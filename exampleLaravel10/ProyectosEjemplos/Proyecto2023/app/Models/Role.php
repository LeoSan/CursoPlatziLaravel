<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function dennyPermissionTo($permisions)
    {
        foreach($permisions AS $permision) {
            PermissionBlacklist::updateOrCreate(['role_id' => $this->id,'permission_id'=>$permision->id],[
                  'role_id' => $this->id,
                  'permission_id'=>$permision->id
            ]);
        }
    }

    public function undennyPermissionTo($permisions)
    {
        foreach($permisions AS $permision) {
            $permisoBlacklist = PermissionBlacklist::where('role_id',$this->id)->where('permission_id',$permision->id)->first();
            if (isset($permisoBlacklist)) $permisoBlacklist->delete();
        }
    }
    public function area(){
        return $this->hasMany(CatalogoElemento::class,'area_id');
    }
}
