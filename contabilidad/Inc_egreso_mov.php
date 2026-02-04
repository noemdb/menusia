<? include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){  $equipo = getenv("COMPUTERNAME"); $mcod_m = "CON02".$equipo; $codigo_mov=substr($mcod_m,0,49);}  else{  $codigo_mov=$_GET["codigo_mov"];}
$Gtipo_pago="0005";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Incluir Cuentas en el Comprobante)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../class/sia.js"  type=text/javascript></SCRIPT>
<script language="javascript" src="ajax_comp.js" type="text/javascript"></script>

<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function llamar_anterior(){ document.location ='Det_inc_mov_comp.php?codigo_mov=<?echo $codigo_mov?>'; }
function apaga_referencia(mthis){var mref;
   apagar(mthis); mref=document.form1.txtreferencia_pago.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtreferencia_pago.value=mref;
return true;}
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_pago.value;   mref = Rellenarizq(mref,"0",8);   mform.txtreferencia_pago.value=mref;
return true;}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
 return true;}
function revisar(){var f=document.form1; var Valido=true; 
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio");return false;}
   if(f.txtcod_fuente.value==""){alert("Codigo de Fuente no puede estar Vacio"); return false; }   
   if(f.txtreferencia_pago.value==""){alert("Referencia no puede estar Vacio");return false;}
   if(f.txtreferencia_pago.value=="00000000"){alert("Referencia no puede Valida");return false;}
   if(f.txtDes_A.value==""){alert("Descripcion de Asiento no puede estar Vacio"); return false; } else{f.txtDes_A.value=f.txtDes_A.value.toUpperCase();}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}else{alert("monto debe tener valores numericos.");return false;}   
 document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 { font-size: 16px; font-weight: bold;  color: #FFFFFF;  }
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Insert_presup_mov.php" onSubmit="return revisar()">
  <table width="623" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="620" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#003399"><span class="Estilo9">INCLUIR NUEVO MOVIMIENTO DE EGRESO</span></td>
        </tr>
        <tr>
          <td><table width="614" border="0">
              <tr>
			    <td width="168"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                <td width="217"><span class="Estilo5"><input name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo de la Cuenta"  size="30" maxlength="30" onFocus="encender(this);" onBlur="apagar(this);" onchange="chequea_codpresup(this.form);"> </span></td>
                <td width="103"><input name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo Codigos Presupuestarios"  onclick="VentanaCentrada('Cat_codigos_presup.php?criterio=','SIA','','750','500','true')" value="..."></td>
                <td width="59"><input name="txtdes_contable" type="hidden" id="txtdes_contable"></td>
              </tr>
          </table></td>
        </tr>
		<tr>
          <td><table width="614" border="0">
            <tr>
              <td width="224"><span class="Estilo5">FUENTE FINANCIAMIENTO : </span></td>
              <td width="40"><span class="Estilo5"><input name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2" onFocus="encender(this); " onBlur="apagar(this);">  </span></td>
              <td width="70"><input name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onclick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="..."></td>
              <td width="270"><span class="Estilo5"><input name="txtdes_fuente" type="text" id="txtdes_fuente" size="50" readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="614" border="0">
              <tr>
                <td width="608"><span class="Estilo5">DENOMINACION :
                    <input name="txtdenominacion" type="text" id="txtdenominacion" size="74" maxlength="250" readonly>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="614" border="0">
                <tr>
				  <td width="100"><span class="Estilo5">REFERENCIA : </span></td>
                  <td width="100"><span class="Estilo5"><div id="refpago"><input name="txtreferencia_pago" type="text"  id="txtreferencia_pago"   size="10" maxlength="8" onFocus="encender(this)" onBlur="apaga_referencia(this)"> </div> </span></td>
                  <td width="100"><span class="Estilo5">DISPONIBLE:</span></td>
                  <td width="174"><span class="Estilo5"><input name="txtdisponible" type="text" id="txtdisponible" size="16" align="right" readonly>  </span></td>
                  <td width="70"><span class="Estilo5">MONTO :</span></td>
                  <td width="170"><span class="Estilo5"><div id="montcod"><input name="txtmonto" type="text" id="txtmonto" size="16" align="right" maxlength="22" onFocus="encender(this)" onBlur="apaga_monto(this)"  onchange="chequea_monto(this.form);">                  </div></span></td>
                </tr>
            </table></td>
        </tr>
		<script language="JavaScript" type="text/JavaScript"> mref="<?echo $Gtipo_pago?>";
			ajaxSenddoc('GET', 'cargarefpag.php?tipo_pago='+mref+'&nro_aut=N&password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&codigo_mov='+mcodigo_mov, 'refpago', 'innerHTML');   </script></td>
        <tr>
          <td><table width="614" border="0">
              <tr>
                <td width="100"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                <td width="428"><textarea name="txtDes_A" cols="60" rows="2" class="headers" id="txtDes_A" onFocus="encender(this)" onBlur="apagar(this)"></textarea></td>
              </tr>
          </table></td>
        </tr>
		<tr>
          <td><table width="614" border="0">
              <tr>
                <td width="100"><span class="Estilo5">DEBITO/CREDITO :</span></td>
                <td width="428"><select name="txtDeb_Cre" size="1" id="select"><option>D</option> <option>C</option>  </select></td>
              </tr>
          </table></td>
        </tr>		    
        <tr>
          <td><p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="7"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="5"><input name="txtcod_contable" type="hidden" id="txtcod_contable" value=""></td>
			<td width="5"><input name="txttipo_pago" type="hidden" id="txttipo_pago" value="<?echo $Gtipo_pago?>"></td>
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>