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
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
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
function validar()
{
document.form2.submit();
}
function agregardetalle()
{
if(document.form2.valor.value!="" &&  document.form2.concecont.value!="")
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.vavlue=2;
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
if (document.form2.codigo.value!='' && document.form2.nombre.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
 else{
  alert('Faltan datos para completar el registro');
  	document.form2.codigo.focus();
  	document.form2.codigo.select();
  }
 }
	function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					document.form2.action="presu-editacodigosconpes.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
					document.form2.action="presu-editacodigosconpes.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
	function iratras(scrtop, numpag, limreg, filtro){
		var idcta=document.getElementById('codigo').value;
		location.href="presu-buscacodigosconpes.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
            <tr>
  				<td colspan="3" class="cinta">
				<a href="presu-codigosconpes.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
				<a href="presu-buscacodigosconpes.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
				<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
			</tr>	  
		</table>
<?php
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
 	 $linkbd=conectar_bd();
	if ($_GET[is]!=""){echo "<script>document.getElementById('codrec').value=$_GET[is];</script>";}
			$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from presuingresoconpes ORDER BY CONVERT(codigo, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[is]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from presuingresoconpes where codigo='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from presuingresoconpes where codigo ='$_GET[is]'";
					}
				}
				else{
					$sqlr="select * from  presuingresoconpes ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
			}
			
			if($_POST[oculto]!="2")
			{
 	
				$sqlr="select *from presuingresoconpes where codigo='$_POST[codigo]'";
//echo $sqlr;
 $cont=0;
 	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp))
	{	 $_POST[codigo]=$row[0];
		 $_POST[nombre]=$row[1]; 	
 	 	 $_POST[tipo]=$row[2];
		 $_POST[terceros]=$row[4];
	}	 
	$sqlr="select *from presuingresoconpes INNER JOIN presuingresoconpes_det ON presuingresoconpes.codigo=presuingresoconpes_det.codigo where   presuingresoconpes.codigo='$_POST[codigo]' and vigencia='$vigusu' ";
//echo $sqlr;
 $cont=0;
 	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp))
	{	/* $_POST[codigo]=$row[0];
		 $_POST[nombre]=$row[1]; 	
 	 	 $_POST[tipo]=$row[2];
		 $_POST[terceros]=$row[4];*/
		 $_POST[cuenta]=$row[11];
		 $_POST[ncuenta]=buscacuentapres($row[11],1);
		 $_POST[valor]=$row[10];			 
		 $_POST[concecont]=$row[6];	
		 $cont=$cont+1; 
	}
}
//NEXT
			$sqln="select *from presuingresoconpes WHERE codigo > '$_POST[codigo]' ORDER BY codigo ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from presuingresoconpes WHERE codigo < '$_POST[codigo]' ORDER BY codigo DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";
?>

 <form name="form2" method="post" action="">
 <?php //**** busca cuenta
  			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],1);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=utf8_decode($nresul);
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
			 
			 ?> 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="8">.: Editar Ingresos</td>
        <td width="112" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td width="90" class="saludo1">Codigo:        </td>
        <td style="10%">
		<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
		<input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" style="width:40%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> 
		<a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
		<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
		<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
		<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
		</td>
        <td width="147" class="saludo1">Nombre Ingreso:        </td>
        <td width="644"><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="80" onKeyUp="return tabular(event,this)">   <input name="oculto" id="oculto" type="hidden" value="1">     </td>
       </tr> 
      </table>	
	   <table class="inicio">
	   <tr><td colspan="4" class="titulos">Agregar Detalle Ingreso</td></tr>                  
	  <tr>
	  <td class="saludo1">Conceptos contables Compes:</td><td><select name="concecont" id="concecont" >
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="select *from conceptoscontables where conceptoscontables.tipo='CP' and conceptoscontables.modulo='3' ".$crit1." order by conceptoscontables.codigo";
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
				  </select><input id="concecontnom" name="concecontnom" type="hidden" value="<?php echo $_POST[concecontnom]?>" ></td></tr>        
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
 $sqlr="update presuingresoconpes  set nombre='".utf8_decode($_POST[nombre])."',estado='S' where codigo = '$_POST[codigo]'";
 //echo "sqlr:".$sqlr;
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
  echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado el Codigo Conpes con Exito</h2></center></td></tr></table>";
  
		//******
		$sqlr="delete from presuingresoconpes_det where codigo ='$_POST[codigo]' and vigencia='$vigusu' ";		
		mysql_query($sqlr,$linkbd);
		$sqlr="INSERT INTO presuingresoconpes_det (codigo,concepto,modulo,tipoconce,cuentapres,estado, vigencia)VALUES ('$_POST[codigo]','".$_POST[concecont]."','4', 'S',  '".$_POST[cuenta]."','S', '$vigusu')";
//		$sqlr="update tesoingresos_det set codigo='$_POST[codigo]',concepto='$_POST[concecont]',modulo='4',tipoconce='S',porcentaje='$_POST[valor]',cuentapres='$_POST[cuenta]',estado='S' where codigo='$_POST[codigo]'";
// 		echo "sqlr:".$sqlr;
  		if (!mysql_query($sqlr,$linkbd))
  		{
		echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
 			 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Detalle del Codigo Conpes con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
		//****
	  	 	}  
	}
	
 }
else
 {
  echo "<table class='inicio'><tr><td class='saludo1'><center>Falta informacion para Crear el Codigo Conpes <img src='imagenes\alert.png'></center></td></tr></table>";
 }
}
?> </td></tr>
     
</table>
				 							<script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('¿Realmente desea cambiar la vigencia?');
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
</body>
</html>