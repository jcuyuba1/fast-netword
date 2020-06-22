<?php 
	session_start();


	include "../conexion.php";	

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Registro de ventas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<?php 

			$busqueda = strtolower($_REQUEST['busqueda']);
			if(empty($busqueda))
			{
				header("location: lista_cliente.php");
				mysqli_close($conection);
			}


		 ?>
		
		<h1><i class="far fa-list-alt"></i> Registro de ventas</h1>
		<a href="registro_cliente.php" class="btn_new"><i class="fas fa-cart-arrow-down"></i> Venta nueva</a>
		
		<form action="buscar_cliente.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>NIF,NIE,CIF</th>
				<th>Fecha de Nacimiento</th>
				<th>Telefono de Contacto</th>
				<th>Direccion de Instalacion</th>
				<th>Ciudad</th>
				<th>Provincia</th>
				<th>Codigo postal</th>
				<th>Productos contratados</th>
				<th>Numeros a portar</th>
				<th>Operador Donante</th>
				<th>Cambio de titular</th>
				<th>Descuento</th>
				<th>Correo Electronico</th>
				<th>Cuenta Bancaria</th>
				<th>Nombre del Banco</th>
				<th>Fecha de registro</th>
				<th>id del usuario</th>


			</tr>
		<?php 
			//Paginador
			
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM cliente 
																WHERE ( idcliente LIKE '%$busqueda%' OR 
																		nombre LIKE '%$busqueda%' OR 
																		dni LIKE '%$busqueda%' OR 
																		nacimiento LIKE '%$busqueda%' OR 
																		telefono LIKE '%$busqueda%' OR 
																		direccion LIKE '%$busqueda%' OR 
																		ciudad LIKE '%$busqueda%' OR 
																		provincia LIKE '%$busqueda%' OR 
																		postal LIKE '%$busqueda%' OR 
																		contrata LIKE '%$busqueda%' OR 
																	portabilidades LIKE '%$busqueda%' OR 
																		operador LIKE '%$busqueda%' OR 
																		titular LIKE '%$busqueda%' OR 
																		descuento LIKE '%$busqueda%' OR 
																		correo LIKE '%$busqueda%' OR 
																		cuenta LIKE '%$busqueda%' OR 
																		banco LIKE '%$busqueda%' OR 
																		dateadd LIKE '%$busqueda%' OR 
																    usuario_id  LIKE '%$busqueda%' 
																		 ) 
																AND estatus = 1  ");

			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 5;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT * FROM cliente WHERE 
															( idcliente LIKE '%$busqueda%' OR 
																		nombre LIKE '%$busqueda%' OR 
																		dni LIKE '%$busqueda%' OR 
																		nacimiento LIKE '%$busqueda%' OR 
																		telefono LIKE '%$busqueda%' OR 
																		direccion LIKE '%$busqueda%' OR 
																		ciudad LIKE '%$busqueda%' OR 
																		provincia LIKE '%$busqueda%' OR 
																		postal LIKE '%$busqueda%' OR 
																		contrata LIKE '%$busqueda%' OR 
																	portabilidades LIKE '%$busqueda%' OR 
																		operador LIKE '%$busqueda%' OR 
																		titular LIKE '%$busqueda%' OR 
																		descuento LIKE '%$busqueda%' OR 
																		correo LIKE '%$busqueda%' OR 
																		cuenta LIKE '%$busqueda%' OR 
																		banco LIKE '%$busqueda%' OR 
																		dateadd LIKE '%$busqueda%' OR 
																    usuario_id  LIKE '%$busqueda%')
															AND
															estatus = 1 ORDER BY idcliente ASC LIMIT  $desde,$por_pagina 
																			");
			mysqli_close($conection);
			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["idcliente"]; ?></td>
					<td><?php echo $data["nombre"]; ?></td>
					<td><?php echo $data["dni"]; ?></td>
					<td><?php echo $data["nacimiento"]; ?></td>
					<td><?php echo $data["telefono"]; ?></td>
					<td><?php echo $data['direccion'] ?></td>
					<td><?php echo $data["ciudad"]; ?></td>
					<td><?php echo $data["provincia"]; ?></td>
					<td><?php echo $data["postal"]; ?></td>
					<td><?php echo $data["contrata"]; ?></td>
					<td><?php echo $data["portabilidades"]; ?></td>
					<td><?php echo $data["operador"]; ?></td>
					<td><?php echo $data["titular"]; ?></td>
					<td><?php echo $data["descuento"]; ?></td>
					<td><?php echo $data["correo"]; ?></td>
					<td><?php echo $data["cuenta"]; ?></td>
					<td><?php echo $data["banco"]; ?></td>
					<td><?php echo $data["dateadd"]; ?></td>
					<td><?php echo $data["usuario_id"]; ?></td>
				


					<td>
						
						
					</td>
				</tr>
			
		<?php 
				}

			}
		 ?>


		</table>
<?php 
	
	if($total_registro != 0)
	{
 ?>
		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1)
				{
			 ?>
				<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
			<?php 
				}
				for ($i=1; $i <= $total_paginas; $i++) { 
					# code...
					if($i == $pagina)
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
					}
				}

				if($pagina != $total_paginas)
				{
			 ?>
				<li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?> ">>|</a></li>
			<?php } ?>
			</ul>
		</div>
<?php } ?>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>