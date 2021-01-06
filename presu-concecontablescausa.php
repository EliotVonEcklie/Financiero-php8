<!--V 1000 14/12/16 -->
<?php
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	$linkbdV2=conectar_v7();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="botones.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script src="JQuery/jquery-2.1.4.min.js"></script>
        <script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<style>
		.c9 input[type="checkbox"]:not(:checked),
		.c9 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c9 input[type="checkbox"]:not(:checked) +  #t9,
		.c9 input[type="checkbox"]:checked +  #t9 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c9 input[type="checkbox"]:not(:checked) +  #t9:before,
		.c9 input[type="checkbox"]:checked +  #t9:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: -2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c9 input[type="checkbox"]:not(:checked) +  #t9:after,
		.c9 input[type="checkbox"]:checked + #t9:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c9 input[type="checkbox"]:not(:checked) +  #t9:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c9 input[type="checkbox"]:checked +  #t9:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c9 input[type="checkbox"]:disabled:not(:checked) +  #t9:before,
		.c9 input[type="checkbox"]:disabled:checked +  #t9:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c9 input[type="checkbox"]:disabled:checked +  #t9:after {
		  color: #999 !important;
		}
		.c9 input[type="checkbox"]:disabled +  #t9 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c9 input[type="checkbox"]:checked:focus + #t9:before,
		.c9 input[type="checkbox"]:not(:checked):focus + #t9:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c9 #t9:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t9{
			background-color: white !important;
		}
		
		
		
		.c10 input[type="checkbox"]:not(:checked),
		.c10 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c10 input[type="checkbox"]:not(:checked) +  #t10,
		.c10 input[type="checkbox"]:checked +  #t10 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c10 input[type="checkbox"]:not(:checked) +  #t10:before,
		.c10 input[type="checkbox"]:checked +  #t10:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: -2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c10 input[type="checkbox"]:not(:checked) +  #t10:after,
		.c10 input[type="checkbox"]:checked + #t10:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c10 input[type="checkbox"]:not(:checked) +  #t10:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c10 input[type="checkbox"]:checked +  #t10:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c10 input[type="checkbox"]:disabled:not(:checked) +  #t10:before,
		.c10 input[type="checkbox"]:disabled:checked +  #t10:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c10 input[type="checkbox"]:disabled:checked +  #t10:after {
		  color: #999 !important;
		}
		.c10 input[type="checkbox"]:disabled +  #t10 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c10 input[type="checkbox"]:checked:focus + #t10:before,
		.c10 input[type="checkbox"]:not(:checked):focus + #t10:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c10 #t10:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t10{
			background-color: white !important;
		}
</style>
<script>
		function validatipo(e){
			var id=e.id;
			var valor = document.form2.finaliza10.checked;
			if(id=='finaliza9'){
				document.form2.finaliza10.checked=false;
				ocultar();
			}else if(id=='finaliza10'){
				 document.form2.finaliza9.checked=false;
				 mostrar();
			}
			if(valor == false)
			{
				ocultar();
			}
		 }
function guardar()
{
	if (document.form2.numero.value!='' && document.form2.nombre.value!='')
  		{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
 	else{alert('Faltan datos para completar el registro');document.form2.numero.focus();document.form2.numero.select();}
 }

function clasifica(formulario)
{
	//document.form2.action="presu-recursos.php";
	document.form2.submit();
}

function agregardetalle()
{
	if(document.getElementById('fecha1').value!='')
	{
		if(document.form2.cuenta.value!=""  && document.form2.cc.value!="" ){document.form2.agregadet.value=1;document.form2.submit();}
		else {alert("Falta informacion para poder Agregar");}
	}
	else
	{
		alert('Falta digitar la Fecha');
	}
}

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

function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1'; document.form2.submit();}}
function buscacc(e){if (document.form2.cc.value!=""){document.form2.bcc.value='1';document.form2.submit();}}

function validar2()
{
	//alert("Balance Descuadrado");
	document.form2.oculto.value=2;
	document.form2.action="presu-concecontablescausa.php";
	document.form2.submit();
}

function validar(){document.form2.submit();}
function validar3(formulario)
			{
				document.form2.action="presu-concecontablescausa.php";
				document.form2.submit();
			}
			
			function despliegamodal2(_valor,v)
			{
				if (document.form2.fecha1.value!='')
				{
					document.getElementById("bgventanamodal2").style.visibility=_valor;
					if(_valor=="hidden"){
						document.getElementById('ventana2').src="";
						document.form2.submit();
					}
					else {
						if(v==1){
							document.getElementById('ventana2').src="cuentasin-ventana1.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==2)
						{
							document.getElementById('ventana2').src="cuentas-ventana2.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==3)
						{
							document.getElementById('ventana2').src="cuentas-ventana3.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==4)
						{
							document.getElementById('ventana2').src="cuentas-ventana4.php?fecha="+document.form2.fecha1.value;
						}
					}
				}
				else
				{
					alert ("Falta digitar la fehca");
				}
			}
			function ocultar(){
				document.getElementById('obj1').style.display = 'none';
			}
			function mostrar(){

				document.getElementById('obj1').style.display = 'block';
			}
</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("cont");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a href="presu-concecontablescausa.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a href="presu-buscaconcecontablescausa.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="presu-concecontables.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
        	</tr>
        </table>
<?php
$vigencia=date(Y);
$linkbd=conectar_bd();
 ?>	
<?php
if($_POST[oculto]=="")
{	
 	 	 $_POST[vigencia]=$vigencia;
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		
		  $sqlr="select MAX(codigo) from conceptoscontables where modulo=3 and tipo='C' order by codigo Desc";
		 //echo $sqlr;
		  $res=mysql_query($sqlr);
		  $row=mysql_fetch_row($res);
		  $_POST[numero]=$row[0]+1;
		  if(strlen($_POST[numero])==1)
		   {
			   $_POST[numero]='0'.$_POST[numero];
			}
}
?>
 <form name="form2" method="post" action=""> 
<?php //**** busca cuenta
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
			  //**** busca centro costo
  			if($_POST[bcc]=='1')
			 {
			  $nresul=buscacentro($_POST[cc]);
			  if($nresul!='')
			   {
			  $_POST[ncc]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncc]="";
			  }
			 }
			 ?>
    <table class="inicio" align="center"  >
      	<tr>
			<td class="titulos" colspan="8" style='width:93%'>.: Concepto Contable de Gastos</td>
			<td class="cerrar" style='width:7%'><a href="presu-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
			<td style="width:10%" class="saludo1">Codigo:</td>
          	<td style="width:8%" valign="middle" >
				<input type="text" id="numero" name="numero" style="width:80%" onKeyPress="javascript:return solonumeros(event)" 		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();">
			</td>
		 	<td style="width:10%" class="saludo1">Nombre:</td>
          	<td style="width:36%" valign="middle" ><input type="text" id="nombre" name="nombre" style="width:96%"
		  	onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td><td class="saludo1">Tipo:</td><td><input name="tipo" value="Gasto" size="10" type="text"><input name="tipoc" value="C" size="10" type="hidden"></td><td class="saludo1">Almacen:</td><td><input name="almacen" id="almacen"  type="checkbox" style="max-height: 15px" <?php if(!empty($_POST[almacen])){echo "checked "; }?> ></td>
	    </tr>
		<tr>
			<td class="saludo1">Correlacion:</td>
			<td colspan="2" style="background-color: #79EEFE !important;">

				<div style="display:inline-block; background-color: #79EEFE !important;margin-left: 14%">
					<label style="background-color: #79EEFE !important">Principal</label>
				</div>
				<div class="c9" style="display:inline-block; border-right: 1px solid gray">
					<input type="checkbox" id="finaliza9" name="finaliza9" <?php if(isset($_POST['finaliza9'])){echo "checked";} ?> value="<?php echo $_POST[finaliza9]?>"  onChange="validatipo(this)"/><label for="finaliza9" id="t9" ></label>
				</div>
				
				<div style="display:inline-block; background-color: #79EEFE !important;margin-right: 1% ">
					<label style="background-color: #79EEFE !important">Asociado a:</label>
				</div>
				<div class="c10" style="display:inline-block; ">
					<input type="checkbox" id="finaliza10" name="finaliza10" <?php if(isset($_POST['finaliza10'])){echo "checked";} ?> value="<?php echo $_POST[finaliza10]?>"  onChange="validatipo(this)"/><label for="finaliza10" id="t10" ></label>
				</div>
				
			</td>
			<td>
				 <?php
				 	$noMuestra = "";
					 if(isset($_POST['finaliza10']))
					 {
						 ?>
						 <script> document.getElementById('obj1').style.display = 'block';</script>
						 <?php
					 }
					 else
					 {
						?>
						<script> document.getElementById('obj1').style.display = 'none';</script>
						<?php
						$noMuestra = "style='display:none'";
					 }
				 ?>
			 	<div id='obj1' <?php echo $noMuestra; ?>>
					<select name="conceptoContableHermano" style="width:96%;" onChange="validar()" onKeyUp="return tabular(event,this)">
						<option value="">Seleccione ...</option>
						<?php
						$linkbd=conectar_bd();
						$sqlr="SELECT C.codigo, C.nombre FROM conceptoscontables C, conceptoscontableshermanos CH WHERE C.modulo = '3' AND C.tipo='C' AND C.codigo = CH.codigo  AND C.modulo = CH.modulo AND CH.tipo = C.tipo AND CH.principal='1'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							if("$row[0]"==$_POST[conceptoContableHermano]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
							else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";} 
						}	 	
						?>
					</select>
				 </div>
			</td>
		</tr>
    </table>
	<table class="inicio">
	<tr><td colspan="6" class="titulos2">Crear Detalle Concepto</td></tr>
	<tr>
			<td class="saludo1" style="width:10%">Fecha Inicial:</td>
			<td style="width:10%;">
				<input name="fecha1" id="fecha1" type="text" id="fecha1" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha1');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
			</td>  
			<td class="saludo1">Cuenta: </td>
          <td  valign="middle" >
			<input name="cuenta" id="cuenta" type="text"  value="<?php echo $_POST[cuenta]?>" onKeyUp="return tabular(event,this) " style="width:75%;" onBlur="validar3()">
				<input name="cuenta_" type="hidden" value="<?php echo $_POST[cuenta_]?>">&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',1);" title="Buscar cuenta" class="icobut" />
		  </td><td >
		  <input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="70" readonly>
		  <input type="hidden" value="<?php echo $_POST[defecto]?>" name="defecto" id="defecto">
		  </td>
	</tr>
	<tr>
	<td class="saludo1">Tipo:</td><td><select style="width:90%;" name="debcred">
		   <option value="1" <?php if($_POST[debcred]=='1') echo "SELECTED"; ?>>Debito</option>
     
		  </select></td>
		  <td class="saludo1">CC:</td><td>
	<select name="cc" style="width:85%;" onChange="validar()" onKeyUp="return tabular(event,this)">
	<?php
	
	$linkbd=conectar_bd();
	$sqlr="select *from centrocosto where estado='S' ORDER BY ID_CC";
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
		  <td><input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet">
		  <?php
		if (!$_POST[oculto])
		 {
		 ?>
		<script>
    	//document.form2.cc.focus();
		</script>	
		<?php
		}
		
		if($_POST[bc]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('debcred').focus();</script>
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
	 //*** centro  costo
			 if($_POST[bcc]=='1')
			 {
			  $nresul=buscacentro($_POST[cc]);
			  if($nresul!='')
			   {
			  $_POST[ncc]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuenta').focus();document.getElementById('cuenta').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncc]="";
			  ?>
			  <script>alert("Centro de Costos Incorrecto");document.form2.cc.focus();</script>
			  <?php
			  }
			 }
		
		?>
		  <input type="hidden" value="0" name="oculto">	
		  </td>
	
        </tr>
	<tr>
	
	</tr>
	<tr>
	
	</tr>
	</table>
    <div class="subpantalla" style="height:50%; width:99.6%; overflow-x:hidden;">
	<table class="inicio">
	<tr><td class="titulos" colspan="7">Detalle Concepto</td></tr>
	<tr><td class="titulos2">Fecha</td><td class="titulos2">CC</td><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Debito</td><td class="titulos2">Credito</td><td class="titulos2" style='text-align:center;'><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
	<?php
			 
	if ($_POST[elimina]!='')
		 { 
		 $posi=$_POST[elimina];
		 unset($_POST[dcuentas][$posi]);
 		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dccs][$posi]);
		 unset($_POST[fecha][$posi]);
		 unset($_POST[dcreditos][$posi]);		 		 		 		 		 
		 unset($_POST[ddebitos][$posi]);		 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 $_POST[fecha]= array_values($_POST[fecha]);
		 $_POST[dcreditos]= array_values($_POST[dcreditos]); 
		 $_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
		 }
	
	if ($_POST[agregadet]=='1')
		 {
		  $cuentacred=0;
		  $cuentadeb=0;
		  $diferencia=0;
		 $_POST[dcuentas][]=$_POST[cuenta];
		 $_POST[dncuentas][]=$_POST[ncuenta];
		 $_POST[dccs][]=$_POST[cc];	
		 $_POST[fecha][]=$_POST[fecha1];
		 if ($_POST[debcred]==1)
		  {
		  $_POST[dcreditos][]='N';
		  $_POST[ddebitos][]="S";
	 	  }
		 else
		  {
		  $_POST[dcreditos][]='S';
		  $_POST[ddebitos][]="N";
		  }
		 $_POST[agregadet]=0;
		  ?><script>
		  		//document.form2.cuenta.focus();	
				document.form2.cc.select();
				document.form2.cc.value="";
		 </script><?php
		 }
		 $iter='saludo1a';
		 $iter2='saludo2';
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {
			 echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
			 <td><input name='fecha[]' value='".$_POST[fecha][$x]."' class='inpnovisibles' type='text' size='8'></td>
			 <td><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='2' class='inpnovisibles' readonly></td>
			 <td><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='8' class='inpnovisibles' readonly></td>
			 <td><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='70' class='inpnovisibles' readonly></td>
			 <td><input name='ddebitos[]' value='".$_POST[ddebitos][$x]."' type='text' size='3' onDblClick='llamarventanadeb(this,$x)' class='inpnovisibles' readonly></td>
			 <td ><input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text' size='3' onDblClick='llamarventanacred(this,$x)' class='inpnovisibles' readonly></td>
			 <td style='text-align:center;'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 	$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
		 }	 
		 ?>
	</table>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2')	
	{
		$almacen="N";

		if(!empty($_POST[almacen])){
			$almacen="S";
		}

		$sqlrDelete = "DELETE FROM conceptoscontableshermanos WHERE codigo='$_POST[numero]'";
		mysqli_query($linkbdV2,$sqlrDelete);
		if(isset($_POST[finaliza9]))
		{
			$sql = "INSERT INTO conceptoscontableshermanos (codigo, modulo, tipo, principal,usuario) VALUES ('$_POST[numero]','3','$_POST[tipoc]', '1','".$_SESSION['nickusu']."')";
			mysqli_query($linkbdV2,$sql);
		}
		else if(isset($_POST[finaliza10]))
		{
			$sql = "INSERT INTO conceptoscontableshermanos (codigo, modulo, tipo, asociado_a,usuario) VALUES ('$_POST[numero]','3','$_POST[tipoc]', '".$_POST['conceptoContableHermano']."','".$_SESSION['nickusu']."')";
			mysqli_query($linkbdV2,$sql);
		}



		//rutina de guardado cabecera
		$linkbd=conectar_bd();

		$sqlr="insert into conceptoscontables (codigo,nombre,modulo,tipo) values ('$_POST[numero]','$_POST[nombre]','3','$_POST[tipoc]')";
		if(!mysql_query($sqlr,$linkbd))
		{
			echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado con Exito El Concepto Contable, Error: $sqlr </center></td></tr></table>";
		}
		else
		{
			echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado con Exito El Concepto Contable</center></td></tr></table>";
		}
		//**** crear el detalle del concepto
		for($x=0;$x<count($_POST[dcuentas]);$x++) 
		{
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha][$x],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			$sqlr="insert into conceptoscontables_det (codigo,tipo,tipocuenta,cuenta,cc,debito,credito,estado,modulo,fechainicial) values ('$_POST[numero]','$_POST[tipoc]','N','".$_POST[dcuentas][$x]."','".$_POST[dccs][$x]."','".$_POST[ddebitos][$x]."','".$_POST[dcreditos][$x]."','S','3','$fechaf')";
			$res=mysql_query($sqlr,$linkbd);
		}

	}
	?>	
    </div>
</form>
<script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('¿Realmente desea cambiar la vigencia?');
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
<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
</body>
</html>