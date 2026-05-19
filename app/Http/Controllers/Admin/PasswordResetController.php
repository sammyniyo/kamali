<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    public function request()
    {
        return view('admin.password.request');
    }

    public function email(Request $request)
    {
        $request->merge([
            'email' => Str::lower((string) $request->input('email', '')),
        ]);

        $data = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                Rule::exists('users', 'email'),
            ],
        ], [
            'email.exists' => 'We could not find an account with that email address.',
        ]);

        $status = Password::sendResetLink(['email' => $data['email']]);

        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        return back()->with('status', __($status));
    }

    public function reset(Request $request, string $token)
    {
        return view('admin.password.reset', [
            'token' => $token,
            'email' => (string) $request->query('email', ''),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'token' => $data['token'],
            ],
            function ($user) use ($data) {
                $user->password = Hash::make($data['password']);
                $user->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        return redirect()->route('admin.login')->with('status', 'Password reset. You can sign in now.');
    }
}

