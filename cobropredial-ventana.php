<?php 
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			var anterior;
			function ponprefijo(pref,opc,val)
			{ 
				parent.document.form2.codproceso.value =pref;
				parent.document.form2.codcatastral.value =opc ;
				parent.document.form2.total.value =val ;
				parent.document.form2.totalco.value =val ;
				parent.document.form2.bc.value ='1' ;
				parent.document.form2.codigoco.value =pref ;
				parent.document.form2.codproceso.focus();
				parent.document.form2.codcatastral.focus();
				parent.document.form2.total.focus();
				parent.despliegamodal2("hidden");
				parent.document.form2.submit();
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
    	<form action="" method="post" enctype="multipart/form-data" name="form2">
			<?php 
					$linkbd=conectar_bd();
					if(isset($_GET[resolucion])){
						$_POST[numresolucion]=$_GET[resolucion];	
					}
							unset($_POST[vigencia]);	 		 
							$_POST[vigencia]= array_values($_POST[vigencia]);
							$sqlr1="select vigencia,predial,intereses1,sobretasabombe,intereses2,sobretasamb,intereses3,descuentos,valortotal,diasmora,codcatastral,fecha,(SELECT sum(valortotal) FROM tesocobroreporte WHERE numresolucion='$_POST[numresolucion]') from tesocobroreporte where numresolucion='$_POST[numresolucion]' ";
							$res1=mysql_query($sqlr1,$linkbd);
							$con=0;
							while ($row1=mysql_fetch_row($res1))
							{		
								$_POST[vigencia][$con]=$row1[0];	
								$_POST[predial][$con]=$row1[1];
								$_POST[interesespredial][$con]=$row1[2];
								$_POST[sobretasabombe][$con]=$row1[3];
								$_POST[intsobretasabombe][$con]=$row1[4];
								$_POST[sobretasamb][$con]=$row1[5];
								$_POST[intsobretasamb][$con]=$row1[6];
								$_POST[descuento][$con]=$row1[7];
								$_POST[valortotal][$con]=$row1[8];
								$_POST[diasmora][$con]=$row1[9];
								$_POST[codigocatastral2]=$row1[10];
								$_POST[fecha]=$row1[11];
								$_POST[total]=$row1[12];
								$con++;
							}
							
							$sql="SELECT * FROM tesocobroreporte_adj WHERE numresolucion='$_POST[numresolucion]' AND vigencia=$vigusu";
								$result=mysql_query($sql,$linkbd);
								while($row = mysql_fetch_row($result)){
									$_POST[nomarchivos][]=$row[2];
									$_POST[rutarchivos][]=basename($row[4]);
									$_POST[tamarchivos][]=filesize($row[4]);
									$_POST[patharchivos][]=basename($row[4]);
								}
							
							$sqlr="select max(numresolucion) from  tesocobroreporte ";
							$res=mysql_query($sqlr,$linkbd);
							//echo $sqlr;
								$r=mysql_fetch_row($res);
								 $_POST[maximo]=$r[0];
				?>
  			
			<div class="content" width="100%" style="overflow-x:hidden;">
		<table class="inicio" align="center" width="99%" >
      	<tr >
        	<td class="titulos" style="width:95%;" >.: Resolucion </td>
        	<td class="cerrar" style="width:8%;"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
      	</tr>
      	<tr>
      		<td style="width:75%;">
      			<table>
      				<tr  >
			  			<td style="width:10%;" class="saludo1">No de Resolucion</td>
				  		<td style="width:0.1%;">
							<td style="width:5%;">
				  			<input type="text" id="numresolucion" name="numresolucion" onKeyPress="javascript:return solonumeros(event)" style="width:100%;" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[numresolucion]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
				  		</td>
			  			<td style="width:5%;" class="saludo1">Fecha:        </td>
		        		<td style="width:7%;">
		        			<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:100%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>
		        			       
		        		</td>
				  		<td style="width:8%;" class="saludo1">Codigo Catastral:</td>
				  		<td style="width:10%;">
				  			<input type="text" id="codigocatastral2" name="codigocatastral2" onKeyPress="javascript:return solonumeros(event)" style="width:100%;" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[codigocatastral2]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
				  		</td>
						<td style="width:10%;" class="saludo1">Total a pagar ($)</td>
				  		<td style="width:8%;">
				  			<input type="text" id="total" name="total" onKeyPress="javascript:return solonumeros(event)" style="width:100%;" onKeyUp="return tabular(event,this)"  value="<?php echo number_format($_POST[total],2)?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
				  		</td>
		       		</tr>
      			</table>
      		</td>
      	</tr>
    </table>
		<table class="inicio"  >
        <tr>
          <td class="titulos" colspan="14">Detalle Resolucion          </td>
        </tr>
		<tr>
			<td class="titulos2">Vigencia</td>
			<td class="titulos2">Codigo Catastral</td>
			<td class="titulos2">Predial</td>
			<td class="titulos2">Intereses Predial</td>
			<td class="titulos2">Sobretasa Bomberil</td>
			<td class="titulos2">Intereses Bomberil</td>
			<td class="titulos2">Sobretasa Ambiental</td>
			<td class="titulos2">Intereses Ambiental</td>
			<td class="titulos2">Descuento</td>
			<td class="titulos2">Valor Total</td>
			<td class="titulos2">Dias Mora</td>
		</tr> 
		<?php 
		  $iter='zebra1';
		  $iter2='zebra2';
		 for ($x=0;$x< count($_POST[vigencia]);$x++)
		 {
		 
		 echo "<tr class='$iter'>
			<td><input name='vigencia[]' value='".$_POST[vigencia][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='codigocatastral[]' value='".$_POST[codigocatastral2]."'  style='width:100%;' readonly></td>
			<td><input name='predial[]' value='".number_format($_POST[predial][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='interesespredial[]' value='".number_format($_POST[interesespredial][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='sobretasabombe[]' value='".number_format($_POST[sobretasabombe][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='intsobretasabombe[]' value='".number_format($_POST[intsobretasabombe][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='sobretasamb[]' value='".number_format($_POST[sobretasamb][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='intsobretasamb[]' value='".number_format($_POST[intsobretasamb][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='descuento[]' value='".number_format($_POST[descuento][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='valortotal[]' value='".number_format($_POST[valortotal][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='diasmora[]' value='".$_POST[diasmora][$x]."' type='text' style='width:100%;' readonly></td>
		</tr>";
		  	$aux=$iter;
	 		$iter=$iter2;
	 		$iter2=$aux;
		 }
		 
		?>
		</tr>
		</table>
		</div>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>"/>
		</form>
	</body>
</html> 
