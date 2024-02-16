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

if (isset($_POST["banner_size"])) 
{
	$clean_s = filter_var($_POST["banner_size"], FILTER_SANITIZE_URL);
	// UPDATE web_config SET VALUE=:banner WHERE CONFIG='banner_size'
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE=:banner WHERE CONFIG='banner_size'");
	$statement_global->bindParam(':banner',$clean_s,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["banner1"])) 
{
	$clean_b = filter_var($_POST["banner1"], FILTER_SANITIZE_URL);
	// UPDATE web_config SET VALUE2=:banner WHERE CONFIG='banner1'
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE2=:banner WHERE CONFIG='banner1'");
	$statement_global->bindParam(':banner',$clean_b,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["banner2"])) 
{
	$clean_b = filter_var($_POST["banner2"], FILTER_SANITIZE_URL);
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE2=:banner WHERE CONFIG='banner2'");
	$statement_global->bindParam(':banner',$clean_b,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["banner3"])) 
{
	$clean_b = filter_var($_POST["banner3"], FILTER_SANITIZE_URL);
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE2=:banner WHERE CONFIG='banner3'");
	$statement_global->bindParam(':banner',$clean_b,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["banner4"])) 
{
	$clean_b = filter_var($_POST["banner4"], FILTER_SANITIZE_URL);
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE2=:banner WHERE CONFIG='banner4'");
	$statement_global->bindParam(':banner',$clean_b,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["blink1"])) 
{
	$clean_l = filter_var($_POST["blink1"], FILTER_SANITIZE_URL);
	// UPDATE web_config SET VALUE3=:blink WHERE CONFIG='banner1'
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE3=:blink WHERE CONFIG='banner1'");
	$statement_global->bindParam(':blink',$clean_l,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["blink2"])) 
{
	$clean_l = filter_var($_POST["blink2"], FILTER_SANITIZE_URL);
	// UPDATE web_config SET VALUE3=:blink WHERE CONFIG='banner2'
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE3=:blink WHERE CONFIG='banner2'");
	$statement_global->bindParam(':blink',$clean_l,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["blink3"])) 
{
	$clean_l = filter_var($_POST["blink3"], FILTER_SANITIZE_URL);
	// UPDATE web_config SET VALUE3=:blink WHERE CONFIG='banner3'
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE3=:blink WHERE CONFIG='banner3'");
	$statement_global->bindParam(':blink',$clean_l,PDO::PARAM_STR);
	$statement_global->execute();
}

if (isset($_POST["blink4"])) 
{
	$clean_l = filter_var($_POST["blink4"], FILTER_SANITIZE_URL);
	// UPDATE web_config SET VALUE3=:blink WHERE CONFIG='banner4'
	$statement_global = $pdo_global->prepare("UPDATE web_config SET VALUE3=:blink WHERE CONFIG='banner4'");
	$statement_global->bindParam(':blink',$clean_l,PDO::PARAM_STR);
	$statement_global->execute();
}

// READ
$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='banner_size'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['banner_size'] = $row_global['VALUE'];}

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='banner1'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['banner1'] = $row_global['VALUE2']; $_SESSION['blink1'] = $row_global['VALUE3'];}

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='banner2'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['banner2'] = $row_global['VALUE2']; $_SESSION['blink2'] = $row_global['VALUE3'];}

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='banner3'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['banner3'] = $row_global['VALUE2']; $_SESSION['blink3'] = $row_global['VALUE3'];}

$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='banner4'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['banner4'] = $row_global['VALUE2']; $_SESSION['blink4'] = $row_global['VALUE3'];}		
?>
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Banners</h3></div>
                        
						<div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 font-weight-bold">Banners URL</p>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
										    <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="banner_size"><strong>Banner Size (Width)</strong></label><input class="form-control" type="text" placeholder="auto, 100px, 500px, etc." name="banner_size" value="<?php echo $_SESSION['banner_size']?>"></div>													
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="banner1"><strong>Banner 1</strong></label><input class="form-control" type="text" placeholder="Image URL" name="banner1" value="<?php echo $_SESSION['banner1']?>"></div>
													<div class="form-group"><label for="blink1"><strong>Link 1</strong></label><input class="form-control" type="text" placeholder="URL" name="blink1" value="<?php echo $_SESSION['blink1']?>"></div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="banner2"><strong>Banner 2</strong></label><input class="form-control" type="text" placeholder="Image URL" name="banner2" value="<?php echo $_SESSION['banner2']?>"></div>
													<div class="form-group"><label for="blink2"><strong>Link 2</strong></label><input class="form-control" type="text" placeholder="URL" name="blink2" value="<?php echo $_SESSION['blink2']?>"></div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="banner3"><strong>Banner 3</strong></label><input class="form-control" type="text" placeholder="Image URL" name="banner3" value="<?php echo $_SESSION['banner3']?>"></div>
													<div class="form-group"><label for="blink3"><strong>Link 3</strong></label><input class="form-control" type="text" placeholder="URL" name="blink3" value="<?php echo $_SESSION['blink3']?>"></div>
                                                </div>
                                            </div>
											<div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="banner4"><strong>Banner 4</strong></label><input class="form-control" type="text" placeholder="Image URL" name="banner4" value="<?php echo $_SESSION['banner4']?>"></div>
													<div class="form-group"><label for="blink4"><strong>Link 4</strong></label><input class="form-control" type="text" placeholder="URL" name="blink4" value="<?php echo $_SESSION['blink4']?>"></div>
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