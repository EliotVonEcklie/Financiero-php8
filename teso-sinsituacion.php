<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>

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
if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
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
if (document.form2.fecha.value!='' && ingresos2.length>0 && document.form2.cc.value!='')
  {
	despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  }
  else{
	despliegamodalm('visible','2','Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
function despliegamodal2(_valor)
		{
			document.getElementById("bgventanamodal2").style.visibility=_valor;
			if(_valor=="hidden"){document.getElementById('ventana2').src="";}
			else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
		}

		function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
		{
			document.getElementById("bgventanamodalm").style.visibility=_valor;
			if(_valor=="hidden"){document.getElementById('ventanam').src="";}
			else
			{
				switch(_tip)
				{
					case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
					case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
					case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
					case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
				}
			}
		}

		function respuestaconsulta(pregunta, variable)
		{
			switch(pregunta)
			{
				case "1":	document.getElementById('oculto').value="2";
							document.form2.submit();break;
				case "2":
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
					break;
			}
		}

		function funcionmensaje(){document.location.href = "teso-editasinsituacion.php?idrecaudo="+document.getElementById('idcomp').value;}
</script>
<script>
function pdf()
{
document.form2.action="teso-pdfssf.php";
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
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-sinsituacion.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar" /></a>
			<a href="teso-buscasinsituacion.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
			<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()"  <?php } ?> class="mgbt"> <img src="imagenes/printd.png"  alt="Buscar" title="Imprimir"/></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
//$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
	$check1="checked";
	$fec=date("d/m/Y");
	$_POST[vigencia]=$vigusu;
$linkbd=conectar_bd();
	$sqlr="select VALOR_INICIAL from dominios where dominio='CUENTA_CAJA' where VALOR_FINAL='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[0];
	}
	/*$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='2' and EXTRACT(YEAR FROM fecha)=".$_SESSION["vigencia"];
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;*/
	 $sqlr="select max(id_recaudo) from tesossfingreso_cab ";
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
<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
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
			  $nresul=buscaingresossf($_POST[codingreso]);
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
        	<td style="width:95% " class="titulos" colspan="2"> Ingresos Sin Situacion de Fondos - SSF</td>
        	<td style="width:5%" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
      		<td style="width:75%;">
      			<table>
      				<tr>
			        	<td style="width:7%;" class="saludo1" >Numero Ingreso:</td>
			        	<td style="width:3%;" >
			            	<input name="idcomp" id="idcomp" type="text" style="width:40%" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  readonly>
			           	</td>
				  		<td style="width:5%;" class="saludo1">Fecha:</td>
			        	<td style="width:10%" >
			            	<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:60%" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> 
			                <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>         	</td>
			         	<td style="width:5%;" class="saludo1">Vigencia:</td>
					  	<td style="width:5%">
			            	<input type="text" id="vigencia" name="vigencia" style="width:30%" onKeyPress="javascript:return solonumeros(event)" 
					  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>      
			          	</td>
			     	</tr>       
			      	<tr>
			        	<td style="width:7%;" class="saludo1">Concepto Ingreso:</td>
			        	<td colspan="5" >
			            	<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%" onKeyUp="return tabular(event,this)">
			           	</td>
			       	</tr>  
			      	<tr>
			        	<td style="width:7%;" class="saludo1">NIT: </td>
						<td style="width:3%;">
			            	<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:85%" onKeyUp="return tabular(event,this)" onBlur="buscater(event)">
			          		<a href="#" onClick="mypop=window.open('terceros-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
			           	</td>
						
						
						
						<td class="saludo1">Contribuyente:</td>
				  		<td colspan="3">
			            	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" onKeyUp="return tabular(event,this) "  readonly>
			                <input type="hidden" value="0" name="bt">
			                <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
			                <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
				    		<input type="hidden" value="1" name="oculto" id="oculto">
			          	</td>
			       	</tr>
					
					
					
				  	<tr>
			        	<td style="width:7%;" class="saludo1">Cod Ingreso SSF:</td>
			            <td style="width:3%;">
			            	<input type="text" id="codingreso" name="codingreso" value="<?php echo $_POST[codingreso]?>" style="width:85%" onKeyUp="return tabular(event,this)" onBlur="buscaing(event)" > 
				    		<a href="#" onClick="mypop=window.open('ingresossf-ventana.php?ti=I&modulo=4','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"> </a>
			                <input type="hidden" value="0" name="bin">
			            </td>
			            <td colspan="4">
				    		<input name="ningreso" type="text" id="ningreso" value="<?php echo $_POST[ningreso]?>" style="width:100%" readonly>
				    	</td> 
					</tr>
					<tr>
			            <td style="width:7%;" class="saludo1">Centro Costo:</td>
				  		<td style="width:3%;">
							<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
							 <option value="">Seleccione ...</option>
							<?php
							$linkbd=conectar_bd();
							$sqlr="select *from centrocosto where estado='S'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
										    {
											echo "<option value=$row[0] ";
											$i=$row[0];
								
											 if($i==$_POST[cc])
									 			{
												 echo "SELECTED";
												 }
											  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
											}	 	
							?>
						   </select>
				 		</td>
			            <td class="saludo1">Valor:</td>
			            <td>
			            	<input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" style="width:50%" onKeyUp="return tabular(event,this)" >
			        		<input  type="button" name="agregact" value="Agregar" onClick="agregardetalle()">	      
			                <input type="hidden" value="0" name="agregadet">
			           	</td>
			      	</tr>
      			</table>
      		</td>
      		<td  colspan="2" style="width:25%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>  
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
			  $nresul=buscaingresossf($_POST[codingreso]);
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
      
     <div class="subpantalla">
	   <table class="inicio">
	   	   	<tr>
   	      		<td colspan="4" class="titulos">Detalle  Ingresos Sin Situacion de Fondos</td>
   	      	</tr>                  
			<tr>
				<td class="titulos2">Codigo</td>
				<td class="titulos2">Ingreso</td>
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
		 		<td style='width:5%;' class='saludo1'>
		 			<input name='dcoding[]' value='".$_POST[dcoding][$x]."' style='width:100%;' type='text' >
		 		</td>
		 		<td style='width:80%;' class='saludo1'>
		 			<input name='dncoding[]' value='".$_POST[dncoding][$x]."' style='width:100%;' type='text' >
		 		</td>
		 		<td class='saludo1'>
		 			<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' >
		 		</td>
		 		<td class='saludo1'>
		 			<a href='#' onclick='eliminar($x)'>
		 			<img src='imagenes/del.png'></a>
		 		</td>
		 	</tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2);
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr>
		 		<td style='width:5%;'>
		 		</td>
		 		<td style='width:80%;' class='saludo2'>Total</td>
		 		<td class='saludo1'>
		 			<input name='totalcf' type='text' value='$_POST[totalcf]'>
		 			<input name='totalc' type='hidden' value='$_POST[totalc]'>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td style='width:5%;' class='saludo1'>Son:</td>
		 		<td >
		 			<input name='letras' type='text' value='$_POST[letras]' style='width:100%;'>
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
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$consec=0;
	$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='20' ";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;
//***cabecera comprobante
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,20,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);	
	$idcomp=mysql_insert_id();
	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($consec,21,'$fechaf','INGRESOS SSF $_POST[concepto]',$_POST[vigencia],0,0,0,'$_POST[estadoc]')";
	  mysql_query($sqlr,$linkbd);
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresossf_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
	 	$res2=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($row2=mysql_fetch_row($res2))
		 {
	    //**** busqueda concepto contable*****		
		$sq="select fechainicial from conceptoscontables_det where codigo='".$row2[2]."' and modulo='4' and tipo='IS' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
		$re=mysql_query($sq,$linkbd);
		while($ro=mysql_fetch_assoc($re))
		{
			$_POST[fechacausa]=$ro["fechainicial"];
		}
		$sqlri="Select * from conceptoscontables_det where codigo='".$row2[2]."' and modulo=4 and tipo='IS' and fechainicial='".$_POST[fechacausa]."'";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
				if($rowi[7]=='S')
				 {
				$valorcred=$_POST[dvalores][$x];
				$valordeb=0;
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('20 $consec','".$rowi[4]."','".$_POST[tercero]."','".$_POST[cc]."','Ingreso sin Situacion de Fondos ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
	mysql_query($sqlr,$linkbd);
//					echo "<br>".$sqlr;
				 }
				if($rowi[6]=='S')
				 {
			  $valordeb=$_POST[dvalores][$x];
				$valorcred=0;				   
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('20 $consec','".$rowi[4]."','".$_POST[tercero]."','".$_POST[cc]."','Ingreso sin Situacion de Fondos ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
	//			echo "<br>".$sqlr;
				$vi=$_POST[dvalores][$x];
				 }
		 }
//			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta =".$rowi[5]."";
			//mysql_query($sqlr,$linkbd);	
				 //****creacion documento presupuesto ingresos
	//		  $sqlr="insert into pptoingtranppto (cuenta,idrecibo,valor,vigencia) values('$rowi[5]',$consec,$vi,'".$_SESSION[vigencia]."')";
  			 // mysql_query($sqlr,$linkbd);				  
		 }
	}	
	//************ insercion de cabecera recaudos ************
	$sqlr="insert into tesossfingreso_cab (idcomp,fecha,vigencia,concepto,tercero,cc,valortotal,estado) values($idcomp,'$fechaf','".$vigusu."','".strtoupper($_POST[concepto])."','$_POST[tercero]','$_POST[cc]','$_POST[totalc]','S')";	  
	mysql_query($sqlr,$linkbd);
	$idrec=mysql_insert_id();
	//echo "Conc: $sqlr <br>";
	//************** insercion de consignaciones **************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
	$sqlr="insert into tesossfingreso_det (id_recaudo,ingreso,valor,estado) values($idrec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "
									<script>
										despliegamodalm('visible','2','Manejador de Errores de la Clase BD No se pudo ejecutar la petición');
										document.getElementById('valfocus').value='2';
									</script>";
	}
  		else
  		 {
			$sqlri="Select * from tesoingresossf_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
		  $vi=$_POST[dvalores][$x];
		  $sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[5]."' AND VIGENCIA='".$vigusu."'";
		  mysql_query($sqlr,$linkbd);	
				 //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptoingssf (cuenta,idrecibo,valor,vigencia) values('$rowi[5]',$idrec,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
			  if($row2[5]!="" && $vi>0)
				{		
	 			$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$rowi[5]."','".$_POST[tercero]."','INGRESOS SSF',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',21,$_POST[idcomp],'1','1','','$fechaf')";
	 			mysql_query($sqlr,$linkbd); 			  
				}
			  
		 }			 			 
		  echo "<script>despliegamodalm('visible','1','Se ha almacenado la Liquidacion con Exito');</script>";
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php
		  }
	}	 
}
?>	
</form>
 </td></tr>
</table>
</body>
</html>