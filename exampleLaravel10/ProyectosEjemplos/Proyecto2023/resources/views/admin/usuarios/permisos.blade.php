<div class="tab-pane fade" id="nav-permisos" role="tabpanel" aria-labelledby="nav-permisos-tab">
    <div class="col-md-12 mt-4">
        <form class="needs-validation form_disable_button" method="post" action="{{ route('usuarios.storePermisos') }}" autocomplete="off" accept-charset="UTF-8" id="permisos_form">
        @csrf
        <input type="hidden" name="user_id" value="{{ @$usuario->id }}" />
        <input type="hidden" name="rol_id" value="{{ @@$usuario->roles->first()->id }}" />
        <div class="row">
            <div class="col-12">
                <p for="plaza" class="form-label fw-bold">Asigne los permisos y privilegios al usuario</p>
            </div>
        </div>
        @foreach($modulos->sortBy('orden') AS $modulo)
        <div class="card mb-3">
            <div class="card-header bg-primary text-white fw-bold">
                {{ $modulo->nombre }}
            </div>
            <div class="card-body">
                @foreach($modulo->secciones->sortBy('nombre') AS $seccion)
                    <div class="accordion mb-2" id="{{$seccion->codigo}}">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading_{{$seccion->codigo}}">
                                <button class="accordion-button accordion-permisos collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$seccion->codigo}}" aria-expanded="false" aria-controls="collapse_{{$modulo->codigo}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 28 28" class="me-2">
                                        <g fill="none" fill-rule="evenodd">
                                            <g fill="#666666" fill-rule="nonzero">
                                                <g>
                                                    <path d="M14 0C6.3 0 0 6.3 0 14s6.3 14 14 14 14-6.3 14-14S21.7 0 14 0zm0 4.34c1.54 0 2.8 1.26 2.8 2.8 0 1.54-1.26 2.8-2.8 2.8-1.54 0-2.8-1.26-2.8-2.8 0-1.54 1.26-2.8 2.8-2.8zm4.2 18.06H9.8v-2.8h1.4V14H9.8v-2.8h7v8.4h1.4v2.8z" transform="translate(-398 -147) translate(398 147)"/>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    {{ $seccion->nombre }}
                                </button>
                            </h2>
                            <div id="collapse_{{$seccion->codigo}}" class="accordion-collapse collapse" aria-labelledby="heading_{{$seccion->codigo}}" data-bs-parent="#{{$seccion->codigo}}">
                                <div class="accordion-body">
                                    @php ($role_id = $usuario->roles->count() > 0?@$usuario->roles->first()->id:null)
                                    @foreach($seccion->permisos->sortBy('show_name') AS $permiso)
                                        <div class="form-check text-muted">
                                            <div class="position-relative">
                                                @if(isset($permisos_by_seccion[$seccion->id]) && $permisos_by_seccion[$seccion->id]->contains('id', $permiso->id)==true && inPermiso($role_id,$permiso->id,$usuario->id))
                                                @if(isPermiso($role_id,$permiso->id,$usuario->id))
                                                <img src="{{ asset('images/icons/checksable.png') }}" style="position: absolute; width: 16px; left: -24px; top: 5px" data-bs-toggle="tooltip" data-bs-placement="top" title="Los permisos no pueden ser alterados"/>
                                                @else
                                                <input
                                                    id="permisos_{{ $permiso->id }}"
                                                    name="permisos[]"
                                                    class="form-check-input "
                                                    type="checkbox"
                                                    value="{{ $permiso->id }}"
                                                    onchange="usuarioContador(this)"
                                                    @if(isset($permisos_by_seccion[$seccion->id]) && $permisos_by_seccion[$seccion->id]->contains('id', $permiso->id)==true && inPermiso($role_id,$permiso->id,$usuario->id))  checked @endif>
                                                @endif
                                                @else
                                                <input
                                                    id="permisos_{{ $permiso->id }}"
                                                    name="permisos[]"
                                                    class="form-check-input "
                                                    type="checkbox"
                                                    value="{{ $permiso->id }}"
                                                    onchange="usuarioContador(this)"
                                                    @if(isset($permisos_by_seccion[$seccion->id]) && $permisos_by_seccion[$seccion->id]->contains('id', $permiso->id)==true && inPermiso($role_id,$permiso->id,$usuario->id))  checked @endif
                                                >
                                                @endif
                                                @if (inPermiso($role_id,$permiso->id,$usuario->id))
                                                     @if(!inPrivilegio($permiso->id,$usuario->id))
                                                    <a href="#"><img src="{{ asset('images/icons/checksable.png') }}" style="position: absolute; width: 16px; left: -24px; top: 5px" data-bs-toggle="tooltip" data-bs-placement="top" title="Los permisos no pueden ser alterados"/></a>
                                                    @endif
                                                @endif
                                                @if (inBlacklist( $role_id ,$permiso))
                                                <a href="#"><img src="{{ asset('images/icons/blacklist.png') }}" style="position: absolute; width: 16px; height: 16px; left: -24px; top: 4px;" data-bs-toggle="tooltip" data-bs-placement="top" title="No tiene acceso a este permiso"/></a>
                                                @endif
                                            </div>
                                            @if(isset($permisos_by_seccion[$seccion->id]) && $permisos_by_seccion[$seccion->id]->contains('id', $permiso->id)==true && inPermiso($role_id,$permiso->id,$usuario->id) && isPermiso($role_id,$permiso->id,$usuario->id))
                                                <label class="badge bg-secondary text-center ms-2 me-2" @if($permisos_user->contains('id', $permiso->id) && !inBlacklist( $role_id ,$permiso)) for="permisos_{{ $permiso->id }}" role="button" @endif>
                                                    <img src="{{ asset('images/icons/informacion-white.svg') }}" class="me-1" width="12px" data-bs-toggle="tooltip" data-bs-placement="top" title=""/>Permiso&nbsp;&nbsp;&nbsp;

                                                </label>
                                                <label class="fw-normal fs-6" @if($permisos_user->contains('id', $permiso->id) && !inBlacklist( $role_id ,$permiso)) for="permisos_{{ $permiso->id }}" role="button" @endif>{{ $permiso->show_name }}</label>
                                            @else
                                                <label class="badge bg-secondary text-center ms-2 me-2" for="permisos_{{ $permiso->id }}" role="button" >
                                                    <img src="{{ asset('images/icons/informacion-white.svg') }}" class="me-1" width="12px" data-bs-toggle="tooltip" data-bs-placement="top" title=""/> Privilegio
                                                </label>
                                                <label class="fw-normal fs-6">{{ $permiso->show_name }}</label>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-end">
        <a href="{{route('usuarios')}}" class="btn btn-default busqueda_casos ms-2 input-regular-height">{{ isset($usuario->id) ? 'Regresar' : 'Cancelar' }}</a>
        <button class="btn btn-primary btn-default btn-tertiary busqueda_casos ms-2 input-regular-height" type="submit" id="usuario_permisos_actualizar">{{ @$usuario->roles->first()->name=='unidad_evaluadora'? 'Actualizar y continuar' : 'Actualizar y salir' }}</button>
    </div>
</div>