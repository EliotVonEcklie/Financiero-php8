<?php //V 1000 12/12/16 ?> 
<?php
//*****04-04-2016 se quita codigo unspc
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
		<title>:: Spid - Almacen</title>
       	<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
 			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
						case "5": 	document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	
						document.getElementById('oculto').value="2";
						document.form2.submit();break;
					case "2":
						document.getElementById('oculto').value="7";
						document.form2.elimina.value=variable;
						vvend=document.getElementById('elimina');
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){}
			function guarda()
			{
				var validacion01=document.getElementById('codigo').value;
				var validacion02=document.getElementById('nombre').value;
				var validacion03=document.getElementById('cuenta').value;
				if (validacion01.trim()!='' && validacion02.trim()!='' && validacion03.trim()!='' && document.getElementById('grupoinv').value !='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function buscar()
			{
				if(document.getElementById('cuenta').value!=""){document.form2.busqueda.value='1';document.form2.submit();}
			}
			function agregardetalle(){
				var validacion00=document.getElementById('nombre').value;
				var validacion01=document.getElementById('umedida').value;
				var validacion02=document.getElementById('factor').value;
				if((validacion00.trim()!='')&&(validacion01.trim()!='')&&(validacion02.trim()!='')){
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
				else{
					despliegamodalm('visible','2','Faltan Informaci�n para poder Agregar');
				}
			}

			function eliminar(variable,id_det,reg){
				document.getElementById('eliminado').value=id_det;
				for(var i=0;i<reg;i++){
					if(variable<=i){
						if (i<(reg-1)) {
							document.getElementById('prin'+i).value=document.getElementById('prin'+(i+1)).value;
							document.getElementById('id_det'+i).value=document.getElementById('id_det'+(i+1)).value;
						}
					}
				}
				despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);

			}

			function camarcori(pos, reg){
				document.getElementById('principal').setAttribute("disabled" , "disabled" , false);
				for(var i=0;i<reg;i++){
					if(pos==i){
						document.getElementById('prin'+i).value=1;
					}
					else{
						document.getElementById('prin'+i).value=0;
					}
				}
			}

			function art_principal(){
				if (document.getElementById('principal').checked) {
					document.getElementById('factor').value=1;
					document.getElementById('factor').setAttribute("readonly" , "readonly" , false);
				}else{
					document.getElementById('factor').value='';
					document.getElementById('factor').removeAttribute("readonly"  , false);
				}
			}

		</script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codart').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codart').value=next;
					var idcta=document.getElementById('codart').value;
					document.form2.action="inve-editararticulos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('codart').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codart').value=prev;
					var idcta=document.getElementById('codart').value;
					document.form2.action="inve-editararticulos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codart').value;
				location.href="inve-buscaarticulos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
  				<td colspan="3" class="cinta">
					<a href="inve-articulos.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
					<a href="#"  onClick="guarda();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a href="inve-buscaarticulos.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
         	</tr>
		</table> 	
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
        <form name="form2" method="post" action="" enctype="multipart/form-data">
        	<input type="hidden" name="codrec" id="codrec"/> 
        	<input type="hidden" name="oculto" id="oculto" value="1"/>   
        	<input id='eliminado' name="eliminado" value='' type='hidden'>
        	<input type="hidden" name="dirimag1" id="dirimag1" value="<?php echo $_POST[dirimag1];?>" onChange="document.form2.submit();"/>
			<input type="hidden" name="imaini1" id="imaini1" value="<?php echo $_POST[imaini1];?>"/> 
			<?php
			if ($_GET[codigo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[codigo];</script>";}
			$sqlr="select MIN(CONVERT(CONCAT(grupoinven, codigo), SIGNED INTEGER)), MAX(CONVERT(CONCAT(grupoinven, codigo), SIGNED INTEGER)) from almarticulos ORDER BY CONVERT(CONCAT(grupoinven, codigo), SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[codigo]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from almarticulos WHERE CONCAT(grupoinven, codigo)='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from almarticulos WHERE CONCAT(grupoinven, codigo)='$_GET[codigo]'";
					}
				}
				else{
					$sqlr="select * from  almarticulos ORDER BY CONCAT(grupoinven, codigo) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codart]=$row[3].$row[0];
			}

                if(($_POST[oculto]!="2")&&($_POST[oculto]!="7"))
                {	
                    $sqlr="SELECT * FROM almarticulos WHERE CONCAT(grupoinven, codigo)=$_POST[codart]";
                    $res=mysql_query($sqlr,$linkbd);
                    while($row=mysql_fetch_row($res))
                    {
                        $_POST[nombre]=$row[1];
                        $_POST[estado]=$row[4];
						$_POST[codigo]=$row[0];
						$_POST[codinterno]=$row[6];
                        $_POST[cuenta]=$row[2];
                        $_POST[ncuenta]=buscaproducto($row[2]);
                        $_POST[grupoinv]=$row[3];
                    	if($row[5]!=""){$_POST[nimagen1]=$row[5];}
						else {$_POST[nimagen1]="";}
                        if ($_POST[nimagen1]!="")
						{echo "<script>document.getElementById('dirimag1').value='imagenes/$_POST[nimagen1]';</script>";}
						else{echo "<script>document.getElementById('dirimag1').value='imagenes/usuario_on.png';</script>";}
                    }
                }

                if($_POST[oculto]=="")
                {	
                	function eliminarDir()
					{
						$usersave=$_SESSION[cedulausu];
						$carpeta="informacion/temp/us$usersave";
						foreach(glob($carpeta . "/*") as $archivos_carpeta)
						{
							if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
							else{unlink($archivos_carpeta);}
						}
						rmdir($carpeta);
					}
					$usersave=$_SESSION[cedulausu];
					$rutaad="informacion/temp/us$usersave/";
					if(!file_exists($rutaad)){mkdir ($rutaad);}
					else {eliminarDir();mkdir ($rutaad);}
					$_POST[imaini1]="0";

					unset($_POST[id_det]);
					unset($_POST[unid]);
					unset($_POST[facd]);
					unset($_POST[prin]);
					$sqlr="SELECT * FROM almarticulos_det  WHERE articulo='$_POST[codart]'";
					$res=view($sqlr);
					foreach ($res as $key => $row) {
						$_POST[id_det][$key] = $row[id_det];
						$_POST[unid][$key]=$row[unidad];
						$_POST[facd][$key]=$row[factor];
						$_POST[prin][$key]=$row[principal];
					}
				}

			//NEXT
			$sqln="select *from almarticulos WHERE CONCAT(grupoinven, codigo) > '$_POST[codart]' ORDER BY CONCAT(grupoinven, codigo) ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[3].$row[0]."'";
			//PREV
			$sqlp="select *from almarticulos WHERE CONCAT(grupoinven, codigo) < '$_POST[codart]' ORDER BY CONCAT(grupoinven, codigo) DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[3].$row[0]."'";
            ?>
    		<table class="inicio" align="center" >
      			<tr>
       			 	<td class="titulos" colspan="9">.: Editar Articulos</td>
        			<td class="cerrar" style="width:7%"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
     		 	</tr>
      			<tr>
       				<td class="saludo1" style="width:11%;">.: Grupo Inventario:</td>
            		<td style="width:15%;">
             			<select name="grupoinv" id="grupoinv" onChange="codi()" style="width:100%;text-transform:uppercase" disabled>
				 			<option value="">Seleccione ....</option>
							<?php
					 			$sqlr="SELECT * FROM almgrupoinv WHERE estado='S' ORDER BY codigo";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[grupoinv]){echo "<option value='$row[0]' style='text-transform:uppercase' SELECTED>$row[0] - $row[1]</option>"; }
									else {echo "<option value='$row[0]' style='text-transform:uppercase'>$row[0] - $row[1]</option>";}
			     				}   		
							?>
		  				</select>
       				</td>
					<td class="saludo1" style="width:7%;">.: Codigo:</td>
        			<td style="width:7%;">
        				<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly/>
        				<input type="hidden" id="codart" value="<?php echo $_POST[codart]?>">
        			</td>
        			<td class="saludo1" style="width:11%;">.: Imagen Producto:</td>
                    <td style="width:11%;">
                        <input type="text" name="nimagen1" id="nimagen1"  style="width:83%" value="<?php echo $_POST[nimagen1]?>" class="tamano02"  readonly/>
                        <div class='upload' style="height:24px;float:right;" > 
                            <input type="file" name="adnimagen1" id="adnimagen1" value="<?php echo $_POST[adnimagen1];?>"  onChange="document.form2.submit();" title="Cargar Imagen" />
                            <img src='imagenes/upload01.png' style="width:23px"/> 
                         </div> 
                     </td>
                     <td style="width:1%;">
                     </td>
                     <td style="width:30%;position: absolute;">
       					<div class="mfoto02">
                            <img id="imagencm1" src="imagenes/usuario_on.png" style="max-height: 110px;">
                        </div>
       				</td>
       			</tr>
       			<tr>
        			<td class="saludo1">.: Nombre Articulo: </td>
        			<td colspan="3"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)" style="width:100%;"/></td>
        			<td>
        				<span class="saludo1" style="position: absolute;width: 6.5%;margin-top: -4px;padding-top: 5px;">.: Activo:</span>
        				<select name="estado" id="estado" style="width: 30%;position: relative;float: right;">
          					<option value="S" selected>SI</option>
          					<option value="N">NO</option>
        				</select> 
        			</td>
					<td class="saludo1">.: Cod Interno:</td>
					<td>
						<input id="codinterno" name="codinterno" value="<?php echo $_POST[codinterno] ?>" readonly	>
					</td>
       			</tr>           
      			<tr>
       				<td class="saludo1">.: Unidad de Medida:</td>
            		<td >
             			<select name="umedida" id="umedida" style="width:100%;text-transform:uppercase">
				 			<option value="">Seleccione ....</option>
							<?php
					 			$sqlr="SELECT * FROM dominios WHERE nombre_dominio='unidad_medida' AND tipo='S' ORDER BY descripcion_valor";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)){
									if($row[2]==$_POST[umedida]){
										echo "<option value='$row[2]' style='text-transform:uppercase' SELECTED>$row[2]</option>";										
									}
									else {
										echo "<option value='$row[2]' style='text-transform:uppercase'>$row[2]</option>";
									}
			     				}   		
							?>
		  				</select>
       				</td>
       				<td class="saludo1">.:Unidad Principal:</td>
		           	<td>			
		           		<input type="checkbox" id="principal" name="principal" onclick="art_principal()" value="1">
        			</td>
       				<td class="saludo1" >.: Factor de Conversion: </td>
        			<td >
                    	<input type="text" name="factor" id="factor" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="" style="width:100%; text-align:right;"/>
		           	</td>
	           	</tr>
	           	<tr>
		           	<td class="saludo1" >.: Codigo UNSPSC: </td>
        			<td width="10%">
                    	<input type="text" name="cuenta" id="cuenta" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[cuenta]?>" style="width:86%; text-align:right;" onBlur="buscar()"/> <a href="#" onClick="despliegamodal2('visible');"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" class="icobut"></a>
		           	</td>
		           	<td colspan="5">
                    	<input type="text" name="ncuenta" id="ncuenta" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ncuenta]?>" style="width:75%; text-align:right;" readonly/>
						<input type="button" name="agrega" value=" Agregar Unidad " onClick="agregardetalle()" >
            			<input type="hidden" value="0" name="agregadet" id="agregadet">
		           	</td>
              	</tr>
    		</table>
    		<script>
				//function cargar_imagen
    			function preloader() 
				{
					if (document.getElementById) 
					{
							document.getElementById('imagencm1').src=document.getElementById('dirimag1').value+"?=<?php echo Date('U');?>";
					}
				}
				function addLoadEvent(func) 
				{
					var oldonload = window.onload;
					if (typeof window.onload != 'function') {window.onload = func;} 
					else 
					{
						window.onload = function() 
						{
							if (oldonload) {oldonload();}
							func();
						}
					}
				}
				addLoadEvent(preloader);
    		</script>
    		<?php
    			if (is_uploaded_file($_FILES['adnimagen1']['tmp_name'])) 
				{
					$archivo = $_FILES['adnimagen1']['name'];
					$tipo = $_FILES['adnimagen1']['type'];
					$usersave=$_SESSION[cedulausu];
					$destino = "informacion/temp/us$usersave/".$archivo;
					if (copy($_FILES['adnimagen1']['tmp_name'],$destino))
					{
						echo"
						<script>
							document.getElementById('nimagen1').value='".$_FILES['adnimagen1']['name']."';
							document.getElementById('dirimag1').value='$destino';
							document.getElementById('dirimag1').scr='$destino';
							document.getElementById('imaini1').value='2';
						</script>";
					}
					else
					{
						echo"<script>document.getElementById('nimagen1').value='';
						despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
					} 
				}
    		?>
    		<?php
				$codart=$_POST[grupoinv].$_POST[codigo];
					
				if($_POST[oculto]=="7"){				
 					$sqld="DELETE FROM almarticulos_det WHERE id_det='$_POST[eliminado]'";
					$resd=mysql_query($sqld,$linkbd);
				}
				if($_POST[oculto]=="2")
				{
					$camarchi1=$_POST[nimagen1];
					if($_POST[imaini1]=="2" && $_POST[nimagen1]!="")
					{
						$camarchi1="articulo_".$camarchi1;
						$usersave=$_SESSION[cedulausu];
						$temarchivo="informacion/temp/us$usersave/$_POST[nimagen1]";
						copy($temarchivo, "imagenes/".$camarchi1);
						echo "<script>document.getElementById('imaini1').value='0';</script>";
					}
					 					
 					$sqlr="UPDATE almarticulos SET nombre='$_POST[nombre]', codunspsc='$_POST[cuenta]', estado='$_POST[estado]' , imagen='$camarchi1' WHERE grupoinven='$_POST[grupoinv]' AND codigo='$_POST[codigo]'";

					if (!mysql_query($sqlr,$linkbd)){
						echo"<script>despliegamodalm('visible','2',''Error no se almaceno');</script>";
					}	
					else {
						$sqld="DELETE FROM almarticulos_det WHERE articulo='$codart'";
						$resd=mysql_query($sqld,$linkbd);

						for($x=0;$x< count($_POST[unid]);$x++)
						{
							$princ = 'prin'.$x;
							$consdet=selconsecutivo('almarticulos_det','id_det');
		 					$sqld="INSERT INTO almarticulos_det (id_det,articulo,unidad,factor,principal) VALUES ('$consdet','$codart','".$_POST[unid][$x]."', '".$_POST[facd][$x]."', '".$_POST[$princ]."')";
							view($sqld);
						}
						echo"<script>despliegamodalm('visible','3','Se ha Actualizado el Articulo con Exito');</script>";
					}
				}
			?> 
			<div class="subpantallac" style="height:76.5%; width:99.6%">
				<table class="inicio">
					<tr>
				    	<td class="titulos" colspan="4">.:Detalle Art�culos - Unidades de Medida</td>
				   	</tr>
					<tr>
				    	<td class="titulos2">Unidad de Medida</td>
				    	<td class="titulos2">Factor de Conversion</td>
				    	<td class="titulos2">Principal</td>
				        <td class="titulos2">
                        	<img src="imagenes/del.png" >
                            <input type='hidden' name='elimina' id='elimina'>
                       	</td>
				   	</tr>
					<?php			 
					if ($_POST[elimina]!=''){ 
		 				$posi=$_POST[elimina];
						unset($_POST[unid][$posi]);
						unset($_POST[facd][$posi]);
						$_POST[unid]= array_values($_POST[unid]); 
						$_POST[facd]= array_values($_POST[facd]); 		 		 
		 			}
	
					if($_POST[agregadet]=='1'){
						if (!in_array($_POST[umedida], $_POST[unid])) {
							$_POST[unid][]=$_POST[umedida];
							$_POST[facd][]=$_POST[factor];
						}else{
							echo "<script>despliegamodalm('visible','2','Unidad de Medida Repetida');</script>";
						}
						$_POST[agregadet]=0;
					}
					$cunid = count($_POST[unid]);
					for($x=0;$x< $cunid;$x++){
						if (!isset($_POST[prin][$x])) {//Envio de POST Se pierden los datos
							$_POST[prin][$x] = $_POST['prin'.$x];
							$_POST[id_det][$x] = $_POST['id_det'.$x];
						}
						if (!isset($_POST[id_det][$x])) {//Detalle  Nuevo
							$_POST[id_det][$x] = 0;
							$_POST[prin][$x] = 0;
						}
						$display = "<a href='#' onclick='eliminar($x,".$_POST[id_det][$x].",".$cunid.")'><img src='imagenes/del.png'></a>";
						if($_POST[prin][$x]==1){
							$marcador='checked';
							$display = "<a href='#'><img src='imagenes/del-des.png'></a>";
							echo "<script>camarcori(".$x.", ".$cunid.");</script>";
						}else {$marcador='disabled';}
                        if ($_POST[principal]==1 && $x == ($cunid-1)) {
                    		$marcador='checked';
                    		$display = "<a href='#'><img src='imagenes/del-des.png'></a>";
                        	$_POST[prin][$x] = 1;
                        	echo "<script>camarcori(".$x.", ".$cunid.");</script>";
                        }
						echo "<tr>
								<td class='saludo2' style='width:70%'>
									<input class='inpnovisibles' name='unid[]' value='".$_POST[unid][$x]."' type='text' style='width:100%'>
								</td>
								<td class='saludo2' style='width:15%'>
									<input class='inpnovisibles' name='facd[]' value='".$_POST[facd][$x]."' type='text' style='width:100%; text-align:right'>
								</td>
								<td>
									<input name='id_det".$x."' id='id_det".$x."' value='".$_POST[id_det][$x]."' type='hidden' >
									<input name='prin".$x."' id='prin".$x."' value='".$_POST[prin][$x]."' type='hidden' >
	                            	<input type='radio' id='radio".$x."' name='uniprin' class='defaultradio' $marcador/>
								</td>
								<td class='saludo2' style='width:15%'>
									$display
								</td>

							</tr>";
				 	}	 
				 	?>
             	</table>
			</div>
            <?php
            	if($_POST[busqueda]=='1')
				{
					$dosdigitos=substr($_POST[cuenta], 6);
					if($dosdigitos!="00" && $dosdigitos!="")
					{
						$nresul=buscaproducto($_POST[cuenta]);
						if($nresul!=''){echo"<script>document.form2.ncuenta.value='$nresul';</script>";}
						else
						{
							echo"
							<script>
								despliegamodalm('visible','2','C�digo Incorrecto');
								document.form2.ncuenta.value='';
								document.form2.cuenta.value='';
							</script>";
						}
					}
					else
					{
						echo"
						<script>
							despliegamodalm('visible','2','C�digo Incorrecto');
							document.form2.ncuenta.value='';
							document.form2.cuenta.value='';
						</script>";
					}
				}

				$sqlr="SELECT * FROM almarticulos_det  WHERE articulo='$_POST[codart]' ";
				$res=mysql_query($sqlr,$linkbd); 
				$cont = 0;
				while($row=mysql_fetch_row($res)){
					if($row[4]==1){
                       	echo "<script>
                       document.getElementById('radio".$cont."').checked = 'checked';
                       document.getElementById('prin".$cont."').value=1;
                       </script>";
                   	}
                   	$cont=$cont+1;
                }

			?>
    		<input type="hidden" name="busqueda" id="busqueda" value="0"/>
  			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
 		</form>
	</body>
</html>