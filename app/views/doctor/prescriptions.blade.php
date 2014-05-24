@section('extra-css')
  {{ HTML::style('assets/css/customTables.css') }}
  {{ HTML::style('assets/css/dataTables.bootstrap.css') }}
  {{ HTML::style('assets/css/prescriptions.css') }}
@stop()

@section('section')
<div class="row">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          <span class="glyphicon glyphicon-home"></span>
          Selecciona algún paciente
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        <div id="selectPatientCombo"></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          <span class="glyphicon glyphicon-home"></span>
          Antecedentes del paciente
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in">
      <div class="panel-body">
        <table class="table">
          <thead>
            <tr>
              <th colspan="2"><h4><strong>Datos personales</strong></h4></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Rut</strong></td>
              <td id="trut" class="rut"></td>
            </tr>
            <tr>
              <td><strong>Nombre</strong></td>
              <td id="tfullName" class="fullName"></td>
            </tr>
            <tr>
              <td><strong>Edad</strong></td>
              <td id="tage" class="birthdate"></td>
            </tr>
          </tbody>
        </table>
        <table class="table">
          <thead>
            <tr>
              <th colspan="2"><h4><strong>Antecedentes médicos</strong></h4></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Reacción adversa a medicamentos</strong></td>
              <td id="tadr" class="adr"></td>
            </tr>
            <tr>
              <td><strong>Mórbidos</strong></td>
              <td id="tmorbid" class="morbid"></td>
            </tr>
            <tr>
              <td><strong>Ginecológicos</strong></td>
              <td id="tgynecological" class="gynecological"></td>
            </tr>
            <tr>
              <td><strong>Familiares</strong></td>
              <td id="tfamily" class="family"></td>
            </tr>
            <tr>
              <td><strong>Hábitos</strong></td>
              <td id="thabit" class="habit"></td>
            </tr>
            <tr>
              <td><strong>Otros</strong></td>
              <td id="tother" class="other"></td>
            </tr>
          </tbody>
        </table>
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
          Fichas del paciente
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover" id="medicalSheetsTable">
            <!-- .danger si una enfermera esta deshabilitada -->
            <thead align="center">
              <tr>
                <th class="tdateHidden"></th>
                <th class="tdate">Fecha visita</th>
                <th class="tobs">Observación</th>
                <th class="tprescription">Visita médica</th>
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
<div class="modal fade" id="seeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="seeDetailsModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <!--<h4 class="modal-title" id="myModalLabel">Detalle del paciente y la visita</h4>-->
      </div>
      <div class="modal-body">
        <!-- Panel group -->
        <div class="panel-group" id="accordion">
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                  <h4>
                    <span class="glyphicon glyphicon-tag"></span>
                    <strong>Diagnóstico</strong>
                  </h4>
                  <span id="diagnosticStepFeedback" class="glyphicon pull-right"></span>
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse in">
              <div class="panel-body">
                <h4><span id="tdiagnostic" class="diagnostic label label-warning"></span></h4>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                  <h4>
                    <span class="glyphicon glyphicon-heart-empty"></span>
                    <strong>Exámenes</strong>
                  </h4>
                  <span id="selectPatientStepFeedback" class="glyphicon pull-right"></span>
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
              <div class="panel-body">
                <table class="table">
                  <thead>
                    <!--
                    <tr>
                      <th colspan="2"><h4><strong></strong></h4></th>
                    </tr>
                    -->
                  </thead>
                  <tbody>
                    <tr>
                      <td><strong>General</strong></td>
                      <td id="tgeneral" class="general"></td>
                    </tr>
                    <tr>
                      <td><strong>Presión Arterial</strong></td>
                      <td id="tbloodPressure" class="bloodPressure"></td>
                    </tr>
                    <tr>
                      <td><strong>Temperatura</strong></td>
                      <td id="ttemperature" class="temperature"></td>
                    </tr>
                    <tr>
                      <td><strong>SAT</strong></td>
                      <td id="tsat" class="sat"></td>
                    </tr>
                    <tr>
                      <td><strong>Segmentario</strong></td>
                      <td id="tsegmentary" class="segmentary"></td>
                    </tr>
                    <tr>
                      <td><strong>Complementarios</strong></td>
                      <td id="tcomplementary" class="complementary"></td>
                    </tr>
                  </tbody>
                </table>                
              </div>
            </div>
          </div>
        </div>
        <div class="panel-group" id="accordion">
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                  <h4>
                    <span class="glyphicon glyphicon-list-alt"></span>
                    <strong>Receta</strong>
                  </h4>
                  <span id="selectPatientStepFeedback" class="glyphicon pull-right"></span>
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse in">
              <div class="panel-body">
                <div id="table-responsive" class="table-responsive">
                  <table id="drugsPrescriptionsTable" class=" table-bordered table">
                    <thead>
                      <!--<tr>
                        <th><h4><strong>Receta</strong></h4></th>
                      </tr>-->
                      <tr>
                        <th><strong>Medicamento</strong></th>
                        <th><strong>Dosis</strong></th>
                        <th><strong>Intervalos de tiempo</strong></th>
                        <th><strong>Duración en tiempo</strong></th>
                        <th><strong>Observación</strong></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="createPatientAccept">Crear paciente</button>
      </div>
    </div>
  </div>
</div>

@stop()
@section('extra-js')
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/jquery.dataTables.min.js') }}
{{ HTML::script('assets/js/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/prescriptions.js') }}

@stop()