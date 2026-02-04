<?include ("../class/ventana.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$mcod_m="PAG001".$equipo;$codigo_mov=substr($mcod_m,0,49);$formato="XX-XX-XX-XXX-XX-XX-XX";}else{$codigo_mov=$_GET["codigo_mov"];$user=$_GET["user"];$password=$_GET["password"];$dbname=$_GET["dbname"]; $formato=$_GET["formato"]; }  $mpatron="Array(2,2,2,2,2,3,2,2,2,2)";  $mpatron=arma_patron($formato); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Incluir Codigos en la Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var patroncodigo = new <?php echo $mpatron ?>;
function SoloNumero(Str){var i; var j;
  for (i = 0; i <= Str.length - 1; i++) {if ((Str.charAt(i) >= '0') && (Str.charAt(i) <= '9') ) {j=i;} else{return false;} }
  return true;}
function quitaformatomonto (monto){var i; var str2 ="";
  for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == ',')){str2 = str2 + ".";} else{if ((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) {str2 = str2 + monto.charAt(i);} } }
  return str2;}
function validarcod(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\-]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
function llamar_anterior(){ document.location ='Det_inc_cod_ord.php?codigo_mov=<?echo $codigo_mov?>&bloqueada=N'; }
function chequea_codpresup(mform){var cod_presup;
  cod_presup=mform.txtcod_presup.value;
  ajaxSenddoc('GET', 'amontcod.php?cod_presup='+cod_presup+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'montcod', 'innerHTML');
return true;}
function apaga_codpresup(mthis){var cod_presup;
 apagar(mthis);
 cod_presup=document.form1.txtcod_presup.value;
 ajaxSenddoc('GET', 'amontcod.php?cod_presup='+cod_presup+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'montcod', 'innerHTML');
}
function llama_codpresup(){var cod_presup;
  cod_presup=document.form1.txtcod_presup.value;
  VentanaCentrada('Cat_codigos_presup.php?criterio='+cod_presup,'SIA','','750','500','true');
}  
function chequea_monto(mform){var mmonto;
   mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
   if(mform.txttipo_imput_presu.value=="CRED. ADICIONAL"){mform.txtmonto_credito.value=mform.txtmonto.value;}
    else{mform.txtmonto_credito.value="0";}
return true;}
function apaga_monto(mthis){var mmonto;  apagar(mthis);
 mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
 if(document.form1.txttipo_imput_presu.value=="CRED. ADICIONAL"){document.form1.txtmonto_credito.value=mmonto;}
  else{document.form1.txtmonto_credito.value="0";}
}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio"); f.txtcod_presup.focus(); return false;}
   if(f.txtcod_fuente.value==""){alert("Codigo de Fuente no puede estar Vacio"); f.txtcod_fuente.focus(); return false; }
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio"); f.txtmonto.focus(); return false;}
   if(f.txtcod_contable.value==""){alert("Codigo Contable no puede estar Vacio"); f.txtcod_contable.focus(); return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}else{alert("monto debe tener valores numericos.");return false;}   
   if(f.txtref_imput_presu.value=="00000000"){ if(f.txttipo_imput_presu.value=="PRESUPUESTO") {Valido=true;} else{alert("Imputacion Preupuestaria Invalida");return false;}  }
     else{ if(f.txttipo_imput_presu.value=="PRESUPUESTO") {alert("Imputacion Preupuestaria Invalida");return false;} }
document.form1.submit;
return true;}
</script>

</head>

<body>
<form name="form1" method="post" action="Insert_cod_ord.php" onSubmit="return revisar()">
  <table width="686" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="683" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="25" align="center" bgcolor="#000066"><span class="Estilo2 Estilo6">INCLUIR NUEVO C&Oacute;DIGO EN LA ORDEN </span></td>
        </tr>
        <tr>
          <td><table width="679" border="0">
              <tr>
                <td width="168"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                <td width="217"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el Codigos Presupuestario"  size="32" maxlength="32" onFocus="encender(this);" onBlur="apaga_codpresup(this);" onchange="chequea_codpresup(this.form);" onkeypress="return validarcod(event,this)" onkeyup="mascara(this,'-',patroncodigo,true)" >  </span></td>
                <td width="103"><input class="Estilo10" name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo Codigos Presupuestarios"  onclick="llama_codpresup()" value="..." onkeypress="return stabular(event,this)"></td>
                <td width="59"><input class="Estilo10" name="txtdes_contable" type="hidden" id="txtdes_contable" onkeypress="return stabular(event,this)"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="677" border="0">
            <tr>
              <td width="222"><span class="Estilo5">FUENTE DE FINANCIAMIENTO : </span></td>
              <td width="18"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)"></span></td>
              <td width="28"><input class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onclick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td>
              <td width="391"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" size="55" readonly onkeypress="return stabular(event,this)">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="674" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="494"><span class="Estilo5"><textarea name="txtdenominacion" cols="65" rows="1" readonly="readonly" id="txtdenominacion" onkeypress="return stabular(event,this)"></textarea></span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><table width="681">
            <tr>
              <td width="178"><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA:</span></td>
              <td width="160"><span class="Estilo5"><select name="txttipo_imput_presu" size="1" id="txttipo_imput_presu" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)">
                  <option selected>PRESUPUESTO</option> <option>CRED. ADICIONAL</option>     </select></span></td>
              <td width="230"><span class="Estilo5">REFERENCIA DEL CREDITO ADICIONAL:</span></td>
              <td width="75"><input class="Estilo10" name="txtref_imput_presu" type="text"  id="txtref_imput_presu" onFocus="encender(this); " onBlur="apagar(this);" size="12" maxlength="8" value="00000000" onchange="checkimput(this.form);" onkeypress="return stabular(event,this)"></td>
              <td width="38"><span class="Estilo5"><input class="Estilo10" name="btref_cred" type="button" id="btref_cred" title="Abrir Catalogo Croditos Adicional" onClick="VentanaCentrada('../presupuesto/Cat_cred_adic.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="671" border="0">
                <tr>
                  <td width="121"><span class="Estilo5">DISPONIBLE:</span></td>
                  <td width="273"><span class="Estilo5"> <input class="Estilo10" name="txtdisponible" type="text" id="txtdisponible" size="25" style="text-align:right" readonly onkeypress="return stabular(event,this)"> </span></td>
                  <td width="79"><span class="Estilo5">MONTO :</span></td>
                  <td width="180"><span class="Estilo5"><div id="montcod"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="25" style="text-align:right" maxlength="22" onFocus="encender(this)" onBlur="apaga_monto(this)"  onchange="chequea_monto(this.form);" onKeypress="return validarNum(event,this)" onkeypress="return stabular(event,this)"></div></span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td><table width="679">
            <tr>
              <td width="135"><span class="Estilo5">CODIGO CONTABLE : </span></td>
              <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtcod_contable" type="text" id="txtcod_contable" size="25" maxlength="30" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)"> </span></td>
              <td width="40"><input class="Estilo10" name="btcatcta" type="button" id="btcatcta" title="Abrir Catalogo de Cuentas" onclick="VentanaCentrada('Cat_cuentasc.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td>
              <td width="130"><span class="Estilo5">MONTO CREDITO :</span></td>
              <td width="168"><span class="Estilo5"><input class="Estilo10" name="txtmonto_credito" type="text" id="txtmonto_credito" size="25" style="text-align:right" maxlength="22" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event,this)" onkeypress="return stabular(event,this)">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>
        </tr>
      </table>
        <table width="653" align="center">
          <tr>
            <td width="20"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="131">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input class="Estilo10" name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input class="Estilo10" name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="96" align="center"><input class="Estilo10" name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="178">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>