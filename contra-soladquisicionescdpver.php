<?php //V 1000 12/12/16 ?> 
<?php
error_reporting(0);
require"comun.inc";
require"funciones.inc";
require "conversor.php";
session_start();
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid - Presupuesto</title>
		<script>			
			function pdf()
			{
				document.form2.action="pdfcdpsoladquisiciones.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function generacdp(){
				document.form2.action="pdfcdispre.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <?php titlepag();?>
	</head>
	<body>
		<?php
 		$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$estilo="";
		if(!$_POST[oculto])
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT * FROM contrasoladquisiciones WHERE codcdp='$_GET[is]'";
			$res=mysql_query($sqlr,$linkbd);
			$row =mysql_fetch_row($res);
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[ovigencia]= $vigusu;
			$_POST[codigot]=$_GET[solicitud];
			$_POST[fecha]=$row[1];
			$_POST[nadquisicion]=$row[2];
			//INFORMACION TERCERO
			$valor=$_SESSION[cedulausu];
			$nresul=buscatercerod($valor);		 
			$_POST[sdocumento][]=$valor;
			$_POST[snombre][]=$nresul[0]; 
			$_POST[sidependencia][]=$nresul[2];
			$_POST[sndependencia][]=$nresul[1];
		
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
			$sqlr="select distinct * from pptocdp  where pptocdp.vigencia='$_GET[vig]' and pptocdp.consvigencia=$_GET[is] and pptocdp.tipo_mov='201' ";
			$res=mysql_query($sqlr,$linkbd); 
			$_POST[agregadet]='';
			$cont=0;
			while ($row=mysql_fetch_row($res)) 
			{		
		 		$_POST[vigencia]=$row[1];
				$_POST[estado]= $row[5];
				switch($row[5])
				{
					case "S":
						$_POST[estadoc]='DISPONIBLE';$estilo="style='background-color:#0CD02A ;color:#fff;text-align:center;font-weight:bold'; "; break;
					case "C":
						 $_POST[estadoc]='CON REGISTRO';$estilo="style=' background-color:#FFEB3B ;color:#aa0000; text-align:center;font-weight:bold' "; break;
					case "N":
						 $_POST[estadoc]='ANULADO'; $estilo="style=' background-color:#0CD02A ;color:#aa0000; text-align:center;font-weight:bold' "; break;
				}
				$p1=substr($row[3],0,4);
				$p2=substr($row[3],5,2);
				$p3=substr($row[3],8,2);
				$_POST[fecha]=$row[3];	
				ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
				$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];						 
				$_POST[solicita]=$row[6];
				$_POST[objeto]=$row[7];
				$_POST[numero]=$row[2];
		 	}
			$sqlr="select pptocuentas.cuenta,pptocuentas.nombre,pptocdp.valor,pptocuentas.futfuentefunc,pptocuentas.futfuenteinv from pptocdp, pptocdp_detalle,pptocuentas where pptocdp.vigencia='$_GET[vig]' and pptocdp.tipo_mov='201' and pptocdp_detalle.tipo_mov='201' and pptocdp.consvigencia=pptocdp_detalle.consvigencia and pptocdp_detalle.cuenta = pptocuentas.cuenta and pptocdp.consvigencia=$_GET[is] and pptocdp_detalle.vigencia='".$vigusu."' and (pptocuentas.vigencia=$_POST[vigencia] OR pptocuentas.vigenciaf=$_POST[vigencia] ) group by pptocdp_detalle.id_cdpdetalle";
			//echo $sqlr;
			$res=mysql_query($sqlr,$linkbd); 
			$_POST[agregadet]='';
			$cont=0;
			while ($row=mysql_fetch_row($res)) 
		 	{		
		 		$_POST[dcuentas][$cont]=$row[0];
		 		$_POST[dncuentas][$cont]=$row[1];
		 		$_POST[dgastos][$cont]=$row[2];
				if (!empty($row[3]))
				{
					$sqlr2="select codigo,nombre from pptofutfuentefunc where codigo='$row[3]'";

				}
				else
				{
					$sqlr2="select codigo,nombre from pptofutfuenteinv where codigo='$row[4]'";

				}
				$res2=mysql_query($sqlr2,$linkbd); 
				while ($row2=mysql_fetch_row($res2)) 
 				{
 					$_POST[dcfuentes][$cont]=$row2[0];
		 			$_POST[dfuentes][$cont]=$row2[1];	
		 		}
		 		$cont=$cont+1;
		 	}
			
			
			
			$sqlr3="SELECT * FROM contrasoladquisicionesgastos WHERE codsolicitud='".$_POST[codigot]."'";
			$res3=mysql_query($sqlr3,$linkbd);
			$contador1=0;
			while ($row3 =mysql_fetch_row($res3))
			{
				$contador1=$contador1+1;
				$_POST[dcuentas2][]=$row3[3];
				$tipo=substr($row3[3],0,1);		
				$nresul=buscacuentapres($row3[3],$tipo); 
				$_POST[dncuentas2][]=$nresul;
				$ind=substr($row3[3],0,1);
				if ($ind==2)
				{
					$sqlr4="select nombre from pptofutfuentefunc where codigo='$row3[4]'";
					$res4=mysql_query($sqlr4,$linkbd);
					$row4 =mysql_fetch_row($res4);
				}
				else
				{
					$sqlr4="select nombre from pptofutfuenteinv where codigo='$row3[4]'";
					$res4=mysql_query($sqlr4,$linkbd);
					$row4 =mysql_fetch_row($res4);
				}
				$_POST[dtipogastos2][]=$row3[1];
				$_POST[dfuentes2][]=$row4[0];
				$_POST[dcfuentes2][]=$row3[4];
				$_POST[dgastos2][]=$row3[5];
				$sqlr5="select nombre from presuplandesarrollo where codigo='$row3[2]'";
				$res5=mysql_query($sqlr5,$linkbd);
				$row5 =mysql_fetch_row($res5);
				$_POST[dmetas2][]=$row3[2];
				$_POST[dnmetas2][]=$row5[0];
				$_POST[dconproyec2][]=$row3[7];
				$sqlr6="select codigo, nombre from planproyectos where consecutivo='$row3[7]'";
				$res6=mysql_query($sqlr6,$linkbd);
				$row6 =mysql_fetch_row($res6);
				$_POST[dcodproyec2][]=$row6[0];		 
				$_POST[dnomproyec2][]=$row6[1];	 
			} 
		}
		?>
 		<form name="form2" method="post" action="">
    		<table class="inicio" align="center" width="80%" >
      			<tr>
        			<td class="titulos" colspan="9">.: Certificado Disponibilidad Presupuestal </td>
        			<td width="73" class="cerrar" ><a href="#" onClick="parent.cerrarventanas()">Cerrar</a></td>
      			</tr>
     			<tr>
                	<td width="74" class="saludo1">Vigencia:</td>
                    <td width="27"><input size="5" type="text" name="vigencia" value="<?php echo $_POST[vigencia] ?>" readonly></td>
	  				<td width="79" class="saludo1">Numero:</td>
		  			<td width="215"><input name="numero" type="text" id="numero" value="<?php echo $_POST[numero] ?>" size="5" readonly></td>
	 	 			<td width="56" class="saludo1">Fecha:</td>
        			<td width="168" ><input name="fecha" type="text" id="fc_1198971545"  size="10" value="<?php echo $_POST[fecha]; ?>" readonly></td>
                    <td width="110" class="saludo1">Estado</td>
                    <td width="75" >
                    	<input name="estadoc" type="text" id="estadoc" value="<?php echo $_POST[estadoc] ?>" size="16" <?php echo $estilo; ?> readonly>
                        <input name="estado" type="hidden" id="estado" value="<?php echo $_POST[estado] ?>">
                    </td>
					<td width="165" >
                    	<input type="button" name="agregar6" id="agregar6" value="   PDF Certificado CDP   "  onClick="generacdp()" />
                    </td>
	    		</tr>
                <tr>
	   				<td class="saludo1"><input type="hidden" value="1" name="oculto">Solicita:</td>
	   				<td colspan="3"><input name="solicita" type="text" id="solicita" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[solicita]?>" size="60" readonly></td>
	   				<td class="saludo1">Objeto:</td>
                    <td  colspan="4"><input name="objeto" type="text" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[objeto]?>" style="width:91% !important" readonly></td>
             	</tr>
       		</table>
			<table class="inicio" width="99%">
        		<tr>	
          			<td class="titulos" colspan="5">Detalle CDP</td>
       			</tr>
				<tr>
					<td class="titulos2" style="width:10%">Cuenta</td>
                    <td class="titulos2" style="width:20%">Nombre Cuenta</td>
                    <td class="titulos2">Fuente</td>
                    <td class="titulos2"  style="width:15%">Valor</td>
				</tr>
				<?php 
					$itern='saludo1a';
                	$itern2='saludo2';
		 			for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 			{ 
						echo "
						<input type='hidden' name='dgastos[]' value='".$_POST[dgastos][$x]."' >
				<tr class='$itern'>
					<td>".$_POST[dcuentas][$x]."<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'></td>
					<td>".$_POST[dncuentas][$x]."<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'></td>
					<td>".$_POST[dfuentes][$x]."
						<input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'>
						<input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."' ></td>
					<td style='width:10%; text-align:right;'>$".number_format($_POST[dgastos][$x],2,",",".")."</td>
					
				</tr>";
						$auxn=$itern;
                   		$itern=$itern2;
              			$itern2=$auxn;
						$gas=$_POST[dgastos][$x];
		 				$cuentagas=$cuentagas+$gas;
		 				$_POST[cuentagas2]=$cuentagas;
		 				$total=number_format($total,2,",","");
 						$_POST[cuentagas]=number_format($cuentagas,2,",",".");
						$resultado = convertir($_POST[cuentagas2]);
						$_POST[letras]=$resultado." PESOS";
		 			}
		 			echo "
				<tr class='$itern'>
					<td></td>
					<td colspan='1'></td>
					<td style='text-align:right;'>Total:</td>
					<td style='text-align:right;'>$$_POST[cuentagas]
						<input type='hidden' class='inpnovisibles' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]' readonly>
						<input type='hidden'id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' >
						<input type='hidden' id='letras' name='letras' value='$_POST[letras]'>
						
					</td>
				</tr>
		 		<tr>
					<td class='saludo1'>Son:</td>
					<td class='saludo1' colspan= '4'>$resultado</td>
				</tr>";
				?>
			</table>
        	<input type="hidden" name="codcdp" id="codcdp" value="<?php echo $_POST[codcdp];?>">
            <input type="hidden" name="codigot" id="codigot" value="<?php echo $_POST[codigot]?>" >
            <input type="hidden" name="fechat" id="fechat" value="<?php echo $_POST[fechat]?>">
            <input type="hidden" name="codigoproy" id="codigoproy" value="<?php echo $_POST[codigoproy]?>">
            <input type="hidden" name="codadquisicion" id="codadquisicion"value="<?php echo $_POST[codadquisicion]?>">
            <input type="hidden" name="nadquisicion" id="nadquisicion" value="<?php echo $_POST[nadquisicion]?>">
            <input type="hidden" name="tercero" id="tercero" value="<?php echo $_POST[tercero]?>">
            <input type="hidden" name="ntercero" id="ntercero"  value="<?php echo $_POST[ntercero]?>">
            <input type="hidden" name="dependencia" id="dependencia" value="<?php echo $_POST[dependencia]?>">
            <input type="hidden" name="iddependencia" id="iddependencia" value="<?php echo $_POST[iddependencia]?>">
            <input type="hidden" name="banderin2" id="banderin2" value="<?php echo $_POST[banderin2];?>" >
            <input type="hidden" name="ovigencia" id="ovigencia" value="<?php echo $_POST[ovigencia];?>">
            <span style="visibility:hidden">
                <table>
                <?php
                for ($x=0;$x<count($_POST[sdocumento]);$x++)
                {		 
                    echo "
                        <tr>
                            <td><input type='text' name='sdocumento[]' value='".$_POST[sdocumento][$x]."'></td>
                            <td><input type='text' name='snombre[]'  value='".$_POST[snombre][$x]."'></td>
                            <td>
                                <input type='text' name='sndependencia[]' value='".$_POST[sndependencia][$x]."'>
                                <input type='hidden' name='sidependencia[]' value='".$_POST[sidependencia][$x]."'>
                            </td>	
                        </tr>";	
                }	
                ?>
                </table>
                <table>
                <?php
                    for ($x=0;$x<count($_POST[dproductos]);$x++)
                    {		 
                        echo "
                            <tr >
                                <td><input type='text' name='dproductos[]' value='".$_POST[dproductos][$x]."'></td>
                                <td><input type='text' name='dnproductos[]'  value='".$_POST[dnproductos][$x]."'></td>
                                <td><input type='text' name='dtipos[]' value='".$_POST[dtipos][$x]."'></td>
							</tr>";		
                  	}	
                ?>
                </table>
                <table>
                <?php
					for ($x=0;$x<count($_POST[dcuentas]);$x++)
					{
						echo "
							<tr>
							<td><input type='text' name='dcuentas2[]' value='".$_POST[dcuentas2][$x]."'></td>
							<td><input type='text' name='dncuentas2[]' value='".$_POST[dncuentas2][$x]."'></td>
							<td>
								<input type='hidden' name='dcfuentes2[]' value='".$_POST[dcfuentes2][$x]."'>
								<input type='text' name='dfuentes2[]' value='".$_POST[dfuentes2][$x]."'>
							</td>
							<td>
								<input type='hidden' name='dmetas2[]' value='".$_POST[dmetas2][$x]."'>
								<input type='text' name='dnmetas2[]' value='".$_POST[dnmetas2][$x]."' type='text'>
							</td>
							<td>
								<input type='hidden' name='dconproyec2[]' value='".$_POST[dconproyec2][$x]."'>
								<input type='hidden' name='dcodproyec2[]' value='".$_POST[dcodproyec2][$x]."'>
								<input type='text' name='dnomproyec2[]' value='".$_POST[dnomproyec2][$x]."'>
							</td>
							<td><input type='text'name='dgastos2[]' value='".$_POST[dgastos2][$x]."'></td>
							<input type='hidden' name='dtipogastos2[]' value='".$_POST[dtipogastos2][$x]."' >
							</tr>";
					}
				?>
                </table>
              	
            </span>
    	</form>
	</body>
</html>