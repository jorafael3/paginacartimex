<?php
require('dbcore.php'); //Call database connection module

$password = 'sakura76xX';
$hash = password_hash($password, PASSWORD_ARGON2I); // actual operation

$in_config = "ADMIN";
$in_val1 = "web@cartimex.com";
$in_val2 = "$hash";
$in_val3 = "";

//Establishes the connection
$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

//Select Query
$statement = $pdo->prepare('INSERT INTO web_config (CONFIG, VALUE, VALUE2, VALUE3) OUTPUT INSERTED.* VALUES (:config, :value1, :value2, :value3)');
	 $statement->bindParam(':config',$in_config,PDO::PARAM_STR);
     $statement->bindParam(':value1',$in_val1,PDO::PARAM_STR);
	 $statement->bindParam(':value2',$in_val2,PDO::PARAM_STR);
	 $statement->bindParam(':value3',$in_val3,PDO::PARAM_STR);
	 

	 //Executes the query
	 $statement->execute(); // execute it
	 
	 $result = $statement->fetchAll(); // fetch the result (in Array)
	 var_dump($result); // show the result "RAW"
	 
	 FormatErrors ($pdo->errorInfo());
		  
function FormatErrors($error)
    {
         /* Display error. */
         echo "Error information: <br/>";
     
         echo "SQLSTATE: ".$error[0]."<br/>";
         echo "Code: ".$error[1]."<br/>";
         echo "Message: ".$error[2]."<br/>";
    }
?>