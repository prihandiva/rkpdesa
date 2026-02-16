<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource (Index)
     * Menampilkan daftar semua user
     */
    public function index()
    {
        $users = User::paginate(10);
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource (Create Form)
     * Menampilkan form untuk membuat user baru
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage (Store)
     * Menyimpan data user baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,nama',
            'telp' => 'nullable|string|max:20',
            'id_dusun' => 'nullable|exists:dusun,id_dusun',
            'id_rw' => 'nullable|exists:rw,id_rw',
            'id_rt' => 'nullable|exists:rt,id_rt',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hash password
        $validated['password'] = bcrypt($validated['password']);

        // Simpan user baru
        User::create($validated);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource (Show/View)
     * Menampilkan detail user tertentu
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource (Edit Form)
     * Menampilkan form untuk mengedit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage (Update)
     * Mengupdate data user di database
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id . ',id_user',
            'email' => 'required|email|unique:users,email,' . $id . ',id_user',
            'password' => 'nullable|min:6',
            'role' => 'required|exists:roles,nama',
            'telp' => 'nullable|string|max:20',
            'id_dusun' => 'nullable|exists:dusun,id_dusun',
            'id_rw' => 'nullable|exists:rw,id_rw',
            'id_rt' => 'nullable|exists:rt,id_rt',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hash password jika ada perubahan
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Update user
        $user->update($validated);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage (Delete)
     * Menghapus user dari database
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User berhasil dihapus');
    }

    /**
     * Store a newly created Role
     */
    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Role::create($validated);

        return redirect()->route('user.index')
            ->with('success', 'Role berhasil ditambahkan');
    }

    /**
     * Update the specified Role
     */
    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $role->update($validated);

        return redirect()->route('user.index')
            ->with('success', 'Role berhasil diperbarui');
    }

    /**
     * Remove the specified Role
     */
    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('user.index')
            ->with('success', 'Role berhasil dihapus');
    }
}
