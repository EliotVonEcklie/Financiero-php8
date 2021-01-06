<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script src="css/programas.js"></script>
        <script src="css/calendario.js"></script>
		<script>
		function capturaTecla(e){ 
		var tcl = (document.all)?e.keyCode:e.which;
		if (tcl==115){
		alert(tcl);
		return tabular(e,elemento);
		}
		}
		function pdf()
		{
		document.form2.action="pdftraslados.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
		}
		</script>
		<script>
			function adelante(scrtop, numpag, limreg, totreg, next){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=next;
				var idcta=document.getElementById('codigo').value;
				totreg++;
				document.form2.action="presu-editaacuerdos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg;
				document.form2.submit();
			}
		
			function atrasc(scrtop, numpag, limreg, totreg, prev){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=prev;
				var idcta=document.getElementById('codigo').value;
				totreg--;
				document.form2.action="presu-editaacuerdos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&totreg="+totreg;
				document.form2.submit();
			}

			function iratras(scrtop, numpag, limreg){
				var idcta=document.getElementById('codigo').value;
				location.href="presu-buscartraslados.php?idcta="+idcta;
			}

			function adelante(){
				if(document.form2.siguiente.value!=''){
					location.href="presu-trasladosver.php?idac="+document.form2.siguiente.value;
				}
			}
		
			function atrasc(){
				if(document.form2.anterior.value!=''){
					location.href="presu-trasladosver.php?idac="+document.form2.anterior.value;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
    <body >
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<img src="imagenes/add.png" title="Nuevo" href="presu-traslados.php" class="mgbt"/><img src="imagenes/guardad.png" href="#" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" href="presu-buscartraslados.php" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/print.png" title="imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras()" class="mgbt"/>
				</td>
       		</tr>
        </table>
		<?php
		$linkbd=conectar_bd();

		$sqlr="select *from pptoacuerdos where (pptoacuerdos.valortraslado>0) and pptoacuerdos.tipo='M' ORDER BY vigencia DESC, consecutivo";
		$res=mysql_query($sqlr,$linkbd);
		$contacu=0;
		$_POST[actual]=$_GET[idac];
		while ($row=mysql_fetch_row($res)){
			if($contacu==0){
				$_POST[anterior]='';
			}
			if($row[0]==$_POST[actual]){
				$row=mysql_fetch_row($res);
				$_POST[siguiente]=$row[0];
				break;
			}
			$_POST[anterior]=$row[0];
			$contacu+=1;
		}



		$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$vigencia=$vigusu;
		if(!$_POST[oculto])
		{
			$linkbd=conectar_bd();
			$sqlr="select *from pptoacuerdos where pptoacuerdos.id_acuerdo=$_GET[idac]";
			$res=mysql_query($sqlr,$linkbd);
			$cont=0; 
			$ban=0;
			//echo $sqlr;
			while ($row=mysql_fetch_row($res))
			{ 
				$_POST[acuerdo]=$row[0];	
				$_POST[codigo]=$row[0];	
				if ($row[9]=='A')	$_POST[fin]='Anulado';
				if ($row[9]=='S')	$_POST[fin]='Sin Finalizar';
				if ($row[9]=='F')	$_POST[fin]='Finalizado';
				$p1=substr($row[3],0,4);
				$p2=substr($row[3],5,2);
				$p3=substr($row[3],8,2);
				$_POST[fecha]=$p3."-".$p2."-".$p1;		
				$resultado = convertir($row[7]);
				$_POST[letras]=$resultado." PESOS";
				$cont=$cont+1;
			}
			$_POST[adre]="TRASLADO PRESUPUESTAL";

			$_POST[tipomov]=3;	
			$sqlr1="select * from pptotraslados, pptocuentas where pptotraslados.cuenta=pptocuentas.cuenta and pptotraslados.vigencia=pptocuentas.vigencia and pptotraslados.id_acuerdo=$_GET[idac] and pptotraslados.estado='S'";
			$res1=mysql_query($sqlr1,$linkbd);
			$cont=0;
			$credt=0;
			$contra=0;
			while ($row1=mysql_fetch_row($res1))
		 	{		
				$_POST[dcuentas][$cont]=$row1[4];	
				$_POST[dncuentas][$cont]=$row1[9];	
				if ($row1[7]=='C')
				{	
					$_POST[dcreditos][$cont]=$row1[5];	
					$_POST[dcontras][$cont]='0';	
					$credt=$credt+$row1[5];
				}
				if ($row1[7]=='R')
				{		
					$_POST[dcreditos][$cont]=	'0';
					$_POST[dcontras][$cont]=$row1[5];	
					$contra=$contra+$row1[5];
				}		
				$cont=$cont+1;
				$credt=number_format($credt,2,",","");
				$contra=number_format($contra,2,",","");
				$_POST[cuentaing]=$credt;
				$_POST[cuentagas]=$contra;
			}	
		}

		?>
 		<?php
		//PARA REVISION MAÑANA A PRIMERA HORA
			/*if ($_GET[idacuerdo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idacuerdo];</script>";}
			$sqlr="Select * from pptoacuerdos ORDER BY pptoacuerdos.vigencia DESC, pptoacuerdos.consecutivo";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idacuerdo]!=""){
					if($_POST[codrec]!=""){
						$sqlr="Select * from pptoacuerdos where id_acuerdo='$_POST[codrec]'";
					}
					else{
						$sqlr="Select * from pptoacuerdos where id_acuerdo ='$_GET[idacuerdo]'";
					}
				}
				else{
					$sqlr="Select * from pptoacuerdos ORDER BY pptoacuerdos.vigencia DESC, pptoacuerdos.consecutivo";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[codigo]=$row[0];
				$_POST[numero]=$row[1];					
				$_POST[acuerdo]=$row[2];		
				$_POST[fecha]=$row[3];				
				$_POST[vigencia]=$row[4];				
				$_POST[tipoacuerdo]=$row[10];				
				$_POST[valoradicion]=$row[5];				
				$_POST[valorreduccion]=$row[6];				
				$_POST[valortraslados]=$row[7];				
				$_POST[valor]=$row[8];				
				$_POST[edicion]=$row[9];				
			}
 			if($_POST[oculto]!="2")
			{
				$sqlr="Select * from pptoacuerdos where id_acuerdo=$_POST[codigo] ";
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp))
				{
					$_POST[codigo]=$row[0];
					$_POST[numero]=$row[1];					
					$_POST[acuerdo]=$row[2];		
					$_POST[fecha]=$row[3];				
					$_POST[vigencia]=$row[4];				
					$_POST[tipoacuerdo]=$row[10];				
					$_POST[valoradicion]=$row[5];				
					$_POST[valorreduccion]=$row[6];				
					$_POST[valortraslados]=$row[7];				
					$_POST[valor]=$row[8];				
					$_POST[edicion]=$row[9];				
				}
			}
			//NEXT
			$sqln="Select * from pptoacuerdos where id_acuerdo > '$_POST[codigo]' ORDER BY vigencia DESC, consecutivo ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next=$row[0];
			//PREV
			$sqlp="Select * from pptoacuerdos where id_acuerdo < '$_POST[codigo]' ORDER BY vigencia DESC, consecutivo DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev=$row[0];*/
 		?>

 <form name="form2" method="post" action="">
    <table class="inicio" align="center" width="80%" >
      <tr >
        <td class="titulos" style="width:95%;" colspan="2">.: Traslados Presupuestal</td>
        <td class="cerrar" style="width:5%;"><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr>
      	<td style="width:75%;">
      		<table>
      			<tr  >
				  <td width="115" class="saludo1">Fecha:        </td>
			        <td width="194"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>   <a href="#" onClick="displayCalendarFor('fc_1198971545');"></a>        </td>
					 <td width="154" class="saludo1">Acto Administrativo:</td>
			          <td width="259" valign="middle" >
			          <a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
				        <input type="hidden" name="anterior" id="anterior" value="<?php echo $_POST[anterior] ?>">
				        <input type="hidden" name="actual" id="actual" value="<?php echo $_POST[actual] ?>">
					  <select name="acuerdo" onChange="validar2()" onKeyUp="return tabular(event,this)" style="width:80%;" disabled="disabled">
					<option value="-1">...</option>
					 <?php
					   $link=conectar_bd();
			  		   $sqlr="Select * from pptoacuerdos where tipo<>'I'";
						        $tv=4+$_POST[tipomov];
					 			$resp = mysql_query($sqlr,$link);
							    while ($row =mysql_fetch_row($resp)) 
							    {
								echo "<option value=$row[0] ";
								$i=$row[0];
								 if($i==$_POST[acuerdo])
						 			{
									 echo "SELECTED";
									 $_POST[nomacuerdo]=$row[1]." ".$row[2];
									 $_POST[vigencia]=$row[4];
									 $_POST[valorac]=$row[$tv];
									 $_POST[valorac2]=$row[$tv];
									 $_POST[valorac]=number_format($_POST[valorac],2,'.',',');		 
									 //******subrutina para cargar el detalle del acuerdo de adiciones
									 if($_POST[chacuerdo]=='2' )
									  {
									 $sqlr2="select *from pptoadiciones where id_acuerdo='$i'";
									 $resp2=mysql_query($sqlr2,$link);
								     while ($row2 =mysql_fetch_row($resp2)) 
									   {
									    $_POST[dcuentas][]=$row2[4];					
										 if(substr($row2[4],0,1)=='1')							
									    {$_POST[dcreditos][]=$row2[5];
										$_POST[dcontras][]=0;
										 $nresul=buscacuentapres($row2[4],1);
										 $_POST[dncuentas][]=$nresul;		}
										else{
										 $nresul=buscacuentapres($row2[4],2);
										 $_POST[dncuentas][]=$nresul;									
									    $_POST[dcontras][]=$row2[5];
										$_POST[dcreditos][]=0;
											}
									   }
									 //******subrutina para cargar el detalle del acuerdo de adiciones
									 $sqlr2="select *from pptoreducciones where id_acuerdo='$i'";
									 $resp2=mysql_query($sqlr2,$link);;
								     while ($row2 =mysql_fetch_row($resp2)) 
									   {
									    $_POST[dcuentas][]=$row2[4];
										 if(substr($row2[4],0,1)=='1')							
									    {$_POST[dcreditos][]=$row2[5];
										$_POST[dcontras][]=0;
										$nresul=buscacuentapres($row2[4],1);
									    $_POST[dncuentas][]=$nresul;							 
											}
										else							
									    {$_POST[dcreditos][]=$row2[5];
										$_POST[dcontras][]=0;														
										 $nresul=buscacuentapres($row2[4],2);
									    $_POST[dncuentas][]=$nresul;							 
											}
									   }
									  }///**** fin si cambio 
									 }
								  echo ">".$row[1]."-".$row[2]."</option>";	  
								}

					  ?>
					</select><input type="hidden" name="chacuerdo" value="1">	<input type="hidden" name="nomacuerdo" value="<?php echo $_POST[nomacuerdo]?>">	  
					<a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
					<input type="hidden" name="siguiente" id="siguiente" value="<?php echo $_POST[siguiente] ?>"></td>
					  <td width="98" class="saludo1">Vigencia:</td>
					  <td width="342"><input type="text" id="vigencia" name="vigencia" size="8" onKeyPress="javascript:return solonumeros(event)" 
					  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly><input type="hidden" name="adre" value="<?php echo $_POST[adre]?>">	</td>
			       </tr><tr>
				   <td class="saludo1">
					Valor Acuerdo:
					<input type="hidden" value="<?php echo $_POST[oculto] ?>" name="oculto" id="oculto">
					<input type="hidden" value="<?php echo $_POST[codigo] ?>" name="codigo" id="codigo">
					</td>
					<td><input name="valorac"  readonly="" type="text" value="<?php echo $_POST[valorac]?>" onKeyPress="javascript:return solonumeros(event)" 
					  onKeyUp="return tabular(event,this)"><input type="hidden"  id="valorac2" name="valorac2" value="<?php echo $_POST[valorac2]?>" readonly></td><td class="saludo1">Finalizar</td><td><input type="text" name="fin" value="<?php echo $_POST[fin]?>" id="fin"  disabled="disabled"></td>
				    </tr>
      		</table>
      	</td>
      	<td colspan="3" style="width:25%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>
      </tr>
      </table>
	   
	<?php
	if(!$_POST[oculto])
	{ 
		 ?>
		 <script>
    	document.form2.fecha.focus();
		</script>
	<?php
	}
	?>
		 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			  $linkbd=conectar_bd();
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta]";
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			  $_POST[valor]=$row[5];		  
			  $_POST[valor2]=$row[5];		  			  

  			  ?>
			  <script>
			  document.getElementById('valor').focus();
			  document.getElementById('valor').select();
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			  <?php
			  }
			 }
//******contracredito

			//**** busca cuenta
			if($_POST[bc2]!='')
			 {

			  $nresul=buscacuentapres($_POST[cuenta2],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta2]=$nresul;
			  $linkbd=conectar_bd();
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta2]";
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			  $_POST[valor]=$row[5];		  
			  $_POST[valor2]=$row[5];		  			  
  			  ?>
			  <script>
			  document.getElementById('valor').focus();
			  document.getElementById('valor').select();
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta2]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuenta2.focus();</script>
			  <?php
			  }
			 }
		?><div class="subpantallac" style="height:64%; width:99.6%; overflow-x:hidden;">
		<table class="inicio" width="99%">
        <tr>
          <td class="titulos" colspan="6">Detalle Comprobantes          </td>
        </tr>
		<tr>
		<td class="titulos2" style='width:10%;'>Cuenta Credito</td>
		<td class="titulos2" style='width:60%;'>Nombre Cuenta Credito</td>
		<td class="titulos2" style='width:15%;'>Credito</td>
		<td class="titulos2" style='width:15%;'>Contracredito</td>
		</tr>
		  <?php
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {
		 
		 echo "<tr><td class='saludo2'>
		 <input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%;' readonly></td><td class='saludo2'>
		 <input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' style='width:100%;'  readonly></td><td class='saludo2'>
		 <input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text'  style='width:100%;' readonly></td><td class='saludo2'>
		 <input name='dcontras[]' value='".$_POST[dcontras][$x]."' type='text'  style='width:100%;' onDblClick='llamarventana(this,$x)' readonly></td></tr>";
//		 $cred= $vc[$x]*1;
		 $cred=$_POST[dcreditos][$x];
 		 $contra=$_POST[dcontras][$x];		 
//		 $cred=number_format($cred,2,".","");
	//	 $deb=number_format($deb,2,".","");
		 $contra=$contra;
		 $cred=$cred;		 
		 $cuentacred=$cuentacred+$cred;
		 $cuentacontras=$cuentacontras+$contra;
		 $_POST[cuentacreditos2]=$cuentacreditos;
		 $_POST[cuentacontras2]=$cuentacontras;		 	
		 $diferencia=$cuentacred-$cuentacontras;
		 $total=number_format($total,2,",","");
		 $_POST[diferencia]=number_format($diferencia,2,".",",");
 		 $_POST[cuentacred]=number_format($cuentacred,2,".",",");
		 $_POST[cuentacontras]=number_format($cuentacontras,2,".",",");	 
		 }
		 echo "<tr><td >Diferencia:</td><td colspan='1' class='saludo1'><input id='diferencia' name='diferencia' value='$_POST[diferencia]' readonly></td><td class='saludo1'>
		 <input name='cuentacred' id='cuentacred' value='$_POST[cuentacred]' readonly>
		 <input name='cuentacreditos2' id='cuentacreditos2' value='$_POST[cuentacreditos2]' type='hidden'></td>	
		 <td class='saludo1'><input name='cuentacontras' id='cuentacontras' value='$_POST[cuentacontras]' readonly>
		 <input name='cuentacontras2' id='cuentacontras2' value='$_POST[cuentacontras2]' type='hidden'>
		 <input id='letras' name='letras' value='$_POST[letras]' type='hidden'><input name='cuentaing' id='cuentaing' value='$_POST[cuentaing]' type='hidden' readonly><input name='cuentagas' id='cuentagas' value='$_POST[cuentagas]' type='hidden' readonly></td></tr>";
		?>
		</table></div>
    </form>
 <?php
  //***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	if ($_POST[acuerdo]!="")
	 {
 	$nr="1";	
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	
	//echo "Click:$_POST[fin]";
	//***modificacion del acuerdo 
	if($_POST[fin]=='1' && ($_POST[valorac2]==$_POST[cuentaing2] && $_POST[valorac2]==$_POST[cuentagas2])) //**** si esta completa y finalizado
		    {
			 $sqlr="update pptoacuerdos set estado='F' where id_acuerdo='".$_POST[acuerdo]."'";
	 //echo "sqlr:".$sqlr;
		  	  mysql_query($sqlr,$linkbd);	  
			  echo "<table><tr><td class='saludo1'><center><h2>Se ha Actualizado el Presupuesto a la cuenta ".$_POST[dcuentas][$x]." con Exito</h2></center></td></tr></table>";
	    	  echo "<script>document.form2.acuerdo.value='';</script>";
		  	  echo "<script>document.form2.fecha.focus();</script>";
			} 
	if($_POST[fin]!='1' )  //***** si no esta finalizado guardado provisionalmente 	
		    {
			 $sqlr="update pptoacuerdos set estado='S' where id_acuerdo='".$_POST[acuerdo]."'";
	//echo "sqlr:".$sqlr;
		  	  mysql_query($sqlr,$linkbd);	  
			  echo "<table><tr><td class='saludo1'><center><h2>Se ha Actualizado el Presupuesto a la cuenta ".$_POST[dcuentas][$x]." con Exito</h2></center></td></tr></table>";
	    	  echo "<script>document.form2.acuerdo.value='';</script>";
		  	  echo "<script>document.form2.fecha.focus();</script>";
			} 
			
	///***********insercion de las cuentas al ppto inicial
	switch($_POST[tipomov])
	{
	case 1:
	 $sqlr="delete from pptocuentaspptoinicial where cuenta='".$_POST[dcuentas][$x]."' and vigencia='$_POST[vigencia]'";	 
		mysql_query($sqlr,$linkbd); 
	 for($x=0;$x<count($_POST[dcuentas]);$x++)	
	  {
	  if ($_POST[dingresos][$x]=='0')
	    {
		 $valores=$_POST[dgastos][$x];
		}
		else
		 {
		  $valores=$_POST[dingresos][$x];
		 }
		 //*** eliminar anteriores registros para crear el nuevo ppto inicial de la vigencia		
	 $sqlr="INSERT INTO pptocuentaspptoinicial (cuenta,fecha,vigencia,valor,estado,pptodef,saldos,saldoscdprp,id_acuerdo)VALUES ('".$_POST[dcuentas][$x]."','".$fechaf."','$_POST[vigencia]', $valores,'S',$valores,$valores,$valores,$_POST[acuerdo])";
	 //echo "sqlr:".$sqlr;
  	if (!mysql_query($sqlr,$linkbd))
		{
		 echo "<script>alert('ERROR EN LA CREACION DEL PRESUPUESTO INICIAL');document.form2.fecha.focus();</script>";
		}
		  else
		  {
		   
			  echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado el presupuesto inicial de la cuenta ".$_POST[dcuentas][$x]." con Exito</h2></center></td></tr></table>";
	    	  echo "<script>document.form2.acuerdo.value='';</script>";
		  	  echo "<script>document.form2.fecha.focus();</script>"; 
  		   }
		}   //****for
		break;		   
	 } //****switch
	 }//***if de acuerdo   
 else
  {
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear el Proceso</H2></center></td></tr></table>";
  echo "<script>document.form2.fecha.focus();</script>";  
  } 
 }//*** if de control de guardado
?> 
</td></tr>     
</table>
</body>
</html>