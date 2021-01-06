<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Presupuesto</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script>
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
</script>
<script>
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function agregardetalle()
{
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
</script>
<script>
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
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.fecha.value!='' && ((document.form2.modorec.value=='banco' && document.form2.banco.value!='') || (document.form2.modorec.value=='caja')))
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
</script>
<script>
function pdf()
{
document.form2.action="teso-pdfrecaja.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script language="JavaScript1.2">
function adelante()
{
   //alert("adelante"+document.form2.ncomp.value);
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="presu-sinrecibocaja-reflejar.php";
document.form2.submit();
}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{
	   //alert("atras"+document.form2.ncomp.value);
//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.idcomp.value=document.form2.idcomp.value-1;
document.form2.action="presu-sinrecibocaja-reflejar.php";
document.form2.submit();
 }
}
</script>
<script language="JavaScript1.2">
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.idcomp.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="presu-sinrecibocaja-reflejar.php";
document.form2.submit();
}
</script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("presu");?></tr>
<tr>
  <td colspan="3" class="cinta">
  <a class="mgbt" href="#" ><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a> 
  <a class="mgbt" href="#" onClick="#"><img src="imagenes/guardad.png"  alt="Guardar" /></a> 
  <a class="mgbt" href="presu-buscasinrecibocaja-reflejar.php"> <img src="imagenes/busca.png"  alt="Buscar" /></a> 
  <a class="mgbt" href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> 
  <a class="mgbt" href="#" onClick="guardar()"><img src="imagenes/reflejar1.png"  alt="Reflejar" style="width:24px;" /></a> 
  <a class="mgbt" href="#"onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a> 
  <a class="mgbt" href="presu-reflejardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
	<form name="form2" method="post" action=""> 
		<?php
		$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$vigencia=$vigusu;
		$linkbd=conectar_bd();
		$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
		$res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)){
	 		$_POST[cuentacaja]=$row[0];
		}
 		?>	
		<?php
	  	//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
		if ($_GET[idrecibo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idrecibo];</script>";}
		$sqlr="select id_recibos,id_recaudo from  tesosinreciboscaja ORDER BY id_recibos DESC";
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
	 	$_POST[maximo]=$r[0];
		if(!$_POST[oculto]){
			$check1="checked";
			$fec=date("d/m/Y");
			$_POST[vigencia]=$vigencia;
			if ($_POST[codrec]!="" || $_GET[idrecibo]!=""){
				if($_POST[codrec]!=""){
					$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja where id_recibos='$_POST[codrec]'";
				}
				else{
					$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja where id_recibos='$_GET[idrecibo]'";
				}
			}
			else{
				$sqlr="select id_recibos,id_recaudo from  tesosinreciboscaja ORDER BY id_recibos DESC";
			}
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
//	 		$_POST[maximo]=$r[0];
		 	$_POST[ncomp]=$r[0];
			$_POST[idcomp]=$r[0];
			$_POST[idrecaudo]=$r[1];	 
	 		if($_GET[idrecibo]!=""){
	 	 		$_POST[idcomp]=$_GET[idrecibo];
		  		$_POST[ncomp]=$_GET[idrecibo];
			}
		}
 		$sqlr="select * from tesosinreciboscaja where id_recibos=$_POST[idcomp]";
 		$res=mysql_query($sqlr,$linkbd);
		while($r=mysql_fetch_row($res)){		  
			$_POST[tiporec]=$r[10];
		  	$_POST[idrecaudo]=$r[4];
		  	$_POST[ncomp]=$r[0];
		  	$_POST[modorec]=$r[5];	
		}
		switch($_POST[tabgroup1]){
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
	<input name="cobrorecibo" type="hidden" value="<?php echo $_POST[cobrorecibo]?>" >
 	<input name="vcobrorecibo" type="hidden" value="<?php echo $_POST[vcobrorecibo]?>" >
 	<input name="tcobrorecibo" type="hidden" value="<?php echo $_POST[tcobrorecibo]?>" > 
 	<input name="encontro" type="hidden" value="<?php echo $_POST[encontro]?>" >
  	<input name="codcatastral" type="hidden" value="<?php echo $_POST[codcatastral]?>" >
 	<?php 
//	echo $_POST[tiporec];
	switch($_POST[tiporec]){	  
		case 3:
	  		$sqlr="select *from tesosinrecaudos where tesosinrecaudos.id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
  		//echo "$sqlr";
  	  $_POST[encontro]="";
	  $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
	 	{
	  	$_POST[concepto]=$row[6];	
	  	$_POST[valorecaudo]=$row[5];		
	  	$_POST[totalc]=$row[5];	
	  	$_POST[tercero]=$row[4];	
	  	$_POST[ntercero]=buscatercero($row[4]);			
	  	$_POST[encontro]=1;
	 	}
		$sqlr="select *from tesosinreciboscaja where  id_recibos=$_POST[idcomp] ";
		$res=mysql_query($sqlr,$linkbd);
		$row =mysql_fetch_row($res); 
		//echo "$sqlr";
		//$_POST[idcomp]=$row[0];
		$_POST[fecha]=$row[2];
		$_POST[estadoc]=$row[9];
		   if ($row[9]=='N')
		   {$_POST[estado]="ANULADO";
		   $_POST[estadoc]='0';
		   }
		   else
		   {
			   $_POST[estadoc]='1';
			   $_POST[estado]="ACTIVO";
		   }

				$_POST[modorec]=$row[5];
					$_POST[banco]=$row[7];
        ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   $_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	   //echo "mre:".$_POST[modorec];
		break;	
	}

 ?>
	<table class="inicio">
    	<tr >
        	<td class="titulos" colspan="6">Interfaz  Ingresos Internos ppto
            	<input name="codrec" id="codrec" type="text" value="<?php echo $_POST[codrec]?>" >
            </td>
        	<td style="width:7%;" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
        	<td class="saludo1" style="width:2.5cm;">No Recibo:</td>
        	<td style="width:10%;"> 
            	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                <input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>" >
                <input name="idcomp" type="text"  style="width:50%;" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  >
                <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
                <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
                <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" >
                <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
       		</td>
	  		<td class="saludo1" style="width:2.5cm;">Fecha:</td>
        	<td  style="width:10%;">
            	<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" style="width:100%;" onKeyUp="return tabular(event,this)" readonly>        
            </td>
         	<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
		  	<td style="width:38%;">
            	<input type="text" id="vigencia" name="vigencia" size="8" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>   
                <input type="text" name="estado" value="<?php echo $_POST[estado] ?>" readonly>  
                <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>" readonly>      
          	</td>
            <td></td>
        </tr>
      	<tr>
        	<td class="saludo1" style="width:2.5cm;"> Recaudo:</td>
            <td style="width:10%;"> 
            	<select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" >
                   	<?php
					switch($_POST[tiporec]){
						case "1":	echo"<option value='1' SELECTED>Predial</option>";break;
						case "2":	echo"<option value='2' SELECTED>Industria y Comercio</option>";break;
						case "3":	echo"<option value='3' SELECTED>Otros Recaudos</option>";break;
					}
					?>
        		</select>
          	</td>
        	<td class="saludo1">No Liquid:</td>
            <td>
            	<input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" size="30" onKeyUp="return tabular(event,this)" onChange="validar()" readonly> 
           	</td>
	 		<td class="saludo1">Recaudado en:</td>
            <td style="width:38%;"> 
            	<select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:16%;" >
                   	<?php
					if($_POST[modorec]=='banco'){
						echo"<option value='banco' SELECTED>Banco</option>";
					}
					else{
						echo"<option value='caja' SELECTED>Caja</option>";
					}
					?>
        		</select>
        		<?php
		  		if ($_POST[modorec]=='banco'){
				?>
         			<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:83%;">
		  				<?php
						$linkbd=conectar_bd();
						$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)){
							echo "<option value=$row[1] ";
					 		if($row[1]==$_POST[banco]){
				 				echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3] - $row[4]</option>";
				 				$_POST[nbanco]=$row[4];
				 	 			$_POST[ter]=$row[5];
								$_POST[cb]=$row[2];
						 	}
						}	 	
						?>
            		</select>
       				<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                    <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >           
                	<input type="hidden" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="40" readonly>
          		</td>
        	<?php
		   	}
			?> 
       	</tr>
	  	<tr>
        	<td class="saludo1" style="width:2.5cm;">Concepto:</td>
            <td colspan="5">
            	<input name="concepto" style="width:100%;" type="text" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)" readonly>
           	</td>
       	</tr>
      	<tr>
        	<td class="saludo1" style="width:2.5cm;">Valor:</td>
            <td>
            	<input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo number_format($_POST[valorecaudo],2,',','.')?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)" readonly >
           	</td>
            <td class="saludo1">Documento: </td>
        	<td>
            	<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:100%;" onKeyUp="return tabular(event,this)" readonly>
         	</td>
			<td class="saludo1">Contribuyente:</td>
	  		<td>
            	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%;" onKeyUp="return tabular(event,this)" readonly>
                <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  		</td>
       	</tr>
   	</table>
	<input type="hidden" value="1" name="oculto">
  	<input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
    <input type="hidden" value="0" name="agregadet">
    <div class="subpantallac7">
		<?php  //echo $_POST[oculto]." - ".$_POST[encontro];
//		echo $_POST[tiporec];
 		if($_POST[encontro]=='1'){
  			switch($_POST[tiporec]){	 	 
	  			case 3: ///*****************otros recaudos *******************
	  		 		$_POST[trec]='OTROS RECAUDOS';	 
  					$sqlr="select *from tesosinrecaudos_det where tesosinrecaudos_det.id_recaudo=$_POST[idrecaudo]  and 3=$_POST[tiporec]";
 //echo $sqlr;
		 			$_POST[dcoding]= array(); 		 
		 			$_POST[dncoding]= array(); 		 
		 			$_POST[dvalores]= array(); 	
  					$res=mysql_query($sqlr,$linkbd);
					while($row =mysql_fetch_row($res)){	
						$_POST[dcoding][]=$row[2];
						$sqlr2="select nombre from tesoingresos where codigo='".$row[2]."'";
						$res2=mysql_query($sqlr2,$linkbd);
						$row2 =mysql_fetch_row($res2); 
						$_POST[dncoding][]=$row2[0];			 		
    					$_POST[dvalores][]=$row[3];		 	
					}
				break;
   			}
 		}
 		?>
		<table class="inicio">
        	<tr>
	   	    	<td colspan="4" class="titulos">Detalle Ingresos Internos</td>
           	</tr>                  
			<tr>
            	<td class="titulos2">Codigo</td>
                <td class="titulos2">Ingreso</td>
                <td class="titulos2">Valor</td>
          	</tr>
			<?php 		
	 		$_POST[totalc]=0;
			$iter='saludo1a';
			$iter2='saludo2';
		 	for ($x=0;$x<count($_POST[dcoding]);$x++){		 
				echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
					<td style='width:10%'>
						<input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='hidden'>".$_POST[dcoding][$x]."
					</td>
					<td>
						<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='hidden'>".$_POST[dncoding][$x]."
					</td>
					<td style='width:20%' align='right'>
						<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden'>$ ".number_format($_POST[dvalores][$x],2,',','.')."
					</td>
				</tr>";
		 		$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 		$_POST[totalcf]=number_format($_POST[totalc],2);
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
		 	}
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." PESOS M/CTE";
			echo "<tr class='$iter'>
				<td></td>
				<td align='right'>Total</td>
				<td align='right'>
					<input name='totalcf' type='hidden' value='$_POST[totalcf]'>
					<input name='totalc' type='hidden' value='$_POST[totalc]'>
					$ ".number_format($_POST[totalc],2,',','.')."
				</td>
			</tr>
			<tr class='titulos2'>
				<td>Son:</td>
				<td colspan='5'>
					<input name='letras' type='hidden' value='$_POST[letras]' size='90'>
					".$_POST[letras]."
				</td>
			</tr>";
			?> 
	   	</table>
   	</div>
	<?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	if($bloq>=1)
	{						
	//************VALIDAR SI YA FUE GUARDADO ************************
	switch($_POST[tiporec]) 
  	 {	  
	  case 3: //**************OTROS RECAUDOS
	
    $sqlr="delete from pptocomprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='18'";
	  mysql_query($sqlr,$linkbd);
	    $sqlr="delete from pptocomprobante_det where  numerotipo=$_POST[idcomp] and tipo_comp='18'";
		//echo $sqlr;
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from pptosinrecibocajappto where idrecibo=$_POST[idcomp]";
		//echo $sqlr;		
		mysql_query($sqlr,$linkbd);
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$consec=$_POST[idcomp];
//***cabecera comprobante
	  $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($consec,18,'$fechaf','INGRESOS PROPIOS',$_POST[vigencia],0,0,0,'$_POST[estadoc]')";
	 	  mysql_query($sqlr,$linkbd);
	$idcomp=$consec;
	 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Ingreso Propio con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>";
//	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
		
		  $sqlr="delete from pptosinrecibocajappto where idrecibo=$consec ";
			 mysql_query($sqlr,$linkbd);	
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
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
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			//mysql_query($sqlr,$linkbd);	
			//****creacion documento presupuesto ingresos		
	  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$consec,$vi,'".$vigusu."')";
	  mysql_query($sqlr,$linkbd);	
	  $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$rowi[6]."','".$_POST[tercero]."','INGRESO PROPIO',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',18,'$consec',1,'','','$fechaf')";
	  mysql_query($sqlr,$linkbd); 		
			//echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
			}
		 }
	}		
	   break;
	   //********************* INDUSTRIA Y COMERCIO
	} //*****fin del switch
	}//***bloqueo
		else
	   {
    	echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
	   }

   }//**fin del oculto 
?>	
</form>
 </td></tr>
</table>
</body>
</html>