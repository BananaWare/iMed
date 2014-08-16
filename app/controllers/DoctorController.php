<?php

class DoctorController extends SecretaryController {

  protected $layout = 'layouts.dashboard';
  
  public function index()
  {
    
    JavaScript::put([
      'hospitals' => Auth::user()->hospitals
    ]);
    
    $this->layout->function = View::make('dashboard.doctorSidebar');
    $this->layout->section = View::make('doctor.dashboard');
  }
  public function doUnassignSecretary()
  {
    SecretaryDoctor::find(Input::get('idSecretaryDoctor'))->delete();
  }
  
  public function doAssignSecretary()
  {
    //define('PASSWORD', "1234"); password = rut;
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

    if (isset($secretary))
      $existSecretary = true;
    else
      $existSecretary = false;
    
    if (!$existSecretary)
    {
      
      $secretary = new User();
      
      $secretary->name = null;
      $secretary->lastname = null;
      $secretary->rut = $rut;
      $secretary->dv = $dv;
      $secretary->password = Hash::make($rut);
      
      $secretary->save();
    }
    else
      $secretaryInfo = $secretary->getUserInfoFromHospital(Input::get('idHospital'));
    
    if (isset($secretaryInfo))
      $existSecretaryInfo = true;
    else
      $existSecretaryInfo = false;
    
    if (!$existSecretaryInfo)
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
    
    $respose = array();
    if (!$existSecretary || !$existSecretaryInfo)
      $response['exist'] = false;
    else 
      $response['exist'] = true;
    $response['secretary'] = $secretary->toJson();
    //return var_dump($response);
    return $response;
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
  /*
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
  */
  /*
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
  
  public function getDoctorsSchedulesFromHospitalSelected()
  {
    
  }
  */
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
    
    $this->layout->function = View::make('dashboard.doctorSidebar');  
    $this->layout->section = View::make('doctor.secretaries'); 
  }
  public function showPrescriptions()
  {
    $date = new DateTime("now", new DateTimeZone('America/Santiago'));
    
    // Envíamos también la hora del servidor
    JavaScript::put([
      'hospital' => $this->getPatientsFullFromHospitalSelected(true, Auth::user()->rut),
      'dateTimeNow' => $date->format('Y-m-d H:i:s'),
      'user' => Auth::user()
    ]);
    
    $this->layout->function = View::make('dashboard.doctorSidebar');  
    $this->layout->section = View::make('doctor.prescriptions');  
    //var_dump($tempReg['hospitals'][0]['patients']['1']['patientHours']['0']['medicalSheet']);
  }
  
  public function schedules()
  {
    $schedulesComplete= array();
    $sch = Auth::user()
      ->getDoctorsScheduleFromHospital(Session::get('idHospitalSelected'))->get();
    
    for($i=0; $i<7; $i++)
    {
    
        $nuevo = new DoctorSchedule();
        $nuevo->dayOfWeek = $i+1;
        $schedulesComplete[] = $nuevo;
    }
    
    
    foreach($sch as $z)
    {
      //Quitando los segundos, buscar mejor forma de hacerlo, quizas en el modelo.
      $z->startHour = substr($z->startHour, 0, -3);
      $z->endHour = substr($z->endHour, 0, -3);
      $z->intervalTime = substr($z->intervalTime, 0, -3);
                             
      $schedulesComplete[$z->dayOfWeek-1] = $z;
    }
    
    JavaScript::put([
      'schedules' => $schedulesComplete
    ]);
    
    $this->layout->function = View::make('dashboard.doctorSidebar');  
    $this->layout->section = View::make('doctor.schedules')->withSchedules($schedulesComplete);
  }
  
  public function billings()
  {
    $billings = Auth::user()->getBillingsFromHospital(Session::get('idHospitalSelected'))
      ->orderBy('startDateTime', 'desc') ->get();
    
    // obtenemos pagos que aun no hayan sido totalmente usados.
    $activeBillings = $billings->filter(function($b){
      if ($b->status == "active")
        return true;
    });
   
    $daysPast = null;
    if ($billings->count() == 0)
      $status = 'new';
    else if ($activeBillings->count() == 0)
      $status = 'freeze';
    else
    {
       // Dias pasados desde el primera pago activo
      $daysPast = (new DateTime($activeBillings->last()->startDateTime))->diff(new DateTime())->format('%R%a');
      $status = 'active';
    }
    
    $totalActiveDays = 0;
    $forLife = false;
    foreach($activeBillings as $aB)
    {
      $totalActiveDays += $aB->daysOfType;
      if ($aB->type == 'forLifeSuscription')
        $forLife = true;
    }
    
    if ($forLife)
      $daysRemaining = "Vitalicia";
    else
      $daysRemaining = $totalActiveDays - $daysPast;
    
    $this->layout->function = View::make('dashboard.doctorSidebar');
    $this->layout->section = View::make('doctor.billings')->withBillings($billings)->withDays($daysRemaining)
      ->withStatus($status);
  }
  
  public function doChangeSchedules()
  {
    $schedules = Input::get('schedules');
    foreach($schedules as $schedule)
    {
      $doctorSchedule = DoctorSchedule::find($schedule['idDoctorSchedule']);
      
      if ($schedule['activate'] === "false") 
      {
          if ($doctorSchedule != null)
            $doctorSchedule->delete();
      }
      else
      {
        if ($doctorSchedule == null)
          $doctorSchedule = new DoctorSchedule();
        
        $doctorSchedule->startHour = $schedule['startHour'];
        $doctorSchedule->endHour = $schedule['endHour'];
        $doctorSchedule->intervalTime = $schedule['intervalTime'];
        $doctorSchedule->dayOfWeek = $schedule['dayOfWeek'];
        $doctorSchedule->idHospital = Session::get('idHospitalSelected');
        $doctorSchedule->doctorsRut = Auth::user()->rut;

        if ($doctorSchedule->startHour != null && $doctorSchedule->endHour != null 
            && $doctorSchedule->intervalTime !=   null)
          $doctorSchedule->save();
      }
    }
    return 'true';
  }
   public function doSavePrescriptionAndMedicalSheet()
   {
     $medicalHistory = User::find(Input::get('rut'))->getUserInfoFromHospital(Session::get('idHospitalSelected'))->medicalHistory;
     
     if($medicalHistory == null)
        return 'Error obteniendo la historia médica';
     $medicalHistory->adr = Input::get('adr');
     $medicalHistory->morbid = Input::get('morbid');
     $medicalHistory->gynecological = Input::get('gynecological');
     $medicalHistory->family = Input::get('family');
     $medicalHistory->habit = Input::get('habit');
     $medicalHistory->other = Input::get('other');
     $medicalHistory->save();
     
     $medicalSheet = new MedicalSheet();
     $medicalSheet->observation = Input::get('observation');
     $medicalSheet->generalExamination = Input::get('generalExamination');
     $medicalSheet->bloodPressure = Input::get('bloodPressure');
     $medicalSheet->temperature = Input::get('temperature');
     $medicalSheet->sat = Input::get('sat');
     $medicalSheet->segmentary = Input::get('segmentary');
     $medicalSheet->complementary = Input::get('complementary');
     $medicalSheet->diagnostic = Input::get('diagnostic');
     $medicalSheet->idHour = Input::get('idHour');
     $medicalSheet->save();
     
     $patientHour = PatientHour::find(Input::get('idHour'));
     $patientHour->idSheet = $medicalSheet->idSheet;
     $patientHour->save();
     
     if(Input::get('drugsPrescriptions') == null)
       $medicalSheet->idPrescription = null;
     else
     {
       $prescription = new Prescription();
       
       $prescription->medicalSheet()->associate($medicalSheet);
       $prescription->save();
       foreach(Input::get('drugsPrescriptions') as $drugPrescription)
       {
         $dP = new DrugPrescription();
         if ($drugPrescription['idDrug'] !== "")
           $dP->idDrug = $drugPrescription['idDrug'];
         else
           $dP->bruteDrugName = $drugPrescription['bruteDrugName'];
         $dP->dosage = $drugPrescription['dosage'];
         $dP->term = $drugPrescription['term'];
         $dP->observation = $drugPrescription['observation'];
         $dP->intervalTime = $drugPrescription['intervalTime'];
         
         $prescription->drugsPrescriptions()->save($dP);
       }
     }

     return 'true';
   }
}