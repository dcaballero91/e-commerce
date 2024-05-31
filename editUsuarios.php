<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
	
}
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Usuarios</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
	<style>
		.content {
			margin-top: 80px;
		}
	</style>
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include("nav.php");?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Complete los campos</h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code

			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
		
			
			$sql = mysqli_query($con, "SELECT * FROM usuarios WHERE usuarioId=$nik");
			if(mysqli_num_rows($sql) == 0){
				header("Location: listUsuarios.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){
				$usuarioId		     = mysqli_real_escape_string($con,(strip_tags($_POST["usuarioId"],ENT_QUOTES)));//Escanpando caracteres 
				$id_rol		     = mysqli_real_escape_string($con,(strip_tags($_POST["id_rol"],ENT_QUOTES)));//Escanpando caracteres 
				$username		     = mysqli_real_escape_string($con,(strip_tags($_POST["username"],ENT_QUOTES)));//Escanpando caracteres 
				$passw		     = mysqli_real_escape_string($con,(strip_tags($_POST["passw"],ENT_QUOTES)));//Escanpando caracteres
				$update = mysqli_query($con, "UPDATE usuarios SET id_rol='$id_rol', username='$username',passw='$passw' WHERE usuarioId='$usuarioId'") or die(mysqli_error());
				if($update){
					
					echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}
			?>
			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label">Id Usuario</label>
					<div class="col-sm-2">
						<input type="text" name="usuarioId" value="<?php echo $row ['usuarioId']; ?>" readonly class="form-control" placeholder="1" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Id Rol</label>
					<div class="col-sm-2">
						<input type="text" name="id_rol" value="<?php echo $row ['id_rol']; ?>" class="form-control" placeholder="1" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Usuario</label>
					<div class="col-sm-2">
						<input type="text" name="username" value="<?php echo $row ['username']; ?>" class="form-control" placeholder="focampos" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Contraseña</label>
					<div class="col-sm-2">
						<input type="password" name="passw" class="form-control" placeholder="dsport123" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="listUsuarios.php" class="btn btn-sm btn-danger">Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
	$('.date').datepicker({
		format: 'dd-mm-yyyy',
	})
	</script>
</body>
</html>