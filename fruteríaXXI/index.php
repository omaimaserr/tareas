<?php

session_start();


if (isset($_GET['cliente'])){
    $_SESSION['cliente'] = $_GET['cliente'];
    $_SESSION['pedido'] = [] ; 
} 


if (!isset($_SESSION['cliente'])){
    include_once 'plantillas/bienvenida.php';
    exit();
}


$fruta = $_POST['fruta'];
$cantidad = $_POST['cantidad'];

if (isset($_POST['accion'])){
    if ( $_POST['accion'] == "Anotar"){
        $_SESSION['pedido'][$fruta] += $cantidad;
    }


    if ( $_POST['accion'] == "Terminar" ){
        $compraRealizada = pedidos();
        include_once 'plantillas/despedida.php';
        session_destroy();
        exit;
    }

}

$compraRealizada = pedidos();
include_once 'plantillas/compra.php';


function pedidos(){
    $mensaje = "";
    if (count ($_SESSION['pedido']) > 0 ){
        $mensaje = "Este es su pedido :";
        $mensaje .= "<table style='border: 1px dashed black'> ";

        foreach ($_SESSION['pedido'] as $fruta => $cantidad) {
            $mensaje .= "<tr><td>" . $fruta . "</td><td></td><td>" .$cantidad . "</td></tr>";
        }
        $mensaje .="</table>";
    }
    return $mensaje;
}

?>