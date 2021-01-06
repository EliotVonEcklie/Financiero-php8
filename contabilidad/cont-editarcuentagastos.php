<?php
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
   	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
	
?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Contabilidad</title>
        <script type="text/javascript" src="css/programas.js"></script>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script>
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
						//eli=document.getElementById(elimina);
						vvend=document.getElementById('elimina');
						//eli.value=elimina;
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){}
			function guardar()
			{
				var validacion01=document.getElementById('clasificacion').value;
				if (validacion01.trim()!='-1')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}

			function buscacta(e)
            {
                if (document.form2.cuenta.value!="")
                {
                    document.form2.bc.value='1';
                    document.form2.submit();
                }
            }
            function adelante()
            {
                //alert('entro'+document.form2.maximo.value);
                //document.form2.oculto.value=2;
                if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
                {
                    document.form2.oculto.value=3;
                    //document.form2.agregadet.value='';
                    //document.form2.elimina.value='';
                    document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
                    //document.form2.egreso.value=parseFloat(document.form2.egreso.value)+1;
                    //document.form2.action="teso-girarchequesver.php";
                    document.form2.submit();
                }
                else
                {
	                // alert("Balance Descuadrado"+parseFloat(document.form2.maximo.value));
	            }
	            //alert('entro');
            }
            function atrasc()
            {
                //document.form2.oculto.value=2;
                if(document.form2.ncomp.value>0)
                {
                    document.form2.oculto.value=3;
                    //document.form2.agregadet.value='';
                    //document.form2.elimina.value='';
                    document.form2.ncomp.value=document.form2.ncomp.value-1;
                    //document.form2.egreso.value=document.form2.egreso.value-1;
                    //document.form2.action="teso-girarchequesver.php";
                    document.form2.submit();
                }
            }
            function validar(id)
			{
				document.form2.ncomp.value=id;
				document.form2.submit();
			}
        </script>
        <script>
            function iratras(scrtop, numpag, limreg, filtro){
                var idcta=document.getElementById('codigo').value;
                location.href="cont-cuentasgasto.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
            }
        </script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
        <table>
       		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
       	 	<tr><?php menu_desplegable("cont");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="cont-cuentasgasto.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
        	</tr>
        </table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
        <form action="" method="post" enctype="multipart/form-data" name="form2">
            <input type="hidden" name="pasa" id="pasa">
            <?php
            $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
            $estilo="style='width:60%; ";
            $uni="";
            if(empty($_POST[codigo])){
            $uni=obtenerUnidad($_GET[idcta]);
            }else{
                $uni=obtenerUnidad($_POST[codigo]);
            }

            if($uni!=null && !empty($uni)){
                $estilo.="background-color: #4FC3F7 !important; ";
            }
            $estilo.="'";
            function obtenerUnidad($cuenta){
                global $vigusu;
                $link=conectar_bd();
                $sql="SELECT unidad FROM pptocuentas WHERE cuenta='$cuenta' AND (vigencia='$vigusu' OR vigenciaf='$vigusu')";
                $result=mysql_query($sql,$link);
                $row=mysql_fetch_row($result);
                return $row[0];
            }

            function actualizaUnidad($cuenta,$unidad){
                $retorno="0";
                global $vigusu,$linkbd;
                $link=conectar_bd();
                $sql="SELECT LENGTH(cuenta) FROM pptocuentas ORDER BY LENGTH(cuenta) ASC LIMIT 0,1";
                $res=mysql_query($sql,$linkbd);
                $fila=mysql_fetch_row($res);
                $tamano=$fila[0];
                if(strlen($cuenta)==$tamano){
                    $hijos="UPDATE pptocuentas SET unidad='$unidad' WHERE cuenta='$cuenta' AND (vigencia='$vigusu' OR vigenciaf='$vigusu') ";
                    mysql_query($hijos,$link);
                }else{
                    $hijos="UPDATE pptocuentas SET unidad='$unidad' WHERE cuenta LIKE '$cuenta%' AND (vigencia='$vigusu' OR vigenciaf='$vigusu') ";
                    mysql_query($hijos,$link);
                }
                return $retorno;

            }
  
            if($_POST[oculto]=='2') //**********guardar la configuracion de la cuenta
            {
                $link=conectar_bd();
                   
                $ret=actualizaUnidad($_POST[codigo],$_POST[unidad]);
                
                $sqlr="UPDATE pptocuentas SET codconcepago='$_POST[concepago]',codconcecausa='$_POST[concecausa]', clasificacion='$_POST[clasificacion]' WHERE  `cuenta`='".$_POST[codigo]."' and (vigencia='".$vigusu."' or vigenciaf='$vigusu')";       
		   	    //  echo $sqlr;
                if (!mysql_query($sqlr,$link))
                {
                    echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
                    echo "Ocurri� el siguiente problema:<br>";
                    echo "<pre>";
                    echo "</pre></center></td></tr></table>";
                    echo "$sqlr <br>";			 
                }
                else
                {
                    echo "<script>despliegamodalm('visible','1','Se ha Actualizado la Cuenta con Exito');</script>";
                }
            }   
            
            if (!$_POST[oculto])
            {
                //echo  "hola".$_POST[codigo];
                $link=conectar_bd();
                $sqlr="Select * from pptocuentas  where estado='S'  and  (left(cuenta,1)>=2 OR (left(cuenta,1)='R' and substring(cuenta,2,1)>=2)) and vigencia='".$vigusu."' or vigenciaf=$vigusu  order by cuenta";
                $resp = mysql_query($sqlr,$link);
                $i=0;
                $copia=array();
                while ($row =mysql_fetch_row($resp)) 
                {						
                    $valor=$row[0];
                    $copia[]=$valor;
                    $_POST[todascuentas][]=$valor;
                    echo "<input type='hidden' name='todascuentas[]' value='$valor'>";	
                }		 
                //	echo "<br>Tama�o:".count($_POST[todascuentas]);		
                //	echo "<br>Tama�o2:".count($copia);					
                $npos=pos_en_array($_POST[todascuentas], $_GET[idcta]);
                //  echo "<br>posicion:".$npos;
                $_POST[maximo]=count($_POST[todascuentas]);
                $_POST[ncomp]=$npos;
	   
  		        $sqlr="Select * from pptocuentas  where estado='S' and cuenta='$_GET[idcta]' and (vigencia='$vigusu' or vigenciaf='$vigusu') order by cuenta";
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
					$_POST[codigo]=$row[0];
                    $_POST[nombre]=$row[1];
                    $_POST[tipo]=$row[2];
 					$_POST[tipoanterior]=$_GET[tipo];
                    $_POST[concepago]=$row[23];	
                    $_POST[concecausa]=$row[24];	
                    $_POST[clasificacion]=$row[29];	
                    $_POST[regalias]=$row[37];					 					 										 
                    $_POST[vigenciarg]=$row[38];					 					 										
                    $_POST[unidad]=$row[39];
                    $_POST[ncuenta]=buscacuenta($_POST[cuenta]);
					$sqlr="select *from pptocuentas_sectores where  cuenta='$_GET[idcta]' and (vigenciai='$vigusu' or vigenciaf='$vigusu')";
					$resp2 = mysql_query($sqlr,$link);		
					$row2 =mysql_fetch_row($resp2);
					$_POST[sectores]=$row2[1];
				}
            }
            
            if ($_POST[oculto]=='3' || $_POST[oculto]=='2' )
		    {
		        foreach($_POST[todascuentas] as $va)
		        {	
		            echo "<input type='hidden' name='todascuentas[]' value='$va'>";	 
		        }
		        $link=conectar_bd();
                $npos=$_POST[ncomp];
                
		        $sqlr="Select * from pptocuentas  where estado='S' and cuenta='".$_POST[todascuentas][$npos]."' and (vigencia='".$vigusu."' or vigenciaf='$vigusu') order by cuenta";
		 		$resp = mysql_query($sqlr,$link);
			    //echo "Oc:$sqlr";
				while ($row =mysql_fetch_row($resp)) 
				{
                    $_POST[codigo]=$row[0];
                    $_POST[nombre]=$row[1];
                    $_POST[tipo]=$row[2];
                    $_POST[tipoanterior]=$_GET[tipo];
                    $_POST[estado]=$row[3];
                    $_POST[concepago]=$row[23];	
                    $_POST[concecausa]=$row[24];	
                    $_POST[clasificacion]=$row[29];	
                    $_POST[regalias]=$row[37];					 					 														 
                    $_POST[vigenciarg]=$row[38];	
                    $_POST[unidad]=$row[39];
                    $_POST[ncuenta]=buscacuenta($_POST[cuenta]);
                    $sqlr="select *from pptocuentas_sectores where  cuenta like '".$_POST[todascuentas][$npos]."' and (vigenciai='$vigusu' or vigenciaf='$vigusu')";
					$resp2 = mysql_query($sqlr,$link);		
					$row2 =mysql_fetch_row($resp2);
					//echo $sqlr;
					$_POST[sectores]=$row2[1]; 
				}
            }
            if ($_POST[oculto]=='1')
            {
                foreach($_POST[todascuentas] as $va)
                {	
                    echo "<input type='hidden' name='todascuentas[]' value='$va'>";	 
                }
            }
		    if($_POST[oculto]=='1' || $_POST[oculto]=='' || $_POST[oculto]=='3' || $_POST[oculto]=='2')
		    {
   		        $link=conectar_bd();
                //*******verificacion de si tiene auxiliares debajo
                $sqlr="select count(*) from pptocuentas where $_POST[codigo]=left(cuenta,".strlen($_POST[codigo]).") and (vigencia=".$vigusu." or vigenciaf='$vigusu')";
                //echo $sqlr;
                $resp=mysql_query($sqlr,$link);
                while ($row =mysql_fetch_row($resp)) 
                {
                    $numero=$row[0];
                }
                if($numero>1 && $_POST[tipoanterior]=='Mayor' && 'Auxiliar'==$_POST[tipo])
                {
                    echo "<script>alert('No se puede pasar a Auxiliar, existen cuentas dependiendo de esta cuenta ')</script>";
                    $_POST[tipo]=$_POST[tipoanterior];
                }
                ?>
                <table class="inicio" width="99%">
                    <?php
                    //**** busca cuenta
  			        if($_POST[bc]=='1')
			        {
                        $nresul=buscacuenta($_POST[cuenta]);
                        if($nresul!='')
                        {
			                $_POST[ncuenta]=$nresul;
			            }
                        else
                        {
                            $_POST[ncuenta]="";
                        }
                    }
  			        ?>
                    <tr>
                    <td  colspan="11" class="titulos" >:. Editar Cuentas Gastos </td>
                    <td class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
                    </tr>
				    <tr>
				        <td class="saludo1" >Codigo:</td>
				        <td  style="width:16%"2>
                            <a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                            <input name="ncomp" id="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"> 
                            <input name="codigo" type="text" id="codigo" value="<?php echo $_POST[codigo]?>" size="20" readonly> 
                            <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
                            <input type="hidden" value="a" name="atras" >
                            <input type="hidden" value="s" name="siguiente" >
                            <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
                            <input name="oculto" type="hidden" id="oculto" value="1" ><input name="tipoanterior" type="hidden" id="tipoanterior" value="<?php echo $_POST[tipoanterior]?>" >			    
			            </td>
				        <td class="saludo1" >Nombre:</td>
				        <td colspan='6'>
                            <input name="nombre" type="text" style="width:86%" value="<?php echo $_POST[nombre]?>">
                        </td>
                        <td class="saludo1" >.: Tipo:</td>
				        <td>
				            <select name="tipo" onChange="document.form2.submit();" style="width: 80%">
                                <option value="Auxiliar" <?php if($_POST[tipo]=='Auxiliar') echo "SELECTED"?>>Auxiliar</option>
                                <option value="Mayor" <?php if($_POST[tipo]=='Mayor') echo "SELECTED"?>>Mayor</option>
                                
				            </select>
				        </td>
			        </tr>
				    <tr>
                        <td class="saludo1">Clasificacion:
                        </td>
                        <td colspan="1">
                            <select name="clasificacion" id="clasificacion" onChange="document.form2.submit()">
                                <option value="-1">Seleccione ....</option>
                                <?php
                                $sqlr="Select * from dominios where nombre_dominio like 'CLASIFICACION_RUBROS' and TIPO='G' order by descripcion_dominio ASC";
                                $resp = mysql_query($sqlr,$link);
                                while ($row =mysql_fetch_row($resp)) 
				                {
                                    $i=$row[2];
                                    echo "<option value='$row[2]' ";
                                    if(0==strcmp($i,$_POST[clasificacion]))
                                    {
				                        echo "SELECTED";
				                    }
				                    echo " >".strtoupper($row[2])."</option>";	  
			                    }			
				                ?>        
                            </select>    
                        </td>   
		                <td class="saludo1">Sector:
                        </td>
		                <td>
                            <select name="sectores" id="sectores" onChange="document.form2.submit();">
				                <option value="-1">Seleccione ....</option>
					            <?php
					            $sqlr="Select * from presusectores order by sector ASC";
                                $resp = mysql_query($sqlr,$link);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    $i=$row[0];
                                    echo "<option value=$row[0] ";
                                    if(0==strcmp($i,$_POST[sectores]))
                                    {
				                        echo "SELECTED";
				                    }
				                    echo " >".$row[0]."</option>";	  
			                    }			
				                ?>
				            </select>
                        </td>
					    <td class="saludo1">.: Regal&iacute;as:</td>
					    <td>
                            <select name="regalias" id="regalias" onChange="document.form2.submit()" >
                                <option value="N" <?php if($_POST[regalias]=='N') echo "SELECTED"?>>N</option>
                                <option value="S" <?php if($_POST[regalias]=='S') echo "SELECTED"?>>S</option>
                            </select>    
					    </td>
                    
                        <td class="saludo1" >.: Unidad:</td>
				        <td>
				            <select name="unidad" onChange="document.form2.submit();" <?php echo $estilo?> >
                                <?php
                                $sql="SELECT id_cc,UPPER(nombre ) FROM pptouniejecu WHERE estado='S' ";
                                $res=mysql_query($sql,$linkbd);
                                echo "<option value='' >Seleccione...</option>";
                                while($row = mysql_fetch_row($res))
                                {
                                    if($_POST[unidad]==$row[0]){
                                        echo "<option value='".$row[0]."' SELECTED>".$row[1]."</option>";
                                    }else{
                                        echo "<option value='".$row[0]."' >".$row[1]."</option>";
                                    }
                                }
                                ?>
				            </select>
				        </td>
					    <?php
					    if($_POST[regalias]=='S'){
                            echo'<td class="saludo1">Vigencia:</td>
                            <td>
                                <select name="vigenciarg" id="vigenciarg">';
                                    $sqlv="select * from dominios where nombre_dominio='VIGENCIA_RG' ORDER BY valor_inicial DESC";
                                    $resv = mysql_query($sqlv,$linkbd);
                                    while($wvig=mysql_fetch_array($resv)){
                                        if($_POST[vigenciarg]==($wvig[0].' - '.$wvig[1])){
                                            echo'<option value="'.$wvig[0].' - '.$wvig[1].'" SELECTED>'.$wvig[0].' - '.$wvig[1].'</option>';
                                        }else{
                                            echo'<option value="'.$wvig[0].' - '.$wvig[1].'">'.$wvig[0].' - '.$wvig[1].'</option>';
                                        }
                                        
                                    }
                                echo'</select>
                            </td>';
					    }
					    ?>
				    </tr>
				</table>
				<?php
				if ($_POST[tipo]=='Auxiliar')
				{
				    ?>
				    <table class="inicio" width="99%">
				        <tr>
                            <td class="titulos2" colspan="5">Parametrizacion contable</td>
                        </tr>
                        <tr>
                            <td  class="saludo1" >Programacion de Pago:</td>
                            <td>
                                <select name="concepago" id="concepago" onChange="document.form2.submit();">
                                    <option value="-1">Seleccione ....</option>
                                    <?php
                                    $sqlr="Select * from conceptoscontables  where modulo='3' and (tipo='N' or tipo='P') order by codigo";
                                    $resp = mysql_query($sqlr,$link);
                                    while ($row =mysql_fetch_row($resp)) 
                                    {
                                        $i=$row[0];
                                        echo "<option value=$row[0] ";
                                        if($i==$_POST[concepago])
                                        {
                                            echo "SELECTED";
                                        }
                                        echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
                                    }			
                                    ?>
                                </select>
                            </td>
                            <td  class="saludo1" >Programacion Reconocimiento CXP:</td>
                            <td>
                                <select name="concecausa" id="concecausa" >
                                    <option value="-1">Seleccione ....</option>
                                    <?php
                                    $sqlr="Select * from conceptoscontables  where modulo='3' and (tipo='C') order by codigo";
                                    $resp = mysql_query($sqlr,$link);
                                    while ($row =mysql_fetch_row($resp)) 
                                    {
                                        $i=$row[0];
                                        echo "<option value=$row[0] ";
                                        if($i==$_POST[concecausa])
                                        {
                                            echo "SELECTED";
                                        }
                                        echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
                                    }			
                                    ?>
                                </select>  
                            </td>
                        </tr>
				    </table>
                    <?php 
			        if($_POST[bc]=='1')
			        {
                        $nresul=buscacuenta($_POST[cuenta]);
                        if($nresul!='')
                        {
                            $_POST[ncuenta]=$nresul;
                            ?>
			                <script>
			                    document.getElementById('cgrclas').focus();document.getElementById('cgrclas').select();
                            </script>
			                <?php
			            }
                        else
                        {
                            $_POST[ncuenta]="";
                            ?>
			                <script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			                <?php
			            }
			        }
	            }
	            ?> 
            </form>
            <?php
        }//******fin del if  
        ?>
        </td>
    </tr>
    <tr><td></td></tr>      
    </table>
				 							
    <script>
        jQuery(function($){
            var user ="<?php echo $_SESSION[cedulausu]; ?>";
            var bloque='';
            $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

        $('#cambioVigencia').change(function(event) {
            var valor= $('#cambioVigencia').val();
            var user ="<?php echo $_SESSION[cedulausu]; ?>";
            var confirma=confirm('�Realmente desea cambiar la vigencia?');
            if(confirma){
                var anobloqueo=bloqueo.split("-");
                var ano=anobloqueo[0];
                if(valor < ano){
                if(confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar")){
                    $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
                }else{
                    location.reload();
                }

                }else{
                $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
                }
                
            }else{
                location.reload();
            }
        
        });

        function updateresponse(data){
            json=eval(data);
            if(json[0].respuesta=='2'){
                alert("Vigencia modificada con exito");
            }else if(json[0].respuesta=='3'){
                alert("Error al modificar la vigencia");
            }
            location.reload();
            }
            function selectresponse(data){ 
            json=eval(data);
            $('#cambioVigencia').val(json[0].vigencia);
            bloqueo=json[0].bloqueo;
            }

        }); 
    </script>
    </body>
</html>