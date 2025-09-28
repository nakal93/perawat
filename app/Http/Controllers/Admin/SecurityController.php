<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request as FacadeRequest;

class SecurityController extends Controller
{
    /**
     * Display activity logs
     */
    public function activity(Request $request)
    {
        $event = $request->query('event');
        $date = $request->query('date'); // optional YYYY-MM-DD
        $window = $request->query('window', '6h'); // configurable window for security summary (default 6h)

        $query = Activity::with('causer')->latest();
        if ($event && in_array($event, ['login','logout','login_failed','login_lockout','bruteforce_warning','created','updated','deleted'])) {
            $query->where('event', $event);
        }
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        $activities = $query->paginate(25)->appends($request->query());

        // Parse window into a Carbon interval
        $now = now();
        $since = (function ($w) use ($now) {
            $w = strtolower(trim($w));
            if (str_ends_with($w, 'h')) {
                $n = (int) rtrim($w, 'h');
                return $now->copy()->subHours(max($n, 1));
            }
            if (str_ends_with($w, 'd')) {
                $n = (int) rtrim($w, 'd');
                return $now->copy()->subDays(max($n, 1));
            }
            // fallback default 6 hours
            return $now->copy()->subHours(6);
        })($window);

        // Summary cards within selected window
        $summary = [
            'failed' => Activity::where('event', 'login_failed')->where('created_at', '>=', $since)->count(),
            'lockout' => Activity::where('event', 'login_lockout')->where('created_at', '>=', $since)->count(),
            'bruteforce' => Activity::where('event', 'bruteforce_warning')->where('created_at', '>=', $since)->count(),
        ];

        // Last seen timestamps (overall and within window)
        $lastOverall = [
            'failed' => Activity::where('event', 'login_failed')->latest('created_at')->value('created_at'),
            'lockout' => Activity::where('event', 'login_lockout')->latest('created_at')->value('created_at'),
            'bruteforce' => Activity::where('event', 'bruteforce_warning')->latest('created_at')->value('created_at'),
        ];
        $lastInWindow = [
            'failed' => Activity::where('event', 'login_failed')->where('created_at', '>=', $since)->latest('created_at')->value('created_at'),
            'lockout' => Activity::where('event', 'login_lockout')->where('created_at', '>=', $since)->latest('created_at')->value('created_at'),
            'bruteforce' => Activity::where('event', 'bruteforce_warning')->where('created_at', '>=', $since)->latest('created_at')->value('created_at'),
        ];

        // Distinct event options for filter
        $events = Activity::select('event')->distinct()->pluck('event')->filter()->values();

        // Event descriptions for tooltips
        $eventDescriptions = [
            'login' => 'User logged in successfully',
            'logout' => 'User logged out of the system',
            'login_failed' => 'Failed login attempt with provided email from a specific IP',
            'login_lockout' => 'Temporary lockout due to too many failed login attempts',
            'bruteforce_warning' => 'Multiple rapid failed attempts detected (possible brute-force attack)',
            'created' => 'A record was created',
            'updated' => 'A record was updated',
            'deleted' => 'A record was deleted',
        ];

        $windowLabel = (function ($w) {
            $w = strtolower(trim($w));
            if (str_ends_with($w, 'h')) {
                $n = (int) rtrim($w, 'h');
                return $n . ' hour' . ($n > 1 ? 's' : '');
            }
            if (str_ends_with($w, 'd')) {
                $n = (int) rtrim($w, 'd');
                return $n . ' day' . ($n > 1 ? 's' : '');
            }
            return '6 hours';
        })($window);

        $summaryMeta = [
            'window' => $window,
            'windowLabel' => $windowLabel,
            'since' => $since,
            'last' => $lastOverall,
            'last_in_window' => $lastInWindow,
            'eventDescriptions' => $eventDescriptions,
        ];

        return view('admin.security.activity', compact('activities','summary','events','event','date','summaryMeta'));
    }

    /**
     * Check brute-force detection status for a given email and current IP.
     */
    public function checkBruteforce(Request $request)
    {
        $email = strtolower((string) $request->query('email'));
        if (!$email) {
            return response()->json(['ok' => false, 'error' => 'email query is required'], 422);
        }
        $ip = FacadeRequest::ip();
        $key = sprintf('login:fail:%s:%s', $ip, $email);
        $startKey = sprintf('login:fail:start:%s:%s', $ip, $email);
        $count = (int) (Cache::get($key) ?? 0);
        $threshold = (int) config('app.login_attempts', 5);
        $start = Cache::get($startKey);
        $windowMinutes = 15;
        $expiresAt = null;
        if ($count > 0) {
            // Attempt to estimate remaining TTL
            $expiresAt = $start ? Carbon::parse($start)->addMinutes($windowMinutes) : null;
        }
        return response()->json([
            'ok' => true,
            'ip' => $ip,
            'email' => $email,
            'fail_count' => $count,
            'threshold' => max(3, $threshold),
            'window_minutes' => $windowMinutes,
            'bruteforce_detected' => $count >= max(3, $threshold),
            'window_started_at' => $start ? Carbon::parse($start)->toDateTimeString() : null,
            'window_expires_at' => $expiresAt ? $expiresAt->toDateTimeString() : null,
        ]);
    }
}