<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::paginate(10);
        return view('admin.pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'NIP' => 'nullable|string|unique:pegawai',
            'telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|unique:pegawai',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Pegawai::create($validated);
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('admin.pegawai.show', compact('pegawai'));
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'NIP' => 'nullable|string|unique:pegawai,NIP,' . $id . ',id_pegawai',
            'telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|unique:pegawai,email,' . $id . ',id_pegawai',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $pegawai->update($validated);
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }
}
