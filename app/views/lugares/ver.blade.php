@extends('layouts.bootstrap')
@section('encabezado')
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
@stop 
 
@section('content')

<div class="content">     
    <h1>
      Mis lugares 
    </h1>

    <div class="dropdown pull-right">
        <a href="#" class="dropdown-toggle btn btn-info" data-toggle="dropdown" id="botoncategorias">Categorías <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li role="presentation"><a href="#" onclick="repoblarmapa('todos','cat')">Todos</a></li>
            <li class="divider"></li>
            @foreach($categorias as $i => $c)
              <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="repoblarmapa({{$i}},'cat')"><span class="badge"> {{Lugar::where('categoria', '=', $i)->where('creador','=',Auth::user()->id)->count()}}</span>{{$c}}</a></li>
		    @endforeach
		    <li class="divider"></li>
		    <li class="dropdown-header">Compartidos</li>
		  
    	    @foreach($compartidos as $i => $c)
              <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="repoblarmapa({{$i}},'comp')"><span class="badge"> {{$c['cantidad']}}</span>{{$c['nombre']}}</a></li>
		    @endforeach				 
		  
        </ul>
    </div>

    <ul class="nav nav-tabs" role="tablist">
      <li class="active"><a href="#tabmapa" role="tab" data-toggle="tab" id="muestramapa">Mapa</a></li>
      <li><a href="#tablista" role="tab" data-toggle="tab" id="muestralista">Lista</a></li>
    </ul>
    <div id="tabmapa">
        <div id="map" style="width: 100%; height: 400px;"></div>    
        <p>La dirección para mostrar sólo tus lugares públicos es la siguiente: {{ HTML::link('/u/'.Auth::user()->email, 'http://www.mislugares.net/u/'.Auth::user()->email) }}</p>        
    </div>
    
    <div id="tablista">
    </div>
    
</div>


<script type="text/javascript"> 
    {{ $lugares_js }};
</script>
  <script src="{{asset('mapa.js')}}"></script>
  
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
$( document ).ready(function() {

	$('body').on('hidden.bs.modal', '.modal', function () {
	  $(this).removeData('bs.modal');
	});
	
	inicializar_mapa();
	if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(centrarMapa, error);
    } else {
         error('Tu navegador no tiene geolocalización');
    }
    
    $('#muestralista').click(function(){
        $('#tabmapa').hide();
        $('#tablista').show();
        $.get('/lugares/lista', function(contenido){
            $('#tablista').html(contenido);
        });
        $('#botoncategorias').attr('disabled', true);
    });
    
    $('#muestramapa').click(function(){
        $('#tabmapa').show();
        $('#tablista').hide();
        $('#botoncategorias').attr('disabled', false);
    });
});
</script>

@stop