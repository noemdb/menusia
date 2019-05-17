<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $fecha_ley="19/06/2007";
$cod_empleado=$_POST["txtcod_empleado"];$fecha_calculo=$_POST["txtfecha_calculo"]; $fecha_ingreso=$_POST["txtfecha_calculo"];
$sueldo_calculo=$_POST["txtsueldo_calculo"]; $sueldo_calculo=formato_numero($sueldo_calculo); if(is_numeric($sueldo_calculo)){$sueldo_calculo=$sueldo_calculo;}else{$sueldo_calculo=0;}
$dias_prestaciones=$_POST["txtdias_prestaciones"];  $dias_prestaciones=formato_numero($dias_prestaciones); if(is_numeric($dias_prestaciones)){$dias_prestaciones=$dias_prestaciones;}else{$dias_prestaciones=0;}
$sueldo_calculo_adic=$_POST["txtsueldo_calculo_adic"]; $sueldo_calculo_adic=formato_numero($sueldo_calculo_adic); if(is_numeric($sueldo_calculo_adic)){$sueldo_calculo_adic=$sueldo_calculo_adic;}else{$sueldo_calculo_adic=0;}
$dias_adicionales=$_POST["txtdias_adicionales"];  $dias_adicionales=formato_numero($dias_adicionales); if(is_numeric($dias_adicionales)){$dias_adicionales=$dias_adicionales;}else{$dias_adicionales=0;}
$total_prestaciones=$_POST["txttotal_prestaciones"]; $total_prestaciones=formato_numero($total_prestaciones); if(is_numeric($total_prestaciones)){$total_prestaciones=$total_prestaciones;}else{$total_prestaciones=0;}
$total_adelanto=$_POST["txttotal_adelanto"];  $total_adelanto=formato_numero($total_adelanto); if(is_numeric($total_adelanto)){$total_adelanto=$total_adelanto;}else{$total_adelanto=0;}
$acumulado_total=$_POST["txtacumulado_total"]; $acumulado_total=formato_numero($acumulado_total); if(is_numeric($acumulado_total)){$acumulado_total=$acumulado_total;}else{$acumulado_total=0;}

$interes_devengado=$_POST["txtinteres_devengado"];  $interes_devengado=formato_numero($interes_devengado); if(is_numeric($interes_devengado)){$interes_devengado=$interes_devengado;}else{$interes_devengado=0;}
$interes_noacum=$_POST["txtinteres_noacum"];  $interes_noacum=formato_numero($interes_noacum); if(is_numeric($interes_noacum)){$interes_noacum=$interes_noacum;}else{$interes_noacum=0;}


$interes_pagado=$_POST["txtinteres_pagado"];  $interes_pagado=formato_numero($interes_pagado); if(is_numeric($interes_pagado)){$interes_pagado=$interes_pagado;}else{$interes_pagado=0;}

$total_interes=$_POST["txttotal_interes"];  $total_interes=formato_numero($total_interes); if(is_numeric($total_interes)){$total_interes=$total_interes;}else{$total_interes=0;}


$saldo_prestaciones668=0; $total_interes668=0;
//$saldo_prestaciones668=$_POST["txtsaldo_prestaciones668"]; $saldo_prestaciones668=formato_numero($saldo_prestaciones668); if(is_numeric($saldo_prestaciones668)){$saldo_prestaciones668=$saldo_prestaciones668;}else{$saldo_prestaciones668=0;}
//$total_interes668=$_POST["txttotal_interes668"];  $total_interes668=formato_numero($total_interes668); if(is_numeric($total_interes668)){$total_interes668=$total_interes668;}else{$total_interes668=0;}
$saldo_prestaciones=$total_prestaciones-$total_adelanto; $acumulado_total=$saldo_prestaciones+$total_interes; $total668=$saldo_prestaciones668+$total_interes668;
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_saldo_prestaciones.php?Gcodigo=C".$cod_empleado;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select cod_empleado from NOM030 WHERE cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR TIENE SALDO DE PRESTACIONES');</script><? }
  if($error==0){if(checkData($fecha_calculo)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CALCULO NO ES VALIDA');</script><? }}
  if($error==0){$sql="SELECT NOM006.cod_empleado,NOM006.tipo_nomina,NOM006.fecha_ingreso,NOM006.cod_categoria FROM NOM006 Where cod_empleado='$cod_empleado'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado); if($filas==0){$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? }
    else{$registro=pg_fetch_array($resultado); $fecha_ingreso=$registro["fecha_ingreso"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso); }  }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);   $fechac=formato_aaaammdd($fecha_calculo);
     $sSQL="SELECT ACTUALIZA_NOM030(1,'$cod_empleado','$fechac','1','S',$sueldo_calculo,$dias_prestaciones,0,$sueldo_calculo_adic,$dias_adicionales,0,0,$total_prestaciones,0,$total_adelanto,0,0,$saldo_prestaciones,0,$interes_noacum,$interes_devengado,$interes_pagado,$total_interes,0,0,$acumulado_total)";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?
     $numf1=fdate($fecha_ingreso);  $numf2=fdate($fecha_ley); if(($numf1<$numf2)and($saldo_prestaciones668>0)){$sSQL="SELECT ACTUALIZA_NOM075(1,'$cod_empleado','$fechac','1','S',$saldo_prestaciones668,$saldo_prestaciones668,0,0,$total_interes668,0,$total_interes668,0,0,$total668)"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); } } }
}
pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>