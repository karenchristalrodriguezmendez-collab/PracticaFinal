<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Services\FileService;

class ProfileController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->middleware('auth');
        $this->fileService = $fileService;
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $uploadResult = $this->fileService->upload(
                $request->file('avatar'),
                'users'
            );

            if ($uploadResult['success']) {
                if ($user->avatar) {
                    $this->fileService->delete($user->avatar);
                }
                $user->avatar = $uploadResult['path'];
            }
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Perfil actualizado exitosamente.');
    }
}
