<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "encrip.inc";
require"funciones.inc";
sesion();
$_SESSION["usuario"] ;
$_SESSION["perfil"] ;
$_SESSION["linkset"] ;
   date_default_timezone_set("America/Bogota");
?>
<html>
<head>


<style>
.fc_main { background: #DDDDDD; border: 1px solid #000000; font-family: Verdana; font-size: 10px; }
.fc_date { border: 1px solid #D9D9D9;  cursor:pointer; font-size: 10px; text-align: center;}
.fc_dateHover, TD.fc_date:hover { cursor:pointer; border-top: 1px solid #FFFFFF; border-left: 1px solid #FFFFFF; border-right: 1px solid #999999; border-bottom: 1px solid #999999; background: #E7E7E7; font-size: 10px; text-align: center; }
.fc_wk {font-family: Verdana; font-size: 10px; text-align: center;font-weight: bold;}
.fc_wknd { color: #FF0000; font-weight: bold; font-size: 10px; text-align: center;}
.fc_head { background: #000066; color: #F7E39C; font-weight:bold; text-align: left;  font-size: 11px; }
</style>




<script>

var coldColor = "#FFCC00"
var hotColor  = "#ffffff"
var motionPix = "0"

// do not edit below this line
// ======================================

var a='<style>'+
'A.InstantLink:link {'+
'  color:'+coldColor+';'+
'  text-decoration:none;'+
'  padding:0 '+motionPix+' 0 0;'+
'  }'+  
'A.InstantLink:visited {'+
'  color:'+coldColor+';'+
'  text-decoration:none;'+
'  padding:0 '+motionPix+' 0 0;}'+  
'A.InstantLink:active {'+
'  color:'+coldColor+';'+
'  text-decoration:none;'+
'  padding:0 '+motionPix+' 0 0;'+
'  }'+  
'A.InstantLink:hover {'+
'  color:'+hotColor+';'+
'  padding:0 0 0 '+motionPix+';'+
'  }'+
'</style>'
if (document.all || document.getElementById){
    document.write(a)
}
</script>

<style>
<!--

.menuskin{
position:absolute;
width:165px;
background-color:#FFdd66;
border:1px solid black;
font:normal 12px Verdana;
line-height:18px;
z-index:100;
visibility:hidden;
}

.menuskin a{
text-decoration:none;
background-color:#FFdd66;
color:black;
padding-left:10px;
padding-right:10px;
}

#mouseoverstyle{
font-size:12px;
background-color:#FFdd66;
color:#FFFFFF;
}

#mouseoverstyle a{
color:white;
}
-->
</style>

<script language="JavaScript1.2">

//Pop-it menu- By Dynamic Drive
//For full source code and more DHTML scripts, visit http://www.dynamicdrive.com
//This credit MUST stay intact for use

var linksets=new Array()
var linkset2=new Array()
linksets= '<?php echo $_SESSION[linkset][0]; ?>'
linkset2[0]=linksets
linksets= '<?php echo $_SESSION[linkset][1]; ?>'
linkset2[1]=linksets
linksets= '<?php echo $_SESSION[linkset][2]; ?>'
linkset2[2]=linksets
linksets= '<?php echo $_SESSION[linkset][3]; ?>'
linkset2[3]=linksets
linksets= '<?php echo $_SESSION[linkset][4]; ?>'
linkset2[4]=linksets

////No need to edit beyond here

var ie4=document.all&&navigator.userAgent.indexOf("Opera")==-1
var ns6=document.getElementById&&!document.all
var ns4=document.layers

function showmenu(e,which){

if (!document.all&&!document.getElementById&&!document.layers)
return

clearhidemenu()

menuobj=ie4? document.all.popmenu : ns6? document.getElementById("popmenu") : ns4? document.popmenu : ""
menuobj.thestyle=(ie4||ns6)? menuobj.style : menuobj

if (ie4||ns6)
menuobj.innerHTML=which
else{
menuobj.document.write('<layer name=gui bgColor=#E6E6E6 width=165 onmouseover="clearhidemenu()" onmouseout="hidemenu()">'+which+'</layer>')
menuobj.document.close()
}

menuobj.contentwidth=(ie4||ns6)? menuobj.offsetWidth : menuobj.document.gui.document.width
menuobj.contentheight=(ie4||ns6)? menuobj.offsetHeight : menuobj.document.gui.document.height
eventX=ie4? event.clientX : ns6? e.clientX : e.x
eventY=ie4? event.clientY : ns6? e.clientY : e.y

//Find out how close the mouse is to the corner of the window
var rightedge=ie4? document.body.clientWidth-eventX : window.innerWidth-eventX
var bottomedge=ie4? document.body.clientHeight-eventY : window.innerHeight-eventY

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<menuobj.contentwidth)
//move the horizontal position of the menu to the left by it's width
menuobj.thestyle.left=ie4? document.body.scrollLeft+eventX-menuobj.contentwidth : ns6? window.pageXOffset+eventX-menuobj.contentwidth : eventX-menuobj.contentwidth
else
//position the horizontal position of the menu where the mouse was clicked
menuobj.thestyle.left=ie4? document.body.scrollLeft+eventX : ns6? window.pageXOffset+eventX : eventX

//same concept with the vertical position
if (bottomedge<menuobj.contentheight)
menuobj.thestyle.top=ie4? document.body.scrollTop+eventY-menuobj.contentheight : ns6? window.pageYOffset+eventY-menuobj.contentheight : eventY-menuobj.contentheight
else
menuobj.thestyle.top=ie4? document.body.scrollTop+event.clientY : ns6? window.pageYOffset+eventY : eventY
menuobj.thestyle.visibility="visible"
return false
}

function contains_ns6(a, b) {
//Determines if 1 element in contained in another- by Brainjar.com
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}

function hidemenu(){
if (window.menuobj)
menuobj.thestyle.visibility=(ie4||ns6)? "hidden" : "hide"
}

function dynamichide(e){
if (ie4&&!menuobj.contains(e.toElement))
hidemenu()
else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
hidemenu()
}

function delayhidemenu(){
if (ie4||ns6||ns4)
delayhide=setTimeout("hidemenu()",500)
}

function clearhidemenu(){

if (window.delayhide)
clearTimeout(delayhide)
}

function highlightmenu(e,state){
if (document.all)
source_el=event.srcElement
else if (document.getElementById)
source_el=e.target
if (source_el.className=="menuitems"){
source_el.id=(state=="on")? "mouseoverstyle" : ""
}
else{
while(source_el.id!="popmenu"){
source_el=document.getElementById? source_el.parentNode : source_el.parentElement
if (source_el.className=="menuitems"){
source_el.id=(state=="on")? "mouseoverstyle" : ""
}
}
}
}

if (ie4||ns6)
document.onclick=hidemenu

</script>

<title>SAIC - ASOLLANOS Ltda</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo2 {color: #000066}
.Estilo3 {color: #FF9900}
.Estilo10 {
	color: #FFCC33;
	font-weight: bold;
}
body {
	margin-left: 2px;
	margin-top: 0px;
	margin-right: 2px;
}
.Estilo14 {
	font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
}
.Estilo15 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFCC00;
}
.Estilo16 {color: #000063}
.Estilo17 {color: #FFFFFF}
.Estilo20 {color: #FF9900; font-family: Verdana, Arial, Helvetica, sans-serif;}
.Estilo21 {color: #FFFFFF; font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif;}
.Estilo37 {color: #FFCF00}
a:link {
	color: #00006B;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #00006B;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
.Estilo5 {	font-size: x-small;
	color: #FF9900;
}
.Estilo38 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo39 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000066;
}
.Estilo60 {
	font-size: 12;
	font-weight: bold;
}
.Estilo66 {
	font-size: 12px;
	color: #000066;
}
.Estilo67 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: bold;
}
.Estilo69 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo71 {font-size: 12px; color: #666666; }
.Estilo72 {font-size: 10px}
.Estilo74 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; color: #000066;}
-->
</style>
<?php titlepag();?>
</head>

<body>
<div id="popmenu" class="menuskin" onMouseover="clearhidemenu();highlightmenu(event,'on')" onMouseout="highlightmenu(event,'off');dynamichide(event)">
</div>
<table width="100%" height="746" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr bordercolor="#FFFFFF" bgcolor="#CCCCCC">
    <td width="51%" height="106" rowspan="5" bgcolor="#FFFFFF"><img src="imagenes/Logo-web.png" width="448" height="100"></td>
    <td width="27%" rowspan="5" bgcolor="#FFFFFF"><img src="imagenes/saic2.png" width="250" height="63"></td>
    <td width="22%" height="14" bordercolor="#CCCCCC" bgcolor="#bbbbbb" class="Estilo72"><strong><span class="Estilo20">:<span class="Estilo3">&middot;</span> <span class="Estilo2">Usuario: </span></span></strong><span class="Estilo21"><?php echo $_SESSION[usuario]; ?></span></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td height="13" bordercolor="#CCCCCC" bgcolor="#bbbbbb">
	<span class="Estilo72"><strong><span class="Estilo20">:<span class="Estilo3">&middot;</span> <span class="Estilo2">Perfil: </span></span></strong><span class="Estilo21"><?php echo $_SESSION[perfil]; ?></span></span> </td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td height="13" bordercolor="#CCCCCC" bgcolor="#bbbbbb"><span class="Estilo72"><strong><span class="Estilo20">:<span class="Estilo3">&middot;</span></span></strong><span class="Estilo20"><span class="Estilo3"><strong> <span class="Estilo2">Hora de Ingreso</span></strong></span><span class="Estilo74">: </span></span><span class="Estilo21">
      <?php $fecha = time (); 
echo date ( "h:i:s" , $fecha ); ?>
    </span></span></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td height="11" bordercolor="#CCCCCC" bgcolor="#BDBABD"><div align="center"><span class="Estilo1 Estilo7"><strong><span class="Estilo5"></span></strong></span></div></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td height="34" bordercolor="#CCCCCC" bgcolor="#FFFFFF"><div align="center"><span class="Estilo1 Estilo7"><strong><span class="Estilo5"><span class="Estilo69">Desarrollado por:</span> <strong><img src="imagenes/ingelsisltda.gif" width="130" height="20" align="absmiddle"></strong></span></strong></span></div></td>
  </tr>
  <tr>
  <td height="40" colspan="3" background="imagenes/barra-menu.png">
   <span class="Estilo10"> <span class="Estilo16">[</span> <span class="Estilo14">.:</span> <span class="Estilo15">
  <a class="InstantLink" href="#" onMouseover="showmenu(event,linkset2[0])" onMouseout="delayhidemenu()">Administracion </a>
<span class="Estilo17">-</span><a class="InstantLink" href="#" onMouseover="showmenu(event,linkset2[1])" onMouseout="delayhidemenu()"> Atencion Clientes </a>
<span class="Estilo17">-</span><a class="InstantLink" href="#" onMouseover="showmenu(event,linkset2[2])" onMouseout="delayhidemenu()"> Reportes </a><span class="Estilo17">-</span> 
<a class="InstantLink" href="#" onMouseover="showmenu(event,linkset2[3])" onMouseout="delayhidemenu()">Herramientas </a><span class="Estilo17">-</span> 
<a class="InstantLink" href="#" onMouseover="showmenu(event,linkset2[4])" onMouseout="delayhidemenu()">Ayuda</a> 
<span class="Estilo17">&middot; <span class="Estilo37"><a class="InstantLink" href="index.php">Salir</a></span> :. </span></span></span>
</td>
  </tr>
  <tr valign="bottom" bgcolor="#F7E39C">
    <td height="27" colspan="3"><span class="Estilo39">:: Administracion :&middot; Usuarios :&middot; Ver/Editar </span></td>
  </tr>
  <tr valign="middle" bgcolor="#FFFFFF">
    <td height="50" colspan="3"><a href="addusuario.php"><img src="imagenes/add.png" alt="Agregar" width="50" height="50" border="0" align="absmiddle"></a> <a href="#" style="cursor:auto" onClick="document.form1.submit()"><img  src="imagenes/guarda.png" alt="Guardar" width="50" height="50" border="0" align="absmiddle" > </a><a href="usuarios.php"><img src="imagenes/busca.png" alt="Buscar" width="50" height="50" border="0" align="absmiddle"></a> </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
   <td colspan="3"><p>&nbsp;</p>
<?php
if ($_POST[oculto]=="")
 {
  $linkbd=conectar();
  $sqlr="select *from usuarios where id_usu=$_GET[r]";
  $resp=oci_parse($linkbd,$sqlr);
  oci_execute($resp);
  $fila = oci_fetch_array($resp,OCI_BOTH);
  $cod=$fila[0];
  $nombre=$fila[1];
  $cc=$fila[2];
  $dire=$fila[3];
  $usu=$fila[4];
$usu=desencrip($usu);
  $pass=$fila[5];
$pass=desencrip($pass);
  $est=$fila[6];
  $codrol=$fila[7];
  oci_close($linkbd);
 ?>
<form name="form1" method="post" action="">
  <table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
    <tr bgcolor="#F7E39C">
      <td height="25" colspan="2"><span class="Estilo8 Estilo38 Estilo60"><span class="Estilo8 Estilo38 Estilo66">:: Informacion Usuario </span></span></td>
    </tr>
    <tr bgcolor="#DDDDDD">
      <td><span class="Estilo39"><span class="Estilo8 Estilo38 Estilo60"><span class="Estilo8 Estilo38 Estilo66">:&middot;</span></span> Nombres: 
          <input name="nombre" type="text" id="nombre" size="45" value="<?php echo $nombre ?>" readonly>
</span></td>
      <td><span class="Estilo39"><span class="Estilo8 Estilo38 Estilo60"><span class="Estilo8 Estilo38 Estilo66">:&middot;</span></span> CC:
          <input name="cc" type="text" id="cc" value="<?php echo $cc ?>" size="15">
      </span></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <td width="529" bgcolor="#CCCCCC"><span class="Estilo39"><span class="Estilo8 Estilo38 Estilo60"><span class="Estilo8 Estilo38 Estilo66">:&middot;</span></span> Direccion:
          <input name="dire" type="text" id="dire" size="45" value="<?php echo $dire ?>">
      </span></td>
      <td width="305">&nbsp;</td>
    </tr>
    <tr bgcolor="#dddddd">
      <td colspan="2" bgcolor="#dddddd"><div align="left"><span class="Estilo39"><span class="Estilo8 Estilo38 Estilo60"><span class="Estilo8 Estilo38 Estilo66">:&middot;</span></span>  Usuario:
                <input name="user" type="text" id="user" value="<?php echo $usu ?>" size="15" readonly>
          </span><span class="Estilo39"><span class="Estilo8 Estilo38 Estilo60"><span class="Estilo8 Estilo38 Estilo66">:&middot;</span></span> Contrase&ntilde;a:
          <input name="contra2" type="password" id="valor22" value="<?php echo $pass ?>" size="15">
        </span></div></td>
      </tr>
    <tr bgcolor="#DDDDDD">
      <td bgcolor="#CCCCCC"><span class="Estilo39"><span class="Estilo8 Estilo38 Estilo60"><span class="Estilo8 Estilo38 Estilo66">:&middot;</span></span> Perfil:
<select name="rol" id="select">
		  <?php
			 $linkbd=conectar();
			 $sqlr="select * from roles order by nom_rol";
			 $resp=oci_parse($linkbd,$sqlr);
			 oci_execute($resp);
			echo "<option value=''>Seleccione Rol</OPTION>";
		    while($fila=oci_fetch_array ($resp, OCI_BOTH))
			 {
			 $i=$fila[0];
   			 $nar=$fila[1];
			 echo "<option value=$fila[0] ";
			 if($i==$codrol)
			 {
			 echo "SELECTED";
			 $nam=$fila[1];
			 }
			 echo ">".$fila[1]."</OPTION>";
			 }
			 oci_close($linkbd);	
			?>
          </select>
      </span></td>
      <td><span class="Estilo39"><span class="Estilo8 Estilo38 Estilo60"><span class="Estilo8 Estilo38 Estilo66">:&middot;</span></span> Estado:
<select name="estado" >
                    <option value="1"
				<?php if ($est==1)
					 echo " SELECTED";?> >Activo</option>
                    <option value="0"
				<?php if ($est==0)
					 echo " SELECTED";?> >Inactivo</option>
              </select>  
          <input name="codigo" type="hidden" id="codigo" value="<?php echo $cod ?>">
</span></td>
    </tr>
    <tr bgcolor="#DDDDDD">
      <th colspan="2"><span class="Estilo5 Estilo6 Estilo67">
        <input name="oculto" type="hidden" id="oculto" value="1">
        <span class="Estilo71">(Click en el Icono de Guardar para almacenar)</span></span></th>
    </tr>
  </table>
  <div align="center"></div>
</form>
<?php
}
$oculto=$_POST['oculto'];
if($oculto!="")
{
$_POST['oculto']="";
$linkbd=conectar();
//inicio de la actualizacion
$usuario=$_POST['user'];
$contra2=$_POST['contra2'];
if (($contra2!="") && ($usuario!=""))
{
 $nuser=encripta($usuario);
 $npass=encripta($contra2);
 $sqlr="update usuarios set nom_usu='$_POST[nombre]',cc_usu='$_POST[cc]',dir_usu='$_POST[dire]',log_usu='$nuser', cla_usu='$npass',est_usu=$_POST[estado],id_rol=$_POST[rol] where id_usu=$_POST[codigo]";
 $respquery=oci_parse($linkbd,$sqlr);
  if (!oci_execute($respquery))
	{
	 echo "<center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1>Por Ingelsis</font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	 $e = oci_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 echo htmlentities($e['message']);
  	 echo "<pre>";
     echo htmlentities($e['sqltext']);
     printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center>";
  	 exit;
	}
 else
 {
 echo "<center><h2>Se ha Actualizado con Exito</h2></center>";
 }
oci_free_statement($statement);
oci_close($linkdb);
}
else
{
 echo "<center><h2>FALTAN DATOS PARA PODER ACTUALIZAR</h2></center>";
}
}
?>
    
  </td>
  </tr>
</table>
</body>
</html>
