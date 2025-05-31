<form>
	<input type="text" name="valor">
	<button type="submit" name="orden" value="BuscarPorTitulo">Buscar por título</button>
	<button type="submit" name="orden" value="BuscarPorDirector">Buscar por director</button>
	<button type="submit" name="orden" value="BuscarPorGenero">Buscar por género</button>
</form>


<h2>Listado de Películas</h2>
<table>
	<tr>
		<th>Id</th>
		<th>Nombre</th>
		<th>Director</th>
		<th>Género</th>
		<th colspan=3></th>
	</tr>
	<?php foreach ($peliculas as $peli): ?>
		<tr>
			<td><?= $peli->codigo_pelicula ?></td>
			<td><?= $peli->nombre ?></td>
			<td><?= $peli->director ?></td>
			<td><?= $peli->genero ?></td>
			<td><a href="?orden=Modificar&id=<?= $peli->codigo_pelicula ?>">Modificar</a></td>
			<td><a href="?orden=Detalles&id=<?= $peli->codigo_pelicula ?>">Detalles</a></td>
			<td><a href="?orden=Borrar&id=<?= $peli->codigo_pelicula ?>" onclick="confirmarBorrar('<?= $peli->nombre ?>','<?= $peli->codigo_pelicula ?>');">Borrar</a></td>
		</tr>
	<?php endforeach; ?>
</table>


<!-- Descargar info de todas las pelis -->
<form method="get" action="index.php" style="margin-bottom: 20px;">
	<button type="submit" name="orden" value="DescargarJSON">Descargar JSON</button>
	<button type="submit" name="orden" value="DescargarCSV">Descargar CSV</button>
	<button type="submit" name="orden" value="DescargarPDF">Descargar PDF</button>
</form>
<br>


<!-- Añadir nueva película -->
<form enctype="multipart/form-data">	
	<button type="submit" name="orden" value="Nuevo"> Añadir Nueva Película </button>
</form>







<script>
	function confirmarBorrar(id, nombre) {
		if ( confirm('¿Está seguro de querer eliminar esta película?')) {
			// redirigir a la URL
			window.location.href = '?orden=Borrar&id=' + id;
		}
	}
</script>