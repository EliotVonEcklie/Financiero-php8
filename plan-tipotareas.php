<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
$linkbd=conectar_bd();
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
header("Cache-control: private"); // Arregla IE 6
date_default_timezone_set("America/Bogota");
?>
<?php 
function modificar_acentosjs($cadena) {$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","–");
$permitidas= array ("\\xe1","\\xe9","\\xed","\\xf3","\\xfa;","\\xc1","\\xc9","\\xcd","\\xd3","\\xda","\\xf1","\\xd1","-");$texto = str_replace($no_permitidas, $permitidas ,$cadena);return $texto;}?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css" rel="stylesheet" type="text/css"/>
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
        <script type='text/javascript' src='botones.js'></script>
        <style>
			.ocultanuevo{ position: relative; display:none; }
			.ocultamodificar{ position: relative; display:none; }
			.ocultabuscar{ position: relative; display:block; }
			.ocultarebuscar{ position: relative; display:block; }
		</style>
        <script>
			var idmodfica= new Array();
			var nommodfica= new Array();
			var tiemodfica= new Array();
			var desmodfica= new Array();
			var sinomodfica= new Array();
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
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
			function Ocultar_tabla(idtabla){var tabdis = document.getElementById(idtabla);tabdis.style.display = 'none';}
			function Mostrar_tabla(idtabla) 
			{
				var tabdis = document.getElementById(idtabla);tabdis.style.display = 'block';
				if (idtabla=='tablanuevo')
				{
					document.getElementById('imguardar').innerHTML=("<img src='imagenes/guarda.png' onClick='guardarm();'/>");
				}
			}
			function guardarm()
			{
				if((document.getElementById('granombre').value!="")&&(document.getElementById('gradescr').value!=""))
					{despliegamodalm('visible','4','Seguro de Guardar el Tipo de Tarea','1');}
				else{despliegamodalm('visible','2','Se deben ingresar la informaci\xf3n en todos los campos');}
			}
			function Ocultar_Modificar(){var tabdis = document.getElementById('tablamodificar');tabdis.style.display = 'none';}
			function Mostrar_Modificar(nomid) 
			{
				var tabdis = document.getElementById('tablamodificar');
				tabdis.style.display = 'block';
				Ocultar_tabla('tablabuscar');Ocultar_tabla('tablarebuscar');
				document.getElementById('graidm').value=idmodfica[nomid];
				document.getElementById('granombrem').value=nommodfica[nomid];
				document.getElementById('gratiempom').value=tiemodfica[nomid];
				document.getElementById('readjunto2').value=sinomodfica[nomid];
				document.getElementById('gradescrm').value=desmodfica[nomid];
				document.getElementById('imguardar').innerHTML=("<img src='imagenes/guarda.png' onClick='modificarm();'/>");
			}
			function modificarm()
			{
				if((document.getElementById('granombrem').value!="")&&(document.getElementById('gradescrm').value!=""))
					{despliegamodalm('visible','4','Seguro de Modificar el Tipo de Tarea','2');}
				else{despliegamodalm('visible','2','Se deben ingresar la informaci\xf3n en todos los campos');}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					
					case "1"://Guardar
						document.formulario.oculto1.value=2; document.formulario.submit();
						break;
					case "2"://Modificar
						document.formulario2.oculto2.value=2; document.formulario2.submit();
						break;
				}
			}
			function funcionmensaje()
			{document.location.href = 'http://servidor/financiero/plan-tipotareas.php';}
		</script>
    </head>
    <body>
    <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
    <span id="todastablas2"></span>
		<table >
            <tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("plan");?></tr>
            <tr>
      			<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo" onClick="Mostrar_tabla('tablanuevo');Ocultar_tabla('tablabuscar');Ocultar_tabla('tablarebuscar');" /></a><a href="#" id="imguardar" class="mgbt"><img src="imagenes/guardad.png" title="Guardar" onClick=""/></a><a href="#" onClick="document.formulario3.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
    		</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	
	 <span id="tablanuevo" class="ocultanuevo">
        <form name="formulario" method="post" action="" >
       		<?php
				$sqlr="SELECT max(valor_inicial) FROM dominios WHERE nombre_dominio='TIPO_TAREAS'";
				$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
				$mx=$row[0];
				$_POST[graid]=$mx+1;
			?>
			<table class="inicio" >
                <tr>
        			<td class="titulos" colspan="9" style="width:95%">:: Ingresar Tipo de Tareas</td>
                  	<td class="cerrar" style="width:5%" ><a href="plan-principal.php">Cerrar</a></td>
                </tr>
            	<tr>
                    <td class="saludo1" style="width:3%">:&middot; Id:</td>
                    <td style="width:2%"><input type="text"name="graid" id="graid" style="width:100%" value="<?php echo $_POST[graid];?>" readonly></td>
                    <td class="saludo1" style="width:6%">:&middot; Nombre:</td>
                    <td style="width:20%"><input name="granombre" type="text" id="granombre" style="width:100%"required="required"></td>
                    <td class="saludo1" style="width:12%">:&middot; Tiempo de Respuesta:</td>
                    <td style="width:7%"><input name="gratiempo" type="text" id="gratiempo" style="width:100%"required="required"></td>
                    <td class="saludo1" style="width:12%">:&middot; Requiere Adjunto:</td>
                    <td style="width:7%">
                         <select name="readjunto1" id="readjunto1" >
                             <option value="S" <?php if($_POST[readjunto1]=="S"){echo "SELECTED ";}?>>SI</option>
                             <option value="N" <?php if($_POST[readjunto1]=="N"){echo "SELECTED ";}?>>NO</option>
                         </select>
                	</td>
				</tr>
            	<tr>           
                <td class="saludo1" style="width:8%">:&middot; Descripci&oacute;n:</td>
                <td colspan="3"><input name="gradescr" type="text" id="gradescr" style="width:100%" required><input type="hidden" id="oculto1" name="oculto1" value="1"></td>
            </tr>
        </table>
        </form>
    </span>
	<span id="tablamodificar" class="ocultamodificar">
        <form name="formulario2" method="post" action="">
        <table class="inicio" >
            <tr>
              <td class="titulos" colspan="9" style="width:95%">:: Modificar Tipo de Tarea</td>
              <td width="5%" class="cerrar" style="width:5%"><a href="plan-principal.php">Cerrar</a></td>
            </tr>
            <tr >
                <td class="saludo1" style="width:3%">:&middot; Id:</td>
                <td style="width:2%"><input type="text" name="graidm" id="graidm" style="width:100%" readonly></td>
                <td class="saludo1" style="width:6%">:&middot; Nombre:</td>
                <td style="width:20%"><input name="granombrem" type="text" id="granombrem" style="width:100%"></td>
              	<td class="saludo1" style="width:12%">:&middot; Tiempo de Respuesta:</td>
                <td style="width:7%"><input type="text"name="gratiempom" id="gratiempom" style="width:100%"></td>
                <td class="saludo1" style="width:12%">:&middot; Requiere Adjunto:</td>
                <td style="width:7%">
                	 <select name="readjunto2" id="readjunto2" >
                     	 <option value="S" <?php if($_POST[readjunto2]=="S"){echo "SELECTED ";}?>>SI</option>
                         <option value="N" <?php if($_POST[readjunto2]=="N"){echo "SELECTED ";}?>>NO</option>
                     </select>
                </td>
			</tr>
            <tr>
                <td class="saludo1" style="width:8%">:&middot; Descripci&oacute;n:</td>
                <td colspan="3"><input name="gradescrm" type="text" id="gradescrm" style="width:100%" required><input type="hidden" id="oculto2" name="oculto2" value="1"></td>
            </tr>
        </table>
        </form>
    </span>
    <span id="tablabuscar" class="ocultabuscar">
    	<form action="" method="post" enctype="multipart/form-data" name="formulario3"> 
  			<table class="inicio">
                <tr >
                  <td height="25" colspan="4" class="titulos" >:.Buscar Tipos de Tareas </td>
                  <td width="5%" class="cerrar" ><a href="plan-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                  <td colspan="5" class="titulos2" >:&middot; Por Descripci&oacute;n </td>
                </tr>
				<tr >
				  <td width="13%" class="saludo1" >:&middot; Tipo de Tarea:</td>
				  <td  colspan="3"><input name="numero" type="text" size="30" >
			      <input name="oculto" type="hidden" id="oculto" value="<?php echo $_POST[oculto];?>" >
				  <input name="ac" type="hidden" id="ac" value="1" >
			      <input name="cod" type="hidden" id="cod" value="1" >
			      </td>
			    </tr>
			</table>
		</form>
    </span>
    <span id="tablarebuscar" class="ocultarebuscar">
    	<div class="subpantallap">
            <table class="inicio">        
                <tr>
                    <td class="titulos" colspan="6">:: Lista de Tipos de Tareas</td>
                </tr>
                <tr >
                    <td class="titulos2"  style="">Id</td>
                    <td class="titulos2">Nombre</td>
                    <td class="titulos2">D&iacute;as Respuesta</td>
                    <td class="titulos2">Descripci&oacute;n</td>
                    <td class="titulos2">Adjunto</td>
                    <td class="titulos2">Editar</td>
                 </tr>
                    <?php 
                        if($_POST['oculto']=="")
                        {
                            $cond=" (valor_inicial like'%".$_POST[numero]."%' or descripcion_valor like '%".strtoupper($_POST[numero])."%') AND nombre_dominio='TIPO_TAREAS'";
                            $sqlr="SELECT distinct * FROM dominios WHERE".$cond."  ORDER BY valor_inicial ASC"; 
                            $res=mysql_query($sqlr,$linkbd);//ASC acendente DESC desendedte
                            $iter='saludo1';
                            $iter2='saludo2';
							$modfictbl='tablamodificar';
							$contador1=0;	
                            while ($rowEmp = mysql_fetch_assoc($res)) 
                            {
								if($rowEmp["tipo"]=="S"){$vsino="SI";}
								else{$vsino="NO";}
                                echo '<tr class="'.$iter.'" ><td >'.$rowEmp['valor_inicial'].'</td>
                                <td>'.$rowEmp['descripcion_valor'].'</td>
								<td>'.$rowEmp['valor_final'].' D&iacute;as</td>
                                <td>'.$rowEmp['descripcion_dominio'].'</td>
								<td  style="text-align:center;">'.$vsino.'</td>
                                <td  style="text-align:center;"><a href="#"><img id="'.$rowEmp['valor_inicial'].'" src="imagenes/b_edit.png" onClick="Mostrar_Modificar('.$contador1.'); " /></a></td></tr>';
								$aux2=$rowEmp['valor_inicial'];
								$arreventos[0][$aux2]=$rowEmp['descripcion_valor'];
								$arreventos[1][$aux2]=$rowEmp['descripcion_dominio'];
                                $aux=$iter;
                                $iter=$iter2;
                                $iter2=$aux;
					?>
								<script>
                                    idmodfica['<?php echo $contador1;?>']='<?php echo $rowEmp['valor_inicial'];?>';
                                    nommodfica['<?php echo $contador1;?>']='<?php echo modificar_acentosjs($rowEmp['descripcion_valor']);?>';
                                    tiemodfica['<?php echo $contador1;?>']='<?php echo $rowEmp['valor_final'];?>';
									sinomodfica['<?php echo $contador1;?>']='<?php echo $rowEmp['tipo'];?>';
                                    desmodfica['<?php echo $contador1;?>']='<?php echo modificar_acentosjs($rowEmp['descripcion_dominio']);?>';
                                </script>
					<?php
						$contador1++;				
                        }
                        $_POST[oculto]="1";
                        }	
                    ?>
             </table>
         </div>
       </span>  
      </td>
      </tr>
    </table>
    <?php
		//guardar
		if ($_POST[oculto1]== 2)
		{
			$sqlr = "INSERT INTO dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) VALUES ('$_POST[graid]','$_POST[gratiempo]','$_POST[granombre]','TIPO_TAREAS','$_POST[readjunto1]','$_POST[gradescr]')";
			if(mysql_query($sqlr,$linkbd))
				{echo "<script>despliegamodalm('visible','1','Se Guardo con Exito El Tipo de Tarea');</script>";}
		}
		//Modificar
		if ($_POST[oculto2]== 2)
		{
			$sqlr = "UPDATE dominios SET  valor_final='$_POST[gratiempom]',descripcion_valor= '$_POST[granombrem]',tipo='$_POST[readjunto2]',descripcion_dominio='$_POST[gradescrm]' WHERE valor_inicial='$_POST[graidm]' AND  nombre_dominio='TIPO_TAREAS'";
			if(mysql_query($sqlr,$linkbd))
				{echo "<script>despliegamodalm('visible','1','Se Modifico con Exito El Tipo de Tarea');</script>";}
		}
	?>
    
    </body>
</html>