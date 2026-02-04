<?include ("../../class/conect.php");  include ("../../class/funciones.php");
if (!$_GET){ $cod_empleado='';} else{$cod_empleado=$_GET["txtcod_empleado"];}   $sql="Select * FROM CALCULO_VACACIONES where (cod_empleado='$cod_empleado')";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Calculo de Vacaciones)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type="text/css" rel=stylesheet>
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<style type="text/css">
<!--
.Estilo16 {font-family: Arial, Helvetica, sans-serif;        font-size: 18pt;}
.Estilo17 {font-size: 8pt}
.Estilo18 {font-size: 10pt}
-->
</style>
</head>
<?
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$nombre=""; $cedula=""; $fecha_ingreso=""; $fecha_caus_hasta=""; $fecha_caus_desde=""; $denominacion=""; $cod_concepto_v=""; $fecha_d_desde=""; $fecha_d_hasta="";
$dias_habiles=0; $dias_no_habiles=0; $fecha_d_desde=""; $fecha_d_hasta=""; $fecha_reincorp=""; $dias_bono_vac=0; $monto_bono_vac=0; $dias_disfrutados=0; $inf_usuario="";
 $calcula_nomina="NO"; $fecha_cal_d=""; $fecha_cal_h=""; $des_cargo=""; $des_departamento=""; $monto_concepto=0; $des_nomina=""; $tipo_nomina="";

$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
   $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_caus_hasta=$registro["fecha_caus_hasta"]; $fecha_caus_desde=$registro["fecha_caus_desde"]; $fecha_caus_desde=formato_ddmmaaaa($fecha_caus_desde);  $fecha_caus_hasta=formato_ddmmaaaa($fecha_caus_hasta);
  $cod_concepto_v=$registro["cod_concepto_v"]; $dias_habiles=$registro["dias_habiles"]; $dias_no_habiles=$registro["dias_no_habiles"]; $tipo_nomina=$registro["tipo_nomina"];
  $fecha_d_desde=$registro["fecha_desde"]; $fecha_d_hasta=$registro["fecha_hasta"]; $fecha_reincorp=$registro["fecha_reincorp"]; 
  $fecha_d_desde=formato_ddmmaaaa($fecha_d_desde); $fecha_d_hasta=formato_ddmmaaaa($fecha_d_hasta);  $fecha_reincorp=formato_ddmmaaaa($fecha_reincorp); 
  $dias_bono_vac=$registro["dias_bono_vaca"]; $monto_bono_vac=$registro["monto_bono_vaca"]; $calcula_nomina=$registro["calcula_nomina"];
  $fecha_cal_d=$registro["fecha_calculo_d"]; $fecha_cal_h=$registro["fecha_calculo_h"]; $fecha_cal_d=formato_ddmmaaaa($fecha_cal_d);  $fecha_cal_h=formato_ddmmaaaa($fecha_cal_h);
  $des_cargo=$registro["des_cargo"]; $des_departamento=$registro["des_departamento"]; $monto_concepto=$registro["monto_concepto_v"]; $usuario_vac=$registro["usuario_sia"];
}
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$des_nomina=$registro["descripcion"];}

$mperiodo=substr($fecha_caus_desde,6,4)."-".substr($fecha_caus_hasta,6,4);
$dias1=15; $dias2=$dias_habiles-$dias1; $mdia=$monto_bono_vac/$dias_bono_vac; $mmensual=$mdia*30;
$mmensual=$monto_concepto; $mdia=$monto_concepto/30;$mdia=formato_monto($mdia); $mmensual=formato_monto($mmensual);
$sql="select * from sia001 where campo101='$usuario_vac'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}

?>
<body>
<table width="981" height="292" border="0" cellpadding="0" cellspacing="0">
<tr><td height="291"><table width="980" border="0"  height="291" cellpadding="0" cellspacing="0">
  <tr><td height="90" colspan="4"><table width="980" border="0" cellpadding="3" cellspacing="1" height="90">
    <tr>
      <td height="67" colspan="4"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Encabezado_rpt_recibo.png" width="970"></div></td>
    </tr>
  </table></td>
  </tr>
  <tr><td>&nbsp;</td> </tr>
  <tr><td height="40" colspan="4"><table width="980" border="0"  height="40">
    <tr>
      <td width="980" height="32" align="center"><span class="Estilo16">RECIBO CALCULO DE VACACIONES</span></td>
        </tr>
    </table></td>
  </tr>
  <tr><td>&nbsp;</td> </tr>
  <tr><td height="25"><table width="1006" border="0"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="150"><span class="Estilo17"><strong>Apellidos y Nombres:</strong></span></td>
            <td width="470"><span class="Estilo17"><?echo $nombre?></span></td>
			<td width="60"><span class="Estilo17"><strong>Cedula:</strong></span></td>
			<td width="100"><span class="Estilo17"><?echo $cedula?></span></td>
			<td width="110"><span class="Estilo17"><strong>Fecha Ingreso:</strong></span></td>
			<td width="90"><span class="Estilo17"><?echo $fecha_ingreso?></span></td>
          </tr>
      </table></td>
    </tr>
    </table></td>
  </tr>

   <tr><td height="25" ><table width="1006" border="0"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="60"><span class="Estilo17"><strong>Cargo:</strong></span></td>
            <td width="650"><span class="Estilo17"><?echo $des_cargo?></span></td>
			<td width="150"><span class="Estilo17"><strong>Periodo de Disfrute:</strong></span></td>
			<td width="100"><span class="Estilo17"><?echo $mperiodo?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="0"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="90"><span class="Estilo17"><strong>Adscripcion:</strong></span></td>
            <td width="520"><span class="Estilo17"><?echo $des_departamento?></span></td>
			<td width="150"><span class="Estilo17"><strong>Tipo de Nomina:</strong></span></td>
			<td width="200"><span class="Estilo17"><?echo $des_nomina?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  
  <tr><td height="25" ><table width="1006" border="0"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="200"><span class="Estilo17"><strong>Fecha de Disfrute Desde :</strong></span></td>
            <td width="100"><span class="Estilo17"><?echo $fecha_d_desde?></span></td>
			<td width="60"><span class="Estilo17"><strong>Hasta:</strong></span></td>
			<td width="240"><span class="Estilo17"><?echo $fecha_d_hasta?></span></td>			
			<td width="180"><span class="Estilo17"><strong>Fecha a Reincorporase :</strong></span></td>
            <td width="200"><span class="Estilo17"><?echo $fecha_reincorp?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>

  <tr><td height="25" ><table width="1006" border="0"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="150"><span class="Estilo17"><strong>Dias de Vacaciones :</strong></span></td>
            <td width="100"><span class="Estilo17"><?echo $dias1?></span></td>
			<td width="150"><span class="Estilo17"><strong>Dias Adicionales :</strong></span></td>
			<td width="200"><span class="Estilo17"><?echo $dias2?></span></td>			
			<td width="280"><span class="Estilo17"><strong>Dias Feriados, Sabados y Domingos :</strong></span></td>
            <td width="100"><span class="Estilo17"><?echo $dias_no_habiles ?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="0"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="230"><span class="Estilo17"><strong>Salario Basico para Vacaciones :</strong></span></td>
            <td width="100"><span class="Estilo17"><?echo $mmensual?></span></td>
			<td width="100"><span class="Estilo17"><strong>Salario Diario :</strong></span></td>
			<td width="200"><span class="Estilo17"><?echo $mdia?></span></td>			
			<td width="200"><span class="Estilo17"></span></td>
            <td width="130"><span class="Estilo17"></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td>&nbsp;</td> </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="60" align="left"><span class="Estilo17">CODIGO</span></td>
	  <td width="540" align="left"><span class="Estilo17">DESCRIPCION DEL CONCEPTO</span></td>
      <td width="100" align="center"><span class="Estilo17">CANTIDAD</span></td>
      <td width="140" align="center"><span class="Estilo17">ASIGNACION</span></td>
	  <td width="140" align="center"><span class="Estilo17">DEDUCCION</span></td>
    </tr>
<? $total=0; $totala=0; $totald=0;
$sql="SELECT cod_concepto,denominacion,asig_ded_apo,sum(monto) as monto,sum(cantidad) as cantidad FROM NOM023 where (oculto='NO') and (cod_empleado='$cod_empleado') group by cod_concepto,denominacion,asig_ded_apo order by cod_concepto";
$res=pg_query($sql); $filas=pg_num_rows($res);
while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto"]);
$asig_ded_apo=$registro["asig_ded_apo"]; $asignacion=""; $deduccion=""; $cantidad=$registro["cantidad"];
if($asig_ded_apo=="A"){ $total=$total+$registro["monto"]; $totala=$totala+$registro["monto"]; $asignacion=$monto;} if($asig_ded_apo=="D"){ $totald=$totald+$registro["monto"];  $cantidad=""; $total=$total-$registro["monto"]; $deduccion=$monto;}
?>
    <tr>
      <td width="60" align="left"><span class="Estilo17"><? echo $registro["cod_concepto"]; ?></span></td>
	  <td width="540" align="left"><span class="Estilo17"><? echo $registro["denominacion"]; ?></span></td>  
      <td width="100" align="center"><span class="Estilo17"><? echo $cantidad; ?></span></td>
      <td width="140" align="right"><span class="Estilo17"><? echo $asignacion; ?></span></td>
	  <td width="140" align="right"><span class="Estilo17"><? echo $deduccion; ?></span></td>
    </tr>
<?}$total=formato_monto($total); $totala=formato_monto($totala); $totald=formato_monto($totald); ?>
    <tr>
	  <td width="60" align="center"><span class="Estilo17"></span></td>
      <td width="540" align="right"><span class="Estilo17"><? echo "TOTALES"; ?></span></td>
      <td width="100" align="center"><span class="Estilo17"></span></td>
      <td width="140" align="right"><span class="Estilo17"><? echo $totala; ?></span></td>
	  <td width="140" align="right"><span class="Estilo17"><? echo $totald; ?></span></td>
    </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td height="25"><table width="994" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="980" align="center"><span class="Estilo18"><strong>NETO A COBRAR : <?echo $total?></strong></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td>&nbsp;</td> </tr>
  <tr><td>&nbsp;</td> </tr>
  <tr><td>&nbsp;</td> </tr>
  <tr><td>&nbsp;</td> </tr>
  
  <tr><td height="25" ><table width="1006" border="0"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="320" align="center"><span class="Estilo17">ELABORADO POR</span></td>
      <td width="330" align="center"><span class="Estilo17">APROBADO POR</span></td>
	  <td width="330" align="center"><span class="Estilo17">RECIBE CONFORME</span></td>
    </tr>
	<tr>
      <td width="320" align="center"  height="100">&nbsp;</td>
      <td width="330" align="center">&nbsp;</td>
	  <td width="330" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td width="320" align="center"><span class="Estilo17">ANALISTA</span></td>
      <td width="330" align="center"><span class="Estilo17">GERENCIA DE CAPITAL HUMANO</span></td>
	  <td width="330" align="center"><span class="Estilo17"><?echo $nombre?></span></td>
    </tr>
	 <tr>
      <td width="320" align="center"><span class="Estilo17"><?echo $nomb_usuario_comp?></span></td>
      <td width="330" align="center"><span class="Estilo17"></span></td>
	  <td width="330" align="center"><span class="Estilo17"><?echo $cedula?></span></td>
    </tr>
  </table></td></tr>
  
  <tr><td>&nbsp;</td></tr>
</table></td></tr>
</table>