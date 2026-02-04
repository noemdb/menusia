<?php include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$cod_aplicacion='';} else {$cod_aplicacion=$_GET["Gaplicacion"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Eliminar Tipos de Aplicaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
function Llamar_Ventana(nombre){var f=document.form1;var url;
    url=nombre+f.txtCodigo_Aplicacion.value;   document.location = url;}
function revisar(){
var f=document.form1;
var Valido;
    if(f.txtCodigo_Aplicacion.value==""){alert("C�digo de Aplicaci�n no puede estar Vacio");return false;}
    if(f.txtNombre_Aplicacion.value==""){alert("Denominaci�n de Aplicaci�n no puede estar Vacia"); return false; }
       else{f.txtNombre_Aplicacion.value=f.txtNombre_Aplicacion.value.toUpperCase();} 
    if(f.txtCodigo_Aplicacion.value.length==1){f.txtCodigo_Aplicacion.value=f.txtCodigo_Aplicacion.value.toUpperCase();}
       else{alert("Longitud C�digo de Aplicaci�n Invalida");return false;}      
document.form1.submit;
return true;}
</script>
<?php 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$den_aplicacion="";$sql="Select * from PRE025 WHERE cod_aplicacion='$cod_aplicacion'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cod_aplicacion=$registro["cod_aplicacion"];
  $den_aplicacion=$registro["des_aplicacion"];}
?>
</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ELIMINAR TIPOS DE APLICACIONES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_tipo_aplica.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_tipo_aplica.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_a.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_a.php">Menu Archivo</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:335px; z-index:1; top: 67px; left: 112px;">
      <form name="form1" method="get" action="Delete_aplicacion.php" onSubmit="return revisar()">
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
                    <td width="148"><span class="Estilo5">C&Oacute;DIGO APLICACI&Oacute;N :</span></td>
                    <td width="650"><span class="Estilo5">
                      <input name="txtCodigo_Aplicacion" type="text" id="txtCodigo_Aplicacion" title="Registre el C&oacute;digo de la Fuente" value="<?php ECHO $cod_aplicacion?>" size="10" maxlength="1"  readonly>
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
                      <td width="666"><input name="txtNombre_Aplicacion" type="text" id="txtNombre_Aplicacion" title="Registre la denominaci&oacute;n de la Fuente"  readonly value="<?php ECHO $den_aplicacion?>" size="100" maxlength="200"></td>
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
            <td width="88" valign="middle"><input name="button" type="button" id="button"  value="Eliminar" onclick="Llamar_Ventana('Delete_aplicacion.php?Gaplicacion=')"></td>
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