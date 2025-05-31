<h1>Detalles de la Película</h1>
<div id="pelicula">
    <p><strong>Id : </strong><?= $peli->codigo_pelicula ?></p>
    <p><strong>Nombre : </strong><?= $peli->nombre ?></p>
    <p><strong>Director :</strong> <?= $peli->director ?></p>
    <p><strong>Género : </strong> <?= $peli->genero ?></p>
    <p><strong>Imagén : </strong> <br>
        <img src="<?= 'app/img/' . $peli->imagen; ?>" alt="Imagen no disponible">
    </p>

    <!-- trailer -->
    <?php
    // función auxiliar para trailer
    function getTrailerId($query)
    {
        $busqueda = urlencode($query . " trailer ");
        $html = file_get_contents("https://www.youtube.com/results?search_query=" . $busqueda);

        if (preg_match('/"idvideo":"([a-zA-Z0-9_-]{11})"/', $html, $matches)) {
            return $matches[1]; // El primer ID de vídeo
        }

        return null; // No encontrado
    }

    $query = urlencode($peli->nombre . ' trailer');
    $busqueda = "https://www.youtube.com/results?search_query=$query";
    ?>
    <p><strong>Tráiler:</strong></p>
    <p><a href="<?= $busqueda ?>" target="_blank">Ver tráiler de <?= $peli->nombre ?> en YouTube</a></p>



    <!-- Valoración -->
    <?php
    session_start();
    if (isset($_SESSION['error_voto'])) {
        echo "<p style='color:red; font-weight:bold;'>" . htmlspecialchars($_SESSION['error_voto']) . "</p>";
        unset($_SESSION['error_voto']);
    }
    ?>

    <form method="post" action="index.php?orden=Votar&id=<?= $peli->codigo_pelicula ?>">
        <label>Puntuación : </label>
        <select name="puntos" required>
            <option value="">Selecciona</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <button type="submit">Votar</button>
    </form>

    <p><strong>Valoración : </strong>
        <?php
        if ($peli->votos > 0) {
            echo round($peli->puntuacion_total / $peli->votos, 2) . " / 5 ({$peli->votos} votos)";
        } else {
            echo "Sin votos aún";
        }
        ?>
    </p>



</div>

<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'">