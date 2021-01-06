<?php
	require "comun.inc";
    require "funciones.inc"; 
    $linkbd = conectar_v7();
	session_start();
	cargarcodigopag(@$_GET['codpag'], @$_SESSION['nivel']);
	header("Cache-control: private"); // Arregla IE 6 
    date_default_timezone_set("America/Bogota");
?>

<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es"> 
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Ideal - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/funciones.js"></script>
        <script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap/css/estilos.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
        <?php titlepag();?> 
        <script>
            function excell()
            {
                document.form2.action="ccp-ejecucioningresosexcel.php";
                document.form2.target="_BLANK";
                document.form2.submit(); 
                document.form2.action="";
                document.form2.target="";
            }

            function validar()
            {
                document.form2.submit();
            }
        </script>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("ccpet");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a><img src="imagenes/add.png" title="Nuevo" onClick="location.href='#'" class="mgbt"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a><img src="imagenes/busca.png" title="Buscar"  onClick="location.href='#'" class="mgbt"/></a>
					<a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
                    <img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/>
					<img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='ccp-ejecucionpresupuestal.php'" class="mgbt"/>
				</td>
        	</tr>
		</table>
        <div class="row" style="margin: 5px 4px 0px">
            <div class="col-12">
                <form name="form2" method="post">
                <div class="row" style="border-radius:2px; background-color: #E1E2E2; ">
                    <div class="col-md-2" style="display: grid; align-content:center;">
                        <label for="" style="margin-bottom: 0; font-weight: bold">Unidad ejecutora: </label>
                    </div>
                    <div class="col-md-3" style="padding: 4px">
                        <select name="unidadEjecutora" id="unidadEjecutora" style="width:85%;" class="form-control select" onChange="validar()" onKeyUp="return tabular(event,this)">
                            <option value=''>Todos</option>
				            <?php
                                $sqlr = "select *from pptouniejecu where estado='S'";
                                $res = mysqli_query($linkbd, $sqlr);
                                while ($row = mysqli_fetch_row($res))
                                {
                                    echo "<option value=$row[0] ";
                                    $i=$row[0];
                                    if($i==$_POST[unidadEjecutora])
                                    {
                                        echo "SELECTED";
                                    }
                                    echo ">".$row[0]." - ".$row[1]."</option>";	 	 
                                }
				            ?>
			            </select>
                    </div>
                    <div class="col-md-2" style="display: grid; align-content:center;">
                        <label for="" style="margin-bottom: 0; font-weight: bold">Medio de pago: </label>
                    </div>
                    <div class="col-md-2" style="padding: 4px">
                        <select name="medioDePago" id="medioDePago" style="width:85%;" class="form-control select" onChange="validar()" onKeyUp="return tabular(event,this)">
                            <option value=''>Todos</option>
                            <option value='CSF' <?php if($_POST[medioDePago]=='CSF') echo "SELECTED"; ?>>CSF</option>
                            <option value='SSF' <?php if($_POST[medioDePago]=='SSF') echo "SELECTED"; ?>>SSF</option>
			            </select>
                    </div>

                    <div class="col-md-1" style="display: grid; align-content:center;">
                        <label for="" style="margin-bottom: 0; font-weight: bold">Vigencia: </label>
                    </div>
                    <div class="col-md-2" style="display: grid; align-content:center;">
                        <select name="vigencia" id="vigencia" style="width:85%;" class="form-control select" onChange="validar()" onKeyUp="return tabular(event,this)">
				            <?php
                                $sqlr = "SELECT vigencia FROM ccpetinicialingresos GROUP BY vigencia ORDER BY vigencia DESC";
                                $res = mysqli_query($linkbd, $sqlr);
                                while ($row = mysqli_fetch_row($res))
                                {
                                    echo "<option value=$row[0] ";
                                    $i=$row[0];
                                    if($i==$_POST[vigencia])
                                    {
                                        echo "SELECTED";
                                    }
                                    echo ">".$row[0]."</option>";	 	 
                                }
				            ?>
			            </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="subpantalla" style="height:472px; width:99.6%; overflow-x:hidden; padding:10px !important; background-color: white;">
            
            <table v-if="show_table_search" class="table table-hover">
                <thead >
                    <tr style="font-size: 140%; background-color: #2ECCFA; ">
                        <th style="border-radius: 5px 0px 0px 0px !important;">Detalle</th>
                        <th>C&oacute;digo</th>
                        <th>Nombre</th>
                        <th style="border-radius: 0px 5px 0px 0px !important;">Presupuesto inicial</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                        $crit = '';
                        if($_POST['unidadEjecutora'] != ''){
                            $crit = "AND unidad = '$_POST[unidadEjecutora]'";
                        }

                        $crit1 = '';
                        if($_POST['medioDePago'] != ''){
                            $crit1 = "AND medioPago = '$_POST[medioDePago]'";
                        }

                        $crit2 = '';
                        if($_POST['vigencia'] != ''){
                            $crit2 = "AND vigencia = '$_POST[vigencia]'";
                        }else{
                            $sqlr = "SELECT MAX(vigencia) FROM ccpetinicialingresos";
                            $res = mysqli_query($linkbd, $sqlr);
                            $row = mysqli_fetch_row($res);
                            $_POST['vigencia'] = $row[0];
                        }

                        $sql = "SELECT codigo, nombre, tipo FROM cuentasingresosccpet WHERE municipio=1";
                        $res = mysqli_query($linkbd, $sql);
                        $i = 0;
                        while($row = mysqli_fetch_row($res))
                        {
                            $negrilla = 'font-weight: normal;';
                            if($row[2] == 'A')
                            {
                                $negrilla = 'font-weight: bold;';
                            }
                            $sql_cuenta = "SELECT sum(valor_total) FROM ccpetinicialingresos WHERE cuenta like '$row[0]%' $crit $crit1 $crit2";
                            $res_cuenta = mysqli_query($linkbd, $sql_cuenta);
                            $row_cuneta = mysqli_fetch_row($res_cuenta);
                            if($row_cuneta[0] > 0){
                                echo "
                                    <tr style='$negrilla font-size: 130%'>
                                        <td style='padding-left: 40px; padding-top: 15px'>";
                                            if($row[2] == 'C'){
                                                echo "<a onClick='verDetalleIngresos($i, \"$row[0]\",\"$_POST[unidadEjecutora]\",\"$_POST[medioDePago]\",\"$_POST[vigencia]\")' style='cursor:pointer;'>
                                                <img id='img".$i."' style='width: 15px;' src='imagenes/plus.gif'>
                                                </a> 
                                                ";
                                            }
                                        echo "
                                        </td>
                                        <td>$row[0]</td>
                                        <td>$row[1]</td>
                                        <td style='width: 300px'>$ ".number_format($row_cuneta[0], 2, ',', '.')."</td>
                                    </tr>
                                    <input type='hidden' name='codigo[]' value='$row[0]'>
                                    <input type='hidden' name='nombre[]' value='$row[1]'>
                                    <input type='hidden' name='valor[]' value='$row_cuneta[0]'>
                                    <input type='hidden' name='tipo[]' value='$row[2]'>
                                    <tr cellspacing='0' cellpadding='0' style = ''>
                                        <td align='center' style='padding: 0px !important; border: 0px'></td>
                                        <td colspan='3' align='right' style='padding: 0px !important; border: 0px'>
                                            <div id='detalle".$i."' style='display:none;'></div>
                                        </td>
                                    </tr>";

                                    $i++;
                            }
                        }
                    ?>
                    </form>
                </tbody>
            </table>
        </div>
    </body>
</html>