@extends('layouts.dashboard')

@section('title', 'Berita Acara')

@section('content')

    <style>
        .ba-page {
            padding-bottom: 30px;
        }

        /* =========================
           HEADER
        ========================= */

        .page-title {
            margin-bottom: 25px;
        }

        .page-title h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #202235;
        }

        .page-title p {
            margin: 6px 0 0;
            font-size: 13px;
            color: #8b91a0;
        }


        /* =========================
           STATISTIK
        ========================= */

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 25px;
        }

        .stat-card {
            min-height: 105px;
            padding: 18px;
            background: #fff;
            border: 1px solid #e0e3e9;
            border-radius: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .07);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .icon-total {
            background: #e1ecff;
            color: #2878e8;
        }

        .icon-process {
            background: #fff0d8;
            color: #e99516;
        }

        .icon-success {
            background: #dcf3e5;
            color: #159447;
        }

        .stat-content {
            margin-left: 14px;
        }

        .stat-title {
            color: #737989;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .stat-number {
            color: #202235;
            font-size: 24px;
            font-weight: 700;
            line-height: 1;
        }


        /* =========================
           FILTER
        ========================= */

        .filter-card {
            padding: 18px;
            margin-bottom: 22px;
            background: #fff;
            border: 1px solid #e0e3e9;
            border-radius: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .07);
        }

        .filter-form {
            display: grid;
            grid-template-columns: 1.7fr 1fr 1fr 1fr;
            gap: 12px;
        }

        .search-wrapper {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa1af;
            font-size: 15px;
            pointer-events: none;
        }

        .filter-input,
        .filter-select {
            width: 100%;
            height: 44px;
            box-sizing: border-box;
            border: 1px solid #cdd2dc;
            border-radius: 8px;
            background: #fff;
            color: #4c5262;
            font-size: 12px;
            outline: none;
        }

        .filter-input {
            padding: 0 14px 0 42px;
        }

        .filter-select {
            padding: 0 12px;
        }

        .filter-input:focus,
        .filter-select:focus {
            border-color: #25243d;
        }


        /* =========================
           TABLE
        ========================= */

        .table-card {
            background: #fff;
            border: 1px solid #e0e3e9;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .08);
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .ba-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .ba-table th {
            height: 52px;
            padding: 0 15px;
            background: #fff;
            border-bottom: 1px solid #e2e4e9;
            color: #303342;
            font-size: 12px;
            font-weight: 700;
            text-align: left;
            white-space: nowrap;
        }

        .ba-table td {
            height: 62px;
            padding: 0 15px;
            border-bottom: 1px solid #e8e9ed;
            color: #424755;
            font-size: 12px;
            vertical-align: middle;
        }

        .ba-table tbody tr:last-child td {
            border-bottom: none;
        }

        .ba-table th:nth-child(1),
        .ba-table td:nth-child(1) {
            width: 5%;
            text-align: center;
        }

        .ba-table th:nth-child(2),
        .ba-table td:nth-child(2) {
            width: 16%;
        }

        .ba-table th:nth-child(3),
        .ba-table td:nth-child(3) {
            width: 14%;
        }

        .ba-table th:nth-child(4),
        .ba-table td:nth-child(4) {
            width: 23%;
        }

        .ba-table th:nth-child(5),
        .ba-table td:nth-child(5) {
            width: 17%;
        }

        .ba-table th:nth-child(6),
        .ba-table td:nth-child(6) {
            width: 12%;
        }

        .ba-table th:nth-child(7),
        .ba-table td:nth-child(7) {
            width: 10%;
            text-align: center;
        }

        .ba-table th:nth-child(8),
        .ba-table td:nth-child(8) {
            width: 10%;
            text-align: center;
        }


        /* =========================
           TEXT
        ========================= */

        .ba-number {
            font-weight: 700;
            color: #25243d;
            white-space: nowrap;
        }

        .laporan-number {
            color: #555b69;
            white-space: nowrap;
        }

        .ba-title-text {
            font-weight: 600;
            color: #303342;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .pelapor {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .date {
            white-space: nowrap;
            color: #626877;
        }


        /* =========================
           STATUS
        ========================= */

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 78px;
            height: 29px;
            padding: 0 10px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-diproses {
            background: #fff0d7;
            color: #d8880a;
        }

        .status-selesai {
            background: #dcf2e3;
            color: #15833f;
        }


        /* =========================
           BUTTON DETAIL
        ========================= */

        .btn-detail {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 62px;
            height: 32px;
            border: 1px solid #aeb5c3;
            border-radius: 8px;
            background: #fff;
            color: #303342;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            transition: .15s;
        }

        .btn-detail:hover {
            background: #25243d;
            border-color: #25243d;
            color: #fff;
        }


        /* =========================
           EMPTY
        ========================= */

        .empty-state {
            padding: 65px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 55px;
            height: 55px;
            margin: 0 auto 13px;
            border-radius: 50%;
            background: #f0f1f5;
            color: #969baa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .empty-state h3 {
            margin: 0 0 6px;
            color: #363946;
            font-size: 15px;
        }

        .empty-state p {
            margin: 0;
            color: #9aa0ad;
            font-size: 12px;
        }


        /* =========================
           FOOTER
        ========================= */

        .table-footer {
            min-height: 72px;
            padding: 0 16px;
            border-top: 1px solid #e2e4e9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
            min-width: 0;
        }

        .pagination > a,
        .pagination > span {
            min-width: 35px;
            height: 35px;
            box-sizing: border-box;
            padding: 0 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #c3c8d2;
            border-radius: 8px;
            background: #fff;
            color: #777e8c;
            text-decoration: none;
            font-size: 11px;
            white-space: nowrap;
        }

        .pagination > .active span {
            border-color: #25243d;
            background: #25243d;
            color: #fff;
        }

        .pagination > .disabled {
            color: #c1c5cd;
            pointer-events: none;
        }

        .pagination svg {
            width: 15px;
            height: 15px;
        }

        .per-page {
            position: absolute;
            right: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #9297a3;
            font-size: 10px;
        }

        .per-page select {
            width: 55px;
            height: 35px;
            padding: 0 7px;
            border: 1px solid #c3c8d2;
            border-radius: 8px;
            background: #fff;
            color: #656b79;
            font-size: 10px;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1100px) {

            .stat-grid {
                grid-template-columns: 1fr;
            }

            .filter-form {
                grid-template-columns: 1fr 1fr;
            }

        }

        @media (max-width: 700px) {

            .filter-form {
                grid-template-columns: 1fr;
            }

            .table-footer {
                justify-content: flex-start;
                overflow-x: auto;
            }

            .per-page {
                position: static;
                margin-left: auto;
            }

        }
    </style>


    <div class="ba-page">

        {{-- =========================
        HEADER
        ========================== --}}

        <div class="page-title">

            <h1>Berita Acara</h1>

            <p>
                Daftar berita acara dari laporan yang telah diverifikasi oleh Admin Fakultas.
            </p>

        </div>


        {{-- =========================
        STATISTIK
        ========================== --}}

        <div class="stat-grid">

            <div class="stat-card">

                <div class="stat-icon icon-total">
                    BA
                </div>

                <div class="stat-content">

                    <div class="stat-title">
                        Total Berita Acara
                    </div>

                    <div class="stat-number">
                        {{ $totalBeritaAcara }}
                    </div>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon icon-process">
                    ↻
                </div>

                <div class="stat-content">

                    <div class="stat-title">
                        Sedang Diproses
                    </div>

                    <div class="stat-number">
                        {{ $sedangDiproses }}
                    </div>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon icon-success">
                    ✓
                </div>

                <div class="stat-content">

                    <div class="stat-title">
                        Selesai
                    </div>

                    <div class="stat-number">
                        {{ $selesai }}
                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
        FILTER
        ========================== --}}

        <div class="filter-card">

            <form action="{{ route('admin.fakultas.berita') }}" method="GET" class="filter-form">

                {{-- SEARCH --}}

                <div class="search-wrapper">

                    <span class="search-icon">
                        ⌕
                    </span>

                    <input type="text" name="search" class="filter-input" value="{{ request('search') }}"
                        placeholder="Cari nomor laporan, judul, atau nama pelapor...">

                </div>


                {{-- STATUS --}}

                <select name="status" class="filter-select" onchange="this.form.submit()">

                    <option value="">
                        Semua Status
                    </option>

                    <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>
                        Sedang Diproses
                    </option>

                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                </select>


                {{-- KATEGORI --}}

                <select name="kategori" class="filter-select" onchange="this.form.submit()">

                    <option value="">
                        Semua Kategori
                    </option>

                    @foreach($kategori as $item)

                        <option value="{{ $item->id }}" {{ request('kategori') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama }}
                        </option>

                    @endforeach

                </select>


                {{-- TANGGAL --}}

                <select name="tanggal" class="filter-select" onchange="this.form.submit()">

                    <option value="">
                        Semua Waktu
                    </option>

                    <option value="hari_ini" {{ request('tanggal') === 'hari_ini' ? 'selected' : '' }}>
                        Hari Ini
                    </option>

                    <option value="7_hari" {{ request('tanggal') === '7_hari' ? 'selected' : '' }}>
                        7 Hari Terakhir
                    </option>

                    <option value="30_hari" {{ request('tanggal') === '30_hari' ? 'selected' : '' }}>
                        30 Hari Terakhir
                    </option>

                </select>

            </form>

        </div>


        {{-- =========================
        TABLE
        ========================== --}}

        <div class="table-card">

            <div class="table-wrapper">

                <table class="ba-table">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Nomor Berita Acara</th>

                            <th>Nomor Laporan</th>

                            <th>Judul Laporan</th>

                            <th>Pelapor</th>

                            <th>Tanggal</th>

                            <th>Status</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($laporans as $index => $laporan)

                                            <tr>

                                                <td>
                                                    {{ $laporans->firstItem() + $index }}
                                                </td>


                                                {{-- NOMOR BERITA ACARA --}}

                                                <td>

                                                    <div class="ba-number">

                                                        BA/{{ $laporan->nomor_laporan }}

                                                    </div>

                                                </td>


                                                {{-- NOMOR LAPORAN --}}

                                                <td>

                                                    <div class="laporan-number">

                                                        {{ $laporan->nomor_laporan }}

                                                    </div>

                                                </td>


                                                {{-- JUDUL --}}

                                                <td>

                                                    <div class="ba-title-text" title="{{ $laporan->judul_laporan }}">
                                                        {{ $laporan->judul_laporan }}
                                                    </div>

                                                </td>


                                                {{-- PELAPOR --}}

                                                <td>

                                                    <div class="pelapor" title="{{ $laporan->user->name ?? '-' }}">
                                                        {{ $laporan->user->name ?? '-' }}
                                                    </div>

                                                </td>


                                                {{-- TANGGAL --}}

                                                <td>

                                                    <div class="date">

                                                        {{ $laporan->created_at
                                ? $laporan->created_at->format('d/m/Y')
                                : '-'
                                                            }}

                                                    </div>

                                                </td>


                                                {{-- STATUS --}}

                                                <td>

                                                    @if($laporan->status === 'diproses')

                                                        <span class="status-badge status-diproses">
                                                            Diproses
                                                        </span>

                                                    @elseif($laporan->status === 'selesai')

                                                        <span class="status-badge status-selesai">
                                                            Selesai
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- AKSI --}}

                                                <td>

                                                    <a href="{{ route(
                                'admin.fakultas.berita.detail',
                                $laporan
                            ) }}" class="btn-detail">
                                                        Detail
                                                    </a>

                                                </td>

                                            </tr>

                        @empty

                            <tr>

                                <td colspan="8">

                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            BA
                                        </div>

                                        <h3>
                                            Belum Ada Berita Acara
                                        </h3>

                                        <p>
                                            Belum ada laporan yang telah diverifikasi
                                            dan tersedia sebagai berita acara.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =========================
            FOOTER PAGINATION
            ========================== --}}

            @if($laporans->hasPages() || $laporans->total() > 0)

                <div class="table-footer">

                    <div class="pagination" aria-label="Navigasi halaman">
                        @if ($laporans->hasPages())
                            <a href="{{ $laporans->previousPageUrl() ?? '#' }}"
                               class="{{ $laporans->onFirstPage() ? 'disabled' : '' }}"
                               @if($laporans->onFirstPage()) aria-disabled="true" tabindex="-1" @endif>
                                &lsaquo; Sebelumnya
                            </a>

                            @for ($page = 1; $page <= $laporans->lastPage(); $page++)
                                @if ($page === $laporans->currentPage())
                                    <span class="active" aria-current="page"><span>{{ $page }}</span></span>
                                @else
                                    <a href="{{ $laporans->url($page) }}">{{ $page }}</a>
                                @endif
                            @endfor

                            <a href="{{ $laporans->nextPageUrl() ?? '#' }}"
                               class="{{ $laporans->hasMorePages() ? '' : 'disabled' }}"
                               @unless($laporans->hasMorePages()) aria-disabled="true" tabindex="-1" @endunless>
                                Berikutnya &rsaquo;
                            </a>
                        @endif
                    </div>


                    <form method="GET" action="{{ route('admin.fakultas.berita') }}" class="per-page">

                        @foreach(request()->except('per_page', 'page') as $key => $value)

                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">

                        @endforeach

                        <span>
                            Data per halaman
                        </span>

                        <select name="per_page" onchange="this.form.submit()">

                            <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>
                                5
                            </option>

                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>
                                10
                            </option>

                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>
                                50
                            </option>

                        </select>

                    </form>

                </div>

            @endif

        </div>

    </div>

@endsection