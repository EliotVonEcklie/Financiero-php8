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
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="funcioneshf.js"></script>
        <link href="css/css2.css" rel="stylesheet" type="text/css"/>
        <link href="css/css3.css" rel="stylesheet" type="text/css"/>
        <link href="css/tabs.css" rel="stylesheet" type="text/css"/>
        <script>
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
		 	function busquedajs()
			{
				if (document.form2.responsable.value!=""){document.form2.busquedas.value="1";document.form2.submit();}
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="plan-acresponsables.php";}
			}
			function buscares(e)
				{if (document.form2.responsable.value!=""){document.form2.bres.value='1';document.form2.submit();}}
			function numradicado(d)
			{
				var diab=d.getDate();
				var semb=d.getDay();
				var mesb=d.getMonth()+1;
				var anob=d.getFullYear();
				if (mesb <10) mesb="0"+mesb;
				return(anob+""+mesb+""+diab);
			}
			function cambiolecesc(id,estado)
			{
				document.form2.idelimina.value=id;
				document.form2.camestado.value=estado;
				if(estado=="E")
					{despliegamodalm('visible','4','Seguro de cambiar el estado a "Solo Lectura"','4');}
				else
					{
						if (document.getElementById('tirespuesta').value!="0")
							{despliegamodalm('visible','4','Seguro de cambiar el estado a "Responder la Solicitud"','4');}
						else {despliegamodalm('visible','2','No se puede cambiar el estado');}
						
					}
			}
			function agresponsable()
			{
				if(document.form2.nresponsable.value!="")
				{
					document.getElementById('ban01').value=parseInt(document.getElementById('ban01').value)+1;
					document.form2.agresp.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n del Responsable para poder Agregar');}	
				
			}
			function eliresponsable(variable)
			{
				document.form2.idelimina.value=variable;
				despliegamodalm('visible','4','Seguro de Eliminar este Responsable','2');
			}
			function agregardocumento()
			{
				if(document.form2.nomarch.value!="")
				{
					document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)+1;
					document.form2.agregamlg.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar');}	
			}
			function eliminarml(variable)
			{
				document.form2.idelimina.value=variable;
				despliegamodalm('visible','4','Seguro de Eliminar esta Archivo Adjunto','1');
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					
					case "1"://Eliminar Archivo Adjunto de la lista
						document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)-1;
						document.form2.iddelad.value=document.form2.idelimina.value;
						document.form2.submit();
						break;
					case "2"://Eliminar Responsable de la lista
						document.getElementById('ban01').value=parseInt(document.getElementById('ban01').value)-1;
						document.form2.eliminaml.value=document.form2.idelimina.value;
						document.form2.submit();
						break;
					case "3"://Guardar Radicación
						document.form2.oculto.value="1";
						document.form2.submit();
						break;
					case "4"://Modificar Estado Lectura Escritura Responsables
						document.form2.modestado.value=document.form2.idelimina.value;;
						document.form2.submit();
						break;
				}
			}
			function guardar()
			{
				var conproce="no";
				if(document.getElementById('tirespuesta').value!="0")
					if(document.getElementById('actescritura').value=="si"){conproce="si";}
					else {despliegamodalm('visible','2','Debe asignar un Responsable para dar respuesta a la solicitud');}
				else	
					if(document.getElementById('actescritura').value=="no"){conproce="si";}
					else{despliegamodalm('visible','2','Todos los responsables deben ser del tipo "Solo Lectura" ');}
				if(conproce=="si")
				{
					if(document.form2.tradicacion.value!="")
							if(document.form2.raddescri.value!="")
								if(document.getElementById('ban01').value!=0)
										if( document.form2.adjuntosn.value=="S")
											if(document.getElementById('banmlg').value!=0)
												{despliegamodalm('visible','4','Est\xe1 Seguro de Asignar la Tarea','3');}
											else{despliegamodalm('visible','2','Falta adjuntar Un Documento para poder Guardar');}
										else{despliegamodalm('visible','4','Est\xe1 Seguro de Asignar la Tarea','3');}
								else{despliegamodalm('visible','2','Falta agregar Un Responsable para poder Guardar');}
							else{despliegamodalm('visible','2','Falta agregar La Descipci\xf3n para poder Guardar');}
					else{despliegamodalm('visible','2','Falta agregar Tipo de Radicaci\xf3n para poder Guardar');}
				}
			}
			function funcionmensaje()
			{document.location.href = "http://servidor/financiero/plan-tareasasignar.php";}
			function camarcori(doc){document.getElementById('mararcori').value=doc;}
		</script>
        <?php
			titlepag();
			function eliminarDir($carpeta)
			{
				$carpeta2="informacion/documentosradicados/".$carpeta;
				foreach(glob($carpeta2 . "/*") as $archivos_carpeta)
				{
					//echo $archivos_carpeta;
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta2);
			}
		?>
	</head>
	<body>
  		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("plan");?></tr>
          	<tr>
          		<td colspan="3" class="cinta"><a href="plan-tareasasignar.php?" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="plan-tareasbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" class="mgbt" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" id="form2" method="post" enctype="multipart/form-data">
         	<?php 
				//*****carga inicial de Varibles************************************
 				if($_POST[oculto]=="")
				{
					$sqlr="SELECT MAX(CAST(SUBSTRING(numeror,2) AS SIGNED INTEGER)) FROM planacradicacion WHERE numeror LIKE  '%I%'";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)){$mx=$row[0];}
					$mx++;
					$ndig=strlen($mx);
					$_POST[nradicadot]="I".$mx;
					for($xx=1;$xx < (7-$ndig);$xx++)
					{$_POST[nradicado]=$_POST[nradicado]."0";}
					$_POST[nradicado]="I".$_POST[nradicado].($mx);
					$_POST[codbarras]=$_POST[nradicado];
					$ruta="informacion/documentosradicados/".$_POST[nradicado];
					if(!file_exists($ruta))
					{mkdir ($ruta);}//Se ha creado el directorio en la ruta
					else {eliminarDir($_POST[nradicado]);mkdir ($ruta);}// " ya existe el directorio en la ruta ";
					$_POST[rutaad]=$ruta."/";
					$_POST[banmlg]=0;
					$_POST[ban01]=0;
					$_POST[modestado]="";
					$_POST[tabgroup1]=1;
					$_POST[tirespuesta]="0";
					$_POST[actescritura]="no";
					$_POST[oculto]="0";
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
				//*****modificar************************************
				if ($_POST[modestado]!='')
				{
					if($_POST[camestado]=='E'){$_POST[lecesc][$_POST[modestado]]="L";$_POST[actescritura]="no";}
					else 
					{
						$xconta=count($_POST[docres]);
						for($x=0;$x<$xconta;$x++){$_POST[lecesc][$x]="L";}
						$_POST[lecesc][$_POST[modestado]]="E";$_POST[actescritura]="si";
					}
					$_POST[modestado]="";
				}
				//*****Agregar Reponsable en la Lista************************************
				if ($_POST[agresp]=='1')
				{
					$_POST[docres][]=$_POST[responsable];	
					$_POST[nomdes][]=$_POST[nresponsable];
					if ($_POST[tirespuesta]=="0"){$_POST[lecesc][]="L";}
					else 
					{
						if($_POST[actescritura]=="no"){$_POST[lecesc][]="E";$_POST[actescritura]="si";}
						else {$_POST[lecesc][]="L";}
					}
					$_POST[responsable]="";
					$_POST[nresponsable]="";
					$_POST[agregamlg]='0';
				}
				//******Eliminar Responsable de la Lista*****************************************
				if ($_POST[eliminaml]!='')
				{ 
					$posi=$_POST[eliminaml];
					unset($_POST[docres][$posi]);
					unset($_POST[nomdes][$posi]);
					unset($_POST[lecesc][$posi]);
					$_POST[docres]= array_values($_POST[docres]); 
					$_POST[nomdes]= array_values($_POST[nomdes]);
					$_POST[lecesc]= array_values($_POST[lecesc]); 
				}
				//*****Agregar Archivo Adjunto A Lista*****************************
				if ($_POST[agregamlg]=='1')
				{
					$_POST[nomarchivo][]=$_POST[nomarch];
					$_POST[nomarch]="";	
					$_POST[agregamlg]='0';
				}
				//******Eliminar Archivo de la Lista*****************************************
				if ($_POST[iddelad]!='')
				{ 
					$posi=$_POST[iddelad];
					$archivodell=$_POST[rutaad].$_POST[nomarchivo][$posi];
					unlink($archivodell);
					unset($_POST[nomarchivo][$posi]);
					$_POST[nomarchivo]= array_values($_POST[nomarchivo]); 
					$_POST[iddelad]='';
				}
				//******Busqueda Por Documento****************************************
				if ($_POST[busquedas]!="")
				{
					$nresul=buscaresponsable($_POST[responsable]);
					if($nresul!=''){$_POST[nresponsable]=$nresul;}
					else
					{
						$_POST[nresponsable]="no";
						echo"<script>despliegamodalm('visible','2','No existe o est\xe1 vinculado un funcionario con este documento');</script>";
					}
					$_POST[busquedas]="";	
				}
				//*****************************************************************
			?>
        	<input type="hidden" name="ban01" id="ban01" value="<?php echo $_POST[ban01];?>">
            <input type="hidden" name="mararcori" id="mararcori" value="<?php echo $_POST[mararcori];?>">
            <input type="hidden" name="banmlg" id="banmlg" value="<?php echo $_POST[banmlg];?>">
            <input type="hidden" name="adjuntosn" id="adjuntosn" value="<?php echo $_POST[adjuntosn]?>">
            <input type="hidden" name="tirespuesta" id="tirespuesta" value="<?php echo $_POST[tirespuesta]?>">
            <div class="tabsmeci"  style="height:76.5%; width:99.6%">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Informaci&oacute;n General</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio">
                            <tr>
                                <td colspan="11" class="titulos" style="width:95%">:.Asignar Tarea </td>
                                <td class="cerrar" style="width:5%"><a href="plan-principal.php" >Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:9%" >:&middot; N&deg; de Tarea:</td>
                                <td style="width:12%">
                                    <input type="text" name="nradicado" id="nradicado" style="width:100%" value="<?php echo $_POST[nradicado]?>" readonly>
                                    <input type="hidden"  name="codbarras" id="codbarras" value="<?php echo $_POST[codbarras]?>">
                                </td>
                                <td class="saludo1" style="width:6%">:&middot; Fecha:</td>
                                <td style="width:10.5%">
                                    <input type="text" name="fecharad" id="fecharad" style="width:100%" readonly>
                                    <input type="hidden" name="fecharado" id="fecharado">
                                </td>
                                <script>
                                    document.getElementById("fecharad").value=fecha_corta2(new Date());
                                    document.getElementById("fecharado").value=fecha_sinformato(new Date());
                                </script>
                                <td class="saludo1" style="width:8%" >:&middot; Hora:</td>
                                <td style="width:9%">
                                    <input type="text" name="horarad" id="horarad" style="width:100%" readonly>
                                    <input type="hidden" name="horarado" id="horarado">
                                </td>
                                <script>window.onload = function(){setInterval(hora_corta, 1000);}</script>
                           	</tr>
                            <tr>
                            	<td class="saludo1" style="width:10%" >:&middot;Tipo de Tarea:</td>
                                <td  colspan="3">
                                    <select name="tradicacion" id="tradicacion" class="elementosmensaje" style="width:100%"  onKeyUp="return tabular(event,this)" onChange="var traddiv=this.value.split('-');document.getElementById('adjuntosn').value= traddiv[2]; document.getElementById('tirespuesta').value=traddiv[1]; sumadiashabiles(document.form2.fechares,document.form2.fechareso,traddiv[1]);">
                                        <option onChange="" value="" >Seleccione....</option>
                                        <?php	
                                            $sqlr="SELECT * FROM dominios WHERE nombre_dominio='TIPO_TAREAS' ORDER BY  valor_inicial ASC  ";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($rowEmp = mysql_fetch_assoc($res)) 
                                            {
                                                echo "<option value= ".$rowEmp['valor_inicial']."-".$rowEmp['valor_final']."-".$rowEmp['tipo'];
                                                $i=$rowEmp['valor_inicial']."-".$rowEmp['valor_final']."-".$rowEmp['tipo'];
                                                if($i==$_POST[tradicacion])
                                                {
                                                    echo "  SELECTED";
                                                    $_POST[octradicacion]=$rowEmp['descripcion_valor'];
                                                }
                                                echo ">".$rowEmp['valor_inicial']." - ".$rowEmp['descripcion_valor']."</option>"; 	 
                                            }		
                                        ?> 
                                    </select>
                                    <input type="hidden" name="octradicacion" id="octradicacion" value="<?php echo $_POST[octradicacion]?>">
                                </td>
                                <td class="saludo1">:&middot; Fecha L&iacute;mite:</td>
                                <td>
                                    <input type="text" name="fechares" id="fechares" style="width:100%" value="<?php echo $_POST[fechares]?>" readonly>
                                    <input type="hidden" name="fechareso" id="fechareso" value="<?php echo $_POST[fechareso]?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="saludo1" >:&middot; Descripci&oacute;n:</td>
                                <td colspan="6"><input id="raddescri" name="raddescri" type="text" style="width:100%" value="<?php echo $_POST[raddescri]?>"></td>
                            </tr>
                            
                            </tr>   
                            <tr>
                                <td class="saludo1">:&middot; Modo de Respuesta :</td>
                                <td class="saludo2" colspan="3">
                           			<input type="checkbox" name="trescrito" id="trescrito" value="escr" class="defaultcheckbox" <?php if(isset($_REQUEST['trescrito'])){echo "checked";} ?>/>Escrita &nbsp;&nbsp;&nbsp;&nbsp;
                           			<input type="checkbox" name="trtelefono" id="trtelefono" value="tele" class="defaultcheckbox" <?php if(isset($_REQUEST['trtelefono'])){echo "checked";} ?>/>Telef&oacute;nica &nbsp;&nbsp; &nbsp;&nbsp;
                              		<input type="checkbox" name="trcorreo" id="trcorreo" value="corr" class="defaultcheckbox" <?php if(isset($_REQUEST['trcorreo'])){echo "checked";} ?>/>Correo Electr&oacute;nico
                                </td>
                            </tr>
                        </table>
      				</div>
				</div>
            	<div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Responsables</label>
                    <div class="content" style="overflow:hidden;" >
						<table>
                        	<tr>
								<td class="saludo1" style="width:15%">:&middot; Responsable Respuesta:</td>
                                <td style="width:15%">
                                    <input id="responsable" type="text" name="responsable" style="width:100%" onKeyPress="return solonumeros(event);" onBlur="busquedajs();" value="<?php echo $_POST[responsable]?>" onClick="document.getElementById('responsable').focus();document.getElementById('responsable').select();">
                                    <input type="hidden" value="0" name="bres">
                                </td>
                                <td>
                                    <a href="#" onClick="despliegamodal2('visible');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                                    <input type="text" name="nresponsable" id="nresponsable" value="<?php echo $_POST[nresponsable]?>" style=" width:90% " readonly>
                                </td>
                                <td><input name="agregamar" type="button" value="  Agregar  " onClick="agresponsable()"></td>
                   			</tr>
                		</table>
                    	<div style="overflow-x:hidden;">
                            <table class="inicio">
                                <tr>
                                    <td colspan="5" class="titulos">Responsables</td>
                                </tr>
                                <tr>
                                    <td class="titulos2" style="width:15%;">Documento</td>
                                    <td class="titulos2" style="width:67%;">Nombre</td>
                                    <td class="titulos2" style="width:8%;">Tipo</td>
                                    <td class="titulos2" style="width:8%;" title="Documento Original">Original</td>
                                    <td class="titulos2" style="width:10%;">Eliminar</td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[docres]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
                                        if($_POST[lecesc][$x] == "L"){$imglecesc="src='imagenes/lectura.jpg' title='Solo Lectura'";}
                                        else {$imglecesc="src='imagenes/escritura.png' title='Responder'"; }
                                        if($_POST[mararcori]==$_POST[docres][$x]){$marcador='checked';}
                                        else {$marcador='';}
                                        echo "
                                            <tr class='$iter'>
                                                <td><input class='inpnovisibles type='text' name='docres[]' value='".$_POST[docres][$x]."' style='width:100%;' readonly></td>
                                                <td><input class='inpnovisibles type='text' name='nomdes[]' value='".$_POST[nomdes][$x]."' style='width:100%;' readonly></td>
                                                <td style='text-align:center;'>
                                                    <input type='hidden' name='lecesc[]' value='".$_POST[lecesc][$x]."'>
                                                    <img $imglecesc style='width:20px' onclick='cambiolecesc($x,\"".$_POST[lecesc][$x]."\")'/>
                                                </td>
                                                <td>
                                                	<input type='radio' name='docorig' class='defaultradio' $marcador onclick='camarcori(\"".$_POST[docres][$x]."\")' />
                                                </td>
                                                <td style='text-align:center;'><a href='#' onclick='eliresponsable($x)'><img src='imagenes/del.png'/></a></td>
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
                    <label for="tab-3">Archivos Adjuntos</label>
                    <div class="content" style="overflow:hidden;">
                    	<table>
                        	<tr>
								<td class="saludo1" style="width:10%">:&middot;Documentos:</td>
                                <td><input type="text" name="nomarch" id="nomarch"  style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
                                <td>
                                    <div class='upload'> 
                                      <a href="#">  <input type="file" name="plantillaad" onChange="document.form2.submit();" />
                                        <img src='imagenes/attach.png'  title='Cargar Documento'  /> </a>
                                    </div> 
                                </td>
                                <td><input name="agregadoc" type="button" value="  Adjuntar " onClick="agregardocumento()"></td>
                            </tr>
                        </table>
                    	<div style="overflow-x:hidden;" >
                            <table class="inicio" >
                                <tr>
                                    <td colspan="4" class="titulos">Archivos Adjuntos</td>
                                </tr>                  
                                <tr>
                                    <td class="titulos2" style="width:80%;">Nombre del Archivo</td>
                                    <td class="titulos2" style="width:10%;">Tipo</td>
                                    <td class="titulos2" style="width:10%;">Eliminar</td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[nomarchivo]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
                                        echo "
                                            <tr class='$iter'>
                                                <td><input class='inpnovisibles type='text' name='nomarchivo[]' value='".$_POST[nomarchivo][$x]."' style='width:100%;' readonly></td>
                                                <td style='text-align:center;'>".traeico($_POST[nomarchivo][$x])."</td>
                                                <td><a href='#' onclick='eliminarml($x)'><img src='imagenes/del.png'></a></td>
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
            <input type="hidden" name="nradicadot" id="nradicadot"  value="<?php echo $_POST[nradicadot]?>">
            <input type="hidden" name="archivonom" id="archivonom"  value="<?php echo $_POST[archivonom]?>">
            <input type="hidden" name="iddelad" id="iddelad" value="<?php echo $_POST[iddelad]?>">
            <input type="hidden" name="ocudelad" id="ocudelad" value="<?php echo $_POST[oculdel]?>">
            <input type="hidden" name="refrest" id="refrest" value="<?php echo $_POST[refrest]?>">
            <input type="hidden" name="rutaad" id="rutaad" value="<?php echo $_POST[rutaad]?>">
            <input type="hidden" id="oculto" name="oculto" value="<?php echo $_POST[oculto]?>">
            <input type="hidden" name="busquedas" id="busquedas" value="<?php echo $_POST[busquedas];?>">
            <input type="hidden" name="idelimina" id="idelimina" value="<?php echo $_POST[idelimina]?>">
            <input type="hidden" name="camestado" id="camestado" value="<?php echo $_POST[camestado]?>">
            <input type="hidden" name="modestado" id="modestado" value="<?php echo $_POST[modestado]?>">
            <input type="hidden" name="actescritura" id="actescritura" value="<?php echo $_POST[actescritura]?>">
            <input type='hidden' name='eliminaml' id='eliminaml'>
            <input type="hidden" name="agresp" id="agresp" value="0">
            <input type="hidden" name="agregamlg" value="0">
            <?php
				//archivos
				if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
				{
					echo"<script>document.getElementById('nomarch').value='".$_FILES['plantillaad']['name']."';</script>";
					copy($_FILES['plantillaad']['tmp_name'], $_POST[rutaad].$_FILES['plantillaad']['name']);
				}
				//guarda la informacion de la Radicación*********************************
				if ($_POST[oculto]=="1")
				{	
					$vallecesc="L";
					$xconta=count($_POST[docres]);
					for($x=0;$x<$xconta;$x++){if($_POST[lecesc][$x]=="E"){$vallecesc="A";}}
					if(isset($_REQUEST['trescrito'])){$cbescrito=1;}else{$cbescrito=0;}
					if(isset($_REQUEST['trtelefono'])){$cbtelefono=1;}else{$cbtelefono=0;}
					if(isset($_REQUEST['trcorreo'])){$cbcorreo=1;}else{$cbcorreo=0;}	
					$nomarchivoad=$_POST[codbarras].".zip";
					$cadtrad=explode("-",$_POST[tradicacion]); 
					$_POST[modestado]="";
					//guarda la informacion general de la radicacion********************************************************
					$sqlr = "INSERT INTO planacradicacion (numeror,codigobarras,fechar,horar,usuarior,tipor,fechalimite,idtercero, descripcionr,tescrito,ttelefono,temail,telefonot,celulart,direcciont,emailt,documento,numeromod,nfolios,narchivosad,estado) VALUES ('$_POST[nradicadot]','$_POST[codbarras]','$_POST[fecharado]','$_POST[horarado]','$_SESSION[cedulausu]','$cadtrad[0]', '$_POST[fechareso]','','$_POST[raddescri]','$cbescrito','$cbtelefono','$cbcorreo','','','','','$nomarchivoad',0,'','$_POST[mararcori]', '$vallecesc')";
					$res=(mysql_query($sqlr,$linkbd));
					//guarda Los responsables********************************************************************************
					$xconta=count($_POST[docres]);
					for($x=0;$x<$xconta;$x++)
					{	
						if($_POST[lecesc][$x]=="E"){$vallecesc="A";}
						else{$vallecesc="LN";}
						$sqlid="SELECT MAX(codigo) FROM planacresponsables ";
						$rowid=mysql_fetch_row(mysql_query($sqlid,$linkbd));
						$numid=$rowid[0]+1;
						$sqlr = "INSERT INTO planacresponsables (codigo,codradicacion,fechasig, fechares,usuarioasig,usuariocon, estado,archivos,respuesta) VALUES ('$numid','$_POST[nradicadot]','$_POST[fecharado]','','$_SESSION[cedulausu]','".$_POST[docres][$x]."','$vallecesc','','')";
						mysql_query($sqlr,$linkbd);
					}
					//guarda Los archivos y crear .zip***********************************************************************
					comprimir($_POST[rutaad],($_POST[codbarras].".zip"));
					copy(($_POST[codbarras].".zip"),("informacion/documentosradicados/".$_POST[codbarras].".zip"));
					eliminarDir($_POST[codbarras]);
					unlink($_POST[codbarras].".zip");
					$yconta=count($_POST[nomarchivo]);
					for($y=0;$y<$yconta;$y++)
					{
						$sqliy="SELECT MAX(idarchivoad) FROM planacarchivosad ";
						$rowiy=mysql_fetch_row(mysql_query($sqliy,$linkbd));
						$numid=$rowiy[0]+1;
						$sqlr = "INSERT INTO planacarchivosad (idarchivoad,idradicacion,nomarchivo) VALUES ('$numid','$_POST[nradicadot]','".$_POST[nomarchivo][$y]."')";
						mysql_query($sqlr,$linkbd);
					}
					$_POST[oculto]="0";
					echo"<script>despliegamodalm('visible','1','Se Asigno con Exito la Tarea');</script>";
				}
			?>
        </form>
        <div id="bgventanamodal2">
            <div id="ventanamodal2">
                <a href="javascript:despliegamodal2('hidden')" style="position: absolute; left: 810px; top: 5px; z-index: 100;"><img src="imagenes/exit.png" alt="cerrar" width=22 height=22>Cerrar</a>
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>  
        
  	</body>
</html>