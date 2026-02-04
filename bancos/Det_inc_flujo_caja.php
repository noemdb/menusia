<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Detalle Gastos para Flujo de Caja)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="1500" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1500">
<?php if (!$_GET){$periodo='';}  else{$periodo=$_GET["criterio"]; }
$sql="SELECT * FROM MOV_FLUJO  where periodo='$periodo' order by cod_movimiento"; $res=pg_query($sql);
 ?>
       <table width="1450"  border="1" cellspacing='0' cellpadding='0' align="left" id="comp_iva">
         <tr height="20" class="Estilo5">
           <td width="41"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
		   <td width="45"  align="left" bgcolor="#99CCFF"><strong>Grupo</strong></td>
		   <td width="55"  align="left" bgcolor="#99CCFF"><strong>Operacion</strong></td>
		   <td width="70"  align="left" bgcolor="#99CCFF"><strong>Tipo Oper</strong></td>
		   <td width="50"  align="left" bgcolor="#99CCFF"><strong>Modulo</strong></td>
		   <td width="50"  align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
		   <td width="140"  align="left" bgcolor="#99CCFF"><strong>Codigo Contable</strong></td>
		   <td width="460" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
		   <td width="40" align="left" bgcolor="#99CCFF"><strong>Signo</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF"><strong>Monto</strong></td>
           <td width="130" align="right" bgcolor="#99CCFF"><strong>Acumulado</strong></td>	
           <td width="250" align="left" bgcolor="#99CCFF"><strong>Des. Grupo</strong></td>
         </tr>
         <?php  $total=0;
//periodo,cod_movimiento,descripcion,cod_grupo,operacion,tipo_operacion,modulo,tipo_mov,signo,cod_contable,monto,acumulado
while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto"]); $acumulado=formato_monto($registro["acumulado"]);  $descripcion=$registro["descripcion"]; $descripcion=substr($descripcion,0,150);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="40" align="center"><?php  echo $registro["cod_movimiento"]; ?></td>	
		   <td width="45" align="center"><?php  echo $registro["cod_grupo"]; ?></td>	
		   <td width="55" align="left"><?php  echo $registro["operacion"]; ?></td>	
		   <td width="75" align="left"><?php  echo $registro["tipo_operacion"]; ?></td>	
		   <td width="50" align="left"><?php  echo $registro["modulo"]; ?></td>	
		   <td width="50" align="left"><?php  echo $registro["tipo_mov"]; ?></td>	
           <td width="140" align="left"><?php  echo $registro["cod_contable"]; ?></td>	
		   <td width="460" align="left"><?php  echo $descripcion; ?></td>
           <td width="40" align="left"><?php  echo $registro["signo"]; ?></td>			   
		   <td width="120" align="right"><?php  echo $monto; ?></td>
		   <td width="130" align="right"><?php  echo $acumulado; ?></td>	
		   <td width="250" align="left"><?php  echo $registro["denominacion"]; ?></td>
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