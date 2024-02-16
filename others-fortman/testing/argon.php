<?php
// USE PASSWORD_ARGON2I for PHP 7.2
// USE PASSWORD_ARGON2ID for PHP 7.3
// First Test
echo "<B>Testing default values</B><br>";
$password = 'test';
$start = microtime(true);
$hash = password_hash($password, PASSWORD_ARGON2I); // actual operation
$time = round((microtime(true) - $start) * 1000);
var_dump($hash);
echo "<br>";
echo "Time with default settings: " . $time . "ms";
echo "<br>";
var_dump(password_get_info($hash));

// Second Test
echo "<br><br>";
echo "<B>Testing 128 MB, Cost 3, Threads 2</B><br>";
$password = 'test';
$options = [
    'memory_cost' => 1<<17, // 128 Mb = 2 square 17 = 1024 * 128
    'time_cost'   => 3,
    'threads'     => 2,
];
$start = microtime(true);
$hash = password_hash($password, PASSWORD_ARGON2I, $options); // actual operation
$time = round((microtime(true) - $start) * 1000);
var_dump($hash);
echo "<br>";
echo "Time with default settings: " . $time . "ms";
echo "<br>";
var_dump(password_get_info($hash));
?>

<?php
// Verify Password
echo "<br><br>";
echo "<B>Testing password verification</B><br>";
//Works for both bcrypt and Argon2
$user_password = "test";
$stored_hash = $hash;
if(password_verify($user_password, $stored_hash)) {
    // password validated
echo "Password is OK 100%";
}
else {echo "Password is not OK";}
?>