<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function upload(Request $request){

        //Valido usando  request
        $request->validate(['photo'=>'required'], ['photo.required'=>'Debes subir una foto']);

        $file = $request->file('photo');
        $file?->store('profiles');
        return redirect('profile');
    }
}
