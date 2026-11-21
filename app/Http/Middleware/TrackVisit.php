<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    private const BOTS = '/bot|crawl|spider|slurp|facebookexternalhit|whatsapp|telegram|preview|monitor|uptime|curl|wget|python|java\/|httpclient|okhttp|axios|headless|lighthouse|pagespeed|gtmetrix|ahrefs|semrush|bingpreview|mediapartners/i';

    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    /** Dicatat setelah halaman terkirim, jadi tidak memperlambat pengunjung. */
    public function terminate(Request $request, Response $response): void
    {
        try {
            if (! $this->shouldTrack($request, $response)) {
                return;
            }

            $agent = (string) $request->userAgent();
            $today = now()->toDateString();

            PageView::create([
                'visited_on' => $today,
                'path'       => '/' . trim($request->path(), '/'),
                'ip_hash'    => hash('sha256', $request->ip() . '|' . $agent . '|' . $today . '|' . config('app.key')),
                'device'     => $this->device($agent),
                'referrer'   => $this->referrer($request),
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Gagal mencatat tidak boleh mengganggu pengunjung.
        }
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET') || $response->getStatusCode() !== 200) {
            return false;
        }

        if ($request->ajax() || $request->expectsJson() || $request->header('Purpose') === 'prefetch') {
            return false;
        }

        // Kunjungan ayah atau admin yang sedang login tidak dihitung.
        if (Auth::check()) {
            return false;
        }

        if (str_starts_with((string) $request->route()?->getName(), 'filament.')) {
            return false;
        }

        if (! str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            return false;
        }

        $agent = (string) $request->userAgent();

        return $agent !== '' && ! preg_match(self::BOTS, $agent);
    }

    private function device(string $agent): string
    {
        if (preg_match('/ipad|tablet/i', $agent)) {
            return 'tablet';
        }

        return preg_match('/mobile|android|iphone|ipod/i', $agent) ? 'mobile' : 'desktop';
    }

    private function referrer(Request $request): ?string
    {
        $ref = $request->headers->get('referer');
        if (! $ref) {
            return null;
        }

        $host = parse_url($ref, PHP_URL_HOST);
        if (! $host) {
            return null;
        }

        $host = preg_replace('/^www\./', '', strtolower($host));
        $own  = preg_replace('/^www\./', '', strtolower($request->getHost()));

        return $host === $own ? 'internal' : substr($host, 0, 100);
    }
}
