@section('title', 'Pagos')

@section('extra-css')
{{ HTML::style('assets/css/bootstrap-formhelpers.min.css') }}
@stop()

@section('section')
    <div id="subscriptionState" class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-pushpin"></span>
            Estado de la suscripción
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body" id="billingsPanel">
          <label>Estado: </label>
          <label id="status">
            @if ($status == "freeze")
              Congelada
            @elseif ($status == "active")
              Activa
            @elseif ($status == "new")
              Nueva suscripción
            @endif
          </label>
          <br />
          @if ($status == "active")
          <label>Días restantes: </label>
          <label id="daysRemaining">{{ $days }}</label>
          @endif
        </div>
      </div>
    </div>

    <div id="pays" class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-pushpin"></span>
            Pagos realizados
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body" id="billingsPanel">
          <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th>Código</th>
              <th>Fecha de pago</th>
              <th>Producto</th>
              <th>Fecha inicio</th>
              <th>Fecha fin</th>
              <th>Monto pagado</th>
            </tr>
          </thead>
          <tbody>
          @foreach($billings as $billing)
            <tr>
              <td>{{ $billing['idBilling'] }}</td>
              <td>{{ $billing['paymentDateTimeFormatted'] }}</td>
              <td>
                @if ($billing['type'] == 'oneMonthSuscription')
                1 mes de suscripción
                @elseif ($billing['type'] == 'twoMonthSuscription')
                2 meses de suscripción
                @elseif ($billing['type'] == 'threeMonthSuscription')
                3 meses de suscripción
                @elseif ($billing['type'] == 'sixMonthSuscription')
                6 meses de suscripción
                @elseif ($billing['type'] == 'oneYearSuscription')
                1 año de suscripción
                @elseif ($billing['type'] == 'forLifeSuscription')
                Suscripción vitalicia
                @endif
              </td>
              <td>{{ $billing['startDateTimeFormatted'] }}</td>
              <td>{{ $billing['endDateTimeFormatted'] }}</td>
              <td>{{ $billing['amountPaidFormatted'] }}</td>
            </tr>
          @endforeach
          </tbody>
          </table>
        </div>
      </div>
    </div>

@stop()

@section('extra-js')
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/bootstrap-formhelpers.min.js') }}

@stop()