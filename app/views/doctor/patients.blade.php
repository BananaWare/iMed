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
            <span class="glyphicon glyphicon-home"></span>
            Activar secretaria
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
           <input id="patientsRutInput" type="text" class="form-control"/>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-home"></span>
            Lista de sus secretarias
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="patientsTable">
              <!-- .danger si una enfermera esta deshabilitada -->
              <thead align="center">
                <tr>
                  <td class="tname">Nombre</td>
                  <td class="trut">Rut</td>
                  <td class="tage">Edad</td>
                  <td class="temail">Email</td>
                  <td class="tphone">Teléfono</td>
                  <td class="tcity">Ciudad</td>
                </tr>
              </thead>
              <tbody align="center">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@stop()

@section('modal')
<!-- Modal -->
<div class="modal fade" id="createPatientModal" tabindex="-1" role="dialog" aria-labelledby="createPatientModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Nuevo paciente</h4>
      </div>
      <div class="modal-body">
        <!-- Panel group -->
        <div class="panel-group" id="accordion">
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                  <span class="glyphicon glyphicon-user"></span>
                  Datos del paciente
                  <span id="selectPatientStepFeedback" class="glyphicon pull-right"></span>
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
              <div class="panel-body">
                <input type="text" id="rut" placeholder="Rut" class="form-control">
                <input type="text" id="name" placeholder="Nombre" class="form-control">
                <input type="text" id="lastname" placeholder="Apellido" class="form-control">
                <input type="text" id="birthDate" placeholder="Fecha de nacimiento" class="form-control">
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                  <span class="glyphicon glyphicon-user"></span>
                  Datos de contacto
                  <span id="selectPatientStepFeedback" class="glyphicon pull-right"></span>
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
              <div class="panel-body">
                #Seleccionar paciente
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Crear paciente</button>
      </div>
    </div>
  </div>
</div>
@stop()

@section('extra-js')
{{ HTML::script('assets/js/jquery-ui.custom.min.js') }}
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/fullcalendar.min.js') }}
{{ HTML::script('assets/js/lang/es.js') }}
{{ HTML::script('assets/js/magicsuggest-1.3.1-min.js') }}
{{ HTML::script('assets/js/bootstrap-editable.min.js') }}
{{ HTML::script('assets/js/filterable-utils.js') }}
{{ HTML::script('assets/js/filterable-cell.js') }}
{{ HTML::script('assets/js/filterable-row.js') }}
{{ HTML::script('assets/js/filterable.js') }}
{{ HTML::script('assets/js/patients.js') }}
@stop()