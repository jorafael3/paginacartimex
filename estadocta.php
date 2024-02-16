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
$cedula_s= $_SESSION['login_id'];
$nombre_s = $_SESSION['login_nombre'];
//header("Access-Control-Allow-Origin: *");
require 'head.php';
$ctr = 0;
?>
	<main class="page catalog-page">
        <section class="clean-block clean-catalog dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Estado de Cuenta</h2>                   				
                </div>
				<p> <h5 class="text-info"> <?php echo "RUC: ". $cedula_s. "    "?>  <?php echo "CLIENTE: " .$nombre_s ?> </h5></p>
				<table border=0 cellpadding=0 cellspacing=10 width=100%>
				<th   align=center  width=9% height=0 bgcolor="gainsboro"> Fecha</th>
				<th   align=center  width=12% height=0 bgcolor="gainsboro"> Vencimiento</th>
				<th   align=center  width=6% height=0 bgcolor="gainsboro"> Dias</th>
				<th   align=center  width=10% height=0 bgcolor="gainsboro"> Tipo</th>
				<th   align=left  width=16% height=0 bgcolor="gainsboro"> Numero</th>
				<th   align=left  width=27% height=0 bgcolor="gainsboro"> Detalle</th>
				<th   align=right  width=10% height=0 bgcolor="gainsboro"> Valor</th>
				<th   align=right  width=10% height=0 bgcolor="gainsboro"> Saldo</th>
				
				<div class="content">
                    <div class="row justify-content-center"> <! este es el marco blanco de contenido >
                        
                            
							
<?php
require('dbcore.php'); //Call database connection module
require('injection/injections.php'); //Anti Hacking Module

//Aqui deberia salir el nombre y los datos del cliente logoneado



	//Establishes the connection
	$pdo6 = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
	//select query
	$statement6 = $pdo6-> prepare("CLI_SELECT_ESTADOCUENTAS_CEDULA @CEDULA=:idcedula");
	$statement6 ->bindParam(':idcedula',$cedula_s,PDO::PARAM_STR);
	$statement6 ->execute();
	$count = $statement6->rowCount();
	if ($row6 = $statement6->fetch(PDO::FETCH_ASSOC)) {
        do {
			//var_dump($row6);
			if($ctr>100)
				break; 
			$ctr++;
		    
			// campos: id, Fecha,Vencimiento, Dias, Tipo, Numero, Detalle, Valor, Saldo
			$id = $row6['ID'];
			$Fecha = $row6['FECHA'];
			$Vencimiento = $row6['VENCIMIENTO'];
			$Dias = $row6['DIAS'];
			$Tipo = $row6['TIPO'];
			$Numero = $row6['NUMERO'];
			$Detalle = $row6['DETALLE'];
			$Valor = $row6['VALOR'];
			$Saldo = $row6['SALDO'];        
			echo "<tr >";
			echo "<td align=left width=9% height=0>".$Fecha."</td>";
			echo "<td align=center width=12% height=0>" .$Vencimiento." </td>";
			echo "<td align=left width=6% height=0>" .$Dias."</td>";
			echo "<td align=left  width=10% height=0>" .$Tipo. "</td>";
			echo "<td align=left  width=16% height=0>" .$Numero."</td>";
			echo "<td align=left  width=27% height=0>" .$Detalle."</td>";
			echo "<td align=right  width=10% height=0> $".money_format('%.2n',$Valor)."</td>";
			echo "<td align=right  width=10% height=0> $".money_format('%.2n',$Saldo)."</td>";
			echo "</tr>";
			} 
			//money_format('%.2n', $number)
			while($row6 = $statement6->fetch(PDO::FETCH_ASSOC));
			
			//echo "<input type='button' value='Imprimir' onClick='window.print()'>";
		
	?>
		   
		   </table>
		   <br>
		   <div align="right" >
		   <input type="button" value=" Imprimir movimientos " onClick="window.print()" border=0>
		   </div>
<?php	   	
		}	
		$statement6 = NULL;
				// Si no hay resultados
				if ($ctr == 0){echo "Cuenta no posee Movimientos 2.";}
				?>
																								
                          
                       
					</div>	
				</div>
            </div>
        </section>
    </main>
	
<?php require 'footer.php';?>