@extends('layouts.dashboard')

@section('title', 'Dashboard Pelapor')

@section('content')

<style>
    /* =========================================
       DASHBOARD
    ========================================= */

    .dashboard-container {
        width: 100%;
        min-height: calc(100vh - 70px);
        padding: 0;
        margin: 0;
        background: transparent;
        font-family: Arial, sans-serif;
    }


    /* =========================================
       STATISTIC CARDS
    ========================================= */

    .stats-grid {
        width: 100%;

        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));

        gap: 20px;

        margin-bottom: 25px;
    }

    .stat-card {
        height: 128px;

        background: #ffffff;

        border: 1px solid #dfe4ec;
        border-radius: 20px;

        padding: 18px 16px;

        display: flex;
        align-items: center;

        box-shadow:
            0 2px 3px rgba(0, 0, 0, 0.17);
    }


    /* =========================================
       STAT ICON
    ========================================= */

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


    /* =========================================
       STAT CONTENT
    ========================================= */

    .stat-content {
        flex: 1;

        text-align: center;

        padding-right: 8px;
    }

    .stat-title {
        font-size: 14px;

        font-weight: 700;

        color: #202235;

        margin-bottom: 8px;
    }

    .stat-number {
        font-size: 25px;

        line-height: 1;

        font-weight: 700;

        color: #171929;

        margin-bottom: 9px;
    }

    .stat-description {
        font-size: 11px;

        color: #202235;
    }


    /* =========================================
       MAIN GRID
    ========================================= */

    .dashboard-grid {
        width: 100%;

        display: grid;

        grid-template-columns:
            minmax(0, 2.8fr)
            minmax(220px, 0.8fr);

        gap: 28px;

        align-items: start;
    }


    /* =========================================
       CHART CARD
    ========================================= */

    .chart-card {
        height: 405px;

        background: #ffffff;

        border: 1px solid #dfe4ec;

        border-radius: 20px;

        padding: 20px 20px 16px;

        box-shadow:
            0 2px 3px rgba(0, 0, 0, 0.17);
    }

    .chart-header {
        display: flex;

        justify-content: space-between;

        align-items: flex-start;
    }

    .chart-title {
        margin: 0 0 12px;

        font-size: 15px;

        font-weight: 700;

        color: #202235;
    }

    .chart-subtitle {
        margin: 0;

        font-size: 10px;

        color: #9299aa;
    }

    .chart-wrapper {
        width: 100%;

        height: 280px;

        margin-top: 30px;

        position: relative;
    }


    /* =========================================
       RIGHT COLUMN
    ========================================= */

    .right-column {
        display: flex;

        flex-direction: column;

        gap: 20px;
    }

    .info-card {
        width: 100%;

        background: #ffffff;

        border: 1px solid #dfe4ec;

        border-radius: 18px;

        padding: 14px 14px 15px;

        box-shadow:
            0 2px 3px rgba(0, 0, 0, 0.17);
    }


    /* =========================================
       INFO HEADER
    ========================================= */

    .info-header {
        display: flex;

        align-items: center;

        gap: 10px;

        padding-bottom: 10px;

        margin-bottom: 11px;

        border-bottom: 1px solid #d5dbe5;
    }

    .info-icon {
        width: 30px;
        height: 30px;

        min-width: 30px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 50%;

        background: #6198f8;

        color: #ffffff;

        font-size: 19px;

        font-weight: 700;
    }

    .info-title {
        font-size: 12px;

        font-weight: 700;

        color: #075bd6;
    }


    /* =========================================
       PANDUAN LAPORAN
    ========================================= */

    .guide-step {
        display: flex;

        gap: 9px;

        position: relative;

        padding-bottom: 10px;
    }

    .guide-step:last-child {
        padding-bottom: 0;
    }

    .step-number {
        width: 15px;
        height: 15px;

        min-width: 15px;

        background: #5791f8;

        color: #ffffff;

        border-radius: 50%;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 8px;

        font-weight: 700;

        position: relative;

        z-index: 2;
    }

    .guide-step:not(:last-child)
    .step-number::after {

        content: "";

        position: absolute;

        width: 1px;

        height: 23px;

        top: 15px;

        left: 7px;

        background: #a9c6fa;
    }

    .step-content {
        flex: 1;
    }

    .step-title {
        font-size: 10px;

        font-weight: 700;

        color: #242738;

        margin-bottom: 2px;
    }

    .step-description {
        font-size: 8.5px;

        line-height: 1.3;

        color: #8a91a2;
    }


    /* =========================================
       BANTUAN
    ========================================= */

    .help-text {
        margin: 0 0 12px;

        font-size: 10px;

        line-height: 1.4;

        color: #25283a;
    }

    .admin-contact {
        height: 61px;

        border: 1px solid #c7cedb;

        border-radius: 9px;

        padding: 8px;

        display: flex;

        align-items: center;

        gap: 10px;

        margin-bottom: 9px;
    }

    .admin-avatar {
        width: 38px;
        height: 38px;

        min-width: 38px;

        background: #dce8ff;

        border-radius: 50%;
    }

    .admin-name {
        font-size: 10px;

        font-weight: 700;

        color: #282b3b;

        margin-bottom: 3px;
    }

    .admin-email {
        font-size: 9px;

        color: #8a91a2;
    }

    .email-button {
        width: 100%;

        height: 27px;

        border: 1px solid #1468ff;

        border-radius: 7px;

        background: #e8f0ff;

        color: #075bd6;

        font-size: 10px;

        font-weight: 600;

        cursor: pointer;

        transition: 0.2s;
    }

    .email-button:hover {
        background: #dce8ff;
    }


    /* =========================================
       RESPONSIVE
    ========================================= */

    @media (max-width: 1100px) {

        .stats-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .right-column {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            min-height: 0;
        }

        .stats-grid,
        .dashboard-grid,
        .right-column {
            min-width: 0;
        }

        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 14px;
        }

        .stat-card {
            min-width: 0;
            height: auto;
            min-height: 130px;
            padding: 14px 10px;
            border-radius: 15px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-align: center;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            min-width: 42px;
        }

        .stat-icon svg {
            width: 22px;
            height: 22px;
        }

        .stat-content {
            width: 100%;
            min-width: 0;
            flex: initial;
            padding: 0;
            text-align: center;
        }

        .stat-title {
            font-size: 12px;
            line-height: 1.25;
            margin-bottom: 5px;
            overflow-wrap: anywhere;
        }

        .stat-number {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .stat-description {
            font-size: 10px;
            line-height: 1.3;
        }

        .dashboard-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 14px;
        }

        .chart-card {
            width: 100%;
            min-width: 0;
            height: auto;
            padding: 16px 12px 12px;
            border-radius: 15px;
        }

        .chart-header {
            min-width: 0;
        }

        .chart-title {
            font-size: 14px;
            line-height: 1.35;
        }

        .chart-subtitle {
            font-size: 11px;
            line-height: 1.4;
        }

        .chart-wrapper {
            width: 100%;
            height: 230px;
            margin-top: 18px;
        }

        .right-column {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 14px;
        }

        .info-card {
            min-width: 0;
            padding: 16px;
            border-radius: 15px;
        }

        .info-title {
            font-size: 13px;
        }

        .step-title {
            font-size: 12px;
        }

        .step-description {
            font-size: 11px;
            line-height: 1.45;
        }

        .guide-step {
            gap: 10px;
            padding-bottom: 13px;
        }

        .guide-step:not(:last-child) .step-number::after {
            height: 27px;
        }

        .help-text {
            font-size: 12px;
        }

        .admin-contact {
            min-height: 58px;
            height: auto;
            gap: 9px;
        }

        .admin-name {
            font-size: 11px;
            overflow-wrap: anywhere;
        }

        .admin-email {
            font-size: 10px;
        }

        .email-button {
            height: 38px;
            font-size: 12px;
        }
    }

    @media (max-width: 380px) {
        .stats-grid {
            gap: 8px;
        }

        .stat-card {
            min-height: 120px;
            padding: 12px 7px;
        }

        .stat-title {
            font-size: 11px;
        }

        .stat-number {
            font-size: 20px;
        }

        .chart-wrapper {
            height: 205px;
        }

        .info-card {
            padding: 13px;
        }
    }
</style>


<div class="dashboard-container">


    {{-- =====================================
         STATISTIK
    ====================================== --}}

    <div class="stats-grid">


        {{-- TOTAL LAPORAN --}}
        <div class="stat-card">

            <div class="stat-icon icon-blue">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor">

                    <rect
                        x="5"
                        y="3"
                        width="14"
                        height="18"
                        rx="1">
                    </rect>

                    <path d="M9 7h6"></path>

                    <path d="M9 11h6"></path>

                    <path d="M9 15h2"></path>

                    <path d="M14 15h1"></path>

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
                    stroke="currentColor">

                    <circle
                        cx="12"
                        cy="12"
                        r="9">
                    </circle>

                    <path d="M12 7v5l3 2"></path>

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
                    stroke="currentColor">

                    <circle
                        cx="12"
                        cy="12"
                        r="9">
                    </circle>

                    <path d="M8 12l3 3 5-6"></path>

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
                    stroke="currentColor">

                    <circle
                        cx="12"
                        cy="12"
                        r="9">
                    </circle>

                    <path d="M9 9l6 6"></path>

                    <path d="M15 9l-6 6"></path>

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


    {{-- =====================================
         CONTENT UTAMA
    ====================================== --}}

    <div class="dashboard-grid">


        {{-- =================================
             GRAFIK
        ================================== --}}

        <div class="chart-card">

            <div class="chart-header">

                <div>

                    <h3 class="chart-title">
                        Tren Laporan Saya
                    </h3>

                    <p class="chart-subtitle">
                        Jumlah laporan yang Anda ajukan
                        dalam 6 bulan terakhir
                    </p>

                </div>

            </div>


            <div class="chart-wrapper">

                <canvas id="reportChart"></canvas>

            </div>

        </div>


        {{-- =================================
             KOLOM KANAN
        ================================== --}}

        <div class="right-column">


            {{-- =================================
                 PANDUAN LAPORAN
            ================================== --}}

            <div class="info-card">

                <div class="info-header">

                    <div class="info-icon">
                        ?
                    </div>

                    <div class="info-title">
                        Panduan Laporan
                    </div>

                </div>


                {{-- STEP 1 --}}
                <div class="guide-step">

                    <div class="step-number">
                        1
                    </div>

                    <div class="step-content">

                        <div class="step-title">
                            Ajukan laporan
                        </div>

                        <div class="step-description">
                            Sampaikan kendala atau masalah
                            secara lengkap dan jelas.
                        </div>

                    </div>

                </div>


                {{-- STEP 2 --}}
                <div class="guide-step">

                    <div class="step-number">
                        2
                    </div>

                    <div class="step-content">

                        <div class="step-title">
                            Tunggu verifikasi
                        </div>

                        <div class="step-description">
                            Admin akan memeriksa dan
                            memverifikasi laporan Anda.
                        </div>

                    </div>

                </div>


                {{-- STEP 3 --}}
                <div class="guide-step">

                    <div class="step-number">
                        3
                    </div>

                    <div class="step-content">

                        <div class="step-title">
                            Proses penanganan
                        </div>

                        <div class="step-description">
                            Laporan diteruskan ke pihak terkait
                            untuk ditangani.
                        </div>

                    </div>

                </div>


                {{-- STEP 4 --}}
                <div class="guide-step">

                    <div class="step-number">
                        4
                    </div>

                    <div class="step-content">

                        <div class="step-title">
                            Laporan selesai
                        </div>

                        <div class="step-description">
                            Periksa hasil penanganan
                            laporan Anda.
                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================
                 BUTUH BANTUAN
            ================================== --}}

            <div class="info-card">

                <div class="info-header">

                    <div class="info-icon">
                        ?
                    </div>

                    <div class="info-title">
                        BUTUH BANTUAN?
                    </div>

                </div>


                <p class="help-text">

                    Ada kendala atau pertanyaan
                    terkait pelaporan?

                    <br>

                    Hubungi Admin untuk mendapatkan
                    bantuan.

                </p>


                <div class="admin-contact">

                    <div class="admin-avatar"></div>

                    <div>

                        <div class="admin-name">
                            admin@unimal.ac.id
                        </div>

                        <div class="admin-email">
                            Email Admin
                        </div>

                    </div>

                </div>


                <button
                    type="button"
                    class="email-button"
                    onclick="window.location.href='mailto:admin@unimal.ac.id'">

                    Kirim Email

                </button>

            </div>

        </div>

    </div>

</div>


{{-- =====================================
     CHART JS
====================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const ctx = document.getElementById('reportChart');


    /*
    |--------------------------------------------------------------------------
    | DATA DARI DATABASE
    |--------------------------------------------------------------------------
    |
    | $bulan dan $jumlahLaporan dikirim dari
    | LaporanController@dashboard()
    |
    */

    const bulan = @json($bulan);

    const jumlahLaporan = @json($jumlahLaporan);


    /*
    |--------------------------------------------------------------------------
    | CHART
    |--------------------------------------------------------------------------
    */

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: bulan,

            datasets: [

                {
                    label: 'Jumlah Laporan',

                    data: jumlahLaporan,

                    borderWidth: 2,

                    borderColor: '#0878ff',

                    backgroundColor:
                        'rgba(8, 120, 255, 0.12)',

                    pointBackgroundColor:
                        '#0878ff',

                    pointBorderColor:
                        '#ffffff',

                    pointBorderWidth: 2,

                    pointRadius: 4,

                    pointHoverRadius: 6,

                    fill: true,

                    tension: 0.35
                }

            ]

        },


        options: {

            responsive: true,

            maintainAspectRatio: false,


            plugins: {

                legend: {
                    display: false
                },


                tooltip: {

                    displayColors: false,

                    callbacks: {

                        label: function(context) {

                            return context.parsed.y +
                                ' laporan';

                        }

                    }

                }

            },


            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0,

                        font: {
                            size: 10
                        },

                        color: '#65708a'

                    },

                    grid: {

                        color: '#e5ebf3',

                        borderDash: [
                            3,
                            3
                        ]

                    }

                },


                x: {

                    ticks: {

                        font: {
                            size: 10
                        },

                        color: '#65708a'

                    },

                    grid: {

                        color: '#e5ebf3',

                        borderDash: [
                            3,
                            3
                        ]

                    }

                }

            }

        }

    });

</script>

@endsection