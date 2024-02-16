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

<main class="page faq-page">
    <section class="clean-block clean-faq dark">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">¿Quiénes Somos?</h2>
            </div>
            <div class="block-content">
                <div class="faq-item">
                    <div class="answer">
                        <p class="text-justify"><strong>CARTIMEX </strong>es una empresa tecnológica fundada en 1996, y desde entonces sigue siendo reconocida en el mercado ecuatoriano por su constante propuesta innovadora, ofreciendo la vanguardia y la calidad con flexibilidad
                            de precios y créditos; constituyéndose en el líder indiscutible de la comercialización tecnológica con la mayor cobertura en todo el Ecuador.&nbsp;</p>
                        <p class="text-justify">Nuestro enfoque de negocios como grupo empresarial con visión social, está dedicado a cubrir toda la red de distribución de hardware, partes, piezas y componentes de computación y electrónica.<br></p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="answer"></div>
                </div>
                <div class="faq-item">
                    <div class="answer">
                        <p class="text-justify"><strong>CARTIMEX</strong>&nbsp;cuenta con sus centros principales de atención y logística en las ciudades de Guayaquil y Quito, permitiendo gestionar negocios efectivos con sus clientes, bajo el concepto de sistema de&nbsp;atención
                            descentralizado en el país.<br>Miles de metros cuadrados hoy día; y, creciendo más para áreas de bodega y tránsito, unido a un eficiente sistema de transportación privada otorga una eficaz y oportuna entrega a nivel nacional.</p>
                        <!-- <p class="text-justify">El entorno tecnológico del Grupo&nbsp;<strong>CARTIMEX&nbsp;</strong>está integrado por varias empresas, instalaciones como:&nbsp;<strong>ITTEK CORP</strong>, encargada de las operaciones de compras y negociaciones con proveedores
                            internacionales;&nbsp;<strong>ITTEKCLOUD</strong>,&nbsp;encargada de desarrollo de proyectos, soporte y consultoría en el área&nbsp;de I.T.(ambas empresas americanas, ubicadas en Miami, USA)</p>
                         -->
                        <p class="text-justify">Nuestro compromiso de servicio de garantía lo realiza
                            <strong>SERVITECH</strong>,
                            otorgándoselos a todos los productos comercializados
                            por&nbsp;<strong>CARTIMEX</strong>, 
                            el componente
                            comercial más tradicional del Grupo <strong>CARTIMEX</strong>
                            sigue enfocando sus metas en la atención corporativa.
                        </p>
                        <p class="text-justify"><strong>CARTIMEX</strong> mantiene una solidez certificada formalmente por empresas como Ecuability, calificadora de riesgo, que confirió al Grupo <strong>CARTIMEX</strong> una calificación de <strong>AA+</strong></p>
                        <p class="text-justify">Fue necesario juntar muchas fuerzas comerciales: productos de última generación, personal capacitado , formar un canal sólido de clientes y amigos para lograr la distribución nacional de las mejores marcas mundiales, de
                            las cuales comercializamos las siguientes:</p>
                        <p class="text-center"><img class="img-fluid d-block mx-auto" src="assets/img/marcas_2.jpeg" style="width: Auto;height: 480px;margin: 0 auto;"></p>
                        <p>Sin duda todos estos elementos que se resumen en nuestra misión y visión: CALIDAD, PRECIO, GARANTIA Y CONFIANZA.</p>
                        <p>Siendo así&nbsp; CARTIMEX un complejo grupo informático con posicionamiento nacional y proyección internacional.<br></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require 'footer.php'; ?>