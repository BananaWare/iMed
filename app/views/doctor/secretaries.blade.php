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
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="secretariesTable">
              <!-- .danger si una enfermera esta deshabilitada -->
              <thead align="center">
                <tr>
                  <td class="tname">Nombre</td>
                  <td class="trut">Rut</td>
                  <td class="tunassign">Deshabilitar</td>
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
{{ HTML::script('assets/js/jquery-ui.custom.min.js') }}
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/fullcalendar.min.js') }}
{{ HTML::script('assets/js/lang/es.js') }}
{{ HTML::script('assets/js/magicsuggest-1.3.1-min.js') }}
{{ HTML::script('assets/js/secretaries.js') }}

@stop()