<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class CuentaController extends Controller
{
    public function password()
    {
        return view('cuenta.password');
    }
    public function actualizarPassword(Request $request){
        //dd($request->all());
         $rules = [
            'password_actual' => 'required',
                'password' => 'required|confirmed|min:6'
        ];
        $messages = [
            'password_actual.required' => 'Favor de llenar el campo Contraseña actual.',
                'password.required' => 'Favor de llenar el campo Contraseña.',
                'password.confirmed' => 'Las contraseñas no coinciden.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        $user = User::whereId(auth()->user()->id)->first();
        if(!\Hash::check($request->password_actual, $user->password)){
            return redirect()->back()
                ->withErrors('La contraseña actual es incorrecta');
        }
         User::where('id',$user->id)->update([
                'password'=> bcrypt($request->password)
            ]);
        return redirect()->back()
                ->with('success', 'La contraseña se actualizó con éxito.');
        
    }
}
