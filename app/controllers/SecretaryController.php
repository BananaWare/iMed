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
  {
    JavaScript::put([
      'hospitals' => Auth::user()->hospitals
    ]);
    
    $this->layout->function = View::make('dashboard.secretarySidebar');
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
          for ( $i = $month - 1 ; $i <= $month + 1 ; $i ++) {
            $temp = $doctor->getPatientsHoursFromHospitalToMonth($hospital->idHospital, $i, $year)
                                        ->get()->toArray();

            $completeDoctor['patientsHours'] = array_merge($completeDoctor['patientsHours'],$temp);

          }

          //$doctor->getPatientsHoursFromHospitalToMonth($hospital->idHospital, 2, 2014);
          $completeHospital['doctors'][] = $completeDoctor;
          //$tempReg['doctors'][] = $completeDoctor;
          //}
        };
      }
      else if ($role == 'doctor')
      {
        $user['schedules'] = Auth::user()->getDoctorsScheduleFromHospital($hospital->idHospital)
          ->get()->toArray();
        $month =  date("m");
        $year = date("Y");
        $user['patientsHours'] = array();
        for ( $i = $month - 1 ; $i <= $month + 1 ; $i++) {
          $temp = Auth::user()->getPatientsHoursFromHospitalToMonth($hospital->idHospital, $i, $year)
            ->get()->toArray();

          $user['patientsHours'] = array_merge($user['patientsHours'], $temp);
        }
      }
      //$completeHospital;      
    };
    
    $hospitalWithPatients =  $this->getPatientsFullFromHospitalSelected(false);
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
    $doCreateUserValidator = $this->doCreateUser($user, $userInfo);
    if($doCreateUserValidator->fails())
      /*return Redirect::to('/patients')
        ->withInput()
        ->withErrors($doCreateUserValidator);*/
      return $doCreateUserValidator->messages();
    
    $user->save();
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
      'name' => 'required',
      'lastname' => 'required|max:15',
      'gender' => 'required|in:male,female',
      'birthdate' => 'date',
      'email' => 'email',
      'phone' => 'numeric',
      'idHospital' => 'numeric'
    );
  
    $validator = Validator::make($data, $rules);
    $validator->setAttributeNames($this->spanishNames);
    
    if (!$validator->fails()) {
      
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
    $startHour = new DateTime(Input::get('dateTimeAssign'));
    $endHour = new DateTime(Input::get('dateTimeEnd'));
    
    $patientHour = new PatientHour();
    $patientHour->doctorsRut = Input::get('doctorsRut');
    $patientHour->idHospital = Input::get('idHospital');
    $patientHour->assignersRut = Auth::user()->rut;
    $patientHour->patientsRut = Input::get('patientsRut');
    $patientHour->dateTimeAssign = $startHour;
    $patientHour->dateTimeEnd = $endHour;
    $patientHour->reason = Input::get('reason');
    $patientHour->confirmed = Input::get('confirmed');    
    $patientHour->save();
    
    return $patientHour->toJson();
  }
  
  public function revokeHour()
  {
    $patientHour = PatientHour::find(idPatientHour);
    $patientHour->delete();
  }
  
  public function confirmHour()
  {
    $patientHour = PatientHour::find(idPatientHour);
    $patientHour->confirmed = true;
    $patientHour->save();
  }
  
  public function disconfirmHour()
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
  /*
  protected function getHospitalWithPatientsFull($withPrescriptions)
  {
    $doctor = Auth::user();
    $hospitals = $doctor->hospitals;
    
    foreach($hospitals as $hospital)
    {
      $completeHospital = $hospital->toArray();
      foreach($hospital->patientsInfos as $patientInfo)
      {
        $completePatient = $patientInfo->user->toArray();
        // Rellenamos con los siguientes datos solo si se solicitó por parametro que se rellenaran
        if ($withPrescriptions)
        {
          $pHs = null;
          foreach($patientInfo->user->patientHours as $patientHour)
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
                if ($prescription->drugs != null)
                {
                  foreach($prescription->drugs as $drug)
                  {
                    //$dP = $drug->toArray();
                    $d = $drug->toArray();
                    $p['drugs'][] = $d;
                  }
                }
                else 
                  $p['drugs'] = null;
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
      $tempReg['hospitals'][] = $completeHospital; 
    }
    return $tempReg;
  }
*/  
  protected function getPatientsFullFromHospitalSelected($withPrescriptions, $doctorsRut = null)
  {
    $hospital = Hospital::find(Session::get('idHospitalSelected'));
    $completeHospital = $hospital->toArray();
    
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
              if ($prescription->drugs != null)
              {
                foreach($prescription->drugs as $drug)
                {
                  //$dP = $drug->toArray();
                  $d = $drug->toArray();
                  $p['drugs'][] = $d;
                }
              }
              else 
                $p['drugs'] = null;
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

                $temp = $doctor->getPatientsHoursFromHospitalToMonth($idHospital, $month, $year)
                ->get()->toArray();

                $hours = array_merge($hours, $temp);
              };
            }
          };
        }
      }
    };
    return $hours;
  }
}