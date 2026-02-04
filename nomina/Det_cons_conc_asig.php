<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&oacute;MINA Y PERSONAL (Detalles Hoja de Vida)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php if (!$_GET){$cod_empleado='';} else{$cod_empleado=$_GET["cod_empleado"];}
$sql="SELECT * FROM CONCEPTOS_ASIGNADOS where cod_empleado='$cod_empleado' order by cod_concepto"; $res=pg_query($sql);
?>
       <table width="820"  border="1" cellspacing='0' cellpadding='0' align="left" id="conc_trab">
         <tr height="20" class="Estilo5">
           <td width="60" align="center" bgcolor="#99CCFF"><strong>Concepto</strong></td>
           <td width="300" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="40" align="center" bgcolor="#99CCFF"><strong>Activo</strong></td>
           <td width="40" align="center" bgcolor="#99CCFF"><strong>Cal.</strong></td>
           <td width="170" align="center" bgcolor="#99CCFF"><strong>Frecuencia</strong></td>
           <td width="90" align="right" bgcolor="#99CCFF"><strong>Cantidad</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF"><strong>Monto</strong></td>
           </tr>
<? while($registro=pg_fetch_array($res)){ $frec=$registro["frecuencia"]; $monto=formato_monto($registro["monto"]); $cantidad=formato_monto($registro["cantidad"]); $frecuencia="PRIMERA Y SEGUNDA QUINCENA";
if($frec=="1"){$frecuencia="PRIMERA QUINCENA";} if($frec=="2"){$frecuencia="SEGUNDA QUINCENA";} if($frec=="3"){$frecuencia="PRIMERA Y SEGUNDA QUINC.";}
if($frec=="4"){$frecuencia="PRIMERA SEMANA";} if($frec=="5"){$frecuencia="SEGUNDA SEMANA";} if($frec=="6"){$frecuencia="TERCERA SEMANA";}
if($frec=="7"){$frecuencia="CUARTA SEMANA";} if($frec=="8"){$frecuencia="TODAS LAS SEMANAS";} if($frec=="9"){$frecuencia="ULTIMA SEMANA";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="60" align="left"><? echo $registro["cod_concepto"]; ?></td>
           <td width="300" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="40" align="center"><? echo $registro["activoa"]; ?></td>
           <td width="40" align="center"><? echo $registro["calculable"]; ?></td>
           <td width="170" align="left"><? echo $frecuencia; ?></td>
           <td width="90" align="right"><? echo $cantidad; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
           </tr>
         <?}?>
       </table></td>
   </tr>
 </table>
</body>
</html>
<?
  pg_close();
?>