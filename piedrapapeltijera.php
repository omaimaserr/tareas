<?php

    define('PIEDRA1', '&#x1F91C;');
    define('PIEDRA2', '&#x1F91B;');
    define('TIJERAS', '&#x1F596;');
    define('PAPEL', '&#x1F91A;');

    $opciones = rand(1, 3);
    if ($opciones == 1) {
        $jugador1 = PIEDRA1;
    } elseif ($opciones == 3) {
        $jugador1 = TIJERAS;
    } else {
        $jugador1 = PAPEL;
    }

    $opciones = rand(1, 4);
    if ($opciones == 1) {
        $jugador2 = PIEDRA2;
    } elseif ($opciones == 3) {
        $jugador2 = TIJERAS;
    } else {
        $jugador2 = PAPEL;
    }

    if ($jugador1 == $jugador2 || $jugador1 == PIEDRA1 && $jugador2 == PIEDRA2) {
        $resultado = 'Empate!';
    } elseif (($jugador1 == PIEDRA1 && $jugador2 == TIJERAS) ||
        ($jugador1 == PIEDRA2 && $jugador2 == TIJERAS) ||
        ($jugador1 == PAPEL && $jugador2 == PIEDRA1) ||
        ($jugador1 == PAPEL && $jugador2 == PIEDRA2) ||
        ($jugador1 == TIJERAS && $jugador2 == PAPEL)
    ) {
        $resultado = 'Ha ganado el jugador 1';
    } else {
        $resultado = 'Ha ganado el jugador 2';
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piedra, Papel o Tijera</title>
</head>

<body>
    <h1>¡Piedra, papel, tijera!</h1>
    <p>Actualice la página para mostrar otra partida.</p>

    <div class="jugadores">
        <div class="jugador">
            <h2>Jugador 1</h2>
            <p class="jugada"><?php echo $jugador1; ?></p>
        </div>
        <div class="jugador">
            <h2>Jugador 2</h2>
            <p class="jugada"><?php echo $jugador2; ?></p>
        </div>
    </div>

    <div class="resultado">
        <p><?php echo $resultado; ?></p>
    </div>

</body>

</html>
