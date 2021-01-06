<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid -  Administracion</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<script src="css/calendario.js"></script>
		<script language="javascript">
			var anterior;
			function ponprefijo(pref,opc)
			{ 
					parent.document.form2.responsable.value =pref;
					parent.document.form2.nresponsable.value =opc;
					parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
  		<form action="" method="post" enctype="multipart/form-data" name="form1">
  			<?php if ($_POST[oculto]==""){$_POST[oculid]=$_GET[id];$_POST[oculto]="0"; $_POST[ocupro]=$_GET[pro];}?>
			<table  class="inicio" align="center" >
      			<tr>
       	 			<td class="titulos" colspan="6">:: Buscar Responsable</td>
      			</tr>
      			<tr>
        			<td class="saludo1">Nombre o apellidos:</td>
        			<td><input name="nombre" type="text" value="" size="40"></td>
        			<td class="saludo1">Documento: </td>
        			<td><input name="documento" type="text" id="documento" value=""></td>
                    <td><input type="submit" name="Submit" value="Buscar" ></td>
      	 		</tr>                       
    		</table> 
      		<?php
				$crit1=" ";
				$crit2=" ";
				if ($_POST[nombre]!=""){$crit1=" AND (t.nombre1 like '%".$_POST[nombre]."%' OR t.nombre2 like '%".$_POST[nombre]."%' OR t.apellido1 like '%".$_POST[nombre]."%' OR t.apellido2 like '%".$_POST[nombre]."%' ) ";}
				if ($_POST[documento]!=""){$crit2=" AND t.cedulanit like '%$_POST[documento]%' ";}
				$sqlr="SELECT t.*, pl.*, pt.* FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.estado='S' AND pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo".$crit1.$crit2." order by t.apellido1, t.apellido2, t.nombre1, t.nombre2";
				$resp = mysql_query($sqlr,$linkbd);
				$ntr = mysql_num_rows($resp);
				$con=1;
				echo "
					<table class='inicio' align='center' width='99%'>
						<tr>
							<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
						</tr>
						<tr>
							<td colspan='8'>Terceros Encontrados: $ntr</td>
						</tr>
						<tr>
							<td class='titulos2' width='2%'>Item</td>
							<td class='titulos2' width='30%'>CARGO</td>
							<td class='titulos2' width='10%'>PRIMER APELLIDO</td>
							<td class='titulos2' width='10%'>SEGUNDO APELLIDO</td>
							<td class='titulos2' width='10%'>PRIMER NOMBRE</td>
							<td class='titulos2' width='10%'>SEGUNDO NOMBRE</td>
							<td class='titulos2' width='4%'>DOCUMENTO</td>
							<td class='titulos2' width='4%'>EST</td>
						</tr>";	
				$iter='saludo1';
				$iter2='saludo2';
 				while ($row =mysql_fetch_row($resp)) 
 				{
   					if ($row[11]=='31'){$ntercero=$row[5];}
   					else{$ntercero=$row[3].' '.$row[4].' '.$row[1].' '.$row[2];}
					if($_POST[ocupro]=="L")
					{ 
						$sqlid="SELECT * FROM planacresponsables WHERE codradicacion='$_POST[oculid]' AND usuariocon='$row[12]' AND estado <> 'LN' AND estado <> 'LS'";
					}
					else
					{$sqlid="SELECT * FROM planacresponsables WHERE codradicacion='$_POST[oculid]' AND usuariocon='$row[12]'";}
					
					$resid=mysql_query($sqlid,$linkbd);
					if (mysql_num_rows($resid)>0)
					{echo"<tr>";$imgtip='<img src="imagenes/confirmd.png" style="height:20px;" title="No disponible">';}
					else
					{echo"<tr onClick=\"javascript:ponprefijo('$row[12]','$ntercero')\">";$imgtip='<img src="imagenes/confirm.png" style="height:20px;" title="Disponible">';}
					
					echo"
						<td class='$iter'>$con</td>
						<td class='$iter'>".strtoupper($row[24])."</td>
						<td class='$iter'>".strtoupper($row[3])."</td>
						<td class='$iter'>".strtoupper($row[4])."</td>
						<td class='$iter'>".strtoupper($row[1])."</td>
						<td class='$iter'>".strtoupper($row[2])."</td>
						<td class='$iter'>$row[12]</td>
						<td class='$iter'>".$imgtip."</td>
					</tr>";
					$con+=1;
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
 				}
				echo"</table>";
			?>
            <input type="hidden" name="oculto" value="<?php echo $_POST[oculto];?> ">
 			<input type="hidden" name="oculid" value="<?php echo $_POST[oculid];?> ">
            <input type="hidden" name="ocupro" value="<?php echo $_POST[ocupro];?> ">
		</form>
	</body>
</html>
