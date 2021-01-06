<?php

require "comun.inc";
require "funciones.inc";
$linkbd = conectar_bd();

?>

<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid</title>

        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script> 
			function ponprefijo(ingreso,concepto,valor,tercero,banco)
			{
				parent.document.form2.numIngreso.value =ingreso;
				parent.document.form2.concepto.value = concepto;
				parent.document.form2.valorIngreso.value=valor;
				parent.document.form2.tercero.value=tercero;
				parent.document.form2.banco.value=banco;
				parent.document.form2.numIngreso.focus();	
				parent.document.form2.numIngreso.select();
				parent.document.form2.concepto.focus();
                parent.document.form2.submit();
				parent.despliegamodal2("hidden");
			} 
		</script> 
        <?php titlepag();?>
    </head>
    <body>
        <form name="form2" action="" method="post">
            <?php
				if ($_POST[oculto]=='')
				{
					$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;
				}
			?>
            <table class="inicio" aling="center">
                <tr>
                    <td class="titulos" colspan="4">.: Buscar Ingresos sin identificar</td>
                    <td class="cerrar"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:15%">N&uacute;mero Ingreso:</td>
                    <td>
                        <input type="search" name="numero"  value="<?php echo $_POST[numero];?>" />
						<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;"/>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="oculto" id="oculto"  value="1">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantalla" style="height:84.5%; width:99%; overflow-x:hidden;">
                <?php
                $crit1="";
                if ($_POST[numero]!=""){
                    $crit1=" and (tesosinidentificar.id_recaudo like '%$_POST[numero]%') ";
                }
                $sqlr="SELECT tesosinidentificar.id_recaudo, tesosinidentificar.concepto, tesosinidentificar.tercero, tesosinidentificar.fecha, tesosinidentificar.estado, tesosinidentificar.valortotal FROM tesosinidentificar WHERE tesosinidentificar.estado='S' AND tesosinidentificar.tipo_mov='201' $crit1 ";
                $resp = mysql_query($sqlr,$linkbd);
                $_POST[numtop]=mysql_num_rows($resp);
                $nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
                $cond2="";
                if ($_POST[numres]!="-1"){ 
                    $cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
                }	
                $sqlr="SELECT tesosinidentificar.id_recaudo, tesosinidentificar.concepto, tesosinidentificar.tercero, tesosinidentificar.fecha, tesosinidentificar.estado, tesosinidentificar.valortotal, tesosinidentificar.banco, tesosinidentificar.ncuentaban FROM tesosinidentificar WHERE tesosinidentificar.estado='S' AND tesosinidentificar.tipo_mov='201' $crit1 $crit2 order by tesosinidentificar.id_recaudo desc $cond2 ";
                //echo $sqlr;
                $resp = mysql_query($sqlr,$linkbd);
                $con=1;
                $numcontrol=$_POST[nummul]+1;
                if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
                {
                    $imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
                    $imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
                }
                else 
                {
                    $imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
                    $imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
                }
                if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
                {
                    $imagenback="<img src='imagenes/back02.png' style='width:17px'>";
                    $imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
                }
                else
                {
                    $imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
                    $imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
                }
                echo "
                <table class='inicio' align='center' width='99%'>
                    <tr>
                        <td colspan='3' class='titulos'>.: Resultados Busqueda:</td>
                        <td class='submenu' style='width:2cm;'>
                            <select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
                                <option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
                                <option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
                                <option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
                                <option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
                                <option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
                                <option value='-1'"; if ($_POST[renumres]=='-1'){echo 'selected';} echo ">Todos</option>
                            </select>
                        </td>
                    </tr>
                    <tr><td colspan='5'>CxP Encontradas: $_POST[numtop]</td></tr>
                    <tr>
                        <td class='titulos2' style='width:3%'>Num. Ingreso</td>
                        <td class='titulos2' style='width:60%'>Concepto</td>
                        <td class='titulos2' style='width:8%'>Fecha</td>
                        <td class='titulos2' style='width:8%'>Valor</td>
                    </tr>";	
                $iter='saludo1a';
                $iter2='saludo2';
                while ($row =mysql_fetch_row($resp)) 
                {
                    $banco = '';
                    $detalle=$row[2];
                    $con2=$con+ $_POST[numpos];
                    $banco = buscabancocn($row[7],$row[6]);
                    echo"
                    <tr class='$iter' onClick=\"javascript:ponprefijo($row[0],'$row[1]',$row[5],$row[6],$banco)\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
                        <td>$row[0]</td>
                        <td>$row[1]</td>
                        <td>$row[3]</td>
                        <td >$row[5]</td>
                    </tr>";
                    $con+=1;
                    $aux=$iter;
                    $iter=$iter2;
                    $iter2=$aux;
                }
                echo"</table>
                    <table class='inicio'>
                        <tr>
                            <td style='text-align:center;'>
                                <a href='#'>$imagensback</a>&nbsp;
                                <a href='#'>$imagenback</a>&nbsp;&nbsp;";
                if($nuncilumnas<=9){$numfin=$nuncilumnas;}
                else{$numfin=9;}
                for($xx = 1; $xx <= $numfin; $xx++)
                {
                    if($numcontrol<=9){$numx=$xx;}
                    else{$numx=$xx+($numcontrol-9);}
                    if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
                    else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
                }
                echo "		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
                                &nbsp;<a href='#'>$imagensforward</a>
                            </td>
                        </tr>
                    </table>";
                ?>
            </div>
        </form>
    </body>
</html>
