<!DOCTYPE html>
<html>
<?php require 'head.php';?>

    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Generar Contraseña</h2>
                    <p>Ingresar Cédula o RUC</p>
                </div>
                <form target="_self" action="reset2.php" method="post">
                    <div class="form-group"><label for="number">Identificación (Cédula o RUC)</label><input class="form-control item" type="text" id="ID" name="ID" required></div>
                    <div class="form-group"><input   type="checkbox" id="terminos" name="terminos" required> He leído y acepto Términos y Condiciones</div>
                    <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#Modal1">
          					Ver Términos y Condiciones
          					</button>
                    <button class="btn btn-danger btn-block" type="submit">Enviar Token al email</button></form>
            </div>
        </section>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="Modal1" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><strong>Términos y Condiciones</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body lg" align="justify">
            <p>
          		Declaro y me responsabilizo que toda la información en esta solicitud es correcta. Asimismo, expresamente autorizo a CARTIMEX S.A. que se obtenga de cualquier fuente de información referencias relativas a mi comportamiento crediticio o al de mí representada, al manejo de mi(s) tarjeta(s) de crédito, etc, y, en general al cumplimiento de mis obligaciones, así como confiero mi autorización expresa para obtener, procesar, reportar y suministrar cualquier información de carácter crediticio; incluidos los burós de crédito, financiero y comercial a cualquier central de información debidamente constituida. <br>Adicionalmente autorizo que se proporcione y obtenga cualquier información de carácter crediticio, financiero y comercial que requiera un tercero interesado en adquirir cartera respecto a la cual sea(mos) obligados principales o garantes. Los valores que estoy(amos) solicitando sean financiados, van a tener un destino lícito y no serán utilizados en ninguna actividad que esté relacionada con el cultivo, producción, transporte, tráfico, etc, de estupefacientes o sustancias psicotrópicas.
    		    </p>
          </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
          </div>
        </div>
    </div>
    <!-- END Modal -->

<?php require 'footer.php';?>
