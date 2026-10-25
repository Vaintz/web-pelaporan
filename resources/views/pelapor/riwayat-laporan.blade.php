@extends('layouts.dashboard')

@section('title', 'Riwayat Laporan')

@section('content')

<style>

/* =========================================================
   PAGE
========================================================= */

.riwayat-page {
    width: 100%;
    margin: 0;
    padding: 0;
}


/* =========================================================
   STATISTIC CARDS
========================================================= */

.stat-grid {
    width: 100%;

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 20px;

    margin-bottom: 38px;
}


.stat-card {
    height: 128px;

    padding: 18px 16px;

    background: #ffffff;

    border: 1px solid #dfe4ec;

    border-radius: 20px;

    display: flex;

    align-items: center;

    box-shadow:
        0 2px 3px rgba(0, 0, 0, 0.17);
}


/* =========================================================
   STAT ICON
========================================================= */

.stat-icon {
    width: 58px;
    height: 58px;

    min-width: 58px;

    border-radius: 50%;

    display: flex;

    align-items: center;
    justify-content: center;
}


.stat-icon svg {
    width: 30px;
    height: 30px;

    stroke-width: 2;
}


.icon-blue {
    background: #dceaff;
    color: #0967e8;
}


.icon-orange {
    background: #fff0d6;
    color: #ff7900;
}


.icon-green {
    background: #d9f2e4;
    color: #009d4d;
}


.icon-red {
    background: #ffdadd;
    color: #ff252d;
}


/* =========================================================
   STAT CONTENT
========================================================= */

.stat-content {
    flex: 1;

    text-align: center;

    padding-right: 8px;
}


.stat-title {
    margin-bottom: 8px;

    color: #202235;

    font-size: 14px;

    font-weight: 700;
}


.stat-number {
    margin-bottom: 9px;

    color: #171929;

    font-size: 25px;

    line-height: 1;

    font-weight: 700;
}


.stat-description {
    color: #202235;

    font-size: 11px;
}


/* =========================================================
   FILTER
========================================================= */

.filter-card {
    width: 100%;

    height: 85px;

    padding: 19px 20px;

    margin-bottom: 39px;

    background: #ffffff;

    border: 1px solid #d9dde6;

    border-radius: 15px;

    display: flex;

    align-items: center;

    box-shadow:
        0 3px 4px rgba(0, 0, 0, 0.14);
}


.filter-form {
    width: 100%;

    height: 46px;

    display: grid;

    grid-template-columns:
        minmax(0, 1.7fr)
        minmax(0, 1fr)
        minmax(0, 1fr)
        minmax(0, 1fr);

    gap: 14px;
}


/* =========================================================
   SEARCH
========================================================= */

.search-wrapper {
    width: 100%;

    height: 46px;

    position: relative;
}


.search-icon {
    position: absolute;

    left: 17px;
    top: 50%;

    width: 18px;
    height: 18px;

    transform: translateY(-50%);

    color: #8d97aa;

    pointer-events: none;
}


.search-icon svg {
    width: 18px;
    height: 18px;

    display: block;
}


.filter-input,
.filter-select {
    width: 100%;

    height: 46px;

    background: #ffffff;

    border: 1px solid #aeb7c8;

    border-radius: 9px;

    color: #606778;

    font-family: Arial, sans-serif;

    font-size: 11px;

    outline: none;
}


.filter-input {
    padding: 0 14px 0 48px;
}


.filter-input::placeholder {
    color: #9aa2b3;

    opacity: 1;
}


.filter-select {
    padding: 0 40px 0 14px;

    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;

    cursor: pointer;
}


/* =========================================================
   SELECT ICON
========================================================= */

.select-wrapper {
    position: relative;

    width: 100%;

    height: 46px;
}


.select-wrapper .filter-select {
    position: absolute;

    inset: 0;
}


.select-icon {
    position: absolute;

    right: 13px;
    top: 50%;

    width: 17px;
    height: 17px;

    transform: translateY(-50%);

    color: #7e8799;

    pointer-events: none;
}


.select-icon svg {
    width: 17px;
    height: 17px;

    display: block;
}


/* =========================================================
   TABLE CARD
========================================================= */

.table-card {
    width: 100%;

    background: #ffffff;

    border: 1px solid #dfe2e8;

    border-radius: 16px;

    overflow: hidden;

    box-shadow:
        0 3px 5px rgba(0, 0, 0, 0.15);
}


/* =========================================================
   TABLE
========================================================= */

.table-wrapper {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.report-table {
    width: 100%;
    min-width: 900px;
    border-collapse: collapse;
    table-layout: fixed;
}


/* =========================================================
   HEADER
========================================================= */

.report-table th {
    height: 50px;

    padding: 0 17px;

    background: #ffffff;

    border-bottom: 1px solid #dfe1e6;

    color: #252535;

    font-size: 14px;

    font-weight: 700;

    line-height: 1;

    text-align: left;

    vertical-align: middle;

    white-space: nowrap;
}


/* =========================================================
   BODY
========================================================= */

.report-table td {
    height: 61px;

    padding: 0 17px;

    background: #ffffff;

    border-bottom: 1px solid #e1e2e6;

    color: #252535;

    font-size: 14px;

    font-weight: 400;

    line-height: 1.2;

    vertical-align: middle;
}

.report-table tbody tr:last-child td {
    border-bottom: none;
}


/* =========================================================
   COLUMN
========================================================= */

.report-table th:nth-child(1),
.report-table td:nth-child(1) {
    width: 17%;
}

.report-table th:nth-child(2),
.report-table td:nth-child(2) {
    width: 21%;
}

.report-table th:nth-child(3),
.report-table td:nth-child(3) {
    width: 15%;
}

.report-table th:nth-child(4),
.report-table td:nth-child(4) {
    width: 18%;
}

.report-table th:nth-child(5),
.report-table td:nth-child(5) {
    width: 19%;
    text-align: center;
}

.report-table th:nth-child(6),
.report-table td:nth-child(6) {
    width: 10%;
    text-align: center;
}


/* =========================================================
   TEXT
========================================================= */

.report-number {
    color: #252535;

    font-size: 14px;

    font-weight: 500;

    white-space: nowrap;
}

.report-title {
    width: 100%;

    color: #252535;

    font-size: 14px;

    font-weight: 500;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;
}

.category {
    max-width: 150px;

    color: #252535;

    font-size: 14px;

    line-height: 1.2;
}

.date {
    color: #252535;

    font-size: 14px;

    white-space: nowrap;
}


/* =========================================================
   STATUS
========================================================= */

.status-badge {
    min-width: 104px;

    height: 32px;

    padding: 0 12px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    font-size: 12px;

    font-weight: 700;

    line-height: 1;

    white-space: nowrap;
}

.status-menunggu {
    background: #fff0dc;
    color: #ee8200;
}

.status-diproses {
    background: #e2edff;
    color: #2664d4;
}

.status-selesai {
    background: #dcf2e3;
    color: #14833f;
}

.status-ditolak {
    background: #ffe0e0;
    color: #ef2d2d;
}

.status-diverifikasi {
    background: #e5eaff;
    color: #4e5dc7;
}


/* =========================================================
   DETAIL
========================================================= */

.btn-detail {
    width: 58px;

    height: 34px;

    padding: 0;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    background: #ffffff;

    border: 1px solid #99a2b5;

    border-radius: 9px;

    color: #252535;

    font-size: 12px;

    font-weight: 500;

    line-height: 1;

    text-decoration: none;
}


/* =========================================================
   FOOTER
========================================================= */

.table-footer {
    position: relative;

    height: 76px;

    padding: 0 16px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    background: #ffffff;

    border-top: 1px solid #dfe1e6;
}


/* =========================================================
   PAGINATION
========================================================= */

.pagination {
    position: absolute;

    left: 50%;
    top: 50%;

    transform: translate(-50%, -50%);

    display: flex;

    align-items: center;

    gap: 7px;
}

.pagination a,
.pagination span {
    width: 39px;

    height: 39px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #ffffff;

    border: 1px solid #aeb6c7;

    border-radius: 9px;

    color: #858da0;

    font-size: 12px;

    line-height: 1;

    text-decoration: none;
}

.pagination .active span {
    background: #25243d;

    border-color: #25243d;

    color: #ffffff;
}

.pagination .disabled span {
    color: #b8bdc7;

    background: #ffffff;
}

.pagination svg {
    width: 17px;
    height: 17px;
}


/* =========================================================
   PER PAGE
========================================================= */

.per-page {
    margin-left: auto;

    display: flex;

    align-items: center;

    gap: 8px;

    color: #9a9eaa;

    font-size: 10px;

    white-space: nowrap;
}

.per-page-select {
    position: relative;

    width: 58px;
    height: 39px;
}

.per-page select {
    width: 100%;
    height: 39px;

    padding: 0 23px 0 9px;

    background: #ffffff;

    border: 1px solid #aeb6c7;

    border-radius: 9px;

    color: #737b8e;

    font-size: 10px;

    outline: none;

    appearance: none;
}

.per-page-icon {
    position: absolute;

    right: 6px;
    top: 50%;

    width: 13px;
    height: 13px;

    transform: translateY(-50%);

    color: #7e8799;

    pointer-events: none;
}

.per-page-icon svg {
    width: 13px;
    height: 13px;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.empty-state {
    padding: 60px 20px;

    text-align: center;
}


.empty-state h3 {
    margin: 0 0 7px;

    color: #30303b;

    font-size: 15px;
}


.empty-state p {
    margin: 0 0 20px;

    color: #9296a0;

    font-size: 11px;
}


.btn-ajukan {
    height: 38px;

    padding: 0 18px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    background: #25243d;

    border-radius: 8px;

    color: #ffffff;

    font-size: 10px;

    font-weight: 700;

    text-decoration: none;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .stat-grid {
        gap: 12px;
    }

    .stat-card {
        padding: 15px;

        gap: 10px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;

        min-width: 48px;
    }

    .stat-title {
        font-size: 10px;
    }

    .stat-number {
        font-size: 22px;
    }

    .stat-description {
        font-size: 8px;
    }

}


@media (max-width: 800px) {

    .stat-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 24px;
    }

    .stat-card {
        height: auto;
        min-height: 104px;
        padding: 14px;
        gap: 10px;
        border-radius: 15px;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
    }

    .stat-icon svg {
        width: 23px;
        height: 23px;
    }

    .stat-title {
        font-size: 11px;
        line-height: 1.3;
    }

    .stat-number {
        font-size: 22px;
        margin-bottom: 6px;
    }

    .stat-description {
        font-size: 9px;
        line-height: 1.3;
    }

    .filter-card {
        height: auto;
        padding: 15px;
        margin-bottom: 24px;
    }

    .filter-form {
        height: auto;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .search-wrapper,
    .select-wrapper {
        min-width: 0;
    }

    .filter-input,
    .filter-select {
        min-width: 0;
        font-size: 12px;
    }

    .filter-input {
        padding-left: 40px;
    }

    .filter-select {
        padding-left: 10px;
        padding-right: 30px;
        text-overflow: ellipsis;
    }

    .table-footer {
        padding-left: 12px;
        padding-right: 12px;
    }

}


@media (max-width: 550px) {

    .stat-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .stat-card {
        min-height: 94px;
        padding: 10px;
        gap: 7px;
    }

    .stat-icon {
        width: 34px;
        height: 34px;
        min-width: 34px;
    }

    .stat-icon svg {
        width: 20px;
        height: 20px;
    }

    .stat-content {
        min-width: 0;
        padding-right: 0;
    }

    .stat-title {
        font-size: 10px;
        margin-bottom: 6px;
    }

    .stat-number {
        font-size: 20px;
    }

    .stat-description {
        font-size: 8px;
    }

    .filter-card {
        padding: 12px;
        border-radius: 12px;
    }

    .filter-form {
        grid-template-columns: minmax(0, 1fr);
        gap: 9px;
    }

    .filter-input,
    .filter-select {
        font-size: 12px;
    }

    .table-footer {
        height: auto;
        padding: 14px 10px;
        flex-direction: column;
        gap: 14px;
    }

    .pagination {
        position: static;
        transform: none;
        max-width: 100%;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination a,
    .pagination span {
        width: 34px;
        height: 34px;
    }

    .per-page {
        margin-left: 0;
        justify-content: center;
        white-space: normal;
    }

    .empty-state {
        padding: 40px 16px;
    }

    .report-table th,
    .report-table td {
        padding-left: 12px;
        padding-right: 12px;
    }

}


/* =========================================================
   STATISTIK
========================================================= */

</style>


<div class="riwayat-page">


    {{-- =====================================================
        STATISTIK
    ====================================================== --}}

    <div class="stat-grid">


        {{-- TOTAL LAPORAN --}}

        <div class="stat-card">

            <div class="stat-icon icon-blue">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >

                    <rect
                        x="5"
                        y="3"
                        width="14"
                        height="18"
                        rx="1"
                    />

                    <path d="M9 7h6" />

                    <path d="M9 11h6" />

                    <path d="M9 15h2" />

                    <path d="M14 15h1" />

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
                    Laporan Anda
                </div>

            </div>

        </div>


        {{-- DALAM PROSES --}}

        <div class="stat-card">

            <div class="stat-icon icon-orange">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >

                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />

                    <path d="M12 7v5l3 2" />

                </svg>

            </div>


            <div class="stat-content">

                <div class="stat-title">
                    Dalam Proses
                </div>

                <div class="stat-number">
                    {{ $dalamProses }}
                </div>

                <div class="stat-description">
                    Sedang Diproses
                </div>

            </div>

        </div>


        {{-- SELESAI --}}

        <div class="stat-card">

            <div class="stat-icon icon-green">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >

                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />

                    <path d="M8 12l3 3 5-6" />

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
                    Sudah Selesai
                </div>

            </div>

        </div>


        {{-- DITOLAK --}}

        <div class="stat-card">

            <div class="stat-icon icon-red">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >

                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />

                    <path d="M9 9l6 6" />

                    <path d="M15 9l-6 6" />

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
                    Laporan Ditolak
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        FILTER
    ====================================================== --}}

    <div class="filter-card">

        <form
            action="{{ route('pelapor.riwayat') }}"
            method="GET"
            class="filter-form"
        >


            {{-- SEARCH --}}

            <div class="search-wrapper">

                <span class="search-icon">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <circle
                            cx="11"
                            cy="11"
                            r="7"
                        />

                        <path d="m20 20-4-4" />

                    </svg>

                </span>


                <input
                    type="text"
                    name="search"
                    class="filter-input"
                    placeholder="Cari berdasarkan nomor atau judul laporan"
                    value="{{ request('search') }}"
                >

            </div>


            {{-- STATUS --}}

            <div class="select-wrapper">

                <select
                    name="status"
                    class="filter-select"
                    onchange="this.form.submit()"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="menunggu_verifikasi"
                        {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}
                    >
                        Menunggu Verifikasi
                    </option>

                    <option
                        value="diverifikasi"
                        {{ request('status') == 'diverifikasi' ? 'selected' : '' }}
                    >
                        Diverifikasi
                    </option>

                    <option
                        value="diproses"
                        {{ request('status') == 'diproses' ? 'selected' : '' }}
                    >
                        Diproses
                    </option>

                    <option
                        value="selesai"
                        {{ request('status') == 'selesai' ? 'selected' : '' }}
                    >
                        Selesai
                    </option>

                    <option
                        value="ditolak"
                        {{ request('status') == 'ditolak' ? 'selected' : '' }}
                    >
                        Ditolak
                    </option>

                </select>


                <span class="select-icon">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <path d="m6 9 6 6 6-6" />

                    </svg>

                </span>

            </div>


            {{-- KATEGORI --}}

            <div class="select-wrapper">

                <select
                    name="kategori"
                    class="filter-select"
                    onchange="this.form.submit()"
                >

                    <option value="">
                        Semua Kategori
                    </option>

                    @foreach($kategori as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ request('kategori') == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama }}
                        </option>

                    @endforeach

                </select>


                <span class="select-icon">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <path d="m6 9 6 6 6-6" />

                    </svg>

                </span>

            </div>


            {{-- TANGGAL --}}

            <div class="select-wrapper">

                <select
                    name="tanggal"
                    class="filter-select"
                    onchange="this.form.submit()"
                >

                    <option value="">
                        Semua Tanggal
                    </option>

                    <option
                        value="hari_ini"
                        {{ request('tanggal') == 'hari_ini' ? 'selected' : '' }}
                    >
                        Hari Ini
                    </option>

                    <option
                        value="7_hari"
                        {{ request('tanggal') == '7_hari' ? 'selected' : '' }}
                    >
                        7 Hari Terakhir
                    </option>

                    <option
                        value="30_hari"
                        {{ request('tanggal') == '30_hari' ? 'selected' : '' }}
                    >
                        30 Hari Terakhir
                    </option>

                </select>


                <span class="select-icon">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <path d="m6 9 6 6 6-6" />

                    </svg>

                </span>

            </div>

        </form>

    </div>


    {{-- =====================================================
        TABLE
    ====================================================== --}}

    <div class="table-card">

        @if($laporans->count() > 0)

            <div class="table-wrapper">

                <table class="report-table">

                    <thead>

                        <tr>

                            <th>
                                No. Laporan
                            </th>

                            <th>
                                Judul Laporan
                            </th>

                            <th>
                                Kategori
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($laporans as $laporan)

                            <tr>


                                {{-- NO LAPORAN --}}

                                <td>

                                    <div class="report-number">
                                        {{ $laporan->nomor_laporan }}
                                    </div>

                                </td>


                                {{-- JUDUL --}}

                                <td>

                                    <div
                                        class="report-title"
                                        title="{{ $laporan->judul_laporan }}"
                                    >
                                        {{ $laporan->judul_laporan }}
                                    </div>

                                </td>


                                {{-- KATEGORI --}}

                                <td>

                                    <div class="category">
                                        {{ $laporan->kategori->nama ?? '-' }}
                                    </div>

                                </td>


                                {{-- TANGGAL --}}

                                <td>

                                    <div class="date">

                                        {{ $laporan->created_at->format('d F Y') }}

                                    </div>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @php

                                        $statusClass = match ($laporan->status) {

                                            'menunggu_verifikasi'
                                                => 'status-menunggu',

                                            'diverifikasi'
                                                => 'status-diverifikasi',

                                            'diproses'
                                                => 'status-diproses',

                                            'selesai'
                                                => 'status-selesai',

                                            'ditolak'
                                                => 'status-ditolak',

                                            default
                                                => 'status-menunggu',

                                        };


                                        $statusText = match ($laporan->status) {

                                            'menunggu_verifikasi'
                                                => 'Menunggu Verifikasi',

                                            'diverifikasi'
                                                => 'Diverifikasi',

                                            'diproses'
                                                => 'Diproses',

                                            'selesai'
                                                => 'Selesai',

                                            'ditolak'
                                                => 'Ditolak',

                                            default
                                                => ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $laporan->status
                                                    )
                                                ),

                                        };

                                    @endphp


                                    <span
                                        class="status-badge {{ $statusClass }}"
                                    >
                                        {{ $statusText }}
                                    </span>

                                </td>


                                {{-- DETAIL --}}

                                <td>

                                    <a
                                        href="{{ route(
                                            'pelapor.laporan.detail',
                                            $laporan->id
                                        ) }}"
                                        class="btn-detail"
                                    >
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- =====================================================
                TABLE FOOTER
            ====================================================== --}}

            <div class="table-footer">


                {{-- PAGINATION --}}

                <div class="pagination">


                    {{-- PREVIOUS --}}

                    @if($laporans->onFirstPage())

                        <div class="disabled">

                            <span>

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >

                                    <path d="m15 18-6-6 6-6" />

                                </svg>

                            </span>

                        </div>

                    @else

                        <a href="{{ $laporans->previousPageUrl() }}">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="m15 18-6-6 6-6" />

                            </svg>

                        </a>

                    @endif


                    {{-- PAGE NUMBERS --}}

                    @foreach(
                        $laporans->getUrlRange(
                            1,
                            min(3, $laporans->lastPage())
                        )
                        as $page => $url
                    )

                        @if($page == $laporans->currentPage())

                            <div class="active">

                                <span>
                                    {{ $page }}
                                </span>

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

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="m9 18 6-6-6-6" />

                            </svg>

                        </a>

                    @else

                        <div class="disabled">

                            <span>

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >

                                    <path d="m9 18 6-6-6-6" />

                                </svg>

                            </span>

                        </div>

                    @endif

                </div>


                {{-- =================================================
                    DATA PER PAGE
                ================================================== --}}

                <div class="per-page">

                    <form
                        action="{{ route('pelapor.riwayat') }}"
                        method="GET"
                    >


                        @if(request('search'))

                            <input
                                type="hidden"
                                name="search"
                                value="{{ request('search') }}"
                            >

                        @endif


                        @if(request('status'))

                            <input
                                type="hidden"
                                name="status"
                                value="{{ request('status') }}"
                            >

                        @endif


                        @if(request('kategori'))

                            <input
                                type="hidden"
                                name="kategori"
                                value="{{ request('kategori') }}"
                            >

                        @endif


                        @if(request('tanggal'))

                            <input
                                type="hidden"
                                name="tanggal"
                                value="{{ request('tanggal') }}"
                            >

                        @endif


                        <div class="per-page-select">

                            <select
                                name="per_page"
                                onchange="this.form.submit()"
                            >

                                <option
                                    value="5"
                                    {{ request('per_page', 5) == 5 ? 'selected' : '' }}
                                >
                                    5
                                </option>

                                <option
                                    value="10"
                                    {{ request('per_page') == 10 ? 'selected' : '' }}
                                >
                                    10
                                </option>

                                <option
                                    value="50"
                                    {{ request('per_page') == 50 ? 'selected' : '' }}
                                >
                                    50
                                </option>

                            </select>


                            <span class="per-page-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >

                                    <path d="m6 9 6 6 6-6" />

                                </svg>

                            </span>

                        </div>

                    </form>


                    <span>
                        data per halaman
                    </span>

                </div>

            </div>


        @else


            {{-- =====================================================
                EMPTY STATE
            ====================================================== --}}

            <div class="empty-state">

                <h3>
                    Belum Ada Laporan
                </h3>

                <p>
                    Belum ada laporan yang sesuai dengan pencarian atau filter.
                </p>

                <a
                    href="{{ route('pelapor.ajukan') }}"
                    class="btn-ajukan"
                >
                    Ajukan Laporan
                </a>

            </div>

        @endif

    </div>

</div>

@endsection