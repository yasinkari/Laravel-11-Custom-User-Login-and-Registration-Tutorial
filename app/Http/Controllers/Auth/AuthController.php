<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('auth.login');
    }

    public function registration(): View
    {
        return view('auth.registration');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            if (Auth::user()->user_role === 'admin') {
                return redirect()->route('admin.dashboard')->withSuccess('Welcome, Admin!');
            } else {
                return redirect()->intended('dashboard')->withSuccess('You have successfully logged in.');
            }
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect("login")->withErrors(['email' => 'User not found.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect("login")->withErrors(['password' => 'Password is incorrect.']);
        }

        return redirect("login")->withErrors(['email' => 'Invalid credentials.']);
    }

    public function postRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'user_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'user_phone' => 'required',
            'user_address' => 'required',
        ]);

        $data = $request->all();
        $user = $this->create($data);
        Auth::login($user);

        return redirect("login")->withSuccess('Registration successful! Please log in.');
    }

    public function create(array $data)
    {
        return User::create([
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_phone' => $data['user_phone'],
            'user_address' => $data['user_address'],
            'user_role' => 'user'
        ]);
    }

    /**
     * Logout User
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }

    /**
     * Show Forgot Password Form
     */
    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot_password');
    }

    /**
     * Handle Forgot Password Submission
     */
    public function handleForgotPassword(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show Reset Password Form
     */
    public function showResetPasswordForm(Request $request): View
    {
        $token = $request->route('token');

        return view('auth.change_password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle Reset Password Submission
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Your password has been reset successfully!')
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show Change Password Form
     */
    public function showChangePasswordForm(): View
    {
        return view('auth.change_password');
    }

    /**
     * Handle Change Password Submission
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );
    
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Your password has been reset successfully.')
                        : back()->withErrors(['email' => __($status)]);}

    public function showAdminLoginForm(): View
    {
        return view('auth.Admin.adminLogin');
    }

    public function adminLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt(array_merge($credentials, ['user_role' => 'admin']))) {
            return redirect()->intended('/admin/dashboard')->withSuccess('Welcome, Admin!');
        }

        return back()->withErrors(['email' => 'Invalid admin credentials.']);
    }

    public function registerAdmin(Request $request): RedirectResponse
    {
        $request->validate([
            'user_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'user_phone' => 'required',
            'user_address' => 'required',
        ]);

        User::create([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_phone' => $request->user_phone,
            'user_address' => $request->user_address,
            'user_role' => 'admin'
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Admin account created successfully!');
    }
}
    

