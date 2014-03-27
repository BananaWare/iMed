@section('section')
    <div class="container">
      @if(Session::has('error_message'))
            <div class="alert alert-danger">{{ Session::get('error_message') }}</div>
            <form class="form-signin" role="form" method="POST" action="/login">
              <h2 class="form-signin-heading">Por favor inicia sesión</h2>
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
            <form class="form-signin" role="form" method="POST" action="/login">
              <h2 class="form-signin-heading">Por favor inicia sesión</h2>
              <div class="form-group">
                <input name="username" type="text" placeholder="RUT xx.xxx.xxx-x" class="form-control">
              </div>
              <div class="form-group">
                <input name="password" type="password" placeholder="Contraseña" class="form-control">
              </div>
              <button type="submit" class="btn btn-success">Iniciar sesión</button>
            </form>
      @endif
    </div> <!-- /container -->
@stop()