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

	<script language="JavaScript1.2">
		function validar()
		{
			document.form2.submit();
		}

		function guardar()
		{

			if (document.form2.fecha.value!='' && document.form2.banco.value!='')
			{
				if((document.form2.valor.value!='' || document.form2.valor.value>0) && (document.form2.valor2.value!='' || document.form2.valor2.value>0) && (document.form2.valor2.value > document.form2.valor.value))
				{
					if (confirm("Esta Seguro de Guardar"))
					{
						document.getElementById('oculto').value='2';
						document.form2.submit();
					}
				}
				else 
				{
					alert('Verifique los parametros del cheque ');
					document.form2.valor.focus();
					document.form2.valor.select();
				}
			}
			else{
				alert('Faltan datos para completar el registro');
				document.form2.fecha.focus();
				document.form2.fecha.select();
			}
		}
	</script>
	<script src="css/programas.js"></script>
	<link href="css/css2.css" rel="stylesheet" type="text/css" />
	<link href="css/css3.css" rel="stylesheet" type="text/css" />
	<script>
		function adelante(scrtop, numpag, limreg, filtro, next){
			var maximo=document.getElementById('maximo').value;
			var actual=document.getElementById('ids').value;
			if(parseFloat(maximo)>parseFloat(actual)){
				document.getElementById('oculto').value='1';
				document.getElementById('ids').value=next;
				document.getElementById('numero').value=next;
				var idcta=document.getElementById('ids').value;
				document.form2.action="teso-editachequeras.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}
		}
		
		function atrasc(scrtop, numpag, limreg, filtro, prev){
			var minimo=document.getElementById('minimo').value;
			var actual=document.getElementById('ids').value;
			if(parseFloat(minimo)<parseFloat(actual)){
				document.getElementById('oculto').value='1';
				document.getElementById('ids').value=prev;
				document.getElementById('numero').value=prev;
				var idcta=document.getElementById('ids').value;
				document.form2.action="teso-editachequeras.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}
		}
		
		function iratras(scrtop, numpag, limreg, filtro){
			var idcta=document.getElementById('ids').value;
			location.href="teso-buscaanularcheques.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
			<a href="teso-chequeras.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
			<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar" /></a>
			<a href="teso-buscachequeras.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" border="0" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a>
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>		  
</table>
<tr> 
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$linkbd=conectar_bd();
?>	
<?php
			if ($_GET[idr]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";}
			$sqlr="select MIN(tesochequeras.idchequera), MAX(tesochequeras.idchequera) from tesochequeras,terceros,tesobancosctas where tesochequeras.banco=tesobancosctas.tercero and tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban = tesochequeras.cuentabancaria and tesobancosctas.estado='S' order by tesochequeras.idchequera";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idr]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from tesochequeras,terceros,tesobancosctas where tesochequeras.banco=tesobancosctas.tercero and tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban = tesochequeras.cuentabancaria and tesobancosctas.estado='S' and tesochequeras.idchequera='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from tesochequeras,terceros,tesobancosctas where tesochequeras.banco=tesobancosctas.tercero and tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban = tesochequeras.cuentabancaria and tesobancosctas.estado='S' and tesochequeras.idchequera ='$_GET[idr]'";
					}
				}
				else{
					$sqlr="select *from tesochequeras,terceros,tesobancosctas where tesochequeras.banco=tesobancosctas.tercero and tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban = tesochequeras.cuentabancaria and tesobancosctas.estado='S' ORDER BY tesochequeras.idchequera DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[ids]=$row[0];
			   	$_POST[numero]=$row[0];
			}
		
 			if($_POST[oculto]!="2"){
		
	$sqlr="select *from tesochequeras,terceros,tesobancosctas where tesochequeras.banco=tesobancosctas.tercero and tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban = tesochequeras.cuentabancaria and tesobancosctas.estado='S' and tesochequeras.idchequera='$_POST[ids]'";

 	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp))
	{	 
	$p1=substr($row[3],0,4);
		$p2=substr($row[3],5,2);
		$p3=substr($row[3],8,2);
		$_POST[fecha]=$p3."-".$p2."-".$p1;	
	
	
	$_POST[numero]=$row[0];
	$_POST[banco]=$row[30];
	$_POST[valor]=$row[4];
	$_POST[valor2]=$row[5];
	$_POST[consecutivo]=$row[6];
	$_POST[nbanco]=$row[13];
	$_POST[estado]=$row[7];
	

	}
				 
}
			//NEXT
			$sqln="select *from tesochequeras,terceros,tesobancosctas where tesochequeras.banco=tesobancosctas.tercero and tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban = tesochequeras.cuentabancaria and tesobancosctas.estado='S' and tesochequeras.idchequera > '$_POST[ids]' ORDER BY tesochequeras.idchequera ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from tesochequeras,terceros,tesobancosctas where tesochequeras.banco=tesobancosctas.tercero and tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban = tesochequeras.cuentabancaria and tesobancosctas.estado='S' and tesochequeras.idchequera < '$_POST[ids]' ORDER BY tesochequeras.idchequera DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";

?>
 <form name="form2" method="post" action="">
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="7">Chequeras</td><td width="138" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td width="161"  class="saludo1">Fecha:        </td>
        <td ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>        </td>
        <td  class="saludo1">N&deg;</td>
        <td style="width:10%" >
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
        	<input type="text" id="numero" name="numero" value="<?php echo $_POST[numero]?>" style="width:40%" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" readonly >
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
      	</td>
      </tr> 
	  <tr>
	  <td class="saludo1">Cuenta Bancaria:</td>
	  <td colspan="1" >
	    <select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)" disabled>
	      <option value="">Seleccione....</option>
		  <?php
	$linkbd=conectar_bd();
	$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[1] ";
					$i=$row[1];
					 if($i==$_POST[banco])
			 			{
						 echo "SELECTED";
						 $_POST[nbanco]=$row[4];
						  $_POST[ter]=$row[5];
						 $_POST[cb]=$row[2];
						 }
					  echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
					}	 	
					?>
            </select>
			<?php 
			$sqlr="select count(*) from tesochequeras where banco=$_POST[ter] and cuentabancaria=$_POST[cb] and estado='S' ";
			$res2=mysql_query($sqlr,$linkbd);
			$row2 =mysql_fetch_row($res2);
		//	if($row2[0]>0)
			//  {
		//	   echo "<script>alert('Ya existe una chequera activa para esta Cuenta');document.form2.banco.value=''; document.form2.banco.focus();</script>";
	//		  $_POST[nbanco]="";
	//		  }
			 ?>
			</td><td colspan="2"> <input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="60" readonly><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ></td><td width="10" class="saludo1">Consecutivo:</td>
	    <td><input type="text" id="consecutivo" name="consecutivo" value="<?php echo $_POST[consecutivo]?>" readonly ></td>
       </tr> 
	  <tr><td class="saludo1">Rango inicial:</td><td width="277"><input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" size="20" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" >	</td>
	  <td width="106" class="saludo1">Rango Final:</td>
	  <td width="550" ><input type="text" id="valor2" name="valor2" value="<?php echo $_POST[valor2]?>" size="20" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" >
      <td width="10" class="saludo1">Estado:</td>
	    <td><input type="text" id="estado" name="estado" value="<?php echo $_POST[estado]?>" ><input type='hidden' name='ids' id='ids' value= "<?php echo $_POST[ids]?>"></td>
        <input type="hidden" value="1" name="oculto" id="oculto"></td>
	  </tr>
      </table>
	  <?php
	   if($_POST[oculto]=='2')
		{
			$linkbd=conectar_bd();
		$p1=substr($_POST[fecha],0,2);
		$p2=substr($_POST[fecha],3,2);
		$p3=substr($_POST[fecha],6,4);
		$fechaf=$p3."-".$p2."-".$p1;
		
		$sqlr="update tesochequeras set inicial='$_POST[valor]',final='$_POST[valor2]',estado='$_POST[estado]' where idchequera='$_POST[ids]'";
		if (!mysql_query($sqlr,$linkbd))
			{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png' > Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Chequera con Exito <img src='imagenes/confirm.png' ></center></td></tr></table>";
		  ?>
<script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  document.form2.oculto.value=1;
		  </script>
		  <?php
		  }
		}
	  ?>
    </form> 
</table>
</body>
</html>