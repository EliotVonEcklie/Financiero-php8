<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	header('Content-Type: text/html; charset=ISO-8859-1'); 
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
	require "conversor.php";
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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			function guardar()
			{
				var validacion00=document.form2.solicita.value;
				if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && validacion00.trim()!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.fecha.focus();
					document.form2.fecha.select();
				}
			}
			function validar(formulario)
			{
				document.form2.action="presu-cdp.php";
				document.form2.submit();
			}
			function validar2(formulario)
			{
				document.form2.chacuerdo.value=2;
				document.form2.action="presu-cdp.php";
				document.form2.submit();
			}
			function validarcdp()
			{
				sinpuntitos2('valor','valorvl');
				valorp=document.getElementById("valor").value;
				nums=valorp;		
				if(nums<0 || nums> parseFloat(document.form2.saldo.value))
				{
					despliegamodalm('visible','2','Valor Superior al Disponible '+document.form2.saldo.value);
					document.form2.cuenta.select();
					document.form2.cuenta.focus();
					msg=0;
				}
				else{msg=1;}
				return msg;
			}
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value=2;
					document.form2.submit();
				}
			}
			function agregardetalle()
			{
				if(document.form2.cuenta.value!="" &&  document.form2.fuente.value!="" && parseFloat(document.form2.valor.value) >=0 )
				{ 
					$resp=validarcdp();
					if($resp==1)
					{
						document.form2.agregadet.value=1;
						//document.form2.chacuerdo.value=2;
						document.form2.submit();
					}	
				}
				else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function pdf()
			{
				document.form2.action="pdfcdispre.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="cuentasppto-ventana01.php?ti=2";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('valfocus').value='0';
									document.getElementById('ncuenta').value='';
									document.getElementById('fuente').value='';
									document.getElementById('saldo').value=0;
									document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();
									break;
					}
				}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje()
			{
				var numdocar=document.getElementById('numero').value;
				var vigencar=document.getElementById('vigencia').value;
				document.location.href = "presu-cdpver.php?is="+numdocar+"&vig="+vigencar;
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";
								document.form2.submit();
								document.form2.action="pdfcdp.php";
								break;
					case "2": 	document.form2.chacuerdo.value=2;
								document.form2.oculto.value="3";
								document.form2.submit();
								break;
				}
			}
			jQuery(function($){ $('#valorvl').autoNumeric('init');});
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
          		<td colspan="3" class="cinta">
				<a onClick="location.href='presu-cdp.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png" title="Guardar" /></a>
				<a onClick="location.href='presu-buscacdp.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
				<a onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				<a <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"><img src="imagenes/print.png" title="Imprimir" style="width:29px; height:25px;"/></a></td>
        	</tr>
        </table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php 
			//$vigencia=date(Y);
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			$_POST[vigencia]=vigencia_usuarios($_SESSION[cedulausu]); 
			$vigencia=$vigusu;
			if($_POST[oculto]=='')
			{
		 		//$_POST[vigencia]=$_SESSION[vigencia]; 	
 		 		$fec=date("d/m/Y");
		 		$_POST[fecha]=$fec; 	
		 		$_POST[valor]=0; 			 
		 		$_POST[cuentaing]=0;
				$_POST[cuentagas]=0;
 		 		$_POST[cuentaing2]=0;
		 		$_POST[cuentagas2]=0;
				$sqlr="select max(consvigencia) from pptocdp where vigencia=$_POST[vigencia] ";
				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res)){$maximo=$r[0];}
				if(!$maximo){$_POST[numero]=1;}
	  			else{$_POST[numero]=$maximo+1;}
			}
			//**** busca cuenta
			if($_POST[bc]!='')
			{
				//$tipo=substr($_POST[cuenta],0,1);			
			  	$nresul=buscacuentapres($_POST[cuenta],2);			
			  	if($nresul!='')
			   	{
			  		$_POST[ncuenta]=$nresul;
			  		//$sqlr="select *from pptocuentaspptoinicial where cuenta='$_POST[cuenta]' and vigencia=".$_POST[vigencia];
 			  		$sqlr="select *from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or   vigenciaf=$vigusu)";
			  		$res=mysql_query($sqlr,$linkbd);
			  		$row=mysql_fetch_row($res);
			  		$_POST[valor]=0;		  
			  		//$_POST[saldo]=$row[6];	
			  		$vigenciai=$row[25];
			  		$clasifica=$row[29];
			  		$vsal=consultasaldo($_POST[cuenta],$vigenciai,$vigusu);
			  		$_POST[saldo]=$vsal;
			  		$ind=substr($_POST[cuenta],0,1);
			  		//$reg=substr($_POST[cuenta],0,1);					  	
			 		$criterio="and (pptocuentas.vigencia=".$vigusu." or  pptocuentas.vigenciaf=$vigusu) ";
			 		if ($clasifica=='funcionamiento')
			  		{
			  			$sqlr="select pptocuentas.futfuentefunc,pptocuentas.pptoinicial,pptofutfuentefunc.nombre from pptocuentas,pptofutfuentefunc where pptocuentas.cuenta='$_POST[cuenta]'  and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
			 			$_POST[tipocuenta]=2;
			  		}
			  		if ($clasifica=='deuda' )
			 		{
						$sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
			  			$_POST[tipocuenta]=3;
			 		}
			  		if ($clasifica=='inversion')
			  		{
						$sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
			  			$_POST[tipocuenta]=4;
			  		}
			  		$res=mysql_query($sqlr,$linkbd);
			  		$row=mysql_fetch_row($res);
			      	if($row[1]!='' || $row[1]!=0)
			     	{
				 		$_POST[cfuente]=$row[0];
				  		$_POST[fuente]=$row[2];
				  		$_POST[valor]=0;			  
				 	}
				 	else
				  	{
					 	$_POST[cfuente]="";
	  			   		$_POST[fuente]=""; 
				  		/*$_POST[cfuente]="";
	  			   		$_POST[fuente]="";
				  		$_POST[valor]="";			  
				  	 	$_POST[saldo]="";
				   		$_POST[cuenta]="";			  
				   		$_POST[ncuenta]="";*/
				  	}  
			   	}
			  	else
			  	{
			  		$_POST[ncuenta]="";	
			   		$_POST[fuente]="";				   
			   		$_POST[cfuente]="";				   			   
			   		$_POST[valor]="";
			   		//$_POST[saldo]="";
			   	}
			}
			/*if ($_POST[chacuerdo]=='2')
			{
				$_POST[dcuentas]=array();
				$_POST[dncuentas]=array();
				$_POST[dingresos]=array();
				$_POST[dgastos]=array();
				$_POST[diferencia]=0;
				$_POST[cuentagas]=0;
				$_POST[cuentaing]=0;																			
			}*/
		$sqlv="select *from dominios where nombre_dominio='VIGENCIA_PD' and tipo='S'";
		$resv=mysql_query($sqlv,$linkbd);
		$wv=mysql_fetch_row($resv);
		$_POST[vigenciaini]=$wv[0];
		$_POST[vigenciafin]=$wv[1];
		?>
 		<form name="form2" method="post" action="">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
    		<table class="inicio">
                <tr>
                    <td class="titulos" colspan="8">.: Certificado Disponibilidad Presupuestal </td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='presu-principal.php'">Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:7%;">Vigencia:</td>
                    <td style="width:8%;"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia] ?>" style="width:90%;" readonly></td>
                    <td class="saludo1" style="width:7%;;">N&uacute;mero:</td>
                    <td style="width:8%;"><input name="numero" type="text" id="numero" value="<?php echo $_POST[numero] ?>" style="width:90%;" readonly></td>
                    <td  class="saludo1" style="width:2cm;">Fecha:</td>
                    <td colspan="1">
                        <input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10">&nbsp;<a onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"/></a>
                        <input type="hidden" name="chacuerdo" value="1">		  
                   </td>
                </tr>
                <tr>
                    <input type="hidden" value="1" name="oculto">
                    <td class="saludo1">Solicita:</td>
                    <td colspan="3" style="width:40%;"><input type="text" name="solicita" id="solicita" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[solicita]?>" style="width:96.5%;"/></td>
                    <td class="saludo1">Objeto:</td>
                    <td colspan="3"><input name="objeto" type="text" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[objeto]?>" style="width:100%;"/></td>
                </tr>
			</table>
            <input type="hidden" name="vigenciaini" value="<?php echo $_POST[vigenciaini] ?>">
            <input type="hidden" name="vigenciafin" value="<?php echo $_POST[vigenciafin] ?>">
            <table class="inicio">
                <tr><td colspan="8" class="titulos">Cuentas</td></tr>
                <tr>
                    <td class="saludo1" style="width:10%;"> Tipo de Gasto:</td>
                    <td> 
                        <select name="tipocuenta" id="tipocuenta" onKeyUp="return tabular(event,this)" onChange="validar()" >
                            <option value="2" <?php if($_POST[tipocuenta]=='2') echo "SELECTED"; ?>>Funcionamiento</option>
                            <option value="3" <?php if($_POST[tipocuenta]=='3') echo "SELECTED"; ?>>Deuda</option>
                            <option value="4" <?php if($_POST[tipocuenta]=='4') echo "SELECTED"; ?>>Inversion</option>
                        </select>
                    </td>
                </tr>
                <?php 
                    if($_POST[tipocuenta]==4)
                    {
						$sqln="SELECT nombre, orden FROM plannivelespd WHERE inicial='$_POST[vigenciaini]' AND final='$_POST[vigenciafin]' ORDER BY orden";
						$resn=mysql_query($sqln,$linkbd);
						$n=0; $j=0;
						while($wres=mysql_fetch_array($resn)){
							if (strcmp($wres[0],'INDICADORES')!=0){
								if($wres[1]==1) $buspad='';
								elseif($_POST[arrpad][($j-1)]!="")
									$buspad=$_POST[arrpad][($j-1)];
								else
									$buspad='';
								if($n==0){echo"<tr>";}
								echo"<td class='saludo1'>".strtoupper($wres[0])."</td>
								<td colspan='3'>
									<select name='niveles[$j]'  onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%;'>
										<option value=''>Seleccione....</option>";
										$sqlr="SELECT * FROM presuplandesarrollo WHERE padre='$buspad' AND vigencia='$_POST[vigenciaini]' AND vigenciaf='$_POST[vigenciafin]' ORDER BY codigo";
										$res=mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($res)) 
										{
											if($row[0]==$_POST[niveles][$j]){
												$_POST[arrpad][$j]=$row[0];
												$_POST[codmet]=$row[0];
												$_POST[nommet]=$row[1];
												echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
											}
											else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	 
										}	
									echo"</select>
									<input type='hidden' name='arrpad[$j]' value='".$_POST[arrpad][$j]."' >
									<input type='hidden' name='codmet' value='".$_POST[codmet]."' >
									<input type='hidden' name='nommet' value='".$_POST[nommet]."' >
								</td>";
								$n++;
								if($n>1){$n=0;echo"</tr>";}
								$j++;
							}
						}
                        /*echo"
                        <tr>
                            <td class='saludo1'>Eje:</td>
                            <td colspan='3'>
                                <select id='eje' name='eje'  onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%;'>
                                    <option value=''>Seleccione....</option>";
                        $sqlr="select * from presuplandesarrollo where padre='' order by codigo";
                        $res=mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($res)) 
                        {
                            echo "";
                            if(0==strcmp($row[0],$_POST[eje])){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                            else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                        }
                        echo"	 	
                                </select>
                            </td>
                            <td class='saludo1'>Sector:</td>
                            <td colspan='4'>
                                <select id='sector' name='sector'  onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%;'>
                                    <option value=''>Seleccione....</option>";
                        $sqlr="select * from presuplandesarrollo where padre='$_POST[eje]' order by codigo";
                        $res=mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($res)) 
                        {
                            if(0==strcmp($row[0],$_POST[sector])){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                            else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                        }
                        echo"	 	
                                </select>
                            </td>
                        </tr>	
                        <tr>
                            <td class='saludo1'>Programa:</td>
                            <td colspan='3'>
                                <select id='programa' name='programa'  onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%;'>
                                    <option value=''>Seleccione....</option>";
                        $sqlr="select *from presuplandesarrollo where padre='$_POST[sector]' order by codigo";
                        $res=mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($res)) 
                        {
                            if(0==strcmp($row[0],$_POST[programa])){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                            {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                        }
                        echo"	 	
                                </select>
                            </td>
                            <td class='saludo1'>Subprograma:</td>
                            <td colspan=4>
                                <select id='subprograma' name='subprograma' onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%;'>
                                <option value=''>Seleccione....</option>";
                        $sqlr="select *from presuplandesarrollo where padre='$_POST[programa]' order by codigo";
                        $res=mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($res)) 
                        {
                            if(0==strcmp($row[0],$_POST[subprograma])){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                            else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                        }	 	
                        echo"
                                </select>
                            </td>
                        </tr>	
                        <tr>
                            <td class='saludo1'>Meta:</td>
                            <td colspan='3'>
                                <select id='meta' name='meta' onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%;'>
                                    <option value=''>Seleccione....</option>";
                        $sqlr="select *from presuplandesarrollo where padre='$_POST[subprograma]' order by codigo";
                        $res=mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($res)) 
                        {
                            if(0==strcmp($row[0],$_POST[meta]))
                            {
                                echo "<option value='$row[0]' SELECTED>$row[0] - ".substr($row[1],0,80)."...</option>";	
                                $_POST[nmeta]=$row[1];				 
                             }
                            else {echo "<option value='$row[0]'>$row[0] - ".substr($row[1],0,80)."...</option>";	}	 	 
                        }	 	
                        echo"
                                </select>
                                <input type='hidden' name='nmeta' value='$_POST[nmeta]'>
                            </td>
                        </tr>";	  */
                    }// **** fin de if de inversion
                ?> 
                <tr>  
                    <td  class="saludo1">Cuenta:</td>
                    <td style="width:15%"><input type="text" id="cuenta" name="cuenta" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" style="width:80%;"/><input type="hidden" value="" name="bc" id="bc">&nbsp;<a onClick="despliegamodal2('visible');" title="Listado de Cuentas"/><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"></a></td>
                    <td colspan="2" style="width:30%"><input type="text" name="ncuenta" id="ncuenta"  value="<?php echo $_POST[ncuenta]?>" style="width:100%" readonly></td>
                    <td class="saludo1" style="width:8%;">Fuente:</td>
                    <td>
                        <input type="text" name="fuente" id="fuente" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fuente] ?>" style="width:83%;"  readonly>
                        <input type="hidden" name="cfuente" value="<?php echo $_POST[cfuente] ?>">
                    </td>
                </tr>
                <tr> 
                    <td class="saludo1">Valor:</td>
                    <td>
                        <input type="hidden" name="valor" id="valor" value="<?php echo $_POST[valor]?>" /> 
                        <input type="text" name="valorvl" id="valorvl" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos2('valor','valorvl');return tabular(event,this);" value="<?php echo $_POST[valorvl]; ?>" style='width:80%;text-align:right;' />
                    </td>		  
                    <td class="saludo1">Saldo:</td>
                    <td><input type="text" name="saldo"  id="saldo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" readonly>
                        <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
                        <input type="hidden" value="0" name="agregadet">
                    </td>
                </tr>  
            </table>
			<?php
                if(!$_POST[oculto]){echo"<script>document.form2.cuenta.focus();</script>";}
                //**** busca cuenta
                if($_POST[bc]!='')
                {
                    //$tipo=substr($_POST[cuenta],0,1);			 
                    $nresul=buscacuentapres($_POST[cuenta],2);
                    if($nresul!='')
                    {
                        $_POST[ncuenta]=$nresul;
                        echo"
                        <script>
                            document.getElementById('valorvl').focus();
                            document.getElementById('valorvl').select();
                        </script>";
                        $sqlr="select *from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or   vigenciaf=$vigusu)";
                        $res=mysql_query($sqlr,$linkbd);
                        $row=mysql_fetch_row($res);
                        $criterio="and (pptocuentas.vigencia=".$vigusu." or  pptocuentas.vigenciaf=$vigusu)";					  			  	
                        $vigenciai=$row[25];
                        $clasifica=$row[29];
                        $vsal=consultasaldo($_POST[cuenta],$vigenciai,$vigusu);
                        $_POST[saldo]=$vsal;
                        $ind=substr($_POST[cuenta],0,1);
                        //$reg=	substr($_POST[cuenta],0,1);					  	
                        $criterio="and (pptocuentas.vigencia=".$vigusu." or  pptocuentas.vigenciaf=$vigusu) ";
                        if ($clasifica=='funcionamiento')
                        {
                            $sqlr="select pptocuentas.futfuentefunc,pptocuentas.pptoinicial,pptofutfuentefunc.nombre from pptocuentas,pptofutfuentefunc where pptocuentas.cuenta='$_POST[cuenta]'  and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
                            $_POST[tipocuenta]=2;
                        }
                        if ($clasifica=='deuda' )
                        {
                            $sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
                            $_POST[tipocuenta]=3;
                        }
                        if ($clasifica=='inversion' )
                        {
                            $sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
                            $_POST[tipocuenta]=4;
                        }
                        //echo $sqlr." ".$clasifica;
                        $res=mysql_query($sqlr,$linkbd);
                        $row=mysql_fetch_row($res);
                        if($row[1]!='' || $row[1]!=0)
                        {
                            $_POST[cfuente]=$row[0];
                            $_POST[fuente]=$row[2];
                            $_POST[valor]=0;	
								  
                            //$_POST[saldo]=$row[1];			  
                        }
                        else
                        {
                            /*$_POST[cfuente]="";
                            $_POST[fuente]="";
                            $_POST[valor]="";			  
                            $_POST[saldo]="";
                            $_POST[cuenta]="";			  
                            $_POST[ncuenta]="";*/
                        }  
						if(strtoupper($row[2])=='MAYOR')
						{
							echo"
							<script>
								document.getElementById('valfocus').value='1';
								despliegamodalm('visible','2','El código pertenece a una cuenta Mayor');
							</script>";
						}
                    }
                    else
                    {
                        $_POST[ncuenta]="";
                        $_POST[fuente]="";
                        $_POST[valor]="";
                        echo "<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
                    }
                }
            ?>
            <div class="subpantallac2" style="height:60%; width:99.6%; overflow-x:hidden;">
                <table class="inicio" width="99%">
                <tr><td class="titulos" colspan="6">Detalle CDP</td></tr>
                <tr>
                    <td class="titulos2" style="width:8%">Cuenta</td>
                    <td class="titulos2" style="width:20%">Nombre Cuenta</td>
                    <td class="titulos2">Fuente</td>
                    <td class="titulos2" style="width:20%">Meta</td>
                    <td class="titulos2" style="width:12%">Valor</td>
                    <td class="titulos2" style="width:5%">Eliminar</td>
                </tr>
                <?php 
                    if ($_POST[oculto]=='3')
                    { 
                        $posi=$_POST[elimina];
                        //echo "<TR><TD>ENTROS :".$_POST[elimina]." $posi</TD></TR>";
                        $cuentagas=0;
                        $cuentaing=0;
                        $diferencia=0;
                        // array_splice($_POST[dcuentas],$posi, 1);
                        unset($_POST[dcuentas][$posi]);
                        unset($_POST[dncuentas][$posi]);
                        unset($_POST[dgastos][$posi]);		 		 		 		 		 
                        unset($_POST[dcfuentes][$posi]);		 		 
                        unset($_POST[dfuentes][$posi]);		 
                        unset($_POST[dmetas][$posi]);	
                        unset($_POST[dnmetas][$posi]);			 
                        $_POST[dcuentas]= array_values($_POST[dcuentas]); 
                        $_POST[dncuentas]= array_values($_POST[dncuentas]); 
                        $_POST[dgastos]= array_values($_POST[dgastos]); 
                        $_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
                        $_POST[dcfuentes]= array_values($_POST[dcfuentes]); 	
                        $_POST[dmetas]= array_values($_POST[dmetas]); 	
                        $_POST[dnmetas]= array_values($_POST[dnmetas]); 			 		 	 	
                        $_POST[elimina]='';	 		 		 		 
                    }	 
                    if ($_POST[agregadet]=='1')
                    {			
                        $ch=esta_en_array($_POST[dcuentas],$_POST[cuenta]);
                        if($ch!='1')
                        {			 
                            $cuentagas=0;
                            $cuentaing=0;
                            $diferencia=0;
                            $_POST[dcuentas][]=$_POST[cuenta];
                            $_POST[dncuentas][]=$_POST[ncuenta];
                            $_POST[dfuentes][]=$_POST[fuente];
                            $_POST[dcfuentes][]=$_POST[cfuente];		 
                            $_POST[valor]=$_POST[valor];
                            $_POST[dgastos][]=$_POST[valor];
                            $_POST[dmetas][]=$_POST[codmet];		 
                            $_POST[dnmetas][]=$_POST[nommet];		 		 
                            $_POST[agregadet]=0;
                            echo"
                                <script>
                                    document.form2.cuenta.value='';
                                    //document.form2.meta.value='';	
                                    //document.form2.nmeta.value='';								
                                    document.form2.ncuenta.value='';
                                    document.form2.fuente.value='';
                                    document.form2.cfuente.value='';
                                    document.form2.valor.value=0;
                                    document.form2.valorvl.value='';	
                                    document.form2.saldo.value='';			
                                    document.form2.cuenta.focus();	
                                </script>";
                        }
                        else {echo"<script>despliegamodalm('visible','2','Ya existe este Rubro en el CDP');</script>";}
                    }
                ?>
                <input type='hidden' name='elimina' id='elimina'>
                <?php
                    // echo "<TR><TD>t :".count($_POST[dcuentas])."</TD></TR>";
					$co="saludo1a";
		  			$co2="saludo2";
                    for ($x=0;$x<count($_POST[dcuentas]);$x++)
                    {
                        echo "
                        <input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
                        <input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
                        <input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'/>
                        <input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."'/>
                        <input type='hidden' name='dmetas[]' value='".$_POST[dmetas][$x]."'/>
                        <input type='hidden' name='dnmetas[]' value='".$_POST[dnmetas][$x]."'/>
                        <input type='hidden' name='dgastos[]' value='".$_POST[dgastos][$x]."'/>
                        <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
                            <td>".$_POST[dcuentas][$x]."</td>
                            <td>".$_POST[dncuentas][$x]."</td>
                            <td>".$_POST[dfuentes][$x]."</td>
                            <td>".$_POST[dnmetas][$x]."</td>
                            <td style='text-align:right;' onDblClick='llamarventana(this,$x)'>$ ".number_format($_POST[dgastos][$x],2,'.',',')."</td>
                            <td style='text-align:center;'><a style='cursor:pointer' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
                        </tr>";
						$aux=$co;
						$co=$co2;
		 				$co2=$aux;
                        //$cred= $vc[$x]*1;
                        $gas=$_POST[dgastos][$x];
                        //$cred=number_format($cred,2,".","");
                        //$deb=number_format($deb,2,".","");
                        $gas=$gas;
                        $cuentagas=$cuentagas+$gas;
                        $_POST[cuentagas2]=$cuentagas;
                        $total=number_format($total,2,",","");
                        $_POST[cuentagas]=number_format($cuentagas,2,".",",");
                        $resultado = convertir($_POST[cuentagas2]);
                        $_POST[letras]=$resultado." Pesos";
                    }
                    echo "
					<input type='hidden' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]'/>
					<input type='hidden' id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]'/>
					<input type='hidden' id='letras' name='letras' value='$_POST[letras]'/>
                    <tr class='$iter' style='text-align:right;'>
                        <td colspan='4'>Total:</td>
                        <td>$ $_POST[cuentagas]</td>
                    </tr>
                    <tr class='titulos2'>
						<td>Son:</td>
						<td colspan='5'>$resultado</td>
					</tr>";
                ?>
            	</table>
				<?php
                     //***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
                    $oculto=$_POST['oculto'];
                    if($_POST[oculto]=='2')
                    {
                        $scsolicita=eliminar_comillas($_POST[solicita]);
                        $scobjeto=eliminar_comillas($_POST[objeto]);
                        ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                        $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
                        $bloq=bloqueos($_SESSION[cedulausu],$fechaf);
                        if($bloq>=1)
                        {
                            $sqlr="select count(*) from pptocdp where vigencia='$_POST[vigencia]' and consvigencia=$_POST[numero]";
                            $res=mysql_query($sqlr,$linkbd);
                            while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
                            if($numerorecaudos==0)
                            {
                                $nr="1";	 	
                                //************** modificacion del presupuesto **************
                                $sqlr="insert into pptocdp (vigencia,consvigencia,fecha,valor,estado,solicita,objeto) values($_POST[vigencia],$_POST[numero], '$fechaf	',$_POST[cuentagas2],'S','$scsolicita','$scobjeto')";
                                if (!mysql_query($sqlr,$linkbd))
                                {
                                    $e =mysql_error(mysql_query($sqlr,$linkbd));
                                    echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: $e');</script>";
                                }
                                else
                                {
                                    $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($_POST[numero],6,'$fechaf	','$scsolicita - $scobjeto',$_POST[vigencia],$_POST[cuentagas2],$_POST[cuentagas2],0,1)";
                                    mysql_query($sqlr,$linkbd);
                                    for ($x=0;$x<count($_POST[dcuentas]);$x++)
                                    {
                                        //$sqlr="update pptocuentaspptoinicial set saldos=saldos-".$_POST[dgastos][$x]." where cuenta='".$_POST[dcuentas][$x]."' and (vigencia=$vigusu or vigenciaf=$vigusu)";
                                        //$res=mysql_query($sqlr,$linkbd); 
                                        $sqlr="insert into pptocdp_detalle (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado) values('$_POST[vigencia]','$_POST[numero]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0)";
                                        $res=mysql_query($sqlr,$linkbd);
                                        $sqlr="insert into presucdpplandesarrollo (id_cdp,vigencia,codigo_meta,fecha,tipogasto,rubro) values($_POST[numero],$_POST[vigencia],'".$_POST[dmetas][$x]."','$fechaf',$_POST[tipocuenta],'".$_POST[dcuentas][$x]."')";
                                        mysql_query($sqlr,$linkbd);  
                                        //****crea comprobante presupuesto  cdp
                                        $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$_POST[dcuentas][$x]."','','".$_POST[dfuentes][$x]."',".$_POST[dgastos][$x].",0,1,'$_POST[vigencia]',6,'$_POST[numero]')";
                                        mysql_query($sqlr,$linkbd); 
                                        //****modifica el comprobante ppto inicial ******
                                        // $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$_POST[dcuentas][$x]."','','Disponibilidad $_POST[numero] Vigencia $_POST[vigencia]',0,".$_POST[dgastos][$x].",1,'$_POST[vigencia]',1,'$_POST[vigencia]')";
                                        // mysql_query($sqlr,$linkbd);
                                        echo "<script>despliegamodalm('visible','1','Se ha almacenado el CDP con Exito');</script>";
                                    }
                                }	
                            }
                            else{echo"<script>despliegamodalm('visible','2','Ya Existe un CDP con este Numero');</script>";}
                        }
                        else
                        {echo"<script>despliegamodalm('visible','2',' No Tiene los Permisos para Modificar este Documento');</script>";
                    }
                 }//*** if de control de guardado
            ?> 
    </div>
    <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
</form>
</body>
</html>