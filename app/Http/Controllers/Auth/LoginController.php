<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginCustom(Request $request)
    {
        $request->validate([
        'name'  => 'required|string',
        'email' => 'required|email',
    ]);

    $user = User::where('name', $request->name)
                ->where('email', $request->email)
                ->first();

    if ($user) {
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('admin1.dashboard')->with('success', 'Login berhasil!');
    }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }
}
