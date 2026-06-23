<?php

namespace App\Http\Controllers;

use App\Models\KecamatanModel;
use App\Models\pointsModel;
use App\Models\polygonsModel;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->points = new pointsModel();
        $this->polygons = new polygonsModel();
        $this->kecamatans = new KecamatanModel();
    }

    public function geojson_points()
    {
        $points = $this->points->geojson_points();
        return response()->json($points, 200, [], JSON_NUMERIC_CHECK);
    }

    public function geojson_point($id)
    {
        $points = $this->points->geojson_point($id);
        return response()->json($points, 200, [], JSON_NUMERIC_CHECK);
    }

    public function geojson_polygons()
    {
        $polygons = $this->polygons->geojson_polygons();
        return response()->json($polygons, 200, [], JSON_NUMERIC_CHECK);
    }

    public function geojson_polygon($id)
    {
        $polygons = $this->polygons->geojson_polygon($id);
        return response()->json($polygons, 200, [], JSON_NUMERIC_CHECK);
    }
    public function geojson_kecamatans()
    {
        $data = $this->kecamatans->geojson_kecamatans();
        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }
}
