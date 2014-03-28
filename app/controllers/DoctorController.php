<?php

class DoctorController extends SecretaryController {

  public function createSecretary()
  {
    $user = new User();
    $userInfo = new UserInfo();
    $this->createUser($user, $userInfo);
    $user->role = 'secretary';
    
    $secretaryDoctor = new SecretaryDoctor();
    $secretaryDoctor->doctorsRut = Auth::user()->rut;
    $secretaryDoctor->secretarysRut = $user->rut;
    $secretaryDoctor->active = true;
   
    $user->save();
    $userInfo->save();
    $secretaryDoctor->save();
  }
  
  public function modifySecretary()
  {
    $user = User::whereRaw('role = secretary and rut = ?', Input::get('rut'))->first();
    $userInfo = UserInfo::whereRaw('rut = ?', Input::get('rut'))->first();
    $this->setUserWithInputs($user, $userInfo);
    
    $user->save();
    $userInfo->save();
  }
  
  public function removeSecretary()
  {
    $secretary = User::whereRaw('role = secretary and rut = ?', Input::get('rut'))->first();
    $secretary->delete();
  }
  
  public function lockSecretary()
  {
    $secretaryDoctor = SecretaryDoctor::whereRaw('doctorsRut = ? and secretarysRut = ?', Auth::user()->rut, Input::get('secretarysRut'))->first();
    $secretaryDoctor->active = false;
    $secretaryDoctor->save();
  }
  
  public function unlockSecretary()
  {
    $secretaryDoctor = SecretaryDoctor::whereRaw('doctorsRut = ? and secretarysRut = ?', Auth::user()->rut, Input::get('secretarysRut'))->first();
    $secretaryDoctor->active = true;
    $secretaryDoctor->save();
  }
  
  public function createSchedule()
  {
    $doctorSchedule = new DoctorSchedule();
    $doctorSchedule->doctorsRut = Auth::user()->rut;
    //TODO: Cambiar la forma en que se asigna la idHospital.
    $doctorSchedule->idHospital = 1;
    $doctorSchedule->dayOfWeek = Input::get('dayOfWeek');
    $doctorSchedule->startHour = Input::get('startHour');
    $doctorSchedule->endHour = Input::get('endHour');
    $doctorSchedule->intervalTime = Input::get('intervalTime');
    
    $doctorSchedule->save();
  }
  
  public function modifySchedule()
  {
    $doctorSchedule = DoctorSchedule::find(Input::get('idDoctorSchedule'));
    $doctorSchedule->startHour = Input::get('startHour');
    $doctorSchedule->endHour = Input::get('endHour');
    $doctorSchedule->intervalTime = Input::get('intervalTime');
    
    $doctorSchedule->save();
  }
  
  public function deleteSchedule()
  {
    DoctorSchedule::destroy(Input::get('idDoctorSchedule'));
  }
  
  public function getDoctorsSchedules()
  {
    DoctorSchedule::where('doctorsRut', Auth::user()->rut);
  }
}