<?php include ("../class/fun_fechas.php"); if (!$_GET){ $referencia_dife='';$tipo_diferido='';  } else {$referencia_dife = $_GET["txtreferencia_dife"]; $tipo_diferido = $_GET["txttipo_diferido"];}
  $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Anular Diferidos)</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript">
</script>
<script language="JavaScript" type="text/JavaScript">
function checkrefecha(mform){var mref;var mfec;
  mref=mform.txtfecha_anu.value;
  if(mform.txtfecha_anu.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_anu.value=mfec;}
return true;}
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtfecha_anu.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtdescrip_anu.value==""){alert("Descripción de Anulación no puede estar Vacia"); return false; }  else{f.txtdescrip_anu.value=f.txtdescrip_anu.value.toUpperCase();}
    if(f.txtfecha_anu.value.length==10){Valido=true;}    else{alert("Longitud de Fecha Invalida");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold;  color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Anu_diferido.php" onSubmit="return revisar()">
  <table width="714" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="707" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">ANULAR EL DIFERIDO </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="680" border="0" align="center">
              <tr>
                <td width="160"><span class="Estilo5">FECHA DE ANULACI&Oacute;N: </span></td>
                <td width="270"><span class="Estilo5"><span class="Estilo10"><input name="txtfecha_anu" type="text" id="txtfecha_anu" size="15" value="<?echo $fecha_hoy?>"  onchange="checkrefecha(this.form)" onFocus="encender(this)" onBlur="apagar(this)"  > </span> </span></td>
                <td width="227"><span class="Estilo5">                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="Estilo5"> </span>
                <table width="680" border="0" align="center">
                  <tr>
                    <td width="110"><span class="Estilo5">CONCEPTO DE ANULACI&Oacute;N  : </span></td>
                    <td width="494"><span class="Estilo5"><textarea name="txtdescrip_anu" cols="65" rows="2" onFocus="encender(this)" onBlur="apagar(this)"  id="txtdescrip_anu"></textarea></span></td>
                  </tr>
              </table></td>
          </tr>
          <tr>
            <td><table width="680" border="0" align="center"> <tr>
				<td width="20"><input name="txttipo_diferido" type="hidden"  id="txttipo_diferido" value="<?echo $tipo_diferido?>"></td>
				<td width="96"><input name="txtreferencia_dife" type="hidden"  id="txtreferencia_dife" value="<?echo $referencia_dife?>"></td>
            </tr></table></td>
          </tr>
          <tr>
            <td></td>
          </tr>
          <tr>
            <td><table width="660" align="center">
              <tr>
                <td width="182">&nbsp;</td>
                <td width="127" align="center" valign="middle"><input name="Anular" type="submit" id="Anular"  value="Anular"></td>
                <td width="10" align="center">&nbsp;</td>
                <td width="136" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:window.close()"></td>
                <td width="181">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><p>&nbsp;</p>
          </tr>
        </table>
          </td>
    </tr>
  </table>
</form>
</body>
</html>