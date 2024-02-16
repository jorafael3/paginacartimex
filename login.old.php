<!DOCTYPE html>
<html>
<?php
// Starting Session
function safeSession() {
    if (isset($_COOKIE[session_name()]) AND preg_match('/^[-,a-zA-Z0-9]{1,128}$/', $_COOKIE[session_name()])) {
        session_start();
    } elseif (isset($_COOKIE[session_name()])) {
        unset($_COOKIE[session_name()]);
        session_start(); 
    } else {
        session_start(); 
    }
}
safeSession();
session_regenerate_id(true); 
?>
<?php require 'head.php';?>

<?php
require('dbcore.php'); //Call database connection module
$_SESSION['loggedin'] = false; //true, false
$_SESSION['login_id'] = ""; //cedula o ruc
$_SESSION['login_email'] = "";
$_SESSION['login_nombre'] = "";
$_SESSION['login_clase'] = "3";
if (empty($_SESSION['error'])) { $_SESSION['error'] = 'Por favor ingrese sus credenciales.<br>Si ya es cliente de Cartimex y no tiene contraseña entonces ingrese su RUC.'; }

$input_id="";
$input_password="";
$clean_id="";
$clean_password="";

function getClase($login_cedula) 
{
	require('dbcore.php'); //Call database connection module
	$pdo2 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
	$statement2 = $pdo2->prepare("WEB_LOGIN @CEDULA=:cedula");
	$statement2->bindParam(':cedula',$login_cedula,PDO::PARAM_STR);
	$statement2->execute();
	$user_clase = "";
	while($row2 = $statement2->fetch(PDO::FETCH_ASSOC))
	{
		$user_clase = $row2['Clase'];
	}
	return $user_clase;
}

function logDate($login_cedula)
{
	require('dbcore.php'); //Call database connection module
	$pdo3 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
	$statement3 = $pdo3->prepare("UPDATE web_loginpag SET LAST_LOGIN=GETDATE() WHERE CEDULA=:cedula");
	$statement3->bindParam(':cedula',$login_cedula,PDO::PARAM_STR);
	$statement3->execute();
}

if (isset($_POST["ID"]) && isset($_POST["Password"])) 
	{
		// Define $username and $password
		$input_id=$_POST['ID'];
		$input_password=$_POST['Password'];
		$clean_id = filter_var($input_id, FILTER_SANITIZE_NUMBER_INT);
		$clean_password = filter_var($input_password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		//Establishes the connection
		$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
		
		//Select Query
		$statement = $pdo->prepare("SELECT * FROM web_loginpag WHERE CEDULA=:idcedula");
		$statement->bindParam(':idcedula',$clean_id,PDO::PARAM_STR);
	 
		//Executes the query
		$statement->execute(); // execute it
		//$rowcount = $statement->rowCount();
		/*
			You should either "SELECT count(*) ..." or use fetchAll() .
			The only way that rowCount() will work, for pretty much all databases
		*/
		
		while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{		
				if (empty($row['CEDULA'])) 
				{
					$_SESSION['error'] = "El Usuario no Existe.";
				}
				else 
				{
					if ($row['PASSWORD'] == "") {$_SESSION['error'] = "<B><a href='reset.php' class='text-danger'>Debe resetear su contraseña - Click Aquí.</a></B>";break;}	
					if ($row['IS_ENABLED'] != "Y") {$_SESSION['error'] = "<B><a href='direccion.php' class='text-danger'>El usuario se encuentra desactivado.<br/>Por favor contactar a la empresa.</a></B>";break;}
					$user_password = $clean_password;
					$stored_hash = $row['PASSWORD'];
					if(password_verify($user_password, $stored_hash)) 
						{
							// password validated
							$_SESSION['login_id'] = $row['CEDULA'];
							$_SESSION['login_nombre'] = $row['NAME'];
							$_SESSION['login_email'] = $row['EMAIL'];
							$_SESSION['loggedin'] = true; //true, false
							$_SESSION['login_clase'] = getClase($row['CEDULA']); // obtener la clase del dobra
							logDate($row['CEDULA']); // ingresar fecha de ingreso a la base de datos
							echo '<script>window.location.replace("index.php")</script>';break;
						}
					else 
						{
							// Password is incorrect
							$_SESSION['error'] = 'Contraseña incorrecta...';
							//echo '<script>window.location.replace("login.php")</script>';break;
						}
				}					
			}			
	}

?>

    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">LOGIN</h2>
                    <p><?php echo $_SESSION['error'];$_SESSION['error']='';?></p>
                </div>
                <form target="_self" action="login.php" method="post">
                    <div class="form-group"><label for="number">Identificación (RUC o Cédula)</label><input class="form-control item" type="text" id="ID" name="ID"></div>
                    <div class="form-group"><label for="password">Contraseña</label><input class="form-control" type="password" id="password" name="Password"></div>
					<span class="input-group-btn">
							<button class="btn btn-default reveal" type="button" onclick="myFunction()"><i class="fa fa-eye" aria-hidden="true"></i></button>
					</span>          
					<button class="btn btn-primary btn-block" type="submit">Ingresar</button>
					<br>
					<div class="form-group text-center"><a href="reset.php">Olvidó su contraseña</a></div>
					<div class="form-group text-center"><a href="registro.php">Regístrate como distribuidor</a></div>
				</form>
            </div>
        </section>
    </main>
	
<script>
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
} 
</script>
<?php require 'footer.php';?>
