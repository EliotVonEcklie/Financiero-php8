<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>

	<script>
		function agregardetalle(){
			if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0 ){ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 			}
			else{
 				alert("Falta informacion para poder Agregar");
 			}
		}

		function eliminar(variable){
			if (confirm("Esta Seguro de Eliminar")){
				document.form2.elimina.value=variable;
				//eli=document.getElementById(elimina);
				vvend=document.getElementById('elimina');
				//eli.value=elimina;
				vvend.value=variable;
				document.form2.submit();
			}
		}

		/*function guardar(){
			if (document.form2.fecha.value!=''){
				if (confirm("Esta Seguro de Guardar")){
  					document.form2.oculto.value=2;
  					document.form2.submit();
  				}
  			}
  			else{
  				alert('Faltan datos para completar el registro');
  				document.form2.fecha.focus();
  				document.form2.fecha.select();
  			}
		}*/

	function pdf(){
		document.form2.action="teso-pdfrecaudos.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}

	function adelante(scrtop, numpag, limreg, filtro){
		if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value)){
			document.form2.oculto.value=1;
			document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
			document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
			var idcta=document.getElementById('ncomp').value;
			document.form2.action="teso-editasinrecaudos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			document.form2.submit();
		}
	}

	function atrasc(scrtop, numpag, limreg, filtro){
		if(document.form2.ncomp.value>1){
			document.form2.oculto.value=1;
			document.form2.ncomp.value=document.form2.ncomp.value-1;
			document.form2.idcomp.value=document.form2.idcomp.value-1;
			var idcta=document.getElementById('ncomp').value;
			document.form2.action="teso-editasinrecaudos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			document.form2.submit();
 		}
	}

	function iratras(scrtop, numpag, limreg, filtro){
		var idcta=document.getElementById('ncomp').value;
		location.href="teso-buscasinrecaudos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
	}
</script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta">
  <a href="teso-sinrecaudos.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> 
  <a href="#" class="mgbt1"><img src="imagenes/guardad.png"  alt="Guardar" /></a>
  <a href="teso-buscasinrecaudos.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" /></a> 
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a> 
  <a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" /></a> 
  <a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
	$check1="checked";
	$fec=date("d/m/Y");	
	$_POST[vigencia]=$vigencia;
$linkbd=conectar_bd();
	$sqlr="select *from cuentacaja where estado='S' and vigencia=".$vigusu;
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[1];
	}
	
	 $link=conectar_bd();
$sqlr="select * from tesosinrecaudos ORDER BY id_recaudo DESC";
$res=mysql_query($sqlr,$link);
//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
	 $_POST[ncomp]=$_GET[idrecaudo];
		$check1="checked"; 
 		 $fec=date("d/m/Y");
//		 $_POST[fecha]=$fec; 		 		  			 
		//$_POST[valor]=0;
		//$_POST[valorcheque]=0;
		//$_POST[valorretencion]=0;
		//$_POST[valoregreso]=0;
		//$_POST[totaldes]=0;
		 $_POST[vigencia]=$vigusu; 		
		$sqlr="select * from tesosinrecaudos where id_recaudo=".$_POST[ncomp];
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		 $_POST[fecha]=$r[2];
		 $_POST[compcont]=$r[1];
		  $consec=$r[0];	  
		  $_POST[rp]=$r[4];
	 	}
	 	$_POST[idcomp]=$consec;	
		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		$_POST[fecha]=$fechaf;	
}
$linkbd=conectar_bd();
	$sqlr="select *from tesosinrecaudos where tesosinrecaudos.id_recaudo=$_POST[idcomp] ";
  //echo "$sqlr";
  	  $_POST[encontro]="";
  $res=mysql_query($sqlr,$linkbd);
//  echo $sqlr;
	while ($row =mysql_fetch_row($res)) 
	{
	  $_POST[concepto]=$row[6];	
	  $_POST[valorecaudo]=$row[5];	
	  $_POST[totalc]=$row[5];	
	  $_POST[tercero]=$row[4];	
	  $_POST[ntercero]=buscatercero($row[4]);	
	  //	 $_POST[idcomp]=$row[0];
		 	 $_POST[fecha]=$row[2];
 	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	 $_POST[fecha]=$fechaf;
		 $_POST[valor]=0;		 	
	  $_POST[encontro]=1;
	  $_POST[numerocomp]=$row[1];
	  if($row[7]=='S')
		 $_POST[estadoc]='ACTIVO'; 	 				  
		 if($row[7]=='P')
		 $_POST[estadoc]='PAGO'; 	 				  
		 if($row[7]=='N')
		 $_POST[estadoc]='ANULADO'; 
	}
	/*$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='2' and EXTRACT(YEAR FROM fecha)=".$vigusu;
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;*/

switch($_POST[tabgroup1])
{
case 1:
$check1='checked';
break;
case 2:
$check2='checked';
break;
case 3:
$check3='checked';
}
?>
<form name="form2" method="post" action=""> 
	<table class="inicio" align="center" >
     	<tr >
        	<td style="width:95%;" class="titulos" colspan="2">Liquidar Ingresos Propios</td>
        	<td style="width:5%;" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
		<tr>
			<td>
				<table>
						<tr >
								<td style="width:7%;" class="saludo1" >Numero Liquidacion:</td>
								<td style="width:12%;" > 
									<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
									<input type="hidden" id="numerocomp" name="numerocomp" value="<?php echo $_POST[numerocomp]?>" >
									<input id="idcomp" name="idcomp" type="text" style="width:40%" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  readonly> 
									<input id="ncomp" name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"><input name="compcont" type="hidden" value="<?php echo $_POST[compcont]?>">
									<a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
									<input type="hidden" value="a" name="atras" >
									<input type="hidden" value="s" name="siguiente" >
									<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
								</td>
								<td style="width:2.5cm" class="saludo1">Fecha:        </td>
								<td style="width:10%" >
									<input name="fecha" type="text"  onKeyDown="mascara(this,'/',patron,true)"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fecha]?>" style="width:100%" maxlength="10" readonly>        
								</td>
								<td style="width:2.5cm" class="saludo1">Vigencia:</td>
								<td style="width:10%">
									<input type="text" id="vigencia" name="vigencia"  onKeyPress="javascript:return solonumeros(event)" 
							  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly> 
								</td>
								<td style="width:2.5cm" class="saludo1">Estado</td>
								<td style="width:10%" >
									<?php 
	                  				if($_POST[estadoc]=="ACTIVO"){
				                    	$valuees="ACTIVO";
				                    	$stylest="width:100%; background-color:#0CD02A; color:white; text-align:center;";
				                    }else if($_POST[estadoc]=="ANULADO"){
				                    	$valuees="ANULADO";
				                    	$stylest="width:100%; background-color:#FF0000; color:white; text-align:center;";
				                    }else if($_POST[estadoc]=="PAGO"){
				                    	$valuees="PAGO";
				                    	$stylest="width:100%; background-color:#0404B4; color:white; text-align:center;";
				                    }

				                    echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
                  				?>
								</td>     
							</tr>
							<tr>
								<td  class="saludo1">Concepto Liquidacion:</td>
								<td colspan="7" >
									<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%" readonly >
								</td>
							</tr>  
							<tr>
								<td  class="saludo1">CC/NIT: </td>
								<td style="width:10%;">
									<input  style="width:80%;" name="tercero" type="text" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>"  readonly>
									<a href="#" onClick="mypop=window.open('terceros-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
								</td>
								<td class="saludo1">Contribuyente:
								</td>
								<td colspan="5"  >
									<input  style="width:100%;" type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>"  onKeyUp="return tabular(event,this) "  readonly>
									<input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
									<input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
									<input type="hidden" value="1" name="oculto">
								</td>
						 
						   </tr>
						  <tr>
							<td class="saludo1">Cod Ingreso:</td>
							<td colspan="3">
								<input  style="width:26%;" name="codingreso" type="text" id="codingreso" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[codingreso]?>"  readonly > <a href="#" onClick="mypop=window.open('ingresos-ventana.php?ti=I&modulo=4','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"> 
								<input style="width:66%;" name="ningreso" type="text" id="ningreso" value="<?php echo $_POST[ningreso]?>"  readonly>
							</a>
							</td>
							<td class="saludo1" >Valor:</td>
							<td>
								<input name="valor" type="text" id="valor" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valor]?>" readonly ></td><td colspan="2">
								<input  type="button" name="agregact" value="Agregar" onClick="agregardetalle()">
								<input type="hidden" value="0" name="agregadet">
							</td>
						</tr>
						  
				</table>
			</td>
			<td colspan="2" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>
		</tr>
      </table>
     <div class="subpantalla">
       <?php 
  $sqlr="select *from tesosinrecaudos_det where tesosinrecaudos_det.id_recaudo=$_POST[idcomp]";
		 $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 		 
		 $_POST[dvalores]= array(); 		 
  $res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	$_POST[dcoding][]=$row[2];	
	$_POST[dncoding][]=buscaingreso($row[2]);			 		
    $_POST[dvalores][]=$row[3];	
	}
 ?>

	   <table class="inicio">
			<tr>
				<td colspan="4" class="titulos">Detalle Liquidacion Recaudos</td>
			</tr>                  
			<tr>
				<td style="width:5%;" class="titulos2">Codigo</td>
				<td style="width:82%;" class="titulos2">Ingreso</td>
				<td style="width:10%;" class="titulos2">Valor</td>
				<td style="width:3%;" class="titulos2"><img src="imagenes/del.png" >
					<input type='hidden' name='elimina' id='elimina'>
				</td>
			</tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];		  
 		 unset($_POST[dcoding][$posi]);	
 		 unset($_POST[dncoding][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  		 
		 $_POST[dcoding]= array_values($_POST[dcoding]); 		 
		 $_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcoding][]=$_POST[codingreso];
		 $_POST[dncoding][]=$_POST[ningreso];			 		
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.codingreso.value="";
				document.form2.valor.value="";	
				document.form2.ningreso.value="";				
				document.form2.codingreso.select();
		  		document.form2.codingreso.focus();	
		 </script>
		  <?php
		  }
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcoding]);$x++)
		 {		 
		 echo "<tr>
					<td class='saludo1'>
						<input style='width:100%;'  name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text'  readonly></td><td class='saludo1'>
						<input style='width:100%;' name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text'  readonly>
					</td>
					<td class='saludo1'>
						<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' style='width:100%;' readonly>
					</td>
					<td class='saludo1'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a>
					</td>
				</tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2);
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr>
					<td>
					</td>
					<td class='saludo2'>Total
					</td>
					<td class='saludo1'>
						<input style='width:100%;' name='totalcf' type='text' value='$_POST[totalcf]' readonly>
						<input style='width:100%;' name='totalc' type='hidden' value='$_POST[totalc]'>
					</td>
				</tr>
				<tr>
					<td class='saludo1'>Son:
					</td>
					<td  >
						<input name='letras' type='text' value='$_POST[letras]' style='width:100%;'>
					</td>
				</tr>";
		?> 
	   </table></div>
	  <?php
/*if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$consec=0;
	$sqlr="select * from comprobante_cab where id_comp=$_POST[numerocomp] and tipo_comp='2' and EXTRACT(YEAR FROM fecha)=".$vigusu;
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;
//***cabecera comprobante
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,2,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);
	$idcomp=mysql_insert_id();
	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo=".$_POST[dcoding][$x];
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
	    //**** busqueda concepto contable*****
		 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
	 	 $resc=mysql_query($sqlrc,$linkbd);	  
		 	//	echo "con: $sqlrc <br>";	      
		while($rowc=mysql_fetch_row($resc))
		 {
			  $porce=$rowi[5];
			if($rowc[6]=='S')
			  {				 
				$valordeb=$_POST[dvalores][$x]*($porce/100);
				$valorcred=0;
			  }
			  else
			   {
				$valorcred=$_POST[dvalores][$x]*($porce/100);
				$valordeb=0;				   
			   }
			   
	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('2 $consec','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Causacion ".$_POST[dncoding][$x]."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
	mysql_query($sqlr,$linkbd);
	//echo "Conc: $sqlr <br>";
		 }
		 }
	}	
	//************ insercion de cabecera recaudos ************

	$sqlr="insert into tesosinrecaudos (id_comp,fecha,vigencia,tercero,valortotal,concepto,estado) values($idcomp,'$fechaf',".$vigusu.",'$_POST[tercero]','$_POST[totalc]','$_POST[concepto]','S')";	  
	mysql_query($sqlr,$linkbd);
	$idrec=mysql_insert_id();
	//************** insercion de consignaciones **************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
	$sqlr="insert into tesosinrecaudos_det (id_recaudo,ingreso,valor,estado) values($idrec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	  
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurri� el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  		else
  		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recaudo con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php
		  }
	}	  
}*/
?>	
</form>
 </td></tr>
</table>
</body>
</html> 		