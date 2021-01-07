<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
$linkbd=conectar_bd();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Contabilidad</title>

<script language="JavaScript1.2">
	function validar(){
	document.form2.submit();
	}
	function despliegamodalm(_valor,_tip,mensa,pregunta)
	{
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden") {document.getElementById('ventanam').src="";}
		else
		{
			switch(_tip)
			{
				case "1":
					document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
				case "2":
					document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
				case "3":
					document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
				case "4":
					document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
			}
		}
	}
	function respuestaconsulta(pregunta)
	{
		switch(pregunta)
		{
			case "1":	
				document.form2.oculto.value=2;
				document.form2.submit();
			break;
		}
	}

	function funcionmensaje()
	{
	}

function guardar(){
	if (document.form2.fecha.value!=''){
		// if (confirm("Esta Seguro de Guardar")){
			// document.form2.oculto.value=2;
			// document.form2.submit();
  		// }
		despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  	}
  	else{
		// alert('Faltan datos para completar el registro');
		// document.form2.fecha.focus();
		// document.form2.fecha.select();
		despliegamodalm('visible','2','Faltan datos para completar el registro');
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
<script language="JavaScript1.2">
function adelante()
{
//   alert("Balance Descuadrado");
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="cont-recaudos-reflejar.php";
document.form2.submit();
}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{

//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {

document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.idcomp.value=document.form2.idcomp.value-1;
document.form2.action="cont-recaudos-reflejar.php";
document.form2.submit();
 }
}
</script>
<script language="JavaScript1.2">
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.idcomp.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="cont-recaudos-reflejar.php";
document.form2.submit();
}
</script>
<script src="css/programas.js"></script>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("cont");?></tr>
	<tr>
	<td colspan="3" class="cinta">
		<a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a>
		<a href="#" class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" /></a>
		<a href="cont-buscarecaudos-reflejar.php" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" title="Buscar" /></a>
		<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
		<a href="#" class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
		<a href="#" class="mgbt" onClick="guardar()"><img src="imagenes/reflejar1.png"  alt="Reflejar" title="Reflejar" style="width:24px;" /></a>
		<a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="imprimir"  title="Imprimir"/></a>
		<a href="cont-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" alt="Atras" title="Atr&aacute;s"></a>
	</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;

$sqlr="select * from admbloqueoanio";
	$res=mysql_query($sqlr,$linkbd);
	$_POST[anio]=array();
	$_POST[bloqueo]=array();
	while ($row =mysql_fetch_row($res)){
	 	$_POST[anio][]=$row[0];
	 	$_POST[bloqueo][]=$row[1];
	}
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if($_GET[consecutivo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[consecutivo];</script>";}
if(!$_POST[oculto]){
	$check1="checked";
	$fec=date("d/m/Y");	
	
	$sqlr="select * from tesorecaudos ORDER BY id_recaudo DESC";
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[maximo]=$r[0];

	if ($_POST[codrec]!="" || $_GET[consecutivo]!=""){
		if($_POST[codrec]!=""){
			$sqlr="select * from tesorecaudos WHERE ID_RECAUDO='$_POST[codrec]'";
		}
		else{
			$sqlr="select * from tesorecaudos WHERE ID_RECAUDO='$_GET[consecutivo]'";
		}
	}
	else{
		$sqlr="select * from tesorecaudos ORDER BY id_recaudo DESC";
	}
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[ncomp]=$r[0];
	$_POST[idcomp]=$r[0];
	$check1="checked"; 
 	$fec=date("d/m/Y");
	//$_POST[vigencia]=$vigusu; 		
	$sqlr="select * from tesorecaudos where id_recaudo=".$_POST[ncomp];
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res)){
 		$_POST[fecha]=$r[2];
		$_POST[compcont]=$r[1];
		$consec=$r[0];	  
		$_POST[rp]=$r[4];
	}
//	$_POST[idcomp]=$consec;	
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	$_POST[fecha]=$fechaf;
	$_POST[vigencia]=$fecha[1];
	$sqlr="select *from cuentacaja where estado='S' and vigencia=".$_POST[vigencia];
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)){
		$_POST[cuentacaja]=$row[1];
	}
}
$sqlr="select *from tesorecaudos where tesorecaudos.id_recaudo=$_POST[idcomp] ";
$_POST[encontro]="";
$res=mysql_query($sqlr,$linkbd);
while ($row =mysql_fetch_row($res)){
	$_POST[concepto]=$row[6];	
	$_POST[valorecaudo]=$row[5];	
	$_POST[valortotal]=$row[5];	
	$_POST[tercero]=$row[4];	
	$_POST[ntercero]=buscatercero($row[4]);	
	$_POST[fecha]=$row[2];
 	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	$_POST[fecha]=$fechaf;
	$_POST[vigencia]=$fecha[1];
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
<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
<form name="form2" method="post" action=""> 
<input type="hidden" name="anio[]" id="anio[]" value="<?php echo $_POST[anio] ?>">
<input type="hidden" name="anioact" id="anioact" value="<?php echo $_POST[anioact] ?>">
<input type="hidden" name="bloqueo[]" id="bloqueo[]" value="<?php echo $_POST[bloqueo] ?>">
	<table class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="8">Liquidar Recaudos</td>
        	<td style="width:7%" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
      	</tr>
     	<tr>
        	<td style="width:10%;" class="saludo1" >N&uacute;mero Liquidaci&oacute;n:</td>
        	<td style="width:10%">
            	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
                <input name="idcomp" type="text" style="width:50%" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()">
                <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
                <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
                <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" >
                <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
                <input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
         	</td>
	  		<td style="width:9%;" class="saludo1">Fecha: </td>
        	<td style="width:10%">
            	<input name="fecha" type="text"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fecha]?>"  style="width:100%" readonly>        
           	</td>
         	<td style="width:7%;" class="saludo1">Vigencia:</td>
		  	<td style="width:20%">
            	<input type="text" id="vigencia" name="vigencia" style="width:40%" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly> 
				<input name="estadoc" type="hidden" id="estadoc" value="<?php echo $_POST[estadoc] ?>" style="width:40%" readonly>
				<?php 
					if($_POST[estadoc]=="ACTIVO"){
						$valuees="ACTIVO";
						$stylest="width:40%; background-color:#0CD02A; color:white; text-align:center;";
					}else if($_POST[estadoc]=="ANULADO"){
						$valuees="ANULADO";
						$stylest="width:40%; background-color:#FF0000; color:white; text-align:center;";
					}else if($_POST[estadoc]=="PAGO"){
						$valuees="PAGO";
						$stylest="width:40%; background-color:#0404B4; color:white; text-align:center;";
					}

					echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
				?>
           	</td>
                
        </tr>
      	<tr>
        	<td  class="saludo1">Concepto Liquidaci&oacute;n:</td>
        	<td colspan="7" >
            	<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%" readonly >
           	</td>
       	</tr>  
      	<tr>
        	<td class="saludo1">CC/NIT: </td>
	        <td>
    	    	<input name="tercero" type="text" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>" style="width:100%" readonly>
			</td>
			<td class="saludo1">Contribuyente:</td>
		  	<td colspan="5">
        		<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" onKeyUp="return tabular(event,this) " readonly>
            	<input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
	            <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
			    <input type="hidden" value="1" name="oculto">
      		</td>
	   	</tr>
		<tr>
            <td class="saludo1" width="101">Valor:</td>
            <td>
            	<input name="valor" type="text" id="valor" onKeyUp="return tabular(event,this)" value="<?php echo number_format($_POST[valortotal],2,',','.')?>" style="width:100%; text-align:right" readonly >
           	</td>
		</tr>
  	</table>
    <div class="subpantalla">
      	<?php 
	   	$linkbd=conectar_bd();
   		$sqlr="select *from tesorecaudos_det where tesorecaudos_det.id_recaudo=$_POST[idcomp] ";
		$_POST[dcoding]= array(); 		 
		$_POST[dncoding]= array(); 		 
		$_POST[dvalores]= array(); 		 
  		$res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)){
			$_POST[dcoding][]=$row[2];
			$_POST[dncoding][]=buscaingreso($row[2]);			 		
    		$_POST[dvalores][]=$row[3];	
		}
 		?>
	  	<table class="inicio">
	   		<tr>
            	<td colspan="4" class="titulos">Detalle Liquidaci&oacute;n Recaudos</td>
           	</tr>                  
			<tr>
            	<td class="titulos2">C&oacute;digo</td>
                <td class="titulos2">Ingreso</td>
                <td class="titulos2">Valor</td>
          	</tr>
			<?php 		
		  	$_POST[totalc]=0;
			$iter='saludo1a';
			$iter2='saludo2';
		 	for ($x=0;$x<count($_POST[dcoding]);$x++){		 
				echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" 	onMouseOut=\"this.style.backgroundColor=anterior\">
					<td>
						<input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='hidden'>".$_POST[dcoding][$x]."
					</td>
					<td>
						<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='hidden'>".$_POST[dncoding][$x]."
					</td>
					<td align='right'>
						<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden'>".number_format($_POST[dvalores][$x],2,',','.')."
					</td>
				</tr>";
		 		$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 		$_POST[totalcf]=number_format($_POST[totalc],2);
			 	$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;	
		 	}
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 	echo "<tr class='titulos2'>
				<td></td>
				<td>Total</td>
				<td align='right'>
					<input name='totalcf' type='hidden' value='$_POST[totalcf]'>
					<input name='totalc' type='hidden' value='$_POST[totalc]'>".number_format($_POST[totalc],2,',','.')."
				</td>
			</tr>
			<tr class='titulos2'>
				<td>Son:</td>
				<td colspan='5' >
					<input name='letras' type='hidden' value='$_POST[letras]'>".strtoupper($_POST[letras])."
				</td>
			</tr>";
		?> 
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	
	
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	
	$anioact=split("/", $_POST[fecha]);
	$_POST[anioact]=$anioact[2];
	for($x=0;$x<count($_POST[anio]);$x++)
	{
		if($_POST[anioact]==$_POST[anio][$x])
		{
			if($_POST[bloqueo][$x]=='S')
			{
				$bloquear="S";
			}else
			{
				$bloquear="N";
			}
		}
	}
	if($bloquear=="N"){
		//$fechaf=$_POST[fecha];
		/*	$p1=substr($_POST[fecha],0,2);
		$p2=substr($_POST[fecha],3,2);
		$p3=substr($_POST[fecha],6,4);
		$fechaf=$p3."-".$p2."-".$p1;	*/
		$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
		if($bloq>=1)
		{
		//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
		//***busca el consecutivo del comprobante contable
		if ($_POST[estadoc]=='ANULADO')
		{
			$sqlr="update comprobante_cab set estado=0 where tipo_comp=2 and numerotipo=$_POST[idcomp]";
			mysql_query($sqlr,$linkbd);			
			$sqlr="insert into  comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total_debito,total_credito,diferencia,estado) values($_POST[idcomp],2,'$fechaf','OTROS RECAUDOS'.$_POST[concepto],0,0,0,'0')";
			mysql_query($sqlr,$linkbd);	
			$sqlr="update comprobante_det set valcredito=0, valcredito=0 where tipo_comp=2 and numerotipo=$_POST[idcomp]";
			mysql_query($sqlr,$linkbd);		
		}
		else
		{
		//	$sqlr="update comprobante_det set tercero='$_POST[tercero]' where id_comp='11 $_POST[idcomp]'";
			//$sqlr="update comprobante_cab set estado=1, fecha='$fechaf'  where tipo_comp=2 and numerotipo=$_POST[idcomp]";
			$sqlr="delete from comprobante_cab where tipo_comp='2' and numerotipo='$_POST[idcomp]'";
			mysql_query($sqlr,$linkbd);
			$sqlr="insert into  comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total_debito,total_credito,diferencia,estado) values($_POST[idcomp],2,'$fechaf','OTROS RECAUDOS $_POST[concepto]','$_POST[totalc]','$_POST[totalc]',0,'1')";
			mysql_query($sqlr,$linkbd);			
			//		echo "$sqlr <br>";	    	
			$sqlr="delete from comprobante_det where id_comp='2 $_POST[idcomp]'";
			//echo $sqlr;
			mysql_query($sqlr,$linkbd);
		//***cabecera comprobante
			//echo "<input type='hidden' name='ncomp' value='$idcomp'>";
			//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
			for($x=0;$x<count($_POST[dcoding]);$x++)
			{
				 //***** BUSQUEDA INGRESO ********
				$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=".$_POST[vigencia];
				$resi=mysql_query($sqlri,$linkbd);
				//	echo "$sqlri <br>";
                $cuentaCredito = '';
				while($rowi=mysql_fetch_row($resi))
				{
					//**** busqueda concepto contable*****
					$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
					$re=mysql_query($sq,$linkbd);
					while($ro=mysql_fetch_assoc($re))
					{
						$_POST[fechacausa]=$ro["fechainicial"];
					}
					$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
					$resc=mysql_query($sqlrc,$linkbd);	  
					//	echo "con: $sqlrc <br>";	      
					while($rowc=mysql_fetch_row($resc))
					{
						$porce=$rowi[5];
						if($rowc[6]=='S')
						{				 
							$valordeb=$_POST[dvalores][$x]*($porce/100);
							$valorcred=0;
                            $cuentaCredito = $rowc[4];
						}
						else
						{
                            if($_POST[dcoding][$x] == 'P08')
                            {
                                $valordeb=$_POST[dvalores][$x]*($porce/100);
                                $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('2 $consec','".$cuentaCredito."','".$_POST[tercero]."','".$rowc[5]."','Causacion ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",'0','1','".$_POST[vigencia]."')";
                                mysql_query($sqlr,$linkbd);
                            }
							$valorcred=$_POST[dvalores][$x]*($porce/100);
							$valordeb=0;
						}
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('2 $_POST[idcomp]','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Causacion ".$_POST[dncoding][$x]."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);
						//echo "Conc: $sqlr <br>";
					}
				}
			}
		}	

		echo "<table class='inicio'>
				<tr>
					<td class='saludo1'>
						<center>Se ha almacenado el Recaudo con Exito <img src='imagenes/confirm.png'></center>
					</td>
				</tr>
			</table>";
			?>
				<script>
					//alert("¡No se puede reflejar por Bloqueo de Fecha!");
					despliegamodalm('visible','1',"Se ha almacenado el Recaudo con Exito");
				</script>
			<?php
				  ?>
				  <script>
				  document.form2.numero.value="";
				  document.form2.valor.value=0;
				  </script>
				  <?php 
		   } 
			}
			else
			{
				?>
				<script>
					//alert("¡No se puede reflejar por Bloqueo de Fecha!");
					despliegamodalm('visible','2',"No se puede reflejar por Cierre de Año");
				</script>
				<?php

			}
}
?>	
</form>
 </td></tr>
</table>
</body>
</html> 		