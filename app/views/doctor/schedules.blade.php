@section('title', 'Horarios')

@section('extra-css')
  <!--{{ HTML::style('assets/css/fullcalendar.css') }}
  {{ HTML::style('assets/css/customTables.css') }}
  {{ HTML::style('assets/css/dataTables.bootstrap.css') }}-->
{{ HTML::style('assets/css/bootstrap-formhelpers.min.css') }}
{{ HTML::style('assets/css/schedules.css') }}
<!--{{ HTML::style('assets/css/bootstrap-responsive.css') }}
{{ HTML::style('assets/css/bootstrap-timepicker.min.css') }}-->  
@stop()

@section('section')
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <span class="glyphicon glyphicon-briefcase"></span>
            Horario de la semana
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body" id="daysOfWeekPanel">
          @foreach($schedules as $schedule)
           <div class="dayOfWeek" data-day-of-week="{{ $schedule['dayOfWeek'] }}"
                data-id-doctor-schedule="{{ $schedule['idDoctorSchedule'] }}" >
             <form class="form-inline" role="form">
               
                <div class="form-group">
                  <div class="checkbox">
                  <label>
                    <input class="checkboxDayOfWeek" type="checkbox"
                    @if (isset($schedule['startHour']))
                           checked
                    @endif
                    >
                  </label>
                </div>
                  <label>{{ $schedule['nameDayOfWeek'] }}</label>
                  </div>
                
               <br/>
               <label>Hora de inicio
               </label>
               <div class="bfh-timepicker" data-name="startHourTimePicker" 
                    data-time="{{ $schedule['startHour'] }}" data-placeholder="Sin hora">
               </div>
               <label>Hora de fin
               </label>
               <div class="bfh-timepicker" data-name="endHourTimePicker"
                    data-time="{{ $schedule['endHour'] }}" data-placeholder="Sin hora">
               </div>
               <label>Duración consultas
               </label>
               <div class="bfh-timepicker" data-name="intervalTimePicker"
                    data-time="{{ $schedule['intervalTime'] }}" data-placeholder="Sin duración">
               </div>
             </form>
          </div>
          @endforeach
          <br />
          <button class="btn btn-primary" id="buttonSaveSchedules" type="button">Guardar horarios</button>
        </div>
      </div>
    </div>

@stop()

@section('extra-js')
{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/bootstrap-formhelpers.min.js') }}
<!--{{ HTML::script('assets/js/bootstrap-timepicker.min.js') }}-->
{{ HTML::script('assets/js/schedules.js') }}

@stop()