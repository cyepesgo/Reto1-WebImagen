<?php
	require_once ('../accesoDB/webimagenDAO.php');
	session_start();
	if(sizeof($_POST) > 0)
		$_SESSION['idAlbum'] = $_POST['idAlbum'];
	$nombre = $_SESSION['nombre'];
	
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; 
	charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="../css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="../css/estilo.css" rel="stylesheet"/>
	<title>WebImagen</title>
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav">
    <div class="container">
        <a href="../index.php" class="navbar-brand">WebImagen</a>
        <button class="navbar-toggle" type="button" 
        data-toggle="collapse" data-target=".bs-navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="nav-collapse collapse bs-navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href='perfil.php'><?php echo $nombre?></a></li>
                <li><a href='albumes.php'>Mis albumes</a></li>
                <li><a href='cerrarSesion.php'>Cerrar Sesion</a></li>
            </ul>
        </div>
    </div>
    </div>
    <div class="container">
	<center>
	<?php
    $webImagen = WebImagenDAO::getInstancia();
    $idAlbum = $_SESSION['idAlbum'];
    $imagenes = $webImagen -> obtenerImgsAlbum($idAlbum);
    $datos = $webImagen -> obtenerDatosAlbum($idAlbum);
    $nombre = $datos['nombre'];
    $descripcion = $datos['descripcion'];
    echo "<legend><b>$nombre</b> $descripcion</legend>";
    for ($i = sizeof($imagenes) - 1; $i >= 0; $i--) {
        $ruta = $imagenes[$i]['ruta'];
        $login = $_SESSION['login'];
        $desc = $imagenes[$i]['descripcion'];
        echo "<form action='imagen.php' method='post'
		enctype='multipart/form-data'>
		<input type='image' src = '../$ruta' height='150'>
		<input type='hidden' name='ruta' value='$ruta'>
		<input type='hidden' name='login' value='$login'>
        <input type='hidden' name='desc' value='$desc'>
		</form>";
    }
	?>
	</center>
	<br>
	<form action="subirImg.php" method="post" 
	id="formImg" enctype="multipart/form-data" 
	onsubmit="return validarImg();">
	<fieldset>
		<legend>Subir nueva imagen</legend>
		<div class="form-group">
			<label>Imagen</label>
			<input type="file" name="imagen" id="imagen">
		</div>
		<div class="form-group">
			<label>Descripcion</label>
			<input type="text" name="desc" id="desc" class="form-control">
			<input type='hidden' name='idAlbum' id="idAlbum" 
			value='<?php echo $idAlbum?>'>
		</div>
		<input type="submit" name="submit" class="btn btn-default" 
		value="Cargar">
	</fieldset>
	</form>
	</div>
	<script src="../js/jquery.js" type="text/javascript"></script>
    <script src="../js/bootstrap.js" type="text/javascript"></script>
    <script src="../js/funcionalidad.js" type="text/javascript"></script>
</body>
</html>