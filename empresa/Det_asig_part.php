<?php include ("../class/conect.php"); include ("../class/funciones.php"); 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$criterio=''; } else{$criterio=$_GET["musuario"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script language="JavaScript" type="text/JavaScript">
function Llama(musuario,mcodigo,mfuente){
if (mcodigo=="") {alert("Codigo debe ser Seleccionado");}
  else { murl="Esta seguro en Eliminar el Codigo:"+mcodigo+" de la Asignacion de Partidas ?";  r=confirm(murl);
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Asignacion de Partidas ?");
    if (r==true) { murl="Delete_asig_part.php?musuario="+musuario+"&codigo="+mcodigo+"&fuente="+mfuente;   document.location=murl;}    }
   else { url="Cancelado, no elimino"; }
  }  
}
 </script>
<title>SIA CONFIGURACI&Oacute;N Y MANTENIMIENTO (Detalles Asignar Partidas)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="840" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="left"><table width="840" border="0" align="left">
          <tr>
            <td width="215" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Codigo al Usuario" onclick="javascript:LlamarURL('Inc_codigo_part.php?usuario=<?php echo $criterio?>')"></td>
            <td width="200" align="center"></td>
            <td width="200" align="center"></td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos del Usuario"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="10">
      <td>
        <p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<?php
$sql="SELECT * FROM SIA008 where sia008.usuario='$criterio'";
$sql="SELECT sia008.cod_presup,sia008.cod_fuente,pre001.denominacion  FROM sia008 LEFT JOIN pre001 ON ((pre001.cod_presup=sia008.cod_presup) And (pre001.cod_fuente=sia008.cod_fuente))  where sia008.usuario='$criterio' Order By sia008.cod_presup,sia008.cod_fuente"; $res=pg_query($sql);
?>
        <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="250"  align="left" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="550" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
         </tr>
<?php while($registro=pg_fetch_array($res)){ ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama('<?php echo $criterio; ?>','<?php echo $registro["cod_presup"]; ?>','<?php echo $registro["cod_fuente"]; ?>');">
           <td width="250" align="left"><?php echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><?php echo $registro["cod_fuente"]; ?></td>
           <td width="550" align="left"><?php echo $registro["denominacion"]; ?></td>
         </tr>
         <?php }?>
       </table></td>
   </tr>
 </table>
</body>
</html>
<?php pg_close(); ?>
