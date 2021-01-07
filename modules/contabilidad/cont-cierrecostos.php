<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]); 
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
        <script>
            function guardar()
            {
                if ((document.getElementById('ages').value!="")&&(document.getElementById('periodo').value!="-1"))
                {
					if(document.getElementById('oculto2').value=="1"){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else {despliegamodalm('visible','2','Se debe "Generar" primero');}
				}
				else {despliegamodalm('visible','2','Debe ingresar Vigencia y Mes Inicial');}
            }
            function buscactac(e){if (document.form2.cuentamiles.value!=""){document.form2.bcc.value='1';document.form2.submit();}}
            function buscactace(e){if (document.form2.cuentac.value!=""){document.form2.bcce.value='1';document.form2.submit();}}
            function buscactacd(e){if (document.form2.cuentac.value!=""){document.form2.bccd.value='1';document.form2.submit();}}
            function generar()
			{
				if ((document.getElementById('ages').value!="")&&(document.getElementById('periodo').value!="-1"))
                {
					document.getElementById('oculto2').value="1";
					document.form2.gencom.value=1;document.form2.oculto.value=1;document.form2.submit();
				}
				else {despliegamodalm('visible','2','Debe ingresar Vigencia y Mes Inicial');}
			}
            function trasladarctas()
            {
                document.form2.gencom.value=0; 
                document.form2.gentrasladar.value=1; 
                document.form2.oculto.value=0; 
                document.form2.submit(); 
            }
            function trasladarctas2()
            {
                document.form2.gencom.value=0; 
                document.form2.gentrasladar.value=1; 
                document.form2.oculto.value=3; 
                document.form2.submit(); 
            }
            function callprogress(vValor)
            {
                document.getElementById("getprogress").innerHTML = vValor;
                document.getElementById("getProgressBarFill").innerHTML = '<div class="ProgressBarFill" style="width: '+vValor+'%;"></div>';
                if (vValor==100)
                {
                    document.getElementById("progreso").style.display='none'
                    document.getElementById("getProgressBarFill").style.display='none'
                }
                if (vValor<100)
                {
                    document.getElementById("progreso").style.display='block'
                    document.getElementById("getProgressBarFill").style.display='block'
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
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;
								document.form2.submit();
								break;
				}
			}
        </script>
        <?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("cont");?></tr>
            <tr>
                <td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png"/></a>
					<a href="#" class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png"  title="Guardar"/></a>
					<a class="mgbt"><img src="imagenes/buscad.png"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" class="mgbt" onClick="<?php echo paginasnuevas("cont");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
            </tr>
        </table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php
            $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
            $sqlr="Select * from configbasica";
            $resp = mysql_query($sqlr,$linkbd);
            while ($row =mysql_fetch_row($resp)){$_POST[nit]=$row[0];}
            //***excedente
            if($_POST[oculto]=="")
            {	
                $_POST[dcuentacierre]=array();
                $_POST[dcuentacerrar]=array();
                $_POST[dcuentatras]=array();	
                $sqlr="select *from contparametroscierrecostos";
                $res=mysql_query($sqlr,$linkbd);
                while($row=mysql_fetch_row($res))
                {
                    $_POST[dcuentacerrar][]=$row[0];
                    $_POST[dcuentacierre][]=$row[1];
                    $_POST[dcuentatras][]=$row[2];	
                }
            }
        ?>
    	<form name="form2" method="post" action="cont-cierrecostos.php">
            <div id="progreso" class="ProgressBar" style="display:none">
                <div class="ProgressBarText"><span id="getprogress"></span>&nbsp;% completado</div>
                <div id="getProgressBarFill"></div>
            </div>
            <table class="inicio" >     
                <tr>
                    <td class="titulos" colspan="4">:: Cierre de Costos</td>
                    <td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td width="" class="saludo1" >:: Vigencia Cierre:</td>
                    <td>
                        <select name="ages" id="ages">
                            <option value="">Seleccione...</option>
                            <?php
                                for($x=($vigusu-2);$x<=($vigusu);$x++)
                                {
                                    if($x==$_POST[ages]){echo "<option value='$x' SELECTED>$x</option>";}
                                    else {echo "<option value='$x'>$x</option>";}
                                }
                            ?>
                        </select> 
                    </td>
                    <td class="saludo1" >Mes Inicial:</td>
                    <td>
                        <select name="periodo" id="periodo" onChange="validar()"  >
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from meses where estado='S' ";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[periodo])
                                    {
                                        echo "<option value=$row[0] SELECTED>$row[1]</option>";
                                        $_POST[periodonom]=$row[1];
                                        $_POST[periodonom]=$row[2];
                                    }
                                    else {echo "<option value=$row[0]>$row[1]</option>";}
                                }   
                            ?>
                        </select>
                        <input type="hidden" value="<?php echo $_POST[oculto]?>" name="oculto">
                        <input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2]?>"/>
                        <input type="hidden" value="<?php echo $_POST[gencom]?>" name="gencom"> 
                        <input type="hidden" value="<?php echo $_POST[gentrasladar]?>" name="gentrasladar">
                        <input type="button" name="genera" value=" Generar " onClick="generar()"> 
                        <input type="button" name="contabiliza" value=" Cerrar Cuentas " onClick="guardar()"> 
                        <input type="button" name="calcular" value=" Calcular Resultado" onClick="trasladarctas()">
                        <input type="button" name="trasladar" value=" Trasladar Resultado" onClick="trasladarctas2()">
                        <?php
                            $numctas=count($_POST[dcuentacierre]);
                            for ($x=0;$x<$numctas;$x++)
                            {
                                echo "
								<input type='hidden' name='dcuentacerrar[]' value='".$_POST[dcuentacerrar][$x]."'>
								<input type='hidden' name='dcuentacierre[]' value='".$_POST[dcuentacierre][$x]."'>
								<input type='hidden' name='dcuentatras[]' value='".$_POST[dcuentatras][$x]."'>";			 											
                            }
  
                        ?>
                        <input type="hidden" value="<?php echo $_POST[nit]?>" name="nit">
                    </td>
                </tr>   
            </table>    
            <div class="subpantallac5" style="height:67.5%; width:99.6%; overflow-x:hidden;">
                <table class="inicio">
                    <tr><td class="titulos" colspan="7">Resultados Cierre</td></tr>
                    <tr>
                        <td class="titulos2">Cuenta</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2">Tercero</td>
                        <td class="titulos2">Nombre Tercero</td>
                        <td class="titulos2">Debito</td>
                        <td class="titulos2">Credito</td>
                        <td class="titulos2">Saldo</td>
                    </tr>    
                    <?php
                        $oculto=$_POST['oculto'];
                        if($_POST[gencom]==1)
                        {
                            //**** creamos tabla temporal para almacenar el comprobante 
                            $sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),tercero varchar(30),cc varchar(4),debito double,credito double)";
                             mysql_query($sqlr,$linkbd);
                            //*****************************************	
                            $_POST[periodo]="0".$_POST[periodo];
                            $_POST[periodo]=substr($_POST[periodo],strlen($_POST[periodo])-2,2);
                            $ultimod=ultimodia($_POST[ages],$_POST[periodo]);
                            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                            $fechaf=$_POST[ages]."-$_POST[periodo]-01";
                            $agetra=$fecha[3];
                            $fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                            $f1=$fechafa2;	
                            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
                            $fechaf2=$_POST[ages]."-$_POST[periodo]-$ultimod";
                            $f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                            //********** calcular saldo inicial ***********
                            $fechafa=$agetra."-01-01";
                            $fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));	
                            $co='saludo1a';
                            $co2='saludo2';
                            $critcons=" and comprobante_det.tipo_comp <> 19 ";	 
                            $tsaldant=0;
                            $totaldebs=0;
                            $totalcreds=0;
                            $totalsaldos=0;	 	 
                            //*******  MOVIMIENTO cuentas 4 5 6 
                            $numctas=count($_POST[dcuentacierre]);
                            for ($x=0;$x<$numctas;$x++)
                            {  
                                $tam=strlen($_POST[dcuentacerrar][$x]);
                                $cuenta=$_POST[dcuentacerrar][$x];
                                $cuentafin=$_POST[dcuentacerrar][$x];
                                $ncuenta=buscacuenta($cuenta);
                                $cuenta2=$_POST[dcuentacierre][$x];
                                $ncuenta2=buscacuenta($cuenta2);	
                                $sqlr="select distinct comprobante_det.cuenta, comprobante_det.tercero, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito),comprobante_det.centrocosto  from comprobante_cab,comprobante_det where comprobante_det.tercero like '%$_POST[tercero]%' and SUBSTR(comprobante_det.cuenta,1,$tam) between '$cuenta' and '$cuentafin' and  comprobante_cab.fecha between 	'$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1'   group by comprobante_det.cuenta, comprobante_det.tercero order by comprobante_det.cuenta, comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                                $res=mysql_query($sqlr,$linkbd);
                                $cuentainicial='';
                                $saldo=0;
                                $i=1;
                                while($row=mysql_fetch_row($res))
                                {	 
                                    $saldo=$row[2]-$row[3];
                                    echo "
                                    <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
                                        <td>$row[0]</td>
                                        <td>".buscacuenta($row[0])."</td>
                                        <td>$row[1]</td>
                                        <td>".buscatercero($row[1])."</td>
                                        <td>$row[2]</td><td>$row[3]</td>
                                        <td>$saldo</td>
                                    </tr>";
                                    if($saldo!=0)
                                    {
                                        if($saldo<0)
                                        {
                                            $sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$row[0]."','".buscacuenta($row[0])."','$row[1]','$row[4]',".abs($saldo).",0)";
                                            mysql_query($sqlr,$linkbd);
                                            $sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta2."','".$ncuenta2."','$_POST[nit]','$row[4]',0,".abs($saldo).")";
                                            mysql_query($sqlr,$linkbd);		 
                                        }
                                        if($saldo>0)
                                        {
                                            $sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta2."','".$ncuenta2."','$_POST[nit]','$row[4]',".abs($saldo).",0)";
                                            mysql_query($sqlr,$linkbd);
                                            $sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$row[0]."','".buscacuenta($row[0])."','$row[1]','$row[4]',0,".abs($saldo).")";
                                            mysql_query($sqlr,$linkbd);		 
                                        }
                                        $i+=1;
                                    }		 	 
                                    $totaldebs+=$row[2];
                                    $totalcreds+=$row[3];
                                    $totalsaldos+=$saldo;
                                    $aux=$co;
                                    $co=$co2;
                                    $co2=$aux;
                                }
                            }
                            echo "
                            <tr class='$co'>
                                <td colspan='4'>Totales:</td>
                                <td>$totaldebs</td>
                                <td>$totalcreds</td>
                                <td>$totalsaldos</td>
                            </tr>"; 	
                        }
                        //****** TRASLADAR LA  CUENTA DEL EJERCICIO
                        if($_POST[gentrasladar]==1)
                        {
                            $sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),tercero varchar(30),cc varchar(4),debito double,credito double)";
                            mysql_query($sqlr,$linkbd);
                            //*****************************************	
                            $_POST[periodo]="0".$_POST[periodo];
                            $_POST[periodo]=substr($_POST[periodo],strlen($_POST[periodo])-2,2);
                            $ultimod=ultimodia($_POST[ages],$_POST[periodo]);
                            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                            $fechaf=$_POST[ages]."-$_POST[periodo]-01";
                            $agetra=$fecha[3];
                            $fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                            $f1=$fechafa2;	
                            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
                            $fechaf2=$_POST[ages]."-$_POST[periodo]-$ultimod";
                            $f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                            //********** calcular saldo inicial ***********
                            $fechafa=$agetra."-01-01";
                            $fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));	
                            $co='zebra1';
                            $co2='zebra2';
                            //*******  MOVIMIENTO cuentas 4 5 6 
                            $repeticiones=array();
                            $numctas=count($_POST[dcuentacierre]);
                            for ($x=0;$x<$numctas;$x++)
                            {  
                                if(!esta_en_array($repeticiones,$_POST[dcuentacierre][$x]))
                                {
                                    $repeticiones[]=$_POST[dcuentacierre][$x];
                                    $tam=count($_POST[dcuentacerrar][$x]);
                                    $cuenta=$_POST[dcuentacerrar][$x];
                                    $cuentafin=$_POST[dcuentacerrar][$x];
                                    $ncuenta=buscacuenta($cuenta);
                                    $cuenta2=$_POST[dcuentacierre][$x];
                                    $ncuenta2=buscacuenta($cuenta2);		 	
                                    $cuenta3=$_POST[dcuentatras][$x];
                                    $ncuenta3=buscacuenta($cuenta3);	
                                    $sqlr="select distinct comprobante_det.cuenta, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito),comprobante_det.centrocosto from comprobante_cab,comprobante_det where comprobante_det.tercero like '%$_POST[tercero]%' and comprobante_det.cuenta between '$cuenta2' and '$cuenta2' and  comprobante_cab.fecha between '$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1'  group by comprobante_det.cuenta,comprobante_det.centrocosto order by comprobante_det.cuenta, comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                                    $res=mysql_query($sqlr,$linkbd);
                                    $cuentainicial='';
                                    $saldo=0;
                                    $i=1;
                                    while($row=mysql_fetch_row($res))
                                    {	 
                                        $saldo=round($row[1]-$row[2],3);
                                        echo "
                                        <tr class='$co'>
                                            <td>$row[0]</td>
                                            <td>".buscacuenta($row[0])."</td>
                                            <td>$_POST[nit]</td>
                                            <td> </td>
                                            <td>".round($row[1],2)."</td>
                                            <td>".round($row[2],2)."</td>
                                            <td>$saldo</td>
                                        </tr>";
                                        if($saldo!=0)
                                        {
                                            if($saldo<0)
                                            {
                                                $sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$row[0]."','".buscacuenta($row[0])."','$_POST[nit]','$row[3]',".abs($saldo).",0)";
                                                mysql_query($sqlr,$linkbd);
                                                $i+=1;
                                                $sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta3."','".$ncuenta3."','$_POST[nit]','$row[3]',0,".abs($saldo).")";
                                                mysql_query($sqlr,$linkbd);		
                                            }
                                            if($saldo>0)
                                            {
                                                $sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta3."','".$ncuenta3."','$_POST[nit]','$row[3]',".abs($saldo).",0)";
                                                mysql_query($sqlr,$linkbd);
                                                $i+=1;
                                                $sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$row[0]."','".buscacuenta($row[0])."','$_POST[nit]','$row[3]',0,".abs($saldo).")";
                                                mysql_query($sqlr,$linkbd);	
                                            }
                                            $i+=1;
                                        }		 	 
                                        $totaldebs+=$row[2];
                                        $totalcreds+=$row[3];
                                        $totalsaldos+=$saldo;
                                        $aux=$co;
                                        $co=$co2;
                                        $co2=$aux;
                                    }
                                }
                            }	 
                        }
                    ?>
                </table> 
            </div>
			<?php
                if($_POST[oculto]==3)
                {
                    $_POST[periodo]="0".$_POST[periodo];
                    $_POST[periodo]=substr($_POST[periodo],strlen($_POST[periodo])-2,2);
                    $ultimod=ultimodia($_POST[ages],$_POST[periodo]);
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                    $fechaf=$_POST[ages]."-$_POST[periodo]-01";
                    $agetra=$fecha[3];
                    $fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                    $f1=$fechafa2;	
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
                    $fechaf2=$_POST[ages]."-$_POST[periodo]-$ultimod";
                    $f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                    //********** calcular saldo inicial ***********
                    $fechafa=$agetra."-01-01";
                    echo "<div class='subpantallac6'>";
                    echo "<table class='inicio'>";
                    //sacar el consecutivo 
                    $sqlr="select max(numerotipo) from comprobante_cab where tipo_comp=31 ";
                    $res=mysql_query($sqlr,$linkbd);
                    while($r=mysql_fetch_row($res)){$maximo=$r[0];}
                    $maximo+=1;	
                    $sqlr="select count(*) from usr_session ";
                    $resc=mysql_query($sqlr,$linkbd); 
                    $rowc=mysql_fetch_row($resc);
                    $valortotal=$rowc[0];
                    $sqlr="insert into comprobante_cab (numerotipo, tipo_comp, fecha, concepto, total,total_debito,total_credito,diferencia,estado) values ('$maximo','31','$fechaf2','CIERRE DE COSTOS TRASLADO DE SALDOS DE COSTOS DE CUENTAS VIGENCIA $_POST[ages] $_POST[periodo]',0,0,0,0,'1')";	
                    if( mysql_query($sqlr,$linkbd))
                    { 
                        $sqlr="select distinct  cuenta, nombrecuenta, tercero,cc,sum(debito),sum(credito) from usr_session group by cuenta,cc";
                        $resc=mysql_query($sqlr,$linkbd); 
                        $i=0;
                        while($rowc=mysql_fetch_row($resc))
                        {
                            $i+=1;
                            echo "
                            <tr class='saludo3'>
                                <td><input type='hidden' name='cuentac[]' value='$rowc[0]'>$rowc[0]</td>
                                <td >$rowc[1]</td><td><input type='hidden' name='terceros[]' value='$rowc[2]'>$rowc[2]</td>
                                <td><input type='hidden' name='cc[]' value='$rowc[3]'>$rowc[3]</td>
                                <td ><input type='hidden' name='debitosc[]' value='$rowc[4]'>$rowc[4]</td>
                                <td ><input type='hidden' name='creditosc[]' value='$rowc[5]'>$rowc[5]</td>
                            </tr>";	 
                            $porcentaje = $i * 100 / $valortotal; 	
                            echo "<script>progres=".round($porcentaje).";callprogress(progres);</script>"; //llamo a la función JS(JavaScript) para actualizar el progreso
                            flush(); //con esta funcion hago que se muestre el resultado de inmediato y no espere a terminar todo el bucle con los 25 registros para recien mostrar el resultado
ob_flush(); 
                            $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('31 $maximo', '$rowc[0]', '$rowc[2]','$rowc[3]','CIERRE DE COSTOS TRASLADO SALDO VIGENCIA $_POST[ages] $_POST[periodo]','',$rowc[4],$rowc[5],'1',$_POST[ages],31,$maximo)";
                            mysql_query($sqlr,$linkbd); 
                        }
                        echo "<script>despliegamodalm('visible','3','Se ha almacenado el Comprobante de Cierre con Exito');</script>";
                    }	
                    else
                    {
                        echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD, No se pudo ejecutar la petición');</script>";
                        $e =mysql_error($respquery);
                    }   
                    echo "</table> </div>";
                }
                if($_POST[oculto]==2)
                {
                    echo"
                    <div class='subpantallac4'>
                        <table class='inicio'>";
                    $_POST[periodo]="0".$_POST[periodo];
                    $_POST[periodo]=substr($_POST[periodo],strlen($_POST[periodo])-2,2);
                    $ultimod=ultimodia($_POST[ages],$_POST[periodo]);
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                    $fechaf=$_POST[ages]."-$_POST[periodo]-01";
                    $agetra=$fecha[3];
                    $fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                    $f1=$fechafa2;	
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
                    $fechaf2=$_POST[ages]."-$_POST[periodo]-$ultimod";
                    $f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                    //********** calcular saldo inicial ***********
                    $fechafa=$agetra."-01-01";
                    $fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));	
                    $sqlr="select count(*) from usr_session ";
                    $resc=mysql_query($sqlr,$linkbd); 
                    $rowc=mysql_fetch_row($resc);
                    $valortotal=$rowc[0];
                    //sacar el consecutivo 
                    $sqlr="select max(numerotipo) from comprobante_cab where tipo_comp=31 ";
                    $res=mysql_query($sqlr,$linkbd);
                    while($r=mysql_fetch_row($res)){$maximo=$r[0];}
                    $maximo+=1;	
                    $sqlr="insert into comprobante_cab (numerotipo, tipo_comp, fecha, concepto, total,total_debito,total_credito,diferencia,estado) values ('$maximo','31','$fechaf2','CIERRE DE COSTOS VIGENCIA $_POST[ages] $_POST[periodo]',0,0,0,0,'1')";	
                    if( mysql_query($sqlr,$linkbd))
                    { 
                        $sqlr="select *from usr_session ";
                        $resc=mysql_query($sqlr,$linkbd); 
                        $i=0;
                        while($rowc=mysql_fetch_row($resc))
                        {
                            $i+=1;
                            $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo) values ('31 $maximo', '$rowc[1]', '$rowc[3]','$rowc[4]','CIERRE DE COSTOS VIGENCIA $_POST[ages]  $_POST[periodo]','',$rowc[5],$rowc[6],'1',$_POST[ages],31,$maximo)";
                            mysql_query($sqlr,$linkbd); 
                            $porcentaje = $i * 100 / $valortotal; 	
                            echo "<script>progres=".round($porcentaje).";callprogress(progres);</script>"; //llamo a la función JS(JavaScript) para actualizar el progreso
                            flush(); //con esta funcion hago que se muestre el resultado de inmediato y no espere a terminar todo el bucle con los 25 registros para recien mostrar el resultado
                            ob_flush(); 
                        }
                        echo "<script>despliegamodalm('visible','3','Se ha almacenado el Comprobante de Cierre con Exito');</script>";
                    }
                    else
                    {
                        echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD, No se pudo ejecutar la petición')</script>;";
                        
                    }
                    echo"</table></div>";
                }
            ?>
  		</form>
	</body>
</html>