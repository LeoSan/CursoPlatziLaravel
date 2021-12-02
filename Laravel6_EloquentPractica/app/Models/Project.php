<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    
    protected $table = 'projects';
    
  //  use SoftDeletes; //Implementamos 

    protected $dates = ['deleted_at']; //Registramos la nueva columna

    protected $fillable = ['name', 'company_id', 'user_id', 'citie_id'];
    
    
    //
    // 
    // use SoftDeletes; //Implementamos 

    // public $timestamps = false; //Esta es la manera de invalidar 
    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'last_update';
    // protected $connection = 'connection-name';.
 /*   protected $attributes = [
        'name' => 'hola',
    ];
 */
    /*protected $fillable = [
        'name',
        'company_id',
        'user_id',
        'citie_id'
    ];*/
    
}
