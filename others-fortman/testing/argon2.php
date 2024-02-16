<?php
/**
 * Password Argon2 Hash Benchmark (argon2_benchmark.php)
 * Source Link: https://gist.github.com/Indigo744/e92356282eb808b94d08d9cc6e37884c
 * Argon2 is available since PHP 7.2 
 *
 * Just upload this script to your server and run it, either through CLI or by calling it in your browser.
 *
 * See Argon2 specs https://password-hashing.net/argon2-specs.pdf chapter 9 Recommended Parameters
 */
// In production the total time should be 500ms and up to 1000ms for interactive websites. Desktop apps minimum 4000ms (4 seconds) and up. 

// Upper time limit to check for each thread value (in milliseconds) (Default test here is 2500)
$upperTimeLimit = 2500; // We're going to run until the time to generate the hash takes longer than this.

$threads = [1, 2, 4]; // You should double your current core. Ex: if you have 4 cores then you should put 8.

$time_cost_min = 1; // Iterations / rounds. The minimum for this in production should be at least 3
$time_cost_max = 8;

$memory_cost_min = 1 << 10; // 1 MB = (2^10 result in KB)
$memory_cost_max = 1 << 18; // 256 MB = (2^18 result in KB)

$password = 'this_is_just_a_long_string_to_test_on_U8WNZqmz8ZVBNiNTQR8r';

if (php_sapi_name() !== 'cli' ) echo "<pre>";
echo "\nPassword ARGON2 Benchmark";
echo "\nWill run until the upper limit of {$upperTimeLimit}ms is reached for each thread value";
echo "\n\nTimes are expressed in milliseconds.";

$start = microtime(true);
$hash = password_hash($password, PASSWORD_ARGON2I);
$time = round((microtime(true) - $start) * 1000);
echo "\n\n\nTime with default settings: {$time}ms";
echo "\nHash = $hash";
echo "\n"; 
var_dump(password_get_info($hash));

foreach($threads as $thread) {
    echo "\n\n\n=Testing with $thread threads";
    echo "\n m_cost (MB) ";
    for ($m_cost = $memory_cost_min; $m_cost <= $memory_cost_max; $m_cost *= 2) {
        $m_cost_mb = $m_cost / 1024;
        echo '|' . str_pad($m_cost_mb, 5, ' ', STR_PAD_BOTH);
    }
    echo "\n             =====================================================";
    for ($time_cost = $time_cost_min; $time_cost <= $time_cost_max; $time_cost++) {
        echo "\n t_cost=$time_cost    ";
        for ($m_cost = $memory_cost_min; $m_cost <= $memory_cost_max; $m_cost *= 2) {
            
            $start = microtime(true);
            password_hash($password, PASSWORD_ARGON2I, [
                'memory_cost' => $m_cost,
                'time_cost'   => $time_cost,
                'threads'     => $thread,
            ]);
            $time = round((microtime(true) - $start) * 1000);
            
            if ($time < $upperTimeLimit) {
                echo '|' . str_pad($time, 5, ' ', STR_PAD_BOTH);
            } else {
                echo '|' . str_pad(">LIM", 5, ' ', STR_PAD_BOTH);
                $m_cost = $memory_cost_max;
                $time_cost = $time_cost_max;
            }
            
        }
    }
}
echo "\n\n";

if (php_sapi_name() !== 'cli' ) echo "</pre>";
