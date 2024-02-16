<!DOCTYPE html>
<html>
<?php
// Starting Session
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
?>
<?php
//header("Access-Control-Allow-Origin: *");
require 'head.php';
?>
    <main class="page faq-page">
        <section class="clean-block clean-faq dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Dirección</h2>
                </div>
                <div class="block-content">
                    <div class="faq-item">
                        <div class="answer">
                            <p class="text-justify">GUAYAQUIL: Sector Industrial Los Alamos Calle Blanca Muñoz y Av. Elías Muñoz <br>&nbsp; PBX. (04) 371-4240.</p>

                        </div>
                    </div>
					          <a href="https://www.google.com/maps/place/Cartimex+S.A./@-2.1751,-79.8972316,15.25z/data=!4m5!3m4!1s0x902d6dc6a4eae02d:0x197829950346ca40!8m2!3d-2.1743511!4d-79.8902321" target="_blank">
					          <p class="text-center"><img class="img-fluid d-block mx-auto" src="assets/img/mapa.png" style="width: Auto;height: 480px;margin: 0 auto;"></p></a>
					      </div>
                <div class="block-content">
                    <div class="faq-item">
                        <div class="answer">

                            <p class="text-justify">Quito: Murgeon OE3-10 y Antonio de Ulloa Atras del registro de la propiedad <br>&nbsp; PBX.(02) 3960310 &nbsp;(02) 3960339<br></p>
                        </div>
                    </div>
					          <a href="https://www.google.com/maps/place/CartimexUIO+S.A.0%C2%B011,23.3%22S+78%C2%B029,41.6%22W/@-0.1898042,-78.497063,17z/data=!3m1!4b1!4m5!3m4!1s0x0:0x0!8m2!3d-0.1898042!4d-78.4948743?hl=es" target="_blank">
					          <p class="text-center"><img class="img-fluid d-block mx-auto" src="assets/img/mapauio.png" style="width: Auto;height: 480px;margin: 0 auto;"></p></a>
					      </div>
            </div>
        </section>
    </main>
<?php require 'footer.php';?>
