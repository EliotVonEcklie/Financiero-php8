<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=utf-8");
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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
		<script>
        	function validar(formulario){
				document.getElementById('oculto').value='7';
				document.form2.submit();
			}
			function guardar()
			{
				if (document.getElementById('persona').value!="-1")
				{
					if (document.getElementById('persona').value=="1")
					{
						var validacion00=document.getElementById('documento').value;
						var validacion01=document.getElementById('razonsocial').value;
						var validacion02=document.getElementById('direccion').value;
						var validacion03=document.getElementById("contribuyente");
						var validacion04=document.getElementById("proveedor");
						var validacion05=document.getElementById("empleado");
						if(!validacion03.checked){var valcheck01="0";}
						else {var valcheck01="1";}
						if(!validacion04.checked){var valcheck02="0";}
						else {var valcheck02="1";}
						if(!validacion05.checked){var valcheck03="0";}
						else {var valcheck03="1";}
						if((validacion00.trim()!='')&&(validacion01.trim()!='')&&(validacion02.trim()!='')&&(document.getElementById('mnpio').value!="-1")&&((valcheck01=="1")||(valcheck02=="1")||(valcheck03=="1")))
						{despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
						else {despliegamodalm('visible','2','Falta informacion para modificar el Tercero');}
					}
					else
					{
						var validacion00=document.getElementById('documento').value;
						var validacion01=document.getElementById('apellido1').value;
						var validacion06=document.getElementById('nombre1').value;
						var validacion02=document.getElementById('direccion').value;
						var validacion03=document.getElementById("contribuyente");
						var validacion04=document.getElementById("proveedor");
						var validacion05=document.getElementById("empleado");
						if(!validacion03.checked){var valcheck01="0";}
						else {var valcheck01="1";}
						if(!validacion04.checked){var valcheck02="0";}
						else {var valcheck02="1";}
						if(!validacion05.checked){var valcheck03="0";}
						else {var valcheck03="1";}
						if((validacion06.trim()!='')&&(validacion00.trim()!='')&&(validacion01.trim()!='')&&(validacion02.trim()!='')&&(document.getElementById('mnpio').value!="-1")&&((valcheck01=="1")||(valcheck02=="1")||(valcheck03=="1")))
						{despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
						else {despliegamodalm('visible','2','Falta informacion para modificar el Tercero');}
					
					}
				}
				else {despliegamodalm('visible','2','Falta informacion para modificar el Tercero');}
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
						document.getElementById('documento').focus();
						document.getElementById('documento').select();
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
			function verificacheckfull(nomcheck)
			{
				if (document.getElementById(''+nomcheck).checked == false)
				{
					document.getElementById(''+nomcheck).value="0";
					document.getElementById(''+nomcheck).checked=false;
				}
				else 
				{
					document.getElementById(''+nomcheck).value="1";
					document.getElementById(''+nomcheck).checked=true;
				}
				if(document.getElementById('emprse').checked==true){document.getElementById('tipoemprse').style.visibility="visible";}
				else {document.getElementById('tipoemprse').style.visibility="hidden";}
				
			}
        </script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, totreg, next){
				document.getElementById('oculto').value='1';
				document.getElementById('idtercero').value=next;
				var idcta=document.getElementById('idtercero').value;
				totreg++;
				document.form2.action="hum-terceroseditar01.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg+"&filtro="+filtro;
				document.form2.submit();
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, totreg, prev){
				document.getElementById('oculto').value='1';
				document.getElementById('idtercero').value=prev;
				var idcta=document.getElementById('idtercero').value;
				totreg--;
				document.form2.action="hum-terceroseditar01.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg+"&filtro="+filtro;
				document.form2.submit();
			}

			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('idtercero').value;
				location.href="hum-tercerosbusca01.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
			<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-terceros01.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar"  onClick="location.href='hum-buscaterceros.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"/><img src='imagenes/iratras.png' title='Men&uacute; Nomina' onClick="location.href='hum-menunomina.php'" class='mgbt'></td>
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
			if ($_GET[idter]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idter];</script>";}
			$sqlr="SELECT * FROM  terceros ORDER BY id_tercero DESC";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];
			if($_POST[oculto]=="")
			{
				if ($_POST[codrec]!="" || $_GET[idter]!="")
				{
					if($_POST[codrec]!=""){$sqlr="SELECT * FROM terceros WHERE id_tercero='$_POST[codrec]'";}
					else{$sqlr="SELECT * FROM terceros WHERE id_tercero ='$_GET[idter]'";}
				}
				else {$sqlr="SELECT * FROM terceros ORDER BY id_tercero DESC";}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[idtercero]=$row[0];
				$accion="INGRESO A EDITAR TERCEROS NOMINA No $row[0]";
				$origen=getUserIpAddr();
        		generaLogs($_SESSION["nickusu"],'HUM','V',$accion,$origen);
			}
			if(($_POST[oculto]!="2")&&($_POST[oculto]!="7"))
			{
				$sqlr="SELECT * FROM terceros WHERE id_tercero='$_POST[idtercero]'";
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[idtercero]=$row[0];
				$_POST[nombre1]=$row[1];
				$_POST[nombre2]=$row[2];
				$_POST[apellido1]=$row[3];
				$_POST[apellido2]=$row[4];	 	 
				$_POST[razonsocial]=$row[5];	 	 	 
				$_POST[direccion]=$row[6];	 	 
				$_POST[telefono]=$row[7];	 	 	 
				$_POST[celular]=$row[8];	 	 	 
				$_POST[email]=$row[9];	 	 	 
				$_POST[web]=$row[10];	 	 	 
				$_POST[tipodoc]=$row[11];	 	 
				$_POST[documento]=$row[12];	 	 
				$_POST[codver]=$row[13];	 	 
				$_POST[dpto]=$row[14];	 	 	 	 	 	 
				$_POST[mnpio]=$row[15];	 	 	 	 	 	 	 
				$_POST[persona]=$row[16];	 	 	 	 	 	 	 
				$_POST[regimen]=$row[17];	 	 	 	 	 	 	 
				$_POST[contribuyente]=$row[18];	 	 	 	 	 	 	 
				$_POST[proveedor]=$row[19];	 	 	 	 	 	 	 	 	 	 	 
				$_POST[estado]=$row[21]; 
				$sqlr1="SELECT tipoemprse FROM hum_terceros_emprse WHERE numdocumento='$row[12]'";
		 		$resp1=mysql_query($sqlr1,$linkbd);
				$row1 =mysql_fetch_row($resp1);
				if($row1[0]!='' && $row1[0]!=NULL)
				{
					$_POST[emprse]="1";
					$_POST[tipoemprse]=$row1[0];
					echo "$_POST[tipoemprse]=$row1[0]";
				}
			}
			//NEXT
			if($_POST[apellido1]!=""){
				$sqln="select *from terceros where apellido1 > '$_POST[apellido1]' ORDER BY apellido1 ASC LIMIT 1";
				$resn=mysql_query($sqln,$linkbd);
				$row=mysql_fetch_row($resn);
				$next=$row[0];
			}
			else{
				$sqln="select *from terceros where razonsocial > '$_POST[razonsocial]' ORDER BY razonsocial ASC LIMIT 1";
				$resn=mysql_query($sqln,$linkbd);
				$row=mysql_fetch_row($resn);
				$next=$row[0];
			}
			//PREV
			if($_POST[apellido1]!=""){
				$sqlp="select *from terceros where apellido1 < '$_POST[apellido1]' ORDER BY  apellido1 DESC LIMIT 1";
				$resp=mysql_query($sqlp,$linkbd);
				$row=mysql_fetch_row($resp);
				$prev=$row[0];
			}
			else{
				$sqlp="select *from terceros where razonsocial < '$_POST[razonsocial]' ORDER BY  razonsocial DESC LIMIT 1";
				$resp=mysql_query($sqlp,$linkbd);
				$row=mysql_fetch_row($resp);
				$prev=$row[0];
			}
 			?>
   	 		<table class="inicio" >
      			<tr>
        			<td class="titulos" colspan="5">.: Editar Terceros</td>
                    <td class="cerrar" style='width:7%'><a onClick="location.href='hum-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
	   			<tr>
        			<td class="saludo1" style="width:3.5cm;">.: Tipo Persona:</td>
        			<td style="width:30%;">
                    	<select name="persona" id="persona" style="width:30%;" onChange="validar()">
							<option value="-1">...</option>
							<?php
  		   						$sqlr="Select * from personas where estado='1'";
								$resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[persona]){echo "<option value=$row[0] SELECTED>$row[1]</option>";}
                                    else {echo "<option value=$row[0]>$row[1]</option>";}	  
                                }  
		  					?>
						</select>   
                   	</td>
                 	<td class="saludo1" style="width:3.5cm;">.: Regimen:</td>
        			<td style='width:30%'>
                    	<select name="regimen" id="regimen" style="width:44%;">
		 					<?php
  		   						$sqlr="Select * from regimen where estado='1' order by id_regimen";
		 						$resp = mysql_query($sqlr,$linkbd);
				    			while ($row =mysql_fetch_row($resp)) 
				    			{
									if("$row[0]"==$_POST[regimen]){echo "<option value='$row[0]' SELECTED>$row[1]</option>";}
					  				else {echo "<option value='$row[0]'>$row[1]</option>";}	  
								} 
		  					?>
						</select>
                  	</td>
             		<td rowspan="10" colspan="2"  style="background:url(imagenes/useradd02.png); background-repeat:no-repeat; background-position:right; background-size: 80% 80%"> </td>
           		</tr>
		   		<tr>
        			<td class="saludo1">.: Tipo Doc:</td>
        			<td>
                    	<select name="tipodoc" id="tipodoc" style="width:30%;">
		 					<?php
  		   						$sqlr="Select docindentidad.id_tipodocid,docindentidad.nombre from  docindentidad, documentopersona where docindentidad.estado='1' and documentopersona.persona=$_POST[persona] and documentopersona.tipodoc=docindentidad.id_tipodocid";
		 						$resp = mysql_query($sqlr,$linkbd);
				    			while ($row =mysql_fetch_row($resp)) 
				    			{
					 				if($row[0]==$_POST[tipodoc]){echo "<option value=$row[0] SELECTED>$row[1]</option>";}
					  				else {echo "<option value=$row[0]>$row[1]</option>";}  
								}
		  					?>
						</select>
                 	</td>
                    <td class="saludo1">.: Documento:</td>
        			<td>
	        	    	<a onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $totreg; ?>, <?php echo $prev; ?>)"  style='cursor:pointer;'><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" name="documento" id="documento"  onBlur="codigover()" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[documento]?>" style="width:50%" readonly/>&nbsp;-&nbsp;<input type="text" name="codver"  id="codver" size="1" maxlength="1" value="<?php echo $_POST[codver]?>" readonly/>
	    	            <a onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $totreg; ?>, <?php echo $next; ?>)"  style='cursor:pointer;'><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                 	</td>
		   		</tr>
		 		<tr>
        			<td class="saludo1">.: Primer Apellido:</td>
        <td><input type="text" name="apellido1" id="apellido1" value="<?php echo $_POST[apellido1]?>" style="width:98%;"  onKeyUp="return tabular(event,this)"/></td>
         			<td class="saludo1">.: Segundo Apellido:</td>
        			<td><input type="text" name="apellido2" id="apellido2"  value="<?php echo $_POST[apellido2]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
        		</tr>
				<tr>
        			<td class="saludo1">.: Primer Nombre:</td>
        			<td><input  type="text" name="nombre1" id="nombre1" value="<?php echo $_POST[nombre1]?>" style="width:98%;"  onKeyUp="return tabular(event,this)"/></td>
					<td class="saludo1">.: Segundo Nombre:</td>
        			<td><input type="text"  name="nombre2" id="nombre2"  value="<?php echo $_POST[nombre2]?>" style="width:100%;"  onKeyUp="return tabular(event,this)"/></td>
	  			</tr>
	   			<tr>
       			 	<td class="saludo1">.: Razon Social:</td>
        			<td colspan="3"><input type="text" name="razonsocial" id="razonsocial" value="<?php echo $_POST[razonsocial]?>" style="width:100%;" onKeyUp="return tabular(event,this)"></td>	
             	</tr>  
	   			<tr>
        			<td class="saludo1">.: Direccion:</td>
        			<td colspan="3"><input type="text" name="direccion" id="direccion" value="<?php echo $_POST[direccion]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
				</tr>
				<tr>
         			<td class="saludo1">.: Telefono:</td>
        			<td><input type="text" name="telefono" id="telefono" value="<?php echo $_POST[telefono]?>" style="width:98%;" onKeyUp="return tabular(event,this)"/></td>
		 			<td class="saludo1">.: Celular:        </td>
        			<td><input type="text" name="celular" id="celular" value="<?php echo $_POST[celular]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
       			</tr>  
	    		<tr>
        			<td class="saludo1">.: E-mail:</td>
        			<td><input type="text" name="email" id="email" value="<?php echo $_POST[email]?>" style="width:98%;" onKeyUp="return tabular(event,this)"/></td>
         			<td class="saludo1">.: Pagina Web:</td>
        			<td><input type="text" name="web" id="web" value="<?php echo $_POST[web]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
       			</tr> 
	   			<tr>
       				<td class="saludo1">:: Dpto : </td>
       			 	<td>
                    	<select name="dpto" id="dpto" onChange="validar()">
                    		<option value="-1">:::: Seleccione Departamento :::</option>
            				<?php
  		   						$sqlr="Select * from danedpto order by nombredpto";
		 						$resp = mysql_query($sqlr,$linkbd);
				    			while ($row =mysql_fetch_row($resp)) 
				    			{
					 				if($row[1]==$_POST[dpto]){echo "<option value=$row[1] SELECTED>$row[2]</option>";}
					 				else {echo "<option value=$row[1]>$row[2]</option>";}  
								}
		  					?>
          				</select>
        			</td>
        			<td class="saludo1">:: Municipio :</td>
        			<td>
                    	<select name="mnpio" id="mnpio">
							<option value="-1">:::: Seleccione Municipio ::::</option>
              				<?php
  		   						$sqlr="Select * from danemnpio where  danemnpio.danedpto='$_POST[dpto]' order by nom_mnpio";
		  						$resp = mysql_query($sqlr,$linkbd);
				    			while ($row =mysql_fetch_row($resp)) 
				    			{
					 				if($row[2]==$_POST[mnpio]){echo "<option value=$row[2] SELECTED>$row[3]</option>";}
					  				echo "<option value=$row[2]>$row[3]</option>";	  
								}
							?>        
        				</select> 
        			</td>
      			</tr> 
	       		<tr style="height:22px;">
        			<td class="saludo1">.: Tipo Tercero: </td>
                    <td colspan="2"  > 
                        :: Contribuyente:&nbsp;<input type="checkbox" name="contribuyente" id="contribuyente" class="defaultcheckbox" value="<?php echo $_POST[contribuyente];?>" onClick="verificacheckfull(this.id);" <?php if(isset($_REQUEST['contribuyente'])){echo "checked";} ?>/>&nbsp;&nbsp;
                        :: Proveedor:&nbsp;<input type="checkbox" name="proveedor" id="proveedor" class="defaultcheckbox" value="<?php echo $_POST[proveedor];?>" onClick="verificacheckfull(this.id);" <?php if(isset($_REQUEST['proveedor'])){echo "checked";} ?>/>&nbsp;&nbsp; 
                        :: Empresa Prestadora de Servicios:&nbsp;<input type="checkbox" name="emprse" id="emprse" class="defaultcheckbox" value="<?php echo $_POST[emprse];?>" onClick="verificacheckfull(this.id);" <?php if(isset($_REQUEST['emprse'])){echo "checked";} ?>/>
        			</td>   
        			<td>
                    	<select name="tipo" id="tipoemprse"  onChange="validar()" <?php if($_POST[emprse]=="1"){echo "style='width:32%; visibility:visible'";} else {echo "style='width:32%; visibility:hidden'";}?>>  			
            				<option value="PB" <?php if($_POST[tipoemprse]=='PB') echo "SELECTED"?>>Publico</option>
            				<option value="PR" <?php if($_POST[tipoemprse]=='PR') echo "SELECTED"?>>Privado</option>
                			<option value="" <?php if($_POST[tipoemprse]=='N/A') echo "SELECTED"?>>N/A</option>
						</select>
                    </td>
          		</tr>               
    		</table>
    		<input name="oculto" id="oculto" type="hidden" value="1">
            <input name="idtercero" id="idtercero" type="hidden" value="<?php echo $_POST[idtercero];?>"> </td>
			<?php
				if(($_POST[oculto]=="")||($_POST[oculto]!="2")&&($_POST[oculto]!="7"))
				{
					echo "
						<script>
							codigover();
							if(document.getElementById('contribuyente').value=='1'){document.getElementById('contribuyente').checked=true}
							if(document.getElementById('proveedor').value=='1'){document.getElementById('proveedor').checked=true}
							if(document.getElementById('emprse').value=='1'){document.getElementById('emprse').checked=true}
						</script>";
				}
				$valor=$_POST[persona];
				switch ($valor) 
				{ 
   					case '1': 
						echo"
						<script>
								document.form2.nombre1.disabled = true;
								document.form2.nombre1.value = '';
								document.form2.nombre2.disabled = true;
								document.form2.nombre2.value = '';
								document.form2.apellido1.disabled = true;
								document.form2.apellido1.value = '';		
								document.form2.apellido2.disabled = true;
								document.form2.apellido2.value = '';		
								document.form2.razonsocial.disabled = false;	
								document.getElementById('nombre1').style.backgroundColor=668;
								document.getElementById('nombre2').style.backgroundColor=668;	
								document.getElementById('apellido1').style.backgroundColor=668;
								document.getElementById('apellido2').style.backgroundColor=668;
							</script>";
      					break;
   					case '2':
						echo" 
							<script>
								document.form2.nombre1.disabled = false;
								document.form2.nombre2.disabled = false;
								document.form2.apellido1.disabled = false;
								document.form2.apellido2.disabled = false;
								document.form2.razonsocial.disabled = true;
								document.form2.razonsocial.value = '';	
								document.getElementById('razonsocial').style.backgroundColor=668;
							</script>";	
      	 				break ;
   					default: 
				} 
				if($_POST[oculto]=='2')
				{
					$sqlr="UPDATE terceros SET nombre1='$_POST[nombre1]',nombre2='$_POST[nombre2]',apellido1='$_POST[apellido1]', apellido2='$_POST[apellido2]',razonsocial='$_POST[razonsocial]',direccion='$_POST[direccion]',telefono='$_POST[telefono]', celular='$_POST[celular]',email='$_POST[email]',web='$_POST[web]',tipodoc=$_POST[tipodoc],cedulanit='$_POST[documento]', codver='$_POST[codver]',depto='$_POST[dpto]',mnpio='$_POST[mnpio]',persona=$_POST[persona],regimen=$_POST[regimen],  contribuyente='$_POST[contribuyente]',proveedor='$_POST[proveedor]',estado='$_POST[estado]' WHERE id_tercero=$_POST[idtercero]";
  					if (!mysql_query($sqlr,$linkbd)){echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";}
  					else
					{
						$accion="MODIFICO TERCERO NOMINA: $sqlr";
						$origen=getUserIpAddr();
						generaLogs($_SESSION["nickusu"],'HUM','M',$accion,$origen);
						echo "<script>despliegamodalm('visible','3','Se ha modificado con Exito');</script>";
					}
				}
			?>
            <script type="text/javascript">$('#apellido1,#apellido2,#nombre1,#nombre2').alphanum({allow: ''});</script>
            <script type="text/javascript">$('#razonsocial').alphanum({allow: '&'});</script>
            <script type="text/javascript">$('#direccion').alphanum({allow: '-'});</script>
            <script type="text/javascript">$('#email').alphanum({allow: '@._-'});</script>
            <script type="text/javascript">$('#web').alphanum({allow: ':._-/&@'});</script>
            <script type="text/javascript">$('#telefono,#celular').alphanum({allow: '-',allowSpace: true, allowLatin: false});</script>
            <script type="text/javascript">$('#documento').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false});</script>
 		</form>
	</body>
</html>