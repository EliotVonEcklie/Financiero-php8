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
    <title>:: Spid - Meci Calidad</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="css/programas.js"></script>
    <script>function funbuscar(){document.form2.submit();}</script>
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
                        <?php	
							$linkbd=conectar_bd();
                            $sqlr="SELECT * FROM calprocesos ORDER BY id ASC  ";
                            $res=mysql_query($sqlr,$linkbd);
                            while ($rowEmp = mysql_fetch_assoc($res)) 
                            {
                                echo "<option  value= ".$rowEmp['id'];
                                $i=$rowEmp['id']."-".$rowEmp['prefijo'];
                                if($i==$_POST[procesos])
                                {
                                    echo "  SELECTED";
                                    $_POST[octradicacion]=$rowEmp['nombre'];
                                }
                                echo ">".$rowEmp['id']." - ".$rowEmp['nombre']." </option>"; 	 
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
                if ($_POST[procesos]!="")
                {
                 	$crit1=" AND cgd.proceso='".$_POST[procesos]."' ";
                }
                if ($_POST[documento]!=""){$crit2=" AND cgd.codigospid LIKE '%$_POST[documento]%' ";}
                //sacar el consecutivo 
                $sqlr="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id AND cgd.estado='S' ".$crit1.$crit2." ORDER BY cgd.proceso, cgd.id";
				//echo  $sqlr;
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
                    $sqlr2="SELECT nombre FROM calprocesos WHERE id='".$row[1]."'";
                    $res2=mysql_query($sqlr2,$linkbd);
                    $row2 = mysql_fetch_row($res2);
                    $procesos=$row2[0];
                    $sqlr2="SELECT nombre FROM caldocumentos WHERE id='".$row[2]."'";
                    $res2=mysql_query($sqlr2,$linkbd);
                    $row2 = mysql_fetch_row($res2);
                    $documentos=$row2[0];
                    $sqlr2="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row[3]."'";
                    $res2=mysql_query($sqlr2,$linkbd);
                    $row2 = mysql_fetch_row($res2);
                    $politicas=$row2[0];
					$sqlr2="SELECT documento FROM calgestiondoc WHERE estado='S' AND proceso='".$row[1]."'";
                    $res2=mysql_query($sqlr2,$linkbd);$ntr2 = mysql_num_rows($res2);
                    $bdescargar='<a href="informacion/calidad_documental/documentos/'.$row[15].'" target="_blank" ><img src="imagenes/descargar.png" alt=\'(Descargar)\' title="(Descargar)" ></a>';
                    $contad++;
                    if($politicas==""){$nombredel=strtoupper($documentos);}
                    else{$nombredel=strtoupper($politicas);}
					$nresul=buscaresponsable($row[14]);
                    echo "
                        <tr class='$iter'>
							<td >".$con."</td>
                            <td >".strtoupper($procesos)."</td>
							<td align=\"middle\">".$row[4]."</td>
							<td>".$row[6]."</td>
                            <td>
								<div style=\"margin-top:10px\" align=\"middle\">".$bdescargar."&nbsp;&nbsp;&nbsp;".$nombredel."</div>
								<div style=\"font-size:11;margin-bottom:10px; margin-left:10px; margin-right:10px;\" align=\"middle\">Versi&oacute;n:".$row[11]." ".$row[13]."; Responsable:".$nresul."</div>
							</td>
                        </tr>";
						
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