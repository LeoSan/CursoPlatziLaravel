<?php

namespace App\Http\Controllers;

use Inertia\Inertia; 
use App\Models\Grafica;
use Illuminate\Http\Request;
use app\Charts\MonthlyUsersChart;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;



class GraficaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

/*        $chart = (new LarapexChart)->setType('area')
        ->setTitle('Total Users Monthly')
        ->setSubtitle('From January to March')
        ->setXAxis([
            'Jan', 'Feb', 'Mar'
        ])
        ->setDataset([
            [
                'name'  =>  'Active Users',
                'data'  =>  [250, 700, 1200]
            ]
        ]);
*/
        //Nota: Esto hace referencia a Page-> \resources\js\Pages\Dashboard.vue
        return Inertia::render('Graficas/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grafica  $grafica
     * @return \Illuminate\Http\Response
     */
    public function show(Grafica $grafica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grafica  $grafica
     * @return \Illuminate\Http\Response
     */
    public function edit(Grafica $grafica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grafica  $grafica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grafica $grafica)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grafica  $grafica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grafica $grafica)
    {
        //
    }
}
