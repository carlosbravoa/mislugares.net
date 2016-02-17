@extends('layouts.bootstrap')

@section('content')

{{HTML::image('gato.jpg')}}

<div class="well">Adicionalmente, el servidor arrojó el siguiente error: {{$code}}</div>

@stop