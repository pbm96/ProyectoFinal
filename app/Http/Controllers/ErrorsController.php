<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorsController extends Controller
{
    public function error_403(){

        return view('errores.error-403');

    }
    public function error_404(){

        return view('errores.error-404');

    }
}
