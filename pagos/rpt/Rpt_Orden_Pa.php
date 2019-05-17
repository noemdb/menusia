<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG001".$usuario_sia.$equipo;
if (!$_GET){ $p_letra='';$criterio=''; $tipo_causado=''; $nro_orden=''; $sql="SELECT * FROM ORD_PAGO WHERE nro_orden>='$nro_orden_d' AND nro_orden<='00002377' ORDER BY nro_orden,tipo_causado";  $codigo_mov=substr($mcod_m,0,49);}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $nro_orden=substr($criterio,1,8);  $tipo_causado=substr($criterio,9,4);}
   else{$nro_orden=substr($criterio,0,8);  $tipo_causado=substr($criterio,8,4);}
  $codigo_mov=substr($mcod_m,0,49);   $clave=$nro_orden.$tipo_causado;
  $nro_orden_d=$_GET["nro_orden_d"];
  $nro_orden_h=$_GET["nro_orden_h"];
  $sql="Select * from ORD_PAGO WHERE nro_orden>='$nro_orden_d' AND nro_orden<='00002377' ORDER BY nro_orden, tipo_causado";
  print_r ($nro_orden_h);
  if ($p_letra=="P"){$sql="SELECT * FROM ORD_PAGO WHERE nro_orden>='$nro_orden_d' AND nro_orden<='00002377' Order by nro_orden,tipo_causado";}
  if ($p_letra=="U"){$sql="SELECT * From ORD_PAGO WHERE nro_orden>='$nro_orden_d' AND nro_orden<='00002377' Order by nro_orden desc,tipo_causado desc";}
  if ($p_letra=="S"){$sql="SELECT * From ORD_PAGO Where nro_orden>='$nro_orden_d' AND nro_orden<='00002377' AND (text(nro_orden)||text(tipo_causado)>'$clave') Order by nro_orden,tipo_causado";}
  if ($p_letra=="A"){$sql="SELECT * From ORD_PAGO Where nro_orden>='$nro_orden_d' AND nro_orden<='00002377' AND (text(nro_orden)||text(tipo_causado)<'$clave') Order by text(nro_orden)||text(tipo_causado) desc";}
 // print_r ($nro_orden_d);
 // print_r ($nro_orden_h);
 //print_r ($clave);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (ORDENES DE PAGO)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK  href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(mop){
 if(mop=='D'){ document.form2.submit(); }
 if(mop=='C'){ document.form3.submit(); }
 if(mop=='F'){ document.form4.submit(); }
 if(mop=='A'){ document.form5.submit(); }
 if(mop=='R'){ document.form6.submit(); }
}
function Mover_Registro(MPos){
var murl;
   murl="Rpt_Orden_Pa.php";
   if(MPos=="P"){murl="Rpt_Orden_Pa.php?Gcriterio=P"}
   if(MPos=="U"){murl="Rpt_Orden_Pa.php?Gcriterio=U"}
   if(MPos=="S"){murl="Rpt_Orden_Pa.php?Gcriterio=S"+document.form1.txtnro_orden.value+document.form1.txttipo_causado.value;}
   if(MPos=="A"){murl="Rpt_Orden_Pa.php?Gcriterio=A"+document.form1.txtnro_orden.value+document.form1.txttipo_causado.value;}
   document.location = murl;
}
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
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
        color: #000000;
}
.Estilo11 {font-size: 16px}

-->
</style>
</head>
<?
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($codigo_mov==""){$codigo_mov="";}
else{
 $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $res=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG029(4,'$codigo_mov','','','','','2007-01-01',0,0,0,0,0,0,0,0,0,0,0,0,0,0)");$error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 (4,'$codigo_mov','','',0)");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT BORRAR_PAG038 ('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
}
$mconf="";$tipo_causd="0002";$tipo_causc="0001";$tipo_causf="0003";
$Ssql="Select * from SIA005 where campo501='01'"; $resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $tipo_causc=$registro["campo504"];$tipo_causd=$registro["campo505"];$tipo_causf=$registro["campo506"];}
$gen_ord_ret=substr($mconf,0,1); $gen_comp_ret=substr($mconf,1,1); $gen_pre_ret=substr($mconf,2,1);
$nro_aut=substr($mconf,4,1); $fecha_aut=substr($mconf,5,1);
$concepto="";$fecha="";$nombre_abrev_caus=""; $ced_rif="";$nombre=""; $fecha_desde=""; $fecha_hasta=""; $fecha_vencim="";
$func_inv="";$genera_comprobante="";  $inf_usuario="";$anulado="";$modulo=""; $mstatus_ord="";$pago_ces="";$ced_rif_ces=""; $nombre_ces="";
$tipo_documento=""; $nro_documento="";$tipo_orden="";$des_tipo_orden="";$cod_banco="";$nombre_cuenta="";$nombre_banco="";
$total_causado=0; $total_retencion=0; $total_ajuste=0; $total_pasivos=0; $monto_am_ant=0;  $total_neto = 0;
$nro_orden_d=$_GET["nro_orden_d"];$nro_orden_h=$_GET["nro_orden_h"];
$res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM ORD_PAGO WHERE nro_orden>='$nro_orden_d' AND nro_orden<='00002377' Order by nro_orden,tipo_causado";}  if ($p_letra=="S"){$sql="SELECT * From ORD_PAGO  WHERE nro_orden>='$nro_orden_d' AND nro_orden<='00002377' Order by nro_orden desc,tipo_causado desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){
  $registro=pg_fetch_array($res);
  $tipo_causado=$registro["tipo_causado"];
  $nro_orden=$registro["nro_orden"];
  $fecha=$registro["fecha"];
  $beneficiario=$registro["nombre"];
  $nombre_ces=$registro["nombre_ces"];
  $cedula=$registro["ced_rif"];
  $cedula_ces=$registro["ced_rif_ces"];
  $concepto=$registro["concepto"];
  $total_causado=$registro["total_causado"];
  $total_retencion=$registro["total_retencion"];
  $total_ajuste=$registro["total_ajuste"];
  $total_pasivos=$registro["total_pasivos"];
  $monto_am_ant=$registro["monto_am_ant"];
  $total_orden_neto=$total_causado - $total_ajuste + $total_pasivos - $monto_am_ant - $total_retencion;
  //$total_orden_neto=formato_monto($total_orden_neto);
  //print_r($registro);
  $afecta_presu=$registro["afecta_presu"];
  if($afecta_presu=="S"){$nchk='checked';}else{$nchk='';}
  if($afecta_presu=="N"){$nchks='checked';}else{$nchks='';}
}
$criterio=$sfecha.$nro_orden.'O'.$tipo_causado;
$clave=$nro_orden.$tipo_causado;
if(substr($tipo_causado,0,1)=='A'){$criterio=$sfecha.'A'.substr($nro_orden,1,7).'O'.$tipo_causado;}
?>
<body>
<table width="1035" height="35" border="0" bgcolor="#FFFFFF" id="tablam">
  <tr>
  <td width="694""];" height="31"  bgColor=#EAEAEA  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o></td>
    <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('P')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
    <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('A')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
    <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('S')"  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
        <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('U')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
        <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Rpt_Orden_Pago.php')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="Rpt_Orden_Pago.php" class="menu">Menu</a></td>
  </tr>
</table>
<table width="1035" height="38" border="0" bgcolor="#FFFFFF">
  <tr>
    <td width="72" height="44"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="471"><div align="center" class="Estilo2 Estilo6"><div align="left">ORDENES DE PAGO </div></div></td>
    <td width="390"><div align="right"><b>ORDEN DE PAGO NRO.<b> <? echo $nro_orden; ?></b></b></div></td>
  </tr>
</table>
<table width="1024" height="543" border="0" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:885px; height:532px; z-index:1; top: 102px; left: 13px;">
        <form name="form1" method="post">
          <table width="869" border="0">
            <tr>
              <td width="777"><b>
                <input name="txttipo_causado" type="text"  style="visibility:hidden;"  id="txttipo_causado3" value="<?echo $tipo_causado?>" size="12" readonly>
              </b></td>
              <td width="229"><div align="right"><b><b>
                  <input name="txtnro_orden" type="text"  style="visibility:hidden;"  id="txtnro_orden" value="<?echo $nro_orden?>" size="12" readonly>
              </b></b></div></td>
            </tr>
            <tr>
              <td><p>
                  <input type="checkbox" name="txt_con_imp" value="checkbox" <? echo $nchk; ?> >
        Con Imputacion Presupuestaria
        <input type="checkbox" name="txt_sin_imp" value="checkbox" <? echo $nchks; ?> >
        Sin Imputacion Presupuestaria</p></td>
              <td><div align="right"><b>
                Fecha:</b><? echo $fecha; ?>
              </div></td>
            </tr>
            <tr>
              <td><p><b>Beneficiario : </b><? echo $beneficiario; ?></p>
                  <p><b>Cheque a Favor : </b><? echo $nombre_ces; ?></p></td>
              <td><p align="right"><b>Cedula/Rif : </b><? echo $cedula; ?></p>
                  <p align="right"><b>Cedula/Rif : </b><? echo $cedula_ces; ?></p></td>
            </tr>
           <tr>
              <td colspan="2"><p><b>Por la Cantidad de:</b>
                  </p>                <div align="right"></div></td>
            </tr>
                        <tr>
              <td colspan="2"><p><b>Por Concepto de : </b><? echo $concepto; ?></p>                <div align="right"></div></td>
            </tr>
                        <tr>
              <td colspan="2"><p align="right"><b>
                Monto Orden Bs. </b><b><? echo $total_orden_neto; ?></b></p>
              <div align="right"></div></td>
            </tr>
            <tr>
              <td height="30" colspan="2"><table width="1010" height="22">
                <tr>
                  <td height="21">
                    <div id="T11" class="tab-body">
                      <iframe src="Det_cons_ret_orden.php?clave=<?echo $nro_orden?>"  width="1020" height="170" scrolling="auto" frameborder="0"> </iframe>
                  </div></td>
                </tr>
              </table></td>
            </tr>
                        <tr>
                          <td colspan="2"><div align="center"><b>CONTABILIDAD PRESUPUESTARIA</b></div></td>
                    </tr>
                        <tr>
              <td height="49" colspan="2"><table width="1010">
                      <tr>
                        <td>
                         <div id="T11" class="tab-body">
                                        <iframe src="Det_cons_cod_orden_presu.php?clave=<?echo $clave?>"  width="1020" height="300" scrolling="auto" frameborder="0"> </iframe>
                                      </div></td>
                      </tr>
                                        <tr>
                        <td>
                         <div id="T11" class="tab-body">
                                        <iframe src="Det_cons_cod_orden_finan.php?clave=<?echo $clave?>"  width="1020" height="300" scrolling="auto" frameborder="0"> </iframe>
                                      </div></td>
                   </tr>
              </table></td>
            </tr>
                        <tr>
              <td colspan="2"><table border="1" width="1010">
                      <tr>
                        <td ><div align="center">CUENTA POR PAGAR</div></td>
                                                <td ><div align="center">REVISADO POR PRESUPUESTO</div></td>
                                                <td ><div align="center">REVISADO POR CONTABILIDAD</div></td>
                                                <td ><div align="center">GERENCIA DE ADMIN. Y FINANZAS</div></td>
                      </tr>
                                          <tr height="80">
                        <td ><div align="center"></div></td>
                                                <td ><div align="center"></div></td>
                                                <td ><div align="center"></div></td>
                                                <td ><div align="center"></div></td>
                      </tr>
              </table></td>
            </tr>
          </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
