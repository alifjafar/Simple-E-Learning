<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index($username)
    {
        if (Auth::user()->username != $username) {
            return abort('404');
        }
        $user = User::where('username', $username)->first();
        return view('dashboard.profile.profile', compact('user'));
    }

    public function updateProfile(Request $request, User $user)
    {
        $validated = $this->validate($request, [
            'username' => 'required|regex:/^[a-z0-9]+$/|unique:users,username,' . $user->id,
            'email' => 'required|unique:users,email,' . $user->id,
            'name' => 'required|string',
        ]);
        $user->update($validated);
        Session::flash('success', 'Berhasil Memperbaharui Profile');
        return redirect()->route('profile', $user->username);
    }

    public function editPassword($username)
    {
        if (Auth::user()->username != $username) {
            return abort('404');
        }

        $user = User::where('username', $username)->first();
        return view('dashboard.profile.change_password', [
            'user' => $user,
        ]);
    }

    public function updatePassword(UpdatePassword $request, User $user)
    {
        if (Auth::user()->username != $user->username) {
            return abort('404');
        }
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        Session::flash('success', 'Berhasil Memperbaharui Password');
        return redirect()->back();
    }

    public function updateFoto(Request $request, User $user)
    {
        $validated = $this->validate($request, [
            'picture' => 'image|mimes:jpg,png,jpeg,svg|max:5000',
        ]);
        if ($request->hasFile('picture')) {
            $validated['picture'] = $this->uploadFoto($request->file('picture'));
            if ($user->picture) {
                //Delete Avatar
                $avaExists = $user->picture;
                Storage::disk('public')->delete($avaExists);
                $avaExists->delete();
            }
        }
        $user->update([
            'picture' => $validated['picture'] ?? $user->picture
        ]);
        return redirect()->back()->with(['success' => 'Berhasil Mengubah Foto Profile']);
    }

    private function uploadFoto($image)
    {
        $filename = uniqid() . time() . '.' . $image->getClientOriginalExtension();
        $path = 'uploads/avatar/';
        $targetPath = public_path('storage/');
        $fullPath = $path . $filename;
        $img = Image::make($image);
        $dimension = 512;
        $img->fit($dimension);
        $img->fit($dimension, $dimension, function ($constraint) {
            $constraint->upsize();
        });

        if (!Storage::has('public/' . $path))
            Storage::makeDirectory('public/' . $path);

        $img->save($targetPath . $fullPath);

        return $fullPath;
    }
}
