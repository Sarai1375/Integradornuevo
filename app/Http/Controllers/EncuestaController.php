<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncuestaController extends Controller
{
    /**
     * Muestra la encuesta de satisfacción
     */
    public function index()
    {
        return view('cpanel.encuesta.index');
    }
}
