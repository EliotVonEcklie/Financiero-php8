<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();

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
     <script>function funbuscar(){document.form2.submit();}</script>
    <?php titlepag();?>
</head>
<body>
	<form name="form2" method="post" action="plan-actareasbuscacumplidos.php" >
	<table  class="inicio" align="center" >
		<tr>
        	<td class="titulos" colspan="7">:: Buscar Eventos Cumplidos</td>
      	</tr>
      	<tr>
            <td style="width:5%" class="saludo1">Evento:</td>
            <td style="width:20%" colspan="2"><input name="cevento" type="text" value="" style="width:90%"></td>
            <td style="width:5%" class="saludo1">Descripci&oacute;n:</td>
            <td style="width:20%"><input name="cdescripcio" type="text" id="cdescripcio" value="" style="width:90%" ></td>
            <td style="width:5%" class="saludo1">Prioridad:</td>
            <td style="width:20%"><input name="cprioridad" type="text" id="cprioridad" value="" style="width:90%" ></td>
       	</tr>                       
    </table>
	<input name="oculto" type="hidden" value="1">
    <input name="iddel" id="iddel" type="hidden" value="<?php echo $_POST[iddel]?>">
    <input name="ocudel" id="ocudel" type="hidden" value="<?php echo $_POST[ocudel]?>">
    <input name="archdel" id="archdel" type="hidden" value="<?php echo $_POST[archdel]?>">
    <input name="nomdel" id="nomdel" type="hidden" value="<?php echo $_POST[nomdel]?>">
    <input name="idclase" id="idclase" type="hidden" value="<?php echo $_POST[idclase]?>">
    <input name="ocudelplan" id="ocudelplan" type="hidden" value="<?php echo $_POST[ocudelplan]?>">
    <input name="contador" id="contador" type="hidden" value="<?php echo $_POST[contador]?>">
    <div class="subpantallac5" style="height:86%; overflow-x:hidden;">
		<?php
		$oculto=$_POST['oculto'];
		if($_POST[oculto])
		{
			$linkbd=conectar_bd();
		 	$crit1=" ";
			$crit2=" ";
			$crit3=" ";
			$hoy=date('Y-m-d');
			if ($_POST[cevento]!="")
			{
				$crit1="AND evento= ANY (SELECT valor_inicial FROM dominios WHERE nombre_dominio='TIPO_EVENTO_AG' AND descripcion_valor LIKE '%".$_POST[cevento]."%')";
			}
			if ($_POST[cdescripcio]!=""){$crit2=" AND descripcion LIKE '%$_POST[cdescripcio]%' ";}
			if ($_POST[cprioridad]!="")
			{
				$crit3="AND prioridad= ANY (SELECT valor_inicial FROM dominios WHERE nombre_dominio='PRIORIDAD_EVENTOS_AG' AND descripcion_valor LIKE '%".$_POST[cprioridad]."%')";
			}
           	$sqlr="SELECT fechaevento,horainicial,horafinal,evento,descripcion,prioridad,tiempoalerta,frecuencia FROM agenda WHERE usrecibe='".$_SESSION[cedulausu]."' AND estado='C' ".$crit1.$crit2.$crit3." ORDER BY fechaevento ASC";
			$res=mysql_query($sqlr,$linkbd);
           	$iter='saludo1';
      		$iter2='saludo2';
			$ntr = mysql_num_rows($res);
			$con=1;
			echo'
				<table class="inicio">        
                	<tr>
                    	<td class="titulos" colspan="12">::Lista de Tareas Activas</td>
                    </tr>
					<tr>
						<td colspan="12">Encontrados:'.$ntr.'</td>
					</tr>
                    <tr>
                        <td class="titulos2" style="width:4%" rowspan="2">Item</td>
                        <td class="titulos2" style="width:8%" rowspan="2">Fecha Evento</td>
						<td class="titulos2" style="width:10%" colspan="2" align="middle">Hora Evento</td>
                        <td class="titulos2" style="width:20%" rowspan="2">Nombre Evento</td>
                        <td class="titulos2" style="width:25%"rowspan="2">Descripci&oacute;n</td>
						<td class="titulos2" rowspan="2" colspan="2">Prioridad</td>
						<td class="titulos2" colspan="2" align="middle">Recordar Desde</td>
						<td class="titulos2" colspan="2" align="middle">Frecuencia</td>
						<td class="titulos2" style="width:4%" rowspan="2">Mirar</td>
                     </tr>
					 <tr>
						<td class="titulos2" style="width:5%">Inicial</td>
						<td class="titulos2" style="width:5%">Final</td>
						<td class="titulos2">Meses</td>
						<td class="titulos2">Dias</td>
						<td class="titulos2">Horas</td>
						<td class="titulos2">Minutos</td>
					</tr>';
            while ($row = mysql_fetch_row($res)) 
       		{
				$desde=explode(":",$row[6]);
				$frecuencia=explode(":",$row[7]);
				$sqlr2="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPO_EVENTO_AG' AND valor_inicial='".$row[3]."'";
                $res2=mysql_query($sqlr2,$linkbd);
                $row2=mysql_fetch_row($res2); 
				$sqlr3="SELECT descripcion_valor,valor_final FROM dominios WHERE nombre_dominio='PRIORIDAD_EVENTOS_AG' AND valor_inicial='".$row[5]."'";
				$res3=mysql_query($sqlr3,$linkbd);
				$row3=mysql_fetch_row($res3);
    			echo '
				<tr class="'.$iter.'" >
					<td >'.$con.'</td>
					<td>'.$row[0].'</td>
					<td>'.$row[1].'</td>
					<td>'.$row[2].'</td>
					<td>'.$row2[0].'</td>
					<td>'.$row[4].'</td>
					<td>'.$row3[0].'</td>
					<td bgcolor="'.$row3[1].'">&nbsp;&nbsp;</td>
					<td align="middle">'.$desde[0].'</td>
					<td align="middle">'.$desde[1].'</td>
					<td align="middle">'.$frecuencia[0].'</td>
					<td align="middle">'.$frecuencia[1].'</td>
					<td align="middle"><a href="#"><img src="imagenes/buscarep.png" onClick="mypop=window.open(\'plan-agenda.php?pagini=principal.php&fechamen='.$row[0].'\',\'\',\'\');mypop.focus();" /></a></td>
				</tr>';
				$con++;
          		$aux=$iter;
     			$iter=$iter2;
        		$iter2=$aux;
          	}
		}
		echo '</table>';
		?>
	</div>
    </form>
</body>
</html>