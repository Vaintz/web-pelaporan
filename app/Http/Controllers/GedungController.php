<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\Lantai;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GedungController extends Controller
{
    public function index(Request $request)
    {
        $query = Gedung::with('lantais')->withCount('ruangans');

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
        $request->validate([
            'nama' => 'required|string|max:255|unique:gedungs,nama',
        ], [
            'nama.required' => 'Nama gedung wajib diisi.',
            'nama.unique' => 'Nama gedung ini sudah terdaftar.',
        ]);

        Gedung::create(['nama' => $request->nama]);

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

        $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('gedungs', 'nama')->ignore($gedung->id)],
        ], [
            'nama.required' => 'Nama gedung wajib diisi.',
            'nama.unique' => 'Nama gedung ini sudah terdaftar.',
        ]);

        $gedung->update(['nama' => $request->nama]);

        return redirect()->route('admin.biro.gedung.index')->with('success', 'Data gedung berhasil diperbarui!');
    }

    public function storeLantai(Request $request, $gedungId)
    {
        $gedung = Gedung::findOrFail($gedungId);

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:50',
                Rule::unique('lantais', 'nama')->where(fn ($query) => $query->where('gedung_id', $gedung->id)),
            ],
        ], [
            'nama.required' => 'Nama lantai wajib diisi.',
            'nama.unique' => 'Lantai tersebut sudah terdaftar pada gedung ini.',
        ]);

        $gedung->lantais()->create(['nama' => trim($validated['nama'])]);

        return redirect()->route('admin.biro.gedung.index')->with('success', 'Lantai berhasil ditambahkan ke ' . $gedung->nama . '.');
    }

    public function destroyLantai($gedungId, $lantaiId)
    {
        $gedung = Gedung::findOrFail($gedungId);
        $lantai = Lantai::where('gedung_id', $gedung->id)->findOrFail($lantaiId);

        if ($gedung->ruangans()->where('lantai', $lantai->nama)->exists()) {
            return redirect()->route('admin.biro.gedung.index')
                ->with('error', 'Lantai tidak dapat dihapus karena masih digunakan oleh data ruangan. Pindahkan ruangan ke lantai lain terlebih dahulu.');
        }

        $lantai->delete();

        return redirect()->route('admin.biro.gedung.index')->with('success', 'Lantai berhasil dihapus.');
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
