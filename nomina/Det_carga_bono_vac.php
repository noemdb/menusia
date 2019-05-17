<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($gnomina=="00"){ $criterion=""; $criterioc="  "; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and (tipo_nomina='$gnomina') ";}
if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}  $tipo_nomina=substr($criterio,0,2);$cod_concepto=substr($criterio,2,3);  $tipof=substr($criterio,5,1); $filtro=substr($criterio,6,50); $swhere="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Carga Manual)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
$sql="Select * from CONCEPTOS_ASIGNADOS where (tipo_nomina='$tipo_nomina') and (monto>0) and (cod_concepto='$cod_concepto')  ".$criterioc." and (statust='ACTIVO' or statust='PERMISO RE' or statust='VACACIONES' or statust='PERMISO NO' or statust='REPOSO') ". $swhere." Order by cod_empleado";
$res=pg_query($sql);
?>
       <table width="920"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="80" align="center" bgcolor="#99CCFF"><strong>Cedula</strong></td>
           <td width="300" align="center" bgcolor="#99CCFF"><strong>Nombre Trabajador</strong></td>
           <td width="30" align="center" bgcolor="#99CCFF" ><strong>Act.</strong></td>
           <td width="30" align="center" bgcolor="#99CCFF" ><strong>Cal.</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Fecha Ingreso</strong></td>
           <td width="80" align="center" bgcolor="#99CCFF" ><strong>Cantidad</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Monto</strong></td>
       </tr>
<? $total=0;
while($registro=pg_fetch_array($res)) {$frec=$registro["frecuencia"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"]; $cantidad=formato_monto($cantidad); $monto=formato_monto($monto);
if($frec=="1"){$frecuencia="PRIMERA QUINCENA";} if($frec=="2"){$frecuencia="SEGUNDA QUINCENA";} if($frec=="3"){$frecuencia="PRIMERA Y SEGUNDA QUINC.";}
if($frec=="4"){$frecuencia="PRIMERA SEMANA";} if($frec=="5"){$frecuencia="SEGUNDA SEMANA";} if($frec=="6"){$frecuencia="TERCERA SEMANA";}
if($frec=="7"){$frecuencia="CUARTA SEMANA";} if($frec=="8"){$frecuencia="QUINTA SEMANA";} if($frec=="9"){$frecuencia="TODAS LAS SEMANAS";} if($frec=="0"){$frecuencia="ULTIMA SEMANA";}
$fecha_ingreso=$registro["fecha_ingreso"]; $fecha_ing=formato_ddmmaaaa($fecha_ingreso); 
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $registro["tipo_nomina"]; ?>','<? echo $registro["cod_concepto"]; ?>','<? echo $registro["cod_empleado"]; ?>','<? echo $tipof.$filtro; ?>');" >
           <td width="100" align="left"><? echo $registro["cod_empleado"]; ?></td>
           <td width="80" align="left"><? echo $registro["cedula"]; ?></td>
           <td width="300" align="left"><? echo $registro["nombre"]; ?></td>
           <td width="30" align="center"><? echo $registro["activoa"]; ?></td>
           <td width="30" align="center"><? echo $registro["calculable"]; ?></td>
           <td width="5" align="center"><? echo $fecha_ing; ?></td>
           <td width="80" align="right"><? echo $cantidad; ?></td>
           <td width="120" align="right"><? echo $monto; ?></td>
          </tr>
         <?} ?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td>  </tr>
 </table>
</body>
</html>
<?   pg_close(); ?>
