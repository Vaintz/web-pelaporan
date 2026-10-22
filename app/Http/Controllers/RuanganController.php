<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Ruangan::with('gedung');

        // Search Nama Ruangan
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter per Gedung
        if ($request->filled('gedung_id')) {
            $query->where('gedung_id', $request->gedung_id);
        }

        // Filter per Lantai
        if ($request->filled('lantai')) {
            $query->where('lantai', $request->lantai);
        }

        $ruangans = $query->latest()->get();
        $listGedung = Gedung::with('lantais')->get();

        return view('admin-biro.ruangan.index', compact('ruangans', 'listGedung'));
    }

    public function create()
    {
        $listGedung = Gedung::all();
        return view('admin-biro.ruangan.create', compact('listGedung'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gedung_id' => 'required|exists:gedungs,id',
            'lantai'    => ['required', 'string', 'max:50', Rule::exists('lantais', 'nama')->where(fn ($query) => $query->where('gedung_id', $request->input('gedung_id')))],
            'nama'      => 'required|string|max:255',
        ], [
            'gedung_id.required' => 'Pilih gedung terlebih dahulu.',
            'lantai.required'    => 'Pilih lantai terlebih dahulu.',
            'lantai.exists'      => 'Lantai tidak terdaftar pada gedung yang dipilih.',
            'nama.required'      => 'Nama ruangan wajib diisi.',
        ]);

        Ruangan::create([
            'gedung_id' => $request->gedung_id,
            'lantai'    => $request->lantai,
            'nama'      => $request->nama,
        ]);

        return redirect()->route('admin.biro.ruangan.index')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $listGedung = Gedung::all();
        return view('admin-biro.ruangan.edit', compact('ruangan', 'listGedung'));
    }

    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);

        $request->validate([
            'gedung_id' => 'required|exists:gedungs,id',
            'lantai'    => 'required|string|max:50',
            'nama'      => 'required|string|max:255',
        ], [
            'gedung_id.required' => 'Pilih gedung terlebih dahulu.',
            'lantai.required'    => 'Lantai wajib diisi.',
            'nama.required'      => 'Nama ruangan wajib diisi.',
        ]);

        $ruangan->update([
            'gedung_id' => $request->gedung_id,
            'lantai'    => $request->lantai,
            'nama'      => $request->nama,
        ]);

        return redirect()->route('admin.biro.ruangan.index')->with('success', 'Data ruangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return redirect()->route('admin.biro.ruangan.index')->with('success', 'Ruangan berhasil dihapus!');
    }
}