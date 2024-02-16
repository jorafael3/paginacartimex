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

<?php 
require "head.php";
require 'dbcore.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
?>
<?php
$upload_path = "https://natsumi.cartimex.com/upload-reg/";
$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);


// Check Functions
$status_message = "";
$_SESSION['temp_name'] = "AUTO";
$_SESSION['temp_email'] = "AUTO";

function checkCedula($login_cedula) // Chequea si el campo Ruc (valida cedula tambien) existe en el dobra
{
	require 'dbcore.php';
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
			if ($cedula_exist == true)
			{
				$_SESSION['temp_name'] = $row2['Nombre'];
				$_SESSION['temp_email'] = $row2['Email'];				
			}
		}
	return $cedula_exist;
}

function checkDuplicate($login_cedula) // check for duplicated cedulas on web_loginpag
{
	require 'dbcore.php';
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
// END CHECK FUNCTIONS

// EMAIL Functions
function sendEmail($login_email) {
		$mail = new PHPMailer;
		$mail->CharSet = "UTF-8";
		$mail->Encoding = 'quoted-printable';
		$mail->isSMTP();
		$mail->SMTPDebug = SMTP::DEBUG_OFF; // 2;
		
		$mail->Host = 'mail.cartimex.com';
		$mail->Port = 465; //465 // 25 //587
		
		//Set the encryption mechanism to use - STARTTLS or SMTPS
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		
		$mail->SMTPOptions = array(
			'ssl' => [
				'verify_peer' => false,
				'verify_peer_name' => true,
				'peer_name' => 'mail.cartimex.com',
				'allow_self_signed' => true,
			],
		);
		
		$mail->SMTPAuth = true;
		
		$mail->Username = 'web';
		$mail->Password = 'misato19X';
		
		$mail->setFrom('web@cartimex.com', 'CARTIMEX'); // From
		$mail->addAddress($login_email, 'Usuario'); // To
		
		// Send Token
		$mail->Subject = 'Usuario CARTIMEX';
		$mail->Body    = "Su usuario ha sido creado, por favor ingrese al sitio con su RUC para crear una contraseña.";
		$mail->send();
		
		//send the message, check for errors LOG MODE
		/*
		if (!$mail->send()) {
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message sent!';
		}
		*/
}


// END EMAIL Functions

if (isset($_POST["user"]) && isset($_POST["cedula"])) 
	{
		// Sanitize user input
		$clean_c = filter_var($_POST["cedula"], FILTER_SANITIZE_NUMBER_INT);
		$clean_s = filter_var($_POST["user"], FILTER_SANITIZE_NUMBER_INT);
		if ($clean_s == "1")
			{
				// Set Status Ingresado
				$statement_global = $pdo->prepare("UPDATE web_regDistribuidor SET Estado='Ingresado' WHERE RUC=:cedula");
				$statement_global->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
				$statement_global->execute();
				
				$statement_global2 = $pdo->prepare("UPDATE web_regDistribuidor SET Fecha_Estado=GETDATE() WHERE RUC=:cedula");
				$statement_global2->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
				$statement_global2->execute();
			}
	
		if ($clean_s == "2")
			{
				// Set Status Rechazado
				$statement_global = $pdo->prepare("UPDATE web_regDistribuidor SET Estado='Rechazado' WHERE RUC=:cedula");
				$statement_global->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
				$statement_global->execute();
				
				$statement_global2 = $pdo->prepare("UPDATE web_regDistribuidor SET Fecha_Estado=GETDATE() WHERE RUC=:cedula");
				$statement_global2->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
				$statement_global2->execute();
			}
			
		if ($clean_s == "3")
			{
				// Set Status En Proceso
				$statement_global = $pdo->prepare("UPDATE web_regDistribuidor SET Estado='En Proceso' WHERE RUC=:cedula");
				$statement_global->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
				$statement_global->execute();
				
				$statement_global2 = $pdo->prepare("UPDATE web_regDistribuidor SET Fecha_Estado=GETDATE() WHERE RUC=:cedula");
				$statement_global2->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
				$statement_global2->execute();
			}
			
		if ($clean_s == "4")
			{				
				// Set Status Ingresar y Generar Usuario
				
				// Primero Chequear Duplicados en la base de la web_loginpag
				$result_duplicate = checkDuplicate($clean_c); // check for duplicate
				
				// Segundo Chequear que se encuentre registrado en el dobra
				$ced_status = checkCedula($clean_c);
				
				// De no estar en la tabla Web y de estar registrado en el dobra, entonces procede a crear el usuario web.
				if ($ced_status == true && $result_duplicate == false)
					{
						$statement_global = $pdo->prepare("INSERT INTO web_loginpag (CEDULA,NAME,EMAIL,CREATION_DATE,LAST_LOGIN,IS_ENABLED) VALUES (:cedula,:nombre,:email,GETDATE(),GETDATE(),'Y')");
						$statement_global->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
						$statement_global->bindParam(':nombre',$_SESSION['temp_name'],PDO::PARAM_STR);
						$statement_global->bindParam(':email',$_SESSION['temp_email'],PDO::PARAM_STR);
						$statement_global->execute();
						$status_message = "Usuario creado.";
						
						// Poner el usuario como registrado en la bitacora
						$statement_global2 = $pdo->prepare("UPDATE web_regDistribuidor SET Estado='Ingresado' WHERE RUC=:cedula");
						$statement_global2->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
						$statement_global2->execute();
						
						$statement_global3 = $pdo->prepare("UPDATE web_regDistribuidor SET Fecha_Estado=GETDATE() WHERE RUC=:cedula");
						$statement_global3->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
						$statement_global3->execute();
						
						// Enviar email al usuario indicando que su usuario ha sido creado
						sendEmail($_SESSION['temp_email']);
					}
				else {$status_message = "El usuario no existe en el Dobra.";}
				if ($result_duplicate==true){$status_message = "Ese RUC o CEDULA ya ha sido creado previamente en la tabla de la web.";}
			}
	}

// READ USERS LIST
$statement = $pdo->prepare('SELECT * FROM web_regDistribuidor where estado ='PENDIENTE'');
$statement->execute();
?>
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Registros de Distribuidor Online</h3></div>
                        
						<div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 font-weight-bold">Control de Registros</p>
                                    </div>
									
									<div class="card-body">
                                        <form method="post">
										    <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="usuario_id"><strong>Usuario CEDULA o RUC</strong></label><input class="form-control" type="text" placeholder="CEDULA / RUC" name="cedula"></div>		
														<label class="radio-inline"><input type="radio" name="user" value="1">Ingresado</label>&nbsp;&nbsp;
														<label class="radio-inline"><input type="radio" name="user" value="2">Rechazado</label>&nbsp;&nbsp;
														<label class="radio-inline"><input type="radio" name="user" value="3">En Proceso</label><br/>
														<label class="radio-inline"><input type="radio" name="user" value="4">Ingresado y Proceder a Generar Usuario</label><br/>
														<label class="radio-inline"><input type="radio" name="user" value="0" checked>Sin cambios</label>
                                                </div>												
                                            </div>
                                            
                                            <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Save Settings</button></div>
											<div class="form-group"><?php echo $status_message; ?></div>
                                        </form>
                                    </div>
								</div>
									
								<div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 font-weight-bold">Lista de Registros</p>
                                    </div>
                                    <div class="card-body">
									<button class="btn btn-info btn-sm" type="submit" id="searchPendiente" name="searchPendiente">Ver Pendientes</button>&nbsp;&nbsp;
									<button class="btn btn-info btn-sm" type="submit" id="searchProceso" name="searchProceso">Ver En Proceso</button>&nbsp;&nbsp;
									<button class="btn btn-info btn-sm" type="submit" id="searchTodo" name="searchTodo">Ver Todo</button>
										<br><br>
                                       <table id="users" class="table-responsive table responsive table-bordered w-auto">
											<thead>
											<tr>
												<th>ESTADO</th>
												<th>RUC</th>
												<th>NOMBRE EMPRESA</th>
												<th>EMAIL</th>
												<th>CIUDAD</th>
												<th>DIRECCION</th>
												<th>CELULAR</th>
												<th>REPRESENTANTE LEGAL</th>
												<th>CEDULA</th>
												<th>FECHA CREACION</th>
												<th>FECHA ESTADO</th>
											</tr>
											</thead>
											<tbody>
											 <?php
											$totalRow = 0;
											$ctr = 0;
											while($row = $statement->fetch(PDO::FETCH_ASSOC))
											{
												$db_estado = $row['Estado'];
												$db_ruc = $row['RUC'];
												$db_nombre = $row['Nombre'];
												$db_email = $row['EMAIL'];
												$db_ciudad = $row['Ciudad'];
												$db_direccion = $row['Direccion'];
												$db_celular = $row['Celular'];
												$db_representante = $row['rlegal'];
												$db_cedula = $row['Cedula'];
												$db_fecha_creacion = $row['Fecha_Create'];
												$db_fecha_estado = $row['Fecha_Estado'];
												
												echo "<tr>";
												echo "<td>$db_estado</td>";
												echo "<td>$db_ruc</td>";
												echo "<td>$db_nombre</td>";
												echo "<td>$db_email</td>";
												echo "<td>$db_ciudad</td>";
												echo "<td>$db_direccion</td>";
												echo "<td>$db_celular</td>";
												echo "<td>$db_representante</td>";
												echo "<td>$db_cedula</td>";
												echo "<td>$db_fecha_creacion</td>";
												echo "<td>$db_fecha_estado</td>";
												echo "</tr>";

												$totalRow++;
											}
											$statement = NULL;
											?>
											</tbody>
										</table>
										<BR>
										Total: <?php echo $totalRow;?>
                                    </div>
                                </div>
  
                            </div>
                        </div>
						
        </div>
<?php require "footer_tables_distribuidor.php";?>