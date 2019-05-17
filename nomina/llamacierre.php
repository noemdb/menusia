<?include ("../class/conect.php");  include ("../class/funciones.php"); $tipo_nomina=$_GET["tipo_nomina"]; $tp_calculo=$_GET["tp_calculo"]; $num_periodos=$_GET["num_periodos"]; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA NOMINA Y PERSONAL (Llama Cierre Nomina)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location='Cierre_nomina.php?'; }
</script>
</head>
<? if($tp_calculo=="N"){ $num_periodos=1; }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $existe_calculo="N";  $inf_orden_g="S"; $exist_vac="N"; $MDivisible=15; $carga_bono_vac="N";
$StrSQL="select fecha_p_desde,fecha_p_hasta from nom017 where (tipo_nomina='$tipo_nomina') and (tp_calculo='$tp_calculo') and (num_periodos=$num_periodos) "; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $existe_calculo="S"; $fecha_desde=$registro["fecha_p_desde"]; $fecha_hasta=$registro["fecha_p_hasta"]; $fechah=$registro["fecha_p_hasta"]; $fecha_desde=formato_ddmmaaaa($fecha_desde); $fecha_hasta=formato_ddmmaaaa($fecha_hasta);}
if($existe_calculo=="S"){ $StrSQL="select bloqueada,bloqueada_ext,g_orden_pago,frecuencia from nom001 where (tipo_nomina='$tipo_nomina')"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); if($registro["frecuencia"]=="M"){$MDivisible=30;} if($registro["frecuencia"]=="S"){$MDivisible=7;} $g_orden_pago=$registro["g_orden_pago"]; $bloqueada=$registro["bloqueada"]; $bloqueada_ext=$registro["bloqueada_ext"];
if($tp_calculo=="N"){if(($g_orden_pago=="S") And ($bloqueada!="S")){$inf_orden_g="N";}}else{if(($g_orden_pago=="S") And ($bloqueada_ext!="S")){$inf_orden_g="N"; $inf_orden_g="S";}}}
if($tp_calculo=="N"){ $campo502="NNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo535  from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];} $proc_vac_nom=substr($campo502,5,1); if(substr($campo502,15,1)=="N"){$carga_bono_vac="S";}
$sSQL="Select cod_empleado,fecha_reincorp FROM NOM024 Where (fecha_reincorp<='$fechah') And (NOM024.cod_empleado IN (SELECT NOM006.cod_empleado FROM NOM006 Where tipo_nomina='$'tipo_nomina))";$resultado=pg_query($sSQL);$filas=pg_num_rows($resultado); if($filas>=1){$exist_vac="S";}}
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="00";}else{$temp_nomina=$gnomina; $tipo_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
}
pg_close();?>
<body>
<form name="form1" method="post" >
  <table width="560" height="360" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="560" height="360" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CERRAR NOMINA</span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
        <tr> <td>&nbsp;</td> </tr>
        <tr> <td align="center" >POR FAVOR ESPERE CERRANDO NOMINA ....</td> </tr>
        <tr> <td><p>&nbsp;</p></td> </tr>
        <tr> <td><p>&nbsp;</p></td> </tr>
      </table>
    </tr>
  </table>
</form>
</body>
<script language="JavaScript" type="text/JavaScript">
var mexiste_calculo='<?php echo $existe_calculo ?>';
var minf_orden_g='<?php echo $inf_orden_g ?>';
var mexist_vac='<?php echo $exist_vac ?>';
var mtipo='<?php echo $tipo_nomina ?>';
var mtp_cal='<?php echo $tp_calculo ?>';
var mcar_bonov='<?php echo $carga_bono_vac ?>';
var mdiv='<?php echo $MDivisible ?>';
var mtemp_nomina='<?php echo $temp_nomina ?>';
var mnum_per='<?php echo $num_periodos ?>';
var mvalido=true;
if(mexiste_calculo=="N"){alert('Nomina No ha sido Calculada'); mvalido=false; }
if(minf_orden_g=="N"){alert('Informacion Orden de pago No Generada'); mvalido=false; }
if(mexist_vac=="S"){alert('Existen Trabajadores en Vacaciones, los Cuales deben ser Retornados'); mvalido=false; }
if(mtemp_nomina!="00"){ if(mtemp_nomina!=mtipo){alert("TIPO DE NOMINA NO ACTIVA PARA EL USUARIO");mvalido=false;}  }
if(mvalido==true){ url="registra_cierre.php?tipo_nomina="+mtipo+'&tp_calculo='+mtp_cal+'&num_periodos='+mnum_per+'&carga_bono_vac='+mcar_bonov; document.location=url; } else{window.close();}
</script>
</html>