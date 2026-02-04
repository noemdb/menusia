<?php include ("../class/conect.php");  include ("../class/funciones.php");
if ($_GET["GUsuario"]!=""){$login=$_GET["GUsuario"];} else{$login='';}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONFIGURACI&Oacute;N Y MANTENIMIENTO (Asignar Partidas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
</head>
<?php
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
 else{  $sql="Select * from SIA001 WHERE campo101='$login'";   $res=pg_query($sql);
  if($registro=pg_fetch_array($res,0)){ $nombre=$registro["campo104"];  $cargo=$registro["campo105"]; $departamento=$registro["campo106"];
      $cat_prog=$registro["campo107"]; $cod_almacen=$registro["campo108"]; $unidad_sol=$registro["campo111"];} }
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ASIGNAR PARTIDAS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="470" border="1">
  <tr>
    <td width="92"><table width="93" height="463" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('usuarios.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="usuarios.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:871px; height:416px; z-index:1; top: 69px; left: 114px;">
      <form name="form1" method="get" action="Acc_usuario.php">
        <table width="824" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="811" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="200"><span class="Estilo5">LOGIN : <input  class="Estilo10" name="txtLogin" type="text" id="txtLogin" size="20" maxlength="15" readonly  value="<?php echo $login?>"> </span></td>
                <td width="565"><span class="Estilo5">NOMBRE USUARIO:</span> <input  class="Estilo10" name="txtNombre" type="text" id="txtNombre" value="<?php echo $nombre?>" readonly size="60" maxlength="200" ></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td>  </tr>
        </table>
        <iframe src="Det_asig_part.php?musuario=<?php echo $login?>"  width="860" height="380" scrolling="auto" frameborder="1">
        </iframe>
        </form>
    </div>

  </tr>
</table>
</body>
</html>