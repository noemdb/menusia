<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$criterio='';$cod_empleado='';} else{$criterio=$_GET["criterio"];$cod_empleado=substr($criterio,0,15);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Detalles calculo Prestaciones)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
$sql="SELECT * FROM nom030  where cod_empleado='$cod_empleado' order by fecha_calculo,num_calculo,tipo_calculo"; $res=pg_query($sql);
?>
       <table width="1600"  border="1" cellspacing='0' cellpadding='0' align="left" id="cal_presta">
         <tr height="20" class="Estilo5">
           <td width="30" align="center" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="80" align="center" bgcolor="#99CCFF"><strong>Fecha</strong></td>
           <td width="40" align="center" bgcolor="#99CCFF"><strong>Dias</strong></td>
           <td width="40" align="center" bgcolor="#99CCFF"><strong>Adic.</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Monto</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Adelanto</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Saldo Prestaciones</strong></td>
           <td width="40" align="center" bgcolor="#99CCFF" ><strong>Tasa</strong></td>
           <td width="40" align="center" bgcolor="#99CCFF" ><strong>T. Var.</strong></td>
           <td width="130" align="center" bgcolor="#99CCFF" ><strong>Interes Dev.</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Pago Interes</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Interes no Acum.</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Interes Acum.</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Total Interes</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Total Acum.</strong></td>
          </tr>
<? while($registro=pg_fetch_array($res)){ $fecha_h=$registro["fecha_calculo"]; $fecha_h=formato_ddmmaaaa($fecha_h);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="30" align="left"><? echo $registro["tipo_calculo"]; ?></td>
           <td width="80" align="left"><? echo $fecha_h; ?></td>
           <td width="40" align="right"><? echo $registro["dias_prestaciones"]; ?></td>
           <td width="40" align="right"><? echo $registro["dias_adicionales"]; ?></td>
           <td width="150" align="right"><? echo formato_monto($registro["monto_prestaciones"]); ?></td>
           <td width="150" align="right"><? echo formato_monto($registro["monto_adelanto"]); ?></td>
           <td width="150" align="right"><? echo formato_monto($registro["saldo_prestaciones"]); ?></td>
           <td width="40" align="right"><? echo $registro["tasa_interes"]; ?></td>
           <td width="40" align="right"><? echo $registro["tiempo_variacion"]; ?></td>
           <td width="130" align="right"><? echo formato_monto($registro["interes_devengado"]); ?></td>
           <td width="150" align="right"><? echo formato_monto($registro["interes_pagado"]); ?></td>
           <td width="150" align="right"><? echo formato_monto($registro["interes_noacum"]); ?></td>
           <td width="150" align="right"><? echo formato_monto($registro["interes_acum"]); ?></td>
           <td width="150" align="right"><? echo formato_monto($registro["total_interes"]); ?></td>
           <td width="150" align="right"><? echo formato_monto($registro["acumulado_total"]); ?></td>
         </tr>
         <?}
?>
    </table></td>
   </tr>
   <tr>   <td>&nbsp;</td> </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close(); ?>