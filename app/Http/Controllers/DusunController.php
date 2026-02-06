<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use Illuminate\Http\Request;

class DusunController extends Controller
{
    public function index()
    {
        $dusuns  = Dusun::all();
        $dusuns = Dusun::paginate(10);
        return view('admin.dusun.index', compact('dusuns'));
    }

    public function create()
    {
        return view('admin.dusun.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Dusun::create($validated);
        return redirect()->route('dusun.index')->with('success', 'Dusun berhasil ditambahkan');
    }

    public function show($id)
    {
        $dusun = Dusun::findOrFail($id);
        return view('admin.dusun.show', compact('dusun'));
    }

    public function edit($id)
    {
        $dusun = Dusun::findOrFail($id);
        return view('admin.dusun.edit', compact('dusun'));
    }

    public function update(Request $request, $id)
    {
        $dusun = Dusun::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        $dusun->update($validated);
        return redirect()->route('dusun.index')->with('success', 'Dusun berhasil diperbarui');
    }

    public function destroy($id)
    {
        $dusun = Dusun::findOrFail($id);
        $dusun->delete();
        return redirect()->route('dusun.index')->with('success', 'Dusun berhasil dihapus');
    }
}
