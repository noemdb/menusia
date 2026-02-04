<?include ("../class/conect.php");  include ("../class/funciones.php");$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}  $tipo_nomina=substr($criterio,0,2);$cod_concepto=substr($criterio,2,3);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Carga Manual)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(tipo_nomina,cod_concepto,cod_empleado){var murl;
  if(cod_empleado==""){alert("Trabajador debe ser Seleccionado");}
  else{murl="Mod_prestamo.php?tipo_nomina="+tipo_nomina+"&cod_concepto="+cod_concepto+"&cod_empleado="+cod_empleado; document.location=murl;}
}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
$sql="Select * from CONCEPTOS_ASIGNADOS where tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' ".$criterioc." and (statust='ACTIVO' or statust='REPOSO' or statust='PERMISO RE' or statust='VACACIONES' or statust='PERMISO NO') and (prestamo='S') order by cod_empleado"; $res=pg_query($sql);
?>
       <table width="1370"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="300" align="center" bgcolor="#99CCFF"><strong>Nombre Trabajador</strong></td>
           <td width="30" align="center" bgcolor="#99CCFF" ><strong>Act.</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Monto Cuota</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Cuotas</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Monto Prestamo</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Acumulado</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Saldo</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>C.Canc.</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>F. Desde</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>F. Hasta</strong></td>
           <td width="170" align="center" bgcolor="#99CCFF" ><strong>Frecuencia</strong></td>
       </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)) {$frec=$registro["frecuencia"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"]; $cantidad=formato_monto($cantidad); $monto=formato_monto($monto);
 $acumulado=$registro["acumulado"]; $saldo=$registro["saldo"]; $prestamo=$registro["prestamo"]; $monto_prestamo=$registro["monto_prestamo"]; $nro_cuotas=$registro["nro_cuotas"]; $nro_cuotas_c=$registro["nro_cuotas_c"];
 $acumulado=formato_monto($acumulado); $saldo=formato_monto($saldo);  $monto_prestamo=formato_monto($monto_prestamo);  $nro_cuotas=intval($nro_cuotas); $nro_cuotas_c=intval($nro_cuotas_c);
if($frec=="1"){$frecuencia="PRIMERA QUINCENA";} if($frec=="2"){$frecuencia="SEGUNDA QUINCENA";} if($frec=="3"){$frecuencia="PRIMERA Y SEGUNDA QUINC.";}
if($frec=="4"){$frecuencia="PRIMERA SEMANA";} if($frec=="5"){$frecuencia="SEGUNDA SEMANA";} if($frec=="6"){$frecuencia="TERCERA SEMANA";}
if($frec=="7"){$frecuencia="CUARTA SEMANA";} if($frec=="8"){$frecuencia="TODAS LAS SEMANAS";} if($frec=="9"){$frecuencia="ULTIMA SEMANA";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $registro["tipo_nomina"]; ?>','<? echo $registro["cod_concepto"]; ?>','<? echo $registro["cod_empleado"]; ?>');" >
           <td width="100" align="left"><? echo $registro["cod_empleado"]; ?></td>
           <td width="300" align="left"><? echo $registro["nombre"]; ?></td>
           <td width="30" align="center"><? echo $registro["activoa"]; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
           <td width="50" align="right"><? echo $nro_cuotas; ?></td>
           <td width="120" align="right"><? echo $monto_prestamo; ?></td>
           <td width="120" align="right"><? echo $acumulado; ?></td>
           <td width="120" align="right"><? echo $saldo; ?></td>
           <td width="50" align="right"><? echo $nro_cuotas_c; ?></td>
           <td width="100" align="center"><? echo formato_ddmmaaaa($registro["fecha_ini"]); ?></td>
           <td width="100" align="center"><? echo formato_ddmmaaaa($registro["fecha_exp"]); ?></td>
           <td width="170" align="center"><? echo $frecuencia; ?></td>
          </tr>
         <?} ?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td>  </tr>
 </table>
</body>
</html>
<? pg_close(); ?>