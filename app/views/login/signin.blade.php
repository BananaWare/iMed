<!doctype html>
<html lang="es_CL">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    {{ HTML::style('assets/css/bootstrap.css') }}
    
    {{ HTML::style('assets/css/bootstrap-theme.css') }}
    {{ HTML::style('assets/css/form-signin.css') }}
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <div class="container">
            <form class="form-signin" role="form" method="POST" action="/signin">
              <h2 class="form-signin-heading">Please sign in</h2>
              @if(Session::has('error_message'))
                <div class="alert alert-danger">{{ Session::get('error_message') }}</div>
                <div class="form-group has-error has-feedback">
              @else
                <div class="form-group">
              @endif

                  <input name="username" type="text" placeholder="RUT xxxxxxxx-x" class="form-control" required="required" pattern="\b\d{1,12}\-[K|k|0-9]" title="Por ejemplo 12123123-3">

              </div>
              @if(Session::has('error_message'))
                <div class="form-group has-error has-feedback">
              @else
                <div class="form-group">
              @endif
                  <input name="password" type="password" placeholder="Contraseña" class="form-control" required="required">

              </div>
              <button type="submit" class="btn btn-lg btn-primary btn-block">Iniciar sesión</button>
            </form>
    </div> <!-- /container -->
<!-- scripts -->
{{ HTML::script('assets/js/jquery-1.11.0.min.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
<script src="/assets/js/docs.min.js"></script>
<!-- scripts -->  
</body>
</html>
