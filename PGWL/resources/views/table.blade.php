@extends('layouts.template')

@section('styles')
<style>
    body {
        margin: 0;
        padding: 0;
    }
</style>
@endsection

@section('content')
<div class="container mt-3">

<div class="card">
    <div class="card-header">
        <h3>Tabel Data</h3>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td>Alun-Alun Kidul</td>
                    <td>Jl. Alun-Alun Kidul, Yogyakarta</td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Malioboro Mall</td>
                    <td>Jl. Malioboro, Yogyakarta</td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Keraton Yogyakarta</td>
                    <td>Jl. Rotowijayan No.1, Yogyakarta</td>
                </tr>

                <tr>
                    <td>4</td>
                    <td>Taman Sari</td>
                    <td>Jl. Taman, Yogyakarta</td>
                </tr>

                <tr>
                    <td>5</td>
                    <td>Borobudur Cafe</td>
                    <td>Jl. Borobudur No.10, Yogyakarta</td>
                </tr>
            </tbody>

        </table>
    </div>
</div>
@endsection
