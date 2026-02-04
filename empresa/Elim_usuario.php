<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); if (!$_GET){$login='';} else {  $login=$_GET["GUsuario"]; }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONFIGURACI&Oacute;N Y MANTENIMIENTO (Cuentas de Usuarios)</title>
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
function revisar(){var f=document.form1; var valido;
    if(f.txtLogin.value==""){alert("Login no puede estar Vacio");return false;} else{f.txtLogin.value=f.txtLogin.value.toUpperCase();}
	r=confirm("Esta seguro en Eliminar la Cuenta de Usuario ?");   if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Cuenta de Usuario?"); if (r==true) { valido=true;}else{return false;} } else{return false;} 
document.form1.submit;
return true;}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar la Cuenta de Usuario ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Cuenta de Usuario?");
    if (r==true) { url="Delete_usuario.php?txtLogin="+document.form1.txtLogin.value;
       VentanaCentrada(url,'Eliminar Usuario','','500','500','true');}
    }
   else { url="Cancelado, no elimino"; }
}
</script>
</head>
<?php $nombre="";$cargo="";$departamento="";$cat_prog="";$cod_almacen="";$unidad_sol="";
$sql="Select * from SIA001 WHERE campo101='$login'"; $res=pg_query($sql);
  if ($registro=pg_fetch_array($res,0)){ $nombre=$registro["campo104"];
     $cargo=$registro["campo105"];$departamento=$registro["campo106"];$cat_prog=$registro["campo107"];$cod_almacen=$registro["campo108"];$unidad_sol=$registro["campo111"];}

?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ELIMINAR USUARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=javascript:LlamarURL('usuarios.php');
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="usuarios.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:348px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Delete_usuario.php" onSubmit="return revisar()">
        <table width="824" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="775" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="360"><span class="Estilo5">LOGIN :
                      <input class="Estilo5" name="txtLogin" type="text" id="txtLogin" size="12" maxlength="8" readonly  value="<?php ECHO $login?>">
                </span></td>
                <td width="415">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="Estilo5">NOMBRE DEL USUARIO :</span>
              <input class="Estilo5" name="txtNombre" type="text" id="txtNombre" value="<?php ECHO $nombre?>" readonly size="80" maxlength="200" ></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="775" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="360"><span class="Estilo5">CARGO :
                    <input class="Estilo5" name="txtCargo" type="text" id="txtCargo" value="<?php ECHO $cargo?>" readonly size="18" maxlength="15" >
                </span></td>
                <td><span class="Estilo5">DEPARTAMENTO :
                    <input class="Estilo5" name="txtDepartamento" type="text" id="txtDepartamento" value="<?php ECHO $departamento?>" readonly size="18" maxlength="15" >
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="775" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="360"><span class="Estilo5">CATEGORIA PROGRAMATICA :
                      <input class="Estilo5" name="txtCat_prog" type="text" id="txtCat_prog" value="<?php ECHO $cat_prog?>" readonly size="18" maxlength="15" >
                </span></td>
                <td><span class="Estilo5">C&Oacute;DIGO DE ALMACEN  :
                      <input class="Estilo5" name="txtCod_Almacen" type="text" id="txtCod_Almacen" value="<?php ECHO $cod_almacen?>" readonly size="12" maxlength="8" >
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="Estilo5">UNIDAD SOLICITANTE :</span>
              <input class="Estilo5" name="txtUnidad_Sol" type="text" id="txtUnidad_Sol" value="<?php ECHO $unidad_sol?>" readonly size="90" maxlength="200" ></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <div align="center"></div>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
			<td width="100" align="center" valign="middle"><input name="button" type="submit" id="button"  value="Eliminar"></td>
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
<?php pg_close();?>
