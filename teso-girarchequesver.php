  <?php //V 1000 12/12/16 ?>
<?php
	require"comun.inc";
	require"funciones.inc";
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
	$filtro1="'".$_GET['filtro1']."'";
	$filtro2="'".$_GET['filtro2']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script language="JavaScript1.2">
			function validar(){
				var x = document.getElementById("tipomov").value;
				document.form2.movimiento.value=x;
				document.form2.submit();
			}
			function buscaop(e)
 			{
				if (document.form2.orden.value!="")
				{
 					document.form2.bop.value='1';
 					document.form2.submit();
 				}
			 }
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{
					document.form2.agregadet.value=1;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function agregardetalled()
			{
				if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
				{
					document.form2.agregadetdes.value=1;
					document.form2.submit();
 				}
				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
					document.form2.elimina.value=variable;
					document.form2.submit();
				}
			}
			function eliminard(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.eliminad.value=variable;
					document.form2.submit();
				}
			}
			function calcularpago()
 			{
				valorp=document.form2.valor.value;
				descuentos=document.form2.totaldes.value;
				valorc=valorp-descuentos;
				document.form2.valorcheque.value=valorc;
				document.form2.valoregreso.value=valorp;
				document.form2.valorretencion.value=descuentos;
 			}
			function pdf()
			{
				document.form2.action="pdfegreso.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.egreso.value=parseFloat(document.form2.egreso.value)+1;
					var idcta=document.getElementById('egreso').value;
					document.form2.action="teso-girarchequesver.php?idcta="+idcta;
					document.form2.submit();
				}
				else
				{
	  				// alert("Balance Descuadrado"+parseFloat(document.form2.maximo.value));
				}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{

//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {

document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.egreso.value=document.form2.egreso.value-1;
var idcta=document.getElementById('egreso').value;
document.form2.action="teso-girarchequesver.php?idcta="+idcta;
document.form2.submit();
 }
}

			function iratras(){
				var idcta=document.getElementById('egreso').value;
				location.href="teso-buscagirarcheques.php?idcta="+idcta;
			}
</script>
<script language="JavaScript1.2">
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.egreso.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="teso-girarchequesver.php";
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
		$scrtop=26*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a href="teso-girarcheques.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#"  class="mgbt1"><img src="imagenes/guardad.png" title="Guardar" /></a>
					<a href="teso-buscagirarcheques.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="<?php echo paginasnuevas("teso");?>"  class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Buscar" style="width:29px;height:25px;"/></a>
					<a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>
		</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[vigencia]=$vigusu;
			$sqlr="select *from cuentapagar where estado='S' ";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) {$_POST[cuentapagar]=$row[1];}
	  		//*********** cuenta origen va al credito y la destino al debito
			if(!$_POST[oculto])
			{
				$sqlr="select *from cuentapagar where estado='S' ";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) {$_POST[cuentapagar]=$row[1];}
				$sqlr="select * from tesoegresos ORDER BY id_egreso DESC";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
				$_POST[ncomp]=$_GET[idegre];
				$check1="checked";
			}
			$_POST[vigencia]=$vigusu;
			if($_POST[oculto]=='1' || !$_POST[oculto])
			{
		 		$sqlr="select * from tesoegresos where id_egreso=$_POST[ncomp]";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res))
		 		{
		 			$consec=$r[0];
		  			$_POST[orden]=$r[2];
		  			$_POST[estado]=$r[13];
		  			$_POST[tipop]=$r[14];
		  			$_POST[banco]=$r[9];
					if($_POST[tipop]=='transferencia'){
						$_POST[ntransfe]=$r[10];
					}else{
						$_POST[ncheque]=$r[10];
					}

					$_POST[cb]=$r[12];
		  			$_POST[transferencia]=$r[12];
					$_POST[fecha]=$r[3];
					$_POST[codingreso] = $r[15];
					$_POST[ningreso] = buscaingreso($r[15]);
	 			}
				ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
				$_POST[fecha]=$fechaf;
	 			$_POST[egreso]=$consec;
			}
			switch($_POST[tabgroup1])
			{
				case 1:	$check1='checked';break;
				case 2:	$check2='checked';break;
				case 3:	$check3='checked';break;
			}
		?>
		<form name="form2" method="post" action="">
			<?php
                if($_POST[orden]!='' )
                {
                    //*** busca detalle cdp
                    $sqlr="select *from tesoordenpago where id_orden=$_POST[orden] ";
                    $resp = mysql_query($sqlr,$linkbd);
                    $row =mysql_fetch_row($resp);
                    $_POST[concepto]=$row[7];
                    if($_POST[movimiento]=='401'){
                    $sql1="select concepto from tesoegresos where id_orden=$_POST[orden] AND tipo_mov='401' ";
                    $resp1 = mysql_query($sql1,$linkbd);
                    $row1 =mysql_fetch_row($resp1);
                    $_POST[concepto]=$row1[0];
                    }
                    $_POST[tercero]=$row[6];
                    $_POST[ntercero]=buscatercero($_POST[tercero]);
                    $_POST[tercerocta]=buscatercero_cta($_POST[tercero]);
                    $_POST[valororden]=$row[10];
                    $_POST[retenciones]=$row[12];
                    $_POST[totaldes]=number_format($_POST[retenciones],2);
                    $_POST[valorpagar]=$_POST[valororden]-$_POST[retenciones];
					$_POST[bop]="";
					
					$_POST[medioDePago] = $row[19];
						if($_POST[medioDePago] == '')
							$_POST[medioDePago] = '-1';
					
                }
                else
                {
                    $_POST[cdp]="";
                    $_POST[detallecdp]="";
                     $_POST[tercero]="";
                    $_POST[ntercero]="";
                    $_POST[bop]="";
                }
            ?>
 			<div class="tabsic" style="height:34.5%; width:99.6%;">
   				<div class="tab">
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Egreso</label>
	   				<div class="content" style="overflow-x:hidden;">
	   					<table class="inicio" align="center" >
	   					<tr>
	     					<td class="titulos" colspan="8" >Comprobante de Egreso</td>
                            <td class="cerrar" style="width:7%"><a href="teso-principal.php">&nbsp;Cerrar</a></td>
                      	</tr>
       					<tr>
                        	<td class="saludo1" style="width:2.7cm;">N&deg; Egreso:</td>
                            <td style="width:16%">
                            	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
                                <input name="cuentapagar" type="hidden" value="<?php echo $_POST[cuentapagar]?>" >
                                <input id="egreso" name="egreso" type="text" value="<?php echo $_POST[egreso]?>"  onKeyUp="return tabular(event,this)" onBlur="validar2()" style="width:50%" >
                                <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
                                <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
                                <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" >
                                <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
                                <input type="text" name="vigencia"  value="<?php echo $_POST[vigencia]?>" onKeyUp="return tabular(event,this)" style="width:22%;" readonly>
                           	</td>
       	  					<td class="saludo1" style="width:2.7cm;">Fecha: </td>
        					<td style="width:12%"><input type="text" id="fc_1198971545" name="fecha"  value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:80%">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"></a></td>
							<?php
								if($_POST[medioDePago]!='2')
								{
									?> 
									<td class="saludo1" style="width:2.8cm;">Forma de Pago:</td>
									<td style="width:15%">
										<select name="tipop" onChange="validar();" ="return tabular(event,this)" style="width:100%">
											<option value="">Seleccione ...</option>
											<option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
											<option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
											<option value="caja" <?php if($_POST[tipop]=='caja') echo "SELECTED"?>>Efectivo</option>
										</select>
									</td>
								<?php 
								}
								else
								{
									$_POST[tipop]='';
									//echo "<td style='width:2.8cm;'></td><td style='width:14%'></td>";
									?>
									<td class="saludo1" style="width:10%">Ingreso:</td>
									<td style="width:6%;">
										<input type="text" id="codingreso" name="codingreso" value="<?php echo $_POST[codingreso]?>"  onKeyUp="return tabular(event,this)" onBlur="buscaing(event)" style="width:100%;" readonly>
										<input type="hidden" value="0" name="bin">
									</td>
									<td><input type="text" name="ningreso" id="ningreso" value="<?php echo $_POST[ningreso]?>" style="width:100%;" readonly></td>
									<?php 
								}
								?>
       					</tr>
						<tr>
                        	<td class="saludo1">Estado:</td>
                            <td>
                            	<?php
                            		if($_POST[estado]=="S")
                            		{
                            			echo "<input name='estado' type='text' value='ACTIVO' size='5' style='width:98%; background-color:#0CD02A; color:white; text-align:center;' readonly >";
                            		}
                            		else
                            		{
                            			echo "<input name='estado' type='text' value='REVERSADO' size='5' style='width:98%; background-color:#FF0000; color:white; text-align:center;' readonly >";
                            		}
                            	?>

                            </td>
                        	<td class="saludo1">No Orden Pago:</td>
	 						<td><input name="orden" type="text" value="<?php echo $_POST[orden]?>" onKeyUp="return tabular(event,this)" onBlur="buscaop(event)" style="width:80%" readonly><input type="hidden" value="0" name="bop">

	 						</td>

	 						<td>
	 							<select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" onChange="validar()">
                 <?php
                 $codMovimiento='201';
				if(isset($_POST['movimiento'])){
						 	if(!empty($_POST['movimiento']))
						 		$codMovimiento=$_POST['movimiento'];
						 }
                 $sql="SELECT tipo_mov FROM tesoegresos where id_egreso=$_POST[egreso] AND vigencia='$vigusu' ORDER BY tipo_mov";

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
      						<td class="saludo1">Tercero:</td>
          					<td><input type="text" id="tercero" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:98%" readonly></td>
           					<td colspan="2"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly></td>
                            <td class="saludo1">Cuenta:</td>
                            <td><input name="tercerocta" type="text" value="<?php echo $_POST[tercerocta]?>" style="width:100%" readonly></td>
                     	</tr>
						<tr>
                        	<td class="saludo1">Concepto:</td>
							<td colspan="6"><textarea id="concepto" name="concepto" style="width:100%; height:40px;resize:none;background-color:#E6F7FF;color:#333;border-color:#ccc;" readonly><?php echo $_POST[concepto];?></textarea></td>
                     	</tr>
      					<?php
	  						if($_POST[tipop]=='cheque')//**** if del cheques
	   					 	{
	  					?>
           						<tr>
	  								<td class="saludo1">Cuenta Bancaria:</td>
	  								<td >
	     								<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      									<option value="">Seleccione....</option>
		  									<?php
												$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban, tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S'  and tesobancosctas.tipo='Corriente' ";
												$res=mysql_query($sqlr,$linkbd);
												while ($row =mysql_fetch_row($res))
				    							{
					 								if($row[1]==$_POST[banco])
			 										{
						 								echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
						 								$_POST[nbanco]=$row[4];
						  								$_POST[ter]=$row[5];
						 								$_POST[cb]=$row[2];
						 								$_POST[tcta]=$row[3];
						 							}
													else{echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";}
												}
											?>
            							</select>
										<input name="tcta" type="hidden" value="<?php echo $_POST[tcta]?>" >
                                        <input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                                        <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
                                	</td>
                                    <td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%" readonly></td>
									<td class="saludo1">Cheque:</td>
                                    <td ><input type="text" id="ncheque" name="ncheque" value="<?php echo $_POST[ncheque]?>" style="width:100%" readonly></td>
	  							</tr>
      					<?php
	     					}//cierre del if de cheques
	  						if($_POST[tipop]=='transferencia')//**** if del transferencias
	    					{
	  					?>
      							<tr>
	  								<td class="saludo1">Cuenta Bancaria:</td>
	  								<td >
	     								<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      									<option value="">Seleccione....</option>
		  									<?php
												$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban, tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
												$res=mysql_query($sqlr,$linkbd);
												while ($row =mysql_fetch_row($res))
				    							{
													echo "";
													$i=$row[1];
					 								if($i==$_POST[banco])
			 										{
														echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
						 								$_POST[nbanco]=$row[4];
						  								$_POST[ter]=$row[5];
						 								$_POST[cb]=$row[2];
						 								$_POST[tcta]=$row[3];
													}
					  								else {echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";}
												}
											?>
            							</select>
										<input name="tcta" type="hidden" value="<?php echo $_POST[tcta]?>" >
                                        <input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                                        <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
                                  	</td>
                                    <td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%" readonly></td>
									<td class="saludo1">No Transferencia:</td>
                                    <td ><input type="text" id="ntransfe" name="ntransfe" value="<?php echo $_POST[ntransfe]?>" style="width:100%" readonly></td>
	  							</tr>
      					<?php
							 }//cierre del if de cheques
							 if($_POST[tipop]=='caja')//**** if del transferencias
	    					{
	  					?>
      							<tr>
	  								<td class="saludo1">Cuenta Caja:</td>
	  								<td >
	     								<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      									<option value="">Seleccione....</option>
		  									<?php
											  	$sqlr="select cuentacaja from tesoparametros";
												$res=mysql_query($sqlr,$linkbd);
												while ($row =mysql_fetch_row($res)) 
												{
													$_POST[nbanco] = buscacuenta($row[0]);
													echo "";
													$i=$row[0];
					 								if($i==$_POST[banco])
			 										{
														echo "<option value='$row[0]' SELECTED>$row[0] - Cuenta $_POST[nbanco]</option>";
						 								
													}
					  								else {echo "<option value='$row[0]'>$row[0] - Cuenta $_POST[nbanco]</option>";}
												}
											?>
            							</select>
                                  	</td>
                                    <td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%" readonly></td>
	  							</tr>
      					<?php
	     					}//cierre del if de efectivo
      					?>
	  					<tr>
	  					<td class="saludo1">Valor Orden:</td>
                        <td><input name="valororden" type="text" id="valororden" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valororden]?>" style="width:98%" readonly></td>
                        <td class="saludo1">Retenciones:</td>
                        <td><input name="retenciones" type="text" id="retenciones" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[retenciones]?>" style="width:100%" readonly></td>
                        <td class="saludo1">Valor a Pagar:</td>
                        <td><input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valorpagar]?>" style="width:100%" readonly> <input type="hidden" value="1" name="oculto"></td>
                   	</tr>
      			</table>
	 		</div>
     </div>
     <div class="tab">
       <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       <label for="tab-2">Retenciones</label>
       <div class="content">
         <table class="inicio" style="overflow:scroll">
         <tr >
        <td class="titulos" colspan="8">Retenciones</td>
      </tr>
       <tr><td></td><td class="saludo1">Total:</td><td><input id="totaldes" name="totaldes" type="text" size="10" value="<?php echo $_POST[totaldes]?>" readonly></td></tr>
        <tr><td class="titulos2">Descuento</td><td class="titulos2">%</td><td class="titulos2">Valor</td></tr>
      	<?php
		if ($_POST[oculto]!='2')
		 {
		$totaldes=0;
		$_POST[dndescuentos]=array();
		$_POST[ddescuentos]=array();
		$_POST[dporcentajes]=array();
		$_POST[ddesvalores]=array();
		$sqlr="select *from tesoordenpago_retenciones where id_orden=$_POST[orden] and estado='S'";
		//echo $sqlr;
		$resd=mysql_query($sqlr,$linkbd);
		while($rowd=mysql_fetch_row($resd))
		 {
		 $sqlr2="SELECT *from tesoretenciones where id=".$rowd[0];
		 //echo $sqlr2;
		 $resd2=mysql_query($sqlr2,$linkbd);
		  $rowd2=mysql_fetch_row($resd2);
		 echo "<tr><td class='saludo2'><input name='dndescuentos[]' value='".$rowd2[1]." - ".$rowd2[2]."' type='text' size='100' readonly><input name='ddescuentos[]' value='".$rowd2[1]."' type='hidden'></td>";
		 echo "<td class='saludo2'><input name='dporcentajes[]' value='".$rowd[2]."' type='text' size='5' readonly></td>";
		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".($rowd[3])."' type='text' size='15' readonly></td></tr>";
// 		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".$_POST[ddesvalores][$x]."' type='text' size='15'></td><td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $totaldes=$totaldes+($rowd[3])	;
		 }
		 }
		?>
        <script>
        document.form2.totaldes.value=<?php echo $totaldes;?>;
	calcularpago();
//       document.form2.valorretencion.value=<?php echo $totaldes;?>;
        </script>
        </table>

      </table>
	   </div>
   </div>

     <div class="tab">
       <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
       <label for="tab-3">Afectacion Presupuestal</label>
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
									$sqlr="select *from pptoretencionpago where idrecibo=$_POST[egreso] and vigencia=$_POST[vigencia] and cuenta!='' and tipo='egreso'";
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

		<div class="subpantallac4" style="height:40%; width:99.6%; overflow-x:hidden;">
	 		<table class="inicio">
	   			<tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>
				<tr>
                	<td class="titulos2">Cuenta</td>
                    <td class="titulos2">Nombre Cuenta</td>
                    <td class="titulos2">Recurso</td>
                    <td class="titulos2">Valor</td>
             	</tr>
				<?php
					if ($_POST[elimina]!='')
		 			{
		 				$posi=$_POST[elimina];
						unset($_POST[dccs][$posi]);
						unset($_POST[dvalores][$posi]);
		 				$_POST[dccs]= array_values($_POST[dccs]);
		 			}
		 			if ($_POST[agregadet]=='1')
		 			{
		 				$_POST[dccs][]=$_POST[cc];
						$_POST[agregadet]='0';
		  		?>
						<script>
                            //document.form2.cuenta.focus();
                            document.form2.banco.value="";
                            document.form2.nbanco.value="";
                            document.form2.banco2.value="";
                            document.form2.nbanco2.value="";
                            document.form2.cb.value="";
                            document.form2.cb2.value="";
                            document.form2.valor.value="";
                            document.form2.numero.value="";
                            document.form2.agregadet.value="0";
                            document.form2.numero.select();
                            document.form2.numero.focus();
                      	</script>
             	<?php
		  			}
		  			$_POST[totalc]=0;
		  			$sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] and tipo_mov='201' ";
				//echo $sqlr;
				$dcuentas[]=array();
				$dncuentas[]=array();
				$resp2 = mysql_query($sqlr,$linkbd);
				$iter='saludo1a';
				$iter2='saludo2';
				while($row2=mysql_fetch_row($resp2))
				 {
					 $sql="select vigencia,iva FROM tesoordenpago where id_orden=$_POST[orden]";
					 $result=mysql_query($sql,$linkbd);
					 $vigDocumento=mysql_fetch_array($result);
				  //$_POST[dcuentas][]=$row2[2];
					$_POST[iva]=$vigDocumento[1];
				  $nombre=buscaNombreCuenta($row2[2],$vigDocumento[0]);
				  $nfuente=buscafuenteppto($row2[2],$vigDocumento[0]);
				  //$_POST[dvalores][]=$row2[4];
		 echo "
		 <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
		 	<td><input name='iva' id='iva' value='".$_POST[iva]."' type='hidden'><input name='dcuentas[]' value='".$row2[2]."' type='hidden'>$row2[2]</td>
			<td><input name='dncuentas[]' value='".$nombre."' type='hidden' >$nombre</td>
			<td><input name='drecursos[]' value='".$nfuente."' type='hidden' >$nfuente</td>
			<td style='text-align:right;'><input name='dvalores[]' value='".$row2[4]."' type='hidden' readonly>$row2[4]</td>
		</tr>";
		 $_POST[totalc]=$_POST[totalc]+$row2[4];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 $aux=$iter;
	 	$iter=$iter2;
	 	$iter2=$aux;
		 }
		$resultado = convertir($_POST[valorpagar]);
		$_POST[letras]=$resultado." PESOS M/CTE";
	    echo "
		<tr class='$iter'>
			<td style='text-align:right;' colspan='3'>Total:</td>
			<td style='text-align:right;'><input name='totalcf' type='hidden' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'>$_POST[totalcf]</td>
		</tr>
		<tr class='titulos2'>
			<td>Son:</td>
			<td colspan='5'><input name='letras' type='hidden' value='$_POST[letras]'>$_POST[letras]</td>
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
	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
//************CREACION DEL COMPROBANTE CONTABLE ************************
$sqlr="update  tesoegresos set fecha='$fechaf' where id_egreso=$_POST[egreso]";
$res=mysql_query($sqlr,$linkbd);
$sqlr="update  comprobante_cab set fecha='$fechaf' where 	numerotipo=$_POST[egreso] and tipo_comp=6";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
}//************ FIN DE IF OCULTO************
?>
</form>
 </td></tr>
</table>
</body>
</html>
