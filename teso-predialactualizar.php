<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
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
	 	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
    	<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
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
				if(document.form2.tercero.value!="" &&  document.form2.ntercero.value!="")
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
					vvend=document.getElementById('elimina');
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function guardar()
			{
				if (document.form2.tipop.value!='' )
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
  					document.form2.tercero.focus();
  					document.form2.tercero.select();
  				}
			}
			function buscater(e)
			{
				if (document.form2.tercero.value!="")
				{
	 				document.form2.bt.value='1';
	 				document.form2.submit();
	 			}
			}
			function buscar()
			{
				document.form2.actualiza.value='0';	
	 			document.form2.buscav.value='1';
	 			document.form2.submit();
 			}
 			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="catastral-ventana01.php";}
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
		  		<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-predialactualizar.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="buscar()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='teso-gestionpredial.php'" class="mgbt"/></td>
			</tr>		  
		</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			function buscarCc($cc)
			{
				$vecotorCcInsert = explode('@@@', $_POST[vecotorCcInsert]);
				$existe = false;
				for ($i=0; $i < count($vecotorCcInsert) ; $i++) 
				{ 
					if ($vecotorCcInsert[$i] == $cc) {$existe = true;}
				}
				return $existe;
			}
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
		<form  name="form2" method="post" action="">
 			<?php 
				if($_POST[bt]=='1')
				{
					$nresul=buscatercero($_POST[tercero]);
					if($nresul!=''){$_POST[ntercero]=$nresul;}
					else{$_POST[ntercero]="";}
				}
				if($_POST[oculto]=='2')
				{
					$sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." AND estado='S' order by ord";
					$res=mysql_query($sqlr,$linkbd);
 					while($row=mysql_fetch_row($res))
					{
						$_POST[doc][]=$row[4];
						$_POST[ords][]=$row[1];
						$_POST[ntercero][]=$row[6];
						$_POST[tercero][]=$row[5];
					}
				}
				if($_POST[buscav]=='1')
				{
					$_POST[dvigencias]=array();
					$_POST[davaluos]=array();
					$_POST[dtodos]=array();		 
					$_POST[dtots]=array();		 
					$_POST[dords]=array();
					$_POST[doc]=array();
					$_POST[ords]=array();
					$_POST[ntercero]=array();
					$_POST[tercero]=array();
					$sqlr="select * from tesopredios where cedulacatastral=".$_POST[codcat]." and estado='S' order by ord";
					$res=mysql_query($sqlr,$linkbd);
 					while($row=mysql_fetch_row($res))
	  				{
		 				$_POST[catastral]=$row[0];
						$_POST[ord]=$row[1];
						$_POST[tot]=$row[2];
						$_POST[doc][]=$row[4];
						$_POST[ords][]=$row[1];
						$_POST[ntercero][]=$row[6];
						$_POST[tercero][]=$row[5];
						$_POST[direccion]=$row[7];
						$_POST[ha]=$row[8];
						$_POST[mt2]=$row[9];
						$_POST[areac]=$row[10];
						$_POST[avaluo]=$row[11];
						$_POST[tipop]=$row[14];
						$_POST[estadop]=$row[13];
		  				if($_POST[tipop]=='urbano'){$_POST[estrato]=$row[15];}
						else {$_POST[rangos]=$row[15];}
						$_POST[buscav]="";
	  				}
	 				$sqlr="select * from tesoprediosavaluos where codigocatastral='".$_POST[codcat]."'"; 
	 				$res=mysql_query($sqlr,$linkbd);
	 				while($row=mysql_fetch_row($res))
	  				{
	  					$_POST[dvigencias][]=$row[0];
						$_POST[davaluos][]=$row[2];
					   	$_POST[dtodos][]=$row[3];
					   	$_POST[dords][]=$row[6];
					   	$_POST[dtots][]=$row[5];	   
	 				}
  				}
			?>
 			<input type="hidden" value="" name="tipoDoc" id="tipoDoc">
    		<table class="inicio" align="center" >
      		<tr >
        		<td class="titulos" colspan="8">.: Actualizar Predios</td>
                <td class="cerrar" style='width:7%'><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      		</tr>
     		<tr>
				<td  class="saludo1" style="width:10%;">No Resoluci&oacute;n:</td>
				<td style="width:10%;"><input  name="numresolucion" type="text" id="numresolucion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numresolucion]?>" /></td>
				<td  class="saludo1" style="width:10%;">Detalle:</td>
				<td colspan="2"><input  name="detallecambio" style="width:100%;" type="text" id="detallecambio" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[detallecambio]?>"/></td>
				<td  class="saludo1" style="width:10%;">Fecha:</td>
				<td style="width:10%;"><input name="fecharesolucion" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecharesolucion]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width:80%;"/>&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario" onClick="displayCalendarFor('fc_1198971545');"/></td>
	 		</tr>
	  		<tr> 
				<td  class="saludo1" style="width:10%;">C&oacute;digo Catastral:</td>
        		<td colspan="2"><input id="codcat" type="text" name="codcat"  onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" onClick="document.getElementById('codcat').focus();document.getElementById('codcat').select();">
			<input id="ord" type="hidden" name="ord"   value="<?php echo $_POST[ord]?>" style="width:5%;" readonly>
			<input id="tot" type="hidden" name="tot"  value="<?php echo $_POST[tot]?>" style="width:5%;" readonly> 
			<input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" id="oculto" name="oculto"> 
			<input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav">
			<input type="hidden" value="<?php echo $_POST[actualiza]?>" name="actualiza">
			<a title="Listado de Predios" onClick="despliegamodal2('visible');" style="cursor:pointer;"><img src="imagenes/find02.png" style="width:20px;"/></a>
			<input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar()" ></td>
        </tr>
	  </table>
	  <table class="inicio">
	  	<tr>
	    	<td class="titulos" colspan="10">Informaci&oacute;n Predio</td>
	   	</tr>
	  	<tr>
		  	<td class="saludo1">C&oacute;digo Catastral:</td>
		  	<td  style="width:10%;">
		  		<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco">
		  		<input  style="width:100%;" name="catastral" type="text" id="catastral" onBlur="buscater(event)" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>"  readonly>
		  	</td>
				   
			<td class="saludo1">Avaluo:</td>
		  	<td style="width:10%;" >
		  		<input style="width:100%;" name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" >
		  	</td>

		  	<td  class="saludo1">Area Cons:</td>
		  	<td style="width:10%;">
		  		<input style="width:100%;" name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" >
		  	</td>
		  	<td class="saludo1">Ha:</td>
		  	<td style="width:10%;">
		  		<input style="width:100%;" name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" >
		  	</td>
			<td  class="saludo1">Mt2:</td>
	  		<td style="width:10%;">
	  			<input style="width:100%;" name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" >
	  		</td>
	  	</tr>
	  	<tr>
			<td width="119" class="saludo1">Tipo:</td>
	     	<td width="202">
	     		<select style='width:100%;' id='tipop' name="tipop">
					<option value="urbano" <?php if($_POST[tipop]=='urbano') echo "SELECTED"?>>Urbano</option>
	  				<option value="rural" <?php if($_POST[tipop]=='rural') echo "SELECTED"?>>Rural</option>
				s</select>
            </td>

			
	        <td id='tipoEstrato' style="width:10%;" class="saludo1">Estratos:</td>
	        <td id='urbano'>
	        	<select style="width:100%;" name="estrato" id='estrato'>
		       		<option value="">Seleccione ...</option>
		            <?php
						$linkbd=conectar_bd();
						$sqlr="select *from estratos where estado='S'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						    {
							echo "<option value=$row[0] ";
							$i=$row[0];
				
							 if($i==$_POST[estrato])
					 			{
								 echo "SELECTED";
								 $_POST[nestrato]=$row[1];
								 }
							  echo ">".$row[1]."</option>";	 	 
							}	 	
						?>            
				</select>  
				<input type="hidden" value="<?php echo $_POST[nestrato]?>" id='nestrato' name="nestrato">
            
	            <select name="rangos" id='rangos' style="width:100%;">
	       		<option value="">Seleccione ...</option>
	            <?php
					$linkbd=conectar_bd();
					$sqlr="select *from rangoavaluos where estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					    {
						echo "<option value=$row[0] ";
						$i=$row[0];
			
			
						 if($i==$_POST[rangos])
				 			{
							 echo "SELECTED";
							 $_POST[nrango]=$row[1]." - ".$row[2]." SMMLV";
						    }
						  echo ">Entre ".$row[1]." - ".$row[2]." SMMLV</option>";	 	 
						}	 	
					?>            
				</select>
	            <input type="hidden" value="<?php echo $_POST[nrango]?>" id='nrango' name="nrango">            
				<input type="hidden" value="0" id='agregadet' name="agregadet">
			</td>
		  	<td  class="saludo1">Direcci&oacute;n:</td>
	  		<td colspan='3'>
	  			<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco">
	  			<input style='width: 100%;' name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" >
	  		</td>

	  		<td  class="saludo1">Estado:</td>
		   	<td style="width:10%;">
			   	<select style="width:100%;" name="estadop" onChange="">
		       		<option value="">Seleccione ...</option>
					<option value="S" <?php if($_POST[estadop]=='S') echo "SELECTED"?>>Activo</option>
		  			<option value="N" <?php if($_POST[estadop]=='N') echo "SELECTED"?>>Inactivo</option>
				</select>
			</td>
        </tr>
        <tr>	    
			<td  class="saludo1">Documento: </td>
        	<td style="width:10%;">
        		<input name="tercero" id="tercero" type="text" value="" onkeyup="return tabular(event,this)" style="width:80%;">
				
				<input type="hidden" value="0" name="bt">
          		<a href="#" onClick="mypop=window.open('terceros-ventanapredios2.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
          	</td>
      		<td  class="saludo1">Propietario:</td>
	  		<td colspan="3" >
	  			<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco">

	  			<input name="ntercero" type="text" id="ntercero" onKeyUp="return tabular(event,this)" value="" style="width:100%;">
	  		</td>
	  		<td>
				<input type="button" name="agregar" id="agregar" value="Agregar Propietario">
			</td>
      	</tr> 
      </table>
      <script type="text/javascript">
	
      		//console.log(ntercero);
			$('#rangos').hide();
			$('#estrato').hide();
			$('#tipoEstrato').hide();

			if($('#tipop').val() == 'urbano'){
      				$('#tipoEstrato').text('Estratos:');
      				$('#rangos').hide();
      				$('#estrato').show();
      				$('#rango').val('');
      				$('#tipoEstrato').show();
      			}else if($('#tipop').val() == 'rural'){
					$('#tipoEstrato').text('Rango Avaluo:');
      				$('#estrato').hide();
      				$('#rangos').show();
      				$('#estrato').val('');
      				$('#tipoEstrato').show();
      			}

			$( "#avaluo" ).keyup(function() {
				//console.log($(this).val());
			  	$('#avaluos0').val($(this).val());
			});

      		$('#tipop').change(function(event) {
      			/* Act on the event */
      			//console.log($(this).val());
      			if($(this).val() == 'urbano'){
      				$('#tipoEstrato').text('Estratos:');
      				$('#rangos').hide();
      				$('#estrato').show();
      				$('#rango').val('');
      				$('#tipoEstrato').show();
      			}else if($(this).val() == 'rural'){
					$('#tipoEstrato').text('Rango Avaluo:');
      				$('#estrato').hide();
      				$('#rangos').show();
      				$('#estrato').val('');
      				$('#tipoEstrato').show();
      			}else{
      				$('#rangos').hide();
					$('#estrato').hide();
					$('#tipoEstrato').hide();
      				$('#rango').val('');					
      				$('#estrato').val('');
      			}
      		});

      		$('#agregar').click(agregarfila);

      		// Cuando se elimina un propietario, si esta en el vector vecotorCcInsert se saca
      		function actulizarInsert(cc){
      			var CcInsert = $('#vecotorCcInsert').val();
      			var vecotorCcInsert = CcInsert.split('@@@');
      			var nuevoVecotorCcInsert='';
      			for (var i = 0; i < vecotorCcInsert.length; i++) {
      				if (vecotorCcInsert[i]!=cc) {
      					if (nuevoVecotorCcInsert=='') {
      						nuevoVecotorCcInsert=vecotorCcInsert[i];
      					}else{
      						nuevoVecotorCcInsert+='@@@'+vecotorCcInsert[i];
      					}
      				}
      			}
      			$('#vecotorCcInsert').val(nuevoVecotorCcInsert);
      		}


      		function actulizarEliminar(cc){
      			var CcEliminar = $('#vecotorCcEliminar').val();
      			var vecotorCcEliminar = CcEliminar.split('@@@');
      			var nuevoVecotorCcEliminar='';

      			for (var i = 0; i < vecotorCcEliminar.length; i++) {
      				if (vecotorCcEliminar[i]!=cc) {
      					if (nuevoVecotorCcEliminar=='') {
      						nuevoVecotorCcEliminar=vecotorCcEliminar[i];
      					}else{
      						nuevoVecotorCcEliminar+='@@@'+vecotorCcEliminar[i];
      					}
      				}
      			}
      			$('#vecotorCcEliminar').val(nuevoVecotorCcEliminar);
      		}

      		function eliminarFila() {
				$(this).parent().remove();
				var vectorOrd='';
				var vecotorCc='';
				var vecotorNombre='';
				var vectorTipoDoc='';

				var vecotorCcEliminar=$('#vecotorCcEliminar').val();
				
				$(this).parent().children("td").each(function (index2) 
	            {
	                switch (index2) 
	                {
	                    case 2: 
	                    if (vecotorCcEliminar=='') {
	                    	vecotorCcEliminar += $(this).text();
						}else{
	                    	vecotorCcEliminar += '@@@'+$(this).text();
	                    }
	                    actulizarInsert($(this).text());
	                    break;
	                }
	            });
$('#tot').val('000');
				$("#tablaPropietarios tr").each(function (index) 
		        {
		        	if (index!=0) {
		        		if (index!=1) {
		        			vectorOrd +='@@@';
							vecotorCc +='@@@';
							vecotorNombre +='@@@';
							vectorTipoDoc +='@@@';
		        		}
		        		
			            $(this).children("td").each(function (index2) 
			            {
			                switch (index2) 
			                {	

			                    case 0: 
			                    	vectorTipoDoc += $(this).text();
			                        break;
			                    case 1:
			                    	if (index<9) {
										$('#tot').val('00'+(index));
										vectorOrd += '00'+(index);
					      			}else if (index<99) {
					      				$('#tot').val('0'+(index));
					      				vectorOrd += '00'+(index);
					      			}else {
					      				$('#tot').val(index);
					      				vectorOrd += '00'+(index);
					      			}
			                    	
		                            break;
			                    case 2: 
			                    	vecotorCc += $(this).text();
			                        break;
			                    case 3: 	
			                    	vecotorNombre += $(this).text();
			                        break;
			                }
			            });
			            
		        	}
		        });
				$("#tablaPropietarios tr").remove();
				
				var nuevaFila='<tr><td class="titulos" style="width:8%">Tipo Doc</td><td class="titulos" style="width:5%">Ord</td><td class="titulos" style="width:15%">Documento</td><td class="titulos">Nombre Propietario</td><td class="titulos2" style="width:8%;text-align:center;">Eliminar</td></tr>';
				
				var tablaOrd = vectorOrd.split('@@@');
				var tablarCc = vecotorCc.split('@@@');
				var tablarNombre = vecotorNombre.split('@@@');
				var tablarTipoDoc = vectorTipoDoc.split('@@@');

				$('#vectorOrd').val(vectorOrd);
				$('#vecotorCc').val(vecotorCc);
				$('#vecotorNombre').val(vecotorNombre);
				$('#vectorTipoDoc').val(vectorTipoDoc);
				$('#vecotorCcEliminar').val(vecotorCcEliminar);

				$.each(tablarCc, function(index,contenido){
				    var saludo1='';
	      			if (index%2!=0) {
	      				saludo1='saludo1a';

	      			}else{
	      				saludo1='saludo2';
	      			}
	      			if (tablarTipoDoc[index]!=''&&tablarCc[index]!=''&&tablarNombre[index]!='') {
				        nuevaFila+="<tr class="+saludo1+">";
			           	nuevaFila+="<td>"+tablarTipoDoc[index]+"</td>";
			           	nuevaFila+="<td>"+tablaOrd[index]+"</td>";
			           	nuevaFila+="<td>"+tablarCc[index]+"</td>";
			           	nuevaFila+="<td>"+tablarNombre[index]+"</td>";
			           	nuevaFila+="<td class='eliminar' style='text-align:center;'><a ><img src='imagenes/del.png' style='cursor:pointer;'></a></td>";
		            	nuevaFila+="</tr>";
		            }
				});
				$("#tablaPropietarios").append(nuevaFila);
				
				$('.eliminar').click(eliminarFila);
      		}

      		function buscarCc(cc){
      			var existe = false;
      			$("#tablaPropietarios tr").each(function (index) {
		            $(this).children("td").each(function (index2) {
		                switch (index2) {
		                    case 2: 
		                    	if (cc == $(this).text()) {
		                    		existe = true;
		                    	}
		                        break;
		                }
		            });
		        });
		        return existe;
      		}

      		function agregarfila() {
      			if ($('#tercero').val()!='') {
	      			if (!buscarCc($('#tercero').val())) {

	      				console.log('-------');
	      				var tot = $('#tot').val();

		      			if (parseInt(tot)<9) {
							$('#tot').val('00'+(parseInt(tot)+1));
		      			}else if (parseInt(tot)<99) {
		      				$('#tot').val('0'+(parseInt(tot)+1));
		      			}else if (parseInt(tot)) {
		      				$('#tot').val((parseInt(tot)+1));
		      			}
		      			var tot = $('#tot').val();
		      			var cc = $('#tercero').val();
		      			var nombre = $('#ntercero').val();
		      			var tipoDoc2 = $('#tipoDoc').val();

						if(tipoDoc2=='N'){
							tipoDoc2='C'
						}
		      			var vecotorCcInsert =$('#vecotorCcInsert').val();
						if (vecotorCcInsert=='') {
							vecotorCcInsert += cc;
						}else{
	                    	vecotorCcInsert += '@@@'+cc;

						}
						actulizarEliminar(cc);

		      			$('#tercero').val('');
		      			$('#ntercero').val('');
		      			var saludo1='';
		      			if (tot%2!=0) {
		      				saludo1='saludo1a';

		      			}else{
		      				saludo1='saludo2';
		      			}
		      			// Obtenemos el numero de filas (td) que tiene la primera columna
		            	// (tr) del id "tabla"
			            var tds=$("#tablaPropietarios tr:first td").length;
			            // Obtenemos el total de columnas (tr) del id "tabla"
			            var trs=$("#tablaPropietarios tr").length;
			            var nuevaFila="<tr id='"+cc+"' class="+saludo1+">";
			           	nuevaFila+="<td id='tipoDoc2'>"+tipoDoc2+"</td>";
			           	nuevaFila+="<td id='tot'>"+tot+"</td>";
			           	nuevaFila+="<td id='cc' name='cc'>"+cc+"</td>";
			           	nuevaFila+="<td id='nombre1' name='nombre1'>"+nombre+"</td>";
			            // A�adimos una columna con el numero total de columnas.
			            // A�adimos uno al total, ya que cuando cargamos los valores para la
			            // columna, todavia no esta a�adida
			            nuevaFila+="<td class='eliminar' style='text-align:center;'><a ><img src='imagenes/del.png' style='cursor:pointer;'></a></td>";
			            nuevaFila+="</tr>";
			            $("#tablaPropietarios").append(nuevaFila);
						
						$('.eliminar').click(eliminarFila);

						
					    var vectorOrd='', vecotorCc='', vecotorNombre='', vectorTipoDoc='';

			      		$("#tablaPropietarios tr").each(function (index) 
				        {
				        	if (index!=0) {
				        		if (index!=1) {
				        			vectorOrd +='@@@';
									vecotorCc +='@@@';
									vecotorNombre +='@@@';
									vectorTipoDoc +='@@@';
				        		}
					            $(this).children("td").each(function (index2) 
					            {
					                switch (index2) 
					                {
					                	case 0: 
					                    	vectorTipoDoc += $(this).text();
				                            break;
					                    case 1: 
					                    	vectorOrd += $(this).text();
				                            break;
					                    case 2: 
					                    	vecotorCc += $(this).text();
					                        break;
					                    case 3: 	
					                    	vecotorNombre += $(this).text();
					                        break;
					                }
					            });
					            
				        	}
				        });

				        $('#vectorTipoDoc').val(vectorTipoDoc);
				        $('#vectorOrd').val(vectorOrd);
						$('#vecotorCc').val(vecotorCc);
						$('#vecotorNombre').val(vecotorNombre);
						$('#vecotorCcInsert').val(vecotorCcInsert);

						$("#tablaPropietarios tr").remove();
						
						var nuevaFila='<tr><td class="titulos" style="width:8%">Tipo Doc</td><td class="titulos" style="width:5%">Ord</td><td class="titulos" style="width:15%">Documento</td><td class="titulos">Nombre Completo del Propietario</td><td class="titulos2" style="width:8%;text-align:center;">Eliminar</td></tr>';
						
						var tablaOrd = vectorOrd.split('@@@');
						var tablarCc = vecotorCc.split('@@@');
						var tablarNombre = vecotorNombre.split('@@@');
						var tablarTipoDoc = vectorTipoDoc.split('@@@');
						$.each(tablarCc, function(index,contenido){
						    var saludo1='';
			      			if (index%2!=0) {
			      				saludo1='saludo1a';

			      			}else{
			      				saludo1='saludo2';
			      			}
					        nuevaFila+="<tr class="+saludo1+">";
				           	nuevaFila+="<td>"+tablarTipoDoc[index]+"</td>";
				           	nuevaFila+="<td>"+tablaOrd[index]+"</td>";
				           	nuevaFila+="<td>"+tablarCc[index]+"</td>";
				           	nuevaFila+="<td>"+tablarNombre[index]+"</td>";
				           	nuevaFila+="<td class='eliminar' style='text-align:center;'><a ><img src='imagenes/del.png' style='cursor:pointer;'></a></td>";
			            	nuevaFila+="</tr>";
						});
						
			            // A�adimos una columna con el numero total de columnas.
			            // A�adimos uno al total, ya que cuando cargamos los valores para la
			            // columna, todavia no esta a�adida
			            
			            $("#tablaPropietarios").append(nuevaFila);
						
						$('.eliminar').click(eliminarFila);
					}
				}
      		}
      </script>
      	<table>
			<tr>
				<td align="left" valign="top"  style="width:60%;">
				<div class="subpantalla" style="width:99.6%; overflow-x:hidden;">
					<table class="inicio" id='tablaPropietarios' style="overflow:scroll">
		       				
		        			<tr>
		                    	<td class="titulos" style="width:8%">Tipo Doc</td>
		                    	<td class="titulos" style="width:5%">Ord</td>
		                    	<td class="titulos" style="width:15%">Documento</td>
		                    	<td class="titulos">Nombre Completo del Propietario</td>
		                        <td class="titulos2" style="width:8%;text-align:center;">Eliminar</td>
		                  	</tr>
		                  	<?php
							  	$co="zebra1";
						  	  	$co2="zebra2";
							  	$tam=count($_POST[tercero]);
	      						$saludo1='saludo1a';
	      						$saludo2='saludo2';
								for($x=0; $x<$tam; $x++)
								{	
									echo "<tr class='$saludo1'>
										<td>".$_POST[doc][$x]."</td>
										<td>".$_POST[ords][$x]."</td>";
									echo "<td>".$_POST[tercero][$x]."</td>";
									echo "<td>".$_POST[ntercero][$x]."</td>
									<td class='eliminar' style='text-align:center;' ><a><img src='imagenes/del.png' style='cursor:pointer;'></a></td></tr>";
									$aux=$saludo1;
									$saludo1=$saludo2;
									$saludo2=$aux;	
									echo "<script>$('.eliminar').click(eliminarFila);</script>";
								}
									
							?>	
							
		        		</table>
		        		</div>
				</td>
				
				<td style="width:25%;" valign="top">
					<div class="subpantalla" style=" width:99.6%; overflow-x:hidden;">
					<table class="inicio">
						<tr>
							<td class="titulos" colspan="6" >Avaluos Vigencias</td>
						</tr>
						  
					    <tr>
							<td class="titulos2" >Vigencia</td>
							<td class="titulos2" >Avaluo</td>
							<td class="titulos2" >PAGO(S/N)</td>
							<td class="titulos2">Ord</td>
							<td class="titulos2">Tot</td></tr>
						</tr>
					      <?php
							  $co="zebra1";
						  	  $co2="zebra2";
							  $tam=count($_POST[dvigencias]);
								for($x=0; $x<$tam; $x++)
								{
								echo "
									<tr>
										<td class='$co' style='width:20%'>
											<input type='text' style='width:100%' name='dvigencias[]' value='".$_POST[dvigencias][$x]."' readonly>
										</td>
										<td class='$co' style='width:30%'>
											<input type='text' style='width:100%' name='davaluos[]' value='".$_POST[davaluos][$x]."' readonly>
										</td>
										<td class='$co' style='width:20%'>
											<input type='text' style='width:100%' name='dtodos[]' value='".$_POST[dtodos][$x]."' maxlength=1>
											<input type='hidden'  name='dsistema[]' value='S'>
										</td>
										<td class='$co' style='width:12%'>
											<input type='text' style='width:100%' name='dords[]' value='".$_POST[dords][$x]."' readonly>
										</td>
										<td class='$co' style='width:12%'>
											<input type='text' style='width:100%' name='dtots[]' value='".$_POST[dtots][$x]."' readonly>
										</td>
									</tr>";			
								$aux=$co;
								$co=$co2;
								$co2=$aux;	
								}
									
							?>	
					</table>
					</div>
				</td>
			</tr>

				<input id="vectorOrd" type="hidden" name="vectorOrd">
				<input id="vectorTipoDoc" type="hidden" name="vectorTipoDoc">
				<input id="vecotorCc" type="hidden" name="vecotorCc">
				<input id="vecotorNombre" type="hidden" name="vecotorNombre">

				<input id="vecotorCcEliminar" type="hidden" name="vecotorCcEliminar">
				<input id="vecotorCcInsert" type="hidden" name="vecotorCcInsert">
				
				<script>
					var vectorOrd='', vecotorCc='', vecotorNombre='', vectorTipoDoc='';

					$("#tablaPropietarios tr").each(function (index) 
					{
						if (index!=0) {
							if (index!=1) {
								vectorOrd +='@@@';
								vecotorCc +='@@@';
								vecotorNombre +='@@@';
								vectorTipoDoc +='@@@';
							}
							$(this).children("td").each(function (index2) 
							{
								switch (index2) 
								{
									case 0: 
										vectorTipoDoc += $(this).text();
										break;
									case 1: 
										vectorOrd += $(this).text();
										break;
									case 2: 
										vecotorCc += $(this).text();
										break;
									case 3: 	
										vecotorNombre += $(this).text();
										break;
								}
							});
							
						}
					});

					$('#vectorTipoDoc').val(vectorTipoDoc);
					$('#vectorOrd').val(vectorOrd);
					$('#vecotorCc').val(vecotorCc);
					$('#vecotorNombre').val(vecotorNombre);
				</script>
		</table>
		<?php 
	if($_POST[oculto]=='2' )
	{
		$vectorOrd = explode('@@@',$_POST[vectorOrd]);
		$vecotorCc = explode('@@@',$_POST[vecotorCc]);
		$vecotorNombre = explode('@@@',$_POST[vecotorNombre]);
		$vectorTipoDoc = explode('@@@',$_POST[vectorTipoDoc]);
		$vecotorCcEliminar = explode('@@@',$_POST[vecotorCcEliminar]);
		$vecotorCcInsert = explode('@@@', $_POST[vecotorCcInsert]);
		$linkbd=conectar_bd();
	 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecharesolucion],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		
		if($_POST[tipop]=='urbano')
		$esra=$_POST[estrato];
		else
		$esra=$_POST[rangos];
		
		$hoy = date("Y-m-d H:i:s");

		
		for ($i=0; $i < count($vecotorCcEliminar); $i++) { 
			//echo "if (_POST[vecotorCcEliminar]!='') { ".$_POST[vecotorCcEliminar].'<br>';
			if ($_POST[vecotorCcEliminar]!='') {
			//	echo "if (_POST[vecotorCcEliminar]!='') { <<<<<Entro>>>>>>".'<br>';
				$sqlr="SELECT * FROM tesopredios WHERE cedulacatastral='$_POST[catastral]' AND documento='$vecotorCcEliminar[$i]'";
				$resultado = mysql_query($sqlr,$linkbd);
				//si el propietario existe se elimina y se registra en el historico :)
		//		echo "if ( mysql_num_rows($resultado)>0) { ".mysql_num_rows($resultado).'<br>';
				if ( mysql_num_rows($resultado)>0) {
		//			echo "if ( mysql_num_rows($resultado)>0) { <<<<Entro>>>>>".'<br>';
					$row=mysql_fetch_row($resultado);
					$sqlr="INSERT INTO tesopredioshistorico (cedulacatastral,ord,tot,e,d,documento,nombrepropietario,direccion,ha,met2,areacon,avaluo,vigencia,estado,tipopredio,estratos,fecha,funcionario,accion,numresolucion,descripcionreso,fecharesolucion) values ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','$row[9]','$row[10]',$row[11],'$row[12]','N','$row[14]','$row[15]','$hoy','$_SESSION[cedulausu]','Cambio de Propietario','$_POST[numresolucion]','$_POST[detallecambio]','$fechaf')";
					//echo $sqlr.'<br>';
					mysql_query($sqlr,$linkbd);

					$sqlr="DELETE FROM tesopredios WHERE cedulacatastral='$_POST[catastral]' AND documento='$vecotorCcEliminar[$i]'";	
					mysql_query($sqlr,$linkbd);  
					//echo $sqlr.'<br>';
				}
				
			}
		}
	
		for ($i=0; $i < count($vecotorNombre); $i++) { 
		
			if (buscarCc($vecotorCc[$i])) {
				$sqlr="INSERT into tesopredios (cedulacatastral,ord,tot,e,d,documento,nombrepropietario,direccion,ha,met2,areacon,avaluo,vigencia,estado,tipopredio,estratos) values ('$_POST[catastral]','$vectorOrd[$i]','$_POST[tot]','','$vectorTipoDoc[$i]','$vecotorCc[$i]','$vecotorNombre[$i]','$_POST[direccion]','$_POST[ha]','$_POST[mt2]','$_POST[areac]',$_POST[avaluo],'$vigusu','S','$_POST[tipop]','$_POST[rangos]$_POST[estrato]')";
				mysql_query($sqlr,$linkbd);
				$sqlr="UPDATE tesoprediosavaluos SET areacon='$_POST[areac]' WHERE codigocatastral='$_POST[catastral]' AND vigencia='$vigusu'";
				mysql_query($sqlr,$linkbd);
				$sqlr="INSERT INTO tesopredioshistorico (cedulacatastral,ord,tot,e,d,documento,nombrepropietario,direccion,ha,met2,areacon,avaluo,vigencia,estado,tipopredio,estratos,fecha,funcionario,accion,numresolucion,descripcionreso,fecharesolucion) values ('$_POST[catastral]','$vectorOrd[$i]','$_POST[tot]','','$vectorTipoDoc[$i]','$vecotorCc[$i]','$vecotorNombre[$i]','$_POST[direccion]','$_POST[ha]','$_POST[mt2]','$_POST[areac]',$_POST[avaluo],'$vigusu','S','$_POST[tipop]','$_POST[rangos]$_POST[estrato]','$hoy','$_SESSION[cedulausu]','Nuevo Propietario','$_POST[numresolucion]','$_POST[detallecambio]','$fechaf')";
				//echo $sqlr.'<br>';
				mysql_query($sqlr,$linkbd);
			}else {
				$sqlr="SELECT * FROM tesopredios WHERE cedulacatastral='$_POST[catastral]' AND documento='$vecotorCc[$i]'";
				$res = mysql_query($sqlr,$linkbd);
				$rowaux =mysql_fetch_array($res);

				$actualiza='Se ha Actualizado: ';

				if($rowaux[ord]!=$vectorOrd[$i]){
					$actualiza.='Ord, ';
				}
				if($rowaux[d]!=$vectorTipoDoc[$i]){
					$actualiza.='Tipo Documento, ';
				}
				if($rowaux[documento]!=$vecotorCc[$i]){
					$actualiza.='Documento, ';
				}
				if($rowaux[nombrepropietario]!=$vecotorNombre[$i]){
					$actualiza.='Nombre Propietario, ';
				}
				if($rowaux[direccion]!=$_POST[direccion]){
					$actualiza.='Direccion, ';
				}
				if($rowaux[ha]!=$_POST[ha]){
					$actualiza.='Ha, ';
				}
				if($rowaux[met2]!=$_POST[mt2]){
					$actualiza.='Met2, ';
				}
				if($rowaux[areacon]!=$_POST[areac]){
					$actualiza.='Areacon, ';
				}
				if($rowaux[avaluo]!=$_POST[avaluo]){
					$actualiza.='Avaluo, ';
				}
				if($rowaux[vigencia]!=$vigusu){
					$actualiza.='Vigencia, ';
				}
				if($rowaux[tipopredio]!=$_POST[tipop]){
					$actualiza.='Tipopredio, ';
				}
				$estratos1 = $_POST[rangos].''.$_POST[estrato];
				if($rowaux[estratos]!=$estratos1){
					$actualiza.='Estratos, ';
				}
				//echo $actualiza.'<br>';
				$sqlr="UPDATE tesopredios SET ord='$vectorOrd[$i]', tot='$_POST[tot]', d='$vectorTipoDoc[$i]', documento='$vecotorCc[$i]', nombrepropietario='$vecotorNombre[$i]', direccion='$_POST[direccion]', ha='$_POST[ha]', met2='$_POST[mt2]', areacon='$_POST[areac]', avaluo=$_POST[avaluo], vigencia='$vigusu', estado='S', tipopredio='$_POST[tipop]', estratos='$_POST[rangos]$_POST[estrato]'  WHERE cedulacatastral='".$_POST[catastral]."' AND estado='S'";
				mysql_query($sqlr,$linkbd);
				$sqlr="UPDATE tesoprediosavaluos SET areacon='$_POST[areac]' WHERE codigocatastral='$_POST[catastral]' AND vigencia='$vigusu'";
				mysql_query($sqlr,$linkbd);
				$sqlr="INSERT INTO tesopredioshistorico (cedulacatastral,ord,tot,e,d,documento,nombrepropietario,direccion,ha,met2,areacon,avaluo,vigencia,estado,tipopredio,estratos,fecha,funcionario,accion,numresolucion,descripcionreso,fecharesolucion) values ('$_POST[catastral]','$vectorOrd[$i]','$_POST[tot]','','$vectorTipoDoc[$i]','$vecotorCc[$i]','$vecotorNombre[$i]','$_POST[direccion]','$_POST[ha]','$_POST[mt2]','$_POST[areac]',$_POST[avaluo],'$vigusu','S','$_POST[tipop]','$_POST[rangos]$_POST[estrato]','$hoy','$_SESSION[cedulausu]','$actualiza','$_POST[numresolucion]','$_POST[detallecambio]','$fechaf')";
				//echo $sqlr.'<br>';
				mysql_query($sqlr,$linkbd);
			}
		}

		echo "<script>document.form2.actualiza.value='1';</script>";
		
		
		$sqlr="update tesoprediosavaluos set avaluo='$_POST[avaluo]' where codigocatastral='".$_POST[catastral]."' and vigencia='$vigusu'";	  
		//	echo $sqlr.'<br>';
		mysql_query($sqlr,$linkbd);
		//******crear y actualizar predio avaluos	
		$tam=count($_POST[dvigencias]);
		for($x=0; $x<$tam; $x++)
		{
			//echo $_POST[dsistema];
			if($_POST[dsistema][$x]=='S')
			{
				$sqlr="update tesoprediosavaluos set pago='".$_POST[dtodos][$x]."' where codigocatastral='".$_POST[catastral]."' AND Vigencia='".$_POST[dvigencias][$x]."'";
				//echo $sqlr.' <-<br>';
				mysql_query($sqlr,$linkbd);
				//echo "<br>".$sqlr;
			}
			if($_POST[dsistema][$x]=='N' AND $_POST[dvigencias][$x]!="" AND $_POST[davaluos][$x]!="")
			{
				$sqlr="INSERT INTO tesoprediosavaluos (vigencia,codigocatastral,avaluo,pago,estado,tot,ord) values ('".$_POST[dvigencias][$x]."','".$_POST[catastral]."','".$_POST[davaluos][$x]."','".$_POST[dtodos][$x]."','S','".$_POST[tot]."','".$_POST[ord]."')";
				//echo $sqlr.' <-><br>';
				mysql_query($sqlr,$linkbd);
			// echo "<br>".$sqlr;
			}			 
		}
		
		echo "<script>
					document.form2.oculto.value='';
					document.form2.buscav.value='1';
					document.form2.submit();
			</script>";	 
	}
		if ($_POST[actualiza]=='1') {
			echo "<script>alert('Se ha Actualizado el Predio con Exito');</script>";
			echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado el Predio con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
		}
		?>
		
		<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
   </form>
</table>
</body>
</html>