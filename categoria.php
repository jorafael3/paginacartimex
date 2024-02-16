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
function FormatErrors($error)
{
	/* Display error. */
	echo "Error information: <br/>";

	echo "SQLSTATE: " . $error[0] . "<br/>";
	echo "Code: " . $error[1] . "<br/>";
	echo "Message: " . $error[2] . "<br/>";
}
?>
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

// GET User Input as variables
$search = "";

if (isset($_GET["group"])) {
	$userInput = $_GET["group"]; // Get user input via form
} else {
	$userInput = "0000000127";
}

$search = sanitize($userInput); // Filter the user input

// If user input is less than 2 chars... DIE
if (strlen($search) < 2) {
	$search = "0000000127";
}

// If user input is more than 80 chars... DIE
if (strlen($search) > 80) {
	$search = "0000000127";
}

// SEARCH STATISTICS BEGIN
if (isset($_SESSION['save_search'])) {
	if ($_SESSION['save_search'] == true) {
		$cedula_s = "";
		$tipo_s = "Categoria";
		if (isset($_SESSION['login_id']) && $_SESSION['login_id'] != "") {
			$stat_categoria = array(
				"0000000075" => "Computadoras - Escritorio y All In One",
				"0000000068" => "Computadoras - Laptops",
				"0000000109" => "Computadoras - Computadoras Gamer",
				"0000000081" => "Computadoras - Monitores",
				"0000000029" => "Computadoras - Software y Antivirus",

				"0000000097" => "Accesorios - Teclado y Mouse",
				"0000000013" => "Accesorios - Mochilas, Fundas y Protectores",
				"0000000127" => "Accesorios - Cables y Adaptadores",
				"0000000072" => "Accesorios - Parlantes de PC",
				"0000000021" => "Accesorios Gamer",

				"0000000023" => "Componentes - Discos Duros",
				"0000000006" => "Componentes - Cases",
				"0000000011" => "Componentes - Procesadores",
				"0000000039" => "Componentes - Coolers",
				"0000000062" => "Componentes - Tarjetas de Video",
				"0000000099" => "Componentes - Opticos (CD, DVD)",
				"0000000030" => "Componentes - Mainboard",
				"0000000106" => "Componentes - Memorias",
				"0000000125" => "Tarjetas de Red",

				"0000000003" => "Almacenamiento - Disco Externo",
				"0000000005" => "Almacenamiento - Pendrive",
				"0000000009" => "Almacenamiento - Tarjetas de Memoria",

				"0000000056" => "Impresoras y Escaners - Impresora Inyección",
				"0000000010" => "Impresoras y Escaners - Impresora Láser",
				"0000000069" => "Impresoras y Escaners - Escaners",
				"0000000122" => "Impresoras y Escaners - Punto de Venta",
				"0000000128" => "Impresoras y Escaners - Suministros",

				"0000000084" => "Audio - Audífonos",
				"0000000031" => "Audio - Audífonos Inalámbricos",
				"0000000073" => "Audio - Parlantes",
				"0000000071" => "Audio - Barras de Sonido",
				"0000000126" => "Audio - Radios",
				"0000000085" => "Audio - Cables, Adaptadores y Accesorios",

				"0000000004" => "Videojuegos - Consolas",
				"0000000077" => "Videojuegos - Juegos",
				"0000000078" => "Videojuegos - Accesorios",

				"0000000088" => "Hogar - Cocina",
				"0000000058" => "Hogar - Clima",
				"0000000033" => "Hogar - Muebles",
				"0000000087" => "Hogar - Limpieza",
				"0000000103" => "Hogar - Smart Home",

				"0000000094" => "Celulares y Tablets - Celulares",
				"0000000141" => "Celulares y Tablets - Tablets",
				"0000000142" => "Celulares y Tablets - Accesorios",

				"0000000067" => "TV y Video - Televisores",
				"0000000086" => "TV y Video - Proyectores",
				"0000000121" => "TV y Video - Cámaras",
				"0000000143" => "TV y Video - Accesorios",

				"0000000046" => "Protección de Voltaje - UPS",
				"0000000102" => "Protección de Voltaje - Reguladores",
				"0000000111" => "Protección de Voltaje - Supresores",
				"0000000120" => "Protección de Voltaje - Accesorios",

				"0000000050" => "Seguridad - Kits de Seguridad",
				"0000000096" => "Seguridad - Cámaras de Seguridad",
				"0000000112" => "Seguridad - Video Porteros",
				"0000000113" => "Seguridad - Lector Biométrico",
				"0000000114" => "Seguridad - Accesorios",

				"0000000042" => "Telefonía y Videoconferencia - Teléfonos IP",
				"0000000095" => "Telefonía y Videoconferencia - Teléfonos Análogos",
				"0000000098" => "Telefonía y Videoconferencia - Videoconferencia",
				"0000000123" => "Telefonía y Videoconferencia - Accesorios",

				"0000000091" => "Redes - Router",
				"0000000089" => "Redes - Access Point",
				"0000000108" => "Redes - Switch",
				"0000000101" => "Redes - Cables",
				"0000000028" => "Redes - Accesorios para Cableado",
				"0000000104" => "Redes - Adaptadores",
				"0000000107" => "Redes - Antenas y Radio Enlaces",

				"0000000051" => "Servidores - Tipo Torre",
				"0000000115" => "Servidores - Tipo Rack",
				"0000000116" => "Servidores - Almacenamiento NAS",
				"0000000117" => "Servidores - Componentes"
			);

			$cedula_s = $_SESSION['login_id'];
			$stat_search = "";

			if (array_key_exists($search, $stat_categoria)) {
				$stat_search = $stat_categoria[$search];
			} else {
				$stat_search = "$search";
			}

			// INSERT INTO web_search (DATE,SEARCH,CEDULA,tipo) VALUES (GETDATE(),:search,:cedula,:tipo)
			$pdo_statistics = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
			$statement_s = $pdo_statistics->prepare("INSERT INTO web_search (DATE,SEARCH,CEDULA,tipo) VALUES (GETDATE(),:search,:cedula,:tipo)");
			$statement_s->bindParam(':cedula', $cedula_s, PDO::PARAM_STR);
			$statement_s->bindParam(':tipo', $tipo_s, PDO::PARAM_STR);
			$statement_s->bindParam(':search', $stat_search, PDO::PARAM_STR);
			$statement_s->execute();
		}
	}
}
// SEARCH STATISTICS END

//Establishes the connection
$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

//Select Query
$statement = $pdo->prepare("WEB_Select_ProductoID @ProductoID='', @GrupoID=:gid, @Clase=:clase");
$statement->bindParam(':gid', $search, PDO::PARAM_STR);
$statement->bindParam(':clase', $class, PDO::PARAM_STR);

//Executes the query
$statement->execute(); // execute it

//$result = $statement->fetchAll(); // fetch the result (in Array)
//var_dump($result); // show the result "RAW"

//Error handling
//FormatErrors ($pdo->errorInfo());

$productCount = 0;
$ctr = 0;
?>

<main class="page catalog-page">
	<section class="clean-block clean-catalog dark">
		<div class="container">
			<div class="block-heading">
				<h2 class="text-info">Galería de Productos</h2>
				<p>Resultado</p>
				<br>
				<span><a href="<?php echo "categoria_filter.php?group=$search"; ?>"><i class="fa fa-th-list"></i>&nbsp;Visualizar en tabla con filtro</a></span>
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

									$P_ID = $row['ProductoID'];
									$Codigo = $row['Código'];
									$Nombre = $row['Producto'];
									$Precio = $row['Precio'];
									$Stock = $row['Stock'];
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
											echo "<h6 class=\"text-center text-danger\">No hay en Stock1</h6>";
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

									$productCount++;
								}
								$statement = NULL;
								?>
							</div>

							<?php
							/*
								<!-- PAGINATION IN CASE.
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
								*/
							?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php require 'footer.php';
?>