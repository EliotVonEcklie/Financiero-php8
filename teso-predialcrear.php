<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>
<script>



function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function validar()
{
document.form2.submit();
}
</script>
<script>
function agregardetalle()
{
if(document.form2.banco.value!="" &&  document.form2.cb.value!=""  )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
</script>
<script>
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar()
{

	var avaluo = document.form2.avaluo.value;

	
	if (avaluo.indexOf(',')==-1 && avaluo.indexOf('.')==-1) {
		if (document.form2.tipop.value!=''&&document.form2.catastral.value!=''&&document.form2.avaluo.value!='' && document.form2.areac.value!=''&&document.form2.ha.value!=''&&document.form2.mt2.value!=''&&document.form2.direccion.value!='' && (document.form2.rangos.value!='' || document.form2.estrato.value!='') && document.form2.vecotorCc.value!='' && document.form2.tipop.value!='' )
	  	{
			if (confirm("Esta Seguro de Guardar"))
		  	{
			  	document.form2.oculto.value=2;
			  	document.form2.submit();
			//document.form2.action="pdfcdp.php";
		  	}
	  	}
		else{
			alert('Faltan datos para completar el registro');
			document.form2.tercero.focus();
			document.form2.tercero.select();
		}
	}else{
		alert('El avaluo no debe de tener , ni .');
	}
}
</script>
<script>
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function buscar()
 {
	// alert("dsdd");
 document.form2.buscav.value='1';
 document.form2.submit();
 }
</script>
<script src="css/programas.js"></script>
<script src="JQuery/jquery-2.1.4.min.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />


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
  <a href="teso-predialcrear.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo" title="Nuevo"/></a> 
  <a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
  <a href="#" onClick="buscar()" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a> 
  <a href="teso-gestionpredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a> </td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 ?>	
<?php
if(!$_POST[oculto])
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;
		 $_POST[tot]=0;		 
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
 <?php if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
			 
			 ?>
 <?php
if($_POST[buscav]=='1')
 {
	 $_POST[dcuentas]=array();
	 $_POST[dncuentas]=array();
	 $_POST[dtcuentas]=array();		 
	 $_POST[dvalores]=array();

	 $linkbd=conectar_bd();
	 $sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]."  and tesopredios.ord='".$_POST[ord]."'  and tesopredios.tot='".$_POST[tot]."'";
	 //echo "s:$sqlr";
	 $res=mysql_query($sqlr,$linkbd);
	 while($row=mysql_fetch_row($res))
	  {
		  //$_POST[vigencia]=$row[0];
		  $_POST[catastral]=$row[0];
		  $_POST[ord]=$row[1];
		  $_POST[tot]=$row[2];
		  $_POST[ntercero]=$row[6];
		  $_POST[tercero]=$row[5];
		  $_POST[direccion]=$row[7];
		  $_POST[ha]=$row[8];
		  $_POST[mt2]=$row[9];
		  $_POST[areac]=$row[10];
		  $_POST[avaluo]=number_format($row[11],2);
		  $_POST[tipop]=$row[14];
		  if($_POST[tipop]=='urbano')
			$_POST[estrato]=$row[15];
			else
			$_POST[rangos]=$row[15];
				// $_POST[dcuentas][]=$_POST[estrato];		
		 $_POST[dtcuentas][]=$row[1];		 
		 $_POST[dvalores][]=$row[5];
		 $_POST[buscav]="";
	  }
	  	 // echo "dc:".$_POST[dcuentas];
  }
?>     
	  <table class="inicio">
	  <tr>
	    <td class="titulos" colspan="12">Informaci&oacute;n Predio</td>
		
		</tr>
	<tr>
		<td  class="saludo1" style="width:10%;">C&oacute;digo Catastral:</td>
		<td style="width:10%;">
			<input type="hidden" value="1" name="oculto">
			<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
			<input name="catastral" type="text" id="catastral"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>" style="width:100%;" >
		</td>
				   
		<td  class="saludo1" style="width:5%;">Avaluo:</td>
		<td style="width:10%;">
			<input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>"  >
		  </td>
		  <td class="saludo1" style="width:10%;">Area Cons:</td>
		  	<td><input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" style="width:100%;"></td>
	 	<td class="saludo1" style="width:5%;">Ha:</td>
	  	<td ><input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" style="width:100%;"></td>
	  	<td class="saludo1" style="width:5%;">Mt2:</td>
	  	<td ><input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" style="width:100%;"></td>
	</tr>
	<tr>
	     <td width="119" class="saludo1">Tipo:</td>
	     <td>
	    	<select name="tipop" id='tipop' style="width:100%;">
			  	<option value="">Seleccione ...</option>
			  	<option value="urbano">Urbano</option>
			  	<option value="rural">Rural</option>
			  </select>
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
          	
		<td class="saludo1">Direcci&oacute;n:</td>
		  <td colspan="3">
			<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
			<input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" style="width:100%;"></td>
			<td class="saludo1">tot</td>
			<td>
				<input id="tot" name="tot"  value="<?php echo $_POST[tot]?>" style="width:100%;" readonly>
			</td>
        </tr> 
        
	<tr>	    
		<td  class="saludo1" style="">Documento:</td>
        <td >
			<input name="tercero" id='tercero' type="text" value="<?php echo $_POST[tercero]?>"  onKeyUp="return tabular(event,this)" style="width:80%;">
			<input type="hidden" value="0" name="bt">
          	<a href="#" onClick="mypop=window.open('terceros-ventanapredios2.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
        </td>
	      <td class="saludo1">Propietario:</td>
			  <td colspan="3">
				<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco">
				<input type="hidden" value="<?php echo $_POST[tipoDoc]?>" name="tipoDoc" id="tipoDoc">
				<input name="ntercero" type="text" id="ntercero" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly>
			</td>

			<td>
				<input type="button" name="agregar" id="agregar" value="Agregar Propietario">
			</td>

				<input id="ord" type="hidden" name="ord"   value="<?php echo $_POST[ord]?>" style="width:100%;">
				
				<input id="vectorOrd" type="hidden" name="vectorOrd">
				<input id="vectorTipoDoc" type="hidden" name="vectorTipoDoc">
				<input id="vecotorCc" type="hidden" name="vecotorCc">
				<input id="vecotorNombre" type="hidden" name="vecotorNombre">
				

      </tr>
      
      <script type="text/javascript">
      	$(document).ready(function() {

			$('#rangos').hide();
			$('#estrato').hide();
			$('#tipoEstrato').hide();

			$( "#avaluo" ).keyup(function() {
				console.log($(this).val());
			  	$('#avaluos0').val($(this).val());
			});

      		$('#tipop').change(function(event) {
      			/* Act on the event */
      			console.log($(this).val());
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

      		function eliminarFila() {
				$(this).parent().remove();
				var vectorOrd='';
				var vecotorCc='';
				var vecotorNombre='';
				var vectorTipoDoc='';
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
				
				var nuevaFila='<tr><td class="titulos" style="width:8%">Tipo Doc</td><td class="titulos" style="width:5%">Ord</td><td class="titulos" style="width:15%">Documento</td><td class="titulos">Nombre Completo</td><td class="titulos2" style="width:8%;text-align:center;">Eliminar</td></tr>';
				
				var tablaOrd = vectorOrd.split('@@@');
				var tablarCc = vecotorCc.split('@@@');
				var tablarNombre = vecotorNombre.split('@@@');
				var tablarTipoDoc = vectorTipoDoc.split('@@@');

				$('#vectorOrd').val(vectorOrd);
				$('#vecotorCc').val(vecotorCc);
				$('#vecotorNombre').val(vecotorNombre);
				$('#vectorTipoDoc').val(vectorTipoDoc);

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
			            // Añadimos una columna con el numero total de columnas.
			            // Añadimos uno al total, ya que cuando cargamos los valores para la
			            // columna, todavia no esta añadida
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

						$("#tablaPropietarios tr").remove();
						
						var nuevaFila='<tr><td class="titulos" style="width:8%">Tipo Doc</td><td class="titulos" style="width:5%">Ord</td><td class="titulos" style="width:15%">Documento</td><td class="titulos">Nombre Completo</td><td class="titulos2" style="width:8%;text-align:center;">Eliminar</td></tr>';
						
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
						
			            // Añadimos una columna con el numero total de columnas.
			            // Añadimos uno al total, ya que cuando cargamos los valores para la
			            // columna, todavia no esta añadida
			            
			            $("#tablaPropietarios").append(nuevaFila);
						
						$('.eliminar').click(eliminarFila);
					}
				}
      		}
      	});
      </script>
	  
      </table>
		<?php
  			  if($_POST[bt]=='1')
			 {				 			
			  $nresul=buscatercero($_POST[tercero]);			 
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
   				?>
			  <script>
			  document.getElementById('direccion').focus();document.getElementById('direccion').select();</script>
			  <?php

			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				alert("Tercero Incorrecto o no Existe")				   		  	
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
			?>
			
<table>
	<tr>
		<td align="left" valign="top"  style="width:65%;">
			<table class="inicio" id='tablaPropietarios' style="overflow:scroll">
       				
        			<tr>
                    	<td class="titulos" style="width:8%">Tipo Doc</td>
                    	<td class="titulos" style="width:5%">Ord</td>
                    	<td class="titulos" style="width:15%">Documento</td>
                    	<td class="titulos">Nombre Completo</td>
                        <td class="titulos2" style="width:8%;text-align:center;">Eliminar</td>
                  	</tr>
        		</table>
		</td>
		<td style="width:25%;" valign="top">
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="5" >Avaluos Vigencias</td>
				</tr>
				  
			    <tr>
					<td class="titulos2" >Vigencia</td>
					<td class="titulos2" >Avaluo</td>
				</tr>
			      <?php
				  $ages=$vigusu;
				  $con=0;
				  $co="zebra1";
			  	  $co2="zebra2";
				  for($x=$vigusu;$x>=$vigusu-5;$x--)
				  {
					echo "<tr class='$co'><td><input name='vigencias[]' type='text' style='width:100%;' value='$x' readonly></td><td><input id='avaluos$con' name='valores[]' value='".$_POST[valores][$con]."' style='width:100%;' type='text' ></td></tr>";  
					$con+=1;
					$aux=$co;
					$co=$co2;
					$co2=$aux;
				   }	  
			      ?>
			</table>
		</td>
	</tr>
</table>

	  <?php
if($_POST[oculto]=='2')
{
	$vectorOrd = explode('@@@',$_POST[vectorOrd]);
	$vecotorCc = explode('@@@',$_POST[vecotorCc]);
	$vecotorNombre = explode('@@@',$_POST[vecotorNombre]);
	$vectorTipoDoc = explode('@@@',$_POST[vectorTipoDoc]);

	//echo count($vecotorCc);
	

	$linkbd=conectar_bd();
	
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	if($_POST[tipop]=='urbano')
	$esra=$_POST[estrato];
	else
	$esra=$_POST[rangos];
	
	$error=false;
	//echo $vecotorCc[0].'<br>';
	//************** modificacion del presupuesto **************
	$sqlr="SELECT * FROM tesopredios WHERE cedulacatastral='$_POST[catastral]'";	  
		//echo $sqlr.'<br>';
	$num = mysql_num_rows(mysql_query($sqlr,$linkbd));
	if($num==0){
		$hoy = date("Y-m-d");
		for ($i=0; $i < count($vecotorCc); $i++) { 
			$ords='';
			if ($i<9) {
				$ords='00'.($i+1);
			}else if($i<99){
				$ords='0'.($i+1);
			}else{
				$ords=''.($i+1);
			}
			$sqlr="insert into tesopredios (cedulacatastral,ord,tot,e,d,documento,nombrepropietario,direccion,ha,met2,areacon,avaluo,vigencia,estado,tipopredio,estratos) values ('$_POST[catastral]','$ords','$_POST[tot]','','$vectorTipoDoc[$i]','$vecotorCc[$i]','$vecotorNombre[$i]','$_POST[direccion]','$_POST[ha]','$_POST[mt2]','$_POST[areac]',$_POST[avaluo],'$vigusu','S','$_POST[tipop]','$_POST[rangos]$_POST[estrato]')";	  
			//echo $sqlr.'<br>';
			if (!mysql_query($sqlr,$linkbd))
			{
				$error=true;
			}
			
			$sqlr="INSERT INTO tesopredioshistorico (cedulacatastral,ord,tot,e,d,documento,nombrepropietario,direccion,ha,met2,areacon,avaluo,vigencia,estado,tipopredio,estratos,fecha,funcionario,accion) values ('$_POST[catastral]','$vectorOrd[$i]','$_POST[tot]','','$vectorTipoDoc[$i]','$vecotorCc[$i]','$vecotorNombre[$i]','$_POST[direccion]','$_POST[ha]','$_POST[mt2]','$_POST[areac]',$_POST[avaluo],'$vigusu','S','$_POST[tipop]','$_POST[rangos]$_POST[estrato]','$hoy','$_SESSION[cedulausu]','Insertar')";
			//echo $sqlr.'<br>';
			mysql_query($sqlr,$linkbd);

			
		}
		if ($error)
		{
			 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
			 $e =mysql_error($respquery);
			 echo "Ocurrió el siguiente problema:<br>";
		  	 //echo htmlentities($e['message']);
		  	 echo "<pre>";
		     ///echo htmlentities($e['sqltext']);
		    // printf("\n%".($e['offset']+1)."s", "^");
		     echo "</pre></center></td></tr></table>";
		}else {
		  	echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Creado el Predio con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
		  	$tam=count($_POST[valores]);
		  	for($i=0;$i<$_POST[tot];$i++)
		    {
			  	
			   $ords='';
			   if ($i<9) {
				   $ords='00'.($i+1);
			   }else if($i<99){
				   $ords='0'.($i+1);
			   }else{
				   $ords=''.($i+1);
			   }				 
				
			 for($x=0;$x<$tam;$x++)
			 {
				 if($_POST[valores]>0)
				 {	
					 $sqlr="insert into tesoprediosavaluos (vigencia, codigocatastral,avaluo,pago,estado,tot,ord) values ('".$_POST[vigencias][$x]."','".$_POST[catastral]."',".$_POST[valores][$x].",'N','S','$_POST[tot]','$ords')";
					 //echo $sqlr.'<br>';
					 mysql_query($sqlr,$linkbd);
				 }
			 }
			}

		}
	}else{
		$_POST[tot]=0;
		echo "<table class='inicio' id='mensaje'>
				<tr>	
					<td class='saludo1'>	
						<center>
						<font color=blue><img src='imagenes\alert.png'> 
						El Predio ya Existe<font size=1>
						</font></br>";
			 
		  	 //echo htmlentities($e['message']);
		  	 echo "<pre>";
		     ///echo htmlentities($e['sqltext']);
		    // printf("\n%".($e['offset']+1)."s", "^");
		     echo "</pre></center></td></tr></table>";
	}
$_POST[tot]=0;
$_POST[tipop]='';
$_POST[estrato]='';
$_POST[rangos]='';
}
?>	
		<script type="text/javascript">
		$('#acptar1').click(function(event) {
			$('#mensaje').hide();
		});
		</script>
   </form>
</table>
</body>
</html>