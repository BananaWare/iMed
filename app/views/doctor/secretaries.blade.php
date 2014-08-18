@section('title', 'Secretarias')

@section('extra-css')
  {{ HTML::style('assets/css/fullcalendar.css') }}
  {{ HTML::style('assets/css/customTables.css') }}
  {{ HTML::style('assets/css/dataTables.bootstrap.css') }}
@stop()

@section('section')

    <div id="addSecretaryPanel" class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-plus"></span>
            Activar secretaria
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-1">Rut </label>
              <div class="col-sm-11">
                <input id="secretarysRutInput" type="text" class="form-control"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div id="listSecretariesPanel" class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-list"></span>
            Lista de sus secretarias
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div id="table-responsive" class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="secretariesTable">
              <!-- .danger si una secretaria esta deshabilitada -->
              <thead align="center">
                <tr>
                  <th class="tname">Nombre</th>
                  <th class="trut">Rut</th>
                  <th class="tage">Edad</th>
                  <th class="temail">Email</th>
                  <th class="tphone">Teléfono</th>
                  <th class="tcity">Ciudad</th>
                  <th id="tableOptions" class="tunassign">Opciones</th>
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
<div class="modal fade" id="assignSecretaryModal" z-index:-1 role="dialog" aria-labelledby="assignSecretaryModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Asignar secretaria</h4>
      </div>
      <div class="modal-body">
        ¿Está seguro de que desea asociar a usted a la secretaria de rut <label id="rutDialog"></label>?
      </div>
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="assignSecretaryAccept">Aceptar</button>
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
  {{ HTML::script('assets/js/tours/doctor/doctorSecretariesTour.js') }}

@stop()