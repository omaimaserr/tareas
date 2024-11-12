<?php
require_once(__DIR__ . '/../dat/datos.php');

/**
 *  Devuelve true si el código del usuario y contraseña se 
 *  encuentra en la tabla de usuarios
 *  @param $login : Código de usuario
 *  @param $clave : Clave del usuario
 *  @return true o false
 */
function userOk($login, $clave): bool {
    global $usuarios;
    return isset($usuarios[$login]) && $usuarios[$login][1] === $clave;
}


/**
 *  Devuelve el rol asociado al usuario
 *  @param $login: código de usuario
 *  @return ROL_ALUMNO o ROL_PROFESOR
 */
function getUserRol($login){
    global $usuarios;
    return $usuarios[$login][2];
}


/**
 *  Muestra las notas del alumno indicado.
 *  @param $codigo: Código del usuario
 *  @return $devuelve una cadena con una tabla html con los resultados 
 */

function verNotasAlumno($codigo):String{
    $msg="";
    global $nombreModulos;
    global $notas;
    global $usuarios;

    $nombre = $usuarios[$codigo][0];

    $msg .= " Bienvenido/a alumno/a: $nombre ";
    $msg .= "<table style='border: 1px solid black'><tr><th> Asignatura </th> <th> Nota </th></tr>";

    if (isset($notas[$codigo])){
        foreach ($nombreModulos as $indice => $modulo) {
            $nota = $notas[$codigo][$indice] ;
            $msg .= "<tr><td>$modulo</td><td> $nota</td></tr>" ;
        }
    }

    $msg .= "</table>";
    return $msg;
}


/**
 *  Muestra las notas de todos alumnos. 
 *  @param $codigo: Código del profesor
 *  @return $devuelve una cadena con una tabla html con los resultados 
 */
function verNotaTodas ($codigo): String {
    $msg="";
    global $nombreModulos;
    global $notas;
    global $usuarios;

    $nombre = $usuarios[$codigo][0];

    $msg .= " Bienvenido Profesor: D. $nombre ";
    $msg .= "<table style='border: 1px solid black'><tr><th> Alumno </th>";

    foreach ($nombreModulos as $modulo) {
        $msg .= "<th>$modulo</th>";
    }
    $msg .= "</tr>";

    foreach ($notas as $alumno => $calificaciones) {
        $nombreAlumno = $usuarios[$alumno][0];
        $msg .= "<tr><td>$nombreAlumno</td>";

        foreach ($calificaciones as $nota) {
            $msg .= "<td>$nota</td>";
        }
        $msg .= "</tr>";
    }


    $msg .= "</table>";
    return $msg;
}