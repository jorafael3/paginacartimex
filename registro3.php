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
?>
<?php
//header("Access-Control-Allow-Origin: *");
require 'head.php';
?>
<?php
// Check User INPUT
$clean_msg = "0";
if (isset($_GET["msg"])) {
    $clean_msg = filter_var($_GET["msg"], FILTER_SANITIZE_NUMBER_INT);
}

if (strlen($clean_msg) > 2) {
    echo '<script>window.location.replace("registro.php")</script>';
    die();
}

// MESSAGES
$message = "";
if ($clean_msg == "1") {
    $message = "Los datos ingresados no son correctos, por favor ingresar datos que se puedan verificar.";
}
if ($clean_msg == "2") {
    $message = "El campo RUC se encuentra incorrecto.";
}
if ($clean_msg == "3") {
    $message = "Los datos no son suficientes, debe llenar todos los campos.";
}


?>
<main class="page registration-page">
    <section class="clean-block clean-form dark">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info"><?php echo $message; ?></h2>
            </div>

        </div>

    </section>

    </div>
</main>

<?php require 'footer.php'; ?>