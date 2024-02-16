<!DOCTYPE html>

<head>
	<style>
		.input-group-append {
			margin-center:
		}

		.container {
			color: black;
			font-family: Verdana;
			width: 100%
		}

		.form-control {
			color: black;
			font-family: Verdana;
			width: 10%;
			background-color: lightblue;
			height: 28px;
			font-size: 16px;
		}

		.btn-success {
			background-color: gray;
			border: 1px;
			color: white;
			text-align: center;
			display: inline-block;
			font-size: 16px;
			padding: 14px 35px;
			border-radius: 14px;
		}

		.containerdatos {
			align=center;
			font-family: Verdana;
			width=100%;
		}

		.tabladatos {
			table-layout: fixed;
			align=center;
			background-color: lightblue;
			border: 1px;
			color: black;
			text-align: center;
			font-size: 16px;
			padding: 14px 35px;
			border-radius: 8px;
		}

		#filacab {
			text-align: center;
			font-size: 12;
			border: 0px solid blue;
			word-wrap: break-word;
		}

		.containerdatos2 {
			align=center;
			font-family: Verdana;
			width=100%;
		}

		.tabladatos2 {
			table-layout: fixed;
			background-color: white;
			align=center;
			border: 3px;
			color: black;
			text-align: center;
			font-size: 16px;
			padding: 14px 35px;
			border-radius: 8px;
		}

		#filadet {
			text-align: center;
			font-size: 12;
			border: 2px solid grey;
			border-radius: 8px;
			word-wrap: break-word;
		}

		#filafooter {
			text-align: center;
			font-size: 12;
			border: 2px solid grey;
			border-radius: 8px;
			word-wrap: break-word;
		}
	</style>
	<style type="text/css">
		html,
		body,
		div,
		iframe {
			margin: 0;
			padding: 0;
			height: 100%;
		}

		iframe {
			display: block;
			width: 100%;
			border: none;
		}
	</style>
</head>
<script type="text/javascript">
	function setfocus() {
		document.getElementById("serie").focus();
	}
</script>
<?php
session_start();

$serie = $_POST['serie'];
require('conexionseries.php');


?>

<body onload="setfocus()">


	<html>
	<main class="Series">
		<div class="container">
			<br>
			<div id="logo">
				<div class="logo desktop" align="center"> <a href=""><img src="xtratech_com.png"></a>
					<div class="container">
						<div class="block-heading">
							<h2 class="text-info">Consultar Serie Producto</h2>

						</div>
					</div>
					<form action="series3.php" method="post">
						<div class="input-group">
							<input type="text" id="serie" name="serie" class="form-control" placeholder="Serie" setfocus>
							<div class="input-group-append">
								<br>
								<input class="btn-success" type="Submit" value="Consultar" id="ingresar"></center>
								</td>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<br>
		<?php
		///Tabla de datos del producto 
		if ($serie <> '') {

		?>
			<div align="center">
				<div class=\"table-responsive-xs\">
					<form width="75%">
						<div class="containerdatos">
							<table class="tabladatos" width="75%">
								<tr>
									<th id="filacab" width="50%"> PRODUCTO </th>
									<th id="filacab" width="50%"> CANAL </th>
								</tr>
							</table>
						</div>

						<div class="containerdatos2">
							<table class="tabladatos2" width=75%">
								<?php
								$pdo1 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
								$result1 = $pdo1->prepare('Inv_buscar_series_productos_xtratech  @serie=:serie');
								$result1->bindParam(':serie', $serie, PDO::PARAM_STR);
								$result1->execute();
								$count = $result1->rowcount();
								//echo "Contador". $count; 

								if ($count < 0) {
									while ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
										$PRODUCTO = $row['PRODUCTO'];
										$CANAL = $row['CANAL'];
								?>
										<tr>
											<td id="filadet" width="50%"> <?php echo $PRODUCTO ?> </td>
											<td id="filadet" width="50%"> <?php echo $CANAL ?> </td>
										</tr>
									<?php
									}
									?>
									<tr>
										<td colspan="2" id="filafooter" width="100%"> <strong>* Este dispositivo fue adquirido a través de un canal autorizado * </strong></td>
									</tr>
							</table>
						</div>
					</form>
				</div>
			</div>

	<?php

									$Serie = '';
								} else {
									echo "SERIE NO REGISTRADA";
								}
							}

	?>

	</main>