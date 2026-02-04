<?php include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$cod_parroquia='';} else {$cod_parroquia=$_GET["Gcod_parroquia"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Modificar Parroquias)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
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
function revisar(){
var f=document.form1;
var Valido;
    if(f.txtCodigo_Parroquia.value==""){alert("C�digo de la Parroquia no puede estar Vacio");return false;}
    if(f.txtNombre_Parroquia.value==""){alert("Nombre de la Parroquia no puede estar Vacia"); return false; }
       else{f.txtNombre_Parroquia.value=f.txtNombre_Parroquia.value.toUpperCase();}
    if(f.txtCodigo_Parroquia.value.length==6){f.txtCodigo_Parroquia.value=f.txtCodigo_Parroquia.value.toUpperCase();}
       else{alert("Longitud C�digo de la Parroquia Invalida");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
-->
</style>
<?php 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$den_parroquia="";$sql="Select cod_parroquia,nombre_parroquia from PRE096 where cod_parroquia='$cod_parroquia'";
$res=pg_query($sql); if ($registro=pg_fetch_array($res,0)){  $cod_parroquia=$registro["cod_parroquia"];  $den_parroquia=$registro["nombre_parroquia"];}
?>
</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR PARROQUIAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_parroquias.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_parroquias.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:335px; z-index:1; top: 67px; left: 112px;">
      <form name="form1" method="post" action="Update_parroquia.php" onSubmit="return revisar()">
        <table width="865" border="0">
          <tr>
            <td><table width="825" height="231" border="0" align="center" id="tabcampos">
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td><table width="800" border="0">
                  <tr>
                    <td width="148"><span class="Estilo5">C&Oacute;DIGO :</span></td>
                    <td width="650"><span class="Estilo5">
                      <input name="txtCodigo_Parroquia" type="text" id="txtCodigo_Parroquia" title="Registre el C&oacute;digo de la Parroquia" size="10" maxlength="6"  readonly value="<?php ECHO $cod_parroquia?>">
                    </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="14">&nbsp;</td>
              </tr>
              <tr>
                <td>
                  <table width="816" border="0">
                    <tr>
                      <td width="148"><span class="Estilo5">NOMBRE :</span></td>
                      <td width="666"><input name="txtNombre_Parroquia" type="text" id="txtNombre_Parroquia" title="Registre el Nombre de la Parroquia" size="100" maxlength="200"  value="<?php ECHO $den_parroquia?>" onFocus="encender(this)" onBlur="apagar(this)"></td>
                    </tr>
                  </table>                  </td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
            </table>
            </td>
          </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
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
<?php  pg_close($conn);?>