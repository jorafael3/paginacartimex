<!DOCTYPE html>
<html>
<body>
<?php
// WEB_LOGIN @CEDULA, @CLAVE
    // SQL Server Variables
    $serverName = "tcp:10.5.1.3,1433";
	$database = "CARTIMEX";
	$uid = "userweb";
	$pwd = "CA043714240";

    //Establishes the connection
    $conn = new PDO( "sqlsrv:server=$serverName ; Database = $database", $uid, $pwd);

    //Select Query
	 $tsql = "WEB_LOGIN @CEDULA='0915798292001'";
	 
	 //Executes the query
	 $getResult = $conn->query( $tsql );
	 
	 //Error handling
	 FormatErrors ($conn->errorInfo());
	 
	 $productCount = 0;
	 $ctr = 0;
?> 
     
<h1> Results are : </h1>
<table style="width:90%">
<tr>
    <th>ID</th>
    <th>Email</th>
    <th>Clase</th>
    <th>Nombre</th>
    <th>RUC</th>
</tr>
 <?php
    	 while($row = $getResult->fetch(PDO::FETCH_ASSOC))
         {
            //var_dump($row);
            $ID = $row['id'];
            $Email = $row['sri_em1'];
            $Clase = $row['Clase'];
            $Nombre = $row['Nombre'];
            $Ruc = $row['Ruc'];
            echo "<tr>";
            echo "<td>$ID</td>";
            echo "<td>$Email</td>";
            echo "<td>$Clase</td>";
            echo "<td>$Nombre</td>";
            echo "<td>$Ruc</td>";
            echo "</tr>";
         }

	 function FormatErrors( $error )
	 {
	    /* Display error. */
	    echo "Error information: <br/>";
	 
	    echo "SQLSTATE: ".$error[0]."<br/>";
	    echo "Code: ".$error[1]."<br/>";
	    echo "Message: ".$error[2]."<br/>";
	 }
?>
</table>
</body>
</html>