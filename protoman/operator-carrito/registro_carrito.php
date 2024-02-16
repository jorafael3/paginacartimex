<!DOCTYPE html>
<html>

<?php
session_name("carrito");
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

if (isset($_POST["user"]) && isset($_POST["Orden"])) 
	{
		// Sanitize user input
		$clean_c = filter_var($_POST["Orden"], FILTER_SANITIZE_NUMBER_INT);
		$clean_s = filter_var($_POST["user"], FILTER_SANITIZE_NUMBER_INT);
		if ($clean_s == "1")
			{
				// Set Status Ingresado
				$statement_global = $pdo->prepare("UPDATE web_regCarrito SET Estado='Ingresado' WHERE ORDEN=:Orden");
				$statement_global->bindParam(':Orden',$clean_c,PDO::PARAM_STR);
				$statement_global->execute();
				
				$statement_global2 = $pdo->prepare("UPDATE web_regCarrito SET Fecha_Estado=GETDATE() WHERE ORDEN=:Orden");
				$statement_global2->bindParam(':Orden',$clean_c,PDO::PARAM_STR);
				$statement_global2->execute();
			}
	
		if ($clean_s == "2")
			{
				// Set Status Rechazado
				$statement_global = $pdo->prepare("UPDATE web_regCarrito SET Estado='Rechazado' WHERE ORDEN=:Orden");
				$statement_global->bindParam(':Orden',$clean_c,PDO::PARAM_STR);
				$statement_global->execute();
				
				$statement_global2 = $pdo->prepare("UPDATE web_regCarrito SET Fecha_Estado=GETDATE() WHERE ORDEN=:Orden");
				$statement_global2->bindParam(':Orden',$clean_c,PDO::PARAM_STR);
				$statement_global2->execute();
			}
			
		if ($clean_s == "3")
			{
				// Set Status En Proceso
				$statement_global = $pdo->prepare("UPDATE web_regCarrito SET Estado='En Proceso' WHERE ORDEN=:Orden");
				$statement_global->bindParam(':Orden',$clean_c,PDO::PARAM_STR);
				$statement_global->execute();
				
				$statement_global2 = $pdo->prepare("UPDATE web_regCarrito SET Fecha_Estado=GETDATE() WHERE ORDEN=:Orden");
				$statement_global2->bindParam(':Orden',$clean_c,PDO::PARAM_STR);
				$statement_global2->execute();
			}
	}

// READ USERS LIST
$statement = $pdo->prepare('SELECT * FROM web_regCarrito');
$statement->execute();
?>
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Registros de Pedidos Online</h3></div>
                        
						<div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 font-weight-bold">Control de Pedidos</p>
                                    </div>
									
									<div class="card-body">
                                        <form method="post">
										    <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="orden_id"><strong>Orden</strong></label><input class="form-control" type="text" placeholder="Orden" name="Orden"></div>		
														<label class="radio-inline"><input type="radio" name="user" value="1">Ingresado</label>&nbsp;&nbsp;
														<label class="radio-inline"><input type="radio" name="user" value="2">Rechazado</label>&nbsp;&nbsp;
														<label class="radio-inline"><input type="radio" name="user" value="3">En Proceso</label><br/>
														<label class="radio-inline"><input type="radio" name="user" value="0" checked>Sin cambios</label>
                                                </div>												
                                            </div>
                                            
                                            <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Save Settings</button></div>
                                        </form>
                                    </div>
								</div>
									
								<div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 font-weight-bold">Lista de Ordenes</p>
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
												<th>ORDEN</th>
												<th>NOMBRE</th>
												<th>RUC</th>
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
												$db_Orden = $row['ORDEN'];
												$db_nombre = $row['Nombre'];
												$db_ruc = $row['RUC'];
												$db_fecha_creacion = $row['Fecha_Create'];
												$db_fecha_estado = $row['Fecha_Estado'];
												
												echo "<tr>";
												echo "<td>$db_estado</td>";
												echo "<td>$db_Orden</td>";
												echo "<td>$db_nombre</td>";
												echo "<td>$db_ruc</td>";
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