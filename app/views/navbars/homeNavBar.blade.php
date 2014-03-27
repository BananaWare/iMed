@section('header')
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">iMed</a>
        </div>
        @if(Auth::check())   
          <div class="collapse navbar-collapse dropdown navbar-right">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a class="dropdown dropdown-toggle" data-toggle="dropdown" href="#">
                  {{ Auth::user()->name }}
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="#">Mi perfil</a>
                  </li>
                  <li>
                    <a href="/logout">Cerrar sesión</a>
                  </li>
                </ul>
              </li>  
            </ul>
          </div>
        @else
          <div class="navbar-collapse collapse">
          @if(Session::has('error_message'))
            
          <!--<div class="alert alert-danger">{{ Session::get('error_message') }}</div>-->
            <form class="navbar-form navbar-right" role="form" method="POST" action="/login">
              <div class="form-group has-error has-feedback">
                <input name="username" type="text" placeholder="RUT xx.xxx.xxx-x" class="form-control">
                <span class="help-inline glyphicon glyphicon-remove form-control-feedback"></span>
                </div>
              <div class="form-group has-error has-feedback">
                <input name="password" type="password" placeholder="Contraseña" class="form-control">
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </div>
              <button type="submit" class="btn btn-success">Iniciar sesión</button>
            </form>
          @else
            <form class="navbar-form navbar-right" role="form" method="POST" action="/login">
              <div class="form-group">
                <input name="username" type="text" placeholder="RUT xx.xxx.xxx-x" class="form-control">
              </div>
              <div class="form-group">
                <input name="password" type="password" placeholder="Contraseña" class="form-control">
              </div>
              <button type="submit" class="btn btn-success">Iniciar sesión</button>
            </form>
          @endif
          </div><!--/.navbar-collapse -->
        @endif
      </div>
    </div>
@stop()