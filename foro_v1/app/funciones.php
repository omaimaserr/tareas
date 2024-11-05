<?php
// función para verificar el inicio de sesión
function usuarioOk($usuario, $contraseña){
  
   return strlen($usuario) >= 8 && $contraseña === strrev($usuario);
    
}

// función para contar las letras del comentario
function contLetras ($comentario){
   $comentario = strtolower($comentario); // tdo a minusculas para que sea todo igual
   $contletras = []; //para guardar las letras

   for ($i=0; $i < strlen($comentario); $i++) { 
      $letra = $comentario[$i];

      // 1º ver si es una letra 
      if (ctype_alpha(($letra))){
         if (isset($contletras[$letra])){
            $contletras[$letra]++;
         } else {
            $contletras[$letra] = 1;
        }

      }
   }

   $letra_mas_repe = '';
   $repeticiones = 0;

   foreach ($contletras as $letra => $num) {
      if ($num > $repeticiones) {
         $repeticiones = $num;
         $letra_mas_repe = $letra;
      }
   }

   return [
      'letra_repe' => strtoupper($letra_mas_repe), 
      'repeticiones' => $repeticiones
   ];
}

// función para contar las palabras
function contPalabras($comentario){
   $comentario = strtolower($comentario);
   $palabras = str_word_count($comentario, 1) ;// con el 1, str_word_count devuelve un array con las palabras del comentario

   $contpalabras = [];

   foreach ($palabras as $palabra) {
      if (isset($contpalabras[$palabra])){
         $contpalabras[$palabra]++;
      }else {
         $contpalabras[$palabra] = 1;
      }
   }

   $palabra_mas_repe = '';
   $repeticiones = 0;
   foreach ($contpalabras as $palabra => $num ){
      if ($num > $repeticiones){
         $repeticiones = $num;
         $palabra_mas_repe = $palabra;
      }
   }

   return [
      'palabra_repe' => $palabra_mas_repe,
      'repeticiones' => $repeticiones,
   ];

}