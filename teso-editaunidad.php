<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
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
if (document.form2.vigencia.value!='' && document.form2.valorunidad.value!='' && document.form2.unidad.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
	document.getElementById('oculto').value='2';
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
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('vigencia').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('vigencia').value=next;
					var idcta=document.getElementById('vigencia').value;
					document.form2.action="teso-editaunidad.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('vigencia').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('vigencia').value=prev;
					var idcta=document.getElementById('vigencia').value;
					document.form2.action="teso-editaunidad.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.form2.vigencia.value;
				location.href="teso-buscaunidad.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
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
			<a href="teso-unidad.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
			<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscaunidad.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" class="mgbt" title="Nueva ventana"></a>
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" ></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
	$linkbd=conectar_bd();
			if ($_GET[is]!=""){echo "<script>document.getElementById('codrec').value=$_GET[is];</script>";}
			$sqlr="select MIN(CONVERT(vigencia, SIGNED INTEGER)), MAX(CONVERT(vigencia, SIGNED INTEGER)) from tesounidadpred ORDER BY CONVERT(vigencia, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[is]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from tesounidadpred where vigencia='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from tesounidadpred where vigencia='$_GET[is]'";
					}
				}
				else{
					$sqlr="select * from  tesounidadpred ORDER BY CONVERT(vigencia, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[vigencia]=$row[3];
			}
		
	if($_POST[oculto]!="2"){
		$sqlr="select * from tesounidadpred where tesounidadpred.vigencia=$_POST[vigencia]";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
		
			{
			 $_POST[vigencia]=$row[3]; 			 		  			 
			 $_POST[unidad]=$row[1];
			 $_POST[valorunidad]=$row[2];			 
			}
		}
			//NEXT
			$sqln="select *from tesounidadpred WHERE vigencia > '$_POST[vigencia]' ORDER BY vigencia ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[3]."'";
			//PREV
			$sqlp="select *from tesounidadpred WHERE vigencia < '$_POST[vigencia]' ORDER BY vigencia DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[3]."'";

?>
 <form name="form2" method="post" action="">
       <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="9">Parametrizacion Unidad Predial</td>
        <td width="80" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
	  <td width="10%"  class="saludo1">Tipo unidad: </td>
        <td width="15%" ><select name="unidad" id="unidad"> <option value="">Seleccione el valor..</option> <option value="uvt" <?php if($_POST[unidad]=='uvt'){echo "SELECTED"; } ?>  >UVT</option><option value="smmlv" <?php if($_POST[unidad]=='smmlv'){echo "SELECTED"; } ?>>SMMLV</option></select> </td><td width="10%" class="saludo1">Valor:</td>
        <td width="15%" ><input name="valorunidad" type="text" value="<?php echo $_POST[valorunidad]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="text-align: right; "> </td> <td width="10%" class="saludo1">Vigencia:</td>
        <td width="25%" ><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="4" size="4" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> </td>
       </tr> 
      </table>
	  <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]; ?>" />
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	//************** modificacion del presupuesto **************
	$sqlr="update tesounidadpred set vigencia='$_POST[vigencia]',valor='$_POST[valorunidad]',tipo='$_POST[unidad]' where vigencia=$_POST[vigencia]";

	
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
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha actualizado la unidad con Exito</center></td></tr></table>";
		  ?>
		  <?php
		  }
  
}
?>	
    </form> 
</table>
</body>
</html>