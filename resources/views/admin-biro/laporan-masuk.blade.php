@extends('layouts.dashboard')

@section('title', 'Laporan Masuk')

@section('content')

<style>
    .page-header {
        margin-bottom: 24px;
    }

    .page-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .page-header p {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .filter-card,
    .table-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid #eef0f3;
    }

    .filter-card {
        padding: 20px;
        margin-bottom: 20px;
    }

    .filter-row {
        display: flex;
        align-items: end;
        gap: 16px;
        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .filter-group input,
    .filter-group select {
        width: 100%;
        height: 42px;
        padding: 0 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        color: #374151;
        background: #fff;
        outline: none;
        transition: 0.2s;
        box-sizing: border-box;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
    }

    .filter-actions {
        display: flex;
        gap: 8px;
    }

    .btn-filter {
        height: 42px;
        padding: 0 18px;
        border: none;
        border-radius: 8px;
        background: #4f46e5;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-filter:hover {
        background: #4338ca;
    }

    .btn-reset {
        height: 42px;
        padding: 0 18px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
        color: #374151;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-reset:hover {
        background: #f9fafb;
    }

    .table-card {
        overflow: hidden;
    }

    .table-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eef0f3;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .table-header h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #1f2937;
    }

    .table-header p {
        margin: 4px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 950px;
    }

    thead {
        background: #f8fafc;
    }

    thead th {
        padding: 13px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    tbody td {
        padding: 15px 16px;
        border-bottom: 1px solid #f0f1f3;
        font-size: 14px;
        color: #374151;
        vertical-align: middle;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    tbody tr:hover {
        background: #fafafa;
    }

    .nomor-laporan {
        font-weight: 600;
        color: #4f46e5;
        white-space: nowrap;
    }

    .judul-laporan {
        max-width: 260px;
        font-weight: 600;
        color: #1f2937;
    }

    .judul-laporan .judul-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }

    .pelapor {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .pelapor-nama {
        font-weight: 600;
        color: #374151;
    }

    .pelapor-email {
        font-size: 12px;
        color: #9ca3af;
    }

    .kategori-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 6px;
        background: #f3f4f6;
        color: #4b5563;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .tanggal {
        white-space: nowrap;
        color: #6b7280;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-diproses {
        background: #fff7ed;
        color: #c2410c;
    }

    .status-diverifikasi {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .status-ditugaskan {
        background: #f5f3ff;
        color: #6d28d9;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 34px;
        padding: 0 12px;
        border-radius: 7px;
        background: #eef2ff;
        color: #4f46e5;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        transition: 0.2s;
        white-space: nowrap;
    }

    .btn-detail:hover {
        background: #e0e7ff;
        color: #4338ca;
    }

    .empty-state {
        text-align: center;
        padding: 55px 20px;
    }

    .empty-state-icon {
        width: 55px;
        height: 55px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        font-size: 23px;
    }

    .empty-state h4 {
        margin: 0 0 6px;
        font-size: 16px;
        color: #374151;
    }

    .empty-state p {
        margin: 0;
        color: #9ca3af;
        font-size: 13px;
    }

    .table-footer {
        padding: 15px 20px;
        border-top: 1px solid #eef0f3;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
    }

    .pagination-info {
        font-size: 13px;
        color: #6b7280;
    }

    .pagination-wrapper {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .pagination-wrapper nav {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .pagination-wrapper svg {
        width: 16px;
        height: 16px;
    }

    .pagination-wrapper a,
    .pagination-wrapper span {
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        text-decoration: none;
        box-sizing: border-box;
    }

    .pagination-wrapper a {
        color: #4b5563;
        background: #fff;
        border: 1px solid #e5e7eb;
    }

    .pagination-wrapper a:hover {
        background: #f9fafb;
    }

    .pagination-wrapper span[aria-current="page"] {
        background: #4f46e5;
        color: #fff;
    }

    .pagination-wrapper span[aria-disabled="true"] {
        color: #d1d5db;
        background: #f9fafb;
        border: 1px solid #f3f4f6;
    }

    .per-page {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6b7280;
    }

    .per-page select {
        height: 34px;
        padding: 0 8px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        color: #374151;
        background: #fff;
        outline: none;
    }

    @media (max-width: 768px) {
        .filter-row {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            min-width: 100%;
        }

        .filter-actions {
            width: 100%;
        }

        .btn-filter,
        .btn-reset {
            flex: 1;
        }

        .table-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .table-footer {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>



{{-- ========================= --}}
{{-- FILTER --}}
{{-- ========================= --}}
<div class="filter-card">

    <form method="GET" action="{{ route('admin.biro.laporan') }}">

        <div class="filter-row">

            {{-- SEARCH --}}
            <div class="filter-group">
                <label for="search">Cari Laporan</label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nomor atau judul laporan..."
                >
            </div>

            {{-- KATEGORI --}}
            <div class="filter-group">
                <label for="kategori">Kategori</label>

                <select
                    name="kategori"
                    id="kategori"
                >
                    <option value="">Semua Kategori</option>

                    @foreach ($kategori as $item)
                        <option
                            value="{{ $item->id }}"
                            {{ request('kategori') == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- STATUS --}}
            <div class="filter-group">
                <label for="status">Status</label>

                <select
                    name="status"
                    id="status"
                >
                    <option value="">Semua Status</option>

                    <option
                        value="diproses"
                        {{ request('status') == 'diproses' ? 'selected' : '' }}
                    >
                        Diproses
                    </option>

                    <option
                        value="diverifikasi"
                        {{ request('status') == 'diverifikasi' ? 'selected' : '' }}
                    >
                        Diverifikasi
                    </option>

                    <option
                        value="ditugaskan"
                        {{ request('status') == 'ditugaskan' ? 'selected' : '' }}
                    >
                        Ditugaskan
                    </option>
                </select>
            </div>

            {{-- BUTTON --}}
            <div class="filter-actions">

                <button
                    type="submit"
                    class="btn-filter"
                >
                    Cari
                </button>

                <a
                    href="{{ route('admin.biro.laporan') }}"
                    class="btn-reset"
                >
                    Reset
                </a>

            </div>

        </div>

    </form>

</div>


{{-- ========================= --}}
{{-- TABLE --}}
{{-- ========================= --}}
<div class="table-card">

    <div class="table-header">

        <div>
            <h3>Daftar Laporan</h3>

            <p>
                Menampilkan laporan yang sedang diproses, diverifikasi,
                atau telah ditugaskan.
            </p>
        </div>

    </div>


    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>No. Laporan</th>
                    <th>Judul Laporan</th>
                    <th>Pelapor</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($laporans as $laporan)

                    <tr>

                        {{-- NO LAPORAN --}}
                        <td>
                            <span class="nomor-laporan">
                                {{ $laporan->nomor_laporan }}
                            </span>
                        </td>


                        {{-- JUDUL --}}
                        <td>
                            <div class="judul-laporan">

                                <span
                                    class="judul-text"
                                    title="{{ $laporan->judul_laporan }}"
                                >
                                    {{ $laporan->judul_laporan }}
                                </span>

                            </div>
                        </td>


                        {{-- PELAPOR --}}
                        <td>

                            <div class="pelapor">

                                <span class="pelapor-nama">
                                    {{ $laporan->user->name ?? '-' }}
                                </span>

                                @if (!empty($laporan->user->email))
                                    <span class="pelapor-email">
                                        {{ $laporan->user->email }}
                                    </span>
                                @endif

                            </div>

                        </td>


                        {{-- KATEGORI --}}
                        <td>

                            <span class="kategori-badge">
                                {{ $laporan->kategori->nama ?? 'Lainnya' }}
                            </span>

                        </td>


                        {{-- TANGGAL --}}
                        <td>

                            <span class="tanggal">
                                {{ $laporan->created_at
                                    ? $laporan->created_at->format('d/m/Y')
                                    : '-' }}
                            </span>

                        </td>


                        {{-- STATUS --}}
                        <td>

                            @if ($laporan->status === 'diproses')

                                <span class="status-badge status-diproses">
                                    Diproses
                                </span>

                            @elseif ($laporan->status === 'diverifikasi')

                                <span class="status-badge status-diverifikasi">
                                    Diverifikasi
                                </span>

                            @elseif ($laporan->status === 'ditugaskan')

                                <span class="status-badge status-ditugaskan">
                                    Ditugaskan
                                </span>

                            @else

                                <span class="status-badge">
                                    {{ ucwords(str_replace('_', ' ', $laporan->status ?? '-')) }}
                                </span>

                            @endif

                        </td>


                        {{-- DETAIL --}}
                        <td>

                            <a
                                href="{{ route(
                                    'admin.biro.laporan.detail',
                                    $laporan->id
                                ) }}"
                                class="btn-detail"
                            >
                                Lihat Detail
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7">

                            <div class="empty-state">

                                <div class="empty-state-icon">
                                    —
                                </div>

                                <h4>
                                    Tidak Ada Laporan
                                </h4>

                                <p>
                                    Belum ada laporan yang masuk atau
                                    sesuai dengan filter yang dipilih.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- ========================= --}}
    {{-- FOOTER --}}
    {{-- ========================= --}}
    @if ($laporans->count() > 0)

        <div class="table-footer">

            {{-- INFO --}}
            <div class="pagination-info">

                Menampilkan
                <strong>{{ $laporans->firstItem() }}</strong>
                -
                <strong>{{ $laporans->lastItem() }}</strong>
                dari
                <strong>{{ $laporans->total() }}</strong>
                laporan

            </div>


            {{-- PER PAGE --}}
            <div class="per-page">

                <span>
                    Data per halaman
                </span>

                <form
                    method="GET"
                    action="{{ route('admin.biro.laporan') }}"
                    id="perPageForm"
                >

                    {{-- Pertahankan filter --}}
                    @if (request('search'))
                        <input
                            type="hidden"
                            name="search"
                            value="{{ request('search') }}"
                        >
                    @endif

                    @if (request('kategori'))
                        <input
                            type="hidden"
                            name="kategori"
                            value="{{ request('kategori') }}"
                        >
                    @endif

                    @if (request('status'))
                        <input
                            type="hidden"
                            name="status"
                            value="{{ request('status') }}"
                        >
                    @endif

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

                </form>

            </div>


            {{-- PAGINATION --}}
            <div class="pagination-wrapper">

                {{ $laporans->links() }}

            </div>

        </div>

    @endif

</div>

@endsection