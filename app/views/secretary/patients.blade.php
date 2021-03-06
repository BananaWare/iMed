@section('title', 'Pacientes')

@section('extra-css')
    {{ HTML::style('assets/css/fullcalendar.css') }}
    {{-- HTML::style('assets/css/fullcalendar.print.css') --}}
    {{ HTML::style('assets/css/customTables.css') }}
    {{ HTML::style('assets/css/dataTables.bootstrap.css') }}
    {{ HTML::style('assets/css/daterangepicker.css') }}
@stop()

@section('section')
    <div id="addPatientPanel" class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-plus"></span>
            Nuevo paciente
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class="form-horizontal">
            <div class="form-group">
              <label class="control-label col-sm-1">Rut </label>
              <div class="col-sm-11">
                 <input id="patientsRutInput" type="text" class="form-control"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="listPatientsPanel" class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-user"></span>
            Lista de pacientes
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div id="table-responsive" class="table-responsive">
            <table class="table table-bordered table-hover" id="patientsTable">
              <thead align="center">
                <tr>
                  <th class="tname">Nombre</th>
                  <th class="trut">Rut</th>
                  <th class="tage">Edad</th>
                  <th class="temail">Email</th>
                  <th class="tphone">Teléfono</th>
                  <th class="tcity">Ciudad</th>
                  <th id="tableOptions" class="tactions">Opciones</th>
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

@section('modifyPatientModal')
<!-- Modal -->
<div class="modal fade" id="modifyPatientModal" role="dialog" aria-labelledby="modifyPatientModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modificar paciente</h4>
      </div>
      @include('/common/contentPatientModal')
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a type="button" class="btn btn-warning" id="modifyPatientAccept"><i class="icon-spin icon-refresh"></i><i class="glyphicon glyphicon-pencil icon-white"></i> Modificar</a>
      </div>
    </div>
  </div>
</div>
@stop()

<!-- Modal -->
@section('modal')
@include('common/createPatientModal')
  @yield('modifyPatientModal')
@stop()
@section('extra-js')
<!--{{ HTML::script('assets/js/jquery-ui.custom.min.js') }}-->
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/fullcalendar.min.js') }}
{{ HTML::script('assets/js/lang/es.js') }}
{{ HTML::script('assets/js/jquery.dataTables.min.js') }}
{{ HTML::script('assets/js/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/patients.js') }}
{{ HTML::script('assets/js/datePickerBugFixer.js') }}
{{-- HTML::script('assets/js/daterangepicker.js') --}}

@stop()