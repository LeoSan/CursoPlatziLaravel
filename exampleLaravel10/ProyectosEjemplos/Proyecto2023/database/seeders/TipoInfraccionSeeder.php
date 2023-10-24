<?php

namespace Database\Seeders;

use App\Models\TipoInfraccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoInfraccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 89. Daño económico cuantificable',
            'anio'=>'2017',
            'monto'=>floatVal('5000.00'),
            'editable'=>true
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 89. Daño económico cuantificable',
            'anio'=>'2018',
            'monto'=>floatVal('5211.00'),
            'editable'=>true
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 89. Daño económico cuantificable',
            'anio'=>'2019',
            'monto'=>floatVal('5423.61'),
            'editable'=>true
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 89. Daño económico cuantificable',
            'anio'=>'2020',
            'monto'=>floatVal('5641.10'),
            'editable'=>true
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 89. Daño económico cuantificable',
            'anio'=>'2021',
            'monto'=>floatVal('5941.20'),
            'editable'=>true
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Derechos fundamentales',
            'anio'=>'2017',
            'monto'=>floatVal('100000.00'),
            'editable'=>true
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Derechos fundamentales',
            'anio'=>'2018',
            'monto'=>floatVal('104220.00'),
            'editable'=>true
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Derechos fundamentales',
            'anio'=>'2019',
            'monto'=>floatVal('108472.18.'),
            'editable'=>true
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Derechos fundamentales',
            'anio'=>'2020',
            'monto'=>floatVal('112821.91'),
            'editable'=>true
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Derechos fundamentales',
            'anio'=>'2021',
            'monto'=>floatVal('118824.04'),
            'editable'=>true
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Libertad de asociación y sindical',
            'anio'=>'2017',
            'monto'=>floatVal('300000.00')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Libertad de asociación y sindical',
            'anio'=>'2018',
            'monto'=>floatVal('312660.00')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Libertad de asociación y sindical',
            'anio'=>'2019',
            'monto'=>floatVal('325416.53')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Libertad de asociación y sindical',
            'anio'=>'2020',
            'monto'=>floatVal('338465.73')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Libertad de asociación y sindical',
            'anio'=>'2021',
            'monto'=>floatVal('356472.11')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Obstrucción a la labor inspectora',
            'anio'=>'2017',
            'monto'=>floatVal('250000.00')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Obstrucción a la labor inspectora',
            'anio'=>'2018',
            'monto'=>floatVal('260550.00')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Obstrucción a la labor inspectora',
            'anio'=>'2019',
            'monto'=>floatVal('271180.44')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Obstrucción a la labor inspectora',
            'anio'=>'2020',
            'monto'=>floatVal('282054.78')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Obstrucción a la labor inspectora',
            'anio'=>'2021',
            'monto'=>floatVal('297060.09')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Obligación de celebrar un contrato colectivo',
            'anio'=>'2017',
            'monto'=>floatVal('200000.00')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Obligación de celebrar un contrato colectivo',
            'anio'=>'2018',
            'monto'=>floatVal('208440.00')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Obligación de celebrar un contrato colectivo',
            'anio'=>'2019',
            'monto'=>floatVal('216944.35')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Obligación de celebrar un contrato colectivo',
            'anio'=>'2020',
            'monto'=>floatVal('225643.82')
        ]);

        TipoInfraccion::updateOrCreate([
            'concepto'=>'Art. 90. Obligación de celebrar un contrato colectivo',
            'anio'=>'2021',
            'monto'=>floatVal('237648.07')
        ]);
    }
}
