<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function home() {
        return view('home');
    }

    public function apiDocument() {
      $file_name = 'api_pdf.pdf';
      $pathToFile = '/storage/document/'.$file_name;
      $temp_file_location = public_path('/storage/document/' . $file_name);
      return response()->file($temp_file_location);
    }
}
