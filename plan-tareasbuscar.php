<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
$linkbd=conectar_bd();	
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("plan");?></tr>
          	<tr>
          		<td colspan="3" class="cinta"><a href="plan-tareasasignar.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" class="mgbt"><img src="imagenes/guardad.png" /></a><a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" class="mgbt" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
		</table>
        <form name="form2" method="post" action="">
            <table class="inicio">
                <tr>
                    <td height="25" colspan="4" class="titulos" >:.Buscar Documento Radicado</td>
                    <td width="5%" class="cerrar"><a href="plan-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                    <td colspan="5" class="titulos2" >:&middot; Por Descripci&oacute;n </td>
                </tr>
                <tr>
                	<td style="width:9%" class="saludo1">Clase Proceso:</td>
                	<td style="width:11%">
                    	<select name="proceso" id="proceso" onKeyUp="return tabular(event,this)" style="width:95%;" onChange="document.form2.submit();">
                        	<option value="" <?php if($_POST[proceso]=='') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>....</option>
          					<option value="A" <?php if($_POST[proceso]=='A') {echo "SELECTED";}?>>Pendientes</option>
          					<option value="C" <?php if($_POST[proceso]=='C') {echo "SELECTED";}?>>Contestados</option>
                            <option value="V" <?php if($_POST[proceso]=='V') {echo "SELECTED";}?>>Vencidos</option>
                            <option value="L" <?php if($_POST[proceso]=='L') {echo "SELECTED";}?>>Solo Lectura</option>
        				</select>
                    </td>
                    <td width="13%" class="saludo1" >:&middot; evento:</td>
                    <td  colspan="3"><input name="numero" type="text" size="30%" value="<?php echo $_POST[numero]?>"></td>
                    <input name="oculto" type="hidden" id="oculto" value="<?php echo $_POST[oculto]?>" >
                </tr>
            </table>
           	<div class="subpantallac5" style="height:65%; width:99.5%; overflow-x:hidden">
				<table class="inicio">
                	<tr>
                 		<td class="titulos" colspan="9">:: Lista de Tareas Asignadas</td>
                    </tr>
                    <tr>
                        <td class="titulos2" style="width:8%;">Radicaci&oacute;n</td>
                        <td class="titulos2" style="width:8%;">Fecha</td>
                        <td class="titulos2" style="width:30%;">Responsable</td>
                        <td class="titulos2" style="width:39%;">Descripci&oacute;n</td>
                        <td class="titulos2" style="width:5%;">Mirar</td>
                        <td class="titulos2" style="width:5%;">Editar</td>
                        <td class="titulos2" style="width:5%;">Tipo</td>
                        <td class="titulos2" style="width:5%;">Estado</td>
                        <td class="titulos2" style="width:5%;">Concluida</td>
                     </tr>
                     <?php 
					 	$cond1="";
						$cond2="";
						if($_POST[proceso]!=""){$cond1=" AND estado='".$_POST[proceso]."' ";}
						if($_POST[numero]!="")
						{$cond2="AND (codigobarras like'%".$_POST[numero]."%' OR idtercero like '%".strtoupper($_POST[numero])."%') ";}
						$sqlr="SELECT * FROM planacradicacion WHERE usuarior='$_SESSION[cedulausu]' AND numeror LIKE '%I%' ".$cond1.$cond2." ORDER BY numeror ASC";
						$res=mysql_query($sqlr,$linkbd);
						$iter='saludo1';
						$iter2='saludo2';
						while ($row = mysql_fetch_row($res))
						{
							$fechar=date("d-m-Y",strtotime($row[2]));
							$fechav=date("d-m-Y",strtotime($row[6]));
							$fechactual=date("d-m-Y");
							$tmp = explode('-',$fechav);
							$fcpv=mktime(0,0,0,$tmp[1],$tmp[0],$tmp[2]);
							$tmp = explode('-',$fechactual);
							$fcpa=mktime(0,0,0,$tmp[1],$tmp[0],$tmp[2]);
							if ($row[20]== "R"){$imgcon="src='imagenes/confirm3.png' title='Aprobada'";}
							else {$imgcon="src='imagenes/confirm3d.png' title='No Aprobada'";}
							$imgver="<a href='plan-tareasmirar.php?id=$row[0]'><img src='imagenes/buscarep.png' style='width:18px' title='Mirar'></a>";
							$imgedi="<a href='plan-tareasmodificar.php?id=$row[0]'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a>";
							$sqlres="SELECT usuariocon,estado FROM planacresponsables WHERE codradicacion='$row[0]' ";
							$resr=mysql_query($sqlres,$linkbd);
							while ($rowres = mysql_fetch_row($resr))
							{
								switch($rowres[1])
								{
									case "LS":
										$imgsem="src='imagenes/sema_verdeON.jpg' title='Revisados'";
										$imgtip="src='imagenes/lectura.jpg' title='Solo Lectura'";
										break;
									case "LN":
										$imgsem="src='imagenes/sema_amarilloON.jpg' title='Pendiantes'";
										$imgtip="src='imagenes/lectura.jpg' title='Solo Lectura'";
										break;
									case "C":
										$imgsem="src='imagenes/sema_verdeON.jpg' title='Contestada'";
										$imgtip="src='imagenes/escritura.png' title='Responder'";
										break;
									case "CC":
										$imgsem="src='imagenes/sema_verdeON.jpg' title='Consulta Contestada'";
										$imgtip="src='imagenes/escritura.png' title='Responder'";
										break;
									case "CA":
										$imgsem="src='imagenes/sema_amarilloON.jpg' title='Consulta Pendiantes'";
										$imgtip="src='imagenes/escritura.png' title='Responder'";
										break;
									case "RC":
										$imgsem="src='imagenes/sema_azulON.jpg' title='Redirigida'";
										$imgtip="src='imagenes/redirigir.png' title='Redirigida'";
										break;
									case "CA":
										if($fcpa > $fcpv ) {$imgsem="src='imagenes/sema_rojoON.jpg' title='Vencida'";}
										else {$imgsem="src='imagenes/sema_amarilloON.jpg' title='Sin Responder'";}
										$imgtip="src='imagenes/escritura.png' title='Responder'";
										break;
									case "A":
										if($fcpa > $fcpv ) {$imgsem="src='imagenes/sema_rojoON.jpg' title='Vencida'";}
										else {$imgsem="src='imagenes/sema_amarilloON.jpg' title='Sin Responder'";}
										$imgtip="src='imagenes/escritura.png' title='Responder'";
										break;
								}					
								echo 
								'<tr class="'.$iter.'" >
									<td>'.$row[1].'</td>
									<td>'.$fechar.'</td>
									<td>'.buscaresponsable($rowres[0]).'</td>
									<td>'.$row[8].'</td>
									<td style="text-align:center;">'.$imgver.'</td>
									<td style="text-align:center;">'.$imgedi.'</td>
									<td style="text-align:center;"><img '.$imgtip.' style="width:20px"/></td>
									<td style="text-align:center;"><img '.$imgsem.' style="width:20px"/></td>
									<td style="text-align:center;"><img '.$imgcon.' style="width:20px"/></td>
								</tr>';
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}
						}
					 ?>
                </table>
            </div>
        </form>
		
	</body>
</html>