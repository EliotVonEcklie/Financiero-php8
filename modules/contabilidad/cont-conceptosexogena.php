<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				if( document.form2.codigo.value!="")
				{
					if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}
				}
				else {alert('Faltan datos para completar el registro');document.form2.codigo.focus();document.form2.codigo.select();}
			}
			function buscactac(e)
 			{
				if (document.form2.cuentacerrar.value!=""){document.form2.bcr.value='1';document.form2.submit();}
 			}
			function buscactacr(e)
 			{
				if (document.form2.cuentacierre.value!=""){document.form2.bcre.value='1';document.form2.submit();}
 			}
			function buscactat(e)
 			{
				if (document.form2.cuentas.value!=""){document.form2.bct.value='1';document.form2.submit();}
 			}
			function agregardetalle()
			{
				if(document.form2.cuentas.value!=""){document.form2.agregadet.value=1;document.form2.submit();}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
					document.form2.elimina.value=variable;
					vvend=document.getElementById('elimina');
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="cuentasgral-ventana01.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=cuentas&nobjeto=ncuentas";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "2":	document.getElementById('valfocus').value='1';
									document.getElementById('cuentas').focus();
									document.getElementById('cuentas').select();
									break;
					}
				}
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
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "cont-comprobantes.php";}
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.getElementById('bt').value="0";	
									mypop=window.open('cont-terceros.php','','');break;
						case "2":	document.form2.oculto.value=2;
									document.form2.action="cont-comprobantes.php";
									document.form2.submit();
									break;
						case "3":	document.form2.elidet.value="1";
									document.form2.submit();break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	document.getElementById('bt').value="0";
									document.getElementById('tercero').focus();
									document.getElementById('tercero').select();
									break;
						case "2":	break;
						case "3":	document.form2.elimina.value="";break;
					}
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
	  			<td colspan="3" class="cinta">
					<a href="cont-conceptosexogena.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a href="cont-buscaconceptosexogena.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
					<a href="cont-parametrosexogena.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
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
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
  	 		if($_POST[oculto]=="")
   			{	
   	 			$_POST[dcuentas]=array();
    			$_POST[dncuentas]=array();
    			$_POST[dtipos]=array();	
			}
			if($_POST[bct]=='1')
			{
				$nresul=buscacuenta($_POST[cuentas]);
			  	if($nresul!=''){$_POST[ncuentas]=$nresul;}
				else{$_POST[ncuentas]="";}
			}
		?>
    	<form name="form2" method="post" action="cont-conceptosexogena.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="1"/>
      		<table class="inicio">  
                <tr>
                    <td class="titulos" colspan="4">:: Conceptos Exogena</td>
                    <td class="cerrar" style='width:7%'><a href="cont-principal.php">&nbsp;Cerrar</a></td>
                </tr>     
                <tr>
                    <td class="saludo1" style="width:8%;">C&oacute;digo:</td>
                    <td valign="middle" style="width:12%;"><input type="text" id="codigo" name="codigo"  style="width:98%;" onKeyPress="javascript:return solonumeros(event)" 	onKeyUp="return tabular(event,this)" value="<?php echo $_POST[codigo]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();"/></td>
                    <td class="saludo1" style="width:8%;">Nombre:</td>
                    <td valign="middle"><input type="text" id="nombre" name="nombre" style="width:60%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"/></td>
                </tr>
			</table>
        	<table class="inicio">  
                <tr><td class="titulos"  colspan="6">:: Parametros de Cuentas</td></tr>  
                <tr>
                    <td class="saludo1" style="width:8%;">:: Cuenta:</td>
                    <td style="width:14.5%;">
                        <input type="text"  name="cuentas" id="cuentas" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" 
              onKeyUp="return tabular(event,this)" onBlur="buscactat(event)" value="<?php echo $_POST[cuentas]?>" onClick="document.getElementById('cuentas').focus();document.getElementById('cuentas').select();" placeholder='cuenta contable'/><a href="#" onClick="despliegamodal2('visible');"/>&nbsp;<img src="imagenes/find02.png" style="width:20px;" align="absmiddle"/></a>
                        <input type="hidden" value="0" name="bct"/>
                    </td>
                    <td style="width:40%;"><input type="text" name="ncuentas" id="ncuentas" value="<?php echo $_POST[ncuentas]?>" style="width:98%;" readonly/></td>
                    <td class="saludo1" style="width:6%;">Tipo:</td>
                    <td style="width:10%;">
                        <select name="debcred" id="debcred">
                            <option value="1" <?php if($_POST[debcred]=='1') echo "SELECTED"; ?>>Debito</option>
                            <option value="2" <?php if($_POST[debcred]=='2') echo "SELECTED"; ?>>Credito</option>
                            <option value="3" <?php if($_POST[debcred]=='3') echo "SELECTED"; ?>>Saldo</option>
                        </select>
                    </td>
                    <td><input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" /><input type="hidden" value="0" name="agregadet"/><input name="oculto" type="hidden" id="oculto" value="1" /></td>
                </tr>   
			</table>
        	<div class="subpantalla" style="height:59.5%; width:99.6%; overflow-x:hidden;">
        		<table class="inicio">
        			<tr><td class="titulos" colspan="4">Detalle Cuentas Concepto</td></tr>
        			<tr>
                    	<td class="titulos2">Cuenta</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2">Tipo</td>
                        <td class="titulos2">Eliminar<input type='hidden' name='elimina' id='elimina'></td>
                	</tr>   
        			<?php
		 				if($_POST[bct]==1)
			 			{
			  				$nresul=buscacuenta($_POST[cuentas]);
			  				if($nresul!='')
			   				{
								echo "<script>document.getElementById('ncuentas').value='$nresul';document.getElementById('debcred').focus(); document.getElementById('debcred').select(); document.getElementById('bct').value='';</script>";
			 				}
			 				else
			 				{
			  					$_POST[ncuentas]="";
			  					echo "<script>document.getElementById('valfocus').value='2';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
			  				}
			 			} 
						if ($_POST[elimina]!='')
		 				{ 
		 					$posi=$_POST[elimina];		 
							 unset($_POST[dcuentas][$posi]);
							 unset($_POST[dncuentas][$posi]);
							 unset($_POST[dtipos][$posi]);		 
							 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
							 $_POST[dncuentas]= array_values($_POST[dncuentas]); 		 
							 $_POST[dtipos]= array_values($_POST[dtipos]); 		 
						}
						if ($_POST[agregadet]=='1')
		 				{
						 	$_POST[dcuentas][]=$_POST[cuentas];
						 	$_POST[dncuentas][]=$_POST[ncuentas];
							$_POST[dtipos][]=$_POST[debcred];	
		 					$_POST[agregadet]=0;
		 				}
						$numctas=count($_POST[dcuentas]);
						$co="saludo1a";
						$co2="saludo2";		
						$tipos=array('','Debito','Credito','Saldos');
						for ($x=0;$x<$numctas;$x++)
		 				{
							echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\"><td><input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'> ".$_POST[dcuentas][$x]."</td><td><input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'> ".$_POST[dncuentas][$x]."</td><td><input type='hidden' name='dtipos[]' value='".$_POST[dtipos][$x]."'> ".$tipos[$_POST[dtipos][$x]]."</td><td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";			 
							$aux=$co;
							$co=$co2;
							$co2=$aux;								
						}
					?>     
        		</table>
        	</div>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
    	</form>
  		<?php
			$oculto=$_POST['oculto'];
			if($_POST[oculto]=="2")
			{
				echo "<div class='subpantallac'>";
				$sqlr="insert into contexogenaconce_cab (codigo, nombre, estado) values ('".$_POST[codigo]."','".$_POST[nombre]."','S')";
				if (mysql_query($sqlr,$linkbd))
				{
					$numctas=count($_POST[dcuentas]);
					for ($x=0;$x<$numctas;$x++)
 					{
  						$sqlr="insert into contexogenaconce_det (codigo, cuenta, tipo,estado) values ('".$_POST[codigo]."','".$_POST[dcuentas][$x]."','".$_POST[dtipos][$x]."','S') ";
  						if (!mysql_query($sqlr,$linkbd))
						{
	 						echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>Ocurrió el siguiente problema:<br><pre>".mysql_error($linkbd)."</pre></center></td></tr></table>";
						}
						else
 						{
  							echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado el Concepto ".$_POST[dcuentacerrar][$x]."  ".$_POST[dcuentacierre][$x]." ".$_POST[dcuentatras][$x]." <img src='imagenes/confirm.png'></center></td></tr></table>";
						} 
 					}
					echo "</div>";
 				}
  				else
  				{
	   				echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b></b></font></p>Ocurrió el siguiente problema:<br><pre>".mysql_error($linkbd)."</pre></center></td></tr></table>";
  				}
			}
		?>
	</body>
</html>