<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
   <meta http-equiv="Content-Type" content="text/html" />
   <meta http-equiv="X-UA-Compatible" content="IE=9" />
   <title>:: SPID - Tesoreria</title>

   <script language="JavaScript1.2">
   function validar(){
   document.form2.submit();
   }
   </script>
   <script>
   function buscater(e) {
   if (document.form2.tercero.value!="")
   {
	document.form2.bt.value='1';
	document.form2.submit();
	}
	}
   </script>
   <script>
	   function pdf()
	   {
		   document.form2.action="pdfpredial.php";
		   document.form2.target="_BLANK";
		   document.form2.submit(); 
		   document.form2.action="";
		   document.form2.target="";
	   }
   </script>
<script>
function buscar()
 {
	// alert("dsdd");
 document.form2.buscav.value='1';
 document.form2.submit();
 }
</script>
<script>
function buscavigencias()
 {
	
 //document.form2.buscarvig.value='1';
vtotalpred=document.getElementsByName("dpredial[]"); 	
vtotaliqui=document.getElementsByName("dhavaluos[]"); 	
vtotalbomb=document.getElementsByName("dimpuesto1[]"); 	
vtotalmedio=document.getElementsByName("dimpuesto2[]"); 	
vtotalintp=document.getElementsByName("dipredial[]"); 	
vtotalintb=document.getElementsByName("dinteres1[]"); 	
vtotalintma=document.getElementsByName("dinteres2[]"); 	
vtotaldes=document.getElementsByName("ddescuentos[]"); 	
sumar=0;
sumarp=0;
sumarb=0;
sumarma=0;
sumarint=0;
sumarintp=0;
sumarintb=0;
sumarintma=0;
sumardes=0;
for(x=0;x<vtotaliqui.length;x++)
 {
	 sumar=sumar+parseFloat(vtotaliqui.item(x).value);
	 sumarp=sumarp+parseFloat(vtotalpred.item(x).value);
	 sumarb=sumarb+parseFloat(vtotalbomb.item(x).value);
	 sumarma=sumarma+parseFloat(vtotalmedio.item(x).value);
	 sumarint=sumarint+parseFloat(vtotalintp.item(x).value)+parseFloat(vtotalintb.item(x).value)+parseFloat(vtotalintma.item(x).value);
	 sumarintp=sumarintp+parseFloat(vtotalintp.item(x).value);
	 sumarintb=sumarintb+parseFloat(vtotalintb.item(x).value);
	 sumarintma=sumarintma+parseFloat(vtotalintma.item(x).value);	 	 
	 sumardes=sumardes+parseFloat(vtotaldes.item(x).value);
 }

document.form2.totliquida.value=sumar;
document.form2.totliquida2.value=sumar;
document.form2.totpredial.value=sumarp;
document.form2.totbomb.value=sumarb;
document.form2.totamb.value=sumarma;
document.form2.totint.value=sumarint;
document.form2.intpredial.value=sumarintp;
document.form2.intbomb.value=sumarintb;
document.form2.intamb.value=sumarintma;
document.form2.totdesc.value=sumardes;
 }
</script>

<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('numpredial').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('numpredial').value=next;
					var idcta=document.getElementById('numpredial').value;
					document.form2.action="teso-predialver.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('numpredial').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('numpredial').value=prev;
					var idcta=document.getElementById('numpredial').value;
					document.form2.action="teso-predialver.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('numpredial').value;
				location.href="teso-buscapredial.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>

<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=22*$totreg;
		?>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
  		<td colspan="3" class="cinta">
		 <a href="teso-predial.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
		 <a href="#" class="mgbt1"><img src="imagenes/guardad.png"  alt="Guardar"  title="Guardar"/></a>
		 <a href="teso-buscapredial.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a>
		 <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a>
		 <a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" title="Buscar"/></a>
		 <a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>		  
</table>
	<tr>
		<td colspan="3" class="tablaprin" align="center"> 
		<?php
			$vigencia=date(Y);
		?>	
		<?php
			$linkbd=conectar_bd();
		 	$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			if ($_GET[idpredial]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idpredial];</script>";}
			$sqlr="select MIN(idpredial), MAX(idpredial) from tesoliquidapredial ORDER BY idpredial";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idpredial]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from tesoliquidapredial where idpredial='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from tesoliquidapredial where idpredial ='$_GET[idpredial]'";
					}
				}
				else{
					$sqlr="select * from  tesoliquidapredial ORDER BY idpredial DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[idpredial]=$row[0];			
				$_POST[numpredial]=$row[0];
		}

		//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
		$linkbd=conectar_bd();
		$fec=date("d/m/Y");
		// $_POST[fecha]=$fec; 		 		  			 
	 	$_POST[vigencia]=$_SESSION[vigencia]; 		
		$check1="checked";
		$sqlr="select *from tesoliquidapredial where idpredial=$_POST[numpredial]";
		//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$_POST[idpredial]=$r[0];			
		$_POST[numpredial]=$r[0];
		$_POST[codcat]=$r[1];
		$_POST[fecha]=$r[2];
		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
		$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];	
		
		$_POST[vigencia]=$r[3];	
		if($r[18]=='S'){ 
			$valuees="ACTIVO";
            $stylest="width:100%; background-color:#0CD02A; color:white; text-align:center;";
		}
		if($r[18]=='P'){
			$valuees="PAGO";
            $stylest="width:100%; background-color:#0404B4; color:white; text-align:center;"; 	 				  
		}
		if($r[18]=='N'){
			$valuees="ANULADO";
            $stylest="width:100%; background-color:#FF0000; color:white; text-align:center;"; 
		}
//			$_POST[fecha]=$r[2];					
//*************TASAS ******
	$sqlr="select *from tesotasainteres where vigencia=".$_SESSION[vigencia];
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$tasam=array();
	$tasam[0]=$r[6];									
	$tasam[1]=$r[7];
	$tasam[2]=$r[8];
	$tasam[3]=$r[9];
	$tasamoratoria[0]=0;
	$sqlr="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='COBRO_ALUMBRADO' AND tipo='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
		$_POST[cobroalumbrado]=$row[0];
		$_POST[vcobroalumbrado]=$row[1];
		$_POST[tcobroalumbrado]=$row[2];
	}
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
//			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			//echo $fecha[2];
	if($fecha[2]<=3)
			 {
			  $tasamoratoria[0]=$tasam[0];				 
			 }
				else
				  {
				  if($fecha[2]<=6)
				   {
					$tasamoratoria[0]=$tasam[1];
									   
				   }
					else
					 {
					  if($fecha[2]<=6)
					   {
						$tasamoratoria[0]=$tasam[2];
					   }
						else   
					    {
 						$tasamoratoria[0]=$tasam[3];
					    }						
					 }
				   }
				$_POST[tasamora]=$tasamoratoria[0];   
			$_POST[tasa]=0;
			$_POST[predial]=0;
			$_POST[descuento]=0;
			//***** BUSCAR FECHAS DE INCENTIVOS
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
			$sqlr="select *from tesodescuentoincentivo where vigencia=".$_SESSION[vigencia]." and ingreso='01' and estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			while($r=mysql_fetch_row($res))
			{	
		
			  if($r[7]<=$fechaactual && $fechaactual <= $r[8])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[2];	   
			   }
			  if($fechaactual>$r[9] && $fechaactual <= $r[10])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[3];	   
			   }
			  if($fechaactual>$r[11] && $fechaactual <= $r[12])
			   {
				 $fdescuento=$r[2];	 
				 $_POST[descuento]=$r[4];	   
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

			//NEXT
			$sqln="select *from tesoliquidapredial WHERE idpredial > '$_POST[idpredial]' ORDER BY idpredial ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from tesoliquidapredial WHERE idpredial < '$_POST[idpredial]' ORDER BY idpredial DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";

?>
<form name="form2" method="post" action="">
  <?php
  	$linkbd=conectar_bd();
 	$_POST[dcuentas]=array();
	$_POST[dncuentas]=array();
	$_POST[dtcuentas]=array();		 
	$_POST[dvalores]=array();

	$linkbd=conectar_bd();
	$sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]." ";
	//echo "s:$sqlr";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
  		//$_POST[vigencia]=$row[0];
		$_POST[catastral]=$row[0];
		$_POST[ord]=$row[1];
		$_POST[tot]=$row[2];
		$_POST[ntercero]=$row[6];
		$_POST[tercero]=$row[5];
		$_POST[direccion]=$row[7];
		$_POST[ha]=$row[8];
		$_POST[mt2]=$row[9];
		$_POST[areac]=$row[10];
		$_POST[avaluo]=number_format($row[11],2);
		$_POST[avaluo2]=number_format($row[11],2);
		$_POST[vavaluo]=$row[11];
		$_POST[tipop]=$row[14];
		if($_POST[tipop]=='urbano'){
			$_POST[estrato]=$row[15];
			$tipopp=$row[15];
		}
		else{
			$_POST[rangos]=$row[15];
			$tipopp=$row[15];
		}
				// $_POST[dcuentas][]=$_POST[estrato];		
		 $_POST[dtcuentas][]=$row[1];		 
		 $_POST[dvalores][]=$row[5];
		 $_POST[buscav]="";
		 $sqlr2="select *from tesotarifaspredial where vigencia='".$_SESSION[vigencia]."' and tipo='$_POST[tipop]' and estratos=$tipopp";
			//echo $sqlr2;
		 $res2=mysql_query($sqlr2,$linkbd);
	 		while($row2=mysql_fetch_row($res2))
			  {				  
			   $_POST[tasa]=$row2[5];
			   $_POST[predial]=($row2[5]/1000)*$_POST[vavaluo];
			   $_POST[predial]=number_format($_POST[predial],2);
			  }
	  }
	  	 // echo "dc:".$_POST[dcuentas];

?>
	<div class="tabspre">
   		<div class="tab">
       		<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   		<label for="tab-1">Liquidacion Predial</label>
	   		<!--Pestaña Liquidacion Predial-->
	   		<div class="content">
           		<table class="inicio" align="center" >
      				<tr >
        				<td class="titulos" colspan="9">Liquidar Predial</td>
                        <td style="width:7%" class="cerrar" >
                        	<a href="teso-principal.php">Cerrar</a>
                        </td>
      				</tr>
     				<tr>
     					<td style="width:10%;" class="saludo1">No Liquidaci&oacute;n:</td>
                        <td style="width:10%;">
		        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                        	<input id="numpredial" name="numpredial" type="text" value="<?php echo $_POST[numpredial]?>"  style="width:50%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>
                            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
                            <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
                            <input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
                            <input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">

						  	<input id="ord" type="hidden" name="ord" value="<?php echo $_POST[ord]?>">
						  	<input id="tot" type="hidden" name="tot" value="<?php echo $_POST[tot]?>">
							<input type="hidden" name="cobroalumbrado" value="<?php echo  $_POST[cobroalumbrado] ?>"/>
							<input type="hidden" name="vcobroalumbrado" value="<?php echo  $_POST[vcobroalumbrado] ?>"/>
							<input type="hidden" name="tcobroalumbrado" value="<?php echo  $_POST[tcobroalumbrado] ?>"/>
                       	</td>
                        <td style="width:7%;" class="saludo1">Fecha:</td>
                        <td style="width:10%">
                        	<input name="fecha" id="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" style="width:100%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>
                       	</td>
                        <td style="width:7%;" class="saludo1">Vigencia:</td>
                        <td style="width:10%">
                        	<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" style="width:100%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>
                       	</td>
                        <td style="width:10%;" class="saludo1">Tasa Interes Mora:</td>
                        <td style="width:7%">
                        	<input name="tasamora" type="text" value="<?php echo $_POST[tasamora]?>" style="width:80%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>%
                       	</td>
    					<td style="width:7%;" class="saludo1">Descuento:</td>
                        <td style="width:7%">
                        	<input name="descuento" type="text" value="<?php echo $_POST[descuento]?>"  style="width:80%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>%
                       	</td>
                  	</tr>
	  				<tr> 
                    	<td class="saludo1">C&oacute;digo Catastral:</td>
          				<td>
                        	<input id="codcat" type="text" name="codcat" style="width:100%" onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" readonly>
                            <input type="hidden" value="0" name="bt"> 
                            <input type="hidden" name="chacuerdo" value="1">
                            <input type="hidden" value="1" name="oculto" id="oculto">
                            <input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav">
                       	</td>
                        <td class="saludo1">Avaluo Vigente:</td>
                        <td>
                        	<input name="avaluo2" value="<?php echo $_POST[avaluo2]?>" type="text" style="width:100%" readonly>
                            <input type="hidden" name="vavaluo"  value="<?php echo $_POST[vavaluo]?>" > 
                       	</td>
                        <td class="saludo1">Tasa Predial:</td>
                        <td>
                        	<input name="tasa" value="<?php echo $_POST[tasa]?>" type="text" style="width:50%" readonly>xmil
                       	</td>
                       	<td class="saludo1">Estado:</td>
                        
                           <?php	echo  "<td><input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly /></td>"?>
                         <td>   <input name="predial" value="<?php echo $_POST[predial]?>" type="hidden"  readonly>
							
                       	</td>
        			</tr>
        			
	  			</table>
			</div> 
		</div>

		<!--Pestaña Informacion Predio -->
     	<div class="tab">
       		<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       		<label for="tab-2">Informacion Predio</label>
       		<div class="content"> 
		  		<table class="inicio">
	  				<tr>
	    				<td class="titulos" colspan="9">Informacion Predio</td>
                        <td style="width:7%" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
                   	</tr>
	  				<tr>
	  					<td style="width:3.5cm" class="saludo1">Codigo Catastral:</td>
	  					<td  style="width:20%" >
                        	<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
                            <input name="catastral" type="text" id="catastral" onBlur="buscater(event)"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>"  style="width:100%" readonly>
                      	</td>
		 				<td style="width:2.5cm" class="saludo1">Avaluo:</td>
	  					<td style="width:10%" >
                        	<input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>"  style="width:100%" readonly>
      					</td>
      					<td class="saludo1">Documento:</td>
	  					<td>
                        	<input name="tercero" type="text" id="tercero" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>" style="width:100%" readonly>
	  					</td>
	  					<td class="saludo1">Propietario:</td>
	  					<td colspan="5" >
                        	<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
                        	<input name="ntercero" type="text" id="propietario" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ntercero]?>"  style="width:78%" readonly>
                       	</td>
                  	</tr>
      				<tr>
	  					<td class="saludo1">Direccion:</td>
	  					<td style="width:20%;">
                        	<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" style="width:100%" readonly>
                       	</td>
		 				<td style="width:1.5cm" class="saludo1">Ha:</td>
	  					<td style="width:10%">
                        	<input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" style="width:100%" readonly>
	  					</td>
	  					<td style="width:1.5cm" class="saludo1">Mt2:</td>
	  					<td style="width:7%">
                        	<input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" style="width:100%" readonly>
                       	</td>
	  					<td style="width:2.5cm" class="saludo1">Area Cons:</td>
	  					<td style="width:25%">
                        	<input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" style="width:50%" readonly>
                       	</td>
      				</tr>
	  				<tr>
	     				<td  class="saludo1">Tipo:</td>
                        <td style="width:20%;">
                        	<select name="tipop" onChange="validar();" disabled>
       							<option value="">Seleccione ...</option>
				  				<option value="urbano" <?php if($_POST[tipop]=='urbano') echo "SELECTED"?>>Urbano</option>
  				  				<option value="rural" <?php if($_POST[tipop]=='rural') echo "SELECTED"?>>Rural</option>
				  			</select>
                 		</td>
         				<?php
		 				if($_POST[tipop]=='urbano'){
		  				?> 
        					<td class="saludo1">Estratos:</td>
                            <td>
                            	<select name="estrato"  disabled>
       								<option value="">Seleccione ...</option>
            						<?php
									$linkbd=conectar_bd();
									$sqlr="select *from estratos where estado='S'";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)){
										echo "<option value=$row[0] ";
										$i=$row[0];
										if($i==$_POST[estrato]){
											echo "SELECTED";
											$_POST[nestrato]=$row[1];
										}
										echo ">".$row[1]."</option>";	 	 
									}	 	
									?>            
								</select>  
            					<input type="hidden" value="<?php echo $_POST[nestrato]?>" name="nestrato">
            				</td>  
          				<?php
		 				}
		 				else{
							?>  
                                <td class="saludo1">Rango Avaluo:</td>
                                <td>
                                    <select name="rangos" >
	                                    <option value="">Seleccione ...</option>
                                    	<?php
                                        $linkbd=conectar_bd();
                                        $sqlr="select *from rangoavaluos where estado='S'";
                                        $res=mysql_query($sqlr,$linkbd);
                                        while ($row =mysql_fetch_row($res)){
                                        	echo "<option value=$row[0] ";
                                            $i=$row[0];
                                            if($i==$_POST[rangos]){
                                             	echo "SELECTED";
                                                $_POST[nrango]=$row[1]." - ".$row[2]." SMMLV";
                                            }
                                            echo ">Entre ".$row[1]." - ".$row[2]." SMMLV</option>";	 	 
                                       	}	 	
                                        ?>            
                                    </select>
            						<input type="hidden" value="<?php echo $_POST[nrango]?>" name="nrango">            
                                    <input type="hidden" value="0" name="agregadet">
                              	</td>
                			<?php
		  					}
		  					?> 
        				</tr> 
      				</table>
				</div> 
			</div>    
		</div>
	  	<div class="subpantallac4">
      <table class="inicio">
	   	   <tr>
	   	     <td colspan="13" class="titulos">Periodos a Liquidar  </td>
	   	   </tr>                  
		<tr>
		  <td class="titulos2">Vigencia</td>
		  <td class="titulos2">Codigo Catastral</td>
   		  <td class="titulos2">Predial</td>
   		  <td class="titulos2">Intereses</td>          
		  <td class="titulos2">Sobretasa Bombe</td>
          <td class="titulos2">Intereses</td>
		  <td class="titulos2">Sobretasa Amb</td>
          <td class="titulos2">Intereses</td>
			<?php 
			$siAlumbrado=0;
			$sqlrDesc = "SELECT vigencia, descuentointpredial, descuentointbomberil, descuentointambiental, val_alumbrado FROM tesoliquidapredial_desc WHERE id_predial='$_POST[numpredial]' ORDER BY vigencia ASC";
			$resDesc = mysql_query($sqlrDesc,$linkbd);
			while ($rowDesc =mysql_fetch_assoc($resDesc))
			{
				$descuentointpredial[] = $rowDesc['descuentointpredial'];
				$descuentointbomberil[] = $rowDesc['descuentointbomberil'];
				$descuentointambiental[] = $rowDesc['descuentointambiental'];
				$val_alumbrado[] = $rowDesc['val_alumbrado'];
			}
			$siAlumbrado =  array_sum($val_alumbrado);
			if($siAlumbrado>0)
			{
				echo "<td class='titulos2'>Alumbrado Publico</td>";
			}
			?>
          <td class="titulos2">Descuentos</td>
          <td class="titulos2">Valor Total</td>
          <td class="titulos2">Dias Mora</td>
		  <td width="3%" class="titulos2">Sel
		    <input type='hidden' name='buscarvig' id='buscarvig'></td></tr>
            	<?php			
				$sqlr2="select *from tesoliquidapredial_det where idpredial=$_POST[idpredial]";
				//echo $sqlr2;
				$res3=mysql_query($sqlr2,$linkbd);
				$cuentavigencias = mysql_num_rows($res);
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$sq="select interespredial from tesoparametros ";
				$result=mysql_query($sq,$linkbd);
				$rw=mysql_fetch_row($result);
				$interespredial=$rw[0];
				$xx = 0;
				$interesesPredial = 0;
				$interesesBomberil = 0;
				$interesesAmbiental = 0;
				$descuentoPredial = 0;
				$_POST[totpredial] = 0;
				$_POST[totbomb] = 0;
				$_POST[totamb] = 0;
				$_POST[totint] = 0;
				$_POST[totdesc] = 0;
				while($r3=mysql_fetch_row($res3)){
				$diasd=0;
				
				$sqlr="select *from tesodescuentoincentivo where vigencia='$vigusu' and ingreso='01' and estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				$ulfedes=explode("-",$r[12]);
				
				//echo "</br>".$_SESSION[vigencia];
				if ($cuentavigencias>1)
				{
					if($_SESSION[vigencia]==$r3[1] && $_POST[descuento]>0)
					{
					$diasd=0;
					$totalintereses=0; 
					$sidescuentos=0;
					}
					
					elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del año 
					{
						
						//$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r[0]);
						$fechaini=mktime(0,0,0,1,1,$r3[1]);
						$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
						$difecha=$fechafin-$fechaini;
						$diasd=$difecha/(24*60*60);
						$diasd=floor($diasd);
						$totalintereses=0; 
					}
					else //Si se cuentan los dias desde el final de descuento incentivo 
					{
						
						$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r3[1]);
						//echo "Hola ".$r3[1];
						$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
						$difecha=$fechafin-$fechaini;
						$diasd=$difecha/(24*60*60);
						$diasd=floor($diasd);
						$totalintereses=0; 
					}
				}
				else
				{
					if($_SESSION[vigencia]==$r3[1] && $_POST[descuento]>0)
					{
					$diasd=0;
					$totalintereses=0; 
					$sidescuentos=0;
					}
					elseif ($interespredial=='inicioanio')//Si se cuentan los dias desde el principio del año 
				   				{
									//$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r[0]);
									//echo "aqui";
									$fechaini=mktime(0,0,0,1,1,$r3[0]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
									$diasd=$difecha/(24*60*60);
									$diasd=floor($diasd);
									$totalintereses=0; 
				   				}
								else //Si se cuentan los dias desde el principio del año 
								{
									//echo "hola";
									$fechaini=mktime(0,0,0,$ulfedes[1],$ulfedes[2],$r3[0]);
									$fechafin=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
									$difecha=$fechafin-$fechaini;
									$diasd=$difecha/(24*60*60);
									$diasd=floor($diasd);
									$totalintereses=0; 
								}
				}
				$valorAlumbrado=0;
				$totalDeudaPotVigencia=0;
				if($_POST[tcobroalumbrado]=='S' && $_POST[tipop]=='rural' && $r3[1]>'2016')
				{
					$valorAlumbrado=round($r3[2]*($_POST[vcobroalumbrado]/1000),0);
				}
				$totalDeudaPotVigencia=$r3[11];
			//*************	
			$interesesPredial = $r3[5]+$descuentointpredial[$xx];
			$interesesBomberil = $r3[7]+$descuentointbomberil[$xx];
			$interesesAmbiental = $r3[9]+$descuentointambiental[$xx];
			$descuentoPredial = $r3[10]+$descuentointpredial[$xx]+$descuentointbomberil[$xx]+$descuentointambiental[$xx];
			 echo "<tr>
						 <td class='saludo1'><input name='dvigencias[]' value='".$r3[1]."' type='text' size='4' readonly></td>
						 <td class='saludo1'>
							<input name='dcodcatas[]' value='".$_POST[codcat]."' type='text' size='16' readonly>
							<input name='dvaloravaluo[]' value='".$r3[2]."' type='hidden' >
							<input name='dtasavig[]' value='".$r3[3]."' type='hidden' >
						</td>
						<td class='saludo1'>
							<input name='dpredial[]' value='".$r3[4]."' type='text' size='12' readonly>
						</td>
						<td class='saludo1'>
							<input name='dipredial[]' value='".$interesesPredial."' type='text' size='7' readonly>
						</td>
						<td class='saludo1'>
							<input name='dimpuesto1[]' value='".$r3[6]."' type='text'  size='12' readonly>
						</td>
						<td class='saludo1'>
							<input name='dinteres1[]' value='".$interesesBomberil."' type='text' size='7' readonly>
						</td>
						<td class='saludo1'>
							<input name='dimpuesto2[]' value='".$r3[8]."' type='text'  size='12' readonly>
						</td>
						<td class='saludo1'>
							<input name='dinteres2[]' value='".$interesesAmbiental."' type='text' size='7' readonly>
						</td>";
						if($siAlumbrado>0)
						{
							echo "<td class='saludo1'>
								<input name='dvalorAlumbrado[]' value='".$val_alumbrado[$xx]."' type='text' size='10' readonly>
							</td>";
						}
						echo "
						<td class='saludo1'>
							<input type='text' name='ddescipredial[]' value='$descuentoPredial' size='6' readonly>
						</td>
						<td class='saludo1'>
							<input name='davaluos[]' value='".number_format($totalDeudaPotVigencia,2)."' type='text' size='10' readonly>
							<input name='dhavaluos[]' value='".$totalDeudaPotVigencia."' type='hidden' >
						</td>
						<td class='saludo1'>
							<input type='text' name='dias[]' value='$diasd' size='4' readonly>
						</td>
						<td class='saludo1'>
							<input type='hidden' name='dselvigencias[]' value='$r3[1]' onClick='buscavigencias(this)' >Ok</td>
						</tr>";
		 $_POST[totalc]=$_POST[totalc]+$totalDeudaPotVigencia;
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		$_POST[totliquida2]=$_POST[totalcf];
		$_POST[totliquida]=$_POST[totalc];	
		$_POST[totpredial]+=$r3[4];
		$_POST[totbomb]+=$r3[6];
		$_POST[totamb]+=$r3[8];
		$_POST[totint] = $_POST[totint] + $interesesPredial + $interesesBomberil + $interesesAmbiental;
		$_POST[totdesc]+=$descuentoPredial;
		 ?>
         <script>
	       
         </script>
         
		<?php
		$xx++;
		 //$ageliqui=$ageliqui." ".$_POST[dselvigencias][$x];
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";	
		?> 
      </table>
      	</div>
      		<table class="inicio">
      			<tr>
		  			<td class="saludo1">Total Liquidacion:</td>
		  			<td>
						<input type="text" name="totliquida2" value="<?php echo $_POST[totliquida2]?>" size="12"  readonly>
						<input type="hidden" name="totliquida" value="<?php echo $_POST[totliquida]?>" size="12" readonly>
					</td>
					<td class="saludo1">Total Predial:</td>
					<td>
						<input type="hidden" name="intpredial" value="<?php echo $_POST[intpredial]?>">
						<input type="text" name="totpredial" value="<?php echo $_POST[totpredial]?>" size="9" readonly>
					</td>
					<td class="saludo1">Total Sobret Bomberil:</td>
					<td>
						<input type="hidden" name="intbomb" value="<?php echo $_POST[intbomb]?>">
						<input type="text" name="totbomb" value="<?php echo $_POST[totbomb]?>" size="9" readonly>
					</td>
					<td class="saludo1">Total Sobret Ambiental:</td>
					<td>
						<input type="hidden" name="intamb" value="<?php echo $_POST[intamb]?>">
						<input type="text" name="totamb" value="<?php echo $_POST[totamb]?>" size="9" readonly>
					</td>
					<td class="saludo1">Total Intereses:</td>
					<td>
						<input type="text" name="totint" value="<?php echo $_POST[totint]?>" size="9" readonly>
					</td>
					<td class="saludo1">Total Descuentos:</td>
					<td>
						<input type="text" name="totdesc"  value="<?php echo $_POST[totdesc]?>" size="9" readonly>
					</td>
				</tr>
      <tr><td class="saludo1" >Son:</td><td colspan="8"><input type="text" name="letras"  value="<?php echo $_POST[letras]?>" size="155"><input name='idpredial' id="idpredial" value='<?php echo $_POST[idpredial]?>' type='hidden' ></td></tr>
      </table>
</form>

 </td></tr>
</table>
</body>
</html>