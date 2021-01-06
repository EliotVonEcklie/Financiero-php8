<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="css/programas.js"></script>
    <script>
   	 	function despliegamodal2(_valor)
		{
			document.getElementById("bgventanamodal2").style.visibility=_valor;
			if (_valor=="hidden"){document.getElementById('todastablas1').innerHTML=""}
		}
		function actualizar(idact)
		{
			despliegamodal2("hidden");
			var winat="actualizar";
			var pagaux='calendario1/malertas-actualizar.php?idact='+idact;
			document.getElementById('todastablas1').innerHTML='<div id="bgventanamodal2"><div id="ventanamodal2"><IFRAME  src="'+pagaux+'" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME></div></div>';
			despliegamodal2('visible');
		}
		function mirar_men(idalerta)
		{
			var winat="alertan";
			var pagaux='calendario1/malertas-mirar.php?idalerta='+idalerta;
			parent.document.getElementById('todastablas1').innerHTML='<div id="bgventanamodal2"><div id="ventanamodal2"><IFRAME  src="'+pagaux+'" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME></div></div>';
			parent.despliegamodal2('visible');
		}    
		function cancelar_men(idalerta)
		{
			if (confirm("Desea marcar como Cumplido este Recordatorio"))
			{
				document.getElementById('iddmod').value=idalerta;
				document.getElementById('ocumod').value="1";
				document.form1.submit();
			}
		}	
		function eliminar_men(idalerta)
		{
			if (confirm("Desea Eliminar este Recordatorio"))
			{
				document.getElementById('iddmod').value=idalerta;
				document.getElementById('ocumod').value="2";
				document.form1.submit();
			}
		}
    </script>
    <?php titlepag();?>
</head>
<body>
	
	<?php $_POST[idrecordatorios]=$_GET[contenido];?>
	<span id="todastablas1"></span>
	<table>
		<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("plan");?></tr>
        <tr>
  			<td colspan="3" class="cinta">
            	<a href="#" ><img src="imagenes/add2.png"  alt="Nuevo" border="0" /></a> 
            	<a href="#"><img src="imagenes/guardad.png"  alt="Guardar" /></a> 
                <a href="#" id="botbuscar"><img src="imagenes/buscad.png"/></a> 
                <a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>
   			</td>
		</tr>
	</table>	
	<form name="form1" method="post" action="plan-alerecordatorios.php?contenido=<?php echo $_POST[idrecordatorios];?>" >
    <input name="oculto" type="hidden" value="1">
    <input name="idrecordatorios" id="idrecordatorios" type="hidden" value="<?php echo $_POST[idrecordatorios]?>">
   <input name="iddmod" id="iddmod" type="hidden" value="<?php echo $_POST[iddmod]?>">
    <input name="ocumod" id="ocumod" type="hidden" value="<?php echo $_POST[ocumod]?>">
   	<div class="subpantallac5" style="height:76%; overflow-x:hidden;">
		<?php
			if($_POST[ocumod]=='1')
			{
				$linkbd=conectar_bd();
				$sqlr = "UPDATE alertasdiarias SET estado='C' WHERE codigo='$_POST[iddmod]' ";
				mysql_query($sqlr,$linkbd);
				?><script>alert("El Recordatorio se Marco como Cumplido ");document.form2.ocumod.value="0";</script><?php
			}
			if($_POST[ocumod]=='2')
			{
				$linkbd=conectar_bd();
				$sqlr = "DELETE FROM alertasdiarias WHERE codigo='$_POST[iddmod]' ";
				mysql_query($sqlr,$linkbd);
				?><script>alert("Se Elimino el El Recordatorio");document.form2.ocumod.value="0";</script><?php
			}			
			//if($_POST[oculto])
			{
			$linkbd=conectar_bd();
			$hoy=date('Y-m-d');
           	$iter='saludo1';
      		$iter2='saludo2';
			$con=1;$conid=0;
			$idrecordatorios=explode("-",$_POST[idrecordatorios]);
			echo'
				<table class="inicio">        
                	<tr>
                    	<td class="titulos" colspan="9">::Lista de Recordatorios Activos</td>
						<td width="5%" class="cerrar" ><a href="#" onClick="window.close();">Cerrar</a></td>
                    </tr>
                    <tr>
                        <td class="titulos2" style="width:4%" rowspan="2">Item</td>
                        <td class="titulos2" style="width:8%" rowspan="2">Fecha</td>
                        <td class="titulos2" style="width:25%" rowspan="2">Descripci&oacute;n</td>
						<td class="titulos2" colspan="2" align="middle">Recordar Desde</td>
						<td class="titulos2" colspan="2" align="middle">Frecuencia</td>
						<td class="titulos2" style="width:6%" rowspan="2"  align="middle">Mirar</td>
						<td class="titulos2" style="width:6%" rowspan="2"  align="middle">Marcar Cumplido</td>
						<td class="titulos2" style="width:6%" rowspan="2"  align="middle">Eliminar</td>
                     </tr>
					 <tr>
						<td class="titulos2">Fecha</td>
						<td class="titulos2">Hora</td>
						<td class="titulos2">Horas</td>
						<td class="titulos2">Minutos</td>
					</tr>';	
			$conid=0;
            while ($idrecordatorios[$conid]!="") 
       		{
				$sqlr="SELECT * FROM alertasdiarias WHERE codigo='$idrecordatorios[$conid]' AND estado='A' ";
				$res=mysql_query($sqlr,$linkbd);
				$row = mysql_fetch_row($res);
				if ($row[0]!="")
				{
					$desde=explode(" ",$row[3]);
					$frecuencia=explode(":",$row[4]);
					echo '
					<tr class="'.$iter.'">
						<td>'.$con.'</td>
						<td>'.$row[2].'</td>
						<td>'.$row[5].'</td>
						<td align="middle">'.$desde[0].'</td>
						<td align="middle">'.$desde[1].'</td>
						<td align="middle">'.$frecuencia[0].'</td>
						<td align="middle">'.$frecuencia[1].'</td>
						<td align="middle"><a href="#"><img src="imagenes/buscarep.png" onClick="mirar_men(\''.$row[0].'\');"/></a></td>
						<td align="middle"><a href="#"><img src="imagenes/confirm.png" onClick="cancelar_men(\''.$row[0].'\');"></a></td>
						<td align="middle"><a href="#"><img src="imagenes/del.png" onClick="eliminar_men(\''.$row[0].'\');"></a></td>
					</tr>';
					$con++;
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
				}
				$conid=$conid+1;
          	}
		}
		echo '</table>';
		?>
	</div>
     
    </form>
   
</body>
</html>