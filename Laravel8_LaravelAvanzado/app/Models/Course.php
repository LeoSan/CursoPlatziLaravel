<?php

namespace App\Models;

use App\Utils\CanBeRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory,CanBeRate;
    

    protected $table = 'Courses';

    //Esto es cuando es inverso -> Un curso pertenece aun Usuario 
    public function user(){
        return $this->belongsTo(User::class);
    }    
    

    //Esto es cuando es inverso -> Tiene mucho 1-M - Curso tiene muchos Post 
    public function posts(){
        return $this->hasMany(Post::class);
    }


    /*
        Campo Virtual 
    */
    public function getExcerptAttribute (){
        return substr($this->description,0,80);
    }    
    

/* Metodo personalizado 
Esta forma de crear nuevas propiedades “curstomizadas” se llaman Accessors & Mutators,
así como tenemos el getNameAttribute() (Accesor) 
también Laravel nos pone a la disposición el setNameAttribute() (Mutator),
les recomiendo darle una leída a esta página de la documentación de Laravel explicándolo a fondo:
*/    
    public function similar (){
        return $this->where( 'category_id',  $this->category_id)->with('user')->take(2)->get();
    }



    //Este metodo nos ayuda a crear una imagen facker cuando no se tiene alguna imagen 
    protected static function booted() {
        //Se ecjecuta antes de crearse la entidad 
        static::creating(function (Course $course) {
           // $faker = \Facker\Factory::create();
           // $course->image = $faker->imageUrl();
           // $course->user_id->associate(auth()->user());
        });
    }


}
