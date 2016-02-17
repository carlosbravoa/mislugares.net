<?php 
class CategoriasController extends BaseController {
 
    /**
     * Mustra la lista con todos los usuarios
     */
    public function mostrarCategorias()
    {
    	$id = Auth::user()->id;
        $categorias = Categoria::where('creador', '=', $id)->get();        
        return View::make('categorias', array('categorias' => $categorias));
        
    }
    
     /**
     * Muestra formulario para crear Cat
     */
    public function agregarCategoria()
    {
        //return View::make('lugares.crear');
    }
    
     /**
     * Crear el usuario nuevo
     */
    public function crearCategoria()
    {
    	$mensaje = "";
    	$tipo_mensaje ="";
    	
    	if(Input::get('creador') == Auth::user()->id) {
        Categoria::create(Input::all());
        $mensaje = "Categoría guardada correctamente";
        $tipo_mensaje = "mensaje_success";
    	}
    	else {
    		$mensaje = "Ha ocurrido un error al guardar";
    		$tipo_mensaje = "mensaje_error";
    	}
 
        return Redirect::to('categorias')->with($tipo_mensaje, $mensaje);;
    // el método redirect nos devuelve a la ruta de mostrar la lista de los usuarios
 
    }
   
    public function eliminarCategoria($id)
    {
    	
    	$mensaje = "";
    	$tipo_mensaje = "";
    	
    	//se debe revisar que el id sea del usuario
    	$categoria = Categoria::find($id);
    	if($categoria->creador == Auth::user()->id) {
    		//luego eliminar
    		$categoria->delete();
    		$mensaje = "Eliminado correctamente";
    		$tipo_mensaje = "mensaje_success";
    		
    	}
    	else {
    		$tipo_mensaje = "mensaje_error";
    		$mensaje = "Ha ocurrido un error al eliminar";
    	}
    	
    	//luego redirigir avisando que se eliminó correctamente	
    	return Redirect::to('categorias')->with($tipo_mensaje, $mensaje);;
    }
    
    public function editarCategoria($id)
    {
    	
    	$mensaje = "";
    	$tipo_mensaje = "";
    	
    	//se debe revisar que el id sea del usuario
    	$categoria = Categoria::find($id);
    	if($categoria->creador == Auth::user()->id) {
    		//luego editar
    		
    		$categoria->nombre = Input::get('nombre');
    		$categoria->save();
    		$mensaje = "Editado correctamente";
    		$tipo_mensaje = "mensaje_success";
    		
    	}
    	else {
    		$tipo_mensaje = "mensaje_error";
    		$mensaje = "Ha ocurrido un error al editar";
    	}
    	
    	//luego redirigir avisando que se eliminó correctamente	
    	return Redirect::to('categorias')->with($tipo_mensaje, $mensaje);;
    }
 
}
?>