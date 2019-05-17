<?include ("../../class/conect.php");  include ("../../class/funciones.php");
if (!$_GET){$cod_banco='';$num_cheque=''; }  else{$cod_banco=$_GET["cod_banco"];$num_cheque=$_GET["num_cheque"];}
$sql="Select * from EDO_CHEQUES where cod_banco='$cod_banco' and num_cheque='$num_cheque'"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Formato Anexo Cheque)</title>
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
.Estilo16 {        font-family: Arial, Helvetica, sans-serif;        font-size: 18pt;}
.Estilo17 {font-size: 8pt}
.Estilo18 {font-size: 10pt}
-->
</style>
</head>
<? $conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$direccion="CALLE 48 CON CARRERA 13 EDIF HIDROLARA, PISO 2, LOCAL S/N, SECTOR VICENTE-CAJA DE AGUA"; $nombre_emp="HIDROLARA C.A."; $rif_emp="G-20009014-6";

$nombre_banco="";$nro_cuenta="";$concepto="";$num_cheque=""; $nro_orden=""; $nombre_benef=""; $ced_rif=""; $concepto=""; $monto_cheque=0; $fecha=""; $inf_usuario=""; $anulado="N";  $fecha_anulado="";  $tipo_pago=""; $edo_cheque=""; $entregado="N";$fecha_entregado="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"];  $fecha_anulado=$registro["fecha_anulado"]; $tipo_pago=$registro["tipo_pago"]; $nro_orden=$registro["nro_orden_pago"];
  $concepto=$registro["concepto"]; $num_cheque=$registro["num_cheque"];  $fecha=$registro["fecha"]; $sfecha=$registro["fecha"];  $nro_orden=$registro["nro_orden_pago"]; $monto_cheque=$registro["monto_cheque"];  $ced_rif=$registro["ced_rif"];
  $nombre_benef=$registro["nombre"];  $entregado=$registro["entregado"]; $fecha_entregado=$registro["fecha_entregado"];$ced_rif_recib=$registro["ced_rif_recib"];$nombre_recib=$registro["nombre_recib"];  $inf_usuario=$registro["inf_usuario"];
}
$monto_cheque=formato_monto($monto_cheque); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$monto_letras= monto_en_letras($monto_cheque); $tipo_comp="B".$cod_banco;
$lugar="BARQUISIMETO, ".substr($fecha,0,5); $ano=substr($fecha,6,4);
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
      <td width="960" height="32" align="center"><span class="Estilo16">ANEXO CHEQUE </span></td>
      <td width="20" align="center">&nbsp;</td>
     </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">CUENTA:</span></td>
            <td width="200"><span class="Estilo17"><?echo $nro_cuenta?></span></td>
			<td width="100"><span class="Estilo17">CHEQUE NRO.:</span></td>
            <td width="200"><span class="Estilo17"><?echo $num_cheque?></span></td>
			<td width="80"><span class="Estilo17">FECHA:</span></td>
            <td width="120"><span class="Estilo17"><?echo $fecha?></span></td>
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
            <td width="660"><span class="Estilo17"><?echo $nombre_benef?></span></td>
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
<? $total=0; $sql="SELECT tipo_retencion,descripcion_ret,tasa_retencion,sum(monto_retencion) as monto_ret FROM RET_ORD where nro_orden_ret in (select nro_orden from pag001 where status='I' and nro_cheque='$num_cheque') group by tipo_retencion,descripcion_ret,tasa_retencion order by tipo_retencion";
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