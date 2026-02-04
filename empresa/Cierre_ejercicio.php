<?php include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
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
<html>
<head>
<title>Cierre de Ejercicio</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<style type="text/css">
<!--
.Estilo2 {font-size: 14pt; color: #FF0000; font-weight: bold;
}
-->
</style>


<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function Llama_cierre(){var r; var url;
   r=confirm("DESEA REALIZAR EL PROCESO DE CIERRE DEL EJERCICIO ?");  if (r==true) { valido=true;
    r=confirm("ESTA REALMENTE SEGURO DE REALIZAR EL PROCESO DE CIERRE DEL EJERCICIO ?");  if (r==true) { url="Reg_cierre.php";  document.location = url; } } 
}
</script>
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
          <td><p><strong>Para ejecutar esta proceso, se debe haber ejecutado la opcion ACTUALIZAR PRE-CIERRE deL Ejercicio</strong></p>            </td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
		<tr>
          <td><p><strong>Este proceso bloquea la información del ejercicio ha cerrar solo para Consultas, sin ninguna posibilidad de realizar cambios sobre los datos. </strong></p>            </td>
        </tr>
		<tr> <td>&nbsp;</td> </tr>
		<tr>
          <td><p><strong>SE RECOMIENDA, RESPALDAR los datos antes de ejecutar este proceso. </strong></p>            </td>
        </tr>
		<tr> <td>&nbsp;</td> </tr>
		
		<tr> <td>&nbsp;</td> </tr>
        <tr>
          <td><table width="454" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><input name="btactualiza" type="button" id="btactualiza3" value="ACTUALIZAR" onClick="javascript:Llama_cierre();"></td>
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
