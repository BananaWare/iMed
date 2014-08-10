@section('title', 'Inicialización de cuenta')

@section('extra-css')
    {{ HTML::style('assets/css/fullcalendar.css') }}
    {{-- HTML::style('assets/css/fullcalendar.print.css') --}}
    {{ HTML::style('assets/css/customTables.css') }}
    {{ HTML::style('assets/css/daterangepicker.css') }}
@stop()

@section('section')
<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-info-sign"></span><strong> ¡Bienvenida/o!</strong>, seguramente esta es la primera vez que ingresas
a iMed, para comenzar debes <strong>ingresar tus datos</strong> en los formularios 
  y hacer click en <strong>"Guardar Datos"</strong>. Después de
esto podrás acceder a todas las funcionalidades normales.</div>
<div class="row">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-user"></span>
            Datos generales
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class="personal-errors">
          </div>
          <input type="text" placeholder="Nombres" class="form-control name">
          <br>
          <input type="text" placeholder="Apellidos" class="form-control lastname">
          <br>
          <input type="password" placeholder="Contraseña" class="form-control password1">
          <br>
          <input type="password" placeholder="Repita contraseña" class="form-control password2">
          <br>
          <input type="text" data-date-format="dd/mm/yyyy" data-date-start-view="decade" placeholder="Fecha de nacimiento" class="form-control dp birthdate">
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
</div>
<div class="row">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          <span class="glyphicon glyphicon-earphone"></span>
          Datos de contacto
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in">
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
<button class="btn btn-primary" id="modifySecretaryAccept" type="button">Guardar datos</button>
@stop()


@section('modal')
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Tenemos un pequeño problema</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove-sign"></span>
          Las <strong>contraseñas</strong> ingresadas no coinciden, por favor <strong>vuelva a escribirlas</strong> para poder continuar. 
        </div>
      </div>
      <!-- Panels group -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>
@stop()

@section('extra-js')
<!--{{ HTML::script('assets/js/jquery-ui.custom.min.js') }}-->
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/fullcalendar.min.js') }}
{{ HTML::script('assets/js/lang/es.js') }}
{{ HTML::script('assets/js/firstLogin.js') }}
{{ HTML::script('assets/js/daterangepicker.js') }}
@stop()