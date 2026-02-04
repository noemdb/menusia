<?include ("../class/conect.php");  include ("../class/funciones.php"); 
if (!$_GET){$codigo_mov="";$nro_factura="";$ref_comp="N";$ced_rif="";}else{$codigo_mov=$_GET["codigo_mov"];$nro_factura=$_GET["factura"];$ref_comp=$_GET["ref_comp"];$ced_rif=$_GET["ced_rif"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Modificar Factura en la Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var Gfactura = "<?echo $nro_factura?>";
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 

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
function llamar_anterior(){ document.location ='Det_inc_fact_ord.php?codigo_mov=<?echo $codigo_mov?>&ref_comp=<?echo $ref_comp?>&ced_rif=<?echo $ced_rif?>'; }
function llamar_eliminar(codigo_mov,ref_comp){var murl;var r;
 if (Gfactura=="") {alert("Factura debe ser Seleccionada");}
  else { murl="Esta seguro en Eliminar la Factura:"+Gfactura+" de la Orden ?";
  r=confirm(murl);
  if(r==true){r=confirm("Esta Realmente seguro en Eliminar la Factura de la Orden ?");
    if(r==true){murl="Delete_fact_ord.php?codigo_mov="+codigo_mov+"&factura="+Gfactura+"&ref_comp="+ref_comp+"&ced_rif=<?echo $ced_rif?>";document.location=murl;}
    }else { url="Cancelado, no elimino"; }
  }
}
function chequea_fecha(mform){var mref;var mfec;mref=mform.txtfecha_factura.value;
  if(mform.txtfecha_factura.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);   mform.txtfecha_factura.value=mfec;}
return true;}
function apaga_fecha(mthis){var mref;var mfec;
  apagar(mthis); mref=mform.txtfecha_factura.value;
  if(mform.txtfecha_factura.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); document.form1.txtfecha_factura.value=mfec;}
}
function chequea_control(mform){var mref;
   mref=mform.txtnro_con_factura.value; if (SoloNumero(mref)){mref=Rellenarizq(mref,"0",20); } mform.txtnro_con_factura.value=mref;
return true;}
function apaga_cont(mthis){var mref;
 apagar(mthis); mref=mthis.value;
 if (SoloNumero(mref)){mref=Rellenarizq(mref,"0",20); } document.form1.txtnro_con_factura.value=mref;
}
function encende_monto(mthis){var mmonto; encender(mthis);  mthis.select();
  mmonto=document.form1.txtmonto_sin_iva.value; mmonto=eliminapunto(mmonto);  document.form1.txtmonto_sin_iva.value=mmonto; 
}
function encende_fecha(mthis){var mmonto; encender(mthis); 
  mthis.select(); 
}
function chequea_monto(mform){var mmonto; var miva;
   mform.txtmonto_iva1_so.value=mform.txtmonto_sin_iva.value; mform.txtmonto_iva4_so.value=mform.txtmonto_sin_iva.value;
   mmonto=quitacomas(mform.txtmonto_sin_iva.value);    miva=quitaformatomonto(mform.txttasa_iva.value);
   mmonto=(mmonto*1);  miva=(mmonto*(miva/100)); miva=(mmonto+miva); miva=Math.round(miva*100)/100;
   mform.txtmonto_factura.value=miva;  mform.txtmonto_factura.value=daformatomonto(mform.txtmonto_factura.value);
return true;}
function apaga_monto(mthis){
var mmonto; var miva;
 apagar(mthis);
 mmonto=mthis.value; document.form1.txtmonto_iva1_so.value=mmonto; mmonto=quitacomas(mmonto);  miva=quitaformatomonto(document.form1.txttasa_iva.value);
 mmonto=(mmonto*1);  miva=(mmonto*(miva/100)); miva=(mmonto+miva);  miva=Math.round(miva*100)/100;
 document.form1.txtmonto_factura.value=miva; document.form1.txtmonto_factura.value=daformatomonto(document.form1.txtmonto_factura.value);
}
function chequea_tasa(mform){
var mmonto; var miva;
   mmonto=quitacomas(mform.txtmonto_iva1_so.value);
   miva=quitaformatomonto(mform.txttasa_iva.value);
   mmonto=(mmonto*1); miva=(mmonto*(miva/100));  miva=(mmonto+miva);  miva=Math.round(miva*100)/100;
   mform.txtmonto_factura.value=miva;  mform.txtmonto_factura.value=daformatomonto(mform.txtmonto_factura.value);
return true;}
function apaga_tasa(mthis){
var mmonto; var miva;
 apagar(mthis);
 mmonto=quitacomas(mform.txtmonto_iva1_so.value);  miva=mthis.value;
 mmonto=(mmonto*1); miva=(mmonto*(miva/100));  miva=(mmonto+miva);  miva=Math.round(miva*100)/100;
 mform.txtmonto_factura.value=miva; mform.txtmonto_factura.value=daformatomonto(mform.txtmonto_factura.value);
}
function chequea_objeto(mform){
var mmonto; var msubt; var miva;
   mmonto=quitacomas(mform.txtmonto_iva1_so.value);    msubt=quitacomas(mform.txtmonto_sin_iva.value);    miva=quitaformatomonto(mform.txttasa_iva.value);
   mmonto=(mmonto*1); miva=(mmonto*(miva/100)); msubt=(msubt*1);  miva=(msubt+miva);   miva=Math.round(miva*100)/100;
   mform.txtmonto_factura.value=miva; document.form1.txtmonto_factura.value=daformatomonto(document.form1.txtmonto_factura.value);
return true;}
function apaga_objeto(mthis){
var mmonto; var msubt; var miva;
 apagar(mthis);
 mmonto=mthis.value; mmonto=quitacomas(mmonto);  miva=quitaformatomonto(document.form1.txttasa_iva.value);  msubt=quitacomas(document.form1.txtmonto_sin_iva.value);
 msubt=(msubt*1);  mmonto=(mmonto*1);  miva=(mmonto*(miva/100));  miva=(msubt+miva);  miva=Math.round(miva*100)/100;
 document.form1.txtmonto_factura.value=miva; document.form1.txtmonto_factura.value=daformatomonto(document.form1.txtmonto_factura.value);
}
function apaga_obj_ret(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto_iva4_so.value;  mmonto=cambia_punto_coma(mmonto);document.form1.txtmonto_iva4_so.value=mmonto;
return true;}
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
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF; }
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$nro_con_factura="";$fecha_factura="";$tipo_compromiso="";$ref_compromiso=""; $rif_factura=""; $campo_str2="";
$monto_factura=0;$monto_sin_iva=0; $monto_iva1_so=0; $monto_iva4_so=0; $campo_str1=""; $monto_iva3_so=0;
$sql="Select * from PAG029 WHERE codigo_mov='$codigo_mov' and nro_factura='$nro_factura'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $nro_con_factura=$registro["nro_con_factura"];  $fecha_factura=$registro["fecha_factura"];  $monto_sin_iva=$registro["monto_sin_iva"];  $monto_iva1_so=$registro["monto_iva1_so"];  $tasa_iva1=$registro["tasa_iva1"];
  $monto_factura=$registro["monto_factura"];  $monto_iva4_so=$registro["monto_iva4_so"]; $rif_factura=$registro["rif_factura"];  $monto_iva3_so=$registro["monto_iva3_so"];  $campo_str2=$registro["campo_str2"];
  $tipo_compromiso=$registro["tipo_compromiso"];  $ref_compromiso=$registro["ref_compromiso"]; $campo_str1=$registro["campo_str1"];
}
$monto_sin_iva=formato_monto($monto_sin_iva);$tasa_iva1=formato_monto($tasa_iva1);$monto_iva1_so=formato_monto($monto_iva1_so);$monto_iva4_so=formato_monto($monto_iva4_so);
$monto_factura=formato_monto($monto_factura);$monto_iva3_so=formato_monto($monto_iva3_so); if($fecha_factura==""){$fecha_factura="";}else{$fecha_factura=formato_ddmmaaaa($fecha_factura);}
?>
<body>
<form name="form1" method="post" action="Update_fact_ord.php" onSubmit="return revisar()">
  <table width="666" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="899"><table width="659" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR  FACTURA DE LA ORDEN</span></td>
        </tr>
                <? if($ref_comp=='S'){?> <tr><td><table width="656">
            <tr>
              <td width="178"><span class="Estilo5">DOCUMENTO COMPROMISO:</span></td>
              <td width="155"><input class="Estilo10" name="txttipo_compromiso" type="text"  id="txttipo_compromiso" size="6" maxlength="4" value="<?echo $tipo_compromiso?>" readonly onkeypress="return stabular(event,this)"></td>
              <td width="129"><span class="Estilo5">REFERENCIA :</span></td>
              <td width="174"><input class="Estilo10" name="txtreferencia_comp" type="text" id="txtreferencia_comp" size="12" value="<?echo $ref_compromiso?>" readonly onkeypress="return stabular(event,this)"></td>
            </tr>
          </table></td> </tr>  <? }?>
        <tr>
          <td><table width="654">
            <tr>
              <td width="153"><span class="Estilo5">N&Uacute;MERO DOCUMENTO:</span></td>
              <td width="183"><input class="Estilo10" name="txtnro_factura" type="text"  id="txtnro_factura" size="25" maxlength="20" onFocus="encender(this);" value="<?echo $nro_factura?>" readonly onkeypress="return stabular(event,this)"></td>
              <td width="123"><span class="Estilo5">FECHA DOCUMENTO:</span></td>
              <td width="175"><input class="Estilo10" name="txtfecha_factura" type="text" id="txtfecha_factura" size="12" maxlength="10" onFocus="encende_fecha(this);" onBlur="apaga_fecha(this)"  onchange="chequea_fecha(this.form);" value="<?echo $fecha_factura?>" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="655" border="0">
              <tr>
                <td width="154"><span class="Estilo5">N&Uacute;MERO DE CONTROL:</span></td>
                <td width="182"><span class="Estilo5"><input class="Estilo10" name="txtnro_con_factura" type="text" id="txtnro_con_factura"  size="25" maxlength="20" onFocus="encender(this); " onBlur="apaga_cont(this)"  onchange="chequea_control(this.form);"  value="<?echo $nro_con_factura?>" onkeypress="return stabular(event,this)">   </span></td>
                <td width="182">&nbsp;</td>
                <td width="119">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="655" border="0">
            <tr>
              <td width="154"><span class="Estilo5">MONTO SIN IVA: </span></td>
              <td width="182"><span class="Estilo5"><input class="Estilo10" name="txtmonto_sin_iva" type="text" id="txtmonto_sin_iva" size="22" style="text-align:right" onFocus="encende_monto(this);" onBlur="apaga_monto(this)"  onchange="chequea_monto(this.form);" value="<?echo $monto_sin_iva?>" onKeypress="return validarNum(event,this)"> </span></td>
              <td width="124"><span class="Estilo5">TASA DE IVA:</span></td>
              <td width="177"><span class="Estilo5"><input class="Estilo10" name="txttasa_iva" type="text" id="txttasa_iva" size="6" maxlength="5" style="text-align:right" onFocus="encender(this);" onBlur="apaga_tasa(this)" onchange="chequea_tasa(this.form);" value="<?echo $tasa_iva1?>" onKeypress="return validarNum(event,this)">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="654" border="0">
            <tr>
              <td width="153"><span class="Estilo5">MONTO OBJETO:</span></td>
              <td width="182"><span class="Estilo5"><input class="Estilo10" name="txtmonto_iva1_so" type="text" id="txtmonto_iva1_so" size="22" style="text-align:right" onFocus="encender(this);" onBlur="apaga_objeto(this)"  onchange="chequea_objeto(this.form);" value="<?echo $monto_iva1_so?>" onKeypress="return validarNum(event,this)"> </span> </td>
              <td width="126"><span class="Estilo5">MONTO CON IVA :</span></td>
              <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtmonto_factura" type="text" id="txtmonto_factura" size="22" style="text-align:right" maxlength="22" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $monto_factura?>" onKeypress="return validarNum(event,this)">  </span></td>
            </tr>
          </table>            </td>
        </tr>
		<tr>
          <td><table width="654" border="0">
            <tr>
              <td width="153"><span class="Estilo5">MONTO OBJETO RETENCION:</span></td>
              <td width="182"><span class="Estilo5"><input class="Estilo10" name="txtmonto_iva4_so" type="text" id="txtmonto_iva4_so" size="22" style="text-align:right" onFocus="encender(this);" onBlur="apaga_obj_ret(this)"  value="<?echo $monto_iva4_so?>" onKeypress="return validarNum(event,this)">  </span> </td>
              <td width="126"><span class="Estilo5">RIF FACTURA :</span></td>
              <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtrif_fact" type="text"  id="txtrif_fact"  value="<?echo $rif_factura?>" size="14" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)"> </span> </td>
           </tr>
          </table>            </td>
        </tr>
		<tr>
          <td><table width="655" border="0">
              <tr>
			    <? if($ref_comp=='S'){?>
                <td width="154"><span class="Estilo5">MONTO ANTICIPO:</span></td>
                <td width="182"><span class="Estilo5"><input class="Estilo10" name="txtmonto_iva3_so" type="text" id="txtmonto_iva3_so" value="0" size="22" maxlength="20" style="text-align:right" onFocus="encender(this); " onBlur="apagar(this)" value="<?echo $monto_iva3_so?>" onKeypress="return validarNum(event,this)">  </span></td>
                <td width="126"><span class="Estilo5">FACT AFECTADA:</span></td>
				<td width="175"><span class="Estilo5"><input class="Estilo10" name="txtcampo_str2" type="text" id="txtcampo_str2"  size="22" maxlength="20" onFocus="encender(this); " onBlur="apagar(this)" value="<?echo $campo_str2?>" onkeypress="return stabular(event,this)">  </span></td>
               <? } else{?>
                <td width="154"><span class="Estilo5">FACT AFECTADA:</span></td>
				<td width="182"><span class="Estilo5"><input class="Estilo10" name="txtcampo_str2" type="text" id="txtcampo_str2"  size="22" maxlength="20" onFocus="encender(this); " onBlur="apagar(this)" value="<?echo $campo_str2?>" onkeypress="return stabular(event,this)">  </span></td>
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
			<td width="20"><input name="txtcampo_str1" type="hidden" id="txtcampo_str1" value="<?echo $campo_str1?>"></td>            
            <td width="30"><input name="txtref_comp" type="hidden" id="txtref_comp" value="<?echo $ref_comp?>"></td>
            <td width="50"><input name="txtced_rif" type="hidden" id="txtref_comp" value="<?echo $ced_rif?>"></td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input name="Atras" type="button" id="Atras2" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="96" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar('<? echo $codigo_mov; ?>','<? echo $ref_comp; ?>')"></td>
            <td width="117"><input name="txtced_rif" type="hidden" id="txtced_rif" value="<?echo $ced_rif?>"></td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>