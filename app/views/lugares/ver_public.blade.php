@extends('layouts.bootstrap')
@section('encabezado')
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
@stop 

<?php $lugares_js = "var lugares = [" ?>

@foreach($lugares as $lugar)

<?php $lugares_js = $lugares_js . "[" .  json_encode($lugar->nombre). ", " . json_encode($lugar->descripcion) . ", " . $lugar->latitud . ", " . $lugar->longitud . ",' " . $lugar->created_at . "', " . $lugar->id ."],"?>
@endforeach

<?php $lugares_js = $lugares_js . "]";?>
 
@section('content')


       
        <h1>


  Lugares públicos de {{$email}}: {{count($lugares)}} </h1>


<div id="map" style="width: 100%; height: 400px;"></div>
<script type="text/javascript"> 
    {{ $lugares_js }};

    var bounds = new google.maps.LatLngBounds();
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    
    for (i = 0; i < lugares.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(lugares[i][2], lugares[i][3]),
        map: map
      });

      

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent("<h4><a href='/lugares/"+lugares[i][5]+"'>" + lugares[i][0]+ "</a></h4>" + lugares[i][1] );
          infowindow.open(map, marker);
          map.panTo(marker.getPosition());
        }
      })(marker, i));
      bounds.extend(marker.position);
    }

    map.fitBounds(bounds);
       	var listener = google.maps.event.addListener(map, "idle", function() { 
  	if (map.getZoom() > 16) map.setZoom(16); 
  		google.maps.event.removeListener(listener); 
	});
    
    
  </script>
  
@stop