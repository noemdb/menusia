<?include ("../class/ventana.php"); include ("../class/fun_fechas.php");
 $codigo_mov=$_POST["txtcodigo_mov"];  $fecha_hoy=asigna_fecha_hoy(); $tipo_imput_presu="P"; $bloqueada=$_POST["txtbloqueada"];  $cod_est=$_POST["txtcod_est"]; $gen_ord_ret=$_POST["txtgen_ord_ret"]; $Cod_Emp=$_POST["txtcod_emp"];
 $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"]; $port=$_POST["txtport"]; $host=$_POST["txthost"];  $nro_aut=$_POST["txtnro_aut"]; $fecha_aut=$_POST["txtfecha_aut"]; $tipo_caus=$_POST["txttipo_caus"];
 $ced_r=$_POST["txtced_r"]; $nomb_r=$_POST["txtnomb_r"]; $con_est=$_POST["txtcon_est"]; $tipo_doc=$_POST["txttipo_doc"]; $nro_doc=$_POST["txtnro_doc"]; $tipo_ord=$_POST["txttipo_ord"]; $fecha_d=$_POST["txtfecha_d"]; $fecha_h=$_POST["txtfecha_h"];
 if ($cod_est==""){$asigna_v="N";} else {$asigna_v="S";} $fec_fin_e=$_POST["txtfecha_fin"]; $nro_ord=$_POST["txtnro_ord"]; $fecha_v=$_POST["txtfecha_v"]; $comp_automatico=$_POST["txtcomp_automatico"]; $des_tipo_orden=$_POST["txtdes_t_orden"];
 $fecha_fin=formato_ddmmaaaa($fec_fin_e);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}
 if($fecha_d==""){$fecha_d=$fecha_hoy;} if($fecha_h==""){$fecha_h=$fecha_hoy;} if($fecha_v==""){$fecha_v=$fecha_hoy;}
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
function Llamar_Inc_Orden(){document.form2.submit(); }
function asigna_valor(mop){
var mcod_est='<?php echo $cod_est ?>';
  if(mop=='1'){ ajaxSenddoc('GET', 'asignaest.php?op=1&cod_est='+mcod_est+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'drif', 'innerHTML'); }
  if(mop=='2'){ ajaxSenddoc('GET', 'asignaest.php?op=2&cod_est='+mcod_est+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'dconc', 'innerHTML'); }
  if(mop=='3'){ ajaxSenddoc('GET', 'asignaest.php?op=3&cod_est='+mcod_est+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'dtipord', 'innerHTML'); }
  if(mop=='4'){ ajaxSenddoc('GET', 'asignaest.php?op=4&cod_est='+mcod_est+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'fechad', 'innerHTML'); }
  if(mop=='5'){ ajaxSenddoc('GET', 'asignaest.php?op=5&cod_est='+mcod_est+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'fechah', 'innerHTML'); }
return true;}
function chequea_tipo(mform){var mref;
  mref=mform.txttipo_causado.value;  mref = Rellenarizq(mref,"0",4);  mform.txttipo_causado.value=mref;
  if (mref == "0000" || mref=="A000" || mref.substring(0,1)=="A"){alert("Tipo de Causado No Aceptado"); return false;}  
return true;}
function apaga_doc(mthis){var mref; apagar(mthis); mref=mthis.value; mref=Rellenarizq(mref,"0",4); 
}
function checkreferencia(mform){var mref;
   mref=mform.txtnro_orden.value;   mref = Rellenarizq(mref,"0",8);   mform.txtnro_orden.value=mref;
return true;}
function checkcedrif(mform){var mref; var mnomb; var mtipo; var norden;
   mref=mform.txtced_rif.value;   mnomb=mform.txtnombre.value;
   mform.txtced_rif_ces.value=mref;   mform.txtnombre_ces.value=mnomb;
   mtipo=document.form1.txttipo_orden.value;   norden=document.form1.txtnro_orden.value;
   ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mtipo+'&cedrif='+mref+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
 return true;}
function apaga_cedrif(mthis){var mref;var mnomb; var mtipo; var norden;
 apagar(mthis); mref=mthis.value;
 mnomb=document.form1.txtnombre.value; document.form1.txtced_rif_ces.value=mref;
 document.form1.txtnombre_ces.value=mnomb; mtipo=document.form1.txttipo_orden.value; norden=document.form1.txtnro_orden.value;
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
function apaga_tipoord(mthis){var mref; var mcedrif; var norden;
 apagar(mthis); mref=mthis.value;
 mref=Rellenarizq(mref,"0",4);
 mcedrif=document.form1.txtced_rif.value;
 norden=document.form1.txtnro_orden.value;
 ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mref+'&cedrif='+mcedrif+'&norden='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
}
function checktipoord(mform){var mref; var mcedrif; var norden;
   mref=mform.txttipo_orden.value;   mref=Rellenarizq(mref,"0",4);   mform.txttipo_orden.value=mref;
   mcedrif=mform.txtced_rif.value;   norden=mform.txtnro_orden.value;
   ajaxSenddoc('GET', 'vtipoord.php?tipo_ord='+mref+'&mcedrif='+mcedrif+'&norden='+norden+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destord', 'innerHTML');
return true;}
function checkrefecha(mform){var mref; var mfec;
  mref=mform.txtfecha.value;  mfec=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha.value=mfec;}
  mform.txtfecha_desde.value=mfec;   mform.txtfecha_hasta.value=mfec;    mform.txtfecha_vencim.value=mfec;
return true;}
function checkrefecha_desde(mform){var mref; var mfec;
  mref=mform.txtfecha_desde.value;
  if(mform.txtfecha_desde.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtfecha_desde.value=mfec;}
return true;}
function checkrefecha_hasta(mform){var mref; var mfec;
  mref=mform.txtfecha_hasta.value;
  if(mform.txtfecha_hasta.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtfecha_hasta.value=mfec;}
return true;}
function checkrefecha_venc(mform){var mref; var mfec;
  mref=mform.txtfecha_vencim.value;
  if(mform.txtfecha_vencim.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_vencim.value=mfec;}
return true;}
function Llamar_factura(){var ced_rif;
  ced_rif=document.form1.txtced_rif.value;
  Ventana_002('Det_inc_fact_ord.php?codigo_mov=<?echo $codigo_mov?>&ref_comp=N&ced_rif='+ced_rif,'SIA','','980','400','true')
return true;}
function Llamar_ced_rif(){var ced_rif;
  ced_rif=document.form1.txtced_rif.value;
  VentanaCentrada('Cat_benef_orden.php?criterio='+ced_rif,'SIA','','750','500','true')
return true;}
function Llamar_cargaest(){var codest; var desest;
  codest=document.form1.txtcod_est.value;    desest="";
//  Ventana_002('Cargar_est_ord.php?codigo_mov=<?echo $codigo_mov?>&ref_comp=N&codest='+codest+'&desest='+desest,'SIA','','780','300','true')
  document.location ='Cargar_est_ord.php?codigo_mov=<?echo $codigo_mov?>&ref_comp=N';
return true;}
function Llamar_Pegar_Orden(){ var murl; murl="pegar_orden.php?codigo_mov=<?echo $codigo_mov?>&ref_comp=N"; document.location = murl;}
function revisar(){var f=document.form1; var valido=true; var r;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia"); f.txtfecha.focus(); return false;}
    if(f.txtnro_orden.value==""){alert("Numero de Orden no puede estar Vacia"); f.txtnro_orden.focus();  return false;}    else{f.txtnro_orden.value=f.txtnro_orden.value;}
    if(f.txttipo_causado.value==""){alert("Tipo de Causado no puede estar Vacio"); f.txttipo_causado.focus(); return false; }     else{f.txttipo_causado.value=f.txttipo_causado.value.toUpperCase();}
    if(f.txtconcepto.value==""){alert("Concepto de la Orden no puede estar Vacia"); f.txtconcepto.focus(); return false; }    else{f.txtconcepto.value=f.txtconcepto.value.toUpperCase();}
    if(f.txtnro_orden.value.length==8){f.txtnro_orden.value=f.txtnro_orden.value.toUpperCase();f.txtnro_orden.value=f.txtnro_orden.value;}    else{alert("Longitud de Numero de Orden  Invalida"); f.txtnro_orden.focus(); return false;}
    if(f.txtfecha.value.length==10){valido=true;}     else{alert("Longitud de Fecha Invalida"); f.txtfecha.focus();  return false;}
    if(f.txttipo_causado.value=="0000" || f.txttipo_causado.value=="A000" ) {alert("Tipo de Causado No Aceptado"); f.txttipo_causado.focus();  return false; }
    if(f.txtfecha_desde.value.length==10){valido=true;}  else{alert("Longitud de Fecha desde Invalida"); f.txtfecha_desde.focus(); return false;}
    if(f.txtfecha_hasta.value.length==10){valido=true;}  else{alert("Longitud de Fecha hasta Invalida"); f.txtfecha_hasta.focus();  return false;}
    if(f.txtfecha_vencim.value.length==10){valido=true;}  else{alert("Longitud de Fecha vencimiento Invalida"); f.txtfecha_vencim.focus(); return false;}
    if(f.txtced_rif.value==""){alert("Cedula/Rif del Beneficiario no puede estar Vacia");  f.txtced_rif.focus(); return false; }      else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    if(f.txttipo_orden.value==""){alert("Tipo de Orden no puede estar Vacio"); return false; }      else{f.txttipo_orden.value=f.txttipo_orden.value.toUpperCase();}
    if(f.txtpago_ces.checked==true){ f.txtp_ces.value="S"; } else{ f.txtp_ces.value="N"; }
	r=confirm("Desea Grabar la Orden de Pago ?");  if (r==true) { valido=true;} else{return false;} 
document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
</script>
</head>
<?$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } $nombre_tipo_caus=""; $des_tipo_orden="";
$sSQL="SELECT tipo_causado, nombre_tipo_caus,nombre_abrev_caus from pre003 Where (tipo_causado='$tipo_caus')";$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);   
if ($filas>0){ $reg=pg_fetch_array($resultado); $nombre_tipo_caus=$reg["nombre_abrev_caus"]; }
$sSQL="Select des_tipo_orden from pag008 WHERE tipo_orden='$tipo_ord'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
if ($filas>0){$registro=pg_fetch_array($resultado); $des_tipo_orden=$registro["des_tipo_orden"]; }
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR ORDEN DE PAGO DIRECTA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="668" border="0" id="tablacuerpo">
  <tr>
     <td><table width="92" height="652" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablam">
     <td width="86">
     <td><table width="92" height="652" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Pegar_Orden();">Pegar Orden</A></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
     </tr>
     <tr><td>&nbsp;</td></tr>
  </table></td>
</table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:595px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Insert_orden_pago.php" onSubmit="return revisar()">
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
                              <input class="Estilo10" name="txtnro_orden" type="text"  id="txtnro_orden" size="12" maxlength="8" value="<?echo $nro_ord?>" readonly >
                            <? }else{?>
                             <input class="Estilo10" name="txtnro_orden" type="text"  id="txtnro_orden" size="12" maxlength="8" value="<?echo $nro_ord?>" onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);" onkeypress="return stabular(event,this)">
                            <? }?>
                             </div> </td>
						  <? if( $nro_ord==''){?>	 
                           <script language="JavaScript" type="text/JavaScript">
                            ajaxSenddoc('GET', 'refordaut.php?nro_aut='+mnro_aut+'& password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrorden', 'innerHTML');
                          </script>
						  <? }?>	 
                          <td width="55"><span class="Estilo5"></span></td>
                          <td width="150"><span class="Estilo5">DOCUMENTO CAUSADO:</span></td>
                          <td width="58"><span class="Estilo5"><input class="Estilo10" name="txttipo_causado" type="text"  id="txttipo_causado" size="6" maxlength="4"  value="<?echo $tipo_caus?>"  readonly onkeypress="return stabular(event,this)"> </span></td>
                          <td width="165"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" size="6"  value="<?echo $nombre_tipo_caus?>" readonly onkeypress="return stabular(event,this)"> </span></td>
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
                          <td width="101"><span class="Estilo5"> <div id="drif"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="12" onFocus="encender(this); " onBlur="apaga_cedrif(this);" onchange="checkcedrif(this.form);" value="<?echo $ced_r?>" onkeypress="return stabular(event,this)"></div> </span></td>
                          <td width="44"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="Llamar_ced_rif()" value="..." onkeypress="return stabular(event,this)">  </span></td>
                          <td width="529"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="84" readonly value="<?echo $nomb_r?>" onkeypress="return stabular(event,this)">
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="860" >
                        <tr>
                          <td width="175" height="30"><span class="Estilo5">CESIONARIO A COBRAR :<input class="Estilo10" name="txtpago_ces" type="checkbox" value="checkbox" onkeypress="return stabular(event,this)">   </span></td>
                          <td width="90"><span class="Estilo5">C&Eacute;DULA/RIF : </span></td>
                          <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif_ces" type="text" id="txtced_rif_ces" size="15" maxlength="12" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)"></span> </td>
                          <td width="40"><span class="Estilo5"><input class="Estilo10" name="btced_rif_ces" type="button" id="btced_rif_ces" title="Abrir Catalogo de Beneficiarios Cesionarios" onClick="VentanaCentrada('Cat_benef_ces.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
                           <td width="65"><span class="Estilo5">NOMBRE :</span></td>
                          <td width="370"><span class="Estilo5"><input class="Estilo10" name="txtnombre_ces" type="text" id="txtnombre_ces" size="55" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)"> </span> </td>
                        </tr>
                      </table></td>
                    </tr>       
    <!--                 <? if($asigna_v=='S'){?><script language="JavaScript" type="text/JavaScript"> asigna_valor('1');</script>   <? }?> -->
                    <tr>
                      <td><table width="847" border="0">
                        <tr>
                          <td width="80"><span class="Estilo5">CONCEPTO:</span></td>
                          <td width="757"><div id="dconc"><textarea name="txtconcepto" cols="95" onFocus="encender(this); " onBlur="apagar(this);" class="Estilo10" id="txtconcepto" onkeypress="return stabular(event,this)"><?echo $con_est?></textarea> </div></td>
                         </tr>
   <!--               <? if($asigna_v=='S'){?><script language="JavaScript" type="text/JavaScript"> asigna_valor('2');</script>   <? }?>   -->
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="857" >
                        <tr>
                          <td width="123" height="24"><span class="Estilo5">TIPO DOCUMENTO : </span></td>
                          <td width="174"><span class="Estilo5"><div id="tipodoc"><select name="txttipo_documento" id="txttipo_documento" onFocus="encender(this)" onBlur="apaga_tipodoc(this);" onchange="checktipodoc(this.form);" class="Estilo10" onkeypress="return stabular(event,this)">
                          <option>FACTURA</option> <option>RECIBO</option> <option>NOTA ENTREGA</option>  <option>CONTRATO</option> <option>VALUACION</option> <option>ANTICIPO</option>    <option>NOMINA</option> <option>DOCUMENTO</option>   </select></div>
                          <script language="JavaScript" type="text/JavaScript">var mtipod='<?php echo $tipo_doc ?>'; ajaxSenddoc('GET', 'cargatipodoc.php?password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&tipo_doc='+mtipod, 'tipodoc', 'innerHTML'); </script>
                          </span></td>
                           <td width="40"><span class="Estilo5"><div id="btdoc">  <input class="Estilo10" name="btfacturas" type="button" id="btfacturas" title="Registrar Facturas de la Orden " onClick="Llamar_factura()" value="..." onkeypress="return stabular(event,this)">   </div>     </span></td>
                           <td width="145"><span class="Estilo5">NUMERO DOCUMENTO :</span></td>
                          <td width="351"><span class="Estilo5"><div id="nrdoc"> <input class="Estilo10" name="txtnro_documento" type="text" id="txtnro_documento"  onFocus="encender(this); " onBlur="apagar(this);"  size="55" value="<?echo $nro_doc?>" onkeypress="return stabular(event,this)" >   </div>     </span> </td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="850">
                        <tr>
                          <td width="123"><span class="Estilo5">TIPO DE ORDEN :</span>  </td>
                          <td width="73"><span class="Estilo5"><div id="dtipord"> <input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" size="8" maxlength="15"  onFocus="encender(this);" onBlur="apaga_tipoord(this);" onchange="checktipoord(this.form);"  value="<?echo $tipo_ord?>" onkeypress="return stabular(event,this)"></div>   </span> </td>
                          <td width="53"><span class="Estilo5"><input class="Estilo10" name="bttipo_orden" type="button" id="bttipo_orden" title="Abrir Catalogo Tipo de Orden " onClick="VentanaCentrada('Cat_tipo_orden.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
                          <td width="581"><span class="Estilo5"><div id="destord"> <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" size="80" value="<? echo $des_tipo_orden ?>" readonly  onkeypress="return stabular(event,this)"> </div>   </span></td> 
                        </tr>
                      </table></td>
   <!--  <? if($asigna_v=='S'){?><script language="JavaScript" type="text/JavaScript"> asigna_valor('3');</script>   <? }?>  -->
                    </tr>
                    <tr>
                      <td><table width="855">
                        <tr>
                          <td width="125"><span class="Estilo5">FECHA DESDE :</span></td>
                          <td width="182"><span class="Estilo5"><div id="fechad"><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="12" maxlength="10" onchange="checkrefecha_desde(this.form)" onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $fecha_d?>" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)"> </div>      </span></td>
                          <td width="102"><span class="Estilo5">FECHA HASTA :</span></td>
                          <td width="131"><span class="Estilo5"><div id="fechah"><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" onFocus="encender(this);" onchange="checkrefecha_hasta(this.form)" onBlur="apagar(this);" size="12" maxlength="10" value="<?echo $fecha_h?>" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)"> </div>   </span>   </td>
                          <td width="140"><span class="Estilo5">FECHA VENCIMIENTO :</span></td>
                          <td width="135"><input class="Estilo10" name="txtfecha_vencim" type="text" id="txtfecha_vencim" onFocus="encender(this);" onchange="checkrefecha_venc(this.form)" onBlur="apagar(this);" size="12" maxlength="10"   value="<?echo $fecha_v?>" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="855">
                        <tr>
                          <td width="114"><span class="Estilo5">TIPO DE GASTO :</span></td>
                          <td width="140"><span class="Estilo5"><select name="txtfunc_inv" size="1" id="txtfunc_inv" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onkeypress="return stabular(event,this)">
                              <option selected>CORRIENTE</option><option>INVERSION</option><option>CORRIENTE/INVERSION</option> </select></span> </td>
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
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:312px; z-index:2; left: 2px; top: 305px;">
              <script language="javascript" type="text/javascript">
   var mbloq = '<?echo $bloqueada?>';
   var gordr = '<?echo $gen_ord_ret?>';
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 850;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "C&oacute;d. Presupuestario";
   rows[1][2] = "Retenciones";
   rows[1][3] = "Comprobantes";
   rows[1][4] = "Otros Pasivos";
   if ((mbloq=="N")&&(gordr=="N")) {
    rows[1][5] = "O/P Retenc. Canc.";
	
   }
   //rows[1][6] = "Fact. Sin Retenc.";
            </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_inc_cod_ord.php?codigo_mov=<?echo $codigo_mov?>&bloqueada=<?echo $bloqueada?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_inc_ret_orden.php?codigo_mov=<?echo $codigo_mov?>&bloqueada=<?echo $bloqueada?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
                          <!--PESTA&Ntilde;A 3 -->
              <div id="T13" class="tab-body" >
                <iframe src="Det_inc_comp_orden.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
                          <!--PESTA&Ntilde;A 4 -->
              <div id="T14" class="tab-body" >
                <iframe src="Det_inc_pas_orden.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <? if(($bloqueada=='N')and($gen_ord_ret=="N")){?>
                <!--PESTA&Ntilde;A 5 -->
                <div id="T15" class="tab-body" >
                  <iframe src="Det_inc_opret_orden.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
				<!--PESTA&Ntilde;A 5 -->
                <div id="T16" class="tab-body" >
                  <iframe src="Det_inc_facret_orden.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
              <? }?>
            </div></td>
         </tr>
        </table>
        <div id="Layer3" style="position:absolute; width:860px; height:60px; z-index:2; left: 2px; top: 640px;">
        <table width="860">
          <tr>
            <td width="2"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="2"><input class="Estilo10" name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td> 
            <td width="2"><input class="Estilo10" name="txtp_ces" type="hidden" id="txtp_ces" value="N"></td>
			<td width="2"><input class="Estilo10" name="txtcod_est" type="hidden" id="txtcod_est"></td>
			<td width="2"><input class="Estilo10" name="txtcaus_directo" type="hidden" id="txtcaus_directo" value="SI"></td>
			
			<td width="240"><span class="Estilo5">GENERAR COMPROBANTES DE RETENCION AUTOMATICO:</span></td>
            <td width="60"><span class="Estilo5"><select name="txtcomp_aut" size="1" id="txtcomp_aut" onFocus="encender(this)" onBlur="apagar(this)">
            <option selected>SI</option> <option>NO</option> </select></span></td>		
<script language="JavaScript" type="text/JavaScript">var mnro_aut='<?php echo $nro_aut ?>'; var mcomp_aut='<?php echo $comp_automatico ?>';  
if(mnro_aut=="S"){if(mcomp_aut=="S"){document.form1.txtcomp_aut.options[0].selected = true;}else{document.form1.txtcomp_aut.options[1].selected = true;}}
else{if(mcomp_aut=="S"){document.form1.txtcomp_aut.options[0].selected = true;}else{document.form1.txtcomp_aut.options[1].selected = true;} } </script>			
			
			<?if($Cod_Emp=="58"){?>
            <td width="140"><span class="Estilo5">ORDEN PERMANENTE:</span></td>
			<td width="60"><span class="Estilo5"><select name="txtord_per" size="1" id="txtord_per" onFocus="encender(this)" onBlur="apagar(this)">
                <option>SI</option> <option selected>NO</option> </select></span></td>			
            <td width="30"><span class="Estilo5"><input class="Estilo10" name="txtper_permanente" type="text"  id="txtper_permanente" size="2" maxlength="2" onFocus="encender(this); " onBlur="apagar(this);" value="0"> </span></td>
            <?} else {?>
			<td width="200"><input class="Estilo10" name="txtord_per" type="hidden" id="txtord_per" value="NO"></td>
			<td width="30"><input class="Estilo10" name="txtper_permanente" type="hidden" id="txtper_permanente" value="0" ></td> 
			<?}?>			
			<td width="40"><input class="Estilo10" name="btmostrar_monto" type="button" id="btmostrar_monto"  value="..."  title="Mostrar Montos de la Orden " onclick="javascript:Ventana_002('Cons_monto_ord.php?codigo_mov=<?echo $codigo_mov?>','SIA','','650','200','true');"></td>
			<td width="80" valign="middle"><input class="Estilo10" name="button" type="submit" id="button" value="Grabar"></td>
            <td width="100"><input class="Estilo10" name="Submit" type="reset" value="Blanquear"></td>
            <td width="100"><input class="Estilo10" name="btcargaest" type="button" id="btcargaest"  value="Cargar Estructura"  title="Cargar estructuras de Orden " onClick="Llamar_cargaest()"></td>
          </tr>
        </table>
        </div>
        </form>
      </div>
    </td>
</tr>
<form name="form2" method="post" action="Inc_orden_pago.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
     <td width="5"><input class="Estilo10" name="txtnro_aut" type="hidden" id="txtnro_aut" value="N" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_ord_ret" type="hidden" id="txtgen_ord_ret" value="<?echo $gen_ord_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_comp_ret" type="hidden" id="txtgen_comp_ret" value="<?echo $gen_comp_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_pre_ret" type="hidden" id="txtgen_pre_ret" value="<?echo $gen_pre_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txttipo_caus" type="hidden" id="txttipo_caus" value="<?echo $tipo_caus?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtbloqueada" type="hidden" id="txtbloqueada" value="N" ></td>
     <td width="5"><input class="Estilo10" name="txtcod_est" type="hidden" id="txtcod_est" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtced_r" type="hidden" id="txtced_r" value=""></td>
     <td width="5"><input class="Estilo10" name="txtnomb_r" type="hidden" id="txtnomb_r" value=""></td>
     <td width="5"><input class="Estilo10" name="txtcon_est" type="hidden" id="txtcon_est" value=""></td>
     <td width="5"><input class="Estilo10" name="txttipo_doc" type="hidden" id="txttipo_doc" value=""></td>
     <td width="5"><input class="Estilo10" name="txtnro_doc" type="hidden" id="txtnro_doc" value=""></td>
     <td width="5"><input class="Estilo10" name="txttipo_ord" type="hidden" id="txttipo_ord" value=""></td>
     <td width="5"><input class="Estilo10" name="txtfecha_d" type="hidden" id="txtfecha_d" value=""></td>
     <td width="5"><input class="Estilo10" name="txtfecha_h" type="hidden" id="txtfecha_h" value=""></td>
	 <td width="5"><input class="Estilo10" name="txtnro_ord" type="hidden" id="txtnro_ord" value=""></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_v" type="hidden" id="txtfecha_v" value=""></td>	
	 <td width="5"><input class="Estilo10" name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $Cod_Emp?>" ></td> 
	 <td width="5"><input class="Estilo10" name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $fec_fin_e?>" ></td>
  </tr>
</table>
</form>
</table>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
var mtipo_doc='<?php echo $tipo_doc ?>';
for (var opcombo=0;opcombo<document.form1.txttipo_documento.length;opcombo++){if(document.form1.txttipo_documento[opcombo].text.toLowerCase()==mtipo_doc.toLowerCase()){  document.form1.txttipo_documento.options[opcombo].selected = true;}}  </script>


