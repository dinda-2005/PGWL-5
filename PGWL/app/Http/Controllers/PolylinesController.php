<?php

namespace App\Http\Controllers;


use App\Models\polylinesModel;
use Illuminate\Http\Request;

class PolylinesController extends Controller
{
    public function __construct()
    {
        $this->polylines = new polylinesModel();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validasi input
    $request->validate(
            [
                'geometry_polyline' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jng|max:2028',
            ],
            [
                'geometry_polyline.required' => 'Field geometry polyline harus diisi.',
                'name.required' => 'Field name harus diisi.',
                'name.string' => 'Field name harus berupa string.',
                'name.max' => 'Field name tidak boleh lebih dari 255 karakter.',
                'description.string' => 'Field description harus berupa string.',
                'image.image' => 'Field  harus berupa gambar.',
                'image.mimes' => 'Field gambar harus berformat jpeg, png, jpg.',
                'image.max' => 'Ukuran field gambar tidak boleh lebih dari 2MB.',
            ]
        );

        #Create directory for images if it doesn't exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
            }

        #Get the uploaded image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
            } else {
                $name_image = null;
                }

        $data = [
            'geom' => $request->geometry_polyline,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // simpan data ke database
       if ($this->polylines->create($data)) {
    return redirect()->route('peta')->with('success', 'Data polyline berhasil disimpan.');
}

        //Kembali ke halaman peta
        return redirect()->route('peta')->with('error', 'Gagal menyimpan data polyline.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $polyline = $this->polylines->find($id);

    $data = [
        'title' => 'Edit Polyline',
        'id' => $id,
        'polyline' => $polyline,
    ];

    return view('map-edit-polyline', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate(
        [
            'geometry' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jng|max:2028',
        ],
        [
            'geometry_point.required' => 'Field geometry point harus diisi.',
            'name.required' => 'Field name harus diisi.',
            'name.string' => 'Field name harus berupa string.',
            'name.max' => 'Field name tidak boleh lebih dari 255 karakter.',
            'description.string' => 'Field description harus berupa string.',
            'image.image' => 'Field  harus berupa gambar.',
            'image.mimes' => 'Field gambar harus berformat jpeg,png,jng.',
            'image.max' => 'Ukuran field gambar tidak boleh lebih dari 2 MB.',
        ]
    );

    //Create directory for image if it dosen't exit
    if (!is_dir('storage/images')) {
        mkdir('./storage/images', 0777);
    }

    $image_old = $this->polylines->find($id)->image;

    // Cek apakah ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);

            //Hapus file gambar jika ada
        if ($image_old != null) {
            // Cek apakah file gambar ada sebelum menghapus
            if (file_exists('storage/images/' . $image_old)) {
                // Hapus file gambar dari direktori
                unlink('storage/images/' . $image_old);
            }
        }
        } else {
            $name_image = $image_old;
        }

        $data = [
            'name' => $request->name,
            'geom' => $request->geometry,
            'description' => $request->description,
            'image' => $name_image
        ];

        // simpan data ke database
        if ($this->polylines->create($data)) {
    return redirect()->route('peta')->with('success', 'Data polyline berhasil disimpan.');
}

        //Kembali ke halaman peta
        return redirect()->route('peta')->with('success', 'Data polyline berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mencari nama file gambar berdasarkan id
    $polylines = $this->polylines->find($id);
    $imagefile = $polylines ? $polylines->image : null;

    //Hapus file gambar jika ada
    if($imagefile != null){
        if (file_exists('./storage/images/' . $imagefile)) {
            unlink('./storage/images/'. $imagefile);
        }
    }

    // Hapus data dari database
    if (!$this->polylines->destroy($id)) {
        return redirect()->route('peta')
            ->with('error', 'Gagal menghapus data polylines.');
    }
    // Kembali ke halaman peta
    return redirect()->route('peta')
        ->with('success', 'Data polylines berhasil dihapus.');
    }
}
