<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
 
       <title>Laravel</title>
 
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 
   </head>
   <body>
       <div class="container">
           <div class="row">
               <div class="col-sm-8 mx-auto"> 
                    <div class="card border-0 shadow">
                       <div class="card-body">
                               @if( $errors->any() )
                                       <div class="alert alert-danger">
                                           @foreach( $errors->all() as $error  )
                                              -- {{$error}}  <br>
 
                                           @endforeach
                                  
                                      </div>
                               @endif
 
                           <form action="{{ route('users.store')  }}" method="POST">
                               <div class="form-row">
                                    <div class="col-sm-3">
                                        <input type="text" name="name" class="form-control" placeholder="Nombre" value="{{ old('name') }}" />  <!-- ESto es un helper de laravel --> 
                                    </div>
                               
                                
                                    <div class="col-sm-4">
                                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" />  <!-- ESto es un helper de laravel --> 
                                    </div>
                                
                                
                                    <div class="col-sm-3">
                                        <input type="password" name="password" class="form-control" placeholder="contraseña"  /> 
                                    </div>
                                
                                
                                    <div class="col-auto">
                                        @csrf <!-- Esto es un token -->                              
                                            <input
                                                type="submit"
                                                value="Guardar"
                                                class="btn btn-primary"
                                                onclick="return confirm('¿ Esta seguro de Guardar ?')"
                                            />
                                    </div>
                                </div>
                           </form>
                       </div>       
                   </div>

                <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Acción</th>
                                </tr>   
                            </thead>
                    
                            <tbody>                             
                                @foreach ( $users as $user )
                                <tr>
                                    <td> {{$user->id}}    </td>
                                    <td> {{$user->name}}  </td>
                                    <td> {{$user->email}} </td>
                                    <td>
                                        <form action="{{ route('users.destroy', $user)  }}" method="POST">
                                            @method('DELETE')<!-- Esto es porque se genero en elrouter un delete fuerza que lo sea -->                              
                                            @csrf <!-- Esto es un token -->                              
                                            <input
                                                type="submit"
                                                value="Eliminar"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('¿ Desea Eliminar ?')"
                                            />
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody> 
                    </table> 

                  
                  
                           
              
               </div>
           </div>
      
       </div>
    </body>
</html>
