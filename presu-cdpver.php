<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function guardar()
			{
				if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.solicita.value!='')
				{
					if (confirm("Esta Seguro de Guardar"))
					{
						document.form2.oculto.value=2;
						document.form2.submit();
					}
				}
				else
				{
					alert('Faltan datos para completar el registro');
					document.form2.fecha.focus();
					document.form2.fecha.select();
				}
			}
			function validar(formulario)
			{
				var x = document.getElementById("tipomov").value;
				document.form2.movimiento.value=x;
				document.form2.action="presu-cdpver.php";
				document.form2.submit();
			}
			function pdf()
			{
				document.form2.action="pdfcdispre.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function finaliza()
 			{
 				if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
  				{
	  				document.form2.fin.value=1;
	 				document.form2.fin.checked=true; 
				} 
				else {document.form2.fin.value=0;}
				document.form2.fin.checked=false; 
			}
			function capturaTecla(e)
			{ 
				var tcl = (document.all)?e.keyCode:e.which;
				if (tcl==115)
				{
					alert(tcl);
					return tabular(e,elemento);
				}
			}
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					document.form2.action="presu-cdpver.php";
					document.form2.submit();
				}
			}
			function atrasc()
			{
				if(document.form2.ncomp.value>1)
 				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					document.form2.action="presu-cdpver.php";
					document.form2.submit();
 				}
			}
			function validar2()
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.idcomp.value;
				document.form2.action="presu-cdpver.php";
				document.form2.submit();
			}
		</script>
		<?php titlepag();?>
    </head>
    <body >
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table >
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='presu-cdp.php'" class="mgbt"/><img src="imagenes/guarda.png" href="#" title="Guardar" onClick="guardar()" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='presu-buscacdp.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"/><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"  onClick="location.href='presu-buscacdp.php'" class="mgbt"></td>
        	</tr>
		</table>
  		<?php
			 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
  			//***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
			$oculto=$_POST['oculto'];
			if($_POST[oculto]=='2')
			{
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
				//************** modificacion del presupuesto **************
				$sqlr="UPDATE pptocdp set objeto='$_POST[objeto]',solicita='$_POST[solicita]' where vigencia='$vigusu' and consvigencia='$_POST[idcomp]' AND tipo_mov='201'";
				if (!mysql_query($sqlr,$linkbd))
				{
					echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
	 				echo "Ocurri� el siguiente problema:<br>";
  	 				echo "<pre>";
					echo "</pre></center></td></tr></table>";
				}
  	 			else
  	 			{
	  				echo "<table class='inicio'><tr><td class='saludo1'> Se ha almacenado el CDP con Exito <img src='imagenes\confirm.png'></center></tr></table>";
	  				$sqlr="UPDATE pptocomprobante_cab set concepto='$_POST[objeto]' where vigencia='$vigusu' and numerotipo='$_POST[idcomp]' and tipo_comp='6'";
	  				mysql_query($sqlr,$linkbd);	
				}
				//********* creacion del cdp ****************
			}//*** if de control de guardado
			$codMovimiento='201';
			if(isset($_POST['movimiento']))
			{
		 		if(!empty($_POST['movimiento'])){$codMovimiento=$_POST['movimiento'];}
			}
			if(!$_POST[oculto])
			{	
				$_POST[vigencia]=$vigusu;
				$_POST[ncomp]=$_GET[is];
				$_POST[idcomp]=$_GET[is];
				$sqlr="SELECT consvigencia FROM  pptocdp WHERE vigencia='$vigusu' AND tipo_mov='$codMovimiento' ORDER BY consvigencia DESC";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
			}                                  
			$_POST[solicita]="";
		 	$_POST[objeto]="";
		 	$_POST[estadoc]="";
			$sqlr="select distinct * from pptocdp  where pptocdp.vigencia='$vigusu' and pptocdp.consvigencia=$_POST[ncomp] AND pptocdp.tipo_mov='$codMovimiento' ";
			$res=mysql_query($sqlr,$linkbd); 
			$_POST[agregadet]='';
			$cont=0;
			while ($row=mysql_fetch_row($res)) 
		 	{		
		 		$_POST[vigencia]=$row[1];
				$_POST[estado]= $row[5];
				switch($row[5])
   				{
					case 'S':	$_POST[estadoc]='ACTIVO';
								$color=" style='background-color:#0CD02A ;color:#fff'";
								break;
					case 'C':	$_POST[estadoc]='COMPLETO'; 	 				
								$color=" style='background-color:#00CCFF ; color:#fff'"; 
								break;
					case 'N':	$_POST[estadoc]='ANULADO'; 
								$color=" style='background-color:#aa0000 ; color:#fff'";
								break;
					case 'R':	$_POST[estadoc]='REVERSADO'; 
								$color=" style='background-color:#aa0000 ; color:#fff'";
								break;
		 		}
				$p1=substr($row[3],0,4);
				$p2=substr($row[3],5,2);
				$p3=substr($row[3],8,2);
				$_POST[fecha]=$row[3];	
				ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
				$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];			
				$_POST[solicita]=$row[6];
				$_POST[objeto]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[7]);
				$_POST[numero]=$row[2];
			}
		 	$_POST[dcuentas]= array(); 		 
		 	$_POST[dncuentas]= array(); 		 
		 	$_POST[dgastos]= array(); 
		 	$_POST[dcfuentes]= array(); 
			$_POST[dfuentes]= array(); 
			$sqlr="select distinct *from  pptocdp_detalle where  pptocdp_detalle.consvigencia=$_POST[ncomp] and pptocdp_detalle.vigencia='".$vigusu."' AND pptocdp_detalle.tipo_mov='$codMovimiento' ORDER BY CUENTA ";
			$res=mysql_query($sqlr,$linkbd); 
			$_POST[agregadet]='';
			$cont=0;
			while ($row=mysql_fetch_row($res)) 
		 	{				
				$_POST[dcuentas][$cont]=$row[3];
				$_POST[dncuentas][$cont]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",existecuentain($row[3]));
				$_POST[dgastos][$cont]=$row[5];
				$nfuente=buscafuenteppto($row[3],$_POST[vigencia]);
	  	 		$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
		 		$_POST[dcfuentes][]=$cdfuente;
	  	 		$_POST[dfuentes][]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$nfuente);
		 		$cont=$cont+1;
		 	}
		?>
 		<form name="form2" method="post" action="">
    		<table class="inicio" align="center" width="80%" >
				<tr >
					<td class="titulos" colspan="8">.: Certificado Disponibilidad Presupuestal </td>
					<td class="cerrar" style='width:7%' onClick="location.href='presu-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td style="width:9%;" class="saludo1">N&uacute;mero:</td>
        			<input type="hidden" name="cuentacaja" value="<?php echo $_POST[cuentacaja]?>"/>
                    <input type="hidden" name="ncomp" value="<?php echo $_POST[ncomp]?>"/>
                    <input type="hidden" name="atras" value="a"/>
                    <input type="hidden" value="s" name="siguiente"/>
                    <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"/>
                    <input name="numero" type="hidden" id="numero" value="<?php echo $_POST[numero] ?>" readonly/>
					<td style="width:15%;"><img src="imagenes/back.png" title="Anterior" onClick="atrasc()" class="icobut">&nbsp;<input type="text" name="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) " style="width:50%;" onBlur="validar2()"/>&nbsp;<img src="imagenes/next.png" title="Siguiente" onClick="adelante()" class="icobut"/></td>
	  				<td style="width:9%;" class="saludo1">Vigencia:</td>
	  				<td style="width:10%;"><input style="width:100%;" type="text" name="vigencia" value="<?php echo $_POST[vigencia] ?>" readonly></td>
	  				<td class="saludo1" style="width:9%;">Fecha:</td>
        			<td style="width:12%;"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;" readonly>&nbsp;<img src="imagenes/calendario04.png" class="icobut" style="width:21px" title="Calendario" onClick="displayCalendarFor('fc_1198971545');"/></a></td>
					<input type="hidden" name="chacuerdo" value="1">		  
					<td  class="saludo1">Estado</td>
					<td >
                    	<input name="estadoc" type="text" id="estadoc" value="<?php echo $_POST[estadoc] ?>" <?php echo $color; ?> readonly>
						<select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" onChange="validar()" style="float:right">
                		<?php
                 			$codMovimiento='201';
							if(isset($_POST['movimiento']))
							{
						 		if(!empty($_POST['movimiento'])){$codMovimiento=$_POST['movimiento'];}
						 	}
                 			$sql="SELECT tipo_mov FROM pptocdp where consvigencia=$_POST[ncomp] AND vigencia='$vigusu' ORDER BY tipo_mov";
							$resultMov=mysql_query($sql,$linkbd);
							$movimientos=Array();
							$movimientos["201"]["nombre"]="201-Documento de Creacion";
							$movimientos["201"]["estado"]="";
							$movimientos["401"]["nombre"]="401-Reversion Total";
							$movimientos["401"]["estado"]="";
							$movimientos["402"]["nombre"]="402-Reversion Parcial";
							$movimientos["402"]["estado"]="";
		 					while($row = mysql_fetch_row($resultMov))
							{
								$mov=$movimientos[$row[0]]["nombre"];
								$movimientos[$codMovimiento]["estado"]="selected";
								$state=$movimientos[$row[0]]["estado"];
								echo "<option value='$row[0]' $state>$mov</option>";
		 					}
		 					$movimientos[$codMovimiento]["estado"]="";
		 					echo "<input type='hidden' id='movimiento' name='movimiento' value='$_POST[movimiento]' />";
                		?>        
                		</select>
						<input name="estado" type="hidden" id="estado" value="<?php echo $_POST[estado] ?>" ></td>
					</tr>
                <tr>
                    <td class="saludo1"><input type="hidden" value="1" name="oculto">Solicita:</td>
                    <td colspan="3"><input name="solicita" type="text" id="solicita" onKeyUp="return tabular(event,this)" style="width:100%;" value="<?php echo $_POST[solicita]?>" ></td>
                    <td class="saludo1">Objeto:</td>
                    <td  colspan="3"><input name="objeto" style="width:100%;" type="text" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo htmlspecialchars($_POST[objeto])?>" ></td>
                </tr>
			</table>
			<?php
                if(!$_POST[oculto]){echo "<script>document.form2.fecha.focus();</script>";}
                //**** busca cuenta
                if($_POST[bc]!='')
                {
                    $nresul=buscacuentapres($_POST[cuenta],2);
                    if($nresul!='')
                    {
                        $_POST[ncuenta]=$nresul;
                        echo"
                        <script>
                            document.getElementById('valor').focus();
                            document.getElementById('valor').select();
                        </script>";
                    }
                    else
                    {
                        $_POST[ncuenta]="";
                        echo " <script>alert('Cuenta Incorrecta');document.form2.cuenta.focus();</script>";
                    }
                }
            ?>
            <div class="subpantalla" style="height:57%; width:99.6%; overflow-x:hidden;">
                <table class="inicio" width="99%">
                    <tr> <td class="titulos" colspan="5">Detalle CDP</td></tr>
                    <tr>
                        <td class="titulos2">Cuenta</td>
                        <td class="titulos2"><center>Nombre Cuenta </center></td>
                        <td class="titulos2"><center>Fuente </center></td>
                        <td class="titulos2"><center>Valor </center></td>
                    </tr>
                    <?php 
                        $iter1='saludo1a';
                        $iter2='saludo2';
                        for ($x=0;$x<count($_POST[dcuentas]);$x++)
                        {
                            $nfuente=buscafuenteppto($_POST[dcuentas][$x],$vigusu);
                            $cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
                            $_POST[dcfuentes][]=$cdfuente;
                            $_POST[dfuentes][]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$nfuente);
                            echo "
                            <input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
                            <input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
                            <input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'/>
                            <input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."'/>
                            <input type='hidden' name='dgastos[]' value='".$_POST[dgastos][$x]."'/>
                            <tr class=$iter1>
                                <td style='width:10%;'>".$_POST[dcuentas][$x]."</td>
                                <td style='width:32%;'>".$_POST[dncuentas][$x]."</td>
                                <td style='width:45%;'>".$_POST[dfuentes][$x]."</td>
                                <td style='width:13%;text-align:right;'>".number_format($_POST[dgastos][$x],2,$_SESSION["spdecimal"],$_SESSION["spmillares"])."</td>
                            </tr>";
                            $gas=$_POST[dgastos][$x];
                            $aux=$iter1;
                            $iter1=$iter2;
                            $iter2=$aux;
                            $gas=$gas;
                            $cuentagas=$cuentagas+$gas;
                            $_POST[cuentagas2]=$cuentagas;
                            $total=number_format($total,2,$_SESSION["spdecimal"],"");
                            $_POST[cuentagas]=number_format($cuentagas,2,$_SESSION["spdecimal"],$_SESSION["spmillares"]);
                            $resultado = convertir($_POST[cuentagas2]);
                            $_POST[letras]=$resultado." Pesos";
                        }
                        echo "
                        <input type='hidden' name='cuentagas' id='cuentagas' value='$_POST[cuentagas]'/>
                        <input type='hidden' name='cuentagas2' id='cuentagas2' value='$_POST[cuentagas2]'/>
                        <input type='hidden' name='letras' id='letras' value='$_POST[letras]'/>
                        <tr class=$iter1>
                            <td colspan='3' style='text-align:right;'>Total:</td>
                            <td style='text-align:right;'>$_POST[cuentagas]</td>
                        </tr>
                        <tr>
                            <td class='saludo1'>Son:</td>
                            <td class='saludo1' colspan= '4'>$resultado</td>
                        </tr>";
                    ?>
                </table>
            </div>
    	</form>
	</body>
	<script>
 		jQuery(function($){
  		var user ="<?php echo $_SESSION[cedulausu]; ?>";
  		var bloque='';
  		$.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
		$('#cambioVigencia').change(function(event) {
   		var valor= $('#cambioVigencia').val();
   		var user ="<?php echo $_SESSION[cedulausu]; ?>";
   		var confirma=confirm('�Realmente desea cambiar la vigencia?');
   		if(confirma)
		{
			var anobloqueo=bloqueo.split("-");
			var ano=anobloqueo[0];
			if(valor < ano)
			{
				if(confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar"))
				{$.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse); }
				else{location.reload(); }
			}
			else{ $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);}
  		}
		else{location.reload();}
 		});
		function updateresponse(data)
		{
  			json=eval(data);
  			if(json[0].respuesta=='2'){alert("Vigencia modificada con exito"); }
  			else if(json[0].respuesta=='3'){lert("Error al modificar la vigencia"); }
 			location.reload();
 		}
		function selectresponse(data)
		{ 
			json=eval(data);
  			$('#cambioVigencia').val(json[0].vigencia);
  			bloqueo=json[0].bloqueo;
 		}
 		}); 
	</script>
</html>