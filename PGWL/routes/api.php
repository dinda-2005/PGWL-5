<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//GEOJSON API
Route::get('/points', [ApiController::class, 'geojson_points'])
->name('geojson.points');

Route::get('/point/{id}', [ApiController::class, 'geojson_point'])
->name('geojson.point');

Route::get('/polygons', [ApiController::class, 'geojson_polygons'])
->name('geojson.polygons');

Route::get('/polygon/{id}', [ApiController::class, 'geojson_polygon'])
->name('geojson.polygon');

Route::get('/kecamatans', [ApiController::class, 'geojson_kecamatans'])
    ->name('geojson.kecamatans');
