@extends('layouts.dashboard')

@section('title', 'Edit Gedung')

@section('content')
<div style="max-width: 700px; display: flex; flex-direction: column; gap: 20px;">
    <div style="background: white; padding: 35px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
        <h2 style="margin: 0 0 25px 0; color: #1a1a2e; font-size: 20px; font-weight: 700; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">Edit Gedung</h2>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px;">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div style="background: #fff7ed; color: #9a3412; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.biro.gedung.update', $gedung->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Nama Gedung</label>
                <input type="text" name="nama" value="{{ old('nama', $gedung->nama) }}" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 14px; outline: none;" required>
            </div>
            <div style="margin-top: 20px; text-align: right;">
                <button type="submit" style="background: #212035; color: white; border: none; padding: 11px 20px; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 13px;">Simpan Nama Gedung</button>
            </div>
        </form>
    </div>

    <div style="background: white; padding: 30px 35px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
        <h3 style="margin: 0 0 6px; color: #1a1a2e; font-size: 17px; font-weight: 700;">Pengaturan Lantai</h3>
        <p style="margin: 0 0 18px; color: #64748b; font-size: 13px;">Kelola lantai khusus untuk {{ $gedung->nama }}. Lantai yang masih dipakai oleh ruangan tidak dapat dihapus.</p>

        <form action="{{ route('admin.biro.gedung.lantai.store', $gedung->id) }}" method="POST" style="display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap;">
            @csrf
            <input type="text" name="nama" maxlength="50" placeholder="Nama lantai, contoh: Lantai 1" required style="flex: 1; min-width: 200px; padding: 11px 12px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px;">
            <button type="submit" style="background: #334155; color: white; border: 0; padding: 10px 15px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">+ Tambah Lantai</button>
        </form>

        <div style="display: flex; flex-direction: column; gap: 8px;">
            @forelse($gedung->lantais as $lantai)
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 12px 14px; border: 1px solid #e2e8f0; border-radius: 10px;">
                    <span style="font-size: 13px; font-weight: 600; color: #334155;">{{ $lantai->nama }}</span>
                    <form action="{{ route('admin.biro.gedung.lantai.destroy', [$gedung->id, $lantai->id]) }}" method="POST" onsubmit="return confirm('Hapus lantai {{ $lantai->nama }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #fee2e2; color: #991b1b; border: 0; padding: 7px 11px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">Hapus</button>
                    </form>
                </div>
            @empty
                <p style="padding: 18px; margin: 0; text-align: center; background: #f8fafc; border-radius: 10px; color: #94a3b8; font-size: 13px;">Belum ada lantai. Tambahkan lantai melalui kolom di atas.</p>
            @endforelse
        </div>
    </div>

    <div style="display: flex; justify-content: flex-end;">
        <a href="{{ route('admin.biro.gedung.index') }}" style="color: #64748b; text-decoration: none; font-size: 13px; font-weight: 600; padding: 10px 18px;">Kembali ke Daftar Gedung</a>
    </div>
</div>
@endsection