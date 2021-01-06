<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
   	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
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
		<title>:: SPID- Presupuesto</title>
        <script type="text/javascript" src="css/programas.js"></script>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
<script>
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
 			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
				case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":
						document.form2.elimina.value=variable;
						//eli=document.getElementById(elimina);
						vvend=document.getElementById('elimina');
						//eli.value=elimina;
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){}
			function guardar()
			{
				var validacion01=document.getElementById('clasificacion').value;
				if (validacion01.trim()!='-1')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}

			function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
function adelante()
{
 //alert('entro'+document.form2.maximo.value);
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
	
document.form2.oculto.value=3;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
//document.form2.egreso.value=parseFloat(document.form2.egreso.value)+1;
//document.form2.action="teso-girarchequesver.php";
document.form2.submit();
}
else
{
	  // alert("Balance Descuadrado"+parseFloat(document.form2.maximo.value));
	}
	//alert('entro');
}
function atrasc()
{

//document.form2.oculto.value=2;
if(document.form2.ncomp.value>0)
 {

document.form2.oculto.value=3;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
//document.form2.egreso.value=document.form2.egreso.value-1;
//document.form2.action="teso-girarchequesver.php";
document.form2.submit();
 }
}
function validar(id)
			{
				document.form2.ncomp.value=id;
				document.form2.submit();
			}
</script>
<script>
	function iratras(scrtop, numpag, limreg, filtro){
		var idcta=document.getElementById('codigo').value;
		location.href="presu-cuentaspasivaexterno.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
       		<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
       	 	<tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a href="presu-cuentaspasivaexternoadd.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="presu-cuentaspasivaexterno.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
        	</tr>
        </table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
   <form action="" method="post" enctype="multipart/form-data" name="form2">
   <input type="hidden" name="pasa" id="pasa">
   <?php
   $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
   $estilo="";
   $uni="";
   if(empty($_POST[codigo])){
   $uni=obtenerUnidad($_GET[idcta]);
   
   }else{
   	$uni=obtenerUnidad($_POST[codigo]);

   }

   if($uni!=null && !empty($uni)){
   	 $estilo="style='background-color: #4FC3F7 !important' ";
   }
   function obtenerUnidad($cuenta){
   	global $vigusu;
   	$link=conectar_bd();
    $sql="SELECT unidad FROM pptocuentas WHERE cuenta='$cuenta' AND (vigencia='$vigusu' OR vigenciaf='$vigusu')";
   	$result=mysql_query($sql,$link);
   	$row=mysql_fetch_row($result);
   	return $row[0];
   }

   function actualizaUnidad($cuenta,$unidad){
   	$retorno="0";
   	global $vigusu,$linkbd;
   	$link=conectar_bd();
   	$sql="SELECT LENGTH(cuenta) FROM pptocuentas ORDER BY LENGTH(cuenta) ASC LIMIT 0,1";
   	$res=mysql_query($sql,$linkbd);
   	$fila=mysql_fetch_row($res);
   	$tamano=$fila[0];
   	if(strlen($cuenta)==$tamano){
   		$hijos="UPDATE pptocuentas SET unidad='$unidad' WHERE cuenta='$cuenta' AND (vigencia='$vigusu' OR vigenciaf='$vigusu') ";
   		mysql_query($hijos,$link);
   	}else{
   		$hijos="UPDATE pptocuentas SET unidad='$unidad' WHERE cuenta LIKE '$cuenta%' AND (vigencia='$vigusu' OR vigenciaf='$vigusu') ";
   		mysql_query($hijos,$link);
   	}
   	
   		return $retorno;

   }
  
    if($_POST[oculto]=='2') //**********guardar la configuracion de la cuenta
    {
		    $link=conectar_bd();
				
			$codpas=substr($_POST[codigo],0,1);
			$codpas=substr($_POST[codigo],0,1);
 			if($codpas=='R' || $codpas=='r')
					 {						
					//$codpas=substr($_POST[codigo],1,1);						  
					 }
		   $ret=actualizaUnidad($_POST[codigo],$_POST[unidad]);
		   switch ($_POST[clasificacion])
		    {
			 case 'funcionamiento':
				if($_POST[regalias]=='S'){
					$arrvig=explode('-',$_POST[vigenciarg]);
					$vigi=trim($arrvig[0]);
					$vigf=trim($arrvig[1]);
					$sqlr="UPDATE pptocuentasentidades SET nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futcodfun='$_POST[futcodfun]',futdependencias='$_POST[futdependencia]',futfuentefunc='$_POST[futfuentefunc]',codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]', nomina='$_POST[nomina]', clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]', vigencia='$vigi', vigenciaf='$vigf', unidad='$_POST[unidad]' WHERE  `cuenta`='".$_POST[codigo]."' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";
				}
				else{
					$sqlr="UPDATE pptocuentasentidades SET nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futcodfun='$_POST[futcodfun]',futdependencias='$_POST[futdependencia]',futfuentefunc='$_POST[futfuentefunc]',codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]', nomina='$_POST[nomina]', clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]',unidad='$_POST[unidad]' WHERE  `cuenta`='".$_POST[codigo]."' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";
				}
		    break;
			case 'deuda':
				if($_POST[regalias]=='S'){
					$arrvig=explode('-',$_POST[vigenciarg]);
					$vigi=trim($arrvig[0]);
					$vigf=trim($arrvig[1]);
					$sqlr="update pptocuentasentidades  set nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futcodfun='$_POST[futcoddeuda]',futtipodeuda='$_POST[futtipodeuda]',futtipooper='$_POST[futtipooper]', futfuenteinv='$_POST[futfuenteinv]' ,codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]', nomina='$_POST[nomina]' , clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]', vigencia='$vigi', vigenciaf='$vigf', unidad='$_POST[unidad]'  where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";	
				}
				else{
					$sqlr="update pptocuentasentidades  set nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futcodfun='$_POST[futcoddeuda]',futtipodeuda='$_POST[futtipodeuda]',futtipooper='$_POST[futtipooper]', futfuenteinv='$_POST[futfuenteinv]' ,codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]', nomina='$_POST[nomina]' , clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]',unidad='$_POST[unidad]'  where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";	
				}
			break;
			case 'inversion':
				if($_POST[regalias]=='S'){
					$arrvig=explode('-',$_POST[vigenciarg]);
					$vigi=trim($arrvig[0]);
					$vigf=trim($arrvig[1]);
					$sqlr="update pptocuentasentidades  set nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futinversion='$_POST[futinversion]', futfuenteinv='$_POST[futfuenteinv]' ,codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]' , nomina='$_POST[nomina]' , clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]', vigencia='$vigi', vigenciaf='$vigf',unidad='$_POST[unidad]' where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";
				}
				else{
					$sqlr="update pptocuentasentidades  set nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futinversion='$_POST[futinversion]', futfuenteinv='$_POST[futfuenteinv]' ,codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]' , nomina='$_POST[nomina]' , clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]',unidad='$_POST[unidad]' where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";
				}
			break;
			
			case 'sgr-gastos':
				if($_POST[regalias]=='S'){
					$arrvig=explode('-',$_POST[vigenciarg]);
					$vigi=trim($arrvig[0]);
					$vigf=trim($arrvig[1]);
					$sqlr="update pptocuentasentidades  set nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futinversion='$_POST[futinversion]', futfuenteinv='$_POST[futfuenteinv]' ,codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]' , nomina='$_POST[nomina]' , clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]', vigencia='$vigi', vigenciaf='$vigf'unidad='$_POST[unidad]' where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";
				}
				else{
					$sqlr="update pptocuentasentidades  set nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futinversion='$_POST[futinversion]', futfuenteinv='$_POST[futfuenteinv]' ,codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]' , nomina='$_POST[nomina]' , clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]',unidad='$_POST[unidad]' where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";
				}
			break;
			
			case 'reservas-gastos':
				if($_POST[regalias]=='S'){
					$arrvig=explode('-',$_POST[vigenciarg]);
					$vigi=trim($arrvig[0]);
					$vigf=trim($arrvig[1]);
					$sqlr="update pptocuentasentidades  set nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futinversion='$_POST[futinversion]', futfuenteinv='$_POST[futfuenteinv]' ,codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]' , nomina='$_POST[nomina]' , clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]', vigencia='$vigi', vigenciaf='$vigf',unidad='$_POST[unidad]' where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";
				}
				else{
					$sqlr="update pptocuentasentidades  set nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futinversion='$_POST[futinversion]', futfuenteinv='$_POST[futfuenteinv]' ,codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]' , nomina='$_POST[nomina]' , clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]', unidad='$_POST[unidad]' where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";
				}
			break;
			
			case 'R':
				if($_POST[regalias]=='S'){
					$arrvig=explode('-',$_POST[vigenciarg]);
					$vigi=trim($arrvig[0]);
					$vigf=trim($arrvig[1]);
					$sqlr="update pptocuentasentidades  set nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futinversion='$_POST[futinversion]', futfuenteinv='$_POST[futfuenteinv]' ,codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]' , nomina='$_POST[nomina]' , clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]', vigencia='$vigi', vigenciaf='$vigf', unidad='$_POST[unidad]' where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";		
				}
				else{
					$sqlr="update pptocuentasentidades  set nombre='".$_POST[nombre]."', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideforigen='$_POST[cgrorigen]',sideftercero='$_POST[cgrtercero]',sidefdest='$_POST[cgrdest]' ,sidefgasto='$_POST[cgrvigencia]',sidefgastofin='$_POST[cgrfinalidad]',sidefdep='$_POST[cgrdependencia]',sideffondos='$_POST[cgrsituacion]',futinversion='$_POST[futinversion]', futfuenteinv='$_POST[futfuenteinv]' ,codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]' , nomina='$_POST[nomina]' , clasificacion='$_POST[clasificacion]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]', unidad='$_POST[unidad]' where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";		
				}
			break;
		   }
		   	 //  echo $sqlr;

		 if (!mysql_query($sqlr,$link))
			{
		 		echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	 			echo "Ocurrió el siguiente problema:<br>";
		  	 	echo "<pre>";
     			echo "</pre></center></td></tr></table>";
				echo "$sqlr <br>";			 
			}
  		else
  		 	{
  		 		if($ret=="0"){
  		 			echo "<script>despliegamodalm('visible','1','Se ha Actualizado la Cuenta con Exito');</script>";	
			$sqlr="delete from pptocuentas_sectores where cuenta='$_POST[codigo]' and (vigenciai='$vigusu' or vigenciaf='$vigusu')";			
			mysql_query($sqlr,$link);
			$sqlr="insert into pptocuentas_sectores (cuenta,sector,vigenciai,vigenciaf) VALUES ('".$_POST[codigo]."','".$_POST[sectores]."','$vigusu','$vigusu')";
			mysql_query($sqlr,$link);
  		 		}else{
  		 			echo "<table><tr><td class='saludo1'><center><font color=blue>Ocurrio un problema<br><font size=1></font></font><br><p align=center><font color=red><b>La cuenta mayor asociada a este rubro tiene parametrizada la unidad. Debe dejar vacia la unidad de dicha cuenta</b></font></p>";
		  	 	echo "<pre>";
     			echo "</pre></center></td></tr></table>";
  		 		}
		  	

		  	}
}   
    if (!$_POST[oculto])
	 {
   		   $link=conectar_bd();
		   $sqlr="Select * from pptocuentasentidades  where estado='S'  and  (left(cuenta,1)>=2 OR (left(cuenta,1)='R' and substring(cuenta,2,1)>=2)) and vigencia='".$vigusu."' or vigenciaf=$vigusu  order by cuenta";
	 //echo "Oc:$_POST[oculto] -".$sqlr;
		 		$resp = mysql_query($sqlr,$link);
				$i=0;
				$copia=array();
				while ($row =mysql_fetch_row($resp)) 
					{						
					 $valor=$row[0];
					 $copia[]=$valor;
					 $_POST[todascuentas][]=$valor;
					 echo "<input type='hidden' name='todascuentas[]' value='$valor'>";	
					}		 
		//	echo "<br>Tamaño:".count($_POST[todascuentas]);		
		//	echo "<br>Tamaño2:".count($copia);					
   		   $npos=pos_en_array($_POST[todascuentas], $_GET[idcta]);
		 //  echo "<br>posicion:".$npos;
		    $_POST[maximo]=count($_POST[todascuentas]);
			 $_POST[ncomp]=$npos;
	   
  		   $sqlr="Select * from pptocuentasentidades  where estado='S' and cuenta='$_GET[idcta]' and (vigencia='$vigusu' or vigenciaf='$vigusu') order by cuenta";
		 		$resp = mysql_query($sqlr,$link);
				
				while ($row =mysql_fetch_row($resp)) 
					{
					 $_POST[codigo]=$row[0];
 					 $_POST[nombre]=$row[1];
					 $_POST[tipo]=$row[2];
 					 $_POST[tipoanterior]=$_GET[tipo];
 					 $_POST[estado]=$row[3];
					 $_POST[nomina]=$row[26];
					 $_POST[cgrclas]=$row[4];
 					 $_POST[cgrrecu]=$row[5];
 					 $_POST[cgrdest]=$row[7];
 					 $_POST[cgrtercero]=$row[8];
 				     $_POST[cgrorigen]=$row[6];
 				     $_POST[cgrvigencia]=$row[9];
 					 $_POST[cgrfinalidad]=$row[10];
 					 $_POST[cgrdependencia]=$row[11];
 				     $_POST[cgrsituacion]=$row[12];
 					 $_POST[concepago]=$row[23];	
			         $_POST[concecausa]=$row[24];	
					 $_POST[clasificacion]=$row[29];	
					 $_POST[regalias]=$row[37];					 					 										 
					 $_POST[vigenciarg]=$row[38];					 					 										
					 $_POST[unidad]=$row[39];
				     $_POST[ncuenta]=buscacuenta($_POST[cuenta]);
					$sqlr="select *from pptocuentas_sectores where  cuenta='$_GET[idcta]' and (vigenciai='$vigusu' or vigenciaf='$vigusu')";
					$resp2 = mysql_query($sqlr,$link);		
					$row2 =mysql_fetch_row($resp2);
					$_POST[sectores]=$row2[1]; 
					  $codpas=substr($_POST[codigo],0,1);
					$_POST[nomina]=$row[26];	
				
					 switch($_POST[clasificacion])
					 {	
					 case 'funcionamiento':
					 $_POST[futcodfun]=$row[14];
 					 $_POST[futdependencia]=$row[15];
 					 $_POST[futfuentefunc]=$row[16];
 					 
					 break;
					 case 'deuda':
					 
					 $_POST[futcoddeuda]=$row[14];
 					 $_POST[futtipodeuda]=$row[21];
 					 $_POST[futtipooper]=$row[20];
 					 $_POST[futfuenteinv]=$row[17];
 					 break;
					 
					 case 'inversion':
					 $_POST[futinversion]=$row[18];
 					 $_POST[futfuenteinv]=$row[17];
 					 
					 break;
					 }
					 }
		}
		if ($_POST[oculto]=='1')
		{
		 foreach($_POST[todascuentas] as $va)
		  {	
		  echo "<input type='hidden' name='todascuentas[]' value='$va'>";	 
		  }
		}
		if ($_POST[oculto]=='3' || $_POST[oculto]=='2' )
		{
		 foreach($_POST[todascuentas] as $va)
		  {	
		  echo "<input type='hidden' name='todascuentas[]' value='$va'>";	 
		  }
		  $link=conectar_bd();
		   $npos=$_POST[ncomp];
		  $sqlr="Select * from pptocuentasentidades  where estado='S' and cuenta='".$_POST[todascuentas][$npos]."' and (vigencia='".$vigusu."' or vigenciaf='$vigusu') order by cuenta";
		 		$resp = mysql_query($sqlr,$link);
			//	 echo "Oc:$sqlr";
				while ($row =mysql_fetch_row($resp)) 
					{
					 $_POST[codigo]=$row[0];
 					 $_POST[nombre]=$row[1];
					 $_POST[tipo]=$row[2];
 					 $_POST[tipoanterior]=$_GET[tipo];
 					 $_POST[estado]=$row[3];
					 $_POST[nomina]=$row[26];
					 $_POST[cgrclas]=$row[4];
 					 $_POST[cgrrecu]=$row[5];
 					 $_POST[cgrdest]=$row[7];
 					 $_POST[cgrtercero]=$row[8];
 				     $_POST[cgrorigen]=$row[6];
 				     $_POST[cgrvigencia]=$row[9];
 					 $_POST[cgrfinalidad]=$row[10];
 					 $_POST[cgrdependencia]=$row[11];
 				     $_POST[cgrsituacion]=$row[12];
 					 $_POST[concepago]=$row[23];	
			         $_POST[concecausa]=$row[24];	
					 $_POST[clasificacion]=$row[29];	
					 $_POST[regalias]=$row[37];					 					 														 
					 $_POST[vigenciarg]=$row[38];					 					 													 
				     $_POST[ncuenta]=buscacuenta($_POST[cuenta]);
					 $sqlr="select *from pptocuentas_sectores where  cuenta like '".$_POST[todascuentas][$npos]."' and (vigenciai='$vigusu' or vigenciaf='$vigusu')";
					$resp2 = mysql_query($sqlr,$link);		
					$row2 =mysql_fetch_row($resp2);
					//echo $sqlr;
					$_POST[sectores]=$row2[1]; 
					$codpas=substr($_POST[codigo],0,1);
					$_POST[nomina]=$row[26];	
				
					 switch(strtolower($_POST[clasificacion]))
					 {	
					 case 'funcionamiento':
					 $_POST[futcodfun]=$row[14];
 					 $_POST[futdependencia]=$row[15];
 					 $_POST[futfuentefunc]=$row[16];
 					 
					 break;
					 case 'deuda':
					 
					 $_POST[futcoddeuda]=$row[14];
 					 $_POST[futtipodeuda]=$row[21];
 					 $_POST[futtipooper]=$row[20];
 					 $_POST[futfuenteinv]=$row[17];
 					 break;
					 
					 case 'inversion':
					 $_POST[futinversion]=$row[18];
 					 $_POST[futfuenteinv]=$row[17];
 					 
					 break;
					 case 'sgr-gastos':
					 $_POST[futregalias]=$row[32]; 					
					 break;
					 case 'reservas-gastos':
					 $_POST[futreservas]=$row[30];
 					 $_POST[futfuenteinv]=$row[17]; 	
					 $_POST[futtipoacto]=$row[33]; 
					 $_POST[nacto]=$row[34]; 				 
					 $_POST[facto]=$row[35]; 					 
					 break;
					 }
					 }
		  
		}
		
		if($_POST[oculto]=='1' || $_POST[oculto]=='' || $_POST[oculto]=='3' || $_POST[oculto]=='2')
		 {
   		   $link=conectar_bd();
		   //*******verificacion de si tiene auxiliares debajo
		   $sqlr="select count(*) from pptocuentasentidades where $_POST[codigo]=left(cuenta,".strlen($_POST[codigo]).") and (vigencia=".$vigusu." or vigenciaf='$vigusu')";
		   //echo $sqlr;
		   $resp=mysql_query($sqlr,$link);
		   	while ($row =mysql_fetch_row($resp)) 
				{
				 $numero=$row[0];
				}
			if($numero>1 && $_POST[tipoanterior]=='Mayor' && 'Auxiliar'==$_POST[tipo])
			 {
			  echo "<script>alert('No se puede pasar a Auxiliar, existen cuentas dependiendo de esta cuenta ')</script>";
			  $_POST[tipo]=$_POST[tipoanterior];
			 }
  ?>
  <table class="inicio" width="99%">
  <?php
 //**** busca cuenta
  			if($_POST[bc]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
  			 ?>
    <tr >
      <td  colspan="11" class="titulos" >:. Editar Cuentas Gastos </td>
      <td class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
    </tr>
				<tr >
				  <td class="saludo1" >Codigo:</td>
				  <td  >
					<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
					<input name="ncomp" id="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"> 
					<input name="codigo" type="text" id="codigo" value="<?php echo $_POST[codigo]?>" size="20" readonly> 
					<a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
					<input type="hidden" value="a" name="atras" >
					<input type="hidden" value="s" name="siguiente" >
					<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
					<input name="oculto" type="hidden" id="oculto" value="1" ><input name="tipoanterior" type="hidden" id="tipoanterior" value="<?php echo $_POST[tipoanterior]?>" >			    
			      </td>
				  <td class="saludo1" >Nombre:</td>
				  <td  ><input name="nombre" type="text" size="70" value="<?php echo $_POST[nombre]?>"></td>
			    <td class="saludo1">.: Nomina:
        </td>
        <td><select name="nomina" id="nomina" >
          <option value="S" <?php if($_POST[nomina]=='S') echo "SELECTED"?>>S</option>
          <option value="N"<?php if($_POST[nomina]=='N') echo "SELECTED"?>>N</option>
        </select>    </td>
				  <td class="saludo1" >Tipo:</td>
				  <td  >
				  <select name="tipo" onChange="document.form2.submit();" style="width: 75%">
				  <option value="Auxiliar" <?php if($_POST[tipo]=='Auxiliar') echo "SELECTED"?>>Auxiliar</option>
  				  <option value="Mayor" <?php if($_POST[tipo]=='Mayor') echo "SELECTED"?>>Mayor</option>
				  </option>
				  </select>
				  </td></tr>
				  <tr>
                   <td class="saludo1">Clasificacion:
        </td>
        <td colspan="1"><select name="clasificacion" id="clasificacion" onChange="document.form2.submit()">
           <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from dominios where nombre_dominio like 'CLASIFICACION_RUBROS' and TIPO='G' order by descripcion_dominio ASC";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[2];
				echo "<option value='$row[2]' ";
				if(0==strcmp($i,$_POST[clasificacion]))
			 	{
				 echo "SELECTED";
				 }
				echo " >".strtoupper($row[2])."</option>";	  
			     }			
				?>        
        </select>    </td>   
		 <td class="saludo1">Sector:
        </td>
		<td  ><select name="sectores" id="sectores" onChange="">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from presusectores order by sector ASC";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if(0==strcmp($i,$_POST[sectores]))
			 	{
				 echo "SELECTED";
				 }
				echo " >".$row[0]."</option>";	  
			     }			
				?>
				  </select></td>
					<td class="saludo1">Regal&iacute;as:</td>
					<td>
						<select name="regalias" id="regalias" onChange="document.form2.submit()" >
							<option value="N" <?php if($_POST[regalias]=='N') echo "SELECTED"?>>N</option>
							<option value="S" <?php if($_POST[regalias]=='S') echo "SELECTED"?>>S</option>
						</select>    
					</td>
                    
                    <td class="saludo1" >.: Unidad:</td>
				  <td >
				  <select name="unidad" onChange="document.form2.submit();" <?php echo $estilo?> >
					<?php
						$sql="SELECT id_cc,UPPER(nombre ) FROM pptouniejecu WHERE estado='S' ";
						$res=mysql_query($sql,$linkbd);
						echo "<option value='' >Seleccione...</option>";
						while($row = mysql_fetch_row($res)){
							if($_POST[unidad]==$row[0]){
								echo "<option value='".$row[0]."' SELECTED>".$row[1]."</option>";
							}else{
								echo "<option value='".$row[0]."' >".$row[1]."</option>";
							}
							
						}
					?>
				  </select>
				  </td>
					<?php
					if($_POST[regalias]=='S'){
						echo'<td class="saludo1">Vigencia:</td>
						<td>
							<select name="vigenciarg" id="vigenciarg">';
								$sqlv="select * from dominios where nombre_dominio='VIGENCIA_RG' ORDER BY valor_inicial DESC";
								$resv = mysql_query($sqlv,$linkbd);
								while($wvig=mysql_fetch_array($resv)){
									echo'<option value="'.$wvig[0].' - '.$wvig[1].'">'.$wvig[0].' - '.$wvig[1].'</option>';
								}
							echo'</select>
						</td>';
					}
					?>
				  </tr>
				</table>
				<?php
				if ($_POST[tipo]=='Auxiliar')
				 {
				?>
				<table class="inicio" width="99%">
				<tr><td class="titulos2" colspan="5">Conceptos</td></tr>
				<tr >
				  <td  class="saludo1" >Concepto Pago:</td>
				  <td  ><select name="concepago" id="concepago" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from conceptoscontables  where modulo='3' and (tipo='N' or tipo='P') order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[concepago])
			 	{
				 echo "SELECTED";
				 }
				echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td  class="saludo1" >Concepto Causacion:</td>
				  <td   >
                  <select name="concecausa" id="concecausa" >
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from conceptoscontables  where modulo='3' and (tipo='C') order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[concecausa])
			 	{
				 echo "SELECTED";
				 }
				echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
			     }			
				?>
				  </select>  </td>
			    </tr>
				</table>
                <?php 
			if($_POST[bc]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cgrclas').focus();document.getElementById('cgrclas').select();</script>
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
			 ?>
				<div class="subpantallap">
				<table class="inicio" width="99%">				
			    <tr >
			      <td height="25" colspan="8" class="titulos2" >C.G.R.</td>
			    </tr>
				<tr >
				  <td class="saludo1" >Cod 	:</td>
				  <td  ><select name="cgrclas" id="cgrclas" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefclas  where nivel='D'  AND LEFT(codigo,1)>='2'order by codigo";

		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=trim($row[0]);
				echo "<option value='".trim($row[0])."' ";
				if($i==$_POST[cgrclas])
			 	{
				 echo "SELECTED";
				 $_POST[cgrclasnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Codigo nombre:</td>
				  <td  ><input name="cgrclasnom" type="text" size="80" value="<?php echo $_POST[cgrclasnom]?>"></td></tr>
				  <tr>
				  <td class="saludo1" >Recurso	:</td>
				  <td  ><select name="cgrrecu" id="cgrrecu" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefrecursos  where estado='S' order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value='".trim($row[0])."'";
				if($i==$_POST[cgrrecu])
			 	{
				 echo "SELECTED";
				 $_POST[cgrrecunom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Recurso nombre:</td>
				  <td  ><input name="cgrrecunom" type="text" size="80" value="<?php echo $_POST[cgrrecunom]?>"></td>
			    </tr>
				<tr>
				  <td class="saludo1" >Origen:</td>
				  <td  ><select name="cgrorigen" id="cgrorigen" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosideforigen order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value='".trim($row[0])."'";
				if($i==$_POST[cgrorigen])
			 	{
				 echo "SELECTED";
				 $_POST[cgrorigennom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Origen nombre:</td>
				  <td  ><input name="cgrorigennom" type="text" size="80" value="<?php echo $_POST[cgrorigennom]?>"></td>
			    </tr>										
				<tr >
				  <td class="saludo1" >Destinacion:</td>
				  <td  ><select name="cgrdest" id="cgrdest" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefdestinacion  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrdest])
			 	{
				 echo "SELECTED";
				 $_POST[cgrdestnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Destinacion nombre:</td>
				  <td  ><input name="cgrdestnom" type="text" size="80" value="<?php echo $_POST[cgrdestnom]?>"></td></tr>
					<tr>
				  <td class="saludo1" >Tercero:</td>
				  <td  ><select name="cgrtercero" id="cgrtercero" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefterceros order by codigo";

		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrtercero])
			 	{
				 echo "SELECTED";
				 $_POST[cgrterceronom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Tercero nombre:</td>
				  <td  ><input name="cgrterceronom" type="text" size="80" value="<?php echo $_POST[cgrterceronom]?>"></td>
			    </tr>
				<tr>
				  <td class="saludo1" >Vigencia:</td>
				  <td  ><select name="cgrvigencia" id="cgrvigencia" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefgasto order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrvigencia])
			 	{
				 echo "SELECTED";
				 $_POST[cgrvigencianom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Vigencia nombre:</td>
				  <td  ><input name="cgrvigencianom" type="text" size="80" value="<?php echo $_POST[cgrvigencianom]?>"></td>
			    </tr>								
  				<tr>
				  <td class="saludo1" >Finalidad:</td>
				  <td  ><select name="cgrfinalidad" id="cgrfinalidad" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefgastofin order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrfinalidad])
			 	{
				 echo "SELECTED";
				 $_POST[cgrfinalidadnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Finalidad nombre:</td>
				  <td  ><input name="cgrfinalidadnom" type="text" size="80" value="<?php echo $_POST[cgrfinalidadnom]?>"></td>
			    </tr>								
  				<tr>
				  <td class="saludo1" >Dependencia:</td>
				  <td  ><select name="cgrdependencia" id="cgrdependencia" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefdependencia order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrdependencia])
			 	{
				 echo "SELECTED";
				 $_POST[cgrdependencianom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Dependencia nombre:</td>
				  <td  ><input name="cgrdependencianom" type="text" size="80" value="<?php echo $_POST[cgrdependencianom]?>"></td>
			    </tr>								
  				<tr>
				  <td class="saludo1" >Situacion Fondos:</td>
				  <td  ><select name="cgrsituacion" id="cgrsituacion" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosideffondos order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[cgrsituacion])
			 	{
				 echo "SELECTED";
				 $_POST[cgrsituacionnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Situacion Fondos nombre:</td>
				  <td  ><input name="cgrsituacionnom" type="text" size="80" value="<?php echo $_POST[cgrsituacionnom]?>"></td>
			    </tr>								  			
			</table>			
			<?php
			 //*** 
			 	$codpas=substr($_POST[codigo],0,1);
 			if($codpas=='R' || $codpas=='r')
					 {						
					//$codpas=substr($_POST[codigo],1,1);						  
					 }

//			echo "cd".$codpas;
			 switch(strtolower($_POST[clasificacion]))
			  {
			   case 'funcionamiento':  //*****funcionamiento
			?>
				<table class="inicio" width="99%">				
			    <tr >
			      <td height="25" colspan="4" class="titulos2" >F.U.T.  - FUNCIONAMIENTO</td>
			    </tr>
				<tr >
				  <td class="saludo1" >Cod Funcionamiento:</td>
				  <td  ><select name="futcodfun" id="futcodfun" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutcodfun  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futcodfun])
			 	{
				 echo "SELECTED";
				 $_POST[futcodfunnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Cod nombre:</td>
				  <td  ><input name="futcodfunnom" type="text" size="80" value="<?php echo $_POST[futcodfunnom]?>"></td>
			    </tr>
				<tr>				
				  <td class="saludo1" >Unidad:</td>
				  <td  ><select name="futdependencia" id="futdependencia" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutdependencias  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futdependencia])
			 	{
				 echo "SELECTED";
				 $_POST[futdependencianom]=$row[1];
				 }
				echo " >".$row[0]."-".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
 				  <td class="saludo1" >Unidad nombre:</td>
				  <td  ><input name="futdependencianom" type="text" size="80" value="<?php echo $_POST[futdependencianom]?>"></td>
			    </tr>				
				<tr>				
				  <td class="saludo1" >Fuente Funcionamiento:</td>
				  <td  ><select name="futfuentefunc" id="futfuentefun" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutfuentefunc  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futfuentefunc])
			 	{
				 echo "SELECTED";
				 $_POST[futfuentefuncnom]=$row[1];
				 }
				echo " >".$row[0]."-".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
 				  <td class="saludo1" >Fuente func nombre:</td>
				  <td  ><input name="futfuentefuncnom" type="text" size="80" value="<?php echo $_POST[futfuentefuncnom]?>"></td>
			    </tr>				
  			</table>
			<?php 
			break;	
				 case 'deuda': //*** Deuda Publica
				 ?>
				 				<table class="inicio" width="99%">				
			    <tr >
			      <td height="25" colspan="4" class="titulos2" >F.U.T. - DEUDA PUBLICA</td>
			    </tr>
				<tr >
				  <td class="saludo1" >Cod Deuda:</td>
				  <td  ><select name="futcoddeuda" id="futcoddeuda" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutdeudas  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futcoddeuda])
			 	{
				 echo "SELECTED";
				 $_POST[futcoddeudanom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Cod nombre:</td>
				  <td  ><input name="futcoddeudanom" type="text" size="80" value="<?php echo $_POST[futcoddeudanom]?>"></td>
			    </tr>
				<tr>				
				  <td class="saludo1" >Tipo Deuda:</td>
				  <td  ><select name="futtipodeuda" id="futtipodeuda" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
				  <option value="1" <?php if($_POST[futtipodeuda]=='1') echo "SELECTED"?>>Interna</option>
  				  <option value="2" <?php if($_POST[futtipodeuda]=='2') echo "SELECTED"?>>Externa</option>
				  </select>
			      </td>
			    </tr>				
				<tr>				
				  <td class="saludo1" >Tipo Operacion:</td>
				  <td  ><select name="futtipooper" id="futtipooper" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofuttipooper  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futtipooper])
			 	{
				 echo "SELECTED";
				 $_POST[futtipoopernom]=$row[1];
				 }
				echo " >".$row[0]."-".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
 				  <td class="saludo1" >Tipo operacion nombre:</td>
				  <td  ><input name="futtipoopernom" type="text" size="80" value="<?php echo $_POST[futtipoopernom]?>"></td>
			    </tr>
				<tr>				
				  <td class="saludo1" >Fuente Inversion:</td>
				  <td  ><select name="futfuenteinv" id="futfuenteinv" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutfuenteinv  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futfuenteinv])
			 	{
				 echo "SELECTED";
				 $_POST[futfuenteinvnom]=$row[1];
				 }
				echo " >".$row[0]."-".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
 				  <td class="saludo1" >Fuente Inversion nombre:</td>
				  <td  ><input name="futfuenteinvnom" type="text" size="80" value="<?php echo $_POST[futfuenteinvnom]?>"></td>
			    </tr>
								
  			</table>
				 <?php
				 break;
				 case 'inversion':  //**** Inversion
				 ?>
				 				<table class="inicio" width="99%">				
			    <tr >
			      <td height="25" colspan="4" class="titulos2" >F.U.T. - INVERSION</td>
			    </tr>
				<tr >
				  <td class="saludo1" >Cod Inversion:</td>
				  <td  ><select name="futinversion" id="futinversion" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutinversion  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futinversion])
			 	{
				 echo "SELECTED";
				 $_POST[futinversionnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Cod Inversion nombre:</td>
				  <td  ><input name="futinversionnom" type="text" size="80" value="<?php echo $_POST[futinversionnom]?>"></td>
			    </tr>
				<tr>				
				  <td class="saludo1" >Fuente Inversion:</td>
				  <td  ><select name="futfuenteinv" id="futfuenteinv" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutfuenteinv  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futfuenteinv])
			 	{
				 echo "SELECTED";
				 $_POST[futfuenteinvnom]=$row[1];
				 }
				echo " >".$row[0]."-".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
 				  <td class="saludo1" >Fuente Inversion nombre:</td>
				  <td  ><input name="futfuenteinvnom" type="text" size="80" value="<?php echo $_POST[futfuenteinvnom]?>"></td>
			    </tr>				
  			</table>
				 <?php
				 break;
				  	  case "sgr-gastos":  //**** REGALIAS
				 ?>
				 				<table class="inicio" width="99%">				
			    <tr >
			      <td height="25" colspan="4" class="titulos2" >F.U.T. - INVERSION</td>
			    </tr>
				<tr >
				  <td class="saludo1" >Codigo Regalias:</td>
				  <td  ><select name="futregalias" id="futregalias" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from presusgrgas  order by codigo";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futregalias])
			 	{
				 echo "SELECTED";
				 $_POST[futregaliasnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Cod Inversion nombre:</td>
				  <td  ><input name="futregaliasnom" type="text" size="80" value="<?php echo $_POST[futregalaisnom]?>"></td>
			    </tr>
							
  			</table>
				 <?php
				 break;
				 
				 case 'reservas-gastos':  //**** Inversion
				 ?>
				 				<table class="inicio" width="99%">				
			    <tr >
			      <td height="25" colspan="4" class="titulos2" >F.U.T. - INVERSION</td>
			    </tr>
				<tr >
				  <td class="saludo1" >Cod Inversion:</td>
				  <td  ><select name="futinversion" id="futinversion" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutinversion  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futinversion])
			 	{
				 echo "SELECTED";
				 $_POST[futinversionnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Cod Inversion nombre:</td>
				  <td  ><input name="futinversionnom" type="text" size="80" value="<?php echo $_POST[futinversionnom]?>"></td>
			    </tr>
				<tr>				
				  <td class="saludo1" >Fuente Inversion:</td>
				  <td  ><select name="futfuenteinv" id="futfuenteinv" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutfuenteinv  order by codigo";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futfuenteinv])
			 	{
				 echo "SELECTED";
				 $_POST[futfuenteinvnom]=$row[1];
				 }
				echo " >".$row[0]."-".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
 				  <td class="saludo1" >Fuente Inversion nombre:</td>
				  <td  ><input name="futfuenteinvnom" type="text" size="80" value="<?php echo $_POST[futfuenteinvnom]?>"></td>
			    </tr>				
  			</table>
				 <?php
				 break;
			} //***** fin del switch
	echo "</div>";
	}
	 ?> 
</form>
<?php
  }//******fin del if  
?>
</td></tr>
<tr><td></td></tr>      
</table>
				 							<script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('¿Realmente desea cambiar la vigencia?');
   if(confirma){
    var anobloqueo=bloqueo.split("-");
    var ano=anobloqueo[0];
    if(valor < ano){
      if(confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar")){
        $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
      }else{
        location.reload();
      }

    }else{
      $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
    }
    
   }else{
   	location.reload();
   }
   
 });

 function updateresponse(data){
  json=eval(data);
  if(json[0].respuesta=='2'){
    alert("Vigencia modificada con exito");
  }else if(json[0].respuesta=='3'){
    alert("Error al modificar la vigencia");
  }
  location.reload();
 }
 function selectresponse(data){ 
  json=eval(data);
  $('#cambioVigencia').val(json[0].vigencia);
  bloqueo=json[0].bloqueo;
 }

 }); 
</script>
</body>
</html>