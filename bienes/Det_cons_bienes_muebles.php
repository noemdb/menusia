<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA BIENES NACIONALES (Detalles Bienes Muebles)</title>
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
       <?php
//<div id="Layer1" style="position:absolute; width:910px; height:500px; z-index:1; top: 10px; left: 5px;">

if (!$_GET){$criterio='';$referencia_transf='';}
 else{$criterio=$_GET["criterio"];$referencia_transf=substr($criterio,0,12);
}
//print_r($criterio);print_r($referencia_transf);
$sql="SELECT * FROM DET_TRANSF_BIEN_MUE where referencia_transf='$referencia_transf' order by referencia_transf";
$res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>Código Bien</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF"><strong>Denominación</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto"]; $monto=formato_monto($monto);$total=$total+$registro["monto"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<? echo $codigo_mov; ?>','<? echo $registro["cod_bien_mue"]; ?>');">
           <td width="200" align="left"><? echo $registro["cod_bien_mue"]; ?></td>
           <td width="500" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
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
<?
  pg_close();
?>
