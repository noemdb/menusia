<?include ("../class/ventana.php");include ("../class/fun_fechas.php");
 $codigo_mov=$_POST["txtcodigo_mov3"];  $fecha_hoy=asigna_fecha_hoy(); $tipo_imput_presu="P"; $gen_ord_ret=$_POST["txtgen_ord_ret3"]; $gen_pre_ret=$_POST["txtgen_pre_ret3"]; $comp_automatico=$_POST["txtcomp_automatico3"];
 $user=$_POST["txtuser3"]; $password=$_POST["txtpassword3"]; $dbname=$_POST["txtdbname3"]; $port=$_POST["txtport3"]; $host=$_POST["txthost3"]; $nro_aut=$_POST["txtnro_aut3"]; $fecha_aut=$_POST["txtfecha_aut3"]; $tipo_caus=$_POST["txttipo_caus3"];
 $ced_r=$_POST["txtced_r3"]; $nomb_r=$_POST["txtnomb_r3"]; $con_est=$_POST["txtcon_est3"]; $tipo_doc=$_POST["txttipo_doc3"]; $tipo_ord=$_POST["txttipo_ord3"]; $fecha_d=$_POST["txtfecha_d3"]; $fecha_h=$_POST["txtfecha_h3"];
 $des_tipo_orden=$_POST["txtdes_t_orden3"];
 $fec_fin_e=$_POST["txtfecha_fin3"];  $fecha_fin=formato_ddmmaaaa($fec_fin_e);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}
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
function quitaformatomonto (monto){
var i; var str2 ="";
  for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == ',')){str2 = str2 + ".";} else{if ((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) {str2 = str2 + monto.charAt(i);} } }
  return str2;}
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function Llamar_Inc_Orden(){document.form4.submit(); }
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_causado.value;    mref = Rellenarizq(mref,"0",4);    mform.txttipo_causado.value=mref;
   if (mref == "0000" || mref=="A000" || mref.substring(0,1)=="A"){alert("Tipo de Causado No Aceptado"); return false;}
   ajaxSenddoc('GET', 'refcausaut.php?tipo_caus='+mref+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refcaus', 'innerHTML');
return true;}
function apaga_doc(mthis){var mref;
 apagar(mthis);  mref=mthis.value; mref=Rellenarizq(mref,"0",4);
 ajaxSenddoc('GET', 'refcausaut.php?tipo_caus='+mref+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refcaus', 'innerHTML');
}
function checkreferencia(mform){var mref;
   mref=mform.txtnro_orden.value;   mref = Rellenarizq(mref,"0",8);    mform.txtnro_orden.value=mref;
return true;}
function checkcedrif(mform){var mref; var mnomb; var mtipo; var norden;
   mref=mform.txtced_rif.value;   mnomb=mform.txtnombre.value;   mform.txtced_rif_ces.value=mref;
   mform.txtnombre_ces.value=mnomb;    mtipo=document.form1.txttipo_orden.value;     norden=document.form1.txtnro_orden.value;
   ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mtipo+'&cedrif='+mref+'&norden='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
 return true;}
function apaga_cedrif(mthis){var mref;var mnomb; var mtipo; var norden;
 apagar(mthis); mref=mthis.value;  mnomb=document.form1.txtnombre.value;  document.form1.txtced_rif_ces.value=mref;
 document.form1.txtnombre_ces.value=mnomb; mtipo=document.form1.txttipo_orden.value;  norden=document.form1.txtnro_orden.value;
 ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mtipo+'&cedrif='+mref+'&norden='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
}
function checktipodoc(mform){var mref;
   mref=mform.txttipo_documento.value;
   ajaxSenddoc('GET', 'btfactura.php?tipo_doc='+mref+'&codigo_mov=<?echo $codigo_mov?>', 'btdoc', 'innerHTML');
   ajaxSenddoc('GET', 'nrodocun.php?tipo_doc='+mref, 'nrdoc', 'innerHTML');
return true;}
function apaga_tipodoc(mthis){var mref;
 apagar(mthis);  mref=mthis.value;
 ajaxSenddoc('GET', 'btfactura.php?tipo_doc='+mref+'&refcomp=N&codigo_mov=<?echo $codigo_mov?>', 'btdoc', 'innerHTML');
 ajaxSenddoc('GET', 'nrodocun.php?tipo_doc='+mref, 'nrdoc', 'innerHTML');
}
function apaga_tipoord(mthis){ var mref; var mcedrif;var norden;
 apagar(mthis);  mref=mthis.value;  mref=Rellenarizq(mref,"0",4);
 mcedrif=document.form1.txtced_rif.value; norden=document.form1.txtnro_orden.value;
 ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mref+'&cedrif='+mcedrif+'&norden='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
}
function checktipoord(mform){
var mref; var mcedrif; var norden;
   mref=mform.txttipo_orden.value;    mref=Rellenarizq(mref,"0",4);
   mform.txttipo_orden.value=mref;    mcedrif=mform.txtced_rif.value;    norden=mform.txtnro_orden.value;
   ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mref+'&mcedrif='+mcedrif+'&norden='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
return true;}
function checkrefecha(mform){var mref;var mfec;
  mref=mform.txtfecha.value;  mfec=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha.value=mfec;}
  mform.txtfecha_vencim.value=mfec;
return true;}
function checkrefecha_venc(mform){var mref; var mfec;
  mref=mform.txtfecha_vencim.value;
  if(mform.txtfecha_vencim.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtfecha_vencim.value=mfec;}
return true;}
function Llamar_factura(){var ced_rif;
  ced_rif=document.form1.txtced_rif.value;
  Ventana_002('Det_inc_fact_ord.php?codigo_mov=<?echo $codigo_mov?>&ref_comp=N&ced_rif='+ced_rif,'SIA','','980','400','true')
return true;}
function apaga_monto(mthis){var mmonto; var rmonto;  rmonto=document.form1.txtmonto.value;   
 apagar(mthis); mmonto=document.form1.txtmonto.value;   mmonto=camb_punto_coma(mmonto); document.form1.txtmonto.value=mmonto;
  rmonto=quitaformatomonto(rmonto);
 ajaxSenddoc('GET', 'vmontoord.php?mmonto='+rmonto+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'desmonto', 'innerHTML');
}
function checkmonto(mform){var mmonto; var rmonto; rmonto=document.form1.txtmonto.value;   
  mmonto=document.form1.txtmonto.value;   mmonto=camb_punto_coma(mmonto); document.form1.txtmonto.value=mmonto;
  rmonto=quitaformatomonto(rmonto);
  ajaxSenddoc('GET', 'vmontoord.php?mmonto='+rmonto+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'desmonto', 'innerHTML');
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
$nombre_tipo_caus="";$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sSQL="SELECT tipo_causado, nombre_tipo_caus,nombre_abrev_caus from pre003 Where (tipo_causado='$tipo_caus')";
$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);  if ($filas>0){ $reg=pg_fetch_array($resultado); $nombre_tipo_caus=$reg["nombre_abrev_caus"]; }
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR ORDEN DE PAGO FINANCIERA </div></td>
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
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
        </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:595px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Insert_orden_finan.php" onSubmit="return revisar()">
      <table width="867" >
              <tr>
                <td>
                  <table width="846" align="center">
                    <tr>
                      <td><table width="847" border="0">
                        <tr>
                          <td width="106"><p><span class="Estilo5">N&Uacute;MERO ORDEN:</span></p></td>
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
                          <td width="55"><span class="Estilo5"></span></td>
                          <td width="145"><span class="Estilo5">DOCUMENTO CAUSADO:</span></td>
                          <td width="58"><span class="Estilo5"><input class="Estilo10" name="txttipo_causado" type="text"  id="txttipo_causado" size="6" maxlength="4"  value="<?echo $tipo_caus?>"  readonly onkeypress="return stabular(event,this)">   </span></td>
                          <td width="170"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" size="6"  value="<?echo $nombre_tipo_caus?>" readonly onkeypress="return stabular(event,this)">   </span></td>
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
                      <td><table width="854">
                        <tr>
                          <td width="155"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="101"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="12" onFocus="encender(this); " onBlur="apaga_cedrif(this);" onchange="checkcedrif(this.form);" onkeypress="return stabular(event,this)" value="<?echo $ced_r?>" >    </span></td>
                          <td width="44"><span class="Estilo5"> <input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_benef_orden.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"> </span></td>
                          <td width="529"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="84" readonly onkeypress="return stabular(event,this)" value="<?echo $nomb_r?>">
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="860" >
                        <tr>
                          <td width="175" height="30"><span class="Estilo5">CESIONARIO A COBRAR :<input class="Estilo10" name="txtpago_ces" type="checkbox" value="checkbox" onkeypress="return stabular(event,this)">    </span></td>
                          <td width="90"><span class="Estilo5">C&Eacute;DULA/RIF : </span></td>
                          <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif_ces" type="text" id="txtced_rif_ces" size="15" maxlength="12" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)"> </span> </td>
                          <td width="40"><span class="Estilo5"><input class="Estilo10" name="btced_rif_ces" type="button" id="btced_rif_ces" title="Abrir Catalogo de Beneficiarios Cesionarios" onClick="VentanaCentrada('Cat_benef_ces.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
                           <td width="65"><span class="Estilo5">NOMBRE :</span></td>
                          <td width="370"><span class="Estilo5"><input class="Estilo10" name="txtnombre_ces" type="text" id="txtnombre_ces" size="55" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)" >  </span> </td>
                        </tr>
                      </table></td>
                    </tr>       
                    <tr>
                      <td><table width="847" border="0">
                        <tr>
                          <td width="80"><span class="Estilo5">CONCEPTO:</span></td>
                          <td width="757"><textarea name="txtconcepto" cols="95" onFocus="encender(this); " onBlur="apagar(this);" class="Estilo10" id="txtconcepto" onkeypress="return stabular(event,this)"><?echo $con_est?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="857" >
                        <tr>
                          <td width="123" height="24"><span class="Estilo5">TIPO DOCUMENTO : </span></td>
                          <td width="174"><span class="Estilo5"> <div id="tipodoc"><select name="txttipo_documento" id="txttipo_documento" onFocus="encender(this)" onBlur="apaga_tipodoc(this);" onchange="checktipodoc(this.form);" onkeypress="return stabular(event,this)">
                             <option value="  ">   </option></select></div>
                          <script language="JavaScript" type="text/JavaScript">ajaxSenddoc('GET', 'cargatipodoc.php?password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&tipo_doc=', 'tipodoc', 'innerHTML'); </script>
                          </span></td>
                          <td width="40"><span class="Estilo5"><div id="btdoc"><input class="Estilo10" name="btfacturas" type="button" id="btfacturas" title="Registrar Facturas de la Orden " onClick="Llamar_factura()" value="..." onkeypress="return stabular(event,this)">   </div></span></td>
                          <td width="145"><span class="Estilo5">NUMERO DOCUMENTO :</span></td>
                          <td width="351"><span class="Estilo5"><div id="nrdoc"> <input class="Estilo10" name="txtnro_documento" type="text" id="txtnro_documento"  onFocus="encender(this); " onBlur="apagar(this);"  size="55" onkeypress="return stabular(event,this)">   </div> </span> </td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="850">
                        <tr>
                          <td width="123"><span class="Estilo5">TIPO DE ORDEN :</span>  </td>
                          <td width="73"><span class="Estilo5"><input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" size="8" maxlength="15"  onFocus="encender(this);" onBlur="apaga_tipoord(this);"  value="<?echo $tipo_ord?>" onchange="checktipoord(this.form);" onkeypress="return stabular(event,this)">    </span> </td>
                          <td width="53"><span class="Estilo5"><input class="Estilo10" name="bttipo_orden" type="button" id="bttipo_orden" title="Abrir Catalogo Tipo de Orden " onClick="VentanaCentrada('Cat_tipo_orden.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">  </span></td>
                          <td width="581"><span class="Estilo5"><div id="destord"> <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" size="80" value="<? echo $des_tipo_orden ?>" readonly onkeypress="return stabular(event,this)"> </div>  </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="855">
                        <tr>
                          <td width="144"><span class="Estilo5">FECHA VENCIMIENTO :</span></td>
                          <td width="139"><span class="Estilo5"><input class="Estilo10" name="txtfecha_vencim" type="text" id="txtfecha_vencim" size="15" onchange="checkrefecha_venc(this.form)" onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $fecha_hoy?>" onkeypress="return stabular(event,this)">    </span></td>
                          <td width="147"><span class="Estilo5"><div id="desmonto">MONTO DE LA ORDEN  :</div></span></td>
                          <td width="185"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="20" style="text-align:right" maxlength="20" onFocus="encender(this)" onBlur="apaga_monto(this);" onchange="checkmonto(this.form);" onKeypress="return validarNum(event,this)">   </span> </td>
						  <td width="116"><span class="Estilo5">TIPO DE GASTO :</span></td>
                          <td width="100"><span class="Estilo5"><select name="txtfunc_inv" size="1" id="txtfunc_inv" onFocus="encender(this)" onBlur="apagar(this)">
                              <option selected>CORRIENTE</option><option>INVERSION</option><option>CORRIENTE/INVERSION</option>  </select> </span> </td>
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
   rows[1][1] = "Comprobantes";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   if (gordr=="N") {rows[1][2] = "Retenciones";}            // Requiere: <div id="T12" class="tab-body">  ... </div>
            </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_inc_comp_ord_fin.php?&codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
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
       <div id="Layer3" style="position:absolute; width:868px; height:60px; z-index:2; left: 1px; top: 621px;">

        <table width="768">
          <tr>
            <td width="31"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="240"><span class="Estilo5">GENERAR COMPROBANTES DE RETENCION AUTOMATICO</span></td>
            <td width="60"><span class="Estilo5"><select name="txtcomp_aut" size="1" id="txtcomp_aut" onFocus="encender(this)" onBlur="apagar(this)">
                <option selected>SI</option> <option>NO</option> </select></span></td>
<script language="JavaScript" type="text/JavaScript">var mnro_aut='<?php echo $nro_aut ?>'; var mcomp_aut='<?php echo $comp_automatico ?>';  
if(mnro_aut=="S"){if(mcomp_aut=="S"){document.form1.txtcomp_aut.options[0].selected = true;}else{document.form1.txtcomp_aut.options[1].selected = true;}}
else{if(mcomp_aut=="S"){document.form1.txtcomp_aut.options[0].selected = true;}else{document.form1.txtcomp_aut.options[1].selected = true;}} </script>
			<td width="50"><input class="Estilo10" name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>  
            <td width="50"><input class="Estilo10" name="txtp_ces" type="hidden" id="txtp_ces" value="N"></td>
            <td width="231"><input class="Estilo10" name="txtcaus_directo" type="hidden" id="txtcaus_directo" value="SI"></td>
            <td width="88" valign="middle"><input class="Estilo10" name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input class="Estilo10" name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table> </div>
        </form>
      </div>
    </td>
</tr>
<form name="form4" method="post" action="Inc_ord_finan.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser3" type="hidden" id="txtuser3" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword3" type="hidden" id="txtpassword3" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname3" type="hidden" id="txtdbname3" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport3" type="hidden" id="txtport3" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost3" type="hidden" id="txthost3" value="<?echo $host?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnro_aut3" type="hidden" id="txtnro_aut3" value="N" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_aut3" type="hidden" id="txtfecha_aut3" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_ord_ret3" type="hidden" id="txtgen_ord_ret3" value="<?echo $gen_ord_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_comp_ret3" type="hidden" id="txtgen_comp_ret3" value="<?echo $gen_comp_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_pre_ret3" type="hidden" id="txtgen_pre_ret3" value="<?echo $gen_pre_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txttipo_caus3" type="hidden" id="txttipo_caus3" value="<?echo $tipo_caus?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov3" type="hidden" id="txtcodigo_mov3" value="<?echo $codigo_mov?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_fin3" type="hidden" id="txtfecha_fin3" value="<?echo $fec_fin_e?>" ></td>
  </tr>
  </table>
</form>
</table>
</table>
</body>
</html>