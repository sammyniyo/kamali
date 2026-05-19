<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\DailyVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TrackVisits
{
    /**
     * Decide whether this request should be counted, then defer the
     * database work to terminate() so it never blocks the response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (! $this->shouldTrack($request, $response)) {
            return;
        }

        try {
            $today = now()->toDateString();

            // firstOrCreate only sets defaults when the row is created — never resets counters on update.
            DailyVisit::query()->firstOrCreate(
                ['date' => $today],
                ['visits' => 0, 'unique_visitors' => 0]
            );

            DailyVisit::query()
                ->where('date', $today)
                ->increment('visits');

            // Dedupe unique visitors without touching the session (avoids an extra session write per visitor/day).
            $visitorKey = 'track_visits:uv:'.hash_hmac('sha256', $request->ip().'|'.$today, (string) config('app.key'));
            if (Cache::add($visitorKey, 1, now()->endOfDay())) {
                DailyVisit::query()
                    ->where('date', $today)
                    ->increment('unique_visitors');
            }
        } catch (Throwable $e) {
            // Never let analytics writes affect the user experience.
            Log::warning('TrackVisits failed: '.$e->getMessage());
        }
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }
        if ($response->getStatusCode() >= 400) {
            return false;
        }
        if ($request->expectsJson()) {
            return false;
        }
        if ($request->is('admin/*')) {
            return false;
        }
        if ($request->is('up')) {
            return false;
        }
        if (Str::startsWith($request->path(), ['build/', 'storage/', 'images/'])) {
            return false;
        }
        // Don't count obvious bot user agents (cheap heuristic).
        $ua = (string) $request->userAgent();
        if ($ua === '' || preg_match('/bot|crawler|spider|http[-_]?client|curl|wget/i', $ua)) {
            return false;
        }

        return true;
    }
}
