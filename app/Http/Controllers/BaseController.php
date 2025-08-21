<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Check if the current user has any of the allowed roles
     *
     * @param array $allowedRoles
     * @return bool
     */
    protected function checkRole($allowedRoles = [])
    {
        $user = Auth::user();

        // If no specific roles required, just check if user is authenticated
        if (empty($allowedRoles)) {
            return $user !== null;
        }

        // Check if user has any of the allowed roles
        return $user && in_array($user->role, $allowedRoles);
    }

    /**
     * Check session timeout and validate access
     *
     * @param Request $request
     * @param array $allowedRoles
     * @return \Illuminate\Http\RedirectResponse|bool
     */
    protected function validateAccess(Request $request, $allowedRoles = [])
    {
        $sessionCheck = $this->checkSessionTimeout($request);
        if ($sessionCheck !== true) {
            return $sessionCheck;
        }

        if (!$this->checkRole($allowedRoles)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return true;
    }

    /**
     * Check if session has timed out
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|bool
     */
    protected function checkSessionTimeout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $lastActivity = $request->session()->get('last_activity');
        $timeout = $request->session()->get('session_timeout', 900); // Default 15 minutes

        if ($lastActivity && (Carbon::now()->diffInSeconds($lastActivity) > $timeout)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'Sesi telah berakhir karena tidak ada aktivitas.');
        }

        $request->session()->put('last_activity', Carbon::now());
        return true;
    }
}