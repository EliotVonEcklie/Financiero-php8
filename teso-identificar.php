<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
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
    document.form2.oculto.value='3';
    document.form2.submit();
}
function validar1()
{
    document.form2.submit();
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
function agregardetalle()
{
if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
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
/*function guardar()
{
	ingresos2=document.getElementsByName('dcoding[]');
	if (document.form2.fecha.value!='' && ingresos2.length>0 && document.form2.presupuesto.value!='-1')
	{
		if (confirm("Esta Seguro de Guardar"))
		{
		document.form2.oculto.value=2;
		document.form2.submit();
		}
	}
	else{
	alert('Faltan datos para completar el registro');
		document.form2.fecha.focus();
		document.form2.fecha.select();
  	}
}*/
function guardar()
{
    if(document.form2.tipomovimiento.value=='201'){
        var validacion01=document.form2.concepto.value;
        if(validacion01.trim()!='' && document.form2.fecha.value!='')
        {
            if (document.getElementById('nbanco').value!='')
            {despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
            else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
            
        }
        else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
            
    }else{
        despliegamodalm('visible','4','Esta Seguro de Guardar','1');
    }
}
function despliegamodalm(_valor,_tip,mensa,pregunta)
		{
			document.getElementById("bgventanamodalm").style.visibility=_valor;
			if(_valor=="hidden"){document.getElementById('ventanam').src="";}
			else
			{
				switch(_tip)
				{
					case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
					case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
					case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
					case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
				}
			}
		}
		function respuestaconsulta(pregunta)
		{
			switch(pregunta)
			{
				case "1":	document.getElementById('oculto').value="2";
							document.form2.submit();break;
				case "2":	document.getElementById('tipoelimina').value="1";
							document.form2.submit();break;
				case "3":	document.getElementById('tipoelimina').value="2";
							document.form2.submit();break;
			}
		}
		function funcionmensaje()
		{
			if(document.form2.tipomovimiento.value=='201')
			{
				var codig=document.form2.idcomp.value;
				document.location.href = "teso-editaidentificar.php?idrecaudo="+codig;
			}
			else
			{
				var codig=document.form2.numIngreso.value;
				document.location.href = "teso-editaidentificar.php?idrecaudo="+codig;
			}
				
		}
</script>
<script>
function pdf()
{
document.form2.action="teso-pdfrecaudostrans.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
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
function buscaing(e)
{
	if (document.form2.codingreso.value!="")
	{
		document.form2.bin.value='1';
		document.form2.submit();
	}
}
function despliegamodal2(_valor,_num)
{
	document.getElementById("bgventanamodal2").style.visibility=_valor;
	if(_valor=="hidden"){document.getElementById('ventana2').src="";}
	else 
	{
		switch(_num)
		{
			case '1':	document.getElementById('ventana2').src="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";break;
			case '2': document.getElementById('ventana2').src="teso-sinidentificar-ventana.php";break;
            case '3': document.getElementById('ventana2').src="reversar-identificar.php";break;
		}
	}
}

function respuestamensaje(){
	location.href="teso-editaidentificar.php?idrecaudo="+document.form2.idcomp.value;
}

</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
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
                <a href="teso-identificar.php" class="mgbt" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a>  
                <a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a>  
                <a href="teso-buscaidentificar.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" /></a> 
                <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
                <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>  
                <a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()"  <?php } ?> class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" /></a>
            </td>
	    </tr>		  
    </table>
    <tr>
        <td colspan="3" class="tablaprin" align="center"> 
        <?php
        $linkbd=conectar_bd();
        $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
        $vigencia=$vigusu;
        $_POST[vigencia]=$vigencia;
        //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
       // echo $_POST[oculto];
        if($_POST[oculto]=='3')
        {
            unset($_POST[dcoding]);	
            unset($_POST[dncoding]);			 
            unset($_POST[dvalores]);
            unset($_POST[concepto]);
            unset($_POST[totalc]);
            unset($_POST[totalcf]);
            $sqlr="select max(id) from tesoidentificar";
            $res=mysql_query($sqlr,$linkbd);
            $consec=0;
            while($r=mysql_fetch_row($res))
            {
                $consec=$r[0];	  
            }
            $consec+=1;
            $_POST[idcomp]=$consec;	
            $fec=date("d/m/Y");
            $_POST[fecha]=$fec; 		 		  			 
            $_POST[valor]=0;
            $_POST[oculto]='1';
            $_POST[idrecaudo]='';
        }
        if(!$_POST[oculto])
        {
            $check1="checked";
            $_POST[tipomovimiento]='201';   
            $fec=date("d/m/Y");
            $_POST[vigencia]=$vigencia;

            $sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
            $res=mysql_query($sqlr,$linkbd);
            while ($row =mysql_fetch_row($res)) 
	        {
	            $_POST[cuentacaja]=$row[0];
	        }
	        $sqlr="select max(id) from tesoidentificar ";
	        $res=mysql_query($sqlr,$linkbd);
            $consec=0;
            while($r=mysql_fetch_row($res))
	        {
                $consec=$r[0];
                
	        }
	        $consec+=1;
            $_POST[idcomp]=$consec;
 		    $fec=date("d/m/Y");
		    $_POST[fecha]=$fec; 		 		  			 
		    $_POST[valor]=0;		 
        }
        switch($_POST[tabgroup1])
        {
            case 1:
            $check1='checked';
            break;
            case 2:
            $check2='checked';
            break;
            case 3:
            $check3='checked';
        }
        $_POST[dcoding]= array();
        $_POST[dncoding]= array();
        $_POST[dvalores]= array();
        $sqlr="select distinct *from  tesosinidentificar_det where tesosinidentificar_det.id_recaudo=$_POST[idrecaudo]";	
        $res=mysql_query($sqlr,$linkbd);
        $cont=0;
        //echo $sqlr;
        //$_POST[idcomp]=$_GET[idrecaudo];	
        $total=0;
        while ($row =mysql_fetch_row($res)) 
        {
            $_POST[dcoding][]=$row[2];
            $_POST[dncoding][]=buscaingreso($row[2]);			 
            $_POST[dvalores][]=$row[3];		
        }
        
        $sqlr="select distinct *from tesosinidentificar where tesosinidentificar.id_recaudo=$_POST[idrecaudo]";	
        $res=mysql_query($sqlr,$linkbd);
        $cont=0;
        //echo $sqlr;
        //$_POST[idcomp]=$_GET[idrecaudo];	
        $total=0;
        while ($row =mysql_fetch_row($res)) 
        {
	        //$_POST[concepto]=$row[6];			
	        $_POST[tercero]=$row[7];				 
	        $_POST[ntercero]=buscatercero($row[7]);				 	 
	        $_POST[cc]=$row[8];
            $_POST[medioDePago]=$row[11];
            $_POST[banco]=$row[5];
            //echo ";}";
            $_POST[dnbanco]=buscatercero($row[4]);
        }
        $sqlr = "select distinct *from tesosinidentificar,tesobancosctas where tesobancosctas.ncuentaban= tesosinidentificar.ncuentaban AND tesosinidentificar.id_recaudo=$_POST[idrecaudo]";
        
        $res=mysql_query($sqlr,$linkbd);
        while ($row =mysql_fetch_row($res)) 
        {	
            $_POST[banco]=$row[13];		 
            $_POST[dnbanco]=buscatercero($row[4]);
        }	
        ?>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" action=""> 
        <?php
        //***** busca tercero
        if($_POST[bt]=='1')
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
        //******** busca ingreso *****
        //***** busca tercero
        if($_POST[bin]=='1')
        {
            $nresul=buscaingreso($_POST[codingreso]);
            if($nresul!='')
            {
                $_POST[ningreso]=$nresul;
            }
            else
            {
                $_POST[ningreso]="";
            }
        }
        ?>
        <table class="inicio">
            <tr>
                <td class="titulos" style="width:100%;">.: Tipo de Movimiento
                    <input type="hidden" value="1" name="oculto" id="oculto">
                    <select name="tipomovimiento" id="tipomovimiento" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:20%;" >
                        <?php 
                            $user=$_SESSION[cedulausu];
                            $sql="SELECT * from permisos_movimientos WHERE usuario='$user' AND estado='T' ";
                            $res=mysql_query($sql,$linkbd);
                            $num=mysql_num_rows($res);
                            if($num==1){
                                $sqlr="select * from tipo_movdocumentos where estado='S' and modulo=4 AND (id='2' OR id='4')";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($_POST[tipomovimiento]==$row[0].$row[1]){
                                        echo "<option value='$row[0]$row[1]' SELECTED >$row[0]$row[1]-$row[2]</option>";
                                    }else{
                                        echo "<option value='$row[0]$row[1]'>$row[0]$row[1]-$row[2]</option>";
                                    }
                                }
                            }else{
                                $sql="SELECT codmov,tipomov from permisos_movimientos WHERE usuario='$user' AND estado='S' AND modulo='4' AND transaccion='TPB' ";
                                $res=mysql_query($sql,$linkbd);
                                while($row = mysql_fetch_row($res)){
                                    if($_POST[tipomovimiento]==$row[0]){
                                        echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
                                    }else{
                                        echo "<option value='$row[0]'>$row[0] - $row[1]</option>";
                                    }
                                    
                                }
                            }
                            
                        ?>
                    </select>
                </td>
                <td style="width:80%;">
                </td>
            </tr>
        </table>
        <?php if ($_POST[tipomovimiento]=='201') {?>
        <table class="inicio" align="center" >
            <tr >
                <td class="titulos" style="width:93%;" colspan="3"> Identificar Ingresos</td>
                <td class="cerrar" style="width:7%;" ><a href="teso-principal.php">Cerrar</a></td>
            </tr>
            <tr>
                <td style="width:80%;">
                    <table>
                        <tr>
                            <td style="width:8%;" class="saludo1" >No Recaudo:</td>
                            <td style="width:10%;">
                                <input name="idcomp" id="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" style="width:75%;" onKeyUp="return tabular(event,this) "  readonly>
                            </td>
                            <td style="width:5%;" class="saludo1">Fecha:</td>
                            <td style="width:7%;">
                                <input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;"> 
                                <a href="#" onClick="displayCalendarFor('fc_1198971545');">
                                    <img src="imagenes/buscarep.png" align="absmiddle" border="0">
                                </a>         
                            </td>
                            <td style="width:3%;" class="saludo1">No Ingreso:</td>
                                <td style="width:5%;">
                                    <input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" style="width:70%;" onKeyUp="return tabular(event,this)" onBlur="validar1()" ><a onClick="despliegamodal2('visible','2');" style="cursor:pointer;" title="Listado Ordenes Pago"><img src="imagenes/find02.png" style="width:20px;"/></a> 
                                </td>
                                <td style="width:8%;" class="saludo1">Centro Costo:</td>
                                <td style="width:10%;">
                                <select name="cc" style="width:100%;" onKeyUp="return tabular(event,this)">
                                <?php
                                    $linkbd=conectar_bd();
                                    $sqlr="select *from centrocosto where estado='S'";
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
                        </tr>
                        <tr>
                            <td style="width:6%;" class="saludo1">Concepto:</td>
                            <td colspan="7">
                                <input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%;" onKeyUp="return tabular(event,this)">
                            </td>
                            
                        </tr>
                        <tr>
                        <td style="width:10%;" class="saludo1">Recaudado:</td>
                        <td colspan="3"> 
                            <select id="banco" name="banco" style="width:100%;" onChange="validar()" onKeyUp="return tabular(event,this)" disabled>
                                <option value="">Seleccione....</option>
                                <?php
                                    $linkbd=conectar_bd();
                                    $sqlr="select tesobancosctas.estado, tesobancosctas.cuenta, tesobancosctas.ncuentaban, tesobancosctas.tipo, terceros.razonsocial, tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' order by tesobancosctas.cuenta";
                                    $res=mysql_query($sqlr,$linkbd);
                                    while ($row =mysql_fetch_row($res)) 
                                    {
                                        echo "<option value=$row[1] ";
                                        $i=$row[1];
                                        $ncb=buscacuenta($row[1]);
                                        if($i==$_POST[banco])
                                        {
                                            echo "SELECTED";
                                            $_POST[nbanco]=$row[4];
                                            $_POST[ter]=$row[5];
                                            $_POST[cb]=$row[2];
                                        }
                                        echo ">".$row[1]."-".substr($ncb,0,70)." - Cuenta ".$row[3]."</option>";	 	 
                                    }	 	
                                ?>
                            </select>
                            <input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                            <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >           
                        </td>
                        <td colspan="4"> 
                            <input type="text" id="nbanco" name="nbanco" style="width:100%;" value="<?php echo $_POST[nbanco]?>" readonly>
                        </td>
                        </tr>
                        <tr>
                            <td style="width:5%;" class="saludo1">NIT: </td>
                            <td style="width:10%;">
                                <input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:100%;" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" readonly>
                            </td>
                            <td colspan="5">
                                <input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%;" onKeyUp="return tabular(event,this) "  readonly>
                                <input type="hidden" value="0" name="bt">
                                <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
                                <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
                            </td>
                            <td style="width:5%;">
                                <input type="hidden" id="vigencia" name="vigencia" style="width:100%;" onKeyPress="javas cript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
                            </td> 
                        </tr>
                        <tr>
                    
                        </tr>
                    </table>
                </td>
                <td colspan="3" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>  
            </tr>
	    </table>
        <?php
        //***** busca tercero
		if($_POST[bt]=='1')
		{
            $nresul=buscatercero($_POST[tercero]);
            if($nresul!='')
            {
                $_POST[ntercero]=$nresul;
                ?>
                <script>
			        document.getElementById('codingreso').focus();document.getElementById('codingreso').select();
                </script>
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
        //*** ingreso
        if($_POST[bin]=='1')
        {
            $nresul=buscaingreso($_POST[codingreso]);
            if($nresul!='')
            {
                $_POST[ningreso]=$nresul;
                ?>
                <script>
                document.getElementById('valor').focus();document.getElementById('valor').select();</script>
                <?php
            }
            else
            {
                $_POST[codingreso]="";
                ?>
                <script>alert("Codigo Ingresos Incorrecto");document.form2.codingreso.focus();</script>
                <?php
            }
        }
    }
    else
    {
        $sqlr = "select distinct *from tesosinidentificar,tesobancosctas where tesobancosctas.ncuentaban= tesosinidentificar.ncuentaban AND tesosinidentificar.id_recaudo=$_POST[idIngreso]";
    
        $res=mysql_query($sqlr,$linkbd);
        while ($row =mysql_fetch_row($res)) 
        {	
            $_POST[banco]=$row[12];		 
            $_POST[dnbanco]=buscatercero($row[4]);
        }
        ?>
        <table class="inicio" aling="center">
            <tr>
                <td style="width:95%" class="titulos">Reversion de ingresos por identificar</td>
                <td style="5%" class="cerrar">
                    <a href="teso-principal.php">Cerrar</a>
                </td>
            </tr>
        </table>
        <table class="inicio" aling="center">
            <tr>
                <td class="saludo1" style="width:10%">N&uacute;mero Ingreso:<td>
                <td style="width:12%">
                    <input type="text" name="numIngreso" id="numIngreso" value="<?php echo $_POST[numIngreso] ?>" style="width:80%" readonly>
                    <a href="#" onClick="despliegamodal2('visible','3');" title="Buscar Ingreso"><img src="imagenes/find02.png" style="width:20px;"></a>
                </td>
                <td class="saludo1" style="width:10%;">Fecha:</td>
                <td style="width:10%;">
                    <input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
                </td>
                <td class="saludo1" style="width:10%;">Descripcion: </td>
                <td style="width:60%;"  colspan="3">
                    <input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:80%;">
                    <input type="hidden" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>">
                </td>
            </tr>
            <tr>
                <td style="width:10%;" class="saludo1">Recaudado:</td>
                <td colspan="3"> 
                    <select id="banco" name="banco" style="width:100%;" onChange="validar()" onKeyUp="return tabular(event,this)" disabled>
                        <option value="">Seleccione....</option>
                        <?php
                            $linkbd=conectar_bd();
                            $sqlr="select tesobancosctas.estado, tesobancosctas.cuenta, tesobancosctas.ncuentaban, tesobancosctas.tipo, terceros.razonsocial, tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' order by tesobancosctas.cuenta";
                            $res=mysql_query($sqlr,$linkbd);
                            while ($row =mysql_fetch_row($res)) 
                            {
                                echo "<option value=$row[1] ";
                                $i=$row[1];
                                $ncb=buscacuenta($row[1]);
                                if($i==$_POST[banco])
                                {
                                    echo "SELECTED";
                                    $_POST[nbanco]=$row[4];
                                    $_POST[ter]=$row[5];
                                    $_POST[cb]=$row[2];
                                }
                                echo ">".$row[1]."-".substr($ncb,0,70)." - Cuenta ".$row[3]."</option>";	 	 
                            }	 	
                        ?>
                    </select>
                    <input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                    <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >           
                </td>
                <td colspan="4"> 
                    <input type="text" id="nbanco" name="nbanco" style="width:100%;" value="<?php echo $_POST[nbanco]?>" readonly>
                </td>
                </tr>
            <tr>
                <td class="saludo1" >Concepto:<td>
                <td colspan="3">	
                    <input type="text" name="concepto" id="concepto" value="<?php echo $_POST[concepto]?>" style="width:100%;" readonly>
                </td>
                <td class="saludo1">Valor: </td>
                <td style="width:10%;">
                    <input type="text" name="valorIngreso" id="valorIngreso" value="<?php echo $_POST[valorIngreso] ?>" style="width:100%;" readonly>
                </td>
                <td class="saludo1" style="width:12%;">Ingreso por identificar: </td>
                <td>
                    <input type="text" name="idIngreso" id="idIngreso" value="<?php echo $_POST[idIngreso] ?>" readonly>
                </td>
            </tr>
        </table>
        <?php
        	
        $sqlr = "SELECT ingreso, valor FROM tesosinidentificar_det WHERE id_recaudo='$_POST[idIngreso]'";
        $res=mysql_query($sqlr,$linkbd);
        while ($row =mysql_fetch_row($res)) 
        {
            $_POST[dcoding][]=$row[0];
            $_POST[dncoding][]=buscaingreso($row[0]);			 		
            $_POST[dvalores][]=$row[1];
        }
    }
        ?>
        <div class="subpantalla" style="height:42%">
	        <table class="inicio">
	   	        <tr>
   	                <td colspan="4" class="titulos">Detalle  Ingresos por Identificar</td>
                </tr>                  
		        <tr>
                    <td class="titulos2">Codigo</td><td class="titulos2">Ingreso</td><td class="titulos2">Valor</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
                </tr>
		        <?php 		
		        if ($_POST[elimina]!='')
		        { 
		            //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		            $posi=$_POST[elimina];
                    unset($_POST[dcoding][$posi]);	
                    unset($_POST[dncoding][$posi]);			 
                    unset($_POST[dvalores][$posi]);			  		 
                    $_POST[dcoding]= array_values($_POST[dcoding]); 		 
                    $_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
                    $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		        }	 
		        if ($_POST[agregadet]=='1')
		        {
		            $_POST[dcoding][]=$_POST[codingreso];
		            $_POST[dncoding][]=$_POST[ningreso];			 		
		            $_POST[dvalores][]=$_POST[valor];
		            $_POST[agregadet]=0;
		            ?>
		            <script>
                        //document.form2.cuenta.focus();	
                        document.form2.codingreso.value="";
                        document.form2.valor.value="";	
                        document.form2.ningreso.value="";				
                        document.form2.codingreso.select();
                        document.form2.codingreso.focus();	
		            </script>
		            <?php
		        }
		        $_POST[totalc]=0;
		        for ($x=0;$x<count($_POST[dcoding]);$x++)
		        { 
		            echo "<tr class='saludo1'>
                    <td style='width:5%;'>
                        <input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' style='width:100%;' readonly>
                    </td>
                    <td style='width:80%;'>
                        <input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' style='width:100%;' readonly>
                    </td>
                    <td style='width:15%;'>
                        <input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' style='width:100%;' readonly>
                    </td>
                    <td >
                        <a href='#' onclick='eliminar($x)'>
                            <img src='imagenes/del.png'>
                        </a>
                    </td>
		 	        </tr>";
		            $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		            $_POST[totalcf]=number_format($_POST[totalc],2);
		        }
                $resultado = convertir($_POST[totalc]);
                $_POST[letras]=$resultado." Pesos";
		        echo "<tr class='saludo1'>
                    <td style='width:5%;'>
                    </td>
                    <td style='width:80%;'>Total</td>
                    <td style='width:15%;'>
                        <input name='totalcf' type='text' value='$_POST[totalcf]' style='width:100%;' readonly>
                        <input name='totalc' type='hidden' value='$_POST[totalc]'>
                    </td>
                    </tr>
                    <tr>
                        <td style='width:5%;' class='saludo1'>Son:</td>
                        <td style='width:80%;'>
                            <input name='letras' type='text' value='$_POST[letras]' style='width:100%;'>
                        </td>
                    </tr>";
		            ?>
	        </table>
        </div>
        <?php
        
	    if($_POST[oculto]=='2')
	    {
            if($_POST[tipomovimiento]=='201')
            {
                ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
                //*********************CREACION DEL COMPROBANTE CONTABLE ***************************
                //***busca el consecutivo del comprobante contable
                $consec=0;
                $consec=$_POST[idcomp];
                //***cabecera comprobante
                $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,35,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'1')";
                mysql_query($sqlr,$linkbd);
                //$idcomp=$_POST[idcomp];
                $idcomp=$consec;
                //***ppto		
                echo "<input type='hidden' name='ncomp' value='$idcomp'>";
                //******************* DETALLE DEL COMPROBANTE CONTABLE *********************
                for($x=0;$x<count($_POST[dcoding]);$x++)
                {
                    //***** BUSQUEDA INGRESO ********
                    $sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."'  and vigencia=$vigusu";
                    $resi=mysql_query($sqlri,$linkbd);
                    //	echo "$sqlri <br>";	    
                    while($rowi=mysql_fetch_row($resi))
                    {
                        //**** busqueda concepto contable*****
                        $sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
                        $re=mysql_query($sq,$linkbd);
                        while($ro=mysql_fetch_assoc($re))
                        {
                            $_POST[fechacausa]=$ro["fechainicial"];
                        }
                        $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
                        $resc=mysql_query($sqlrc,$linkbd);	  
                        //		echo "con: $sqlrc <br>";	      
                        while($rowc=mysql_fetch_row($resc))
                        {
                            $porce=$rowi[5];
                            if($_POST[cc]==$rowc[5])
                            {
                                if($rowc[6]=='N')
                                {
                                    $valorcred=$_POST[dvalores][$x]*($porce/100);
                                    $valordeb=0;
                                    $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('35 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','Ingreso por Identificar ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",".$valordeb.",'1','".$_POST[vigencia]."','35','$consec')";
                                    mysql_query($sqlr,$linkbd);
//									echo "<br>".$sqlr;
                                    $valordeb=$_POST[dvalores][$x]*($porce/100);
                                    $valorcred=0;				   
                                    $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('35 $consec','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','Ingreso por Identificar ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",".$valordeb.",'1','".$_POST[vigencia]."','35','$consec')";
                                    mysql_query($sqlr,$linkbd);
                        //			echo "<br>".$sqlr;
                                    $vi=$_POST[dvalores][$x]*($porce/100);			  
                                }		   
                            }
                            //echo "Conc: $sqlr <br>";
                        }
                    }
                }	
                //************ insercion de cabecera recaudos ************
                $sqlrIdentificar = "UPDATE tesosinidentificar SET estado='I' WHERE id_recaudo='$_POST[idrecaudo]'";
                mysql_query($sqlrIdentificar,$linkbd);
                $sqlr="insert into tesoidentificar (idcomp,fecha,vigencia,banco,ncuentaban,concepto,tercero,cc,valortotal,estado,tipo_mov) values('$_POST[idrecaudo]','$fechaf','".$_POST["vigencia"]."','$_POST[ter]','$_POST[cb]','".strtoupper($_POST[concepto])."','$_POST[tercero]','$_POST[cc]','$_POST[totalc]','S','$_POST[tipomovimiento]')";	  
                mysql_query($sqlr,$linkbd);
                $idrec=mysql_insert_id();
                //$idrec=$_POST[idcomp];
                //************** insercion de consignaciones **************
                for($x=0;$x<count($_POST[dcoding]);$x++)
                {
                    $sqlr="insert into tesoidentificar_det (id_identificar,ingreso,valor,estado,tipo_mov) values($idrec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S','$_POST[tipomovimiento]')";
                    //echo $sqlr;
                    if (!mysql_query($sqlr,$linkbd))
                    {
                        echo "<table >
                                <tr>
                                    <td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><	font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
                        //$e =mysql_error($respquery);
                        echo "Ocurrió el siguiente problema:<br>";
                        //echo htmlentities($e['message']);
                        echo "<pre>";
                        ///echo htmlentities($e['sqltext']);
                        // printf("\n%".($e['offset']+1)."s", "^");
                        echo "</pre></center></td></tr></table>";
                    }
                    else
                    {
                        $sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
                        $resi=mysql_query($sqlri,$linkbd);
                        //	echo "$sqlri <br>";	    
                        while($rowi=mysql_fetch_row($resi))
                        {
                            $porce=$rowi[5];
                            $vi=$_POST[dvalores][$x]*($porce/100);			 
                        }
                                        
                        echo "<table  class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Ingreso por Identificar con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
                    ?>	
                    <script>
                        document.form2.numero.value="";
                        document.form2.valor.value=0;
                    </script>
                    <?php
                    }
                }
                
                echo "<script>despliegamodalm('visible','1','Se ha almacenado el Ingreso por identificar con Exito');</script>";
            }
            else
            {
                ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
                $vigenciaReversion = $fecha[3];
                $consec = $_POST[numIngreso];
                $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,35,'$fechaf','".strtoupper($_POST[descripcion])."',0,$_POST[totalc],$_POST[totalc],0,'2')";
                mysql_query($sqlr,$linkbd);

                for($x=0;$x<count($_POST[dcoding]);$x++)
                {
                    //***** BUSQUEDA INGRESO ********
                    $sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."'  and vigencia=$vigenciaReversion";
                    $resi=mysql_query($sqlri,$linkbd);
                    //	echo "$sqlri <br>";	    
                    while($rowi=mysql_fetch_row($resi))
                    {
                        //**** busqueda concepto contable*****
                        $sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
                        $re=mysql_query($sq,$linkbd);
                        while($ro=mysql_fetch_assoc($re))
                        {
                            $_POST[fechacausa]=$ro["fechainicial"];
                        }
                        $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
                        $resc=mysql_query($sqlrc,$linkbd);	  
                        //		echo "con: $sqlrc <br>";	      
                        while($rowc=mysql_fetch_row($resc))
                        {
                            $porce=$rowi[5];
                            if($rowc[6]=='N')
                            {				 
                                $valorcred=$_POST[dvalores][$x]*($porce/100);
                                $valordeb=0;
                                $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('35 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','Reversion de Ingreso por Identificar ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'2','".$_POST[vigencia]."','35','$consec')";
                                mysql_query($sqlr,$linkbd);
                                //echo "<br>".$sqlr;
                                $valordeb=$_POST[dvalores][$x]*($porce/100);
                                $valorcred=0;				   
                                $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('35 $consec','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','Reversion de Ingreso por Identificar ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'2','".$_POST[vigencia]."','35','$consec')";
                                mysql_query($sqlr,$linkbd);
                    //			echo "<br>".$sqlr;
                                $vi=$_POST[dvalores][$x]*($porce/100);			  
                            }
                            //echo "Conc: $sqlr <br>";
                        }
                    }
                }
                $sqlr = "UPDATE tesoidentificar SET estado='R' WHERE id='$consec'";
                mysql_query($sqlr,$linkbd);
                $sqlrIdentificar = "UPDATE tesosinidentificar SET estado='S' WHERE id_recaudo='$_POST[idIngreso]'";
                mysql_query($sqlrIdentificar,$linkbd);
                $sqlr="insert into tesoidentificar (id,idcomp,fecha,vigencia,banco,ncuentaban,concepto,tercero,cc,valortotal,estado,tipo_mov) values($consec,$_POST[idIngreso],'$fechaf','".$_POST["vigencia"]."','$_POST[ter]','$_POST[cb]','".strtoupper($_POST[descripcion])."','$_POST[tercero]','$_POST[cc]','$_POST[totalc]','R','$_POST[tipomovimiento]')";	  
                mysql_query($sqlr,$linkbd);
                $idrec=mysql_insert_id();

                //************** insercion de consignaciones **************
                for($x=0;$x<count($_POST[dcoding]);$x++)
                {
                    $sqlr = "UPDATE tesoidentificar_det SET estado='R' WHERE id_identificar='$consec'";
                    mysql_query($sqlr,$linkbd);
                    $sqlr="insert into tesoidentificar_det (id_identificar,ingreso,valor,estado,tipo_mov) values($idrec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'R','$_POST[tipomovimiento]')";	  
                    if (!mysql_query($sqlr,$linkbd))
                    {
                        echo "<table >
                                <tr>
                                    <td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><	font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
                        echo "Ocurrió el siguiente problema:<br>";
                        echo "<pre>";
                        echo "</pre></center></td></tr></table>";
                    }
                    else
                    {
                        $sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
                        $resi=mysql_query($sqlri,$linkbd);
                        while($rowi=mysql_fetch_row($resi))
                        {
                            $porce=$rowi[5];
                            $vi=$_POST[dvalores][$x]*($porce/100);			 
                        }
                                        
                        echo "<table  class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Ingreso por Identificar con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
                    ?>	
                    <script>
                        document.form2.numero.value="";
                        document.form2.valor.value=0;
                    </script>
                    <?php
                    }
                }
                echo "<script>despliegamodalm('visible','1','Se ha reversado el Ingreso por identificar con Exito');</script>";
            }
	    }
        ?>	
		<div id="bgventanamodal2">
            <div id="ventanamodal2">
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
       	</div>	
    </form>
    </td>
    </tr>
</table>
</body>
</html> 		