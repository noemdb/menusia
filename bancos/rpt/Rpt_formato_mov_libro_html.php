<?php include ("../../class/conect.php");  include ("../../class/funciones.php");
if (!$_GET){$cod_banco='';$referencia=''; $tipo_mov='';}  else{$cod_banco=$_GET["cod_banco"];$referencia=$_GET["referencia"];$tipo_mov=$_GET["tipo_mov"];}
$sql="Select * from MOV_LIBROS where cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Formato Movimiento en libros)</title>
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
<?php  $conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$direccion="CALLE 48 CON CARRERA 13 EDIF HIDROLARA, PISO 2, LOCAL S/N, SECTOR VICENTE-CAJA DE AGUA"; $nombre_emp="HIDROLARA C.A."; $rif_emp="G-20009014-6";
$nombre_banco="";$nro_cuenta="";$des_tipo_mov="";$referencia=""; $tipo_mov="";$nombre_benef=""; $ced_rif=""; $descripcion=""; $monto_mov_libro=0; $fecha=""; $inf_usuario=""; $anulado="N"; $mes_conciliacion="00"; $fecha_anulado="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"];$nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"]; $mes_conciliacion=$registro["mes_conciliacion"]; $fecha_anulado=$registro["fecha_anulado"];
  $des_tipo_mov=$registro["descrip_tipo_mov"]; $referencia=$registro["referencia"];  $tipo_mov=$registro["tipo_mov_libro"];   $fecha=$registro["fecha_mov_libro"];
  $monto_mov_libro=$registro["monto_mov_libro"]; $descripcion=$registro["descrip_mov_libro"];  $nombre_benef=$registro["nombre"]; $ced_rif=$registro["ced_rif"]; $inf_usuario=$registro["inf_usuario"];
}else{ echo $sql;} $total_debe=0; $total_haber=0; $ref_comp=$referencia;
$clave=$cod_banco.$referencia.$tipo_mov;  $monto_mov_libro=formato_monto($monto_mov_libro); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}  if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}  $criterio=$sfecha.$referencia.'B'.$cod_banco;if(($anulado=='S')and(($tipo_mov=="ANU")or($tipo_mov=="ANC")or($tipo_mov=="AND"))){$criterio=$sfecha.'A'.substr($referencia,1,7).'B'.$cod_banco; $ref_comp='A'.substr($referencia,1,7);}
$monto_letras= monto_en_letras($monto_mov_libro); $tipo_comp="B".$cod_banco; $lugar="BARQUISIMETO, ".substr($fecha,0,5); $ano=substr($fecha,6,4);
?>
<body>
<table width="981" height="292" border="1" cellpadding="0" cellspacing="0">
<tr><td height="291"><table width="980" border="0"  height="291" cellpadding="0" cellspacing="0">
  <td width="673"><div id="Layer2" style="position:absolute; width:118px; height:127px; z-index:2; left: 16px; top: 10px;"><img src="../../imagenes/Logo_empresa.gif" width="115" height="122" border="0"></div>

  <tr><td height="90" colspan="4"><table width="980" border="0" cellpadding="3" cellspacing="1" height="90">
    <tr>
      <td width="150" align="center">&nbsp;</td>
      <td width="30"><span class="Estilo18">RIF:</span></td>
      <td width="150"><span class="Estilo18"><?php echo $rif_emp?></span></td>
      <td width="650" align="center">&nbsp;</td>
    </tr>
  </table></td>

  </tr>
  <tr><td height="40" colspan="4"><table width="980" border="0"  height="40">
    <tr>
      <td width="980" height="32" align="center"><span class="Estilo16"><?php echo $des_tipo_mov?></span></td>
     </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">CUENTA:</span></td>
            <td width="200"><span class="Estilo17"><?php echo $nro_cuenta?></span></td>
			<td width="100"><span class="Estilo17">REFERENCIA:</span></td>
            <td width="200"><span class="Estilo17"><?php echo $referencia?></span></td>
			<td width="80"><span class="Estilo17">FECHA:</span></td>
            <td width="120"><span class="Estilo17"><?php echo $fecha?></span></td>
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
            <td width="660"><span class="Estilo17"><?php echo $nombre_benef?></span></td>
          </tr>
      </table></td>
          <td width="227"><table width="220" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">CEDULA/RIF:</span></td>
            <td width="120"><span class="Estilo17"><?php echo $ced_rif?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="80"><span class="Estilo17">CONCEPTO:</span></td>
            <td width="900"><span class="Estilo17"><?php echo $descripcion?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="980" align="center"><span class="Estilo18">COMPROBANTE</span></td>
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

<?php  $sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$ref_comp' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql); 
while($registro=pg_fetch_array($res)){$monto_a=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_a);
if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";$total_debe=$total_debe+$monto_a;}else{$debe="";$haber=$monto_asiento; $total_haber=$total_haber+$monto_a;}?>
    <tr>
        <td width="200" align="center"><span class="Estilo17"><?php  echo $registro["cod_cuenta"]; ?></span></td>
        <td width="460" align="left"><span class="Estilo17"><?php  echo $registro["nombre_cuenta"]; ?></span></td>
        <td width="160" align="right"><span class="Estilo17"><?php  echo $debe; ?></span></td>
        <td width="160" align="right"><span class="Estilo17"><?php  echo $haber; ?></span></td>
		<td width="5" align="center">&nbsp;</td>
    </tr>
<?php }$total_debe=formato_monto($total_debe); $total_haber=formato_monto($total_haber);  ?>    
    </table></td>	  
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td height="25"><table width="994" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="660" align="right"><span class="Estilo17">TOTAL:</span></td>
            <td width="160" align="right"><span class="Estilo17"><?php echo $total_debe?></span></td>
			<td width="160" align="right"><span class="Estilo17"><?php echo $total_haber?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">    
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
