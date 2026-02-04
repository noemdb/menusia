<? include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG001".$usuario_sia.$equipo;
if (!$_GET){ $p_letra='';$criterio=''; $tipo_causado=''; $nro_orden='';
  $sql="SELECT * FROM ORD_PAGO_ANT Order BY nro_orden desc,tipo_causado desc";
  $codigo_mov=substr($mcod_m,0,49);}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){
    $nro_orden=substr($criterio,1,8);  $tipo_causado=substr($criterio,9,4);}
   else{$nro_orden=substr($criterio,0,8);  $tipo_causado=substr($criterio,8,4);}
  $codigo_mov=substr($mcod_m,0,49);
  $clave=$nro_orden.$tipo_causado;
  $sql="Select * FROM ORD_PAGO_ANTwhere tipo_causado='$tipo_causado' and nro_orden='$nro_orden'";
  if ($p_letra=="P"){$sql="SELECT * FROM ORD_PAGO_ANT Order by nro_orden,tipo_causado";}
  if ($p_letra=="U"){$sql="SELECT * FROM ORD_PAGO_ANT Order by nro_orden desc,tipo_causado desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM ORD_PAGO_ANTWhere (text(nro_orden)||text(tipo_causado)>'$clave') Order by nro_orden,tipo_causado";}
  if ($p_letra=="A"){$sql="SELECT * FROM ORD_PAGO_ANTWhere (text(nro_orden)||text(tipo_causado)<'$clave') Order by text(nro_orden)||text(tipo_causado) desc";}
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (ORDENES DE PAGO AÑOS ANTERIORES)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Mover_Registro(MPos){
var murl;
   murl="Act_orden_pago.php";
   if(MPos=="P"){murl="Act_orden_pago.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_orden_pago.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_orden_pago.php?Gcriterio=S"+document.form1.txtnro_orden.value+document.form1.txttipo_causado.value;}
   if(MPos=="A"){murl="Act_orden_pago.php?Gcriterio=A"+document.form1.txtnro_orden.value+document.form1.txttipo_causado.value;}
   document.location = murl;
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 { font-size: 16pt; font-weight: bold;}
.Estilo9 {font-size: 8pt}
.Estilo15 {color: #FF0000; font-weight: bold; font-size: 13pt;}
.Estilo19 {color: #0000CC; font-weight: bold; font-size: 13pt; }

-->
</style>
</head>
<?
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$mconf="";$tipo_causd="0002";$tipo_causc="0001";$tipo_causf="0003";
$Ssql="Select * from SIA005 where campo501='01'";
$resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $tipo_causc=$registro["campo504"];$tipo_causd=$registro["campo505"];$tipo_causf=$registro["campo506"];}
$gen_ord_ret=substr($mconf,0,1); $gen_comp_ret=substr($mconf,1,1); $gen_pre_ret=substr($mconf,2,1);
$nro_aut=substr($mconf,4,1); $fecha_aut=substr($mconf,5,1);
$concepto="";$fecha="";$nombre_abrev_caus=""; $ced_rif="";$nombre=""; $fecha_desde=""; $fecha_hasta=""; $fecha_vencim="";
$func_inv="";$genera_comprobante="";  $inf_usuario="";$anulado="";$modulo="";$mstatus_ord="";$pago_ces="";$ced_rif_ces=""; $nombre_ces="";
$tipo_documento=""; $nro_documento="";$tipo_orden="";$des_tipo_orden="";$cod_banco="";$nombre_cuenta="";$nombre_banco="";
$total_causado=0; $total_retencion=0; $total_ajuste=0; $total_pasivos=0; $monto_am_ant=0;  $total_neto = 0;
$res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="A"){$sql="SELECT * FROM ORD_PAGO_ANT Order by nro_orden,tipo_causado";}
  if ($p_letra=="S"){$sql="SELECT * FROM ORD_PAGO_ANT Order by nro_orden desc,tipo_causado desc";}
  $res=pg_query($sql); $filas=pg_num_rows($res);
}
if($filas>0){
  $registro=pg_fetch_array($res);
  $nro_orden=$registro["nro_orden"];
  $tipo_causado=$registro["tipo_causado"];
  $fecha=$registro["fecha"];
  $concepto=$registro["concepto"];
  $inf_usuario=$registro["inf_usuario"];
  $nombre_abrev_caus=$registro["nombre_abrev_caus"];
  $ced_rif=$registro["ced_rif"];
  $nombre=$registro["nombre"];
  $func_inv=$registro["func_inv"];
  $anulado=$registro["anulado"];
  $pago_ces=$registro["pago_ces"];
  $ced_rif_ces=$registro["ced_rif_ces"];
  $nombre_ces=$registro["nombre_ces"];
  $tipo_documento=$registro["tipo_documento"];
  $nro_documento=$registro["nro_documento"];
  $fecha_desde=$registro["fecha_desde"];
  $fecha_hasta=$registro["fecha_hasta"];
  $fecha_vencim=$registro["fecha_vencim"];
  $tipo_orden=$registro["tipo_orden"];
  $des_tipo_orden=$registro["des_tipo_orden"];
  $cod_banco=$registro["cod_banco"];
  $nombre_cuenta=$registro["nombre_cuenta"];
  $nombre_banco=$registro["nombre_banco"];
  $mstatus_ord=$registro["status"];
  $fecha_c=$registro["fecha_cheque"];
  if($fecha_c==""){$fecha_c="";}else{$fecha_c=formato_ddmmaaaa($fecha_c);}
  $inf_canc="Banco:".$registro["cod_banco"]." Cheque Número:".$registro["nro_cheque"]." Fecha:".$fecha_c;
  if($registro["tipo_pago"]=="NDB"){ $inf_canc="Banco:".$registro["cod_banco"]." Nota Debito:".$registro["nro_cheque"]." Fecha:".$fecha_c;}
  if($registro["tipo_pago"]=="PAG"){ $inf_canc="Pago Presupuestario:".$registro["nro_cheque"]." Fecha:".$fecha_c;}
  $total_causado=$registro["total_causado"];
  $total_retencion=$registro["total_retencion"];
  $total_ajuste=$registro["total_ajuste"];
  $total_pasivos=$registro["total_pasivos"];
  $monto_am_ant=$registro["monto_am_ant"];
  $total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant;
  if($registro["retencion"]=="S"){$total_neto = $total_causado - $total_ajuste;}
  else{if($total_pasivos>0) {$total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant + $total_pasivos;}}
}
$total_causado=formato_monto($total_causado);
$total_retencion=formato_monto($total_retencion);
$total_ajuste=formato_monto($total_ajuste);
$total_pasivos=formato_monto($total_pasivos);
$monto_am_ant=formato_monto($monto_am_ant);
$total_neto=formato_monto($total_neto);
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
$clave=$nro_orden.$tipo_causado;
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha_desde==""){$fecha_desde="";}else{$fecha_desde=formato_ddmmaaaa($fecha_desde);}
if($fecha_hasta==""){$fecha_hasta="";}else{$fecha_hasta=formato_ddmmaaaa($fecha_hasta);}
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}
$criterio=$sfecha.$nro_orden.'O'.$tipo_causado;
if(substr($tipo_causado,0,1)=='A'){$criterio=$sfecha.'A'.substr($nro_orden,1,7).'O'.$tipo_causado;}
?>
<body>
<table width="985" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ORDENES DE PAGO PENDIENTE AÑOS ANTERIORES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="543" border="0" id="tablacuerpo">
  <tr>
    <td><div id="Layer2" style="position:absolute; width:101px; height:523px; z-index:2; top: 73px; left: 7px;">
      <table width="92" height="494" border="1" cellpadding="0" cellspacing="0" id="tablam">
        <td width="86">
            <td>
              <table width="92" height="510" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
         <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
                </tr>
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
                </tr><tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
        </tr>
        <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
        </tr>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_orden_ante.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_orden_ante.php" class="menu">Catalogo</a></td>
        </tr>
         <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
            </table></td>
      </table>
    </div>
    <p>&nbsp;</p></td><td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:866px; height:532px; z-index:1; top: 67px; left: 118px;">
            <form name="form1" method="post">
              <table width="862" align="center">
                <tr>
                  <td width="856"><table width="861">
                      <tr>
                        <td width="102">
                          <p><span class="Estilo5">N&Uacute;MERO ORDEN:</span></p></td>
                        <td width="118"><input name="txtnro_orden" type="text"  id="txtnro_orden" value="<?echo $nro_orden?>" size="12" readonly></td>
                        <td width="143"><span class="Estilo5">DOCUMENTO CAUSADO : </span></td>
                        <td width="48"><span class="Estilo5">
                          <input name="txttipo_causado" type="text"  id="txttipo_causado" value="<?echo $tipo_causado?>" size="6" readonly>
</span> </td>
                        <td width="66"><span class="Estilo5">
                          <input name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus6" value="<?ECHO $nombre_abrev_caus?>" size="6" readonly>
</span></td>
                        <? if($anulado=='S'){?> <td width="109"><span class="Estilo15">ANULADO</span></td>
                        <? }else{if($mstatus_ord=='I'){?> <td width="109"><a class="Estilo19" href="javascript:alert('<?echo $inf_canc?>');">CANCELADA</a>
                        <? }else{if($mstatus_ord=='R'){?> <td width="109"><span class="Estilo19">P/RETENCION</span>
                        <? }else{?> <td width="30"><span class="Estilo5"></span></td><? }}}?>
                        <td width="49"><span class="Estilo5">FECHA :</span> </td>
                        <td width="78"><span class="Estilo5">
                          <input name="txtFecha" type="text" id="txtFecha" value="<?echo $fecha?>" size="12" readonly>
                        </span></td>
                        <td width="22"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                        <td width="23"><img src="../imagenes/s_tbl.png" width="16" height="16" title="Mostrar Cheques de la Orden" onclick="javascript:Ventana_002('Cons_pago_ord.php?clave=<?echo $clave?>','SIA','','650','300','true');"></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="858">
                    <tr>
                      <td width="166"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                      <td width="134"><span class="Estilo5">
                        <input name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="12"  value="<?echo $ced_rif?>" readonly>
                      </span></td>
                      <td width="542"><span class="Estilo5">
                        <input name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="89" readonly>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="859" >
                    <tr>
                      <td width="180" height="30"><span class="Estilo5">CESIONARIO A COBRAR :
                        <? if($pago_ces=="S"){$nchk='checked';}else{$nchk='';} ?>
                       <input name="txtpago_ces" type="checkbox" readonly value="checkbox" <? echo $nchk; ?> >
                      </span></td>
                      <td width="87"><span class="Estilo5">C&Eacute;DULA/RIF : </span></td>
                      <td width="109"><span class="Estilo5">
                        <input name="txtced_rif_ces" type="text" id="txtced_rif_ces" size="14" maxlength="12"  value="<?echo $ced_rif_ces?>" readonly>
                      </span> </span></td>
                      <td width="70"><span class="Estilo5">NOMBRE :</span></td>
                      <td width="383"><span class="Estilo5">
                        <input name="txtnombre_ces" type="text" id="txtnombre_ces" size="59" readonly value="<?echo $nombre_ces?>">
                      </span> </td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="856">
                      <tr>
                        <td width="106"><span class="Estilo5">CONCEPTO:</span></td>
                        <td width="694"><textarea name="txtconcepto" cols="89" readonly="readonly" class="headers" id="txtconcepto"><?echo $concepto?></textarea></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="857" >
                    <tr>
                      <td width="122" height="24"><span class="Estilo5">TIPO DOCUMENTO : </span></td>
                      <td width="137"><span class="Estilo5">
                        <input name="txttipo_documento" type="text" id="txttipo_documento"  readonly value="<?echo $tipo_documento?>" size="20">
                      </span></td>
                      <td width="38"><span class="Estilo5">
                          <td width="125"><span class="Estilo5">NRO. DOCUMENTO : </span></td>
                      <td width="402"><span class="Estilo5">
                        <input name="txtnro_documento" type="text" id="txtnro_documento"  readonly value="<?echo $nro_documento?>" size="61">
</span> </td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="846">
                    <tr>
                      <td width="122"><span class="Estilo5">FECHA DESDE :</span></td>
                      <td width="160"><span class="Estilo5">
                        <input name="txtfecha_desde" type="text" id="txtfecha_desde" size="15" value="<?echo $fecha_desde?>" readonly>
                      </span></td>
                      <td width="101"><span class="Estilo5">FECHA HASTA :</span></td>
                      <td width="183"><span class="Estilo5">
                        <input name="txtfecha_hasta" type="text" id="txtfecha_hasta" value="<?echo $fecha_hasta?>" size="15" readonly>
                      </span></td>
                      <td width="137"><span class="Estilo5">FECHA VENCIMIENTO : </span></td>
                      <td width="115"><span class="Estilo5">
                        <input name="txtfecha_vencim" type="text" id="txtfecha_vencim" value="<?echo $fecha_vencim?>" size="15" readonly>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="856">
                    <tr>
                      <td width="124"><span class="Estilo5">TIPO DE ORDEN :</span></td>
                      <td width="92"><span class="Estilo5">
                        <input name="txtcod_tipo_ord" type="text" id="txtcod_tipo_ord" size="8" maxlength="15"  readonly  value="<?echo $tipo_orden?>">
                      </span> </td>
                      <td width="618"><span class="Estilo5">
                        <input name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" size="98" readonly  value="<?echo $des_tipo_orden?>">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="866" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="116" height="20"><span class="Estilo5">TIPO DE GASTO :</span></td>
                      <td width="126"><span class="Estilo5">
                        <input name="txtfunc_inv" type="text" id="txtfunc_inv"  readonly value="<?echo $func_inv?>" size="12" maxlength="12">
                      </span></td>
                      <td width="141"><span class="Estilo5">BANCO QUE  CANCELA :</span></td>
                      <td width="78"><span class="Estilo5">
                        <input name="txtcod_banco" type="text" id="txtcod_banco"  readonly value="<?echo $cod_banco?>" size="6" maxlength="6">
                      </span></td>
                      <td width="405"><span class="Estilo5">
                        <input name="txtnombre_banco" type="text" id="txtnombre_banco"  readonly value="<?echo $nombre_banco?>" size="60">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
              </table>

        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:312px; z-index:2; left: 2px; top: 300px;">
              <script language="javascript" type="text/javascript">
   var gordr = '<?echo $gen_ord_ret?>';
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "C&oacute;d. Presupuestario";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Retenciones";        // Requiere: <div id="T12" class="tab-body">  ... </div>
   rows[1][3] = "Comprobantes";
             </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_cod_orden.php?clave=<?echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_cons_ret_ord_ant.php?clave=<?echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
                          <!--PESTA&Ntilde;A 3 -->
              <div id="T13" class="tab-body" >
                <iframe src="Det_cons_comp_ord_ant.php?criterio=<?echo $criterio?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>

            </div></td>
         </tr>
        </table>
                <div id="Layer3" style="position:absolute; width:868px; height:60px; z-index:2; left: 2px; top: 640px;">
                <table width="865" border="0">
                <tr>
                <td width="130"> <span class="Estilo5">TOTAL CAUSADO : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_causado; ?></td> </tr>
         </table></td>
                <td width="130" align="right"> <span class="Estilo5">AMORT. ANTICIPO : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $monto_am_ant; ?></td> </tr>
         </table></td>
                 <td width="130" align="right"> <span class="Estilo5">TOTAL PASIVO : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_pasivos; ?></td> </tr>
         </table></td>
                </tr>
                <tr>
                <td width="130"> <span class="Estilo5">RETENCIONES : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_retencion; ?></td> </tr>
         </table></td>
                <td width="130" align="right"> <span class="Estilo5">AJUSTE : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_ajuste; ?></td> </tr>
         </table></td>
                 <td width="130" align="right"> <span class="Estilo5"><strong>NETO</strong> : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_neto; ?></td> </tr>
         </table></td>
                </tr>
         </table></div>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>