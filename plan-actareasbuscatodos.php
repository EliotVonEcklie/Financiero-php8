<?php //V 1000 12/12/16 ?> 
<?php 
require"comun.inc";
require"funciones.inc";
session_start();
$linkbd=conectar_bd();
header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
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
	<form name="form2" method="post" action="plan-actareasbuscatodos.php" >
	<table  class="inicio" align="center" >
		<tr>
        	<td class="titulos" colspan="5">:: Buscar Tareas </td>
      	</tr>
      	<tr>
            <td style="width:5%" class="saludo1">Radicaci&oacute;n:</td>
            <td style="width:15%"><input name="nradicacion" id="nradicacion" type="text" value="" onKeyPress="return solonumeros(event);"style="width:95%" onBlur="funbuscar()"></td>
            <td style="width:13%" class="saludo1">C&oacute;digo SPID:</td>
            <td style="width:43%"><input name="documento" type="text" id="documento" value=""  maxlength="16"></td>
       	</tr>                       
    </table>
    <div class="subpantallac5" style="height:86%; overflow-x:hidden;">
		<?php
		 	$crit1="";
			$crit2="";
			if ($_POST[nradicacion]!=""){$crit1="AND rad.codigobarras like'%$_POST[nradicacion]%' ";}
			if ($_POST[documento]!="")
			$crit2="  ";
           	$sqlr="SELECT res.*,rad.numeror,rad.fechalimite,rad.descripcionr,rad.codigobarras,rad.estado FROM planacresponsables res, planacradicacion rad WHERE res.codradicacion=codigobarras AND res.usuariocon='".$_SESSION[cedulausu]."'".$crit1.$crit2."  ORDER BY res.codigo ASC";
			$res=mysql_query($sqlr,$linkbd);
           	$iter='saludo1';
      		$iter2='saludo2';
			$ntr = mysql_num_rows($res);
			echo'
				<table class="inicio">        
                	<tr>
                    	<td class="titulos" colspan="8">::Lista de Tareas</td>
                    </tr>
					<tr>
						<td colspan="8">Encontrados:'.$ntr.'</td>
					</tr>
                    <tr>
                        <td class="titulos2" style="width:7%" >Radicaci&oacute;n</td>
                        <td class="titulos2" style="width:10%">Fecha Asignaci&oacute;n</td>
						<td class="titulos2" style="width:10%" >Fecha L&iacute;mite</td>
                        <td class="titulos2" style="width:25%">Asignado por</td>
                        <td class="titulos2" >Descripci&oacute;n</td>
						<td class="titulos2" style="width:4%">Tipo</td>
                        <td class="titulos2" style="width:7%">Responder</td>
						<td class="titulos2" style="width:7%">Concluida</td>
                     </tr>';
            while ($row = mysql_fetch_row($res)) 
       		{
				$nresul=buscaresponsable($row[4]);
				$mitr=$row[0]-1;
				$sqlr3="SELECT respuesta FROM planacresponsables WHERE codigo='".$mitr."'";
				$res3=mysql_query($sqlr3,$linkbd);
				$row3 = mysql_fetch_row($res3);
				if(($row3[0]=="")or($row3[0]==NULL)){$descripcion=$row[11];}
				else{$descripcion=$row3[0];}
				$paginar="plan-actareasresponder.php?idradicado=".$row[9]."&idresponsable=".$row[0];
				$paginam="plan-actareasmirar.php?idradicado=".$row[9]."&idresponsable=".$row[0];
				switch($row[13])
				{
					case "C":
						$imgtip='<img src="imagenes/escritura.png" style="height:20px;" title="Tarea">';
						$imgcon='<img src="imagenes/confirm3d.png" style="height:20px;">';
						break;
					case "L":
						$imgtip='<img src="imagenes/lectura.jpg" style="height:20px;" title="Informativa">';
						$imgcon='<img src="imagenes/confirm3.png" style="height:20px;">';
						break;
					case "A":
						$imgtip='<img src="imagenes/escritura.png" style="height:20px;" title="Tarea">';
						$imgcon='<img src="imagenes/confirm3d.png" style="height:20px;">';
						break;
					case "R":
						$imgtip='<img src="imagenes/escritura.png" style="height:20px;" title="Tarea">';
					 	$imgcon='<img src="imagenes/confirm3.png" style="height:20px;">';
						break;
				}
				switch($row[6])
				{
					case "C":
					case "RC":
					case "LS":
					case "LN":
						$icopreoce='<img src="imagenes/buscarep.png" onClick="parent.cargarpagina(\''.$paginam.'\');" style="width:18px" title="Mirar" />';
						break;
					
					case "A":
						$icopreoce='<img src="imagenes/b_edit.png" onClick="parent.cargarpagina(\''.$paginar.'\');" style="width:18px" title="Editar" />';
						break;
				}
    			echo '
				<tr class="'.$iter.'" >
					<td>'.$row[12].'</td>
					<td>'.$row[2].'</td>
					<td>'.$row[10].'</td>
					<td>'.$nresul.'</td>
					<td>'.strtoupper($descripcion).'</td>
					<td align="middle"><a href="#">'.$imgtip.'</a></td>
					<td align="middle"><a href="#">'.$icopreoce.'</a></td>
					<td align="middle"><a href="#">'.$imgcon.'</a></td>
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