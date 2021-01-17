<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
<?php //V 1000 12/12/16 ?> 	
<?php
//***** modificacion cabecera de conciliacion : extracto diferencia  2016-03-07
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
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<script>
			//************* ver reporte ************
			$(window).load(function () { $('#cargando').hide();});
			function buscarconciliar()
			{
				if(document.getElementById('cuenta').value!="-1")
				{
					var validacion01=document.getElementById('fc_1198971545').value;
					var validacion02=document.getElementById('fc_1198971546').value;
					if((validacion01.trim()!='')&&(validacion02.trim()!=''))
					{
						var fechaInicial=validacion01;
        				var fechaFinal=validacion02;
        				if(validate_fechaMayorQue(fechaInicial,fechaFinal)){document.form2.bconc.value=1;document.form2.submit();}
						else
						{despliegamodalm('visible','2',"La fecha final NO es superior a la fecha inicial");}				
					}
					else{despliegamodalm('visible','2',"Falta ingresar una fecha de inicio y una fecha final")}
				}
				else{despliegamodalm('visible','2',"Falta seleccionar una cuenta")}
				
			}
			function checktodos()
			{
				cali=document.getElementsByName('conciliados[]');
				for (var i=0;i < cali.length;i++) 
				{ 
					if (document.getElementById("todos").checked == true){cali.item(i).checked = true;document.getElementById("todos").value=1;	 }
					else{cali.item(i).checked = false;document.getElementById("todos").value=0;}
				}	
				sumarconc();
			}
			//************* genera reporte ************
			function marcar(indice,posicion)
			{
				vvigencias=document.getElementsByName('conciliados[]');
				anterior=document.getElementsByName('conciliadoanterior[]');
				anterior_fecha=document.getElementsByName('conciliadoanterior_fecha[]');
				vtabla=document.getElementById('fila'+indice);
				//clase=vtabla.className;
				ca=anterior.length;
				con=0;
				
				for(y=0;y<ca;y++)
				{	  
					fechacon=anterior_fecha.item(y).value;					
					if(anterior.item(y).value==vvigencias.item(posicion).value && fechacon!='')
					{
						con=con+1;
						fechaconv=anterior_fecha.item(y).value
					}  
				}
				
				if(vvigencias.item(posicion).checked)
				{			
				//alert('M');	
					if(con==0)
					{					
					//vtabla.style.backgroundColor="#3399bb"; 
					//alert('MO');
					}
					else
					{	var menalert="Ya esta conciliado en la fecha "+fechaconv;
						despliegamodalm('visible','2',menalert)
						vvigencias.item(posicion).checked=false;
					}
				}
				else
				{
				//alert('MB');
					e=vvigencias.item(posicion).value;
					//vtabla.style.backgroundColor='#ffffff';
					//document.getElementById('fila'+e).style.backgroundColor='#ffffff';
				}
				
				sumarconc();
			}
			//************* genera reporte ************
			function sumarconc()
			{
				//alert('SM');
				vvigencias=document.getElementsByName('conciliados[]');
				vdebitos=document.getElementsByName('debitos[]');
				vcreditos=document.getElementsByName('creditos[]');
				sumacd=0;
				sumancd=0;
				sumacc=0;
				sumancc=0;
				for (x=0;x<vvigencias.length;x++)
				{
					if(vvigencias.item(x).checked)
					{
						sumacd=sumacd+parseFloat(vdebitos.item(x).value);
						sumacc=sumacc+parseFloat(vcreditos.item(x).value);				
					}
					else
					{
						sumancd=sumancd+parseFloat(vdebitos.item(x).value);		
						sumancc=sumancc+parseFloat(vcreditos.item(x).value);				
					}
				}
				saldofinal=parseFloat(document.form2.saldofin.value); 
				document.form2.ccreditos.value=(sumacc);
				document.form2.ncdebitos.value=(sumancd); 
				document.form2.nccreditos.value=(sumancc); 
				document.form2.cdebitos.value=(sumacd); 
				document.form2.debnc.value=(sumancd); 
				document.form2.crednc.value=Math.round((sumancc),2);       
				document.form2.extracto.value=Math.round((saldofinal+sumancc-sumancd));     
				document.form2.difextracto.value=Math.round((document.form2.extractofis.value-document.form2.extracto.value),2);
			}
			function pdf()
			{
				document.form2.action="pdfconciliacion.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function validar()
			{
				document.form2.bconc.value=1;
				document.form2.action="cont-conciliacion.php";
				document.form2.submit();
			}
			//************* genera reporte ************
			function guardar()
			{
				if(document.getElementById('cuenta').value!="-1")
				{
					if(document.getElementById('extractofis').value!="0")
					{
						var validacion01=document.getElementById('fc_1198971545').value;
						var validacion02=document.getElementById('fc_1198971546').value;
						if((validacion01.trim()!='')&&(validacion02.trim()!='')){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
						else{despliegamodalm('visible','2',"Falta ingresar una fecha de inicio y una fecha final");}
					}
					else
					{
						document.getElementById('extractofis').style.backgroundColor='yellow'
						despliegamodalm('visible','2',"Falta digitar el Saldo Extracto Banco:");
					}
				}
				else{despliegamodalm('visible','2',"Falta seleccionar una cuenta");}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{document.getElementById('ventanam').src="";}
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
					case "1":	document.form2.oculto.value="2";document.form2.submit();break;
					
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		
		<table>
            <tr>
                <script>barra_imagenes("cont");</script>
                <?php cuadro_titulos();?>
            </tr>
            <tr>
                <?php menu_desplegable("cont");?>
            </tr>
            <tr>
                <td colspan="3" class="cinta"> 
					<a onClick="location.href='cont-conciliacion.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a> 
					<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a> 
					<a class="mgbt"><img src="imagenes/buscad.png" title="Buscar" /></a> 
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a onClick="pdf()" class="mgbt"><img src="imagenes/print.png" style="width:29px;height:25px;" title="Imprimir" /></a>
				</td>
            </tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="">
		 	<div class="loading" id="divcarga"><span>Cargando...</span></div>
			<?php
				if($_POST[oculto]==""){echo"<script>document.getElementById('divcarga').style.display='none';</script>";}
				ini_set('max_execution_time', 7200);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if($_POST[ban]=="")
				{
					if(isset($_GET['cod'])){
						if(!empty($_GET['cod'])){
							$_POST[cuenta]=$_GET['cod'];
							$_POST[fecha]=$_GET['fec'];
							$_POST[fecha2]=$_GET['fec1'];
							$_POST[bc]='1';
							$_POST[bconc]='1';
						}
					}		
				}
				/*$sqlr1="select cuentant from tesobancosctas where cuenta='$_POST[cuenta]'";
				$res1=mysql_query($sqlr1,$linkbd);
				$row1=mysql_fetch_row($res1);
				$cuenav=$row1[0];*/ 
                if ($_POST[bconc]=='1')
                {
					if(strpos($_POST[fecha],"/")===true){
						$arregloini=explode("/",$_POST[fecha]);
						$_POST[fecha]=$arregloini[2]."-".$arregloini[1]."-".$arregloini[0];
					}
					if(strpos($_POST[fecha2],"/")===true){
						$arregloini2=explode("/",$_POST[fecha2]);
						$_POST[fecha2]=$arregloini2[2]."-".$arregloini2[1]."-".$arregloini2[0];
					}
                    $_POST[ncdebitos]=0;
                    $_POST[ccreditos]=0;
                    $_POST[nccreditos]=0;
                    $_POST[saldofin]=0;
                    $_POST[saldoini]=0;
                    $_POST[extracto]=0;
                    $_POST[debnc]=0;
                    $_POST[crednc]=0;
                    $_POST[ncompro]=array();
                    $_POST[compro]=array();
                    $_POST[compro2]=array(); 
                    $_POST[dfechas]=array(); 
                    $_POST[dterceros]=array();  
                    $_POST[conciliados]=array();
                    $_POST[detalles]=array();
                    $_POST[debitos]=array();
                    $_POST[creditos]=array();
					$_POST[extractofis]=0;
					$_POST[difextracto]=0;
					
					ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})", $_POST[fecha],$fecha);
                    $fechaf=$fecha[1]."-".$fecha[2]."-".$fecha[3];
                    $agetra=$fecha[1];
                    $fechafa2=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]);
                    $f1=$fechafa2;	
                    ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})", $_POST[fecha2],$fecha);
                    $fechaf2=$fecha[1]."-".$fecha[2]."-".$fecha[3];	
                    $f2=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]);
                    //********** calcular saldo inicial ***********
                    $fechafa=$agetra."-01-01";
                    $fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
                    //***** buscar saldo inicial ***
                    $compinicial=0;
					$sqlr="select *from  conciliacion_cab where cuenta='$_POST[cuenta]' and periodo1='$fechaf' and periodo2='$fechaf2'";
                    $res=mysql_query($sqlr,$linkbd);
                    $saldoperant=0;	
                    while ($row =mysql_fetch_row($res))
					{
					 $_POST[extractofis]=$row[1];
					 $_POST[difextracto]=round($row[3],2);
					}
                    if($fechaf <= $fechafa and $fechaf2 > $fechafa)
                    {
                        /*$sqlr="select comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' and comprobante_cab.tipo_comp='102' AND comprobante_det.cuenta!='' group by comprobante_det.cuenta order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det,comprobante_cab.fecha ";
                        $res=mysql_query($sqlr,$linkbd);
                        $row =mysql_fetch_row($res);
                        $compinicial=$row[1];*/
                    }  	//quitar comentario si desea saldo inicial
                    //*****buscar periodo anterior al de consulta ******
                    //$sqlr="select distinct comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between '$fechafa' and '$fechafa2' and comprobante_det.id_comp=CONCAT(comprobante_cab.tipo_comp,' ',comprobante_cab.numerotipo) and  comprobante_det.vigencia='".$_SESSION[vigencia]."' and comprobante_cab.estado='1' and comprobante_cab.tipo_comp<>'7' group by comprobante_det.cuenta order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                    //***** CONSULTA ANTERIOR A LA ACTUALIZACIONES SISTEMA VIGENCIA
                    //$sqlr="select  comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between '$fechafa' and '$fechafa2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo and  comprobante_cab.estado='1' and comprobante_cab.tipo_comp<>'7' group by comprobante_det.cuenta order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                    $sqlr="select  comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between '' and '$fechafa2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo and  comprobante_cab.estado='1' AND comprobante_det.cuenta!='' order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det,comprobante_cab.fecha";
                    $res=mysql_query($sqlr,$linkbd);
                    $saldoperant=0;	
                    while ($row =mysql_fetch_row($res)){$saldoperant=$row[1];}

				//	echo $saldoperant;
                    $_POST[saldoini]=round($compinicial+$saldoperant,2);
                    $_POST[saldofin]=$_POST[saldoini];	
                    //******* calcular el saldo final ******************
                    //$sqlr="select distinct comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between 	'$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo and  comprobante_det.vigencia='".$_SESSION[vigencia]."' and comprobante_cab.estado='1' and comprobante_cab.tipo_comp<>'7' order by comprobante_cab.fecha,comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                    //***** CONSULTA ANTERIOR A LA ACTUALIZACIONES SISTEMA VIGENCIA
                    //$sqlr="select  comprobante_det.cuenta,sum(comprobante_det.valdebito),sum(comprobante_det.valcredito), comprobante_cab.tipo_comp, comprobante_cab.numerotipo from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between 	'$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo and comprobante_cab.estado='1' and comprobante_cab.tipo_comp<>'7' group by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                    $sqlr="select  comprobante_det.cuenta,sum(comprobante_det.valdebito),sum(comprobante_det.valcredito), comprobante_cab.tipo_comp, comprobante_cab.numerotipo from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between 	'$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo and comprobante_cab.estado='1' and comprobante_cab.tipo_comp<>'7' and comprobante_cab.tipo_comp<>'102' AND comprobante_det.cuenta!='' group by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
                    $res=mysql_query($sqlr,$linkbd);
					//echo $sqlr;
                    $acumd=0;
                    $acumc=0;
                    while ($row =mysql_fetch_row($res)){$acumd+=$row[1];$acumc+=$row[2];}
					$_POST[saldofin]+=$acumd-$acumc;
					$_POST[ban]=1;
                }
            ?>
    		<table  align="center" class="inicio">
            	<tr>
        			<td class="titulos" colspan="10">Conciliacion Bancaria NICSP</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='cont-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
                <tr>
					<td class="saludo3">Saldo Extracto Banco:</td>
					<td style="width:8%"><input id="extractofis" name="extractofis" type="text" style="width:100%" value="<?php echo $_POST[extractofis]?>" onBlur='marcar(0,0)'/></td>
					<td class="saludo3">Fecha Inicial:</td>
        			<td><input name="fecha" type="text" id="fc_1198971545" title="YYYY-MM-DD" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width:70%" onBlur="document.form2.submit();">&nbsp;<a onClick="displayCalendarFor('fc_1198971545');" title="Calendario" style='cursor:pointer;'><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a></td>
        			<td class="saludo3">Fecha Final: </td>
        			<td ><input name="fecha2" type="text" id="fc_1198971546" title="YYYY-MM-DD" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:70%">&nbsp;<a onClick="displayCalendarFor('fc_1198971546');" title="Calendario" style='cursor:pointer;'><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a></td>
        			<td class="saludo3">Diferencia:</td>
					<td style="width:8%"><input id="difextracto" name="difextracto" type="text" style="width:100%" value="<?php echo $_POST[difextracto]?>"/></td>
             	</tr>
                <tr>
					<td class="saludo3" >Cuenta:</td>
          			<td valign="middle" colspan="6" > 
                    	<input type="hidden" name="oculto" id="oculto" value="1" />
						
                        <select id="cuenta" name="cuenta" onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%;">
                            <option value="-1">Seleccione....</option>
                            <?php
								
								ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
								if($fecha[1]=='')
								{
									$fecha[1]='2018';
								}
								if($fecha[1]>'2017')
								{
									$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo, terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' order by tesobancosctas.cuenta";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										if($row[1]==$_POST[cuenta])
										{
											echo "<option value=$row[1] SELECTED>$row[1]-$row[4] $row[2] - Cuenta $row[3]</option>";
											$_POST[nbanco]=$row[4];
											$_POST[ter]=$row[5];
											$_POST[cb]=$row[2];
											$_POST[ncuenta]=$_POST[cuenta];
										}
										else{echo "<option value=$row[1]>$row[1]-$row[4] $row[2] - Cuenta $row[3]</option>";}
									}
								}	
                                else
								{
									$sqlr="select tesobancosctas.estado,tesobancosctas.cuentant,tesobancosctas.ncuentaban,tesobancosctas.tipo, terceros.razonsocial,tesobancosctas.tercero from terceros,tesobancosctas where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' order by tesobancosctas.cuentant";
									
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										if($row[1]==$_POST[cuenta])
										{
											echo "<option value=$row[1] SELECTED>$row[1]-$row[4] $row[2] - Cuenta $row[3]</option>";
											$_POST[nbanco]=$row[4];
											$_POST[ter]=$row[5];
											$_POST[cb]=$row[2];
											$_POST[ncuenta]=$_POST[cuenta];
										}
										else{echo "<option value=$row[1]>$row[1]-$row[4] $row[2] - Cuenta $row[3]</option>";}
									}
								}
                            ?>
                        </select>
          				<input type="hidden" value="0" name="bc"/>
                        <input type="hidden" value="<?php echo $_POST[cb]?>" name="cb"/> 
                        <input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"/>
                 	</td>    
                    <td colspan="1" ><input type="button" style="width:100%" name="generar" value="Conciliar" onClick="buscarconciliar()" ><input type="hidden" value="0" name="bconc" id="bconc">
                    </td>
					<td class="saludo3">Cuenta:</td>
                    <td><input name="ncuenta" id="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" style="width:100%" readonly></td>
					
					
         		</tr>
                <tr>
                	<td class="saludo3">No Conciliados</td>
          			<td style="width:10%">Debitos:</td>
                    <td style="width:10%"><input name="ncdebitos" id="ncdebitos" type="text" value="<?php echo $_POST[ncdebitos]?>" style="width:100%" readonly /></td>
          			<td style="width:10%">Creditos:</td>
                    <td style="width:10%"><input name="nccreditos" id="nccreditos" type="text" style="width:100%" readonly value="<?php echo $_POST[nccreditos]?>"/></td>
                    <td class="saludo3" style="width:8%">Conciliados</td>	
          			<td style="width:10%">Debitos:</td>
                    <td style="width:8%"><input id="cdebitos" name="cdebitos" type="text"  readonly style="width:100%" value="<?php echo $_POST[cdebitos]?>"/></td>
        			<td style="width:10%">Creditos:</td>
                    <td style="width:8%"><input name="ccreditos" id="ccreditos" type="text"  readonly style="width:100%" value="<?php echo $_POST[ccreditos]?>"/></td>
            	</tr>
                <tr>
        			<td  class="saludo3">Saldo I Libros</td>
                    <td><input name="saldoini" id="saldoini" type="text"  readonly value="<?php echo $_POST[saldoini]?>" style="width:100%"></td>
                    <td class="saludo3">Saldo F Libros</td>
                    <td><input name="saldofin" id="saldofin" type="text"  readonly value="<?php echo $_POST[saldofin]?>" style="width:100%"></td>
                    <td class="saludo3">- Debitos NC</td>
                    <td><input name="debnc" id="debnc" type="text"  readonly value="<?php echo $_POST[debnc]?>" style="width:100%"></td>
                    <td class="saludo3">+ Creditos NC</td>
                    <td><input name="crednc" id="crednc" type="text"  readonly value="<?php echo round($_POST[crednc],2)?>" style="width:100%"></td>
        			<td class="saludo3">Saldo Extracto Calc:</td>
        			<td><input name="extracto" id="extracto" type="text" readonly value="<?php echo round($_POST[extracto],2)?>" style="width:100%"><input name='ban' type="hidden" value='<?php echo $_POST[ban]?>'></td>
                    
        		</tr>
            </table>	
    		<?php
				if($_POST[oculto]=='2')
				{					
 					$fec=date("Y-m-d");
 					//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);

					$fechaf=$_POST[fecha]; 
					//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);

					$fechaf2=$_POST[fecha2];				
					$sqlr="delete from conciliacion_cab where cuenta='$_POST[cuenta]' and periodo1 ='$fechaf' and periodo2 ='$fechaf2'";
					mysql_query($sqlr,$linkbd);	
					$sqlr="insert into conciliacion_cab (cuenta,extractobanc,extractocalc,diferencia,fecha,vigencia,periodo1,periodo2) values ('$_POST[cuenta]','$_POST[extractofis]','$_POST[extracto]','$_POST[difextracto]','$fec','$vigusu','$fechaf','$fechaf2')";
					mysql_query($sqlr,$linkbd);	
					for($y=0;$y<count($_POST[detalles]);$y++)
    				{	   
					
	 					$dnc=esta_en_array($_POST[conciliados],$_POST[detalles][$y]);
						
	 					if($dnc!='1')
	   					{
							$sqlr="delete from conciliacion where id_comp='".$_POST[compro][$y]."' and periodo2 between '$fechaf' and '$fechaf2'";
							mysql_query($sqlr,$linkbd);	
	  					}
  						for($x=0;$x<count($_POST[conciliados]);$x++)
   						{	
	  						if($_POST[detalles][$y]==$_POST[conciliados][$x])
	   						{	
								$sqlr="insert into conciliacion (id_comp, cuenta, id_det, valordeb, valorcred,fecha,vigencia,periodo1,periodo2) values ('".$_POST[compro][$y]."','$_POST[cuenta]',".$_POST[conciliados][$x].",".$_POST[debitos][$y].",".$_POST[creditos][$y].",'$fec','".$vigusu."','$fechaf','$fechaf2')";
								
								//echo "<br>".$sqlr;
 								if(!mysql_query($sqlr,$linkbd))
  								{
  									 //echo "<br>ERROR".$sqlr;
 								} 
								else
								{echo"<script>despliegamodalm('visible','3','Se ha Conciliado el detalle ".$_POST[ncompro][$y]." - Id: ".$_POST[conciliados][$x]." con Exitoo');</script>";}
	   						}	 
						}
   					}
					
 				}
			?>
			<div class="subpantallac5" style="height:55.8%; width:99.6%; overflow-x:hidden;">
  			<?php
  				//**** para sacar la consulta del balance se necesitan estos datos ********
  				//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
				if($_POST[banco]!="-1")
				{	
					//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					
					$fecha124= explode("-",$_POST[fecha]);
					$f1=mktime(0,0,0,$fecha124[2],$fecha124[1],$fecha124[0]);	
					//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
					$fecha14= explode("-",$_POST[fecha2]);
					$f2=mktime(0,0,0,$fecha14[2],$fecha14[1],$fecha14[0]);	
					$sumad=0;
					$sumac=0;	
					//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);

					$fechaf=$_POST[fecha];
					//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);

					$fechaf2=$_POST[fecha2];	
	 				$nc=buscacuenta($_POST[cuenta]);
  					echo "
					<table class='inicio' >
						<tr><td colspan='11' class='titulos'>Conciliar Cuentas</td></tr>
						<tr>
							<td class='titulos2'>Id</td>
							<td class='titulos2'>Fecha</td>
							<td class='titulos2'>Tipo Comp</td>
							<td class='titulos2'>Comp</td>
							<td class='titulos2'>CC</td>
							<td class='titulos2'>Tercero</td>
							<td class='titulos2'>Detalle</td>
							<td class='titulos2'>Cheque</td>
							<td class='titulos2'>Debito</td>
							<td class='titulos2'>Credito</td>
							<td class='titulos2'><input id='todos' type='checkbox' name='todos' value='1' onClick='checktodos()' $chekt> Act/Des</td>				
						</tr>";
					//CONCATENAR $sqlr="select distinct * from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between 	'$fechafa' and '$fechaf2' and comprobante_det.id_comp=CONCAT(comprobante_cab.tipo_comp,' ',comprobante_cab.numerotipo) and  comprobante_det.vigencia='".$_SESSION[vigencia]."' and comprobante_cab.estado='1' AND comprobante_cab.tipo_comp <>'7' order by comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
					//**********ANTES DE LA ACT DE VIGENCIAS
					//$sqlr="select  * from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between 	'$fechafa' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' AND comprobante_cab.tipo_comp <>'7' group by comprobante_det.id_det  order by comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det ";
					//$sqlr="select  * from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between 	'' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' AND comprobante_cab.tipo_comp <>'7' group by comprobante_det.id_det  order by comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det ";  actual usado 2016
					if($_POST[fecha]!='2018-01-01')
						$ajusteConvergencia=" AND comprobante_cab.tipo_comp <>'104' ";
					$sqlr="select  comprobante_cab.id_comp,comprobante_cab.numerotipo,comprobante_cab.tipo_comp,comprobante_cab.fecha,comprobante_cab.concepto,comprobante_det.id_det,	comprobante_det.cuenta,comprobante_det.tercero,comprobante_det.centrocosto,comprobante_det.cheque,sum(comprobante_det.valdebito),sum(comprobante_det.valcredito) from comprobante_cab,comprobante_det where comprobante_det.cuenta='$_POST[cuenta]' and  comprobante_cab.fecha between 	'' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' AND comprobante_cab.tipo_comp <>'7' AND comprobante_cab.tipo_comp <>'102' AND comprobante_cab.tipo_comp <>'103'".$ajusteConvergencia." group by comprobante_det.tipo_comp, comprobante_det.numerotipo  order by comprobante_cab.fecha"; //***** nueva version
					//echo $sqlr;
					$res=mysql_query($sqlr,$linkbd);
 					$i=0;
 					$iter="zebra1";
 					$iter2="zebra2";
					while($row=mysql_fetch_row($res))
 					{	 	 
	 					$sqlr="select *from tipo_comprobante where codigo=$row[2]";
	 					$res2=mysql_query($sqlr);
	 					$row2=mysql_fetch_row($res2);
	 					$chk="";
	 					$fecon="";
						$concant="";
	 					$ch=esta_en_array($_POST[conciliados], $row[5]);
						if($ch==1){$chk="checked";}
						else{
						$chk="";
						}
						ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $row[3],$fecha);
						$fcc=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]); 
						//if($concnulas==0)
	  					//{
							//****buscar en la tabla de conciliados 
						$sqlr="select count(*),periodo2 from conciliacion where id_comp='$row[2] $row[1]' and cuenta='$_POST[cuenta]' AND periodo2 between '$fechaf' and '$fechaf2'";
						//echo $sqlr;
						$vc=0;
						//$sqlr="select count(*),periodo2 from conciliacion where id_comp like '$row[2] $row[1]' and cuenta='$_POST[cuenta]' AND periodo2 between '$fechaf' and '$fechaf2'";
						
	 					$res3=mysql_query($sqlr);
	 					$row3=mysql_fetch_row($res3);
						$vc=$row3[0];
						$ncc='';
						if($vc>=1 ){
						$chk="checked";
						$ncc='S';
						$fecon=$row3[1];
						}
						else
			 			{
						$fecon="";
			  				if ($f1<$fcc){$ncc='S';}
				 			else
							{
								if ($row3[0]==0){$ncc='S';}
					 			else{$ncc='N';}
							}
				 			//$sqlr="select count(*),periodo2 from conciliacion where id_det=$row[5] and cuenta='$_POST[cuenta]' AND periodo2 between '' and '$fechaf'"; 		 
							$sqlr="select count(*),periodo2 from conciliacion where id_comp like '$row[2] $row[1]' and cuenta='$_POST[cuenta]' AND periodo2 between '' and '$fechaf'"; 
				 			$res4=mysql_query($sqlr);
				 			$row4=mysql_fetch_row($res4);
				 			if($row4[0]>0){$ncc='N';}			 				
						} 
	 					$nt=buscatercero($row[7]);	 
	 					if($ncc=='S') 
	  					{
  							echo "
							<tr id='fila$row[10]' class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
  								<td>$row[5]</td>
  								<td>$row[3]<input type='hidden' name='dfechas[]' value='$row[3]'></td>
  								<td>$row2[1] <input type='hidden' name='ncompro[]' value='$row2[1]'></td>
  								<td>$row[1]<input type='hidden' name='compro[]' value='$row[2] $row[1]'><input type='hidden' name='compro2[]' value='$row[1]'></td>
  								<td>$row[8]</td>
  								<td>".substr($nt,0,50)."<input type='hidden' name='dterceros[]' value='$nt'></td>
  								<td>".substr($row[4],0,50)."</td>
  								<td>$row[9]</td>
  								<td style='text-align:right;'>".number_format($row[10],2)." <input type='hidden' name='debitos[]' value='$row[10]'></td>
  								<td style='text-align:right;'>".number_format($row[11],2)." <input type='hidden' name='creditos[]' value='$row[11]'></td>
 								<td><input type='hidden' name='detalles[]' value='$row[5]'><input type='checkbox' name='conciliados[]' value='$row[5]' $chk onClick='marcar($row[5],$i);' class='defaultcheckbox'> ";
  								if($chk!="" and $chk!=NULL){echo "<img src='imagenes/confirm2.png' style='width:14px' title='Conciliado'> $fecon ";}
   								else 
								{ 
								$concant=0;
	   								$concant=buscaconciliacion($row[2], $row[1],$fechafa,$fechaf2,$_POST[cuenta]);
									$feconc=buscaconciliacion_fecha($row[2], $row[1],$fechafa,$fechaf2,$_POST[cuenta]);					
									if($concant>=1)
		 							{
										echo "<input type='hidden' name='conciliadoanterior[]'  value='$row[5]'>";
										echo "<input type='text' name='conciliadoanterior_fecha[]' class='inpnovisibles' size='10'  value='$feconc' readonly>";
									}		
	   							}
	     						$aux=$iter;
         						$iter=$iter2;
         						$iter2=$aux;
   								echo "</td></tr>";
 								$sumad+=$row[10];
								$sumac+=$row[11];
								$i+=1;
							}
  			 			}
 					//}
 					echo "<tr><td colspan='7'></td><td>Totales:</td><td class='saludo3'  style='text-align:right;'>$".number_format($sumad,2)."<input type='hidden' name='tdebito' value='$sumad'></td><td class='saludo3' style='text-align:right;'>$".number_format($sumac,2)."<input type='hidden' name='tcredito' value='$sumac'></td></tr>";
					echo"</table>";
					 echo"<script> sumarconc();</script> <script>document.getElementById('divcarga').style.display='none';</script>";
					 
				}
			?> 
		</div>
</form>

</body>
</html>