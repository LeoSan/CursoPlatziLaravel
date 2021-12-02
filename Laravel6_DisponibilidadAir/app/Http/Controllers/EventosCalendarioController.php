<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventosCalendarioController extends Controller
{
    public function index(Request $request) {
        return view('calendario.index');
    }
}
