@extends('layouts.template')

@section('styles')
<style>
    body {
        margin: 0;
        padding: 0;
    }
</style>
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #0f172a;
        color: white;
    }

    .card {
        background: #1e293b;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(255, 20, 147, 0.2);
        transition: 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 25px rgba(255, 20, 147, 0.7);
    }

    .card-header {
        background: linear-gradient(45deg, #ff1493, #ff69b4);
        color: white;
        font-weight: bold;
        border-bottom: none;
    }

    .card-header h3 {
        margin: 0;
    }

    .card-body {
        color: #e2e8f0;
    }

    h1 {
        font-size: 60px;
        font-weight: bold;
        color: #ff69b4;
        text-shadow: 0 0 10px #ff1493,
                     0 0 20px #ff1493,
                     0 0 40px #ff1493;
    }

    p {
        font-size: 16px;
        line-height: 1.7;
    }
</style>
@endsection

@section('content')
<div class="container mt-3">

<div class="card">
    <div class="card-header bg-pink text-white">
        <h3>Aplikasi Geospasial CRUD</h3>
    </div>

    <div class="card-body">
        <p>Aplikasi ini dibuat untuk memenuhi tugas mata kuliah Pemrograman Geospasial Website:Lanjut.Aplikasi menampilkan peta interaktif yang menunjukkan objek dengan geometri titik, garis, dan area yang dapat ditambah, ditampilkan, diubah, dan dihapus. Aplikasi ini dikembangkan dengan menggunakan Laravel dan PostegresSQL - PostGIS.</p>
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
                    <h3>Jumlah Polyline</h3>
                </div>
                <div class="card-body text-center">
                    <h1>
                        {{ $polylines_count }}
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
