<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KecamatanModel extends Model
{
    protected $table = 'kecamatans';
    protected $guarded = ['id'];

    public function geojson_kecamatans()
    {
        $rows = DB::table('kecamatans')
            ->select(DB::raw('
                ogc_fid as id,
                ST_AsGeoJSON(wkb_geometry) as geojson,
                wadmkc as nama_kecamatan,
                wadmkk as nama_kabupaten,
                produksi as produksi
            '))
            ->get();

        $geojson = ['type' => 'FeatureCollection', 'features' => []];

        foreach ($rows as $r) {
    $produksi_angka = floatval(
        str_replace(',', '.', str_replace('.', '', $r->produksi))
    );

    $geojson['features'][] = [
        'type'     => 'Feature',
        'geometry' => json_decode($r->geojson),
        'properties' => [
            'id'             => $r->id,
            'nama_kecamatan' => $r->nama_kecamatan,
            'nama_kabupaten' => $r->nama_kabupaten,
            'produksi'       => $produksi_angka,
        ]
    ];
}

        return $geojson;
    }
}
