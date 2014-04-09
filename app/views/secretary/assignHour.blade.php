@section('extra-css')
    {{ HTML::style('assets/css/fullcalendar.css') }}
    {{-- HTML::style('assets/css/fullcalendar.print.css') --}}
    {{ HTML::style('assets/css/jquery-ui.min.css') }}
    {{ HTML::style('assets/css/magicsuggest-1.3.1-min.css') }}
@stop()

@section('section')
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
        <div class="panel-body">
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
        <h4 class="modal-title" id="myModalLabel">Asignar hora</h4>
      </div>
      <div class="modal-body">
        <!-- Panel group -->
        <div class="panel-group" id="accordion">
          <div class="panel panel-warning">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                  <span class="glyphicon glyphicon-user"></span>
                  Selecciona un paciente
                  <span id="selectPatientStepFeedback" class="glyphicon glyphicon-exclamation-sign pull-right"></span>
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
              <div class="panel-body">
                #Seleccionar paciente
              </div>
            </div>
          </div>
          <div class="panel panel-warning">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                  <span class="glyphicon glyphicon-user"></span>
                  Otra etapa
                  <span id="selectPatientStepFeedback" class="glyphicon glyphicon-exclamation-sign pull-right"></span>
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
              <div class="panel-body">
              #otra etapa
              </div>
            </div>
          </div>
          <div class="panel panel-warning">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                  <span class="glyphicon glyphicon-list-alt "></span>
                  Añade información extra
                  <span id="extraInfStepFeedback" class="glyphicon glyphicon-exclamation-sign pull-right pull-right"></span>
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
              <div class="panel-body">
              #Añade información extra 
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Asignar hora</button>
      </div>
    </div>
  </div>
</div>
@stop()

@section('extra-js')
{{ HTML::script('assets/js/jquery-ui.custom.min.js') }}
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/fullcalendar.js') }}
{{ HTML::script('assets/js/lang/es.js') }}
{{ HTML::script('assets/js/magicsuggest-1.3.1-min.js') }}
{{ HTML::script('assets/js/assignHour.js') }}

@stop()