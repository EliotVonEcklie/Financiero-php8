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
        <title>:: Spid - Meci Calidad</title>
        <script>
			function busquedajs(tipo)
			{
				switch(tipo)
                {
                    case "1":
						if (document.form2.responsablet1.value!=""){document.form2.busquedas.value=tipo;document.form2.submit();}
						break;
					 case "2":
						if (document.form2.responsablet2.value!=""){document.form2.busquedas.value=tipo;document.form2.submit();}
						break;
					 case "3":
						if (document.form2.responsablet3.value!=""){document.form2.busquedas.value=tipo;document.form2.submit();}
						break;
				}
			}
			function despliegamodal2(_valor,tipo)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else{document.getElementById('ventana2').src="meci-insparticipacionresponsables.php?tipo="+tipo;}
			}
			function despliegamodalm(_valor,_tip,mensa)
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
					}
				}
			}
			function funcionmensaje()
			{
				var pesact=document.form2.tabgroup1.value;
				switch(pesact)
                {
                    case "1": document.getElementById('ocutc1').value="";break;
                    case "2": document.getElementById('ocutc2').value="";break;
					case "3": document.getElementById('ocutc3').value="";break;
					case "4": document.getElementById('ocumlg').value="";break;
                }
				document.form2.submit();
			}
			function guardar()
			{
				var pesact=document.form2.tabgroup1.value; var varver='N'; var nomgua='';
				switch(pesact)
                {
                    case "1":
						if(document.getElementById('bana01').value!=0)
							{varver='S';nomgua='Esta Seguro de Guardar los Representantes para el Comit\xe9 Coordinador CI';}
                        break;
                    case "2":
						if(document.getElementById('bana02').value!=0)
							{varver='S';nomgua='Esta Seguro de Guardar los Representantes para Alta Direcci\xf3n';}
                        break;
                    case "3":
						if(document.getElementById('bana03').value!=0)
							{varver='S';nomgua='Esta Seguro de Guardar los Representantes para el Equipo Meci'}
                        break;
                    case "4":
						if(document.getElementById('banmlg').value!=0)
							{varver='S'; nomgua='Esta Seguro de Guardar los Protocolos Eticos'}
                        break;
                }
				if(varver=='S'){if (confirm(nomgua)){document.form2.oculto.value="1";document.form2.submit();}}
				else{despliegamodalm('visible','2','Falta informaci\xf3n para poder Guardar');}
			}
			function agregarlista1()
			{
				if(document.getElementById('nresponsablet1').value!="" && document.getElementById('fechai1').value!="" && document.getElementById('cargo1').value!="")
				{
					document.getElementById('bana01').value=parseInt(document.getElementById('bana01').value)+1;
					document.form2.agregar01.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar');}
			}
			function agregarlista2()
			{
				if(document.getElementById('nresponsablet2').value!="" && document.getElementById('fechai2').value!="")
				{
					document.getElementById('bana02').value=parseInt(document.getElementById('bana02').value)+1;
					document.form2.agregar02.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar');}
			}
			function agregarlista3()
			{
				if(document.getElementById('nresponsablet3').value!="" && document.getElementById('fechai3').value!="")
				{
					document.getElementById('bana03').value=parseInt(document.getElementById('bana03').value)+1;
					document.form2.agregar03.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar');}
			}
			function eliminarl1(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			 	{
					document.getElementById('bana01').value=parseInt(document.getElementById('bana01').value)-1;
					document.form2.eliminal1.value=variable;
					document.getElementById('eliminal1').value=variable;
					document.form2.submit();
				}
			}
			function eliminarl2(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			 	{
					document.getElementById('bana02').value=parseInt(document.getElementById('bana02').value)-1;
					document.form2.eliminal2.value=variable;
					document.getElementById('eliminal2').value=variable;
					document.form2.submit();
				}
			}
			function eliminarl3(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			 	{
					document.getElementById('bana03').value=parseInt(document.getElementById('bana03').value)-1;
					document.form2.eliminal3.value=variable;
					document.getElementById('eliminal3').value=variable;
					document.form2.submit();
				}
			}
			function agregarmarco()
			{
				if((document.form2.protocolo.value!="")&&(document.form2.fecmls.value!="")&&(document.form2.desmar.value!="")&&(document.form2.nomarch.value!=""))
				{
					document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)+1;
					document.form2.agregamlg.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar');}	
			}
			function eliminarml(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			 	{
					document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)-1;
					document.form2.eliminaml.value=variable;
					document.getElementById('eliminaml').value=variable;
					document.form2.submit();
				}
			}
		</script>
		<script type="text/javascript" src="css/programas.js"></script>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<?php 
			titlepag();
			function eliminarDir()
			{
				$carpeta="informacion/protocolos_eticos/temp";
				foreach(glob($carpeta . "/*") as $archivos_carpeta)
				{
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta);
			}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("meci");?></tr>
          	<tr>
          		<td colspan="3" class="cinta"><a href="meci-insparticipacion.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="meci-insparticipacionbusca.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" class="mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
		</table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" enctype="multipart/form-data"> 
			<?php
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
                $linkbd=conectar_bd(); 
				//*****************************************************************
 				if($_POST[oculto]=="")
                {
					$_POST[tabgroup1]=1;
					$_POST[busquedas]="";
					$_POST[oculto]="0";
                }
				//*****************************************************************
                if($_POST[ocutc1]=="")
                {
					$_POST[responsablet1]="";
					$_POST[nresponsablet1]="";
					$_POST[cargo1]="";
					$_POST[ncargo1]="";
					$_POST[fechai1]=date("Y-m-d");
					$_POST[fechar1]="";
					$_POST[bana01]=0;
					$xx=count($_POST[lresponsablet1]);
							for($posi=0;$posi<$xx;$posi++)
							{
								unset($_POST[lresponsablet1][0]);
								unset($_POST[lnresponsablet1][0]);
								unset($_POST[lcargo1][0]);
								unset($_POST[lncargo1][0]);
								unset($_POST[lfechai1][0]);
								unset($_POST[lfechar1][0]);
								$_POST[lresponsablet1]= array_values($_POST[lresponsablet1]); 
								$_POST[lnresponsablet1]= array_values($_POST[lnresponsablet1]); 
								$_POST[lcargo1]= array_values($_POST[lcargo1]); 
								$_POST[lncargo1]= array_values($_POST[lncargo1]);
								$_POST[lfechai1]= array_values($_POST[lfechai1]); 
								$_POST[lfechar1]= array_values($_POST[lfechar1]);
							}
					$_POST[ocutc1]="1";
				}
				//*****************************************************************
				if($_POST[ocutc2]=="")
                {
					$_POST[responsablet2]="";
					$_POST[nresponsablet2]="";
					$_POST[cargo2]="";
					$_POST[ncargo2]="";
					$_POST[fechai2]=date("Y-m-d");
					$_POST[fechar2]="";
					$_POST[bana02]=0;
					$xx=count($_POST[lresponsablet2]);
							for($posi=0;$posi<$xx;$posi++)
							{
								unset($_POST[lresponsablet2][0]);
								unset($_POST[lnresponsablet2][0]);
								unset($_POST[lcargo2][0]);
								unset($_POST[lncargo2][0]);
								unset($_POST[lfechai2][0]);
								unset($_POST[lfechar2][0]);
								$_POST[lresponsablet2]= array_values($_POST[lresponsablet2]); 
								$_POST[lnresponsablet2]= array_values($_POST[lnresponsablet2]); 
								$_POST[lcargo2]= array_values($_POST[lcargo2]); 
								$_POST[lncargo2]= array_values($_POST[lncargo2]);
								$_POST[lfechai2]= array_values($_POST[lfechai2]); 
								$_POST[lfechar2]= array_values($_POST[lfechar2]);
							}
					$_POST[ocutc2]="1";
				}
				//*****************************************************************
				if($_POST[ocutc3]=="")
				{
					$_POST[responsablet3]="";
					$_POST[nresponsablet3]="";
					$_POST[cargo3]="";
					$_POST[ncargo3]="";
					$_POST[fechai3]=date("Y-m-d");
					$_POST[fechar3]="";
					$_POST[bana03]=0;
					$xx=count($_POST[lresponsablet3]);
							for($posi=0;$posi<$xx;$posi++)
							{
								unset($_POST[lresponsablet3][0]);
								unset($_POST[lnresponsablet3][0]);
								unset($_POST[lcargo3][0]);
								unset($_POST[lncargo3][0]);
								unset($_POST[lfechai3][0]);
								unset($_POST[lfechar3][0]);
								$_POST[lresponsablet3]= array_values($_POST[lresponsablet3]); 
								$_POST[lnresponsablet3]= array_values($_POST[lnresponsablet3]); 
								$_POST[lcargo3]= array_values($_POST[lcargo3]); 
								$_POST[lncargo3]= array_values($_POST[lncargo3]);
								$_POST[lfechai3]= array_values($_POST[lfechai3]); 
								$_POST[lfechar3]= array_values($_POST[lfechar3]);
							}
					$_POST[ocutc3]="1";
				}
				//*****************************************************************
				if($_POST[ocumlg]=="")
				{
					$rutaad="informacion/protocolos_eticos/temp/";
					if(!file_exists($rutaad)){mkdir ($rutaad);}
					else {eliminarDir();mkdir ($rutaad);}
					if($_POST[banmlg]!="" && $_POST[banmlg]!=0)
					{ 
						$xx=count($_POST[marcla]);
						for($posi=0;$posi<$xx;$posi++)
						{
							unset($_POST[marcla][0]);
							unset($_POST[marfec][0]);
							unset($_POST[mardes][0]);
							unset($_POST[maradj][0]);
							$_POST[marcla]= array_values($_POST[marcla]); 
							$_POST[marfec]= array_values($_POST[marfec]); 
							$_POST[mardes]= array_values($_POST[mardes]); 
							$_POST[maradj]= array_values($_POST[maradj]);
						}
					}
					$_POST[banmlg]=0;
					$_POST[ocumlg]="1";
				}
				//*****************************************************************
                switch($_POST[tabgroup1])
                {
                    case 1:
                        $check1='checked';break;
                    case 2:
                        $check2='checked';break;
                    case 3:
                        $check3='checked';break;
                    case 4:
                        $check4='checked';break;
                }
				//*****************************************************************
				if ($_POST[eliminaml]!='')
				{ 
					$posi=$_POST[eliminaml];
					unset($_POST[marcla][$posi]);
					unset($_POST[mnarcla][$posi]);
					unset($_POST[marfec][$posi]);
					unset($_POST[mardes][$posi]);
					unset($_POST[maradj][$posi]);
					$_POST[marcla]= array_values($_POST[marcla]); 
					$_POST[mnarcla]= array_values($_POST[mnarcla]); 
					$_POST[marfec]= array_values($_POST[marfec]); 
					$_POST[mardes]= array_values($_POST[mardes]); 
					$_POST[maradj]= array_values($_POST[maradj]); 
				}
				//*****************************************************************
				if ($_POST[agregar01]=='1')
				{
					$_POST[lresponsablet1][]=$_POST[responsablet1];
					$_POST[lnresponsablet1][]=$_POST[nresponsablet1];
					$_POST[lcargo1][]=$_POST[cargo1];
					$_POST[lncargo1][]=$_POST[ncargo1];
					$_POST[lfechai1][]=$_POST[fechai1];
					$_POST[lfechar1][]=$_POST[fechar1];
					$_POST[responsablet1]="";
					$_POST[nresponsablet1]="";
					$_POST[cargo1]="";
					$_POST[ncargo1]="";
					$_POST[fechai1]=date("Y-m-d");
					$_POST[fechar1]="";
					$_POST[agregar01]='0';
				}
				//*****************************************************************
				if ($_POST[agregar02]=='1')
				{
					$_POST[lresponsablet2][]=$_POST[responsablet2];
					$_POST[lnresponsablet2][]=$_POST[nresponsablet2];
					$_POST[lcargo2][]=$_POST[cargo2];
					$_POST[lncargo2][]=$_POST[ncargo2];
					$_POST[lfechai2][]=$_POST[fechai2];
					$_POST[lfechar2][]=$_POST[fechar2];
					$_POST[responsablet2]="";
					$_POST[nresponsablet2]="";
					$_POST[cargo2]="";
					$_POST[ncargo2]="";
					$_POST[fechai2]=date("Y-m-d");
					$_POST[fechar2]="";
					$_POST[agregar02]='0';
				}
				//*****************************************************************
				if ($_POST[agregar03]=='1')
				{
					$_POST[lresponsablet3][]=$_POST[responsablet3];
					$_POST[lnresponsablet3][]=$_POST[nresponsablet3];
					$_POST[lcargo3][]=$_POST[cargo3];
					$_POST[lncargo3][]=$_POST[ncargo3];
					$_POST[lfechai3][]=$_POST[fechai3];
					$_POST[lfechar3][]=$_POST[fechar3];
					$_POST[responsablet3]="";
					$_POST[nresponsablet3]="";
					$_POST[cargo3]="";
					$_POST[ncargo3]="";
					$_POST[fechai3]=date("Y-m-d");
					$_POST[fechar3]="";
					$_POST[agregar03]='0';
				}
				//*****************************************************************
				if ($_POST[eliminal1]!='')
				{ 
					$posi=$_POST[eliminal1];
					unset($_POST[lresponsablet1][$posi]);
					unset($_POST[lnresponsablet1][$posi]);
					unset($_POST[lcargo1][$posi]);
					unset($_POST[lncargo1][$posi]);
					unset($_POST[lfechai1][$posi]);
					unset($_POST[lfechar1][$posi]);
					$_POST[lresponsablet1]= array_values($_POST[lresponsablet1]); 
					$_POST[lnresponsablet1]= array_values($_POST[lnresponsablet1]); 
					$_POST[lcargo1]= array_values($_POST[lcargo1]); 
					$_POST[lncargo2]= array_values($_POST[lncargo2]); 
					$_POST[lfechai1]= array_values($_POST[lfechai1]); 
					$_POST[lfechar1]= array_values($_POST[lfechar1]); 
				}
				//*****************************************************************
				if ($_POST[eliminal2]!='')
				{ 
					$posi=$_POST[eliminal2];
					unset($_POST[lresponsablet2][$posi]);
					unset($_POST[lnresponsablet2][$posi]);
					unset($_POST[lcargo2][$posi]);
					unset($_POST[lncargo2][$posi]);
					unset($_POST[lfechai2][$posi]);
					unset($_POST[lfechar2][$posi]);
					$_POST[lresponsablet2]= array_values($_POST[lresponsablet2]); 
					$_POST[lnresponsablet2]= array_values($_POST[lnresponsablet2]); 
					$_POST[lcargo2]= array_values($_POST[lcargo2]); 
					$_POST[lncargo2]= array_values($_POST[lncargo2]); 
					$_POST[lfechai2]= array_values($_POST[lfechai2]); 
					$_POST[lfechar2]= array_values($_POST[lfechar2]); 
				}
				//*****************************************************************
				if ($_POST[eliminal3]!='')
				{ 
					$posi=$_POST[eliminal3];
					unset($_POST[lresponsablet3][$posi]);
					unset($_POST[lnresponsablet3][$posi]);
					unset($_POST[lcargo3][$posi]);
					unset($_POST[lncargo3][$posi]);
					unset($_POST[lfechai3][$posi]);
					unset($_POST[lfechar3][$posi]);
					$_POST[lresponsablet3]= array_values($_POST[lresponsablet3]); 
					$_POST[lnresponsablet3]= array_values($_POST[lnresponsablet3]); 
					$_POST[lcargo3]= array_values($_POST[lcargo3]); 
					$_POST[lncargo3]= array_values($_POST[lncargo3]); 
					$_POST[lfechai3]= array_values($_POST[lfechai3]); 
					$_POST[lfechar3]= array_values($_POST[lfechar3]); 
				}
				//*****************************************************************
				if ($_POST[agregamlg]=='1')
				{
					$_POST[marcla][]=$_POST[protocolo];	
					$_POST[mnarcla][]=$_POST[nomproto];	
					$_POST[marfec][]=$_POST[fecmls];	
					$_POST[mardes][]=$_POST[desmar];	
					$_POST[maradj][]=$_POST[nomarch];	
					$_POST[protocolo]="";
					$_POST[fecmls]="";
					$_POST[desmar]="";
					$_POST[nomarch]="";	
					$_POST[agregamlg]='0';
				}
				//*****************************************************************
				if ($_POST[busquedas]!="")
				{
					 switch($_POST[busquedas])
					{
						case 1:
							$nresul=buscaresponsable($_POST[responsablet1]);
							if($nresul!=''){$_POST[nresponsablet1]=$nresul;}
							else
							{
								$_POST[nresponsablet1]="";
								?><script>
									despliegamodalm('visible','2','No existe o est\xe1 vinculado un funcionario con este documento');	
                               	</script><?php 
							}
							break;
						case 2:
							$nresul=buscaresponsable($_POST[responsablet2]);
							if($nresul!=''){$_POST[nresponsablet2]=$nresul;}
							else
							{
								$_POST[nresponsablet2]="";
								?><script>
									despliegamodalm('visible','2','No existe o est\xe1 vinculado un funcionario con este documento');	
                               	</script><?php 
							}
							break;
						case 3:
							$nresul=buscaresponsable($_POST[responsablet3]);
							if($nresul!=''){$_POST[nresponsablet3]=$nresul;}
							else
							{
								$_POST[nresponsablet3]="";
								?><script>
									despliegamodalm('visible','2','No existe o est\xe1 vinculado un funcionario con este documento');	
                               	</script><?php 
							}
							break;
						case 4:
							break;
					}
					$_POST[busquedas]="";	
				}
            ?>
            <input type="hidden" name="bana01" id="bana01" value="<?php echo $_POST[bana01];?>">
            <input type="hidden" name="bana02" id="bana02" value="<?php echo $_POST[bana02];?>">
            <input type="hidden" name="bana03" id="bana03" value="<?php echo $_POST[bana03];?>">
            <input type="hidden" name="banmlg" id="banmlg" value="<?php echo $_POST[banmlg];?>" >
            <div class="tabsmeci"  style="height:76.5%; width:99.6%">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Comit&eacute; Coordinador CI</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="7" style="width:93%">Comit&eacute; Coordinador CI</td>
                                <td class="cerrar" style="width:7%"><a href="meci-principal.php">Cerrar</a></td>
                            </tr>
							<tr>
                            	<td class="saludo1" style="width:10%">Responsable:</td>
                         		<td style="width:10%">
                            		<input type="text" name="responsablet1" id="responsablet1" style="width:100%" onKeyPress="return solonumeros(event);"  onBlur="busquedajs('1');" value="<?php echo $_POST[responsablet1]?>" >
                            	</td>                               	
            					<td style="width:30%" colspan="3">
									<input type="text" name="nresponsablet1" id="nresponsablet1" value="<?php echo $_POST[nresponsablet1]?>" style=" width:88.5% " readonly>
                                    <a href="#" onClick="despliegamodal2('visible','1');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
								</td>
                                <td class="saludo1" style="width:6%;">Cargo:</td>
                                <td>
                                	<select name="cargo1" id="cargo1" style="width:30%;" onChange="document.form2.submit();">
                        				<option value="" <?php if($_POST[cargo1]=='') {echo "SELECTED";}?>>...</option>
										<?php
                                            $linkbd=conectar_bd();
                                            $sqlr="SELECT * FROM mecivariables WHERE clase='CCC' AND estado='S' ORDER BY id ASC";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                echo "<option value=$row[0] ";
                                                $i=$row[0];
                                                if($i==$_POST[cargo1])
												{
													echo "SELECTED"; 
													$_POST[cargo1]=$row[0];
													$_POST[ncargo1]=$row[1];
												}
                                                echo ">".$row[1]." </option>";
                                            }	 	
                                        ?>
                       				</select>
                                    <input type="hidden" name="ncargo1" id="ncargo1" value="<?php echo $_POST[ncargo1];?>">
                                </td>
                        	</tr>
                            <tr>        
                                <td class="saludo1" style="width:10%">Fecha Inicial:</td>
                                <td><input type="date" name="fechai1" id="fechai1" value="<?php echo $_POST[fechai1]?>"></td>
                                <td class="saludo1" style="width:10%">Fecha Retiro:</td>
                                 <td><input type="date" name="fechar1" id="fechar1" value="<?php echo $_POST[fechar1]?>"></td>
                                 <td style="width:5%">
                                	<input name="bagregar1" type="button" value="  Agregar " onClick="agregarlista1();">
                               </td>
                            </tr>
                        </table>
                        <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                                <tr>
                                    <td class="titulos" style="width:6%;">No</td>
                                    <td class="titulos" style="width:10%;">Documento</td>
                                    <td class="titulos" style="width:40%;">Nombre</td>
                                    <td class="titulos" style="width:20%;">Cargo</td>
                                    <td class="titulos" style="width:10%;">Fecha de Inicio</td>
                                    <td class="titulos" style="width:10%;">Fecha Final</td>
                                    <td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[lresponsablet1]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
                                        echo "
                                            <tr class='$iter'>
                                                <td>".($x+1)."</td>
                                                <td><input class='inpnovisibles' type='text' name='lresponsablet1[]' value='".$_POST[lresponsablet1][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lnresponsablet1[]' value='".$_POST[lnresponsablet1][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lncargo1[]' value='".$_POST[lncargo1][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lfechai1[]' value='".$_POST[lfechai1][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lfechar1[]' value='".$_POST[lfechar1][$x]."' style='width:100%;' readonly></td>
                                                <td><a href='#' onclick='eliminarl1($x)'><img src='imagenes/del.png'></a></td>
												<input type='hidden' name='lcargo1[]' value='".$_POST[lcargo1][$x]."'>
                                            </tr>";  
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux; 
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div> 
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Representante Alta Direcci&oacute;n</label>
                    <div class="content" style="overflow:hidden;">
                       <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="7" style="width:93%">Representante Alta Direcci&oacute;n</td>
                                <td class="cerrar" style="width:7%"><a href="meci-principal.php">Cerrar</a></td>
                            </tr>
							<tr>
                            	<td class="saludo1" style="width:10%">Responsable:</td>
                         		<td style="width:10%">
                            		<input type="text" name="responsablet2" id="responsablet12" style="width:100%" onKeyPress="return solonumeros(event);"  onBlur="busquedajs('2');" value="<?php echo $_POST[responsablet2]?>" >
                            	</td>                               	
            					<td style="width:30%" colspan="3">
									<input type="text" name="nresponsablet2" id="nresponsablet2" value="<?php echo $_POST[nresponsablet2]?>" style=" width:88.5% " readonly>
                                    <a href="#" onClick="despliegamodal2('visible','2');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
								</td>
                                <td class="saludo1" style="width:6%;">Cargo:</td>
                                <td>
                                	<select name="cargo2" id="cargo2" style="width:30%;" onChange="document.form2.submit();">
                        				<option value="" <?php if($_POST[cargo2]=='') {echo "SELECTED";}?>>...</option>
										<?php
                                            $linkbd=conectar_bd();
                                            $sqlr="SELECT * FROM mecivariables WHERE clase='CAD' AND estado='S' ORDER BY id ASC";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                echo "<option value=$row[0] ";
                                                $i=$row[0];
                                                if($i==$_POST[cargo2])
												{
													echo "SELECTED"; 
													$_POST[cargo2]=$row[0];
													$_POST[ncargo2]=$row[1];
												}
                                                echo ">".$row[1]." </option>";
                                            }	 	
                                        ?>
                       				</select>
                                    <input type="hidden" name="ncargo2" id="ncargo2" value="<?php echo $_POST[ncargo2];?>">
                                </td>
                        	</tr>
                            <tr>        
                                <td class="saludo1" style="width:10%">Fecha Inicial:</td>
                                <td><input type="date" name="fechai2" id="fechai2" value="<?php echo $_POST[fechai2]?>"></td>
                                <td class="saludo1" style="width:10%">Fecha Retiro:</td>
                                 <td><input type="date" name="fechar2" id="fechar2" value="<?php echo $_POST[fechar2]?>"></td>
                                 <td style="width:5%">
                                	<input name="bagregar2" type="button" value="  Agregar " onClick="agregarlista2();">
                               </td>
                            </tr>
                        </table>
                        <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                                <tr>
                                    <td class="titulos" style="width:6%;">No</td>
                                    <td class="titulos" style="width:10%;">Documento</td>
                                    <td class="titulos" style="width:40%;">Nombre</td>
                                    <td class="titulos" style="width:20%;">Cargo</td>
                                    <td class="titulos" style="width:10%;">Fecha de Inicio</td>
                                    <td class="titulos" style="width:10%;">Fecha Final</td>
                                    <td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[lresponsablet2]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
                                        echo "
                                            <tr class='$iter'>
                                                <td>".($x+1)."</td>
                                                <td><input class='inpnovisibles' type='text' name='lresponsablet2[]' value='".$_POST[lresponsablet2][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lnresponsablet2[]' value='".$_POST[lnresponsablet2][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lncargo2[]' value='".$_POST[lncargo2][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lfechai2[]' value='".$_POST[lfechai2][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lfechar2[]' value='".$_POST[lfechar2][$x]."' style='width:100%;' readonly></td>
                                                <td><a href='#' onclick='eliminarl2($x)'><img src='imagenes/del.png'></a></td>
												<input type='hidden' name='lcargo2[]' value='".$_POST[lcargo2][$x]."'>
                                            </tr>";  
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux; 
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
                    <label for="tab-3">Equipo MECI</label>
                    <div class="content" style="overflow:hidden;">
                     	<table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="8" style="width:93%">Equipo MECI</td>
                                <td class="cerrar" style="width:7%"><a href="meci-principal.php">Cerrar</a></td>
                            </tr>
							<tr>
                            	<td class="saludo1" style="width:10%">Responsable:</td>
                         		<td style="width:10%">
                            		<input type="text" name="responsablet3" id="responsablet13" style="width:100%" onKeyPress="return solonumeros(event);"  onBlur="busquedajs('3');" value="<?php echo $_POST[responsablet3]?>" >
                            	</td>                               	
            					<td style="width:30%" colspan="3">
									<input type="text" name="nresponsablet3" id="nresponsablet3" value="<?php echo $_POST[nresponsablet3]?>" style=" width:88.5% " readonly>
                                    <a href="#" onClick="despliegamodal2('visible','3');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
								</td>
                                <td class="saludo1" style="width:6%;">Cargo:</td>
                                <td>
                                	<select name="cargo3" id="cargo3" style="width:30%;" onChange="document.form2.submit();">
                        				<option value="" <?php if($_POST[cargo3]=='') {echo "SELECTED";}?>>...</option>
										<?php
                                            $linkbd=conectar_bd();
                                            $sqlr="SELECT * FROM mecivariables WHERE clase='CEM' AND estado='S' ORDER BY id ASC";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                echo "<option value=$row[0] ";
                                                $i=$row[0];
                                                if($i==$_POST[cargo3])
												{
													echo "SELECTED"; 
													$_POST[cargo3]=$row[0];
													$_POST[ncargo3]=$row[1];
												}
                                                echo ">".$row[1]." </option>";
                                            }	 	
                                        ?>
                       				</select>
                                    <input type="hidden" name="ncargo3" id="ncargo3" value="<?php echo $_POST[ncargo3];?>">
                                </td>
                        	</tr>
                            <tr>        
                                <td class="saludo1" style="width:10%">Fecha Inicial:</td>
                                <td><input type="date" name="fechai3" id="fechai3" value="<?php echo $_POST[fechai3]?>"></td>
                                <td class="saludo1" style="width:10%">Fecha Retiro:</td>
                                 <td><input type="date" name="fechar3" id="fechar3" value="<?php echo $_POST[fechar3]?>"></td>
                                 <td style="width:5%">
                                	<input name="bagregar3" type="button" value="  Agregar " onClick="agregarlista3();">
                               </td>
                            </tr>
                        </table>
                        <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                                <tr>
                                    <td class="titulos" style="width:6%;">No</td>
                                    <td class="titulos" style="width:10%;">Documento</td>
                                    <td class="titulos" style="width:40%;">Nombre</td>
                                    <td class="titulos" style="width:20%;">Cargo</td>
                                    <td class="titulos" style="width:10%;">Fecha de Inicio</td>
                                    <td class="titulos" style="width:10%;">Fecha Final</td>
                                    <td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[lresponsablet3]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
                                        echo "
                                            <tr class='$iter'>
                                                <td>".($x+1)."</td>
                                                <td><input class='inpnovisibles' type='text' name='lresponsablet3[]' value='".$_POST[lresponsablet3][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lnresponsablet3[]' value='".$_POST[lnresponsablet3][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lncargo3[]' value='".$_POST[lncargo3][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lfechai3[]' value='".$_POST[lfechai3][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='lfechar3[]' value='".$_POST[lfechar3][$x]."' style='width:100%;' readonly></td>
                                                <td><a href='#' onclick='eliminarl3($x)'><img src='imagenes/del.png'></a></td>
												<input type='hidden' name='lcargo3[]' value='".$_POST[lcargo3][$x]."'>
                                            </tr>";  
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux; 
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> >
                    <label for="tab-4">Protocolos Eticos</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="6">Protocolos Eticos</td>
                                 <td class="cerrar" ><a href="meci-principal.php">Cerrar</a></td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:10%;">Clase Protocolo:</td>
                                <td style="width:15%;">
                                	<select name="protocolo" id="protocolo" style="width:100%;" >
                                    	<option value="" <?php if($_POST[protocolo]=='') {echo "SELECTED";}?>>....</option>
                                    	<?php
                                            $sqlr="SELECT * FROM mecivariables WHERE clase='CPE' ORDER BY id ASC";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                echo "<option value=$row[0] ";
                                                $i=$row[0];
                                                if($i==$_POST[protocolo])
												{echo "SELECTED"; $_POST[protocolo]=$row[0];$_POST[nomproto]=$row[1];}
                                                echo ">".$row[1]." </option>";
                                            }	 	
                                        ?>
                                    </select>
                                    <input type="hidden" name="nomproto" id="nomproto" value="<?php echo $_POST[nomproto];?>"
                                </td>
                                <td class="saludo1" style="width:12%;">Documento Adjunto:</td>
                                <td ><input type="text" name="nomarch" id="nomarch"  style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
                                <td>
                                    <div class='upload'> 
                                        <input type="file" name="plantillaad" onChange="document.form2.submit();" />
                                        <img src='imagenes/attach.png'  title='Cargar Documento'  /> 
                                    </div> 
                                </td>
                            </tr>
                            <tr>
                                <td class="saludo1">Descripci&oacute;:</td>
                                <td colspan="3" style="width:72%">
                					<input type="text" name="desmar" id="desmar" value="<?php echo $_POST[desmar];?>" style="width:100%">
                                </td>
                            </tr>
                             <tr>
                                <td class="saludo1" style="width:5%;">Fecha:</td>
                                <td><input type="date" name="fecmls" id="fecmls" value="<?php echo $_POST[fecmls]?>"></td>
                                <td style="width:5%">
                                	<input name="agregamar" type="button" value="  Agregar Documento " onClick="agregarmarco()">
                               </td>
                            </tr>
                        </table>
                        <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                            	 <tr>
                                    <td class="titulos" style="width:6%;">Item</td>
                                    <td class="titulos" style="width:15%;">Clase</td>
                                    <td class="titulos" style="width:35%;">Descripci&oacute;n</td>
                                    <td class="titulos" style="width:30%;">Adjunto</td>
                                    <td class="titulos" style="width:10%;">Fecha</td>
                                    <td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[marcla]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
                                        echo "
                                            <tr class='$iter'>
                                                <td>".($x+1)."</td>
                                                <td><input class='inpnovisibles type='text' name='mnarcla[]' value='".$_POST[mnarcla][$x]."' style='width:100%;' readonly></td>
                                                <td><input class='inpnovisibles type='text' name='mardes[]' value='".$_POST[mardes][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles type='text' name='maradj[]' value='".$_POST[maradj][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles type='text' name='marfec[]' value='".$_POST[marfec][$x]."' style='width:100%;' readonly></td>
                                                <td><a href='#' onclick='eliminarml($x)'><img src='imagenes/del.png'></a></td>
												<input type='hidden' name='marcla[]' value='".$_POST[marcla][$x]."'>
                                            </tr>";   
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
                                    }
                                ?>
                            </table>
                    	</div>
                    </div>
                </div>
            </div>  
           
            <?php  
				//archivos
				if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
				{
					$rutaad="informacion/protocolos_eticos/temp/";
					?><script>document.getElementById('nomarch').value='<?php echo $_FILES['plantillaad']['name'];?>';</script><?php
					copy($_FILES['plantillaad']['tmp_name'], $rutaad.$_FILES['plantillaad']['name']);
				}
                //********guardar
                if($_POST[oculto]=="1")
                {
                    switch($_POST[tabgroup1])
					{
						case 1: //*************************************************
							$xconta=count($_POST[lresponsablet1]);
							for($x=0;$x<$xconta;$x++)
							{
								$sqlid="SELECT MAX(id) FROM mecinsparticipacion ";
								$rowid=mysql_fetch_row(mysql_query($sqlid,$linkbd));
								$numid=$rowid[0]+1;
								$sqln="INSERT INTO mecinsparticipacion (id,clase,documento,cargo,fechaini,fechafin,estado) VALUES ('$numid','RCC', '".$_POST[lresponsablet1][$x]."','".$_POST[lcargo1][$x]."','".$_POST[lfechai1][$x]."','".$_POST[lfechar1][$x]."','S')";
								mysql_query($sqln,$linkbd);
							}
							$clamensaje="Se Guardo con exito Los Representantes para el Comit\xe9 Coordinador CI";
							break;
						case 2: //*************************************************
							$xconta=count($_POST[lresponsablet2]);
							for($x=0;$x<$xconta;$x++)
							{
								$sqlid="SELECT MAX(id) FROM mecinsparticipacion ";
								$rowid=mysql_fetch_row(mysql_query($sqlid,$linkbd));
								$numid=$rowid[0]+1;
								$sqln="INSERT INTO mecinsparticipacion (id,clase,documento,cargo,fechaini,fechafin,estado) VALUES ('$numid','RAD', '".$_POST[lresponsablet2][$x]."','".$_POST[lcargo2][$x]."','".$_POST[lfechai2][$x]."','".$_POST[lfechar2][$x]."','S')";
								mysql_query($sqln,$linkbd);
							}
							$clamensaje="Se Guardo con exito Los Representantes para Alta Direcci\xf3n";
							break;
						case 3: //*************************************************
							$xconta=count($_POST[lresponsablet3]);
							for($x=0;$x<$xconta;$x++)
							{
								$sqlid="SELECT MAX(id) FROM mecinsparticipacion ";
								$rowid=mysql_fetch_row(mysql_query($sqlid,$linkbd));
								$numid=$rowid[0]+1;
								$sqln="INSERT INTO mecinsparticipacion (id,clase,documento,cargo,fechaini,fechafin,estado) VALUES ('$numid','REM', '".$_POST[lresponsablet3][$x]."','".$_POST[lcargo3][$x]."','".$_POST[lfechai3][$x]."','".$_POST[lfechar3][$x]."','S')";
								mysql_query($sqln,$linkbd);
							}
							$clamensaje="Se Guardo con exito Los Representantes para el Equipo Meci";
							break;
							break;
						case 4: //*************************************************
							for($x=0;$x<$_POST[banmlg];$x++)
							{
								$sqlidml="SELECT MAX(id) FROM meciprotocoloseticos ";
								$rowidml=mysql_fetch_row(mysql_query($sqlidml,$linkbd));
								$numidml=$rowidml[0]+1;
								$sqlmlg="INSERT INTO meciprotocoloseticos(id,idclase,fechaprotocolo,descripcion,adjunto,estado) VALUES ('$numidml','".$_POST[marcla][$x]."','".$_POST[marfec][$x]."','".$_POST[mardes][$x]."','".$_POST[maradj][$x]."','S')";
								mysql_query($sqlmlg,$linkbd);
								copy("informacion/protocolos_eticos/temp/".$_POST[maradj][$x],("informacion/protocolos_eticos/".$_POST[maradj][$x]));
								$clamensaje="Se Guardo con exito los Documentos para Protocolos Eticos";
							}
							break;
					}
					?><script>despliegamodalm('visible','1','<?php echo $clamensaje;?>');</script><?php
					$_POST[oculto]="0";
                }
            ?>
            <input type="hidden" name="agregar01" value="0">
            <input type="hidden" name="agregar02" value="0">
            <input type="hidden" name="agregar03" value="0">
            <input type="hidden" name="agregamlg" value="0">
            <input type='hidden' name='eliminal1' id='eliminal1'>
            <input type='hidden' name='eliminal2' id='eliminal2'>
            <input type='hidden' name='eliminal3' id='eliminal3'>
            <input type='hidden' name='eliminaml' id='eliminaml'>
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
            <input type="hidden" name="ocutc1" id="ocutc1" value="<?php echo $_POST[ocutc1];?>">
            <input type="hidden" name="ocutc2" id="ocutc2" value="<?php echo $_POST[ocutc2];?>">
            <input type="hidden" name="ocutc3" id="ocutc3" value="<?php echo $_POST[ocutc3];?>">
            <input type="hidden" name="ocumlg" id="ocumlg" value="<?php echo $_POST[ocumlg];?>">
            <input type="hidden" name="busquedas" id="busquedas" value="<?php echo $_POST[busquedas];?>">
 		</form>     
        <div id="bgventanamodal2">
            <div id="ventanamodal2">
                <a href="javascript:despliegamodal2('hidden')" style="position: absolute; left: 810px; top: 5px; z-index: 100;"><img src="imagenes/exit.png" title="cerrar" width=22 height=22>Cerrar</a>
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>  
	</body>
</html>