<?php //V 1001 22/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
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
$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID- Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				var concepto=document.form2.concepto.value;
				if(concepto==''){
					despliegamodalm('visible','2','Falta la Causa');
				}else{
					despliegamodalm('visible','4','Esta Seguro de Actualizar la Informacion','1');
				}
				
			}
			function funcionmensaje()
			{
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						// alert("case 1");
						document.form2.oculto.value='2';
						document.form2.submit();
					break;
				}
			}
			function validar(){
				document.form2.formapa.value="1";
				document.form2.submit();
				
			}
			function pdf()
			{
				document.form2.action="teso-pdfrecaja01.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 				{
					document.form2.oculto.value=1;
					if(document.getElementById('codrec').value!="")
					{document.getElementById('codrec').value=""}
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					location.href="teso-recibocajabancover.php?idrecibo="+document.form2.idcomp.value;
				}
			}
			function atrasc()
			{
				if(document.form2.ncomp.value>1)
 				{
					document.form2.oculto.value=1;
					if(document.getElementById('codrec').value!="")
					{document.getElementById('codrec').value=""}
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					location.href="teso-recibocajabancover.php?idrecibo="+document.form2.idcomp.value;
 				}
			}
			function validar2()
			{
				location.href="teso-recibocajabancover.php?idrecibo="+document.form2.idcomp.value;
			}
			function iratras()
			{
				var id=<?php echo $_GET[idrecibo] ?>;
				location.href="teso-buscarecibocajabanco.php?idcta="+id;
				
			}
			function crearexcel(){
				document.form2.action="teso-buscarecibocajaexcel1.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				//refrescar();
			}
			function despliegamodal2(_valor,v)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					if(v==1){
						document.getElementById('ventana2').src="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
					}else{
						var url="notaspararevelacioneditar.php?nota="+document.form2.notaf.value+"&modulo=teso&doc="+document.form2.idcomp.value+"&tdoc=5&valor="+document.form2.valorecaudo.value+"";
						// alert(url);
						document.getElementById('ventana2').src=url;
					}
					
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden") {document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			
			function cambiarmodo(){
				document.form2.rec.value="1";
				document.form2.submit();
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
		$scrtop=26*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a  onClick="location.href='teso-recibocaja.php'"  class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"/></a><a onClick="location.href='teso-buscarecibocajabanco.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir" style="width:29px;height:25px;"/></a>

  				<a class="mgbt" onClick="iratras()">
  				<img src="imagenes/iratras.png" title="Atr&aacute;s">
  				</a>
				<a onClick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" style="width:29px;height:25px;" title="csv"></a>
  				</td>
			</tr>		  
		</table>
		<?php
		function generaConcepto($idrecibo)
		{
			global $linkbd;
			$sql="SELECT descripcion FROM tesoreciboscaja WHERE id_recibos=$idrecibo";
			$result=mysql_query($sql,$linkbd);
			$row = mysql_fetch_array($result);
			return $row[0];
		}
		$vigencia=date(Y);
		$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$vigencia=$vigusu;
		
		$sqlr="select *from cuentacaja where estado='S' and vigencia=".$_SESSION["vigencia"];
		//	echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[1];}
		//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
		if(!$_POST[oculto])
		{
			$sqlr="select max(id_recibos) from  tesoreciboscaja ORDER BY id_recibos DESC";
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];
			$_POST[ncomp]=$_GET[idrecibo];
			$_POST[idcomp]=$_GET[idrecibo];
			$_POST[tabgroup1]=1;
		}
		if(!$_POST[oculto])
		{
			$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) 
			{
				$_POST[cobrorecibo]=$row[0];
				$_POST[vcobrorecibo]=$row[1];
				$_POST[tcobrorecibo]=$row[2];	 
			}
		}
		switch($_POST[tabgroup1])
		{
			case 1:	$check1='checked';break;
			case 2:	$check2='checked';break;
			case 3:	$check3='checked';
		}
				
		if($_POST[oculto]!="2"){
			$sql="SELECT * FROM tesoreciboscaja_banco WHERE id_recibos=$_POST[idcomp]";
			$result=mysql_query($sql,$linkbd);
			$row=mysql_fetch_row($result);
			$_POST[concepto]=$row[6];	
		}
			
		$sqlr="select * from tesoreciboscaja where id_recibos=$_POST[idcomp]";
		$res=mysql_query($sqlr,$linkbd); 
		while($r=mysql_fetch_row($res)) {$_POST[tiporec]=$r[10]; }
		switch($_POST[tiporec]) 
		{
	  		case 1:
				$sqlr="select * from tesoliquidapredial, tesoreciboscaja where tesoliquidapredial.idpredial=tesoreciboscaja.id_recaudo and tesoreciboscaja.estado !=''  and tesoreciboscaja.id_recibos=".$_POST[idcomp];
				$_POST[encontro]="";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
					$_POST[codcatastral]=$row[1];
					//$_POST[idcomp]=$row[19];	
					$_POST[idrecaudo]=$row[23];	
					$_POST[fecha]=$row[21];
					$_POST[vigencia]=$row[3];			
					$_POST[valorecaudo]=$row[8];		
					$_POST[totalc]=$row[8];	
					$_POST[tercero]=$row[4];
					if(empty($_POST[rec])){
						$_POST[modorec]=$row[24];
					}						
					if($_POST[formapa]=="" || !isset($_POST[formapa])){
						$_POST[banco]=$row[25];
					}
					if($row[28]=='S') {$_POST[estadoc]='ACTIVO';} 	 				  
					if($row[28]=='N'){$_POST[estadoc]='ANULADO';} 	
					$sqlr1="select nombrepropietario from tesopredios where cedulacatastral='$_POST[codcatastral]' and estado='S'";
					$resul=mysql_query($sqlr1,$linkbd);
					$row1 =mysql_fetch_row($resul);
					$_POST[ntercero]=$row1[0];
					if ($_POST[ntercero]=='')
					{
						$sqlr2="select *from tesopredios where cedulacatastral='".$row[1]."' ";
						$resc=mysql_query($sqlr2,$linkbd);
						$rowc =mysql_fetch_row($resc);
						$_POST[ntercero]=$rowc[6];
					}			
					$_POST[encontro]=1;
				}
				$sqlr="select *from tesoreciboscaja where tipo='1' and id_recaudo=$_POST[idrecaudo] ";
				$res=mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($res); 
				//$_POST[idcomp]=$row[0];
				$_POST[fecha]=$row[2];
				$_POST[estadoc]=$row[9];
				if ($_POST[estadoc]=='N') {$_POST[estado]="ANULADO";}
				else {$_POST[estado]="ACTIVO";}
				if(empty($_POST[rec])){
						$_POST[modorec]=$row[5];
					}
				if($_POST[formapa]=="" || !isset($_POST[formapa])){
						$_POST[banco]=$row[7];
					}
				ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
				$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
			break;
	  		case 2:
				$sqlr="select *from tesoindustria,tesoreciboscaja where tesoreciboscaja.id_recibos=$_POST[idcomp] and tesoreciboscaja.id_recaudo=tesoindustria.id_industria";
				//echo "$sqlr";
				$_POST[encontro]="";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
					//$_POST[idcomp]=$row[8];				
					$_POST[fecha]=$row[12];
					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
					$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
					$_POST[idrecaudo]=$row[0];	
					$_POST[vigencia]=$row[2];
					$_POST[tiporec]=$row[20];		
					$_POST[valorecaudo]=$row[18];		
					$_POST[totalc]=$row[18];	
					$_POST[tercero]=$row[5];	
					$_POST[ntercero]=buscatercero($row[5]);	
					if(empty($_POST[rec])){
						$_POST[modorec]=$row[15];
					}
					if($_POST[formapa]=="" || !isset($_POST[formapa])){
						$_POST[banco]=$row[16];
					}
					$_POST[encontro]=1;
					$_POST[estadoc]=$row[19];
					if ($_POST[estadoc]=='N'){$_POST[estado]="ANULADO";}
					else {$_POST[estado]="ACTIVO";}
				}
	  		break;
	  		case 3:
				$sqlr="select *from tesoreciboscaja,tesorecaudos where tesorecaudos.id_recaudo=tesoreciboscaja.id_recaudo and tesoreciboscaja.id_recibos=".$_POST[idcomp];
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
					//$_POST[idcomp]=$row[0];	
					$_POST[idrecaudo]=$row[11];	
					$_POST[fecha]=$row[2];
					$_POST[vigencia]=$row[3];		
					$_POST[tiporec]=$row[10];
					if(empty($_POST[rec])){
						$_POST[modorec]=$row[5];
					}						
					
					if($_POST[formapa]=="" || !isset($_POST[formapa])){
						$_POST[banco]=$row[7];
					}						
					$_POST[cb]=$row[6];
					$_POST[estadoc]=$row[9];
					if ($_POST[estadoc]=='N'){$_POST[estado]="ANULADO";}
					else {$_POST[estado]="ACTIVO";} 		
					$_POST[valorecaudo]=$row[8];				
					$_POST[tercero]=$row[15];				
					$_POST[ntercero]=buscatercero($_POST[tercero]);						
				}
			break;	
		}
		?>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action=""> 
  			<input type="hidden" name="cobrorecibo" value="<?php echo $_POST[cobrorecibo]?>" >
            <input type="hidden" name="vcobrorecibo" value="<?php echo $_POST[vcobrorecibo]?>" >
            <input type="hidden" name="tcobrorecibo" value="<?php echo $_POST[tcobrorecibo]?>" > 
            <input type="hidden" name="encontro" value="<?php echo $_POST[encontro]?>" >
            <input type="hidden" name="codcatastral" value="<?php echo $_POST[codcatastral]?>" >
            <input type="hidden" name="codrec" id="codrec" value="<?php echo $_POST[codrec];?>" />
			<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$vigencia=$vigusu;
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[0];}
				if(!$_POST[oculto])
				{
					$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
	 					$_POST[cobrorecibo]=$row[0];
	 					$_POST[vcobrorecibo]=$row[1];
	 					$_POST[tcobrorecibo]=$row[2];	 
					}
				}
	  			//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
				if ($_GET[idrecibo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idrecibo];</script>";}
				//if ($_POST[codrec]!="")
				//{$sqlr="select id_recibos,id_recaudo from tesoreciboscaja where id_recibos='$_POST[codrec]'";}
				//else
				{$sqlr="select id_recibos,id_recaudo from tesoreciboscaja ORDER BY id_recibos DESC";}
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
				if(!$_POST[oculto])
				{
					$fec=date("d/m/Y");
					$_POST[vigencia]=$vigencia;
					if ($_POST[codrec]!="" || $_GET[idrecibo]!="")
						if($_POST[codrec]!="")
						{$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja where id_recibos='$_POST[codrec]'";}
						else 
						{$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja where id_recibos='$_GET[idrecibo]'";}
					else
					{$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja ORDER BY id_recibos DESC";}
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
	 				//$_POST[maximo]=$r[0];
				 	$_POST[ncomp]=$r[0];
	 				$_POST[idcomp]=$r[0];
	 				$_POST[idrecaudo]=$r[1];
	 				$_POST[oculto]=0;
				}
				if ($_POST[codrec]!="")
				{$sqlr="select * from tesoreciboscaja where id_recibos='$_POST[codrec]'";}
				else
 				{$sqlr="select * from tesoreciboscaja where id_recibos='$_POST[idcomp]'";}
 				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res))
		 		{		  
		  			$_POST[tiporec]=$r[10];
		  			$_POST[idrecaudo]=$r[4];
		  			$_POST[ncomp]=$r[0];
		  			if(empty($_POST[rec])){
							$_POST[modorec]=$row[5];
						}
		  			$_POST[vigencia]=$r[3]; 
		 		}
			?>
			<input type="hidden" name="cobrorecibo" value="<?php echo $_POST[cobrorecibo]?>" >
			<input type="hidden" name="vcobrorecibo" value="<?php echo $_POST[vcobrorecibo]?>" >
 			<input type="hidden" name="tcobrorecibo" value="<?php echo $_POST[tcobrorecibo]?>" > 
 			<input type="hidden" name="encontro"  value="<?php echo $_POST[encontro]?>" >
  			<input type="hidden" name="codcatastral"  value="<?php echo $_POST[codcatastral]?>" >
 			<?php 
				switch($_POST[tiporec]) 
  	 			{
	  				case 1:	$sqlr="SELECT * FROM tesoliquidapredial WHERE idpredial=$_POST[idrecaudo] AND  1=$_POST[tiporec]";
  	  						$_POST[encontro]="";
	  						$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
	 						{
								$_POST[codcatastral]=$row[1];		
	  							$_POST[valorecaudo]=$row[8];		
	  							$_POST[totalc]=$row[8];	
	  							$_POST[tercero]=$row[4];	
	  							$_POST[ntercero]=buscatercero($row[4]);		
								if ($_POST[ntercero]=='')
		 						{
		  							$sqlr2="SELECT * FROM tesopredios WHERE cedulacatastral='".$row[1]."' ";
		  							$resc=mysql_query($sqlr2,$linkbd);
		  							$rowc =mysql_fetch_row($resc);
		   							$_POST[ntercero]=$rowc[6];
		 						}	
	  							$_POST[encontro]=1;
							}
							$sqlr="SELECT * FROM tesoreciboscaja WHERE id_recibos=$_POST[idcomp] ";
							$res=mysql_query($sqlr,$linkbd);
							$row =mysql_fetch_row($res); 
							$_POST[fecha]=$row[2];
							$_POST[estadoc]=$row[9];
		   					if ($row[9]=='N')
		   					{
								$_POST[estado]="ANULADO";
		   						$_POST[estadoc]='0';
		   					}
		   					else
						  	{
							   $_POST[estadoc]='1';
							   $_POST[estado]="ACTIVO";
						   	}
							if(empty($_POST[rec])){
								$_POST[modorec]=$row[5];
							}
							if($_POST[formapa]=="" || !isset($_POST[formapa])){
							$_POST[banco]=$row[7];
							}
       	 					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   						$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	  						break;
	  
	  				case 2:	$sqlr="SELECT * FROM tesoindustria WHERE id_industria=$_POST[idrecaudo] AND 2=$_POST[tiporec]";
  	  						$_POST[encontro]="";
	  						$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
	 						{	
	  							$_POST[valorecaudo]=$row[6];		
	  							$_POST[totalc]=$row[6];	
	  							$_POST[tercero]=$row[5];	
	  							$_POST[ntercero]=buscatercero($row[5]);	
	  							$_POST[encontro]=1;
	 						}
							$sqlr="select *from tesoreciboscaja where  id_recibos=$_POST[idcomp] ";
							$res=mysql_query($sqlr,$linkbd);
							$row =mysql_fetch_row($res); 
							$_POST[fecha]=$row[2];
							$_POST[estadoc]=$row[9];
		   					if ($row[9]=='N')
		   					{
								$_POST[estado]="ANULADO";
		   						$_POST[estadoc]='0';
		   					}
		   					else
							{
							   $_POST[estadoc]='1';
							   $_POST[estado]="ACTIVO";
							}
        					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   						$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	   						if(empty($_POST[rec])){
								$_POST[modorec]=$row[5];
							}
							if($_POST[formapa]=="" || !isset($_POST[formapa])){
							$_POST[banco]=$row[7];
						}
			
	  						break;
	  				case 3:	$sqlr="SELECT * FROM tesorecaudos where tesorecaudos.id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
  	  						$_POST[encontro]="";
	  						$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
	 						{
	  							$_POST[valorecaudo]=$row[5];		
	  							$_POST[totalc]=$row[5];	
	  							$_POST[tercero]=$row[4];	
	  							$_POST[ntercero]=buscatercero($row[4]);			
	  							$_POST[encontro]=1;
	 						}
							$sqlr="select *from tesoreciboscaja where  id_recibos=$_POST[idcomp] ";
							$res=mysql_query($sqlr,$linkbd);
							$row =mysql_fetch_row($res); 
							$_POST[fecha]=$row[2];
							$_POST[estadoc]=$row[9];
		   					if ($row[9]=='N')
		   					{
								$_POST[estado]="ANULADO";
		  						$_POST[estadoc]='0';
		   					}
		  					else
		   					{
			   					$_POST[estadoc]='1';
			   					$_POST[estado]="ACTIVO";
		   					}
							if(empty($_POST[rec])){
								$_POST[modorec]=$row[5];
							}
							if($_POST[formapa]=="" || !isset($_POST[formapa])){
							$_POST[banco]=$row[7];
						}
        					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   						$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
							break;	
				}
 			?>
    		<div class="tabsic" style="height:36%; width:99.6%;">
			<div class="tab">
			<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	  		<label for="tab-1">Recibo Caja</label>
			<div class="content" style="overflow-x:hidden;">
			<table class="inicio" style="width:99.7%;">
                <tr>
                    <td class="titulos" colspan="7">Recibo de Caja</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
        			<td class="saludo1" style="width:2cm;">No Recibo:</td>
        			<td style="width:20%;"> 
                    	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" title="anterior" align="absmiddle"/></a> 
                        <input type="hidden" name="cuentacaja" value="<?php echo $_POST[cuentacaja]?>" />
                        <input type="text" name="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  style="width:50%;" />
                        <input type="hidden" name="ncomp"  value="<?php echo $_POST[ncomp]?>"/>
                        <a href="#" onClick="adelante()"><img src="imagenes/next.png" title="siguiente" align="absmiddle"/></a> 
                        <input type="hidden" value="a" name="atras"/>
                        <input type="hidden" value="s" name="siguiente"/>
                        <input type="hidden" name="maximo" value="<?php echo $_POST[maximo]?>" />
               		</td>
	 		
					<td class="saludo1" style="width:2.3cm;">Fecha: </td>
        			<td style="width:18%"><input type="text" id="fc_1198971545" name="fecha" value="<?php echo $_POST[fecha]?>" title="DD/MM/YYYY" maxlength="10" onKeyDown="mascara(this,'/',patron,true)" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:35%">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;" ></a>
					<?php 
							if($_POST[estado]=='ACTIVO'){
								echo "<input name='estado' type='text' value='ACTIVO' size='5' style='width:52%; background-color:#0CD02A; color:white; text-align:center;' readonly >";
							}
							else
							{
								echo "<input name='estado' type='text' value='ANULADO' size='5' style='width:40%; background-color:#FF0000; color:white; text-align:center;' readonly >";
							}
						?>
					</td> 
								
         			<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
		  			<td style="width:12%;">
                    	<input type="text" id="vigencia" name="vigencia" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" readonly>
                   	</td>
                  	<td rowspan="6" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>     
        		</tr>
     			<tr>
                	<td class="saludo1"> Recaudo:</td>
                    <td> 
                    	<select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)"  style="width:100%;">
                        	<?php
								switch($_POST[tiporec])
								{
									case "1":	echo"<option value='1' SELECTED>Predial</option>";break;
									case "2":	echo"<option value='2' SELECTED>Industria y Comercio</option>";break;
									case "3":	echo"<option value='3' SELECTED>Otros Recaudos</option>";break;
								}
							?>
        				</select>
          			</td>
        			<td class="saludo1">No Liquid:</td>
                    <td><input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:100%;" readonly></td>
					<td class="saludo1">Recaudado en:</td>
     				<td> 
                    	<select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" style="width:100%;" onChange="cambiarmodo()" >
                        	<?php
							
								if($_POST[modorec]=='banco'){
									echo "<option value='banco' SELECTED>Banco</option>";
									echo "<option value='caja' >Caja</option>";
								}
								else{
									echo "<option value='banco'>Banco</option>";
									echo "<option value='caja' SELECTED>Caja</option>";
								}
								
								
							?>
        				</select>
						<input type="hidden" name="rec" id="rec" value="<?php echo $_POST[rec]; ?>" />
          			</td>
       			</tr>
                <?php
					if ($_POST[modorec]=='banco')
					{
						echo"
						<tr>
							<td class='saludo1'>Cuenta:</td>
							<td>
								<select id='banco' name='banco' onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%'>
									<option value=''>Seleccione....</option>";
						$sqlr="select TB1.estado,TB1.cuenta,TB1.ncuentaban,TB1.tipo,TB2.razonsocial,TB1.tercero from tesobancosctas TB1,terceros TB2 where TB1.tercero=TB2.cedulanit and TB1.estado='S' ";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							if("$row[1]"==$_POST[banco])
							{
								echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
								$_POST[nbanco]=$row[4];
								$_POST[ter]=$row[5];
								$_POST[cb]=$row[2];
							}
							else{echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";}
						}	 	
						echo"
								</select>
							</td>
							<input type='hidden' name='cb' value='$_POST[cb]'/>
							<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/></td>
							<td class='saludo1'>Banco:</td>
							<td colspan='3'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%;' readonly></td>
						</tr>";
					}
					
					$sqlr="select nota from teso_notasrevelaciones where modulo='teso' and tipo_documento='5' and numero_documento='$_POST[idcomp]'";
					// echo $sqlr;
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[notaf]=$row[0];
				?> 
				<input name="formapa" id="formapa" type="hidden" value="<?php echo $_POST[formapa]; ?>" /> 	
	  			<tr>
                	<td class="saludo1">Concepto:</td>
                    <td colspan="<?php if($_POST[tiporec]==2){echo '3';}else{echo'5';}?>">
						<input name="concepto" type="text" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)" style="width:100%;background-color:#FFF" <?php if(!empty($_POST[concepto]) ){echo "readonly"; } ?> >
						<input type="hidden" name="notaf" id="notaf" value="<?php echo $_POST[notaf]?>" >
					
					</td>
              	</tr>
                <tr>
                	<td  class="saludo1">Documento: </td>
        			<td ><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
			  		<td class="saludo1">Contribuyente:</td>
	  				<td colspan="3">
                    	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>"  onKeyUp="return tabular(event,this) " style="width:100%;" readonly>
                        <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
                        <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  				</td>
                </tr>
      			<tr>
                	<td class="saludo1" >Valor:</td>
                    <td><input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly /></td>
                     
            	</tr>
                <?php if ($_POST[modorec]!='banco'){echo"<tr style='height:20;'><tr>";}?>
			</table>
			</div>
			</div>	
      		</div>
      		<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
	    	<input type="hidden" value="0" name="agregadet">
     		<div class="subpantalla" s style="height:49.3%; width:99.6%; overflow-x:hidden;">
      			<?php	 
      			//echo $_POST[oculto]."dddhdhdhd".$_POST[encontro];
      			
 					if($_POST[oculto]>=0 && $_POST[encontro]=='1')
 					{
 					
  						switch($_POST[tiporec]) 
  	 					{
	  						case 1: //********PREDIAL
	   								$sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
	   								//echo "s:".$sqlr;
									unset($_POST[dcoding]); 		 
									unset($_POST[dncoding]); 		 
									unset($_POST[dvalores]); 	
									$_POST[dcoding]= array(); 		 
									$_POST[dncoding]= array(); 		 
									$_POST[dvalores]= array(); 	
		 							if($_POST[tcobrorecibo]=='S')
		 							{	 
		 								$_POST[dcoding][]=$_POST[cobrorecibo];
		 								$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
    	 								$_POST[dvalores][]=$_POST[vcobrorecibo];
		 							}
		 							$_POST[trec]='PREDIAL';	 
 	 								$res=mysql_query($sqlr,$linkbd);
									//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
									while ($row =mysql_fetch_row($res)) 
									{
										$vig=$row[1];
										if($vig==$vigusu)
		 								{
											$sqlr2="select * from tesoingresos where codigo='01'";
											$res2=mysql_query($sqlr2,$linkbd);
											$row2 =mysql_fetch_row($res2); 
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    										$_POST[dvalores][]=$row[11];		 
	 									}
		 								else
	   	 								{	
											$sqlr2="select * from tesoingresos where codigo='03'";
											$res2=mysql_query($sqlr2,$linkbd);
											$row2 =mysql_fetch_row($res2); 
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;			 		
	    									$_POST[dvalores][]=$row[11];		
		 								}
									}  
	  								break;
	  						case 2:	//***********INDUSTRIA Y COMERCIO
									unset($_POST[dcoding]); 		 
									unset($_POST[dncoding]); 		 
									unset($_POST[dvalores]); 	
 									$_POST[dcoding]= array(); 		 
		 							$_POST[dncoding]= array(); 		 
		 							$_POST[dvalores]= array(); 	
	  			 					$_POST[trec]='INDUSTRIA Y COMERCIO';	 
									if($_POST[tcobrorecibo]=='S')
		 							{	 
		 								$_POST[dcoding][]=$_POST[cobrorecibo];
		 								$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
    	 								$_POST[dvalores][]=$_POST[vcobrorecibo];
		 							}
									$sqlr="select *from tesoindustria where id_industria=$_POST[idrecaudo] and  2=$_POST[tiporec]";
	  								$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
	 								{
										$sqlr2="select * from tesoingresos where codigo='02'";
	  									$res2=mysql_query($sqlr2,$linkbd);
										$row2 =mysql_fetch_row($res2);
 										$_POST[dcoding][]=$row2[0];
										$_POST[dncoding][]=$row2[1];			 		
	    								$_POST[dvalores][]=$row[6];		
									}
	  								break;
	  						case 3:	//*****************otros recaudos *******************
	  			 					$_POST[trec]='OTROS RECAUDOS';	 
	  			 					unset($_POST[dcoding]); 		 
									unset($_POST[dncoding]); 		 
									unset($_POST[dvalores]); 	
  									$sqlr="select *from tesorecaudos_det where id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
		 							$_POST[dcoding]= array(); 		 
		 							$_POST[dncoding]= array(); 		 
		 							$_POST[dvalores]= array(); 	
									if($_POST[tcobrorecibo]=='S')
		 							{	 
		 								$_POST[dcoding][]=$_POST[cobrorecibo];
		 								$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
    	 								$_POST[dvalores][]=$_POST[vcobrorecibo];
		 							}	 
  									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{	
										$_POST[dcoding][]=$row[2];
										$sqlr2="select nombre from tesoingresos where codigo='".$row[2]."'";
										$res2=mysql_query($sqlr2,$linkbd);
										$row2 =mysql_fetch_row($res2); 
										$_POST[dncoding][]=$row2[0];			 		
    									$_POST[dvalores][]=$row[3];		 	
									}
									break;
   						}
 					}
 				?>
	<?php
	$descrip="";
	if($_POST[oculto]=='2')
	{
		$linkbd=conectar_bd();
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="select * from tesoreciboscaja_banco where id_recibos=$_POST[ncomp]";
		$res=mysql_query($sqlr,$linkbd);
		$numerofilas=mysql_num_rows($res);
		if($numerofilas>0)
		{
			echo "<script>despliegamodalm('visible','1','Ya existe un comprobante de cambio para este recibo');</script>";
		}
		else
		{
			$sqlr="select id_recibos,id_comp,cuentabanco,recaudado,vigencia,id_recaudo,valor,descripcion from tesoreciboscaja where id_recibos=$_POST[ncomp]";
			$result=mysql_query($sqlr,$linkbd);
			while($row = mysql_fetch_row($result))
			{
				$bancoant=$row[2];
				$recaudoant=$row[3];
				$idcomp=$row[1];
				$idrecibo=$row[0];
				$vigencia=$row[4];
				$idrecaudo=$row[5];
				$valor=$row[6];
				$concepto=$row[7];
				$descrip=$row[7];
			}
			$sqlr="INSERT INTO tesoreciboscaja_banco(id_recibos,fecha_mod,usuario,cuentabanco_ant,cuentabanco_nu,concepto,recaudo_ant,recaudo_nu) VALUES ('$_POST[ncomp]','$fechaf','$_SESSION[nickusu]','$bancoant','$_POST[banco]','$_POST[concepto]','$recaudoant','$_POST[modorec]')";
			if(mysql_query($sqlr,$linkbd))
			{
				$elimina="delete from tesoreciboscaja WHERE id_recibos=$_POST[ncomp]";
				mysql_query($elimina,$linkbd);
				if($_POST[modorec]=='caja')
				{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
				}
				if($_POST[modorec]=='banco')
				{
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
				}
					
				$sqlr="insert into tesoreciboscaja (id_recibos,id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo, descripcion) values($idrecibo,$idcomp,'$fechaf',".$vigencia.",$idrecaudo,'$_POST[modorec]','$cajas','$cbancos','$valor','S','$_POST[tiporec]', '$concepto')";
				mysql_query($sqlr,$linkbd);
				//echo "<script>despliegamodalm('visible','1','Se ha actualizado el Recibo con Exito');</script>";
			}
			else
			{
				//echo "<script>despliegamodalm('visible','1','Error al actualizar el Recibo de Caja');</script>";
			}
		}
	}
	if($_POST[oculto]=='2')
	{
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
		if($bloq>=1)
		{						
			//************VALIDAR SI YA FUE GUARDADO ************************
			switch($_POST[tiporec]) 
  		 	{
	  			case 1://***** PREDIAL *****************************************
	  				$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='1' ";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{
						$numerorecaudos=$r[0];
					}
					if($numerorecaudos>=0)
					{	
						$sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='5'";
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from comprobante_det where numerotipo=$_POST[idcomp] and tipo_comp='5'";
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
						mysql_query($sqlr,$linkbd);
						if($_POST[modorec]=='caja')
						{				 
							$cuentacb=$_POST[cuentacaja];
							$cajas=$_POST[cuentacaja];
							$cbancos="";
						}
						if($_POST[modorec]=='banco')
						{
							$cuentacb=$_POST[banco];				
							$cajas="";
							$cbancos=$_POST[banco];
						}	   
		     	 		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			  			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						//************ insercion de cabecera recaudos ************
						$concecc=$_POST[idcomp];
						echo "<input type='hidden' name='concec' value='$concecc'>";	
						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>";
						$sqlr="update tesoliquidapredial set estado='P' WHERE idpredial=$_POST[idrecaudo]";
						mysql_query($sqlr,$linkbd);
						$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
						$resq=mysql_query($sqlr,$linkbd);
						while($rq=mysql_fetch_row($resq))
						{
							$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE   idpredial=$_POST[idrecaudo]) AND vigencia=$rq[1]";
							mysql_query($sqlr2,$linkbd);
		  				}
		  				?>
						<script>
							document.form2.numero.value="";
							document.form2.valor.value=0;
						</script>
						<?php		  			 
						//**********************CREANDO COMPROBANTE CONTABLE ********************************	 
						$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','".$descrip."',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estadoc]')";	 
		 				mysql_query($sqlr,$linkbd);
		 
		 		 		//******parte para el recaudo del cobro por recibo de caja
		 
						for($x=0;$x<count($_POST[dcoding]);$x++)
						{
							if($_POST[dcoding][$x]==$_POST[cobrorecibo])
							{
								//***** BUSQUEDA INGRESO ********
								$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
								$resi=mysql_query($sqlri,$linkbd);
								while($rowi=mysql_fetch_row($resi))
								{
	    							//**** busqueda cuenta presupuestal*****
									//busqueda concepto contable
									 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
									$resc=mysql_query($sqlrc,$linkbd);	  
									while($rowc=mysql_fetch_row($resc))
									{
			  							$porce=$rowi[5];
										if($rowc[7]=='S')
										{
											$valorcred=$_POST[dvalores][$x]*($porce/100);
											$valordeb=0;
											if($rowc[3]=='N')
											{
												//*****inserta del concepto contable  
												//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
												$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia='$vigusu'";
												$respto=mysql_query($sqlrpto,$linkbd);	  
												$rowpto=mysql_fetch_row($respto);
			
												$vi=$_POST[dvalores][$x]*($porce/100);
												$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia='$vigusu'";
												mysql_query($sqlr,$linkbd);	
			
												//****creacion documento presupuesto ingresos
												$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
												mysql_query($sqlr,$linkbd);	
												//************ FIN MODIFICACION PPTAL
			
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
												mysql_query($sqlr,$linkbd);
												//***cuenta caja o banco
												if($_POST[modorec]=='caja')
												{				 
													$cuentacb=$_POST[cuentacaja];
													$cajas=$_POST[cuentacaja];
													$cbancos="";
			  									}
												if($_POST[modorec]=='banco')
												{
													$cuentacb=$_POST[banco];				
													$cajas="";
													$cbancos=$_POST[banco];
												}
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
												mysql_query($sqlr,$linkbd);
											}
			  							}
		 							}
		 						}
	  						}
						}			 	 
	 					//*************** fin de cobro de recibo
						$sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
						$res=mysql_query($sqlrs,$linkbd);	
						$rowd==mysql_fetch_row($res);
						$tasadesc=($rowd[6]/100);
						$sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
						$res=mysql_query($sqlrs,$linkbd);		 
						//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
						while ($row =mysql_fetch_row($res)) 
						{
							$vig=$row[1];
							$vlrdesc=$row[10];
							if($vig==$vigusu) //*************VIGENCIA ACTUAL *****************
							{
								$idcomp=mysql_insert_id();
								$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
								mysql_query($sqlr,$linkbd);
								$sqlr2="select * from tesoingresos_DET where codigo='01' AND MODULO='4' and vigencia=$vigusu";
								$res2=mysql_query($sqlr2,$linkbd);
								//****** $cuentacb   ES LA CUENTA CAJA O BANCO
								while($rowi =mysql_fetch_row($res2))
								{
									switch($rowi[2])
									{
										case '01': //***  VALOR PREDIAL
											//**** busca descuento PREDIAL
											$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P01' AND MODULO='4' and vigencia=$vigusu";
											$resds=mysql_query($sqlrds,$linkbd);
											while($rowds =mysql_fetch_row($resds))
											{
					 							$descpredial=round($vlrdesc*round($rowds[5]/100,2),2);
											}
											//****			
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[4];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Vigente $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=round($valorcred-$descpredial,2);
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Vigente $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
					     									//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL		
					  									}
													}
				  								}
				 							}
										break;  
										case '02': //***
			 								$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[8];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
					  									{
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							
					  										//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															//echo "con: $sqlrpto <br>";	      
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL			
					  									}
													}
				  								}
				 							}
			
										break;  
										case '03': 			
											$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P10' AND MODULO='4' and vigencia=$vigusu";
											$resds=mysql_query($sqlrds,$linkbd);
											while($rowds =mysql_fetch_row($resds))
											{
												$descpredial=round($vlrdesc*round($rowds[5]/100,2),2);
											}

											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[6];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
				 	 									if($valorcred>0)
					  									{
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred-$descpredial;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							
					  										//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL			
					  									}
													}
				  								}
				 							}
										break;  
										case 'P10': 
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valordeb=round($row[10]*($porce/100),2);
													$valorcred=0;		
													if($rowc[3]=='N')
													{
														if($valordeb>0)
														{						
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							 								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
															
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
					  									}
													}
				  								}
				 							}
										break;  
										case 'P01': 
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valordeb=round($row[10]*$porce/100,2);
													$valorcred=0;					
													if($rowc[3]=='N')
													{
														if($valordeb>0)
														{						
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							  								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 												$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 												$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
					  									}
													}
				 								}
				 							}
										break;  
										case 'P02': 
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 							$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[5];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							  								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
					  									}
													}
				  								}
				 							}
										break;  
										case 'P04': 
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[7];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{					
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							
							  								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
					  									}
													}
				  								}
				 							}
										break;  
										case 'P05': 
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{
													$valorcred=$row[6];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{						
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							
							  								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
					  									}
													}
				  								}
				 							}
										break;  
										case 'P07':
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[9];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							
							  								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
					  									}
													}
												}
				 							}
										break;  
										case 'P08': 
			
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{
													$valorcred=0;
													$valordeb=$row[8];					
												}
												if($rowc[6]=='N')
												{				 
													$valorcred=$row[8];
													$valordeb=0;					
				  								}
												if($rowc[3]=='N')
												{
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);					
							
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
													$respto=mysql_query($sqlrpto,$linkbd);	  
													$rowpto=mysql_fetch_row($respto);
			
													$vi=$valorcred;
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
													mysql_query($sqlr,$linkbd);	
			
													//****creacion documento presupuesto ingresos
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
													mysql_query($sqlr,$linkbd);	
													//************ FIN MODIFICACION PPTAL	
				   								}
				 							}
										break; 
									} 
		 						}
								$_POST[dcoding][]=$row2[0];
								$_POST[dncoding][]=$row2[1]." ".$vig;			 		
								$_POST[dvalores][]=$row[11];		 
	 						}
							else  ///***********OTRAS VIGENCIAS ***********
							{	
								$tasadesc=$row[10]/($row[4]+$row[6]);
								$idcomp=mysql_insert_id();
								$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
								mysql_query($sqlr,$linkbd);
								$sqlr2="select * from tesoingresos_DET where codigo='03' AND MODULO='4' and vigencia=$vigusu";
								$res2=mysql_query($sqlr2,$linkbd);
				 				//****** $cuentacb   ES LA CUENTA CAJA O BANCO
								while($rowi =mysql_fetch_row($res2))
								{
									switch($rowi[2])
									{
										case 'P03': //***
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[4];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{						
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred-$tasadesc*$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
						  									//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL		
					  									}
													}
				  								}
				 							}
										break;  
										case 'P06': //***
			 								$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[8];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{						
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							
							  								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
					  									}
													}
				  								}
				 							}
										break;  
										case '03': 
			
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[6];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred-$tasadesc*$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							  								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
					  									}
													}
				  								}
				 							}
										break;  
										case 'P01': 
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valordeb=$row[10];
													$valorcred=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
					  									}
													}
				  								}
				 							}
										break;  
										case 'P02': 
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{
													$valorcred=$row[5];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							
							  								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
														}
				   									}
				  								}
				 							}
										break;  
										case 'P04': 
			
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[7];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{						
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							
							  								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
					  									}
													}
				  								}
				 							}
										break;  
										case 'P05': 
			
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[6];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							
							  								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
															//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
					  									}
													}
				  								}
				 							}
										break;  
										case 'P07': 
			
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=$row[9];
													$valordeb=0;					
													if($rowc[3]=='N')
													{
														if($valorcred>0)
														{						
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
															$valordeb=$valorcred;
															$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
															mysql_query($sqlr,$linkbd);
							
							 								//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	  
															$rowpto=mysql_fetch_row($respto);
			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
			
			  												//****creacion documento presupuesto ingresos
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
															mysql_query($sqlr,$linkbd);	
															//************ FIN MODIFICACION PPTAL	
					  									}
													}
				  								}
				 							}
										break;  
										case 'P08': 
			
											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
											$resc=mysql_query($sqlrc,$linkbd);	  
											while($rowc=mysql_fetch_row($resc))
											{
												$porce=$rowi[5];
												if($rowc[6]=='S')
												{				 
													$valorcred=0;
													$valordeb=$row[8];					
				  								}
												if($rowc[6]=='N')
												{				 
													$valorcred=$row[8];
													$valordeb=0;					
												}
												if($rowc[3]=='N')
												{
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);					
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
													$respto=mysql_query($sqlrpto,$linkbd);	  
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
													mysql_query($sqlr,$linkbd);	
													//****creacion documento presupuesto ingresos
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
													mysql_query($sqlr,$linkbd);	
													//echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL		
				  								}
				 							}
										break;  
									} 
		 						}
								$_POST[dcoding][]=$row2[0];
								$_POST[dncoding][]=$row2[1]." ".$vig;			 		
								$_POST[dvalores][]=$row[11];		 	
								//echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
		 					}
						}
						//*******************  
	 					$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
						$resp=mysql_query($sqlr,$linkbd);
						while($row=mysql_fetch_row($resp,$linkbd))
						{
		    				$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[1]";
							mysql_query($sqlr2,$linkbd);
		   				}	 	  
   	 				}//fin de la verificacion
					else
					{
	  					echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion Predial<img src='imagenes/alert.png'></center></td></tr></table>";
	 				}//***FIN DE LA VERIFICACION
				break;
				case 2:  //********** INDUSTRIA Y COMERCIO
	  				echo "INDUSTRIA";
		      		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			  		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='2'";
					$res=mysql_query($sqlr,$linkbd);
					//echo $sqlr;
					while($r=mysql_fetch_row($res))
					{
						$numerorecaudos=$r[0];
	 				}
					if($numerorecaudos>=0)
					{   	 
						$sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='5'";
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from comprobante_det where id_comp='5 $_POST[idcomp]'";
						//echo $sqlr;
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
						//echo $sqlr;		
						mysql_query($sqlr,$linkbd);
         
						if (!mysql_query($sqlr,$linkbd))
						{
							echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
							echo "Ocurrió el siguiente problema:<br>";
							echo "<pre>";
							echo "</pre></center></td></tr></table>";
						}
						else
						{
							echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>"; 
							$concecc=$_POST[idcomp]; 
							//*************COMPROBANTE CONTABLE INDUSTRIA
							$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','".$descrip."',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estadoc]')";		  
							mysql_query($sqlr,$linkbd);
							$idcomp=mysql_insert_id();
							$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='2'";
							mysql_query($sqlr,$linkbd);
							$sqlr="update tesoindustria set estado='P' WHERE id_industria=$_POST[idrecaudo]";
							mysql_query($sqlr,$linkbd);
							if($_POST[modorec]=='caja')
							{				 
								$cuentacb=$_POST[cuentacaja];
								$cajas=$_POST[cuentacaja];
								$cbancos="";
							}
							if($_POST[modorec]=='banco')
							{
								$cuentacb=$_POST[banco];				
								$cajas="";
								$cbancos=$_POST[banco];
							}

		 					//******parte para el recaudo del cobro por recibo de caja
		 
							for($x=0;$x<count($_POST[dcoding]);$x++)
							{
		 						if($_POST[dcoding][$x]==$_POST[cobrorecibo])
								{
									//***** BUSQUEDA INGRESO ********
									$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
									$resi=mysql_query($sqlri,$linkbd);
									while($rowi=mysql_fetch_row($resi))
									{
	    								//**** busqueda cuenta presupuestal*****
										//busqueda concepto contable
										$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
										$resc=mysql_query($sqlrc,$linkbd);	  
										while($rowc=mysql_fetch_row($resc))
		 								{
			  								$porce=$rowi[5];
											if($rowc[7]=='S')
											{				 
												$valorcred=$_POST[dvalores][$x]*($porce/100);
												$valordeb=0;
												if($rowc[3]=='N')
												{
													//*****inserta del concepto contable  
													//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia='$vigusu'";
													$respto=mysql_query($sqlrpto,$linkbd);	  
													$rowpto=mysql_fetch_row($respto);
													$vi=$_POST[dvalores][$x]*($porce/100);
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia='$vigusu'";
													mysql_query($sqlr,$linkbd);	
			
													//****creacion documento presupuesto ingresos
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
													mysql_query($sqlr,$linkbd);	
													//************ FIN MODIFICACION PPTAL
			
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
														//***cuenta caja o banco
													if($_POST[modorec]=='caja')
													{				 
														$cuentacb=$_POST[cuentacaja];
														$cajas=$_POST[cuentacaja];
														$cbancos="";
			  										}
													if($_POST[modorec]=='banco')
													{
														$cuentacb=$_POST[banco];				
														$cajas="";
														$cbancos=$_POST[banco];
													}
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
												}
			  								}
		 								}
		 							}
	  							}
							}			 	 
	 						//*************** fin de cobro de recibo
							for($x=0;$x<count($_POST[dcoding]);$x++)
							{
		 						//***** BUSQUEDA INGRESO ********
								$sqlr="Select * from tesoindustria_det where id_industria=".$_POST[idrecaudo];
								$res=mysql_query($sqlr,$linkbd);
								$row=mysql_fetch_row($res);
								$industria=$row[1];
								$avisos=$row[2];
								$bomberil=$row[3];
								$retenciones=$row[4];
								$sanciones=$row[5];	
								$intereses=$row[6];		
								$antivigact=$row[11];		
								$antivigant=$row[10];		
								$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
								$res=mysql_query($sqlri,$linkbd);
								while($row=mysql_fetch_row($res))
								{
									if($row[2]=='04') //*****industria
									{
										$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='04' and tipo='C'";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
					  					{
											if($row2[3]=='N')
											{				 					  		
												if($row2[6]=='S')
												{				 
													$valordeb=0;
													$valorcred=$industria+$sanciones+$intereses;
						 							$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Industria y Comercio $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);	 
													//********** CAJA O BANCO
													//*** retencion ica
													$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
													$rescr=mysql_query($sqlr2,$linkbd);
													while($rowcr=mysql_fetch_row($rescr))
													{
														if($rowcr[3]=='N')
														{
															if($rowcr[6]=='S')
															{
																$cuentaretencion= $rowcr[4];
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero, centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentaretencion."','".$_POST[tercero]."','".$row2[5]."','Retenciones Industria y Comercio','',".$retenciones.",0,'1','".$_POST[vigencia]."')";
																mysql_query($sqlr,$linkbd);
						 									}
														}
					  								}
					 								//**fin rete ica
													$valordeb=$industria+$sanciones+$intereses-$retenciones-$antivigant;
													$valorcred=0;
													if($valordeb<0)
													{
						 								$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
														$res2=mysql_query($sqlr2,$linkbd);
														while($row2=mysql_fetch_row($res2))
														{
															if($row2[3]=='N')
															{				 					  		
							   									if($row2[7]=='S')
								 								{	
																	$cuentacbr=$row2[4];
																	$valordeb=0;
																	$valorcred=$retenciones;
								 								}
															}
							  							}			 
						 							}
													else
													{
						  								$cuentacbr=$cuentacb;
						 							}
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacbr."','".$_POST[tercero]."','".$row2[5]."','Industria y Comercio $_POST[modorec]','',".($valordeb).",$valorcred,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
						
													$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$industria  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
													mysql_query($sqlr,$linkbd);
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$industria,'".$vigusu."')";
													mysql_query($sqlr,$linkbd);	
						 						}
											}
					  					}
			  						}
									if($row[2]=='05')//************avisos
									{
										$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='05' and tipo='C'";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{				 					  		
												if($row2[6]=='S')
												{				 
													$valordeb=0;
													$valorcred=$avisos;					
						  							$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Avisos y Tableros $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);	 
													//********** CAJA O BANCO
													$valordeb=$avisos;
													$valorcred=0;
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','Avisos y Tableros $_POST[modorec]','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
													$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$avisos  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
													mysql_query($sqlr,$linkbd);
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$avisos,'".$vigusu."')";
		  			  								mysql_query($sqlr,$linkbd);	
						 						}
											}						
					  					}
			  						}
									if($row[2]=='P11')//************ANTICIPOS VIG ACTUAL ****************** 
									{
										$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{				 					  		
					   							if($row2[7]=='S')
												{				 
													$valordeb=0;
													$valorcred=$antivigact;					
						  							$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','ANTICIPO VIGENCIA ACTUAL $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);	 
													//********** CAJA O BANCO
													$valordeb=$antivigact;
													$valorcred=0;
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','ANTICIPO VIGENCIA ACTUAL $_POST[modorec]','',$valordeb,0,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);											
						 						}
											}						
					  					}
			  						}
									//*******************
									if($row[2]=='P11')//************ANTICIPOS VIG ANTERIOR ****************** 
									{
										$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{
												if($row2[7]=='S')
												{				 
													$valorcred=0;
													$valordeb=$antivigant;					
						  							$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','ANTICIPO VIGENCIA ANTERIOR $_POST[ageliquida]','',$valordeb,$valorcred,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);	 
													//********** CAJA O BANCO
													$valordeb=$industria-$retenciones-$antivigant;
													$valorcred=0;
						 						}
											}						
					  					}
			  						}
			  						//*******************
									if($row[2]=='06') //*********bomberil ********
			  						{
										$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='06' and tipo='C'";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{				 					  		
					   							if($row2[6]=='S')
						 						{				 
													$valordeb=0;
													$valorcred=$bomberil;					
													$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Bomberil $_POST[ageliquida]','',".$valordeb.",$valorcred,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);	 
													//********** CAJA O BANCO
													$valordeb=$bomberil;
													$valorcred=0;
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','Bomberil $_POST[modorec]','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
													//***MODIFICAR PRESUPUESTO
													$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$bomberil  WHERE cuenta=$row[6]   and vigencia=".$vigusu;
													mysql_query($sqlr,$linkbd);
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$bomberil,'".$vigusu."')";
  			  										mysql_query($sqlr,$linkbd);	
						 						}
											}
					  					}
			   						}
		    					}
		  					}
						}
   					}
	 				else
	 				{
	 					echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion <img src='imagenes/alert.png'></center></td></tr></table>";
	 				}
		 
				break; 
	  			case 3: //**************OTROS RECAUDOS
	
    				$sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='5'";
	  				mysql_query($sqlr,$linkbd);
					$sqlr="delete from comprobante_det where  numerotipo=$_POST[idcomp] and tipo_comp='5'";
					mysql_query($sqlr,$linkbd);
					$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
					mysql_query($sqlr,$linkbd);
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
					//***busca el consecutivo del comprobante contable
					$consec=$_POST[idcomp];
					//***cabecera comprobante
	 				$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,5,'$fechaf','".$descrip."',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estadoc]')";
					mysql_query($sqlr,$linkbd);
					$idcomp=mysql_insert_id();
		
		  			$sqlr="delete from pptorecibocajappto where idrecibo=$consec ";
					//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
					for($x=0;$x<count($_POST[dcoding]);$x++)
					{
		 				//***** BUSQUEDA INGRESO ********
						$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
						$resi=mysql_query($sqlri,$linkbd);
						while($rowi=mysql_fetch_row($resi))
						{
	    					//**** busqueda cuenta presupuestal*****
							//busqueda concepto contable
							$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
	 	 					$resc=mysql_query($sqlrc,$linkbd);	  
		 					//echo "concc: $sqlrc <br>";	      
							while($rowc=mysql_fetch_row($resc))
							{
								$porce=$rowi[5];
								echo "";			  
								if($rowc[6]=='S' and $_POST[dcoding][$x]!=$_POST[cobrorecibo])
								{				 			  
			  						$cuenta=$rowc[4];
									$valorcred=$_POST[dvalores][$x]*($porce/100);
									$valordeb=0;
									if($rowc[3]=='N')
									{
										//*****inserta del concepto contable  
										//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
										$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
										$respto=mysql_query($sqlrpto,$linkbd);	  
										$rowpto=mysql_fetch_row($respto);
			
										$vi=$_POST[dvalores][$x]*($porce/100);
										$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			
			  							//****creacion documento presupuesto ingresos
		
										$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$consec,$vi,'".$vigusu."')";
										mysql_query($sqlr,$linkbd);	
										//************ FIN MODIFICACION PPTAL
			
										$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $consec','".$cuenta."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
										mysql_query($sqlr,$linkbd);
											//***cuenta caja o banco
										if($_POST[modorec]=='caja')
										{				 
											$cuentacb=$_POST[cuentacaja];
											$cajas=$_POST[cuentacaja];
											$cbancos="";
										}
										if($_POST[modorec]=='banco')
										{
											$cuentacb=$_POST[banco];				
											$cajas="";
											$cbancos=$_POST[banco];
										}
										$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $consec','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
										mysql_query($sqlr,$linkbd);
									}
								
								}
								if($_POST[dcoding][$x]==$_POST[cobrorecibo] and $rowc[7]=='S')
								{
			  						$cuenta=$rowc[4];
			  			  			$cuenta=$rowc[4];
									$valorcred=$_POST[dvalores][$x]*($porce/100);
									$valordeb=0;
									if($rowc[3]=='N')
									{
										//*****inserta del concepto contable  
										//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
										$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
										$respto=mysql_query($sqlrpto,$linkbd);	  
										$rowpto=mysql_fetch_row($respto);
										$vi=$_POST[dvalores][$x]*($porce/100);
										$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			
										//****creacion documento presupuesto ingresos
										$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$consec,$vi,'".$vigusu."')";
										mysql_query($sqlr,$linkbd);	
										//************ FIN MODIFICACION PPTAL
										$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $consec','".$cuenta."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
										mysql_query($sqlr,$linkbd);
										//echo $sqlr."<br>";						
											//***cuenta caja o banco
										if($_POST[modorec]=='caja')
										{				 
											$cuentacb=$_POST[cuentacaja];
											$cajas=$_POST[cuentacaja];
											$cbancos="";
										}
										if($_POST[modorec]=='banco')
										{
											$cuentacb=$_POST[banco];				
											$cajas="";
											$cbancos=$_POST[banco];
										}
										$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $consec','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
										mysql_query($sqlr,$linkbd);
									}			  
			  					}
		 					}
		 				}
					}	
	
	   			break;
	   				//********************* INDUSTRIA Y COMERCIO
			} //*****fin del switch
			$sqlr="delete from tesoreciboscaja_det where id_recibos=$_POST[idcomp]";
			mysql_query($sqlr,$linkbd); 
			for($x=0;$x<count($_POST[dcoding]);$x++)
		 	{
				$sqlr="insert into tesoreciboscaja_det (id_recibos,ingreso,valor,estado) values($_POST[idcomp],'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	  
				mysql_query($sqlr,$linkbd);  
		 	}		
		}//***bloqueo
		else
	   	{
    		echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
	   	}
   	}//**fin del oculto 
  
	?>	
	<table class="inicio">
		<tr><td colspan="4" class="titulos">Detalle Recibo de Caja</td></tr>                  
		<tr>
			<td class="titulos2">Codigo</td>
			<td class="titulos2">Ingreso</td>
			<td class="titulos2">Valor</td>
		</tr>
		<?php 		
			$_POST[totalc]=0;
			$iter='saludo1a';
			$iter2='saludo2';
			$namearch="archivos/".$_SESSION[usuario]."-reporterecibos.csv";
			$Descriptor1 = fopen($namearch,"w+"); 
			fputs($Descriptor1,"CODIGO;VALOR\r\n");
			for ($x=0;$x<count($_POST[dcoding]);$x++)
			{		 
				echo "
				<input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."'>
				<input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."'>
				<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."' style='width:100%;'>
				<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
					<td style='width:10%;'>".$_POST[dcoding][$x]."</td>
					<td>".$_POST[dncoding][$x]."</td>
					<td style='width:20%;text-align:right;'>$ ".number_format($_POST[dvalores][$x],2,',','.')."</td>				
				</tr>";
				//fputs($Descriptor1,"".$_POST[dcoding][$x]".;;$row[2];$rowt[0];$ntercero;$row[8];$row[4];".$tipos[$row[10]-1].";$row[9]\r\n");
				$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
				$_POST[totalcf]=number_format($_POST[totalc],2);
				$totalg=number_format($_POST[totalc],2,'.','');
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
				
			}
			if ($_POST[totalc]!='' && $_POST[totalc]!=0){$_POST[letras] = convertirdecimal($totalg,'.');}
			else{$_POST[letras]=''; $_POST[totalcf]=0;}
			echo "
				<input type='hidden' name='totalcf' value='$_POST[totalcf]'>
				<input name='totalc' type='hidden' value='$_POST[totalc]'>
				<input type='hidden' name='letras' value='$_POST[letras]'>
				<tr class='$iter' >
					<td style='text-align:right;' colspan='2'>Total:</td>
					<td style='text-align:right;'>$ ".number_format($_POST[totalc],2,',','.')."</td>
				</tr>
				<tr class='titulos2'>
					<td>Son:</td>
					<td colspan='5'>$_POST[letras]</td>
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
 </td></tr>
</table>
	
</body>
</html>