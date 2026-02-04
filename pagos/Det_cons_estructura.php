<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Detalles Codigos de la Estructura)</title>
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>
<body>
 <table width="1065" border="0" cellspacing="0" cellpadding="0">
   <tr> <td>
<?php
//<div id="Layer1" style="position:absolute; width:910px; height:500px; z-index:1; top: 10px; left: 5px;">
if (!$_GET){$criterio='';$cod_estructura='';} else{$criterio=$_GET["criterio"];$cod_estructura=substr($criterio,0,8);}
$sql="SELECT * FROM COD_ESTRUCTURA  where cod_estructura='$cod_estructura' order by tipo_comp_est,ref_comp_est,cod_presup_est,fuente_est";
$res=pg_query($sql);
?>
       <table width="1060"  border="1" cellspacing='0' cellpadding='0' align="left" id="cod_estructura">
         <tr height="20" class="Estilo5">
           <td width="50" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Ref.Comp</strong></td>
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="370" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
		   <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Imputacion</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Referencia Cred.</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)){ $monto=$registro["monto_est"]; $monto=formato_monto($monto);
$total=$total+$registro["monto_est"]; $denominacion=$registro["denominacion"]; $denominacion=substr($denominacion,0,100);
$tipo_imput_presu=$registro["tipo_imput_presu"];  $ref_imput_presu=$registro["ref_imput_presu"];
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="50" align="left"><? echo $registro["tipo_comp_est"]; ?></td>
           <td width="80" align="left"><? echo $registro["ref_comp_est"]; ?></td>
           <td width="200" align="left"><? echo $registro["cod_presup_est"]; ?></td>
           <td width="40" align="left"><? echo $registro["fuente_est"]; ?></td>
           <td width="370" align="left"><? echo $denominacion; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
		    <td width="120" align="left"><? echo $tipo_imput_presu; ?></td>
           <td width="100" align="left"><? echo $ref_imput_presu; ?></td>
         </tr>
         <?} $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td>   </tr>
   <tr>
     <td><table width="842" border="0">
       <tr>
         <td width="123">&nbsp;</td>
         <td width="388">&nbsp;</td>
         <td width="132"><span class="Estilo5">TOTAL CODIGOS:</span></td>
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