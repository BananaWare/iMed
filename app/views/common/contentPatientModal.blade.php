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
          <br>
          <input type="text" placeholder="Nombres" class="form-control name">
          <br>
          <input type="text" placeholder="Apellidos" class="form-control lastname">
          <br>
          <input type="date" placeholder="Fecha de nacimiento" class="form-control birthdate">
          <br>
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
          <br>
          <input type="text" placeholder="Teléfono" class="form-control phone">
          <br>
          <input type="text" placeholder="Ciudad" class="form-control city">
          <br>
          <input type="text" placeholder="Dirección" class="form-control address">
        </div>
      </div>
    </div>
  </div>
</div>