<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $validated['email'])->orWhere('username', $validated['email'])->first();

        abort_unless($user && Hash::check($validated['password'], $user['password']), 422, __('Incorrect Email/Username or Passsword'));

        $token = hash('sha256', Str::random(60));
        $user->forceFill([
            'api_token' => $token
        ])->save();

        return response()->json([
            'status' => 'success',
            'data' => [
                'token' => $token
            ]
        ]);
    }
}
