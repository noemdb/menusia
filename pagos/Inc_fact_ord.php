<?include ("../class/ventana.php"); include ("../class/fun_numeros.php"); include ("../class/fun_fechas.php");
if (!$_GET){$codigo_mov="";$ivag=0;$ref_comp="N";$ced_rif="";$tipo_comp="";$ref_compromiso="";$monto=0;}
else{$codigo_mov=$_GET["codigo_mov"];$user=$_GET["user"];$password=$_GET["password"];$dbname=$_GET["dbname"];$ivag=$_GET["ivag"];$ref_comp=$_GET["ref_comp"];$ced_rif=$_GET["ced_rif"];$tipo_comp=$_GET["tipo_comp"];$ref_compromiso=$_GET["ref_compromiso"];$monto=$_GET["monto"];}
$tasa_iva=formato_monto($ivag);$fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Incluir Factura en la Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
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

function llamar_anterior(){ document.location ='Det_inc_fact_ord.php?codigo_mov=<?echo $codigo_mov?>&ref_comp=<?echo $ref_comp?>&ced_rif=<?echo $ced_rif?>'; }
function daformatomonto (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function quitacomas (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ".";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function cambia_punto_coma (monto){var i;var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ",";} else{if (monto.charAt(i) == '.'){str2 = str2 + ',';}else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } } }
   return str2;}   

function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_compromiso.value;   mref = Rellenarizq(mref,"0",4);    mform.txttipo_compromiso.value=mref;
return true;}
function apaga_tipo(mthis){var mref;var mtipo;
 apagar(mthis); mtipo=mthis.value; mref=document.form1.txtreferencia_comp.value;
 ajaxSenddoc('GET', 'amontfac.php?tipo='+mtipo+'&refcomp='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'montOb', 'innerHTML');
}
function apaga_referencia(mthis){var mref;var mtipo;
 apagar(mthis); mref=mthis.value;  mref=Rellenarizq(mref,"0",8);   document.form1.txtreferencia_comp.value=mref;
 mtipo=document.form1.txttipo_compromiso.value;
 ajaxSenddoc('GET', 'amontfac.php?tipo='+mtipo+'&refcomp='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'montOb', 'innerHTML');
}
function checkreferencia(mform){var mref;
   mref=mform.txtnro_orden.value;   mref=Rellenarizq(mref,"0",8);   document.form1.txtreferencia_comp.value=mref;
return true;}
function chequea_factura(mform){var mref=mform.txtnro_factura.value;;  var mcont=mform.txtnro_factura.value;
   if (SoloNumero(mref)){ mref=Rellenarizq(mref,"0",20); if(mcont.length>8){ mcont="00000000";}
     mcont="00-"+Rellenarizq(mcont,"0",8); }  
   mform.txtnro_factura.value=mref; mform.txtnro_con_factura.value=mcont;
return true;}
function apaga_fact(mthis){var mref; var mcont=mthis.value; apagar(mthis); mref=mthis.value;
 if (SoloNumero(mref)){ mref=Rellenarizq(mref,"0",20);  mcont="00-"+Rellenarizq(mcont,"0",8);  } document.form1.txtnro_factura.value=mref; 
 
}
function chequea_fecha(mform){var mref;var mfec;
  mref=mform.txtfecha_factura.value;
  if(mform.txtfecha_factura.value.length==8){ mfec=mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_factura.value=mfec;}
return true;}
function apaga_fecha(mthis){var mref;var mfec;  apagar(mthis);
  mref=mform.txtfecha_factura.value;
  if(mform.txtfecha_factura.value.length==8){ mfec=mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  document.form1.txtfecha_factura.value=mfec;}
}
function chequea_control(mform){var mref;
   mref=mform.txtnro_con_factura.value;  if (SoloNumero(mref)){mref=Rellenarizq(mref,"0",20); }   mform.txtnro_con_factura.value=mref;
return true;}
function apaga_cont(mthis){var mref; apagar(mthis);
 mref=mthis.value;  if (SoloNumero(mref)){mref=Rellenarizq(mref,"0",20); }  
 document.form1.txtnro_con_factura.value=mref;
}
function encende_monto(mthis){var mmonto; encender(mthis);   mthis.select();
  mmonto=document.form1.txtmonto_sin_iva.value; mmonto=eliminapunto(mmonto);  document.form1.txtmonto_sin_iva.value=mmonto; 
}
function encende_fecha(mthis){var mmonto; encender(mthis); 
  mthis.select(); 
}
function chequea_monto(mform){var mmonto; var miva; var smonto=mform.txtmonto_sin_iva.value; 
   smonto=cambia_punto_coma(smonto); mform.txtmonto_sin_iva.value=smonto;
   mform.txtmonto_iva1_so.value=smonto; mform.txtmonto_iva4_so.value=smonto;
   mmonto=quitacomas(smonto); miva=quitaformatomonto(mform.txttasa_iva.value);
   mmonto=(mmonto*1);  miva=(mmonto*(miva/100));   miva=(mmonto+miva); miva=Math.round(miva*100)/100; 
   mform.txtmonto_factura.value=miva;  mform.txtmonto_factura.value=daformatomonto(mform.txtmonto_factura.value);
return true;}
function apaga_monto(mthis){var mmonto; var miva;
 apagar(mthis);
 mmonto=mthis.value; document.form1.txtmonto_iva1_so.value=mmonto; document.form1.txtmonto_iva4_so.value=mmonto;
 mmonto=quitacomas(mmonto);  miva=quitaformatomonto(document.form1.txttasa_iva.value);
 mmonto=(mmonto*1);  miva=(mmonto*(miva/100)); miva=(mmonto+miva);  miva=Math.round(miva*100)/100;
 document.form1.txtmonto_factura.value=miva; document.form1.txtmonto_factura.value=daformatomonto(document.form1.txtmonto_factura.value);
}
function chequea_tasa(mform){var mmonto; var miva;
   mmonto=quitacomas(mform.txtmonto_iva1_so.value);
   miva=quitaformatomonto(mform.txttasa_iva.value);
   mmonto=(mmonto*1); miva=(mmonto*(miva/100));  miva=(mmonto+miva);  miva=Math.round(miva*100)/100;
   mform.txtmonto_factura.value=miva;  mform.txtmonto_factura.value=daformatomonto(mform.txtmonto_factura.value);
return true;}
function apaga_tasa(mthis){var mmono; var miva;
 apagar(mthis);
 mmonto=quitacomas(mform.txtmonto_iva1_so.value);  miva=mthis.value;
 mmonto=(mmonto*1); miva=(mmonto*(miva/100));  miva=(mmonto+miva);  miva=Math.round(miva*100)/100;
 mform.txtmonto_factura.value=miva; mform.txtmonto_factura.value=daformatomonto(mform.txtmonto_factura.value);
}

function chequea_objeto(mform){var mmonto; var msubt; var miva; var smonto=mform.txtmonto_iva1_so.value; 
   smonto=cambia_punto_coma(smonto); mform.txtmonto_iva1_so.value=smonto;
   mmonto=quitacomas(mform.txtmonto_iva1_so.value);    msubt=quitacomas(mform.txtmonto_sin_iva.value);    miva=quitaformatomonto(mform.txttasa_iva.value);
   mmonto=(mmonto*1); miva=(mmonto*(miva/100)); msubt=(msubt*1);  miva=(msubt+miva);   miva=Math.round(miva*100)/100;
   mform.txtmonto_factura.value=miva; document.form1.txtmonto_factura.value=daformatomonto(document.form1.txtmonto_factura.value);
return true;}

function apaga_objeto(mthis){var mmonto; var msubt; var miva;
 apagar(mthis);
 mmonto=mthis.value; mmonto=quitacomas(mmonto);  miva=quitaformatomonto(document.form1.txttasa_iva.value);  msubt=quitacomas(document.form1.txtmonto_sin_iva.value);
 msubt=(msubt*1);  mmonto=(mmonto*1);  miva=(mmonto*(miva/100));  miva=(msubt+miva);  miva=Math.round(miva*100)/100;
 document.form1.txtmonto_factura.value=miva; document.form1.txtmonto_factura.value=daformatomonto(document.form1.txtmonto_factura.value);
}

function apaga_obj_ret(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto_iva4_so.value;  mmonto=cambia_punto_coma(mmonto);document.form1.txtmonto_iva4_so.value=mmonto;
return true;}
function Llama_catalogo(){var murl;
  murl="Cat_comp_benef.php?codigo_mov=<?echo$codigo_mov;?>&ivag=<?echo$ivag;?>&ref_comp=<?echo$ref_comp;?>&ced_rif=<?echo $ced_rif?>&tipo_comp=&ref_compromiso=";
  document.location=murl;
}
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtfecha_factura.value==""){alert("Fecha no puede estar Vacia"); f.txtfecha_factura.focus(); return false;}
   if(f.txtfecha_factura.value.length==10){Valido=true;}else{alert("Longitud de Fecha Invalida"); f.txtfecha_factura.focus(); return false;}
   if(f.txtnro_factura.value==""){alert("Numero de Factura no puede estar Vacio"); f.txtnro_factura.focus();  return false;}else{f.txtnro_factura.value=f.txtnro_factura.value.toUpperCase();}
   if(f.txtnro_con_factura.value==""){alert("Numero de Control no puede estar Vacio");  f.txtnro_con_factura.focus();  return false;}else{f.txtnro_con_factura.value=f.txtnro_con_factura.value.toUpperCase();}
   if(f.txtmonto_factura.value==""){alert("Monto no puede estar Vacio"); f.txtmonto_factura.focus(); return false;}
document.form1.submit;
return true;}
   
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;font-weight: bold;color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Insert_fact_ord.php" onSubmit="return revisar()">
  <table width="666" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="899"><table width="659" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR NUEVA FACTURA A LA ORDEN</span></td>
        </tr>
            <? if($ref_comp=='S'){?><tr><td><table width="656">
            <tr>
              <td width="177"><span class="Estilo5">DOCUMENTO COMPROMISO:</span></td>
              <td width="56"><input class="Estilo10" name="txttipo_compromiso" type="text"  id="txttipo_compromiso" size="6" maxlength="4" onFocus="encender(this);" onBlur="apaga_tipo(this)"  onchange="chequea_tipo(this.form);" value="<?echo $tipo_comp?>" onkeypress="return stabular(event,this)"></td>
              <td width="95"><span class="Estilo5"><input class="Estilo10" name="btcomp_rif" type="button" id="btcomp_rif" title="Abrir Catalogo de Compomisos del Beneficiario" onClick="Llama_catalogo()" value="..." onkeypress="return stabular(event,this)">  </span></td>
              <td width="128"><span class="Estilo5">REFERENCIA :</span></td>
              <td width="176"><input class="Estilo10" name="txtreferencia_comp" type="text" id="txtreferencia_comp" size="12" maxlength="8"  onFocus="encender(this);" onBlur="apaga_referencia(this)" onchange="checkreferencia(this.form);" value="<?echo $ref_compromiso?>" onkeypress="return stabular(event,this)"></td>
            </tr>
          </table></td> </tr>  <? }?>
        <tr>
          <td><table width="654">
            <tr>
              <td width="153"><span class="Estilo5">N&Uacute;MERO DOCUMENTO:</span></td>
              <td width="183"><input class="Estilo10" name="txtnro_factura" type="text"  id="txtnro_factura" size="25" maxlength="20" onFocus="encender(this);" onBlur="apaga_fact(this)"  onchange="chequea_factura(this.form);" onkeypress="return stabular(event,this)"></td>
              <td width="123"><span class="Estilo5">FECHA FACTURA:</span></td>
              <td width="175"><input class="Estilo10" name="txtfecha_factura" type="text" id="txtfecha_factura" size="12" maxlength="10" onFocus="encende_fecha(this);" onBlur="apaga_fecha(this)"  onchange="chequea_fecha(this.form);" value="<?echo $fecha_hoy?>" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="655" border="0">
              <tr>
                <td width="154"><span class="Estilo5">N&Uacute;MERO DE CONTROL:</span></td>
                <td width="182"><span class="Estilo5"><input class="Estilo10" name="txtnro_con_factura" type="text" id="txtnro_con_factura"  size="25" maxlength="20" onFocus="encender(this); " onBlur="apaga_cont(this)"  onchange="chequea_control(this.form);" onkeypress="return stabular(event,this)">  </span></td>
                <td width="182">&nbsp;</td>
                <td width="119">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="655" border="0">
            <tr>
              <td width="154"><span class="Estilo5">MONTO SIN IVA: </span></td>
              <td width="182"><span class="Estilo5"><div id="montOb"><input class="Estilo10" name="txtmonto_sin_iva" type="text" id="txtmonto_sin_iva" size="22" style="text-align:right" onFocus="encende_monto(this);" onBlur="apaga_monto(this)"  onchange="chequea_monto(this.form);" value="<?echo $monto?>" onKeypress="return validarNum(event,this)">  </div> </span></td>
              <td width="124"><span class="Estilo5">TASA DE IVA:</span></td>
              <td width="177"><span class="Estilo5"><input class="Estilo10" name="txttasa_iva" type="text" id="txttasa_iva" size="6" maxlength="5" style="text-align:right" onFocus="encender(this);" onBlur="apaga_tasa(this)" onchange="chequea_tasa(this.form);" value="<?echo $tasa_iva?>" onKeypress="return validarNum(event,this)">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="654" border="0">
            <tr>
              <td width="153"><span class="Estilo5">MONTO OBJETO:</span></td>
              <td width="182"><span class="Estilo5"><input class="Estilo10" name="txtmonto_iva1_so" type="text" id="txtmonto_iva1_so" size="22" style="text-align:right" onFocus="encender(this);" onBlur="apaga_objeto(this)"  onchange="chequea_objeto(this.form);" onKeypress="return validarNum(event,this)"> </span> </td>
              <td width="126"><span class="Estilo5">MONTO CON IVA:</span></td>
              <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtmonto_factura" type="text" id="txtmonto_factura" size="22" style="text-align:right" maxlength="22" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event,this)"> </span></td>
            </tr>
          </table>            </td>
        </tr>
        <tr>
          <td><table width="654" border="0">
            <tr>
              <td width="153"><span class="Estilo5">MONTO OBJETO RETENCION:</span></td>
              <td width="182"><span class="Estilo5"><input class="Estilo10" name="txtmonto_iva4_so" type="text" id="txtmonto_iva4_so" size="22" style="text-align:right" onFocus="encender(this);" onBlur="apaga_obj_ret(this)" onKeypress="return validarNum(event,this)"> </span> </td>
			  <td width="126"><span class="Estilo5">RIF FACTURA :</span></td>
              <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtrif_fact" type="text"  id="txtrif_fact"  value="<?echo $ced_rif?>" size="14" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)"> </span> </td>
             </tr>
          </table>            </td>
        </tr>		
		<tr>
          <td><table width="655" border="0">
              <tr>
			    <? if($ref_comp=='S'){?>
                <td width="154"><span class="Estilo5">MONTO ANTICIPO:</span></td>
                <td width="182"><span class="Estilo5"><input class="Estilo10" name="txtmonto_iva3_so" type="text" id="txtmonto_iva3_so" value="0" size="22" maxlength="20" style="text-align:right" onFocus="encender(this); " onBlur="apagar(this)" onKeypress="return validarNum(event,this)">  </span></td>
                <td width="126"><span class="Estilo5">FACT AFECTADA:</span></td>
				<td width="175"><span class="Estilo5"><input class="Estilo10" name="txtcampo_str2" type="text" id="txtcampo_str2"  size="22" maxlength="20" onFocus="encender(this); " onBlur="apagar(this)" onkeypress="return stabular(event,this)">  </span></td>
               <? } else{?>
                <td width="154"><span class="Estilo5">FACT AFECTADA:</span></td>
				<td width="182"><span class="Estilo5"><input class="Estilo10" name="txtcampo_str2" type="text" id="txtcampo_str2"  size="22" maxlength="20" onFocus="encender(this); " onBlur="apagar(this)" onkeypress="return stabular(event,this)">  </span></td>
                <td width="126">&nbsp;</td>
                <td width="175">&nbsp;</td>
				<? }?>
              </tr>
          </table></td>
        </tr>
		
        <tr>
          <td><p>&nbsp;</p>  </td>
        </tr>
      </table>
        <table width="595" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100"><input name="txtref_comp" type="hidden" id="txtref_comp" value="<?echo $ref_comp?>"></td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117"><input name="txtced_rif" type="hidden" id="txtced_rif" value="<?echo $ced_rif?>"></td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>
