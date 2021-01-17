<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
header("Cache-control: private"); // Arregla IE 6
date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"  />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: Spid - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />	
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
<script>
//************* ver reporte ************
//***************************************
function guardar()
{
	if( document.form2.codigo.value!="")
	{
  	if (confirm("Esta Seguro de Guardar"))
  	{
	  document.form2.oculto.value=2;
	  document.form2.submit();
	}
	}
	else{alert('Faltan datos para completar el registro');document.form2.codigo.focus();document.form2.codigo.select();}
}
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }

//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }

function buscactac(e)
 {
if (document.form2.cuentacerrar.value!="")
{
 document.form2.bcr.value='1';
 document.form2.submit();
 }
 }

function buscactacr(e)
 {
if (document.form2.cuentacierre.value!="")
{
//alert();
 document.form2.bcre.value='1';
 document.form2.submit();
 }
 }

function buscactat(e)
 {
if (document.form2.cuentas.value!="")
{
 document.form2.bct.value='1';
 document.form2.submit();
 }
 }

function agregardetalle()
{
//alert('valor'+valordeb);
if(document.form2.campo.value!="")
 {
document.form2.agregadet.value=1;
document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}

function agregardetalle2()
{
//alert('valor'+valordeb);
if(document.form2.concepto.value!="")
 {
document.form2.agregadet2.value=1;
document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
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
function validar(){document.form2.submit();}
</script>

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
			<a href="cont-formatosexogena.php" class="mgbt"><img src="imagenes/add.png"  alt="Nuevo" title="Nuevo" /></a>
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar" /></a>
			<a href="cont-buscaformatosexogena.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
			<a href="cont-parametrosexogena.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>
</table>
<tr>
<td>
<?php
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
	//echo  "oc".$_POST[oculto];
   if($_POST[oculto]=="")
   {	
   $check1='checked';
    $_POST[dcuentas]=array();
    $_POST[dncuentas]=array();
    $_POST[dtipos]=array();	
	/*$sqlr="select * from  contexogenaconce_cab";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
	 {
		$_POST[dcuentacerrar][]=$row[0];
    	$_POST[dcuentacierre][]=$row[1];
	    $_POST[dcuentatras][]=$row[2];	
	 }*/
	}	
switch($_POST[tabgroup1])
{
case 1:
$check1='checked';
break;
case 2:
$check2='checked';
break;
case 3:
$check3='checked';
break;
case 4:
$check4='checked';
break;
}	
	if($_POST[bct]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuentas]);
			  if($nresul!='')
			   {
			  $_POST[ncuentas]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuentas]="";
			  }
			 }
?>
<form name="form2" method="post" action="cont-formatosexogena.php">
<div class="tabs_full">
   <div class="tab">
       <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   <label for="tab-1">Formatos Ex&oacute;gena - Datos B&aacute;sicos</label>
	   <div class="content">
     <table class="inicio">  
     <tr >
        <td class="titulos"  colspan="6">:: Formatos Ex&oacute;gena</td><td width="5%" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
      </tr>     
      <tr  >
		<td  class="saludo1">C&oacute;digo:</td>
          <td  valign="middle" ><input type="text" id="codigo" name="codigo" size="10" onKeyPress="javascript:return solonumeros(event)" 		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[codigo]?>" onClick="document.getElementById('numero').focus();document.getElementById('nombre').select();"></td>
		 <td  class="saludo1">Nombre:</td>
         <td  valign="middle" ><input type="text" id="nombre" name="nombre" size="80" 
	onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('nombre').focus();document.getElementById('nombre').select();"></td>
   </tr>
       </table>
       <table class="iniciop">
       <tr><td class="titulos" colspan="3">Datos B&aacute;sicos</td></tr>
       <tr><td class="titulos2">Id</td><td class="titulos2">Nombre</td><td class="titulos2" align="center"><input type="checkbox" name="todos" value="1" <?php echo $chektodos;?>></td></tr>
       <?php
	   $sqlr="show full columns from terceros";
	   $resp=mysql_query($sqlr,$linkbd);
	   if ($resp>0)
        {
		 $cont=0;
		 $_POST[total]=0;
         $nrow=mysql_num_rows($resp);
         while ($cont<$nrow)        
		   {
			  $comentario=mysql_result($resp,$cont,(Comment));
              $campo=mysql_result($resp,$cont,(Field));
		   	  if ($comentario!="")
               {
				$chkter="";
				if(esta_en_array($_POST[listadatos],$campo))
				$chkter=" checked";				   
              echo "<tr><td>$cont</td>";
              echo "<td><input type='hidden' name='tcampos[]' value='".$campo."'/><input type='text' name='comentarios[]' value='".$comentario."' class='inpnovisibles'/></td><td align='center'><input type='checkbox' name='listadatos[]' value='".$campo."' $chkter></td></tr>"; 
			  //$_POST[campos][$cont]=$campo;
              //$_POST[comentarios][$cont]=$comentario;
			   }
			  $cont+=1;
		   }
		}
	   ?>
       </table>
    </div>
 </div>
 
  <div class="tab">
       <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
	   <label for="tab-2">Formatos Ex&oacute;gena - Campos</label>
	   <div class="content">
      <table class="inicio">  
      <tr >
        <td class="titulos" colspan="6">:: Agregar Campos Formato </td><td  class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
      </tr>  
        <tr  >
        <td  class="saludo1">:: Nombre Campo:
       </td>
        <td ><input type="text" id="campo" name="campo" size="70" 
	onKeyUp="return tabular(event,this)" value="<?php echo $_POST[campo] ?>"></td> <td  class="saludo1">Valor Limite:</td>
    <td  valign="middle" ><input type="text" id="valor" name="valor" size="10" 
	onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valor]+0 ?>"></td><td> <input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"><input name="oculto" type="hidden" id="oculto" value="1" ></td>
        </tr>   
        </table>
        <table class="inicio">
        <tr><td class="titulos" colspan="4">Detalle Campos Formato</td></tr>
        <tr><td class="titulos2">No</td><td class="titulos2">Nombre Campo</td><td class="titulos2">Valor Limite</td><td class="titulos2"><center><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></center></td></tr>   
        <?php
		// echo "bcr".$_POST[bcr];
		//  echo "bcre".$_POST[bcre];
		// echo "bct".$_POST[bct];
		 if($_POST[bct]==1)
			 {
			  $nresul=buscacuenta($_POST[cuentas]);
			  if($nresul!='')
			   {
			  $_POST[ncuentas]=$nresul;
  			  ?>
			  <script>			  
			  document.getElementById('ncuentas').value='<?php echo $_POST[ncuentas]?>';
			  document.getElementById('bct').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentas]="";
//			  	 echo "bcr--".$_POST[bcr];
	//	  echo "bcre--".$_POST[bcre];
		// echo "bct--".$_POST[bct];
			  ?>
			  <script>alert("Cuenta Incorrecta ");document.form2.cuentas.focus();</script>
			  <?php
			  }
			 } 
			 
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];		 
		 unset($_POST[dcampos][$posi]);
		 $_POST[dcampos]= array_values($_POST[dcuentas]); 		 				 
		 }
		if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcampos][]=$_POST[campo]; 	
		 $_POST[dvalores][]=$_POST[valor]; 	
		 //echo "numero ".$_POST[cuentacierre];	 		 
		 $_POST[agregadet]=0;
		 }
		$numctas=count($_POST[dcampos]);
		//echo "numero ".$numctas;
		$co="saludo1";
		$co2="saludo2";		
		$tipos=array('','Debito','Credito','Saldos');
		for ($x=0;$x<$numctas;$x++)
		 {
		echo "<tr class='$co'><td ><input type='hidden' name='idcampos[]' value='".($x+1)."'>".($x+1)."</td><td ><input type='hidden' name='dcampos[]' value='".$_POST[dcampos][$x]."'> ".strtoupper($_POST[dcampos][$x])."</td><td ><input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'> ".number_format($_POST[dvalores][$x],0,",",".")."</td><td ><center><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></center></td></tr>";			 
				$aux=$co;
				$co=$co2;
				$co2=$aux;								
		 }
		?>     
        </table>
    </div>
 </div>
 <div class="tab">
       <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
	   <label for="tab-3">Formatos Ex&oacute;gena - Agregar Concepto</label>
	   <div class="content">
      <table class="inicio">  
      <tr >
        <td class="titulos" colspan="6">:: Agregar Conceptos </td><td  class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
      </tr>  
        <tr  >
        <td  class="saludo1" style="width:9%;">:: Conceptos:
       </td>
        <td style="width:20%;"><select name="concepto"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:80%;">
        <option value="" <?php if($_POST[concepto]=='') echo "SELECTED"; ?>>Seleccione...</option>
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from contexogenaconce_cab where estado='S' ORDER BY codigo";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[concepto])
			 			{
						 echo "SELECTED";
						 $_POST[nconcepto]=$row[1];
						 }
					  echo ">".strtoupper($row[0]." - ".$row[1])."</option>";	 	 
					}	 	
	?>
   </select><input type="hidden" id="nconcepto" name="nconcepto" size="10" value="<?php echo $_POST[nconcepto]?>">
   </td>
   <td style="width:10%;">
   <input type="button" name="agrega2" value="  Agregar  " onClick="agregardetalle2()" ><input type="hidden" value="0" name="agregadet2"><input name="oculto2" type="hidden" id="oculto2" value="1" ></td>
        </tr>   
        </table>
        <table class="inicio">
        <tr><td class="titulos" colspan="3">Detalle Conceptos Formato</td></tr>
        <tr><td class="titulos2">C&oacute;digo Concepto</td><td class="titulos2">Nombre Concepto</td><td class="titulos2"><center><img src="imagenes/del.png"><input type='hidden' name='elimina2' id='elimina2'></center></td></tr>   
        <?php
		// echo "bcr".$_POST[bcr];
		//  echo "bcre".$_POST[bcre];
		// echo "bct".$_POST[bct];
		 if($_POST[bct]==1)
			 {
			  $nresul=buscacuenta($_POST[cuentas]);
			  if($nresul!='')
			   {
			  $_POST[ncuentas]=$nresul;
  			  ?>
			  <script>			  
			  document.getElementById('ncuentas').value='<?php echo $_POST[ncuentas]?>';
			  document.getElementById('bct').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentas]="";
//			  	 echo "bcr--".$_POST[bcr];
	//	  echo "bcre--".$_POST[bcre];
		// echo "bct--".$_POST[bct];
			  ?>
			  <script>alert("Cuenta Incorrecta ");document.form2.cuentas.focus();</script>
			  <?php
			  }
			 } 
			 
		if ($_POST[elimina2]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];		 
		 unset($_POST[dcuentas][$posi]);
		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dtipos][$posi]);		 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]); 		 
		 $_POST[dtipos]= array_values($_POST[dtipos]); 		 
		 }
		if ($_POST[agregadet2]=='1')
		 {
		 $_POST[dcuentas][]=$_POST[concepto];
		 $_POST[dncuentas][]=$_POST[nconcepto];		 	
		 //echo "numero ".$_POST[cuentacierre];	 		 
		 $_POST[agregadet]=0;
		 }
		$numctas=count($_POST[dcuentas]);
		//echo "numero ".$numctas;
		$co="saludo1";
		$co2="saludo2";		
		$tipos=array('','Debito','Credito','Saldos');
		for ($x=0;$x<$numctas;$x++)
		 {
		echo "<tr class='$co'><td ><input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'> ".$_POST[dcuentas][$x]."</td><td ><input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'> ".strtoupper($_POST[dncuentas][$x])."</td><td ><center><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></center></td></tr>";			
				$aux=$co;
				$co=$co2;
				$co2=$aux;								
		 }
		?>     
       </table>
    </div>
 </div>
 <div class="tab">
       <input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> >
	   <label for="tab-4">Formatos Ex&oacute;gena - Variables</label>
	   <div class="content">
       <table class="inicio">  
      <tr >
        <td class="titulos" colspan="6">:: Conceptos - Campos </td><td  class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
      </tr>
        <tr><td class="titulos2">Concepto</td><td class="titulos2">Nombre Concepto</td><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Campo</td></tr>
        <?php
			$numctas=count($_POST[dcuentas]);
		//echo "numero ".$numctas;
		$co="saludo1";
		$co2="saludo2";				
		$contsel=0;
		for ($x=0;$x<$numctas;$x++)
		{
		$nombreconc=strtoupper($_POST[dncuentas][$x]);	
		$sqlr="select *from contexogenaconce_det where codigo='".$_POST[dcuentas][$x]."'";	
		$res=mysql_query($sqlr,$linkbd);
		
		while($row=mysql_fetch_row($res))
		 {
		  $ncuenta=buscacuentacont($row[1]);	 
		 echo "<tr class=$co><td><input type='hidden' name='didconc[]' value='".$row[0]."'> ".$row[0]."</td><td ><input type='hidden' name='didnconc[]' value='".$nombreconc."'> ".$nombreconc."</td><td><input type='hidden' name='didcuentas[]' value='".$row[1]."'> ".$row[1]."</td><td><input type='hidden' name='didncuentas[]' value='".$ncuenta."'> ".$ncuenta."</td>";
		 echo "<td>";		   
         echo "<select name='camposvar[]'  >";
         echo "<option value=''";
		 if($_POST[camposvar][$contsel]=='') 
		 echo "SELECTED"; 
		 echo '>Seleccione...</option>';
		 $numctas=count($_POST[dcampos]);			
		 for($y=0;$y<$numctas;$y++)
		   {
			 echo "<option value='".$_POST[idcampos][$y]."'";
			 if($_POST[camposvar][$contsel]==$_POST[idcampos][$y]) 
		 	  echo " SELECTED "; 
			 echo ">".$_POST[idcampos][$y]." - ".$_POST[dcampos][$y]."</option>";  
			}
		echo "</select></td></tr>";
		$contsel+=1;
		 }
		}		
		?>
      </table>
       </div>
  </div>   
</div>    
    </form>
  <?php
  

$oculto=$_POST['oculto'];
if($_POST[oculto]=="2")
{
?>
<?php	
$linkbd=conectar_bd();
$sqlr="insert into contexogenaforma_cab (codigo, nombre,valor_limite, estado) values ('".$_POST[codigo]."','".$_POST[nombre]."',".$_POST[valor].",'S')";
if (mysql_query($sqlr,$linkbd))
	{
	$numctas=count($_POST[dcampos]);
		//echo "numero ".$numctas;
	//*************** ALMACENA LOS CAMPOS ****************
	for ($x=0;$x<$numctas;$x++)
 	{
// echo "<div><div>sqlr:".$sqlr."</div></div>";
  	$sqlr="insert into contexogenaforma_campos (codigo, codcampo, nombrecampo,valor) values ('".$_POST[codigo]."','".$_POST[idcampos][$x]."','".$_POST[dcampos][$x]."',".$_POST[dvalores][$x].") ";
  	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	// $e = mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>".mysql_error($linkbd);
     //echo htmlentities($e['sqltext']);
     //printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
		else
 			{
  			echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado El Formato  <img src='imagenes/confirm.png'></center></td></tr></table>";
			 } 
 	}
	//**** DATOS BASICOS ***********
	$numctas=count($_POST[comentarios]);
		//echo "numero ".$numctas;
	//*************** DATOS BASICOS TABLA TERCEROS ****************
	for ($x=0;$x<$numctas;$x++)
 	{
// echo "<div><div>sqlr:".$sqlr."</div></div>";
    if(esta_en_array($_POST[listadatos],$_POST[tcampos][$x]))
	 {
  	$sqlr="insert into contexogenaforma_basicos(codigo, codcampo, nombrecampo) values ('".$_POST[codigo]."','".$_POST[tcampos][$x]."','".$_POST[comentarios][$x]."') ";
  		if (!mysql_query($sqlr,$linkbd))
		{
	 	echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	// $e = mysql_error($respquery);
	 	echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 	echo "<pre>".mysql_error($linkbd);
     //echo htmlentities($e['sqltext']);
     //printf("\n%".($e['offset']+1)."s", "^");
     	echo "</pre></center></td></tr></table>";
		}
		else
 		{
  		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado El Formato  <img src='imagenes/confirm.png'></center></td></tr></table>";
		} 
	 }
 	}	
	//************ ALMACENA CONCEPTOS ************
	$numctas=count($_POST[dcuentas]);
	for ($x=0;$x<$numctas;$x++)
 	{
// echo "<div><div>sqlr:".$sqlr."</div></div>";
  	$sqlr="insert into contexogenaforma_det (codigo, concepto,tipo,estado) values ('".$_POST[codigo]."','".$_POST[dcuentas][$x]."','','S') ";
  	 if (!mysql_query($sqlr,$linkbd))
	 {
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	// $e = mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>".mysql_error($linkbd);
     //echo htmlentities($e['sqltext']);
     //printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	 }
		else
 			{
  			echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado El Formato  <img src='imagenes/confirm.png'></center></td></tr></table>";
			 } 
 	}
	//**********ALMACENA PARAMETRIZACION CAMPOS CONCEPTOS **************
	$numctas=count($_POST[didconc]);
	for ($x=0;$x<$numctas;$x++)
 	{
// echo "<div><div>sqlr:".$sqlr."</div></div>";
  	$sqlr="insert into contexogenaforma_campos_conce (codigo, codcampo, concepto,cuenta,estado) values ('".$_POST[codigo]."','".$_POST[camposvar][$x]."','".$_POST[didconc][$x]."','".$_POST[didcuentas][$x]."','S') ";
  	 if (!mysql_query($sqlr,$linkbd))
	 {
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	// $e = mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>".mysql_error($linkbd);
     //echo htmlentities($e['sqltext']);
     //printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	 }
		else
 		{
  			echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado El Formato  <img src='imagenes/confirm.png'></center></td></tr></table>";
		 } 
 	}
 ?>
 <?php
  }
  else
  {
	   echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b></b></font></p>";
	// $e = mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>".mysql_error($linkbd);
     //echo htmlentities($e['sqltext']);
     //printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
  }
}
?>
 </td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>