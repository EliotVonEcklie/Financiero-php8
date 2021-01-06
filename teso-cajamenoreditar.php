<?php //V 1000 12/12/16 ?> 
<?php
  	require "comun.inc";
  	require "funciones.inc";
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
		<title>:: Spid - Tesoreria</title>
      	<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script src="JQuery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
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
		  left: 0 !important; top: 2 !important;
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
			function despliegamodal2(_valor,_pag)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_pag=="1"){document.getElementById('ventana2').src="inve-greservas-articulos.php";}
				else {document.getElementById('ventana2').src="inve-greservas-cuentas.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('articulo').focus();
									document.getElementById('articulo').select();
									break;
						case "2":	document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();
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
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":	document.getElementById('oculto').value="3";
								document.form2.submit();break;
				}
			}
			function funcionmensaje(){document.form2.oculto.value='';document.form2.submit();}
			function guardar()
			{
				valg01=document.form2.codigo.value;
				valg02=document.form2.fecha.value;
				valg03=document.form2.objeto.value;
				if (valg01!='' && valg02!='' && valg03!=0)
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function guiabuscar(_opc)
			{
				if(_opc==1){if(document.getElementById('articulo').value!=""){document.getElementById('busqueda').value='1';}}
				else{if(document.getElementById('cuenta').value!=""){document.getElementById('busqueda').value='2';}}
				document.form2.submit();
			}
			function agregardetalle()
			{
				val01=document.getElementById('tercero').value;
				val02=document.getElementById('detalle').value;
				val03=document.getElementById('cc').value;
                val04=document.getElementById('valor').value;
                val05=document.getElementById('cuenta').value;
				if(val01!="" && val02!="" && val03!="" && val04!="" && val05!=""){document.form2.agregadet.value=1;document.form2.submit();}
			 	else {despliegamodalm('visible','2','Falta informacion para poder Agregar Detalle de Modalidad');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function validar(_opc){document.form2.submit();}
			function limpiar()
			{
				document.getElementById('articulo').value='';
				document.getElementById('narticulo').value='';
				document.getElementById('nbodega').value='';
				document.getElementById('nreserva').value='';
				document.getElementById('nreservav').value='';
				document.getElementById('cuenta').value='';
				document.getElementById('ncuenta').value='';
				document.getElementById('cc').value='';
				document.getElementById('umedida').value='';
			}
            function iratras()
			{
				var idcta=document.getElementById('codigo').value;
				var inicio=document.getElementById('fechaini').value;
				var fin=document.getElementById('fechafin').value;
                
				location.href="teso-buscacajamenor.php?filtro="+idcta+"&fini="+inicio+"&ffin="+fin;
			}
			jQuery(function($){ $('#nreservav').autoNumeric('init',{mDec:'0'});});
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-contabilizacajamenor.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='teso-buscacajamenor.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("teso");?>" class="mgbt">
                <a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
                </td>
			</tr>
         </table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		  
 		<form name="form2" method="post" action="teso-cajamenoreditar.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
        	<?php
            
                if(!$_POST[oculto])
                {
                    $fech1=split("/",$_GET[fini]);
					$fech2=split("/",$_GET[ffin]);
					$_POST[fechaini]=$fech1[2]."-".$fech1[1]."-".$fech1[0];
					$_POST[fechafin]=$fech2[2]."-".$fech2[1]."-".$fech2[0];
                    $sqlr="select * from tesocontabilizacajamenor ORDER BY id_cajamenor DESC";
                    $res=mysql_query($sqlr,$linkbd);
                    $r=mysql_fetch_row($res);
                    $_POST[maximo]=$r[0];
                    if ($_GET[idop]!="")
                    {
						$sqlr="select * from tesocontabilizacajamenor where id_cajamenor='$_GET[idop]' ";
                    }
                    else{$sqlr="select * from tesocontabilizacajamenor ORDER BY id_cajamenor DESC";}
                    $res=mysql_query($sqlr,$linkbd);
                    $r=mysql_fetch_row($res);
                    $_POST[ncomp]=$r[0];
                    $_POST[codigo]=$r[0];			
                    $check1="checked"; 
                }
                $sqlr="select * from tesocontabilizacajamenor where id_cajamenor=".$_POST[ncomp]." ";
                $res=mysql_query($sqlr,$linkbd);
                $consec=0;
                while($r=mysql_fetch_row($res))
                {
                    $_POST[fecha]=$r[2];
                    $consec=$r[0];
                    $_POST[estado]=$r[4];
                    $_POST[objeto]=$r[1];
                    $_POST[finaliza]=$r[5];
                    $_POST[atercero]=array();
  	  				$_POST[adetalle]=array();
	  				$_POST[acc]=array();
                    $_POST[avalor]=array();
                    $_POST[acuenta]=array();
                    
	  				$sqlr="select * from tesocontabilizacajamenor_det where id_cajamenor=$_POST[codigo]";
	  				$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
	 				{	  
	 					$_POST[atercero][]=$r[2];
	 					$_POST[adetalle][]=$r[3];
	   					$_POST[acc][]=$r[4];
                        $_POST[avalor][]=$r[5];
                        $_POST[acuenta][]=$r[6];
                    }
                    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
                    $fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
                    $_POST[fecha]=$fechaf;
                }
                
			?>
    		<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="9">.: Contabilizaci&oacute;n de reintegro caja menor</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='inve-principal.php'">Cerrar</td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:10%;">.: C&oacute;digo Caja Menor:</td>
                    <td style="width:9%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:100%;" readonly/></td>
                    <td class="saludo1" style="width:12%;">.: Fecha:</td>
                    <td style="width:8%;"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width: 70%">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut"/><input type="hidden" name="chacuerdo" value="1"></td>
                    <td style="width:12%;" class="saludo1">.: Tercero:</td>
                    <td style="width:14%;">
                        <input id="tercero" type="text" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" >
                        <input type="hidden" value="0" name="bt">
                            <a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();">
                                <img src="imagenes/buscarep.png" align="absmiddle" border="0">
                            </a>
                    </td>
                    <td colspan="3">
                        <input  id="ntercero" style="width:100.5%;"  name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>"  readonly>
                        <input type="hidden" name="fechaini" id="fechaini" value="<?php echo $_GET[fini]; ?>" />
 			            <input type="hidden" name="fechafin" id="fechafin" value="<?php echo $_GET[ffin]; ?>" />
                    </td>
      			</tr>
                <tr>
                    <td style="width:11%;" class="saludo1">.: Objeto:</td>
                    <td colspan="3">
                        <input type="text" id="objeto" name="objeto" placeholder="Detalle cabecera" style="width:100.45%;" value="<?php echo $_POST[objeto]?>" readonly>
                    </td>
                    <td class="saludo1">.: Detalle Orden de Pago:</td>
                    <td colspan="4">
                        <input type="text" id="detalle" name="detalle" placeholder="Descripcion del gasto" style="width:100.45%;" value="<?php echo $_POST[detalle]?>">
                    </td>
                </tr>
  				<tr>
                    <td class="saludo1" >.: Valor:</td>
                    <td >
                    	<input type="hidden" name="nreserva" id="nreserva" value="<?php echo $_POST[nreserva]?>"/>
                        <input type="number" name="valor" id="valor" value="<?php echo $_POST[valor]?>" style="width:100%;text-align:right;" data-a-dec=',' data-a-sep='.' data-v-min='0' />
                    </td>
   					<td class="saludo1">.: Conceptos Contables:</td>
                    <td>
                    	<select id="cuenta" name="cuenta" onChange="validar()" style="width:100%">
                    		<option value="">Seleccione...</option>
							<?php
								$sqlm="SELECT * FROM conceptoscontables WHERE almacen='S' and tipo='C' and modulo='3' ORDER BY codigo";
								$resm=mysql_query($sqlm,$linkbd);
								while($rowm=mysql_fetch_array($resm))
								{
									if("$rowm[0]"==$_POST[cuenta])
									{
										$_POST[ncuenta]=$rowm[1];
										echo "<option value='$rowm[0]' style='text-transform:uppercase' SELECTED>$rowm[0] - $rowm[1]</option>";										
									}
									else {
										echo "<option value='$rowm[0]' style='text-transform:uppercase'>$rowm[0] - $rowm[1]</option>";
									}
								}
							?>
                    	</select>
               			<input type="hidden" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>" >
                    </td>
                    <td style="width:11%;" class="saludo1">Centro Costo:</td>
                    <td style="width:15%;">
                            <select name="cc" id="cc" onChange="validar()" style="width:90%;" onKeyUp="return tabular(event,this)" >
                            <?php
                                $linkbd=conectar_bd();
                                $sqlr="select *from centrocosto where estado='S'";
                                $res=mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($res)) 
                                {
                                    echo "<option value=$row[0] ";
                                    $i=$row[0];
                                    if($i==$_POST[cc])
                                    {
                                        echo "SELECTED";
                                    }
                                    echo ">".$row[0]." - ".$row[1]."</option>";	 	 
                                }	 	
                            ?>
                        </select>
                    </td>
                    <td >
                        <em class="botonflecha" onClick="agregardetalle()">agregar detalle</em>
                    </td>
                    <td class="saludo1" style="width:7%">Liberar:</td>
                    <td>
                        <div class="c1"><input type="checkbox" id="finaliza" name="finaliza" <?php if($_POST['finaliza']!='0' && !empty($_POST['finaliza'])){echo "checked disabled";} ?> <?php echo $_POST[finfasblo];?> /><label for="finaliza" id="t1" ></label></div>								
                    </td>  
                </tr>
            </table>
    		<input type="hidden" name="oculto" id="oculto" value="1"> 
            <input type="hidden" name="agregadet" id="agregadet" value="0" >
            <input type="hidden" name="busqueda" id="busqueda" value=""> 
            <input type='hidden' name='elimina' id='elimina'>
            <div class="subpantalla" style="height:50%; width:99.6%; overflow-x:hidden;">
				<table class='inicio'>
                    <tr><td class='titulos' colspan='9'>Detalles del Comprobante</td></tr>
                    <tr class='titulos2'>
                        <td style="width:8%;">Tercero</td>
                        <td >Detalle</td>
                        <td style="width:5%;">Centro costo</td>
						<td style="width:5%;">Valor</td>
						<td style="width:8%;">Cod. Cuenta</td>
                        <td style="width:4%;">Eliminar</td>
                    </tr>
             		<?php
						if ($_POST[oculto]=='3')
						{ 
							$posi=$_POST[elimina];
							unset($_POST[atercero][$posi]);
							unset($_POST[adetalle][$posi]);
							unset($_POST[acc][$posi]);
							unset($_POST[avalor][$posi]);
							unset($_POST[acuenta][$posi]);
							$_POST[atercero]= array_values($_POST[atercero]); 
							$_POST[adetalle]= array_values($_POST[adetalle]); 
							$_POST[acc]= array_values($_POST[acc]); 		 		 
							$_POST[avalor]= array_values($_POST[avalor]); 
							$_POST[acuenta]= array_values($_POST[acuenta]); 
						}
						if ($_POST[agregadet]=='1')
						{
							$_POST[atercero][]=$_POST[tercero];
							$_POST[adetalle][]=$_POST[detalle];
							$_POST[acc][]=$_POST[cc]; 
							$_POST[avalor][]=$_POST[valor];
							$_POST[acuenta][]=$_POST[cuenta];
							$_POST[agregadet]=0;
                            echo "<script>
                                        document.getElementById('tercero').value='';
                                        document.getElementById('ntercero').value='';
                                        document.getElementById('detalle').value='';
                                        document.getElementById('cuenta').value='';
                                        document.getElementById('valor').value='';
                                    </script>";
							
						}
						$iter='saludo1a';
						$iter2='saludo2';
						$_POST[total]=0;
						for ($x=0;$x<count($_POST[atercero]);$x++)
						{
							echo "
							<input type='hidden' name='atercero[]' value='".$_POST[atercero][$x]."'/>
							<input type='hidden' name='adetalle[]' value='".$_POST[adetalle][$x]."'/>
							<input type='hidden' name='acc[]' value='".$_POST[acc][$x]."'/>
							<input type='hidden' name='avalor[]' value='".$_POST[avalor][$x]."'/>
							<input type='hidden' name='acuenta[]' value='".$_POST[acuenta][$x]."'/>
							<input type='hidden' name='agncue[]' value='".$_POST[agncue][$x]."'/>
							<input type='hidden' name='aguni[]' value='".$_POST[aguni][$x]."'/>
							<input type='hidden' name='agfact[]' value='".$_POST[agfact][$x]."'/>
							<input type='hidden' name='agncc[]' value='".$_POST[agncc][$x]."'/>
							<tr class='$iter'>
								<td>".$_POST[atercero][$x]."</td>
								<td>".$_POST[adetalle][$x]."</td>
								<td>".$_POST[acc][$x]."</td>
								<td style='text-align:right;'>".$_POST[avalor][$x]."</td>
								<td style='text-align:right;'>".$_POST[acuenta][$x]."</td>
								<td class='icobut' style='text-align:center;'><img src='imagenes/del.png' onclick='eliminar($x)'></td>
                            </tr>";
                            $_POST[total]+=$_POST[avalor][$x];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							
                        }
                        
					?>
                </table>
                
            </div>
                <table class='inicio'>
                    <tr class='titulos2'>
                        <td style="width:82%;"></td>
                        <?php echo "<td style='width:8%;'>$ $_POST[total]</td>" ;?>
                        <td style="width:10%;"></td>
                    </tr>
                </table>
              <?php	
				if($_POST[oculto]=="2")
				{
                    $sqlrCajaMenor = "select cuentacajamenor from tesoparametros";
                    $resCajaMenor=mysql_query($sqlrCajaMenor,$linkbd);
                    $rowCajaMenor=mysql_fetch_row($resCajaMenor);
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                    $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
                    $vigencia = $fecha[3];
                    $bloq=bloqueos($_SESSION[cedulausu],$fechaf);
                    if($bloq>=1)
                    {
                        //$sqlr = "INSERT INTO tesocontabilizacajamenor (id_cajamenor,objeto,fecha,valor,estado) VALUES ($_POST[codigo],'$_POST[objeto]','$fechaf',$_POST[total],'1')";
                        //if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error no se almaceno en tesocontabilizacajamenor');</script>";}
                        if($_POST[finaliza]==on)
                            $final = 1;
                        else
                            $final = 0;
                        $sqlr = "UPDATE tesocontabilizacajamenor SET valor=$_POST[total], finaliza=$final WHERE id_cajamenor=$_POST[codigo]";
                        mysql_query($sqlr,$linkbd);
                        $sqlr = "DELETE FROM tesocontabilizacajamenor_det WHERE id_cajamenor=$_POST[codigo]";
                        mysql_query($sqlr,$linkbd);
                        $sqlr = "DELETE FROM comprobante_det WHERE numerotipo=$_POST[codigo] AND tipo_comp=36";
                        mysql_query($sqlr,$linkbd);
                        for($x=0;$x<count($_POST[atercero]);$x++)
                        {
                            $sqlr = "INSERT INTO tesocontabilizacajamenor_det (id_cajamenor,tercero,detalle,cc,valor,conceptocontable,estado) VALUES ($_POST[codigo],'".$_POST[atercero][$x]."','".$_POST[adetalle][$x]."','".$_POST[acc][$x]."','".$_POST[avalor][$x]."','".$_POST[acuenta][$x]."','1')";
                            if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error no se almaceno en tesocontabilizacajamenor_det');</script>";$cont=$cont+1;}
                            else
                            {
								//echo $_POST[acuenta][$x]." ->> ".$_POST[acc][$x]." ---- ".$fechaf."<br>";
                                $cuentas=concepto_cuentas($_POST[acuenta][$x],'C',3,$_POST[acc][$x],$fechaf);
                                $tam=count($cuentas);
                                for($cta=0;$cta<$tam;$cta++)
                                {
                                    $ctacon=$cuentas[$cta][0];
                                    if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
                                    {
										$ncuent=buscacuenta($ctacon);
																	  
                                        if ($_POST[avalor][$x]>0 && $ncuent!='')
                                        {
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('36 $_POST[codigo]','".$ctacon."','".$_POST[atercero][$x]."','".$_POST[acc][$x]."','".$_POST[adetalle][$x]."','','".$_POST[avalor][$x]."',0,'1','".$vigencia."')";
											//echo $sqlr."<br>";	
                                            mysql_query($sqlr,$linkbd);
                                        }
                                    }
                                }
                                $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('36 $_POST[codigo]','$rowCajaMenor[0]','".$_POST[atercero][$x]."','".$_POST[acc][$x]."','".$_POST[adetalle][$x]."','',0,'".$_POST[avalor][$x]."','1','".$vigencia."')";
                                mysql_query($sqlr,$linkbd);
                            }
                        }
                        if ($cont!=0){echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";}
						else {//echo"<script>despliegamodalm('visible','1','Se almaceno el comprobante con exito');</script>";
						} 
                        
                    }
                    else
                    {
                        echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
                    }
				}
			?>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
            <input type="hidden" name="conarticulos" id="conarticulos" value="<?php echo $_POST[conarticulos];?>"> 
 		</form>
	</body>
</html>