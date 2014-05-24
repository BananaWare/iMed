<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      @if(Request::is('dashboard*'))
      <button type="button" class="navbar-toggle pull-left sidebar-button" data-toggle="offcanvas" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>  
      @endif
      <a class="navbar-brand" href="/">iMed</a>
    </div>

    <div class="navbar-collapse collapse">
      @if(Auth::check())
      <!--<div id="hospitalsContainer">
        <div id="selectHospitalComboBox" class="navbar-right"></div>
      </div>-->
      <ul class="nav navbar-nav">
        <li class="active">
          <a href="/dashboard">Mi Escritorio</a>
        </li>
      </ul>
      <form id="hospitalsFormContainer" class="navbar-form navbar-left" role="form">
        <div id="selectHospitalComboBox"></div>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown dropdown-toggle" data-toggle="dropdown" href="#">
            {{ Auth::user()->name }}
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a href="#">
                <span class="glyphicon glyphicon-user">
                </span>
                Mi perfil</a>
            </li>
            <li>
              <a href="/logout">                            
                <span class="glyphicon glyphicon-log-out">
                </span>
                Cerrar sesión
              </a>
            </li>
          </ul>
        </li>  
      </ul>
      @else
      <form class="navbar-form navbar-right" role="form" method="POST" action="/signin">
        @if(Session::has('error_message'))
        <!--<div class="alert alert-danger">{{ Session::get('error_message') }}</div>-->
        <div class="form-group has-error has-feedback">
          @else
          <div class="form-group">
            @endif

            <input name="username" type="text" placeholder="RUT xxxxxxxx-x" class="form-control" required="required" pattern="\b\d{1,8}\-[K|k|0-9]" title="Por ejemplo 12123123-3">

          </div>
          @if(Session::has('error_message'))
          <div class="form-group has-error has-feedback">
            @else
            <div class="form-group">
              @endif
              <input name="password" type="password" placeholder="Contraseña" class="form-control" required="required">

            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
          </div></div>
            </form>
          @endif
        </div>
        </div>
    </div>