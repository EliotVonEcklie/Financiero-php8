<?php //V 1000 12/12/16 ?> 
<?php
error_reporting(0);
require "comun.inc";
require "funciones.inc";
require "conversor.php";
require_once "teso-funciones.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Contabilidad</title>

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
if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
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
	function respuestaconsulta(pregunta)
	{
		switch(pregunta)
		{
			case "1":	
				document.form2.oculto.value=2;
				document.form2.submit();
			break;
		}
	}

	function funcionmensaje()
	{
	}
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.fecha.value!='')
  {
	// if (confirm("Esta Seguro de Guardar"))
  	// {
  	// document.form2.oculto.value=2;
  	// document.form2.submit();
  	// }
	despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  }
  else{
  // alert('Faltan datos para completar el registro');
  	// document.form2.fecha.focus();
  	// document.form2.fecha.select();
  // }
  despliegamodalm('visible','2','Faltan datos para completar el registro');
}
}
</script>
<script language="JavaScript1.2">
function adelante()
{
//   alert("Balance Descuadrado");
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="cont-ordenactivacion-reflejar.php";
document.form2.submit();
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
document.form2.idcomp.value=document.form2.idcomp.value-1;
document.form2.action="cont-ordenactivacion-reflejar.php";
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
document.form2.action="cont-ordenactivacion-reflejar.php";
document.form2.submit();
}
</script>
<script src="css/programas.js"></script>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("cont");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a>
			<a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" /></a>
			<a href="cont-buscasinrecaudos-reflejar.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
			<a href="#" class="mgbt" onClick="guardar()"><img src="imagenes/reflejar1.png"  alt="Reflejar"  title="Reflejar" style="width:24px;" />
			<a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="Imprimir" title="Imprimir"/></a>
			<a href="cont-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" alt="atras" title="Atr&aacute;s"></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
//$vigencia=$vigusu;

$linkbd=conectar_bd();
$sqlr="select * from admbloqueoanio";
	$res=mysql_query($sqlr,$linkbd);
	$_POST[anio]=array();
	$_POST[bloqueo]=array();
	while ($row =mysql_fetch_row($res)){
	 	$_POST[anio][]=$row[0];
	 	$_POST[bloqueo][]=$row[1];
	}
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if($_GET[consecutivo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[consecutivo];</script>";}
	if(!$_POST[oculto])
	{
		$check1="checked";
		$fec=date("d/m/Y");	
		$link=conectar_bd();
		$sqlr="select * from acticrearact where tipo_mov='101' ORDER BY codigo DESC";
		$res=mysql_query($sqlr,$link);
		$r=mysql_fetch_row($res);
		$_POST[maximo]=$r[0];
		
		if ($_POST[codrec]!="" || $_GET[consecutivo]!=""){
			if($_POST[codrec]!=""){
                $sqlr="select * from acticrearact WHERE  tipo_mov='101' and codigo='$_POST[codrec]'";
			}
			else{
                $sqlr="select * from acticrearact WHERE  tipo_mov='101' and codigo='$_GET[consecutivo]'";
			}
		}
		else{
            $sqlr="select * from acticrearact where tipo_mov='101' ORDER BY codigo DESC";
		}
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$_POST[ncomp]=$r[0];
		$_POST[idcomp]=$r[0];
		$check1="checked"; 
		$fec=date("d/m/Y");		
	}
	
	$sqlr="select * from acticrearact where  tipo_mov='101' and codigo=".$_POST[idcomp];
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res)){
		$_POST[fecha]=$r[1];
		$consec=$r[0];	
		$_POST[ncomp]=$r[0];
		$_POST[rp]=$r[3];
	}
	//	$_POST[idcomp]=$consec;	
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	$_POST[fecha]=$fechaf;
	$_POST[vigencia]=$fecha[1];
	$linkbd=conectar_bd();
    $linkbd=conectar_bd();
    $sqlr="select *from acticrearact where tipo_mov='101' and acticrearact.codigo=$_POST[idcomp] ";
    $_POST[encontro]="";
    $res=mysql_query($sqlr,$linkbd);
    while ($row =mysql_fetch_row($res))
    {
        $_POST[concepto]="ORDEN DE ACTIVACION";	
        $_POST[fecha]=$row[1];
        ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
        $fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
        $_POST[fecha]=$fechaf;
        $_POST[vigencia]=$fecha[1];
        $_POST[valor]=$row[4];
        $_POST[numerocomp]=$row[0];
        if($row[5]=='S')
            $_POST[estadoc]='ACTIVO'; 	 				  
        if($row[5]=='R')
            $_POST[estadoc]='REVERSADO'; 	 				  
        if($row[5]=='N')
            $_POST[estadoc]='ANULADO'; 
    }
?>
<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
<form name="form2" method="post" action=""> 
<input type="hidden" name="anio[]" id="anio[]" value="<?php echo $_POST[anio] ?>">
<input type="hidden" name="anioact" id="anioact" value="<?php echo $_POST[anioact] ?>">
<input type="hidden" name="bloqueo[]" id="bloqueo[]" value="<?php echo $_POST[bloqueo] ?>">
<input type="hidden" name="cc" id="cc" value="<?php echo $_POST[cc] ?>">
	<table class="inicio" align="center" >
    	<tr>
       		<td class="titulos" colspan="10">Interfaz Orden de Activacion</td>
        	<td style="width:7%" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr  >
        	<td style="width:2.5cm" class="saludo1" >Consecutivo: </td>
        	<td style="width:10%">
            	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
                <input name="idcomp" type="text" style="width:50%" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()">
                <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
                <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
                <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" >
                <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
                <input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
          	</td>
	  		<td style="width:2.5cm" class="saludo1">Fecha: </td>
        	<td style="width:10%">
            	<input name="fecha" type="text"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fecha]?>" style="width:100%" readonly>        
          	</td>
         	<td style="width:2.5cm" class="saludo1">Vigencia:</td>
		  	<td style="width:10%">
            	<input type="text" id="vigencia" name="vigencia" style="width:100%" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly> 
           	</td>
            <td style="width:2.5cm" class="saludo1">Estado</td>
            <td style="width:10%" >
			<?php 
					if($_POST[estadoc]=="ACTIVO"){
						$valuees="ACTIVO";
						$stylest="width:100%; background-color:#0CD02A; color:white; text-align:center;";
					}else if($_POST[estadoc]=="ANULADO" || $_POST[estadoc]=="REVERSADO"){
						$valuees="ANULADO";
						$stylest="width:100%; background-color:#FF0000; color:white; text-align:center;";
					}else if($_POST[estadoc]=="PAGO"){
						$valuees="PAGO";
						$stylest="width:100%; background-color:#0404B4; color:white; text-align:center;";
					}

					echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
				?>
            	<input name="estadoc" type="hidden" id="estadoc" value="<?php echo $_POST[estadoc] ?>" style="width:100%" readonly>
           	</td>	
        </tr>
      	<tr>
        	<td  class="saludo1">Descripcion:</td>
        	<td colspan="7" >
            	<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%" readonly >
                <input type="hidden" value="1" name="oculto">
           	</td>
       	</tr>  
	  	<tr>
	        <td class="saludo1" width="101">Valor:</td>
           	<td>
               	<input name="valor" type="text" id="valor" onKeyUp="return tabular(event,this)" value="<?php echo number_format($_POST[valor],2,',','.')?>"  style="width:100%; text-align:right;" readonly >
          	</td>
      	</tr>
  	</table>
   	<div class="subpantalla">
    	<?php 
	   	$linkbd=conectar_bd();
        $sqlr="select *from acticrearact_det where tipo_mov='101' and acticrearact_det.codigo=$_POST[idcomp] ";
		$_POST[placa]= array();
        $_POST[um]= array();
        $_POST[valunitario]= array();
        $_POST[valtotal]= array(); 	 
  		$res=mysql_query($sqlr,$linkbd);
        while ($row =mysql_fetch_row($res))
        {
            $_POST[placa][]=$row[1];
            $_POST[nombre][]=$row[2];
            $_POST[fechaComp][]=$row[7];
			$_POST[valunitario][]=$row[15];
			$_POST[dcc1][]=$row[14];
			$_POST[ddispo][]=$row[30];
		}
  		?>
	   	<table class="inicio">
	   		<tr>
            	<td colspan="4" class="titulos">Detalle Orden de Activacion</td>
          	</tr>                  
			<tr>
            	<td class="titulos2">Placa</td>
                <td class="titulos2">Nombre</td>
                <td class="titulos2">Fecha Compra</td>
                <td class="titulos2">Valor</td>
          	</tr>
			<?php
		  	$_POST[totalc]=0;
			$iter='saludo1a';
			$iter2='saludo2';
		 	for ($x=0;$x<count($_POST[placa]);$x++){		 
			echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
					<td style='width:10%'>
						<input name='placa[]' value='".$_POST[placa][$x]."' type='hidden'>".$_POST[placa][$x]."
                    </td>
                    <td style='width:70%'>
						<input name='nombre[]' value='".$_POST[nombre][$x]."' type='hidden'><input name='dcc1[]' value='".$_POST[dcc1][$x]."' type='hidden'><input name='ddispo[]' value='".$_POST[ddispo][$x]."' type='hidden'>".$_POST[nombre][$x]."
					</td>
                    <td style='width:10%'>
						<input name='fechaComp[]' value='".$_POST[fechaComp][$x]."' type='hidden'>".$_POST[fechaComp][$x]."
                    </td>
					<td align='right'>
						<input name='valunitario[]' value='".$_POST[valunitario][$x]."' type='hidden'>".number_format($_POST[valunitario][$x],2,',','.')."
                    </td>
				</tr>";
		 		$_POST[totalc]=$_POST[totalc]+$_POST[valunitario][$x];
		 		$_POST[totalcf]=number_format($_POST[totalc],2);
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;	
		 	}
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 	echo "<tr class='titulos2'>
                <td></td>
                <td></td>
				<td>Total</td>
				<td align='right'>
                    <input name='totalcf' type='hidden' value='$_POST[totalcf]' readonly>
                    <input name='totalalm' type='hidden' value='$_POST[totalc]'>
					<input name='totalc' type='hidden' value='$_POST[totalc]'>".number_format($_POST[totalc],2,',','.')."
				</td>
			</tr>
			<tr class='titulos2'>
				<td>Son:</td>
				<td colspan='7'>
					<input name='letras' type='hidden' value='$_POST[letras]'>".strtoupper($_POST[letras])."
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
	$anioact=split("/", $_POST[fecha]);
	$_POST[anioact]=$anioact[2];
	//echo $anioact[2]." anio: ".count($_POST[anio]);
	for($x=0;$x<count($_POST[anio]);$x++)
	{
		if($_POST[anioact]==$_POST[anio][$x])
		{
			//echo "anio: ".$_POST[anio][$x]."<br>";
			if($_POST[bloqueo][$x]=='S')
			{
				$bloquear="S";
			}
			else
			{
				$bloquear="N";
			}
		}
	}
	//echo $bloquear;
	if($bloquear=="N")
	{
		/*	$p1=substr($_POST[fecha],0,2);
		$p2=substr($_POST[fecha],3,2);
		$p3=substr($_POST[fecha],6,4);
		$fechaf=$p3."-".$p2."-".$p1;	*/
		$linkbd=conectar_bd();
		$sqlr="select *from configbasica where estado='S'";
		//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res)) 
		{
		  	$nit=$row[0];
		  	$rs=$row[1];
	 	}
		$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
		
			//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
			//***busca el consecutivo del comprobante contable
			if ($_POST[estadoc]=='ANULADO')
			{
				$sqlr="update comprobante_cab set estado=0 where tipo_comp=70 and numerotipo=$_POST[idcomp]";
				mysql_query($sqlr,$linkbd);			
				$sqlr="update comprobante_det set valcredito=0, valcredito=0 where tipo_comp=70 and numerotipo=$_POST[idcomp]";
				mysql_query($sqlr,$linkbd);		
			}
			else
			{
				$sqlr="delete from comprobante_det where id_comp='70 $_POST[idcomp]'";
				mysql_query($sqlr,$linkbd);
				$sqlr="delete from comprobante_cab where tipo_comp='70' and numerotipo='$_POST[idcomp]'";
				mysql_query($sqlr,$linkbd);
				//echo $_POST[causacion];
                //$sqlr="update comprobante_det set tercero='$_POST[tercero]' where id_comp='11 $_POST[idcomp]'";
                //$sqlr="update comprobante_cab set estado=1 where tipo_comp=70 and numerotipo=$_POST[idcomp]";
                //mysql_query($sqlr,$linkbd);			
            
                //***cabecera comprobante
                //echo "<input type='hidden' name='ncomp' value='$idcomp'>";
                //******************* DETALLE DEL COMPROBANTE CONTABLE *********************
                //**** busqueda concepto contable*****
                for($x = 0; $x<count($_POST[placa]); $x++)
                {
                    $fechaBase = cambiarFormatoFecha($_POST[fecha]);
					$cuentaCredito = buscaCuentaContable('01','CT',$_POST[dcc1][$x],5,$fechaBase);
					if($cuentaCredito["cuenta"]!='')
					{
						/**** concepto contable */
						//$sqlr="insert into comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,numacti,cantarticulo) values ('70 $consec','".$cuentaCredito["cuenta"]."','".$nit."','".$_POST[cc]."','Cta Destino compra ".$origen."','',0,".$_POST[valor].",'$estadc','".$vigusu."')";

                    	$sql="INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('70 $_POST[idcomp]','".$cuentaCredito["cuenta"]."','".$nit."','".$_POST[dcc1][$x]."','$_POST[concepto]','0','".$_POST[valunitario][$x]."',1,'$_POST[anioact]','70','$_POST[idcomp]','".$_POST[placa][$x]."','1')";
                    	view($sql);
					}
					$sqlr="Select * from acti_activos_det where disposicion_activos='".$_POST[ddispo][$x]."' AND centro_costos='".$_POST[dcc1][$x]."' and tipo like '".substr($_POST[placa][$x],0,6)."'";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)) 
					{
						$sql="INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,numacti,cantarticulo) VALUES ('70 $_POST[idcomp]','".$row[3]."','".$nit."','".$_POST[dcc1][$x]."','$_POST[concepto]','".$_POST[valunitario][$x]."','0',1,'$_POST[anioact]','70','$_POST[idcomp]','".$_POST[placa][$x]."','1')";
						view($sql);
						//$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('70 $consec','".$row[3]."','".$nit."','".$_POST[cc]."','Cta Clasificacion Activo ".$_POST[clasificacion]."','',".$_POST[valor].",0,'$estadc','".$vigusu."')";
						//echo "$sqlr <br>";
						//mysql_query($sqlr,$linkbd);  				
					}
                    //COMPROBANTE CREDI
                   
							
                    
                }
                $sql="INSERT INTO comprobante_cab(numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) VALUES ('$_POST[idcomp]','70','$fechaf','$_POST[concepto]','0','".round($_POST[totalalm])."','".round($_POST[totalalm])."','0','1')";
                view($sql);
				echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recaudo con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
				?>
				<script>
					despliegamodalm('visible','1',"Se ha almacenado la Entrada de almacen con Exito");
					document.form2.numero.value="";
					document.form2.valor.value=0;
				</script>
				<?php 
			}	  
		
	}
	else
	{
		?>
		<script>
			//alert("¡No se puede reflejar por Bloqueo de Fecha!");
			despliegamodalm('visible','2',"No se puede reflejar por Cierre de Año");
		</script>
		<?php

	}
}
?>	
</form>
 </td></tr>
</table>
</body>
</html> 		