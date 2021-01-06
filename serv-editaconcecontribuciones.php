<?php
require "comun.inc";
require "funciones.inc";
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>:: Contabilidad</title>
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
					else {despliegamodalm('visible','2','Falta información para poder Agregar Detalle de Modalidad');}
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
					document.form2.defecto.value='1';
					document.getElementById('oculto').value='9';
					document.form2.submit();
					
				}
			}

			function validar(){
				document.getElementById('oculto').value='9';
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

		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('numero').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('numero').value=next;
					var idcta=document.getElementById('numero').value;
					document.form2.action="serv-editaconcecontribuciones.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="serv-editaconcecontribuciones.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}

            function iratras(scrtop, numpag, limreg, filtro){
                var idcta=document.getElementById('numero').value;
                location.href="serv-buscaconcecontribuciones.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
            }
        </script>

<script src="css/programas.js"></script>
<script type="text/javascript" src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
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
			<a href="serv-concecontribuciones.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" border="0" /></a>
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
			<a href="serv-buscaconcecontribuciones.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>
</table>
<tr><td colspan="3" class="tablaprin"> 
<?php
		$linkbd=conectar_bd();
		if ($_GET[is]!=""){echo "<script>document.getElementById('codrec').value=$_GET[is];</script>";}
		$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from conceptoscontables where modulo='10' and tipo='SC' ORDER BY CONVERT(codigo, SIGNED INTEGER)";
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$_POST[minimo]=$r[0];
		$_POST[maximo]=$r[1];
		if($_POST[oculto]==""){
			if ($_POST[codrec]!="" || $_GET[is]!=""){
				if($_POST[codrec]!=""){
					$sqlr="select *from conceptoscontables where codigo='$_POST[codrec]' and modulo='10' and tipo='SC'";
				}
				else{
					$sqlr="select *from conceptoscontables where codigo ='$_GET[is]' and modulo='10' and tipo='SC'";
				}
			}
			else{
				$sqlr="select * from  conceptoscontables where modulo='10' and tipo='SC' ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";
			}
			$res=mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($res);
		   	$_POST[numero]=$row[0];
		}

		if(($_POST[oculto]!="2")&&($_POST[oculto]!="9")){
		 	$linkbd=conectar_bd();
 		 	$sqlr="SELECT * FROM conceptoscontables where modulo='10' and tipo='SC' and codigo='$_POST[numero]'";
		 	$resp = mysql_query($sqlr,$linkbd);
		 	$cont=0;
		 	$_POST[tipoc]='SC';
		 	while ($row =mysql_fetch_assoc($resp)){
		 		$_POST[numero]=$row["codigo"]; 	
 	 	 		$_POST[nombre]=$row["nombre"];
		 	}
		}

		if(($_POST[oculto]!="2")&&($_POST[oculto]!="9")){
		 	unset($_POST[tcuentas]);
		 	unset($_POST[dcuentas]);
 		 	unset($_POST[dncuentas]);
		 	unset($_POST[dcuentasp]);
 		 	unset($_POST[dncuentasp]);
		 	unset($_POST[dccs]);
		 	unset($_POST[dcreditos]);		 		 		 		 		 
		 	unset($_POST[ddebitos]);
			unset($_POST[fecha]);
			unset($_POST[fecha1]);
			unset($_POST[cuenta]);
			unset($_POST[ncuenta]);
 		 	$sqlr="SELECT * FROM conceptoscontables_det where codigo ='$_POST[numero]' and tipo='SC' and tipocuenta='N' and cuenta!='' order by fechainicial desc";
		 	$resp = mysql_query($sqlr,$linkbd);
		 	$cont=0;
		 	$_POST[tipoc]='SC';
		 	while ($row =mysql_fetch_assoc($resp)){
				$_POST[dccs][$cont]=$row["cc"];
				$_POST[dcuentas][$cont]=$row["cuenta"];
				$_POST[dncuentas][$cont]=buscacuenta($row["cuenta"]);		 		  			 
				$_POST[dcreditos][$cont]=$row["credito"]; 
				$_POST[ddebitos][$cont]=$row["debito"];
				$_POST[tcuentas][$cont]='N';
				$_POST[fecha][$cont]=$row["fechainicial"];
				$cont=$cont+1;		 
		 	}
		}

		//NEXT
		$sqln="select *from conceptoscontables WHERE codigo > '$_POST[numero]' and modulo='10' and tipo='SC' ORDER BY codigo ASC LIMIT 1";
		$resn=mysql_query($sqln,$linkbd);
		$row=mysql_fetch_row($resn);
		$next="'".$row[0]."'";
		//PREV
		$sqlp="select *from conceptoscontables WHERE codigo < '$_POST[numero]' and modulo='10' and tipo='SC' ORDER BY codigo DESC LIMIT 1";
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
 <?php //**** busca cuentas presup
  			if($_POST[bcp]=='1')
			 {
			  $nresul=buscacuentapres($_POST[cuentap],2);			
			  if($nresul!='')
			   {
			  $_POST[ncuentap]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentap]="";	
			   }
			 }			 
			 ?>
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
    	<tr>
        	<td class="titulos" colspan="6">.: Editar Concepto Contable Contribuciones </td>
        	<td style="width:7%" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
			<td style="width:2.5cm" class="saludo1">C6oacute;digo:</td>
          	<td  style="width:15%" valign="middle" >
	   	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
            	<input type="text" id="numero" name="numero" style="width:50%" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();" readonly>
                <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
                <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
                <input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
                <input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
				<input type="hidden" value="<?php echo $_POST[defecto]?>" name="defecto" id="defecto">
      		</td>
		 	<td style="width:2.5cm" class="saludo1">Nombre:</td>
          	<td style="width:40%" valign="middle" >
            	<input type="text" id="nombre" name="nombre" style="width:100%" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td>
          <td style="width:2.5cm" class="saludo1">Tipo:</td>
          <td style="width:15%">
          	<input name="tipo" value="Contribuciones"  style="width:100%" type="text" readonly>
            <input name="tipoc" value="SC" size="10" type="hidden">
          </td>
	 	</tr>
  	</table>
	<table class="inicio">
		<tr>
        	<td colspan="6" class="titulos2">Crear Detalle Concepto</td>
       	</tr>
		<tr>
			<td class="saludo1" style="width:10%">Fecha Inicial:</td>
			<td style="width:10%;">
				<input name="fecha1" id="fecha1" type="text" title="YYYY-MM-DD" style="width:75%;" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha1');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
			</td>   
			<td class="saludo1" style="width:8%">Cuenta Contable: </td>
          	<td  valign="middle" style="width:15%">
            	<input name="cuenta" id="cuenta" type="text"  value="<?php echo $_POST[cuenta]?>" onKeyUp="return tabular(event,this) " style="width:80%;" onBlur="buscacta(event)"><input type="hidden" value="" name="bc" id="bc">
				<input name="cuenta_" type="hidden" value="<?php echo $_POST[cuenta_]?>">&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',1);" title="Buscar cuenta" class="icobut" />
          	</td>
            <td >
            	<input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>"  style="width:88%" readonly>
           	</td>
		</tr>
		<tr>
        	
        </tr>
		<tr>
			
	   	</tr>				
		<tr>
		<?php
			if($_POST[defecto]=='1')
			{
				if ($_POST[cuenta][0]=='2' || $_POST[cuenta][0]=='3' || $_POST[cuenta][0]=='4')
					$_POST[debcred]='2';
				else
					$_POST[debcred]='1';
				echo "<script>document.form2.defecto.value='0';</script>";
			}
		?>
			<td class="saludo1">Tipo:</td>
        	<td>
        		<select name="debcred" id="debcred" style="width:90%;">
                    <option value="1" <?php if($_POST[debcred]=='1') echo "SELECTED"; ?>>Debito</option>
                    <option value="2" <?php if($_POST[debcred]=='2') echo "SELECTED"; ?>>Credito</option>
                </select>
			</td>
               <td  class="saludo1">CC:</td>
            <td>
				<select name="cc" style="width:80%;" id="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
					<?php
					$linkbd=conectar_bd();
					$sqlr="select *from centrocosto where estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){
						echo "<option value=$row[0] ";
						$i=$row[0];
					 	if($i==$_POST[cc]){
						 	echo "SELECTED";
						}
					  	echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
					?>
   				</select>
	 		</td>
			<td>
                <input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet">
                <input type="hidden" value="0" name="oculto" id="oculto">	
            </td>
   		</tr>
  	</table>
	<?php
		if($_POST[bc]=='1'){
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentap').focus();</script>
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
			 //**** cuenta presupuestal
			 if($_POST[bcp]=='1')
			 {
			  $nresulp=buscacuentapres($_POST[cuentap],2);
			  if($nresulp!='')
			   {
			  $_POST[ncuentap]=$nresulp;
  			  ?>
			  <script>
			  document.getElementById('debcred').focus();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentap]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuentap.focus();</script>
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
    <div class="subpantalla" style="height:46%; width:99.6%; overflow-x:hidden;">
	<table class="inicio">
	<tr><td class="titulos" colspan="8">Detalle Concepto</td></tr>
	<tr>
	<td class="titulos2">Fecha</td>
	<td class="titulos2">CC</td>
	<td class="titulos2">Cuenta</td>
	<td class="titulos2">Nombre Cuenta</td>
	<td class="titulos2">Debito</td>
	<td class="titulos2">Credito</td><td class="titulos2"><img src="imagenes/del.png" >
	<input type='hidden' name='elimina' id='elimina'></td></tr>
	<?php
			 
	if ($_POST[elimina]!='')
		 { 
		 $posi=$_POST[elimina];
		 unset($_POST[tcuentas][$posi]);
		 unset($_POST[dcuentas][$posi]);
 		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dcuentasp][$posi]);
 		 unset($_POST[dncuentasp][$posi]);
		 unset($_POST[dccs][$posi]);
		 unset($_POST[fecha][$posi]);
		 unset($_POST[dcreditos][$posi]);		 		 		 		 		 
		 unset($_POST[ddebitos][$posi]);		 
		 $_POST[tcuentas]= array_values($_POST[tcuentas]); 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]); 
		 $_POST[dcuentasp]= array_values($_POST[dcuentasp]); 
		 $_POST[dncuentasp]= array_values($_POST[dncuentasp]); 		 		 		 
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
		 $_POST[tcuentas][]='N';
		 $_POST[dcuentas][]=$_POST[cuenta];
		 $_POST[dncuentas][]=$_POST[ncuenta];
		 $_POST[dcuentasp][]=$_POST[cuentap];
		 $_POST[dncuentasp][]=$_POST[ncuentap];		 
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
		 {echo "<tr class='$iter'><td>
		<input name='fecha[]' value='".$_POST[fecha][$x]."' type='text' size='8' class='inpnovisibles'></td>
		<td  style='width:10%'>
		<input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' style='width:100%' class='inpnovisibles'></td>
		<td style='width:10%'>
		<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
		<td  style='width:50%'>
		<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
		<td  style='width:10%'>
		<input name='ddebitos[]' value='".$_POST[ddebitos][$x]."' type='text' style='width:100%' onDblClick='llamarventanadeb(this,$x)' class='inpnovisibles' readonly></td>
		<td  style='width:10%'>
		<input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text' style='width:100%' onDblClick='llamarventanacred(this,$x)'  class='inpnovisibles' readonly></td>
		<td  style='width:3%'>
		<a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
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
		$sqlr="delete from conceptoscontables_det where codigo='".$_POST[numero]."' and tipo='$_POST[tipoc]' and modulo ='10'";	
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from conceptoscontables where codigo='".$_POST[numero]."' and tipo='$_POST[tipoc]' and modulo ='10'";	 
		mysql_query($sqlr,$linkbd);
			
		
		$sqlr="insert into conceptoscontables (codigo,nombre,modulo,tipo) values ('$_POST[numero]','$_POST[nombre]',10,'$_POST[tipoc]')";
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
			$sqlr="insert into conceptoscontables_det (codigo,tipo,tipocuenta,cuenta,cc,debito,credito,estado,modulo,fechainicial) values ('$_POST[numero]','$_POST[tipoc]','N','".$_POST[dcuentas][$x]."','".$_POST[dccs][$x]."','".$_POST[ddebitos][$x]."','".$_POST[dcreditos][$x]."','S','10','".$_POST[fecha][$x]."')";
			$res=mysql_query($sqlr,$linkbd);
		}
		
	   }
	?>	
</td></tr>     
</table>
			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
</body>
</html>