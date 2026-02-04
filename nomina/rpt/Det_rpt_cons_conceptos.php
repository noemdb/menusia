<?include ("../../class/conect.php");  include ("../../class/funciones.php");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Detalle Consolidado de Conceptos)</title>
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
</head>
<script language="JavaScript" type="text/JavaScript">
function cerrar_fact(mfacturas){
  window.close(); window.opener.location.reload();
}
function Llamar_Inc_factura(){
 murl="Inc_rpt_cons_conceptos.php?password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>";
 document.location=murl;
}
function Llama_Modificar(codigo){var murl;
  if (codigo=="") {alert("Reporte debe ser Seleccionada");}
  else{ murl="Mod_rpt_cons_conceptos.php?codigo="+codigo; document.location=murl;}
}
</script>
<body>
 <table width="805" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Factura" onclick="javascript:Llamar_Inc_factura();"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar las Facturas"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5">
      <td>
        <p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<?php $sql="SELECT * FROM nom047  order by cod_reporte"; $res=pg_query($sql);?>
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_pasivo">
         <tr height="20" class="Estilo5">
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="400"  align="left" bgcolor="#99CCFF"><strong>Descripcion del Reporte</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>Nombre Archivo</strong></td>           
         </tr>
         <? 
while($registro=pg_fetch_array($res)){  ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $registro["cod_reporte"]; ?>');">
           <td width="100" align="left"><? echo $registro["cod_reporte"]; ?></td>
           <td width="400" align="left"><? echo $registro["des_repote"]; ?></td>
           <td width="300" align="left"><? echo $registro["den_arch_rpt"]; ?></td>
           
         </tr>
         <?} ?>
       </table></td>
   </tr>
   <tr> <td>&nbsp;</td> </tr>  
   <tr>
     <td align="center"><input name="btcerrar" type="button" id="btcerrar" value="Cerra Ventana" onclick="javascrip:cerrar_fact();"></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?
  pg_close();
?>
