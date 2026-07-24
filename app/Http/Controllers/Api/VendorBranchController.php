<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VendorBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorBranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * List all branches for the authenticated vendor.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        if ((int) $user->user_type !== 2) {
            return responseJson(403, __('messages.unauthorized'));
        }

        $query = VendorBranch::where('user_id', $user->id)->withTrashed();

        if ($request->has('active_only') && $request->boolean('active_only')) {
            $query->where('is_active', 1)->whereNull('deleted_at');
        }

        $branches = $query->latest()->get()->map(fn (VendorBranch $b) => [
            'id' => $b->id,
            'name' => $b->name,
            'name_ar' => $b->name_ar,
            'display_name' => $b->display_name,
            'address' => $b->address,
            'city' => $b->city,
            'region' => $b->region,
            'postal_code' => $b->postal_code,
            'phone' => $b->phone,
            'email' => $b->email,
            'latitude' => $b->latitude,
            'longitude' => $b->longitude,
            'is_active' => $b->is_active,
            'is_default' => $b->is_default,
            'notes' => $b->notes,
            'deleted_at' => $b->deleted_at?->toDateTimeString(),
            'created_at' => $b->created_at?->toDateTimeString(),
            'updated_at' => $b->updated_at?->toDateTimeString(),
        ]);

        return responseJson(200, __('messages.success'), $branches);
    }

    /**
     * Show a single branch.
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        if ((int) $user->user_type !== 2) {
            return responseJson(403, __('messages.unauthorized'));
        }

        $branch = VendorBranch::where('user_id', $user->id)->withTrashed()->find($id);

        if (!$branch) {
            return responseJson(404, __('messages.not_found', ['item' => 'Branch']));
        }

        return responseJson(200, __('messages.success'), [
            'id' => $branch->id,
            'name' => $branch->name,
            'name_ar' => $branch->name_ar,
            'display_name' => $branch->display_name,
            'address' => $branch->address,
            'city' => $branch->city,
            'region' => $branch->region,
            'postal_code' => $branch->postal_code,
            'phone' => $branch->phone,
            'email' => $branch->email,
            'latitude' => $branch->latitude,
            'longitude' => $branch->longitude,
            'is_active' => $branch->is_active,
            'is_default' => $branch->is_default,
            'notes' => $branch->notes,
            'deleted_at' => $branch->deleted_at?->toDateTimeString(),
            'created_at' => $branch->created_at?->toDateTimeString(),
            'updated_at' => $branch->updated_at?->toDateTimeString(),
        ]);
    }

    /**
     * Create a new branch.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        if ((int) $user->user_type !== 2) {
            return responseJson(403, __('messages.unauthorized'));
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'name_ar'     => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:500',
            'city'        => 'nullable|string|max:255',
            'region'      => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone'       => 'nullable|string|max:50',
            'email'       => 'nullable|email|max:255',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',
            'is_active'   => 'nullable|in:0,1',
            'is_default'  => 'nullable|in:0,1',
            'notes'       => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        $branch = VendorBranch::create([
            'user_id'     => $user->id,
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

        return responseJson(201, __('vendor_branches.branch_created'), [
            'id' => $branch->id,
            'name' => $branch->name,
            'name_ar' => $branch->name_ar,
            'display_name' => $branch->display_name,
            'address' => $branch->address,
            'city' => $branch->city,
            'region' => $branch->region,
            'postal_code' => $branch->postal_code,
            'phone' => $branch->phone,
            'email' => $branch->email,
            'latitude' => $branch->latitude,
            'longitude' => $branch->longitude,
            'is_active' => $branch->is_active,
            'is_default' => $branch->is_default,
            'notes' => $branch->notes,
            'created_at' => $branch->created_at?->toDateTimeString(),
        ]);
    }

    /**
     * Update an existing branch.
     */
    public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        if ((int) $user->user_type !== 2) {
            return responseJson(403, __('messages.unauthorized'));
        }

        $branch = VendorBranch::where('user_id', $user->id)->find($id);

        if (!$branch) {
            return responseJson(404, __('messages.not_found', ['item' => 'Branch']));
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'name_ar'     => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:500',
            'city'        => 'nullable|string|max:255',
            'region'      => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone'       => 'nullable|string|max:50',
            'email'       => 'nullable|email|max:255',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',
            'is_active'   => 'nullable|in:0,1',
            'is_default'  => 'nullable|in:0,1',
            'notes'       => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        $branch->update($request->only([
            'name', 'name_ar', 'address', 'city', 'region', 'postal_code',
            'phone', 'email', 'latitude', 'longitude', 'is_active', 'is_default', 'notes',
        ]));

        if ($request->input('is_default', 0)) {
            $branch->setAsDefault();
        }

        return responseJson(200, __('vendor_branches.branch_updated'), [
            'id' => $branch->id,
            'name' => $branch->name,
            'name_ar' => $branch->name_ar,
            'display_name' => $branch->display_name,
            'address' => $branch->address,
            'city' => $branch->city,
            'region' => $branch->region,
            'postal_code' => $branch->postal_code,
            'phone' => $branch->phone,
            'email' => $branch->email,
            'latitude' => $branch->latitude,
            'longitude' => $branch->longitude,
            'is_active' => $branch->is_active,
            'is_default' => $branch->is_default,
            'notes' => $branch->notes,
            'updated_at' => $branch->updated_at?->toDateTimeString(),
        ]);
    }

    /**
     * Delete a branch (soft delete).
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        if ((int) $user->user_type !== 2) {
            return responseJson(403, __('messages.unauthorized'));
        }

        $branch = VendorBranch::where('user_id', $user->id)->find($id);

        if (!$branch) {
            return responseJson(404, __('messages.not_found', ['item' => 'Branch']));
        }

        $branch->delete();

        return responseJson(200, __('vendor_branches.branch_deleted'));
    }

    /**
     * Restore a soft-deleted branch.
     */
    public function restore(int $id): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        if ((int) $user->user_type !== 2) {
            return responseJson(403, __('messages.unauthorized'));
        }

        $branch = VendorBranch::where('user_id', $user->id)->onlyTrashed()->find($id);

        if (!$branch) {
            return responseJson(404, __('messages.not_found', ['item' => 'Branch']));
        }

        $branch->restore();

        return responseJson(200, __('vendor_branches.branch_restored'), [
            'id' => $branch->id,
            'name' => $branch->name,
            'display_name' => $branch->display_name,
        ]);
    }

    /**
     * Toggle branch active status.
     */
    public function toggle(int $id): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        if ((int) $user->user_type !== 2) {
            return responseJson(403, __('messages.unauthorized'));
        }

        $branch = VendorBranch::where('user_id', $user->id)->find($id);

        if (!$branch) {
            return responseJson(404, __('messages.not_found', ['item' => 'Branch']));
        }

        $branch->update(['is_active' => !$branch->is_active]);

        return responseJson(200, $branch->is_active
            ? __('vendor_branches.branch_activated')
            : __('vendor_branches.branch_deactivated'),
            ['id' => $branch->id, 'is_active' => $branch->is_active]
        );
    }

    /**
     * Public endpoint: list active branches for a specific vendor (for customer use).
     */
    public function publicVendorBranches(int $vendorId): \Illuminate\Http\JsonResponse
    {
        $branches = VendorBranch::where('user_id', $vendorId)
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->latest()
            ->get()
            ->map(fn (VendorBranch $b) => [
                'id' => $b->id,
                'name' => $b->name,
                'name_ar' => $b->name_ar,
                'display_name' => $b->display_name,
                'address' => $b->address,
                'city' => $b->city,
                'region' => $b->region,
                'postal_code' => $b->postal_code,
                'phone' => $b->phone,
                'latitude' => $b->latitude,
                'longitude' => $b->longitude,
                'is_default' => $b->is_default,
            ]);

        return responseJson(200, __('messages.success'), $branches);
    }
}
