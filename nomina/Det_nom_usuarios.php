<?include ("../class/conect.php");  include ("../class/funciones.php");  if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles nominas asignadas a usuarios)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="750" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="740" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="220" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Tipo Nomina" onclick="javascript:llamar_agregar()"></td>
            <td width="300" align="center">&nbsp;</td>
            <td width="220" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar Hoja de Vida"></td>
          </tr>
      </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
   <tr>   <td width="750">
<?php
$sql="select nom059.tipo_nomina,nom001.descripcion FROM nom059,nom001 Where (nom059.tipo_nomina=nom001.tipo_nomina) And (usuario_sia='$criterio')"; $res=pg_query($sql);
?>
       <table width="740"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="120" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo n&oacute;mina</strong></td>
           <td width="620" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
         </tr>
         <?
while($registro=pg_fetch_array($res)){
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:llamar_eliminar('<? echo $registro["tipo_nomina"]; ?>');" >
           <td width="120" align="left"><? echo $registro["tipo_nomina"]; ?></td>
           <td width="620" align="left"><? echo $registro["descripcion"]; ?></td>
         </tr>
         <?}
?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td>   </tr>
</table>
 <p>&nbsp;</p>
</body>
</html>
<?   pg_close(); ?>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_agregar(){var mcodigo='<?echo $criterio?>';
if(mcodigo==""){ alert('Usuario Invalido');}else{document.location='Inc_nomina_usuario.php?criterio=<?echo $criterio?>'; } }

function llamar_eliminar(mtipo){ var r;
  r=confirm("Esta seguro en Eliminar el Tipo de Nomina del Usuario ?");
  if(r==true){ r=confirm("Esta Realmente seguro en Eliminar el Tipo de Nomina del Usuario ?");
    if(r==true){document.location='Delete_nom_usuario.php?criterio=<?echo $criterio?>'+'&tipo_nomina='+mtipo;  }}
      else { url="Cancelado, no elimino"; }
}
</script>