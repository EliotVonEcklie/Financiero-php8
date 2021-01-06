<?php //V 1000 12/12/16 ?> 
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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
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

function adelante(){
	//alert('entro'+document.form2.maximo.value);
	//document.form2.oculto.value=2;
	if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value)){
		document.form2.oculto.value=3;
		//document.form2.agregadet.value='';
		//document.form2.elimina.value='';
		document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
		//document.form2.egreso.value=parseFloat(document.form2.egreso.value)+1;
		//document.form2.action="teso-girarchequesver.php";
		document.form2.submit();
	}
	else{
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
</script>
<script>
	function iratras(scrtop, numpag, limreg, filtro){
		var idcta=document.getElementById('codigo').value;
		location.href="presu-cuentasactiva.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					<a href="presu-cuentasactivaadd.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a href="presu-cuentasactiva.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
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

	<?php
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
    $estilo="";
	if($_POST[oculto]=='2') //**********guardar la configuracion de la cuenta
	{
		$link=conectar_bd();
		   //*******verificacion de si tiene auxiliares debajo
//		   echo $sqlr;
		   //**** actualizacion de la cuenta
		actualizaUnidad($_POST[codigo],$_POST[unidad]);
		if($_POST[regalias]=='S'){
			$arrvig=explode('-',$_POST[vigenciarg]);
			$vigi=trim($arrvig[0]);
			$vigf=trim($arrvig[1]);
			$sqlr="update pptocuentas  set nombre='$_POST[nombre]', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideftercero='$_POST[cgrtercero]',sideforigen='$_POST[cgrorigen]',sidefdest='$_POST[cgrdest]', sideffondos='$_POST[cgrsituacion]' ,futcoding='$_POST[futcoding]',codconficontable='$_POST[concecont]', futsituacion='$_POST[situacion]' , clasificacion='$_POST[clasificacion]', futdest='$_POST[destinesp]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]', vigencia='$vigi', vigenciaf='$vigf',unidad='$_POST[unidad]' where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='".$vigusu."')";
		}
		else{
			$sqlr="update pptocuentas  set nombre='$_POST[nombre]', tipo='$_POST[tipo]',sidefclas='$_POST[cgrclas]',sidefrecur='$_POST[cgrrecu]',sideftercero='$_POST[cgrtercero]',sideforigen='$_POST[cgrorigen]',sidefdest='$_POST[cgrdest]', sideffondos='$_POST[cgrsituacion]' ,futcoding='$_POST[futcoding]',codconficontable='$_POST[concecont]', futsituacion='$_POST[situacion]' , clasificacion='$_POST[clasificacion]', futdest='$_POST[destinesp]', regalias='$_POST[regalias]', vigenciarg='$_POST[vigenciarg]',unidad='$_POST[unidad]' where  cuenta='$_POST[codigo]' and (vigencia='".$vigusu."' or vigenciaf='".$vigusu."')";
			
			$sq="SELECT *FROM futparametros WHERE cuenta='$_POST[codigo]' and vigencia='".$vigusu."'";
			$result=mysql_query($sq,$linkbd);
			$ro=mysql_fetch_row($result);
			if($ro[0]!='')
			{
				$srl="UPDATE futparametros SET codigo='".$_POST[fondosalud]."' WHERE cuenta='$_POST[codigo]'";
				mysql_query($srl,$linkbd);
			}
			else
			{
				$srl="INSERT INTO futparametros(cuenta,codigo,vigencia) VALUES ('$_POST[codigo]','".$_POST[fondosalud]."','".$vigusu."')";
				mysql_query($srl,$linkbd);
			}
		}
//		 echo $sqlr;
		 if (!mysql_query($sqlr,$link))
			{
		 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	
		 	$e =mysql_error($resp);
	 		echo "Ocurrió el siguiente problema:<br>";
//  	 echo htmlentities($e['message']);
		  	 echo "<pre>";
  //           echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     		echo "</pre></center></td></tr></table>";
			}
  			else
  		 	  {
		  		echo "<script>despliegamodalm('visible','1','Se ha Actualizado con Exito');</script>";				
		  	   }
    }
   
   
   // echo "Oc:$_POST[oculto] -";
    if (!$_POST[oculto])
	 {
		 $link=conectar_bd();		 
		 $sqlr="Select * from pptocuentas  where estado='S'  and (left(cuenta,1)='1' OR left(cuenta,2)='R1') and vigencia='".$vigusu."'  order by cuenta";//echo  $sqlr;
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
		//	  echo "<br>maximo:".count($_POST[todascuentas]);
  		   $sqlr="Select * from pptocuentas  where estado='S' and cuenta='$_GET[idcta]' and (vigencia='".$vigusu."' or vigenciaf=$vigusu) order by cuenta";
		   		 //echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
					{
					 $_POST[codigo]=$row[0];
 					 $_POST[nombre]=$row[1];
					 $_POST[tipo]=$row[2];
 					 $_POST[tipoanterior]=$_GET[tipo];
 					 $_POST[estado]=$row[3];
					 $_POST[cgrclas]=$row[4];
 					 $_POST[cgrclasnom]="";
					 $_POST[cgrrecu]=$row[5];
 					 $_POST[cgrrecunomb]="";
					  $_POST[cgrorigen]=$row[6];
					 $_POST[cgrorigennom]="";
					 $_POST[cgrdest]=$row[7];
 					 $_POST[cgrdestnom]="";
					 $_POST[cgrtercero]=$row[8];
 					 $_POST[cgrterceronom]="";
					 $_POST[cgrsituacion]=$row[12];
					 $_POST[cgrsituacionnom]="";
					 $_POST[futcoding]=$row[13];
 					 $_POST[futcodingnom]="";
					 $_POST[futrecurso]=$row[17];
 					 $_POST[futrecursonom]="";
					 $_POST[futdependencia]=$row[15];
 					 $_POST[futdependencianom]="";	
					 $_POST[concecont]=$row[22];
 					 $_POST[concecontnom]="";	
					 $_POST[situacion]=$row[19];					 					 													 
					 $_POST[clasificacion]=$row[29];					 					 													 
					 $_POST[regalias]=$row[37];					 					 													 
					 $_POST[vigenciarg]=$row[38];	
					 $_POST[unidad]=$row[39];				 					 													 
					}
		}
		if ($_POST[oculto]=='1')
		{
		 foreach($_POST[todascuentas] as $va)
		  {	
		  echo "<input type='hidden' name='todascuentas[]' value='$va'>";	 
		  }
		}
		if ($_POST[oculto]=='3' || $_POST[oculto]=='2')
		{
		 foreach($_POST[todascuentas] as $va)
		  {	
		  echo "<input type='hidden' name='todascuentas[]' value='$va'>";	 
		  }
		  
		 $link=conectar_bd();
		 $npos=$_POST[ncomp];
		 $sqlr="SELECT codigo FROM futparametros WHERE cuenta='".$_POST[todascuentas][$npos]."' AND vigencia='".$vigusu."' ORDER BY cuenta";
		   $result=mysql_query($sqlr,$link);
		   while($row=mysql_fetch_row($result))
		   {
			   $_POST[fondosalud]=$row[0];
			   $_POST[fondosaludnombre]="";
		   }
		 $sqlr="Select * from pptocuentas  where estado='S' and cuenta='".$_POST[todascuentas][$npos]."' and (vigencia='".$vigusu."' or vigenciaf=$vigusu) order by cuenta";
		 //echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
					{
					 $_POST[codigo]=$row[0];
 					 $_POST[nombre]=$row[1];
					 $_POST[tipo]=$row[2];
 					 //$_POST[tipoanterior]=$_GET[tipo];
 					 $_POST[estado]=$row[3];
					 $_POST[cgrclas]=$row[4];
 					 $_POST[cgrclasnom]="";
					 $_POST[cgrrecu]=$row[5];
 					 $_POST[cgrrecunomb]="";
					 $_POST[cgrdest]=$row[7];
 					 $_POST[cgrdestnom]="";
					 $_POST[cgrorigen]=$row[6];
					 $_POST[cgrorigennom]="";
					 $_POST[cgrtercero]=$row[8];
 					 $_POST[cgrterceronom]="";
					  $_POST[cgrsituacion]=$row[12];
					 $_POST[cgrsituacionnom]="";
					 $_POST[futcoding]=$row[13];
 					 $_POST[futcodingnom]="";
					 $_POST[futrecurso]=$row[17];
 					 $_POST[futrecursonom]="";
					 $_POST[futdependencia]=$row[15];
 					 $_POST[futdependencianom]="";	
					 $_POST[concecont]=$row[22];
 					 $_POST[concecontnom]="";	
					 $_POST[situacion]=$row[19];
					 $_POST[destinesp]=$row[36];					 					 													 
					 $_POST[regalias]=$row[37];					 					 													 
					 $_POST[vigenciarg]=$row[38];
					 $_POST[unidad]=$row[39];
					 					 					 													 
					}
		}
		
		if($_POST[oculto]=='1' || $_POST[oculto]=='' || $_POST[oculto]=='3' || $_POST[oculto]=='2')
		 {
   		   $link=conectar_bd();
		   //*******verificacion de si tiene auxiliares debajo
		   $sqlr="select count(*) from pptocuentas where $_POST[codigo]=left(cuenta,".strlen($_POST[codigo]).") (vigencia=".$vigusu." or vigenciaf=$vigusu)";
		   $resp=mysql_query($sqlr,$link);
//		   echo $sqlr;
		   	while ($row =mysql_fetch_row($resp)) 
				{
				 $numero=$row[0];
				}
			if($numero>1 && $_POST[tipoanterior]=='Mayor' && 'Auxiliar'==$_POST[tipo])
			 {
			  echo "<script>alert('No se puede pasar a Auxiliar, existen cuentas dependiendo de esta cuenta ')</script>";
			  $_POST[tipo]=$_POST[tipoanterior];
			 }
			 if($uni!=null && !empty($uni)){
   				 $estilo="style='background-color: #4FC3F7 !important' ";
   				}
  ?>
  <table class="inicio" width="99%">
    <tr >
      <td colspan="14" class="titulos" >:. Editar Cuentas Ingresos </td>
      <td class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
    </tr>
				<tr >
				  <td class="saludo1" >Codigo:</td>
				  <td  >
				  	<a href="#" onClick="atrasc()">
				  		<img src="imagenes/back.png" alt="anterior" align="absmiddle">
				  	</a> 
				  	<input name="ncomp" type="hidden" style="width:60%;" value="<?php echo $_POST[ncomp]?>"> 
				  	<input id="codigo" name="codigo" type="text" size="15" value="<?php echo $_POST[codigo]?>" readonly> 
				  	<a href="#" onClick="adelante()">
				  		<img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
				  		<input type="hidden" value="a" name="atras" >
				  		<input type="hidden" value="s" name="siguiente" >
				  		<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
			      		<input name="oculto" type="hidden" id="oculto" value="1" >
			      		<input name="tipoanterior" type="hidden" id="tipoanterior" value="<?php echo $_POST[tipoanterior]?>" >			    
			      </td>
				  <td class="saludo1" >Nombre:</td>
				  <td  ><input name="nombre" type="text" size="70" value="<?php echo $_POST[nombre]?>"></td>
			    
				  <td class="saludo1" >Tipo:</td>
				  <td  >
				  <select name="tipo" onChange="document.form2.submit();">
				  <option value="Auxiliar" <?php if($_POST[tipo]=='Auxiliar') echo "SELECTED"?>>Auxiliar</option>
  				  <option value="Mayor" <?php if($_POST[tipo]=='Mayor') echo "SELECTED"?>>Mayor</option>
				  </option>
				  </select>
				  </td>
					<td colspan="2">
						<select name="clasificacion" id="clasificacion" >
							<option value="-1">Seleccione ....</option>
							<?php
							$sqlr="Select * from dominios where nombre_dominio like 'CLASIFICACION_RUBROS' and TIPO='I' order by descripcion_dominio ASC";
							$resp = mysql_query($sqlr,$linkbd);
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
						</select>    
					</td>
					<td class="saludo1">Regal&iacute;as:</td>
					<td>
						<select name="regalias" id="regalias" onChange="document.form2.submit()" >
							<option value="N" <?php if($_POST[regalias]=='N') echo "SELECTED"?>>N</option>
							<option value="S" <?php if($_POST[regalias]=='S') echo "SELECTED"?>>S</option>
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
					 <td class="saludo1" >Unidad:</td>
				  <td >
				  <select name="unidad" onChange="document.form2.submit();" <?php echo $estilo?> >
				  <option value="" >Sin parametrizar</option>
				  <option value="central" <?php if($_POST[unidad]=='central') echo "SELECTED"?>>Central</option>
  				  <option value="concejo" <?php if($_POST[unidad]=='concejo') echo "SELECTED"?>>Concejo</option>
                  <option value="personeria" <?php if($_POST[unidad]=='personeria') echo "SELECTED"?>>Personeria</option>
				  </option>
				  </select>
				  </td>
				  </tr>
           
				</table>
				<?php
				if ($_POST[tipo]=='Auxiliar')
				 {
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
					 $sqlr="Select * from pptosidefclas  where nivel='D'  AND LEFT(codigo,1)='1'order by codigo";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
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
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
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
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
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
//			 echo $sqlr;
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
//			 echo $sqlr;
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
				  <td class="saludo1" >Situacion Fondos:</td>
				  <td  ><select name="cgrsituacion" id="cgrsituacion" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosideffondos order by codigo";
//			 echo $sqlr;
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
				<table class="inicio" width="99%">				
			    <tr >
			      <td height="25" colspan="4" class="titulos2" >F.U.T.</td>
			    </tr>
				<tr >
				  <td class="saludo1" >Cod 	:</td>
				  <td  ><select name="futcoding" id="futcoding" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutcoding  order by codigo";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futcoding])
			 	{
				 echo "SELECTED";
				 $_POST[futcodingnom]=$row[1];
				 }
				echo " >".$row[0]." - ".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
				  <td class="saludo1" >Cod nombre:</td>
				  <td  ><input name="futcodingnom" type="text" size="80" value="<?php echo $_POST[futcodingnom]?>"></td>
			    </tr>				
				<tr >
				  <td class="saludo1" >Situacion de Fondos:</td>
				  <td  ><select name="situacion" id="situacion" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
				  <option value="C" <?php if($_POST[situacion]=='C') echo "SELECTED"?>>Con Situacion</option>
  				  <option value="S" <?php if($_POST[situacion]=='S') echo "SELECTED"?>>Sin Situacion</option>
				  </select>
			      </td>
			    </tr>		
			    <tr >
				  <td class="saludo1" >Destinacion Especifica:</td>
				  <td  ><select name="destinesp" id="destinesp" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
				  <option value="TRUE" <?php if($_POST[destinesp]=='TRUE') echo "SELECTED"?>>Con Destinacion Especifica</option>
  				  <option value="FALSE" <?php if($_POST[destinesp]=='FALSE') echo "SELECTED"?>>Sin Destinacion Especifica</option>
				  </select>
			      </td>
			    </tr>
				<tr>
				 <td class="saludo1" >Codigo Fondo Salud Ejecucion:</td>
				 <td><select name="fondosalud" id="fondosalud" onChange="document.form2.submit();">
						<option value="-1">Seleccione ...</option>
						<?php
							$sqlr="SELECT *FROM fondosalud ORDER BY codigo";
							$result=mysql_query($sqlr,$link);
							while($row=mysql_fetch_row($result))
							{
								$i=$row[0];
								echo "<option value=$row[0] ";
								if($i==$_POST[fondosalud])
								{
									echo "SELECTED";
									$_POST[fondosaludnombre]=$row[1];
								}
								echo " >".$row[0]."-".substr($row[1],0,50)."</option>";
							}
						?>
						</select>
				 </td>		
				 <td class="saludo1">Fondo Salud Ejecucion Nombre:</td>
				 <td><input name="fondosaludnombre" type="text" size="80" value="<?php echo $_POST[fondosaludnombre] ?>"></td>
				 
				</tr>
  			</table>
			</div>
			<?php 	
}	 ?>
</form>
<?php
  }//******fin del if 
  
?>
</td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>