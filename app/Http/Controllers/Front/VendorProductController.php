<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VendorProductController extends Controller
{
    /**
     * Display list of vendor's products
     */
    public function index(Request $request)
    {
        $vendor = auth()->user();
        $search = $request->get('search', '');
        $status = $request->get('status', '');
        
        $query = Product::where('provider_id', $vendor->id)
            ->where('deleted_at', null);
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        if ($status === 'active') {
            $query->where('is_activate', 1);
        } elseif ($status === 'inactive') {
            $query->where('is_activate', 0);
        }
        
        $products = $query->with('category')
            ->withAvg('ratings', 'rating')
            ->latest()
            ->paginate(15);
        
        return view('front.vendor.products.index', compact('products', 'search', 'status'));
    }

    /**
     * Show product creation form
     */
    public function create()
    {
        $categories = Category::where('deleted_at', null)->get();
        return view('front.vendor.products.create', compact('categories'));
    }

    /**
     * Store new product
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // New specification fields
            'imaging_type' => 'nullable|string|max:255',
            'mfg_date' => 'nullable|date',
            'exp_date' => 'nullable|date|after_or_equal:mfg_date',
            'weight' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            $product = Product::create([
                'name' => $request->name,
                'desc' => $request->description,
                'category_id' => $request->category_id,
                'brand' => $request->brand,
                'price' => $request->price,
                'stock_quantity' => $request->quantity,
                'provider_id' => auth()->id(),
                'is_activate' => 1,
                // Add specification fields
                'imaging_type' => $request->imaging_type,
                'manufacture_date' => $request->mfg_date,
                'expiry_date' => $request->exp_date,
                'weight' => $request->weight,
                'dimensions' => $request->dimensions,
                'warranty' => $request->warranty,
            ]);
            
            // Handle image uploads
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $imagePaths[] = $path;  // Store without 'storage/' prefix
                    // Save the first image as the main image
                    if (!$product->img) {
                        $product->img = $path;  // Store without 'storage/' prefix
                    }
                }
                if (!empty($imagePaths)) {
                    $clean = $this->sanitizeImagePaths($imagePaths);
                    // Ensure JSON fits in column (1255 chars)
                    $json = json_encode($clean);
                    $max = 1255;
                    while (strlen($json) > $max && count($clean) > 1) {
                        array_pop($clean);
                        $json = json_encode($clean);
                    }
                    if (strlen($json) > $max) {
                        // If still too long, only keep first element
                        $clean = array_slice($clean, 0, 1);
                        $json = json_encode($clean);
                    }
                    $product->imgs = $json;
                    $product->img = $clean[0] ?? $product->img;
                    $product->save();
                }
            }
            
            DB::commit();
            flash()->success('تم إضافة المنتج بنجاح');
            return redirect()->route('vendor/products');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Product creation error: ' . $e->getMessage(), ['exception' => $e]);
            flash()->error('حدث خطأ أثناء إضافة المنتج: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Show product edit form
     */
    public function edit($id)
    {
        $vendor = auth()->user();
        $product = Product::where('id', $id)
            ->where('provider_id', $vendor->id)
            ->firstOrFail();
        
        $categories = Category::where('deleted_at', null)->get();
        return view('front.vendor.products.edit', compact('product', 'categories'));
    }

    /**
     * Normalize image paths stored in the `imgs` column.
     * Handles values that may be arrays, JSON strings, or JSON strings encoded multiple times.
     * Returns a clean array of paths.
     */
    private function normalizeImagePaths($imgs)
    {
        if (empty($imgs)) return [];

        if (is_array($imgs)) return $imgs;

        $decoded = $imgs;
        // Try repeatedly decoding up to a few layers (defensive)
        for ($i = 0; $i < 5; $i++) {
            if (is_string($decoded)) {
                $try = json_decode($decoded, true);
                if (json_last_error() === JSON_ERROR_NONE && (is_array($try) || is_string($try))) {
                    $decoded = $try;
                    continue;
                }

                // Try stripslashes then decode
                $stripped = stripslashes($decoded);
                $try2 = json_decode($stripped, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $decoded = $try2;
                    continue;
                }

                break;
            }
            break;
        }

        if (is_array($decoded)) return $decoded;

        // As a fallback try to extract product file paths with regex
        preg_match_all('/products\\?\/[^\"\'\[\],\s]+\.(?:png|jpe?g|gif|webp)/i', (string)$imgs, $matches);
        if (!empty($matches[0])) return $matches[0];

        return [];
    }

    /**
     * Sanitize and flatten an array of image values into clean relative paths.
     * Accepts mixed input (strings, escaped strings, nested arrays) and returns
     * an array of plain paths like `products/xxx.png`.
     */
    private function sanitizeImagePaths($values)
    {
        $flatten = [];

        $walk = function ($val) use (&$walk, &$flatten) {
            if (is_array($val)) {
                foreach ($val as $v) $walk($v);
                return;
            }
            if (is_null($val) || $val === '') return;

            // Unescape and strip extra quotes
            $s = is_string($val) ? $val : (string) $val;
            // Remove surrounding quotes
            $s = preg_replace('/^\s*["\']+|["\']+\s*$/', '', $s);
            // Remove excessive backslashes
            $s = stripslashes($s);

            // If the string is a JSON array, decode and walk it
            if (strpos($s, '[') !== false && strpos($s, ']') !== false) {
                $decoded = @json_decode($s, true);
                if (json_last_error() === JSON_ERROR_NONE && $decoded) {
                    $walk($decoded);
                    return;
                }
            }

            // Extract product file paths using regex
            if (preg_match_all('/products\\?\/[A-Za-z0-9_\-\.]+\.(?:png|jpe?g|gif|webp)/i', $s, $m)) {
                foreach ($m[0] as $match) {
                    $flatten[] = str_replace('\\', '/', ltrim($match, '/'));
                }
                return;
            }

            // If looks like a path, keep it
            if (preg_match('/^[A-Za-z0-9_\-\/\.]+\.(?:png|jpe?g|gif|webp)$/i', $s)) {
                // Legacy rows may store only filename (e.g. seed-product-1.jpg).
                // Normalize to products/filename to match storage structure.
                if (!str_contains($s, '/')) {
                    $s = 'products/' . ltrim($s, '/');
                }
                $flatten[] = $s;
            }
        };

        $walk($values);

        // Deduplicate while preserving order
        $result = [];
        foreach ($flatten as $p) {
            if (!in_array($p, $result)) $result[] = $p;
        }
        return $result;
    }

    /**
     * Show product details
     */
    public function show($id)
    {
        $vendor = auth()->user();
        $product = Product::where('id', $id)
            ->where('provider_id', $vendor->id)
            ->with(['category', 'provider', 'ratings' => function($query) {
                $query->where('is_activate', 1)->latest()->limit(5);
            }])
            ->firstOrFail();
        
        // Extract images from JSON column (normalize various encodings)
        $images = $this->normalizeImagePaths($product->imgs);
        
        // Add main image if not already in images array
        if ($product->img && !in_array($product->img, $images)) {
            array_unshift($images, $product->img);
        }
        
        // Calculate average rating and review count
        $avgRating = $product->ratings->avg('rating') ?? 0;
        $reviewsCount = $product->ratings->count();
        
        return view('front.vendor.products.show', compact('product', 'images', 'avgRating', 'reviewsCount'));
    }

    /**
     * Update product
     */
    public function update(Request $request, $id)
    {
        $vendor = auth()->user();
        $product = Product::where('id', $id)
            ->where('provider_id', $vendor->id)
            ->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // New specification fields
            'imaging_type' => 'nullable|string|max:255',
            'mfg_date' => 'nullable|date',
            'exp_date' => 'nullable|date|after_or_equal:mfg_date',
            'weight' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            $product->update([
                'name' => $request->name,
                'desc' => $request->description,
                'category_id' => $request->category_id,
                'brand' => $request->brand,
                'price' => $request->price,
                'stock_quantity' => $request->quantity,
                // Update specification fields
                'imaging_type' => $request->imaging_type,
                'manufacture_date' => $request->mfg_date,
                'expiry_date' => $request->exp_date,
                'weight' => $request->weight,
                'dimensions' => $request->dimensions,
                'warranty' => $request->warranty,
            ]);
            
            // Handle existing + removed + newly uploaded images.
            $imagePaths = $this->normalizeImagePaths($product->imgs);
            if (!empty($product->img) && !in_array($product->img, $imagePaths, true)) {
                array_unshift($imagePaths, $product->img);
            }

            if ($request->filled('removed_images')) {
                $removedIndexes = array_filter(array_map('intval', explode(',', $request->removed_images)), function ($idx) {
                    return $idx >= 0;
                });

                // Remove highest indexes first to avoid shifting.
                rsort($removedIndexes);
                $filesToDelete = [];
                foreach ($removedIndexes as $index) {
                    if (array_key_exists($index, $imagePaths)) {
                        $filesToDelete[] = $imagePaths[$index];
                        unset($imagePaths[$index]);
                    }
                }
                $imagePaths = array_values($imagePaths);

                foreach ($filesToDelete as $file) {
                    $normalized = ltrim((string) $file, '/');
                    Storage::disk('public')->delete($normalized);
                    if (!str_contains($normalized, '/')) {
                        Storage::disk('public')->delete('products/' . $normalized);
                    }
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $imagePaths[] = $path;  // Store without 'storage/' prefix
                }
            }

            $clean = $this->sanitizeImagePaths($imagePaths);
            if (!empty($clean)) {
                $json = json_encode($clean);
                $max = 1255;
                while (strlen($json) > $max && count($clean) > 1) {
                    array_pop($clean);
                    $json = json_encode($clean);
                }
                if (strlen($json) > $max) {
                    $clean = array_slice($clean, 0, 1);
                    $json = json_encode($clean);
                }
                $product->imgs = $json;
                $product->img = $clean[0] ?? null;
            } else {
                $product->imgs = null;
                $product->img = null;
            }
            $product->save();
            
            DB::commit();
            flash()->success('تم تحديث المنتج بنجاح');
            return redirect()->route('vendor/products');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Product update error: ' . $e->getMessage(), ['exception' => $e]);
            flash()->error('حدث خطأ أثناء تحديث المنتج: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Toggle product activation
     */
    public function toggleActivation($id)
    {
        $vendor = auth()->user();
        $product = Product::where('id', $id)
            ->where('provider_id', $vendor->id)
            ->firstOrFail();
        
        $product->update([
            'is_activate' => !$product->is_activate
        ]);
        
        flash()->success($product->is_activate ? 'تم تفعيل المنتج' : 'تم إلغاء تفعيل المنتج');
        return back();
    }

    /**
     * Delete product
     */
    public function destroy($id)
    {
        $vendor = auth()->user();
        $product = Product::where('id', $id)
            ->where('provider_id', $vendor->id)
            ->firstOrFail();
        
        $product->delete();
        
        flash()->success('تم حذف المنتج بنجاح');
        return redirect()->route('vendor/products');
    }
}
