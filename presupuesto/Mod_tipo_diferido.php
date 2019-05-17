<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$tipo_diferido='';} else {$tipo_diferido=$_GET["Gtipo_diferido"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Modificar Tipos de Diferidos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function revisar(){var f=document.form1;var Valido;
    if(f.txttipo_diferido.value==""){alert("Tipo de Diferido no puede estar Vacio");return false;}
    if(f.txtnombre_tipo_dife.value==""){alert("Descripción Tipo de Diferido no puede estar Vacia"); return false; }
       else{f.txtnombre_tipo_dife.value=f.txtnombre_tipo_dife.value.toUpperCase();}
	if(f.txtnombre_abrev.value==""){alert("Nombre Abreviado del Tipo de Diferido no puede estar Vacio");return false; }
       else{f.txtnombre_abrev.value=f.txtnombre_abrev.value.toUpperCase();}   
    if(f.txttipo_diferido.value.length==4){f.txttipo_diferido.value=f.txttipo_diferido.value.toUpperCase();}
       else{alert("Longitud Código de Aplicación Invalida");return false;}
document.form1.submit;
return true;}
function chequea_codigo(mform){var mref;
   mref=mform.txttipo_diferido.value;   mref = Rellenarizq(mref,"0",4);   mform.txttipo_diferido.value=mref;
return true;}
</script>

</head>
<?
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$den_aplicacion="";$sql="Select * from pre024 WHERE tipo_diferido='$tipo_diferido'";  $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $nombre_tipo_dife=$registro["nombre_tipo_dife"];  $nombre_abrev=$registro["nombre_abrev_dife"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR TIPOS DE DIFERIDOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_tipo_diferido.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_tipo_diferido.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:335px; z-index:1; top: 67px; left: 112px;">
      <form name="form1" method="post" action="Update_tipo_dif.php" onSubmit="return revisar()">
        <table width="865" border="0">
          <tr>
            <td><table width="825" height="235" border="0" align="center" id="tabcampos">
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="800" border="0">
                  <tr>
                    <td width="148"><span class="Estilo5">TIPO DE DIFERIDO :</span></td>
                    <td width="650"><span class="Estilo5"><input class="Estilo10" name="txttipo_diferido" type="text" id="txttipo_diferido" title="Registre el C&oacute;digo del tipo de diferido" size="10" maxlength="4"  readonly onFocus="encender(this); " onBlur="apagar(this);" value="<?ECHO $tipo_diferido?>">
                    </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>
                  <table width="816" border="0">
                    <tr>
                      <td width="148"><span class="Estilo5">DENSCRIPCION :</span></td>
                      <td width="666"><input class="Estilo10" name="txtnombre_tipo_dife" type="text" id="txtnombre_tipo_dife" title="Registre la descripción del tipo de diferido" size="100" maxlength="200"  onFocus="encender(this)" onBlur="apagar(this)" value="<?ECHO $nombre_tipo_dife?>"></td>
                    </tr>
                  </table>                  </td>
              </tr>

              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="800" border="0">
                  <tr>
                    <td width="148"><span class="Estilo5">NOMBRE ABREVIADO :</span></td>
                    <td width="650"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev" type="text" id="txtnombre_abrev" title="Registre el nombre abreviado del tipo de diferido" size="10" maxlength="4"  onFocus="encender(this); " onBlur="apagar(this);" value="<?ECHO $nombre_abrev?>">
                    </span></td>
                  </tr>
                </table>                <p class="Estilo5">&nbsp;
</p></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp; </td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88">&nbsp;</td>
          </tr>
        </table>
        <div align="right"></div>
        <div align="right"></div>
        <p>&nbsp;</p>
        </form>
    </div>

  </tr>
</table>
</body>
</html>
<? pg_close();?>
