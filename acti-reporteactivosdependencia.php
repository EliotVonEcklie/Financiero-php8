<?php
    ini_set('max_execution_time',3600);
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
		<title>:: Spid - Activos</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
<script>
$(window).load(function () { $('#cargando').hide();});
function guardar()
{
	if(document.form2.periodo.value!='')
		{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.listar.value=2;document.form2.submit();}}
	else{alert('Seleccione un MES para realizar la Depreciaci�n');}
 }

function clasifica(formulario)
{
	//document.form2.action="presu-recursos.php";
	document.form2.submit();
}

function buscacta(e)
 {if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}

function buscacc(e)
 {if (document.form2.cc.value!=""){document.form2.bcc.value='1';document.form2.submit();}}

function validar(){document.form2.submit();}

function buscaract()
{
	//alert("Balance Descuadrado");
	document.form2.listar.value=2;
	document.form2.submit();
}

function excell()
{
    document.form2.action="acti-reporteactivosdependenciaexcel.php";
    document.form2.target="_BLANK";
    document.form2.submit(); 
    document.form2.action="";
    document.form2.target="";
}
</script>

<?php titlepag();?>
</head>
<body>
    <table>
   	    <tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
        <tr><?php menu_desplegable("acti");?></tr>
	    <tr>
            <td colspan="3" class="cinta">
                <a href="acti-reporteactivosdependencia.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
                <a href="acti-reporteactivosdependencia.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
                <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
                <a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
                <img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/>
            </td>
	    </tr>
    </table>
    <form name="form2" method="post" action=""> 
    <div class="loading" id="divcarga"><span>Cargando...</span></div> 
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
                <td class="titulos" colspan="9">.: Reporte de Activos</td>
                <td  class="cerrar"  style="width:5%;"><a href="acti-principal.php">Cerrar</a></td>
            </tr>
		    <tr>
                <td class="saludo1" style="width:10%;">Fecha Inicial:</td>
                <td style="width:10%;">
                    <input type="text" name="fecha1" value="<?php echo $_POST[fecha1]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
                </td>
                <td class="saludo1" style="width:10%;">Fecha Final:</td>
                <td style="width:10%;">
                    <input name="fecha2" type="text" value="<?php echo $_POST[fecha2]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
                </td>
                <td class="saludo1" style="width:6%;">.: Ubicacion:</td>
                <td style="width:30%">
                    <select name="ubicacion" style="width:90%">
                        <option value="">...</option>
                        <?php
                        $link=conectar_bd();
                        $sqlr="Select * from actiubicacion where estado='S'";
                        $resp = mysql_query($sqlr,$link);
                        while ($row =mysql_fetch_row($resp)) 
                        {
                            echo "<option value=$row[0] ";
                            $i=$row[0];
                            if($i==$_POST[ubicacion])
                            {
                                echo "SELECTED";
                            }
                            echo ">".$row[0].' - '.$row[1]."</option>";	  
                        }
                        ?>
                    </select>
                </td>
                <td class="saludo1" style="width:8%;">.: Dependencia:</td>
                <td style="width:30%">
                    <select name="dependencia" style="width:90%">
                        <option value="">...</option>
                        <?php
                        $link=conectar_bd();
                        $sqlr="Select * from planacareas where estado='S'";
                        $resp = mysql_query($sqlr,$link);
                        while ($row =mysql_fetch_row($resp)) 
                        {
                            echo "<option value=$row[0] ";
                            $i=$row[0];
                            if($i==$_POST[ubicacion])
                            {
                                echo "SELECTED";
                            }
                            echo ">".$row[0].' - '.$row[1]."</option>";	  
                        }
                        ?>
                    </select>
                </td>
                <input name="oculto" type="hidden" value="1">
                </td>
                <td style=" padding-bottom: 0em"><input type="hidden" name="listar" id="listar" value="<?php echo $_POST[listar] ?>" /><em class="botonflecha" onClick="buscaract()">Buscar</em></td>
		    </tr>
            <tr>    
                
		 </tr>          
    </table>    
    <div class="subpantalla" style="height:66.5%; width:99.6%;">
        <table class="inicio">
            <tr><td class="titulos" colspan="7">Listado de Activos</td></tr>
            <tr>
                <td class="titulos2">Placa</td>
                <td class="titulos2">Nombre</td>
                <td class="titulos2">Ubicacion</td>
                <td class="titulos2">Dependencia</td>
                <td class="titulos2">Fecha Activacion</td>
                <td class="titulos2">Valor</td>
                <td class="titulos2">Estado</td>
            </tr>   
            <?php
            if($_POST[listar]=='2')
            {
                $vigenciaRp = 0;
                if($_POST[fecha1]!='')
                {
                    $fech1=split("/",$_POST[fecha1]);
                    $f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
                    if($_POST[fecha2]!='')
                    {
                        $fech2=split("/",$_POST[fecha2]);
                        $f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
                        $criterio=" AND fechact between '$f1' AND '$f2'";
                    }
                    else{$criterio=" AND fechact >= '$f1'";}
                }
                else if($_POST[fecha2]!='') 
                {
                    $fech2=split("/",$_POST[fecha2]);
                    $f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
                    $criterio=" AND fechact <= '$f2'";
                }
                else
                {
                    $criterio="";
                }

                if($_POST[ubicacion]!='') {$criterio2=" and ubicacion='$_POST[ubicacion]'";}

                if($_POST[dependencia]!='') {$criterio2=" and area='$_POST[dependencia]'";}
	   	
                $linkbd=conectar_bd();
                $sqlr="SELECT * FROM acticrearact_det WHERE estado!='N' $criterio $criterio2 ORDER BY fechact DESC";
                //echo $sqlr."<br>";
                $row = view($sqlr);
                var_dump($row);
                $tama=count($row);
                $con=0;
                $co="zebra1";
                $co2='zebra2';
		        while($con<$tama) 
                {
                    $sqlrUbicacion = "Select * from actiubicacion where estado='S' and id_cc='".$row[$con]['ubicacion']."'";
                    $rowUbicacion = view($sqlrUbicacion);

                    $sqlrDependencia = "Select * from planacareas where estado='S' and codarea='".$row[$con]['area']."'";
                    //echo $sqlrDependencia."<br>";
                    $rowDependencia = view($sqlrDependencia);

                    echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
                    <td style='width:6%'>".$row[$con]['placa']."</td>
                    <td style='width:30%'>".$row[$con]['nombre']."</td>
                    <td>".$rowUbicacion[0][nombre]."</td>
                    <td>".$rowDependencia[0][nombrearea]."</td>
                    <td style='width:8%'>".$row[$con]['fechact']."</td>
                    <td style='width:10%'>".$row[$con]['valor']."</td>
                    <td>".$row[$con]['estadoactivo']."</td></tr>";
                    echo "
                        <input type='hidden' name='contrato[]' id='contrato[]' value='".$row[$con]['contrato']."'>
                        <input type='hidden' name='consvigencia[]' id='consvigencia[]' value='".$row[$con]['consvigencia']."'>
                        <input type='hidden' name='detalle[]' id='detalle[]' value='".$row[$con]['detalle']."'>
                        <input type='hidden' name='cuenta[]' id='cuenta[]' value='".$rowDet[$xx]['cuenta']."'>
                        <input type='hidden' name='vigencia[]' id='vigencia[]' value='".$rowDet[$xx]['vigencia']."'>
                        <input type='hidden' name='fecha[]' id='fecha[]' value='".$row[$con]['fecha']."'>
                        <input type='hidden' name='valor[]' id='valor[]' value='".$row[$con]['valor']."'>
                        <input type='hidden' name='estado[]' id='estado[]' value='".$row[$con]['estado']."'>
                        ";
                    $aux=$co;
                    $co=$co2;
                    $co2=$aux;

                    $con+=1;
                }
	        }
            ?><script>document.getElementById('divcarga').style.display='none';</script>
        </table>
    </div>
    
</form>
</body>
</html>