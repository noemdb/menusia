<? include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="02-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
 $opcion="02-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$Mcamino.$reg["campo617"]; } else{ $Mcamino=$Mcamino."N";}
 }$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG001".$usuario_sia.$equipo;
if (!$_GET){ $p_letra='';$criterio=''; $tipo_causado=''; $nro_orden=''; $sql="SELECT * FROM ORD_PAGO_ANT  ORDER BY nro_orden desc,tipo_causado desc";  $codigo_mov=substr($mcod_m,0,49);}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $nro_orden=substr($criterio,1,8);  $tipo_causado=substr($criterio,9,4);}
   else{$nro_orden=substr($criterio,0,8);  $tipo_causado=substr($criterio,8,4);}
  $codigo_mov=substr($mcod_m,0,49);   $clave=$nro_orden.$tipo_causado;
  $sql="Select * from ORD_PAGO_ANT where tipo_causado='$tipo_causado' and nro_orden='$nro_orden'";
  if ($p_letra=="P"){$sql="SELECT * FROM ORD_PAGO_ANT Order by nro_orden,tipo_causado";}
  if ($p_letra=="U"){$sql="SELECT * From ORD_PAGO_ANT Order by nro_orden desc,tipo_causado desc";}
  if ($p_letra=="S"){$sql="SELECT * From ORD_PAGO_ANT Where (text(nro_orden)||text(tipo_causado)>'$clave') Order by nro_orden,tipo_causado";}
  if ($p_letra=="A"){$sql="SELECT * From ORD_PAGO_ANT Where (text(nro_orden)||text(tipo_causado)<'$clave') Order by text(nro_orden)||text(tipo_causado) desc";}
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (ORDENES DE PAGO PERIODOS ANTERIORES)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(mop){
 if(mop=='D'){ document.form2.submit(); }
 if(mop=='C'){ document.form3.submit(); }
 if(mop=='F'){ document.form4.submit(); }
 if(mop=='A'){ document.form5.submit(); }
 if(mop=='R'){ document.form6.submit(); }
}
function Mover_Registro(MPos){var murl;    murl="Act_orden_pago_ant.php";
   if(MPos=="P"){murl="Act_orden_pago_ant.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_orden_pago_ant.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_orden_pago_ant.php?Gcriterio=S"+document.form1.txtnro_orden.value+document.form1.txttipo_causado.value;}
   if(MPos=="A"){murl="Act_orden_pago_ant.php?Gcriterio=A"+document.form1.txtnro_orden.value+document.form1.txttipo_causado.value;}
   document.location = murl;
}
function Llama_Reg_Cancelacion(){var url;var r;
 url="Canc_orden_pago_ant.php?txtnro_orden="+document.form1.txtnro_orden.value+"&txttipo_causado="+document.form1.txttipo_causado.value;
 VentanaCentrada(url,'Registrar Cancelacion de Orden','','800','400','true');
}
function Llama_Cancela_Lote(){var url;var r;
    r=confirm("Esta seguro en Cancelar las Orden de Pago por Lote ?");
    if (r==true) { r=confirm("Esta Realmente seguro en Cancelar las Orden de Pago por Lote ?");
      if (r==true) {  url="Lote_ord_pago_ant.php";
         VentanaCentrada(url,'Cancelar Orden Orden de Pago por Lote','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
}
</script>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
</head>
<?

$mconf="";$tipo_causd="0002";$tipo_causc="0001";$tipo_causf="0003"; $Ssql="Select * from SIA005 where campo501='01'"; $resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $tipo_causc=$registro["campo504"];$tipo_causd=$registro["campo505"];$tipo_causf=$registro["campo506"];}
$gen_ord_ret=substr($mconf,0,1); $gen_comp_ret=substr($mconf,1,1); $gen_pre_ret=substr($mconf,2,1); $nro_aut=substr($mconf,4,1); $fecha_aut=substr($mconf,5,1);
$comp_automatico="S";
$concepto="";$fecha="";$nombre_abrev_caus=""; $ced_rif="";$nombre=""; $fecha_desde=""; $fecha_hasta=""; $fecha_vencim=""; $usuario_siao=""; $inf_anul="";
$func_inv="";$genera_comprobante="";  $inf_usuario="";$anulado="";$modulo=""; $mstatus_ord="";$pago_ces="";$ced_rif_ces=""; $nombre_ces="";
$tipo_documento=""; $nro_documento="";$tipo_orden="";$des_tipo_orden="";$cod_banco="";$nombre_cuenta="";$nombre_banco=""; $orden_permanen="N"; $nro_periodos=0;
$total_causado=0; $total_retencion=0; $total_ajuste=0; $total_pasivos=0; $monto_am_ant=0;  $total_neto = 0;
$res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM ORD_PAGO_ANT Order by nro_orden,tipo_causado";}  if ($p_letra=="S"){$sql="SELECT * From ORD_PAGO_ANT Order by nro_orden desc,tipo_causado desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){$registro=pg_fetch_array($res);
  $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"];
  $concepto=$registro["concepto"];   $inf_usuario=$registro["inf_usuario"];   $nombre_abrev_caus=$registro["nombre_abrev_caus"];
  $ced_rif=$registro["ced_rif"];   $nombre=$registro["nombre"];   $func_inv=$registro["func_inv"];   $anulado="N"; $fecha_anulado=$registro["fecha"]; 
  $pago_ces=$registro["pago_ces"];  $ced_rif_ces=$registro["ced_rif_ces"];   $nombre_ces=$registro["nombre_ces"];
  $tipo_documento=$registro["tipo_documento"];  $nro_documento=$registro["nro_documento"];    $fecha_desde=$registro["fecha_desde"];
  $fecha_hasta=$registro["fecha_hasta"];  $fecha_vencim=$registro["fecha_vencim"];   $tipo_orden=$registro["tipo_orden"];
  $des_tipo_orden=$registro["des_tipo_orden"];   $cod_banco=$registro["cod_banco"];  $nombre_cuenta=$registro["nombre_cuenta"];
  $nombre_banco=$registro["nombre_banco"];   $mstatus_ord=$registro["status"];    $fecha_c=$registro["fecha_cheque"];
  $orden_permanen=$registro["orden_permanen"]; $nro_periodos=$registro["nro_periodos"];
  if($fecha_c==""){$fecha_c="";}else{$fecha_c=formato_ddmmaaaa($fecha_c);} $inf_anul="Orden Anulada con Fecha: ".formato_ddmmaaaa($fecha_anulado);
  $inf_canc="Banco:".$registro["cod_banco"]." Cheque Numero:".$registro["nro_cheque"]." Fecha:".$fecha_c;
  if($registro["tipo_pago"]=="NDB"){ $inf_canc="Banco:".$registro["cod_banco"]." Nota Debito:".$registro["nro_cheque"]." Fecha:".$fecha_c;}
  if($registro["tipo_pago"]=="PAG"){ $inf_canc="Pago Presupuestario:".$registro["nro_cheque"]." Fecha:".$fecha_c;}
  $total_causado=$registro["total_causado"];  $total_retencion=$registro["total_retencion"]; $usuario_siao=$registro["usuario_sia"];
  $total_ajuste=$registro["total_ajuste"];  $total_pasivos=$registro["total_pasivos"];  $monto_am_ant=$registro["monto_am_ant"];
  $total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant;
  if($registro["retencion"]=="S"){$total_neto = $total_causado - $total_ajuste;}
  else{if($total_pasivos>0) {$total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant + $total_pasivos;}}
}
$total_causado=formato_monto($total_causado);$total_retencion=formato_monto($total_retencion);
$total_ajuste=formato_monto($total_ajuste); $total_pasivos=formato_monto($total_pasivos);
$monto_am_ant=formato_monto($monto_am_ant);$total_neto=formato_monto($total_neto);
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="I"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
$clave=$nro_orden.$tipo_causado;
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha_desde==""){$fecha_desde="";}else{$fecha_desde=formato_ddmmaaaa($fecha_desde);}
if($fecha_hasta==""){$fecha_hasta="";}else{$fecha_hasta=formato_ddmmaaaa($fecha_hasta);}
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}
$criterio=$sfecha.$nro_orden.'O'.$tipo_causado;
if(substr($tipo_causado,0,1)=='A'){$criterio=$sfecha.'A'.substr($nro_orden,1,7).'O'.$tipo_causado;}

//if(($usuario_siao=="YROA")and($mstatus_ord=="I")and($nro_orden>="00000730")){$mstatus_ord="N";}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ORDENES DE PAGO PERIODOS ANTERIORES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="543" border="0" id="tablacuerpo">
  <tr>
    <td><div id="Layer2" style="position:absolute; width:102px; height:434px; z-index:2; top: 61px; left: 7px;">
      <table width="92" height="524" border="1" cellpadding="0" cellspacing="0" id="tablam">
        <td width="86">
            <td>
              <table width="92" height="522" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">                
                 <? if ($Mcamino{2}=="S"){?>
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
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_orden_pago_ant.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_orden_pago_ant.php" class="menu">Catalogo</a></td>
        </tr>
        <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>        
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llama_Reg_Cancelacion()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Reg_Cancelacion()" class="menu">Registra Cancelacion</a></td>
        </tr>    

		<?} if(($tipo_u=="A")and($SIA_Cierre=="N")){ ?>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Cancela_Lote();" class="menu">Registra Cancelacion por Lote</a></td>
        </tr>
        		
        <? } } ?>
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
                        <td width="102"><p><span class="Estilo5">N&Uacute;MERO ORDEN:</span></p></td>
                        <td width="118"><input name="txtnro_orden" type="text"  id="txtnro_orden" value="<?echo $nro_orden?>" size="12" readonly></td>
                        <td width="143"><span class="Estilo5">DOCUMENTO CAUSADO : </span></td>
                        <td width="48"><span class="Estilo5"><input name="txttipo_causado" type="text"  id="txttipo_causado" value="<?echo $tipo_causado?>" size="6" readonly></span> </td>
                        <td width="66"><span class="Estilo5"><input name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" value="<?echo $nombre_abrev_caus?>" size="6" readonly></span></td>
                        <? if($anulado=='S'){?> <td width="109"><a class="Estiloanu"  href="javascript:alert('<?echo $inf_anul?>');">ANULADO</a></td>
                        <? }else{if($mstatus_ord=='I'){?> <td width="109"><a class="Estilo11" href="javascript:alert('<?echo $inf_canc?>');">CANCELADA</a>
						<? }else{if($mstatus_ord=='A'){?> <td width="109"><a class="Estilo11" href="javascript:alert('<?echo $inf_canc?>');">ABONADA</a>
                        <? }else{if($mstatus_ord=='L'){?> <td width="109"><span class="Estilo11">LIBERADA</span>
                        <? }else{if($mstatus_ord=='R'){?> <td width="109"><span class="Estilo11">P/RETENCION</span>
                        <? }else{?> <td width="30"><span class="Estilo5"></span></td><? }}}}}?>
                        <td width="49"><span class="Estilo5">FECHA :</span> </td>
                        <td width="78"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" value="<?echo $fecha?>" size="12" readonly> </span></td>
                        <td width="45"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                       </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="858">
                    <tr>
                      <td width="166"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                      <td width="134"><span class="Estilo5"><input name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="12"  value="<?echo $ced_rif?>" readonly> </span></td>
                      <td width="542"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="89" readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="859" >
                    <tr>
                      <td width="180" height="30"><span class="Estilo5">CESIONARIO A COBRAR :
                        <? if($pago_ces=="S"){$nchk='checked';}else{$nchk='';} ?><input name="txtpago_ces" type="checkbox" readonly value="checkbox" <? echo $nchk; ?> ></span></td>
                      <td width="87"><span class="Estilo5">C&Eacute;DULA/RIF : </span></td>
                      <td width="109"><span class="Estilo5"><input name="txtced_rif_ces" type="text" id="txtced_rif_ces" size="14" maxlength="12"  value="<?echo $ced_rif_ces?>" readonly>  </span> </td>
                      <td width="70"><span class="Estilo5">NOMBRE :</span></td>
                      <td width="383"><span class="Estilo5"><input name="txtnombre_ces" type="text" id="txtnombre_ces" size="59" readonly value="<?echo $nombre_ces?>"> </span> </td>
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
                      <td width="137"><span class="Estilo5"><input name="txttipo_documento" type="text" id="txttipo_documento"  readonly value="<?echo $tipo_documento?>" size="20"> </span></td>
                      <td width="38"><span class="Estilo5">
                      <? if($tipo_documento=='FACTURA'){?>
                        <input name="btfacturas" type="button" id="btfacturas" title="Abrir Facturas de la Orden " onClick="Ventana_002('Cons_fact_orden.php?clave=<?echo $clave?>','SIA','','950','450','true')" value="...">
                      <? }else{?> <? }?> </span></td>
                      <td width="125"><span class="Estilo5">NRO. DOCUMENTO : </span></td>
                      <td width="402"><span class="Estilo5"><input name="txtnro_documento" type="text" id="txtnro_documento"  readonly value="<?echo $nro_documento?>" size="61"></span> </td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="846">
                    <tr>
                      <td width="122"><span class="Estilo5">FECHA DESDE :</span></td>
                      <td width="160"><span class="Estilo5"><input name="txtfecha_desde" type="text" id="txtfecha_desde" size="15" value="<?echo $fecha_desde?>" readonly> </span></td>
                      <td width="101"><span class="Estilo5">FECHA HASTA :</span></td>
                      <td width="183"><span class="Estilo5"><input name="txtfecha_hasta" type="text" id="txtfecha_hasta" value="<?echo $fecha_hasta?>" size="15" readonly> </span></td>
                      <td width="137"><span class="Estilo5">FECHA VENCIMIENTO : </span></td>
                      <td width="115"><span class="Estilo5"><input name="txtfecha_vencim" type="text" id="txtfecha_vencim" value="<?echo $fecha_vencim?>" size="15" readonly></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="856">
                    <tr>
                      <td width="124"><span class="Estilo5">TIPO DE ORDEN :</span></td>
                      <td width="92"><span class="Estilo5"><input name="txtcod_tipo_ord" type="text" id="txtcod_tipo_ord" size="8" maxlength="15"  readonly  value="<?echo $tipo_orden?>"></span> </td>
                      <td width="618"><span class="Estilo5"><input name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" size="98" readonly  value="<?echo $des_tipo_orden?>"></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="866" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="116" height="20"><span class="Estilo5">TIPO DE GASTO :</span></td>
                      <td width="126"><span class="Estilo5"><input name="txtfunc_inv" type="text" id="txtfunc_inv"  readonly value="<?echo $func_inv?>" size="12" maxlength="12"></span></td>
                      <? if ($orden_permanen=="S"){?>
					    <td width="241" align="right" ><span class="Estilo5">ORDEN PERMANENTE : </span></td>
                        <td width="88" align="center"><span class="Estilo5"><input name="txtord_per" type="text" id="txtord_per"  readonly value="SI" size="2" maxlength="2"> </span></td>
                        <td width="155"><span class="Estilo5">NUMERO DE PERIODOS :</span></td>
						<td width="140"><span class="Estilo5"><input name="txtnro_periodos" type="text" id="txnro_periodos"  readonly value="<?echo $nro_periodos?>" size="2" maxlength="2"> </span></td>
                        
					  <?} else {?>
					  <td width="141"><span class="Estilo5">BANCO QUE  CANCELA :</span></td>
                      <td width="78"><span class="Estilo5"><input name="txtcod_banco" type="text" id="txtcod_banco"  readonly value="<?echo $cod_banco?>" size="6" maxlength="6"> </span></td>
                      <td width="405"><span class="Estilo5"><input name="txtnombre_banco"  type="text" id="txtnombre_banco"  readonly value="<?echo $nombre_banco?>" size="60"></span></td>
                      <?} ?>
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
                <iframe src="Det_cons_cod_orden_ant.php?clave=<?echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_cons_ret_orden_ant.php?clave=<?echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
               <!--PESTA&Ntilde;A 3 -->
              <div id="T13" class="tab-body" >
                <iframe src="Det_cons_comp_orden_ant.php?criterio=<?echo $criterio?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
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