<main class="page landing-page">
	<section class="clean-block slider dark" style="height: auto;width: auto;padding: 15px;">
		<div class="container <?php if ($_SESSION['banner_size'] != "auto") {
									echo "d-flex justify-content-center";
								} ?>">
			<div class="carousel slide carousel-fade" data-ride="carousel" id="carousel-1" style="width: <?php echo $_SESSION['banner_size']; ?>;">
				<div class="carousel-inner" role="listbox" style="width: auto;">
					<div class="carousel-item img-fluid active"><a href="<?php echo $_SESSION['blink1']; ?>"><img class="w-100 d-block" src="<?php echo $_SESSION['banner1']; ?>" alt="Slide Image"></a></div>
					<div class="carousel-item img-fluid"><a href="<?php echo $_SESSION['blink2']; ?>"><img class="w-100 d-block" src="<?php echo $_SESSION['banner2']; ?>" alt="Slide Image"></a></div>
					<div class="carousel-item img-fluid"><a href="<?php echo $_SESSION['blink3']; ?>"><img class="w-100 d-block" src="<?php echo $_SESSION['banner3']; ?>" alt="Slide Image"></a></div>
					<div class="carousel-item img-fluid"><a href="<?php echo $_SESSION['blink4']; ?>"><img class="w-100 d-block" src="<?php echo $_SESSION['banner4']; ?>" alt="Slide Image"></a></div>
				</div>
				<div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button" data-slide="next"><span class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a></div>
				<ol class="carousel-indicators">
					<li data-target="#carousel-1" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-1" data-slide-to="1"></li>
					<li data-target="#carousel-1" data-slide-to="2"></li>
					<li data-target="#carousel-1" data-slide-to="3"></li>
				</ol>
			</div>
		</div>
	</section>
</main>


<!-------------------------------------- OFERTAS -------------------------------------------------------
	<section class="clean-block slider dark" style="height: auto;width: auto;padding: 15px;">
		 Aqui se pone la imagen que se quiera cargar al inicio de la pagina
		<div class="container-fluid">
			<div class="content" style="width: auto;">
				<div id="Mymodal" class="modal fade" role="dialog" >
				  <div class="modal-dialog modal-lg">
					<div class="modal-content">
					
					   <div class="modal-body">
						 <div class="row justify-content-center">
						
								<a> <img src="assets/img/popupinfo.jpg" style="max-width:100%;height:auto;"></a>
							 
						 </div>
					   </div>
				  </div>
				</div>
				</div>
			</div>
		</div>   -->


<section class="clean-block slider dark" style="height: auto;width: auto;padding: 15px;">
	<!-- Aqui se pone la imagen que se quiera cargar al inicio de la pagina -->
	<div class="container-fluid">
		<div class="content" style="width: auto;">
			<div id="Mymodal" class="modal fade" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title"></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row justify-content-center">
								<a href="https://www.cartimex.com/comunicado.php"> <img src="assets/img/comley.jpg" style="max-width:100%;height:auto;"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class="clean-block clean-catalog dark">

		<div class="container">
			<div class="block-heading">
				<h2 class="text-info">Productos Destacados</h2>
			</div>
			<div class="content">
				<div class="row justify-content-center">
					<div class="col-md-9">
						<div class="products">
							<div class="row no-gutters">

								<?php
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
								for ($i = 1; $i <= 9; $i++)  // INIT FOR
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

	<script src="assets/js/jquery.min.js"></script>
	<script type="text/javascript">
		$(window).on("load", function() {
			$('#Mymodal').modal('show');
		});
	</script>