<? include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){ $nro_orden="";$tipo_causado=""; $mcod_m="PAG001".$equipo;$codigo_mov=substr($mcod_m,0,49);}
 else{$nro_orden=$_GET["txtnro_orden"];  $tipo_causado=$_GET["txttipo_causado"];  $codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (MODIFICAR ORDENES DE PAGO)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function llamar_anterior(){ document.location ='Act_orden_pago.php?Gcriterio=C<? echo $nro_orden.$tipo_causado;?>'; }
function checkcedrif(mform){var mref; var mnomb;
   mref=mform.txtced_rif.value;   mnomb=mform.txtnombre.value;
   mform.txtced_rif_ces.value=mref;   mform.txtnombre_ces.value=mnomb;
  return true;}
function apaga_cedrif(mthis){var mref;var mnomb;
 apagar(mthis); mref=mthis.value;
 mnomb=document.form1.txtnombre.value; document.form1.txtced_rif_ces.value=mref; document.form1.txtnombre_ces.value=mnomb;
}
function checktipodoc(mform){var mref;
   mref=mform.txttipo_documento.value;
   ajaxSenddoc('GET', 'btfactura.php?tipo_doc='+mref+'&codigo_mov=<?echo $codigo_mov?>', 'btdoc', 'innerHTML');
   ajaxSenddoc('GET', 'nrodocun.php?tipo_doc='+mref, 'nrdoc', 'innerHTML');
return true;}
function apaga_tipodoc(mthis){var mref;
 apagar(mthis);
 mref=mthis.value;
 ajaxSenddoc('GET', 'btfactura.php?tipo_doc='+mref+'&refcomp=N&codigo_mov=<?echo $codigo_mov?>', 'btdoc', 'innerHTML');
 ajaxSenddoc('GET', 'nrodocun.php?tipo_doc='+mref, 'nrdoc', 'innerHTML');
}
function checkrefecha_desde(mform){var mref; var mfec;
  mref=mform.txtfecha_desde.value;
  if(mform.txtfecha_desde.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_desde.value=mfec;}
return true;}
function checkrefecha_hasta(mform){var mref; var mfec;  mref=mform.txtfecha_hasta.value;
  if(mform.txtfecha_hasta.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtfecha_hasta.value=mfec;}
return true;}
function checkrefecha_venc(mform){var mref;var mfec;
  mref=mform.txtfecha_vencim.value;
  if(mform.txtfecha_vencim.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_vencim.value=mfec;}
return true;}
function Llamar_factura(){var ced_rif; var mref_comp='N';
  ced_rif=document.form1.txtced_rif.value;   mref_comp=document.form1.txtref_compromiso.value;
  Ventana_002('Det_inc_fact_ord.php?codigo_mov=<?echo $codigo_mov?>&ref_comp='+mref_comp+'&ced_rif='+ced_rif,'SIA','','980','400','true')
return true;}
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia"); f.txtfecha.focus();return false;}
    if(f.txtnro_orden.value==""){alert("Numero de Orden no puede estar Vacia");return false;}  else{f.txtnro_orden.value=f.txtnro_orden.value;}
    if(f.txttipo_causado.value==""){alert("Tipo de Causado no puede estar Vacio"); return false; }  else{f.txttipo_causado.value=f.txttipo_causado.value.toUpperCase();}
    if(f.txtconcepto.value==""){alert("Concepto de la Orden no puede estar Vacia"); return false; }  else{f.txtconcepto.value=f.txtconcepto.value.toUpperCase();}
    if(f.txtnro_orden.value.length==8){f.txtnro_orden.value=f.txtnro_orden.value.toUpperCase();f.txtnro_orden.value=f.txtnro_orden.value;}  else{alert("Longitud de Numero de Orden  Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;} else{alert("Longitud de Fecha Invalida"); f.txtfecha.focus();return false;}
    if(f.txttipo_causado.value=="0000" || f.txttipo_causado.value=="A000" ) {alert("Tipo de Causado No Aceptado");return false; }
    if(f.txtfecha_desde.value.length==10){Valido=true;}  else{alert("Longitud de Fecha desde Invalida"); f.txtfecha_desde.focus();  return false;}
    if(f.txtfecha_hasta.value.length==10){Valido=true;}  else{alert("Longitud de Fecha hasta Invalida");  f.txtfecha_hasta.focus();  return false;}
    if(f.txtfecha_vencim.value.length==10){Valido=true;}  else{alert("Longitud de Fecha vencimiento Invalida"); f.txtfecha_vencim.focus(); return false;}
    if(f.txtced_rif.value==""){alert("Cedula/Rif del Beneficiario no puede estar Vacia"); f.txtced_rif.focus(); return false; }  else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
if(f.txtpago_ces.checked==true){ f.txtp_ces.value="S"; } else{ f.txtp_ces.value="N"; }
document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
function Llama_ant_orden(){ var murl;
  murl="anterior_orden_pago.php?Gcriterio="+document.form1.txtnro_orden.value+document.form1.txttipo_causado.value+"&codigo_mov=<?echo $codigo_mov?>"; 
  document.location=murl;	
}
function Llama_siguiente(){ var murl;
  murl="siguiente_orden_pago.php?Gcriterio="+document.form1.txtnro_orden.value+document.form1.txttipo_causado.value+"&codigo_mov=<?echo $codigo_mov?>"; 
  document.location=murl;	
}
</script>
</head>
<? $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from ORD_PAGO where tipo_causado='$tipo_causado' and nro_orden='$nro_orden'";
if ($codigo_mov==""){$codigo_mov="";}
else{
 $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $res=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG029(4,'$codigo_mov','','','','','2007-01-01',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','')");$error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 (4,'$codigo_mov','','',0)");  $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT BORRAR_PAG038 ('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
}
$concepto="";$fecha="";$nombre_abrev_caus=""; $ced_rif="";$nombre=""; $fecha_desde=""; $fecha_hasta=""; $fecha_vencim=""; $func_inv="";$genera_comprobante="";  $inf_usuario="";$anulado="";$modulo=""; $ref_compromiso='';
$total_causado=0; $total_retencion=0; $total_ajuste=0; $total_pasivos=0; $monto_am_ant=0;  $total_neto = 0;
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
  $nro_orden=$registro["nro_orden"];   $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"];  $concepto=$registro["concepto"];
  $inf_usuario=$registro["inf_usuario"];  $nombre_abrev_caus=$registro["nombre_abrev_caus"]; $ref_compromiso=$registro["ref_compromiso"];
  $ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];  $func_inv=$registro["func_inv"];
  $anulado=$registro["anulado"];  $pago_ces=$registro["pago_ces"];  $ced_rif_ces=$registro["ced_rif_ces"];
  $nombre_ces=$registro["nombre_ces"];  $tipo_documento=$registro["tipo_documento"];  $nro_documento=$registro["nro_documento"];
  $fecha_desde=$registro["fecha_desde"];   $fecha_hasta=$registro["fecha_hasta"];   $fecha_vencim=$registro["fecha_vencim"];
  $tipo_orden=$registro["tipo_orden"];   $des_tipo_orden=$registro["des_tipo_orden"];   $cod_banco=$registro["cod_banco"];
  $nombre_cuenta=$registro["nombre_cuenta"];   $nombre_banco=$registro["nombre_banco"];  $mstatus_ord=$registro["status"];
  $fecha_c=$registro["fecha_cheque"];
  if($fecha_c==""){$fecha_c="";}else{$fecha_c=formato_ddmmaaaa($fecha_c);}
  $inf_canc="Banco:".$registro["cod_banco"]." Cheque Número:".$registro["nro_cheque"]." Fecha:".$fecha_c;
  if($registro["tipo_pago"]=="NDB"){ $inf_canc="Banco:".$registro["cod_banco"]." Nota Debito:".$registro["nro_cheque"]." Fecha:".$fecha_c;}
  if($registro["tipo_pago"]=="PAG"){ $inf_canc="Pago Presupuestario:".$registro["nro_cheque"]." Fecha:".$fecha_c;}
  $total_causado=$registro["total_causado"];   $total_retencion=$registro["total_retencion"];   $total_ajuste=$registro["total_ajuste"];
  $total_pasivos=$registro["total_pasivos"];   $monto_am_ant=$registro["monto_am_ant"];
  $total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant;
  if($registro["retencion"]=="S"){$total_neto = $total_causado - $total_ajuste;}
  else{if($total_pasivos>0) {$total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant + $total_pasivos;}}
}
$total_causado=formato_monto($total_causado); $total_retencion=formato_monto($total_retencion);
$total_ajuste=formato_monto($total_ajuste); $total_pasivos=formato_monto($total_pasivos);
$monto_am_ant=formato_monto($monto_am_ant); $total_neto=formato_monto($total_neto);
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
$ref_compromiso=substr($ref_compromiso,0,1);
$clave=$nro_orden.$tipo_causado;
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha_desde==""){$fecha_desde="";}else{$fecha_desde=formato_ddmmaaaa($fecha_desde);}
if($fecha_hasta==""){$fecha_hasta="";}else{$fecha_hasta=formato_ddmmaaaa($fecha_hasta);}
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}
$criterio=$sfecha.$nro_orden.'O'.$tipo_causado;
$sSQL="SELECT tipo_causado, nombre_tipo_caus,nombre_abrev_caus from pre003 Where (tipo_causado='$tipo_causado')";
$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); $nombre_tipo_caus="";
if ($filas>0){ $reg=pg_fetch_array($resultado); $nombre_tipo_caus=$reg["nombre_abrev_caus"]; }
$resultado=pg_exec($conn,"SELECT CARGA_PAG029('$codigo_mov','$nro_orden')"); $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR ORDEN DE PAGO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="558" border="0" id="tablacuerpo">
  <tr>
     <td><table width="92" height="542" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablam">
        <td width="86">
      <td><table width="92" height="542" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:llamar_anterior();";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:llamar_anterior();">Atras</A></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
        </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:427px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Update_orden.php" onSubmit="return revisar()">
      <table width="867" >
              <tr>
                <td>
                  <table width="846" align="center">
                    <tr> <td>&nbsp;</td> </tr>
                    <tr>
                      <td><table width="847" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">N&Uacute;MERO ORDEN:</span></td>
                          <td width="97"><input class="Estilo10" name="txtnro_orden" type="text"  id="txtnro_orden" size="12" maxlength="8" value="<?echo $nro_orden?>" readonly></td>
                          <td width="55"><span class="Estilo5"> </span></td>
                          <td width="145"><span class="Estilo5">DOCUMENTO CAUSADO:</span></td>
                          <td width="58"><span class="Estilo5"><input class="Estilo10" name="txttipo_causado" type="text"  id="txttipo_causado" size="6" maxlength="4"  value="<?echo $tipo_causado?>"  readonly>  </span></td>
                          <td width="170"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" size="6"  value="<?echo $nombre_tipo_caus?>" readonly>   </span></td>
                          <td width="60"><span class="Estilo5">FECHA :</span> </td>
                          <td width="108"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10"  value="<?echo $fecha?>" readonly>  </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="854">
                        <tr>
                          <td width="155"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="101"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="15" onFocus="encender(this); " onBlur="apaga_cedrif(this);" onchange="checkcedrif(this.form);" value="<?echo $ced_rif?>" onkeypress="return stabular(event,this)">   </span></td>
                          <td width="44"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_benef_orden.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">  </span></td>
                          <td width="529"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="84" readonly value="<?echo $nombre?>" onkeypress="return stabular(event,this)"> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="859" >
                        <tr>
                          <td width="176" height="30"><span class="Estilo5">CESIONARIO A COBRAR : <input class="Estilo10" name="txtpago_ces" type="checkbox" value="checkbox" onkeypress="return stabular(event,this)"> </span></td>
                          <td width="92"><span class="Estilo5">C&Eacute;DULA/RIF : </span></td>
                          <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtced_rif_ces" type="text" id="txtced_rif_ces" size="14" maxlength="12" onFocus="encender(this); " onBlur="apagar(this);"  value="<?echo $ced_rif_ces?>" onkeypress="return stabular(event,this)"></span> </td>
                          <td width="70"><span class="Estilo5">NOMBRE :</span></td>
                          <td width="377"><span class="Estilo5"><input class="Estilo10" name="txtnombre_ces" type="text" id="txtnombre_ces" size="59" onFocus="encender(this); " onBlur="apagar(this);" value="<?echo $nombre_ces?>" onkeypress="return stabular(event,this)"> </span> </td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="847" border="0">
                        <tr>
                          <td width="80"><span class="Estilo5">CONCEPTO:</span></td>
                          <td width="757"><textarea name="txtconcepto" cols="95" onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="txtconcepto" onkeypress="return stabular(event,this)"><?echo $concepto?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="857" >
                        <tr>
                          <td width="123" height="24"><span class="Estilo5">TIPO DOCUMENTO : </span></td>
                          <td width="174"><span class="Estilo5"> <div id="tipodoc"><select name="txttipo_documento" id="txttipo_documento" onFocus="encender(this)" onBlur="apaga_tipodoc(this);" onchange="checktipodoc(this.form);" onkeypress="return stabular(event,this)">
                              <option value="  ">   </option></select></div>
                          <script language="JavaScript" type="text/JavaScript"> var mtipod='<?php echo $tipo_documento ?>'; ajaxSenddoc('GET', 'cargatipodoc.php?password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&tipo_doc='+mtipod, 'tipodoc', 'innerHTML'); </script>
                          </span></td>
                          <td width="40"><span class="Estilo5"><div id="btdoc"><input class="Estilo10" name="btfacturas" type="button" id="btfacturas" title="Registrar Facturas de la Orden " onClick="Llamar_factura()" value="...">  </div>      </span></td>
                          <td width="145"><span class="Estilo5">NUMERO DOCUMENTO :</span></td>
                          <td width="351"><span class="Estilo5"> <div id="nrdoc"><input class="Estilo10" name="txtnro_documento" type="text" id="txtnro_documento"  onFocus="encender(this); " onBlur="apagar(this);"  size="55"  value="<?echo $nro_documento?>" onkeypress="return stabular(event,this)">  </div>
                         </span> </td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="850">
                        <tr>
                          <td width="123"><span class="Estilo5">TIPO DE ORDEN :</span>  </td>
                          <td width="73"><span class="Estilo5"><input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" size="8" maxlength="15"   readonly  value="<?echo $tipo_orden?>"  onkeypress="return stabular(event,this)">   </span> </td>
                          <td width="14"><span class="Estilo5"></span></td>
                          <td width="620"><span class="Estilo5"><div id="destord"> <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" size="90" readonly value="<?echo $des_tipo_orden?>" onkeypress="return stabular(event,this)"> </div>   </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="855">
                        <tr>
                          <td width="122"><span class="Estilo5">FECHA DESDE :</span></td>
                          <td width="188"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="15" onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $fecha_desde?>" onkeypress="return stabular(event,this)"> </span></td>
                          <td width="106"><span class="Estilo5">FECHA HASTA :</span></td>
                          <td width="162"><span class="Estilo5"><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="15" onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $fecha_hasta?>" onkeypress="return stabular(event,this)"> </span></td>
                          <td width="143"><span class="Estilo5">FECHA VENCIMIENTO :</span></td>
                          <td width="106"><span class="Estilo5"><input class="Estilo10" name="txtfecha_vencim" type="text" id="txtfecha_vencim" size="15" onchange="checkrefecha_venc(this.form)" onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $fecha_vencim?>" onkeypress="return stabular(event,this)" > </span></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
          </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"></td>
         </tr>
        </table>
        <div id="Layer3" style="position:absolute; width:868px; height:121px; z-index:2; left: 3px; top: 432px;">
        <table width="854">
          <tr>
            <td width="100"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100"><input name="txtp_ces" type="hidden" id="txtp_ces" value="N"></td>
			
			<td width="100"><input name="btanterior" type="button" id="btanterior" value="ANTERIOR" onClick="javascript:Llama_ant_orden();"></td>
            <td width="100"><input name="txtcaus_directo" type="hidden" id="txtcaus_directo" value="NO"></td>
			<td width="100"><input name="btsiguiente" type="button" id="btsiguiente" value="SIGUIENTE" onClick="javascript:Llama_siguiente();"></td>
			<td width="100"><input name="txtref_compromiso" type="hidden" id="txtref_compromiso" value="<?echo $ref_compromiso?>"></td>
            <td width="128" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
          </tr>
        </table>
        </div>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
var f=document.form1; f.txtced_rif.focus();
</script>