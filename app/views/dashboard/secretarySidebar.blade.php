@section('function')

<a href="/secretary/patients" class="list-group-item {{ Request::is('profile*') ? 'active': '' }}"><span class="glyphicon glyphicon-user"></span> Pacientes</a>
<a href="/secretary/assignhour" class="list-group-item {{ Request::is('profile*') ? 'active' : '' }}"><span class="glyphicon glyphicon-calendar"></span> Asignar hora</a>

@stop