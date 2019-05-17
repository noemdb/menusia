<?include ("../../class/conect.php");  include ("../../class/funciones.php");
if (!$_GET){  $referencia_caus='';$tipo_causado='';$tipo_pago=''; $referencia_pago=''; $referencia_comp='';$tipo_compromiso=''; $cod_banco='';}
 else {  $tipo_pago=$_GET["txttipo_pago"];  $referencia_pago=$_GET["txtreferencia_pago"];   $referencia_caus=$_GET["txtreferencia_caus"];  $tipo_causado=$_GET["txttipo_causado"];  $referencia_comp = $_GET["txtreferencia_comp"];  $tipo_compromiso = $_GET["txttipo_compromiso"]; $cod_banco='';}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Pago Presupuestario)</title>
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
<?  $rif_emp="G-20009014-6";
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$l_cat=0;  $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat);} 
$sql="Select * FROM PAGOS where tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'" ;
$descripcion="";$fecha="";$nombre_abrev_caus="";$nombre_abrev_pago="";$nombre_abrev_comp="";$ced_rif="";$nombre="";$num_proyecto="";$des_proyecto="";$func_inv="";$genera_comprobante="";$inf_usuario="";$modulo="";$anulado="";
$res=pg_query($sql);$filas=pg_num_rows($res); $des_unidad_sol =""; $unidad_sol="";
if($filas>0){ $registro=pg_fetch_array($res);  $tipo_pago=$registro["tipo_pago"];
  $referencia_pago=$registro["referencia_pago"]; $referencia_caus=$registro["referencia_caus"];
  $tipo_causado=$registro["tipo_causado"];  $referencia_comp=$registro["referencia_comp"];  $tipo_compromiso=$registro["tipo_compromiso"];
  $cod_banco=$registro["cod_banco"];  $fecha=$registro["fecha_pago"];  $descripcion=$registro["descripcion_pago"];   $inf_usuario=$registro["inf_usuario"];
  $nombre_abrev_pago=$registro["nombre_abrev_pago"];   $nombre_abrev_caus=$registro["nombre_abrev_caus"];   $nombre_abrev_comp=$registro["nombre_abrev_comp"];
  $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"];  $num_proyecto=$registro["num_proyecto"]; $des_proyecto=$registro["des_proyecto"];
  $func_inv=$registro["func_inv"]; $genera_comprobante=$registro["genera_comprobante"]; $modulo=$registro["modulo"]; $anulado=$registro["anulado"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
$clave=$tipo_pago.$referencia_pago.$tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp.$cod_banco;
if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}$criterio=$sfecha.$referencia_caus.'G'.$tipo_pago; $tipo_comp='G'.$tipo_pago;
for ($i=0; $i<strlen($inf_usuario); $i++) { if (substr($inf_usuario,$i, 1)==" "){$l=$i; $i=strlen($inf_usuario);} } $usuario_comp=substr($inf_usuario,0,$l);
$sql="select * from sia001 where campo101='$usuario_comp'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}
$sql="SELECT * FROM codigos_pagos where tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' order by cod_presup";
$res=pg_query($sql); $filas=pg_num_rows($res);if($filas>=1){ $reg=pg_fetch_array($res); $cod_presup=$reg["cod_presup"]; $unidad_sol=substr($cod_presup,0, $l_cat);}
$sSQL="Select cod_presup_cat,cod_fuente_cat,denominacion_cat from pre019 WHERE cod_presup_cat='$unidad_sol'";   $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if($filas>=1){ $reg=pg_fetch_array($resultado); $des_unidad_sol=$reg["denominacion_cat"];}
$sql="SELECT * FROM codigos_pagos where tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' order by cod_presup";
$res=pg_query($sql); $filas=pg_num_rows($res);
?>
<body>
<table width="981" height="292" border="1" cellpadding="0" cellspacing="0">
<tr><td height="291"><table width="980" border="0"  height="291" cellpadding="0" cellspacing="0">
  <tr><td height="90" colspan="4"><table width="980" border="0" cellpadding="3" cellspacing="1" height="90">
    <tr>
      <td height="67" colspan="4"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Encabezado_rpt_presupuesto.png" width="970"></div></td>
    </tr>
  </table></td>
  </tr>
  <tr><td height="40" colspan="4"><table width="980" border="0"  height="40">
    <tr>
          <td width="30"><span class="Estilo18">RIF:</span></td>
          <td width="100"><span class="Estilo18"><?echo $rif_emp?></span></td>
          <td width="650" height="32" align="center"><span class="Estilo16">REGISTRO DE PAGO PRESUPUESTARIO</span></td>
          <td width="100" align="center">NUMERO :</td>
          <td width="100" align="center"><?echo $referencia_comp?></td>
        </tr>
    </table></td>
  </tr>
  <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="760"><table width="760" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">UNIDAD:</span></td>
            <td width="660"><span class="Estilo17"><?echo $des_unidad_sol?></span></td>
          </tr>
      </table></td>
      <td width="220"><table width="220" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">FECHA:</span></td>
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
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">CONCEPTO :</span></td>
            <td width="880"><span class="Estilo17"><?echo $descripcion?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="980" align="center"><span class="Estilo17">CONTABILIDAD PRESUPUESTARIA</span></td>
           </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="240" align="center"><span class="Estilo17">CODIGO</span></td>
          <td width="580" align="center"><span class="Estilo17">DENOMINACION</span></td>
          <td width="160" align="center"><span class="Estilo17">MONTO</span></td>
        </tr>
<? $total=0;
while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto"]); $total=$total+$registro["monto"];?>
    <tr>
      <td width="240" align="center"><span class="Estilo17"><? echo $registro["cod_presup"]; ?></span></td>
          <td width="580" align="left"><span class="Estilo17"><? echo $registro["denominacion"]; ?></span></td>
          <td width="160" align="right"><span class="Estilo17"><? echo $monto; ?></span></td>
        </tr>
<?}$total=formato_monto($total); ?>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td height="25"><table width="994" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="815" align="right"><span class="Estilo18">TOTAL :</span></td>
            <td width="165" align="right"><span class="Estilo18"><?echo $total?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
<? $sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$referencia_pago' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>=1){?>

  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="980" align="center"><span class="Estilo17">CONTABILIDAD FINANCIERA</span></td>
           </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="200" align="center"><span class="Estilo17">CODIGO CUENTA</span></td>
          <td width="460" align="center"><span class="Estilo17">NOMBRE</span></td>
          <td width="160" align="center"><span class="Estilo17">DEBE</span></td>
          <td width="160" align="center"><span class="Estilo17">HABER</span></td>
        </tr>
  </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="0"  height="30" cellpadding="3" cellspacing="0">
<? $sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$referencia_pago' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){
$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);
if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;}?>
    <tr>
      <td width="200" align="center"><span class="Estilo17"><? echo $registro["cod_cuenta"]; ?></span></td>
          <td width="460" align="left"><span class="Estilo17"><? echo $registro["nombre_cuenta"]; ?></span></td>
          <td width="160" align="right"><span class="Estilo17"><? echo $debe; ?></span></td>
          <td width="160" align="right"><span class="Estilo17"><? echo $haber; ?></span></td>
        </tr>
<?}$total=formato_monto($total); ?>
    </table></td>
  </tr>
<?} ?>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="480" align="center"><span class="Estilo17">ELABORADO POR</span></td>
      <td width="500" align="center"><span class="Estilo17">APROBADO POR</span></td>
    </tr>
    <tr>
      <td width="480" align="center"  height="120">&nbsp;</td>
      <td width="500" align="center">&nbsp;</td>
    </tr>
        <tr>
      <td width="480" align="center"><span class="Estilo17"><?echo $nomb_usuario_comp?></span></td>
      <td width="500" align="center"><span class="Estilo17"></span></td>
    </tr>
    </table></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
</table></td></tr>
</table>
<?
  pg_close();
?> 