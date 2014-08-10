@section('title', 'Prescripciones')

@section('extra-css')
  {{ HTML::style('assets/css/customTables.css') }}
  {{ HTML::style('assets/css/dataTables.bootstrap.css') }}
  {{ HTML::style('assets/css/prescriptions.css') }}
@stop()

@section('section')
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
          <span class="glyphicon glyphicon-user"></span>
          Selecciona algún paciente
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        <div id="selectPatientCombo"></div>
      </div>
    </div>
  </div>

  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
          <span class="glyphicon glyphicon-list-alt"></span>
          Antecedentes del paciente
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

  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
          <span class="glyphicon glyphicon-list-alt"></span>
          Fichas del paciente
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

@stop()

@section('modal')
<!-- Modal -->
<div class="modal fade" id="seeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="seeDetailsModal" aria-hidden="true">
  <div class="modal-dialog modal-primary">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">
          Visita del paciente
        </h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h4 class="panel-title">
                    <h4>
                      <span class="glyphicon glyphicon-tag"></span>
                      <strong>Diagnóstico</strong>
                    </h4>
                </h4>
              </div>
              <div class="panel-body">
                <h4><span id="tdiagnostic" class="diagnostic label label-warning"></span></h4>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h4 class="panel-title">
                    <h4>
                      <span class="glyphicon glyphicon-heart-empty"></span>
                      <strong>Exámenes</strong>
                    </h4>
                </h4>
              </div>
              <div class="panel-body">
                <table class="table">
                  <thead>

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
                    <tr>
                      <td><strong>Observación</strong></td>
                      <td id="tobservation" class="observation"></td>
                    </tr>
                  </tbody>
                </table>                
              </div>
            </div>    
          </div>
          
          <div class="col-md-12">
            <div class="panel panel-primary col-md-12">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <span class="glyphicon glyphicon-list-alt"></span>
                  <strong>Receta</strong>
                  <a>
                    <a id="printPresciption" class="pull-right glyphicon glyphicon-print">
                    </a>
                  </a>            
                </h4>
              </div>
              <div class="panel-body">
                <div id="prescriptionTable" class="table-responsive">
                  <table id="drugsPrescriptionsTable" class=" table-bordered table">
                    <thead>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="closeButton" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- create prescription Modal -->
<div class="modal fade" id="createPrescriptionModal" tabindex="-1" role="dialog" aria-labelledby="createPrescriptionModal" aria-hidden="true">
  <div class="modal-dialog modal-primary">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">
          Ingresar información del paciente
        </h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h4 class="panel-title">
                    <h4>
                      <span class="glyphicon glyphicon-list-alt"></span>
                      <strong>Antecedentes médicos históricos</strong>
                    </h4>
                </h4>
              </div>
              <div class="panel-body">
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="control-label col-sm-3">Reacciones adversas a medicamentos</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpAdr">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Mórbidos</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpMorbid">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Ginecológicos</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpGynecological">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Familiares</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpFamily">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Hábitos</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpHabit">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Otros</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpOther">
                    </div>
                  </div>
                </div>
              </div>
            </div>    
          </div>
          
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h4 class="panel-title">
                    <h4>
                      <span class="glyphicon glyphicon-heart-empty"></span>
                      <strong>Exámenes</strong>
                    </h4>
                </h4>
              </div>
              <div class="panel-body">
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="control-label col-sm-3">General</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpGeneral">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Presión Arterial</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpBloodPressure">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Temperatura</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpTemperature">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">SAT</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpSat">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Segmentario</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpSegmentary">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Complementario</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpComplementary">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Observación</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpSheetObservation">
                    </div>
                  </div>
                </div>
                
              </div>
            </div>    
          </div>
          
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h4 class="panel-title">
                    <h4>
                      <span class="glyphicon glyphicon-tag"></span>
                      <strong>Diagnóstico</strong>
                    </h4>
                </h4>
              </div>
              <div class="panel-body">
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="control-label col-sm-3">Diagnóstico</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control cpDiagnostic">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-12">
            <div class="panel panel-primary col-md-12">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <span class="glyphicon glyphicon-list-alt"></span>
                  <strong>Receta</strong>
                  <a>
                    <a id="printPresciption" class="pull-right glyphicon glyphicon-print">
                    </a>
                  </a>            
                </h4>
              </div>
              <div class="panel-body">
                <div class="form-group" hidden="hidden">
                  <label class="control-label col-sm-3">Medicamento</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control cpIdDrug">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3">Medicamento</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control cpBruteDrugName">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3">Dosis</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control cpDosage">
                   </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3">Intervalos de tiempo</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control cpIntervalTime">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3">Duración del tratamiento</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control cpTerm">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3">Observación</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control cpDrugObservation">
                  </div>
                </div>
                <button class="btn btn-primary" id="addDrugButton">Agregar medicamento a receta</button>
                
                <div id="prescriptionTable" class="table-responsive">
                  <table id="createDrugsPrescriptionsTable" class=" table-bordered table">
                    <thead>
                      <tr>
                        <th><strong>Medicamento</strong></th>
                        <th><strong>Dosis</strong></th>
                        <th><strong>Intervalos de tiempo</strong></th>
                        <th><strong>Duración en tiempo</strong></th>
                        <th><strong>Observación</strong></th>
                        <th><strong>Acción</strong></th>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="saveAllButton">Almacenar todo para siempre</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmPrescriptionModal" z-index:-1 role="dialog" aria-labelledby="confirmPrescriptionModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Confirmar receta</h4>
      </div>
      <div class="modal-body">
        <span>¿Está seguro de que desea almacenar estos datos de visita y esta receta? Una vez almacenados  <strong> no se pueden borrar.</strong></span>
      </div>
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="confirmPrescriptionAccept">Aceptar</button>
      </div>
    </div>
  </div>
</div>
@stop()
@section('extra-js')
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/jquery.dataTables.min.js') }}
{{ HTML::script('assets/js/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/jspdf.min.js') }}

{{ HTML::script('assets/js/prescriptions.js') }}

@stop()