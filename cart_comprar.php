<!DOCTYPE html>
<html>
<?php 
function safeSession() {
    if (isset($_COOKIE[session_name()]) AND preg_match('/^[-,a-zA-Z0-9]{1,128}$/', $_COOKIE[session_name()])) {
        session_start();
    } elseif (isset($_COOKIE[session_name()])) {
        unset($_COOKIE[session_name()]);
        session_start(); 
    } else {
        session_start(); 
    }
}
safeSession();

// Check if Logged in
if ( isset($_SESSION['loggedin']) )
	{
		if ($_SESSION['loggedin'] == true){}
		else {echo '<script>window.location.replace("login.php")</script>';die();}
	}
else {echo '<script>window.location.replace("login.php")</script>';die();}

require('dbcore.php');
require('injection/injections.php'); //Anti Hacking Module
require 'head.php';
?>

<?php
if (!isset($_SESSION["total"])) {echo '<script>window.location.replace("cart.php")</script>';die();}
if (isset($_SESSION["total"]) && $_SESSION["total"] < 100)
	{
		echo '<script>window.location.replace("cart.php")</script>';die();
	}

function FormatErrors( $error )
{
   /* Display error. */
   echo "Error information: <br/>";

   echo "SQLSTATE: ".$error[0]."<br/>";
   echo "Code: ".$error[1]."<br/>";
   echo "Message: ".$error[2]."<br/>";
}

// Check if carrito is enabled
if ($_SESSION['enable_carrito'] == false) {echo '<script>window.location.replace("cart.php")</script>';die();}
?>
<main class="page product-page">
    <section class="clean-block clean-product dark">
        <div class="container">
		    <div class="block-heading">
				<h2>Compra</h2>
			</div>
			<div class="block-content">

				<?php
				if ( isset($_SESSION["cart"]) ) 
					{
						$compra_seguir = true;
						
						$_SESSION["orden_id"] = "";
						$_SESSION["orden_Numero"] = "";
						$_SESSION["orden_Error"] = "";
						$_SESSION["orden_ErrorM"] = "";
						/*
						echo "Cliente ID: " . $_SESSION["login_id"] . "<BR>";
						echo "Nombre: " . $_SESSION["login_nombre"] . "<BR>";
						echo "Email: " . $_SESSION["login_email"] . "<BR>";
						*/

						// CHEQUEAR DISPONIBILIDAD DE STOCK
						if ($compra_seguir == true)
							{
								$stock_disp = true;
								foreach ( $_SESSION["cart"] as $i ) 
									{
										// Chequear que lo que se pide concuerde con lo que hay en stock.
										if ($_SESSION["qty"][$i] > $_SESSION["item_stock"][$i])
											{
												$compra_seguir = false;
												$stock_disp = false;
												echo "Ajuste el producto: " . '"' . substr($_SESSION["cart_products"][$i],0,20) . '..."' . " con lo que hay en stock.<br>";
											}
									}
								if ($stock_disp == false)
									{
										echo '<p><a class="btn btn-primary" href="cart.php" role="button">Regresar al carrito</a></p>';
										$compra_seguir = false;
									}
							}
						
						require('dbcore.php'); //LOAD DATABASE MODULE
						
						if ($compra_seguir == true)
							{
								// GENERAR ORDEN
								$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
								$clean_ruc = $_SESSION["login_id"]; // RUC o CEDULA DEL CLIENTE *DEBUG
								$statement = $pdo->prepare("ven_ordenes_validate_create @ClienteIdentifier=:cedula, @nota=''");
								$statement->bindParam(':cedula',$clean_ruc,PDO::PARAM_STR);
								$statement->execute();
								
								while($row = $statement->fetch(PDO::FETCH_ASSOC))
									{
										//var_dump($row); // DEBUG
										$_SESSION["orden_id"] = $row["IDOrden"];
										$_SESSION["orden_Numero"] = $row["NumeroDeOrden"];
										$_SESSION["orden_Error"] = $row["ErrorLine"];
										$_SESSION["orden_ErrorM"] = $row["ErrorMessage"];										
									}
							}	
							
						// CHEQUEAR ERROR AL GENERAR ORDEN
						if (isset($_SESSION["orden_id"]) && $_SESSION["orden_id"] == "-1") 
							{
								echo "Error: " . $_SESSION["orden_Error"] . ",&nbsp;" . $_SESSION["orden_ErrorM"] . '<br>';
								$compra_seguir = false;
								echo '<p><a class="btn btn-primary" href="cart.php" role="button">Regresar al carrito</a></p>';								
							}
						else 
							{
								echo "<p class='text-success'>Su orden ha sido generada, su número de orden es: ". $_SESSION["orden_Numero"] . "<br>";
								echo "Por favor tome nota de su número de orden.</p>";
								
								// Ingresar ORDEN al Registro de Ordenes para el Frontend del Administrador
								$estado = "Pendiente";
								$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
								$statement = $pdo->prepare("INSERT INTO web_regCarrito (Nombre, RUC, ORDEN, Fecha_Create, Estado) VALUES (:Nombre, :Ruc, :Orden, GETDATE(), :Estado)");
								$statement->bindParam(':Nombre',$_SESSION["login_nombre"],PDO::PARAM_STR);
								$statement->bindParam(':Ruc',$_SESSION["login_id"],PDO::PARAM_STR);
								$statement->bindParam(':Orden',$_SESSION["orden_Numero"],PDO::PARAM_STR);
								$statement->bindParam(':Estado',$estado,PDO::PARAM_STR);
								$statement->execute();
									// FormatErrors ($pdo->errorInfo());
							}
						
						// CONTINUAR INGRESANDO LOS PRODUCTOS A LA ORDEN
						if ($compra_seguir == true)
						{
							?>
							 <div class="table-responsive">
								<table class="table table-bordered">
									<thead class="thead-light">
										<tr>
										<th class="align-middle text-center">Código</th>
										<th class="align-middle text-center">Producto</th>
										<th class="align-middle text-center">Observación</th>								
										</tr>
									</thead>
							<?php
							$pdo2 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
							$compra_orden = $_SESSION["orden_id"];
							$cart_product_errors = false;
							foreach ( $_SESSION["cart"] as $i ) 
								{
									$comp_producto = $_SESSION["item_code"][$i];
									$comp_cantidad = $_SESSION["qty"][$i];
									$statement = $pdo->prepare("Ven_OrdenesDT_validate_insert @producto=:codproducto, @orden=:ordenid, @cantidad=:cantidad, @ClienteIdentifier=:cedula");
									$statement->bindParam(':codproducto',$comp_producto,PDO::PARAM_STR);
									$statement->bindParam(':ordenid',$compra_orden,PDO::PARAM_STR);
									$statement->bindParam(':cantidad',$comp_cantidad,PDO::PARAM_STR);
									$statement->bindParam(':cedula',$clean_ruc,PDO::PARAM_STR);
									$statement->execute();

									while($row = $statement->fetch(PDO::FETCH_ASSOC))
										{
											$_SESSION["cart_p_number"] = $row["detalleNumber"];
											$_SESSION["cart_p_errorline"] = $row["ErrorLine"];
											$_SESSION["cart_p_errormessage"] = $row["ErrorMessage"];
											if ($row["detalleNumber"] == "-1") // Si el producto devuelve error
												{
													//var_dump($row); // DEBUG
													?>
													<tr>
													<td class="align-middle text-center"><?php echo $comp_producto; ?></td>
													<td class="align-middle text-center"><?php echo substr($_SESSION["cart_products"][$i],0,30); ?></td>
													<td class="align-middle text-center text-danger"><?php echo $row["ErrorMessage"]; ?></td>
													</tr>												
													<?php
													//echo "<p class='text-danger'>Cod: " . $comp_producto . " Producto: " . '"' . substr($_SESSION["cart_products"][$i],0,30) . '..." ' . $row["ErrorMessage"] . "</p>";
													$cart_product_errors = true;
												}
											else // si el producto se ingresa bien
												{
													?>
													<tr>
													<td class="align-middle text-center"><?php echo $comp_producto; ?></td>
													<td class="align-middle text-center"><?php echo substr($_SESSION["cart_products"][$i],0,30); ?></td>
													<td class="align-middle text-center">OK</td>
													</tr>
													<?php
													//echo "<p> Producto: " . '"' . substr($_SESSION["cart_products"][$i],0,30) . '..." ' . "OK - Ingresado";
												}
										}
								}
								?>
								</table>
								</div>
								<?php
							if ($cart_product_errors == true) // si hay error en algun producto se notifica generalmente
								{
									echo "<p class='text-primary'>Ciertos productos han tenido observaciones, por favor con el número de orden puede completar su pedido con su vendedor asignado.</p>";
								}
							// Quitar todo del carrito:
							unset($_SESSION["qty"]); //The quantity for each product
							unset($_SESSION["amounts"]); //The amount from each product
							unset($_SESSION["total"]); //The total cost
							unset($_SESSION["cart"]); //Which item has been chosen
							unset($_SESSION["item_stock"]); // item in storage
							unset($_SESSION["item_reservas"]); //item that are already separated for other customer
							unset($_SESSION["item_code"]); // item code
							unset($_SESSION["item_id"]); //item id
							
							unset($_SESSION["cart_products"]);
							unset($_SESSION["cart_product_id"]);
							unset($_SESSION["cart_product_code"]);
							unset($_SESSION["cart_product_price"]);
							unset($_SESSION["cart_product_stock"]);
							unset($_SESSION["cart_product_reservas"]);
							// Fin de quitar todo del carrito.
						}
					}
				else {echo '<script>window.location.replace("cart.php")</script>';die();}// Si no existe sesion de carrito entonces muere el script
				?>

			</div>
		
		</div>
	</section>
</main>

<?php require 'footer.php';?>