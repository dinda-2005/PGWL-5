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
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'geometry_polygon.required' => 'Field geometry polygon harus diisi.',
                'name.required' => 'Field name harus diisi.',
                'name.string' => 'Field name harus berupa string.',
                'name.max' => 'Field name tidak boleh lebih dari 255 karakter.',
                'description.string' => 'Field description harus berupa string.',
                'image.image' => 'Field harus berupa gambar.',
                'image.mimes' => 'Field gambar harus berformat jpeg,png,jpg.',
                'image.max' => 'Ukuran field gambar tidak boleh lebih dari 2 MB.'
            ]
        );

        // Create directory jika belum ada
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777, true);
        }

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geometry_polygon,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        if ($this->polygons->create($data)) {
            return redirect()->route('peta')->with('success', 'Data polygon berhasil disimpan.');
        }

        return redirect()->route('peta')->with('error', 'Gagal menyimpan data polygon.');
    }
    public function destroy(string $id)
    {
        // Mencari nama file gambar berdasarkan id
    $polygons = $this->polygons->find($id);
    $imagefile = $polygons ? $polygons->image : null;

    //Hapus file gambar jika ada
    if($imagefile != null){
        if (file_exists('./storage/images/' . $imagefile)) {
            unlink('./storage/images/'. $imagefile);
        }
    }

    // Hapus data dari database
    if (!$this->polygons->destroy($id)) {
        return redirect()->route('peta')
            ->with('error', 'Gagal menghapus data polygons.');
    }
    // Kembali ke halaman peta
    return redirect()->route('peta')
        ->with('success', 'Data polygons berhasil dihapus.');
    }
}
