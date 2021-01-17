<?php
	require "comun.inc";
	require "funciones.inc";
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
		<title>:: Contabilidad</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function verCuentaActiva(idcta, tipo, filas, filtro){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="cont-editarcuentagastos.php?idcta="+idcta+"&tipo="+tipo+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function concepto35()
			{
				var concepto = document.getElementById("concepago").value;
				if(concepto == '-1')
				{
					despliegamodalm('visible','2','Falta escoger el concepto de pago');
				}
				else
				{
					despliegamodalm('visible','4','Esta seguro de programar concepto ' + concepto +' a cuentas de inversion?','1');
				}
			}
			function guardar()
			{
				despliegamodalm('visible','4','Esta seguro de actualizar concepto pago y gasto','2');
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
			function funcionmensaje()
			{
				document.form2.submit();
			}
			
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
							document.form2.concepto.value=1;
							document.form2.submit();
							break;
					case "2":
							document.form2.oculto.value=2;
							document.form2.submit();
							break;
				}
			}
		</script>
		<?php titlepag();?>
        <?php
		$scrtop=$_GET['scrtop'];
		if($scrtop=="") $scrtop=0;
		echo"<script>
			window.onload=function(){
				$('#divdet').scrollTop(".$scrtop.")
			}
		</script>";
		$gidcta=$_GET['idcta'];
		if(isset($_GET['filtro']))
			$_POST[numero]=$_GET['filtro'];
		?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("cont");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><a href="cont-cuentasgasto.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png"/></a><a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='cont-programacioncontable.php'" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <?php
		if($_GET[numpag]!=""){
			$oculto=$_POST[oculto];
			if($oculto!=2){
				$_POST[numres]=$_GET[limreg];
				$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
				$_POST[nummul]=$_GET[numpag]-1;
			}
		}
		else{
			if($_POST[nummul]==""){
				$_POST[numres]=10;
				$_POST[numpos]=0;
				$_POST[nummul]=0;
			}
		}
		$link=conectar_bd();
		?>
        <form action="" method="post" enctype="multipart/form-data" name="form2">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres]; ?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos]; ?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul]; ?>"/>
         	<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>"/>
			
            <table class="inicio" width="99%">
                <tr>
                    <td height="25" colspan="7" class="titulos" >Buscar Cuentas Gastos</td><td width="91"  class="cerrar"><a href="cont-principal.php"> Cerrar</a></td>
                </tr>
                <tr>
                    <td colspan="8" class="titulos2" >:&middot; Por Descripcion </td>
                </tr>
				<tr>
                    <td style="width:8%" class="saludo1" >:&middot; Numero Cuenta:</td>
                    <td  colspan="3"><input name="numero" type="text" style="width:70%" value="<?php echo $_POST[numero];?>" >
                    <input name="oculto" type="hidden" id="oculto" value="1" >
                    <input type="submit" name="Submit" value="Buscar" >
                    </td>
					<td  class="saludo1" >Programacion de Pago:</td>
					<td>
						<select name="concepago" id="concepago">
							<option value="-1">Seleccione ....</option>
							<?php
							$sqlr="Select * from conceptoscontables  where modulo='3' and (tipo='N' or tipo='P') order by codigo";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								$i=$row[0];
								echo "<option value=$row[0] ";
								if($i==$_POST[concepago])
								{
									echo "SELECTED";
								}
								echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
							}			
							?>
						</select>
					</td>
					<td style=" padding-bottom: 0em"><em class="botonflecha" onClick="concepto35()">Parametrizar concepto pago a cuentas de inversion</em></td>
			    </tr>
            </table>
            <div id="divdet" class="subpantallap" style="height:63.5%; width:99.6%;">
	            <?php
                $oculto=$_POST['oculto'];
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
                //echo $oculto;
				$link=conectar_bd();
				if($_POST[concepto] == 1)
				{
					$sqlrConcept = "UPDATE pptocuentas  SET codconcepago='$_POST[concepago]' WHERE clasificacion='inversion' AND vigencia='$vigusu' AND tipo='Auxiliar'";
					mysql_query($sqlrConcept,$link);	
					$_POST[concepto] = 0;
				}
                $cond="";
                $cond2="";
                if ($_POST[numero]!="")
                { 
                    $cond="and (cuenta like'%".trim($_POST[numero])."%' or nombre like '%".strtoupper($_POST[numero])."%')"; 
                }
				if ($_POST[numres]!="-1"){ 
					$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
				}
				$sqlr="Select distinct pptocuentas.*, dominios.tipo from pptocuentas, dominios where dominios.descripcion_valor=pptocuentas.clasificacion AND dominios.nombre_dominio='CLASIFICACION_RUBROS' AND (dominios.tipo='G') and (vigencia='".$vigusu."' or  vigenciaf='".$vigusu."') $cond";
				//echo $sqlr;
				$resp = mysql_query($sqlr,$link);			
				$_POST[numtop]=mysql_num_rows($resp);
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				$sqlr="Select distinct pptocuentas.*, dominios.tipo from pptocuentas, dominios where dominios.descripcion_valor=pptocuentas.clasificacion AND dominios.nombre_dominio='CLASIFICACION_RUBROS' AND (dominios.tipo='G') and (vigencia='".$vigusu."' or  vigenciaf='".$vigusu."') $cond ORDER BY cuenta ASC ".$cond2;
				//echo $sqlr;
				$resp = mysql_query($sqlr,$linkbd);			
				$co='saludo1a';
				$co2='saludo2';	
				$numcontrol=$_POST[nummul]+1;
				$i=($_POST[nummul]*$_POST[numres])+1;
				if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1")){
					$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
					$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
				}
				else{
					$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
					$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
				}
				if(($_POST[numpos]==0)||($_POST[numres]=="-1")){
					$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
					$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
				}
				else{
					$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
					$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
				}
				echo'<table class="inicio">
    				<tr>
      					<td height="25" colspan="10" class="titulos" style="width:95%" >Resultados Busqueda </td>
						<td class="submenu" colspan="2">
							<select name="renumres" id="renumres" onChange="cambionum();" style="width:100%">
								<option value="10"'; if ($_POST[renumres]=='10'){echo 'selected';} echo '>10</option>
								<option value="20"'; if ($_POST[renumres]=='20'){echo 'selected';} echo '>20</option>
								<option value="30"'; if ($_POST[renumres]=='30'){echo 'selected';} echo '>30</option>
								<option value="50"'; if ($_POST[renumres]=='50'){echo 'selected';} echo '>50</option>
								<option value="100"'; if ($_POST[renumres]=='100'){echo 'selected';} echo '>100</option>
								<option value="-1"'; if ($_POST[renumres]=='-1'){echo 'selected';} echo '>Todos</option>
							</select>
						</td>
      				</tr>
    				<tr>
                        <td width="32" class="titulos2"  >Item</td>
                        <td width="76" class="titulos2" >Cuenta </td>
                        <td width="140" class="titulos2" >Descripcion</td>
                        <td width="140" class="titulos2" >Tipo</td>
                        <td class="titulos2" >Concepto Pago</td>      
                        <td class="titulos2" >Causacion</td>     
                        <td class="titulos2" >Agregado</td>             
                        <td  class="titulos2" >Fuente</td>				
                        <td  class="titulos2" >Regal&iacute;as</td>
                        <td  class="titulos2" >Unidad</td>				
                        <td  class="titulos2" >Vigencia</td>	
                        <td width="5" class="titulos2" >Editar</td>	  	  
    				</tr>';
                    $filas=1;
                    while ($r =mysql_fetch_row($resp)) {
                        $negrilla="style='font-weight:bold'";
                        $tipo=$r[2];
                        if ($r[2]=='Auxiliar'){$negrilla=" ";} 
						if($gidcta!=""){
							if($gidcta==$r[0]){
								$estilo='background-color:yellow';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
		
						$idcta="'$r[0]'";
						$tipo="'$tipo'";
						$numfil="'".$filas."'";
						$filtro="'".$_POST[numero]."'";
						echo"<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			            onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verCuentaActiva($idcta, $tipo, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
                        <td>$i</td>
                        <td $negrilla><input name='cuenta[]' value='".$r[0]."' type='text' class='inpnovisibles' style='width:100%' readonly></td>
                        <td $negrilla>".ucwords(strtolower($r[1]))."</td>
						<td $negrilla>".ucwords(strtolower($r[2]))."</td>
						<td $negrilla><input name='conceptoPago[]' value='".$r[23]."' type='text' class='inpnovisibles' style='width:100%'></td>
						<td $negrilla><input name='conceptoGasto[]' value='".$r[24]."' type='text' class='inpnovisibles' style='width:100%'></td>";
                        /*if($r[23]!='-1'){echo "<td $negrilla><input name='dplaca[]' value='".$_POST[dplaca][$x]."' type='text' class='inpnovisibles' style='width:100%' readonly>".ucwords(strtolower($r[23]))."</td>";}
                        else {echo "<td $negrilla></td>";}		  
                        if($r[24]!='-1'){echo "<td $negrilla>".ucwords(strtolower($r[24]))."</td>";}		 
                        else {echo "<td $negrilla></td>";}	*/
                        echo "<td $negrilla>$r[26]</td>
                        <td $negrilla>$r[16]</td>
                        <td align='center' $negrilla>$r[37]</td>";
                        echo "<td $negrilla>".$r[39]."</td>";
                        if($r[37]=='S')
                            echo "<td $negrilla>".$r[38]."</td>";
                        else
                            echo "<td $negrilla>".$r[25]."</td>";
		
                            echo "<td style='text-align:center;'>
                                    <a onClick=\"verCuentaActiva($idcta,$tipo,$numfil,$filtro)\" style='cursor:pointer;'>
                                    <img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a>
                                </td>
                            </tr>";
                        $aux=$co;
                        $co=$co2;
                        $co2=$aux;
                        $i=1+$i;
                        $filas++;
					}
					if($_POST[oculto] == '2')
					{
						for($x=0;$x<count($_POST[cuenta]);$x++)
						{
							$sqlr = "UPDATE pptocuentas SET codconcepago='".$_POST[conceptoPago][$x]."', codconcecausa='".$_POST[conceptoGasto][$x]."' WHERE cuenta='".$_POST[cuenta][$x]."'";
							mysql_query($sqlr,$link);
							echo "<script>despliegamodalm('visible','1','Se ha actualizado con Exito');</script>";
						}
					}
	                $_POST[oculto]="";

                    ?>
                </table>
				<input type="hidden" name="concepto" id="concepto" value="0"/>
				<?php
				echo"<table class='inicio'>
					<tr>
						<td style='text-align:center;'>
							<a href='#'>$imagensback</a>&nbsp;
							<a href='#'>$imagenback</a>&nbsp;&nbsp;";
							if($nuncilumnas<=9){$numfin=$nuncilumnas;}
							else{$numfin=9;}
							for($xx = 1; $xx <= $numfin; $xx++){
								if($numcontrol<=9){$numx=$xx;}
								else{$numx=$xx+($numcontrol-9);}
								if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
								else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
							}
							echo "&nbsp;&nbsp;<a href='#'>$imagenforward</a>
								&nbsp;<a href='#'>$imagensforward</a>
						</td>
					</tr>
				</table>";
				?>

            </div>
        </form>
        <script>
        jQuery(function($)
        {
            var user ="<?php echo $_SESSION[cedulausu]; ?>";
            var bloque='';
            $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);

            $('#cambioVigencia').change(function(event) {
                var valor= $('#cambioVigencia').val();
                var user ="<?php echo $_SESSION[cedulausu]; ?>";
                var confirma=confirm('¿Realmente desea cambiar la vigencia?');
                if(confirma)
                {
                    var anobloqueo=bloqueo.split("-");
                    var ano=anobloqueo[0];
                    if(valor < ano)
                    {
                        if(confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar"))
                        {
                            $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
                        }
                        else
                        {
                            location.reload();
                        }
                    }
                    else
                    {
                        $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
                    }
                }
                else
                {
                    location.reload();
                } 
            });

            function updateresponse(data)
            {
                json=eval(data);
                if(json[0].respuesta=='2')
                {
                    alert("Vigencia modificada con exito");
                }
                else if(json[0].respuesta=='3')
                {
                    alert("Error al modificar la vigencia");
                }
                location.reload();
            }
            function selectresponse(data)
            { 
                json=eval(data);
                $('#cambioVigencia').val(json[0].vigencia);
                bloqueo=json[0].bloqueo;
            }
        }); 
</script>
</body>
</html>