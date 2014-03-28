<?php

class DoctorController extends SecretaryController {

  public function createSecretary()
  {
    $user = new User();
    $userInfo = new UserInfo();
    $this->createUser($user, $userInfo);
    $user->role = 'secretary';
   
    $user->save();
    $userInfo->save();
  }
  
  public function modifySecretary()
  {
    
    
  }
}