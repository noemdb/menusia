<?include ("../class/ventana.php");
$equipo=getenv("COMPUTERNAME");
if (!$_GET){$mcod_m="PRE008".$equipo;$codigo_mov=substr($mcod_m,0,49);}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Incluir Códigos en el Pago)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_pagos.php?codigo_mov=<?echo $codigo_mov?>'; }
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtcod_presup.value==""){alert("Código Presupuestario no puede estar Vacio");return false;}
   if(f.txtcod_fuente.value==""){alert("Código de Fuente no puede estar Vacio"); return false; }
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}
    else{alert("monto debe tener valores numéricos.");return false;}
document.form1.submit;
return true;}
</script>

</head>

<body>
<form name="form1" method="post" action="Insert_cod_pago.php" onSubmit="return revisar()">
  <table width="686" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="683" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR NUEVO CÓDIGO EN EL PAGO </span></td>
        </tr>
        <tr>
          <td><table width="679" border="0">
              <tr>
                <td width="168"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :

                </span></td>
                <td width="217"><span class="Estilo5">
                  <input name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo de la Cuenta"  size="30" maxlength="30" onFocus="encender(this); " onBlur="apagar(this);">
                </span></td>
                <td width="103"><input name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('Cat_codigos_presup.php?criterio=','SIA','','750','500','true')" value="..."></td>
                <td width="59"><input name="txtdes_contable" type="hidden" id="txtdes_contable"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="677" border="0">
            <tr>
              <td width="222"><span class="Estilo5">FUENTE DE FINANCIAMIENTO : </span></td>
              <td width="18"><span class="Estilo10">
                <input name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2" onFocus="encender(this); " onBlur="apagar(this);">
              </span></td>
              <td width="28"><input name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onclick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="..."></td>
              <td width="391"><span class="Estilo10">
                <input name="txtdes_fuente" type="text" id="txtdes_fuente" size="55" readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="674" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N :

                </span></td>
                <td width="494"><span class="Estilo5">
                  <textarea name="txtdenominacion" cols="65" rows="2" readonly="readonly" id="txtdenominacion"></textarea>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><table width="681">
            <tr>
              <td width="121"><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA:</span></td>
              <td width="158"><span class="Estilo5">
                <select name="txttipo_imput_presu" size="1" id="txttipo_imput_presu" onFocus="encender(this)" onBlur="apagar(this)" >
                  <option selected>PRESUPUESTO</option>
                  <option>CRED. ADICIONAL</option>
                </select>
              </span></td>
              <td width="270"><span class="Estilo5">REFERENCIA DEL CREDITO ADICIONAL:</span></td>
              <td width="72"><input name="txtref_imput_presu" type="text"  id="txtref_imput_presu" onFocus="encender(this); " onBlur="apagar(this);" size="12" maxlength="8" value="00000000" onchange="checkimput(this.form);"></td>
              <td width="36"><span class="Estilo5">
                <input name="btref_cred" type="button" id="btref_cred" title="Abrir Catalogo Cr&eacute;ditos Adicional" onClick="VentanaCentrada('Cat_cred_adic.php?criterio=','SIA','','750','500','true')" value="...">
</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="671" border="0">
                <tr>
                  <td width="121"><span class="Estilo5">DISPONIBLE:</span></td>
                  <td width="273"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtdisponible" type="text" id="txtdisponible" size="25" align="right" readonly>
                  </span>
                  </span></td>
                  <td width="79"><span class="Estilo5">MONTO </span>:</td>
                  <td width="180"><span class="Estilo5">
                  <input name="txtmonto" type="text" id="txtmonto" size="25" align="right" maxlength="22" onFocus="encender(this)" onBlur="apagar(this)">
</span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td><table width="670">
            <tr>
              <td width="138"><span class="Estilo5">CODIGO CONTABLE : </span></td>
              <td width="212"><span class="Estilo5">
                <input name="txtcod_contable" type="text" id="txtcod_contable" size="25" maxlength="30" readonly">
              </span></td>
              <td width="121"><span class="Estilo5">MONTO CREDITO </span>:</td>
              <td width="179"><span class="Estilo5">
                <input name="txtmonto_credito" type="text" id="txtmonto_credito" size="25" align="right" maxlength="22" onFocus="encender(this)" onBlur="apagar(this)">
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
            <td width="20"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="131">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="178">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>