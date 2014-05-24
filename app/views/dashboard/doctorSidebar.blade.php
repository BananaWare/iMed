@section('function')

<a href="/dashboard/doctor/secretaries" class="list-group-item {{ Request::is('*secretaries') ? 'active': '' }}"><span class="glyphicon glyphicon-list"></span> Secretarias</a>
<a href="/dashboard/doctor/patients" class="list-group-item {{ Request::is('*patients') ? 'active': '' }}"><span class="glyphicon glyphicon-user"></span> Pacientes</a>
<a href="/dashboard/doctor/assignHour" class="list-group-item {{ Request::is('*assignhour') ? 'active' : '' }}"><span class="glyphicon glyphicon-calendar"></span> Asignar hora</a>
<a href="/dashboard/doctor/prescriptions" class="list-group-item {{ Request::is('*prescriptions') ? 'active' : '' }}"><span class="glyphicon glyphicon-list-alt"></span> Recetar</a>

@stop