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
        <title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
        <script>

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
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("adm");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
				<a href="cont-reflejarrecibosmasivo.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guarda.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('presu-principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a><a href="adm-comparacomprobantes-cont.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
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
				<?php
			
			function obtenerTipoPredio($catastral)
			{
				$tipo="";
				$linkbd=conectar_bd();
				$sqlr="SELECT tipopredio FROM tesopredios WHERE cedulacatastral='$catastral'";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				$tipo=$r[0];
				/*$digitos=substr($catastral,5,2);echo $digitos;
				if($digitos=="00"){$tipo="rural";}
				else {$tipo="urbano";}*/
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
                    <td><input type="button" name="bboton" onClick="buscar()" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /><input type="button" name="bboton" onClick="reflejar()" value="&nbsp;&nbsp;Reflejar&nbsp;&nbsp;" /></td>
                </tr>
			</table>
			
			<?php
				
				if($_POST[oculto]==3)
				{
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
					if(isset($_POST[fechafin]) and isset($_POST[fechaini])){

						if(!empty($_POST[fechaini]) and !empty($_POST[fechafin])){
							$fechaInicial=date('Y-m-d',strtotime($_POST[fechaini]));
							$fechaFinal=date('Y-m-d',strtotime($_POST[fechafin]));
							$queryDate="AND T.fecha>='".$fechaInicial."' and T.fecha<='".$fechaFinal."'";
						}
					}
					$sqlr="select T.id_recibos, T.valor, T.estado,T.id_comp,T.descripcion from tesoreciboscaja T where T.estado!='N' $queryDate group by T.id_recibos";
					$resp=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)) 
					{
						
						$sq="select TD.ingreso,T.codigo,T.terceros from tesoreciboscaja_det TD,tesoingresos T where id_recibos='$row[0]' and TD.ingreso=T.codigo";
						$re=mysql_query($sq,$linkbd);
						$ro=mysql_fetch_row($re);
						$estilo="";
						$stado="";	
							
						$sql="select C.numerotipo,sum(C.valdebito),C.cuenta,sum(C.valcredito) from comprobante_det C  where C.numerotipo='$row[0]' and C.tipo_comp='5' and LEFT(cuenta,2)='11' ";
						//$sql = "SELECT numerotipo,sum(valdebito),sum(valcredito) from comprobante_det where numerotipo='$row[0]' and tipo_comp='5' and cuenta!=''";
						
						$rs=mysql_query($sql,$linkbd);
						$rw=mysql_fetch_row($rs);
						
						//Se verifica si existe el recibo en contabilidad
						if($rw[0] != null){
							$dif=$row[1]-$rw[1]+$rw[3];
						
							if($row[2]=='N'){
								$stado="color:red";
							}
							$difround = round($dif);
							if ($difround!=0)
							{
								$_POST[recaudocc][] = $row[0];
								$_POST[conceptocc][] = $row[4];
								$_POST[valtotaltescc][] = $row[1];
								$_POST[valtotalcontcc][] = $rw[1];
								$_POST[diferenciacc][] = round($dif);
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
			echo "<div class='subpantallac5' style='height:55%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>
				<table class='inicio' align='center' id='valores' >
				<tbody>";
				echo "<tr class='titulos'><td colspan='5'>.:Resultados: ".count($_POST[recaudocc])."</td></tr>";
				echo "<tr class='titulos ' style='text-align:center;'>
							<td ></td>
							<td ></td>
							<td >Tesoreria</td>
							<td >Contabilidad</td>
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
				for($n=0; $n<count($_POST[recaudocc]); $n++)
				{
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
										
									$sql="select * from tesoacuerdopredial where tesoacuerdopredial.idacuerdo=$_POST[idrecaudo] and (estado='S' or estado='P') ";
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
								$sqlr="SELECT * FROM tesoindustria WHERE id_industria='".$_POST['idrecaudo']."' AND 2='".$_POST['tiporec']."'";
								$_POST['encontro']="";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									$_POST['concepto']="Liquidacion Industria y Comercio avisos y tableros - $row[3]";
									$_POST['valorecaudo']=$row[6];
									$_POST['totalc']=$row[6];
									$_POST['tercero']=$row[5];
									$_POST['encontro']=1;
								}
								$sqlr="select *from tesoreciboscaja where  id_recibos='".$_POST['idcomp']."'";
								$res=mysql_query($sqlr,$linkbd);
								$row =mysql_fetch_row($res);
								$_POST['estadoc']=$row[9];
								if ($row[9]=='N'){$_POST['estadoc']='0';}
								else {$_POST[estadoc]='1';}
								preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",$row[2],$fecha);
								$_POST['fecha']="$fecha[3]/$fecha[2]/$fecha[1]";
								$_POST['modorec']=$row[5];
								$_POST['banco']=$row[7];
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
								if ($row[9]=='N'){$_POST[estadoc]='0';}
								else {$_POST[estadoc]='1';}
								$_POST[modorec]=$row[5];
								$_POST[banco]=$row[7];
							}break;
						}
						
						if($_POST[encontro]=='1')
							{
								switch($_POST['tiporec']) 
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
											$sqlr="select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo] and 1=$_POST[tiporec]";
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
										$_POST['dcoding']= array();
										$_POST['dncoding']= array();
										$_POST['dvalores']= array();
										$_POST[trec]='INDUSTRIA Y COMERCIO';
										if($_POST['tcobrorecibo']=='S')
										{	 
											$_POST['dcoding'][]=$_POST['cobrorecibo'];
											$_POST['dncoding'][]=buscaingreso($_POST['cobrorecibo'])." ".$vigusu;
											$_POST['dvalores'][]=$_POST['vcobrorecibo'];
										}
										$sqlr="SELECT * FROM tesoindustria WHERE id_industria='".$_POST['idrecaudo']."' AND  2='".$_POST['tiporec']."'";
										$res=mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($res)) 
										{
											$sqlr2="SELECT * FROM tesoingresos WHERE codigo='02'";
											$res2=mysql_query($sqlr2,$linkbd);
											$row2 =mysql_fetch_row($res2);
											$_POST['dcoding'][]=$row2[0];
											$_POST['dncoding'][]=$row2[1];
											if($row[8]>1){$_POST[dvalores][]=$row[6]/$row[8];}
											else{$_POST['dvalores'][]=$row[6];}
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
								$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='1' ";
								$res=mysql_query($sqlr,$linkbd);
								while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
								if($numerorecaudos>=0)
								{
									$sql="DELETE FROM comprobante_cab WHERE numerotipo='$_POST[idcomp]' AND  tipo_comp='5' ";
									mysql_query($sql,$linkbd);
									$sql="DELETE FROM comprobante_det WHERE numerotipo='$_POST[idcomp]' AND  tipo_comp='5' ";
									mysql_query($sql,$linkbd);
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
									$concecc=$_POST[idcomp];
									if(strpos($_POST[fecha],"-")===false)
									{
										preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
										$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
									}
									else{$fechaf=$_POST[fecha];}
									
									if($_POST[tipo]=='1')
									{
										$sql = "SELECT T1.porcentaje_valor,T1.valor_pago FROM tesoacuerdopredial_pagos T1 WHERE T1.idacuerdo=$_POST[idrecaudo] AND T1.cuota=$_POST[cuotas]";
										$dat = view($sql);
									}
									//************ insercion de cabecera recaudos ************
									echo "
									<input type='hidden' name='concec' value='$concecc'>
									<script>
										document.form2.vguardar.value='1';
										document.form2.numero.value='';
										document.form2.valor.value=0;
									</script>";
									//**********************CREANDO COMPROBANTE CONTABLE ********************************
									$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
									mysql_query($sqlr,$linkbd);
									
									//******parte para el recaudo del cobro por recibo de caja
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
														$valorcred=$_POST[dvalores][$x]*($porce/100);
														$valordeb=0;
														if($rowc[3]=='N')
														{
															//*****inserta del concepto contable  
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
															$vi=$_POST[dvalores][$x]*($porce/100);
															//****creacion documento presupuesto ingresos
															//************ FIN MODIFICACION PPTAL
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]', '$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
															//***cuenta caja o banco
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
															//$valordeb=$_POST[dvalores][$x]*($porce/100);
															//$valorcred=0;
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
														}
													}
												}
											}
										}
									}
									//*************** fin de cobro de recibo
									$sql="select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]";
									$resul=mysql_query($sql,$linkbd);
									$rowcod=mysql_fetch_row($resul);
									$tipopre=obtenerTipoPredio($rowcod[0]);
									if($_POST[tipo]=='1')
									{
										$sqlrs="select * from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo] ";
										$res=mysql_query($sqlrs,$linkbd);
										$rowd==mysql_fetch_row($res);
										$tasadesc=(($rowd[5]/$_POST[tcuotas])/100);
										$sqlr="select *from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo]";
									}
									else
									{
										$sqlrs="select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
										$res=mysql_query($sqlrs,$linkbd);
										$rowd==mysql_fetch_row($res);
										$tasadesc=($rowd[6]/100);
										$sqlr="select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo] and estado ='S' and 1=$_POST[tiporec]";
									}
									$res=mysql_query($sqlr,$linkbd);
									//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
									while ($row =mysql_fetch_row($res)) 
									{
										if($_POST[tipo]=='1')
										{
											$vig=$row[13];
											$vlrdesc=($row[9]/$_POST[tcuotas]);
										}
										else
										{
											$vig=$row[1];
											$vlrdesc=$row[10];
										}
										if($vig==$vigusu) //*************VIGENCIA ACTUAL *****************
										{
											$idcomp=$_POST[idcomp];
											$sqlr2="select * from tesoingresos_det where codigo='01' AND MODULO='4' and vigencia=$vigusu group by concepto";
											$res2=mysql_query($sqlr2,$linkbd);
											//****** $cuentacb   ES LA CUENTA CAJA O BANCO
											while($rowi =mysql_fetch_row($res2))
											{
												switch($rowi[2])
												{
													case '01': //Impuesto Predial Vigente
													{
														$sqlrds="select * from tesoingresos_det where codigo='01' and concepto='P01' AND modulo='4' and vigencia=$vigusu";
														$resds=mysql_query($sqlrds,$linkbd);
														while($rowds =mysql_fetch_row($resds)){$descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);}
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																if($_POST[tipo]=='1'){$valorcred=round($row[2]*$dat[0][porcentaje_valor],2);} 
																else{$valorcred=$row[4];}
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Impuesto Predial Vigente $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=round($valorcred-$descpredial,2);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Impuesto Predial Vigente $vig','','".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO ******
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL		
																	}
																}
															}
														}
													}break;  
													case '02': //Ingreso Sobretasa Ambiental
													{
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
																if($_POST[tipo]=='1'){$valorcred=round($row[7]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[8];}
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Ambiental $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Ingreso Sobretasa Ambiental $vig','','".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//*******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *******
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL
																	}
																}
															}
														}
													}break;  
													case '03': //Ingreso Sobretasa Bomberil
													{
														$sqlrds="select * from tesoingresos_det where codigo='01' and concepto='P10' AND modulo='4' and vigencia='$vigusu'";
														$resds=mysql_query($sqlrds,$linkbd);
														while($rowds =mysql_fetch_row($resds)){$descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);}
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																if($_POST[tipo]=='1'){$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[6];}
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]', '$rowc[5]','Ingreso Sobretasa Bomberil $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=round($valorcred-$descpredial,2);
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Bomberil $vig','', '".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//*********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL
																	}
																}
															}
														}
													}break;
													case 'P10': //Descuento Pronto Pago Bomberil
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																if($_POST[tipo]=='1'){$valordeb=round(round($row[9]*$dat[0][porcentaje_valor],2)*round(($porce/100),2),2);}
																else{$valordeb=round($row[10]*round(($porce/100),2),2);}
																$valorcred=0;
																if($rowc[3]=='N')
																{
																	if($valordeb>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Descuento Pronto Pago Bomberil $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
														}
													}break;
													case 'P01': //Descuento Pronto Pago Predial
													{ 
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																if($_POST[tipo]=='1'){$valordeb=round(round($row[9]*$dat[0][porcentaje_valor],2)*round(($porce/100),2),2);}
																else{$valordeb=round($row[10]*round($porce/100,2),2);}
																$valorcred=0;
																if($rowc[3]=='N')
																{
																	if($valordeb>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Descuento Pronto Pago Predial $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
														}
													}break;
													case 'P02': //Intereses Predial
													{ 
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																if($_POST[tipo]=='1'){$valorcred=round($row[3]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[5];}
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','".round($valordeb,0)."', '".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','".round($valordeb,0)."', '0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
																		$respto=mysql_query($sqlrpto,$linkbd);
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
															else
															{
																if($_POST[tipo]=='1'){$valorcred=round($row[3]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[5];}
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
															}
														}
													}break;
													case 'P04': //Intereses Sobretasa Bomberil
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{		
																if($_POST[tipo]=='1'){$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[7];}
																$valordeb=0;
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Sobretasa Bomberil $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Sobretasa Bomberil $vig','','".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
															else
															{
																if($_POST[tipo]=='1'){$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[7];}
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
															}
														}
													}break;  
													case 'P05': //Ingreso Sobtretasa Bomberil
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																if($_POST[tipo]=='1'){$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[6];}
																$valordeb=0;					
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{						
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1',''$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
														}
													}break;  
													case 'P07': //Intereses Sobtretasa Ambiental
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{		
																if($_POST[tipo]=='1'){$valorcred=round($row[8]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[9];}
																$valordeb=0;					
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{						
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobtretasa Ambiental $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]','Intereses Sobtretasa Ambiental $vig','','".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
														}
													}break;
													case 'P08': //Sobtretasa Ambiental
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																$valorcred=0;
																if($_POST[tipo]=='1'){$valordeb=round($row[7]*$dat[0][porcentaje_valor],2);}
																else{$valordeb=$row[8];}			  
															}
															if($rowc[6]=='N')
															{				 
																$valordeb=0;
																if($_POST[tipo]=='1'){$valorcred=round($row[7]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[8];}					
															}
															if($rowc[3]=='N')
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Sobtretasa Ambiental $vig','','".round($valordeb,0)."', '".round($valorcred,0)."', '1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);					
															}
														}
													}break;
													case 'P18': //***
													{
														$sqlca="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='COBRO_ALUMBRADO' AND tipo='S'";
														$resca=mysql_query($sqlca,$linkbd);
														while ($rowca =mysql_fetch_row($resca)) 
														{
															$cobroalumbrado=$rowca[0];
															$vcobroalumbrado=$rowca[1];
															$tcobroalumbrado=$rowca[2];
														}
														if($tcobroalumbrado=='S' && $tipopre=='rural')
														{
															$valorAlumbrado=round($row[2]*($vcobroalumbrado/1000),0);
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
																	$valorcred=$valorAlumbrado;
																	$valordeb=0;
																	if($rowc[3]=='N')
																	{
																		if($valorcred>0)
																		{
																			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero, centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]', 'Ingreso Impuesto sobre el Servicio de Alumbrado P�blico $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			$valordeb=$valorcred;
																			$sqlr="insert into comprobante_det (id_comp, cuenta,tercero, centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc', '$cuentacb','$_POST[tercero]', '$rowc[5]', 'Ingreso Impuesto sobre el Servicio de Alumbrado P�blico $vig','', '".round($valordeb,0)."','0','1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			//*******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *******
																			$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																			$respto=mysql_query($sqlrpto,$linkbd);	  
																			$rowpto=mysql_fetch_row($respto);
																			$vi=$valordeb;
																			//****creacion documento presupuesto ingresos
																			//************ FIN MODIFICACION PPTAL			
																		}
																	}
																}
															}
														}
													}break;
												}
											}
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;
											if($_POST[tipo]=='1'){$_POST[dvalores][]=round($row[10]*$dat[0][porcentaje_valor],2);}
											else{$_POST[dvalores][]=$row[11];}
										}
										else  ///***********OTRAS VIGENCIAS ***********
										{	
											if($_POST[tipo]=='1')
											{$tasadesc=0;}
											else{$tasadesc=$row[10]/($row[4]+$row[6]);}
											
											$idcomp=$_POST[idcomp];	
											
											$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
											mysql_query($sqlr,$linkbd);
											$sqlr2="select * from tesoingresos_DET where codigo='03' AND MODULO='4' and vigencia=$vigusu GROUP BY concepto";
											$res2=mysql_query($sqlr2,$linkbd);
											//****** $cuentacb   ES LA CUENTA CAJA O BANCO
											while($rowi =mysql_fetch_row($res2))
											{
												switch($rowi[2])
												{
													case 'P03': //Ingreso Impuesto Predial Otras Vigencias
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
																$valdescuento = 0;
																if($_POST[tipo]=='1')
																{
																	$valdescuento = round($row[9]*$dat[0][porcentaje_valor],2);
																	$valorcred=round($row[2]*$dat[0][porcentaje_valor],2)-$valdescuento;
																	
																}
																else{
																	$valdescuento = $row[10];
																	$valorcred=$row[4]-$valdescuento;
																}
																
																$valordeb=0;					
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{						
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Impuesto Predial Otras Vigencias $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Impuesto Predial Otras Vigencias $vig','','".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$sq="select fechainicial from conceptoscontables_det where codigo='P01' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
																		$re=mysql_query($sq,$linkbd);
																		while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
																		$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = 'P01' and tipo='C' and fechainicial='$_POST[fechacausa]'";
																		$resc=mysql_query($sqlrc,$linkbd);	  
																		while($rowc=mysql_fetch_row($resc))
																		{
																			$sqlrdes="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Descuento Pago Predial $vig','', '".round($desc,0)."','0','1','$_POST[vigencia]')";
																			mysql_query($sqlrdes,$linkbd);
																		}
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL		
																	}
																}
															}
														}
													}break;  
													case 'P06': //Ingreso Sobretasa Ambiental
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{		
																if($_POST[tipo]=='1'){$valorcred=round($row[7]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[8];}
																$valordeb=0;					
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{						
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Ambiental $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Ambiental $vig','', '".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
														}
													}break;  
													case '03': //Ingreso Sobretasa Bomberil
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																if($_POST[tipo]=='1'){$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[6];}
																$valordeb=0;					
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{						
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Bomberil $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred-$tasadesc*$valorcred;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Sobretasa Bomberil $vig','','".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
														}
													}break;  
													case 'P01': //Descuento Pronto Pago
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{		
																if($_POST[tipo]=='1'){$valordeb=round($row[9]*$dat[0][porcentaje_valor],2);}
																else{$valordeb=$row[10];}
																$valorcred=0;					
																if($rowc[3]=='N')
																{
																	if($valordeb>0)
																	{						
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Descuento Pronto Pago $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																	}
																}
															}
														}
													}break;  
													case 'P02': //Intereses Predial
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='".$rowi[2]."' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															$valdescuento=0;
														
															if($rowc[6]=='S')
															{	
																if($_POST[tipo]=='1')
																{
																	//Se obtienen descuentos en caso de haberlos
																	$valdescuento = round($row[4]*$dat[0][porcentaje_valor],2);
																	$valorcred=round($row[3]*$dat[0][porcentaje_valor],2)-$valdescuento;	
																}
																else 
																{
																	$valorcred=$row[5];
																}
															
																$valordeb=0;
																
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','".round($valordeb,0)."', '".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Predial $vig','','".round($valordeb,0)."', 0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
															else
															{
																if($_POST[tipo]=='1')
																{
																	$valdescuento = round($row[4]*$dat[0][porcentaje_valor],2);
																	$valorcred=round($row[3]*$dat[0][porcentaje_valor],2)-$valdescuento;
																}
																else 
																{
																	$valorcred=$row[5];
																}
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Predial $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
															}
														}
													}break;  
													case 'P04': //Intereses Sobretasa Bomberil
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																if($_POST[tipo]=='1'){$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[7];}
																$valordeb=0;					
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{						
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Sobretasa Bomberil $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Sobretasa Bomberil $vig','','".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','".round($valorcred,0)."','0','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
															else
															{
																if($_POST[tipo]=='1'){$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[7];}
																$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '$rowc[4]','$_POST[tercero]', '$rowc[5]','Intereses Sobretasa Bomberil $vig','','0','".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
															}
														}
													}break;  
													case 'P05': //Ingreso Sobtretasa Bomberil Otras Vigencias
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{		
																if($_POST[tipo]=='1'){$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);}
																else{$valorcred=$row[6];}
																$valordeb=0;					
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','','".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
															
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
														}
													}break;  
													case 'P07': //Intereses Sobtretasa Ambiental
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($rowc[6]=='S')
															{	
																if($_POST[tipo]=='1'){$valorcred=round($row[8]*$dat[0][porcentaje_valor],2);}
																else {$valorcred=$row[9];}
																$valordeb=0;					
																if($rowc[3]=='N')
																{
																	if($valorcred>0)
																	{						
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Intereses Sobtretasa Ambiental $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		$valordeb=$valorcred;
																		$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Intereses Sobtretasa Ambiental $vig','','".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																		$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
																		$respto=mysql_query($sqlrpto,$linkbd);	  
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		//****creacion documento presupuesto ingresos
																		//************ FIN MODIFICACION PPTAL	
																	}
																}
															}
														}
													}break;  
													case 'P08': 
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$resc=mysql_query($sqlrc,$linkbd);	  
														while($rowc=mysql_fetch_row($resc))
														{
															$porce=$rowi[5];
															if($_POST[tipo]=='1'){$valnu=round($row[7]*$dat[0][porcentaje_valor],2);}
															else{$valnu=$row[8];}
															if($rowc[6]=='S')
															{				 
																$valorcred=0;
																$valordeb=$valnu;				
															}
															if($rowc[6]=='N')
															{				 
																$valorcred=$valnu;
																$valordeb=0;					
															}
															if($rowc[3]=='N')
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Sobtretasa Ambiental $vig','','".round($valordeb,0)."', '".round($valorcred,0)."','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);						
															}
														}
													}break;
													case 'P18': //***
													{
														$sqlca="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='COBRO_ALUMBRADO' AND tipo='S'";
														$resca=mysql_query($sqlca,$linkbd);
														while ($rowca =mysql_fetch_row($resca)) 
														{
															$cobroalumbrado=$rowca[0];
															$vcobroalumbrado=$rowca[1];
															$tcobroalumbrado=$rowca[2];
														}
														if($tcobroalumbrado=='S' && $tipopre=='rural')
														{
															$valorAlumbrado=round($row[2]*($vcobroalumbrado/1000),0);
															$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
															$re=mysql_query($sq,$linkbd);
															while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
															$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
															$resc=mysql_query($sqlrc,$linkbd);
															while($rowc=mysql_fetch_row($resc))
															{
																$porce=$rowi[5];
																if($rowc[6]=='S')
																{
																	$valorcred=$valorAlumbrado;
																	$valordeb=0;
																	if($rowc[3]=='N')
																	{
																		if($valorcred>0)
																		{
																			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso Impuesto sobre el Servicio de Alumbrado P�blico $vig','', '".round($valordeb,0)."','".round($valorcred,0)."','1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			$valordeb=$valorcred;
																			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso Impuesto sobre el Servicio de Alumbrado P�blico $vig','', '".round($valordeb,0)."',0,'1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																			$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
																			$respto=mysql_query($sqlrpto,$linkbd);	  
																			$rowpto=mysql_fetch_row($respto);
																			$vi=$valordeb;
																			//****creacion documento presupuesto ingresos
																			//************ FIN MODIFICACION PPTAL	
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
									//*******************  
									if($_POST[tipo]=='1')
									{
										$sqlr="Select *from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo]";
										$resp=mysql_query($sqlr,$linkbd);
										while($row=mysql_fetch_row($resp,$linkbd))
										{
											$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[13]";
											mysql_query($sqlr2,$linkbd);
										}
									}
									else
									{
										$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
										$resp=mysql_query($sqlr,$linkbd);
										while($row=mysql_fetch_row($resp,$linkbd))
										{
											$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[1]";
											mysql_query($sqlr2,$linkbd);
										}
									}
									
								} //fin de la verificacion
								//***FIN DE LA VERIFICACION
							}break;
							case 2:  //********** INDUSTRIA Y COMERCIO
							{
								$valorcuentabanco=0;
								$sqlr="SELECT tmindustria,desindustria,desavisos,desbomberil,intindustria,intavisos,intbomberil FROM tesoparametros";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res))
								{
									$descunidos="$row[1]$row[2]$row[3]";
									$intecunidos="$row[4]$row[5]$row[6]";
								}
								if(strpos($_POST['fecha'],"-")===false)
								{
									preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
									$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
								}
								else{$fechaf=$_POST['fecha'];}
								$sqlr="SELECT count(*) FROM tesoreciboscaja WHERE id_recaudo='".$_POST['idrecaudo']."' AND tipo='2'";
								$res=mysql_query($sqlr,$linkbd);
								while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0]; }
								if($numerorecaudos>=0)
								{
									$sqlr="delete from comprobante_cab where numerotipo='".$_POST['idcomp']."' and tipo_comp='5'";
									mysql_query($sqlr,$linkbd);
									$sqlr="delete from comprobante_det where id_comp='5 ".$_POST['idcomp']."'";
									mysql_query($sqlr,$linkbd);
									if (!mysql_query($sqlr,$linkbd))
									{
										echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la peticion: <br><font color=red><b>$sqlr</b></font></p>Ocurrio el siguiente problema:<br><pre></pre></center></td></tr></table>";
									}
									else
									{
										
										$concecc=$_POST['idcomp']; 
										//*************COMPROBANTE CONTABLE INDUSTRIA
										$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito, total_credito,diferencia,estado) values ($concecc,5,'$fechaf','".$_POST['concepto']."',0, '".$_POST['totalc']."','".$_POST['totalc']."',0,'".$_POST['estadoc']."')";
										mysql_query($sqlr,$linkbd);
										$idcomp=$_POST['idcomp'];
										if($_POST['modorec']=='caja')
										{				 
											$cuentacb=$_POST['cuentacaja'];
											$cajas=$_POST['cuentacaja'];
											$cbancos="";
										}
										if($_POST['modorec']=='banco')
										{
											$cuentacb=$_POST['banco'];
											$cajas="";
											$cbancos=$_POST['banco'];
										}
										//******parte para el recaudo del cobro por recibo de caja
										for($x=0;$x<count($_POST['dcoding']);$x++)
										{
											if($_POST['dcoding'][$x]==$_POST['cobrorecibo'])
											{
												//***** BUSQUEDA INGRESO ********
												$sqlri="Select * from tesoingresos_det where codigo='".$_POST['dcoding'][$x]."' and vigencia='$vigusu'";
												$resi=mysql_query($sqlri,$linkbd);
												while($rowi=mysql_fetch_row($resi))
												{
													//**** busqueda cuenta presupuestal*****
													//busqueda concepto contable
													$sqlrc="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$rowi[2]' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$rowi[2]' AND tipo='C' AND fechainicial<='$fechaf')";
													$resc=mysql_query($sqlrc,$linkbd);	  
													while($rowc=mysql_fetch_row($resc))
													{
														$porce=$rowi[5];
														if($rowc[7]=='S')
														{				 
															$valorcred=$_POST[dvalores][$x]*($porce/100);
															$valordeb=0;
															if($rowc[3]=='N')
															{
																//*****inserta del concepto contable  
																//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
																$sqlrpto="SELECT * FROM pptocuentas WHERE estado='S' AND cuenta='$rowi[6]' AND vigencia = '$vigusu'";
																$respto=mysql_query($sqlrpto,$linkbd);	  
																$rowpto=mysql_fetch_row($respto);
																$vi=$_POST[dvalores][$x]*($porce/100);
																//****creacion documento presupuesto ingresos
																//************ FIN MODIFICACION PPTAL
																$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$rowc[4]','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','$valordeb','$valorcred','1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																if($_POST['banco']==$rowc[4])
																{
																	$valorcuentabanco=$valorcuentabanco+($valordeb-$valorcred);
																}
																//***cuenta caja o banco
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
																$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','','$valorcred',0,'1','$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
																if($_POST['banco']==$valorcred)
																{
																	$valorcuentabanco=$valorcuentabanco+$valorcred;
																}
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
											$sqlr="SELECT ncuotas FROM tesoindustria WHERE id_industria='$_POST[idrecaudo]'";
											$res=mysql_query($sqlr,$linkbd);
											$row=mysql_fetch_row($res);
											$ncuotas=$row[0];
											$sqlr="SELECT * FROM tesoindustria_det WHERE id_industria='$_POST[idrecaudo]'";
										
											$res=mysql_query($sqlr,$linkbd);
											$row=mysql_fetch_row($res);
											$industria=$row[1];
											$avisos=$row[2];
											$bomberil=$row[3];
											$retenciones=$row[4]+$row[18];
											$saldoafavor=$row[20];
											$sanciones=$row[5];
											$intereses=$row[25];	
											$interesesind=$row[26];
											$interesesavi=$row[27];
											$interesesbom=$row[28];	
											$antivigact=$row[11];
											$antivigant=$row[10];
											$saldopagar=$row[8];
											if((float)$intereses>0)//intereses
											{
												$intetodos=(float)$interesesind+(float)$interesesavi+(float)$interesesbom;
												if($intetodos>0)
												{
													$indinteres=(float)$interesesind;
													$aviinteres=(float)$interesesavi;
													$bominteres=(float)$interesesbom;
												}
												else
												{
													$indinteres=(float)$intereses;
													$aviinteres=0;
													$bominteres=0;
												}
											}
											if(($row[21]>0)|| ($row[13]>0))//descuentos
											{
												if(($row[22]+$row[23]+$row[24])>0)
												{
													$descuenindus=$row[22];//descuento industria
													$descuenaviso=$row[23];//descuento avisos
													$descuenbombe=$row[24];//descuento bomberil
												}
												else
												{
													if(substr($descunidos, -3, 1)=='S')//descuento industria
													{$descuenindus=$row[1]*($row[13]/100);}
													else{$descuenindus=0;}
													if(substr($descunidos, -2, 1)=='S')//descuento avisos
													{$descuenaviso=$row[2]*($row[13]/100);}
													else {$descuenaviso=0;}
													if(substr($descunidos, -1, 1)=='S')//descuento bomberil
													{$descuenbombe=$row[3]*($row[13]/100);}
													else{$descuenbombe=0;}
												}
											}
											$totalica01=$industria+$indinteres+$sanciones-$descuenindus;
											$totalica=$industria+$indinteres+$sanciones-$descuenindus-$retenciones-$antivigant-$saldoafavor;
											$totalbombe=$bomberil-$descuenbombe+$interesesbom;
											$totalavisos=$avisos-$descuenaviso+$interesesavi;
											if($ncuotas>1)
											{
												$totalica=$totalica/$ncuotas;
												$totalbombe=$totalbombe/$ncuotas;
												$totalavisos=$totalavisos/$ncuotas;
											}
											$valorcred=$valordeb=$saldo01=$auxreten=$auxsaldoafavor=$auxantivigant=0;
											$sqlri="SELECT * FROM tesoingresos_det WHERE codigo='".$_POST[dcoding][$x]."' AND vigencia='$vigusu' ORDER BY concepto ASC";
											$res=mysql_query($sqlri,$linkbd);
											while($row=mysql_fetch_row($res))
											{
												switch($row[2])
												{
													case '04': //*****industria
													{
														$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='04' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='04' AND tipo='C' AND fechainicial<='$fechaf')";
														$res2=mysql_query($sqlr2,$linkbd);
														while($row2=mysql_fetch_row($res2))
														{
															$numcc=$row2[5];
															if($row2[3]=='N')
															{
																if($row2[6]=='S')
																{	
																	$valorcred=$totalica01;$cuentaica=$row2[4];
																	$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','Industria y Comercio $_POST[ageliquida]','',0, '$valorcred','1', '$_POST[vigencia]')";
																	mysql_query($sqlr,$linkbd);
																	if($_POST['banco']==$row2[4])
																	{
																		$valorcuentabanco=$valorcuentabanco+(0-$valorcred);
																	}
																	//********** CAJA O BANCO
																	$auxica=$totalica01;
																	if($retenciones>0)//si hay retencion 
																	{
																		$cuentacbr=buscanumcuenta('P11',$fechaf);
																		$auxica=$auxica-$retenciones;
																		if($auxica>=0){$valordeb=$retenciones;$auxreten=0;}
																		else{$valordeb=$retenciones+$auxica;$auxreten=abs($auxica);}
																		$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Retenci�n Industria y Comercio $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		if($_POST['banco']==$cuentacbr)
																		{
																			$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																		}
																	}
																	
																	if($saldoafavor>0 && $auxica>0)//si hay saldo a favor
																	{
																		$cuentacbr=buscanumcuenta('P13',$fechaf);
																		$auxica=$auxica-$saldoafavor;
																		if($auxica>=0){$valordeb=$saldoafavor;$auxsaldoafavor=0;}
																		else{$valordeb=$saldoafavor+$auxica;$auxsaldoafavor=abs($auxica);}
																		$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle ,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Industria y Comercio $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		if($_POST['banco']==$cuentacbr)
																		{
																			$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																		}
																	}
																	if($antivigant>0 && $auxica>0)//si hay saldo vigencia Anterior
																	{
																		$cuentacbr=buscanumcuenta('P13',$fechaf);
																		$auxica=$auxica-$antivigant;
																		if($auxica>=0){$valordeb=$antivigant;$auxantivigant=0;}
																		else{$valordeb=$antivigant+$auxica;$auxantivigant=abs($auxica);}
																		$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle ,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Industria y Comercio $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		if($_POST['banco']==$cuentacbr)
																		{
																			$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																		}
																	}
																	if($auxica>0)//si queda saldo ICA lo toma del banco
																	{
																		$valordeb=$auxica;
																		$cuentacbr=$cuentacb;
																		$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Industria y Comercio $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		if($_POST['banco']==$cuentacbr)
																		{
																			$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																		}
																	}
																}
															}
														}
														
													}break;
													case '05'://************avisos
													{
														if($avisos>0)
														{
															$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='05' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='05' AND tipo='C' AND fechainicial<='$fechaf')";
															$res2=mysql_query($sqlr2,$linkbd);
															while($row2=mysql_fetch_row($res2))
															{
																if($row2[3]=='N')
																{
																	if($row2[6]=='S')
																	{				 
																		$valordeb=0;
																		$valorcred=$totalavisos;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','Avisos y Tableros $_POST[ageliquida]','','0', '$valorcred','1', '$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		if($_POST['banco']==$row2[4])
																		{
																			$valorcuentabanco=$valorcuentabanco+$valorcred;
																		}
																		//********** CAJA O BANCO
																		$auxavisos=$totalavisos;
																		if($retenciones>0 && $auxreten>0)//si hay retencion 
																		{
																			$reteavi=$auxreten;
																			$cuentacbr=buscanumcuenta('P11',$fechaf);
																			$auxavisos=$auxavisos-$reteavi;
																			if($auxavisos>=0){$valordeb=$reteavi;$auxreten=0;}
																			else{$valordeb=$reteavi+$auxavisos;$auxreten=abs($auxavisos);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Retenci�n Avisos y Tableros $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																		if($saldoafavor>0 && $auxavisos>0 && $auxsaldoafavor>0)//si hay saldo a favor
																		{
																			$salfaavi=$auxsaldoafavor;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxavisos=$auxavisos-$salfaavi;
																			if($auxavisos>=0){$valordeb=$salfaavi;$auxsaldoafavor=0;}
																			else{$valordeb=$salfaavi+$auxavisos;$auxsaldoafavor=abs($auxavisos);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Avisos y Tableros $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																		if($antivigant>0 && $auxavisos>0 && $auxantivigant>0)//saldo vigencia Anterio
																		{
																			$svantavi=$auxantivigant;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxavisos=$auxavisos-$svantavi;
																			if($auxavisos>=0){$valordeb=$svantavi;$auxantivigant=0;}
																			else{$valordeb=$svantavi+$auxavisos;$auxantivigant=abs($auxavisos);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a vigencia Anterior Avisos y tableros $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																		if($auxavisos>0)//si queda saldo avisos lo toma del banco
																		{
																			$valordeb=$auxavisos;
																			$cuentacbr=$cuentacb;
																			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','Avisos y Tableros $_POST[modorec]','', '$valordeb','0','1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																	}
																}
															}
														}
													}break;	
													case '06': //*********bomberil ********
													{
														if($bomberil>0)
														{
															$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='06' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='06' AND tipo='C' AND fechainicial<='$fechaf')";
															$res2=mysql_query($sqlr2,$linkbd);
															while($row2=mysql_fetch_row($res2))
															{
																if($row2[3]=='N')
																{
																	if($row2[6]=='S')
																	{
																		$valordeb=0;
																		$valorcred=$totalbombe;
																		$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','Bomberil $_POST[ageliquida]', '','$valordeb', '$valorcred','1', '$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		if($_POST['banco']==$row2[4])
																		{
																			$valorcuentabanco=$valorcuentabanco+($valordeb-$valordeb);
																		}
																		//********** CAJA O BANCO
																		$auxbombe=$totalbombe;
																		if($retenciones>0 && $auxreten>0)//si hay retencion 
																		{
																			$retebombe=$auxreten;
																			$cuentacbr=buscanumcuenta('P11',$fechaf);
																			$auxbombe=$auxbombe-$retebombe;
																			if($auxbombe>=0){$valordeb=$retebombe;$auxreten=0;}
																			else{$valordeb=$retebombe+$auxbombe;$auxreten=abs($auxbombe);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Retenci�n Bomberil $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																		if($saldoafavor>0 && $auxbombe>0 && $auxsaldoafavor>0)//si hay saldo a favor
																		{
																			$salfabombe=$auxsaldoafavor;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxbombe=$auxbombe-$salfabombe;
																			if($auxbombe>=0){$valordeb=$salfabombe;$auxsaldoafavor=0;}
																			else{$valordeb=$salfabombe+$auxbombe;$auxsaldoafavor=abs($auxbombe);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Bomberil $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																		if($antivigant>0 && $auxbombe>0 && $auxantivigant>0)//saldo vigencia Anterio
																		{
																			$svantbombe=$auxantivigant;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxbombe=$auxbombe-$svantbombe;
																			if($auxbombe>=0){$valordeb=$svantbombe;$auxantivigant=0;}
																			else{$valordeb=$svantbombe+$auxbombe;$auxantivigant=abs($auxbombe);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a vigencia Anterior Avisos y tableros $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																		if($auxbombe>0)//si queda saldo bomberil lo toma del banco
																		{
																			$valordeb=$auxbombe;
																			$cuentacbr=$cuentacb;
																			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito, estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','Bomberil $_POST[modorec]', '','$valordeb','0', '1','$_POST[vigencia]' )";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																	}
																}
															}
														}
													}break;
													case 'P12'://Anticipo vigencia Actual
													{
														if($antivigact>0)
														{
															$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P12' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P12' AND tipo='C' AND fechainicial<='$fechaf')";
															$res2=mysql_query($sqlr2,$linkbd);
															while($row2=mysql_fetch_row($res2))
															{
																if($row2[3]=='N')
																{
																	if($row2[6]=='N')
																	{
																		$valorcred=$antivigact;
																		$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentaica','$_POST[tercero]','$row2[5]','Anticipo vigencia Actual $_POST[ageliquida]','',0, '$valorcred','1', '$_POST[vigencia]')";
																		mysql_query($sqlr,$linkbd);
																		if($_POST['banco']==$cuentaica)
																		{
																			$valorcuentabanco=$valorcuentabanco+(0-$valorcred);
																		}
																		//********** CAJA O BANCO
																		$auxantivigact=$antivigact;
																		if($retenciones>0 && $auxreten>0)//si hay retencion 
																		{
																			$retevigact=$auxreten;
																			$cuentacbr=buscanumcuenta('P11',$fechaf);
																			$auxantivigact=$auxantivigact-$retevigact;
																			if($auxantivigact>=0){$valordeb=$retevigact;$auxreten=0;}
																			else{$valordeb=$retevigact+$auxantivigact;$auxreten=abs($auxantivigact);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Retenci�n Anticipo vigencia Actual $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																		if($saldoafavor>0 && $auxantivigact>0 && $auxsaldoafavor>0)//hay saldo a favor
																		{
																			$salfavigact=$auxsaldoafavor;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxantivigact=$auxantivigact-$salfavigact;
																			if($auxantivigact>=0){$valordeb=$salfavigact;$auxsaldoafavor=0;}
																			else{$valordeb=$salfavigact+$auxantivigact;$auxsaldoafavor=abs($auxantivigact);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a Favor del Perido Anterior Anticipo vigencia Actual $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																		if($antivigant>0 && $auxantivigact>0 && $auxantivigant>0)//saldo vigencia Anter
																		{
																			$svantvigact=$auxantivigant;
																			$cuentacbr=buscanumcuenta('P13',$fechaf);
																			$auxantivigact=$auxantivigact-$svantvigact;
																			if($auxantivigact>=0){$valordeb=$svantvigact;$auxantivigant=0;}
																			else{$valordeb=$svantvigact+$auxavisos;$auxantivigant=abs($auxantivigact);}
																			$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentacbr','$_POST[tercero]','$row2[5]','Saldo a vigencia Anterior Anticipo vigencia Actual $_POST[modorec]','','$valordeb','0', '1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																		if($auxantivigact>0)//si queda saldo avisos lo toma del banco
																		{
																			$valordeb=$auxantivigact;
																			$cuentacbr=$cuentacb;
																			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','Anticipo vigencia Actual $_POST[modorec]','', '$valordeb','0','1','$_POST[vigencia]')";
																			mysql_query($sqlr,$linkbd);
																			if($_POST['banco']==$cuentacbr)
																			{
																				$valorcuentabanco=$valorcuentabanco+($valordeb-0);
																			}
																		}
																	}
																}
															}
														}
													}break;
												}
											}
										}
										//**************Ajuste de redondeo******************
										$diferenciatotal=$_POST['valorecaudo']-$valorcuentabanco;
										if($diferenciatotal!=0)
										{
											$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_MILES'";
											$res=mysql_query($sqlr,$linkbd);
											while ($row =mysql_fetch_row($res)){$cuentaredondeos=$row[0];}
											if($diferenciatotal>0)
											{
												$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','".$_POST['banco']."','".$_POST['tercero']."','$numcc','AJUSTE DE REDONDEO','0',$diferenciatotal,'0','1', '".$_POST['vigencia']."')";
												mysql_query($sqlr,$linkbd);
												$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentaredondeos','".$_POST['tercero']."','$numcc','AJUSTE DE REDONDEO','0','0',$diferenciatotal,'1', '".$_POST['vigencia']."')";
												mysql_query($sqlr,$linkbd);
											}
											else
											{
												$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','".$_POST['banco']."','".$_POST['tercero']."','$numcc','AJUSTE DE REDONDEO','0','0',".abs($diferenciatotal).",'1', '".$_POST['vigencia']."')";
												mysql_query($sqlr,$linkbd);
												$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque, valdebito,valcredito,estado,vigencia) VALUES ('5 $concecc','$cuentaredondeos','".$_POST['tercero']."','$numcc','AJUSTE DE REDONDEO','0',".abs($diferenciatotal).",'0','1', '".$_POST['vigencia']."')";
												mysql_query($sqlr,$linkbd);
											}
										}
									}
								}
								
							}break; 
							case 3: //**************OTROS RECAUDOS
							{
								$sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='5'";
								mysql_query($sqlr,$linkbd);
								$sqlr="delete from comprobante_det where  numerotipo=$_POST[idcomp] and tipo_comp='5'";
								mysql_query($sqlr,$linkbd);
								if(strpos($_POST[fecha],"-")===false)
								{
									preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
									$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
								}
								else{$fechaf=$_POST[fecha];}
								//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
								//***busca el consecutivo del comprobante contable
								$consec=$_POST[idcomp];
								//***cabecera comprobante
								$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito, diferencia,estado) values ($consec,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estadoc]')";
								mysql_query($sqlr,$linkbd);
								$idcomp=mysql_insert_id();
								//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
								for($x=0;$x<count($_POST[dcoding]);$x++)
								{
									//***** BUSQUEDA INGRESO ********
									$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
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
											if($rowc[6]=='S' and $_POST[dcoding][$x]!=$_POST[cobrorecibo])
											{				 			  
												$cuenta=$rowc[4];
												$valorcred=$_POST[dvalores][$x]*($porce/100);
												$valordeb=0;
												if($rowc[3]=='N')
												{
													//*****inserta del concepto contable  
													//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
													$respto=mysql_query($sqlrpto,$linkbd);	  
													$rowpto=mysql_fetch_row($respto);
													$vi=$_POST[dvalores][$x]*($porce/100);
													//****creacion documento presupuesto ingresos
													$sql="SELECT terceros FROM tesoingresos WHERE codigo=".$_POST[dcoding][$x] ;
													$res=mysql_query($sql,$linkbd);
													$row= mysql_fetch_row($res);
													//************ FIN MODIFICACION PPTAL
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $consec','$cuenta','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','', '$valordeb.','$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
													//***cuenta caja o banco
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
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $consec','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','', '$valorcred',0,'1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
												}
											}
											if($_POST[dcoding][$x]==$_POST[cobrorecibo] and $rowc[7]=='S')
											{
												$cuenta=$rowc[4];
												$valorcred=$_POST[dvalores][$x]*($porce/100);
												$valordeb=0;
												if($rowc[3]=='N')
												{
													//*****inserta del concepto contable  
													//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
													$respto=mysql_query($sqlrpto,$linkbd);	  
													$rowpto=mysql_fetch_row($respto);
													$vi=$_POST[dvalores][$x]*($porce/100);
													$sql="SELECT terceros FROM tesoingresos WHERE codigo='".$_POST[dcoding][$x]."'";
													$res=mysql_query($sql,$linkbd);
													$row= mysql_fetch_row($res);
													//****creacion documento presupuesto ingresos
													//************ FIN MODIFICACION PPTAL
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $consec','$cuenta','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','', '$valordeb','$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
													//***cuenta caja o banco
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
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('5 $consec','$cuentacb','$_POST[tercero]','$rowc[5]','Ingreso ".strtoupper($_POST[dncoding][$x])."','', '$valorcred',0,'1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);
												}			  
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