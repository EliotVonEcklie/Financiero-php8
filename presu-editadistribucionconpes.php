<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
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
function buscactap(e)
 {
if (document.form2.cuentap.value!="")
{
 document.form2.bcp.value='1';
 document.form2.submit();
 }
 }
function validar()
{
document.form2.submit();
}
function agregardetalle()
{
if(document.form2.ingreso.value!="" &&  parseFloat(document.form2.valor.value)>0)
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
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
if (document.form2.codigo.value!='' && document.form2.concepto.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
 else{
  alert('Faltan datos para completar el registro');
  	document.form2.codigo.focus();
  	document.form2.codigo.select();
  }
 }
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
 function adelante()
{
	if(parseFloat(document.form2.codigo.value)<parseFloat(document.form2.maximo.value))
	 {
		document.form2.oculto.value='';
		document.form2.codigo.value=parseFloat(document.form2.codigo.value)+1;
		document.form2.action="presu-editadistribucionconpes.php";
		document.form2.submit();
	}
}
function atrasc()
{
	if(document.form2.codigo.value>1)
	 {

		document.form2.oculto.value='';
		document.form2.codigo.value=document.form2.codigo.value-1;
		document.form2.action="presu-editadistribucionconpes.php";
		document.form2.submit();
	 }
}
</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><a href="presu-distribucionconpes.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="presu-buscadistribucionconpes.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><img src="imagenes/iratras.png" title="Atr&aacute;s"  onClick="location.href='presu-buscadistribucionconpes.php'" class="mgbt"></td>
        </tr>		  
        </table>
<?php
$linkbd=conectar_bd();
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
 ?>	
<?php
if($_GET[is]!='')
{
	$_POST[codigo]=$_GET[is];
}
//echo "<br>  Oc:".$_POST[oculto];
if(!$_POST[oculto])
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[tipo]='S';
		 $_POST[deuda]=0;
		 $_POST[cuotas]=0;
		 $_POST[vcuotas]=0;		 		  			 
		 $_POST[valor]=0;	
		  $sqlr="select  * from presuconpes  where id_conpes=$_POST[codigo]";
		 //echo $sqlr;
		  $res=mysql_query($sqlr,$linkbd);
		  $row=mysql_fetch_row($res);
		  $_POST[codigo]=$row[0];
		  $_POST[concepto]=$row[1];		  
		  ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $row[2],$fecha);
   		  $fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		  $_POST[fecha]=$fechaf;
		  
		 $_POST[dmovs]= array(); 		 
		 $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 
		 $_POST[dterceros]= array(); 
		 $_POST[dnterceros]= array(); 
		 $_POST[dvalores]= array(); 
		 $_POST[dccs]= array(); 
		  $sqlr="select  * from presuconpes_det  where id_conpes=$_POST[codigo]  order by codigo";
		 //echo $sqlr;
		  $res=mysql_query($sqlr,$linkbd);
		  while($row=mysql_fetch_row($res))
		   {
		 $_POST[dmovs][]=$row[2];
		 $_POST[dcoding][]=$row[5];		 
		 $_POST[dncoding][]=buscaingreso($row[5]);	
		 $_POST[dterceros][]=$row[4];			 
		 $_POST[dnterceros][]=buscatercero($row[4]);			 		 
//		 $_POST[valor]=str_replace(".","",$_POST[valor]);		 		
		  $_POST[dvalores][]=$row[6];
		  $_POST[dccs][]=$row[3];		  			   
			}
		$sqlr="select id_conpes from presuconpes order by id_conpes desc";
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		$r=mysql_fetch_row($res);
		$_POST[maximo]=$r[0];
}
?>
 <form name="form2" method="post" action="">
<?php  //***** busca tercero
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
			 ?>
 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="8">.: Agregar Conpes</td><td class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td  class="saludo1">Codigo:        </td>
	  <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"/>
        <td ><img src="imagenes/back.png" title="Anterior" onClick="atrasc()" class="icobut"><input name="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly><img src="imagenes/next.png" title="Siguiente" onClick="adelante()" class="icobut"/></td>
        <td class="saludo1">Fecha:</td><td ><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          </td>
        <td  class="saludo1">Detalle:        </td>
        <td ><input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" size="80" onKeyUp="return tabular(event,this)"><input name="oculto" type="hidden" value="1"></td>
       </tr> 
      </table>
	   <?php
	   $linkbd=conectar_bd();
	   ?>
	    <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Conpes</td></tr>                  
	  		  <tr><td class="saludo1">Tipo Mov:</td><td><select name="tipog">
		   <option value="A" <?php if($_POST[tipog]=='A') echo "SELECTED"; ?>>Aumenta</option>
          <option value="D" <?php if($_POST[tipog]=='D') echo "SELECTED"; ?>>Disminuye</option>
		  </select></td>              
              <td  class="saludo1">Tercero:          </td>
          <td  ><input id="tercero" type="text" name="tercero" size="12" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();"><input type="hidden" value="0" name="bt">
            <a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
          <td colspan="2"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="100" readonly></td></tr>
          <tr>
	  <td   class="saludo1">Ingreso:</td>
	  <td colspan="1"><select name="ingreso" id="ingreso" >
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from tesoingresos  where estado='S' and terceros='sgp' order by codigo";
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[ingreso])
			 	{
				 echo "SELECTED";
				 $_POST[ingresonom]=$row[0]." - ".$row[3]." - ".$row[1];
				 }
				echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
			     }   
				?>
		  </select><input id="ingresonom" name="ingresonom" type="hidden" value="<?php echo $_POST[ingresonom]?>" ></td>
          <td class="saludo1">Centro Costo:</td><td colspan="1">
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
          
          <td class="saludo1">Valor :</td><td ><input type="text" name="valor" value="<?php echo $_POST[valor]?>" size="12" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"><input  type="button" name="agregact" value="Agregar" onClick="agregardetalle()"><input type="hidden" value="0" name="agregadet"></td>
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
			  document.getElementById('retencion').focus();document.getElementById('retencion').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				alert("Tercero Incorrecto o no Existe");				  
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
		?>
<div class="subpantallac7" style="height:52.5%; width:99.6%; overflow-x:hidden;">
	   <table class="inicio">
	   	   <tr><td colspan="6" class="titulos">Detalle Conpes</td></tr>                  
		<tr><td class="titulos2">Tipo Mov</td><td class="titulos2">Ingreso</td><td class="titulos2">Tercero</td><td class="titulos2">CC</td><td class="titulos2">Valor</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
 		 unset($_POST[dmovs][$posi]);			  
 		 unset($_POST[dcoding][$posi]);	
 		 unset($_POST[dncoding][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  		 
		 unset($_POST[dterceros][$posi]);			  		 		 
		 unset($_POST[dnterceros][$posi]);			  		 		 		 
		 unset($_POST[dccs][$posi]);			  		 		 		 		 
		 $_POST[dmovs]= array_values($_POST[dmovs]); 		 
		 $_POST[dcoding]= array_values($_POST[dcoding]); 		 		 
		 $_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 $_POST[dterceros]= array_values($_POST[dterceros]); 
		 $_POST[dnterceros]= array_values($_POST[dnterceros]); 		 		 		 		 		 		 		 
		 $_POST[dccs]= array_values($_POST[dccs]); 		 		 		 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dmovs][]=$_POST[tipog];
		 $_POST[dcoding][]=$_POST[ingreso];		 
		 $_POST[dncoding][]=$_POST[ingresonom];	
		 $_POST[dterceros][]=$_POST[tercero];			 
		 $_POST[dnterceros][]=buscatercero($_POST[tercero]);			 		 
		 $_POST[valor]=str_replace(",",".",$_POST[valor]);		 		
		  $_POST[dvalores][]=$_POST[valor];
		  $_POST[dccs][]=$_POST[cc];		  
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.codingreso.value="";
				document.form2.tercero.value="";
				document.form2.valor.value="0";	
				document.form2.ningreso.value="";				
				document.form2.codingreso.select();
		  		document.form2.codingreso.focus();	
		 </script>         
		  <?php
		  }
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcoding]);$x++)
		 {		 
		 echo "<tr><td class='saludo1'><input name='dmovs[]' value='".$_POST[dmovs][$x]."' type='text' size='4' readonly></td><td class='saludo1'><input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' size='4' readonly><input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' size='90' readonly></td><td class='saludo1'><input name='dterceros[]' value='".$_POST[dterceros][$x]."' type='text' size='10' readonly><input name='dnterceros[]' value='".$_POST[dnterceros][$x]."' type='text' size='30' readonly></td><td class='saludo1'><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='4' readonly></td><td class='saludo1'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15' readonly></td><td class='saludo1'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2);
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr><td></td><td></td><td></td><td class='saludo2'>Total</td><td class='saludo1'><input name='totalcf' type='text' value='$_POST[totalcf]' readonly ><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td class='saludo1'>Son:</td><td colspan='5' ><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?> 
	   </table>       
       </div>
  <?php
$oculto=$_POST[oculto];
if($_POST[oculto]=='2')
{

	$linkbd=conectar_bd();
	$p1=substr($_POST[fecha],0,2);
	$p2=substr($_POST[fecha],3,2);
	$p3=substr($_POST[fecha],6,4);
	$fechaf=$p3."-".$p2."-".$p1;	
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	if($bloq>=1)
	{
 	ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	 $sqlr="delete from comprobante_cab where tipo_comp=24 and numerotipo=$_POST[codigo] ";
	 mysql_query($sqlr,$linkbd);
	  $sqlr="delete from presuconpes where codigo=$_POST[codigo] ";
	 mysql_query($sqlr,$linkbd);
	$consec=0;
	$sqlr="insert into presuconpes (codigo,nombre_conpes,fecha,tipo_conpes,vigencia,estado) values($_POST[concepto],'".$_POST[concepto]."','$fechaf','',".$vigusu.",'S')";	  
	mysql_query($sqlr,$linkbd);
//	$idconsig=mysql_insert_id();
$idconsig=$_POST[codigo];
	 $consec=$idconsig;
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************	
//***busca el consecutivo del comprobante contable
//***cabecera comprobante
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,24,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);
	$idcomp=mysql_insert_id();
	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
		 $sqlr="delete from comprobante_det where id_comp='24 $_POST[codigo]'";
	 mysql_query($sqlr,$linkbd);
	  $sqlr="delete from presuconpes_det where id_conpes=$_POST[codigo] ";
	 mysql_query($sqlr,$linkbd);
//	echo $sqlr;
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	{
		//***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
		$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		{
			//**** busqueda concepto contable*****
			$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
			$re=mysql_query($sq,$linkbd);
			while($ro=mysql_fetch_assoc($re))
			{
				$_POST[fechacausa]=$ro["fechainicial"];
			}
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
			$resc=mysql_query($sqlrc,$linkbd);	  
			//	echo "con: $sqlrc <br>";	      
			while($rowc=mysql_fetch_row($resc))
			{
				if($_POST[dmovs][$x]=='A')
		  		{
					$porce=$rowi[5];
					if($rowc[6]=='S')
					{				 
						$valordeb=$_POST[dvalores][$x]*($porce/100);
						$valorcred=0;
					}
					else
					{
						$valorcred=$_POST[dvalores][$x]*($porce/100);
						$valordeb=0;				   
					}
					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('24 $consec','".$rowc[4]."','".$_POST[dterceros][$x]."','".$_POST[dccs][$x]."','CONPES ".$_POST[dncoding][$x]."','',".str_replace(",",".",$valordeb).",".str_replace(",",".",$valorcred).",'1','".$vigusu."')";
					mysql_query($sqlr,$linkbd);
					//echo "Conc: $sqlr <br>";
				}
				if($_POST[dmovs][$x]=='D')
		  		{
					$porce=$rowi[5];
					if($rowc[7]=='S')
					{
						$valordeb=$_POST[dvalores][$x]*($porce/100);
						$valorcred=0;
					}
					else
					{
						$valorcred=$_POST[dvalores][$x]*($porce/100);
						$valordeb=0;				   
					}
					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('24 $consec','".$rowc[4]."','".$_POST[dterceros][$x]."','".$_POST[dccs][$x]."','CONPES ".$_POST[dncoding][$x]."','',".str_replace(",",".",$valordeb).",".str_replace(",",".",$valorcred).",'1','".$vigusu."')";
					mysql_query($sqlr,$linkbd);
					//echo "Conc: $sqlr <br>";
				}
			}
		}
	}
	/*for($x=0;$x<count($_POST[dcoding]);$x++)
	 {	 
	$cod=$_POST[dcoding][$x];
	$sql="select concepto from presuingresoconpes_det where codigo='$cod' and vigencia='$vigusu' ";
	$result=mysql_query($sql,$linkbd);
	$row=mysql_fetch_row($result);
	//******Busca el concepto contable de los gastos bancarios
	$sq="select fechainicial from conceptoscontables_det where codigo=".$row[0]." and modulo='3' and tipo='CP' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
	$re=mysql_query($sq,$linkbd);
	while($ro=mysql_fetch_assoc($re))
	{
		$_POST[fechacausa]=$ro["fechainicial"];
	}
	$sqlr="select * from conceptoscontables_det where conceptoscontables_det.codigo=".$row[0]." and conceptoscontables_det.tipo='CP' and conceptoscontables_det.modulo='3' and conceptoscontables_det.cc='".$_POST[dccs][$x]."' and conceptoscontables_det.estado='S' and conceptoscontables_det.tipocuenta='N' and conceptoscontables_det.fechainicial='".$_POST[fechacausa]."'";
	$res2=mysql_query($sqlr,$linkbd);
	while($r2=mysql_fetch_row($res2))
	 {
		 //*****SI ES DE GASTO *****
		 if($_POST[dmovs][$x]=='A')
		  {
		  //**** NOTA  BANCARIA DETALLE CONTABLE*****
		  if($r2[6]=='S')  //debito
		   {
			$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('24 $consec','".$r2[4]."','".$_POST[dterceros][$x]."','".$_POST[dccs][$x]."','CONPES ".$_POST[dncoding][$x]."','',".str_replace(",",".",$_POST[dvalores][$x]).",0,'1','".$vigusu."')";
		 	
			mysql_query($sqlr2,$linkbd);  
			$sqlr="";
		   }
		  if($r2[7]=='S') //credito
		  {
			//*** Cuenta credito **
			$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('24 $consec','".$r2[4]."','".$_POST[dterceros][$x]."','".$_POST[dccs][$x]."','CONPES ".$_POST[dncoding][$x]."','',0,".str_replace(",",".",$_POST[dvalores][$x]).",'1','".$vigusu."')";
			mysql_query($sqlr2,$linkbd);
			//echo "$sqlr2 <br>";			  
		  }
		}//*****FIN GASTO
	//*****SI ES DE INGRESO *****
		 if($_POST[dmovs][$x]=='D')
		  {
		  //**** NOTA  BANCARIA DETALLE CONTABLE*****
		  if($r2[7]=='S')  //debito
		   {
			$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('24 $consec','".$r2[4]."','".$_POST[dterceros][$x]."','".$_POST[dccs][$x]."','CONPES ".$_POST[dncoding][$x]."','',".str_replace(",",".",$_POST[dvalores][$x]).",0,'1','".$vigusu."')";
			//echo "$sqlr2 <br>";
			mysql_query($sqlr2,$linkbd);  
			$sqlr="";
		   }
		  if($r2[6]=='S') //credito
		  {
			//*** Cuenta credito **
			$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('24 $consec','".$r2[4]."','".$_POST[dterceros][$x]."','".$_POST[dccs][$x]."','CONPES ".$_POST[dncoding][$x]."','',0,".str_replace(",",".",$_POST[dvalores][$x]).",'1','".$vigusu."')";
			mysql_query($sqlr2,$linkbd);
		//	echo "$sqlr2 <br>";			  
		  }
		}//*****FIN INGRESO	
	 }
	
	 }*/
	//************ insercion de cabecera consignaciones ************
	//************** insercion de consignaciones **************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
	$sqlr="insert into presuconpes_det(id_conpes,tipomov,cc,tercero,codigo,valor) values($idconsig,'".$_POST[dmovs][$x]."','".$_POST[dccs][$x]."','".$_POST[dterceros][$x]."','".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].")";	  
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
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
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado El Documento Conpes Cod $idconsig con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
		  ?>		  
		  <?php
		  }
	}	  
 } 
}
?>	
    </form>
</body>
</html>