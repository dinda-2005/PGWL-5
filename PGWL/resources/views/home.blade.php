@extends('layouts.template')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f0e8;
            color: #2d5a27;
        }

        .hero-card {
            background: linear-gradient(135deg, #2d5a27, #4a8c3f);
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(45, 90, 39, 0.3);
            color: white;
            margin-bottom: 20px;
        }

        .hero-card .card-header {
            background: rgba(255, 255, 255, 0.15);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px 16px 0 0;
            font-weight: bold;
            font-size: 1.3rem;
        }

        .hero-card .card-body {
            color: #e8f5e1;
            font-size: 15px;
            line-height: 1.7;
        }

        .stat-card {
            background: white;
            border: 2px solid #c8e6c9;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(76, 140, 63, 0.15);
            transition: 0.3s ease;
            overflow: hidden;
            margin-bottom: 14px;
        }

        .stat-card:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 20px rgba(45, 90, 39, 0.25);
            border-color: #4a8c3f;
        }

        .stat-card .card-header {
            background: linear-gradient(90deg, #4a8c3f, #81c784);
            color: white;
            font-weight: 600;
            font-size: 1rem;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stat-card .card-body {
            background: #f9fdf7;
            padding: 12px 16px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2d5a27;
            line-height: 1;
        }

        #map-home {
            height: 100%;
            min-height: 380px;
            border-radius: 14px;
            border: 2px solid #c8e6c9;
            box-shadow: 0 2px 12px rgba(45, 90, 39, 0.15);
        }

        .map-wrapper {
            background: white;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 2px 12px rgba(45, 90, 39, 0.12);
            border: 1px solid #dcedc8;
            height: 100%;
        }

        .map-wrapper h6 {
            color: #2d5a27;
            font-weight: 700;
            margin-bottom: 10px;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
@endsection

@section('content')
    {{-- HERO SECTION --}}
    <div class="hero-section position-relative text-white"
        style="
    height: 100vh;
    min-height: 600px;
    background: url('{{ asset('storage/images/tembakau.jpg') }}') center center / cover no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
">
        <div
            style="
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(20,60,20,0.75) 0%, rgba(45,90,39,0.6) 100%);
    ">
        </div>

        <div class="text-center position-relative" style="z-index:2; padding: 0 20px;">
            <div
                style="
            font-size: 1.1rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #a8d5a2;
            margin-bottom: 12px;
            font-weight: 500;
        ">
                Website Geospasial Tembakau Temanggung</div>

            <h1
                style="
            font-size: clamp(3rem, 8vw, 7rem);
            font-weight: 900;
            letter-spacing: 6px;
            color: #ffffff;
            text-shadow: 0 4px 30px rgba(0,0,0,0.5);
            margin-bottom: 8px;
            line-height: 1;
        ">
                TETRA</h1>

            <div
                style="
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #81c784, #4caf50);
            margin: 16px auto;
            border-radius: 2px;
        ">
            </div>

            <p
                style="
            font-size: clamp(0.9rem, 2vw, 1.25rem);
            color: #d4edda;
            letter-spacing: 1px;
            font-weight: 300;
            margin-bottom: 32px;
        ">
                Temanggung Tobacco Trade &amp; Agribusiness</p>

            <a href="#konten-utama"
                style="
            display: inline-block;
            padding: 14px 36px;
            background: linear-gradient(135deg, #4a8c3f, #2d5a27);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 1px;
            box-shadow: 0 4px 20px rgba(45,90,39,0.5);
        ">
                🌿 Jelajahi Peta
            </a>

            <div style="margin-top: 48px; animation: bounce 2s infinite;">
                <div style="color: #a8d5a2; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 8px;">SCROLL</div>
                <div style="font-size: 1.5rem;">↓</div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4 mt-3" id="konten-utama">

        {{-- Baris 1: Deskripsi --}}
        <div class="row mb-3">
            <div class="col-12">
                <div class="card hero-card">
                    <div class="card-header">
                        🌿 Aplikasi Geospasial Tanaman Tembakau
                    </div>
                    <div class="card-body">
                        <p>Tanaman tembakau (Nicotiana tabacum) merupakan salah satu komoditas perkebunan strategis yang
                            memiliki peran penting dalam mendukung perekonomian daerah dan kesejahteraan masyarakat.
                            Kabupaten Temanggung dikenal sebagai salah satu sentra produksi tembakau terbaik di Indonesia,
                            dengan karakteristik geografis yang unik berupa wilayah pegunungan, kondisi tanah vulkanik yang
                            subur, serta iklim yang mendukung pertumbuhan tanaman tembakau berkualitas tinggi. Keunggulan
                            tersebut menjadikan tembakau Temanggung memiliki cita rasa, aroma, dan karakteristik khas yang
                            bernilai ekonomi tinggi serta diminati oleh berbagai industri pengolahan hasil tembakau.</p>

                        <p style="margin-bottom: 0;">Dalam proses budidayanya, tanaman tembakau memerlukan pengelolaan yang
                            terencana mulai dari tahap persiapan lahan, penanaman, pemeliharaan, hingga panen dan
                            pascapanen. Berbagai faktor seperti kondisi tanah, curah hujan, ketinggian wilayah, suhu udara,
                            dan teknik budidaya sangat memengaruhi kualitas serta produktivitas hasil panen. Oleh karena
                            itu, ketersediaan data yang akurat dan terintegrasi menjadi kebutuhan penting dalam mendukung
                            pengelolaan sektor pertanian tembakau secara efektif dan berkelanjutan.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Baris 2: Kartu Statistik (kiri) + Peta (kanan) --}}
        <div class="row">

            {{-- Kolom Kiri: 3 Kartu --}}
            <div class="col-md-4 d-flex flex-column">

                <div class="stat-card">
                    <div class="card-header">
                        📍 Jumlah Distributor Tembakau
                    </div>
                    <div class="card-body text-center">
                        <div class="stat-number">{{ $points_count }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="card-header">
                        🔷 Polygon
                    </div>
                    <div class="card-body text-center">
                        <div class="stat-number">{{ $polygons_count }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="card-header">
                        👤 Jumlah Pengguna
                    </div>
                    <div class="card-body text-center">
                        <div class="stat-number">{{ $users_count }}</div>
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan: Peta --}}
            <div class="col-md-8">
                <div class="map-wrapper">
                    <h6>🗺️ Peta Sebaran Data</h6>
                    <div id="map-home"></div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        var map = L.map('map-home').setView([-7.3145, 110.1768], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Fungsi warna choropleth
        function getColor(produksi) {
            var nilai = parseFloat(produksi) || 0;
            return nilai > 800 ? '#006400' :
                nilai > 600 ? '#38a800' :
                nilai > 400 ? '#79c900' :
                nilai > 200 ? '#ffff00' :
                nilai > 100 ? '#ffaa00' :
                nilai > 50 ? '#ff5500' :
                nilai > 0 ? '#ff0000' :
                '#cccccc';
        }

        // Layer Kecamatan
        var kecamatans = L.geoJSON(null, {
            style: function(feature) {
                return {
                    fillColor: getColor(feature.properties.produksi),
                    weight: 2,
                    opacity: 1,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.35
                };
            },
            onEachFeature: function(feature, layer) {
                var p = feature.properties;
                var nilaiProduksi = parseFloat(p.produksi) || 0;
                layer.bindPopup(
                    '<div style="min-width:200px">' +
                    '<h6 style="margin:0 0 8px 0; font-weight:bold; border-bottom:2px solid #ccc; padding-bottom:4px">' +
                    '🏘️ Kec. ' + p.nama_kecamatan + '</h6>' +
                    '<table style="width:100%; font-size:13px">' +
                    '<tr><td>Kabupaten</td><td>: <b>' + p.nama_kabupaten + '</b></td></tr>' +
                    '<tr><td>Produksi Tembakau</td><td>: <b>' + nilaiProduksi.toLocaleString('id-ID') +
                    ' Ton</b></td></tr>' +
                    '</table></div>'
                );
                layer.on({
                    mouseover: function(e) {
                        e.target.setStyle({
                            weight: 3,
                            color: '#333',
                            fillOpacity: 0.85
                        });
                    },
                    mouseout: function(e) {
                        kecamatans.resetStyle(e.target);
                    }
                });
            }
        });

        $.getJSON("{{ route('geojson.kecamatans') }}", function(data) {
            kecamatans.addData(data);
            map.addLayer(kecamatans);
        });

        // Layer Points
        // Icon rumah custom
        var rumahIcon = L.divIcon({
            html: `<div style="
        background: #2d5a27;
        width: 36px;
        height: 36px;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
    ">
        <span style="transform: rotate(45deg); font-size: 16px;">🏠</span>
    </div>`,
            className: '',
            iconSize: [36, 36],
            iconAnchor: [18, 36],
            popupAnchor: [0, -36]
        });

        // Layer Points
        var points = L.geoJSON(null, {
            pointToLayer: function(feature, latlng) {
                return L.marker(latlng, {
                    icon: rumahIcon
                });
            },
            onEachFeature: function(feature, layer) {
                var p = feature.properties;
                layer.bindPopup(
                    '<b>' + (p.name || 'Point') + '</b><br>' +
                    (p.description || '')
                );
            }
        });

        $.getJSON("{{ route('geojson.points') }}", function(data) {
            points.addData(data);
            map.addLayer(points);
        });

        // Legenda
        var legend = L.control({
            position: 'bottomright'
        });
        legend.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'info legend');
            div.style.cssText =
                'background:white; padding:10px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.3); font-size:12px; line-height:1.8';
            div.innerHTML =
                '<b style="font-size:13px">🌿 Produksi Tembakau (Ton)</b><br>' +
                '<i style="background:#006400;width:14px;height:14px;display:inline-block;margin-right:6px;opacity:0.8"></i> > 800 Ton<br>' +
                '<i style="background:#38a800;width:14px;height:14px;display:inline-block;margin-right:6px;opacity:0.8"></i> 601 – 800 Ton<br>' +
                '<i style="background:#79c900;width:14px;height:14px;display:inline-block;margin-right:6px;opacity:0.8"></i> 401 – 600 Ton<br>' +
                '<i style="background:#ffff00;width:14px;height:14px;display:inline-block;margin-right:6px;opacity:0.8"></i> 201 – 400 Ton<br>' +
                '<i style="background:#ffaa00;width:14px;height:14px;display:inline-block;margin-right:6px;opacity:0.8"></i> 101 – 200 Ton<br>' +
                '<i style="background:#ff5500;width:14px;height:14px;display:inline-block;margin-right:6px;opacity:0.8"></i> 51 – 100 Ton<br>' +
                '<i style="background:#ff0000;width:14px;height:14px;display:inline-block;margin-right:6px;opacity:0.8"></i> 1 – 50 Ton<br>' +
                '<i style="background:#cccccc;width:14px;height:14px;display:inline-block;margin-right:6px;opacity:0.8"></i> 0 Ton (tidak ada)';
            return div;
        };
        legend.addTo(map);
    </script>
@endsection

@section('content')
    <div class="container mt-3">

        <div class="card">
            <div class="card-header bg-pink text-white">
                <h3>Aplikasi Geospasial CRUD</h3>
            </div>

            <div class="card-body">
                <p>Aplikasi ini dibuat untuk memenuhi tugas mata kuliah Pemrograman Geospasial Website:Lanjut.Aplikasi
                    menampilkan peta interaktif yang menunjukkan objek dengan geometri titik, garis, dan area yang dapat
                    ditambah, ditampilkan, diubah, dan dihapus. Aplikasi ini dikembangkan dengan menggunakan Laravel dan
                    PostegresSQL - PostGIS.</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="card">
                    <div class="card-header bg-pink text-white">
                        <h3>Jumlah Point</h3>
                    </div>
                    <div class="card-body text-center">
                        <h1>
                            {{ $points_count }}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header bg-pink text-white">
                        <h3>Jumlah Polygon</h3>
                    </div>
                    <div class="card-body text-center">
                        <h1>
                            {{ $polygons_count }}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header bg-pink text-white">
                        <h3>Jumlah User</h3>
                    </div>
                    <div class="card-body text-center">
                        <h1>
                            {{ $users_count }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
