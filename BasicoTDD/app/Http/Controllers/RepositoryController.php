<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;


use App\Http\Requests\RepositoryRequest;

class RepositoryController extends Controller
{


    public function index(Request $request){
        return view('repositories.index', [
            'repositories' => $request->user()->repositories
        ]);
    }
    
    public function show( Repository $repository ){
        /*if ($request->user()->id != $repository->user_id) {
            abort(403);
        }*/

        $this->authorize('pass', $repository);

        return view('repositories.show', compact('repository'));
    }   
    
    public function edit( Repository $repository){
        
        
        /*if ($request->user()->id != $repository->user_id) {
            abort(403);
        }*/
        $this->authorize('pass', $repository);

        return view('repositories.edit', compact('repository'));
    }

    public function create(){
        
        return view('repositories.create');

    }

    public function store(Request $request, RepositoryRequest $validator){
       
        //Valido 
        $request = $validator->validarRegistroWeb($request);

        //Esto es cuando es json 
        // $validator = $validator->validarRegistroJson($request);
        //if ( !empty($validator) ) return response()->json($validator, 422);

        //Guardo si todo bien 
        $request->user()->repositories()->create($request->all());
        
        return redirect()->route('repositories.index');

    }

    public function update(Request $request, Repository $repository){
        
        //Valido 
        $request->validate(
            [
                'url'=>'required'
                ,'description'=>'required'
            ],
            [
                'url.required'=>'Url es obligatoria.'
                ,'description.required'=>'La Descripcion es obligatoria'

            ]
        );

        //Genero la Politica 
        /*if ($request->user()->id != $repository->user_id) {
            abort(403);
        }*/
        
        $this->authorize('pass', $repository);

        //Acutalizo 
        $repository->update($request->all());
        
        //Redurecciono
        return redirect()->route('repositories.edit', $repository);

    }    
    
    public function destroy(Request $request, Repository $repository){
        
        //Genero la Politica 
        /*if ($request->user()->id != $repository->user_id) {
            abort(403);
        }*/

        $this->authorize('pass', $repository);

        $repository->delete();
        
        return redirect()->route('repositories.index');

    }


}
