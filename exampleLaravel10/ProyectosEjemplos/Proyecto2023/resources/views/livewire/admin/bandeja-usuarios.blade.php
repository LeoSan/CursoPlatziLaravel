<div>
    <div class="row">
        <div class="col-12">
            <div class="border-top mb-2"></div>
        </div>
        <label class="form-label font-regular-size mb-1" for="busqueda">Buscar</label>
        <div class="col-md-12 py-1 d-flex justify-content-end text-end align-items-center">
            <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height border-filter" wire:model="busqueda" value="{{$busqueda}}" placeholder="Busque por nombre, correo electrónico o cargo">
            @if(isset($busqueda) && strlen($busqueda)>2)
                <button class="btn btn-default busqueda_casos ms-2 input-regular-height" wire:click="removeFiltro('busqueda')">Cancelar</button>
            @endif
        </div>
    </div>
    @include('livewire.admin.partials.filtros-usuarios')

    <div class="col-md-12 d-flex justify-content-end text-end align-items-center py-2 table-responsive">
        <a href="{{ route('usuarios.create') }}" class='btn btn-danger fw-semibold float-end input-regular-height'>Nuevo usuario</a>
    </div>

    @php
        $num_pagina = isset($page) && $page!="" ? $page : 1;
        $num_registro =  (($num_pagina-1)*20);
    @endphp
    <div class="d-none d-md-block">
        <div class="table-responsive">
            <table class="table text-start tabla-pgr">
                <thead>
                <tr>
                    <th class="ps-3" style="width: 5%;">ID</th>
                    <th class=" text-nowrap" style="width: 20%;">Nombre completo</th>
                    <th class="" style="width: 15%;">Correo electrónico</th>
                    <th class="" style="width: 15%;">Cargo</th>
                    <th class="" style="width: 15%;">Perfil</th>
                    <th class="pe-3  text-center" style="width: 30%;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @forelse($usuarios as $usuario)
                        @php
                            $num_registro++;
                        @endphp
                        <td class="ps-3 bg-white">{{ $num_registro }}</td>
                        <td class="bg-white">{{ $usuario->nombre_completo}}</td>
                        <td class="bg-white">{{ $usuario->email }}</td>
                        <td class="bg-white">{{ $usuario->cargo }}</td>
                        <td class="bg-white">{{ $usuario->perfil->show_name }}</td>
                        <td class="bg-white">
                            <div class="d-flex justify-content-center h-100">
                                <div class="">
                                    <a class="dropdown-item p-2" href="{{ route('usuarios.show', ['user_id' => $usuario->id,'accion'=>'ver_detalle']) }}">
                                        <span class="d-flex gap-1 align-items-center">
                                            <small><i class="fas fa-eye fs-6"></i></small>
                                            <span class="ps-1">
                                                Detalle
                                            </span>
                                        </span>
                                    </a>
                                </div>
                                <div class="">
                                    <a class="dropdown-item p-2" href="{{route('bitacora.index',['usuario_id' => $usuario->id])}}">
                                        <span class="d-flex gap-1 align-items-center">
                                            <small><i class="fas fa-history fs-6"></i></small>
                                            <span class="ps-1">
                                                Bitácora
                                            </span>
                                        </span>
                                    </a>
                                </div>
                                <div class="">
                                    <a class="text-red-eliminar dropdown-item p-2" style="color: #e63535!important;" href="#" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal" onclick="getOpcionesEliminarUsuario(this)" data-user_id = "{{$usuario->id}}" data-user_name =  "{{$usuario-> complete_name}}">
                                        <span class="d-flex gap-1 align-items-center">
                                            <small><i class="fas fa-trash-can fs-6"></i></small>
                                            <span class="ps-1">
                                                Eliminar
                                            </span>
                                        </span>
                                    </a>
                                    <form id="form_eliminar_usuario" action="{{ route('usuarios.getElementosEliminar') }}" method="GET" autocomplete="off" accept-charset="UTF-8">
                                        @csrf
                                        <input type="hidden" name="usuario_id">
                                    </form>
                                </div>
                            </div>
                        </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="6" class="bg-white border-0">
                            Sin resultados encontrados
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-md-block d-lg-none">
        @forelse($usuarios as $usuario)
            <div class="card my-2 card-usuarios p-1">
                <div class="card-body">
                    <p class="fw-bold">Nombre completo: <span class="fw-normal">{{ $usuario->nombre_completo}}</span></p>
                    <p class="fw-bold">Correo electrónico: <span class="fw-normal">{{ $usuario->email}}</span></p>
                    <p class="fw-bold">Cargo: <span class="fw-normal">{{ $usuario->cargo}}</span></p>
                    <p class="fw-bold">Perfil: <span class="fw-normal">{{ $usuario->perfil->show_name}}</span></p>
                    <div class="row justify-content-end">
                        <div class="col d-flex justify-content-end">
                            <a class="dropdown-item p-2" href="{{ route('usuarios.show', ['user_id' => $usuario->id,'accion'=>'ver_detalle']) }}"><img src="{{ asset('images/icons/icon-eye.svg') }}" class="mx-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver detalle">Ver detalle</a>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <a class="dropdown-item p-2" href="{{route('bitacora.index',['usuario_id' => $usuario->id])}}"><img src="{{ asset('images/icons/icon-eye.svg') }}" class="mx-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver bitácora">Ver bitácora</a>
                        </div>
                        @csrf
                        <input type="hidden" name="usuario_id">
                        <div class="col d-flex justify-content-end">
                            <a class="text-red-eliminar dropdown-item p-2" style="color: #e63535!important;" href="#" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal" onclick="getOpcionesEliminarUsuario(this)" data-user_id = "{{$usuario->id}}" data-user_name =  "{{$usuario-> complete_name}}"><img src="{{ asset('images/icons/icon-trash-rojo.svg') }}" class="mx-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar usuario">Eliminar</a>
                            <form id="form_eliminar_usuario" action="{{ route('usuarios.getElementosEliminar') }}" method="GET" autocomplete="off" accept-charset="UTF-8">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h5>Sin usuarios</h5>
        @endforelse
    </div>
    <div class="d-flex justify-content-center">
        {!! $usuarios->links() !!}
    </div>

</div>
