@extends('layouts.bootstrap')

@section('content')


@if(Auth::user())
<h1>¡Hola 
{{{Auth::user()->nombre}}}!
</h1>
@else
<h1>¡Hola!</h1>
Debes {{ HTML::link('login', 'iniciar sesión'); }} para usar esta app.

@endif
<img src="touch-icon-ipad-retina.png" class="pull-right">

<p>Esta aplicación te permite guardar y administrar lugares en tu propio mapa (planificar viajes, guardar puntos de interés, compartir "picadas", etc!). Categorízalas y compártelas con tus contactos a tu volundad.<p>
<p>No se utilizarán datos para compartir con terceros, además de no ser un sitio con fines de lucro. Solamente se utilizan cookies para hacer posible el propio funcionamiento del sitio.</p>

<p>Pese a que las funcionalidades básicas ya están, todavía queda pendiente mucho trabajo, sobretodo corrección de errores y mejoras en usabilidad. Cualquier error o sugerencia, no dudes en hacérmela llegar.
</p>
<p>
TO DO:
<ul>

	<li>Compartir categorías completas</li>   
        <li>Colores en pins</li>
        <li>Mejoras en estabilidad en funciones para compartir</li>
        <li>Solución de errores (bugs)</li>
        <li>Retoques en diseño (¡muchos!)</li>
</ul>


@stop
