@extends('layout/template')

@section('content')
    <!-- Hero Section -->
    <div class="hero-section">
        <h1>KUMALA JOGJA: <em>Kundha Mandala</em> KKPR 2022–2023</h1>
        <h3>Layanan Informasi Kesesuaian Kegiatan Pemanfaatan Ruang Wilayah Yogyakarta</h3>
        <a href="{{ route('map') }}" target="_blank" class="btn btn-outline-light btn-lg mt-4">
            Lihat Peta Menampilkan Penataan Ruang Wilayah Yogyakarta
        </a>
        <a href="{{ route('table') }}" target="_blank" class="btn btn-outline-light btn-lg mt-4">
            Tabel
        </a>
    </div>
    <!-- Informasi Section -->
    <div class="info-container ">
        <h2 class="text-center mb-5 fw-bold">Informasi Mengenai Website KUMALA JOGJA</h2>
        <div class="box full-box mb-5">
            <h2>KUMALA JOGJA (<em>Kundha Mandala</em> KKPR 2022-2023)</h2>
            <p>Website <strong>KUMALA JOGJA</strong>(<em>Kundha Mandala</em> KKPR 2022-2023) GIS Tata Ruang Jogja: KKPR 2022
                & 2023 adalah aplikasi berbasis web yang menyajikan informasi mengenai Kesesuaian Kegiatan Pemanfaatan Ruang
                (KKPR) di wilayah Kota Yogyakarta. Peta ini menampilkan data pemanfaatan ruang yang telah disesuaikan dengan
                regulasi KKPR tahun 2022 dan 2023.</p>
            <p>Simbolisasi data pada masing-masing KKPR dari rentang tahun 2019 hingga tahun 2023 mengacu pada Peraturan
                Menteri Agraria dan Tata Ruang/Kepala Badan Pertanahan Nasional Republik Indonesia Nomor 14 Tahun 2021, yang
                mengatur tentang Pedoman Penyusunan Basis Data dan Penyajian Peta Rencana Tata Ruang Wilayah Provinsi,
                Kabupaten, dan Kota, serta Peta Rencana Detail Tata Ruang Kabupaten/Kota.</p>
        </div>
    </div>

    <div class="card-body">
        <div class="mapouter">
            <div class="gmap_canvas">
                <h4 class="map-title">Wilayah Yogyakarta</h4>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d53183.16557532672!2d110.34218527273079!3d-7.804385099031694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5787bd5b6bc5%3A0x21723fd4d3684f71!2sYogyakarta%2C%20Yogyakarta%20City%2C%20Special%20Region%20of%20Yogyakarta!5e0!3m2!1sen!2sid!4v1736829264147!5m2!1sen!2sid"
                    width="100%" height="500"
                    style="border:10px; border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);" allowfullscreen=""
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <!-- CSS untuk menempatkan peta di tengah -->
    <style>
        .card-body {
            display: flex;
            justify-content: center;
            /* Memusatkan secara horizontal */
            align-items: center;
            /* Memusatkan secara vertikal */
            height: 100vh;
            /* Tinggi penuh untuk memastikan konten tengah */
            margin-bottom: 0 !important;
        }
        .map-title {
            font-size: 34px;
            font-weight: bold;
            text-align: center;
            color: #b46305;
            margin-bottom: 20px;
        }

        .mapouter {
            position: relative;
            text-align: right;
            height: 760px;
            width: 1320px;
        }

        .gmap_canvas {
            overflow: hidden;
            background: none !important;
            height: 660px;
            width: 1320px;
            margin-bottom: 0 !important;
        }

        .map-title {
            text-align: center;

        }

        #linkwebsite-section {
            margin-top: 290px;
            /* Geser ke atas dengan margin negatif */
            padding-top: -9px;
            /* Tambahkan sedikit padding agar konten tidak terlalu mepet */
            margin-bottom: 0px;
        }

        #linkwebsite-section h3 {
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            color: #b46305;
            margin-bottom: 5px;
            margin-top: 10px;
            /* Sesuaikan margin jika terlalu rendah */
        }

        #linkwebsite-section h5 {
            text-align: center;
            font-size: 20px;
            color: rgb(9, 9, 9);
            margin-bottom: 10px;
            margin-top: -5px;
            /* Sesuaikan margin jika terlalu rendah */
        }

        .description-box {
            margin-top: 100px;
            /* Tambahkan jarak pada description jika diperlukan */
        }

        .interactive-image {
            max-width: 100%;
            /* Pastikan gambar berskala dengan baik */
            height: auto;
        }
    </style>

    <!-- Footer -->
    <footer class="py-3" style="background-color: #b46305;">
        <div class="container d-flex justify-content-between align-items-center flex-wrap">
            <!-- Informasi Kiri -->
            <div style="color: white; font-size: 0.9rem; max-width: 70%;">
                <strong>KUMALA JOGJA: Kundha Mandala KKPR 2022–2023</strong><br>
                Program Studi: Sistem Informasi Geografis<br>
                NIM: 23/522796/23782<br>
                Email: alif.nursafitri01@gmail.com<br>
                <a href="https://github.com/aliflipi" target="_blank" style="color: white; text-decoration: underline;">
                    github.com/aliflipi
                </a>
            </div>

            <!-- Gambar Kanan -->
            <div>
                <img src="{{ asset('storage/icon/LOGO_SIG.png') }}" alt="Logo Yogyakarta"
                    style="max-height: 60px; width: auto;">
            </div>
        </div>

        <p class="text-center text-white mt-3 mb-0" style="font-size: 0.85rem;">
            &copy; Alif Nur Safitri 2025
        </p>
    </footer>
@endsection
