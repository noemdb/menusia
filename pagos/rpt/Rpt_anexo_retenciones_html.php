<?include ("../../class/conect.php");  include ("../../class/funciones.php");
if (!$_GET){ $nro_orden="";$tipo_causado=""; } else{$nro_orden=$_GET["txtnro_orden"];  $tipo_causado=$_GET["txttipo_causado"];}
$sql="Select * from ORD_PAGO where tipo_causado='$tipo_causado' and nro_orden='$nro_orden'";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Formato Anexo Cheque)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
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
.Estilo16 {        font-family: Arial, Helvetica, sans-serif;        font-size: 18pt;}
.Estilo17 {font-size: 8pt}
.Estilo18 {font-size: 10pt}
-->
</style>
</head>
<?  $rif_emp="G-20009014-6";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$concepto="";$fecha="";$nombre_abrev_caus=""; $ced_rif="";$nombre="";$inf_usuario="";$anulado="";  $tipo_documento="";  $nro_documento=""; $afecta_presu=""; $status_1=""; $usuario_sia="";
$res=pg_query($sql); $filas=pg_num_rows($res); $total_neto=0;
if($filas>0){  $registro=pg_fetch_array($res); $nro_orden=$registro["nro_orden"];   $tipo_causado=$registro["tipo_causado"];
  $fecha=$registro["fecha"];  $concepto=$registro["concepto"]; $afecta_presu=$registro["afecta_presu"]; $status_1=$registro["status_1"];
  $inf_usuario=$registro["inf_usuario"];  $nombre_abrev_caus=$registro["nombre_abrev_caus"];
  $ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];  $func_inv=$registro["func_inv"];
  $anulado=$registro["anulado"];  $pago_ces=$registro["pago_ces"];  $ced_rif_ces=$registro["ced_rif_ces"]; $usuario_sia=$registro["usuario_sia"];
  $nombre_ces=$registro["nombre_ces"];  $tipo_documento=$registro["tipo_documento"];  $nro_documento=$registro["nro_documento"];
  $total_causado=$registro["total_causado"];  $total_retencion=$registro["total_retencion"];
  $total_ajuste=$registro["total_ajuste"];  $total_pasivos=$registro["total_pasivos"];  $monto_am_ant=$registro["monto_am_ant"];
  $total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant + $total_pasivos;
} $tipo_comp='O'.$tipo_causado; $sfecha=$fecha; $referencia=$nro_orden;
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);} $total_neto=formato_monto($total_neto);
if($afecta_presu=="S"){$nchk='checked'; $schk='';}else{$nchk='';$schk='checked';}
$sql="SELECT * FROM codigos_causados where tipo_causado='$tipo_causado' and referencia_caus='$nro_orden' order by cod_presup";$res=pg_query($sql);$filas=pg_num_rows($res); $tipo_compromiso=""; $fuente_financ=""; $referencia_comp="";
if($filas>0){  $registro=pg_fetch_array($res); $tipo_compromiso=$registro["tipo_compromiso"]; $fuente_financ=$registro["fuente_financ"]; $referencia_comp=$registro["referencia_comp"]; }
$sql="SELECT * FROM PAG016  where nro_orden='$nro_orden' order by nro_factura";$res=pg_query($sql); $cant_fact=pg_num_rows($res);
$firma="PRESUPUESTO";if(($afecta_presu=="N")and($status_1=="S")){$firma="CONTABILIDAD";}
if(substr($tipo_causado,0,1)=='A'){$referencia='A'.substr($nro_orden,1,7);}
$monto_letras= monto_en_letras($total_neto);
$usuario_comp=$usuario_sia;
$sql="select * from sia001 where campo101='$usuario_comp'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}


?>
<body>
<table width="981" height="292" border="1" cellpadding="0" cellspacing="0">
<tr><td height="291"><table width="980" border="0"  height="291" cellpadding="0" cellspacing="0">
  <td width="673"><div id="Layer2" style="position:absolute; width:118px; height:127px; z-index:2; left: 16px; top: 10px;"><img src="../../imagenes/Logo_empresa.gif" width="115" height="122" border="0"></div>

  <tr><td height="90" colspan="4"><table width="980" border="0" cellpadding="3" cellspacing="1" height="90">
    <tr>
      <td width="150" align="center">&nbsp;</td>
      <td width="30"><span class="Estilo18">RIF:</span></td>
      <td width="150"><span class="Estilo18"><?echo $rif_emp?></span></td>
      <td width="650" align="center">&nbsp;</td>
    </tr>
  </table></td>

  </tr>
  <tr><td height="40" colspan="4"><table width="980" border="0"  height="40">
    <tr>
      <td width="960" height="32" align="center"><span class="Estilo16">ANEXO RETENCIONES </span></td>
      <td width="20" align="center">&nbsp;</td>
     </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="200"><span class="Estilo17">NUMERO DE ORDEN:</span></td>
            <td width="200"><span class="Estilo17"><?echo $nro_orden?></span></td>
            <td width="80"><span class="Estilo17">FECHA:</span></td>
            <td width="320"><span class="Estilo17"><?echo $fecha?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="760" height="25"><table width="760" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">BENEFICIARIO:</span></td>
            <td width="660"><span class="Estilo17"><?echo $nombre?></span></td>
          </tr>
      </table></td>
          <td width="227"><table width="220" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">CEDULA/RIF:</span></td>
            <td width="120"><span class="Estilo17"><?echo $ced_rif?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  
  
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
          <td width="100" align="center"><span class="Estilo17">CODIGO</span></td>
          <td width="660" align="center"><span class="Estilo17">DESCRIPCION RETENCION</span></td>
          <td width="60" align="center"><span class="Estilo17">TASA</span></td>
          <td width="160" align="center"><span class="Estilo17">MONTO RETENCION</span></td>
        </tr>
  </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="0"  height="30" cellpadding="3" cellspacing="0">
<? $total=0; $sql="SELECT tipo_retencion,descripcion_ret,tasa_retencion,sum(monto_retencion) as monto_ret FROM RET_ORD where nro_orden_ret='$nro_orden' group by tipo_retencion,descripcion_ret,tasa_retencion order by tipo_retencion";
$resret=pg_query($sql); $filas=pg_num_rows($resret); $prev_ret="";
while($registro=pg_fetch_array($resret)){
$tasa=$registro["tasa_retencion"]; $tasa=formato_monto($tasa); $monto=$registro["monto_ret"]; $monto=formato_monto($monto); $total=$total+$registro["monto_ret"];
$concepto_ret=$registro["descripcion_ret"]; $concepto_ret=substr($concepto_ret,0,100);?>
    <tr><td><table width="1000" border="0"  cellpadding="3" cellspacing="0">
        <tr>
          <td width="100" align="center"><span class="Estilo17"><? echo $registro["tipo_retencion"]; ?></span></td>
          <td width="660" align="left"><span class="Estilo17"><? echo $concepto_ret; ?></span></td>
          <td width="60" align="right"><span class="Estilo17"><? echo $tasa; ?></span></td>
          <td width="160" align="right"><span class="Estilo17"><? echo $monto; ?></span></td>
		</tr>  
		</table></td>
    </tr>
<?}  $total=formato_monto($total); ?>
        </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td height="25"><table width="994" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="830" align="right"><span class="Estilo18">TOTAL RETENCIONES :</span></td>
            <td width="150" align="right"><span class="Estilo18"><?echo $total?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
	  <td width="980" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td width="980" align="center"  height="120">&nbsp;</td>
    </tr>
	<tr>
      <td width="980" align="center"><span class="Estilo17">FIRMA</span></td>
    </tr>
    </table></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
</table></td></tr>
</table>