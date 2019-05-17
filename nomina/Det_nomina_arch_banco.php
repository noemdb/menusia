<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}$tipo_arch_banco=substr($criterio,0,2); $cod_arch_banco=substr($criterio,2,6);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles del Archivo Texto Banco)</title>
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
$sql="SELECT NOM046.tipo_nomina,NOM001.descripcion FROM NOM046,NOM001 Where (NOM046.tipo_nomina=NOM001.tipo_nomina) And (Cod_Arch_Banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco')"; $res=pg_query($sql);
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
function llamar_agregar(){var mcodigo='<?echo $cod_arch_banco?>';
if(mcodigo==""){ alert('Codigo de Banco Invalido');}
else{
//document.location='Inc_nomina_arch_banco.php?cod_arch_banco=<?echo $cod_arch_banco?>'+'&tipo_arch_banco=<?echo $tipo_arch_banco?>'; 
document.location='Inc_nomina_arch_banco.php?criterio=<?echo $criterio?>'; 

} }
function llamar_eliminar(mtipo){ var r;
  r=confirm("Esta seguro en Eliminar el Tipo de Nomina del Archivo ?");
  if(r==true){ r=confirm("Esta Realmente seguro en Eliminar el Tipo de N&oacute;mina del Archivo ?");
    if(r==true){document.location='Delete_nom_arch_banco.php?cod_arch_banco=<?echo $cod_arch_banco?>'+'&tipo_arch_banco=<?echo $tipo_arch_banco?>'+'&tipo_nomina='+mtipo;  }}
      else { url="Cancelado, no elimino"; }
}

</script>