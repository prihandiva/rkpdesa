<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::all();
        $bidangs = Bidang::paginate(10);
        return view('admin.bidang.index', compact('bidangs'));
    }

    public function create()
    {
        return view('admin.bidang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Bidang::create($validated);
        return redirect()->route('bidang.index')->with('success', 'Bidang berhasil ditambahkan');
    }

    public function show($id)
    {
        $bidang = Bidang::findOrFail($id);
        return view('admin.bidang.show', compact('bidang'));
    }

    public function edit($id)
    {
        $bidang = Bidang::findOrFail($id);
        return view('admin.bidang.edit', compact('bidang'));
    }

    public function update(Request $request, $id)
    {
        $bidang = Bidang::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        $bidang->update($validated);
        return redirect()->route('bidang.index')->with('success', 'Bidang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bidang = Bidang::findOrFail($id);
        $bidang->delete();
        return redirect()->route('bidang.index')->with('success', 'Bidang berhasil dihapus');
    }
}
