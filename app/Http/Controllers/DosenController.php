<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    function index(){
        return view ('dashboard.dosen');
      }
}
