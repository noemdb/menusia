<?php include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{?><script language="JavaScript">  window.close(); </script><?php }
 $SIA_Cierre="N"; $SIA_Precierre="N"; $sql="Select * from SIA000 order by campo001";$resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$SIA_Integrado=$registro["campo036"];$Fec_Ini_Ejer=$registro["campo031"];$Fec_Fin_Ejer=$registro["campo032"];$SIA_Precierre=substr($SIA_Integrado,16,1); $SIA_Cierre=substr($SIA_Integrado,17,1);} else{ ?><script language="JavaScript">muestra('INFORMACION DE EMPRESA NO LOCALIZADA'); window.close(); </script><?php }
if($SIA_Precierre=="S"){$SIA_Precierre="S";}else{ ?><script language="JavaScript">muestra('PRE-CIERRE DEL EJERCICIO NO EJECUTADO'); window.close(); </script><?php } 
if($SIA_Cierre=="S"){ ?><script language="JavaScript">muestra('EJERCICIO YA CERRADO'); window.close(); </script><?php } 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>Actualizar Precierre</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<style type="text/css">
<!--
.Estilo2 {color: #FF0000; font-weight: bold;
}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="">
  <table width="530" height="206" border="1" align="center" cellpadding="0" cellspacing="0">
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
          <td><p><strong>Los Saldos Iniciales de los Bancos y Contabilidad ser&aacute;n Actualizados tomando como base los Saldos Finales del Ejercicio Actual</strong></p>            </td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
		<tr><td width="428"><table width="428" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="358"><strong>ACTUALIZAR MOVIMIENTOS EN TRANSITO:<strong> </td>
			  <td width="70"><div align="center"><span class="Estilo5"><select name="txtact_trans" size="1"> <option selected>NO</option> <option>SI</option> </select> </span></div></td>
			</tr>
		</table></td> </tr>
		<tr> <td>&nbsp;</td> </tr>
		<tr><td width="428"><table width="428" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="358"><strong>ACTUALIZAR ORDENES DE PAGO PENDIENTE:<strong> </td>
			  <td width="70"><div align="center"><span class="Estilo5"><select name="txtact_ordenes" size="1"> <option selected>NO</option> <option>SI</option> </select> </span></div></td>
			</tr>
		</table></td> </tr>
		<tr> <td>&nbsp;</td> </tr>
		<tr><td width="428"><table width="428" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="358"><strong>ACTUALIZAR SALDO DE ALMACEN:<strong> </td>
			  <td width="70"><div align="center"><span class="Estilo5"><select name="txtact_saldalm" size="1"> <option selected>NO</option> <option>SI</option> </select> </span></div></td>
			</tr>
		</table></td> </tr>
		<tr> <td>&nbsp;</td> </tr>
        <tr>
          <td><table width="454" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><input name="btactualiza" type="button" id="btactualiza3" value="ACTUALIZAR" onClick="javascript:VentanaCentrada('React_precierre.php?act_trans='+document.form1.txtact_trans.value+'&act_ordenes='+document.form1.txtact_ordenes.value+'&act_almacen='+document.form1.txtact_saldalm.value,'Actualizar Precierre','','600','260','true');"></td>
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
