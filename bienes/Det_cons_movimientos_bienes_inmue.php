<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP BIENES NACIONALES (Detalles Movimientos Bienes Muebles)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
 <table width="1450" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php 
if (!$_GET){ $criterio='';  $referencia='';  $fecha='';} else{$criterio=$_GET["criterio"];  $referencia=substr($criterio,0,8); $fecha=substr($criterio,8,10);   }
$sql="SELECT * FROM DET_MOV_INMUE where text(fecha)='$fecha' and referencia='$referencia' order by cod_bien_inm"; $res=pg_query($sql);
?>
       <table width="1420"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="150"  align="left" bgcolor="#99CCFF"><strong>Codigo Bien</strong></td>
           <td width="550" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
		   <td width="50"  align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
		   <td width="550" align="center" bgcolor="#99CCFF"><strong>Descripcion Tipo de Movimiento</strong></td>
         </tr>
         <?php  $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto"]; $monto=formato_monto($monto);$total=$total+$registro["monto"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<?php  echo $codigo_mov; ?>','<?php  echo $registro["cod_bien_inm"]; ?>');">
           <td width="150" align="left"><?php  echo $registro["cod_bien_inm"]; ?></td>
           <td width="550" align="left"><?php  echo $registro["denominacion"]; ?></td>
           <td width="100" align="right"><?php  echo $monto; ?></td>
		   <td width="50" align="left"><?php  echo $registro["tipo_movimiento"]; ?></td>
		   <td width="550" align="left"><?php  echo $registro["denomina_tipo"]; ?></td>
         </tr>
         <?php }
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="842" border="0">
       <tr>
         <td width="133">&nbsp;</td>
         <td width="438">&nbsp;</td>
         <td width="82"><span class="Estilo5">TOTAL :</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><?php  echo $total; ?></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php 
  pg_close($conn);
?>
