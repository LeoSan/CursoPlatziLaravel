<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CasosExport implements WithHeadings, FromArray, ShouldAutoSize
{
    protected $registros;
    protected $encabezados;

    public function __construct(array $datos)
    {
        $this->encabezados = ['Número de expediente SETRASS','Número de expediente PGR','Razón social','Fecha de notificación','Fecha de ingreso a DNPJ', 'Monto a cobrar (L)','Monto cobrado (L)','Monto cobrado con intereses (L)','Asignado a','Inspector','Estatus'];
        $this->registros = $datos;
    }

    public function headings(): array
    {
        return $this->encabezados;
    }


    public function array(): array
    {
        return $this->registros;
    }
}
