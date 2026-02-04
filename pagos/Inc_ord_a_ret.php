<?include ("../class/ventana.php"); include ("../class/fun_fechas.php");
 $codigo_mov=$_POST["txtcodigo_mov5"];  $fecha_hoy=asigna_fecha_hoy(); $tipo_imput_presu="P"; $gen_ord_ret=$_POST["txtgen_pre_ret5"];
 $user=$_POST["txtuser5"]; $password=$_POST["txtpassword5"]; $dbname=$_POST["txtdbname5"]; $port=$_POST["txtport5"]; $host=$_POST["txthost5"]; $nro_aut=$_POST["txtnro_aut5"]; $fecha_aut=$_POST["txtfecha_aut5"]; $tipo_caus=$_POST["txttipo_caus5"];
 $fec_fin_e=$_POST["txtfecha_fin5"]; $fecha_fin=formato_ddmmaaaa($fec_fin_e);   if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (INCLUIR ORDENES DE PAGO A RETENCIONES)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
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
var mhost='<?php echo $host ?>';
var mport='<?php echo $port ?>';
var mnro_aut='<?php echo $nro_aut ?>';
function Llamar_Inc_Orden(){document.form6.submit(); }
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_causado.value; mref = Rellenarizq(mref,"0",4);   mform.txttipo_causado.value=mref;
   if (mref == "0000" || mref=="A000" || mref.substring(0,1)=="A"){alert("Tipo de Causado No Aceptado"); return false;}
   ajaxSenddoc('GET', 'refcausaut.php?tipo_caus='+mref+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refcaus', 'innerHTML');
return true;}
function apaga_doc(mthis){var mref;
 apagar(mthis); mref=mthis.value; mref=Rellenarizq(mref,"0",4);
 ajaxSenddoc('GET', 'refcausaut.php?tipo_caus='+mref+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refcaus', 'innerHTML');
}
function checkreferencia(mform){var mref;
   mref=mform.txtnro_orden.value;  mref = Rellenarizq(mref,"0",8); mform.txtnro_orden.value=mref;
return true;}
function chequea_tipo_d(mform){var mref;
   mref=mform.txttipo_ret_d.value;  mref = Rellenarizq(mref,"0",3); mform.txttipo_ret_d.value=mref;
return true;}
function apaga_tipo_d(mthis){var mref;var mcedrif; var mtipo; var norden; var mret_d; var mret_h;
 apagar(mthis);  mret_d=mthis.value;
 mtipo=document.form1.txttipo_orden.value; norden=document.form1.txtnro_orden.value;
 mret_h=document.form1.txttipo_ret_h.value; mcedrif=document.form1.txtced_rif.value;
 ajaxSenddoc('GET', 'vtipoordret.php?tipo_ord='+mtipo+'&cedrif='+mcedrif+'&norden='+norden+'&ret_d='+mret_d+'&ret_h='+mret_h+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
}
function chequea_tipo_h(mform){var mref;
   mref=mform.txttipo_ret_h.value;  mref = Rellenarizq(mref,"0",3); mform.txttipo_ret_h.value=mref;
return true;}
function apaga_tipo_h(mthis){var mref;var mcedrif; var mtipo; var norden; var mret_d; var mret_h;
 apagar(mthis);  mret_h=mthis.value;
 mtipo=document.form1.txttipo_orden.value; norden=document.form1.txtnro_orden.value;
 mret_d=document.form1.txttipo_ret_d.value; mcedrif=document.form1.txtced_rif.value;
 ajaxSenddoc('GET', 'vtipoordret.php?tipo_ord='+mtipo+'&cedrif='+mcedrif+'&norden='+norden+'&ret_d='+mret_d+'&ret_h='+mret_h+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
}
function checkcedrif(mform){var mref; var mnomb; var mtipo; var norden;
   mref=mform.txtced_rif.value;    mnomb=mform.txtnombre.value;
   mform.txtced_rif_ces.value=mref;    mform.txtnombre_ces.value=mnomb;
   mtipo=mform.txttipo_orden.value;    norden=mform.txtnro_orden.value;
  return true;}
function apaga_cedrif(mthis){var mref;var mnomb; var mtipo; var norden; var mret_d; var mret_h;
 apagar(mthis);  mref=mthis.value;
 mnomb=document.form1.txtnombre.value;
 document.form1.txtced_rif_ces.value=mref; document.form1.txtnombre_ces.value=mnomb;
 mtipo=document.form1.txttipo_orden.value; norden=document.form1.txtnro_orden.value;
 mret_d=document.form1.txttipo_ret_d.value; mret_h=document.form1.txttipo_ret_h.value;
 ajaxSenddoc('GET', 'vtipoordret.php?tipo_ord='+mtipo+'&cedrif='+mref+'&norden='+norden+'&ret_d='+mret_d+'&ret_h='+mret_h+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
}
function apaga_tipoord(mthis){var mref;var mcedrif;var norden; var mret_d; var mret_h;
 apagar(mthis);  mref=mthis.value;  mref=Rellenarizq(mref,"0",4);
 mcedrif=document.form1.txtced_rif.value;  norden=document.form1.txtnro_orden.value;
 mret_d=document.form1.txttipo_ret_d.value; mret_h=document.form1.txttipo_ret_h.value;
 ajaxSenddoc('GET', 'vtipoordret.php?tipo_ord='+mref+'&cedrif='+mcedrif+'&norden='+norden+'&ret_d='+mret_d+'&ret_h='+mret_h+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
}
function checktipoord(mform){var mref; var mcedrif; var norden; var mret_d; var mret_h;
   mref=mform.txttipo_orden.value;    mref=Rellenarizq(mref,"0",4);   mform.txttipo_orden.value=mref;
   mcedrif=mform.txtced_rif.value;  norden=mform.txtnro_orden.value;
   mret_d=document.form1.txttipo_ret_d.value; mret_h=document.form1.txttipo_ret_h.value;
   ajaxSenddoc('GET', 'vtipoordret.php?tipo_ord='+mref+'&mcedrif='+mcedrif+'&norden='+norden+'&ret_d='+mret_d+'&ret_h='+mret_h+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
return true;}
function checkrefecha(mform){var mref;var mfec;
  mref=mform.txtfecha.value;  mfec=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha.value=mfec;}
  mform.txtfecha_vencim.value=mfec;
return true;}
function checktipodoc(mform){var mref;
   mref=mform.txttipo_documento.value;   
return true;}
function apaga_tipodoc(mthis){var mref;
 apagar(mthis);  mref=mthis.value;
 return true;}
function checkrefecha_venc(mform){var mref;var mfec;
  mref=mform.txtfecha_vencim.value;
  if(mform.txtfecha_vencim.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtfecha_vencim.value=mfec;}
return true;}
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");f.txtfecha.focus();return false;}
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
$nombre_tipo_caus=""; $tipo_ret_d="001"; $tipo_ret_h="999";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sSQL="SELECT tipo_causado, nombre_tipo_caus,nombre_abrev_caus from pre003 Where (tipo_causado='$tipo_caus')";
$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
if ($filas>0){ $reg=pg_fetch_array($resultado); $nombre_tipo_caus=$reg["nombre_abrev_caus"]; }
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR ORDEN DE PAGO A RETENCIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="658" border="0" id="tablacuerpo">
  <tr>
     <td><table width="92" height="642" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablam">
        <td width="86">
      <td><table width="92" height="642" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
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
  <tr> <td>&nbsp;</td> </tr>
    </table></td>
        </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:595px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Insert_orden_a_ret.php" onSubmit="return revisar()">
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
                              <input class="Estilo10" name="txtnro_orden" type="text"  id="txtnro_orden" size="12" maxlength="8" readonly>
                            <? }else{?>
                             <input class="Estilo10" name="txtnro_orden" type="text"  id="txtnro_orden" size="12" maxlength="8" onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);" onkeypress="return stabular(event,this)">
                            <? }?>
                             </div>
                           <script language="JavaScript" type="text/JavaScript">
                            ajaxSenddoc('GET', 'refordaut.php?nro_aut='+mnro_aut+'& password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrorden', 'innerHTML');
                          </script></td>
                          <td width="55"><span class="Estilo5"> </span></td>
                          <td width="145"><span class="Estilo5">DOCUMENTO CAUSADO:</span></td>
                          <td width="58"><span class="Estilo5"><input class="Estilo10" name="txttipo_causado" type="text"  id="txttipo_causado" size="6" maxlength="4"  value="<?echo $tipo_caus?>"  readonly onkeypress="return stabular(event,this)">   </span></td>
                          <td width="170"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" size="6"  value="<?echo $nombre_tipo_caus?>" readonly onkeypress="return stabular(event,this)">  </span></td>
                          <td width="60"><span class="Estilo5">FECHA :</span> </td>
                          <td width="108"><span class="Estilo5">
                          <? if($fecha_aut=='S'){?>
                            <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10"  value="<?echo $fecha_hoy?>" readonly onkeypress="return stabular(event,this)">
                            <? }else{?>
                            <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10" onFocus="encender(this);" onBlur="apagar(this);"  value="<?echo $fecha_hoy?>" onchange="checkrefecha(this.form)" onkeypress="return stabular(event,this)">     <? }?>
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="854">
                        <tr>
                          <td width="155"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="101"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="12" onFocus="encender(this); " onBlur="apaga_cedrif(this);" onchange="checkcedrif(this.form);" onkeypress="return stabular(event,this)"> </span></td>
                          <td width="44"><span class="Estilo5"> <input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_benef_orden.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">  </span></td>
                          <td width="529"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="84" readonly onkeypress="return stabular(event,this)"> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="859" >
                        <tr>
                          <td width="176" height="30"><span class="Estilo5">CESIONARIO A COBRAR :  <input class="Estilo10" name="txtpago_ces" type="checkbox" value="checkbox" onkeypress="return stabular(event,this)">   </span></td>
                          <td width="92"><span class="Estilo5">C&Eacute;DULA/RIF : </span></td>
                          <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtced_rif_ces" type="text" id="txtced_rif_ces" size="15" maxlength="12" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)"> </span> </td>
                          <td width="40"><span class="Estilo5"><input class="Estilo10" name="btced_rif_ces" type="button" id="btced_rif_ces" title="Abrir Catalogo de Beneficiarios Cesionarios" onClick="VentanaCentrada('Cat_benef_ces.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
                           <td width="65"><span class="Estilo5">NOMBRE :</span></td>
                          <td width="370"><span class="Estilo5">  <input class="Estilo10" name="txtnombre_ces" type="text" id="txtnombre_ces" size="59" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)"> </span> </td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="847" border="0">
                        <tr>
                          <td width="80"><span class="Estilo5">CONCEPTO:</span></td>
                          <td width="757"><textarea name="txtconcepto" cols="95" onFocus="encender(this); " onBlur="apagar(this);" class="Estilo10" id="txtconcepto" onkeypress="return stabular(event,this)"></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="857" >
                        <tr>
                          <td width="123" height="24"><span class="Estilo5">TIPO DOCUMENTO : </span></td>
                          <td width="174"><span class="Estilo5">
                          <div id="tipodoc"><select name="txttipo_documento" id="txttipo_documento" onFocus="encender(this)" onBlur="apagar(this);" onkeypress="return stabular(event,this)">
                          <option value="  ">   </option> </select></div>
                          <script language="JavaScript" type="text/JavaScript">var mtipod='FACTURA'; ajaxSenddoc('GET', 'cargatipodoc.php?password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&tipo_doc='+mtipod, 'tipodoc', 'innerHTML'); </script>    </span></td>
                          <td width="145"><span class="Estilo5">NUMERO DOCUMENTO :</span></td>
                          <td width="351"><span class="Estilo5"> <div id="nrdoc">  <input class="Estilo10" name="txtnro_documento" type="text" id="txtnro_documento"  onFocus="encender(this); " onBlur="apagar(this);"  size="55" onkeypress="return stabular(event,this)">  </div>  </span> </td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="850">
                        <tr>
                          <td width="123"><span class="Estilo5">TIPO DE ORDEN :</span>  </td>
                          <td width="73"><span class="Estilo5"><input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" size="8" maxlength="15"  onFocus="encender(this);" onBlur="apaga_tipoord(this);" onchange="checktipoord(this.form);"  onkeypress="return stabular(event,this)">   </span> </td>
                          <td width="53"><span class="Estilo5"><input class="Estilo10" name="bttipo_orden" type="button" id="bttipo_orden" title="Abrir Catalogo Tipo de Orden " onClick="VentanaCentrada('Cat_tipo_orden.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
                          <td width="581"><span class="Estilo5"><div id="destord"> <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" size="80" readonly onkeypress="return stabular(event,this)"> </div>  </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="855">
                        <tr>
                          <td width="144"><span class="Estilo5">FECHA VENCIMIENTO :</span></td>
                          <td width="199"><span class="Estilo5"><input class="Estilo10" name="txtfecha_vencim" type="text" id="txtfecha_vencim" size="15" onchange="checkrefecha_venc(this.form)" onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $fecha_hoy?>" onkeypress="return stabular(event,this)"> </span></td>
                          <td width="166"><span class="Estilo5">TIPO DE RETENCION DESDE :</span></td>
                          <td width="50"><span class="Estilo5"><input class="Estilo10" name="txttipo_ret_d" type="text" id="txttipo_ret_d" size="4" maxlength="3"  onFocus="encender(this)" onBlur="apaga_tipo_d(this)"  onchange="chequea_tipo_d(this.form);" value="<?echo $tipo_ret_d?>" onkeypress="return stabular(event,this)"> </span></td>
						  <td width="50"><span class="Estilo5"><input class="Estilo10" name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('Cat_tipo_retd.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">  </span></td>
                          <td width="50"><span class="Estilo5">HASTA :</span></td>
						  <td width="50"><span class="Estilo5"><input class="Estilo10" name="txttipo_ret_h" type="text" id="txttipo_ret_h" size="4" maxlength="3"  onFocus="encender(this)" onBlur="apaga_tipo_h(this)"  onchange="chequea_tipo_h(this.form);" value="<?echo $tipo_ret_h?>" onkeypress="return stabular(event,this)"> </span></td>
                          <td width="50"><span class="Estilo5"><input class="Estilo10" name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('Cat_tipo_reth.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">  </span></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
          </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:346px; z-index:2; left: 2px; top: 266px;">
              <script language="javascript" type="text/javascript">
   var gordr = '<?echo $gen_ord_ret?>';
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Retenciones/Cancelar";        // Requiere: <div id="T11" class="tab-body">  ... </div>
             </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_inc_opret_orden.php?&codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
                <div id="Layer3" style="position:absolute; width:868px; height:60px; z-index:2; left: 1px; top: 621px;">

        <table width="768">
          <tr>
            <td width="331"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="50"><input class="Estilo10" name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>               
            <td width="500"><input class="Estilo10" name="txtp_ces" type="hidden" id="txtp_ces" value="N"></td>
            <td width="231"><input class="Estilo10" name="txtcaus_directo" type="hidden" id="txtcaus_directo" value="SI"></td>
            <td width="88" valign="middle"><input class="Estilo10" name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input class="Estilo10" name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table> </div>
        </form>
      </div>
    </td>
</tr>
</table>
<form name="form6" method="post" action="Inc_ord_a_ret.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser5" type="hidden" id="txtuser5" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword5" type="hidden" id="txtpassword5" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname5" type="hidden" id="txtdbname5" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport5" type="hidden" id="txtport5" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost5" type="hidden" id="txthost5" value="<?echo $host?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnro_aut5" type="hidden" id="txtnro_aut5" value="N" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_aut5" type="hidden" id="txtfecha_aut5" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_ord_ret5" type="hidden" id="txtgen_ord_ret5" value="<?echo $gen_ord_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_comp_ret5" type="hidden" id="txtgen_comp_ret5" value="<?echo $gen_comp_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_pre_ret5" type="hidden" id="txtgen_pre_ret5" value="<?echo $gen_pre_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txttipo_caus5" type="hidden" id="txttipo_caus5" value="<?echo $tipo_caus?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov5" type="hidden" id="txtcodigo_mov5" value="<?echo $codigo_mov?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_fin5" type="hidden" id="txtfecha_fin5" value="<?echo $fec_fin_e?>" ></td>
  </tr>
</table>
</form>
</body>
</html>