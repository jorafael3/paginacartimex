<!DOCTYPE html>
<html>
<body>
<?php
// WEB_BUSQUEDA_PRODUCTO @NOMBRE, @CLASE
// @CLASE = 01, 02, 03
    // SQL Server Variables
    $serverName = "tcp:10.5.1.3,1433";
	$database = "CARTIMEX";
	$uid = "userweb";
	$pwd = "CA043714240";

    //Establishes the connection
    $conn = new PDO( "sqlsrv:server=$serverName ; Database = $database", $uid, $pwd);

    //Select Query
	 $tsql = "WEB_BUSQUEDA_PRODUCTO @NOMBRE='Laptop', @CLASE=01";
	 
	 //Executes the query
	 $getResult = $conn->query( $tsql );
	 
	 //Error handling
	 FormatErrors ($conn->errorInfo());
	 
	 $productCount = 0;
	 $ctr = 0;
?> 
     
<h1> Results are : </h1>

 <?php
    	 while($row = $getResult->fetch(PDO::FETCH_ASSOC))
         {
            var_dump($row);    
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
</body>
</html>