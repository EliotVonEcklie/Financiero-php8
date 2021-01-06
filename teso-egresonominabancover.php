<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	require "validaciones.inc";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
		 <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function guardar()
			{
				var concepto=document.form2.concepto.value;
				if(concepto==''){despliegamodalm('visible','2','Falta la Causa');}
				else{despliegamodalm('visible','4','Esta Seguro de Actualizar la Informacion','1');}
			}
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.form2.oculto.value='2';
						document.form2.submit();
					break;
				}
			}
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!="")
				{
 					document.form2.bc.value='1';
 					document.form2.submit();
 				}
	 		}
			function validar()
			{
				document.form2.action="teso-egresonominabancover.php";
				document.form2.submit();
			}
			function validar(id)
			{
				document.form2.formapa.value="1";
				document.form2.ncomp.value=id;
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
				document.form2.action="pdfegresonominacambio.php";
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
					document.form2.action="teso-egresonominabancover.php";
					document.form2.submit();
				}
				else
				{
	  				// alert("Balance Descuadrado"+parseFloat(document.form2.maximo.value));
				}
			}
			function atrasc()
			{
				if(document.form2.ncomp.value>1)
 				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.egreso.value=document.form2.egreso.value-1;
					document.form2.action="teso-egresonominabancover.php";
					document.form2.submit();
 				}
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('ncomp').value;
				location.href="teso-buscaegresonominabanco.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden") {document.getElementById('ventanam').src="";}
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
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <?php $numpag=$_GET[numpag];$limreg=$_GET[limreg];$scrtop=22*$totreg;?>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
 		 		<td colspan="3" class="cinta">
					<a><img src="imagenes/add2.png" title="Nuevo" class="mgbt1"/></a>
					<a><img src="imagenes/guarda.png" onClick="guardar()" class="mgbt"/></a>
					<a><img src="imagenes/busca.png" title="Buscar" class="mgbt" onClick="location.href='teso-buscaegresonominabanco.php'"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"></a>
					<a><img src="imagenes/print.png"  title="Imprimir"  onClick="pdf()" class="mgbt"/></a>
					<a><img src="imagenes/iratras.png" title="Atr&aacute;s"  onClick="iratras(<?php echo "$scrtop,$numpag,$limreg,$filtro)" ?>)" class="mgbt"></a>
				</td>
			</tr>		  
		</table>
		<?php
			$vigencia=date(Y);
			$sqlr="select *from cuentapagar where estado='S' ";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)){ $_POST[cuentapagar]=$row[1];}
		  	//*********** cuenta origen va al credito y la destino al debito
			if(!$_POST[oculto])
			{
				$sqlr="select *from cuentapagar where estado='S' ";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){ $_POST[cuentapagar]=$row[1];}
				$sqlr="select * from tesoegresosnomina ORDER BY id_EGRESO DESC";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
				$_POST[ncomp]=$_GET[idegre];
				$check1="checked";
 				//$fec=date("d/m/Y");
		 		//$_POST[fecha]=$fec; 		 		  			 
				//$_POST[valor]=0;
				//$_POST[valorcheque]=0;
				//$_POST[valorretencion]=0;
				//$_POST[valoregreso]=0;
				//$_POST[totaldes]=0;
			}
		 	$_POST[vigencia]=$_SESSION[vigencia]; 		
			if($_POST[oculto]=='1' || !$_POST[oculto])
			{		 
				$sqlr="select * from tesoegresosnomina_banco where id_egreso=$_POST[ncomp]";
				$res=mysql_query($sqlr,$linkbd);
				$numerofilas=mysql_num_rows($res);
				$camposnu=mysql_fetch_row($res);
				$_POST[bancoant]=$camposnu[2];
				$_POST[concepto]=$camposnu[6];
				$_POST[usuario]=$camposnu[5];
				
		 		$sqlr="select * from tesoegresosnomina where id_egreso=$_POST[ncomp]";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
		while($r=mysql_fetch_row($res))
		 {
			// echo $r[10];
			$consec=$r[0];	  
			$_POST[orden]=$r[2];
			$_POST[estado]=$r[13];
			if($_POST[formapa]=="" || !isset($_POST[formapa])){
				$_POST[tipop]=$r[14];
				$_POST[banco]=$r[9];
			}
			if($_POST[tipop]=='transferencia'){
				$_POST[ntransfe]=$r[10];
			}else{
				$_POST[ncheque]=$r[10];	
			}
			$_POST[cb]=$r[12];		  
			$_POST[transferencia]=$r[12];
			$_POST[fecha]=$r[3];		  		  		  
	 	}
		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		$_POST[fecha]=$fechaf;
	 	$_POST[egreso]=$consec;		 
}
switch($_POST[tabgroup1])
{
case 1:
$check1='checked';
break;
case 2:
$check2='checked';
break;
case 3:
$check3='checked';
}
?>
<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 <form name="form2" method="post" action=""> 
 <?php
				 if($_POST[orden]!='' )
				 {
			  //*** busca detalle cdp
			    $linkbd=conectar_bd();
  				$sqlr="select *from tesoegresosnomina where id_egreso=$_POST[ncomp] ";
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[tercero]=$row[11];
				$_POST[ntercero]=buscatercero($_POST[tercero]);
				$_POST[valororden]=$row[7];
				$_POST[retenciones]=0;
				$_POST[totaldes]=number_format($_POST[retenciones],2);
				$_POST[valorpagar]=$_POST[valororden]-$_POST[retenciones];
				$_POST[bop]="";
				
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
	
	<table class="inicio" align="center"  style="border:none!">       
	   	<tr>
	     	<td class="titulos">Comprobante de Egreso Nomina</td>
	     	<td width="74" class="cerrar" >
	     		<a href="teso-principal.php">Cerrar</a>
	     	</td>
	    </tr>
	</table>
	
	<table class="inicio" align="center" >       

       	<tr>
       		<td class="saludo1" style="width: 7%">No Egreso:</td>
       		<td style="width:10%;">
       			<a href="#" onClick="atrasc()">
       				<img src="imagenes/back.png" alt="anterior" align="absmiddle">
       			</a>
       			<input name="cuentapagar" type="hidden" value="<?php echo $_POST[cuentapagar]?>" > 
       			<input name="egreso" type="text" value="<?php echo $_POST[egreso]?>" size="10" onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" onChange="validar(document.form2.egreso.value)" > 
       			<input name="ncomp" id="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
       			<a href="#" onClick="adelante()">
       				<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
       			</a> 
       			<input type="hidden" value="a" name="atras" >
       			<input type="hidden" value="s" name="siguiente" >
       			<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
       		</td>
			<td class="saludo1" style="width:7%;">Fecha: </td>
        	<td style="width:10%"><input type="text" id="fc_1198971545" name="fecha" value="<?php echo $_POST[fecha]?>" title="DD/MM/YYYY" maxlength="10" onKeyDown="mascara(this,'/',patron,true)" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:80%">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;" ></a></td> 	
			
       		<td class="saludo1" style="width: 7% !important">Forma de Pago:</td>
       		<td>
       			<select name="tipop" onChange="validar(document.form2.egreso.value)" style="width: 100% ">
       				<option value="">Seleccione ...</option>
				  	<option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
  				  	<option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
				</select>
          	</td> 
			<input name="formapa" id="formapa" type="hidden" value="<?php echo $_POST[formapa]; ?>" /> 			
       		<td width="20%" rowspan="5"  style="background-image:url('imagenes/cheque04.png');background-repeat: no-repeat;background-position:center; background-size:200px "></td>			
       	</tr>
		<tr>  
			<td class="saludo1">No Orden Pago:</td>
	  		<td style="width:10%;">
	  			<input name="orden" type="text" value="<?php echo $_POST[orden]?>" style="width:100%;" onKeyUp="return tabular(event,this)" onBlur="buscaop(event)" readonly >
	  			<input type="hidden" value="0" name="bop">  
	  		</td>
      		<td style="width:8%;" class="saludo1">Tercero:</td>
          	<td style="width:10%;">
          		<input id="tercero" type="text" name="tercero" style="width:100%;" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" readonly>
           	</td>
           	<td colspan="2">
           		<input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly>
           	</td>
        </tr>
		<tr>
			<td class="saludo1">Causa de Cambio:</td>
			<td colspan="5" style="width:38%;">
				<textarea id="concepto" name="concepto" style="width:100%; height:40px;resize:none;background-color:#FFF;color:#333;border-color:#ccc;" <?php if(!empty($_POST[concepto]) ){echo "readonly"; } ?> ><?php echo $_POST[concepto]; ?></textarea>
			</td>
		</tr>           
      	<?php 
	  		//**** if del cheques
	  		if($_POST[tipop]=='cheque')
	    	{
	  	?>    
        <tr>
	  		<td class="saludo1">Cuenta Bancaria:</td>
	  		<td style="width:10%;">
	     		<select id="banco" name="banco" onChange="validar(documento.form2.egreso.value)" onKeyUp="return tabular(event,this)">
		<?php
			$linkbd=conectar_bd();
			$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S'  and tesobancosctas.tipo='Corriente' ";
			echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);

			while ($row =mysql_fetch_row($res)) 
			{
				echo "<option value=$row[1] ";
				$i=$row[1];
				if($i==$_POST[banco])
			 	{
					echo "SELECTED";
					$_POST[nbanco]=$row[4];
					$_POST[ter]=$row[5];
					$_POST[cb]=$row[2];
					$_POST[tcta]=$row[3];
				}
				echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
			}	 	
		?>
        	    </select>
        <?php
				
		?>
				<input name="tcta" type="hidden" value="<?php echo $_POST[tcta]?>" >
				<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
				<input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
			</td>
			<td colspan="2">
				<input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="50" readonly>
			</td>
			<td style="width:10%;" class="saludo1">Cheque:</td>
			<td style="width:10%;">
				<input type="text" id="ncheque" name="ncheque" value="<?php echo "123".$_POST[ncheque]; ?>" size="20" readonly>
			</td>
	  	</tr>
      	<?php
	     	}//cierre del if de cheques
      ?> 
       <?php 
	   
	  //**** if del transferencias
	  if($_POST[tipop]=='transferencia')
	    {
	  ?> 
      <tr>
	  	<td class="saludo1">Cuenta Bancaria:</td>
	  	<td >
	     	<select id="banco" name="banco"  onChange="validar(document.form2.egreso.value)" onKeyUp="return tabular(event,this)" style="width: 100%">
		<?php
			$linkbd=conectar_bd();
			$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) 
			{
				echo "<option value=$row[1] ";
				$i=$row[1];
				if($i==$_POST[banco])
			 	{
					echo "SELECTED";
					$_POST[nbanco]=$row[4];
					$_POST[ter]=$row[5];
					$_POST[cb]=$row[2];
					$_POST[tcta]=$row[3];
				}
				echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
			}	 	
		?>
            </select>				
			<input name="tcta" type="hidden" value="<?php echo $_POST[tcta]?>" >
			<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
			<input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
		</td>
		<td colspan="2">
			<input type="text" id="nbanco" style="width:100%;" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="50" readonly>
		</td>
		<td class="saludo1">No Transferencia:</td>
		<td >
			<input type="text" id="ntransfe" name="ntransfe" value="<?php echo $_POST[ntransfe]?>" size="20" >
		</td>
	</tr>
      	<?php
	     }//cierre del if de cheques
      	?> 
		<?php
							
							if($numerofilas>0){
								echo "<tr>";
								echo "<td class='saludo1'>Cuenta Bancaria Ant.:</td>";
								echo "<td ><select id='bancoant' name='bancoant' disabled>";
								
								$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban, tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
								echo "";
								$i=$row[1];
					 			if($i==$_POST[bancoant])
			 					{
								echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
								$_POST[nbancoant]=$row[4];
								$_POST[tctant]=$row[3];
								$_POST[cbant]=$row[2];
								}
					  			else {echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";} 
								}
								echo "</select>
								</td>";
								echo "<td colspan=\"2\"><input type=\"text\" id=\"nbancoant\" name=\"nbancoant\" value='$_POST[nbancoant]' style=\"width:100%\" readonly></td>";
								if($_POST[tipop]=='transferencia')//**** if del transferencias
								{
									echo "<td class=\"saludo1\">No Transferencia Ant.:</td>
                                    <td ><input type=\"text\" id=\"ntransfeant\" name=\"ntransfeant\" value='$_POST[ntransfeant]' style=\"width:100%\"></td>";
								echo "</tr>";
								}else{
									echo "<td class=\"saludo1\">Cheque Ant.:</td>
                                    <td ><input type=\"text\" id=\"nchequeant\" name=\"nchequeant\" value='$_POST[nchequeant]' style=\"width:100%\"></td>";
								echo "</tr>";
								}
								
							}
						?>
						<input name="tctant" type="hidden" value="<?php echo $_POST[tctant]?>" >
						<input name="cbant" type="hidden" value="<?php echo $_POST[cbant]?>" >
	<tr>
	 	<td class="saludo1">Valor Orden:</td>
	 	<td style="width:10%;">
	 		<input name="valororden" type="text" id="valororden" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valororden]?>"  readonly>
	 	</td>	  
	 	<td style="width:8%;" class="saludo1">Retenciones:</td>
	 	<td style="width:10%;">
	 		<input name="retenciones" type="text" id="retenciones" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[retenciones]?>"  readonly>
	 	</td>	  
	 	<td style="width:10%;" class="saludo1">Valor a Pagar:</td>
	 	<td style="width:10%;">
	 		<input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valorpagar]?>"  readonly> 
	 		<input type="hidden" value="1" name="oculto">
	 	</td>
	</tr>	
      </table>
<div class="subpantallac4">
 <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Egreso Nomina</td></tr>                  
		<tr><td class="titulos2">No</td><td class="titulos2">Nit</td><td class="titulos2">Tercero</td><td class="titulos2">CC</td><td class="titulos2">Cta Presupuestal</td><td class="titulos2">Valor</td></tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
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
		  $sqlr="select *from tesoegresosnomina_DET where id_egreso=$_POST[egreso] and estado='S'";
				//echo $sqlr;
				$iter='zebra1';
				$iter2='zebra2';	
				$dcuentas[]=array();
				$dncuentas[]=array();
				$resp2 = mysql_query($sqlr,$linkbd);
				while($row2=mysql_fetch_row($resp2))
				 {
				  //$_POST[dcuentas][]=$row2[2];
				  $nid=$row2[3];
				  $nombre=buscacuentapres($row2[6],2);
				  $tercero=buscatercero($row2[4]);
				  //$_POST[dvalores][]=$row2[4];				
		echo "<tr  class='$iter'><td ><input type='text' size='1' name='tedet[]' value='".$row2[3]."' readonly></td><td ><input name='decuentas[]' value='".$row2[4]."' type='text' size='20' readonly><input name='ddescuentos[]' value='".$_POST[ddescuentos][$jp]."' type='hidden'></td>";
		 echo "<td ><input name='dencuentas[]' value='".$tercero."' type='text' size='90' readonly></td>";
		 echo "<td><input name='deccs[]' value='".$row2[7]."' type='text' size='2' readonly></td>";
		 echo "<td ><input name='derecursos[]' value='".$row2[6]."' type='text' readonly></td>";
		 echo "<td ><input name='devalores[]' value='".$row2[8]."' type='text' size='15' readonly></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$row2[8];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 		 	 $aux=$iter;
			 $iter=$iter2;
			 $iter2=$aux;	
		 }
		$resultado = convertir($_POST[valorpagar]);
		$_POST[letras]=$resultado." PESOS M/CTE";
	    echo "<tr><td colspan='4'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' size='15' value='$_POST[totalcf]' readonly><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td  class='saludo1'>Son:</td> <td colspan='5' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' size='150'></td></tr>";
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
	if($_POST[tipop]=='cheque'){$vartipos=$_POST[ncheque];}
	if($_POST[tipop]=='transferencia'){$vartipos=$_POST[ntransfe];}
	$sqlr="select * from tesoegresosnomina_banco where id_egreso=$_POST[ncomp]";
	$res=mysql_query($sqlr,$linkbd);
    $numerofilas=mysql_num_rows($res);
	if($numerofilas>0){
		echo "<script>despliegamodalm('visible','1','Ya existe un comprobante de cambio para este egreso');</script>";
	}else{
		$sqlr="select banco,cheque,cuentabanco,pago from tesoegresosnomina where id_egreso=$_POST[ncomp]";
	$res=mysql_query($sqlr,$linkbd);
	while($row = mysql_fetch_row($res)){
		$bancoant=$row[0];
		$chequeant=$row[1];
		$cuentabanant=$row[2];
		$tipoant=$row[3];

	}			

	$sql="UPDATE tesoegresosnomina SET banco='$_POST[banco]',cheque='$vartipos',cuentabanco='$_POST[cb]',pago='$_POST[tipop]' WHERE id_egreso= $_POST[egreso] ";
	if(mysql_query($sql,$linkbd)){
		$sqlr="UPDATE comprobante_det SET cheque='$vartipos',cuenta='$_POST[banco]' WHERE tipo_comp=17 AND numerotipo=$_POST[egreso] AND (detalle LIKE '%banco%' OR  detalle LIKE '%Banco%')";
		mysql_query($sqlr,$linkbd);
		if($bancoant!=$_POST[banco] || $chequeant!=$vartipos || $tipoant!=$_POST[tipop]){
		$sqlr="INSERT INTO tesoegresosnomina_banco(id_egreso,banco_ant,banco_nu,fecha_mod,usuario,objeto,cheque_ant,cheque_nu,tipo_ant,tipo_nu,cuentabanco_ant,cuentanbanco_nu) VALUES ('$_POST[egreso]','$bancoant','$_POST[banco]','$fechaf','$_SESSION[nickusu]','$_POST[concepto]','$chequeant','$vartipos','$tipoant','$_POST[tipop]','$cuentabanant','$_POST[cb]')";
		echo $sqlr;
		mysql_query($sqlr,$linkbd);
		echo "<script>despliegamodalm('visible','1','Se ha actualizado el Egreso con Exito');</script>";
		}else{
		echo "<script>despliegamodalm('visible','1','No hay algun cambio en el comprobante');</script>";
		}
	
		
	}else{
		echo "<script>despliegamodalm('visible','2','Error al actualizar el comprobante');</script>";
	}
	}
	
}
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 