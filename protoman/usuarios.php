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
$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

if (isset($_POST["user"]) && isset($_POST["cedula"])) 
	{
		// Sanitize user input
		$clean_c = filter_var($_POST["cedula"], FILTER_SANITIZE_NUMBER_INT);
		$clean_s = filter_var($_POST["user"], FILTER_SANITIZE_NUMBER_INT);
		if ($clean_s == "1")
			{
				// Reset Password
				$statement_global = $pdo->prepare("UPDATE web_loginpag SET PASSWORD='' WHERE CEDULA=:cedula");
				$statement_global->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
				$statement_global->execute();
			}
	
		if ($clean_s == "2")
			{
				// Enable User
				$statement_global = $pdo->prepare("UPDATE web_loginpag SET IS_ENABLED='Y' WHERE CEDULA=:cedula");
				$statement_global->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
				$statement_global->execute();
			}

		if ($clean_s == "3")
			{
				// Disable User
				$statement_global = $pdo->prepare("UPDATE web_loginpag SET IS_ENABLED='N' WHERE CEDULA=:cedula");
				$statement_global->bindParam(':cedula',$clean_c,PDO::PARAM_STR);
				$statement_global->execute();
			}
	}

// READ USERS LIST
$statement = $pdo->prepare('SELECT * FROM web_loginpag');
$statement->execute();
?>
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Usuarios</h3></div>
                        
						<div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 font-weight-bold">Control de Usuarios</p>
                                    </div>
									
									<div class="card-body">
                                        <form method="post">
										    <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="usuario_id"><strong>Usuario CEDULA o RUC</strong></label><input class="form-control" type="text" placeholder="CEDULA / RUC" name="cedula"></div>		
														<label class="radio-inline"><input type="radio" name="user" value="1">Force Reset Password</label><br/>
														<label class="radio-inline"><input type="radio" name="user" value="2">Enable User</label>&nbsp;&nbsp;		
														<label class="radio-inline"><input type="radio" name="user" value="3">Disable User</label><br/>
														<label class="radio-inline"><input type="radio" name="user" value="0" checked>Nothing</label>
                                                </div>												
                                            </div>
                                            
                                            <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Save Settings</button></div>
											<a class="text-info" href="usuarios_crear.php">Click para crear un usuario</a>
                                        </form>
                                    </div>
								</div>
									
								<div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 font-weight-bold">Lista de Usuarios</p>
                                    </div>
                                    <div class="card-body">
                                       <table id="users" class="table-responsive table responsive table-bordered w-auto">
											<thead>
											<tr>
												<th>CEDULA</th>
												<th>NAME</th>
												<th>EMAIL</th>
												<th>PASSWORD</th>
												<th>TELEFONO</th>
												<th>2FA</th>
												<th>CREATION_DATE</th>
												<th>LAST_LOGIN</th>
												<th>IS_ENABLED</th>
												<th>PASSCHANGE_DATE</th>
												<th>OLD_PASSWORD</th>
												<th>RESET_TOKEN</th>
											</tr>
											</thead>
											<tbody>
											 <?php
											$totalRow = 0;
											$ctr = 0;
											while($row = $statement->fetch(PDO::FETCH_ASSOC))
											{
												$db_cedula = $row['CEDULA'];
												$db_name = $row['NAME'];
												$db_email = $row['EMAIL'];
												$db_password = $row['PASSWORD'];
												$db_telefono = $row['TELEFONO'];
												$db_2fa = $row['2FA'];
												$db_creation_date = $row['CREATION_DATE'];
												$db_last_login = $row['LAST_LOGIN'];
												$db_is_enabled = $row['IS_ENABLED'];
												$db_passchange_date = $row['PASSCHANGE_DATE'];
												$db_old_password = $row['OLD_PASSWORD'];
												$db_reset_token = $row['RESET_TOKEN'];
												
												$db_password_t = "";
												$db_old_password_t = "";
												$db_reset_token_t = "";
												if (strlen($db_password) > 8) {$db_password_t = "Yes";} else {$db_password_t = "Empty";}
												if (strlen($db_old_password) > 8) {$db_old_password_t = "Yes";} else {$db_old_password_t = "Empty";}
												if (strlen($db_reset_token) > 8) {$db_reset_token_t = "Yes";} else {$db_reset_token_t = "Empty";}
												
												echo "<tr>";
												echo "<td>$db_cedula</td>";
												echo "<td>$db_name</td>";
												echo "<td>$db_email</td>";
												echo "<td>$db_password_t</td>";
												echo "<td>$db_telefono</td>";
												echo "<td>$db_2fa</td>";
												echo "<td>$db_creation_date</td>";
												echo "<td>$db_last_login</td>";
												echo "<td>$db_is_enabled</td>";
												echo "<td>$db_passchange_date</td>";
												echo "<td>$db_old_password_t</td>";
												echo "<td>$db_reset_token_t</td>";
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
<?php require "footer_tables.php";?>