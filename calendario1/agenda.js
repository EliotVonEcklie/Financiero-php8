function pasarfecha()
{
	var fecha=document.getElementById('fecha');
	var mfecha=document.getElementById('nfecha');
	mfecha.innerHTML= fecha.value;
}
function fecha_actual()
{
	shortMonths=["Jan", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
	longMonths=["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
	shortDays=["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"];
	longDays =["Domingo", "Lunes", "Martes", "Mi&eacute;rcoles", "Jueves", "Viernes", "S&aacute;bado"];
	var d = new Date();
	var diab=d.getDate();
	var semb=d.getDay();
	var mesb=d.getMonth();
	var anob=d.getFullYear();
	var mfecha=document.getElementById('nfecha');
	mfecha.innerHTML=(longDays[semb]+"<br>"+shortMonths[mesb]+" "+diab+", "+anob);
}
function genera_tabla() {
  // Obtener la referencia del elemento body
  	var body= document.getElementById('calendario');
 	//var body = document.getElementsByTagName("body")[0];
  	var nids=0;	 
	var nhoras=7;
	for(var k =0; k <17; k++)
	{		
		// Crea un elemento <table> y un elemento <tbody>
 	 	var tabla   = document.createElement("table");
  		var tblBody = document.createElement("tbody"); 
		var cuartosH=0;
		var atid="";
  		// Crea las celdas
	  for (var i = 0; i < 4; i++) 
	  {
		// Crea las hileras de la tabla
		var hilera = document.createElement("tr");
		if(i==0)
		{
			var celda1 = document.createElement("td");
			nhoras++;
			if (nhoras<13){var textoCelda = document.createTextNode(nhoras+"am");}
			else{var rhoras=nhoras-12;var textoCelda = document.createTextNode(rhoras+"pm");}
			celda1.setAttribute("rowspan", "6");
			celda1.appendChild(textoCelda);
			celda1.setAttribute("class","choras");	
			hilera.appendChild(celda1);
		}
			for (var j = 0; j < 2; j++) {
			  // Crea un elemento <td> y un nodo de texto, haz que el nodo de
			  // texto sea el contenido de <td>, ubica el elemento <td> al final
			  // de la hilera de la tabla
				var celda = document.createElement("td");
				if(j==0)
			  	{
					nids++;
					if(cuartosH==0){ var textoCelda = document.createTextNode(":00");atid=nhoras+":00:00";}
					else{var textoCelda = document.createTextNode(":"+cuartosH);atid=nhoras+":"+cuartosH+":00";}
					celda.setAttribute("class","cminutos");	
					cuartosH=cuartosH +15;
				}
				else
				{
					celda.setAttribute("id",atid);
					var textoCelda = document.createTextNode("");
					celda.setAttribute("class","cmensaje");	
					celda.setAttribute("onClick","ventanaNueva()");
					var textoCelda1 = document.createTextNode(atid);
					celda.appendChild(textoCelda1);
				}
			  	celda.appendChild(textoCelda);
			  	hilera.appendChild(celda);
			}
			// agrega la hilera al final de la tabla (al final del elemento tblbody)
			tblBody.appendChild(hilera);
	  	}
	  	// posiciona el <tbody> debajo del elemento <table>
		tabla.appendChild(tblBody);
	 	 // appends <table> into <body>
		body.appendChild(tabla);
		// modifica el atributo "border" de la tabla y lo fija a "2";
		tabla.setAttribute("border", "1");
		tabla.setAttribute("class","tmensajes");
		tblBody.setAttribute("margin","0");
	}
}
function generar_listasi()
{
	var conid=0;
	var nhoras=7;
	var choraf=0;
	var ampm=0;
	var horaimp=0;
	var convalor=0;
	for ( var i=0; i<17; i++)
	{
		var cuartosH=0;
		nhoras++;
		if (nhoras<13){ampm="am";horaimp=nhoras;}
		else{ampm="pm";horaimp=nhoras -12;}
		for(var j=0; j<4; j++)
		{	
			var body= document.getElementById('listahorasi');
			var lishoras   = document.createElement("option");
			conid="n"+conid;
			if (cuartosH==0){choraf= horaimp +":00"+ampm;convalor=nhoras +":00";}
			else{choraf= horaimp +":"+cuartosH+ampm;convalor=nhoras +":"+cuartosH;}
			lishoras.setAttribute("value",convalor);
			lishoras.setAttribute("id",conid);
			lishoras.innerHTML=choraf;
			body.appendChild(lishoras);
			cuartosH=cuartosH +15;
		}
	}
}

function generar_listasf()
{
	var conid=0;
	var nhoras=7;
	var choraf=0;
	var ampm=0;
	var horaimp=0;
	var convalor=0;
	for ( var i=0; i<17; i++)
	{
		var cuartosH=0;
		nhoras++;
		if (nhoras<13){ampm="am";horaimp=nhoras;}
		else{ampm="pm";horaimp=nhoras -12;}
		for(var j=0; j<4; j++)
		{	
			var body= document.getElementById('listahorasf');
			var lishoras   = document.createElement("option");
			conid="nhf"+conid;
			if (cuartosH==0){choraf= horaimp +":00"+ampm;convalor=nhoras +":00";}
			else{choraf= horaimp +":"+cuartosH+ampm;convalor=nhoras +":"+cuartosH;}
			lishoras.setAttribute("value",convalor);
			lishoras.setAttribute("id",conid);
			lishoras.innerHTML=choraf;
			body.appendChild(lishoras);
			cuartosH=cuartosH +15;
		}
	}
}
function malertas()
{
	alert("para otra cosa");
}

function ventanaNueva(nomid)
{ 
	var contengr=document.getElementById(nomid);
 	var contengr2=contengr.innerHTML;
 	if (contengr2 == "")
 	{
 		window.open('calendario1/mensajes.php?fecha='+document.form2.fecha.value+'&'+'horaini='+nomid,'nuevaVentana',"toolbar=no,toolbar=no, location=no, scrollbars=no, resizable=no, width=400, height=450, top=170, left=450");	
	}
	else
	{
		window.open('calendario1/mensajes-actualizar.php?fecha='+document.form2.fecha.value+'&'+'horaini='+nomid,'nuevaVentana',"toolbar=no,toolbar=no, location=no, scrollbars=no, resizable=no, width=400, height=450, top=170, left=450");
	}
}
/*
 document.write('<IFRAME src="calendario1/mensajes.php?fecha='+document.form2.fecha.value+'" name="otras" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME> <p><a href="javascript:despliegamodal(\'2\',\'hidden\');">Cerrar ventana</a></p>');
				//?fecha='+document.form2.fecha.value+'&'+'horaini='+nomid
                </script>*/
function comparar_horas()
{
	var horai= document.getElementById(listahorasi);
	var horaf=document.getElementById(listahorasf);
	var K=horai.value;
	var j=horaf.value;
	if (k>j){alertafechas();}
}
function alertafechas()
{
	alert("Intentando unir Ventana de almacenamiento con la base");
}
function dia_semana(fecha){    
    fecha=fecha.split('/');   
    if(fecha.length!=3){   
            return null;   
    }   
    //Vector para calcular día de la semana de un año regular.   
    var regular =[0,3,3,6,1,4,6,2,5,0,3,5];    
    //Vector para calcular día de la semana de un año bisiesto.   
    var bisiesto=[0,3,4,0,2,5,0,3,6,1,4,6];    
    //Vector para hacer la traducción de resultado en día de la semana.   
    var semana=['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];   
    //Día especificado en la fecha recibida por parametro.   
    var dia=fecha[0];   
    //Módulo acumulado del mes especificado en la fecha recibida por parametro.   
    var mes=fecha[1]-1;   
    //Año especificado por la fecha recibida por parametros.   
    var anno=fecha[2];   
    //Comparación para saber si el año recibido es bisiesto.   
    if((anno % 4 == 0) && !(anno % 100 == 0 && anno % 400 != 0))   
        mes=bisiesto[mes];   
    else  
        mes=regular[mes];   
    //Se retorna el resultado del calculo del día de la semana.   
    return semana[Math.ceil(Math.ceil(Math.ceil((anno-1)%7)+Math.ceil((Math.floor((anno-1)/4)-Math.floor((3*(Math.floor((anno-1)/100)+1))/4))%7)+mes+dia%7)%7)];   
}  
