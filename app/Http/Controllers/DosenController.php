<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    function dashboard(){
        return view ('Dosen.Dashboard');
      }
}
