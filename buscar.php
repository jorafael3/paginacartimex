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
<?php
// WEB_BUSQUEDA_PRODUCTO @NOMBRE, @CLASE
// Donde @CLASE = 01, 02, 03

require('dbcore.php'); //Call database connection module
require('injection/injections.php'); //Anti Hacking Module

$class = "03";
if (isset($_SESSION['login_clase'])) {
	$class = $_SESSION['login_clase'];
} else {
	$class = "03";
}

// GET User Input as variables
if (isset($_GET["product"])) {
	$userInput = $_GET["product"]; // Get user input via form
} else {
	$userInput = "Procesador";
}

$search1 = sanitize($userInput); // Filter the user input
$search = str_replace("%20", " ", $search1);		// Replaces "%20" for "blank spaces"

// If user input is less than 2 chars... DIE
if (strlen($search) < 2) {
	$search = "Procesador";
}

// If user input is more than 80 chars... DIE
if (strlen($search) > 80) {
	$search = "Procesador";
}

// SEARCH STATISTICS BEGIN
if (isset($_SESSION['save_search'])) {
	if ($_SESSION['save_search'] == true) {
		$cedula_s = "9999999999";
		$tipo_s = "Busqueda";
		if (isset($_SESSION['login_id']) && $_SESSION['login_id'] != "") {
			$cedula_s = $_SESSION['login_id'];
		}
		// INSERT INTO web_search (DATE,SEARCH,CEDULA,tipo) VALUES (GETDATE(),:search,:cedula,:tipo)
		$pdo_statistics = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
		$statement_s = $pdo_statistics->prepare("INSERT INTO web_search (DATE,SEARCH,CEDULA,tipo) VALUES (GETDATE(),:search,:cedula,:tipo)");
		$statement_s->bindParam(':cedula', $cedula_s, PDO::PARAM_STR);
		$statement_s->bindParam(':tipo', $tipo_s, PDO::PARAM_STR);
		$statement_s->bindParam(':search', $search, PDO::PARAM_STR);
		$statement_s->execute();
	}
}
// SEARCH STATISTICS END

//Establishes the connection
$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

//Select Query
$search_backend = str_replace(" ", "%", $search); // Replaces "blank spaces" for "%"
$statement = $pdo->prepare('WEB_BUSQUEDA_PRODUCTO @NOMBRE=:name, @CLASE=:class');
$statement->bindParam(':name', $search_backend, PDO::PARAM_STR); // $search
$statement->bindParam(':class', $class, PDO::PARAM_STR);

//Executes the query
$statement->execute(); // execute it

//$result = $statement->fetchAll(); // fetch the result (in Array)
// var_dump($result); // show the result "RAW"

//Error handling
// FormatErrors ($pdo->errorInfo());

$productCount = 0;
$ctr = 0;
?>

<?php
function fileExists($filePath)
{
	// NOT USED YET
	/*
To check if it is a file then you should use is_file together with file_exists to 
know if there is really a file behind the path, otherwise file_exists will return true for any existing path.
*/
	return is_file($filePath) && file_exists($filePath);
}
?>

<main class="page catalog-page">
	<section class="clean-block clean-catalog dark">
		<div class="container">
			<div class="block-heading">
				<h2 class="text-info">Resultado de la Búsqueda</h2>
				<p>Búsqueda: <?php echo $search; ?>
					<br>
					<span><a href="<?php echo "buscar_filter.php?product=$search"; ?>"><i class="fa fa-th-list"></i>&nbsp;Visualizar en tabla con filtro</a></span>
				</p>
			</div>
			<div class="content">
				<div class="row justify-content-center">
					<div class="col-md-9">
						<div class="products">
							<div class="row no-gutters">
								<?php
								while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
									//var_dump($row);
									if ($ctr > 200)
										break;
									$ctr++;

									$P_ID = $row['id'];
									$Codigo = $row['Código'];
									$Nombre = $row['Nombre'];
									$Precio = $row['PRECIO'];
									$Stock = $row['STOCK'];
									$Reservas = $row['Reservas'];
									$Precio_round = round($Precio, 2, PHP_ROUND_HALF_UP);
									$Stock_round = round($Stock, 0, PHP_ROUND_HALF_UP);

									// http://167.114.98.49/v2/upload/
									// http://img.cartimex.com/v2/upload/
									$product_RawURL = "https://img.cartimex.com/v2/upload/$Codigo" . " gr.jpg";
									$product_image = $product_RawURL; // Leave this here in case you want to check images from server side.

									/*										
										// print_r(get_headers($product_RawURL));
										if(@get_headers($product_RawURL)[0] == 'HTTP/1.0 404 Not Found') // HTTP/1.1 404 Not Found
										{$product_image = "assets/img/Sin-Imagen.jpg";}
										else{$product_image = $product_RawURL;}
										*/

									/*
										if(@getimagesize($url_encode))
											{$product_image = $url_encode;}
										else {$product_image = "assets/img/Sin-Imagen.jpg";}
										*/

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
									echo "
														<h3 class=\"text-center\">\$";
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

									/*
										echo "<td>$P_ID</td>";
										echo "<td>$Codigo</td>";
										echo "<td>$Nombre</td>";
										echo "<td>$Precio</td>";
										echo "<td>$Stock</td>";
										echo "<td>$Descripcion</td>";
										*/
									$productCount++;
								}
								$statement = NULL;
								?>
							</div>
							<?php
							// Buscar por CODIGO SI NO HAY PRODUCTOS
							if ($ctr == 0) {
								echo "<script>window.location.replace(\"buscar_codigo.php?product=$search\")</script>";
								die();
							}
							?>

							<!--
								
                                <nav>
                                    <ul class="pagination">
                                        <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                    </ul>
                                </nav>
								-->


						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php require 'footer.php';
?>