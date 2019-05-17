<? if (!$_GET){  $equipo = getenv("COMPUTERNAME"); $mcod_m = "CON02".$equipo; $codigo_mov=substr($mcod_m,0,49);}  else{  $codigo_mov=$_GET["codigo_mov"];}
include ("../class/conect.php");  include ("../class/funciones.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Incluir Cuentas en el Comprobante)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js"  type=text/javascript></script>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44)){alert('Por Favor Ingrese Solo Numeros '+tecla) };
    patron=/[0-9\,\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function llamar_anterior(){ document.location ='Det_inc_comprobantes.php?codigo_mov=<?echo $codigo_mov?>'; }
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
 return true;}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtCodigo_Cuenta.value==""){alert("Codigo de Cuenta no puede estar Vacio");return false;}
   if(f.txtDeb_Cre.value=="D" || f.txtDeb_Cre.value=="C") {Valido=true;}else{alert("Valor Dedito/Credito no valida");return false; }
   if(f.txtDes_A.value==""){alert("Descripcion de Asiento no puede estar Vacio"); return false; }else{f.txtDes_A.value=f.txtDes_A.value.toUpperCase();}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;} else{alert("monto debe tener valores numericos.");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 { font-size: 16px; font-weight: bold;  color: #FFFFFF;  }
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Insert_cuenta_comp.php" onSubmit="return revisar()">
  <table width="623" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="620" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#003399"><span class="Estilo9">INCLUIR NUEVA CUENTA EN EL COMPROBANTE</span></td>
        </tr>
        <tr>
          <td><table width="614" border="0">
              <tr>
                <td width="330"><span class="Estilo5">C&Oacute;DIGO CUENTA :
                      <input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" title="Registre el C&oacute;digo de la Cuenta"  size="30" maxlength="30" onFocus="encender(this); " onBlur="apagar(this);">
                </span></td>
                <td width="268"><input name="btCatcuentas" type="button" id="btCatcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onclick="VentanaCentrada('Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="..."></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="614" border="0">
              <tr>
                <td width="608"><span class="Estilo5">NOMBRE CUENTA :
                    <input name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" size="74" maxlength="250" readonly>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="614" border="0">
                <tr>
                  <td width="336"><span class="Estilo5">DEBITO/CREDITO :
                        <select name="txtDeb_Cre" size="1" id="select"><option>D</option> <option>C</option>  </select>
                  </span></td>
                  <td width="242"><span class="Estilo5">MONTO :
                        <input name="txtmonto" type="text" id="txtmonto" size="25" style="text-align:right" maxlength="22" onFocus="encender(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event)">
                  </span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td><table width="614" border="0">
              <tr>
                <td width="87"><span class="Estilo5">DESCRIPCI&Oacute;N ASIENTO:</span></td>
                <td width="428"><textarea name="txtDes_A" cols="70" rows="2" class="headers" id="textarea2" onFocus="encender(this)" onBlur="apagar(this)"></textarea></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>
              <p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov2" value="<?echo $codigo_mov?>"></td>
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