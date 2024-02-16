<!DOCTYPE html>
<html>
<?php require 'head.php';?>

<?php
$input_token="";
$input_password="";
$clean_token="";
$clean_password="";
$token_exist = false; // Variable para marcar si el token existe o no...
?>

<?php
function savePassword($user_token, $user_newPassword) //INPUT token y password -- guarda en la base de datos el nuevo password
	{
		// Changes password in database
		require('dbcore.php'); //Call database connection module
		$pdo2 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd); //Establishes the connection		
		$statement2 = $pdo2->prepare("UPDATE web_loginpag SET PASSWORD=:password WHERE RESET_TOKEN=:token");
		$statement2->bindParam(':password',$user_newPassword,PDO::PARAM_STR);
		$statement2->bindParam(':token',$user_token,PDO::PARAM_STR);
		$statement2->execute();
		
		// Enter Password change Date in database
		$statement4 = $pdo2->prepare("UPDATE web_loginpag SET PASSCHANGE_DATE=GETDATE() WHERE RESET_TOKEN=:token");
		$statement4->bindParam(':token',$user_token,PDO::PARAM_STR);
		$statement4->execute();
		
		// reset token in database
		$statement3 = $pdo2->prepare("UPDATE web_loginpag SET RESET_TOKEN='' WHERE RESET_TOKEN=:token");
		$statement3->bindParam(':token',$user_token,PDO::PARAM_STR);
		$statement3->execute();
	}
?>

<?php
if (strlen($_POST["Password"]) < 8) {echo '<script>window.location.replace("reset2.php")</script>';exit;}
if (strlen($_POST["Password"]) > 64) {echo '<script>window.location.replace("reset2.php")</script>';exit;}

if (isset($_POST["TOKEN"]) && isset($_POST["Password"])) 
	{
		$input_token=$_POST['TOKEN'];
		$clean_token=filter_var($input_token, FILTER_SANITIZE_STRING);
		$input_password=$_POST['Password'];
		$clean_password = filter_var($input_password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		require('dbcore.php'); //Call database connection module		
		$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd); //Establishes the connection
		
		//Select Query
		$statement = $pdo->prepare("SELECT * FROM web_loginpag WHERE RESET_TOKEN=:token");
		$statement->bindParam(':token',$clean_token,PDO::PARAM_STR);
	 
		//Executes the query
		$statement->execute(); // execute it
		//$rowcount = $statement->rowCount();
		/*
			You should either "SELECT count(*) ..." or use fetchAll() .
			The only way that rowCount() will work, for pretty much all databases
		*/
		
		$token_exist = false; // Variable para marcar si el token existe o no...
		while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{		
				if (empty($row['RESET_TOKEN'])) 
				{
					die("El Token no Existe.");
				}
				else 
				{
					$token_exist = true;
					$user_token = $row['RESET_TOKEN'];
					$user_cedula = $row['CEDULA'];
					$new_password = password_hash($clean_password, PASSWORD_ARGON2I); // Hash Password
					savePassword($user_token, $new_password);
				}					
			}
		if ($token_exist == false) {echo '<script>window.location.replace("reset2.php")</script>';}
	}

?>

    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info"><?php if ($token_exist == true) {echo 'La Contraseña se ha cambiado.';} else {echo 'El Token es incorrecto.';}?></h2>
                    <p><a href="login.php">Click para iniciar sesión...</a></p>
                </div>           
            </div>
        </section>
    </main>
 
<?php require 'footer.php';?>
