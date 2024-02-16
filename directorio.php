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
<?php require 'head.php';
?>
    <main class="page catalog-page">
        <section class="clean-block clean-catalog dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Directorio</h2>
                    <p>Gye-PBX. (04) 371-4240</p>
                    <p>UIO-PBX. (02) 396-0310 /396-0339</p>
                </div>
                <div class="content">
                    <div class="row no-gutters justify-content-center">
                        <div class="col-md-9">
                            <div class="products">
                                <div class="table-responsive">
									<table id="products" class="table-responsive table responsive table-bordered w-auto" style="width:100%">
										<thead>
											<tr>
												<th>Nombre</th>
												<th>Cargo</th>
												<th>EXT.</th>
												<th>Correo</th>
											</tr>
										</thead>
										<tbody>

									<?php
										$file = "directorio.csv";
									    $csv = array_map('str_getcsv', file($file));
										array_walk($csv, function(&$a) use ($csv)
											{
												$a = array_combine($csv[0], $a);
											});
										array_shift($csv); # remove column header
										//print_r($csv);
									foreach($csv as $row)
									{
										$Nombre = strtoupper(array_values($row)[0]);
										$Cargo = strtoupper($row["CARGO"]);
										$Ext = $row["EXT."];
										$Correo = strtolower($row["CORREO"]);

										echo "
												<tr>
												<td><h6 class=\"text-left align-middle\">$Nombre</h6></td>
												<td><h6 class=\"text-center align-middle\">$Cargo</h6></td>
												<td><h6 class=\"text-center align-middle\">$Ext</h6></td>
												<td><h6 class=\"text-center align-middle\">$Correo</h6></td>
												</tr>
										";
									}
									?>
										</tbody>
									</table>
									</div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php require 'footer_buscar.php';
?>
