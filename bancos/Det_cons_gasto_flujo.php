<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Detalle Gastos para Flujo de Caja)</title>
<LINK
href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="845">
<?php if (!$_GET){$periodo='';}  else{$periodo=$_GET["criterio"]; }
$sql="SELECT * FROM MOV_GASTO_FLUJO  where periodo='$periodo' order by fecha_mov_libro,cod_banco,referencia"; $res=pg_query($sql);
 ?>
       <table width="1500"  border="1" cellspacing='0' cellpadding='0' align="left" id="comp_iva">
         <tr height="20" class="Estilo5">
           <td width="55"  align="left" bgcolor="#99CCFF"><strong>Banco</strong></td>
           <td width="75" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
		   <td width="40" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="350" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto</strong></td>
		   <td width="130" align="left" bgcolor="#99CCFF"><strong>Cod.Partida</strong></td>
		   <td width="130" align="left" bgcolor="#99CCFF"><strong>Cod.Contable</strong></td>
           <td width="90" align="left" bgcolor="#99CCFF"><strong>Ced.Rif</strong></td>
		   <td width="280" align="left" bgcolor="#99CCFF"><strong>Beneficiario</strong></td>
           <td width="90" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto Mov.</strong></td>
         </tr>
         <?php  $total=0;
//periodo, cod_banco, referencia, tipo_mov_libro, ced_rif, fecha_mov_libro,  monto_mov_libro, cod_presup, fuente_financ, cod_partida, cod_contable,monto_codigo, campo_str1, campo_str2, campo_num1, campo_num2,descrip_mov_libro
while($registro=pg_fetch_array($res)){ $sfecha=$registro["fecha_mov_libro"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); 
$montoc=formato_monto($registro["monto_codigo"]); $montom=formato_monto($registro["monto_mov_libro"]);  $descripcion=$registro["descrip_mov_libro"]; $descripcion=substr($descripcion,0,100);
$nombre=$registro["nombre"]; $nombre=substr($nombre,0,80);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="55" align="left"><?php  echo $registro["cod_banco"]; ?></td>
		   <td width="75" align="left"><?php  echo $registro["referencia"]; ?></td>
		   <td width="40" align="left"><?php  echo $registro["tipo_mov_libro"]; ?></td>
		   <td width="350" align="left"><?php  echo $descripcion; ?></td>
		   <td width="120" align="right"><?php  echo $montoc; ?></td>
		   <td width="130" align="left"><?php  echo $registro["cod_partida"]; ?></td>
		   <td width="130" align="left"><?php  echo $registro["cod_contable"]; ?></td>
           <td width="90" align="left"><?php  echo $registro["ced_rif"]; ?></td>
           <td width="280" align="left"><?php  echo $nombre; ?></td>
           <td width="90" align="left"><?php  echo $fecha; ?></td>
           <td width="120" align="right"><?php  echo $montom; ?></td>
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