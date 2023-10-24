<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
Use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Description: me permite usar el paginador de boostrap 5, ya que por defecto usa los css de tailwindcss
         *
         */
        Paginator::useBootstrapFive();
        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_HN', 'es', 'ES', 'es_HN.utf8');
        Relation::morphMap([
            'bitacora' => 'App\Models\Bitacora',
            'caso' => 'App\Models\Caso',
            'catalogo' => 'App\Models\Catalogo',
            'catalogo_elemento' => 'App\Models\CatalogoElemento',
            'convenio' => 'App\Models\Convenio',
            'demanda' => 'App\Models\Demanda',
            'denuncia' => 'App\Models\Denuncia',
            'denunciaInforme' => 'App\Models\DenunciaInforme',
            'documento' => 'App\Models\Documento',
            'domicilio' => 'App\Models\Domicilio',
            'empresa' => 'App\Models\Empresa',
            'gestion_caso' => 'App\Models\GestionCaso',
            'gestion_denuncia' => 'App\Models\GestionDenuncia',
            'pago' => 'App\Models\Pago',
            'pago_total' => 'App\Models\PagoTotal',
            'representante_legal' => 'App\Models\RepresentanteLegal',
            'resolucion' => 'App\Models\Resolucion',
            'rol' => 'App\Models\Role',
            'sancion' => 'App\Models\Sancion',
            'seccion' => 'App\Models\Seccion',
            'tipo_infraccion' => 'App\Models\TipoInfraccion',
            'usuario' => 'App\Models\User',
            'usuario_jurisdiccion' => 'App\Models\UsuarioJurisdiccion',
            'planeacion' => 'App\Models\Planeacion',
            'planeacion_auditoria' => 'App\Models\PlaneacionAuditoria',
            'planeacion_solicitud_expediente' => 'App\Models\PlaneacionSolicitudExpediente',
            'ejecucion_auditoria' => 'App\Models\PlaneacionAuditoriaEjecucion',
            'plantilla_auditoria' => 'App\Models\PlaneacionAuditoriaEjecucionPlantilla',
            'mes_auditoria' => 'App\Models\PlaneacionAuditoriaMes',
            'plantilla' => 'App\Models\Plantilla',
        ]);
        Password::defaults(function (){
            return Password::min(6);
        });

    }
}
