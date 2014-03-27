<?php

class AuthController extends BaseController {
    
    protected $layout = 'layouts.default';
    public function showLogin()
    {
        $this->layout->header = View::make('navbars.homeNavBar');
        $this->layout->content = View::make('login.signin'); 
    }
    
    public function doLogin()
    {
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
            // De ser datos válidos nos mandara a la bienvenida
            return Redirect::to('/');
        }
        // En caso de que la autenticación haya fallado manda un mensaje al formulario de login y también regresamos los valores enviados con withInput().
        
      return Redirect::to('/')
        ->with('error_message', 'RUT y/o contraseña incorrecta')
                    ->withInput();
    }
    
    public function doLogOut()
    {
        Auth::logout();
        return Redirect::to('/signin')
                    ->with('error_message', 'Tu sesión ha sido cerrada.');
    }
}