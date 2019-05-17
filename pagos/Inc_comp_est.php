<?include ("../class/ventana.php"); if (!$_GET){$cod_estructura='';}else{$cod_estructura=$_GET["cod_estructura"];} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Incluir Codigos en la Estructura)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_asig_comp_est.php?cod_estructura=<?echo $cod_estructura?>'; }
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_compromiso.value;  mref=Rellenarizq(mref,"0",4);  mform.txttipo_compromiso.value=mref;
return true;}
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_comp.value;  mref = Rellenarizq(mref,"0",8);  mform.txtreferencia_comp.value=mref;
return true;}
function revisar(){var f=document.form1;
var Valido=true;
   if(f.txtreferencia_comp.value==""){alert("Referencia no puede estar Vacio");return false;}
   if(f.txtreferencia_comp.value.length==8){f.txtreferencia_comp.value=f.txtreferencia_comp.value.toUpperCase();}
      else{alert("Longitud de Referencia Invalida");return false;}
   if(f.txttipo_compromiso.value==""){alert("Tipo de Compromiso no puede estar Vacio"); return false; }
      else{f.txttipo_compromiso.value=f.txttipo_compromiso.value.toUpperCase();}
   if(f.txttipo_compromiso.value.length==4){f.txttipo_compromiso.value=f.txttipo_compromiso.value.toUpperCase();}
      else{alert("Longitud de Tipo Invalida");return false;}
  
document.form1.submit;
return true;}
</script>

</head>

<body>
<form name="form1" method="post" action="Insert_asig_est.php" onSubmit="return revisar()">
  <table width="634" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="628" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo2 Estilo6">INCLUIR NUEVO CODIGO EN LA ESTRUCTURA</span></td>
        </tr>
		<tr>
          <td><p>&nbsp;</p>              </td>
        </tr>
		<tr>
          <td><table width="620">
            <tr>
              <td width="187"><span class="Estilo5">CEDULA:</span></td>
              <td width="96"><input class="Estilo10" name="txtcedula" type="text"  id="txtcedula" size="10" maxlength="10" onFocus="encender(this);" onBlur="apagar(this)"  ></td>
              <td width="130"><span class="Estilo5"></span></td>
              <td width="187"></td>
            </tr>
          </table></td>
        </tr>
		<tr>
          <td><p>&nbsp;</p>              </td>
        </tr>
        <tr>
          <td><table width="620">
            <tr>
              <td width="187"><span class="Estilo5">DOCUMENTO COMPROMISO:</span></td>
              <td width="82"><input class="Estilo10" name="txttipo_compromiso" type="text"  id="txttipo_compromiso" size="6" maxlength="4" onFocus="encender(this);" onBlur="apagar(this)" value="0013" onchange="chequea_tipo(this.form);"></td>
              <td width="144"><span class="Estilo5">REFERENCIA :</span></td>
              <td width="187"><input class="Estilo10" name="txtreferencia_comp" type="text" id="txtreferencia_comp" size="12" maxlength="8"  onFocus="encender(this);" onBlur="apaga_doc(this)" value="00000000" onchange="checkreferencia(this.form);"></td>
            </tr>
          </table></td>
        </tr>
        <tr><td><p>&nbsp;</p> </td></tr>
		<tr><td><p>&nbsp;</p> </td></tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input class="Estilo10" name="txtcod_estructura" type="hidden" id="txtcod_estructura" value="<?echo $cod_estructura?>"></td>
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