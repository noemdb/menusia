<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Detalles del C&oacute;digo Presupuestarios)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="1015" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1015">
       <?php

$sql="SELECT pag044.cod_rif_est,pag044.cod_presup_est,pag044.fuente_est,pag044.monto_cod,pag044.ced_rif_est,pag044.ref_comp_est,pag044.tipo_comp_est,pre001.denominacion FROM PAG044 left join pre001 on ((pre001.cod_presup=pag044.cod_presup_est) and (pre001.cod_fuente=pag044.fuente_est)) where codigo_mov='$codigo_mov' order by cod_rif_est,cod_presup_est"; $res=pg_query($sql);
?>
       <table width="1010"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Cod. Trabajador</strong></td>
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>C&oacute;digo Presupuestario</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="320" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Cedula </strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Ref.Comp</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
             </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_cod"]; $monto=formato_monto($monto);$total=$total+$registro["monto_cod"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="200" align="left"><? echo $registro["cod_rif_est"]; ?></td>
           <td width="200" align="left"><? echo $registro["cod_presup_est"]; ?></td>
           <td width="40" align="left"><? echo $registro["fuente_est"]; ?></td>
           <td width="300" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="120" align="right"><? echo $monto; ?></td>
           <td width="120" align="right"><? echo $registro["ced_rif_est"];  ?></td>
           <td width="80" align="center"><? echo $registro["ref_comp_est"]; ?></td>
           <td width="50" align="center"><? echo $registro["tipo_comp_est"]; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);
?>
</table></td>
   </tr>
   <tr> <td>&nbsp;</td></tr>
   <tr>
     <td><table width="840" border="0">
       <tr>
         <td width="500">&nbsp;</td>
         <td width="120"><span class="Estilo5">TOTAL C&Oacute;DIGOS:</span></td>
         <td width="220"><table width="150" border="1" cellspacing="0" cellpadding="0">
         <tr><td align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<? pg_close();  ?>