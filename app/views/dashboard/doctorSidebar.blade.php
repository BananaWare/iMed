@section('function')

<a id="secretariesSideBar" href="/dashboard/doctor/secretaries" class="list-group-item {{ Request::is('*secretaries') ? 'active': '' }}"><span class="glyphicon glyphicon-list"></span> Secretarias</a>
<a id="patientsSideBar" href="/dashboard/doctor/patients" class="list-group-item {{ Request::is('*patients') ? 'active': '' }}"><span class="glyphicon glyphicon-user"></span> Pacientes</a>
<a id="assignHourSideBar" href="/dashboard/doctor/assignHour" class="list-group-item {{ Request::is('*assignHour') ? 'active' : '' }}"><span class="glyphicon glyphicon-calendar"></span> Asignar hora</a>
<a id="prescripciontsSideBar" href="/dashboard/doctor/prescriptions" class="list-group-item {{ Request::is('*prescriptions') ? 'active' : '' }}"><span class="glyphicon glyphicon-list-alt"></span> Recetar</a>
<a id="schedulesSideBar" href="/dashboard/doctor/schedules" class="list-group-item {{ Request::is('*schedules') ? 'active' : '' }}"><span class="glyphicon glyphicon-briefcase"></span> Horarios</a>
<a id="billingsSideBar" href="/dashboard/doctor/billings" class="list-group-item {{ Request::is('*billings') ? 'active' : '' }}"><span class="glyphicon glyphicon-pushpin"></span> Pagos</a>
@stop
