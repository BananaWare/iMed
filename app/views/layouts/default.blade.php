<!doctype html>
<html lang="es_CL">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>iMed - @yield('title')</title>
    {{ HTML::style('assets/css/bootstrap.min.css') }}
    {{ HTML::style('assets/css/offcanvas.css') }}
  @if (!Request::is('/'))
    {{ HTML::style('assets/css/magicsuggest-min.css') }}
  @endif
    {{ HTML::style('assets/css/navbar.css') }}
  
    <!--{{ HTML::style('assets/css/form-signin.css') }}-->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    
  <div class="container">
    
    <div class="col-md-12">
      @include('navbars.navBar')
    </div>
  
    <div class="col-md-12">
      @yield('section')
    </div>
  
      

    <div class="col-md-12">
        <hr>
      @include('footer.footer')
    </div>
  </div>
<!-- scripts -->
{{ HTML::script('assets/js/jquery-1.11.0.min.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
  {{ HTML::script('assets/js/jquery.cookie.js') }}
<!-- Si no estamo en el '/' -->
@if (!Request::is('/'))
  {{ HTML::script('assets/js/magicsuggest-min.js') }}
  {{ HTML::script('assets/js/hospitalLoadings.js') }}
@endif
<script src="/assets/js/docs.min.js"></script>
<!-- scripts -->  
</body>
</html>