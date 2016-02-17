<?php 
class LugaresController extends BaseController {
 
    /**
     * Mustra la lista con todos los usuarios
     */
    public function verLugar($id)
    {
        $lugar = Lugar::find($id); 
        
        $id = (Auth::guest()?0:Auth::user()->id);
        
        $tienePermiso = false;
        
        if($lugar){
        //TODO: falta validar q el lugar este compartido con el usuario:
        
            if($lugar->privacidad == 'publico' || $lugar->creador ==$id)
            {
            	$tienePermiso = true;
            }
            elseif(!Auth::guest())
            {
            	//revisar que si no cumple ambas condiciones, entonces hay que revisar si 
            	//el lugar ha sido compartido con este usuario o no.
            	//1. Obtener los id de contacto de a quienes se les ha compartido este lugar en particular
            	//2. hacer el join con la tabla contacto para obtener los mails
            	$compartidos_actuales = $lugar->compartidos;
            	$arreglo_email_compartidos = array();
        
                foreach($compartidos_actuales as $k){
                    
                    $arreglo_email_compartidos[] = $k->email;    
                }
                           	
            	//3. si el mail del usuario está dentro de estalista de mails, entonces sí tengo permiso
            	if(in_array(Auth::user()->email, $arreglo_email_compartidos)) {
            	   $tienePermiso = true;
            	}
            	
            }
            
            if($tienePermiso) {
                return View::make('lugares.ver_lugar', array('lugar' => $lugar));
            }
            else {
                $mensaje = "No tienes permisos suficientes para acceder a este contenido";
            	$tipo_mensaje = "mensaje_info";
            	
            	if(Auth::guest()) {
            		return Redirect::to('login')->with($tipo_mensaje, $mensaje);
            	}
            	else {
            		return Redirect::to('lugares')->with($tipo_mensaje, $mensaje);
            	}
            }
            
            
        }
        else {
        	$mensaje = "Lugar no existente";
        	$tipo_mensaje = "mensaje_info";
        	return Redirect::to('lugares')->with($tipo_mensaje, $mensaje);
        }
    }
    
     /**
     * Muestra formulario para crear Usuario
     */
    public function agregarLugarUsuario()
    {
        return View::make('lugares.crear');
    }
    
     /**
     * Crear el usuario nuevo
     */
    public function guardarLugarUsuario()
    {
    	$mensaje = "";
    	$tipo_mensaje ="";
    	
    	if(Input::get('creador') == Auth::user()->id) {
        $lugar = Lugar::create(Input::all());
        $mensaje = "Lugar guardado correctamente. <a class='alert-link' href='/lugares/".$lugar->id."'>Ver lugar.</a>";
        $tipo_mensaje = "mensaje_success";
    	}
    	else {
    		$mensaje = "Ha ocurrido un error al guardar";
    		$tipo_mensaje = "mensaje_error";
    	}
 
        return Redirect::to('lugares')->with($tipo_mensaje, $mensaje);
    // el método redirect nos devuelve a la ruta de mostrar la lista de los usuarios
 
    }
 
     /**
     * Ver usuario con id
     */
    public function verLugaresUsuario()
    {

    	$id = Auth::user()->id;
        $lugares = Lugar::where('creador', '=', $id)->get();
    
    	//Generamos el arreglo de categorias
    	
		$categorias = array(1 => "general");
		
		//poblamos el resto de las categorias del usuario
		$categorias_ = Categoria::select('id', 'nombre')->where('creador', '=', $id)->orderBy('id','asc')->get();
		foreach ($categorias_ as $cat)
		{
		  $categorias[$cat->id] = $cat->nombre;
		}
		
		//lugares_js
		
		$lugares_js = "var lugares = [";

		foreach($lugares as $lugar)
		{
			$lugares_js = $lugares_js . "[" .  json_encode($lugar->nombre). ", " . json_encode($lugar->descripcion) . ", " . $lugar->latitud . ", " . $lugar->longitud . ",' " . $lugar->created_at . "', " . $lugar->id ."],";
		}
		
		$lugares_js = $lugares_js . "]";
		
		//generamos lista de usuarios que comparten y cantidad generarListaCompartidos()
		$compartidos = $this->generarListaCompartidos();
		
    
    	return View::make('lugares.ver', array('lugares' => $lugares, 'id' => $id, 'categorias' => $categorias, 'lugares_js' => $lugares_js, 'compartidos'=>$compartidos));
    }
    
    public function eliminarLugar($id)
    {
    	$mensaje = "";
    	$tipo_mensaje = "";
    	
    	//se debe revisar que el id sea del usuario
    	$lugar = Lugar::find($id);
    	if($lugar->creador == Auth::user()->id) {
    		//luego eliminar
    		$lugar->delete();
    		$mensaje = "Eliminado correctamente";
    		$tipo_mensaje = "mensaje_success";
    		
    	}
    	else {
    		$tipo_mensaje = "mensaje_error";
    		$mensaje = "Ha ocurrido un error al eliminar";
    	}
    	
    	//luego redirigir avisando que se eliminó correctamente	
    	return Redirect::to('lugares')->with($tipo_mensaje, $mensaje);;
    }
    
    public function verLugaresPublicos($email) {
    
    	$lugares = Lugar::join('users', 'users.id', '=', 'lugar.creador')->where('email', '=', $email)->where('privacidad', '=', 'publico')->get(array('lugar.nombre', 'lugar.descripcion', 'lugar.latitud', 'lugar.longitud', 'lugar.created_at', 'lugar.id'));
    	
	//generar la vista
	    if(count($lugares) > 0) {
			return View::make('lugares.ver_public', array('lugares'=> $lugares, 'email' => $email));
	    }
	    else {
	    	$tipo_mensaje = "mensaje_error";
    		$mensaje = "El usuario ". $email ." no tiene lugares públicos para mostrar, o bien, ¡no tiene cuenta en este sitio!";
    		return Redirect::to('contactos')->with($tipo_mensaje, $mensaje);;
	    }
    	
    }
    
        public function editarLugar($id)
    {
    	$lugar = Lugar::find($id);
    	
    	if($lugar->creador == Auth::user()->id)
    	{
        	return View::make('lugares.editar', array('lugar'=>$lugar));
    	}
    	else
    	{
    		$tipo_mensaje = "mensaje_error";
    		$mensaje = "Ha ocurrido un error al intentar acceder a este lugar. Compruebe que está utilizando la ruta correcta";
    		return Redirect::to('lugares')->with($tipo_mensaje, $mensaje);;
    		
    	}
    }

        public function actualizarLugar($id)
    {
        //Guarda en la DB los nuevos datos
        $mensaje = "";
    	$tipo_mensaje = "";
        
        $lugar = Lugar::find($id);
    	
    	if($lugar->creador == Auth::user()->id)
    	{
    		$lugar->nombre = Input::get('nombre');
    		$lugar->descripcion = Input::get('descripcion');
        	$lugar->latitud = Input::get('latitud');
        	$lugar->longitud = Input::get('longitud');
        	$lugar->privacidad = Input::get('privacidad');
        	$lugar->categoria = Input::get('categoria');
        	$lugar->save();
        	$mensaje = "Lugar editado correctamente";
    		$tipo_mensaje = "mensaje_success";
       	}
    	else
    	{
    		$tipo_mensaje = "mensaje_error";
    		$mensaje = "Ha ocurrido un error al intentar modificar este lugar. Compruebe que está utilizando la ruta correcta";		
    	}
    	return Redirect::to('lugares')->with($tipo_mensaje, $mensaje);;
    }
    
    public function guardarCompartidos($id) 
    {

    	$contactos = Input::get('contactos');
    	$lugar = Lugar::find($id);
    	
    	if (!is_array($contactos)) {
  			$contactos = array();
    	}
    
        $mensaje = "";
    
        $compartidos_actuales = $lugar->compartidos;
        $arreglo_compartidos_actuales = array();
        
        foreach($compartidos_actuales as $k){
            //
            $arreglo_compartidos_actuales[] = $k->id;    
        }
        
        foreach ($contactos as $cont) {
            //revisar si estaban ya en la lista de compartidos
            if (!in_array($cont, $arreglo_compartidos_actuales)){
                
                //sino, enviar mail
                //$mensaje  =$mensaje . $cont . ", ";
                $this->enviarMailCompartidos($cont, $lugar);
            }
            
        }
        
    	$lugar->compartidos()->sync($contactos);
    	
    	//se envia mail de notificacion a quienes tienen un lugar compartido nuevo
    	//enviarMailCompartidos($usuarios)
    	
    	//$mensaje = $mensaje . " Lista de compartidos actualizada correctamente. " . json_encode($arreglo_compartidos_actuales) . " - " . json_encode($contactos);
        
        $mensaje = "Lista de compartidos actualizada correctamente.";
        $tipo_mensaje = "mensaje_success";
        //return Redirect::to('/compartir/'.$id)->with($tipo_mensaje, $mensaje);
        //return Redirect::back()->with($tipo_mensaje, $mensaje);
        return $mensaje;
    }
    
    public function mostrarCompartidos($id) 
    {
    	//genera la lista de quienes comparten lugares al usuario y la cantidad
    	
    	//tenemos el id del usuario y el email mio. se debe obtener mi id en la lista de contactos del usuario
    	//y luego consultar en lugares por ese id
    	
    	$email = Auth::user()->email;
    	$lugares = array();
    	
    	$algo = Contacto::where('email', 'like', $email)->where('creador', '=', $id)->get();
    	$id_usuario = $algo[0]["id"];
    	
    	$lugares = $algo[0]->lugares;
    	
    	
    	//foreach ($algo as $contacto) {
    		    
    	//		$lugares[] = array("nombre" => $usuario_compartidor->nombre . " " . $usuario_compartidor->apellido , "cantidad" => count($contacto->lugares));
    			
    	//	}
		
        //$response->header('Access-Control-Allow-Origin', '*');
        return json_encode($lugares);
    }
    
    public function generarListaCompartidos()
    {
    	//genera la lista de quienes comparten lugares al usuario y la cantidad
    	$email = Auth::user()->email;
    	$lugares = array();
    	
    	$algo = Contacto::where('email', 'like', $email)->get();
    	
    	
    	foreach ($algo as $contacto) {
    		    //para obtener el nombre de la persona que comparte, estamos usando find por cada id de creador
    		    //TODO: usar la relacion uno a uno de LARAVEL
    		    $usuario_compartidor = User::find($contacto->creador);
    		    
    			$lugares[$contacto->creador] = array("nombre" => $usuario_compartidor->nombre . " " . $usuario_compartidor->apellido , "cantidad" => count($contacto->lugares));
    			
    		}
		
        //$response->header('Access-Control-Allow-Origin', '*');
        return $lugares;
    }
    
    public function enviarMailCompartidos($idusuario, $lugar)
    {
        //tengo el id del usuario del sistema. Pero puede darse el caso que ese id no exista y sea solamente un contacto. El lugar debería compartirse igual y guardarse bajo ese mail.
        //el mail de notidifacion deberia enviarse como invitacion a unirse al sistema
        
    
    $user_to = Contacto::find($idusuario);
    $user_from = Auth::user();
    $datos = array('from_nombre' => $user_from->nombre, 'to_email' => $user_to->email, 'to_nombre' => $user_to->nombre, 'id' => $user_to->id, 'lugar_id' => $lugar->id, 'lugar_nombre'=>$lugar->nombre);

    $data = $datos; //un parche horrible
    
    //para cada usuario en usuarios, enviar mail
    Mail::queue('emails.lugarcompartido',$data, function($message) use ($datos)
    {

      $message->to($datos['to_email'], $datos['to_nombre'])->subject($datos['from_nombre'] . " ha compartido un lugar contigo");
      //$message->to('cbravoa@gmail.com', 'Carlos Bravo')->subject('Correo de prueba!' . json_encode($datos));
    });
        
    }
    
    public function verListaLugares()
    {
        //
        $id = Auth::user()->id;
        $lugares = Lugar::where('creador', '=', $id)->get();
        
        return View::make('lugares.lista', array('lugares'=> $lugares));
    }
 
}
?>