@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">{{ __('Load files') }}</div>

                <div class="card-body">

                    <form action="/load-files" enctype="multipart/form-data" method="post">
                        @csrf

                        <input type="text" name="nombre" class="form-control">
                        <br>
                        <br>

                        @include('components.carga-archivos', ['codigo' => 'acuse_recibo'])

                        <br>
                        <br>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>

                </div>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Load files multiple') }}</div>

                <div class="card-body">

                    <form action="/load-files" enctype="multipart/form-data" method="post">
                        @csrf

                        <input type="text" name="nombre" class="form-control">
                        <br>
                        <br>

                        @include('components.carga-archivos-multiple', ['codigo' => 'acuse_recibo'])


                        <br>
                        <br>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>



                </div>
            </div>
        </div>
    </div>
@endsection
