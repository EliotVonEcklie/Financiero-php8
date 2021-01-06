 <?php
// require "comun.inc";
// require "funciones.inc";
// require "conversor.php";
if($_POST[oculto]=="")
{
	$_POST["tipomovimientov"]="201";
	$sqlr="select max(id_notaban) from tesonotasbancarias_cab";
//echo $sqlr;
 $cont=0;
 	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp))
	{	
	$_POST[maximo]=$row[0];
	 $_POST[ncomp]=$_POST[maximo];
	$_POST[idcomp]=$_POST[ncomp];
		if($_GET[idr]!="")
		{
	 	 $_POST[idcomp]=$_GET[idr];
		  $_POST[ncomp]=$_POST[idcomp];
		}
	// $cont=$cont+1;
	} 
	
}
if(($_POST[oculto]!=2 && ($_POST[oculto]==1 || $_POST[oculto]=="")) && ($_POST[elimina]=='' && $_POST[agregadet]!='1') )
{
//echo "oculto:".$_POST[oculto]." Elimina:".$_POST[elimina]."  agrega:".$_POST[agregadet];
	  $_POST[dccs]=array();
  	  $_POST[ddocban]=array();
	  $_POST[dcts]=array();
	  $_POST[dbancos]=array();
  	  $_POST[dgbancarios]=array();
	  $_POST[dngbancarios]=array();
	  $_POST[dnbancos]=array();
  	  $_POST[dcbs]=array();
	  $_POST[dvalores]=array();
	  $_POST[drps]=array();
	  $_POST[drubros]=array();
$sqlr="select *from tesonotasbancarias_cab left join tesonotasbancarias_det on  tesonotasbancarias_cab.id_notaban=tesonotasbancarias_det.id_notabancab where tesonotasbancarias_cab.id_notaban=$_POST[idcomp] and tesonotasbancarias_cab.tipo_mov='".$_POST["tipomovimientov"]."'";
// echo $sqlr;
 $cont=0;
 	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp))
	{	 $_POST[idcomp]=$row[0];
		 $_POST[concepto]=$row[5]; 
		 $_POST[conceptoh]=$row[5]; 
		 $_POST[estadoc]=$row[4]; 
		 if ($_POST[estadoc]=="S")
		 $stilo="color:#2CC81C;border:1px solid"; 
		 else
		 $stilo="color:#C81C1C;border:1px solid"; 
		 $_POST[fecha]=$row[2]; 	
		  	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	 $_POST[fecha]=$fechaf;
		 $_POST[dccs][]=$row[12];
		 $_POST[ddocban][]=$row[11];
		 $_POST[dcts][]=$row[14];
 $ctaconban=buscabancocn($row[13],$row[14]);
		 $_POST[dbancos][]=$ctaconban;
		  $_POST[dgbancarios][]=$row[15];
		    $_POST[dngbancarios][]=$row[15]." - ".buscagastoban($row[15]);
		  $_POST[dnbancos][]=buscatercero($row[14]);
		 $_POST[dcbs][]=$row[13];		 
		 $_POST[dvalores][]=$row[17];		
         $_POST[cuenta]=$row[11];
		 $_POST[ncuenta]=buscacuentapres($row[11],2);
		 $_POST[vigencia]=$row[3];
		 $_POST[drps][]=$row[19];		 
		 $_POST[drubros][]=$row[20];
		 $cont=$cont+1;
	} 
}	
 ?>

 <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="5"> Nota Bancaria </td>
        <td style="width:7%" ><label class="boton02" onClick="location.href='teso-principal.php'">Cerrar</label></td>
      </tr>
      <tr>
	  
      	<td style="width:10%;">
      	
      			<tr  >    
			        <td style="width:2.5cm" class="saludo1" >Numero Comp:</td>
			        <td style="width:25%" >
					  <a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
					  <input name="idcomp" id="idcomp" type="text" style="width:30%"  value="<?php echo $_POST[idcomp]?>" onBlur='validar2()'>
					  <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
					  <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
					  <input type="hidden" value="a" name="atras" >
                    <input type="hidden" value="s" name="siguiente" >
                    <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
                    <input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
					  <input name="vigencia" style="width:30%"  type="text" value="<?php echo $_POST[vigencia] ?>" readonly>
					  <select name="tipomovimientov" id="tipomovimientov" onKeyUp="return tabular(event,this)" onChange="validar2()" style="width:20%;" >
							<?php 
								$user=$_SESSION[cedulausu];
								$sql="SELECT tesonotasbancarias_cab.tipo_mov from tesonotasbancarias_cab  where tesonotasbancarias_cab.id_notaban=$_POST[idcomp]";
								$res=mysql_query($sql,$linkbd);								
							
									while ($row =mysql_fetch_row($res)) 
									{
										if($_POST[tipomovimientov]==$row[0]){
											echo "<option value='$row[0]' SELECTED >$row[0]</option>";
										}else{
											echo "<option value='$row[0]'>$row[0]</option>";
										}
									}
								
								
							?>
						</select>
					</td>
					
			        <td style="width:2.5cm" class="saludo1">Fecha:</td>
			        <td style="width:32%">
					  <input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" style="width:34%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
					</td>    
			       <td><label style="<?php echo $stilo;	 ?>"><?php if($_POST["estadoc"]=="S"){echo "ACTIVO";}else{echo "REVERSADO";} ?></label></td>
			   	</tr>
			    <tr>
			        <td class="saludo1">Concepto Nota:</td>
			        <td colspan="3">
					  <input id="concepto" name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%" onKeyUp="return tabular(event,this)">
					  <input id="conceptoh" name="conceptoh" type="hidden" value="<?php echo $_POST[conceptoh]?>" >
					</td>
			  </tr>
		
      
	  </table>
	  
<div class="subpantallac4" style="height:48.5%; width:99.6%; overflow-x:hidden;">
	   <table class="inicio">
	   	   <tr><td colspan="9" class="titulos">Detalle Gastos Bancarios</td></tr>                  
		<tr><td class="titulos2">CC</td><td class="titulos2">Doc Bancario</td><td class="titulos2">Cuenta Bancaria</td><td class="titulos2">Banco</td><td class="titulos2">Gasto Bancario</td><td class="titulos2">Valor</td><td class="titulos2">RP/Compromiso</td><td class="titulos2">Rubro</td><td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'><input type="hidden" id="comp" name="comp" value="<?php echo $_POST[comp]?>" ><input name="oculto" type="hidden" id="oculto" value="1" ></td></tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		 unset($_POST[dccs][$posi]);
		 unset($_POST[ddocban][$posi]);
		  unset($_POST[dbancos][$posi]);
		 unset($_POST[dnbancos][$posi]);
		 unset($_POST[dgbancarios][$posi]);	
		 unset($_POST[dngbancarios][$posi]);		 
 		 unset($_POST[dcbs][$posi]);	
 		 unset($_POST[dcts][$posi]);			 
		 unset($_POST[dvalores][$posi]);	
		 unset($_POST[drps][$posi]);			 
		 unset($_POST[drubros][$posi]);		  
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 $_POST[ddocban]= array_values($_POST[ddocban]);  
		 $_POST[dbancos]= array_values($_POST[dbancos]); 
  		 $_POST[dnbancos]= array_values($_POST[dnbancos]); 
		 $_POST[dgbancarios]= array_values($_POST[dgbancarios]); 
		 $_POST[dngbancarios]= array_values($_POST[dngbancarios]); 		 
		 $_POST[dcbs]= array_values($_POST[dcbs]); 		 
		 $_POST[dcts]= array_values($_POST[dcts]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 	
		 $_POST[drps]= array_values($_POST[drps]); 		 
		 $_POST[drubros]= array_values($_POST[drubros]); 	 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dccs][]=$_POST[cc];
		 $_POST[ddocban][]=$_POST[numero];			 
		 $_POST[dbancos][]=$_POST[banco];		 
		 $_POST[dnbancos][]=$_POST[nbanco];	
		 $_POST[dgbancarios][]=$_POST[gastobancario];		
		 $_POST[dngbancarios][]=$_POST[ngastobancario];				  
		 $_POST[dcbs][]=$_POST[cb];
		 $_POST[dcts][]=$_POST[ct];
		  $_POST[dvalores][]=$_POST[valor];
		  $_POST[drps][]=$_POST[rp];
		  $_POST[drubros][]=$_POST[rubros];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.banco.value="";
				document.form2.nbanco.value="";
				document.form2.cb.value="";
				document.form2.valor.value="";	
				document.form2.numero.value="";				
				document.form2.numero.select();
		  		document.form2.numero.focus();	
		 </script>
		  <?php
		  }
		  $_POST[totalc]=0;
		$iter='saludo1a';
		$iter2='saludo2';
		 for ($x=0;$x<count($_POST[dbancos]);$x++){		 
			echo "
			<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden'/>
			
			<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
		 		<td>
					<input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='4' readonly class='inpnovisibles'>
				</td>
				<td>
					<input name='ddocban[]' value='".$_POST[ddocban][$x]."' type='text' readonly class='inpnovisibles'>
				</td>
				<td>
					<input name='dcts[]' value='".$_POST[dcts][$x]."' type='hidden' >
					<input name='dbancos[]' value='".$_POST[dbancos][$x]."' type='hidden' >
					<input name='dcbs[]' value='".$_POST[dcbs][$x]."' type='text' size='45' readonly class='inpnovisibles'>
				</td>
				<td>
					<input name='dnbancos[]' value='".$_POST[dnbancos][$x]."' type='text' size='30' readonly class='inpnovisibles'>
				</td>
				<td>
					<input name='dngbancarios[]' value='".$_POST[dngbancarios][$x]."' type='text' size='50' readonly class='inpnovisibles'>
					<input name='dgbancarios[]' value='".$_POST[dgbancarios][$x]."' type='hidden' >
				</td>
				<td>".number_format($_POST[dvalores][$x],2,".",",")."</td>
				<td>
					<input name='drps[]' value='".$_POST[drps][$x]."' type='text' readonly class='inpnovisibles'>
				</td>
				<td>
					<input name='drubros[]' value='".$_POST[drubros][$x]."' type='text' readonly class='inpnovisibles'>
				</td>
				<td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
			</tr>";
		 	$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 	$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
		 }
 		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." Pesos";
		echo "<tr class='$iter' style='text-align:right;font-weight:bold;'>
			<td colspan='4'></td>
			<td>Total</td>
			<td>
				<input name='totalcf' type='hidden' value='$_POST[totalcf]'>
				<input name='totalc' type='hidden' value='$_POST[totalc]'>
				$_POST[totalcf]
			</td>
		</tr>
		<tr class='titulos2'>
			<td>Son:</td>
			<td colspan='8'>
				<input name='letras' type='hidden' value='$_POST[letras]' size='90'>
				$_POST[letras]
			</td>
		</tr>";
		?> 
		<input type="hidden" name="banban" id="banban" value="<?php echo $_POST[banban];?>"/>
	   </table></div>
	   
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	$p1=substr($_POST[fecha],0,2);
	$p2=substr($_POST[fecha],3,2);
	$p3=substr($_POST[fecha],6,4);
	$fechaf=$p3."-".$p2."-".$p1;	
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	if($bloq>=1)
	{
 	//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	//$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************	
//***busca el consecutivo del comprobante contable
	$consec=0;
//***cabecera comprobante
//echo $_POST[tipomovimientov]." - ".$_POST[tipomovimiento];
if ($_POST[tipomovimientov]=='201' and $_POST[tipomovimiento]=="201")
$esta=1;
if ($_POST[tipomovimientov]=='201' and $_POST[tipomovimiento]=="401")
$esta=0;
 $sqlr="delete from comprobante_cab where tipo_comp=9 and numerotipo=$_POST[idcomp] ";
	 mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($_POST[idcomp],9,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'$esta')";
	mysql_query($sqlr,$linkbd);
	
// $sqlr="update comprobante_cab set fecha='$fechaf',concepto='$_POST[concepto]',total=0,total_debito=$_POST[totalc],total_credito=$_POST[totalc],diferencia=0,estado='$esta' where tipo_comp=9 and numerotipo=$_POST[idcomp]";
	//mysql_query($sqlr,$linkbd);
//	$idcomp=mysql_insert_id();
//	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	 $sqlr="delete from comprobante_det where tipo_comp=9 and numerotipo=$_POST[idcomp] ";

	 mysql_query($sqlr,$linkbd);
	
//	echo "$sqlr <br>";
	
	for($x=0;$x<count($_POST[dccs]);$x++)
	 {	 
	 //** Busca  Gastos Bancarios ****
	$sqlr="select tesogastosbancarios_det.*,tesogastosbancarios.tipo from tesogastosbancarios_det,tesogastosbancarios where tesogastosbancarios_det.tipoconce='GB' and tesogastosbancarios_det.modulo='4' and tesogastosbancarios_det.codigo='".$_POST[dgbancarios][$x]."' and tesogastosbancarios_det.estado='S' and tesogastosbancarios_det.vigencia='$vigusu' and tesogastosbancarios_det.codigo=tesogastosbancarios.codigo";
//	echo "$sqlr";
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	//******Busca el concepto contable de los gastos bancarios
	$sq="select fechainicial from conceptoscontables_det where codigo='".$r[2]."' and modulo='4' and tipo='GB' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
	$re=mysql_query($sq,$linkbd);
	while($ro=mysql_fetch_assoc($re))
	{
		$_POST[fechacausa]=$ro["fechainicial"];
	}
	$sqlr="select * from conceptoscontables_det where conceptoscontables_det.codigo='".$r[2]."' and conceptoscontables_det.tipo='GB' and conceptoscontables_det.modulo='4' and conceptoscontables_det.cc='".$_POST[dccs][$x]."' and conceptoscontables_det.estado='S' and conceptoscontables_det.fechainicial='".$_POST[fechacausa]."'";
	//echo $sqlr;
	$res2=mysql_query($sqlr,$linkbd);
	while($r2=mysql_fetch_row($res2))
	 {
		 //*****SI ES DE GASTO *****
		 if($r[8]=='G')
		  {
	      //**** NOTA  BANCARIA DETALLE CONTABLE*****
		  if($r2[3]=='N')
		   {
			   if($r2[6]=='S')
			   {
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('9 $_POST[idcomp]','".$r2[4]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Doc Banco ".$_POST[ddocban][$x]."','',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
				//*** Cuenta BANCO **
				mysql_query($sqlr,$linkbd); 
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('9 $_POST[idcomp]','".$_POST[dbancos][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Doc Banco ".$_POST[ddocban][$x]."','','',".$_POST[dvalores][$x].",'1','".$vigusu."')";
				mysql_query($sqlr,$linkbd);
			   }
			   else
			   {
				   $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('9 $_POST[idcomp]','".$r2[4]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Doc Banco ".$_POST[ddocban][$x]."','',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
					//*** Cuenta BANCO **
					mysql_query($sqlr,$linkbd); 
					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('9 $_POST[idcomp]','".$_POST[dbancos][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Doc Banco ".$_POST[ddocban][$x]."','',".$_POST[dvalores][$x].",'','1','".$vigusu."')";
					mysql_query($sqlr,$linkbd);
			   }
		   }
		 }//*****FIN GASTO
		//*****SI ES DE INGRESO *****
		 if($r[8]=='I')
		  {
		  //**** NOTA  BANCARIA DETALLE CONTABLE*****
		  if($r2[3]=='N')
		   {
			$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('9 $_POST[idcomp]','".$r2[4]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Doc Banco ".$_POST[ddocban][$x]."','',0,".$_POST[dvalores][$x].",'1','".$_POST[vigencia]."')";
			//echo "$sqlr2 <br>";
			mysql_query($sqlr2,$linkbd);  
			//*** Cuenta BANCO **
			$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('9 $_POST[idcomp]','".$_POST[dbancos][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Doc Banco ".$_POST[ddocban][$x]."','',".$_POST[dvalores][$x].",0,'1','".$_POST[vigencia]."')";
			mysql_query($sqlr2,$linkbd);
		   }
		}//*****FIN INGRESO	  
	 }
	}
	}	
	//************ insercion de cabecera consignaciones ************
	if($_POST[tipomovimientov]=='201'and $_POST[tipomovimiento]=="201" )
	$sqlr="update tesonotasbancarias_cab set fecha='$fechaf',estado='$_POST[estadoc]',concepto='".$_POST[concepto]."' where id_notaban=$_POST[idcomp] ";	
	if($_POST[tipomovimientov]=='201'and $_POST[tipomovimiento]=="401" )
	{
	$sqlr="insert into tesonotasbancarias_cab (id_notaban,id_comp,fecha,vigencia,estado,concepto,tipo_mov,user) values($_POST[idcomp],0,'$fechaf',".$_POST[vigencia].",'N','".$_POST[concepto]."','401','".$_SESSION['nickusu']."')";	
	mysql_query($sqlr,$linkbd);
	$sqlr="update tesonotasbancarias_cab set estado='N' where id_notaban=$_POST[idcomp] and tipo_mov='201'";	
	mysql_query($sqlr,$linkbd);
	}
	//$idconsig=mysql_insert_id();
	//************** insercion de consignaciones **************
	$sqlr="select *from tesonotasbancarias_cab where id_notaban=$_POST[idcomp] and tipo_mov='201'";
	$resp=mysql_query($sqlr,$linkbd);
	$row=mysql_fetch_row($resp);
	$idconsig=$_POST[idcomp];
	//************** insercion de consignaciones **************
	 $sqlr="delete from tesonotasbancarias_det where id_notabancab='$idconsig'";
	 mysql_query($sqlr,$linkbd);
	//echo "$sqlr <br>";
	for($x=0;$x<count($_POST[dbancos]);$x++)
	 {
	$sqlr="insert into tesonotasbancarias_det(id_notabancab,fecha,docban,cc,ncuentaban,tercero,gastoban,cheque,valor,estado,rp,rubro) values($_POST[idcomp],'$fechaf','".$_POST[ddocban][$x]."','".$_POST[dccs][$x]."','".$_POST[dcbs][$x]."','".$_POST[dcts][$x]."','".$_POST[dgbancarios][$x]."','',".$_POST[dvalores][$x].",'S','".$_POST[drps][$x]."','".$_POST[drubros][$x]."')";	  
//echo "$sqlr <br>";
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurri� el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  		else
  		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Nota Bancaria con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php
		  }
	}	  
	 }
  else
   {
    echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
   }
  //****fin if bloqueo  
}
?>	
</form>
 </td></tr>
</table>