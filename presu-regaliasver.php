<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require"conversor.php";
	require"validaciones.inc";
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
		<meta http-equiv="expira" content="no-cache">
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/cssrefresh.js">
        <script type="text/javascript" src="botones.js"></script>
		<script src="JQuery/jquery-2.1.4.min.js"></script>
        <script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
<script>

function guardar()
{
	var concepto=document.form2.concepto.value;
	var conta=document.form2.contador.value;
	if(concepto!='' && conta>0){
		despliegamodalm('visible','4','Esta Seguro de Guardar','1');
	  
	}else{
		despliegamodalm('visible','2','Faltan datos para completar el registro');
	}

}
function respuestaconsulta(pregunta)
{
	switch(pregunta)
	{
		case "1":	
			document.form2.oculto.value=2;
			document.form2.action="presu-regalias.php";
			document.form2.submit();
			break;
	}
}

function excell()
{
    //code
	document.form2.action="presu-regaliasexcel.php";
	document.form2.target="_BLANK";
	document.form2.submit(); 
	document.form2.action="";
	document.form2.target="";

}

function buscar(){
	document.form2.oculto.value=3;
	document.form2.submit();
}

function verificasaldo(posicion){
	var arreglo=document.getElementsByName("totalval[]");
	var valortot=arreglo.item(posicion).value;
	var valorin=document.getElementById("valores"+posicion).value;
	var nueva=parseInt(limpiarNumero(valorin));
	var saldo=valortot-nueva;
	if(saldo<0){
		alert("El saldo es negativo");
		document.getElementById("valores"+posicion).value=valortot;
		
	}
	document.form2.submit();
}

function limpiarNumero(numero){
	var acum="";
	for(var i=0;i<numero.length;i++){
		if(!(numero.charAt(i)=='$' || numero.charAt(i)=='.')){
			acum+=numero.charAt(i);
		}
	}
	return acum;
}
function cambiar(objeto){
	var check=objeto.checked;
	if(check){
		document.form2.contador.value=parseInt(document.form2.contador.value)+1;
	}else{
		document.form2.contador.value=parseInt(document.form2.contador.value)-1;
	}
	
	document.form2.submit();
}

function despliegamodalm(_valor,_tip,mensa,pregunta)
{
	document.getElementById("bgventanamodalm").style.visibility=_valor;
	if(_valor=="hidden"){document.getElementById('ventanam').src="";}
	else
	{
		switch(_tip)
		{
			case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
			case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
			case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;	
			case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;
		}
	}
}
function atrasc(){
	var consec=parseInt(document.getElementById("ncomp").value);
	var min=1;
	if(consec>1){
		document.getElementById("ncomp").value=parseInt(document.getElementById("ncomp").value)-1;
		document.form2.oculto.value="";
		document.form2.submit();
	}
}
function adelante(){
	var consec=parseInt(document.getElementById("ncomp").value);
	var max=parseInt(document.getElementById("maximo").value);
	if(consec<max){
		document.getElementById("ncomp").value=parseInt(document.getElementById("ncomp").value)+1;
		document.form2.oculto.value="";
		document.form2.submit();
	}
}

</script>
		<?php titlepag();clearstatcache();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
  			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
      		<tr><?php menu_desplegable("presu");?></tr>
            <tr>
     			<td colspan="3" class="cinta">
					<a href="presu-regalias.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#"  class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="presu-buscaregalias.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png"  alt="excel" title="Excel"></a><a href="#" onClick="location.href='presu-buscaregalias.php'"><img  src="imagenes/iratras.png" title="Atr&aacute;s"  /></a></td> 
     		</tr>
		</table>
   <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		
  <form name="form2" method="post" action="presu-regaliasver.php">
	<?php
	function limpiarnum($numero){
		$acum="";
		if(strpos($numero,"$")===false){
			return $numero;
		}else{
			for($i=0;$i<strlen($numero);$i++ ){
			if(!($numero[$i]=='$' || $numero[$i]=='.')){
				$acum.=$numero[$i];
			}
		}
			$pos=strpos($acum,",");
			return substr($acum,0,$pos);
		}
		
	}
	if($_POST[oculto]==""){
		$_POST[contador]=0;
		
		if(isset($_GET[codigo])){
			$_POST[ncomp]=$_GET[codigo];
		}
		$sql="SELECT MAX(codigo) FROM pptoregalias_cab";  // -- OBTENER EL VALOR MAXIMO
		$result=mysql_query($sql,$linkbd);
		$row = mysql_fetch_row($result);
		$_POST[maximo]=$row[0];
		$sql="SELECT * FROM pptoregalias_cab WHERE codigo=$_POST[ncomp]";
		$res=mysql_query($sql,$linkbd);
		$row = mysql_fetch_row($res);
		$_POST[concepto]=$row[3];
		$_POST[fecha]=$row[1];
		switch($row[2]){
			case 'S':
				$_POST[estado]="ACTIVO";
				break;
			case 'R':
				$_POST[estado]="REVERSADO";
				break;
		}
		$_POST[vigencia]=$row[4];
		$_POST[fechai]=$row[8];
		$_POST[fechaf]=$row[9];
		$_POST[total]=$row[5];
		unset($_POST[recibos],$_POST[conceptos],$_POST[fechas],$_POST[liquidaciones],$_POST[cuentas],$_POST[valores]);
		//-- Detalle
		$sql="SELECT * FROM pptoregalias_det WHERE codigo=$_POST[ncomp]";
		$res=mysql_query($sql,$linkbd);
		while($row = mysql_fetch_row($res)){
			$_POST[recibos][]=$row [1];
			$_POST[conceptos][]=$row [2];
			$_POST[fechas][]=$row [7];
			$_POST[liquidaciones][]=$row [3];
			$_POST[cuentas][]=$row [4];
			$_POST[valores][]=$row [5];
			$_POST[ingresos][]=$row [8];
		}
	}

	?>
  	<table class="inicio" width="99%">
        <tr>
          	<td class="titulos" colspan="9">.: Comprobantes de ingreso para regalias</td>
          	<td width="287" class="cerrar" >
          		<a href="cont-principal.php">Cerrar</a>
          	</td>
        </tr>
        <tr>
		  
		  	<td style="width:10%;" class="saludo1" >No:          </td>
		  	<td style="width:10%;" >
			<a href="#" onClick="atrasc()">
				<img src="imagenes/back.png" alt="anterior" align="absmiddle">
			</a>
         		<input type="text" name="ncomp" id="ncomp" style="width:70%;" onKeyPress="javascript:return solonumeros(event)" value="<?php echo $_POST[ncomp]?>" onKeyUp="return tabular(event,this) " onBlur="validar2()" readonly >  
			<a href="#" onClick="adelante()">
				<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
				<input type="hidden" name="maximo" id="maximo" value="<?php echo $_POST[maximo]; ?>" >
			</a>				
         	</td>
          	<td style="width:10%;" class="saludo1" >Fecha: </td>
          	<td style="width:10%;">
          		<input name="fecha" type="text" id="fecha" title="DD/MM/YYYY" style="width:80%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>         
          		<a href="#" >
          			<img src="imagenes/calendario04.png" align="absmiddle" style="width:20px; cursor:pointer" border="0">
          		</a>          
          	</td>
          	<td style="width:10%;" class="saludo1">Estado:          </td>
          	<td style="width:10%;">
          		<input type="hidden" id="contador" name="contador"  value="<?php echo $_POST[contador]; ?>" >
          		<input type="hidden" id="oculto" name="oculto"  value="<?php echo $_POST[oculto]; ?>">
          		<?php 
				$valuees=$_POST[estado];
				if(strcmp($_POST[estado],"REVERSADO")==0){
					$stylest="width:100%; background-color:red ;color:#fff; text-align:center;";	
				}else{
					$stylest="width:100%; background-color:#0CD02A ;color:#fff; text-align:center;";	
				}
				
				echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
						
                  ?>
          		
          	</td>
			<td class="saludo1" style="width: 7%">Fecha inicial: </td>
			<td style="width: 20%"><input name="fechai" type="text" id="fechai" title="DD/MM/YYYY" style="width:50%;" value="<?php echo $_POST[fechai]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         
          		<a href="#" onClick="displayCalendarFor('fechai');">
          			<img src="imagenes/calendario04.png" align="absmiddle" style="width:20px; cursor:pointer" border="0">
          		</a> 
			</td>
			
          	<td rowspan="2" style="width: 15%; background-image:url('imagenes/sgr.png'); background-repeat:no-repeat; background-size: 80% 100%; background-position: left"></td>
        </tr>
    	<tr>
          	<td class="saludo1">Concepto:          </td>
          	<td colspan="3" >
				<input type="text" name="concepto" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[concepto]; ?>">          
			</td>
          	<td style="width:5%;" class="saludo1">Vigencia:          </td>
          	<td style="width:10%;" >
          		<input type="text" name="vigencia" id="vigencia" onKeyUp="return tabular(event,this)" style="width:100%;" value="<?php echo $_POST[vigencia]; ?>" readonly >          
          	</td>
			<td class="saludo1">Fecha Final: </td>
			<td><input name="fechaf" type="text" id="fechaf" title="DD/MM/YYYY" style="width:80%;" value="<?php echo $_POST[fechaf]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>         
          		<a href="#" >
          			<img src="imagenes/calendario04.png" align="absmiddle" style="width:20px; cursor:pointer" border="0">
          		</a>
			</td>
			
        </tr>
    </table>

	<div class="subpantallac5" style="height:60.5%; width:99.6%; overflow-x:hidden;">
	    <table class="inicio" width="99%">
        	<tr>
         	 	<td class="titulos" colspan="8">Detalle Comprobantes          </td>
        	</tr>
			<tr>
				<td class="titulos2" style="width: 5%"><input type="checkbox" name="todos" id="todos" /></td>
				<td class="titulos2" style="width: 10%">Recibo</td>
				<td class="titulos2" style="width: 40%">Concepto</td>
				<td class="titulos2" style="width: 10%">Fecha</td>
				<td class="titulos2" style="width: 10%">Liquidacion</td>
				<td class="titulos2" style="width: 5%">Ingreso</td>
				<td class="titulos2" style="width: 10%">Rubro</td>
				<td class="titulos2" style="width: 20%">Valor</td>
			</tr>
			<?php
				

					$estilo="saludo1";
					$estilo1="saludo2";
					for($i=0; $i<count($_POST[recibos]);$i++ ){
						echo "
						<script>
							jQuery(function($){ $('#valores$i').autoNumeric('init');});
						</script>";
			
						echo "<td><input type='checkbox' name='chkrecibo[$i]' id='chkrecibo[$i]' CHECKED/> </td>";
						echo "<td><input type='hidden' name='recibos[]' value='".$_POST[recibos][$i]."' />".$_POST[recibos][$i]."</td>";
						echo "<td><input type='hidden' name='conceptos[]' value='".$_POST[conceptos][$i]."' />".$_POST[conceptos][$i]."</td>";
						echo "<td><input type='hidden' name='fechas[]' value='".$_POST[fechas][$i]."' />".$_POST[fechas][$i]."</td>";
						echo "<td><input type='hidden' name='liquidaciones[]' value='".$_POST[liquidaciones][$i]."' />".$_POST[liquidaciones][$i]."</td>";
						echo "<td><input type='hidden' name='ingresos[]' value='".$_POST[ingresos][$i]."' />".$_POST[ingresos][$i]."</td>";
						echo "<td><input type='hidden' name='cuentas[]' value='".$_POST[cuentas][$i]."' />".$_POST[cuentas][$i]."</td>";
						echo "<td> <input type='hidden' name='dvalores[]' id='dvalores$i' value='".$_POST[dvalores][$i]."'/> <input type='text' name='valores[]' id='valores$i' value='".$_POST[valores][$i]."' data-a-sign='$' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dvalores$i','valores$i');\" readonly/></td>";
						echo "</tr>";
						$aux=$estilo;
						$estilo=$estilo1;
						$estilo1=$aux;
						
					}
	
			
				
				
			?>
		</table>  
		</div> 
		<div class="subpantallac5" style="height:5%; width:99.6%; overflow:hidden;">
			<table class="inicio" width="99%;" height="100%">
        	<tr>
         	 	<td class="titulos2" style="text-align:right; padding-right: 8%; font-size: 15px">$ <?php echo number_format($_POST[total],2,",","."); ?>   (<?php echo convertir($_POST[total]); ?> PESOS MCTE)</td>
        	</tr>
		    </table>
		</div>
		<?php
		//--Guardando el comprobante
		if($_POST[oculto]==2){
			$total=0;
			for($i=0; $i<count($_POST[valores]); $i++ ){
				$total+=limpiarnum($_POST[valores][$i]);
			}
			$user=$_SESSION['nickusu'];
			$sql="INSERT INTO pptoregalias_cab (codigo,fecha,estado,concepto,vigencia,total,tipo_mov,usuario) VALUES ('$_POST[ncomp]','$_POST[fecha]','S','$_POST[concepto]','$_POST[vigencia]','".$total."','201','$user')";
			if(mysql_query($sql,$linkbd)){
				echo"<script>despliegamodalm('visible','1','Se Almaceno el Comprobante');</script>";
				echo "<table class='inicio'><tr><td class='saludo1'><center>Se Almaceno de Manera Exitosa el Comprobante <img src='imagenes/confirm.png'></center></td></tr></table>"; 
					for($i=0; $i<count($_POST[cuentas]); $i++ ){
						if(!empty($_POST[chkrecibo][$i])){
							$saldo=$_POST[totalval][$i] - limpiarnum($_POST[valores][$i]);
							$sql="INSERT INTO pptoregalias_det (codigo,recibo,concepto,liquidacion,rubro,valor,saldo) VALUES ('$_POST[ncomp]','".$_POST[recibos][$i]."','".$_POST[conceptos][$i]."','".$_POST[liquidaciones][$i]."','".$_POST[cuentas][$i]."','".limpiarnum($_POST[valores][$i])."','$saldo')";
							mysql_query($sql,$linkbd);
							if($saldo==0){
								$sql="UPDATE pptorecibocajappto SET tipo='P' WHERE cuenta='".$_POST[cuentas][$i]."' AND idrecibo='".$_POST[recibos][$i]."' ";
								mysql_query($sql,$linkbd);
							}
						}
					}
			}else{
				echo "<table class='inicio'><tr><td class='saludo1'><center>Error al Almacenar <img src='imagenes/alert.png'></center></td></tr></table>";
			}
					
			
		}
		?>
	  </form>
 
</body>
</html>