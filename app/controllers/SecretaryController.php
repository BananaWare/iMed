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
    $this->layout->header = View::make('navbars.dashboardNavBar');
    $this->layout->function = View::make('dashboard.secretarySidebar');  
    //$this->layout->section = View::make('dasb');
  }
  
  public function createPatient()
  {
    $user = new User();
    $userInfo = new UserInfo();
    $this->createUser($user, $userInfo);
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
  protected function createUser(&$user, &$userInfo)
  {
    $this->setUserWithInputs($user, $userInfo);
    list($user->rut, $user->dv) = explode("-", Input::get('rut'));
    // TODO: cambiar esto.
    $userInfo->idHospital = 1;
    //$userInfo->idHospital = Input::get('idHospital');
  }
 
  public function modifyPatient()
  {
    $user = User::whereRaw('role = patient and rut = ?', Input::get('rut'))->first();
    //TODO: cambiar el numero de idHospital.
    $userInfo = UserInfo::whereRaw('rut = ? and idHospital = ?', Input::get('rut'), 1)->first();
    $this->setUser($user, $userInfo);
    
    $user->save();
    $userInfo->save();
  }
  
  /**
    Establece los campos de user: name, lastname, gender y birthdate. Y
    establece los campos de userInfo: rut, dv, email, phone.
    Nota: No establece el campo de userInfo idHospital.
  */
  protected function setUserWithInputs(&$user, &$userInfo)
  {
    //list($user->rut, $user->dv) = explode("-", Input::get('rut'));
    $user->name = Input::get('name');
    $user->lastname = Input::get('lastname');
    $user->gender = Input::get('gender');
    $user->birthDate = Input::get('birthDate');
    
    $userInfo->rut = $user->rut;
    $userInfo->dv = $user->dv;
    $userInfo->email = Input::get('email');
    $userInfo->phone = Input::get('phone');
  }
  public function removePatient()
  {
     //TODO: cambiar el numero de idHospital.
    $user = User::whereRaw('role = patient and rut = ? and idHospital = ?', Input::get('rut'), 1)->first();
    $user->delete();
  }
  
  public function doAssignHour()
  {
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
    //TODO: cambiar el numero de idHospital.
    $userInfo = UserInfo::whereRaw('role = patient and rut = ? and idHospital = ?', Input::get('rut'), 1)->first();
  }
}