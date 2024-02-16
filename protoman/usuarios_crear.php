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
$clean_cedula="";
$clean_nombre="";
$clean_email="";

require('dbcore.php');
$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
$status_message = "";

function checkCedula($login_cedula) // Chequea si el campo Ruc (valida cedula tambien) existe en el dobra
{
	require('dbcore.php');
	$pdo2 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
	$statement2 = $pdo2->prepare("WEB_LOGIN @CEDULA=:cedula");
	$statement2->bindParam(':cedula',$login_cedula,PDO::PARAM_STR);
	$statement2->execute();
	
	$cedula_exist = false;
	while($row2 = $statement2->fetch(PDO::FETCH_ASSOC))
		{
			if (empty($row2['Ruc'])) 
			{
				$cedula_exist = false;
			}
			else 
			{
				$cedula_exist = true;
			}					
			// $user_cedula = $row2['Ruc'];		
		}
	return $cedula_exist;
}

function checkDuplicate($login_cedula) // check for duplicated cedulas on web_loginpag
{
	require('dbcore.php');
	$pdo2 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
	$statement2 = $pdo2->prepare("SELECT CEDULA FROM web_loginpag WHERE CEDULA=:cedula");
	$statement2->bindParam(':cedula',$login_cedula,PDO::PARAM_STR);
	$statement2->execute();
	
	$ctr = 0;
	while($row2 = $statement2->fetch(PDO::FETCH_ASSOC))
		{
			$ctr++;
		}
	if ($ctr > 0){$cedula_duplicate = true;}
	if ($ctr == 0){$cedula_duplicate = false;}
	return $cedula_duplicate;
}

if (isset($_POST["usuario_cedula"]) && isset($_POST["usuario_email"]) && isset($_POST["usuario_nombre"])) 
	{
		// Sanitize user input
		$clean_cedula = filter_var($_POST["usuario_cedula"], FILTER_SANITIZE_NUMBER_INT);
		$clean_nombre = filter_var($_POST["usuario_nombre"], FILTER_SANITIZE_STRING);
		$clean_email = filter_var($_POST["usuario_email"], FILTER_SANITIZE_EMAIL);
		
		$result_duplicate = checkDuplicate($clean_cedula); // check for duplicate
		
		if ($result_duplicate==true){$status_message = "Ese RUC o CEDULA ya ha sido creado previamente.";}
		if (strlen($clean_cedula) > 5 && strlen($clean_nombre) > 5 && strlen($clean_email) > 4 && $result_duplicate == false)
			{
				$ced_status = checkCedula($clean_cedula); // check cedula exists on Dobra first
				if ($ced_status == true)
					{
						$statement_global = $pdo->prepare("INSERT INTO web_loginpag (CEDULA,NAME,EMAIL,CREATION_DATE,LAST_LOGIN,IS_ENABLED) VALUES (:cedula,:nombre,:email,GETDATE(),GETDATE(),'Y')");
						$statement_global->bindParam(':cedula',$clean_cedula,PDO::PARAM_STR);
						$statement_global->bindParam(':nombre',$clean_nombre,PDO::PARAM_STR);
						$statement_global->bindParam(':email',$clean_email,PDO::PARAM_STR);
						$statement_global->execute();
						$status_message = "Usuario creado.";
					}
				else {$status_message = "El usuario no existe en el Dobra.";}
			}	
	}

?>
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Usuarios</h3></div>
                        
						<div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 font-weight-bold">Crear Usuario</p>
                                    </div>
									
									<div class="card-body">
                                        <form method="post">
										    <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="usuario_cedula"><strong>CEDULA o RUC</strong></label><input class="form-control" type="text" placeholder="CEDULA / RUC" name="usuario_cedula" value="<?php echo $clean_cedula;?>"></div>		
                                                </div>
											</div>
												
											<div class="form-row">
												<div class="col">
                                                    <div class="form-group"><label for="usuario_nombre"><strong>NOMBRE</strong></label><input class="form-control" type="text" placeholder="NOMBRE COMPLETO" name="usuario_nombre" value="<?php echo $clean_nombre;?>"></div>		
                                                </div>
											</div>
												
											<div class="form-row">
												<div class="col">
                                                    <div class="form-group"><label for="usuario_email"><strong>EMAIL</strong></label><input class="form-control" type="text" placeholder="EMAIL" name="usuario_email" value="<?php echo $clean_email;?>"></div>		
                                                </div>						
                                            </div>
                                            
                                            <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Create User</button></div>
                                        </form>
										<br>
										Estado: <?php echo $status_message;?>
                                    </div>
								</div>
									

  
                            </div>
                        </div>
						
        </div>
<?php require "footer_tables.php";?>