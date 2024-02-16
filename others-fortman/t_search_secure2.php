<!DOCTYPE html>
<html>
<body>
<?php
// WEB_BUSQUEDA_PRODUCTO @NOMBRE, @CLASE
// Donde @CLASE = 01, 02, 03

	require('dbcore.php'); //Call database connection module
	require('injection/injections.php'); //Anti Hacking Module

// GET User Input as variables
	$class="01";
	
	if (isset($_GET["product"])) 
	{
		$userInput = $_GET["product"]; // Get user input via form
	}
	else {$userInput = "Computador";}

	$search1 = sanitize($userInput); // Filter the user input
	$search = str_replace("%20", " ", $search1);		// Replaces "%20" for "blank spaces"
	
		// If user input is less than 2 chars... DIE
	if (strlen($search) < 2)
		{
			die("Insert 2 chars or more.");
		}

    //Establishes the connection
	$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
	
    //Select Query
	$statement = $pdo->prepare('WEB_BUSQUEDA_PRODUCTO @NOMBRE=:name, @CLASE=:class');
	 $statement->bindParam(':name',$search,PDO::PARAM_STR);
     $statement->bindParam(':class',$class,PDO::PARAM_STR);
	 
	 //Executes the query
	 $statement->execute(); // execute it
	 $rowcount = $statement->rowCount();
	 
	 $result = $statement->fetchAll(); // fetch the result (in Array)
	 // var_dump($result); // show the result "RAW"
	 
	 //Error handling
	 FormatErrors ($pdo->errorInfo());
	 
	 $productCount = 0;
	 $ctr = 0;
?> 



<h1> Results for <?php echo $search; ?> are : </h1>
<table style="width:90%">
<tr>
    <th>ID</th>
    <th>Código</th>
    <th>Nombre</th>
    <th>Precio</th>
    <th>Stock</th>
    <th>Descripción</th>
</tr>
 <?php	
    	 //while($row = $statement->fetch(PDO::FETCH_ASSOC))
		foreach ($result as $row) 
         {
            //var_dump($row);
			if($ctr>100)
				break; 
			$ctr++;
			
			if ($rowcount = 0) { echo "No hay resultados"; break; } 
			
			$P_ID = $row['id'];
            $Codigo = $row['Código'];
            $Nombre = $row['Nombre'];
            $Precio = $row['PRECIO'];
            $Stock = $row['STOCK'];
            $Descripcion = $row['Descripción'];
            echo "<tr>";
			echo "<td>$P_ID</td>";
            echo "<td>$Codigo</td>";
            echo "<td>$Nombre</td>";
            echo "<td>$Precio</td>";
            echo "<td>$Stock</td>";
            echo "<td>$Descripcion</td>";
            echo "</tr>";
			$productCount++;
         }
		 $statement = NULL;

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
<br>
<?php echo "Total Productos: $productCount";?>
</body>
</html>