<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $guarded = []; //Se puedan crear productos con cualquier atributo -- Lista Blanca
}
