<?php

	require '../../include/comun.php';
    require '../../include/funciones.php';
    
    session_start();
    
    $linkbd = conectar_v7();
    
    if(isset($_GET['codpag']))
        cargarcodigopag($_GET['codpag'], $_SESSION['nivel']);
    
    date_default_timezone_set("America/Bogota");
    
    if(isset($_GET['scrtop']))
        $scroll = $_GET['scrtop'];

    if(isset($_GET['totreg']))
        $totreg = $_GET['totreg'];
        
    if(isset($_GET['idcta']))
        $idcta = $_GET['idcta'];

    if(isset($_GET['altura']))
        $altura = $_GET['altura'];
        
    if(isset($_GET['filtro']))
        $filtro = '\''.$_GET['filtro'].'\'';

?>

<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>

        <meta http-equiv="cache-control" content="no-cache"> <!-- tells browser not to cache -->
        <meta http-equiv="expires" content="0"> <!-- says that the cache expires 'now' -->
        <meta http-equiv="pragma" content="no-cache"> <!-- says not to use cached stuff, if there is any -->

		<title>:: Contabilidad</title>

        <link href="../../css/css2.css" rel="stylesheet" type="text/css" />
		<link href="../../css/css3.css" rel="stylesheet" type="text/css" />

		<script type="text/javascript" src="../../js/programas.js"></script>
		<script type="text/javascript" src="../../js/funciones.js"></script>
		<script type="text/javascript" src="../../js/sweetalert.js"></script>
		<script type="text/javascript" src="../../js/sweetalert.min.js"></script>
        <script type='text/javascript' src='../../js/JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="../../js/JQuery/alphanum/jquery.alphanum.js"></script>

		<link href="../../css/sweetalert.css" rel="stylesheet" type="text/css"/>

		<script>
        	function validar(formulario){
				document.getElementById('oculto').value = '7';
				document.form2.submit();
            }
            
			function validarR(formulario){
				document.getElementById('bt').value = '1';
				document.form2.submit();
            }
            
			function guardar()
			{
				if (document.getElementById('persona').value != '-1')
				{
					if (document.getElementById('persona').value == '1')
					{
						var validacion00 = document.getElementById('documento').value;
						var validacion01 = document.getElementById('razonsocial').value;
						var validacion02 = document.getElementById('direccion').value;
						var validacion03 = document.getElementById('contribuyente');
						var validacion04 = document.getElementById('proveedor');
						var validacion05 = document.getElementById('empleado');
                        

                        var valcheck01 = validacion03.checked ? '1' : '0';

                        var valcheck02 = validacion04.checked ? '1' : '0';

                        var valcheck03 = validacion05.checked ? '1' : '0';


                        if((validacion00.trim() != '') &&
                           (validacion01.trim() != '') &&
                           (validacion02.trim() != '') &&
                           (document.getElementById('mnpio').value != '-1') &&
                           ((valcheck01 == '1') || (valcheck02 == '1') || (valcheck03 == '1')))
						{
                            despliegamodalm('visible', '4', 'Esta Seguro de Modificar', '1');
                        }
                        else 
                        {
                            despliegamodalm('visible', '2', 'Falta informacion para modificar el Tercero');
                        }
					}
					else
					{
						var validacion00 = document.getElementById('documento').value;
						var validacion01 = document.getElementById('apellido1').value;
						var validacion06 = document.getElementById('nombre1').value;
						var validacion02 = document.getElementById('direccion').value;
						var validacion03 = document.getElementById('contribuyente');
						var validacion04 = document.getElementById('proveedor');
                        var validacion05 = document.getElementById('empleado');
                        
                        var valcheck01 = validacion03.checked ? '1' : '0';

                        var valcheck02 = validacion04.checked ? '1' : '0';

                        var valcheck03 = validacion05.checked ? '1' : '0';

                        if((validacion06.trim() != '') &&
                           (validacion00.trim() != '') &&
                           (validacion01.trim() != '') &&
                           (validacion02.trim() != '') &&
                           (document.getElementById('mnpio').value != '-1') &&
                           ((valcheck01 == '1') || (valcheck02 == '1') || (valcheck03 == '1')))
						{
                            despliegamodalm('visible', '4', 'Esta Seguro de Modificar','1');
                        }
                        else 
                        {
                            despliegamodalm('visible', '2', 'Falta informacion para modificar el Tercero');
                        }
					
					}
				}
                else 
                {
                    despliegamodalm('visible', '2', 'Falta informacion para modificar el Tercero');
                }
 			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById('bgventanamodalm').style.visibility = _valor;
                
                if(_valor == 'hidden')
				{
					document.getElementById('ventanam').src = '';
                    
                    if(document.getElementById('valfocus').value == '2')
					{
						document.getElementById('valfocus').value = '1';
                        
                        document.getElementById('documento').focus();
						document.getElementById('documento').select();
					}
				}
				else
				{
					switch(_tip)
					{
						case '1':
                            document.getElementById('ventanam').src = '../modals/ventana-mensaje1.php?titulos=' + mensa;
                            break;

						case '2':
                            document.getElementById('ventanam').src = '../modals/ventana-mensaje3.php?titulos=' + mensa;
                            break;

						case '3':
                            document.getElementById('ventanam').src = '../modals/ventana-mensaje2.php?titulos=' + mensa;
                            break;

						case '4':
                            document.getElementById('ventanam').src = '../modals/ventana-consulta1.php?titulos=' + mensa + '&idresp=' + pregunta;
                            break;	
					}
				}
            }
            
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case '1':
						document.getElementById('oculto').value = '2';
						document.form2.submit();
						break;
					case '2':
						document.getElementById('oculto').value = '3';
						document.form2.submit();
						break;
				}
			}
            
            function guardarEntidad()
			{
				if (document.getElementById('idEntidad').value != '')
					despliegamodalm('visible','4','Esta Seguro de Guardar Entidad Reciproca?','2');
				else
					despliegamodalm('visible','2','Falta escoger entidad reciproca');
				
			}

            function adelante(scrtop, numpag, limreg, filtro, totreg, next)
            {
				document.getElementById('oculto').value = '1';
				document.getElementById('idtercero').value = next;
                
                if(document.getElementById('idEntidad'))
				{
					document.getElementById('idEntidad').value = '';
					document.getElementById('entidad').value = '';
				}
                
                var idcta = document.getElementById('idtercero').value;
                
                totreg++;
                
                document.form2.action = 'cont-editaterceros.php?idcta=' + idcta + '&scrtop=' + scrtop + '&numpag=' + numpag + '&limreg=' + limreg + '&totreg=' + totreg + '&filtro=' + filtro;

				document.form2.submit();
			}
		
            function atrasc(scrtop, numpag, limreg, filtro, totreg, prev)
            {
				document.getElementById('oculto').value = '1';
                document.getElementById('idtercero').value = prev;
                
				if(document.getElementById('idEntidad'))
				{
					document.getElementById('idEntidad').value = '';
					document.getElementById('entidad').value = '';
				}
				
                var idcta=document.getElementById('idtercero').value;
                
                totreg--;
                
				document.form2.action = 'cont-editaterceros.php?idcta=' + idcta + '&scrtop=' + scrtop + '&numpag=' + numpag + '&limreg=' + limreg + '&totreg=' + totreg + '&filtro=' + filtro;
				document.form2.submit();
			}

            function iratras(scrtop, numpag, limreg, filtro)
            {
				var idcta = document.getElementById('idtercero').value;
                
                location.href = 'cont-buscaterceros.php?idcta=' + idcta + '&scrtop=' + scrtop + '&numpag=' + numpag + '&limreg=' + limreg + '&filtro=' + filtro;
			}

			function despliegamodal2(_valor, _nomve)
			{
                document.getElementById('bgventanamodal2').style.visibility = _valor;
                
                if(_valor == 'hidden')
                {
					document.getElementById('ventana2').src = '';
				}
				else 
				{
					switch(_nomve)
					{
						case '1':
                            document.getElementById('ventana2').src = 'entidadesReciprocas.php?objeto=idEntidad&nobjeto=entidad';
                            break;
					}
				}
			}
		</script>

        <link rel="shortcut icon" href="favicon.ico"/>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>

		<span id="todastablas2"></span>

        <?php
            
            $numpag = $_GET['numpag'];
        
		    $limreg = $_GET['limreg'];
        
            $scrtop = 26 * $totreg;
        
        ?>

		<table>
			<tr>
                <script>
                    barra_imagenes('cont');
                </script>

                <?php
                    cuadro_titulos();
                ?>
            </tr>	

    		<tr>
                <?php
                    menu_desplegable('cont');
                ?>
            </tr>

			<tr>
            	<?php 
					if($_SESSION['prcrear'] == 1)
					{
                        $botonnuevo = '<a onClick="location.href=\'cont-terceros.php\'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>';
                    }
					else
					{
                        $botonnuevo = '<a class="mgbt1"><img src="imagenes/add2.png"/></a>';
                    }
				?>
  				<td colspan="3" class="cinta">

					<?php echo $botonnuevo;?>

					<a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a onClick="location.href = 'cont-buscaterceros.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="window.open('../planeacion/plan-agenda.php', '', '');" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda"/></a>
					<a onClick="<?php echo paginasnuevas('cont');?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
					<a onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atrás"></a>
				</td>
          	</tr>
      	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style="width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="">
 			<?php

                if(isset($_GET['idter']))
                {
                    echo '<script>document.getElementById(\'codrec\').value = '.$_GET['idter'].';</script>';
                }

                $sqlr = 'SELECT id_tercero FROM terceros ORDER BY id_tercero DESC';

                $res = mysqli_query($linkbd, $sqlr);
                $r = mysqli_fetch_assoc($res);

                $_POST['maximo'] = $r['id_tercero'];

                if(!isset($_POST['oculto']))
                {

                    if (isset($_POST['codrec']))
                        $sqlr = 'SELECT id_tercero FROM terceros WHERE id_tercero=\''.$_POST['codrec'].'\'';
                    else if(isset($_GET['idter']))
                        $sqlr = 'SELECT id_tercero FROM terceros WHERE id_tercero=\''.$_GET['idter'].'\'';
                    else
                        $sqlr = 'SELECT id_tercero FROM terceros ORDER BY id_tercero DESC';

                    $res = mysqli_query($linkbd, $sqlr);
                    $row = mysqli_fetch_assoc($res);

                    $_POST['idtercero'] = $row['id_tercero'];


                    //if($_POST['oculto'] != '2' && $_POST['oculto'] != '7')
                    $sqlr = 'SELECT * FROM terceros WHERE id_tercero=\''.$_POST['idtercero'].'\'';
                    
                    $resp = mysqli_query($linkbd, $sqlr);
                    $row = mysqli_fetch_row($resp);

                    $_POST['idtercero'] = $row[0];
                    $_POST['nombre1'] = $row[1];
                    $_POST['nombre2'] = $row[2];
                    $_POST['apellido1'] = $row[3];
                    $_POST['apellido2'] = $row[4];	 	 
                    $_POST['razonsocial'] = $row[5];	 	 	 
                    $_POST['direccion'] = $row[6];	 	 
                    $_POST['telefono']= $row[7];	 	 	 
                    $_POST['celular'] = $row[8];	 	 	 
                    $_POST['email'] = $row[9];	 	 	 
                    $_POST['web'] = $row[10];	 	 	 
                    $_POST['tipodoc'] = $row[11];	 	 
                    $_POST['documento'] = $row[12];	 	 
                    $_POST['codver'] = $row[13];	 	 
                    $_POST['dpto'] = $row[14];	 	 	 	 	 	 
                    $_POST['mnpio'] = $row[15];	 	 	 	 	 	 	 
                    $_POST['persona'] = $row[16];	 	 	 	 	 	 	 
                    $_POST['regimen'] = $row[17];	 	 	 	 	 	 	 
                    $_POST['contribuyente'] = $row[18];	 	 	 	 	 	 	 
                    $_POST['proveedor'] = $row[19];	 	 	 	 	 	 	 	 	 	 	 
                    $_POST['empleado'] = $row[20];
                    $_POST['estado'] = $row[21]; 
                }

                //NEXT
                if(isset($_POST['apellido1']))
                {
                    $sqln = 'SELECT * FROM terceros WHERE apellido1 > \''.$_POST['apellido1'].'\' ORDER BY apellido1 ASC LIMIT 1';

                    $resn = mysqli_query($linkbd, $sqln);
                    $row = mysqli_fetch_row($resn);

                    $next = $row[0];
                }
                else if(isset($_POST['razonsocial']))
                {
                    $sqln = 'SELECT * FROM terceros WHERE razonsocial > \''.$_POST['razonsocial'].'\' ORDER BY razonsocial ASC LIMIT 1';

                    $resn = mysqli_query($linkbd, $sqln);
                    $row = mysqli_fetch_row($resn);

                    $next = $row[0];
                }

                //PREV
                if(isset($_POST['apellido1']))
                {
                    $sqlp = 'SELECT * FROM terceros WHERE apellido1 < \''.$_POST['apellido1'].'\' ORDER BY apellido1 DESC LIMIT 1';

                    $resp = mysqli_query($linkbd, $sqln);
                    $row = mysqli_fetch_row($resp);

                    $prev = $row[0];
                }
                else if(isset($_POST['razonsocial']))
                {
                    $sqlp = 'SELECT * FROM terceros WHERE razonsocial < \''.$_POST['razonsocial'].'\' ORDER BY  razonsocial DESC LIMIT 1';

                    $resp = mysqli_query($linkbd, $sqln);
                    $row = mysqli_fetch_row($resp);

                    $prev = $row[0];
                }

                //if(isset($_POST['documento']))
                //{

                    $sqlr = 'SELECT id_entidad FROM entidadreciprocatercero WHERE tercero = \''.$_POST['documento'].'\'';

                    $resp = mysqli_query($linkbd, $sqlr);
                    $row = mysqli_num_rows($resp);
                    
                    if($_POST['persona'] == '1' || $row > 0)
                    {
                        $sqlrEntidadReciproca = 'SELECT id_entidad, nombre FROM codigoscun WHERE nit=\''.$_POST['documento'].'\'';

                        $respEntidadReciproca = mysqli_query($linkbd, $sqlrEntidadReciproca);
                        $rowEntidadReciproca = mysqli_fetch_assoc($respEntidadReciproca);

                        if(isset($rowEntidadReciproca))
                        {
                            $_POST['idEntidad'] = $rowEntidadReciproca['id_entidad'];
                            $_POST['entidad'] = $rowEntidadReciproca['nombre'];
                        }
                    }
                //}
 			?>
   	 		<table class="inicio" >
      			<tr>
        			<td class="titulos" colspan="5">.: Editar Terceros</td>
                    <td class="cerrar" style="width:7%"><a onClick="location.href = 'cont-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
	   			<tr>
        			<td class="saludo1" style="width:3.5cm;">.: Tipo Persona:</td>
        			<td style="width:30%;">
                    	<select name="persona" id="persona" style="width:30%;" onChange="validar()">
							<option value="-1">...</option>
							<?php

  		   						$sqlr = 'SELECT * FROM personas WHERE estado=\'1\'';
                                $resp = mysqli_query($linkbd, $sqlr);
                                
                                while ($row = mysqli_fetch_row($resp)) 
                                {
                                    if($row[0] == $_POST['persona'])
                                    {
                                        echo '<option value="'.$row[0].'" selected>'.$row[1].'</option>';
                                    }
                                    else 
                                    {
                                        echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                                    }	  
                                }  
		  					?>
						</select>   
                   	</td>
                 	<td class="saludo1" style="width:3.5cm;">.: Regimen:</td>
        			<td style='width:30%'>
                    	<select name="regimen" id="regimen" style="width:44%;">
		 					<?php

                                    $sqlr = 'SELECT id_regimen, nombre FROM regimen WHERE estado=\'1\' ORDER BY id_regimen';
                                     
                                    $resp = mysqli_query($linkbd, $sqlr);
                                     
				    			    while ($row = mysqli_fetch_assoc($resp)) 
				    			    {
                                        if(isset($_POST['regimen']) && $row['id_regimen'] == $_POST['regimen'])
                                        {
                                            echo '<option value=\''.$row['id_regimen'].'\' selected>'.$row['nombre'].'</option>';
                                        }
                                        else
                                        {
                                            echo '<option value=\''.$row['id_regimen'].'\'>'.$row['nombre'].'</option>';
                                        }	  
								    } 
		  					?>
						</select>
                  	</td>
             		<td rowspan="10" colspan="2"  style="background:url(imagenes/useradd02.png); background-repeat:no-repeat; background-position:right; background-size: 80% 80%"> </td>
           		</tr>
		   		<tr>
        			<td class="saludo1">.: Tipo Doc:</td>
        			<td>
                    	<select name="tipodoc" id="tipodoc" style="width:30%;">
		 					<?php
                                if(isset($_POST['persona']))
                                {

                                    $sqlr = 'SELECT docindentidad.id_tipodocid, docindentidad.nombre FROM  docindentidad, documentopersona WHERE docindentidad.estado=\'1\' AND documentopersona.persona=\''.$_POST['persona'].'\' AND documentopersona.tipodoc=docindentidad.id_tipodocid';
                                    
                                    $resp = mysqli_query($linkbd, $sqlr);
                                    
                                    while ($row = mysqli_fetch_assoc($resp)) 
                                    {
                                        if(isset($_POST['tipodoc']) && $row['id_tipodocid'] == $_POST['tipodoc'])
                                        {
                                            echo '<option value='.$row['id_tipodocid'].' selected>'.$row['nombre'].'</option>';
                                        }
                                        else 
                                        {
                                            echo '<option value='.$row['id_tipodocid'].'>'.$row['nombre'].'</option>';
                                        }  
                                    }
                                }
		  					?>
						</select>
                 	</td>
                    <td class="saludo1">.: Documento:</td>
        			<td>
	        	    	<a onClick="atrasc(<?php echo $scrtop.', '.$numpag.', '.$limreg.', '.$filtro.', '.$totreg.', '.$prev; ?>)" style="cursor: pointer;">
                            <img src="../../img/icons/back-to.png" alt="anterior" style=" width: 24px; height: 24px;">
                        </a> 
                    	
                        <input type="text" name="documento" id="documento" onBlur="validarR()" onKeyUp="return tabular(event, this)" value="<?php echo $_POST['documento']?>" style="width:30%" readonly/>
                        &nbsp;-&nbsp;
                        <input type="text" name="codver"  id="codver" size="1" maxlength="1" value="<?php echo $_POST['codver']?>" readonly/>
	    	            
                        <a onClick="adelante(<?php echo $scrtop.', '.$numpag.', '.$limreg.', '.$filtro.', '.$totreg.', '.$next; ?>)" style="cursor: pointer;">
                            <img src="../../img/icons/next-page.png" alt="siguiente" style=" width: 24px; height: 24px;">
                        </a> 
						
                        <?php 
						    if(isset($_POST['idEntidad']))
						    {
						?>
							    <label for="idEntidad">Reciproca:</label>
							    <input type="text" id="idEntidad" name="idEntidad" value="<?php echo $_POST['idEntidad'] ?>" style="width:30%" readonly>
						<?php
						    }
						?>

						<input type="hidden" value="<?php echo $_POST['maximo']?>" name="maximo">
						<input type="hidden" value="<?php if(isset($_POST['codrec'])) echo $_POST['codrec']?>" name="codrec" id="codrec">
                 	</td>
		   		</tr>

		 		<tr>
        			<td class="saludo1">.: Primer Apellido:</td>

                    <td>
                        <input type="text" name="apellido1" id="apellido1" value="<?php if(isset($_POST['apellido1'])) echo $_POST['apellido1']?>" style="width:98%;"  onKeyUp="return tabular(event,this)"/>
                    </td>
         			
                    <td class="saludo1">.: Segundo Apellido:</td>
        			
                    <td>
                        <input type="text" name="apellido2" id="apellido2"  value="<?php if(isset($_POST['apellido2']))echo $_POST['apellido2']?>" style="width:100%;" onKeyUp="return tabular(event,this)"/>
                    </td>
        		</tr>
				<tr>
        			<td class="saludo1">.: Primer Nombre:</td>
        			
                    <td>
                        <input type="text" name="nombre1" id="nombre1" value="<?php if(isset($_POST['nombre1'])) echo $_POST['nombre1']?>" style="width:98%;"  onKeyUp="return tabular(event,this)"/>
                    </td>                   
					<td class="saludo1">.: Segundo Nombre:</td>
        			
                    <td>
                        <input type="text" name="nombre2" id="nombre2" value="<?php if(isset($_POST['nombre2'])) echo $_POST['nombre2']?>" style="width:100%;"  onKeyUp="return tabular(event,this)"/>
                    </td>
	  			</tr>

				<?php 
				    if(isset($_POST['idEntidad']))
				    {
				?>
					    <tr>
						    <td class="saludo1">.: Entidad Reciproca:</td>
						    <td colspan="3">
							    <input type="text" id="entidad" name="entidad" value="<?php echo $_POST['entidad'] ?>" style="width:100%;" readonly>
						    </td>
					    </tr>
				<?php
				    }
				?>

	   			<tr>
       			 	<td class="saludo1">.: Razon Social:</td>
        			<td colspan="3"><input type="text" name="razonsocial" id="razonsocial" value="<?php echo $_POST['razonsocial']?>" style="width:100%;" onKeyUp="return tabular(event,this)"></td>	
             	</tr>  
	   			<tr>
        			<td class="saludo1">.: Direccion:</td>
        			<td colspan="3"><input type="text" name="direccion" id="direccion" value="<?php echo $_POST['direccion']?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
				</tr>
				<tr>
         			<td class="saludo1">.: Telefono:</td>
        			<td><input type="text" name="telefono" id="telefono" value="<?php echo $_POST['telefono']?>" style="width:98%;" onKeyUp="return tabular(event,this)"/></td>
		 			<td class="saludo1">.: Celular:        </td>
        			<td><input type="text" name="celular" id="celular" value="<?php echo $_POST['celular']?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
       			</tr>  
	    		<tr>
        			<td class="saludo1">.: E-mail:</td>
        			<td><input type="text" name="email" id="email" value="<?php echo $_POST['email']?>" style="width:98%;" onKeyUp="return tabular(event,this)"/></td>
         			<td class="saludo1">.: Pagina Web:</td>
        			<td><input type="text" name="web" id="web" value="<?php echo $_POST['web']?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
       			</tr> 
	   			<tr>
       				<td class="saludo1">:: Dpto : </td>
       			 	<td>
                    	<select name="dpto" id="dpto" onChange="validar()">
                    		<option value="-1">:::: Seleccione Departamento :::</option>
            				<?php

                                $sqlr = 'SELECT danedpto, nombredpto FROM danedpto ORDER BY nombredpto';
                                     
                                $resp = mysqli_query($linkbd, $sqlr);
                                 
				    			while ($row = mysqli_fetch_assoc($resp)) 
				    			{
                                    if($row['danedpto'] == $_POST['dpto'])
                                        echo '<option value="'.$row['danedpto'].'" selected>'.$row['nombredpto'].'</option>';
                                    else 
                                        echo '<option value="'.$row['danedpto'].'">'.$row['nombredpto'].'</option>';
								}
		  					?>
          				</select>
        			</td>

        			<td class="saludo1">:: Municipio :</td>

        			<td>
                    	<select name="mnpio" id="mnpio">
							<option value="-1">:::: Seleccione Municipio ::::</option>

              				<?php
                            
                                $sqlr = 'SELECT danemnpio, nom_mnpio FROM danemnpio WHERE danemnpio.danedpto=\''.$_POST['dpto'].'\' ORDER BY nom_mnpio';
                                     
                                $resp = mysqli_query($linkbd, $sqlr);
                                  
				    			while ($row = mysqli_fetch_assoc($resp))
				    			{
                                    if($row['danemnpio'] == $_POST['mnpio'])
                                        echo '<option value="'.$row['danemnpio'].'" selected>'.$row['nom_mnpio'].'</option>';
                                    else
					  				    echo '<option value="'.$row['danemnpio'].'">'.$row['nom_mnpio'].'</option>';
								}
							?>        
        				</select>
        			</td>

      			</tr> 
	       		<tr style="height:22px;">

        			<td class="saludo1">.: Tipo Tercero: </td>

        			<td> 
                    	<label for="contribuyente">:: Contribuyente:</label>
                        <input type="checkbox" name="contribuyente" id="contribuyente" class="defaultcheckbox" value="<?php if(isset($_POST['contribuyente'])) echo $_POST['contribuyente'];?>" <?php if(isset($_REQUEST['contribuyente'])) echo 'checked'; ?>/>
		 				
                        <label for="proveedor">:: Proveedor:</label>
                        <input type="checkbox" name="proveedor" id="proveedor" class="defaultcheckbox" value="<?php if(isset($_POST['proveedor'])) echo $_POST['proveedor'];?>" <?php if(isset($_REQUEST['proveedor'])) echo 'checked'; ?>/>
  		 				
                        <label for="empleado">:: Empleado:</label>
                        <input type="checkbox" name="empleado" id="empleado" class="defaultcheckbox" value="<?php if(isset($_POST['empleado'])) echo $_POST['empleado'];?>" <?php if(isset($_REQUEST['empleado'])) echo 'checked'; ?>/>
                  	</td>    
        			<td class="saludo1">:: Estado: </td>
                    <td>
          				<select name="estado">
            				<option value="S" <?php if($_POST['estado'] == 'S') echo 'selected';?> >SI</option>
            				<option value="N" <?php if($_POST['estado'] == 'N') echo 'selected';?> >NO</option>
          				</select>
          			</td>
          		</tr>               
    		</table>
    		<input name="oculto" id="oculto" type="hidden" value="1">

            <input name="idtercero" id="idtercero" type="hidden" value="<?php echo $_POST['idtercero'];?>"> </td>

			<input type="hidden" name="bt" id="bt" value="0"/>

			<?php
				if( !isset($_POST['oculto']) /*($_POST[oculto]=="") || ($_POST[oculto]!="2") && ($_POST[oculto]!="7")*/)
				{
					echo '
						<script>
							codigover();
                            
                            if(document.getElementById(\'contribuyente\').value == \'1\') 
                                document.getElementById(\'contribuyente\').checked = true
                            
                            if(document.getElementById(\'proveedor\').value == \'1\') 
                                document.getElementById(\'proveedor\').checked = true
                            
                            if(document.getElementById(\'empleado\').value == \'1\') 
                                document.getElementById(\'empleado\').checked = true
						</script>';
                }
                
                $valor = $_POST['persona'];
                
				switch ($valor)
				{ 
   					case '1': 
						echo '
                        <script>
                        
                                document.form2.nombre1.disabled = true;
                                
                                document.form2.nombre1.value = \'\';
                                
                                document.form2.nombre2.disabled = true;
                                
                                document.form2.nombre2.value = \'\';
                                
                                document.form2.apellido1.disabled = true;
                                
                                document.form2.apellido1.value = \'\';
                                
                                document.form2.apellido2.disabled = true;
                                
                                document.form2.apellido2.value = \'\';
                                
                                document.form2.razonsocial.disabled = false;
                                
								document.getElementById(\'nombre1\').style.backgroundColor = 668;
								document.getElementById(\'nombre2\').style.backgroundColor = 668;
								document.getElementById(\'apellido1\').style.backgroundColor = 668;
                                document.getElementById(\'apellido2\').style.backgroundColor = 668;
                                
							</script>';
      					break;
   					case '2':
						echo '
							<script>
								document.form2.nombre1.disabled = false;
                                document.form2.nombre2.disabled = false;
                                
								document.form2.apellido1.disabled = false;
                                document.form2.apellido2.disabled = false;
                                
                                document.form2.razonsocial.disabled = true;
                                
                                document.form2.razonsocial.value = \'\';
                                
                                document.getElementById(\'razonsocial\').style.backgroundColor = 668;
                                
							</script>';	
      	 				break;
                }
                
				if(isset($_POST['oculto']) && $_POST['oculto'] == '2')
				{
					$sqlr = 'UPDATE terceros SET nombre1=\''.$_POST['nombre1'].'\',nombre2=\''.$_POST['nombre2'].'\',apellido1=\''.$_POST['apellido1'].'\', apellido2=\''.$_POST['apellido2'].'\', razonsocial=\''.$_POST['razonsocial'].'\', direccion=\''.$_POST['direccion'].'\', telefono=\''.$_POST['telefono'].'\', celular=\''.$_POST['celular'].'\',email=\''.$_POST['email'].'\', web=\''.$_POST['web'].'\', tipodoc=\''.$_POST['tipodoc'].'\', cedulanit=\''.$_POST['documento'].'\', codver=\''.$_POST['codver'].'\', depto=\''.$_POST['dpto'].'\', mnpio=\''.$_POST['mnpio'].'\', persona=\''.$_POST['persona'].'\', regimen=\''.$_POST['regimen'].'\', contribuyente=\''.$_POST['contribuyente'].'\', proveedor=\''.$_POST['proveedor'].'\', empleado=\''.$_POST['empleado'].'\',estado=\''.$_POST['estado'].'\' WHERE id_tercero=\''.$_POST['idtercero'].'\'';
                    
                    if (!mysqli_query($linkbd, $sqlr))
                    {
                        echo '<script>despliegamodalm(\'visible\', \'2\', \'No se pudo ejecutar la petición\');</script>';
                    }
					else
					{
						$sqlr = 'DELETE FROM entidadreciprocatercero WHERE tercero = \''.$_POST['documento'].'\'';
						mysqli_query($linkbd, $sqlr);
						
						$sqlrInsert = 'INSERT INTO entidadreciprocatercero (id_entidad, tercero) VALUES (\''.$_POST['idEntidad'].'\', \''.$_POST['documento'].'\')';
                        mysqli_query($linkbd, $sqlrInsert);
                        
						echo '<script>despliegamodalm(\'visible\', \'3\', \'Se ha modificado con Exito\');</script>';
					}
                }
                
                if(isset($_POST['idEntidad']))
				{
					echo '<script>buscaNombreEntidad(\'idEntidad\', \'entidad\');</script>';
				}
			?>
            <script type="text/javascript">$('#apellido1,#apellido2,#nombre1,#nombre2').alphanum({allow: ''});</script>
            <script type="text/javascript">$('#razonsocial').alphanum({allow: '&'});</script>
            <script type="text/javascript">$('#direccion').alphanum({allow: '-'});</script>
            <script type="text/javascript">$('#email').alphanum({allow: '@._-'});</script>
            <script type="text/javascript">$('#web').alphanum({allow: ':._-/&@'});</script>
            <script type="text/javascript">$('#telefono,#celular').alphanum({allow: '-',allowSpace: true, allowLatin: false});</script>
            <script type="text/javascript">$('#documento').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false});</script>

			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <iframe src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </iframe>
                </div>
       	 	</div> 
 		</form>
	</body>
</html>
