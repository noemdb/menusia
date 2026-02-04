<?php include ("../class/conect.php"); include ("../class/funciones.php"); 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$criterio=''; } else{$criterio=$_GET["usuario"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script language="JavaScript" type="text/JavaScript">
function Llama(musuario,mdep,mdir,mdepart,msubdep){
if (msubdep=="") {alert("Codigo debe ser Seleccionado");}
  else { murl="Esta seguro en Eliminar el Codigo:"+msubdep+" de la Ubicacion de Bienes del Usuario ?";  r=confirm(murl);
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Ubicacion de Bienes del Usuario ?");
    if (r==true) { murl="Delete_asig_ubic_bienes.php?usuario="+musuario+"&dep="+mdep+"&dir="+mdir+"&depart="+mdepart+"&subdep="+msubdep;   document.location=murl;}    }
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
            <td width="215" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Codigo al Usuario" onclick="javascript:LlamarURL('Inc_codigo_subdepart.php?usuario=<?php echo $criterio?>')"></td>
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
$sql="SELECT sia009.cod_dependencia,sia009.cod_direccion,sia009.cod_departamento,sia009.cod_sub_departamento FROM SIA009 where sia009.usuario='$criterio'"; $res=pg_query($sql);
?>
        <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>Dependencia</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong>Direccion</strong></td>
           <td width="200" align="center" bgcolor="#99CCFF"><strong>Departamento</strong></td>
		   <td width="240" align="left" bgcolor="#99CCFF"><strong>Sub-Departamento</strong></td>
         </tr>
<?php while($registro=pg_fetch_array($res)){ ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama('<?php echo $criterio; ?>','<?php echo $registro["cod_dependencia"]; ?>','<?php echo $registro["cod_direccion"]; ?>','<?php echo $registro["cod_departamento"]; ?>','<?php echo $registro["cod_sub_departamento"]; ?>');">
           <td width="200" align="left"><?php echo $registro["cod_dependencia"]; ?></td>
           <td width="200" align="left"><?php echo $registro["cod_direccion"]; ?></td>
           <td width="200" align="left"><?php echo $registro["cod_departamento"]; ?></td>
		   <td width="240" align="left"><?php echo $registro["cod_sub_departamento"]; ?></td>
         </tr>
         <?php }?>
       </table></td>
   </tr>
 </table>
</body>
</html>
<?php pg_close(); ?>
