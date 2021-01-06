<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
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
	function buscacta(e){
		if (document.form2.cuenta.value!=""){
			document.form2.bc.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}

	function buscactap(e){
		if (document.form2.cuentap.value!=""){
			document.form2.bcp.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}

	function validar(){
		document.getElementById('oculto').value='7';
		document.form2.submit();
	}

	function guardar(){
		if (document.form2.codigo.value!='' && document.form2.nombre.value!=''){
			despliegamodalm('visible','4','Esta Seguro de Guardar los Cambios','1');
		}
		else{
			despliegamodalm('visible','2','Faltan datos para Modificar los Datos');
			document.form2.nombre.focus();document.form2.nombre.select();
		}
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
					document.form2.action="teso-editasanciones.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="teso-editasanciones.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="teso-buscasanciones.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
  <td colspan="3" class="cinta"><a href="teso-sanciones.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscasanciones.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" /></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a><a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
 ?>	
<?php
			if ($_GET[idr]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";}
			$sqlr="select MIN(CONVERT(id_sancion, SIGNED INTEGER)), MAX(CONVERT(id_sancion, SIGNED INTEGER)) from tesosanciones ORDER BY CONVERT(id_sancion, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idr]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from tesosanciones where id_sancion='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from tesosanciones where id_sancion ='$_GET[idr]'";
					}
				}
				else{
					$sqlr="select * from  tesosanciones ORDER BY CONVERT(id_sancion, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}
		
		if(($_POST[oculto]!="2")&&($_POST[oculto]!="7")){	
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		 
		 $linkbd=conectar_bd();
		 $sqlr="Select *from tesosanciones where id_sancion=".$_POST[codigo];
		 $res=mysql_query($sqlr,$linkbd);
		 $row=mysql_fetch_row($res);
		 $_POST[codigo]=$row[0];
		 $_POST[nombre]=$row[1];
		 $_POST[valor]=$row[4];	
		 $_POST[cuenta]=$row[2];
		 $_POST[ncuenta]=buscacuenta($_POST[cuenta]);
		 $_POST[cuentap]=$row[3];		
		 $_POST[ncuentap]=buscacuentapres($_POST[cuentap],1);		 	 	 		 
}
			//NEXT
			$sqln="select *from tesosanciones WHERE id_sancion > '$_POST[codigo]' ORDER BY id_sancion ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from tesosanciones WHERE id_sancion < '$_POST[codigo]' ORDER BY id_sancion DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";

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
			 
			 ?>
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">Edita Sancion </td>
        <td width="121" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td width="88" class="saludo1">Codigo:        </td>
        <td style="width:15%">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
        	<input name="codigo" id='codigo' type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" style="width:30%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">        
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
       	</td>
        <td width="105" class="saludo1">Nombre:        </td>
        <td width="593"><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="86" onKeyUp="return tabular(event,this)">        </td>
		<td width="92" class="saludo1">Porcentaje:</td><td width="90"><input id="valor" name="valor" type="text" value="<?php echo $_POST[valor]?>" onKeyUp="return tabular(event,this)" size="5" onKeyPress="javascript:return solonumeros(event)"> % <input type="hidden" name="oculto" id="oculto" value="1"></td>
       </tr> 
      </table>
	  
	   <table class="inicio">
	   <tr>
	     <td colspan="5" class="titulos">Detalle Sancion </td>
	   </tr>                  
				  <tr>
	<td width="13%" class="saludo1">Cuenta Contable: </td>
          <td colspan="2"  valign="middle" ><input type="text" id="cuenta" name="cuenta" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="" name="bc"><a href="#" onClick="mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td width="69%" ><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="80" readonly></td>
	     </tr>
				  <tr><td class="saludo1">Cuenta presupuestal: </td>
          <td colspan="2" valign="middle" ><input type="text" id="cuentap" name="cuentap" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscactap(event)" value="<?php echo $_POST[cuentap]?>" onClick="document.getElementById('cuentap').focus();document.getElementById('cuentap').select();"><input type="hidden" value="" name="bcp" id="bcp"><a href="#" onClick="mypop=window.open('scuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
	      <td colspan="2" valign="middle" ><input name="ncuentap" type="text" value="<?php echo $_POST[ncuentap]?>" size="80" readonly></td>
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
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$linkbd=conectar_bd();
if ($_POST[nombre]!="" and $_POST[codigo]!="" )
 {  
 $nr="1";
 $sqlr="delete from tesosanciones where id_sancion=".$_POST[codigo];
// echo "ddddd".$sqlr;
 mysql_query($sqlr,$linkbd);
 $sqlr="INSERT INTO tesosanciones (id_sancion,nombre,cuentacontable,cuentapptal,porcentaje,estado)VALUES ('$_POST[codigo]','".utf8_decode($_POST[nombre])."','$_POST[cuenta]','$_POST[cuentap]','$_POST[valor]','S')";
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
  echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado con Exito</h2></center></td></tr></table>";
  }
 }
else
 {
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear la Sancion</H2></center></td></tr></table>";
 }
}
?> </td></tr>
     
</table>
</body>
</html>