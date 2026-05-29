<?php

namespace App\Http\Controllers;

use App\Models\pointsModel;
use Illuminate\Http\Request;

class PointsController extends Controller
{
    public function __construct()
    {
        $this->points = new pointsModel();
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
                'geometry_point' => 'required',
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

        //Get the upload image, menagkap dengan konsisi ketika imahe hasfile nama diambil dari name image yang ada di map.blade.php, jika input nama image ada file maka aakan memproses membuat variabel image untuk mewakili dan menampung file image nama image dengan nama time yang detik semua,(_point)untuk mendefiniiskan punya point, strtolower extention nama konsisten huruf kecil semua.
        //image-move pindah ke folder storege image dengan mana image, els imput image nggak ada maka name image null
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
            } else {
                $name_image = null;
                }

        $data = [
            'geom' => $request->geometry_point,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // simpan data ke database
        if ($this->points->create($data)) {
    return redirect()->route('peta')->with('success', 'Data point berhasil disimpan.');
}

        //Kembali ke halaman peta
        return redirect()->route('peta')->with('error', 'Gagal menyimpan data point.');
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
        $data=[
            'title' => 'Edit Point',
            'id' => $id,
        ];

        return view('map-edit-point', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Validasi input
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

        $image_old = $this->points->find($id)->image;


        //Get the upload image, menagkap dengan konsisi ketika imahe hasfile nama diambil dari name image yang ada di map.blade.php, jika input nama image ada file maka aakan memproses membuat variabel image untuk mewakili dan menampung file image nama image dengan nama time yang detik semua,(_point)untuk mendefiniiskan punya point, strtolower extention nama konsisten huruf kecil semua.
        //image-move pindah ke folder storege image dengan mana image, els imput image nggak ada maka name image null
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);

            //Hapus file gambar jika ada
        if($image_old != null){
        //cek apakah file gambar ada sebelum
        if (file_exists('./storage/images/' . $image_old)) {
            unlink('./storage/images/'. $image_old);
        }
    }

            } else {
                $name_image = $image_old;
                }

        $data = [
            'geom' => $request->geometry,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // simpan data ke database
        if ($this->points->find($id)->update($data)) {
    return redirect()->route('peta')->with('success', 'Data point berhasil memperbaharui.');
}

        //Kembali ke halaman peta
        return redirect()->route('peta')->with('error', 'Gagal memperbaharui data point.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    // Mencari nama file gambar berdasarkan id
    $point = $this->points->find($id);
    $imagefile = $point ? $point->image : null;

    //Hapus file gambar jika ada
    if($imagefile != null){
        if (file_exists('./storage/images/' . $imagefile)) {
            unlink('./storage/images/'. $imagefile);
        }
    }

    // Hapus data dari database
    if (!$this->points->destroy($id)) {
        return redirect()->route('peta')
            ->with('error', 'Gagal menghapus data point.');
    }
    // Kembali ke halaman peta
    return redirect()->route('peta')
        ->with('success', 'Data point berhasil dihapus.');

}
}
