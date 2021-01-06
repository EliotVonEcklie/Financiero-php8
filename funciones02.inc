<?php
/* Cambios, Modificaciones y Actualizaciones:
	<7-03-2016, Modifico funcion paginasnuevas(), HAFR>
*/
//include "comun.inc";
//****** BLOQUEOS USUARIO Y PERIODOS
function bloqueos($usuario,$fechadoc)
 {
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="Select count(*) From dominios dom  where dom.nombre_dominio = 'PERMISO_MODIFICA_DOC'  and dom.valor_final <= '$fechadoc'  AND dom.valor_inicial =  '$usuario' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;	
}
function vigencia_usuarios($usuario)
 {
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="Select dom.tipo From dominios dom  where dom.nombre_dominio = 'PERMISO_MODIFICA_DOC'  AND dom.valor_inicial =  '".$usuario."'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;	
}
//****** cuentas contables ***
function buscacuentacont($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from cuentas where cuenta='$cuenta' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	//echo $sqlr;
	return $nombre;
}
function buscacuenta($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from cuentas where cuenta='$cuenta' and tipo='Auxiliar'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}

function buscagasto_valoriva($gasto)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
//***
$co=0;
$sqlr="select porcentaje from tesogastos_det where codigo='$gasto'";
//echo $sqlr;
$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{ 
	 $valor=$r[0];	
	}
return $valor;
}

function buscarpcxpactiva($rp,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select count(id_orden) from tesoordenpago where tesoordenpago.id_rp=$rp and vigencia='$vigencia' and estado<>'N'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$co+=1;}
	return $valor;
}
//**** busca tercero
function buscatercero($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from terceros where cedulanit='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
		if ($r[16]=='1'){$ntercero=$r[5];}
   		else {$ntercero=$r[3].' '.$r[4].' '.$r[1].' '.$r[2];}
	 	$valor=$r[12];
	 	$valor2=$ntercero;
	 	$co+=1;
	}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//**********************
function codifica($cadena,$cadena2)
{
 	$tam=strlen($cadena);
 	$tam2=strlen($cadena2);
	$con=0;
	$nuevacadena='';
 	for ($x=0;$x<$tam;$x++)
  	{
		$asci=  abs(((ord(substr($cadena,$x,1))+ord(substr($cadena2,$con,1)))));
		$asci=abs($asci-255);	
   		$nuevacadena.=chr($asci);
    	if($con<($tam2-1)){$con+=1;}
  	 	else{$con=0;}
  	}
 	return $nuevacadena;
}
function decodifica($cadena,$cadena2)
{
 	$tam=strlen($cadena);
 	$tam2=strlen($cadena2);
	$con=0;
	$nuevacadena='';
 	for ($x=0;$x<$tam;$x++)
  	{
		$asci=abs(ord(substr($cadena,$x,1))-255);  
		$asci=abs($asci-ord(substr($cadena2,$con,1)));
   		$nuevacadena.=chr($asci);
      	if($con<$tam2-1){$con+=1;}
   		else{$con=0;}  
  	}
 	return $nuevacadena;
}
function software()
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
  	$sqlr="select * from admcon where  id=1 ";
	$res=mysql_query($sqlr,$conexion);
	$fec=date("d/m/Y"); 
	while ($row =mysql_fetch_row($res)){$f1=$row[1];$f2=$row[2];$cadena2=$row[3];$estado=$row[4];}
	if($estado=='N')
	{
		die("<br><br><br><div style='background-color:#0555aa;color:fff';><h4><img src='imagenes/gyc.png'  align='middle' >&nbsp;&nbsp;<img src='imagenes/pagar.png' widht='100' height='100' align='middle'  >&nbsp;&nbsp; &iexcl;&iexcl;&iexcl; EL SISTEMA ESTA DESACTIVADO !!!. COMUNIQUESE CON LA EMPRESA DISTRIBUIDORA DEL SOFTWARE  &nbsp;&nbsp; <img src='imagenes/alert.png' align='middle'  ></h4></div>");	
	}
	if($estado=='A')
	{
	 	$decfin=decodifica($f2,$cadena2);
	 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fec,$fecha);
	 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $decfin,$fecha2);
	 	$fechafin=mktime(0,0,0,$fecha2[2],$fecha2[1],$fecha2[3]);
	 	$fechactual=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);	 
	 	if(($fechafin-$fechactual)<0)
	  	{
	   		die("<br><br><br><div style='background-color:#0555aa;color:fff';><h4><img src='imagenes/gyc.png'  align='middle' >&nbsp;&nbsp;<img src='imagenes/pagar.png' widht='100' height='100' align='middle'  >&nbsp;&nbsp; &iexcl;&iexcl;&iexcl; EL SISTEMA ESTA DESACTIVADO !!!. COMUNIQUESE CON LA EMPRESA DISTRIBUIDORA DEL SOFTWARE  &nbsp;&nbsp; <img src='imagenes/alert.png' align='middle'  ></h4></div>");
	   		$sqlr='UPDATE  admcon SET estado="N", where  id=1 ';
			mysql_query($sqlr,$conexion);
	   	}
		$resultado=codifica($cadena,$cadena2);  
	}
 }
//**** busca centro costo
function buscacentro($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from centrocosto where id_cc='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$ncc=$r[1];$valor=$r[0];$valor2=$ncc;$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}

function buscaNombreCuenta($cuenta,$vigencia){
$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
  	 $criterio=" and (vigencia=$vigencia or vigenciaf=$vigencia)";
   $sqlr="select * from pptocuentas where cuenta='$cuenta'  ".$criterio;
// echo $sqlr." fff";
$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
	 $valor=$r[0];
	 $valor2=$r[1];
	 $co+=1;
	}
  $nombre=$valor2; 
  return $nombre;
}
//***** busca cuentas presupuestales
function buscacuentapres($cuenta,$tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
  	 $criterio=" and (vigencia=$vigusu or vigenciaf=$vigusu)";
   $sqlr="select * from pptocuentas where cuenta='$cuenta'  ".$criterio;
// echo $sqlr." fff";
$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
	 $valor=$r[0];
	 $valor2=$r[1];
	 $co+=1;
	}
  $nombre=$valor2; 
return $nombre;
}
// busca si existe una cuenta
function existecuenta($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from cuentas where cuenta='$cuenta'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
// busca si existe una cuenta nicsp
function existecuentanicsp($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from cuentasnicsp where cuenta='$cuenta'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
// busca si existe una cuenta de ingreso
function existecuentain($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	$co=0;
	$sqlr="select * from pptocuentas where cuenta='$cuenta' and (vigencia='".$vigusu."' or  vigenciaf='".$vigusu."')";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else{$nombre="";}
	return $nombre;
}
// busca si la cuenta es auxiliar o no 
function mayaux($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	$sqlr="select * from pptocuentas where cuenta='$cuenta'and vigencia=".$vigusu;
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[2];$co+=1;}
	if ($co>0){$tipo=$valor2;}
	else {$tipo="";}
	return $tipo;
}
//**** busca registro
function buscaregistro($cuenta,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from pptorp where consvigencia='$cuenta' and vigencia='$vigencia' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[1];$valor2=$r[2];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//*****busca ingreso tesoreria
function buscaingreso($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from tesoingresos where codigo='$cuenta'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//***
function buscaingresoconpes($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from presuingresoconpes where codigo='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//**** ingresos ssf
function buscaingresossf($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from tesoingresossf_cab where codigo='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre=""; }
	return $nombre;
}
//***** anula todos los documentos de predial y liq recaudos de fechas anteriores que no se hallan pagado
function anularprediales($fecha)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
 	die("no se puede conectar");
  	if(!mysql_select_db($datin[0]))
  	die("no se puede seleccionar bd"); 
	$sqlr="Select *  From dominios dom where dom.nombre_dominio = 'FECHA_LIMITE_MODIFICA_DOC'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$fecha2=$r[0];}
	$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
	$difecha=$fechafin-$fechaini;
	$diasd=$difecha/(24*60*60);
	$diasd=floor($diasd);
	//**** predial
  	$sqlr="update tesoliquidapredial set estado='N' where fecha between '$fecha2' and '$fecha'  and estado='S'";
 	mysql_query($sqlr,$conexion);
	//**** recibos de caja
  	/*$sqlr="select * from tesorecaudos where fecha between '$fecha2' and '$fecha'  and estado='S'";
 	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
  		$sqlr="update tesorecaudos set estado='N' where id_recaudo=$r[0] and fecha between '$fecha2' and '$fecha'  and estado='S'";
 		mysql_query($sqlr,$conexion);
  		$sqlr="update comprobante_cab set estado=0 where tipo_comp=2 and numerotipo=$r[0]";
  		mysql_query($sqlr,$conexion);
  		$sqlr="update comprobante_det set debito=0,credito=0 where tipo_comp=2 and numerotipo=$r[0]";
  		mysql_query($sqlr,$conexion);
	}*/
	//echo "CONSULTA".$sqlr;  
 }
//*********
function buscaciiu($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select *from codigosciiu where codigosciiu.nombre<>='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}

function buscacodigociiu($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select nombre from codigosciiu where codigo='$codigo'";
	$res=mysql_query($sqlr,$conexion);
	$r=mysql_fetch_row($res);
	return $r[0];
}

function buscaretencion($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from tesoretenciones where id='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[2]; $co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaretencioncod($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from tesoretenciones where id='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaretencioniva($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from tesoretenciones where id='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0]; $valor2=$r[7];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//**** busca tercero
function buscaregimen($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from terceros where cedulanit='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[12];$valor2=$r[17];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaconcepto($cuenta, $modulo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from conceptoscontables where codigo='$cuenta' and modulo='$modulo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];$valor2=$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre=""; }
	return $nombre;
}
function buscaconcepto2($cuenta, $modulo, $tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT nombre FROM conceptoscontables WHERE codigo='$cuenta' AND modulo='$modulo' AND tipo='$tipo'";
	$res=mysql_query($sqlr,$conexion);
	$row=mysql_fetch_row($res);
	return $row[0];
}
function buscanomina($tercero,$posicion)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from terceros_nomina where cedulanit='$tercero' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[$posicion];}
	return $valor;
}
function buscaparafiscal($codigo,$cc,$sector)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	if($sector=='PB'){$sector="publico";}
	if($sector=='PR'){$sector="privado";}
	$sqlr="select * from humparafiscales_det where codigo='$codigo' and cc='$cc' and sector like '%$sector%' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[6];}
	return $valor;
}
function buscanominaparafiscal_estado($nomina,$codigo,$tercero,$cc,$sector)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	/*if($sector=='PB')
	$sector="publico";
	if($sector=='PR')
	$sector="privado";*/
	$sqlr="select estado from humnomina_saludpension where id_nom=$nomina and tipo='$codigo' and tercero='$tercero' and cc='$cc' and sector like '%$sector%' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscaparafiscalnom($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from humparafiscales where codigo='$codigo'  and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[1];}
	return $valor;
}
function buscavariablepago($codigo,$cc)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from  humvariables_det where codigo='$codigo' and cc='$cc'  and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[7];}
	return $valor;
}
function buscabanco($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from  tesobancosctas where cuenta='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[1];}
	return $valor;
}
function buscabancocn($cuentab,$nit)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from  tesobancosctas where ncuentaban='$cuentab' and tercero='$nit' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscabancocn2($cuentab,$nit)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from  tesobancosctas where cuenta='$cuentab' and tercero='$nit' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[2];}
	return $valor;
}
function buscagastoban($ngasto)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from  tesogastosbancarios where codigo='$ngasto' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[1];}
	return $valor;
}
function validarcuentas($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
    $sqlrchip="select count(*) from cuentas where cuenta='$cuenta'";
	$reschip=mysql_query($sqlrchip,$conexion);
	$rowchip=mysql_fetch_row($reschip);
	return $rowchip[0];
}
function buscadominio($dominio,$valorinicial)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from dominios where  NOMBRE_DOMINIO='$dominio' and VALOR_INICIAL='$valorinicial'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$ncc=$r[2];$valor=$r[0];$valor2=$ncc;$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscadominiov2($dominio,$tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from dominios where  NOMBRE_DOMINIO='$dominio' and tipo='$tipo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$ncc=$r[1];$valor=$r[0];$valor2=$ncc;$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaperfil($idrol)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select nom_rol from  roles where id_rol='$idrol' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
//****BUSCA CONCILIACION ***
function buscaconciliacion($idconc,$fechaini,$fechafin)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
//	$valor=0;
	$sqlr="select COUNT(*) from  CONCILIACION where id_DET='$idconc' and periodo2 not between '$fechaini' and '$fechafin' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];	}
	return $valor;
}
function buscaconciliacion_fecha($idconc,$fechaini,$fechafin)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select periodo2 from  CONCILIACION where id_DET='$idconc' and periodo2 not between '$fechaini' and '$fechafin'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
//***ultimo dia de un mes
function ultimodia($anho,$mes){ 
   if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) {$dias_febrero = 29; } 
   else {$dias_febrero = 28;} 
   switch($mes)
   { 
       case 1: return 31; break; 
       case 2: return $dias_febrero; break; 
       case 3:  return 31; break; 
       case 4: return 30; break; 
       case 5: return 31; break; 
       case 6:  return 30; break; 
       case 7:  return 31; break; 
       case 8:  return 31; break; 
       case 9:  return 30; break; 
       case '01': return 31; break; 
       case '02': return $dias_febrero; break; 
       case '03' :  return 31; break; 
       case '04' :  return 30; break; 
       case '05' : return 31; break; 
       case '06' :  return 30; break; 
       case '07' : return 31; break; 
       case '08':  return 31; break; 
       case '09':  return 30; break; 
       case 10: return 31; break; 
       case 11: return 30; break; 
       case 12: return 31; break; 
   } 
}
function buscacomprobante($tipocomp)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
    $sqlrchip="select nombre from tipo_comprobante where codigo='$tipocomp'";
	$reschip=mysql_query($sqlrchip,$conexion);
	$rowchip=mysql_fetch_row($reschip);
	return $rowchip[0];
}
function digitosnivelesctas($nivel)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
    $sqlrchip="select posiciones from nivelesctas where id_nivel=$nivel";
	$reschip=mysql_query($sqlrchip,$conexion);
	$rowchip=mysql_fetch_row($reschip);
	return $rowchip[0];
}
function pptovalor($cuentap,$mes,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	//******RECAUDOS - RECIBOS DE CAJA
	$sqlr="select pptorecibocajappto.valor, pptorecibocajappto.idrecibo from pptorecibocajappto, tesoreciboscaja where pptorecibocajappto.cuenta='$cuentap' AND tesoreciboscaja.id_recibos=pptorecibocajappto.idrecibo and pptorecibocajappto.vigencia='".$vigencia."' and MONTH(tesoreciboscaja.fecha)='$mes' and tesoreciboscaja.estado<>'N' ORDER BY pptorecibocajappto.idrecibo";
	echo "<br>re:".$sqlr;
 	$res=mysql_query($sqlr,$conexion);
 	$valor=0;		 
 	while ($row =mysql_fetch_row($res)){$valor+=$row[0];}
	//RETENCIONES
	$sqlr="select pptoretencionpago.valor,pptoretencionpago.idrecibo from pptoretencionpago, tesoegresos where pptoretencionpago.cuenta='$_POST[cuenta]' AND tesoegresos.id_egreso=pptoretencionpago.idrecibo and pptoretencionpago.vigencia='".$vigencia."' and MONTH(tesoegresos.fecha)='$mes' and tesoegresos.estado<>'N' ORDER BY pptoretencionpago.idrecibo";
	echo "v:$valor<br>ret:".$sqlr;
 	$res=mysql_query($sqlr,$conexion);
 	while ($row =mysql_fetch_row($res)){$valor+=$row[0];}
 	//****INGRESOS TRANSFERENCIAS 
 	$sqlr="select pptoingtranppto.valor,pptoingtranppto.idrecibo from pptoingtranppto, tesorecaudotransferencia where pptoingtranppto.cuenta='$_POST[cuenta]' AND tesorecaudotransferencia.id_recaudo=pptoingtranppto.idrecibo and pptoingtranppto.vigencia='".$vigencia."' and MONTH(tesorecaudotransferencia.fecha) ='$mes' and tesorecaudotransferencia.estado<>'N'   ORDER BY pptoingtranppto.idrecibo";
 	echo "v:$valor<br>ing:".$sqlr;
  	$res=mysql_query($sqlr,$conexion);
  	while ($row =mysql_fetch_row($res)){$valor+=$row[0];}
  	return $valor;
}
 //*****BUSCA PRODUCTOS COMPRAS
 function buscaproducto($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select nombre from  productospaa where codigo='$codigo' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
 function buscaproductotipo($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select tipo from  productospaa where codigo='$codigo' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscacodssf($rubro,$vigencia)
 {
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select codigo from  tesoingresossf_det where cuentapresgas='$rubro' and vigencia=$vigencia";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
 }
function buscacodssfnom($codigo)
 {
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select nombre from  tesoingresossf_cab where codigo='$codigo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
 }
//***activos ****
function diferenciamesesfechas($fechainicial,$fechafinal)
{
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fechainicial,$fecha);
	$fechai=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]);
	$yeari=$fecha[1];
	$mesesi=$fecha[2];
  	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fechafinal,$fecha);
	$fechaf=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]);
	$yearf=$fecha[1];
	$mesesf=$fecha[2];
	$dif=$fechaf-$fechai;
	$meses=floor($dif/(30*24*60*60));	
	$meses=($yearf-$yeari)*12+($mesesf-$mesesi);	  
 	return $meses;
}
function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}
function sumamesesfecha($fechainicial,$meses)
 {
	$fechaf=date("Y-m-d",strtotime("$fechainicial+$meses months"));
	return $fechaf;
 } 
 function diferenciamesesfechas_f2($fechainicial,$fechafinal)
 {
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fechainicial,$fecha);
	$fechai=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
	$yeari=$fecha[1];
	$mesesi=$fecha[2];
  	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fechafinal,$fecha);
	$fechaf=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
	$yearf=$fecha[1];
	$mesesf=$fecha[2];
	$dif=$fechaf-$fechai;
	$meses=floor($dif/(30*24*60*60));	
	$meses=($yearf-$yeari)*12+($mesesf-$mesesi);	  
	return $dif;
 }
 function diferenciamesesfechas_f3($fechainicial,$fechafinal)
 {
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fechainicial,$fecha);
	$fechai=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]);
	$yeari=$fecha[1];
	$mesesi=$fecha[2];
  	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fechafinal,$fecha);
	$fechaf=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]);
	$yearf=$fecha[1];
	$mesesf=$fecha[2];
	$dif=$fechaf-$fechai;
	$meses=floor($dif/(30*24*60*60));	
	$meses=($yearf-$yeari)*12+($mesesf-$mesesi);	  
	return $dif;
 }
//******BUSCAR FUENTES DE RECURSOS PRESUPUESTALES
function buscafuenteppto($rubro,$vigencia) 
{

	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$ind=substr($rubro,0,1);
 	$sqlr="select clasificacion from pptocuentas where pptocuentas.cuenta='$rubro' and (pptocuentas.vigencia=".$vigencia." or  pptocuentas.vigenciaf=$vigencia)";
 	$res=mysql_query($sqlr,$conexion);
	$row=mysql_fetch_row($res);
	$ind=$row[0];
	//****clasificacion
	$criterio="and (pptocuentas.vigencia=".$vigencia." or  pptocuentas.vigenciaf=$vigencia)";	
	if ($ind=='funcionamiento')
		//$sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldos,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.vigencia=$vigusu and pptocuentas.cuenta='$rubro' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
		$sqlr="select distinct pptocuentas.futfuentefunc,pptofutfuentefunc.nombre from pptocuentas,pptofutfuentefunc where pptocuentas.cuenta='$rubro' and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
	if ($ind=='deuda' || $ind=='inversion' || $ind=='reservas-gastos')
	//$sqlr="select pptocuentas.futfuenteinv,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.cuenta='$rubro' and  pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
		$sqlr="select distinct pptocuentas.futfuenteinv,pptofutfuenteinv.nombre from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$rubro' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
	$res=mysql_query($sqlr,$conexion);
	$row=mysql_fetch_row($res);
	$recurso="";
    if($row[1]!='' || $row[1]!=0)
	{
	$recurso=$row[0].'_'.$row[1];
	} 
	//echo $sqlr;
	return $recurso;
}//****** funcion de busqueda de sector empleado pension
 
function buscasector($cedulausu)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select fondopensionestipo from terceros_nomina where cedulanit='$cedulausu'"; 
	$res=mysql_query($sqlr,$conexion);
	$row=mysql_fetch_row($res);
	$sector=$row[0];
	return $sector;
}
 
//***** NOMINA BUSCAR VARIABLE
function buscapptovarnom($codigo,$tipo,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	if($tipo=='N')
	{
		$sqlr="select distinct humvariables_det.concepto from humvariables_det,humvariables where humvariables_det.codigo='$codigo' and humvariables_det.codigo=humvariables.codigo and humvariables.estado='S' AND humvariables_det.vigencia=$vigencia";
	}
	if($tipo=='F' || $tipo=='SR' || $tipo=='SE' || $tipo=='PR' || $tipo=='PE')
	{
		$sqlr="select distinct humparafiscales_det.concepto from humparafiscales_det,humparafiscales where humparafiscales_det.codigo='$codigo' and humparafiscales_det.codigo=humparafiscales.codigo and humparafiscales.estado='S' AND humparafiscales_det.vigencia=$vigencia";
	}
	//echo $sqlr; 
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
//**** 
function buscapptovarnom_ppto($codigo,$tipo,$cc,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	if($tipo=='N' || $tipo=='D' || $tipo=='SE' || $tipo=='PE')
	{
		$sqlr="select distinct humvariables_det.cuentapres from humvariables_det,humvariables where humvariables_det.codigo='$codigo' and humvariables_det.codigo=humvariables.codigo and humvariables.estado='S' and humvariables_det.cc='$cc' AND humvariables_det.vigencia=$vigencia";
	}
	if($tipo=='F' || $tipo=='SR'  || $tipo=='PR' )
	{
		$sqlr="select distinct humparafiscales_det.cuentapres from humparafiscales_det,humparafiscales where humparafiscales_det.codigo='$codigo' and humparafiscales_det.codigo=humparafiscales.codigo and humparafiscales_det.cc='$cc' and humparafiscales.estado='S' AND humparafiscales_det.vigencia=$vigencia";
	}
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	if($valor=="")
	{
	//echo $sqlr;
	}
	//echo $sqlr;
	return $valor;
}
//************** CODIGOS PARAMETROS DE NOMINA
function buscaparanom($parametro)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select ".$parametro." from humparametrosliquida ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
//**** busca responsable
function buscaresponsable($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="SELECT t.*, pt.* FROM terceros t, planestructura_terceros pt WHERE pt.estado='S' AND pt.cedulanit = t.cedulanit AND pt.cedulanit='".$cuenta."'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
	  	if ($r[16]=='1'){$ntercero=$r[5];}
   		else {$ntercero=$r[3].' '.$r[4].' '.$r[1].' '.$r[2];}
	 	$valor=$r[12];
	 	$valor2=$ntercero;
	 	$co+=1;
	}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
//**** busca terceros2
function buscatercero2($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from terceros where cedulanit='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
	  	if ($r[16]=='1'){$ntercero=$r[5];}
   		else {$ntercero=$r[3].' '.$r[4].' '.$r[1].' '.$r[2];}
		$valor=$r[12];
		$valor2=$ntercero;
		$terdireccion=$r[6];
		$tertelefono=$r[7];
		$tercelular=$r[8];
		$teremail=$r[9];
		$co+=1;
	}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	$pruebav[0]=$nombre;
	$pruebav[1]=trim($terdireccion);
	$pruebav[2]=trim($tertelefono);
	$pruebav[3]=trim($tercelular);
	$pruebav[4]=trim($teremail);//str_replace(' ', '', $cadena);
	return $pruebav;
}
function buscatercero_cta($tercero)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from terceros_cuentasban where cedulanit='$tercero' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$nombre=$r[1];}
	return $nombre;	
}
// INICIO CARGA MENU DESPLEGABLE
function menu_desplegable($modulo)
{
	//$nombre_archivo = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT valor_inicial FROM dominios WHERE nombre_dominio='FECHA_BACKUP' ";
	$rowbk=mysql_fetch_row(mysql_query($sqlr,$conexion));
	if($rowbk[0]!=NULL){$fechabackup=$rowbk[0];}
	else {$fechabackup='Sin Fecha';}															   
	$nombre_archivo = $_SERVER['REQUEST_URI'];
	if ( strpos($nombre_archivo, '/') !== FALSE )
  	$nombre_archivo = array_pop(explode('/', $nombre_archivo));
	switch ($modulo) 
	{
		case "plan":
			echo ('<td colspan="3">
				<ul class="mi-menu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a>
					</li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu($_SESSION[linksetpl][1]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetpl][1]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu($_SESSION[linksetpl][2]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetpl][2]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu($_SESSION[linksetpl][3]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetpl][3]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu($_SESSION[linksetpl][4]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetpl][4]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.html\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios($_SESSION[cedulausu]).'</a></li>');
					if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 25px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li>
					</ul></td>');
			break;
		case "adm":
			echo ('<td colspan="3">
				<ul class="mi-menu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Sistema</a>');
						$estilos=ajustar_menu($_SESSION[linksetad][0]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetad][0]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Parametros</a>');
						$estilos=ajustar_menu($_SESSION[linksetad][1]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetad][1]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu($_SESSION[linksetad][2]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetad][2]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu($_SESSION[linksetad][3]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetad][3]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.html\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios($_SESSION[cedulausu]).'</a></li>');
						if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 25px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul></td>');
			break;
		case "acti":
			echo ('<td colspan="3">
				<ul class="mi-menu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu($_SESSION[linksetac][1]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetac][1]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu($_SESSION[linksetac][2]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetac][2]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu($_SESSION[linksetac][3]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetac][3]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu($_SESSION[linksetac][4]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetac][4]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.html\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios($_SESSION[cedulausu]).'</a></li>');
					if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 25px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li>
					</ul></td>');
			break;
		case "cont":
			echo ('<td colspan="3">
				<ul class="mi-menu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu($_SESSION[linksetco][1]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetco][1]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu($_SESSION[linksetco][2]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetco][2]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu($_SESSION[linksetco][3]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetco][3]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu($_SESSION[linksetco][4]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetco][4]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li>
						<a href="ayuda.html" target="_blank">Ayuda</a>
					</li>
					<li style="text-align:right; float:right">
						<a>'.vigencia_usuarios($_SESSION[cedulausu]).'</a>
					</li>');
					if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="text-align:right; float:right">
						<img src="imagenes/chat2.png" style="width:30px; height:25px; cursor:pointer;" alt="Chat" title="Chat" onclick="verChat()">
					</li>
					<li style="vertical-align:bottom; line-height: 25px; float:right" >
						<a>Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a>
					</li>
				</ul>
			</td>');
			break;
		case "teso":
			echo('<td colspan="3">
				<ul class="mi-menu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;" accesskey="i">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu($_SESSION[linksette][1]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksette][1]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Recaudo</a>');
						$estilos=ajustar_menu($_SESSION[linksette][2]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksette][2]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Pago</a>');
						$estilos=ajustar_menu($_SESSION[linksette][3]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksette][3]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Traslados</a>');
						$estilos=ajustar_menu($_SESSION[linksette][4]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksette][4]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu($_SESSION[linksette][5]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksette][5]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu($_SESSION[linksette][6]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksette][6]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.html\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios($_SESSION[cedulausu]).'</a></li>');
				if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 25px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul></td>');
			break;
		case "contra":
			echo ('<td colspan="3"> 
				<ul class="mi-menu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu($_SESSION[linksetct][1]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetct][1]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu($_SESSION[linksetct][2]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetct][2]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu($_SESSION[linksetct][3]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetct][3]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu($_SESSION[linksetct][4]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetct][4]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.html\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios($_SESSION[cedulausu]).'</a></li>');
						if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 25px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul></td>');
			break;
		case "presu":
			echo ('<td colspan="3">
				<ul class="mi-menu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu($_SESSION[linksetpr][1]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetpr][1]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Proceso Ingreso </a>');
						$estilos=ajustar_menu($_SESSION[linksetpr][2]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetpr][2]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Proceso Gastos </a>');
						$estilos=ajustar_menu($_SESSION[linksetpr][3]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetpr][3]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Reportes</a>');
						$estilos=ajustar_menu($_SESSION[linksetpr][4]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetpr][4]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu($_SESSION[linksetpr][5]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetpr][5]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.html\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right">

					 <a>'.vigencia_usuarios($_SESSION[cedulausu]).'</a> 
					<!--
					<a>

			
					<select style="border:none; appearance:none; -moz-appearance:none;-webkit-appearance:none;background:#26ABD7; color:white; font-size: 15px;width: 2cm;" id="cambioVigencia" name="cambioVigencia">
						<option value="2012">2012</option>
						<option value="2013">2013</option>
						<option value="2014">2014</option>
						<option value="2015">2015</option>
						<option value="2016">2016</option>
						<option value="2017">2017</option>
					</select>

					</a>
					-->
					</li>');
					if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 25px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul></td>');
			break;
		case "serv":
			echo ('<td colspan="3">
				<ul class="mi-menu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu($_SESSION[linksetser][1]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetser][1]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu($_SESSION[linksetser][2]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetser][2]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu($_SESSION[linksetser][3]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetser][3]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu($_SESSION[linksetser][4]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetser][4]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.html\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li> <li style="text-align:right; float:right"><a>'.vigencia_usuarios($_SESSION[cedulausu]).'</a></li>');
						if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 25px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul></td>');
			break;
		case "hum":
			echo ('<td colspan="3">
				<ul class="mi-menu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;"">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu($_SESSION[linksethu][1]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksethu][1]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu($_SESSION[linksethu][2]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksethu][2]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu($_SESSION[linksethu][3]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksethu][3]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu($_SESSION[linksethu][4]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksethu][4]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.html\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li>
					<li style="text-align:right; float:right"><a>'.vigencia_usuarios($_SESSION[cedulausu]).'</a></li>');
								if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 25px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul></td>');
			break;
		case "meci":
			echo ('<td colspan="3">
				<ul class="mi-menu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu($_SESSION[linkset][1]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linkset][1]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu($_SESSION[linkset][2]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linkset][2]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu($_SESSION[linkset][3]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linkset][3]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu($_SESSION[linkset][4]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linkset][4]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.html\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios($_SESSION[cedulausu]).'</a></li>');
						if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 25px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul></td>');
			break;
		case "inve":
			echo ('<td colspan="3">
				<ul class="mi-menu">
					<li><a onClick="location.href=\'principal.php\'" style="cursor:pointer;">Inicio</a></li>
					<li><a style="cursor:pointer;">Archivos Maestros</a>');
						$estilos=ajustar_menu($_SESSION[linksetin][1]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetin][1]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Procesos</a>');
						$estilos=ajustar_menu($_SESSION[linksetin][2]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetin][2]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Herramientas</a>');
						$estilos=ajustar_menu($_SESSION[linksetin][3]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetin][3]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a style="cursor:pointer;">Informes</a>');
						$estilos=ajustar_menu($_SESSION[linksetin][4]);
						$filas=str_replace('<li>','<li '.$estilos[1].'>',$_SESSION[linksetin][4]);
						echo('<ul class="ws_css_cb_menum" style="width:'.$estilos[0].';">
							'.$filas.'
						</ul>
					</li>
					<li><a onClick="mypop=window.open(\'../spid.php?pagina=ayuda.html\',\'\',\'\');mypop.focus();" style="cursor:pointer;">Ayuda</a></li><li style="text-align:right; float:right"><a>'.vigencia_usuarios($_SESSION[cedulausu]).'</a></li>');
					if($_SESSION["perfil"]=="Superman"){echo('<li><a onClick="alert(\''."Pagina: $nombre_archivo\\nBase: $datin[0]\\nFecha: $fechabackup".'\')" style="cursor:pointer;">Link</a></li>');}
					echo('<li style="vertical-align:bottom; line-height: 25px; float:right" ><a>Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..." onkeypress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li></ul></td>');
			break;
	}
}
//FIN CARGA MENU DESPLEGABLE
//INICIO CARGA CUADRO DE TITULOS
function cuadro_titulos()
{
	$hora=time();
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT razonsocial FROM configbasica";
    $row =mysql_fetch_row(mysql_query($sqlr,$conexion));
	$ttentidad=$row[0];
	$sqlr="SELECT * FROM interfaz01 ";
    $resp = mysql_query($sqlr,$conexion);
	$ntr = mysql_num_rows($resp);
	$row =mysql_fetch_row($resp);	
	if($ntr==0)
	{
		$ttlema="Ingresar Lema de la Entidad";
		$ttcolor1="#000000";
		$ttcolor2="#ffffff";
		$sqlr1="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_LETRA' AND valor_inicial='1'";
		$row1 =mysql_fetch_row(mysql_query($sqlr1,$conexion));
		$ttletra1= $row1[0];
		$ttflle01="normal";
		$ttle01="100%";
		$ttcolorl1="#000000";
		$sqlr1="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_LETRA' AND valor_inicial='1'";
		$row1 =mysql_fetch_row(mysql_query($sqlr1,$conexion));
		$ttletra2= $row1[0];
		$ttflle02="normal";
		$ttle02="100%";
		$ttcolorl2="#000000";
	}
	else
	{
		$ttlema=$row[0];
		$ttcolor1=$row[1];
		$ttcolor2=$row[2];
		$sqlr1="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_LETRA' AND valor_inicial='$row[3]'";
		$row1 =mysql_fetch_row(mysql_query($sqlr1,$conexion));
		$ttletra1= $row1[0];
		$ttflle01=$row[4];
		$ttle01="$row[5]%";
		$ttcolorl1=$row[6];
		$sqlr1="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_LETRA' AND valor_inicial='$row[7]'";
		$row1 =mysql_fetch_row(mysql_query($sqlr1,$conexion));
		$ttletra2= $row1[0];
		$ttflle02=$row[8];
		$ttle02="$row[9]%";
		$ttcolorl2=$row[10];
	}
	echo"
	<td style='height:50px; width:36%;margin-right:0px;padding-right:0px'>
		<img src='imagenes/escudo.jpg'  style='width:14%;height:131%;float:left;margin-top:1px;'/>
		<table style='width:85%;height:100%; background: -webkit-linear-gradient($ttcolor1,$ttcolor2);float:left; border-top-right-radius:4px; border-bottom-right-radius:4px;'>
			<tr>
				<td style='font-family:$ttletra1;font-style:$ttflle01;text-align:center;font-size:$ttle01;color:$ttcolorl1;'>$ttentidad</td>
			</tr>
			<tr>
				<td style='font-family:$ttletra2;font-style:$ttflle02;text-align:center;font-size:$ttle02;color:$ttcolorl2;'>$ttlema</td>
			</tr>
		</table>
	</td>";
    
    echo('
	<td style="margin-left:0px;padding-left:0px ">
		<table class="inicio" style="width:100%;margin-left:0px;padding-left:0px">
			<tr>
				<td class="saludot"  style="width:1.5cm;" >Usuario: </td>
				<td>'.substr(ucwords((strtolower($_SESSION[usuario]))),0,14).'</td>
				<td class="saludot" style="width:1.5cm;">Perfil: </td>
				<td>'.substr(ucwords((strtolower($_SESSION["perfil"]))),0,14).'</td>
				<td rowspan="2"><img class="marco01" id="imagencmS" src="'.$_SESSION["fotousuario"].'" style="height:57px; width:50px;" /></td>
			</tr>
			<tr>
				<td class="saludot" style="width:1.5cm;">Fecha ingreso:</td>
				<td>'.' '.$fec=date("d-m-Y").'</td>
				<td class="saludot" style="width:1.5cm;">Hora Ingreso: </td>
				<td>'.' '.date ( "h:i:s" , $hora ).'</td>
			</tr>
		</table>
	</td>'); 
	
}
//FIN CARGA CUADRO DE TITULOS
//****BUSQUEDA RECURSIVA
function buscaplan($padre,$prioridad,$minimaprioridad,$color,$color2)
{
	$tipo=array();
	$tipo[0]="folder";
	$tipo[1]="file";
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	//echo "<tr class=$color><td>$padre</td><td>$row[1]</td><td ><a href='plan-editaplandesarrollo.php?idproceso=$row[0]'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";		
	$sqlr="Select distinct *from presuplandesarrollo where padre like '$padre'";
	$resp2 = mysql_query($sqlr,$conexion);
	//echo "<br>$sqlr";
	while ($row=mysql_fetch_row($resp2)) 
    {	
		/*$sqlr="Select distinct *from presuplandesarrollo where codigo=$padre";
		$resp3 = mysql_query($sqlr,$conexion);
		$fila=mysql_fetch_row($resp3); 	
		*/
		if($minimaprioridad==$row[5]){$clase="file";$vinculo="plan-indicadores.php";}
		else{$clase="folder";$vinculo="plan-indicadores.php";}
		$aux=$color;
		$color=$color2;
		$color2=$aux; 
		echo "<ul><li><span class='$clase'>$row[0] $row[1]<a href='$vinculo?idproceso=$row[0]&tipo=$row[5]'><img src='imagenes/ver.png' ></a></span>";	
		$aux=$color;
		$color=$color2;
		$color2=$aux;
		if($row){buscaplan($row[0],$row[5],$minimaprioridad,$color,$color2);echo "</li></ul>";}
    }	
}
function buscaplanedit($padre,$prioridad,$minimaprioridad,$color,$color2)
 {
	$tipo=array();
	$tipo[0]="folder";
	$tipo[1]="file";
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	//echo "<tr class=$color><td>$padre</td><td>$row[1]</td><td ><a href='plan-editaplandesarrollo.php?idproceso=$row[0]'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";		
	$sqlr="Select distinct *from presuplandesarrollo where padre like '$padre'";
	$resp2 = mysql_query($sqlr,$conexion);
	//echo "<br>$sqlr";
	while ($row=mysql_fetch_row($resp2)) 
    {	
		/*$sqlr="Select distinct *from presuplandesarrollo where codigo=$padre";
		$resp3 = mysql_query($sqlr,$conexion);
		$fila=mysql_fetch_row($resp3); 	
		*/
		if($minimaprioridad==$row[5]){$clase="file";$vinculo="plan-editaplandesarrollo.php";}
		else{$clase="folder";	$vinculo="plan-editaplandesarrollo.php";}
		$aux=$color;
		$color=$color2;
		$color2=$aux; 
		echo "<ul><li><span class='$clase'>$row[0] $row[1]<a href='$vinculo?idproceso=$row[0]&tipo=$row[5]'><img src='imagenes/ver.png' ></a></span>";	
		$aux=$color;
		$color=$color2;
		$color2=$aux;
		if($row){buscaplanedit($row[0],$row[5],$minimaprioridad,$color,$color2);echo "</li></ul>";}
    }	
}
//***
function buscavariable_pd($codigo,$vigenciai,$vigenciaf)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="Select distinct *from presuplandesarrollo where codigo like '$codigo' and vigencia=$vigenciai and vigenciaf=$vigenciaf";
	$resp2 = mysql_query($sqlr,$conexion);
	$variable=array();
	while ($row=mysql_fetch_row($resp2)) 
    {	
		$variable[0]=$row[0];
		$variable[1]=$row[1];
		$variable[2]=$row[5];
		$variable[3]=$row[2];
	}
	return $variable;	
}
function tipos_pd($tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select *from dominios where nombre_dominio='PLAN_DESARROLLO' and VALOR_INICIAL=$tipo order by VALOR_INICIAL";
	$resp2 = mysql_query($sqlr,$conexion);
	while ($row=mysql_fetch_row($resp2)){$variable=$row[1];}
	return $variable;	
}
//***
function buscaestrato_servicios($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="select * from servestratos where id='$codigo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor2=$r[0]." - ".$r[2]." - ".$r[1];$co+=1;}
	if ($co>0){$nombre=$valor2;}
	else {$nombre="";}
	return $nombre;
}
function buscaclienteserv($documento)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="select terceros_servicios.cedulanit from terceros, terceros_servicios where terceros.cedulanit=terceros_servicios.cedulanit and terceros_servicios.consecutivo='$documento'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$nombre=$r[0];}
	return $nombre;
}
function buscaclienteserv2($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="select terceros_servicios.consecutivo from terceros, terceros_servicios where terceros.cedulanit=terceros_servicios.cedulanit and terceros_servicios.cedulanit='$codigo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$nombre=$r[0];}
	echo $sqlr;
	return $nombre;
}

function buscaclienteserv3($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="select t.razonsocial,t.apellido1,t.apellido2,t.nombre1,t.nombre2 from terceros t, servclientes sc where sc.terceroactual=t.cedulanit and sc.codigo='$codigo'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{	
		if($r[0]==""){$nombre[0]=$r[1].' '.$r[2].' '.$r[3].' '.$r[4];}
		else{$nombre[0]=$r[0];}
	}
	$sqlr2="select codigo from servmedidores where cliente=".$codigo;
	$resp2=mysql_query($sqlr2,$linkbd);
	$row2=mysql_fetch_row($resp2);
	if($row2[0]==""){$nombre[1]="MEDIDOR NO ASIGNADO";}
	else{$nombre[1]=$row2[0];}
	return $nombre;
}
function buscasubsidio_valor($servicio,$estrato,$tipoliquida, $valormed)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	if($tipoliquida==1)
	$sqlr="select servsubsidios_det.valor from servsubsidios,servsubsidios_det where servsubsidios.codigo=servsubsidios_det.codigo and 	servsubsidios.codservicio='$servicio' and servsubsidios_det.estrato='$estrato' and  servsubsidios_det.estado='S'";
	if($tipoliquida==2)
	$sqlr="select servsubsidios_det.valor from servsubsidios,servsubsidios_det where servsubsidios.codigo=servsubsidios_det.codigo and servsubsidios.codservicio='$servicio' and servsubsidios_det.estrato='$estrato' and '$valormed' between servsubsidios_det.rango2 and servsubsidios_det.rango2 and  servsubsidios_det.estado='S' ";	
	$res=mysql_query($sqlr,$conexion);
	$valor=0;
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscadescuento_valor($servicio,$estrato,$tipoliquida, $valormed)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	if($tipoliquida==1)
		$sqlr="select servdescuentos_det.valor from servdescuentos,servdescuentos_det where servdescuentos.codigo=servdescuentos_det.codigo and servdescuentos.codservicio='$servicio' and servdescuentos_det.estrato='$estrato' and  servdescuentos_det.estado='S'";
	if($tipoliquida==2)
		$sqlr="select servdescuentos_det.valor from servdescuentos,servdescuentos_det where servsubsidios.codigo=servdescuentos_det.codigo and servdescuentos.codservicio='$servicio' and servdescuentos_det.estrato='$estrato' and '$valormed' between servdescuentos_det.rango2 and servdescuentos_det.rango2 and  servdescuentos_det.estado='S' ";	
	$res=mysql_query($sqlr,$conexion);
	$valor=0;
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscatarifa_valor($servicio,$estrato,$tipoliquida, $valormed)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	if($tipoliquida==1)
		$sqlr="select servtarifas_det.valor, servtarifas_det.valorcf from servtarifas,servtarifas_det where servtarifas.codigo=servtarifas_det.codigo and servtarifas.codservicio='$servicio' and servtarifas_det.estrato='$estrato' and  servtarifas_det.estado='S'";
	if($tipoliquida==2)
		$sqlr="select servtarifas_det.valor, servtarifas_det.valorcf from servtarifas,servtarifas_det where servtarifas.codigo=servtarifas_det.codigo and servtarifas.codservicio='$servicio' and servtarifas_det.estrato='$estrato' and '$valormed' between servtarifas_det.rango2 and servtarifas_det.rango2 and  servtarifas_det.estado='S' ";	
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor[0]=$r[0];$valor[1]=$r[1];}
	return $valor;
}
function buscacontribucion_valor($servicio,$estrato,$tipoliquida,$valormed)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	if($tipoliquida==1)
		$sqlr="select servcontribuciones_det.valor from servcontribuciones,servcontribuciones_det where servcontribuciones.codigo=servcontribuciones_det.codigo and servcontribuciones.codservicio='$servicio' and servcontribuciones_det.estrato='$estrato' and  servcontribuciones_det.estado='S'";
	if($tipoliquida==2)
		$sqlr="select servcontribuciones_det.valor from servcontribuciones,servcontribuciones_det where servcontribuciones.codigoservcontribuciones_det.codigo and servcontribuciones.codservicio='$servicio' and servcontribuciones_det.estrato='$estrato' and '$valormed' between servcontribuciones_det.rango2 and servcontribuciones_det.rango2 and  servcontribuciones_det.estado='S' ";	
	$res=mysql_query($sqlr,$conexion);
	$valor=0;
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function mostrarservicios($cliente)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="select servicio from  terceros_servicios where  terceros_servicios.estado='S' and terceros_servicios.consecutivo='$cliente' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor.=" ".$r[0];}
	return $valor;
}
function buscaservicio_liquida($servicio)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="select tipo_liqui from  servservicios where  servservicios.codigo='$servicio' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscaservicio_cc($servicio)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="select cc from  servservicios where  servservicios.codigo='$servicio' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
function buscamedicion($servicio,$medidor,$cliente)
{
 
}
function buscasaldoanterior($servicio,$cliente)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$valor=0;
	$c=0;
	//$sqlr="select codigo from  servliquidaciones, servliquidaciones_det where  servliquidaciones.estado='S' and servliquidaciones.codusuario='$cliente' and servliquidaciones.id_liquidacion=servliquidaciones_det.id_liquidacion and servliquidaciones_det.servicio='$servicio'";
	$sqlr="SELECT * FROM (SELECT sn.id_liquidacion, sn.codusuario,det.servicio, det.valorliquidacion,sn.estado
					FROM servliquidaciones sn, servliquidaciones_det  det, servfacturas fac
						WHERE sn.id_liquidacion = det.id_liquidacion
						AND sn.codusuario = '$cliente' and det.servicio='$servicio'
						and  sn.factura=fac.id_factura
						ORDER BY sn.id_liquidacion DESC)SUB	";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{	
		if($r[4]=='S'){$valor=$r[0];}
		else{$c+=1;exit;}
	}
	if($valor==0 && $c==0)
	{
		$sqlr="SELECT saldo FROM terceros_servicios where consecutivo='".$cliente."' AND ESTADO='S' and servicio='$servicio' order by servicio";
		//echo "<br>sw: ".$sqlr;
		$resp=mysql_query($sqlr,$conexion);
		while($rowEmp =mysql_fetch_row($resp)){$valor=	$rowEmp[0];}
		//echo "suma: ".$valor;	
	}
	return $valor;		 
}
function buscarmedidor($cliente)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="select codigo from  servmedidores where  servmedidores.estado='S' and servmedidores.cliente='$cliente' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;		
}
function buscarmedidor_servicios($cliente)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="select servicio from  servmedidores_servicios where  servmedidores_servicios.estado='S' and servmedidores_servicios.codigo='$cliente' ";
	$res=mysql_query($sqlr,$conexion);
	$valor=' ';
	while($r=mysql_fetch_row($res))
	{$valor.=$r[0]." ";}
	return $valor;		
}
function buscaconcepto_sp($servicio,$tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	switch ($tipo)
	{
		case 'TR':  //tarifas
			$sqlr="select concecont from servtarifas where codservicio='$servicio' and estado='S' ";break;
		case 'SB':  //subsidios
			$sqlr="select concecont from servsubsidios where codservicio='$servicio' and estado='S' ";break;
		case 'CT':  //contribucion
			$sqlr="select concecont from servcontribuciones where codservicio='$servicio' and estado='S' ";break;
		case 'DS': //descuentos
			$sqlr="select concecont from servdescuentos where codservicio='$servicio' and estado='S' ";break;
	}
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}
//conceptos contables en general
function concepto_cuentas($concepto,$tipo,$modulo,$centrocosto)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="Select distinct conceptoscontables_det.cuenta, conceptoscontables_det.tipocuenta,conceptoscontables_det.debito,conceptoscontables_det.credito from conceptoscontables, conceptoscontables_det where conceptoscontables.tipo='$tipo' and conceptoscontables_det.tipo='$tipo' and conceptoscontables.codigo=conceptoscontables_det.codigo and conceptoscontables.codigo='$concepto' and conceptoscontables_det.codigo='$concepto' and conceptoscontables_det.modulo=$modulo and conceptoscontables_det.cc like '%$centrocosto%'";
	$res=mysql_query($sqlr,$conexion);
	//echo "<br>".$sqlr;
	$valor[]=array();
	$con=0;
	while($r=mysql_fetch_row($res))
	{	
	$valor[$con][0]=$r[0]; //cuenta
	$valor[$con][1]=$r[1]; //tipo cuenta
	$valor[$con][2]=$r[2]; //debito
	$valor[$con][3]=$r[3]; //credito
	$con+=1;
	}
	return $valor;
}
//****fin servicios publicos
function buscarareatrabajo($idarea)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="select nombrearea from  planacareas where   planacareas.codarea='$idarea' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;		
}

//**** buscar datos de cualquier dominio
function buscar_dominio($dominio,$valini,$valfin,$tipo,$varsalida)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	if($valini==NULL){$cond1=" and (valor_inicial is NULL or valor_inicial='')";}
	else{$cond1=" and  valor_inicial = '$valini'";}
	if($valfin==NULL){$cond2=" and (valor_final is NULL or valor_final='')";}
	else{$cond2=" and  valor_final = '$valfin'";}
	if($tipo==NULL){$cond3=" and (tipo is NULL or tipo='')";}
	else{$cond3=" and  tipo like '%$tipo%'";}
	$sqlr="select $varsalida from  dominios where nombre_dominio='$dominio' $cond1 $cond2 $cond3 ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;	
}
function buscar_empleado($documento,$campo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))	
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");		
	if($campo == NULL || $campo>1)
	$campo=0;
	$crit2=" and t.cedulanit like '%$documento%' ";
	$sqlr='SELECT concat(t.nombre1," ",t.nombre2," ",t.apellido1," ",t.apellido2), pl.nombrecargo, pt.* FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.estado="S" AND pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo'.$crit1.$crit2.' order by t.apellido1, t.apellido2, t.nombre1, t.nombre2';
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[$campo];}
	return $valor;	
}
//***** genera semaforo 
function  semaforo($estadofase)
{
	switch ($estadofase)
	{
		case 1:
			echo "<img src='imagenes/sema_rojoON.jpg' width='16px' height='16px'><img src='imagenes/sema_amarilloOFF.jpg' width='16px' height='16px'><img src='imagenes/sema_verdeOFF.jpg' width='16px' height='16px'>";break;
		case 2:
			echo "<img src='imagenes/sema_rojoOFF.jpg' width='16px' height='16px'><img src='imagenes/sema_amarilloON.jpg' width='16px' height='16px'><img src='imagenes/sema_verdeOFF.jpg' width='16px' height='16px'>";break;
		case 3:
			echo "<img src='imagenes/sema_rojoOFF.jpg' width='16px' height='16px'><img src='imagenes/sema_amarilloOFF.jpg' width='16px' height='16px'><img src='imagenes/sema_verdeON.jpg' width='16px' height='16px'>";break;
	}
}
//****************
function busca_cdpcontrato($cdp,$vigencia,$tipodoc)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$valor=array();		
	$sqlr="select proceso from contrasolicitudcdpppto where vigencia='$vigencia' and tipodoc='$tipodoc' and ndoc=$cdp";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$proceso=$r[0];}
	//echo $sqlr;

	$sqlr="select contrato from contraprocesos where idproceso=$proceso";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$contrato=$r[0];}

	//echo $sqlr;
	$sqlr="select numcontrato,contratista from contracontrato where vigencia='$vigencia'  and numcontrato=$contrato";
	$res=mysql_query($sqlr,$conexion);	
	while($r=mysql_fetch_row($res))
	{
	$valor[0]=$r[0];
	$valor[1]=$r[1];
	}
	//echo $sqlr;
	return $valor;	
}
//**Inicio copiar carpeta con todo el contenido
function full_copy( $source, $target ) 
{
	if ( is_dir( $source ) ) 
	{ 
		@mkdir( $target ); 
		$d = dir( $source ); 
		while ( FALSE !== ( $entry = $d->read() ) ) 
		{ 
			if ( $entry == '.' || $entry == '..' ) { continue;} 
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ){full_copy( $Entry, $target . '/' . $entry ); continue;} 
			copy( $Entry, $target . '/' . $entry ); 
		} 
		$d->close();
	}
	else {copy( $source, $target );}
}
//**Inicio comprimir carpeta**
function comprimir($ruta, $zip_salida, $handle = false, $recursivo = false)
{
	if(!$handle)
	{
		$handle = new ZipArchive;
		if ($handle->open($zip_salida, ZipArchive::CREATE) === false){}
	}
	if(is_dir($ruta))
	{
		$ruta = dirname($ruta.'/arch.ext'); 
		$handle->addEmptyDir($ruta); 
		foreach(glob($ruta.'/*') as $url){comprimir($url, $zip_salida, $handle, true);}
	}
	else{$handle->addFile($ruta);}
	if(!$recursivo){$handle->close();}
}
//**Descomprimir carpeta
function descomprimir($ruta)
{
	$zip = new ZipArchive;
	if ($zip->open($ruta.".zip") === TRUE) 
	{
		$zip->extractTo(getcwd()."/");
		$zip->close();
	} 
}
//**mirar icono del archivo
function traeico($archivo)
{
	$ext=explode(".",$archivo);
	switch (strtoupper($ext[1])) 
	{
		case "":
			$icono='<img style="width:17px; height:17px" src="imagenes/tipodoc/sinarch.png" title="Sin Archivo">';
			break;
		case "DOC":
			$icono='<img style="width:20px" src="imagenes/tipodoc/doc1.png" title="(.doc)">';
			break;
		case "DOCX":
			$icono='<img style="width:20px" src="imagenes/tipodoc/doc1.png" title="(.docx)">';
			break;
		case "PDF":
			$icono='<img style="width:20px" src="imagenes/tipodoc/pdf2.png" title="(.pdf)">';
			break;
		case "JPG":
			$icono='<img style="width:20px" src="imagenes/tipodoc/imagen_jpg.png" title="(.jpg)">';
			break;
		case "BPM":
			$icono='<img style="width:20px" src="imagenes/tipodoc/imagen_bmp.png" title="(.bpm)">';
			break;
		case "GIF":
			$icono='<img style="width:20px" src="imagenes/tipodoc/imagen_gif.png" title="(.gif)">';
			break;
		case "PNG":
			$icono='<img style="width:20px" src="imagenes/tipodoc/imagen_png.png" title="(.png)">';
			break;
		case "TXT":
			$icono='<img style="width:20px" src="imagenes/tipodoc/imagen_txt.png" title="(.txt)">';
			break;
		default:
			$icono='<img style="width:20px" src="imagenes/tipodoc/unknown.png" title="Desconocido">';
		
	}
	return $icono;
}
function buscaingreso_valor($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$valor=0;
	$sqlr="select precio from tesoingresos_precios where ingreso='$cuenta' and estado='S'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor=$r[0];}
	return $valor;
}

function buscaproductos($padre,$prioridad,$minimaprioridad,$color,$color2)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="Select distinct *from productospaa where padre like '$padre'";
	$resp2 = mysql_query($sqlr,$conexion);
	while ($row=mysql_fetch_row($resp2)) 
    {	
		switch($row[2])
		{
			case "2":
				echo "<tr class='$color2'><td width='10%' colspan=\"2\" style=\"text-align:right\">$row[0]</td><td colspan=\"4\">$row[1]</td></tr>";
				break;
			case "3":
				echo "<tr class='$color2'><td width='15%' colspan=\"3\" style=\"text-align:right\">$row[0]</td><td colspan=\"3\">$row[1]</td></tr>";
				break;
			case "4":
				echo "<tr class='$color2'><td width='20%' colspan=\"4\" style=\"text-align:right\">$row[0]</td><td colspan=\"2\">$row[1]</td></tr>";
				break;
			default:
				echo "<tr class='$color2'><td width='25%' colspan=\"5\" style=\"text-align:right\">$row[0]</td><td>$row[1]</td></tr>";
		}
		$aux=$color;
		$color=$color2;
	 	$color2=$aux;
		if($row){buscaproductos($row[0],$row[3],$minimaprioridad,$color,$color2);}
	}
}
function buscaproductos_arbol($padre,$prioridad,$minimaprioridad,$color,$color2)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))	
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="Select distinct *from productospaa where padre like '$padre'";
	$resp2 = mysql_query($sqlr,$conexion);
	while ($row=mysql_fetch_row($resp2)) 
    {	
		if($minimaprioridad==$row[3]){$clase="file";$vinculo="plan-indicadores.php";}
		else{$clase="folder";$vinculo="plan-indicadores.php";}
		$aux=$color;
		$color=$color2;
		$color2=$aux; 
	 	echo "<ul><li><span class='$clase'>$row[0] $row[1]<a href='$vinculo?idproceso=$row[0]&tipo=$row[3]'><img src='imagenes/ver.png' ></a></span>";	
		$aux=$color;
		$color=$color2;
		$color2=$aux;
		if($row)	
		{
			//echo "<br>$row[11]";	
			buscaproductos_arbol($row[0],$row[3],$minimaprioridad,$color,$color2);
			echo "</li></ul>";
		}				
  	}
}
//*****BUSCA PRODUCTOS COMPRAS
function buscadquisicion($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select codigosunspsc, descripcion, codplan from contraplancompras where codplan='$codigo' ";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){
		$valor[0]=$r[0];
		$valor[1]=$r[1];
		$valor[2]=$r[2];
	}
	return $valor;
}
//*****BUSCA PRODUCTOS SOLICIUD ADOQUISICIONAL
function buscasoladquisicion($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select codproductos, objeto, codsolicitud, numproductos, valortotal, valunitariop from contrasoladquisiciones where codsolicitud='$codigo' and estado='S' and activo='1'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){
		$valor[0]=$r[0];
		$valor[1]=$r[1];
		$valor[2]=$r[2];
		$valor[3]=$r[3];
		$valor[4]=$r[4];
		$valor[5]=$r[5];
	}
	return $valor;
}
//*****BUSCA PRODUCTOS SOLICIUD RESERVA
function buscasolreserva($codigo){
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT almreservas.codigo, almreservas.solicitante, terceros.nombre1, terceros.nombre2, terceros.apellido1, terceros.apellido2 FROM almreservas INNER JOIN terceros ON almreservas.solicitante=terceros.cedulanit WHERE almreservas.codigo='$codigo' AND (almreservas.estado='ACT' OR almreservas.estado='PND')";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){
		$valor[0]=$r[0];
		$valor[1]=$r[1];
		$valor[2]=$r[2];
		$valor[3]=$r[3];
		$valor[4]=$r[4];
		$valor[5]=$r[5];
	}
	return $valor;
}
//*****BUSCA REVERSION
function buscainveitem($codigo, $movimiento, $tipoentra){
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$tipomov=$movimiento-2;
	$sqlr="SELECT codigo, nombre FROM almginventario WHERE codigo='$codigo' AND tipomov='$tipomov' AND tiporeg='$tipoentra'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){
		$valor[0]=$r[0];
		$valor[1]=$r[1];
	}
	return $valor;
}
//**** busca tercero con dependencia
function buscatercerod($cuenta)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
	$sqlr="SELECT t.*, pl.*, pt.* FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.estado='S' AND t.cedulanit='$cuenta' AND pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res))
	{
		if ($r[11]=='31'){$ntercero=$r[5];}
	   	else {$ntercero=$r[3].' '.$r[4].' '.$r[1].' '.$r[2];}
	   	$dependencia=strtoupper(buscarareatrabajo($r[25]));
		$coddependencia=$r[25];
	 	$co+=1;
	}
	if ($co>0)
	 { 
	  $nombre[0]=$ntercero;
	  $nombre[1]=$dependencia;  
	  $nombre[2]=$coddependencia;     
	 }
	else {$nombre[0]=""; }
	return $nombre;
}
//*********
function buscaingreso_recaudo($recibo, $ingreso)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");		
	$sqlr="select ingreso, valor from tesoreciboscaja_det where id_recibos=$recibo and ingreso='$ingreso'";
	$res=mysql_query($sqlr,$conexion);
	while($r=mysql_fetch_row($res)){$valor[0]=$r[0];$valor[1]=$r[1];} 
	return $valor;	
}
function buscaing_cobrorecibo($vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");		
	$sqlr="select valor_inicial,valor_final from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigencia' and  tipo='S'";
	$res=mysql_query($sqlr,$conexion);
	while ($row =mysql_fetch_row($res)){$valor[0]=$row[0];$valor[1]=$row[1];}
	return $valor;	
}
function buscacomprobanteppto($tipocomp)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$co=0;
    $sqlrchip="select nombre from pptotipo_comprobante where codigo='$tipocomp'";
	$reschip=mysql_query($sqlrchip,$conexion);
	$rowchip=mysql_fetch_row($reschip);
	return $rowchip[0];
}
//*****BUSCA PROYECTOS
function buscaproyectos($codigo,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT nombre, consecutivo FROM planproyectos WHERE codigo='$codigo' AND vigencia='$vigencia' AND estado='S'";
	$r=mysql_fetch_row(mysql_query($sqlr,$conexion));
	//$res=mysql_query($sqlr,$conexion);
	//while($r=mysql_fetch_row($res))
	{$valor[0]=$r[0];$valor[1]=$r[1];}
	//$valor=strtoupper($r[0]);
	return $valor;
}
//*****BUSCA EL PADRE PLANDEDESARROLLO
function buscapadreplan($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="select padre from presuplandesarrollo where codigo='".$codigo."' ";
	$row =mysql_fetch_row(mysql_query($sqlr,$conexion));
	$sqlr2="select codigo, nombre from presuplandesarrollo where codigo='".$row[0]."' ";
	$row2 =mysql_fetch_row(mysql_query($sqlr2,$conexion));
	{$valor[0]=$row2[0];$valor[1]=$row2[1];}
	return $valor;
}
//****busca pago terceros - ingreso - retencion
function buscapagotercero_detalle($codpago,$mes,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT tesopagoterceros_det.valor,tesopagoterceros.fecha FROM tesopagoterceros, tesopagoterceros_det 
	WHERE 
	tesopagoterceros_det.id_pago=tesopagoterceros.id_pago 
	and tesopagoterceros_det.movimiento='$codpago'
	and MONTH(tesopagoterceros.fecha)='$mes' 
	and YEAR(tesopagoterceros.fecha)='$vigencia' and tesopagoterceros.estado='S'";
	//echo "ssss   ".$sqlr;
	$r=mysql_fetch_row(mysql_query($sqlr,$conexion));
	//$res=mysql_query($sqlr,$conexion);
	//while($r=mysql_fetch_row($res))
	{$valor[0]=$r[0];$valor[1]=$r[1];}
	//$valor=strtoupper($r[0]);
	return $valor;
}
function cargarcodigopag($cod,$nivel)
{//header ("location: http://servidor/financiero/principal.php");
	if ($cod!="")
	{
		$datin=datosiniciales();
		if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
		die("no se puede conectar");
		if(!mysql_select_db($datin[0]))
		die("no se puede seleccionar bd");
		$cod=strtoupper($cod);
		$sqlr="SELECT id_opcion,ruta_opcion FROM opciones WHERE comando='".$cod."'";
		$r=mysql_fetch_row(mysql_query($sqlr,$conexion));
		$opsi=$r[0];
		if ($opsi!="")
		{
			$sqln="SELECT id_opcion FROM rol_priv WHERE id_rol='".$nivel."' AND id_opcion='".$opsi."'";
			$niv=mysql_fetch_row(mysql_query($sqln,$conexion));
			$supnivel=$niv[0];
			if($supnivel!="")
			{
				cargainfomenus(strtoupper(substr($cod,0,2)),$nivel);
				$pagina=$r[1];
				if($pagina!=""){$pagina="location: http://servidor/financiero/".$pagina;header ($pagina);}
				else{echo '<script >alert(" C\xf3digo de P\xe1gina Incorrecto");</script>';}
			}
			else
			{echo '<script >alert("No tiene los privilegios para abrir esta p\xe1gina");</script>';}
		}
		else{echo '<script >alert(" C\xf3digo de P\xe1gina Incorrecto");</script>';}
	}
}
function cargainfomenus($cod,$nivel)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	switch ($cod) 
	{
		case "PE":
			$marcalink="linksetpl";
			$opcion="9";
			break;
		case "AD":
			$marcalink="linksetad";
			$opcion="0";
			break;
		case "AF":
			$marcalink="linksetac";
			$opcion="6";
			break;
		case "CO":
			$marcalink="linksetco";
			$opcion="1";
			break;
		case "TE":
			$marcalink="linksette";
			$opcion="4";
			break;
		case "CT":
			$marcalink="linksetct";
			$opcion="8";
			break;
		case "PR":
			$marcalink="linksetpr";
			$opcion="3";
			break;
		case "SP":
			$marcalink="linksetser";
			$opcion="10";
			break;
		case "GH":
			$marcalink="linksethu";
			$opcion="2";
			break;
		case "ME":
			$marcalink="linkset";
			$opcion="7";
			break;
		case "AL":
			$marcalink="linksetin";
			$opcion="5";
			break;
	}
	$_SESSION[$marcalink]=array();
	$sqlrw="Select DISTINCT (opciones.nom_opcion),opciones.ruta_opcion, opciones.niv_opcion,opciones.comando  from rol_priv, opciones where rol_priv.id_rol=$nivel and opciones.id_opcion=rol_priv.id_opcion and opciones.modulo='$opcion' group by (opciones.nom_opcion), opciones.ruta_opcion, opciones.niv_opcion,opciones.comando  order by opciones.orden";
	$resw=mysql_query($sqlrw,$conexion);
	while($roww=mysql_fetch_row($resw))
    {
	 	$_SESSION[$marcalink][$roww[2]].='<li> <a href="'.$roww[1].'">'.$roww[0].' <span style="float:right">'.$roww[3].'</span></a></li>';
	}
}
//******FUNCIONES PPTO *******
function buscacdp_detalle($numero,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="select objeto from pptocdp where vigencia=$vigencia and consvigencia=$numero";	
	$res=mysql_query($sqlr,$conexion);
	while($row=mysql_fetch_row($res)){$valor=$row[0];}
 return $valor;	
}
function buscacdp_rp($numero,$vigencia)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="select idcdp from pptorp where vigencia=$vigencia and consvigencia=$numero";	
	$res=mysql_query($sqlr,$conexion);
	while($row=mysql_fetch_row($res)){$valor=$row[0];}
 	return $valor;	
}
function buscaescalas($numero)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="SELECT * FROM humnivelsalarial WHERE id_nivel='$numero'";	
	$res=mysql_query($sqlr,$conexion);
	while($row=mysql_fetch_row($res))
	{$valor[0]=$row[1];$valor[1]=$row[2];}
	return $valor;
}
function mesletras($mes)
{
	switch ($mes) 
	{
		case "1":	$mesl="Enero";break;
		case "2":	$mesl="Febrero";break;
		case "3":	$mesl="Marzo";break;
		case "4":	$mesl="Abril";break;
		case "5":	$mesl="Mayo";break;
		case "6":	$mesl="Junio";break;
		case "7":	$mesl="Julio";break;
		case "8":	$mesl="Agosto";break;
		case "9":	$mesl="Septiembre";break;
		case "10":	$mesl="Octubre";break;
		case "11":	$mesl="Noviembre";break;
		case "12":	$mesl="Diciembre";
	}
	 return $mesl;	
}
function buscararticulos($codigo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="SELECT nombre FROM almarticulos WHERE estado='S' AND concat_ws('', grupoinven, codigo)='$codigo'";	
	$row=mysql_fetch_row(mysql_query($sqlr,$conexion));
	return $row[0];
}
function selconsecutivo($base,$campo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT MAX(CONVERT($campo, SIGNED INTEGER)) FROM $base";
    $resp = mysql_query($sqlr,$conexion);
    while ($row =mysql_fetch_row($resp)){$mx=$row[0];}
	$mx=$mx+1;
	return $mx;
}
function selconsecutivodomi($campo,$domi)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT MAX(CONVERT($campo, SIGNED INTEGER)) FROM dominios WHERE nombre_dominio='$domi'";
    $resp = mysql_query($sqlr,$conexion);
    while ($row =mysql_fetch_row($resp)){$mx=$row[0];}
	$mx=$mx+1;
	return $mx;
}
function selconsecutivohres($campo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT MAX(CONVERT(idhistory, SIGNED INTEGER)) FROM planacresponsables WHERE codradicacion='$campo'";
    $resp = mysql_query($sqlr,$conexion);
    while ($row =mysql_fetch_row($resp)){$mx=$row[0];}
	$mx=$mx+1;
	return $mx;
}
function busquedageneralSN($ntabla,$ncampo,$datocp)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");	
	$sqlr="SELECT * FROM $ntabla WHERE $ncampo='$datocp'";	
	$res=mysql_query($sqlr,$conexion);
	while($row=mysql_fetch_row($res))
	{
		if($row[0]!=''){$valor='SI';}
		else {$valor='NO';}
	}
	return $valor;
}
function kill_Spid($carpeta)
{/*
	$carpeta2="../financiero/".$carpeta;
	foreach(glob($carpeta2 . "/*") as $archivos_carpeta)
	{
		if (is_dir($archivos_carpeta)){kill_SiiP($archivos_carpeta);}
		else{unlink($archivos_carpeta);}
	}
	rmdir($carpeta2);*/
}
function mortal_strike()
{
	//$fechakill = new DateTime('2015-12-31 10:34:09');
	//$fechahoy = new DateTime('now');
	//if($fechakill < $fechahoy){kill_SiiP();}
}
function ajustar_menu($menu){
	$arrmenu=explode('<li>',$menu);
	$filas=count($arrmenu);
	$cols=round($filas/11);
	if($cols<=1){
		$ancho='240px';
		$estilo='style="margin-left:-30px;
		padding-left:0px;"';
		$estilo2='';
	}
	else{
		$valor=$cols*265;
		$ancho=$valor.'px';
		$estilo='style="margin-left:-40px;
		border-left:#ccc 1px solid;
		padding-left:10px;
		padding-right:50px;"';
	}
	$arreglo=array($ancho, $estilo);
	return $arreglo;
}
function paginasnuevas($modulo)
{
	switch ($modulo) 
	{
		case "cont":	$pagina="mypop=window.open('../spid.php?pagina=cont-principal.php','','');mypop.focus();";break;
		case "meci":	$pagina="mypop=window.open('../spid.php?pagina=meci-principal.php','','');mypop.focus();";break;
		case "teso":	$pagina="mypop=window.open('../spid.php?pagina=teso-principal.php','','');mypop.focus();";break;
		case "hum":		$pagina="mypop=window.open('../spid.php?pagina=hum-principal.php','','');mypop.focus();";break;
		case "plan":	$pagina="mypop=window.open('../spid.php?pagina=plan-principal.php','','');mypop.focus();";break;
		case "inve":	$pagina="mypop=window.open('../spid.php?pagina=inve-principal.php','','');mypop.focus();";break;
		case "adm":		$pagina="mypop=window.open('../spid.php?pagina=adm-principal.php','','');mypop.focus();";break;
		case "presu":	$pagina="mypop=window.open('../spid.php?pagina=presu-principal.php','','');mypop.focus();";break;
		case "contra":	$pagina="mypop=window.open('../spid.php?pagina=contra-principal.php','','');mypop.focus();";break;
	}
	return $pagina;
}
function busca_recaudos($recibo,$tipo)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
 $liquidacion=array();
 switch ($tipo) 
	{
		case 16:
	 	$sqlrw="select id_recaudo,tipo from tesoreciboscaja where id_recibos=$recibo";	
		$resw=mysql_query($sqlrw,$conexion);
		 //echo "<br>".$sqlr;
		 while($roww=mysql_fetch_row($resw))
		 {

		   $liquidacion[0]=$roww[0]; 
		   if($roww[1]==1)
		   $tipo='Predial';
		   if($roww[1]==2)
		   $tipo='Industria y Comercio';
		   if($roww[1]==3)
		   $tipo='Otros Recaudos';
   		   $liquidacion[1]=$tipo; 
		 }	
		break;
		case 17:
		$sqlrw="select id_orden from tesoordenpago_retenciones where id_orden=$recibo";	
		$resw=mysql_query($sqlrw,$conexion);
		 while($roww=mysql_fetch_row($resw))
		 {
		   $liquidacion[0]=$roww[0]; 
   		   $liquidacion[1]=$roww[1]; 		    
		 }	
		break;
		case 18:
		$sqlrw="select id_recaudo,tipo from tesosinreciboscaja where id_recibos=$recibo";	
		$resw=mysql_query($sqlrw,$conexion);
		 while($roww=mysql_fetch_row($resw))
		 {
		   $liquidacion[0]=$roww[0]; 
   		   $liquidacion[1]=$roww[1]; 		    
		 }
		break;
		case 19:
	 	$sqlrw="select idcomp from tesorecaudotransferencia where id_recaudo=$recibo";	
		$resw=mysql_query($sqlrw,$conexion);
		 while($roww=mysql_fetch_row($resw))
		 {
		   $liquidacion[0]=$roww[0]; 
   		   $liquidacion[1]=$roww[1]; 		    
		 }	
		break;
		case 21:
	 	$sqlrw="select id_recaudo from  tesossfingreso_cab where id_recaudo=$recibo";	
		$resw=mysql_query($sqlrw,$conexion);
		 while($roww=mysql_fetch_row($resw))
		 {
		   $liquidacion[0]=$roww[0]; 
   		   $liquidacion[1]=$roww[1]; 		    
		 }	
		break;
		case 22:
		   $liquidacion[0]=""; 
   		   $liquidacion[1]=""; 
		break;
	}	

 return $liquidacion;
}
function convertirdecimal($numero,$div)
{
	$numeros = explode($div, $numero);
	$pesos=convertir((int)$numeros[0]);
	$centa=convertir((int)$numeros[1]);
	if($numeros[1]!=0 && $numeros[1]!="00"){$total="$pesos PESOS CON $centa CENTAVOS M/CTE";}
	else{$total="$pesos PESOS M/CTE";}
	return $total;
}
function verificavigencia()
{
	if (vigencia_usuarios($_SESSION[cedulausu])=="")
	{echo"<script>despliegamodalm('visible','2','No tiene activo un año para la vigencia, favor agregarlo');</script>";}
}
function delnominaxx($idnom)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr ="DELETE FROM humnomina WHERE id_nom='$idnom'";//1
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM hum_nom_cdp_rp WHERE nomina='$idnom'";//2
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humcomprobante_cab WHERE numerotipo='$idnom'";//3
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humnomina_det WHERE id_nom='$idnom'";//4
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humcomprobante_det WHERE numerotipo='$idnom'";//5
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humnomina_saludpension WHERE id_nom='$idnom'";//6
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humnominaretenemp WHERE id_nom='$idnom'";//7
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humnomina_parafiscales WHERE id_nom='$idnom'";//7
	mysql_query($sqlr,$conexion);
	$sqlr ="DELETE FROM humnom_presupuestal WHERE id_nom='$idnom'";//8
	mysql_query($sqlr,$conexion);
	
	//$sqlr="UPDATE humretenempleados SET SNCUOTAS=SNCUOTAS-1 where estado='S' and empleado='".$_POST[ccemp][$x]."' and sncuotas>0";	
	//$sqlr="UPDATE humretenempleados SET estado='P' where estado='S' and empleado='".$_POST[ccemp][$x]."'  and sncuotas<=0";			
	
}
 function intercalar_caracteres( $cadena1, $cadena2, $posicion ) 
{ 
	$cadena2 = str_split( $cadena2 ); 
	$nueva = ''; 
	$l=1; $k=0; 
	for( $n=0; $n < strlen( $cadena1 ); $n++ )
	{ 
    	if( $l % $posicion == 0 ) 
		{ 
        	$l=0; 
        	$letra = $cadena2[ $k ]; 
       	 	$k++; 
    	} 
    	$l++; 
    	$nueva .=  $cadena1[ $n ] . $letra ; 
    	$letra = ''; 
	} 
	return $nueva; 
} 
function quitarcomas($quitarcom)
{
	return str_replace(',','',$quitarcom); 
		   
	 
	
}
function cambiar_fecha($fecha){
	$fecha=str_replace('/','-',$fecha);
	$arrfec=explode('-',$fecha);
	$nfecha=$arrfec[2].'-'.$arrfec[1].'-'.$arrfec[0];
	return $nfecha;
}

?>