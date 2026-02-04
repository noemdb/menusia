<?php include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){ $Doc_ajuste='';} else {$Doc_ajuste = $_GET["GDoc_ajuste"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Documentos Ajustes)</title>
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
    url="Delete_doc_ajuste.php?txtdoc_ajuste="+f.txtdoc_ajuste.value;  document.location = url;}
</script>

<?php 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="Select * from pre005 where tipo_ajuste='$Doc_ajuste'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$Doc_ajuste=$registro["tipo_ajuste"];$Nombre_doc_ajuste=$registro["nombre_tipo_ajuste"];
  $Nombre_Abrev=$registro["nombre_abrev_ajuste"];  $Refiera_a=$registro["refierea"];}
?>
</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DOCUMENTOS AJUSTES (Eliminar)</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_doc_ajuste.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="Act_doc_ajuste.php">Atras</A></td>
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
                                <input name="txtdoc_ajuste" id="txtdoc_ajuste" value="<?php ECHO $Doc_ajuste?>" size="10" readOnly>
                  </p>
                          </blockquote></td>
          </tr>
          <tr>
            <td height="49" colspan="3" valign="middle"><blockquote>
              <p align="left"><span class="Estilo5">NOMBRE DEL DOCUMENTO :</span>
                <input readOnly name="txtnombre_doc_ajuste" id="txtnombre_doc_ajuste" value="<?php ECHO $Nombre_doc_ajuste?>" size="80">
</p>
            </blockquote></td>
          </tr>
          <tr>
            <td width="380" height="43" valign="middle"><blockquote>
              <p><span class="Estilo5">NOMBRE ABREVIADO DOCUMENTO :</span>
                    <input readOnly name="txtnombre_abrev" id="txtnombre_abrev" value="<?php ECHO $Nombre_Abrev?>" size="6">
              </p>
            </blockquote></td>
            <td width="226" valign="middle"><span class="Estilo5">REFIERE A :
                <input readOnly name="txtRefierea" id="txtRefierea" value="<?php ECHO $Refiera_a?>" size="12">
            </span></td>
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
            <td width="88" valign="middle"><input name="button" type="button" id="button"  value="Eliminar" onclick="Llamar_Ventana('Delete_doc_ajuste.php')"></td>
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