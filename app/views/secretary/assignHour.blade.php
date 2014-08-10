@section('title', 'Asignar Hora')

@section('extra-css')
    {{ HTML::style('assets/css/fullcalendar.css') }}
    {{-- HTML::style('assets/css/fullcalendar.print.css') --}}
    {{ HTML::style('assets/css/jquery-ui.min.css') }}
{{ HTML::style('assets/css/assignHour.css') }}
@stop()

@section('section')
@if ($role == 'secretary')
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
@endif
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
          <button class='btn btn-primary' style="display:none;" onclick="addExtraHour()" id="addExtraHourButton">Agregar nuevo bloque horario al final</button>
        </div>
      </div>
    </div>
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
          <h4><strong id="dateTimeFormatted" class="ahDateTime">Fecha hora</strong></h4>
          <div id="selectPatientCombo"></div>
          <input id="startHour" name="startHour" type="hidden">
          <input id="endHour" name="endHour" type="hidden">
        </div>
      </div>
      <!-- Panels group -->
      <div class="modal-footer">
        <a id="createPatientButton" class="btn btn-info pull-left">Crear paciente</a>
          
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="assignHourAccept">Asignar hora</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirmHourModal" tabindex="-1" role="dialog" aria-labelledby="confirmHourModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">¿Desea confirmar o eliminar la hora asignada?</h4>
      </div>
      <div class="modal-body">
        <!-- Panel group -->
        <div class="panel-group" id="accordion">
          <table class="table">
            <thead>
              <tr>
                <th colspan="2">
                  <h4><strong id="ahDateTime" class="ahDateTime">Fecha hora</strong></h4>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Nombre paciente</strong></td>
                <td id="ahName" class="ahName"></td>
              </tr>
              <tr>
                <td><strong>Rut paciente</strong></td>
                <td id="ahRut" class="ahRut"></td>
              </tr>
              <tr>
                <td><strong>Estado hora</strong></td>
                <td id="ahState" class="ahState"></td>
              </tr>
              <tr>
                <td><strong>Asignada por</strong></td>
                <td id="ahAssignBy" class="ahAssignBy"></td>
              </tr>
            </tbody>
          </table>    
          <input id="idPatientHourSelected" name="idPatientHourSelected" type="hidden">
        </div>
      </div>
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="revokeHourAccept">Eliminar hora</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" id="confirmHourAccept">Confirmar hora</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addExtraHourModal" z-index:-1 role="dialog" aria-labelledby="addExtraHourModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Agregar nuevo bloque</h4>
      </div>
      <div class="modal-body">
        ¿Está seguro de que desea agregar un nuevo bloque horario a este día de trabajo?
      </div>
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="addExtraHourAccept">Aceptar</button>
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
{{ HTML::script('assets/js/datePickerBugFixer.js') }}
@stop()