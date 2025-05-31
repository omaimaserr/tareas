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
    session_start();
    if (!isset($_SESSION['usuario'])) {
        echo "Acceso denegado. Debes estar logueado para realizar esta acción.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        include_once 'plantillas/fnueva.php';
    } else {
        $peli = new Pelicula();
        $peli->nombre = $_POST['nombre'];
        $peli->director = $_POST['director'];
        $peli->genero = $_POST['genero'];

        if (!empty($_FILES['imagen']['name'])) {
            if (procesarImagen()) {
                $peli->imagen = $_FILES['imagen']['name'];
            }
        }
        $db = ModeloPeliDB::getModelo();
        $db->insert($peli);
        $_SESSION['msg'] = "Película añadida";
        ctlPeliVerPelis();
    }
}

/*
 *  Muestra y procesa el formulario de Modificación 
 */
function ctlPeliModificar()
{
    session_start();
    if (!isset($_SESSION['usuario'])) {
        echo "Acceso denegado. Debes estar logueado para realizar esta acción.";
        exit;
    }

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
    session_start();
    if (!isset($_SESSION['usuario'])) {
        echo "Acceso denegado. Debes estar logueado para realizar esta acción.";
        exit;
    }

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





/**
 * Buscar pelis
 */
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




/**
 * Descargar info peliculas
 */
function ctlPeliDescargarJSON()
{
    ob_clean();

    $db = ModeloPeliDB::getModelo();
    $pelis = $db->getAll();

    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="peliculas.json"');

    $datos = array_map(function ($p) {
        return [
            'codigo_pelicula' => $p->codigo_pelicula,
            'nombre'          => $p->nombre,
            'director'        => $p->director,
            'genero'          => $p->genero,
        ];
    }, $pelis);

    echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function ctlPeliDescargarCSV()
{
    $db = ModeloPeliDB::getModelo();
    $pelis = $db->getAll();

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="peliculas.csv"');

    $salida = fopen('php://output', 'w');
    fputcsv($salida, ['ID', 'Nombre', 'Director', 'Género']);

    foreach ($pelis as $p) {
        fputcsv($salida, [
            $p->codigo_pelicula,
            $p->nombre,
            $p->director,
            $p->genero
        ]);
    }

    fclose($salida);
    exit;
}

function ctlPeliDescargarPDF()
{
    // importar la libreria de fpdf
    require_once 'app/librerias/fpdf.php';

    $db = ModeloPeliDB::getModelo();
    $pelis = $db->getAll();

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Listado de Peliculas', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 12);
    foreach ($pelis as $p) {
        $pdf->Cell(0, 10, "ID: {$p->codigo_pelicula} - {$p->nombre} - {$p->director} - {$p->genero}", 0, 1);
    }

    $pdf->Output('D', 'peliculas.pdf');
}



/**
 * Votar
 */
function ctlPeliVotar()
{
    // contar los votos con cookies
    session_start();
    $error = "";

    $votos = isset($_COOKIE['votos_hoy']) ? (int) $_COOKIE['votos_hoy'] : 0;

    if ($votos >= 5) {
        $error = "Has alcanzado el límite de 5 votos para hoy. Intenta de nuevo mañana.";
    }

    if ($error === "") {
        if (!isset($_GET['id']) || !isset($_POST['puntos'])) {
            $error = "Datos incompletos.";
        }
    }

    if ($error === "") {
        $id = $_GET['id'];
        $puntos = intval($_POST['puntos']);

        $db = ModeloPeliDB::getModelo();
        $peli = $db->getById($id);

        if (!$peli) {
            $error = "Película no encontrada.";
        }
    }

    if ($error === "") {
        $peli->votos += 1;
        $peli->puntuacion_total += $puntos;

        if ($db->update($peli)) {
            $votos++; // actualizar cookies del día
            // configurar cookies para restablecerlas cada día
            $ahora = time();
            $medianoche = strtotime('tomorrow midnight');
            $segundos_restantes = $medianoche - $ahora;
            setcookie('votos_hoy', $votos, $ahora + $segundos_restantes, "/");

            header("Location: index.php?orden=Detalles&id=$id");
            exit;
        } else {
            $error = "Error al votar.";
        }
    }

    // mostrar mensaje error
    if ($error !== "") {
        $_SESSION['error_voto'] = $error;
        $id = $_GET['id'] ?? '';
        header("Location: index.php?orden=Detalles&id=$id");
        exit;
    }
}









/**
 * 
 * USUARIOS 
 *  
 */

function ctlLogin()
{
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include_once 'app/plantillas/login.php';
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['usuario']) || !isset($_POST['password'])) {
            header("Location: index.php?orden=Login&error=1");
            exit;
        }

        $usuario = trim($_POST['usuario']);
        $password = $_POST['password'];

        $db = ModeloPeliDB::getModelo();
        $userObj = $db->getUsuarioByNombre($usuario);

        if (!$userObj) {
            header("Location: index.php?orden=Login&error=1");
            exit;
        }

        if ($password === $userObj->password) {
            $_SESSION['usuario'] = $userObj->usuario;
            $_SESSION['id_usuario'] = $userObj->id;
            header("Location: index.php");
            exit;
        } else {
            header("Location: index.php?orden=Login&error=1");
            exit;
        }
    }
}

function ctlLogout()
{
    session_start();
    session_destroy();
    header("Location: index.php");
    exit;
}
