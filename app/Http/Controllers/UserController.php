<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard.user.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.user.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'string',
            'username' => 'required|string|regex:/^[a-z0-9]+$/|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'picture' => 'image|mimes:jpg,png,jpeg,svg|max:5000',
            'role' => 'required|in:admin,dosen,mahasiswa'
        ]);

        if ($request->hasFile('picture')) {
            $validated['picture'] = $this->uploadFoto($request->file('picture'));
        }

        User::create($validated);

        Session::flash('success', 'Berhasil Menambahkan User');

        return redirect(route('users.index'));
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

    public function edit(User $user)
    {
        return view('dashboard.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $this->validate($request, [
            'name' => 'string',
            'username' => 'required|string|regex:/^[a-z0-9]+$/|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|min:6',
            'picture' => 'image|mimes:jpg,png,jpeg,svg|max:5000',
            'role' => 'required|in:admin,dosen,mahasiswa'
        ]);
        if (!$validated['password'] ?? '') {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('picture')) {
            $validated['picture'] = $this->uploadFoto($request->file('picture'));
            if ($user->picture) {
                //Delete Avatar
                $avaExists = $user->picture;
                Storage::disk('public')->delete($avaExists);
                $avaExists->delete();
            }
        }
        $user->update($validated);

        Session::flash('success', 'Berhasil Memperbaharui User');

        return redirect(route('users.index'));
    }

    public function destroy(User $user)
    {

        Storage::disk('public')->delete($user['picture']);
        $user->delete();
        Session::flash('success', 'Berhasil Menghapus User');
        return route('users.index');
    }

}
