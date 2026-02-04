<?php include ("../../class/conect.php");  include ("../../class/funciones.php");
if (!$_GET){ $referencia_ajuste=''; $tipo_ajuste=''; $tipo_pago=''; $referencia_pago='';} else{$referencia_ajuste=$_GET["txtreferencia_ajuste"]; $tipo_ajuste=$_GET["txttipo_ajuste"]; $tipo_pago=$_GET["txttipo_pago"]; $referencia_pago=$_GET["txtreferencia_pago"];
$referencia_caus=$_GET["txtreferencia_caus"];$tipo_causado=$_GET["txttipo_causado"];$referencia_comp = $_GET["txtreferencia_comp"];$tipo_compromiso = $_GET["txttipo_compromiso"];}
   $sql="Select * from AJUSTES where tipo_ajuste='$tipo_ajuste' and referencia_ajuste='$referencia_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Ajuste Presupuestario)</title>
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
<?php 
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$descripcion="";$fecha="";$nombre_abrev_ajuste="";$inf_usuario=""; $nombre_refiere_a=""; $tpo_ajuste="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
  $tipo_ajuste=$registro["tipo_ajuste"];  $referencia_ajuste=$registro["referencia_ajuste"]; $tpo_ajuste=$registro["tpo_ajuste"];
  $tipo_pago=$registro["tipo_pago"];  $referencia_pago=$registro["referencia_pago"];
  $referencia_caus=$registro["referencia_caus"];  $tipo_causado=$registro["tipo_causado"];
  $referencia_comp=$registro["referencia_comp"];  $tipo_compromiso=$registro["tipo_compromiso"];
  $fecha=$registro["fecha_ajuste"];  $descripcion=$registro["descripcion"];  $inf_usuario=$registro["inf_usuario"];
  $nombre_abrev_ajuste=$registro["nombre_abrev_ajuste"];  $nombre_abrev_pago=$registro["nombre_abrev_pago"];
  $nombre_abrev_caus=$registro["nombre_abrev_caus"];  $nombre_abrev_comp=$registro["nombre_abrev_comp"];
  $modulo=$registro["modulo"];  $anulado=$registro["anulado"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);} $refierea=""; $nombre_tipo=""; $ced_rif="";  $nombre="";
$sSQL="Select refierea from pre005 WHERE tipo_ajuste='$tipo_ajuste'";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
if ($filas>0){$registro=pg_fetch_array($resultado);  $refierea=$registro["refierea"]; }
if($refierea=="COMPROMISO"){$sSQL="Select tipo_compromiso,nombre_tipo_comp from pre002 WHERE tipo_compromiso='$tipo_compromiso'";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
  if ($filas>0){$registro=pg_fetch_array($resultado);  $nombre_tipo=$registro["nombre_tipo_comp"]; } $nombre_refiere_a=$nombre_tipo.' NUMERO:'.$referencia_comp;

$nro_documento=""; $des_unidad_sol=""; $nombre_refiere_c=$nombre_refiere_a;
$sSQL="Select * from COMPROMISOS where tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";     
$resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
if ($filas>0){$registro=pg_fetch_array($resultado);  $nro_documento=$registro["nro_documento"]; $des_unidad_sol=$registro["denominacion_cat"];  
$ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"]; 
$nombre_refiere_a=$nombre_refiere_a." ".$nro_documento;  }
  

}
if($refierea=="CAUSADO"){$sSQL="Select tipo_causado,nombre_tipo_caus from pre003 WHERE tipo_causado='$tipo_causado'";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
  if ($filas>0){$registro=pg_fetch_array($resultado);  $nombre_tipo=$registro["nombre_tipo_caus"]; } $nombre_refiere_a=$nombre_tipo.' NUMERO:'.$referencia_caus;}
if($refierea=="PAGO"){$sSQL="Select tipo_pago,nombre_tipo_pago from pre004 WHERE tipo_pago='$tipo_pago'";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
  if ($filas>0){$registro=pg_fetch_array($resultado);  $nombre_tipo=$registro["nombre_tipo_pago"]; }$nombre_refiere_a=$nombre_tipo.' NUMERO: '.$referencia_pago;}
if($tpo_ajuste=="A"){$titulo="REGISTRO DE AUMENTO A COMPROMISO";}else{$titulo="REGISTRO AJUSTE PRESUPUESTARIO"; if($refierea=="COMPROMISO"){$titulo="REGISTRO DE DISMINUCION A COMPROMISO";}}
for ($i=0; $i<strlen($inf_usuario); $i++) { if (substr($inf_usuario,$i, 1)==" "){$l=$i; $i=strlen($inf_usuario);} } $usuario_comp=substr($inf_usuario,0,$l);
$sql="select * from sia001 where campo101='$usuario_comp'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];
if( $nomb_usuario_comp=="ADMINISTRADOR"){$nomb_usuario_comp="";}}
$sql="SELECT * FROM CODIGOS_AJUSTES where referencia_ajuste='$referencia_ajuste' and tipo_ajuste='$tipo_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' order by cod_presup";
$res=pg_query($sql); $filas=pg_num_rows($res);?>
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
      <td width="766" height="32" align="center"><span class="Estilo16"><?php echo $titulo?></span></td>
          <td width="91" align="center">NUMERO :</td>
          <td width="99" align="center"><?php echo $referencia_ajuste?></td>
        </tr>
    </table></td>
  </tr>
<?php  if($refierea=="COMPROMISO"){ ?>
  <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="760"><table width="760" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">UNIDAD:</span></td>
            <td width="660"><span class="Estilo17"><?php echo $des_unidad_sol?></span></td>
          </tr>
      </table></td>
      <td width="220"><table width="220" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">FECHA:</span></td>
            <td width="120"><span class="Estilo17"><?php echo $fecha?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="540" height="25"><table width="440" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="80"><span class="Estilo17">DOCUMENTO:</span></td>
            <td width="460"><span class="Estilo17"><?php echo $nombre_refiere_c ?></span></td>
          </tr>
      </table></td>
          <td width="440"><table width="440" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="140"><span class="Estilo17">NUMERO DOCUMENTO:</span></td>
            <td width="300"><span class="Estilo17"><?php echo $nro_documento?></span></td>
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
            <td width="660"><span class="Estilo17"><?php echo $nombre?></span></td>
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
<?php } else { ?>
  <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="760"><table width="760" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="150"><span class="Estilo17">DOCUMENTO DE AJUSTE:</span></td>
            <td width="610"><span class="Estilo17"><?php echo $nombre_refiere_a?></span></td>
          </tr>
      </table></td>
      <td width="220"><table width="220" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">FECHA:</span></td>
            <td width="120"><span class="Estilo17"><?php echo $fecha?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
<?php }  ?>
   <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="980" height="25"><table width="980" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">CONCEPTO :</span></td>
            <td width="880"><span class="Estilo17"><?php echo $descripcion?></span></td>
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
	</table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="0"  height="30" cellpadding="3" cellspacing="0">	
<?php  $total=0;
while($registro=pg_fetch_array($res)){$monto=$registro["monto"]; if($tpo_ajuste=="A"){$monto=$monto*-1;}else{$monto=$monto*-1;} $total=$total+$monto; $monto=formato_monto($monto); ?>
    <tr>
      <td width="240" align="center"><span class="Estilo17"><?php  echo $registro["cod_presup"]; ?></span></td>
          <td width="580" align="left"><span class="Estilo17"><?php  echo $registro["denominacion"]; ?></span></td>
          <td width="160" align="right"><span class="Estilo17"><?php  echo $monto; ?></span></td>
        </tr>
<?php }$total=formato_monto($total); ?>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td height="25"><table width="994" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="815" align="right"><span class="Estilo18">TOTAL :</span></td>
            <td width="165" align="right"><span class="Estilo18"><?php echo $total?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
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
         <td width="480" align="center"><span class="Estilo17"><?php echo $nomb_usuario_comp?></span></td>
         <td width="500" align="center"><span class="Estilo17"></span></td>
        </tr>
    </table></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
</table></td></tr>
</table>
