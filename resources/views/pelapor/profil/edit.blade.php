@extends('layouts.dashboard')

@section('title', 'Edit Profil')

@section('content')
    <style>
        .profil-edit-page { width: 100%; max-width: 800px; display: flex; flex-direction: column; gap: 20px; min-width: 0; }
        .profil-edit-card { background: #fff; padding: 30px; border-radius: 18px; box-shadow: 0 4px 15px rgba(0,0,0,.03); box-sizing: border-box; min-width: 0; }
        .profil-edit-fields { display: flex; flex-direction: column; gap: 24px; min-width: 0; }
        .profil-edit-inputs { flex: 1 1 auto; width: 100%; min-width: 0; display: flex; flex-direction: column; gap: 16px; }
        .profil-edit-photo { flex: 0 1 220px; min-width: 0; display: flex; flex-direction: column; align-items: center; text-align: center; }
        .profil-edit-input { width: 100%; max-width: 100%; box-sizing: border-box; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; }
        .profil-edit-input:disabled { background: #f8fafc; color: #94a3b8; border-color: #e2e8f0; }
        .profil-edit-photo { flex: 0 0 auto; width: 100%; min-width: 0; align-items: stretch; text-align: left; padding-bottom: 18px; border-bottom: 1px solid #f1f5f9; }
        .profil-edit-photo-head { display: flex; align-items: center; gap: 14px; width: 100%; margin-bottom: 14px; text-align: left; }
        .profil-edit-avatar { width: 72px; height: 72px; flex: 0 0 72px; border-radius: 50%; overflow: hidden; background: #eef2f3; border: 3px solid #eef2f3; box-shadow: 0 4px 10px rgba(0,0,0,.08); display: flex; justify-content: center; align-items: center; box-sizing: border-box; }
        .profil-edit-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profil-edit-photo-identity { min-width: 0; overflow-wrap: anywhere; }
        .profil-edit-photo-identity strong { display: block; color: #1a1a2e; font-size: 14px; line-height: 1.35; margin-bottom: 5px; }
        .profil-edit-role { display: inline-block; background: #eef2f3; color: #212035; padding: 3px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; }
        .profil-edit-email { display: block; color: #64748b; font-size: 11px; line-height: 1.4; overflow-wrap: anywhere; }
        .profil-edit-photo label { align-self: flex-start; text-align: left; }
        .profil-edit-actions { margin-top: 28px; border-top: 1px solid #f1f5f9; padding-top: 18px; display: flex; justify-content: flex-end; align-items: center; gap: 12px; }
        @media (max-width: 600px) {
            .profil-edit-page { gap: 14px; }
            .profil-edit-card { padding: 18px 16px; border-radius: 14px; }
            .profil-edit-fields { flex-direction: column; gap: 20px; }
            .profil-edit-inputs { flex: 1 1 auto; width: 100%; min-width: 0; }
            .profil-edit-photo { flex: 0 0 auto; width: 100% !important; padding-top: 0; align-items: stretch; }
            .profil-edit-photo-head { gap: 12px; margin-bottom: 14px; }
            .profil-edit-avatar { width: 64px; height: 64px; flex-basis: 64px; }
            .profil-edit-photo-identity strong { font-size: 13px; }
            .profil-edit-photo input[type="file"] { width: 100%; max-width: 100%; font-size: 11px; }
            .profil-edit-photo input[type="file"]::file-selector-button { max-width: 100%; font-size: 11px; padding: 6px 8px; }
            .profil-edit-photo label { font-size: 11px !important; }
            .profil-edit-photo > span { display: block; line-height: 1.5; font-size: 10px !important; }
            .profil-edit-actions { margin-top: 22px; padding-top: 16px; gap: 8px; }
            .profil-edit-actions a { display: flex; align-items: center; justify-content: center; }
            .profil-edit-actions { flex-direction: column-reverse; align-items: stretch; }
            .profil-edit-actions a, .profil-edit-actions button { width: 100%; min-height: 44px; box-sizing: border-box; text-align: center; }
        }
    </style>
    <div class="profil-edit-page">

        <div class="profil-edit-card">
            <h2 style="margin: 0 0 25px 0; color: #1a1a2e; font-size: 20px; font-weight: 700; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
                Edit Profil
            </h2>

            <!-- Menampilkan pesan error validasi -->
            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- LOGIKA MENENTUKAN LABEL IDENTITAS -->
            @php
                $labelIdentitas = 'NIP';
                if ($user->role === 'pelapor') {
                    if (str_ends_with($user->email, '@mhs.unimal.ac.id')) {
                        $labelIdentitas = 'Nomor Induk Mahasiswa (NIM)';
                    } else {
                        $labelIdentitas = 'NIP / NIDN';
                    }
                }
            @endphp

            <!-- Form update -->
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="profil-edit-fields">

                    <!-- Bagian Kiri: Input Teks -->
                    <div class="profil-edit-inputs">
                        
                        <!-- Nama Lengkap (Bisa Diubah) -->
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="profil-edit-input" required>
                        </div>

                        <!-- Email (Disabled) -->
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px;">Email (Tidak dapat diubah)</label>
                            <input type="email" value="{{ $user->email }}"
                                class="profil-edit-input" disabled>
                        </div>

                        <!-- NIM/NIP (Disabled) -->
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px;">
                                {{ $labelIdentitas }} (Tidak dapat diubah)
                            </label>
                            <input type="text" value="{{ $user->nim_nip }}"
                                style="width: 100%; padding: 12px 14px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: #f8fafc; color: #94a3b8;" disabled>
                        </div>

                        <!-- Fakultas (Disabled) -->
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px;">Fakultas (Tidak dapat diubah)</label>
                            <input type="text" value="{{ $user->fakultas }}"
                                style="width: 100%; padding: 12px 14px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: #f8fafc; color: #94a3b8;" disabled>
                        </div>

                        <!-- Program Studi (Disabled) -->
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px;">Program Studi (Tidak dapat diubah)</label>
                            <input type="text" value="{{ $user->program_studi }}"
                                style="width: 100%; padding: 12px 14px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: #f8fafc; color: #94a3b8;" disabled>
                        </div>

                        <!-- Nomor HP (Bisa Diubah) -->
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Nomor HP / WhatsApp</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 14px; outline: none;">
                        </div>

                        <!-- Alamat (Bisa Diubah) -->
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Alamat</label>
                            <textarea name="alamat" rows="3"
                                class="profil-edit-input">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>
                    </div>

                    <!-- Bagian Kanan: Foto Profil -->
                    <div class="profil-edit-photo">
                        <div class="profil-edit-photo-head">
                            <div class="profil-edit-avatar">
                                @if($user->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto profil">
                                @else
                                    <span style="color: #888; font-size: 14px; font-weight: 600;">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                @endif
                            </div>
                            <div class="profil-edit-photo-identity">
                                <strong>{{ $user->name }}</strong>
                                <span class="profil-edit-role">{{ str_replace('_', ' ', $user->role) }}</span>
                                <span class="profil-edit-email">{{ $user->email }}</span>
                            </div>
                        </div>

                        <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 8px;">Ganti Foto Profil</label>
                        <input type="file" name="profile_photo" accept="image/*" style="width: 100%; font-size: 12px; color: #64748b;">
                        <span style="font-size: 11px; color: #94a3b8; margin-top: 6px;">Format JPG/PNG, maks. 5MB</span>
                    </div>

                </div>

                <!-- Tombol Bawah -->
                <div class="profil-edit-actions">
                    <a href="{{ route($user->role === 'admin_fakultas' ? 'admin.fakultas.profil' : ($user->role === 'admin_biro' ? 'admin.biro.profil' : 'pelapor.profil')) }}"
                        style="color: #64748b; text-decoration: none; font-size: 13px; font-weight: 600; padding: 10px 18px;">
                        Batal
                    </a>
                    <button type="submit"
                        style="background: #212035; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 13px; box-shadow: 0 4px 10px rgba(33,32,53,0.15);">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection