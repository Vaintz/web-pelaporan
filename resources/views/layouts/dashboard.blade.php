<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard')</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #f4f7f6;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #334155;
            display: flex;
            min-height: 100vh;
        }

        /* =========================================
           SIDEBAR
        ========================================= */

        .sidebar {
            position: fixed;
            top: 15px;
            left: 15px;
            bottom: 15px;
            width: 260px;

            background: #212035;
            border-radius: 24px;

            display: flex;
            flex-direction: column;

            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);

            z-index: 1000;
            overflow: hidden;
        }

        /* =========================================
           BRAND
        ========================================= */

        .sidebar-brand {
            padding: 25px 20px 20px;

            display: flex;
            align-items: center;
            gap: 12px;

            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 10px;
        }

        .sidebar-brand img {
            height: 38px;
            width: auto;

            border-radius: 8px;
            background: white;
            padding: 2px;
        }

        .sidebar-brand .brand-text {
            color: #94a3b8;
            font-size: 13px;
            line-height: 1.2;
        }

        .sidebar-brand .brand-text strong {
            display: block;
            color: #ffffff;

            font-size: 18px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        /* =========================================
           USER PROFILE SIDEBAR
        ========================================= */

        .sidebar-user {
            padding: 12px 20px 18px;

            display: flex;
            align-items: center;
            gap: 10px;

            color: #ffffff;
        }

        .sidebar-user-avatar {
            width: 42px;
            height: 42px;

            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;

            background: #ffffff;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-user-info {
            min-width: 0;
        }

        .sidebar-user-name {
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;

            text-transform: uppercase;
        }

        .sidebar-user-role {
            margin-top: 3px;

            color: #94a3b8;
            font-size: 9px;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;

            text-transform: uppercase;
        }

        /* =========================================
           MENU WRAPPER
        ========================================= */

        .sidebar-menu-wrapper {
            flex: 1;

            overflow-y: auto;
            overflow-x: hidden;

            padding-bottom: 20px;
        }

        .sidebar-menu-wrapper::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu-wrapper::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            position: relative;
            width: 100%;
            z-index: 1;
        }

        .sidebar li:not(.dropdown-parent) {
            height: 50px;
        }

        /* =========================================
           LINK MENU
        ========================================= */

        .sidebar li a,
        .sidebar .dropdown-toggle {
            position: relative;
            z-index: 10;

            display: flex;
            align-items: center;

            width: 100%;
            height: 50px;

            padding-left: 35px;
            padding-right: 20px;

            text-decoration: none;

            color: #cbd5e1;

            font-size: 13.5px;
            font-weight: 500;
            letter-spacing: 0.3px;

            cursor: pointer;

            border: none;
            background: transparent;

            transition: all 0.2s ease;
        }

        .sidebar li a svg,
        .sidebar .dropdown-toggle svg.menu-icon {
            width: 20px;
            height: 20px;

            flex-shrink: 0;

            color: #94a3b8;

            transition: 0.2s ease;
        }

        .sidebar li a span,
        .sidebar .dropdown-toggle span {
            margin-left: 16px;
        }

        /* =========================================
           DROPDOWN
        ========================================= */

        .sidebar .dropdown-toggle {
            justify-content: space-between;
        }

        .sidebar .dropdown-toggle > div {
            display: flex;
            align-items: center;
        }

        .sidebar .dropdown-toggle .arrow-icon {
            width: 16px;
            height: 16px;

            transition: transform 0.3s ease;
        }

        .sidebar .dropdown-parent.open .arrow-icon {
            transform: rotate(180deg);
        }

        .sidebar .submenu {
            max-height: 0;

            overflow: hidden;

            transition: max-height 0.3s ease-in-out;

            background: rgba(15, 14, 26, 0.3);
        }

        .sidebar .dropdown-parent.open .submenu {
            max-height: 400px;

            padding: 6px 0;
            margin-bottom: 8px;
        }

        .sidebar .submenu li {
            height: 42px !important;
        }

        .sidebar .submenu li a {
            height: 42px !important;

            padding-left: 50px !important;

            font-size: 12.5px !important;

            border-left: 3px solid transparent;
        }

        .sidebar .submenu li a svg {
            width: 16px !important;
            height: 16px !important;
        }

        .sidebar .submenu li a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.03);
        }

        .sidebar .submenu li a:hover svg {
            color: #ffffff;
        }

        .sidebar .submenu li.active-sub a {
            color: #ffffff !important;
            font-weight: 600;

            background: rgba(255, 255, 255, 0.05);

            border-left: 3px solid #6366f1;
        }

        .sidebar .submenu li.active-sub a svg {
            color: #818cf8 !important;
        }

        /* =========================================
           HOVER
        ========================================= */

        .sidebar li:not(.active) a:hover,
        .sidebar .dropdown-toggle:hover {
            color: #ffffff;
        }

        .sidebar li:not(.active) a:hover svg,
        .sidebar .dropdown-toggle:hover svg.menu-icon {
            color: #ffffff;
        }

        /* =========================================
           ACTIVE MENU
        ========================================= */

        .sidebar li.active {
            margin-left: 15px;

            width: calc(100% - 15px);

            background: #f4f7f6;

            border-radius: 25px 0 0 25px;

            height: 50px;
        }

        .sidebar li.active a {
            color: #212035;
            font-weight: 700;
        }

        .sidebar li.active a svg {
            color: #6366f1;
        }

        .sidebar li.active::before {
            content: "";

            position: absolute;

            right: 0;
            top: -20px;

            width: 20px;
            height: 20px;

            background: transparent;

            border-bottom-right-radius: 20px;

            box-shadow: 5px 5px 0 5px #f4f7f6;

            pointer-events: none;
        }

        .sidebar li.active::after {
            content: "";

            position: absolute;

            right: 0;
            bottom: -20px;

            width: 20px;
            height: 20px;

            background: transparent;

            border-top-right-radius: 20px;

            box-shadow: 5px -5px 0 5px #f4f7f6;

            pointer-events: none;
        }

        /* =========================================
           MAIN WRAPPER
        ========================================= */

        .main-wrapper {
            flex: 1;

            margin-left: 275px;

            padding: 15px 25px 25px 15px;

            display: flex;
            flex-direction: column;

            min-width: 0;
        }

        /* =========================================
           TOPBAR
        ========================================= */

        .topbar {
            background: #ffffff;

            border-radius: 20px;

            min-height: 70px;

            padding: 0 25px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);

            margin-bottom: 25px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
        }

        .topbar-left .page-title {
            margin: 0;

            font-size: 18px;
            font-weight: 700;

            color: #1e293b;

            letter-spacing: 0.3px;
        }

        .topbar-left .date-text {
            display: block;

            font-size: 12px;
            color: #64748b;

            margin-top: 2px;

            font-weight: 500;
        }

        .topbar-right {
            display: flex;
            align-items: center;

            gap: 15px;

            position: relative;
        }

        .topbar-profile {
            display: flex;
            align-items: center;

            gap: 12px;

            text-align: right;
        }

        .topbar-profile .text-info .name {
            display: block;

            font-size: 13.5px;
            font-weight: 700;

            color: #1e293b;
        }

        .topbar-profile .text-info .role {
            display: block;

            font-size: 11px;

            color: #64748b;

            text-transform: uppercase;

            letter-spacing: 0.5px;
        }

        .topbar-avatar {
            width: 44px;
            height: 44px;

            border-radius: 50%;

            border: 2px solid #e2e8f0;

            overflow: hidden;

            background: #f8fafc;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* =========================================
           PROFILE DROPDOWN
        ========================================= */

        .profile-dropdown-btn {
            background: #f8fafc;

            border: 1px solid #e2e8f0;

            color: #64748b;

            cursor: pointer;

            width: 32px;
            height: 32px;

            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            transition: 0.2s ease;
        }

        .profile-dropdown-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .profile-menu {
            position: absolute;

            top: 55px;
            right: 0;

            background: #ffffff;

            border-radius: 14px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

            width: 180px;

            padding: 8px;

            display: none;

            z-index: 2000;

            border: 1px solid #f1f5f9;
        }

        .profile-menu.show {
            display: block;

            animation: fadeIn 0.2s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-menu a {
            width: 100%;

            padding: 10px 14px;

            text-decoration: none;

            color: #334155;

            border-radius: 8px;

            font-size: 13px;
            font-weight: 600;

            display: flex;
            align-items: center;

            gap: 10px;

            transition: 0.2s ease;

            margin-bottom: 4px;
        }

        .profile-menu a:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .profile-menu-divider {
            height: 1px;

            background: #e2e8f0;

            margin: 6px 0;
        }

        .profile-menu button {
            width: 100%;

            padding: 10px 14px;

            border: none;

            background: #fee2e2;

            color: #b91c1c;

            border-radius: 8px;

            font-size: 13px;
            font-weight: 700;

            cursor: pointer;

            text-align: left;

            display: flex;
            align-items: center;

            gap: 10px;

            transition: 0.2s ease;
        }

        .profile-menu button:hover {
            background: #fca5a5;
            color: #7f1d1d;
        }

        /* =========================================
           CONTENT
        ========================================= */

        .content {
            flex: 1;

            border-radius: 20px;

            min-width: 0;
        }

        /* =========================================
           RESPONSIVE
        ========================================= */

        .mobile-menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
            color: #212035;
            cursor: pointer;
        }

        .mobile-menu-toggle svg {
            width: 22px;
            height: 22px;
        }

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 768px) {
            body {
                display: block;
                width: 100%;
                overflow-x: hidden;
            }

            .sidebar {
                width: min(290px, 86vw);
                top: 0;
                left: 0;
                bottom: 0;
                height: 100dvh;
                border-radius: 0 18px 18px 0;
                transform: translateX(-105%);
                visibility: hidden;
                transition: transform 0.25s ease, visibility 0.25s ease;
                z-index: 1100;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
                visibility: visible;
            }

            .sidebar-brand .brand-text,
            .sidebar-user-info {
                display: block;
            }

            .main-wrapper {
                display: block;
                width: 100%;
                min-width: 0;
                margin: 0;
                padding: 10px;
            }

            .topbar {
                width: 100%;
                min-height: 62px;
                padding: 10px;
                gap: 10px;
                border-radius: 14px;
                margin-bottom: 14px;
                display: flex;
                align-items: center;
                justify-content: flex-start;
            }

            .mobile-menu-toggle {
                display: inline-flex;
            }

            .topbar-left {
                flex: 1 1 auto;
                min-width: 0;
            }

            .topbar-left > div {
                min-width: 0;
            }

            .topbar-left .page-title {
                font-size: 15px;
                line-height: 1.25;
                overflow-wrap: anywhere;
            }

            .topbar-left .date-text {
                font-size: 10px;
                line-height: 1.3;
            }

            .topbar-right {
                gap: 6px;
                flex: 0 0 auto;
            }

            .topbar-profile {
                gap: 0;
            }

            .topbar-profile .text-info {
                display: none;
            }

            .topbar-avatar {
                width: 34px;
                height: 34px;
            }

            .profile-dropdown-btn {
                width: 30px;
                height: 30px;
                flex: 0 0 30px;
            }

            .profile-menu {
                top: calc(100% + 8px);
                right: 0;
                max-width: calc(100vw - 24px);
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.48);
                z-index: 1090;
            }

            .content {
                width: 100%;
                min-width: 0;
                overflow-wrap: anywhere;
            }

            body.mobile-menu-open {
                overflow: hidden;
            }
        }

        @media (max-width: 380px) {
            .main-wrapper {
                padding: 8px;
            }

            .topbar {
                padding: 8px;
                gap: 7px;
            }

            .mobile-menu-toggle {
                width: 36px;
                height: 36px;
                flex-basis: 36px;
            }

            .topbar-left .page-title {
                font-size: 13px;
            }

            .topbar-left .date-text {
                font-size: 9px;
            }

            .topbar-avatar {
                width: 30px;
                height: 30px;
            }

            .profile-dropdown-btn {
                width: 26px;
                height: 26px;
                flex-basis: 26px;
            }
        }

    </style>
</head>

<body>

    <!-- =========================================
         SIDEBAR
    ========================================= -->

    <aside class="sidebar">

        <!-- BRAND -->
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo-navbar.png') }}" alt="Logo Unimal">

            <div class="brand-text">
                <strong>SIFASTEK</strong>
                Universitas Malikussaleh
            </div>
        </div>

        

        <!-- MENU -->
        <div class="sidebar-menu-wrapper">

            <ul>

                {{-- =================================
                     PELAPOR
                ================================== --}}

                @if(auth()->user()->role === 'pelapor')

                    <!-- DASHBOARD -->
                    <li class="{{ request()->routeIs('pelapor.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('pelapor.dashboard') }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- AJUKAN LAPORAN -->
                    <li class="{{ request()->routeIs('pelapor.ajukan') ? 'active' : '' }}">
                        <a href="{{ route('pelapor.ajukan') }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 14H7v-2h10v2zm0-4H7v-2h10v2zm0-4H7V7h10v2z" />
                            </svg>
                            <span>Ajukan Laporan</span>
                        </a>
                    </li>

                    <!-- RIWAYAT LAPORAN -->
                    <li class="{{ request()->routeIs('pelapor.riwayat', 'pelapor.laporan.detail') ? 'active' : '' }}">
                        <a href="{{ route('pelapor.riwayat') }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13 3a9 9 0 1 0 8.94 10h-2.02A7 7 0 1 1 13 5V3zm1 0v9h9a9 9 0 0 0-9-9z" />
                            </svg>
                            <span>Riwayat Laporan</span>
                        </a>
                    </li>

                    


                {{-- =================================
                     ADMIN FAKULTAS
                ================================== --}}

                @elseif(auth()->user()->role === 'admin_fakultas')

                    <!-- DASHBOARD -->
                    <li class="{{ request()->routeIs('admin.fakultas.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.fakultas.dashboard') }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- LAPORAN MASUK -->
                    <li class="{{ request()->routeIs('admin.fakultas.laporan', 'admin.fakultas.laporan.detail') ? 'active' : '' }}">
                        <a href="{{ route('admin.fakultas.laporan') }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 14H7v-2h10v2zm0-4H7v-2h10v2zm0-4H7V7h10v2z" />
                            </svg>
                            <span>Laporan Masuk</span>
                        </a>
                    </li>

                    <!-- RIWAYAT LAPORAN -->
                    <li class="{{ request()->routeIs('admin.fakultas.riwayat', 'admin.fakultas.riwayat.detail') ? 'active' : '' }}">
                        <a href="{{ route('admin.fakultas.riwayat') }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13 3a9 9 0 1 0 8.94 10h-2.02A7 7 0 1 1 13 5V3zm1 0v9h9a9 9 0 0 0-9-9z" />
                            </svg>
                            <span>Riwayat Laporan</span>
                        </a>
                    </li>

                    <!-- BERITA ACARA -->
                    <li class="{{ request()->routeIs('admin.fakultas.berita', 'admin.fakultas.berita.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.fakultas.berita') }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14 2H6c-1.1 0-2 0-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm1 7V3.5L18.5 9H15z" />
                            </svg>
                            <span>Berita Acara</span>
                        </a>
                    </li>

                    


                {{-- =================================
                     ADMIN BIRO
                ================================== --}}

                @elseif(auth()->user()->role === 'admin_biro')

                    <!-- DASHBOARD -->
                    <li class="{{ request()->routeIs('admin.biro.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.biro.dashboard') }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- LAPORAN MASUK -->
                    <li class="{{ request()->routeIs('admin.biro.laporan', 'admin.biro.laporan.detail') ? 'active' : '' }}">
                        <a href="{{ route('admin.biro.laporan') }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 14H7v-2h10v2zm0-4H7v-2h10v2zm0-4H7V7h10v2z" />
                            </svg>
                            <span>Laporan Masuk</span>
                        </a>
                    </li>

                    <!-- RIWAYAT LAPORAN -->
                    <li class="{{ request()->routeIs('admin.biro.riwayat', 'admin.biro.riwayat.detail') ? 'active' : '' }}">
                        <a href="{{ route('admin.biro.riwayat') }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13 3a9 9 0 1 0 8.94 10h-2.02A7 7 0 1 1 13 5V3zm1 0v9h9a9 9 0 0 0-9-9z" />
                            </svg>
                            <span>Riwayat Laporan</span>
                        </a>
                    </li>

                    <!-- BERITA ACARA -->
                    <li class="{{ request()->routeIs('admin.biro.berita', 'admin.biro.berita.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.biro.berita') }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14 2H6c-1.1 0-2 0-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm1 7V3.5L18.5 9H15z" />
                            </svg>
                            <span>Berita Acara</span>
                        </a>
                    </li>

                    <!-- DATA MASTER -->
                    @php
                        $isDataMasterActive =
                            request()->routeIs('admin.biro.pengguna.*') ||
                            request()->routeIs('admin.biro.prodi.*') ||
                            request()->routeIs('admin.biro.gedung.*') ||
                            request()->routeIs('admin.biro.ruangan.*') ||
                            request()->routeIs('admin.biro.kategori-kerusakan.*') ||
                            request()->routeIs('admin.biro.teknisi.*');
                    @endphp

                    <li class="dropdown-parent {{ $isDataMasterActive ? 'open' : '' }}">

                        <button type="button" class="dropdown-toggle" onclick="toggleDropdown(this)">

                            <div>
                                <svg class="menu-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 3C7.58 3 4 4.34 4 6v12c0 1.66 3.58 3 8 3s8-1.34 8-3V6c0-1.66-3.58-3-8-3zm0 2c3.87 0 6 1.12 6 1s-2.13 1-6 1-6-.12-6-1 2.13-1 6-1zm0 5c3.87 0 6 1.12 6 1s-2.13 1-6 1-6-.12-6-1 2.13-1 6-1zm0 5c3.87 0 6 1.12 6 1s-2.13 1-6 1-6-.12-6-1 2.13-1 6-1z" />
                                </svg>

                                <span>Data Master</span>
                            </div>

                            <svg class="arrow-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z" />
                            </svg>

                        </button>

                        <ul class="submenu">

                            <!-- PENGGUNA -->
                            <li class="{{ request()->routeIs('admin.biro.pengguna.*') ? 'active-sub' : '' }}">
                                <a href="{{ route('admin.biro.pengguna.index') }}">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                    </svg>
                                    <span>Pengguna</span>
                                </a>
                            </li>

                            <!-- PROGRAM STUDI -->
                            <li class="{{ request()->routeIs('admin.biro.prodi.*') ? 'active-sub' : '' }}">
                                <a href="{{ route('admin.biro.prodi.index') }}">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z" />
                                    </svg>
                                    <span>Program Studi</span>
                                </a>
                            </li>

                            <!-- GEDUNG -->
                            <li class="{{ request()->routeIs('admin.biro.gedung.*') ? 'active-sub' : '' }}">
                                <a href="{{ route('admin.biro.gedung.index') }}">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M15 3H9c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-3 2h2v2h-2V5zm0 4h2v2h-2V9zm0 4h2v2h-2v-2zm-2-8h2v2h-2V5zm0 4h2v2h-2V9zm0 4h2v2h-2v-2zM3 9v10c0 1.1.9 2 2 2h1v-2H5V9h1V7H5c-1.1 0-2 .9-2 2zm16-2h-1v2h1v10h-1v2h1c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2z" />
                                    </svg>
                                    <span>Gedung</span>
                                </a>
                            </li>

                            <!-- KATEGORI KERUSAKAN -->
                            <li class="{{ request()->routeIs('admin.biro.kategori-kerusakan.*') ? 'active-sub' : '' }}">
                                <a href="{{ route('admin.biro.kategori-kerusakan.index') }}">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.6C.4 7 1 10 3 12c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.4-.4 1.1-.9.1.5 0z" />
                                    </svg>
                                    <span>Kategori Kerusakan</span>
                                </a>
                            </li>

                            <!-- TEKNISI -->
                            <li class="{{ request()->routeIs('admin.biro.teknisi.*') ? 'active-sub' : '' }}">
                                <a href="{{ route('admin.biro.teknisi.index') }}">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                    <span>Teknisi</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    

                @endif

            </ul>

        </div>

    </aside>


    <!-- =========================================
         MAIN WRAPPER
    ========================================= -->

    <div class="main-wrapper">

        <div class="sidebar-overlay" onclick="closeMobileSidebar()"></div>

        <!-- TOPBAR -->
        <header class="topbar">

            <button
                type="button"
                class="mobile-menu-toggle"
                onclick="toggleMobileSidebar()"
                aria-label="Buka menu"
                aria-expanded="false"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 6h18M3 12h18M3 18h18"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round" />
                </svg>
            </button>

            <!-- KIRI -->
            <div class="topbar-left">
                <div>

                    <h2 class="page-title">
                        @yield('title', 'Dashboard')
                    </h2>

                    <span class="date-text">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>

                </div>
            </div>


            <!-- KANAN -->
            <div class="topbar-right">

                <!-- PROFILE -->
                <div class="topbar-profile">

                    <div class="text-info">

                        <span class="name">
                            {{ auth()->user()->name }}
                        </span>

                        <span class="role">
                            {{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}
                        </span>

                    </div>

                    <div class="topbar-avatar">

                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Foto Profil">
                        @else
                            <img src="{{ asset('images/avatar-default.jfif') }}" alt="Avatar Default">
                        @endif

                    </div>

                </div>


                <!-- DROPDOWN BUTTON -->
                <button
                    class="profile-dropdown-btn"
                    type="button"
                    onclick="toggleProfileMenu(event)"
                >

                    <svg
                        viewBox="0 0 24 24"
                        width="18"
                        height="18"
                        fill="currentColor"
                    >
                        <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z" />
                    </svg>

                </button>


                <!-- PROFILE MENU -->
                <div class="profile-menu" id="profileMenu">

                    @php
                        $profilRoute = '#';

                        if (auth()->user()->role === 'pelapor') {
                            $profilRoute = route('pelapor.profil');
                        } elseif (auth()->user()->role === 'admin_fakultas') {
                            $profilRoute = route('admin.fakultas.profil');
                        } elseif (auth()->user()->role === 'admin_biro') {
                            $profilRoute = route('admin.biro.profil');
                        }
                    @endphp

                    <!-- PROFIL -->
                    <a href="{{ $profilRoute }}">

                        <svg
                            viewBox="0 0 24 24"
                            width="16"
                            height="16"
                            fill="currentColor"
                        >
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>

                        Profil Saya

                    </a>


                    <div class="profile-menu-divider"></div>


                    <!-- LOGOUT -->
                    <form action="{{ route('logout') }}" method="POST">

                        @csrf

                        <button type="submit">

                            <svg
                                viewBox="0 0 24 24"
                                width="16"
                                height="16"
                                fill="currentColor"
                            >
                                <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
                            </svg>

                            Log Out

                        </button>

                    </form>

                </div>

            </div>

        </header>


        <!-- CONTENT -->
        <main class="content">

            @yield('content')

        </main>

    </div>


    <!-- =========================================
         SCRIPTS
    ========================================= -->

    <script>

        function toggleMobileSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const button = document.querySelector('.mobile-menu-toggle');

            const isOpen = sidebar.classList.toggle('mobile-open');

            overlay.classList.toggle('show', isOpen);
            document.body.classList.toggle('mobile-menu-open', isOpen);

            button.setAttribute('aria-expanded', String(isOpen));
            button.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
        }

        function closeMobileSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const button = document.querySelector('.mobile-menu-toggle');

            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('show');
            document.body.classList.remove('mobile-menu-open');

            button.setAttribute('aria-expanded', 'false');
            button.setAttribute('aria-label', 'Buka menu');
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMobileSidebar();
            }
        });

        document.querySelectorAll('.sidebar a').forEach(function(link) {
            link.addEventListener('click', closeMobileSidebar);
        });

        // ============================
        // DROPDOWN DATA MASTER
        // ============================

        function toggleDropdown(button) {

            const parent = button.parentElement;

            parent.classList.toggle('open');

        }


        // ============================
        // DROPDOWN PROFILE
        // ============================

        function toggleProfileMenu(event) {

            event.stopPropagation();

            const menu = document.getElementById('profileMenu');

            menu.classList.toggle('show');

        }


        // ============================
        // CLICK OUTSIDE PROFILE
        // ============================

        window.addEventListener('click', function(event) {

            const menu = document.getElementById('profileMenu');

            const button = document.querySelector('.profile-dropdown-btn');

            if (
                menu &&
                menu.classList.contains('show') &&
                !menu.contains(event.target) &&
                !button.contains(event.target)
            ) {

                menu.classList.remove('show');

            }

        });

    </script>

</body>

</html>
