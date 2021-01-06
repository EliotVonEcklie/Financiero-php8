<?php //V 1000 12/12/16 ?> 
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

//************* genera reporte ************
//***************************************
	function genrep(idfac)
	{
	  	document.form2.oculto.value=idfac;
	  	document.form2.submit();
	}
	
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
	
	//aqui inicia el codigo incrustado

	function adelante()
	{
		var maximo=document.form2.maximo.value;
		//alert(maximo);
		var actual=document.form2.idcomp.value;
		if(parseFloat(maximo)>parseFloat(actual))
		{
			var idcta=parseFloat(document.form2.idcomp.value)+1;
			location.href="teso-editarecaudotransferenciasgr.php?idrecaudo="+idcta;
		}
	}
		
	function atrasc()
	{
		var actual=document.form2.idcomp.value;
		if(0<parseFloat(actual))
		{
			var idcta=document.form2.idcomp.value-1;
			location.href="teso-editarecaudotransferenciasgr.php?idrecaudo="+idcta;
		}
	}
	
	function iratras()
	{
		var idcomp=document.form2.idcomp.value;
		location.href="teso-buscarecaudotransferenciasgr.php?id="+idcomp;
	}
	
	//aqui termina el codigo incrustado
		
	function validar()
	{
		document.form2.submit();
	}	
	
	function buscater(e)
 	{
		if (document.form2.tercero.value!="")
		{
 		document.form2.bt.value='1';
 		document.form2.submit();
 		}
 	}

	function agregardetalle()
	{
		if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
		{ 
			document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
			document.form2.submit();
 		}
 		else 
 		{
 			alert("Falta informacion para poder Agregar");
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

    //************* genera reporte ************
    //***************************************
	function guardar()
	{
		ingresos2=document.getElementsByName('dcoding[]');
		if (document.form2.fecha.value!='' && ingresos2.length>0)
	  	{
			if (confirm("Esta Seguro de Guardar"))
	  		{
			  	document.form2.oculto.value=2;
			  	document.form2.submit();
	  		}
	  	}
	  	else
	  	{
		  	alert('Faltan datos para completar el registro');
		  	document.form2.fecha.focus();
		  	document.form2.fecha.select();
	  	}
	}

	function pdf()
	{
		document.form2.action="teso-pdfrecaudostrans.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}

	function buscater(e)
 	{	
		if (document.form2.tercero.value!="")
		{
	 		document.form2.bt.value='1';
	 		document.form2.submit();
	 	}
	}

	function buscaing(e)
	{
		if (document.form2.codingreso.value!="")
		{
	 		document.form2.bin.value='1';
	 		document.form2.submit();
	 	}
	}

	function despliegamodal2(_valor)
	{
		document.getElementById("bgventanamodal2").style.visibility=_valor;
		if(_valor=="hidden")
		{
			document.getElementById('ventana2').src="";
		}
		else 
		{
			document.getElementById('ventana2').src="ingresos-ventana.php?ti=I&modulo=4";
		}
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
                <a href="teso-recaudotransferenciasgr.php" class="mgbt" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a>
                <a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a>
                <a href="teso-buscarecaudotransferenciasgr.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" /></a>
                <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
                <a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" /></a>
				<a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
            </td>
        </tr>		  
    </table>
    <tr>
        <td colspan="3" class="tablaprin" align="center"> 
        <?php
            $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
            $vigencia=$vigusu;
            $_POST[vigencia]=$vigencia;
	        //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
            if(!$_POST[oculto])
            {
                $_POST[tabgroup1]=1;
                $check1="checked";
                $fec=date("d/m/Y");
                $_POST[vigencia]=$vigencia;
                $linkbd=conectar_bd();
	            $sqlr="select *from cuentacaja where estado='S' and vigencia=".$vigusu;
	            $res=mysql_query($sqlr,$linkbd);
	            while ($row =mysql_fetch_row($res)) 
	            {
	                $_POST[cuentacaja]=$row[1];
	            }
	            switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';
                }
                if(!$_POST[oculto])
                {
                    $linkbd=conectar_bd();
	                $sqlr="select distinct *from tesorecaudotransferenciasgr, tesorecaudotransferenciasgr_det   where	  tesorecaudotransferenciasgr.id_recaudo=$_GET[idrecaudo]  AND tesorecaudotransferenciasgr.ID_recaudo=tesorecaudotransferenciasgr_det.ID_recaudo and tesorecaudotransferenciasgr_det.id_recaudo=$_GET[idrecaudo] and tesorecaudotransferenciasgr.tipo_mov='101'";	
                    $res=mysql_query($sqlr,$linkbd);
                    $cont=0;
                    $_POST[idcomp]=$_GET[idrecaudo];
                    $total=0;
                    while ($row =mysql_fetch_row($res))
	                {
                        $p1=substr($row[1],0,4);
                        $p2=substr($row[1],5,2);
                        $p3=substr($row[1],8,2);
                        $_POST[fecha]=$p3."/".$p2."/".$p1;
                        //echo "hola".$_POST[fecha];
                        $_POST[cc]=$row[8];
                        $_POST[liquidacion]=$row[1];
                        $_POST[dcoding][$cont]=$row[14];
                        $_POST[banco]=$row[3];
                        $_POST[dnbanco]=buscatercero($row[4]);
                        $_POST[dncoding][$cont]=buscaingreso($row[15]);
                        $_POST[tercero]=$row[7];
                        $_POST[ntercero]=buscatercero($row[7]);
                        $_POST[concepto]=$row[5];
						$total=$total+$row[16];
						$_POST[tiporet]=$row[12];
                        $_POST[totalc]=$total;
                        $_POST[dvalores][$cont]=$row[16];
                        $_POST[estadoc]=$row[10];
                        $cont=$cont+1;
	                }
		            $sqlr="select distinct *from tesorecaudotransferenciasgr, tesorecaudotransferenciasgr_det ,tesobancosctas   where	 tesobancosctas.ncuentaban= tesorecaudotransferenciasgr.ncuentaban  and tesorecaudotransferenciasgr.id_recaudo=$_GET[idrecaudo]  AND tesorecaudotransferenciasgr.ID_recaudo=tesorecaudotransferenciasgr_det.ID_recaudo and tesorecaudotransferenciasgr_det.id_recaudo=$_GET[idrecaudo]";	
                    $res=mysql_query($sqlr,$linkbd);
                    //$cont=0;
                    //echo $sqlr;
                    //$_POST[idcomp]=$_GET[idrecaudo];	
                    //$total=0;
                    while ($row =mysql_fetch_row($res)) 
	                {	
                        /*$p1=substr($row[2],0,4);
                        $p2=substr($row[2],5,2);
                        $p3=substr($row[2],8,2);
                        $_POST[fecha]=$p3."/".$p2."/".$p1;	
                        $_POST[cc]=$row[8];
                        $_POST[dcoding][$cont]=$row[13];*/
                        $_POST[banco]=$row[19];		 
                        $_POST[dnbanco]=buscatercero($row[4]);		 
                        /*$_POST[dncoding][$cont]=buscaingreso($row[13]);
                        $_POST[tercero]=$row[7];
                        $_POST[ntercero]=buscatercero($row[7]);
                        $_POST[concepto]=$row[6];
                        $total=$total+$row[15]; 
                        $_POST[totalc]=$total;
                        $_POST[dvalores][$cont]=$row[14];
                        $cont=$cont+1;		*/
	                }		
                }		 
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
            ?>
            <form name="form2" method="post" action=""> 
            <?php
            $sql = "SELECT id_recaudo FROM `tesorecaudotransferenciasgr` where 1 order by id_recaudo desc";
            $res=mysql_query($sql,$linkbd);
            $row =mysql_fetch_row($res);
            $_POST[maximo]=$row[0];
            //echo $_POST[maximo];
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
	        <div class="tabsmeci" style="min-height:26% !important;">
		        <div class="tab">
			        <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	    	        <label for="tab-1">Recaudo Transferencia</label>
	    	        <div class="content" style="overflow-x:hidden;">
	    		        <table class="inicio" align="center" >
                            <tr>
                                <td class="titulos" colspan="9"> Recaudos Transferencias SGR    </td>
                                <td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
                            </tr>
                            <tr>
                                <td style="width:10%;" class="saludo1" >No Recaudo:</td>
                                <td style="width:10%;">
									<a href="#" onClick="atrasc()">
										<img src="imagenes/back.png" alt="anterior" align="absmiddle">
									</a>
                                    <input name="idcomp" id="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" style="width:65%;" onKeyUp="return tabular(event,this) "  readonly>
                                    <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
									<a href="#" onClick="adelante()">
										<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
									</a>
									<input type="hidden" value="a" name="atras" >
									<input type="hidden" value="s" name="siguiente" >	
									<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
        	                    </td>
                                   
	  		                    <td style="width:7%;" class="saludo1">Fecha:</td>
                                <td style="width:10%;" >
                                    <input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" style="width:80%;" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" readonly>
                                </td>
                                <td  class="saludo1">Vigencia:</td>
                                <td >
                                    <input type="text" id="vigencia" name="vigencia" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>
                                </td>
                                <td style="width:10%;">
                                    <input name="estadoc" type="hidden"  value="<?php echo $_POST[estadoc]?>" onKeyUp="return tabular(event,this) "  readonly>
                                    <?php 
                                        if($_POST[estadoc]=="S"){
                                            $valuees="ACTIVO";
                                            $stylest="width:80%; background-color:#0CD02A; color:white; text-align:center;";
                                        }else if($_POST[estadoc]=="N"){
                                            $valuees="ANULADO";
                                            $stylest="width:80%; background-color:#FF0000; color:white; text-align:center;";
                                        }else if($_POST[estadoc]=="P"){
                                            $valuees="PAGO";
                                            $stylest="width:80%; background-color:#0404B4; color:white; text-align:center;";
                                        }else if($_POST[estadoc]=="R"){
                                            $valuees="REVERSADO";
                                            $stylest="width:80%; background-color:#FF0000; color:white; text-align:center;";
                                        }
                                        echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
                                    ?>
			                    </td>
								<td class="saludo1" style="width:8%;">Destino:</td>
								<td style="width:20%;">
									<select name="tiporet" id="tiporet">
										<option value="" >Seleccione...</option>
										<option value="N" <?php if($_POST[tiporet]=='N') echo "SELECTED"?>>Nacional</option>
										<option value="D" <?php if($_POST[tiporet]=='D') echo "SELECTED"?>>Departamental</option>
										<option value="M" <?php if($_POST[tiporet]=='M') echo "SELECTED"?>>Municipal</option>            
									</select>        
								</td>
		                    </tr>
                            <tr>
                                <td class="saludo1">Recaudado:</td>
                                <td colspan="3"> 
                                    <select id="banco" name="banco" style="width:100%;" onChange="validar()" onKeyUp="return tabular(event,this)">
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
                                <td colspan="2"> 
                                    <input type="text" id="nbanco" name="nbanco" style="width:100%;" value="<?php echo $_POST[nbanco]?>" readonly>
                                </td>
                                <td style="width:7%;" class="saludo1">Centro Costo:</td>
                                <td colspan='2' >
                                    <select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
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
                                <td style="width:10%;" class="saludo1">Concepto Recaudo:</td>
                                <td colspan="3">
                                    <input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%;" onKeyUp="return tabular(event,this)">
                                </td>
        
                                <td style="width:7%;" class="saludo1">NIT: </td>
                                <td style="width:5%;">
                                    <input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:100%;" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" readonly>
                                </td>
                                <td class="saludo1">Contribuyente:</td>
                                <td colspan='2'>
                                    <input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" onKeyUp="return tabular(event,this) " style="width:100%;" readonly>
                                    <input type="hidden" value="0" name="bt">
                                    <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
                                    <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
                                    <input type="hidden" value="1" name="oculto">
                                </td>
	                        </tr>
	                    	<tr>
                                

                            </tr>
                        </table>
	    	        </div>
		        </div>
		        <div class="tab">
			        <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
	    	        <label for="tab-2">Retencion ingresos propios</label>
	    	        <div class="content" style="overflow-x:hidden;">
	    		        <table class="inicio" style="overflow:scroll">
         					<tr><td class="titulos" colspan="3">Detalle Comprobantes</td></tr>
        					<tr>
                            	<td class="titulos2">Retencion</td>
                                <td class="titulos2">Nombre Retencion</td>
                                <td class="titulos2">Valor</td>
                         	</tr>
                            <input type="hidden" id="totaldes" name="totaldes" value="<?php echo $_POST[totaldes]?>" readonly>
							
      						<?php
									$totaldes=0;
									$_POST[dcuenta]=array();
									$_POST[ncuenta]=array();
									$_POST[rvalor]=array();
									$sqlr="select *from tesorecaudotransferenciaretencionsgr where id_recaudo=$_POST[idcomp]";
									$resd=mysql_query($sqlr,$linkbd);
									$iter='saludo1a';
									$iter2='saludo2';
									$cr=0;
									while($rowd=mysql_fetch_row($resd))
									{
                                        $nresult=buscaretencion($rowd[2]);
                                        echo "<tr class=$iter>
                                            <td>$rowd[2]</td>
                                            <td >$nresult</td>
                                            <td >".number_format($rowd[3],2)."</td>
                                        </tr>";
                                        echo "<tr>
                                                <td>
                                                    <input name='dcuenta[]' value='$rowd[2]' type='hidden'>
                                                </td>
                                                <td>
                                                    <input name='ncuenta[]' value='$nresult' type='hidden'>
                                                </td>
                                                <td >
                                                    <input name='rvalor[]' value='".number_format($rowd[3],2)."' type='hidden'>
                                                </td>
                                            </tr>";
                                        $var1=$rowd[3];
                                        $var1=$var1;
                                        $cuentavar1=$cuentavar1+$var1;
                                        $_POST[varto]=number_format($cuentavar1,2,".",",");
									}
									echo "<tr >
											<td ></td>
											<td>Total:</td>
											<td >
												<input name='varto' id='varto' value='$_POST[varto]' size='10' readonly>
											</td>
										 </tr>";
								
							?>
							<input type='hidden' name='contrete' value="<?php echo $_POST[contrete] ?>" />
        				</table>
	    	        </div>
		        </div>
                <div class="tab">
       			<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
       			<label for="tab-3">Afectacion Presupuestal</label>
       				<div class="content" style="overflow-x:hidden;"> 
         				<table class="inicio" style="overflow:scroll">
         					<tr><td class="titulos" colspan="4">Detalle Comprobantes</td></tr>
        					<tr>
                            	<td class="titulos2" style="width:15%">Cuenta</td>
                                <td class="titulos2">Nombre Cuenta</td>
                                <td class="titulos2" style="width:15%">Valor</td>
                                <td class="titulos2" style="width:30%"></td>
                         	</tr>
                            <input type="hidden" id="totaldes" name="totaldes" value="<?php echo $_POST[totaldes]?>" readonly>
							
      						<?php
							
									$totaldes=0;
									$_POST[dcuenta]=array();
									$_POST[ncuenta]=array();
									$_POST[rvalor]=array();
									$sqlr="select *from pptoingtranpptosgr where idrecibo=$_POST[idcomp] and vigencia='".$_POST[vigencia]."' and cuenta!=''";
									//echo $sqlr;
									$resd=mysql_query($sqlr,$linkbd);
									
									$iter='saludo1a';
									$iter2='saludo2';
									$cr=0;
									$iter='saludo1a';
                                    $iter2='saludo2';
                                    $var2 = 0;
									while($rowd=mysql_fetch_row($resd))
									{
								    	$nresult=buscacuentapres($rowd[1],$rowd[4]);
										echo "
										<input type='hidden' name='dcuenta[]' value='$rowd[1]'/>
										<input type='hidden' name='ncuenta[]' value='$nresult'/>
										<input type='hidden' name='rvalor[]' value='".number_format($rowd[3],2)."'/>
										<tr class=$iter>
											<td class='icoop'>$rowd[1]</td>
											<td class='icoop'>$nresult</td>
											<td class='icoop' style='text-align:right;'>".number_format($rowd[3],2)."</td>
											<td></td>
                                        </tr>";
                                        
										$var2=$rowd[3];
										$var2=$var2;
										$cuentavar2=$cuentavar2+$var2;
										$_POST[vartot]=number_format($cuentavar2,2,".",",");
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									 }
									echo "
										<input type='hidden' name='vartot' id='vartot' value='$_POST[vartot]'/>
										<tr >
											<td ></td>
											<td style='text-align:left;'>Total:</td>
											<td class='icoop' style='text-align:right;'>$_POST[vartot]</td>
										 </tr>";
								
							?>
							<input type='hidden' name='contrete' value="<?php echo $_POST[contrete] ?>" />
        				</table>
						
	   				</div>
  			 	</div> 
	        </div> 
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
			            document.getElementById('codingreso').focus();document.getElementById('codingreso').select();</script>
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
			                document.getElementById('valor').focus();document.getElementById('valor').select();
                        </script>
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
			    ?>
                <div class="subpantalla">
	   	            <table class="inicio">
                        <tr>
                            <td colspan="4" class="titulos">Detalle  Recaudos Transferencia SGR</td>
                        </tr>                  
                        <tr>
                            <td class="titulos2">Codigo</td>
                            <td class="titulos2">Ingreso</td>
                            <td class="titulos2">Valor</td>
                        </tr>
                        <?php 		
                        $iter='saludo1a';
                        $iter2='saludo2';
                        $_POST[totalc]=0;
                        for ($x=0;$x<count($_POST[dcoding]);$x++)
                        {
                            echo "<tr class='$iter'>
                                    <td>".$_POST[dcoding][$x]."</td>
                                    <td>".$_POST[dncoding][$x]."</td>
                                    <td>".$_POST[dvalores][$x]."</td>
                                  </tr>";
                            echo "<tr>
                                <td>
                                    <input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='hidden' style='width:100%;' >
                                </td >
                                <td>
                                    <input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='hidden'  style='width:100%;'>
                                </td>
                                <td>
                                    <input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden'  style='width:100%;'>
                                </td>
                                
                            </tr>";
                            $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
                            $_POST[totalcf]=number_format($_POST[totalc],2);
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
                        }
                        $resultado = convertir($_POST[totalc]);
                        $_POST[letras]=$resultado." Pesos";
                        echo "<tr class='$iter'>
                            <td style='width:5%;'>
                            </td>
                            <td style='width:80%;' class='saludo2'>Total</td>
                            <td style='width:15%;' class='saludo1'>
                                <input name='totalcf' type='text' value='$_POST[totalcf]' readonly>
                                <input name='totalc' type='hidden' value='$_POST[totalc]'>
                            </td>
                        </tr>
                        <tr>
                            <td style='width:5%;' class='saludo1'>Son:</td>
                            <td style='width:80%;'>
                                <input name='letras' type='text' value='$_POST[letras]' style='width:100%;' >
                            </td>
                        </tr>";
                        ?> 
	                </table>
                </div>
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