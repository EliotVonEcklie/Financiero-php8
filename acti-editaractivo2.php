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

			function adelante(idproceso,scrtop,totreg,altura,numpag,limreg,clase, maximo){
					document.getElementById('oculto').value='1';
					clase=parseInt(clase)+1;
					if (parseInt(clase)<=parseInt(maximo)) {
						$("#tabla-activo-det tr").remove();
						document.form2.action="acti-editaractivo.php?idproceso="+idproceso+"&scrtop="+scrtop+"&totreg="+totreg+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
						document.form2.submit();
					}
			}
		
			function atrasc(idproceso,scrtop,totreg,altura,numpag,limreg,clase){
				document.getElementById('oculto').value='1';
				clase=parseInt(clase)-1;
				if (clase!='0') {
					$("#tabla-activo-det tr").remove();
				document.form2.action="acti-editaractivo.php?idproceso="+idproceso+"&scrtop="+scrtop+"&totreg="+totreg+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
				document.form2.submit();
			}
			}

			function iratras(scrtop, numpag, limreg, clase){
				var idcta=document.getElementById('codigo').value;
				location.href="acti-buscaactivo.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
			}
				function cambioswitch(id,estado) {

					document.getElementById('desactivar').value=id;

					
					document.getElementById('oculto2').value='3';

					if(estado==1){
						document.getElementById('desactivarestado').value='S';
						despliegamodalm('visible','4','Desea activar este Activo','1');
					}else{
						document.getElementById('desactivarestado').value='N';
						despliegamodalm('visible','4','Desea Desactivar este Activo','2');
					}
				}
				//function eliminar(id){
				//	$("table#tabla-activo-det tr#filadetalle"+(id+1)+"").remove();
				//}
				$(document).ready(function() {
					
					$('.eliminando').click(function(event) {
						$(this).parent().parent().remove();
					});
				});
    	</script>

	</head>
	<body>

		<input type="hidden" name="desactivar" id="desactivar">
		<input type="hidden" name="desactivarestado" id="desactivarestado">

			<?php
				//echo "<script>alert($_POST[oculto2]);</script>";
				if($_POST[oculto2]=="3"){
						//echo "<script>alert($sqlrEstado);</script>";
					$sqlrEstado="UPDATE acti_activos_det SET estado='$_POST[desactivarestado]' WHERE id_cab=$_GET[clase] AND id='$_POST[desactivar]';";
					echo $sqlrEstado;
						mysql_query($sqlrEstado,$linkbd);
						$_POST[oculto2]='0';
				}

				if($_POST[oculto]=="2")
				{

					$delete=' id_cab='.$_GET[clase];
					for ($x=0;$x<count($_POST[dispactivos]);$x++){
						

						if ($_POST[idcomp][$x]=='undefined') {							
							
							$sqlr12 = "SELECT MAX(id) FROM acti_activos_det WHERE id_cab=$_GET[clase]";
							$rep12 = mysql_query($sqlr12,$linkbd);
							$row12 = mysql_fetch_row($rep12);
							$row12[0]++;
							$_POST[idcomp][$x]=$row12[0];
							$sqlr11="INSERT INTO acti_activos_det (fechainicial,fechafinal,cuenta_activo,cuenta_perdida,cuenta_recuperacion,cuenta_retiro,disposicion_activos,centro_costos,estado,id_cab,id) VALUES ('".$_POST[fecha1][$x]."','".$_POST[fecha2][$x]."','".$_POST[cuentact][$x]."','".$_POST[cuentaper][$x]."','".$_POST[cuentarecuperacion][$x]."','".$_POST[cuentaretiro][$x]."','".$_POST[dispactivos][$x]."','".$_POST[cc][$x]."','S','$_GET[clase]',$row12[0]);";
							
							//echo $sqlr11.'<br>';
							if (!mysql_query($sqlr11,$linkbd)){
	  							echo "<script>despliegamodalm('visible','3','No se pudo ejecutar la petición');</script>";
	  						}

						}else { 							
 							$sqlr2="UPDATE acti_activos_det 
 								SET fechainicial='".$_POST[fecha1][$x]."',fechafinal='".$_POST[fecha2][$x]."',cuenta_activo='".$_POST[cuentact][$x]."',cuenta_perdida='".$_POST[cuentaper][$x]."',cuenta_recuperacion='".$_POST[cuentarecuperacion][$x]."',cuenta_retiro='".$_POST[cuentaretiro][$x]."',disposicion_activos='".$_POST[dispactivos][$x]."',centro_costos='".$_POST[cc][$x]."' 
 								WHERE id_cab=$_GET[clase] AND id='".$_POST[idcomp][$x]."';";
 							
 							if (!mysql_query($sqlr2,$linkbd)){
	  							echo "<script>despliegamodalm('visible','3','No se pudo ejecutar la petición');</script>";
		  					}
  						} 	
  						if($_POST[idcomp][$x]!='undefined' && $_POST[idcomp][$x]!=''){
							$delete=$delete.' AND id!='.$_POST[idcomp][$x];
						}					
  					}
  					$sqlr="UPDATE acti_activos_cab 
 						SET nombre='$_POST[nombreactivo]',estado='$_POST[estado]'
 						WHERE id=$_GET[clase]";
 						//echo $sqlr;
 						if (!mysql_query($sqlr,$linkbd)){
	  						echo "<script>despliegamodalm('visible','3','No se pudo ejecutar la petición');</script>";
	  					} else {
  							echo "<script>despliegamodalm('visible','3','Se ha modificado con Exito la Clase');</script>";
  						}

  					//echo $delete.'<br>';
  					$sqlr="DELETE FROM acti_activos_det WHERE $delete";
  					//echo $sqlr.'<br>';
  					mysql_query($sqlr,$linkbd);
 				}
			?> 
		<input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2] ?>">
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
			$sqlr="SELECT * from  acti_activos_cab ORDER BY id DESC";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);

			$_POST[maximo]=$r[0];
			if(!$_POST[oculto])	{
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
			   	//$_POST[idcomp]=$row[0];
			}

			if($_POST[oculto]!="2"){
				$sqlr="SELECT * from acti_activos_det where id_cab=$_GET[clase]";
				//echo "<br>".$sqlr;
				$res=mysql_query($sqlr,$linkbd);
				$i=0;
				while($row=mysql_fetch_row($res)){
													
					$_POST[idcomp][$i]=$row[0];
					$_POST[codigo][$i]=$row[0];

					$_POST[fecha1][$i]=$row[2];
					$_POST[fecha2][$i]=$row[3];
					$_POST[cuentact][$i]=$row[4];
					$_POST[cuentaper][$i]=$row[5];
					$_POST[cuentarecuperacion][$i]=$row[6];
					$_POST[cuentaretiro][$i]=$row[7];
					$_POST[dispactivos][$i]=$row[8];
					$_POST[cc][$i]=$row[9];
					$_POST[estadoactivo][$i]=$row[10];
					

					$sqlr1="SELECT nombre from cuentasnicsp where cuenta='$row[4]'";
					$res1=mysql_query($sqlr1,$linkbd);
					$row1=mysql_fetch_row($res1);
					$_POST[ncuentact][$i]=$row1[0];
//echo "<br>".$sqlr1;
					$sqlr2="SELECT nombre from cuentasnicsp where cuenta='$row[5]'";
					$res2=mysql_query($sqlr2,$linkbd);
					$row2=mysql_fetch_row($res2);
					$_POST[ncuentaper][$i]=$row2[0];
//echo "<br>".$sqlr2;
					$sqlr3="SELECT nombre from cuentasnicsp where cuenta='$row[6]'";
					$res3=mysql_query($sqlr3,$linkbd);
					$row3=mysql_fetch_row($res3);
					$_POST[ncuentarecuperacion][$i]=$row3[0];
//echo "<br>".$sqlr3;
					$sqlr4="SELECT nombre from cuentasnicsp where cuenta='$row[7]'";
					$res4=mysql_query($sqlr4,$linkbd);
					$row4=mysql_fetch_row($res4);
					$_POST[ncuentaretiro][$i]=$row4[0];
//echo "<br>".$sqlr4;

					$i++;
				}

				$sqlr="SELECT nombre,estado FROM acti_activos_cab WHERE id=$_GET[clase]";
              	$res = mysql_query($sqlr,$linkbd);
              	$row=mysql_fetch_row($res);
              	$_POST[nombreactivo]=$row[0];
              	$_POST[estado]=$row[1];


				

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
                    <td class="titulos" colspan="8">.: Editar el Activo</td>
                </tr>
                <tr>
                	<td class="saludo1"  style="width:10%;">Codigo:</td>
                  	<td class="saludo1"  style="width:10%;"> 
                  		<a onclick='atrasc("<?php echo $_GET[idproceso] ?>", "<?php echo $_GET[scrtop] ?>", "<?php echo $_GET[totreg] ?>", "<?php echo $_GET[altura] ?>", "<?php echo $_GET[numpag] ?>", "<?php echo $_GET[limreg] ?>","<?php echo $_GET[clase] ?>")' style="cursor:pointer;">
                  			<img src="imagenes/back.png" alt="siguiente" align="absmiddle">
              			</a>
                  		
                  		<input type="text" id="codigo" name="codigo" value="<?php echo $_GET[clase]?>" style='width:60%' readonly>
              			
              			<a onclick='adelante("<?php echo $_GET[idproceso] ?>", "<?php echo $_GET[scrtop] ?>", "<?php echo $_GET[totreg] ?>", "<?php echo $_GET[altura] ?>", "<?php echo $_GET[numpag] ?>", "<?php echo $_GET[limreg] ?>","<?php echo $_GET[clase] ?>", "<?php echo $_POST[maximo] ?>")'' style="cursor:pointer;"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
          			</td>
                	<td class="saludo1"  style="width:10%;">Nombre:</td>
                    <td class="saludo1" style="width:60%;">
                       <input type="text" id="nombreactivo" name="nombreactivo" value="<?php echo $_POST[nombreactivo]?>" style='width:100%'>
                    </td>
                         
                    <td class="saludo1">Activo:</td>
                    <td >
                        <select name="estado" id="estado" style="width:100%;">

                            <option value="S" <?php if($_POST[estado]=='S') echo "selected" ?>>SI</option>
                            <option value="N" <?php if($_POST[estado]=='N') echo "selected" ?>>NO</option>
                        </select>   
                    </td>
                </tr>               
    		</table>


    		<table class="inicio" style='margin-top: 5px;'>
				<tr>
					<td colspan="11" class="titulos">Crear Detalle Clasificacion</td>
				</tr>	
				<tr>        
		        	<td class="saludo1" style='width:10%'>Cuenta Activos:</td>
		           	<td style='width:10%'>
		           		<input type="text" id="cuentact" name="cuentact"  onKeyPress="javascript:return solonumeros(event)" 
		              		onKeyUp="return tabular(event,this)" onBlur="buscacta('3')" onClick="document.getElementById('cuentact').focus();document.getElementById('cuentact').select();" style='width:80%'>
		              	<input type="hidden" value="0" name="bca">
		              	<a href="#" onClick="mypop=window.open('cuentasnicsp-ventana.php?objeto=cuentact&nobjeto=ncuentact','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
		              	&nbsp;<img src="imagenes/buscarep.png" style='width:16px'>
		              	</a>
		          	</td>
		            <td style='width:30%' colspan="4">
		            	<input name="ncuentact" type="text" id="ncuentact" style='width:100%' readonly>
		        	</td>
					<td class="saludo1" style='width:10%'>Cuenta Perdida:</td>
		        	<td style='width:10%'>
		        		<input type="text" id="cuentaper" name="cuentaper"  onKeyPress="javascript:return solonumeros(event)" 
		              		onKeyUp="return tabular(event,this)" onBlur="buscacta('4')" onClick="document.getElementById('cuentaper').focus();document.getElementById('cuentaper').select();" style='width:80%'>
		          		<input type="hidden" value="0" name="bcp">
		          		<a href="#" onClick="mypop=window.open('cuentasnicsp-ventana.php?objeto=cuentaper&nobjeto=ncuentaper','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
		          		&nbsp;<img src="imagenes/buscarep.png" style='width:16px'>
		          		</a>
		      		</td>
		          	<td style='width:30%' colspan="4">
		          		<input id="ncuentaper" name="ncuentaper" type="text" style='width:100%' readonly>
		      		</td>
				</tr>		
				<tr>        
		        	<td class="saludo1" style='width:10%'>Cuenta Recuperacion:</td>
		           	<td style='width:10%'>
		           		<input type="text" id="cuentarecuperacion" name="cuentarecuperacion"  onKeyPress="javascript:return solonumeros(event)" 
		              		onKeyUp="return tabular(event,this)" onBlur="buscacta('3')" onClick="document.getElementById('cuentarecuperacion').focus();document.getElementById('cuentarecuperacion').select();" style='width:80%'>
		              	<input type="hidden" value="0" name="bcrecu">
		              	<a href="#" onClick="mypop=window.open('cuentasnicsp-ventana.php?objeto=cuentarecuperacion&nobjeto=ncuentarecuperacion','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
		              	&nbsp;<img src="imagenes/buscarep.png" style='width:16px'>
		              	</a>
		          	</td>
		            <td style='width:30%' colspan="4">
		            	<input name="ncuentarecuperacion" type="text" id="ncuentarecuperacion" style='width:100%' readonly>
		        	</td>
					<td class="saludo1" style='width:10%'>Cuenta Retiro:</td>
		        	<td style='width:10%'>
		        		<input type="text" id="cuentaretiro" name="cuentaretiro"  onKeyPress="javascript:return solonumeros(event)" 
		              		onKeyUp="return tabular(event,this)" onBlur="buscacta('4')" onClick="document.getElementById('cuentaretiro').focus();document.getElementById('cuentaretiro').select();" style='width:80%'>
		          		<input type="hidden" value="0" name="bcret">
		          		<a href="#" onClick="mypop=window.open('cuentasnicsp-ventana.php?objeto=cuentaretiro&nobjeto=ncuentaretiro','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
		          		&nbsp;<img src="imagenes/buscarep.png" style='width:16px'>
		          		</a>
		      		</td>
		          	<td colspan="4" style='width:30%'>
		          		<input id="ncuentaretiro" name="ncuentaretiro" type="text" style='width:100%' readonly>
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
						<input name="fecha1" id="fecha1" type="text" id="fecha1" title="YYYY-MM-DD" style="width:75%;" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha1');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
					</td>
						<td class="saludo1" style="width:5%;">Activo:</td>
		            <td>
		                <select name="estadoactivo" id="estadoactivo">
		                    <option value="S" >SI</option>
		                    <option value="N" >NO</option>
		                </select>   
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
								echo ">".$row[0]." - ".$row[1]."</option>";	 	 
							}	 	
						?>
			   			</select>
			 		</td>
			 		<td class="saludo1" style="width:10%;">Fecha Final:</td>
					<td style="width:10%;">
						<input name="infecha2" id="infecha2" type="text" id="infecha2" title="YYYY-MM-DD" style="width:75%;" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('infecha2');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
					</td>
		            <td>
		            	<input type="button"  name="agregar" id="agregar" value="Agregar">
		            	<input type="hidden" name="agregadet" id="agregadet" valuer="0">
		            	

		            </td>
		        </tr>
			</table>
			<script type="text/javascript">
				$(document).ready(function() {

					$("#agregar").click(function(event) {

						var dispactivos = $("#dispactivos").val();
			    		var cc = $("#cc").val();
			    		var fecha1 = $("#fecha1").val();
			    		var fecha2 = $("#infecha2").val();
			    		var booleamFecha = true;

						$('#tabla-activo-det tr').each(function () {

							var tablacc = $(this).find("td:eq(0)").find("input").val();
							var tabladisp = $(this).find("td:eq(1)").find("input").val();
							var tablafecha1 = $(this).find("td:eq(2)").find("input").val();
							var tablafecha2 = $(this).find("td:eq(3)").find("input").val();
													
							if (dispactivos==tabladisp && cc==tablacc) {
								//alert(dispactivos+"=="+tabladisp);
								//alert(cc+" == "+tablacc);

								if((Date.parse(fecha1)) <= (Date.parse(tablafecha2))){
									//alert('------> False');
									booleamFecha= false;	
								}
							}
						});
						
			    		var cuentact = $("#cuentact").val();
			    		var cuentarecuperacion = $("#cuentarecuperacion").val();
			    		var cuentaper = $("#cuentaper").val();
			    		var cuentaretiro = $("#cuentaretiro").val();

			    		var ncuentact = $("#ncuentact").val();
			    		var ncuentarecuperacion = $("#ncuentarecuperacion").val();
			    		var ncuentaper = $("#ncuentaper").val();
			    		var ncuentaretiro = $("#ncuentaretiro").val();

			    		var idcomp = $("#idcomp").val();
			    		if (fecha1 != "" && fecha2!="" && cuentact!="" && cuentarecuperacion!="" && cuentaper!="" && cuentaretiro!="" && dispactivos!="" && cc!="" && booleamFecha) {
				    		//var tds=$("#tabla-activo-det tr:first td").length;
			    		 	var tds=14;
			    		 	var trs=$("#tabla-activo-det tr").length;
	/*		    		 	console.log(trs);
			    		 	var separador="";
			    		 	if (trs > 2) {
			    		 		separador="|@@@|";
			    		 	}
	
			    		 	$("#veccuentact").val($("#veccuentact").val()+separador+cuentact);
			    		 	$("#veccuentarecuperacion").val($("#veccuentarecuperacion").val()+separador+cuentarecuperacion);
			    		 	$("#veccuentaper").val($("#veccuentaper").val()+separador+cuentaper);
			    		 	$("#veccuentaretiro").val($("#veccuentaretiro").val()+separador+cuentaretiro);
			    		 	$("#vecdispactivos").val($("#vecdispactivos").val()+separador+dispactivos);
			    		 	$("#veccc").val($("#veccc").val()+separador+cc);
			    		 	$("#vecfecha1").val($("#vecfecha1").val()+separador+fecha1);
			    		 	$("#vecfecha2").val($("#vecfecha2").val()+separador+fecha2);
			    		 	*/
			    		 	var style;
			    		 	if ((trs%2)==0) {
			    		 		style = "zebra1";
			    		 	}else{
			    		 		style = "zebra2";
			    		 	}
			    		 	var filadetalle="filadetalle"+(trs);
			    		 	var nuevaFila="<tr class='"+style+"' id='"+filadetalle+"'>";
			                // añadimos las columnas
			                nuevaFila+="<td align='center' ><input class='inpnovisibles' name='cc[]' type='text' readonly value='"+cc+"'><input class='inpnovisibles' name='idcomp[]' type='hidden' readonly value='"+idcomp+"''></td>";
			                nuevaFila+="<td align='center' ><input class='inpnovisibles' name='dispactivos[]' type='text' readonly value='"+dispactivos+"'></td>";

			                nuevaFila+="<td><input class='inpnovisibles' name='fecha1[]' type='text' readonly value='"+fecha1+"'></td>";
			                nuevaFila+="<td><input class='inpnovisibles' name='fecha2[]' type='text' readonly value='"+fecha2+"'></td>";

			                nuevaFila+="<td><input class='inpnovisibles' name='cuentact[]' type='text' readonly value='"+cuentact+"'></td>";
			                nuevaFila+="<td><input class='inpnovisibles' name='ncuentact[]' type='text' readonly value='"+ncuentact+"'></td>";

			                nuevaFila+="<td><input class='inpnovisibles' name='cuentarecuperacion[]' type='text' readonly value='"+cuentarecuperacion+"'></td>";
			                nuevaFila+="<td><input class='inpnovisibles' name='ncuentarecuperacion[]' type='text' readonly value='"+ncuentarecuperacion+"'></td>";

			                nuevaFila+="<td><input class='inpnovisibles' name='cuentaper[]' type='text' readonly value='"+cuentaper+"'></td>";
			                nuevaFila+="<td><input class='inpnovisibles' name='ncuentaper[]' type='text' readonly value='"+ncuentaper+"'></td>";

			                nuevaFila+="<td><input class='inpnovisibles' name='cuentaretiro[]' type='text' readonly value='"+cuentaretiro+"'></td>";
			                nuevaFila+="<td><input class='inpnovisibles' name='ncuentaretiro[]' type='text' readonly value='"+ncuentaretiro+"'></td>";
			                
			            	nuevaFila+="<td><a href='#' class='eliminando' ><img src='imagenes/del.png' ></a></td>";
				            // Añadimos una columna con el numero total de columnas.
				            // Añadimos uno al total, ya que cuando cargamos los valores para la
				            // columna, todavia no esta añadida
				            nuevaFila+="</tr>";
				            $("#tabla-activo-det").append(nuevaFila);

		            	}else{
		            		if (booleamFecha) {
		            			alert("Ingrese todo los datos");
		            		}else{
		            			alert('Debe Cambiar la Fecha de inicio');
		            		}
		            	}

						$('.eliminando').click(function(event) {
							$(this).parent().parent().remove();
						});
			    	});

				});
			</script>
			<div class="subpantalla" style="height:35%; width:99.6%; overflow-x:scroll;">

				<table class="inicio" id="tabla-activo-det">
                    <tr><td class="titulos" colspan="13">Activos</td></tr>
                    <tr>
                        <td class="titulos2" style='width: 10px;'>C.C</td>
                        <td class="titulos2" style="width: 10px;">Disp.</td>
                        <td class="titulos2" style="width: 10px;">Fecha Ini.</td>
                        <td class="titulos2" style="width: 10px;">Fecha Fin.</td>
                        <td class="titulos2" style="width: 10px;">Cuent Act</td>
                        <td class="titulos2" style="width: 10px;">Nombre</td>
                        <td class="titulos2" style="width: 10px;">Cuenta Recuperacion</td>
                        <td class="titulos2" style="width: 10px;">Nombre</td>
                        <td class="titulos2" style="width: 10px;">Cuenta Per</td>
                        <td class="titulos2" style="width: 10px;">Nombre</td>
                        <td class="titulos2" style="width: 10px;">Cuenta Retiro</td>
                        <td class="titulos2" style="width: 10px;">Nombre</td>
                        <td class="titulos2" style="width: 10px;"><img src="imagenes/del.png"></td>
                    </tr>    
                    <?php 
                        if ($_POST[elimina]!='') { 
                            $posi=$_POST[elimina];
                            unset($_POST[dids][$posi]);
                            unset($_POST[dnvars][$posi]);
                            unset($_POST[dadjs][$posi]);                     
                            $_POST[dids]= array_values($_POST[dids]); 
                            $_POST[dnvars]= array_values($_POST[dnvars]); 
                            $_POST[dadjs]= array_values($_POST[dadjs]); 
                            echo"<script>document.form2.elimina.value='';</script>";           
                        }

                        if ($_POST[agregadet]=='1') {
                          	if (true) {
	                            $_POST[dids][]=$_POST[iddet];
	                            $_POST[dnvars][]=$_POST[nombredet];
	                            $_POST[dadjs][]=$_POST[adjuntodet]; 
	                            $_POST[agregadet]=0;
	                            echo "
	                            <script>
	                              document.form2.nombredet.value=''; 
	                              document.form2.contdet.value=parseInt(document.form2.contdet.value)+1;
	                            </script>";
                          	}
                        }
                        $iter='saludo1a';
                        $iter2='saludo2';
                        for ($x=0;$x<count($_POST[fecha2]);$x++) {    
                          
                          	//$_POST[idcomp][$x]
//$_POST[codigo][$x]
//$_POST[estadoactivo][$x]
                        	

                    		$idActivo = $_POST[idcomp][$x];
                            echo "
                            <tr class='$iter' id='filadetalle".($x+1)."'>

                                <td>
                                	<input class='inpnovisibles' name='cc[]' value='".$_POST[cc][$x]."' type='text' style='width: 25px;' readonly>
                                	<input class='inpnovisibles' name='idcomp[]' value='".$_POST[idcomp][$x]."' type='hidden' readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='dispactivos[]' value='".$_POST[dispactivos][$x]."' type='text' style='width: 30px;' readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='fecha1[]' value='".$_POST[fecha1][$x]."' type='text' style='width: 80px;' readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='fecha2[]' value='".$_POST[fecha2][$x]."' type='text' style='width: 80px;' readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='cuentact[]' value='".$_POST[cuentact][$x]."' type='text' style='width: 90px;' readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='ncuentact[]' style='width: 290px;' value='".$_POST[ncuentact][$x]."' type='text' readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='cuentarecuperacion[]' style='width: 90px;' value='".$_POST[cuentarecuperacion][$x]."' type='text' readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='ncuentarecuperacion[]' style='width: 290px;' value='".$_POST[ncuentarecuperacion][$x]."' type='text'  readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='cuentaper[]' style='width: 90px;' value='".$_POST[cuentaper][$x]."' type='text' readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='ncuentaper[]' style='width: 290px;' value='".$_POST[ncuentaper][$x]."' type='text' readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='cuentaretiro[]' style='width: 90px;' value='".$_POST[cuentaretiro][$x]."' type='text'  readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='ncuentaretiro[]' style='width: 290px;'value='".$_POST[ncuentaretiro][$x]."' type='text' readonly>
                                </td>
                                <td><a href='#' class='eliminando'><img src='imagenes/del.png'></a></td>
                            </tr>";

                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
                        }
                    ?>
                </table> 
			</div>

            <input type="hidden" name="oculto" id="oculto" value="1"/>  
            
  			
            <script type="text/javascript">$('#nombre').alphanum({allow: ''});</script>
       		<script type="text/javascript">$('#codigo').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false,maxDigits: 2});</script> 
		</form>
	</body>
</html>