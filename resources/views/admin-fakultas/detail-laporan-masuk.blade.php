@extends('layouts.dashboard')

@section('title', 'Detail Laporan')

@section('content')

<style>

    /* =====================================================
       DETAIL PAGE
    ===================================================== */

    .detail-page {
        padding: 4px 4px 20px;
    }


    /* =====================================================
       HEADER
    ===================================================== */

    .detail-header {
        margin-bottom: 16px;
    }

    .breadcrumb-detail {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #25243a;
        margin-bottom: 10px;
    }

    .breadcrumb-detail a {
        color: #25243a;
        text-decoration: none;
    }

    .breadcrumb-detail .arrow {
        font-size: 20px;
    }

    .detail-title h2 {
        margin: 0;
        font-size: 25px;
        font-weight: 700;
        color: #25243a;
    }

    .report-number {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 8px;
    }

    .report-number strong {
        font-size: 21px;
        color: #25243a;
    }

    .status-main {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 190px;
        height: 33px;
        padding: 0 18px;
        border: 1px solid #ff7a00;
        border-radius: 11px;
        color: #ff7a00;
        background: #fffaf5;
        font-size: 13px;
        font-weight: 600;
    }


    /* =====================================================
       GRID UTAMA
    ===================================================== */

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: auto auto auto auto;
        gap: 12px;
    }

    /*
    Form tetap bisa membungkus bagian verifikasi,
    tetapi elemen di dalamnya tetap dianggap sebagai
    item langsung dari CSS Grid.
    */

    .verification-form {
        display: contents;
    }


    /* =====================================================
       CARD
    ===================================================== */

    .detail-card {
        background: #ffffff;
        border: 1px solid #dcdde4;
        border-radius: 9px;
        box-shadow: 0 3px 4px rgba(0, 0, 0, 0.15);
        padding: 14px 26px;
        box-sizing: border-box;
    }

    .detail-card h3 {
        margin: 0 0 17px;
        font-size: 15px;
        font-weight: 700;
        color: #29283c;
        text-transform: uppercase;
    }


    /* =====================================================
       POSISI CARD
    ===================================================== */

    /*
        Baris 1
        Informasi Laporan | Informasi Pelapor
    */

    .report-info-card {
        grid-column: 1;
        grid-row: 1;
    }

    .reporter-card {
        grid-column: 2;
        grid-row: 1;
    }


    /*
        Baris 2
        Bukti              | Riwayat
    */

    .attachment-card {
        grid-column: 1;
        grid-row: 2;
    }


    /*
        Riwayat Status memanjang dari
        baris Bukti sampai Hasil Verifikasi
    */

    .timeline-card {
        grid-column: 2;
        grid-row: 2 / 4;
    }


    /*
        Baris 3
        Hasil Verifikasi   | Riwayat Status
    */

    .verification-card {
        grid-column: 1;
        grid-row: 3;

        min-height: 108px;
    }


    /*
        Baris 4
        Tombol penuh
    */

    .action-card {
        grid-column: 1 / -1;
        grid-row: 4;
    }


    /* =====================================================
       INFORMASI
    ===================================================== */

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .info-row {
        display: grid;
        grid-template-columns: 112px 14px 1fr;
        align-items: start;
        font-size: 13px;
        line-height: 1.35;
    }

    .info-label {
        font-weight: 700;
        color: #29283c;
    }

    .info-colon {
        font-weight: 700;
        color: #29283c;
        text-align: center;
    }

    .info-value {
        color: #29283c;
        font-weight: 600;
    }

    .description-value {
        font-weight: 500;
        line-height: 1.45;
    }


    /* =====================================================
       FOTO / LAMPIRAN
    ===================================================== */

    .photo-grid {
        display: flex;
        gap: 13px;
        flex-wrap: wrap;
    }

    .photo-item {
        position: relative;
        width: 88px;
        height: 60px;
        border: 2px solid #29283c;
        border-radius: 8px;
        overflow: hidden;
        background: #f3f4f6;
    }

    .photo-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .photo-empty {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        font-size: 11px;
    }

    .photo-zoom {
        position: absolute;
        right: 3px;
        bottom: 3px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background: #29283c;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 9px;
    }


    /* =====================================================
       TIMELINE
    ===================================================== */

    .timeline {
        position: relative;
        padding-left: 4px;
    }

    .timeline-item {
        position: relative;
        display: flex;
        gap: 13px;
        min-height: 51px;
    }

    .timeline-line {
        position: absolute;
        left: 7px;
        top: 17px;
        width: 1px;
        height: 42px;
        border-left: 1px dashed #8d91a6;
    }

    .timeline-item:last-child .timeline-line {
        display: none;
    }

    .timeline-dot {
        position: relative;
        z-index: 2;
        flex: 0 0 13px;
        width: 13px;
        height: 13px;
        margin-top: 1px;
        border: 2px solid #29283c;
        border-radius: 50%;
        background: #fff;
    }

    .timeline-dot.active {
        background: #29283c;
    }

    .timeline-content {
        position: relative;
        flex: 1;
        margin-top: -2px;
        padding-right: 65px;
    }

    .timeline-title {
        font-size: 11px;
        font-weight: 700;
        color: #29283c;
        margin-bottom: 2px;
    }

    .timeline-date {
        font-size: 10px;
        color: #8c92a8;
        font-weight: 500;
    }

    .timeline-current {
        position: absolute;
        right: 0;
        top: 0;
        border: 1px solid #ff7a00;
        border-radius: 7px;
        color: #ff7a00;
        background: #fffaf5;
        padding: 6px 8px;
        font-size: 10px;
        font-weight: 600;
    }


    /* =====================================================
       HASIL VERIFIKASI
    ===================================================== */

    .verification-card {
        padding: 12px 20px;
    }

    .verification-card h3 {
        margin-bottom: 10px;
        font-size: 13px;
    }

    .verification-row {
        display: grid;
        grid-template-columns: 125px 12px 1fr;
        align-items: center;
        margin-bottom: 7px;
        font-size: 10px;
    }

    .verification-row:last-child {
        margin-bottom: 0;
    }

    .verification-label {
        font-weight: 700;
        color: #29283c;
    }

    .verification-colon {
        font-weight: 700;
        color: #29283c;
        text-align: center;
    }

    .verification-field {
        width: 100%;
    }


    /* =====================================================
       DROPDOWN
    ===================================================== */

    .verification-select {
        width: 100%;
        height: 30px;
        box-sizing: border-box;
        border: 1px solid #9da3b8;
        border-radius: 8px;
        padding: 0 10px;
        color: #29283c;
        font-weight: 600;
        background: #fff;
        outline: none;
        cursor: pointer;
        font-family: inherit;
        font-size: 10px;
    }

    .verification-select:focus {
        border-color: #25243a;
        box-shadow: 0 0 0 2px rgba(37, 36, 58, 0.08);
    }


    /* =====================================================
       TEXTAREA
    ===================================================== */

    .verification-note {
        width: 100%;
        height: 42px;
        min-height: 42px;
        box-sizing: border-box;
        resize: none;
        border: 1px solid #9da3b8;
        border-radius: 8px;
        padding: 6px 9px;
        color: #29283c;
        background: #fff;
        font-size: 9px;
        line-height: 1.25;
        font-weight: 500;
        font-family: inherit;
        outline: none;
    }

    .verification-note::placeholder {
        color: #8d94aa;
    }

    .verification-note:focus {
        border-color: #25243a;
        box-shadow: 0 0 0 2px rgba(37, 36, 58, 0.08);
    }


    /* =====================================================
       ACTION CARD
    ===================================================== */

    .action-card {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 85px;

        padding: 8px 12px;

        align-items: center;
    }

    .action-button {
        width: 100%;
        height: 43px;

        border-radius: 9px;

        padding: 0 12px;

        display: flex;
        align-items: center;

        gap: 9px;

        cursor: pointer;

        font-family: inherit;
        text-align: left;

        box-sizing: border-box;
    }

    .reject-button {
        border: 1px solid #ff2424;
        background: #fff;
        color: #ff2424;
    }

    .forward-button {
        border: none;
        background: #25243a;
        color: #fff;
    }

    .action-icon {
        width: 22px;
        height: 22px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        font-size: 13px;
        font-weight: 700;
    }

    .reject-button .action-icon {
        background: #ff2424;
        color: #fff;
    }

    .forward-button .action-icon {
        font-size: 17px;
        width: 22px;
    }

    .action-text {
        display: flex;
        flex-direction: column;

        gap: 1px;

        min-width: 0;
    }

    .action-title {
        font-size: 11px;
        font-weight: 700;
    }

    .action-description {
        font-size: 9px;
        font-weight: 500;
        opacity: 0.7;
        line-height: 1.2;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 1000px) {

        .detail-grid {
            grid-template-columns: 1fr;
            grid-template-rows: auto;
        }

        .report-info-card,
        .reporter-card,
        .attachment-card,
        .timeline-card,
        .verification-card,
        .action-card {
            grid-column: 1;
            grid-row: auto;
        }

        .timeline-card {
            min-height: auto;
        }

        .action-card {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

    }


    @media (max-width: 700px) {

        .detail-page {
            padding: 0;
        }

        .detail-card {
            padding: 15px;
        }

        .report-number {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .info-row {
            grid-template-columns: 95px 12px 1fr;
        }

        .verification-row {
            grid-template-columns: 110px 12px 1fr;
        }

        .action-card {
            grid-template-columns: 1fr;
        }

        .photo-grid {
            gap: 10px;
        }

        .photo-item {
            width: 110px;
            height: 78px;
        }

        .timeline-current {
            position: static;
            display: inline-block;
            margin-top: 6px;
        }

        .timeline-content {
            padding-right: 0;
        }

    }

</style>


<div class="detail-page">


    {{-- =====================================================
         HEADER
    ===================================================== --}}

    


        <div class="report-number">

            <strong>
                {{ $laporan->nomor_laporan }}
            </strong>

            <span class="status-main">
                Menunggu Verifikasi
            </span>

        </div>

    </div>



    {{-- =====================================================
         GRID
    ===================================================== --}}

    <div class="detail-grid">


        {{-- =================================================
             INFORMASI LAPORAN
        ================================================== --}}

        <div class="detail-card report-info-card">

            <h3>
                Informasi Laporan
            </h3>

            <div class="info-list">


                <div class="info-row">

                    <div class="info-label">
                        Judul
                    </div>

                    <div class="info-colon">
                        :
                    </div>

                    <div class="info-value">
                        {{ $laporan->judul_laporan }}
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        Kategori
                    </div>

                    <div class="info-colon">
                        :
                    </div>

                    <div class="info-value">
                        {{ $laporan->kategori->nama ?? '-' }}
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        Tanggal
                    </div>

                    <div class="info-colon">
                        :
                    </div>

                    <div class="info-value">
                        {{ $laporan->created_at->format('d F Y') }}
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        Lokasi
                    </div>

                    <div class="info-colon">
                        :
                    </div>

                    <div class="info-value">

                        {{ $laporan->gedung->nama ?? '-' }}

                        @if($laporan->lantai)
                            , Lantai {{ $laporan->lantai }}
                        @endif

                        @if($laporan->ruangan)
                            , {{ $laporan->ruangan }}
                        @endif

                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        Deskripsi
                    </div>

                    <div class="info-colon">
                        :
                    </div>

                    <div class="info-value description-value">
                        {{ $laporan->deskripsi_kerusakan ?? '-' }}
                    </div>

                </div>


            </div>

        </div>



        {{-- =================================================
             INFORMASI PELAPOR
        ================================================== --}}

        <div class="detail-card reporter-card">

            <h3>
                Informasi Pelapor
            </h3>

            <div class="info-list">


                <div class="info-row">

                    <div class="info-label">
                        Nama
                    </div>

                    <div class="info-colon">
                        :
                    </div>

                    <div class="info-value">
                        {{ $laporan->user->name ?? '-' }}
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        NIM/NIP
                    </div>

                    <div class="info-colon">
                        :
                    </div>

                    <div class="info-value">
                        {{ data_get($laporan->user, 'nim_nip', '-') }}
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        Fakultas
                    </div>

                    <div class="info-colon">
                        :
                    </div>

                    <div class="info-value">
                        {{ data_get($laporan->user, 'fakultas', '-') }}
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        Unit
                    </div>

                    <div class="info-colon">
                        :
                    </div>

                    <div class="info-value">
                        {{ data_get($laporan->user, 'program_studi', '-') }}
                    </div>

                </div>


            </div>

        </div>



        {{-- =================================================
             BUKTI / LAMPIRAN
        ================================================== --}}

        <div class="detail-card attachment-card">

            <h3>
                Bukti / Lampiran
            </h3>

            <div class="photo-grid">

                @forelse ($laporan->foto as $foto)

                    <div class="photo-item">

                        <img
                            src="{{ asset('storage/' . $foto->foto) }}"
                            alt="Bukti laporan"
                        >

                        <span class="photo-zoom" onclick="window.open('{{ asset('storage/' . $foto->foto) }}', '_blank')">
                            ⌕
                        </span>

                    </div>

                @empty

                    <div class="photo-item">

                        <div class="photo-empty">
                            Tidak ada foto
                        </div>

                    </div>

                @endforelse

            </div>

        </div>



        {{-- =================================================
             RIWAYAT STATUS
             
             CARD INI MEMANJANG:
             BARIS BUKTI + BARIS HASIL VERIFIKASI
        ================================================== --}}

        <div class="detail-card timeline-card">

            <h3>
                Riwayat Status
            </h3>

            <div class="timeline">


                {{-- LAPORAN DIAJUKAN --}}

                <div class="timeline-item">

                    <div class="timeline-dot active"></div>

                    <div class="timeline-line"></div>

                    <div class="timeline-content">

                        <div class="timeline-title">
                            Laporan Diajukan
                        </div>

                        <div class="timeline-date">
                            {{ $laporan->created_at->format('d F Y, H:i') }}
                        </div>

                    </div>

                </div>



                {{-- DITERIMA ADMIN --}}

                <div class="timeline-item">

                    <div class="timeline-dot active"></div>

                    <div class="timeline-line"></div>

                    <div class="timeline-content">

                        <div class="timeline-title">
                            Diterima Admin fakultas
                        </div>

                        <div class="timeline-date">
                            {{ $laporan->created_at->format('d F Y, H:i') }}
                        </div>

                    </div>

                </div>



                {{-- MENUNGGU VERIFIKASI --}}

                <div class="timeline-item">

                    <div class="timeline-dot active"></div>

                    <div class="timeline-line"></div>

                    <div class="timeline-content">

                        <div class="timeline-title">
                            Menunggu Verifikasi
                        </div>

                        <div class="timeline-date">
                            {{ $laporan->created_at->format('d F Y, H:i') }}
                        </div>

                        <span class="timeline-current">
                            Saat Ini
                        </span>

                    </div>

                </div>



                {{-- DITERUSKAN KE BIRO --}}

                <div class="timeline-item">

                    <div class="timeline-dot"></div>

                    <div class="timeline-line"></div>

                    <div class="timeline-content">

                        <div class="timeline-title">
                            Diteruskan Ke Biro
                        </div>

                        <div class="timeline-date">
                            Belum dilakukan
                        </div>

                    </div>

                </div>



                {{-- SELESAI --}}

                <div class="timeline-item">

                    <div class="timeline-dot"></div>

                    <div class="timeline-content">

                        <div class="timeline-title">
                            Selesai
                        </div>

                        <div class="timeline-date">
                            Belum dilakukan
                        </div>

                    </div>

                </div>


            </div>

        </div>



        {{-- =================================================
             FORM VERIFIKASI
        ================================================== --}}

        <form
            action="{{ route('admin.fakultas.laporan.proses', $laporan->id) }}"
            method="POST"
            id="formVerifikasi"
            class="verification-form"
        >

            @csrf


            {{-- =================================================
                 HASIL VERIFIKASI
            ================================================== --}}

            <div class="detail-card verification-card">

                <h3>
                    Hasil Verifikasi
                </h3>


                {{-- STATUS VERIFIKASI --}}

                <div class="verification-row">

                    <label
                        for="status_verifikasi"
                        class="verification-label"
                    >
                        Status Verifikasi
                    </label>

                    <div class="verification-colon">
                        :
                    </div>

                    <div class="verification-field">

                        <select
                            name="status_verifikasi"
                            id="status_verifikasi"
                            class="verification-select"
                            required
                        >

                            <option value="valid">
                                Valid
                            </option>

                            <option value="tidak_valid">
                                Tidak Valid
                            </option>

                        </select>

                    </div>

                </div>


                {{-- CATATAN VERIFIKASI --}}

                <div class="verification-row">

                    <label
                        for="catatan_verifikasi"
                        class="verification-label"
                    >
                        Catatan Verifikasi
                    </label>

                    <div class="verification-colon">
                        :
                    </div>

                    <div class="verification-field">

                        <textarea
                            name="catatan_verifikasi"
                            id="catatan_verifikasi"
                            class="verification-note"
                            placeholder="Masukkan catatan verifikasi..."
                        >{{ old('catatan_verifikasi', $laporan->catatan_verifikasi ?? '') }}</textarea>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 ACTION
            ================================================== --}}

            <div class="detail-card action-card">


                {{-- TOLAK LAPORAN --}}

                <button
                    type="submit"
                    class="action-button reject-button"
                    onclick="return setVerificationStatus('tidak_valid')"
                >

                    <span class="action-icon">
                        ×
                    </span>

                    <span class="action-text">

                        <span class="action-title">
                            Tolak Laporan
                        </span>

                        <span class="action-description">
                            Laporan akan ditolak dan tidak diproses lebih lanjut
                        </span>

                    </span>

                </button>



                {{-- TERUSKAN KE BIRO --}}

                <button
                    type="submit"
                    class="action-button forward-button"
                    onclick="return setVerificationStatus('valid')"
                >

                    <span class="action-icon">
                        ➤
                    </span>

                    <span class="action-text">

                        <span class="action-title">
                            Teruskan ke Biro
                        </span>

                        <span class="action-description">
                            Laporan akan diteruskan ke Biro Umum dan Keuangan
                        </span>

                    </span>

                </button>


            </div>


        </form>


    </div>

</div>



<script>

    function setVerificationStatus(status)
    {
        const select =
            document.getElementById('status_verifikasi');

        select.value = status;


        if (status === 'tidak_valid') {

            return confirm(
                'Apakah Anda yakin ingin menolak laporan ini?'
            );

        }


        return confirm(
            'Apakah laporan ini sudah valid dan ingin diteruskan ke Biro?'
        );
    }

</script>


@endsection