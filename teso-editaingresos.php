Tipo Ingreso:<?php //V 1000 12/12/16 ?>
<?php
error_reporting(0);
require "comun.inc";
require "funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>
<script>
	function buscacta(e){
		if (document.form2.cuenta.value!=""){
			document.form2.bc.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}

	function validar(){
		document.getElementById('oculto').value='7';
		document.form2.submit();
	}

	function guardar(){
		if (document.form2.codigo.value!='' && document.form2.nombre.value!=''){
			despliegamodalm('visible','4','Esta Seguro de Guardar los Cambios','1');
		}
		else{
			despliegamodalm('visible','2','Faltan datos para Modificar los Datos');
			document.form2.nombre.focus();document.form2.nombre.select();
		}
	}

	function agregardetalle(){
		//var cuenta=document.form2.dcuentas[].value.trim();
		if(document.form2.valor.value!="" && document.form2.concecont.value!=-1 ){
			document.form2.agregadet.value=1;
			document.getElementById('oculto').value='7';
			document.form2.submit();
		 }
		 else {
			 despliegamodalm('visible','2','Faltan datos para Agregar el Registro');
		}
	}

	function eliminar(variable){
		document.getElementById('elimina').value=variable;
		despliegamodalm('visible','4','Esta Seguro de Eliminar el Registro','2');
	}
	function despliegamodal2(_valor)
	{
		document.getElementById("bgventanamodal2").style.visibility=_valor;
		if(_valor=="hidden"){document.getElementById('ventana2').src="";}
		else {document.getElementById('ventana2').src="cuentasppto-ventana1.php?ti=1";}
	}
	function despliegamodal3(_valor,pos)
	{
		document.getElementById("bgventanamodal2").style.visibility=_valor;
		if(_valor=="hidden"){document.getElementById('ventana2').src="";}
		else {document.getElementById('ventana2').src="cuentasppto-ventanaingresos.php?pos="+pos;}
	}
	function despliegamodalm(_valor,_tip,mensa,pregunta){
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden"){document.getElementById('ventanam').src="";}
		else{
			switch(_tip){
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

	function funcionmensaje(){document.form2.submit();}

	function respuestaconsulta(pregunta){
		switch(pregunta){
			case "1":	document.getElementById('oculto').value='2';document.form2.submit();break;
			case "2":	document.getElementById('oculto').value='6';
						document.form2.submit();break;
		}
	}
	 function validafinalizar(e)
	 {
		 var id=e.id;
		 var check=e.checked;
		 if(id=='terceros'){
			document.getElementById('terceros').value=1;
		 }else{
			 document.form2.terceros.checked=false;
		 }
		 document.getElementById('oculto').value='6';
		 document.form2.submit();
	 }
	function buscacuentap()
	{
		document.form2.buscap.value='1';
		document.form2.oculto.value='7';
		document.form2.submit();
	}
</script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="teso-editaingresos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=prev;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="teso-editaingresos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idrecaudo=document.getElementById('codigo').value;
				location.href="teso-buscaingresos.php?idcta="+idrecaudo;
			}
			function cambiavalor(pos,element){
				//var arreglo=document.getElementsByName('tipos[]');
				//arreglo.item(pos).value=element.value;
				document.form2.posicion.value=pos;
				document.form2.valorpos.value=element.value;
				document.form2.submit();
			}
		</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=20*$totreg;
		?>
<table>
	<tr>
		<script>barra_imagenes("teso");</script>
		<?php cuadro_titulos();?>
	</tr>	 
	<tr>
		<?php menu_desplegable("teso");?>
	</tr>
	<tr>
  		<td colspan="3" class="cinta">
			<a href="teso-ingresos.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo" /></a> 
			<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscaingresos.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" class="mgbt" title="Nueva Ventana"></a> 
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>		  
</table>
	<tr>
		<td colspan="3" class="tablaprin" align="center"> 
		<?php
 			$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			if ($_GET[idr]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";}
			$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from tesoingresos ORDER BY CONVERT(codigo, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idr]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from tesoingresos where codigo='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from tesoingresos where codigo ='$_GET[idr]'";
					}
				}
				else{
					$sqlr="select * from  tesoingresos ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}
 			if(($_POST[oculto]!="2")&&($_POST[oculto]!="6")&&($_POST[oculto]!="7")){	
 		 		$linkbd=conectar_bd();
				$sqlr="select *from tesoingresos where tesoingresos.codigo='$_POST[codigo]' ";
 				$cont=0;
 				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)){	 
					$_POST[codigo]=$row[0];
				 	$_POST[nombre]=$row[1]; 	
					 $_POST[tipo]=$row[2];
					if($row[4]!='')
					{
						$_POST[terceros]="1";
					}
					
					$_POST[destinoIng]=$row[4];
					$_POST[regalias] = $row[5];
                    $_POST[ivaGravado] = $row[6];
					//if($_POST[terceros] != '1' && $_POST[terceros] != 'N' && $_POST[terceros] != 'D' && $_POST[terceros] != 'M')
						
				}	 
			}
			if($_POST[oculto]=="7" && $_POST[terceros]=="on")
			{
				$_POST[terceros]=1;
			}
 			if(($_POST[oculto]!="2")&&($_POST[oculto]!="6")&&($_POST[oculto]!="7"))
 			{
				unset($_POST[dcuentas]);
				unset($_POST[dncuentas]);
				unset($_POST[dconceptos]);	 		 		 		 		 
				unset($_POST[dnconceptos]);	
				unset($_POST[dvalores]); 		 		 		 		 		 	
				$_POST[dcuentas]=array();	
				$_POST[dncuentas]=array();	
				$_POST[dconceptos]=array();		 		 		 		 		 
				$_POST[dnconceptos]=array();		 		 		 		 		 		 
				$_POST[dvalores]=array();	 		
				$_POST[concecont]="";
				$_POST[cuenta]="";
				$_POST[ncuenta]="";
				$_POST[precio]=0;
				$sqlr="select precio from tesoingresos_precios where  tesoingresos_precios.ingreso='$_POST[codigo]' and estado='S' ";
				$resp = mysql_query($sqlr,$linkbd);	
				while ($row =mysql_fetch_row($resp)){
					$_POST[precio]=$row[0];
				}
				
				//$sqlr="select  distinct *from tesoingresos INNER JOIN tesoingresos_det ON tesoingresos.codigo=tesoingresos_det.codigo where   tesoingresos_det.modulo=4 and tesoingresos.codigo='$_POST[codigo]'  group by tesoingresos_det.id_det ORDER BY  tesoingresos_det.id_det desc";
				 $sqlr="select tesoingresos.tipo, tesoingresos.codigo, tesoingresos_det.cuentapres, tesoingresos_det.porcentaje, tesoingresos_det.concepto  from tesoingresos INNER JOIN tesoingresos_det ON tesoingresos.codigo=tesoingresos_det.codigo where   tesoingresos_det.modulo=4 and tesoingresos.codigo='$_POST[codigo]' and vigencia='$vigusu' ORDER BY  tesoingresos_det.cuentapres";
				//echo $sqlr;
				$cont=0;
				//echo "v:".count($_POST[dcuentas]);
				$resp = mysql_query($sqlr,$linkbd);
				if(mysql_affected_rows()<=0)
				{
				 $sqlri="insert into tesoingresos_det (codigo,concepto,modulo,tipoconce,porcentaje,estado,vigencia)  select distinct codigo,concepto,modulo,tipoconce,porcentaje,estado,'$vigusu' from tesoingresos_det where tesoingresos_det.codigo='$_POST[codigo]' and vigencia=$vigusu-1 order by vigencia desc ";
				//  echo $sqlri;
				 mysql_query($sqlri,$linkbd);
				 $sqlr="select tesoingresos.tipo, tesoingresos.codigo, tesoingresos_det.cuentapres, tesoingresos_det.porcentaje, tesoingresos_det.concepto from tesoingresos INNER JOIN tesoingresos_det ON tesoingresos.codigo=tesoingresos_det.codigo where   tesoingresos_det.modulo=4 and tesoingresos.codigo='$_POST[codigo]' and vigencia='$vigusu' ORDER BY  tesoingresos_det.cuentapres";
				 $resp = mysql_query($sqlr,$linkbd);
				}
				//echo $sqlr;
				while ($row =mysql_fetch_row($resp)){	
					/* $_POST[codigo]=$row[0];
					$_POST[nombre]=$row[1]; 	
					$_POST[tipo]=$row[2];
					$_POST[terceros]=$row[4];*/
					$sql="SELECT tipo FROM tesoingresos_tipo WHERE cod_ingreso='$row[1]' AND concepto='$row[4]' AND cuentapres='$row[2]' AND vigencia='$vigusu' ORDER BY cuentapres";
					$res=mysql_query($sql,$linkbd);
					$fila=mysql_fetch_row($res);
					$_POST[tipos][]=$fila[0];
					//echo $sql;
					$sqlr1="Select * from conceptoscontables  where modulo='4' and tipo='C' and codigo ='$row[4]' ";
					//echo $sqlr1;
					$resp1 = mysql_query($sqlr1,$linkbd);
					$row1 =mysql_fetch_row($resp1);
					if ($row[0]=='C'){ 
						$_POST[dcuentas][$cont]=$row[2];
						$_POST[dncuentas][$cont]=buscacuentapres($row[2],1);
						$_POST[dvalores][$cont]=$row[3];	
						$_POST[dnconceptos][$cont]=$row1[0]." ".$row1[1];
						$_POST[dconceptos][$cont]=$row1[0];
					}
			
					if($row[0]=='S'){
						$_POST[cuenta]=$row[2];
						$_POST[ncuenta]=buscacuentapres($row[2],1);
						$_POST[valor]=$row[3];			 
						$_POST[concecont]=$row[4];
					}
				$cont=$cont+1; 
				}
				

			}
			//NEXT
			$sqln="select *from tesoingresos WHERE codigo > '$_POST[codigo]' ORDER BY codigo ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from tesoingresos WHERE codigo < '$_POST[codigo]' ORDER BY codigo DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
		?>

			<div id="bgventanamodalm" class="bgventanamodalm">
	            <div id="ventanamodalm" class="ventanamodalm">
	                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
	                </IFRAME>
	            </div>
	        </div>
 			<form name="form2" method="post" action="">
 				<?php //**** busca cuenta
	  			if($_POST[bc]!='')
				 {
				  $nresul=buscacuentapres($_POST[cuenta],1);			
				  if($nresul!='')
				   {
				  $_POST[ncuenta]=utf8_decode($nresul);
				   }
				  else
				  {
				   $_POST[ncuenta]="";	
				   }
				 }
				 
				 ?>
 
			    <table class="inicio" align="center" >
			      	<tr>
			        	<td class="titulos" colspan="12">.: Editar Ingresos</td>
			        	<td width="112" class="cerrar" >
			        		<a href="teso-principal.php">Cerrar</a>
			        	</td>
			      	</tr>
			      	<tr>
				  	<td width="" class="saludo1">Codigo:        </td>
			        <td style="width:10%">
				        <a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)">
				        	<img src="imagenes/back.png" alt="anterior" align="absmiddle">
				        </a> 
			        	<input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" style="width:30%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>        
				    	<a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)">
				    		<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
				    	</a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
			       	</td>
			        <td style="width:10%" class="saludo1">Nombre Ingreso:        </td>
			        <td style="width:40%" colspan="5">
			        	<input name="nombre" type="text" style="width:100%" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)">        
			        </td>
					<td class="saludo1">Precio Venta:</td>
					<td>
						<input id="precio" name="precio" type="text" value="<?php echo $_POST[precio]?>" onKeyUp="return tabular(event,this)" size="8" onKeyPress="javascript:return solonumeros(event)" >
					</td>
			       
			    </tr> 
				<tr>
				<td width="" class="saludo1">Tipo:</td>
			        <td>
			        	<select name="tipo" id="tipo" onChange="validar()" >
							<option value="S" <?php if($_POST[tipo]=='S') echo "SELECTED"?>>Simple</option>
				  			<option value="C" <?php if($_POST[tipo]=='C') echo "SELECTED"?>>Compuesto</option>
						</select>
						<input name="oculto" id="oculto" type="hidden" value="1">		  
					</td>
			        <td width="" class="saludo1">Terceros:        </td>
					<td> 
						<div class="c1">
							<input type="checkbox" id="terceros" name="terceros"  onChange="validafinalizar(this)" <?php if($_POST[terceros]!=""){echo "checked"; } ?> />	
								<label for="terceros" id="t1" ></label
						</div>
					</td>
					<?php
					if($_POST[terceros]!="")
					{
						?>
						<td  style="width:10%;" class="saludo1">Destino:</td>
						<td>
							<select name="destinoIng" id="destinoIng" onChange="validar()">
								<option value="" >Seleccione...</option>        
								<option value="N" <?php if($_POST[destinoIng]=='N') echo "SELECTED"?>>Nacional</option>
								<option value="D" <?php if($_POST[destinoIng]=='D') echo "SELECTED"?>>Departamental</option>
								<option value="M" <?php if($_POST[destinoIng]=='M') echo "SELECTED"?>>Municipal</option>            
							</select>
						</td>	
						<?php 
					}
					?>
					<td  style="width:10%;" class="saludo1">Tipo Ingreso:</td>
					<td>
						<select name="regalias" id="regalias" onChange="validar()">
							<option value="normal" <?php if($_POST[regalias]=='normal') echo "SELECTED"?>>Normal</option>
							<option value="sgr" <?php if($_POST[regalias]=='sgr') echo "SELECTED"?>>SGR</option>
							<option value="sgp" <?php if($_POST[regalias]=='sgp') echo "SELECTED"?>>SGP</option>
							<option value="salud" <?php if($_POST[regalias]=='salud') echo "SELECTED"?>>Salud ssf</option>
							<option value="educacion" <?php if($_POST[regalias]=='educacion') echo "SELECTED"?>>Educacion ssf</option>
						</select>
					</td>
                    <td  style="width:10%;" class="saludo1">Iva:</td>
                    <td>
                        <select name="ivaGravado" id="ivaGravado">
                            <option value="" <?php if($_POST[ivaGravado]=='') echo "SELECTED"?>>...</option>
                            <option value="S" <?php if($_POST[ivaGravado]=='S') echo "SELECTED"?>>Gravado</option>
                        </select>
                    </td>
				</tr>
			</table>
	   	<?php
		   	if($_POST[tipo]=='S') //***** SIMPLE
		   	{
	   			$linkbd=conectar_bd();
	   	?>
	   		<table class="inicio">
	   		<tr>
	   			<td colspan="6" class="titulos">Agregar Detalle Ingreso</td>
	   		</tr>                  
	  		<tr>
	  		<td style="width:10%;" class="saludo1">Concepto Contable:</td>
	  		<td style="width:50%;">
	  			<select name="concecont" id="concecont" style="width:100%;">
				  	<option value="-1">Seleccione ....</option>
						<?php
					 		$sqlr="Select * from conceptoscontables where modulo='4' and tipo='C' order by codigo";
		 					$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp))
							{
								$i=$row[0];
								echo "<option value=$row[0] ";
								if($i==$_POST[concecont])
			 					{
				 					echo "SELECTED";
				 					$_POST[concecontnom]=$row[0]." - ".$row[3]." - ".$row[1];
				 				}
								echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
			     			}
						?>
				</select>
				<input id="concecontnom" name="concecontnom" type="hidden" value="<?php echo $_POST[concecontnom]?>" >
			</td>
			<td></td>
			<td></td>
		</tr>
        <tr>
	  		<td style="width:10%;" class="saludo1">Cuenta presupuestal: </td> 
	  		<td style="width:50%;" colspan="3" valign="middle" >
	  			<input type="text" id="cuenta" name="cuenta" style="width:10%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">
	  			<input type="hidden" value="" name="bc" id="bc">
	  			<a title="Cuentas presupuestales" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"/></a>
				<input name="ncuenta" type="text" style="width:59%;" value="<?php echo $_POST[ncuenta]?>" readonly>
			</td>
	  		<td></td>
			<td></td>	
	  		
	    </tr> 
		<tr>		  
			<td class="saludo1">Porcentaje:</td>
			<td>
				<input id="valor" name="valor" type="text" value="<?php echo $_POST[valor]?>" style="width:10%;" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" > %
			</td>
			<td ></td>
			<td></td>
		</tr>
    </table>
		<?php
			}
			if($_POST[tipo]=='C') //**** COMPUESTO
	   		{
	   			$linkbd=conectar_bd();
	   	?>
	<table class="inicio">
	   	<tr>
	   		<td colspan="7" class="titulos">Agregar Detalle Ingreso</td>
	   	</tr>                  
	  	<tr>
		  	<td style="width:10%;" class="saludo1">Concepto Contable:</td>
		  	<td style="width:100%;" colspan="4">
		  		<select name="concecont" id="concecont" style="width:62%;">
				  	<option value="-1">Seleccione ....</option>
						<?php
					 		$sqlr="Select * from conceptoscontables  where modulo='4' and tipo='C' order by codigo";
		 					$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								$i=$row[0];
								echo "<option value=$row[0] ";
								if($i==$_POST[concecont])
			 					{
							 		echo "SELECTED";
							 		$_POST[concecontnom]=$row[0]." - ".$row[3]." - ".$row[1];
				 				}
								echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
			     			}   
						?>
		  		</select>
		  		<input id="concecontnom" name="concecontnom" type="hidden" value="<?php echo $_POST[concecontnom]?>" >
		  	</td>
		  	<td></td>
			<td></td>
		</tr>
		<tr>
			<td style="width:7%;" class="saludo1">Cuenta presupuestal: </td>
          	<td style="width:9%;" valign="middle" >
          		<input type="text" id="cuenta" name="cuenta" style="width:90%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">
          		<input type="hidden" value="" name="bc" id="bc">
          		  
				<a title="Cuentas presupuestales" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"/></a>				
          		
          	</td> 
          	<td colspan="2"><input name="ncuenta" type="text" style="width:51.3%;" value="<?php echo $_POST[ncuenta]?>" readonly></td>
        </tr>
        <tr>
          	<td style="width:7%;" class="saludo1">Porcentaje:</td>
		  	<td style="width:20%;">
		  		<input id="valor" name="valor" type="text" value="<?php echo $_POST[valor]?>" style="width:70%;" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" >% 


          	</td>
          	<td style="width:10%;" class="saludo1">Tipo:</td>
			<td><select name='tipopredio' id='tipopredio' style='width: 30%' > <option value='' >No aplica</option><option value='rural' >Rural</option><option value='urbano' >Urbano</option> </select><input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" style="margin-left: 4.5%">
          		<input type="hidden" value="0" name="agregadet"><input type="hidden" value="0" name="buscap"></td>
	    </tr> 
    </table>
	 	<?php
			//**** busca cuenta
			if($_POST[bc]!='')
			{
			  	$nresul=buscacuentapres($_POST[cuenta],1);
			  	if($nresul!='')
			   	{
			  		$_POST[ncuenta]=utf8_decode($nresul);
  		?>
		<script>
			document.getElementById('agregar').focus();
			document.getElementById('agregar').select();
		</script>
		<?php
			  	}
			 	else
			 	{
			  		$_POST[ncuenta]="";
		?>
		<script>
			alert("Cuenta Incorrecta");document.form2.cuenta.focus();
		</script>
		<?php
			  	}
			}
		?>
		<div class="subpantalla" style="height:48%; width:99.6%; overflow-x:hidden;" id="divdet">
			<table class="inicio" style="height:300px;">
				<tr>
					<td class="titulos" colspan="6">Detalle Ingreso</td>
				</tr>
				<tr>
					<td class="titulos2" style="width:8%">Tipo</td>
					<td class="titulos2" style="width:8%">Cuenta</td>
					<td class="titulos2" style="width:35%">Nombre Cuenta</td>
					<td class="titulos2" style="width:40%">Concepto</td>
					<td class="titulos2" style="width:6%">Porcentaje</td>
					<td class="titulos2" style="width:3%"><center>
						<img src="imagenes/del.png" >
						<input type='hidden' name='elimina' id='elimina'></center>
						<input type='hidden' name='posicion' id='posicion'  >
						<input type='hidden' name='valorpos' id='valorpos'  >
					</td>
				</tr>
				<?php
					if($_POST[posicion]!=''){
					$pos=$_POST[posicion];
					$val=$_POST[valorpos];
					$_POST[tipos][$pos]=$val;
					$_POST[tipos]= array_values($_POST[tipos]); 

		 		}
					if ($_POST[elimina]!='')
					{ 
						$posi=$_POST[elimina];
						unset($_POST[tipos][$posi]);
						unset($_POST[dcuentas][$posi]);
						unset($_POST[dncuentas][$posi]);
						unset($_POST[dconceptos][$posi]);	 		 		 		 		 
						unset($_POST[dnconceptos][$posi]);	 		 		 		 		 		 
						unset($_POST[dvalores][$posi]);	
						$_POST[tipos]= array_values($_POST[tipos]); 	 		
						$_POST[dcuentas]= array_values($_POST[dcuentas]); 
						$_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 
						$_POST[dconceptos]= array_values($_POST[dconceptos]); 
						$_POST[dnconceptos]= array_values($_POST[dnconceptos]); 		 
						$_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 
					}
			
					if ($_POST[agregadet]=='1')
					{
						$cuentacred=0;
						$cuentadeb=0;
						$diferencia=0;
						$_POST[tipos][]=$_POST[tipopredio];
						$_POST[dcuentas][]=$_POST[cuenta];
						$_POST[dncuentas][]=$_POST[ncuenta];
						$_POST[dconceptos][]=$_POST[concecont];		 
						$_POST[dnconceptos][]=$_POST[concecontnom];		 		 
						$_POST[dvalores][]=$_POST[valor];	
						$_POST[agregadet]=0;
				?>
				<script>
					//document.form2.cuenta.focus();	
					document.form2.concecont.select();
				</script>
				<?php
					}
					if($_POST[buscap]=='1')
					{
						for($x=0;$x<count($_POST[dcuentas]);$x++)
						{
							$sqlr="SELECT nombre FROM pptocuentas WHERE cuenta='".$_POST[dcuentas][$x]."' AND vigencia='$vigusu'";
							$res=mysql_query($sqlr,$linkbd);
							$row=mysql_fetch_row($res);
							$_POST[dncuentas][$x]=$row[0];
						}
					}
					
					for ($x=0;$x< count($_POST[dcuentas]);$x++)
					{	
						$val=$_POST[tipos][$x];
						if($_POST[tipos][$x]=="rural"){
							$check1="SELECTED";
							$check2="";
							$check3="";
						}else if($_POST[tipos][$x]=="urbano"){
							$check1="";
							$check2="SELECTED";
							$check3="";
						}else{
							$check1="";
							$check2="";
							$check3="SELECTED";
						}
						
						echo "<tr>
								<td class='saludo2'>
								<input type='hidden' name='tipos[]' value='".$_POST[tipos][$x]."' >
									<select name='tipopre' style='width: 100%' onChange='cambiavalor($x,this)' > <option value='' $check3>No aplica</option><option value='rural' $check1>Rural</option><option value='urbano' $check2>Urbano</option> </select>
									
								</td>
								<td class='saludo2'>
									<input name='dcuentas[]' id='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%' onDblClick='despliegamodal3(\"visible\",$x)'>
								</td>
								<td class='saludo2'>
									<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text'style='width:100%' readonly>
								</td>
								<td class='saludo2'>
									<input name='dnconceptos[]' value='".$_POST[dnconceptos][$x]."' type='text' style='width:100%' onDblClick='llamarventanadeb(this,$x)' readonly>
									<input name='dconceptos[]' value='".$_POST[dconceptos][$x]."' type='hidden'>
								</td>
								<td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' style='width:70%' onDblClick='llamarventanacred(this,$x)' readonly>%
								</td>
								<td class='saludo2'><center>
									<a href='#' onclick='eliminar($x)'>
										<img src='imagenes/del.png'>
									</a>
									</center>
								</td>
							</tr>";
					}	 
				?>
				<tr></tr>
			</table>	
		</div>
	   	<?php
	   	}
		?>
		<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	</div>
    	</form>
  			<?php
				$oculto=$_POST['oculto'];
				if($_POST[oculto]=='2')
				{
					$linkbd=conectar_bd();
					if ($_POST[nombre]!="")
					{
						 $nr="1";
						if($_POST[destinoIng]!='')
							$dest = $_POST[destinoIng];
						else
							$dest=1;
						if($_POST[terceros]!=''){
							$sqlr="update tesoingresos  set nombre='".utf8_decode($_POST[nombre])."',tipo='$_POST[tipo]',estado='S',terceros='$dest',tipoIngreso='$_POST[regalias]', gravado='$_POST[ivaGravado]' where codigo = '$_POST[codigo]'";
						}
						else
						{
							$sqlr="update tesoingresos  set nombre='".utf8_decode($_POST[nombre])."',tipo='$_POST[tipo]',estado='S',terceros='',tipoIngreso='$_POST[regalias]', gravado='$_POST[ivaGravado]' where codigo = '$_POST[codigo]'";
						}
						
					 	//echo "sqlr:".$sqlr;
					  	if (!mysql_query($sqlr,$linkbd))
						{
						 	echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
					//	 	$e =mysql_error($respquery);
						 	echo "Ocurri� el siguiente problema:<br>";
					  	 	//echo htmlentities($e['message']);
					  	 	echo "<pre>";
					     	///echo htmlentities($e['sqltext']);
					    	// printf("\n%".($e['offset']+1)."s", "^");
					     	echo "</pre></center></td></tr></table>";
						}
					  	else
					  	{
					  		$fecha=date('Y-m-d h:i:s');
							$sqlr="update tesoingresos_precios set estado='N' where ingreso='$_POST[codigo]'";
							mysql_query($sqlr,$linkbd);
							//echo "sqlr:".$sqlr;
					 		$sqlr="INSERT INTO tesoingresos_precios (ingreso,precio,fecha,estado) VALUES ('$_POST[codigo]',$_POST[precio],'$fecha','S')";
							mysql_query($sqlr,$linkbd);
					  		//echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado el Ingreso con Exito</h2></center></td></tr></table>";
					  		if($_POST[tipo]=='S') //**** simple
	   						{
								//******
								$sql="delete from tesoingresos_tipo where cod_ingreso='$_POST[codigo]' and vigencia='$vigusu'";
						 		mysql_query($sql,$linkbd);
								$sqlr="delete from tesoingresos_det where codigo ='$_POST[codigo]' and vigencia='$vigusu' ";		
								mysql_query($sqlr,$linkbd);

								if($_POST[tipos][$x]!=""){
									$sql="INSERT INTO tesoingresos_tipo(cod_ingreso,concepto,modulo,vigencia,tipo,cuentapres) VALUES ('$_POST[codigo]','".$_POST[concecont][$x]."','4','$vigusu','".$_POST[tipos][$x]."','".$_POST[cuenta]."')";
											mysql_query($sql,$linkbd);
										}

								$sqlr="INSERT INTO tesoingresos_det (codigo,concepto,modulo,tipoconce,porcentaje,cuentapres,estado, vigencia)VALUES ('$_POST[codigo]','".$_POST[concecont]."','4', 'S', '".$_POST[valor]."', '".$_POST[cuenta]."','S', '$vigusu')";
								//$sqlr="update tesoingresos_det set codigo='$_POST[codigo]',concepto='$_POST[concecont]',modulo='4',tipoconce='S',porcentaje='$_POST[valor]',cuentapres='$_POST[cuenta]',estado='S' where codigo='$_POST[codigo]'";
								//echo "sqlr:".$sqlr;
						  		if (!mysql_query($sqlr,$linkbd))
						  		{
									echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
									//	 	$e =mysql_error($respquery);
								 	echo "Ocurri� el siguiente problema:<br>";
							  	 	//echo htmlentities($e['message']);
							  	 	echo "<pre>";
							     	///echo htmlentities($e['sqltext']);
							    	// printf("\n%".($e['offset']+1)."s", "^");
							     	echo "</pre></center></td></tr></table>";
								}
 		 						else
  								{
 			 						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Detalle del Ingreso con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
									//****
	  	 						}
  							}
							//****COMPUESTO	
						 	if($_POST[tipo]=='C') //**** COMPUESTO
						 	{

						 		$sql="delete from tesoingresos_tipo where cod_ingreso=$_POST[codigo] and vigencia='$vigusu'";
						 		mysql_query($sql,$linkbd);
								//******
								$sqlr="delete from tesoingresos_det where tipoconce='C' and codigo =$_POST[codigo] and vigencia='$vigusu' ";
							
								if (!mysql_query($sqlr,$linkbd))
					  			{
									echo "<table class=''><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD <img src='imagenes\alert.png'><br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
									//	 $e =mysql_error($respquery);
								 	echo "Ocurri� el siguiente problema:<br>";
							  	 	//echo htmlentities($e['message']);
							  		echo "<pre>";
							     	///echo htmlentities($e['sqltext']);
							    	// printf("\n%".($e['offset']+1)."s", "^");
							     	echo "</pre></center></td></tr></table>";
								}
 		 						else
  								{
									for($x=0;$x<count($_POST[dcuentas]);$x++)
									{
										if($_POST[tipos][$x]!=""){
											$sql="INSERT INTO tesoingresos_tipo(cod_ingreso,concepto,modulo,vigencia,tipo,cuentapres) VALUES ('$_POST[codigo]','".$_POST[dconceptos][$x]."','4','$vigusu','".$_POST[tipos][$x]."','".$_POST[dcuentas][$x]."')";
											mysql_query($sql,$linkbd);
										}
										
										$sqlr="INSERT INTO tesoingresos_det (codigo,concepto,modulo,tipoconce,porcentaje,cuentapres,estado,vigencia)VALUES ('$_POST[codigo]','".$_POST[dconceptos][$x]."','4', 'C', '".$_POST[dvalores][$x]."', '".$_POST[dcuentas][$x]."','S', '$vigusu' )";
							 			//echo "sqlr:".$sqlr;
								  		if (!mysql_query($sqlr,$linkbd))
								  		{
											echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD <img src='imagenes\alert.png'><br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
											//	 $e =mysql_error($respquery);
										 	echo "Ocurri� el siguiente problema:<br>";
									  	 	//echo htmlentities($e['message']);
									  	 	echo "<pre>";
									     	///echo htmlentities($e['sqltext']);
									    	// printf("\n%".($e['offset']+1)."s", "^");
									     	echo "</pre></center></td></tr></table>";
										}
											
										
									}
									
									echo "<script>despliegamodalm('visible','1','Se ha almacenado el Detalle del Ingreso con Exito ');</script>";
								}//***** fin del for	
							}
						}
					}
					else
				 	{
				  		echo "<table class='inicio'><tr><td class='saludo1'><center>Falta informacion para Crear el Centro Costo <img src='imagenes\alert.png'></center></td></tr></table>";
				 	}
				}
			?> 
		</td>
	</tr>
     
</table>
</body>
</html>