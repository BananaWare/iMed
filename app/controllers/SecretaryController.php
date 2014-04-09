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
    if(!$this->doCreateUser($user, $userInfo))
      return Redirect::to('/createPatient')
        ->with('error_message', 'Datos en formato no válido')
        ->withInput();
    
    $user->role = 'patient';
   
    $user->save();
    $userInfo->save();
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
      'rut' => array('required', 'regex:/\b\d{1,9}\-(K|k|\d)/')
    );
  
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
      return false;
    }
    
    if(!$this->setUserWithInputs($user, $userInfo))
      return false;
    
    list($user->rut, $user->dv) = explode("-", Input::get('rut'));
    $userInfo->rut = $user->rut;
    $userInfo->dv = $user->dv;
    // TODO: cambiar esto.
    $userInfo->idHospital = 1;
    //$userInfo->idHospital = Input::get('idHospital');
    return true;
  }
 
  public function doModifyPatient()
  {
    $data = Input::all();
    $rules = array(
      'rut' => array('required', 'regex:/\b\d{1,9}\-(K|k|\d)/')
    );
  
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
      return Redirect::to('/modifyPatient');
    }
    
    //$user = User::whereRaw('role = patient and rut = ?', Input::get('rut'))->first();
    $user = User::where('rut', '=', Input::get('rut'))->first();
    //TODO: cambiar el numero de idHospital.
    //$userInfo = UserInfo::whereRaw('rut = ? and idHospital = ?', Input::get('rut'), 1)->first();
    $userInfo = UserInfo::where('rut', '=', Input::get('rut'))->where('role', '=', 'patient')
      ->where('idHospital', '=', 1)->first();
    if (!$this->setUserWithInputs($user, $userInfo))
      return Redirect::to('/modifyPatient')
        ->with('error_message', 'Datos en formato no válido')
        ->withInput();
    
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
      'birthDate' => 'date',
      'email' => 'email',
      'phone' => 'numeric'
    );
  
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
      return false;
    }
    list($user->rut, $user->dv) = explode("-", Input::get('rut'));
    $userInfo->rut = $user->rut;
    //list($user->rut, $user->dv) = explode("-", Input::get('rut'));
    $user->name = Input::get('name');
    $user->lastname = Input::get('lastname');
    $user->gender = Input::get('gender');
    $user->birthDate = Input::get('birthDate');
    
    $userInfo->email = Input::get('email');
    $userInfo->phone = Input::get('phone');
    return true;
  }
  public function doRemovePatient()
  {
    $data = Input::all();
    $rules = array(
      'rut' => array('required', 'regex:/\b\d{1,9}\-(K|k|\d)/'),
      'idHospital' => 'required|numeric'
    );
    list($rut, $dv) = explode("-", Input::get('rut'));
    
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
      'doctorsRut' => array('required', 'regex:/\b\d{1,9}\-(K|k|\d)/'),
      'patientsRut' => array('required', 'regex:/\b\d{1,9}\-(K|k|\d)/'),
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
      'rut' => array('required', 'regex:/\b\d{1,9}\-(K|k|\d)/')
    );
  
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
      return Redirect::to('/patients');
    }
    //TODO: cambiar el numero de idHospital.
    //$userInfo = UserInfo::whereRaw('role = patient and rut = ? and idHospital = ?', Input::get('rut'), 1)->first();
    $userInfo = UserInfo::where('role', '=', 'patient')->where('rut', '=', Input::get('rut'))
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