@extends('layout/template')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-sidebar-v2/css/leaflet-sidebar.min.css" />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .navbar-fixed-top {
            /* Ganti dengan class/ID navbar Anda yang sebenarnya */
            flex-shrink: 0;
            /* Mencegah navbar menyusut */
            height: 56px;
            /* Tinggi navbar Anda (sesuaikan jika berbeda) */
            width: 100%;
        }
        #main-layout-area {
            flex: 1;
            display: flex;

            flex-direction: row;
            overflow: hidden;
        }
        #container {
            display: flex;
            flex-direction: row;
            /* Untuk .sidebar_left dan .content-panel */
            height: 100%;
            /* Mengisi 100% tinggi dari parent-nya (#main-layout-area) */
            flex-shrink: 0;
        }

        #map {
            flex: 1;
            /* Peta mengambil sisa ruang horizontal yang tersedia */
            height: 100%;
            /* Peta mengisi 100% tinggi dari parent-nya (#main-layout-area) */
            background-color: #e4e4e4;
            /* Placeholder background */
        }

        /* --- Sidebar Specific Styles --- */
        .sidebar_left {
            background-color: rgba(235, 175, 86, 0.911);
            color: white;
            width: 120px;
            height: 100%;
            display: flex;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
            flex-direction: column;
            flex-shrink: 0;
            /* Mencegah sidebar ini menyusut */
        }

        .sidebar-header {
            padding: 10px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            background-color: rgba(235, 175, 86, 0.911);
            border-bottom: 1.5px solid #ddd;
            flex-shrink: 0;
            /* Memastikan header tidak menyusut */
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
            /* Memungkinkan menu tumbuh dan mengisi ruang vertikal yang tersedia */
            /* overflow-y: auto; */
            /* Aktifkan jika item menu itu sendiri perlu discroll */
        }

        /* --- Content Panel Specific Styles (untuk panel legenda, layer, basemap) --- */
        .content-panel {
            flex: 1;
            /* Memungkinkan content-panel mengambil sisa ruang horizontal di #container */
            display: flex;
            flex-direction: column;
            /* Menyusun content-header dan content-text secara vertikal */
            height: 100%;
            /* Mengisi 100% tinggi dari #container */
            overflow: hidden;
            /* Mencegah scrolling pada wrapper ini */
        }

        .content-header {
            padding: 10px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            background-color: #D2691E;
            border-bottom: 1.5px solid #ddd;
            width: 120px;
        }
        .sidebar-menu li {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .sidebar-menu li:hover {
            background-color: #b3510b;

        }

        #contentText {
            flex: 1;
            /* Memungkinkan contentText mengambil semua sisa ruang vertikal di content-panel */
            display: flex;
            flex-direction: column;
            /* Menyusun #layerContent, #basemapContent, #sidebarLegend secara vertikal */
            overflow-y: hidden;
            /* Kontainer ini sendiri tidak boleh discroll, anak-anaknya yang akan discroll */
            padding: 0;
        }

        /* Styles untuk panel konten individual: #sidebarLegend, #layerContent, #basemapContent */
        /* Pastikan elemen-elemen ini adalah anak langsung dari #contentText */
        #sidebarLegend,
        #layerContent,
        #basemapContent {
            flex-shrink: 0;
            flex-grow: 1;
            overflow-y: auto;
            /* INI KRITIS: Mengaktifkan scrolling vertikal untuk konten yang meluap */
            max-height: 100%;
            /* Memastikan mereka tidak melebihi tinggi parent-nya (#contentText) */

            /* Gaya yang sudah ada dari CSS yang Anda berikan */
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
            font-size: 14px;
            line-height: 1.6;
            transition: all 0.3s ease;
        }

        /* --- Kustomisasi Scrollbar & Animasi (sesuai yang Anda berikan) --- */
        #sidebarLegend::-webkit-scrollbar {
            width: 8px;
        }

        #sidebarLegend::-webkit-scrollbar-track {
            background: #dae1e5;
        }

        #sidebarLegend::-webkit-scrollbar-thumb {
            background: #D2691E;
            border-radius: 4px;
        }

        #sidebarLegend::-webkit-scrollbar-thumb:hover {
            background: #A0522D;
        }

        #sidebarLegend.show {
            display: block;
            opacity: 1;
            transform: translateX(0);
        }

        #sidebarLegend.hide {
            opacity: 0;
            transform: translateX(-100%);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* --- Gaya Legenda, Basemap, Layer Lainnya (sesuai yang Anda berikan) --- */
        .legend-category {
            margin-top: 10px;
            margin-bottom: 20px;
            margin-left: 10px;
            padding-bottom: 10px;
            border-bottom: 1.5px solid #A0522D;
            color: #702908;
        }

        .legend-category h5 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #702908;
            margin-bottom: 15px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        .legend-category i {
            width: 25px;
            height: 15px;
            display: inline-block;
            margin-right: 8px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .legend-category i:hover {
            transform: scale(1.5);
            transition: transform 0.2s ease;
            border-color: #666;
        }

        #basemapContent {
            background: #f8f9fc;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        #basemapContent:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .basemap-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #702908;
            margin-bottom: 15px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        .basemap-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .basemap-list li {
            margin-bottom: 10px;
        }

        .basemap-list label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 1rem;
            color: #333;
            transition: color 0.3s ease;
        }

        .basemap-list label:hover {
            color: #702908;
        }

        .basemap-list input[type="radio"] {
            margin-right: 10px;
            accent-color: #702908;
        }

        .basemap-list input[type="radio"]:checked+span {
            font-weight: bold;
            color: #702908;
            text-decoration: underline;
        }

        #layerContent {
            background: #f8f9fc;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        #layerContent:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .overlay-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #702908;
            margin-bottom: 15px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        .overlay-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .overlay-list li {
            margin-bottom: 10px;
        }

        .overlay-list label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 1rem;
            color: #333;
            transition: color 0.3s ease;
        }

        .overlay-list label:hover {
            color: #702908;
        }

        .overlay-list input[type="checkbox"] {
            margin-right: 10px;
            accent-color: #702908;
        }

        .overlay-list input[type="checkbox"]:checked+span {
            font-weight: bold;
            color: #051443;
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
    {{-- Main wrapper for flex layout: map and sidebar --}}
    <div id="app-wrapper" style="display: flex; flex-direction: row; height: 100vh;"> @include('components/menu')
        {{-- This will now include your sidebar --}}
        <div id="map" style="flex: 1; height: 100%;"></div> {{-- Map will take remaining space --}}
    </div>

    {{-- Modal for creating point --}}
    <div class="modal fade" id="createpointModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Point</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('points.store') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill the point name">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Fungsi Bangunan</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tipe" class="form-label">Tipe</label>
                            <select class="form-select" id="tipe" name="tipe">
                                <option value="AP">Aset Pemkot</option>
                                <option value="BT">Belum Terdaftar</option>
                                <option value="HGB">Hak Guna Bangunan</option>
                                <option value="HM">Hak Milik</option>
                                <option value="Hak Pakai">Hak Pakai</option>
                                <option value="Hak Pinjam">Hak Pinjam</option>
                                <option value="Hak Wakaf">Hak Wakaf</option>
                                <option value="Lain Lain">Lain-Lain</option>
                                <option value="SK">Surat Kekancingan</option>
                                <option value="Verponding">Verponding</option>
                            </select>

                            <div class="mb-3">
                                <label for="geom_point" class="form-label">Geometry</label>
                                <textarea class="form-control" id="geom_point" name="geom_point" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Photo</label>
                                <input type="file" class="form-control" id="image_point" name="image"
                                    onchange="document.getElementById('preview-image-point').src = window.URL.createObjectURL(this.files[0])">
                                <img src="" alt="" id="preview-image-point" class="img-thumbnail"
                                    width="500">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>
    <script src="https://unpkg.com/leaflet-sidebar-v2/js/leaflet-sidebar.min.js"></script>

    <script>
        var map = L.map('map').setView([-7.78590077277728, 110.36025240235908], 13);

        // Definisi basemap
        var basemaps = {
            "OpenStreetMap": L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; OpenStreetMap contributors'
            }),
            "Esri World Imagery": L.tileLayer(
                "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
                    attribution: 'Tiles &copy; Esri'
                }),
            "Topographic": L.tileLayer("https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; OpenTopoMap'
            }),
            "RupaBumi Indonesia": L.tileLayer(
                "https://geoservices.big.go.id/rbi/rest/services/BASEMAP/Rupabumi_Indonesia/MapServer/tile/{z}/{y}/{x}", {
                    attribution: 'Badan Informasi Geospasial'
                })
        };
        // Tambahkan default basemap ke peta
        basemaps["OpenStreetMap"].addTo(map);
        // Logika untuk mengganti basemap
        function setBasemap(basemapKey) {
            Object.keys(basemaps).forEach(function(key) {
                if (key === basemapKey) {
                    basemaps[key].addTo(map);
                } else {
                    map.removeLayer(basemaps[key]);
                }
            });
        }

        var drawControl = new L.Control.Draw({
            draw: {
                position: 'topleft',
                polyline: true,
                polygon: true,
                rectangle: true,
                circle: false,
                marker: true,
                circlemarker: true
            },
            edit: false
        });
        map.addControl(drawControl);
        map.on('draw:created', function(e) {
            var type = e.layerType,
                layer = e.layer;

            console.log(type);

            var drawnJSONObject = layer.toGeoJSON();
            var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

            console.log(drawnJSONObject);
            // console.log(objectGeometry);

            if (type === 'polyline') {
                console.log("Create " + type);
                $('#geom_polyline').val(objectGeometry);
                //MEMUNCULKAN MODAL POLYLINE
                $('#createpolylineModal').modal('show');


            } else if (type === 'polygon' || type === 'rectangle') {
                console.log("Create " + type);
                $('#geom_polygon').val(objectGeometry);
                //MEMUNCULKAN MODAL POLYGON
                $('#createpolygonModal').modal('show');

            } else if (type === 'marker') {
                console.log("Create " + type);
                $('#geom_point').val(objectGeometry);
                //MEMUNCULKAN MODAL MARKER
                $('#createpointModal').modal('show');
            } else {
                console.log('__undefined__');
            }
            drawnItems.addLayer(layer);
        });

        // GeoJSON Points
        var point = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                var routedelete = "{{ route('points.destroy', ':id') }}";
                routedelete = routedelete.replace(':id', feature.properties.id);

                var routeedit = "{{ route('points.edit', ':id') }}";
                routeedit = routeedit.replace(':id', feature.properties.id);

                var popupContent =
                    "Nama: " + feature.properties.name + "<br>" +
                    "Deskripsi: " + feature.properties.description + "<br>" +
                    "Tipe: " + feature.properties.tipe + "<br>" +
                    "Dibuat: " + feature.properties.created_at + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.properties.image +
                    "' width='300px' alt=''>" + "<br>" +
                    "<div class='row mt-4'>" +
                    "<div class='col-6 text-end'>" +
                    "<a href='" + routeedit +
                    "' class='btn btn-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a>" +
                    "</div>" +

                    "<div class='col-6'>" +
                    "<form method='POST' action='" + routedelete + "'>" +
                    '@csrf' + '@method('DELETE')' +
                    "<button type='submit' class='btn btn-sm btn-danger' onclick='return confirm(`Yakin Akan dihapus?`)'><i class='fa-solid fa-trash'></i></button>" +
                    "</form>" +
                    "</div>" + "<br>" + "<p>Dibuat: " + feature.properties.user_created + "</p>" +
                    "</div>";

                layer.on({
                    click: function(e) {
                        point.bindPopup(popupContent);
                    },
                    mouseover: function(e) {
                        point.bindTooltip(feature.properties.description);
                    },
                });
            },
        });
        $.getJSON("{{ route('api.points') }}", function(data) {
            point.addData(data);
            map.addLayer(point);
        });

        // Tambah Data GeoJSON KKPR 2022
        map.createPane('panedata22');
        map.getPane("panedata22").style.zIndex = 304;
        var kkpr_2022 = L.geoJSON(null, {
            pane: 'panedata22',
            // Style berdasarkan kategori kode_warna
            style: function(feature) {
                var kkpr_2022 = feature.properties.Kode;
                var fillColor;

                // Tetapkan warna berdasarkan nilai Kode
                if (kkpr_2022 === "R2" || kkpr_2022 === "R-2") {
                    fillColor = "#ffdc00";
                } else if (kkpr_2022 === "C1" || kkpr_2022 === "C-1") {
                    fillColor = "#f05500";
                } else if (kkpr_2022 === "C2" || kkpr_2022 === "C-2") {
                    fillColor = "#f0731e";
                } else if (kkpr_2022 === "CB") {
                    fillColor = "#ff37cd";
                } else if (kkpr_2022 === "HK") {
                    fillColor = "#9b00ff";
                } else if (kkpr_2022 === "K1" || kkpr_2022 === "K-1") {
                    fillColor = "#ff6464";
                } else if (kkpr_2022 === "K2" || kkpr_2022 === "K-2") {
                    fillColor = "#ff8282";
                } else if (kkpr_2022 === "KT") {
                    fillColor = "#9b9b9b";
                } else if (kkpr_2022 === "R1" || kkpr_2022 === "R-1") {
                    fillColor = "#ffbe00";
                } else if (kkpr_2022 === "R3" || kkpr_2022 === "R-3") {
                    fillColor = "#fff005";
                } else if (kkpr_2022 === "R4") {
                    fillColor = "#fffa4b";
                } else if (kkpr_2022 === "TR") {
                    fillColor = "#d73700";
                } else if (kkpr_2022 === "RTH2") {
                    fillColor = "#416900";
                } else if (kkpr_2022 === "RTH3" || kkpr_2022 === "RTH-3") {
                    fillColor = "#468700";
                } else if (kkpr_2022 === "RTH-4") {
                    fillColor = "#4ba500";
                } else if (kkpr_2022 === "RTH-5") {
                    fillColor = "#50c300";
                } else if (kkpr_2022 === "SC") {
                    fillColor = "#cc99ff";
                } else if (kkpr_2022 === "SPU1" || kkpr_2022 === "SPU-1") {
                    fillColor = "#7d197d";
                } else if (kkpr_2022 === "SPU-2") {
                    fillColor = "#9b329b";
                } else if (kkpr_2022 === "SPU-3") {
                    fillColor = "#b94bb9";
                } else {
                    fillColor = "#000000";
                }

                return {
                    opacity: 1,
                    color: 'black',
                    weight: 1.0,
                    fillOpacity: 1,
                    fillColor: fillColor
                };
            },
        }, );
        $.getJSON("{{ asset('storage/data/kkpr_2022.geojson') }}", function(data) {
            kkpr_2022.addData(data); // Menambahkan data ke layer GeoJSON
            map.addLayer(kkpr_2022); // Menambahkan layer ke dalam peta
        });

        // Tambah Data GeoJSON KKPR 2023
        map.createPane('panedata23');
        map.getPane("panedata23").style.zIndex = 305;

        var kkpr_2023 = L.geoJSON(null, {
            pane: 'panedata23',
            // Style berdasarkan kategori kode_warna
            style: function(feature) {
                var kkpr_2023 = feature.properties.POLA_RUANG;
                var fillColor;

                // Tetapkan warna berdasarkan nilai Kode
                if (["K-1", "K-1.k", "K-1.k-3", "k.1", "K.1", "K.1.K", "k1", "K1", "K1 B", "k1.b",
                        "K1.b", "K1.B", "k1.k", "K1.k", "K1.K", "k1.K3", "k1b", "K1B", "K1K", "K1K."
                    ].includes(kkpr_2023)) {
                    fillColor = "#ff6464";
                } else if (["k-2", "K-2", "K-2.K", "K-2.K-2", "K-2.k-3", "K-2.K-3", "K-2K", "K.2", "k2", "K2",
                        "k2k", "K2K", "k2.k", "K2.k", "K2.K"
                    ].includes(kkpr_2023)) {
                    fillColor = "#ff8282";
                } else if (kkpr_2023 === "KT") {
                    fillColor = "#9b9b9b";
                } else if (kkpr_2023 === "BJ") {
                    fillColor = "#ff1e1e";
                } else if (["C-1", "C1", "C1 b"].includes(kkpr_2023)) {
                    fillColor = "#f05500";
                } else if (["C-2", "C2"].includes(kkpr_2023)) {
                    fillColor = "#f0731e";
                } else if (["cb", "CB", "CB FIL", "CB FILOS", "CB-fil", "CB-FIL", "CB.I-2", "CB.I-3", "CB.I-6",
                        "CB.I-7", "CB.I-9", "CB.I.2"
                    ].includes(kkpr_2023)) {
                    fillColor = "#ff37cd";
                } else if (kkpr_2023 === "R") {
                    fillColor = "#ffa000";
                } else if (["R-2", "R-2.k", "R-2.k-3", "R.2.K", "r2", "R2", "R2-K", "R2-k.2", "R2,K", "R2.k",
                        "R2.K", "R2.k-4", "r2k", "R2K"
                    ].includes(kkpr_2023)) {
                    fillColor = "#ffdc00";
                } else if (["R-3", "R-3.k", "R.3K", "R.3.K", "r3", "R3", "R3-k.3", "r3.k", "R3.K", "R3.k",
                        "r3k", "R3K"
                    ].includes(kkpr_2023)) {
                    fillColor = "#ffdc00";
                } else if (["RTH 3", "RTH 3 > R3", "RTH-3", "RTH3"].includes(kkpr_2023)) {
                    fillColor = "#fff005";
                } else if (kkpr_2023 === "RTH-4") {
                    fillColor = "#4ba500";
                } else if (["SPU 1", "SPU 1,K", "SPU-1.K1", "spu1"].includes(kkpr_2023)) {
                    fillColor = "#7d197d";
                } else if (["SPU 2 K", "SPU-2"].includes(kkpr_2023)) {
                    fillColor = "#9b329b";
                } else if (["SPU 3", "SPU-3"].includes(kkpr_2023)) {
                    fillColor = "#b94bb9";
                } else {
                    fillColor = "#000000";
                }

                return {
                    opacity: 1,
                    color: 'black',
                    weight: 1.0,
                    fillOpacity: 1,
                    fillColor: fillColor
                };
            },
        }, );
        $.getJSON("{{ asset('storage/data/kkpr_2023.geojson') }}", function(data) {
            kkpr_2023.addData(data); // Menambahkan data ke layer GeoJSON
            map.addLayer(kkpr_2023); // Menambahkan layer ke dalam peta
        });
        // Logika untuk mengaktifkan/dinonaktifkan overlay layer
        // Menggunakan toggleLayer yang mengambil objek layer dan status checked
        function toggleLayer(layer, isChecked) {
            if (isChecked) {
                layer.addTo(map);
            } else {
                map.removeLayer(layer);
            }
        }

        // --- Sidebar Menu Control ---
        let activeMenu = null; // Variable to track the active menu

        function showContent(menu) {
            const sidebarLegend = document.getElementById('sidebarLegend');
            const contentTitle = document.getElementById('contentTitle');
            const contentText = document.getElementById('contentText'); // Ini adalah parent div untuk konten
            const layerContent = document.getElementById('layerContent');
            const basemapContent = document.getElementById('basemapContent');

            // Reset semua konten display
            layerContent.style.display = 'none';
            basemapContent.style.display = 'none';
            sidebarLegend.style.display = 'none'; // Sembunyikan legenda secara default

            if (activeMenu === menu) {
                // Jika menu yang sama diklik lagi, sembunyikan semua konten
                contentTitle.innerText = '';
                // contentText.innerHTML = ''; // Tidak perlu reset innerHTML dari contentText, cukup childrennya
                activeMenu = null; // Reset active menu
            } else {
                // Tampilkan konten yang dipilih
                if (menu === 'layer') {
                    layerContent.style.display = 'block';
                } else if (menu === 'legenda') {
                    sidebarLegend.style.display = 'block';
                    // Generate legend HTML dynamically based on your styling logic
                    sidebarLegend.innerHTML = `
                        <div class="legend-category">
                            <h5>Data Tahun 2022</h5>
                            <i style="background: #ffdc00; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perumahan Kepadatan Tinggi<br>
                            <i style="background: #f05500; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Campuran Intensitas Tinggi<br>
                            <i style="background: #f0731e; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Campuran Intensitas Menengah/Sedang<br>
                            <i style="background: #ff37cd; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Kawasan Cagar Budaya<br>
                            <i style="background: #9b00ff; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Kawasan Pertahanan dan Keamanan<br>
                            <i style="background: #ff6464; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perdagangan dan Jasa Skala Kota<br>
                            <i style="background: #ff8282; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perdagangan dan Jasa Skala WP<br>
                            <i style="background: #9b9b9b; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perkantoran<br>
                            <i style="background: #ffbe00; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perumahan Kepadatan Sangat Tinggi<br>
                            <i style="background: #fff005; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perumahan Kepadatan Sedang<br>
                            <i style="background: #fffa4b; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perumahan Kepadatan Rendah<br>
                            <i style="background: #d73700; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Transportasi<br>
                            <i style="background: #416900; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Taman Kota<br>
                            <i style="background: #468700; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Taman Kecamatan<br>
                            <i style="background: #4ba500; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Taman Kelurahan<br>
                            <i style="background: #50c300; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Taman RW<br>
                            <i style="background: #7d197d; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> SPU Skala Kota<br>
                            <i style="background: #9b329b; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> SPU Skala Kecamatan<br>
                            <i style="background: #b94bb9; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> SPU Skala Kelurahan<br>
                            <i style="background: #000000; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Lain-lain (Kode Tidak Dikenal)<br>
                        </div>
                        <div class="legend-category" style="margin-top: 20px;">
                            <h5>Data Tahun 2023</h5>
                            <i style="background: #ff6464; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perdagangan dan Jasa Skala Kota<br>
                            <i style="background: #ff8282; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perdagangan dan Jasa Skala WP<br>
                            <i style="background: #9b9b9b; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perkantoran<br>
                            <i style="background: #ff1e1e; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Badan Jalan<br>
                            <i style="background: #f05500; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Campuran Intensitas Tinggi<br>
                            <i style="background: #f0731e; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Campuran Intensitas Menengah/Sedang<br>
                            <i style="background: #ff37cd; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Cagar Budaya<br>
                            <i style="background: #ffa000; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Kawasan Perumahan<br>
                            <i style="background: #ffdc00; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perumahan Kepadatan Tinggi<br>
                            <i style="background: #fff005; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Perumahan Kepadatan Sedang<br>
                            <i style="background: #468700; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Taman Kecamatan<br>
                            <i style="background: #4ba500; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Taman Kelurahan<br>
                            <i style="background: #7d197d; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> SPU Skala Kota<br>
                            <i style="background: #9b329b; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> SPU Skala Kecamatan<br>
                            <i style="background: #b94bb9; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> SPU Skala Kelurahan<br>
                            <i style="background: #000000; width: 20px; height: 10px; display: inline-block; border: 1px solid black;"></i> Lain-lain (Kode Tidak Dikenal)<br>
                        </div>
                    `;
                } else if (menu === 'basemap') {
                    basemapContent.style.display = 'block';
                }
                activeMenu = menu;
            }
        }

        // Tampilkan konten 'layer' secara default saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            showContent('layer');
        });
    </script>
@endsection
