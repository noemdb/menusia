<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"]; }  $cedula=substr($criterio,0,10);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Carga cedula)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(tipo_nomina,cod_concepto,cod_empleado,cedula){var murl;
  if(cod_empleado==""){alert("Trabajador debe ser Seleccionado");}
  else{murl="Mod_carga_trab.php?tipo_nomina="+tipo_nomina+"&cod_concepto="+cod_concepto+"&cod_empleado="+cod_empleado+"&cedula="+cedula; document.location=murl;}
}
</script>

<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
       <?php

$sql="Select * from CONCEPTOS_ASIGNADOS where cedula='$cedula' ".$criterioc." and (statust='ACTIVO' or statust='PERMISO RE' or statust='REPOSO' or statust='VACACIONES' or statust='PERMISO NO') order by tipo_nomina,cod_empleado,cod_concepto";
$res=pg_query($sql); 
?>
       <table width="920"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="50" align="center" bgcolor="#99CCFF"><strong>N&oacute;mina</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>C&oacute;d.Trabajador</strong></td>
           <td width="40" align="center" bgcolor="#99CCFF"><strong>Conc.</strong></td>
           <td width="290" align="center" bgcolor="#99CCFF"><strong>Denominacion Concepto</strong></td>
           <td width="30" align="center" bgcolor="#99CCFF" ><strong>Act.</strong></td>
           <td width="30" align="center" bgcolor="#99CCFF" ><strong>Cal.</strong></td>
           <td width="170" align="center" bgcolor="#99CCFF" ><strong>Frecuencia</strong></td>
           <td width="80" align="center" bgcolor="#99CCFF" ><strong>Cantidad</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Monto</strong></td>
       </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)) {$frec=$registro["frecuencia"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"]; $cantidad=formato_monto($cantidad); $monto=formato_monto($monto);
if($frec=="1"){$frecuencia="PRIMERA QUINCENA";} if($frec=="2"){$frecuencia="SEGUNDA QUINCENA";} if($frec=="3"){$frecuencia="PRIMERA Y SEGUNDA QUINC.";}
if($frec=="4"){$frecuencia="PRIMERA SEMANA";} if($frec=="5"){$frecuencia="SEGUNDA SEMANA";} if($frec=="6"){$frecuencia="TERCERA SEMANA";}
if($frec=="7"){$frecuencia="CUARTA SEMANA";} if($frec=="8"){$frecuencia="TODAS LAS SEMANAS";} if($frec=="9"){$frecuencia="ULTIMA SEMANA";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $registro["tipo_nomina"]; ?>','<? echo $registro["cod_concepto"]; ?>','<? echo $registro["cod_empleado"]; ?>','<? echo $registro["cedula"]; ?>');" >
           <td width="50" align="left"><? echo $registro["tipo_nomina"]; ?></td>
           <td width="100" align="left"><? echo $registro["cod_empleado"]; ?></td>
           <td width="40" align="left"><? echo $registro["cod_concepto"]; ?></td>
           <td width="290" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="30" align="center"><? echo $registro["activoa"]; ?></td>
           <td width="30" align="center"><? echo $registro["calculable"]; ?></td>
           <td width="170" align="left"><? echo $frecuencia; ?></td>
           <td width="80" align="right"><? echo $cantidad; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
          </tr>
         <?} ?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td>  </tr>
 </table>
</body>
</html>

<?   pg_close(); ?>