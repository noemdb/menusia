<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>Actualizar Maestro</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<style type="text/css">
<!--
.Estilo2 {
        color: #FF0000;
        font-weight: bold;
}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="">
  <table width="530" height="176" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top"><table width="457" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="Estilo2">ADVERTENCIA</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><p><strong>Los Saldos de los Bancos ser&aacute;n Actualizados tomando como base los Movimientos en Libro y en Banco.</strong></p>            </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="454" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><input name="btactualiza" type="button" id="btactualiza3" value="ACTUALIZAR" onClick="javascript:VentanaCentrada('React_maestro.php','Actualizar Maestro','','600','260','true');"></td>
              <td align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:window.close();"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
