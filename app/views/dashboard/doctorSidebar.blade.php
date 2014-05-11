@section('function')

<a href="/doctor/secretaries" class="list-group-item {{ Request::is('profile*') ? 'active': '' }}"><span class="glyphicon glyphicon-list"></span> Secretarias</a>
<a href="/doctor/patients" class="list-group-item {{ Request::is('profile*') ? 'active': '' }}"><span class="glyphicon glyphicon-user"></span> Pacientes</a>
<a href="/doctor/assignhour" class="list-group-item {{ Request::is('profile*') ? 'active' : '' }}"><span class="glyphicon glyphicon-calendar"></span> Asignar hora</a>

@stop