<?include ("../class/ventana.php"); include ("../class/fun_fechas.php");
 $codigo_mov=$_POST["txtcodigo_mov4"];  $fecha_hoy=asigna_fecha_hoy();   $tipo_imput_presu="P"; $gen_pre_ret=$_POST["txtgen_pre_ret4"]; $gen_ord_ret=$_POST["txtgen_ord_ret4"];
 $user=$_POST["txtuser4"]; $password=$_POST["txtpassword4"]; $dbname=$_POST["txtdbname4"]; $port=$_POST["txtport4"]; $host=$_POST["txthost4"]; $nro_aut=$_POST["txtnro_aut4"]; $fecha_aut=$_POST["txtfecha_aut4"]; $tipo_caus=$_POST["txttipo_caus4"];
 $fec_fin_e=$_POST["txtfecha_fin4"]; $fecha_fin=formato_ddmmaaaa($fec_fin_e);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (INCLUIR ORDENES DE PAGO)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
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
var mhost='<?php echo $host ?>';
var mport='<?php echo $port ?>';
var mnro_aut='<?php echo $nro_aut ?>';
function Llamar_Inc_Orden(){document.form5.submit(); }
function daformatomonto (monto){
var i;var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if ((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) {str2 = str2 + monto.charAt(i);} } }
return str2;}
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_causado.value;   mref = Rellenarizq(mref,"0",4);   mform.txttipo_causado.value=mref;
   if (mref == "0000" || mref=="A000" || mref.substring(0,1)=="A"){alert("Tipo de Causado No Aceptado"); return false;}
   ajaxSenddoc('GET', 'refcausaut.php?tipo_caus='+mref+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refcaus', 'innerHTML');
return true;}
function apaga_doc(mthis){var mref;
 apagar(mthis); mref=mthis.value; mref=Rellenarizq(mref,"0",4);
 ajaxSenddoc('GET', 'refcausaut.php?tipo_caus='+mref+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refcaus', 'innerHTML');
}
function checkreferencia(mform){var mref;
   mref=mform.txtnro_orden.value;   mref = Rellenarizq(mref,"0",8);   mform.txtnro_orden.value=mref;
return true;}
function checkrefe_comp(mform){var mref; var mtipo;
   mref=mform.txtreferencia_comp.value;   mref = Rellenarizq(mref,"0",8);   mform.txtreferencia_comp.value=mref;   mtipo=document.form1.txttipo_compromiso.value;
  // ajaxSenddoc('GET', 'vmontocomp.php?tipo='+mtipo+'&referencia='+mref+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'totcomp', 'innerHTML');
return true;}

function apagarefe_comp(mthis){var mref; var mtipo; var norden;
   apagar(mthis);   mref=mthis.value;   mtipo=document.form1.txttipo_orden.value;   norden=document.form1.txtnro_orden.value;
   ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mtipo+'&cedrif='+mref+'&norden='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
   mtipo=document.form1.txttipo_compromiso.value;
   ajaxSenddoc('GET', 'vmontocomp.php?tipo='+mtipo+'&referencia='+mref+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'totcomp', 'innerHTML');
   mtipo=document.form1.txttasa_ant.value;   mtipo=quitaformatomonto(mtipo);   norden=document.form1.txtCodigo_Cuenta.value;
   ajaxSenddoc('GET', 'vmontoant.php?tasa='+mtipo+'&cod_cuenta='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'montord', 'innerHTML')
return true;}
function chequea_tipo_comp(mform){var mref;
   mref=mform.txttipo_compromiso.value;   mref=Rellenarizq(mref,"0",4);   mform.txttipo_compromiso.value=mref;
   if (mref=="0000" || mref.substring(0,1)=="A"){alert("Tipo de Compromiso No Aceptado"); return false;}
return true;}
function checkcedrif(mform){var mref; var mnomb; var mtipo; var norden;
   mref=mform.txtced_rif.value;   mnomb=mform.txtnombre.value;
   mtipo=document.form1.txttipo_orden.value;   norden=document.form1.txtnro_orden.value;
   ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mtipo+'&cedrif='+mref+'&norden='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
 return true;}
function apaga_cedrif(mthis){var mref;var mnomb; var mtipo; var norden;
 apagar(mthis); mref=mthis.value;
 mnomb=document.form1.txtnombre.value; mtipo=document.form1.txttipo_orden.value; norden=document.form1.txtnro_orden.value;
 ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mtipo+'&cedrif='+mref+'&norden='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
}
function checktipodoc(mform){var mref;
   mref=mform.txttipo_documento.value;
   ajaxSenddoc('GET', 'btfactura.php?tipo_doc='+mref+'&codigo_mov=<?echo $codigo_mov?>', 'btdoc', 'innerHTML');
   ajaxSenddoc('GET', 'nrodocun.php?tipo_doc='+mref, 'nrdoc', 'innerHTML');
return true;}
function apaga_tipodoc(mthis){var mref;
 apagar(mthis); mref=mthis.value;
 ajaxSenddoc('GET', 'btfactura.php?tipo_doc='+mref+'&refcomp=N&codigo_mov=<?echo $codigo_mov?>', 'btdoc', 'innerHTML');
 ajaxSenddoc('GET', 'nrodocun.php?tipo_doc='+mref, 'nrdoc', 'innerHTML');
}
function apaga_tipoord(mthis){var mref;var mcedrif;var norden;
 apagar(mthis); mref=mthis.value; mref=Rellenarizq(mref,"0",4);
 mcedrif=document.form1.txtced_rif.value; norden=document.form1.txtnro_orden.value;
 ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mref+'&cedrif='+mcedrif+'&norden='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
}
function checktipoord(mform){var mref; var mcedrif; var norden;
   mref=mform.txttipo_orden.value;   mref=Rellenarizq(mref,"0",4);
   mform.txttipo_orden.value=mref;   mcedrif=mform.txtced_rif.value;   norden=mform.txtnro_orden.value;
   ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mref+'&mcedrif='+mcedrif+'&norden='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
return true;}
function checkrefecha(mform){var mref; var mfec;
  mref=mform.txtfecha.value;   mfec=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){  mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtfecha.value=mfec;}
  mform.txtfecha_vencim.value=mfec;
return true;}
function checkrefecha_venc(mform){var mref;var mfec;
  mref=mform.txtfecha_vencim.value;
  if(mform.txtfecha_vencim.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtfecha_vencim.value=mfec;}
return true;}
function Llamar_factura(){var ced_rif;
  ced_rif=document.form1.txtced_rif.value;
  Ventana_002('Det_inc_fact_ord.php?codigo_mov=<?echo $codigo_mov?>&ref_comp=N&ced_rif='+ced_rif,'SIA','','980','400','true')
return true;}
function apaga_tasa(mthis){var mmonto;var mtasa; var ncod_ant; var ptasa;
   apagar(mthis);   mmonto=quitaformatomonto(document.form1.txttotal_comp.value);
   mtasa=mthis.value;  mtasa=quitaformatomonto(mtasa);   mmonto=(mmonto*1); ptasa=mtasa;
   mtasa=(mmonto*(mtasa/100));   mtasa=Math.round(mtasa*100)/100;
   document.form1.txtmonto.value=mtasa;   document.form1.txtmonto.value=daformatomonto(document.form1.txtmonto.value);
   ncod_ant=document.form1.txtCodigo_Cuenta.value;
  ajaxSenddoc('GET', 'vcodant.php?tasa='+ptasa+'&cod_cuenta='+ncod_ant+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'desmonto', 'innerHTML')
return true;}

function apaga_monto(mthis){var mmonto; var mtasa; var ncod_ant;
 apagar(mthis); mmonto=mthis.value; mmonto=quitaformatomonto(mmonto);
 ajaxSenddoc('GET', 'vmontoord.php?mmonto='+mmonto+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'desmonto', 'innerHTML');
 mtasa=document.form1.txttasa_ant.value;   mtasa=quitaformatomonto(mtasa);   ncod_ant=document.form1.txtCodigo_Cuenta.value;
 ajaxSenddoc('GET', 'vcodant.php?tasa='+mtasa+'&cod_cuenta='+ncod_ant+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'desmonto', 'innerHTML')
}
function checkmonto(mform){var mmonto;
  mmonto=document.form1.txtmonto.value;  mmonto=quitaformatomonto(mmonto);
  //ajaxSenddoc('GET', 'vmontoord.php?mmonto='+mmonto+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'desmonto', 'innerHTML');
return true;}
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia"); f.txtfecha.focus();return false;}
    if(f.txtnro_orden.value==""){alert("Numero de Orden no puede estar Vacia"); f.txtnro_orden.focus(); return false;}      else{f.txtnro_orden.value=f.txtnro_orden.value;}
    if(f.txttipo_causado.value==""){alert("Tipo de Causado no puede estar Vacio"); f.txttipo_causado.focus(); return false; }      else{f.txttipo_causado.value=f.txttipo_causado.value.toUpperCase();}
    if(f.txtconcepto.value==""){alert("Concepto de la Orden no puede estar Vacia"); f.txtconcepto.focus(); return false; }      else{f.txtconcepto.value=f.txtconcepto.value.toUpperCase();}
    if(f.txtnro_orden.value.length==8){f.txtnro_orden.value=f.txtnro_orden.value.toUpperCase();f.txtnro_orden.value=f.txtnro_orden.value;}      else{alert("Longitud de Numero de Orden  Invalida"); f.txtnro_orden.focus(); return false;}
    if(f.txtfecha.value.length==10){Valido=true;} else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_causado.value=="0000" || f.txttipo_causado.value=="A000" ) {alert("Tipo de Causado No Aceptado"); f.txttipo_causado.focus(); return false; }
    if(f.txtfecha_vencim.value.length==10){Valido=true;}  else{alert("Longitud de Fecha vencimiento Invalida");  f.txtfecha_vencim.focus(); return false;}
    if(f.txtced_rif.value==""){alert("Cedula/Rif del Beneficiario no puede estar Vacia"); f.txtced_rif.focus(); return false; }  else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    if(f.txtpago_ces.checked==true){ f.txtp_ces.value="S"; } else{ f.txtp_ces.value="N"; }
document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
</script>
</head>
<?
$nombre_tipo_caus="";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sSQL="SELECT tipo_causado, nombre_tipo_caus,nombre_abrev_caus from pre003 Where (tipo_causado='$tipo_caus')";
$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);if ($filas>0){ $reg=pg_fetch_array($resultado); $nombre_tipo_caus=$reg["nombre_abrev_caus"]; }
$cod_doc="ANTICIPO";
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR ORDEN DE PAGO ANTICIPO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="688" border="0" id="tablacuerpo">
  <tr>
     <td><table width="92" height="672" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablam">
        <td width="86">
      <td><table width="92" height="672" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_orden_pago.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_orden_pago.php">Atras</A></td>
      </tr>
	  <?if ($nro_aut=="S"){?>
          <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Orden();">Quitar Numero Automatico</A></td>
          </tr>
      <?} ?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
        </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:595px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Insert_orden_ant.php" onSubmit="return revisar()">
      <table width="867" >
              <tr>
                <td>
                  <table width="846" align="center">
                    <tr>
                      <td><table width="847" border="0">
                        <tr>
                          <td width="106">
                          <p><span class="Estilo5">N&Uacute;MERO ORDEN:</span></p></td>
                          <td width="97"><div id="nrorden">
                            <? if($nro_aut=='S'){?>
                              <input class="Estilo10" name="txtnro_orden" type="text"  id="txtnro_orden" size="12" maxlength="8" readonly onkeypress="return stabular(event,this)">
                            <? }else{?>
                             <input class="Estilo10" name="txtnro_orden" type="text"  id="txtnro_orden" size="12" maxlength="8" onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);" onkeypress="return stabular(event,this)">
                            <? }?>
                             </div>
                           <script language="JavaScript" type="text/JavaScript">
                            ajaxSenddoc('GET', 'refordaut.php?nro_aut='+mnro_aut+'& password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrorden', 'innerHTML');
                          </script></td>
                          <td width="55"><span class="Estilo5">
                          </span></td>
                          <td width="145"><span class="Estilo5">DOCUMENTO CAUSADO:</span></td>
                          <td width="58"><span class="Estilo5">
                            <input class="Estilo10" name="txttipo_causado" type="text"  id="txttipo_causado" size="6" maxlength="4"  value="<?echo $tipo_caus?>"  readonly onkeypress="return stabular(event,this)">
                          </span></td>
                          <td width="170"><span class="Estilo5">
                             <input class="Estilo10" name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" size="6"  value="<?echo $nombre_tipo_caus?>" readonly onkeypress="return stabular(event,this)">
                          </span></td>
                          <td width="60"><span class="Estilo5">FECHA :</span> </td>
                          <td width="108"><span class="Estilo5">
                          <? if($fecha_aut=='S'){?>
                            <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10"  value="<?echo $fecha_hoy?>" readonly onkeypress="return stabular(event,this)">
                            <? }else{?>
                            <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10" onFocus="encender(this);" onBlur="apagar(this);"  value="<?echo $fecha_hoy?>" onchange="checkrefecha(this.form)" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)">
                            <? }?>
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="854" border="0">
                        <tr>
                          <td width="181">
                            <p><span class="Estilo5">DOCUMENTO COMPROMISO:</span></p></td>
                          <td width="41"><input class="Estilo10" name="txttipo_compromiso" type="text"  id="txttipo_compromiso" size="5" maxlength="4" onFocus="encender(this);" onBlur="apagar(this);"   onchange="chequea_tipo_comp(this.form);" onkeypress="return stabular(event,this)"></td>
                          <td width="41"><span class="Estilo5"><input class="Estilo10" name="btdoc_comp" type="button" id="btdoc_comp" title="Abrir Catalogo Documentos Compromiso" onClick="VentanaCentrada('../presupuesto/Cat_doc_comp.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">
                          </span></td>
                          <td width="49"><span class="Estilo5"> <input class="Estilo10" name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" size="4" readonly onkeypress="return stabular(event,this)">
                          </span></td>
                          <td width="177"><span class="Estilo5">REFERENCIA COMPROMISO:</span> </td>
                          <td width="70"><div id="refer"><input class="Estilo10" name="txtreferencia_comp" type="text" id="txtreferencia_comp" size="9" onFocus="encender(this);" onBlur="apagarefe_comp(this);"  onchange="checkrefe_comp(this.form);" onkeypress="return stabular(event,this)">  </div></td>
                          <td width="60"><span class="Estilo5"><input class="Estilo10" name="btref_comp" type="button" id="btref_comp" title="Abrir Catalogo de Compromisos" onClick="VentanaCentrada('Cat_comp_ant.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">  </span></td>
                          <td width="50"><span class="Estilo5">TOTAL : </span></td>
                          <td width="137"><span class="Estilo5"><div id="totcomp"> <input class="Estilo10" name="txttotal_comp" type="text" id="txttotal_comp" size="20" align="right" maxlength="20" readonly onkeypress="return stabular(event,this)"> </div> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="854">
                        <tr>
                          <td width="155"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="101"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="12" onFocus="encender(this); " onBlur="apaga_cedrif(this);" onchange="checkcedrif(this.form);" onkeypress="return stabular(event,this)"> </span></td>
                          <td width="44"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_benef_orden.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"> </span></td>
                          <td width="529"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="84" readonly onkeypress="return stabular(event,this)"> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="847" border="0">
                        <tr>
                          <td width="80"><span class="Estilo5">CONCEPTO:</span></td>
                          <td width="757"><textarea name="txtconcepto" cols="95" onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="txtconcepto" onkeypress="return stabular(event,this)"></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="855" >
                        <tr>
                          <td width="123" height="24"><span class="Estilo5">TIPO DOCUMENTO : </span></td>
                          <td width="174"><span class="Estilo5">
                          <div id="tipodoc"><select name="txttipo_documento" id="txttipo_documento" onFocus="encender(this)" onBlur="apaga_tipodoc(this);" onchange="checktipodoc(this.form);" onkeypress="return stabular(event,this)">   <option value="  ">   </option>     </select></div>
                          <script language="JavaScript" type="text/JavaScript"> ajaxSenddoc('GET', 'cargatipodoc.php?password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&tipo_doc=<?echo $cod_doc?>', 'tipodoc', 'innerHTML'); </script>
                          </span></td>
                           <td width="40"><span class="Estilo5"> <div id="btdoc"><input class="Estilo10" name="btfacturas" type="button" id="btfacturas" title="Registrar Facturas de la Orden " onClick="Llamar_factura()" value="..." onkeypress="return stabular(event,this)">  </div>    </span></td>
                          <td width="145"><span class="Estilo5">NUMERO DOCUMENTO :</span></td>
                          <td width="351"><span class="Estilo5"><div id="nrdoc"><input class="Estilo10" name="txtnro_documento" type="text" id="txtnro_documento"  onFocus="encender(this); " onBlur="apagar(this);"  size="55" onkeypress="return stabular(event,this)">     </div> </span> </td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="850">
                        <tr>
                          <td width="123"><span class="Estilo5">TIPO DE ORDEN :</span>  </td>
                          <td width="73"><span class="Estilo5"> <input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" size="8" maxlength="15"  onFocus="encender(this);" onBlur="apaga_tipoord(this);" onchange="checktipoord(this.form);" onkeypress="return stabular(event,this)">  </span> </td>
                          <td width="53"><span class="Estilo5"><input class="Estilo10" name="bttipo_orden" type="button" id="bttipo_orden" title="Abrir Catalogo Tipo de Orden " onClick="VentanaCentrada('Cat_tipo_orden.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">  </span></td>
                          <td width="581"><span class="Estilo5"><div id="destord"> <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" size="80" readonly onkeypress="return stabular(event,this)"> </div>   </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="848">
                        <tr>
                          <td width="139"><span class="Estilo5">FECHA VENCIMIENTO :</span></td>
                          <td width="182"><span class="Estilo5"><input class="Estilo10" name="txtfecha_vencim" type="text" id="txtfecha_vencim" size="12" onchange="checkrefecha_venc(this.form)" onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $fecha_hoy?>" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)"> </span></td>
                          <td width="161"><span class="Estilo5">CUENTA DE ANTICIPO : </span></td>
                          <td width="188"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" size="30" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)">    </span></td>
                          <td width="73"><span class="Estilo5"><input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onclick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span> </td>
                          <td width="77"><input class="Estilo10" name="txtNombre_Cuenta" type="hidden" id="txtNombre_Cuenta" onkeypress="return stabular(event,this)"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="842">
                        <tr>
                          <td width="206"><span class="Estilo5">PORCENTAJE DE ANTICIPO(%):</span></td>
                          <td width="113"><span class="Estilo5"> <input class="Estilo10" name="txttasa_ant" type="text" id="txttasa_ant" size="5" align="right" maxlength="5" onFocus="encender(this)" onBlur="apaga_tasa(this);" onKeypress="return validarNum(event,this)">     </span></td>
                          <td width="161"><span class="Estilo5"> <div id="desmonto">MONTO DE LA ORDEN : </div> </span></td>
                          <td width="342"><span class="Estilo5"> <div id="montord"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="20" align="right" maxlength="20" onFocus="encender(this)" onBlur="apaga_monto(this);" onchange="checkmonto(this.form);" onKeypress="return validarNum(event,this)"> </div>  </span></td>
                        </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td><table width="855">
                        <tr>
                          <td width="114"><span class="Estilo5">TIPO DE GASTO :</span></td>
                          <td width="140"><span class="Estilo5"><select name="txtfunc_inv" size="1" id="txtfunc_inv" onFocus="encender(this)" onBlur="apagar(this)">
                              <option selected>CORRIENTE</option><option>INVERSION</option><option>CORRIENTE/INVERSION</option>   </select></span> </td>
                          <td width="147">&nbsp;</td>
                          <td width="135"></td>
                          <td width="154"></td>
                          <td width="89"></td>
                          <td width="44"></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
          </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:335px; z-index:2; left: 2px; top: 326px;">
              <script language="javascript" type="text/javascript">
   var gordr = '<?echo $gen_ord_ret?>';
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Comprobantes";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   if (gordr=="N") {rows[1][2] = "Retenciones";}      // Requiere: <div id="T12" class="tab-body">  ... </div>
            </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_inc_comp_ord_ant.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
               <? if($gen_ord_ret=="N"){?>
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_inc_ret_ord_fin.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
               <? }?>
            </div></td>
         </tr>
        </table>
                <div id="Layer3" style="position:absolute; width:868px; height:60px; z-index:2; left: 1px; top: 658px;">

        <table width="768">
          <tr>
            <td width="331"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="50"><input class="Estilo10" name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>  
            
            <td width="281"><input class="Estilo10" name="txtcaus_directo" type="hidden" id="txtcaus_directo" value="SI"></td>
            <td width="88" valign="middle"><input class="Estilo10" name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input class="Estilo10" name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table> </div>
        </form>
      </div>
    </td>
</tr>
<form name="form5" method="post" action="Inc_ord_ant.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser4" type="hidden" id="txtuser4" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword4" type="hidden" id="txtpassword4" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname4" type="hidden" id="txtdbname4" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport4" type="hidden" id="txtport4" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost4" type="hidden" id="txthost4" value="<?echo $host?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnro_aut4" type="hidden" id="txtnro_aut4" value="N" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_aut4" type="hidden" id="txtfecha_aut4" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_ord_ret4" type="hidden" id="txtgen_ord_ret4" value="<?echo $gen_ord_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_comp_ret4" type="hidden" id="txtgen_comp_ret4" value="<?echo $gen_comp_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_pre_ret4" type="hidden" id="txtgen_pre_ret4" value="<?echo $gen_pre_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txttipo_caus4" type="hidden" id="txttipo_caus4" value="<?echo $tipo_caus?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov4" type="hidden" id="txtcodigo_mov4" value="<?echo $codigo_mov?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_fin4" type="hidden" id="txtfecha_fin4" value="<?echo $fec_fin_e?>" ></td>
	 
  </tr>
</table>
</form>
</table>
</body>
</html>