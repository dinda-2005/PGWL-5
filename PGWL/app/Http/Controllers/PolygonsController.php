<?php

namespace App\Http\Controllers;

use App\Models\PolygonsModel;
use Illuminate\Http\Request;

class PolygonsController extends Controller
{
    protected $polygons;

    public function __construct()
    {
        $this->polygons = new PolygonsModel();
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'geometry_polygon' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
            ]
        );

        $data = [
            'geom' => $request->geometry_polygon,
            'name' => $request->name,
            'description' => $request->description,
            'image' => 'default.png'
        ];

        if ($this->polygons->create($data)) {
            return redirect()->route('peta')->with('success', 'Data polygon berhasil disimpan.');
        }

        return redirect()->route('peta')->with('error', 'Gagal menyimpan data polygon.');
    }
}
