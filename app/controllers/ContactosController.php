<?php 
class ContactosController extends BaseController {
 
    /**
     * Mustra la lista con todos los usuarios
     */
    public function mostrarContactos()
    {
    	$id = Auth::user()->id;
        $contactos = Contacto::where('creador', '=', $id)->get();        
        return View::make('contactos', array('contactos' => $contactos));
        
    }
    
     /**
     * Crear el usuario nuevo
     */
    public function crearContacto()
    {
    	$mensaje = "";
    	$tipo_mensaje ="";
    	
    	if(Input::get('creador') == Auth::user()->id) {
        Contacto::create(Input::all());
        $mensaje = "Contacto guardado correctamente";
        $tipo_mensaje = "mensaje_success";
    	}
    	else {
    		$mensaje = "Ha ocurrido un error al guardar";
    		$tipo_mensaje = "mensaje_error";
    	}
 
        return Redirect::to('contactos')->with($tipo_mensaje, $mensaje);;
    // el método redirect nos devuelve a la ruta de mostrar la lista de los usuarios
 
    }
   
    public function eliminarContacto($id)
    {
    	
    	$mensaje = "";
    	$tipo_mensaje = "";
    	
    	//se debe revisar que el id sea del usuario
    	$contacto = Contacto::find($id);
    	if($contacto->creador == Auth::user()->id) {
    		//luego eliminar
    		$contacto->delete();
    		$mensaje = "Eliminado correctamente";
    		$tipo_mensaje = "mensaje_success";
    		
    	}
    	else {
    		$tipo_mensaje = "mensaje_error";
    		$mensaje = "Ha ocurrido un error al eliminar";
    	}
    	
    	//luego redirigir avisando que se eliminó correctamente	
    	return Redirect::to('contactos')->with($tipo_mensaje, $mensaje);;
    }
    
    public function editarContacto($id)
    {
    	
    	$mensaje = "";
    	$tipo_mensaje = "";
    	
    	//se debe revisar que el id sea del usuario
    	$contacto = Contacto::find($id);
    	if($contacto->creador == Auth::user()->id) {
    		//luego editar
    		
    		$contacto->nombre = Input::get('nombre');
    		$contacto->apellido = Input::get('apellido');
    		$contacto->email = Input::get('email');
    		$contacto->save();
    		$mensaje = "Editado correctamente";
    		$tipo_mensaje = "mensaje_success";
    		
    	}
    	else {
    		$tipo_mensaje = "mensaje_error";
    		$mensaje = "Ha ocurrido un error al editar";
    	}
    	
    	//luego redirigir avisando que se eliminó correctamente	
    	return Redirect::to('contactos')->with($tipo_mensaje, $mensaje);;
    }
    
    public function mostrarCompartirLugar($id)
    {
    	$idUsuario = Auth::user()->id;
        $contactos = Contacto::where('creador', '=', $idUsuario)->get();
        $lugar = Lugar::find($id); 
        $compartidos = $lugar->compartidos; 
        $comp_array = array();
        
        foreach($compartidos as $c) {
        	$comp_array[] = $c->id;
        }      
        return View::make('compartir', array('contactos' => $contactos, 'compartidos'=> $comp_array, 'idlugar' => $id));
    }
 
}
?>