<?php

class AuthController extends BaseController {
    
    public function showLogin()
    {
      return View::make('login.signin'); 
    }
    
    public function doLogin()
    {
      $data = Input::all();
      $rules = array(
        'username' => array('required', 'regex:/\b\d{1,11}\-(K|k|\d)/'),
        'password' => 'required|max:20'
      );
  
      // Create a new validator instance.
      $validator = Validator::make($data, $rules);
  
      if (!$validator->passes()) {
        return Redirect::to('signin')
          ->with('error_message', 'Datos en formato no válido')
                      ->withInput();
      }
        list($rut, $dv) = explode("-", Input::get('username'));
        // Guardamos en un arreglo los datos del usuario.
        $userdata = array(
            'rut' => $rut,
            'dv' => $dv,
            'password'=> Input::get('password'),
        );
        // Validamos los datos y además mandamos como un segundo parámetro la opción de recordar el usuario.
        if(Auth::attempt($userdata))
        {
          // Si se había logeado previamente otro usuario o nadie, entonces se actualizan datos de usuario
          // logeado y hospital seleccionado.
          if (Session::get('rutLogged') == null || Session::get('rutLogged') != Auth::user()->rut)
          {
            Session::set('rutLogged', Auth::user()->rut);
            Session::set('idHospitalSelected', Auth::user()->hospitals[0]->idHospital);
          }
          // De ser datos válidos nos mandara a la bienvenida
          return Redirect::to('/dashboard');
        }
        // En caso de que la autenticación haya fallado manda un mensaje al formulario de login y también regresamos los valores enviados con withInput().
        
      return Redirect::to('/')
        ->with('error_message', 'RUT y/o contraseña incorrecta')
                    ->withInput();
    }
    
    public function doLogOut()
    {
        Auth::logout();
        return Redirect::to('/')
                    ->with('error_message', 'Tu sesión ha sido cerrada.');
    }
}