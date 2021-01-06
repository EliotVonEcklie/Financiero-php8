<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>

<script>
	function guardar()
	{
		if (document.form2.fecha.value!='' && document.form2.acuerdo.value!='')
		{
			despliegamodalm('visible','4','Esta Seguro de Modificar','1');
		}
		else{
			despliegamodalm('visible','2','Faltan datos para Modificar el registro');
			document.form2.acuerdo.focus();document.form2.acuerdo.select();
		}
	}

	function clasifica(formulario)
	{
		//document.form2.action="presu-recursos.php";
		document.form2.submit();
	}

	function despliegamodalm(_valor,_tip,mensa,pregunta)
	{
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden"){document.getElementById('ventanam').src="";}
		else
		{
			switch(_tip)
			{
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

	function funcionmensaje(){
		// document.location.href = "presu-editaacuerdos.php";
		}
	function respuestaconsulta(pregunta)
	{
		switch(pregunta)
		{
			case "1":	
				document.getElementById('oculto').value='2';
				document.form2.submit();
				break;
		}
	}
</script>
		<script>
			function adelante(scrtop, numpag, limreg, totreg, next){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=next;
				var idcta=document.getElementById('codigo').value;
				totreg++;
				document.form2.action="teso-editaacuerdo.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg;
				document.form2.submit();
			}
		
			function atrasc(scrtop, numpag, limreg, totreg, prev){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=prev;
				var idcta=document.getElementById('codigo').value;
				totreg--;
				document.form2.action="teso-editaacuerdo.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg;
				document.form2.submit();
			}

			function iratras(scrtop, numpag, limreg){
				var idcta=document.getElementById('codigo').value;
				location.href="teso-buscaracuerdo.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg;
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
					<a href="teso-acuerdo.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a href="teso-buscaracuerdo.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
        	</tr>
        </table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
<?php
$vigencia=date(Y);
$linkbd=conectar_bd();
 ?>	
<?php
if(!$_POST[oculto])
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[vigencia]=$vigencia;		 		  			 
		 $_POST[valor]=0;		 
}
?>
 <form name="form2" method="post" action="">
 		<?php
			if ($_GET[idacuerdo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idacuerdo];</script>";}
			$sqlr="Select * from tesoacuerdo ORDER BY tesoacuerdo.vigencia DESC, tesoacuerdo.consecutivo";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idacuerdo]!=""){
					if($_POST[codrec]!=""){
						$sqlr="Select * from tesoacuerdo where id_acuerdo='$_POST[codrec]'";
					}
					else{
						$sqlr="Select * from tesoacuerdo where id_acuerdo ='$_GET[idacuerdo]'";
					}
				}
				else{
					$sqlr="Select * from tesoacuerdo ORDER BY tesoacuerdo.vigencia DESC, tesoacuerdo.consecutivo";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
				$_POST[numero]=$row[1];					
				$_POST[acuerdo]=$row[2];
				// echo $row[3];
				$ff=split("-",$row[3]);
				$_POST[fecha]=$ff[2]."/".$ff[1]."/".$ff[0];	
				// echo $_POST[fecha];		
				$_POST[tipoacuerdo]=$row[10];				
				$_POST[valor]=$row[5];					
			}
 			if($_POST[oculto]!="2")
			{
				$sqlr="Select * from tesoacuerdo where id_acuerdo=$_POST[codigo] ";
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp))
				{
					$_POST[codigo]=$row[0];
					$_POST[numero]=$row[1];					
					$_POST[acuerdo]=$row[2];		
					$ff=split("-",$row[3]);
					$_POST[fecha]=$ff[2]."/".$ff[1]."/".$ff[0];			
					$_POST[valor]=$row[5];			
				}
			}
			//NEXT
			$sqln="Select * from tesoacuerdo where id_acuerdo > '$_POST[codigo]' ORDER BY vigencia DESC, consecutivo ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next=$row[0];
			//PREV
			$sqlp="Select * from tesoacuerdo where id_acuerdo < '$_POST[codigo]' ORDER BY vigencia DESC, consecutivo DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev=$row[0];
 		?>
    <table class="inicio" align="center" width="80%" >
      	<tr >
        	<td class="titulos" colspan="2" style="width: 95%">.: Editar Acto Administrativo </td>
        	<td class="cerrar" style="width: 5%" ><a href="presu-principal.php"> Cerrar</a></td>
      	</tr>
      	<tr>
      		<td style="width:75%;">
      			<table>
      				<tr  >
				  		<td  class="saludo1" style="width: 15%">Fecha: </td>
			        	<td style="width: 30%">
							<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width: 40%" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
							<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
							<input type="hidden" id="codigo" name="codigo" value="<?php echo $_POST[codigo]?>">
							<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
							<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
							<input type="hidden" value="<?php echo $_POST[edicion]?>" name="edicion" id="edicion">
					</td>
					<td class="saludo1" style="width: 15%">Numero:</td>
			        <td  valign="middle" style="width: 20%" >
			   	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $totreg; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
						<input type="text" id="numero" name="numero" style="width: 60%" onKeyPress="javascript:return solonumeros(event)" 
					  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();">
			            <a onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $totreg; ?>, <?php echo $next; ?>)"  style='cursor:pointer;'><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
					</td>
					<td style="width: 33%"></td>
				  </tr>
				  <tr>
					 <td  class="saludo1">Acto Administrativo:</td>
			          <td  valign="middle" colspan="3" ><input type="text" id="acuerdo" name="acuerdo"  style="width: 100%" 
					  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[acuerdo]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td>
				  </tr>
					   <tr>	  
					  <td class="saludo1">Valor:</td>
					  <td>
						<input name="valor" type="text" style="width: 80%" onKeyPress="javascript:return solonumeros(event)" 
					  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[valor];?>">
						<input name="valortraslados" type="hidden"  value="<?php echo $_POST[valortraslados];?>"><input name="valorreduccion" type="hidden"  value="0"><input name="valoradicion" type="hidden"  value="0"><input name="valoradicion" type="hidden"  value="0"></td>
			  		  <td>
						<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
					  </td>
					  </tr>
      			</table>
      		</td>
      		<td colspan="3" style="width:25%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>
      	</tr>
    </table>
	<?php
	if(!$_POST[oculto])
	{ 
		 ?>
		 <script>
    	document.form2.fecha.focus();
		</script>
	<?php
	}
	?>
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$linkbd=conectar_bd();
if ($_POST[acuerdo]!=""){
	if ($_POST[edicion]=="S"){
		$nr="1";	
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		// echo $fechaf;
		$sqlr="update tesoacuerdo set detalle_acuerdo='$_POST[acuerdo]', fecha='$fechaf', vigencia='$fecha[3]',valor='$_POST[valor]' where id_acuerdo=$_POST[codigo]";	
		// echo "sqlr:".$sqlr;
		if(!mysql_query($sqlr,$linkbd)){
			echo"<script>despliegamodalm('visible','2','ERROR EN LA ACTUALIZACION DEL ACUERDO');</script>";
		}
		else{
			echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado con Exito</h2></center></td></tr></table>";
			echo"<script>despliegamodalm('visible','1','Se ha modificado el ACUERDO con Exito');</script>";
		}
	}
	else{
		echo"<script>despliegamodalm('visible','2','No es posible Modificar el Acuerdo');
			document.form2.acuerdo.focus();document.form2.acuerdo.select();
		</script>";
	}
}
else{
	echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear el Acuerdo de Modificacion al Presupuesto</H2></center></td></tr></table>";
	echo "<script>document.form2.fecha.focus();</script>";  
 }
 }
?> 
</td></tr>     
</table>
</body>
</html>