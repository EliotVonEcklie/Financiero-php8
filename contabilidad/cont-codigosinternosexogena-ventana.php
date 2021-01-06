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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			var anterior;
			function ponprefijo(pref,pos)
            {
				parent.document.getElementsByName('conexogena[]').item(pos).value = pref;
				parent.despliegamodal3("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<?php
		    $_POST[posicion]=$_GET[pos];
		?>
	<form action="" method="post" enctype="multipart/form-data" name="form1">
		<table class="inicio">
			<tr >
				<td height="25" colspan="4" class="titulos" >Buscar Codigos internos</td>
				<td class="cerrar"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
			</tr>
			<tr>
				<td colspan="5" class="titulos2" >:&middot; Por Descripcion </td>
			</tr>
			<tr>
				<td class="saludo1" style="width:10%;">:&middot; Codigo:</td>
				<td  style="width:50%;">
                    <input name="numero" style="width:100%;" type="text" >
					<input type="hidden" name="tipo"  id="tipo" value="<?php echo $_POST[tipo]?>" >
					<input type="hidden" name="oculto" id="oculto" value="1" >
					
				</td>
                <td style="width:10px;"><input type="submit" name="Submit" value="Buscar" ></td>
			</tr>
		</table>
		<div class="subpantalla" style="height:73.5%; width:99.6%; overflow-x:hidden;">
			<table class="inicio">
				<tr >
					<td height="25" colspan="5" class="titulos" >Resultados Busqueda </td>
				</tr>
				<tr >
					<td width="32" class="titulos2" >Item</td>
					<td width="76" class="titulos2" >Codigo </td>
					<td width="140" class="titulos2" >Nomber</td>
					<td width="140" class="titulos2" >Estado</td>	  	  
				</tr>
				<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
				$oculto=$_POST['oculto'];
                $link=conectar_bd();
                $cond="and  (codigo like'%".$_POST[numero]."%' or nombre like '%".($_POST[numero])."%')";
                
                $sqlr="Select distinct contcodigosinternos.* from contcodigosinternos where  estado='S' $cond ORDER BY codigo ASC ";
                $resp = mysql_query($sqlr,$link);			
                $co='saludo1a';
                $co2='saludo2';	
                $i=1;
                while ($r =mysql_fetch_row($resp)) 
                {
                    echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" "; 
                    echo" onClick=\"javascript:ponprefijo('$r[1]','$_POST[posicion]')\"";
                    echo"><td>$i</td>
                    <td >$r[1]</td>
                    <td>".ucwords(strtolower($r[2]))."</td>
                    <td>".ucwords(strtolower($r[3]))."</td></tr>";
                    $aux=$co;
                    $co=$co2;
                    $co2=$aux;
                    $i=1+$i;
                }
                $_POST[oculto]="";
				?>
			</table>
		</div>
	</form>
</body>
</html> 
