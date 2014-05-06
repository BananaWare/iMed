<?php

class DoctorController extends SecretaryController {

  protected $layout = 'layouts.dashboard';
  
  public function index()
  {
    $this->layout->header = View::make('navbars.homeNavBar');
    $this->layout->function = View::make('dashboard.doctorSidebar');
  }
  public function doUnassignSecretary()
  {
    
    SecretaryDoctor::find(Input::get('idSecretaryDoctor'))->delete();
    
    /*UserRole::where('rut', '=', $secDoc->secretarysRut)
      ->where('idHospital', '=', $secDoc->idHospital)
      ->where('role', '=', 'secretary');*/
  }
  
  public function doAssignSecretary()
  {
    define('PASSWORD', "1234");
    $data = Input::all();
    $rules = array(
      'rut' => array('required', 'regex:/^(\.|\d)+-(k|K|\d)$/')
    );
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
      return $validator;
    }
    $rutSinPuntos = str_replace(".", "", Input::get('rut'));
    list($rut, $dv) = explode("-", $rutSinPuntos);
    $secretary = User::where('rut', '=', $rut)->first();

    
    if (!isset($secretary))
    {
      
      $secretary = new User();
      
      $secretary->name = null;
      $secretary->lastname = null;
      $secretary->rut = $rut;
      $secretary->dv = $dv;
      $secretary->password = Hash::make(PASSWORD);
      //$secretary->role = 'secretary';
      
      $secretary->save();
    }
    else
      $secretaryInfo = $secretary->getUserInfoFromHospital(Input::get('idHospital'));
    
    if (!isset($secretaryInfo))
    {
        $secretaryInfo = new UserInfo();
        $secretaryInfo->rut = $rut;
        $secretaryInfo->dv = $dv;
        $secretaryInfo->idHospital = Input::get('idHospital');
        $secretaryInfo->save();
    }
    
    $secretaryDoctor = new SecretaryDoctor();
    $secretaryDoctor->doctorsRut = Auth::user()->rut;
    $secretaryDoctor->secretarysRut = $rut;
    $secretaryDoctor->idHospital = Input::get('idHospital');
    $secretaryDoctor->save();
    
    if (!$secretary->isSecretaryOn(Input::get('idHospital')))
    {
      $role = new UserRole();
      $role->rut = $rut;
      $role->role = "secretary";
      $role->idHospital = Input::get('idHospital');
      $role->save();
    }
    
    $secretary["userInfo"] = $secretary->getUserInfoFromHospital(Input::get('idHospital'))->toArray();
    $secretary->pivot = $secretaryDoctor->toArray();
    return $secretary->toJson();
  }
  
  public function doLockSecretary()
  {
    $secretaryDoctor = SecretaryDoctor::where('doctorsRut', '=', Auth::user()->rut)
      ->where('secretarysRut', '=', Input::get('secretarysRut'))->first();
    $secretaryDoctor->active = false;
    $secretaryDoctor->save();
  }
  
  public function doUnlockSecretary()
  {
    $secretaryDoctor = SecretaryDoctor::where('doctorsRut', '=', Auth::user()->rut)
      ->where('secretarysRut', '=', Input::get('secretarysRut'))->first();
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
  public function showSecretaries()
  {
    $doctor = Auth::user(); 
    $hospitals = $doctor->hospitals;
    
    foreach($hospitals as $hospital)
    {
      $completeHospital = $hospital->toArray();
      $secretaries = $doctor->getSecretariesFromHospital($hospital->idHospital)->get();
      foreach($secretaries as $secretary)
      {
        $completeSecretary = $secretary->toArray();
        $completeSecretary['userInfo'] = $secretary->getUserInfoFromHospital($hospital->idHospital)->toArray();
        $completeHospital['secretaries'][] = $completeSecretary;
      }
      $tempReg['hospitals'][] = $completeHospital; 
    }
    JavaScript::put([
      'hospitals' => $tempReg['hospitals']
    ]);    
    
    $this->layout->header = View::make('navbars.dashboardNavBar');
    $this->layout->function = View::make('dashboard.doctorSidebar');  
    $this->layout->section = View::make('doctor.secretaries'); 
  }
}