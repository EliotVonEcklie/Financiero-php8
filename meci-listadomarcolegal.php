<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html;" charset=ISO-8859-1 />
        <meta http-equiv="X-UA-Compatible" content="IE=9"  />
        <title>:: Spid - Calidad</title>
        <script type="text/javascript" src="css/programas.js"></script>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script>
            function excell()
            {
                document.form2.action="meci-listadomarcolegalexcel.php";
                document.form2.target="_BLANK";
                document.form2.submit();
                document.form2.action="";
                document.form2.target="";
            }
            function pdf()
            {
                document.form2.action="pdfmeci-listadomarcolegal.php";
                document.form2.target="_BLANK";
                document.form2.submit();
                document.form2.action="";
                document.form2.target="";
            }
        </script>
		<?php titlepag();?>
	</head>
	<body>
        <table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("meci");?></tr>
          	<tr>
          		<td colspan="3" class="cinta">
                    <a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo" /></a>
                    <a href="#" class="mgbt"><img src="imagenes/guardad.png" title="Guardar"/></a>
                    <a href="#" class="mgbt"><img src="imagenes/buscad.png" title="Buscar"/></a>
                    <a href="#" class="mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
                    <img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/>
               	    <img src="imagenes/excel.png" title="Excel" onClick="excell()" class="mgbt"/>
                </td>
        	</tr>
		</table>
        <form name="form2" method="post" action="meci-listadomarcolegal.php" enctype="multipart/form-data">
        	<table class="inicio" >
				<tr>
                	<td class="titulos" colspan="4" style="width:95%">:: Filtrar Marco Legal </td>
                	<td class="cerrar" style="width:5%" onclick="location.href='meci-principal.php'">Cerrar</td>
              	</tr>
              	<tr>
                    <td style="width:10%" class="saludo1">Clase Normativa:</td>
                    <td style="width:10%">
                        <select name="normativa" id="normativa" style="width:100%" onChange="document.form2.submit();">
                        	<option value="" <?php if($_POST[normativa]=='') {echo "SELECTED";}?>>...</option>
                            <?php
								$linkbd=conectar_bd();
                                $sqlr="select * from mecivariables WHERE clase='NML' AND estado='S' order by id ASC";
                                $res=mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($res)) 
                                {
                                    echo "<option value=$row[0] ";
                                    $i=$row[0];
                                    if($i==$_POST[normativa]){echo "SELECTED"; $_POST[normativa]=$row[0];}
                                    echo ">".$row[1]." </option>";
                                }	 	
                            ?>
                        </select>
                    </td>
                    <td class="saludo1" style="width:10%;">Categor&iacute;a Normativa:</td>
                    <td style="width:40%;">
                        <select name="catenormativa" id="catenormativa" style="width:25%;" onChange="document.form2.submit();">
                        	<option value="" <?php if($_POST[catenormativa]=='') {echo "SELECTED";}?>>...</option>
                            <?php
								$linkbd=conectar_bd();
								$sqlr="select * from mecivariables WHERE clase='CML' AND estado='S' ORDER BY id ASC";
								$resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    echo "<option value=$row[0] ";
                                    $i=$row[0];
                                    if($i==$_POST[catenormativa]){echo "SELECTED"; $_POST[catenormativa]=$row[0];}
                                    echo ">".$row[1]." </option>";
                                }
                                 	
                            ?>
                        </select>
                    </td>
               </tr>                       
   			</table>
            <div class="subpantallac5" style="height:68%; width:99.5%; overflow-x:hidden">
            	<?php
					$linkbd=conectar_bd();					
					//************************************************************************
						
                    if ($_POST[normativa]!=""){$crit1=" AND idnormativa='$_POST[normativa]'";}
                    if ($_POST[catenormativa]!=""){$crit2=" AND idcatenormativa='$_POST[catenormativa]'";}
                    $sqlr="SELECT * FROM meciestructuraorg_marcolegal WHERE estado<>'' ".$crit1.$crit2." ORDER BY id DESC";
                    $resp = mysql_query($sqlr,$linkbd);
                    $ntr = mysql_num_rows($resp);
                    $con=1;
                    $iter='saludo1';
                    $iter2='saludo2';
                    echo "
                        <table class='inicio' align='center' width='80%'>
                            <tr>
                                <td colspan='9' class='titulos'>.: Resultados Busqueda:</td>
                            </tr>
                            <tr class='saludo3'>
                                <td colspan='9'>Encontrados: $ntr</td>
                            </tr>
                            <tr>
                                <td class='titulos2' style='width:4%'>Item</td>
                                <td class='titulos2' style='width:10%'>Clase</td>
                                <td class='titulos2' style='width:10%'>Categor&iacute;a</td>
                                <td class='titulos2' style='width:41%'>Descripci&oacute;n</td>
                                <td class='titulos2' style='width:8%'>Fecha</td>
                                <td class='titulos2' style='width:8%'>Documentos</td>
                                <td class='titulos2' style='width:4%'>Estado</td>
                            </tr>";
                    while ($row =mysql_fetch_row($resp)) 
                    {
                        $sqlrdoc="SELECT nombre FROM mecivariables WHERE id='$row[2]'";
                        $rowdoc =mysql_fetch_row(mysql_query($sqlrdoc,$linkbd));
                        $sqlrcate="SELECT nombre FROM mecivariables WHERE id='$row[7]'";
                        $rowcate =mysql_fetch_row(mysql_query($sqlrcate,$linkbd));
                        
                        switch($row[6])
                        {
                            case "S": 
                                $imgsem="src='imagenes/sema_verdeON.jpg' title='Vigente'";
                                echo "
                                <tr class='$iter' style='text-transform:uppercase;'>
                                    <td>$con</td>
                                    <td>$rowdoc[0]</td>
                                    <td>$rowcate[0]</td>
                                    <td>$row[4]</td>
                                    <td>".date("d-m-Y",strtotime($row[3]))."</td>
                                    <td style='text-align:center;'>".$row[5]."</td>
                                    <td style='text-align:center;'><img $imgsem style='width:20px'/></td>
                                </tr>";
                                $con+=1;
                                break;
                            case "N": 
                                $imgsem="src='imagenes/sema_rojoON.jpg' title='No Vigente'";
                                break;
                            case "M": $clase="Objetivos";break;
                            case "F": $clase="Marco Legal";break;
                        }
                        $aux=$iter;
                        $iter=$iter2;
                        $iter2=$aux;
                    }
                    echo"</table>";
				?>
            
            </div>
        </form>
	</body>
</html>