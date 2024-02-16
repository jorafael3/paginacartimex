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

if (isset($_POST["product1"])) 
{
	$clean_p = filter_var($_POST["product1"], FILTER_SANITIZE_URL);
	// UPDATE web_config SET VALUE=:product WHERE CONFIG='product1'
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE=:product WHERE CONFIG='product1'");
	$statement_global->bindParam(':product',$clean_p,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["product2"])) 
{
	$clean_p = filter_var($_POST["product2"], FILTER_SANITIZE_URL);
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE=:product WHERE CONFIG='product2'");
	$statement_global->bindParam(':product',$clean_p,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["product3"])) 
{
	$clean_p = filter_var($_POST["product3"], FILTER_SANITIZE_URL);
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE=:product WHERE CONFIG='product3'");
	$statement_global->bindParam(':product',$clean_p,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["product4"])) 
{
	$clean_p = filter_var($_POST["product4"], FILTER_SANITIZE_URL);
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE=:product WHERE CONFIG='product4'");
	$statement_global->bindParam(':product',$clean_p,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["product5"])) 
{
	$clean_p = filter_var($_POST["product5"], FILTER_SANITIZE_URL);
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE=:product WHERE CONFIG='product5'");
	$statement_global->bindParam(':product',$clean_p,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["product6"])) 
{
	$clean_p = filter_var($_POST["product6"], FILTER_SANITIZE_URL);
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE=:product WHERE CONFIG='product6'");
	$statement_global->bindParam(':product',$clean_p,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["product7"])) 
{
	$clean_p = filter_var($_POST["product7"], FILTER_SANITIZE_URL);
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE=:product WHERE CONFIG='product7'");
	$statement_global->bindParam(':product',$clean_p,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["product8"])) 
{
	$clean_p = filter_var($_POST["product8"], FILTER_SANITIZE_URL);
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE=:product WHERE CONFIG='product8'");
	$statement_global->bindParam(':product',$clean_p,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["product9"])) 
{
	$clean_p = filter_var($_POST["product9"], FILTER_SANITIZE_URL);
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE=:product WHERE CONFIG='product9'");
	$statement_global->bindParam(':product',$clean_p,PDO::PARAM_STR);
	$statement_global->execute();
}

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product1'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product1'] = $row_global['VALUE'];}

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product2'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product2'] = $row_global['VALUE'];}

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product3'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product3'] = $row_global['VALUE'];}

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product4'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product4'] = $row_global['VALUE'];}		

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product5'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product5'] = $row_global['VALUE'];}		

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product6'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product6'] = $row_global['VALUE'];}		

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product7'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product7'] = $row_global['VALUE'];}		

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product8'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product8'] = $row_global['VALUE'];}		

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product9'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product9'] = $row_global['VALUE'];}		

?>
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Productos</h3></div>
                        
						<div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 font-weight-bold">Productos IDs</p>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="product1"><strong>Producto 1</strong></label><input class="form-control" type="text" placeholder="ID del Producto" name="product1" value="<?php echo $_SESSION['product1']?>"></div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="product2"><strong>Producto 2</strong></label><input class="form-control" type="text" placeholder="ID del Producto" name="product2" value="<?php echo $_SESSION['product2']?>"></div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="product3"><strong>Producto 3</strong></label><input class="form-control" type="text" placeholder="ID del Producto" name="product3" value="<?php echo $_SESSION['product3']?>"></div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="product4"><strong>Producto 4</strong></label><input class="form-control" type="text" placeholder="ID del Producto" name="product4" value="<?php echo $_SESSION['product4']?>"></div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="product4"><strong>Producto 5</strong></label><input class="form-control" type="text" placeholder="ID del Producto" name="product5" value="<?php echo $_SESSION['product5']?>"></div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="product4"><strong>Producto 6</strong></label><input class="form-control" type="text" placeholder="ID del Producto" name="product6" value="<?php echo $_SESSION['product6']?>"></div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="product4"><strong>Producto 7</strong></label><input class="form-control" type="text" placeholder="ID del Producto" name="product7" value="<?php echo $_SESSION['product7']?>"></div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="product4"><strong>Producto 8</strong></label><input class="form-control" type="text" placeholder="ID del Producto" name="product8" value="<?php echo $_SESSION['product8']?>"></div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="product4"><strong>Producto 9</strong></label><input class="form-control" type="text" placeholder="ID del Producto" name="product9" value="<?php echo $_SESSION['product9']?>"></div>
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