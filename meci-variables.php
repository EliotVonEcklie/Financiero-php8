<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<?php require "head.php"; ?>
		<title>:: Spid - Calidad</title>

        <script>
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
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
						case "5":	
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;
					}
				}
			}
			function funcionmensaje()
			{
				var pesact=document.form2.tabgroup1.value;
				switch(pesact)
                {
                    case "1":
						document.getElementById('bana01').value=0;
						document.getElementById('limpiar').value=1;break;
					case "2":
						document.getElementById('bana02').value=0;
						document.getElementById('limpiar').value=2;break;
					case "3":
						document.getElementById('bana03').value=0;
						document.getElementById('limpiar').value=3;break;
					case "4":
						document.getElementById('bana04').value=0;
						document.getElementById('limpiar').value=4;break;
					case "5":
						document.getElementById('bana05').value=0;
						document.getElementById('limpiar').value=5;break;
					case "6":
						document.getElementById('bana06').value=0;
						document.getElementById('limpiar').value=6;break;
				}
				// document.form2.submit();
			}
			function guardar()
			{
				var pesact=document.form2.tabgroup1.value;
				var varver='N';
				var nomgua='';
				switch(pesact)
                {
                    case "1":
						nomgua='las Normativas del Marco Legal';
						if(document.getElementById('bana01').value!=0)
							{varver='S';}
						 break;
					case "2":
						nomgua='los Cargos para El Comité Coordibador CI';
						if(document.getElementById('bana02').value!=0)
							{varver='S';}
						 break;
					case "3":
						nomgua='los Cargos para la Alta Dirección';
						if(document.getElementById('bana03').value!=0)
							{varver='S';}
						 break;
					case "4":
						nomgua='los Cargos para el Equipo Meci';
						if(document.getElementById('bana04').value!=0)
							{varver='S';}
						 break;
					case "5":
						nomgua='las Clases de Protocolos Eticos';
						if(document.getElementById('bana05').value!=0)
							{varver='S';}
						 break;
					case "6":
						nomgua='las Categorías del Marco Legal';
						if(document.getElementById('bana06').value!=0)
							{varver='S';}
						 break;
				}
				//alert(nomgua);
				if(varver=='S')
				{
					despliegamodalm('visible','4','Esta Seguro de guardar '+nomgua,'7');
				}
				else
				{
					despliegamodalm('visible','2','Falta información para poder Guardar '+nomgua);
				}
			}
			function agregarlista1()
			{
				if(document.getElementById('nombre1').value!="")
				{
					document.getElementById('bana01').value=parseInt(document.getElementById('bana01').value)+1;
					document.form2.agregar01.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta información para poder Agregar');}
			}
			function agregarlista2()
			{
				if(document.getElementById('nombre2').value!="")
				{
					document.getElementById('bana02').value=parseInt(document.getElementById('bana02').value)+1;
					document.form2.agregar02.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta información para poder Agregar');}
			}
			function agregarlista3()
			{
				if(document.getElementById('nombre3').value!="")
			  	{
					document.getElementById('bana03').value=parseInt(document.getElementById('bana03').value)+1;
					document.form2.agregar03.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta información para poder Agregar');}
			}
			function agregarlista4()
			{
				if(document.getElementById('nombre4').value!="")
			  {
					document.getElementById('bana04').value=parseInt(document.getElementById('bana04').value)+1;
					document.form2.agregar04.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta información para poder Agregar');}
			}
			function agregarlista5()
			{
				if(document.getElementById('nombre5').value!="")
			  {
					document.getElementById('bana05').value=parseInt(document.getElementById('bana05').value)+1;
					document.form2.agregar05.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta información para poder Agregar');}
			}
			function agregarlista6()
			{
				if(document.getElementById('nombre6').value!="")
				{
					document.getElementById('bana06').value=parseInt(document.getElementById('bana06').value)+1;
					document.form2.agregar06.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta información para poder Agregar');}
			}
			function eliminarlista1(variable)
			{
				despliegamodalm('visible','4','Esta Seguro de Eliminar','1');
				document.form2.eliminal1.value=variable;
				document.getElementById('eliminal1').value=variable;
			}
			function eliminarlista2(variable)
			{
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
				document.form2.eliminal2.value=variable;
				document.getElementById('eliminal2').value=variable;
			}
			function eliminarlista3(variable)
			{
				despliegamodalm('visible','4','Esta Seguro de Eliminar','3');
				document.form2.eliminal3.value=variable;
				document.getElementById('eliminal3').value=variable;
			}
			function eliminarlista4(variable)
			{
				despliegamodalm('visible','4','Esta Seguro de Eliminar','4');
				document.form2.eliminal4.value=variable;
				document.getElementById('eliminal4').value=variable;
			}
			function eliminarlista5(variable)
			{
				despliegamodalm('visible','4','Esta Seguro de Eliminar','5');
				document.form2.eliminal5.value=variable;
				document.getElementById('eliminal5').value=variable;
			}
			function eliminarlista6(variable)
			{
				despliegamodalm('visible','4','Esta Seguro de Eliminar','6');
				document.form2.eliminal6.value=variable;
				document.getElementById('eliminal6').value=variable;
			}
			function respuestaconsulta(estado,pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.getElementById('bana01').value=parseInt(document.getElementById('bana01').value)-1;
						document.form2.submit();
					break;
					case "2":	
						document.getElementById('bana02').value=parseInt(document.getElementById('bana02').value)-1;
						document.form2.submit();
					break;
					case "3":	
						document.getElementById('bana03').value=parseInt(document.getElementById('bana03').value)-1;
						document.form2.submit();
					break;
					case "4":	
						document.getElementById('bana04').value=parseInt(document.getElementById('bana04').value)-1;
						document.form2.submit();
					break;
					case "5":	
						document.getElementById('bana05').value=parseInt(document.getElementById('bana05').value)-1;
						document.form2.submit();
					break;
					case "6":	
						document.getElementById('bana06').value=parseInt(document.getElementById('bana06').value)-1;
						document.form2.submit();
					break;
					case "7":
						document.form2.oculto.value="1";
						document.form2.submit();
					break;
				}
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "8":	document.form2.cambioestado.value="1";break;
						case "9":	document.form2.cambioestado.value="0";break;
					}
					document.form2.submit();
				}
				else
				{
					switch(pregunta)
					{
						case "8":	document.form2.nocambioestado.value="1";break;
						case "9":	document.form2.nocambioestado.value="0";break;
					}
					document.form2.submit();
				}
			}
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1)
				{
					despliegamodalm('visible','5','Desea activar esta Normativa','8');
				}
				else
				{
					despliegamodalm('visible','5','Desea Desactivar esta Normativa','9');
				}
			}
			
		</script>
        <!-- <style>
			input[type='range'] {
			-webkit-appearance: none;
			border-radius: 5px;
			box-shadow: inset 0 0 5px #333;
			background-color: #999;
			height: 10px;
			vertical-align: middle;
			}
		</style> -->
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("meci");?></tr>
          	<tr>
          		<td colspan="3" class="cinta">
					<a onClick="nuevo();" class="tooltip bottom mgbt"><img src="imagenes/add.png"/><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png"/><span class="tiptext">Guardar</span></a>
					<a onclick="location.href='meci-variableslbusca.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png" /><span class="tiptext">Buscar</span></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
				</td>
        	</tr>
		</table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" enctype="multipart/form-data"> 
			<?php
        		//*****************************************************************
 				if($_POST[oculto]=="")
                {
					if ($_POST[bana01]==''||$_POST[bana02]==''||$_POST[bana03]==''||$_POST[bana04]==''||$_POST[bana05]==''||$_POST[bana06]=='') {
						$_POST[bana01]=0;$_POST[bana02]=0;$_POST[bana03]=0;$_POST[bana04]=0;$_POST[bana05]=0;$_POST[bana06]=0;
					}
					
					$_POST[tabgroup1]=1;
					$_POST[cambioestado]="";
					$_POST[nocambioestado]="";
					$_POST[limpiar]="";
					$_POST[oculto]="0";
                }
				//*****************************************************************
                switch($_POST[tabgroup1])
                {
                    case 1:
                        $check1='checked';break;
                    case 2:
                        $check2='checked';break;
                    case 3:
                        $check3='checked';break;
                    case 4:
                        $check4='checked';break;
					case 5:
						$check5='checked';break;
					case 6:
                        $check6='checked';break;
                }
				//*****************************************************************

				if($_POST[bana01]>0)
				{
					$_POST[bloqueo1]="";
					$_POST[bloqueo2]="disabled";
					$_POST[bloqueo3]="disabled";
					$_POST[bloqueo4]="disabled";
					$_POST[bloqueo5]="disabled";
					$_POST[bloqueo6]="disabled";
				}
				if($_POST[bana06]>0)
				{
					$_POST[bloqueo1]="disabled";
					$_POST[bloqueo2]="disabled";
					$_POST[bloqueo3]="disabled";
					$_POST[bloqueo4]="disabled";
					$_POST[bloqueo5]="disabled";
					$_POST[bloqueo6]="";
				}
				if($_POST[bana02]>0)
				{
					$_POST[bloqueo1]="disabled";
					$_POST[bloqueo2]="";
					$_POST[bloqueo3]="disabled";
					$_POST[bloqueo4]="disabled";
					$_POST[bloqueo5]="disabled";
					$_POST[bloqueo6]="disabled";
				}
				if($_POST[bana03]>0)
				{
					$_POST[bloqueo1]="disabled";
					$_POST[bloqueo2]="disabled";
					$_POST[bloqueo3]="";
					$_POST[bloqueo4]="disabled";
					$_POST[bloqueo5]="disabled";
					$_POST[bloqueo6]="disabled";
				}
				if($_POST[bana04]>0)
				{
					$_POST[bloqueo1]="disabled";
					$_POST[bloqueo2]="disabled";
					$_POST[bloqueo3]="disabled";
					$_POST[bloqueo4]="";
					$_POST[bloqueo5]="disabled";
					$_POST[bloqueo6]="disabled";
				}
				if($_POST[bana05]>0)
				{
					$_POST[bloqueo1]="disabled";
					$_POST[bloqueo2]="disabled";
					$_POST[bloqueo3]="disabled";
					$_POST[bloqueo4]="disabled";
					$_POST[bloqueo5]="";
					$_POST[bloqueo6]="disabled";
				}

				if($_POST[ocutc1]=="")
				{
					$_POST[ocutc1]="0";
				}
				//*****************************************************************
				if ($_POST[agregar01]=='1')
				{
					$_POST[lnombre1][]=$_POST[nombre1];
					$_POST[ldescripcion1][]=$_POST[descripcion1];
					$_POST[lestado1][]="S";
					$_POST[lswitch1][]=0;
					$_POST[nombre1]="";
					$_POST[descripcion1]="";
					$_POST[agregar01]='0';
				}
				//*****************************************************************
				if ($_POST[agregar02]=='1')
				{
					$_POST[lnombre2][]=$_POST[nombre2];
					$_POST[ldescripcion2][]=$_POST[descripcion2];
					$_POST[lestado2][]="S";
					$_POST[lswitch2][]=0;
					$_POST[nombre2]="";
					$_POST[descripcion2]="";
					$_POST[agregar02]='0';
				}
				//*****************************************************************
				if ($_POST[agregar03]=='1')
				{
					$_POST[lnombre3][]=$_POST[nombre3];
					$_POST[ldescripcion3][]=$_POST[descripcion3];
					$_POST[lestado3][]="S";
					$_POST[lswitch3][]=0;
					$_POST[nombre3]="";
					$_POST[descripcion3]="";
					$_POST[agregar03]='0';
				}
				//*****************************************************************
				if ($_POST[agregar04]=='1')
				{
					$_POST[lnombre4][]=$_POST[nombre4];
					$_POST[ldescripcion4][]=$_POST[descripcion4];
					$_POST[lestado4][]="S";
					$_POST[lswitch4][]=0;
					$_POST[nombre4]="";
					$_POST[descripcion4]="";
					$_POST[agregar04]='0';
				}
				//*****************************************************************
				if ($_POST[agregar05]=='1')
				{
					$_POST[lnombre5][]=$_POST[nombre5];
					$_POST[ldescripcion5][]=$_POST[descripcion5];
					$_POST[lestado5][]="S";
					$_POST[lswitch5][]=0;
					$_POST[nombre5]="";
					$_POST[descripcion5]="";
					$_POST[agregar05]='0';
				}
				//*****************************************************************
				if ($_POST[agregar06]=='1')
				{
					$_POST[lnombre6][]=$_POST[nombre6];
					$_POST[ldescripcion6][]=$_POST[descripcion6];
					$_POST[lestado6][]="S";
					$_POST[lswitch6][]=0;
					$_POST[nombre6]="";
					$_POST[descripcion6]="";
					$_POST[agregar06]='0';
				}
				//*****************************************************************
				if ($_POST[eliminal1]!='')
				{ 
					$posi=$_POST[eliminal1];
					unset($_POST[lnombre1][$posi]);
					unset($_POST[ldescripcion1][$posi]);
					unset($_POST[lestado1][$posi]);
					unset($_POST[lswitch1][$posi]);
					$_POST[lnombre1]= array_values($_POST[lnombre1]); 
					$_POST[ldescripcion1]= array_values($_POST[ldescripcion1]); 
					$_POST[lestado1]= array_values($_POST[lestado1]); 
					$_POST[lswitch1]= array_values($_POST[lswitch1]); 
				}
				//*****************************************************************
				if ($_POST[eliminal2]!='')
				{ 
					$posi=$_POST[eliminal2];
					unset($_POST[lnombre2][$posi]);
					unset($_POST[ldescripcion2][$posi]);
					unset($_POST[lestado2][$posi]);
					unset($_POST[lswitch2][$posi]);
					$_POST[lnombre2]= array_values($_POST[lnombre2]); 
					$_POST[ldescripcion2]= array_values($_POST[ldescripcion2]); 
					$_POST[lestado2]= array_values($_POST[lestado2]); 
					$_POST[lswitch2]= array_values($_POST[lswitch2]); 
				}
				//*****************************************************************
				if ($_POST[eliminal3]!='')
				{ 
					$posi=$_POST[eliminal3];
					unset($_POST[lnombre3][$posi]);
					unset($_POST[ldescripcion3][$posi]);
					unset($_POST[lestado3][$posi]);
					unset($_POST[lswitch3][$posi]);
					$_POST[lnombre3]= array_values($_POST[lnombre3]); 
					$_POST[ldescripcion3]= array_values($_POST[ldescripcion3]); 
					$_POST[lestado3]= array_values($_POST[lestado3]); 
					$_POST[lswitch3]= array_values($_POST[lswitch3]); 
				}
				//*****************************************************************
				if ($_POST[eliminal4]!='')
				{ 
					$posi=$_POST[eliminal4];
					unset($_POST[lnombre4][$posi]);
					unset($_POST[ldescripcion4][$posi]);
					unset($_POST[lestado4][$posi]);
					unset($_POST[lswitch4][$posi]);
					$_POST[lnombre4]= array_values($_POST[lnombre4]); 
					$_POST[ldescripcion4]= array_values($_POST[ldescripcion4]); 
					$_POST[lestado4]= array_values($_POST[lestado4]); 
					$_POST[lswitch4]= array_values($_POST[lswitch4]); 
				}
				//*****************************************************************
				if ($_POST[eliminal5]!='')
				{ 
					$posi=$_POST[eliminal5];
					unset($_POST[lnombre5][$posi]);
					unset($_POST[ldescripcion5][$posi]);
					unset($_POST[lestado5][$posi]);
					unset($_POST[lswitch5][$posi]);
					$_POST[lnombre5]= array_values($_POST[lnombre5]); 
					$_POST[ldescripcion5]= array_values($_POST[ldescripcion5]); 
					$_POST[lestado5]= array_values($_POST[lestado5]); 
					$_POST[lswitch5]= array_values($_POST[lswitch5]); 
				}
				//*****************************************************************
				if ($_POST[eliminal6]!='')
				{ 
					$posi=$_POST[eliminal6];
					unset($_POST[lnombre6][$posi]);
					unset($_POST[ldescripcion6][$posi]);
					unset($_POST[lestado6][$posi]);
					unset($_POST[lswitch6][$posi]);
					$_POST[lnombre6]= array_values($_POST[lnombre6]); 
					$_POST[ldescripcion6]= array_values($_POST[ldescripcion6]); 
					$_POST[lestado6]= array_values($_POST[lestado6]); 
					$_POST[lswitch6]= array_values($_POST[lswitch6]); 
				}
				//*****************************************************************

				if($_POST[cambioestado]!="")
				{
					 switch($_POST[tabgroup1])
					{
						case 1:
							if($_POST[cambioestado]=="1"){$_POST[lestado1][$_POST[idestado]]="S";}
							else {$_POST[lestado1][$_POST[idestado]]="N";}
							$_POST[cambioestado]="";
							break;
						case 2:
							if($_POST[cambioestado]=="1"){$_POST[lestado2][$_POST[idestado]]="S";}
							else {$_POST[lestado2][$_POST[idestado]]="N";}
							$_POST[cambioestado]="";
							break;
						case 3:
							if($_POST[cambioestado]=="1"){$_POST[lestado3][$_POST[idestado]]="S";}
							else {$_POST[lestado3][$_POST[idestado]]="N";}
							$_POST[cambioestado]="";
							break;
						case 4:
							if($_POST[cambioestado]=="1"){$_POST[lestado4][$_POST[idestado]]="S";}
							else {$_POST[lestado4][$_POST[idestado]]="N";}
							$_POST[cambioestado]="";
							break;
						case 5:
							if($_POST[cambioestado]=="1"){$_POST[lestado5][$_POST[idestado]]="S";}
							else {$_POST[lestado5][$_POST[idestado]]="N";}
							$_POST[cambioestado]="";
							break;
						case 6:
							if($_POST[cambioestado]=="1"){$_POST[lestado6][$_POST[idestado]]="S";}
							else {$_POST[lestado6][$_POST[idestado]]="N";}
							$_POST[cambioestado]="";
							break;
					}
				}
				//*****************************************************************
				if($_POST[nocambioestado]!="")
				{
					switch($_POST[tabgroup1])
					{
						case 1:
							if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
							else {$_POST[lswitch1][$_POST[idestado]]=0;}
							$_POST[nocambioestado]="";
							break;
						case 2:
							if($_POST[nocambioestado]=="1"){$_POST[lswitch2][$_POST[idestado]]=1;}
							else {$_POST[lswitch2][$_POST[idestado]]=0;}
							$_POST[nocambioestado]="";
							break;
						case 3:
							if($_POST[nocambioestado]=="1"){$_POST[lswitch3][$_POST[idestado]]=1;}
							else {$_POST[lswitch3][$_POST[idestado]]=0;}
							$_POST[nocambioestado]="";
							break;
						case 4:
							if($_POST[nocambioestado]=="1"){$_POST[lswitch4][$_POST[idestado]]=1;}
							else {$_POST[lswitch4][$_POST[idestado]]=0;}
							$_POST[nocambioestado]="";
							break;
						case 5:
							if($_POST[nocambioestado]=="1"){$_POST[lswitch5][$_POST[idestado]]=1;}
							else {$_POST[lswitch5][$_POST[idestado]]=0;}
							$_POST[nocambioestado]="";
							break;
						case 6:
							if($_POST[nocambioestado]=="1"){$_POST[lswitch6][$_POST[idestado]]=1;}
							else {$_POST[lswitch6][$_POST[idestado]]=0;}
							$_POST[nocambioestado]="";
							break;
					}
				}
				//*****************************************************************
				if($_POST[limpiar]!="")
				{
					switch($_POST[tabgroup1])
					{
						case 1:
							$_POST[nombre1]="";
							$_POST[descripcion1]="";
							$xx=count($_POST[lnombre1]);
							for($posi=0;$posi<$xx;$posi++)
							{
								unset($_POST[lnombre1][0]);
								unset($_POST[ldescripcion1][0]);
								unset($_POST[lestado1][0]);
								unset($_POST[lswitch1][0]);
								$_POST[lnombre1]= array_values($_POST[lnombre1]); 
								$_POST[ldescripcion1]= array_values($_POST[ldescripcion1]); 
								$_POST[lestado1]= array_values($_POST[lestado1]); 
								$_POST[lswitch1]= array_values($_POST[lswitch1]);
							}
							break;
						case 2:
							$_POST[nombre2]="";
							$_POST[descripcion2]="";
							$xx=count($_POST[lnombre2]);
							for($posi=0;$posi<$xx;$posi++)
							{
								unset($_POST[lnombre2][0]);
								unset($_POST[ldescripcion2][0]);
								unset($_POST[lestado2][0]);
								unset($_POST[lswitch2][0]);
								$_POST[lnombre2]= array_values($_POST[lnombre2]); 
								$_POST[ldescripcion2]= array_values($_POST[ldescripcion2]); 
								$_POST[lestado2]= array_values($_POST[lestado2]); 
								$_POST[lswitch2]= array_values($_POST[lswitch2]);
							}
							break;
						case 3:
							$_POST[nombre3]="";
							$_POST[descripcion3]="";
							$xx=count($_POST[lnombre3]);
							for($posi=0;$posi<$xx;$posi++)
							{
								unset($_POST[lnombre3][0]);
								unset($_POST[ldescripcion3][0]);
								unset($_POST[lestado3][0]);
								unset($_POST[lswitch3][0]);
								$_POST[lnombre3]= array_values($_POST[lnombre3]); 
								$_POST[ldescripcion3]= array_values($_POST[ldescripcion3]); 
								$_POST[lestado3]= array_values($_POST[lestado3]); 
								$_POST[lswitch3]= array_values($_POST[lswitch3]);
							}
							break;
						case 4:
							$_POST[nombre4]="";
							$_POST[descripcion4]="";
							$xx=count($_POST[lnombre4]);
							for($posi=0;$posi<$xx;$posi++)
							{
								unset($_POST[lnombre4][0]);
								unset($_POST[ldescripcion4][0]);
								unset($_POST[lestado4][0]);
								unset($_POST[lswitch4][0]);
								$_POST[lnombre4]= array_values($_POST[lnombre4]); 
								$_POST[ldescripcion4]= array_values($_POST[ldescripcion4]); 
								$_POST[lestado4]= array_values($_POST[lestado4]); 
								$_POST[lswitch4]= array_values($_POST[lswitch4]);
							}
							break;
						case 5:
							$_POST[nombre5]="";
							$_POST[descripcion5]="";
							$xx=count($_POST[lnombre5]);
							for($posi=0;$posi<$xx;$posi++)
							{
								unset($_POST[lnombre5][0]);
								unset($_POST[ldescripcion5][0]);
								unset($_POST[lestado5][0]);
								unset($_POST[lswitch5][0]);
								$_POST[lnombre5]= array_values($_POST[lnombre5]); 
								$_POST[ldescripcion5]= array_values($_POST[ldescripcion5]); 
								$_POST[lestado5]= array_values($_POST[lestado5]); 
								$_POST[lswitch5]= array_values($_POST[lswitch5]);
							}
							break;
						case 6:
							$_POST[nombre6]="";
							$_POST[descripcion6]="";
							$xx=count($_POST[lnombre6]);
							for($posi=0;$posi<$xx;$posi++)
							{
								unset($_POST[lnombre6][0]);
								unset($_POST[ldescripcion6][0]);
								unset($_POST[lestado6][0]);
								unset($_POST[lswitch6][0]);
								$_POST[lnombre6]= array_values($_POST[lnombre6]); 
								$_POST[ldescripcion6]= array_values($_POST[ldescripcion6]); 
								$_POST[lestado6]= array_values($_POST[lestado6]); 
								$_POST[lswitch6]= array_values($_POST[lswitch6]);
							}
							break;
					}
				}
			?>
            <input type="hidden" name="bana01" id="bana01" value="<?php echo $_POST[bana01];?>">
            <input type="hidden" name="bana02" id="bana02" value="<?php echo $_POST[bana02];?>">
            <input type="hidden" name="bana03" id="bana03" value="<?php echo $_POST[bana03];?>">
            <input type="hidden" name="bana04" id="bana04" value="<?php echo $_POST[bana04];?>">
			<input type="hidden" name="bana05" id="bana05" value="<?php echo $_POST[bana05];?>">
			<input type="hidden" name="bana06" id="bana06" value="<?php echo $_POST[bana06];?>">
            <div class="tabsmeci"  style="height:76.5%; width:99.6%">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> <?php echo $_POST[bloqueo1];?>>
                    <label for="tab-1">Normativas Marco Legal</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:93%">Normativas Marco Legal</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre1" id="nombre1" value="<?php echo $_POST[nombre1];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td style="width:50%">
                                	<input type="text" name="descripcion1" id="descripcion1" value="<?php echo $_POST[descripcion1];?>" style="width:100%">
                                </td>
                                <td style="padding-bottom: 5px;">
									<em name="bagregar1" class="botonflecha" onclick="agregarlista1()">Agregar</em>
								</td>
                            </tr>
                        </table>
                         <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                                <tr class="centrartext">
                                    <td class="titulos" style="width:4%;">N&deg;</td>
                                    <td class="titulos" style="width:20%;">Nombre</td>
                                    <td class="titulos" style="width:40%;">Descripci&oacute;n</td>
                                    <td class="titulos" style="width:5%;">Estado</td>
                                     <td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[lnombre1]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
										if($_POST[lestado1][$x]=='S') 
										{$coloracti="#0F0";}
										else 
										{$coloracti="#C00";}
                                        echo "
                                            <tr class='$iter'>
                                                <td class='centrartext'>".($x+1)."</td>
                                                <td><input class='inpnovisibles' type='text' name='lnombre1[]' value='".$_POST[lnombre1][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='ldescripcion1[]' value='".$_POST[ldescripcion1][$x]."' style='width:100%;' readonly></td>
												<td class='centrartext'>
													<input class='inpnovisibles' type='hidden' name='lestado1[]' value='".$_POST[lestado1][$x]."' style='width:100%;' readonly>
													<input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$x]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch($x,\"".$_POST[lswitch1][$x]."\")' />
												</td>
                                                <td class='centrartext'><a  onclick='eliminarlista1($x)'><img src='imagenes/del.png' title='Eliminar'></a></td>
                                            </tr>";  
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux; 
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
				</div> 
				<div class="tab">
                    <input type="radio" id="tab-6" name="tabgroup1" value="6" <?php echo $check6;?> <?php echo $_POST[bloqueo6];?>>
                    <label for="tab-6">Categor&iacute;as Marco Legal</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:93%">Categor&iacute;as Marco Legal</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre6" id="nombre6" value="<?php echo $_POST[nombre6];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td style="width:50%">
                                	<input type="text" name="descripcion6" id="descripcion6" value="<?php echo $_POST[descripcion6];?>" style="width:100%">
								</td>
								<td style="padding-bottom: 5px;">
									<em name="bagregar6" class="botonflecha" onclick="agregarlista6()">Agregar</em>
								</td>
                            </tr>
                        </table>
                         <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                                <tr class="centrartext">
                                    <td class="titulos" style="width:4%;">N&deg;</td>
                                    <td class="titulos" style="width:20%;">Nombre</td>
                                    <td class="titulos" style="width:40%;">Descripci&oacute;n</td>
                                    <td class="titulos" style="width:5%;">Estado</td>
                                     <td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[lnombre6]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
										if($_POST[lestado6][$x]=='S') 
										{$coloracti="#0F0";}
										else 
										{$coloracti="#C00";}
                                        echo "
                                            <tr class='$iter'>
                                                <td class='centrartext'>".($x+1)."</td>
                                                <td><input class='inpnovisibles' type='text' name='lnombre6[]' value='".$_POST[lnombre6][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='ldescripcion6[]' value='".$_POST[ldescripcion6][$x]."' style='width:100%;' readonly></td>
												<td class='centrartext'>
													<input class='inpnovisibles' type='hidden' name='lestado6[]' value='".$_POST[lestado6][$x]."' style='width:100%;' readonly>
													<input type='range' name='lswitch6[]' value='".$_POST[lswitch6][$x]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch($x,\"".$_POST[lswitch6][$x]."\")' />
												</td>
                                                <td class='centrartext'><a  onclick='eliminarlista6($x)'><img src='imagenes/del.png' title='Eliminar'></a></td>
                                            </tr>";  
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux; 
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div> 
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?><?php echo $_POST[bloqueo2];?>>
                    <label for="tab-2">Cargos Comit&eacute; Coordinador CI</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:93%">Cargos Comit&eacute; Coordinador CI</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre2" id="nombre2" value="<?php echo $_POST[nombre2];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td style="width:50%">
                                	<input type="text" name="descripcion2" id="descripcion2" value="<?php echo $_POST[descripcion2];?>" style="width:100%">
								</td>
								<td style="padding-bottom: 5px;">
									<em name="bagregar2" class="botonflecha" onclick="agregarlista2()">Agregar</em>
								</td>
                            </tr>
                        </table>  
                        <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                                <tr class="centrartext">
                                    <td class="titulos" style="width:4%;">N&deg;</td>
                                    <td class="titulos" style="width:20%;">Nombre</td>
                                    <td class="titulos" style="width:40%;">Descripci&oacute;n</td>
                                    <td class="titulos" style="width:5%;">Estado</td>
                                     <td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[lnombre2]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
										if($_POST[lestado2][$x]=='S') 
										{$coloracti="#0F0";}
										else 
										{$coloracti="#C00";}
                                        echo "
                                            <tr class='$iter'>
                                                <td class='centrartext'>".($x+1)."</td>
                                                <td><input class='inpnovisibles' type='text' name='lnombre2[]' value='".$_POST[lnombre2][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='ldescripcion2[]' value='".$_POST[ldescripcion2][$x]."' style='width:100%;' readonly></td>
												<td class='centrartext'>
													<input class='inpnovisibles' type='hidden' name='lestado2[]' value='".$_POST[lestado2][$x]."' style='width:100%;' readonly>
													<input type='range' name='lswitch2[]' value='".$_POST[lswitch2][$x]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch($x,\"".$_POST[lswitch2][$x]."\")' />
												</td>
                                                <td class='centrartext'><a onclick='eliminarlista2($x)'><img src='imagenes/del.png' title='Eliminar'></a></td>
                                            </tr>";  
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux; 
                                    }
                                ?>
                            </table>
                        </div>	
                    </div>
                </div>
                <div class="tab"> 
                    <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> <?php echo $_POST[bloqueo3];?>>
                    <label for="tab-3">Cargos Alta Direcci&oacute;n</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:93%">Cargos Alta Direcci&oacute;n</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre3" id="nombre3" value="<?php echo $_POST[nombre3];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td style="width:50%">
                                	<input type="text" name="descripcion3" id="descripcion3" value="<?php echo $_POST[descripcion3];?>" style="width:100%">
								</td>
								<td style="padding-bottom: 5px;">
									<em name="bagregar3" class="botonflecha" onclick="agregarlista3()">Agregar</em>
								</td>
                            </tr>
                        </table>  
                        <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                                <tr class="centrartext">
                                    <td class="titulos" style="width:4%;">N&deg;</td>
                                    <td class="titulos" style="width:20%;">Nombre</td>
                                    <td class="titulos" style="width:40%;">Descripci&oacute;n</td>
                                    <td class="titulos" style="width:5%;">Estado</td>
                                     <td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[lnombre3]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
										if($_POST[lestado3][$x]=='S') 
										{$coloracti="#0F0";}
										else 
										{$coloracti="#C00";}
                                        echo "
                                            <tr class='$iter'>
                                                <td class='centrartext'>".($x+1)."</td>
                                                <td><input class='inpnovisibles' type='text' name='lnombre3[]' value='".$_POST[lnombre3][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='ldescripcion3[]' value='".$_POST[ldescripcion3][$x]."' style='width:100%;' readonly></td>
												<td class='centrartext'>
													<input class='inpnovisibles' type='hidden' name='lestado3[]' value='".$_POST[lestado3][$x]."' style='width:100%;' readonly>
													<input type='range' name='lswitch3[]' value='".$_POST[lswitch3][$x]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch($x,\"".$_POST[lswitch3][$x]."\")' />
												</td>
                                                <td class='centrartext'><a onclick='eliminarlista3($x)'><img src='imagenes/del.png' title='Eliminar'></a></td>
                                            </tr>";  
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux; 
                                    }
                                ?>
                            </table>
                        </div>		
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> <?php echo $_POST[bloqueo4];?>>
                    <label for="tab-4">Cargos Equipo Meci</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:93%">Cargos Equipo Meci</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre4" id="nombre4" value="<?php echo $_POST[nombre4];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td style="width:50%">
                                	<input type="text" name="descripcion4" id="descripcion4" value="<?php echo $_POST[descripcion4];?>" style="width:100%">
								</td>
								<td style="padding-bottom: 5px;">
									<em name="bagregar4" class="botonflecha" onclick="agregarlista4()">Agregar</em>
								</td>
                            </tr>
                        </table>  
                        <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                                <tr class="centrartext">
                                    <td class="titulos" style="width:4%;">N&deg;</td>
                                    <td class="titulos" style="width:20%;">Nombre</td>
                                    <td class="titulos" style="width:40%;">Descripci&oacute;n</td>
                                    <td class="titulos" style="width:5%;">Estado</td>
                                     <td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[lnombre4]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
										if($_POST[lestado4][$x]=='S') 
										{$coloracti="#0F0";}
										else 
										{$coloracti="#C00";}
                                        echo "
                                            <tr class='$iter'>
                                                <td class='centrartext'>".($x+1)."</td>
                                                <td><input class='inpnovisibles' type='text' name='lnombre4[]' value='".$_POST[lnombre4][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='ldescripcion4[]' value='".$_POST[ldescripcion4][$x]."' style='width:100%;' readonly></td>
												<td class='centrartext'>
													<input class='inpnovisibles' type='hidden' name='lestado4[]' value='".$_POST[lestado4][$x]."' style='width:100%;' readonly>
													<input type='range' name='lswitch4[]' value='".$_POST[lswitch4][$x]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch($x,\"".$_POST[lswitch4][$x]."\")' />
												</td>
                                                <td class='centrartext'><a onclick='eliminarlista4($x)'><img src='imagenes/del.png' title='Eliminar'></a></td>
                                            </tr>";  
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux; 
                                    }
                                ?>
                            </table>
                        </div>		
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-5" name="tabgroup1" value="5" <?php echo $check5;?><?php echo $_POST[bloqueo5];?> >
                    <label for="tab-5">Clases Protocolos Eticos</label>
                    <div class="content" style="overflow:hidden;">
                    	<table class="inicio ancho">
                        	<tr>
                           		<td class="titulos" colspan="8" style="width:93%">Clases Protocolos Eticos</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:8%">Nombre:</td>
                                <td style="width:20%">
                                	<input type="text" name="nombre5" id="nombre5" value="<?php echo $_POST[nombre5];?>" style="width:100%">
                                </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
                                <td style="width:50%">
                                	<input type="text" name="descripcion5" id="descripcion5" value="<?php echo $_POST[descripcion5];?>" style="width:100%">
								</td>
								<td style="padding-bottom: 5px;">
									<em name="bagregar5" class="botonflecha" onclick="agregarlista5()">Agregar</em>
								</td>
                            </tr>
                        </table>  
                        <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                                <tr class="centrartext">
                                    <td class="titulos" style="width:4%;">N&deg;</td>
                                    <td class="titulos" style="width:20%;">Nombre</td>
                                    <td class="titulos" style="width:40%;">Descripci&oacute;n</td>
                                    <td class="titulos" style="width:5%;">Estado</td>
                                     <td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[lnombre5]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
										if($_POST[lestado5][$x]=='S') 
										{$coloracti="#0F0";}
										else 
										{$coloracti="#C00";}
                                        echo "
                                            <tr class='$iter'>
                                                <td class='centrartext'>".($x+1)."</td>
                                                <td><input class='inpnovisibles' type='text' name='lnombre5[]' value='".$_POST[lnombre5][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='ldescripcion5[]' value='".$_POST[ldescripcion5][$x]."' style='width:100%;' readonly></td>
												<td class='centrartext'>
													<input class='inpnovisibles' type='hidden' name='lestado5[]' value='".$_POST[lestado5][$x]."' style='width:100%;' readonly>
													<input type='range' name='lswitch5[]' value='".$_POST[lswitch5][$x]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch($x,\"".$_POST[lswitch5][$x]."\")' />
												</td>
                                                <td class='centrartext'><a onclick='eliminarlista5($x)'><img src='imagenes/del.png' title='Eliminar'></a></td>
                                            </tr>";  
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux; 
                                    }
                                ?>
                            </table>
                        </div>		
                    </div>
                </div>
            </div>  
			<?php  
			 //********guardar
                if($_POST[oculto]=="1")
                {
					$linkbd=conectar_bd();;
					switch($_POST[tabgroup1])
					{
						case 1://************************************************
							$xconta=count($_POST[lnombre1]);
							$conmensaje="Se Guardo con Exito Las Normativas del Marco Legal";
							for($x=0;$x<$xconta;$x++)
							{
								$mxa=selconsecutivo('mecivariables','id');
								$sqlnorma="INSERT INTO mecivariables (id,nombre,descripcion,estado,clase) VALUES ('$mxa','".$_POST[lnombre1][$x]."','".$_POST[ldescripcion1][$x]."','".$_POST[lestado1][$x]."','NML')";
								mysql_query($sqlnorma,$linkbd);
								
							}
							break;
						case 2://************************************************
							$xconta=count($_POST[lnombre2]);
							$conmensaje="Se Guardo con Exito Los Cargos para El Comit� Coordinador CI";
							for($x=0;$x<$xconta;$x++)
							{
								$mxa=selconsecutivo('mecivariables','id');
								$sqlnorma="INSERT INTO mecivariables (id,nombre,descripcion,estado,clase) VALUES ('$mxa','".$_POST[lnombre2][$x]."','".$_POST[ldescripcion2][$x]."','".$_POST[lestado2][$x]."','CCC')";
								mysql_query($sqlnorma,$linkbd);
							}
							break;
						case 3://************************************************
							$xconta=count($_POST[lnombre3]);
							$conmensaje="Se Guardo con Exito Los Cargos para la Alta Direcci�n";
							for($x=0;$x<$xconta;$x++)
							{
								$mxa=selconsecutivo('mecivariables','id');
								$sqlnorma="INSERT INTO mecivariables (id,nombre,descripcion,estado,clase) VALUES ('$mxa','".$_POST[lnombre3][$x]."','".$_POST[ldescripcion3][$x]."','".$_POST[lestado3][$x]."','CAD')";
								mysql_query($sqlnorma,$linkbd);
							}
							break;
						case 4://************************************************
							$xconta=count($_POST[lnombre4]);
							$conmensaje="Se Guardo con Exito Los Cargos para el Equipo Meci";
							for($x=0;$x<$xconta;$x++)
							{
								$mxa=selconsecutivo('mecivariables','id');
								$sqlnorma="INSERT INTO mecivariables (id,nombre,descripcion,estado,clase) VALUES ('$mxa','".$_POST[lnombre4][$x]."','".$_POST[ldescripcion4][$x]."','".$_POST[lestado4][$x]."','CEM')";
								mysql_query($sqlnorma,$linkbd);
							}
							break;
						case 5://************************************************
							$xconta=count($_POST[lnombre5]);
							$conmensaje="Se Guardo con Exito Las Calses de Protocolos Eticos";
							for($x=0;$x<$xconta;$x++)
							{
								$mxa=selconsecutivo('mecivariables','id');
								$sqlnorma="INSERT INTO mecivariables (id,nombre,descripcion,estado,clase) VALUES ('$mxa','".$_POST[lnombre5][$x]."','".$_POST[ldescripcion5][$x]."','".$_POST[lestado5][$x]."','CPE')";
								mysql_query($sqlnorma,$linkbd);
							}
							break;
						case 6://************************************************
							$xconta=count($_POST[lnombre6]);
							$conmensaje="Se Guardo con Exito Las Categorías del Marco Legal";
							for($x=0;$x<$xconta;$x++)
							{
								$mxa=selconsecutivo('mecivariables','id');
								$sqlnorma="INSERT INTO mecivariables (id,nombre,descripcion,estado,clase) VALUES ('$mxa','".$_POST[lnombre6][$x]."','".$_POST[ldescripcion6][$x]."','".$_POST[lestado6][$x]."','CML')";
								mysql_query($sqlnorma,$linkbd);
								
							}
							break;
					}
					echo"<script>despliegamodalm('visible','1','$conmensaje');</script>";
					$_POST[oculto]="0";
				}
			
            ?>
            <input type="hidden" name="agregar01" value="0">
            <input type="hidden" name="agregar02" value="0">
            <input type="hidden" name="agregar03" value="0">
            <input type="hidden" name="agregar04" value="0">
			<input type="hidden" name="agregar05" value="0">
			<input type="hidden" name="agregar06" value="0">
            <input type='hidden' name='eliminal1' id='eliminal1'>
            <input type='hidden' name='eliminal2' id='eliminal2'>
            <input type='hidden' name='eliminal3' id='eliminal3'>
            <input type='hidden' name='eliminal4' id='eliminal4'>
			<input type='hidden' name='eliminal5' id='eliminal5'>
			<input type='hidden' name='eliminal6' id='eliminal6'>
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
            <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
            <input type="hidden" name="limpiar" id="limpiar" value="<?php echo $_POST[limpiar];?>">
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
            <input type="hidden" name="ocutc1" id="ocutc1" value="<?php echo $_POST[ocutc1];?>">
 		</form>     
      
	</body>
</html>