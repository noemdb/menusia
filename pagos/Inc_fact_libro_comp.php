<?include ("../class/ventana.php");include ("../class/fun_numeros.php");include ("../class/fun_fechas.php");
if (!$_GET){$codigo_mov="";$ivag=0;$orden="";$tipo_planilla="";}
else{$codigo_mov=$_GET["codigo_mov"];$user=$_GET["user"];$password=$_GET["password"];$dbname=$_GET["dbname"];$ivag=$_GET["ivag"];  $orden=$_GET["nro_l"]; $tipo_planilla=$_GET["mes"]; }
$tasa_iva=formato_monto($ivag);$fecha_hoy=asigna_fecha_hoy(); $retenc=75; $retenc=formato_monto($retenc); $nro_planilla="01-REG";
$monto=0;$montob=0; $montoi=0; $montos=0; $montor=0; $tasa=0; $monto1=0; $monto2=0; $tipo_en=""; $tipo_documento="01"; $nro_documento=""; $nro_con_factura=""; $fecha=$fecha_hoy; $nro_doc_afectado=""; $tipo_operacion=""; $nro_ncr=""; $nro_ndb=""; $nro_fact="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Incluir Documento Libro de Compra)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../class/sia.js" type=text/javascript></script>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function daformatomonto(monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i)=='.')){str2 = str2 + ",";} else{if ((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function llamar_anterior(){document.location ='Det_inc_libro_comp.php?codigo_mov=<?echo $codigo_mov?>&agregar=S';}
function chequea_monto(mform){var mmonto; var miva;  var mret;
   mmonto=quitaformatomonto(mform.txtmontob.value);  miva=quitaformatomonto(mform.txttasa.value);  mret=quitaformatomonto(mform.txtretenc.value);
   mmonto=(mmonto*1);miva=(miva*1);mret=(mret*1);  miva=(mmonto*(miva/100)); mret=(miva*(mret/100));  miva=Math.round(miva*100)/100;   mret=Math.round(mret*100)/100;
   mform.txtmontoi.value=miva;  mform.txtmontoi.value=daformatomonto(mform.txtmontoi.value);
   mform.txtmontor.value=mret;  mform.txtmontor.value=daformatomonto(mform.txtmontor.value);
return true;}
function apaga_monto(mthis){var mmonto; var miva;  var mret;
 apagar(mthis); mmonto=mthis.value;
}
function chequea_tasa(mform){var mmonto; var miva;  var mret;
   mmonto=quitaformatomonto(mform.txtmontob.value);  miva=quitaformatomonto(mform.txttasa.value);    mret=quitaformatomonto(mform.txtretenc.value);
   mmonto=(mmonto*1);miva=(miva*1);mret=(mret*1);  miva=(mmonto*(miva/100)); mret=(miva*(mret/100)); miva=Math.round(miva*100)/100;   mret=Math.round(mret*100)/100;
   mform.txtmontoi.value=miva;  mform.txtmontoi.value=daformatomonto(mform.txtmontoi.value);
   mform.txtmontor.value=mret;  mform.txtmontor.value=daformatomonto(mform.txtmontor.value);
return true;}
function chequea_monto_iva(mform){var mmonto; var miva;  var mret;
   mmonto=quitaformatomonto(mform.txtmontoi.value);  miva=quitaformatomonto(mform.txttasa.value);    mret=quitaformatomonto(mform.txtretenc.value);
   mmonto=(mmonto*1);miva=(miva*1);mret=(mret*1);  miva=(mmonto*(mret/100)); miva=Math.round(miva*100)/100;   mret=Math.round(mret*100)/100;
   mform.txtmontoi.value=miva;  mform.txtmontoi.value=daformatomonto(mform.txtmontoi.value);
return true;}
function chequea_retenc(mform){var mmonto; var miva;  var mret;
   mmonto=quitaformatomonto(mform.txtmontob.value);  miva=quitaformatomonto(mform.txtmontoi.value);    mret=quitaformatomonto(mform.txtretenc.value);
   mmonto=(mmonto*1);miva=(miva*1);mret=(mret*1);  mret=(miva*(mret/100)); miva=Math.round(miva*100)/100;   mret=Math.round(mret*100)/100;
   mform.txtmontor.value=mret;  mform.txtmontor.value=daformatomonto(mform.txtmontor.value);
return true;}
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtced_rif.value==""){alert("Cédula/Rif no puede estar Vacio"); return false; }
   if(f.txtmonto.value==""){alert("Total Factura no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;} else{alert("Total Factura debe tener valores numéricos.");return false;}
   if(f.txtmontob.value==""){alert("Base Imponible no puede estar Vacio");return false;}
   if(MontoValido(f.txtmontob.value)) {Valido=true;} else{alert("Base Imponible debe tener valores numéricos.");return false;}
   if(f.txtmontor.value==""){alert("Monto Retención no puede estar Vacio");return false;}
   if(MontoValido(f.txtmontor.value)) {Valido=true;} else{alert("Monto Retención  debe tener valores numéricos.");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 { font-size: 16px;font-weight: bold; color: #FFFFFF; }
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
              <td width="100"><span class="Estilo5">CEDULA/RIF :</span></td>
              <td width="87"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="12" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
              <td width="51"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../presupuesto/Cat_beneficiarios.php?criterio=','SIA','','750','500','true')" value="..." > </span></td>
              <td width="479"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="70" readonly> </span></td>
            </tr>
          </table></td>
                </tr>
        <tr>
          <td><table width="729" >
            <tr>
              <td width="103"><span class="Estilo5">DOCUMENTO :</span></td>
              <td width="201"><span class="Estilo5"><input class="Estilo10" name="txtdocumento" type="text" id="txtdocumento" size="4" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $tipo_documento ?>"> </span></td>
              <td width="220"><span class="Estilo5">FECHA DOCUMENTO:</span></td>
              <td width="185"><span class="Estilo5"><input class="Estilo10" name="txtfecha_doc" type="text" id="txtfecha_doc" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $fecha ?>"></span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="737">
            <tr>
              <td width="142"><span class="Estilo5">N&Uacute;MERO FACTURA :</span></td>
              <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtnro_factura" type="text" id="txtnro_factura"  onFocus="encender(this)" onBlur="apagar(this)"  size="20" value="<? echo $nro_fact ?>"> </span></td>
              <td width="185"><span class="Estilo5">N&Uacute;MERO DE CONTROL: </span></td>
              <td width="215"><span class="Estilo5"><input class="Estilo10" name="txtnro_con_factura" type="text" id="txtnro_con_factura" size="20" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $nro_con_factura ?>"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="733" border="0">
            <tr>
              <td width="142"><span class="Estilo5">NRO. NOTA CREDITO </span>:</td>
              <td width="121"><span class="Estilo5"><input class="Estilo10" name="txtnro_nota_c" type="text" id="txtnro_nota_c" size="12" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $nro_ncr ?>">   </span></td>
              <td width="134"><span class="Estilo5">NRO. NOTA DEBITO </span>:</td>
              <td width="119"><span class="Estilo5"><input class="Estilo10" name="txtnro_nota_d" type="text" id="txtnro_nota_d" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $nro_ndb ?>">   </span></td>
              <td width="128"><span class="Estilo5">TIPO TRANSACCI&Oacute;N :</span></td>
              <td width="63"><span class="Estilo5"><input class="Estilo10" name="txttipo_trans" type="text" id="txttipo_trans" size="7" maxlength="7" onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $nro_planilla ?>">   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="733" border="0">
              <tr>
                <td width="188"><span class="Estilo5">NRO. FACTURA AFECTADA  :</span></td>
                <td width="192"><span class="Estilo5"><input class="Estilo10" name="txtnro_doc_afectado" type="text" id="txtnro_doc_afectado"  value="<? echo $nro_doc_afectado ?>"  size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
                <td width="140"><span class="Estilo5">TOTAL COMPRAS :</span></td>
                <td width="195"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto"  size="15" maxlength="15"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apagar(this)" value="<? echo $monto ?>" onKeypress="return validarNum(event)"> </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="737" border="0">
            <tr>
              <td width="188"><span class="Estilo5">COMPRAS S/DERECHO  :</span></td>
              <td width="193"> <span class="Estilo5"><input class="Estilo10" name="txtmontos" type="text" id="txtmontos" size="20" maxlength="20" style="text-align:right" onFocus="encender_monto(this)" onBlur="apagar(this)"  value="<? echo $montos ?>" onKeypress="return validarNum(event)">  </span> </td>
               <td width="137"><span class="Estilo5">BASE IMPONIBLE :  </span></td>
              <td width="201"><span class="Estilo5"><input class="Estilo10" name="txtmontob" type="text" id="txtmontob" size="20" maxlength="20" style="text-align:right" onFocus="encender_monto(this)"  onBlur="apaga_monto(this)"  onchange="chequea_monto(this.form);"  value="<? echo $montob ?>" onKeypress="return validarNum(event)">  </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="739" >
            <tr>
              <td width="188"><span class="Estilo5">PORCENTAJE (%) ALICUOTA: </span></td>
              <td width="192"><span class="Estilo5"><input class="Estilo10" name="txttasa" type="text" id="txttasa" size="8" maxlength="8"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apagar(this)" onchange="chequea_tasa(this.form);" value="<? echo $tasa_iva ?>" onKeypress="return validarNum(event)"> </span></td>
              <td width="138"><span class="Estilo5">MONTO IVA: </span></td>
              <td width="201"><span class="Estilo5"><input class="Estilo10" name="txtmontoi" type="text" id="txtmontoi" size="20" maxlength="20" style="text-align:right" onFocus="encender_monto(this)" onBlur="apagar(this)" value="<? echo $montoi ?>" onKeypress="return validarNum(event)"></span></td>
              </tr>
          </table> </td>
        </tr>
        <tr>
          <td><table width="739" >
            <tr>
              <td width="187"><span class="Estilo5">PORCENTAJE (%) RETENCI&Oacute;N: </span></td>
              <td width="190"><span class="Estilo5"><input class="Estilo10" name="txtretenc" type="text" id="txtretenc" size="10" maxlength="10"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apagar(this)" onchange="chequea_retenc(this.form);" value="<? echo $retenc ?>" onKeypress="return validarNum(event)"> </span></td>
              <td width="139"><span class="Estilo5"> IVA RETENIDO : </span></td>
             <td width="203"><span class="Estilo5"><input class="Estilo10" name="txtmontor" type="text" id="txtmontor" size="15" maxlength="15" style="text-align:right" onFocus="encender_monto(this)" onBlur="apagar(this)"  value="<? echo $montor ?>" onKeypress="return validarNum(event)"> </span></td>
            </tr>
          </table></td>
        </tr>
		<tr>
            <td><table width="739" >
                <tr>
                  <td width="89"><span class="Estilo5">CONCEPTO:</span></td>
                  <td width="650"><span class="Estilo5"> <input class="Estilo10" name="txttipo_en" type="text" id="txttipo_en" value="<?echo $tipo_en?>" onFocus="encender(this)" onBlur="apagar(this)" maxlength="100" size="110">
                  </span></td>
                </tr>
            </table></td>
        </tr>
        <tr> <td><p>&nbsp;</p></td></tr>
      </table>
        <table width="699" align="center">
          <tr>
            <td width="10"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100"><input name="txttipo_operacion" type="hidden" id="txttipo_operacion" value="<?echo $tipo_operacion?>"></td>
            <td width="60"><input name="txtnro_orden" type="hidden" id="txtnro_orden" value="<?echo $orden?>"></td>  
			<td width="60"><input name="txttipo_planilla" type="hidden" id="txttipo_planilla" value="<?echo $tipo_planilla?>"></td>
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