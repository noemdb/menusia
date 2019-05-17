<?php include ("../class/conect.php");  include ("../class/funciones.php");
if(!$_GET){ $login='';}else {$login=$_GET["GUsuario"];}$nombre="";$cargo=""; $departamento="";$cat_prog="";$cod_almacen="";$unidad_sol="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sql="Select * from sia001 WHERE campo101='$login'";  $res=pg_query($sql);
  if ($registro=pg_fetch_array($res,0)){ $nombre=$registro["campo104"];$cargo=$registro["campo105"]; $departamento=$registro["campo106"];  $cat_prog=$registro["campo107"]; $cod_almacen=$registro["campo108"];$unidad_sol=$registro["campo111"];}}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONFIGURACI&Oacute;N Y MANTENIMIENTO  (Cambio de Clave)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){document.location ='menu.php';}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtnombre_usuario.value==""){alert("Nombre de Usuario no puede estar Vacio");return false;} else{f.txtnombre_usuario.value=f.txtnombre_usuario.value.toUpperCase();}
   if(f.txtClaveN.value==""){alert("Clave Nueva puede estar Vacio");return false;} else{f.txtClaveN.value=f.txtClaveN.value.toUpperCase();}
   if(f.txtClaveNR.value==""){alert("Clave Nueva puede estar Vacio");return false;} else{f.txtClaveNR.value=f.txtClaveNR.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
</head>
<body>
<form name="form1" method="post" action="Update_camb_clave.php" onSubmit="return revisar()">
  <table width="534" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="530" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><table width="530" height="38"  border="0" cellpadding="0" cellspacing="0" bgcolor="#000066">
           <tr>
              <td width="530"><div align="center" class="Estilo2 Estilo6">CAMBIO DE CLAVE</div></td>
           </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="520">
            <tr>
              <td width="20">&nbsp;</td>
              <td width="200"><span class="Estilo5">NOMBRE USUARIO:</span></td>
              <td width="300"><input class="Estilo10" name="txtnombre_u" type="text"  id="txtnombre_u" size="20" maxlength="20" readonly value="<? echo $login ?>"></td>
               </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>        
        <tr>
          <td><table width="520" border="0">
            <tr>
               <td width="20">&nbsp;</td>
               <td width="200"><span class="Estilo5">TIPEE CLAVE NUEVA : </span></td>
               <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtClaveN" type="password" id="txtClaveN" size="20" maxlength="12" onFocus="encender(this);" onBlur="apagar(this);"> </span></td>
             </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="520" border="0">
            <tr>
               <td width="20">&nbsp;</td>
               <td width="200"><span class="Estilo5">REPITA CLAVE NUEVA : </span></td>
               <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtClaveNR" type="password" id="txtClaveNR" size="20" maxlength="12" onFocus="encender(this);" onBlur="apagar(this);"> </span></td>
             </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
      </table>
        <table width="500" align="center">
          <tr>
            <td width="100">&nbsp;</td>
            <td width="150" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="150" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>
