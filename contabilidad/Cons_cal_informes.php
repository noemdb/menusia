<?php include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$linea='';$cod_informe='';} else{$linea=$_GET["linea"];$cod_informe=$_GET["cod_informe"];}
$sql="SELECT * FROM CON006 where (tipo_informe='$cod_informe') and (linea='$linea')";  $res=pg_query($sql);$filas=pg_num_rows($res);  
$codigo_cuenta=""; $nombre_cuenta=""; 
if($filas>=1){$registro=pg_fetch_array($res,0); $codigo_cuenta=$registro["codigo_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Calculos de Informes Contables)</title>
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>
<body>
 <table width="640" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="640"><span class="Estilo5"><strong> LINEA : <?php echo $linea?>  CUENTA : <?php echo $codigo_cuenta." ".$nombre_cuenta?>  </strong></span></td>
   </tr>
   <tr>
     <td>
<?php
$sql="SELECT con007.codigo_cuenta,con007.operacion,con007.status_c,con001.nombre_cuenta FROM con007 left join con001 on (con007.codigo_cuenta=con001.codigo_cuenta) where tipo_informe='$cod_informe' and linea='$linea' order by codigo_cuenta";$res=pg_query($sql);

?>
       <table width="630"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_pasivo">
         <tr height="20" class="Estilo5">
           <td width="150" align="left" bgcolor="#99CCFF"><strong>Codigo Cuenta</strong></td>
           <td width="300" align="center" bgcolor="#99CCFF" ><strong>Denominacion </strong></td>
           <td width="90" align="center" bgcolor="#99CCFF" ><strong>Operacion</strong></td>
           <td width="90" align="center" bgcolor="#99CCFF" ><strong>D/C/S</strong></td>
         </tr>
         <?php while($registro=pg_fetch_array($res)){  ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="150" align="left"><?php  echo $registro["codigo_cuenta"]; ?></td>
           <td width="300" align="left"><?php  echo $registro["nombre_cuenta"]; ?></td>
           <td width="90" align="center"><?php  echo $registro["operacion"]; ?></td>
           <td width="90" align="center"><?php  echo $registro["status_c"]; ?></td>
         </tr>
         <?php }?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   
   <tr>
     <td align="center"><input name="btcerrar" type="button" id="btcerrar" value="Cerra Ventana" onclick="javascrip:cerrar_ventana();"></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php   pg_close($conn); ?>