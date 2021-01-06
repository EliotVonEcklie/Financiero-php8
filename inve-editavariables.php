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
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Almacen</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function buscacta(e){if (document.form2.cuenta.value!=""){ document.form2.bc.value='1'; document.form2.submit(); }}
			function buscater(e){if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}}
			function validar(){
				document.getElementById('oculto').value='7';
				document.form2.submit();
			}
			function agregardetalle()
			{
				if(document.form2.ncuenta.value!="" ){
					document.form2.agregadet.value=1;
					document.getElementById('oculto').value='7';
					document.form2.submit();
				}
 				else {despliegamodalm('visible','2','Falta información para poder Agregar Detalle');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','¿Esta Seguro de Eliminar?','2')
			}
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if (document.form2.codigo.value!='' && validacion01.trim()!='' && document.getElementById('ntercero').value!="" && document.getElementById('condeta').value != "0"){despliegamodalm('visible','4','¿Esta Seguro de Guardar?','3')}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function despliegamodal2(_valor,_nven)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					if(_nven=="1")
					{document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=cuenta";}
					else {document.getElementById('ventana2').src="cuentasgral-ventana01.php?objeto=cuenta&nobjeto=ncuenta";}
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
						case "0":	break;
						case "1": 	document.getElementById('valfocus').value='0';
									document.getElementById('ntercero').value='';
									document.getElementById('bt').value='0';
									document.getElementById('tercero').focus();
									document.getElementById('tercero').select();break;
						case "2": 	document.getElementById('valfocus').value='0';
									document.getElementById('ncuenta').value='';
									document.getElementById('bc').value='0';
									document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();break;
					}
				}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	despliegamodalm("hidden");
								mypop=window.open('cont-terceros.php','','');break;
					case "2":	document.getElementById('oculto').value="6";
								document.form2.submit();break;
					case "3":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
				}
			}
		</script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="inve-editavariables.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="inve-editavariables.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="inve-buscavariables.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
   		<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>
    	<tr><?php menu_desplegable("inve");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="inve-variables.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="inve-buscavariables.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
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
			if ($_GET[idr]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";}
			$sqlr="select MIN(codigo), MAX(codigo) from   invevariables ORDER BY codigo";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idr]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from  invevariables where codigo='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from  invevariables where codigo ='$_GET[idr]'";
					}
				}
				else{
					$sqlr="select * from   invevariables ORDER BY codigo DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}

 			if(($_POST[oculto]!="2")&&($_POST[oculto]!="6")&&($_POST[oculto]!="7")){	
				$sqlr="SELECT * FROM  invevariables WHERE codigo='$_POST[codigo]' ";
 				$cont=0;
 				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp))
				{	 
					$_POST[codigo]=$row[0];
		 			$_POST[nombre]=$row[1]; 	
 	 	 			$_POST[tercero]=$row[2];
	 				$_POST[ntercero]=buscatercero($row[2]);
		 			$cont=$cont+1; 
				}
				unset($_POST[dcuentas]);
				unset($_POST[dncuentas]);
				unset($_POST[dccs]);
				unset($_POST[dcreditos]);		 		 		 		 		 
				unset($_POST[ddebitos]);		 
				$sqlr="SELECT * FROM  invevariables_det WHERE codigo='$_POST[codigo]'";
				$res=mysql_query($sqlr,$linkbd); 
				$cont=0;
				while ($row=mysql_fetch_row($res)) 
 				{
					$_POST[dcuentas][$cont]=$row[4];
					$_POST[dccs][$cont]=$row[5];
					$_POST[dncuentas][$cont]=buscacuenta($row[4]);
					$_POST[ddebitos][$cont]=$row[5];
					$_POST[dcreditos][$cont]=$row[6];
					$cont=$cont+1;
				}
			}
			//NEXT
			$sqln="select *from  invevariables where codigo > '$_POST[codigo]' ORDER BY codigo ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from  invevariables where codigo < '$_POST[codigo]' ORDER BY codigo DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
		?>
 		<form name="form2" method="post" action="">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
   			<table class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="6">.: Agregar Variable</td>
                    <td class="cerrar" style="width:7%;"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
	  				<td class="saludo1" style="width:8%;">Codigo:</td>
        			<td style="width:12%;">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:35%;" readonly/>
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                   	</td>
        			<td class="saludo1" style="width:13%;">Nombre Variable:</td>
        			<td style="width:45%;"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)" style="width:100%;"/></td>
                    <td></td>
        		</tr> 
        		<tr>
                	<td class="saludo1">Tercero:</td>
          			<td><input id="tercero" type="text" name="tercero"  onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:80%;"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
          			<td colspan="2"><input  id="ntercero"  name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly></td>
                    <td></td>
            	</tr>
      		</table>
	    	<table class="inicio">
				<tr>
	  				<td colspan="4" class="titulos2">Crear Detalle Variable</td></tr>
				<tr>
					<td class="saludo1" style="width:8%;">Cuenta: </td>
          			<td style="width:12%;"><input type="text" id="cuenta" name="cuenta" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"  style="width:80%;"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','2');"><img src="imagenes/buscarep.png" align="absmiddle"></a></td>
          			<td style="width:57.8%;"><input type="text" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>"  style="width:100%;" readonly></td>
                    <td></td>
				</tr>
				<tr>
					<td class="saludo1">Tipo:</td>
                    <td>
                    	<select name="debcred" style="width:80%;">
		   					<option value="1" <?php if($_POST[debcred]=='1') echo "SELECTED"; ?>>Debito</option>
             				<option value="2" <?php if($_POST[debcred]=='2') echo "SELECTED"; ?>>Credito</option>
		  				</select>
                 	</td>
                    <td><input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"></td>
                    <td></td>
				</tr>
			</table>
    		<input type="hidden" name="bc" id="bc" value="0"/>
            <input type="hidden" name="bt" id="bt" value="0" >
            <?php
				if($_POST[bc]=='1')
				{
					$nresul=buscacuenta($_POST[cuenta]);
					if($nresul!='')
					{
						echo"<script>document.getElementById('ncuenta').value='$nresul';document.getElementById('debcred').focus();</script>";
					}
					else
					{
						echo"<script>document.getElementById('valfocus').value='2';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
					}
				}
				if($_POST[bt]=='1')
				{
					$nresul=buscatercero($_POST[tercero]);
					if($nresul!='')
					{
						echo"
						<script>									
							document.getElementById('ntercero').value='$nresul';
							document.getElementById('cuenta').focus();
							document.getElementById('cuenta').select();
						</script>";
					}
					else 
					{
						echo"
						<script>
							document.getElementById('valfocus').value='1';
							despliegamodalm('visible','4','Tercero Incorrecto o no Existe, ¿Desea Agregar un Tercero?','1');
						</script>";
					}
				}
			?>
            <input type="hidden" name="oculto" id="oculto" value="0" />
        	<div class="subpantallac" style="height:53%;width:99.5%;overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="6">Detalle Variable</td></tr>
					<tr>
                    	<td class="titulos2" style='width:10%;'>Cuenta</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2" style='width:8%;'>Debito</td>
                        <td class="titulos2" style='width:8%;'>Credito</td>
                        <td class="titulos2" style='width:5%;'><img src="imagenes/del.png" ></td>
                	</tr>
                    <input type='hidden' name='elimina' id='elimina'>
					<?php
						if ($_POST[oculto]=='6')
		 				{ 
		 					$posi=$_POST[elimina];
							unset($_POST[dcuentas][$posi]);
							unset($_POST[dncuentas][$posi]);
							unset($_POST[dccs][$posi]);
							unset($_POST[dcreditos][$posi]);		 		 		 		 		 
							unset($_POST[ddebitos][$posi]);		 
							$_POST[dcuentas]= array_values($_POST[dcuentas]); 
							$_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 
							$_POST[dccs]= array_values($_POST[dccs]); 
							$_POST[dcreditos]= array_values($_POST[dcreditos]); 
							$_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
						}
						if ($_POST[agregadet]=='1')
		 				{
		  					$cuentacred=0;
		  					$cuentadeb=0;
		  					$diferencia=0;
		 					$_POST[dcuentas][]=$_POST[cuenta];
		 					$_POST[dncuentas][]=$_POST[ncuenta];
		 					$_POST[dccs][]=$_POST[cc];		 
		 					if ($_POST[debcred]==1){$_POST[dcreditos][]='N';$_POST[ddebitos][]="S";}
							else {$_POST[dcreditos][]='S';$_POST[ddebitos][]="N";}
		 					$_POST[agregadet]=0;
		  					echo"
							<script>
								document.form2.cuenta.select();
								document.getElementById('cuenta').value='';
								document.getElementById('ncuenta').value='';
							</script>";
		 				}
						$iter='saludo1a';
						$iter2='saludo2';
						$cdtll=count($_POST[dcuentas]);
						$_POST[condeta]=$cdtll;
		 				for ($x=0;$x< $cdtll;$x++)
		 				{
							echo "
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
								<td><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' class='inpnovisibles' style='width:100%;' readonly></td>
								<td><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' class='inpnovisibles' style='width:100%;' readonly></td>
								<td><input name='ddebitos[]' value='".$_POST[ddebitos][$x]."' type='text' onDblClick='llamarventanadeb(this,$x)' class='inpnovisibles' style='width:100%;' readonly></td>
								<td><input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text' onDblClick='llamarventanacred(this,$x)' class='inpnovisibles' style='width:100%;' readonly></td>
								<td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
							</tr>";
							 $aux=$iter;
							 $iter=$iter2;
							 $iter2=$aux;
		 				}	 
		 			?>
				</table>
			</div>
            <input type="hidden" name="condeta" id="condeta" value="<?php echo $_POST[condeta];?>"/>
  			<?php
				if($_POST[oculto]=='2')
				{
					if ($_POST[nombre]!="")
 					{
 						$nr="1";
 						$sqlr="UPDATE  invevariables SET nombre='$_POST[nombre]',beneficiario='$_POST[tercero]',estado='S' WHERE codigo = '$_POST[codigo]'";
  						if (!mysql_query($sqlr,$linkbd))
						{
	 						echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD, No se pudo ejecutar la petición:  invevariables');</script>";
						}
  						else
 						 {
							//****COMPUESTO	
							$sqlr="delete from  invevariables_det where  codigo ='$_POST[codigo]'";
							mysql_query($sqlr,$linkbd);
							for($x=0;$x<count($_POST[dcuentas]);$x++)
		 					{
								$sqlr="insert into  invevariables_det (codigo,tipo,tipocuenta,cuenta,debito,credito,estado,modulo) values ('$_POST[codigo]','R','N','".$_POST[dcuentas][$x]."','".$_POST[ddebitos][$x]."','".$_POST[dcreditos][$x]."','S','2')";
  								if (!mysql_query($sqlr,$linkbd))
  								{
									echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD, No se pudo ejecutar la petición:  invevariables_det');</script>";
								}
 		 						else
  								{
 									echo "<script>despliegamodalm('visible','3','Se ha almacenado el Detalle de la Variable con Exito');</script>";
		
	  	 						}
							}//***** fin del for	
  						}
					}
					else
 					{
  						echo "<table class='inicio'><tr><td class='saludo1'><center>Falta informacion para Crear la Variable <img src='imagenes/confirm.png' ></center></td></tr></table>";
 					}
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