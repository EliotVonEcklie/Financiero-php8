<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		<script>
        
        </script>
		<script type="text/javascript" src="css/programas.js"></script>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
	<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("plan");?></tr>
            <tr>
  				<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add2.png" border="0" /></a><a href="#"  class="mgbt"><img src="imagenes/guardad.png"/></a><a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" id="impre" class="mgbt"><img src="imagenes/print_off.png" alt="Imprimir" style="width:30px;"/></a></td>
			</tr>
		</table>	
 		<form name="form2" method="post" action="plan-informegestioncontratos.php">
		<table  class="inicio" align="center" >
      		<tr>
        		<td class="titulos" colspan="5">:: Buscar Procesos de Contratacion </td>
        		<td  class="cerrar" ><a href="plan-principal.php">Cerrar</a></td>
      		</tr>
      		<tr>
        		<td class="saludo1" style="width:10%" >N&deg; Proceso:</td>
        		<td style="width:10%"><input type="text" name="documento" id="documento" value="" style="width:95%"></td>
                <td class="saludo1" style="width:10%" >N&deg; Contrato:</td>
        		<td style="width:10%"><input type="text" name="contrato"  id="contrato" value="" style="width:100%"></td>
                <td></td>
                <input name="oculto" type="hidden" value="1">
       		</tr>                       
    	</table>
    	<div class="subpantallac5">
    	<?php 
		$oculto=$_POST['oculto'];
		if($_POST[oculto])
		{
			$linkbd=conectar_bd();
			$crit1=" ";
			$crit2=" ";
			if ($_POST[documento]!=""){$crit1=" and idproceso LIKE '$_POST[documento]' ";}
			if ($_POST[contrato]!=""){$crit2=" and contrato LIKE '%$_POST[contrato]%' ";}
			//sacar el consecutivo 
			$sqlr="SELECT * FROM contraprocesos WHERE estado<>'' ".$crit1.$crit2." ORDER BY idproceso";
			$resp = mysql_query($sqlr,$linkbd);
			$ntr = mysql_num_rows($resp);
			$con=1;
			echo "
				<table class='inicio' align='center' width='80%'>
					<tr>
						<td colspan='16' class='titulos'>.: Resultados Busqueda:</td>
					</tr>
					<tr class='saludo3'>
						<td colspan='16'>Encontrados: $ntr</td>
					</tr>
					<tr>
						<td class='titulos2' style='width:4%' rowspan='2'>Proceso</td>
						<td class='titulos2' style='width:6%' rowspan='2'>Fecha</td>
						<td class='titulos2' style='width:4%' rowspan='2'>Vigencia</td>
						<td class='titulos2' style='width:27%' rowspan='2'>Objeto</td>
						<td class='titulos2' style='width:8%' rowspan='2'>Modalidad</td>
						<td class='titulos2' style='width:8%' rowspan='2'>Procedimiento</td>
						<td class='titulos2' style='width:8%' rowspan='2'>Tipo Contrato</td>
						<td class='titulos2' style='width:7%' rowspan='2'>N&deg; Contrato</td>
						<td class='titulos2' style='width:5%' rowspan='2'>CDP</td>
						<td class='titulos2' style='width:10%; text-align:center;' colspan='4'>Fase Contractuales</td>
						<td class='titulos2' style='width:3%; text-align:center;' rowspan='2'>Cuentas Por Pagar</td>
						<td class='titulos2' style='width:7%; text-align:center;' rowspan='2'>Egreso</td>
						<td class='titulos2' style='width:3%' rowspan='2'>Estado</td>
					</tr>
					<tr>
						<td class='titulos2' title='Datos Precontractuales'>DP</td>
						<td class='titulos2' title='Anexos Precontractuales'>AP</td>
						<td class='titulos2' title='Datos Contrataci&oacute;n'>DC</td>
						<td class='titulos2' title='Anexos Contrataci&oacute;n'>AC</td>
					</tr>";	
					
			$iter='saludo1';
			$iter2='saludo2';
 			while ($row =mysql_fetch_row($resp)) 
 			{	
				$modalidad= buscar_dominio('MODALIDAD_SELECCION',$row[4],'','S','DESCRIPCION_VALOR');
				$smodalidad= buscar_dominio('MODALIDAD_SELECCION',$row[5],$row[4],'S','DESCRIPCION_VALOR');
				$sqlrcl="SELECT nombre FROM contraclasecontratos where id='$row[6]'";
				$rowcl =mysql_fetch_row(mysql_query($sqlrcl,$linkbd));
				$sqlrsf="SELECT * FROM contraestadosemf where idcontrato='$row[0]'";
				$rowsf =mysql_fetch_row(mysql_query($sqlrsf,$linkbd));
				$cmrojo="src='imagenes/sema_rojoON.jpg'";
				$cmamarillo="src='imagenes/sema_amarilloON.jpg' title='Informaci&oacute;n Incompleta'";
				$cmverde="src='imagenes/sema_verdeON.jpg' title='Informaci&oacute;n Completa'";
				$cmamarilloa="src='imagenes/sema_amarilloON.jpg' title='Anexos Incompletos'";
				$cmverdea="src='imagenes/sema_verdeON.jpg' title='Anexos Completos'";
				for($xy=1;$xy<=4;$xy++)
				{
					if (($xy==1 )||($xy==3))
					{
						switch($rowsf[$xy])
						{
							case "0":
								$csemf[$xy]=$cmrojo;
								break;
							case "1":
							case "2":
								$csemf[$xy]=$cmamarillo;
								break;
							case "3":
								$csemf[$xy]=$cmverde;
								break;
						}
					}
					else
					{
						switch($rowsf[$xy])
						{
							case "0":
								$csemf[$xy]=$cmrojo;
								break;
							case "1":
								$csemf[$xy]=$cmamarilloa;
								break;
							case "2":
								$csemf[$xy]=$cmverdea;
								break;
						}
					}
				}
				if($row[11]=="S"){$imagenes="src='imagenes/confirm.png' title='Activo'";}
				else{$imagenes="src='imagenes/noacti.png' title='No Activo'";}
				$imagenco="src='imagenes/construcc01.gif' title='En Construccion'";
				$sqlcdp="SELECT codcdp FROM contrasoladquisiciones WHERE codsolicitud='$row[12]'";
				$rowcdp=mysql_fetch_row(mysql_query($sqlcdp,$linkbd));
				echo "
					<tr class='$iter'>	
						<td>".strtoupper($row[0])."</td>
						<td>".date("d-m-Y",strtotime($row[1]))."</td>
						<td>$row[2]</td>
						<td>".ucfirst(strtolower($row[3]))."</td>
						<td>$modalidad</td>
						<td>$smodalidad</td>
						<td>".ucwords(strtolower($rowcl[0]))."</td>
						<td>$row[8]</td>
						<td>$rowcdp[0]</td>
						<td style='text-align:center;'><img $csemf[1] style='width:20px'/></td>
						<td style='text-align:center;'><img $csemf[2] style='width:20px'/></td>
						<td style='text-align:center;'><img $csemf[3] style='width:20px'/></td>
						<td style='text-align:center;'><img $csemf[4] style='width:20px'/></td>
						<td style='text-align:center;'><img $imagenco style='width:26px'/></td>
						<td style='text-align:center;'><img $imagenco style='width:26px'/></td>
						<td style='text-align:center;'><img $imagenes style='width:18px'/></td>
					</tr>";
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
 			}
 			echo"</table>";
		}
		?>
        </div>
        </form>
</td></tr>     
</table>
</body>
</html>