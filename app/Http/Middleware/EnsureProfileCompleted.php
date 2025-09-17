<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    /**
     * Ensure approved users complete their profile before accessing restricted areas.
     * Allowed paths: /karyawan/profile and POST /karyawan/complete-registration
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        if ($user->role !== 'karyawan') {
            return $next($request);
        }

        // Enforce completion for non-active users
        $karyawan = $user->karyawan;
        $isComplete = $karyawan && ($karyawan->status_kelengkapan === 'lengkap' || $user->status === 'active');

        $path = trim($request->path(), '/');
        $isProfileView = $path === 'karyawan/profile' && $request->isMethod('get');
        $isProfileUpdate = $path === 'karyawan/profile' && in_array($request->method(), ['POST','PATCH']);
        $isCompleteRegistration = $path === 'karyawan/complete-registration' && $request->isMethod('post');

        if (!$isComplete && !($isProfileView || $isProfileUpdate || $isCompleteRegistration)) {
            return redirect()->route('karyawan.profile')->with('warning', 'Lengkapi profil Anda sebelum mengakses fitur lainnya.');
        }

        return $next($request);
    }
}
