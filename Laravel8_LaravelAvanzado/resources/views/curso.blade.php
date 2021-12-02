@extends('layouts.web')

@section('content')
    <div class="grid grid-cols-3 gap-4">
            <div class="p-8 bg-gray-200 col-span-1">
                <ul class="flex flex-col">
                    <li class="font-medium text-sm text-gray-400 mb-4 uppercase">
                           Contenido  
                    </li>
                    @foreach ($curso->posts as $post)

                    <li class="flex items-center text-gray-600 mt-2">
                        {{$post->name}}
                        @if ( $post->free )
                                <span class="text-xs text-gray-600 font-semibold bg-gray-400 rounded-full ml-auto px-3">Gratis</span> 
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>   

            <div class="text-gray-700 col-span-2">
                <img src="{{ $curso->image  }}" alt="Imagen del Curso">    
                <h2 class="text-4xl"> {{ $curso->name}} </h2>
                <p>{{ $curso->description }}</p>
                <div class="flex mt-3">
                    <img class="h-10 w-10 rounded mr-2" src="{{ $curso->user->avatar}}" alt="Imagen de Avata">
                </div>
                <div>
                    <p class="text-gray-700 text-sm"> {{ $curso->user->name}} </p>
                    <p class="text-gray-500 text-xs"> {{ $curso->created_at->diffForHumans()}} </p>
                </div>
                <div class="grid grid-cols-2 gap-4 my-8">
                    @foreach ($curso->similar() as $course)

                    <x-course-card :course="$course" />
                   
                    @endforeach
                </div> 
            </div> 
     
    </div>    



    <div class="text-center mt-4">
        <h1 class="text-3xl text-gray-700 mb-2 uppercase">Ultimos Cursos</h1>
        <h2 class="text-xl text-gray-700 ">Formate online en profesional de tecnología</h2>
    </div>
    <livewire:course-list>
@endsection