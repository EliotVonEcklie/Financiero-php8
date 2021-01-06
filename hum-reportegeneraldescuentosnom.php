<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
        <title>:: SPID - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script src="css/funciones.js"></script>
		<script>
			function despliegamodal2(_valor,_pag)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_pag=="1"){document.getElementById('ventana2').src="hum-nnomina2.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta, variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('docum').focus();
									document.getElementById('docum').select();
									break;
					}		
					document.getElementById('valfocus').value='0';
				}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
						case "5":	document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();
								break;
					case "2":	document.form2.elimina.value=variable;
								vvend=document.getElementById('elimina');
								vvend.value=variable;
								document.form2.sw.value=document.getElementById('tipomov').value ;
								document.form2.submit();
								break;
				}
			}
			function funcionmensaje(){}
			function validar(){document.form2.oculto.value=2;document.form2.submit();}
			function pdf(idnomp,mesp,vigenp,tercerop,totalpagop,diaslabp,salbasicp,auxalimp,auxtranp,devenp,horaxp,saludp,pensionp,fondosp,retep)
			{
				
				document.form2.action="pdfdescnomina.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function pdf2(){
				document.form2.action="hum-reportegeneraldescuentospdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excel(){
				document.form2.action="hum-reportegeneraldescuentosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/buscad.png" class="mgbt1"/><img src="imagenes/nv.png" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt" title="Nueva Ventana"/><img src='imagenes/print.png' title='Imprimir' onClick='pdf2();' class="mgbt" /><img src="imagenes/excel.png"  title="Excel"  onClick='excel();' class="mgbt"/></td>
			</tr>		  
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
    			<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
       			 </IFRAME>
   			</div>
		</div>		  
        <form name="form2" method="post" action="">
			<?php
                if(!$_POST[oculto])
                {
    
                }
				$listanomina=array();
				$listames=array();
				$listavigencia=array();
				$listadocumento=array();
				$listafuncionario=array();
				$listanomdescuento=array();
				$listavaldescuento=array();
           ?>
          
			
		   </style>
			<table class="inicio">
                <tr>
                    <td colspan="8" class="titulos">Descuentos de Nomina</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
                </tr>                  
				<tr>
                    <td class="saludo1" style='width:7%'> N&deg; N&oacute;mina:</td>
                    <td width="7%">
                        <input type="text" id="nnomina" name="nnomina" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[nnomina]?>" style='width:60%'/>&nbsp;<img src="imagenes/find02.png" class="icobut" onClick="despliegamodal2('visible','1');" title="Listado de Nominas"/>
                    </td>
                    <td class="saludo1" style='width:5%'>Vigencia:</td>
                    <td style='width:5%'><input type="text" name="vigencias" id="vigencias" style="width:80%" value="<?php echo $_POST[vigencias] ?>" ></td>
                    <td class="saludo1" style='width:3%'>Mes:</td>
                    <td style='width:8%'>
                    	<select name="periodo" id="periodo" onChange="validar()" style="width:100%">
				  			<option value="-1">Seleccione ....</option>
							<?php
					 			$sqlr="Select * from meses where estado='S' ";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[periodo]) {echo "<option value='$row[0]' SELECTED>$row[1]</option>";}
									else {echo "<option value='$row[0]'>$row[1]</option>";}
			     				}   
							?>
		  				</select>
                    </td>
                    <td >&nbsp;<input type="button" name="buscar" value="Buscar " onClick="validar()"></td>
				</tr>
			</table>  
            <input name="oculto" id="oculto" type="hidden" value="1"> 
			<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
				<?php
                    echo "
                    <table class='inicio'>
                        <tr><td colspan='10' class='titulos'>Nominas Liquidadas</td></tr>
                        <tr>
                            <td class='titulos2' style='width:5%;'>No N&oacute;mina</td>
                            <td class='titulos2' style='width:8%;'>Mes</td>
                            <td class='titulos2' style='width:5%;'>Vigencia</td>
                            <td class='titulos2' style='width:10%;'>Documento</td>
                            <td class='titulos2'>Funcionario</td>
                            <td class='titulos2'>Nombre Descuento</td>	
                            <td class='titulos2' style='width:10%;'>Valor Descuentos</td>
                        </tr>";
					if($_POST[nnomina]!=""){$rest1="AND id_nom='$_POST[nnomina]' ";}
					else {$rest1="";}
					if($_POST[vigencias]!=""){$rest2="AND YEAR(fecha)='$_POST[vigencias]' ";}
					else {$rest2="";}
					if($_POST[periodo]!="-1" && $_POST[periodo]!="" ){$rest3="AND MONTH(fecha)='$_POST[periodo]' ";}
					else {$rest3="";}
                    $sqlr="SELECT id_nom,MONTH(fecha),YEAR(fecha),descripcion,cedulanit,valor FROM humnominaretenemp WHERE estado='P' $rest1 $rest2 $rest3 ORDER BY id_nom DESC, cedulanit DESC";
                    $resp = mysql_query($sqlr,$linkbd);
                    $co="saludo1a";
                    $co2="saludo2";
                    while ($row =mysql_fetch_row($resp))
                    {
                        $nomfun=buscatercero($row[4]);
                        $mesl=mesletras($row[1]);
						$listanomina[]=$row[0];
						$listames[]=$mesl;
						$listavigencia[]=$row[2];
						$listadocumento[]=$row[4];
						$listafuncionario[]=$nomfun;
						$listanomdescuento[]=$row[3];
						$listavaldescuento[]=$row[5];
                        echo "
                        <tr class='$co' >
                            <td style='text-align:right;'>$row[0]&nbsp;&nbsp;</td>
                            <td style='text-transform:uppercase'>&nbsp;$mesl</td>
                            <td>$row[2]</td>
                            <td>$row[4]</td>
                            <td>$nomfun</td>
                            <td>$row[3]</td>
                            <td style='text-align:right;'>$ ".number_format($row[5],2,",",".")."</td>
                        </tr>";
                        $aux=$co;
                        $co=$co2;
                        $co2=$aux;
                    }
                    echo "
						<tr>
						 <td style='text-align:right;' colspan='6'>TOTAL:</td>
						 <td style='text-align:right;'>$ ".number_format(array_sum($listavaldescuento),2,",",".")."</td>

						</tr>
					</table>
					<input type='hidden' name='lista_nominas' value='".serialize($listanomina)."'/>
					<input type='hidden' name='lista_meses' value='".serialize($listames)."'/>
					<input type='hidden' name='lista_vigencias' value='".serialize($listavigencia)."'/>
					<input type='hidden' name='lista_documentos' value='".serialize($listadocumento)."'/>
					<input type='hidden' name='lista_funcionarios' value='".serialize($listafuncionario)."'/>
					<input type='hidden' name='lista_nomdescuentos' value='".serialize($listanomdescuento)."'/>
					<input type='hidden' name='lista_valdescuentos' value='".serialize($listavaldescuento)."'/>";
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