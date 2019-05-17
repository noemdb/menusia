<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles nominas asignadas a usuarios)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="750" border="0" cellspacing="0" cellpadding="0">
   
    <tr><td>&nbsp;</td></tr>
   <tr>   <td width="750">
<?php if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}
$sql="select nom059.tipo_nomina,nom001.descripcion,nom059.status FROM nom059,nom001 Where (nom059.tipo_nomina=nom001.tipo_nomina) And (usuario_sia='$criterio')"; $res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo n&oacute;mina</strong></td>
           <td width="640" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
		   <td width="120" align="center" bgcolor="#99CCFF"><strong>Activa</strong></td>
         </tr>
         <?
while($registro=pg_fetch_array($res)){
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:llamar_seleccion('<? echo $registro["tipo_nomina"]; ?>');" >
           <td width="100" align="left"><? echo $registro["tipo_nomina"]; ?></td>
           <td width="640" align="left"><? echo $registro["descripcion"]; ?></td>
		   <td width="100" align="center"><? echo $registro["status"]; ?></td>
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

function llamar_seleccion(mtipo){ var r;
  r=confirm("Esta seguro en Seleccionar el Tipo de Nomina del Usuario ?");
  if(r==true){ r=confirm("Esta Realmente seguro en Seleccionar el Tipo de Nomina del Usuario ?");
    if(r==true){document.location='Selec_nom_usuario.php?criterio=<?echo $criterio?>'+'&tipo_nomina='+mtipo;  }}
      else { url="Cancelado, no elimino"; }
}

</script>