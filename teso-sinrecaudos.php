<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
//session_start();
sesion();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function validar()
{
document.form2.submit();
}
</script>
<script>
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function agregardetalle()
{
if(document.form2.codingreso.value!="" &&  parseFloat(document.form2.valor.value)>0 && document.form2.cc.value!="")
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
</script>
<script>
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar()
{
ingresos2=document.getElementsByName('dcoding[]');
if (document.form2.fecha.value!='' && ingresos2.length>0)
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
</script>
<script>
function pdf()
{
document.form2.action="teso-pdfrecaudos.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script>
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function buscaing(e)
 {
if (document.form2.codingreso.value!="")
{
 document.form2.bin.value='1';
 document.form2.submit();
 }
 }
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-sinrecaudos.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> 
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a>
			<a href="teso-buscasinrecaudos.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a> 
			<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()"  <?php } ?> class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" /></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$linkbd=conectar_bd();
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if($_POST[oculto]=="")
{
 $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 		 
		 $_POST[dvalores]= array();
	$check1="checked";
	$fec=date("d/m/Y");
	$_POST[vigencia]=$vigusu;

	$sqlr="select *from cuentacaja where estado='S' and vigencia=".$vigusu;
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[1];
	}
	/*$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";	
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cobrorecibo]=$row[0];
	 $_POST[vcobrorecibo]=$row[1];
	 $_POST[tcobrorecibo]=$row[2];	 
	// echo $sqlr;
	}
	 if($_POST[tcobrorecibo]=='S')
		 {	 
		 $_POST[dcoding][]=$_POST[cobrorecibo];
		 $_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
    	 $_POST[dvalores][]=$_POST[vcobrorecibo];
		// echo $sqlr;
		 }*/
	/*$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='2' and EXTRACT(YEAR FROM fecha)=".$_SESSION["vigencia"];
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;*/
	 $sqlr="select max(id_recaudo) from tesosinrecaudos ";
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;
	 $_POST[idcomp]=$consec;	
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 		 		  			 
		 $_POST[valor]=0;		 
}
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
 <?php
 //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
//******** busca ingreso *****
//***** busca tercero
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingreso($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ningreso]="";
			  }
			 }
			 
 ?>
 

    <table class="inicio" align="center" >
      	<tr >
        	<td style="width:95%;" class="titulos" colspan="2">Liquidar Recaudos</td>
        	<td style="width:5%;" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
			<td>
				<table>
					<tr  >
						<td style="width:12%;" class="saludo1" >Numero Liquidacion:</td>
						<td  style="width:7%;" >
							<input name="idcomp" type="text"  value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  readonly>
						</td>
						<td style="width:5%;"  class="saludo1">Fecha:        </td>
						<td  style="width:10%;">
							<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" style="width:80%;" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> 
							<a href="#" onClick="displayCalendarFor('fc_1198971545');">
								<img src="imagenes/buscarep.png" align="absmiddle" border="0">
							</a>         
						</td>
						<td style="width:5%;" class="saludo1">Vigencia:</td>
						<td style="width:10%;">
							<input type="text" id="vigencia" name="vigencia"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:40%;" value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>
						</td>
						<td style="width:10%;" class="saludo1">Causacion Contable:</td>
						<td style="width:10%;">
							<select name="causacion" id="causacion" onKeyUp="return tabular(event,this)"  >
								<option value="1" <?php if($_POST[causacion]=='1') echo "SELECTED"; ?>>Si</option>
								<option value="2" <?php if($_POST[causacion]=='2') echo "SELECTED"; ?>>No</option>         
							</select>
						</td> 	
						<td class="saludo1">Centro Costo:</td>
						<td>
							<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%;">
								<option value="">Seleccione ...</option>
								<?php
									$sqlr="select *from centrocosto where estado='S' order by id_cc	";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										if("$row[0]"==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
										else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
									}	 	
								?>
							</select>
						</td>	
					</tr>
					<tr>
						<td class="saludo1">Concepto Liquidacion:</td>
						<td colspan="9" >
							<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%;"  onKeyUp="return tabular(event,this)">
						</td>
					</tr>  
					<tr>
						<td class="saludo1">Contribuyente: </td>
						<td>
							<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="buscater(event)"> 
							<a href="#" onClick="mypop=window.open('terceros-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
								<img src="imagenes/buscarep.png" align="absmiddle" border="0">
							</a>
						</td>
						<td colspan="8">
							<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%;" onKeyUp="return tabular(event,this) "  readonly>
							<input type="hidden" value="0" name="bt">
							<input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
							<input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
							<input type="hidden" value="1" name="oculto" id="oculto">
							<input name="cobrorecibo" type="hidden" value="<?php echo $_POST[cobrorecibo]?>" >
							<input name="vcobrorecibo" type="hidden" value="<?php echo $_POST[vcobrorecibo]?>" >
							<input name="tcobrorecibo" type="hidden" value="<?php echo $_POST[tcobrorecibo]?>" > 
						</td>
				 
					</tr>
					<tr>
						<td class="saludo1">Cod Ingreso:</td>
						<td>
							<input type="text" id="codingreso" name="codingreso" value="<?php echo $_POST[codingreso]?>" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="buscaing(event)" > 
							<a href="#" onClick="mypop=window.open('ingresos-ventana.php?ti=I&modulo=4','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px'); mypop.focus();">
								<img src="imagenes/buscarep.png" align="absmiddle" border="0"> 
							</a>
						</td>
						<td colspan="8">
							<input type="hidden" value="0" name="bin">
							<input name="ningreso" type="text" id="ningreso" value="<?php echo $_POST[ningreso]?>" style="width:100%;" readonly>
						</td>
					</tr>
					<tr>
						<td class="saludo1" >Valor:</td>
						<td>
							<input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" style="width:80%;" onKeyDown ="return tabular(event,this)" >
						</td>
						<td colspan="2">
							<input  type="button" name="agregact" value="Agregar" onClick="agregardetalle()">
							<input type="hidden" value="0" name="agregadet">
						</td>
					</tr>
				</table>
			</td>
		</tr>
    </table>
       <?php
           //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
			  <script>
			  document.getElementById('codingreso').focus();document.getElementById('codingreso').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				alert("Tercero Incorrecto o no Existe")				   		  	
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
			 //*** ingreso
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingreso($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('valor').focus();document.getElementById('valor').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[codingreso]="";
			  ?>
			  <script>alert("Codigo Ingresos Incorrecto");document.form2.codingreso.focus();</script>
			  <?php
			  }
			 }
			 ?>
      
     	<div class="subpantallac7">
	   		<table class="inicio">
	   	   		<tr>
					<td colspan="4" class="titulos">Detalle Liquidacion Recaudos</td>
				</tr>                  
				<tr>
					<td class="titulos2">Codigo</td>
					<td class="titulos2">Ingreso</td>
					<td class="titulos2">Centro Costo</td>
					<td class="titulos2">Valor</td>
					<td class="titulos2">
						<img src="imagenes/del.png" >
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
		  unset($_POST[dncc][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  		 
		 $_POST[dcoding]= array_values($_POST[dcoding]); 		 
		 $_POST[dncoding]= array_values($_POST[dncoding]);
		 $_POST[dncc]= array_values($_POST[dncc]);
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcoding][]=$_POST[codingreso];
		 $_POST[dncoding][]=$_POST[ningreso];
		 $_POST[dncc][]=$_POST[cc];	
		 $_POST[valor]=str_replace(",","",$_POST[valor]);		 		
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.codingreso.value="";
				document.form2.valor.value="0";	
				document.form2.ningreso.value="";
				document.form2.cc.value="";			
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
							 <input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' size='4' readonly>
						</td>
						<td class='saludo1'>
							<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' size='90' readonly>
						</td>
						<td class='saludo1'>
							<input name='dncc[]' value='".$_POST[dncc][$x]."' type='text' size='4' readonly>
						</td>
						<td class='saludo1'>
							<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15' readonly>
						</td>
						<td class='saludo1'>
							<a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a>
						</td>
					</tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];		 
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr>
					 <td></td>
					 <td class='saludo2'>Total</td><td></td><td class='saludo1'><input name='totalcf' type='text' value='$_POST[totalcf]' readonly ><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td class='saludo1'>Son:</td><td colspan='5' ><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?> 
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	if($bloq>=1)
	{
		//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
		//***busca el consecutivo del comprobante contable
		$consec=0;
		$sqlr="select max(id_recaudo) from tesosinrecaudos" ;
		//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);
		while($r=mysql_fetch_row($res))
		{
			$consec=$r[0];	  
		}
		$consec+=1;
		if($_POST[causacion]=='2')
		{$_POST[concepto]="ESTE DOCUMENTO NO REQUIERE CAUSACION CONTABLE - ".$_POST[concepto];}
		//***cabecera comprobante
		$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,26,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'1')";
		mysql_query($sqlr,$linkbd);
	
		$idcomp=mysql_insert_id();
		echo "<input type='hidden' name='ncomp' value='$idcomp'>";
		//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
		if($_POST[causacion]!='2')
		{
			for($x=0;$x<count($_POST[dcoding]);$x++)
			{
				//***** BUSQUEDA INGRESO ********
				$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
				$resi=mysql_query($sqlri,$linkbd);
				//	echo "$sqlri <br>";	    
				while($rowi=mysql_fetch_row($resi))
				{
					//**** busqueda concepto contable*****
					$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cc='".$_POST[dncc][$x]."' and cuenta!='' order by fechainicial asc";
					$re=mysql_query($sq,$linkbd);
					while($ro=mysql_fetch_assoc($re))
					{
						$_POST[fechacausa]=$ro["fechainicial"];
					}
					$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and cc='".$_POST[dncc][$x]."' and fechainicial='".$_POST[fechacausa]."'";
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
			   
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('26 $consec','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Causacion ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);
						//echo "Conc: $sqlr <br>";
					}
				}
			}	
		}
			//************ insercion de cabecera recaudos ************

			$sqlr="insert into tesosinrecaudos (id_comp,fecha,vigencia,tercero,valortotal,concepto,estado,cc) values($idcomp,'$fechaf',".$vigusu.",'$_POST[tercero]','$_POST[totalc]','".strtoupper($_POST[concepto])."','S','".$_POST[cc]."')";	  
			mysql_query($sqlr,$linkbd);
	
			$idrec=mysql_insert_id(); 
			//************** insercion de consignaciones **************
			for($x=0;$x<count($_POST[dcoding]);$x++)
			{
				$sqlr="insert into tesosinrecaudos_det (id_recaudo,ingreso,valor,estado,cc) values($idrec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S','".$_POST[dncc][$x]."')";	  
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
			?>
			<script >
				pdf();
				function recarga() 
				{
				var pagina="teso-sinrecaudos.php";
				location.href=pagina;
				} 
				setTimeout ("recarga()", 1500);
			</script>
			<?php
			
	}
  else
   {
    echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
   }
  //****fin if bloqueo  
}
?>	
</form>
 </td></tr>
</table>
</body>
</html> 		