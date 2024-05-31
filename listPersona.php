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
	<title>Persona</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">

	<style>
		.content {
			margin-top: 80px;
		}
	</style>

</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include('nav.php');?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Personas</h2>
			<hr />
			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    <th>Identificador</th>
					<th>Cedula</th>
					<th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha Nac.</th>
					<th>Dirección</th>
					<th>Editar</th>
				</tr>
				<?php
				
				$sql = mysqli_query($con, "SELECT * FROM personas ORDER BY personaID ASC");
				
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							<td>'.$row['personaId'].'</td>
							<td>'.$row['ci'].'</td>
							<!--
                            <td><a href="profilePersona.php?nik='.$row['ci'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nombre'].'</a></td>
							-->
							<td>'.$row['nombre'].'</td>
                            <td>'.$row['apellido'].'</td>
							<td>'.$row['fechaN'].'</td>
                            <td>'.$row['dire'].'</td>
							<td>

								<a href="editPersona.php?nik='.$row['ci'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						$no++;
					}
				}
				?>
			</table>
			</div>
		</div>
	</div><center>
	<p>&copy; Sistemas Web <?php echo date("Y");?></p
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
