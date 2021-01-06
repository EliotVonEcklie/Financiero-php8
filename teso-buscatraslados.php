<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<title>:: Spid - Tesoreria</title>

	<script>
		//************* ver reporte ************
		//***************************************
		function verep(idfac)
		{
		 	document.form1.oculto.value=idfac;
		  	document.form1.submit();
		}
	
		//************* genera reporte ************
		//***************************************
		function genrep(idfac)
		{
		  	document.form2.oculto.value=idfac;
		  	document.form2.submit();
		}
	
		function buscacta(e)
		{
			if (document.form2.cuenta.value!="")
			{
			 	document.form2.bc.value='1';
				document.form2.submit();
			}
		}
	</script>
	<script language="JavaScript1.2">
		function validar()
		{
			document.form2.submit();
		}
	
		function buscater(e)
		{
			if (document.form2.tercero.value!="")
			{
				document.form2.bt.value='1';
				document.form2.submit();
			}
		}
	
		function agregardetalle()
		{
			if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
			{ 
				document.form2.agregadet.value=1;
				//			document.form2.chacuerdo.value=2;
				document.form2.submit();
			}
			else
			{
			 	alert("Falta informacion para poder Agregar");
			}
		}
	
		//************* genera reporte ************
		//***************************************
		function eliminar(idr)
		{
			if (confirm("Esta Seguro de Eliminar el Traslado "+idr))
		  	{
			  	document.form2.oculto.value=2;
			  	document.form2.var1.value=idr;
				document.form2.submit();
		  	}
		}
	
		//************* genera reporte ************
		//***************************************
		function guardar()
		{

		if (document.form2.fecha.value!='')
		  {
			if (confirm("Esta Seguro de Guardar"))
		  	{
			  	document.form2.oculto.value=2;
			  	document.form2.submit();
		  	}
		  }
		  else{
		  	alert('Faltan datos para completar el registro');
		  	document.form2.fecha.focus();
		  	document.form2.fecha.select();
		  }
		}
	
		function pdf()
		{
			document.form2.action="teso-pdftraslados.php";
			document.form2.target="_BLANK";
			document.form2.submit(); 
			document.form2.action="";
			document.form2.target="";
		}
		function verUltimaPos(idr, dc){
				location.href="teso-editatraslados.php?idr="+idr+"&dc="+dc;
			}
	</script>
	<script src="css/programas.js"></script>
	<script src="css/calendario.js"></script>
	<link href="css/css2.css" rel="stylesheet" type="text/css" />
	<link href="css/css3.css" rel="stylesheet" type="text/css" />
	<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
	<table>
		<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("teso");?></tr>
		<tr>
		  	<td colspan="3" class="cinta">
		  		<a href="teso-traslados.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo" title="Nuevo"/></a> 
		  		<a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" title="Guardar" /> </a>
		  		<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" alt="Buscar" title="Buscar"/></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
		  		<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title=" Nueva Ventana"></a>
		 	</td>
		</tr>	
	</table>
	
		<tr><td colspan="3" class="tablaprin"> 

 	<form name="form2" method="post" action="teso-buscatraslados.php">
		<table  class="inicio" align="center" >
		    <tr >
		        <td class="titulos" colspan="6">:. Buscar Traslados de Bancos </td>
		        <td width="139" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
		    </tr>
		    <tr >
		        <td width="162" class="saludo1">Numero Comprobante:</td>
		        <td width="179"><input name="numero" type="text" value="" size="15"></td>
		        <td width="131" class="saludo1">Fecha Inicial: </td>
		    	<td width="131" >
		    		<input name="fechaini" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
		        	<a href="#" onClick="displayCalendarFor('fc_1198971545');">
		        		<img src="imagenes/calendario04.png"  style="width:20px" align="absmiddle" border="0">
		        	</a>          
		        </td>
		  		<td width="147" class="saludo1">Fecha Final: </td>
		    	<td width="149" >
		    		<input name="fechafin" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
		        	<a href="#" onClick="displayCalendarFor('fc_1198971546');">
		        		<img src="imagenes/calendario04.png"  style="width:20px" align="absmiddle" border="0">
		        	</a>          
		        </td>
		        <input name="oculto" type="hidden" value="1"><input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
		        </tr>                       
		</table>  
	    <?php	
			if($_POST[oculto]==2)
			{
				$linkbd=conectar_bd();	
				$sqlr="select * from tesotraslados_cab where id_consignacion=$_POST[var1]";
				$resp = mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($resp);
				//********Comprobante contable en 000000000000
				$sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where tipo_comp=10 and numerotipo=$row[0]";
				mysql_query($sqlr,$linkbd);	
				//  echo $sqlr;
				$sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='10 $row[0]'";
				mysql_query($sqlr,$linkbd);		
				// echo $sqlr;	  
				$sqlr="update tesotraslados_cab set estado='N' where id_consignacion=$row[0]";
				mysql_query($sqlr,$linkbd);
				//echo $sqlr;	  
			}
	   ?>   
      	</form> 
      		<div class="subpantallap">
      			<?php
					$oculto=$_POST['oculto'];
					//if($_POST[oculto])
					{
						$linkbd=conectar_bd();
						$crit1=" ";
						$crit2=" ";
						if ($_POST[numero]!="")
							$crit1=" and tesotraslados_cab.id_consignacion like '%".$_POST[numero]."%' ";
						if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
						{	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
							$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
							$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							$crit2=" and tesotraslados_cab.fecha between '$fechai' and '$fechaf'  ";
						}
						//sacar el consecutivo 
						//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
						$sqlr="select *from  tesotraslados_cab where estado<>'' ".$crit1.$crit2." order by tesotraslados_cab.id_consignacion DESC";
						$resp = mysql_query($sqlr,$linkbd);
						$ntr = mysql_num_rows($resp);
						$con=1;
						echo "<table class='inicio' align='center' >
								<tr>
									<td colspan='7' class='titulos'>.: Resultados Busqueda:</td>
								</tr>
								<tr>
									<td colspan='7'>Traslados Encontrados: $ntr</td>
								</tr>
								<tr>
									<td width='8%' class='titulos2'><center>No Traslado</td>
									<td class='titulos2' width='8%'><center>Fecha</td>
									<td class='titulos2'>Concepto Traslado</td>
									<td class='titulos2'>Valor</td>
									<td width='5%' class='titulos2'>Estado</td>
									<td class='titulos2' width='5%'><center>Anular</td>
									<td class='titulos2' width='5%'><center>Editar</td>
								</tr>";	
						//echo "nr:".$nr;
						$iter='zebra1';
						$iter2='zebra2';
						 while ($row =mysql_fetch_row($resp)) 
						 {
						 	$sqlr="select SUM(VALOR) FROM  tesotraslados WHERE id_trasladocab=$row[0]";
							$resp2=mysql_query($sqlr,$linkbd);
							$row2 =mysql_fetch_row($resp2);
							$valor=$row2[0];
							$estilo='';
							if($_GET[idr]==$row[0]){
								$estilo='background-color:#FF9';
							}
							$idr="'$row[0]'";
							$dc="'$row[0]'";
							echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idr, $dc)\" style='text-transform:uppercase; $estilo' >
									<td style='text-align:center'>$row[0]</td>
									<td style='text-align:center'>$row[2]</td>
									<td >$row[5]</td>
									<td style='text-align:right'>".number_format($valor,2,".",",")."</td>";
							if ($row[4]=='S')
							 	echo "<td ><center>
							 			<img src='imagenes\confirm.png'></center>
							 		</td>
							 		<td >
							 			<a href='#' onClick=eliminar($row[0])>
							 				<center>
							 					<img src='imagenes/anular.png'>
							 				</center>
							 			</a>
							 		</td>";
							if ($row[4]=='N')
								echo "<td style='text-align:center'>
										<img src='imagenes\del3.png'>
									</td>
									<td ></td>";	
							
							echo "<td >
									<a href='teso-editatraslados.php?idr=$row[0]&dc=$row[0]'>
										<center>
											<img src='imagenes/lupa02.png' style='width:20px'>
										</center>
									</a>
								</td>
								</tr>";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
					 echo"</table>";
					}
					?>
				</div>
			</td>
		</tr>     
	</table>
</body>
</html>