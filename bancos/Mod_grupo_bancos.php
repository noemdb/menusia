<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
if (!$_GET){$cod_grupob=''; $sql="SELECT * FROM ban022 ORDER BY cod_grupob";} else{$cod_grupob=$_GET["Gcod_grupob"]; $sql="Select * from ban022 where cod_grupob='$cod_grupob'";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Grupos de Bancos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
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
function revisar(){var f=document.form1;
  if(f.txtcodigo_grupo.value==""){alert("Codigo no puede estar Vacio");return false;}else{f.txtcodigo_grupo.value=f.txtcodigo_grupo.value.toUpperCase();}
  if(f.txtdenominacion.value==""){alert("Denominacion no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
  document.form1.submit;
return true;}
</script>

</head>
<?
$des_cod_grupob="";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $cod_grupob=$registro["cod_grupob"]; $nombre_grupob=$registro["nombre_grupob"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR GRUPOS DE BANCOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="365" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Grupo_Bancos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_Grupo_Bancos.php">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr> <td>&nbsp;</td></tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>      <div id="Layer1" style="position:absolute; width:851px; height:350px; z-index:1; top: 71px; left: 130px;">
            <form name="form1" method="post" action="Update_grupo_bancos.php" onSubmit="return revisar()">
              <table width="860" height="76" border="0" align="center" >
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td><table width="850" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="180"><span class="Estilo5">C&Oacute;DIGO DE GRUPO :</span></td>
                      <td width="670"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_grupo" type="text"  id="txtcodigo_grupo"  value="<?echo $cod_grupob?>"  size="5" maxlength="3" readonly>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td><table width="850" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="180"><span class="Estilo5">DENOMINACI&Oacute;N DEL GRUPO : </span></td>
                      <td width="670"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion" type="text"  id="txtdenominacion"  onFocus="encender(this)" onBlur="apagar(this)" size="100" maxlength="150" value="<?echo $nombre_grupob?>" >
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
              </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
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
</body>
</html>
<? pg_close();?>