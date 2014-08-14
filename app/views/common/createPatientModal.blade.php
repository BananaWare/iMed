<div class="modal fade" id="createPatientModal" role="dialog" aria-labelledby="createPatientModal" aria-hidden="true" tabindex='-1'>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Nuevo paciente</h4>
      </div>
      @include('/common/contentPatientModal')
      <!-- Panels group -->
      <div class="modal-footer">
        <a type="button" class="btn btn-default" id="createPatientCancel" data-dismiss="modal">Cancelar</a>
        <a type="button" class="btn btn-success"  id="createPatientAccept"><i class="icon-spin icon-refresh"></i><i class="glyphicon glyphicon-plus"></i> Crear paciente</a>
      </div>
    </div>
  </div>
</div>