<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID- Tesoreria</title>

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
//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.vigencia.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
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
			<a href="teso-tasasinteres.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
			<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscatasasinteres.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 		 $fec=date("d/m/Y");
		 $_POST[vigencia]=$vigusu;
		 $_POST[fecha]=$fec; 		 		  			 
		 $_POST[incopri]="0";		 
		 $_POST[incoseg]="0";		 		 
		 $_POST[incoter]="0";	
		 $_POST[incocua]="0";
		 $_POST[incoquin]="0";
		 $_POST[incosex]="0";
		 $_POST[incosep]="0";
		 $_POST[incooct]="0";
		 $_POST[inconov]="0";
		 $_POST[incodec]="0";
		 $_POST[incoonc]="0";
		 $_POST[incodoc]="0";	
         //---INTERESES CORRIENTES		 
		 $_POST[inmopri]="0";		 
		 $_POST[inmoseg]="0";		 		 
		 $_POST[inmoter]="0";		 
		 $_POST[inmocua]="0";	
		 $_POST[inmoquin]="0";	
		 $_POST[inmosex]="0";
		 $_POST[inmosep]="0";
         $_POST[inmooct]="0";	
	     $_POST[inmonov]="0";
		 $_POST[inmodec]="0";
		 $_POST[inmoonc]="0";
		 $_POST[inmodoc]="0";

}
?>
 <form name="form2" method="post" action="">
    <table class="inicio" align="center" >
      <tr>
        <td class="titulos" colspan="11">Tasas de Interes</td>
        <td width="10%" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
      </tr>
	  <tr>
	  <td  style="width: 6% !important" class="saludo1">Fecha:</td>
        <td style="width: 6% !important"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width: 100%"></td>
		<td  style="width: 6% !important" class="saludo1">Vigencia:</td>
        <td  style="width: 6% !important"><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width: 100%"> </td> 
		<td colspan="8">Fuente: www.superfinanciera.gov.co/</td>
       </tr> 
	   
	   <tr><td colspan="12" class="titulos">Intereses Corrientes<input name="oculto" type="hidden" value="1"></td></tr>
      
	   
	  <tr>
	  <td class="saludo1" style="width: 6% !important">Enero:</td>
	  <td style="width: 6% !important"><input type="text" id="incopri" name="incopri" value="<?php echo $_POST[incopri]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%" > %
	  	</td>
	  <td class="saludo1" style="width: 6% !important">Febrero:</td><td style="width: 6% !important"><input type="text" id="incoseg" name="incoseg" value="<?php echo $_POST[incoseg]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %
	  </td>
	  <td style="width: 6% !important" class="saludo1">Marzo:</td>
	  <td style="width: 6% !important"><input type="text" id="incoter" name="incoter" value="<?php echo $_POST[incoter]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %
	  </td>
	  <td style="width: 6% !important" class="saludo1" >Abril:</td>
	  <td style="width: 6% !important"><input type="text" id="incocua" name="incocua" value="<?php echo $_POST[incocua]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %
	  </td>
	  <td style="width: 6% !important" class="saludo1" >Mayo:</td>
	  <td style="width: 6% !important"><input type="text" id="incoquin" name="incoquin" value="<?php echo $_POST[incoquin]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %
	  </td>
	  <td style="width: 6% !important" class="saludo1" >Junio:</td>
	  <td style="width: 6% !important"><input type="text" id="incosex" name="incosex" value="<?php echo $_POST[incosex]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %
	  </td>
	  
	  </tr>
	  
	  <tr>
	  <td class="saludo1" >Julio:</td><td style="width: 6% !important"><input type="text" id="incosep" name="incosep" value="<?php echo $_POST[incosep]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%" > %
	  </td>
	  <td class="saludo1" >Agosto:</td><td style="width: 6% !important"><input type="text" id="incooct" name="incooct" value="<?php echo $_POST[incooct]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %
	  </td>
	  <td class="saludo1" >Septiembre:</td><td style="width: 6% !important"><input type="text" id="inconov" name="inconov" value="<?php echo $_POST[inconov]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %
	  </td>
	  <td class="saludo1" >Octubre:</td><td style="width: 6% !important"><input type="text" id="incodec" name="incodec" value="<?php echo $_POST[incodec]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %
	  </td>
	  <td class="saludo1" >Noviembre:</td><td style="width: 6% !important"><input type="text" id="incoonc" name="incoonc" value="<?php echo $_POST[incoonc]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %
	  </td>
	   <td class="saludo1" >Diciembre:</td><td style="width: 6% !important"><input type="text" id="incodoc" name="incodoc" value="<?php echo $_POST[incodoc]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %
	  </td>
	  </tr>
	   
	   <tr><td colspan="12" class="titulos">Intereses Moratorios</td></tr>
	  <tr>
	  <td class="saludo1" style="width: 6% !important">Enero:</td><td><input type="text" id="inmopri" name="inmopri" value="<?php echo $_POST[inmopri]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %	</td>
	  <td class="saludo1" style="width: 6% !important">Febrero:</td><td><input type="text" id="inmoseg" name="inmoseg" value="<?php echo $_POST[inmoseg]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %	</td>
	  <td class="saludo1" style="width: 6% !important">Marzo:</td><td><input type="text" id="inmoter" name="inmoter" value="<?php echo $_POST[inmoter]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %  </td>
	  <td class="saludo1" style="width: 6% !important">Abril:</td><td><input type="text" id="inmocua" name="inmocua" value="<?php echo $_POST[inmocua]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %  </td>
	  <td class="saludo1" style="width: 6% !important">Mayo:</td><td><input type="text" id="inmoquin" name="inmoquin" value="<?php echo $_POST[inmoquin]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %  </td>
	  <td class="saludo1" style="width: 6% !important">Junio:</td><td><input type="text" id="inmosex" name="inmosex" value="<?php echo $_POST[inmosex]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %  </td>
	  </tr>
	   <tr>
	  <td class="saludo1">Julio:</td><td><input type="text" id="inmosep" name="inmosep" value="<?php echo $_POST[inmosep]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%" > %	</td>
	  <td class="saludo1">Agosto:</td><td><input type="text" id="inmooct" name="inmooct" value="<?php echo $_POST[inmooct]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %	</td>
	  <td class="saludo1">Septiembre:</td><td><input type="text" id="inmonov" name="inmonov" value="<?php echo $_POST[inmonov]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %  </td>
	  <td class="saludo1">Octubre:</td><td><input type="text" id="inmodec" name="inmodec" value="<?php echo $_POST[inmodec]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %  </td>
	  <td class="saludo1">Noviembre:</td><td><input type="text" id="inmoonc" name="inmoonc" value="<?php echo $_POST[inmoonc]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %  </td>
	  <td class="saludo1">Diciembre:</td><td><input type="text" id="inmodoc" name="inmodoc" value="<?php echo $_POST[inmodoc]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"> %  </td>
	  </tr>
	  
      </table>
	
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	$sqlr="select *from tesotasainteres where tesotasainteres.vigencia=$_POST[vigencia]";
	$resp=(mysql_query($sqlr,$linkbd));
	$ntr = mysql_num_rows($resp);
 
	if ($ntr>0)
 	{
		?>
		<script>
		alert("Ya existe tasas de interes para esta vigencia");
		</script>
	<?php
	}	
 	
	else	
 	{
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//************** modificacion del presupuesto **************
	
	$sqlr="insert into tesotasainteres (vigencia,fecha,incopri,incoseg,incoter,incocua,incoquin,incosex,incosep,incooct,inconov,incodeci,incoonc,incodoc,inmopri,inmoseg,inmoter,inmocua,inmoquin,inmosex,inmosep,inmooct,inmonov,inmodec,inmoonc,inmodoc) values('$_POST[vigencia]','$fechaf','$_POST[incopri]','$_POST[incoseg]','$_POST[incoter]','$_POST[incocua]','$_POST[incoquin]','$_POST[incosex]','$_POST[incosep]','$_POST[incooct]','$_POST[inconov]','$_POST[incodec]','$_POST[incoonc]','$_POST[incodoc]','$_POST[inmopri]','$_POST[inmoseg]','$_POST[inmoter]','$_POST[inmocua]','$_POST[inmoquin]','$_POST[inmosex]','$_POST[inmosep]','$_POST[inmooct]','$_POST[inmonov]','$_POST[inmodec]','$_POST[inmoonc]','$_POST[inmodoc]')";	  
	
	
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Cuenta con Exito</center></td></tr></table>";
		  ?>
		  <script>
//		  document.form2.numero.value="";
//		  document.form2.valor.value=0;
		  </script>
		  <?php
		  }
	}	  
}
?>	
    </form> 
</table>
</body>
</html>