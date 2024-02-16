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
<?php require 'head.php';
?>

<style>
	body {
		font-family: Arial, sans-serif;
		margin: 20px;
	}

	.aviso {
		background-color: #f8d7da;
		color: #721c24;
		padding: 15px;
		border: 1px solid #f5c6cb;
		border-radius: 5px;
		margin-bottom: 20px;
	}

	.contacto {
		margin-top: 20px;
	}
</style>

<section class="clean-block clean-catalog dark">
	<div class="container">
		<div class="block-heading">
			<h2 class="text-info">Comunicado</h2>
		</div>
		<div class="content">
			<div class="row justify-content-center">

				<div class="col-12 p-5">

					<div class="avis">
						<p><strong>Aviso Importante:</strong></p>
						<p>Es nuestra obligación informarle que CARTIMEX S.A. con RUC 0991400427001, es GRAN CONTRIBUYENTE y según la nueva “LEY ORGÁNICA DE URGENCIA ECONÓMICA Y GENERACIÓN DE EMPLEO” en su artículo 17 indica: A partir del 1 de Enero de 2024 “Las sociedades consideradas como Grandes Contribuyentes no serán sujetas de Retención en la Fuente del Impuesto a la Renta”; excepto en aquellas operaciones que realicen con el Estado y sus instituciones.</p>
						<p>Las condiciones para las Retenciones de IVA se mantienen y se continuarán receptando con normalidad.</p>
						<p>Agradecemos de antemano su colaboración a fin de evitar confusiones contables y en caso de tener duda alguna favor comunicarse con nuestras áreas de crédito y cobranzas:</p>
					</div>

					<div class="contacto">
						<!-- <p><strong>Áreas de Crédito y Cobranzas:</strong></p> -->
						<p><strong>Victor Cedeño - Crédito y Cobranzas Guayaquil:</strong> 04 371 4240 Ext 308 / Cell 096-819 8102 / Email: <a href="mailto:vcedeno@cartimex.com">vcedeno@cartimex.com</a></p>
						<p><strong>Marco Ajitimbay - Crédito y Cobranzas Quito:</strong> 02 396 0310 Ext 218 / Cell 099-312 1944 / Email: <a href="mailto:marco.ajitimbay@uio.cartimex.com">marco.ajitimbay@uio.cartimex.com</a></p>
						<p>
							<i style="font-size: 26px;" class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i>
							<strong> Para leer la LEY DE ORGÁNICA DE EFICIENCIA ECONÓMICA hacer click </strong> 
							<a href="DocLegal/LEY_ORGANICA_DE_EFICIENCIA _ECONOMICA.pdf">aquí</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php require 'footer.php';
?>