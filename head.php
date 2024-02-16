<?php require "head_globals.php"; ?>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Cartimex</title>
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/bootstrap/css/rvc.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
	<link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
	<link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
	<link rel="stylesheet" href="assets/baguettebox/baguetteBox.min.css">
	<link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
	<link rel="stylesheet" href="assets/css/smoothproducts.css">
	<link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css" />

</head>

<body>
	<nav class="navbar navbar-light navbar-expand-xl bg-white clean-navbar">
		<div class="container"><a href="index.php" class="navbar-brand logo"><img src="assets/img/logo200.png"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse" id="navcol-1">
				<ul class="nav navbar-nav">
					<li class="nav-item" role="presentation">
						<form class="form-inline mr-auto" target="_self" action="buscar.php" method="get">
							<div class="form-group"><label for="search-field"></label><input class="border-primary form-control search-field" type="search" id="search-field" name="product" style="font-size: 14px;" placeholder="Buscar en Cartimex" required="" minlength="2"></div>
							<button class="btn btn-light action-button" type="submit" style="background-color: rgba(248,249,250,0);margin-right: 0px;margin-left: 4px;"><i class="fa fa-search"></i></button>
						</form>
					</li>
					<li class="nav-item dropdown keep-open menu-open" href="#">
						<a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Categorías</a>
						<div class="dropdown-menu" role="menu" href="#">
							<div class="nav-item dropright" href="#">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Computadoras</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000075">Escritorio y All In One</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000068">Laptops</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000109">Computadoras Gamer</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000081">Monitores</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000029">Software y Antivirus</a>
								</div>
							</div>
							<div class="nav-item dropright" href="#">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Accesorios</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000097">Teclado y Mouse</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000013">Mochilas, Fundas y Protectores</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000127">Cables y Adaptadores</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000072">Parlantes de PC</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000021">Accesorios Gamer</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Componentes</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000023">Discos Duros</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000006">Cases</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000011">Procesadores</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000039">Coolers</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000062">Tarjetas de Video</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000099">Opticos (CD, DVD)</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000030">Mainboard</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000106">Memorias</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000125">Tarjetas de Red</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Almacenamiento</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000003">Disco Externo</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000005">Pendrive</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000009">Tarjetas de Memoria</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Impresoras y Escaners</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000056">Impresora Inyección</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000010">Impresora Láser</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000069">Escaners</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000122">Punto de Venta</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000128">Suministros</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Audio</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000084">Audífonos</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000031">Audífonos Inalámbricos</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000073">Parlantes</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000071">Barras de Sonido</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000126">Radios</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000085">Cables, Adaptadores y Accesorios</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Videojuegos</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000004">Consolas</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000077">Juegos</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000078">Accesorios</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Hogar</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000033">Muebles</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Electrodomesticos</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000169">Acondicionadores de Aire </a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000173">Cocinas y Hornos </a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000178">Dispensadores de Agua </a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000181">Electrodomesticos Menores </a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000189">Lavadoras y Secadoras </a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000193">Maquinas de Limpieza </a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000196">Refrigeradoras y Congeladores</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Celulares y Tablets</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000094">Celulares</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000141">Tablets</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000142">Accesorios</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000204">Smart Watch</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">TV y Video</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000067">Televisores</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000086">Proyectores</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000121">Cámaras</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000143">Accesorios</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000147">Reproductores Streaming</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Protección de Voltaje</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000046">UPS</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000102">Reguladores</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000111">Supresores</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000120">Accesorios</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Seguridad</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000050">Kits de Seguridad</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000096">Cámaras de Seguridad</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000112">Video Porteros</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000113">Lector Biométrico</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000114">Accesorios</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Telefonía y Videoconferencia</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000042">Teléfonos IP</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000095">Teléfonos Análogos</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000098">Videoconferencia</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000123">Accesorios</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Redes</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000091">Router</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000089">Access Point</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000108">Switch</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000101">Cables</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000028">Accesorios para Cableado</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000104">Adaptadores</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000107">Antenas y Radio Enlaces</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Servidores</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000051">Tipo Torre</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000115">Tipo Rack</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000116">Almacenamiento NAS</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000117">Componentes</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Smart Home</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000103 ">Smart Home</a>
								</div>
							</div>
							<div class="nav-item dropright">
								<a class="dropdown-toggle dropdown-submenu dropdown-item" data-toggle="dropdown" aria-expanded="false" href="#">Movilidad</a>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000208">Moto Electrica</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000209">Bicicleta Electrica</a>
									<a class="dropdown-item" role="presentation" href="categoria.php?group=0000000222">Moto a Gasolina</a>
								</div>
							</div>
						</div>
					</li>
					<!--   <li class="nav-item" role="presentation"><a class="nav-link" href="ofertas.php">Aniversario Xtratech &nbsp;<i class="fa fa-tag"></i></a></li>-->
					<li class="nav-item" role="presentation"><a class="nav-link" href="ofertas.php">Ofertas&nbsp;<i class="fa fa-tag"></i></a></li>
					<li class="nav-item" role="presentation"><a class="nav-link" href="cart.php">Carrito&nbsp;<i class="fa fa-shopping-cart"></i></a></li>
					<li class="nav-item" role="presentation"></li>
					<li class="nav-item" role="presentation">

						<?php
						// -------------------------------- ICONO USUARIO --------------------------------------
						if (isset($_SESSION['loggedin'])) {
							if ($_SESSION['loggedin'] == true) {
								//
						?>
					<li class="nav-item dropdown" href="#">
						<a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
						<div class="dropdown-menu" role="menu" href="#">
							<div class="nav-item" href="reset.php">
								<a class="dropdown-item" aria-expanded="false" href="#"><?php echo $_SESSION['login_nombre']; ?></a>
							</div>
							<div class="nav-item" href="reset.php">
								<a class="dropdown-item" aria-expanded="false" href="reset.php"><i class="fa fa-key" aria-hidden="true"></i>&nbsp;&nbsp;Cambiar Contraseña</a>
							</div>
							<div class="nav-item" href="logout.php">
								<a class="dropdown-item" aria-expanded="false" href="logout.php"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Cerrar Sesión</a>
							</div>
						</div>
					</li>

			<?php
							} else {
								echo '<a class="nav-link" href="login.php">Login&nbsp;<i class="fa fa-sign-in"></i></a>';
							}
						} else {
							echo '<a class="nav-link" href="login.php">Login&nbsp;<i class="fa fa-sign-in"></i></a>';
						}
			?>
			</li>
				</ul>
			</div>
		</div>
	</nav>