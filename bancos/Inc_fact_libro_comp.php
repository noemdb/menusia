<?php include ("../class/ventana.php");?>
<?php include ("../class/fun_numeros.php");?>
<?php include ("../class/fun_fechas.php");
if (!$_GET){$codigo_mov="";$ivag=0;$orden="";}
else{$codigo_mov=$_GET["codigo_mov"];$user=$_GET["user"];$password=$_GET["password"];$dbname=$_GET["dbname"];$ivag=$_GET["ivag"];}
$tasa_iva=formato_monto($ivag);$fecha_hoy=asigna_fecha_hoy(); $retenc=75; $retenc=formato_monto($retenc); $nro_planilla="01-REG";
$monto=0;$montob=0; $montoi=0; $montos=0; $montor=0; $tasa=0; $monto1=0; $monto2=0; $tipo_en=""; $tipo_documento="01"; $nro_documento=""; $nro_con_factura=""; $fecha=$fecha_hoy; $nro_doc_afectado=""; $tipo_operacion=""; $nro_ncr=""; $nro_ndb=""; $nro_fact="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Incluir Documento Libro de Compra)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../class/sia.js" type=text/javascript></script>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
unction validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function apagar_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=mthis.value;  mmonto=camb_punto_coma(mmonto); mthis.value=mmonto;
 return true;}
function daformatomonto(monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i)=='.')){str2 = str2 + ",";} else{if ((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function llamar_anterior(){document.location ='Det_inc_libro_comp.php?codigo_mov=<?php echo $codigo_mov?>&agregar=S';}
function chequea_monto(mform){
var mmonto; var miva;  var mret;
   mmonto=quitaformatomonto(mform.txtmontob.value);  miva=quitaformatomonto(mform.txttasa.value);  mret=quitaformatomonto(mform.txtretenc.value);
   mmonto=(mmonto*1);miva=(miva*1);mret=(mret*1);  miva=(mmonto*(miva/100)); mret=(miva*(mret/100));  miva=Math.round(miva*100)/100;   mret=Math.round(mret*100)/100;
   mform.txtmontoi.value=miva;  mform.txtmontoi.value=daformatomonto(mform.txtmontoi.value);
   mform.txtmontor.value=mret;  mform.txtmontor.value=daformatomonto(mform.txtmontor.value);
return true;}
function apaga_monto(mthis){
var mmonto; var miva;  var mret;
 apagar(mthis);
 mmonto=mthis.value;
}
function chequea_tasa(mform){
var mmonto; var miva;  var mret;
   mmonto=quitaformatomonto(mform.txtmontob.value);  miva=quitaformatomonto(mform.txttasa.value);    mret=quitaformatomonto(mform.txtretenc.value);
   mmonto=(mmonto*1);miva=(miva*1);mret=(mret*1);  miva=(mmonto*(miva/100)); mret=(miva*(mret/100)); miva=Math.round(miva*100)/100;   mret=Math.round(mret*100)/100;
   mform.txtmontoi.value=miva;  mform.txtmontoi.value=daformatomonto(mform.txtmontoi.value);
   mform.txtmontor.value=mret;  mform.txtmontor.value=daformatomonto(mform.txtmontor.value);
return true;}
function chequea_monto_iva(mform){
var mmonto; var miva;  var mret;
   mmonto=quitaformatomonto(mform.txtmontoi.value);  miva=quitaformatomonto(mform.txttasa.value);    mret=quitaformatomonto(mform.txtretenc.value);
   mmonto=(mmonto*1);miva=(miva*1);mret=(mret*1);  miva=(mmonto*(mret/100)); miva=Math.round(miva*100)/100;   mret=Math.round(mret*100)/100;
   mform.txtmontoi.value=miva;  mform.txtmontoi.value=daformatomonto(mform.txtmontoi.value);
return true;}
function chequea_retenc(mform){
var mmonto; var miva;  var mret;
   mmonto=quitaformatomonto(mform.txtmontob.value);  miva=quitaformatomonto(mform.txtmontoi.value);    mret=quitaformatomonto(mform.txtretenc.value);
   mmonto=(mmonto*1);miva=(miva*1);mret=(mret*1);  mret=(miva*(mret/100)); miva=Math.round(miva*100)/100;   mret=Math.round(mret*100)/100;
   mform.txtmontor.value=mret;  mform.txtmontor.value=daformatomonto(mform.txtmontor.value);
return true;}
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtced_rif.value==""){alert("C�dula/Rif no puede estar Vacio"); return false; }
   if(f.txtmonto.value==""){alert("Total Factura no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;} else{alert("Total Factura debe tener valores num�ricos.");return false;}
   if(f.txtmontob.value==""){alert("Base Imponible no puede estar Vacio");return false;}
   if(MontoValido(f.txtmontob.value)) {Valido=true;} else{alert("Base Imponible debe tener valores num�ricos.");return false;}
   if(f.txtmontor.value==""){alert("Monto Retenci�n no puede estar Vacio");return false;}
   if(MontoValido(f.txtmontor.value)) {Valido=true;} else{alert("Monto Retenci�n  debe tener valores num�ricos.");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 { font-size: 16px;font-weight: bold; color: #FFFFFF; }
.Estilo10 {font-size: 10px}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="Insert_fact_libro_comp.php" onSubmit="return revisar()">
  <table width="745" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="741" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR DOCUMENTO LIBRO DE COMPRA</span></td>
        </tr>
        <tr>
          <td><table width="737" >
            <tr>
              <td width="100"><span class="Estilo5">C�DULA/RIF :</span></td>
              <td width="87"><span class="Estilo5"><input name="txtced_rif" type="text" id="txtced_rif" size="12" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
              <td width="51"><span class="Estilo5"><input name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../presupuesto/Cat_beneficiarios.php?criterio=','SIPAP','','750','500','true')" value="..." > </span></td>
              <td width="479"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" size="70" readonly> </span></td>
            </tr>
          </table></td>
                </tr>
        <tr>
          <td><table width="729" >
            <tr>
              <td width="103"><span class="Estilo5">DOCUMENTO :</span></td>
              <td width="201"><span class="Estilo5"><input name="txtdocumento" type="text" id="txtdocumento" size="4" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" value="<?php  echo $tipo_documento ?>"> </span></td>
              <td width="220"><span class="Estilo5">FECHA DOCUMENTO:</span></td>
              <td width="185"><span class="Estilo5"><input name="txtfecha_doc" type="text" id="txtfecha_doc" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?php  echo $fecha ?>"></span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="737">
            <tr>
              <td width="142"><span class="Estilo5">N&Uacute;MERO FACTURA :</span></td>
              <td width="175"><span class="Estilo5"><input name="txtnro_factura" type="text" id="txtnro_factura"  onFocus="encender(this)" onBlur="apagar(this)"  size="20" value="<?php  echo $nro_fact ?>"> </span></td>
              <td width="185"><span class="Estilo5">N&Uacute;MERO DE CONTROL: </span></td>
              <td width="215"><span class="Estilo5"><input name="txtnro_con_factura" type="text" id="txtnro_con_factura" size="20" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php  echo $nro_con_factura ?>"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="733" border="0">
            <tr>
              <td width="142"><span class="Estilo5">NRO. NOTA CREDITO </span>:</td>
              <td width="121"><span class="Estilo5"><input name="txtnro_nota_c" type="text" id="txtnro_nota_c" size="12" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)" value="<?php  echo $nro_ncr ?>">
              </span></td>
              <td width="134"><span class="Estilo5">NRO. NOTA DEBITO </span>:</td>
              <td width="119"><span class="Estilo5"><input name="txtnro_nota_d" type="text" id="txtnro_nota_d" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)" value="<?php  echo $nro_ndb ?>">
              </span></td>
              <td width="128"><span class="Estilo5">TIPO TRANSACCI&Oacute;N :</span></td>
              <td width="63"><span class="Estilo5"><input name="txttipo_trans" type="text" id="txttipo_trans" size="7" maxlength="7" onFocus="encender(this)" onBlur="apagar(this)" value="<?php  echo $nro_planilla ?>">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="733" border="0">
              <tr>
                <td width="188"><span class="Estilo5">NRO. FACTURA AFECTADA  :</span></td>
                <td width="192"><span class="Estilo5"><input name="txtnro_doc_afectado" type="text" id="txtnro_doc_afectado"  value="<?php  echo $nro_doc_afectado ?>"  size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
                <td width="140"><span class="Estilo5">TOTAL COMPRAS :</span></td>
                <td width="195"><span class="Estilo5"><input name="txtmonto" type="text" id="txtmonto"  size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar_monto(this)" value="<?php  echo $monto ?>"> </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="737" border="0">
            <tr>
              <td width="188"><span class="Estilo5">COMPRAS S/DERECHO  :</span></td>
              <td width="193"> <span class="Estilo5"><input name="txtmontos" type="text" id="txtmontos" size="20" maxlength="20" align="right" onFocus="encender(this)" onBlur="apagar_monto(this)"  value="<?php  echo $montos ?>">  </span> </td>
               <td width="137"><span class="Estilo5">BASE IMPONIBLE :  </span></td>
              <td width="201"><span class="Estilo5"><input name="txtmontob" type="text" id="txtmontob" size="20" maxlength="20" align="right" onFocus="encender(this)"  onBlur="apaga_monto(this)"  onchange="chequea_monto(this.form);"  value="<?php  echo $montob ?>">  </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="739" >
            <tr>
              <td width="188"><span class="Estilo5">PORCENTAJE (%) ALICUOTA: </span></td>
              <td width="192"><span class="Estilo5"><input name="txttasa" type="text" id="txttasa" size="8" maxlength="8"  align="right" onFocus="encender(this)" onBlur="apagar_monto(this)" onchange="chequea_tasa(this.form);" value="<?php  echo $tasa_iva ?>"> </span></td>
              <td width="138"><span class="Estilo5">MONTO IVA: </span></td>
              <td width="201"><span class="Estilo5"><input name="txtmontoi" type="text" id="txtmontoi" size="20" maxlength="20" align="right" onFocus="encender(this)" onBlur="apagar_monto(this)" value="<?php  echo $montoi ?>"></span></td>
              </tr>
          </table> </td>
        </tr>
        <tr>
          <td><table width="739" >
            <tr>
              <td width="187"><span class="Estilo5">PORCENTAJE (%) RETENCI&Oacute;N: </span></td>
              <td width="190"><span class="Estilo5"><input name="txtretenc" type="text" id="txtretenc" size="10" maxlength="10"  align="right" onFocus="encender(this)" onBlur="apagar_monto(this)" onchange="chequea_retenc(this.form);" value="<?php  echo $retenc ?>"> </span></td>
              <td width="139"><span class="Estilo5"> IVA RETENIDO : </span></td>
             <td width="203"><span class="Estilo5"><input name="txtmontor" type="text" id="txtmontor" size="15" maxlength="15" align="right" onFocus="encender(this)" onBlur="apagar_monto(this)"  value="<?php  echo $montor ?>"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td><p>&nbsp;</p></td></tr>
      </table>
        <table width="699" align="center">
          <tr>
            <td width="10"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="100"><input name="txttipo_operacion" type="hidden" id="txttipo_operacion" value="<?php echo $tipo_operacion?>"></td>
            <td width="120"><input name="txtnro_orden" type="hidden" id="txtnro_orden" value="0"></td>
            <td width="120" align="center"><input name="Incluir" type="submit" id="Incluir" value="Incluir"></td>
            <td width="120" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="230">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>