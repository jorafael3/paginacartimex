    <footer class="page-footer dark ">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Links</h5>
                    <ul>
                        <li><a href="http://nuevo.cartimex.com:88/matrix/sri" target="_blank">Factura Electrónica</a></li>
                        <li></li>
                        <li><a href="registro.php">Regístrate como distribuidor</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Empresa</h5>
                    <ul>
                        <li><a href="empresa.php">Información de la Empresa</a></li>
                        <li><a href="direccion.php">Dirección</a></li>
                        <li><a href="directorio.php">Directorio / Teléfonos</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Redes Sociales</h5>
                    <ul>
                        <li><a href="https://twitter.com/CartimexSA" target="_blank">Twitter&nbsp;<i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.facebook.com/cartimex" target="_blank">Facebook&nbsp;<i class="fa fa-facebook-official"></i>&nbsp;</a></li>
                        <li><a href="https://www.youtube.com/@cartimexs.a4897" target="_blank">Youtube&nbsp;<i class="fa fa-youtube"></i>&nbsp;</a></li>

                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Políticas de Venta y Devolución</a></li>
                        <li><a href="#">Políticas de Privacidad</a></li>
                        <li><a href="DocLegal/Resolución_Cartimex.pdf" target="_blank">Resolución Aprobatoria</a></li>
                        <li><a href="DocLegal/Resolucion_cancelada_41875.pdf" target="_blank">Resolución Cancelada</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p style="font-size: 12px;">© 2020 CARTIMEX<br>Cartimex S.A. se reserva el derecho a efectuar cambios en su contenido sin previo aviso.<br>Cartimex S.A. no manifiesta ni garantiza que la información contenida en esta página sea precisa o completa.<br>Cartimex S.A. no
                se responsabiliza de los posibles errores en la publicación de dicha información, incluyendo sin limitación las fotografías, los modelos, precios y las especificaciones de los productos.<br><br></p>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/baguettebox/baguetteBox.min.js"></script>
    <script src="assets/js/smoothproducts.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/rvc.js"></script>
	<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>
	<script>
/* Custom filtering function which will search data in column four between two values */
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = parseInt( $('#min').val(), 10 );
        var max = parseInt( $('#max').val(), 10 );
        var price = parseFloat( data[4] ) || 0; // use data for the price column

        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && price <= max ) ||
             ( min <= price   && isNaN( max ) ) ||
             ( min <= price   && price <= max ) )
        {
            return true;
        }
        return false;
    }
);
$(document).ready(function() {
	var table = $('#products').DataTable( {
		"pageLength": 10,
		responsive: true,
		"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": true,
                "searchable": false
            }
			],

        "language": {
            "url": "assets/datatables/Spanish.json"
        }
    });
    // Event listener to the two range filtering inputs to redraw on input
    $('#min, #max').keyup( function() {
        table.draw();
    } );
} );
</script>
</body>
</html>
