<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('inicio'); 
});
 
//Route::get('usuarios/{id}', array('uses'=>'UsersController@verUsuario'));

Route::get('login', function(){
    return View::make('login'); 
});
 
// esta ruta sera para crear al usuario 
Route::post('registro', array('before' => 'csrf', 'uses' => 'UsersController@crearUsuario'));
 
// esta ruta servirá para iniciar la sesión por medio del correo y la clave 
// para esto utilizamos la función estática attemp de la clase Auth
// esta función recibe como parámetro un arreglo con el correo y la clave
Route::post('login', function(){
 
    // la función attempt se encarga automáticamente se hacer la encriptación de la clave para ser comparada con la que esta en la base de datos. 
    if (Auth::attempt( array('email' => Input::get('email'), 'password' => Input::get('password') ), true )){
    	//en Auth::user() estan todos los datos del usuario. Son obtenido de la sesion
        //$id = Auth::user()->id;
        return Redirect::to('lugares')->with('mensaje_success', "Bienvenido " . Auth::user()->nombre);
    }else{
        return Redirect::to('login')->with('mensaje_error', 'Ingreso inválido');
    }
 
});

Route::get('logout', function(){

	Auth::Logout();
        return Redirect::to('login')->with('mensaje_success', "Sesión cerrada exitosamente. Esperamos verte nuevamente");

});



Route::group(array('before' => 'auth'), function()
{
 	Route::get('lugares', array('uses'=>'LugaresController@verLugaresUsuario')); //agregar validacion de id con el de la sesion en el controlador!!!
 	Route::get('agregar', array('uses'=>'LugaresController@agregarLugarUsuario'));
 	Route::post('guardar', array('uses'=>'LugaresController@guardarLugarUsuario'));
 	Route::get('lugares/eliminar/{id}', array('uses'=>'LugaresController@eliminarLugar'));
 	Route::get('categorias', array('uses'=>'CategoriasController@mostrarCategorias'));
	Route::post('categorias/editar/{id}', array('uses'=>'CategoriasController@editarCategoria'));
	Route::post('categorias/crear', array('uses'=>'CategoriasController@crearCategoria'));
 	Route::delete('categorias/{id}', array('uses'=>'CategoriasController@eliminarCategoria'));
 	Route::get('lugares/{id}/editar', array('as'=>'lugar.editar', 'uses'=>'LugaresController@editarLugar'));
    Route::put('lugares/{id}', array('as'=>'lugar.actualizar','uses'=>'LugaresController@actualizarLugar'));
    
    Route::get('lugares/cat/{id}', function($id){
          $lugares = Lugar::where('categoria', '=', $id)->where('creador','=',Auth::user()->id)->get();
          $response = Response::make($lugares);

          //$response->header('Access-Control-Allow-Origin', '*');
          return $response;
        });
    Route::get('lugares/todos', function(){
          $lugares = Lugar::where('creador','=',Auth::user()->id)->get();
          $response = Response::make($lugares);

          //$response->header('Access-Control-Allow-Origin', '*');
          return $response;
        });
    Route::get('contactos', array('uses'=>'ContactosController@mostrarContactos'));
	Route::post('contactos/editar/{id}', array('uses'=>'ContactosController@editarContacto'));
	Route::post('contactos/crear', array('uses'=>'ContactosController@crearContacto'));
 	Route::delete('contactos/{id}', array('uses'=>'ContactosController@eliminarContacto'));
 	Route::get('compartir/{id}', array('uses'=>'ContactosController@mostrarCompartirLugar'));
	Route::post('compartir/{id}', array('uses'=>'LugaresController@guardarCompartidos'));
	Route::get('lugares/comp/{id}', array('uses'=>'LugaresController@mostrarCompartidos'));
	//Route::get('compartidoslista', array('uses'=>'LugaresController@generarListaCompartidos'));

    //prueba de mail
    Route::get('lugares/lista', array('uses'=>'LugaresController@verListaLugares'));  
        
});
Route::get('lugares/{id}', array('uses'=>'LugaresController@verLugar'));

Route::get('inicio', function(){
    return View::make('inicio'); 
});

Route::get('u/{email}', array('uses'=>'LugaresController@verLugaresPublicos'));
Route::get('blank', function(){
    return View::make('blank'); 
});
