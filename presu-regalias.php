<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	require "validaciones.inc";
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
		<meta http-equiv="expira" content="no-cache">
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/cssrefresh.js">
        <script type="text/javascript" src="botones.js"></script>
		<script src="JQuery/jquery-2.1.4.min.js"></script>
        <script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>

			function guardar()
			{
				var concepto=document.form2.concepto.value;
				var conta=document.form2.contador.value;
				if(concepto!='' && conta>0){
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				
				}else{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
				}

			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.form2.oculto.value=2;
						document.form2.action="presu-regalias.php";
						document.form2.submit();
						break;
					case "2":	
						document.form2.oculto12.value=1;
						document.form2.action="presu-regalias.php";
						document.form2.submit();
						break;
				}
			}

			function excell()
			{
				//code
				document.form2.action="presu-regaliasexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";

			}

			function buscar(){
				document.form2.oculto.value=3;
				document.form2.submit();
			}

			function verificasaldo(posicion){
				var arreglo=document.getElementsByName("totalval[]");
				var valortot=arreglo.item(posicion).value;
				var valorin=document.getElementById("valores"+posicion).value;
				var nueva=parseInt(limpiarNumero(valorin));
				var saldo=valortot-nueva;
				if(saldo<0){
					alert("El saldo es negativo");
					document.getElementById("valores"+posicion).value=valortot;
					
				}
				document.form2.submit();
			}

			function limpiarNumero(numero){
				var acum="";
				for(var i=0;i<numero.length;i++){
					if(!(numero.charAt(i)=='$' || numero.charAt(i)=='.')){
						acum+=numero.charAt(i);
					}
				}
				return acum;
			}
			function cambiar(objeto){
				var check=objeto.checked;
				if(check){
					document.form2.contador.value=parseInt(document.form2.contador.value)+1;
				}else{
					document.form2.contador.value=parseInt(document.form2.contador.value)-1;
				}
				document.form2.submit();
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
			function aprobar(obj){
				var cont=document.form2.maximo.value;
				for(var i=0; i<cont; i++){
					var checks=document.getElementById("chkrecibo["+i+"]");
					if(obj.checked){
						checks.checked=true;
					}else{
						checks.checked=false;
					}
				}
				document.form2.submit();
			}
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				var vigencia=document.form2.vigencia.value;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case 1:	
							document.getElementById('ventana2').src="ventana-regalias.php?vigencia="+vigencia; 
						break;
						case "2": 	
							document.getElementById('ventana2').src="ingresosRegalias-ventana01.php";
						break;
					}
				}
			}
			function validar2(){
				document.form2.oculto.value=3;
				document.form2.submit();
			}
			function validar()
			{
				document.form2.submit();
			}
			function funcionmensaje()
			{
				var _cons=document.getElementById('ncomp').value;
				document.location.href = "presu-regaliasver.php?codigo="+_cons;
			}
			function agregardetalle()
			{
				if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
				{ 
					document.form2.agregadet.value=1;
					document.form2.oculto.value=3;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}

			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
		</script>
		<?php titlepag();clearstatcache();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
  			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
      		<tr><?php menu_desplegable("presu");?></tr>
            <tr>
     			<td colspan="3" class="cinta">
					<a href="presu-regalias.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="presu-buscaregalias.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="excell()"><img src="imagenes/excel.png"  alt="excel" title="Excel"></a>
				</td> 
     		</tr>
		</table>
   		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		
 		 <form name="form2" method="post" action="presu-regalias.php">
			<?php
			function limpiarnum($numero)
			{
				$acum="";
				if(strpos($numero,"$")===false){
					return $numero;
				}else{
					for($i=0;$i<strlen($numero);$i++ ){
					if(!($numero[$i]=='$' || $numero[$i]=='.')){
						$acum.=$numero[$i];
					}
				}
					$pos=strpos($acum,",");
					return substr($acum,0,$pos);
				}
				
			}
			if(!$_POST[oculto])
			{
				$_POST[contador]=0;
			}
			
			if($_POST[oculto]=="" || $_POST[tipomovimiento]=="101")
			{
				$_POST[tipomovimiento]="101";
				$vigencia=vigencia_usuarios($_SESSION[cedulausu]);
				$sql="SELECT MAX(codigo) FROM pptoregalias_cab";
				$res=mysql_query($sql,$linkbd);
				$row = mysql_fetch_row($res);
				$_POST[ncomp]=$row[0]+1;
				$_POST[fecha]=date("Y/m/d");
				$_POST[vigencia]=$vigencia;
			}
			if ($_POST[manual]=="0") 
			{
				$coloracti="#C00";
			}
			else
			{
				$coloracti="#0F0";
			}
			?>
			<table class="inicio">
				<tr>
					<td class="titulos" style="width:100%;">.: Tipo de Movimiento 
						<select name="tipomovimiento" id="tipomovimiento" onKeyUp="return tabular(event,this)" onChange="document.form2.oculto.value=1; document.form2.submit();" style="width:20%;" >
							<?php 
								$user=$_SESSION[cedulausu];
								$sql="SELECT * from permisos_movimientos WHERE usuario='$user' AND estado='T' ";
								$res=mysql_query($sql,$linkbd);
								$num=mysql_num_rows($res);
								if($num==1)
								{
									$sqlr="select * from tipo_movdocumentos where estado='S' and modulo=3 AND (id='1' OR id='3')";
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										if($_POST[tipomovimiento]==$row[0].$row[1])
										{
											echo "<option value='$row[0]$row[1]' SELECTED >$row[0]$row[1]-$row[2]</option>";
										}
										else
										{
											echo "<option value='$row[0]$row[1]'>$row[0]$row[1]-$row[2]</option>";
										}
									}
								}
								else
								{
									$sql="SELECT codmov,tipomov from permisos_movimientos WHERE usuario='$user' AND estado='S' AND modulo='3' AND transaccion='PIC' ";
									$res=mysql_query($sql,$linkbd);
									while($row = mysql_fetch_row($res))
									{
										if($_POST[tipomovimiento]==$row[0])
										{
											echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										}
										else
										{
											echo "<option value='$row[0]'>$row[0] - $row[1]</option>";
										}
									}
								}
								
							?>
						</select>
					</td>
					<td style="width:80%;">
					</td>
				</tr>
			</table>
			<table class="inicio" width="99%">
				<tr>
					<td class="titulos" colspan="<?php if($_POST[tipomovimiento]=="101"){echo "9"; }else{echo "8";}?>">.: Comprobantes de ingreso para regalias</td>
					<td style="width: 4% !important" class="cerrar" >
						<a href="cont-principal.php">Cerrar</a>
					</td>
        		</tr>
				<tr>
					<td style="width:10%;" class="saludo1" >No:</td>
					<td style="width:10%;" >
						<?php
						if($_POST[tipomovimiento]=="101")
						{
						?>
         					<input type="text" name="ncomp" id="ncomp" style="width:95%;" onKeyPress="javascript:return solonumeros(event)" value="<?php echo $_POST[ncomp]?>" onKeyUp="return tabular(event,this) " readonly >  
						<?php
						}
						else
						{
						?>
							<input type="text" name="ncomp" id="ncomp" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" value="<?php echo $_POST[ncomp]?>" onKeyUp="return tabular(event,this) " onBlur="validar2()" >&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',1);" title="Buscar REGLIAS" class="icobut" />  
						<?php
						}
						?>
         			</td>
					<td style="width:10%;" class="saludo1" >Fecha: </td>
					<td style="width:10%;">
						<input name="fecha" type="text" id="fecha" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         
						<a href="#" onClick="displayCalendarFor('fecha');">
							<img src="imagenes/calendario04.png" align="absmiddle" style="width:20px; cursor:pointer" border="0">
						</a>          
					</td>
					<input type="hidden" id="oculto" name="oculto"  value="<?php echo $_POST[oculto]; ?>">
					<?php
					if($_POST[tipomovimiento]=="101")
					{
						?>
						<td style="width:10%;" class="saludo1">Automatico:          </td>
						<td style="width:10%;">
							<input type="hidden" id="contador" name="contador"  value="<?php echo $_POST[contador]; ?>" >
							
							<input type="hidden" id="oculto12" name="oculto12"  value="<?php echo $_POST[oculto12]; ?>">
							<input type="hidden" name="estado"  value="<?php echo $_POST[estado]; ?>" >
							<?php 
							$valuees="ACTIVO";
							$stylest="width:100%; background-color:#0CD02A ;color:#fff; text-align:center;";	
							echo "<input type='hidden' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";		
							?>
							<input type='range' name='manual' id="manual" value='<?php echo $_POST[manual]?>' min ='0' max='1' step ='1' style='background: <?php echo $coloracti; ?>; width:100%;position: relative;float: left;' onChange='validar()'/></td>
						</td>
						<?php
					}
					else
					{
						?>
						<td></td>	
						<td></td>
						<?php
					}
					if($_POST[tipomovimiento]=="101" && $_POST[manual]!="0")
					{
					?>
						<td class="saludo1" style="width: 7%">Fecha inicial: </td>
						<td style="width: 20%"><input name="fechai" type="text" id="fechai" title="DD/MM/YYYY" style="width:50%;" value="<?php echo $_POST[fechai]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         
						<a href="#" onClick="displayCalendarFor('fechai');">
							<img src="imagenes/calendario04.png" align="absmiddle" style="width:20px; cursor:pointer" border="0">
						</a> 
						</td>
					<?php
					}
					?>
					<td rowspan="2" style="width: 15%; background-image:url('imagenes/sgr.png'); background-repeat:no-repeat; background-size: 80% 100%; background-position: left"></td>
        		</tr>
				<tr>
					<td class="saludo1">Concepto:</td>
					<td colspan="3" >
						<input type="text" name="concepto" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[concepto]; ?>">          
					</td>
					<td style="width:5%;" class="saludo1">Vigencia:          </td>
					<td style="width:10%;" >
						<input type="text" name="vigencia" id="vigencia" onKeyUp="return tabular(event,this)" style="width:100%;" value="<?php echo $_POST[vigencia]; ?>" readonly >          
					</td>
					<?php
					if($_POST[tipomovimiento]=="101" && $_POST[manual]!="0")
					{
						?>
						<td class="saludo1">Fecha Final: </td>
						<td><input name="fechaf" type="text" id="fechaf" title="DD/MM/YYYY" style="width:50%;" value="<?php echo $_POST[fechaf]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         
							<a href="#" onClick="displayCalendarFor('fechaf');">
								<img src="imagenes/calendario04.png" align="absmiddle" style="width:20px; cursor:pointer" border="0">
							</a>
							<input type="button" name="busca" id="busca" value="   Buscar   " onClick="buscar()" >
						</td>
						<?php
					}
					
					?>
				</tr>
				<tr>
					<?php
					if($_POST[manual]=="0")
					{
						?>
						<td class="saludo1">Ingreso:</td>
						<td>
							<input type="text" id="codingreso" name="codingreso" value="<?php echo $_POST[codingreso]?>"  onKeyUp="return tabular(event,this)" onBlur="buscaing(event)" style="width:80%;">&nbsp;<a onClick="despliegamodal2('visible','2');" title="Listado de Ingresos"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a>
							<input type="hidden" value="0" name="bin">
						</td> 
						<td colspan="2"><input type="text" name="ningreso" id="ningreso" value="<?php echo $_POST[ningreso]?>" style="width:100%;" readonly></td>
						<td class="saludo1" >Valor:</td>
						<td>
							<input type="hidden" id="valor" name="valor" value="<?php echo $_POST[valor]?>"/>
							<input type="text" name="valorvl" id="valorvl" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos2('valor','valorvl');return tabular(event,this);" value="<?php echo $_POST[valorvl]; ?>" style='text-align:right; width:60%;' style=""/>
							<input type="button" name="agregact" value="Agregar" onClick="agregardetalle()"><input type="hidden" name="agregadet"/>
						</td>
						<?php
					}
					?>
				</tr>
    		</table>

			<div class="subpantallac5" style="height:50.5%; width:99.6%; overflow-x:hidden;">
				<table class="inicio" width="99%">
					<tr>
						<td class="titulos" colspan="8">Detalle Comprobantes          </td>
					</tr>
					<tr>
						<td class="titulos2" style="width: 5%"><input type="checkbox" name="todos" id="todos" onChange="aprobar(this)" <?php if(!empty($_POST[todos])){echo "CHECKED"; } ?> /><input type="hidden" name="maximo" id="maximo" value="<?php echo $_POST[maximo]; ?>"/></td>
						<td class="titulos2" style="width: 10%">Liquidacion</td>
						<td class="titulos2" style="width: 40%">Concepto</td>
						<td class="titulos2" style="width: 10%">Fecha</td>
						<td class="titulos2" style="width: 10%">Ingreso</td>
						<td class="titulos2" style="width: 10%">Rubro</td>
						<td class="titulos2" style="width: 20%">Valor</td>
					</tr>
					<input type='hidden' name='elimina' id='elimina'>
					<?php
					if($_POST[oculto]==3)
					{
						$estilo="saludo1";
						$estilo1="saludo2";
						
						if($_POST[tipomovimiento]=="101")
						{
							if ($_POST[oculto12]=='1')
							{
								$posi=$_POST[elimina];
								unset($_POST[liquidaciones][$posi]);	
								unset($_POST[conceptos][$posi]);			 
								unset($_POST[totalval][$posi]);			  		 
								unset($_POST[ingresos][$posi]);			  		 
								unset($_POST[cuentas][$posi]);			  		 
								$_POST[liquidaciones]= array_values($_POST[liquidaciones]); 		 
								$_POST[conceptos]= array_values($_POST[conceptos]); 		 		 
								$_POST[totalval]= array_values($_POST[totalval]); 		 		 		 		 		 
								$_POST[ingresos]= array_values($_POST[ingresos]); 		 		 		 		 		 
								$_POST[cuentas]= array_values($_POST[cuentas]); 		 		 		 		 		 
							}
							if ($_POST[agregadet]=='1')
							{
								$sqlr = "SELECT TID.cuentapres FROM tesoingresos_det AS TID WHERE TID.codigo = '$_POST[codingreso]' AND TID.vigencia='$_POST[vigencia]' ";
								$resI = mysql_query($sqlr,$linkbd);
								$rowI = mysql_fetch_row($resI);
								
								$_POST[liquidaciones][]=0;
								$_POST[conceptos][]=$_POST[concepto];			 		
								$_POST[totalval][]=$_POST[valor];
								$_POST[ingresos][]=$_POST[codingreso];
								$_POST[cuentas][]=$rowI[0];
								$_POST[agregadet]=0;
								echo"
								<script>	
									document.form2.valorvl.value='';	
									document.form2.codingreso.value='';
									document.form2.ningreso.value='';
									document.form2.contador.value=parseInt(document.form2.contador.value)+1;
								</script>";
							}
							$fechai=explode("/",$_POST[fechai]);
							$fechaf=explode("/",$_POST[fechaf]);
							$nfechai=$fechai[2]."-".$fechai[1]."-".$fechai[0];
							$nfechaf=$fechaf[2]."-".$fechaf[1]."-".$fechaf[0];

							$sql = "SELECT TR.id_recaudo, TR.fecha, TR.concepto, TRD.ingreso, TRD.valor, TI.codigo FROM tesorecaudotransferencialiquidar AS TR, tesorecaudotransferencialiquidar_det AS TRD, tesoingresos AS TI WHERE TR.fecha BETWEEN '$nfechai' AND '$nfechaf' AND TR.estado<>'N' AND TR.id_recaudo = TRD.id_recaudo AND TI.codigo = TRD.ingreso AND TI.terceros = 'sgr' ORDER BY TR.id_recaudo DESC";
							
							$res=mysql_query($sql,$linkbd);
							$i=0;
							$total=0;
							$codigoIngreso = 0;
							$_POST[maximo]=mysql_num_rows($res);
							while($row = mysql_fetch_row($res))
							{
								echo "
								<script>
									jQuery(function($){ $('#valores$i').autoNumeric('init');});
								</script>";
								$sqlre="SELECT * FROM pptoregalias_det WHERE liquidacion='$row[0]'";
								$resrep=mysql_query($sqlre,$linkbd);
								$numreg=mysql_num_rows($resrep);
								if($numreg==0)
								{
									$valfinal=$row[4];

									echo "<tr class='$estilo'>";
									$habilita="readonly";
									$check="";
									if(!empty($_POST[chkrecibo][$i]))
									{
										$habilita="";
										$check="CHECKED";
									}
									$aux=$row[4];
									if(empty($_POST[valores][$i]))
									{
										$_POST[valores][$i]=$valfinal;
									}else
									{
										$_POST[valores][$i]=limpiarnum($_POST[valores][$i]);
									}
									$total+=limpiarnum($_POST[valores][$i]);
									$sqlr = "SELECT TID.cuentapres FROM tesoingresos_det AS TID WHERE TID.codigo = '$row[5]' AND TID.vigencia='$_POST[vigencia]' ";
									$resI = mysql_query($sqlr,$linkbd);
									$rowI = mysql_fetch_row($resI);
									echo "<td><input type='checkbox' name='chkrecibo[$i]' id='chkrecibo[$i]' onChange='cambiar(this)' $check/> </td>";
									echo "<td><input type='hidden' name='liquidaciones[]' value='".$row[0]."' />$row[0]</td>";
									echo "<td><input type='hidden' name='conceptos[]' value='".$row[2]."' />$row[2]</td>";
									echo "<td><input type='hidden' name='fechas[]' value='".$row[1]."' />$row[1]</td>";
									echo "<td><input type='hidden' name='ingresos[]' value='".$row[3]."' />$row[3]</td>";
									echo "<td><input type='hidden' name='cuentas[]' value='".$rowI[0]."' /> $rowI[0]</td>";
									echo "<td><input type='hidden' name='totalval[]' value='".$valfinal."' /> <input type='hidden' name='dvalores[]' id='dvalores$i' value='".$_POST[dvalores][$i]."'/> <input type='text' name='valores[]' id='valores$i' value='".$_POST[valores][$i]."' data-a-sign='$' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dvalores$i','valores$i');\" onBlur='verificasaldo($i)' $habilita/></td>";
									echo "</tr>";
									$aux=$estilo;
									$estilo=$estilo1;
									$estilo1=$aux;
									$i++;
								}
							}
							$co="saludo1a";
							$co2="saludo2";
							if($_POST[manual] == "0")
							{
								for ($x=0;$x<count($_POST[conceptos]);$x++)
								{
									$check="CHECKED";
									$habilita="readonly";
									if(!empty($_POST[chkrecibo][$i]))
									{
										$habilita="";
										$check="CHECKED";
									}
									echo "
									<script>
										jQuery(function($){ $('#valores$x').autoNumeric('init');});
									</script>"; 
									echo "
									<input type='hidden' name='liquidaciones[]' value='".$_POST[liquidaciones][$x]."'/>
									<input type='hidden' name='conceptos[]' value='".$_POST[conceptos][$x]."'/>
									<input type='hidden' name='fechas[]' value='".$_POST[fechas][$x]."'/>
									<input type='hidden' name='ingresos[]' value='".$_POST[ingresos][$x]."'/>
									<input type='hidden' name='cuentas[]' value='".$_POST[cuentas][$x]."'/>
									

									<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">";
									echo "<td><input type='checkbox' name='chkrecibo[$x]' id='chkrecibo[$x]' onChange='cambiar(this)' $check/> </td>";
									$total+=limpiarnum($_POST[totalval][$x]);
									echo "<td>".$_POST[liquidaciones][$x]."</td>
										<td>".$_POST[conceptos][$x]."</td>
										<td>".$_POST[fechas][$x]."</td>
										<td>".$_POST[ingresos][$x]."</td>
										<td>".$_POST[cuentas][$x]."</td>
										<td><input type='hidden' name='totalval[]' value='".$_POST[totalval][$x]."' /> <input type='hidden' name='dvalores[]' id='dvalores$x' value='".$_POST[dvalores][$i]."'/> <input type='text' name='valores[]' id='valores$x' value='".$_POST[totalval][$x]."' data-a-sign='$' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dvalores$x','valores$x');\" onBlur='verificasaldo($x)' $habilita/></td>
										<td style='text-align:center;'><a onclick='eliminar($x)'><img src='imagenes/del.png' style='cursor:pointer;'></a></td>
									</tr>";
									
									$aux=$co;
									$co=$co2;
									$co2=$aux;
								}
							}
							
							$_POST[total]=$total;
						}
						else
						{
							$sql="SELECT recibo,concepto,liquidacion,rubro,valor,fechacompro,ingreso FROM pptoregalias_det WHERE codigo='$_POST[ncomp]' ";
							$res=mysql_query($sql,$linkbd);
							$tot=mysql_num_rows($res);
							$_POST[contador]=$tot;
							echo "<script>document.getElementById('contador').value=$tot; </script>";
							while($row = mysql_fetch_row($res))
							{
								echo "<tr class='$estilo'>";
								echo "
								<script>
									jQuery(function($){ $('#valores$i').autoNumeric('init');});
								</script>";
								$check="";
								$valfinal=$row[4];
								$_POST[chkrecibo][$i]="1";
								if(!empty($_POST[chkrecibo][$i]))
								{
									$habilita="READONLY";
									$check="CHECKED";
								}
								$aux=$row[4];
								
								$_POST[valores][$i]=$valfinal;
							
								echo "<td><input type='checkbox' name='chkrecibo[$i]' id='chkrecibo[$i]' onChange='cambiar(this)' $check/> </td>";
								echo "<td><input type='hidden' name='recibos[]' value='".$row[0]."' />$row[0]</td>";
								echo "<td><input type='hidden' name='conceptos[]' value='".$row[1]."' />$row[1]</td>";
								echo "<td><input type='hidden' name='fechas[]' value='".$row[5]."' />$row[5]</td>";
								echo "<input type='hidden' name='liquidaciones[]' value='".$row[2]."' />";
								echo "<td><input type='hidden' name='ingresos[]' value='".$row[6]."' />$row[6]</td>";
								echo "<td><input type='hidden' name='cuentas[]' value='".$row[3]."' /> $row[3]</td>";
								echo "<td><input type='hidden' name='totalval[]' value='".$valfinal."' /> <input type='hidden' name='dvalores[]' id='dvalores$i' value='".$_POST[dvalores][$i]."'/> <input type='text' name='valores[]' id='valores$i' value='".$_POST[valores][$i]."' data-a-sign='$' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dvalores$i','valores$i');\" onBlur='verificasaldo($i)' $habilita/></td>";
								echo "</tr>";
								$total+=limpiarnum($_POST[valores][$i]);
								$aux=$estilo;
								$estilo=$estilo1;
								$estilo1=$aux;
								$i++;
							}
							$_POST[total]=$total;
						}
					}
					?>
				</table>  
			</div> 
			<div class="subpantallac5" style="height:5%; width:99.6%; overflow:hidden;">
				<table class="inicio" width="99%;" height="100%">
					<tr>
						<td class="titulos2" style="text-align:right; padding-right: 8%; font-size: 15px">$ <?php echo number_format($_POST[total],2,",","."); ?>   (<?php echo convertir($_POST[total]); ?> PESOS MCTE)</td>
        			</tr>
		    	</table>
			</div>
			<?php
			//--Guardando el comprobante
			if($_POST[oculto]==2)
			{
				$total=0;
				for($i=0; $i<count($_POST[valores]); $i++ )
				{
					if(!empty($_POST[chkrecibo][$i]))
						$total+=limpiarnum($_POST[valores][$i]);
				}
				$fecha=explode("/",$_POST[fecha]);
				$fechaf = $fechai[0]."-".$fechai[1]."-".$fechai[2];

				$fechai=explode("/",$_POST[fechai]);
				$fechaf=explode("/",$_POST[fechaf]);
				$nfechai=$fechai[2]."-".$fechai[1]."-".$fechai[0];
				$nfechaf=$fechaf[2]."-".$fechaf[1]."-".$fechaf[0];
				$user=$_SESSION['nickusu'];
				if($_POST[tipomovimiento]=="101")
				{
					$sql="INSERT INTO pptoregalias_cab (codigo,fecha,estado,concepto,vigencia,total,tipo_mov,usuario,fechai,fechaf) VALUES ('$_POST[ncomp]','$_POST[fecha]','S','$_POST[concepto]','$_POST[vigencia]','".$total."','101','$user','$nfechai','$nfechaf')";
				}
				else
				{
					$sql="INSERT INTO pptoregalias_cab (codigo,fecha,estado,concepto,vigencia,total,tipo_mov,usuario) VALUES ('$_POST[ncomp]','$fechaf','R','$_POST[concepto]','$_POST[vigencia]','".$total."','301','$user')";
				}
				if(mysql_query($sql,$linkbd))
				{
					if($_POST[tipomovimiento]=="301")
					{
						$sql="UPDATE pptoregalias_cab SET estado='R' WHERE codigo='$_POST[ncomp]' AND tipo_mov='101' ";
						mysql_query($sql,$linkbd);
					}
					echo"<script>despliegamodalm('visible','1','Se Almaceno el Comprobante');</script>";
					echo "<table class='inicio'><tr><td class='saludo1'><center>Se Almaceno de Manera Exitosa el Comprobante <img src='imagenes/confirm.png'></center></td></tr></table>"; 
					if($_POST[tipomovimiento]=="101")
					{
						for($i=0; $i<count($_POST[cuentas]); $i++ )
						{
							if(!empty($_POST[chkrecibo][$i]))
							{
								$saldo=$_POST[totalval][$i] - limpiarnum($_POST[valores][$i]);
								$sql="INSERT INTO pptoregalias_det (codigo,recibo,concepto,liquidacion,rubro,valor,saldo,fechacompro,ingreso) VALUES ('$_POST[ncomp]','".$_POST[ncomp]."','".$_POST[conceptos][$i]."','".$_POST[liquidaciones][$i]."','".$_POST[cuentas][$i]."','".limpiarnum($_POST[valores][$i])."','$saldo','".$_POST[fechas][$i]."','".$_POST[ingresos][$i]."')";
								mysql_query($sql,$linkbd);
								
							}
						}
					}
					else
					{
						for($i=0; $i<count($_POST[cuentas]); $i++ )
						{
							$sql="UPDATE pptorecibocajappto SET tipo='R' WHERE cuenta='".$_POST[cuentas][$i]."' AND idrecibo='".$_POST[recibos][$i]."' AND ingreso='".$_POST[ingresos][$i]."' ";
							//mysql_query($sql,$linkbd);
					  	}
					}
					
				}
				else
				{
					echo "<table class='inicio'><tr><td class='saludo1'><center>Error al Almacenar <img src='imagenes/alert.png'></center></td></tr></table>";
				}
			}
			?>
			<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
					</IFRAME>
				</div>
			</div>
	  	</form>
</body>
</html>