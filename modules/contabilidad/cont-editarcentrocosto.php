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
        	function guardar()
			{
				
				var validacion01=document.getElementById('nombre').value;
				if(validacion01.trim()!=''){despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
				else {despliegamodalm('visible','2','Falta informacion para modificar el Centro Costo');}
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
			function adelante(scrtop, numpag, limreg, filtro, next){
				if(parseFloat(document.form2.idcomp.value)<parseFloat(document.form2.maximo.value)){
					document.getElementById('oculto').value='1';
					document.getElementById('idcomp').value=next;
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="cont-editarcentrocosto.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				document.getElementById('oculto').value='1';
				document.getElementById('idcomp').value=prev;
				document.getElementById('codigo').value=prev;
				var idcta=document.getElementById('codigo').value;
				document.form2.action="cont-editarcentrocosto.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}

			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="cont-buscacentrocosto.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
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
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a onClick="location.href='cont-centrocostos.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a onClick="location.href='cont-buscacentrocosto.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a href="" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
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
			$sqlr="select * from  centrocosto ORDER BY id_cc DESC";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];
			if(!$_POST[oculto])
			{
				if ($_POST[codrec]!="" || $_GET[idtipocom]!=""){
					if($_POST[codrec]!=""){$sqlr="select * from centrocosto where id_cc='$_POST[codrec]'";}
					else{$sqlr="select * from centrocosto where id_cc ='$_GET[idtipocom]'";}
				}
				else{$sqlr="select * from  centrocosto ORDER BY id_cc DESC";}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[idcomp]=$row[0];
			}

			if($_POST[oculto]!="2"){
				$sqlr="Select * from centrocosto where id_cc=$_POST[idcomp]";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res)){
					$_POST[idcomp]=$row[0];
					$_POST[nombre]=$row[1];
					$_POST[estado]=$row[2];
					$_POST[tipo]=$row[3];
					$_POST[codigo]=$row[0];
				}
			}
			//NEXT
			$sqln="select *from centrocosto where id_cc > '$_POST[idcomp]' ORDER BY id_cc ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next=$row[0];
			//PREV
			$sqlp="select *from centrocosto where id_cc < '$_POST[idcomp]' ORDER BY id_cc DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev=$row[0];
			?>
    		<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="6">.: Editar Centro Costo</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='cont-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:8%;">Codigo:</td>
                    <td style="width:13%;">
	        	    	<a onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"  style="cursor:pointer;"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:50%;" maxlength="2" readonly/>
	    	            <a onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"  style="cursor:pointer;"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
                  	</td>
                    <td class="saludo1" style="width:8%;">Nombre:</td>
                    <td><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:80%;" onKeyUp="return tabular(event,this)"/></td>
                </tr>
                <tr>
                    <td class="saludo1">Tipo:</td>
                    <td>
                        <select name="tipo" id="tipo" style="width:98%;">
                            <option value="S" <?php if($_POST[tipo]=='S') echo "selected" ?>>Entidad</option>
                            <option value="N" <?php if($_POST[tipo]=='N') echo "selected" ?>>Externo</option>
                        </select>
                    </td>
                    <td class="saludo1">Activo:</td>
                    <td>
                        <select name="estado" id="estado" style="width:8%;">
                            <option value="S" <?php if($_POST[estado]=='S') echo "selected" ?>>SI</option>
                            <option value="N" <?php if($_POST[estado]=='N') echo "selected" ?>>NO</option>
                        </select>   
                    </td>
                </tr>               
    		</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>  
            <input type="hidden" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>"/> 
  			<?php
				if($_POST[oculto]=="2")
				{
 					$sqlr="UPDATE centrocosto SET nombre='$_POST[nombre]',estado='$_POST[estado]',entidad='$_POST[tipo]' WHERE id_cc='$_POST[idcomp]'";
  					if (!mysql_query($sqlr,$linkbd)){echo "<script>despliegamodalm('visible','3','No se pudo ejecutar la petición');</script>";}
  					else {echo "<script>despliegamodalm('visible','3','Se ha modificado con Exito el centro de costo');</script>";}
 				}
			?> 
            <script type="text/javascript">$('#nombre').alphanum({allow: ''});</script>
       		<script type="text/javascript">$('#codigo').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false,maxDigits: 2});</script> 
		</form>
	</body>
</html>