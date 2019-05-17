<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){
  $Doc_pago='';
} else {
  $Doc_pago = $_GET["GDoc_pago"];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Documentos Pagos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
function Llamar_Ventana(nombre){var f=document.form1;var url;
    url="Delete_doc_pago.php?txtdoc_pago="+f.txtdoc_pago.value;    document.location = url;}
</script>

<?
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="Select * from pre004 where tipo_pago='$Doc_pago'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $Doc_pago=$registro["tipo_pago"]; $Nombre_doc_pago=$registro["nombre_tipo_pago"];
  $Nombre_Abrev=$registro["nombre_abrev_pago"]; $Refiera_a=$registro["refierea"]; $Afecta_Presup=$registro["afecta_presup"];}
?>
</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DOCUMENTOS PAGOS (Eliminar)</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_doc_pago.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_doc_pago.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:338px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post"  onSubmit="return revisar()">
        <p>&nbsp;</p>
        <table width="859" height="199" border="0" id="tabcampos">
          <tr>
            <td height="49" colspan="3" valign="middle"><blockquote>
              <p class="Estilo5">C&Oacute;DIGO :
                                <input name="txtdoc_pago" id="txtdoc_pago" value="<?ECHO $Doc_pago?>" size="10" readOnly>
                  </p>
                          </blockquote></td>
          </tr>
          <tr>
            <td height="49" colspan="3" valign="middle"><blockquote>
              <p align="left"><span class="Estilo5">NOMBRE DEL DOCUMENTO :</span>
                <input readOnly name="txtnombre_doc_pago" id="txtnombre_doc_pago" value="<?ECHO $Nombre_doc_pago?>" size="80">
</p>
            </blockquote></td>
          </tr>
          <tr>
            <td width="380" height="43" valign="middle"><blockquote>
              <p><span class="Estilo5">NOMBRE ABREVIADO DOCUMENTO :</span>
                    <input readOnly name="txtnombre_abrev" id="txtnombre_abrev" value="<?ECHO $Nombre_Abrev?>" size="6">
              </p>
            </blockquote></td>
            <td width="226" valign="middle"><span class="Estilo5">REFIERE A :
                <input readOnly name="txtRefierea" id="txtRefierea" value="<?ECHO $Refiera_a?>" size="12">
            </span></td>
            <td width="239" valign="middle"><span class="Estilo5">AFECTA PRESUPUESTO:</span><span class="Estilo5">
              <input readOnly name="TxtAfecta" id="TxtAfecta" value="<?ECHO $Afecta_Presup?>" size="4">
            </span> </td>
          </tr>
          <tr>
            <td height="48" colspan="3" valign="middle">&nbsp;</td>
          </tr>
        </table>
        <div align="center">
          <p>&nbsp;</p>
          </div>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="button" id="button"  value="Eliminar" onclick="Llamar_Ventana('Delete_doc_pago.php')"></td>
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