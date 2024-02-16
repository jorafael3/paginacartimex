<!DOCTYPE html>
<html>
<?php
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

// Check if Logged in
if (isset($_SESSION['loggedin'])) {
	if ($_SESSION['loggedin'] == true) {
	} else {
		echo '<script>window.location.replace("login.php")</script>';
		die();
	}
} else {
	echo '<script>window.location.replace("login.php")</script>';
	die();
}

require('dbcore.php');
require('injection/injections.php'); //Anti Hacking Module
require 'head.php';

//-------------------------------------------------------------------------------------------
// Variable Globales que vienen de la base de datos
if (!isset($_SESSION["cart_products"])) {
	$_SESSION["cart_products"] = array();
}
if (!isset($_SESSION["cart_product_id"])) {
	$_SESSION["cart_product_id"] = array();
}
if (!isset($_SESSION["cart_product_code"])) {
	$_SESSION["cart_product_code"] = array();
} // works for images and product code... but not ID.
if (!isset($_SESSION["cart_product_price"])) {
	$_SESSION["cart_product_price"] = array();
}
if (!isset($_SESSION["cart_product_stock"])) {
	$_SESSION["cart_product_stock"] = array();
}
if (!isset($_SESSION["cart_product_reservas"])) {
	$_SESSION["cart_product_reservas"] = array();
}

// Variables Globales propias del carrito de compras (comentadas para tenerlas de referencia)
// $_SESSION["qty"][$i] = 0; // Tener en cuenta
// $_SESSION["amounts"][$i] = 0; // Tener en cuenta
// $_SESSION["total"] = 0; // Tener en cuenta
// $_SESSION["cart"] = 0; // Tener en cuenta
//--------------------------------------------------------------------------------------------

// Usar el id del producto que viene del click en el boton de producto.php para obtener los datos del producto
if (isset($_GET["productid"]) && isset($_GET["action"]) == "add") {
	$input_productid = sanitize($_GET["productid"]); // Get user input via form	
	$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
	$statement = $pdo->prepare('WEB_Select_ProductoID @ProductoID=:pid, @GrupoID=127, @Clase=:clase');
	$statement->bindParam(':pid', $input_productid, PDO::PARAM_STR);
	$statement->bindParam(':clase', $_SESSION['login_clase'], PDO::PARAM_STR);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		// PARA QUE NO SALGAN DUPLICADOS
		if (in_array($row['ProductoID'], $_SESSION["cart_product_id"]) == false) {
			array_push($_SESSION["cart_product_id"], $row['ProductoID']);
			array_push($_SESSION["cart_product_code"], $row['Código']);
			array_push($_SESSION["cart_products"], $row['Producto']);
			// $Precio_round = round($_SESSION["cart_product_price"], 2, PHP_ROUND_HALF_UP);
			array_push($_SESSION["cart_product_price"], $row['Precio']);
			array_push($_SESSION["cart_product_stock"], $row['Stock']);
			array_push($_SESSION["cart_product_reservas"], $row['Reservas']);
		}
	}
}

//Define the products and price
$products = $_SESSION["cart_products"];
$amounts = $_SESSION["cart_product_price"];

$product_code = $_SESSION["cart_product_code"];
$product_stock = $_SESSION["cart_product_stock"];
$product_reservas = $_SESSION["cart_product_reservas"];
$product_id = $_SESSION["cart_product_id"];
$reserva_message = "";
$reserva_message2 = "";

//Load up session "CART VARIABLES"
if (!isset($_SESSION["total"])) {
	$_SESSION["total"] = 0;

	for ($i = 0; $i < count($products); $i++) {
		$_SESSION["qty"][$i] = 0;
		$_SESSION["amounts"][$i] = 0;
	}
}
if (!isset($_SESSION["item_stock"])) {
	$_SESSION["item_stock"] = array();
}
if (!isset($_SESSION["item_reservas"])) {
	$_SESSION["item_reservas"] = array();
}
if (!isset($_SESSION["item_code"])) {
	$_SESSION["item_code"] = array();
}
if (!isset($_SESSION["item_id"])) {
	$_SESSION["item_id"] = array();
}

//---------------------------
//Reset
if (isset($_GET['reset'])) {
	if ($_GET["reset"] == 'true') {
		unset($_SESSION["qty"]); //The quantity for each product
		unset($_SESSION["amounts"]); //The amount from each product (Price)
		unset($_SESSION["total"]); //The total cost
		unset($_SESSION["cart"]); //Which item has been chosen
		unset($_SESSION["item_stock"]); // item in storage
		unset($_SESSION["item_reservas"]); //item that are already separated for other customer
		unset($_SESSION["item_code"]); // item code
		unset($_SESSION["item_id"]); //item id
	}
}

// Full Reset
if (isset($_GET['fullreset'])) {
	if ($_GET["fullreset"] == 'true') {
		unset($_SESSION["qty"]); //The quantity for each product
		unset($_SESSION["amounts"]); //The amount from each product
		unset($_SESSION["total"]); //The total cost
		unset($_SESSION["cart"]); //Which item has been chosen
		unset($_SESSION["item_stock"]); // item in storage
		unset($_SESSION["item_reservas"]); //item that are already separated for other customer
		unset($_SESSION["item_code"]); // item code
		unset($_SESSION["item_id"]); //item id

		// Productos Preseleccionados
		unset($_SESSION["cart_products"]);
		unset($_SESSION["cart_product_id"]);
		unset($_SESSION["cart_product_code"]);
		unset($_SESSION["cart_product_price"]);
		unset($_SESSION["cart_product_stock"]);
		unset($_SESSION["cart_product_reservas"]);

		echo '<script>window.location.replace("cart.php")</script>';
	}
}

//---------------------------
// First Add
if (isset($_GET["action"]) == "add") {
	$i_name = end($products); // get latest added item name in array
	$i = array_search($i_name, $products); // returns current array number position for product resently added
	// echo "<script>console.log(\"$i\");</script>"; // Debug: Show in console index number position
	$_SESSION["qty"][$i] = 0;
	if (isset($products[$i])) // Check if the element exists (Prevents XSS)
	{
		$qty = $_SESSION["qty"][$i] + 1;
		$_SESSION["amounts"][$i] = $amounts[$i] * $qty;
		$_SESSION["cart"][$i] = $i;
		$_SESSION["qty"][$i] = $qty;
		$_SESSION["item_stock"][$i] = $product_stock[$i];
		$_SESSION["item_reservas"][$i] = $product_reservas[$i];
		$_SESSION["item_code"][$i] = $product_code[$i];
		$_SESSION["item_id"][$i] = $product_id[$i];
	}
}

//---------------------------
//Add 1 to selected item
if (isset($_GET["add"])) {
	$i = $_GET["add"];
	$i = filter_var($i, FILTER_SANITIZE_NUMBER_INT);
	if (isset($_SESSION["cart"][$i])) // Check if the index number exists (Prevents XSS)
	{
		$qty = $_SESSION["qty"][$i] + 1;
		$_SESSION["amounts"][$i] = $amounts[$i] * $qty;
		$_SESSION["cart"][$i] = $i;
		$_SESSION["qty"][$i] = $qty;
		$_SESSION["item_stock"][$i] = $product_stock[$i];
		$_SESSION["item_reservas"][$i] = $product_reservas[$i];
		$_SESSION["item_code"][$i] = $product_code[$i];
		$_SESSION["item_id"][$i] = $product_id[$i];
	}
}

//---------------------------
//Delete
if (isset($_GET["delete"])) {
	$i = $_GET["delete"];
	$i = filter_var($i, FILTER_SANITIZE_NUMBER_INT);
	if (isset($_SESSION["cart"][$i])) // Check if the index number exists (Prevents XSS)
	{
		$qty = $_SESSION["qty"][$i];
		$qty--;
		$_SESSION["qty"][$i] = $qty;
		//remove item if quantity is zero
		if ($qty < 1) {
			$_SESSION["amounts"][$i] = 0;
			$qty = 0;
			$_SESSION["qty"][$i] = 0;
			unset($_SESSION["cart"][$i]);
			unset($_SESSION["amounts"][$i]);
			unset($_SESSION["qty"][$i]);
			unset($_SESSION["item_stock"][$i]);
			unset($_SESSION["item_reservas"][$i]);
			unset($_SESSION["item_code"][$i]);
			unset($_SESSION["item_id"][$i]);
		} else {
			$_SESSION["amounts"][$i] = $amounts[$i] * $qty;
		}
	}
}
?>
<main class="page product-page">
	<section class="clean-block clean-product dark">
		<div class="container">
			<div class="block-heading">
				<h2>Carrito</h2>
				<!-- <h2><?php echo $_SESSION['login_id'] ?></h2> -->
				<!-- <h2><?php echo $_SESSION['login_clase'] ?></h2> -->
			</div>
			<div class="block-content">
				<?php
				if (isset($_SESSION["cart"])) {
				?>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead class="thead-light">
								<tr>
									<th class="align-middle text-center">Foto</th>
									<th class="align-middle text-center">Código</th>
									<th class="align-middle text-center">Producto</th>
									<th class="align-middle text-center">Precio/U</th>
									<th class="align-middle text-center">Cantidad</th>
									<th class="align-middle text-center">Valor</th>
									<th class="align-middle text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>
								</tr>
							</thead>
							<?php
							$total = 0;
							foreach ($_SESSION["cart"] as $i) {
								// Load Image
								$p_image = $_SESSION["cart_product_code"][$i];
								$product_image = "https://img.cartimex.com/v2/upload/$p_image" . " gr.jpg";
							?>
								<tr>
									<td class="align-middle text-center">
										<div class="mx-auto d-xl-flex align-items-xl-center sp-wrap"><img class="img-fluid d-block mx-auto" src="<?php echo $product_image; ?>" onerror="this.onerror=null;this.src='assets/img/Sin-Imagen.jpg';"></div>
									</td>
									<td class="align-middle"><?php echo $_SESSION["item_code"][$i]; ?></td>
									<td class="align-middle"><?php echo ($products[$_SESSION["cart"][$i]]); ?></td>
									<td class="align-middle text-center"><?php echo ($amounts[$i]); ?></td>

									<?php
									if ($_SESSION["qty"][$i] > $_SESSION["item_stock"][$i]) {
										$Stock_round = round($_SESSION["item_stock"][$i], 0, PHP_ROUND_HALF_UP);
										$Reservas_round = round($_SESSION["item_reservas"][$i], 0, PHP_ROUND_HALF_UP);
									?>
										<td class="align-middle text-center text-danger"><?php echo ($_SESSION["qty"][$i]); ?><br>
											En Inventario Hay: <?php echo $Stock_round;
																$reserva_message = "* Si necesita más unidades por favor contacte a su vendedor asignado.";
																$reserva_message2 .= "Del Producto " . substr($products[$_SESSION["cart"][$i]], 0, 20) . "... hay en reserva: " . $Reservas_round . "<br>"; ?></td>
									<?php
									} else {
									?>
										<td class="align-middle text-center"><?php echo ($_SESSION["qty"][$i]); ?></td>
									<?php
									}
									?>


									<td class="align-middle text-center"><?php echo ($_SESSION["amounts"][$i]); ?></td>
									<td class="align-middle text-center"><a href="?delete=<?php echo ($i); ?>"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
										<a href="?add=<?php echo ($i); ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
									</td>
								</tr>

							<?php
								// TOTAL Compra
								$total = $total + $_SESSION["amounts"][$i];
							}
							$_SESSION["total"] = $total;
							?>
						</table>
					</div>
					<p><a href="?fullreset=true">Quitar Todo</a></p>

					<br />
					<p class="text-primary">Sub-Total : <?php echo (number_format($total, 2, '.', ',')); ?></p>
					<p class="text-primary">I.V.A 12% : <?php echo (number_format($total * 0.12, 2, '.', ',')); ?></p>
					<p class="text-danger">Total : <?php echo (number_format($total * 1.12, 2, '.', ',')); ?></p>
					<br />

					<?php
					// Check if cart is enabled and if cart total $ is >=100 
					if (isset($_SESSION['login_clase'])) {
						if ($_SESSION['enable_carrito'] == false) {
							echo "<p><b>* La generación de orden de compras se encuentra desactivada por el Administrador.</b></p>";
						} else {
							if ($total >= 100) {
					?>
								<p><a class="btn btn-primary" href="cart_comprar.php" role="button">Generar Orden de Compra</a></p>
							<?php
							}
						}
						$SES = trim($_SESSION['login_id']);
						if ($SES === "0931531115") {
							?>
							<p><a class="btn btn-primary" href="cart_comprar.php" role="button">Generar Orden de Compra</a></p>
						<?php
						} else {
						?>
							<p><?php echo $SES ?></p>
					<?php
						}
					}


					?>



					<?php if ($total < 100) {
						echo '<p class="text-info">* La orden debe tener mínimo un sub-total de $100 dólares.</p>';
					} ?>
					<p class="text-danger"><?php echo $reserva_message; ?></p>
					<p><?php echo $reserva_message2; ?></p>
				<?php
				} else {
					echo "No tiene productos agregados en el carrito de compras...";
				}
				// END OF if $_SESSION["cart"]
				?>
				<p>* El carrito se borra automáticamente después de cerrar el navegador o después de 4 horas.</p>
			</div>
		</div>
	</section>
</main>

<?php require 'footer.php'; ?>