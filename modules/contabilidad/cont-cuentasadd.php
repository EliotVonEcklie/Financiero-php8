<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
		<script>
			function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}
			function guardar()
			{
				var validacion01=document.getElementById('cuenta').value;
				var validacion02=document.getElementById('descripcion').value;
				if((validacion01.trim()!='')&&(validacion02.trim()!='')){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
	 		}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if(document.getElementById('valfocus').value=="2")
					{
						document.getElementById('valfocus').value='1';
						document.getElementById('cuenta').focus();
						document.getElementById('cuenta').select();
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
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "cont-cuentasadd.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value=2;
						document.form2.otipo.value=document.form2.tipo.value;
						document.form2.occ.value=document.form2.cc.value;
						document.form2.otercero.value=document.form2.tercero.value;
						document.form2.action="cont-cuentasadd.php";
						document.form2.submit();
						break;
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
					<a class="mgbt" onClick="location.href='cont-cuentasadd.php'"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a onClick="location.href='cont-cuentas.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a href="" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
           	</tr>
    	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="cont-cuentasadd.php">
			<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="9">.: Agregar Cuentas</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='cont-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:10%;">.: Cuenta:</td>
                    <td style="width:10%;"><input type="text" name="cuenta" id="cuenta" value="<?php echo $_POST[cuenta]?>" style="width:98%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  onBlur="buscacta(event)"/><input type="hidden" value="0" name="bc"/></td>
                    <td class="saludo1" style="width:13%;">.: Descripción:</td>
                    <td colspan="6"><input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:70%;" onKeyUp="return tabular(event,this)"/></td>
                </tr>
                <tr>
                    <td class="saludo1">.: Naturaleza:</td>	
                    <td>
                        <select name="naturaleza" id="natualeza" style="width:98%;">
                            <option value="CREDITO" <?php if ($_POST[naturaleza]=="CREDITO"){echo "selected";}?>>CREDITO</option>
                            <option value="DEBITO" <?php if ($_POST[naturaleza]=="DEBITO"){echo "selected";}?>>DEBITO</option>
                        </select> 
                    </td>
                    <td class="saludo1">.: Centro de Costo:</td>
                    <td style="width:6%;">
                        <select name="cc" id="cc" style="width:95%;">
                            <option value="S" <?php if ($_POST[cc]=="S"){echo "selected";}?>>SI</option>
                            <option value="N" <?php if ($_POST[cc]=="N"){echo "selected";}?>>NO</option>
                        </select> 
                    </td>
                    <td class="saludo1" style="width:8%;">.: Tercero:</td>
                    <td style="width:6%;">
                        <select name="tercero" id="tercero" style="width:95%;">
                            <option value="S" <?php if ($_POST[tercero]=="S"){echo "selected";}?>>SI</option>
                            <option value="N" <?php if ($_POST[tercero]=="N"){echo "selected";}?>>NO</option>
                        </select>  
                    </td> 
                    <td class="saludo1" style="width:8%;">.: Tipo:</td>
                    <td>
                        <select name="tipo" id="tipo" disabled style="width:30%;">
                        	<option value="Mayor" <?php if ($_POST[tipo]=="Mayor"){echo "selected";}?>>Mayor</option>
                            <option value="Auxiliar" <?php if ($_POST[tipo]=="Auxiliar"){echo "selected";}?>>Auxiliar</option>
                        </select> 
                        <input type="hidden" name="oculto" id="oculto" value="1"/>   
                        <input type="hidden" name="otipo" value=""/> 
                        <input type="hidden" name="otercero" value=""/>
                        <input type="hidden" name="occ" value=""/> 
                        <input type="hidden" name="valfocus" id="valfocus" value="1"/> 
                    </td>
                </tr>                 
    		</table>
  		<?php
			$oculto=$_POST['oculto'];
			$otipo=$_POST['otipo'];
			$occ=$_POST['occ'];
			$otercero=$_POST['otercero'];
			if($_POST[oculto]==2)
			{
				$sqlr="INSERT INTO cuentas (cuenta,nombre,naturaleza,centrocosto,tercero,tipo,estado) VALUES ('$_POST[cuenta]','$_POST[descripcion]', '$_POST[naturaleza]','$occ','$otercero','$otipo','S')";
  				if (!mysql_query($sqlr,$linkbd)) {echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";}
				else {echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";}
			}
			if($_POST[bc]=='1')
			{
			  	$nresul=existecuenta($_POST[cuenta]);
			  	if($nresul!='')
			   	{		  
  			  	echo"
			  	<script>
					res='$nresul';
					texaler='Esta cuenta ya existe su descripcion es '+res
					despliegamodalm('visible','2',texaler);
					document.getElementById('valfocus').value='2';
				</script>";
			  	}
			 	else
				{	
					$cant=strlen($_POST[cuenta]);
					if ($can==3 or $can==5 or $can==7 or $can==9 or $can==11 or $can==13 or $can==15)
						{
							echo"
								<script>
									despliegamodalm('visible','2','No se puede crear cuenta... Cuenta erronea ...! ');
									document.getElementById('valfocus').value='2';
								</script>";
						}
					else
			 		{
			 			if($cant>1)
			 			{
							$sqlr="select *from nivelesctas where posiciones=$cant";
			  				$res=mysql_query($sqlr,$linkbd);
			  				$con=mysql_fetch_row($res);
							$ncuen=substr($_POST[cuenta],'0',$cant-$con[1]);
							$resultado=existecuenta($ncuen);
							if($resultado!='')
							{
			  					if ($cant<=6)
									{echo "<script>document.form2.tipo.value='Mayor';document.form2.descripcion.focus();</script>";}
								else
								{
									echo"
										<script>
											document.form2.tercero.value='S';	
											document.form2.tipo.value='Auxiliar';	
											document.form2.tercero.disabled='disabled';
											document.form2.cc.disabled='disabled';
											document.form2.descripcion.focus();
										</script>";
								}
							}
			 				else
							{
								echo "
									<script>
										despliegamodalm('visible','2','No existe cuenta mayor para crear esta cuenta');
										document.getElementById('valfocus').value='2';
									</script>";}
						}
						else
							{echo "<script>document.form2.tipo.value='Mayor';document.form2.descripcion.focus();</script>";}	
					}
				}	 
			}
		?>		
        <script type="text/javascript">$('#descripcion').alphanum({allow: ''});</script>
        <script type="text/javascript">$('#cuenta').numeric({allowThouSep: false,allowDecSep: false});</script>
        
        </form>	 
	</body>
</html>