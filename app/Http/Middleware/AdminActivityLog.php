<?php

namespace App\Http\Middleware;

use App\Models\AdminActivityLog as AdminActivityLogModel;
use Closure;
use Illuminate\Http\Request;

class AdminActivityLog
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $admin = auth()->guard('admin')->user();
        if (!$admin) {
            return $response;
        }

        if (in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'], true)) {
            return $response;
        }

        $excluded = ['_token', 'password', 'password_confirmation', 'old_password', 'remember_token'];

        // Use input() instead of all()/except() to avoid touching uploaded-file
        // temp paths that may already have been moved/deleted by the controller.
        $raw = array_diff_key($request->input() ?? [], array_flip($excluded));

        $payload = $this->sanitizePayload($raw);

        AdminActivityLogModel::create([
            'admin_id' => $admin->id,
            'method' => $request->method(),
            'route_name' => $request->route()?->getName(),
            'path' => $request->path(),
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            'payload' => $payload,
            'response_status' => $response->getStatusCode(),
        ]);

        return $response;
    }

    private function sanitizePayload(array $payload): array
    {
        foreach ($payload as $key => $value) {
            if (is_array($value)) {
                $payload[$key] = $this->sanitizePayload($value);
                continue;
            }

            if (is_scalar($value) || $value === null) {
                continue;
            }

            $payload[$key] = is_object($value) ? get_class($value) : (string) $value;
        }

        return $payload;
    }
}
