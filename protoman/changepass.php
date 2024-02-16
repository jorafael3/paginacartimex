<?php
// Admin User:	 web@cartimex.com
// OLD PASSWORD: sakura76xX
// OLD HASH: 	 $argon2i$v=19$m=65536,t=4,p=1$dnFZUWg4VWFmVUhZdjBORw$9IeXWbV93N9sVSFppWjOddVIuqnrCK4ILLslQSxZhx0

session_name("protoman");
session_start();
// Check if Logged in
if ( isset($_SESSION['loggedin']) )
	{
		if ($_SESSION['loggedin'] == true){}
		else {echo '<script>window.location.replace("login.php")</script>';die();}
	}
else {echo '<script>window.location.replace("login.php")</script>';die();}
?>

<?php require "head.php";?>

<?php

if (isset($_POST["password"])) 
	{
		if (strlen($_POST["password"])>7)
		{
		$clean_password = filter_var($_POST["password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = $clean_password;
				
		$hash = password_hash($password, PASSWORD_ARGON2I); // Hash Password (Argon2I)

		$in_val1 = "web@cartimex.com"; //admin email
		$in_val2 = "$hash"; // admin password

		require('dbcore.php');
		$pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

		$statement = $pdo->prepare("UPDATE web_config SET VALUE2=:value2 WHERE VALUE=:value1");
		$statement->bindParam(':value1',$in_val1,PDO::PARAM_STR);
		$statement->bindParam(':value2',$in_val2,PDO::PARAM_STR);	 
		$statement->execute(); // execute it
		echo '<script>window.location.replace("logout.php")</script>';
		}
}
?>

            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Cambiar Contraseña</h3></div>
                        
						<div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 font-weight-bold">Ingrese una nueva contraseña de 8 caracteres o más.</p>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-row">
                                                <div class="col">
													<div class="form-group"><label for="text">Nueva Contraseña</label>
														<input class="form-control" type="password" id="password" name="password">
														<span class="input-group-btn">
															<button class="btn btn-default reveal" type="button" onclick="myFunction()"><i class="fa fa-eye" aria-hidden="true"></i></button>
														</span>          
													</div>
                                                </div>
                                            </div>
											
                                            <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Save Settings</button></div>
                                        </form>
                                    </div>
                                </div>
  
                            </div>
                        </div>
						
        </div>

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

<?php require "footer.php";?>