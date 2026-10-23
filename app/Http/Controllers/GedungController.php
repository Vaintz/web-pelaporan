<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use Illuminate\Http\Request;

class GedungController extends Controller
{
    public function index(Request $request)
    {
        $query = Gedung::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $gedungs = $query->latest()->get();

        return view('admin-biro.gedung.index', compact('gedungs'));
    }

    public function create()
    {
        return view('admin-biro.gedung.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:gedungs,nama',
        ], [
            'nama.required' => 'Nama gedung wajib diisi.',
            'nama.unique' => 'Nama gedung ini sudah terdaftar.',
        ]);

        Gedung::create(['nama' => $validated['nama']]);

        return redirect()->route('admin.biro.gedung.index')->with('success', 'Gedung berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $gedung = Gedung::findOrFail($id);

        return view('admin-biro.gedung.edit', compact('gedung'));
    }

    public function update(Request $request, $id)
    {
        $gedung = Gedung::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('gedungs', 'nama')->ignore($gedung->id)],
        ], [
            'nama.required' => 'Nama gedung wajib diisi.',
            'nama.unique' => 'Nama gedung ini sudah terdaftar.',
        ]);

        $gedung->update(['nama' => $validated['nama']]);

        return redirect()->route('admin.biro.gedung.edit', $gedung->id)->with('success', 'Nama gedung berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $gedung = Gedung::findOrFail($id);

        if ($gedung->ruangans()->exists()) {
            return redirect()->route('admin.biro.gedung.index')
                ->with('error', 'Gedung tidak dapat dihapus karena masih memiliki ruangan.');
        }

        $gedung->delete();

        return redirect()->route('admin.biro.gedung.index')->with('success', 'Gedung berhasil dihapus!');
    }
}
