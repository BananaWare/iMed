<!doctype html>
<html lang="es_CL">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    {{ HTML::style('assets/css/bootstrap.min.css') }}
    
    {{ HTML::style('assets/css/navBar.css') }}
    {{ HTML::style('assets/css/form-signin.css') }}
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    @yield('header')
    

    @yield('section')
       
      <hr>
    @include('footer.footer')


<!-- scripts -->
{{ HTML::script('assets/js/jquery-1.11.0.min.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
<script src="/assets/js/docs.min.js"></script>
<!-- scripts -->  
</body>
</html>