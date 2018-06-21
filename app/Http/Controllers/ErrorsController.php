<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorsController extends Controller
{
    /**
     * vista de error 403
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function error_403(){

        return view('errores.error-403');

    }

    /**
     * vista error 404
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function error_404(){

        return view('errores.error-404');

    }
    /**
     * vista error 405
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function error_405(){

        return view('errores.error-405');

    }

    /**
     * vista error 405
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function error_500(){

        return view('errores.error-500');

    }
}
