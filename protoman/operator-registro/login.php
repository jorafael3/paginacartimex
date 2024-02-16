<!DOCTYPE html>
<html>

<?php 
session_name("registro");

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

// Registro user: registro@cartimex.com
$inconfig = "ADMIN-REGISTRO";

if (isset($_POST["username"]) && isset($_POST["password"])) 
{
	$clean_username = filter_var($_POST["username"], FILTER_SANITIZE_EMAIL);
	$clean_password = filter_var($_POST["password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	
	// Get passsword hash from database
	require('dbcore.php');
	$pdo_global = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
	$statement = $pdo_global->prepare('SELECT * FROM web_config WHERE VALUE=:email AND CONFIG=:inconfig');
	$statement->bindParam(':email',$clean_username,PDO::PARAM_STR);
	$statement->bindParam(':inconfig',$inconfig,PDO::PARAM_STR);
	$statement->execute();
	
	$db_hash = "";
	while($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		$db_hash = $row['VALUE2'];
	}
	
	// Password Verification
	$user_password = $clean_password;
	$stored_hash = $db_hash;
	if(password_verify($user_password, $stored_hash)) 
	{
		// If password is OK...		
		$_SESSION['loggedin'] = true; // Set flag loggedin
		echo '<script>window.location.replace("index.php")</script>';	
	}
}

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Cartimex</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
</head>

<body class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex align-items-center align-items-sm-center align-items-md-center align-items-lg-center align-items-xl-center bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="bg-login-image flex-grow-1" style="background-image: url(&quot;../assets/img/KW4.jpg&quot;);"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Administrator</h4>
                                    </div>
                                    <form class="user" action="login.php" method="post">
                                        <div class="form-group"><input class="form-control form-control-user" type="text" id="user" aria-describedby="emailHelp" placeholder="Enter username..." name="username"></div>
                                        <div class="form-group"><input class="form-control form-control-user" type="password" id="InputPassword" placeholder="Password" name="password"></div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <div class="form-check"><input class="form-check-input custom-control-input" type="checkbox" id="formCheck-1"><label class="form-check-label custom-control-label" for="formCheck-1">Recordar</label></div>
                                            </div>
                                        </div><button class="btn btn-primary btn-block text-white btn-user" type="submit">Login</button>
                                        <hr>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/chart.min.js"></script>
    <script src="../assets/js/bs-charts.js"></script>
    <script src="../assets/jquery.easing.js"></script>
    <script src="../assets/js/theme.js"></script>
</body>

</html>