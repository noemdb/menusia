<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Detalles Sueldo Dias Adicionales)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="836" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="836">
<?php  if (!$_GET){$criterio='';$cod_empleado='';$fecha_sueldo='';}else{$criterio=$_GET["criterio"]; $fecha_sueldo=substr($criterio,0,10);$cod_empleado=substr($criterio,10,15);}
$sql="SELECT * FROM nom050  where cod_empleado='$cod_empleado' and fecha_sueldo='$fecha_sueldo' order by cod_concepto"; $res=pg_query($sql);
?>
       <table width="837"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Concepto</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Fecha</strong></td>
           <td width="136" align="center" bgcolor="#99CCFF" ><strong>Monto</strong></td>
         </tr>
         <?
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]; $monto=formato_monto($monto); $fecha_h=$registro["fecha_historico"]; $fecha_h=formato_ddmmaaaa($fecha_h);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="100" align="left"><? echo $registro["cod_concepto"]; ?></td>
           <td width="500" align="left"><? echo $registro["des_concepto"]; ?></td>
           <td width="100" align="left"><? echo $fecha_h; ?></td>
           <td width="136" align="right"><? echo $monto; ?></td>
         </tr>
         <?}
?>
     </table></td>
   </tr>
   <tr> <td>&nbsp;</td> </tr>
   <tr> <td>&nbsp;</td> </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close(); ?>