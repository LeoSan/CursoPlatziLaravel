<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Pivot
{
    public $incrementing = true;

    protected $table = 'rating';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'score'
    ];


    public function rateable(){
        return $this->morphTo();
    }

    public function qualifier(){
        return $this->morphTo();
    }

}
