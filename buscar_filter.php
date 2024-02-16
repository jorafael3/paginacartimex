<!DOCTYPE html>
<html>
<?php
// Starting Session
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
?>
<?php require 'head.php';
?>

<style>

</style>
<?php
// WEB_BUSQUEDA_PRODUCTO @NOMBRE, @CLASE
// Donde @CLASE = 01, 02, 03

	require('dbcore.php'); //Call database connection module
	require('injection/injections.php'); //Anti Hacking Module

$class="03";
if (isset($_SESSION['login_clase']))
	{
		$class=$_SESSION['login_clase'];
	}
else {$class="03";}

// GET User Input as variables
	if (isset($_GET["product"]))
	{
		$userInput = $_GET["product"]; // Get user input via form
	}
	else {$userInput = "Procesador";}

	$search1 = sanitize($userInput); // Filter the user input
	$search = str_replace("%20", " ", $search1);		// Replaces "%20" for "blank spaces"

		// If user input is less than 2 chars... DIE
	if (strlen($search) < 2)
		{
			$search = "Procesador";
		}

		// If user input is more than 80 chars... DIE
	if (strlen($search) > 80)
		{
			$search = "Procesador";
		}

    //Establishes the connection
	$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

    //Select Query
	$search_backend = str_replace(" ", "%", $search); // Replaces "blank spaces" for "%"
	$statement = $pdo->prepare('WEB_BUSQUEDA_PRODUCTO @NOMBRE=:name, @CLASE=:class');
	 $statement->bindParam(':name',$search_backend,PDO::PARAM_STR); // $search
     $statement->bindParam(':class',$class,PDO::PARAM_STR);

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
                  <a class="d-none d-print-block"><img src="assets/img/logo200.png"></a>
                    <h2 class="text-info d-print-none ">Resultado de la Búsqueda</h2>
                    <p class="d-print-none" >Búsqueda: <?php echo $search;?>
						<br>
						<span><a class="d-print-none" href="<?php echo "buscar.php?product=$search";?>"><i class="fa fa-th"></i>&nbsp;Visualizar en Galería</a></span>
					</p>
                </div>
                <div class="content">
                    <div class="row no-gutters justify-content-center">
                        <div class="col-md-9">
                            <div class="products">
                                <div class="table-responsive ">

								<table cellspacing="5" cellpadding="5" border="0" class="d-print-none">
									<tbody>
										<tr>
											<td>Precio Mínimo:</td>
											<td><input type="text" id="min" name="min"></td>
										</tr>
										<tr>
											<td>Precio Máximo:</td>
											<td><input type="text" id="max" name="max"></td>
										</tr>
									</tbody>
								</table>

									<table id="products" class="table-responsive table responsive table-bordered w-auto" style="width:100%">
										<thead >
											<tr>
												<th>Foto</th>
												<th>Nombre</th>
												<th>Código</th>
												<th>Stock</th>
												<th>Precio</th>
											</tr>
										</thead>
										<tbody>

									<?php
									while($row = $statement->fetch(PDO::FETCH_ASSOC))
									{
										//var_dump($row);
										if($ctr>500)
											break;
										$ctr++;

										$P_ID = $row['id'];
										$Codigo = $row['Código'];
										$Nombre = $row['Nombre'];
										$Precio = $row['PRECIO'];
										$Stock = $row['STOCK'];
										$Precio_round = round($Precio, 2, PHP_ROUND_HALF_UP);
										$Stock_round = round($Stock, 0, PHP_ROUND_HALF_UP);

										// http://167.114.98.49/v2/upload/
										// http://img.cartimex.com/v2/upload/
										$product_RawURL = "https://img.cartimex.com/v2/upload/$Codigo". " gr.jpg";
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
												<tr>
												<td>
												<div class=\"image\"><img class=\"img-fluid d-block mx-auto\" src=\"$product_image\" onerror=\"this.onerror=null;this.src='assets/img/Sin-Imagen.jpg';\"></div>
												</td>
												<td>
												<div class=\"product-name\" style=\"max-height: 75px;min-height: 75px;overflow: hidden;\"><a href=\"producto.php?productid=$P_ID\">$Nombre</a></div>
												</td>
												<div class=\"justify-content-center about\">
													<div class=\"justify-content-center text-center price\">
														<td><h6 class=\"text-center\">$Codigo</h6></td>";

														if ($_SESSION['show_stock'] == true)
															{
																if ($Stock > 0) {echo "<td><h6 class=\"text-center text-success\">En Stock: $Stock_round</h6></td>";} else {echo "<td><h6 class=\"text-center text-danger\">No hay en Stock</h6></td>";}
															}
														else
															{
																if ($Stock > 0) {echo "<td><h6 class=\"text-center text-success\">En Stock</h6></td>";} else {echo "<td><h6 class=\"text-center text-danger\">No hay en Stock</h6></td>";}
															}

										echo "
														<td><h6 class=\"text-center\">";

														if (($_SESSION['show_price'] == true) || (isset($_SESSION['loggedin'])))
															{
																if ($_SESSION['loggedin'] == true) {echo $Precio_round;}
																elseif ($_SESSION['show_price'] == true){echo $Precio_round;}
																else {echo '<a href="login.php">Ver Precio</a>';}
															}
														else
															{
																echo '<a href="login.php">Ver Precio</a>';
															}

														echo "</h6></td>
												</div>
												</div>
												</tr>

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
										</tbody>
									</table>
									</div>
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
        </section>
    </main>
<?php require 'footer_buscar.php';
?>
