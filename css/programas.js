function solonumeros(e)
{

 var key;

 if(window.event) // IE
 {
  key = e.keyCode;
 }
  else if(e.which) // Netscape/Firefox/Opera
 {
  key = e.which;
 }

 if ((key < 48 || key > 57) && key !=46)
    {
      return false;
    }

 return true;
}

function solonumerossinpuntos(e)
{

 var key;

 if(window.event) // IE
 {
  key = e.keyCode;
 }
  else if(e.which) // Netscape/Firefox/Opera
 {
  key = e.which;
 }

 if (key < 48 || key > 57)
    {
      return false;
    }

 return true;
}

function tabular(e,obj)  
{ 
  tecla=(document.all) ? e.keyCode : e.which; 
            if(tecla!=13) return; 
            frm=obj.form; 
            for(i=0;i<frm.elements.length;i++)  
                if(frm.elements[i]==obj)  
                {  
                    if (i==frm.elements.length-1)  
                        i=-1; 
                    break  
                } 
    /*ACA ESTA EL CAMBIO disabled, Y PARA SALTEAR CAMPOS HIDDEN*/ 
            if ((frm.elements[i+1].disabled ==true) || (frm.elements[i+1].type=='hidden') )     
                tabular(e,frm.elements[i+1]); 
/*ACA ESTA EL CAMBIO readOnly */ 
            else if (frm.elements[i+1].readOnly ==true )     
                tabular(e,frm.elements[i+1]); 
            else { 
                if (frm.elements[i+1].type=='text') /*VALIDA SI EL CAMPO ES TEXTO*/ 
                { frm.elements[i+1].select(); };   /* AÑADIR LOS CORCHETES Y ESTA INSTRUCCION */ 
                frm.elements[i+1].focus(); 
            } 
            return false;  
}  
//****************************
//CODIGO DE VERIFICACION DIAN
function codigover()
{ 
 var vpri, x, y, z, i, nit1, dv1;
 nit1=document.form2.documento.value;
	if (isNaN(nit1))
	{
 	document.form2.codver.value="";
  //alert('El valor digitado no es un numero valido');		
	} else {
		if(document.form2.tipodoc.value=='31')
		{
  vpri = new Array(16); 
 	x=0 ; y=0 ; z=nit1.length ;
 	vpri[1]=3;
 	vpri[2]=7;
 	vpri[3]=13; 
 	vpri[4]=17;
 	vpri[5]=19;
 	vpri[6]=23;
 	vpri[7]=29;
 	vpri[8]=37;
 	vpri[9]=41;
 	vpri[10]=43;
 	vpri[11]=47;  
 	vpri[12]=53;  
 	vpri[13]=59; 
 	vpri[14]=67; 
 	vpri[15]=71;
  for(i=0 ; i<z ; i++)
 	{ 
 	 y=(nit1.substr(i,1));
 		//document.write(y+"x"+ vpri[z-i] +":");
   x+=(y*vpri[z-i]);
 		//document.write(x+"<br>");		
 	} 
  y=x%11
 	//document.write(y+"<br>");
  if (y > 1)
 	{
   dv1=11-y;
 	} else {
   dv1=y;
 	}
 	document.form2.codver.value=dv1;
	}
	else{ 	document.form2.codver.value="";}
	}
	
}

//VALIDADOR DE FECHAS

/**************************************************************
Máscara de entrada. Script creado por Tunait! (21/12/2004)
Si quieres usar este script en tu sitio eres libre de hacerlo con la condición de que permanezcan intactas estas líneas, osea, los créditos.
No autorizo a distribuír el código en sitios de script sin previa autorización
Si quieres distribuírlo, por favor, contacta conmigo.
Ver condiciones de uso en http://javascript.tunait.com/
tunait@yahoo.com 
****************************************************************/
var patron = new Array(2,2,4)
var patron2 = new Array(1,3,3,3,3)
function mascara(d,sep,pat,nums){
if(d.valant != d.value){
	val = d.value
	largo = val.length
	val = val.split(sep)
	val2 = ''
	for(r=0;r<val.length;r++){
		val2 += val[r]	
	}
	if(nums){
		for(z=0;z<val2.length;z++){
			if(isNaN(val2.charAt(z))){
				letra = new RegExp(val2.charAt(z),"g")
				val2 = val2.replace(letra,"")
			}
		}
	}
	val = ''
	val3 = new Array()
	for(s=0; s<pat.length; s++){
		val3[s] = val2.substring(0,pat[s])
		val2 = val2.substr(pat[s])
	}
	for(q=0;q<val3.length; q++){
		if(q ==0){
			val = val3[q]
		}
		else{
			if(val3[q] != ""){
				val += sep + val3[q]
				}
		}
	}
	d.value = val
	d.valant = val
	}
}

//**********comprobantes actualizar detalle
function llamarventana(e,posicion)
{
valoresp=document.getElementsByName('ddetalles[]');
valoractual=valoresp.item(posicion).value;
valor= prompt("Valor", ''+valoractual);
valoresp.item(posicion).value=valor;
}

function llamarventanadeb(e,posicion)
{
valoresp=document.getElementsByName('ddebitos[]');
valoractual=valoresp.item(posicion).value;
valor= prompt("Valor", ''+valoractual);
valoresp.item(posicion).value=valor;
recalcular();
}

function llamarventanacred(e,posicion)
{
valoresp=document.getElementsByName('dcreditos[]');
valoractual=valoresp.item(posicion).value;
valor= prompt("Valor", ''+valoractual);
valoresp.item(posicion).value=valor;
recalcular();
}
function recalcular()
{
 debs=0;
 creds=0;
 difs=0;
 valoresp=document.getElementsByName('ddebitos[]');
 valorcred=document.getElementsByName('dcreditos[]');
//  alert("qui");
 for (x=0;x<valoresp.length;x++)
  {
	 debs=debs+parseFloat(valoresp.item(x).value);
	 creds=creds+parseFloat(valorcred.item(x).value);	 
  }
  difs=debs-creds;
  document.form2.cuentadeb.value=debs;
  document.form2.cuentacred.value=creds; 
  document.form2.diferencia.value=difs;  
}

function redireccionar(pagina) 
{
//var pagina="http://www.yahoo.com"
location.href=pagina
setTimeout ("redireccionar()", 15000);
} 

function redirpdf(pagina,pdf) 
{
//var pagina="http://www.yahoo.com"
location.href=pagina
setTimeout ("redireccionar()", 15000);
} 

function llamarventanaegre(e,posicion)
{
	valoresp=document.getElementsByName('dvalores[]');
	valorocu=document.getElementsByName('dvaloresoc[]');
	//saldos=parseFloat(document.form2.saldorp.value);
	
	saldos=parseFloat(valorocu.item(posicion).value);
	valoractual=parseFloat(valoresp.item(posicion).value);
	valores= prompt("Ingrese el Valor: ", ''+valoractual);
	valores=parseFloat(valores);
	if(valores<=saldos && valores>=0)
	{
		totales=parseFloat(document.form2.totalc.value);	
		ntotal=parseFloat(totales)-parseFloat(valoractual)+parseFloat(valores);
		//if(ntotal<=saldos  && ntotal>=0)
		if(ntotal>=0)
 		{
			if(valores=='')
			{
				valoresp.item(posicion).value=0;
				recalcularegreso(); 	
			}
			else
			{
				valoresp.item(posicion).value=valores;
				recalcularegreso(); 	
 			}
 		}
 		else {alert(ntotal+" El valor supera el saldo");}
	}
	else {alert("El valor es invalido "+valores+"  sa:"+saldos);}
}

function recalcularegreso()
{
 	debs=0;
 	creds=0;
 	difs=0;
 	bases=document.getElementById("base").value;
 	regimenes=document.getElementById("regimen").value;
	//alert(regimenes);
	ivas=document.getElementById("iva").value;
	anteriores=document.getElementById("sumarbase").value;

 	cuentas=document.getElementsByName('dcuentas[]');
  	valoresp=document.getElementsByName('dvalores[]');
 	checkb=document.getElementsByName('rubros[]');
	//  alert("qui"+valoresp.length);
 	//for (y=0;y<checkb.length;y++)
  	{
  		for (x=0;x<valoresp.length;x++)
  		{	  
			//   alert("bd: "+valoresp.item(x).value+"  cd:"+checkb.item(x).value)
   			if(true==checkb.item(x).checked )
    		{
				debs=debs+parseFloat(valoresp.item(x).value);
				//alert("debs: "+valoresp.item(x).value)
				// creds=creds+parseFloat(valorcred.item(x).value);	 
			}
		}
  	}
  	//difs=debs-creds;
	//  alert("base: ".debs)
  	if(regimenes==1){
		document.getElementById("iva").value=Math.round(debs-(debs/(1.19)));	
		iva2=anteriores-(anteriores/1.19);	   
		document.getElementById("iva").value=parseInt(document.getElementById("iva").value)+parseInt(iva2);
  	}	
	else {
		document.getElementById("iva").value=0;	
	}
	
	//alert("A: "+anteriores+" B: "+debs+" I: "+document.getElementById("iva").value);
	document.getElementById("base").value=debs-parseInt(document.getElementById("iva").value)+parseInt(anteriores);	
	//alert("qsssui"+debs);
    document.form2.totalcf.value=debs;
    document.form2.valor.value=debs;
	//document.form2.base.value=debs;
	document.form2.submit();
  	//document.form2.cuentacred.value=creds; 
  	//document.form2.diferencia.value=difs;  
}
                 
//Código para colocar 
//los indicadores de miles mientras se escribe
//script por tunait!
function puntitos(donde,caracter)
	{
	pat = /[\*,\+,\(,\),\?,\,$,\[,\],\^]/;
	valor = donde.value;
	largo = valor.length;
	crtr = true
	if(isNaN(caracter) || pat.test(caracter) == true)
	 {
		if (pat.test(caracter)==true)
		{ 
		 caracter= "\\" +caracter;
		}
		caracter = new RegExp(caracter,"g");
		valor = valor.replace(caracter,"")
		donde.value = valor
		crtr = false
	}
	else{
		var nums = new Array()
		cont = 0
		for(m=0;m<largo;m++){
			if(valor.charAt(m) == "." || valor.charAt(m) == " ")
				{continue;}
			else{
				nums[cont] = valor.charAt(m)
				cont++
			}
		}
	}
	var cad1=""
	cad2=""
	tres=0
	if(largo > 3 && crtr == true){
		for (k=nums.length-1;k>=0;k--){
			cad1 = nums[k]
			cad2 = cad1 + cad2
			tres++
			if((tres%3) == 0){
				if(k!=0){
					cad2 = "." + cad2
				}
			}
		}
		donde.value = cad2
	}
}	

//**********quitar puntos cdp rp validaciones
function quitarpuntos(valorpuntos)
 {
	//alert('v:'+valorpuntos);
	//valorpuntos=valorpuntos.replace(".","");
largo=valorpuntos.length;
//alert('L:'+largo);
cont=0;
//numero = valorpuntos.split(" ");
//alert('L2:'+numero.charAt(2));
//largo2=numero.length;
//alert('L2:'+largo2);
for(m=0;m<largo;m++)
	{
		if(valorpuntos.charAt(m)>=0)
		  {
		//alert('C:'+valorpuntos.charAt(m));
		//definitivo[cont]=valorpuntos.charAt(m);	
		//  cont+=1;
		  }
		  else
		  {
			valorpuntos=valorpuntos.replace(".","");  
			}
			}
for(m=0;m<largo;m++)
	{
		if(valorpuntos.charAt(m)>=0)
		  {
		//alert('C:'+valorpuntos.charAt(m));
		//definitivo[cont]=valorpuntos.charAt(m);	
		//  cont+=1;
		  }
		  else
		  {
			valorpuntos=valorpuntos.replace(",",".");  
			}
			}						
		//	alert('v2:'+valorpuntos);
//definitivo=numero.join("");
//alert('N:'+definitivo);
return valorpuntos; 
 }

/*****************************************************************************
Código para colocar los indicadores de miles  y decimales mientras se escribe
Script creado por Tunait!
Si quieres usar este script en tu sitio eres libre de hacerlo con la condición de que permanezcan intactas estas líneas, osea, los créditos.

http://javascript.tunait.com
tunait@yahoo.com  27/Julio/03
******************************************************************************/
function puntitos2(donde,caracter,campo)
{
var decimales = true
dec = campo
pat = /[\*,\+,\(,\),\?,\\,\$,\[,\],\^]/
valor = donde.value
largo = valor.length
crtr = true
if(isNaN(caracter) || pat.test(caracter) == true)
	{
	if (pat.test(caracter)==true) 
		{caracter = "\\" + caracter}
	carcter = new RegExp(caracter,"g")
	valor = valor.replace(carcter,"")
	donde.value = valor
	crtr = false
	}
else
	{
	var nums = new Array()
	cont = 0
	for(m=0;m<largo;m++)
		{
		if(valor.charAt(m) == "." || valor.charAt(m) == " " || valor.charAt(m) == ",")
			{continue;}
		else{
			nums[cont] = valor.charAt(m)
			cont++
			}
		
		}
	}

if(decimales == true) {
	ctdd = eval(1 + dec);
	nmrs = 1
	}
else {
	ctdd = 1; nmrs = 3
	}
var cad1="",cad2="",cad3="",tres=0
if(largo > nmrs && crtr == true)
	{
	for (k=nums.length-ctdd;k>=0;k--){
		cad1 = nums[k]
		cad2 = cad1 + cad2
		tres++
		if((tres%3) == 0){
			if(k!=0){
				cad2 = "." + cad2
				}
			}
		}
		
	for (dd = dec; dd > 0; dd--)	
	{cad3 += nums[nums.length-dd] }
	if(decimales == true)
	{cad2 += "," + cad3}
	 donde.value = cad2
	}
donde.focus()
}	
//Creo una función que imprimira en la hoja el valor del porcentanje asi como el relleno de la barra de progreso

//INICIO CARGA BARRA DE IMAGENES
function barra_imagenes(modulo)
{
	var imgmodulo;
	switch(modulo)
	{
		case "plan":
			imgmodulo="logoplan.png";break;
		case "acti":
			imgmodulo="logoacti.png";break;
		case "adm":
			imgmodulo="logoadmin.png";break;
		case "cont":
			imgmodulo="logoconta.png";break;
		case "contra":
			imgmodulo="logocontra.png";break;
		case "hum":
			imgmodulo="logohum.png";break;
		case "presu":
			imgmodulo="logopresu.png";break;
		case "inve":
			imgmodulo="logoalma.png";break;
		case "meci":
			imgmodulo="logomeci.png";break;
		case "serv":
			imgmodulo="logoserv.png";break;
		case "teso":
			imgmodulo="logoteso.png";break;
		case "ccpet":
			imgmodulo="logoccpet.png";break;
		case "ayuda":
			imgmodulo="logoayuda.png";break;
	}
	document.write('<td  style="background:url(imagenes/'+imgmodulo+'); background-repeat:no-repeat; background-position:center; background-size: 100% 95%;height:50px; width:33%;border-radius:4px;"></td>');
}
//FIN CARGA BARRA DE IMAGENES

//INICIO CARGA BARRA DE BOTONES
var b1a;var b2a;var b3a;var b4a;
var imbot1;var imbot2;var imbot3;var imbot4;
var vin1;var vin2;var vin3;var vin4;
var instr1;var instr2;var instr3;var instr4;

function barra_imgbotones(modulo)
{
	b1a="compact";b2a="compact";b3a="compact";b4a="compact";b5a="none";
	imbot1="imagenes/add.png";imbot2="imagenes/guardad.png";imbot3="imagenes/buscad.png";imbot4="imagenes/nv.png";imbot5="imagenes/print_off.png";
	vin1="href=\"#\"";vin2="";vin3="";vin4="href=\"#\"";vin5="href=\"#\"";
	clase="mgbt";
	instr1="";instr2="";instr3="";instr4="mypop=window.open(pagini,'','');mypop.focus();";instr5="";
	switch(modulo)
	{
		case "inicio1":
		imbot3="imagenes/busca.png";vin3="href=\"plan-agendabusca.php\"";
			break;
		case "inicio2":
			instr1="cambiarwin(\"winguardar\");";imbot3="imagenes/busca.png";vin2="href=\"#\"";vin3="href=\"#\"";instr3="cambiarwin(\"winbuscar\");"
			break;
		case "inicio3":
			b5a="compact";instr1="cambiarwin(\"winguardar\");";imbot3="imagenes/busca.png";vin2="href=\"#\"";vin3="href=\"#\"";instr3="cambiarwin(\"winbuscar\");"
			break;
		case "informacion":
			imbot3="imagenes/busca.png";vin1="href=\"#\"";vin2="href=\"#\"";vin3="href=\"#\"";vin4="href=\"#\"";instr1="Mostrar_tabla('tablanuevo');Ocultar_tabla('tablamodificar');Ocultar_tabla('tablabuscar');Ocultar_tabla('tablarebuscar');";instr3="listado_informacion();";break;
		case "eventos":
			instr1="Mostrar_tabla('tablanuevo');Ocultar_tabla('tablabuscar');Ocultar_tabla('tablarebuscar');"; vin3="href=\"#\""; imbot3="imagenes/busca.png"; instr3="document.formulario3.submit();";instr4="mypop=window.open('plan-principal.php','','');mypop.focus();";
			break;
		case "conta":
			break;
		case "contra":
			break;
		case "hum":
			break;
	}
	document.write('<tr><td colspan="3" class="cinta"><a id="bot1" '+vin1+' style="display:'+b1a+';margin-right:3px;" onClick='+instr1+' class="mgbt"><img id="imbot1" src='+imbot1+' alt="Nuevo" border="0"/></a><a id="bot2" '+vin2+' style="display:'+b2a+';margin-right:3px;" onClick='+instr2+' class="mgbt"><img id="imbot2" src='+imbot2+' alt="Guardar"/></a><a id="bot3" '+vin3+' style="display:'+b3a+';margin-right:3px;" onClick='+instr3+' class="mgbt"><img id="imbot3" src='+imbot3+' title="Buscar"/></a><a id="bot4" '+vin4+' style="display:'+b4a+';margin-right:3px;" onClick='+instr4+' class="mgbt"><img id="imbot4" src='+imbot4+' title="nueva ventana"></a><a id="bot5" '+vin5+' style="display:'+b5a+';margin-right:3px;" onClick='+instr5+' class="mgbt"><img id="imbot5" src='+imbot5+' title="nueva ventana"></a></td></tr>');
}

function boton_cerrar()
{document.write('<td width="5%" class="cerrar" ><a href='+pagini+'>Cerrar</a></td>');}

//FIN CARGA BARRA DE BOTONES

function despliegamodalmen(_valor)//Funcion para desplegar alertas y mensajes
{
	document.getElementById("bgmodalmensajes").style.visibility=_valor;
	if (_valor=="hidden"){document.getElementById('todastablas2').innerHTML=""}
}

function validateEnter(e) 
{
	var key=e.keyCode || e.which;
	if (key==13){ return true; } else { return false; }
}
function abriratajo(cod)
{
	var direccion=document.URL;
	var pos1 = direccion.indexOf("codpag");
	var ultimochar=direccion.substr(direccion.length-1,direccion.length); 
	if(ultimochar!= '#'){var ndireccion=direccion}
	else{var ndireccion = direccion.substring(0, direccion.length-1);}
	var pos2 = ndireccion.indexOf("?");
	if(pos2!= -1){var irnuevadir=ndireccion+"&codpag="+cod;}
	else {var irnuevadir =ndireccion+"?codpag="+cod;}
	document.location.href=irnuevadir;
}
function direccionacjs()
{
	var direcc="http://servidor/financiero/";
	return direcc;	
}
function cambionum()
{
	document.getElementById('numres').value=document.getElementById('renumres').value;
	document.getElementById('nummul').value=0;
	document.getElementById('numpos').value=0;
	document.getElementById('oculto').value=2;
	document.form2.submit(); 
}
function numsiguiente()
{
	document.getElementById('nummul').value=parseInt(document.getElementById('nummul').value)+1;
	document.getElementById('numpos').value=parseInt(document.getElementById('numres').value)*parseInt(document.getElementById('nummul').value);
	document.getElementById('oculto').value=2;
	document.form2.submit(); 
}
function numanterior()
{
	document.getElementById('nummul').value=parseInt(document.getElementById('nummul').value)-1;
	document.getElementById('numpos').value=parseInt(document.getElementById('numres').value)*parseInt(document.getElementById('nummul').value);
	document.getElementById('oculto').value=2;
	document.form2.submit(); 
}
function saltocol(pag)
{
	document.getElementById('nummul').value=parseInt(pag)-1;
	document.getElementById('numpos').value=parseInt(document.getElementById('numres').value)*parseInt(document.getElementById('nummul').value);
	document.getElementById('oculto').value=2;
	document.form2.submit();
}
function limbusquedas()
{
	document.getElementById('numpos').value=0;
	document.getElementById('nummul').value=0;
	document.form2.submit();
}
function validate_fechaMayorQue(fechaInicial,fechaFinal)
{
	valuesStart=fechaInicial.split("/");
	valuesEnd=fechaFinal.split("/");
	var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
	var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
	if(dateStart>=dateEnd){return 0;}
	return 1;
}
var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
  num +='';
  var splitStr = num.split('.');
  var splitLeft = splitStr[0];
  var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
  var regx = /(\d+)(\d{3})/;
  while (regx.test(splitLeft)) {
  splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
  }
  return this.simbol + splitLeft  +splitRight;
 },
 new:function(num, simbol){
  this.simbol = simbol ||'';
  return this.formatear(num);
 }
}
function sinpuntitos(_val1,_val2)
  {
	  numeropc=document.getElementById(''+_val2).value.replace(/[$.]/g, '');
	  document.getElementById(''+_val1).value=numeropc.replace(',', '.');
  }
  function sinpuntitos2(_val1,_val2)
  {
	  document.getElementById(''+_val1).value=document.getElementById(''+_val2).value.replace(/[$,]/g, '');
  }
   function sinpuntitos3(_val1,_val2,cadecimal)
  {
	  if(cadecimal==".")  {document.getElementById(''+_val1).value=document.getElementById(''+_val2).value.replace(/[$,]/g, '');}
	  else {document.getElementById(''+_val1).value=document.getElementById(''+_val2).value.replace(/[$.]/g, '');}
  }
 function cambiocheckbox(nomobj){if (document.getElementById(''+nomobj).checked){document.getElementById(''+nomobj).value="1"}}
 function cambiocheckbox2(nomobj,nomdes)
 {
	var divnomdes = nomdes.split("-");
	if (document.getElementById(''+nomobj).checked){document.getElementById(''+nomobj).value="1";}
	for (x=0;x<divnomdes.length;x++)
	{
		document.getElementById(''+divnomdes[x]).checked=false;
		document.getElementById(''+divnomdes[x]).value="0";
	}
	 
 }
 function detallesdocradi(id, radicado, tipor)
 {
	if($('#detalle'+id).css('display')=='none')
	{
		$('#detalle'+id).css('display','block');
		$('#img'+id).attr('src','imagenes/minus.gif');
	}
	else
	{
		$('#detalle'+id).css('display','none');
		$('#img'+id).attr('src','imagenes/plus.gif');
	}
	var toLoad= 'plan-acdetallesdocradi.php';
	$.post(toLoad,{radicado:radicado,tipor:tipor},function (data){
		$('#detalle'+id).html(data.detalle);
		return false;
	},'json');
 }
function cambio_paginas(dir) {window.location.replace(dir)}
function existeFecha(fecha)
{
      var fechaf = fecha.split("/");
      var day = fechaf[0];
      var month = fechaf[1];
      var year = fechaf[2];
      var date = new Date(year,month,'0');
      if((day-0)>(date.getDate()-0)){return false;}
      return true;
}