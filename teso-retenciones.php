<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
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
<script>
function buscactac(e)
 {
if (document.form2.cuentac.value!="")
{
 document.form2.bcc.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function buscactap(e)
 {
if (document.form2.cuentap.value!="")
{
 document.form2.bcp.value='1';
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
function agregardetalle()
{
if(document.form2.valor.value!="" &&  document.form2.cuenta.value!="")
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.vavlue=2;
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
	function guardar()
	{
	
	if (document.form2.nombre.value!=''&& document.form2.tipo.value!=''  && document.form2.codigo.value!='')
	  {
		  despliegamodalm('visible','4','Esta Seguro de Guardar','1');
	  }
	  else{
		despliegamodalm('visible','2','Faltan datos para completar el registro');
		document.form2.codigo.focus();
		document.form2.codigo.select();
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

		function funcionmensaje(){document.location.href = "teso-editaretenciones.php?id="+document.getElementById('codigo').value;}
	
</script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
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
  <a href="teso-retenciones.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
  <a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a> 
  <a href="teso-buscaretenciones.php" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 ?>	
<?php
if(!$_POST[oculto])
{
		$linkbd=conectar_bd();
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[tipo]='S';
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		
		  $sqlr="select  MAX(RIGHT(codigo,2)) from tesoretenciones  order by codigo Desc";
		 //echo $sqlr;
		  $res=mysql_query($sqlr,$linkbd);
		  $row=mysql_fetch_row($res);
		  $_POST[codigo]=$row[0]+1;
		  if(strlen($_POST[codigo])==1)
		   {
			   $_POST[codigo]='0'.$_POST[codigo];
			}	  
}
?>
	  <div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
 <form name="form2" method="post" action="">
<?php //**** busca cuentas
  			if($_POST[bcp]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap],1);			
			  if($nresul!='')
			   {
			  $_POST[ncuentap]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentap]="";	
			   }
			 }
			 if($_POST[bc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuenta],1);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
			  if($_POST[bcc]!='')
			 {
				
			  $nresul=buscacuenta($_POST[cuentac]);		
			   //echo "bbbb".$_POST[cuentac];	
			  if($nresul!='')
			   {
			  $_POST[ncuentac]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentac]="";	
			   }
			 }
			 ?>
 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="14">Retenciones Pagos</td><td width="110" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td width="70" class="saludo1">Codigo:        </td>
        <td width="63"><input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">        </td>
        <td width="132" class="saludo1">Nombre :        </td>
        <td colspan="7"><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="60" onKeyUp="return tabular(event,this)">        </td>
        <td width="114" class="saludo1">Valor Retencion </td>
        <td width="215"><input name="retencion" type="text" id="retencion" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[retencion]?>" size="4" maxlength="3">%</td>
        				</tr>
                        <tr>
        <td width="52" class="saludo1">Tipo:        </td>
        <td><select name="tipo" id="tipo" onChange="validar()" >
			<option value="S" <?php if($_POST[tipo]=='S') echo "SELECTED"?>>Simple</option>
  			<option value="C" <?php if($_POST[tipo]=='C') echo "SELECTED"?>>Compuesto</option>
			</select>
			<input name="oculto" id="oculto" type="hidden" value="1">		  </td>
             <td width="73" class="saludo1">Terceros:        </td>
        <td><?php
		if ($_POST[terceros]=='1')
		  $chk='checked';
		  else
		  $chk='';
		?>
        <input name="terceros" type="checkbox" value="1" <?php echo $chk ?>>		  </td>
        <td width="73" class="saludo1">IVA:</td>
        <td><?php
		if ($_POST[iva]=='1')
		  $chk2='checked';
		  else
		  $chk='';
		?>
        <input name="iva" type="checkbox" value="1" <?php echo $chk2 ?>>		  </td>
         					<td class="saludo1" style="width:2.5cm">Nomina:</td>
        					<td>
        						<?php
									if ($_POST[nomina]=='1'){$chk3='checked';}
									else {$chk3='';}
								?>
        						<input type="checkbox" name="nomina" value="1" <?php echo $chk3 ?>>		  
        					</td>
        <td class="saludo1">Retencion</td><td>
        <select name="tiporet" id="tiporet" onChange="validar()" >
   			<option value="" >Seleccione...</option>
			<option value="N" <?php if($_POST[tiporet]=='N') echo "SELECTED"?>>Nacional</option>
  			<option value="D" <?php if($_POST[tiporet]=='D') echo "SELECTED"?>>Departamental</option>
  			<option value="M" <?php if($_POST[tiporet]=='M') echo "SELECTED"?>>Municipal</option>            
		</select>        
        </td>
       </tr> 
	   </table>
	   <?php
	   if($_POST[tipo]=='S') //***** SIMPLE
	   {
	   ?>
	   <table class="inicio">
	   <tr><td colspan="4" class="titulos">Detalle Retencion Pago</td></tr>   
        <tr>
	  		<td  style="width:10%;" class="saludo1">Cuenta Contable Causacion:</td>
          	<td colspan="2" style="width:8%;"  valign="middle" >
          		<input type="text" id="cuentac" name="cuentac"  onKeyPress="javascript:return solonumeros(event)" 
		  			onKeyUp="return tabular(event,this)" onBlur="buscactac(event)" value="<?php echo $_POST[cuentac]?>" onClick="document.getElementById('cuentac').focus();document.getElementById('cuentac').select();">
		  		<input type="hidden" value="" name="bcc">
		  			<a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=cuentac&nobjeto=ncuentac','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
					<img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  
			</td>
			<td style="width:50%;">
				<input id="ncuentac" style="width:50%;" name="ncuentac" type="text" value="<?php echo $_POST[ncuentac]?>"  readonly>
			</td>
	    </tr>               
	  	<tr>		
			<td style="width:10%;" class="saludo1">Cuenta Contable: </td>
		    <td colspan="2" style="width:8%;" valign="middle" >
		    	<input type="text" id="cuenta" name="cuenta"  onKeyPress="javascript:return solonumeros(event)" 
				  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">
				<input type="hidden" value="" name="bc">
					<a href="#" onClick="mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
					<img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  
			</td>
			<td  style="width:50%;">
				<input name="ncuenta" type="text" style="width:50%;" value="<?php echo $_POST[ncuenta]?>"  readonly>
			</td>
	    </tr>
		<tr>
			<td style="width:10%;" class="saludo1">Cuenta presupuestal: </td>
		    <td colspan="2" style="width:8%;" valign="middle" >
		    	<input type="text" id="cuentap" name="cuentap"  onKeyPress="javascript:return solonumeros(event)" 
				  onKeyUp="return tabular(event,this)" onBlur="buscactap(event)" value="<?php echo $_POST[cuentap]?>" onClick="document.getElementById('cuentap').focus();document.getElementById('cuentap').select();">
				<input type="hidden" value="" name="bcp" id="bcp">
					<a href="#" onClick="mypop=window.open('scuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
			</td>
			<td colspan="2" style="width:50%;" valign="middle" >
				<input name="ncuentap" style="width:50%;" type="text" value="<?php echo $_POST[ncuentap]?>"  readonly>
			</td>
	    </tr> 
    </table>
		<?php
		}
		if($_POST[tipo]=='C') //**** COMPUESTO
	   {
	   ?>
	    <table class="inicio">
	   <tr><td colspan="4" class="titulos">Agregar Detalle Retencion Pago</td></tr>   
        <tr>
	  <td width="13%" class="saludo1">Cuenta Contable Causacion:</td>
          <td colspan="2"  valign="middle" ><input type="text" id="cuentac" name="cuentac" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscactac(event)" value="<?php echo $_POST[cuentac]?>" onClick="document.getElementById('cuentac').focus();document.getElementById('cuentac').select();"><input type="hidden" value="" name="bcc"><a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=cuentac&nobjeto=ncuentac','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td width="69%" ><input id="ncuentac"  name="ncuentac" type="text" value="<?php echo $_POST[ncuentac]?>" size="80" readonly></td>
	     </tr>                 
	  <tr>
	 <td width="13%" class="saludo1">Cuenta Contable: </td>
          <td colspan="2"  valign="middle" ><input type="text" id="cuenta" name="cuenta" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="" name="bc"><a href="#" onClick="mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td width="69%" ><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="80" readonly></td>
	     </tr>
				  <tr><td class="saludo1">Cuenta presupuestal: </td>
          <td colspan="2" valign="middle" ><input type="text" id="cuentap" name="cuentap" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscactap(event)" value="<?php echo $_POST[cuentap]?>" onClick="document.getElementById('cuentap').focus();document.getElementById('cuentap').select();"><input type="hidden" value="" name="bcp" id="bcp"><a href="#" onClick="mypop=window.open('scuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
	      <td colspan="2" valign="middle" ><input name="ncuentap" type="text" value="<?php echo $_POST[ncuentap]?>" size="80" readonly></td></tr>
		  <tr>		  <td class="saludo1">Division Retencion:</td><td><input id="valor" name="valor" type="text" value="<?php echo $_POST[valor]?>" onKeyUp="return tabular(event,this)" size="5" onKeyPress="javascript:return solonumeros(event)" > % <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"></td>
	    </tr> 
    </table>
	 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentap').focus();
			  document.getElementById('cuentap').select();
			  document.getElementById('bc').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			  <?php
			  }
			 }
			 
			 if($_POST[bcc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuentac]);
			  if($nresul!='')
			   {
			  $_POST[ncuentac]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuenta').focus();
			  document.getElementById('cuenta').select();
			  document.getElementById('bcc').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentac]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuentac.focus();</script>
			  <?php
			  }
			 } 
		?>

	 <?php
			//**** busca cuenta
			if($_POST[bcp]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap],1);
			  if($nresul!='')
			   {
			  $_POST[ncuentap]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('codigo').focus();
			  document.getElementById('codigo').select();
			  document.getElementById('bcp').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentap]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");
			  document.form2.cuentap.focus();
			  document.form2.cuentap.select();
			  </script>
			  <?php
			  }
			 }
		?>
	<table class="inicio">
	<tr><td class="titulos" colspan="8">Detalle Retencion Pago</td></tr>
	<tr><td class="titulos2">Cta Contable Causacion</td><td class="titulos2">Nombre Cta</td><td class="titulos2">Cta Contable Ingreso</td><td class="titulos2">Nombre Cta</td><td class="titulos2">Cta Pres</td><td class="titulos2">Nombre Cta Pres</td><td class="titulos2">%</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
	<?php
			 
	if ($_POST[elimina]!='')
		 { 
		 $posi=$_POST[elimina];
		 unset($_POST[tcuentas][$posi]);
		 unset($_POST[dcuentas][$posi]);
 		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dcuentasc][$posi]);
 		 unset($_POST[dncuentasc][$posi]);
		 unset($_POST[dcuentasp][$posi]);
 		 unset($_POST[dncuentasp][$posi]);		 
		 unset($_POST[dccs][$posi]);
		 unset($_POST[dcreditos][$posi]);		 		 		 		 		 
		 unset($_POST[ddebitos][$posi]);		 
		 $_POST[tcuentas]= array_values($_POST[tcuentas]); 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]);
		 $_POST[dcuentasc]= array_values($_POST[dcuentasc]); 
		 $_POST[dncuentasc]= array_values($_POST[dncuentasc]); 	 		 		 
		 $_POST[dcuentasp]= array_values($_POST[dcuentasp]); 
		 $_POST[dncuentasp]= array_values($_POST[dncuentasp]); 		 		 
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 $_POST[dcreditos]= array_values($_POST[dcreditos]); 
		 $_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
		 }
	
	if ($_POST[agregadet]=='1')
		 {
		  $cuentacred=0;
		  $cuentadeb=0;
		  $diferencia=0;
		 $_POST[tcuentas][]='N';
		 $_POST[dcuentas][]=$_POST[cuenta];
		 $_POST[dncuentas][]=$_POST[ncuenta];
		 $_POST[dcuentasc][]=$_POST[cuentac];
		 $_POST[dncuentasc][]=$_POST[ncuentac];
		 $_POST[dcuentasp][]=$_POST[cuentap];
		 $_POST[dncuentasp][]=$_POST[ncuentap];		 
		 $_POST[dvalores][]=$_POST[valor];		 
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
			document.form2.cuentac.select();
				document.form2.cuentac.value="";
				document.form2.cuenta.value="";
				document.form2.cuentap.value="";
				document.form2.ncuenta.value="";
				document.form2.ncuentac.value="";
					document.form2.ncuentac.value="";	
				document.form2.ncuentap.value="";
				document.form2.valor.value="";
		 </script>
		 <?php
		 }
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {echo "<tr><td class='saludo2'><input name='dcuentasc[]' value='".$_POST[dcuentasc][$x]."' type='text' size='8' readonly></td><td class='saludo2'><input name='dncuentasc[]' value='".$_POST[dncuentasc][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='tcuentas[]' value='".$_POST[tcuentas][$x]."' type='hidden' ><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='8' readonly></td><td class='saludo2'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='dcuentasp[]' value='".$_POST[dcuentasp][$x]."' type='text' size='30' onDblClick='llamarventanadeb(this,$x)' readonly></td><td class='saludo2'><input name='dncuentasp[]' value='".$_POST[dncuentasp][$x]."' type='text' size='50' onDblClick='llamarventanacred(this,$x)' readonly></td><td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='4' onDblClick='llamarventanadeb(this,$x)' readonly></td><td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 }	 
		 ?>
	<tr></tr>
	</table>	
	   <?php
	   }
		?>
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$suma=0;
for ($x=0;$x< count($_POST[dcuentas]);$x++)
	{$suma=$suma+$_POST[dvalores][$x];
	}
			
if ($suma=='0' or $suma=='100' )
{
$linkbd=conectar_bd();
if ($_POST[nombre]!="")
 {
 $nr="1";
 $sqlr="INSERT INTO tesoretenciones(codigo,nombre,tipo,estado,retencion,terceros,iva,destino,nomina)VALUES ('$_POST[codigo]','".utf8_decode($_POST[nombre])."','$_POST[tipo]' ,'S', '$_POST[retencion]','$_POST[terceros]','$_POST[iva]','$_POST[tiporet]','$_POST[nomina]')";
 //echo "sqlr:".$sqlr;
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
  echo "<table><tr><td class='saludo1'><center>Se ha almacenado el Ingreso con Exito  <img src='imagenes/confirm.png'></center></td></tr></table>";
  	$idin=mysql_insert_id();
 
  if($_POST[tipo]=='S') //**** simple
	   {
		//******
		$sqlr="INSERT INTO tesoretenciones_det (codigo,cuenta,cuentapres,porcentaje,estado,cuentac,vigencia)VALUES ('$idin', '$_POST[cuenta]','$_POST[cuentap]','100','S','$_POST[cuentac]', $vigusu)";
 		
		//echo "sqlr:".$sqlr;
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
 			 echo "<script>despliegamodalm('visible','1','Se ha almacenado el Detalle del Ingreso con Exito');</script>";
		//****
	  	 	}
  	}
	//****COMPUESTO	
	 if($_POST[tipo]=='C') //**** COMPUESTO
	   {
		//******
		for($x=0;$x<count($_POST[dcuentas]);$x++)
		 {
		$sqlr="INSERT INTO tesoretenciones_det (codigo,cuenta,cuentapres,porcentaje,estado,cuentac, vigencia)VALUES ('$idin', '".$_POST[dcuentas][$x]."','".$_POST[dcuentasp][$x]."','".$_POST[dvalores][$x]."','S','".$_POST[dcuentasc][$x]."', $vigusu)";
 		//echo "sqlr:".$sqlr;
  		if (!mysql_query($sqlr,$linkbd))
  		{
		echo "
									<script>
										despliegamodalm('visible','2','Manejador de Errores de la Clase BD No se pudo ejecutar la petición');
										document.getElementById('valfocus').value='2';
									</script>";
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
				echo "<script>despliegamodalm('visible','1','Se ha almacenado el Detalle del Ingreso con Exito');</script>";
		
	  	 	}
		}//***** fin del for	
  	}
	}
	
 }
else
 {
  echo "<table class='inicio'><tr><td class='saludo1'><center>Falta informacion para Crear el Centro Costo</center></td></tr></table>";
 }
}
else
	{
		?>
		<script>
		
		alert("No cumple con la división de la retención");
		
		
		</script>
	<?php	
	}
}
?> </td></tr>
     
</table>
</body>
</html>