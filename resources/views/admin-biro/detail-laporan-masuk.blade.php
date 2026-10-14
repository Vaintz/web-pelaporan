@extends('layouts.dashboard')

@section('title', 'Detail Laporan')

@section('content')

    <style>
        .detail-page {
            padding-bottom: 30px;
        }

        /* =========================
               HEADER
            ========================= */

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            color: #27263d;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .back-link:hover {
            color: #4f46e5;
        }

        .back-arrow {
            font-size: 22px;
            line-height: 1;
        }

        .detail-header {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 22px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.12);
            margin-bottom: 14px;
        }

        .detail-header-title {
            font-size: 22px;
            font-weight: 700;
            color: #27263d;
        }

        .detail-header-right {
            text-align: right;
        }

        .nomor-laporan {
            font-size: 21px;
            font-weight: 700;
            color: #27263d;
            margin-bottom: 8px;
        }

        .status-header {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 190px;
            padding: 7px 20px;
            border: 1px solid #ff7900;
            border-radius: 11px;
            background: #fffaf5;
            color: #ff7900;
            font-size: 13px;
            font-weight: 600;
        }

        /* =========================
               GRID
            ========================= */

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
            margin-bottom: 14px;
        }

        .detail-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 11px;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.12);
            padding: 15px 28px;
        }

        .detail-card.full {
            grid-column: 1 / -1;
        }

        .card-title {
            margin: 0 0 16px;
            font-size: 16px;
            font-weight: 700;
            color: #27263d;
        }

        /* =========================
               INFORMATION
            ========================= */

        .info-row {
            display: grid;
            grid-template-columns: 115px 15px 1fr;
            margin-bottom: 10px;
            font-size: 13px;
            line-height: 1.4;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 700;
            color: #27263d;
        }

        .info-separator {
            font-weight: 600;
            color: #27263d;
        }

        .info-value {
            color: #27263d;
            font-weight: 600;
            word-break: break-word;
        }

        .description-value {
            line-height: 1.5;
        }

        /* =========================
               FOTO
            ========================= */

        .photo-list {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .photo-item {
            position: relative;
            width: 150px;
            height: 92px;
            border: 2px solid #27263d;
            border-radius: 10px;
            overflow: hidden;
            background: #f3f4f6;
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .photo-zoom {
            position: absolute;
            right: 5px;
            bottom: 5px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #27263d;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .no-photo {
            color: #9ca3af;
            font-size: 13px;
            padding: 20px 0;
        }

        /* =========================
               BADGE
            ========================= */

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 13px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-valid {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-high {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-medium {
            background: #fef3c7;
            color: #b45309;
        }

        .badge-low {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-process {
            background: #fff7ed;
            color: #c2410c;
        }

        .badge-assigned {
            background: #f3e8ff;
            color: #7e22ce;
        }

        /* =========================
               FORM
            ========================= */

        .verification-form {
            margin-top: 4px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 115px 15px 1fr;
            margin-bottom: 14px;
            align-items: center;
        }

        .form-label {
            font-size: 13px;
            font-weight: 700;
            color: #27263d;
        }

        .form-separator {
            font-size: 13px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            height: 38px;
            box-sizing: border-box;
            padding: 0 11px;
            border: 1px solid #9ca3af;
            border-radius: 8px;
            background: #ffffff;
            color: #27263d;
            font-size: 13px;
            outline: none;
        }

        textarea.form-control {
            height: 76px;
            padding: 10px 11px;
            resize: vertical;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.08);
        }

        .verification-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 18px;
        }

        .btn-primary {
            min-width: 180px;
            height: 42px;
            padding: 0 20px;
            border: none;
            border-radius: 9px;
            background: #242238;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #171629;
        }

        /* =========================
               PENUGASAN
            ========================= */

        .assignment-card {
            margin-top: 14px;
        }

        .assignment-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.8fr 1.2fr;
            gap: 28px;
            align-items: start;
        }

        .assignment-column {
            min-width: 0;
        }

        .assignment-label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 700;
            color: #27263d;
        }

        .technician-search {
            margin-bottom: 8px;
        }

        .technician-list {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: hidden;
        }

        .technician-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #eef0f3;
            transition: 0.2s;
        }

        .technician-option:last-child {
            border-bottom: none;
        }

        .technician-option:hover {
            background: #fafafa;
        }

        /* Teknisi yang sedang dipilih */
        .technician-option.selected {
            background: #f0f1f7;
            border-left: 3px solid #242238;
            padding-left: 7px;
            box-shadow: inset 0 0 0 1px #d8d9e5;
        }

        .technician-option.selected .technician-avatar {
            background: #242238;
            color: #ffffff;
        }

        .technician-option.selected .technician-name {
            color: #242238;
        }

        .technician-option.selected::after {
            content: '✓';
            width: 22px;
            height: 22px;
            margin-left: auto;
            border-radius: 50%;
            background: #242238;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .technician-option input {
            display: none;
        }

        .technician-info {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .technician-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .technician-name {
            font-size: 12px;
            font-weight: 700;
            color: #27263d;
        }

        .technician-role {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 2px;
        }

        .availability {
            padding: 5px 9px;
            border-radius: 7px;
            background: #dcfce7;
            color: #15803d;
            font-size: 11px;
            font-weight: 700;
        }

        .assignment-date {
            margin-bottom: 13px;
        }

        .assignment-date:last-child {
            margin-bottom: 0;
        }

        .assignment-date input {
            text-align: center;
        }

        .assignment-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
        }

        .btn-assign {
            min-width: 205px;
            height: 43px;
            border: none;
            border-radius: 9px;
            background: #242238;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-assign:hover {
            background: #171629;
        }

        /* =========================
               ALERT
            ========================= */

        .alert {
            padding: 11px 15px;
            border-radius: 8px;
            margin-bottom: 14px;
            font-size: 13px;
            font-weight: 600;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .btn-selesai {
            min-width: 205px;
            height: 43px;
            padding: 0 20px;
            border: none;
            border-radius: 9px;
            background: #15803d;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-selesai:hover {
            background: #166534;
        }

        /* =========================
               RESPONSIVE
            ========================= */

        @media (max-width: 900px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .detail-card.full {
                grid-column: auto;
            }

            .assignment-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .detail-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .detail-header-right {
                text-align: left;
            }

            .info-row,
            .form-row {
                grid-template-columns: 100px 12px 1fr;
            }

            .detail-card {
                padding: 15px;
            }
        }
    </style>


    <div class="detail-page">

        {{-- =========================
        BACK
        ========================= --}}
        <a href="{{ route('admin.biro.laporan') }}" class="back-link">
            <span class="back-arrow">←</span>
            <span>Daftar Laporan / Detail Laporan</span>
        </a>


        {{-- =========================
        ALERT
        ========================= --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif


        {{-- =========================
        HEADER
        ========================= --}}
        <div class="detail-header">

            <div class="detail-header-title">
                Detail Laporan
            </div>

            <div class="detail-header-right">

                <div class="nomor-laporan">
                    {{ $laporan->nomor_laporan }}
                </div>

                @if ($laporan->status === 'diproses')

                    <div class="status-header">
                        Menunggu Verifikasi
                    </div>

                @elseif ($laporan->status === 'diverifikasi')

                    <div class="status-header">
                        Siap Ditangani
                    </div>

                @elseif ($laporan->status === 'ditugaskan')

                    <div class="status-header">
                        Sedang Ditangani
                    </div>

                @else

                    <div class="status-header">
                        {{ ucfirst($laporan->status) }}
                    </div>

                @endif

            </div>

        </div>


        {{-- =========================
        INFORMASI
        ========================= --}}
        <div class="detail-grid">

            {{-- INFORMASI LAPORAN --}}
            <div class="detail-card">

                <h3 class="card-title">
                    INFORMASI LAPORAN
                </h3>

                <div class="info-row">
                    <div class="info-label">Judul</div>
                    <div class="info-separator">:</div>
                    <div class="info-value">
                        {{ $laporan->judul_laporan ?? '-' }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Kategori</div>
                    <div class="info-separator">:</div>
                    <div class="info-value">
                        {{ $laporan->kategori->nama ?? '-' }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Tanggal</div>
                    <div class="info-separator">:</div>
                    <div class="info-value">
                        {{ $laporan->created_at
        ? $laporan->created_at->format('d F Y')
        : '-' }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Lokasi</div>
                    <div class="info-separator">:</div>
                    <div class="info-value">
                        @if ($laporan->gedung)
                            {{ $laporan->gedung->nama ?? '' }}

                            @if ($laporan->ruangan)
                                , {{ $laporan->ruangan ?? '' }}
                            @endif
                        @else
                            {{ $laporan->detail_lokasi ?? '-' }}
                        @endif
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Deskripsi</div>
                    <div class="info-separator">:</div>
                    <div class="info-value description-value">
                        {{ $laporan->deskripsi_kerusakan ?? '-' }}
                    </div>
                </div>

            </div>


            {{-- INFORMASI PELAPOR --}}
            <div class="detail-card">

                <h3 class="card-title">
                    INFORMASI PELAPOR
                </h3>

                <div class="info-row">
                    <div class="info-label">Nama</div>
                    <div class="info-separator">:</div>
                    <div class="info-value">
                        {{ $laporan->user->name ?? '-' }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">NIM/NIP</div>
                    <div class="info-separator">:</div>
                    <div class="info-value">
                        {{ $laporan->user->nim_nip ?? '-' }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Fakultas</div>
                    <div class="info-separator">:</div>
                    <div class="info-value">
                        {{ $laporan->user->fakultas ?? '-' }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Unit</div>
                    <div class="info-separator">:</div>
                    <div class="info-value">
                        {{ $laporan->user->program_studi ?? '-' }}
                    </div>
                </div>

            </div>


            {{-- =========================
            BUKTI / LAMPIRAN
            ========================= --}}
            <div class="detail-card full">

                <h3 class="card-title">
                    BUKTI / LAMPIRAN
                </h3>

                @if ($laporan->foto && $laporan->foto->count() > 0)

                    <div class="photo-list">

                        @foreach ($laporan->foto as $foto)

                            <a href="{{ asset('storage/' . $foto->foto) }}" target="_blank" class="photo-item">

                                <img src="{{ asset('storage/' . $foto->foto) }}" alt="Foto laporan">

                                <span class="photo-zoom">
                                    ⌕
                                </span>

                            </a>

                        @endforeach

                    </div>

                @else

                    <div class="no-photo">
                        Tidak ada lampiran foto.
                    </div>

                @endif

            </div>

        </div>


        {{-- =========================
        HASIL VERIFIKASI FAKULTAS
        ========================= --}}
        <div class="detail-grid">

            <div class="detail-card">

                <h3 class="card-title">
                    HASIL VERIFIKASI FAKULTAS
                </h3>

                <div class="info-row">
                    <div class="info-label">Valid</div>
                    <div class="info-separator">:</div>
                    <div class="info-value">

                        <span class="badge badge-valid">
                            Valid
                        </span>

                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">
                        Catatan Admin Fakultas
                    </div>

                    <div class="info-separator">:</div>

                    <div class="info-value">
                        {{ $laporan->catatan_verifikasi ?? '-' }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">
                        Diverifikasi Oleh
                    </div>

                    <div class="info-separator">:</div>

                    <div class="info-value">
                        Admin Fakultas
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">
                        Tanggal Verifikasi
                    </div>

                    <div class="info-separator">:</div>

                    <div class="info-value">
                        {{ $laporan->updated_at
        ? $laporan->updated_at->format('d F Y')
        : '-' }}
                    </div>
                </div>

            </div>


            {{-- =========================
            VERIFIKASI ADMIN BIRO
            ========================= --}}
            <div class="detail-card">

                <h3 class="card-title">
                    VERIFIKASI ADMIN BIRO
                </h3>

                {{-- BELUM DIVERIFIKASI --}}
                @if ($laporan->status === 'diproses')

                            <form action="{{ route(
                        'admin.biro.laporan.verifikasi',
                        $laporan->id
                    ) }}" method="POST" class="verification-form">

                                @csrf

                                <div class="form-row">

                                    <div class="form-label">
                                        Status
                                    </div>

                                    <div class="form-separator">
                                        :
                                    </div>

                                    <div>
                                        <span class="badge badge-process">
                                            Menunggu Verifikasi
                                        </span>
                                    </div>

                                </div>


                                <div class="form-row">

                                    <label for="prioritas" class="form-label">
                                        Prioritas
                                    </label>

                                    <div class="form-separator">
                                        :
                                    </div>

                                    <div>

                                        <select name="prioritas" id="prioritas" class="form-control" required>

                                            <option value="">
                                                Pilih Prioritas
                                            </option>

                                            <option value="rendah">
                                                Rendah
                                            </option>

                                            <option value="sedang">
                                                Sedang
                                            </option>

                                            <option value="tinggi">
                                                Tinggi
                                            </option>

                                        </select>

                                    </div>

                                </div>


                                <div class="form-row">

                                    <label for="catatan_verifikasi_biro" class="form-label">
                                        Catatan
                                    </label>

                                    <div class="form-separator">
                                        :
                                    </div>

                                    <div>

                                        <textarea name="catatan_verifikasi_biro" id="catatan_verifikasi_biro" class="form-control"
                                            placeholder="Tulis Catatan ..." required></textarea>

                                    </div>

                                </div>


                                <div class="verification-actions">

                                    <button type="submit" class="btn-primary">
                                        Verifikasi Laporan
                                    </button>

                                </div>

                            </form>


                            {{-- SUDAH DIVERIFIKASI --}}
                @elseif (
                            $laporan->status === 'diverifikasi' ||
                            $laporan->status === 'ditugaskan'
                        )

                        <div class="info-row">

                            <div class="info-label">
                                Status
                            </div>

                            <div class="info-separator">
                                :
                            </div>

                            <div class="info-value">

                                <span class="badge badge-valid">
                                    Valid
                                </span>

                            </div>

                        </div>


                        <div class="info-row">

                            <div class="info-label">
                                Prioritas
                            </div>

                            <div class="info-separator">
                                :
                            </div>

                            <div class="info-value">

                                @if ($laporan->prioritas === 'tinggi')

                                    <span class="badge badge-high">
                                        Tinggi
                                    </span>

                                @elseif ($laporan->prioritas === 'sedang')

                                    <span class="badge badge-medium">
                                        Sedang
                                    </span>

                                @else

                                    <span class="badge badge-low">
                                        Rendah
                                    </span>

                                @endif

                            </div>

                        </div>


                        <div class="info-row">

                            <div class="info-label">
                                Catatan
                            </div>

                            <div class="info-separator">
                                :
                            </div>

                            <div class="info-value">
                                {{ $laporan->catatan_verifikasi_biro ?? '-' }}
                            </div>

                        </div>


                        <div class="info-row">

                            <div class="info-label">
                                Tanggal Verifikasi
                            </div>

                            <div class="info-separator">
                                :
                            </div>

                            <div class="info-value">

                                {{ $laporan->diverifikasi_biro_at
                    ? $laporan->diverifikasi_biro_at->format('d F Y')
                    : '-' }}

                            </div>

                        </div>

                @endif

            </div>

        </div>


        {{-- =====================================================
        PENUGASAN TEKNISI
        HANYA MUNCUL SETELAH STATUS DIVERIFIKASI / DITUGASKAN
        ====================================================== --}}

        @if (
                $laporan->status === 'diverifikasi' ||
                $laporan->status === 'ditugaskan'
            )

            <div class="detail-card assignment-card">

                <h3 class="card-title">
                    PENUGASAN TEKNISI
                </h3>


                {{-- =========================
                BELUM DITUGASKAN
                ========================= --}}
                @if ($laporan->status === 'diverifikasi')

                    <form action="{{ route(
                        'admin.biro.laporan.tugaskan',
                        $laporan->id
                    ) }}" method="POST">

                        @csrf

                        <div class="assignment-grid">

                            {{-- PILIH TEKNISI --}}
                            <div class="assignment-column">

                                <label class="assignment-label">
                                    Pilih Teknisi
                                </label>

                                <input type="text" class="form-control technician-search" placeholder="Cari / Pilih Teknisi"
                                    id="technicianSearch">

                                <div class="technician-list">

                                    @php
                                        $teknisiList = \App\Models\Teknisi::where(
                                            'status',
                                            'tersedia'
                                        )->get();
                                    @endphp

                                    @forelse ($teknisi as $teknisi)

                                        <label class="technician-option">

                                            <input type="radio" name="teknisi_id" value="{{ $teknisi->id }}" required>

                                            <div class="technician-info">

                                                <div class="technician-avatar">
                                                    {{ strtoupper(substr($teknisi->nama, 0, 1)) }}
                                                </div>

                                                <div>

                                                    <div class="technician-name">
                                                        {{ $teknisi->nama }}
                                                    </div>

                                                    <div class="technician-role">
                                                        Teknisi
                                                    </div>

                                                </div>

                                            </div>

                                            <span class="availability">
                                                Tersedia
                                            </span>

                                        </label>

                                    @empty

                                        <div style="
                                                                        padding: 14px;
                                                                        color: #9ca3af;
                                                                        font-size: 12px;
                                                                    ">
                                            Belum ada teknisi tersedia.
                                        </div>

                                    @endforelse

                                </div>

                            </div>


                            {{-- TANGGAL --}}
                            <div class="assignment-column">

                                <div class="assignment-date">

                                    <label class="assignment-label" for="tanggal_penugasan">
                                        Tanggal Penugasan
                                    </label>

                                    <input type="date" name="tanggal_penugasan" id="tanggal_penugasan" class="form-control"
                                        value="{{ date('Y-m-d') }}" required>

                                </div>


                                <div class="assignment-date">

                                    <label class="assignment-label" for="target_selesai">
                                        Target Selesai
                                    </label>

                                    <input type="date" name="target_selesai" id="target_selesai" class="form-control" required>

                                </div>

                            </div>


                            {{-- INSTRUKSI --}}
                            <div class="assignment-column">

                                <label class="assignment-label" for="instruksi_teknisi">
                                    Instruksi untuk Teknisi
                                </label>

                                <textarea name="instruksi_teknisi" id="instruksi_teknisi" class="form-control"
                                    placeholder="Tulis instruksi untuk teknisi..." style="height: 88px;" required></textarea>

                            </div>

                        </div>


                        <div class="assignment-actions">

                            <button type="submit" class="btn-assign">
                                Tugaskan Teknisi
                            </button>

                        </div>

                    </form>


                    {{-- =========================
                    SUDAH DITUGASKAN
                    ========================= --}}
                @elseif ($laporan->status === 'ditugaskan')

                    <div class="assignment-grid">

                        <div class="assignment-column">

                            <label class="assignment-label">
                                Teknisi
                            </label>

                            <div class="technician-option">

                                <div class="technician-info">

                                    <div class="technician-avatar">
                                        {{ $laporan->teknisi
                        ? strtoupper(substr($laporan->teknisi->nama, 0, 1))
                        : '-' }}
                                    </div>

                                    <div>

                                        <div class="technician-name">
                                            {{ $laporan->teknisi->nama ?? '-' }}
                                        </div>

                                        <div class="technician-role">
                                            Teknisi
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="assignment-column">

                            <div class="assignment-date">

                                <label class="assignment-label">
                                    Tanggal Penugasan
                                </label>

                                <div class="form-control">
                                    {{ $laporan->tanggal_penugasan
                        ? $laporan->tanggal_penugasan->format('d F Y')
                        : '-' }}
                                </div>

                            </div>


                            <div class="assignment-date">

                                <label class="assignment-label">
                                    Target Selesai
                                </label>

                                <div class="form-control">
                                    {{ $laporan->target_selesai
                        ? $laporan->target_selesai->format('d F Y')
                        : '-' }}
                                </div>

                            </div>

                        </div>


                        <div class="assignment-column">

                            <label class="assignment-label">
                                Instruksi untuk Teknisi
                            </label>

                            <div class="form-control" style="
                                                        height:auto;
                                                        min-height:88px;
                                                        line-height:1.5;
                                                        padding:10px 11px;
                                                    ">
                                {{ $laporan->instruksi_teknisi ?? '-' }}
                            </div>

                        </div>

                    </div>

                    <div style="margin-top: 18px;">
                        <label class="assignment-label" for="deskripsi_tindak_lanjut">
                            Deskripsi Tindak Lanjut
                        </label>
                        <form action="{{ route('admin.biro.laporan.selesai', $laporan->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin laporan ini sudah selesai ditangani?');">
                            @csrf

                            <textarea
                                name="deskripsi_tindak_lanjut"
                                id="deskripsi_tindak_lanjut"
                                class="form-control"
                                style="height: 100px;"
                                placeholder="Tuliskan hasil tindak lanjut atau pekerjaan yang telah dilakukan..."
                                required>{{ old('deskripsi_tindak_lanjut') }}</textarea>

                            <div class="assignment-actions">
                                <button type="submit" class="btn-selesai">
                                    Simpan dan Tandai Selesai
                                </button>
                            </div>
                        </form>
                    </div>

                @endif

            </div>

        @endif

    </div>


    {{-- =========================
    SEARCH TEKNISI
    ========================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const searchInput =
                document.getElementById('technicianSearch');

            if (!searchInput) {
                return;
            }

            searchInput.addEventListener('input', function () {

                const keyword =
                    this.value.toLowerCase().trim();

                const options =
                    document.querySelectorAll('.technician-option');

                options.forEach(function (option) {

                    const name =
                        option
                            .querySelector('.technician-name')
                            ?.textContent
                            .toLowerCase() || '';

                    option.style.display =
                        name.includes(keyword)
                            ? 'flex'
                            : 'none';

                });

            });


            // Tampilkan efek visual saat teknisi dipilih
            const technicianOptions =
                document.querySelectorAll('.technician-option');

            function updateSelectedTechnician() {

                technicianOptions.forEach(function (option) {
                    option.classList.remove('selected');
                });

                const checked =
                    document.querySelector(
                        '.technician-option input[name="teknisi_id"]:checked'
                    );

                if (checked) {
                    checked.closest('.technician-option')
                        ?.classList.add('selected');
                }
            }

            technicianOptions.forEach(function (option) {

                const radio =
                    option.querySelector('input[name="teknisi_id"]');

                if (!radio) {
                    return;
                }

                radio.addEventListener('change', function () {
                    updateSelectedTechnician();
                });

                option.addEventListener('click', function () {
                    setTimeout(updateSelectedTechnician, 0);
                });

            });

            updateSelectedTechnician();

        });
    </script>

@endsection