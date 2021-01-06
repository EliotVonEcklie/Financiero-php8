<?php
	require "comun.inc";
	require"funciones.inc";
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
		<title>:: SieS</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script> 
			function guardar()
			{
				document.form2.oculto.value=2;
				document.form2.submit();
			}
			function limpiar()
			{
				document.form2.oculto.value=3;
				document.form2.submit();
			}			
			function funcionmensaje()
			{
				alert("Se almaceno con exito");
				document.form2.submit();
			}
			function funcionmensaje2()
			{
				alert("Se actualizo con exito");
				document.form2.submit();
			}
			function funcionmensaje1()
			{
				alert("Se elimino con exito");
				document.form2.submit();
			}
		</script> 
		<?php titlepag();?>
	</head>
	<body >
  	<form action="" method="post" name="form2">
	<input type="hidden" name="oculto" id="oculto" value="1"/>
	<input type="hidden" name="guardo" id="guardo" value="1"/>
		<?php 
		$linkbd=conectar_bd();	
		$_POST[periodo]=$_GET[periodo1];
		$num_cuenta=$_GET[cuenta];
		$saldo=$_GET[saldo];
		$saldo1=round($saldo,2);
		$vigencia=vigencia_usuarios($_SESSION[cedulausu]);
		$sql="SELECT notas FROM conta_notas WHERE vigencia='$vigencia' AND cuenta='$num_cuenta' AND periodo='$_POST[periodo]'";
		$resp=mysql_query($sql,$linkbd);
		$row=mysql_fetch_row($resp);
		$_POST[nota1]=$row[0];
		
		//$_POST[guardo]=1;
		
		?>
		<table  class="inicio" style="width:99.4%;">
  			<tr >
    			<td class="titulos" colspan="2">:. Notas Contabilidad</td>
				<td style="width:7%" class="cerrar" ><a onClick="parent.despliegamodal2('hidden');" style="cursor:pointer;">Cerrar</a></td>
			</tr>
      	</table> 
		<div class="subpantalla" style="height:86%; width:99%; overflow-x:hidden;">
			<table>
				<tr >
					<td style="width:4.5cm" class="saludo1">:. Nota:</td>
				</tr>
				<tr>
					<td>
						
						<?php echo "<textarea name='texta' id='texta' rows='24' cols='120' >$_POST[nota1]</textarea>";?>
						<input type="hidden" name="nota1" id="nota1" value="<?php echo $_POST[nota1]?>">
						
					</td>
				</tr>
				<tr>
					<td><input type="button" value="Guardar" onClick="guardar()">
					<input type="button" value="Limpiar" onClick="limpiar()">
					<?php
						if($_POST[guardo]=='3')
							echo "Se almaceno la nota con exito";
					?>
					
					</td>
					
				</tr>
				
			</table>
			
		</div>
		<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		<?php
		if($_POST[oculto]=='2'){
			$sqlr1="SELECT *FROM conta_notas WHERE vigencia='$vigencia' AND cuenta='$num_cuenta' AND periodo='$_POST[periodo]'";
			$res1=mysql_query($sqlr1,$linkbd);
			$row1=mysql_fetch_row($res1);
			if($row1[0]!='')
			{
				$sqlr="UPDATE conta_notas SET notas='$_POST[texta]', saldofinal='".$saldo1."' WHERE vigencia='$vigencia' AND cuenta='$num_cuenta' AND periodo='$_POST[periodo]'";
				mysql_query($sqlr,$linkbd);
				echo "<script> funcionmensaje2();</script>";
			}
			else
			{
				if($_POST[texta]!='')
				{
					$date=getdate();
					$h=$date["hours"];
					$min=$date["minutes"];
					$dia=$date["mday"];
					$mes=$date["mon"];
					$ano=$date["year"];
					$hora=$h.":".$min;
					$fechaf=$ano."-".$mes."-".$dia;
					
					$sqlr="insert into conta_notas (hora,fecha,usuario,modulo,vigencia,periodo,cuenta,notas,saldofinal) values('$hora','$fechaf','".$_SESSION["usuario"]."','conta','$vigencia','$_POST[periodo]','$num_cuenta','$_POST[texta]','".$saldo1."')";
					mysql_query($sqlr,$linkbd);
					echo "<script> funcionmensaje();</script>";
				}
			}
			
			
		}
		if($_POST[oculto]=='3'){
			$sqlr="delete from conta_notas where vigencia='$vigencia' AND cuenta='$num_cuenta' AND periodo='$_POST[periodo]' AND modulo='conta'";
			mysql_query($sqlr,$linkbd);
			echo "<script> funcionmensaje1();</script>";
		}
		
		
		
		?>
</form>
</body>
</html>
