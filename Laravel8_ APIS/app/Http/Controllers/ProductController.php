<?php

namespace App\Http\Controllers;

use App\models\Product;
use Illuminate\Http\Request;

// Resourse personalizados para los resultados json 
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

//Request Personalizados para validar 
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Es una forma de trabajar el producto 
        //return Product::all();

        // Podemos usar la collection que viene por defecto laravel 
        //return ProductResource::collection(Product::all());

        //Podemos usar la collection de una forma que nosotros creamos e importamos 
        return new ProductCollection(Product::all());        



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create( $request->all() );
        return response()->json([
            'message' =>  "Se creo de manera correcta"
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
            // Aqui hacemos la transformación no olvides importarlo 
            $product = new ProductResource($product);
            return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest  $request, Product $product)
    {
        //
        $product->update( $request->all() );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

        return response()->json([
            'message' => 'Success'
        ], 204);

    }
}
