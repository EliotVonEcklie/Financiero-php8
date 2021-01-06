<!--V 1.0 24/02/2015-->
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
	$filtro="'".$_GET['clase']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Control de Activos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<?php titlepag();?>
		<script>
        	function guardar()
			{
				/*
				var validacion01=document.getElementById('nombre').value;
				if(validacion01.trim()!=''){*/
					despliegamodalm('visible','4','Esta Seguro de Modificar','1');
					/*
				}else {
					despliegamodalm('visible','2','Falta informacion para modificar la clase');
				}*/
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
			function funcionmensaje(){}
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
			function adelante(scrtop, numpag, limreg, clase, next){
				if(parseFloat(document.form2.idcomp.value)<parseFloat(document.form2.maximo.value)){
					document.getElementById('oculto').value='1';
					document.getElementById('idcomp').value=next;
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="acti-editaractivoV2.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, clase, prev){
				document.getElementById('oculto').value='1';
				document.getElementById('idcomp').value=prev;
				document.getElementById('codigo').value=prev;
				var idcta=document.getElementById('codigo').value;
				document.form2.action="acti-editaractivoV2.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
				document.form2.submit();
			}

			function iratras(scrtop, numpag, limreg, clase){
				var idcta=document.getElementById('codigo').value;
				location.href="acti-buscaactivo.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
			}

		</script>


	</head>
	<body>

			<?php
				if($_POST[oculto]=="2")
				{
					
 					$sqlr="UPDATE acti_activos_det 
 						SET fechainicial='$_POST[fecha1]',fechafinal='$_POST[fecha2]',cuenta_activo='$_POST[cuentact]',cuenta_perdida='$_POST[cuentaper]',cuenta_recuperacion='$_POST[cuentarecuperacion]',cuenta_retiro='$_POST[cuentaretiro]',disposicion_activos='$_POST[dispactivos]',centro_costos='$_POST[cc]',estado='$_POST[estadoactivo]'
 						WHERE id_cab=$_GET[clase] AND id=$_POST[idcomp]";
 						//echo $sqlr.'<br>';
  					
	  					if (!mysql_query($sqlr,$linkbd)){
	  						echo "<script>despliegamodalm('visible','3','No se pudo ejecutar la petición');</script>";
	  					} else {
	  						$sqlr="UPDATE acti_activos_cab 
		 						SET nombre='$_POST[nombreactivo]',estado='$_POST[estado]'
		 						WHERE id=$_GET[clase]";
		 						//echo $sqlr;
		 						if (!mysql_query($sqlr,$linkbd)){
			  						echo "<script>despliegamodalm('visible','3','No se pudo ejecutar la petición');</script>";
			  					} else {
		  						echo "<script>despliegamodalm('visible','3','Se ha modificado con Exito la Clase');</script>";
		  					}
	  					}
  					
 				}
			?> 
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <?php
			$numpag=$_GET[numpag];
			$limreg=$_GET[limreg];
			$scrtop=26*$totreg;
		?>
		<table>
            <tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
            <tr><?php menu_desplegable("acti");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
  					<a onClick="location.href='acti-creacionactivos.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
  					<a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
  					<a onClick="location.href='acti-buscaactivo.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
  					<a onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  					<a onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
        	</tr>
    	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" action="">
			<?php
			if ($_GET[idtipocom]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idtipocom];</script>";}
			$sqlr="SELECT * from  acti_activos_det WHERE id_cab=$_GET[clase] ORDER BY id DESC";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];
			if(!$_POST[oculto])
			{
				if ($_POST[codrec]!="" || $_GET[idtipocom]!=""){
					if($_POST[codrec]!=""){
						$sqlr="SELECT * from acti_activos_det where id_cab=$_GET[clase] AND id='$_POST[codrec]'";
					}
					else{
						$sqlr="SELECT * from acti_activos_det where id_cab=$_GET[clase] AND id ='$_GET[idtipocom]'";
					}
				}
				else{
					if ($_GET[idproceso]=='') {
						$sqlr="SELECT * from  acti_activos_det where id_cab=$_GET[clase] ORDER BY id";		
					}else{
						$sqlr="SELECT * from  acti_activos_det where id_cab=$_GET[clase] AND  id='$_GET[idproceso]' ORDER BY id DESC";
					}
				}
				//echo $sqlr;
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[idcomp]=$row[0];
			}

			if($_POST[oculto]!="2"){
				$sqlr="SELECT * from acti_activos_det where id_cab=$_GET[clase] AND id=$_POST[idcomp]";
				//echo "<br>".$sqlr;
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res)){
													
					$_POST[idcomp]=$row[0];
					$_POST[codigo]=$row[0];

					$_POST[fecha1]=$row[2];
					$_POST[fecha2]=$row[3];
					$_POST[cuentact]=$row[4];
					$_POST[cuentaper]=$row[5];
					$_POST[cuentarecuperacion]=$row[6];
					$_POST[cuentaretiro]=$row[7];
					$_POST[dispactivos]=$row[8];
					$_POST[cc]=$row[9];
					$_POST[estadoactivo]=$row[10];
				}

				$sqlr="SELECT nombre,estado FROM acti_activos_cab WHERE id=$_GET[clase]";
              	$res = mysql_query($sqlr,$linkbd);
              	$row=mysql_fetch_row($res);
              	$_POST[nombreactivo]=$row[0];
              	$_POST[estado]=$row[1];


				$sqlr="SELECT nombre from cuentas where cuenta='$_POST[cuentact]'";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[ncuentact]=$row[0];

				$sqlr="SELECT nombre from cuentas where cuenta='$_POST[cuentaper]'";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[ncuentaper]=$row[0];

				$sqlr="SELECT nombre from cuentas where cuenta='$_POST[cuentarecuperacion]'";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[ncuentarecuperacion]=$row[0];

				$sqlr="SELECT nombre from cuentas where cuenta='$_POST[cuentaretiro]'";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[ncuentaretiro]=$row[0];

			}
			//NEXT
			$sqln="SELECT *from acti_activos_det where id_cab=$_GET[clase] AND id > '$_POST[idcomp]' ORDER BY id ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next=$row[0];
			//PREV
			$sqlp="SELECT *from acti_activos_det where id_cab=$_GET[clase] AND id < '$_POST[idcomp]' ORDER BY id DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev=$row[0];
			?>
    		<table class="inicio" align="center" style='margin-top: 5px;'>
                <tr>
                    <td class="titulos" colspan="7">.: Seleccione el Activo</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='acti-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                  	<td class="saludo1"  style="width:10%;">Nombre:</td>
                    <td class="saludo1" style="width:60%;">
                       <select name="cambclase" id="cambclase" onKeyUp="return tabular(event,this)" style="width:100%;">
                          <option value='' selected>Seleciona una Clase...</option>
                          <?php
                              $sqlrClase="SELECT * FROM acti_activos_cab";
                              $respClase = mysql_query($sqlrClase,$linkbd);
                              while ($rowClase =mysql_fetch_row($respClase)){
                                if ($_GET[clase]==$rowClase[0]) {
                                  echo "<option value='$rowClase[0]' selected>:. $rowClase[1]</option>";
                                  $_GET[clase]=$rowClase[0];
                                }else{
                                  echo "<option value='$rowClase[0]'>:. $rowClase[1]</option>";
                                }
                              }
                          ?>
                        </select>
                    </td>
                    <script type="text/javascript">
						$("#cambclase").change(function() {
							var idcta=document.getElementById('codigo').value;
							location.href="acti-editaractivoV2.php?idcta="+idcta+"&scrtop=0&numpag=1&limreg=10&clase="+$(this).val();
						});
					</script>
                    <td class="saludo1" style="width:10%;">Codigo:</td>
                    <td style="width:10%;">
	        	    	<a onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"  style="cursor:pointer;"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:50%;" maxlength="2" readonly/>
	    	            <a onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"  style="cursor:pointer;"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                  	</td>
                  
                </tr>               
    		</table>

    		<table class="inicio" align="center" style='margin-top: 5px;'>
                <tr>
                    <td class="titulos" colspan="8">.: Editar el Activo</td>
                </tr>
                <tr>
                  	<td class="saludo1"  style="width:10%;">Nombre:</td>
                    <td class="saludo1" style="width:60%;">
                       <input type="text" id="nombreactivo" name="nombreactivo" value="<?php echo $_POST[nombreactivo]?>" style='width:100%'>
                    </td>
                         
                    <td class="saludo1" style="width:5%;">Activo:</td>
                    <td style="width:5%;">
                        <select name="estado" id="estado" style="width:100%;">

                            <option value="S" <?php if($_POST[estado]=='S') echo "selected" ?>>SI</option>
                            <option value="N" <?php if($_POST[estado]=='N') echo "selected" ?>>NO</option>
                        </select>   
                    </td>
                </tr>               
    		</table>

	<table class="inicio" style='margin-top: 5px;'>
		<tr><td colspan="11" class="titulos2">Crear Detalle Clasificacion</td></tr>	
		<tr>        
        	<td class="saludo1" style='width:10%'>Cuenta Activos:</td>
           	<td style='width:10%'>
           		<input type="text" id="cuentact" name="cuentact"  onKeyPress="javascript:return solonumeros(event)" 
              		onKeyUp="return tabular(event,this)" onBlur="buscacta('3')" value="<?php echo $_POST[cuentact]?>" onClick="document.getElementById('cuentact').focus();document.getElementById('cuentact').select();" style='width:80%'>
              	<input type="hidden" value="0" name="bca">
              	<a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentact&nobjeto=ncuentact','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
              	&nbsp;<img src="imagenes/buscarep.png" style='width:16px'>
              	</a>
          	</td>
            <td style='width:30%' colspan="4">
            	<input name="ncuentact" type="text" id="ncuentact" value="<?php echo $_POST[ncuentact]?>" style='width:100%' readonly>
        	</td>
			<td class="saludo1" style='width:10%'>Cuenta Perdida:</td>
        	<td style='width:10%'>
        		<input type="text" id="cuentaper" name="cuentaper"  onKeyPress="javascript:return solonumeros(event)" 
              		onKeyUp="return tabular(event,this)" onBlur="buscacta('4')" value="<?php echo $_POST[cuentaper]?>" onClick="document.getElementById('cuentaper').focus();document.getElementById('cuentaper').select();" style='width:80%'>
          		<input type="hidden" value="0" name="bcp">
          		<a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentaper&nobjeto=ncuentaper','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
          		&nbsp;<img src="imagenes/buscarep.png" style='width:16px'>
          		</a>
      		</td>
          	<td style='width:30%' colspan="4">
          		<input id="ncuentaper" name="ncuentaper" type="text" value="<?php echo $_POST[ncuentaper]?>" style='width:100%' readonly>
      		</td>
		</tr>		
		<tr>        
        	<td class="saludo1" style='width:10%'>Cuenta Recuperacion:</td>
           	<td style='width:10%'>
           		<input type="text" id="cuentarecuperacion" name="cuentarecuperacion"  onKeyPress="javascript:return solonumeros(event)" 
              		onKeyUp="return tabular(event,this)" onBlur="buscacta('3')" value="<?php echo $_POST[cuentarecuperacion]?>" onClick="document.getElementById('cuentarecuperacion').focus();document.getElementById('cuentact').select();" style='width:80%'>
              	<input type="hidden" value="0" name="bcrecu">
              	<a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentarecuperacion&nobjeto=ncuentarecuperacion','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
              	&nbsp;<img src="imagenes/buscarep.png" style='width:16px'>
              	</a>
          	</td>
            <td style='width:30%' colspan="4">
            	<input name="ncuentarecuperacion" type="text" id="ncuentarecuperacion" value="<?php echo $_POST[ncuentarecuperacion]?>" style='width:100%' readonly>
        	</td>
			<td class="saludo1" style='width:10%'>Cuenta Retiro:</td>
        	<td style='width:10%'>
        		<input type="text" id="cuentaretiro" name="cuentaretiro"  onKeyPress="javascript:return solonumeros(event)" 
              		onKeyUp="return tabular(event,this)" onBlur="buscacta('4')" value="<?php echo $_POST[cuentaretiro]?>" onClick="document.getElementById('cuentaretiro').focus();document.getElementById('cuentaretiro').select();" style='width:80%'>
          		<input type="hidden" value="0" name="bcret">
          		<a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentaretiro&nobjeto=ncuentaretiro','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
          		&nbsp;<img src="imagenes/buscarep.png" style='width:16px'>
          		</a>
      		</td>
          	<td colspan="4" style='width:30%'>
          		<input id="ncuentaretiro" name="ncuentaretiro" type="text" value="<?php echo $_POST[ncuentaretiro]?>" style='width:100%' readonly>
      		</td>
		</tr>
		<tr>
			<td class="saludo1">Disposicion de los Activos:</td>
    		<td colspan="6">
				<select id="dispactivos" name="dispactivos" onKeyUp="return tabular(event,this)" style="width: 100%;">
				<?php
					$sqlr="SELECT * from acti_disposicionactivos where estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){
						echo "<option value=$row[0] ";
						$i=$row[0];
					 	if($i==$_POST[dispactivos]){
							echo "SELECTED";
						}
						echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
				?>
	   			</select>
	 		</td>			
			<td class="saludo1" style="width:10%">Fehca Inicial:</td>
			<td style="width:10%;">
				<input name="fecha1" id="fecha1" type="text" id="fecha1" title="YYYY-MM-DD" style="width:75%;" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha1');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
			</td>
			<td class="saludo1" style="width:10%;">Fecha Final:</td>
			<td style="width:10%;">
				<input name="fecha2" id="fecha2" type="text" id="fecha2" title="YYYY-MM-DD" style="width:75%;" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha2');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
			</td>    		
        </tr>
        <tr>
			<td class="saludo1">Centro de Costos:</td>
    		<td colspan="6">
				<select id="cc" name="cc" onKeyUp="return tabular(event,this)" style="width: 100%;">
				<?php
					$sqlr="SELECT * from centrocosto where estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){
						echo "<option value=$row[0] ";
						$i=$row[0];
					 	if($i==$_POST[cc]){
							echo "SELECTED";
						}
						echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
				?>
	   			</select>
	 		</td>
			<td class="saludo1" style="width:5%;">Activo:</td>
            <td style="width:5%;">
                <select name="estadoactivo" id="estadoactivo" style="width:100%;">

                    <option value="S" <?php if($_POST[estadoactivo]=='S') echo "selected" ?>>SI</option>
                    <option value="N" <?php if($_POST[estadoactivo]=='N') echo "selected" ?>>NO</option>
                </select>   
            </td>

        </tr>
	</table>


            <input type="hidden" name="oculto" id="oculto" value="1"/>  
            <input type="hidden" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>"/> 
  			
            <script type="text/javascript">$('#nombre').alphanum({allow: ''});</script>
       		<script type="text/javascript">$('#codigo').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false,maxDigits: 2});</script> 
		</form>
	</body>
</html>