        </div> <!-- Head end -->
	<footer class="bg-white sticky-footer">
        <div class="container my-auto">
            <div class="text-center my-auto copyright"><span>Copyright © Cartimex 2020</span></div>
        </div>
    </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/chart.min.js"></script>
    <script src="../assets/js/bs-charts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="../assets/js/theme.js"></script>
	<script type="text/javascript" src="../assets/datatables/datatables.min.js"></script>
<script>
$(document).ready(function() {
	var table = $('#users').DataTable( {
		"pageLength": 25,
		responsive: true,
		"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": true,
                "searchable": true
            }
			],
			
        "language": {
            "url": "../assets/datatables/Spanish.json"
        }
    });
    // Event listener to the two range filtering inputs to redraw on input
    $('#min, #max').keyup( function() {
        table.draw();
    } );
} );
</script>
<script>
$(document).ready(function() {
    var oTable = $('#users').DataTable();
	
    $('#searchPendiente').click(function () {
        oTable.search("Pendiente").draw();
    });
	
	$('#searchProceso').click(function () {
        oTable.search("En Proceso").draw();
    });
	
	$('#searchTodo').click(function () {
        oTable.search("").draw();
    });
	
});
</script>

</body>

</html>