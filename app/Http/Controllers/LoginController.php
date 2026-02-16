<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Models\MonitoringLog;

class LoginController extends Controller
{
    /**
     * Show login form (User/Guest)
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Show admin login form
     */
    public function showAdminLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Handle login validation
     */
    public function login(Request $request)
    {
        // Determine input name (login or email)
        $inputName = $request->has('login') ? 'login' : 'email';

        // Validasi input
        $request->validate([
            $inputName => 'required|string',
            'password' => 'required|string',
        ], [
            "$inputName.required" => 'Email atau Username harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $inputValue = $request->input($inputName);
        $loginType = filter_var($inputValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Cari user berdasarkan email atau username
        $user = User::where($loginType, $inputValue)->first();

        // Validasi user dan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withInput($request->only($inputName))
                ->withErrors([$inputName => 'Email/Username atau password salah']);
        }

        // Simpan ke session
        session()->put('user_id', $user->id_user);
        session()->put('user_name', $user->nama);
        session()->put('user_role', $user->role);
        session()->put('user_authenticated', true);

        // Record Monitoring Log
        MonitoringLog::create([
            'user_id' => $user->id_user,
            'activity_type' => 'login',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Jika login dari halaman admin atau role admin, set session admin juga
        $allowedRoles = ['admin', 'opdusun', 'opdesa', 'timverif', 'penyusunrkp', 'bpd', 'bendahara'];
        
        if (in_array(strtolower($user->role), $allowedRoles)) { 
            session()->put('admin_authenticated', true);
            return redirect()->route('admin.dashboard');
        }

        return redirect('/dashboard');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request) // Request needed for IP/UserAgent if we want to log it
    {
        // Record Monitoring Log before formatting session
        if (session('user_id')) {
            MonitoringLog::create([
                'user_id' => session('user_id'),
                'activity_type' => 'logout',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        session()->forget('user_id');
        session()->forget('user_name');
        session()->forget('user_role');
        session()->forget('user_authenticated');
        session()->forget('admin_authenticated');
        session()->flush();
        session()->invalidate();
        session()->regenerateToken();

        // Redirect ke login admin jika sebelumnya di halaman admin (bisa dicek dari previous url atau default to login)
        return redirect()->route('admin.login')->with('success', 'Anda telah logout');
    }
}
