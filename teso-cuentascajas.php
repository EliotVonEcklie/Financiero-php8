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
		<title>:: IDEAL - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js" ></script>
		<script>
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value='1';
 					document.form2.submit();
 				}
 			}
			function validar(){document.form2.submit();}
			function agregardetalle()
			{
				if(document.form2.banco.value!="" &&  document.form2.cb.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
					document.form2.elimina.value=variable;
					document.form2.submit();
				}
			}
			function guardar()
			{
				if (document.form2.tercero.value!='' && document.form2.tipocta.value!='')
				{
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.tercero.focus();
					document.form2.tercero.select();
				}
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
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
						case "5":
						document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":
						document.form2.elimina.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){document.location.href = "teso-buscacuentascajas.php";}
			function buscater(e)
			{
				if (document.form2.tercero.value!="")
				{
					document.form2.bt.value='1';
					document.form2.submit();
				}
			}
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
 				<td colspan="3" class="cinta">
				<a href="teso-cuentascajas.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
				<a href="teso-buscacuentascajas.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>		  
		</table>
		<?php
			$vigencia=date(Y);
			if(!$_POST[oculto])
			{
				$fec=date("d/m/Y");
			   	$_POST[fecha]=$fec; 	
			   	$_POST[valoradicion]=0;
			   	$_POST[valorreduccion]=0;
			   	$_POST[valortraslados]=0;		 		  			 
			   	$_POST[valor]=0;		 
			}
			if ($_POST[chacuerdo]=='2')
			{
				$_POST[dcuentas]=array();
				$_POST[dncuetas]=array();
				$_POST[dingresos]=array();
				$_POST[dgastos]=array();
				$_POST[diferencia]=0;
				$_POST[cuentagas]=0;
				$_POST[cuentaing]=0;																			
			}	
		?>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form  name="form2" method="post" action="">
 			<?php 
				if($_POST[bt]=='1')
				 {
					$nresul=buscatercero($_POST[tercero]);
					if($nresul!=''){$_POST[ntercero]=$nresul;}
					else {$_POST[ntercero]=""; }
				 }
			 ?>
			<table class="inicio" align="center" >
      			<tr >
        			<td class="titulos" colspan="5">.: Activar Cuentas de Cajas</td>
                    <td width="116" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      			</tr>
			</table>
	  		<table class="inicio">
		  		<tr><td class="titulos" colspan="4">Cuentas</td></tr>
	  			<tr>
	  				<td class="saludo1" style="width:3cm;">Cuenta Contable:</td>
	  				<td style="width:35.5%;" >
	    				<select name="banco" id="banco"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%;">
							<option value="">Seleccione.....</option>
	      					<?php
								$sqlr="SELECT TB1.* FROM cuentasnicsp TB1 WHERE left(TB1.cuenta,4)='1105' AND TB1.estado='S' AND TB1.tipo='Auxiliar' AND NOT EXISTS (SELECT TB2.cuenta FROM tesobancosctas TB2 WHERE TB2.cuenta=TB1.cuenta) ORDER BY TB1.cuenta";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
					 				if("$row[0]"==$_POST[banco])
			 						{
										echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
						 				$_POST[nbanco]=$row[1];
						 			}
									else{echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}	 	
							?>
         				 </select>	
                        <input type="hidden" value="0" name="bt">
                        <input type="hidden" name="chacuerdo" value="1">
                        <input type="hidden" value="1"  id="oculto" name="oculto">
                         <input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco">
           			</td>
		 			<td class="saludo1" style="width:3cm;">Cuenta Bancaria:</td>
	  				<td ><input name="cb" type="text"  value="<?php echo $_POST[cb]?>" onKeyUp="return tabular(event,this)"></td>
      			</tr>
	  			<tr>
                	<td class="saludo1" style="width:3cm;">Tipo:</td>
      				<td >
						<select name="tipocta" id="tipocta" onKeyUp="return tabular(event,this)" onChange="validar()">
							<option value="">...</option>
							<option value="Ahorros" <?php if($_POST[tipocta]=='Ahorros') echo "SELECTED"; ?>>Ahorros</option>
							<option value="Corriente" <?php if($_POST[tipocta]=='Corriente') echo "SELECTED"; ?>>Corriente</option>
						</select>&nbsp;<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet">
                   </td>	   
	  			</tr> 
			</table>
	   		<div class="subpantallac2" style="height:55.5%; width:99.6%; overflow-x:hidden;">
                <table class="inicio">
                    <tr><td class="titulos" colspan="5">Detalle Cuentas</td></tr>
                    <tr>
                        <td class="titulos2">Cuenta</td>
                        <td class="titulos2" >Cuenta Bancaria</td>
                        <td class="titulos2">Tipo Cuenta</td>
                        <td class="titulos2" style="width:5%;">Eliminar</td>
                    </tr>
                    <input type='hidden' name='elimina' id='elimina'>
                    <?php 
                        if($_POST[bt]=='1')//***** busca tercero
                        {
                            $nresul=buscatercero($_POST[tercero]);
                            if($nresul!='')
                            {
                                $_POST[ntercero]=$nresul;
                                echo "<script> document.getElementById('banco').focus();document.getElementById('banco').select();</script>";
                            }
                            else
                            {
                                $_POST[ntercero]="";
                                echo "<script>document.form2.tercero.focus();</script>";
                            }
                        }
                        if ($_POST[elimina]!='')
                        { 
                            $posi=$_POST[elimina];
                            unset($_POST[dcuentas][$posi]);
                            unset($_POST[dncuentas][$posi]);
                            unset($_POST[dtcuentas][$posi]);		 
                            unset($_POST[dcbs][$posi]);	 
                            $_POST[dcuentas]= array_values($_POST[dcuentas]); 
                            $_POST[dncuentas]= array_values($_POST[dncuentas]); 
                            $_POST[dtcuentas]= array_values($_POST[dtcuentas]); 
                            $_POST[dcbs]= array_values($_POST[dcbs]); 		 		 		 		 		 
                        }	 
                        if ($_POST[agregadet]=='1')
                        {
                            $_POST[dcuentas][]=$_POST[banco];
                             $_POST[dncuentas][]=$_POST[nbanco];
                             $_POST[dtcuentas][]=$_POST[tipocta];		 
                             $_POST[dcbs][]=$_POST[cb];
                             $_POST[agregadet]=0;
                            echo"
                            <script>
                                document.form2.banco.value='';
                                document.form2.nbanco.value='';
                                document.form2.cb.value='';
                                document.form2.cuenta.select();
                                document.form2.cuenta.focus();	
                            </script>";
                        }
                        $iter='saludo1a';
                        $iter2='saludo2';
                        for ($x=0;$x<count($_POST[dcuentas]);$x++)
                        {		 
                            echo "
                            <input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
                            <input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
                            <input type='hidden' name='dcbs[]' value='".$_POST[dcbs][$x]."'/>
                            <input type='hidden' name='dtcuentas[]' value='".$_POST[dtcuentas][$x]."'>
                            <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
                onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase;'>
                                <td>".$_POST[dncuentas][$x]."</td> 
                                <td>".$_POST[dcbs][$x]."</td>
                                <td>".$_POST[dtcuentas][$x]."</td>
                                <td style='text-align:center;'><img src='imagenes/del.png' style='cursor:pointer' onclick='eliminar($x)'></td>
                            </tr>";
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
                        }
                    ?>
                </table>
			</div>
			<?php
                if($_POST[oculto]=='2')
                {
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                    $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
                    //************** modificacion del presupuesto **************
                    for($x=0;$x<count($_POST[dcuentas]);$x++)
                    {
                        $sqlr="insert into tesobancosctas (cuenta,tercero,ncuentaban,tipo,estado) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dcbs][$x]."','".$_POST[dtcuentas][$x]."','S')";	  
                        if (!mysql_query($sqlr,$linkbd))
                        {
                            echo "
                            <script>
                                despliegamodalm('visible','2','Manejador de Errores de la Clase BD No se pudo ejecutar la petici�n');
                                document.getElementById('valfocus').value='2';
                            </script>";
                        }
                        else
                        {
                            echo "
                            <table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Cuenta con Exito</center></td></tr></table>
                            <script>
                                 document.form2.tercero.value='';
                                document.form2.ntercero.value='';
                            </script>";
                        }
                    }	  
                }
    		?>	
   		</form>
	</body>
</html>