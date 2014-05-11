@section('extra-css')
    {{ HTML::style('assets/css/fullcalendar.css') }}
    {{-- HTML::style('assets/css/fullcalendar.print.css') --}}
    {{ HTML::style('assets/css/jquery-ui.min.css') }}
    {{ HTML::style('assets/css/magicsuggest-1.3.1-min.css') }}
    {{ HTML::style('assets/css/jquery.dataTables.css') }}
    {{ HTML::style('assets/css/jquery.dataTables_theme.css') }}
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
            Nuevo paciente
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
            Lista de pacientes
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="patientsTable">
              <thead align="center">
                <tr>
                  <th class="tname">Nombre</th>
                  <th class="trut">Rut</th>
                  <th class="tage">Edad</th>
                  <th class="temail">Email</th>
                  <th class="tphone">Teléfono</th>
                  <th class="tcity">Ciudad</th>
                  <th class="tactions">Acciones</th>
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

@section('contentModal')
<div class="modal-body">
  <!-- Panel group -->
  <div class="panel-group" id="accordion">
    <div class="panel">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-user"></span>
            Paciente
            <span id="selectPatientStepFeedback" class="glyphicon pull-right"></span>
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class="personal-errors">
          </div>
          <input type="text" placeholder="Rut" class="form-control rut">
          <input type="text" placeholder="Nombre" class="form-control name">
          <input type="text" placeholder="Apellido" class="form-control lastname">
          <input type="date" placeholder="Fecha de nacimiento" class="form-control birthdate">
          <div class="btn-group"  data-toggle="buttons">
            <label class="btn btn-primary">
              <input type="radio" name="gender" value="male" class="form-control genderMale">Masculino<br>
            </label>
            <label class="btn btn-primary">
              <input type="radio" name="gender" value="female" class="form-control genderFemale">Femenino<br>
            </label>
          </div>
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
          <div class="contact-errors">
          </div>
          <input type="text" placeholder="Email" class="form-control email">
          <input type="text" placeholder="Teléfono" class="form-control phone">
          <input type="text" placeholder="Ciudad" class="form-control city">
          <input type="text" placeholder="Dirección" class="form-control address">
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
      @yield('contentModal')
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="createPatientAccept">Crear paciente</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modifyPatientModal" tabindex="-1" role="dialog" aria-labelledby="modifyPatientModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modificar paciente</h4>
      </div>
      @yield('contentModal')
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="modifyPatientAccept">Modificar paciente</button>
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
{{ HTML::script('assets/js/jquery.dataTables.min.js') }}
{{ HTML::script('assets/js/patients.js') }}

@stop()