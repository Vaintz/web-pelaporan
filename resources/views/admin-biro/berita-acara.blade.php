@extends('layouts.dashboard')

@section('title', 'Berita Acara')

@section('content')

    <style>
        .ba-list-page {
            padding-bottom: 30px;
        }

        .ba-page-header {
            margin-bottom: 22px;
        }

        .ba-page-header h1 {
            margin: 0;
            font-size: 25px;
            font-weight: 700;
            color: #25243a;
        }

        .ba-page-header p {
            margin: 6px 0 0;
            color: #9295a5;
            font-size: 13px;
        }

        .ba-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .ba-stat {
            background: #fff;
            border: 1px solid #e2e2e8;
            border-radius: 11px;
            padding: 18px 20px;
            box-shadow: 0 3px 7px rgba(0, 0, 0, .08);
        }

        .ba-stat-label {
            color: #858898;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .ba-stat-value {
            color: #25243a;
            font-size: 24px;
            font-weight: 800;
        }

        .ba-filter {
            background: #fff;
            border: 1px solid #e2e2e8;
            border-radius: 11px;
            padding: 18px;
            margin-bottom: 20px;
            box-shadow: 0 3px 7px rgba(0, 0, 0, .06);
        }

        .ba-filter-row {
            display: flex;
            align-items: end;
            gap: 12px;
            flex-wrap: wrap;
        }

        .ba-filter-group {
            flex: 1;
            min-width: 190px;
        }

        .ba-filter-group label {
            display: block;
            margin-bottom: 7px;
            color: #37364b;
            font-size: 12px;
            font-weight: 700;
        }

        .ba-filter-group input,
        .ba-filter-group select {
            width: 100%;
            height: 40px;
            box-sizing: border-box;
            border: 1px solid #d8d8df;
            border-radius: 8px;
            padding: 0 12px;
            outline: none;
            color: #353448;
            background: #fff;
            font-size: 13px;
        }

        .ba-filter-actions {
            display: flex;
            gap: 8px;
        }

        .ba-btn-search,
        .ba-btn-reset {
            height: 40px;
            padding: 0 17px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .ba-btn-search {
            border: 1px solid #25243a;
            background: #25243a;
            color: #fff;
        }

        .ba-btn-reset {
            border: 1px solid #d8d8df;
            background: #fff;
            color: #353448;
        }

        .ba-table-card {
            background: #fff;
            border: 1px solid #e2e2e8;
            border-radius: 11px;
            overflow: hidden;
            box-shadow: 0 3px 7px rgba(0, 0, 0, .06);
        }

        .ba-table-header {
            padding: 18px 20px;
            border-bottom: 1px solid #e9e9ee;
        }

        .ba-table-header h3 {
            margin: 0;
            color: #25243a;
            font-size: 16px;
            font-weight: 800;
        }

        .ba-table-header p {
            margin: 5px 0 0;
            color: #9295a5;
            font-size: 12px;
        }

        .ba-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .ba-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        .ba-table th {
            background: #f8f8fa;
            padding: 13px 15px;
            text-align: left;
            color: #77798a;
            font-size: 11px;
            font-weight: 800;
            border-bottom: 1px solid #e6e6eb;
            white-space: nowrap;
        }

        .ba-table td {
            padding: 14px 15px;
            border-bottom: 1px solid #eeeeF2;
            color: #363548;
            font-size: 13px;
            vertical-align: middle;
        }

        .ba-table tr:last-child td {
            border-bottom: none;
        }

        .ba-number {
            color: #25243a;
            font-weight: 800;
            white-space: nowrap;
        }

        .ba-title-cell {
            max-width: 250px;
            font-weight: 700;
        }

        .ba-title-cell span {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ba-pelapor {
            font-weight: 600;
            white-space: nowrap;
        }

        .ba-kategori {
            display: inline-flex;
            padding: 5px 9px;
            border-radius: 6px;
            background: #f2f2f5;
            color: #4e4d60;
            font-size: 11px;
            font-weight: 700;
        }

        .ba-teknisi {
            white-space: nowrap;
        }

        .ba-status {
            display: inline-flex;
            padding: 6px 11px;
            border-radius: 7px;
            background: #e5f8e9;
            color: #18752e;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .ba-detail {
            display: inline-flex;
            height: 34px;
            padding: 0 12px;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
            background: #25243a;
            color: #fff;
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .ba-empty {
            padding: 60px 20px;
            text-align: center;
            color: #9295a5;
        }

        .ba-footer {
            display: grid;
            grid-template-columns: minmax(180px, 1fr) auto minmax(180px, 1fr);
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            border-top: 1px solid #e9e9ee;
        }

        .ba-footer>.ba-info {
            grid-column: 1;
            justify-self: start;
        }

        .ba-footer>.ba-per-page {
            grid-column: 3;
            grid-row: 1;
            justify-self: end;
        }

        .ba-footer>.ba-pagination {
            grid-column: 2;
            grid-row: 1;
            justify-self: center;
        }

        .ba-info {
            color: #858898;
            font-size: 12px;
        }

        .ba-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 5px;
            min-width: 0;
        }

        .ba-pagination nav {
            display: flex;
            gap: 4px;
        }

        .ba-pagination svg {
            width: 15px;
            height: 15px;
        }

        .ba-pagination a,
        .ba-pagination span {
            min-width: 30px;
            height: 30px;
            padding: 0 7px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
        }

        .ba-pagination a {
            border: 1px solid #dedee5;
            color: #4a495b;
        }

        .ba-pagination .is-active {
            border: 1px solid #25243a;
            background: #25243a;
            color: #fff;
        }

        .ba-pagination .is-disabled {
            border: 1px solid #ececf0;
            color: #bfc1ca;
            pointer-events: none;
        }

        .ba-per-page {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #858898;
            font-size: 12px;
        }

        .ba-per-page select {
            height: 32px;
            border: 1px solid #d8d8df;
            border-radius: 6px;
            padding: 0 7px;
            background: #fff;
        }

        @media (max-width: 900px) {
            .ba-footer {
                grid-template-columns: 1fr;
                justify-items: center;
            }

            .ba-footer>.ba-info,
            .ba-footer>.ba-per-page,
            .ba-footer>.ba-pagination {
                grid-column: 1;
                grid-row: auto;
                justify-self: center;
            }

            .ba-stats {
                grid-template-columns: 1fr;
            }

            .ba-filter-row {
                flex-direction: column;
                align-items: stretch;
            }

            .ba-filter-group {
                min-width: 100%;
            }

            .ba-filter-actions {
                width: 100%;
            }

            .ba-btn-search,
            .ba-btn-reset {
                flex: 1;
            }
        }
    </style>

    <div class="ba-list-page">

        <div class="ba-stats">

            <div class="ba-stat">
                <div class="ba-stat-label">Total Berita Acara</div>
                <div class="ba-stat-value">
                    {{ $totalBeritaAcara }}
                </div>
            </div>

            <div class="ba-stat">
                <div class="ba-stat-label">Selesai Bulan Ini</div>
                <div class="ba-stat-value">
                    {{ $bulanIni }}
                </div>
            </div>

            <div class="ba-stat">
                <div class="ba-stat-label">Ditangani Teknisi</div>
                <div class="ba-stat-value">
                    {{ $denganTeknisi }}
                </div>
            </div>

        </div>

        <div class="ba-filter">

            <form method="GET" action="{{ route('admin.biro.berita') }}">

                <div class="ba-filter-row">

                    <div class="ba-filter-group">
                        <label>Cari Laporan</label>

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nomor, judul, atau nama pelapor...">
                    </div>

                    <div class="ba-filter-group">
                        <label>Kategori</label>

                        <select name="kategori">
                            <option value="">Semua Kategori</option>

                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ request('kategori') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="ba-filter-group">
                        <label>Periode</label>

                        <select name="tanggal">
                            <option value="">Semua Waktu</option>

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
                    </div>

                    <div class="ba-filter-actions">
                        <button type="submit" class="ba-btn-search">
                            Cari
                        </button>

                        <a href="{{ route('admin.biro.berita') }}" class="ba-btn-reset">
                            Reset
                        </a>
                    </div>

                </div>

            </form>

        </div>

        <div class="ba-table-card">

            <div class="ba-table-header">
                <h3>Daftar Berita Acara</h3>

                <p>
                    Hanya laporan dengan status selesai yang ditampilkan.
                </p>
            </div>

            <div class="ba-table-wrapper">

                <table class="ba-table">

                    <thead>
                        <tr>
                            <th>Nomor BA</th>
                            <th>Nomor Laporan</th>
                            <th>Judul Laporan</th>
                            <th>Pelapor</th>
                            <th>Kategori</th>
                            <th>Teknisi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($laporans as $laporan)

                                            <tr>

                                                <td>
                                                    <span class="ba-number">
                                                        BA/UM/{{ $laporan->nomor_laporan }}
                                                    </span>
                                                </td>

                                                <td>
                                                    {{ $laporan->nomor_laporan }}
                                                </td>

                                                <td>
                                                    <div class="ba-title-cell">
                                                        <span title="{{ $laporan->judul_laporan }}">
                                                            {{ $laporan->judul_laporan }}
                                                        </span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="ba-pelapor">
                                                        {{ $laporan->user?->name ?? '-' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="ba-kategori">
                                                        {{ $laporan->kategori?->nama ?? '-' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="ba-teknisi">
                                                        {{ $laporan->teknisi?->nama ?? '-' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="ba-status">
                                                        Selesai
                                                    </span>
                                                </td>

                                                <td>
                                                    <a href="{{ route(
                                'admin.biro.berita.detail',
                                $laporan
                            ) }}" class="ba-detail">
                                                        Lihat Berita Acara
                                                    </a>
                                                </td>

                                            </tr>

                        @empty

                            <tr>
                                <td colspan="8">

                                    <div class="ba-empty">
                                        Belum ada laporan selesai yang dapat
                                        dibuat menjadi berita acara.
                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if ($laporans->count() > 0)

                <div class="ba-footer">

                    <div class="ba-info">
                        Menampilkan
                        <strong>{{ $laporans->firstItem() }}</strong>
                        -
                        <strong>{{ $laporans->lastItem() }}</strong>
                        dari
                        <strong>{{ $laporans->total() }}</strong>
                        berita acara
                    </div>

                    <div class="ba-per-page">

                        <span>Data per halaman</span>

                        <form method="GET" action="{{ route('admin.biro.berita') }}">

                            <input type="hidden" name="search" value="{{ request('search') }}">

                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">

                            <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">

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

                    <div class="ba-pagination" aria-label="Navigasi halaman">
                        @if ($laporans->hasPages())
                            <a href="{{ $laporans->previousPageUrl() ?? '#' }}"
                                class="{{ $laporans->onFirstPage() ? 'is-disabled' : '' }}" @if($laporans->onFirstPage())
                                aria-disabled="true" tabindex="-1" @endif>
                                &lsaquo; Sebelumnya
                            </a>

                            @for ($page = 1; $page <= $laporans->lastPage(); $page++)
                                @if ($page === $laporans->currentPage())
                                    <span class="is-active" aria-current="page">{{ $page }}</span>
                                @else
                                    <a href="{{ $laporans->url($page) }}">{{ $page }}</a>
                                @endif
                            @endfor

                            <a href="{{ $laporans->nextPageUrl() ?? '#' }}"
                                class="{{ $laporans->hasMorePages() ? '' : 'is-disabled' }}" @unless($laporans->hasMorePages())
                                aria-disabled="true" tabindex="-1" @endunless>
                                Berikutnya &rsaquo;
                            </a>
                        @endif
                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection