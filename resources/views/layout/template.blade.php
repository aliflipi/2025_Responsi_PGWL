<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage - KKPR Yogyakarta</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous" />

    <!-- Leaflet Plugins -->
    <link rel="stylesheet" href="plugin/leaflet-search-master/leaflet-search-master/dist/leaflet-search.min.css" />
    <link rel="stylesheet"
        href="plugin/Leaflet.defaultextent-master/Leaflet.defaultextent-master/dist/leaflet.defaultextent.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-sidebar-v2/css/leaflet-sidebar.min.css" />


    <!-- Leaflet CSS-->
    <link rel="icon" href="https://i.ibb.co.com/BCLJxwR/logo-gamacare.png" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('styles')

    <!-- Custom Styles -->
    <style>
        body {
            background-color: rgb(255, 255, 255);
            padding-top: 70px;
            margin-bottom: -200px;
        }

        .hero-section {
            background: linear-gradient(rgba(1, 7, 22, 0.5), rgba(2, 6, 68, 0.5)),
                url('https://cdn-images.hipwee.com/wp-content/uploads/2020/06/hipwee-jogja-1.jpeg');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 90px 20px;
            /* Menambah padding untuk tinggi lebih besar */
            height: 55vh;
            /* Membuat section memiliki tinggi penuh layar */
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero-section p {
            font-size: 1.5rem;
            margin-top: 15px;
        }

        .navbar .btn {
            margin-left: 10px;

        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999;
        }

        .navbar-brand span {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .container {
            display: flex;
            flex-wrap: nowrap;
            gap: 20px;
            justify-content: space-between;
        }

        h2 {
            color: #b46305;
            padding-bottom: 8px;
            margin-top: 20px;
        }

        p,
        li {
            color: #424242;
            line-height: 1.8;
            font-size: 20px;
            text-align: justify;
        }

        .box {
            border: 2px solid #e6e8e9;
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff;
            width: 100%;
            margin-bottom: 40px;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .half-box {
            width: 48%;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .half-box {
                width: 100%;
            }
        }

        .full-box {
            width: 80%;
            max-width: 100%;
            margin: auto;
            padding-left: 20px;
            padding-right: 20px;
            box-sizing: border-box;
        }

        .map-title {
            font-size: 34px;
            font-weight: bold;
            text-align: center;
            color: #0d6efd;
            margin-bottom: 20px;
        }

        .modal-content {
            background-color: #b46305;
            color: #ffffff;
        }

        .modal-header {
            border-bottom: 1px solid #faf9f8;
        }

        .modal-title {
            color: #b46305;
        }

        .modal-body {
            border-bottom: 1px solid #f5b941e0;
        }

        .btn-secondary {
            background-color: #f5b941e0;
            border-color: #f5b941e0;
        }

        .btn-secondary:hover {
            background-color: #E0A529;
            border-color: #E0A529;
        }
    </style>


</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">About</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Nama : Alif Nur Safitri</p>
                    <p>NIM : 23/522796/SV/23792</p>
                    <p>Kelas : A</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @include('components/navbar')

    @yield('content')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

    @include('components/toast')
</body>

</html>
