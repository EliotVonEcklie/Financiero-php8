<?php //V 1000 12/12/16 ?> 
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
		<title>:: SPID - Almacen</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
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
		if(document.form2.cuenta.value!=""  && document.form2.cc.value!=""){
			document.form2.agregadet.value=1;
			document.form2.oculto.value='7';
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

	function buscacta(){
		if (document.form2.cuenta.value!=""){
			document.form2.bc.value='1';
			document.form2.oculto.value='7';
			document.form2.submit();
		}else{
		
			document.form2.ncuenta.value='';
			document.form2.submit();
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
</script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('numero').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('numero').value=next;
					var idcta=document.getElementById('numero').value;
					document.form2.action="inve-editaorigen.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="inve-editaorigen.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('numero').value;
				location.href="inve-buscaorigen.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
   		<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>
    	<tr><?php menu_desplegable("inve");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="inve-origen.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="inve-buscaorigen.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
</tr>
</table>
<?php
//$vigencia=date(Y);
//$linkbd=conectar_bd();
 ?>	
<?php
			if ($_GET[is]!=""){echo "<script>document.getElementById('codrec').value=$_GET[is];</script>";}
			$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from almorigenes ORDER BY CONVERT(codigo, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[is]!=""){
					
					if($_POST[codrec]!=""){
						$sqlr="select *from almorigenes where codigo='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from almorigenes where codigo ='$_GET[is]'";
					}
					
				}
				else{
					$sqlr="select * from  almorigenes ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[numero]=$row[0];
				$_POST[nombre]=$row[1];
			}

 			if(($_POST[oculto]!="2")&&($_POST[oculto]!="6")&&($_POST[oculto]!="7")){	
				$linkbd=conectar_bd();
				$sqlr="select *from almorigenes where actiorigenes.codigo='$_POST[numero]'  ";
				$res=mysql_query($sqlr,$linkbd); 
				while ($row=mysql_fetch_row($res)){
					$_POST[nombre]=$row[1];
					$_POST[numero]=$row[0];
				}
			}

 			if(($_POST[oculto]!="6")&&($_POST[oculto]!="7")){	
			 	unset($_POST[dcuentas]);
			 	unset($_POST[dncuentas]);
			 	unset($_POST[dccs]);
			 	unset($_POST[dcreditos]);		 		 		 		 		 
			 	unset($_POST[ddebitos]);		 

				$sqlr="select * from  almorigenes_det  where codigo='$_POST[numero]' ";
				//echo $sqlr;
				$res=mysql_query($sqlr,$linkbd); 
				$cont=0;
				while($row=mysql_fetch_row($res)){
					//$_POST[nombre]=$row[1];
					//$_POST[numero]=$row[0];
					$_POST[dcuentas][$cont]=$row[3];
					$_POST[dccs][$cont]=$row[4];
					$_POST[dncuentas][$cont]=buscacuenta($row[3]);
					$_POST[ddebitos][$cont]=$row[5];
					$_POST[dcreditos][$cont]=$row[6];
					$cont=$cont+1;
				}
			}
			//NEXT
			$sqln="select *from almorigenes WHERE codigo > '$_POST[numero]' ORDER BY codigo ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from almorigenes WHERE codigo < '$_POST[numero]' ORDER BY codigo DESC LIMIT 1";
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
  			  ?>
			  <script>
			  document.getElementById('debcred').focus();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");</script>
			  <?php
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
        <td class="titulos" colspan="8">.: Editar Origen</td>
        <td width="61" class="cerrar" ><a href="acti-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
		<td width="119" class="saludo1">Codigo:</td>
          	<td style="width:20%" valign="middle" >
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
          		<input type="text" id="numero" name="numero" style="width:60%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();">
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
       		</td>
		 <td width="119" class="saludo1">Nombre:</td>
          <td width="197" valign="middle" ><input type="text" id="nombre" name="nombre" size="80" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td>
	    </tr>
    </table>
	<table class="inicio">
	<tr><td colspan="6" class="titulos2">Destino Compra</td></tr>
	<tr>
	<td class="saludo1" style="width: 6%">Cuenta: </td>
          <td  valign="middle" ><input type="text" id="cuenta" name="cuenta" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta()" value="<?php echo $_POST[cuenta]?>" ><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td>
		  <td style="width: 30%"><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="50" readonly>
		  </td>
		  <td class="saludo1" style="width: 6%">CC:</td>
		  <td>
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
	</tr>
	<tr>
	<td class="saludo1">Tipo:</td><td><select name="debcred">
		   <option value="2" <?php if($_POST[debcred]=='2') echo "SELECTED"; ?>>Credito</option>
   		  </select></td><td><input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet">
		  <?php
		if (!$_POST[oculto])
		 {
		 ?>
		<script>
    	//document.form2.cc.focus();
		</script>	
		<?php
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
		  <input type="hidden" value="0" name="oculto">	
		  </td>
	</tr>
	</table>
    <div class="subpantalla" style="height:51.8%; width:99.6%; overflow-x:hidden;">
	<table class="inicio">
	<tr><td class="titulos" colspan="6">Detalle Destino Compra</td></tr>
	<tr><td class="titulos2">CC</td><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Debito</td><td class="titulos2">Credito</td><td class="titulos2" style='text-align:center;'><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
	<?php
			 
	if ($_POST[elimina]!='')
		 { 
			
		 $posi=$_POST[elimina];
		 unset($_POST[dcuentas][$posi]);
 		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dccs][$posi]);
		 unset($_POST[dcreditos][$posi]);		 		 		 		 		 
		 unset($_POST[ddebitos][$posi]);		 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 $_POST[dcreditos]= array_values($_POST[dcreditos]); 
		 $_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
	
		
		 }
	
	if ($_POST[agregadet]=='1')
		 {
		  $cuentacred=0;
		  $cuentadeb=0;
		  $diferencia=0;
		  $iter='saludo1a';
		  $iter2='saludo2';
		 $_POST[dcuentas][]=$_POST[cuenta];
		 $_POST[dncuentas][]=$_POST[ncuenta];
		 $_POST[dccs][]=$_POST[cc];		 
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
				document.form2.submit();
		 </script>
		 <?php
		 }
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
		 <td><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='2' class='inpnovisibles' readonly ></td>
		 <td><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='8' class='inpnovisibles' readonly ></td>
		 <td><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='70' class='inpnovisibles' readonly ></td>
		 <td><input name='ddebitos[]' value='".$_POST[ddebitos][$x]."' type='text' size='3' onDblClick='llamarventanadeb(this,$x)' class='inpnovisibles' readonly ></td>
		 <td><input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text' size='3' onDblClick='llamarventanacred(this,$x)' class='inpnovisibles' readonly ></td>
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
		
		
		$sqlr="delete from almorigenes_det where codigo='".$_POST[numero]."' ";	 
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from almorigenes where codigo='".$_POST[numero]."' ";	 
		mysql_query($sqlr,$linkbd);
			
		
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="insert into almorigenes (codigo,nombre,estado) values ('$_POST[numero]','$_POST[nombre]','S')";
		//echo $sqlr;
		if(!mysql_query($sqlr,$linkbd))
		 {
		   echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado con Exito El Origen, Error:  ".mysql_error()." </center></td></tr></table>";
		 }
		 else
		 {
		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado con Exito El Origen</center></td></tr></table>";
		 }
		 //**** crear el detalle del concepto
		for($x=0;$x<count($_POST[dcuentas]);$x++) 
		 {
		  $sqlr="insert into almorigenes_det (codigo,tipocuenta,cuenta,cc,debito,credito,estado) values ('$_POST[numero]','N','".$_POST[dcuentas][$x]."','".$_POST[dccs][$x]."','".$_POST[ddebitos][$x]."','".$_POST[dcreditos][$x]."','S')";
		  $res=mysql_query($sqlr,$linkbd);
		 }
	   }
	?>	
</td></tr>     
</table>
</body>
</html>