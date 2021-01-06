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
		<title>:: Spid - Tesoreria</title>
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
    document.form2.action="teso-reporteidentificadosexcel.php";
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
   	    <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>
        <tr><?php menu_desplegable("teso");?></tr>
	    <tr>
            <td colspan="3" class="cinta">
                <a href="teso-reporteidentificados.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
                <a href="teso-reporteidentificados.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
                <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
                <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
                <img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/>
                <a href="teso-informestesoreria.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
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
                <td class="titulos" colspan="8">.: Reporte de identificados</td>
                <td  class="cerrar"  style="width:5%;"><a href="teso-principal.php">Cerrar</a></td>
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
                <td class="saludo1" style="width:5%;">.: Estado:</td>
                <td style="width:30%">
                    <select name="estado" id="estado" style="width: 100%">
                        <option value="">Seleccione ....</option>
                        <option value="I" <?php if($_POST[estado]=='I') echo "SELECTED"?>>Identificado</option>
                        <option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"?>>Por identificar</option>
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
            <tr><td class="titulos" colspan="7">Listado de Identificados</td></tr>
            <tr>
                <td class="titulos2">No Comprobante</td>
                <td class="titulos2">Concepto</td>
                <td class="titulos2">Tercero</td>
                <td class="titulos2">Fecha</td>
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
                    $vigenciaRp = $fech1[2];
                    if($_POST[fecha2]!='')
                    {
                        $fech2=split("/",$_POST[fecha2]);
                        $f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
                        $criterio=" AND fecha between '$f1' AND '$f2'";
                    }
                    else{$criterio=" AND fecha >= '$f1'";}
                }
                else if($_POST[fecha2]!='') 
                {
                    $fech2=split("/",$_POST[fecha2]);
                    $f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
                    $vigenciaRp = $fech1[2];
                    $criterio=" AND fecha <= '$f2'";
                }
                else
                {
                    $criterio="";
                    $vigenciaRp = date(Y);
                }

                if($_POST[estado]!='') {$criterio2=" and estado='$_POST[estado]'";}
	   	
                $linkbd=conectar_bd();
                $sqlr="SELECT * FROM tesosinidentificar WHERE tipo_mov='201' $criterio $criterio2 ORDER BY id_recaudo DESC";
                //echo $sqlr."<br>";
                $row = view($sqlr);
                $tama=count($row);
                $con=0;
                $co="zebra1";
                $co2='zebra2';
                
		        while($con<$tama) 
                {
                    $estadoComp = "";
                    $estiloC = "";
                    if($row[$con]['estado']=='S')
                    {
                        $estadoComp = "POR IDENTIFICAR";
                        $estiloC = "background-color: #F85D3C;";
                    }
                    else
                    {
                        $estadoComp = "IDENTIFICADO";
                        $estiloC = "background-color: #45F93D;";
                    }
                    $tercero = buscatercero($row[$con]['tercero']);
                    echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
                    <td style='width:7%; text-align:center;'>".$row[$con]['id_recaudo']."</td>
                    <td>".$row[$con]['concepto']."</td>
                    <td>".$row[$con]['tercero']." - ".$tercero."</td>
                    <td style='width:8%'>".$row[$con]['fecha']."</td>
                    <td style='width:10%'> $ ".number_format($row[$con]['valortotal'],2)."</td>
                    <td style='width:10%; $estiloC'>".$estadoComp."</td></tr>";
                    echo "
                        <input type='hidden' name='id_recaudo[]' id='id_recaudo[]' value='".$row[$con]['id_recaudo']."'>
                        <input type='hidden' name='concepto[]' id='concepto[]' value='".$row[$con]['concepto']."'>
                        <input type='hidden' name='tercero[]' id='tercero[]' value='".$row[$con]['tercero']."'>
                        <input type='hidden' name='fecha[]' id='fecha[]' value='".$row[$con]['fecha']."'>
                        <input type='hidden' name='valor[]' id='valor[]' value='".$row[$con]['valortotal']."'>
                        <input type='hidden' name='estadoComp[]' id='estadoComp[]' value='".$estadoComp."'>
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