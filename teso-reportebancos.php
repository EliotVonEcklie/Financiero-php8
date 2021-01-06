<?php
require "comun.inc";
require "funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>:: Tesoreria</title>
        <script language="JavaScript1.2">
            function despliegamodal2(_valor,_num)
            {
                document.getElementById("bgventanamodal2").style.visibility = _valor;
                if (_valor == "hidden") 
                {
                    document.getElementById('ventana2').src = "";
                } 
                else 
                {
                    switch (_num) 
                    {
                        case '1':
                            document.getElementById('ventana2').src =
                            "cuentasbancarias-ventana03.php?tipoc=D&objeto=cuentaBancaria&nobjeto=nbanco&cobjeto=ccuenta_banca&tcobjeto=tccuenta_banca";
                        break;
                        case '2':
                            fecha = new Date();
                            document.getElementById('ventana2').src =
                            "registro-ventana04.php?objeto=rp&nobjeto=des_rp&vigencia=2019" //+ fecha.getYear();
                        break;
                        case '3':
                            document.getElementById('ventana2').src =
                            "notasbancarias-ventana.php?iNota=nota_banca&iFecha=fecha";
                        break;
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
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
            }
            
            function generar()
            {
                var fechaInicial = document.getElementById("fc_1198971545").value;
                var fechaFinal = document.getElementById("fc_1198971546").value;
                if(fechaInicial =='' || fechaFinal =='')
                {
                    despliegamodalm('visible','2','Falta digitar la fecha.');
                }
                else
                {
                    document.getElementById('oculto').value='3';
                    document.form2.submit();
                }
                
            }
        </script>
        <script src="css/programas.js"></script>
        <script src="css/calendario.js"></script>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("teso");?></tr>
            <tr>
                <td colspan="3" class="cinta">
                    <a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo" title="Nuevo"/></a>
                    <a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" title="Guardar" /></a>
                    <a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" alt="Buscar" title="Buscar"/></a> 
                    <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a>
                    <a href="<?php echo "archivos/".$_SESSION[usuario]."-reportecontribuyente.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png"  alt="csv" title="csv"></a>
                    <a href="teso-informestesoreria.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
                </td>
            </tr>	
        </table>
        <tr>
            <td colspan="3" class="tablaprin"> 
                <div id="bgventanamodalm" class="bgventanamodalm">
                    <div id="ventanamodalm" class="ventanamodalm">
                        <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; "> 
                        </IFRAME>
                    </div>
                </div>
                <form name="form2" method="post" action="teso-reportebancos.php">
                    <table  class="inicio" align="center" >
                        <tr>
                            <td class="titulos" colspan="8">:. Reporte contribuyente:</td>
                            <td width="139" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
                        </tr>
                        <tr>    
                            <td  class="saludo1" style="width:6%;">Cuenta:</td>
                            <td  valign="middle" style="width:15%;">
                                <input type="text" name="cuentaBancaria" id="cuentaBancaria" value="<?php echo @$_POST[cuentaBancaria]; ?>" aria-describedby="basic-addon1" readonly>
                                <a onClick="despliegamodal2('visible','1');" tittle="Cuenta Bancaria"><img src='imagenes/find02.png' style='width:20px;' /></a>
                            </td>
                            <td style="width:30%;">
                                <input name="nbanco" type="text" id="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%;" readonly> <input name="oculto" id="oculto" type="hidden" value="1"> 
                                <input type="hidden" id="ccuenta_banca" name="ccuenta_banca" value="<?php echo $_POST[ccuenta_banca]?>">
                                <input type="hidden" id="tccuenta_banca" name="tccuenta_banca" value="<?php echo $_POST[tccuenta_banca]?>">
                            </td>     
                            <td  class="saludo1">Fecha Inicial:</td>
                            <td style="width:10%;">
                                <input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias">
                                <input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  style="width:80%;">
                                <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>        
                            </td>
                            <td  class="saludo1">Fecha Final: </td>
                            <td style="width:10%;">
                                <input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  style="width:80%;"> 
                                <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>
                            </td>
                            <td>
                                <input type="button" name="bboton" onClick="generar();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                            </td>
                        </tr>                 
                    </table>    
                    
                    <div id="bgventanamodal2">
                        <div id="ventanamodal2">
                            <IFRAME name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0
                                style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
                        </div>
                    </div>
                </form> 
                <div class="subpantallap">
                    <?php
                    $oculto=$_POST['oculto'];
                    if($_POST[oculto]=='3')
                    {
                        $linkbd=conectar_bd();
                        ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                        $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
                        ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
                        $fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
                        $crit1=" ";
                        $crit2=" ";
                        $crit3=" ";
                        
                        $sqlr = "SELECT T.id_recibos, T.fecha, T.estado, sum(TD.valor) FROM tesoreciboscaja T, tesoreciboscaja_det TD WHERE T.fecha BETWEEN '$fechaf' AND '$fechaf2' AND T.cuentabanco = '$_POST[ccuenta_banca]' AND T.estado='S' AND T.id_recibos=TD.id_recibos GROUP BY T.id_recibos";
                        $resp = mysql_query($sqlr,$linkbd);
                        $ntr = mysql_num_rows($resp);

                        $sqlrIngresoInterno = "SELECT T.id_recibos, T.fecha, T.estado, sum(TD.valor) FROM tesosinreciboscaja T, tesosinreciboscaja_det TD WHERE T.fecha BETWEEN '$fechaf' AND '$fechaf2' AND T.cuentabanco = '$_POST[ccuenta_banca]' AND T.estado='S' AND T.id_recibos=TD.id_recibos GROUP BY T.id_recibos";
                        $respIngresoInterno = mysql_query($sqlrIngresoInterno,$linkbd);
                        $ntr += mysql_num_rows($respIngresoInterno);

                        $sqlrRecaudoTransferencia = "SELECT T.id_recaudo, T.fecha, T.estado, sum(TD.valor) FROM tesorecaudotransferencia T, tesorecaudotransferencia_det TD WHERE T.fecha BETWEEN '$fechaf' AND '$fechaf2' AND T.ncuentaban = '$_POST[cuentaBancaria]' AND T.estado='S' AND T.id_recaudo=TD.id_recaudo GROUP BY T.id_recaudo";
                        $respRecaudoTransferencia = mysql_query($sqlrRecaudoTransferencia,$linkbd);
                        $ntr += mysql_num_rows($respRecaudoTransferencia);

                        $sqlrSinIdentificar = "SELECT T.id_recaudo, T.fecha, T.estado, sum(TD.valor) FROM tesosinidentificar T, tesosinidentificar_det TD WHERE T.fecha BETWEEN '$fechaf' AND '$fechaf2' AND T.ncuentaban = '$_POST[cuentaBancaria]' AND T.estado='S' AND T.id_recaudo=TD.id_recaudo GROUP BY T.id_recaudo";
                        $respSinIdentificar = mysql_query($sqlrSinIdentificar,$linkbd);
                        $ntr += mysql_num_rows($respSinIdentificar);


                        echo "<table class='inicio' align='center' ><tr><td colspan='9' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='9' class='saludo3'>Pagos Encontrados: $ntr</td></tr>
                        <tr>
                            <td class='titulos2'>item</td>
                            <td class='titulos2'>Num. Comprobante</td>
                            <td class='titulos2'>Comprobante</td>
                            <td class='titulos2'>Fecha</td>
                            <td class='titulos2'>Valor</td>
                            <td class='titulos2' width='3%'><center>Estado</td>
                        </tr>";	
                        //echo "nr:".$nr;
                        $iter='saludo1';
                        $iter2='saludo2';
                        $con=1;
                        $valortotal=0;
                        while ($row =mysql_fetch_row($resp)) 
                        {
                            switch ($row[2])
                            {
								case "S":
									$imagen="src='imagenes/confirm.png' title='Activo'";
									$camcelda="<td style='text-align:center;'><a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png' title='Anular'></a></td>";
									break;
								case "P":
									$imagen="src='imagenes/dinero3.png' title='Pago'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
									break;
								case "N":
									$imagen="src='imagenes/cross.png' title='Anulado'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
								case "R":
									$imagen="src='imagenes/reversado.png' title='Reversado'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
                            }
                            echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\"  style='text-transform:uppercase; $estilo' >
								<td>$con</td>
								<td>$row[0]</td>
								<td>RECIBOS DE CAJA</td>
								<td>$row[1]</td>
								<td style='text-align:right;'>$ ".number_format($row[3],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"])."&nbsp;&nbsp;</td>
								<td style='text-align:center;'><img $imagen style='width:18px'></td>
                                </tr>";
                            $valortotal+=$row[3];   
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
                        }

                        while ($row =mysql_fetch_row($respIngresoInterno)) 
                        {
                            switch ($row[2])
                            {
								case "S":
									$imagen="src='imagenes/confirm.png' title='Activo'";
									$camcelda="<td style='text-align:center;'><a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png' title='Anular'></a></td>";
									break;
								case "P":
									$imagen="src='imagenes/dinero3.png' title='Pago'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
									break;
								case "N":
									$imagen="src='imagenes/cross.png' title='Anulado'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
								case "R":
									$imagen="src='imagenes/reversado.png' title='Reversado'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
                            }
                            echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\"  style='text-transform:uppercase; $estilo' >
								<td>$con</td>
								<td>$row[0]</td>
								<td>INGRESOS INTERNOS</td>
								<td>$row[1]</td>
								<td style='text-align:right;'>$ ".number_format($row[3],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"])."&nbsp;&nbsp;</td>
								<td style='text-align:center;'><img $imagen style='width:18px'></td>
                                </tr>";
                            $valortotal+=$row[3];   
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
                        }

                        while ($row =mysql_fetch_row($respRecaudoTransferencia)) 
                        {
                            switch ($row[2])
                            {
								case "S":
									$imagen="src='imagenes/confirm.png' title='Activo'";
									$camcelda="<td style='text-align:center;'><a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png' title='Anular'></a></td>";
									break;
								case "P":
									$imagen="src='imagenes/dinero3.png' title='Pago'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
									break;
								case "N":
									$imagen="src='imagenes/cross.png' title='Anulado'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
								case "R":
									$imagen="src='imagenes/reversado.png' title='Reversado'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
                            }
                            echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\"  style='text-transform:uppercase; $estilo' >
								<td>$con</td>
								<td>$row[0]</td>
								<td>RECAUDO TRANSFERENCIA</td>
								<td>$row[1]</td>
								<td style='text-align:right;'>$ ".number_format($row[3],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"])."&nbsp;&nbsp;</td>
								<td style='text-align:center;'><img $imagen style='width:18px'></td>
                                </tr>";
                            $valortotal+=$row[3];   
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
                        }
                        while ($row =mysql_fetch_row($respSinIdentificar)) 
                        {
                            switch ($row[2])
                            {
								case "S":
									$imagen="src='imagenes/confirm.png' title='Activo'";
									$camcelda="<td style='text-align:center;'><a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png' title='Anular'></a></td>";
									break;
								case "P":
									$imagen="src='imagenes/dinero3.png' title='Pago'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
									break;
								case "N":
									$imagen="src='imagenes/cross.png' title='Anulado'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
								case "R":
									$imagen="src='imagenes/reversado.png' title='Reversado'";
									$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
                            }
                            echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\"  style='text-transform:uppercase; $estilo' >
								<td>$con</td>
								<td>$row[0]</td>
								<td>RECAUDO TRANSFERENCIA</td>
								<td>$row[1]</td>
								<td style='text-align:right;'>$ ".number_format($row[3],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"])."&nbsp;&nbsp;</td>
								<td style='text-align:center;'><img $imagen style='width:18px'></td>
                                </tr>";
                            $valortotal+=$row[3];   
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
                        }
                        echo"<tr class='$iter'>
									<td colspan='3'>
									</td>
									<td >
										Total:
									</td>
                                        <td style='text-align:right;'>$ ".number_format($valortotal,$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"])."&nbsp;&nbsp;
										<input type='hidden' name='valtotal' value='$valortotal'></td>
									<td>
                                    </td>
                                </tr>";
                        echo"</table>";        
                    }
                    ?>
                </div>
            </td>
        </tr> 
    </body>
</html>