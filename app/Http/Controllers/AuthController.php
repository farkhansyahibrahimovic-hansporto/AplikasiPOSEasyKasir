<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Set last activity time and timeout
            $request->session()->put('last_activity', now());
            $timeout = (Auth::user()->role === 'administrator') ? 1800 : 900; // 30 mins for admin, 15 mins for petugas
            $request->session()->put('session_timeout', $timeout);

            // Redirect based on role
            $user = Auth::user();
            if ($user->role === 'administrator') {
                return redirect()->route('dashboard.admin');
            } elseif ($user->role === 'petugas') {
                return redirect()->route('dashboard.petugas');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    
    // Check session timeout
    protected function checkSessionTimeout(Request $request)
    {
        if (!Auth::check()) {
            return false;
        }

        $lastActivity = $request->session()->get('last_activity');
        $timeout = $request->session()->get('session_timeout', 900);

        if ($lastActivity && (now()->diffInSeconds($lastActivity) > $timeout)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'Sesi telah berakhir karena tidak ada aktivitas.');
        }

        $request->session()->put('last_activity', now());
        return true;
    }
    
    // Dashboard redirection
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $user = Auth::user();
        
        if ($user->role === 'administrator') {
            return redirect()->route('dashboard.admin');
        } elseif ($user->role === 'petugas') {
            return redirect()->route('dashboard.petugas');
        }
        
        return redirect('/login')->with('error', 'Akses tidak valid.');
    }
    
    // Admin dashboard
    public function dashboardAdmin(Request $request)
    {
        // Check session timeout
        $timeoutCheck = $this->checkSessionTimeout($request);
        if ($timeoutCheck !== true) {
            return $timeoutCheck;
        }

        $user = Auth::user();
        
        if ($user->role !== 'administrator') {
            if ($user->role === 'petugas') {
                return redirect()->route('dashboard.petugas');
            }
            return redirect('/login')->with('error', 'Anda tidak memiliki akses administrator.');
        }
        
        return view('dashboard.dashboardadmin');
    }
    
    // Petugas dashboard
    public function dashboardPetugas(Request $request)
    {
        // Check session timeout
        $timeoutCheck = $this->checkSessionTimeout($request);
        if ($timeoutCheck !== true) {
            return $timeoutCheck;
        }

        $user = Auth::user();
        
        if ($user->role !== 'petugas') {
            if ($user->role === 'administrator') {
                return redirect()->route('dashboard.admin');
            }
            return redirect('/login')->with('error', 'Anda tidak memiliki akses petugas.');
        }
        
        return view('dashboard.dashboardpetugas');
    }

    // Profile view (simplified)
    public function profile(Request $request)
    {
        // Check session timeout
        $timeoutCheck = $this->checkSessionTimeout($request);
        if ($timeoutCheck !== true) {
            return $timeoutCheck;
        }

        $user = Auth::user();
        
        return view('profile.index', compact('user'));
    }
}