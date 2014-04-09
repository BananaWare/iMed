@section('header')
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">iMed</a>
        </div>

        <div class="collapse navbar-collapse navbar-right">
          <a href="/dashboard" class="btn btn-primary navbar-btn pull-left">Mi Escritorio</a>
          @if(Auth::check())
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

          @else
          <a href="/signin" class="btn btn-primary navbar-btn">Iniciar sesión</a>
          @endif
        </div>
      </div>
    </div>
@stop()