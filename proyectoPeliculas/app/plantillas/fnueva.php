
<div id='aviso'><b><?= (isset($msg)) ? $msg : "" ?></b></div>

<form name='NUEVA' enctype="multipart/form-data" method="POST">
    <table>
        <tr>
            <td>Título del la película</td>
            <td> <input name="nombre" type="text" required> </td>
        </tr>
        <tr>
            <td>Director</td>
            <td> <input name="director" type="text" required> </td>
        </tr>
        <tr>
            <td>Genero</td>
            <td> <input name="genero" type="text" required></td>
        </tr>
        <tr>
            <td>Imagen (Opcional)</td>
            <td><input name="imagen" type="file"></td>
        </tr>
    </table>
    <button type="submit" name="orden" value="Nuevo">Añadir Película</button>
    <button type="button" size="10" onclick="javascript:window.location='index.php'">Volver</button>
</form>