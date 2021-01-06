function modiacentosjs(str){ 
	for (var i=0;i<str.length;i++)
	{ 
		if (str.charAt(i)=="á") str = str.replace(/á/,"\xe1"); 
		if (str.charAt(i)=="é") str = str.replace(/é/,"\xe9"); 
		if (str.charAt(i)=="í") str = str.replace(/í/,"\xed"); 
		if (str.charAt(i)=="ó") str = str.replace(/ó/,"\xf3"); 
		if (str.charAt(i)=="ú") str = str.replace(/ú/,"\xfa"); 
	} 
	alert(str);
return str; 
} 

function modiacentoshtml(str){ 
	for (var i=0;i<str.length;i++)
	{ 
		if (str.charAt(i)=="á") str = str.replace(/á/,"&aacute;"); 
		if (str.charAt(i)=="é") str = str.replace(/é/,"&eacute;"); 
		if (str.charAt(i)=="í") str = str.replace(/í/,"&iacute;"); 
		if (str.charAt(i)=="ó") str = str.replace(/ó/,"&oacute;"); 
		if (str.charAt(i)=="ú") str = str.replace(/ú/,"&uacute;"); 
	} //alert(str)
return str; 
} 

function fecha_corta(d)
{
	shortMonths=["Jan", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
	shortDays=["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"];
	//var d = new Date();
	var diab=d.getDate();
	var semb=d.getDay();
	var mesb=d.getMonth();
	var anob=d.getFullYear();
	return("  "+shortDays[semb]+",  "+diab+" - "+shortMonths[mesb]+" - "+anob);
}
function fecha_corta2(d)
{
	var diab=d.getDate();
	var mesb=d.getMonth();
	var anob=d.getFullYear();
	mesb=mesb+1;
	if (diab < 10)
		diab="0"+diab; 
	if (mesb < 10)
		mesb="0"+mesb; 
	return(diab+"/"+mesb+"/"+anob);
}
function fecha_sinformato(d)
{
	shortMonths=["Jan", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
	shortDays=["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"];
	//var d = new Date();
	var diab=d.getDate();
	var semb=d.getDay();
	var mesb=d.getMonth();
	var anob=d.getFullYear();
	mesb=mesb+1;
	return(anob+"/"+mesb+"/"+diab);
}
function hora_corta()
{
	var fechaHora = new Date();
	var horas = fechaHora.getHours();
	var horaso = horas;
	var minutos = fechaHora.getMinutes();
	var segundos = fechaHora.getSeconds();
	var horarad=document.getElementById("horarad");
	var horarado=document.getElementById("horarado");
	var sufijo = ' am';
	if(horas > 12) {horas = horas - 12;sufijo = ' pm';}
	if(horas < 10) { horas = '0' + horas; }
	if(minutos < 10) { minutos = '0' + minutos; }
	if(segundos < 10) { segundos = '0' + segundos; }
	horarad.value=("  "+horas+':'+minutos+':'+segundos+" "+sufijo);
	horarado.value=(horaso+':'+minutos+':'+segundos);
}
function sumadias(days)
			{
				var preubas = document.formraddoc.fechares;
				var preubaso = document.formraddoc.fechareso;
				milisegundos=parseInt(35*24*60*60*1000);
				fecha=new Date();
				day=fecha.getDate();
				month=fecha.getMonth()+1;
				year=fecha.getFullYear();
				tiempo=fecha.getTime();
				milisegundos=parseInt(days*24*60*60*1000);
				total=fecha.setTime(tiempo+milisegundos);
				day=fecha.getDate();
				month=fecha.getMonth()+1;
				year=fecha.getFullYear();
				fechaenv=(year+"/"+month+"/"+day);
				preubas.value=(day+"/"+month+"/"+year);
				preubaso.value=(year+"/"+month+"/"+day);
			}

function sumadiashabiles(preubas,preubaso,Rdays)
{
	var days=Rdays.substr(1);
	var tidays=Rdays.substr(0,1);
	var i=0;
	var daysf=0;
	milisegundos=parseInt(35*24*60*60*1000);
	fecha=new Date()
	day=fecha.getDate();
	month=fecha.getMonth()+1;
	year=fecha.getFullYear();
	tiempo=fecha.getTime();
	if (tidays=="H")
	{
		while (i<days)
		{
			daysf++;
			milisegundos=parseInt(daysf*24*60*60*1000);
			total=fecha.setTime(tiempo+milisegundos);
			if (fecha.getDay() != 6 && fecha.getDay() != 0){i++;}
		}
	}
	else
	{
		while (i<days)
		{
			daysf++;
			milisegundos=parseInt(daysf*24*60*60*1000);
			total=fecha.setTime(tiempo+milisegundos);
			i++;
		}
	}
	day=fecha.getDate();
	month=fecha.getMonth()+1;
	year=fecha.getFullYear();
	fechaenv=(year+"/"+month+"/"+day);
	preubas.value=fecha_corta2(fecha);
	preubaso.value=(year+"/"+month+"/"+day);
}

		
	