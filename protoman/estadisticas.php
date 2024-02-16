<!DOCTYPE html>
<html>

<?php
session_name("protoman");
session_start();
// Check if Logged in
if (isset($_SESSION['loggedin'])) {
	if ($_SESSION['loggedin'] == true) {
	} else {
		echo '<script>window.location.replace("login.php")</script>';
		die();
	}
} else {
	echo '<script>window.location.replace("login.php")</script>';
	die();
}
?>

<?php require "head.php"; ?>
<?php
require('dbcore.php');
$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
$statement = $pdo->prepare('SELECT TOP(200) * FROM web_search ORDER BY DATE DESC');
$statement->execute();

?>
<div class="container-fluid">
	<div class="d-sm-flex justify-content-between align-items-center mb-4">
		<h3 class="text-dark mb-0">Búsquedas</h3>
	</div>

	<div class="row">
		<div class="col">
			<div class="card shadow mb-3">
				<div class="card-header py-3">
					<p class="text-primary m-0 font-weight-bold">Últimas 200 Búsquedas</p>
				</div>
				<div class="card-body">
					<table class="table table-responsive">
						<tr>
							<th>Fecha</th>
							<th>Búsqueda</th>
							<th>ID</th>
							<th>Tipo</th>
						</tr>
						<?php
						$totalRow = 0;
						$ctr = 0;
						while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
							//var_dump($row);
							if ($ctr > 20000)
								break;
							$ctr++;

							$db_date = $row['DATE'];
							$db_search = $row['SEARCH'];
							$db_cedula = $row['CEDULA'];
							$db_tipo = $row['tipo'];
							echo "<tr>";
							echo "<td>$db_date</td>";
							echo "<td>$db_search</td>";
							echo "<td>$db_cedula</td>";
							echo "<td>$db_tipo</td>";
							echo "</tr>";
							$totalRow++;
						}
						$statement = NULL;
						echo "</table>";
						echo "<BR>";
						echo "Total: " . $totalRow;
						?>
				</div>
			</div>

		</div>
	</div>

</div>
<?php require "footer.php"; ?>