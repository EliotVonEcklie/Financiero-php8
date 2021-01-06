<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
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
//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.codigo.value!='' && document.form2.nombre.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
	document.getElementById('oculto').value='2';
  	document.form2.submit();
  	}
  }
 else{
  alert('Faltan datos para completar el registro');
  	document.form2.codigo.focus();
  	document.form2.codigo.select();
  }
 }
</script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="teso-editagastosbancarios.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=prev;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="teso-editagastosbancarios.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="teso-buscagastosbancarios.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
			<a href="teso-gastosbancarios.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscagastosbancarios.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu; 
$linkbd=conectar_bd();
?>	
<?php
			if ($_GET[idr]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";}
			$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from tesogastosbancarios ORDER BY CONVERT(codigo, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idr]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from tesogastosbancarios where codigo='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from tesogastosbancarios where codigo ='$_GET[idr]'";
					}
				}
				else{
					$sqlr="select * from  tesogastosbancarios ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}
		
		 if($_POST[oculto]!="2"){
			$sqlr="select *from tesogastosbancarios where tesogastosbancarios.codigo=$_POST[codigo]";
			$_POST[ids]=$_GET[is];
			$resp = mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($resp))
			{	 
			$_POST[codigo]=$row[0];
			$_POST[nombre]=$row[1]; 	
			$_POST[tipog]=$row[2]; 	
		   }
		}
		 if($_POST[oculto]==""){
			 $sqlr="select *from tesogastosbancarios_det where tesogastosbancarios_det.codigo=$_POST[codigo] and vigencia='$vigusu'";
			$cont=0;
			$resp = mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($resp))
			{	 
				 $_POST[concecont]=$row[2];
				 $_POST[cuenta]=$row[5];
				 $_POST[ncuenta]=buscacuentapres($row[5],2);
				 $cont=$cont+1;
			} 

		 }
	
		//NEXT
		$sqln="select *from tesogastosbancarios WHERE codigo > '$_POST[codigo]' ORDER BY codigo ASC LIMIT 1";
		$resn=mysql_query($sqln,$linkbd);
		$row=mysql_fetch_row($resn);
		$next="'".$row[0]."'";
		//PREV
		$sqlp="select *from tesogastosbancarios WHERE codigo < '$_POST[codigo]' ORDER BY codigo DESC LIMIT 1";
		$resp=mysql_query($sqlp,$linkbd);
		$row=mysql_fetch_row($resp);
		$prev="'".$row[0]."'";
?>

 <form name="form2" method="post" action="">
 <?php //**** busca cuenta
  			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
$linkbd=conectar_bd();			 
			 ?>
 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">.: Editar Gastos Bancarios</td>
        <td width="112" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td width="90" class="saludo1">Codigo:        </td>
        <td style="width:10%">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
        	<input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" style="width:30%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">        
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
       	</td>
        <td width="147" class="saludo1">Nombre:        </td>
        <td width="644"><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="80" onKeyUp="return tabular(event,this)">  <input name="oculto" id="oculto" type="hidden" value="1">	      </td><td class="saludo1">Tipo Nota:</td><td><select name="tipog" onChange="validar()">
		   <option value="I" <?php if($_POST[tipog]=='I') echo "SELECTED"; ?>>Ingreso</option>
          <option value="G" <?php if($_POST[tipog]=='G') echo "SELECTED"; ?>>Gasto</option>
		  </select></td>
       </tr> 
	   </table>
	  
	   <table class="inicio">
	   <tr><td colspan="4" class="titulos">Agregar Detalle Gastos Bancarios</td></tr>                  
	  <tr>
	  <td width="12%"  class="saludo1">Concepto Contable:</td>
	  <td width="88%" ><select name="concecont" id="concecont" >
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from conceptoscontables  where modulo='4' and tipo='GB' order by codigo";
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[concecont])
			 	{
				 echo "SELECTED";
				 $_POST[concecontnom]=$row[1];
				 }
				echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
			     }			
				?>
		  </select></td></tr>
		  <?php if($_POST[tipog]=='I'){ ?>
		  <tr>
		  	<td class="saludo1">Cuenta presupuestal: </td>
          	<td colspan="3" valign="middle" >
          		<input type="text" id="cuenta" name="cuenta" size="20" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">
          		<input type="hidden" value="" name="bc" id="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>            
          		<input id="ncuenta" name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="80" readonly>
          	</td>
	    </tr> 
	    <?php } ?>
    </table>
	<?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('agregar').focus();
			  document.getElementById('agregar').select();
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
		?>
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$linkbd=conectar_bd();
if ($_POST[nombre]!="")
 {
 $nr="1";
 $sqlr="UPDATE tesogastosbancarios SET codigo='$_POST[codigo]',nombre='".utf8_decode($_POST[nombre])."',tipo='$_POST[tipog]',estado='S' where codigo='$_POST[codigo]'";
//echo "sqlr:".$sqlr;
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
//  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Gasto Bancario con Exito</center></td></tr></table>";
		$sqlr="delete from tesogastosbancarios_det  where codigo='$_POST[codigo]' and vigencia='$vigusu'";
		mysql_query($sqlr,$linkbd);
		//******
		$sqlr="insert into tesogastosbancarios_det  (codigo,concepto,modulo,tipoconce,cuentapres,estado, vigencia) values ('$_POST[codigo]','$_POST[concecont]','4','GB','$_POST[cuenta]','S', $vigusu)";
 		//echo "sqlr:".$sqlr;
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
 			 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Gasto Bancario con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
		//****
	  	 	}

	//****COMPUESTO	
	}	
 }
else
 {
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear el Centro Costo</H2></center></td></tr></table>";
 }
}
?> </td></tr>
     
</table>
</body>
</html>