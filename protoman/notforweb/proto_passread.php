<?php
require('dbcore.php'); //Call database connection module

$in_config = "ADMIN";
$in_val1 = "web@cartimex.com";
$in_val2 = "";
$in_val3 = "";

//Establishes the connection
$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

//Select Query
$statement = $pdo->prepare('SELECT * FROM web_config WHERE CONFIG=:config');
	 $statement->bindParam(':config',$in_config,PDO::PARAM_STR);

	 //Executes the query
	 $statement->execute(); // execute it
	 
	 //$result = $statement->fetchAll(); // fetch the result (in Array)
	 //var_dump($result); // show the result "RAW"
	 
	 FormatErrors ($pdo->errorInfo());
		  
function FormatErrors($error)
    {
         /* Display error. */
         echo "Error information: <br/>";
     
         echo "SQLSTATE: ".$error[0]."<br/>";
         echo "Code: ".$error[1]."<br/>";
         echo "Message: ".$error[2]."<br/>";
    }

$hash = "";

while($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo "Config: " . $row['CONFIG'] . "<BR>";
		echo "Value: " . $row['VALUE'] . "<BR>";
		echo "Value2: " . $row['VALUE2'] . "<BR>";
		echo "Value3: " . $row['VALUE3'] . "<BR>";		
		$hash = $row['VALUE2'];
	}

echo "<br><br>";
$user_password = "sakura76xX";
$stored_hash = $hash;
if(password_verify($user_password, $stored_hash)) {
    // password validated
echo "Password is OK 100%";
}
else {echo "Password is not OK";}

?>