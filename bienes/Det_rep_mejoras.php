<?include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_bien_mue='';}else{$cod_bien_mue=$_GET["cod_bien_mue"];}  $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA COMPRAS,SERVICIOS Y ALMAC&Eacute;N (Detalle Reparaciones y Mejoras)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
<table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
		    <td width="222" align="center" valign="middle"> <input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar" onclick="javascript:Llama_Agregar('<?echo $cod_bien_mue?>')">   </td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5">
      <td>
        <p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<?php
$sql="SELECT bien058.cod_bien_mue,bien058.cod_bien_aso,bien058.fecha_rep,bien058.valor_rep,bien058.campo_str1,bien058.campo_str2,bien058.monto1,bien058.monto2,bien015.denominacion  FROM bien058 left join bien015 on (bien015.cod_bien_mue=bien058.cod_bien_aso) where bien058.cod_bien_mue='$cod_bien_mue' order by bien058.cod_bien_aso";  $resultado=pg_query($sql);
?>
 <table width="810" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="800">
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_orden">
         <tr height="20" class="Estilo5">
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="420" align="left" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
		   <td width="80"  align="center" bgcolor="#99CCFF"><strong>Fecha</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>Valor</strong></td>
         </tr>
         <? $total_rep=0; $filas=pg_num_rows($resultado); 
         while($registro=pg_fetch_array($resultado)){ $total_rep=$total_rep+$registro["valor_rep"];  $fecha_rep=$registro["fecha_rep"]; $fecha_rep=formato_ddmmaaaa($fecha_rep); $valor_rep=$registro["valor_rep"]; $valor_rep=formato_monto($valor_rep); ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $cod_bien_mue; ?>','<? echo $registro["cod_bien_aso"]; ?>');">
           <td width="200" align="left"><? echo $registro["cod_bien_aso"]; ?></td>
           <td width="420" align="left"><? echo $registro["denominacion"]; ?></td>
		   <td width="80" align="center"><? echo $fecha_rep; ?></td>
		   <td width="100" align="right"><? echo $valor_rep; ?></td>
         </tr>
         <?}  $total_rep=formato_monto($total_rep); ?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td>   </tr>
   <tr>
     <td><table width="800" border="0">
       <tr>
        
         <td width="590">&nbsp;</td>
         <td width="100"><span class="Estilo5">TOTAL :</span></td>
         <td width="120"><table width="119" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><? echo $total_rep; ?></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<? pg_close(); ?>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Agregar(cod_bien_mue){var murl; 
   murl="Inc_rep_mejoras.php?cod_bien_mue="+cod_bien_mue; document.location=murl;
}
function Llama_Modificar(cod_bien_mue,codigo){var murl;   
   murl="Mod_rep_mejoras.php?cod_bien_mue="+cod_bien_mue+"&cod_bien_aso="+codigo; document.location=murl; 
}
</script>