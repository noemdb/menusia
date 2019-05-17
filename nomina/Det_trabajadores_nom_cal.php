<?include ("../class/conect.php");  include ("../class/funciones.php");$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles del C&oacute;digo Presupuestarios)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="838" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="838">
       <?php
if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$sql="SELECT * FROM PAG043 where codigo_mov='$codigo_mov' order by cod_rif_est"; $res=pg_query($sql);
?>
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="130" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo Trabajador</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>C&eacute;dula</strong></td>
           <td width="470" align="center" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Monto</strong></td>
           </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_benef_e"]; $monto=formato_monto($monto);$total=$total+$registro["monto_benef_e"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="130" align="left"><? echo $registro["cod_rif_est"]; ?></td>
           <td width="100" align="left"><? echo $registro["ced_rif_est"]; ?></td>
           <td width="470" align="left"><? echo $registro["nombre_benef_e"]; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
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
         <td width="460">&nbsp;</td>
         <td width="190"><span class="Estilo5">TOTAL TRABAJADORES:</span></td>
         <td width="190"><table width="150" border="1" cellspacing="0" cellpadding="0">
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