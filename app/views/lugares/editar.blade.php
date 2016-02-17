@extends('layouts.bootstrap')
@section('encabezado')
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
         
@stop 

<?php
$id_user = Auth::user()->id;
$categorias = array(1 => "general");

//poblamos el resto de las categorias del usuario
foreach (Categoria::select('id', 'nombre')->where('creador', '=', $id_user)->orderBy('id','asc')->get() as $cat)
{
  $categorias[$cat->id] = $cat->nombre;
}

$privacidad = array('publico' => 'Público', 'privado' => 'Privado');

?>


 
@section('content')
        {{ HTML::link('lugares', 'cancelar'); }}
        <h1>Editar lugar "{{{$lugar->nombre}}}"</h1>
        
        
        <div id="map" style="width: 100%; height: 400px;"></div>
        <p>Puedes ajustar el pin arrástrándolo o pinchando directamente cualquier parte del mapa. Si lo deseas, también puedes <a href="#" id="mostrarmodal" class="btn btn-sm btn-info">buscar por dirección</a></p>


          <script src="{{asset('mapa.js')}}"></script>

        
         {{ Form::model($lugar, array('route' => array('lugar.actualizar', $lugar->id), 'method' => 'PUT', 'onsubmit'=> 'cambiarboton()')) }}

        	
        
         <div class="form-group">
            {{Form::label('nombre', 'Nombre:', array('class' => 'control-label'))}}
            {{Form::text('nombre', NULL, array('class' => 'form-control'))}}
            
            {{Form::label('descripcion', 'Descripción:', array('class' => 'control-label'))}}
            {{Form::textarea('descripcion', NULL, array('class' => 'form-control'))}}
            
            {{Form::hidden('creador', Auth::user()->id)}}
            {{Form::hidden('latitud', NULL, array('id' => 'latitud'))}}
            {{Form::hidden('longitud', NULL, array('id' => 'longitud'))}}
            
            {{Form::label('privacidad', 'Privacidad:', array('class' => 'control-label'))}}
            {{Form::select('privacidad', $privacidad, NULL)}}
            <br>
			{{Form::label('categoria', 'Categoría:', array('class' => 'control-label'))}}
            {{Form::select('categoria', $categorias)}}       
		</div>
		
            {{Form::submit('Guardar', array('class' => 'btn btn-lg btn-success', 'id'=>'botonsubmit'))}}
            
        
        {{ Form::close() }}
        
<div class="modal fade" id="modaldireccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	        
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
	        <h4 class="modal-title">Ingresa una dirección</h4>
	      </div>
	      <div class="modal-body">
	        <p>	
	            <div class="input-group">
	        	<input type="search" class="form-control" name="direccion" id="direccion" placeholder="Calle, número, localidad, país (etc)">
	        	<div class="input-group-btn">
	        		<button type="button" class="btn btn-success" id="botonmodalcreareditar" onclick="buscardireccion()"><span class="glyphicon glyphicon-search"></span> Buscar</button>
				</div>
				</div>
	        </p>
	      </div>
		
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 
@stop        
@section('final')
<script type="text/javascript">

      $(document).ready(function () {
	   	  var lat = $('#latitud').val();
	      var lng = $('#longitud').val();
	      ubicarLatLng(lat,lng);
	      
	      $('#mostrarmodal').click(function() {
	   	  	$('#modaldireccion').modal('show');
	   	  });
	   	  
	   	  $('#modaldireccion').on('shown.bs.modal', function () {
    			$('#direccion').focus();
			}); 
	     
		});

</script>
        
        
@stop
