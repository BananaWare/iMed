@section('extra-css')
    {{ HTML::style('assets/css/fullcalendar.css') }}
    {{-- HTML::style('assets/css/fullcalendar.print.css') --}}
    {{ HTML::style('assets/css/jquery-ui.min.css') }}
@stop()

@section('section')
<!--
  <div class="row">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-home"></span>
            Selecciona la consulta que desea administrar
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div id="selectHospitalCombo"></div>
        </div>
      </div>
    </div>
  </div>
-->
@if ($role == 'secretary')
  <div class="row">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-user"></span>
            Selecciona un doctor para ver su calendario
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div id="selectDoctorCombo"></div>
        </div>
      </div>
    </div>
  </div>
@endif
  <div class="row">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-calendar"></span>
            Calendario
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body" id="panel-calendar">
          <div id='calendar'></div>
        </div>
      </div>
    </div>
  </div><!--/row-->
@stop()

@section('modal')
<!-- Modal -->
<div class="modal fade" id="assignHourModal" tabindex="-1" role="dialog" aria-labelledby="assignHourModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Seleccione paciente o cree uno nuevo para asignar la hora</h4>
      </div>
      <div class="modal-body">
        <!-- Panel group -->
        <div class="panel-group" id="accordion">
          <div id="selectPatientCombo"></div>
          <a id="createPatientButton" class="btn btn-primary navbar-btn pull-right">Crear paciente</a>
          <input id="startHour" name="startHour" type="hidden">
          <input id="endHour" name="endHour" type="hidden">
        </div>
      </div>
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="assignHourAccept">Asignar hora</button>
      </div>
    </div>
  </div>
</div>
@include('common/createPatientModal')
@stop()

@section('extra-js')
{{ HTML::script('assets/js/jquery-ui.custom.min.js') }}
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/fullcalendar.js') }}
{{ HTML::script('assets/js/lang/es.js') }}
{{ HTML::script('assets/js/assignHour.js') }}

@stop()