<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h4>Password Test</h4>
You can test the password filtering by using password variable, ex:
<br>
passtest.php?password=myPassword123
<br>
<br>
<?php
	if (isset($_GET["password"])) 
	{
		$userInput = $_GET["password"]; // Get user input via form
	}
	else {$userInput = "test123";}
	// $pass = $userInput;
	$pass = filter_var($userInput, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	
	// Argon2i
	$start = microtime(true);
	$hash = password_hash($pass, PASSWORD_ARGON2I); // actual operation
	$time = round((microtime(true) - $start) * 1000);
?>
<p>
User Password Input: <?php echo $pass;?>
<br>
User Stored Password: <?php var_dump($hash);?>
<br>
Time with default settings: <?php echo $time . "ms";?>
</p>
</body>
</html>
