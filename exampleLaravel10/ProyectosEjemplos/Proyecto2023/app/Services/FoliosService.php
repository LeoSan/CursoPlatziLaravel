<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use function now;

class FoliosService
{
    public function generarfolio($tipo){
        $anio = now()->year;
        $folioAnterior = \App\Models\Folio::where('anio',$anio)
            ->where('tipo',$tipo)
            ->orderBy('id','desc')->first();

        if($folioAnterior){
            $newFolio = $folioAnterior->numero + 1;
        }else
            $newFolio = 1;

        switch (strlen($newFolio)){
            case 1:
                $folio='0000'.$newFolio.'-'.$anio;
                break;
            case 2:
                $folio='000'.$newFolio.'-'.$anio;
                break;
            case 3:
                $folio='00'.$newFolio.'-'.$anio;
                break;
            case 4:
                $folio='0'.$newFolio.'-'.$anio;
                break;
            case 5:
                $folio=$newFolio.'-'.$anio;
                break;
        }
        DB::beginTransaction();
        $consecutivo = \App\Models\Folio::where('anio',$anio)
            ->where('tipo',$tipo)
            ->orderBy('id','desc')->first();

        if($consecutivo)
            $consecutivo->update([
                'numero' => $newFolio,
                'anio' => $anio,
                'folio' => $folio,
            ]);
        else
            $consecutivo = \App\Models\Folio::create([
                'numero' => $newFolio,
                'anio' => $anio,
                'tipo'  => $tipo,
                'folio' => $folio
            ]);
        DB::commit();
        return $consecutivo->folio;

    }


    /**
     * Metodo: Peermite generar y consultar un consecutivo para luego generar un folio para ATI
     *
     * @param  mixed $anio  -> Indica el anio para generar folios consecutivos de ese año
     * @param  mixed $tipo  -> Valor definido por las reglas de negocio puede ser cualquier sigla para generar el folio pero para este caso es para ATI
     * @param  mixed $opera -> indica el tipo de operación, si es Solo Lectura o Acceso a ser modificado
     * @return string
     */
    public function generaConsecutivo(int $anio, string $tipo, string $opera): string {

        $is_consecutivo = \App\Models\Folio::where('anio',$anio)->where('tipo',$tipo)->orderBy('id','desc')->first();

        if($is_consecutivo){
            $consecutivo = $is_consecutivo->numero + 1;
        }else
            $consecutivo = 1;


        if ($opera=='RAM'){
            DB::beginTransaction();
                if($is_consecutivo)
                    $is_consecutivo->update(['numero' => $consecutivo,'anio' => $anio,'folio' => $consecutivo]);
                else
                    \App\Models\Folio::create(['numero' => $consecutivo,'anio' => $anio,'tipo'  => $tipo,'folio' => $consecutivo]);
            DB::commit();
        }

        return $consecutivo;
    }
}
