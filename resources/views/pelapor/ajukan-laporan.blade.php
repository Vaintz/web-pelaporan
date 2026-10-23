@extends('layouts.dashboard')

@section('title', 'Ajukan Laporan')

@section('content')

    <style>
        /* =========================================================
                                           PAGE TITLE
                                        ========================================================= */

        .page-title {
            margin-bottom: 20px;
        }

        .page-title h1 {
            margin: 0 0 5px;

            color: #16234a;

            font-size: 24px;
            line-height: 1.2;

            font-weight: 700;
        }

        .page-title p {
            margin: 0;

            color: #6f7890;

            font-size: 12px;
        }


        /* =========================================================
                                           FORM SECTION
                                        ========================================================= */

        .form-section {
            width: 100%;
            box-sizing: border-box;

            background: #ffffff;

            border: 1px solid #dfe2e8;
            border-radius: 20px;

            /* sebelumnya 51px */
            padding: 14px 35px 34px;

            margin-bottom: 20px;

            box-shadow:
                0 3px 4px rgba(0, 0, 0, 0.17);
        }


        /* =========================================================
                                           SECTION TITLE
                                        ========================================================= */

        .section-title {
            margin: 0 0 17px 0;

            display: flex;
            align-items: center;
            gap: 10px;

            color: #202235;

            font-size: 15px;
            line-height: 1.2;

            font-weight: 700;
        }

        .section-icon {
            width: 22px;
            height: 22px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #25253a;
        }

        .section-icon svg {
            width: 20px;
            height: 20px;

            stroke: currentColor;
            stroke-width: 2;
            fill: none;

            stroke-linecap: round;
            stroke-linejoin: round;
        }


        /* =========================================================
                                           INFORMASI PELAPOR
                                        ========================================================= */

        .pelapor-box {
            width: 100%;

            min-height: 124px;

            box-sizing: border-box;

            border: 2px solid #25253a;

            border-radius: 9px;

            padding: 20px 60px;

            display: flex;
            align-items: center;
        }


        .pelapor-grid {
            width: 100%;

            display: grid;

            grid-template-columns: 1fr 1fr;

            column-gap: 55px;

            row-gap: 10px;
        }


        .info-row {
            display: grid;

            grid-template-columns: 126px 12px 1fr;

            align-items: center;

            color: #252535;

            font-size: 12px;

            line-height: 1.4;
        }


        .info-label {
            font-weight: 700;

            white-space: nowrap;
        }


        .info-separator {
            text-align: center;

            font-weight: 700;
        }


        .info-value {
            font-weight: 500;

            white-space: nowrap;
        }


        /* =========================================================
                                           FORM GRID
                                        ========================================================= */

        .form-grid {
            display: grid;

            grid-template-columns: 1fr 1.12fr;

            column-gap: 37px;

            row-gap: 14px;
        }


        .form-group {
            min-width: 0;

            display: flex;
            flex-direction: column;
        }


        .form-group.full {
            grid-column: 1 / -1;
        }


        /* =========================================================
                                           LABEL
                                        ========================================================= */

        .form-group label {
            margin-bottom: 6px;

            color: #202235;

            font-size: 12px;

            line-height: 1.2;

            font-weight: 700;
        }


        .required {
            color: #e32626;
        }


        /* =========================================================
                                           INPUT
                                        ========================================================= */

        .form-control {
            width: 100%;

            height: 43px;

            box-sizing: border-box;

            padding: 0 14px;

            background: #ffffff;

            border: 1px solid #aeb6c7;

            border-radius: 8px;

            color: #303449;

            font-family: inherit;

            font-size: 12px;

            outline: none;
        }


        .form-control::placeholder {
            color: #9aa2b5;

            opacity: 1;
        }


        .form-control:focus {
            border-color: #7c87a0;

            box-shadow:
                0 0 0 2px rgba(37, 36, 61, 0.06);
        }


        textarea.form-control {
            height: 91px;

            padding: 12px 14px;

            resize: vertical;
        }


        select.form-control {
            cursor: pointer;

            padding-right: 38px;

            appearance: auto;
        }


        /* =========================================================
                                           ERROR
                                        ========================================================= */

        .is-invalid {
            border-color: #dc2626;
        }


        .error-text {
            margin-top: 5px;

            color: #dc2626;

            font-size: 10px;
        }


        /* =========================================================
                                           LOKASI
                                        ========================================================= */

        /*
                                            Section lokasi membutuhkan 3 kolom:

                                            Gedung | Lantai | Ruangan
                                        */

        .form-section:nth-of-type(3) .form-grid {
            grid-template-columns: repeat(3, 1fr);

            column-gap: 19px;

            row-gap: 17px;
        }


        /* Detail lokasi full */

        .form-section:nth-of-type(3) .form-group.full {
            grid-column: 1 / -1;
        }


        /* =========================================================
                                           UPLOAD FOTO
                                        ========================================================= */

        .upload-box {
            width: 100%;

            min-height: 124px;

            box-sizing: border-box;

            border: 2px solid #25253a;

            border-radius: 9px;

            display: flex;

            align-items: center;
            justify-content: center;

            text-align: center;

            cursor: pointer;

            transition: background .15s ease;
        }


        .upload-box:hover {
            background: #fafbfc;
        }


        .upload-box-content {
            pointer-events: none;
        }


        .upload-main {
            margin-bottom: 7px;

            color: #252535;

            font-size: 12px;

            font-weight: 700;
        }


        .upload-info {
            color: #929aae;

            font-size: 10px;
        }


        #foto {
            display: none;
        }


        /* =========================================================
                                           PHOTO PREVIEW
                                        ========================================================= */

        .preview-container {
            display: flex;

            gap: 16px;

            flex-wrap: wrap;

            margin-top: 16px;
        }


        .preview-item {
            position: relative;

            width: 143px;

            height: 87px;

            box-sizing: border-box;

            overflow: hidden;

            background: #f3f4f6;

            border: 2px solid #25253a;

            border-radius: 9px;
        }


        .preview-item img {
            width: 100%;
            height: 100%;

            display: block;

            object-fit: cover;
        }


        .preview-remove {
            position: absolute;

            top: 5px;
            right: 5px;

            width: 21px;
            height: 21px;

            padding: 0;

            border: 0;

            border-radius: 50%;

            background: rgba(0, 0, 0, .70);

            color: #ffffff;

            cursor: pointer;

            font-size: 13px;

            line-height: 21px;
        }


        .photo-count {
            margin-top: 7px;

            color: #777f91;

            font-size: 10px;
        }


        /* =========================================================
                                           ACTION BUTTON
                                        ========================================================= */

        .form-actions {
            display: flex;

            justify-content: flex-end;

            align-items: center;

            gap: 17px;

            margin-top: 28px;

            margin-bottom: 5px;
        }


        .btn {
            height: 44px;

            box-sizing: border-box;

            padding: 0 24px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            border-radius: 9px;

            font-family: inherit;

            font-size: 12px;

            font-weight: 700;

            text-decoration: none;

            cursor: pointer;
        }


        .btn-secondary {
            min-width: 89px;

            background: #ffffff;

            color: #252535;

            border: 2px solid #25253a;
        }


        .btn-primary {
            min-width: 197px;

            background: #25243d;

            color: #ffffff;

            border: 2px solid #25243d;
        }


        .btn-primary:hover {
            background: #1d1c31;

            border-color: #1d1c31;
        }


        /* =========================================================
                                           SUCCESS
                                        ========================================================= */

        .alert-success {
            margin-bottom: 15px;

            padding: 10px 12px;

            background: #ecfdf5;

            border: 1px solid #a7f3d0;

            border-radius: 7px;

            color: #047857;

            font-size: 12px;
        }


        /* =========================================================
                                           RESPONSIVE
                                        ========================================================= */

        @media (max-width: 1000px) {

            .laporan-wrapper {
                max-width: 100%;
            }

        }


        @media (max-width: 800px) {

            .form-section {
                padding-left: 25px;
                padding-right: 25px;
            }

            .pelapor-box {
                padding-left: 25px;
                padding-right: 25px;
            }

            .pelapor-grid {
                grid-template-columns: 1fr;

                row-gap: 10px;
            }

            .form-section:nth-of-type(3) .form-grid {
                grid-template-columns: 1fr;
            }

            .form-section:nth-of-type(3) .form-group.full {
                grid-column: auto;
            }

        }


        @media (max-width: 600px) {

            .page-title h1 {
                font-size: 21px;
            }

            .form-section {
                padding: 14px 18px 25px;

                border-radius: 14px;
            }

            .section-title {
                margin-left: 0;
            }

            .pelapor-box {
                padding: 18px;
            }

            .info-row {
                grid-template-columns: 105px 10px 1fr;

                font-size: 10px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .form-actions {
                justify-content: stretch;
            }

            .btn {
                flex: 1;
            }

        }
    </style>


    <div class="laporan-wrapper">





        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))

            <div class="alert-success">
                {{ session('success') }}
            </div>

        @endif


        <form action="{{ route('pelapor.ajukan.store') }}" method="POST" enctype="multipart/form-data">

            @csrf


            {{-- =====================================================
            1. INFORMASI PELAPOR
            ====================================================== --}}

            <div class="form-section">

                <div class="section-title">

                    <span class="section-icon">
                        <svg viewBox="0 0 24 24">
                            <rect x="4" y="3" width="16" height="18" rx="2"></rect>
                            <line x1="8" y1="8" x2="16" y2="8"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                            <line x1="8" y1="16" x2="13" y2="16"></line>
                        </svg>
                    </span>

                    <span>1. Informasi Pelapor</span>

                </div>


                <div class="pelapor-box">

                    <div class="pelapor-grid">


                        {{-- NAMA --}}

                        <div class="info-row">

                            <span class="info-label">
                                Nama Lengkap
                            </span>

                            <span class="info-separator">
                                :
                            </span>

                            <span class="info-value">
                                {{ $user->name ?? '-' }}
                            </span>

                        </div>


                        {{-- PROGRAM STUDI --}}

                        <div class="info-row">

                            <span class="info-label">
                                Program Studi
                            </span>

                            <span class="info-separator">
                                :
                            </span>

                            <span class="info-value">
                                {{ $user->program_studi ?? '-' }}
                            </span>

                        </div>


                        {{-- NIM / NIP --}}

                        <div class="info-row">

                            <span class="info-label">
                                NIM / NIP
                            </span>

                            <span class="info-separator">
                                :
                            </span>

                            <span class="info-value">
                                {{ $user->nim_nip ?? '-' }}
                            </span>

                        </div>


                        {{-- EMAIL --}}

                        <div class="info-row">

                            <span class="info-label">
                                Email
                            </span>

                            <span class="info-separator">
                                :
                            </span>

                            <span class="info-value">
                                {{ $user->email ?? '-' }}
                            </span>

                        </div>


                        {{-- FAKULTAS --}}

                        <div class="info-row">

                            <span class="info-label">
                                Fakultas
                            </span>

                            <span class="info-separator">
                                :
                            </span>

                            <span class="info-value">
                                {{ $user->fakultas ?? '-' }}
                            </span>

                        </div>


                        {{-- NOMOR HP --}}

                        <div class="info-row">

                            <span class="info-label">
                                Nomor HP
                            </span>

                            <span class="info-separator">
                                :
                            </span>

                            <span class="info-value">
                                {{ $user->no_hp ?? '-' }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
            2. INFORMASI KERUSAKAN
            ====================================================== --}}

            <div class="form-section">

                <div class="section-title">

                    <span class="section-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M6 3h9l3 3v15H6z"></path>
                            <path d="M14 3v4h4"></path>
                            <line x1="9" y1="11" x2="15" y2="11"></line>
                            <line x1="9" y1="15" x2="15" y2="15"></line>
                        </svg>
                    </span>

                    <span>2. Informasi Kerusakan</span>

                </div>


                <div class="form-grid">


                    {{-- JUDUL --}}

                    <div class="form-group full">

                        <label>
                            Judul Laporan
                            <span class="required">*</span>
                        </label>

                        <input type="text" name="judul_laporan"
                            class="form-control @error('judul_laporan') is-invalid @enderror"
                            placeholder="Contoh: AC Ruang Laboratorium Tidak Dingin" value="{{ old('judul_laporan') }}">

                        @error('judul_laporan')

                            <div class="error-text">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- KATEGORI --}}

                    <div class="form-group">

                        <label>
                            Kategori Kerusakan
                            <span class="required">*</span>
                        </label>

                        <select name="kategori_kerusakan_id"
                            class="form-control @error('kategori_kerusakan_id') is-invalid @enderror">

                            <option value="">
                                Pilih Kategori Kerusakan
                            </option>

                            @foreach($kategori as $item)

                                <option value="{{ $item->id }}" {{ old('kategori_kerusakan_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>

                            @endforeach

                        </select>

                        @error('kategori_kerusakan_id')

                            <div class="error-text">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- DESKRIPSI --}}

                    <div class="form-group">

                        <label>
                            Deskripsi Kerusakan
                            <span class="required">*</span>
                        </label>

                        <textarea name="deskripsi_kerusakan"
                            class="form-control @error('deskripsi_kerusakan') is-invalid @enderror"
                            placeholder="Jelaskan kondisi kerusakan secara detail...">{{ old('deskripsi_kerusakan') }}</textarea>

                        @error('deskripsi_kerusakan')

                            <div class="error-text">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- =====================================================
            3. LOKASI KERUSAKAN
            ====================================================== --}}

            <div class="form-section">

                <div class="section-title">

                    <span class="section-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0z"></path>
                            <circle cx="12" cy="10" r="2.5"></circle>
                        </svg>
                    </span>

                    <span>3. Lokasi Kerusakan</span>

                </div>


                <div class="form-grid">


                    {{-- GEDUNG --}}

                    <div class="form-group">

                        <label>
                            Gedung
                            <span class="required">*</span>
                        </label>

                        <select id="gedung" name="gedung_id" class="form-control @error('gedung_id') is-invalid @enderror">

                            <option value="">
                                Pilih Gedung
                            </option>

                            @foreach($gedungs as $gedung)

                                <option value="{{ $gedung->id }}" {{ old('gedung_id') == $gedung->id ? 'selected' : '' }}>
                                    {{ $gedung->nama }}
                                </option>

                            @endforeach

                        </select>

                        @error('gedung_id')

                            <div class="error-text">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- LANTAI --}}

                    <div class="form-group">

                        <label>
                            Lantai
                            <span class="required">*</span>
                        </label>

                        <input type="text" id="lantai" name="lantai"
                            class="form-control @error('lantai') is-invalid @enderror"
                            value="{{ old('lantai') }}" maxlength="50"
                            placeholder="Contoh: Lantai 1">

                        @error('lantai')

                            <div class="error-text">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- RUANGAN --}}

                    <div class="form-group">

                        <label>
                            Ruangan
                            <span class="required">*</span>
                        </label>

                        <input type="text"
                            id="ruangan"
                            name="ruangan"
                            value="{{ old('ruangan') }}"
                            class="form-control @error('ruangan') is-invalid @enderror"
                            placeholder="Contoh: Ruang 101">

                        @error('ruangan')
                            <div class="error-text">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- DETAIL LOKASI --}}

                    <div class="form-group full">

                        <label>
                            Detail Lokasi
                            <span class="required">*</span>
                        </label>

                        <input type="text" name="detail_lokasi"
                            class="form-control @error('detail_lokasi') is-invalid @enderror"
                            placeholder="Contoh: AC bagian depan ruangan, dekat jendela, dll."
                            value="{{ old('detail_lokasi') }}">

                        @error('detail_lokasi')

                            <div class="error-text">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- =====================================================
            4. BUKTI KERUSAKAN
            ====================================================== --}}

            <div class="form-section">

                <div class="section-title">

                    <span class="section-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 7h4l2-2h4l2 2h4v12H4z"></path>
                            <circle cx="12" cy="13" r="3.5"></circle>
                        </svg>
                    </span>

                    <span>4. Bukti Kerusakan (Foto)</span>

                </div>


                <label for="foto" class="upload-box">

                    <div class="upload-box-content">

                        <div class="upload-main">
                            Klik untuk upload foto atau drag & drop
                        </div>

                        <div class="upload-info">
                            Format: JPG, PNG | Maksimal 5 MB per foto | Maksimal 5 foto
                        </div>

                    </div>

                </label>


                <input type="file" id="foto" name="foto[]" accept="image/jpeg,image/png" multiple>


                <div id="preview-container" class="preview-container"></div>


                <div id="photo-count" class="photo-count">
                    Belum ada foto dipilih.
                </div>


                @error('foto')

                    <div class="error-text">
                        {{ $message }}
                    </div>

                @enderror


                @error('foto.*')

                    <div class="error-text">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- =====================================================
            ACTION
            ====================================================== --}}

            <div class="form-actions">

                <a href="{{ route('pelapor.dashboard') }}" class="btn btn-secondary">
                    Batal
                </a>


                <button type="submit" class="btn btn-primary">
                    Kirim Laporan
                </button>

            </div>

        </form>

    </div>


    <script>
        // Preview foto yang dipilih sebelum laporan dikirim.
        const fotoInput = document.getElementById('foto');
        const previewContainer = document.getElementById('preview-container');
        const photoCount = document.getElementById('photo-count');
        const uploadBox = document.querySelector('.upload-box');
        let fotoTerpilih = [];

        function tampilkanPreviewFoto() {
            previewContainer.innerHTML = '';
            photoCount.textContent = fotoTerpilih.length
                ? fotoTerpilih.length + ' foto dipilih.'
                : 'Belum ada foto dipilih.';

            fotoTerpilih.forEach((file, index) => {
                const item = document.createElement('div');
                item.className = 'preview-item';

                const gambar = document.createElement('img');
                gambar.alt = file.name;
                gambar.src = URL.createObjectURL(file);
                gambar.onload = () => URL.revokeObjectURL(gambar.src);

                const hapus = document.createElement('button');
                hapus.type = 'button';
                hapus.className = 'preview-remove';
                hapus.textContent = '×';
                hapus.setAttribute('aria-label', 'Hapus ' + file.name);
                hapus.addEventListener('click', () => {
                    fotoTerpilih.splice(index, 1);
                    sinkronkanFotoInput();
                });

                item.appendChild(gambar);
                item.appendChild(hapus);
                previewContainer.appendChild(item);
            });
        }

        function sinkronkanFotoInput() {
            const dataTransfer = new DataTransfer();
            fotoTerpilih.forEach(file => dataTransfer.items.add(file));
            fotoInput.files = dataTransfer.files;
            tampilkanPreviewFoto();
        }

        function tambahFoto(files) {
            const pesan = [];
            Array.from(files).forEach(file => {
                if (!['image/jpeg', 'image/png'].includes(file.type)) {
                    pesan.push(file.name + ': format harus JPG atau PNG.');
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    pesan.push(file.name + ': ukuran melebihi 5 MB.');
                    return;
                }
                if (fotoTerpilih.length >= 5) {
                    pesan.push('Maksimal 5 foto.');
                    return;
                }
                if (fotoTerpilih.some(existing =>
                    existing.name === file.name &&
                    existing.size === file.size &&
                    existing.lastModified === file.lastModified
                )) {
                    return;
                }
                fotoTerpilih.push(file);
            });

            sinkronkanFotoInput();
            if (pesan.length) {
                photoCount.textContent = fotoTerpilih.length
                    ? fotoTerpilih.length + ' foto dipilih. ' + pesan.join(' ')
                    : pesan.join(' ');
            }
        }

        fotoInput.addEventListener('change', function () {
            tambahFoto(this.files);
        });

        uploadBox.addEventListener('dragover', function (event) {
            event.preventDefault();
            uploadBox.style.background = '#f3f4f6';
        });

        uploadBox.addEventListener('dragleave', function () {
            uploadBox.style.background = '';
        });

        uploadBox.addEventListener('drop', function (event) {
            event.preventDefault();
            uploadBox.style.background = '';
            tambahFoto(event.dataTransfer.files);
        });

    </script>

@endsection