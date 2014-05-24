<div class="modal fade" id="createPatientModal" tabindex="-1" role="dialog" aria-labelledby="createPatientModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Nuevo paciente</h4>
      </div>
      @include('/common/contentPatientModal')
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="createPatientCancel" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="createPatientAccept">Crear paciente</button>
      </div>
    </div>
  </div>
</div>