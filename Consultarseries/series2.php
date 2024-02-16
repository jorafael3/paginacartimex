<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Series</title>
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
	<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<body>
	<div class="col-12 p-5">
		<div class="card">
			<!-- <h5 class="card-header">Consultar Series Productos</h5> -->
			<div class="card-body">
				<center>
					<img src="xtratech_com.png" class="text-center" alt="">
				</center>

				<h5 class="card-title text-center fs-1">Consultar Series Productos</h5>
				<div class="col-12 d-flex justify-content-center mt-5">
					<div class="form-group">
						<input type="email" class="form-control" id="SERIE" placeholder="Numero de serie" name="serie_pr">
					</div>
				</div>
				<div class="col-12 d-flex justify-content-center mt-3">
					<div class="form-group">

						<button onclick="GET_SERIES()" class="btn btn-primary fw-bolder fs-5">Consultar</button>
					</div>
				</div>
				<center style="display: none;" id="SECC">
					<div class="col-9 mt-3">
						<div class="table-responsive">
							<table id="TABLA" class="table display" style="width: 100%;">
								<thead>
									<tr>
										<td class="text-muted fw-bolder fs-5">Serie</td>
										<td class="text-muted fw-bolder fs-5">Producto</td>
										<td class="text-muted fw-bolder fs-5">Cliente</td>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="alert alert-primary fs-4" role="alert">
						Este dispositivo fue adquirido a través de un canal autorizado
					</div>
				</center>

			</div>
		</div>
	</div>


</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	document.getElementById("SERIE").focus();

	function GET_SERIES() {
		let numero = $("#SERIE").val();
		var parametros = {
			"series": "1",
			"numero": numero
		};
		if (numero == "") {
			Swal.fire(
				'ingrese un numero de serie',
				'',
				'error'
			)
			document.getElementById("SERIE").focus();

		} else {

			$.ajax({
				data: parametros,
				datatype: 'json',
				url: 'funcion.php',
				type: 'POST',
				success: function(marcas) {
					let data = JSON.parse(marcas)
					if (data[0]["PRODUCTO"] == "SERIE NO REGISTRADA") {
						Swal.fire(
							'SERIE NO REGISTRADA',
							'',
							'error'
						)
					} else {
						console.log(data);
						Tabla(data);
						document.getElementById("SERIE").focus();
						$("#SERIE").val("");
						$("#SECC").show(200);
					}

				}
			})
		}

	}

	function Tabla(datos) {
		console.log('datos: ', datos);

		// // $("#Tabla_Pendientes").empty();
		// if ($.fn.dataTable.isDataTable('#TABLA')) {
		// 	$('#TABLA').DataTable().destroy();
		// 	$('#TABLA').empty();
		// }
		// $("#Tabla_Pendientes").addClass("table align-middle table-row-dashed fs-6 gy-3 dataTable no-footer");
		var tablaprecios = $('#TABLA').DataTable({
			destroy: true,
			data: datos,
			dom: 'rtip',
			paging: false,
			order: [
				[0, "desc"]
			],
			info: false,
			columns: [{
					data: "SERIE",
					title: "Serie"
				}, {
					data: "PRODUCTO",
					title: "Producto"
				}, {
					data: "CANAL",
					title: "Cliente"
				},
				// {
				// 	data: "Garantia",
				// 	title: "Garantia restante (Dias)"
				// }
			],
			"createdRow": function(row, data, index) {

				// let fecha = `
				//     <div class="d-flex justify-content-start flex-column">
				//         <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">` + moment(data["fecha"]).format("YYYY-MM-DD") + `</a>
				//         <span class="text-gray-600 fw-semibold d-block fs-7">` + moment(data["fecha"]).format("hh:mm") + `</span>
				//     </div>
				// `;
				// $('td', row).eq(0).html(fecha);
				$('td', row).eq(0).addClass("text-dark fs-6 fw-bolder");
				$('td', row).eq(3).addClass("text-dark fs-6 fw-bolder");
				$('td', row).eq(1).addClass("fs-6");
				$('td', row).eq(2).addClass("fs-6");
				// $('td', row).eq(2).addClass("text-gray-800 text-hover-primary");
				// $('td', row).eq(3).addClass("text-gray-800 text-hover-primary");
				// $('td', row).eq(4).addClass("text-gray-800 fw-bolder bg-light-warning");
				// // $('td', row).eq(5).html(data["texto"]);
				// if (data["estado"] == 1) {
				// 	$('td', row).eq(5).addClass("text-danger fs-5 fw-bolder");
				// } else if (data["estado"] == 2) {
				// 	$('td', row).eq(5).addClass("text-success fs-5 fw-bolder");
				// }
			}
		});

		setTimeout(function() {
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust().draw();
		}, 1000);



		//------------------------------------------------------------ //  
	}
</script>

</html>