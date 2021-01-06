<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE  6
	date_default_timezone_set("America/Bogota");
	$_POST[oculto2]=$_GET[oculto2];
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid - Presupuesto</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
        <script>
		$(window).load(function () {
				$('#cargando').hide();
			});
			function buscar()
			{
				var fechaini = document.getElementById("fechaini").value;
				var fechafin = document.getElementById("fechafin").value;
				
				if(fechaini!='' && fechafin!=''){
					document.form2.oculto.value='3';
					document.form2.submit(); 
				}else{
					despliegamodalm('visible','2','Debe existir una fecha inicial y una fecha final');
				}
				
			}
			
			function reflejar(){
				var numrecaudos = document.getElementsByName("recaudocc[]");
				if(numrecaudos.length >0){
					document.form2.oculto.value='2';
					document.form2.submit(); 
				}else{
					despliegamodalm('visible','2','No existen recibos para reflejar');
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
								break;
				}
			}
			
        </script>
		<?php titlepag();?>
		 
	</head>
	<body>
		<div id="cargando" style=" position:absolute;left: 40%; bottom: 45%">
			<img src="imagenes/cargando.gif" style=" width: 250px; height: 20px"/>
		</div>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("adm");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
				<a href="presu-reflejarrecibosmasivo.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guarda.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('adm-principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a><a href="adm-comparacomprobantes-presu.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
         	</tr>	
		</table>
		
		 <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		
 		<form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">  
			<input type="hidden" name="cuentacaja" value="<?php echo $_POST[cuentacaja]?>" />
			<input type="hidden" name="cobrorecibo" value="<?php echo $_POST[cobrorecibo]?>" >
			<input type="hidden" name="vcobrorecibo" value="<?php echo $_POST[vcobrorecibo]?>" >
 			<input type="hidden" name="tcobrorecibo" value="<?php echo $_POST[tcobrorecibo]?>" > 
			<input type="hidden" name="vigencia" value="<?php echo $_POST[vigencia]?>" >
			<input type="hidden" name="ncomp" id="ncomp" value="<?php echo $_POST[ncomp]?>"/>
			<input type="hidden" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>"/>
			<input type="hidden" name="idrecaudo" id="idrecaudo" value="<?php echo $_POST[idrecaudo]?>"/>
			<input type="hidden" name="tiporec" id="tiporec" value="<?php echo $_POST[tiporec]?>"/>
			<input type="hidden" name="modorec" id="modorec" value="<?php echo $_POST[modorec]?>"/>
			<input type="hidden" name="codcatastral"  value="<?php echo $_POST[codcatastral]?>" >
			<input type="hidden" name="tipo"  value="<?php echo $_POST[tipo]?>" >
			<input type="hidden" name="encontro"  value="<?php echo $_POST[encontro]?>" >
			<input type="hidden" name="cuotas"  value="<?php echo $_POST[cuotas]?>" >
			<input type="hidden" name="tcuotas"  value="<?php echo $_POST[tcuotas]?>" >
			<input type="hidden" name="concepto"  value="<?php echo $_POST[concepto]?>" >
			<input type="hidden" name="valorecaudo"  value="<?php echo $_POST[valorecaudo]?>" >
			<input type="hidden" name="totalc"  value="<?php echo $_POST[totalc]?>" >
			<input type="hidden" name="tercero"  value="<?php echo $_POST[tercero]?>" >
			<input type="hidden" name="fecha"  value="<?php echo $_POST[fecha]?>" >
			<input type="hidden" name="banco"  value="<?php echo $_POST[banco]?>" >
			<input type="hidden" name="estadoc"  value="<?php echo $_POST[estadoc]?>" >
			<input type="hidden" name="trec"  value="<?php echo $_POST[trec]?>" >
			<input type="hidden" name="totalcf"  value="<?php echo $_POST[totalcf]?>" >
			<input type="hidden" name="vguardar"  value="<?php echo $_POST[vguardar]?>" >
			<input type="hidden" name="numero"  value="<?php echo $_POST[numero]?>" >
			<input type="hidden" name="valor"  value="<?php echo $_POST[valor]?>" >
			<input type="hidden" name="fechacausa"  value="<?php echo $_POST[fechacausa]?>" >
			<input type="hidden" name="descuenindus"  value="<?php echo $_POST[descuenindus]?>" >
			<input type="hidden" name="descunidos"  value="<?php echo $_POST[descunidos]?>" >
			<input type="hidden" name="descuenaviso"  value="<?php echo $_POST[descuenaviso]?>" >
			<input type="hidden" name="descuenbombe"  value="<?php echo $_POST[descuenbombe]?>" >
				<?php
			
			function obtenerTipoPredio($catastral){
				$tipo="";
				$digitos=substr($catastral,1,2);
				if($digitos=="00"){$tipo="rural";}
				else {$tipo="urbano";}
				return $tipo;
			} 
			
			function buscanumcuenta($ncod,$fechaf)
			{
				$linkbd=conectar_bd();
				$sqlr="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$ncod' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$ncod' AND tipo='C' AND fechainicial<='$fechaf')";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
				{
					if($row[3]=='N')
					{
						if($row[7]=='N'){$cuenta=$row[4];}
					}
				}
				return $cuenta;
			}
					
			?>
			<?php
				$iter='saludo1b';
				$iter2='saludo2b';
			?>
			<table width="100%" align="center"  class="inicio" >
                <tr>
                    <td class="titulos" colspan="9">:: Buscar .: Recibos de Caja </td>
                    <td class="cerrar" style='width:7%' onClick="location.href='cont-principal.php'">Cerrar</td>
                    <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]; ?>">
                    <input type="hidden" name="iddeshff" id="iddeshff" value="<?php echo $_POST[iddeshff];?>">	 
                </tr>                       
                <tr>
                    <td  class="saludo1" >Fecha Inicial: </td>
                    <td><input type="search" name="fechaini" id="fechaini" title="YYYY/MM/DD"  value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px" onClick="displayCalendarFor('fechaini');" class="icobut" title="Calendario"></td>
                    <td  class="saludo1" >Fecha Final: </td>
                    <td ><input type="search" name="fechafin" id="fechafin" title="YYYY/MM/DD"  value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px" onClick="displayCalendarFor('fechafin');"  class="icobut" title="Calendario"></td>  
                    
					<td style=" padding-bottom: 0em"><em class="botonflecha" onClick="buscar()">Buscar</em></td>
					<td style=" padding-bottom: 0em"><em class="botonflecha" onClick="reflejar()">Reflejar</em></td>
                </tr>
			</table>
			
			<?php
				
				if($_POST[oculto]==3){
					//Variables ocultas para información de tablas
					unset($_POST[recaudocc]);
					unset($_POST[conceptocc]);
					unset($_POST[valtotaltescc]);
					unset($_POST[valtotalcontcc]);
					unset($_POST[diferenciacc]);
					
					$_POST[recaudocc]= array_values($_POST[recaudocc]); 
					$_POST[conceptocc]= array_values($_POST[conceptocc]); 
					$_POST[valtotaltescc]= array_values($_POST[valtotaltescc]); 
					$_POST[valtotalcontcc]= array_values($_POST[valtotalcontcc]); 		 		 
					$_POST[diferenciacc]= array_values($_POST[diferenciacc]); 
				
					$queryDate="";
					if(isset($_POST['fechafin']) and isset($_POST['fechaini'])){

						if(!empty($_POST['fechaini']) and !empty($_POST['fechafin'])){
							$fechaInicial=date('Y-m-d',strtotime($_POST['fechaini']));
							$fechaFinal=date('Y-m-d',strtotime($_POST['fechafin']));
							$queryDate="AND T.fecha>='".$fechaInicial."' and T.fecha<='".$fechaFinal."'";
						}
					}
					$sqlr="select T.id_recibos, T.valor, T.estado,T.id_comp,T.descripcion,T.tipo,T.vigencia from tesoreciboscaja T where T.estado!='N' $queryDate group by T.id_recibos";
					//if($row[0]=='6623')
					$resp=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)) 
					{
						if($row[5]==3)
						{
							$sqlrCodIngreso = "SELECT ingreso FROM tesoreciboscaja_det WHERE id_recibos=$row[0]";
							$resCodIngreso=mysql_query($sqlrCodIngreso,$linkbd);
							$rowCodIngreso=mysql_fetch_row($resCodIngreso);
							
							$sqlrPorcentaje = "SELECT porcentaje FROM tesoingresos_det WHERE codigo='$rowCodIngreso[0]' AND vigencia='$row[6]' AND cuentapres!=''";
							$resPorcentaje = mysql_query($sqlrPorcentaje,$linkbd);
							$rowPorcentaje=mysql_fetch_row($resPorcentaje);
							//$row[1] = $row[1] * ($rowPorcentaje[0]/100);
							$sq="select TD.ingreso,T.codigo,T.terceros from tesoreciboscaja_det TD,tesoingresos T where id_recibos='$row[0]' and TD.ingreso=T.codigo";
							$re=mysql_query($sq,$linkbd);
							$ro=mysql_fetch_row($re);

						}
						$estilo="";
						$stado="";	
							
						$sql="select C.idrecibo,sum(C.valor),C.cuenta from pptorecibocajappto C  where C.idrecibo=$row[0]";
						$rs=mysql_query($sql,$linkbd);
						$rw=mysql_fetch_row($rs);
						
						if($rw[0] != null){
							
							$dif=$row[1]-$rw[1];
							$difround = round($dif);
							if ($difround!=0)
							{
								$_POST[recaudocc][] = $row[0];
								$_POST[conceptocc][] = $row[4];
								$_POST[valtotaltescc][] = $row[1];
								$_POST[valtotalcontcc][] = $rw[1];
								$_POST[diferenciacc][] = $difround;
							}
						}else{
							$_POST[recaudocc][] = $row[0];
							$_POST[conceptocc][] = $row[4];
							$_POST[valtotaltescc][] = $row[1];
							$_POST[valtotalcontcc][] = 0;
							$_POST[diferenciacc][] = $row[1];
						}
						
						
						
					} 				
				}			
          ?>
				
			<?php

			
			echo "<div class='subpantallac5' style='height:55%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>
				<table class='inicio' align='center' id='valores' >
				<tbody>";
				echo "<tr class='titulos'><td colspan='5'>.:Resultados: ".count($_POST[recaudocc])."</td></tr>";
				echo "<tr class='titulos ' style='text-align:center;'>
							<td ></td>
							<td ></td>
							<td >Tesoreria</td>
							<td >Presupuesto</td>
							<td ></td>
						</tr>
						<tr class='titulos' style='text-align:center;'>
							<td id='col1'>Id Recaudo</td>
							<td id='col2'>Concepto</td>
							<td id='col3'>Valor Total</td>
							<td id='col6'>Valor Total</td>
							<td id='col7'>Diferencia</td>
						</tr>";
						
				for($k=0; $k<count($_POST[recaudocc]);$k++){
					
					echo "<input type='hidden' name='recaudocc[]' value='".$_POST[recaudocc][$k]."'/>";
					echo "<input type='hidden' name='conceptocc[]' value='".$_POST[conceptocc][$k]."'/>";
					echo "<input type='hidden' name='valtotaltescc[]' value='".$_POST[valtotaltescc][$k]."'/>";
					echo "<input type='hidden' name='valtotalcontcc[]' value='".$_POST[valtotalcontcc][$k]."'/>";
					echo "<input type='hidden' name='diferenciacc[]' value='".$_POST[diferenciacc][$k]."'/>";
					echo "<input type='hidden' name='estilocc[]' value='".$_POST[estilocc][$k]."'/>";
					
					echo"<tr class='$iter' style='text-transform:uppercase;background-color:yellow; ' >
						<td style='width:7%;' id='1'>".$_POST[recaudocc][$k]."</td>
						<td style='width:32%;' id='2'>".$_POST[conceptocc][$k]."</td>
						<td style='text-align:right;width:3%;' id='3'>$".number_format($_POST[valtotaltescc][$k],2,',','.')."</td>
						<td  style='text-align:right;width:4.5%;' id='6'>$".number_format($_POST[valtotalcontcc][$k],2,',','.')."</td>
						<td  style='text-align:right;width:4.5%;' id='7'>$".number_format($_POST[diferenciacc][$k],2,',','.')."</td></tr>";
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
					$resultadoSuma=0.0;
					
				}

				echo "</table></tbody></div>";				
				
			?>

			<?php
			
			if($_POST['oculto']==2){
				//Se actualizan a vacio las variables
				unset($_POST[cuentacaja]);
				unset($_POST[cobrorecibo]);
				unset($_POST[vcobrorecibo]);
				unset($_POST[tcobrorecibo]);
				unset($_POST[vigencia]);
				unset($_POST[ncomp]);
				unset($_POST[idcomp]);
				unset($_POST[idrecaudo]);
				unset($_POST[tiporec]);
				unset($_POST[modorec]);
				unset($_POST[codcatastral]);
				unset($_POST[tipo]);
				unset($_POST[encontro]);
				unset($_POST[cuotas]);
				unset($_POST[cuotas]);
				unset($_POST[tcuotas]);
				unset($_POST[concepto]);
				unset($_POST[valorecaudo]);
				unset($_POST[totalc]);
				unset($_POST[tercero]);
				unset($_POST[fecha]);
				unset($_POST[banco]);
				unset($_POST[estadoc]);
				unset($_POST[trec]);
				unset($_POST[totalcf]);
				unset($_POST[vguardar]);
				unset($_POST[numero]);
				unset($_POST[valor]);
				unset($_POST[fechacausa]);

				$recibos = "";
				$recibosfallidos = "";
				
				for($n=0; $n<count($_POST[recaudocc]); $n++){
						
						$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
						$vigencia=$vigusu;
						$codrecibo = $_POST[recaudocc][$n];
						$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[0];}
						
						$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							$_POST[cobrorecibo]=$row[0];
							$_POST[vcobrorecibo]=$row[1];
							$_POST[tcobrorecibo]=$row[2];	 
						}
						
						$fec=date("d/m/Y");
						$_POST[vigencia]=$vigencia;
						
						$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja where id_recibos='$codrecibo'";
						$res=mysql_query($sqlr,$linkbd);
						$r=mysql_fetch_row($res);
						$_POST[ncomp]=$r[0];
						$_POST[idcomp]=$r[0];
						$_POST[idrecaudo]=$r[1];
						
						$sqlr="select * from tesoreciboscaja where id_recibos='$_POST[idcomp]'";
						$res=mysql_query($sqlr,$linkbd);
						while($r=mysql_fetch_row($res))
						{
							preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",$r[2],$fecha);
							$_POST[fecha]="$fecha[3]/$fecha[2]/$fecha[1]";							
							$_POST[tiporec]=$r[10];
							$_POST[idrecaudo]=$r[4];
							$_POST[ncomp]=$r[0];
							$_POST[modorec]=$r[5];	
							$_POST[vigencia]=$r[3]; 
						}
						if(strpos($_POST[fecha],"-")===false)
						{
							preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
							$fechaf1="$fecha[3]-$fecha[2]-$fecha[1]";
						}
						else{$fechaf1=$_POST[fecha];}
			
						$bloq=bloqueos($_SESSION[cedulausu],$fechaf1);
						
						if($bloq>=1){
							switch($_POST[tiporec]) 
							{
								case 1: //Predial
								{
									$sql="SELECT FIND_IN_SET($_POST[idcomp],recibo),idacuerdo FROM tesoacuerdopredial ";
									$result=mysql_query($sql,$linkbd);
									$val=0;
									$compro=0;
									while($fila = mysql_fetch_row($result))
									{
										if($fila[0]!=0)
										{
											$val=$fila[0];
											$compro=$fila[1];
											break;
										}
									}
									if($val>0)
									{
										$_POST[tipo]="1";
										$_POST[idrecaudo]=$compro;		
										$sqlr="select vigencia from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo]  ";
										$res=mysql_query($sqlr,$linkbd);
										$vigencias="";
										while($row = mysql_fetch_row($res)){$vigencias.=($row[0]."-");}
										$vigencias=utf8_decode("Años liquidados: ".substr($vigencias,0,-1));
										
										//OBTENER CUOTA ACTUAL
										$sqlr = "SELECT FIND_IN_SET($_POST[idcomp],recibo) as cuota FROM tesoacuerdopredial WHERE idacuerdo=$_POST[idrecaudo]";
										$data = view($sqlr);
										$_POST[cuotas] = $data[0][cuota]-1;
					
										$sql="select * from tesoacuerdopredial where tesoacuerdopredial.idacuerdo=$_POST[idrecaudo] and estado<>'N' ";
										$result=mysql_query($sql,$linkbd);
										$_POST[encontro]="";
										while($row = mysql_fetch_row($result))
										{
											$_POST[tcuotas]=$row[4];
											$_POST[codcatastral]=$row[1];	
											if($_POST[concepto]==""){$_POST[concepto]=$vigencias.' Cod Catastral No '.$row[1];}	
												$_POST[valorecaudo]=$row[7];		
												$_POST[totalc]=$row[7];	
												$_POST[tercero]=$row[13];										
												$_POST[encontro]=1;
										}
					
									}
									else
									{
										$_POST[tipo]="2";
										$sqlr="select *from tesoliquidapredial, tesoreciboscaja where tesoliquidapredial.idpredial=tesoreciboscaja.id_recaudo and tesoreciboscaja.estado !=''  and tesoreciboscaja.id_recibos='$_POST[idcomp]' ";
										$_POST[encontro]="";
										$res=mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($res)) 
										{
											preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",$row[23],$fecha);
											$_POST[fecha]="$fecha[3]/$fecha[2]/$fecha[1]";
											$_POST[codcatastral]=$row[1];
											$_POST[idrecaudo]=$row[25];	
											$_POST[vigencia]=$row[3];			
											$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1];	
											$_POST[valorecaudo]=$row[8];		
											$_POST[totalc]=$row[8];	
											$_POST[tercero]=$row[4];		
											$_POST[modorec]=$row[24];
											$_POST[banco]=$row[25]; 				
											$_POST[encontro]=1;
										}
									}	  				
									$sqlr="select *from tesoreciboscaja where tipo='1' and id_recaudo=$_POST[idrecaudo] and vigencia='".$_POST[vigencia]."' and id_recibos=$_POST[idcomp]";
									$res=mysql_query($sqlr,$linkbd);
									$row =mysql_fetch_row($res); 
									$_POST[estadoc]=$row[9];
									$_POST[modorec]=$row[5];
									$_POST[banco]=$row[7];
									
								}break;
								case 2:	// Industria y Comercio
								{
									$sqlr="SELECT * FROM tesoindustria WHERE id_industria=$_POST[idrecaudo] AND 2=$_POST[tiporec]";
									$_POST[encontro]="";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - $row[3]";	
										$_POST[valorecaudo]=$row[6];		
										$_POST[totalc]=$row[6];	
										$_POST[tercero]=$row[5];	
										$_POST[encontro]=1;
									}
									$sqlr="select *from tesoreciboscaja where  id_recibos='$_POST[idcomp]' ";
									$res=mysql_query($sqlr,$linkbd);
									$row =mysql_fetch_row($res); 
									$_POST[estadoc]=$row[9];
									if ($row[9]=='N')
									{
										$_POST[estadoc]='0';
									}
									else
									{
									   $_POST[estadoc]='1';
									}
									preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",$row[2],$fecha);
									$_POST[fecha]="$fecha[3]/$fecha[2]/$fecha[1]";
									$_POST[modorec]=$row[5];
									$_POST[banco]=$row[7];
								}break;
								case 3:	//Otros Recaudos
								{
									$sqlr="SELECT * FROM tesorecaudos where tesorecaudos.id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
									$_POST[encontro]="";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										$_POST[concepto]=$row[6];	
										$_POST[valorecaudo]=$row[5];		
										$_POST[totalc]=$row[5];	
										$_POST[tercero]=$row[4];			
										$_POST[encontro]=1;
									}
									$sqlr="select *from tesoreciboscaja where  id_recibos=$_POST[idcomp] ";
									$res=mysql_query($sqlr,$linkbd);
									$row =mysql_fetch_row($res); 
									preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/", $row[2],$fecha);
									$_POST[fecha]="$fecha[3]/$fecha[2]/$fecha[1]";
									$_POST[estadoc]=$row[9];
									if ($row[9]=='N')
									{
										$_POST[estadoc]='0';
									}
									else
									{
										$_POST[estadoc]='1';
									}
									$_POST[modorec]=$row[5];
									$_POST[banco]=$row[7];
								}break;	
							}
						
						if($_POST[encontro]=='1')
						{
							switch($_POST[tiporec]) 
							{
								case 1: //********PREDIAL
								{
									unset($_POST[dcoding]); 		 
									unset($_POST[dncoding]); 		 
									unset($_POST[dvalores]); 	
									$_POST[dcoding]= array(); 		 
									$_POST[dncoding]= array(); 		 
									$_POST[dvalores]= array(); 	
									if($_POST[tcobrorecibo]=='S')
									{	 
										$_POST[dcoding][]=$_POST[cobrorecibo];
										$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
										$_POST[dvalores][]=$_POST[vcobrorecibo];
									}
									$_POST[trec]='PREDIAL';	 
									if($_POST[tipo]=='1')
									{
										$sqlr="select * from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo] ";
										$res=mysql_query($sqlr,$linkbd);
										//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
										while ($row =mysql_fetch_row($res)) 
										{
											$vig=$row[13];
											if($vig==$vigusu)
											{
												$sqlr2="select * from tesoingresos where codigo='01'";
												$res2=mysql_query($sqlr2,$linkbd);
												$row2 =mysql_fetch_row($res2); 
												$_POST[dcoding][]=$row2[0];
												$_POST[dncoding][]=$row2[1]." ".$vig;			 		
												$_POST[dvalores][]=($row[10]/$_POST[tcuotas]);		 
											}
											else
											{	
												$sqlr2="select * from tesoingresos where codigo='03'";
												$res2=mysql_query($sqlr2,$linkbd);
												$row2 =mysql_fetch_row($res2); 
												$_POST[dcoding][]=$row2[0];
												$_POST[dncoding][]=$row2[1]." ".$vig;			 		
												$_POST[dvalores][]=($row[10]/$_POST[tcuotas]);		
											}
										}
									}
									else
									{
										$sqlr="select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
										$res=mysql_query($sqlr,$linkbd);
										//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
										while ($row =mysql_fetch_row($res)) 
										{
											$vig=$row[1];
											if($vig==$vigusu)
											{
												$sqlr2="select * from tesoingresos where codigo='01'";
												$res2=mysql_query($sqlr2,$linkbd);
												$row2 =mysql_fetch_row($res2); 
												$_POST[dcoding][]=$row2[0];
												$_POST[dncoding][]=$row2[1]." ".$vig;			 		
												$_POST[dvalores][]=$row[11];		 
											}
											else
											{	
												$sqlr2="select * from tesoingresos where codigo='03'";
												$res2=mysql_query($sqlr2,$linkbd);
												$row2 =mysql_fetch_row($res2); 
												$_POST[dcoding][]=$row2[0];
												$_POST[dncoding][]=$row2[1]." ".$vig;			 		
												$_POST[dvalores][]=$row[11];		
											}
										}
								
									}
								   
								}break;
								case 2:	//***********INDUSTRIA Y COMERCIO
								{
									$_POST[dcoding]= array(); 		 
									$_POST[dncoding]= array(); 		 
									$_POST[dvalores]= array(); 	
									$_POST[trec]='INDUSTRIA Y COMERCIO';	 
									if($_POST[tcobrorecibo]=='S')
									{	 
										$_POST[dcoding][]=$_POST[cobrorecibo];
										$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
										$_POST[dvalores][]=$_POST[vcobrorecibo];
									}
									$sqlr="SELECT * FROM tesoindustria WHERE id_industria='$_POST[idrecaudo]' AND  2='$_POST[tiporec]'";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										$sqlr2="SELECT * FROM tesoingresos WHERE codigo='02'";
										$res2=mysql_query($sqlr2,$linkbd);
										$row2 =mysql_fetch_row($res2);
										$_POST[dcoding][]=$row2[0];
										$_POST[dncoding][]=$row2[1];
										if($row[8]>1){$_POST[dvalores][]=$row[6]/$row[8];}	
										else{$_POST[dvalores][]=$row[6];}	
									}
								}break;
								case 3:	//*****************otros recaudos *******************
								{
									$_POST[trec]='OTROS RECAUDOS';	 
									$sqlr="select *from tesorecaudos_det where id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
									$_POST[dcoding]= array(); 		 
									$_POST[dncoding]= array(); 		 
									$_POST[dvalores]= array(); 	
									if($_POST[tcobrorecibo]=='S')
									{	 
										$_POST[dcoding][]=$_POST[cobrorecibo];
										$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
										$_POST[dvalores][]=$_POST[vcobrorecibo];
									}	 
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{	
										$_POST[dcoding][]=$row[2];
										$sqlr2="select nombre from tesoingresos where codigo='".$row[2]."'";
										$res2=mysql_query($sqlr2,$linkbd);
										$row2 =mysql_fetch_row($res2); 
										$_POST[dncoding][]=$row2[0];			 		
										$_POST[dvalores][]=$row[3];		 	
									}
								}break;
							}
						}
						
						for ($x=0;$x<count($_POST[dcoding]);$x++)
						{		 
							echo "
							<input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."'>
							<input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."'>
							<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'>";
							$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
							$_POST[totalcf]=number_format($_POST[totalc],2);
						
						}
						
						//************VALIDAR SI YA FUE GUARDADO ************************
						switch($_POST[tiporec]) 
						{
							case 1://***** PREDIAL *****************************************
							{
								$sql="select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo] and estado != 'N'";
								$resul=mysql_query($sql,$linkbd);
								$rowcod=mysql_fetch_row($resul);
								$tipopre=obtenerTipoPredio($rowcod[0]);
								$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='1' ";
								$res=mysql_query($sqlr,$linkbd);
								while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
								if($numerorecaudos>=0)
								{ 	
									$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
									mysql_query($sqlr,$linkbd);
									if($_POST[modorec]=='caja')
									{				 
										$cuentacb=$_POST[cuentacaja];
										$cajas=$_POST[cuentacaja];
										$cbancos="";
									}
									if($_POST[modorec]=='banco')
									{
										$cuentacb=$_POST[banco];				
										$cajas="";
										$cbancos=$_POST[banco];
									}	   
									ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
									$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];	   	   
									//************ insercion de cabecera recaudos ************
									$concecc=$_POST[idcomp];
									echo "<input type='hidden' name='concec' value='$concecc'>";	
									
									if($_POST[tipo]=='1'){
										$cuotas=intval($_POST[cuotas]);
										$totcuotas=intval($_POST[tcuotas]);
										if(($totcuotas-$cuotas)==0){
											$sqlrp="Select tesoacuerdopredial_det.vigencia,tesoacuerdopredial.codcatastral from tesoacuerdopredial_det,tesoacuerdopredial where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo] AND tesoacuerdopredial_det.idacuerdo=tesoacuerdopredial.idacuerdo";
											$resq=mysql_query($sqlrp,$linkbd);
											while($rq=mysql_fetch_row($resq))
											{
												$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral='".$rq[1]."' AND vigencia='".$rq[0]."' ";
												mysql_query($sqlr2,$linkbd);
											}
										}
									}else{
										$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
										$resq=mysql_query($sqlr,$linkbd);
										while($rq=mysql_fetch_row($resq))
										{
											$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE   idpredial=$_POST[idrecaudo]) AND vigencia=$rq[1]";
											mysql_query($sqlr2,$linkbd);
										}
									}
									echo"
									<script>
										document.form2.numero.value='';
										document.form2.valor.value=0;
									</script>";
									if($_POST[tipo]=='1'){
										$sql = "SELECT T1.porcentaje_valor,T1.valor_pago FROM tesoacuerdopredial_pagos T1 WHERE T1.idacuerdo=$_POST[idrecaudo] AND T1.cuota=$_POST[cuotas]";
										$dat = view($sql);
										$sqlrs="select *from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo] ";
										$res=mysql_query($sqlrs,$linkbd);	
										$rowd==mysql_fetch_row($res);
										$tasadesc=round(($rowd[5]*$dat[0][porcentaje_valor])/100,2);
										$sqlr="select *from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo]";
									}else{
										$sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
										$res=mysql_query($sqlrs,$linkbd);	
										$rowd==mysql_fetch_row($res);
										$tasadesc=($rowd[6]/100);
										$sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
									}
									$res=mysql_query($sqlrs,$linkbd);
									//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
									$query="DELETE FROM pptorecibocajappto WHERE idrecibo=$concecc";
									mysql_query($query,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										if($_POST[tipo]=='1'){
											$vig=$row[13];
											$vlrdesc=round($row[9]*$dat[0][porcentaje_valor],2);
										}else{
											$vig=$row[1];
											$vlrdesc=$row[10];	
										}
										if($vig==$vigusu) //*************VIGENCIA ACTUAL *****************
										{	
											$sqlr2="select * from tesoingresos_det where codigo='01' AND MODULO='4' and vigencia=$vigusu group by concepto";
											$res2=mysql_query($sqlr2,$linkbd);
											
											//****** $cuentacb   ES LA CUENTA CAJA O BANCO
											while($rowi =mysql_fetch_row($res2))
											{
												switch($rowi[2])
												{
													case '01': //***  VALOR PREDIAL
													{
														//**** busca descuento PREDIAL
														$sqlrds="select * from tesoingresos_det where codigo='01' and concepto='P01' AND MODULO='4' and vigencia=$vigusu";
														$resds=mysql_query($sqlrds,$linkbd);
														while($rowds =mysql_fetch_row($resds))
														{$descpredial=round($vlrdesc*round($rowds[5]/100,2),2);}
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){
															$valorcred=round($row[2]*$dat[0][porcentaje_valor],2);
															$valordeb=round($row[2]*$dat[0][porcentaje_valor],2);
														}else{
															$valorcred=$row[4];
															$valordeb=$row[4];
														}				 
														if($valorcred>0)
														{
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															if($_POST[tipo]=='1'){
																$vi=$valordeb-$descpredial;
															}else{
																$vi=$row[4]-$descpredial;
															}	
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='01' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]', $concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]', $concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															//************ FIN MODIFICACION PPTAL		
														}
													}break;  
													case '02':
													{
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){
															$valorcred=round($row[7]*$dat[0][porcentaje_valor],2);
															$valordeb=round($row[7]*$dat[0][porcentaje_valor],2);
														}else{
															$valorcred=$row[8];
															$valordeb=$row[8];	
														}			 
														if($valorcred>0)
														{							
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															if($_POST[tipo]=='1'){
																$vi=$valordeb;
															}else{
																$vi=$row[8];
															}
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
															mysql_query($sqlr,$linkbd);	
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='02' AND vigencia='$vigusu'";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]', $concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]', $concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}	
														}
													}break;  
													case '03': 	
													{		
														$sqlrds="select * from tesoingresos_det where codigo='01' and concepto='P10' AND MODULO='4' and vigencia=$vigusu";
														$resds=mysql_query($sqlrds,$linkbd);
														while($rowds =mysql_fetch_row($resds))
														{$descpredial=round($vlrdesc*round($rowds[5]/100,2),2);}
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){
															$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);
															$valordeb=round($row[5]*$dat[0][porcentaje_valor],2);
														}else{
															$valorcred=$row[6];
															$valordeb=$row[6];
														}			 	
														if($valorcred>0)
														{							
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															if($_POST[tipo]=='1'){
																$vi=$valordeb-$descpredial;
															}else{
																$vi=$row[6]-$descpredial;
															}
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='03' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															//************ FIN MODIFICACION PPTAL			
														}
													}break;  
													case 'P02': 
													{
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){
															$valorcred=round($row[3]*$dat[0][porcentaje_valor],2);
														}else{
															$valorcred=$row[5];
														}	 	
														$valordeb=$valorcred;
														if($valorcred>0)
														{
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															if($_POST[tipo]=='1'){
																$vi=$valordeb;
															}else{
																$vi=$row[5];
															}
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P02' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															//************ FIN MODIFICACION PPTAL	
														}
													}break;  
													case 'P04':
													{
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){
															$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);
														}else{
															$valorcred=$row[7];
														}	
														$valordeb=$valorcred;		 	
														if($valorcred>0)
														{			
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															if($_POST[tipo]=='1'){
																$vi=$valordeb;
															}else{
																$vi=$row[7];
															}
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
															  //****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P04' AND vigencia=$vigusu";
															//echo $sql;
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}	
															//************ FIN MODIFICACION PPTAL	
														}
													}break;  
													case 'P07': 
													{
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){
															$valorcred=round($row[8]*$dat[0][porcentaje_valor],2);	
														}else{
															$valorcred=$row[9];
														}	 
														$valordeb=$valorcred;
														if($valorcred>0)
														{			
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															if($_POST[tipo]=='1'){
																$vi=$valordeb;
															}else{
																$vi=$row[9];
															}
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P07' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															//************ FIN MODIFICACION PPTAL	
														}
													}break; 	
													case 'P18': 
													{
														$siAlumbrado=0;
														$sqlrDesc = "SELECT val_alumbrado FROM tesoliquidapredial_desc WHERE id_predial='$row[0]' AND vigencia=$vig ORDER BY vigencia ASC";
														$resDesc = mysql_query($sqlrDesc,$linkbd);
														while ($rowDesc =mysql_fetch_assoc($resDesc))
														{
															$siAlumbrado = $rowDesc['val_alumbrado'];
														}
														if($siAlumbrado>0)
														{
															$vi=round($siAlumbrado,0);
															if($vi>0)
															{	
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																//****creacion documento presupuesto ingresos
																$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P18' AND vigencia=$vigusu";
																$resul=mysql_query($sql,$linkbd);
																$numreg=mysql_num_rows($resul);
																while($rowp = mysql_fetch_row($resul))
																{
																	if($rowp[0]!="" && $vi>0)
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																		mysql_query($sqlr,$linkbd);	
																	}
																}
																if($numreg==0 )
																{
																	if($vi>0)
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																		mysql_query($sqlr,$linkbd);
																	}
																}
																//************ FIN MODIFICACION PPTAL	
															}
														}
													}break;
												}
											}
											if($_POST[tipo]=='1'){
												$_POST[dcoding][]=$row2[0][codigo];
												$_POST[dncoding][]=$row2[0][nombre]." ".$vig;			 		
												$_POST[dvalores][]=$dvalorTRUE;	
											}else{
												$_POST[dcoding][]=$row2[0];
												$_POST[dncoding][]=$row2[1]." ".$vig;			 		
												$_POST[dvalores][]=$row[11];
											}
										}
										else  ///***********OTRAS VIGENCIAS ***********
										{	
											if($_POST[tipo]=='1'){
												$tasadesc=round(($row[9]*$dat[0][porcentaje_valor])/(($row[2]*$dat[0][porcentaje_valor])+($row[5]*$dat[0][porcentaje_valor])),2);
											}else{
												$tasadesc=$row[10];
											}

											$sqlr2="select * from tesoingresos_det where codigo='03' AND MODULO='4' and vigencia=$vigusu group by concepto";
											$res2=mysql_query($sqlr2,$linkbd);				 
											//****** $cuentacb   ES LA CUENTA CAJA O BANCO
											while($rowi =mysql_fetch_row($res2))
											{
												switch($rowi[2])
												{
													case 'P03': //***
													{
														$porce=$rowi[5];	
														if($_POST[tipo]=='1'){
															$valorcred=round($row[2]*$dat[0][porcentaje_valor],2);
														}else{
															$valorcred=$row[4];
														}		 
														$valordeb=$valorcred;	
														if($valorcred>0)
														{								
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	     
															$rowpto=mysql_fetch_row($respto);
															if($_POST[tipo]=='1'){
																$vi=$valordeb;
															}else{
																$vi=$row[4]-$tasadesc;
															}
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P03' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															//************ FIN MODIFICACION PPTAL		
														}
													}break;  
													case 'P06': //***
													{
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){
															$valorcred=round($row[7]*$dat[0][porcentaje_valor],2);	
														}else{		 
															$valorcred=$row[8];
														}
														$valordeb=$valorcred;	
														if($valorcred>0)
														{						
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															if($_POST[tipo]=='1'){
																$vi=$valordeb;
															}else{
																$vi=$row[8];
															}
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P06' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															//************ FIN MODIFICACION PPTAL	
														}
													}break;  
													case '03': 
													{
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){
															$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);	
														}else{
															$valorcred=$row[6];
														}		 
														$valordeb=$valorcred;	
														if($valorcred>0)
														{			
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$vi=$valordeb;
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='03' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															//************ FIN MODIFICACION PPTAL	
														}
													}break;  
													case 'P01':
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='".$rowi[2]."' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{			
																if($_POST[tipo]=='1'){
																	$valordeb=round($row[9]*$dat[0][porcentaje_valor],2);	
																}else{ 
																	$valordeb=$row[10];
																}
																$valorcred=0;					
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{}
																}
															}
														}
													}break;  
													case 'P02':
													{ 
														$porce=$rowi[5];
														$valdescuento=0;
														if($_POST[tipo]=='1'){
															//Se obtienen descuentos en caso de haberlos
															$valdescuento = round($row[4]*$dat[0][porcentaje_valor],2);
															$valorcred=round($row[3]*$dat[0][porcentaje_valor],2);	
														}else{
															$valorcred=$row[5];
														}		 
														$valordeb=$valorcred;
														if($valorcred>0)
														{
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$vi=$valordeb-$valdescuento;
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P02' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]', $concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
														}
													}break;  
													case 'P04': 
													{
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){
															$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);	
														}else{
															$valorcred=$row[7];
														}			 
														$valordeb=$valorcred;	
														if($valorcred>0)
														{						
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$vi=$valordeb;
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P04' AND vigencia='$vigusu'";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]', $concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															//************ FIN MODIFICACION PPTAL	
														}
													}break;  
													case 'P05':
													{
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){
															$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);
														}else{
															$valorcred=$row[6];
														}			 
														$valordeb=$valorcred;
														if($valorcred>0)
														{
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															if($_POST[tipo]=='1'){
																$vi=$valordeb;
															}else{
																$vi=$row[6];
															}	
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P05' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]', $concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]', $concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															//************ FIN MODIFICACION PPTAL	
														}
													}break;  
													case 'P07': 
													{
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){
															$valorcred=round($row[8]*$dat[0][porcentaje_valor],2);
														}else{
															$valorcred=$row[9];
														}			 
														$valordeb=$valorcred;	
														if($valorcred>0)
														{			
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
															$respto=mysql_query($sqlrpto,$linkbd);   
															$rowpto=mysql_fetch_row($respto);
															$vi=$valordeb;
	
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P07' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]', $concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															if($numreg==0 )
															{
																if($vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]', $concecc,$vi,'$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																}
															}
															//************ FIN MODIFICACION PPTAL	
														}
													}break;  
													case 'P18': 
													{
														$siAlumbrado=0;
														$sqlrDesc = "SELECT val_alumbrado FROM tesoliquidapredial_desc WHERE id_predial='$row[0]' AND vigencia=$vig ORDER BY vigencia ASC";
														$resDesc = mysql_query($sqlrDesc,$linkbd);
														while ($rowDesc =mysql_fetch_assoc($resDesc))
														{
															$siAlumbrado = $rowDesc['val_alumbrado'];
														}
														if($siAlumbrado>0)
														{
															$vi=round($siAlumbrado,0);
															if($vi>0)
															{		
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																//****creacion documento presupuesto ingresos
																$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P18' AND vigencia=$vigusu";
																$resul=mysql_query($sql,$linkbd);
																$numreg=mysql_num_rows($resul);
																while($rowp = mysql_fetch_row($resul))
																{
																	if($rowp[0]!="" && $vi>0)
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																		mysql_query($sqlr,$linkbd);	
																	}
																}
																if($numreg==0 )
																{
																	if($vi>0)
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																		mysql_query($sqlr,$linkbd);	
																	}
																}
																//************ FIN MODIFICACION PPTAL	
															}
														}
													}break;
												} 
											}
											/*if($_POST[tipo]=='1'){
												$_POST[dcoding][]=$row2[0][codigo];
												$_POST[dncoding][]=$row2[0][nombre]." ".$vig;			 		
												$_POST[dvalores][]=$cuot[1][valor];	
											}else{
												$_POST[dcoding][]=$row2[0];
												$_POST[dncoding][]=$row2[1]." ".$vig;			 		
												$_POST[dvalores][]=$row[11];
											}*/
										}
									}
									//*******************  
									if($_POST[tipo]=='1'){
										$sqlr="Select *from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo]";
										$resp=mysql_query($sqlr,$linkbd);
										while($row=mysql_fetch_row($resp,$linkbd))
										{
											$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[13]";
											mysql_query($sqlr2,$linkbd);
										}
										//ACTUALIZAR CUOTA PAGADA
										$sql = "UPDATE tesoacuerdopredial_pagos T1 SET T1.estado='N' WHERE T1.idacuerdo=$_POST[idrecaudo] AND T1.cuota=$_POST[cuotas]";
										view($sql);
									}else{
										$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
										$resp=mysql_query($sqlr,$linkbd);
										while($row=mysql_fetch_row($resp,$linkbd))
										{
											$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial='$_POST[idrecaudo]') AND vigencia='$row[1]'";
											mysql_query($sqlr2,$linkbd);
										}	
									} 	  
								} //fin de la verificacion
								else
								{
									echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion Predial<img src='imagenes/alert.png'></center></td></tr></table>";
								}//***FIN DE LA VERIFICACION
							}break;
							case 2:  //********** INDUSTRIA Y COMERCIO
							{
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
								$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
								$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='2'";
								$res=mysql_query($sqlr,$linkbd);
								while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
								if($numerorecaudos>=0)
								{   	 
									$sqlr="delete from pptorecibocajappto where idrecibo='$_POST[idcomp]'";
									if (mysql_query($sqlr,$linkbd))
									{ 
										$concecc=$_POST[idcomp]; 
										//*************COMPROBANTE CONTABLE INDUSTRIA
										if($_POST[modorec]=='caja')
										{				 
											$cuentacb=$_POST[cuentacaja];
											$cajas=$_POST[cuentacaja];
											$cbancos="";
										}
										if($_POST[modorec]=='banco')
										{
											$cuentacb=$_POST[banco];				
											$cajas="";
											$cbancos=$_POST[banco];
										}
										//**********************CREANDO COMPROBANTE CONTABLE ********************************	 		 
										for($x=0;$x<count($_POST[dcoding]);$x++)
										{
											if($_POST[dcoding][$x]==$_POST[cobrorecibo])
											{
												//***** BUSQUEDA INGRESO ********
												$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
												$resi=mysql_query($sqlri,$linkbd);
												while($rowi=mysql_fetch_row($resi))
												{
													//**** busqueda cuenta presupuestal*****
													//busqueda concepto contable
													$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
													$re=mysql_query($sq,$linkbd);
													while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
													$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
													$resc=mysql_query($sqlrc,$linkbd);	  
													while($rowc=mysql_fetch_row($resc))
													{
														$porce=$rowi[5];
														if($rowc[7]=='S')
														{				 
															$vi=$_POST[dvalores][$x];
															$valordeb=0;
															if($rowc[3]=='N')
															{
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$rowi[6]','$_POST[tercero]','RECIBO DE CAJA PREDIAL','$vi',0, '$_POST[estadoc]','$_POST[vigencia]',16,'$concecc',1,'','','$fechaf')";
																//mysql_query($sqlr,$linkbd); 				
															}
														}
													}
												}
											}
										}			 	 
										//*************** fin de cobro de recibo
										for($x=0;$x<count($_POST[dcoding]);$x++)
										{	
											//***** BUSQUEDA INGRESO ********
											$sqlr="Select * from tesoindustria_det where id_industria='$_POST[idrecaudo]'";
											$res=mysql_query($sqlr,$linkbd);
											$row=mysql_fetch_row($res);
											if(substr($_POST[descunidos], -3, 1)=='S')
											{
												if($row[21]>0){$_POST[descuenindus]=$row[21];}
												else {$_POST[descuenindus]=$row[1]*($row[13]/100);}
											}
											else{$_POST[descuenindus]=0;}
											if(substr($_POST[descunidos], -2, 1)=='S')
											{
												if($row[22]>0){$_POST[descuenaviso]=$row[22];}
												else{$_POST[descuenaviso]=$row[2]*($row[13]/100);}
											}
											else {$_POST[descuenaviso]=0;}
											if(substr($_POST[descunidos], -1, 1)=='S')
											{
												if($row[23]>0){$_POST[descuenbombe]=$row[23];}
												else {$_POST[descuenbombe]=$row[3]*($row[13]/100);}
											}
											else{$_POST[descuenbombe]=0;}
											$industria=round($row[1]-$_POST[descuenindus],-3);
											$avisos=round($row[2]-$_POST[descuenaviso],-3);
											$bomberil=round($row[3]-$_POST[descuenbombe],-3);
											$retenciones=$row[4];
											$sanciones=$row[5];	
											$intereses=$row[25];
											$interesesind=$row[26];
											$interesesavi=$row[27];
											$interesesbom=$row[28];
											$antivigact=$row[11];		
											$antivigant=$row[10];
											if($intereses>0)
											{
												$intetodos=(float)$interesesind+(float)$interesesavi+(float)$interesesbom;
												if($intetodos>0)
												{
													$indinteres=$interesesind;
													$aviinteres=$interesesavi;
													$bominteres=$interesesbom;
												}
												else
												{
													$indinteres=$intereses;
													$aviinteres=0;
													$bominteres=0;
												}
											}
											$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
											$res=mysql_query($sqlri,$linkbd);
											while($row=mysql_fetch_row($res))
											{
												switch($row[2])
												{
													case '00': //*****SANCIONES
													{					
														$valordeb=$industria+$sanciones-$retenciones;
														$valorcred=0;
														$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$industria WHERE cuenta='$row[6]' and vigencia= '$vigusu'";
														mysql_query($sqlr,$linkbd);
														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$sanciones,'$vigusu')";
														mysql_query($sqlr,$linkbd);	
														if($row[6]!="")
														{
															//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$row[6]','$_POST[tercero]','RECIBO DE CAJA','$sanciones',0, '$_POST[estadoc]','$_POST[vigencia]',16,'$concecc',1,'','','$fechaf')";
															//mysql_query($sqlr,$linkbd); 		
														}						
													}break;
													case '04': //*****INDUSTRIA
													{					
														$valordeb=$industria+$sanciones+$intereses-$retenciones;
														$valorcred=0;
														$totalindustria=$industria;
														$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$industria WHERE cuenta='$row[6]' and vigencia='$vigusu'";
														mysql_query($sqlr,$linkbd);
														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc, $totalindustria,'$vigusu')";
														mysql_query($sqlr,$linkbd);	
														if($row[6]!="")
														{
															$industria+=$intereses;
															//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo) values('$row[6]','$_POST[tercero]','RECIBO DE CAJA','$industria',0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc')";
															//mysql_query($sqlr,$linkbd); 	
														}	
													}break;
													case '05'://************AVISOS
													{
														$valordeb=$avisos;
														$valorcred=0;
														$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$avisos WHERE cuenta='$row[6]' and vigencia='$vigusu'";
														mysql_query($sqlr,$linkbd);
														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$avisos,'".$vigusu."')";
														mysql_query($sqlr,$linkbd);	
														if($row[6]!="")
														{
															//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$row[6]."','".$_POST[tercero]."','RECIBO DE CAJA',".$avisos.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc',1,'','','$fechaf')";
															//mysql_query($sqlr,$linkbd); 	
														}				
													}break;
													case '06': //*********BOMBERIL ********
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='06' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='06' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$res2=mysql_query($sqlr2,$linkbd);
														while($row2=mysql_fetch_row($res2))
														{
															if($row2[3]=='N')
															{				 					  		
																if($row2[6]=='S')
																{				 
																	$valordeb=0;
																	$valorcred=$bomberil;					
																	//********** CAJA O BANCO
																	$valordeb=$bomberil;
																	$valorcred=0;
																	//***MODIFICAR PRESUPUESTO
																	$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$bomberil WHERE cuenta='$row[6]' and vigencia='$vigusu'";
																	mysql_query($sqlr,$linkbd);
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]','$concecc', '$bomberil','$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																	if($row[6]!="")
																	{
																		//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$row[6]', '$_POST[tercero]','RECIBO DE CAJA',$bomberil,0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc',1,'','','$fechaf')";
																		//mysql_query($sqlr,$linkbd); 		
																	}
																}
															}
														}
													}break;
													case 'P04': //*********INTERESES BOMBERIL********
													{
														if($bominteres>0)
														{
															$sq="select fechainicial from conceptoscontables_det where codigo='P04' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
															$re=mysql_query($sq,$linkbd);
															while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
															$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P04' and tipo='C' and fechainicial='$_POST[fechacausa]'";
															$res2=mysql_query($sqlr2,$linkbd);
															while($row2=mysql_fetch_row($res2))
															{
																if($row2[3]=='N')
																{				 					  		
																	if($row2[6]=='S')
																	{				 
																		$valordeb=0;
																		$valorcred=$bominteres;					
																		//********** CAJA O BANCO
																		$valordeb=$bominteres;
																		$valorcred=0;
																		//***MODIFICAR PRESUPUESTO
																		$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$bominteres WHERE cuenta='$row[6]' and vigencia='$vigusu'";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]', '$concecc','$bominteres','$vigusu')";
																		mysql_query($sqlr,$linkbd);	
																		if($row[6]!="")
																		{
																			//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$row[6]', '$_POST[tercero]','RECIBO DE CAJA',$bominteres,0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc',1,'','','$fechaf')";
																			//mysql_query($sqlr,$linkbd); 		
																		}
																	}
																}
															}
														}
													}break;
													case 'P12'://************ANTICIPOS VIG ACTUAL ****************** 
													{
														if($antivigact>0)
														{
															$sq="select fechainicial from conceptoscontables_det where codigo='P11' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
															$re=mysql_query($sq,$linkbd);
															while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
															$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C' and fechainicial='$_POST[fechacausa]'";
															$res2=mysql_query($sqlr2,$linkbd);
															while($row2=mysql_fetch_row($res2))
															{
																if($row2[3]=='N')
																{				 					  		
																	if($row2[7]=='S')
																	{				 
																		$valordeb=0;
																		$valorcred=$antivigact;					
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','ANTICIPO VIGENCIA ACTUAL $_POST[ageliquida]', '',0,$valorcred,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);	 
																		//********** CAJA O BANCO
																		$valordeb=$antivigact;
																		$valorcred=0;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','ANTICIPO VIGENCIA ACTUAL $_POST[modorec]','', '$valordeb',0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);											
																	}
																}						
															}
														}
													}break;
													case 'P13'://************ANTICIPOS VIG ANTERIOR ****************** 
													{
														if($antivigant>0)
														{
															$sq="select fechainicial from conceptoscontables_det where codigo='P11' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
															$re=mysql_query($sq,$linkbd);
															while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
															$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C' and fechainicial='$_POST[fechacausa]'";
															$res2=mysql_query($sqlr2,$linkbd);
															while($row2=mysql_fetch_row($res2))
															{
																if($row2[3]=='N')
																{				 					  		
																	if($row2[7]=='S')
																	{				 
																		$valorcred=0;
																		$valordeb=$antivigant;					
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','ANTICIPO VIGENCIA ANTERIOR $_POST[ageliquida]', '',$valordeb,$valorcred,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);	 
																		//********** CAJA O BANCO									
																	}
																}						
															}
														}
													}break;
													case 'P16'://*****INTERESES INDUSTRIA
													{
														if($indinteres>0)
														{
															$sq="select fechainicial from conceptoscontables_det where codigo='P16' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
															$re=mysql_query($sq,$linkbd);
															while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
															$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P16' and tipo='C' and fechainicial='$_POST[fechacausa]'";
															$res2=mysql_query($sqlr2,$linkbd);
															while($row2=mysql_fetch_row($res2))
															{
																if($row2[3]=='N')
																{				 					  		
																	if($row2[6]=='S')
																	{				 
																		$valordeb=0;
																		$valorcred=$indinteres;					
																		//********** CAJA O BANCO
																		$valordeb=$indinteres;
																		$valorcred=0;
																		//***MODIFICAR PRESUPUESTO
																		$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$indinteres WHERE cuenta='$row[6]' and vigencia='$vigusu'";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]', '$concecc','$indinteres','$vigusu')";
																		mysql_query($sqlr,$linkbd);	
																		if($row[6]!="")
																		{
																			//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$row[6]', '$_POST[tercero]','RECIBO DE CAJA',$indinteres,0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc',1,'','','$fechaf')";
																			//mysql_query($sqlr,$linkbd); 		
																		}
																	}
																}
															}
														}
													}break;
													case 'P17'://*****INTERESES AVISOS Y TABLEROS
													{
														if($aviinteres>0)
														{
															$sq="select fechainicial from conceptoscontables_det where codigo='P17' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
															$re=mysql_query($sq,$linkbd);
															while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
															$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P17' and tipo='C' and fechainicial='$_POST[fechacausa]'";
															$res2=mysql_query($sqlr2,$linkbd);
															while($row2=mysql_fetch_row($res2))
															{
																if($row2[3]=='N')
																{				 					  		
																	if($row2[6]=='S')
																	{				 
																		$valordeb=0;
																		$valorcred=$aviinteres;					
																		//********** CAJA O BANCO
																		$valordeb=$aviinteres;
																		$valorcred=0;
																		//***MODIFICAR PRESUPUESTO
																		$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$aviinteres WHERE cuenta='$row[6]' and vigencia='$vigusu'";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]', '$concecc','$aviinteres','$vigusu')";
																		mysql_query($sqlr,$linkbd);	
																		if($row[6]!="")
																		{
																			//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$row[6]', '$_POST[tercero]','RECIBO DE CAJA',$aviinteres,0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc',1,'','','$fechaf')";
																			//mysql_query($sqlr,$linkbd); 		
																		}
																	}
																}
															}
														}
													}break;
												}
											}
										}
									}
								}
								
							}break; 
							case 3: //**************OTROS RECAUDOS
							{
								$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
								//echo $sqlr;		
								mysql_query($sqlr,$linkbd);
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
								$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
								//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
								//***busca el consecutivo del comprobante contable
								$consec=$_POST[idcomp];

								//**********************CREANDO COMPROBANTE CONTABLE ********************************	 		 
								for($x=0;$x<count($_POST[dcoding]);$x++)
								{
									if($_POST[dcoding][$x]==$_POST[cobrorecibo])
									{
										//***** BUSQUEDA INGRESO ********
										$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
										$resi=mysql_query($sqlri,$linkbd);
										//	echo "$sqlri <br>";	    
										while($rowi=mysql_fetch_row($resi))
										{
											//**** busqueda cuenta presupuestal*****
											//busqueda concepto contable
											$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
											$re=mysql_query($sq,$linkbd);
											while($ro=mysql_fetch_assoc($re))
											{
												$_POST[fechacausa]=$ro["fechainicial"];
											}
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
							
											$resc=mysql_query($sqlrc,$linkbd);	  
											//echo "concc: $sqlrc <br>";	      
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[7]=='S')
												{				 
													$vi=$_POST[dvalores][$x];
													$valordeb=0;
													if($rowc[3]=='N')
													{
														//*****inserta del concepto contable  
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA PREDIAL',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concec',1,'','','$fechaf')";
														//mysql_query($sqlr,$linkbd); 				
													}
								
												}
											}
										}
									}
								}			 	 
								//*************** fin de cobro de recibo
								//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
								for($x=0;$x<count($_POST[dcoding]);$x++)
								{
									//***** BUSQUEDA INGRESO ********
									$sqlri="select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
									$resi=mysql_query($sqlri,$linkbd);
									//	echo "$sqlri <br>";	    
									while($rowi=mysql_fetch_row($resi))
									{
										if($rowi[6]!="")
										{
											//**** busqueda cuenta presupuestal*****
											$porce=$rowi[5];
											$valorcred=$_POST[dvalores][$x]*($porce/100);
											$valordeb=0;
											//*****inserta del concepto contable  
											//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
											$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
											$respto=mysql_query($sqlrpto,$linkbd);	  
											//echo "con: $sqlrpto <br>";	      
											$rowpto=mysql_fetch_row($respto);			
											$vi=$_POST[dvalores][$x]*($porce/100);
	
											//****creacion documento presupuesto ingresos		
											$sql="SELECT terceros FROM tesoingresos WHERE codigo=".$_POST[dcoding][$x] ;
											$res=mysql_query($sql,$linkbd);
											$row= mysql_fetch_row($res);	
											
											if($row[0]!="R"){
												$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$consec,'$vi','$vigusu','N','".$_POST[dcoding][$x]."')";
												mysql_query($sqlr,$linkbd);	
											}else{
												$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$consec,'$vi','$vigusu','R','".$_POST[dcoding][$x]."')";
												mysql_query($sqlr,$linkbd);	
											}
			
										}
									}
								}	
					
							}break;
						} //*****fin del switch
						$recibos.=($_POST[recaudocc][$n])." ";
						}else{
							$recibosfallidos.=($_POST[recaudocc][$n])." ";	
						}

					
		}
		echo "<table class='inicio'><tr><td class='saludo1'><center>Se han reflejado los Recibos de Caja $recibos con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>"; 
		echo "<table class='inicio'><tr><td class='saludo1'><center>No se pudieron reflejar los Recibos de Caja $recibosfallidos <img src='imagenes/del.png'><script></script></center></td></tr></table>"; 
							
	}
			
?>
			
		
        </form> 

</body>
</html>