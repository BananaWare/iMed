<?php
class SecretaryController extends BaseController {
  
  protected $layout = 'layouts.dashboard';
  
  private $spanishNames = array(
    'name' => 'nombre',
    'lastname' => 'apellido',
    'birthdate' => 'fecha de nacimiento',
    'gender' => 'género',
    'phone' => 'teléfono',
    'city' => 'ciudad',
    'address' => 'dirección',
    
  );
  
  public function index()
  {/*
    JavaScript::put([
      'hospitals' => Auth::user()->hospitals
    ]);*/
    //var_dump(Auth::user()->hospitals->toArray());
    // If she is a new secretary or it is her first login
    if (!isset(Auth::user()->name) || !isset(Auth::user()->lastname) || 
        !isset(Auth::user()->gender) || !isset(Auth::user()->birthdate) )
      return Redirect::to('/firstLogin');
    else
      {
        $this->layout->function = View::make('dashboard.secretarySidebar');
        $this->layout->section = View::make('secretary.dashboard');
      }
  }
  
  public function firstLogin()
  {
      $this->layout->section = View::make('secretary.firstLogin');
  }
  
  public function noSuscription()
  {
    if (Auth::user()->isSecretaryOn(Session::get('idHospitalSelected')) == true)
      $this->layout->function = View::make('dashboard.secretarySidebar');
    else if (Auth::user()->isDoctorOn(Session::get('idHospitalSelected')) == true)
      $this->layout->function = View::make('dashboard.doctorSidebar');
    
    $this->layout->section = View::make('doctor.noSuscription');
  }
  
  public function doModifySecretary()
  {
    $data = Input::all();
    $rules = array(
      'password' => 'required'
    );
    
     $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {   
      return $validator->messages();
    }
    
    $user = Auth::user();
    $userInfo = UserInfo::where("rut", "=", $user->rut)
      ->where("idHospital", "=", Session::get('idHospitalSelected'))->first();
    
    $setUserWithInputsValidator = $this->setUserWithInputs($user, $userInfo);
    if($setUserWithInputsValidator->fails())
      return $setUserWithInputsValidator->messages();
    
    $user->password = Hash::make(Input::get('password'));
    $user->save();
    $userInfo->save();
    
    $userInfo->user = null;
    $user['userInfo'] = $userInfo->toArray();
    
    return $user->toJson();
  }
  
  public function showAssignHourFromHospitalSelected()
  {
    $user = Auth::user();
    
    if (get_class($this) == "SecretaryController")
      $role = 'secretary';
    else if (get_class($this) == "DoctorController")
      $role = 'doctor';
      
    $hospital = $user->hospitals->find(Session::get('idHospitalSelected'));
    if ($hospital !== null)
    {
      $completeHospital = $hospital->toArray();
      //foreach($allDoctors as $doctor)
      if ($role == 'secretary')
      {
        // Get secretary's doctors
        $doctors = $user->getDoctorsFromHospital($hospital->idHospital)->get();
        foreach($doctors as $doctor)
        {
          //if($doctor->pivot->idHospital == $hospital->idHospital)
          //{
          $completeDoctor = $doctor->toArray();
          $completeDoctor['schedules'] = $doctor->getDoctorsScheduleFromHospital($hospital->idHospital)
            ->get()->toArray();
          
          $month =  date("m");
          $year = date("Y");
          $completeDoctor['patientsHours'] = array();
          $completeDoctor['customSchedules'] = array();
          for ( $i = $month - 1 ; $i <= $month + 1 ; $i ++) {
            $temp = array();
            $pHs = $doctor->getPatientsHoursFromHospitalToMonth($hospital->idHospital, $i, $year)->get();
            $tempCS = $doctor->getCustomScheduleFromHospitalToMonth($hospital->idHospital, $i, $year)
               ->get()->toArray();
            foreach($pHs as $pH)
            {
              $pH['patient'] = $pH->patient->toArray();
              $pH['assigner'] = $pH->assigner->toArray();
              $temp[] = $pH->toArray();
            }
            $completeDoctor['patientsHours'] = array_merge($completeDoctor['patientsHours'],$temp);
            $completeDoctor['customSchedules'] = array_merge($completeDoctor['customSchedules'], $tempCS);
          }
          $completeHospital['doctors'][] = $completeDoctor;
        };
      }
      else if ($role == 'doctor')
      {
        $user['schedules'] = Auth::user()->getDoctorsScheduleFromHospital($hospital->idHospital)
          ->get()->toArray();
        $month =  date("m");
        $year = date("Y");
        $user['patientsHours'] = array();
        $user['customSchedules'] = array();
        for ( $i = $month - 1 ; $i <= $month + 1 ; $i++) {

          $temp = array();
          $pHs = Auth::user()->getPatientsHoursFromHospitalToMonth($hospital->idHospital, $i, $year)->get();
          $tempCS = Auth::user()->getCustomScheduleFromHospitalToMonth($hospital->idHospital, $i, $year)
          ->get()->toArray();
          foreach($pHs as $pH)
          {
            $pH['patient'] = $pH->patient->toArray();
            $pH['assigner'] = $pH->assigner->toArray();
            $temp[] = $pH->toArray();
          }
          $user['patientsHours'] = array_merge($user['patientsHours'], $temp);
          $user['customSchedules'] = array_merge($user['customSchedules'], $tempCS);
        }
      }
      //$completeHospital;      
    };
    
    $hospitalWithPatients =  $this->getPatientsFullFromHospitalSelected(false);
    $completeHospital['patients'] = $hospitalWithPatients['patients'];
    JavaScript::put([
      'hospital' => $completeHospital,
      'hospitalWithPatients' => $hospitalWithPatients,
      'user' => $user,
      'role' => $role
    ]);
    
    if ($role == 'secretary')
      $this->layout->function = View::make('dashboard.secretarySidebar');
    else if ($role == 'doctor')
      $this->layout->function = View::make('dashboard.doctorSidebar');
    
    $this->layout->section = View::make('secretary.assignHour')->with('role', $role);
    
  }
  
  public function doCreatePatient()
  {
    $user = new User();
    $userInfo = new UserInfo();
    $medicalHistory = new MedicalHistory();
    
    $doCreateUserValidator = $this->doCreateUser($user, $userInfo);
    if($doCreateUserValidator->fails())
      /*return Redirect::to('/patients')
        ->withInput()
        ->withErrors($doCreateUserValidator);*/
      return $doCreateUserValidator->messages();
    //$medicalHistory->rut = $user->rut;
    $medicalHistory->save();
    $user->save();
    $userInfo->idMedicalHistory = $medicalHistory->idMedicalHistory;
    $userInfo->save();
    
    if (!User::find($user->rut)->isPatientOn(Input::get('idHospital')))
    {
      
      $role = new UserRole();
      $role->rut = $user->rut;
      $role->role = "patient";
      $role->idHospital = Input::get('idHospital');
      $role->save();
      
    }
    
    $userInfo->user = null;
    $user['userInfo'] = $userInfo->toArray();
    
    return $user->toJson();
  }
  
  /**
    Crea un usuario con las siguientes características:
    Establece los campos de user: rut, dv, name, lastname, gender y birthdate. Y
    establece los campos de userInfo: rut, dv, email, phone.
    Nota: No establece el campo de userInfo idHospital ni el campo de user role.
  */
  protected function doCreateUser(&$user, &$userInfo)
  {
    $data = Input::all();
    $rules = array(
      'rut' => array('required', 'regex:/^(\.|\d)+-(k|K|\d)$/')
    );
    
    $validator = Validator::make($data, $rules, array("regex" => "El :attribute no está en el formato correcto."));
    
    if ($validator->fails()) {
      return $validator;
    }
    
    $rutSinPuntos = str_replace(".", "", Input::get('rut'));    
    list($user->rut, $user->dv) = explode("-", $rutSinPuntos);
    
    $userAntiguo = User::find($user->rut);
    if (isset($userAntiguo))
      $user = $userAntiguo;
    
    $setUserWithInputs = $this->setUserWithInputs($user, $userInfo);
    if($setUserWithInputs->fails())
      return $setUserWithInputs;
    
    $userInfo->rut = $user->rut;
    $userInfo->dv = $user->dv;
    $userInfo->idHospital = Input::get('idHospital');
    
    $userInfoValidator = Validator::make(array('rut' => $userInfo->rut), 
                                         array('rut' => 'unique:users_info,rut,NULL,rut,idHospital,' . $userInfo->idHospital));
    if ($userInfoValidator->fails())
      return $userInfoValidator;
    
    return $setUserWithInputs;
  }
 
  public function doModifyPatient()
  {
    $data = Input::all();
    $rules = array(
      'rut' => array('required', 'regex:/^(\.|\d)+-(k|K|\d)$/')
    );
    
    
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
      return $validator->messages();
      /*return Redirect::to('/patients')
        ->withInput()
        ->withErrors($validator);*/
    }
    $rutSinPuntos = str_replace(".", "", Input::get('rut'));
    list($rut, $dv) = explode("-", $rutSinPuntos);
    $user = User::where('rut', '=', $rut)->first();
    if (!$user->isPatientOn(Input::get('idHospital')))
        return 'Paciente incorrecto.';
        
    $userInfo = UserInfo::where('rut', '=', $rut)
      ->where('idHospital', '=', Input::get('idHospital'))->first();
    //echo var_dump($user);
    //echo $user;return;
    $setUserWithInputsValidator = $this->setUserWithInputs($user, $userInfo);
    
    if($setUserWithInputsValidator->fails())
    {
      /*return Redirect::to('/patients')
        ->withInput()
        ->withErrors($setUserWithInputsValidator);*/
      
      return $setUserWithInputsValidator->messages();
    }
    $user->password = Hash::make(Input::get("password"));
    $user->save();
    $userInfo->save();
    
    $userInfo->user = null;
    $user['userInfo'] = $userInfo->toArray();
    return $user->toJson();
  }
  
  /**
    Establece los campos de user: name, lastname, gender y birthdate. Y
    establece los campos de userInfo: rut, email, phone.
    Nota: No establece el campo de userInfo idHospital, ni rut. Tampoco el 
    campo de user rut.
  */
  protected function setUserWithInputs(&$user, &$userInfo)
  {
    //   echo var_dump($user->toArray());
    
    $data = Input::all();
    $rules = array(
      'name' => 'required|max:40',
      'lastname' => 'required|max:40',
      'gender' => 'required|in:male,female',
      'birthdate' => 'date_format:"Y-m-d"',
      'email' => 'email|max:40',
      'phone' => 'numeric',
      'idHospital' => 'numeric'
    );
  
    $validator = Validator::make($data, $rules);
    $validator->setAttributeNames($this->spanishNames);
    
    if (!$validator->fails()) {
      $values= preg_split("/\//", Input::get('birthdate'));
      
      $user->name = Input::get('name');
      $user->lastname = Input::get('lastname');
      $user->gender = Input::get('gender') == '' ? null : Input::get('gender');
      $user->birthdate = Input::get('birthdate') == '' ? null : Input::get('birthdate');
      
      $userInfo->email = Input::get('email') == '' ? null : Input::get('email');
      $userInfo->phone = Input::get('phone') == '' ? null : Input::get('phone');
      $userInfo->city = Input::get('city') == '' ? null : Input::get('city');
      $userInfo->address = Input::get('address') == '' ? null : Input::get('address');
    }
    return $validator;
  }
  public function doRemovePatient()
  {
    $data = Input::all();
    $rules = array(
      'rut' => array('required', 'regex:/^(\.|\d)+-(k|K|\d)$/'),
      'idHospital' => 'required|numeric'
    );
    $rutSinPuntos = str_replace(".", "", Input::get('rut'));
    list($rut, $dv) = explode("-", $rutSinPuntos);
    
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
      return Redirect::to('/patients');
    }
    
    $user = UserInfo::where('role', '=', 'patient')->where('rut', '=', $rut)
      ->where('idHospital', '=', Input::get('idHospital'))
      ->first()
      ->delete();
  }
  
  public function doAssignHour()
  {
    date_default_timezone_set('America/Santiago');
    $data = Input::all();
    $rules = array(
      'doctorsRut' => 'required|numeric',
      'patientsRut' => 'required|numeric',
      'dateTimeAssign' => 'required|date',
      'dateTimeEnd' => 'required|date'
    );
  
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
        return $validator->messages();
        //return Redirect::to('/patients');
    }
    
    $startHour = new DateTime(  (new DateTime(Input::get('dateTimeAssign')))->format('Y-m-d H:i:s')  );
    $endHour = new DateTime(Input::get('dateTimeEnd'));
    
      
    $patientHour = new PatientHour();
    $patientHour->doctorsRut = Input::get('doctorsRut');
    $patientHour->idHospital = Input::get('idHospital');
    $patientHour->assignersRut = Auth::user()->rut;
    $patientHour->patientsRut = Input::get('patientsRut');
    $patientHour->dateTimeAssign = $startHour;
    $patientHour->dateTimeEnd = $endHour;
    $patientHour->reason = Input::get('reason');
    $patientHour->confirmed = false;
    
    
    if ($startHour  < new DateTime() )
      return "denied";
    
    if (!$patientHour->save())
    {
      return 0;
    }
    $pH = PatientHour::find($patientHour->idHour);
    
    $pH['patient'] = $pH->patient->toArray();
    $pH['assigner'] = $pH->assigner->toArray();
    return $pH->toJson();
  }
  
  public function doRevokeHour()
  {
    $patientHour = PatientHour::find(Input::get("idPatientHour"));
    
    if ((new DateTime($patientHour->dateTimeAssign, new DateTimeZone('America/Santiago'))) < new DateTime(null, new DateTimeZone('America/Santiago')) )
      return "denied";
    
    if ($patientHour != null && $patientHour->delete())
      return $patientHour->toJson();
    else 
      return "0";
  }
  
  public function doConfirmHour()
  {
    $patientHour = PatientHour::find(Input::get("idPatientHour"));
    if ($patientHour != null)
    {
      $patientHour->confirmed = true;
      if ($patientHour->save())
        return $patientHour->toJson();
      else 
        return "0";
    }
    else
      return "0";
  }
  
  public function doDisconfirmHour()
  {
    $patientHour = PatientHour::find(idPatientHour);
    $patientHour->confirmed = false;
    $patientHour->save();
  }
  
  public function getPatientInfo()
  {
    $data = Input::all();
    $rules = array(
      'rut' => array('required', 'regex:/^(\.|\d)+-(k|K|\d)$/')
    );
  
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
      return Redirect::to('/patients');
    }
    
    $rutSinPuntos = str_replace(".", "", Input::get('rut'));
    list($rut, $dv) = explode("-", $rutSinPuntos);
    
    $user = User::find($rut);
    $userInfo = UserInfo::where('role', '=', 'patient')->where('rut', '=', $rut)
      ->where('idHospital', '=', Input::get('idHospital'))->first();
  }
  
  public function showPatients()
  {
    JavaScript::put([
      'hospital' => $this->getPatientsFullFromHospitalSelected(false)
    ]);    
    
    
    if (get_class($this) == "SecretaryController")
      $this->layout->function = View::make('dashboard.secretarySidebar');
    else if (get_class($this) == "DoctorController")
      $this->layout->function = View::make('dashboard.doctorSidebar');
    
    $this->layout->section = View::make('secretary.patients');
  }
  
  public function doGetPatientsFromHospitalSelected()
  {
    return getPatientsFullFromHospitalSelected(false);
  }
 
  protected function getPatientsFullFromHospitalSelected($withPrescriptions, $doctorsRut = null)
  {
    $hospital = Hospital::find(Session::get('idHospitalSelected'));
    $completeHospital = $hospital->toArray();
    $completeHospital['patients'] = array();
    foreach($hospital->patientsInfos as $patientInfo)
    {
      $completePatient = $patientInfo->user->toArray();
      // Rellenamos con los siguientes datos solo si se solicitó por parametro que se rellenaran
      if ($withPrescriptions)
      {
        $pHs = null;
        if ($doctorsRut === null)
          continue;
        $patientHours = $patientInfo->user->getPatientHoursFromHospitalToDoctor(Session::get('idHospitalSelected'), $doctorsRut);
        foreach($patientHours as $patientHour)
        {
          $pH = $patientHour->toArray();
          $pH['medicalSheet'] = null;
          if ($patientHour->medicalSheet != null)
          {
            $pH['medicalSheet'] = $patientHour->medicalSheet->toArray();
            if ($patientHour->medicalSheet->prescription != null)
            {
              $prescription = $patientHour->medicalSheet->prescription;
              $p = $prescription->toArray();
              if ($prescription->drugs->count() != 0)
              {
                foreach($prescription->drugs as $drug)
                {
                  //$dP = $drug->toArray();
                  $d = $drug->toArray();
                  $p['drugs'][] = $d;
                }
              }
              else 
              {
                foreach($prescription->drugsPrescriptions as $drug)
                {
                  //$dP = $drug->toArray();
                  $d = $drug->toArray();
                  $p['drugs'][] = $d;
                }
              }
            }
            else 
              $p = null;
            $pH['prescription'] = $p;
          }
          else
            $pH['prescription'] = null;
          $pHs[] = $pH;
        }
        $completePatient['patientHours'] = $pHs;
      }

      $completePatient['userInfo'] = $patientInfo->toArray();
      unset($completePatient['userInfo']['user']);

      if ($patientInfo->medicalHistory != null)
        $completePatient['userInfo']['medicalHistory'] = $patientInfo->medicalHistory->toArray();
      else
        $completePatient['userInfo']['medicalHistory'] = null;
      $completeHospital['patients'][] = $completePatient;
    }
    return $completeHospital;
  }
  
  //Obtengo las horas pedidas para un doctor en un hospital determinado y en los meses enviados por post
  public function doRefreshHoursForCalendar()
  {
    $user = Auth::user();
    $idHospital = Input::get('idHospital');
    $idDoctor = Input::get('rut');
    $months = Input::get('months');
    $year = Input::get('year');
    $hours = array();
    if (get_class($this) == "SecretaryController")
      $role = 'secretary';
    else if (get_class($this) == "DoctorController")
      $role = 'doctor';

    foreach ($user->hospitals as $hospital)
    {
      if($hospital->idHospital == $idHospital)
      {

        if ($role == 'secretary')
        {
          $doctors = $user->getDoctorsFromHospital($hospital->idHospital)->get();

          foreach($doctors as $doctor)
          {
            if($doctor->rut == $idDoctor)
            {
              foreach($months as $key => $month)
              {
                $temp = array();
                $pHs = $doctor->getPatientsHoursFromHospitalToMonth($idHospital, $month, $year)
                ->get();
                foreach($pHs as $pH)
                {
                  $pH['patient'] = $pH->patient->toArray();
                  $pH['assigner'] = $pH->assigner->toArray();
                  $temp[] = $pH->toArray();
                }

                $hours = array_merge($hours, $temp);
              }
            }
          }
        }
        else if ($role == "doctor")
        {
          foreach($months as $key => $month)
          {
            $temp = array();
            $pHs = Auth::user()->getPatientsHoursFromHospitalToMonth($hospital->idHospital, $month, $year)->get();
            foreach($pHs as $pH)
            {
              $pH['patient'] = $pH->patient->toArray();
              $pH['assigner'] = $pH->assigner->toArray();
              $temp[] = $pH->toArray();
            }

            $hours = array_merge($hours, $temp);
          }
        }
      }
    }
    return $hours;
  }
  
  public function doAddExtraHour()
  {
    $idHospital = Session::get('idHospitalSelected');
    $doctorsRut = Input::get('doctorsRut');
    $day = Input::get('day');
      
    $customSchedules = CustomSchedule::where('idHospital', '=', $idHospital)->where('doctorsRut', '=', $doctorsRut)
      ->where('day', '=', $day);
    
    $cS = new CustomSchedule();
    if ($customSchedules->count() == 0)
    {
      $cS->idHospital = $idHospital;
      $cS->doctorsRut = $doctorsRut;
      $cS->day = $day;
      $cS->extraHours = 1;
    }
    else
    {
      $cS = $customSchedules->first();
      $cS->extraHours += 1;
    }
    
    //Comprobando que no exceda las 24:00 horas.
    $dayOfWeek =  (date('w', strtotime($day)) == 0) ? 7 : date('w', strtotime($day));
    $schedule = DoctorSchedule::where('idHospital', '=', $idHospital)->where('doctorsRut', '=', $doctorsRut)
      ->where('dayOfWeek', '=', $dayOfWeek)->first();
    $endHour = new DateTime($day . ' ' . $schedule->endHour);
    for($i=0; $i<$cS->extraHours; $i++)
    {
      list($hours, $minutes, $seconds) = preg_split("/:/", $schedule->intervalTime);
      $endHour->add(new DateInterval('PT'. $hours . 'H' . $minutes .'M'));
    }
        
    if ($endHour->format('Y-m-d') == $day)
    {
      $cS->save();
      return 'true';
    }
    else
      return 'false';
  }
}