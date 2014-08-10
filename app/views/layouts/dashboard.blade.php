<!doctype html>
<html lang="es_CL">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>iMed - Dashboard - @yield('title')</title>
    {{ HTML::style('assets/css/bootstrap.min.css') }}

    {{ HTML::style('assets/css/dashboard.css') }}
    {{ HTML::style('assets/css/offcanvas.css') }}
    {{ HTML::style('assets/css/magicsuggest-min.css') }}
    {{ HTML::style('assets/css/navbar.css') }}
    {{ HTML::style('assets/css/spinner.css') }}
    {{ HTML::style('assets/css/bootstrap-tour.min.css') }}
    {{ HTML::style('assets/css/bootstrap-tour.fixer.css') }}
    {{ HTML::style('assets/css/bootstrap-dialog.css') }}    
    {{ HTML::style('assets/css/datepicker3.css') }}  
    @yield('extra-css')
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
  <div class="container">
    
      <div class="col-md-12">
        @include('navbars.navBar')
        @yield('modal')
      </div>
      <div class="col-md-12">
        <div class="row row-offcanvas row-offcanvas-left">
          <div id="functions" class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="list-group">

              @yield('function')

            </div>
          </div>
          <div id="mainContainer" class="col-xs-12 col-sm-9">
            @yield('section')
          </div>
        </div>
      </div>
  
      

    <div class="col-md-12">
        <hr>
      @include('footer.footer')
    </div>
  </div>
<!-- scripts -->
{{ HTML::script('assets/js/jquery-1.11.0.min.js') }}
{{ HTML::script('assets/js/jquery.cookie.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
{{ HTML::script('assets/js/offcanvas.js') }}
{{ HTML::script('assets/js/spin.min.js') }}
{{ HTML::script('assets/js/magicsuggest-min.js') }}
  <!-- arriba o abjo?-->
{{ HTML::script('assets/js/hospitalLoadings.js') }}
{{ HTML::script('assets/js/bootbox.min.js') }}
{{ HTML::script('assets/js/bootstrap-tour.min.js') }}
{{ HTML::script('assets/js/globalTourOptions.js') }}
{{ HTML::script('assets/js/bootstrap-dialog.js') }}
{{ HTML::script('assets/js/bootstrap-datepicker.js') }}
  {{ HTML::script('assets/js/locales/bootstrap-datepicker.es.js') }}
<script src="/assets/js/docs.min.js"></script>
@yield('extra-js')
  
<!-- scripts -->  
</body>
</html>