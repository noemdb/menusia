<?include ("../class/conect.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME"); if (!$_GET){$codigo_ubicacion="";} else{$codigo_ubicacion=$_GET["codigo"];} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL N&Oacute;MINA Y PERSONAL (Modificar Definici&oacute;n de Ubicaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
function revisar(){
var f=document.form1;
    if(f.txtcodigo_ubicacion.value==""){alert("Codigo de Ubicacion no puede estar Vacio");return false;}  else{f.txtcodigo_ubicacion.value=f.txtcodigo_ubicacion.value.toUpperCase();}
    if(f.txtdescripcion_ubi.value==""){alert("Descripcion de Ubicacion no puede estar Vacia"); return false;}  else{f.txtdescripcion_ubi.value=f.txtdescripcion_ubi.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * FROM NOM058 where codigo_ubicacion='$codigo_ubicacion'"; $res=pg_query($sql);$filas=pg_num_rows($res);
$descripcion_ubi="";
If($registro=pg_fetch_array($res,0)){$codigo_ubicacion=$registro["codigo_ubicacion"]; $descripcion_ubi=$registro["descripcion_ubi"]; }
pg_close();
?>
</head>
<body>
<table width="978" height="52" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR DEFINICI&Oacute;N DE UBICACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>

<table width="978" height="288" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="285"><table width="92" height="285" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_ubi_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_ubi_ar.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu </A></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="870">       <div id="Layer1" style="position:absolute; width:833px; height:248px; z-index:1; top: 83px; left: 121px;">
      <form name="form1" method="post" action="Update_ubicacion.php" onSubmit="return revisar()">
        <table width="868" border="0" align="center" >
          <tr>
            <td><table width="866">
                <tr>
                  <td width="204" ><span class="Estilo5">C&Oacute;DIGO UBICACION : </span></td>
                  <td width="660" ><span class="Estilo5"> <input class="Estilo10" name="txtcodigo_ubicacion" type="text" id="txtcodigo_ubicacion" size="15" maxlength="10"  readonly value="<?echo $codigo_ubicacion?>"  > </span></td>
                </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
          <tr>
             <td><table width="866">
               <tr>
                 <td width="205" ><span class="Estilo5">DESCRIPCI&Oacute;N DE LA UBICACI&Oacute;N : </span></td>
                 <td width="660" ><span class="Estilo5"><textarea name="txtdescripcion_ubi" cols="70" maxlength="100" class="Estilo10" id="txtdescripcion_ubi" onFocus="encender(this)" onBlur="apagar(this)" ><?echo $descripcion_ubi?></textarea></span></td>
               </tr>
             </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
          <tr> <td>&nbsp;</td> </tr>
        </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
            </form>
      </div>
    </td>
</tr>
</table>
<p>&nbsp;</p>
</body>
</html>