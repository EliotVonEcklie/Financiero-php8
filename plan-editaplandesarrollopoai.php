<?php
require"comun.inc";
require"funciones.inc";
session_start();
require"validaciones.inc";
require "conversor.php";
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$buscta=$_GET['buscta'];
	$ruta="'".$_GET['ruta']."'";
	//$vigfin="'".$_GET['vigfin']."'";
	$padret="'".$_GET['padre']."'";
	$vigini=$_GET['vigini'];
	$vigfin=$_GET['vigfin'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="css/programas.js"></script>
<script type="text/javascript" src="css/calendario.js"></script>
<script type="text/javascript" src="css/programas.js"></script>
<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
<title>:: Spid - Planeacion Estrategica</title>
<script>
	function guardar()
	{
		var validacion01=document.getElementById('nmeta').value;
		if (validacion01.trim()!='')
		{
			despliegamodalm('visible','4','Esta Seguro de Guardar','1');
		}
		else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
	}


			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if (document.getElementById('valfocus').value!="0")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('consecutivo').focus();
						document.getElementById('consecutivo').select();
					}
				}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.form2.submit();}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";
								document.form2.submit();break;
					case "2": 	document.form2.oculto.value="3";
								document.form2.submit();
								break;
				}
			}
			function despliegamodal2(_valor,ventana)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventana2').src="";
				}
				else {
					if(ventana==1){
						document.getElementById('ventana2').src="cuentasppto-ventana01.php?ti=2";
					}else if(ventana==2){
						document.getElementById('ventana2').src="cdp-reversar-ventana.php";
					}else if(ventana==3){
						document.getElementById('ventana2').src="contra-soladquisicionesproyectos.php";
					}
					
				}
			}
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value=2;
					document.form2.submit();
				}
			}
			
			function agregardetalle()
			{
				//document.form2.bc.value=2;
				if(document.form2.cuenta.value!="" &&  document.form2.fuente.value!="" && parseFloat(document.form2.valor.value) >=0 )
				{ 
						document.form2.agregadet.value=1;
						document.form2.submit();
				}
				else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
			}
			function cambiobotones1()
			{
				document.form2.oculto.value="5";
				//document.form2.submit();
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function cambiatab()
			{
				document.form2.oculto.value="4";
				document.form2.submit();
			}
</script>

		<script>
		jQuery(function($){ $('#valorvl').autoNumeric('init');});
			function iratras(scrtop, numpag, limreg, vigini, vigfin, padre, ruta){
				var idcta=document.getElementById('meta').value;
				location.href="plan-buscaplandesarrollopoai.php?idcta="+idcta+"&vigini="+vigini+"&vigfin="+vigfin+"&padret="+padre+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&ruta="+ruta;
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
	<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("plan");?></tr>
        <tr>
  <td colspan="3" class="cinta">
	<a href="#" class="mgbt"><img src="imagenes/add.png"  alt="Nuevo" border="0" /></a> 
	<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a> 
	<a href="plan-buscaplandesarrollo.php" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> 
	<a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
	<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $vigini; ?>, <?php echo $vigfin; ?>, <?php echo $padret; ?>, <?php echo $ruta; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
	</td>
</tr>
</table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>

<form name="form2" method="post"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
$linkbd=conectar_bd(); 
$_POST[vigenciai]=$vigini;
$_POST[vigenciaf]=$vigfin; 	
if($_POST[oculto]=="")
{
	$_POST[marquilla]='1';
	$_POST[meta]=$_GET[idproceso];	
	$vanterior=buscavariable_pd($_POST[meta],$_POST[vigenciai],$_POST[vigenciaf]);
	$_POST[nmeta]=$vanterior[1];			
	$_POST[anterior]=$vanterior[3];
	$vanterior=buscavariable_pd($_POST[anterior],$_POST[vigenciai],$_POST[vigenciaf]);
	$_POST[nombre]=$vanterior[1];	
	$_POST[tipo]=$_GET[tipo];		
	$_POST[ctipo]=tipos_pd($_POST[tipo]);	
	$_POST[tabgroup1]=1;
	
	$_POST[cuentaselim]= array();
	$_POST[vigenciaelim]= array();
	$_POST[dcuentas]= array(); 		 
	$_POST[dcfuentes]= array(); 		 
	$_POST[dgastos]= array(); 
	$_POST[vigenciafun]= array(); 
	$_POST[dfuentes]= array(); 
	$sqlr="select cuenta,valor,vigencia from  planfuentes where  meta='$_POST[meta]' and vigencia='$_POST[vigenciai]' ORDER BY CUENTA ";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd); 
	$cont=0;
	$_POST[vigtab]=$_POST[vigenciai];
	while ($row=mysql_fetch_row($res)) 
	{				
	$_POST[dcuentas][$cont]=$row[0];
	$_POST[dncuentas][$cont]=existecuentain($row[0]);
	$_POST[dgastos][$cont]=$row[1];
	$_POST[vigenciafun][$cont]=$row[2];
	$nfuente=buscafuenteppto($row[0],$vigusu);
	$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
	$_POST[dcfuentes][$cont]=$cdfuente;
	$_POST[dfuentes][$cont]=$nfuente;
	$cont=$cont+1;
	}
}
switch($_POST[tabgroup1])
{
	case 1:	$check1='checked';$_POST[vigtab]=$_POST[vigenciai];break;
	case 2:	$check2='checked';$_POST[vigtab]=$_POST[vigenciai]+1;break;
	case 3:	$check3='checked';$_POST[vigtab]=$_POST[vigenciai]+2;break;
	case 4:	$check4='checked';$_POST[vigtab]=$_POST[vigenciai]+3;break;
} 
if($_POST[oculto]==4)
{
	unset($_POST[dcuentas]);
	unset($_POST[vigenciafun]);
	unset($_POST[dncuentas]);
	unset($_POST[dgastos]);		 		 		 		 		 
	unset($_POST[dcfuentes]);		 		 
	unset($_POST[dfuentes]);		 
	$_POST[dcuentas]= array_values($_POST[dcuentas]); 
	$_POST[vigenciafun]= array_values($_POST[vigenciafun]); 
	$_POST[dncuentas]= array_values($_POST[dncuentas]); 
	$_POST[dgastos]= array_values($_POST[dgastos]); 
	$_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
	$_POST[dcfuentes]= array_values($_POST[dcfuentes]); 
	
	$sqlr="select cuenta,valor,vigencia from  planfuentes where  meta='$_POST[meta]' and vigencia='$_POST[vigtab]' ORDER BY CUENTA ";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd); 
	$cont=0;
	while ($row=mysql_fetch_row($res)) 
	{				
	$_POST[dcuentas][$cont]=$row[0];
	$_POST[dncuentas][$cont]=existecuentain($row[0]);
	$_POST[dgastos][$cont]=$row[1];
	$_POST[vigenciafun][$cont]=$row[2];
	$nfuente=buscafuenteppto($row[0],$vigusu);
	$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
	$_POST[dcfuentes][$cont]=$cdfuente;
	$_POST[dfuentes][$cont]=$nfuente;
	$cont=$cont+1;
	}
}

$medi=array();
if(count($_POST[mmetas])>0){
	for($i=0;$i<count($_POST[mmetas]);$i++){
		$medi[$i]=$_POST[mmetas][$i];
	}
}		
$cuanti=array();
if(count($_POST[vmetas])>0){
	for($i=0;$i<count($_POST[vmetas]);$i++){
		$cuanti[$i]=$_POST[vmetas][$i];
	}
}		
if($_POST[bc]!='')
			{
				//$tipo=substr($_POST[cuenta],0,1);			
			  	$nresul=buscacuentapres($_POST[cuenta],2);
			  	if($nresul!='')
			   	{
			  		$_POST[ncuenta]=$nresul;
			  		//$sqlr="select *from pptocuentaspptoinicial where cuenta='$_POST[cuenta]' and vigencia=".$_POST[vigencia];
 			  		$sqlr="select *from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or   vigenciaf=$vigusu)";
			  		$res=mysql_query($sqlr,$linkbd);
			  		$row=mysql_fetch_row($res);
			  		$_POST[valor]=0;		  
			  		//$_POST[saldo]=$row[6];	
			  		$vigenciai=$row[25];
			  		$clasifica=$row[29];
			  		//echo $_POST[cuenta].'  '.$vigenciai.'   '.$vigusu.'<br>';
			  		$vsal=generaSaldo($_POST[cuenta],$vigenciai,$vigusu);
			  		//echo '------------->'.$vsal.'<br>';
			  		$_POST[saldo]=$vsal;
			  		$_POST[calculado]="$".number_format(generaSaldo($_POST[cuenta],$vigenciai,$vigusu),2,',','.');
			  		$ind=substr($_POST[cuenta],0,1);
			  		//$reg=substr($_POST[cuenta],0,1);					  	
			 		$criterio="and (pptocuentas.vigencia=".$vigusu." or  pptocuentas.vigenciaf=$vigusu) ";
			 		if ($clasifica=='funcionamiento')
			  		{
			  			$sqlr="select pptocuentas.futfuentefunc,pptocuentas.pptoinicial,pptofutfuentefunc.nombre from pptocuentas,pptofutfuentefunc where pptocuentas.cuenta='$_POST[cuenta]'  and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
			 			$_POST[tipocuenta]=2;
						// echo $sqlr;
			  		}
			  		if ($clasifica=='deuda' )
			 		{
						$sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
			  			$_POST[tipocuenta]=3;
			 		}
			  		if ($clasifica=='inversion')
			  		{
						$sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
			  			$_POST[tipocuenta]=4;
			  		}
			  		if ($clasifica=='sgr-gastos')
			  		{
						$sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial from pptocuentas where pptocuentas.cuenta='$_POST[cuenta]'  ".$criterio;
			 			$_POST[tipocuenta]=6;
			  		}
			  		$res=mysql_query($sqlr,$linkbd);
			  		$row=mysql_fetch_row($res);
			      	if($row[1]!='' || $row[1]!=0)
			     	{
				 		$_POST[cfuente]=$row[0];
				  		$_POST[fuente]=buscafuenteppto($_POST[cuenta],$vigusu);
				  		$_POST[valor]=0;			  
				 	}
				 	else
				  	{
					 	$_POST[cfuente]="";
	  			   		$_POST[fuente]=""; 
				  		
				  	}  
			   	}
			  	else
			  	{
			  		$_POST[ncuenta]="";	
			   		$_POST[fuente]="";				   
			   		$_POST[cfuente]="";				   			   
			   		$_POST[valor]="";
			   		
			   	}
			}
?>
   <table class="inicio" >
   <tr>
     <td class="titulos" colspan="4">Datos Plan de Desarrollo</td><td class="cerrar" ><a href="plan-principal.php">Cerrar</a></td></tr>
     <tr><td class="saludo1">Codigo:</td><td ><input type="text" name="meta" id="meta" value="<?php echo $_POST[meta]?>" size="30" readonly></td>
     <td class="saludo1">Descripcion:</td><td ><input type="text" name="nmeta" id="nmeta" value="<?php echo $_POST[nmeta]?>" size="100" ></td>
     </tr>
     
   <tr><td class="saludo1">Tipo:</td><td><input name="tipo" type="hidden" value="<?php echo $_POST[tipo]?>" ><input name="ctipo" type="text" value="<?php echo $_POST[ctipo]?>" size="15" readonly></td><td class="saludo1">Nivel Anterior</td><td><input name="anterior" value="<?php echo $_POST[anterior]?>" size="20" readonly><input name="nombre" value="<?php echo $_POST[nombre]?>" size="80" readonly><input type="hidden" name="oculto" value="1"></td></tr>
   <tr>
   <td class="saludo1">Estado</td><td> <select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
          <option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
          <option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
        </select>
		</td>
        <td class="saludo1" style='width:10%'>Vigencia:</td>
        <td > 
						<input type="text" name="vigenciai" id="vigenciai" value="<?php echo $_POST[vigenciai]?>" style='width:10%' readonly> - 
						<input type="text" name="vigenciaf" id="vigenciaf" value="<?php echo $_POST[vigenciaf]?>" style='width:10%' readonly> 
                    </td>
   </tr>
   </table>   
   
    <?php
		echo'<table class="inicio">
			<tr>
				<td class="titulos">Tipo</td>';
				for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
				{
					echo "<td class='titulos'>Valor Programado $x<input type='hidden' name='vigenciasm[]' value='$x'></td>";
				}
			echo'</tr>
			<tr>
				<td>Medible</td>';
			$c=0;
			for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
			{
				$sqlk="select * from planmetasindicadores where codigo='$buscta' and tipo='M' and vigencia='$x'";
				$resk=mysql_query($sqlk, $linkbd);
				$rowk=mysql_fetch_array($resk);
				if($_POST[oculto]=="")
					$_POST[mmetas][$c]=$rowk[3];
				else
					$_POST[mmetas][$c]=$medi[$c];
				echo "<td>
					<input type='number' name='mmetas[]' value='".$_POST[mmetas][$c]."' onKeyPress='solonumeros(event)' min=0 placeholder='Valor Programado' style='text-align:center;'>
				</td>";
				$c+=1;
			}
		echo'</tr>
			<tr>
				<td>Cuantificable</td>';
			$c=0;
			for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++)
			{
				$sqlk="select sum(valor) from planfuentes where meta='$_POST[meta]' and vigencia='$x'";
				$resk=mysql_query($sqlk, $linkbd);
				$rowk=mysql_fetch_array($resk);
				$_POST[vmetas][$c]=$rowk[0];
				echo "<td>
					<input type='text' name='vmetas[]' value='".number_format($_POST[vmetas][$c],2)."' min=0  style='text-align:center;' readonly>
				</td>";
				$c+=1;
			}
		echo'</tr>
		</table>';
		?>
		<div class="tabsic" style="height:55%; width:99.6%;"> 
		<div class="tab" style="width:300px !important;margin-left:10%"> 			
			<input type="radio" id="tab-1" style="width:100%;" name="tabgroup1" value="1" <?php echo $check1;?> onClick="cambiatab();" >
			<label for="tab-1" style="padding-right:20% !important;padding-left:10% !important">Fuentes <?php echo $_POST[vigenciai]?></label> 
			<?php
				if($_POST[tabgroup1]=='1')
				{
			?>
                <div class="content" width="60%" style="overflow: scroll">
					<table class="inicio">
						<tr>
							<td class="titulos" colspan="7">Fuente para la vigencia <?php echo $_POST[vigenciai]?></td>
							<input type="hidden" name="marquilla" value="2">
						</tr>
						<tr>
							<td  class="saludo1">Cuenta:</td>
							<td style="width:15%"><input type="text" id="cuenta" name="cuenta" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" style="width:80%;"/><input type="hidden" value="" name="bc" id="bc">&nbsp;<img src="imagenes/find02.png" style="width:20px;cursor:pointer;" class="icobut" onClick="despliegamodal2('visible',1);" title="Listado de Cuentas"></td>
							<td colspan="3" style="width:30%"><input type="text" name="ncuenta" id="ncuenta"  value="<?php echo $_POST[ncuenta]?>" style="width:100%" readonly></td>
							<td class="saludo1" style="width:8%;">Fuente:</td>
							<td>
								<input type="text" name="fuente" id="fuente" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fuente] ?>" style="width:83%;"  readonly>
								<input type="hidden" name="cfuente" value="<?php echo $_POST[cfuente] ?>">
							</td>
						</tr>
						<tr> 
							<td class="saludo1">Valor:</td>
							<td>
								<input type="hidden" name="valor" id="valor" value="<?php echo $_POST[valor]?>" /> 
								<input type="text" name="valorvl" id="valorvl" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos2('valor','valorvl');return tabular(event,this);" value="<?php echo $_POST[valorvl]; ?>" style='width:80%;text-align:right;' />
							</td>		  
							<td class="saludo1">Saldo:</td>
							<td><input type="text" name="saldo"  id="saldo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" $state readonly>
							</td>
							<td>
								<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
								<input type="hidden" value="0" name="agregadet">
							</td>

						</tr> 
					</table>
					<table class="inicio" width="80%" >
                <tr><td class="titulos" colspan="6">Detalle Fuentes</td></tr>
                <tr>
                    <td class="titulos2" style="width:8%">Cuenta</td>
					<td class="titulos2" style="width:8%">Vigencia</td>
                    <td class="titulos2" style="width:20%">Nombre Cuenta</td>
                    <td class="titulos2">Fuente</td>
                    <td class="titulos2" style="width:12%">Valor</td>
                    <td class="titulos2" style="width:5%">Eliminar</td>
                </tr>
                <?php 
                    if ($_POST[oculto]=='3')
                    {
                        $posi=$_POST[elimina];
                        //echo "<TR><TD>ENTROS :".$_POST[elimina]." $posi</TD></TR>";
                        $cuentagas=0;
                        $cuentaing=0;
                        $diferencia=0;
                        // array_splice($_POST[dcuentas],$posi, 1);
						$_POST[cuentaselim][]=$_POST[dcuentas][$posi];
						$_POST[vigenciaelim][]=$_POST[vigenciafun][$posi];
                        unset($_POST[dcuentas][$posi]);
						unset($_POST[vigenciafun][$posi]);
                        unset($_POST[dncuentas][$posi]);
                        unset($_POST[dgastos][$posi]);		 		 		 		 		 
                        unset($_POST[dcfuentes][$posi]);		 		 
                        unset($_POST[dfuentes][$posi]);		 
                        unset($_POST[dmetas][$posi]);	
                        unset($_POST[dnmetas][$posi]);			 
                        $_POST[dcuentas]= array_values($_POST[dcuentas]); 
						$_POST[vigenciafun]= array_values($_POST[vigenciafun]); 
                        $_POST[dncuentas]= array_values($_POST[dncuentas]); 
                        $_POST[dgastos]= array_values($_POST[dgastos]); 
                        $_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
                        $_POST[dcfuentes]= array_values($_POST[dcfuentes]); 	
                        $_POST[dmetas]= array_values($_POST[dmetas]); 	
                        $_POST[dnmetas]= array_values($_POST[dnmetas]); 			 		 	 	
                        $_POST[elimina]='';	 		 		 		 
                    }	 
                    if ($_POST[agregadet]=='1')
                    {			
                        $ch=esta_en_array($_POST[dcuentas],$_POST[cuenta]);
                        if($ch!='1')
                        {			 
                            $cuentagas=0;
                            $cuentaing=0;
                            $diferencia=0;
                            $_POST[dcuentas][]=$_POST[cuenta];
							$_POST[vigenciafun][]=$_POST[vigenciai];
                            $_POST[dncuentas][]=$_POST[ncuenta];
                            $_POST[dfuentes][]=$_POST[fuente];
                            $_POST[dcfuentes][]=$_POST[cfuente];		 
                            $_POST[valor]=$_POST[valor];
                            $_POST[dgastos][]=$_POST[valor];
                            $_POST[dmetas][]=$_POST[codmet];		 
                            $_POST[dnmetas][]=$_POST[nommet];		 		 
                            $_POST[agregadet]=0;
                            echo"
                                <script>
                                    document.form2.cuenta.value='';
                                    //document.form2.meta.value='';	
                                    //document.form2.nmeta.value='';								
                                    document.form2.ncuenta.value='';
                                    document.form2.fuente.value='';
                                    document.form2.cfuente.value='';
                                    document.form2.valor.value=0;
                                    document.form2.valorvl.value='';	
                                    document.form2.saldo.value='';			
                                    document.form2.cuenta.focus();	
                                </script>";
                        }
                        else {echo"<script>despliegamodalm('visible','2','Ya existe este Rubro en el CDP');</script>";}
                    }
                ?>
                <input type='hidden' name='elimina' id='elimina'>
                <?php
                    // echo "<TR><TD>t :".count($_POST[dcuentas])."</TD></TR>";
					$co="saludo1a";
		  			$co2="saludo2";
                    for ($x=0;$x<count($_POST[dcuentas]);$x++)
                    {
                        echo "
                        <input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
						<input type='hidden' name='vigenciafun[]' value='".$_POST[vigenciafun][$x]."'/>
                        <input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
                        <input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'/>
                        <input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."'/>
                        <input type='hidden' name='dnmetas[]' value='".$_POST[dnmetas][$x]."'/>
                        <input type='hidden' name='dgastos[]' value='".$_POST[dgastos][$x]."'/>
                        <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
                            <td>".$_POST[dcuentas][$x]."</td>
							<td>".$_POST[vigenciafun][$x]."</td>
                            <td>".$_POST[dncuentas][$x]."</td>
                            <td>".$_POST[dfuentes][$x]."</td>
                            <td style='text-align:right;' onDblClick='llamarventana(this,$x)'>$ ".number_format($_POST[dgastos][$x],2,'.',',')."</td>
                            <td style='text-align:center;'><a style='cursor:pointer' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
                        </tr>";
						$aux=$co;
						$co=$co2;
		 				$co2=$aux;
                        //$cred= $vc[$x]*1;
                        $gas=$_POST[dgastos][$x];
                        //$cred=number_format($cred,2,".","");
                        //$deb=number_format($deb,2,".","");
                        $gas=$gas;
                        $cuentagas=$cuentagas+$gas;
                        $_POST[cuentagas2]=$cuentagas;
                        $total=number_format($total,2,",","");
                        $_POST[cuentagas]=number_format($cuentagas,2,".",",");
                        $resultado = convertir($_POST[cuentagas2]);
                        $_POST[letras]=$resultado." Pesos";
                    }
                    echo "
					<input type='hidden' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]'/>
					<input type='hidden' id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]'/>
					<input type='hidden' id='letras' name='letras' value='$_POST[letras]'/>
                    <tr class='$iter' style='text-align:right;'>
                        <td colspan='4'></td>
                        <td></td>
                    </tr>
                    <tr class='titulos2'>
						
					</tr>";
                ?>
            	</table>
				</div>
				<?php
				}
				?>
			</div>
			<div class="tab" style="width:300px !important;margin-left:0.1%"> 
		
			<input type="radio" id="tab-2" style="width:100%;" name="tabgroup1" value="2" <?php echo $check2;?> onClick="cambiatab();">
			<label for="tab-2" style="padding-right:20% !important;padding-left:10% !important">Fuentes <?php echo $_POST[vigenciai]+1?></label> 
			<?php
				if($_POST[tabgroup1]=='2')
				{
			?>
                <div class="content" style="overflow:hidden">
					<table class="inicio">
						<tr>
							<td class="titulos" colspan="7">Fuente para la vigencia <?php echo $_POST[vigenciai]+1?></td>
							<input type="hidden" name="marquilla" value="3">
						</tr>
						<tr>
							<td  class="saludo1">Cuenta:</td>
							<td style="width:15%"><input type="text" id="cuenta" name="cuenta" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" style="width:80%;"/><input type="hidden" value="" name="bc" id="bc">&nbsp;<img src="imagenes/find02.png" style="width:20px;cursor:pointer;" class="icobut" onClick="despliegamodal2('visible',1);" title="Listado de Cuentas"></td>
							<td colspan="3" style="width:30%"><input type="text" name="ncuenta" id="ncuenta"  value="<?php echo $_POST[ncuenta]?>" style="width:100%" readonly></td>
							<td class="saludo1" style="width:8%;">Fuente:</td>
							<td>
								<input type="text" name="fuente" id="fuente" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fuente] ?>" style="width:83%;"  readonly>
								<input type="hidden" name="cfuente" value="<?php echo $_POST[cfuente] ?>">
							</td>
						</tr>
						<tr> 
							<td class="saludo1">Valor:</td>
							<td>
								<input type="hidden" name="valor" id="valor" value="<?php echo $_POST[valor]?>" /> 
								<input type="text" name="valorvl" id="valorvl" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos2('valor','valorvl');return tabular(event,this);" value="<?php echo $_POST[valorvl]; ?>" style='width:80%;text-align:right;' />
							</td>		  
							<td class="saludo1">Saldo:</td>
							<td><input type="text" name="saldo"  id="saldo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" $state readonly>
							</td>
							
							<td>
								<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
								<input type="hidden" value="0" name="agregadet">
							</td>

						</tr> 
					</table>
					<table class="inicio" width="99%">
                <tr><td class="titulos" colspan="6">Detalle Fuentes</td></tr>
                <tr>
                    <td class="titulos2" style="width:8%">Cuenta</td>
					<td class="titulos2" style="width:8%">Vigencia</td>
                    <td class="titulos2" style="width:20%">Nombre Cuenta</td>
                    <td class="titulos2">Fuente</td>
                    <td class="titulos2" style="width:12%">Valor</td>
                    <td class="titulos2" style="width:5%">Eliminar</td>
                </tr>
                <?php 
                    if ($_POST[oculto]=='3')
                    { 
                        $posi=$_POST[elimina];
                        //echo "<TR><TD>ENTROS :".$_POST[elimina]." $posi</TD></TR>";
                        $cuentagas=0;
                        $cuentaing=0;
                        $diferencia=0;
                        // array_splice($_POST[dcuentas],$posi, 1);
						$_POST[cuentaselim][]=$_POST[dcuentas][$posi];
						$_POST[vigenciaelim][]=$_POST[vigenciafun][$posi];
                        unset($_POST[dcuentas][$posi]);
						unset($_POST[vigenciafun][$posi]);
                        unset($_POST[dncuentas][$posi]);
                        unset($_POST[dgastos][$posi]);		 		 		 		 		 
                        unset($_POST[dcfuentes][$posi]);		 		 
                        unset($_POST[dfuentes][$posi]);		 
                        unset($_POST[dmetas][$posi]);	
                        unset($_POST[dnmetas][$posi]);			 
                        $_POST[dcuentas]= array_values($_POST[dcuentas]); 
						$_POST[vigenciafun]= array_values($_POST[vigenciafun]); 
                        $_POST[dncuentas]= array_values($_POST[dncuentas]); 
                        $_POST[dgastos]= array_values($_POST[dgastos]); 
                        $_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
                        $_POST[dcfuentes]= array_values($_POST[dcfuentes]); 	
                        $_POST[dmetas]= array_values($_POST[dmetas]); 	
                        $_POST[dnmetas]= array_values($_POST[dnmetas]); 			 		 	 	
                        $_POST[elimina]='';	 		 		 		 
                    }	 
                    if ($_POST[agregadet]=='1')
                    {			
                        $ch=esta_en_array($_POST[dcuentas],$_POST[cuenta]);
                        if($ch!='1')
                        {			 
                            $cuentagas=0;
                            $cuentaing=0;
                            $diferencia=0;
                            $_POST[dcuentas][]=$_POST[cuenta];
							$_POST[vigenciafun][]=$_POST[vigenciai]+1;
                            $_POST[dncuentas][]=$_POST[ncuenta];
                            $_POST[dfuentes][]=$_POST[fuente];
                            $_POST[dcfuentes][]=$_POST[cfuente];		 
                            $_POST[valor]=$_POST[valor];
                            $_POST[dgastos][]=$_POST[valor];
                            $_POST[dmetas][]=$_POST[codmet];		 
                            $_POST[dnmetas][]=$_POST[nommet];		 		 
                            $_POST[agregadet]=0;
                            echo"
                                <script>
                                    document.form2.cuenta.value='';
                                    //document.form2.meta.value='';	
                                    //document.form2.nmeta.value='';								
                                    document.form2.ncuenta.value='';
                                    document.form2.fuente.value='';
                                    document.form2.cfuente.value='';
                                    document.form2.valor.value=0;
                                    document.form2.valorvl.value='';	
                                    document.form2.saldo.value='';			
                                    document.form2.cuenta.focus();	
                                </script>";
                        }
                        else {echo"<script>despliegamodalm('visible','2','Ya existe este Rubro en el CDP');</script>";}
                    }
                ?>
                <input type='hidden' name='elimina' id='elimina'>
                <?php
                    // echo "<TR><TD>t :".count($_POST[dcuentas])."</TD></TR>";
					$co="saludo1a";
		  			$co2="saludo2";
                    for ($x=0;$x<count($_POST[dcuentas]);$x++)
                    {
                        echo "
                        <input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
						<input type='hidden' name='vigenciafun[]' value='".$_POST[vigenciafun][$x]."'/>
                        <input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
                        <input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'/>
                        <input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."'/>
                        <input type='hidden' name='dnmetas[]' value='".$_POST[dnmetas][$x]."'/>
                        <input type='hidden' name='dgastos[]' value='".$_POST[dgastos][$x]."'/>
                        <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
                            <td>".$_POST[dcuentas][$x]."</td>
							<td>".$_POST[vigenciafun][$x]."</td>
                            <td>".$_POST[dncuentas][$x]."</td>
                            <td>".$_POST[dfuentes][$x]."</td>
                            <td style='text-align:right;' onDblClick='llamarventana(this,$x)'>$ ".number_format($_POST[dgastos][$x],2,'.',',')."</td>
                            <td style='text-align:center;'><a style='cursor:pointer' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
                        </tr>";
						$aux=$co;
						$co=$co2;
		 				$co2=$aux;
                        //$cred= $vc[$x]*1;
                        $gas=$_POST[dgastos][$x];
                        //$cred=number_format($cred,2,".","");
                        //$deb=number_format($deb,2,".","");
                        $gas=$gas;
                        $cuentagas=$cuentagas+$gas;
                        $_POST[cuentagas2]=$cuentagas;
                        $total=number_format($total,2,",","");
                        $_POST[cuentagas]=number_format($cuentagas,2,".",",");
                        $resultado = convertir($_POST[cuentagas2]);
                        $_POST[letras]=$resultado." Pesos";
                    }
                    echo "
					<input type='hidden' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]'/>
					<input type='hidden' id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]'/>
					<input type='hidden' id='letras' name='letras' value='$_POST[letras]'/>
                    <tr class='$iter' style='text-align:right;'>
                        <td colspan='4'>Total:</td>
                        <td>$ $_POST[cuentagas]</td>
                    </tr>
                    <tr class='titulos2'>
						<td>Son:</td>
						<td colspan='5'>$resultado</td>
					</tr>";
                ?>
            	</table>
				</div>
				<?php
					}
				?>
			</div>
			<div class="tab" style="width:300px !important;margin-left:0.1%"> 
			<input type="radio" id="tab-3" style="width:100%;" name="tabgroup1" value="3" <?php echo $check3;?> onClick="cambiatab();" >
			<label for="tab-3" style="padding-right:20% !important;padding-left:10% !important">Fuentes <?php echo $_POST[vigenciai]+2?></label> 
			<?php
				if($_POST[tabgroup1]=='3')
				{
			?>
                <div class="content" style="overflow:hidden">
					<table class="inicio">
						<tr>
							<td class="titulos" colspan="7">Fuente para la vigencia <?php echo $_POST[vigenciai]+2?></td>
							
						</tr>
						<tr>
							<td  class="saludo1">Cuenta:</td>
							<td style="width:15%"><input type="text" id="cuenta" name="cuenta" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" style="width:80%;"/><input type="hidden" value="" name="bc" id="bc">&nbsp;<img src="imagenes/find02.png" style="width:20px;cursor:pointer;" class="icobut" onClick="despliegamodal2('visible',1);" title="Listado de Cuentas"></td>
							<td colspan="3" style="width:30%"><input type="text" name="ncuenta" id="ncuenta"  value="<?php echo $_POST[ncuenta]?>" style="width:100%" readonly></td>
							<td class="saludo1" style="width:8%;">Fuente:</td>
							<td>
								<input type="text" name="fuente" id="fuente" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fuente] ?>" style="width:83%;"  readonly>
								<input type="hidden" name="cfuente" value="<?php echo $_POST[cfuente] ?>">
							</td>
						</tr>
						<tr> 
							<td class="saludo1">Valor:</td>
							<td>
								<input type="hidden" name="valor" id="valor" value="<?php echo $_POST[valor]?>" /> 
								<input type="text" name="valorvl" id="valorvl" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos2('valor','valorvl');return tabular(event,this);" value="<?php echo $_POST[valorvl]; ?>" style='width:80%;text-align:right;' />
							</td>		  
							<td class="saludo1">Saldo:</td>
							<td><input type="text" name="saldo"  id="saldo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" $state readonly>
							</td>
							<td>
								<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
								<input type="hidden" value="0" name="agregadet">
							</td>

						</tr> 
					</table>
					<table class="inicio" width="99%">
                <tr><td class="titulos" colspan="6">Detalle Fuentes</td></tr>
                <tr>
                    <td class="titulos2" style="width:8%">Cuenta</td>
					<td class="titulos2" style="width:8%">Vigencia</td>
                    <td class="titulos2" style="width:20%">Nombre Cuenta</td>
                    <td class="titulos2">Fuente</td>
                    <td class="titulos2" style="width:12%">Valor</td>
                    <td class="titulos2" style="width:5%">Eliminar</td>
                </tr>
                <?php 
                    if ($_POST[oculto]=='3')
                    { 
                        $posi=$_POST[elimina];
                        //echo "<TR><TD>ENTROS :".$_POST[elimina]." $posi</TD></TR>";
                        $cuentagas=0;
                        $cuentaing=0;
                        $diferencia=0;
                        // array_splice($_POST[dcuentas],$posi, 1);
						$_POST[cuentaselim][]=$_POST[dcuentas][$posi];
						$_POST[vigenciaelim][]=$_POST[vigenciafun][$posi];
                        unset($_POST[dcuentas][$posi]);
						unset($_POST[vigenciafun][$posi]);
                        unset($_POST[dncuentas][$posi]);
                        unset($_POST[dgastos][$posi]);		 		 		 		 		 
                        unset($_POST[dcfuentes][$posi]);		 		 
                        unset($_POST[dfuentes][$posi]);		 
                        unset($_POST[dmetas][$posi]);	
                        unset($_POST[dnmetas][$posi]);			 
                        $_POST[dcuentas]= array_values($_POST[dcuentas]); 
						$_POST[vigenciafun]= array_values($_POST[vigenciafun]); 
                        $_POST[dncuentas]= array_values($_POST[dncuentas]); 
                        $_POST[dgastos]= array_values($_POST[dgastos]); 
                        $_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
                        $_POST[dcfuentes]= array_values($_POST[dcfuentes]); 	
                        $_POST[dmetas]= array_values($_POST[dmetas]); 	
                        $_POST[dnmetas]= array_values($_POST[dnmetas]); 			 		 	 	
                        $_POST[elimina]='';	 		 		 		 
                    }	 
                    if ($_POST[agregadet]=='1')
                    {			
                        $ch=esta_en_array($_POST[dcuentas],$_POST[cuenta]);
                        if($ch!='1')
                        {			 
                            $cuentagas=0;
                            $cuentaing=0;
                            $diferencia=0;
                            $_POST[dcuentas][]=$_POST[cuenta];
							$_POST[vigenciafun][]=$_POST[vigenciai]+2;
                            $_POST[dncuentas][]=$_POST[ncuenta];
                            $_POST[dfuentes][]=$_POST[fuente];
                            $_POST[dcfuentes][]=$_POST[cfuente];		 
                            $_POST[valor]=$_POST[valor];
                            $_POST[dgastos][]=$_POST[valor];
                            $_POST[dmetas][]=$_POST[codmet];		 
                            $_POST[dnmetas][]=$_POST[nommet];		 		 
                            $_POST[agregadet]=0;
                            echo"
                                <script>
                                    document.form2.cuenta.value='';
                                    //document.form2.meta.value='';	
                                    //document.form2.nmeta.value='';								
                                    document.form2.ncuenta.value='';
                                    document.form2.fuente.value='';
                                    document.form2.cfuente.value='';
                                    document.form2.valor.value=0;
                                    document.form2.valorvl.value='';	
                                    document.form2.saldo.value='';			
                                    document.form2.cuenta.focus();	
                                </script>";
                        }
                        else {echo"<script>despliegamodalm('visible','2','Ya existe este Rubro en el CDP');</script>";}
                    }
                ?>
                <input type='hidden' name='elimina' id='elimina'>
                <?php
                    // echo "<TR><TD>t :".count($_POST[dcuentas])."</TD></TR>";
					$co="saludo1a";
		  			$co2="saludo2";
                    for ($x=0;$x<count($_POST[dcuentas]);$x++)
                    {
                        echo "
                        <input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
						<input type='hidden' name='vigenciafun[]' value='".$_POST[vigenciafun][$x]."'/>
                        <input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
                        <input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'/>
                        <input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."'/>
                        <input type='hidden' name='dnmetas[]' value='".$_POST[dnmetas][$x]."'/>
                        <input type='hidden' name='dgastos[]' value='".$_POST[dgastos][$x]."'/>
                        <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
                            <td>".$_POST[dcuentas][$x]."</td>
							<td>".$_POST[vigenciafun][$x]."</td>
                            <td>".$_POST[dncuentas][$x]."</td>
                            <td>".$_POST[dfuentes][$x]."</td>
                            <td style='text-align:right;' onDblClick='llamarventana(this,$x)'>$ ".number_format($_POST[dgastos][$x],2,'.',',')."</td>
                            <td style='text-align:center;'><a style='cursor:pointer' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
                        </tr>";
						$aux=$co;
						$co=$co2;
		 				$co2=$aux;
                        //$cred= $vc[$x]*1;
                        $gas=$_POST[dgastos][$x];
                        //$cred=number_format($cred,2,".","");
                        //$deb=number_format($deb,2,".","");
                        $gas=$gas;
                        $cuentagas=$cuentagas+$gas;
                        $_POST[cuentagas2]=$cuentagas;
                        $total=number_format($total,2,",","");
                        $_POST[cuentagas]=number_format($cuentagas,2,".",",");
                        $resultado = convertir($_POST[cuentagas2]);
                        $_POST[letras]=$resultado." Pesos";
                    }
                    echo "
					<input type='hidden' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]'/>
					<input type='hidden' id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]'/>
					<input type='hidden' id='letras' name='letras' value='$_POST[letras]'/>
                    <tr class='$iter' style='text-align:right;'>
                        <td colspan='4'>Total:</td>
                        <td>$ $_POST[cuentagas]</td>
                    </tr>
                    <tr class='titulos2'>
						<td>Son:</td>
						<td colspan='5'>$resultado</td>
					</tr>";
                ?>
            	</table>
				</div>
				<?php
					}
				?>
			</div>
			<div class="tab" style="width:300px !important;margin-left:0.1%"> 
			<input type="radio" id="tab-4" style="width:100%;" name="tabgroup1" value="4" <?php echo $check4;?> onClick="cambiatab();" >
			<label for="tab-4" style="padding-right:5% !important;padding-left:10% !important">Fuentes <?php echo $_POST[vigenciaf]?></label> 
			<?php
				if($_POST[tabgroup1]=='4')
				{
			?>
                <div class="content" style="overflow:hidden">
					<table class="inicio">
						<tr>
							<td class="titulos" colspan="7">Fuente para la vigencia <?php echo $_POST[vigenciaf]?></td>
						</tr>
						<tr>
							<td  class="saludo1">Cuenta:</td>
							<td style="width:15%"><input type="text" id="cuenta" name="cuenta" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" style="width:80%;"/><input type="hidden" value="" name="bc" id="bc">&nbsp;<img src="imagenes/find02.png" style="width:20px;cursor:pointer;" class="icobut" onClick="despliegamodal2('visible',1);" title="Listado de Cuentas"></td>
							<td colspan="3" style="width:30%"><input type="text" name="ncuenta" id="ncuenta"  value="<?php echo $_POST[ncuenta]?>" style="width:100%" readonly></td>
							<td class="saludo1" style="width:8%;">Fuente:</td>
							<td>
								<input type="text" name="fuente" id="fuente" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fuente] ?>" style="width:83%;"  readonly>
								<input type="hidden" name="cfuente" value="<?php echo $_POST[cfuente] ?>">
							</td>
						</tr>
						<tr> 
							<td class="saludo1">Valor:</td>
							<td>
								<input type="hidden" name="valor" id="valor" value="<?php echo $_POST[valor]?>" /> 
								<input type="text" name="valorvl" id="valorvl" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos2('valor','valorvl');return tabular(event,this);" value="<?php echo $_POST[valorvl]; ?>" style='width:80%;text-align:right;' />
							</td>		  
							<td class="saludo1">Saldo:</td>
							<td><input type="text" name="saldo"  id="saldo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" $state readonly>
							</td>
							<td>
								<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
								<input type="hidden" value="0" name="agregadet">
							</td>

						</tr> 
					</table>
					<table class="inicio" width="99%">
                <tr><td class="titulos" colspan="6">Detalle Fuentes</td></tr>
                <tr>
                    <td class="titulos2" style="width:8%">Cuenta</td>
					<td class="titulos2" style="width:8%">Vigencia</td>
                    <td class="titulos2" style="width:20%">Nombre Cuenta</td>
                    <td class="titulos2">Fuente</td>
                    <td class="titulos2" style="width:12%">Valor</td>
                    <td class="titulos2" style="width:5%">Eliminar</td>
                </tr>
                <?php 
                    if ($_POST[oculto]=='3')
                    { 
                        $posi=$_POST[elimina];
                        //echo "<TR><TD>ENTROS :".$_POST[elimina]." $posi</TD></TR>";
                        $cuentagas=0;
                        $cuentaing=0;
                        $diferencia=0;
						$_POST[cuentaselim][]=$_POST[dcuentas][$posi];
						$_POST[vigenciaelim][]=$_POST[vigenciafun][$posi];
                        // array_splice($_POST[dcuentas],$posi, 1);
                        unset($_POST[dcuentas][$posi]);
						unset($_POST[vigenciafun][$posi]);
                        unset($_POST[dncuentas][$posi]);
                        unset($_POST[dgastos][$posi]);		 		 		 		 		 
                        unset($_POST[dcfuentes][$posi]);		 		 
                        unset($_POST[dfuentes][$posi]);		 
                        unset($_POST[dmetas][$posi]);	
                        unset($_POST[dnmetas][$posi]);			 
                        $_POST[dcuentas]= array_values($_POST[dcuentas]); 
						$_POST[vigenciafun]= array_values($_POST[vigenciafun]); 
                        $_POST[dncuentas]= array_values($_POST[dncuentas]); 
                        $_POST[dgastos]= array_values($_POST[dgastos]); 
                        $_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
                        $_POST[dcfuentes]= array_values($_POST[dcfuentes]); 	
                        $_POST[dmetas]= array_values($_POST[dmetas]); 	
                        $_POST[dnmetas]= array_values($_POST[dnmetas]); 			 		 	 	
                        $_POST[elimina]='';	 		 		 		 
                    }	 
                    if ($_POST[agregadet]=='1')
                    {			
                        $ch=esta_en_array($_POST[dcuentas],$_POST[cuenta]);
                        if($ch!='1')
                        {			 
                            $cuentagas=0;
                            $cuentaing=0;
                            $diferencia=0;
                            $_POST[dcuentas][]=$_POST[cuenta];
							$_POST[vigenciafun][]=$_POST[vigenciaf];
                            $_POST[dncuentas][]=$_POST[ncuenta];
                            $_POST[dfuentes][]=$_POST[fuente];
                            $_POST[dcfuentes][]=$_POST[cfuente];		 
                            $_POST[valor]=$_POST[valor];
                            $_POST[dgastos][]=$_POST[valor];
                            $_POST[dmetas][]=$_POST[codmet];		 
                            $_POST[dnmetas][]=$_POST[nommet];		 		 
                            $_POST[agregadet]=0;
                            echo"
                                <script>
                                    document.form2.cuenta.value='';
                                    //document.form2.meta.value='';	
                                    //document.form2.nmeta.value='';								
                                    document.form2.ncuenta.value='';
                                    document.form2.fuente.value='';
                                    document.form2.cfuente.value='';
                                    document.form2.valor.value=0;
                                    document.form2.valorvl.value='';	
                                    document.form2.saldo.value='';			
                                    document.form2.cuenta.focus();	
                                </script>";
                        }
                        else {echo"<script>despliegamodalm('visible','2','Ya existe este Rubro en el CDP');</script>";}
                    }
                ?>
                <input type='hidden' name='elimina' id='elimina'>
                <?php
                    // echo "<TR><TD>t :".count($_POST[dcuentas])."</TD></TR>";
					$co="saludo1a";
		  			$co2="saludo2";
                    for ($x=0;$x<count($_POST[dcuentas]);$x++)
                    {
                        echo "
                        <input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
						<input type='hidden' name='vigenciafun[]' value='".$_POST[vigenciafun][$x]."'/>
                        <input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
                        <input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'/>
                        <input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."'/>
                        <input type='hidden' name='dnmetas[]' value='".$_POST[dnmetas][$x]."'/>
                        <input type='hidden' name='dgastos[]' value='".$_POST[dgastos][$x]."'/>
                        <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
                            <td>".$_POST[dcuentas][$x]."</td>
							<td>".$_POST[vigenciafun][$x]."</td>
                            <td>".$_POST[dncuentas][$x]."</td>
                            <td>".$_POST[dfuentes][$x]."</td>
                            <td style='text-align:right;' onDblClick='llamarventana(this,$x)'>$ ".number_format($_POST[dgastos][$x],2,'.',',')."</td>
                            <td style='text-align:center;'><a style='cursor:pointer' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
                        </tr>";
						$aux=$co;
						$co=$co2;
		 				$co2=$aux;
                        //$cred= $vc[$x]*1;
                        $gas=$_POST[dgastos][$x];
                        //$cred=number_format($cred,2,".","");
                        //$deb=number_format($deb,2,".","");
                        $gas=$gas;
                        $cuentagas=$cuentagas+$gas;
                        $_POST[cuentagas2]=$cuentagas;
                        $total=number_format($total,2,",","");
                        $_POST[cuentagas]=number_format($cuentagas,2,".",",");
                        $resultado = convertir($_POST[cuentagas2]);
                        $_POST[letras]=$resultado." Pesos";
                    }
                    echo "
					<input type='hidden' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]'/>
					<input type='hidden' id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]'/>
					<input type='hidden' id='letras' name='letras' value='$_POST[letras]'/>
                    <tr class='$iter' style='text-align:right;'>
                        <td colspan='4'>Total:</td>
                        <td>$ $_POST[cuentagas]</td>
                    </tr>
                    <tr class='titulos2'>
						<td>Son:</td>
						<td colspan='5'>$resultado</td>
					</tr>";
                ?>
            	</table>
				</div>
				<?php
					}
				?>
			</div>
			</div>    
 <?php  
 //********guardar
 if($_POST[oculto]=="2")
	{
		
		$sqlr="update presuplandesarrollo set nombre='$_POST[nmeta]' where id='$buscta'";	
		mysql_query($sqlr,$linkbd);
		//metas
			$sqld="delete from planmetasindicadores where codigo='$buscta'";
			mysql_query($sqld,$linkbd);
			$tam=count($_POST[vigenciasm]);	
			//MEDIBLES
			for($x=0;$x<$tam;$x++)
			{
				$maxid=selconsecutivo('planmetasindicadores','id');
				$sqlr="insert into planmetasindicadores (codigo,vigencia, descripcion, valorprogramado, valorejecutado, estado,tipo, id) values ('$buscta','".$_POST[vigenciasm][$x]."','".$_POST[descripcion]."','".$_POST[mmetas][$x]."','0','S','M', '".$maxid."')";	
				mysql_query($sqlr,$linkbd);
			}
			//CUANTIFICABLES
			for($x=0;$x<count($_POST[cuentaselim]);$x++)
			{
				$sqld="DELETE FROM planfuentes WHERE meta='$_POST[meta]' AND cuenta='".$_POST[cuentaselim][$x]."' AND vigencia='".$_POST[vigenciaelim][$x]."'";
				mysql_query($sqld,$linkbd);
			}
			
			for($i=0;$i<count($_POST[dcuentas]);$i++)
			{
				$sq="SELECT *FROM planfuentes WHERE cuenta='".$_POST[dcuentas][$i]."' AND meta='$_POST[meta]' AND vigencia='".$_POST[vigenciafun][$i]."'";
				$result=mysql_query($sq,$linkbd);
				$ro=mysql_fetch_row($result);
				if($ro[0]=='')
				{
					$sqlr="INSERT INTO planfuentes(cuenta,meta,fuente,valor,vigencia,area_responsable) VALUES('".$_POST[dcuentas][$i]."','$_POST[meta]','".$_POST[dcfuentes][$i]."','".$_POST[dgastos][$i]."','".$_POST[vigenciafun][$i]."','planeacion')";
					mysql_query($sqlr,$linkbd);
					echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
				}
			}
	}
 ?>
<div id="bgventanamodal2">
	<div id="ventanamodal2">
		<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
		</IFRAME>
	</div>
</div>
 </form>    
</body>
</html>