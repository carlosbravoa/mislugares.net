<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<td>&nbsp;</td>
			<td>Nombre</td>
			<td>Descripción</td>
			<td>Categoría</td>
			<td>Acciones</td>
		</tr>
	</thead>
	<tbody>
	<?php 
	   $num=0;
	
	?>
	@foreach($lugares as $lugar)
	<?php $num++;?>
		<tr>
			<td>{{ $num }}</td>
			<td>{{HTML::link('/lugares/' . $lugar->id, $lugar->nombre)}}</td>
			<td>{{{ $lugar->descripcion }}}</td>
			<td><?php echo Categoria::find($lugar->categoria)->nombre ?></td>
			<td>
                <button type="button" class="btn btn-xs btn-primary" onclick="editar('{{{$lugar->id}}}')" alt="Editar"><span class="glyphicon glyphicon-pencil"></span></button> 
                <a href='/compartir/{{{$lugar->id}}}' class='btn btn-xs btn-success' data-toggle='modal' data-target='#modalcompartir' alt="Compartir"><span class="glyphicon glyphicon-share"></span></a>
                <button type="button" class="btn btn-xs btn-danger" onclick="eliminar('{{{$lugar->id}}}')" alt="Eliminar"><span class="glyphicon glyphicon-trash"></span></button>
				
			</td>
		</tr>
	@endforeach
	</tbody>
</table>