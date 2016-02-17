@extends('layouts.bootstrap')


@section('encabezado')
  <style type="text/css">body {
  /*padding-top: 40px;*/
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.panel-heading a:after {
    font-family: 'Glyphicons Halflings';
    content: "\e114";    
    float: right; 
    color: grey; 
}
.panel-heading a.collapsed:after {
    content: "\e080";
}
</style>
@stop

@section('content')

<div class="panel-group" id="accordion">
  <div class="panel panel-default" id="panel1">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-target="#login" data-parent="#accordion"
           href="#login">
           Identificación usuario existente
        </a>
      </h4>
    </div>
    <div id="login" class="panel-collapse collapse @if (!Session::has('mensaje_error')) in @endif">
      <div class="panel-body">
       {{ Form::open(array('url' => 'login', 'class' => 'form-signin', 'role'=>'form')) }}
 
    {{ Form::email('email','', array('class' => 'form-control', 'placeholder' => 'Correo electrónico' )); }} 
    {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Contraseña' )); }}
    {{ Form::submit('Ingresar', array('class' => 'btn btn-lg btn-primary btn-block'))}}
 
{{ Form::close() }}
      </div>
    </div>
  </div>
  <div class="panel panel-default" id="panel2">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-target="#registro" data-parent="#accordion"
           href="#registro" class="collapsed">
          Registro nuevo usuario
        </a>
      </h4>
    </div>
    <div id="registro" class="panel-collapse collapse @if (Session::has('mensaje_error')) in @endif ">
      <div class="panel-body">
      
      <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
      </ul>
      
        {{ Form::open(array('url' => 'registro','class' => 'form-horizontal', 'role'=> 'form')) }}
    <div class="form-signin">
    {{ Form::label('nombre', 'Nombre:', array('class' => 'control-label')); }}
    {{ Form::text('nombre', '' , array('class' => 'form-control')); }}
    {{ Form::label('apellido', 'Apellido:', array('class' => 'control-label')); }}
    {{ Form::text('apellido', '', array('class' => 'form-control')); }}
    {{ Form::label('email', 'Correo:', array('class' => 'control-label')); }}
    {{ Form::email('email', '', array('class' => 'form-control')); }}
    {{ Form::label('password','Contraseña:', array('class' => 'control-label')); }} 
    {{ Form::password('password', array('class' => 'form-control')); }}
    {{ Form::label('password-confirmation','Confirmar contraseña:', array('class' => 'control-label')); }} 
    {{ Form::password('password_confirmation', array('class' => 'form-control')); }}
    {{ Form::submit('Registrar', array('class' => 'btn btn-lg btn-success')); }}
    </div>
{{ Form::close() }}
      </div>
    </div>
  </div>
</div>


@stop