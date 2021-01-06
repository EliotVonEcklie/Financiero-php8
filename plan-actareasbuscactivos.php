<?php //V 1000 12/12/16 ?> 
<?php 
require"comun.inc";
require"funciones.inc";
session_start();

//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="css/programas.js"></script>
     <script>function funbuscar(){document.form2.submit();}</script>
    <?php titlepag();?>
</head>
<body>
	<form name="form2" method="post" action="plan-actareasbuscactivos.php" >
	<table  class="inicio" align="center" >
		<tr>
        	<td class="titulos" colspan="5">:: Buscar Tareas Activas </td>
      	</tr>
      	<tr>
            <td style="width:5%" class="saludo1">Proceso:</td>
            <td style="width:30%" colspan="2"><input name="nombre" type="text" value="" size="40"></td>
            <td style="width:13%" class="saludo1">C&oacute;digo SPID:</td>
            <td style="width:43%"><input name="documento" type="text" id="documento" value=""  maxlength="16"></td>
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

		
			$linkbd=conectar_bd();
		 	$crit1=" ";
			$crit2=" ";
			if ($_POST[nombre]!="")
			{
				$sqlr2="SELECT id FROM calprocesos WHERE nombre LIKE '%".$_POST[nombre]."%'";
				$res2=mysql_query($sqlr2,$linkbd);
				$row2 = mysql_fetch_row($res2);
				$proceso=$row2[0];
				$crit1=" AND (cgd.proceso='".$proceso."') ";
			}
			if ($_POST[documento]!="")
			$crit2=" AND cgd.codigospid LIKE '%$_POST[documento]%' ";
           	$sqlr="SELECT res.*,rad.numeror,rad.fechalimite,rad.descripcionr,rad.codigobarras FROM planacresponsables res, planacradicacion rad WHERE res.codradicacion=codigobarras AND res.estado='A' AND res.usuariocon='".$_SESSION[cedulausu]."'".$crit1.$crit2."  ORDER BY codigo ASC";
			$res=mysql_query($sqlr,$linkbd);
           	$iter='saludo1';
      		$iter2='saludo2';
			$ntr = mysql_num_rows($res);
			echo'
				<table class="inicio">        
                	<tr>
                    	<td class="titulos" colspan="6">::Lista de Tareas Activas</td>
                    </tr>
					<tr>
						<td colspan="7">Encontrados:'.$ntr.'</td>
					</tr>
                    <tr>
                        <td class="titulos2" style="width:7%" >Radicaci&oacute;n</td>
                        <td class="titulos2" style="width:10%">Fecha Asignaci&oacute;n</td>
						<td class="titulos2" style="width:10%" >Fecha L&iacute;mite</td>
                        <td class="titulos2" style="width:25%">Asignado por</td>
                        <td class="titulos2" >Descripci&oacute;n</td>
                        <td class="titulos2" style="width:7%">Responder</td>
                     </tr>';
            while ($row = mysql_fetch_row($res)) 
       		{
				$nresul=buscaresponsable($row[4]);
    			echo '
				<tr class="'.$iter.'" >
					<td >'.$row[12].'</td>
					<td>'.$row[2].'</td>
					<td>'.$row[10].'</td>
					<td>'.$nresul.'</td>';
					$mitr=$row[0]-1;
				$sqlr3="SELECT respuesta FROM planacresponsables WHERE codigo='".$mitr."'";
				$res3=mysql_query($sqlr3,$linkbd);
				$row3 = mysql_fetch_row($res3);
				if(($row3[0]=="")or($row3[0]==NULL)){echo'<td>'.strtoupper($row[11]).'</td>';}
				else{echo'<td>'.strtoupper($row3[0]).'</td>';}
				$pagina="plan-actareasresponder.php?idradicado=".$row[9]."&idresponsable=".$row[0];
				echo'
					<td align="middle"><a href="#"><img src="imagenes/b_edit.png" onClick="parent.cargarpagina(\''.$pagina.'\');" /></a></td>
				</tr>';
          		$aux=$iter;
     			$iter=$iter2;
        		$iter2=$aux;
          	}
		
		echo '</table>';
		?>
	</div>
    </form>
</body>
</html>