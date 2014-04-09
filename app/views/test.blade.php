<!DOCTYPE html>
<html lang="en">
  <head>
    
  </head>

  <body>
    
    <form action="/assignSecretary">    
      Rut <input name="rut" />
      Hospital <input name="idHospital" />
      <input type="submit" value="Asignar" />
    </form>
  </body>
  <br />
  Secretarias del doctor
  <br />
  {{ 
  '</br>';
  $asdf = Auth::user()->getSecretariesFromHospital(1)->get();
  foreach($asdf as $o)
  {
    echo $o->rut . $o->name . $o->pivot->active.
      ' - <a href="/lockSecretary?secretarysRut='.$o->rut.'">Desactivar</a>'.
      ' - <a href="/unlockSecretary?secretarysRut='.$o->rut.'">Activar</a>'.
' - <a href="/unassignSecretary?secretarysRut='.$o->rut.'">Eliminar</a></br>';
  }
  }}

</html>
