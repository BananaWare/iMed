@section('header')

<div class="navbar-wrapper">
      <div class="container">

  <nav class="navbar navbar-custom navbar-inverse" role="navigation">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">iMed</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
            
            @if(Auth::check())   
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <button href="#" class="btn btn-primary navbar-btn dropdown-toggle" data-toggle="dropdown">
                      <span>
                          {{ Auth::user()->names }}
                      </span><span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">
                        <span>
                            <span class="glyphicon glyphicon-log-out"></span>
                        Mi perfil
                        </span></a></li>
                    <li class="divider"></li>
                    <li><a href="/logout">
                        <span class="glyphicon glyphicon-log-out"></span> Cerrar sesión
                        </a>
                    </li>
    
                  </ul>
                </li>
              </ul>
            @else
                    <ul class="nav navbar-nav navbar-right">
                      <li class="dropdown" id="menuLogin">
                        <button class="btn btn-default navbar-btn dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">Iniciar                                        sesión
                        <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu" style="padding:17px;">
                            {{-- Preguntamos si hay algún mensaje de error y si hay lo mostramos  --}}
                            @if(Session::has('error_message'))
                                <div class="alert alert-danger">{{ Session::get('error_message') }}</div>
                            @endif
                            {{ Form::open(array('url' => '/login', 'method' => 'POST')) }}
                                <div class="form-group">
                                    {{ Form::label('usuario', 'RUT') }}
                                    {{ Form::text('username', Input::old('username'), array('class' => 'form-control')); }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('contraseña', 'Contraseña') }}
                                    {{ Form::password('password', array('class' => 'form-control')); }}
                                </div>
                                <div class="checkbox">
                                    <label>
                                        Recordar
                                        {{ Form::checkbox('rememberme', true) }}
                                    </label>
                                </div>
                                {{ Form::submit('Iniciar sesión', array('class' => 'btn btn-primary')) }}
                            {{ Form::close() }}
                        </div>
                      </li>
                    </ul>
            @endif
            

            
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

@stop()