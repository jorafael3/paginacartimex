<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin - Cartimex</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
	<link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css"/>
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="index.php">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-flask"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Cartimex</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-white" id="accordionSidebar">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="index.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="banners.php"><i class="fas fa-images"></i><span>Banners</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="destacados.php"><i class="fas fa-tags"></i><span>Destacados</span></a></li>
					<li class="nav-item" role="presentation"><a class="nav-link" href="usuarios.php"><i class="fas fa-users"></i><span>Usuarios</span></a></li>
					<li class="nav-item" role="presentation"><a class="nav-link" href="registro_distribuidor.php"><i class="fas fa-clipboard-list"></i><span>Registros Online</span></a></li>
					<li class="nav-item" role="presentation"><a class="nav-link" href="registro_carrito.php"><i class="fas fa-clipboard-list"></i><span>Ordenes Online</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="estadisticas.php"><i class="fas fa-list-alt"></i><span>Estadísticas</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="options.php"><i class="fas fa-tools"></i><span>Configuración Global</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Buscar...">
                                <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                            </div>
                        </form>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">

                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small">Protoman</span><img class="border rounded-circle img-profile" src="assets/img/protoman.png"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
										<a class="dropdown-item" role="presentation" href="changepass.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Cambiar Contraseña</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a></div>
                    </div>
                    </li>
                    </ul>
            </div>
            </nav>
