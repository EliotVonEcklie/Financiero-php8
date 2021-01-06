<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'"; 
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}
			function validar(){
				var x = document.getElementById("tipomov").value;
				document.form2.movimiento.value=x;
				document.form2.submit();
			}

			function buscarp(e){if (document.form2.rp.value!=""){document.form2.brp.value='1';document.form2.submit();}}
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else {alert("Falta informacion para poder Agregar");}
			}
			function agregardetalled()
			{
				if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
				{ 
					document.form2.agregadetdes.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function eliminard(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.eliminad.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('eliminad');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
				}
			}
			/*function guardar()
			{
				if (document.form2.fecha.value!='')
					{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
				else
				{
					alert('Faltan datos para completar el registro');
					document.form2.fecha.focus();
					document.form2.fecha.select();
				}
			}*/
			function calcularpago()
			 {
				//alert("dddadadad");
				valorp=document.form2.valor.value;
				descuentos=document.form2.totaldes.value;
				valorc=valorp-descuentos;
				document.form2.valorcheque.value=valorc;
				document.form2.valoregreso.value=valorp;
				document.form2.valorretencion.value=descuentos;	
				document.form2.submit();
			 }
			function pdf()
			{
				document.form2.action="pdfcxp.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function adelante(scrtop, numpag, limreg, filtro)
			{
				//alert("Balance Descuadrado");
				//document.form2.oculto.value=2;
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
				{
					document.form2.oculto.value=1;
					//document.form2.agregadet.value='';
					//document.form2.elimina.value='';
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="teso-egresover.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
			function atrasc(scrtop, numpag, limreg, filtro)
			{
				//document.form2.oculto.value=2;
				if(document.form2.ncomp.value>1)
				{
					document.form2.oculto.value=1;
					//document.form2.agregadet.value='';
					//document.form2.elimina.value='';
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="teso-egresover.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('idcomp').value;
				var inicio=document.getElementById('fechaini').value;
				var fin=document.getElementById('fechafin').value;

				location.href="teso-buscaegreso.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro+"&fini="+inicio+"&ffin="+fin;
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <?php $numpag=$_GET[numpag];$limreg=$_GET[limreg];$scrtop=27*$totreg;?>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
  					<a href="teso-egreso.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
  					<a class="mgbt1"><img src="imagenes/guardad.png"/></a>
  					<a href="teso-buscaegreso.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
  					<a href="#" onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  title="Imprimir" style="width:29px;height:25px;" /></a>
  					<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
  				</td>
			</tr>		  
		</table>
        <form name="form2" method="post" action=""> 

			<?php

                $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
                $vigencia=$vigusu;
                //*********** cuenta origen va al credito y la destino al debito
                if($_GET[idopc]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idop];</script>";}
                if(!$_POST[oculto])
                {
                	$fech1=split("/",$_GET[fini]);
					$fech2=split("/",$_GET[ffin]);
					$_POST[fechaini]=$fech1[2]."-".$fech1[1]."-".$fech1[0];
					$_POST[fechafin]=$fech2[2]."-".$fech2[1]."-".$fech2[0];
                    $sqlr="select *from cuentapagar where estado='S' ";
                    $res=mysql_query($sqlr,$linkbd);
                    while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
                    $sqlr="select * from tesoordenpago ORDER BY id_orden DESC";
                    $res=mysql_query($sqlr,$linkbd);
                    $r=mysql_fetch_row($res);
                    $_POST[maximo]=$r[0];
                    if ($_POST[codrec]!="" || $_GET[idop]!="")
                    {
                        if($_POST[codrec]!="")
						{
							$sqlr="select * from tesoordenpago where id_orden='$_POST[codrec]' and tipo_mov='201' ";
						}
                        else
						{
							$sqlr="select * from tesoordenpago where id_orden='$_GET[idop]' and tipo_mov='201' ";
						}
                    }
                    else{$sqlr="select * from tesoordenpago ORDER BY id_orden DESC";}
                    $res=mysql_query($sqlr,$linkbd);
                    $r=mysql_fetch_row($res);
                    $_POST[ncomp]=$r[0];
                    $_POST[idcomp]=$r[0];	
                    $_POST[vigencia]=$r[3]; 		
                    $check1="checked"; 
                    $fec=date("d/m/Y");
                }
                // $_POST[fecha]=$fec; 		 		  			 
                //$_POST[valor]=0;
                //$_POST[valorcheque]=0;
                //$_POST[valorretencion]=0;
                //$_POST[valoregreso]=0;
                //$_POST[totaldes]=0;
                $sqlr="select * from tesoordenpago where id_orden=".$_POST[ncomp]." and tipo_mov='201' ";
                $res=mysql_query($sqlr,$linkbd);
                $consec=0;
                while($r=mysql_fetch_row($res))
                {
                    $_POST[fecha]=$r[2];
                    $_POST[compcont]=$r[1];
                    $consec=$r[0];	  
                    $_POST[rp]=$r[4];
                    $_POST[estado]=$r[13];
					$_POST[estadoc]=$r[3];
					$_POST[medioDePago]	= $r[19];
					if($_POST[medioDePago]=='')
						$_POST[medioDePago] = '-1';
                }
                ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
                $fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
                $_POST[fecha]=$fechaf;
                switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked'; break;
                    case 4:	$check4='checked'; break;
                }
 				if($_POST[oculto]!='2')
				{
					$sqlr="select * from tesoordenpago where id_orden=$_POST[idcomp] and tipo_mov='201' ";
					$res=mysql_query($sqlr,$link);
					while($r=mysql_fetch_row($res))
					{
	 					$_POST[fecha]=$r[2];
	  					$_POST[idcomp]=$r[0];
	 					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	 					$_POST[fecha]=$fechaf;	
	 					$_POST[rp]=$r[4];
	 					$_POST[base]=$r[14];
	 					$_POST[iva]=$r[15];
	 		 			$_POST[vigencia]=$r[3]; 		
	 		 			$_POST[estado]=$r[13];
						$_POST[estadoc]=$r[13];
						$_POST[medioDePago]	= $r[19];
						if($_POST[medioDePago]=='')
							$_POST[medioDePago] = '-1';
					}
			 		$nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
			  		$_POST[cdp]=$nresul;
			  		//*** busca detalle cdp
  					$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo, pptorp.tercero,pptocdp.objeto from pptorp, pptocdp where pptorp.estado='S' and pptocdp.consvigencia=$_POST[cdp] and pptorp.idcdp=pptocdp.consvigencia and pptorp.consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] and pptorp.idcdp=pptocdp.consvigencia and pptocdp.vigencia=$_POST[vigencia] and pptorp.tipo_mov='201' and pptocdp.tipo_mov='201' order by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";

  					

					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[detallecdp]=$row[2];
					$sqlr="Select *from tesoordenpago where id_orden=".$_POST[idcomp]." and tipo_mov='201' ";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[tercero]=$row[6];
					$_POST[ntercero]=buscatercero($_POST[tercero]);
					$_POST[valorrp]=$row[8];
					$_POST[saldorp]=generaSaldoRP($_POST[rp],$_POST[vigencia]);
					//$_POST[cdp]=$row[4];
					$_POST[valor]=$row[10];				
					$_POST[cc]=$row[5];				
					$_POST[detallegreso]=$row[7];
					$_POST[valoregreso]=$_POST[valor];
					$_POST[valorretencion]=$row[12];
					$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
					$_POST[base]=$row[14];
					$_POST[iva]=$row[15];
					if($_POST[movimiento]=='401'){
  					$sql="select conceptorden from tesoordenpago where id_orden=$_POST[idcomp] and vigencia=$vigusu and tipo_mov='401' ";
  					$resp1 = mysql_query($sql,$linkbd);
					$row1 =mysql_fetch_row($resp1);
					$_POST[detallegreso]=$row1[0];
  					}
					//$_POST[valorcheque]=number_format($_POST[valorcheque],2);
				}
 			?>
 			<input type="hidden" name="fechaini" id="fechaini" value="<?php echo $_GET[fini]; ?>" />
 			<input type="hidden" name="fechafin" id="fechafin" value="<?php echo $_GET[ffin]; ?>" />
 			<div class="tabs">
   				<div class="tab">
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Liquidacion CxP</label>
	   				<div class="content" style="overflow-x:hidden;">
    					<table class="inicio" align="center" >
      						<tr >
       							<td class="titulos" colspan="7" >Liquidacion CxP</td>
                                <td class="cerrar" style='width:7%'><a href="teso-principal.php">&nbsp;Cerrar</a></td>
      						</tr>
      						<tr>
								<td class="saludo1" style="width:2.6cm;">Numero CxP:</td>
        						<td style="width:20%;"> 
        							<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)"><img src="imagenes/back.png" title="anterior" align="absmiddle"></a>
            						<input type="text" id="idcomp" name="idcomp" value="<?php echo $_POST[idcomp]?>" style="width:40%;" readonly>
           							<input type="hidden" id="ncomp" name="ncomp" value="<?php echo $_POST[ncomp]?>">
            						<input type="hidden" name="compcont" value="<?php echo $_POST[compcont]?>">
            						<a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)"><img src="imagenes/next.png" title="siguiente" align="absmiddle"></a> 
            						<input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" >
            						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
            						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
       							</td>
	  							<td class="saludo1" style="width:3.1cm;">Fecha: </td>
        						<td style="width:10%;"><input type="text" name="fecha" value="<?php echo $_POST[fecha]?>" style='width:100%' id="fc_1198971545"  readonly></td>
	  							<td class="saludo1" style="width:3cm;">Medio de pago: </td>
        						<td style="width:17%;">
									<select name="medioDePago" id="medioDePago" onKeyUp="return tabular(event,this)" disabled style="width:80%">
										<option value="-1" <?php if(($_POST[medioDePago]=='-1')) echo "SELECTED"; ?>>Seleccione...</option>
         								<option value="1" <?php if(($_POST[medioDePago]=='1')) echo "SELECTED"; ?>>Con SF</option>
          								<option value="2" <?php if($_POST[medioDePago]=='2') echo "SELECTED"; ?>>Sin SF</option>
        							</select>
                                	<input type="hidden" name="vigencia" value="<?php echo $_POST[vigencia]?>" style='width:50%' readonly>
        							<input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc]?>" > 
                                    <input type="hidden" name="estado" value="<?php echo $_POST[estado]?>" > 
                               	</td>
                                <td rowspan="7" colspan="2" style="background:url(imagenes/factura03.png); background-repeat:no-repeat; background-position:right; background-size: 90% 95%"></td>
                            </tr>
							<tr>
        						<td class="saludo1">Registro: </td>
        						<td>
                            		<input type="text"name="rp" value="<?php echo $_POST[rp]?>" style="width:80%;" readonly />
                                	<input type="hidden" value="0" name="brp"/>
                  				</td> 
                  				<td class="saludo1">Estado: </td>
                  				<?php 
	                  				if($_POST[estado]=="S"){
				                    	$valuees="ACTIVO";
				                    	$stylest="width:100%; background-color:#0CD02A; color:white; text-align:center;";
				                    }else if($_POST[estado]=="N"){
				                    	$valuees="ANULADO";
				                    	$stylest="width:100%; background-color:#FF0000; color:white; text-align:center;";
				                    }else if($_POST[estado]=="P"){
				                    	$valuees="PAGO";
				                    	$stylest="width:100%; background-color:#0404B4; color:white; text-align:center;";
				                    }else if($_POST[estado]=="R"){
				                    	$valuees="REVERSADO";
				                    	$stylest="width:100%; background-color:#FF0000; color:white; text-align:center;";
				                    }

				                    echo "<td><input type='text' name='estado1' id='estado1' value='$valuees' style='$stylest' readonly /></td>";
                  				?>
            
        						<td style="width:3.1cm;" colspan="2">
                                	<select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" onChange="validar()" >
                 <?php
                 $codMovimiento='201';
				if(isset($_POST['movimiento'])){
						 	if(!empty($_POST['movimiento']))
						 		$codMovimiento=$_POST['movimiento'];
						 }
                 $sql="SELECT tipo_mov FROM tesoordenpago where id_orden=$_POST[idcomp] ORDER BY tipo_mov";

		 		$resultMov=mysql_query($sql,$linkbd);
		 		$movimientos=Array();
		 		$movimientos["201"]["nombre"]="201-Documento de Creacion";
		 		$movimientos["201"]["estado"]="";
		 		$movimientos["401"]["nombre"]="401-Reversion Total";
		 		$movimientos["401"]["estado"]="";
		 		while($row = mysql_fetch_row($resultMov)){
		 			$mov=$movimientos[$row[0]]["nombre"];
		 			$movimientos[$codMovimiento]["estado"]="selected";
		 			$state=$movimientos[$row[0]]["estado"];
		 			echo "<option value='$row[0]' $state>$mov</option>";
		 		}
		 		$movimientos[$codMovimiento]["estado"]="";
		 		echo "<input type='hidden' id='movimiento' name='movimiento' value='$_POST[movimiento]' />";
                 ?>        
                 </select>


                               	</td>

                            </tr>
                           	<tr>
	  							<td class="saludo1">CDP:</td>
	  							<td><input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" style="width:80%;" readonly></td>
	  							<td class="saludo1">Detalle RP:</td>
	  							<td colspan="3"><input type="text" id="detallecdp" name="detallecdp" value="<?php echo $_POST[detallecdp]?>" style='width:100%' readonly></td>
	  						</tr> 
	  						<tr>
	  							<td class="saludo1">Centro Costo:</td>
	  							<td>
									<select name="cc" onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%;text-transform:uppercase;">
										<?php
                                            $sqlr="select *from centrocosto where estado='S'";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {if("$row[0]"==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}}	 	
                                        ?>
   									</select>
	 							</td>
	     						<td class="saludo1">Tercero:</td>
          						<td><input id="tercero" type="text" name="tercero" style='width:100%' onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" readonly></td>
          						<td colspan="2"><input id="ntercero" name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style='width:100%' readonly></td>
                         	</tr>
          					<tr>
                            	<td class="saludo1">Detalle CxP:</td>
          						<td colspan="5"><input type="text" id="detallegreso" name="detallegreso" value="<?php echo $_POST[detallegreso]?>" style='width:100%' readonly></td>
                          	</tr>
	  						<tr>
      							<td class="saludo1">Valor RP:</td>
      							<td><input type="text" id="valorrp" name="valorrp" value="<?php echo $_POST[valorrp]?>" style='width:95%' readonly></td>
      							<td class="saludo1">Saldo RP:</td>
      							<td><input type="text" id="saldorp" name="saldorp"  value="<?php echo $_POST[saldorp]?>" style='width:95%' readonly></td>
                           	</tr>
                          	<tr>
	  							<td class="saludo1" >Valor a Pagar:</td>
      							<td><input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" style='width:95%'  onChange='calcularpago()' readonly> <input type="hidden" value="1" name="oculto"></td>
      							<td class="saludo1" >Base:</td>
      							<td><input type="text" id="base" name="base" value="<?php echo $_POST[base]?>" style='width:95%' onKeyUp="return tabular(event,this)"  readonly></td>
      							<td class="saludo1" >Iva:</td>
      							<td><input type="text" id="iva" name="iva" value="<?php echo $_POST[iva]?>" style='width:100%' onKeyUp="return tabular(event,this)" onChange='calcularpago()' readonly> </td>
                        	</tr>
      					</table>
      					<?php
	  						if(!$_POST[oculto]){echo "<script>document.form2.fecha.focus();document.form2.fecha.select();</script>";}
		 					//***** busca tercero
			 				if($_POST[brp]=='1')
			 				{
			 				 	$nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
			  					if($nresul!='')
			   					{
			  						$_POST[cdp]=$nresul;
  									echo"<script>document.getElementById('cc').focus();document.getElementById('cc').select();</script>";
			  					}
			 					else
			 					{
			  						$_POST[cdp]="";
			  						echo"
			  						<script>
				 						alert('Registro Presupuestal Incorrecto');
				 						document.form2.rp.select();
		  								//document.form2.rp.focus();	
			  						</script>";
			  					}
			 				}
						?>
	  				</div>
    			</div>
				<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       				<label for="tab-2">Retenciones</label>
       				<div class="content" style="overflow-x:hidden;"> 
     					<table class="inicio" style="overflow:scroll">
        					<tr>
                            	<td class="titulos">Descuento</td>
                                <td class="titulos">%</td>
                                <td class="titulos">Valor</td>
                                
                          	</tr>
      						<?php
								$totaldes=0;
								$sqlr="select *from tesoordenpago_retenciones where id_orden=".$_POST[idcomp];
								$res=mysql_query($sqlr,$linkbd);
								$iter='saludo1a';
								$iter2='saludo2';
								while ($row=mysql_fetch_row($res))
		 						{		 
		 							$sqlr="select *from tesoretenciones where id='$row[0]'";
									$res2=mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($res2);
		 							echo "
									<input type='hidden' name='dndescuentos[]' value='$row2[2]'/ >
									<input type='hidden' name='ddescuentos[]' value='$row[0]'/>
									<input type='hidden' name='dporcentajes[]' value='$row[2]'/>
									<input type='hidden' name='ddesvalores[]' value='$row[3]'/>
									<tr class='$iter' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
										<td>$row2[2]</td>
										<td style='text-align:right;'>$row[2] %</td>
										<td style='text-align:right;'>$ $row[3]</td>
									</tr>";
									//echo "<td class='saludo2'><input name='ddesvalores[]' value='".$_POST[ddesvalores][$x]."' type='text' size='15'></td><td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";
		 							$totaldes=$totaldes+$row[3];
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
		 						}		 
								echo"
        						<script>
        							document.form2.totaldes.value=<?php echo $totaldes;?>;		
									calcularpago();
									//document.form2.valorretencion.value=$totaldes;
        						</script>";
							?>
       					 </table>
	   				</div>
   				</div>
    			<div class="tab">
       				<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
       				<label for="tab-3">Cuenta por Pagar</label>
       				<div class="content" style="overflow-x:hidden;"> 
	   					<table class="inicio" align="center" >
	   						<tr>
                            	<td colspan="6" class="titulos">Cheque</td>
                                <td width="108" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
                         	</tr>
							<tr>
	  							<td class="saludo1">Cuenta Contable:</td>
	  							<td >
	    							<input name="cuentapagar" type="text" value="<?php echo $_POST[cuentapagar]?>" size="25"  readonly> 
									<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                                    <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
                              	</td>
	  						</tr> 
	  						<tr>
	  							<td class="saludo1">Valor Orden de Pago:</td>
                                <td><input type="text" id="valoregreso" name="valoregreso" value="<?php echo $_POST[valoregreso]?>" size="20" onKeyUp="return tabular(event,this)" readonly></td>
                                <td class="saludo1">Valor Retenciones:</td>
                                <td><input type="text" id="valorretencion" name="valorretencion" value="<?php echo $_POST[valorretencion]?>" size="20" onKeyUp="return tabular(event,this)" readonly></td>
                                <td class="saludo1">Valor Cta Pagar:</td>
                                <td><input type="text" id="valorcheque" name="valorcheque" value="<?php echo $_POST[valorcheque]?>" size="20" onKeyUp="return tabular(event,this)" readonly></td>
                         	</tr>	
      					</table>
	   				</div>
	 			</div>

	 			<div class="tab">
       				<input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?>>
       				<label for="tab-4">Afectacion presupuestal</label>
       				<div class="content" style="overflow-x:hidden;"> 
         				<table class="inicio" style="overflow:scroll">
         					<tr><td class="titulos" colspan="3">Detalle Comprobantes</td></tr>
        					<tr>
                            	<td class="titulos2">Cuenta</td>
                                <td class="titulos2">Nombre Cuenta</td>
                                <td class="titulos2">Valor</td>
                         	</tr>
                            <input type="hidden" id="totaldes" name="totaldes" value="<?php echo $_POST[totaldes]?>" readonly>
							
      						<?php
							
									//echo "hola";
									$totaldes=0;
									$_POST[dcuenta]=array();
									$_POST[ncuenta]=array();
									$_POST[rvalor]=array();
									$sqlr="select *from pptoretencionpago where idrecibo=$_POST[idcomp] and vigencia=$_POST[vigencia] and cuenta!='' and tipo='orden'";
									//echo $sqlr;
									$resd=mysql_query($sqlr,$linkbd);
									
									$iter='saludo1a';
									$iter2='saludo2';
									$cr=0;
									while($rowd=mysql_fetch_row($resd))
									{
								    $nresult=buscacuentapres($rowd[1],$rowd[4]);
											echo "<tr class=$iter>
												<td >
													<input name='dcuenta[]' value='$rowd[1]' type='text' size='20' readonly>
												</td>
												<td >
													<input name='ncuenta[]' value='$nresult' type='text' size='55' readonly>
												</td>
												<td >
													<input name='rvalor[]' value='".number_format($rowd[3],2)."' type='text' size='10' readonly>
												</td>
											</tr>";
									$var1=$rowd[3];
									$var1=$var1;
									$cuentavar1=$cuentavar1+$var1;
									$_POST[varto]=number_format($cuentavar1,2,".",",");
									 }
									 echo "<tr class=$iter><td> </td></tr>";
									echo "<tr >
											<td ></td>
											<td>Total:</td>
											<td >
												<input name='varto' id='varto' value='$_POST[varto]' size='10' readonly>
											</td>
										 </tr>";
								
							?>
							<input type='hidden' name='contrete' value="<?php echo $_POST[contrete] ?>" />
        				</table>
						
	   				</div>
	 			</div>		 
			</div>
	  		<div class="subpantallac4" style="height:36.8%; width:99.6%; overflow-x:hidden;">
     			<?php
	  				//*** busca contenido del rp
	  				$_POST[dcuentas]=array();
  	  				$_POST[dncuentas]=array();
	  				$_POST[dvalores]=array();
					$_POST[drecursos]=array();
	  				$sqlr="select * from tesoordenpago_det where id_orden=$_POST[idcomp] and tipo_mov='201' ";
	  				$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
	 				{
						$consec=$r[0];	  
	 					$_POST[dcuentas][]=$r[2];
	 					$_POST[dvalores][]=$r[4];
	   					$_POST[dncuentas][]=buscaNombreCuenta($r[2],$_POST[vigencia]);

						$_POST[drecursos][]=buscafuenteppto($r[2],$_POST[vigencia]);
						// echo count($_POST[drecursos]);
	 				}
					
	  			?>
	   			<table class="inicio">
	   				<tr><td colspan="4" class="titulos">Detalle Orden de Pago</td></tr>                  
					<tr>
                    	<td class="titulos2" style='width:15%'>Cuenta</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2" style='width:35%'>Recurso</td>
                        <td class="titulos2" style='width:10%'>Valor</td>
                 	</tr>
		  			<?php
		  				$_POST[totalc]=0;
						$iter='saludo1a';
		 				$iter2='saludo2';
		 				for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 				{		 		
		 					echo "
							<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
							<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
							<input type='hidden' name='drecursos[]' value='".$_POST[drecursos][$x]."'/>
							<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'/>
							<tr class='$iter'>
		 						<td>".$_POST[dcuentas][$x]."</td>
		 						<td >".iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT", $_POST[dncuentas][$x])."</td>
		 						<td >".iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT", $_POST[drecursos][$x])."</td>
		 						<td style='text-align:right;'>$ ".number_format($_POST[dvalores][$x],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"])."</td>
		 					</tr>";
		 					$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
							$_POST[totalcf]=number_format($_POST[totalc],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"]);
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
		 				}
						$resultado = convertir($_POST[totalc]);
						$_POST[letras]=$resultado." PESOS M/CTE";
	    				echo "
						<input type='hidden' name='totalcf' value='$_POST[totalcf]'/>
						<input type='hidden' name='totalc' value='$_POST[totalc]'/>
						<input type='hidden' name='letras' value='$_POST[letras]' >
						<tr class='$iter' style='text-align:right;font-weight:bold;'>
							<td colspan='3'>Total:</td>
							<td>$ $_POST[totalcf]</td>
						</tr>
						<tr class='titulos2'>
							<td >Son:</td>
							<td colspan='3'>$_POST[letras]</td>
						</tr>";
		?>
        <script>
        document.form2.valor.value=<?php echo $_POST[totalc];?>;
		//calcularpago();
        </script>
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$scdetalle=eliminar_comillas($_POST[detallegreso]);
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$sqlr="update tesoordenpago set fecha='$fechaf', tercero='$_POST[tercero]', conceptorden='$scdetalle' where id_orden=$_POST[idcomp] and tipo_mov='201' ";
if (!mysql_query($sqlr,$linkbd))
		{
			 echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Actualizado la Orden de Pago con Exito <img src='imagenes\alert.png'></center></td></tr></table>";
		}
		else
		{
	$sqlr="update comprobante_cab set fecha='$fechaf',concepto='$scdetalle' where id_comp=$_POST[compcont]";
	mysql_query($sqlr,$linkbd);
	$sqlr="update comprobante_det set tercero='$_POST[tercero]' where id_comp='11 $_POST[idcomp]'";
	mysql_query($sqlr,$linkbd);
	 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado la Orden de Pago con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
		}
//************CREACION DEL COMPROBANTE CONTABLE ************************
//***busca el consecutivo del comprobante contable
}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 