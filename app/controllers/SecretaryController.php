<?php

class SecretaryController extends BaseController {
  
  protected $layout = 'layouts.dashboard';
  
  public function index()
  {
    $this->layout->header = View::make('navbars.homeNavBar');
    $this->layout->function = View::make('dashboard.secretarySidebar');
    //$this->layout->function = View::make('dasb');
  }
  
  public function showAssignHour()
  {
    $secretary = Auth::user();
    //$allDoctors = $secretary->doctors;
    foreach ($secretary->hospitals as $hospital)
    {
      $completeHospital = $hospital->toArray();
      //foreach($allDoctors as $doctor)
      $doctors = $secretary->getDoctorsFromHospital($hospital->idHospital)->get();
      
      foreach($doctors as $doctor)
      {
        //if($doctor->pivot->idHospital == $hospital->idHospital)
        //{
        $completeDoctor = $doctor->toArray();
        $completeDoctor['schedules'] = $doctor->getDoctorsScheduleFromHospital($hospital->idHospital)
          ->get()->toArray();
        $completeDoctor['patientsHours'] = $doctor->getPatientsHoursFromHospitalToMonth($hospital->idHospital)
          ->get()->toArray();
        //$doctor->getPatientsHoursFromHospitalToMonth($hospital->idHospital, 2, 2014);
        $completeHospital['doctors'][] = $completeDoctor;
        //$tempReg['doctors'][] = $completeDoctor;
        //}
      };
      $hospitals[] = $completeHospital;
      
    };
    JavaScript::put([
      'hospitals' => $hospitals,
      'secretary' => $secretary
    ]);
    
    $this->layout->header = View::make('navbars.dashboardNavBar');
    $this->layout->function = View::make('dashboard.secretarySidebar');  
    $this->layout->section = View::make('secretary.assignHour');
  }
  
  public function doCreatePatient()
  {
    $user = new User();
    $userInfo = new UserInfo();
    $doCreateUserValidator = $this->doCreateUser($user, $userInfo);
    if($doCreateUserValidator->fails())
      return Redirect::to('/patients')
        ->withInput()
        ->withErrors($doCreateUserValidator);
    
    
    $user->role = 'patient';
   
    $user->save();
    $userInfo->save();
    
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
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
      return $validator;
    }
    
    $setUserWithInputs = $this->setUserWithInputs($user, $userInfo);
    if($setUserWithInputs->fails())
      return $setUserWithInputs;
    
    $rutSinPuntos = str_replace(".", "", Input::get('rut'));    
    list($user->rut, $user->dv) = explode("-", $rutSinPuntos);
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
      return Redirect::to('/patients')
        ->withInput()
        ->withErrors($validator);
    }
    $rutSinPuntos = str_replace(".", "", Input::get('rut'));
    list($rut, $dv) = explode("-", $rutSinPuntos);
    $user = User::where('rut', '=', $rut)->where('role', '=', 'patient')->first();
    $userInfo = UserInfo::where('rut', '=', $rut)
      ->where('idHospital', '=', Input::get('idHospital'))->first();
    
    $setUserWithInputsValidator = $this->setUserWithInputs($user, $userInfo);
    if($setUserWithInputsValidator->fails())
    {
      return Redirect::to('/patients')
        ->withInput()
        ->withErrors($setUserWithInputsValidator);
    }
      /* $asdf = $validator->messages();
    $qq = $asdf->all();
      foreach ($qq as $q)
      echo $qq[0];*/
    $user->save();
    $userInfo->save();
    
  }
  
  /**
    Establece los campos de user: name, lastname, gender y birthdate. Y
    establece los campos de userInfo: rut, email, phone.
    Nota: No establece el campo de userInfo idHospital, ni rut. Tampoco el 
    campo de user rut.
  */
  protected function setUserWithInputs(&$user, &$userInfo)
  {
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
    
    if (!$validator->fails()) {
      
      //return false;
      $rutSinPuntos = str_replace(".", "", Input::get('rut'));
      list($rut, $dv) = explode("-", $rutSinPuntos);
      $user = User::find($rut);
      $userInfo = UserInfo::where('rut', '=', $rut)->where('idHospital', '=', Input::get('idHospital'))->first();
      
      $user->name = Input::get('name');
      $user->lastname = Input::get('lastname');
      $user->gender = Input::get('gender') == '' ? null : Input::get('gender');
      $user->birthdate = Input::get('birthdate') == '' ? null : Input::get('birthdate');
      
      $userInfo->email = Input::get('email') == '' ? null : Input::get('email');
      $userInfo->phone = Input::get('phone') == '' ? null : Input::get('phone');
      $userInfo->city = Input::get('city') == '' ? null : Input::get('city');
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
      'doctorsRut' => array('required', 'regex:/^(\.|\d)+-(k|K|\d)$/'),
      'patientsRut' => array('required', 'regex:/^(\.|\d)+-(k|K|\d)$/'),
      'dateTimeAssignRut' => 'required|date'
    );
  
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
      return Redirect::to('/patients');
    }
    
    $patientHour = new PatientHour();
    $patientHour->doctorsRut = Input::get('doctorsRut');
    $patientHour->assignersRut = Auth::user()->rut;
    $patientHour->patientsRut = Input::get('patientsRut');
    $patientHour->dateTimeAssing = Input::get('dateTimeAssing');
    $patientHour->reason = Input::get('reason');
    $patientHour->confirmed = Input::get('confirmed');    
    $patientHour->save();
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
    
    //TODO: cambiar el numero de idHospital.
    $user = User::find($rut);
    $userInfo = UserInfo::where('role', '=', 'patient')->where('rut', '=', $rut)
      ->where('idHospital', '=', 1)->first();
  }
  
  public function showPatients()
  {
    $doctor = Auth::user(); 
    $hospitals = $doctor->hospitals;
    
    foreach($hospitals as $hospital)
    {
      $completeHospital = $hospital->toArray();
      $patientsInfo = $hospital->patientsInfo;
      foreach($patientsInfo as $patientInfo)
      {
        //var_dump($patientInfo);
        $completePatient = $patientInfo->user->toArray();
        $completePatient['userInfo'] = $patientInfo->toArray();
        //$completeSecretary['rutFormated'] = $secretary->rutFormated();
        
        $completeHospital['patients'][] = $completePatient;
      }
      $tempReg['hospitals'][] = $completeHospital; 
    }
    JavaScript::put([
      'hospitals' => $tempReg['hospitals']
    ]);    
    
    $this->layout->header = View::make('navbars.dashboardNavBar');
    $this->layout->function = View::make('dashboard.doctorSidebar');
    $this->layout->section = View::make('doctor.patients');
  }
}