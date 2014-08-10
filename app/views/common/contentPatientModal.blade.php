<div class="modal-body">
  <!-- Panel group -->
  <div class="panel-group" id="accordion">
    <div class="panel">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-user"></span>
            Datos generales
            <span id="selectPatientStepFeedback" class="glyphicon pull-right"></span>
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class="form-horizontal">
            <div class="personal-errors">
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Rut: </label>
              <div class="col-sm-8">
                <input type="text" placeholder="Rut" class="form-control rut">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-4">Nombres: </label>
              <div class="col-sm-8">
                <input type="text" placeholder="Nombres" class="form-control name">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-4">Apellidos: </label>
              <div class="col-sm-8">
                <input type="text" placeholder="Apellidos" class="form-control lastname">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-4">Fecha de nacimiento: </label>
              <div class="col-sm-8">
                <input type="text" data-date-format="dd/mm/yyyy" data-date-start-view="decade" placeholder="Fecha de nacimiento" class="form-control dp birthdate">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-4">Sexo: </label>
              <div class="col-sm-8">
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
        </div>
      </div>
    </div>
    <div class="panel">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-earphone"></span>
            Datos de contacto
            <span id="selectPatientStepFeedback" class="glyphicon pull-right"></span>
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class="form-horizontal">
            <div class="contact-errors">
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Email: </label>
              <div class="col-sm-8">
                <input type="text" placeholder="Email" class="form-control email">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-4">Teléfono: </label>
              <div class="col-sm-8">
                <input type="text" placeholder="Teléfono" class="form-control phone">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-4">Ciudad: </label>
              <div class="col-sm-8">
                <input type="text" placeholder="Ciudad" class="form-control city">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-4">Dirección: </label>
              <div class="col-sm-8">
                <input type="text" placeholder="Dirección" class="form-control address">
              </div>
            </div>
                
          </div>
        </div>
      </div>
    </div>
  </div>
</div>