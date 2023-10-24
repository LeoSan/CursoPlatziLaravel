<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\Notificacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles,SoftDeletes;

    public function sendPasswordResetNotification($token)
    {
        Mail::to($this->email)->send(new Notificacion($this, 'resetPassword', null, [
            'url'=>route('password.reset',$token),
            'token' => $token
        ]));
        $descripcionBitacora = "Se envía correo electrónico para recuperación de contraseña al usuario $this->complete_name";
        registroBitacora(User::find($this->id),A_NOTIFICAR,C_USUARIOS,null,$descripcionBitacora,null,1);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'complete_name',
        'email',
        'phone',
        'dependencia_id',
        'regional_id',
        'area_adscripcion_id',
        'cargo',
        'perfil_id',
        'password',
        'activo',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNombreCompletoAttribute(){
        return $this->name.' '.$this->first_name.' '.$this->last_name;
    }

    public function getPosicionAttribute(){
        return $this->roles()->first()->show_name;
    }

    public function dependencia(){
        return $this->belongsTo(CatalogoElemento::class,'dependencia_id');
    }
    public function area(){
        return $this->belongsTo(CatalogoElemento::class,'area_adscripcion_id');
    }
    public function perfil(){
        return $this->belongsTo(Role::class,'perfil_id');
    }

    public function getIsAdminAttribute(){
        return $this->hasAnyPermission(
            [
                'gestionar_usuarios',
                'gestionar_catalogos',
                'gestionar_bitacoras',
                'gestionar_tipos_infraccion'
            ]);
    }
    public function getAdminUrlAttribute(){
        if($this->hasAnyPermission('gestionar_usuarios'))
            return route('usuarios');
        else if($this->hasAnyPermission('gestionar_catalogos'))
            return route('catalogos.index');
        else if($this->hasAnyPermission('gestionar_bitacoras'))
            return route('bitacora.index');
        else if($this->hasAnyPermission('gestionar_tipos_infraccion'))
            return route('tiposInfraccion.index');
    }

    public function casos(){
        return $this->hasMany(Caso::class,'usuario_asignado_id');
    }
    public function denuncias(){
        return $this->hasMany(Denuncia::class,'usuario_asignado_id');
    }
    public function auditorias(){
        return $this->hasMany(PlaneacionAuditoria::class,'auditor_responsable_id');
    }


    public function getPosicionRolAttribute(){
        return $this->roles()->first()->name;
    }
}
