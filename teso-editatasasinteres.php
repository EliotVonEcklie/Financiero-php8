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
if (document.form2.vigencia.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
	document.form2.oculto.value='2';
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
					document.form2.action="teso-editatasasinteres.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="teso-editatasasinteres.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('vigencia').value;
				location.href="teso-buscatasasinteres.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
			<a href="teso-tasasinteres.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
			<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscatasasinteres.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" class="mgbt" title="Nueva ventana"></a>
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
$linkbd=conectar_bd();
			if ($_GET[is]!=""){echo "<script>document.getElementById('codrec').value=$_GET[is];</script>";}
			$sqlr="select MIN(CONVERT(vigencia, SIGNED INTEGER)), MAX(CONVERT(vigencia, SIGNED INTEGER)) from tesotasainteres ORDER BY CONVERT(vigencia, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[is]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from tesotasainteres where vigencia='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from tesotasainteres where vigencia='$_GET[is]'";
					}
				}
				else{
					$sqlr="select * from  tesotasainteres ORDER BY CONVERT(vigencia, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[vigencia]=$row[0];
			}
		
	if($_POST[oculto]!="2"){
		$sqlr="select *from tesotasainteres where tesotasainteres.vigencia=$_POST[vigencia]";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
		
			{
		$p1=substr($row[1],0,4);
			$p2=substr($row[1],5,2);
			$p3=substr($row[1],8,2);
			
			
			
		 $_POST[fecha]=$p3."-".$p2."-".$p1;
		 $_POST[vigencia]=$row[0]; 		 		  			 
		 $_POST[incopri]=$row[2];		 
		 $_POST[incoseg]=$row[3];		 		 
		 $_POST[incoter]=$row[4];		 
		 $_POST[incocua]=$row[5];
		 $_POST[incoquin]=$row[6];	
		 $_POST[incosex]=$row[7];	
		 $_POST[incosep]=$row[8];
		 $_POST[incooct]=$row[9];
		 $_POST[inconov]=$row[10];
		 $_POST[incodec]=$row[11];
		 $_POST[incoonc]=$row[12];
		 $_POST[incodoc]=$row[13];
		 
		 $_POST[inmopri]=$row[14];		 
		 $_POST[inmoseg]=$row[15];		 		 
		 $_POST[inmoter]=$row[16];		 
		 $_POST[inmocua]=$row[17];
		 $_POST[inmoquin]=$row[18];
		 $_POST[inmosex]=$row[19];
		 $_POST[inmosep]=$row[20];
		 $_POST[inmooct]=$row[21];
		 $_POST[inmonov]=$row[22];
		 $_POST[inmodec]=$row[23];
		 $_POST[inmoonc]=$row[24];
		 $_POST[inmodoc]=$row[25];
		 
}
}
			//NEXT
			$sqln="select *from tesotasainteres WHERE vigencia > '$_POST[vigencia]' ORDER BY vigencia ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from tesotasainteres WHERE vigencia < '$_POST[vigencia]' ORDER BY vigencia DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";

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
        <td  style="width: 6% !important"><input name="vigencia" id="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width: 100%"> 
		<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec"></td> 
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
	$p1=substr($_POST[fecha],0,2);
	$p2=substr($_POST[fecha],3,2);
	$p3=substr($_POST[fecha],6,4);
	$fechaf=$p3."-".$p2."-".$p1;
	$sqlr="update tesotasainteres set vigencia='$_POST[vigencia]',fecha='$fechaf',incopri='$_POST[incopri]',incoseg='$_POST[incoseg]',incoter='$_POST[incoter]',incocua='$_POST[incocua]',incoquin='$_POST[incoquin]',incosex='$_POST[incosex]',incosep='$_POST[incosep]',incooct='$_POST[incooct]',inconov='$_POST[inconov]',incodeci='$_POST[incodec]',incoonc='$_POST[incoonc]',incodoc='$_POST[incodoc]',inmopri='$_POST[inmopri]',inmoseg='$_POST[inmoseg]',inmoter='$_POST[inmoter]',inmocua='$_POST[inmocua]',inmoquin='$_POST[inmoquin]',inmosex='$_POST[inmosex]',inmosep='$_POST[inmosep]',inmooct='$_POST[inmooct]',inmonov='$_POST[inmonov]',inmodec='$_POST[inmodec]',inmoonc='$_POST[inmoonc]',inmodoc='$_POST[inmodoc]' where vigencia=$_POST[vigencia]";
	
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
?>	
    </form> 
</table>
</body>
</html>