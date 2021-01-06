<?php
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6 //para poder actualizar
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Tesoreria</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script src="javaScript/funciones.js"></script>
        <script src="ajax/funcionesTesoreria.js"></script>
        <script type="text/javascript" src="css/funciones.js"></script>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap/css/estilos.css">
        <script type="text/javascript" src="css/sweetalert.js"></script>
		<script type="text/javascript" src="css/sweetalert.min.js"></script>
        <script type="text/javascript" src="bootstrap/fontawesome.5.11.2/js/all.js"></script>
		<link href="css/sweetalert.css" rel="stylesheet" type="text/css" />
		<script>
			function verUltimaPos(idcta, idc, filas, filtro)
			{
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag=="")){numpag=0;}
				if((limreg==0)||(limreg=="")){limreg=10;}
                numpag++;
				location.href="teso-editarnotasbancarias.php?idr="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<script>
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}
			}
			function validar(){document.form2.submit();}
			function buscater(e)
 			{
				if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}
 			}
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			//************* genera reporte ************
			//***************************************
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Eliminar la Nota Bancaria "+idr))
  				{
  					document.form2.oculto.value=2;
  					document.form2.var1.value=idr;
					document.form2.submit();
  				}
			}
			//************* genera reporte ************
			//***************************************
			function guardar()
			{
				if (document.form2.fecha.value!='')
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
				document.form2.action="teso-pdfconsignaciones.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php 
			titlepag();
			$scrtop=$_GET['scrtop'];
			if($scrtop=="") $scrtop=0;
			echo"<script>window.onload=function(){ $('#divdet').scrollTop(".$scrtop.")}</script>";
			$gidcta=$_GET['idcta'];
			if(isset($_GET['filtro']))
				$_POST[numero]=$_GET['filtro'];
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
				<a href="teso-notasbancarias.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png" title="Guardar" /></a>
				<a onClick="document.form2.submit();" class="mgbt" href="#"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>	
		</table>
 		<form name="form2" method="post" action="teso-buscanotasbancarias.php">
            <section>
                <div class="barra--titulo">
                    <h4 class="barra--titulo__h4">Notas Bancarias</h4>
                </div>
            </section>
            <section class="container--crear">
                <div class="form-group">
                    <div class="container row">
                        <div class="col-2 subtitulos--label">
                            <label for="" class="col-form-label label1">Num. Comprobante:</label>
                        </div>
                        <div class="col-1 container--crear__datos">
                            <input type="text" name="numero" id="numero" class="form-control input__num" aria-describedby="basic-addon1" value="<?php echo @$_POST[numero]; ?>">
                        </div>
                        <div class="col-1 subtitulos--label subtitulos--label__fecha">
                            <label for="" class="col-form-label label1">Fecha Ini:</label>
                        </div>
                        <div class="col-2 container--crear__datos container row">
                            <div class="col-9">
                                <input type="text" name="fechaini" value="<?php echo @$_POST[fechaini]; ?>" class="form-control imput--fecha" aria-describedby="basic-addon1" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" placeholder="DD/MM/YYYY">
                            </div>
                            <div class="col-2 container--crear__datos--a">
                                <a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
                            </div>
                        </div>
                        <div class="col-1 subtitulos--label subtitulos--label__fecha">
                            <label for="" class="col-form-label label1">Fecha Final:</label>
                        </div>
                        <div class="col-2 container--crear__datos container row">
                            <div class="col-9">
                                <input type="text" name="fechafin" value="<?php echo @$_POST[fechafin]; ?>" class="form-control imput--fecha" aria-describedby="basic-addon1" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" placeholder="DD/MM/YYYY">
                            </div>
                            <div class="col-2 container--crear__datos--a">
                                <a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-primary" name="agregar" id="agregar" onClick="document.form2.submit()">
                            <i class="fas fa-arrow-circle-down"></i>
                            Buscar
                            </button>
                        </div>
                    </div>  
                </div>    
            </section>
        	<?php
				if($_GET[numpag]!="")
				{
					$oculto=$_POST[oculto];
					if($oculto!=2)
					{
						$_POST[numres]=$_GET[limreg];
						$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
						$_POST[nummul]=$_GET[numpag]-1;
					}
				}
				else{if($_POST[nummul]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}}
			?>
            <input type="hidden" name="oculto" id="oculto" value="1">
         	<input type="hidden" name="var1" value=<?php echo $_POST[var1];?>>  
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/> 
	    <div class="subpantalla" style="height:66%; width:99.6%; overflow-x:hidden;" id="divdet">
      <?php
        $oculto=$_POST['oculto'];
        if($_POST[oculto]==2)
	    {
            $linkbd=conectar_bd();	
            $sqlr="select * from tesonotasbancarias_cab where id_comp=$_POST[var1]";
            $resp = mysql_query($sqlr,$linkbd);
            $row=mysql_fetch_row($resp);
            //********Comprobante contable en 000000000000
            $sqlr="update comprobante_cab set estado='0' where numerotipo=$row[1] AND tipo_comp=9";
            mysql_query($sqlr,$linkbd);
            $sqlr="update comprobante_det set estado='0' where id_comp='9 $row[1]'";
            mysql_query($sqlr,$linkbd);
            
            $sqlr="update pptocomprobante_cab set estado='0' where numerotipo=$row[1] AND tipo_comp=20";
            mysql_query($sqlr,$linkbd);
            
            //******** RECIBO DE CAJA ANULAR 'N'	 
            $sqlr="update tesonotasbancarias_cab set estado='N' where id_comp=$row[1]";
            mysql_query($sqlr,$linkbd);	  
            $sqlr="update tesonotasbancarias_det set estado='N' where id_notabancab=$row[1]";
            mysql_query($sqlr,$linkbd);
	    }

        //if($_POST[oculto])
        //{
        $linkbd=conectar_bd();
        $crit1=" ";
        $crit2=" ";
        if ($_POST[numero]!="")
        $crit1=" and tesonotasbancarias_cab.id_comp like '%".$_POST[numero]."%' ";
        if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
        {	
            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
            $fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
            $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];

            $crit2=" and tesonotasbancarias_cab.fecha between '$fechai' and '$fechaf'  ";
        }

        //sacar el consecutivo 
        //$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
        $sqlr="select *from tesonotasbancarias_cab where tesonotasbancarias_cab.estado<>'' ".$crit1.$crit2." order by tesonotasbancarias_cab.id_comp DESC";
        $resp = mysql_query($sqlr,$linkbd);
        $_POST[numtop]=mysql_num_rows($resp);
        $nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
        $cond2="";
        if ($_POST[numres]!="-1"){ 
            $cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
        }

        $sqlr="select *from tesonotasbancarias_cab where tesonotasbancarias_cab.estado<>'' ".$crit1.$crit2." order by tesonotasbancarias_cab.id_comp DESC $cond2";
        $resp = mysql_query($sqlr,$linkbd);
        $ntr = mysql_num_rows($resp);
        $con=1;
        $numcontrol=$_POST[nummul]+1;
        if($nuncilumnas==$numcontrol)
        {
            $imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
            $imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
        }
        else 
        {
            $imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
            $imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
        }
        if($_POST[numpos]==0)
        {
            $imagenback="<img src='imagenes/back02.png' style='width:17px'>";
            $imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
        }
        else
        {
            $imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
            $imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
        }

        $con=1;

        echo "
            <div class='bg-white contenedor-tabla rounded overflow-auto'>
            <table class='inicio' align='center' >
            <tr>
                <td width='96%' class='titulos'>.: Resultados Busqueda:</td>
                <td class='submenu'>
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
            <tr>
                <td colspan='7'>Notas Bancarias Encontrados: $ntr</td>
            </tr>
            </table>
            <table class='table table-striped table-hover'>
            <thead class='bg-info'>
                <tr>
                    <th scope='col'>No Nota Bancaria</th>
                    <th scope='col'>Fecha Costo</th>
                    <th scope='col'>Concepto Nota Bancaria</th>
                    <th scope='col'>Valor</th>
                    <th scope='col'>Estado Banco</th>
                    <th scope='col'>Anular</th>
                    <th scope='col'>Editar</th>
                </tr>
            </thead>
            <tbody>";		
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
$filas=1;
 while ($row =mysql_fetch_row($resp)) 
 {
	 
	 if($row[4]=='S')
		$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'"; 	 				  
	if($row[4]=='N')
		$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";
	if($gidcta!="")
	{
		if($gidcta==$row[0]){$estilo='background-color:#FF9';}
		else{$estilo="";}
	}
	else{$estilo="";}	
	
	$idcta="'".$row[1]."'";
	$idc="'".$row[1]."'";
	$numfil="'".$filas."'";
	$filtro="'".$_POST[numero]."'";
	 $sqlr="Select sum(valor) from tesonotasbancarias_det where id_notabancab=$row[1]";
	 $resn=mysql_query($sqlr,$linkbd);
	 $rn=mysql_fetch_row($resn);
    echo "
            <tr class='font-weight-normal' onDblClick=\"verUltimaPos($idcta, $idc, $numfil, $filtro)\">
                <td>$row[1]</td>
                <td>$row[2]</td>
                <td>$row[5]</td>
                <td>".number_format($rn[0],0)."</td>
                <td><img $imgsem style='width:18px' ></td>";
                if($row[4]=='S')
                echo "<td><a href='#' onClick=eliminar($row[1])><img src='imagenes/anular.png'></a></td>";		 
                if($row[4]=='N')
                echo "<td></td>";	
                echo"<td>
                    <a onClick=\"verUltimaPos($idcta, $idc, $numfil, $filtro)\" style='cursor:pointer;'>
                        <img src='imagenes/lupa02.png' style='width:18px' title='Editar'>
                    </a>
                </td>
            </tr>
        ";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	 $filas++;
 }
echo"</tbody>
</table>
</div>
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
//}
?></div>
</td></tr>     
</table>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
</body>
</html>