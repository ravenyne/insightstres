<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah admin sudah login (Auth guard)
        if (!\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Prevent browser caching
        $response = $next($request);
        
        // Don't add cache headers to file downloads
        if ($response instanceof BinaryFileResponse) {
            return $response;
        }
        
        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                       ->header('Pragma', 'no-cache')
                       ->header('Expires', '0');
    }
}
