@extends('layouts.bootstrap')
@section('encabezado')
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
         
@stop 
 
@section('dp_body')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=668965699863601&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
@stop

@section('content')
<div class="content">  
 <div class="pull-right">
<div class="fb-like" data-href="http://www.mislugares.net/lugares/{{$lugar->id}}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>


</div>
  
 <h1>{{{$lugar->nombre}}}
 </h1>


</div>

<div class="content">
	<div class="well">
		<div class="pull-right">
		@if (!Auth::guest())
			@if ($lugar->creador == Auth::user()->id)
			    
			    {{HTML::link('/compartir/' . $lugar->id, 'Compartir', array('class'=>'btn btn-small btn-success', 'data-toggle'=>'modal', 'data-target'=>'#modalcompartir'))}}
				{{HTML::link('/lugares/' . $lugar->id . '/editar','Editar',array('class'=>'btn btn-small btn-primary'))}}
			@endif
		@endif
		</div>
		<p>{{{$lugar->descripcion}}}</p>
		<strong>Creador: {{{User::find($lugar->creador)->nombre}}}</strong> 
		
	</div>
	<div class="pull-right">
	
	<div id="map" style="width: 300px; height: 300px;"></div>
	<script src="{{asset('mapa.js')}}"></script>
    </div>
	
</div>
<div class="fb-comments" data-href="http://www.mislugares.net/lugares/{{$lugar->id}}" data-numposts="5" data-colorscheme="light"></div>


  
  <div class="modal fade" id="modaleliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Confirmación de eliminación</h4>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro que deseas eliminar este lugar?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="botonmodaleliminar">Eliminar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <div class="modal fade" id="modalcompartir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Compartir</h4>
      </div>
      <div class="modal-body">
        <p>Cargando lista...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="botonmodaleliminar">Compartir</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  
@stop

@section('final')
<script type="text/javascript">

      $(document).ready(function () {
	   	  var lat = {{$lugar->latitud}};
	      var lng = {{$lugar->longitud}};
	      ubicarLatLng_fijo(lat,lng);
		});

</script>
@stop