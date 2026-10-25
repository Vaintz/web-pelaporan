@extends('layouts.dashboard')

@section('title', 'Detail Laporan')

@section('content')

<style>
    /* =========================================================
       PAGE TITLE
    ========================================================= */

    .page-title {
        margin-bottom: 20px;
    }

    .page-title h1 {
        margin: 0 0 5px;

        color: #16234a;

        font-size: 24px;
        line-height: 1.2;

        font-weight: 700;
    }

    .page-title p {
        margin: 0;

        color: #6f7890;

        font-size: 12px;
    }


    /* =========================================================
       MAIN CARD
    ========================================================= */

    .detail-card {
        width: 100%;

        box-sizing: border-box;

        background: #ffffff;

        border: 1px solid #dfe2e8;
        border-radius: 20px;

        padding: 14px 35px 30px;

        box-shadow:
            0 3px 4px rgba(0, 0, 0, 0.17);
    }


    /* =========================================================
       REPORT HEADER
    ========================================================= */

    .report-header {
        min-height: 62px;

        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding-bottom: 18px;

        border-bottom: 1px solid #e4e6eb;
    }

    .report-number {
        margin-bottom: 5px;

        color: #7b8293;

        font-size: 11px;

        font-weight: 600;
    }

    .report-title {
        margin: 0;

        color: #202235;

        font-size: 17px;

        line-height: 1.4;

        font-weight: 700;
    }


    /* =========================================================
       STATUS
    ========================================================= */

    .status-badge {
        min-width: 104px;
        height: 32px;

        padding: 0 14px;

        box-sizing: border-box;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        border-radius: 20px;

        font-size: 11px;

        font-weight: 700;

        white-space: nowrap;
    }

    .status-diajukan {
        background: #fff7d6;
        color: #9a7200;
    }

    .status-diproses {
        background: #e8f0ff;
        color: #3b63b8;
    }

    .status-selesai {
        background: #e5f8ed;
        color: #218653;
    }

    .status-ditolak {
        background: #ffe8e8;
        color: #c93636;
    }


    /* =========================================================
       SECTION
    ========================================================= */

    .detail-section {
        padding: 22px 0;

        border-bottom: 1px solid #e4e6eb;
    }

    .detail-section:last-of-type {
        border-bottom: 0;
    }


    /* =========================================================
       SECTION TITLE
    ========================================================= */

    .section-title {
        margin: 0 0 16px;

        display: flex;

        align-items: center;

        gap: 10px;

        color: #202235;

        font-size: 15px;

        line-height: 1.2;

        font-weight: 700;
    }

    .section-icon {
        width: 22px;
        height: 22px;

        flex-shrink: 0;

        display: flex;

        align-items: center;
        justify-content: center;

        color: #25253a;
    }

    .section-icon svg {
        width: 20px;
        height: 20px;

        stroke: currentColor;

        stroke-width: 2;

        fill: none;

        stroke-linecap: round;
        stroke-linejoin: round;
    }


    /* =========================================================
       INFORMATION GRID
    ========================================================= */

    .info-grid {
        display: grid;

        grid-template-columns: 1fr 1fr;

        column-gap: 55px;

        row-gap: 11px;
    }

    .info-row {
        display: grid;

        grid-template-columns: 130px 12px 1fr;

        align-items: center;

        min-width: 0;

        color: #252535;

        font-size: 12px;

        line-height: 1.4;
    }

    .info-label {
        font-weight: 700;

        white-space: nowrap;
    }

    .info-separator {
        text-align: center;

        font-weight: 700;
    }

    .info-value {
        min-width: 0;

        color: #303449;

        font-weight: 500;

        word-break: break-word;
    }


    /* =========================================================
       DESCRIPTION
    ========================================================= */

    .description-label {
        margin-bottom: 6px;

        color: #202235;

        font-size: 12px;

        font-weight: 700;
    }

    .description-box {
        width: 100%;

        min-height: 91px;

        box-sizing: border-box;

        padding: 12px 14px;

        background: #ffffff;

        border: 1px solid #aeb6c7;

        border-radius: 8px;

        color: #303449;

        font-size: 12px;

        line-height: 1.6;

        white-space: pre-line;
    }


    /* =========================================================
       LOCATION
    ========================================================= */

    .location-grid {
        display: grid;

        grid-template-columns: repeat(3, 1fr);

        column-gap: 19px;

        row-gap: 14px;
    }

    .location-group {
        min-width: 0;
    }

    .location-group.full {
        grid-column: 1 / -1;
    }

    .location-label {
        margin-bottom: 6px;

        color: #202235;

        font-size: 12px;

        font-weight: 700;
    }

    .location-value {
        width: 100%;

        min-height: 43px;

        box-sizing: border-box;

        padding: 0 14px;

        display: flex;

        align-items: center;

        background: #ffffff;

        border: 1px solid #aeb6c7;

        border-radius: 8px;

        color: #303449;

        font-size: 12px;

        line-height: 1.4;
    }


    /* =========================================================
       FOTO
    ========================================================= */

    .photo-grid {
        display: flex;

        flex-wrap: wrap;

        gap: 16px;
    }

    .photo-item {
        position: relative;

        width: 143px;
        height: 87px;

        overflow: hidden;

        box-sizing: border-box;

        background: #f3f4f6;

        border: 2px solid #25253a;

        border-radius: 9px;

        cursor: pointer;
    }

    .photo-item img {
        width: 100%;
        height: 100%;

        display: block;

        object-fit: cover;

        transition: transform .2s ease;
    }

    .photo-item:hover img {
        transform: scale(1.04);
    }

    .photo-overlay {
        position: absolute;

        left: 0;
        right: 0;
        bottom: 0;

        padding: 6px 5px;

        background: rgba(37, 36, 61, .78);

        color: #ffffff;

        text-align: center;

        font-size: 9px;

        opacity: 0;

        transition: opacity .2s ease;
    }

    .photo-item:hover .photo-overlay {
        opacity: 1;
    }

    .no-photo {
        min-height: 87px;

        box-sizing: border-box;

        display: flex;

        align-items: center;
        justify-content: center;

        border: 1px dashed #aeb6c7;

        border-radius: 9px;

        color: #929aae;

        font-size: 11px;
    }


    /* =========================================================
       STATUS NOTE
    ========================================================= */

    .status-note {
        margin-top: 15px;

        padding: 10px 12px;

        background: #f8f9fb;

        border: 1px solid #e2e5eb;

        border-radius: 7px;

        color: #70798b;

        font-size: 10px;

        line-height: 1.5;
    }

    .status-note strong {
        color: #252535;
    }


    /* =========================================================
       ACTION
    ========================================================= */

    .form-actions {
        display: flex;

        justify-content: flex-end;

        align-items: center;

        gap: 17px;

        margin-top: 20px;
    }

    .btn {
        height: 44px;

        box-sizing: border-box;

        padding: 0 24px;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        border-radius: 9px;

        font-family: inherit;

        font-size: 12px;

        font-weight: 700;

        text-decoration: none;

        cursor: pointer;
    }

    .btn-secondary {
        min-width: 120px;

        background: #ffffff;

        color: #252535;

        border: 2px solid #25253a;
    }

    .btn-secondary:hover {
        background: #fafafa;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 800px) {

        .detail-card {
            padding-left: 25px;
            padding-right: 25px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .location-grid {
            grid-template-columns: 1fr;
        }

        .location-group.full {
            grid-column: auto;
        }

    }


    @media (max-width: 600px) {

        .page-title h1 {
            font-size: 21px;
        }

        .detail-card {
            padding: 14px 18px 25px;

            border-radius: 14px;
        }

        .report-header {
            align-items: flex-start;

            flex-direction: column;
        }

        .report-title {
            font-size: 16px;
        }

        .info-row {
            grid-template-columns: 105px 10px 1fr;

            font-size: 10px;
        }

        .photo-item {
            width: calc(50% - 8px);
            height: 100px;
        }

    }

    /* Tambahan responsif untuk layar kecil */
    .detail-wrapper {
        width: 100%;
        min-width: 0;
    }

    .detail-card,
    .report-header,
    .detail-section,
    .info-grid,
    .location-grid {
        min-width: 0;
        max-width: 100%;
    }

    .report-title,
    .info-value,
    .location-value,
    .description-box,
    .status-note {
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    @media (max-width: 800px) {
        .info-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .location-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .location-group.full {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 600px) {
        .detail-card {
            padding: 14px 16px 22px;
        }

        .report-header {
            gap: 12px;
            padding-bottom: 15px;
        }

        .report-header > div {
            width: 100%;
            min-width: 0;
        }

        .status-badge {
            max-width: 100%;
            min-width: 0;
            height: auto;
            padding: 7px 12px;
            white-space: normal;
            line-height: 1.3;
            text-align: center;
        }

        .detail-section {
            padding: 18px 0;
        }

        .info-row {
            grid-template-columns: 105px 10px minmax(0, 1fr);
            align-items: start;
            font-size: 11px;
        }

        .info-label {
            white-space: normal;
            overflow-wrap: anywhere;
        }

        .location-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .location-group.full {
            grid-column: auto;
        }

        .location-value {
            min-height: 40px;
            padding: 9px 12px;
        }

        .photo-grid {
            gap: 10px;
        }

        .photo-item {
            width: calc(50% - 5px);
            height: 105px;
        }

        .photo-overlay {
            display: none;
        }

        .form-actions .btn {
            width: 100%;
            min-width: 0;
            min-height: 44px;
            padding: 10px 16px;
            text-align: center;
        }
    }

    @media (max-width: 360px) {
        .detail-card {
            padding-left: 12px;
            padding-right: 12px;
        }

        .info-row {
            grid-template-columns: 88px 8px minmax(0, 1fr);
            font-size: 10px;
        }

        .photo-item {
            width: 100%;
            height: 150px;
        }
    }

</style>


<div class="detail-wrapper">


    {{-- =====================================================
       PAGE TITLE
    ====================================================== --}}

    <div class="page-title">

        <h1>
            Detail Laporan
        </h1>

        <p>
            Informasi lengkap mengenai laporan kerusakan yang diajukan.
        </p>

    </div>


    {{-- =====================================================
       MAIN CARD
    ====================================================== --}}

    <div class="detail-card">


        {{-- =================================================
           HEADER
        ================================================== --}}

        <div class="report-header">

            <div>

                <div class="report-number">

                    {{ $laporan->nomor_laporan
                        ?? 'LP-' . now()->format('Y') . '-' . str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}

                </div>

                <h2 class="report-title">

                    {{ $laporan->judul_laporan }}

                </h2>

            </div>


            @php

                $statusClass = match($laporan->status) {

                    'diajukan' => 'status-diajukan',

                    'diproses' => 'status-diproses',

                    'selesai' => 'status-selesai',

                    'ditolak' => 'status-ditolak',

                    default => 'status-diajukan',

                };

            @endphp


            <span class="status-badge {{ $statusClass }}">

                {{ ucwords(str_replace('_', ' ', $laporan->status ?? 'Diajukan')) }}

            </span>

        </div>


        {{-- =================================================
           1. INFORMASI LAPORAN
        ================================================== --}}

        <div class="detail-section">

            <div class="section-title">

                <span class="section-icon">

                    <svg viewBox="0 0 24 24">

                        <rect
                            x="4"
                            y="3"
                            width="16"
                            height="18"
                            rx="2">
                        </rect>

                        <line
                            x1="8"
                            y1="8"
                            x2="16"
                            y2="8">
                        </line>

                        <line
                            x1="8"
                            y1="12"
                            x2="16"
                            y2="12">
                        </line>

                        <line
                            x1="8"
                            y1="16"
                            x2="13"
                            y2="16">
                        </line>

                    </svg>

                </span>

                <span>
                    1. Informasi Laporan
                </span>

            </div>


            <div class="info-grid">


                <div class="info-row">

                    <span class="info-label">
                        Nomor Laporan
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span class="info-value">
                        {{ $laporan->nomor_laporan ?? '-' }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Tanggal Laporan
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span class="info-value">

                        {{ $laporan->created_at
                            ? $laporan->created_at->translatedFormat('d F Y, H:i')
                            : '-' }}

                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Kategori
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span class="info-value">
                        {{ $laporan->kategori->nama ?? '-' }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Status
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span class="info-value">
                        {{ ucwords(str_replace('_', ' ', $laporan->status ?? '-')) }}
                    </span>

                </div>

            </div>

        </div>


        {{-- =================================================
           2. INFORMASI KERUSAKAN
        ================================================== --}}

        <div class="detail-section">

            <div class="section-title">

                <span class="section-icon">

                    <svg viewBox="0 0 24 24">

                        <path d="M6 3h9l3 3v15H6z"></path>

                        <path d="M14 3v4h4"></path>

                        <line
                            x1="9"
                            y1="11"
                            x2="15"
                            y2="11">
                        </line>

                        <line
                            x1="9"
                            y1="15"
                            x2="15"
                            y2="15">
                        </line>

                    </svg>

                </span>

                <span>
                    2. Informasi Kerusakan
                </span>

            </div>


            <div class="description-label">
                Deskripsi Kerusakan
            </div>


            <div class="description-box">

                {{ $laporan->deskripsi_kerusakan ?? '-' }}

            </div>

        </div>


        {{-- =================================================
           3. LOKASI KERUSAKAN
        ================================================== --}}

        <div class="detail-section">

            <div class="section-title">

                <span class="section-icon">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0z">
                        </path>

                        <circle
                            cx="12"
                            cy="10"
                            r="2.5">
                        </circle>

                    </svg>

                </span>

                <span>
                    3. Lokasi Kerusakan
                </span>

            </div>


            <div class="location-grid">


                {{-- GEDUNG --}}

                <div class="location-group">

                    <div class="location-label">
                        Gedung
                    </div>

                    <div class="location-value">

                        {{ $laporan->gedung->nama ?? '-' }}

                    </div>

                </div>


                {{-- LANTAI --}}

                <div class="location-group">

                    <div class="location-label">
                        Lantai
                    </div>

                    <div class="location-value">

                        {{ $laporan->lantai ? (preg_match('/^lantai\s*/i', trim($laporan->lantai)) ? trim($laporan->lantai) : 'Lantai ' . trim($laporan->lantai)) : '-' }}

                    </div>

                </div>


                {{-- RUANGAN --}}

                <div class="location-group">

                    <div class="location-label">
                        Ruangan
                    </div>

                    <div class="location-value">

                        {{ $laporan->ruangan ?? '-' }}

                    </div>

                </div>


                {{-- DETAIL LOKASI --}}

                <div class="location-group full">

                    <div class="location-label">
                        Detail Lokasi
                    </div>

                    <div class="location-value">

                        {{ $laporan->detail_lokasi ?? '-' }}

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
           4. INFORMASI PELAPOR
        ================================================== --}}

        <div class="detail-section">

            <div class="section-title">

                <span class="section-icon">

                    <svg viewBox="0 0 24 24">

                        <circle
                            cx="12"
                            cy="8"
                            r="3.5">
                        </circle>

                        <path
                            d="M5 21c.8-4 3.1-6 7-6s6.2 2 7 6">
                        </path>

                    </svg>

                </span>

                <span>
                    4. Informasi Pelapor
                </span>

            </div>


            <div class="info-grid">


                <div class="info-row">

                    <span class="info-label">
                        Nama Lengkap
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span class="info-value">
                        {{ $laporan->user->name ?? '-' }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Program Studi
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span class="info-value">
                        {{ $laporan->user->program_studi ?? '-' }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        NIM / NIP
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span class="info-value">
                        {{ $laporan->user->nim_nip ?? '-' }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Email
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span class="info-value">
                        {{ $laporan->user->email ?? '-' }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Fakultas
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span class="info-value">
                        {{ $laporan->user->fakultas ?? '-' }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Nomor HP
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span class="info-value">
                        {{ $laporan->user->no_hp ?? '-' }}
                    </span>

                </div>

            </div>

        </div>


        {{-- =================================================
           5. BUKTI KERUSAKAN
        ================================================== --}}

        <div class="detail-section">

            <div class="section-title">

                <span class="section-icon">

                    <svg viewBox="0 0 24 24">

                        <path d="M4 7h4l2-2h4l2 2h4v12H4z"></path>

                        <circle
                            cx="12"
                            cy="13"
                            r="3.5">
                        </circle>

                    </svg>

                </span>

                <span>
                    5. Bukti Kerusakan (Foto)
                </span>

            </div>


            @if($laporan->foto && $laporan->foto->count() > 0)

                <div class="photo-grid">

                    @foreach($laporan->foto as $foto)

                        <div
                            class="photo-item"
                            onclick="window.open('{{ asset('storage/' . $foto->foto) }}', '_blank')"
                        >

                            <img
                                src="{{ asset('storage/' . $foto->foto) }}"
                                alt="Bukti kerusakan"
                            >

                            <div class="photo-overlay">
                                Klik untuk melihat foto
                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="no-photo">
                    Tidak ada foto yang dilampirkan.
                </div>

            @endif

        </div>


        {{-- =================================================
           STATUS NOTE
        ================================================== --}}

        @if($laporan->status === 'diajukan')

            <div class="status-note">

                <strong>Status laporan:</strong>
                Laporan telah berhasil diajukan dan menunggu proses verifikasi oleh admin.

            </div>

        @elseif($laporan->status === 'diproses')

            <div class="status-note">

                <strong>Status laporan:</strong>
                Laporan sedang dalam proses penanganan.

            </div>

        @elseif($laporan->status === 'selesai')

            <div class="status-note">

                <strong>Status laporan:</strong>
                Laporan telah selesai ditangani.

            </div>

        @elseif($laporan->status === 'ditolak')

            <div class="status-note">

                <strong>Status laporan:</strong>
                Laporan tidak dapat diproses.

            </div>

        @endif


    </div>


    {{-- =====================================================
       ACTION
    ====================================================== --}}

    <div class="form-actions">

        <a
            href="{{ route('pelapor.riwayat') }}"
            class="btn btn-secondary"
        >
            Kembali ke Riwayat
        </a>

    </div>


</div>

@endsection