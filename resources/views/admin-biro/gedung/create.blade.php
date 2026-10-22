@extends('layouts.dashboard')

@section('title', 'Tambah Gedung')

@section('content')
<div style="max-width: 700px; display: flex; flex-direction: column; gap: 20px;">
    <div style="background: white; padding: 35px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
        <h2 style="margin: 0 0 25px 0; color: #1a1a2e; font-size: 20px; font-weight: 700; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">Tambah Gedung Baru</h2>

        @if($errors->any())
            <div style="background: #fff7ed; color: #9a3412; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.biro.gedung.store') }}" method="POST">
            @csrf
            <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Nama Gedung</label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Gedung A / Gedung Dekanat" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 14px; outline: none;" required>
            </div>

            <div style="margin-top: 24px; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px;">
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 8px;">
                    <label style="font-size: 14px; font-weight: 700; color: #1e293b;">Daftar Lantai</label>
                    <button type="button" id="tambah-lantai" style="background: #e0e7ff; color: #3730a3; border: 0; padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer;">+ Tambah Lantai</button>
                </div>
                <p style="font-size: 12px; color: #64748b; margin: 0 0 14px;">Tambahkan nama lantai untuk gedung ini. Bagian ini boleh dikosongkan dan diatur nanti melalui menu Edit.</p>
                <div id="daftar-lantai" style="display: flex; flex-direction: column; gap: 10px;">
                    @php($lantaiLama = old('lantais', ['']))
                    @foreach($lantaiLama as $i => $namaLantai)
                        <div class="baris-lantai" style="display: flex; gap: 8px; align-items: center;">
                            <input type="text" name="lantais[]" value="{{ $namaLantai }}" maxlength="50" placeholder="Contoh: Lantai 1" style="flex: 1; min-width: 0; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px;">
                            <button type="button" class="hapus-lantai" style="background: #fee2e2; color: #991b1b; border: 0; padding: 9px 12px; border-radius: 8px; cursor: pointer; font-size: 12px;">Hapus</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px; display: flex; justify-content: flex-end; align-items: center; gap: 12px;">
                <a href="{{ route('admin.biro.gedung.index') }}" style="color: #64748b; text-decoration: none; font-size: 13px; font-weight: 600; padding: 10px 18px;">Batal</a>
                <button type="submit" style="background: #212035; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 13px; box-shadow: 0 4px 10px rgba(33,32,53,0.15);">Simpan Gedung</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const daftar = document.getElementById('daftar-lantai');
    const tombolTambah = document.getElementById('tambah-lantai');

    function buatBaris(nilai = '') {
        const baris = document.createElement('div');
        baris.className = 'baris-lantai';
        baris.style.cssText = 'display:flex;gap:8px;align-items:center;';
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'lantais[]';
        input.maxLength = 50;
        input.placeholder = 'Contoh: Lantai 1';
        input.value = nilai;
        input.style.cssText = 'flex:1;min-width:0;padding:10px 12px;border:1px solid #cbd5e1;border-radius:10px;font-size:13px;';
        const tombol = document.createElement('button');
        tombol.type = 'button';
        tombol.className = 'hapus-lantai';
        tombol.textContent = 'Hapus';
        tombol.style.cssText = 'background:#fee2e2;color:#991b1b;border:0;padding:9px 12px;border-radius:8px;cursor:pointer;font-size:12px;';
        baris.append(input, tombol);
        daftar.appendChild(baris);
    }

    tombolTambah.addEventListener('click', function () { buatBaris(); });
    daftar.addEventListener('click', function (event) {
        const tombol = event.target.closest('.hapus-lantai');
        if (!tombol) return;
        const baris = tombol.closest('.baris-lantai');
        if (daftar.querySelectorAll('.baris-lantai').length > 1) {
            baris.remove();
        } else {
            const input = baris.querySelector('input');
            input.value = '';
            input.focus();
        }
    });
});
</script>
@endsection