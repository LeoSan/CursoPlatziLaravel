<?php

namespace App\Http\Controllers;

use App\models\Category;
use Illuminate\Http\Request;

// Resourse personalizados para los resultados json 
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

//Request Personalizados para validar 
use App\Http\Requests\StoreCategoryRequest;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Es una forma de trabajar el producto 
        return Category::all();
        // Podemos usar la collection que viene por defecto laravel 
        //return CategoryResource::collection(Product::all());

        //Podemos usar la collection de una forma que nosotros creamos e importamos 
        return new CategoryCollection(Category::all());        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        return Category::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        //return $category;

            // Aqui hacemos la transformación no olvides importarlo 
            $category = new CategoryResource($category);
            return $category;        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        //
        return Category::all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
