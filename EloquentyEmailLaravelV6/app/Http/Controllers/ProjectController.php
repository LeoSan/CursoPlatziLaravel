<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

use App\Mail\EloquentMail;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function getAllProjects() {
        $projects = Project::all();
        return $projects;
    } 
    
    public function getTenProjects() {
        $projects = Project::paginate();
        //$projects = Project::latest()->take(10)->get();
       // $projects = Project::orderBy('project_id', 'DESC')->take(10)->get();
       // $projects = Project::take(10)->get();
        return $projects;
    }    
    
    
    public function getTerminoChunkProjects() {
        /* 
            En la clase anterior aprendimos a usar el modelo Project para traer datos de la tabla projects de una manera bastante simple, ahora imagina que esta tabla creció en registros y ahora se tarda mucho tiempo trayendo, por ejemplo, 900 registros, el rendimiento de la aplicación baja, se puede morir el servidor y ya no logramos tener todos los datos.

            Para evitar este problema tenemos un comando que nos va a traer los registros por secciones, este es chunk, al cual le pediremos un bloque menor de registros y fragmentará la cantidad de valores hasta tenerlos todos.

            Esto lo logramos implementando un Closure que procesará los datos en los bloques que van llegando.        
        
        */
        
        Project::chunk(200, function ($projects) {
            foreach ($projects as $project) {
                //Aquí escribimos lo que haremos con los datos (operar, modificar, etc)
            }
        });
    } 

    public function getFindOrFailProjects() {
        /* 
           Para esto tenemos dos métodos que nos ayudan a manejar una excepción. En caso de no encontrar el modelo, nos retornarán un objeto de tipo ModelNotFoundException y podemos operar con él en caso de error.

                findOrFail 
                $project = Project::findOrFail(1);
        
        */
        $project = Project::findOrFail(1);
    }     
    
    public function getfirstOrFailProjects() {
        /* 
         firstOrFail
            Este método es bastante similar al anterior, sin embargo, este nos retornará el primer resultado que coincida con la condición que le pedimos, pero también nos retornará una excepción de no encontrar el modelo Project.
        
        */
        
        $project = Project::where('is_active', '=', 1)->firstOrFail();
    } 

    public function insertProject() {
        /* 
        Lo primero que hacemos es crear una instancia del modelo Project y lo almacenamos en una variable, de ahí tomamos esa misma variable e indicamos cada campo de la tabla y le asignamos el valor que va a guardar. Finalmente, le indicamos la acción, que en este caso será save() para guardar.
        
        Ahora te preguntarás por qué no hemos agregado los campos created_at y updated_at para asignarles valores, lo que sucede es que el método save() ya se encarga de asignarles la fecha/hora actual de manera automática, si deseas asignar una valor diferente se lo puedes dar como los demás campos, pero recuerda que estos campos son de tiempo datetime.
        
        */
        //Ejemplo si vienen del request 
       /* $project = new Project;
        $project->city_id = $request->cityId;
        $project->company_id = $request->companyId;
        $project->user_id = $request->userId;
        $project->name = $request->name;
        $project->execution_date = $request->executionDate;
        $project->is_active = $request->isActive;
        $project->save();*/

        //Pero lo haremos a manita 
        $project = new Project; //Primero intancio el modelo aseguradome de importal el modelo al controlador 
        $project->name = 'Nuevo Aprendizaje';
        $project->company_id = 1;
        $project->user_id = 1;
        $project->citie_id = 1;

        $project->save();
        return 'Se Guardo';

    } 

    public function updateProject() {
        $project = Project::find(3);
        $project->name = 'Proyecto de tecnología';
        $project->save();
        return "Actualizado";
    }

    public function updateCondicionProject() {
            $project = Project::where('is_active', 1)->where('city_id', 1);
            $project->name = 'Proyecto de tecnología ciudad dos ';
            $project->save();
            return "Actualizado";
    }

    public function deleteProject() {
         $project = Project::where('id', '=', 1)->delete();// Borrado  permanente
        // $project   = Project::find(1)->delete(); // Borrado Logico 
        // $products = Product::onlyTrashed()->get();
        //$project   = Project::find(1)->forceDelete(); // Borrado Logico 
        return "Registros eliminados";
    }

    public function sendMail($email)
    {
        Mail::to($email)->send(new EloquentMail);
        return "Envio de correo";
    }


    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }




}
