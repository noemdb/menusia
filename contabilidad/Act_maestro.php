<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
  else{ $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql); $filas=pg_numrows($resultado); $tipo_u="U"; if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN"; if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  
	else{$modulo="03"; $opcion="04-0000015"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql); $filas=pg_numrows($res); if ($filas>0){$reg=pg_fetch_array($res); 
	  $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
      }$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> window.close();</script><?}}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>Actualizar Maestro</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo2 {color: #FF0000;       font-weight: bold;}
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
          <td><p><strong>Los Saldos de las Cuentas ser&aacute;n Actualizados tomando como base los Comprobantes Contables.</strong></p>            </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="454" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><input name="btactualiza" type="button" id="btactualiza3" value="ACTUALIZAR" onClick="javascript:VentanaCentrada('Actualizar.php','Actualizar Maestro','','600','260','true');"></td>
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