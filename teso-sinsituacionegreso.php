<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
require "validaciones.inc";
session_start();
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
function buscarp(e)
 {
if (document.form2.rp.value!="")
{
 document.form2.brp.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function agregardetalle()
{
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
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
function agregardetalled()
{
if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
{ 
				document.form2.agregadetdes.value=1;
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
function eliminard(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.eliminad.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('eliminad');
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

if (document.form2.fecha.value!='')
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
function despliegamodalm(_valor,_tip,mensa,pregunta)
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
					}
				}
			}
			function funcionmensaje()
			{
				var _cons=document.getElementById('idcomp').value;
				document.location.href = "teso-editasinsituacionegreso.php?idrecaudo="+_cons;
			}
</script>
<script>
function calcularpago()
 {
	//alert("dddadadad");
	valorp=document.form2.valor.value;
	document.form2.base.value=valorp-document.form2.iva.value;
	descuentos=document.form2.totaldes.value;
	valorc=valorp-descuentos;
	document.form2.valorcheque.value=valorc;
	document.form2.valoregreso.value=valorp;
	document.form2.valorretencion.value=descuentos;	
	  	document.form2.submit();
 }
</script>
<script>
function pdf()
{
document.form2.action="pdfssfegre.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script >
function sumapagosant() 
{ 

 cali=document.getElementsByName('pagos[]');
 valrubro=document.getElementsByName('pvalores[]');
 sumar=0;
// document.form2.todos.checked=chkbox.checked;
for (var i=0;i < cali.length;i++) 
{ 
	if (cali.item(i).checked == true) 
	{
//		 alert('si'+i+' '+cali.item(i).value);
//	cali.item(i).checked = true;
	sumar=parseFloat(sumar)+parseFloat(valrubro.item(i).value);	
	
//		alert("cabio"+habdesv.item(i).value);
	}
//		alert("cabio"+habdesv.item(i).value);
} 
//  		alert("cam");
	document.form2.sumarbase.value=sumar;	
	//alert('fjfjfjfjfjf'+sumar );
	 resumar();
} 
</script>
<script >
function resumar() 
{ 
 cali=document.getElementsByName('rubros[]');
 valrubro=document.getElementsByName('dvalores[]');
 sumar=0;
// document.form2.todos.checked=chkbox.checked;
for (var i=0;i < cali.length;i++) 
{ 
	if (cali.item(i).checked == true) 
	{
//		 alert('si'+i+' '+cali.item(i).value);
//	cali.item(i).checked = true;
	sumar=parseFloat(sumar)+parseFloat(valrubro.item(i).value);	
//		alert("cabio"+habdesv.item(i).value);
	}
//		alert("cabio"+habdesv.item(i).value);
} 
//  		alert("cam");
			if(document.form2.regimen.value==1)
			 document.form2.iva.value=Math.round(sumar-sumar/(1.16));	
			 else
			 document.form2.iva.value=0;	
			document.form2.base.value=sumar-document.form2.iva.value+parseFloat(document.form2.sumarbase.value);	
document.form2.totalc.value=sumar;
document.form2.valor.value=sumar;
document.form2.valoregreso.value=sumar;
document.form2.valorcheque.value=document.form2.valor.value-document.form2.valorretencion.value;	
document.form2.submit();	
} 
</script>
<script>
function checktodos()
{
 cali=document.getElementsByName('rubros[]');
 valrubro=document.getElementsByName('dvalores[]');
 for (var i=0;i < cali.length;i++) 
 { 
	if (document.getElementById("todos").checked == true) 
	{
	 cali.item(i).checked = true;
 	 document.getElementById("todos").value=1;	 
	}
	else
	{
	cali.item(i).checked = false;
    document.getElementById("todos").value=0;
	}
 }	
 resumar() ;
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
	<tr class="cinta">
		<td colspan="3" class="cinta">
			<a href="teso-sinsituacionegreso.php" accesskey="n" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> 
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a>
			<a href="teso-buscasinsituacionegreso.php" accesskey="b" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> 
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>  
		</td>
	</tr>
</table>
<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 ?>	
<?php
	  //*********** cuenta origen va al credito y la destino al debito
if(!$_POST[oculto])
{
	
	$linkbd=conectar_bd();
	$sqlr="select *from cuentapagar where estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentapagar]=$row[1];
	}
		$check1="checked";
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 		 		  			 
		//$_POST[valor]=0;
		//$_POST[valorcheque]=0;
		//$_POST[valorretencion]=0;
		//$_POST[valoregreso]=0;
		//$_POST[totaldes]=0;
		// $_POST[vigencia]=$vigusu; 		
		 $_POST[vigencia]=$vigusu; 		
		 $sqlr="select max(id_ORDEN) from tesossfegreso_cab ";
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		  $consec=$r[0];	  
	 	}
	 	$consec+=1;
	 	$_POST[idcomp]=$consec;						 
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
break;
case 4:
$check4='checked';
break;
}
if($_POST[anticipo]=='S')
 {
	 $chkant=' checked ';
 }
?>
 <form name="form2" method="post" action=""> 
 <?php
 if($_POST[brp]=='1')
			 {
			  $nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
			  if($nresul!='')
			   {
			  $_POST[cdp]=$nresul;
			  //*** busca detalle cdp
			  $linkbd=conectar_bd();
  				$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo,pptorp.tercero, pptocdp.objeto from pptorp,pptocdp where pptorp.estado='S' and pptorp.idcdp=pptocdp.consvigencia and pptorp.consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] AND pptocdp.tipo_mov='201' AND pptorp.tipo_mov='201' AND pptocdp.vigencia=pptorp.vigencia order by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";
				//echo $sqlr;
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[detallecdp]=$row[2];
				$_POST[tercero]=$row[7];
				$_POST[ntercero]=buscatercero($_POST[tercero]);
				$_POST[regimen]=buscaregimen($_POST[tercero]);			
				$_POST[valorrp]=$row[5];
				$_POST[saldorp]=generaSaldoRP($_POST[rp],$_POST[vigencia]);
				$_POST[valor]=$row[6];
				if($_POST[regimen]==1)
				 $_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);	
				 else
				 $_POST[iva]=0;			
				 $_POST[base]=$_POST[valor]-$_POST[iva];				 
				$_POST[detallegreso]=$row[8];
				$_POST[valoregreso]=$_POST[valor];
				$_POST[valorretencion]=$_POST[totaldes];
				$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
				$_POST[valorcheque]=number_format($_POST[valorcheque],2);				
			  }
			 else
			 {
			  $_POST[cdp]="";
			  $_POST[detallecdp]="";
			  $_POST[tercero]="";
			  $_POST[ntercero]="";
			  }
			 }
 //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  $_POST[regimen]=buscaregimen($_POST[tercero]);	
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				if($_POST[regimen]==1)
				 $_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);	
				 else
				 $_POST[iva]=0;	
				 $_POST[base]=$_POST[valor]-$_POST[iva];				 
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
 
 ?>
    <table class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="12">Egreso SSF</td>
        	<td class="cerrar" >
        		<a href="teso-principal.php">Cerrar</a>
        	</td>
      	</tr>
      	<tr >
		    <td style="width:11%;" class="saludo1" >Numero Egreso SSF:</td>
        	<td style="width:15%;">
        		<input name="idcomp" type="text" style="width:90%;" value="<?php echo $_POST[idcomp]?>" readonly> 
        	</td>
			<td style="width:8%;" class="saludo1">Fecha: </td>
        	<td style="width:15%;">
        		<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   
        		<a href="#" onClick="displayCalendarFor('fc_1198971545');">
        			<img src="imagenes/buscarep.png" align="absmiddle" border="0">
        		</a>     
        	</td>
	  		<td style="width:8%;" class="saludo1">Vigencia: </td>
        	<td style="width:10%;" >
        		<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> 
        	</td>
        </tr>
        <tr>
        	<td style="width:11%;" class="saludo1">Registro:</td>
        	<td style="width:15%;">
        		<input name="rp" type="text" style="width:80%;" value="<?php echo $_POST[rp]?>"  onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" >
        		<input type="hidden" value="0" name="brp">
            	<a href="#" onClick="mypop=window.open('registro-ventana.php?vigencia=<?php echo $_POST[vigencia]?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();">
            		<img src="imagenes/buscarep.png" align="absmiddle" border="0">
            	</a>        
            </td>
	  		<td style="width:8%;" class="saludo1">CDP:</td>
	  		<td style="width:15%;">
				<input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>"  readonly>
			</td>
	  		<td style="width:8%;" class="saludo1">Detalle RP:</td>
	  		<td colspan="7">
				<input type="hidden" name="saldorp" id="saldorp" value="<?php echo $_POST[saldorp];?>">
				<input type="text" id="detallecdp" name="detallecdp" style="width:100%;" value="<?php echo $_POST[detallecdp]?>"  readonly>
			</td>
		</tr> 
	  	<tr>
	  		<td style="width:11%;" class="saludo1">Centro Costo:</td>
	  		<td style="width:15%;">
				<select name="cc"  onChange="validar()" style="width:90%;" onKeyUp="return tabular(event,this)" >
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
	     	<td style="width:8%;" class="saludo1">Tercero:</td>
          	<td style="width:15%;" >
          		<input id="tercero" type="text" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" >
          		<input type="hidden" value="0" name="bt">
          			<a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();">
          				<img src="imagenes/buscarep.png" align="absmiddle" border="0">
          			</a>
           	</td>
          	<td colspan="6">
          		<input  id="ntercero" style="width:100.5%;"  name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>"  readonly>
          	</td>
        </tr>
        <tr>
        	<td style="width:11%;" class="saludo1">Detalle Orden de Pago:</td>
        	<td colspan="8">
				<input type="text" id="detallegreso" name="detallegreso" style="width:100.45%;" value="<?php echo $_POST[detallegreso]?>" >
			</td>
		</tr>
	  	<tr>
	  		<td style="width:11%;" class="saludo1">Valor RP:</td>
	  		<td style="width:15%;">
	  			<input type="text" id="valorrp" name="valorrp" style="width:90%;" value="<?php echo $_POST[valorrp]?>" onKeyUp="return tabular(event,this)" readonly>
	  		</td>
	  		<td style="width:8%;" class="saludo1" >Valor a Pagar:</td>
	  		<td style="width:15%;">
	  			<input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>"  readonly> 
	  			<input type="hidden" value="1" name="oculto">
	  		</td>
	  		<td style="width:8%;" class="saludo1" >Base:</td>
	  		<td style="width:10%;">
	  			<input type="hidden" id="base" name="base" value="<?php echo $_POST[base]?>" onKeyUp="return tabular(event,this)" onChange='calcularpago()' readonly> 
	  		</td>
	  		<td style="width:8%;" class="saludo1" >Iva:</td>
	  		<td>
	  			<input type="hidden" id="iva" name="iva" value="<?php echo $_POST[iva]?>"  onKeyUp="return tabular(event,this)" onChange='calcularpago()' onBlur="calcularpago()" > 
	  			<input type="hidden" id="regimen" name="regimen" value="<?php echo $_POST[regimen]?>" >
	  		</td>
	  	</tr>
    </table>
      <?php
	  if(!$_POST[oculto])
	   {
		?>
         <script>
			  document.form2.fecha.focus();
			 document.form2.fecha.select();</script>
        <?php   
		}
	  ?>
      		
      <?php
		 //***** busca tercero
			 if($_POST[brp]=='1')
			 {
			  $nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
			  if($nresul!='')
			   {
			  $_POST[cdp]=$nresul;
  				?>
			  <script>
			  document.getElementById('cc').focus();
			   document.getElementById('cc').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[cdp]="";
			  ?>
			  <script>
				 alert("Registro Presupuestal Incorrecto");
				 document.form2.rp.select();
		  		//document.form2.rp.focus();	
			  </script>
			  <?php
			  }
			 }
			 
			  if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  $_POST[regimen]=buscaregimen($_POST[tercero]);	
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
			  if($_POST[regimen]==1)
				 $_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);	
				 else
				 $_POST[iva]=0;	
				 $_POST[base]=$_POST[valor]-$_POST[iva];
  				?>
			  <script>
			  document.getElementById('detallegreso').focus();document.getElementById('detallegreso').select();</script>
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
			?>  	      
	  <div class="subpantallac2">
      <?php
	  if($_POST[brp]=='1')
	  {
		  $_POST[brp]=0;
	  //*** busca contenido del rp
	  $_POST[dcuentas]=array();
  	  $_POST[dncuentas]=array();
	  $_POST[dvalores]=array();
	  $_POST[drecursos]=array();
	  $_POST[dnrecursos]=array();	  	  
	  $_POST[rubros]=array();	
	  $_POST[dcodssf]=array();  	
	  $_POST[dcodssfnom]=array();  	  
	  $sqlr="select *from pptorp_detalle where pptorp_detalle.consvigencia=(select pptorp.consvigencia from pptorp where consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] ) and pptorp_detalle.vigencia=$_POST[vigencia]";
	  //echo $sqlr;
	  $res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	  $_POST[dcuentas][]=$r[3];
	  $_POST[dvalores][]=generaSaldoRPxcuenta($r[2],$r[3],$_POST[vigencia]);
	   $_POST[dncuentas][]=buscacuentapres($r[3],2);	   
	   $_POST[rubros][]=$r[3];	   
	   $ind=substr($r[3],0,1);
	   $codssf=buscacodssf($r[3],$vigusu);
	   $nomcodssf= buscacodssfnom($codssf);
	   $_POST[dcodssf][]=$codssf;
	   $_POST[dcodssfnom][]=$codssf." - ".$nomcodssf;
//	   echo "i".$ind;
			if($ind=='R' || $ind=='r')
					 {						
					$ind=substr($r[3],1,1);						  
					 }	
			  if ($ind=='2')
			  $sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldoscdprp,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.cuenta='$r[3]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo and pptocuentaspptoinicial.vigencia=".$_POST[vigencia]."";
			  if ($ind=='3' || $ind=='4')
			  $sqlr="select pptocuentas.futfuenteinv,pptocuentaspptoinicial.saldoscdprp,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.cuenta='$r[3]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv and pptocuentaspptoinicial.vigencia=".$_POST[vigencia]."";
			  //echo $sqlr;
			  $res2=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res2);
    if($row[1]!='' || $row[1]!=0)
			     {
				  $_POST[drecursos][]=$row[0];
				  $_POST[dnrecursos][]=$row[2];
				//  $_POST[valor]=$row[1];			  
				 }
				 else
				  {
				  $_POST[drecurso][]="";
				  $_POST[dnrecurso][]="";
				  }	 
				  
		 }
	  }
	  ?>
	   <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
       <?php
	   if($_POST[todos]==1)
	    $checkt='checked';
		else
	    $checkt='';
	   ?>
		<tr><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Recurso</td><td class="titulos2">Cod SSF</td><td class="titulos2">Valor</td><td class="titulos2"><input type="checkbox" id="todos" name="todos" onClick="checktodos()" value="<?php echo $_POST[todos]?>" <?php echo $checkt ?>><input type='hidden' name='elimina' id='elimina'  ></td></tr>
<?php
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 {		
		 $chk=''; 
		$ch=esta_en_array($_POST[rubros],$_POST[dcuentas][$x]);
			if($ch=='1')
			 {
			 $chk="checked";
			 //echo "ch:$x".$chk;
			 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
			// $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
			 }
			
		 echo "<tr><td class='saludo2'><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='80' readonly></td><td class='saludo2'><input name='drecursos[]' value='".$_POST[drecursos][$x]."' type='hidden' ><input name='dnrecursos[]' value='".$_POST[dnrecursos][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input type='hidden' name='dcodssf[]' value='".$_POST[dcodssf][$x]."'><input type='text' name='dcodssfnom[]' value='".$_POST[dcodssfnom][$x]."' readonly></td><td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='20' onDblClick='llamarventanaegre(this,$x);' ></td><td class='saludo2'><input type='checkbox' name='rubros[]' value='".$_POST[dcuentas][$x]."' onClick='resumar()' $chk></td></tr>";
		 }
		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." PESOS M/CTE";
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
	    echo "<tr><td colspan='3'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]' readonly><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td  class='saludo1'>Son:</td> <td colspan='5' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?>
        <script>
        document.form2.valor.value=<?php echo $_POST[totalc];?>;
        document.form2.valoregreso.value=<?php echo $_POST[totalc];?>;		
        document.form2.valorcheque.value=document.form2.valor.value-document.form2.valorretencion.value;		
		//calcularpago();
        </script>
	   </table></div>
	  <?php
	  //echo "oc:".$_POST[oculto];
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	//if($bloq>=1)
	//{
	 $sqlr="select count(*) from tesossfegreso_cab where id_orden=$_POST[idcomp] ";
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		while($r=mysql_fetch_row($res))
		 {
			$numerorecaudos=$r[0];
		 }
	  if($numerorecaudos==0)
	   { 	
//************CREACION DEL COMPROBANTE CONTABLE ************************
//***busca el consecutivo del comprobante contable
	$consec=0;
	$sqlr="select max(id_orden) from tesossfegreso_cab";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;
//***cabecera comprobante SSF GASTO
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,21,'$fechaf','$_POST[detallegreso]',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);
	$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito, diferencia,estado) values($consec,13,'$fechaf','EGRESO SSF',$vigusu,$_POST[valor],0,0,'1')";
	mysql_query($sqlr,$linkbd);	
	//echo "<br>$sqlr ";
//	$idcomp=mysql_insert_id();
	$_POST[idcomp]=$idcomp;
	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	//******************* DETALLE DEL COMPROBANTE CONTABLE  *********************
	for ($y=0;$y<count($_POST[rubros]);$y++)
	{
		for($x=0;$x<count($_POST[dcuentas]);$x++)
		{
			if($_POST[dcuentas][$x]==$_POST[rubros][$y])  
			{
				//***BUSCAR CUENTA PPTAL ***************
				$sqlr="select * from tesoingresossf_det where cuentapresgas='".$_POST[dcuentas][$x]."' and vigencia=".$_POST[vigencia];
				$resp=mysql_query($sqlr,$linkbd);
				//echo "<br>$sqlr ";
				//******ACTUALIZACION DE CUENTA PPTAL CUENTAS X PAGAR ************			
				while($row=mysql_fetch_row($resp))
				{
					$codingressf=$row[2];
					//******** CONCEPTO DE GASTO SSF *****		
					$sq="select fechainicial from conceptoscontables_det where codigo=".$row[3]." and modulo='4' and tipo='GS' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
					$re=mysql_query($sq,$linkbd);
					while($ro=mysql_fetch_assoc($re))
					{
						$_POST[fechacausa]=$ro["fechainicial"];
					}
					$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$row[3]." and tipo='GS' and cc='$_POST[cc]' and fechainicial='".$_POST[fechacausa]."'";
					$resc=mysql_query($sqlrc,$linkbd);   
					//echo "<br>$rowc[5]   -   $sqlrc ";
					while($rowc=mysql_fetch_row($resc))
					{	   
						//	echo "<br>$rowc[5]";
						//******buscar CONCEPTO CONTABLE DE PAGO
						//**** CUENTA COntables*****				
						if ($rowc[3]=='N')
						{
							//****no es  NOMINA
							if($rowc[6]=='N' )
							{
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('21 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','GASTO SSF".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
								mysql_query($sqlr,$linkbd);
								$cuentagastocredito=$rowc[4];
							}
							if($rowc[7]=='N' )
						    {
								//	echo "<br>".$sqlr;
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('21 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','GASTO SSF".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
								mysql_query($sqlr,$linkbd);			
								//echo "<br>".$sqlr;
							}					
							//echo "<br>Cuenta: $cuentagastocredito - ".$sqlr ;
						}

					}//****FIN CONCEPTO GASTO
					//***** BUSCA CONCEPTO INGRESO SSF
					$sq="select fechainicial from conceptoscontables_det where codigo=".$codingressf." and modulo='4' and tipo='IS' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
					$re=mysql_query($sq,$linkbd);
					while($ro=mysql_fetch_assoc($re))
					{
						$_POST[fechacausa]=$ro["fechainicial"];
					}
					$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$codingressf." and tipo='IS' and cc='$_POST[cc]' and fechainicial='".$_POST[fechacausa]."'";
					//echo $sqlrc;
					$resc=mysql_query($sqlrc,$linkbd);   
					//echo "<br>$rowc[5]   -   $sqlrc ";
					while($rowc=mysql_fetch_row($resc))
					{	   
						$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$rowc[4]."','".$_POST[tercero]."','EGRESO SSF ',0,".$_POST[dvalores][$x].",1,'$vigusu',13,'$consec',1,'1','','$fechaf')";
				  		mysql_query($sqlr,$linkbd); 
						//echo "<br>$sqlr ";
						//	echo "<br>$rowc[5]";
						//******buscar CONCEPTO CONTABLE DE PAGO
						//**** CUENTA COntables*****		
						// echo $rowc[3];
						if ($rowc[3]=='N')
						{
							//****no es  NOMINA
							$ncuent=buscacuenta($rowc[4]);	
							if($rowc[6]=='S')
						    {
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('21 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','EGRESO SSF ".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
								mysql_query($sqlr,$linkbd);
							}
							//$ncuent=buscacuenta($rowc[4]);	
							if($rowc[7]=='N' )
						    {
								//	echo "<br>".$sqlr;
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('21 $consec','".$cuentagastocredito."','".$_POST[tercero]."','".$_POST[cc]."','GASTO SSF ".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
								mysql_query($sqlr,$linkbd);
								//echo "<br>".$sqlr;
							}				
							//				echo "<br>".$sqlr;	
						}

					} //***** FIN CONCEPTO INGRESO
				}
			}
		}
	}	
	//**************FIN DE CONTABILIDAD	


	//**************PPTO AFECTAR LAS CUENTAS PPTALES CAMPO CxP
		 for ($y=0;$y<count($_POST[rubros]);$y++)
		  {
		for($x=0;$x<count($_POST[dcuentas]);$x++)
		 {	
		  if($_POST[dcuentas][$x]==$_POST[rubros][$y])
			  {
			$sqlr2="update pptorp_detalle set saldo=saldo-".$_POST[dvalores][$x]." where cuenta='".$_POST[dcuentas][$x]."' and consvigencia=".$_POST[rp]." and vigencia=".$vigusu;
			$res2=mysql_query($sqlr2,$linkbd); 
				 //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptoegressf (cuenta,idrecibo,valor,vigencia) values('".$_POST[dcuentas][$x]."',$consec,".$_POST[dvalores][$x].",'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
		//	echo "<br>$sqlr2";
			  }
		   }
		 }
		 //***ACTUALIZACION  DEL REGISTRO
		 $sqlr="update pptorp set saldo=saldo-".$_POST[valoregreso]." where consvigencia=".$_POST[rp]." and vigencia=".$vigusu;
			$res=mysql_query($sqlr,$linkbd); 
		 //*****
	///*******INCIO DE TABLAS DE TESORERIA **************
	//**** ENCABEZADO ORDEN DE PAGO
	
	$sqlr="insert into tesossfegreso_cab (id_comp,fecha,vigencia,id_rp,cc,tercero,conceptorden,valorrp,saldo,valorpagar,cuentapagar,valorretenciones,estado,base,iva,anticipo) values($consec,'$fechaf',".$vigusu.",$_POST[rp],'$_POST[cc]','$_POST[tercero]','$_POST[detallegreso]',$_POST[valorrp],0,$_POST[totalc],'$_POST[cuentapagar]',0,'S','$_POST[base]','$_POST[iva]','$_POST[anticipo]')";	  
	mysql_query($sqlr,$linkbd);
	//echo "<br>$sqlr";
	$idorden=mysql_insert_id();
	//****** DETALLE ORDEN DE PAGO
	 for ($y=0;$y<count($_POST[rubros]);$y++)
	  {	
	for($x=0;$x<count($_POST[dcuentas]);$x++)
	 {
		  if($_POST[dcuentas][$x]==$_POST[rubros][$y])
			  {
 	  $sqlr="insert into tesossfegreso_det (id_egreso,cuentap,cc,valor,codssf,estado) values ($consec,'".$_POST[dcuentas][$x]."','".$_POST[cc]."',".$_POST[dvalores][$x].",'".$_POST[dcodssf][$x]."','S')";
//	  echo "<br>".$sqlr;
		if (!mysql_query($sqlr,$linkbd))
		{
		 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
		 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     	 echo "</pre></center></td></tr></table>";
		 }
  		else
  		 {
		  echo "<script>despliegamodalm('visible','1','Se ha almacenado el Egreso con Exito');</script>";
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  document.form2.oculto.value=1;
		  </script>
		  <?php
		  }
		}
	 }
	}
	
	}
   //}
 // else
  // {
  //  echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
   //}
  //****fin if bloqueo  
}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 