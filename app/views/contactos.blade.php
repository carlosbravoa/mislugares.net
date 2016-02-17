@extends('layouts.bootstrap')

@section('content')

<div class="content">

<h1>Contactos</h1>

<div class="form-group">
<a class="btn btn-small btn-success" href="#" onclick="crear()">Crear nuevo contacto</a>
</div>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<td>&nbsp;</td>
			<td>Nombre</td>
			<td>e-mail</td>
			<td>Acciones</td>
		</tr>
	</thead>
	<tbody>
	<?php $num=0;?>
	@foreach($contactos as $key => $value)
	<?php $num++;?>
		<tr>
			<td>{{ $num }}</td>
			<td>{{HTML::link('/u/' . $value->email, $value->nombre . ' ' . $value->apellido)}}</td>
			<td>{{{ $value->email }}}</td>
			<td>

				{{ Form::open(array('url' => 'contactos/' . $value->id, 'class' => 'pull-left')) }}

				{{HTML::link('#', 'Editar', array('class'=>'btn btn-small btn-info', 'onclick'=> 'editar(' . $value->id . ',' . json_encode($value->nombre) .',' . json_encode($value->apellido) .',' . json_encode($value->email) . ')'))}}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::submit('Eliminar', array('class' => 'btn btn-warning')) }}
				{{ Form::close() }}
			</td>
		</tr>
	@endforeach
	</tbody>
</table>


</div>

<script type="text/javascript"> 
     function eliminar(ide) {
         	
     	$('#botonmodaleliminar').click(function() {
  			redirigir('/contactos/eliminar/' + ide);
		});
     	
     	//mostrarlo
     	$('#modaleliminar').modal('show');
    	
    }
    
    
    function crear() {
    	
    	$('#nombrecontacto').val("");
    	$('#apellidocontacto').val("");
    	$('#emailcontacto').val("");
    	$('#formcreareditar').attr("action",('/contactos/crear'));
     	
     	//mostrarlo
     	$('#modalcreareditar').modal('show');
    	
    }
    
    function editar(ide, nombre, apellido, email) {
    	
    	$('#nombrecontacto').val(nombre);
    	$('#apellidocontacto').val(apellido);
    	$('#emailcontacto').val(email);
    	$('#formcreareditar').attr("action",'/contactos/editar/' + ide);
     	
     	//mostrarlo
     	$('#modalcreareditar').modal('show');
    	
    }
    
    function redirigir(url){
    	//redirigir a la url solicitada por el modal
    	window.location.href = url;
    	
    }
   
  </script>


  <div class="modal fade" id="modaleliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Confirmación de eliminación</h4>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro que deseas eliminar ese contcto?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="botonmodaleliminar">Eliminar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <div class="modal fade" id="modalcreareditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	{{ Form::open(array('url' => '/contactos/guardar', 'class' => 'form-horizontal', 'role'=> 'form', 'id'=>'formcreareditar' )) }}
               
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
	        <h4 class="modal-title">Ingresa los datos de tu contacto</h4>
	      </div>
	      <div class="modal-body">
	        <p>	
	        	{{Form::label('nombre', 'Nombre: ', array('class' => 'control-label'))}}
            	{{Form::text('nombre', '', array('class' => 'form-control', 'id'=>'nombrecontacto'))}}
            	{{Form::label('apellido', 'Apellido: ', array('class' => 'control-label'))}}
            	{{Form::text('apellido', '', array('class' => 'form-control', 'id'=>'apellidocontacto'))}}
            	{{Form::label('email', 'e-mail: ', array('class' => 'control-label'))}}
            	{{Form::text('email', '', array('class' => 'form-control', 'id'=>'emailcontacto'))}}
            	{{Form::hidden('creador', Auth::user()->id)}}
	        </p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-primary" id="botonmodalcreareditar">Guardar</button>
	      </div>
		{{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop