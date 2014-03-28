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
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>

  @yield('header')
  
  <div class="container">
    <div class="row row-offcanvas row-offcanvas-left">
      <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
        <div class="list-group">
          <!--<a href="#" class="list-group-item {{ Request::is('secretary*') ? 'active' : '' }}"></a>-->
          
          @yield('function')

        </div>
      </div><!--/span-->
      <div class="col-xs-12 col-sm-9">
        <div class="jumbotron">
          <h1>Hello, world!</h1>
          <p>This is an example to show the potential of an offcanvas layout pattern in Bootstrap. Try some responsive-range viewport sizes to see it in action.</p>
        </div>
        <div class="row">
          <div class="col-6 col-sm-6 col-lg-4">
            <h2>Heading</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
          </div><!--/span-->
          <div class="col-6 col-sm-6 col-lg-4">
            <h2>Heading</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
          </div><!--/span-->
          <div class="col-6 col-sm-6 col-lg-4">
            <h2>Heading</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
          </div><!--/span-->
          <div class="col-6 col-sm-6 col-lg-4">
            <h2>Heading</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
          </div><!--/span-->
          <div class="col-6 col-sm-6 col-lg-4">
            <h2>Heading</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
          </div><!--/span-->
          <div class="col-6 col-sm-6 col-lg-4">
            <h2>Heading</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
          </div><!--/span-->
        </div><!--/row-->
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
<!-- scripts -->  
</body>
</html>