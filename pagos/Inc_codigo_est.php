<?include ("../class/ventana.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$mcod_m="PAG006".$equipo;$codigo_mov=substr($mcod_m,0,49);}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Incluir Codigos en la Estructura)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function llamar_anterior(){ document.location ='Det_inc_cod_est.php?codigo_mov=<?echo $codigo_mov?>'; }
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_compromiso.value;   mref=Rellenarizq(mref,"0",4);   mform.txttipo_compromiso.value=mref;
return true;}
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_comp.value;   mref = Rellenarizq(mref,"0",8);   mform.txtreferencia_comp.value=mref;
return true;}

function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto); document.form1.txtmonto.value=mmonto;
return true;}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtreferencia_comp.value==""){alert("Referencia no puede estar Vacio");return false;}
   if(f.txtreferencia_comp.value.length==8){f.txtreferencia_comp.value=f.txtreferencia_comp.value.toUpperCase();}
      else{alert("Longitud de Referencia Invalida");return false;}
   if(f.txttipo_compromiso.value==""){alert("Tipo de Compromiso no puede estar Vacio"); return false; }
      else{f.txttipo_compromiso.value=f.txttipo_compromiso.value.toUpperCase();}
   if(f.txttipo_compromiso.value.length==4){f.txttipo_compromiso.value=f.txttipo_compromiso.value.toUpperCase();}
      else{alert("Longitud de Tipo Invalida");return false;}
   if(f.txtcod_presup.value==""){alert("Código Presupuestario no puede estar Vacio");return false;}
   if(f.txtcod_fuente.value==""){alert("Código de Fuente no puede estar Vacio"); return false; }
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;} else{alert("monto debe tener valores numéricos.");return false;}
document.form1.submit;
return true;}
</script>

</head>

<body>
<form name="form1" method="post" action="Insert_cod_est.php" onSubmit="return revisar()">
  <table width="634" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="628" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo2 Estilo6">INCLUIR NUEVO CODIGO EN LA ESTRUCTURA</span></td>
        </tr>
        <tr>
          <td><table width="620">
            <tr>
              <td width="187"><span class="Estilo5">DOCUMENTO COMPROMISO:</span></td>
              <td width="82"><input class="Estilo10" name="txttipo_compromiso" type="text"  id="txttipo_compromiso" size="6" maxlength="4" onFocus="encender(this);" onBlur="apagar(this)"  onchange="chequea_tipo(this.form);"></td>
              <td width="144"><span class="Estilo5">REFERENCIA :</span></td>
              <td width="187"><input class="Estilo10" name="txtreferencia_comp" type="text" id="txtreferencia_comp" size="12" maxlength="8"  onFocus="encender(this);" onBlur="apagar(this)"  onchange="checkreferencia(this.form);"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="620" border="0">
              <tr>
                <td width="168"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                <td width="217"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo de la Cuenta"  size="30" maxlength="30" onFocus="encender(this); " onBlur="apagar(this);"> </span></td>
                <td width="103"><input class="Estilo10" name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('Cat_codigos_presup.php?criterio=','SIA','','750','500','true')" value="..."></td>
                <td width="51"><input class="Estilo10" name="txtcod_contable" type="hidden" id="txtcod_contable"></td>
                <td width="59"><input class="Estilo10" name="txtdes_contable" type="hidden" id="txtdes_contable"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="623" border="0">
            <tr>
              <td width="215"><span class="Estilo5">FUENTE DE FINANCIAMIENTO : </span></td>
              <td width="22"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2" onFocus="encender(this); " onBlur="apagar(this);">  </span></td>
              <td width="28"><input class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onclick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="..."></td>
              <td width="340"><span class="Estilo5"> <input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" size="50" readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>
            <table width="621" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="494"><span class="Estilo5"><textarea name="txtdenominacion" cols="58" rows="1" readonly="readonly" id="txtdenominacion"></textarea>
                </span></td>
              </tr>
            </table>   
		  </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="620" border="0">
                <tr>
                  <td width="109"><span class="Estilo5">DISPONIBLE:</span></td>
                  <td width="190"><span class="Estilo5"><input class="Estilo10" name="txtdisponible" type="text" id="txtdisponible" size="25" style="text-align:right" readonly>  </span></td>
                  <td width="109"><span class="Estilo5">MONTO : </span></td>
                  <td width="180"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="25" style="text-align:right" maxlength="22" onFocus="encender(this)" onBlur="apaga_monto(this)"  onKeypress="return validarNum(event)">
                  </span></td>
                </tr>
            </table></td>
        </tr>
		<tr>
          <td><table width="681">
            <tr>
              <td width="180"><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA:</span></td>
              <td width="130"><span class="Estilo5"> <select name="txttipo_imput_presu" size="1" id="txttipo_imput_presu" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                  <option selected>PRESUPUESTO</option> <option>CRED. ADICIONAL</option>  </select>  </span></td>
              <td width="180"><span class="Estilo5">REFERENCIA DEL CREDITO ADICIONAL:</span></td>
              <td width="74"><input class="Estilo10" name="txtref_imput_presu" type="text"  id="txtref_imput_presu" onFocus="encender(this); " onBlur="apagar(this);" size="12" maxlength="8" value="00000000" class="Estilo5"></td>
              <td width="36"><span class="Estilo5"><input class="Estilo10" name="btref_cred" type="button" id="btref_cred" class="Estilo5" title="Abrir Catalogo Cr&eacute;ditos Adicional" onClick="VentanaCentrada('../presupuesto/Cat_cred_adic.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p> </td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>