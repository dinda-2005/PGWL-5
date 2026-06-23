@extends('layouts.template')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.9/dist/leaflet-search.min.css">

    <style>
        body,
        html {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: calc(100vh - 56px);
            width: 100%;
        }

        /* Routing */
        .routing-panel {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border-radius: 16px;
            padding: 16px 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: none;
            min-width: 300px;
            border: 2px solid #c8e6c9;
        }

        .routing-panel h6 {
            color: #2d5a27;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .routing-info {
            display: flex;
            gap: 20px;
            margin-bottom: 12px;
        }

        .routing-info-item {
            text-align: center;
        }

        .routing-info-item .nilai {
            font-size: 1.3rem;
            font-weight: 900;
            color: #2d5a27;
        }

        .routing-info-item .satuan {
            font-size: 0.75rem;
            color: #888;
        }

        .btn-tutup-rute {
            background: #e53935;
            color: white;
            border: none;
            padding: 6px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
        }
    </style>
@endsection


@section('content')
    <div id="map"></div>

    {{-- Panel Rute --}}
    <div class="routing-panel" id="routingPanel">
        <h6>🗺️ Rute ke <span id="namaGudang">-</span></h6>
        <div class="routing-info">
            <div class="routing-info-item">
                <div class="nilai" id="jarakRute">-</div>
                <div class="satuan">km</div>
            </div>
            <div class="routing-info-item">
                <div class="nilai" id="waktuRute">-</div>
                <div class="satuan">menit</div>
            </div>
        </div>
        <button class="btn-tutup-rute" onclick="tutupRute()">✕ Tutup Rute</button>
    </div>

    {{-- Modal Input Point --}}
    <div class="modal" tabindex="-1" id="modalInputPoint">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Input Point</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('points.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Geometry</label>
                            <textarea class="form-control" id="geometry_point" name="geometry_point"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>image</label>
                            <input type="file" class="form-control" name="image"
                                onchange="document.getElementById('preview-image-point').src =
                                window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-point" class="img-thumbnail"
                                width="400">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    {{-- Modal Polygon --}}
    <div class="modal" tabindex="-1" id="modalInputPolygon">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Input Polygon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('polygons.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Geometry</label>
                            <textarea class="form-control" id="geometry_polygon" name="geometry_polygon"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>image</label>
                            <input type="file" class="form-control" name="image"
                                onchange="document.getElementById('preview-image-polygone').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-polygone" class="img-thumbnail"
                                width="400">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.9/dist/leaflet-search.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // INIT MAP
        var map = L.map('map').setView([-7.3145, 110.1768], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        // FEATURE GROUP
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        // DRAW CONTROL
        var drawControl = new L.Control.Draw({
            draw: {
                polyline: true,
                polygon: true,
                rectangle: true,
                circle: false,
                marker: true,
                circlemarker: false
            },
            edit: false
        });

        map.addControl(drawControl);

        // EVENT DRAW
        map.on('draw:created', function(e) {

            var layer = e.layer;
            var type = e.layerType;

            var geojson = layer.toGeoJSON();
            var wkt = Terraformer.geojsonToWKT(geojson.geometry);

            console.log("Type:", type);
            console.log("WKT:", wkt);

            // POINT
            if (type === 'marker') {
                $('#geometry_point').val(wkt);
                new bootstrap.Modal(document.getElementById('modalInputPoint')).show();
            }

            // POLYLINE
            else if (type === 'polyline') {
                $('#geometry_polyline').val(wkt);
                new bootstrap.Modal(document.getElementById('modalInputPolyline')).show();
            }

            // POLYGON & RECTANGLE
            else if (type === 'polygon' || type === 'rectangle') {
                $('#geometry_polygon').val(wkt);
                new bootstrap.Modal(document.getElementById('modalInputPolygon')).show();
            }

            drawnItems.addLayer(layer);
        });

        // RELOAD setelah modal ditutup
        $('#modalInputPoint, #modalInputPolyline, #modalInputPolygon').on('hidden.bs.modal', function() {
            location.reload();
        });

        // GeoJSON Point
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

        var points = L.geoJSON(null, {
            pointToLayer: function(feature, latlng) {
                return L.marker(latlng, {
                    icon: rumahIcon
                });
            },

            // onEachFeature
            onEachFeature: function(feature, layer) {
                //Route delete point
                var routedelete = "{{ route('points.delete', ':id') }}";
                routedelete = routedelete.replace(':id', feature.properties.id);

                //Route edit point
                var routeedit = "{{ route('point.edit', ':id') }}";
                routeedit = routeedit.replace(':id', feature.properties.id);


                // variable popup content
                var popup_content = "Nama: " + feature.properties.name + "<br>" +
                    "Deskripsi: " + feature.properties.description + "<br>" +
                    "Dibuat: " + feature.properties.created_at + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.
                properties.image + "' alt='Image Point' class='img-thumbnail' width='600'>" +
                    "<br><br>" +
                    "<div class='row'>" + "<div class='col-2'>" +

                    "<form action='" + routedelete + "' method='post'>" +
                    '@csrf' +
                    '@method('delete')' +
                    "<button type='submit'class='btn btn-sm btn-danger' title='Delete feature' onclick='return confirm(`Are you sure you want to delete this feature?`)'><i class='fa-solid fa-trash-can'></i></button>" +
                    "</form>" +
                    "</div>" +
                    "<div class='col-2'>" +
                    "<a href='" + routeedit +
                    "' class='btn btn-warning btn-sm' title='Edit point'><i class='fa-solid fa-pen-to-square'></i></i></a>" +
                    "</div>" +
                    "<div class='mt-2'>" +
                    "<button onclick='buatRute(" +
                    feature.geometry.coordinates[1] + "," +
                    feature.geometry.coordinates[0] + ",\"" +
                    feature.properties.name + "\")' " +
                    "style='background:linear-gradient(135deg,#2d5a27,#4a8c3f);color:white;border:none;padding:8px 16px;border-radius:8px;cursor:pointer;font-weight:600;width:100%;margin-top:4px'>" +
                    "🗺️ Navigasi ke Sini" +
                    "</button>" +
                    "</div>" +
                    "</div>";

                layer.on({
                    click: function(e) {
                        points.bindPopup(popup_content);
                    },
                });
            },

        });

        $.getJSON("{{ route('geojson.points') }}", function(data) {
            points.addData(data);
            map.addLayer(points);
        });




        // GeoJSON Polygons
        var polygons = L.geoJSON(null, {
            //style

            // onEachFeature
            onEachFeature: function(feature, layer) {

                //Route delete polygon
                var routedelete = "{{ route('polygons.delete', ':id') }}";
                routedelete = routedelete.replace(':id', feature.properties.id);

                //Route edit polygon
                var routeedit = "{{ route('polygon.edit', ':id') }}";
                routeedit = routeedit.replace(':id', feature.properties.id);

                // variable popup content
                var popup_content = "Nama: " + feature.properties.name + "<br>" +
                    "Deskripsi: " + feature.properties.description + "<br>" +
                    "Dibuat: " + feature.properties.created_at + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.
                properties.image + "' alt='Image Polyline' class='img-thumbnail' width='600'>" +
                    "<br><br>" +
                    "<div class='row'>" + "<div class='col-2'>" +

                    "<form action='" + routedelete + "' method='post'>" +
                    '@csrf' +
                    '@method('delete')' +
                    "<button type='submit'class='btn btn-sm btn-danger' title='Delete feature' onclick='return confirm(`Are you sure you want to delete this feature?`)'><i class='fa-solid fa-trash-can'></i></button>" +
                    "</form>" +
                    "</div>" +
                    "<div class='col-2'>" +
                    "<a href='" + routeedit +
                    "' class='btn btn-warning btn-sm' title='Edit polygon'><i class='fa-solid fa-pen-to-square'></i></i></a>" +
                    "</div>" +
                    "</div>";

                layer.on({
                    click: function(e) {
                        polygons.bindPopup(popup_content);
                    },
                });
            },

        });

        $.getJSON("{{ route('geojson.polygons') }}", function(data) {
            polygons.addData(data);
            map.addLayer(polygons);
        });

        // ===== LAYER KECAMATAN TEMBAKAU =====
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
                    '🏘️ Kec. ' + p.nama_kecamatan +
                    '</h6>' +
                    '<table style="width:100%; font-size:13px">' +
                    '<tr><td>Kabupaten</td><td>: <b>' + p.nama_kabupaten + '</b></td></tr>' +
                    '<tr><td>Produksi Tembakau</td><td>: <b>' + nilaiProduksi.toLocaleString('id-ID') +
                    ' Ton</b></td></tr>' +
                    '</table>' +
                    '</div>'
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

            var searchControl = new L.Control.Search({
                layer: kecamatans,
                propertyName: 'nama_kecamatan',
                marker: false,
                initial: false,
                zoom: 13,
                title: 'Cari Kecamatan',
                autoCollapse: true,
                autoType: false,
                minLength: 2,
                textPlaceholder: '🔍 Cari kecamatan...',
                textErr: 'Kecamatan tidak ditemukan',

                moveToLocation: function(latlng, title, map) {
                    map.setView(latlng, 13);

                    kecamatans.eachLayer(function(layer) {
                        if (layer.feature.properties.nama_kecamatan === title) {
                            layer.setStyle({
                                weight: 4,
                                color: '#333',
                                fillOpacity: 0.9
                            });

                            var p = layer.feature.properties;
                            var nilaiProduksi = parseFloat(p.produksi) || 0;
                            layer.bindPopup(
                                '<div style="min-width:200px">' +
                                '<h6 style="margin:0 0 8px 0; font-weight:bold; border-bottom:2px solid #ccc; padding-bottom:4px">' +
                                '🏘️ Kec. ' + p.nama_kecamatan +
                                '</h6>' +
                                '<table style="width:100%; font-size:13px">' +
                                '<tr><td>Kabupaten</td><td>: <b>' + p.nama_kabupaten +
                                '</b></td></tr>' +
                                '<tr><td>Produksi Tembakau</td><td>: <b>' + nilaiProduksi
                                .toLocaleString('id-ID') + ' Ton</b></td></tr>' +
                                '</table>' +
                                '</div>'
                            ).openPopup();

                            setTimeout(function() {
                                kecamatans.resetStyle(layer);
                            }, 3000);
                        }
                    });
                }
            });

            map.addControl(searchControl);
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
        // Control Layer
        var baseMaps = {

        };

        var overlayMaps = {
            "🌿 Kecamatan Tembakau": kecamatans,
            "Points": points,
            "Polygons": polygons,
        };

        var controllayer = L.control.layers(baseMaps, overlayMaps);
        controllayer.addTo(map);

        // ===== ROUTING =====
        var routeLayer = null;
        var userMarker = null;
        var userLat = null;
        var userLng = null;

        // Marker posisi user
        var userIcon = L.divIcon({
            html: `<div style="
        width: 20px;
        height: 20px;
        background: #1565c0;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 4px rgba(21,101,192,0.3);
    "></div>`,
            className: '',
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        // Ambil lokasi user
        function ambilLokasi(callback) {
            if (!navigator.geolocation) {
                alert('Browser tidak mendukung GPS');
                return;
            }
            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    userLat = pos.coords.latitude;
                    userLng = pos.coords.longitude;

                    if (userMarker) map.removeLayer(userMarker);
                    userMarker = L.marker([userLat, userLng], {
                            icon: userIcon
                        })
                        .addTo(map)
                        .bindPopup('📍 Lokasi Anda')
                        .openPopup();

                    if (callback) callback(userLat, userLng);
                },
                function(err) {
                    alert('Tidak bisa ambil lokasi: ' + err.message);
                }, {
                    enableHighAccuracy: true
                }
            );
        }

        // Buat rute dari user ke tujuan
        function buatRute(destLat, destLng, namaGudang) {
            ambilLokasi(function(lat, lng) {
                // Hapus rute lama
                if (routeLayer) map.removeLayer(routeLayer);

                // OSRM routing API (gratis, tanpa API key)
                var url = 'https://router.project-osrm.org/route/v1/driving/' +
                    lng + ',' + lat + ';' +
                    destLng + ',' + destLat +
                    '?overview=full&geometries=geojson';

                fetch(url)
                    .then(r => r.json())
                    .then(data => {
                        if (data.code !== 'Ok') {
                            alert('Rute tidak ditemukan');
                            return;
                        }

                        var route = data.routes[0];
                        var jarak = (route.distance / 1000).toFixed(1);
                        var waktu = Math.round(route.duration / 60);

                        // Tampilkan rute di peta
                        routeLayer = L.geoJSON(route.geometry, {
                            style: {
                                color: '#1565c0',
                                weight: 5,
                                opacity: 0.8,
                                dashArray: null
                            }
                        }).addTo(map);

                        // Fit peta ke rute
                        map.fitBounds(routeLayer.getBounds(), {
                            padding: [50, 50]
                        });

                        // Tampilkan panel info
                        document.getElementById('namaGudang').textContent = namaGudang;
                        document.getElementById('jarakRute').textContent = jarak;
                        document.getElementById('waktuRute').textContent = waktu;
                        document.getElementById('routingPanel').style.display = 'block';
                    })
                    .catch(function() {
                        alert('Gagal mengambil rute. Cek koneksi internet.');
                    });
            });
        }

        // Tutup rute
        function tutupRute() {
            if (routeLayer) {
                map.removeLayer(routeLayer);
                routeLayer = null;
            }
            document.getElementById('routingPanel').style.display = 'none';
        }
    </script>
@endsection
