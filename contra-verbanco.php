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
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script> 
			function pdf(){
				document.form2.action="pdfcertificabanco.php";
				document.form2.target="_blank";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
		</script> 
		<?php titlepag();?>
	</head>
	<body>
  		<form action="" method="post" enctype="multipart/form-data" name="form2">
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
			<?php
			function obtenerCodigoMeta($proyecto,$meta){
				$linkbd=conectar_bd();
				$sql="SELECT planproyectos_det.cod_meta FROM planproyectos_det WHERE planproyectos_det.codigo='$proyecto' AND planproyectos_det.valor='$meta' ";
				$res=mysql_query($sql,$linkbd);
				$fila=mysql_fetch_row($res);
				return $fila[0];
			}
			?>
			<?php
			$_POST[codigot]=$_GET[solicitud];
			$sqlr="SELECT codproyecto FROM contrasoladquisicionesgastos WHERE codsolicitud='$_GET[solicitud]'";
			$res=mysql_query($sqlr,$linkbd);
			$rowc=mysql_fetch_row($res);
			$codigo=$rowc[0];
			$_POST[codigoproy]=$codigo;
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[vigencia]=$vigusu;			
			$sqlr="SELECT codproyecto FROM contrasolicitudproyecto WHERE codsolicitud='$_GET[solicitud]'";
			$res=mysql_query($sqlr,$linkbd);
			$rowc=mysql_fetch_row($res);
			$codigo=$rowc[0];
			$_POST[codigoproy]=$codigo;
			$_POST[codigo]=$codigo;
			$_POST[conproyec]=$codigo;
			$nresul=buscaproyectos($codigo);
			$_POST[nproyecto]=$nresul[0];$_POST[conproyec]=$nresul[1];$_POST[nomarchadj]=basename($nresul[2]);$_POST[valorproyecto]=$nresul[3];$_POST[descripcion]=$nresul[4]; 
			$_POST[nombre]=$nresul[0];
			
			$sql="SELECT MAX(cod_meta) FROM planproyectos_det WHERE codigo='$_POST[codigoproy]' ";
			$res=mysql_query($sql,$linkbd);
			$row=mysql_fetch_row($res);
			$_POST[contador]=$row[0];
			
			
			$sql="SELECT contrasolicitudproyecto.metascert FROM contrasolicitudproyecto WHERE contrasolicitudproyecto.codsolicitud='$_GET[solicitud]'  ";
			$res=mysql_query($sql,$linkbd);
			$fila = mysql_fetch_row($res);
			$arreglo=explode("-",$fila[0]);
			$cantidad=count($arreglo);
			
			
			for($i=0;$i<$cantidad;$i++){
			$nummeta=obtenerCodigoMeta($_POST[codigoproy],$arreglo[$i]);
			$sql="SELECT valor,nombre_valor,cod_meta FROM planproyectos_det WHERE codigo='$_POST[codigoproy]' AND cod_meta='$nummeta'  ORDER BY LENGTH(valor),cod_meta ASC ";
			$res=mysql_query($sql,$linkbd);
			$cont=0;
			while($row = mysql_fetch_row($res)){
				$j=$row[2];
				$_POST["matmetas$j"][]=$row[0];
				$_POST["matmetasnom$j"][]=$row[1];
				$cont++;
			}
		}
			?>
			<table  class="inicio" style="width:99.4%;">
                <tr>
                    <td class="titulos" colspan="5">:: Proyecto</td>
                    <td class="cerrar" style="width:10%;"><a onClick="parent.despliegamodalm2('hidden');" href="#" >&nbsp;Cerrar</a></td>
                </tr>
                       
    		</table> 
    		<input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="tobjeto" id="tobjeto" value="<?php echo $_POST[tobjeto]?>"/>
            <input type="hidden" name="tnobjeto" id="tnobjeto" value="<?php echo $_POST[tnobjeto]?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantallac" style="height:86%; width:99.1%; overflow-x:hidden;overflow-y:hidden;">
			
			 <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="10" >Datos Proyecto</td>
                             
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:7%">Codigo:</td>
                                <td style="width:20%"><input type="text" name="codigoproy" id="codigoproy" value="<?php echo $_POST[codigoproy]?>" style="width:98%" readonly></td>
                                <td class="saludo1" style="width:7%">Vigencia:</td>
                                <td style="width:7%"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]?>" style="width:98%" readonly></td>
                                 <td style="width: 15%" class="saludo1" colspan="2">
									<input type="button" name="agregar6" id="agregar6" value=" VER CERTIFICADO "  onClick="pdf()" style="width:100%" />
								</td>
                                
								
                            </tr>
                            <tr>
                                <td class="saludo1">Nombre:</td>
                                <td colspan="3">
                                    <input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:100%;text-transform: uppercase;" readonly> 
                                </td>
                                <td class="saludo1">Valor:</td>
                                <td>
       
                                    <script>jQuery(function($){ $('#valorproyecto').autoNumeric('init');});</script>
                                    <input type="hidden" name="valorp" id="valorp" value="<?php echo $_POST[valorp]?>"   />
                                    <input type="text" id="valorproyecto" name="valorproyecto"  value="<?php echo $_POST[valorproyecto]?>" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('valorp','valorproyecto');return tabular(event,this);" onBlur="validarcdp();" style="width:100%; text-align:right;" autocomplete="off" readonly>
                                    <input type="hidden" name="saldo" id="saldo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" > 

                                </td>
                                <input type="hidden" name="contador" id="contador" value="<?php echo $_POST[contador];?>" >
                            </tr>
							<tr>
                                <td class="saludo1">Descripci&oacute;n:</td>
                                <td colspan="6">
                                    <input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:100%;text-transform: uppercase;" readonly> 
                                </td>
                                
                              
                            </tr>
                           
                           
                        </table>
	
                         <?php
                        	$conta=0;
							$sqln="SELECT nombre, orden FROM plannivelespd WHERE estado='S' AND nombre NOT LIKE '%INDICADORES%' ORDER BY orden";
                            $resn=mysql_query($sqln,$linkbd);
							$num=mysql_num_rows($resn);	
                        	 echo"
                                <div class='subpantalla' style='height:70%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='$num'>Detalle Metas Certificadas</td>
                                            </tr>
                                            <tr>";
                                $sqln="SELECT nombre, orden FROM plannivelespd WHERE estado='S' ORDER BY orden";
                                $resn=mysql_query($sqln,$linkbd);
                                $n=0; $j=0;
                                while($wres=mysql_fetch_array($resn))
                                {
                                    if (strcmp($wres[0],'INDICADORES')!=0)
                                    {
                         				$conta++;
                                        echo "<td class='titulos2' style='width: 18% !important'>".strtoupper($wres[0])."</td>";
                                        	
                                    }
                                }
				
                              		  echo "</tr>";
               	 
                                $itern='saludo1a';
                                $iter2n='saludo2';
								for($x=0;$x<$_POST[contador]; $x++){
									if(!empty($_POST["matmetas$x"][0]) && isset($_POST["matmetas$x"][0])){
									echo "<tr class='$itern'>";
									for ($y=0;$y<$conta;$y++)
                                {
									
									
										echo "<td>";
										echo $_POST["matmetas$x"][$y]." - ".$_POST["matmetasnom$x"][$y];
										echo "<input type='hidden' name='matmetas".$x."[]' value='".$_POST["matmetas$x"][$y]."' />";
										echo "<input type='hidden' name='matmetasnom".$x."[]' value='".$_POST["matmetasnom$x"][$y]."' />";
										echo "</td>";
									
									
                                    $auxn=$itern;
                                    $itern=$itern2;
                                    $itern2=$auxn;
                                }
                            
								echo "</tr>";
									}
								}
                                
                                echo "
                                    </table></div>";
                         ?>
                  
					
            </div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
			 <input type="hidden" name="codigot" id="codigot" value="<?php echo $_POST[codigot];?>" />
		</form>
	</body>
</html>
