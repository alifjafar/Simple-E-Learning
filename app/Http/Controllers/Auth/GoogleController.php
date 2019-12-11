<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToProvider()
    {

        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $providerUser = collect(Socialite::driver('google')->user());
            $user = User::whereEmail($providerUser['email'])->first();

        } catch (\Exception $e) {
            return redirect(route('register'));
        }

        if ($user) {
            Auth::login($user);

            return redirect()->route('dashboard');
        } else {
            return redirect()->route('register')->with(['status' => 'Akun Belum Teregistrasi']);
        }
    }
}
