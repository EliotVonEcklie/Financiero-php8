<?php //V 1000 12/12/16 ?> 
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
		<title>:: Spid - Almacen</title> 
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			jQuery(function($){ $('#vlrestimadovl').autoNumeric('init');});
			jQuery(function($){ $('#vlrestimadoactvl').autoNumeric('init');});
			function agregardetalle()
			{
				if(document.form2.cuenta.value!="" )
				{
					document.form2.agregadet.value=1;
					document.getElementById('banderin2').value=parseInt(document.getElementById('banderin2').value)+1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Falta informacion del Producto para poder Agregar');}
			}
			function eliminard(variable)
			{
				document.form2.eliminar.value=variable;
				despliegamodalm('visible','4','Esta seguro de eliminar el Producto de la lista','2');
			}
			function buscacta(e)
			{
				if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
			function guardar()
			{

				var validacion01=document.getElementById('descripcion').value;
				var validacion02=document.getElementById('duracion1').value;
				var validacion03=document.getElementById('vlrestimado').value;
				var validacion04=document.getElementById('vlrestimadoact').value;
				if((document.form2.fecha.value!="")&&(document.form2.fecha2.value!="")&&(validacion02.trim()!='')&&(document.form2.modalidad.value!="")&&(validacion01.trim()!='')&&(document.form2.fuente.value!="")&&(validacion03.trim()!='')&&(validacion02.trim()!='')&&(document.form2.requierev.value!="")&&(document.form2.estadorequierev.value!="")&&(document.getElementById('banderin2').value!=0))
				{despliegamodalm('visible','4','Esta Seguro de Modificar la Adquisición','1');}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function validar()
			{
				if (document.getElementById('banderin1').value=="1"){document.getElementById('banderin1').value="0";document.form2.submit();}
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
			function funcionmensaje(){document.location.href = "contra-plancompras.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculgen.value="2";document.form2.submit();break;
					case "2":	document.getElementById('banderin2').value=parseInt(document.getElementById('banderin2').value)-1;
								document.form2.oculto.value='3';document.form2.submit();break;
					case "3":	document.getElementById('banderin2').value=parseInt(document.getElementById('banderin2').value)-1;
								document.form2.oculto.value='3';document.form2.submit();break;
				}
			}
			function iratras(scrtop,numpag){
				alert (numpag);
				var idcta=document.getElementById('codigo').value;
				location.href="contra-plancomprasbuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
  				<td colspan="3" class="cinta">
					<a href="contra-plancompras.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
					<a href="contra-plancomprasbuscar.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" class="mgbt" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="contra-plancomprasbuscar.php"  class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
    	<form name="form2" method="post">
    		<input id="oculgen" name="oculgen" type="hidden" value="<?php echo $_POST[oculgen] ?> ">
    		<?php 
				if($_POST[oculgen]=="")
				{
					$_POST[codadq]=str_replace("#","",$_GET[codid]);
					$_POST[vigencia01]=str_replace("#","",$_GET[vigen]);
					$sqlr="SELECT * FROM contraplancompras WHERE codplan='$_POST[codadq]' AND vigencia='$_POST[vigencia01]'";
					$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$_POST[fecha]=$row[2];
					$_POST[fecha2]=$row[6];
					$duraciones=explode('/', $row[7]);
					if ($duraciones[0]==""){$_POST[duracion1]=0;}
					else{$_POST[duracion1]=$duraciones[0];}
					if ($duraciones[1]==""){$_POST[duracion2]=0;}
					else{$_POST[duracion2]=$duraciones[1];}
					$_POST[modalidad]=$row[8];
					$_POST[descripcion]=$row[5];
					$_POST[fuente]=$row[9];
					$_POST[vlrestimado]=$row[10];
					$_POST[vlrestimadovl]=$row[10];
					$_POST[vlrestimadoact]=$row[11];
					$_POST[vlrestimadoactvl]=$row[11];
					$_POST[requierev]=$row[12];
					$_POST[estadorequierev]=$row[13];
					$contacto1=explode('-',$row[15]);
					$_POST[contacto]=$contacto1[0];
					$_POST[cargo]=$contacto1[1];
					$codunspsc=explode("-",$row[4]);
					foreach ($codunspsc as &$valor)
					{
						$sqlr2="SELECT nombre FROM productospaa WHERE codigo='".$valor."'";
						$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
						$_POST[dproductos][]=$valor;
						$_POST[dnproductos][]=$row2[0]; 
						$nt=buscaproductotipo($valor);
						$_POST[dtipos][]=buscadominiov2("UNSPSC",$nt);
					}
					unset($valor);
					$_POST[banderin2]=count($_POST[dnproductos]);
					$_POST[banderin1]="0";
					echo "<script>document.getElementById('oculgen').value='1';</script>";
				}
				if($_POST[bc]=='1')
				{
					$nresul=buscaproducto($_POST[cuenta]);
					if($nresul!='')
					{
						$_POST[ncuenta]=$nresul;
						echo "<script>document.getElementById('agrega').focus();document.getElementById('agrega').select();</script>";
					}
					else
					{
						$_POST[ncuenta]="";
						echo"<script>despliegamodalm('visible','2','Codigo Incorrecto');</script>";
					 }
				}
				if ($_POST[oculto]=='3')
				{ 
					$posi=$_POST[eliminar];
					unset($_POST[dproductos][$posi]);
					unset($_POST[dnproductos][$posi]);
					unset($_POST[dtipos][$posi]);
					$_POST[dproductos]= array_values($_POST[dproductos]); 
					$_POST[dnproductos]= array_values($_POST[dnproductos]); 
					$_POST[dtipos]= array_values($_POST[dtipos]);
					echo"<script>document.form2.oculto.value='1';</script>";
				}
				if ($_POST[agregadet]=='1')
				{
					$_POST[dproductos][]=$_POST[cuenta];
					$_POST[dnproductos][]=$_POST[ncuenta]; 
					$nt=buscaproductotipo($_POST[cuenta]);
					$_POST[dtipos][]=buscadominiov2("UNSPSC",$nt);
					$_POST[agregadet]=0;
				}
				if($_POST[oculto]=='11')
				{
					$_POST[dproductos]=array();
					$_POST[dproductos]=array();
					$_POST[adqproductos][]=array();
					$_POST[adqindice]=array();
					$_POST[adqdescripcion]=array();
					$_POST[adqfecha2]=array();
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
      		<input type="hidden" name="banderi1" id="banderin1" value="<?php echo $_POST[banderin1];?>">
            <input type="hidden" name="banderin2" id="banderin2" value="<?php echo $_POST[banderin2];?>">
            <input type="hidden" name="codadq" id="codadq" value="<?php echo $_POST[codadq];?>">
            <input type="hidden" name="vigencia01" id="vigencia01" value="<?php echo $_POST[vigencia01];?>">
 			<table class="inicio" >
                <tr>
                    <td colspan="8" class="titulos" style="width:90%">Adquisiciones Plan de Compras</td>
                    <td class="cerrar" style="width:8%"><a href="contra-principal.php"> Cerrar</a></td>
                </tr>
                <tr>
                    <td  class="saludo1" style="width:8%" >Fecha Registro:</td>
                    <td style="width:10%">
						<input type="text" style="width:80%" name="fecha" id="fecha" title="DD/MM/YYYY" value="<?php echo $_POST[fecha];?>" readonly>
						<a onClick="displayCalendarFor('fecha') ;  " maxlength="5" style="width:40%;"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"/></a>
					</td>
					
                    <td class="saludo1" style="width:10%">Fecha Estimada Inicio Selecci&oacute;n:</td>
                    <td style="width:15%">
					<input type="text" style="width:60%" name="fecha2" id="fecha2" title="DD/MM/YYYY" value="<?php echo $_POST[fecha2];?>" readonly>
						<a onClick="displayCalendarFor('fecha2') ;  " maxlength="5" style="width:40%;"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"/></a>
					</td>
                     <td class="saludo1" style="width:10%">Duraci&oacute;n Contrato (D&iacute;as / Meses):</td>
                   <td style="width:3%">
                    	<input type="text" name="duracion1" id="duracion1"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[duracion1]; ?>" style="width:40%">
                        <input type="text" name="duracion2" id="duracion2"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[duracion2]; ?>" style="width:40%">
                    </td>
                     <td class="saludo1" style="width:10%">Modalidad Selecci&oacute;n:</td>
                     <td colspan="2" style="width:21%">
                        <select name="modalidad" style="width:100%" onChange="validar()">
                            <option value=''>Seleccione ...</option>
                            <?php
                                $linkbd=conectar_bd();
                                $sqlr="SELECT * FROM dominios  WHERE nombre_dominio='MODALIDAD_SELECCION' AND (valor_final IS NULL or valor_final ='') ORDER BY valor_inicial ASC";
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
                </tr>
                <tr>
                    <td class="saludo1" >Descripci&oacute;n:</td>
                    <td colspan="5" ><input type="text" name="descripcion" id="descripcion"  value="<?php echo $_POST[descripcion]; ?>" style="width:100%" onBlur="validar()"></td>
                    <td class="saludo1">Fuente Recurso:</td>
                    <td colspan="2">
                        <select name="fuente" style="width:100%" onChange="validar()">
                            <option value=''>Seleccione ...</option>
                            <?php
                                $linkbd=conectar_bd();
                                $sqlr="SELECT * FROM pptofutfuenteinv ORDER BY codigo ASC";
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
                </tr>
                <tr>
                    <td class="saludo1">Valor Estimado</td>
                    <td>
                    	<input type="hidden" name="vlrestimado" id="vlrestimado" value="<?php echo $_POST[vlrestimado]; ?>" />
                    	<input type="text" name="vlrestimadovl" id="vlrestimadovl" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('vlrestimado','vlrestimadovl');return tabular(event,this);" value="<?php echo $_POST[vlrestimadovl]; ?>" style='text-align:right;' />
                    </td>
                    <td class="saludo1">Vlr Estimado Vig. Actual</td>
                    <td>
                    	<input type="hidden" name="vlrestimadoact" id="vlrestimadoact" value="<?php echo $_POST[vlrestimadoact]; ?>">
                    	<input type="text" name="vlrestimadoactvl" id="vlrestimadoactvl" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('vlrestimadoact','vlrestimadoactvl');return tabular(event,this);" value="<?php echo $_POST[vlrestimadoactvl]; ?>" style='text-align:right;' />
                    </td>
                    <td class="saludo1">Requiere Vigencias Futuras:</td>
                    <td>
                        <select name="requierev" onChange="validar()">
                            <option value=''>Seleccione ...</option>
                            <?php
                                $linkbd=conectar_bd();
                                $sqlr="SELECT * FROM dominios WHERE nombre_dominio='VIGENCIASF' ORDER BY valor_inicial ASC";
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
                    <td class="saludo1">Estado de Solicitud Vigencias Futuras:</td>
                    <td colspan="2">
                        <select name="estadorequierev" style="width:100%" onBlur="validar()">
                            <option value='' >Seleccione ...</option>
                            <?php
                                $linkbd=conectar_bd();
                                $sqlr="SELECT * FROM dominios  WHERE nombre_dominio='ESTADO_VIGENCIASF' ORDER BY valor_inicial ASC";
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
					<td class="saludo1"> Contacto responsable: </td>
					 <td colspan="3">
                    	
                    	<input type="text" name="contacto" id="contacto" value="<?php echo $_POST[contacto]; ?>" style="width:100%" onBlur="validar()" />
                    </td>
					<td class="saludo1"> Cargo: </td>
					 <td colspan="3">
                    	
                    	<input type="text" name="cargo" id="cargo" value="<?php echo $_POST[cargo]; ?>" style="width:75%" />
                    </td>
				</tr>
                <tr>
                    <td colspan="9" class="titulos2">Productos Adquisici&oacute;n</td>
                </tr>
                <tr>
                    <td class="saludo1">C&oacute;digo Producto:</td>
                    <td valign="middle" >
                        <input type="text" name="cuenta" id="cuenta" onKeyPress="javascript:return solonumeros(event)" 
                  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" style="width:85%" >
                        <input type="hidden" value="0" name="bc">
                        <a href="#" onClick="despliegamodal2('visible');"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;" border="0"></a></td>
                    <td colspan='5'>
                        <input type="text" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>" style="width:100%"  readonly>
                    </td>
                    <td style="width:20%" colspan='2'>
                        <input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" >
                        <input type="hidden" value="0" name="agregadet"> 
                    </td>
                </tr>
            </table>
            <input type="hidden" name="oculto" id="oculto" value="1">
    		<div class="subpantalla" style="height:49.5%; width:99.5%; overflow-x:hidden">
                <table class="inicio" style="width:100%">
                    <tr>
                        <td class="titulos2" style="width:10%">Codigo</td>
                        <td class="titulos2" style="width:60%">Nombre</td>
                        <td class="titulos2"style="width:25%">Tipo</td>
                        <td class="titulos2" style="width:5%" align=\"middle\">Eliminar<input type='hidden' name='eliminar' id='eliminar'></td>
                    </tr>
                    <?php
                        $iter='saludo1';
                        $iter2='saludo2';
                        for ($x=0;$x<count($_POST[dproductos]);$x++)
                        {		 
                            echo "
                                <tr class='$iter'>
                                    <td><input class='inpnovisibles' name='dproductos[]' value='".$_POST[dproductos][$x]."' type='text' readonly></td>
                                    <td><input class='inpnovisibles' name='dnproductos[]'  value='".$_POST[dnproductos][$x]."' type='text' style=\"width:100%\" readonly></td>
                                    <td><input class='inpnovisibles' name='dtipos[]' value='".$_POST[dtipos][$x]."' type='text'  readonly></td>";		
                            echo "<td align=\"middle\"><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";	
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
                        }	
                        if($_POST[oculgen]=="2")
                        {
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha1);
							$fechaf1=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
                            $linkbd=conectar_bd();
                            $codigosunsps =implode("-", $_POST[dproductos]);
							$duraciontotal=$_POST[duracion1]."/".$_POST[duracion2];
                            $sqlr="UPDATE contraplancompras SET fecharegistro='$fechaf',codigosunspsc='$codigosunsps', descripcion='$_POST[descripcion]',fechaestinicio='$fechaf1', duracionest='$duraciontotal',modalidad='$_POST[modalidad]', fuente='$_POST[fuente]',valortotalest='$_POST[vlrestimado]',valorestvigactual='$_POST[vlrestimadoact]',requierevigfut='$_POST[requierev]' ,estadovigfut='$_POST[estadorequierev]',contacto_respon='".$_POST[contacto]."-".$_POST[cargo]."' WHERE codplan='$_POST[codadq]' AND vigencia='$_POST[vigencia01]'";
                            mysql_query($sqlr,$linkbd);	
							echo"
							<script>
								document.getElementById('oculgen').value='1';document.getElementById('banderin1').value='1';
								despliegamodalm('visible','3','Se ha Actualizado el Plan Anual de Adquisiciones con Exito');
							</script>";
                        }
               ?>
                </table>
 			</div>	
   		</form>
        <div id="bgventanamodal2">
            <div id="ventanamodal2">
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>
	</body>
</html>