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
<?php
//header("Access-Control-Allow-Origin: *");
require 'head.php';
?>

<?php
// WEB_Select_ProductoID @ProductoID, @GrupoID, @Clase
// Donde @CLASE = 01, 02, 03
// Devuelve: ProductoID, Código, Producto, CategoriaID, Categoria, Precio, Stock, Descripción.

require('dbcore.php'); //Call database connection module
require('injection/injections.php'); //Anti Hacking Module

// GET User Input as variables

$class = "03";
if (isset($_SESSION['login_clase'])) {
	$class = $_SESSION['login_clase'];
} else {
	$class = "03";
}
$groupid = "127";

if (isset($_GET["productid"])) {
	$userInput = $_GET["productid"]; // Get user input via form
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

//Establishes the connection
$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

//Select Query
$statement = $pdo->prepare('WEB_Select_ProductoID @ProductoID=:pid, @GrupoID=:gid, @Clase=:clase');
$statement->bindParam(':pid', $search, PDO::PARAM_STR);
$statement->bindParam(':gid', $groupid, PDO::PARAM_STR);
$statement->bindParam(':clase', $class, PDO::PARAM_STR);

//Executes the query
$statement->execute(); // execute it

//$result = $statement->fetchAll(); // fetch the result (in Array)
// var_dump($result); // show the result "RAW"

//Error handling
// FormatErrors ($pdo->errorInfo());

$productCount = 0;
$ctr = 0;

// Initialize variables
$P_ID = "";
$Codigo = "";
$Nombre = "";
$Precio = "";
$Stock = "";
$Description = "";
$Precio_round = "";
$Stock_round = "";


// http://167.114.98.49/v2/upload/
// http://img.cartimex.com/v2/upload/
$product_RawURL = "https://img.cartimex.com/v2/upload/$Codigo" . " gr.jpg";
$product_image = $product_RawURL; // Leave this here in case you want to check images from server side.

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
	//var_dump($row);
	if ($ctr > 100)
		break;
	$ctr++;
	// campos: ProductoID, Código, Producto, CategoriaID, Categoria, Precio, Stock, Descripción.

	$P_ID = $row['ProductoID'];
	$Codigo = $row['Código'];
	$Nombre = $row['Producto'];
	$Precio = $row['Precio'];
	$Stock = $row['Stock'];
	$Reservas = $row['Reservas'];
	$Description = $row['Descripción'];
	$Precio_round = round($Precio, 2, PHP_ROUND_HALF_UP);
	$Stock_round = round($Stock, 0, PHP_ROUND_HALF_UP);

	// http://167.114.98.49/v2/upload/
	// http://img.cartimex.com/v2/upload/
	$product_RawURL = "https://img.cartimex.com/v2/upload/$Codigo" . " gr.jpg";
	// echo $product_RawURL;
	$product_image = $product_RawURL; // Leave this here in case you want to check images from server side.
}

// SEARCH STATISTICS BEGIN
if (isset($_SESSION['save_search'])) {
	if ($_SESSION['save_search'] == true) {
		if (isset($_SESSION['login_id']) && $_SESSION['login_id'] != "") {
			$tipo_s = "Producto";
			$cedula_s = $_SESSION['login_id'];
			// INSERT INTO web_search (DATE,SEARCH,CEDULA,tipo) VALUES (GETDATE(),:search,:cedula,:tipo)
			$pdo_statistics = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
			$statement_s = $pdo_statistics->prepare("INSERT INTO web_search (DATE,SEARCH,CEDULA,tipo) VALUES (GETDATE(),:search,:cedula,:tipo)");
			$statement_s->bindParam(':cedula', $cedula_s, PDO::PARAM_STR);
			$statement_s->bindParam(':tipo', $tipo_s, PDO::PARAM_STR);
			$statement_s->bindParam(':search', $Nombre, PDO::PARAM_STR);
			$statement_s->execute();
		}
	}
}
// SEARCH STATISTICS END
?>

<main class="page product-page">
	<section class="clean-block clean-product dark">
		<div class="container">
			<div class="block-heading">
				<h2 class="text-info">Información del Producto</h2>

			</div>
			<div class="block-content">
				<div class="product-info">
					<div class="row">
						<div class="col-md-6 d-xl-flex">
							<div class="d-xl-flex align-items-xl-center sp-wrap">
								<img class="img-fluid d-block mx-auto" src="<?php echo $product_image; ?>" onerror="this.onerror=null;this.src='assets/img/Sin-Imagen.jpg';">
							</div>
						</div>
						<div class="col-md-6">
							<div class="info">
								<h3><?php echo $Nombre; ?></h3>
								<div class="rating"></div>
								<div class="price">
									<h6 class=\"text-center\">SKU: <?php echo $Codigo; ?></h6>

									<?php
									if ($_SESSION['show_stock'] == true) {
										if ($Stock > 0) {
											if ($Stock > 0 && $Stock <= 5) {
												echo "<h6 class=\"text-success\">Las ultimas 5 Disponibles</h6>";
											} else if ($Stock > 5 && $Stock <= 10) {
												echo "<h6 class=\"text-success\">Las ultimas 10 Disponibles</h6>";
											} else if ($Stock > 10 && $Stock <= 15) {
												echo "<h6 class=\"text-success\">Las ultimas 15 Disponibles</h6>";
											} else if ($Stock > 15 && $Stock <= 20) {
												echo "<h6 class=\"text-success\">Las ultimas 20 Disponibles</h6>";
											} else if ($Stock > 20) {
												echo "<h6 class=\"text-success\">En Stock más de 20 Unidades</h6>";
											}
										} else {
											echo "<h6 class=\"text-danger\">No hay en Stock</h6>";
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
											if ($Stock > 0 and $Stock == $Reservas) {
												echo "<h6 class=\"text-danger\">Reservadas</h6>";
											} else {
												echo "<h6 class=\"text-success\">En Stock</h6>";
											}
										}
									}
									?>

									<h3>$
										<?php
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
										?>
									</h3>
								</div><a href="cart.php?productid=<?php echo $P_ID; ?>&action=add" class="btn btn-primary"><i class="icon-basket"></i>Agregar al Carrito</a>
								<div class="summary">
									<p>* Precio no tiene IVA</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="product-info">
					<div>
						<ul class="nav nav-tabs" id="myTab">
							<li class="nav-item"><a class="nav-link active" role="tab" data-toggle="tab" id="description-tab" href="#description">Descripción</a></li>
							<li class="nav-item"><a class="nav-link" role="tab" data-toggle="tab" id="ficha-tab" href="#ficha">Ficha</a></li>
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane active fade show description" role="tabpanel" id="description">
								<p><?php if ($Description == '') {
										echo "Sin Descripción";
									} else {
										echo $Description;
									} ?></p>
							</div>
							<div class="tab-pane fade show description" role="tabpanel" id="ficha">
								<p id="ficha_content">
									<?php
									$ficha_pdf = 'http://img.cartimex.com/v2/pdf/' . $Codigo . '.pdf';
									echo "<span><a href=\"$ficha_pdf\" target=\"_blank\"><i class=\"fa fa-file-pdf-o\"></i>&nbsp;PDF - Ver ficha técnica</a></span>";
									/*
										if(is_file($ficha_pdf)){echo "<span><a href=\"$ficha_pdf\"><i class=\"fa fa-file-pdf-o\"></i>&nbsp;Ver ficha técnica</a></span>";}
										else {echo "<span><i class=\"fa fa-file-pdf-o\"></i>&nbsp;Ficha técnica no disponible</span>";}
										*/
									?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
/*
<script>
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', "<?php echo $ficha_pdf;?>", true);
    xhr.send();

    if (xhr.status == "404") {
        console.log("File doesn't exist");
		document.getElementById("ficha_content").innerHTML = "No Existe";
    } else {
        console.log("File exists");
		document.getElementById("ficha_content").innerHTML = "Existe";
    }
</script>
*/
?>

<?php require 'footer.php'; ?>