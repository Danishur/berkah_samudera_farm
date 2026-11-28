<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menampilkan halaman "sedang dalam perawatan" kepada pengunjung selama mode perawatan menyala.
 * Admin yang sedang login tetap bisa melihat web seperti biasa, dan /admin tidak terpengaruh.
 */
class SiteMaintenance
{
    public function handle(Request $request, Closure $next): Response
    {
        // Saat pengembangan di komputer sendiri, web tetap terbuka.
        if (app()->environment('local') || ! config('site.maintenance', true)) {
            return $next($request);
        }

        if (Auth::check()) {
            return $next($request);
        }

        return response()
            ->view('maintenance', [
                'message' => config('site.maintenance_message'),
                'eta'     => config('site.maintenance_eta'),
            ], 503)
            ->header('Retry-After', '3600')
            ->header('Cache-Control', 'no-store, max-age=0');
    }
}
