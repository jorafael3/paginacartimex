<!DOCTYPE html>
<html>
<?php
// Starting Session
function safeSession()
{
	if (isset($_COOKIE[session_name()]) and preg_match('/^[-,a-zA-Z0-9]{1,128}$/', $_COOKIE[session_name()])) {
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
<?php require 'head.php'; ?>

<?php
require('dbcore.php'); //Call database connection module
$_SESSION['loggedin'] = false; //true, false
$_SESSION['login_id'] = ""; //cedula o ruc
$_SESSION['login_email'] = "";
$_SESSION['login_nombre'] = "";
$_SESSION['login_clase'] = "3";
if (empty($_SESSION['error'])) {
	$_SESSION['error'] = 'Si ya es cliente de Cartimex y no tiene contraseña <B> SOLO </B> escribir Ruc/Cedula y presione <B>INGRESAR</B>';
}

$input_id = "";
$input_password = "";
$clean_id = "";
$clean_password = "";

function logDate($login_cedula)
{
	require('dbcore.php'); //Call database connection module
	$pdo3 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
	$statement3 = $pdo3->prepare("UPDATE web_loginpag SET LAST_LOGIN=GETDATE() WHERE CEDULA=:cedula");
	$statement3->bindParam(':cedula', $login_cedula, PDO::PARAM_STR);
	$statement3->execute();
}

if (isset($_POST["ID"]) && isset($_POST["Password"])) {
	// LOGIN STEP 1 CHECK USER EXIST
	// Define $username and $password
	$input_id = $_POST['ID'];
	$input_password = $_POST['Password'];
	$clean_id = filter_var($input_id, FILTER_SANITIZE_NUMBER_INT);
	$clean_password = filter_var($input_password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	//Establishes the connection
	$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

	//Select Query
	$statement = $pdo->prepare("WEB_LOGIN @CEDULA=:idcedula");
	$statement->bindParam(':idcedula', $clean_id, PDO::PARAM_STR);

	//Executes the query
	$statement->execute(); // execute it		
	//$rowcount = $statement->rowCount();
	/*
			You should either "SELECT count(*) ..." or use fetchAll() .
			The only way that rowCount() will work, for pretty much all databases
		*/
	$login_continue = false;
	$ctr = 0;
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		$ctr++;
		$_SESSION['login_clase'] = $row['Clase'];
		$_SESSION['login_nombre'] = $row['Nombre'];
		$_SESSION['login_email'] = $row['Email'];
		$_SESSION['login_id'] = $row['Ruc'];
		$login_continue = true;
	}
	if ($ctr == 0) {
		$_SESSION['error'] = "El Usuario no Existe.";
		$login_continue = false;
	}

	if ($statement == null) {
		$_SESSION['error'] = "El Usuario no Existe.";
		$login_continue = false;
	}

	if ($login_continue == true) {
		// Login Step 2 check password
		//Establishes the connection
		$pdo2 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

		//Select Query
		$statement2 = $pdo2->prepare("SELECT * FROM web_loginpag WHERE CEDULA=:idcedula");
		$statement2->bindParam(':idcedula', $clean_id, PDO::PARAM_STR);

		//Executes the query
		$statement2->execute(); // execute it

		$ctr2 = 0;
		while ($row = $statement2->fetch(PDO::FETCH_ASSOC)) {
			$ctr2++;
			if ($row['PASSWORD'] == "") {
				$_SESSION['error'] = "<B><a href='reset.php' class='text-danger'>Debe resetear su contraseña - Click Aquí.</a></B>";
				break;
			}
			if ($row['IS_ENABLED'] != "Y") {
				$_SESSION['error'] = "<B><a href='direccion.php' class='text-danger'>El usuario se encuentra desactivado.<br/>Por favor contactar a la empresa.</a></B>";
				break;
			}
			$user_password = $clean_password;
			$stored_hash = $row['PASSWORD'];
			if (password_verify($user_password, $stored_hash)) {
				// password validated
				$_SESSION['loggedin'] = true; //true, false
				logDate($_SESSION['login_id']); // ingresar fecha de ingreso a la base de datos
				echo '<script>window.location.replace("index.php")</script>';
				break;
			} else {
				// Password is incorrect
				$_SESSION['error'] = 'Contraseña incorrecta...';
				//echo '<script>window.location.replace("login.php")</script>';break;
			}
		}
		if ($statement2 == null) {
			$_SESSION['error'] = "<B><a href='direccion.php' class='text-danger'>Debe Actualizar sus datos<br/>Por favor contactar a la empresa o su vendedor asignado.</a></B>";
		}
		if ($ctr2 == 0) {
			$_SESSION['error'] = "<B><a href='direccion.php' class='text-danger'>Debe Actualizar sus datos<br/>Por favor contactar a la empresa o su vendedor asignado.</a></B>";
		}
	}
}

?>

<main class="page login-page">
	<section class="clean-block clean-form dark">
		<div class="container">
			<div class="block-heading">
				<h2 class="text-info">LOGIN</h2>
				<p><?php echo $_SESSION['error'];
					$_SESSION['error'] = ''; ?></p>
			</div>
			<form target="_self" action="login.php" method="post">
				<div class="form-group"><label for="number">Identificación (RUC o Cédula)</label><input class="form-control item" type="text" id="ID" name="ID" required></div>
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
<?php require 'footer.php'; ?>