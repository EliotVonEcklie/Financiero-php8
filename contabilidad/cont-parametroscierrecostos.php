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
				if(document.getElementById('cotcant').value!="0"){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else{despliegamodalm('visible','2',"Falta información para poder guardar")}
			}
			function buscactac(e){if (document.form2.cuentacerrar.value!=""){document.form2.bcr.value='1';document.form2.submit();}}
			function buscactacr(e){if (document.form2.cuentacierre.value!=""){document.form2.bcre.value='1';document.form2.submit();}}
			function buscactat(e){if (document.form2.cuentatras.value!=""){document.form2.bct.value='1';document.form2.submit();}}
			function agregardetalle()
			{
				if((document.form2.cuentacerrar.value!="")&&(document.form2.cuentacierre.value!="")&&(document.form2.cuentatras.value!=""))
				{document.form2.agregadet.value="1";document.form2.submit();}
			 	else {despliegamodalm('visible','2',"Falta informacion para poder Agregar")}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function despliegamodal2(_valor,_nomve)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_nomve)
					{
						case "1":	document.getElementById('ventana2').src="cuentasgral-ventana02.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=cuentacerrar&nobjeto=ncuentacerrar";;break;
						case "2":	document.getElementById('ventana2').src="cuentasgral-ventana01.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=cuentacierre&nobjeto=ncuentacierre";;break;
						case "3":	document.getElementById('ventana2').src="cuentasgral-ventana01.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=cuentatras&nobjeto=ncuentatras";;break;
					}
					
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('valfocus').value='0';
									document.getElementById('cuentacerrar').focus();
									document.getElementById('cuentacerrar').select();
									break;
						case "2":	document.getElementById('valfocus').value='0';
									document.getElementById('cuentacierre').focus();
									document.getElementById('cuentacierre').select();
									break;
						case "3":	document.getElementById('valfocus').value='0';
									document.getElementById('cuentatras').focus();
									document.getElementById('cuentatras').select();
									break;
					}
				}
				else
				{
					switch(_tip)
					{
						case "1":alert();
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
			function respuestaconsulta(estado,pregunta)
			{
				switch(estado)
				{
					case "1":	document.form2.oculto.value="2";
								document.form2.submit();break;
					case "2":	document.form2.oculto.value="6";
								document.form2.submit();break;
				}
				switch(pregunta)
				{
					case "1":	break;
					case "2":	break;
				}
			}
			
			function funcionmensaje(){document.location.href = "cont-.php";}
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
	  			<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png"/></a><a href="#" class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png" title="Guardar" /></a><a class="mgbt" ><img src="imagenes/buscad.png"/></a><a href="#" class="mgbt" onClick="<?php echo paginasnuevas("cont");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
  			</tr>
   		</table>
          <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" action="cont-parametroscierrecostos.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
                if($_POST[oculto]=="")
                {	
                    $_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;
                    $_POST[dcuentacierre]=array();
                    $_POST[dcuentacerrar]=array();
                    $_POST[dcuentatras]=array();	
                    $sqlr="SELECT * FROM contparametroscierrecostos";
                    $res=mysql_query($sqlr,$linkbd);
                    while($row=mysql_fetch_row($res))
                    {
                        $_POST[dcuentacerrar][]=$row[0];
                        $_POST[dcuentacierre][]=$row[1];
                        $_POST[dcuentatras][]=$row[2];	
                    }
                }
            ?>
      		<table class="inicio">  
     			<tr >
        			<td class="titulos" colspan="4">:: Parametros de Cierre de Cuentas de Costos</td>
                    <td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
           		<tr>
        			<td class="saludo1" style="width:15%;">:: Cuenta a Cerrar:</td>
        			<td style="width:20%;">
        				<input type="text" name="cuentacerrar" id="cuentacerrar" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactac(event)" value="<?php echo $_POST[cuentacerrar]?>" onClick="document.getElementById('cuentacerrar').focus();document.getElementById('cuentacerrar').select();" placeholder='cuenta contable'>&nbsp;<a href="#" onClick="despliegamodal2('visible','1');">
        				<img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a>
        			</td>
          			<td><input type="text" name="ncuentacerrar" id="ncuentacerrar" value="<?php echo $_POST[ncuentacerrar]?>" style="width:60%;" readonly></td>
        		</tr>           
           		<tr>
        			<td class="saludo1">:: Cuenta de Cierre :</td>
        			<td><input type="text" id="cuentacierre" name="cuentacierre" style="width:80%;" onKeyPress="javascript:return solonumeros(event)"
		  onKeyUp="return tabular(event,this)" onBlur="buscactacr(event)" value="<?php echo $_POST[cuentacierre]?>" onClick="document.getElementById('cuentacierre').focus();document.getElementById('cuentacierre').select();" placeholder='cuenta contable'>&nbsp;<a href="#" onClick="despliegamodal2('visible','2');"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a></td>
          			<td><input id="ncuentacierre"  name="ncuentacierre" type="text" value="<?php echo $_POST[ncuentacierre]?>" style="width:60%;" readonly></td>
        		</tr>   
         		<tr>
        			<td  class="saludo1">:: Cuenta de Traslado:</td>
       				<td><input type="text" id="cuentatras" name="cuentatras" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscactat(event)" value="<?php echo $_POST[cuentatras]?>" onClick="document.getElementById('cuentatras').focus();document.getElementById('cuentatras').select();" placeholder='cuenta contable'>&nbsp;<a href="#" onClick="despliegamodal2('visible','3');"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a></td>
          			<td><input id="ncuentatras" name="ncuentatras" type="text" value="<?php echo $_POST[ncuentatras]?>" style="width:60%;" readonly> <input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"></td>
        		</tr>   
        	</table>
            <input type="hidden" name="oculto"  id="oculto" value="1"/>
            <input type="hidden" name="bcr" id="bcr" value="0"/>
            <input type="hidden" name="bcre" id="bcre" value="0"/>
            <input type="hidden" name="bct" id="bct" value="0">
            <input type="hidden" name="cotcant" id="cotcant" value="<?php echo $_POST[cotcant];?>"/>
            <input type="hidden" name="elimina" id="elimina" value="<?php echo $_POST[elimina];?>"/>
        	<div class="subpantalla"  style="height:61%; width:99.6%; overflow-x:hidden;">
       			<?php
					if($_POST[bcr]==1)
					{
						$nresul=buscacuentacont($_POST[cuentacerrar]);
						if($nresul!='')
						{
							echo "
								<script>
									document.getElementById('bcr').value='';
									document.getElementById('ncuentacerrar').value='$nresul';
								</script>";
						}
						else
						{
							echo "
							<script>
								document.getElementById('ncuentacerrar').value='';
								document.getElementById('bcr').value='';
								document.getElementById('valfocus').value='1';
								despliegamodalm('visible','2','Cuenta Incorrecta a Cerrar');
							</script>";
						}
					} 
					if($_POST[bcre]==1)
					{			 
						$nresul=buscacuenta($_POST[cuentacierre]);
						if($nresul!='')
						{
							echo "
							<script>
								document.getElementById('bcre').value='';
								document.getElementById('ncuentacierre').value='$nresul';
							</script>";
						}
						else
						{
							echo "
							<script>
								document.getElementById('ncuentacierre').value='';
								document.getElementById('bcre').value='';
								document.getElementById('valfocus').value='2';
								despliegamodalm('visible','2','Cuenta Incorrecta de Cierre');
							</script>";
						}
					} 
					if($_POST[bct]==1)
					{
						$nresul=buscacuenta($_POST[cuentatras]);
						if($nresul!='')
						{
							echo "
							<script>
								document.getElementById('bct').value='';
								document.getElementById('ncuentatras').value='$nresul';
							</script>";
						}
						else
						{
							echo "
							<script>
								document.getElementById('ncuentatras').value='';
								document.getElementById('bct').value='';
								document.getElementById('valfocus').value='3';
								despliegamodalm('visible','2','Cuenta Incorrecta de Traslado');
							</script>";
						}
					} 
					if ($_POST[oculto]=='6')
					{ 
						$posi=$_POST[elimina];		 
						unset($_POST[dcuentacierre][$posi]);
						unset($_POST[dcuentacerrar][$posi]);
						unset($_POST[dcuentatras][$posi]);		 
						$_POST[dcuentacierre]= array_values($_POST[dcuentacierre]); 
						$_POST[dcuentacerrar]= array_values($_POST[dcuentacerrar]); 		 
						$_POST[dcuentatras]= array_values($_POST[dcuentatras]); 		 
					}
					if ($_POST[agregadet]=='1')
					{
						$_POST[dcuentacierre][]=$_POST[cuentacierre];
						$_POST[dcuentacerrar][]=$_POST[cuentacerrar];
						$_POST[dcuentatras][]=$_POST[cuentatras];	
						$_POST[agregadet]=0;
					}
					echo"
						<table class='inicio'>
        					<tr><td class='titulos' colspan='4'>Detalle Cuentas de Cierre de Costos</td></tr>
       						<tr>
                    			<td class='titulos2'>Cuenta Cerrar</td>
                        		<td class='titulos2'>Cuenta Cierre</td>
                        		<td class='titulos2'>Cuenta Traslado</td>
                        		<td class='titulos2' style='width:5%;'>Eliminar</td>
                 			</tr>";
					$numctas=count($_POST[dcuentacierre]);
					echo"<script>document.getElementById('cotcant').value=$numctas;</script>";
					$co="saludo1a";
					$co2="saludo2";	
					for ($x=0;$x<$numctas;$x++)
					{
						echo "
						<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
							<td style='width:30%;'><input type='hidden' name='dcuentacerrar[]' value='".$_POST[dcuentacerrar][$x]."'> ".$_POST[dcuentacerrar][$x]." - ".buscacuenta($_POST[dcuentacerrar][$x])."</td>
							<td style='width:30%;'><input type='hidden' name='dcuentacierre[]' value='".$_POST[dcuentacierre][$x]."'>".$_POST[dcuentacierre][$x]." - ".buscacuenta($_POST[dcuentacierre][$x])."</td>
								<td><input type='hidden' name='dcuentatras[]' value='".$_POST[dcuentatras][$x]."'>".$_POST[dcuentatras][$x]." - ".buscacuenta($_POST[dcuentatras][$x])."</td>
							<td><a href='#' onclick='eliminar($x);'><img src='imagenes/del.png'></a></td>
						</tr>";			 
						$aux=$co;
						$co=$co2;
						$co2=$aux;								
					}
					echo"</table>";
				?>     
        	</div>
 			<?php
				$oculto=$_POST['oculto'];
				if($_POST[oculto]=="2")
				{
					echo "<div class='subpantallac'>";
					//****CUENTA_COSTOS_CREDITO
					$sqlr="delete from contparametroscierrecostos   ";
					mysql_query($sqlr,$linkbd);
					$numctas=count($_POST[dcuentacierre]);
					for ($x=0;$x<$numctas;$x++)
					{
						$sqlr="insert into contparametroscierrecostos (cuentacerrar, cuentacierre, cuentatras) values ('".$_POST[dcuentacerrar][$x]."','".$_POST[dcuentacierre][$x]."','".$_POST[dcuentatras][$x]."') ";
						if (!mysql_query($sqlr,$linkbd))
						{
							echo"<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD, No se pudo ejecutar la petición');</script>";
						}
						else
						{
							echo"<script>despliegamodalm('visible','3','Se ha Almacenado los Parametros de Cierre de Costos ".$_POST[dcuentacerrar][$x]." - ".$_POST[dcuentacierre][$x]." - ".$_POST[dcuentatras][$x]."');</script>";
						} 
					}
					echo"</div>";
				}
			?>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
     	</form>
	</body>
</html>


