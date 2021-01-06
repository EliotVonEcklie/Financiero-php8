<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
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
	function buscacta(e){
		if (document.form2.cuenta.value!=""){
			document.form2.bc.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}
	function validar(){
		document.getElementById('oculto').value='7';
		document.form2.submit();
	}

	function guardar(){
		if (document.form2.tercero.value!=''){
			despliegamodalm('visible','4','Esta Seguro de Guardar los Cambios','1');
		}
		else{
			despliegamodalm('visible','2','Faltan datos para Modificar los Datos');
			document.form2.tercero.focus();document.form2.tercero.select();
		}
	}

	function agregardetalle(){
		if(document.form2.banco.value!="" &&  document.form2.cb.value!=""){
			document.form2.agregadet.value=1;
			document.getElementById('oculto').value='7';
			document.form2.submit();
		 }
		 else {
			 despliegamodalm('visible','2','Faltan datos para Agregar el Registro');
		}
	}

	function eliminar(variable){
		document.getElementById('elimina').value=variable;
		despliegamodalm('visible','4','Esta Seguro de Eliminar el Registro','2');
	}

	function despliegamodalm(_valor,_tip,mensa,pregunta){
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden"){document.getElementById('ventanam').src="";}
		else{
			switch(_tip){
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

	function funcionmensaje(){}

	function respuestaconsulta(pregunta){
		switch(pregunta){
			case "1":	document.getElementById('oculto').value='2';document.form2.submit();break;
			case "2":	document.getElementById('oculto').value='6';
						document.form2.submit();break;
		}
	}

	function buscater(e){
		if (document.form2.tercero.value!=""){
			document.form2.bt.value='1';
			document.getElementById('oculto').value='7';
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
				var actual=document.getElementById('idcuenta').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('idcuenta').value=next;
					var idcta=document.getElementById('idcuenta').value;
					document.form2.action="teso-editacuentasbancos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('idcuenta').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('idcuenta').value=prev;
					var idcta=document.getElementById('idcuenta').value;
					document.form2.action="teso-editacuentasbancos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idrcta=document.getElementById('idcuenta').value;
				location.href="teso-buscacuentasbancos.php?idcta="+idrcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
		$scrtop=23*$totreg;
		?>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-cuentasbancos.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo" title="Nuevo" border="0" /></a>
			<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar" /></a>
			<a href="teso-buscacuentasbancos.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" class="mgbt" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
			if ($_GET[idr]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";}
			$sqlr="select MIN(tesobancosctas.ncuentaban), MAX(tesobancosctas.ncuentaban) from terceros, tesobancosctas, cuentas where terceros.cedulanit=tesobancosctas.tercero and cuentas.cuenta=tesobancosctas.cuentant ORDER BY cuentas.cuenta";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idr]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select * from terceros, tesobancosctas, cuentas where terceros.cedulanit=tesobancosctas.tercero and cuentas.cuenta=tesobancosctas.cuentant and tesobancosctas.ncuentaban='$_POST[codrec]'";
					}
					else{
						$sqlr="select * from terceros, tesobancosctas, cuentas where terceros.cedulanit=tesobancosctas.tercero and cuentas.cuenta=tesobancosctas.cuentant and tesobancosctas.ncuentaban ='$_GET[idr]'";
					}
				}
				else{
					$sqlr="select * from terceros, tesobancosctas, cuentas where terceros.cedulanit=tesobancosctas.tercero and cuentas.cuenta=tesobancosctas.cuentant ORDER BY cuentas.cuenta DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[idcuenta]=$row[24];
			}
		
 			if(($_POST[oculto]!="2")&&($_POST[oculto]!="6")&&($_POST[oculto]!="7")){	
				$sqlr="select * from terceros, tesobancosctas, cuentas where terceros.cedulanit=tesobancosctas.tercero and cuentas.cuenta=tesobancosctas.cuentant and tesobancosctas.ncuentaban='$_POST[idcuenta]' ORDER BY cuentas.cuenta";
				$res=mysql_query($sqlr,$linkbd);
				$rowt=mysql_fetch_row($res);
			//BUSCAR CUENTAS
				$sqlr="select * from terceros, tesobancosctas, cuentas where terceros.cedulanit=tesobancosctas.tercero and cuentas.cuenta=tesobancosctas.cuentant and tesobancosctas.tercero=$rowt[12] ORDER BY cuentas.cuenta";
				$res=mysql_query($sqlr,$linkbd);
				$cont=0;
				while ($row =mysql_fetch_row($res)) 
				
				{
					$_POST[tercero]=$row[12];
					$_POST[ntercero]=$row[5];
					$_POST[dncuentas][$cont]=$row[28];
					$_POST[dcuentas][$cont]=$row[27];
					$_POST[dcbs][$cont]=$row[24];
					$_POST[dtcuentas][$cont]=$row[25];
					$cont=$cont + 1;
				
				}	
					
				
			}
			if ($_POST[chacuerdo]=='2')
					 {
				    $_POST[dcuentas]=array();
				    $_POST[dncuetas]=array();
				    $_POST[dingresos]=array();
				    $_POST[dgastos]=array();
					$_POST[diferencia]=0;
					$_POST[cuentagas]=0;
					$_POST[cuentaing]=0;																			
			}	

			//NEXT
			$sqln="select * from terceros, tesobancosctas, cuentas where terceros.cedulanit=tesobancosctas.tercero and cuentas.cuenta=tesobancosctas.cuentant and tesobancosctas.ncuentaban > '$_POST[idcuenta]' ORDER BY tesobancosctas.ncuentaban ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[24]."'";
			//PREV
			$sqlp="select * from terceros, tesobancosctas, cuentas where terceros.cedulanit=tesobancosctas.tercero and cuentas.cuenta=tesobancosctas.cuentant and tesobancosctas.ncuentaban < '$_POST[idcuenta]' ORDER BY tesobancosctas.ncuentaban DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[24]."'";
?>

		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
<form  name="form2" method="post" action="">
 <?php if($_POST[bt]=='1')
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
			 
			 ?>
 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="5">.: Editar Cuentas Bancarias</td>
        <td width="116" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
     
	  <tr> <td class="saludo1" style="width:7%;">Nit Tercero:</td>
          <td style="width:15%"  >
   	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
          	<input id="tercero" type="text" name="tercero" style="width:60%" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();">
            <input type="hidden" value="0" name="bt"> 
          	<input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto" id="oculto">	
          	<input type="hidden" name="idcuenta" id="idcuenta" value="<?php echo $_POST[idcuenta]?>">	
         	<a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
        	</td>
          <td width="298" colspan="2">
		  <input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:50%" readonly></td>
	  </tr>
	  </table>
	  <table class="inicio">
	  <tr><td class="titulos" colspan="4">Cuentas</td></tr>
	  <tr>
	  <td width="27%" class="saludo1">Cuenta Contable:</td>
	  <td width="20%" >
	    <select name="banco" id="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
		<option value="">Seleccione.....</option>
	      <?php
	$linkbd=conectar_bd();
	$sqlr="select *from cuentas where left(cuenta,4)='1110' and estado='S' and tipo='Auxiliar' order by cuenta";
	
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[banco])
			 			{
						 echo "SELECTED";
						 $_POST[nbanco]=$row[1];
						 }
					  echo ">".substr($row[0]."-".$row[1],0,100)."</option>";	 	 
					}	 	
	?>
          </select>	<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> </td>
			   
		 <td width="12%" class="saludo1">Cuenta Bancaria:</td>
	  <td width="41%"><input name="cb" type="text" size="20" value="<?php echo $_POST[cb]?>" onKeyUp="return tabular(event,this)">
	  </td></tr>
	  <tr><td class="saludo1">Tipo:</td><td ><select name="tipocta" id="tipocta" onKeyUp="return tabular(event,this)" onChange="validar()">
          <option value="Ahorros" <?php if($_POST[tipocta]=='Ahorros') echo "SELECTED"; ?>>Ahorros</option>
          <option value="Corriente" <?php if($_POST[tipocta]=='Corriente') echo "SELECTED"; ?>>Corriente</option>
        </select></td><td>
	   <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"></td>	   
	  </tr> 
	   </table>
	   <div class="subpantallac2">
	   <table class="inicio">
	   <tr>
          <td class="titulos" colspan="5">Detalle Cuentas</td>
        </tr>
		<tr>
		<td class="titulos2">Cuenta</td><td class="titulos2">Cuenta Bancaria</td><td class="titulos2">Cuenta Contable</td><td class="titulos2">Tipo Cuenta</td><td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td>
		</tr>
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
			  document.getElementById('banco').focus();document.getElementById('banco').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			  }
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		 unset($_POST[dcuentas][$posi]);
		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dtcuentas][$posi]);		 
 		 unset($_POST[dcbs][$posi]);	 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		  $_POST[dncuentas]= array_values($_POST[dncuentas]); 
  		  $_POST[dtcuentas]= array_values($_POST[dtcuentas]); 
		 $_POST[dcbs]= array_values($_POST[dcbs]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcuentas][]=$_POST[banco];
		 $_POST[dncuentas][]=$_POST[nbanco];
		 $_POST[dtcuentas][]=$_POST[tipocta];		 
		 $_POST[dcbs][]=$_POST[cb];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.banco.value="";
				document.form2.nbanco.value="";
				document.form2.cb.value="";
				document.form2.cuenta.select();
		  		document.form2.cuenta.focus();	
		 </script>
		  <?php
		  }
		 for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 {		 
		 	echo "<tr><td class='saludo2'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='80' readonly></td><td class='saludo2'><input name='dcbs[]' value='".$_POST[dcbs][$x]."' type='text' size='45'></td><td class='saludo2'><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' readonly></td><td class='saludo2'><input name='dtcuentas[]' value='".$_POST[dtcuentas][$x]."' type='text' size='15'></td><td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 }
		?>
	   </table>
	   </div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
    
	$sqlr="delete from tesobancosctas where tercero='".$_POST[tercero]."'";	 
	mysql_query($sqlr,$linkbd);

 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	echo count($_POST[dcuentas]);
	//************** modificacion del presupuesto **************
	for($x=0;$x<count($_POST[dcuentas]);$x++)
	 {
	$sqlr="insert into tesobancosctas (cuenta,tercero,ncuentaban,tipo,estado) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dcbs][$x]."','".$_POST[dtcuentas][$x]."','S')";	  
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
		  document.form2.tercero.value="";
		  document.form2.ntercero.value="";
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