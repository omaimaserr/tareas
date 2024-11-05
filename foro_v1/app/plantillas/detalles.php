<?php
if (isset($_REQUEST['comentario'])){
    $contadorletras = contLetras($_REQUEST['comentario']);
    $contadorpalabras = contPalabras($_REQUEST['comentario']);
}
?>

<div>
    <b> Detalles:</b><br>
    <table>
        <tr>
            <td>Longitud: </td>
            <td><?= isset($_REQUEST['comentario']) ? strlen($_REQUEST['comentario']) : '0' ?></td>
        </tr>
        <tr>
            <td>Nº de palabras: </td>
            <td><?= isset($_REQUEST['comentario']) ? str_word_count($_REQUEST['comentario']) : '0' ?> </td>
        </tr>
        <tr>
            <td>Letra + repetida: </td>
            <td>' <?= isset($contadorletras['letra_repe']) ? $contadorletras['letra_repe'] : '' ?> ' </td>
            <td> <?= isset($contadorletras['repeticiones']) ? $contadorletras['repeticiones'] : '0' ?></td>
            <td> veces</td>
        </tr>
        <tr>
            <td>Palabra + repetida:</td>
            <td>' <?= isset($contadorpalabras['palabra_repe']) ? $contadorpalabras['palabra_repe'] : '' ?> '</td>
            <td><?= isset($contadorpalabras['repeticiones']) ? $contadorpalabras['repeticiones'] : '0' ?></td>
            <td> veces</td>
        </tr>
    </table>
</div>