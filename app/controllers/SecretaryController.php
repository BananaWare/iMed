<?php

class SecretaryController extends BaseController {
  
  protected $layout = 'layouts.dashboard';
  public function index()
  {
    $this->layout->header = View::make('navbars.homeNavBar');
    //$this->layout->content = View::make('dasb');
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
  
  protected function createUser(&$user, &$userInfo)
  {
    list($user->rut, $user->dv) = explode("-", Input::get('rut'));
    $user->name = Input::get('name');
    $user->lastname = Input::get('lastname');
    $user->gender = Input::get('gender');
    $user->birthDate = Input::get('birthDate');
    
    $userInfo->rut = $user->rut;
    $userInfo->dv = $user->dv;
    $userInfo->email = Input::get('email');
    $userInfo->phone = Input::get('phone');
    // TODO: cambiar esto.
    $userInfo->idHospital = 1;
    //$userInfo->idHospital = Input::get('idHospital');

  }
  
  public function modifyPatient()
  {
    $user = User::whereRaw('role = patient and rut = ?', Input::get('rut'))->first();
    list($user->rut, $user->dv) = explode("-", Input::get('rut'));
    $user->name = Input::get('name');
    $user->lastname = Input::get('lastname');
    $user->gender = Input::get('gender');
    $user->birthDate = Input::get('birthDate');
    
    $userInfo = UserInfo::whereRaw('rut = ?', Input::get('rut'))->first();
    $userInfo->rut = $user->rut;
    $userInfo->dv = $user->dv;
    $userInfo->email = Input::get('email');
    $userInfo->phone = Input::get('phone');
    $user->save();
    $userInfo->save();
  }
  
  public function removePatient()
  {
    $user = User::whereRaw('role = patient and rut = ?', Input::get('rut'))->first();
    $user->delete();
  }
  
  public function assignHour()
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
}