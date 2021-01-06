<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: Spid - Contratacion</title>
<script>
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
//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.documento.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  }
 }

function validar()
{
	document.form1.submit();
}

function agregardetalle()
{
if(document.form1.cuenta.value!="" )
 {
document.form1.agregadet.value=1;
document.form1.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}

function agregaradqui()
{
if(document.form1.fecha.value!="" )
 {
document.form1.agregadetadq.value=1;
document.form1.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}

function eliminard(variable)
{
if (confirm("Esta Seguro de Eliminar "+variable))
  {
document.form1.eliminar.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('eliminar');
//eli.value=elimina;
vvend.value=variable;
// alert("Falta informacion para poder Agregar");
document.form1.submit();
}
}

function buscacta(e)
 {
if (document.form1.cuenta.value!="")
{
 document.form1.bc.value='1';
 document.form1.submit();
 }
 }
</script>
<script type="text/javascript" src="css/calendario.js"></script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
    <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
    <span id="todastablas2"></span>
    <table>
        <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
        <tr><?php menu_desplegable("contra");?></tr>
    	<tr>
  			<td colspan="3" class="cinta">
				<a class="mgbt"><img src="imagenes/add2.png"  title="Nuevo" /></a>
				<a class="mgbt"><img src="imagenes/guardad.png"  title="Guardar" /></a>
				<a class="mgbt"><img src="imagenes/buscad.png"  title="Buscar" border="0" /></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
			</td>
		</tr>
	</table>
	<div class="subpantalla" style="height:45%; width:99.5%; overflow-x:hidden">
    <form name="form1" method="post">
    <?php 
		if($_POST[oculto]!='')
		 {
			 $_POST[dproductos]=array();
			 $_POST[dproductos]=array();
			 $_POST[adqproductos][]=array();
			 $_POST[adqindice]=array();
			  $_POST[adqdescripcion]=array();
			   $_POST[adqfecha]=array();
			   $_POST[adqprodtodos]=array();
			  $_POST[dtipos]=array(); 
		 } 
		 //**** busca cuenta
		if($_POST[bc]=='1')
		{
			$nresul=buscaproducto($_POST[cuenta]);
			if($nresul!=''){$_POST[ncuenta]=$nresul;}
		 	else{$_POST[ncuenta]="";}
		}
    ?>
 	<table class="inicio" >
 		<tr>
 			<td colspan="8" class="titulos" style="width:90%">Adquisiciones Plan de Compras</td>
            <td class="cerrar" ><a href="contra-principal.php"> Cerrar</a></td>
       	</tr>
 		<tr>
        	<td  class="saludo1" style="width:8%" >Fecha Registro:</td>
          	<td style="width:10%"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:85%"><a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
            <td class="saludo1" style="width:10%">Fecha Estimada Inicio Selecci&oacute;n:</td>
            <td style="width:15%"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:85%"><a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
             <td class="saludo1" style="width:10%">Modalidad Selecci&oacute;n:</td>
             <td style="width:25%">
                <select name="modalidad" style="width:100%">
					<option value=''>Seleccione ...</option>
                	<?php
						$linkbd=conectar_bd();
                 		$sqlr="Select * from dominios  where nombre_dominio='MODALIDAD_SELECCION' and (valor_final IS NULL or valor_final ='') order by valor_inicial asc";
                   		$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$i=$row[0];
							echo "<option value=$row[0] ";
							if($i==$_POST[modalidad]){echo "SELECTED";}
							echo " >".$row[0]." - ".$row[2]."</option>";	  
						 }			
                   	?>
                </select>
			</td>
            <td class="saludo1" style="width:10%">Duraci&oacute;n Contrato (Meses):</td>
            <td style="width:3%"><input name="duracion" type="text" id="duracion"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[duracion]; ?>" style="width:100%"></td>
           
    	</tr>
		<tr>
        	<td class="saludo1" >Descripci&oacute;n:</td>
            <td colspan="3" ><input name="descripcion" type="text" value="<?php echo $_POST[descripcion]; ?>" style="width:100%"></td>
            <td class="saludo1">Fuente Recurso:</td>
            <td>
                <select name="fuente" style="width:100%">
					<option value=''>Seleccione ...</option>
                    <?php
						$linkbd=conectar_bd();
						$sqlr="Select * from pptosidefrecursos   order by codigo asc";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$i=$row[0];
							echo "<option value=$row[0] ";
							if($i==$_POST[fuente]){echo "SELECTED";}
							echo " >".$row[0]." - ".$row[1]."</option>";	  
						 }			
				  	?>
                </select>
			</td>
            <td class="saludo1">Valor Estimado</td>
            <td><input type="text" name="vlrestimado"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" value="<?php echo $_POST[vlrestimado]; ?>"></td>
     	<tr>
        	
            
 		</tr>
        <tr>
        	<td class="saludo1">Vlr Estimado Vig. Actual</td>
            <td><input type="text" name="vlrestimadoact"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" value="<?php echo $_POST[vlrestimadoact]; ?>"></td><td class="saludo1">Requiere Vigencias Futuras:</td>
            <td>
                <select name="requierev">
                    <option value=''>Seleccione ...</option>
                    <?php
					 	$linkbd=conectar_bd();
					 	$sqlr="Select * from dominios  where nombre_dominio='VIGENCIASF'   order by valor_inicial asc";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$i=$row[0];
							echo "<option value=$row[0] ";
							if($i==$_POST[requierev]){echo "SELECTED";}
							echo " >".$row[2]."</option>";	  
						 }			
                    ?>
                </select>
			</td>
			<td class="saludo1">Estado de Solicitud Vigencias Futuras:</td><td >
                <select name="estadorequierev">
                    <option value=''>Seleccione ...</option>
                    <?php
					 	$linkbd=conectar_bd();
					 	$sqlr="Select * from dominios  where nombre_dominio='ESTADO_VIGENCIASF'   order by valor_inicial asc";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$i=$row[0];
							echo "<option value=$row[0] ";
							if($i==$_POST[estadorequierev]){echo "SELECTED";}
							echo " >".$row[2]."</option>";	  
						 }			
  					?>
                </select>
			</td>
		</tr>
		<tr>
 			<td colspan="9" class="titulos2">Productos Adquisici&oacute;n</td>
        </tr>
	 	<tr>
        	<td class="saludo1">C&oacute;digo Producto:</td>
          	<td valign="middle" >
            	<input type="text" id="cuenta" name="cuenta"  onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" style="width:85%" >
          		<input type="hidden" value="0" name="bc">
                <a href="#" onClick="mypop=window.open('contra-productos-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
          	<td colspan='3'>
            	<input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>"  readonly>
                <input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" >
                <input type="hidden" value="0" name="agregadet"> 
                <input type="button" name="agregaadq" value="Agregar Adquisicion" onClick="agregaradqui()" >
                <input type="hidden" value="0" name="agregadetadq">
         	</td>
		</tr>
 	</table>
 	<table class="inicio" style="width:50%">
 		<tr>
        	<td class="titulos2">Codigo</td>
            <td class="titulos2">Nombre</td>
            <td class="titulos2">Tipo</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='eliminar' id='eliminar'></td>
     	</tr>
		<?php
			if($_POST[bc]=='1')
			{
				$nresul=buscaproducto($_POST[cuenta]);
				if($nresul!='')
				{
					$_POST[ncuenta]=$nresul;
					?><script>document.getElementById('agrega').focus();document.getElementById('agrega').select();</script><?php
				}
			   else
			   {
					$_POST[ncuenta]="";
					?><script>alert("Codigo Incorrect0");document.form2.cuenta.focus();</script><?php
               }
			}
			if ($_POST[eliminar]!='')
			{ 
				$posi=$_POST[eliminar];
				unset($_POST[dproductos][$posi]);
				unset($_POST[dnproductos][$posi]);
				unset($_POST[dtipos][$posi]);
				$_POST[dproductos]= array_values($_POST[dproductos]); 
				$_POST[dnproductos]= array_values($_POST[dnproductos]); 
				$_POST[dtipos]= array_values($_POST[dtipos]); 	
			}
			if ($_POST[agregadet]=='1')
			{
				$_POST[dproductos][]=$_POST[cuenta];
				$_POST[dnproductos][]=$_POST[ncuenta];		 
				$nt=buscaproductotipo($_POST[cuenta]);
				$_POST[dtipos][]=buscadominiov2("UNSPSC",$nt);
				$_POST[agregadet]=0;
		   	}
			$iter='saludo1';
			$iter2='saludo2';
			for ($x=0;$x<count($_POST[dproductos]);$x++)
			{		 
				echo "
					<tr class='$iter'>
						<td><input class='inpnovisibles' name='dproductos[]' value='".$_POST[dproductos][$x]."' type='text' ' readonly></td>
						<td><input class='inpnovisibles' name='dnproductos[]'  value='".$_POST[dnproductos][$x]."' type='text' readonly></td>
						<td><input class='inpnovisibles' name='dtipos[]' value='".$_POST[dtipos][$x]."' type='text'  readonly></td>";		
				 
				echo "<td><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";	
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
			}	
		?>
 	</table>
 	</div>
 	<div class="subpantallac" style="height:30%; width:99.5%; overflow-x:hidden">
 <table class="inicio">
 <tr><td class="titulos" colspan="10">ADQUISICIONES</td></tr>
 <tr><td class="titulos2">Codigo UNSPSC</td><td class="titulos2">Descripcion</td><td class="titulos2">Fecha Estimada</td><td class="titulos2">Duracion Estimada</td><td class="titulos2">Modalidad Seleccion</td><td class="titulos2">Fuente</td><td class="titulos2">Vlr Estimado</td><td class="titulos2">Vlr Estimado Vig Actual</td></tr>
 <?php
 if ($_POST[agregadetadq]=='1')
		 {
		 $indice=count($_POST[adqindice]);
		//	 echo "i:".$indice;
		 $_POST[adqindice][]=$indice;
		 $_POST[adqdescripcion][]=$_POST[descripcion];	
		 $_POST[adqfecha][]=$_POST[fecha2];	
		  $_POST[adqduracion][]=$_POST[duracion];	
		  $_POST[adqmodalidad][]=$_POST[modalidad];	
		  $_POST[adqfuente][]=$_POST[fuente];
		  $_POST[adqvlrestimado][]=$_POST[vlrestimado];
		  $_POST[adqvlrvig][]=$_POST[vlrestimadoact];			  		  
		  //echo "d:".$_POST[adqdetalles][$indice][1];	 
		 for($x=0;$x<count($_POST[dproductos]);$x++)
		  {
			$_POST[adqproductos][$indice][$x]=$_POST[dproductos][$x];
			// echo "<br>p:".$_POST[adqproductos][$indice][$x];  
		  }
		  $codigos=implode("<br>", $_POST[adqproductos][$indice]);
		  $_POST[adqprodtodos][]=$codigos;
		 //$nt=buscaproductotipo($_POST[cuenta]);
		// $_POST[dtipos][]=buscadominiov2("UNSPSC",$nt);
		 $_POST[agregadetadq]=0;
		 }
		  $co='saludo1';
	 $co2='saludo2';
		for($k=0;$k<count($_POST[adqdescripcion]); $k++  )
		 {
			 $codigos=$_POST[adqprodtodos][$k];		
		echo "<tr class='$co'><td><p>$codigos <input name='adqprodtodos[]' value='".$_POST[adqprodtodos][$k]."' type='hidden' ></p></td><td><input name='adqindice[]' value='".$_POST[adqindice][$k]."' type='hidden'><input name='adqdescripcion[]' value='".$_POST[adqdescripcion][$k]."' type='hidden' >".$_POST[adqdescripcion][$k]."</td><td><input name='adqfecha[]' value='".$_POST[adqfecha][$k]."' type='hidden' >".$_POST[adqfecha][$k]."</td><td><input name='adqduracion[]' value='".$_POST[adqduracion][$k]."' type='hidden' >".$_POST[adqduracion][$k]."</td><td><input name='adqmodalidad[]' value='".$_POST[adqmodalidad][$k]."' type='hidden' >".$_POST[adqmodalidad][$k]."</td><td><input name='adqfuente[]' value='".$_POST[adqfuente][$k]."' type='hidden' >".$_POST[adqfuente][$k]."</td><td><input name='adqvlrestimado[]' value='".$_POST[adqvlrestimado][$k]."' type='hidden' >".number_format($_POST[adqvlrestimado][$k],2)."</td><td><input name='adqvlrvig[]' value='".$_POST[adqvlrvig][$k]."' type='hidden' >".number_format($_POST[adqvlrvig][$k],2)."</td></tr>";	
		$aux=$co;
         $co=$co2;
         $co2=$aux; 
		 }
 ?>
 </table>
 </div>
   </form>
</td></tr>     
</table>
</body>
</html>