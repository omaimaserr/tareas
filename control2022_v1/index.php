<?php
session_start();

include_once('app/funciones.php');

// intentos
if (!isset($_SESSION['intentos'])){
  $_SESSION['intentos'] = 0;
}


if (  !empty( $_GET['login']) && !empty($_GET['clave'])){

  // para comprobar los intentos
  if ($_SESSION['intentos'] >= 5){
    $contenido = "Superado el número máximo de accesos erróneos";
    include_once('app/acceso.php');
    exit;
  }

    if ( userOk($_GET['login'],$_GET['clave'])){

      // reiniciar el contador
      $_SESSION['intentos'] = 0;

      if ( getUserRol($_GET['login']) == ROL_PROFESOR){
        $contenido = verNotaTodas($_GET['login']);

      } else {
        $contenido = verNotasAlumno($_GET['login']);

      }
      include_once ('app/resultado.php');

    } 
    // userOK falso
    else {
      // sumar errores de sesión
      $_SESSION['intentos'] ++;
       $contenido = "El número de usuario y la contraseña no son válidos";
       include_once('app/acceso.php');
    }

} else {
    $contenido = " Introduzca su número de usuario y su contraseña";
    include_once('app/acceso.php');
}
