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

        $user = User::whereEmail($validated['email'])->orWhereUsername($validated['email'])->first();

        abort_unless($user && Hash::check($validated['password'], $user['password']), 422, __('Incorrect Email/Username or Passsword'));

        $user = $user->update([
            'api_token' => hash('sha256', Str::random(60))
        ]);

        return [
            'status' => 'success',
            'data' => [
                'token' => $user['api_token']
            ]
        ];
    }
}
