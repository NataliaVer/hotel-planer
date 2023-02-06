<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function upload_foto(Request $request) {
        $file = $request->hasFile('photo');
        if ($file) {
            $newFile = $request->file('photo');
            $file_path = $newFile->store('images');
        }
    }
}
