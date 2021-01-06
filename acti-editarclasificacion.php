<!--V 1.0 24/02/2015-->
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
		<title>:: Spid - Activos Fijos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>

<script>
	function guardar(){
		if (document.form2.numero.value!='' && document.form2.nombre.value!=''){
			despliegamodalm('visible','4','Esta Seguro de Guardar los Cambios','1');
		}
		else{
			despliegamodalm('visible','2','Faltan datos para Modificar los Datos');
			document.form2.numero.focus();document.form2.numero.select();
		}
	}

	function agregardetalle(){
		if(document.form2.cc.value!=""){
			document.form2.agregadet.value=1;
			document.getElementById('oculto').value='7';
			document.form2.submit();
		 }
		 else {
			 despliegamodalm('visible','2','Faltan datos para Agregar el Registro');
		}
	}

	function eliminar(variable){
		document.getElementById('elimina').value=variable;
		despliegamodalm('visible','4','Esta Seguro de Eliminar el Registro','2');
	}

	function despliegamodalm(_valor,_tip,mensa,pregunta){
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden"){document.getElementById('ventanam').src="";}
		else{
			switch(_tip){
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

	function funcionmensaje(){}

	function respuestaconsulta(pregunta){
		switch(pregunta){
			case "1":	document.getElementById('oculto').value='2';document.form2.submit();break;
			case "2":	document.getElementById('oculto').value='6';
						document.form2.submit();break;
		}
	}

	function buscacta(objeto){
		if(objeto=='1'){
			if (document.form2.cuentadeb.value!=""){
				document.form2.bcd.value='1';
				document.getElementById('oculto').value='7';
				document.form2.submit();
			}
		}
		if(objeto=='2'){
			if (document.form2.cuentacred.value!=""){
				document.form2.bccr.value='1';
				document.getElementById('oculto').value='7';
				document.form2.submit();
			}
		}
		if(objeto=='3'){
			if (document.form2.cuentact.value!=""){
				document.form2.bca.value='1';
				document.getElementById('oculto').value='7';
				document.form2.submit();
			}
		}
		if(objeto=='4'){
			if (document.form2.cuentaper.value!=""){
				document.form2.bcp.value='1';
				document.getElementById('oculto').value='7';
				document.form2.submit();
			}
		}
	}

	function buscacc(e){
		if (document.form2.cc.value!=""){
			document.form2.bcc.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}

	function validar(){
		document.getElementById('oculto').value='7';
		document.form2.submit();
	}

	function deprec(){
		var campo = document.getElementById('agedep');
		if (document.form2.deprecia.checked==true){campo.readOnly=true;}
		else{campo.readOnly=false;document.form2.agedep.value=0;}
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
					document.form2.action="acti-editarclasificacion.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="acti-editarclasificacion.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('numero').value;
				location.href="acti-buscaclasificacion.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
	<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
    <tr><?php menu_desplegable("acti");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="acti-clasificacion.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
			<a href="acti-buscaclasificacion.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>
</table>
<?php
$vigencia=date(Y);
$linkbd=conectar_bd();
 ?>	
<?php
			if ($_GET[is]!=""){echo "<script>document.getElementById('codrec').value=$_GET[is];</script>";}
			$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from acticlasificacion ORDER BY CONVERT(codigo, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[is]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from acticlasificacion where codigo='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from acticlasificacion where codigo ='$_GET[is]'";
					}
				}
				else{
					$sqlr="select * from  acticlasificacion ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[numero]=$row[0];
			}
		
 			if(($_POST[oculto]!="2")&&($_POST[oculto]!="6")&&($_POST[oculto]!="7")){	
				$linkbd=conectar_bd();
				$sqlr="Select *from acticlasificacion where codigo=$_POST[numero]";
				$res=mysql_query($sqlr,$linkbd);
				//echo $sqlr;
				while($row=mysql_fetch_row($res))
				  {
				   $_POST[numero]=$row[0];
				   $_POST[nombre]=$row[1];
				   $_POST[deprecia]=$row[2];
				   $_POST[agedep]=$row[3];   
				 $_POST[estado]=$row[4];      
				 $chk="";
				 if($_POST[deprecia]=='S')
				 $chk='checked';
				  }
			}

		if(($_POST[oculto]!="6")&&($_POST[oculto]!="7")){	
		 	unset($_POST[dcuentasdeb]);
 		 	unset($_POST[dncuentasdeb]);
		 	unset($_POST[dcuentascred]);
 		 	unset($_POST[dncuentascred]);
		  	unset($_POST[dcuentasper]);
 		 	unset($_POST[dncuentasper]);
		  	unset($_POST[dcuentasact]);
 		 	unset($_POST[dncuentasact]);		 
		 	unset($_POST[dccs]);		 	 
 			$sqlr="Select *from acticlasificacion_det where codigo=$_POST[numero]";
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			while($row=mysql_fetch_row($res)){
			   	$_POST[dcuentasdeb][]=$row[2];
			   	$_POST[dcuentascred][]=$row[3];
			   	$_POST[dcuentasact][]=$row[4];      
			   	$_POST[dcuentasper][]=$row[5];  
			   	$_POST[dncuentasdeb][]=buscacuenta($row[2]);
			   	$_POST[dncuentascred][]=buscacuenta($row[3]);
			   	$_POST[dncuentasact][]=buscacuenta($row[4]);      
			   	$_POST[dncuentasper][]=buscacuenta($row[5]);       
			   	$_POST[dccs][]=$row[6];   
				$_POST[estado]=$row[7];      
			} 
		}
			//NEXT
			$sqln="select *from acticlasificacion WHERE codigo > '$_POST[numero]' ORDER BY codigo ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from acticlasificacion WHERE codigo < '$_POST[numero]' ORDER BY codigo DESC LIMIT 1";
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
  			if($_POST[bcd]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentadeb]);
			  if($nresul!='')
			   {
			  $_POST[ncuentadeb]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
			 if($_POST[bccr]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentacred]);
			  if($nresul!='')
			   {
			  $_POST[ncuentacred]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
			 if($_POST[bca]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentact]);
			  if($nresul!='')
			   {
			  $_POST[ncuentact]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
			 if($_POST[bcp]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentaper]);
			  if($nresul!='')
			   {
			  $_POST[ncuentaper]=$nresul;
  	
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
		<tr>
			<td class="titulos" colspan="9" style='width:90%'>.: Clasificacion</td>
			<td  class="cerrar" style='width:10%'><a href="acti-principal.php">&nbsp;&nbsp;Cerrar</a></td>
		</tr>
		<tr>
			<td class="saludo1" style='width:10%'>Codigo:</td>
          	<td style='width:10%'>
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
            	<input type="text" id="numero" name="numero"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();" style='width:60%'>
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
           	</td>
		 	<td class="saludo1" style='width:10%'>Nombre:</td>
          	<td style='width:36%'><input type="text" id="nombre" name="nombre" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();" style='width:95%'></td>
          	<td class="saludo1" style='width:10%'>No Deprecia:</td>
            <td style='width:4%'><input name="deprecia" type="checkbox" value="S" <?php echo $chk; ?> onClick="deprec()"></td>
           	<td class="saludo1" style='width:10%'>A&ntilde;os Depreciacion:</td>
	  		<td colspan="2" style='width:5%'><input type="text" id="agedep" name="agedep"  onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[agedep]?>" onClick="document.getElementById('agedep').focus();document.getElementById('agedep').select();" style='width:80%'></td>
	    </tr>
    </table>
	<table class="inicio">
	<tr><td colspan="6" class="titulos2">Crear Detalle Concepto</td></tr>
		<tr>
        	<td class="saludo1" style='width:10%'>Cuenta Depreciacion Deb:</td>
    		<td style='width:10%'><input type="text" id="cuentadeb" name="cuentadeb" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(1)" value="<?php echo $_POST[cuentadeb]?>" onClick="document.getElementById('cuentadeb').focus();document.getElementById('cuentadeb').select();" style='width:80%'><input type="hidden" value="0" name="bcd"><a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentadeb&nobjeto=ncuentadeb','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">&nbsp;<img src="imagenes/buscarep.png" style='width:16px'></a>  </td>
            <td style='width:30%'><input id="ncuentadeb" name="ncuentadeb" type="text" value="<?php echo $_POST[ncuentadeb]?>" style='width:100%'  readonly></td>
         	<td class="saludo1" style='width:10%'>Cuenta Depreciacion Cred:</td>
          	<td style='width:10%'><input type="text" id="cuentacred" name="cuentacred"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(2)" value="<?php echo $_POST[cuentacred]?>" onClick="document.getElementById('cuentacred').focus();document.getElementById('cuentacred').select();" style='width:80%'><input type="hidden" value="0" name="bcc"><a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentacred&nobjeto=ncuentacred','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">&nbsp;<img src="imagenes/buscarep.png" style='width:16px'></a>  </td>
            <td style='width:30%'><input id="ncuentacred" name="ncuentacred" type="text" value="<?php echo $_POST[ncuentacred]?>" style='width:100%' readonly></td> 
		</tr>
		<tr>        
        	<td class="saludo1">Cuenta Activos:</td>
			<td><input type="text" id="cuentact" name="cuentact" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(3)" value="<?php echo $_POST[cuentact]?>" onClick="document.getElementById('cuentact').focus();document.getElementById('cuentact').select();" style='width:80%'><input type="hidden" value="0" name="bca"><a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentact&nobjeto=ncuentact','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">&nbsp;<img src="imagenes/buscarep.png" style='width:16px'></a></td>
			<td><input name="ncuentact" type="text" id="ncuentact" value="<?php echo $_POST[ncuentact]?>" style='width:100%'  readonly></td>
			<td class="saludo1">Cuenta Perdida:</td>
			<td><input type="text" id="cuentaper" name="cuentaper"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(4)" value="<?php echo $_POST[cuentaper]?>" onClick="document.getElementById('cuentaper').focus();document.getElementById('cuentaper').select();" style='width:80%'><input type="hidden" value="0" name="bcp"><a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentaper&nobjeto=ncuentaper','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">&nbsp;<img src="imagenes/buscarep.png" style='width:16px'></a>  </td>
 			<td><input id="ncuentaper" name="ncuentaper" type="text" value="<?php echo $_POST[ncuentaper]?>" style='width:100%' readonly></td></tr>
		<tr>
	 
    <td class="saludo1">CC:</td><td colspan="2">
	<select name="cc"   onKeyUp="return tabular(event,this)">
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
	 </td><td><input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"><input type="hidden"  name="oculto" id="oculto" value="<?php echo $_POST[oculto]?>">		</td>
        </tr>
		  <?php
		if (!$_POST[oculto])
		 {
		 ?>
		<script>
    	//document.form2.cc.focus();
		</script>	
		<?php
		}
		
		if($_POST[bcd]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentadeb]);
			  if($nresul!='')
			   {
			  $_POST[ncuentadeb]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentacred').focus();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentadeb]="";
			  ?>
			  <script>alert("Cuenta Incorrecta Debito");document.form2.cuentadeb.focus();</script>
			  <?php
			  }
			 }
			 	if($_POST[bccr]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentacred]);
			  if($nresul!='')
			   {
			  $_POST[ncuentacred]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentact').focus();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentacred]="";
			  ?>
			  <script>alert("Cuenta Incorrecta Credito");document.form2.cuentacred.focus();</script>
			  <?php
			  }
			 }
			 	if($_POST[bca]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentact]);
			  if($nresul!='')
			   {
			  $_POST[ncuentact]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentaper').focus();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentact]="";
			  ?>
			  <script>alert("Cuenta Incorrecta Activo");document.form2.cuentact.focus();</script>
			  <?php
			  }
			 }
			 	if($_POST[bcp]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentaper]);
			  if($nresul!='')
			   {
			  $_POST[ncuentaper]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cc').focus();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentaper]="";
			  ?>
			  <script>alert("Cuenta Incorrecta Perdida");document.form2.cuentaper.focus();</script>
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
		  	  
	</table>
	<div class="subpantallac" style="height:49.5%; width:99.6%;">
	<table class="inicio">
	<tr><td class="titulos" colspan="10">Detalle Clasificacion</td></tr>
	<tr><td class="titulos2">CC</td><td class="titulos2">Cuenta Depre Deb</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Cuenta Depre Cred</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Cuenta Activa</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Cuenta Perdida</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
	<?php		
	//echo "<br>posic:".$_POST[elimina];	 
	if ($_POST[elimina]!='')
		 { 
		 $posi=$_POST[elimina];
		 //echo "<br>posic:".$_POST[elimina];
		 unset($_POST[dcuentasdeb][$posi]);
 		 unset($_POST[dncuentasdeb][$posi]);
		 unset($_POST[dcuentascred][$posi]);
 		 unset($_POST[dncuentascred][$posi]);
		  unset($_POST[dcuentasper][$posi]);
 		 unset($_POST[dncuentasper][$posi]);
		  unset($_POST[dcuentasact][$posi]);
 		 unset($_POST[dncuentasact][$posi]);		 
		 unset($_POST[dccs][$posi]);		 	 
		 $_POST[dcuentasdeb]= array_values($_POST[dcuentasdeb]); 
		 $_POST[dncuentasdeb]= array_values($_POST[dncuentasdeb]); 	
		 $_POST[dcuentascred]= array_values($_POST[dcuentascred]); 
		 $_POST[dncuentascred]= array_values($_POST[dncuentascred]); 	
		 $_POST[dcuentasper]= array_values($_POST[dcuentasper]); 
		 $_POST[dncuentasper]= array_values($_POST[dncuentasper]); 	
		 $_POST[dcuentasact]= array_values($_POST[dcuentasact]); 
		 $_POST[dncuentasact]= array_values($_POST[dncuentasact]); 	
			 	 		 
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 }
	
	if ($_POST[agregadet]=='1')
		 {
		  $cuentacred=0;
		  $cuentadeb=0;
		  $diferencia=0;
		  
		 $_POST[dcuentasdeb][]=$_POST[cuentadeb];
		 $_POST[dncuentasdeb][]=$_POST[ncuentadeb];
		 $_POST[dcuentascred][]=$_POST[cuentacred];
		 $_POST[dncuentascred][]=$_POST[ncuentacred];		 
		 $_POST[dcuentasact][]=$_POST[cuentact];
		 $_POST[dncuentasact][]=$_POST[ncuentact];		 
		 $_POST[dcuentasper][]=$_POST[cuentaper];
		 $_POST[dncuentasper][]=$_POST[ncuentaper];	 
		 $_POST[dccs][]=$_POST[cc];		 		 
		 $_POST[agregadet]=0;
		 
		 
		 ?><script>
			//document.form2.cuenta.focus();	
			document.form2.cc.select();
			document.form2.cc.value="";
		 </script><?php
		 
		 }
		  $iter='zebra1';
		  $iter2='zebra2';
		 for ($x=0;$x< count($_POST[dcuentasdeb]);$x++)
		 {echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
			<td><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='1' class='inpnovisibles' readonly></td>
			<td><input name='dcuentasdeb[]' value='".$_POST[dcuentasdeb][$x]."' type='text' size='6' class='inpnovisibles' readonly></td>
			<td><input name='dncuentasdeb[]' value='".$_POST[dncuentasdeb][$x]."' type='text' size='50' class='inpnovisibles' readonly></td>
			<td><input name='dcuentascred[]' value='".$_POST[dcuentascred][$x]."' type='text' size='6' class='inpnovisibles' readonly></td>
			<td><input name='dncuentascred[]' value='".$_POST[dncuentascred][$x]."' type='text' size='50' class='inpnovisibles' readonly></td>
			<td><input name='dcuentasact[]' value='".$_POST[dcuentasact][$x]."' type='text' size='6' class='inpnovisibles' readonly></td>
			<td><input name='dncuentasact[]' value='".$_POST[dncuentasact][$x]."' type='text' size='50' class='inpnovisibles' readonly></td>
			<td><input name='dcuentasper[]' value='".$_POST[dcuentasper][$x]."' type='text' size='6' class='inpnovisibles' readonly></td>
			<td><input name='dncuentasper[]' value='".$_POST[dncuentasper][$x]."' type='text' size='50' class='inpnovisibles' readonly></td>
			<td style='text-align:center;'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
			$aux=$iter;
			$iter=$iter2;
		 	$iter2=$aux;
		 }	 
		 ?>
	</table>
	</div>
	
</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2')	
		{
		//rutina de guardado cabecera
		$linkbd=conectar_bd();
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="update acticlasificacion set  codigo='$_POST[numero]',nombre='$_POST[nombre]', deprecia='$_POST[deprecia]',  agedep=$_POST[agedep], estado='S' where codigo='$_POST[numero]'";
		if(!mysql_query($sqlr,$linkbd))
		 {
		   echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Actualizado la Clasificacion, Error:".mysql_error()." <img src='imagenes\alert.png' ></center></td></tr></table>";
		 }
		 else
		 {
		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado con Exito La Clasificacion <img src='imagenes\confirm.png' ></center></td></tr></table>";
		 $sqlr="delete from acticlasificacion_det where codigo='$_POST[numero]'";
		mysql_query($sqlr,$linkbd);
		   for($x=0;$x<count($_POST[dccs]);$x++) 
		 {
		  $sqlr="insert into acticlasificacion_det(codigo,depredeb,deprecred,activa, perdida,cc,estado) values ('$_POST[numero]', '".$_POST[dcuentasdeb][$x]."','".$_POST[dcuentascred][$x]."', '".$_POST[dcuentasact][$x]."', '".$_POST[dcuentasper][$x]."','".$_POST[dccs][$x]."','S')";
		  $res=mysql_query($sqlr,$linkbd);
		 }
		 }

	   }
	?>	

</body>
</html>