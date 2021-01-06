<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID- Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
<style>
		.c1 input[type="checkbox"]:not(:checked),
		.c1 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c1 input[type="checkbox"]:not(:checked) +  #t1,
		.c1 input[type="checkbox"]:checked +  #t1 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c1 input[type="checkbox"]:not(:checked) +  #t1:before,
		.c1 input[type="checkbox"]:checked +  #t1:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: -3 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c1 input[type="checkbox"]:not(:checked) +  #t1:after,
		.c1 input[type="checkbox"]:checked + #t1:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c1 input[type="checkbox"]:not(:checked) +  #t1:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c1 input[type="checkbox"]:checked +  #t1:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c1 input[type="checkbox"]:disabled:not(:checked) +  #t1:before,
		.c1 input[type="checkbox"]:disabled:checked +  #t1:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c1 input[type="checkbox"]:disabled:checked +  #t1:after {
		  color: #999 !important;
		}
		.c1 input[type="checkbox"]:disabled +  #t1 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c1 input[type="checkbox"]:checked:focus + #t1:before,
		.c1 input[type="checkbox"]:not(:checked):focus + #t1:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c1 #t1:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t1{
			background-color: white !important;
		}
		</style>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
function validar()
{
var x = document.getElementById("tipop").value;
document.form2.codigo.value=x;
document.form2.submit();
}
function agregardetalle()
{
if(document.form2.tipop.value!="" &&  document.form2.tasa.value!=""  )
{ 
				document.form2.agregadet.value=1;
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
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.vigencia.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
	//document.form2.action="pdfcdp.php";
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.tercero.focus();
  	document.form2.tercero.select();
  }
}
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
 
 function validafinalizar(e){
	 var id=e.id;
	 var check=e.checked;
	 if(id=='avaluoc'){
		 document.form2.fijo.checked=false;
	 }else{
		 document.form2.avaluoc.checked=false;
	 }
	 var x = document.getElementById("tipop").value;
	 document.form2.submit();
 }
</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta">
  <a href="teso-tarifaspredial.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
  <a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
  <a href="teso-editatarifaspredial.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a>
  <a href="#" class="mgbt" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
 ?>	
<?php
if(!$_POST[oculto])
{
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	 $_POST[vigencia]=$vigusu; 	
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		 
}
if ($_POST[chacuerdo]=='2')
					 {
				    $_POST[dcuentas]=array();
				    $_POST[dncuetas]=array();
				    $_POST[dingresos]=array();
				    $_POST[dgastos]=array();
					$_POST[arreglotipo]=array();
					$_POST[arreglorango]=array();
					$_POST[dtcuentascod]=array();
					$_POST[diferencia]=0;
					$_POST[cuentagas]=0;
					$_POST[cuentaing]=0;																			
					 }	
?>

<form  name="form2" method="post" action="">
 <?php if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
			 
			 ?>
 
    <table class="inicio" align="center" >
      	<tr >
        	<td style="width:97%;" class="titulos" colspan="7">Tarifas Predial</td>
        	<td style="width:3%;" class="cerrar" >
        		<a href="teso-principal.php">  Cerrar</a>
        	</td>
        </tr>
      	<tr >
      		<td style="width:10%;" class="saludo1">Vigencia:</td>
      		<td style="width:20%;">
      			<input type="text" name="vigencia" value="<?php echo $_POST[vigencia]?>" style="width: 40%"  readonly>
      		</td>
      		<td  style="width:10%;" class="saludo1">Tipo:</td>
      		<td  style="width: 25%"><select name="tipop" onChange="validar();" id="tipop">
       <option value="">Seleccione ...</option>
		<?php
				$linkbd=conectar_bd();
				$sql="SELECT codigo,nombre FROM teso_clasificapredios GROUP BY codigo,nombre";
				$result=mysql_query($sql,$linkbd);
				$check="";
				if(isset($_POST[tipop])){
					if(!empty($_POST[tipop])){
					$check="SELECTED";
					}
				}

				while($row = mysql_fetch_array($result)){
					if(!empty($check)){
						if($row[0]==$_POST[tipop]){
							echo "<option value='$row[0]' $check >$row[1]</option>";
						}else{
							echo "<option value='$row[0]'>$row[1]</option>";
						}
					}else{
						echo "<option value='$row[0]'>$row[1]</option>";
					}
				}

			?>
		</select>
		<input type="hidden" name='codigo' id="codigo" val="<?php echo $_POST[codigo]; ?>" />
		</td>
		<td  style="width:10%;" class="saludo1">Por Avaluo:</td> <td> <div class="c1"><input type="checkbox" id="avaluoc" name="avaluoc"  onChange="validafinalizar(this)" <?php if($_POST[avaluoc]!=""){echo "checked"; } ?> /><label for="avaluoc" id="t1" ></label><input type="text"  name="num1" value="<?php echo $_POST[num1]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 18%;text-align: center;margin-left: 3%" <?php if($_POST[avaluoc]==""){echo "readonly"; } ?> > <span>- </span> <input type="text"  name="num2" value="<?php echo $_POST[num2]?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 18%;text-align: center" <?php if($_POST[avaluoc]==""){echo "readonly"; } ?> ></div></td>
         	<?php
		 		if($_POST[tipop]=='urbano')
		 		{
		  		?> 
		</tr>
       	<tr>
          	<td style="width:10%;" class="saludo1">Estratos:</td>
          	<td >
          		<select name="estrato" >
       				<option value="">Seleccione ...</option>
            		<?php
						$linkbd=conectar_bd();
						$sqlr="select *from estratos where estado='S'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
				    	{
							echo "<option value=$row[0] ";
							$i=$row[0];
							if($i==$_POST[estrato])
			 				{
						 		echo "SELECTED";
						 		$_POST[nestrato]=$row[1];
						 	}
					  	echo ">".$row[1]."</option>";	 	 
						}	 	
					?>            
				</select>  
				<input type="hidden" value="<?php echo $_POST[nestrato]?>" name="nestrato">
            </td>  
        	<?php
		 		}
		 		else
		  		{
			?>  
		</tr>
       	<tr>
			<td style="width:10%;" class="saludo1">Rango Avaluo:</td>
            <td style="width:20%;">
           		<select name="rangos" >
					<option value="">Seleccione ...</option>
					<?php
						$linkbd=conectar_bd();
						if(isset($_POST[tipop])){
							if(!empty($_POST[tipop])){
								$sql="SELECT id_rango,nom_rango FROM teso_clasificapredios WHERE codigo=$_POST[tipop]";
								$result=mysql_query($sql,$linkbd);
								while($row = mysql_fetch_array($result)){
								echo "<option value='$row[0]'>$row[1]</option>";
								}
							}
						} 	
						?>            
			</select>
            	<input type="hidden" value="<?php echo $_POST[nrango]?>" name="nrango">
            </td>  
           <?php
		  		}
		  	?>  
     		<td style="width:10%;"  class="saludo1">Valor:</td>
     		<td >
     			<input type="text"  name="tasa" value="<?php echo $_POST[tasa]?>" maxlength="4" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)">&nbsp; 	&nbsp; 	&nbsp; 	&nbsp; Por Mil 
     			<input type="hidden" value="0" name="agregadet">  
     			<input type="hidden" value="0" name="oculto">	
     		</td>
			<td  style="width:10%;" class="saludo1">Fijo:</td> <td> <div class="c1"><input type="checkbox" id="fijo" name="fijo"  onChange="validafinalizar(this)" <?php if($_POST[fijo]!=""){echo "checked"; } ?> /><label for="fijo" id="t1" ></label><input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" style="margin-left: 12%"></div></td>
     	</tr>     	     
    </table>
	 	   <div class="subpantallac2" style="height:63.5%; width:99.6%; overflow-x:hidden;">
	   <table class="inicio">
	   <tr>
          <td class="titulos" colspan="6">Detalle Tarifas</td>
        </tr>
		<tr>
		<td class="titulos2">Estratos/Rango</td>
		<td class="titulos2">Tipo</td>
		<td class="titulos2">Tasifica por</td>
		<td class="titulos2">Rango</td>
		<td class="titulos2">Tasa</td><td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td>
		</tr>
		<?php 
		
		  //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
			  <script>
			  document.getElementById('banco').focus();document.getElementById('banco').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			  }
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		 unset($_POST[dcuentas][$posi]);
		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dtcuentas][$posi]);
		 unset($_POST[dtcuentascod][$posi]);		 
 		 unset($_POST[dvalores][$posi]);
		 unset($_POST[arreglotipo][$posi]);
		 unset($_POST[arreglorango][$posi]);
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]); 
  		 $_POST[dtcuentas]= array_values($_POST[dtcuentas]); 
		 $_POST[dtcuentascod]= array_values($_POST[dtcuentascod]); 
		 $_POST[dvalores]= array_values($_POST[dvalores]);
		 $_POST[arreglotipo]= array_values($_POST[arreglotipo]);
		 $_POST[arreglorango]= array_values($_POST[arreglorango]); 		 
		 }	 
		if ($_POST[agregadet]=='1')
		 {
		 	 $sqlr="select nombre,nom_rango from teso_clasificapredios where codigo='".$_POST[tipop]."' AND id_rango='".$_POST[rangos]."' ";
		 $res=mysql_query($sqlr,$linkbd);
		 $row = mysql_fetch_array($res);
		 $_POST[dcuentas][]=$_POST[rangos];
		  $_POST[dtcuentascod][]=$_POST[tipop];
		 $_POST[dncuentas][]=$row[1];	
		 $_POST[dtcuentas][]=$row[0];		 
		 $_POST[dvalores][]=$_POST[tasa];
		 if($_POST["fijo"]!=''){
			$_POST[arreglotipo][]="FIJO"; 
			$_POST[arreglorango][]=" "; 
		 }
		  if($_POST["avaluoc"]!=''){
			$_POST[arreglotipo][]="AVALUO";
			$_POST[arreglorango][]=$_POST[num1]." - ".$_POST[num2]; 			
		 }
		 
		 $_POST[agregadet]=0;
		  ?>
		 <script>
				document.form2.banco.value="";
				document.form2.nbanco.value="";
				document.form2.cb.value="";
				document.form2.cuenta.select();
		  		document.form2.cuenta.focus();	
		 </script>
		  <?php
		  }
		  
		 for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 {		 
		 echo "<tr class='saludo2'>
		 		<td style='width:25%;'>
		 			<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='hidden'>
		 			<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text'  readonly class='inpnovisibles' style='width: 100%'>
		 		</td>
		 		<td style='width:20%;'>
				    <input name='dtcuentascod[]' value='".$_POST[dtcuentascod][$x]."' type='hidden'>
		 			<input name='dtcuentas[]' value='".$_POST[dtcuentas][$x]."' type='text'  class='inpnovisibles' style='width: 100%'>
		 		</td>
				<td style='width:20%;'>
		 			<input name='arreglotipo[]' value='".$_POST[arreglotipo][$x]."' type='text'  class='inpnovisibles' style='width: 100%'>
		 		</td>
				<td style='width:10%;'>
		 			<input name='arreglorango[]' value='".$_POST[arreglorango][$x]."' type='text'  class='inpnovisibles' style='width: 100%'>
		 		</td>
		 		<td style='width:10%;'>
		 			<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text'  class='inpnovisibles' style='width: 100%'>
		 		</td>
		 		<td style='width:5%;'>
		 			<a href='#' onclick='eliminar($x)'>
		 				<img src='imagenes/del.png'>
		 			</a>
		 		</td>
		 	</tr>";
		 }
		?>
	   </table>
	   </div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$sqlr="delete from tesotarifaspredial where vigencia=".$_POST[vigencia];
	mysql_query($sqlr,$linkbd);
	//************** modificacion del presupuesto **************
	for($x=0;$x<count($_POST[dcuentas]);$x++)
	 {
	$sqlr="insert into tesotarifaspredial(vigencia,tipo,estratos,ha,avaluo,tasa,estado) values('".$_POST[vigencia]."','".$_POST[dtcuentascod][$x]."','".$_POST[dcuentas][$x]."','','','".$_POST[dvalores][$x]."','S')";	  
	if (!mysql_query($sqlr,$linkbd))
	{
		
		
		
	 echo "<table class='inicio'><tr class='saludo1'><td><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  		else
  		 {
			 $opctipo="";
		$val1=0;
		$val2=0;
		if($_POST[arreglotipo][$x]=="FIJO"){
			$opctipo="F";
		}else{
			$opctipo="A";
			$arreglo=explode("-",$_POST[arreglorango][$x]);
			$val1=$arreglo[0];
			$val2=$arreglo[1];
		}
		$sql="UPDATE teso_clasificapredios SET avaluo_fijo='$opctipo',val1=$val1 ,val2=$val2 WHERE codigo='".$_POST[dtcuentascod][$x]."' AND  id_rango='".$_POST[dcuentas][$x]."'  ";
		mysql_query($sql,$linkbd);
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado las Tarifas con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
		  ?>
		  <script>
		  document.form2.tercero.value="";
		  document.form2.ntercero.value="";
		  </script>
		  <?php
		  }
	}	  
}

?>	
   </form>
</table>
</body>
</html>