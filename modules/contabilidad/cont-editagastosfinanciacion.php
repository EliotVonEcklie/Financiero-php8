<!--V 1.0-->
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
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
		<title>:: Contabilidad</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('numero').value
				var validacion02=document.getElementById('nombre').value
				if (validacion01.trim()!='' && validacion02.trim()!='')
					{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.numero.focus();
					document.form2.numero.select();
				}
			}
			
			function agregardetalle()
			{
				if(document.getElementById('fecha1').value!='')
				{
					validacion01=document.getElementById('cuenta').value
					validacion02=document.getElementById('cc').value
					if(validacion01.trim()!='' && validacion02.trim()!=''){
						document.getElementById('oculto').value='9';
						document.form2.agregadet.value=1;
						document.form2.submit();
					}
					else {despliegamodalm('visible','2','Falta informaci�n para poder Agregar Detalle de Modalidad');}
				}
				else
				{
					alert('Falta digitar la Fecha');
				}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar el Detalle de Modalidad','2');
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
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
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje()
			{document.location.href = "contra-modalidadedita.php?idproceso="+document.getElementById('codigo').value;}

			function respuestaconsulta(estado,pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";
								document.form2.submit();break;
					case "2":	document.getElementById('oculto').value='9';
								document.form2.submit();break;
				}
				document.form2.submit();
			}

			function buscacta(e){
				
				if (document.form2.cuenta.value!=""){
					document.form2.bc.value='1';
					document.getElementById('oculto').value='9';
					document.form2.submit();
					
				}
			}

			function validar(){
				document.getElementById('oculto').value='9';
				document.form2.submit();
			}	
        </script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('numero').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('numero').value=next;
					var idcta=document.getElementById('numero').value;
					document.form2.action="presu-editaconcecontablescausa.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('numero').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('numero').value=prev;
					var idcta=document.getElementById('numero').value;
					document.form2.action="presu-editaconcecontablescausa.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}

			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('numero').value;
				location.href="presu-buscaconcecontablescausa.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
function validar3(formulario)
			{
				document.form2.action="presu-editaconcecontablescausa.php";
				document.form2.submit();
			}
			
			function despliegamodal2(_valor,v)
			{
				if (document.form2.fecha1.value!='')
				{
					document.getElementById("bgventanamodal2").style.visibility=_valor;
					if(_valor=="hidden"){
						document.getElementById('ventana2').src="";
						document.form2.submit();
					}
					else {
						if(v==1){
							document.getElementById('ventana2').src="cuentasin-ventana1.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==2)
						{
							document.getElementById('ventana2').src="cuentas-ventana2.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==3)
						{
							document.getElementById('ventana2').src="cuentas-ventana3.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==4)
						{
							document.getElementById('ventana2').src="cuentas-ventana4.php?fecha="+document.form2.fecha1.value;
						}
					}
				}
				else
				{
					alert ("Falta digitar la fehca");
				}
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
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("cont");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a href="cont-gastosfinanciacion.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="cont-buscagastosfinanciacion.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
        	</tr>
        </table>
<?php
		$linkbd=conectar_bd();
		if ($_GET[is]!=""){echo "<script>document.getElementById('codrec').value=$_GET[is];</script>";}
		$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from conceptoscontables where conceptoscontables.tipo='C' and conceptoscontables.modulo='3' ORDER BY CONVERT(codigo, SIGNED INTEGER)";
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$_POST[minimo]=$r[0];
		$_POST[maximo]=$r[1];
		if($_POST[oculto]==""){
			if ($_POST[codrec]!="" || $_GET[is]!=""){
				if($_POST[codrec]!=""){
					$sqlr="select *from conceptoscontables where codigo='$_POST[codrec]' and conceptoscontables.tipo='C' and conceptoscontables.modulo='3'";
				}
				else{
					$sqlr="select *from conceptoscontables where codigo ='$_GET[is]' and conceptoscontables.tipo='C' and conceptoscontables.modulo='3'";
				}
			}
			else{
				$sqlr="select * from  conceptoscontables where conceptoscontables.tipo='C' and conceptoscontables.modulo='3' ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";
			}
			$res=mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($res);
		   	$_POST[numero]=$row[0];
			$_POST[almacen]=$row[4];
			
		}

		if(($_POST[oculto]!="2")&&($_POST[oculto]!="9")){
			$sqlr="select * from conceptoscontables where conceptoscontables.codigo=$_POST[numero] and conceptoscontables.tipo='C' and conceptoscontables.modulo='3' ";
			$res=mysql_query($sqlr,$linkbd); 
			$cont=0;
			while($row=mysql_fetch_row($res)){
				$_POST[nombre]=$row[1];
				$_POST[numero]=$row[0];
				$_POST[almacen]=$row[4];
				$cont=$cont+1;
			}
		}

		if(($_POST[oculto]!="2")&&($_POST[oculto]!="9")){
			unset($_POST[dcuentas]);
			unset($_POST[dncuentas]);
			unset($_POST[dccs]);
			unset($_POST[dcreditos]);		 		 		 		 		 
			unset($_POST[ddebitos]);	
			unset($_POST[fecha]);	 
			unset($_POST[fecha1]);
			unset($_POST[cuenta]);
			unset($_POST[ncuenta]); 
			$sqlr="select  * from conceptoscontables_det where conceptoscontables_det.codigo=$_POST[numero]  and conceptoscontables_det.tipo='C' and conceptoscontables_det.cuenta<>'' and conceptoscontables_det.modulo='3' order by conceptoscontables_det.fechainicial desc";
			$res=mysql_query($sqlr,$linkbd); 
			$cont=0;
			while ($row=mysql_fetch_assoc($res)){
				$_POST[dcuentas][$cont]=$row["cuenta"];
				$_POST[dccs][$cont]=$row["cc"];
				$_POST[dncuentas][$cont]=buscacuenta($row["cuenta"]);
				$_POST[ddebitos][$cont]=$row["debito"];
				$_POST[dcreditos][$cont]=$row["credito"];
				$_POST[fecha][$cont]=$row["fechainicial"];
				$cont=$cont+1;
			}
		}

		//NEXT
		$sqln="select *from conceptoscontables WHERE codigo > '$_POST[numero]' and conceptoscontables.tipo='C' and conceptoscontables.modulo='3' ORDER BY codigo ASC LIMIT 1";
		$resn=mysql_query($sqln,$linkbd);
		$row=mysql_fetch_row($resn);
		$next="'".$row[0]."'";
		//PREV
		$sqlp="select *from conceptoscontables WHERE codigo < '$_POST[numero]' and conceptoscontables.tipo='C' and conceptoscontables.modulo='3' ORDER BY codigo DESC LIMIT 1";
		$resp=mysql_query($sqlp,$linkbd);
		$row=mysql_fetch_row($resp);
		$prev="'".$row[0]."'";

?>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 <form name="form2" method="post" action=""> 
<?php //**** busca cuenta
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
    <table class="inicio" align="center"  >
      <tr >
        <td class="titulos" colspan="8">.: Editar Concepto Contable de Gasto </td>
        <td width="61" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
		<td width="119" class="saludo1">Codigo:</td>
       	<td style="width:15%" valign="middle" >
   	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
          	<input type="text" id="numero" name="numero" style="width:60%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();">
            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
			<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
			<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
			<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
			<input type="hidden" value="<?php echo $_POST[defecto]?>" name="defecto" id="defecto">
       	</td>
		 <td width="119" class="saludo1">Nombre:</td>
          <td width="160" valign="middle" ><input type="text" id="nombre" name="nombre" size="50" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td><td class="saludo1" width="110">Tipo:</td><td style="width: 8%"><input name="tipo" value="Gasto" size="10" type="text"><input name="tipoc" value="C" size="10" type="hidden"></td><td class="saludo1" width="110" style="text-align: center">Almacen:</td><td><input name="almacen" id="almacen"  type="checkbox" style="max-height: 15px" <?php if(!empty($_POST[almacen])){echo "checked "; }?> ></td>
	    </tr>
    </table>
	<table class="inicio">
	<tr><td colspan="6" class="titulos2">Crear Detalle Concepto</td></tr>
	<tr>
			<td class="saludo1" style="width:10%">Fecha Inicial:</td>
			<td style="width:10%;">
				<input name="fecha1" type="text" id="fecha1" title="YYYY-MM-DD" style="width:75%;" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha1');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
			</td>  
			<td class="saludo1">Cuenta: </td>
          <td  valign="middle" >
			<input name="cuenta" id="cuenta" type="text"  value="<?php echo $_POST[cuenta]?>" onKeyUp="return tabular(event,this) " style="width:75%;" onBlur="buscacta(event)"><input type="hidden" value="" name="bc" id="bc">
				<input name="cuenta_" type="hidden" value="<?php echo $_POST[cuenta_]?>">&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',1);" title="Buscar cuenta" class="icobut" />
		  </td><td ><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="85" readonly></td>
	</tr>
	<tr>
	<td class="saludo1">Tipo:</td><td><select style="width:90%;" name="debcred">
		   <option value="1" <?php if($_POST[debcred]=='1') echo "SELECTED"; ?>>Debito</option>
		  </select></td>
		  <td class="saludo1">CC:</td><td>
	<select name="cc" id="cc" style="width:85%;" onChange="validar()" onKeyUp="return tabular(event,this)">
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from centrocosto where estado='S' ORDER BY ID_CC";
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
		  <td><input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet">
		  <?php
		if (!$_POST[oculto])
		 {
		 ?>
		<script>
    	//document.form2.cc.focus();
		</script>	
		<?php
		}
		
		if($_POST[bc]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('debcred').focus();</script>
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
	 //*** centro  costo
			 if($_POST[bcc]=='1')
			 {
			  $nresul=buscacentro($_POST[cc]);
			  if($nresul!='')
			   {
			  $_POST[ncc]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuenta').focus();document.getElementById('cuenta').select();</script>
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
		  <input type="hidden" value="0" name="oculto" id="oculto">	
		  </td>
	
        </tr>
	<tr>
	
	</tr>
	<tr>
	
	</tr>
	</table>
    <div class="subpantalla" style="height:52%; width:99.6%; overflow-x:hidden;">
	<table class="inicio">
	<tr><td class="titulos" colspan="7">Detalle Concepto</td></tr>
	<tr><td class="titulos2">Fecha</td><td class="titulos2">CC</td><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Debito</td><td class="titulos2">Credito</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
	<?php
	if ($_POST[elimina]!='')
		 { 
			
		 $posi=$_POST[elimina];
		 unset($_POST[dcuentas][$posi]);
 		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dccs][$posi]);
		 unset($_POST[fecha][$posi]);
		 unset($_POST[dcreditos][$posi]);		 		 		 		 		 
		 unset($_POST[ddebitos][$posi]); 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 $_POST[fecha]= array_values($_POST[fecha]);
		 $_POST[dcreditos]= array_values($_POST[dcreditos]); 
		 $_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
	
		
		 }
	if ($_POST[agregadet]=='1')
		 {
		  $cuentacred=0;
		  $cuentadeb=0;
		  $diferencia=0;
		 $_POST[dcuentas][]=$_POST[cuenta];
		 $_POST[dncuentas][]=$_POST[ncuenta];
		 $_POST[dccs][]=$_POST[cc];
		 $_POST[fecha][]=$_POST[fecha1];
		 if ($_POST[debcred]==1)
		  {
		  $_POST[dcreditos][]='N';
		  $_POST[ddebitos][]="S";
	 	  }
		 else
		  {
		  $_POST[dcreditos][]='S';
		  $_POST[ddebitos][]="N";
		  }
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.cc.select();
				document.form2.cc.value="";
		 </script>
		 <?php
		 }
		 $iter='saludo1a';
		 $iter2='saludo2';
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
		<td><input name='fecha[]' value='".$_POST[fecha][$x]."' type='text' size='8' readonly class='inpnovisibles'></td>
		<td><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='2' readonly class='inpnovisibles'></td>
		<td><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='8' readonly class='inpnovisibles'></td>
		<td><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='70' readonly class='inpnovisibles'></td>
		<td><input name='ddebitos[]' value='".$_POST[ddebitos][$x]."' type='text' size='3' onDblClick='llamarventanadeb(this,$x)' readonly class='inpnovisibles'></td>
		<td><input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text' size='3' onDblClick='llamarventanacred(this,$x)' readonly class='inpnovisibles'></td>
		<td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $aux=$iter;
		 $iter=$iter2;
		 $iter2=$aux;
		 }	 
		 ?>
	<tr></tr>
	</table>

	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2')	
		{
			$almacen="N";
			
			if(!empty($_POST[almacen])){
				$almacen="S";
			}
			elseif($_POST[almacen]=='')
			{
				$almacen="";
			}
		 //**** crear el detalle del concepto
		 $linkbd=conectar_bd();
		$sqlr="delete from conceptoscontables_det where codigo='".$_POST[numero]."' and tipo='$_POST[tipoc]' and modulo ='3'";	
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from conceptoscontables where codigo='".$_POST[numero]."' and tipo='$_POST[tipoc]' and modulo ='3'";	 
		mysql_query($sqlr,$linkbd);
		
		$sqlr="insert into conceptoscontables (codigo,nombre,modulo,tipo,almacen) values ('$_POST[numero]','$_POST[nombre]',3,'$_POST[tipoc]','$almacen')";
		//echo $sqlr;
		if(!mysql_query($sqlr,$linkbd))
		 {
		   echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado con Exito El Concepto Contable, Error: $sqlr </center></td></tr></table>";
		 }
		 else
		 {
		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado con Exito El Concepto Contable</center></td></tr></table>";
		 }
		for($x=0;$x<count($_POST[dcuentas]);$x++) 
		 {
		   ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha][$x],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		  $sqlr="insert into conceptoscontables_det (codigo,tipo,tipocuenta,cuenta,cc,debito,credito,estado,modulo,fechainicial) values ('$_POST[numero]','$_POST[tipoc]','N','".$_POST[dcuentas][$x]."','".$_POST[dccs][$x]."','".$_POST[ddebitos][$x]."','".$_POST[dcreditos][$x]."','S','3','".$_POST[fecha][$x]."')";
		  $res=mysql_query($sqlr,$linkbd);
		 }
	   }
	?>	
</div>
</form>
<script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('�Realmente desea cambiar la vigencia?');
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
<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
</body>
</html>