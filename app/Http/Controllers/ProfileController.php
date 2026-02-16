<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User profile not found.');
        }

        return view('admin.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User profile not found.');
        }

        $request->validate([
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && file_exists(public_path('storage/' . $user->profile_image))) {
                unlink(public_path('storage/' . $user->profile_image));
            }

            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $user->profile_image = $imagePath;
            
            // Update session profile image if needed
            session()->put('user_image', $imagePath);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
