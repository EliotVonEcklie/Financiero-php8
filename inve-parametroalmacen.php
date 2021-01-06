<?php //V 1000 12/12/16 ?> 
<?php
  require"comun.inc";
  require"funciones.inc";
  session_start();

  $linkbd=conectar_bd();  
  cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
  header("Cache-control: private"); // Arregla IE 6
  date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: Spid - Almacen</title>
<script>
	function guardar(){
		document.form2.oculto.value=2;
		despliegamodalm('visible','4','Esta Seguro de Guardar','1');
	}
//************* ver reporte ************
	function despliegamodal2(_valor){
		document.getElementById("bgventanamodal2").style.visibility=_valor;
		if(_valor=="hidden"){document.getElementById('ventana2').src="";}
		else{document.getElementById('ventana2').src="cuentas-ventana01.php";}
	}
	function cambioswitch(id,valor){
		document.getElementById('idestado').value=id;
		if(valor==1){
			despliegamodalm('visible','4','Desea activar este Parametro de Valuacion','1');
		}
		else{
			despliegamodalm('visible','4','Desea Desactivar este Parametro de Valuacion','2');
		}
	}
	function despliegamodalm(_valor,_tip,mensa,pregunta){
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden"){
			document.getElementById('ventanam').src="";
		}
		else{
			switch(_tip){
				case "1":
					document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
				case "2":
					document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
				case "3":
					document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
				case "4":
					document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
			}
		}
	}
	function respuestaconsulta(estado,pregunta){
		if(estado=="S"){
			switch(pregunta){
				case "1":	document.form2.cambioestado.value="1";break;
				case "2":	document.form2.cambioestado.value="0";break;
			}
		}
		else{
			switch(pregunta){
				case "1":	document.form2.nocambioestado.value="1";break;
				case "2":	document.form2.nocambioestado.value="0";break;
			}
		}
		document.form2.submit();
	}
	function iratras(){
				window.location='inve-parametros.php';
			}
	function validar3(){
		document.form2.bc.value=1;
		document.form2.submit();
	}
</script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
	<table>
    	<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    	<tr><?php menu_desplegable("inve");?></tr>
		<tr>
		  	<td colspan="3" class="cinta">
            	<a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo" border="0" /></a>
                <a href="#" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" /></a>
	   			<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
		    	<a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a><a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
			</td>
		</tr>	
	</table>
	<div id="bgventanamodalm" class="bgventanamodalm">
    	<div id="ventanamodalm" class="ventanamodalm">
        	<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
            </IFRAME>
       	</div>
   	</div>
 	<form name="form2" method="post" action="inve-parametroalmacen.php">
		<?php
		if($_POST[oculto]==""){
			$sql="SELECT cuenta FROM almparametros WHERE estado='S' ";
			$res=mysql_query($sql,$linkbd);
			$fila=mysql_fetch_row($res);
			$_POST[cuenta]=$fila[0];
			$_POST[ncuenta]=buscacuenta($fila[0]);
		}
		
		$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		if($_POST[bc]=='1')
		{
			$nresul=buscacuenta($_POST[cuenta]);
			if($nresul!='')
			{
				$_POST[ncuenta]=$nresul;
				echo "<script>document.getElementById('ncuenta').value='$nresul';</script>";
			}
			else
			{
				$_POST[ncuenta]="";
				echo "<script>despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
			}
		}
		?>
		<?php
		//*****************************************************************
		if($_POST[cambioestado]!=""){
			if($_POST[cambioestado]=="1"){
				$estado=$_POST[idestado];
				$sqlr="UPDATE dominios
				    SET tipo = CASE 
				        WHEN valor_inicial='$_POST[idestado]' and nombre_dominio='param_almacen' THEN 'S'
				        WHEN valor_inicial<>'$_POST[idestado]' and nombre_dominio='param_almacen' THEN 'N'
				    END
					WHERE nombre_dominio='param_almacen'";
	            mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
			}
/*			else{
         		$sqlr="UPDATE dominios SET tipo='N' WHERE valor_inicial='$_POST[idestado]' and nombre_dominio='param_almacen'";
	           	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
			}*/
			echo"<script>document.form2.cambioestado.value=''</script>";
		}
		//*****************************************************************
		if($_POST[nocambioestado]!=""){
			if($_POST[nocambioestado]=="1"){
				$_POST[lswitch1][$_POST[idestado]]=1;
			}
			else{
				$_POST[lswitch1][$_POST[idestado]]=0;
			}
			echo"<script>document.form2.nocambioestado.value=''</script>";
		}
 		?>
		<table class="inicio" align="center" >
      		<tr>
        		<td class="titulos" colspan="3"> .: Parametrizacion Cuenta por Pagar Fija</td>
		        <td class="cerrar" ><a href="inve-principal.php">Cerrar</a></td>
		   	</tr>
			<tr>
        		<td class="saludo1" style="width: 10%">Cuenta:</td>
				<td style="width: 20%"><input type="text" name="cuenta" id="cuenta" value="<?php echo $_POST[cuenta]?>" onKeyPress="javascript:return solonumeros(event)" onBlur="validar3()" style="width:85%"/>&nbsp;
						<a href="#" onClick="despliegamodal2('visible',1);"><img src="imagenes/find02.png" style="width:20px;"/></a></td>
				<td style="width: 60%"><input type="text" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>"  style="width:60%" readonly/></td>
		   	</tr>
    	</table> 
		<table class="inicio" align="center" >
      		<tr>
        		<td class="titulos" colspan="4"> .: Configuración de Valuación de Inventarios</td>
		   	</tr>
    	</table>    
		<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>"/>
		<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
		<input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>"/>
		<input type="hidden" name="bc" id="bc" value="0"/>
		<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]; ?>"/>	
    	<?php
			$crit1=" ";
			$crit2=" ";
			$sqlr="select * from dominios where nombre_dominio='param_almacen' order by valor_inicial";
			$resp = mysql_query($sqlr,$linkbd);
			$ntr = mysql_num_rows($resp);
			$con=1;
			echo "<table class='inicio' align='center' width='80%'>
				<tr>
					<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
				</tr>
				<tr>
					<td colspan='5'> Encontrados: $ntr</td>
				</tr>
				<tr>
					<td width='5%' class='titulos2'>Codigo</td>
					<td class='titulos2'>Nombre</td>
					<td class='titulos2' colspan='2' width='10%'>Estado</td>
				</tr>";	
				//echo "nr:".$nr;
				$iter='saludo1a';
				$iter2='saludo2';
				while($row =mysql_fetch_row($resp)){
				if($row[4]=='S'){
					$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;
				}
				else{
					$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";;$_POST[lswitch1][$row[0]]=1;
				}
				 echo "<tr class='$iter'>
				 	<td>".strtoupper($row[0])."</td>
					<td>".strtoupper($row[2])."</td>
					<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
					<td>
						<input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"".$row[0]."\",\"".$_POST[lswitch1][$row[0]]."\")' />
					</td>
				</tr>";
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
			}
			echo"</table>";
		?>
		<?php
		if($_POST[oculto]==2){
			$sql="DELETE FROM almparametros";
			mysql_query($sql,$linkbd);
			$fecha=date("d/m/Y");
			$sql="INSERT INTO almparametros(cuenta,vigencia,estado,fecha) VALUES ('$_POST[cuenta]','$vigusu','S','$fecha')";
			mysql_query($sql,$linkbd);
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