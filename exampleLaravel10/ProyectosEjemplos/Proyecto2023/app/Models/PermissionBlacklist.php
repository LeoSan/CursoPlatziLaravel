<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionBlacklist extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'permissions_blacklists'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'permission_id'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];
}
