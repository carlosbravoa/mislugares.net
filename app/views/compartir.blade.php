<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Selecciona los contactos para compartir este lugar</h4>
</div>
<div class="modal-body">

{{ Form::open(array('url' => 'compartir/' . $idlugar, 'id'=>'formcompartir')) }}
 <div class="listacheck">  
       
@foreach($contactos as $key => $value)
<div class="elemento">
	<label class="checkbox">
		{{Form::checkbox('contactos[]', $value->id, in_array($value->id, $compartidos))}} {{$value->nombre . ' ' . $value->apellido }} 
	</label>
</div>
@endforeach
</div>
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
{{Form::button('Guardar', array('class'=>'btn btn-primary', 'onclick'=>'guardar()'))}}

{{ Form::close() }}

</div>
<script type="text/javascript">
function guardar(){
	var formData = $('#formcompartir').serializeArray();
	var URL = $("#formcompartir").attr("action");
	$.post(URL,
	    formData,
	    function(data, textStatus, jqXHR)
	    {

	       var mensaje = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>";
	       mensaje = mensaje + data + "</div>";
	       
	       $('#mensaje_estado').html(mensaje);
	       
	    }).fail(function(jqXHR, textStatus, errorThrown) 
	    {
	 	   var mensaje = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>";
	       mensaje = mensaje + "Ha ocurrido un error al actualizar listados de compartidos" + "</div>";
	       
	       $('#mensaje_estado').html(mensaje);
	    });
	    $('#modalcompartir').modal('hide');
}
</script>
