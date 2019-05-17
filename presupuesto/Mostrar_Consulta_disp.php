<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$cod_presup=$_POST["txtcod_presup"];$cod_fuente=$_POST["txtcod_fuente"]; $denominacion=$_POST["txtdenominacion"]; $asignado=$_POST["txtasignado"];$fecha=$_POST["txtFechad"]; $des_fuente=$_POST["txtdes_fuente"];
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else{ $Nom_Emp=busca_conf(); }
$sSQL="Select * from codigos where cod_presup='$cod_presup' and cod_fuente='$cod_fuente'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO EXISTE'); window.close();  </script> <? }
 else {  $registro=pg_fetch_array($resultado); $asignado=$registro["asignado"];  $denominacion=$registro["denominacion"];   $des_fuente=$registro["des_fuente_financ"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Consulta Disponibilidad)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
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
.Estilo16 {font-family: Arial, Helvetica, sans-serif;   font-size: 18pt;}
.Estilo17 {font-size: 8pt}
.Estilo18 {font-size: 10pt}
-->
</style>
</head>
<?
$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
$l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+1;
$unidad_sol=substr($cod_presup,0,$c); $des_unidad_sol=""; $cod_part=substr($cod_presup,$ini,$p);
$sSQL="Select cod_presup_cat,cod_fuente_cat,denominacion_cat from pre019 WHERE cod_presup_cat='$unidad_sol'";
$res=pg_exec($conn,$sSQL);  $filas=pg_numrows($res); $sfecha=formato_aaaammdd($fecha);
if($filas>0){  $registro=pg_fetch_array($res); $des_unidad_sol=$registro["denominacion_cat"]; }
$modificaciones=0; $comprometido=0; $causado=0; $pagado=0; $diferido=0;

$tipo_ajuc='0001'; $tipo_ajuc_anu='A001';
$sql="SELECT * FROM PRE005 where refierea='COMPROMISO' order by tipo_ajuste"; $res=pg_exec($conn,$sql);  $filas=pg_numrows($res); 
if($filas>0){  $registro=pg_fetch_array($res); $tipo_ajuc=$registro["tipo_ajuste"]; $tipo_ajuc_anu="A".substr($tipo_ajuc,1,3); }
$tipo_ajua='0002'; $tipo_ajua_anu='A002';
$sql="SELECT * FROM PRE005 where refierea='CAUSADO' order by tipo_ajuste"; $res=pg_exec($conn,$sql);  $filas=pg_numrows($res); 
if($filas>0){  $registro=pg_fetch_array($res); $tipo_ajua=$registro["tipo_ajuste"]; $tipo_ajua_anu="A".substr($tipo_ajuc,1,3); }
$tipo_ajup='0003'; $tipo_ajup_anu='A003';
$sql="SELECT * FROM PRE005 where refierea='PAGO' order by tipo_ajuste"; $res=pg_exec($conn,$sql);  $filas=pg_numrows($res); 
if($filas>0){  $registro=pg_fetch_array($res); $tipo_ajup=$registro["tipo_ajuste"]; $tipo_ajup_anu="A".substr($tipo_ajuc,1,3); }


$sSQL="select sum(monto-ajustado) as monto_comp from pre036 where  cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and fecha_compromiso<='$sfecha'";
$sSQL="select sum(monto) as monto_comp from pre036 where  cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and fecha_compromiso<='$sfecha'";
$res=pg_exec($conn,$sSQL);  $filas=pg_numrows($res); if($filas>0){  $registro=pg_fetch_array($res); $comprometido=$registro["monto_comp"]; }
//echo $sSQL." ".$comprometido,"<br>";
$sSQL="select sum(monto) as monto_comp from pre031, pre011 where (pre031.tipo_ajuste='$tipo_ajuc' or pre031.tipo_ajuste='$tipo_ajuc_anu') and pre031.cod_presup='$cod_presup' and pre031.fuente_financ='$cod_fuente' and pre011.fecha_ajuste<='$sfecha' and pre011.referencia_ajuste=pre031.referencia_ajuste and pre011.tipo_ajuste=pre031.tipo_ajuste and pre011.referencia_pago=pre031.referencia_pago and pre011.tipo_pago=pre031.tipo_pago and pre011.referencia_caus=pre031.referencia_caus and  pre011.tipo_causado=pre031.tipo_causado and pre011.referencia_comp=pre031.referencia_comp and pre011.tipo_compromiso=pre031.tipo_compromiso";
$res=pg_exec($conn,$sSQL);  $filas=pg_numrows($res); if($filas>0){  $registro=pg_fetch_array($res); $comprometido=$comprometido-$registro["monto_comp"]; }

//echo $sSQL." ".$comprometido,"<br>";

$sSQL="select sum(monto) as monto_caus from pre037 where  cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and fecha_causado<='$sfecha'";
$res=pg_exec($conn,$sSQL);  $filas=pg_numrows($res); if($filas>0){  $registro=pg_fetch_array($res); $causado=$registro["monto_caus"]; }
$sSQL="select sum(monto) as monto_caus from pre031, pre011 where (pre031.tipo_ajuste='$tipo_ajua' or pre031.tipo_ajuste='$tipo_ajua_anu') and pre031.cod_presup='$cod_presup' and pre031.fuente_financ='$cod_fuente' and pre011.fecha_ajuste<='$sfecha' and pre011.referencia_ajuste=pre031.referencia_ajuste and pre011.tipo_ajuste=pre031.tipo_ajuste and pre011.referencia_pago=pre031.referencia_pago and pre011.tipo_pago=pre031.tipo_pago and pre011.referencia_caus=pre031.referencia_caus and  pre011.tipo_causado=pre031.tipo_causado and pre011.referencia_comp=pre031.referencia_comp and pre011.tipo_compromiso=pre031.tipo_compromiso";
$res=pg_exec($conn,$sSQL);  $filas=pg_numrows($res); if($filas>0){  $registro=pg_fetch_array($res); $causado=$causado-$registro["monto_caus"]; }


$sSQL="select sum(monto) as monto_pago FROM PRE038,PRE008 WHERE pre008.cod_banco=pre038.cod_banco and pre008.tipo_pago=pre038.tipo_pago and pre008.referencia_pago=pre038.referencia_pago and pre008.tipo_causado=pre038.tipo_causado and pre008.referencia_caus=pre038.referencia_caus and pre008.tipo_compromiso=pre038.tipo_compromiso and pre008.referencia_comp=pre038.referencia_comp and pre038.cod_presup='$cod_presup' and pre038.fuente_financ='$cod_fuente' and pre008.fecha_pago<='$sfecha'";
$res=pg_exec($conn,$sSQL);  $filas=pg_numrows($res); if($filas>0){  $registro=pg_fetch_array($res); $pagado=$registro["monto_pago"]; }
$sSQL="select sum(monto) as monto_pago from pre031, pre011 where (pre031.tipo_ajuste='$tipo_ajup' or pre031.tipo_ajuste='$tipo_ajup_anu') and pre031.cod_presup='$cod_presup' and pre031.fuente_financ='$cod_fuente' and pre011.fecha_ajuste<='$sfecha' and pre011.referencia_ajuste=pre031.referencia_ajuste and pre011.tipo_ajuste=pre031.tipo_ajuste and pre011.referencia_pago=pre031.referencia_pago and pre011.tipo_pago=pre031.tipo_pago and pre011.referencia_caus=pre031.referencia_caus and  pre011.tipo_causado=pre031.tipo_causado and pre011.referencia_comp=pre031.referencia_comp and pre011.tipo_compromiso=pre031.tipo_compromiso";
$res=pg_exec($conn,$sSQL);  $filas=pg_numrows($res); if($filas>0){  $registro=pg_fetch_array($res); $pagado=$pagado-$registro["monto_pago"]; }

$StrSQL = "select sum(monto) AS mmonto FROM pre009,pre039 Where (pre009.referencia_modif=pre039.referencia_modif) and (pre009.tipo_modif=pre039.tipo_modif) and (pre039.operacion='+') And (pre009.modif_aprob='S') And (pre009.anulado='N') And (pre039.cod_presup='$cod_presup') and (pre039.Fuente_Financ='$cod_fuente') And (pre009.fecha_modif<='$sfecha')";
$res=pg_exec($conn,$StrSQL); $filas=pg_numrows($res); if($filas>=1){$reg=pg_fetch_array($res);$modificaciones=$modificaciones+$reg["mmonto"];}

$StrSQL = "select sum(monto) AS mmonto FROM pre009,pre039 Where (pre009.referencia_modif=pre039.referencia_modif) and (pre009.tipo_modif=pre039.tipo_modif) and (pre039.operacion='-') And (pre009.modif_aprob='S') And (pre009.anulado='N') And (pre039.cod_presup='$cod_presup') and (pre039.Fuente_Financ='$cod_fuente') And (pre009.fecha_modif<='$sfecha')";
$res=pg_exec($conn,$StrSQL); $filas=pg_numrows($res); if($filas>=1){$reg=pg_fetch_array($res);$modificaciones=$modificaciones-$reg["mmonto"];}

$StrSQL="select sum(monto_diferido) AS mmonto FROM CODIGOS_DIFERIDOS where cod_presup='$cod_presup' and fuente_financ='$cod_fuente'";
$StrSQL="select sum(monto_diferido) AS mmonto FROM pre033,pre023 where pre023.referencia_dife=pre033.referencia_dife and pre023.tipo_diferido=pre033.tipo_diferido And (cod_presup='$cod_presup') and (fuente_financ='$cod_fuente') and (pre023.fecha_diferido<='$sfecha') and (pre023.status_2<>'L')";
$res=pg_exec($conn,$StrSQL);  $filas=pg_numrows($res); if($filas>0){  $registro=pg_fetch_array($res); $diferido=$registro["mmonto"]; }

$asig_act=$asignado+$modificaciones; $disponible=$asig_act-$comprometido; $disp_dif=$disponible-$diferido;
$asignado=formato_monto($asignado); $asig_act=formato_monto($asig_act);
$comprometido=formato_monto($comprometido);$causado=formato_monto($causado);
$pagado=formato_monto($pagado); $disponible=formato_monto($disponible);
$modificaciones=formato_monto($modificaciones); 
$disp_dif=formato_monto($disp_dif); $dif_presup=formato_monto($diferido);
?>
<body>
<table width="983" height="292" border="1" cellpadding="0" cellspacing="0">
<tr><td width="986" height="291"><table width="978" border="0"  height="274" cellpadding="0" cellspacing="0">
   <tr><td width="970" height="90" colspan="4"><table width="969" border="0" cellpadding="3" cellspacing="1" height="90">
    <tr>
      <td height="87" colspan="1"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_empresa.gif"  width="150" height="51"></div></td>    
      <td height="87" colspan="3"><div align="center" class="Estilo4"> <? echo $Nom_Emp ?></div></div></td>
	</tr>
  </table></td>
  </tr>
  <tr><td height="20" colspan="4"><table width="971" border="0"  height="40">
    <tr>
      <td width="766" height="32" align="center"><span class="Estilo16">CONSULTA DE DISPONIBILIDAD</span></td>

        </tr>
    </table></td>
  </tr>
  <tr><td height="25"><table width="978" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="760"><table width="760" border="0" cellpadding="3" cellspacing="0">
          <tr>
                    <td width="10" align="center">&nbsp;</td>
            <td width="80" align="left"><span class="Estilo17">CATEGORIA:</span></td>
                        <td width="77"align="left"><span class="Estilo17"><?echo $unidad_sol ?></span></td>
            <td width="567"><span class="Estilo17"><?echo $des_unidad_sol?></span></td>
          </tr>
      </table></td>
      <td width="220"><table width="195" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="100"><span class="Estilo17">A LA FECHA:</span></td>
            <td width="120"><span class="Estilo17"><?echo $fecha?></span></td>
          </tr>
      </table></td>
        </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="978" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="970" height="25"><table width="961" border="0" cellpadding="3" cellspacing="0">
          <tr>
                    <td width="8" align="center">&nbsp;</td>
            <td width="78" align="left"><span class="Estilo17">PARTIDA:</span></td>
                        <td width="77"align="left"><span class="Estilo17"><?echo $cod_part ?></span></td>
            <td width="774"><span class="Estilo17"><?echo $denominacion ?></span></td>
          </tr>
      </table></td>

        </tr>
    </table></td>
  </tr>
  <tr><td height="25" ><table width="978" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="970" height="25"><table width="961" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="8" align="center">&nbsp;</td>
            <td width="78" align="left"><span class="Estilo17">FUENTE:</span></td>
           <td width="57"align="left"><span class="Estilo17"><?echo $cod_fuente ?></span></td>
           <td width="794"><span class="Estilo17"><?echo $des_fuente ?></span></td>
          </tr>
      </table></td>

        </tr>
    </table></td>
  </tr>
   <tr><td height="25" ><table width="978" border="0"  height="30" cellpadding="3" cellspacing="0">
    <tr>
      <td width="978" height="25"><table width="969" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="339"><span class="Estilo17">&nbsp;</span></td>
                        <td width="164"><span class="Estilo17">&nbsp;</span></td>
                        <td width="96" align="center">&nbsp;</td>
                        <td width="346"><span class="Estilo17">&nbsp;</span></td>
          </tr>
                  <tr>
                     <td width="339"><span class="Estilo17">&nbsp;</span></td>
            <td width="164" align="left" ><span class="Estilo17">ASIGNACION INICIAL :</span></td>
            <td width="96" align="right"><span class="Estilo17"><?echo $asignado?></span></td>
                         <td width="346"><span class="Estilo17">&nbsp;</span></td>
          </tr>
                  <tr>
                     <td width="339"><span class="Estilo17">&nbsp;</span></td>
            <td width="164"><span class="Estilo17">MODIFICACIONES :</span></td>
            <td width="96" align="right"><span class="Estilo17"><?echo $modificaciones?></span></td>
                        <td width="346"><span class="Estilo17">&nbsp;</span></td>
          </tr>
                  <tr>
                     <td width="339"><span class="Estilo17">&nbsp;</span></td>
            <td width="164"><span class="Estilo17">ASIGNACION ACTUALIZADA :</span></td>
            <td width="96" align="right"><span class="Estilo17"><?echo $asig_act?></span></td>
                        <td width="346"><span class="Estilo17">&nbsp;</span></td>
          </tr>
                  <tr>
                     <td width="339"><span class="Estilo17">&nbsp;</span></td>
            <td width="164"><span class="Estilo17">COMPROMETIDO :</span></td>
            <td width="96" align="right"><span class="Estilo17"><?echo $comprometido?></span></td>
                        <td width="346"><span class="Estilo17">&nbsp;</span></td>
          </tr>
                  <tr>
                     <td width="339"><span class="Estilo17">&nbsp;</span></td>
            <td width="164"><span class="Estilo17">CAUSADO :</span></td>
            <td width="96" align="right"><span class="Estilo17"><?echo $causado?></span></td>
                        <td width="346"><span class="Estilo17">&nbsp;</span></td>
          </tr>
          <tr>
            <td width="339"><span class="Estilo17">&nbsp;</span></td>
            <td width="164"><span class="Estilo17">PAGADO :</span></td>
            <td width="96"align="right"><span class="Estilo17"><?echo $pagado?></span></td>
            <td width="346"><span class="Estilo17">&nbsp;</span></td>
          </tr>
          <tr>
            <td width="339"><span class="Estilo17">&nbsp;</span></td>
            <td width="164"><span class="Estilo18">DISPONIBLE :</span></td>
            <td width="96" align="right"><span class="Estilo18"><?echo $disponible?></span></td>
            <td width="346"><span class="Estilo17">&nbsp;</span></td>
          </tr>
<? if ($diferido>0){?>
       <tr>
            <td width="259"><span class="Estilo17">&nbsp;</span></td>
            <td width="244"><span class="Estilo17">DIFERIDO :</span></td>
            <td width="96"align="right"><span class="Estilo17"><?echo $dif_presup?></span></td>
            <td width="346"><span class="Estilo17">&nbsp;</span></td>
          </tr>
       <tr>
            <td width="259"><span class="Estilo17">&nbsp;</span></td>
            <td width="244"><span class="Estilo18">DISPONIBILIDAD DIFERIDA :</span></td>
            <td width="96" align="right"><span class="Estilo18"><?echo $disp_dif ?></span></td>
            <td width="346"><span class="Estilo17">&nbsp;</span></td>
          </tr>
<?} ?>
      </table></td>
        </tr>
    </table></td>
  </tr>
</table></td></tr>
</table>