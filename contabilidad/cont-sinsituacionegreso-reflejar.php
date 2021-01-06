<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";  //este es un comentario
	require "conversor.php";
	session_start();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: SPID - Tesoreria</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
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
		if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
		{ 
			document.form2.agregadet.value=1;
	//		document.form2.chacuerdo.value=2;
			document.form2.submit();
		}
		else {
			alert("Falta informacion para poder Agregar");
		}
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
//************* genera reporte ************
//***************************************
	function guardar()
	{
		ingresos2=document.getElementsByName('dcodssf[]');
		if (document.form2.fecha.value!='' )
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
		document.form2.action="pdfssfegre.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}
	function buscater(e)
	{
		if (document.form2.tercero.value!="")
		{
			document.form2.bt.value='1';
			document.form2.submit();
		}
	}
	function buscaing(e)
	{
	if (document.form2.codingreso.value!="")
		{
			document.form2.bin.value='1';
			document.form2.submit();
		}
	}
	function adelante(){
		//document.form2.oculto.value=2;
		if(parseFloat(document.form2.idcomp.value)<parseFloat(document.form2.maximo.value)){
			document.form2.oculto.value=1;
			//document.form2.agregadet.value='';
			//document.form2.elimina.value='';
			document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
			document.form2.action="cont-sinsituacionegreso-reflejar.php";
			document.form2.submit();
		}
	}

	function atrasc(){
		//document.form2.oculto.value=2;
		if(document.form2.idcomp.value>1){
			document.form2.oculto.value=1;
			//document.form2.agregadet.value='';
			//document.form2.elimina.value='';
			document.form2.idcomp.value=document.form2.idcomp.value-1;
			document.form2.action="cont-sinsituacionegreso-reflejar.php";
			document.form2.submit();
 		}
	}
	
	function validar2()
	{
		document.form2.oculto.value=1;
		document.form2.ncomp.value=document.form2.idcomp.value;
		document.form2.action="cont-sinsituacionegreso-reflejar.php";
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
	<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("cont");?></tr>
	<tr>
  		<td colspan="3" class="cinta">
  			<a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
  			<a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" title="Guardar"/></a> 
			<a href="cont-buscasinsituacionegreso.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
  			<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/reflejar1.png"  alt="Reflejar" style="width:24px;" title="Reflejar"/> 
			<a href="#"  onClick="pdf()"  class="mgbt"><img src="imagenes/print.png" title="Imprimir" /></a>
			<a href="cont-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" alt="nueva ventana" title="Atras"></a>
  		</td>
	</tr>		  
</table>
<?php
//$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if($_POST[idcomp]!=""){echo "<script>document.getElementById('codrec').value=$_POST[idcomp];</script>";}
if(!$_POST[oculto]){
	$check1="checked";
	$fec=date("d/m/Y");
	$_POST[vigencia]=$vigusu;
	$linkbd=conectar_bd();

	$linkbd=conectar_bd();
	if($_POST[idcomp]==''){
		$sqlr="SELECT * FROM tesossfegreso_cab WHERE 1 ORDER BY id_orden DESC";	
		$res=mysql_query($sqlr,$linkbd);
		$row =mysql_fetch_row($res);
		$_POST[idcomp]=$row[0];
	}
	
	$sqlr="select * from tesossfegreso_cab ORDER BY id_orden DESC";
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[maximo]=$r[0];
	
	if ($_POST[codrec]!="" || $_POST[idcomp]!=""){
		if($_POST[codrec]!=""){
			$sqlr="select * from tesossfegreso_cab WHERE id_orden='$_POST[codrec]'";
		}
		else{
			$sqlr="select * from tesossfegreso_cab WHERE id_orden='$_POST[idcomp]'";
		}
	}
	else{
		$sqlr="select * from tesossfegreso_cab ORDER BY id_orden DESC";
	}
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[ncomp]=$r[0];
	$_POST[idcomp]=$r[0];
}

$sqlr="select * from tesossfegreso_cab WHERE id_orden='$_POST[idcomp]'";
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
{
	$_POST[fecha]=$row[2];
	$_POST[vigencia]=$row[3];
	$_POST[rp]=$row[4];
	$_POST[detallegreso]=$row[7];	 
	$_POST[tercero]=$row[6];	
	$_POST[ntercero]=buscatercero($row[6]);		 
	$_POST[cc]=$row[5];			 	 	 
	$_POST[valor]=$row[10];
	$_POST[valorcheque]=$row[10];	 
	$_POST[estado]=$row[13];			 	 	 	  	 	 	 
	if($_POST[estado]=='S'){
		$_POST[estadoc]="ACTIVO";
	}
	if($_POST[estado]=='N'){
		$_POST[estadoc]="ANULADO";
	}
}
$_POST[dcodssf]=array();
$_POST[dcodssfnom]=array();
$_POST[dvalores]=array();	
$_POST[dvalores]=array();
$_POST[dcuentas]=array();
$_POST[rubros]=array();
$_POST[dncuentas]=array();
$_POST[drecursos]=array();
$_POST[dnrecursos]=array();
$sqlr="select * from tesossfegreso_det WHERE id_egreso='$_POST[idcomp]'";
$res=mysql_query($sqlr,$linkbd);
while($r=mysql_fetch_row($res))
{
	$codssf=buscacodssf($_POST[rp],$vigusu);
	if($r[5]==''){ //esta es una busqueda alternativa por si no se habia parametrizado antes del ingreso de la celda
		$asqlr="select tc.* from tesoingresossf_cab tc, tesoingresossf_det td WHERE td.codigo=tc.codigo and td.cuentapresgas='$r[2]'";
		$ares=mysql_query($asqlr,$linkbd);
		$ar=mysql_fetch_row($ares);
		$nomcodssf= buscacodssfnom($ar[0]);
		$_POST[dcodssf][]=$ar[0];
		$_POST[dcodssfnom][]=$ar[0]." - ".$nomcodssf;
	}
	else{
		$nomcodssf= buscacodssfnom($r[5]);
		$_POST[dcodssf][]=$r[5];
		$_POST[dcodssfnom][]=$r[5]." - ".$nomcodssf;
	}	 		
	$_POST[dvalores][]=$r[4];
	$_POST[dcuentas][]=$r[2];
	$_POST[rubros][]=$r[2];
	$_POST[dncuentas][]=buscacuentapres($r[2],2);	
	$_POST[drecursos][]=buscafuenteppto($r[2],$_POST[vigencia]);
	$_POST[dnrecursos][]=buscafuenteppto($r[2],$_POST[vigencia]);	
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
 <form name="form2" method="post" action=""> 
 <?php
 //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
//******** busca ingreso *****
//***** busca tercero
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingresossf($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ningreso]="";
			  }
			 }
			 
 ?>
 

    <table class="inicio" align="center" >
	    <tr >
	    	<td class="titulos" style="width:95%;" colspan="2">Egreso SSF VER</td>
	    	<td class="cerrar" style="width:5%;"><a href="teso-principal.php">Cerrar</a></td>
	    </tr>
      	<tr>
      		<td style="width:80%;">
      			<table>
      				<tr>
			      		<td style="width:15%;" class="saludo1" >Numero Egreso SSF:</td>
			        	<td style="width:20%;">
						<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
						<input type="text" name="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  style="width:60%;" />
                        <input type="hidden" name="ncomp" id="ncomp" value="<?php echo $_POST[ncomp]?>"/>
						<a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
			        	</td>
				  		<td style="width:10%;" class="saludo1">Fecha: </td>
			        	<td style="width:15%;">
			        		<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   
			        		<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>     
			        	</td>
				  		<td   class="saludo1">Vigencia: </td>
			        	<td  >
			        		<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> 
			        	</td>
			        </tr>
			        <tr>
			        	<td  class="saludo1">Registro:</td>
			        	<td>
			        		<input name="rp" type="text" value="<?php echo $_POST[rp]?>" onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" >
			        		<input type="hidden" value="0" name="brp">
			            	<a href="#" onClick="mypop=window.open('registro-ventana.php?vigencia=<?php echo $_POST[vigencia]?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        
			            </td>
				  		<td class="saludo1">Centro Costo:</td>
						<td>
							<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
							<?php
							$linkbd=conectar_bd();
							$sqlr="select *from centrocosto where estado='S'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
										    {
											echo "<option value=$row[0] ";
											$i=$row[0];
								
											 if($i==$_POST[cc])
									 			{
												 echo "SELECTED";
												 }
											  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
											}	 	
							?>
						   </select>
				 		</td>
					</tr> 
				  	<tr>
				     	<td class="saludo1" style="width:10%;">Tercero:</td>
			          	<td style="width:15%;" >
			          		<input id="tercero" type="text" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" style="width:74%;" value="<?php echo $_POST[tercero]?>" >
			          		<input type="hidden" value="0" name="bt">
			          		<a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900, height=500px'); mypop.focus();">
			          			<img src="imagenes/buscarep.png" align="absmiddle" border="0">
			          		</a>
			           	</td>
			          	<td colspan="6">
			          		<input  id="ntercero" style="width:100%;" name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>"  readonly>
			          	</td>
			        </tr>
			        <tr>
			        	<td class="saludo1">Detalle Orden de Pago:</td>
			        	<td colspan="8">
							<input type="text" id="detallegreso" name="detallegreso" style="width:100%;" value="<?php echo $_POST[detallegreso]?>" >
						</td>
					</tr>
				  	<tr>
				  		<td class="saludo1" >Valor a Pagar:</td>
				  		<td>
				  			<input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" readonly> 
				  			<input type="hidden" id="valorcheque" name="valorcheque" value="<?php echo $_POST[valorcheque]?>" readonly> 
				  			<input type="hidden" value="1" name="oculto">
							<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
							<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
							<input type="hidden" value="<?php echo $_POST[estado]; ?>" name="estado" id="estado">
				  			<input type="hidden" id="regimen" name="regimen" value="<?php echo $_POST[regimen]?>" >
				  		</td>
				  	</tr>
      			</table>
      		</td>
      		<td colspan="3" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>  
      	</tr>
    </table>
       <?php
           //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
<script>
			  document.getElementById('codingreso').focus();document.getElementById('codingreso').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				alert("Tercero Incorrecto o no Existe")				   		  	
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
			 //*** ingreso
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingresossf($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('valor').focus();document.getElementById('valor').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[codingreso]="";
			  ?>
			  <script>alert("Codigo Ingresos Incorrecto");document.form2.codingreso.focus();</script>
			  <?php
			  }
			 }
			 ?>
      
     <div class="subpantalla" style="height:45.5%; width:99.6%; overflow-x:hidden;">
	   <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
       <?php
	   if($_POST[todos]==1)
	    $checkt='checked';
		else
	    $checkt='';
	   ?>
		<tr>
			<td class="titulos2" style="width:10%;">Cuenta</td>
			<td class="titulos2">Nombre Cuenta</td>
			<td class="titulos2">Recurso</td>
			<td class="titulos2">Cod SSF</td>
			<td class="titulos2" style='width:10%;'>Valor</td>
			<td class="titulos2">
				<input type="checkbox" id="todos" name="todos" onClick="checktodos()" value="<?php echo $_POST[todos]?>" <?php echo $checkt ?>>
				<input type='hidden' name='elimina' id='elimina'  >
			</td>
		</tr>
<?php
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 {		
		 $chk=''; 
		$ch=esta_en_array($_POST[rubros],$_POST[dcuentas][$x]);
			if($ch=='1')
			 {
			 $chk="checked";
			 //echo "ch:$x".$chk;
			 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
			// $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
			 }
			
		 echo "<tr>
		 		<td class='saludo2'>
		 			<input name='rubros[]' value='".$_POST[rubros][$x]."' type='hidden' readonly>
		 			<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%;'  readonly>
		 		</td>
		 		<td class='saludo2'>
		 			<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' style='width:100%;'  readonly>
		 		</td>
		 		<td class='saludo2'>
		 			<input name='drecursos[]' value='".$_POST[drecursos][$x]."' type='hidden' >
		 			<input name='dnrecursos[]' value='".$_POST[dnrecursos][$x]."' type='text' style='width:100%;' readonly>
		 		</td>
		 		<td class='saludo2'>
		 			<input type='hidden' name='dcodssf[]' value='".$_POST[dcodssf][$x]."'>
		 			<input type='text' name='dcodssfnom[]' value='".$_POST[dcodssfnom][$x]."' style='width:100%;' readonly>
		 		</td>
		 		<td class='saludo2'>
		 			<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' style='width:100%;' onDblClick='llamarventanaegre(this,$x);' >
		 		</td>
		 		<td class='saludo2'>
		 		</td>
		 	</tr>";
		 }
		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." PESOS M/CTE";
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
	    echo "<tr>
	    		<td colspan='3'></td>
	    		<td class='saludo2'>Total</td>
	    		<td class='saludo2'>
	    			<input name='totalcf' type='text' value='$_POST[totalcf]' readonly>
	    			<input name='totalc' type='hidden' value='$_POST[totalc]'>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td  class='saludo1'>Son:</td> 
	    		<td colspan='4' class='saludo1'>
	    			<input name='letras' type='text' value='$_POST[letras]' style='width:100%;'>
	    		</td>
	    	</tr>";
		?>
        <script>
        document.form2.valor.value=<?php echo $_POST[totalc];?>;
        document.form2.valoregreso.value=<?php echo $_POST[totalc];?>;		
		//calcularpago();
        </script>
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$_POST[fecha];
	
	 $numerorecaudos=0;
	
	  if($numerorecaudos==0)
	   {
	   
//************CREACION DEL COMPROBANTE CONTABLE ************************
//***busca el consecutivo del comprobante contable
	$consec=$_POST[idcomp];
	$sql="DELETE FROM comprobante_cab WHERE numerotipo=$consec AND tipo_comp='21' ";
	mysql_query($sql,$linkbd);
	$sql="DELETE FROM comprobante_det WHERE id_comp='21 $consec'";
	mysql_query($sql,$linkbd);
	switch($_POST[estado]){
		case "S":
			$estado=1;
			break;
		case "R":
			$estado=0;
			break;
		case "N":
			$estado=0;
			break;
	}
	
//***cabecera comprobante SSF GASTO
	$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,21,'$fechaf','$_POST[detallegreso]',0,$_POST[totalc],$_POST[totalc],0,'$estado')";
	mysql_query($sqlr,$linkbd);
	$_POST[idcomp]=$idcomp;
	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	//******************* DETALLE DEL COMPROBANTE CONTABLE  *********************
	for ($y=0;$y<count($_POST[rubros]);$y++)
	{
		for($x=0;$x<count($_POST[dcuentas]);$x++)
		{
			if($_POST[dcuentas][$x]==$_POST[rubros][$y])  
			{
				//***BUSCAR CUENTA PPTAL ***************
				$sqlr="select * from tesoingresossf_det where cuentapresgas='".$_POST[dcuentas][$x]."' and vigencia=".$_POST[vigencia];
				$resp=mysql_query($sqlr,$linkbd);
				//******ACTUALIZACION DE CUENTA PPTAL CUENTAS X PAGAR ************			
				while($row=mysql_fetch_row($resp))
				{
					$codingressf=$row[2];
					//******** CONCEPTO DE GASTO SSF *****			
					$sq="select fechainicial from conceptoscontables_det where codigo='".$row[3]."' and modulo='4' and tipo='GS' and fechainicial<='$fechaf' and cuenta!='' order by fechainicial asc";
					$re=mysql_query($sq,$linkbd);
					while($ro=mysql_fetch_assoc($re))
					{
						$_POST[fechacausa]=$ro["fechainicial"];
					}
					$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$row[3]." and tipo='GS' and cc='$_POST[cc]' and fechainicial='".$_POST[fechacausa]."'";
					//echo $sqlrc;
					$resc=mysql_query($sqlrc,$linkbd);
					while($rowc=mysql_fetch_row($resc))
					{	//******buscar CONCEPTO CONTABLE DE PAGO          //**** CUENTA COntables*****				
						if ($rowc[3]=='N')
						{//****no es  NOMINA
							if($rowc[6]=='N' )
							{
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('21 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','GASTO SSF".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
								mysql_query($sqlr,$linkbd);
								$cuentagastocredito=$rowc[4];
							}
							if($rowc[7]=='N' )
						    {
								//	echo "<br>".$sqlr;
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('21 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','GASTO SSF".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
								mysql_query($sqlr,$linkbd);			
								//echo "<br>".$sqlr;
							}//echo "<br>Cuenta: $cuentagastocredito - ".$sqlr ;
						}
					}//****FIN CONCEPTO GASTO
					$sq="select fechainicial from conceptoscontables_det where codigo='".$codingressf."' and modulo='4' and tipo='IS' and cc='$_POST[cc]' and fechainicial<='$fechaf' and cuenta!='' order by fechainicial asc";
					$re=mysql_query($sq,$linkbd);
					while($ro=mysql_fetch_assoc($re))
					{
						$_POST[fechacausa]=$ro["fechainicial"];
					}
					$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$codingressf." and tipo='IS' and cc='$_POST[cc]' and fechainicial='".$_POST[fechacausa]."'";
					$resc=mysql_query($sqlrc,$linkbd);   
					while($rowc=mysql_fetch_row($resc))
					{	
						if ($rowc[3]=='N')
						{
							//****no es  NOMINA
							$ncuent=buscacuenta($rowc[4]);	
							/*if($rowc[6]=='N')
						    {
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('21 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','EGRESO SSF ".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
								mysql_query($sqlr,$linkbd);
							}*/
							//$ncuent=buscacuenta($rowc[4]);	
							if($rowc[6]=='S' )
						    {
								//	echo "<br>".$sqlr;
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('21 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','GASTO SSF ".$_POST[dncuentas][$x]."','','0',".$_POST[dvalores][$x].",'1','".$vigusu."')";
								mysql_query($sqlr,$linkbd);
							}	
						}
					} //***** FIN CONCEPTO INGRESO
					
					$sq="select fechainicial from conceptoscontables_det where codigo='".$row[3]."' and modulo='4' and tipo='GS' and fechainicial<='$fechaf' and cuenta!='' order by fechainicial asc";
					$re=mysql_query($sq,$linkbd);
					while($ro=mysql_fetch_assoc($re))
					{
						$_POST[fechacausa]=$ro["fechainicial"];
					}
					$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$row[3]." and tipo='GS' and cc='$_POST[cc]' and fechainicial='".$_POST[fechacausa]."'";
					//echo $sqlrc;
					$resc=mysql_query($sqlrc,$linkbd);
					while($rowc=mysql_fetch_row($resc))
					{	//******buscar CONCEPTO CONTABLE DE PAGO          //**** CUENTA COntables*****				
						if ($rowc[3]=='N')
						{//****no es  NOMINA
							/*if($rowc[6]=='N' )
							{
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('21 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','GASTO SSF".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
								mysql_query($sqlr,$linkbd);
								$cuentagastocredito=$rowc[4];
							}*/
							if($rowc[7]=='S' )
						    {
								//	echo "<br>".$sqlr;
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('21 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','GASTO SSF".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
								mysql_query($sqlr,$linkbd);			
								//echo "<br>".$sqlr;
							}//echo "<br>Cuenta: $cuentagastocredito - ".$sqlr ;
						}
					}//****FIN CONCEPTO GASTO
				}
				echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Orden de Pago con Exito <img  src='imagenes\confirm.png'></center></td></tr></table>";
				?>
				<script>
					document.form2.numero.value="";
					document.form2.valor.value=0;
					document.form2.oculto.value=1;
				</script>
				<?php
			}
		}
	}
}
   
  
  //****fin if bloqueo  
}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>
</table>
</body>
</html>