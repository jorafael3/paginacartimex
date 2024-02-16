<!DOCTYPE html>
<html>

<?php
session_name("banner");
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
function get_server_memory_usage(){
// return ram percent
    $free = shell_exec('free');
    $free = (string)trim($free);
    $free_arr = explode("\n", $free);
    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem);
    $mem = array_merge($mem);
    $memory_usage = $mem[2]/$mem[1]*100;

    return $memory_usage;
}
function get_server_cpu_usage(){

    $load = sys_getloadavg();
    return $load[0];

}
$ram_2round = round(get_server_memory_usage(),2); // RAM 2 Decimals
$ram_0round = round($ram_2round,0); // RAM 0 Decimals
$cpu_2round = get_server_cpu_usage();
$cpu_0round = round($cpu_2round,0);
?>
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Dashboard</h3></div>
                <div class="row">
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-primary py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Uptime</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?php echo shell_exec('uptime -p');?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-success py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">

                                        <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>CPU Usage</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?php echo $cpu_2round;?>%</span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-microchip fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-info py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-info font-weight-bold text-xs mb-1"><span>Memory Usage</span></div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="text-dark font-weight-bold h5 mb-0 mr-3"><span><?php echo $ram_2round;?>%</span></div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-info" aria-valuenow="<?php echo $ram_0round;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $ram_0round;?>%;"><span class="sr-only"><?php echo $ram_0round;?>%</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-memory fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-warning py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span>PHP Version</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?php echo phpversion();?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fab fa-linux fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
<?php require "footer.php";?>