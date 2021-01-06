<?php //V 1000 12/12/16 ?>
<?php
require"comun.inc";
require"funciones.inc";
session_start();
 $linkbd=conectar_bd();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>
<script>
	function buscacta(e){
		if (document.form2.cuenta.value!=""){
			document.form2.bc.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}

	function buscactac(e){
		if (document.form2.cuentac.value!=""){
 			document.form2.bcc.value='1';
			document.getElementById('oculto').value='7';
 			document.form2.submit();
 		}
 	}

	function buscactag(e){
		if (document.form2.cuentag.value!=""){
			document.form2.bcg.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}

	function buscactap(e){
		if (document.form2.cuentap.value!=""){
			document.form2.bcp.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}

	function buscactap2(e){
		if (document.form2.cuentap2.value!=""){
			document.form2.bcp2.value='1';
			document.getElementById('oculto').value='7';
			document.form2.submit();
		}
	}

	function validar(){
		document.getElementById('oculto').value='7';
		document.form2.submit();
	}

	function guardar(){
		if (document.form2.codigo.value!='' && document.form2.nombre.value!='' && document.form2.concecont.value!=-1 ){
			despliegamodalm('visible','4','Esta Seguro de Guardar los Cambios','1');
		}
		else{
			despliegamodalm('visible','2','Faltan datos para Modificar los Datos');
			document.form2.nombre.focus();document.nombre.modalidad.select();
		}
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

</script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="teso-editaingresossf.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}

			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=prev;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="teso-editaingresossf.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}

			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigo').value;
				location.href="teso-buscaingresossf.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
      function agregardetalle(){
    		//var cuenta=document.form2.dcuentas[].value.trim();
    		if(document.form2.cuenta2.value!="" ){
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
	<tr>
		<script>barra_imagenes("teso");</script>
		<?php cuadro_titulos();?>
	</tr>
	<tr>
		<?php menu_desplegable("teso");?>
	</tr>
	<tr>
  		<td colspan="3" class="cinta">
			<a href="teso-ingresossf.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscaingresossf.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" />  </a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" class="mgbt" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" ></a>
		</td>
	</tr>
</table>
	<tr>
		<td colspan="3" class="tablaprin" align="center">
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
      if($_POST[oculto]=='1')
      {
        $sqlr="select *from tesoingresossf_cab INNER JOIN tesoingresossf_det ON tesoingresossf_cab.codigo=tesoingresossf_det.codigo where  tesoingresossf_cab.codigo='$_POST[codigo]' and tesoingresossf_det.vigencia=$vigusu";
				//echo $sqlr;
				$cont=0;
        unset($_POST[dcuentas]);
        unset($_POST[dncuentas]);
        unset($_POST[cuenta2]);
        unset($_POST[ncuenta2]);
	 			$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp))
				{
			 		$_POST[concecont]=$row[5];
				 	$_POST[concecontgas]=$row[6];
				 	$_POST[cuentap]=$row[8];
				 	$_POST[ncuentap]=buscacuentapres($row[8],1);
				 	$_POST[dcuentas][]=$row[9];
				 	$_POST[dncuentas][]=buscacuentapres($row[9],2);
				}
      }
			if($_POST[oculto]=='')
			{
				if ($_GET[idr]!="")
				{
					echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";
				}
				$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from tesoingresossf_cab ORDER BY CONVERT(codigo, SIGNED INTEGER)";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				$_POST[minimo]=$r[0];
				$_POST[maximo]=$r[1];
				if($_POST[oculto]==""){
					if ($_POST[codrec]!="" || $_GET[idr]!=""){
						if($_POST[codrec]!="")
						{
							$sqlr="select *from tesoingresossf_cab where codigo='$_POST[codrec]'";
						}
						else
						{
							$sqlr="select *from tesoingresossf_cab where codigo ='$_GET[idr]'";
						}
					}
					else
					{
						$sqlr="select * from  tesoingresossf_cab ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";
					}
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[codigo]=$row[0];
				}
				$sqlr="select *from tesoingresossf_cab INNER JOIN tesoingresossf_det ON tesoingresossf_cab.codigo=tesoingresossf_det.codigo where  tesoingresossf_cab.codigo='$_POST[codigo]' and tesoingresossf_det.vigencia=$vigusu";
				//echo $sqlr;
				$cont=0;
        unset($_POST[dcuentas]);
        unset($_POST[dncuentas]);
        unset($_POST[cuenta2]);
        unset($_POST[ncuenta2]);
	 			$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp))
				{
			 		$_POST[concecont]=$row[5];
				 	$_POST[concecontgas]=$row[6];
				 	$_POST[cuentap]=$row[8];
				 	$_POST[ncuentap]=buscacuentapres($row[8],1);
				 	$_POST[dcuentas][]=$row[9];
				 	$_POST[dncuentas][]=buscacuentapres($row[9],2);
				}

			}
	 			if(($_POST[oculto]!="2")&&($_POST[oculto]!="7"))
	 			{
					$sqlr="select *from tesoingresossf_cab where  tesoingresossf_cab.codigo='$_POST[codigo]' ";
					//echo $sqlr;
					$cont=0;
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$_POST[codigo]=$row[0];
					 	$_POST[nombre]=$row[1];
					}
				}



			//NEXT
				$sqln="select *from tesoingresossf_cab WHERE codigo > '$_POST[codigo]' ORDER BY codigo ASC LIMIT 1";
				$resn=mysql_query($sqln,$linkbd);
				$row=mysql_fetch_row($resn);
				$next="'".$row[0]."'";
				//PREV
				$sqlp="select *from tesoingresossf_cab WHERE codigo < '$_POST[codigo]' ORDER BY codigo DESC LIMIT 1";
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
<?php //**** busca cuentas
  			if($_POST[bcp]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap],1);
			  if($nresul!='')
			   {
			  $_POST[ncuentap]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentap]="";
			   }
			 }
			 if($_POST[bcp2]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap2],2);
			  if($nresul!='')
			   {
			  $_POST[ncuentap2]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentap2]="";
			   }
			 }
			 if($_POST[bc]!='')
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
			 if($_POST[bcg]!='')
			 {
			  $nresul=buscacuenta($_POST[cuentag]);
			  if($nresul!='')
			   {
			  $_POST[ncuentag]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentag]="";
			   }
			 }

			  if($_POST[bcc]!='')
			 {

			  $nresul=buscacuenta($_POST[cuentac]);
			   //echo "bbbb".$_POST[cuentac];
			  if($nresul!='')
			   {
			  $_POST[ncuentac]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentac]="";
			   }
			 }
			 ?>

   	<table class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="4">Ingresos Sin situacion de Fondos SSF</td>
            <td style="width:7%" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
	  		<td style="width:2.5cm" class="saludo1">Codigo:        </td>
        	<td style="width:10%">
	        	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
        		<input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" style="width:30%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
	    	    <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
				<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
				<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
				<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
       		</td>
        	<td style="width:2.5cm" class="saludo1">Nombre : </td>
        	<td style="width:50%">
        		<input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" style="width:100%" onKeyUp="return tabular(event,this)">        	</td>
       	</tr>
   	</table>
	<table class="inicio">
		<tr>
        	<td colspan="3" class="titulos">Detalle Recursos SSF</td>
       	</tr>
        <tr>
	  		<td style="width:15%;" class="saludo1">Parametro Contable Ingreso:</td>
          	<td colspan="2" valign="middle" >
            	<select name="concecont" id="concecont" >
					<option value="-1">Seleccione ....</option>
					<?php
						$sqlr="Select * from conceptoscontables  where modulo='4' and tipo='IS' order by codigo";
			 			$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp))
						{
							$i=$row[0];
							echo "<option value=$row[0] ";
							if($i==$_POST[concecont])
						 	{
								echo "SELECTED";
							 	$_POST[concecontnom]=$row[0]." - ".$row[3]." - ".$row[1];
							}
							echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";
						}
					?>
				</select>
				<input id="concecontnom" name="concecontnom" type="hidden" value="<?php echo $_POST[concecontnom]?>" >
         	</td>
	 	</tr>
	  	<tr>
	  		<td style="width:15%;" class="saludo1">Parametro Contable Gastos: </td>
          	<td colspan="2"  valign="middle" >
            	<select style="width:41.6%;" name="concecontgas" id="concecontgas" >
					<option value="-1">Seleccione ....</option>
					<?php
						 $sqlr="Select * from conceptoscontables  where modulo='4' and tipo='GS' order by codigo";
			 			$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp))
						{
							$i=$row[0];
							echo "<option value=$row[0] ";
							if($i==$_POST[concecontgas])
				 			{
					 			echo "SELECTED";
					 			$_POST[concecontgasnom]=$row[0]." - ".$row[3]." - ".$row[1];
					 		}
							echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";
				     	}
					?>
				  </select>
				  <input id="concecontgasnom" name="concecontgasnom" type="hidden" value="<?php echo $_POST[concecontgasnom]?>" >
         	</td>
	    </tr>
		<tr>
         	<td style="width:15%;" class="saludo1">Cuenta presupuestal Ingreso: </td>
          	<td valign="middle" >
            	<input type="text" id="cuentap" name="cuentap" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactapxx(event)" value="<?php echo $_POST[cuentap]?>" onClick="document.getElementById('cuentap').focus();document.getElementById('cuentap').select();">
            	<input type="hidden" value="" name="bcp" id="bcp">
            	<a href="#" onClick="mypop=window.open('scuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
            		<img src="imagenes/buscarep.png" align="absmiddle" border="0">
            	</a>
        		<input style="width:40%;" name="ncuentap" type="text" value="<?php echo $_POST[ncuentap]?>"  readonly>
           	</td>
	    </tr>
		<tr>
          	<td style="width:15%;" class="saludo1">Cuenta presupuestal Gasto: </td>
          	<td valign="middle" >
          		<input type="text" id="cuenta2" name="cuenta2"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactap2(event)" value="<?php echo $_POST[cuenta2]?>" onClick="document.getElementById('cuenta2').focus();document.getElementById('cuenta2').select();">
          		<input type="hidden" value="" name="bcp2" id="bcp2">
          		<a href="#" onClick="mypop=window.open('cuentasppto2-ventana.php?ti=2','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
          			<img src="imagenes/buscarep.png" align="absmiddle" border="0">
          		</a>
	         	<input style="width:40%;"  name="ncuenta2" type="text" value="<?php echo $_POST[ncuenta2]?>"  readonly>
                <input name="oculto" id="oculto" type="hidden" value="1">
                <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" style="margin-left: 4.5%">
                <input type="hidden" value="0" name="agregadet">
           	</td>
	    </tr>

    </table>
	 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentag').focus();
			  document.getElementById('cuentag').select();
			  document.getElementById('bc').value='';
			  </script>
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
			 if($_POST[bcg]!='')
			 {
			  $nresul=buscacuenta($_POST[cuentag]);
			  if($nresul!='')
			   {
			  $_POST[ncuentag]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentap').focus();
			  document.getElementById('cuentap').select();
			  document.getElementById('bcg').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentag]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuentag.focus();</script>
			  <?php
			  }
			 }


			 if($_POST[bcc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuentac]);
			  if($nresul!='')
			   {
			  $_POST[ncuentac]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuenta').focus();
			  document.getElementById('cuenta').select();
			  document.getElementById('bcc').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentac]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuentac.focus();</script>
			  <?php
			  }
			 }
		?>

	 <?php
			//**** busca cuenta
			if($_POST[bcp]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap],1);
			  if($nresul!='')
			   {
			  $_POST[ncuentap]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuenta2').focus();
			  document.getElementById('cuenta2').select();
			  document.getElementById('bcp').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentap]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");
			  document.form2.cuentap.focus();
			  document.form2.cuentap.select();
			  </script>
			  <?php
			  }
			 }
			 //**** busca cuenta
			if($_POST[bcp2]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta2],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta2]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('codigo').focus();
			  document.getElementById('codigo').select();
			  document.getElementById('bcp2').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta2]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");
			  document.form2.cuenta2.focus();
			  document.form2.cuenta2.select();
			  </script>
			  <?php
			  }
			 }
       ?>
       <table class="inicio">
     		<tr>
     			<td class="titulos" colspan="6">Detalle gasto</td>
     		</tr>
     		<tr>
     			<td class="titulos2" style="width:8%">Cuenta</td>
     			<td class="titulos2" style="width:35%">Nombre Cuenta</td>
     			<td class="titulos2" style="width:3%"><center>
     				<img src="imagenes/del.png" >
     				<input type='hidden' name='elimina' id='elimina'></center>
     				<input type='hidden' name='posicion' id='posicion'  >
     				<input type='hidden' name='valorpos' id='valorpos'  >
     			</td>
     		</tr>
     		<?php
     			if($_POST[posicion]!=''){
     		 		$pos=$_POST[posicion];
     		 		$val=$_POST[valorpos];
     		 	}
     			if ($_POST[elimina]!='')
     			{
     				$posi=$_POST[elimina];
     				unset($_POST[dcuentas][$posi]);
     		 		unset($_POST[dncuentas][$posi]);
     				$_POST[dcuentas]= array_values($_POST[dcuentas]);
     				$_POST[dncuentas]= array_values($_POST[dncuentas]);
     			}

     			if ($_POST[agregadet]=='1')
     			{
     				$cuentacred=0;
     				$cuentadeb=0;
     				$diferencia=0;
     				$_POST[dcuentas][]=$_POST[cuenta2];
     				$_POST[dncuentas][]=$_POST[ncuenta2];
     				$_POST[agregadet]=0;
     		?>
     		<script>
     			document.form2.concecont.select();
     		</script>
     		<?php
     		 	}
     		 	for ($x=0;$x< count($_POST[dcuentas]);$x++)
     		 	{
     		 		echo "<tr>
     						<td class='saludo2'>
     							<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%' readonly>
     						</td>
     						<td class='saludo2'>
     							<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text'style='width:100%' readonly>
     						</td>
     						<td class='saludo2'><center>
     							<a href='#' onclick='eliminar($x)'>
     								<img src='imagenes/del.png'>
     							</a>
     							</center>
     						</td>
     					</tr>";
     		 	}
     		?>
     		<tr></tr>
     	</table>
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$linkbd=conectar_bd();
if ($_POST[nombre]!="")
 {
 $nr="1";
// $sqlr="INSERT INTO tesoingresossf_cab(codigo,nombre,estado)VALUES ('$_POST[codigo]','".($_POST[nombre])."' ,'S')";
  $sqlr="update tesoingresossf_cab  set nombre='".($_POST[nombre])."' ,estado='S' where codigo = $_POST[codigo]";
 //echo "sqlr:".$sqlr;
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurri� el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  else
  {
  echo "<table><tr><td class='saludo1'><center>Se ha almacenado el Ingreso SSF con Exito  <img src='imagenes/confirm.png'></center></td></tr></table>";
		//******
		$sqlr="delete from tesoingresossf_det where codigo ='$_POST[codigo]'";
		mysql_query($sqlr,$linkbd);
		if(count($_POST[dcuentas])>0)
		{
			for ($x=0;$x< count($_POST[dcuentas]);$x++)
			{
			  $sqlr="INSERT INTO tesoingresossf_det (codigo,conceing,concegas,cuentacongas,cuentapresing,cuentapresgas,estado,vigencia)VALUES ('$_POST[codigo]', '$_POST[concecont]','$_POST[concecontgas]','$_POST[cuentag]','$_POST[cuentap]','".$_POST[dcuentas][$x]."','S', $vigusu)";
			  //echo $sqlr;
				if (!mysql_query($sqlr,$linkbd))
				{
				  echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
				echo "Ocurri� el siguiente problema:<br>";
				  echo "<pre>";
				echo "</pre></center></td></tr></table>";
			   }
			   else
				 {
					echo "<table><tr><td class='saludo1'><center>Se ha almacenado el Detalle del Ingreso con Exito  <img src='imagenes/confirm.png'></center></td></tr></table>";
			 }
			}
		}
		else
		{
			$sqlr="INSERT INTO tesoingresossf_det (codigo,conceing,concegas,cuentacongas,cuentapresing,cuentapresgas,estado,vigencia)VALUES ('$_POST[codigo]', '$_POST[concecont]','$_POST[concecontgas]','$_POST[cuentag]','$_POST[cuentap]','".$_POST[dcuentas][$x]."','S', $vigusu)";
			  //echo $sqlr;
				if (!mysql_query($sqlr,$linkbd))
				{
				  echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
				echo "Ocurri� el siguiente problema:<br>";
				  echo "<pre>";
				echo "</pre></center></td></tr></table>";
			   }
			   else
				 {
					echo "<table><tr><td class='saludo1'><center>Se ha almacenado el Detalle del Ingreso con Exito  <img src='imagenes/confirm.png'></center></td></tr></table>";
			 }
		}
	   }
  }
}
?> </td></tr>

</table>
</body>
</html>
