@section('function')

<a href="/dashboard/secretary/patients" class="list-group-item {{ Request::is('*patients') ? 'active': '' }}"><span class="glyphicon glyphicon-user"></span> Pacientes</a>
<a href="/dashboard/secretary/assignHour" class="list-group-item {{ Request::is('*assignHour') ? 'active' : '' }}"><span class="glyphicon glyphicon-calendar"></span> Asignar hora</a>

@stop