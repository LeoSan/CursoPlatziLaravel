<?
namespace App\Utils; 

use App\Events\ModelRated;
use Illuminate\Database\Eloquent\Model;

trait CanRate{

    
    //Todo esto es para crear una relación de muchos a mucho (MaM) 

    public function ratings($model = null){
        $modelClass = $model ? $model : $this->getMorphClass();

        $morphToMany = $this->morphToMany( 
            $modelClass, // Modelo de quien deseo relacionarme 
            'qualifier', // Nombre de mi relación  -> Los que pueden calificar
            'ratings',   // Nombre de la tabla 
            'qualifier_id', //Columna donde hago relación 
            'rateable_id'   //Columna que deseo relacionarme 
        );

        //Todo esto para definir nuestra relación. 

        $morphToMany->as('rating')
            ->withTimesTamps()//Indico que voy a trabajar con los datos tipos fechas
            ->withPivot('score', 'rateable_id')
            ->wherePivot('rateable_type', $modelClass )
            ->wherePivot('qualifier_type', $this->getMorphClass());

        return $morphToMany; 

    }


    public function rate(Model $model, float $score): bool
    {
        if ($this->hasRated($model)) {
            return false;
        }

        $this->ratings($model)->attach($model->getKey(), [
            'score' => $score,
            'rateable_type' => get_class($model)
        ]);

        //Forma de disparar eventos 
        event(new ModelRated($this, $model, $score));

        return true;
    }

    public function unrate(Model $model): bool
    {
        if (! $this->hasRated($model)) {
            return false;
        }

        $this->ratings($model->getMorphClass())->detach($model->getKey());

        return true;
    }

    public function hasRated(Model $model){
       
        return ! is_null($this->ratings($model->getMorphClass())->find($model->getKey()));

    }


}