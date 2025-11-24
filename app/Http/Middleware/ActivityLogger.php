<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityLogger
{
    /**
     * Log non-read actions from admin/staf using spatie/laravel-activitylog.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!config('activitylog.enabled')) {
            return $response;
        }

        $user = $request->user();
        $routeName = optional($request->route())->getName();

        if (!$user || !$user->hasAnyRole(['admin', 'staf'])) {
            return $response;
        }

        if ($routeName && Str::startsWith($routeName, 'sirekap.logs.')) {
            return $response;
        }

        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            return $response;
        }

        $properties = [
            'method' => $request->method(),
            'status' => method_exists($response, 'getStatusCode') ? $response->getStatusCode() : null,
            'path' => $request->path(),
            'route' => optional($request->route())->getName(),
            'full_url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 255, '...'),
            'roles' => $user->getRoleNames(),
            'payload' => $this->filteredPayload($request),
        ];

        $routeLabel = $properties['route'] ?: $properties['path'];
        $description = sprintf(
            '%s melakukan %s pada %s',
            $user->name,
            strtoupper($properties['method']),
            $routeLabel
        );

        activity('activity')
            ->causedBy($user)
            ->event(strtolower($properties['method']))
            ->withProperties($properties)
            ->log($description);

        return $response;
    }

    private function filteredPayload(Request $request): array
    {
        $input = $request->except([
            '_token',
            '_method',
            'password',
            'password_confirmation',
            'current_password',
            'file',
            'attachment',
        ]);

        return collect($input)
            ->map(function ($value) {
                if ($value instanceof \Illuminate\Http\UploadedFile) {
                    return 'uploaded_file:' . $value->getClientOriginalName();
                }

                if (is_array($value)) {
                    return $value;
                }

                return Str::limit((string) $value, 500, '...');
            })
            ->filter(function ($value) {
                if (is_array($value)) {
                    return !empty($value);
                }

                return $value !== '';
            })
            ->all();
    }
}
