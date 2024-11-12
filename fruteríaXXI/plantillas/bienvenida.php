<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>LA FRUTERIA</title>
</head>
<body>
<H1> La Frutería del siglo XXI</H1>
<B>BIENVENIDO A NUESTRA FRUTERÍA</B><br>
<form action="<?=$_SERVER['PHP_SELF'];?>" method="get">
    Introduzca su nombre :<input name="cliente" type="text" required > <br>
    <input type="submit" value="Ingresar">
</form>
</body>
</html>
