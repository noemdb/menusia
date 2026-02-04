<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Detalle Flujo de Caja)</title>
<LINK
href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="845">
<?php if (!$_GET){$periodo='';}  else{$periodo=$_GET["criterio"]; }
$sql="SELECT * FROM BAN016  where periodo='$periodo' order by linea,consecutivo"; $res=pg_query($sql);
 ?>
       <table width="820"  border="1" cellspacing='0' cellpadding='0' align="left" id="comp_iva">
         <tr height="20" class="Estilo5">
           <td width="40"  align="left" bgcolor="#99CCFF"><strong>Linea</strong></td>
           <td width="480" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF"><strong>Monto</strong></td>
           <td width="130" align="right" bgcolor="#99CCFF"><strong>Acumulado</strong></td>		   
		   <td width="25" align="left" bgcolor="#99CCFF"><strong>Op</strong></td>
           <td width="25" align="left" bgcolor="#99CCFF"><strong>St</strong></td>
         </tr>
         <?php  $total=0;
//periodo,linea,consecutivo,descripcion,monto,acumulado,operacion,status
while($registro=pg_fetch_array($res)){ 
$monto=formato_monto($registro["monto"]); $acumulado=formato_monto($registro["acumulado"]); 

 $descripcion=$registro["descripcion"]; $descripcion=substr($descripcion,0,150);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="40" align="left"><?php  echo $registro["linea"]; ?></td>		   
		   <td width="480" align="left"><?php  echo $descripcion; ?></td>		   
		   <td width="120" align="right"><?php  echo $monto; ?></td>
		   <td width="130" align="right"><?php  echo $acumulado; ?></td>		   
		   <td width="25" align="left"><?php  echo $registro["operacion"]; ?></td>
		   <td width="25" align="left"><?php  echo $registro["status"]; ?></td>
           
         </tr>
<?php } ?>
       </table></td>
   </tr>
   <tr> <td>&nbsp;</td>   </tr>   
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php  pg_close($conn); ?>