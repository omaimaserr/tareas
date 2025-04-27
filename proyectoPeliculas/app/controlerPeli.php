<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------

include_once 'config.php';
include_once 'modeloPeliDB.php';
include_once 'Pelicula.php';


/**********
/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function  ctlPeliInicio()
{
    include 'plantillas/todo.php';
}

/*
 *  Muestra y procesa el formulario de alta 
 */

function ctlPeliAlta()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        include_once 'plantillas/fnueva.php';
    } else {
        $peli = new Pelicula();
        $peli->nombre = $_POST['nombre'];
        $peli->director = $_POST['director'];
        $peli->genero = $_POST['genero'];

        if ( !empty ($_FILES['imagen']['name'])){
            if (procesarImagen() ){
                $peli -> imagen = $_FILES['imagen']['name'];
            }
        }
        $db = ModeloPeliDB::getModelo();
        $peli = $db->insert($peli);
        $_SESSION['msg'] = "Película añadida";
        ctlPeliVerPelis();
    }
}

/*
 *  Muestra y procesa el formulario de Modificación 
 */
function ctlPeliModificar()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['id'])) {
            $db = ModeloPeliDB::getModelo();
            $peli = $db->getById($_GET['id']);
            include_once 'plantillas/fmodificar.php';
        }
    } else {
        $peli = new Pelicula();
        $peli->codigo_pelicula = $_POST['codigo_pelicula'];
        $peli->nombre = $_POST['nombre'];
        $peli->director = $_POST['director'];
        $peli->genero = $_POST['genero'];
        $peli->imagen = $_POST['imagenold'];

        if (!empty($_FILES['imagen']['name'])) {
            if (procesarImagen()) {
                $peli->imagen = $_FILES['imagen']['name'];
            }
        }
        $db = ModeloPeliDB::getModelo();
        $peli = $db->Update($peli);
        $_SESSION['msg'] = "Película actualizada";
        ctlPeliVerPelis();
    }
}


function procesarImagen(): bool
{
    $error = $_FILES['imagen']['error'];
    $nombre = $_FILES['imagen']['name'];
    $nombretmp = $_FILES['imagen']['tmp_name'];

    if ($error == 0) {
        if (move_uploaded_file($nombretmp, 'app/img/' . $nombre))
            return true;
    }
    return false;
}




/*
 *  Muestra detalles de la pelicula
 */

function ctlPeliDetalles()
{
    $db = ModeloPeliDB::getModelo();
    $peli = $db->getbyId($_GET['id']);
    include_once 'plantillas/detalle.php';
}
/*
 * Borrar Peliculas
 */

function ctlPeliBorrar()
{
    $db = ModeloPeliDB::getModelo();
    $peli = $db->deletebyId($_GET['id']);
    $_SESSION['msg'] = " Película eliminada ";
    ctlPeliVerPelis();
}

/*
 * Cierra la sesión y vuelca los datos
 */
function ctlPeliCerrar()
{
    session_destroy();
    modeloPeliDB::closeDB();
    header('Location:index.php');
}

/*
 * Muestro la tabla con los usuario 
 */
function ctlPeliVerPelis()
{
    // Obtengo los datos del modelo
    $db = ModeloPeliDB::getModelo();
    $peliculas = $db->getAll();
    // Invoco la vista 
    include_once 'plantillas/verpeliculas.php';
}


function ctlPeliBuscarTitulo()
{
    $titulo = $_GET['valor'];
    $db = ModeloPeliDB::getModelo();
    $peliculas = $db->getByTitulo($titulo); //get por titulo
    include_once 'plantillas/verpeliculas.php';
}

function ctlPeliBuscarDirector()
{
    $director = $_GET['valor'];
    $db = ModeloPeliDB::getModelo();
    $peliculas = $db->getByDirector($director); //get por genero
    include_once 'plantillas/verpeliculas.php';
}

function ctlPeliBuscarGenero()
{
    $genero = $_GET['valor'];
    $db = ModeloPeliDB::getModelo();
    $peliculas = $db->getByGenero($genero); //get por genero
    include_once 'plantillas/verpeliculas.php';
}





