	<?php //V 1000 12/12/16 ?> 
<?php 
	error_reporting(0);
	require"comun.inc";
	require"funciones.inc";
	require"conversor.php";
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
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script> 
			function ponprefijo(pref,opc,valor,valor2,cargo)
			{   
				parent.despliegamodalm2('hidden');
			} 
			function pdf(){
				document.form2.action='pdfcertificadopaa.php'; 
				document.form2.target='_BLANK'; 
				document.form2.submit();
				document.form2.action=''; 
				document.form2.target=''; 
			}
		</script> 
		<?php titlepag();?>
	</head>
	<body>
  		<form action="" method="post" enctype="multipart/form-data" name="form2">
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
			<?php
			$_POST[codigot]=$_GET[solicitud];
			$sqlr="SELECT * FROM contrasoladquisiciones WHERE codsolicitud='$_GET[solicitud]'";
			$res=mysql_query($sqlr,$linkbd);
			$row =mysql_fetch_row($res);
			$codsolicita=explode("-",$row[3]);
			$codadqui=$row[12];
			$_POST[codigo]=$row[12];
			$_POST[nombre]=$row[2];
			foreach ($codsolicita as &$valor)
			{	
				$nresul=buscatercerod($valor);		 
				$_POST[sdocumento][]=$valor;
				$_POST[snombre][]=$nresul[0]; 
				$_POST[sidependencia][]=$nresul[2];
				$_POST[sndependencia][]=$nresul[1];
			}
			$_POST[solproyecod]=$_GET[solicitud];
			$sql1="SELECT contrasolicitudpaa.descripcion,contrasolicitudpaa.observaciones,contrasolicitudpaa.codigosaprob,contrasolicitudpaa.codplan,contrasolicitudpaa.vigencia FROM contrasolicitudpaa where contrasolicitudpaa.codsolicitud='$_GET[solicitud]' ";
			$res1=mysql_query($sql1,$linkbd);
			$row1=mysql_fetch_row($res1);
			$_POST[vigencia]=$row1[5];		
			$codunspsc=explode("-",$row1[2]);
			foreach ($codunspsc as &$valor)
			{
				$sqlr2="SELECT nombre FROM productospaa WHERE codigo='$valor'";
				$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
				$_POST[dproductos][]=$valor;
				$_POST[dnproductos][]=$row2[0]; 
				$nt=buscaproductotipo($valor);
				$_POST[dtipos][]=buscadominiov2("UNSPSC",$nt);
			}
					
			$canpro=explode("-",$row[10]);
			foreach ($canpro as &$valor)
			{
				$_POST[dcantidad][]=$valor;
				$_POST[dcantidadv][]=$valor;
			}
			unset($valor);
			$cvaluni=explode("-",$row[11]);
			foreach ($cvaluni as &$valor)
			{
				$_POST[dvaluni][]=$valor;
				$_POST[dvaluniv][]=$valor;
			}
			unset($valor);
					
			?>
			<table  class="inicio" style="width:99.4%;">
                <tr>
                    <td class="titulos" colspan="5">:: Productos Certificados</td>
                    <td class="cerrar" style="width:10%;"><a onClick="parent.despliegamodalm2('hidden');" href="#" >&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td style="width: 80%">
                    	<div class="informa" style="font-family: 'Oswald', sans-serif !important;font-size: 17px;padding-left: 10%">Informacion acerca de los productos certificados a partir del Plan Anual de Adquisicion </div>
                    </td>
					
					<td>
                    	<input type="button" name="agregar6" id="agregar6" value=" VER CERTIFICADO "  onClick="pdf()" />
                    </td>
                </tr>                       
    		</table> 
    		<input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="tobjeto" id="tobjeto" value="<?php echo $_POST[tobjeto]?>"/>
            <input type="hidden" name="tnobjeto" id="tnobjeto" value="<?php echo $_POST[tnobjeto]?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<input type="hidden" name="solproyecod" id="solproyecod" value="<?php echo $_POST[solproyecod];?>"/>
			<input type="hidden" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia];?>"/>
            <div class="subpantallac" style="height:86%; width:99.1%; overflow-x:hidden;">
			
			<table class="inicio" style="width:100%">
			<tr>
				<td class="titulos2" style="width:10%">Documento</td>
				<td class="titulos2" style="width:45%">Nombre</td>
				<td class="titulos2" style="width:45%">Dependencia</td>
			</tr>
			
			<?php
				$iter='saludo1a';
				$iter2='saludo2';
				for ($x=0;$x<count($_POST[sdocumento]);$x++)
				{	
					echo "
			<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
				<td><input class='inpnovisibles' name='sdocumento[]' value='".$_POST[sdocumento][$x]."' type='text' readonly style='width:100%'></td>
				<td><input class='inpnovisibles' name='snombre[]'  value='".$_POST[snombre][$x]."' type='text' style=\"width:100%\" readonly style='width:100%'></td>
				<td><input class='inpnovisibles' name='sndependencia[]' value='".$_POST[sndependencia][$x]."' type='text' readonly style='width:100%'><input name='sidependencia[]' value='".$_POST[sidependencia][$x]."' type='hidden'></td>
			</tr>";	
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
				}	
			?>
		</table>
	
                        <table class="inicio" style="width:100%">
                            <tr>
                                <td class="titulos2" style="width:10%">Codigo</td>
                                <td class="titulos2" >Nombre</td>
                                <td class="titulos2" style="width:10%">Cantidad</td>
                                <td class="titulos2" style="width:15%">Valor Unitario</td>
                                <td class="titulos2" style="width:20%">Tipo</td>
                                
                            </tr>
                            <?php
                                $iter='saludo1a';
                                $iter2='saludo2';
                                for ($x=0;$x<count($_POST[dproductos]);$x++)
                                {		 
                                    echo "
										<script>
											jQuery(function($){ $('#dvaluniv$x').autoNumeric('init');});
											jQuery(function($){ $('#dcantidadv$x').autoNumeric('init',{mDec:'0'});});
										</script>
                                        <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
                                            <td><input class='inpnovisibles' name='dproductos[]' value='".$_POST[dproductos][$x]."' type='text' readonly style='width:100%'></td>
                                            <td><input class='inpnovisibles' name='dnproductos[]'  value='".$_POST[dnproductos][$x]."' type='text' style='width:100%' readonly></td>
											<td>
												<input type='hidden' name='dcantidad[]' id='dcantidad$x' value='".$_POST[dcantidad][$x]."'/>
												<input type='text' name='dcantidadv[]' id='dcantidadv$x' value='".$_POST[dcantidadv][$x]."' style='width:100%;text-align:right;' readonly data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dcantidad$x','dcantidadv$x');\"  />
											</td>
											<td>
												<input type='hidden' name='dvaluni[]' id='dvaluni$x' value='".$_POST[dvaluni][$x]."'/>
												<input type='text' name='dvaluniv[]' id='dvaluniv$x' value='".$_POST[dvaluniv][$x]."' style='width:100%;text-align:right;' readonly data-a-sign='$' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dvaluni$x','dvaluniv$x');\" />												
											</td>
                                            <td><input class='inpnovisibles' name='dtipos[]' value='".$_POST[dtipos][$x]."' type='text'  readonly style='width:100%'></td>";		
                                    echo "</tr>";	
                                    $aux=$iter;
                                    $iter=$iter2;
                                    $iter2=$aux;
                                }	
                            ?>
                        </table>
                  
					
            </div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
			 <input type="hidden" name="codigot" id="codigot" value="<?php echo $_POST[codigot];?>" />
		</form>
	</body>
</html>
