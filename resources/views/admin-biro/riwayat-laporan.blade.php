@extends('layouts.dashboard')

@section('title', 'Riwayat Laporan')

@section('content')

    <style>
        .page-title {
            margin-bottom: 28px;
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
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            min-height: 120px;
            padding: 18px;
            background: #fff;
            border: 1px solid #e0e3e9;
            border-radius: 16px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .08);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon svg {
            width: 26px;
            height: 26px;
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

        .icon-danger {
            background: #ffe1e1;
            color: #e53939;
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
            margin-bottom: 6px;
        }

        .stat-description {
            color: #a0a5b0;
            font-size: 10px;
        }

        /* =========================
           FILTER
        ========================= */

        .filter-card {
            padding: 18px;
            margin-bottom: 25px;
            background: #fff;
            border: 1px solid #e0e3e9;
            border-radius: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .07);
        }

        .btn-export-excel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            padding: 0 18px;
            border: 1px solid #16834a;
            border-radius: 8px;
            background: #16834a;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s ease;
            white-space: nowrap;
        }

        .btn-export-excel:hover {
            background: #116b3c;
            color: #fff;
        }

        .filter-form {
            display: grid;
            grid-template-columns: 1.7fr 1fr 1fr 1fr auto;
            gap: 12px;
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper svg {
            position: absolute;
            width: 17px;
            height: 17px;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa1af;
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
            padding: 0 14px 0 43px;
        }

        .filter-input::placeholder {
            color: #a1a7b3;
        }

        .filter-select {
            padding: 0 12px;
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

        .report-table {
            width: 100%;
            min-width: 1450px;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .report-table th {
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

        .report-table td {
            height: 60px;
            padding: 0 15px;
            border-bottom: 1px solid #e8e9ed;
            color: #424755;
            font-size: 12px;
            vertical-align: middle;
        }

        .report-table tbody tr:last-child td {
            border-bottom: none;
        }

        .report-table th:nth-child(1),
        .report-table td:nth-child(1) { width: 10%; }
        .report-table th:nth-child(2),
        .report-table td:nth-child(2) { width: 15%; }
        .report-table th:nth-child(3),
        .report-table td:nth-child(3) { width: 10%; }
        .report-table th:nth-child(4),
        .report-table td:nth-child(4) { width: 8%; }
        .report-table th:nth-child(5),
        .report-table td:nth-child(5) { width: 9%; }
        .report-table th:nth-child(6),
        .report-table td:nth-child(6),
        .report-table th:nth-child(7),
        .report-table td:nth-child(7),
        .report-table th:nth-child(8),
        .report-table td:nth-child(8),
        .report-table th:nth-child(9),
        .report-table td:nth-child(9) {
            width: 10%;
            padding-left: 20px;
            padding-right: 20px;
        }
        .report-table th:nth-child(10),
        .report-table td:nth-child(10) { width: 7%; text-align: center; }
        .report-table th:nth-child(11),
        .report-table td:nth-child(11) { width: 5%; text-align: center; }

        .report-number {
            font-weight: 600;
            white-space: nowrap;
        }

        .report-title,
        .pelapor,
        .teknisi {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .date {
            white-space: nowrap;
        }

        /* =========================
           STATUS
        ========================= */

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 82px;
            height: 30px;
            padding: 0 10px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-selesai {
            background: #dcf2e3;
            color: #15833f;
        }

        .status-ditolak {
            background: #ffe0e0;
            color: #e52e2e;
        }

        /* =========================
           DETAIL
        ========================= */

        .btn-detail {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 32px;
            border: 1px solid #aeb5c3;
            border-radius: 8px;
            background: #fff;
            color: #303342;
            font-size: 11px;
            text-decoration: none;
            transition: .15s;
        }

        .btn-detail:hover {
            background: #25243d;
            border-color: #25243d;
            color: #fff;
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
            gap: 6px;
        }

        .pagination a,
        .pagination span {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #c3c8d2;
            border-radius: 8px;
            background: #fff;
            color: #777e8c;
            text-decoration: none;
            font-size: 11px;
        }

        .pagination .active span {
            background: #25243d;
            border-color: #25243d;
            color: #fff;
        }

        .pagination .disabled span {
            color: #c1c5cd;
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
           EMPTY
        ========================= */

        .empty-state {
            padding: 65px 20px;
            text-align: center;
        }

        .empty-state svg {
            width: 45px;
            height: 45px;
            margin-bottom: 12px;
            color: #b5bbc6;
        }

        .empty-state h3 {
            margin: 0 0 6px;
            color: #363946;
            font-size: 15px;
        }

        .empty-state p {
            margin: 0;
            color: #9da2ad;
            font-size: 11px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1000px) {

            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-form {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 600px) {

            .stat-grid {
                grid-template-columns: 1fr;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .table-footer {
                padding: 15px;
                flex-direction: column;
                gap: 15px;
            }

            .pagination {
                position: static;
            }

            .per-page {
                position: static;
            }
        }
    </style>


    


    {{-- =========================
    STATISTIK
    ========================= --}}

    <div class="stat-grid">

        {{-- TOTAL --}}

        <div class="stat-card">

            <div class="stat-icon icon-total">

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">

                    <rect x="5" y="3" width="14" height="18" rx="2" />
                    <path d="M9 7h6" />
                    <path d="M9 11h6" />
                    <path d="M9 15h4" />

                </svg>

            </div>

            <div class="stat-content">

                <div class="stat-title">
                    Total Laporan
                </div>

                <div class="stat-number">
                    {{ $totalLaporan }}
                </div>

                <div class="stat-description">
                    Laporan dalam riwayat
                </div>

            </div>

        </div>


        {{-- SELESAI --}}

        <div class="stat-card">

            <div class="stat-icon icon-success">

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">

                    <circle cx="12" cy="12" r="9" />
                    <path d="m8 12 3 3 5-6" />

                </svg>

            </div>

            <div class="stat-content">

                <div class="stat-title">
                    Selesai
                </div>

                <div class="stat-number">
                    {{ $selesai }}
                </div>

                <div class="stat-description">
                    Laporan telah selesai
                </div>

            </div>

        </div>


        {{-- DITOLAK --}}

        <div class="stat-card">

            <div class="stat-icon icon-danger">

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">

                    <circle cx="12" cy="12" r="9" />
                    <path d="m9 9 6 6" />
                    <path d="m15 9-6 6" />

                </svg>

            </div>

            <div class="stat-content">

                <div class="stat-title">
                    Ditolak
                </div>

                <div class="stat-number">
                    {{ $ditolak }}
                </div>

                <div class="stat-description">
                    Laporan ditolak
                </div>

            </div>

        </div>


        {{-- BULAN INI --}}

        <div class="stat-card">

            <div class="stat-icon icon-process">

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">

                    <rect x="3" y="4" width="18" height="17" rx="2" />
                    <path d="M16 2v4" />
                    <path d="M8 2v4" />
                    <path d="M3 10h18" />
                    <path d="M8 14h2" />
                    <path d="M14 14h2" />
                    <path d="M8 18h2" />

                </svg>

            </div>

            <div class="stat-content">

                <div class="stat-title">
                    Bulan Ini
                </div>

                <div class="stat-number">
                    {{ $bulanIni }}
                </div>

                <div class="stat-description">
                    Laporan selesai atau ditolak
                </div>

            </div>

        </div>

    </div>


    {{-- =========================
    FILTER
    ========================= --}}

    <div class="filter-card">

        <form action="{{ route('admin.biro.riwayat') }}" method="GET" class="filter-form">

            {{-- SEARCH --}}

            <div class="search-wrapper">

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">

                    <circle cx="11" cy="11" r="7" />
                    <path d="m20 20-4-4" />

                </svg>

                <input type="text" name="search" class="filter-input" placeholder="Cari nomor atau judul laporan"
                    value="{{ request('search') }}">

            </div>


            {{-- STATUS --}}

            <select name="status" class="filter-select" onchange="this.form.submit()">

                <option value="">
                    Semua Status
                </option>

                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                    Selesai
                </option>

                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                    Ditolak
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
                    Semua Tanggal
                </option>

                <option value="hari_ini" {{ request('tanggal') == 'hari_ini' ? 'selected' : '' }}>
                    Hari Ini
                </option>

                <option value="7_hari" {{ request('tanggal') == '7_hari' ? 'selected' : '' }}>
                    7 Hari Terakhir
                </option>

                <option value="30_hari" {{ request('tanggal') == '30_hari' ? 'selected' : '' }}>
                    30 Hari Terakhir
                </option>

            </select>

            <a
                href="{{ route('admin.biro.riwayat.export', request()->query()) }}"
                class="btn-export-excel"
            >
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <path d="M14 2v6h6" />
                    <path d="M8 13h8M8 17h8" />
                </svg>
                Export
            </a>

        </form>

    </div>


    {{-- =========================
    TABLE
    ========================= --}}

    <div class="table-card">

        @if($laporans->count() > 0)

            <div class="table-wrapper">

                <table class="report-table">

                    <thead>

                        <tr>

                            <th>No. Laporan</th>

                            <th>Judul Laporan</th>

                            <th>Pelapor</th>

                            <th>Kategori</th>

                            <th>Teknisi</th>

                            <th>Tanggal Laporan</th>

                            <th>Tanggal Pengecekan</th>

                            <th>Tanggal Diverifikasi</th>

                            <th>Tanggal Selesai</th>

                            <th>Status</th>

                            <th>Detail</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($laporans as $laporan)

                                    <tr>

                                        {{-- NOMOR --}}

                                        <td>

                                            <div class="report-number">
                                                {{ $laporan->nomor_laporan }}
                                            </div>

                                        </td>


                                        {{-- JUDUL --}}

                                        <td>

                                            <div class="report-title" title="{{ $laporan->judul_laporan }}">
                                                {{ $laporan->judul_laporan }}
                                            </div>

                                        </td>


                                        {{-- PELAPOR --}}

                                        <td>

                                            <div class="pelapor" title="{{ $laporan->user->name ?? '-' }}">
                                                {{ $laporan->user->name ?? '-' }}
                                            </div>

                                        </td>


                                        {{-- KATEGORI --}}

                                        <td>

                                            {{ $laporan->kategori->nama ?? '-' }}

                                        </td>


                                        {{-- TEKNISI --}}

                                        <td>

                                            <div class="teknisi" title="{{ $laporan->teknisi->nama ?? '-' }}">
                                                {{ $laporan->teknisi->nama ?? '-' }}
                                            </div>

                                        </td>


                                        {{-- TANGGAL LAPORAN --}}

                                        <td>
                                            <div class="date">
                                                {{ $laporan->created_at?->format('d/m/Y') ?? '-' }}
                                            </div>
                                        </td>

                                        {{-- TANGGAL PENGECEKAN --}}

                                        <td>
                                            <div class="date">
                                                {{ $laporan->tanggal_pengecekan?->format('d/m/Y') ?? '-' }}
                                            </div>
                                        </td>

                                        {{-- TANGGAL DIVERIFIKASI --}}

                                        <td>
                                            <div class="date">
                                                {{ $laporan->diverifikasi_biro_at?->format('d/m/Y') ?? '-' }}
                                            </div>
                                        </td>

                                        {{-- TANGGAL SELESAI --}}

                                        <td>
                                            <div class="date">
                                                {{ $laporan->status === 'selesai' ? ($laporan->updated_at?->format('d/m/Y') ?? '-') : '-' }}
                                            </div>
                                        </td>


                                        {{-- STATUS --}}

                                        <td>

                                            @if($laporan->status === 'selesai')

                                                <span class="status-badge status-selesai">
                                                    Selesai
                                                </span>

                                            @elseif($laporan->status === 'ditolak')

                                                <span class="status-badge status-ditolak">
                                                    Ditolak
                                                </span>

                                            @endif

                                        </td>


                                        {{-- DETAIL --}}

                                        <td>

                                            <a href="{{ route(
                                'admin.biro.riwayat.detail',
                                $laporan->id
                            ) }}" class="btn-detail">
                                                Detail
                                            </a>

                                        </td>

                                    </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- =========================
            FOOTER
            ========================== --}}

            <div class="table-footer">

                <div class="pagination">

                    {{-- PREVIOUS --}}

                    @if($laporans->onFirstPage())

                        <div class="disabled">

                            <span>

                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">

                                    <path d="m15 18-6-6 6-6" />

                                </svg>

                            </span>

                        </div>

                    @else

                        <a href="{{ $laporans->previousPageUrl() }}">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">

                                <path d="m15 18-6-6 6-6" />

                            </svg>

                        </a>

                    @endif


                    {{-- NUMBER --}}

                    @foreach(
                            $laporans->getUrlRange(
                                max(1, $laporans->currentPage() - 1),
                                min(
                                    $laporans->lastPage(),
                                    $laporans->currentPage() + 1
                                )
                            ) as $page => $url
                        )

                        @if($page == $laporans->currentPage())

                            <div class="active">
                                <span>{{ $page }}</span>
                            </div>

                        @else

                            <a href="{{ $url }}">
                                {{ $page }}
                            </a>

                        @endif

                    @endforeach


                    {{-- NEXT --}}

                    @if($laporans->hasMorePages())

                        <a href="{{ $laporans->nextPageUrl() }}">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">

                                <path d="m9 18 6-6-6-6" />

                            </svg>

                        </a>

                    @else

                        <div class="disabled">

                            <span>

                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">

                                    <path d="m9 18 6-6-6-6" />

                                </svg>

                            </span>

                        </div>

                    @endif</div>


                        {{-- DATA PER HALAMAN --}}

                        <div class="per-page">

                            <span>Data per halaman</span>

                            <form action="{{ route('admin.biro.riwayat') }}" method="GET">

                                @if(request('search'))

                                    <input type="hidden" name="search" value="{{ request('search') }}">

                                @endif

                                @if(request('status'))

                                    <input type="hidden" name="status" value="{{ request('status') }}">

                                @endif

                                @if(request('kategori'))

                                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">

                                @endif

                                @if(request('tanggal'))

                                    <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">

                                @endif

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

                    </div>

        @else

                {{-- EMPTY STATE --}}

                <div class="empty-state">

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">

                        <rect x="5" y="3" width="14" height="18" rx="2" />
                        <path d="M9 8h6" />
                        <path d="M9 12h6" />
                        <path d="M9 16h3" />

                    </svg>

                    <h3>
                        Belum Ada Riwayat Laporan
                    </h3>

                    <p>
                        Belum terdapat laporan yang telah selesai atau ditolak.
                    </p>

                </div>

            @endif

        </div>

@endsection