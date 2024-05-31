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
			$username = $password = $confirm_password = "";
			$username_err = $password_err = $confirm_password_err = "";
			if(isset($_POST['add'])){
				$id_rol		     = mysqli_real_escape_string($con,(strip_tags($_POST["id_rol"],ENT_QUOTES)));//Escanpando caracteres 
				$id_pers		     = mysqli_real_escape_string($con,(strip_tags($_POST["id_pers"],ENT_QUOTES)));//Escanpando caracteres 
				$user_name		     = mysqli_real_escape_string($con,(strip_tags($_POST["user_name"],ENT_QUOTES)));//Escanpando caracteres 
				$user_pass		     = mysqli_real_escape_string($con,(strip_tags($_POST["user_pass"],ENT_QUOTES)));//Escanpando caracteres 
			    if(empty(trim($_POST["user_name"]))){
			        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Por favor ingrese nombre de usuario.</div>';
			    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["user_name"]))){
			        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>El nombre de usuario solo puede contener letras, números y guiones bajos.</div>';
			    } else{
			    	// Validate password
						    if(empty(trim($_POST["user_pass"]))){ 
						    	$password_err = "Por favor ingrese una contraseña."; 
						        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Por favor ingrese una contraseña.</div>';    
						    } elseif(strlen(trim($_POST["user_pass"])) < 6){
						    	$password_err = "La contraseña debe tener al menos 6 caracteres.";
						        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>La contraseña debe tener al menos 6 caracteres.</div>'; 
						    } else{
						        $password = trim($_POST["user_pass"]);
						    }
						    
						    // Validate confirm password
						    if(empty(trim($_POST["confirm_password"]))){
						    	$confirm_password_err = "Por favor confirma su contraseña."; 
						        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Por favor confirma su contraseña.</div>';     
						    } else{
						        $confirm_password = trim($_POST["confirm_password"]);
						        if(empty($password_err) && ($password != $confirm_password)){
						        	$confirm_password_err = "Las contraseñas no coinciden.";
						            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Las contraseñas no coinciden.</div>'; 
						        }
						    }
							$cek = mysqli_query($con, "SELECT * FROM usuarios WHERE username='$user_name'");

						if((mysqli_num_rows($cek) == 0)&& empty($password_err) && empty($confirm_password_err)){
						$param_username = $user_name;
            			$param_password = password_hash($user_pass, PASSWORD_DEFAULT); // Creates a password hash
						$insert = mysqli_query($con, "INSERT INTO usuarios(personaId,id_rol,username,passw)
															VALUES('$id_pers','$id_rol','$user_name','$user_pass')") or die(mysqli_error());
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Datos cargados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>No se pudo guardar los datos !</div>';
						}
					 
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Usuario ya exite!</div>';
				}
			}}
			?>

			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label">Rol</label>
					<div class="col-sm-2">
						<input type="text" name="id_rol" class="form-control" placeholder="1" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Persona</label>
					<div class="col-sm-2">
						<input type="text" name="id_pers" class="form-control" placeholder="1" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Usuario</label>
					<div class="col-sm-2">
						<input type="text" name="user_name" class="form-control" placeholder="derlisca" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Contraseña</label>
					<div class="col-sm-2">
						<input type="password" name="user_pass" class="form-control" placeholder="unida123" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Confirma Contraseña</label>
					<div class="col-sm-2">
						<input type="password" name="confirm_password" class="form-control" placeholder="unida123" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
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
