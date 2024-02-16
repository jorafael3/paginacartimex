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
// CHECK ISSET from POST
// nombre, ruc, cedula, ciudad, direccion, celular, rlegal, email
$data_present = false;
if (isset($_POST["Enviar_Datos"])) {
    $data_present = true;
} else {
    echo '<script>window.location.replace("registro3.php?msg=3")</script>';
    die();
}; // MSG 3

// CLEAN USER INPUT
$clean_p_natural = filter_var($_POST["p_natural"], FILTER_SANITIZE_STRING);

$clean_ruc = filter_var($_POST["ruc"], FILTER_SANITIZE_NUMBER_INT);
$clean_nombres = filter_var($_POST["nombres"], FILTER_SANITIZE_STRING);
$clean_actividad_comercial = filter_var($_POST["actividad_comercial"], FILTER_SANITIZE_STRING);

$clean_razon_social = filter_var($_POST["razon_social"], FILTER_SANITIZE_STRING);
$clean_rlegal = filter_var($_POST["rlegal"], FILTER_SANITIZE_STRING);
$clean_cedula = filter_var($_POST["cedula"], FILTER_SANITIZE_NUMBER_INT);

$clean_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$clean_provincia = filter_var($_POST["provincia"], FILTER_SANITIZE_STRING);
$clean_ciudad = filter_var($_POST["ciudad"], FILTER_SANITIZE_STRING);
$clean_direccion = filter_var($_POST["direccion"], FILTER_SANITIZE_STRING);
$clean_celular = filter_var($_POST["celular"], FILTER_SANITIZE_EMAIL);
$clean_pg = ($_POST["terminos"]);
$clean_ppd = ($_POST["terminos_prt"]);
if ($clean_pg == 'on') {
    $clean_pg = 1;
} else {
    $clean_pg = 0;
}
if ($clean_ppd == 'on') {
    $clean_ppd = 1;
} else {
    $clean_ppd = 0;
}
$continue_execution = 0;

if ($clean_nombres == "") {
    $errors = "Debe Escribir un nombre";
    $continue_execution = 1;
    // echo '<script>window.location.replace("registrov2.php")</script>';
}
if ($clean_actividad_comercial == "") {
    $errors = "Debe Escribir una actividad Comercial";
    $continue_execution = 1;

    // echo '<script>window.location.replace("registrov2.php")</script>';
}
if ($clean_email == "") {
    $errors = "Debe Escribir un email";
    // echo '<script>window.location.replace("registrov2.php")</script>';
}
if ($clean_provincia == "") {
    $continue_execution = 1;

    $errors = "Debe Seleccionar una Provincia";
    // echo '<script>window.location.replace("registrov2.php")</script>';
}
if ($clean_ciudad == "") {
    $continue_execution = 1;

    $errors = "Debe Seleccionar una ciudad";
    // echo '<script>window.location.replace("registrov2.php")</script>';
}
if ($clean_direccion == "") {
    $continue_execution = 1;

    $errors = "Debe Escribir una dirección";
    // echo '<script>window.location.replace("registrov2.php")</script>';
}
if ($clean_celular == "") {
    $continue_execution = 1;

    echo "Debe Escribir un número celular";
    // echo '<script>window.location.replace("registrov2.php")</script>';
}

if ($clean_p_natural == 1) {

    if ($clean_razon_social == "") {
        $continue_execution = 1;
        $errors = "Debe Escribir la razón social";
        // echo '<script>window.location.replace("registrov2.php")</script>';

    }
    if ($clean_rlegal == "") {
        $continue_execution = 1;
        $errors = "Debe Escribir el representante legal";
        // echo '<script>window.location.replace("registrov2.php")</script>';

    }
    if ($clean_cedula == "") {
        $continue_execution = 1;
        $errors = "Debe Escribir la cédula del representante legal";
        // echo '<script>window.location.replace("registrov2.php")</script>';

    }
}

// echo $continue_execution;
if ($continue_execution == 0) {

}

// // Check if there is content inside the variables (From user input and sanitized)
// if (strlen($clean_nombre) > 5 && strlen($clean_ruc) > 5 && strlen($clean_email) > 5 && strlen($clean_ciudad) > 3 && strlen($clean_direccion) > 4 && strlen($clean_celular) > 5 && strlen($clean_rlegal) > 5 && strlen($clean_cedula) > 5) {
//     $data_present = true;
// } else {
//     echo '<script>window.location.replace("registro3.php?msg=1")</script>';
//     die();
// } // MSG 1


// if (strlen($clean_ruc) > 15) {
//     echo '<script>window.location.replace("registro3.php?msg=2")</script>';
//     die();
// } // MSG 2


// //-------------------------------------------------------------------------------------------
// $errors = ""; // Error Messages
// $continue_execution = true; // if there is an error the registration is not saved in database
// //-------------------------------------------------------------------------------------------



// //Check for RUC on registry table Dist
// require('dbcore.php'); //LOAD DATABASE MODULE
// $pdo2 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
// $statement2 = $pdo2->prepare("SELECT * FROM web_regDistribuidor WHERE Ruc=:ruc");
// $statement2->bindParam(':ruc', $clean_ruc, PDO::PARAM_STR);
// $statement2->execute();
// $ctr = 0;
// while ($row2 = $statement2->fetch(PDO::FETCH_ASSOC)) {
//     $ctr++;
// }
// if ($ctr > 0) {
//     $continue_execution = false;
//     $errors = "Ya se ha registrado previamente,<br>si después de 7 días no tiene una respuesta por favor<br>contactar a la empresa.<br>PBX. (04) 371-4240";
// }
// if ($ctr == 0) {
//     $continue_execution = true;
// }
// // END CHECK FOR EXISTING RUC



// if ($_SESSION['enable_regs'] == false) {
//     $continue_execution = false;
//     $errors .= "<br><br><b>El registro se encuentra desactivado por el Administrador.</b>";
// }

// ENTER USER DATA TO DATABASE web_regDistribuidor
// if ($continue_execution == true) {
//     $estado = "Pendiente";
//     $pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
//     $statement = $pdo->prepare("INSERT INTO web_regDistribuidor (Nombre, RUC, EMAIL, Ciudad, Direccion, Celular, Cedula, rlegal, Fecha_Create, Estado) VALUES (:Nombre, :Ruc, :Email, :Ciudad, :Direccion, :Celular, :Cedula, :rlegal, GETDATE(), :Estado)");
//     $statement->bindParam(':Nombre', $clean_nombre, PDO::PARAM_STR);
//     $statement->bindParam(':Ruc', $clean_ruc, PDO::PARAM_STR);
//     $statement->bindParam(':Email', $clean_email, PDO::PARAM_STR);
//     $statement->bindParam(':Ciudad', $clean_ciudad, PDO::PARAM_STR);
//     $statement->bindParam(':Direccion', $clean_direccion, PDO::PARAM_STR);
//     $statement->bindParam(':Celular', $clean_celular, PDO::PARAM_STR);
//     $statement->bindParam(':Cedula', $clean_cedula, PDO::PARAM_STR);
//     $statement->bindParam(':rlegal', $clean_rlegal, PDO::PARAM_STR);
//     $statement->bindParam(':Estado', $estado, PDO::PARAM_STR);
//     $statement->execute();
//     $errors .= "<br>Registro Completo. <br>Un agente se contactará dentro de los próximos días.";



//     $OS = $_SERVER['HTTP_USER_AGENT'];
//     $metodo = "PAG_WEB";
//     $empresa = "CARTIMEX";
//     $ip = getRealIP();
//     $pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
//     $statement3 = $pdo->prepare("INSERT INTO WEB_CARTIMEX_DATOS_POLITICAS
//     (
//         ruc,
//         email,
//         telefono,
//         politica_general,
//         politica_pr_datos,
//         nombres,
//         apellidos,
//         empresa,
//         ip,
//         so,
//         metodo,
//         direccion
//     )
//         VALUES
//     (
//         :ruc,
//         :email,
//         :telefono,
//         :politica_general,
//         :politica_pr_datos,
//         :nombres,
//         :apellidos,
//         :empresa,
//         :ip,
//         :so,
//         :metodo,
//         :direccion
//     )");
//     $statement3->bindParam(':ruc', $clean_ruc, PDO::PARAM_STR);
//     $statement3->bindParam(':email', $clean_email, PDO::PARAM_STR);
//     $statement3->bindParam(':telefono', $clean_celular, PDO::PARAM_STR);
//     $statement3->bindParam(':politica_general', $clean_pg, PDO::PARAM_STR);
//     $statement3->bindParam(':politica_pr_datos', $clean_ppd, PDO::PARAM_STR);
//     $statement3->bindParam(':nombres', $clean_nombre, PDO::PARAM_STR);
//     $statement3->bindParam(':empresa', $empresa, PDO::PARAM_STR);
//     $statement3->bindParam(':ip', $ip, PDO::PARAM_STR);
//     $statement3->bindParam(':so', $OS, PDO::PARAM_STR);
//     $statement3->bindParam(':metodo', $metodo, PDO::PARAM_STR);
//     $statement3->bindParam(':direccion', $clean_direccion, PDO::PARAM_STR);
//     if ($statement3->execute()) {
//     } else {
//         // $errors = $statement3->errorInfo();
//         // $errors = json_encode($errors);
//         // $errors = $clean_ppd;
//     }
// }



function getRealIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];

    return $_SERVER['REMOTE_ADDR'];
}

function validarCedula($cedula)
{
    // Verificar que la cédula tenga 10 dígitos
    if (strlen($cedula) !== 10) {
        return false;
    }

    // Obtener los primeros 9 dígitos de la cédula
    $digitos = substr($cedula, 0, 9);

    // Obtener el último dígito de la cédula
    $digitoVerificador = substr($cedula, 9);

    // Calcular el dígito verificador esperado
    $suma = 0;
    $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
    for ($i = 0; $i < 9; $i++) {
        $producto = $digitos[$i] * $coeficientes[$i];
        if ($producto >= 10) {
            $producto -= 9;
        }
        $suma += $producto;
    }
    $digitoVerificadorEsperado = (ceil($suma / 10) * 10) - $suma;

    // Comparar el dígito verificador calculado con el dígito verificador ingresado
    if ($digitoVerificador != $digitoVerificadorEsperado) {
        return false;
    }

    return true;
}

function validarRUC($ruc)
{
    // Verificar que el RUC tenga 13 dígitos
    if (strlen($ruc) !== 13) {
        return false;
    }

    // Verificar que los primeros dos dígitos sean 10 o 20 (personas naturales) o 30 (empresas)
    $primerosDosDigitos = substr($ruc, 0, 2);
    if ($primerosDosDigitos !== "10" && $primerosDosDigitos !== "20" && $primerosDosDigitos !== "30") {
        return false;
    }

    // Verificar el último dígito, que corresponde al dígito verificador
    $digitoVerificador = substr($ruc, -1);
    $digitos = substr($ruc, 0, -1);

    // Calcular el dígito verificador esperado
    $suma = 0;
    $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
    for ($i = 0; $i < 9; $i++) {
        $producto = $digitos[$i] * $coeficientes[$i];
        if ($producto >= 10) {
            $producto -= 9;
        }
        $suma += $producto;
    }
    $digitoVerificadorEsperado = (ceil($suma / 10) * 10) - $suma;

    // Verificar que el dígito verificador sea correcto
    if ($digitoVerificador != $digitoVerificadorEsperado) {
        return false;
    }

    return true;
}

?>

<main class="page registration-page">
    <section class="clean-block clean-form dark">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Registro</h2>
                <p style="font-weight: bold; color: red; font-size: 16px;"><?php echo $errors; ?></p>
            </div>

        </div>

    </section>

    </div>
</main>

<?php require 'footer.php'; ?>