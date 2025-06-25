<?php

namespace App\Http\Controllers;
use App\Models\Point; // tambahkan ini di bagian atas jika belum


use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home',
        ];

        return view('home', $data);
    }


}
