<!DOCTYPE html>
<html>

<?php
session_name("protoman");
session_start();
// Check if Logged in
if ( isset($_SESSION['loggedin']) )
	{
		if ($_SESSION['loggedin'] == true){}
		else {echo '<script>window.location.replace("login.php")</script>';die();}
	}
else {echo '<script>window.location.replace("login.php")</script>';die();}
?>

<?php require "head.php";?>
<?php
require('dbcore.php');
$pdo_global = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

if (isset($_POST["stock"])) 
	{
		// Stock write config
		$clean_s = filter_var($_POST["stock"], FILTER_SANITIZE_NUMBER_INT);
		if ($clean_s == "1")
			{
				// UPDATE web_config SET VALUE='true' WHERE CONFIG='show_stock'
				$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE='true' WHERE CONFIG='show_stock'");
				$statement_global->execute();
			}
	
		if ($clean_s == "0")
			{
				// UPDATE web_config SET VALUE='false' WHERE CONFIG='show_stock'
				$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE='false' WHERE CONFIG='show_stock'");
				$statement_global->execute();
			}
	}

if (isset($_POST["price"])) 
	{
		// Price write config
		$clean_p = filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_INT);
		if ($clean_p == "1")
			{
				// UPDATE web_config SET VALUE='true' WHERE CONFIG='show_price'
				$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE='true' WHERE CONFIG='show_price'");
				$statement_global->execute();
			}
	
		if ($clean_p == "0")
			{
				// UPDATE web_config SET VALUE='false' WHERE CONFIG='show_price'
				$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE='false' WHERE CONFIG='show_price'");
				$statement_global->execute();
			}
	}
	
if (isset($_POST["search"])) 
	{
		// Save Search write config
		$clean_search = filter_var($_POST["search"], FILTER_SANITIZE_NUMBER_INT);
		if ($clean_search == "1")
			{
				// UPDATE web_config SET VALUE='true' WHERE CONFIG='save_search'
				$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE='true' WHERE CONFIG='save_search'");
				$statement_global->execute();
			}
	
		if ($clean_search == "0")
			{
				// UPDATE web_config SET VALUE='false' WHERE CONFIG='show_price'
				$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE='false' WHERE CONFIG='save_search'");
				$statement_global->execute();
			}
	}

if (isset($_POST["distribuidor"])) 
	{
		// Save Distribuidor write config
		$clean_distribuidor = filter_var($_POST["distribuidor"], FILTER_SANITIZE_NUMBER_INT);
		if ($clean_distribuidor == "1")
			{
				// UPDATE web_config SET VALUE='true' WHERE CONFIG='save_search'
				$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE='true' WHERE CONFIG='enable_regs'");
				$statement_global->execute();
			}
	
		if ($clean_distribuidor == "0")
			{
				// UPDATE web_config SET VALUE='false' WHERE CONFIG='show_price'
				$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE='false' WHERE CONFIG='enable_regs'");
				$statement_global->execute();
			}
	}
	
if (isset($_POST["carrito"])) 
	{
		// Save carrito write config
		$clean_carrito = filter_var($_POST["carrito"], FILTER_SANITIZE_NUMBER_INT);
		if ($clean_carrito == "1")
			{
				// UPDATE web_config SET VALUE='true' WHERE CONFIG='enable_carrito'
				$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE='true' WHERE CONFIG='enable_carrito'");
				$statement_global->execute();
			}
	
		if ($clean_carrito == "0")
			{
				// UPDATE web_config SET VALUE='false' WHERE CONFIG='enable_carrito'
				$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE='false' WHERE CONFIG='enable_carrito'");
				$statement_global->execute();
			}
	}
//--------------------------READS------------------------------------------------------------
// Price Read
$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='show_price'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC))
	{
		if ($row_global['VALUE'] == "true"){$_SESSION['show_price'] = "1";}
		if ($row_global['VALUE'] == "false"){$_SESSION['show_price'] = "0";}
	}

// Stock Read
$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='show_stock'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC))
	{
		if ($row_global['VALUE'] == "true") {$_SESSION['show_stock'] = "1";}
		if ($row_global['VALUE'] == "false") {$_SESSION['show_stock'] = "0";}
	}	

// Save Search Read
$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='save_search'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC))
	{
		if ($row_global['VALUE'] == "true"){$_SESSION['save_search'] = "1";}
		if ($row_global['VALUE'] == "false"){$_SESSION['save_search'] = "0";}
	}
	
// Distribuidor Read
$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='enable_regs'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC))
	{
		if ($row_global['VALUE'] == "true"){$_SESSION['enable_regs'] = "1";}
		if ($row_global['VALUE'] == "false"){$_SESSION['enable_regs'] = "0";}
	}
	
// Carrito Read
$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='enable_carrito'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC))
	{
		if ($row_global['VALUE'] == "true"){$_SESSION['enable_carrito'] = "1";}
		if ($row_global['VALUE'] == "false"){$_SESSION['enable_carrito'] = "0";}
	}
	
?>

            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Global Options</h3></div>
                        
						<div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 font-weight-bold">Options</p>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="Price"><strong>Mostrar Precios (Afecta a los usuarios no registrados "Guest")</strong></label><br/>
														<label class="radio-inline"><input type="radio" name="price" value="1" <?php if ($_SESSION['show_price'] == "1"){echo "checked";}?>>SI</label><br/>
														<label class="radio-inline"><input type="radio" name="price" value="0" <?php if ($_SESSION['show_price'] == "0"){echo "checked";}?>>NO</label>
														</div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="Stock"><strong>Mostrar Stock (Afecta a todos los usuarios registrados y no registrados)</strong></label><br/>
														<label class="radio-inline"><input type="radio" name="stock" value="1" <?php if ($_SESSION['show_stock'] == "1"){echo "checked";}?>>SI</label><br/>
														<label class="radio-inline"><input type="radio" name="stock" value="0" <?php if ($_SESSION['show_stock'] == "0"){echo "checked";}?>>NO</label>
													</div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="Search"><strong>Guardar Búsquedas (Estadísticas)</strong></label><br/>
														<label class="radio-inline"><input type="radio" name="search" value="1" <?php if ($_SESSION['save_search'] == "1"){echo "checked";}?>>SI</label><br/>
														<label class="radio-inline"><input type="radio" name="search" value="0" <?php if ($_SESSION['save_search'] == "0"){echo "checked";}?>>NO</label>
													</div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="Distribuidor"><strong>Habilitar Registros (Ser Distribuidor)</strong></label><br/>
														<label class="radio-inline"><input type="radio" name="distribuidor" value="1" <?php if ($_SESSION['enable_regs'] == "1"){echo "checked";}?>>SI</label><br/>
														<label class="radio-inline"><input type="radio" name="distribuidor" value="0" <?php if ($_SESSION['enable_regs'] == "0"){echo "checked";}?>>NO</label>
													</div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="Carrito"><strong>Habilitar Carrito de Compras (Afecta sólo a la generación de orden de compra)</strong></label><br/>
														<label class="radio-inline"><input type="radio" name="carrito" value="1" <?php if ($_SESSION['enable_carrito'] == "1"){echo "checked";}?>>SI</label><br/>
														<label class="radio-inline"><input type="radio" name="carrito" value="0" <?php if ($_SESSION['enable_carrito'] == "0"){echo "checked";}?>>NO</label>
													</div>
                                                </div>
                                            </div>
                                            <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Save Settings</button></div>
                                        </form>
                                    </div>
                                </div>
  
                            </div>
                        </div>
						
        </div>
<?php require "footer.php";?>