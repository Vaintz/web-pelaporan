@extends('layouts.dashboard')

@section('title', 'Detail Riwayat Laporan')

@section('content')

<style>
    .detail-wrapper {
        max-width: 1100px;
        margin: 0 auto;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #777d8c;
        text-decoration: none;
        font-size: 12px;
        margin-bottom: 18px;
    }

    .back-link:hover {
        color: #25243d;
    }

    .back-link svg {
        width: 16px;
        height: 16px;
    }

    .detail-header {
        background: #fff;
        border: 1px solid #e0e3e9;
        border-radius: 16px;
        padding: 22px 24px;
        margin-bottom: 18px;
        box-shadow: 0 2px 4px rgba(0,0,0,.06);
    }

    .header-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
    }

    .header-label {
        color: #9096a3;
        font-size: 11px;
        margin-bottom: 6px;
    }

    .header-number {
        color: #202235;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .header-title {
        color: #737989;
        font-size: 12px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 90px;
        height: 32px;
        padding: 0 13px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
    }

    .status-selesai {
        background: #dcf2e3;
        color: #15833f;
    }

    .status-ditolak {
        background: #ffe0e0;
        color: #e52e2e;
    }

    .section-card {
        background: #fff;
        border: 1px solid #e0e3e9;
        border-radius: 16px;
        margin-bottom: 18px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,.06);
    }

    .section-header {
        padding: 17px 22px;
        border-bottom: 1px solid #e6e8ed;
    }

    .section-title {
        margin: 0;
        color: #25263a;
        font-size: 14px;
        font-weight: 700;
    }

    .section-content {
        padding: 22px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px 28px;
    }

    .info-item.full {
        grid-column: 1 / -1;
    }

    .info-label {
        color: #9298a5;
        font-size: 10px;
        margin-bottom: 6px;
    }

    .info-value {
        color: #343746;
        font-size: 12px;
        line-height: 1.6;
    }

    .description-box {
        padding: 14px 16px;
        background: #f8f9fb;
        border: 1px solid #e4e6eb;
        border-radius: 9px;
        color: #555b69;
        font-size: 12px;
        line-height: 1.7;
    }

    .location-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .location-item {
        padding: 14px;
        background: #f8f9fb;
        border: 1px solid #e4e6eb;
        border-radius: 9px;
    }

    .location-label {
        color: #969ba7;
        font-size: 10px;
        margin-bottom: 5px;
    }

    .location-value {
        color: #353847;
        font-size: 12px;
        font-weight: 600;
    }

    .verification-box {
        padding: 17px;
        border: 1px solid #e2e5ea;
        border-radius: 10px;
        background: #fafbfc;
    }

    .verification-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .priority-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 700;
    }

    .priority-rendah {
        background: #e9f3ff;
        color: #3978b8;
    }

    .priority-sedang {
        background: #fff1d9;
        color: #bd7911;
    }

    .priority-tinggi {
        background: #ffe1e1;
        color: #d93434;
    }

    .note-box {
        padding: 14px 16px;
        background: #fff;
        border: 1px solid #e2e5ea;
        border-radius: 9px;
        color: #555b69;
        font-size: 12px;
        line-height: 1.7;
    }

    .technician-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 17px;
        background: #f8f9fb;
        border: 1px solid #e2e5ea;
        border-radius: 10px;
        margin-bottom: 18px;
    }

    .technician-icon {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: #e9e8f5;
        color: #4d4a78;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .technician-icon svg {
        width: 23px;
        height: 23px;
    }

    .technician-label {
        color: #959aa6;
        font-size: 10px;
        margin-bottom: 4px;
    }

    .technician-name {
        color: #303342;
        font-size: 13px;
        font-weight: 700;
    }

    .assignment-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .assignment-item {
        padding: 14px;
        border: 1px solid #e3e5ea;
        border-radius: 9px;
        background: #fff;
    }

    .assignment-label {
        color: #969ba7;
        font-size: 10px;
        margin-bottom: 5px;
    }

    .assignment-value {
        color: #363847;
        font-size: 12px;
        font-weight: 600;
    }

    .instruction-box {
        margin-top: 18px;
    }

    .result-box {
        padding: 18px;
        border-radius: 10px;
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    .result-success {
        background: #edf8f1;
        border: 1px solid #d2ecd9;
    }

    .result-danger {
        background: #fff0f0;
        border: 1px solid #f1d2d2;
    }

    .result-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .result-success .result-icon {
        background: #d9f0e0;
        color: #168342;
    }

    .result-danger .result-icon {
        background: #ffdede;
        color: #d83232;
    }

    .result-icon svg {
        width: 20px;
        height: 20px;
    }

    .result-title {
        color: #303342;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .result-text {
        color: #656b78;
        font-size: 11px;
        line-height: 1.6;
    }

    .photo-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .photo-item {
        aspect-ratio: 1 / 1;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e1e4e9;
        background: #f5f6f8;
    }

    .photo-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .empty-photo {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #a4a9b3;
        font-size: 10px;
    }

    @media (max-width: 800px) {

        .info-grid,
        .verification-grid {
            grid-template-columns: 1fr;
        }

        .info-item.full {
            grid-column: auto;
        }

        .location-grid,
        .assignment-grid {
            grid-template-columns: 1fr;
        }

        .photo-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .header-top {
            flex-direction: column;
        }
    }
</style>


<div class="detail-wrapper">

    {{-- KEMBALI --}}

    <a
        href="{{ route('admin.biro.riwayat') }}"
        class="back-link"
    >

        <svg viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round">

            <path d="m15 18-6-6 6-6"/>

        </svg>

        Kembali ke Riwayat Laporan

    </a>


    {{-- HEADER --}}

    <div class="detail-header">

        <div class="header-top">

            <div>

                <div class="header-label">
                    Nomor Laporan
                </div>

                <div class="header-number">
                    {{ $laporan->nomor_laporan }}
                </div>

                <div class="header-title">
                    {{ $laporan->judul_laporan }}
                </div>

            </div>


            <div>

                @if($laporan->status === 'selesai')

                    <span class="status-badge status-selesai">
                        Selesai
                    </span>

                @elseif($laporan->status === 'ditolak')

                    <span class="status-badge status-ditolak">
                        Ditolak
                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- =========================
         INFORMASI LAPORAN
    ========================== --}}

    <div class="section-card">

        <div class="section-header">

            <h2 class="section-title">
                Informasi Laporan
            </h2>

        </div>

        <div class="section-content">

            <div class="info-grid">

                <div class="info-item">

                    <div class="info-label">
                        Judul Laporan
                    </div>

                    <div class="info-value">
                        {{ $laporan->judul_laporan }}
                    </div>

                </div>


                <div class="info-item">

                    <div class="info-label">
                        Kategori Kerusakan
                    </div>

                    <div class="info-value">
                        {{ $laporan->kategori->nama ?? '-' }}
                    </div>

                </div>


                <div class="info-item">

                    <div class="info-label">
                        Pelapor
                    </div>

                    <div class="info-value">
                        {{ $laporan->user->name ?? '-' }}
                    </div>

                </div>


                <div class="info-item">

                    <div class="info-label">
                        Tanggal Laporan
                    </div>

                    <div class="info-value">
                        {{ $laporan->created_at
                            ? $laporan->created_at->format('d F Y')
                            : '-' }}
                    </div>

                </div>


                <div class="info-item full">

                    <div class="info-label">
                        Detail Lokasi
                    </div>

                    <div class="location-grid">

                        <div class="location-item">

                            <div class="location-label">
                                Gedung
                            </div>

                            <div class="location-value">
                                {{ $laporan->gedung->nama ?? '-' }}
                            </div>

                        </div>


                        <div class="location-item">

                            <div class="location-label">
                                Ruangan
                            </div>

                            <div class="location-value">
                                {{ $laporan->ruangan ?? '-' }}
                            </div>

                        </div>


                        <div class="location-item">

                            <div class="location-label">
                                Detail Lokasi
                            </div>

                            <div class="location-value">
                                {{ $laporan->detail_lokasi ?? '-' }}
                            </div>

                        </div>

                    </div>

                </div>


                <div class="info-item full">

                    <div class="info-label">
                        Deskripsi Kerusakan
                    </div>

                    <div class="description-box">
                        {{ $laporan->deskripsi_kerusakan ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
         FOTO LAPORAN
    ========================== --}}

    @if($laporan->foto && $laporan->foto->count())

        <div class="section-card">

            <div class="section-header">

                <h2 class="section-title">
                    Foto Laporan
                </h2>

            </div>

            <div class="section-content">

                <div class="photo-grid">

                    @foreach($laporan->foto as $foto)

                        <div class="photo-item">

                            <img
                                src="{{ asset('storage/' . $foto->foto) }}"
                                alt="Foto laporan"
                            >

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    @endif


    {{-- =========================
         VERIFIKASI ADMIN FAKULTAS
    ========================== --}}

    <div class="section-card">

        <div class="section-header">

            <h2 class="section-title">
                Verifikasi Admin Fakultas
            </h2>

        </div>

        <div class="section-content">

            <div class="verification-box">

                <div class="verification-grid">

                    <div>

                        <div class="info-label">
                            Status Verifikasi
                        </div>

                        <div class="info-value">
                            Laporan telah diverifikasi oleh Admin Fakultas.
                        </div>

                    </div>


                    <div>

                        <div class="info-label">
                            Catatan Verifikasi
                        </div>

                        <div class="note-box">
                            {{ $laporan->catatan_verifikasi ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
         VERIFIKASI ADMIN BIRO
    ========================== --}}

    @if(
        $laporan->prioritas ||
        $laporan->catatan_verifikasi_biro ||
        $laporan->diverifikasi_biro_at
    )

        <div class="section-card">

            <div class="section-header">

                <h2 class="section-title">
                    Verifikasi Admin Biro
                </h2>

            </div>

            <div class="section-content">

                <div class="verification-box">

                    <div class="verification-grid">

                        {{-- PRIORITAS --}}

                        <div>

                            <div class="info-label">
                                Prioritas
                            </div>

                            @if($laporan->prioritas === 'tinggi')

                                <span class="priority-badge priority-tinggi">
                                    Tinggi
                                </span>

                            @elseif($laporan->prioritas === 'sedang')

                                <span class="priority-badge priority-sedang">
                                    Sedang
                                </span>

                            @elseif($laporan->prioritas === 'rendah')

                                <span class="priority-badge priority-rendah">
                                    Rendah
                                </span>

                            @else

                                <span class="info-value">
                                    -
                                </span>

                            @endif

                        </div>


                        {{-- TANGGAL VERIFIKASI --}}

                        <div>

                            <div class="info-label">
                                Tanggal Verifikasi
                            </div>

                            <div class="info-value">

                                @if($laporan->diverifikasi_biro_at)

                                    {{ $laporan->diverifikasi_biro_at
                                        ->format('d F Y, H:i') }}

                                @else

                                    -

                                @endif

                            </div>

                        </div>


                        {{-- CATATAN --}}

                        <div class="info-item full">

                            <div class="info-label">
                                Catatan Verifikasi Biro
                            </div>

                            <div class="note-box">
                                {{ $laporan->catatan_verifikasi_biro ?? '-' }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- =========================
         PENUGASAN TEKNISI
    ========================== --}}

    @if($laporan->teknisi_id)

        <div class="section-card">

            <div class="section-header">

                <h2 class="section-title">
                    Penugasan Teknisi
                </h2>

            </div>

            <div class="section-content">

                {{-- TEKNISI --}}

                <div class="technician-card">

                    <div class="technician-icon">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round">

                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>

                            <circle cx="12" cy="7" r="4"/>

                        </svg>

                    </div>

                    <div>

                        <div class="technician-label">
                            Teknisi yang Ditugaskan
                        </div>

                        <div class="technician-name">
                            {{ $laporan->teknisi->nama ?? '-' }}
                        </div>

                    </div>

                </div>


                <div class="assignment-grid">

                    {{-- TANGGAL PENUGASAN --}}

                    <div class="assignment-item">

                        <div class="assignment-label">
                            Tanggal Penugasan
                        </div>

                        <div class="assignment-value">

                            @if($laporan->tanggal_penugasan)

                                {{ $laporan->tanggal_penugasan
                                    ->format('d F Y') }}

                            @else

                                -

                            @endif

                        </div>

                    </div>


                    {{-- TARGET SELESAI --}}

                    <div class="assignment-item">

                        <div class="assignment-label">
                            Target Selesai
                        </div>

                        <div class="assignment-value">

                            @if($laporan->target_selesai)

                                {{ $laporan->target_selesai
                                    ->format('d F Y') }}

                            @else

                                -

                            @endif

                        </div>

                    </div>


                    {{-- STATUS --}}

                    <div class="assignment-item">

                        <div class="assignment-label">
                            Status Penanganan
                        </div>

                        <div class="assignment-value">

                            @if($laporan->status === 'selesai')

                                Selesai

                            @elseif($laporan->status === 'ditolak')

                                Ditolak

                            @else

                                -

                            @endif

                        </div>

                    </div>

                </div>


                {{-- INSTRUKSI --}}

                <div class="instruction-box">

                    <div class="info-label">
                        Instruksi Teknisi
                    </div>

                    <div class="note-box">
                        {{ $laporan->instruksi_teknisi ?? '-' }}
                    </div>

                </div>

                {{-- DESKRIPSI TINDAK LANJUT DARI ADMIN BIRO --}}

                @if($laporan->status === 'selesai')
                    <div class="instruction-box">

                        <div class="info-label">
                            Deskripsi Tindak Lanjut
                        </div>

                        <div class="note-box">
                            {{ $laporan->deskripsi_tindak_lanjut ?? 'Belum ada deskripsi tindak lanjut.' }}
                        </div>

                    </div>
                @endif

            </div>

        </div>

    @endif


    {{-- =========================
         HASIL AKHIR
    ========================== --}}

    <div class="section-card">

        <div class="section-header">

            <h2 class="section-title">
                Hasil Penanganan
            </h2>

        </div>

        <div class="section-content">

            @if($laporan->status === 'selesai')

                <div class="result-box result-success">

                    <div class="result-icon">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round">

                            <path d="m5 12 4 4L19 6"/>

                        </svg>

                    </div>

                    <div>

                        <div class="result-title">
                            Laporan Telah Selesai
                        </div>

                        <div class="result-text">
                            Laporan telah selesai ditangani dan telah masuk
                            ke dalam riwayat laporan.
                        </div>

                    </div>

                </div>

            @elseif($laporan->status === 'ditolak')

                <div class="result-box result-danger">

                    <div class="result-icon">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round">

                            <circle cx="12" cy="12" r="9"/>
                            <path d="m9 9 6 6"/>
                            <path d="m15 9-6 6"/>

                        </svg>

                    </div>

                    <div>

                        <div class="result-title">
                            Laporan Ditolak
                        </div>

                        <div class="result-text">
                            Laporan ini tidak dilanjutkan ke proses
                            penanganan dan telah masuk ke dalam riwayat laporan.
                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection