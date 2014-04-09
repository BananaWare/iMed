<!doctype html>
<html lang="es_CL">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    {{ HTML::style('assets/css/bootstrap.min.css') }}

    {{ HTML::style('assets/css/dashboard.css') }}
    {{ HTML::style('assets/css/navBar.css') }}
    {{ HTML::style('assets/css/offcanvas.css') }}
  
    @yield('extra-css')
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>

  @yield('header')
  @yield('modal')
  <div class="container">
    <div class="row row-offcanvas row-offcanvas-left">
      <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
        <div class="list-group">
          <!--<a href="#" class="list-group-item {{ Request::is('secretary*') ? 'active' : '' }}"></a>-->
          
          @yield('function')

        </div>
      </div><!--/span-->
      <div class="col-xs-12 col-sm-9">
        @yield('section')
      </div><!--/span-->
    </div>
  </div>
  
      
  <hr>
  @include('footer.footer')

<!-- scripts -->
{{ HTML::script('assets/js/jquery-1.11.0.min.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
{{ HTML::script('assets/js/offcanvas.js') }}
<script src="/assets/js/docs.min.js"></script>
@yield('extra-js')
<!-- scripts -->  
</body>
</html>