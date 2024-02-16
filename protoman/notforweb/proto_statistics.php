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
$statement = $pdo->prepare('SELECT * FROM web_search');

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
    <th>DATE</th>
    <th>SEARCH</th>
    <th>CEDULA</th>
    <th>Tipo</th>
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
</body>
</html>