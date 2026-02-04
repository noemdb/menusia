<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000040"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$cod_tipo_personal=""; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Actualiza Tabla de Grados y Pasos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function Cargar_pasos_grados(mform){var mcod_tipo_p; mcod_tipo_p=mform.txtcod_tipo_personal.value;
   ajaxSenddoc('GET', 'cargapasosgrados.php?cod_tipo_personal='+mcod_tipo_p, 'T11', 'innerHTML');
return true;}
function Llama_act_grados_pasos(){var url;var r;
  r=confirm("Desea Revisar la Tabla de Grados y Pasos  ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Revisar la Tabla de Grados y Pasos ?");
    if (r==true) { url="revisar_tabla_pasos_grado.php?";  VentanaCentrada(url,'Revisar la Tabla de Grados y Pasos ','','400','400','true');} }
   else { url="Cancelado, no asignado"; }
}
</script>
</head>
<body>
<table width="978" height="52" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">TABLA DE GRADOS Y PASOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="422" border="1" id="tablacuerpo">
   <tr>
    <td><table width="96" border="1" cellspacing="0">
      <tr>
        <td height="280"><table width="92" height="420" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
          <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
				onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_act_grados_pasos();" class="menu">Revisar Grados y Pasos</a></td>
		  </tr>
          <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
          </tr>
          <td >&nbsp;</td>
  </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="870">       <div id="Layer1" style="position:absolute; width:833px; height:248px; z-index:1; top: 73px; left: 121px;">
      <form name="form1" method="post" >
        <table width="868" border="0" align="center" >
          <tr>
            <td><table width="866">
                <tr>
				   <td width="140"><span class="Estilo5">TIPO DE PERSONAL : </span></td>
                   <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtcod_tipo_personal" type="text" id="txtcod_tipo_personal" size="6" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                   <td width="40"><input class="Estilo10" name="bttipo_per" type="button" id="bttipo_per" title="Abrir Catalogo Tipo de Personal"  onClick="VentanaCentrada('Cat_Tipo_personal.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="610"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_personal" type="text" id="txtdes_tipo_personal" size="95" maxlength="80" readonly ></span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
             <td><table width="866">
                 <tr>
                   <td width="650"><span class="Estilo5"> </span></td>
                   <td width="216"><span class="Estilo5"><input type="button" name="btcarga_asig" value="Cargar Grados y Pasos" title="Cargar Grados y Pasos del Tipo de Persnoal" onClick="javascript:Cargar_pasos_grados(this.form)" ></span></td>
                 </tr>
             </table></td>
           </tr>
        </table>
		<div id="T11" class="tab-body">
         <iframe src="Det_pasos_grado.php?Gcodigo=<?echo $cod_tipo_personal?>" width="850" height="340" scrolling="auto" frameborder="1"></iframe>
         </div>
       
      </form>
    </div>
</tr>
</table>
</body>
</html>