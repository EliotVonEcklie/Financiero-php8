<?php //V 1000 12/12/16 ?> 
<?php 
    require"comun.inc";
    require"funciones.inc";
    session_start();
    $linkbd=conectar_bd();  
    cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
    header("Cache-control: private"); // Arregla IE 6
    date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <title>:: Spid - Meci Calidad</title>
   <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="css/programas.js"></script>
    <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
    
    <script>function funbuscar(){document.form2.submit();}</script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#procesos').change(function(event) {
                funbuscar();
            });
        });
    </script>

    <?php titlepag();?>
</head>
<body>	
	<form name="form2" method="post" action="meci-gestionmaestrospro.php" enctype="multipart/form-data">

        <table  class="inicio" align="center" >
			<tr>
				<td class="titulos" colspan="4">:: Listado Maestro por Procesos </td>
          	</tr>
      		<tr>
                <td style="width:5%" class="saludo1">Proceso:</td>
                <td style="width:30%">
                    <select id="procesos" name="procesos" class="elementosmensaje" style="width:95%"  onKeyUp="return tabular(event,this)"   >
                        <option onChange="" value=""  >0 - TODOS</option>
                        <script>parent.document.form1.listado.value='0';</script>
                        <?php	
							$linkbd=conectar_bd();
                            $sqlr="SELECT * FROM calprocesos ORDER BY id ASC  ";
                            $res=mysql_query($sqlr,$linkbd);
                            while ($rowEmp = mysql_fetch_assoc($res)) 
                            {
                                if($rowEmp['id']==$_POST[procesos])
                                {
                                    echo "<option value= '$rowEmp[id]' SELECTED> $rowEmp[id] - $rowEmp[nombre] </option>";
                                    $_POST[octradicacion]=$rowEmp['nombre'];
                                    echo"<script>parent.document.form1.listado.value='$rowEmp[id]';</script>";
                                }
                                else{
                                    echo "<option value='$rowEmp[id]'>$rowEmp[id] - $rowEmp[nombre]</option>";
                                }
                            }		
                        ?> 
                    </select> 
                </td>
                <td style="width:13%" class="saludo1">C&oacute;digo SPID:</td>
                <td style="width:43%"><input name="documento" type="text" id="documento" value=""  maxlength="16"></td>
       		</tr>                       
		</table>
        <input name="oculto" type="hidden" value="1">
        <div class="subpantallac5" style="height:85%">
		<?php
            $oculto=$_POST['oculto'];
            if($_POST[oculto])
            {
                $contad=0;
                $linkbd=conectar_bd();
                $crit1=" ";
                $crit2=" ";
                $namearch="informacion/temp/documentos_en_mejora.csv";
                if ($_POST[procesos]!=""){$crit1=" AND proceso='".$_POST[procesos]."' ";}
                if ($_POST[documento]!=""){$crit2=" AND codigospid LIKE '%$_POST[documento]%' ";}
                $sqlr="SELECT distinct proceso FROM calgestiondoc WHERE estado='S' ".$crit1.$crit2." ORDER BY proceso, id";
                $resp = mysql_query($sqlr,$linkbd);
                $ntr = mysql_num_rows($resp);
                $con=1;
                echo "
                    <table class='inicio' align='center' width='80%'>
                        <tr>
                            <td colspan='11' class='titulos'>.: Resultados Busqueda:</td>
                        </tr>
                        <tr>
                            <td colspan='7'>Encontrados: $ntr</td>
                        </tr>
                        <tr>
							<td class='titulos2' style=\"width:3%\">Item</td>
                            <td class='titulos2' style=\"width:25%\">Procesos</td>
							<td class='titulos2' style=\"width:10%\">Codigo</td>
							<td class='titulos2' style=\"width:20%\">Titulo</td>
                            <td class='titulos2' style=\"width:35%\">Documentos</td>
                        </tr>";	
                $iter='saludo1';
                $iter2='saludo2';
                while ($row =mysql_fetch_row($resp)) 
                {	
					$sqlr2="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id AND cgd.estado='S' AND cgd.proceso='".$row[0]."' ".$crit1.$crit2." ORDER BY cgd.proceso, cgd.id";
               		$resp2 = mysql_query($sqlr2,$linkbd);
					$row2 =mysql_fetch_row($resp2);
                	$ntr2 = mysql_num_rows($resp2);
                  	$sqlr3="SELECT nombre FROM calprocesos WHERE id='".$row[0]."'";
                    $res3=mysql_query($sqlr3,$linkbd);
                    $row3 = mysql_fetch_row($res3);
                    $procesos=$row3[0];
					$sqlr3="SELECT nombre FROM caldocumentos WHERE id='".$row2[2]."'";
                    $res3=mysql_query($sqlr3,$linkbd);
                    $row3 = mysql_fetch_row($res3);
                    $documentos=$row3[0];
					$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row2[3]."'";
                    $res3=mysql_query($sqlr3,$linkbd);
                    $row3 = mysql_fetch_row($res3);
                    $politicas=$row3[0];
					if($politicas==""){$nombredel=strtoupper($documentos);}
                    else{$nombredel=strtoupper($politicas);}
					$bdescargar='<a href="informacion/calidad_documental/documentos/'.$row2[15].'" target="_blank" ><img src="imagenes/descargar.png" title=\'(Descargar)\' title="(Descargar)" ></a>';
					$nresul=buscaresponsable($row2[14]);
                    echo "
                        <tr class='$iter'>
							<td rowspan='".$ntr2."'>".$con."</td>
                            <td rowspan='".$ntr2."'>".strtoupper($procesos)."</td>
							<td align=\"middle\">".$row2[4]."</td>
							<td>".$row2[6]."</td>
                            <td>
								<div style=\"margin-top:10px\" align=\"middle\">".$bdescargar."&nbsp;&nbsp;&nbsp;".$nombredel."</div>
								<div style=\"font-size:11;margin-bottom:10px; margin-left:10px; margin-right:10px;\" align=\"middle\">Versi&oacute;n:".$row2[11]." ".$row2[13]."; Responsable:".$nresul."</div>
							</td>
                        </tr>";
						
						if($ntr2!=1)
						{
							while ($row2 =mysql_fetch_row($resp2))
							{	
								$sqlr3="SELECT nombre FROM caldocumentos WHERE id='".$row2[2]."'";
								$res3=mysql_query($sqlr3,$linkbd);
								$row3 = mysql_fetch_row($res3);
								$documentos=$row3[0];
								$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row2[3]."'";
								$res3=mysql_query($sqlr3,$linkbd);
								$row3 = mysql_fetch_row($res3);
								$politicas=$row3[0];
								if($politicas==""){$nombredel=strtoupper($documentos);}
								else{$nombredel=strtoupper($politicas);}
								$bdescargar='<a href="informacion/calidad_documental/documentos/'.$row2[15].'" target="_blank" ><img src="imagenes/descargar.png" title=\'(Descargar)\' title="(Descargar)" ></a>';
								$nresul=buscaresponsable($row2[14]);
								echo"
									<tr class='$iter'>
										<td align=\"middle\">".$row2[4]."</td>
										<td>".$row2[6]."</td>
										 <td>
											<div style=\"margin-top:10px\" align=\"middle\">".$bdescargar."&nbsp;&nbsp;&nbsp;".$nombredel."</div>
											<div style=\"font-size:11;margin-bottom:10px; margin-left:10px; margin-right:10px;\" align=\"middle\">Versi&oacute;n:".$row2[11]." ".$row2[13]."; Responsable:".$nresul."</div>
										</td>
									</tr>";	
							}
						}
                     $con+=1;
                     $aux=$iter;
                     $iter=$iter2;
                     $iter2=$aux;
                 }
                echo"</table>";
            }
        ?>
		</div>
	</form>
</body>
</html>