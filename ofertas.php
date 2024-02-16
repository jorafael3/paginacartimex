<!DOCTYPE html>
<html>
<?php
// Starting Session
function safeSession()
{
	if (isset($_COOKIE[session_name()]) and preg_match('/^[-,a-zA-Z0-9]{1,128}$/', $_COOKIE[session_name()])) {
		session_start();
	} elseif (isset($_COOKIE[session_name()])) {
		unset($_COOKIE[session_name()]);
		session_start();
	} else {
		session_start();
	}
}
safeSession();
?>
<?php require 'head.php';
?>

<main class="page catalog-page">
	<section class="clean-block clean-catalog dark">
		<div class="container">
			<div class="block-heading">
				<h2 class="text-info">Galería de Productos</h2>
				<p>Productos Destacados</p>
			</div>
			<div class="content">
				<div class="row justify-content-center">
					<div class="col-md-9">
						<div class="products">
							<div class="row no-gutters">

								<?php
								// WEB_Select_ProductoID @ProductoID, @GrupoID, @Clase
								// Donde @CLASE = 01, 02, 03
								// Devuelve: ProductoID, Código, Producto, CategoriaID, Categoria, Precio, Stock, Descripción.

								require('dbcore.php'); //Call database connection module
								require('injection/injections.php'); //Anti Hacking Module

								$class = "03";
								if (isset($_SESSION['login_clase'])) {
									$class = $_SESSION['login_clase'];
								} else {
									$class = "03";
								}

								//Establishes the connection
								$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
								//Select Query
								$statement = $pdo->prepare("WEB_Select_ProductoID @ProductoID=:pid, @GrupoID='', @Clase=:clase");
								for ($i = 1; $i <= 43; $i++)  // INIT FOR
								{
									$statement->bindParam(':pid', $_SESSION["product$i"], PDO::PARAM_STR);
									$statement->bindParam(':clase', $class, PDO::PARAM_STR);
									//Executes the query
									$statement->execute(); // execute it	 
								?>
								<?php
									while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
										$P_ID = $row['ProductoID'];
										$Codigo = $row['Código'];
										$Nombre = $row['Producto'];
										$Precio = $row['Precio'];
										$Stock = $row['Stock'];
										$Precio_round = round($Precio, 2, PHP_ROUND_HALF_UP);
										$Stock_round = round($Stock, 0, PHP_ROUND_HALF_UP);
										$product_RawURL = "https://img.cartimex.com/v2/upload/$Codigo" . " gr.jpg";
										$product_image = $product_RawURL; // Leave this here in case you want to check images from server side.					
										echo "
										<div class=\"col-12 col-md-6 col-lg-4\">
											<div class=\"clean-product-item\">
												<div class=\"img-fluid d-block mx-auto\"><a href=\"producto.php?productid=$P_ID\"><img class=\"img-fluid d-block mx-auto\" src=\"$product_image\" onerror=\"this.onerror=null;this.src='assets/img/Sin-Imagen.jpg';\"></a></div>
												<div class=\"product-name\" style=\"max-height: 75px;min-height: 75px;overflow: hidden;\"><a href=\"producto.php?productid=$P_ID\">$Nombre</a></div>
												<div class=\"justify-content-center about\">
													<div class=\"justify-content-center text-center price\">
														<h6 class=\"text-center\">SKU: $Codigo</h6>";

										if ($_SESSION['show_stock'] == true) {
											if ($Stock > 0) {
												echo "<h6 class=\"text-center text-success\">En Stock: $Stock_round</h6>";
											} else {
												echo "<h6 class=\"text-center text-danger\">No hay en Stock</h6>";
											}
										} else {
											if ($_SESSION['loggedin'] == true) {
												if ($Stock > 0 and $Stock == $Reservas) {
													echo "<h6 class=\"text-danger\">Reservadas</h6>";
												} else {
													if ($Stock > 0 && $Stock <= 5) {
														echo "<h6 class=\"text-success\">Las últimas 5 Disponibles</h6>";
													} else if ($Stock > 5 && $Stock <= 10) {
														echo "<h6 class=\"text-success\">Las últimas 10 Disponibles</h6>";
													} else if ($Stock > 10 && $Stock <= 15) {
														echo "<h6 class=\"text-success\">Las últimas 15 Disponibles</h6>";
													} else if ($Stock > 15 && $Stock <= 20) {
														echo "<h6 class=\"text-success\">Las últimas 20 Disponibles</h6>";
													} else if ($Stock > 20) {
														echo "<h6 class=\"text-success\">En Stock más de 20 Unidades</h6>";
													}
												}
											} else {
												if ($Stock > 0) {
													echo "<h6 class=\"text-center text-success\">En Stock</h6>";
												} else {
													echo "<h6 class=\"text-center text-danger\">No hay en Stock</h6>";
												}
											}
										}
										echo "<h3 class=\"text-center\">\$";
										if (($_SESSION['show_price'] == true) || (isset($_SESSION['loggedin']))) {
											if ($_SESSION['loggedin'] == true) {
												echo $Precio_round;
											} elseif ($_SESSION['show_price'] == true) {
												echo $Precio_round;
											} else {
												echo '<a href="login.php">Ver Precio</a>';
											}
										} else {
											echo '<a href="login.php">Ver Precio</a>';
										}
										echo "</h3>
														<small class=\"text-center text-black-50\">Precio No Incluye IVA</small>
													</div>
												</div>
											</div>
										</div>
										";
									}
								} // END FOR
								$statement = NULL;
								?>
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php require 'footer.php';
?>