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
	}
	document.write('<td><img src="imagenes/'+imgmodulo+'" class="imgtitulos"></td><td><img src="imagenes/entidad.png" class="imgtitulos"></td>');
}
//FIN CARGA BARRA DE IMAGENES

//INICIO CARGA BARRA DE BOTONES
var b1a;var b2a;var b3a;var b4a;
var imbot1;var imbot2;var imbot3;var imbot4;
var vin1;var vin2;var vin3;var vin4;
var instr1;var instr2;var instr3;var instr4;

function barra_imgbotones(modulo)
{
	b1a="compact";b2a="compact";b3a="compact";b4a="compact";
	imbot1="imagenes/add.png";imbot2="imagenes/guardad.png";imbot3="imagenes/buscad.png";imbot4="imagenes/nv.png";
	vin1="href=\"#\"";vin2="";vin3="";vin4="href=\"#\"";
	instr1="";instr2="";instr3="";instr4="mypop=window.open(pagini,'','');mypop.focus();";
	switch(modulo)
	{
		case "inicio1":
			break;
		case "inicio2":
			instr1="cambiarwin(\"winguardar\");";imbot3="imagenes/busca.png";vin2="href=\"#\"";vin3="href=\"#\"";instr3="cambiarwin(\"winbuscar\");"
			break;
		case "informacion":
			imbot3="imagenes/busca.png";vin1="href=\"#\"";vin2="href=\"#\"";vin3="href=\"#\"";vin4="href=\"#\"";instr1="Mostrar_tabla('tablanuevo');Ocultar_tabla('tablamodificar');Ocultar_tabla('tablabuscar');Ocultar_tabla('tablarebuscar');";instr3="listado_informacion();";break;
		case "conta":
			break;
		case "contra":
			break;
		case "hum":
			break;
	}
	document.write('<tr><td colspan="3" class="cinta"><a id="bot1" '+vin1+' style="display:'+b1a+';margin-right:3px; " onClick='+instr1+'><img id="imbot1" src='+imbot1+' alt="Nuevo" border="0"/></a><a id="bot2" '+vin2+' style="display:'+b2a+';margin-right:3px;" onClick='+instr2+'><img id="imbot2" src='+imbot2+' alt="Guardar"/></a><a id="bot3" '+vin3+' style="display:'+b3a+';margin-right:3px;" onClick='+instr3+'><img id="imbot3" src='+imbot3+' alt="Buscar"/></a><a id="bot4" '+vin4+' style="display:'+b4a+';margin-right:3px;" onClick='+instr4+'><img id="imbot4" src='+imbot4+' alt="nueva ventana"></a></td></tr>');
}

function boton_cerrar()
{document.write('<td width="5%" class="cerrar" ><a href='+pagini+'>Cerrar</a></td>');}

//FIN CARGA BARRA DE BOTONES