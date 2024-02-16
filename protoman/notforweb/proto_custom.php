<?php
require('dbcore.php'); //Call database connection module

//Establishes the connection
$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);


// UPDATE web_loginpag SET PASSWORD=''
// INSERT INTO web_loginpag (CEDULA,NAME,EMAIL,CREATION_DATE,LAST_LOGIN,IS_ENABLED) OUTPUT INSERTED.* VALUES ('0915798292001','VERA CADENA ROMEL ANDRE','romel.vera.cadena@gmail.com',GETDATE(),GETDATE(),'Y')
// SELECT * FROM web_loginpag WHERE CEDULA = '0915798292001'

// Global Configs
// SELECT * FROM web_config
// INSERT INTO web_config (CONFIG, VALUE) OUTPUT INSERTED.* VALUES ('show_stock','false')
// INSERT INTO web_config (CONFIG, VALUE) OUTPUT INSERTED.* VALUES ('show_price','false')
// INSERT INTO web_config (CONFIG, VALUE) OUTPUT INSERTED.* VALUES ('enable_carrito','false')

// 4 BANNERS
// INSERT INTO web_config (CONFIG, VALUE) VALUES ('banner_size','auto')
// INSERT INTO web_config (CONFIG, VALUE, VALUE2) OUTPUT INSERTED.* VALUES ('banner1','true','http://www2.cartimex.com/images/banners/ban1/banner1.jpg')
// INSERT INTO web_config (CONFIG, VALUE, VALUE2) OUTPUT INSERTED.* VALUES ('banner2','true','http://www2.cartimex.com/images/banners/ban1/banner2.jpg')
// INSERT INTO web_config (CONFIG, VALUE, VALUE2) OUTPUT INSERTED.* VALUES ('banner3','true','http://www2.cartimex.com/images/banners/ban1/banner3.jpg')
// INSERT INTO web_config (CONFIG, VALUE, VALUE2) OUTPUT INSERTED.* VALUES ('banner4','true','http://www2.cartimex.com/images/banners/ban1/banner4.jpg')

// 9 Productos destacados
// INSERT INTO web_config (CONFIG, VALUE) OUTPUT INSERTED.* VALUES ('product1','0000029692')

// DELETE FROM web_loginpag WHERE NAME='Romel 2'

// SELECT * FROM web_regDistribuidor

// Select Query
$statement = $pdo->prepare("SELECT * FROM web_config");

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