<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$cod_fuente='';} else {$cod_fuente=$_GET["Gfuente"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Modificar Fuentes de Financiamiento)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type="text/javascript"></SCRIPT>
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
function revisar(){var f=document.form1; var Valido;
    if(f.txtCodigo_Fuente.value==""){alert("Código de Fuente no puede estar Vacio");return false;}
    if(f.txtNombre_Fuente.value==""){alert("Denominación de Fuente no puede estar Vacia"); return false; }
       else{f.txtNombre_Fuente.value=f.txtNombre_Fuente.value.toUpperCase();} 
    if(f.txtCodigo_Fuente.value.length==2){f.txtCodigo_Fuente.value=f.txtCodigo_Fuente.value.toUpperCase();}
       else{alert("Longitud Código de Fuente Invalida");return false;}      
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
-->
</style>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $den_fuente="";
$sql="Select cod_fuente_financ,des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $cod_fuente=$registro["cod_fuente_financ"];  $den_fuente=$registro["des_fuente_financ"];}
?>
</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR FUENTES DE FINANCIAMIENTO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_fuentes.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_fuentes.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:335px; z-index:1; top: 67px; left: 112px;">
      <form name="form1" method="post" action="Update_fuente.php" onSubmit="return revisar()">
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
                    <td width="148"><span class="Estilo5">C&Oacute;DIGO DE FUENTE :</span></td>
                    <td width="650"><span class="Estilo5">
                      <input name="txtCodigo_Fuente" type="text" id="txtCodigo_Fuente" title="Registre el C&oacute;digo de la Fuente" size="10" maxlength="2"  readonly value="<?echo $cod_fuente?>">
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
                      <td width="148"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                      <td width="666"><input name="txtNombre_Fuente" type="text" id="txtNombre_Fuente" title="Registre la denominaci&oacute;n de la Fuente" size="100" maxlength="200"  value="<?ECHO $den_fuente?>" onFocus="encender(this)" onBlur="apagar(this)"></td>
                    </tr>
                  </table>                  </td>
              </tr>

              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><p class="Estilo5">&nbsp;
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