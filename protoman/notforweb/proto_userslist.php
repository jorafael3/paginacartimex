<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
}
</style>
</head>
<body>
<?php
require('dbcore.php'); //Call database connection module

//Establishes the connection
$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

//Select Query
$statement = $pdo->prepare('SELECT * FROM web_loginpag');

	 //Executes the query
	 $statement->execute(); // execute it
	 
	 //$result = $statement->fetchAll(); // fetch the result (in Array)
	 //var_dump($result); // show the result "RAW"
	 
	 //FormatErrors ($pdo->errorInfo());
		  
function FormatErrors($error)
    {
         /* Display error. */
         echo "Error information: <br/>";
     
         echo "SQLSTATE: ".$error[0]."<br/>";
         echo "Code: ".$error[1]."<br/>";
         echo "Message: ".$error[2]."<br/>";
    }
?>
<table style="width:90%">
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
 <?php
		$totalRow = 0;
		$ctr = 0;
    	 while($row = $statement->fetch(PDO::FETCH_ASSOC))
         {
            //var_dump($row);
			if($ctr>20000)
				break; 
			$ctr++;
			
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
            echo "<tr>";
			echo "<td>$db_cedula</td>";
			echo "<td>$db_name</td>";
			echo "<td>$db_email</td>";
			echo "<td>$db_password</td>";
			echo "<td>$db_telefono</td>";
			echo "<td>$db_2fa</td>";
			echo "<td>$db_creation_date</td>";
			echo "<td>$db_last_login</td>";
			echo "<td>$db_is_enabled</td>";
			echo "<td>$db_passchange_date</td>";
			echo "<td>$db_old_password</td>";
			echo "<td>$db_reset_token</td>";
            echo "</tr>";
			$totalRow++;
         }
		 $statement = NULL;
		 echo "</table>";
		 echo "<BR>";
		 echo "Total: " . $totalRow;
?>
</body>
</html>