<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{ Catalogo, CatalogoElemento };

class CatalogoElementosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DEPENDENCIAS
        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Secretaría de Trabajo y Seguridad Social',
            'codigo'=>'setrass',
            'orden'=>1
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Procuraduría General de la República',
            'codigo'=>'pgr',
            'orden'=>2
        ]);

        //ESTATUS
        $catalogo = Catalogo::whereCodigo('estatus_pgr')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'En captura',
            'codigo' => 'captura',
            'orden' => 1
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'En revisión',
            'codigo' => 'revision',
            'orden' => 2
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Rechazado por el analista',
            'codigo' => 'rechazado_analista',
            'orden' => 3
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Pendiente',
            'codigo' => 'pendiente',
            'orden' => 4
        ]);

        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Turnado a coordinador',
            'codigo' => 'turnado_coordinador',
            'orden' => 5
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Rechazado por el coordinador',
            'codigo' => 'rechazado_coordinador',
            'orden' => 6
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Turnado a procurador',
            'codigo' => 'turnado_procurador',
            'orden' => 7
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Rechazado por el procurador',
            'codigo' => 'rechazado_procurador',
            'orden' => 8
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'En proceso',
            'codigo' => 'proceso',
            'orden' => 9
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Proceso de demanda',
            'codigo' => 'demanda',
            'orden' => 10
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Convenio de pago',
            'codigo' => 'convenio_pago',
            'orden' => 11
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Pago total',
            'codigo' => 'pago_total',
            'orden' => 12
        ]);

        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'No procedente',
            'codigo' => 'no_procedente',
            'orden' => 13
        ]);

         CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Información pendiente',
            'codigo' => 'informacion_pendiente',
            'orden' => 14
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Otro descargo',
            'codigo' => 'otro_descargo',
            'orden' => 15
        ]);

        //ESTATUS PLAN
        $catalogo = Catalogo::whereCodigo('estatus_plan_anual')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Planeacion',
            'codigo' => 'planeacion',
            'orden' => 1
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Registrado',
            'codigo' => 'registrado',
            'orden' => 2
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Vigente',
            'codigo' => 'vigente',
            'orden' => 3
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Histórico',
            'codigo' => 'historico',
            'orden' => 4
        ]);


        //ESTATUS AUDITORIAS
        $catalogo = Catalogo::whereCodigo('estatus_auditorias')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Pendiente',
            'codigo' => 'pendiente',
            'orden' => 1
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'En espera',
            'codigo' => 'espera',
            'orden' => 2
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Plazo vencido',
            'codigo' => 'plazo_vencido',
            'orden' => 3
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Incumplimiento',
            'codigo' => 'incumplimiento',
            'orden' => 4
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Expediente recibido',
            'codigo' => 'expediente_recibido',
            'orden' => 5
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Desestimada',
            'codigo' => 'desestimada',
            'orden' => 6
        ]);

        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'En proceso',
            'codigo' => 'proceso',
            'orden' => 7
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Elaboración de informe',
            'codigo' => 'elaboracion_informe',
            'orden' => 8
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Expediente recibido - sin información',
            'codigo' => 'expediente_recibido_sin_informacion',
            'orden' => 9
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Incumplimiento sin expediente',
            'codigo' => 'incumplimiento_sin_expediente',
            'orden' => 10
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre' => 'Finalizada',
            'codigo' => 'finalizada',
            'orden' => 11
        ]);


        // ACTIVIDADES ECONOMICAS
        $catalogo = Catalogo::whereCodigo('actividades_economicas')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Actividad económica 1',
            'codigo'=>'actividad_economica_1',
            'orden'=>1
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Actividad económica 2',
            'codigo'=>'actividad_economica_2',
            'orden'=>2
        ]);


        //TIPO DOCUMENTOS
        $catalogo = Catalogo::whereCodigo('documentos')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Ficha de averiguación previa',
            'codigo'=>'ficha_averiguacion',
            'orden'=>1
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Constancia de firmeza',
            'codigo'=>'constancia_firmeza',
            'orden'=>2
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Resolución certificada',
            'codigo'=>'resolucion_certificada',
            'orden'=>3
        ]);

        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Acuse de recibo',
            'codigo'=>'acuse_recibo',
            'orden'=>4
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Carátula del expediente',
            'codigo'=>'caratula_expediente',
            'orden'=>5
        ]);

        //Documentos para la Denuncia
        $catalogo = Catalogo::whereCodigo('documentos')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Documento de la denuncia',
            'codigo'=>'oficio_denuncia',
            'orden'=>6
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Documentos pruebas denuncia',
            'codigo'=>'pruebas_denuncia',
            'orden'=>7
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Documento de alta de la denuncia',
            'codigo'=>'alta_denuncia',
            'orden'=>8
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Documento providencia',
            'codigo'=>'providencia_denuncia',
            'orden'=>9
        ]);

        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Oficio de inadmisión',
            'codigo'=>'oficio_inadmision_denuncia',
            'orden'=>10
        ]);

        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Plan anual de auditorías',
            'codigo'=>'plan_anual_auditorias',
            'orden'=>11
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Respuesta a solicitud de expediente',
            'codigo'=>'respuesta_solicitud_expediente',
            'orden'=>12
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Informe de denuncia',
            'codigo'=>'informe_denuncia',
            'orden'=>13
        ]);


        //Documentos para la auditoria
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Cedula de trabajo firmada',
            'codigo'=>'auditoria_plantilla_firmada',
            'orden'=>17
        ]);

        $catalogo = Catalogo::whereCodigo('documentos')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Documentos de la respuesta a la providencia',
            'codigo'=>'pruebas_denuncia_resp_providencia',
            'orden'=>14
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Oficio para solicitar expediente',
            'codigo'=>'oficio_solicitar_expediente',
            'orden'=>15
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Documento oficio de desestimación',
            'codigo'=>'desistimiento_denuncia',
            'orden'=>16
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Auto de admisión de denuncia',
            'codigo'=>'auto_admision_denuncia',
            'orden'=>17
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Informe final',
            'codigo'=>'informe_final',
            'orden'=>18
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Acuse recibo',
            'codigo'=>'acuse_recibo_informe_final',
            'orden'=>19
        ]);

        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Oficio de orden de ejecución de auditoría',
            'codigo'=>'oficio_orden_ejecucion_auditoria',
            'orden'=>23
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Oficio de solicitud de información',
            'codigo'=>'oficio_solicitud_informacion_auditoria',
            'orden'=>24
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Acta de incumplimiento',
            'codigo'=>'acta_incumplimiento_auditoria',
            'orden'=>25
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Expediente de respuesta de solicitud',
            'codigo'=>'expediente_respuesta_solicitud',
            'orden'=>26
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Acta de inicio de auditoría',
            'codigo'=>'acta_inicio_auditoria',
            'orden'=>27
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Seguimiento de  recomendación',
            'codigo'=>'informe_seguimiento_recomendacion_auditoria',
            'orden'=>28
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Informe de resultados de seguimiento',
            'codigo'=>'informe_seguimiento_resultados_auditoria',
            'orden'=>29
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Cédula de hallazgos',
            'codigo'=>'cedula_hallazgos',
            'orden'=>30
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Informe de auditoría',
            'codigo'=>'informe_auditoria',
            'orden'=>31
        ]); 

        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Oficio',
            'codigo'=>'oficio_solicitud_prorroga_expedientes',
            'orden'=>32
        ]);

        $catalogo = Catalogo::whereCodigo('medio_recepcion')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'En línea',
            'codigo'=>'linea_recepcion',
            'orden'=>1
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Email',
            'codigo'=>'email_recepcion',
            'orden'=>2
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Presencial',
            'codigo'=>'presencial_recepcion',
            'orden'=>3
        ]);

        //departamentos

        $catalogo = Catalogo::whereCodigo('departamentos')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Atlántida','codigo'=>'atlantida','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Choluteca','codigo'=>'choluteca','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Colón','codigo'=>'colon','orden'=>3]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Comayagua','codigo'=>'comayagua','orden'=>4]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Copán','codigo'=>'copan','orden'=>5]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Cortés','codigo'=>'cortes','orden'=>6]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'El Paraíso','codigo'=>'el_paraiso','orden'=>7]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Francisco Morazán','codigo'=>'francisco_morazan','orden'=>8]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Gracias a Dios','codigo'=>'gracias_a_dios','orden'=>9]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Intibucá','codigo'=>'intibuca','orden'=>10]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Islas de la Bahía','codigo'=>'islas_de_la_bahia','orden'=>11]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'La Paz','codigo'=>'la_paz','orden'=>12]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Lempira','codigo'=>'lempira','orden'=>13]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Ocotepeque','codigo'=>'ocotepeque','orden'=>14]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Olancho','codigo'=>'olancho','orden'=>15]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Santa Bárbara','codigo'=>'santa_barbara','orden'=>16]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Valle','codigo'=>'valle','orden'=>17]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Yoro','codigo'=>'yoro','orden'=>18]);

        //regiones
        $catalogo = Catalogo::whereCodigo('regiones_setrass')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Ceiba','codigo'=>'reg_ceiba','descripcion'=>'CEI','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Choluteca','codigo'=>'reg_choluteca','descripcion'=>'CHO','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Comayagua','codigo'=>'reg_comayagua','descripcion'=>'COM','orden'=>3]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Danlí','codigo'=>'reg_danli','descripcion'=>'DAN','orden'=>4]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Distrito Central','codigo'=>'reg_distrito_central','descripcion'=>'DICE','orden'=>5]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'El progreso','codigo'=>'reg_el_progreso','descripcion'=>'PRO','orden'=>6]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Juticalpa','codigo'=>'reg_juticalpa','descripcion'=>'JUT','orden'=>7]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'La esperanza','codigo'=>'reg_la_esperanza','descripcion'=>'ESP','orden'=>8]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Olanchito','codigo'=>'reg_olanchito','descripcion'=>'OLAN','orden'=>9]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Puerto Cortes','codigo'=>'reg_puerto_cortes','descripcion'=>'PUCO','orden'=>10]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Puerto Lempira','codigo'=>'reg_puerto_lempira','descripcion'=>'PULE','orden'=>11]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Roatán','codigo'=>'reg_roatan','descripcion'=>'ROA','orden'=>12]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'San Pedro Sula','codigo'=>'reg_san_pedro_sula','descripcion'=>'SPS','orden'=>13]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Santa Barbara','codigo'=>'reg_santa_barbara','descripcion'=>'SABA','orden'=>14]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Santa Rosa de Copán','codigo'=>'reg_santa_rosa_de_copan','descripcion'=>'SRC','orden'=>15]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Tela','codigo'=>'reg_tela','descripcion'=>'TELA','orden'=>16]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Trujillo','codigo'=>'reg_trujillo','descripcion'=>'TRU','orden'=>17]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Villanueva','codigo'=>'reg_villanueva','descripcion'=>'VILL','orden'=>18]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Yoro','codigo'=>'reg_yoro','descripcion'=>'YORO','orden'=>19]);

        //municipios
        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('atlantida')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_tela')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Arizona','descripcion'=>'1','codigo'=>'0108','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_ceiba')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'El Porvenir','descripcion'=>'2','codigo'=>'0102','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_tela')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Esparta','descripcion'=>'3','codigo'=>'0103','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_ceiba')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Jutiapa','descripcion'=>'4','codigo'=>'0104','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_ceiba')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Ceiba','descripcion'=>'5','codigo'=>'0101','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_ceiba')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Masica','descripcion'=>'6','codigo'=>'0105','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_ceiba')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Francisco','descripcion'=>'7','codigo'=>'0106','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_tela')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Tela','descripcion'=>'8','codigo'=>'0107','orden'=>8]);
        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('choluteca')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Apacilagua','descripcion'=>'1','codigo'=>'0602','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Choluteca','descripcion'=>'2','codigo'=>'0601','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Concepción de María','descripcion'=>'3','codigo'=>'0603','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Duyure','descripcion'=>'4','codigo'=>'0604','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'El Corpus','descripcion'=>'5','codigo'=>'0605','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'El Triunfo','descripcion'=>'6','codigo'=>'0606','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Marcovia','descripcion'=>'7','codigo'=>'0607','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Morolica','descripcion'=>'8','codigo'=>'0608','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Namasigue','descripcion'=>'9','codigo'=>'0609','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Orocuina','descripcion'=>'10','codigo'=>'0610','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Pespire','descripcion'=>'11','codigo'=>'0611','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Antonio de Flores','descripcion'=>'12','codigo'=>'0612','orden'=>12]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Isidro','descripcion'=>'13','codigo'=>'0613','orden'=>13]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San José','descripcion'=>'14','codigo'=>'0614','orden'=>14]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Marcos de Colón','descripcion'=>'15','codigo'=>'0615','orden'=>15]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Ana de Yusguare','descripcion'=>'16','codigo'=>'0616','orden'=>16]);

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('colon')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_ceiba')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Balfate','descripcion'=>'1','codigo'=>'0202','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_trujillo')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Bonito Oriental','descripcion'=>'2','codigo'=>'0210','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_trujillo')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Iriona','descripcion'=>'3','codigo'=>'0203','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_trujillo')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Limón','descripcion'=>'4','codigo'=>'0204','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_olanchito')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Sabá','descripcion'=>'5','codigo'=>'0205','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_trujillo')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Fe','descripcion'=>'6','codigo'=>'0206','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_trujillo')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Rosa de Aguán','descripcion'=>'7','codigo'=>'0207','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_olanchito')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Sonaguera','descripcion'=>'8','codigo'=>'0208','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_trujillo')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Tocoa','descripcion'=>'9','codigo'=>'0209','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_trujillo')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Trujillo','descripcion'=>'10','codigo'=>'0201','orden'=>10]);

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('comayagua')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Ajuterique','descripcion'=>'1','codigo'=>'0302','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Comayagua','descripcion'=>'2','codigo'=>'0301','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'El Rosario','descripcion'=>'3','codigo'=>'0303','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Esquías','descripcion'=>'4','codigo'=>'0304','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Humuya','descripcion'=>'5','codigo'=>'0305','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La libertad','descripcion'=>'6','codigo'=>'0306','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Trinidad','descripcion'=>'7','codigo'=>'0308','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Lamaní','descripcion'=>'8','codigo'=>'0307','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Las Lajas','descripcion'=>'9','codigo'=>'0320','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Lejamani','descripcion'=>'10','codigo'=>'0309','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Meambar','descripcion'=>'11','codigo'=>'0310','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Minas de Oro','descripcion'=>'12','codigo'=>'0311','orden'=>12]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Ojos de Agua','descripcion'=>'13','codigo'=>'0312','orden'=>13]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Jerónimo','descripcion'=>'14','codigo'=>'0313','orden'=>14]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San José de Comayagua','descripcion'=>'15','codigo'=>'0314','orden'=>15]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San José del Potrero','descripcion'=>'16','codigo'=>'0315','orden'=>16]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Luis','descripcion'=>'17','codigo'=>'0316','orden'=>17]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Sebastián','descripcion'=>'18','codigo'=>'0317','orden'=>18]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Siguatepeque','descripcion'=>'19','codigo'=>'0318','orden'=>19]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Taulabé','descripcion'=>'20','codigo'=>'0321','orden'=>20]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Villa de San Antonio','descripcion'=>'21','codigo'=>'0319','orden'=>21]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Cabañas','descripcion'=>'1','codigo'=>'0402','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Concepción','descripcion'=>'2','codigo'=>'0403','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Copán Ruinas','descripcion'=>'3','codigo'=>'0404','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Corquín','descripcion'=>'4','codigo'=>'0405','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Cucuyagua','descripcion'=>'5','codigo'=>'0406','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Dolores','descripcion'=>'6','codigo'=>'0407','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Dulce Nombre','descripcion'=>'7','codigo'=>'0408','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'El Paraíso','descripcion'=>'8','codigo'=>'0409','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Florida','descripcion'=>'9','codigo'=>'0410','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Jigua','descripcion'=>'10','codigo'=>'0411','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Unión','descripcion'=>'11','codigo'=>'0412','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Nueva Arcadia','descripcion'=>'12','codigo'=>'0413','orden'=>12]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Agustín','descripcion'=>'13','codigo'=>'0414','orden'=>13]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Antonio','descripcion'=>'14','codigo'=>'0415','orden'=>14]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Jerónimo','descripcion'=>'15','codigo'=>'0416','orden'=>15]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San José','descripcion'=>'16','codigo'=>'0417','orden'=>16]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Juan de Opoa','descripcion'=>'17','codigo'=>'0418','orden'=>17]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Nicolás','descripcion'=>'18','codigo'=>'0419','orden'=>18]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Pedro','descripcion'=>'19','codigo'=>'0420','orden'=>19]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Rita','descripcion'=>'20','codigo'=>'0421','orden'=>20]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Rosa de Copán','descripcion'=>'21','codigo'=>'0401','orden'=>21]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Trinidad de Copán','descripcion'=>'22','codigo'=>'0422','orden'=>22]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Veracruz','descripcion'=>'23','codigo'=>'0423','orden'=>23]);

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('cortes')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_san_pedro_sula')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Choloma','descripcion'=>'1','codigo'=>'0502','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_san_pedro_sula')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Lima','descripcion'=>'2','codigo'=>'0512','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_puerto_cortes')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Omoa','descripcion'=>'3','codigo'=>'0503','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_villanueva')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Pimienta','descripcion'=>'4','codigo'=>'0504','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_villanueva')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Potrerillos','descripcion'=>'5','codigo'=>'0505','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_puerto_cortes')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Puerto Cortés','descripcion'=>'6','codigo'=>'0506','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_villanueva')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Antonio de Cortés','descripcion'=>'7','codigo'=>'0507','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_villanueva')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Francisco de Yojoa','descripcion'=>'8','codigo'=>'0508','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_san_pedro_sula')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Manuel','descripcion'=>'9','codigo'=>'0509','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_san_pedro_sula')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Pedro Sula','descripcion'=>'10','codigo'=>'0501','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_villanueva')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Cruz de Yojoa','descripcion'=>'11','codigo'=>'0510','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_villanueva')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Villanueva','descripcion'=>'12','codigo'=>'0511','orden'=>12]);

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('el_paraiso')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Alauca','descripcion'=>'1','codigo'=>'0702','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Danlí','descripcion'=>'2','codigo'=>'0703','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'El Paraíso','descripcion'=>'3','codigo'=>'0704','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Güinope','descripcion'=>'4','codigo'=>'0705','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Jacaleapa','descripcion'=>'5','codigo'=>'0706','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Liure','descripcion'=>'6','codigo'=>'0707','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Morocelí','descripcion'=>'7','codigo'=>'0708','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Oropolí','descripcion'=>'8','codigo'=>'0709','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Potrerillos','descripcion'=>'9','codigo'=>'0710','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Antonio de Flores','descripcion'=>'10','codigo'=>'0711','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Lucas','descripcion'=>'11','codigo'=>'0712','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Matías','descripcion'=>'12','codigo'=>'0713','orden'=>12]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Soledad','descripcion'=>'13','codigo'=>'0714','orden'=>13]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Teupasenti','descripcion'=>'14','codigo'=>'0715','orden'=>14]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Texiguat','descripcion'=>'15','codigo'=>'0716','orden'=>15]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Trojes','descripcion'=>'16','codigo'=>'0719','orden'=>16]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Vado Ancho','descripcion'=>'17','codigo'=>'0717','orden'=>17]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Yauyupe','descripcion'=>'18','codigo'=>'0718','orden'=>18]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_danli')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Yuscarán','descripcion'=>'19','codigo'=>'0701','orden'=>19]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('francisco_morazan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Alubarén','descripcion'=>'1','codigo'=>'0802','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Cedros','descripcion'=>'2','codigo'=>'0803','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Curarén','descripcion'=>'3','codigo'=>'0804','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Distrito Central','descripcion'=>'4','codigo'=>'0801','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'El Porvenir','descripcion'=>'5','codigo'=>'0805','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Guaimaca','descripcion'=>'6','codigo'=>'0806','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Libertad','descripcion'=>'7','codigo'=>'0807','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Venta','descripcion'=>'8','codigo'=>'0808','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Lepaterique','descripcion'=>'9','codigo'=>'0809','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Maraita','descripcion'=>'10','codigo'=>'0810','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Marale','descripcion'=>'11','codigo'=>'0811','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Nueva Armenia','descripcion'=>'12','codigo'=>'0812','orden'=>12]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Ojojona','descripcion'=>'13','codigo'=>'0813','orden'=>13]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Orica','descripcion'=>'14','codigo'=>'0814','orden'=>14]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Reitoca','descripcion'=>'15','codigo'=>'0815','orden'=>15]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Sabanagrande','descripcion'=>'16','codigo'=>'0816','orden'=>16]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Antonio de Oriente','descripcion'=>'17','codigo'=>'0817','orden'=>17]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Buenaventura','descripcion'=>'18','codigo'=>'0818','orden'=>18]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Ignacio','descripcion'=>'19','codigo'=>'0819','orden'=>19]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Juan de Flores','descripcion'=>'20','codigo'=>'0820','orden'=>20]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Miguelito','descripcion'=>'21','codigo'=>'0821','orden'=>21]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Ana','descripcion'=>'22','codigo'=>'0822','orden'=>22]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Lucía','descripcion'=>'23','codigo'=>'0823','orden'=>23]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Talanga','descripcion'=>'24','codigo'=>'0824','orden'=>24]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Tatumbla','descripcion'=>'25','codigo'=>'0825','orden'=>25]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Valle de Ángeles','descripcion'=>'26','codigo'=>'0826','orden'=>26]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Vallecillo','descripcion'=>'27','codigo'=>'0828','orden'=>27]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_distrito_central')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Villa de San Francisco','descripcion'=>'28','codigo'=>'0827','orden'=>28]);

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('gracias_a_dios')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_puerto_lempira')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Ahuas','descripcion'=>'1','codigo'=>'0903','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_puerto_lempira')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Brus Laguna','descripcion'=>'2','codigo'=>'0902','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_puerto_lempira')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Juan Francisco Bulnes','descripcion'=>'3','codigo'=>'0904','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_puerto_lempira')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Puerto Lempira','descripcion'=>'4','codigo'=>'0901','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_puerto_lempira')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Ramón Villeda Morales','descripcion'=>'5','codigo'=>'0905','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_puerto_lempira')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Wampusirpe','descripcion'=>'6','codigo'=>'0906','orden'=>6]);

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('intibuca')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Camasca','descripcion'=>'1','codigo'=>'1002','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Colomoncagua','descripcion'=>'2','codigo'=>'1003','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Concepción','descripcion'=>'3','codigo'=>'1004','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Dolores','descripcion'=>'4','codigo'=>'1005','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Intibucá','descripcion'=>'5','codigo'=>'1006','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Jesús de Otoro','descripcion'=>'6','codigo'=>'1007','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Esperanza','descripcion'=>'7','codigo'=>'1001','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Magdalena','descripcion'=>'8','codigo'=>'1008','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Masaguara','descripcion'=>'9','codigo'=>'1009','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Antonio','descripcion'=>'10','codigo'=>'1010','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Francisco de Opalaca','descripcion'=>'11','codigo'=>'1017','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Isidro','descripcion'=>'12','codigo'=>'1011','orden'=>12]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Juan','descripcion'=>'13','codigo'=>'1012','orden'=>13]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Marcos de la Sierra','descripcion'=>'14','codigo'=>'1013','orden'=>14]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Miguel Guancapla','descripcion'=>'15','codigo'=>'1014','orden'=>15]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Lucía','descripcion'=>'16','codigo'=>'1015','orden'=>16]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Yamaranguila','descripcion'=>'17','codigo'=>'1016','orden'=>17]);


        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('islas_de_la_bahia')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_ceiba')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Guanaja','descripcion'=>'1','codigo'=>'1102','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_roatan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'José Santos Guardiola','descripcion'=>'2','codigo'=>'1103','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_roatan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Roatán','descripcion'=>'3','codigo'=>'1101','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_ceiba')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Utila','descripcion'=>'4','codigo'=>'1104','orden'=>4]);

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('la_paz')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Aguanqueterique','descripcion'=>'1','codigo'=>'1202','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Cabañas','descripcion'=>'2','codigo'=>'1203','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Cane','descripcion'=>'3','codigo'=>'1204','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Chinacla','descripcion'=>'4','codigo'=>'1205','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Guajiquiro','descripcion'=>'5','codigo'=>'1206','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Paz','descripcion'=>'6','codigo'=>'1201','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Lauterique','descripcion'=>'7','codigo'=>'1207','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Marcala','descripcion'=>'8','codigo'=>'1208','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Mercedes de Oriente','descripcion'=>'9','codigo'=>'1209','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Opatoro','descripcion'=>'10','codigo'=>'1210','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Antonio del Norte','descripcion'=>'11','codigo'=>'1211','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San José','descripcion'=>'12','codigo'=>'1212','orden'=>12]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Juan','descripcion'=>'13','codigo'=>'1213','orden'=>13]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Pedro de Tutule','descripcion'=>'14','codigo'=>'1214','orden'=>14]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Ana','descripcion'=>'15','codigo'=>'1215','orden'=>15]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Elena','descripcion'=>'16','codigo'=>'1216','orden'=>16]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa María','descripcion'=>'17','codigo'=>'1217','orden'=>17]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santiago de Puringla','descripcion'=>'18','codigo'=>'1218','orden'=>18]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_comayagua')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Yarula','descripcion'=>'19','codigo'=>'1219','orden'=>19]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('lempira')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Belén','descripcion'=>'1','codigo'=>'1302','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Candelaria','descripcion'=>'2','codigo'=>'1303','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Cololaca','descripcion'=>'3','codigo'=>'1304','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Erandique','descripcion'=>'4','codigo'=>'1305','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Gracias','descripcion'=>'5','codigo'=>'1301','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Gualcince','descripcion'=>'6','codigo'=>'1306','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Guarita','descripcion'=>'7','codigo'=>'1307','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Campa','descripcion'=>'8','codigo'=>'1308','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Iguala','descripcion'=>'9','codigo'=>'1309','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Unión','descripcion'=>'10','codigo'=>'1311','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Virtud','descripcion'=>'11','codigo'=>'1312','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Las Flores','descripcion'=>'12','codigo'=>'1310','orden'=>12]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Lepaera','descripcion'=>'13','codigo'=>'1313','orden'=>13]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Mapulaca','descripcion'=>'14','codigo'=>'1314','orden'=>14]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Piraera','descripcion'=>'15','codigo'=>'1315','orden'=>15]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Andrés','descripcion'=>'16','codigo'=>'1316','orden'=>16]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Francisco','descripcion'=>'17','codigo'=>'1317','orden'=>17]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Juan Guarita','descripcion'=>'18','codigo'=>'1318','orden'=>18]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Manuel Colohete','descripcion'=>'19','codigo'=>'1319','orden'=>19]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Marcos de Caiquín','descripcion'=>'20','codigo'=>'1328','orden'=>20]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Rafael','descripcion'=>'21','codigo'=>'1320','orden'=>21]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Sebastián','descripcion'=>'22','codigo'=>'1321','orden'=>22]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Cruz','descripcion'=>'23','codigo'=>'1322','orden'=>23]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Talgua','descripcion'=>'24','codigo'=>'1323','orden'=>24]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Tambla','descripcion'=>'25','codigo'=>'1324','orden'=>25]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Tomalá','descripcion'=>'26','codigo'=>'1325','orden'=>26]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Valladolid','descripcion'=>'27','codigo'=>'1326','orden'=>27]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_la_esperanza')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Virginia','descripcion'=>'28','codigo'=>'1327','orden'=>28]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('ocotepeque')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Belén Gualcho','descripcion'=>'1','codigo'=>'1402','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Concepción','descripcion'=>'2','codigo'=>'1403','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Dolores Merendón','descripcion'=>'3','codigo'=>'1404','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Fraternidad','descripcion'=>'4','codigo'=>'1405','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Encarnación','descripcion'=>'5','codigo'=>'1406','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Labor','descripcion'=>'6','codigo'=>'1407','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Lucerna','descripcion'=>'7','codigo'=>'1408','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Mercedes','descripcion'=>'8','codigo'=>'1409','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Ocotepeque','descripcion'=>'9','codigo'=>'1401','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Fernando','descripcion'=>'10','codigo'=>'1410','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Francisco del Valle','descripcion'=>'11','codigo'=>'1411','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Jorge','descripcion'=>'12','codigo'=>'1412','orden'=>12]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Marcos','descripcion'=>'13','codigo'=>'1413','orden'=>13]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Fe','descripcion'=>'14','codigo'=>'1414','orden'=>14]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Sensenti','descripcion'=>'15','codigo'=>'1415','orden'=>15]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Sinuapa','descripcion'=>'16','codigo'=>'1416','orden'=>16]);

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('olancho')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Campamento','descripcion'=>'1','codigo'=>'1502','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Catacamas','descripcion'=>'2','codigo'=>'1503','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Concordia','descripcion'=>'3','codigo'=>'1504','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Dulce Nombre de Culmí','descripcion'=>'4','codigo'=>'1505','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'El Rosario','descripcion'=>'5','codigo'=>'1506','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Esquipulas del Norte','descripcion'=>'6','codigo'=>'1507','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Gualaco','descripcion'=>'7','codigo'=>'1508','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Guarizama','descripcion'=>'8','codigo'=>'1509','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Guata','descripcion'=>'9','codigo'=>'1510','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Guayape','descripcion'=>'10','codigo'=>'1511','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Jano','descripcion'=>'11','codigo'=>'1512','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Juticalpa','descripcion'=>'12','codigo'=>'1501','orden'=>12]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'La Unión','descripcion'=>'13','codigo'=>'1513','orden'=>13]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Mangulile','descripcion'=>'14','codigo'=>'1514','orden'=>14]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Manto','descripcion'=>'15','codigo'=>'1515','orden'=>15]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Patuca','descripcion'=>'16','codigo'=>'1523','orden'=>16]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Salamá','descripcion'=>'17','codigo'=>'1516','orden'=>17]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Esteban','descripcion'=>'18','codigo'=>'1517','orden'=>18]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Francisco de Becerra','descripcion'=>'19','codigo'=>'1518','orden'=>19]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Francisco de la Paz','descripcion'=>'20','codigo'=>'1519','orden'=>20]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa María del Real','descripcion'=>'21','codigo'=>'1520','orden'=>21]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Silca','descripcion'=>'22','codigo'=>'1521','orden'=>22]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_juticalpa')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Yocón','descripcion'=>'23','codigo'=>'1522','orden'=>23]);

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('santa_barbara')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Arada','descripcion'=>'1','codigo'=>'1602','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Atima','descripcion'=>'2','codigo'=>'1603','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_san_pedro_sula')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Azacualpa','descripcion'=>'3','codigo'=>'1604','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Ceguaca','descripcion'=>'4','codigo'=>'1605','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Chinda','descripcion'=>'5','codigo'=>'1609','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Concepción del Norte','descripcion'=>'6','codigo'=>'1607','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Concepción del Sur','descripcion'=>'7','codigo'=>'1608','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'El Níspero','descripcion'=>'8','codigo'=>'1610','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Gualala','descripcion'=>'9','codigo'=>'1611','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Ilama','descripcion'=>'10','codigo'=>'1612','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Las Vegas','descripcion'=>'11','codigo'=>'1627','orden'=>11]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_san_pedro_sula')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Macuelizo','descripcion'=>'12','codigo'=>'1613','orden'=>12]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Naranjito','descripcion'=>'13','codigo'=>'1614','orden'=>13]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Nueva Frontera','descripcion'=>'14','codigo'=>'1628','orden'=>14]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Nuevo Celilac','descripcion'=>'15','codigo'=>'1615','orden'=>15]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_san_pedro_sula')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Petoa','descripcion'=>'16','codigo'=>'1616','orden'=>16]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_rosa_de_copan')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Protección','descripcion'=>'17','codigo'=>'1617','orden'=>17]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_san_pedro_sula')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Quimistán','descripcion'=>'18','codigo'=>'1618','orden'=>18]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Francisco de Ojuera','descripcion'=>'19','codigo'=>'1619','orden'=>19]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San José de las Colinas','descripcion'=>'20','codigo'=>'1606','orden'=>20]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Luis','descripcion'=>'21','codigo'=>'1620','orden'=>21]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_san_pedro_sula')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Marcos','descripcion'=>'22','codigo'=>'1621','orden'=>22]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Nicolás','descripcion'=>'23','codigo'=>'1622','orden'=>23]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Pedro Zacapa','descripcion'=>'24','codigo'=>'1623','orden'=>24]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Vicente Centenario','descripcion'=>'25','codigo'=>'1625','orden'=>25]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Bárbara','descripcion'=>'26','codigo'=>'1601','orden'=>26]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Rita','descripcion'=>'27','codigo'=>'1624','orden'=>27]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_santa_barbara')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Trinidad','descripcion'=>'28','codigo'=>'1626','orden'=>28]);

        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('valle')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Alianza','descripcion'=>'1','codigo'=>'1702','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Amapala','descripcion'=>'2','codigo'=>'1703','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Aramecina','descripcion'=>'3','codigo'=>'1704','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Caridad','descripcion'=>'4','codigo'=>'1705','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Goascorán','descripcion'=>'5','codigo'=>'1706','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Langue','descripcion'=>'6','codigo'=>'1707','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Nacaome','descripcion'=>'7','codigo'=>'1701','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Francisco de Coray','descripcion'=>'8','codigo'=>'1708','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_choluteca')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'San Lorenzo','descripcion'=>'9','codigo'=>'1709','orden'=>9]);


        $catalogo = Catalogo::whereCodigo('municipios')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('yoro')->first()->id;
        $categoria_id = CatalogoElemento::whereCodigo('reg_olanchito')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Arenal','descripcion'=>'1','codigo'=>'1802','orden'=>1]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_el_progreso')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'El Negrito','descripcion'=>'2','codigo'=>'1803','orden'=>2]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_el_progreso')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'El Progreso','descripcion'=>'3','codigo'=>'1804','orden'=>3]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_yoro')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Jocón','descripcion'=>'4','codigo'=>'1805','orden'=>4]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_el_progreso')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Morazán','descripcion'=>'5','codigo'=>'1806','orden'=>5]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_olanchito')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Olanchito','descripcion'=>'6','codigo'=>'1807','orden'=>6]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_el_progreso')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Santa Rita','descripcion'=>'7','codigo'=>'1808','orden'=>7]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_yoro')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Sulaco','descripcion'=>'8','codigo'=>'1809','orden'=>8]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_yoro')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Victoria','descripcion'=>'9','codigo'=>'1810','orden'=>9]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_yoro')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Yorito','descripcion'=>'10','codigo'=>'1811','orden'=>10]);
        $categoria_id = CatalogoElemento::whereCodigo('reg_yoro')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'parent_id'=>$parent_id,'categoria_id'=>$categoria_id,'nombre'=>'Yoro','descripcion'=>'11','codigo'=>'1801','orden'=>11]);


        //Áreas de adscripción
        $catalogo = Catalogo::whereCodigo('areas_adscripcion')->first()->id;
        $parent_id = CatalogoElemento::whereCodigo('setrass')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Dirección General de Inspección del Trabajo',
            'codigo'=>'dgit',
            'orden'=>1,
            'parent_id'=>$parent_id
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Auditoría Técnica de la Inspección',
            'codigo'=>'ati',
            'orden'=>1,
            'parent_id'=>$parent_id
        ]);
        $parent_id = CatalogoElemento::whereCodigo('pgr')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Dirección Nacional de Procuración Judicial',
            'codigo'=>'dnpj',
            'orden'=>1,
            'parent_id'=>$parent_id
        ]);

        //MÓDULOS
        $catalogo = Catalogo::whereCodigo('modulos_compartidos')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Configuración',
            'codigo'=>'configuracion',
            'orden'=>1
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Casos',
            'codigo'=>'casos',
            'orden'=>2
        ]);

        $catalogo_setrass = Catalogo::whereCodigo('modulos_setrass')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo_setrass,
            'nombre'=>'Módulo ATI',
            'codigo'=>'modulo_ati',
            'orden'=>1
        ]);
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo_setrass,
            'nombre'=>'Auditorías',
            'codigo'=>'auditorias',
            'orden'=>2
        ]);

        //Origen Denuncia
        $catalogo = Catalogo::whereCodigo('origen_denuncia')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Empleador',
            'codigo'=>'empleador',
            'orden'=>1
        ]);

        $catalogo = Catalogo::whereCodigo('origen_denuncia')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Trabajador',
            'codigo'=>'trabajador',
            'orden'=>2
        ]);
        $catalogo = Catalogo::whereCodigo('origen_denuncia')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Sindicato',
            'codigo'=>'sindicato',
            'orden'=>3
        ]);
         $catalogo = Catalogo::whereCodigo('origen_denuncia')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'De Oficio',
            'codigo'=>'de_oficio',
            'orden'=>4
        ]);
         $catalogo = Catalogo::whereCodigo('origen_denuncia')->first()->id;
        CatalogoElemento::updateOrCreate([
            'catalogo_id' => $catalogo,
            'nombre'=>'Por Terceros',
            'codigo'=>'por_terceros',
            'orden'=>5
        ]);

        //Estatus denuncias ATI
        $catalogo = Catalogo::whereCodigo('estatus_denuncia_ati')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Pendiente','codigo'=>'pendiente','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'En revisión','codigo'=>'en_revision','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Revisión de inadmisión','codigo'=>'revision_inadmision','orden'=>3]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Inadmisión','codigo'=>'inadmision','orden'=>4]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Providencia','codigo'=>'providencia','orden'=>5]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Solventado','codigo'=>'solventado','orden'=>6]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Solicitud de expediente','codigo'=>'solicitud_expediente','orden'=>7]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Admitida','codigo'=>'admitida','orden'=>8]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Informe cargado','codigo'=>'informe_cargado','orden'=>9]);
        //CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Para Desestimar','codigo'=>'para_desestimar','orden'=>10]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Desestimado','codigo'=>'desestimado','orden'=>11]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Informe con observaciones','codigo'=>'observaciones_informe','orden'=>12]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Informe actualizado','codigo'=>'informe_actualizado','orden'=>13]);
        //CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Validar informe Auditor','codigo'=>'validar_informe_auditor','orden'=>14]);
        //CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'En proceso de Remisión','codigo'=>'proceso_remision','orden'=>15]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Finalizado','codigo'=>'finalizado','orden'=>16]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Expediente recibido','codigo'=>'expediente_recibido','orden'=>17]);


        // Rechazos por el coordinador
        $catalogo = Catalogo::whereCodigo('rechazo_coordinador')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'El número de expediente PGR y/o fecha de recepción no coinciden','codigo'=>'motivo_coord_1','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'No corresponde a la regional ','codigo'=>'motivo_coord_2','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Otro','codigo'=>'motivo_coord_3','orden'=>3]);


        // Rechazos por el procurador
        $catalogo = Catalogo::whereCodigo('rechazo_procurador')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'El número de expediente PGR y/o fecha de recepción no coinciden','codigo'=>'motivo_procu_1','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'No corresponde a la regional ','codigo'=>'motivo_procu_2','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Otro','codigo'=>'motivo_procu_3','orden'=>3]);

        // Tipo de pagos
        $catalogo = Catalogo::whereCodigo('tipo_pagos')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Extrajudicial','codigo'=>'extrajudicial','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Judicial','codigo'=>'judicial','orden'=>2]);

        // Rechazos por el coordinador
        $catalogo = Catalogo::whereCodigo('providencia_denuncia_ati')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Motivo providencia coordinador 1','codigo'=>'motivo_providencia_coord_1','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Motivo providencia coordinador 2','codigo'=>'motivo_providencia_coord_2','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Motivo providencia coordinador 3','codigo'=>'motivo_providencia_coord_3','orden'=>3]);

        // Motivos de Inadmisión Denuncias ATI
        $catalogo = Catalogo::whereCodigo('inadmision_denuncia_ati')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Motivo de Inadmisión Denuncias 1','codigo'=>'motivo_inadmision_denuncia_1','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Motivo de Inadmisión Denuncias 2','codigo'=>'motivo_inadmision_denuncia_2','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Motivo de Inadmisión Denuncias 3','codigo'=>'motivo_inadmision_denuncia__3','orden'=>3]);

        // Desestimación de denuncia
        $catalogo = Catalogo::whereCodigo('desestimacion_denuncia_ati')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'No se recibió respuesta','codigo'=>'sin_respuesta','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Motivo desestimación 2','codigo'=>'motivo_desestimacion_2','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Motivo desestimación 3','codigo'=>'motivo_desestimacion_3','orden'=>3]);

        // Desestimación de denuncia
        $catalogo = Catalogo::whereCodigo('tipos_inspeccion')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Ordinaria','codigo'=>'ordinaria','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Extraordinaria','codigo'=>'extraordinaria','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Asesoría técnica','codigo'=>'asesoria_tecnica','orden'=>3]);

        // Desestimación de denuncia
        $catalogo = Catalogo::whereCodigo('caracteres_denuncia')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Judicial','codigo'=>'judicial','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Extrajudicial','codigo'=>'extrajudicial','orden'=>2]);

        // Tipos de descargo
        $catalogo = Catalogo::whereCodigo('tipos_descargo')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'El multado pagó la multa en la Secretaría de Trabajo','codigo'=>'pago_multa','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'En virtud de las investigaciones realizadas se encuentra que la empresa multada cerró operaciones','codigo'=>'cierre_operaciones','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Otros','codigo'=>'otro_descargo','orden'=>3]);

        // Secciones para plantillas
        $catalogo = Catalogo::whereCodigo('secciones_plantillas')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Cédulas de trabajo','codigo'=>'seccion_cedulas_de_trabajo','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Resultados preliminares','codigo'=>'seccion_resultados_preliminares','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Cierre de auditoría','codigo'=>'seccion_cierre_auditoria','orden'=>3]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Inicio de proceso de auditoría','codigo'=>'seccion_inicio_proceso','orden'=>4]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Informe de auditoria','codigo'=>'seccion_informe_auditoria','orden'=>5]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Cédula de hallazgos','codigo'=>'seccion_cedula_hallazgos','orden'=>6]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Formato de seguimiento de recomendaciones auditoría','codigo'=>'formato_seguimiento_recomendaciones_auditoria','orden'=>7]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Informe de seguimiento de resultados auditoría','codigo'=>'formato_informe_seguimiento_resultados_auditoria','orden'=>8]);


        // Estatus para formularios
        $catalogo = Catalogo::whereCodigo('estatus_formularios')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Borrador','codigo'=>'formulario_borrador','orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Activo','codigo'=>'formulario_activo','orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Histórico','codigo'=>'formulario_historico','orden'=>3]);

        // Estatus para estatus_solicitud_expediente auditorías
        $catalogo = Catalogo::whereCodigo('estatus_solicitud_expediente')->first()->id;
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Expedientes Solicitados', 'codigo'=>'solicitud_solicitada',     'orden'=>1]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Expedientes Recibidos',   'codigo'=>'solicitud_recibida',       'orden'=>2]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Plazo Vencido',           'codigo'=>'solicitud_plazo_vencido',  'orden'=>3]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Prórroga',                'codigo'=>'solicitud_prorroga',       'orden'=>4]);
        CatalogoElemento::updateOrCreate(['catalogo_id'=>$catalogo,'nombre'=>'Incumplimiento',          'codigo'=>'solicitud_incumplimiento', 'orden'=>5]);

    }
}