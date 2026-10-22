@extends('layouts.dashboard')

@section('title', 'Manajemen Gedung')

@section('content')
<div style="max-width: 1050px; display: flex; flex-direction: column; gap: 20px;">
    <div style="background: white; padding: 25px 30px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="margin: 0 0 5px 0; color: #1a1a2e; font-size: 20px; font-weight: 700;">Manajemen Gedung</h2>
            <p style="margin: 0; color: #64748b; font-size: 13px;">Kelola data gedung fasilitas utama di Fakultas Teknik.</p>
        </div>
        <a href="{{ route('admin.biro.gedung.create') }}" style="background: #212035; color: white; text-decoration: none; padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 10px rgba(33,32,53,0.15);">
            + Tambah Gedung
        </a>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px 18px; border-radius: 12px; font-size: 14px; font-weight: 500;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 12px 18px; border-radius: 12px; font-size: 14px; font-weight: 500;">{{ session('error') }}</div>
    @endif

    <div style="background: white; padding: 20px 30px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
        <form action="{{ route('admin.biro.gedung.index') }}" method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
            <div style="flex: 1; min-width: 220px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama gedung..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px; outline: none;">
            </div>
            <button type="submit" style="background: #334155; color: white; border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.biro.gedung.index') }}" style="color: #64748b; text-decoration: none; font-size: 13px; font-weight: 600; padding: 10px;">Reset</a>
            @endif
        </form>
    </div>

    <div style="background: white; padding: 25px 30px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="border-bottom: 2px solid #f1f5f9; color: #64748b; font-size: 12px; text-transform: uppercase;">
                    <th style="padding: 12px 10px; width: 60px;">No</th>
                    <th style="padding: 12px 10px;">Nama Gedung</th>
                    <th style="padding: 12px 10px;">Jumlah Ruangan</th>
                    <th style="padding: 12px 10px; text-align: center; width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gedungs as $gedung)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 15px 10px; color: #64748b; font-weight: 600;">{{ $loop->iteration }}</td>
                        <td style="padding: 15px 10px; font-weight: 600; color: #1e293b;">{{ $gedung->nama }}</td>
                        <td style="padding: 15px 10px;">
                            <span style="background: #f1f5f9; color: #334155; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 700;">{{ $gedung->ruangans_count }} Ruangan</span>
                        </td>
                        <td style="padding: 15px 10px; text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                <a href="{{ route('admin.biro.gedung.edit', $gedung->id) }}" style="background: #e0f2fe; color: #0369a1; text-decoration: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600;">Edit</a>
                                <form action="{{ route('admin.biro.gedung.destroy', $gedung->id) }}" method="POST" onsubmit="return confirm('Menghapus gedung akan menghapus seluruh ruangan di dalamnya. Yakin?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #fee2e2; color: #991b1b; border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align: center; padding: 30px; color: #94a3b8;">Data Gedung belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection