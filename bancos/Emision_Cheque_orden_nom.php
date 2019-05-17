<?include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php");include ("../class/configura.inc");
if (!$_GET){$continua="N";}else{$continua=$_GET["continua"];}  $fecha_hoy=asigna_fecha_hoy();
$equipo = getenv("COMPUTERNAME"); $mcod_m = "BAN0064".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); 
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if($SIA_Cierre=="N"){$error=0;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$fecha_fin=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}
if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA'); document.location='menu.php';</script><?}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Emision de Cheques a Orden Nomina)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_ban.js" type="text/javascript"></script>
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
var mcodigo_mov='<?php echo $codigo_mov ?>';

function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 


function apaga_banco(mthis){var mref;
   apagar(mthis);
   mref=document.form1.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  document.form1.txtcod_banco.value=mref;
   ajaxSenddoc('GET', 'numchq.php?cod_banco='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrochq', 'innerHTML');
return true;}
function chequea_banco(mform){
var mref;
   mref=mform.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  mform.txtcod_banco.value=mref;
   ajaxSenddoc('GET', 'numchq.php?cod_banco='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrochq', 'innerHTML');
 return true;}
function apaga_numchq(mthis){
var mref; var nchq;  var fchq; var tpago; var mfechad; var mfechah; var morden;
   apagar(mthis);
   mref=document.form1.txtcod_banco.value;  mfechad=document.form1.txtfecha.value;  mfechah=document.form1.txtfecha.value; nchq=document.form1.txtnro_cheque.value;  nchq=Rellenarizq(nchq,"0",8);  document.form1.txtnro_cheque.value=nchq;    fchq=document.form1.txtfecha.value;  tpago=document.form1.txttipo_pago.value;  morden=mform.txtnro_orden.value;
   ajaxSenddoc('GET', 'vbanchqp.php?codigo_mov='+mcodigo_mov+'&cbanco='+mref+'&fechad='+mfechad+'&fechah='+mfechah+'&ncheque='+nchq+'&fecha='+fchq+'&tpago='+tpago+'&norden='+morden+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'ncheque', 'innerHTML');
return true;}
function chequea_numchq(mform){
var mref; var nchq;  var fchq; var tpago; var mfechad; var mfechah; var morden;
   mref=mform.txtcod_banco.value;  mfechad=mform.txtfecha.value;  mfechah=mform.txtfecha.value; nchq=mform.txtnro_cheque.value;  nchq=Rellenarizq(nchq,"0",8);  mform.txtnro_cheque.value=nchq; fchq=mform.txtfecha.value;  tpago=mform.txttipo_pago.value;  morden=mform.txtnro_orden.value;
   ajaxSenddoc('GET', 'vbanchqp.php?codigo_mov='+mcodigo_mov+'&cbanco='+mref+'&fechad='+mfechad+'&fechah='+mfechah+'&ncheque='+nchq+'&fecha='+fchq+'&tpago='+tpago+'&norden='+morden+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'ncheque', 'innerHTML');
return true;}

function checkreferencia(mform){var mref;
var mref; var nchq;  var fchq; var tpago; var mfechad; var mfechah; var morden;
   morden=mform.txtnro_orden.value;   morden=Rellenarizq(morden,"0",8);   mform.txtnro_orden.value=morden;
   mref=mform.txtcod_banco.value;  mfechad=mform.txtfecha.value;  mfechah=mform.txtfecha.value; nchq=mform.txtnro_cheque.value;   fchq=mform.txtfecha.value;  tpago=document.form1.txttipo_pago.value;  
  /* ajaxSenddoc('GET', 'vbanchqp.php?codigo_mov='+mcodigo_mov+'&cbanco='+mref+'&fechad='+mfechad+'&fechah='+mfechah+'&ncheque='+nchq+'&fecha='+fchq+'&tpago='+tpago+'&norden='+morden+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'ncheque', 'innerHTML'); */
return true;}


function apaga_orden(mthis){
var mref; var nchq;  var fchq; var tpago; var mfechad; var mfechah; var morden;
   apagar(mthis); morden=document.form1.txtnro_orden.value;  morden=Rellenarizq(morden,"0",8);   document.form1.txtnro_orden.value=morden;
   mref=document.form1.txtcod_banco.value;  mfechad=document.form1.txtfecha.value;  mfechah=document.form1.txtfecha.value; nchq=document.form1.txtnro_cheque.value;     fchq=document.form1.txtfecha.value;  tpago=document.form1.txttipo_pago.value;  
   ajaxSenddoc('GET', 'vbanchqp.php?codigo_mov='+mcodigo_mov+'&cbanco='+mref+'&fechad='+mfechad+'&fechah='+mfechah+'&ncheque='+nchq+'&fecha='+fchq+'&tpago='+tpago+'&norden='+morden+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'ncheque', 'innerHTML');
return true;}

function Cargar_abono(mthis){ var mref; var mmonto; var mper; var mdisp; var mmonto_per;
   mper=document.form1.txtnro_periodos.value; mdisp=document.form1.txtdispo_ord.value;
   if(mper>0){ mmonto_per=document.form1.txttotal_orden.value; mmonto_per=quitaformatomonto(mmonto_per);
	 mmonto_per=(mmonto_per*1);  mmonto_per=(mmonto_per/mper);   mmonto_per=Math.round(mmonto_per*100)/100; 
	 if(mmonto_per>mdisp){ document.form1.txtmonto_cheque.value=mdisp;}	else{document.form1.txtmonto_cheque.value=mmonto_per;}	 
   }else{ document.form1.txtmonto_cheque.value=mdisp; }
   asigna_monto_chq();
return true;}

function revisar(){var f=document.form1;
    if(f.txtcod_banco.value==""){alert("Codigo de Banco no puede estar Vacio");return false;}
    if(f.txtnombre_banco.value==""){alert("Nombre de Banco no puede estar Vacio");return false;} else{f.txtnombre_banco.value=f.txtnombre_banco.value.toUpperCase();}
    if(f.txtcod_banco.value.length==4){f.txtcod_banco.value=f.txtcod_banco.value.toUpperCase();} else{alert("Longitud Codigo de Banco Invalida");return false;}
    if(f.txtced_rif.value==""){alert("Cedula/Rif no puede estar Vacio");return false;}
    if(f.txtconcepto.value==""){alert("Concepto no puede estar Vacio");return false;}else{f.txtconcepto.value=f.txtconcepto.value.toUpperCase();}
    if(f.txtmonto_cheque.value==""){alert("Monto no puede estar Vacio");return false;}
	if(f.txtnro_orden.value==""){alert("Numero de Orden no puede estar Vacia");return false;}else{f.txtnro_orden.value=f.txtnro_orden.value;}
    if(f.txttipo_causado.value==""){alert("Tipo de Causado no puede estar Vacio"); return false; }else{f.txttipo_causado.value=f.txttipo_causado.value.toUpperCase();}
document.form1.submit;
return true;}
function apaga_monto(mthis){
   apagar(mthis);  asigna_monto_chq(); 
return true;}
function chequea_monto(mform){var mref; var mmonto; var mcuen; var morden;
   mref=mform.txtcod_banco.value;  mmonto=mform.txtmonto_cheque.value; mcuen=mform.txtcod_contable_o.value; morden=mform.txtnro_orden.value;   
return true;}
function asigna_monto_chq(){var mref; var mmonto; var mcuen; var morden; var mret; var mpas;
   mref=document.form1.txtcod_banco.value; mcuen=document.form1.txtcod_contable_o.value;  mmonto=document.form1.txtmonto_cheque.value;  mmonto=camb_punto_coma(mmonto);    morden=document.form1.txtnro_orden.value;  mret=document.form1.txttotal_retencion.value;  mpas=document.form1.txttotal_pasivos.value; 
   ajaxSenddoc('GET', 'pagandbper.php?monto='+mmonto+'&codigo_mov='+mcodigo_mov+'&monto_ret='+mret+'&monto_pas='+mpas+'&orden='+morden+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML');
   ajaxSenddoc('GET', 'gasiencomper.php?cod_banco='+mref+'&monto='+mmonto+'&mcuen='+mcuen+'&codigo_mov='+mcodigo_mov+'&orden='+morden+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T13', 'innerHTML');
   document.form1.txtmonto_cheque.value=mmonto;
}
</script>
</head>
<?
$nombre_benef="";  $ced_rif=""; $nro_orden=""; $tipo_caus=""; $fecha_ord=""; $total_orden=0; $total_abono=0; $resta=0; $cod_contable_o="";  $concepto=""; $dispo_ord=0;
$tipo_pago="0001"; $nombre_abrev="CHQ"; $cod_banco="0001"; $nro_cuenta=""; $nombre_banco=""; $nro_cheque="00000000"; $fecha=$fecha_hoy; $fecha_hasta=nextDate($fecha,30); $fecha_desde=prevDate($fecha,30);
$mconf="";  $Ssql="Select * from SIA005 where campo501='02'"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $tipo_pago=$registro["campo504"];}
$resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); 
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); 
if($continua=="S"){
$StrSQL="select * from ban030 where codigo_mov='$codigo_mov'"; $res=pg_query($StrSQL); $filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $ced_rif=$registro["campo_str1"]; $nro_orden=$registro["campo_str2"]; $multiple=$registro["status_1"]; $cod_banco=$registro["cod_banco"]; $nro_cheque=$registro["num_cheque"]; $fecha=formato_ddmmaaaa($registro["fecha"]); $fecha_desde=formato_ddmmaaaa($registro["fecha_d"]); $fecha_hasta=formato_ddmmaaaa($registro["fecha_h"]);}
$sql="SELECT * FROM bancos where cod_banco='".$cod_banco."'"; $res=pg_query($sql);$filas=pg_num_rows($res); if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $codc_banco=$registro["cod_contable"]; }
$sSQL="SELECT nombre FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if ($filas>=1){$registro=pg_fetch_array($resultado,0); $nombre_benef=$registro["nombre"];}
$sql="Select * from ORD_PAGO where nro_orden='$nro_orden' and anulado='N'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res,0);   $tipo_caus=$registro["tipo_causado"];  $ced_rif=$registro["ced_rif"]; $nombre_benef=$registro["nombre"]; $fecha_ord=$registro["fecha"];
  $orden_permanen=$registro["orden_permanen"]; $nro_periodos=$registro["nro_periodos"]; $concepto=$registro["concepto"];  $cod_contable_o=$registro["cod_contable_o"]; $tipo_orden=$registro["tipo_orden"];
  $anulado=$registro["anulado"]; $mstatus_ord=$registro["status"]; $pago_ces=$registro["pago_ces"];  $ced_rif_ces=$registro["ced_rif_ces"];   $nombre_ces=$registro["nombre_ces"]; 
  $total_orden=$registro["total_causado"]-$registro["total_ajuste"]-$registro["total_retencion"]-$registro["monto_am_ant"]+$registro["total_pasivos"];  $total_abono=$registro["total_pagado"]; 
  $total_neto = $registro["total_causado"]-$registro["total_ajuste"]-$registro["total_retencion"]-$registro["monto_am_ant"]+$registro["total_pasivos"]-$registro["total_pagado"] ;
  $dispo_ord=$total_neto; 	$resta=$total_neto;  $total_neto=0;  $error=0;  if($total_abono==0){$total_retencion=$registro["total_retencion"]; $total_pasivos=$registro["total_pasivos"]; $nro_orden_ret=$nro_orden;}else{$total_retencion=0;$total_pasivos=0;$nro_orden_ret="";}
  if($anulado=="S"){ $error=1; ?><script language="JavaScript">muestra('ORDEN DE PAGO ESTA ANULADA');</script><? }
  if($mstatus_ord=="I"){ $error=1; ?><script language="JavaScript">muestra('ORDEN DE PAGO ESTA CANCELADA');</script><? }
  if(($tipo_orden=="0005")or($tipo_orden=="0015")or($tipo_orden=="0016")){$error=$error;}else{ echo $tipo_orden; $error=1; ?><script language="JavaScript">muestra('TIPO DE ORDEN NO ES VALIDO');</script><? }  
  
  if($error==1){ $tipo_caus=""; $fecha_ord=""; $total_orden=0; $total_abono=0; $resta=0;  $concepto=""; $dispo_ord=0; }
  if($error==0){ $sql="select pre037.referencia_caus,pre037.tipo_causado,pre037.referencia_comp,pre037.tipo_compromiso,pre037.cod_presup,pre037.fuente_financ,pre037.monto,pre037.ajustado,pre037.tipo_imput_presu,pre037.ref_imput_presu,pre037.monto_credito,pre037.pagado,pre037.amort_anticipo,pre007.ref_aep,pre007.num_proyecto,pre007.fecha_aep,pre007.func_inv,pre003.ref_compromiso from pre037,pre007 Left Join pre003 On (pre003.tipo_causado=pre007.tipo_causado) where (pre037.referencia_caus=pre007.referencia_caus) and (pre037.tipo_causado=pre007.tipo_causado) and (pre037.referencia_comp=pre007.referencia_comp) and (pre037.tipo_compromiso=pre007.tipo_compromiso) and (pre007.referencia_caus='$nro_orden') and (pre007.tipo_causado='$tipo_caus') order by cod_presup,fuente_financ"; $res=pg_query($sql);
    while($reg=pg_fetch_array($res)){ $monto_c=$reg["monto"]-$reg["ajustado"]; $pagado=$reg["pagado"]; $cod_presup=$reg["cod_presup"]; $fuente_financ=$reg["fuente_financ"];  $referencia_comp=$reg["referencia_comp"]; $tipo_compromiso=$reg["tipo_compromiso"]; $tipo_imput_presu=$reg["tipo_imput_presu"];  $ref_imput_presu=$reg["ref_imput_presu"]; $monto_credito=$reg["monto_credito"]; $func_inv=$reg["func_inv"];  $fecha_aep=$reg["fecha_aep"]; $ref_aep=$reg["ref_aep"]; $num_proyecto=$reg["num_proyecto"];  $operacion="N";  if($reg["ref_compromiso"]="SI"){$operacion="C";}
		$monto_c=cambia_coma_numero($monto_c); $pagado=cambia_coma_numero($pagado); 
		$resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$nro_orden','$tipo_caus','','0000','','0000','$operacion','','','','$ref_aep','$num_proyecto','$fecha_aep','$func_inv','$tipo_imput_presu','$ref_imput_presu','$fecha_ord',0,$monto_c,0,$pagado)"); $error=pg_errormessage($conn);   $error="ERROR GRABANDO: ".substr($error, 0, 61);  if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }
    }
  }
  if($error==0){ $monto_asiento=0;
    $resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$cod_contable_o','00000','',$monto_asiento,'D','B','N','02','0','$concepto')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }
    $resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','C','$codc_banco','00000','',$monto_asiento,'D','B','N','02','0','$concepto')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }
  }	   
 }
}
else {
$sql="SELECT * FROM bancos ORDER BY cod_banco"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $nro_cheque=$registro["num_cheque"]+1; $len=strlen($nro_cheque); $nro_cheque=substr("00000000",0,8-$len).$nro_cheque;}
$resultado=pg_exec($conn,"SELECT INCLUYE_BAN030 (1,'$codigo_mov','$cod_banco','$nro_cheque','$tipo_pago','$fecha','$fecha_desde','$fecha_hasta','N','N','$ced_rif','$nro_orden',0,0,'')"); }
$total_orden=formato_monto($total_orden); $total_abono=formato_monto($total_abono); $resta=formato_monto($resta);
if($fecha_ord==""){$fecha_ord="";}else{$fecha_ord=formato_ddmmaaaa($fecha_ord);}
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">EMISI&Oacute;N DE CHEQUES ORDEN NOMINA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="641" border="1" id="tablacuerpo">
  <tr>
    <td width="890" height="640">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:951px; height:599px; z-index:1; top: 70px; left: 15px;">
        <form name="form1" method="post" action="Insert_chq_nom.php" onSubmit="return revisar()">
          <table width="960" border="0" >
                <tr>
                  <td><table width="945">
                    <tr>
                      <td width="125"><span class="Estilo5">DOCUMENTO PAGO: </span></td>
                      <td width="30"><span class="Estilo5"><input class="Estilo10" name="txttipo_pago" type="text" id="txttipo_pago" readonly  value="<?echo $tipo_pago?>" size="4" maxlength="4" onkeypress="return stabular(event,this)"> </span></td>
                      <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev" type="text" id="txtnombre_abrev" size="5" maxlength="5"  value="<?echo $nombre_abrev?>" onkeypress="return stabular(event,this)" readonly>  </span> </td>
                      <td width="118"><span class="Estilo5">C&Oacute;DIGO BANCO:</span></td>
                      <td width="53"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco" size="5" maxlength="4"  value="<?echo $cod_banco?>" onFocus="encender(this)" onBlur="apaga_banco(this)" onchange="chequea_banco(this.form);" onkeypress="return stabular(event,this)">  </span> </td>
                      <td width="119"><input class="Estilo10" name="btcod_banco" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancos.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td>
                      <td width="135"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                      <td width="249"><span class="Estilo5"> <input class="Estilo10" name="txtnro_cuenta" type="text" id="txtnro_cuenta" value="<?echo $nro_cuenta?>"  size="30" maxlength="25" readonly onkeypress="return stabular(event,this)"> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="949" >
                    <tr>
                      <td width="115"><span class="Estilo5"> NOMBRE BANCO :</span></span></td>
                      <td width="561"><span class="Estilo5"><input class="Estilo10" name="txtnombre_banco" type="text" id="txtnombre_banco" value="<?echo $nombre_banco?>" size="80" maxlength="80" readonly onkeypress="return stabular(event,this)"> </span></td>
                      <td width="138"><span class="Estilo5"><div id="ncheque">N&Uacute;MERO DE CHEQUE: </div></span></td>
                      <td width="115"><span class="Estilo5"><div id="nrochq"><input class="Estilo10" name="txtnro_cheque" type="text" id="txtnro_cheque" size="10" maxlength="8"  value="<?echo $nro_cheque?>" onFocus="encender(this)" onBlur="apaga_numchq(this)" onchange="chequea_numchq(this.form);" onkeypress="return stabular(event,this)">  </div> </span></td>
                    </tr>
                  </table></td>
                </tr>
				<tr> <td><table width="952" >
                  <tr>
                    <td width="125"><span class="Estilo5">FECHA DE EMISI&Oacute;N :  </span></td>
                    <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtfecha" type="text" id="txtfecha"  value="<?echo $fecha?>" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)"> </span></td>
                    <td width="106"><p><span class="Estilo5">N&Uacute;MERO ORDEN:</span></p></td>
                    <td width="98"><div id="nrorden"><input class="Estilo10" name="txtnro_orden" type="text"  id="txtnro_orden" size="12" maxlength="8" onFocus="encender(this); " onBlur="apaga_orden(this);"  value="<?echo $nro_orden?>"  onchange="checkreferencia(this.form);" onkeypress="return stabular(event,this)"></div></td>
                    <td width="73"><span class="Estilo5"><input class="Estilo10" name="txttipo_causado" type="text"  id="txttipo_causado" size="4" maxlength="4"  value="<?echo $tipo_caus?>" onkeypress="return stabular(event,this)" readonly></span></td>
					<td width="110"><span class="Estilo5">FECHA ORDEN :  </span></td>
                    <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ord" type="text" id="txtfecha_ord" value="<?echo $fecha_ord?>" size="12" readonly onkeypress="return stabular(event,this)"> </span></td>                        
					<td width="200" align="center" ><span class="Estilo5"> <input type="button" name="btcarga_ord" value="Cargar Orden" title="Cargar Informacion de la Orden de pago" onClick="javascript:LlamarURL('Emision_Cheque_orden_nom.php?continua=S'); " > </span></td>                   	  
				 </tr>
                </table></td> </tr>
                <tr> <td><table width="860">
                  <tr>
                    <td width="100"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                    <td width="115"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text"  id="txtced_rif"  value="<?echo $ced_rif?>" size="12" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)"> </span> </td>
                    <td width="45"><input class="Estilo10" name="btced_rif" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_benef_chq.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td>
                    <td width="100"><span class="Estilo5">BENEFICIARIO : </span></td>
                    <td width="500"><span class="Estilo5"><input class="Estilo10" name="txtnombre_benef" type="text" id="txtnombre_benef"  value="<?echo $nombre_benef?>" size="80" maxlength="80" readonly onkeypress="return stabular(event,this)"> </span></td>
                  </tr>
                 </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                    <tr>
                      <td width="90"><span class="Estilo5">CONCEPTO :</span></td>
                      <td width="760"><span class="Estilo5">  <textarea name="txtconcepto" cols="93" onFocus="encender(this); " onBlur="apagar(this);" id="txtconcepto" onkeypress="return stabular(event,this)"><?echo $concepto?></textarea></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td><table width="952" >
                  <tr>
                    <td width="100"><span class="Estilo5">TOTAL ORDEN : </span></td>	
                    <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txttotal_orden" type="text" id="txttotal_orden"  readonly value="<?echo $total_orden?>" size="12" maxlength="12" style="text-align:right" onkeypress="return stabular(event,this)"></span></td>
					<td width="80"><span class="Estilo5">ABONADO :  </span></td>
					<td width="120"><span class="Estilo5"> <input class="Estilo10" name="txttotal_abono" type="text" id="txttotal_abono"  readonly value="<?echo $total_abono?>" size="12" maxlength="12" style="text-align:right" onkeypress="return stabular(event,this)"></span></td>
					<td width="62"><span class="Estilo5">RESTA :  </span></td>
					<td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtresta" type="text" id="txtresta"  readonly value="<?echo $resta?>" size="12" maxlength="12" style="text-align:right" onkeypress="return stabular(event,this)"></span></td>
					<td width="60" align="center" ><span class="Estilo5"> <input type="button" name="btcarga_abono" value="..." title="Coloca Abono del Periodo" onClick="javascript:Cargar_abono(this.form)" > </span></td>
                    <td width="175"  align="right" ><span class="Estilo5">MONTO DEL ABONO:</span></td>					
                    <td width="125"><span class="Estilo5"><input class="Estilo10" name="txtmonto_cheque" type="text" id="txtmonto_cheque" size="12" maxlength="12" style="text-align:right" onFocus="encender(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event,this)"> </span></td>
                  </tr>
                </table></td> </tr>
          </table>
		  
		  <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:312px; z-index:2; left: 2px; top: 240px;">
              <script language="javascript" type="text/javascript">
  
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 850;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "C&oacute;d. Presupuestario";
   rows[1][2] = "Retenciones";
   rows[1][3] = "Comprobantes";
   
            </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_inc_cod_chqp.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_inc_ret_ndbp.php?clave=<?echo $nro_orden_ret?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
			  <!--PESTA&Ntilde;A 3 -->
              <div id="T13" class="tab-body" >
                <iframe src="Det_inc_comp_chqp.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
		
        <div id="Layer3" style="position:absolute; width:868px; height:60px; z-index:2; left: 2px; top: 555px;">
        <table width="957">
         <tr> <td>&nbsp;</td> </tr>
          <tr><td><table width="923">
            <td width="129"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="100"><input name="txtcod_contable_o" type="hidden" id="txtcod_contable_o" value="<?echo $cod_contable_o?>"></td>
			<td width="100"><input name="txtnro_periodos" type="hidden" id="txnro_periodos"  readonly value="<?echo $nro_periodos?>" size="2" maxlength="2"> </td>                      
		    <td width="50"><input name="txtdispo_ord" type="hidden" id="txtdispo_ord" value="<?echo $dispo_ord?>"></td>
			<td width="50"><input name="txttotal_retencion" type="hidden" id="txttotal_retencion" value="<?echo $total_retencion?>"></td>
            <td width="20"><input name="txttotal_pasivos" type="hidden" id="txttotal_pasivos" value="<?echo $total_pasivos?>"></td>
            <td width="193"><input name="Grabar" type="submit" id="Grabar" title="Emitir el Cheque" value="Grabar Cheques"></td>
            <td width="138"><input name="Submit" type="reset" value="Blanquear"></td>
            <td width="143" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
          </table></td></tr>
        </table> </div>
		
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>