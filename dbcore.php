<?php
# Readme: Database Connect 1.3 by @RomelSan (November 22 2019)
# Usage: 
//       require('dbcore.php');

$sql_serverName = "tcp:10.5.1.3,1433";
$sql_database = "CARTIMEX";
$sql_user = "jairo";
$sql_pwd = "qwertys3gur0";

// $sql_serverName = "tcp:10.5.1.3,1433";
// $sql_database = "CARTIMEX";
// $sql_user = "userweb";
// $sql_pwd = "CA043714240";

try
{
	$pdo_test = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
}

catch (PDOException $e)
{
	/* If there is an error an exception is thrown */
	// $pdo_exp = $e;
	echo "
	<script>
	console.log(\"No se puede conectar a la base de datos\");
	</script>
	";
	die("El sitio no se encuentra disponible por el momento, disculpe las molestias.");
}
$pdo_test = null;
