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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
<script>
	function guardar()
	{
		if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.acuerdo.value!='')
		{
			despliegamodalm('visible','4','Esta Seguro de Modificar','1');
		}
		else{
			despliegamodalm('visible','2','Faltan datos para Modificar el registro');
			document.form2.acuerdo.focus();document.form2.acuerdo.select();
		}
	}

	function validarar(){
		if(document.form2.valoradicion.value!='0' || document.form2.valorreduccion.value!='0'){
			document.form2.valortraslados.value='0';
		}
		
		document.form2.submit();
	}

	function validart(){
		if(document.form2.valortraslados.value!='0'){
			document.form2.valoradicion.value='0';
			document.form2.valorreduccion.value='0';
		}
		document.form2.submit();
	}

	function clasifica(formulario)
	{
		//document.form2.action="presu-recursos.php";
		document.form2.submit();
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

	function funcionmensaje(){document.location.href = "presu-acuerdos.php";}
	function respuestaconsulta(pregunta)
	{
		switch(pregunta)
		{
			case "1":	document.getElementById('oculto').value='2';document.form2.submit();break;
		}
	}
</script>

		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
        	<tr><?php menu_desplegable("presu");?></tr>
        	<tr>
         		<td colspan="3" class="cinta">
					<a href="presu-acuerdos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="presu-buscaracuerdos.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a>
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
        	</tr>
    	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
<?php
$vigencia=vigencia_usuarios($_SESSION[cedulausu]); 
$linkbd=conectar_bd();
 ?>	
<?php
if(!$_POST[oculto])
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[vigencia]=$vigencia;
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		 
}
?>
 <form name="form2" method="post" action="">
    <table class="inicio" align="center" width="80%" >
      <tr >
        <td class="titulos" style="width: 95%" colspan="2">.: Agregar Acto Administrativo </td>
        <td class="cerrar" style="width: 5%" ><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr>
      	<td style="width:75%;">
      		<table>
      			<tr  >
				  <td  class="saludo1" style="width: 15%">Fecha: </td>
			        <td style="width: 30%">
						<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width: 40%" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
						<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
					</td>
					<td class="saludo1" style="width: 15%">Numero:</td>
			        <td  valign="middle" style="width: 20%" >
						<input type="text" id="numero" name="numero" style="width: 100%" onKeyPress="javascript:return solonumeros(event)" 
					  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();">
					</td>
					<td style="width: 33%"></td>
				  </tr>
				  <tr>
					 <td  class="saludo1">Acto Administrativo:</td>
			          <td  valign="middle" colspan="3" ><input type="text" id="acuerdo" name="acuerdo"  style="width: 100%" 
					  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[acuerdo]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td>
					  </tr>
					  <tr>
					  <td class="saludo1">Vigencia:</td>
					  <td><input type="text" id="vigencia" name="vigencia" style="width: 80%" onKeyPress="javascript:return solonumeros(event)" 
					  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('valor').focus();document.getElementById('valor').select();" readonly>		</td>
			          <td class="saludo1">Tipo</td>
					  <td>
					  <select name="tipoacuerdo" id="tipoacuerdo" style="width: 100%" onKeyUp="return tabular(event,this)" onChange="clasifica()">
			          <option value="I" <?php if($_POST[tipoacuerdo]=='I') echo "SELECTED"; ?>>Incial</option>
			          <option value="M" <?php if($_POST[tipoacuerdo]=='M') echo "SELECTED"; ?>>Modificacion</option>
			        </select>		  
				    </td></tr>
					  <?php
					  if($_POST[tipoacuerdo]=='M')
					   {
					  ?>
					  <tr>	  
					  <td class="saludo1">Valor Adicion:</td>
					  <td>
						<input name="valoradicion" type="text" style="width: 80%" onKeyPress="javascript:return solonumeros(event)" 
					  onKeyUp="return tabular(event,this)" onChange="" value="<?php echo $_POST[valoradicion];?>"></td>
					  <td class="saludo1">Valor Reduccion:</td>
					  <td>
						<input name="valorreduccion" style="width: 100%" type="text" onKeyPress="javascript:return solonumeros(event)" 
					  onKeyUp="return tabular(event,this)" onChange="" value="<?php echo $_POST[valorreduccion];?>"></td>
					  </tr>
					  <tr>
					  <td class="saludo1">Valor Traslados:</td>
					  <td >
						<input name="valortraslados" type="text" style="width: 80%" onKeyPress="javascript:return solonumeros(event)" 
					  onKeyUp="return tabular(event,this)" onChange="" value="<?php echo $_POST[valortraslados];?>">
					  <input name="valor" type="hidden"  value="0">
					  </td>
						<td>
					    <input type="button" name="guardard2" id="guardard2" value="   Guardar   " onClick="guardar()">
						<input type="hidden" value="1" name="oculto" id="oculto">
					</td>
				    </tr>
				   <?php
				     }
					 else
					 {
					 ?>
					   <tr>	  
					  <td class="saludo1">Valor Inicial:</td>
					  <td>
						<input name="valor" type="text" style="width: 80%" onKeyPress="javascript:return solonumeros(event)" 
					  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[valor];?>">
						<input name="valortraslados" type="hidden"  value="<?php echo $_POST[valortraslados];?>"><input name="valorreduccion" type="hidden"  value="0"><input name="valoradicion" type="hidden"  value="0"><input name="valoradicion" type="hidden"  value="0"></td>
			  		  <td>
						<input type="button" name="guardard" id="guardard" value="   Guardar   " onClick="guardar()">
						<input type="hidden" value="1" name="oculto" id="oculto">
					  </td>
					  </tr>
					<?php 
					 }
				   ?>  
      		</table>
      	</td>
      	<td colspan="3" style="width:25%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>
      </tr>
    </table>
	<?php
	if(!$_POST[oculto])
	{ 
		 ?>
		 <script>
    	document.form2.fecha.focus();
		</script>
	<?php
	}
	?>
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	if($_POST[acuerdo]!="")
	{
		$sqlb="select * from pptoacuerdos where consecutivo='$_POST[numero]' and vigencia='$_POST[vigencia]' AND estado <> 'N'";
		$resb=mysql_query($sqlb,$linkbd);
		if(mysql_num_rows($resb)!=0){
			echo"<script>despliegamodalm('visible','2','El Numero de Acuerdo YA EXISTE');</script>";
		}
		else{
			$nr="1";	
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			$sqlr="INSERT INTO pptoacuerdos (consecutivo,numero_acuerdo,fecha,vigencia,valoradicion,valorreduccion,valortraslado,valorinicial,estado,tipo)VALUES ($_POST[numero],'$_POST[acuerdo]','".$fechaf."','$_POST[vigencia]',$_POST[valoradicion],$_POST[valorreduccion], $_POST[valortraslados],$_POST[valor],'S','$_POST[tipoacuerdo]')";
		 //echo "sqlr:".$sqlr;
			if (!mysql_query($sqlr,$linkbd))
			{
				echo"<script>despliegamodalm('visible','2','ERROR EN LA CREACION DEL ACUERDO');</script>";
			}
			else
			{
				echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
				echo "<script>document.form2.valoradicion.value=0;</script>";
				echo "<script>document.form2.valorreduccion.value=0;</script>";
				echo "<script>document.form2.acuerdo.value='';</script>";
				echo "<script>document.form2.valor.value=0;</script>";
				echo "<script>document.form2.fecha.focus();</script>";
			}
		}
	}
	else
	{
		echo "<script>despliegamodalm('visible','1','Falta informacion para Crear el Acuerdo de Modificacion al Presupuesto');
		document.form2.fecha.focus();</script>";	
	}
 }
?> 
</td></tr>     
</table>
</body>
</html>