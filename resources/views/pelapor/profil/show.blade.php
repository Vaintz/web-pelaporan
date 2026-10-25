@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
    <style>
        .profil-page { width: 100%; max-width: 800px; display: flex; flex-direction: column; gap: 20px; min-width: 0; }
        .profil-card { background: #fff; padding: 30px; border-radius: 18px; box-shadow: 0 4px 15px rgba(0,0,0,.03); box-sizing: border-box; min-width: 0; }
        .profil-identity { display: flex; align-items: center; gap: 20px; flex-wrap: wrap; min-width: 0; }
        .profil-hero { display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; }
        .profil-avatar { width: 100px; height: 100px; flex: 0 0 100px; border-radius: 50%; overflow: hidden; background: #eef2f3; border: 3px solid #eef2f3; box-shadow: 0 4px 10px rgba(0,0,0,.08); display: flex; justify-content: center; align-items: center; box-sizing: border-box; }
        .profil-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profil-edit-link { background: #212035; color: #fff; text-decoration: none; padding: 10px 22px; border-radius: 10px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; box-shadow: 0 4px 10px rgba(33,32,53,.15); }
        .profil-identity-text { min-width: 0; overflow-wrap: anywhere; }
        .profil-identity-heading { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 4px; }
        .profil-info-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        .profil-info-item { background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #f1f5f9; min-width: 0; box-sizing: border-box; }
        .profil-info-value { display: block; font-size: 14px; color: #1e293b; font-weight: 600; overflow-wrap: anywhere; line-height: 1.5; }
        .profil-password-input { width: 100%; max-width: 100%; box-sizing: border-box; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; }
        @media (max-width: 600px) {
            .profil-page { gap: 14px; }
            .profil-card { padding: 18px 16px; border-radius: 14px; }
            .profil-hero { padding: 18px 16px; gap: 14px; align-items: stretch; }
            .profil-identity { width: 100%; gap: 12px; flex-wrap: nowrap; align-items: center; }
            .profil-avatar { width: 64px; height: 64px; flex-basis: 64px; border-width: 2px; }
            .profil-identity-text { flex: 1; }
            .profil-identity-heading { gap: 6px; }
            .profil-edit-link { width: 100%; box-sizing: border-box; min-height: 42px; }
            .profil-identity-heading h2 { font-size: 18px !important; overflow-wrap: anywhere; }
            .profil-identity-heading span { font-size: 10px !important; }
            .profil-info-grid { grid-template-columns: minmax(0, 1fr); gap: 10px; }
            .profil-info-item { padding: 13px 14px; }
            .profil-info-item.address-item { grid-column: auto !important; }
            .profil-info-value { font-size: 14px; }
            .profil-password-button { width: 100%; min-height: 44px; }
        }
    </style>
    <div class="profil-page">

        <!-- NOTIFIKASI SUKSES (OPSIONAL KALAU ADA) -->
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px 18px; border-radius: 12px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                <span>✓</span> {{ session('success') }}
            </div>
        @endif

        <!-- CARD UTAMA: PROFIL -->
        <div class="profil-card profil-hero">

            <!-- Sisi Kiri: Foto + Identitas Singkat -->
            <div class="profil-identity">
                <div style="position: relative;">
                    <div class="profil-avatar">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto profil">
                        @else
                            <span style="color: #888; font-size: 13px; font-weight: 600;">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        @endif
                    </div>
                </div>

                <div class="profil-identity-text">
                    <div class="profil-identity-heading">
                        <h2 style="margin: 0; color: #1a1a2e; font-size: 20px; font-weight: 700;">{{ $user->name }}</h2>
                        <span style="background: #eef2f3; color: #212035; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                            {{ str_replace('_', ' ', $user->role) }}
                        </span>
                    </div>
                    <p style="margin: 0; color: #666; font-size: 13px;">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Sisi Kanan: Tombol Edit -->
            <div>
                <a href="{{ route('profil.edit') }}" class="profil-edit-link">
                    Edit Profil
                </a>
            </div>
        </div>

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

        <!-- CARD DETAIL INFORMASI (Gaya List Bersih) -->
        <div class="profil-card">
            <h3 style="margin: 0 0 20px 0; color: #1a1a2e; font-size: 16px; font-weight: 700;">Detail Informasi</h3>

            <div class="profil-info-grid">
                
                <!-- Identitas Utama (NIM/NIP) -->
                <div class="profil-info-item">
                    <span style="display: block; font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">
                        {{ $labelIdentitas }}
                    </span>
                    <span class="profil-info-value">{{ $user->nim_nip ?? 'Belum diisi' }}</span>
                </div>

                <!-- Nomor HP -->
                <div style="background: #f8fafc; padding: 16px 20px; border-radius: 14px; border: 1px solid #f1f5f9;">
                    <span style="display: block; font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">
                        Nomor HP / WhatsApp
                    </span>
                    <span style="font-size: 15px; color: #1e293b; font-weight: 600;">{{ $user->no_hp ?? 'Belum diisi' }}</span>
                </div>

                <!-- Fakultas -->
                <div style="background: #f8fafc; padding: 16px 20px; border-radius: 14px; border: 1px solid #f1f5f9;">
                    <span style="display: block; font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">
                        Fakultas
                    </span>
                    <span style="font-size: 15px; color: #1e293b; font-weight: 600;">{{ $user->fakultas ?? 'Belum diisi' }}</span>
                </div>

                <!-- Program Studi -->
                <div style="background: #f8fafc; padding: 16px 20px; border-radius: 14px; border: 1px solid #f1f5f9;">
                    <span style="display: block; font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">
                        Program Studi
                    </span>
                    <span style="font-size: 15px; color: #1e293b; font-weight: 600;">{{ $user->program_studi ?? 'Belum diisi' }}</span>
                </div>

                <!-- Alamat -->
                <div class="profil-info-item address-item">
                    <span style="display: block; font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">
                        Alamat 
                    </span>
                    <span class="profil-info-value" style="font-weight: 500;">{{ $user->alamat ?? 'Belum diisi' }}</span>
                </div>
            </div>
        </div>

        <!-- CARD GANTI PASSWORD -->
        <div class="profil-card">
            <div style="margin-bottom: 20px;">
                <h3 style="margin: 0 0 4px 0; color: #1a1a2e; font-size: 16px; font-weight: 700;">Keamanan & Password</h3>
                <p style="margin: 0; color: #64748b; font-size: 13px;">Pastikan menggunakan password yang kuat dan mudah diingat.</p>
            </div>

            @if(session('password_success'))
                <div style="background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 500;">
                    ✓ {{ session('password_success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ str_replace(')', '', $error) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profil.password') }}" method="POST" style="max-width: 500px;">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Password Lama</label>
                    <input type="password" name="current_password" class="profil-password-input" placeholder="Masukkan password saat ini" required>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Password Baru</label>
                    <input type="password" name="password" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 14px; outline: none;" placeholder="Minimal 8 karakter" required>
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 14px; outline: none;" placeholder="Ulangi password baru" required>
                </div>

                <button type="submit" class="profil-password-button" style="background: #334155; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 13px; transition: 0.2s;">
                    Perbarui Password
                </button>
            </form>
        </div>

    </div>
@endsection