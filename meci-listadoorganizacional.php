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
                var tinfo=document.form2.proceso.value;
                if (tinfo==0) {
                    
                }else {
                    document.form2.action="meci-listadoorganizacionalexcel.php";
                    document.form2.target="_BLANK";
                    document.form2.submit();
                    document.form2.action="";
                    document.form2.target="";
                }
            }
            function pdf()
            {
                var tinfo=document.form2.proceso.value;
                if (tinfo==0) {
                    
                }else {
                    document.form2.action="pdfmeci-listadoorganizacional.php";
                    document.form2.target="_BLANK";
                    document.form2.submit();
                    document.form2.action="";
                    document.form2.target="";
                }
            }
        </script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
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
               	    <img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/>
                </td>
        	</tr>
		</table>
		<form name="form2" method="post" action="meci-listadoorganizacional.php" enctype="multipart/form-data">
        <?php
			if($_POST[oculto]=="")
			{
                $_POST[proceso]='TODO';
				$_POST[ocublo]="visibility:hidden;";
				$_POST[oculto]="0";
			}
		?>
        	<table class="inicio" >
				<tr>
                	<td class="titulos" colspan="4" style="width:95%">:: Buscar Estrucctura Organizacional </td>
                	<td class="cerrar" style="width:5%" onclick="location.href='meci-principal.php'">Cerrar</td>
              	</tr>
              	<tr>
                	<td style="width:9%" class="saludo1">Clase Proceso:</td>
                	<td style="width:11%">
                    	<select name="proceso" id="proceso" onKeyUp="return tabular(event,this)" style="width:95%;" onChange="document.form2.submit();" >
                        	<option value="TODO"  <?php if($_POST[proceso]=='TODO') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Todos</option>
          					<option value="VIS" <?php if($_POST[proceso]=='VIS') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Visi&oacute;n</option>
          					<option value="MIS" <?php if($_POST[proceso]=='MIS') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Misi&oacute;n</option>
							<option value="PCL" <?php if($_POST[proceso]=='PCL') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Politicas de Calidad</option>
                            <option value="OBJ" <?php if($_POST[proceso]=='OBJ') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Objetivos</option>
        				</select>
					</td>
					<td class="saludo1" style="width:10%; <?php echo $_POST[ocublo];?>">Clase Normativa:</td>
                    <td style="width:43%; <?php echo $_POST[ocublo];?>"></td>
               </tr>                       
   			</table>
            <input name="idclase" id="idclase" type="hidden" value="<?php echo $_POST[idclase]?>" >
            <input name="contador" id="contador" type="hidden" value="<?php echo $_POST[contador]?>">
            <input name="archdel" id="archdel" type="hidden" value="<?php echo $_POST[archdel]?>">
            <input name="ocudelplan" id="ocudelplan" type="hidden" value="<?php echo $_POST[ocudelplan]?>">
            <div class="subpantallac5" style="height:68%; width:99.5%; overflow-x:hidden">
            	<?php
					$linkbd=conectar_bd();					
					//************************************************************************
					
					$crit1=" ";
					if($_POST[proceso]!="TODO")
					{
							if ($_POST[proceso]!="TODO"){$crit1=" AND clase='$_POST[proceso]' ";}
							$sqlr="SELECT * FROM meciestructuraorg WHERE estado<>'' ".$crit1." ORDER BY id DESC";
							$resp = mysql_query($sqlr,$linkbd);
							$ntr = mysql_num_rows($resp);
							$con=1;
							$iter='saludo1';
							$iter2='saludo2';
							echo "
								<table class='inicio' align='center' width='80%'>
									<tr>
										<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
									</tr>
									<tr class='saludo3'>
										<td colspan='8'>Encontrados: $ntr</td>
									</tr>
									<tr>
										<td class='titulos2' style='width:4%'>Item</td>
										<td class='titulos2' style='width:10%'>Clase</td>
										<td class='titulos2' style='width:41%'>Descripci&oacute;n</td>
										<td class='titulos2' style='width:8%'>Versi&oacute;n</td>
										<td class='titulos2' style='width:8%'>Fecha</td>
										<td class='titulos2' style='width:8%'>Estado</td>
									</tr>";
							while ($row =mysql_fetch_row($resp)) 
							{
								switch($row[1])
								{
									case "VIS": $clase="Visi&oacute;n";break;
									case "MIS": $clase="Misi&oacute;n";break;
									case "PCL": $clase="Politica de Calidad";break;
									case "OBJ": $clase="Objetivos";break;
								}
								if($row[5]=='S')
								{
									$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";
									echo "
									<tr class='$iter'>
										<td>$con</td>
										<td>$clase</td>
										<td>".substr(ucwords(strtolower(str_replace("&lt;br/&gt;","\n",$row[4]))), 0, 80)."</td>
										<td>$row[2]</td>
										<td>".date("d-m-Y",strtotime($row[3]))."</td>
										<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
									</tr>";
									$con+=1;
								}
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}
							echo"</table>";
					}else{

                        $sqlr="SELECT * FROM meciestructuraorg WHERE estado<>'' ORDER BY clase DESC";
                        $resp = mysql_query($sqlr,$linkbd);
                        $ntr = mysql_num_rows($resp);
                        $con=1;
                        $iter='saludo1';
                        $iter2='saludo2';
                        echo "
                            <table class='inicio' align='center' width='80%'>
                                <tr>
                                    <td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
                                </tr>
                                <tr class='saludo3'>
                                    <td colspan='8'>Encontrados: $ntr</td>
                                </tr>
                                <tr>
                                    <td class='titulos2' style='width:4%'>Item</td>
                                    <td class='titulos2' style='width:10%'>Clase</td>
                                    <td class='titulos2' style='width:41%'>Descripci&oacute;n</td>
                                    <td class='titulos2' style='width:8%'>Versi&oacute;n</td>
                                    <td class='titulos2' style='width:8%'>Fecha</td>
                                    <td class='titulos2' style='width:8%'>Estado</td>
                                </tr>";
                        while ($row =mysql_fetch_row($resp)) 
                        {
                            switch($row[1])
                            {
                                case "VIS": $clase="Visi&oacute;n";break;
                                case "MIS": $clase="Misi&oacute;n";break;
                                case "PCL": $clase="Politica de Calidad";break;
                                case "OBJ": $clase="Objetivos";break;
                            }
                            if($row[5]=='S')
                            {
								$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";
								echo "
                                <tr class='$iter'>
                                    <td>$con</td>
                                    <td>$clase</td>
                                    <td>".substr(ucwords(strtolower(str_replace("&lt;br/&gt;","\n",$row[4]))), 0, 80)."</td>
                                    <td>$row[2]</td>
                                    <td>".date("d-m-Y",strtotime($row[3]))."</td>
                                    <td style='text-align:center;'><img $imgsem style='width:20px'/></td>
								</tr>";
								$con+=1;
                            }							
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
                        }
                        echo"</table>";
                    }
				?>
            
            </div>
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
            <input type="hidden" name="ocublo" id="ocublo" value="<?php echo $_POST[ocublo];?>">
        </form>
	</body>
</html>