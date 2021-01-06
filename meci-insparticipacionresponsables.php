<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require"funciones.inc";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>:: Spid - Meci Calidadn</title>
		<script src="css/calendario.js"></script>
		<script> 
			function ponprefijo(pref,opc)
			{ 
				switch(document.getElementById('tipolista').value)
				{
					case "1":
						parent.document.form2.responsablet1.value =pref;
						parent.document.form2.nresponsablet1.value =opc;
						parent.despliegamodal2("hidden");
						break;
					case "2":
						parent.document.form2.responsablet2.value =pref;
						parent.document.form2.nresponsablet2.value =opc;
						parent.despliegamodal2("hidden");
						break;
					case "3":
						parent.document.form2.responsablet3.value =pref;
						parent.document.form2.nresponsablet3.value =opc;
						parent.despliegamodal2("hidden");
						break;
				}
			} 
		</script> 
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<?php 
			titlepag();
			$_POST[tipolista]=$_GET[tipo];
		?>
	</head>
	<body>
  		<form action="" method="post" enctype="multipart/form-data" name="form1">

            <table  class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="4">:: Buscar Responsable</td>
                </tr>
                <tr>
                    <td class="saludo1">Nombre o apellidos:</td>
                    <td><input name="nombre" type="text" value="" size="40"></td>
                    <td class="saludo1">Documento:</td>
                    <td>
                        <input name="documento" type="text" id="documento" value="">
                        <input type="submit" name="Submit" value="Buscar" >
                    </td>
                </tr>                       
            </table> 
			<?php
                $oculto=$_POST['oculto'];
                if(true)
                {
                    $linkbd=conectar_bd();
                    $crit1=" ";
                    $crit2=" ";
                    if ($_POST[nombre]!="")
                        {$crit1=" AND (t.nombre1 like '%".$_POST[nombre]."%' OR t.nombre2 like '%".$_POST[nombre]."%' OR t.apellido1 like '%".$_POST[nombre]."%' OR t.apellido2 like '%".$_POST[nombre]."%' ) ";}
                    if ($_POST[documento]!="")
                        {$crit2=" and t.cedulanit like '%$_POST[documento]%' ";}
                    $sqlr="SELECT t.*, pl.*, pt.* FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.estado='S' AND pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo".$crit1.$crit2." order by t.apellido1, t.apellido2, t.nombre1, t.nombre2";
                    $resp = mysql_query($sqlr,$linkbd);
                    $ntr = mysql_num_rows($resp);
                    $con=1;
                    echo "<table class='inicio' align='center' width='99%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='8'>Terceros Encontrados: $ntr</td></tr><tr><td class='titulos2' width='2%'>Item</td><td class='titulos2' width='30%'>CARGO</td><td class='titulos2' width='10%'>PRIMER APELLIDO</td><td class='titulos2' width='10%'>SEGUNDO APELLIDO</td><td class='titulos2' width='10%'>PRIMER NOMBRE</td><td class='titulos2' width='10%'>SEGUNDO NOMBRE</td><td class='titulos2' width='4%'>DOCUMENTO</td></tr>";	
                    $iter='saludo1';
                    $iter2='saludo2';
                    while ($row =mysql_fetch_row($resp)) 
                    {
                        if ($row[11]=='31'){$ntercero=$row[5];}
                        else {$ntercero=$row[3].' '.$row[4].' '.$row[1].' '.$row[2];}
                        echo 
                        "<tr class='$iter' onClick='javascript:ponprefijo(\"$row[12]\",\"$ntercero\")'>
                            <td>$con</td>
                            <td>".strtoupper($row[24])."</td>
                            <td>".strtoupper($row[3])."</td>
                            <td>".strtoupper($row[4])."</td>
                            <td>".strtoupper($row[1])."</td>
                            <td>".strtoupper($row[2])."</td>
                            <td>$row[12] </td>
                        </tr>";
                        $con+=1;
                        $aux=$iter;
                        $iter=$iter2;
                        $iter2=$aux;
                    }
                    echo"</table>";
                }
            ?>
            <input type="hidden" name="oculto" id="oculto"  value="1">
            <input type="hidden" name="tipolista" id="tipolista" value="<?php echo $_POST[tipolista];?>"
        </form>
	</body>
</html>
