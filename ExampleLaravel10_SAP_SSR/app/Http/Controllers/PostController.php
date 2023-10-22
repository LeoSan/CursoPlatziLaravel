<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Response};

class PostController extends Controller
{
    
    private $message_error = "Error en la petición";
    private $message_success = "Proceso exitoso.";

    /**
     * Display a listing of the resource.
     */
    public function showPost()
    {
        //
        $parametros = [];
        return view('post.form', compact('parametros'));
    }
    /**
     * Display a listing of the resource.
     */
    public function showPostAjax()
    {
        //
        $parametros = [];
        return view('post.formAjax', compact('parametros'));
    }

    /**
     * Almacenamiento Normal 
     */
    public function storePost(Request $request)
    {
        $is_create = Post::create([
            'nombre'=> $request->input('nombre'),
            'descripcion'=> $request->input('descripcion'),
            'estatus'=> true,
        ]);
        if ($is_create){
             $tipo_mensaje = 'success';    
             $mensaje = "Se realizó alta de la denuncia de manera correcta.";    
        }else{
            $tipo_mensaje = 'error';    
            $mensaje = "Ocurrio un problema vuelva intentarlo.";    
        }
        //Redirect a bandeja
        return redirect()->route('form.post')->with($tipo_mensaje, $mensaje);

    }
    /**
     * Almacenamiento con Ajax .
     */
    public function storePostAjax(Request $request)
    {
        if (!$request->ajax()) {
            return Response::json([
                'message' => $this->message_error,
                'error' =>  'Error Ajax',
            ], 203);
        }
        try {
            //Inserto valores
            $is_create = Post::create([
                'nombre'=> $request->input('nombre'),
                'descripcion'=> $request->input('descripcion'),
                'estatus'=> true,
            ]);
            
            //envio respuesta al JS 
            if (!$is_create){
                return Response::json([
                    'message'   => $this->message_error,
                    'estatus'   =>  203,//bad
                ], 203);
            }else{
                return Response::json([
                    'message' => $this->message_success,
                    'id'   => $is_create->id ,
                    'estatus'   =>  201,//Good
                ], 201);
            }
        }catch(\Exception $e) {
            $error_exception = "Error try exception";
            return Response::json([
                'message' => $this->message_error,
                'estatus'   =>  203,//bad
            ], 203);
        }
    }

}
