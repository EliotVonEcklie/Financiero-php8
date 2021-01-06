<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require "comun.inc";
	require "funciones.inc";
	session_start();
    $linkbd=conectar_bd();
    $conexion = conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	$_POST[oculto2]=$_GET[oculto2];
?>

<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Ideal 10</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script>
		<script>
		$(window).load(function () {
			$('#cargando').hide();
		});
		function excell()
		{
			document.form2.action="presu-auxiliarregistrosexcel.php";
			document.form2.target="_BLANK";
			document.form2.submit();
			document.form2.action="";
			document.form2.target="";
		}
        function generar()
        {
            document.form2.bc.value='1';
            document.form2.submit();
        }
        function despliegamodal2(_valor,v)
        {
            document.getElementById("bgventanamodal2").style.visibility=_valor;
            if(_valor=="hidden"){
                document.getElementById('ventana2').src="";
                document.form2.submit();
            }
            else {
                if(v==1){
                    document.getElementById('ventana2').src="registro-ventana02.php?vigencia="+document.form2.vigencia.value;
                }else if(v==2){
                    document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=solicita";
                }else if(v==3){
                    document.getElementById('ventana2').src="registro-ventana03.php?vigencia="+document.form2.vigencia.value;
                }
                
            }
        }
        function despliegamodalm(_valor,_tip,mensa,pregunta)
        {
            document.getElementById("bgventanamodalm").style.visibility=_valor;
            if(_valor=="hidden"){document.getElementById('ventanam').src="";}
            else
            {
                switch(_tip)
                {
                    case "1":
                        document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
                    case "2":
                        document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
                    case "3":
                        document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
                    case "4":
                        document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
                }
            }
        }
        function funcionmensaje()
        {
            
        }
        function respuestaconsulta(pregunta)
        {
            switch(pregunta)
            {
                case "1":	document.form2.oculto.value=2;
                            document.form2.submit();
                            document.form2.action="pdfcdp.php";
                            break;
            }
        }
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
			<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
		</div>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr>
				<script>barra_imagenes("presu");</script>
				<?php cuadro_titulos();?>
			</tr>
			<tr>
				<?php menu_desplegable("presu");?>
			</tr>
			<tr>
				<td colspan="3" class="cinta">
                    <a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
                    <a class="mgbt"><img src="imagenes/guardad.png"/></a>
                    <a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
                    <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
                    <a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a>
                    <a href="#" class="mgbt" onClick="mypop=window.open('presu-principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
                    <a href="presu-librosppto.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
                </td>
			</tr>
		</table>
 		<form name="form2" method="post" action=""> 
            <?php 
            $sqlReporte = "";
            $nombreReporte ="";
            ?>
			<table class='inicio' align='center'>
				<tr>
					<td colspan='8' class='titulos'>.: Auxiliar de Registros</td>
                    <input type="hidden" value="0" name="bc"> 
				</tr>
                <?php
                $sqlr = "SELECT * FROM meci_reportepersonalizado WHERE sist_cod='4'  AND id_reporte='5'";
                $res = mysqli_query($conexion, $sqlr);
                $row = mysqli_fetch_row($res);
                $sqlReporte = $row[5];
                $nombreReporte = $row[4];

                ?>
				<tr>
                    <td class="saludo1" style="width:3cm;">Fecha Inicial:</td>
                    <td style="width:15%;"><input name="fechai" type="text" id="fc_1198971545" title="YYYY-MM-DD" value="<?php echo $_POST[fechai]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut" /></td>
                    <td class="saludo1" style="width:3cm;">Fecha Final:</td>
                    <td style="width:15%;"><input name="fechaf" type="text" id="fc_1198971546" title="YYYY-MM-DD" value="<?php echo $_POST[fechaf]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971546');" class="icobut" /></td>
                    <td><em class="botonflecha" onClick="generar()">Genera tu reporte</em></td>
                    
				</tr>
			</table>
			<div class="subpantallac5" style="height:65%; width:99.6%; margin-top:0px; overflow-x:hidden" id="divdet">
				<table class='inicio' align='center'>
					<?php
                        
                        if($_POST[bc]==1)
                        {
                            if($_POST[fechai]=='' || $_POST[fechaf]=='')
                            {
                                echo "<script>despliegamodalm('visible','1','Falta seleccionar la fecha ');</script>";
                            }
                            else
                            {
                                $sqlReporte = str_replace(":pfechaini", "'".$_POST[fechai]."'", $sqlReporte);
                                $sqlReporte = str_replace(":pfechafin", "'".$_POST[fechaf]."'", $sqlReporte);
                            }
                            $result = mysqli_query($conexion, $sqlReporte);

                            $cantColum = mysqli_num_fields($result);
                            ?>
                            <input type="hidden" name="cantColum1" id="cantColum1" value="<?php echo $cantColum ?> ">
                            <input type="hidden" name="nombreReporte" id="nombreReporte" value="<?php echo $nombreReporte ?> ">
                            <?php
                
                            $i = 0;
                            echo "	<tr class='titulos'>";
                            while ($metadatos = $result->fetch_field()) 
                            {
                                //$metadatos = mysqli_fetch_field($result, $i);
                                echo "
                                        <td>".$metadatos->name."</td>
                                        <input type='hidden' name='titulo_".$i."[]' id='titulo_".$i."[]' value='".$metadatos->name."' />
                                    ";

                                $i++;
                            }
                            echo "<tr>";
                            $iter='saludo1b';
                            $iter2='saludo2b';
                            $filas=1;
                            while ($row =mysqli_fetch_row($result)) 
                            {
                                echo"<tr class='$iter' style='$stilo; $stado; cursor: hand' text-rendering: optimizeLegibility; ondblclick='direccionaCuentaGastos(this)'>";
                                $x = 0;
                                while($x < $cantColum)
                                {
                                    echo "
                                            <td>".$row[$x]."</td>
                                            <input type='hidden' name='registro_".$x."[]' id='registro_".$x."[]' value='".$row[$x]."' />
                                        ";
                                    $x++;
                                }
                                echo "</tr>";
                                
                                $con+=1;
                                $aux=$iter;
                                $iter=$iter2;
                                $iter2=$aux;
                                $filas++;
                            }
                        }
					?>
				</table>
			</div>
		</form> 
        <div id="bgventanamodal2">
            <div id="ventanamodal2">
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>
	</body>
</html>