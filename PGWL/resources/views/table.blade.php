@extends('layouts.template')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.css">
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #f5f0e8;
    }

    .page-wrapper {
        padding: 24px;
    }

    /* Chart */
    .chart-container {
        background: white;
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(45,90,39,0.12);
        border: 1px solid #dcedc8;
        margin-bottom: 24px;
    }

    .chart-title {
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 16px;
        color: #2d5a27;
    }

    /* Card Tabel */
    .tabel-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(45,90,39,0.12);
        border: 1px solid #dcedc8;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .tabel-card-header {
        background: linear-gradient(135deg, #2d5a27, #4a8c3f);
        color: white;
        padding: 14px 20px;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .tabel-card-body {
        padding: 20px;
    }

    /* DataTable override */
    table.dataTable thead th {
        background: #e8f5e1 !important;
        color: #2d5a27 !important;
        font-weight: 700 !important;
        border-bottom: 2px solid #a5d6a7 !important;
    }

    table.dataTable tbody tr:hover {
        background-color: #f1f8e9 !important;
    }

    table.dataTable tbody tr:nth-child(even) {
        background-color: #f9fdf7;
    }

    table.dataTable {
        border-radius: 8px;
        overflow: hidden;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #2d5a27 !important;
        color: white !important;
        border-radius: 6px !important;
        border: none !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #4a8c3f !important;
        color: white !important;
        border-radius: 6px !important;
        border: none !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1.5px solid #a5d6a7;
        border-radius: 8px;
        padding: 4px 10px;
        outline: none;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #2d5a27;
        box-shadow: 0 0 0 2px rgba(45,90,39,0.15);
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1.5px solid #a5d6a7;
        border-radius: 8px;
        padding: 4px 8px;
    }

    img.foto-tabel {
        border-radius: 8px;
        border: 2px solid #c8e6c9;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
<div class="page-wrapper">

    {{-- Chart --}}
    <div class="chart-container">
        <div class="chart-title">🌿 Grafik Produksi Tembakau Per Kecamatan (Ton)</div>
        <canvas id="chartProduksi" height="80"></canvas>
    </div>

    {{-- Tabel Point --}}
    <div class="tabel-card">
        <div class="tabel-card-header">
            📍 Tabel Data Point
        </div>
        <div class="tabel-card-body">
            <table class="table table-bordered" id="tabledatapoints" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Foto</th>
                        <th>Tanggal Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($points as $p)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $p['name'] }}</td>
                        <td>{{ $p['description'] }}</td>
                        <td>
                            <img src="{{ asset('storage/images') . '/' . $p['image'] }}"
                                alt="" width="100" class="foto-tabel">
                        </td>
                        <td>{{ $p['created_at'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tabel Polygon --}}
    <div class="tabel-card">
        <div class="tabel-card-header">
            🔷 Tabel Data Polygon
        </div>
        <div class="tabel-card-body">
            <table class="table table-bordered" id="tabledatapolygons" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Foto</th>
                        <th>Tanggal Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($polygons as $p)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $p['name'] }}</td>
                        <td>{{ $p['description'] }}</td>
                        <td>
                            <img src="{{ asset('storage/images') . '/' . $p['image'] }}"
                                alt="" width="100" class="foto-tabel">
                        </td>
                        <td>{{ $p['created_at'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
<script>
    new DataTable('#tabledatapoints');
    new DataTable('#tabledatapolygons');

    $.getJSON("{{ route('geojson.kecamatans') }}", function(data) {
        var labels = [];
        var values = [];
        var colors = [];

        var features = data.features.sort(function(a, b) {
            return b.properties.produksi - a.properties.produksi;
        });

        features.forEach(function(f) {
            var nama = f.properties.nama_kecamatan;
            var produksi = parseFloat(f.properties.produksi) || 0;
            labels.push(nama);
            values.push(produksi);

            var warna =
                produksi > 800 ? '#006400' :
                produksi > 600 ? '#38a800' :
                produksi > 400 ? '#79c900' :
                produksi > 200 ? '#ffff00' :
                produksi > 100 ? '#ffaa00' :
                produksi > 50  ? '#ff5500' :
                produksi > 0   ? '#ff0000' :
                                 '#cccccc';
            colors.push(warna);
        });

        var ctx = document.getElementById('chartProduksi').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Produksi Tembakau (Ton)',
                    data: values,
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Produksi: ' + context.parsed.y.toLocaleString('id-ID') + ' Ton';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Produksi (Ton)', font: { size: 13 } }
                    },
                    x: {
                        title: { display: true, text: 'Kecamatan', font: { size: 13 } },
                        ticks: { maxRotation: 45, minRotation: 45 }
                    }
                }
            }
        });
    });
</script>
@endsection
