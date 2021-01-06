<?php //V 1001 17/12/16 ?>
<?php
require "comun.inc";
require"funciones.inc";
$linkbd=conectar_bd();
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: SPID</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script >
			function ponprefijo(pref,opc)
			{   
				parent.document.form2.placa.value =pref;
				parent.document.form2.serbus.value =opc;
				parent.despliegamodal2("hidden");
			} 
			function validar(){document.form1.submit();}
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<form action="" method="post" enctype="multipart/form-data" name="form1">
			<table  class="inicio" align="center" >
				<tr>
					<td height="25" colspan="4" class="titulos" >Buscar Activo Fijo </td>
					<td class="cerrar"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Placa:</td>
					<td style="width:40%">
						<input type="text" id="placa" name="placa" onKeyUp="return tabular(event,this)"  style="width:90%;" value="<?php echo $_POST[placa]?>">
					</td>
					<td class="saludo1" style="width:10%">Origen:</td>
					<td style="width:40%">
						<select id="origen" name="origen" onChange="validar()" style="width:90%">
							<option value="">...</option>
							<?php
							$sqlr="Select * from almdestinocompra where estado='S' and (codigo>'01' and codigo<'05')";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value='A-".$row[0]."'";
								$i="A-".$row[0];
								if($i==$_POST[origen])
								{
									echo "SELECTED";
								}
								echo ">A-".$row[0].' - '.$row[1]."</option>";	  
							}
							$sqlr="Select * from actiorigenes where estado='S'";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value='F-".$row[0]."'";
								$i="F-".$row[0];
								if($i==$_POST[origen])
								{
									echo "SELECTED";
								}
								echo ">F-".$row[0].' - '.$row[1]."</option>";	  
							}		
							?>
						</select>
						<input name="oculto" type="hidden" id="oculto" value="1" >
					</td>
			    </tr>
				<tr>
					<td class="saludo1" style="width:10%">Clase:</td>
					<td style="width:40%">
						<select id="clasificacion" name="clasificacion" onChange="validar()" style="width:90%">
							<option value="">...</option>
							<?php
							$sqlr="SELECT * from acti_clase where estado='S'";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[clasificacion])
								{
									echo "SELECTED";
									$_POST[agedep]=$row[3];
								}
								echo ">".$row[0].' - '.$row[1]."</option>";	  
							}
							?>
						</select>
					</td>    
					<td class="saludo1">Grupo:</td>
					<td>
						<select id="grupo" name="grupo" onChange="validar()" style="width:90%">
							<option value="">...</option>
							<?php
							$sqlr="SELECT * from acti_grupo where estado='S' and id_clase='$_POST[clasificacion]'";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[grupo])
								{
									echo "SELECTED";
								}
								echo ">".$row[0].' - '.$row[2]."</option>";	  
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Tipo:</td>
					<td style="width:40%">
						<select id="tipo" name="tipo" onChange="validar()" style="width:90%">
							<option value="">...</option>
							<?php
							$sqlr="SELECT * from acti_tipo_cab where estado='S'";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[tipo])
								{
									echo "SELECTED";
								}
								echo ">".$row[0].' - '.$row[1]."</option>";	  
							}
							?>
						</select>
					</td>    
					<td class="saludo1">Prototipo:</td>
					<td>
						<select id="prototipo" name="prototipo" onChange="validar()" style="width:90%">
							<option value="">...</option>
							<?php
							$sqlr="SELECT * from acti_prototipo where estado='S'";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[prototipo])
								{
									echo "SELECTED";
								}
								echo ">".$row[0].' - '.$row[1]."</option>";	  
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Nombre:</td>
					<td style="width:40%">
						<input type="text" id="nombre" name="nombre" onKeyUp="return tabular(event,this)"  style="width:90%; text-transform:uppercase;" value="<?php echo $_POST[nombre]?>">
					</td>
					<td class="saludo1" style="width:10%">Ref:</td>
					<td style="width:40%">
						<input type="text" id="referencia" name="referencia" onKeyUp="return tabular(event,this)" style="width:90%" value="<?php echo $_POST[referencia]?>">
					</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Modelo:</td>
					<td style="width:40%">
						<input type="text" id="modelo" name="modelo" onKeyUp="return tabular(event,this)" style="width:90%" value="<?php echo $_POST[modelo]?>">
					</td>
					<td class="saludo1" style="width:10%">Serial:</td>
					<td style="width:40%">
						<input type="text" id="serial" name="serial" onKeyUp="return tabular(event,this)" style="width:70%" value="<?php echo $_POST[serial]?>">
						<input type="submit" name="Submit" value="Buscar" >
					</td>
				</tr>
			</table>
			<div class="subpantalla" style="height:78.5%; width:99.6%; overflow-x:hidden;">
				<table class="inicio">
					<tr>
						<td height="25" colspan="5" class="titulos" >Resultados Busqueda </td>
					</tr>
					<td style='width:4%' class="titulos2" >Item</td>
					<td style='width:15%' class="titulos2" >Placa</td>
					<td style='width:30%' class="titulos2" >Nombre</td>
					<td style='width:15%' class="titulos2">Modelo</td>
					<td style='width:18%' class="titulos2" >Referencia</td>	  	  
					<td style='width:18%' class="titulos2" >Serial</td>	  	  
					<?php
					$crit1=" "; $crit2=" "; $crit3=" "; $crit4=" "; $crit5=" "; $crit6=" "; $crit7=" "; $crit8=" "; $crit9=" "; $crit10=" ";
					if($_POST[placa]!="")$crit1="AND placa='$_POST[placa]'";
					if($_POST[origen]!="")$crit2="AND origen='$_POST[origen]'";
					if($_POST[clasificacion]!="")$crit3="AND clasificacion='$_POST[clasificacion]'";
					if($_POST[grupo]!="")$crit4="AND grupo='$_POST[grupo]'";
					if($_POST[tipo]!="")$crit5="AND tipo='$_POST[tipo]'";
					if($_POST[prototipo]!="")$crit6="AND prototipo='$_POST[prototipo]'";
					if($_POST[nombre]!="")$crit7="AND nombre='$_POST[nombre]'";
					if($_POST[modelo]!="")$crit7="AND modelo='$_POST[modelo]'";
					if($_POST[referencia]!="")$crit7="AND referencia='$_POST[referencia]'";
					if($_POST[serial]!="")$crit7="AND serial='$_POST[serial]'";
					$sqlr="SELECT * FROM acticrearact_det WHERE estado='S' $crit1 $crit2 $crit3 $crit4 $crit5 $crit6 $crit7 $crit8 $crit9 $crit10 ORDER BY placa";
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$i=1;
					$co='saludo1a';
					$co2='saludo2';	
					while ($r =mysql_fetch_row($resp)) 
					{			
						echo"<tr class='$co' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" onClick=\"javascript:ponprefijo('$r[1]','$r[5]')\">"; 
							echo "<td>$i</td>
							<td style='text-align:center;'>$r[1]</td>
							<td>$r[2]</td>
							<td style='text-align:center;'>$r[4]</td>
							<td style='text-align:center;'>$r[3]</td>
							<td style='text-align:center;'>$r[5]</td>
						</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
						$i=1+$i;
					}
					?>
				</table>
			</div>
		</form>
	</body>
</html>