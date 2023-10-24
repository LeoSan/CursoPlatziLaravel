<?php

namespace App\Http\Controllers;

use App\Models\{Bitacora};
use Illuminate\Http\Request;


class BitacoraController extends Controller
{

    /**
     * Description: Metodo que permite generar la vista de bitacora
     *
     * @param type int $id
     * @param type Request $request
     * @return type view -> Bitacora
     */
    public function index(Request $request)
    {

        //Registro movimiento
        $this->registroMovimiento($request);
        //Migas de Pan
        $itemsbread = [
            ['nombreComponente' => 'Usuarios',   'ruta'=> '/admin/usuarios', 'value'=>'null'  ],
            ['nombreComponente' => 'Bitácora',   'ruta'=> '#'         , 'value'=>'active' ]
        ];
        //Vista
		return view('bitacora.index', compact('itemsbread'));
    }

    /**
     * Metodo: Permite registrar valores en la tabla bitacora usando helpers
     *
     * @param  mixed $request
     * @return void
     */
    public function registroMovimiento(Request $request )
    {
        registroBitacora(null,A_CONSULTAR,C_BITACORA,null,"Consultó la bitácora",$request->except('_token'));
    }
}
