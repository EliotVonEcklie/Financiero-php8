<?php //V 1000 12/12/16 ?> 
<!--V 1.0-->
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script src="css/programas.js"></script>
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
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
function guardar()
 {

if (confirm("Esta Seguro de Guardar"))
  {
document.form2.oculto.value=2;


document.form2.action="presu-cuentaspasivaadd.php";
document.form2.submit();
  }
 }
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
function buscactap(e)
 {
if (document.form2.cuentap.value!="")
{
 document.form2.bcp.value='1';
 document.form2.submit();
 }
 }
</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><a href="presu-cuentaspasivaadd.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="presu-cuentaspasiva.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>	
        </table>	  
<tr><td colspan="3" class="tablaprin" align="center"> 
 <form name="form2" method="post" action="presu-cuentaspasivaadd.php">
 <?php
 $link=conectar_bd();
 $vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
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
 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="10">.: Agregar Cuentas Gastos </td>
        <td class="cerrar" ><a href="presu-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
	  <td class="saludo1">Cuenta:
        </td>
        <td><input name="cuentap" type="text" value="<?php echo $_POST[cuentap]?>" size="25"  onKeyUp="return tabular(event,this)" onBlur="buscactap(event)"><input type="hidden" value="0" name="bcp" >
        </td>
        <td class="saludo1">Descripción:
        </td>
        <td colspan="1">  <input name="descripcion" type="text" value="<?php echo $_POST[descripcion]?>" size="70" onKeyUp="return tabular(event,this)">
        </td>
		      
	   <td class="saludo1">Nomina:
        </td>
        <td><select name="nomina" id="nomina" >
          <option value="S" <?php if($_POST[nomina]=='S') echo "SELECTED"?>>S</option>
          <option value="N"<?php if($_POST[nomina]=='N') echo "SELECTED"?>>N</option>
        </select>    </td>
    	      
	   <td class="saludo1">Tipo:
        </td>
        <td><select name="tipo" id="tipo" onChange="document.form2.submit()">
          <option value="Mayor" <?php if($_POST[tipo]=='Mayor') echo "SELECTED"?>>Mayor</option>
          <option value="Auxiliar"<?php if($_POST[tipo]=='Auxiliar') echo "SELECTED"?>>Auxiliar</option>
        </select>   <input name="oculto" type="hidden" value="1">     </td></tr>
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
				$i=strtolower($row[2]);
				echo "<option value='".strtolower($row[2])."' ";
				if(0==strcmp($i,strtolower($_POST[clasificacion])))
			 	{
				 echo "SELECTED";
				 }
				echo " >".$row[2]."</option>";	  
			     }			
				?>        
        </select>    </td>      
        <td class="saludo1">Sector:
        </td>
        <td>
        <select name="sectores" id="sectores" onChange="">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from presusectores order by sector ASC";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[sectores])
			 	{
				 echo "SELECTED";
				 }
				echo " >".$row[0]."</option>";	  
			     }			
				?>
				  </select></td>
	    </tr>                
    </table>
   
   
   <?php
				if ($_POST[tipo]=='Auxiliar')
				 { $link=conectar_bd();
				?>
				<table class="inicio" width="99%">
				<tr><td class="titulos2" colspan="5">Conceptos</td></tr>
				<tr >
				  <td width="119" class="saludo1" >Concepto Pago:</td>
				  <td width="307"  ><select name="concepago" id="concepago" onChange="document.form2.submit();">
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
				  <td  >
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
				  </select>
 
			      </td>
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
				<div class="subpantallac2">
				<table class="inicio" width="99%">				
			    <tr >
			      <td height="25" colspan="8" class="titulos2" >C.G.R.</td>
			    </tr>
				<tr >
				  <td class="saludo1" >Cod 	:</td>
				  <td  ><select name="cgrclas" id="cgrclas" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefclas  where nivel='D'  AND LEFT(codigo,1)>'2'order by codigo";
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
				  <td class="saludo1" >Vigencia:</td>
				  <td  ><select name="cgrvigencia" id="cgrvigencia" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptosidefgasto order by codigo";
//			 echo $sqlr;
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
//			 echo $sqlr;
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
//			 echo $sqlr;
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
			<?php
			 //*** 
			// $codpas=substr($_POST[cuenta],0,1);
	
	// echo "cod:$codpas";
 			$codpas=substr($_POST[cuentap],0,1);
 			if($codpas=='R' || $codpas=='r')
					 {						
					$codpas=substr($_POST[cuentap],1,1);						  
					 }


			 switch(strtolower($_POST[clasificacion]))
			  {
			   case "funcionamiento":  //*****funcionamiento
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
//			 echo $sqlr;
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
//			 echo $sqlr;
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
//			 echo $sqlr;
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
				 case "deuda": //*** Deuda Publica
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
//			 echo $sqlr;
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
//			 echo $sqlr;
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
//			 echo $sqlr;
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
				 case "inversion":  //**** Inversion
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
//			 echo $sqlr;
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
//			 echo $sqlr;
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
				  case "reservas-gastos":  //**** RESERVAS GASTOS
				 ?>
				<table class="inicio" width="99%">				
			    <tr >
			      <td height="25" colspan="4" class="titulos2" >F.U.T. - INVERSION</td>
			    </tr>
				<tr>				
				  <td class="saludo1" >Codigo Reservas:</td>
				  <td  ><select name="futreservas" id="futreservas" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutreservas  order by codigo";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futreservas])
			 	{
				 echo "SELECTED";
				 $_POST[futreservasnom]=$row[1];
				 }
				echo " >".$row[0]."-".substr($row[1],0,50)."</option>";	  
			     }			
				?>
				  </select>
			      </td>
 				  <td class="saludo1" >Codigo Reservas nombre:</td>
				  <td  ><input name="futreservasnom" type="text" size="80" value="<?php echo $_POST[futreservasnom]?>"></td>
			    </tr>
                
                <tr>				
				  <td class="saludo1" >Fuente Inversion:</td>
				  <td  ><select name="futfuenteinv" id="futfuenteinv" onChange="document.form2.submit();">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from pptofutfuenteinv  order by codigo";
//			 echo $sqlr;
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
               <tr>				
				  <td class="saludo1" >Tipo Acto Admin:</td>
                  <td><select name="futtipoacto" id="futtipoacto" onChange="">
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="Select * from dominios where nombre_dominio='TIPOS_ACTOS'  order by VALOR_INICIAL";
//			 echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[futtipoacto])
			 	{
				 echo "SELECTED";	
				 }
				echo " >".$row[0]."-".substr($row[2],0,100)."</option>";	  
			     }			
				?>
				  </select></td>
    			  <td class="saludo1" >No Acto Admin:</td>
                  <td><input type="text" name="nacto" value="<?php echo $_POST[nacto]?>"></td>
                 </tr>  
               <tr>				
				  <td class="saludo1" >Fecha Acto Admin:</td>
                  <td><input type="date" name="dacto" value="<?php echo $_POST[dacto]?>"></td>
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
$oculto=$_POST['oculto'];

if($_POST[oculto]==2)
{
		$fec=date("d/m/Y");
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fec,$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
 ?>

<script>
	document.form2.oculto.value=1;
	document.form2.descripcion.value="";
	document.form2.cuenta.value="";
</script>
<?php
//***************************guardar
$linkbd=conectar_bd();
if ($_POST[cuentap]!="" and $_POST[descripcion]!="")
{
							
 $codpas=substr($_POST[cuentap],0,1);
 if($codpas=='R' || $codpas=='r')
					 {						
					$codpas=substr($_POST[cuentap],1,1);						  
					 }
					 	
 switch($_POST[clasificacion])
			  {
			   case 'funcionamiento':
			   $sqlr="INSERT INTO pptocuentas(cuenta,nombre,tipo,estado,`sidefclas`, `sidefrecur`, `sideforigen`, `sidefdest`, `sideftercero`, `sidefgasto`, `sidefgastofin`, `sidefdep`, `sideffondos`, `futcodfun`, `futdependencias`, `futfuentefunc`,`codconcepago`,codconcecausa ,nomina,vigencia,vigenciaf,pptoinicial,clasificacion,futreservas,futsgring,futsgrgas,tipoacto,numacto,fechaacto) VALUES ('".strtoupper($_POST[cuentap])."','".utf8_decode($_POST[descripcion])."','$_POST[tipo]','S','$_POST[cgrclas]','$_POST[cgrrecu]','$_POST[cgrtercero]','$_POST[cgrorigen]','$_POST[cgrvigencia]','$_POST[cgrfinalidad]','$_POST[cgrdependencia]','$_POST[cgrsituacion]','$_POST[cgrdest]',',$_POST[futcodfun]','$_POST[futdependencia]','$_POST[futfuentefunc]','$_POST[concepago]','$_POST[concecausa]','$_POST[nomina]','".$vigusu."','".$vigusu."',0,'$_POST[clasificacion]', '$_POST[futreservas]', '', '$_POST[futregalias]', '$_POST[futtipoacto]', '$_POST[nacto]', '$_POST[dacto]')";
			   break;	
			   
			   case 'deuda':
$sqlr="INSERT INTO pptocuentas(cuenta,nombre,tipo,estado,sidefclas,sidefrecur,sideftercero,sideforigen,sidefgasto,sidefgastofin,sidefdep,sideffondos, sidefdest,codconcepago,codconcecausa, futcodfun, futtipodeuda,futtipooper,futfuenteinv,codconcepago,codconcecausa ,nomina,vigencia,vigenciaf,pptoinicial,clasificacion,futreservas,futsgring,futsgrgas,tipoacto,numacto,fechaacto) VALUES ('".strtoupper($_POST[cuentap])."','".$_POST[descripcion]."','$_POST[tipo]','S','$_POST[cgrclas]','$_POST[cgrrecu]','$_POST[cgrtercero]','$_POST[cgrorigen]','$_POST[cgrvigencia]','$_POST[cgrfinalidad]','$_POST[cgrdependencia]','$_POST[cgrsituacion]','$_POST[cgrdest]','$_POST[concepago]','$_POST[cuenta]','$_POST[futcoddeuda]','$_POST[futtipodeuda]','$_POST[futtipooper]','$_POST[futfuenteinv]','$_POST[concecausa]','$_POST[nomina]','$_POST[nomina]','".$vigusu."','".$vigusu."',0,'$_POST[clasificacion]', '$_POST[futreservas]', '', '$_POST[futregalias]', '$_POST[futtipoacto]', '$_POST[nacto]', '$_POST[dacto]')";
			break;
			
			case 'inversion':
$sqlr="INSERT INTO pptocuentas(cuenta,nombre,tipo,estado,sidefclas,sidefrecur,sideftercero,sideforigen,sidefgasto,sidefgastofin,sidefdep,sideffondos, sidefdest,futinversion,futfuenteinv,codconcepago,codconcecausa,vigencia,nomina,vigenciaf,pptoinicial,clasificacion,futreservas,futsgring,futsgrgas,tipoacto,numacto,fechaacto) VALUES ('".strtoupper($_POST[cuentap])."','".$_POST[descripcion]."','$_POST[tipo]','S','$_POST[cgrclas]','$_POST[cgrrecu]','$_POST[cgrtercero]','$_POST[cgrorigen]','$_POST[cgrvigencia]','$_POST[cgrfinalidad]','$_POST[cgrdependencia]','$_POST[cgrsituacion]','$_POST[cgrdest]','$_POST[futinversion]','$_POST[futfuenteinv]','$_POST[concepago]','$_POST[concecausa]','".$vigusu."','$_POST[nomina]','".$vigusu."',0,'$_POST[clasificacion]', '$_POST[futreservas]', '', '$_POST[futregalias]', '$_POST[futtipoacto]', '$_POST[nacto]', '$_POST[dacto]')";
			break;
			case 'sgr-gastos':
$sqlr="INSERT INTO pptocuentas(cuenta,nombre,tipo,estado,sidefclas,sidefrecur,sideftercero,sideforigen,sidefgasto,sidefgastofin,sidefdep,sideffondos, sidefdest,futinversion,futfuenteinv,codconcepago,codconcecausa,vigencia,nomina,vigenciaf,pptoinicial,clasificacion,futreservas,futsgring,futsgrgas,tipoacto,numacto,fechaacto) VALUES ('".strtoupper($_POST[cuentap])."','".$_POST[descripcion]."','$_POST[tipo]','S','$_POST[cgrclas]','$_POST[cgrrecu]','$_POST[cgrtercero]','$_POST[cgrorigen]','$_POST[cgrvigencia]','$_POST[cgrfinalidad]','$_POST[cgrdependencia]','$_POST[cgrsituacion]','$_POST[cgrdest]','$_POST[futinversion]','$_POST[futfuenteinv]','$_POST[concepago]','$_POST[concecausa]','".$vigusu."','$_POST[nomina]','".$vigusu."',0,'$_POST[clasificacion]', '$_POST[futreservas]', '', '$_POST[futregalias]', '$_POST[futtipoacto]', '$_POST[nacto]', '$_POST[dacto]')";
			break;			
		case 'reservas-gastos':
$sqlr="INSERT INTO pptocuentas(cuenta,nombre,tipo,estado,sidefclas,sidefrecur,sideftercero,sideforigen,sidefgasto,sidefgastofin,sidefdep,sideffondos, sidefdest,futinversion,futfuenteinv,codconcepago,codconcecausa,vigencia,nomina,vigenciaf,pptoinicial,clasificacion,futreservas,futsgring,futsgrgas,tipoacto,numacto,fechaacto) VALUES ('".strtoupper($_POST[cuentap])."','".$_POST[descripcion]."','$_POST[tipo]','S','$_POST[cgrclas]','$_POST[cgrrecu]','$_POST[cgrtercero]','$_POST[cgrorigen]','$_POST[cgrvigencia]','$_POST[cgrfinalidad]','$_POST[cgrdependencia]','$_POST[cgrsituacion]','$_POST[cgrdest]','$_POST[futinversion]','$_POST[futfuenteinv]','$_POST[concepago]','$_POST[concecausa]','".$vigusu."','$_POST[nomina]','".$vigusu."',0,'$_POST[clasificacion]', '$_POST[futreservas]', '', '$_POST[futregalias]', '$_POST[futtipoacto]', '$_POST[nacto]', '$_POST[dacto]')";
			break;
	  }
 
  if (!mysql_query($sqlr,$linkbd))
	{
	 	echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	 	echo "Ocurrió el siguiente problema:<br>";
  	 	echo "<pre>";
     	echo "</pre></center></td></tr></table>";
	}
  else
  	{
  		echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado con Exito</center></td></tr></table>";
		if($_POST[tipo]=='Auxiliar')
	   {
		 //$sqlr="INSERT INTO pptocuentaspptoinicial (cuenta,fecha,vigencia,valor,estado, pptodef, saldos, saldoscdprp, id_acuerdo, cxp, ingresos,pagos,vigenciaf) values ('".strtoupper($_POST[cuentap])."','$fechaf','$vigusu',0,'S',0,0,0,0,0,0,0,$vigusu)";
		 //mysql_query($sqlr,$linkbd);
		 
		 $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$_POST[cuentap]."','','PPTO INICIAL(CUENTA CREADA MANUALMENTE)',0,0,1,'$vigusu',1,'$vigusu')";
	 	 mysql_query($sqlr,$linkbd); 
		// echo $sqlr;
		}
  	}
 }
else
	echo "<table class='inicio'><tr><td class='saludo1'><center>Falta informacion para Crear la Cuenta</center></td></tr></table>";
	}
//********* validacion ***********			
			//echo "".$_POST[bcp];	
			if($_POST[bcp]=='1')
			 {
				$r1='';
			 	$dig=substr($_POST[cuentap],0,1);
				$cant=strlen($_POST[cuentap]);
				if($dig=='R' || $dig=='r')
					 {
					$cant=strlen($_POST[cuentap])-1;	
					$r1=substr($_POST[cuentap],1,1);				
					$ini=1;			  
					 }
					 else
					 {
					$cant=strlen($_POST[cuentap]);
					$r1=2;
					$ini=0;
					 }		
					// echo "$r1";	
					if ($dig=='-' && ($dig<>'R' || $r1=='-' || $dig<>'r'))					
						{
							?><script>alert("Esta cuenta no es de gasto ...!. No se puede crear  "); 
							document.form2.cuenta.focus();
							</script><?php
			 			}
			 		else
			 			{ 
							$nresul=existecuentain($_POST[cuentap]);
			  				if($nresul!='')
			   					{		  
  			  					?>
			  					<script> res="<?php echo $nresul ?>";
			   					alert("Esta cuenta ya existe su descripcion es "+res);
			   					document.form2.cuenta.focus();
			  					document.getElementById('cuentap').focus();document.getElementById('cuentap').select();</script>
			  					<?php
			  					}			 				
							else
			 					{
								if($cant>1)
			 						{
			  							$linkbd=conectar_bd();
										$sqlr="select *from nivelesctasgas where posiciones=$cant";
			  							$res=mysql_query($sqlr,$linkbd);
			  							$con=mysql_fetch_row($res);																			
										$ncuen=substr($_POST[cuentap],'0',$cant-$con[1]-$ini);
										$resultado=existecuentain($ncuen);
										if($resultado!='')
											{ 																							
												$ncuen=substr($_POST[cuentap],'0',$cant-$con[1]-$ini);
												$stipo=mayaux($ncuen);																								
												if ($stipo=='Mayor')
												{
												?>
												<script>
												document.form2.descripcion.focus(); </script>
												<?php }
												else
												{
													?>	<script> alert("La anterior cuenta es auxiliar... No se puede crear otra ");
													document.form2.cuentap.focus();
													</script><?php
			  									}						
											}					
										else
											{?>	<script> alert("Error cantidad de digitos");
												document.form2.cuentap.focus();
												</script><?php
											}
								 } 
							}
			 		//		else
					//		{	?>
			  				<script>
			  		//		  alert("No existe cuenta mayor para crear esta cuenta");</script>
			   				<?php	//}
						//}
			//			else
				//		{	
						?>
			  				<script>
			  //				  document.form2.tipo.value='Mayor';
			   //				  document.form2.descripcion.focus();</script>	
							<?php	
						}					 
			 }
?>			 
</td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>