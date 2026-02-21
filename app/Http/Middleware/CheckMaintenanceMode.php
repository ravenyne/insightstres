<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if maintenance mode is enabled in system settings
        $maintenanceMode = \App\Models\SystemSetting::where('key', 'maintenance_mode')->value('value');

        if ($maintenanceMode === '1') {
            // ALWAYS Allow access to ANY admin route
            if ($request->is('admin') || $request->is('admin/*')) {
                return $next($request);
            }

            // Also check if user is logged in as admin (double check)
            if (\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
                return $next($request);
            }

            // For everyone else: Show 503 Maintenance Page
            // Check if our custom 503 view exists, otherwise use default
            if (view()->exists('errors.503')) {
                return response()->view('errors.503', [], 503);
            }
            
            abort(503, 'Sistem sedang dalam perbaikan.');
        }

        return $next($request);
    }
}
