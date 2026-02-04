<?php include ("../../class/conect.php");  include ("../../class/funciones.php");
if (!$_GET){$cod_banco='';$num_cheque=''; }  else{$cod_banco=$_GET["cod_banco"];$num_cheque=$_GET["num_cheque"];}
$sql="Select * from EDO_CHEQUES where cod_banco='$cod_banco' and num_cheque='$num_cheque'";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Formato Cheque)</title>
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
.Estilo16 {font-family: sans-serif; font-size: 18pt;}
.Estilo17 {font-family: serif; font-size: 12pt}
.Estilo18 {font-family: sans-serif; font-size: 14pt}
.Estilo19 {font-family: sans-serif; font-size: 16pt}
-->
</style>
</head>
<?php  $conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$nombre_banco="";$nro_cuenta="";$concepto="";$num_cheque=""; $nro_orden=""; $nombre_benef=""; $ced_rif=""; $concepto=""; $monto_cheque=0; $fecha=""; $inf_usuario=""; $anulado="N";  $fecha_anulado="";  $tipo_pago=""; $edo_cheque=""; $entregado="N";$fecha_entregado="";$ced_rif_recib="";$nombre_recib="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"];  $fecha_anulado=$registro["fecha_anulado"]; $tipo_pago=$registro["tipo_pago"];
  $concepto=$registro["concepto"]; $num_cheque=$registro["num_cheque"];  $fecha=$registro["fecha"]; $sfecha=$registro["fecha"];  $nro_orden=$registro["nro_orden_pago"]; $monto_cheque=$registro["monto_cheque"];  $ced_rif=$registro["ced_rif"];
  $nombre_benef=$registro["nombre"];  $entregado=$registro["entregado"]; $fecha_entregado=$registro["fecha_entregado"];$ced_rif_recib=$registro["ced_rif_recib"];$nombre_recib=$registro["nombre_recib"];  $inf_usuario=$registro["inf_usuario"];
}
$monto_cheque=formato_monto($monto_cheque); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$monto_letras= monto_en_letras($monto_cheque); $tipo_comp="B".$cod_banco;
$lugar="BARQUISIMETO, ".substr($fecha,0,5); $ano=substr($fecha,6,4); $facturas="";

$cod_c=array ('','','','','','','','','','','','','','',''); $debe_c=array ('','','','','','','','','','','','','','','');
$den_c=array ('','','','','','','','','','','','','','',''); $haber_c=array ('','','','','','','','','','','','','','','');


$k=0; $max_ccont=6;
$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$num_cheque' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;} 
$cod_c[$k]=$registro["cod_cuenta"]; $den_c[$k]=$registro["nombre_cuenta"]; $debe_c[$k]=$debe; $haber_c[$k]=$haber; if($k<15){$k=$k+1;}} $cant_cont=$k;


$cod_p=array ('','','','','','','','','','','','','','',''); $monto_p=array ('','','','','','','','','','','','','','','');
$den_p=array ('','','','','','','','','','','','','','',''); 

$max_cpre=12; $k=0;
$sqlc="SELECT cod_presup,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$num_cheque' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,denominacion order by cod_presup";
$resc=pg_query($sqlc); $filas=pg_num_rows($resc); $cant_cod_presup=$filas; 
while($registro=pg_fetch_array($res)){

$monto_chq=$registro["monto_chq"]; $monto_asiento=formato_monto($monto_chq);


$cod_p[$k]=$registro["cod_presup"]; $den_c[$k]=$registro["denominacion"]; $debe_c[$k]=$monto_chq; if($k<15){$k=$k+1;}} $cant_cod_presup=$k;


?>
<body>
<table width="981" height="57" border="0" cellpadding="0" cellspacing="0">
<tr><td height="115">&nbsp;</td></tr>
<tr><td height="25" ><table width="980" border="0" >
    <tr>
     <td width="500">&nbsp;</td>
     <td width="431"><div align="left"> </div> <p align="right" class="Estilo19">***<?php  echo $monto_cheque; ?>***</p></td>
     <td width="50">&nbsp;</td>
    </tr>
  </table></td>
</tr>
<tr><td height="41">&nbsp;</td></tr>
<tr><td height="20" ><table width="980" border="0" >
    <tr>
     <td width="170">&nbsp;</td>
     <td width="810"><div align="left"> </div> <p align="left" class="Estilo19">***<?php  echo $nombre_benef; ?>***</p></td>
        </tr>
  </table></td>
</tr>
<tr><td height="10">&nbsp;</td></tr>
<tr><td height="25" ><table width="980" border="0" >
    <tr>
     <td width="180">&nbsp;</td>
     <td width="900"><div align="left"> </div> <p align="left" class="Estilo18"><?php  echo $monto_letras; ?></p></td>
        </tr>
  </table></td>
</tr>
<tr><td height="16">&nbsp;</td></tr>
<tr><td height="25" ><table width="980" border="0" >
    <tr>
     <td width="120">&nbsp;</td>
     <td width="300"><div align="left"> </div> <p align="left" class="Estilo19"><?php  echo $lugar; ?></p></td>
         <td width="380"><div align="left"> </div> <p align="left" class="Estilo19"><?php  echo $ano; ?></p></td>
     <td width="180">&nbsp;</td>
        </tr>
  </table></td>
</tr>
<tr><td height="280">&nbsp;</td></tr>
<tr><td height="25" ><table width="980" border="0" >
    <tr>
     <td width="400"><div align="left"> </div> <p align="left" class="Estilo18"><?php  echo $nombre_banco; ?></p></td>
         <td width="300"><div align="left"> </div> <p align="left" class="Estilo18"><?php  echo $nro_cuenta; ?></p></td>
         <td width="180"><div align="left"> </div> <p align="left" class="Estilo18"><?php  echo $num_cheque; ?></p></td>
        </tr>
  </table></td>
</tr>
<tr><td height="30">&nbsp;</td></tr>
<tr><td height="180" ><table width="980" border="0" >
    <tr>
     <td width="40">&nbsp;</td>
     <td width="840"><div align="left"> </div> <p align="left" class="Estilo18"><?php  echo $concepto; ?></p></td>
     <td width="100">&nbsp;</td>
    </tr>
  </table>
    <div id="Layer1" style="position:absolute; width:994px; height:215px; z-index:1; left: 11px; top: 1283px;">
      <table width="975" border="0" >
        <tr>
          <td height="25" ><table width="996" border="0"  cellpadding="3" cellspacing="0">
<?php  $total=0; $sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$num_cheque' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);
if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;}?>
              <tr>
                <td width="200" align="left"><span class="Estilo17"><?php  echo $registro["cod_cuenta"]; ?></span></td>
                <td width="440" align="left"><span class="Estilo17"><?php  echo $registro["nombre_cuenta"]; ?></span></td>
                <td width="120" align="right"><span class="Estilo17"><?php  echo $debe; ?></span></td>
                <td width="120" align="right"><span class="Estilo17"><?php  echo $haber; ?></span></td>
                <td width="80"></td>
              </tr>
<?php }$total=formato_monto($total); ?>
          </table></td>
        </tr>
      </table>
    </div></td>
</tr>
<tr><td height="180">&nbsp;</td></tr>
<tr><td height="25" ><table width="1006" border="0"  height="30" cellpadding="3" cellspacing="0">
<?php  $total=0;
$sql="SELECT cod_presup,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$num_cheque' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,denominacion order by cod_presup";$res=pg_query($sql);$filas=pg_num_rows($res);
while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto_chq"]); $total=$total+$registro["monto_chq"];?>
    <tr>
      <td width="200" align="left"><span class="Estilo17"><?php  echo $registro["cod_presup"]; ?></span></td>
          <td width="560" align="left"><span class="Estilo17"><?php  echo $registro["denominacion"]; ?></span></td>
          <td width="120" align="right"><span class="Estilo17"><?php  echo $monto; ?></span></td>
          <td width="100">&nbsp;</td>
        </tr>
<?php } ?>
    </table></td>
  </tr>
  <tr><td height="100">&nbsp;</td></tr>
 <tr><td ><table width="980" border="0" ><tr><td height="25" ><table width="1000" border="0"  cellpadding="3" cellspacing="0"><tr><td width="100">&nbsp;</td>
        </tr>

    </table></td>
  </tr>
   </table></td>
  </tr>
<tr><td>&nbsp;</td></tr>
<tr><td height="180">&nbsp;</td></tr>
</table>