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
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
       
<script>
function pdf()
{
document.form2.action="pdfcmov.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}

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

function agregardetalle()
{
valordeb=quitarpuntos(document.form2.vlrdeb.value)	
valorcred=quitarpuntos(document.form2.vlrcre.value)
//alert('valor'+valordeb);
if(document.form2.cuenta.value!="" && document.form2.tercero.value!=""  && (valordeb>0 || valorcred>0))
 {
document.form2.agregadet.value=1;
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

function adelante()
{
//   alert("Balance Descuadrado");
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.fecha.value='';
document.form2.oculto.value=2;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.action="presu-buscacomprobantes.php";
document.form2.submit();
}
}

function atrasc()
{
   
//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {
document.form2.fecha.value='';
document.form2.oculto.value=2;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.action="presu-comprobantes.php";
//alert("Balance Descuadrado");
document.form2.submit();
 }
}

function validar()
{
//   alert("Balance Descuadrado");
//document.form2.oculto.value=2;
document.form2.oculto.value=1;
document.form2.action="presu-comprobantes.php";
document.form2.submit();
}

function validar3()
{
//   alert("Balance Descuadrado");
//document.form2.oculto.value=2;
//document.form2.oculto.value=2;
//document.form2.action="cont-buscacomprobantes.php";
document.form2.submit();
}

function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=2;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="presu-comprobantes.php";
document.form2.submit();
}

function guardar()
{
//   alert("Balance Descuadrado");
if ( document.form2.fecha.value!='')
 {
	if (confirm("Esta Seguro de Guardar"))
  {
document.form2.oculto.value=3;
document.form2.action="presu-comprobantes.php";
document.form2.submit();
  }
 }
 else 
  {
   alert("Comprobante descuadrado o faltan informacion: "+valor);
  }
}

function duplicarcomp()
{
//   alert("Balance Descuadrado");
valor=parseFloat(document.form2.diferencia.value);
if (valor==0 && document.form2.fecha.value!='')
 {
	if (confirm("Esta Seguro de Duplicar el Comprobante"))
  {
document.form2.oculto.value=4;
document.form2.duplicar.value=2;
document.form2.action="presu-comprobantes.php";
document.form2.submit();
  }
 }
 else 
  {
   alert("Comprobante descuadrado o faltan informacion: "+valor);
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

function buscacc(e)
 {
if (document.form2.cc.value!="")
{
 document.form2.bcc.value='1';
 document.form2.submit();
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

function excell()
{
document.form2.action="presu-buscacomprobantesexcel.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
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
       			<td colspan="3" class="cinta"><a href="presu-comprobantes.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="presu-buscacomprobantes.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="duplicarcomp()" class="mgbt"><img src="imagenes/duplicar.png" title="Duplicar"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"title="imprimir"></a><a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a></td>
			</tr> 
		</table>
<?php 
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 $_POST[vigencia]=$vigusu;
 $_POST[estadoc]="ACTIVO";
 $_POST[estado]="1";
//echo "entro  dupli".$_POST[oculto];
if($_POST[oculto]!='')
{	
$link=conectar_bd();
$sqlr="select fijo from pptotipo_comprobante where codigo='$_POST[tipocomprobantep]'";
$res2=mysql_query($sqlr,$link);
$rt=mysql_fetch_row($res2);
if($rt[0]=='N')
 {
$sqlr="select max(numerotipo) from pptocomprobante_cab where tipo_comp=$_POST[tipocomprobantep] ";
$res=mysql_query($sqlr,$link);
//echo $sqlr;
	while($r=mysql_fetch_row($res))
	{
	 $maximo=$r[0];
	}
if(!$maximo)
  {
  $_POST[ncomp]=1;
  }else{
  $_POST[ncomp]=$maximo+1;
  }
 }
 else
  {	  
    echo "<script>alert('Para este Tipo de Comprobantes no se pueden crear manualmente los comprobantes')</script>";
	$_POST[tipocomprobante]='-1';
	$_POST[ncomp]="";
  }
 }
?>
  <form name="form2" method="post" action="">
<?php
			//**** busca cuenta
  			if($_POST[bc]=='1')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],1);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
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
			 
			 //**** busca centro costo
  			if($_POST[bcc]=='1')
			 {
			  $nresul=buscacentro($_POST[cc]);
			  if($nresul!='')
			   {
			  $_POST[ncc]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncc]="";
			  }
			 }
			 ?>

  <table class="inicio" width="99%">
        <tr>
          <td class="titulos" colspan="9">Comprobantes          </td>
          <td width="287" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
        </tr>
        <tr>
		   <td width="170" class="saludo1" >Tipo Comprobante:          </td>
          <td width="376"  ><select name="tipocomprobantep" onKeyUp='return tabular(event,this)' onChange="validar()">
		  <option value="-1">Seleccion Tipo Comprobante</option>	  
		   <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from pptotipo_comprobante  where estado='S' order by nombre";
			// echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[3];
				echo "<option value=$row[3] ";
				if($i==$_POST[tipocomprobantep])
			 	{
				 $_POST[ntipocomp]=$row[1];
				 echo "SELECTED";
				 }
				echo " >".$row[1]."</option>";	  
			     }			
		  ?>
		  </select></td><td width="69" class="saludo1" >No:          </td>
          <td width="228" ><input type="hidden" name="ntipocomp" value="<?php echo $_POST[ntipocomp]?>">          
          <input type="text" name="ncomp" size="7" onKeyPress="javascript:return solonumeros(event)" value="<?php echo $_POST[ncomp]?>" onKeyUp="return tabular(event,this) " onBlur="validar2()" ><input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">                      </td>
          <td width="93" class="saludo1" >Fecha:</td>
          <td width="148" ><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          </td>
          <td width="64" class="saludo1">Estado:</td>
          <td colspan="2"><input type="hidden" id="duplicar" name="duplicar"  value="<?php echo $_POST[duplicar]; ?>" readonly><input type="hidden" id="oculto" name="oculto"  value="<?php echo $_POST[oculto]; ?>" readonly><input type="hidden" name="estado"  value="<?php echo $_POST[estado]; ?>" readonly><input type="text" name="estadoc" size="20"  value="<?php echo $_POST[estadoc]; ?>" readonly></td><td></td>
        </tr>
    <tr>
          <td class="saludo1">Concepto:          </td>
          <td colspan="3" ><input type="text" name="concepto" size="87" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[concepto]; ?>">          </td>
          <td class="saludo1">Vigencia:          </td>
          <td  ><input type="text" name="vigencia" size="20" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]; ?>" readonly >          </td>
        </tr></table>
		
		<table class="inicio" width="99%">		
        <tr>
          <td class="titulos2" colspan="30">Agregar Detalle          </td>
        </tr>
        <tr>
          <td class="saludo1">Cuenta:</td>
          <td width="110" valign="middle" ><input type="text" id="cuenta" name="cuenta" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td><td width="486"><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="70" readonly></td>
          <td class="saludo1">Tercero: </td>
          <td width="139" ><input id="tercero" type="text" name="tercero" size="12" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();"><input type="hidden" value="0" name="bt">
            <a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
          <td width="298" colspan="2"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="45" readonly></td></tr><tr>         
          <td width="92" class="saludo1">Detalle:          </td>
          <td colspan="2" ><input type="text" name="detalle" id="detalle" size="80" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[detalle]?>" onClick="document.getElementById('detalle').focus();document.getElementById('detalle').select();" placeholder='Descripcion del registro'>          </td></tr><tr>
          
          <td width="96" class="saludo1">Vlr Aumenta:          </td>
          <td colspan="2" ><input type="text" name="vlrdeb" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyDown="return tabular(event,this)"  value="0" onClick="document.getElementById('vlrdeb').focus();document.getElementById('vlrdeb').select();" >          </td>
          <td width="92" class="saludo1">Vlr Disminuye:          </td>
          <td width="139" ><input type="text" name="vlrcre" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyDown="return tabular(event,this)"  value="0" onClick="document.getElementById('vlrcre').focus();document.getElementById('vlrcre').select();" >          </td>
          <td colspan="2" ><input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet">
	  	<?php
		if ($_POST[oculto]=="")
		 {
		 ?>
		<script>
    	document.form2.tipocomprobante.focus();
		</script>	
		<?php
		}
		?>
		 </td>
<?php 
			if($_POST[bc]=='1')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],1);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('tercero').focus();document.getElementById('tercero').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			  <?php
			  }
			 }			 
			  //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
			  <script>
			  document.getElementById('cc').focus();document.getElementById('cc').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				if (confirm("Tercero Incorrecto o no Existe, ¿Desea Agregar un Tercero?"))
				  {
				  mypop=window.open('cont-terceros.php','','');
  		  		document.form2.tercero.value="";	
  		  		document.form2.tercero.focus();	
			  		//document.form2.tercero.focus();
			  		}
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
			 //*** centro  costo
			 if($_POST[bcc]=='1')
			 {
			  $nresul=buscacentro($_POST[cc]);
			  if($nresul!='')
			   {
			  $_POST[ncc]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('detalle').focus();document.getElementById('detalle').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncc]="";
			  ?>
			  <script>alert("Centro de Costos Incorrecto");document.form2.cc.focus();</script>
			  <?php
			  }
			 }
			 ?>
        </tr>
      </table>
		<div class="subpantallac4" style="height:47%; width:99.6%; overflow-x:hidden;">
	    <table class="inicio" width="99%">
        <tr>
          <td class="titulos" colspan="8">Detalle Comprobantes          </td>
        </tr>
		<tr>
		<td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Tercero</td><td class="titulos2">Nom Tercero</td><td class="titulos2">Detalle</td><td class="titulos2">Aumenta</td><td class="titulos2">Disminuye</td><td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td></tr>
		<?php 
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		  $cuentacred=0;
		  $cuentadeb=0;
		   $diferencia=0;

		 unset($_POST[dpcuentas][$posi]);
 		 unset($_POST[dpncuentas][$posi]);
		 unset($_POST[dpterceros][$posi]);
		 unset($_POST[dpnterceros][$posi]);		 
		 unset($_POST[dpdetalles][$posi]);
		 unset($_POST[dcheques][$posi]);
		 unset($_POST[dcreditos][$posi]);		 		 		 		 		 
		 unset($_POST[ddebitos][$posi]);		 
		 $_POST[dpcuentas]= array_values($_POST[dpcuentas]); 
		 $_POST[dpncuentas]= array_values($_POST[dpncuentas]); 
		 $_POST[dpterceros]= array_values($_POST[dpterceros]); 		 		 
		 $_POST[dpnterceros]= array_values($_POST[dpnterceros]); 		 		 		 
		 $_POST[dpdetalles]= array_values($_POST[dpdetalles]); 
		 $_POST[dcheques]= array_values($_POST[dcheques]); 
		 $_POST[dcreditos]= array_values($_POST[dcreditos]); 
		 $_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
		 }
		if ($_POST[agregadet]=='1')
		 {
		  $cuentacred=0;
		  $cuentadeb=0;
		  $diferencia=0;
		 $_POST[dpcuentas][]=$_POST[cuenta];
		 $_POST[dpncuentas][]=$_POST[ncuenta];
		 $_POST[dpterceros][]=$_POST[tercero];
		 $_POST[dpnterceros][]=$_POST[ntercero];	 
		 $_POST[dpdetalles][]=$_POST[detalle];
		 $_POST[dcheques][]=$_POST[cheque];
//		 $_POST[dcreditos][]=number_format($_POST[vlrcre],2,".","");
	//	 $_POST[ddebitos][]=number_format($_POST[vlrdeb],2,".","");
	// $_POST[vlrcre]=str_replace(".","",$_POST[vlrcre]);
	 //$_POST[vlrdeb]=str_replace(".","",$_POST[vlrdeb]);
	 $_POST[vlrcre]=str_replace(",",".",$_POST[vlrcre]);
	 $_POST[vlrdeb]=str_replace(",",".",$_POST[vlrdeb]);
	 $_POST[dcreditos][]=$_POST[vlrcre];
		 $_POST[ddebitos][]=$_POST[vlrdeb];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.cuenta.select();
				document.form2.cuenta.value="";
		 </script>
		  <?php
/*		 $_POST[cuenta]='';
		 $_POST[ncuenta]='';
		 $_POST[tercero]='';
		 $_POST[cc]='';		 
	     $_POST[detalle]='';
		 $_POST[cheque]='';
		 $_POST[vlrcre]='';
		 $_POST[vlrdeb]='';*/
		  }
		 //  echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		  
/*		  		  $i=0;
			$vc=array();
			Foreach ($_SESSION[creditos] as $valor)
			{
			$vd=$valor;
			$vc[$i]=$vd;
			//$_SESSION["cods"][$i] =$vd;
			$i+=1;
			}		 		 */
		 //echo "<input name='cuentas[]' type='hidden' value='$_POST[cuenta]'>";
		 //echo "C".count($_POST[dpcuentas]);
		 $iter="saludo1";
		 $iter2="saludo2";		 
		 for ($x=0;$x< count($_POST[dpcuentas]);$x++)
		 {
		echo "<tr class=$iter><td ><input name='dpcuentas[]' value='".$_POST[dpcuentas][$x]."' type='text' size='20' readonly></td><td ><input name='dpncuentas[]' value='".ucfirst(strtolower($_POST[dpncuentas][$x]))."' type='text' size='55' readonly></td><td ><input name='dpterceros[]' value='".$_POST[dpterceros][$x]."' type='text' size='10' readonly></td><td ><input name='dpnterceros[]' value='".buscatercero($_POST[dpterceros][$x])."' type='text' size='20' readonly></td><td ><input name='dpdetalles[]' value='".ucfirst(strtolower($_POST[dpdetalles][$x]))."' type='text' size='35' onDblClick='llamarventana(this,$x)' onBlur='validar3()' onKeyUp='return tabular(event,this)' readonly></td><td ><input name='ddebitos[]' value='".$_POST[ddebitos][$x]."' type='text' size='10' onDblClick='llamarventanadeb(this,$x)' onBlur='validar3()' onKeyUp='return tabular(event,this)' onKeyPress='javascript:return solonumeros(event)' readonly></td><td><input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text' size='10' onDblClick='llamarventanacred(this,$x)' onBlur='validar3()' onKeyUp='return tabular(event,this)' onKeyPress='javascript:return solonumeros(event)' readonly></td><td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
//		 $cred= $vc[$x]*1;
		 $cred=$_POST[dcreditos][$x];
		 $deb=$_POST[ddebitos][$x];
//		 $cred=number_format($cred,2,".","");
	//	 $deb=number_format($deb,2,".","");
		 $cred=$cred;
		 $deb=$deb;		 
		 $cuentacred=$cuentacred+$cred;
		 $cuentadeb=$cuentadeb+$deb;		 
		 $diferencia=$cuentadeb-$cuentacred;
		 $total=number_format($total,2,",","");
		 $_POST[diferencia]=$diferencia;
		 $_POST[diferencia2]=number_format($diferencia,2,".",",");
 		 $_POST[cuentadeb]=number_format($cuentadeb,2,".",",");
		 $_POST[cuentadeb2]=$cuentadeb;
		 $_POST[cuentacred]=number_format($cuentacred,2,".",",");	 
		 $_POST[cuentacred2]=$cuentacred;
		 $aux=$iter2;
		 $iter2=$iter;
		 $iter=$aux;
		 }
		 echo "<tr><td></td><td></td><td >Diferencia:</td><td colspan='1'><input type='hidden' id='diferencia' name='diferencia' value='$_POST[diferencia]' ><input id='diferencia2' name='diferencia2' value='$_POST[diferencia2]' type='text' readonly></td><td>Totales:</td><td class='saludo2'><input name='cuentadeb2' type='hidden' id='cuentadeb2' value='$_POST[cuentadeb2]'><input name='cuentadeb' id='cuentadeb' value='$_POST[cuentadeb]' readonly></td><td class='saludo2'><input id='cuentacred' name='cuentacred' value='$_POST[cuentacred]' readonly><input id='cuentacred2' type='hidden' name='cuentacred2' value='$_POST[cuentacred2]' ></td></tr>";
		?>
		</table>  
		</div> 
	  </form>
	  	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	//	echo "oc: ".$_POST[oculto];
	if($_POST[oculto]=='3')	
		{
	$linkbd=conectar_bd();
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		//echo "F: ".$fechaf;
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	//	echo "B: ".$bloq;
	if($bloq>=1)
	{						
		$sqlr="select fijo from pptotipo_comprobante where codigo='$_POST[tipocomprobantep]'";
$res2=mysql_query($sqlr,$link);
$rt=mysql_fetch_row($res2);
//echo "N: ".$rt[0];
if($rt[0]=='N') //**** validacion tipo comprobante
 {	
		//rutina de guardado cabecera	
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];

		$sqlr="select count(*) from pptocomprobante_cab where tipo_comp=$_POST[tipocomprobantep] and numerotipo=$_POST[ncomp]";
		$res=mysql_query($sqlr,$linkbd);
		$nc=mysql_fetch_row($resp); 
		if ($nc[0]>0)
		{
//		$sqlr="update comprobante_cab where tipo_comp=$_POST[tipocomprobante] and numerotipo=$_POST[ncomp]";	
		 $sqlr="update pptocomprobante_cab set numerotipo=$_POST[ncomp],tipo_comp=$_POST[tipocomprobantep],fecha='$fechaf',concepto='$_POST[concepto]',vigencia=$_POST[vigencia] where tipo_comp='$_POST[tipocomprobantep]' and numerotipo='$_POST[ncomp]'";
		}
		else
		{
	$sqlr="insert into pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values ($_POST[ncomp],$_POST[tipocomprobantep],'$fechaf','$_POST[concepto]',$_POST[vigencia],0,0,0,'1')";
		}
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici?n: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurri? el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  		else
  		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el encabezado con Exito <img src='imagenes\confirm.png' ></center></td></tr></table>";
		// $idcomp=mysql_insert_id(); 
 		$sqlr="delete from pptocomprobante_det where tipo_comp='$_POST[tipocomprobantep]' AND numerotipo=$_POST[ncomp]'";
		mysql_query($sqlr,$linkbd);
		 for ($x=0;$x<count($_POST[dpcuentas]);$x++)
		  {
		 $sqlr="insert into pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('".$_POST[dpcuentas][$x]."','".$_POST[dpterceros][$x]."','".$_POST[dpdetalles][$x]."',".$_POST[ddebitos][$x].",".$_POST[dcreditos][$x].",'1','".$_POST[vigencia]."',$_POST[tipocomprobantep],$_POST[ncomp],'1','1','','$fechaf')";
		 if (!mysql_query($sqlr,$linkbd))
			{
		 echo "<table ><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici?n: <br><font color=red><b>$sqlr</b></font></p>";
//	
		 	$e =mysql_error($respquery);
	 		echo "Ocurrio el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
		  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     		echo "</pre></center></td></tr></table>";
			}
  			else
  		 	  {
		  		//echo "<table><tr><td class='saludo1'><center>$sqlr Se ha almacenado el detalle con Exito</center></td></tr></table>";
		  	   }
		  }
		} 
 	}//**** fin validacion tipo comprobante
	}
	else
	   {
    	echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
	   }
	}
	
	?></form>
 </td></tr>
</table>
</body>
</html>