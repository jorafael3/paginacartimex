<!DOCTYPE html>
<html>
<?php require 'head.php';?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$input_id="";
$input_password="";
$clean_id="";
$clean_password="";
$user_email = "";
?>

<?php
function sendToken($login_email) {
		$mail = new PHPMailer;
		$mail->CharSet = "UTF-8";
		$mail->Encoding = 'quoted-printable';
		$mail->isSMTP();
		$mail->SMTPDebug = SMTP::DEBUG_OFF; // 2;
		
		$mail->Host = 'mail.cartimex.com';
		$mail->Port = 465; //465 // 25 //587
		
		//Set the encryption mechanism to use - STARTTLS or SMTPS
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		
		$mail->SMTPOptions = array(
			'ssl' => [
				'verify_peer' => false,
				'verify_peer_name' => true,
				'peer_name' => 'mail.cartimex.com',
				'allow_self_signed' => true,
			],
		);
		
		$mail->SMTPAuth = true;
		
		$mail->Username = 'web';
		$mail->Password = 'misato19X';
		
		$mail->setFrom('web@cartimex.com', 'CARTIMEX'); // From
		$mail->addAddress($login_email, 'Usuario'); // To
		
		// Generate Token
		$token_seed = rand(1000,1000000); //de mil a 1 millon
		$token_generator = $login_email . $token_seed;
		$token_hash = hash('sha256', $token_generator);
		
		// Send Token
		$mail->Subject = 'Token para Resetear la Contraseña';
		$mail->Body    = "Su token es: $token_hash";
		$mail->send();
		
		//send the message, check for errors LOG MODE
		/*
		if (!$mail->send()) {
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message sent!';
		}
		*/
		return $token_hash;
}
function saveToken($user_id, $user_token) //INPUT cedula y hash -- guarda en la base de datos el hash en el campo RESET_TOKEN
	{
		require('dbcore.php'); //Call database connection module
		$pdo2 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd); //Establishes the connection
		$statement2 = $pdo2->prepare("UPDATE web_loginpag SET RESET_TOKEN=:token WHERE CEDULA=:idcedula");
		$statement2->bindParam(':idcedula',$user_id,PDO::PARAM_STR);
		$statement2->bindParam(':token',$user_token,PDO::PARAM_STR);
		$statement2->execute();
	}
?>

<?php
if (isset($_POST["ID"]))
	{
		$input_id=$_POST['ID'];
		$clean_id = filter_var($input_id, FILTER_SANITIZE_NUMBER_INT);
		
		require('dbcore.php'); //Call database connection module		
		$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd); //Establishes the connection
		
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
		
		$cedula_exist = false; // Variable para marcar si el usuario existe o no...
		while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{		
				if (empty($row['CEDULA'])) 
				{
					die("El Usuario no Existe.");
				}
				else 
				{
					$cedula_exist = true;
					$user_email = $row['EMAIL'];
					$generated_token = sendToken($user_email);
					saveToken($row['CEDULA'], $generated_token);
				}					
			}
		if ($cedula_exist == false) {echo '<script>window.location.replace("reset.php")</script>';}
	}

?>

    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Cambiar Contraseña</h2>
                    <p class="text-success"><b>Ingrese los datos que se han enviado a su correo: <?php echo $user_email;?></b></p>
                </div>
                <form target="_self" action="reset3.php" method="post">
                    <div class="form-group"><label for="text">Copie su Token Aquí</label><input class="form-control item" type="text" id="TOKEN" name="TOKEN"></div>
                    <div class="form-group"><label for="text">Escriba su Nueva Contraseña</label>
						<input class="form-control" type="password" id="password" name="Password">
						<span class="input-group-btn">
							<button class="btn btn-default reveal" type="button" onclick="myFunction()"><i class="fa fa-eye" aria-hidden="true"></i></button>
						</span>          
					</div>
					<button class="btn btn-primary btn-block" type="submit">Proceder</button>
					* La contraseña debe tener mínimo 8 caracteres.
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
