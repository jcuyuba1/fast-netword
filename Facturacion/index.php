<?php	
$alert = '';
 session_start();
if(!empty($_SESSION['active'])) 
 
{
   header('location: sistema/');
}else{
if(!empty($_POST))

{
if(empty($_POST['usuario']) || empty($_POST['clave']))

{
	$alert = 'ingrese a su usuario y contraseña'; 
}else{
	require_once "conexion.php";
	$user =mysqli_real_escape_string($conection,$_POST['usuario']);
	$pass = mysqli_real_escape_string($conection,$_POST['clave']);
	$query = mysqli_query($conection, "SELECT * FROM usuario WHERE usuario= '$user' AND clave = '$pass'");
	mysqli_close($conection);
	$result = mysqli_num_rows($query);

	if($result >0)
{ 
	$data =mysqli_fetch_array($query);

 $_SESSION['active'] = true;
 $_SESSION['idUser'] = $data['idusuario'];
 $_SESSION['nombre'] = $data['nombre'];
  $_SESSION['user'] = $data['usuario'];
   $_SESSION['rol'] = $data['rol'];
   header('location: sistema/');
}else{
	$alert = 'El usuario o contraseña son incorrectas'; 
	session_destroy();
	
}
}
}
}
?>

<!DOCTYPE html>
 <html lang="en">
<head> 
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1,">
<title> Logim | sistema Merced Molina</title>
<link rel="stylesheet" type="text/css" href="css/styless.css">
</head>
<body>
	<section id="container">
		<form action="" method="post">
			<h3>Login</h3>
			<img src="img/php3.png" alt="login"> 
			<input type="text" name="usuario" placeholder="Usuario">
			<input type="password" name="clave" placeholder="Contraseña">
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			<input type="submit" value="INGRESAR">



		</form>
	</section>	

</body>
 </html>