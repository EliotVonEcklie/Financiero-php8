<?php
    ini_set('max_execution_time',36000);
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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				if ((document.getElementById('ages').value!=""))
                {
					if(document.getElementById('oculto2').value=="1"){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else {despliegamodalm('visible','2','Se debe "Generar" primero');}
				}
				else {despliegamodalm('visible','2','Debe ingresar Vigencia ');}
			}
			function buscactac(e){if (document.form2.cuentamiles.value!=""){document.form2.bcc.value='1';document.form2.submit();}}
			function buscactace(e){if (document.form2.cuentac.value!=""){document.form2.bcce.value='1';document.form2.submit();}}
			function buscactacd(e){if (document.form2.cuentac.value!=""){document.form2.bccd.value='1';document.form2.submit();}}
			function generar()
			{
				if ((document.getElementById('ages').value!=""))
                {
					if ((document.getElementById('cc').value!=""))
					{
						document.getElementById('oculto2').value="1";
						document.form2.gencom.value=1; 
						document.form2.oculto.value=1; 
						document.form2.submit(); 
					}
					else {despliegamodalm('visible','2','Debe ingresar centro de costo ');}
				}
				else {despliegamodalm('visible','2','Debe ingresar Vigencia ');}
			}
			function trasladarctas()
			{
				if(document.getElementById('oculto2').value=="2")
				{
					document.form2.gencom.value=0; 
					document.form2.gentrasladar.value=1; 
					document.form2.oculto.value=0; 
					document.form2.submit(); 
				}
				else {despliegamodalm('visible','2','Debe cerrar cuentas primero');}
			}
			function trasladarctas2()
			{
				if(document.getElementById('oculto2').value=="2")
				{
					document.form2.gencom.value=0; 
					document.form2.gentrasladar.value=1; 
					document.form2.oculto.value=3; 
					document.form2.submit(); 
				}
				else {despliegamodalm('visible','2','Debe cerrar cuentas primero');}
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
					case "1":	document.getElementById('oculto2').value="2";
								document.form2.oculto.value=2;
				  				document.form2.submit();
								break;
				}
			}
			function reseteo(){document.getElementById('oculto2').value="";}
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
					<a href="#" class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png"  title="Guardar" /></a>
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
			$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_EXCEDENTE'";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) 
			{
	 			$_POST[cuentautilidad]=$row[0];
	 			$_POST[ncuentautilidad]=buscacuenta($_POST[cuentautilidad]);
			}
			//**** deficit
			$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_DEFICIT'";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) 
			{
	 			$_POST[cuentacierredef]=$row[0];
	 			$_POST[ncuentacierredef]=buscacuenta($_POST[cuentacierredef]);
			}
			//**** resultado
			$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CIERRE_EJERCICIO'";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) 
			{
	 			$_POST[cuentacierre]=$row[0];
	 			$_POST[ncuentacierre]=buscacuenta($_POST[cuentacierre]);
			}
			$_POST[tipocc]="";
		?>
    	<form name="form2" method="post" action="cont-cierreresultados.php">
    		<div id="progreso" class="ProgressBar" style="display:none">
      			<div class="ProgressBarText"><span id="getprogress"></span>&nbsp;% completado</div>
      			<div id="getProgressBarFill"></div>
    		</div>
    		<table class="inicio" >     
     			<tr>
        			<td class="titulos" colspan="5">:: Cierre de Resultados</td>
        			<td class="cerrar" style="width:7%;"><a href="cont-principal.php">Cerrar</a></td>
      			</tr>
      			<tr>
      				<td class="saludo1" style="width:12%;">:: Vigencia Cierre:</td>
      				<td style="width:8%;">
                    	<select name="ages" id="ages" onChange="reseteo();" style="width:100%;">
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
	           		<td class="saludo1" style="width:10%;">Centro Costo:</td>
	  				<td style="width:25%;">
						<select name="cc" id="cc" onKeyUp="return tabular(event,this)" onChange="reseteo();" style="width:100%;">
                            <option value="" >Seleccione...</option>
                            <?php
                                $sqlr="select *from centrocosto where estado='S'";
                                $res=mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($res)) 
                                {
                                    if($row[0]==$_POST[cc])
                                    {
                                        echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
                                        $_POST[tipocc]=$row[3];
                                    }
                                    else {echo "<option value='$row[0]' >$row[0] - $row[1]</option>";}
                                }	 	
                            ?>
   						</select>
                        <input type="hidden" name="tipocc" value='<?php echo $_POST[tipocc]?>'>
					</td>
					<td colspan="2">
	   					<input type="hidden" value="<?php echo $_POST[oculto]?>" name="oculto">
                        <input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2]?>"/>
                        <input type="hidden" value="<?php echo $_POST[gencom]?>" name="gencom"> 
                        <input type="hidden" value="<?php echo $_POST[gentrasladar]?>" name="gentrasladar">
                        <input type="button" name="genera" value=" Generar " onClick="generar()"> 
                        <input type="button" name="contabiliza" value=" Cerrar Cuentas " onClick="guardar()"> 
                        <input type="button" name="calcular" value=" Calcular Resultado" onClick="trasladarctas()"> 
                        <input type="button" name="trasladar" value=" Trasladar Resultado" onClick="trasladarctas2()">
                        <input id="cuentautilidad" name="cuentautilidad" type="hidden" value="<?php echo $_POST[cuentautilidad]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactacu(event)"  onClick="document.getElementById('cuentautilidad').focus();document.getElementById('cuentautilidad').select();">
 						<input type="hidden" value="" name="bcce">
  						<input id="ncuentautilidad"  name="ncuentautilidad" type="hidden" value="<?php echo $_POST[ncuentautilidad]?>" size="80" readonly>
        				<input id="cuentacierredef" name="cuentacierredef" type="hidden" value="<?php echo $_POST[cuentacierredef]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactaci(event)"  onClick="document.getElementById('cuentacierredef').focus();document.getElementById('cuentacierredef').select();">
        				<input type="hidden" value="" name="bccde">
                        <input id="ncuentacierredef"  name="ncuentacierredef" type="hidden" value="<?php echo $_POST[ncuentacierredef]?>" size="80" readonly>
                        <input id="cuentacierre" name="cuentacierre" type="hidden" value="<?php echo $_POST[cuentacierre]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactaci(event)"  onClick="document.getElementById('cuentacierre').focus();document.getElementById('cuentacierre').select();">
        				<input type="hidden" value="" name="bccd">
                        <input id="ncuentacierre"  name="ncuentacierre" type="hidden" value="<?php echo $_POST[ncuentacierre]?>" size="80" readonly>  						<input type="hidden" value="<?php echo $_POST[nit]?>" name="nit">
                 	</td>
        		</tr>   
    		</table>    
			<?php
                echo"
                <div class='subpantallac5' style='height:67.5%; width:99.6%; overflow-x:hidden;'>
                    <table class='inicio'>
                        <tr><td class='titulos' colspan='7'>Resultados Cierre</td></tr>
                        <tr>
                            <td class='titulos2'>Cuenta</td>
                            <td class='titulos2'>Nombre Cuenta</td>
                            <td class='titulos2'>Tercero</td>
                            <td class='titulos2'>Nombre Tercero</td>
                            <td class='titulos2'>Debito</td>
                            <td class='titulos2'>Credito</td>
                            <td class='titulos2'>Saldo</td>
                        </tr>";
                if($_POST[bcc]!='')
                {
                    $nresul=buscacuenta($_POST[cuentamiles]);
                    if($nresul!='')
                    {
                        $_POST[ncuentamiles]=$nresul;
                        echo "<script> document.getElementById('bcc').value='';</script>";
                    }
                    else
                    {
                        $_POST[ncuentamiles]="";
                        echo "<script>alert('Cuenta Incorrecta');document.form2.cuentamiles.focus();</script>";
                    }
                } 
                if($_POST[bcce]!='')
                {
                    $nresul=buscacuenta($_POST[cuentautilidad]);
                    if($nresul!='')
                    {
                        $_POST[ncuentautilidad]=$nresul;
                        echo "<script>document.getElementById('bcce').value='';</script>";
                    }
                    else
                    {
                        $_POST[ncuentautilidad]="";
                        echo "<script>alert('Cuenta Incorrecta');document.form2.cuentautilidad.focus();</script>";
                    }
                } 		
                if($_POST[bccd]!='')
                {
                    $nresul=buscacuenta($_POST[cuentacierre]);
                    if($nresul!='')
                    {
                        $_POST[ncuentacierre]=$nresul;
                        echo "<script>document.getElementById('bccd').value='';</script>";
                    }
                    else
                    {
                        $_POST[ncuentacierre]="";
                        echo "<script>alert('Cuenta Incorrecta');document.form2.cuentacierre.focus();</script>";
                    }
                } 			  
                if($_POST[bccde]!='')
                {
                    $nresul=buscacuenta($_POST[cuentacierredef]);
                    if($nresul!='')
                    {
                        $_POST[ncuentacierredef]=$nresul;
                        echo "<script>document.getElementById('bccde').value='';</script>";
                    }
                    else
                    {
                        $_POST[ncuentacierredef]="";
                        echo "<script>alert('Cuenta Incorrecta');document.form2.cuentacierredef.focus();</script>";
                    }
                } 			  
                $oculto=$_POST['oculto'];
                if($_POST[gencom]==1)
                {
                    $critcons="";
                    if($_POST[tipocc]=='N'){$critcons="";$ccc=$_POST[cc];}
                    else
                    {
                        $sqlrcc="select id_cc from centrocosto where entidad='N'";
                        $rescc=mysql_query($sqlrcc,$linkbd);
                        while($rowcc=mysql_fetch_row($rescc))
                        { 
                            $critcons.=" and comprobante_det.centrocosto <> '$rowcc[0]' ";	 
                            $ccc='01';
                        }
                    }	 
                    //**** creamos tabla temporal para almacenar el comprobante 
                    $sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),tercero varchar(30),cc varchar(4),debito double,credito double)";
                    mysql_query($sqlr,$linkbd);
                    //*****************************************	
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                    $fechaf=$_POST[ages]."-01-01";
                    $agetra=$fecha[3];
                    $fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                    $f1=$fechafa2;	
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
                    $fechaf2=$_POST[ages]."-12-31";
                    $f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                    //********** calcular saldo inicial ***********
                    $fechafa=$agetra."-01-01";
                    $fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));	
                    $co='saludo1a';
                    $co2='saludo2';
                    $tsaldant=0;
                    $totaldebs=0;
                    $totalcreds=0;
                    $totalsaldos=0;	 	 
                    //*******  MOVIMIENTO cuentas 4 5 6 
                    $cuenta="4";
                    $cuentafin="699999999999999999";
                    $ncuenta=buscacuenta($cuenta);
                    $cuenta2=$_POST[cuentacierre];
                    $ncuenta2=buscacuenta($cuenta2);	
                    $sqlr="select distinct comprobante_det.cuenta, comprobante_det.tercero, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito),comprobante_det.centrocosto from comprobante_cab,comprobante_det where comprobante_det.tercero like '%$_POST[tercero]%' and comprobante_det.cuenta between '$cuenta' and '$cuentafin' and  comprobante_cab.fecha between '$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and comprobante_cab.tipo_comp<>13 and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1'  AND comprobante_det.centrocosto like '%$_POST[cc]%' $critcons  group by comprobante_det.cuenta, comprobante_det.tercero order by comprobante_det.cuenta, comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                    //$sqlr="select distinct comprobante_det.cuenta, comprobante_det.tercero, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito),comprobante_det.centrocosto from comprobante_cab,comprobante_det where comprobante_det.tercero like '%$_POST[tercero]%' and comprobante_det.cuenta between '$cuenta' and '$cuentafin' and  comprobante_cab.fecha between '$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and comprobante_cab.tipo_comp<>13 and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1'    group by comprobante_det.cuenta, comprobante_det.tercero order by comprobante_det.cuenta, comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";



                    $res=mysql_query($sqlr,$linkbd);
                    $cuentainicial='';
                    $saldo=0;
                    $i=1;
					//echo $sqlr;
                    while($row=mysql_fetch_row($res))
                    {	 
                        $saldo=$row[2]-$row[3];
                        echo "
                        <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
                            <td>$row[0]</td>
                            <td>".buscacuenta($row[0])."</td>
                            <td>$row[1]</td>
                            <td>".buscatercero($row[1])."</td>
                            <td>$row[2]</td>
                            <td>$row[3]</td><td>$saldo</td>
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
                                $sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$row[0]."','".buscacuenta($row[0])."','$nit','$row[4]',0,".abs($saldo).")";
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
					  echo "
                    <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
                        <td colspan='4'>Totales:</td>
                        <td>$totaldebs</td>
                        <td>$totalcreds</td>
                        <td>$totalsaldos</td>
                    </tr>"; 		
                }
                //****** TRASLADAR LA  CUENTA DEL EJERCICIO
                if($_POST[gentrasladar]==1)
                {
                    $critcons="";
                    if($_POST[tipocc]=='N'  ){$critcons="";$ccc=$_POST[cc];}
                    else
                    {
                        $sqlrcc="select id_cc from centrocosto where entidad='N'";
                        $rescc=mysql_query($sqlrcc,$linkbd);
                        while($rowcc=mysql_fetch_row($rescc))
                        { 
                            $critcons.=" and comprobante_det.centrocosto <> '$rowcc[0]' ";	 
                            $ccc='01';
                        }
                    }	 
                    $sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),tercero varchar(30),cc varchar(4),debito double,credito double)";
                    mysql_query($sqlr,$linkbd);
                    //*****************************************	
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                    $fechaf=$_POST[ages]."-01-01";
                    $agetra=$fecha[3];
                    $fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                    $f1=$fechafa2;	
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
                    $fechaf2=$_POST[ages]."-12-31";
                    $f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
                    //********** calcular saldo inicial ***********
                    $fechafa=$agetra."-01-01";
                    $fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));	
                    $co='saludo1a';
                    $co2='saludo2';
                    //*******  MOVIMIENTO cuentas 4 5 6 
                    $cuenta=$_POST[cuentacierre];
                    $cuentafin=$_POST[cuentacierre];
                    $ncuenta=buscacuenta($cuenta);
                    $cuenta2=$_POST[cuentautilidad];
                    $ncuenta2=buscacuenta($cuenta2);	
                    $cuenta3=$_POST[cuentacierredef];
                    $ncuenta3=buscacuenta($cuenta3);	
                    $sqlr="select distinct comprobante_det.cuenta, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito), comprobante_det.centrocosto from comprobante_cab,comprobante_det where comprobante_det.tercero like '%$_POST[tercero]%' and comprobante_det.cuenta between '$cuenta' and '$cuentafin' and  comprobante_cab.fecha between 	'$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' AND comprobante_det.centrocosto like '%$_POST[cc]%' group by comprobante_det.cuenta, comprobante_det.tercero order by comprobante_det.cuenta, comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                    $res=mysql_query($sqlr,$linkbd);
                    $cuentainicial='';
                    $saldo=0;
                    $i=1;
                    while($row=mysql_fetch_row($res))
                    {	 
                        $saldo=round($row[1]-$row[2],3);
                        echo "
                        <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
                            <td>$row[0]</td>
                            <td>".buscacuenta($row[0])."</td>
                            <td>$_POST[nit]</td>
                            <td></td>
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
                                $sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta2."','".$ncuenta2."','$_POST[nit]','$row[3]',0,".abs($saldo).")";
                                mysql_query($sqlr,$linkbd);		 
                            }
                            if($saldo>0)
                            {
                                $sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta3."','".$ncuenta3."','$_POST[nit]','$row[3]',".abs($saldo).",0)";
                                mysql_query($sqlr,$linkbd);
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
				echo"</table></div>";
				if($_POST[oculto]==3)
				{
					echo "
					<div class='subpantallac6'>
						<table class='inicio'>";
					//sacar el consecutivo 
					$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp=13 ";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res)){$maximo=$r[0];}
					$maximo+=1;	
					$sqlr="select count(*) from usr_session ";
  					$resc=mysql_query($sqlr,$linkbd); 
					$rowc=mysql_fetch_row($resc);
					$valortotal=$rowc[0];
					$sqlr="insert into comprobante_cab (numerotipo, tipo_comp, fecha, concepto, total,total_debito,total_credito,diferencia,estado) values ('$maximo','13','$fechaf2','TRASLADO DE SALDOS DE CUENTAS DE UTILIDAD-PERDIDA VIGENCIA $_POST[ages]',0,0,0,0,'1')";	
 					if( mysql_query($sqlr,$linkbd))
  					{ 
  						$sqlr="select *from usr_session ";
  						$resc=mysql_query($sqlr,$linkbd);
  						$i=0;
	  					while($rowc=mysql_fetch_row($resc))
	   					{
		   					$i+=1;
	  						echo "<tr class='saludo3'><td ><input type='hidden' name='cuentac[]' value='$rowc[1]'>$rowc[1]</td><td >$rowc[2]</td><td><input type='hidden' name='terceros[]' value='$rowc[3]'>$rowc[3]</td><td><input type='hidden' name='ccos[]' value='$rowc[4]'>$rowc[4]</td><td ><input type='hidden' name='debitosc[]' value='$rowc[5]'>$rowc[5]</td><td ><input type='hidden' name='creditosc[]' value='$rowc[6]'>$rowc[6]</td></tr>";	 
	   						$porcentaje = $i * 100 / $valortotal; 	
	   						echo "<script>progres=".round($porcentaje).";callprogress(progres);</script>";//llamo a la funci�n JS(JavaScript) para actualizar el progreso
 							flush(); //con esta funcion hago que se muestre el resultado de inmediato y no espere a terminar todo el bucle con los 25 registros para recien mostrar el resultado
 							ob_flush(); 
	  						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo) values ('13 $maximo', '$rowc[1]', '$rowc[3]','$rowc[4]','TRASLADO SALDO VIGENCIA $_POST[ages]','',$rowc[5],$rowc[6], '1',$_POST[ages],13,$maximo)";
	  						mysql_query($sqlr,$linkbd); 
	   					}
		  				echo "<script>despliegamodalm('visible','3','Se ha almacenado el Comprobante de Cierre con Exito');</script>";
 					}
  					else
  					{
	  					echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD, No se pudo ejecutar la petici�n');</script>";
						$e =mysql_error($respquery);
  					}   
					echo "</table></div>";
				}
				if($_POST[oculto]==2)
				{
					echo "
					<div class='subpantallac4'>
						<table class='inicio'>";
					$sqlr="select count(*) from usr_session ";
  					$resc=mysql_query($sqlr,$linkbd); 
					$rowc=mysql_fetch_row($resc);
					$valortotal=$rowc[0];
					//sacar el consecutivo 
					$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp=13 ";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res)){$maximo=$r[0];}
					$maximo+=1;	
					$sqlr="insert into comprobante_cab (numerotipo, tipo_comp, fecha, concepto, total,total_debito,total_credito,diferencia,estado) values ('$maximo','13','$fechaf2','CIERRE DE CUENTAS DE RESULTADOS VIGENCIA $_POST[ages]',0,0,0,0,'1')";	
 					if( mysql_query($sqlr,$linkbd))
  					{ 
						$sqlr="select *from usr_session ";
  						$resc=mysql_query($sqlr,$linkbd); 
	    				$i=0;
	 			 		while($rowc=mysql_fetch_row($resc))
	   					{
							$i+=1;
	  						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo) values ('13 $maximo', '$rowc[1]', '$rowc[3]','$rowc[4]','CIERRE DE CUENTAS DE RESULTADOS VIGENCIA $_POST[ages]','',$rowc[5],$rowc[6],'1',$_POST[ages],13,$maximo)";
	  						mysql_query($sqlr,$linkbd); 
	  						$porcentaje = $i * 100 / $valortotal; 	
	   						echo "<script>progres=".round($porcentaje).";callprogress(progres);</script>"; //llamo a la funci�n JS(JavaScript) para actualizar el progreso
 							flush(); //con esta funcion hago que se muestre el resultado de inmediato y no espere a terminar todo el bucle con los 25 registros para recien mostrar el resultado
 							ob_flush(); 
	   					}
	  					echo "<script>despliegamodalm('visible','3','Se ha almacenado el Comprobante de Cierre con Exito');</script>";
  					}
  					else
  					{
	  					echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD, No se pudo ejecutar la petici�n');</script>";
		 				$e =mysql_error($respquery);
  					}
					echo "</table></div>";
				}
			?>
  		</form>
	</body>
</html>