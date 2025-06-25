<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class PointsController extends Controller
{
    protected $points;

    public function __construct()
    {
        $this->points = new PointsModel();
    }


    public function index()
    {
        $data = [
            'title' => 'Map',
            // 'points' => $this->points->all()
        ];
        return view('map', $data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //Validation request
        $request->validate(
            [
                'name' => 'required|unique:points_tables,name',
                'description' => 'required',
                'tipe' => 'required',
                'geom_point' => 'required',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:4048',
            ],
            [
                'name.required' => 'Name is required',
                'name.unique' => 'Name already exists',

                'description.required' => 'Description is required',
                'geom_point.required' => 'Location is required',
            ]

        );

        // Create image directory if not exists
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // Get image file
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        // Get data from bootstrap form
        $data = [
            'geom' => $request->geom_point,
            'name' => $request->name,
            'description' => $request->description,
            'tipe' => $request->tipe,
            'image' => $name_image,
            'user_id' => auth()->user()->id,
        ];

        //dd($data); //ini cuma ngecek dlm bentuk teks data geojson

        // create Data
        if (!$this->points->create($data)) {
            return redirect()->route('map')->with('error', 'Failed to add point');
        }

        // Redirect to map
        return redirect()->route('map')->with('success', 'Point has been added');
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Point',
            'id' => $id,
        ];

        return view('edit-point', $data);
    }



    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => 'required|unique:points_tables,name,' . $id,
                'description' => 'required',
                'tipe' => 'required',
                'geom_point' => 'required',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:4048',
            ],
            [
                'name.required' => 'Name is required',
                'name.unique' => 'Name already exists',
                'description.required' => 'Description is required',
                'geom_point.required' => 'Location is required',
            ]
        );

        // Pastikan direktori penyimpanan gambar ada
        if (!is_dir('storage/images')) {
            mkdir('storage/images', 0777, true);
        }


        // $point = $this->points->find($id);
        // $old_image = $point->image;

        $old_image = $this->points->find($id)->image;
        // Handle upload image baru
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);

            if ($old_image != null) {
                // Hapus gambar lama jika ada
                if (file_exists('storage/images/' . $old_image)) {
                    unlink('storage/images/' . $old_image);
                }
            }
        } else {
            // Tidak upload gambar baru, gunakan gambar lama
            $name_image = $old_image;
        }
        $data = [
            'geom' => $request->geom_point,
            'name' => $request->name,
            'description' => $request->description,
            'tipe' => $request->tipe,
            'image' => $name_image,
        ];

        if (!$this->points->find($id)->update($data)) {
            return redirect()->route('map')->with('error', 'Failed to update point');
        }

        // if (!$point->update($data)) {
        //     return redirect()->route('map')->with('error', 'Failed to update point');
        // }

        return redirect()->route('map')->with('success', 'Point has been updated');
    }


    public function destroy(string $id)
    {
        $imagefile = $this->points->find($id)->image;

        if (!$this->points->destroy($id)) {
            return redirect()->route('map')->with('error', 'Failed to delete point');
        }

        // Delete image file if exists
        if ($imagefile != null) {
            if (file_exists('storage/images/' . $imagefile)) {
                unlink('storage/images/' . $imagefile);
            }
        }

        return redirect()->route('map')->with('success', 'Point has been deleted');
    }


    public function table()
    {
        $data = [
            'title' => 'Points Table',
            'points' => $this->points->all()
        ];
        return view('table', $data);
    }
}
