@extends('layouts.dashboard')

@section('title', 'Detail Berita Acara')

@section('content')

@php
    $user = $laporan->user;
    $teknisi = $laporan->teknisi;

    $nomorBeritaAcara = 'BA/UM/' . $laporan->nomor_laporan;

    $tanggalLaporan = $laporan->created_at;

    $tanggalVerifikasiBiro =
        $laporan->diverifikasi_biro_at;

    $tanggalPenugasan =
        $laporan->tanggal_penugasan;

    $targetSelesai =
        $laporan->target_selesai;

    $lokasi = collect([
        $laporan->gedung?->nama,
        $laporan->ruangan,
        $laporan->detail_lokasi,
    ])->filter()->implode(' ');

    $statusLabel = 'Selesai';
@endphp

<style>
    .ba-detail-page {
        padding: 8px 4px 40px;
    }

    .ba-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 22px;
    }

    .ba-header-left {
        flex: 1;
    }

    .ba-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        color: #25243a;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .ba-breadcrumb-arrow {
        font-size: 20px;
    }

    .ba-detail-title {
        margin: 0;
        color: #25243a;
        font-size: 25px;
        font-weight: 800;
    }

    .ba-detail-subtitle {
        margin: 5px 0 12px;
        color: #9295a5;
        font-size: 13px;
    }

    .ba-number-status {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .ba-report-number {
        color: #25243a;
        font-size: 19px;
        font-weight: 800;
    }

    .ba-status-valid {
        display: inline-flex;
        align-items: center;
        padding: 6px 16px;
        border: 1px solid #43a85f;
        border-radius: 8px;
        background: #e5f8e9;
        color: #18752e;
        font-size: 12px;
        font-weight: 800;
    }

    .ba-header-actions {
        display: flex;
        gap: 8px;
        padding-top: 31px;
    }

    .ba-action {
        height: 38px;
        padding: 0 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border: 1px solid #25243a;
        border-radius: 9px;
        background: #fff;
        color: #25243a;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
    }

    .ba-action-primary {
        background: #25243a;
        color: #fff;
    }

    .ba-detail-layout {
        display: grid;
        grid-template-columns: minmax(480px, 1fr) minmax(480px, 1fr);
        gap: 18px;
        align-items: start;
    }

    .ba-detail-left {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .ba-info-card {
        background: #fff;
        border: 1px solid #dedee5;
        border-radius: 11px;
        padding: 17px 25px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .11);
    }

    .ba-card-title {
        margin: 0 0 13px;
        color: #25243a;
        font-size: 14px;
        font-weight: 800;
    }

    .ba-info-grid {
        display: grid;
        grid-template-columns: 150px 14px 1fr;
        row-gap: 9px;
        font-size: 12px;
        line-height: 1.45;
    }

    .ba-label {
        color: #25243a;
        font-weight: 800;
    }

    .ba-colon {
        text-align: center;
        color: #25243a;
        font-weight: 800;
    }

    .ba-value {
        color: #25243a;
        font-weight: 600;
        word-break: break-word;
    }

    .ba-description {
        white-space: pre-line;
        line-height: 1.55;
    }

    .ba-small-status {
        display: inline-flex;
        padding: 5px 12px;
        border-radius: 7px;
        background: #e5f8e9;
        color: #25803a;
        font-size: 11px;
        font-weight: 800;
    }

    .ba-photo-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .ba-photo {
        position: relative;
        width: 112px;
        height: 78px;
        overflow: hidden;
        border: 2px solid #25243a;
        border-radius: 9px;
        background: #f4f4f5;
        cursor: pointer;
    }

    .ba-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ba-photo-icon {
        position: absolute;
        right: 4px;
        bottom: 4px;
        width: 17px;
        height: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #25243a;
        color: #fff;
        font-size: 9px;
    }

    .ba-no-photo {
        color: #9295a5;
        font-size: 12px;
    }

    .ba-document-area {
        position: sticky;
        top: 20px;
    }

    .ba-document {
        width: 100%;
        min-height: 710px;
        box-sizing: border-box;
        padding: 28px 55px;
        border: 1px solid #333;
        background: #fff;
        color: #111;
        font-family: "Times New Roman", serif;
        font-size: 9.5px;
        line-height: 1.35;
    }

    .ba-doc-header {
        display: flex;
        align-items: center;
        padding-bottom: 7px;
        border-bottom: 2px solid #111;
    }

    .ba-doc-logo {
        width: 55px;
        height: 55px;
        margin-right: 12px;
        object-fit: contain;
    }

    .ba-doc-head-text {
        flex: 1;
        text-align: center;
        line-height: 1.2;
    }

    .ba-doc-head-text .university {
        font-size: 12px;
        font-weight: bold;
    }

    .ba-doc-title {
        margin-top: 17px;
        margin-bottom: 3px;
        text-align: center;
        font-size: 11px;
        font-weight: bold;
    }

    .ba-doc-number {
        margin-bottom: 18px;
        text-align: center;
    }

    .ba-doc-paragraph {
        margin: 0 0 10px;
        text-align: justify;
    }

    .ba-doc-table {
        width: 100%;
        margin: 5px 0 11px;
        border-collapse: collapse;
    }

    .ba-doc-table td {
        padding: 1px 0;
        vertical-align: top;
    }

    .ba-doc-table td:first-child {
        width: 135px;
    }

    .ba-doc-signature {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 45px;
        margin-top: 25px;
        text-align: center;
    }

    .ba-signature-space {
        height: 45px;
    }

    .ba-signature-name {
        font-weight: bold;
    }

    .ba-doc-footer-date {
        margin-top: 15px;
        text-align: right;
    }

    .ba-print-note {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-top: 10px;
        padding: 12px 16px;
        border: 1px solid #6687ff;
        border-radius: 9px;
        background: #f0f4ff;
        color: #9196a7;
        font-size: 11px;
    }

    .ba-print-icon {
        width: 24px;
        height: 24px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #315cff;
        border-radius: 50%;
        color: #315cff;
        font-weight: 800;
    }

    @media (max-width: 1100px) {
        .ba-detail-layout {
            grid-template-columns: 1fr;
        }

        .ba-document-area {
            position: static;
        }
    }

    @media (max-width: 700px) {
        .ba-detail-header {
            flex-direction: column;
        }

        .ba-header-actions {
            padding-top: 0;
            flex-wrap: wrap;
        }

        .ba-detail-layout {
            grid-template-columns: 1fr;
        }
    }

    @media print {

        body * {
            visibility: hidden !important;
        }

        .ba-document,
        .ba-document * {
            visibility: visible !important;
        }

        .ba-document {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            min-height: auto;
            border: none;
            box-shadow: none;
        }

        @page {
            size: A4;
            margin: 15mm;
        }
    }
</style>

<div class="ba-detail-page">

    {{-- HEADER --}}
    <div class="ba-detail-header">

        <div class="ba-header-left">

            <div
                class="ba-breadcrumb"
                onclick="history.back()"
            >
                <span class="ba-breadcrumb-arrow">←</span>
                Berita Acara / Detail Berita Acara
            </div>

            <h1 class="ba-detail-title">
                Berita Acara Laporan
            </h1>

            <p class="ba-detail-subtitle">
                Berikut adalah berita acara dari laporan yang telah diverifikasi dan ditangani.
            </p>

            <div class="ba-number-status">

                <div class="ba-report-number">
                    {{ $laporan->nomor_laporan }}
                </div>

                <div class="ba-status-valid">
                    Telah Ditangani
                </div>

            </div>

        </div>

        <div class="ba-header-actions">

            <button
                type="button"
                class="ba-action"
                onclick="history.back()"
            >
                ← &nbsp; Kembali
            </button>

            <button
                type="button"
                class="ba-action"
                onclick="window.print()"
            >
                ◉ &nbsp; Preview
            </button>

            <button
                type="button"
                class="ba-action ba-action-primary"
                onclick="window.print()"
            >
                ▣ &nbsp; Cetak Berita Acara
            </button>

        </div>

    </div>


    <div class="ba-detail-layout">

        <div class="ba-detail-left">

            {{-- INFORMASI BA --}}
            <div class="ba-info-card">

                <h3 class="ba-card-title">
                    INFORMASI BERITA ACARA
                </h3>

                <div class="ba-info-grid">

                    <div class="ba-label">Nomor Berita Acara</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $nomorBeritaAcara }}
                    </div>

                    <div class="ba-label">Tanggal Dibuat</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $tanggalLaporan?->translatedFormat('d F Y') ?? '-' }}
                    </div>

                    <div class="ba-label">Nomor Laporan</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $laporan->nomor_laporan }}
                    </div>

                    <div class="ba-label">Judul Laporan</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $laporan->judul_laporan ?? '-' }}
                    </div>

                    <div class="ba-label">Kategori Laporan</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $laporan->kategori?->nama ?? '-' }}
                    </div>

                </div>

            </div>


            {{-- INFORMASI PELAPOR --}}
            <div class="ba-info-card">

                <h3 class="ba-card-title">
                    INFORMASI PELAPOR
                </h3>

                <div class="ba-info-grid">

                    <div class="ba-label">Nama</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $user?->name ?? '-' }}
                    </div>

                    <div class="ba-label">NIM/NIP</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $user?->nim_nip ?? '-' }}
                    </div>

                    <div class="ba-label">Fakultas</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $user?->fakultas ?? '-' }}
                    </div>

                    <div class="ba-label">Unit / Program Studi</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $user?->program_studi ?? '-' }}
                    </div>

                </div>

            </div>


            {{-- URAIAN LAPORAN --}}
            <div class="ba-info-card">

                <h3 class="ba-card-title">
                    URAIAN LAPORAN
                </h3>

                <div class="ba-info-grid">

                    <div class="ba-label">Tanggal Laporan</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $tanggalLaporan?->translatedFormat('d F Y') ?? '-' }}
                    </div>

                    <div class="ba-label">Lokasi Kejadian</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $lokasi ?: '-' }}
                    </div>

                    <div class="ba-label">Kronologi / Deskripsi</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value ba-description">
                        {{ $laporan->deskripsi_kerusakan ?? '-' }}
                    </div>

                </div>

            </div>


            {{-- HASIL VERIFIKASI FAKULTAS --}}
            <div class="ba-info-card">

                <h3 class="ba-card-title">
                    HASIL VERIFIKASI FAKULTAS
                </h3>

                <div class="ba-info-grid">

                    <div class="ba-label">Status Verifikasi</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        <span class="ba-small-status">
                            Valid
                        </span>
                    </div>

                    <div class="ba-label">Catatan Verifikasi</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $laporan->catatan_verifikasi ?? '-' }}
                    </div>

                    <div class="ba-label">Admin Fakultas</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        Tidak tersimpan pada data laporan
                    </div>

                    <div class="ba-label">Tanggal Verifikasi</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        Tidak tersimpan pada data laporan
                    </div>

                </div>

            </div>


            {{-- INFORMASI PENANGANAN --}}
            <div class="ba-info-card">

                <h3 class="ba-card-title">
                    INFORMASI PENANGANAN
                </h3>

                <div class="ba-info-grid">

                    <div class="ba-label">Tanggal Verifikasi Biro</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $tanggalVerifikasiBiro?->translatedFormat('d F Y') ?? '-' }}
                    </div>

                    <div class="ba-label">Ditugaskan Kepada</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $teknisi?->nama ?? '-' }}
                    </div>

                    <div class="ba-label">Instruksi Penanganan</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        {{ $laporan->instruksi_teknisi ?? '-' }}
                    </div>

                    <div class="ba-label">Tanggal Penanganan</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">

                        @if($tanggalPenugasan && $targetSelesai)

                            {{ $tanggalPenugasan->translatedFormat('d F Y') }}
                            -
                            {{ $targetSelesai->translatedFormat('d F Y') }}

                        @elseif($tanggalPenugasan)

                            {{ $tanggalPenugasan->translatedFormat('d F Y') }}

                        @else

                            -

                        @endif

                    </div>

                    <div class="ba-label">Status</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        <span class="ba-small-status">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="ba-label">Hasil</div>
                    <div class="ba-colon">:</div>
                    <div class="ba-value">
                        Laporan telah diselesaikan.
                    </div>

                </div>

            </div>


            {{-- DESKRIPSI TINDAK LANJUT --}}
            <div class="ba-info-card">

                <h3 class="ba-card-title">
                    DESKRIPSI TINDAK LANJUT
                </h3>

                <div class="ba-value ba-description">
                    {{ $laporan->deskripsi_tindak_lanjut ?? 'Belum ada deskripsi tindak lanjut.' }}
                </div>

            </div>
        </div>


        {{-- ============================= --}}
        {{-- DOKUMEN --}}
        {{-- ============================= --}}

        <div class="ba-document-area">

            <div class="ba-document">

                <div class="ba-doc-header">

                    <img
                        src="{{ asset('images/logo-navbar.png') }}"
                        class="ba-doc-logo"
                        alt="Logo Universitas Malikussaleh"
                    >

                    <div class="ba-doc-head-text">

                        <div>
                            KEMENTERIAN PENDIDIKAN TINGGI, SAINS,<br>
                            DAN TEKNOLOGI
                        </div>

                        <div class="university">
                            UNIVERSITAS MALIKUSSALEH
                        </div>

                        <div>
                            Jl. Cot Teungku Nie, Reuleut Kecamatan Muara Batu -
                            Aceh Utara<br>
                            Laman: http://www.unimal.ac.id
                        </div>

                    </div>

                </div>


                <div class="ba-doc-title">
                    BERITA ACARA TINDAK LANJUT LAPORAN
                </div>

                <div class="ba-doc-number">
                    Nomor: {{ $nomorBeritaAcara }}
                </div>


                <p class="ba-doc-paragraph">

                    Pada tanggal
                    <strong>
                        {{ $tanggalLaporan?->translatedFormat('d F Y') ?? '-' }}
                    </strong>,
                    telah dilakukan tindak lanjut terhadap laporan
                    yang diajukan melalui sistem pelaporan
                    Universitas Malikussaleh.

                </p>


                <table class="ba-doc-table">

                    <tr>
                        <td>Nama Pelapor</td>
                        <td>: {{ $user?->name ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>NIM/NIP</td>
                        <td>: {{ $user?->nim_nip ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Fakultas</td>
                        <td>: {{ $user?->fakultas ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Program Studi</td>
                        <td>: {{ $user?->program_studi ?? '-' }}</td>
                    </tr>

                </table>


                <p class="ba-doc-paragraph">
                    Adapun laporan yang telah ditindaklanjuti adalah
                    sebagai berikut:
                </p>


                <table class="ba-doc-table">

                    <tr>
                        <td>Nomor Laporan</td>
                        <td>: {{ $laporan->nomor_laporan }}</td>
                    </tr>

                    <tr>
                        <td>Judul Laporan</td>
                        <td>: {{ $laporan->judul_laporan ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Kategori</td>
                        <td>: {{ $laporan->kategori?->nama ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Tanggal Laporan</td>
                        <td>: {{ $tanggalLaporan?->translatedFormat('d F Y') ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Lokasi</td>
                        <td>: {{ $lokasi ?: '-' }}</td>
                    </tr>

                    <tr>
                        <td>Teknisi</td>
                        <td>: {{ $teknisi?->nama ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Tanggal Penugasan</td>
                        <td>: {{ $tanggalPenugasan?->translatedFormat('d F Y') ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Target Selesai</td>
                        <td>: {{ $targetSelesai?->translatedFormat('d F Y') ?? '-' }}</td>
                    </tr>

                </table>


                <p class="ba-doc-paragraph">

                    <strong>Uraian Laporan:</strong><br>

                    {{ $laporan->deskripsi_kerusakan ?? '-' }}

                </p>


                <p class="ba-doc-paragraph">

                    <strong>Instruksi Penanganan:</strong><br>

                    {{ $laporan->instruksi_teknisi ?? '-' }}

                </p>


                <p class="ba-doc-paragraph">

                    Berdasarkan data laporan, penanganan telah
                    diselesaikan dan status laporan telah berubah
                    menjadi <strong>selesai</strong>.

                </p>


                @if($laporan->catatan_verifikasi_biro)

                    <p class="ba-doc-paragraph">

                        <strong>Catatan Verifikasi Biro:</strong><br>

                        {{ $laporan->catatan_verifikasi_biro }}

                    </p>

                @endif


                <p class="ba-doc-paragraph">

                    Demikian berita acara ini dibuat dengan
                    sebenar-benarnya untuk dapat dipergunakan
                    sebagaimana mestinya.

                </p>


                <div class="ba-doc-footer-date">

                    Lhokseumawe,
                    {{ now()->translatedFormat('d F Y') }}

                </div>


                <div class="ba-doc-signature">

                    <div>

                        Mengetahui,<br>
                        Kepala Biro Umum dan Keuangan

                        <div class="ba-signature-space"></div>

                        <div class="ba-signature-name">
                            __________________________
                        </div>

                        <div>
                            NIP.
                        </div>

                    </div>


                    <div>

                        Dibuat oleh,<br>
                        Admin Biro

                        <div class="ba-signature-space"></div>

                        <div class="ba-signature-name">
                            {{ auth()->user()?->name ?? '__________________________' }}
                        </div>

                        <div>
                            NIP.
                            {{ auth()->user()?->nim_nip ?? '-' }}
                        </div>

                    </div>

                </div>


            </div>


            <div class="ba-print-note">

                <div class="ba-print-icon">
                    !
                </div>

                <div>
                    Pastikan semua data sudah benar sebelum mencetak
                    Berita Acara.
                </div>

            </div>

        </div>

    </div>

</div>

@endsection