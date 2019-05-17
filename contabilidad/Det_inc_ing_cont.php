<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTROL DE INGRESOS  (Detalles Codigos de Ingresos)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="845">
<?if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"]; }         
$sql="SELECT * FROM COD_DET_ING where codigo_mov='$codigo_mov' order by cod_presup";$res=pg_query($sql); ?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="cod_ingresos">
         <tr height="20" class="Estilo5">
		   <td width="200"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="400" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
		   <td width="140" align="center" bgcolor="#99CCFF"><strong>Cod. Contable</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=formato_monto($registro["monto_mov"]); $total=$total+$registro["monto_mov"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="200" align="left"><? echo $registro["cod_presup"]; ?></td>
           <td width="400" align="left"><? echo $registro["nombre"]; ?></td>
		   <td width="100" align="right"><? echo $monto; ?></td>     
           <td width="140" align="left"><? echo $registro["codigo_contable"]; ?></td>
               </tr>
         <?}
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
             <td align="right" class="Estilo5"><? echo $total; ?></td>
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