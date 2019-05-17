<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$criterio=''; $tipo_informe=''; } else{$criterio=$_GET["criterio"]; $tipo_informe=substr($criterio,0,2);}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Detalles Informes Contables)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="904" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Campo al archivo" onclick="javascript:llamar_agregar()"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar Campos"></td>
          </tr>
      </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
   <tr>
     <td>
<?php 
$sql="SELECT * FROM CON006 where (tipo_informe='$tipo_informe') order by linea"; $res=pg_query($sql);
?>
       <table width="900"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="60"  align="left" bgcolor="#99CCFF"><strong>Linea</strong></td>
           <td width="150" align="left" bgcolor="#99CCFF"><strong>Codigo Cuenta</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="300" align="center" bgcolor="#99CCFF" ><strong>Denominacion </strong></td>
           <td width="50" align="center" bgcolor="#99CCFF"><strong>Calculable</strong></td>
		   <td width="50" align="center" bgcolor="#99CCFF"><strong>Status</strong></td>
		   <td width="50" align="center" bgcolor="#99CCFF"><strong>Operacion</strong></td>
		   <td width="50" align="center" bgcolor="#99CCFF"><strong>Columna</strong></td>
		   <td width="40" align="center" bgcolor="#99CCFF"><strong>Estilo</strong></td>
         </tr>
         <? $ult_campo=10;
while($registro=pg_fetch_array($res)){ $pos_campo=$registro["linea"]; $ult_campo=$pos_campo+10; ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_modifica('<? echo $registro["linea"]; ?>','<? echo $registro["calculable"]; ?>');" >
           <td width="60" align="left"><? echo $registro["linea"]; ?></td>
		   <? if ($registro["codigo_cuenta"]=="") {?>
           <td width="150" align="left">&nbsp;</td>
           <?}else{?>
		   <td width="150" align="left"><? echo $registro["codigo_cuenta"]; ?></td>
		   <?}?>
           <? if ($registro["cod_cuenta"]=="") {?>
		   <td width="150" align="left">&nbsp;</td>
           <?}else{?>
		   <td width="150" align="left"><? echo $registro["cod_cuenta"]; ?></td>
		    <?}?>
           <td width="300" align="left"><? echo $registro["nombre_cuenta"]; ?></td>
           <td width="50" align="center"><? echo $registro["calculable"]; ?></td>
           <td width="50" align="center"><? echo $registro["status_linea"]; ?></td>
           <td width="50" align="center"><? echo $registro["moperacion"]; ?></td>
		   <td width="50" align="center"><? echo $registro["columna"]; ?></td>
		   <td width="40" align="center"><? echo $registro["status"]; ?></td>
         </tr>
    <?} ?>
       </table></td>
   </tr>
   <tr> <td>&nbsp;</td>  </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close(); ?>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_agregar(){ var minforme='<?echo $tipo_informe?>';  var mpos_campo='<?echo $ult_campo; ?>';  mpos_campo=Rellenarizq(mpos_campo,"0",8);
 document.location='Inc_campo_inf_contab.php?tipo_informe=<?echo $tipo_informe?>'+'&linea='+mpos_campo; }
function Llama_modifica(mlinea,mcalculable){var murl; var minforme='<?echo $tipo_informe?>';
  document.location='Mod_campo_inf_contab.php?tipo_informe=<?echo $tipo_informe?>'+'&linea='+mlinea+'&calcula='+mcalculable;
}
</script>