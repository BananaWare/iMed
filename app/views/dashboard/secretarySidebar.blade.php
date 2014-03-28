@section('function')

<a href="#" class="list-group-item {{ Request::is('profile*') ? 'active': '' }}">Pacientes</a>
  <a href="/secretary/assignhour" class="list-group-item {{ Request::is('secretary/assignhour') ? 'active' : '' }}">Asignar hora</a>

@stop