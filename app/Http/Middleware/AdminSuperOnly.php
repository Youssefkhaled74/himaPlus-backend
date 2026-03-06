<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminSuperOnly
{
    public function handle(Request $request, Closure $next)
    {
        $admin = auth()->guard('admin')->user();
        if (!$admin) {
            flash()->error("FORBIDDEN , Please Contact Technical Support");
            return redirect(route('admin/login'));
        }

        $allowedIds = config('auth.admin_super_ids', [1]);
        if (!in_array((int) $admin->id, $allowedIds, true)) {
            flash()->error("FORBIDDEN , Super Admin Access Required");
            return redirect(route('admin/index'));
        }

        return $next($request);
    }
}

