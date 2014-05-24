@section('extra-css')
  {{ HTML::style('assets/css/fullcalendar.css') }}
  {{ HTML::style('assets/css/customTables.css') }}
  {{ HTML::style('assets/css/dataTables.bootstrap.css') }}
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
           <input id="secretarysRutInput" type="text" class="form-control"/>
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
          <div id="table-responsive" class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="secretariesTable">
              <!-- .danger si una enfermera esta deshabilitada -->
              <thead align="center">
                <tr>
                  <th class="tname">Nombre</th>
                  <th class="trut">Rut</th>
                  <th class="tage">Edad</th>
                  <th class="temail">Email</th>
                  <th class="tphone">Teléfono</th>
                  <th class="tcity">Ciudad</th>
                  <th class="tunassign">Quitar secretaria</th>
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

@section('extra-js')
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/fullcalendar.min.js') }}
{{ HTML::script('assets/js/lang/es.js') }}
{{ HTML::script('assets/js/jquery.dataTables.min.js') }}
{{ HTML::script('assets/js/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/secretaries.js') }}

@stop()