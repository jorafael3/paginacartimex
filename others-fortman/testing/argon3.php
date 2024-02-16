<?php
/**
 * Password Argon2i Hash Cost Calculator
 *
 * Just upload this script to your server and run it, either through CLI or by calling it in your browser.
 *
 * You should choose a cost that will take at least 100ms 
 */
// Upper time limit to check
$upperTimeLimit = 1000; // in milliseconds
$password = 'this_is_just_a_long_string_to_test_on_U8WNZqmz8ZVBNiNTQR8r';
if (php_sapi_name() !== 'cli' ) echo "<pre>";
echo "\nPassword Argon2i Hash Cost Calculator\n\n";
echo "We're going to run until the time to generate the hash takes longer than {$upperTimeLimit}ms\n";
$cost = 0;
$first_cost_above_100 = null;
$first_cost_above_500 = null;
do {
    $cost++;
    
    echo "\nTesting cost value of $cost: ";
    
    $start = microtime(true);
    password_hash($password, PASSWORD_ARGON2I, array('time_cost' => $cost));
    $time = round((microtime(true) - $start) * 1000);
    
    echo "... took {$time}ms";
    
    if ($first_cost_above_100 === null && $time > 100) {
        $first_cost_above_100 = $cost;
    } else if ($first_cost_above_500 === null && $time > 500) {
        $first_cost_above_500 = $cost;
    }
    
} while ($time < $upperTimeLimit);
echo "\n\n\nYou should use a cost between $first_cost_above_100 and $first_cost_above_500";
if (php_sapi_name() !== 'cli' ) echo "</pre>";