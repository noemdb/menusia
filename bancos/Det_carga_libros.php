<?php include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';$cod_banco='';$fecha=''; $monto_d=0; $monto_h=9999999999.99; $solop="NO";}
else{$codigo_mov=$_GET["codigo_mov"];$cod_banco=$_GET["cod_banco"];$fecha=$_GET["fecha"]; $monto_d=$_GET["monto_d"]; $monto_h=$_GET["monto_h"]; $solop=$_GET["solop"]; }  
$monto_d=formato_numero($monto_d); if(is_numeric($monto_d)){$monto_d=$monto_d;} else{$monto_d=0;}
$monto_h=formato_numero($monto_h); if(is_numeric($monto_h)){$monto_h=$monto_h;} else{$monto_h=0;}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Detalles Carga Libros)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,cbanco,refe,tipom){var murl;
   murl="Selec_mov_carga.php?codigo_mov="+codigo_mov+"&cod_banco="+cbanco+"&referencia="+refe+"&tipom="+tipom+"&fecha=<?php echo $fecha?>&solop=<?php echo $solop?>&monto_d=<?php echo $monto_d?>&monto_h=<?php echo $monto_h?>"; 
   murl="ver_mov_carga.php?codigo_mov="+codigo_mov+"&cod_banco="+cbanco+"&referencia="+refe+"&tipom="+tipom+"&fecha=<?php echo $fecha?>&solop=<?php echo $solop?>&monto_d=0&monto_h=<?php echo $monto_h?>"; 
   document.location=murl;
}
</script>
<style type="text/css">
<!--
.Estilo19 {color: #0000CC; font-weight: bold; font-size: 13pt; }
-->
</style>
<body>
<?php
if($solop=="SI"){ $sql="SELECT * FROM carga_libros where codigo_mov='$codigo_mov' and mes_conciliacion='99' and monto_mov_libro>='$monto_d' and monto_mov_libro<='$monto_h' order by fecha_mov_libro,referencia";}
else{$sql="SELECT * FROM carga_libros where codigo_mov='$codigo_mov' and monto_mov_libro>='$monto_d' and monto_mov_libro<='$monto_h' order by fecha_mov_libro,referencia";} $res=pg_query($sql);
?>
 <table width="1000" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1000">
       <table width="1000"  border="1" cellspacing='0' cellpadding='0' align="left" id="mov_libro">
         <tr height="20" class="Estilo5">
           <td width="70"  align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
		   <td width="40"  align="center" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
		   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto</strong></td>
		   <td width="30" align="center" bgcolor="#99CCFF" ><strong>Mes</strong></td>
		   <td width="330" align="left" bgcolor="#99CCFF" ><strong>Nombre Benef.</strong></td>
           <td width="350" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
         </tr>
         <?php  $total=0; $cant=0;
while($registro=pg_fetch_array($res)) { $monto=$registro["monto_mov_libro"];  $nomb_benef=$registro["nombre"]; $sfecha=$registro["fecha_mov_libro"];
$monto=formato_monto($monto);  $fecha_mov=substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); if($nomb_benef==""){$nomb_benef=$registro["campo_str2"];}
$nomb_benef=substr($nomb_benef,0,100); $descripcion=substr($registro["descrip_mov_libro"],0,50);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript: Llama_Modificar('<?php  echo $codigo_mov; ?>','<?php  echo $registro["cod_banco"]; ?>','<?php  echo $registro["referencia"]; ?>','<?php  echo $registro["tipo_mov_libro"]; ?>');">

           <td width="70" align="left"><?php  echo $registro["referencia"]; ?></td>
		   <td width="40" align="center"><?php  echo $registro["tipo_mov_libro"]; ?></td>           
           <td width="80" align="left"><?php  echo $fecha_mov; ?></td>
           <td width="100" align="right"><?php  echo $monto; ?></td>
		   <td width="30" align="center"><?php  echo $registro["mes_conciliacion"]; ?></td>  
           <?php  if ($nomb_benef=="") {?>
           <td width="330" align="left">&nbsp;</td>
           <?php }else{?>
           <td width="330" align="left"><?php  echo $nomb_benef ?></td>
		   <?php }?>		   
           <?php  if ($descripcion=="") {?>
           <td width="350" align="left">&nbsp;</td>
           <?php }else{?>
           <td width="350" align="left"><?php  echo $descripcion ?></td>
		   <?php }?>
         </tr>
         <?php }
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr> <td>&nbsp;</td> </tr>
   
 </table>
</body>
</html>
<?php  pg_close($conn); ?>