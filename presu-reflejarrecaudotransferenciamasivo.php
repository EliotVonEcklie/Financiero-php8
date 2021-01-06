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
				<a href="presu-reflejarrecaudotransferenciamasivo.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
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
			<?php
			function obtenerTipoPredio($catastral){
				$tipo="";
				$digitos=substr($catastral,5,2);
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
                    <td class="titulos" colspan="9">:: Buscar .: Recaudo transferencia </td>
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
					unset($_POST[vigenciaComp]);
					
					$_POST[recaudocc]= array_values($_POST[recaudocc]); 
					$_POST[conceptocc]= array_values($_POST[conceptocc]); 
					$_POST[valtotaltescc]= array_values($_POST[valtotaltescc]); 
					$_POST[valtotalcontcc]= array_values($_POST[valtotalcontcc]); 		 		 
					$_POST[diferenciacc]= array_values($_POST[diferenciacc]);
					$_POST[vigenciaComp]= array_values($_POST[vigenciaComp]); 
				
					$queryDate="";
					if(isset($_POST['fechafin']) and isset($_POST['fechaini'])){

						if(!empty($_POST['fechaini']) and !empty($_POST['fechafin'])){
							$fechaInicial=date('Y-m-d',strtotime($_POST['fechaini']));
							$fechaFinal=date('Y-m-d',strtotime($_POST['fechafin']));
							$queryDate="AND T.fecha>='".$fechaInicial."' and T.fecha<='".$fechaFinal."'";
						}
					}
                    $sqlr="select T.id_recaudo, T.valortotal, T.estado,T.idcomp,T.concepto,T.vigencia from tesorecaudotransferencia T where T.estado!='N' $queryDate group by T.id_recaudo";
                    //echo $sqlr;
					$resp=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)) 
					{
						$estilo="";
						$stado="";	
							
						$sql="select C.idrecibo,sum(C.valor),C.cuenta from pptoingtranppto C  where C.idrecibo=$row[0]";
						//echo $sql."<br>";
						$rs=mysql_query($sql,$linkbd);
						$rw=mysql_fetch_row($rs);
						//echo $rw[1]." $rw[0] <br>";
						if($rw[0] != null){
							//echo "hola $row[1] - $rw[1]";
							$dif=$row[1]-$rw[1];
							$difround = round($dif);
							if ($difround!=0)
							{
								$_POST[recaudocc][] = $row[0];
								$_POST[conceptocc][] = $row[4];
								$_POST[valtotaltescc][] = $row[1];
								$_POST[valtotalcontcc][] = $rw[1];
								$_POST[diferenciacc][] = $difround;
								$_POST[vigenciaComp][] = $row[5];
							}
						}else{
							$_POST[recaudocc][] = $row[0];
							$_POST[conceptocc][] = $row[4];
							$_POST[valtotaltescc][] = $row[1];
							$_POST[valtotalcontcc][] = 0;
							$_POST[diferenciacc][] = $row[1];
							$_POST[vigenciaComp][] = $row[5];
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
					echo "<input type='hidden' name='vigenciaComp[]' value='".$_POST[vigenciaComp][$k]."'/>";
					
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

				$recibos = "";
				$recibosfallidos = "";
				
				for($n=0; $n<count($_POST[recaudocc]); $n++)
				{
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$vigencia=$vigusu;
					$codrecibo = $_POST[recaudocc][$n];
					$linkbd=conectar_bd();
					//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
					$idcomp=mysql_insert_id();
					$sqlr="DELETE from pptoingtranppto where idrecibo=$codrecibo";
					mysql_query($sqlr,$linkbd);	
					//******************* DETALLE DEL COMPROBANTE CONTABLE *********************

					$sqlrRecaudoDet = "SELECT ingreso,valor From tesorecaudotransferencia_det WHERE id_recaudo=$codrecibo";
					//echo $sqlrRecaudoDet." -- <br>";
					$resRecaudoDet = mysql_query($sqlrRecaudoDet,$linkbd);	
					while($rowRecaudoDet = mysql_fetch_row($resRecaudoDet))
					{
						//***** BUSQUEDA INGRESO ********
						$sqlri="SELECT * from tesoingresos_det where codigo='".$rowRecaudoDet[0]."' and vigencia='".$_POST[vigenciaComp][$n]."'";
						if(!$resi=mysql_query($sqlri,$linkbd))
						{
							$recibosfallidos.=($_POST[recaudocc][$n])." ";	
						}
						//echo "$sqlri <br>";	    
						while($rowi=mysql_fetch_row($resi))
						{
							//**** busqueda concepto contable*****
							if($rowi[6]!="")
							{
								$porce=$rowi[5];
								$vi=$rowRecaudoDet[1]*($porce/100);
								//****creacion documento presupuesto ingresos
								$sqlr="INSERT into pptoingtranppto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$codrecibo,$vi,'".$_POST[vigenciaComp][$n]."')";
								mysql_query($sqlr,$linkbd);				  
								//echo "Conc: $sqlr <br>";
							}else{
								$recibosfallidos.=($_POST[recaudocc][$n])." ";	
							}
						}
					}
					$recibos.=($_POST[recaudocc][$n])." ";
				}
		echo "<table class='inicio'><tr><td class='saludo1'><center>Se han reflejado los Recibos de Caja $recibos con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>"; 
		echo "<table class='inicio'><tr><td class='saludo1'><center>No se pudieron reflejar los Recibos de Caja $recibosfallidos <img src='imagenes/del.png'><script></script></center></td></tr></table>"; 
							
	}
			
?>
			
		
        </form> 

</body>
</html>