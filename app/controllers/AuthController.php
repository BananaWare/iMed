<?php

class AuthController extends BaseController {
    
    public function showLogin()
    {
            return Redirect::to('/');
    }
    
    public function postLogin()
    {
        // Guardamos en un arreglo los datos del usuario.
        $userdata = array(
            'rut' => Input::get('username'),
            'password'=> Input::get('password'),
        );
        // Validamos los datos y además mandamos como un segundo parámetro la opción de recordar el usuario.
      if(Auth::attempt($userdata))
        {
            // De ser datos válidos nos mandara a la bienvenida
            return Redirect::to('/');
        }
        // En caso de que la autenticación haya fallado manda un mensaje al formulario de login y también regresamos los valores enviados con withInput().
        
      return Redirect::to('/')
                    ->with('error_message', 'Datos incorrectos')
                    ->withInput();
    }
    
    public function logOut()
    {
        Auth::logout();
        return Redirect::to('/')
                    ->with('error_message', 'Tu sesión ha sido cerrada.');
    }
}