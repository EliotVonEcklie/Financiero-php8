<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET[scrtop];
	$totreg=$_GET[totreg];
	$idcta=$_GET[idcta];
	$altura=$_GET[altura];
	$filtro="'$_GET[filtro]'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gesti&oacute;n Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <style>
			.swfun
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swfun-checkbox {display: none;}
			.swfun-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swfun-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swfun-inner:before, .swfun-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swfun-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swfun-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swfun-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swfun-checkbox:checked + .swfun-label .swfun-inner {margin-left: 0;}
			.swfun-checkbox:checked + .swfun-label .swfun-switch {right: 0px;}
		</style>
        <script>
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '0':	document.getElementById('ventana2').src="cargosadministrativos-ventana01.php";break;
						case '1':	document.getElementById('ventana2').src="tercerosgral-ventana04.php?objeto=tercero&nobjeto=ntercero&nfoco=tercero&valsub=SI"; break;
						case '2':	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=eps&nobjeto=neps&nfoco=arp";break;
						case "3":	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=arp&nobjeto=narp&nfoco=afp";break;
						case "4":	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=afp&nobjeto=nafp&nfoco=fondocesa";break;
						case "5":	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=fondocesa&nobjeto=nfondocesa&nfoco=cargo";break;
						case "6":	document.getElementById('ventana2').src="nivelsalarial-ventana01.php";break;
					}
				}
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
			function funcionmensaje()
			{
				var _cons=document.getElementById('egreso').value;
				document.location.href = "teso-girarchequesver.php?idegre="+_cons+"&scrtop=0&numpag=1&limreg=10&filtro1=&filtro2=";
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value='2';document.form2.submit();break;
				}
			}
			function validar(){document.form2.submit();}
			function buscar(_num)
			{
				switch(_num)
				{
					case "1":	
						var validacion01=document.getElementById('tercero').value;
						if (validacion01.trim()!='')
						{
							document.getElementById('vbuscar').value="1";
							document.form2.submit();
							break;
						}
						else
						{
							document.getElementById('ntercero').value=""
							document.getElementById('direccion').value="";
							document.getElementById('telefono').value="";
							document.getElementById('celular').value="";
							document.getElementById('email').value="";
							break;
						}
				}
			}
			function guardar()
			{
				if ((document.form2.fechain.value!='' && existeFecha(document.form2.fechain.value))  && (document.form2.fechaeps.value!='' && existeFecha(document.form2.fechaeps.value)) && (document.form2.fechaarl.value!='' && existeFecha(document.form2.fechaarl.value)) && document.form2.nomcargoad.value!='' && document.form2.ntercero.value!=''  && document.form2.neps.value!='' && document.form2.narp.value!='' && document.form2.nivsal.value!='' && document.form2.numcc.value!='')
				{despliegamodalm('visible','4','Esta Seguro de modificar el funcionario','1');}
  				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function cambiocheck()
			{	
				if(document.getElementById('idswfun').value=='S'){document.getElementById('idswfun').value='N';}
				else{document.getElementById('idswfun').value='S';}
				document.form2.submit();
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{alert();
				var idcta=document.form2.idfun.value;
				location.href="hum-funcionariosbuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-funcionarios.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-funcionariosbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras(<?php echo "'$scrtop','$numpag','$limreg','$filtro'"; ?>)" class="mgbt"></td>
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
				if ($_POST[oculto]=="")
				{
					$_POST[fechamodi]=date('Y-m-d');
					$_POST[idfun]=$_GET[idfun];
					$sqlr="
					SELECT GROUP_CONCAT(descripcion ORDER BY valor SEPARATOR '<->'),
					GROUP_CONCAT(fechain ORDER BY valor SEPARATOR '<->'),
					GROUP_CONCAT(codrad ORDER BY valor SEPARATOR '<->')
					FROM hum_funcionarios
					WHERE codfun='$_POST[idfun]' AND estado='S'
					GROUP BY codfun
					ORDER BY valor";
   					$resp = mysql_query($sqlr,$linkbd);
  					$row =mysql_fetch_row($resp);
    				$datos = explode('<->', $row[0]);
					$fechas= explode('<->', $row[1]);
					$_POST[basdatos]=$row[0];
					$_POST[basfechas]=$row[1];
					$_POST[basids]=$row[2];
					$_POST[fechain]=date('d/m/Y',strtotime($fechas[25]));
					$_POST[nomcargoad]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$datos[1]);
					$_POST[idcargoad]=$datos[0];
					$_POST[tercero]=$datos[5];
					$_POST[ntercero]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$datos[6]);
					$_POST[direccion]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$datos[7]);
					$_POST[telefono]=$datos[8];
					$_POST[celular]=$datos[9];
					$_POST[email]=$datos[10];
					$_POST[tercerocta]=$datos[11];
					$_POST[bancocta]=$datos[12];
					$_POST[eps]=$datos[13];
					$_POST[neps]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$datos[14]);
					$_POST[fechaeps]=date('d/m/Y',strtotime($fechas[13]));
					$_POST[arp]=$datos[15];
					$_POST[narp]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$datos[16]);
					$_POST[fechaarl]=date('d/m/Y',strtotime($fechas[15]));
					$_POST[afp]=$datos[17];
					$_POST[nafp]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$datos[18]);
					$_POST[fechaafp]=date('d/m/Y',strtotime($fechas[17]));
					$_POST[fondocesa]=$datos[19];
					$_POST[nfondocesa]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$datos[20]);
					$_POST[fechafdc]=date('d/m/Y',strtotime($fechas[19]));
					$_POST[cargo]=$datos[2];
					$_POST[nivsal]=$datos[3];
					$_POST[asigbas2]="$ ".number_format($datos[4], 0, ',', '.');
					$_POST[asigbas]=$datos[4];
					$_POST[tperiodo]=$datos[23];
					$_POST[numcc]=$datos[21];
					$_POST[nomcc]=$datos[22];
					$_POST[pagces]=$datos[24];
					$_POST[swfun]=$datos[25];
					$_POST[nivelarl]=$datos[26];
					$sqlr="SELECT id_tercero FROM terceros where cedulanit='$datos[5]' AND estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$_POST[idterc]=$r[0];
				}
				
				if ($_POST[vbuscar]=="1")
				{
					$sqlr="SELECT nombre1,nombre2,apellido1,apellido2,direccion,telefono,celular,email,id_tercero FROM terceros where cedulanit='$_POST[tercero]' AND estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{
						if ($r[3]!="" && $r[1]!=""){$_POST[ntercero]="$r[2] $r[3] $r[0] $r[1]";}
						elseif($r[3]!=""){$_POST[ntercero]="$r[2] $r[3] $r[0]";}
						elseif($r[1]!=""){$_POST[ntercero]="$r[2] $r[0] $r[1]";}
						else {$_POST[ntercero]="$r[2] $r[0]";}
						if($r[4]!=""){$_POST[direccion]=$r[4];}
						else {$_POST[direccion]="SIN DIRECCION DIGITADA";}
						if($r[5]!=""){$_POST[telefono]=$r[5];}
						else{$_POST[telefono]="SIN NUMERO TELEFONICO";}
						if($r[6]!=""){$_POST[celular]=$r[6];}
						else{$_POST[celular]="SIN NUMERO CELULAR";}
						if($r[7]!=""){$_POST[email]=$r[7];}
						else{$_POST[email]="SIN CORREO ELECTRONICO";}
						$_POST[idterc]=$r[8];
					}
					$sqlr00="SELECT T1.codcargo,T1.nombrecargo,T1.clasificacion FROM planaccargos T1, planestructura_terceros T2  WHERE T1.estado = 'S' AND T1.codcargo=T2.codcargo AND T2.cedulanit='$_POST[tercero]' AND T1.estado='S' AND T2.estado='S'";
					$resp00 = mysql_query($sqlr00,$linkbd);
					$row00=mysql_fetch_row($resp00);
					$sqlr01="SELECT nombre,valor FROM humnivelsalarial WHERE id_nivel='$row00[2]'";
					$resp01 = mysql_query($sqlr01,$linkbd);
					$row01=mysql_fetch_row($resp01);
					$_POST[idcargoad]=$row00[0];
					$_POST[nomcargoad]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row00[1]);
					$_POST[cargo]=$row00[2];
					$_POST[nivsal]=$row01[0];
					$_POST[asigbas]=$row01[1];
					$_POST[asigbas2]="$ ".number_format($row01[1], 0, ',', '.');
				}
			?>
        	<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="7">.: Ingresar Funcionario Nuevo</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
      			</tr>
                <tr>
                	<td class="saludo1" >.: Id Funcionario:</td>
                    <td><input type="text" name="idfun" id="idfun" value="<?php echo $_POST[idfun];?>" readonly/></td>
                    <td class="saludo1" >Funcionario Activo:</td>
        			<td>
                    	<div class="swfun">
                            <input type="checkbox" name="swfun" class="swfun-checkbox" id="idswfun" value="<?php echo $_POST[swfun];?>" <?php if($_POST[swfun]=='S'){echo "checked";}?> onChange="cambiocheck();"/>
                            <label class="swfun-label" for="idswfun">
                                <span class="swfun-inner"></span>
                                <span class="swfun-switch"></span>
                            </label>
                        </div>
           			</td>
                </tr>
                <tr>
                	<td class="saludo1" style="width:3cm;">.: Fecha Ingreso:</td>
        			<td><input type="text" name="fechain" id="fc_1198971547" value="<?php echo $_POST[fechain]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971547');" class="icobut" title="Calendario"/></td>
                	<td class="saludo1">.: Cargo:</td>
                    <td colspan="2"><input type="text" name="nomcargoad" id="nomcargoad" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nomcargoad]?>" style="width:100%" readonly></td>
                    <td><img class="icobut" src="imagenes/find02.png"  title="Lista de Cargos" onClick="despliegamodal2('visible','0');"/>&nbsp;<img class="icobut" src="imagenes/ladd.png" title="Agregar Cargo" onClick="mypop=window.open('adm-cargosadmguardar.php','','');mypop.focus();"/></td>
                    <td rowspan="11" style="border:double;"></td>
                </tr>
                <input type="hidden" name="idcargoad" id="idcargoad" value="<?php echo $_POST[idcargoad]?>"/>
                <tr>
     				<td class="saludo1">.: Tercero:</td>
          			<td style="width:15%;"><input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscar('1')" value="<?php echo $_POST[tercero]?>" style="width:80%">&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Listado Terceros" onClick="despliegamodal2('visible','1');"/></td>
           			<td style="width:50%;" colspan="3"><input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly></td>
                    <?php
						if($_POST[ntercero]==""){$editer=" class='icobut1' src='imagenes/usereditd.png'";}
						else{$editer=" class='icobut' src='imagenes/useredit.png' onClick=\"mypop=window.open('hum-terceroseditar01.php?idter=$_POST[idterc]','','');mypop.focus();\"";}
					?>
                    <td style="width:1.5cm;">&nbsp;<img class="icobut" src="imagenes/usuarion.png" title="Crear Tercero" onClick="mypop=window.open('hum-terceros01.php','','');mypop.focus();"/>&nbsp;<img <?php echo $editer; ?> title="Editar Tercero" /></td>
              	</tr>
                <tr>
        			<td class="saludo1">.: Direcci&oacute;n:</td>
        			<td colspan="5"><input type="text" name="direccion" id="direccion" value="<?php echo $_POST[direccion]?>" style="width:100%;" readonly/></td>
               	</tr>
                <tr>
         			<td class="saludo1">.: Telefono:</td>
        			<td><input type="text" name="telefono" id="telefono" value="<?php echo $_POST[telefono]?>" style="width:100%;" readonly/></td>
		 			<td class="saludo1" style="width:10%;">.: Celular:</td>
        			<td colspan="3"><input type="text" name="celular" id="celular" value="<?php echo $_POST[celular]?>" style="width:100%;" readonly/></td>
      	 		</tr>
                <tr>
        			<td class="saludo1">.: E-mail:</td>
        			<td colspan="5"><input type="text" name="email" id="email" value="<?php echo $_POST[email]?>" style="width:100%;" readonly/></td>
                </tr>
                <tr>
              		<td class="saludo1">.: Cuenta:</td>
            		<td><input type="text" name="tercerocta" id="tercerocta" value="<?php echo $_POST[tercerocta]?>" style="width:100%"/></td>
                    <td class="saludo1">.: Banco:</td>
                    <td colspan="3">
                    	<select name="bancocta" id="bancocta" style='text-transform:uppercase; width:70%; height:22px;'>
                        	<option value="">....</option>
                            <?php
                                $sqlr="SELECT codigo, nombre FROM hum_bancosfun WHERE estado='S' ORDER BY CONVERT(codigo, SIGNED INTEGER)";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[bancocta]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	  
                                }
                            ?>
                        </select>
                        &nbsp;<img class="icobut" src="imagenes/ladd.png" title="Crear Banco" onClick="mypop=window.open('hum-bancos.php','','');mypop.focus();"/>&nbsp;<img class="icorot" src="imagenes/reload.png" title="Actualizar Lista Bancos" onClick="document.form2.submit();"/>
                    </td>
      			</tr>	
                <tr>
                	<td class="saludo1">.: EPS:</td>
            		<td><input type="text" name="eps" id="eps" value="<?php echo $_POST[eps]?>" onKeyUp="return tabular(event,this)" style="width:80%;" onBlur="buscar('2')"/>&nbsp;<img class="icobut" src="imagenes/find02.png" onClick="despliegamodal2('visible','2');" title="Lista"/></td>
                    <td colspan="2"><input type="text" id="neps" name="neps" value="<?php echo $_POST[neps]?>" onKeyUp="return tabular(event,this)"  style="width:100%;" readonly/></td>
                    <td><input type="text" name="fechaeps" id="fc_1198971548" value="<?php echo $_POST[fechaeps]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:100%;"/></td>
                    <td><img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971548');" class="icobut" title="Fecha Ingreso EPS"/></td>
                </tr>
                <tr>
                	<td class="saludo1">.: ARL: </td>
        			<td><input type="text" name="arp" id="arp" value="<?php echo $_POST[arp]?>" onKeyUp="return tabular(event,this)" style="width:80%;" onBlur="buscar('3')"/>&nbsp;<img class="icobut" src="imagenes/find02.png" onClick="despliegamodal2('visible','3');" title="Lista"/></td>
                    <td colspan="2"><input type="text" id="narp" name="narp" value="<?php echo $_POST[narp]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                    <td><input type="text" name="fechaarl" id="fc_1198971549" value="<?php echo $_POST[fechaarl]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:100%;"/></td>
                    <td><img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971549');" class="icobut" title="Fecha Ingreso ARL"/></td>
                </tr>
                <tr>
                	<td class="saludo1">.: AFP:</td>
        			<td><input type="text" id="afp" name="afp" value="<?php echo $_POST[afp]?>" onKeyUp="return tabular(event,this)" style="width:80%;" onBlur="buscar('4')"/>&nbsp;<img class="icobut" src="imagenes/find02.png" onClick="despliegamodal2('visible','4');" /></td>
                  	<td colspan="2"><input type="text" name="nafp" id="nafp"  value="<?php echo $_POST[nafp]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                    <td><input type="text" name="fechaafp" id="fc_1198971550" value="<?php echo $_POST[fechaafp]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:100%;"/></td>
                    <td><img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971550');" class="icobut" title="Fecha Ingreso AFP"/></td>
                </tr>
                <tr>
                	<td class="saludo1">.: Fondo Cesantias:</td>
        			<td ><input type="text" id="fondocesa" name="fondocesa" value="<?php echo $_POST[fondocesa]?>" onKeyUp="return tabular(event,this)" style="width:80%;" onBlur="buscar('5')"/>&nbsp;<img class="icobut" src="imagenes/find02.png" title="Lista" onClick="despliegamodal2('visible','5');"></td>
                    <td colspan="2"><input id="nfondocesa" name="nfondocesa" type="text" value="<?php echo $_POST[nfondocesa]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                    <td><input type="text" name="fechafdc" id="fc_1198971551" value="<?php echo $_POST[fechafdc]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:100%;"/></td>
                    <td><img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971551');" class="icobut" title="Fecha Ingreso Fondo Cesantias"/></td>
                </tr>
                <tr>
 					<td class="saludo1">.: Escala:</td>
        			<td><input type="text" name="cargo" id="cargo" value="<?php echo $_POST[cargo]?>" style="width:80%;" readonly/></td>
                   	<td colspan="2"><input type="text" name="nivsal" id="nivsal" value="<?php echo $_POST[nivsal]?>" style="width:100%;" readonly></td>
                    <td style="width:10%;"><input type="text" name="asigbas2" id="asigbas2" value="<?php echo $_POST[asigbas2]?>" style="width:100%;" readonly/></td>
                    <input type="hidden" name="asigbas" id="asigbas" value="<?php echo $_POST[asigbas]?>"/>
				</tr>
                <tr>
                	<td class="saludo1">.: Periodo:</td>
                    <td>
                    	<select name="tperiodo" id="tperiodo" style="width:80%;">
				  			<option value="-1">Seleccione ....</option>
                            <option value="30"<?php if($_POST[tperiodo]==30){echo"SELECTED";}?>>MENSUAL</option>
                            <option value="15"<?php if($_POST[tperiodo]==15){echo"SELECTED";}?>>QUINCENAL</option>
		  				</select>
                    </td>
                	<td class="saludo1">.: Centro de Costo:</td>
                    <td colspan="2">
                    	<select name="numcc" id="numcc" style='text-transform:uppercase; width:70%; height:22px;'>
                        	<option value="">....</option>
                            <?php
                                $sqlr="SELECT id_cc, nombre FROM centrocosto WHERE estado='S' ORDER BY CONVERT(id_cc, SIGNED INTEGER)";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[numcc])
									{
										echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										$_POST[nomcc]=$row[1];
									}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	  
                                }
                            ?>
                        </select>
                        &nbsp;<img class="icobut" src="imagenes/ladd.png" title="Crear Centro de Costo" onClick="mypop=window.open('cont-buscacentrocosto.php','','');mypop.focus();"/>&nbsp;<img class="icorot" src="imagenes/reload.png" title="Actualizar Lista Centro de Costo" onClick="document.form2.submit();"/>
                        <input type="hidden" name="nomcc" id="nomcc" value="<?php echo $_POST[nomcc];?>"/>
                    </td>
                </tr>
            	<tr>
     				<td class="saludo1">.: Pago Cesantias:</td>
        			<td>
            			<select name="pagces" id="pagces" style="width:80%;">
                			<option value="" <?php if($_POST[pagces]==""){echo "SELECTED";} ?>> ...</option>
                			<option value="A" <?php if($_POST[pagces]=="A"){echo "SELECTED";} ?>> Anual</option>
                			<option value="M" <?php if($_POST[pagces]=="M"){echo "SELECTED";} ?>> Mensual</option>
						</select>
        			</td>
                    <td class="saludo1">.: Nivel ARL:</td>
					<td>
						<select name="nivelarl" id="nivelarl" style="width:100%;">
							<?php
								$sqlr="SELECT id,codigo,tarifa,detalle FROM hum_nivelesarl WHERE estado='S' ORDER BY id";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[nivelarl])
									{
										echo "<option value='$row[0]' SELECTED>Nivel $row[1] ($row[2]) - ".iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[3])."</option>";
									}
									else {echo "<option value='$row[0]'>Nivel $row[1] ($row[2]) - ".iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[3])."</option>";}	  
								}
							?>
						</select>
					</td>
                </tr> 
          	</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="vbuscar" id="vbuscar" value="0"/>
            <input type="hidden" name="fechamodi" id="fechamodi" value="<?php echo $_POST[fechamodi];?>"/>
            <input type="hidden" name="idterc" id="idterc" value="<?php echo $_POST[idterc];?>"/>
            <input type="hidden" name="basdatos" id="basdatos" value="<?php echo $_POST[basdatos];?>"/>
            <input type="hidden" name="basfechas" id="basfechas" value="<?php echo $_POST[basfechas];?>"/>
            <input type="hidden" name="basids" id="basids" value="<?php echo $_POST[basids];?>"/>
            <?php
				if($_POST[oculto]==2)
				{
					$bsave=0;
					$bdatos = explode('<->', $_POST[basdatos]);
					$bfechas= explode('<->', $_POST[basfechas]);
					$bids= explode('<->', $_POST[basids]);
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechain],$fecha);
					$fechaini="$fecha[3]-$fecha[2]-$fecha[1]";	
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaeps],$fecha);
					$fechainieps="$fecha[3]-$fecha[2]-$fecha[1]";	
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaarl],$fecha);
					$fechainiarl="$fecha[3]-$fecha[2]-$fecha[1]";	
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafdc],$fecha);
					$fechainifdc="$fecha[3]-$fecha[2]-$fecha[1]";
					if($_POST[fechaafp]!="")
					{
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaafp],$fecha);
						$fechainiafp="$fecha[3]-$fecha[2]-$fecha[1]";
					}
					else{$fechainiafp="0000-00-00";}
					if($_POST[swfun]=='S'){$actfun='S';}
					else {$actfun='N';}
					if($fechaini!=$bfechas[25] || $actfun!=$bdatos[25])
					{
						
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[25]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]', 'ESTGEN','$actfun','26','$fechaini','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[idcargoad]!=$bdatos[0])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[0]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]', 'IDCARGO','$_POST[idcargoad]','1','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[nomcargoad]!=$bdatos[1])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[1]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NOMCARGO','$_POST[nomcargoad]','2','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[cargo]!=$bdatos[2])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[2]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','IDESCALA','$_POST[cargo]','3','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[nivsal]!=$bdatos[3])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[3]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','INOMESCALA','$_POST[nivsal]','4','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[asigbas]!=$bdatos[4])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[4]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','VALESCALA','$_POST[asigbas]','5','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[tercero]!=$bdatos[5])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[5]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','DOCTERCERO','$_POST[tercero]','6','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[ntercero]!=$bdatos[6])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[6]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NOMTERCERO','$_POST[ntercero]','7','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[direccion]!=$bdatos[7])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[7]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','DIRTERCERO','$_POST[direccion]','8','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[telefono]!=$bdatos[8])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[8]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','TELTERCERO','$_POST[telefono]','9','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[celular]!=$bdatos[9])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[9]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','CELTERCERO','$_POST[celular]','10','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[email]!=$bdatos[10])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[10]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','EMATERCERO','$_POST[email]','11','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[tercerocta]!=$bdatos[11])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[11]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NUMCUENTA','$_POST[tercerocta]','12','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[bancocta]!=$bdatos[12])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[12]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NOMCUENTA','$_POST[bancocta]','13','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[eps]!=$bdatos[13])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[13]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NUMEPS','$_POST[eps]','14','$fechainieps','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[neps]!=$bdatos[14])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[14]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NOMEPS','$_POST[neps]','15','$fechainieps','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[arp]!=$bdatos[15])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[15]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NUMARL','$_POST[arp]','16','$fechainiarl','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[narp]!=$bdatos[16])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[16]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NOMARL','$_POST[narp]','17','$fechainiarl','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[afp]!=$bdatos[17])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[17]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NUMAFP','$_POST[afp]','18','$fechainiafp','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[nafp]!=$bdatos[18])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[18]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NOMAFP','$_POST[nafp]','19','$fechainiafp','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[fondocesa]!=$bdatos[19])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[19]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NUMFDC','$_POST[fondocesa]','20','$fechainiafp','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[nfondocesa]!=$bdatos[20])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[20]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NOMFDC','$_POST[nfondocesa]','21','$fechainiafp','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[numcc]!=$bdatos[21])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[21]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NUMCC','$_POST[numcc]','22','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[nomcc]!=$bdatos[22])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[22]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NOMCC','$_POST[nomcc]','23','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[tperiodo]!=$bdatos[23])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[23]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','PERLIQ','$_POST[tperiodo]','24','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if( $_POST[pagces]!=$bdatos[24])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[24]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','TPCESANTIAS','$_POST[pagces]','25','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if($_POST[nivelarl]!=$bdatos[26])
					{
						$sqlr ="UPDATE hum_funcionarios SET fechasal='$_POST[fechamodi]', estado='N' WHERE codrad='$bids[26]'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES ('$_POST[idfun]','NIVELARL','$_POST[nivelarl]','27','$_POST[fechamodi]','0000-00-00','S')";
						mysql_query($sqlr,$linkbd);
						$bsave=1;
					}
					if ($bsave==1){echo "<script>despliegamodalm('visible','3','Se ha modificado con Exito el funcionario');</script>";}
				}
            ?>
		</form>
        <div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
        	</div>
		</div>
    </body>
</html>