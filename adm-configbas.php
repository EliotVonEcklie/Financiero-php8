<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	sesion();
	$_SESSION["usuario"] ;
	$_SESSION["perfil"] ;
	$_SESSION["linkset"] ;
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
		<title>:: :: Spid - Meci Calidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function habilitar(chkbox) 
			{ 
				habdesv=document.getElementsByName('habdes[]');
				chks=document.getElementsByName('asigna[]');
				for (var i=0;i < cali.length;i++) 
				{ 
 					if(chks.item(i)==chkbox)
  					{
   						if (chkbox.checked==true){habdesv.item(i).value="1";}
						else{habdesv.item(i).value="0";}

  					}
				}
			} 
			function validar(formulario){document.form2.submit();}
			function buscater(e){if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}}
			function guardar()
			{
				if (document.form2.razon.value!='')
  					{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
  				else
				{
  					alert('Faltan datos para completar el registro');
  					document.form2.razon.focus();
  					document.form2.razon.select();
  				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("meci");?></tr>
        	<tr>
  				<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
         	</tr>
		</table>
		<form name="form2" method="post" >
		<?php
			if($_POST[oculto]=="")
 			{
  				$sqlr="Select * from configbasica";
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{	
					$_POST[nit]=$row[0];
				   	$_POST[razon]=$row[1];
				   	$_POST[direccion]=$row[2];
				   	$_POST[telefono]=$row[3];
				   	$_POST[web]=$row[4];
				   	$_POST[email]=$row[5];
				  	$_POST[ntercero]=$row[6];
				   	$_POST[estado]=$row[7];
				   	$_POST[contaduria]=$row[8];
				   	$_POST[igac]=$row[9];
				   	$_POST[sigla]=$row[10];
				   	$_POST[liquidacion]=$row[11];
				   	$_POST[orden]=$row[12];
				   	$_POST[tercero]=$row[13];
				   	$_POST[dpto]=$row[14];
				   	$_POST[mnpio]=$row[15];										 					 
				}
 			}
	 		if($_POST[bt]=='1')
			{
				$nresul=buscatercero($_POST[tercero]);
			  	$_POST[regimen]=buscaregimen($_POST[tercero]);	
			  	if($nresul!='')
			   	{
			  		$_POST[ntercero]=$nresul;
  					if($_POST[regimen]==1){$_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);}	
				 	else{$_POST[iva]=0;}
				 	$_POST[base]=$_POST[valor]-$_POST[iva];				 
			  	}
			 	else{$_POST[ntercero]="";}
			}
		?>
  		<table width="60%" class="inicio" align="center" >
    		<tr>
              <td class="titulos" colspan="8" style='width:93%'>Configuracion Entidad</td>
              <td class='cerrar' style='width:7%'><a href='meci-principal.php'>Cerrar</a></td>
    </tr>
    <tr >
      <td class="saludo1" style='width:8%'>Razon Social: </td>
      <td style='width:16%'><input name="razon" type="text" id="razon" value="<?php echo $_POST[razon] ?>" style='width:100%'></td>
      <td class="saludo1" style='width:8%'>Nit:</td>
      <td style='width:16%'><input name="nit" type="text" id="nit"  value="<?php echo $_POST[nit] ?>" style='width:100%'></td>
      <td class="saludo1" style='width:8%'>Sigla:</td>
      <td style='width:8%'><input name="sigla" type="text" id="sigla"  value="<?php echo $_POST[sigla] ?>" style='width:100%'></td>
      <td class="saludo1" style='width:8%'>Direccion:</td>
      <td><input name="direccion" type="text" id="direccion"  value="<?php echo $_POST[direccion] ?>" style='width:100%'></td>
    </tr>  
    <tr >
      <td class="saludo1" >Dpto: </td>
      <td><select name="dpto" id="dpto" onChange="validar()" style='width:100%'>
                    <option value="-1">:::: Seleccione Departamento :::</option>
            <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from danedpto order by nombredpto";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
echo "<option value=$row[1] ";
					$i=$row[1];
					 if($i==$_POST[dpto])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[2]."</option>";	  
					}
  
		  ?>
          </select></td>
      <td class="saludo1">Municipio:</td>
      <td><select name="mnpio" id="mnpio" style='width:100%'>
			<option value="-1">:::: Seleccione Municipio ::::</option>
              <?php
  		   $sqlr="Select * from danemnpio where  danemnpio.danedpto=".$_POST[dpto]." order by nom_mnpio";
		  					$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
echo "<option value=$row[2] ";
					$i=$row[2];
					 if($i==$_POST[mnpio])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[3]."</option>";	  
					}
		?>        
        </select><input name="oculto" type="hidden" value="1"></td>
      <td class="saludo1">Telefonos:</td>
      <td><input name="telefono" type="text" id="telefono"  value="<?php echo $_POST[telefono] ?>" style='width:100%'></td>
      <td class="saludo1">Email:</td>
      <td><input name="email" type="text" id="email"  value="<?php echo $_POST[email] ?>" style='width:100%'></td>
    </tr>    
     <tr >
      <td class="saludo1" >Web: </td>
      <td><input name="web" type="text" id="web"  value="<?php echo $_POST[web] ?>" style='width:100%'></td>
      <td class="saludo1">IGAC:</td>
      <td><input name="igac" type="text" id="igac"  value="<?php echo $_POST[igac] ?>" style='width:100%'></td>
      <td class="saludo1">Cod CGR:</td>
      <td><input name="contaduria" type="text" id="contaduria"  value="<?php echo $_POST[contaduria] ?>" style='width:100%'></td>
      <td class="saludo1">Orden:</td>
      <td><select name="orden" onKeyUp="return tabular(event,this)" style='width:100%'>
       <option value="">Seleccione ...</option>
				  <option value="Nacional" <?php if($_POST[orden]=='Nacional') echo "SELECTED"?>>Nacional</option>
  				  <option value="Dptal" <?php if($_POST[orden]=='Dptal') echo "SELECTED"?>>Dptal</option>
        	  	  <option value="Mnpal" <?php if($_POST[orden]=='Mnpal') echo "SELECTED"?>>Mnpal</option>
				  </select></td>
    </tr>  
       <tr >
      <td class="saludo1" >Liquidacion: </td>
      <td><select name="liquidacion" onKeyUp="return tabular(event,this)" style='width:100%'>
       <option value="">Seleccione ...</option>
				  <option value="S" <?php if($_POST[liquidacion]=='S') echo "SELECTED"?>>SI</option>
  				  <option value="N" <?php if($_POST[liquidacion]=='N') echo "SELECTED"?>>NO</option>
				  </select></td>
      <td class="saludo1">Cedula Rep Legal:</td>
      <td><input id="tercero" type="text" name="tercero"  onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style='width:80%'><input type="hidden" value="0" name="bt"><a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();">&nbsp;<img src="imagenes/buscarep.png" style='width:16px'></a></td>
      <td class="saludo1">Rep Legal:</td>
      <td colspan="3"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>"  readonly style='width:100%'></td>
    </tr>  
      </table>
      <?php
	  if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  $_POST[regimen]=buscaregimen($_POST[tercero]);	
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
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
<?php
$oculto=$_POST[oculto];
if($oculto=="2")
{
$linkbd=conectar_bd();
$sqlr="delete from configbasica";
mysql_query($sqlr,$linkbd);
$sqlr="insert into configbasica (nit, razonsocial, direccion, telefono, web, email, representante, estado, codcontaduria, igac, sigla, liquidacion, orden, cedulareplegal, depto, mnpio) values('$_POST[nit]', '$_POST[razon]', '$_POST[direccion]', '$_POST[telefono]', '$_POST[web]', '$_POST[email]', '$_POST[ntercero]', 'S', '$_POST[contaduria]', '$_POST[igac]', '$_POST[sigla]', '$_POST[liquidacion]', '$_POST[orden]', '$_POST[tercero]', '$_POST[dpto]', '$_POST[mnpio]')";
//$resp=oci_parse ($linkbd, $sqlr);
//oci_execute ($resp);
//echo $sqlr."<br>";
if(!mysql_query($sqlr,$linkbd))
 {
echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Actualizado la informacion <img src='imagenes/alert.png'></center></td></tr></table>";
 }
 else
 {
echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";	 
 }
//oci_free_statement($resp);
//oci_close($linkdb);
}
?>
</form>
</td></tr>   
</table>
</body>
</html>