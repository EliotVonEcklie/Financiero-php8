<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
$linkbd=conectar_bd();
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
header("Cache-control: private"); // Arregla IE 6
date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html;"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		    <link href="css/css2.css" rel="stylesheet" type="text/css" />
            <link href="css/css3.css" rel="stylesheet" type="text/css" />
            <link href="calendario1/css/agenda.css" rel="stylesheet" type="text/css" />
            <link href="calendario1/css/agenda2.css" rel="stylesheet" type="text/css" />
            <link rel="shortcut icon" href="favicon.ico"/>
            <script type="text/javascript" src="calendario1/agenda.js"></script>
            <script type="text/javascript" src="css/programas.js"></script>
            <script type="text/javascript">
				function despliegamodal2(_valor)
				{
					document.getElementById("bgventanamodal2").style.visibility=_valor;
					if (_valor=="hidden"){document.getElementById('todastablas').innerHTML=""}
				}
				function actulizar(idfecha,idlinea)
				{
					despliegamodal2("hidden");
					var winat="actualizar";
					var pagaux='calendario1/mensajes-actualizar.php?fecha='+idfecha+'&'+'horaini='+idlinea;
					document.getElementById('todastablas').innerHTML='<div id="bgventanamodal2"><div id="ventanamodal2"><IFRAME  src="'+pagaux+'" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME></div></div>';
					despliegamodal2('visible');
				}
				function prueba(){var ca=document.getElementById('fecha');ca.focus();}
				function alertadiaria(afecha)
				{
					var winat="alertan";
					var pagaux='calendario1/malertas.php?fecha='+afecha;
					document.getElementById('todastablas').innerHTML='<div id="bgventanamodal2"><div id="ventanamodal2"><IFRAME  src="'+pagaux+'" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME></div></div>';
					despliegamodal2('visible');
				}
				function ventanaNueva2(idlinea)
				{
					var contlinea=document.getElementById(idlinea).innerHTML;
					var  elemento=contlinea.split('/');
					if (contlinea=="")
					{
						var winat="nuevo";
						var pagaux='calendario1/mensajes.php?fecha='+document.form2.fecha.value+'&'+'horaini='+idlinea;
					}
					else if(elemento[0]!="--")
						{
							var winat="actualizar";
							var pagaux='calendario1/mensajes-mirar.php?fecha='+document.form2.fecha.value+'&'+'horaini='+idlinea;
						}
						else
						{
							var winat="actualizar";
							var pagaux='calendario1/mensajes-mirar.php?fecha='+document.form2.fecha.value+'&'+'horaini='+elemento[1];
						}
					document.getElementById('todastablas').innerHTML='<div id="bgventanamodal2"><div id="ventanamodal2"><IFRAME  src="'+pagaux+'" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME></div></div>';
					despliegamodal2('visible');
				}
				var mensaven=0;var mensatotal=0;var mensapen=0;
				//addEventListener('unload',parent.document.revisamensajes(),false);
				
            </script>
    </head>
    <body>
    	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
    	<span id="todastablas2"></span>
		<?php //Calcula el total de Mensajes
		$hoy=date('Y-m-d');
        $sqlr="SELECT * FROM agenda WHERE usrecibe='$_SESSION[cedulausu]'";
        $res=mysql_query($sqlr,$linkbd);
        while ($rowEmp = mysql_fetch_assoc($res)) 
        {$dosss;?><script>mensatotal++;</script><?php }
        // calcu vencidos la los mensajes
        $sqlr="SELECT * FROM agenda WHERE fechaevento<'$hoy' AND usrecibe='$_SESSION[cedulausu]' AND estado='A' ";
        $res=mysql_query($sqlr,$linkbd);
        while ($rowEmp = mysql_fetch_assoc($res)) 
        {$dosss;?><script>mensaven++;</script><?php }
         // calcula los eventos pendientes
        $sqlr="SELECT * FROM agenda WHERE fechaevento>='$hoy' AND usrecibe='$_SESSION[cedulausu]' AND estado='A'";
        $res=mysql_query($sqlr,$linkbd);
        while ($rowEmp = mysql_fetch_assoc($res)) 
        {$dosss;?><script>mensapen++;</script><?php }?>
        <table>
            <tr><script> barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>
            <tr><?php menu_desplegable("plan");?></tr>
			<tr>
			<script>var pagini = '<?php echo $_GET[pagini];?>';</script>
				<td colspan="3" class="cinta">
					<a href="plan-agenda.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a>
					<a href=""  class="mgbt"><img src="imagenes/guardad.png"  title="Guardar" /></a>
					<a href="plan-agendabusca.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
					<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
			</tr>
        </table>	
        <form name="form2" method="post">
            <?php
                if ($_POST[oculnicio]==""){$fechamen=$_GET[fechamen];}
                if($fechamen!=""){$_POST[fecha]=$fechamen; $fecha=$fechamen;}
                if($_POST[fecha]==""){$_POST[fecha]=date("Y-m-d");}
                ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
                $age=$fecha[1];
                $mes=$fecha[2];
                $dia=$fecha[3];
                $lastday = mktime (0,0,0,$mes,$dia,$age);	  
            ?> 
            <table class="inicio">
                <tbody>
                    <tr><td id="nfecha"  class="titulos" colspan="2"></td><script>boton_cerrar();</script></tr>
                    <tr><td class="saludo1" colspan="3"> Seleccione el D&iacute;a</td></tr>
                    <tr>
                        <td valign="top" align="center" >                    
                            <div class="minicalendario">
                                <div class="minicalendario_age"><a href="#" onClick="prueba() "><?php echo $age ?></a></div>
                                <div class="minicalendario_mes"><?php echo strtoupper(strftime('%B',$lastday)) ?></div>
                                <div class="minicalendario_dia"><?php echo $dia ?></div>
                                <div class="minicalendario_base">::: <?php echo ucfirst(strftime('%A',$lastday)) ?> :::</div>
                            </div>
                            <input type="date" name="fecha" id="fecha" onChange="document.form2.submit()" value="<?php echo $_POST[fecha]?>">
                            <input type="hidden" name="oculto" value="0"><br><br>
                            <div>
                                <table class="inicio">
                                    <tr>
                                        <td colspan="2" id="pruel" class="saludo3">Clasificaci&oacute;n de Eventos
                                            <?php
                                                $linkbd=conectar_bd();
                                                $sqlr="SELECT valor_final,descripcion_valor FROM dominios WHERE nombre_dominio = 'PRIORIDAD_EVENTOS_AG'"; 
                                                $res=mysql_query($sqlr,$linkbd);
                                                while ($colmensa= mysql_fetch_assoc($res))
                                                {
                                                    $colorprioridad=$colmensa['valor_final'];
                                                    $nombreprioridad=$colmensa['descripcion_valor'];
                                            ?>
                                                    <script>
                                                        document.write('<tr><td width="20px" bgcolor="<?php echo $colorprioridad; ?>"></td> <td class="saludo3"><?php echo $nombreprioridad;?> </td></tr>');
                                                    </script>	
                                            <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <table class="inicio">
                                    <tr><td class="saludo3">
                                            <label >Eventos Pendientes: </label><label class="etiq2"><script>document.write(mensapen);</script></label>
                                    </td></tr>
                                    <tr><td class="saludo3">
                                                <label >Eventos Vencidos: </label><label class="etiq2"><script>document.write(mensaven);</script></label>
                                    </td></tr>
                                    <tr><td class="saludo3">
                                                <label >Total Eventos: </label><label class="etiq2"><script>document.write(mensatotal);</script></label>
                                    </td></tr>
                                </table>
                            </div>
                            <div>
                            	<table class="inicio">
                                	<tr>
                                    	<td class="saludo3">Recordatorios:</td> 
                                		<td>
                                        	<a href="#"><img src="imagenes/add.png" alt="Buscar" border="0"onClick="alertadiaria('<?php echo $_POST[fecha];?>');" style="width:20px;height:20px; -webkit-box-shadow: 2px 3px 4px rgba(0,0,0,.5);" title="Adicionar"/></a>
                                        </td>
                                        <td>
                                        	<a href="plan-alertasbusca.php"><img src="imagenes/busca.png" alt="Buscar" border="0" style="width:19px;height:19px;-webkit-box-shadow: 2px 3px 4px rgba(0,0,0,.5);" title="Programados"/></a>
                                        </td>
                                	</tr>
                                </table>
                            </div>
                        </td>
                        <td colspan="1">
                            <div id="agrupar">
                                <aside class="inicio">
                                    <article>
                                        <header>
                                            <div id="calendario" style="width:auto; height:400px; overflow:scroll;"> 
                                                <script> 
                                                    var body= document.getElementById('calendario');var nids=0;var nhoras=7;
                                                    for(var k =0; k <17; k++)
                                                    {		
                                                        var tabla   = document.createElement("table");
                                                        var tblBody = document.createElement("tbody"); 
                                                        var cuartosH=0;
                                                        var atid="";
                                                        for (var i = 0; i < 4; i++) 
                                                        {
                                                            var hilera = document.createElement("tr");
                                                            if(i==0)
                                                            {
                                                                var celda1 = document.createElement("td");
                                                                nhoras++;
                                                                if (nhoras<13)
                                                                {var textoCelda = document.createTextNode(nhoras+"am");}
                                                                else
                                                                {
                                                                    var rhoras=nhoras-12;
                                                                    var textoCelda = document.createTextNode(rhoras+"pm");
                                                                }
                                                                celda1.setAttribute("rowspan","6");
                                                                celda1.appendChild(textoCelda);
                                                                celda1.setAttribute("class","choras");	
                                                                hilera.appendChild(celda1);
                                                            }
                                                            for (var j = 0; j < 2; j++) 
                                                            {
                                                                var celda = document.createElement("td");
                                                                if(j==0)
                                                                {
                                                                    nids++;
                                                                    if(cuartosH==0)
                                                                    { 
                                                                        var textoCelda = document.createTextNode(":00 - 15");
                                                                        if (nhoras<10){atid="0"+nhoras+":00:00";}
                                                                        else {atid=nhoras+":00:00";}
                                                                    }
                                                                    else
                                                                    {
																		var cHh=cuartosH+15;
                                                                        var textoCelda = document.createTextNode(":"+cuartosH+" - "+cHh);	
                                                                        if(nhoras<10){atid="0"+nhoras+":"+cuartosH+":00";}
                                                                        else{atid=nhoras+":"+cuartosH+":00";}
                                                                    }
                                                                    celda.setAttribute("class","cminutos");	
                                                                    cuartosH=cuartosH +15;
                                                                }
                                                                else
                                                                {
                                                                    celda.setAttribute("id",atid);
                                                                    var textoCelda = document.createTextNode("");
                                                                    celda.setAttribute("class","cmensaje");	
                                                                    celda.setAttribute("onClick","ventanaNueva2(this.id)");
                                                                }
                                                                 celda.appendChild(textoCelda);
                                                                 hilera.appendChild(celda);
                                                            }
                                                            tblBody.appendChild(hilera);
                                                         }
                                                         tabla.appendChild(tblBody);
                                                         body.appendChild(tabla);
                                                         tabla.setAttribute("border", "1");
                                                         tabla.setAttribute("class","tmensajes");
                                                         tblBody.setAttribute("margin","0");
                                                    }
                                                    window.addEventListener('load', fecha_actual, false);
                                                </script>
                                            </div>                                        
                                        </header>
                                    </article>
                                </aside>
                            </div>
                         </td>
                    </tr>
                </tbody>
			</table> 
            <input id="horaocul"name="horaocul" type="hidden" value="0">  
			<input id="oculnicio"name="oculnicio" type="hidden" value="1">      
		</form>
		<span id="todastablas"></span>
        <?php
			$linkbd=conectar_bd();
			$sqlr="SELECT * FROM agenda WHERE usrecibe='$_SESSION[cedulausu]' AND fechaevento='$_POST[fecha]' ";
			$res=mysql_query($sqlr,$linkbd);
			while ($rowEmp = mysql_fetch_assoc($res)) 
			{
				$fechven=$rowEmp['horainicial'];
				$fechsum=explode(":",$fechven);
				$fechfin=explode(":",$rowEmp['horafinal']);
				$conini=date('H:i:s', mktime($fechsum[0],$fechsum[1],0,0,0,0));
				$confin=date('H:i:s', mktime($fechfin[0],$fechfin[1],0,0,0,0));
				$nomeven=$rowEmp['evento'];
				$desevento=$rowEmp['descripcion'];
				$prioeven=$rowEmp['prioridad'];
				$sqlr2="SELECT valor_final FROM dominios WHERE nombre_dominio='PRIORIDAD_EVENTOS_AG' AND valor_inicial='$prioeven'"; 
				$res2=mysql_query($sqlr2,$linkbd);
				$colmensa= mysql_fetch_assoc($res2);
				$colorevento=$colmensa['valor_final'];
				$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPO_EVENTO_AG' AND valor_inicial='$nomeven'";
				$res3=mysql_query($sqlr3,$linkbd);
				$temensa= mysql_fetch_assoc($res3);
				$texmensaje=$temensa['descripcion_valor'];
				$band1=0;
				while ($conini <= $confin) 
				{
					?><script>
						var ingresat=document.getElementById('<?php echo $conini;?>');
						var priori='<?php echo $prioeven;?>'
						var bandera='<?php echo $band1;?>';
						ingresat.style.backgroundColor='<?php echo $colorevento;?>';
						if	(bandera=='0')
						{
							ingresat.style.color="#FFFFFF";
							ingresat.innerHTML=('<?php echo $texmensaje;?>'+' - '+'<?php echo $desevento;?>');
						}
						else
						{
							ingresat.style.color='<?php echo $colorevento;?>';
							ingresat.innerHTML='--/'+'<?php echo $fechven;?>';
						}
					</script><?php	
					$fechsum[1]=$fechsum[1]+15;
					$conini=date('H:i:s', mktime($fechsum[0],$fechsum[1],0,0,0,0));
					$band1=$band1+1;
				}
			}	
		?>
    </body>
</html>