<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	error_reporting(0);
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		 <script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<script>
			$(window).load(function () {
				$('#cargando').hide();
			});
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
			function despliegamodal2(_valor,_nomcu)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					document.getElementById('ventana2').src="cuentasgral-ventana03.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto="+_nomcu+"&nobjeto=000";
				}
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
				case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":
						document.form2.elimina.value=variable;
						//eli=document.getElementById(elimina);
						vvend=document.getElementById('elimina');
						//eli.value=elimina;
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){}
			function pdf()
			{
				document.form2.action="presu-ejecucioningresospdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="presu-ejecucioningresosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function validar()
			{
				document.getElementById('oculto').value='3';
				document.form2.submit(); 
			}
			var expanded = false;
			function showCheckboxes() {
			  var checkboxes = document.getElementById("checkboxes");
			  if (!expanded) {
			    checkboxes.style.display = "block";
			    expanded = true;
			  } else {
			    checkboxes.style.display = "none";
			    expanded = false;
			  }
			}
			var expanded1 = false;
			function showCheckboxes1() {
			  var checkboxes1 = document.getElementById("checkboxes1");
			  if (!expanded1) {
			    checkboxes1.style.display = "block";
			    expanded1 = true;
			  } else {
			    checkboxes1.style.display = "none";
			    expanded1 = false;
			  }
			}
		function direccionaCuentaGastos(row){
			var cell = row.getElementsByTagName("td")[0];
			var id = cell.innerHTML;
			var fechai=document.form2.fecha.value;
			var fechaf=document.form2.fecha2.value;
			window.open("presu-auxiliarcuentaingresos.php?cod="+id+"&fechai="+fechai+"&fechaf="+fechaf);
			
		}
		</script>

		<style type="text/css">
		.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;

}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;

}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
  position: absolute;
  width: 13%;
  overflow-y: scroll;
  z-index: 999999999;
}
#checkboxes1{
 display: none;
  border: 1px #dadada solid;
  position: absolute;
  width: 13%;
  overflow-y: scroll;
  z-index: 9999;	
}
#checkboxes label,#checkboxes1 label {
  display: block;
  background: #ECEFF1;
  border-bottom: 1px solid #CFD8DC;
  font-size: 10px;
}
#checkboxes label:last-child, #checkboxes1 label:last-child {
  display: block;
  background: #ECEFF1;
  border-bottom: none;
}

#checkboxes label:hover,#checkboxes1 label:hover {
  background-color: #1e90ff;
  cursor:pointer;
}

	</style>
		<?php titlepag();?>
	</head>
<body>
 <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
        	<tr><?php menu_desplegable("presu");?></tr>
        	<tr>
  				<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a> <a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar"/></a> <a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a> <a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a> <a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a> <a href="presu-ejecucionpresupuestal.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a><a href="descargartxt.php?id=<?php echo $informes[$_POST[reporte]].".txt"; ?>&dire=archivos" target="_blank" class="mgbt"><img src="imagenes/contraloria.png"  title="contraloria"></a><a href="<?php echo "archivos/FORMATO_6_Ejecucion_Presupuestal_de_Ingresos.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/sia.png"  title="csv" width="32px" height="32px"></a></td>
          	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
		<form name="form2" method="post" action="presu-ejecucioningresos.php">
			<input type="hidden" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia];?>" >
			<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			if($_POST[bc]!='')
			{
				$nresul=buscacuentapres($_POST[cuenta],2);			
				if($nresul!='')
				{
					$_POST[ncuenta]=$nresul;
   			 /* $linkbd=conectar_bd();
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=". $vigusu;
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			  $_POST[valor]=$row[5];		  
			  $_POST[valor2]=$row[5];	*/	  			  

				}
				else
				{
					$_POST[ncuenta]="";	
				}
			}
 ?>
	<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
		<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
	</div>
    <table  align="center" class="inicio" >
		<tr >
			<td class="titulos" colspan="12">.: Ejecucion Ingresos</td>
			<td width="7%" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
		</tr>
		<tr>      
			<td width="12%" class="saludo1">Fecha Inicial:</td>
			<td width="12%"><input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="8" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px;" align="absmiddle" border="0"></a>        </td>
			<td width="12%" class="saludo1">Fecha Final: </td>
			<td width="12%"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="8" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width:20px;" align="absmiddle" border="0"></a>  
			</td>
			<td style="width:5%" class="saludo1">Unidad(es): </td>
			<td style="width:10%">
				<div class="multiselect">
			    <div class="selectBox" onclick="showCheckboxes()">
			      <select>
			        <option id="texto" >Selecciona...</option>
			      </select>
			      <div class="overSelect"></div>
			    </div>
			    <div id="checkboxes">
			    <?php
			    $sql="Select * from pptouniejecu  WHERE estado='S' order by id_cc";
			    $query=mysql_query($sql,$linkbd);
			  
			    while ($row = mysql_fetch_array($query)){
			    	echo "<label for='".$row[0]."'>";
			    	echo "<input type='checkbox' class='".$row[0]."' id='$row[0]' name='unidad'/>$row[0] - $row[1]";
			    	echo "</label>";
			   
			    }
			    ?>
			    </div>
			  </div>
			  <input type="hidden" name="filtros" id="filtros" value="">
			</td>
			<td style="width:5%" class="saludo1">Orden: </td>
			<td style="width:7%">
				<select name="orden" id="orden" style="width: 100%">
					<option value="">Seleccione ....</option>
					<option value="ASC" <?php if($_POST[orden]=="ASC"){ echo "selected"; } ?> >Ascendente</option>
					<option value="DESC" <?php if($_POST[orden]=="DESC"){ echo "selected"; } ?> >Descendente</option>
				</select>
			</td>
			<td style="width:5%" class="saludo1">Fuente: </td>
			<td style="width:30%">
				<select name="ffunc" id="ffunc" style="width: 100%">
					<option value="">Seleccione ....</option>
					<?php
						$sql="SELECT codigo,nombre FROM pptofutfuentefunc UNION SELECT codigo,nombre FROM pptofutfuenteinv ORDER BY CAST(codigo AS SIGNED) ASC";
						$result=mysql_query($sql,$linkbd);
						while($row = mysql_fetch_row($result)){
							echo "<option value='$row[0]'>$row[0] - $row[1]</option>";
						}
					?>
				</select>
			</td>

			<td width="5%">
				<input type="button" name="generar" value="Generar" onClick="validar()"> 
				<input type="hidden" value="<?php echo $_POST[oculto]; ?>" name="oculto" id="oculto">
			</td>
			<td width="33%"></td>
		</tr> 
			<tr> 
    			<td class="saludo1" >Cuenta Inicial:</td>
        		<td><input type="text" id="cuenta1" name="cuenta1" size="8" onKeyPress="javascript:return solonumeros(event)" 
						onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta1]?>" onClick="document.getElementById('cuenta1').focus();document.getElementById('cuenta1').select();"><a href="#" onClick="mypop=window.open('cuentasppto-ventanac1.php?ti=1&c=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
        		<td class="saludo1" >Cuenta Final:</td>
				<td><input type="text" id="cuenta2" name="cuenta2" size="8" onKeyPress="javascript:return solonumeros(event)" 
						onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta2]?>" onClick="document.getElementById('cuenta2').focus();document.getElementById('cuenta2').select();"><a href="#" onClick="mypop=window.open('cuentasppto-ventanac1.php?ti=1&c=2','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
				<td style="width:5%" class="saludo1">Clasificacion: </td>
			<td style="width:10%">
				<div class="multiselect">
			    <div class="selectBox" onclick="showCheckboxes1()">
			      <select>
			        <option id="texto1">Selecciona...</option>
			      </select>
			      <div class="overSelect"></div>
			    </div>
			    <div id="checkboxes1">
			    <?php
			    $contenido="";
			    $sql="Select * from dominios where nombre_dominio like 'CLASIFICACION_RUBROS' and TIPO='I' $contenido order by descripcion_dominio ASC";

			    $query=mysql_query($sql,$linkbd);
			    $i=10;
			    while ($row = mysql_fetch_array($query)){
			    	echo "<label for='".$i."' style='color:#BDBDBD'>";
			    	echo "<input type='checkbox' class='".$i."' name='clasifica' id='".$i."' disabled/>$i - ".strtoupper($row[2])." ";
			    	echo "</label>";
			    	$i++;
			    }
			    ?>
			    </div>
			    <input type="hidden" name="filtrosclases" id="filtrosclases" value="">
			  </div>
			</td>
			<td style="width=5%" class="saludo1">Sector: </td>
			<td style="width=7%">
				<select name="sectores" id="sectores">
				  <option value="">Seleccione ....</option>
					<?php
					 $sqlr="Select * from presusectores order by sector ASC";
		 			 $resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if(0==strcmp($i,$_POST[sectores]))
			 	{
				 echo "SELECTED";
				 }
				echo " >".$row[0]."</option>";	  
			     }			
				?>
				  </select>
			</td>
			<td style="width:5%" class="saludo1">Regalias: </td>
			<td style="width:30%; border: 1px dashed gray">
			
				<input type="checkbox" name="regalias" id="regalias" <?php if(isset($_POST[regalias])){echo "CHECKED"; }?> />
			</td>
    		</tr>   		
    </table>
	<?php

		if($_POST[oculto]==2){
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha1);
			$fechaf=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha2);
			$fechaf2=$fecha2[3]."-".$fecha2[2]."-".$fecha2[1];	
			if($_POST[vereg]=='1'){
				if($fecha1[3]==$fecha2[3]){
					$correcto=1;
					$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
					$resv=mysql_query($sqlv,$linkbd);
					if(mysql_num_rows($resv)!=0){
						$todos=1;
					}
					else{
						$todos=0;
					}
				}
				else{
					$correcto=0;
					echo "<script>despliegamodalm('visible','1','El Presupuesto General SOLO Aplica para Una Vigencia');</script>";				
				}
			}
			elseif($_POST[vereg]=='2'){
				if($fecha1[3]==$fecha2[3]){
					$correcto=1;
					$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
					//echo $sqlv;
					$resv=mysql_query($sqlv,$linkbd);
					if(mysql_num_rows($resv)!=0){
						$todos=1;
					}
					else{
						$todos=0;
					}
				}
				else{
					$numvig=$fecha2[3]-$fecha1[3];
					if(($numvig>0)&&($numvig<3)){
						$vigenciarg=$fecha1[3].' - '.$fecha2[3];
						$sqlv2="SELECT * FROM pptocuentas WHERE vigenciarg='$vigenciarg'";
						$resv2=mysql_query($sqlv2,$linkbd);
						if(mysql_num_rows($resv2)!=0){
							$correcto=1;
							if($numvig>0){
								$todos=1;
							}
							else{
								$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
								$resv=mysql_query($sqlv,$linkbd);
								if(mysql_num_rows($resv)!=0){
									$todos=1;
								}
								else{
									$todos=0;
								}
							}
						}
						else{
							$correcto=0;
							echo "<script>despliegamodalm('visible','1','Su Busqueda NO corresponde a una Vigencia del SGR');</script>";			
						}
					}
					else{
						$correcto=0;
						echo "<script>despliegamodalm('visible','1','La Vigencia para SGR se puede Consultar Maximo por 2 Años');</script>";				
					}
				}
			}
		}
		//**** busca cuenta
		if($_POST[bc]!='')
		{
			$nresul=buscacuentapres($_POST[cuenta],2);
			if($nresul!='')
			{
				$_POST[ncuenta]=$nresul;	  			  
				?>
				<script>
					document.form2.fecha.focus();
					document.form2.fecha.select();
				</script>
			<?php
			}
			else
			{
				$_POST[ncuenta]="";
			?>
				<script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			<?php
			}
		}
	?>
	<table>
	
	</table>
	<?php
	if ($_POST[oculto]==3)
	{
	?>

	
	<?php
		
		//$vigencia=$_SESSION[vigencia];
		$fech1=split("/",$_POST[fecha]);
		$fech2=split("/",$_POST[fecha2]);
		$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
		$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
		$_POST[vigencia]=$fech1[2];
		$cuentaInicial='';
		$cuentaFinal='';
		$iter="zebra1";
		$iter2="zebra2";
		if(isset($_POST['cuenta1'])){
			if(!empty($_POST['cuenta1']))
				$cuentaInicial=$_POST['cuenta1'];
		}
		if(isset($_POST['cuenta2'])){
			if(!empty($_POST['cuenta2']))
				$cuentaFinal=$_POST['cuenta2'];
		}
		$cuentaPadre=Array();
		$vectorDif=Array();
		cuentasAux();
		$namearch2="archivos/".$informes[$_POST[reporte]].".txt";
		$Descriptor2 = fopen($namearch2,"w+"); 	
		if(!empty($_POST[regalias])){
			echo "<div class='subpantallac5' style='height:60%; width:99.6%; margin-top:0px; overflow-x:scroll' id='divdet'>
				<table class='inicio' align='center' id='valores' >
					<tr class='titulos'>
				<td colspan='15'>.: Ejecucion Cuentas</td>
			</tr>
			<tr class='titulos2'>
				<td id='col1' >Cuenta</td>
				<td id='col2' >Nombre</td>
				<td id='col2' >Fuente</td>
				<td id='col3' >Disponibilidad Inicial</td>
				<td id='col3' >Presupuesto Inicial</td>
				<td id='col4' >Adicion</td>
				<td id='col5' >Reduccion</td>
				<td id='col6' >Presupuesto Definitivo</td>
				<td id='col7' >Superavit Fiscal</td>
				<td id='col8' >Recaudos Anteriores</td>
				<td id='col9' >Recaudos de Consulta</td>
				<td id='col10' >Total Recaudos</td>
				<td id='col11' >Saldo por Recaudar</td>
				<td id='col12' >% En Ejecucion</td>
			</tr>
				<tbody>";
		}else{
			echo "<div class='subpantallac5' style='height:50%; width:99.6%; margin-top:0px; overflow-x:scroll' id='divdet'>
				<table class='inicio' align='center' id='valores' >
					<tr class='titulos'>
				<td colspan='15'>.: Ejecucion Cuentas</td>
			</tr>
			<tr class='titulos2'>
				<td id='col1' >Cuenta</td>
				<td id='col2' >Nombre</td>
				<td id='col2' >Fuente</td>
				<td id='col3' >Presupuesto Inicial</td>
				<td id='col4' >Adicion</td>
				<td id='col5' >Reduccion</td>
				<td id='col6' >Presupuesto Definitivo</td>
				<td id='col7' >Superavit Fiscal</td>
				<td id='col8' >Recaudos Anteriores</td>
				<td id='col9' >Recaudos de Consulta</td>
				<td id='col10' >Total Recaudos</td>
				<td id='col11' >Saldo por Recaudar</td>
				<td id='col12' >% En Ejecucion</td>
			</tr>
				<tbody>";
		}
		

			$elimina="DELETE FROM pptoejecucionpresu_ingresos";
			mysql_query($elimina,$linkbd);

	   		for ($i=0; $i <sizeof($cuentaPadre) ; $i++) { 
	   			buscaCuentasHijo($cuentaPadre[$i]);
			}

			$sqlRep="SELECT * FROM meci_reportepersonalizado WHERE sist_cod='90' ORDER BY id_reporte";
			$resRep=mysql_query($sqlRep,$linkbd);
			$rowRep =mysql_fetch_row($resRep);
			$sqlReporte = $rowRep[5];

			$namearch="archivos/FORMATO_6_Ejecucion_Presupuestal_de_Ingresos.csv";
			$Descriptor1 = fopen($namearch,"w+"); 
	   		$totPresuInicial=0;
	   		$totDispobilidad=0;
	   		$totAdiciones=0;
	   		$totReducciones=0;
	   		$totPresuDefinitivo=0;
	   		$totIngresos_ant=0;
	   		$totIngresos_mes=0;
	   		$totIngresos_tot=0;
	   		$totSaldo=0;
	   		$totPorcentaje=0;
	   		$totSuperavit=0;
			foreach ($cuentas as $key => $value) {
					$numeroCuenta=$cuentas[$key]['numCuenta'];
					$nombreCuenta=$cuentas[$key]['nomCuenta'];
					$fuenteCuenta=$cuentas[$key]['fuenCuenta'];
					$presupuestoInicial=$cuentas[$key]['presuInicial'];
					$disponibilidad=$cuentas[$key]['disponibilidad'];
					$adicion=$cuentas[$key]['adicion'];
					$reduccion=$cuentas[$key]['reduccion'];
					$presupuestoDefinitivo=$cuentas[$key]['presuDefinitivo'];
					$ingresos_ant=$cuentas[$key]['ingreso_ant'];
					$ingresos_mes=$cuentas[$key]['ingreso_mes'];
					$ingresos_tot=$cuentas[$key]['ingreso_tot'];
					$superavit=$cuentas[$key]['superavit'];
					$saldo_ing=$cuentas[$key]['saldo_ing'];
					$porcentaje=$cuentas[$key]['porcentaje'];
					$tipo=$cuentas[$key]['tipo'];
					$tasa=$cuentas[$key]['tasa'];
					$saldo=0;
					$style='';
					if($saldo<0){
						$style='background: yellow';
					}
				fputs($Descriptor2,"D\t".$numeroCuenta."\t".$_POST[periodo]."\t".$vigusu."\tPROGRAMACIONDEINGRESOS\r\n");
				$nombreCuentaff=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$nombreCuenta);
				if(!empty($numeroCuenta))//----bloque nuevo 17/01/2016
				{  
					if($tipo=='Auxiliar' || $tipo=='auxiliar')
					{
						$totPresuInicial+=$cuentas[$key]['presuInicial'];
						$totDispobilidad+=$cuentas[$key]['disponibilidad'];
						$totAdiciones+=$cuentas[$key]['adicion'];
						$totReducciones+=$cuentas[$key]['reduccion'];
						$totPresuDefinitivo+=$cuentas[$key]['presuDefinitivo'];
						$totIngresos_ant+=$cuentas[$key]['ingreso_ant'];
						$totIngresos_mes+=$cuentas[$key]['ingreso_mes'];
						$totIngresos_tot+=$cuentas[$key]['ingreso_tot'];
						$totSuperavit+=$cuentas[$key]['superavit'];
						$totSaldo+=$cuentas[$key]['saldo_ing'];
						$totPorcentaje+=$cuentas[$key]['porcentaje'];
						echo "<tr style='font-size:9px; text-rendering: optimizeLegibility;$style' class='$iter' ondblclick='direccionaCuentaGastos(this)'>";
						if(!empty($_POST[regalias]))
						{
							echo "
							<td id='1' style='width: 5%'>$numeroCuenta</td>
							<td id='2' style='width: 15%'>$nombreCuentaff</td>
							<td id='2' style='width: 15%'>$fuenteCuenta</td>
							<td id='3' style='width: 5.5%'>".number_format($disponibilidad,2,",",".")."</td>
							<td id='3' style='width: 5.5%'>".number_format($presupuestoInicial,2,",",".")."</td>
							<td id='4' style='width: 4.5%'>".number_format($adicion,2,",",".")."</td>
							<td id='5' style='width: 4.5%'>".number_format($reduccion,2,",",".")."</td>
							<td id='6' style='width: 5%'>".number_format($presupuestoDefinitivo,2,",",".")."</td>
							<td id='7' style='width: 4.5%'>".number_format($superavit,2,",",".")."</td>
							<td id='8' style='width: 4.5%'>".number_format($ingresos_ant,2,",",".")."</td>
							<td id='9' style='width: 4.5%'>".number_format($ingresos_mes,2,",",".")."</td>
							<td id='10' style='width: 4.5%'>".number_format($ingresos_tot,2,",",".")."</td>
							<td id='11' style='width: 4.5%'>".number_format($saldo_ing,2,",",".")."</td>
							<td id='12' style='width: 4.5%'>".$porcentaje."%</td>";
						}
						else
						{
							echo "
							<td id='1' style='width: 5%'>$numeroCuenta</td>
							<td id='2' style='width: 15%'>$nombreCuentaff</td>
							<td id='2' style='width: 15%'>$fuenteCuenta</td>
							<td id='3' style='width: 5.5%'>".number_format($presupuestoInicial,2,",",".")."</td>
							<td id='4' style='width: 4.5%'>".number_format($adicion,2,",",".")."</td>
							<td id='5' style='width: 4.5%'>".number_format($reduccion,2,",",".")."</td>
							<td id='6' style='width: 5%'>".number_format($presupuestoDefinitivo,2,",",".")."</td>
							<td id='7' style='width: 4.5%'>".number_format($superavit,2,",",".")."</td>
							<td id='8' style='width: 4.5%'>".number_format($ingresos_ant,2,",",".")."</td>
							<td id='9' style='width: 4.5%'>".number_format($ingresos_mes,2,",",".")."</td>
							<td id='10' style='width: 4.5%'>".number_format($ingresos_tot,2,",",".")."</td>
							<td id='11' style='width: 4.5%'>".number_format($saldo_ing,2,",",".")."</td>
							<td id='12' style='width: 4.5%'>".$porcentaje."%</td>";
						}
						echo "</tr>";
					}
					else
					{
						echo "<tr style='font-weight:bold; font-size:9px; text-rendering: optimizeLegibility' class='$iter'>";
						if(!empty($_POST[regalias]))
						{
							echo "
							<td id='1' style='width: 5%'>$numeroCuenta</td>
							<td id='2' style='width: 15%'>$nombreCuentaff</td>
							<td id='2' style='width: 15%'>$fuenteCuenta</td>
							<td id='3' style='width: 5.5%'>".number_format($disponibilidad,2,",",".")."</td>
							<td id='3' style='width: 5.5%'>".number_format($presupuestoInicial,2,",",".")."</td>
							<td id='4' style='width: 4.5%'>".number_format($adicion,2,",",".")."</td>
							<td id='5' style='width: 4.5%'>".number_format($reduccion,2,",",".")."</td>
							<td id='6' style='width: 5%'>".number_format($presupuestoDefinitivo,2,",",".")."</td>
							<td id='7' style='width: 4.5%'>".number_format($superavit,2,",",".")."</td>
							<td id='8' style='width: 4.5%'>".number_format($ingresos_ant,2,",",".")."</td>
							<td id='9' style='width: 4.5%'>".number_format($ingresos_mes,2,",",".")."</td>
							<td id='10' style='width: 4.5%'>".number_format($ingresos_tot,2,",",".")."</td>
							<td id='11' style='width: 4.5%'>".number_format($saldo_ing,2,",",".")."</td>
							<td id='12' style='width: 4.5%'>".ROUND(($ingresos_tot/$presupuestoDefinitivo)*100,2)."%</td>";
						}
						else
						{
							echo "
							<td id='1' style='width: 5%'>$numeroCuenta</td>
							<td id='2' style='width: 15%'>$nombreCuentaff</td>
							<td id='2' style='width: 15%'>$fuenteCuenta</td>
							<td id='3' style='width: 5.5%'>".number_format($presupuestoInicial,2,",",".")."</td>
							<td id='4' style='width: 4.5%'>".number_format($adicion,2,",",".")."</td>
							<td id='5' style='width: 4.5%'>".number_format($reduccion,2,",",".")."</td>
							<td id='6' style='width: 5%'>".number_format($presupuestoDefinitivo,2,",",".")."</td>
							<td id='7' style='width: 4.5%'>".number_format($superavit,2,",",".")."</td>
							<td id='8' style='width: 4.5%'>".number_format($ingresos_ant,2,",",".")."</td>
							<td id='9' style='width: 4.5%'>".number_format($ingresos_mes,2,",",".")."</td>
							<td id='10' style='width: 4.5%'>".number_format($ingresos_tot,2,",",".")."</td>
							<td id='11' style='width: 4.5%'>".number_format($saldo_ing,2,",",".")."</td>
							<td id='12' style='width: 4.5%'>".ROUND(($ingresos_tot/$presupuestoDefinitivo)*100,2)."%</td>";
						}
						echo "</tr>";
					}
					fputs($Descriptor2,"D\t".$numeroCuenta."\t".$nombreCuenta."\t".$fuenteCuenta."\t".number_format($presupuestoInicial,2,",",".")."\t".number_format($adicion,2,",",".")."\t".number_format($reduccion,2,",",".")."\t".number_format($presupuestoDefinitivo,2,",",".")."\t".number_format($superavit,2,",",".")."\t".number_format($ingresos_ant,2,",",".")."\t".number_format($ingresos_mes,2,",",".")."\t".number_format($ingresos_tot,2,",",".")."\t".number_format($saldo_ing,2,",",".")."\t".ROUND(($ingresos_tot/$presupuestoDefinitivo)*100,2)."\r\n");
					$inserta="INSERT INTO pptoejecucionpresu_ingresos(cuenta,pptoinicial,adicion,reduccion,pptodefinitivo,supavit,rec_ant, rec_consul,rec_tot,saldo,porc_ejec,unidad,vigencia,nombre) VALUES ('$numeroCuenta',$presupuestoInicial,$adicion,$reduccion, $presupuestoDefinitivo, $superavit,$ingresos_ant,$ingresos_mes,$ingresos_tot,$saldo_ing,".ROUND(($ingresos_tot/$presupuestoDefinitivo)*100,2).",'central', '$_POST[vigencia]','$nombreCuentaff')";
					mysql_query($inserta,$linkbd);
					
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
				}  //----bloque nuevo 17/01/2016
					
					echo "<input type='hidden' name='codcuenta[]' id='codcuenta[]' value='".$numeroCuenta."' />";
					echo "<input type='hidden' name='nomcuenta[]' id='nomcuenta[]' value='".$nombreCuenta."' />";
					echo "<input type='hidden' name='fuente[]' id='fuente[]' value='".$fuenteCuenta."' />";
					echo "<input type='hidden' name='pdcuenta[]' id='pdcuenta[]' value='".$disponibilidad."' />";
					echo "<input type='hidden' name='picuenta[]' id='picuenta[]' value='".round($presupuestoInicial,2)."' />";
					echo "<input type='hidden' name='padcuenta[]' id='padcuenta[]' value='".round($adicion,2)."' />";
					echo "<input type='hidden' name='psvcuenta[]' id='psvcuenta[]' value='".round($superavit,2)."' />";
					echo "<input type='hidden' name='predcuenta[]' id='predcuenta[]' value='".round($reduccion,2)."' />";
					echo "<input type='hidden' name='pdefcuenta[]' id='pdefcuenta[]' value='".round($presupuestoDefinitivo,2)."' />";
					echo "<input type='hidden' name='vantcuenta[]' id='vantcuenta[]' value='".round($ingresos_ant,2)."' />";
					echo "<input type='hidden' name='vmescuenta[]' id='vmescuenta[]' value='".round($ingresos_mes,2)."' />";
					echo "<input type='hidden' name='vtotcuenta[]' id='vtotcuenta[]' value='".round($ingresos_tot,2)."' />";
					echo "<input type='hidden' name='vsalcuenta[]' id='vsalcuenta[]' value='".round($saldo_ing,2)."' />";
					echo "<input type='hidden' name='vporcuenta[]' id='vporcuenta[]' value='".ROUND(($ingresos_tot/$presupuestoDefinitivo)*100,2)."' />";
					echo "<input type='hidden' name='tcodcuenta[]' id='tcodcuenta[]' value='".$tipo."' />";
			
		}
		$result=mysql_query($sqlReporte,$linkbd);
		while ($row =mysql_fetch_assoc($result)) 
		{
			fputs($Descriptor1,$row['CodigoRubro'].",".$row['DescripcionIngreso'].",".$row['AforoInicial'].",".$row['Adiciones'].",".$row['Reduciones'].",".$row['AforoDefinitivo'].",".$row['TotalRecaudado'].",".$row['SaldoPorRecaudar'].",".$row['porcentajeRecaudar']."\r\n");
		}
		fclose($Descriptor1);
		echo "</tbody></table>
		</div>";
		echo "<div class='subpantallac5' style='height:20%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>";
		if(!empty($_POST[regalias])){
			echo "<table class='inicio' align='center' id='valores' >
					<tr><td class='saludo1'>Disponibilidad Inicial</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totDispobilidad)."</td><td class='saludo1'>Presupueso Inicial</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totPresuInicial)."</td><td class='saludo1'>Adiciones</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totAdiciones)."</td><td class='saludo1'>Reducciones</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totReducciones)."</td><td class='saludo1'>Presupuesto Definitivo</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totPresuDefinitivo)."</td></tr><tr><td class='saludo1'>Superavit</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totSuperavit)."</td><td class='saludo1'>Recaudo anterior</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totIngresos_ant)."</td><td class='saludo1'>Recaudo mes</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totIngresos_mes)."</td><td class='saludo1'>Recaudo total</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totIngresos_tot)."</td></tr>
					</table>";
		}else{
			echo "<table class='inicio' align='center' id='valores' >
					<tr><td class='saludo1'>Presupueso Inicial</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totPresuInicial)."</td><td class='saludo1'>Adiciones</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totAdiciones)."</td><td class='saludo1'>Reducciones</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totReducciones)."</td><td class='saludo1'>Presupuesto Definitivo</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totPresuDefinitivo)."</td></tr><tr><td class='saludo1'>Superavit</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totSuperavit)."</td><td class='saludo1'>Recaudo anterior</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totIngresos_ant)."</td><td class='saludo1'>Recaudo mes</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totIngresos_mes)."</td><td class='saludo1'>Recaudo total</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totIngresos_tot)."</td></tr>
					</table>";
		}
				
		echo "</div>";
?> 
	
	<?php
	}
	function generarUnidad($conector,$tabla,$arreglo){
		$resultado="$conector ";
		$tiene=false;
		$unidades="";
		for($i=0;$i<count($arreglo); $i++ ){
			$unidades.=($arreglo[$i]).",";
		}
		$unidades=substr($unidades,0,-1);
		$resultado.="$tabla.unidad IN ($unidades)";
		return $resultado;
	}
		
	function cuentasAux(){
		global $cuentas,$vigencia,$f1,$f2,$cuentaPadre,$cuentaInicial,$cuentaFinal,$vectorDif;
		$linkbd=conectar_bd();	
		$orden='cuenta';
		$buqueda=" ";
		$vectorBusqueda=explode("-",$_POST[filtros]);
		$vectorBusquedaClases=explode("-",$_POST[filtrosclases]);
		$tieneAntes=false;
		if(sizeof($vectorBusqueda)>1){
				if(!$tieneAntes){
					$buqueda.=generarUnidad("AND","pptocuentas",$vectorBusqueda);
				}else{
					$buqueda.=generarUnidad("OR","pptocuentas",$vectorBusqueda);
				}
			}
		
		$tieneAntes=false;
		$regalias="AND pptocuentas.regalias='N' ";
		for($i=0;$i<sizeof($vectorBusquedaClases); $i++){
			if($vectorBusquedaClases[$i]=='11'){
				$regalias="";
				if(!$tieneAntes)
					$buqueda.=" AND (pptocuentas.clasificacion LIKE '%reservas-ingresos%'";
				else
					$buqueda.=" OR pptocuentas.clasificacion LIKE '%reservas-ingresos%'";
			$tieneAntes=true;
			}
			if($vectorBusquedaClases[$i]=='10'){
				$regalias="";
				if(!$tieneAntes)
					$buqueda.=" AND (pptocuentas.clasificacion LIKE '%ingresos%'";
				else
					$buqueda.=" OR pptocuentas.clasificacion LIKE '%ingresos%'";
			$tieneAntes=true;
			}
			if($vectorBusquedaClases[$i]=='12'){
				$regalias="";
				if(!$tieneAntes)
					$buqueda.=" AND (pptocuentas.clasificacion LIKE '%sgr-ingresos%'";
				else
					$buqueda.=" OR pptocuentas.clasificacion LIKE '%sgr-ingresos%'";
			$tieneAntes=true;
			}
	
		}
		if(isset($_POST[regalias])){
			if(!empty($_POST[regalias])){
				$regalias="AND pptocuentas.regalias='S' ";
			}
		}
		$pos=stripos($buqueda,"pptocuentas.clasificacion");
		if($pos!=null){
			$buqueda.=")";
		}
		$tabla2="";
		if(isset($_POST[sectores])){
			if(!empty($_POST[sectores])){
				$buqueda.=" AND pptocuentas_sectores.cuenta=pptocuentas.cuenta AND pptocuentas_sectores.sector LIKE '%$_POST[sectores]%' AND (pptocuentas_sectores.vigenciai=$vigencia OR pptocuentas_sectores.vigenciaf=$vigencia)";
				$tabla2=",pptocuentas_sectores";
			}
		}
		if(isset($_POST[ffunc])){
			if(!empty($_POST[ffunc])){
				$buqueda.="AND (pptocuentas.futfuentefunc=$_POST[ffunc] OR pptocuentas.futfuenteinv=$_POST[ffunc]) ";
			}
		}

		if(empty($cuentaInicial) || empty($cuentaFinal)){
			$sql="SELECT pptocuentas.cuenta,pptocuentas.nombre,pptocuentas.tipo,pptocuentas.futfuentefunc,pptocuentas.futfuenteinv,SUBSTR(pptocuentas.cuenta,1,1) AS c,pptocuentas.regalias,pptocuentas.vigencia,pptocuentas.vigenciaf FROM pptocuentas,pptocuentas_pos $tabla2 WHERE pptocuentas.estado='S' AND pptocuentas.clasificacion LIKE '%ingresos%' AND pptocuentas_pos.cuentapos = pptocuentas.cuenta AND pptocuentas_pos.tipo LIKE '%ingresos%' $regalias AND (pptocuentas.vigencia=$vigencia OR pptocuentas.vigenciaf=$vigencia) AND pptocuentas_pos.vigencia=$vigencia $buqueda ORDER BY pptocuentas_pos.posicion,pptocuentas_pos.cuentapos";
		}else{
			$sql="SELECT pptocuentas.cuenta,pptocuentas.nombre,pptocuentas.tipo,pptocuentas.futfuentefunc,pptocuentas.futfuenteinv,SUBSTR(pptocuentas.cuenta,1,1) AS c,pptocuentas.regalias,pptocuentas.vigencia,pptocuentas.vigenciaf FROM pptocuentas,pptocuentas_pos $tabla2 WHERE pptocuentas.estado='S' AND pptocuentas.clasificacion LIKE '%ingresos%' AND pptocuentas_pos.cuentapos = pptocuentas.cuenta AND pptocuentas_pos.tipo LIKE '%ingresos%' $regalias AND (pptocuentas.vigencia=$vigencia OR pptocuentas.vigenciaf=$vigencia) AND pptocuentas.cuenta between '$cuentaInicial' AND '$cuentaFinal' AND pptocuentas_pos.vigencia=$vigencia $buqueda ORDER BY pptocuentas_pos.posicion,pptocuentas_pos.cuentapos";
		}
		$result=mysql_query($sql,$linkbd);
		$cont=mysql_num_rows($result);

		while($row = mysql_fetch_row($result)){
			if($row[2]=='Auxiliar' || $row[2]=='auxiliar'){
			$arregloCuenta=generaReporteIngresos($row[0],$vigencia,$f1,$f2);
			$cuentas[$row[0]]["numCuenta"]=$row[0];
			$cuentas[$row[0]]["nomCuenta"]=$row[1];
			$cuentas[$row[0]]["disponibilidad"]=$arregloCuenta[8];
			$cuentas[$row[0]]["presuInicial"]=$arregloCuenta[0];
			$cuentas[$row[0]]["fuenCuenta"]=obtenerFuente($row[3],$row[4]);
			$cuentas[$row[0]]["adicion"]=$arregloCuenta[1];
			$cuentas[$row[0]]["reduccion"]=$arregloCuenta[2];
			$cuentas[$row[0]]["presuDefinitivo"]=$arregloCuenta[3];
			$cuentas[$row[0]]["ingreso_ant"]=$arregloCuenta[4];
			$cuentas[$row[0]]["ingreso_mes"]=$arregloCuenta[5];
			$cuentas[$row[0]]["ingreso_tot"]=$arregloCuenta[6];
			$cuentas[$row[0]]["superavit"]=$arregloCuenta[7];
			$cuentas[$row[0]]["saldo_ing"]=$arregloCuenta[3]-$arregloCuenta[6];
			$cuentas[$row[0]]["porcentaje"]=round(($arregloCuenta[6]/$arregloCuenta[3])*100,2);
			$cuentas[$row[0]]["tipo"]="Auxiliar";

			}else{
			
			$cuentas[$row[0]]["numCuenta"]=$row[0];
			$cuentas[$row[0]]["nomCuenta"]=$row[1];
			$cuentas[$row[0]]["presuInicial"]=0;
			$cuentas[$row[0]]["disponibilidad"]=0;
			$cuentas[$row[0]]["fuenCuenta"]=obtenerFuente($row[3],$row[4]);
			$cuentas[$row[0]]["adicion"]=0;
			$cuentas[$row[0]]["reduccion"]=0;
			$cuentas[$row[0]]["presuDefinitivo"]=0;
			$cuentas[$row[0]]["ingreso_ant"]=0;
			$cuentas[$row[0]]["ingreso_mes"]=0;
			$cuentas[$row[0]]["ingreso_tot"]=0;
			$cuentas[$row[0]]["superavit"]=0;
			$cuentas[$row[0]]["saldo_ing"]=0;
			$cuentas[$row[0]]["porcentaje"]=0;
			$cuentas[$row[0]]["tipo"]="Mayor";
			$cuentaPadre[]=$row[0];
			}

		}

		}

			function buscaCuentasHijo($cuenta){
			global $cuentas,$linkbd,$vigencia,$f1,$f2,$cuentaPadre;
			$arreglo=Array('0','1','2','3','4','5','6','7','8','9');
			$numcuenta=strlen($cuenta);
			
			if(($numcuenta==1 || $numcuenta==2) && !is_numeric($cuenta)){
				$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '%$cuenta%' AND estado='S' AND clasificacion  LIKE '%ingresos%' AND (vigencia=$vigencia or vigenciaf=$vigencia) AND (tipo='Auxiliar' OR tipo='auxiliar')";
			}else{
				$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '$cuenta%' AND estado='S' AND clasificacion  LIKE '%ingresos%' AND (vigencia=$vigencia or vigenciaf=$vigencia)  AND (tipo='Auxiliar' OR tipo='auxiliar')";
			}
			$result=mysql_query($sql,$linkbd);
			$acumdisponibilidad=0.0;
			$acumpptoini=0.0;
			$acumadic=0.0;
			$acumredu=0.0;
			$acumpptodef=0.0;
			$acumingreso_ant=0.0;
			$acumingreso_mes=0.0;
			$acumingreso_tot=0.0;
			$acumsuperavit=0.0;
			$acumsaldoingresos=0.0;
			$acumporcentaje=0.0;
			while($row = mysql_fetch_array($result)){
				$acumdisponibilidad+=$cuentas[$row[0]]["disponibilidad"];
				$acumpptoini+=$cuentas[$row[0]]["presuInicial"];
				$acumadic+=$cuentas[$row[0]]["adicion"];
				$acumredu+=$cuentas[$row[0]]["reduccion"];
				$acumpptodef+=$cuentas[$row[0]]["presuDefinitivo"];
				$acumingreso_ant+=$cuentas[$row[0]]["ingreso_ant"];
				$acumingreso_mes+=$cuentas[$row[0]]["ingreso_mes"];
				$acumingreso_tot+=$cuentas[$row[0]]["ingreso_tot"];
				$acumsuperavit+=$cuentas[$row[0]]["superavit"];
				$acumsaldoingresos+=$cuentas[$row[0]]["saldo_ing"];
				$acumporcentaje+=$cuentas[$row[0]]["porcentaje"];
			}
			$cuentas[$cuenta]["disponibilidad"]=$acumdisponibilidad;
			$cuentas[$cuenta]["presuInicial"]=$acumpptoini;
			$cuentas[$cuenta]["adicion"]=$acumadic;
			$cuentas[$cuenta]["reduccion"]=$acumredu;
			$cuentas[$cuenta]["presuDefinitivo"]=$acumpptodef;
			$cuentas[$cuenta]["ingreso_ant"]=$acumingreso_ant;
			$cuentas[$cuenta]["ingreso_mes"]=$acumingreso_mes;
			$cuentas[$cuenta]["ingreso_tot"]=$acumingreso_tot;
			$cuentas[$cuenta]["superavit"]=$acumsuperavit;
			$cuentas[$cuenta]["saldo_ing"]=$acumsaldoingresos;
			$cuentas[$cuenta]["porcentaje"]=$acumporcentaje;

		}		
		function obtenerFuente($fuenFuncion,$fuenInversion){
		global $linkbd;
		$codigo='';
		$nombre='';
		if(!empty($fuenFuncion) && $fuenFuncion!=null){
			$sql="SELECT codigo,nombre FROM pptofutfuentefunc WHERE codigo=$fuenFuncion";
		}else{
			$sql="SELECT codigo,nombre FROM pptofutfuenteinv WHERE codigo=$fuenInversion";
		}
		$result=mysql_query($sql,$linkbd);
		while($row = mysql_fetch_array($result)){
			$codigo = $row[0];
			$nombre = $row[1];
			break;
		}
		return $codigo." - ".$nombre;
		}
		

	?>
	   <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
</form>
<script type="text/javascript">

        	jQuery(function($){
        		if(jQuery){
        				var countChecked = function() {
						  var texto="";
							
						  $("input[name=unidad]").change(function(){
						  		if($(this).attr("class")=="01" && $(this).is(":checked")){
						  		$('input[name=clasifica]').attr("disabled",false);
						  		$('input[name=clasifica]').closest('label').css('color','black');
						  		}else if($(this).attr("class")=="01" && !($(this).is(":checked"))){
						  			if($("input[name=unidad][class=02]").is(":checked") || $("input[name=unidad][class=03]").is(":checked")){
						  				$('input[name=clasifica]').not(document.getElementById( "14" )).attr("disabled",true);
						  				$('input[name=clasifica]').not(document.getElementById( "14" )).closest('label').css('color','#BDBDBD');
						  				
						  			}else{
						  				$('input[name=clasifica]').attr("disabled",true);
						  				$('input[name=clasifica]').closest('label').css('color','#BDBDBD');
						  			}
						  
						  		$('input[name=clasifica]').attr("checked",false);
						  		
						  		}
						  		if($(this).attr("class")=="02" && $(this).is(":checked")){
						  		$('input[name=clasifica][id=14]').attr("disabled",false);
						  		$('input[name=clasifica][id=14]').closest('label').css('color','black');
						  		}else if($(this).attr("class")=="02" && !($(this).is(":checked"))){

						  			if($("input[name=unidad][class=01]").is(":checked") || $("input[name=unidad][class=03]").is(":checked")){
						  				$('input[name=clasifica][id=14]').attr("disabled",false);
						  				$('input[name=clasifica][id=14]').closest('label').css('color','black');
						  				
						  			}else{
						  				$('input[name=clasifica][id=14]').attr("disabled",true);
						  				$('input[name=clasifica][id=14]').closest('label').css('color','#BDBDBD');
						  			}

					
						  		$('input[name=clasifica][id=14]').attr("checked",false);
						  		
						  		}
						  		if($(this).attr("class")=="03" && $(this).is(":checked")){
						  		$('input[name=clasifica][id=14]').attr("disabled",false);
						  		$('input[name=clasifica][id=14]').closest('label').css('color','black');
						  		}else if($(this).attr("class")=="03" && !($(this).is(":checked"))){
						  		if($("input[name=unidad][class=01]").is(":checked") || $("input[name=unidad][class=02]").is(":checked")){
						  				$('input[name=clasifica][id=14]').attr("disabled",false);
						  				$('input[name=clasifica][id=14]').closest('label').css('color','black');
						  				
						  			}else{
						  				$('input[name=clasifica][id=14]').attr("disabled",true);
						  				$('input[name=clasifica][id=14]').closest('label').css('color','#BDBDBD');
						  			}

					
						  		$('input[name=clasifica][id=14]').attr("checked",false);
						  		}
						  });


						  $( "input[name=unidad]:checked" ).each(function(){
						  	texto+=($(this).attr('class'))+"-";

						  });

					

						  if(texto==''){
						  	$( "#texto" ).text("Selecciona...");
						  }else{
						  	$( "#texto" ).text(texto.substring(0,texto.length-1));
						  	$('input[name=filtros]').val(texto.substring(0,texto.length-1));
						  }
						  
						};

						var countChecked1 = function() {
						  var texto="";
						 
						  $( "input[name=clasifica]:checked" ).each(function(){
						  	texto+=($(this).attr('id'))+"-";
						  });
						  if(texto==''){
						  	$( "#texto1" ).text("Selecciona...");
						  }else{
						  	$( "#texto1" ).text(texto.substring(0,texto.length-1));
						  	$('input[name=filtrosclases]').val(texto.substring(0,texto.length-1));
						  	

						  }
						  
						};

						countChecked();
						countChecked1();
        				$( "input[name=unidad][type=checkbox]" ).on( "click", countChecked );
        				$( "input[name=clasifica][type=checkbox]" ).on( "click", countChecked1 );

        				$('#valores tbody tr:first-child td').each(function(index, el) {
        					if($(this).attr('id')=='1'){
        						
        						$('#col1').css('width',$(this).css('width'));


        					}
        					if($(this).attr('id')=='2'){
        					
        						$('#col2').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='3'){
        					
        						$('#col3').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='4'){
        					
        						$('#col4').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='5'){
        					
        						$('#col5').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='6'){
        					
        						$('#col6').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='7'){
        					
        						$('#col7').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='8'){
        					
        						$('#col8').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='9'){
        					
        						$('#col9').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='10'){
        					
        						$('#col10').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='11'){
        					
        						$('#col11').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='12'){
        					
        						$('#col12').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='13'){
        					
        						$('#col13').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='14'){
        					
        						$('#col14').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='15'){
        					
        						$('#col15').css('width',$(this).css('width'));
        					}
        				});
        				
        			}
        		
        	});	
        	
        </script>
        <script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('¿Realmente desea cambiar la vigencia?');
   if(confirma){
    var anobloqueo=bloqueo.split("-");
    var ano=anobloqueo[0];
    if(valor < ano){
      if(confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar")){
        $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
      }else{
        location.reload();
      }

    }else{
      $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
    }
    
   }else{
    location.reload();
   }
   
 });

 function updateresponse(data){
  json=eval(data);
  if(json[0].respuesta=='2'){
    alert("Vigencia modificada con exito");
  }else if(json[0].respuesta=='3'){
    alert("Error al modificar la vigencia");
  }
  location.reload();
 }
 function selectresponse(data){ 
  json=eval(data);
  $('#cambioVigencia').val(json[0].vigencia);
  bloqueo=json[0].bloqueo;
 }

 }); 
</script>
</body>
</html>