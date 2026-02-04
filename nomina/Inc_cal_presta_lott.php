<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");   $fecha_hoy=asigna_fecha_hoy();  $fecha_tope="30/04/2012"; 
if (!$_GET){$criterio="";} else{$criterio=$_GET["Gcriterio"];}  $cod_empleado=$criterio;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Calculo de Prestaciones LOTT)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="javascript" src="../class/cal2.js"></script>
<script language="javascript" src="../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
var patronfecha = new Array(2,2,4);
function Llamar_Ventana(url){var murl;   document.location = url;}
function revisar(){var f=document.form1;
    if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txtFechad.value==""){alert("Fecha de Calculo no puede  estar Vacia"); return false; }
document.form1.submit;
return true;}
function Calcula_presta(){var f=document.form1;  var r; var murl;
    if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txtFechad.value==""){alert("Fecha de Calculo no puede  estar Vacia"); return false; }
    r=confirm("Desea Calcular las Prestaciones  ?");
    if(r==true){murl='Insert_calculo_presta_lott.php?codigo_d='+f.txtcod_empleado.value+'&codigo_h='+f.txtcod_empleado.value+'&tipod='+f.txttipo_nomina.value+'&tipoh='+f.txttipo_nomina.value+'&fechah='+f.txtFechad.value; murl='llamacalprestalott.php?codigo='+f.txtcod_empleado.value+'&fechah='+f.txtFechad.value; document.location = murl;}
document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select cod_empleado,nombre,cedula,fecha_ingreso,tipo_nomina FROM NOM006 where (cod_empleado='$cod_empleado')"; $res=pg_query($sql);$filas=pg_num_rows($res);
$nombre=""; $cedula=""; $fecha_ingreso=""; $tipo_nomina="00"; if($filas>=1){ $registro=pg_fetch_array($res,0);
$nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $tipo_nomina=$registro["tipo_nomina"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso); $cod_empleado=$registro["cod_empleado"];  }
pg_close(); $fecha_hoy=colocar_udiames($fecha_hoy); 
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR CALCULO DE PRESTACIONES LOTT</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Act_cal_prest_lott.php?Gcodigo=C<?echo $cod_empleado?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Ventana('Act_cal_prest_lott.php?Gcodigo=C<?echo $cod_empleado?>');">Atras</a></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr>
   </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post" action="Insert_calculo_presta_lott.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
          <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR  : </span></td>
                   <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_empleado?>" > </span></td>
                   <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trabajadores.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="550"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="80" maxlength="80" readonly value="<?echo $nombre?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">FECHA CALCULO HASTA :</span></td>
                 <td width="730"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" onkeyup="mascara(this,'/',patronfecha,true)">
				  <img src="../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha" onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  />
				 </span></td>
               </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
                  <td width="200"><input class="Estilo10" name="txttipo_nomina" type="hidden" id="txttipo_nomina" value="<?echo $tipo_nomina?>"></td>
                  <td width="200" align="center"><input name="btprocesar" type="button" id="btprocesar" title="Procesar Calculo" onclick="javascript:Calcula_presta()" value="Procesar Calculo"></td>
                  <td width="59">&nbsp;</td>
                  <td width="200"><input name="Blanquear" type="reset" value="Blanquear"></td>
                  <td width="200">&nbsp;</td>
                </tr>
          </table>
        </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>