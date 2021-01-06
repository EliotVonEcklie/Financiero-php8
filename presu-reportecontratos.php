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
		<title>:: Spid - Presupuesto</title>
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

function validar2()
{
	//   alert("Balance Descuadrado");
	document.form2.oculto.value=2;
	document.form2.action="presu-concecontablesconpes.php";
	document.form2.submit();
}

function validar(){document.form2.submit();}

function buscaract()
{
	//alert("Balance Descuadrado");
	document.form2.listar.value=2;
	document.form2.submit();
}
function buscater(e)
{
    if (document.form2.tercero.value!="")
    {
        document.form2.bt.value='1';
        document.form2.oculto.value='0'; 
        document.form2.submit();
    }
    else
    {
        document.form2.ntercero.value='';
        document.form2.submit();
    }
}
function excell()
{
    document.form2.action="presu-reportecontratosexcel.php";
    document.form2.target="_BLANK";
    document.form2.submit(); 
    document.form2.action="";
    document.form2.target="";
}
function despliegamodal2(_valor,v)
{
    document.getElementById("bgventanamodal2").style.visibility=_valor;
    if(_valor=="hidden"){
        document.getElementById('ventana2').src="";
        document.form2.submit();
    }
    else {
        if(v==1){
            document.getElementById('ventana2').src="registro-ventana02.php?vigencia="+document.form2.vigencia.value;
        }else if(v==2){
            document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=solicita";
        }else if(v==3){
            document.getElementById('ventana2').src="registro-ventana03.php?vigencia="+document.form2.vigencia.value;
        }
        
    }
}
</script>

<?php titlepag();?>
</head>
<body>
    <table>
   	    <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>
        <tr><?php menu_desplegable("presu");?></tr>
	    <tr>
            <td colspan="3" class="cinta">
                <a href="presu-reportecontratos.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
                <a href="presu-reportecontratos.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
                <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
                <a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
                <img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/>
            </td>
	    </tr>
    </table>
    <?php
    /*$vigencia=date(Y);
    $vs=" ";
    if(!$_POST[oculto])
    {
        $fec=date("d/m/Y");
        $_POST[fecha]=$fec; 	
        $_POST[vigencia]=$vigencia;
        $_POST[vigdep]=$vigencia;		 	  			 
        $_POST[valor]=0;	
        $vs=" style=visibility:visible";	 		 
	}*/	  
    ?>
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
        if($_POST[bt]=='1')
			{
				$nresul=buscatercero($_POST[tercero]);
			  	if($nresul!=''){$_POST[ntercero]=$nresul;}
			 	else{$_POST[ntercero]="";}
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
                <td class="titulos" colspan="10">.: Reporte de Contratos</td>
                <td  class="cerrar"  style="width:5%;"><a href="presu-principal.php">Cerrar</a></td>
            </tr>
		    <tr>
                <td class="saludo1" style="width:6%;">Fecha Inicial:</td>
                <td style="width:8%;">
                    <input type="text" name="fecha1" value="<?php echo $_POST[fecha1]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
                </td>
                <td class="saludo1" style="width:6%;">Fecha Final:</td>
                <td style="width:8%;">
                    <input name="fecha2" type="text" value="<?php echo $_POST[fecha2]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
                </td>
                <td class="saludo1" style="width:5%;">.: Fuentes:</td>
                <td style="width:20%">
                    <select name="ffunc" id="ffunc" style="width: 100%">
                        <option value="">Seleccione ....</option>
                        <?php
                            $sql="SELECT codigo,nombre FROM pptofutfuentefunc UNION SELECT codigo,nombre FROM pptofutfuenteinv ORDER BY CAST(codigo AS SIGNED) ASC";
                            $result=mysql_query($sql,$linkbd);
                            while($row = mysql_fetch_row($result)){echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                        ?>
                    </select>
                </td>
                <input name="oculto" type="hidden" value="1">
                <td class="saludo1" style="width:5%;">.: Tercero:</td>
                <td style="width:10%;">
                    <input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" style="width:80%">&nbsp;<a onClick="despliegamodal2('visible',2);" title="Listado Terceros"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a> 
                        <input type="hidden" value="0" name="bt">
                </td>
                <td style="width:20%;">
                    <input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly >
                </td>
                <td style=" padding-bottom: 0em"><input type="hidden" name="listar" id="listar" value="<?php echo $_POST[listar] ?>" /><em class="botonflecha" onClick="buscaract()">Buscar</em></td>
		    </tr>
            <tr>    
                
		 </tr>          
    </table>    
    <div class="subpantalla" style="height:66.5%; width:99.6%;">
        <table class="inicio">
            <tr><td class="titulos" colspan="10">Listado de Contratos</td></tr>
            <tr>
                <td class="titulos2">No Contrato</td>
                <td class="titulos2">RP</td>
                <td class="titulos2">CDP</td>
                <td class="titulos2">Concepto</td>
                <td class="titulos2">Fuente</td>
                <td class="titulos2">Tercero</td>
                <td class="titulos2">Rubro</td>
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
                $criterio2 = '';
                $criterio3 = '';
                if($_POST[ffunc]!='') {$criterio2=" and fuente='$_POST[ffunc]'";}
                
                if($_POST[tercero]!=''){$criterio3=" and tercero='$_POST[tercero]'";}

                $linkbd=conectar_bd();
                $sqlr="SELECT * FROM pptorp WHERE estado!='N' $criterio $criterio3 AND vigencia='$vigenciaRp' AND detalle NOT LIKE '%NOMINA%' ORDER BY consvigencia DESC";
                //echo $sqlr."<br>";
                //$row = view($sqlr);
                $resd=mysql_query($sqlr,$linkbd);
                //$tama=count($row);
                $con=0;
                $co="zebra1";
                $co2='zebra2';
                
                //while($con<$tama)
                while($rowd=mysql_fetch_assoc($resd)) 
                {
                    $sqlrRpNomina = "SELECT * FROM hum_nom_cdp_rp WHERE rp='".$rowd[consvigencia]."' AND vigencia='$vigenciaRp' ";
                    $rowRpNomina = view($sqlrRpNomina);
                    $tamaRpNomina=count($rowRpNomina);                        
                    if($tamaRpNomina==0 && (($rowd['contrato']!='' && $rowd['contrato']!='0') || $rowd[tipo_mov]=='401' || $rowd[tipo_mov]=='402'))
                    {
                        $sqlrDet = "SELECT * FROM pptorp_detalle WHERE vigencia='$vigenciaRp' AND consvigencia='".$rowd[consvigencia]."' AND tipo_mov='".$rowd[tipo_mov]."' $criterio2 ";
                        $rowDet = view($sqlrDet);
                        
                        //var_dump($rowDet);
                        $fuenteRp = "";
                        for($xx = 0; $xx < count($rowDet); $xx++)
                        {
                            if($rowd[tipo_mov]!='201')
                            {
                                $rowDet[$xx]['valor'] = $rowDet[$xx]['valor'] * (-1);
                            }
                            $fuenteRp = buscafuenteppto($rowDet[$xx]['cuenta'],$rowDet[$xx]['vigencia']);
                            echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
                            <td style='width:6%'>".$rowd['contrato']."</td>
                            <td style='width:4%'>".$rowd['consvigencia']."</td>
                            <td style='width:4%'>".$rowd['idcdp']."</td>
                            <td>".$rowd['detalle']."</td>
                            <td>".$fuenteRp."</td>
                            <td style='width:20%'>".$rowd['tercero'] ." - ".buscatercero($rowd['tercero'])."</td>
                            <td style='width:20%'>".$rowDet[$xx]['cuenta'] ." - ".buscacuentapres($rowDet[$xx]['cuenta'])."</td>
                            <td style='width:8%'>".$rowd['fecha']."</td>
                            <td style='width:10%'>".number_format($rowDet[$xx]['valor'],2)."</td>
                            <td>".$rowd['estado']."</td></tr>";
                            echo "
                                <input type='hidden' name='contrato[]' id='contrato[]' value='".$rowd['contrato']."'>
                                <input type='hidden' name='consvigencia[]' id='consvigencia[]' value='".$rowd['consvigencia']."'>
                                <input type='hidden' name='idcdp[]' id='idcdp[]' value='".$rowd['idcdp']."'>
                                <input type='hidden' name='detalle[]' id='detalle[]' value='".$rowd['detalle']."'>
                                <input type='hidden' name='cuenta[]' id='cuenta[]' value='".$rowDet[$xx]['cuenta']."'>
                                <input type='hidden' name='vigencia[]' id='vigencia[]' value='".$rowDet[$xx]['vigencia']."'>
                                <input type='hidden' name='fecha[]' id='fecha[]' value='".$rowd['fecha']."'>
                                <input type='hidden' name='valor[]' id='valor[]' value='".$rowDet[$xx]['valor']."'>
                                <input type='hidden' name='estado[]' id='estado[]' value='".$rowd['estado']."'>
                                <input type='hidden' name='terceroT[]' id='terceroT[]' value='".$rowd['tercero']."'>
                                ";
                            $aux=$co;
                            $co=$co2;
                            $co2=$aux;
                        }
                    }
                    //$con+=1;
                }
	        }
            ?><script>document.getElementById('divcarga').style.display='none';</script>
        </table>
    </div>
    <div id="bgventanamodal2">
        <div id="ventanamodal2">
            <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
            </IFRAME>
        </div>
    </div>
</form>
</body>
</html>