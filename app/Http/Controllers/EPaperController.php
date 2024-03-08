<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EPaperController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // validasi file
        ]);

        $directory = 'uploads/' . now()->format('Y-m-d');

        // Simpan file ke direktori penyimpanan
        $path = $request->file('file')->storeAs($directory, '1.pdf');

        // Lakukan sesuatu dengan path file, misalnya simpan ke basis data

        return "File berhasil diunggah";
    }
}
