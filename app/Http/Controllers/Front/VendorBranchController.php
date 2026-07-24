<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\VendorBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorBranchController extends Controller
{
    /**
     * List all branches for the authenticated vendor.
     */
    public function index(Request $request)
    {
        $vendor = auth()->user();
        $search = $request->get('search', '');

        $query = VendorBranch::where('user_id', $vendor->id)->withTrashed();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('name_ar', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%");
            });
        }

        $branches = $query->latest()->paginate(15);

        return view('front.vendor.branches.index', compact('branches'));
    }

    /**
     * Show the create branch form.
     */
    public function create()
    {
        return view('front.vendor.branches.create');
    }

    /**
     * Store a new branch.
     */
    public function store(Request $request)
    {
        $vendor = auth()->user();

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'name_ar'   => 'nullable|string|max:255',
            'address'   => 'nullable|string|max:500',
            'city'      => 'nullable|string|max:255',
            'region'    => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone'     => 'nullable|string|max:50',
            'email'     => 'nullable|email|max:255',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'nullable|in:0,1',
            'is_default' => 'nullable|in:0,1',
            'notes'     => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $branch = VendorBranch::create([
            'user_id'     => $vendor->id,
            'name'        => $request->name,
            'name_ar'     => $request->name_ar,
            'address'     => $request->address,
            'city'        => $request->city,
            'region'      => $request->region,
            'postal_code' => $request->postal_code,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'is_active'   => $request->input('is_active', 1),
            'is_default'  => $request->input('is_default', 0),
            'notes'       => $request->notes,
        ]);

        if ($request->input('is_default', 0)) {
            $branch->setAsDefault();
        }

        flash()->success(__('vendor_branches.branch_created'));
        return redirect()->route('vendor/branches');
    }

    /**
     * Show the edit branch form.
     */
    public function edit($id)
    {
        $vendor = auth()->user();
        $branch = VendorBranch::where('user_id', $vendor->id)->findOrFail($id);

        return view('front.vendor.branches.edit', compact('branch'));
    }

    /**
     * Update an existing branch.
     */
    public function update(Request $request, $id)
    {
        $vendor = auth()->user();
        $branch = VendorBranch::where('user_id', $vendor->id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'name_ar'   => 'nullable|string|max:255',
            'address'   => 'nullable|string|max:500',
            'city'      => 'nullable|string|max:255',
            'region'    => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone'     => 'nullable|string|max:50',
            'email'     => 'nullable|email|max:255',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'nullable|in:0,1',
            'is_default' => 'nullable|in:0,1',
            'notes'     => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $branch->update($request->only([
            'name', 'name_ar', 'address', 'city', 'region', 'postal_code',
            'phone', 'email', 'latitude', 'longitude', 'is_active', 'is_default', 'notes',
        ]));

        if ($request->input('is_default', 0)) {
            $branch->setAsDefault();
        }

        flash()->success(__('vendor_branches.branch_updated'));
        return redirect()->route('vendor/branches');
    }

    /**
     * Delete a branch (soft delete).
     */
    public function destroy($id)
    {
        $vendor = auth()->user();
        $branch = VendorBranch::where('user_id', $vendor->id)->findOrFail($id);
        $branch->delete();

        flash()->success(__('vendor_branches.branch_deleted'));
        return redirect()->route('vendor/branches');
    }

    /**
     * Restore a soft-deleted branch.
     */
    public function restore($id)
    {
        $vendor = auth()->user();
        $branch = VendorBranch::where('user_id', $vendor->id)->onlyTrashed()->findOrFail($id);
        $branch->restore();

        flash()->success(__('vendor_branches.branch_restored'));
        return redirect()->route('vendor/branches');
    }

    /**
     * Toggle branch active status.
     */
    public function toggle($id)
    {
        $vendor = auth()->user();
        $branch = VendorBranch::where('user_id', $vendor->id)->findOrFail($id);

        $branch->update(['is_active' => !$branch->is_active]);

        flash()->success(
            $branch->is_active
                ? __('vendor_branches.branch_activated')
                : __('vendor_branches.branch_deactivated')
        );
        return redirect()->route('vendor/branches');
    }
}
