<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_role' => 'required|unique:roles',
            'nama' => 'required|string|max:255',
        ]);

        Role::create($validated);
        return redirect()->route('role.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role.show', compact('role'));
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        $role->update($validated);
        return redirect()->route('role.index')->with('success', 'Role berhasil diperbarui');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus');
    }
}
