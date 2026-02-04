<?php include ("../class/fun_fechas.php");
if (!$_GET){$cod_banco='';}  else{$cod_banco=$_GET["txtcod_banco"];} $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (DESCATIVA CUENTA BANCARIA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function checkrefecha(mform){var mref;var mfec;
  mref=mform.txtfecha_anu.value;
  if(mform.txtfecha_anu.value.length==8){mfec=mref.substring(0,6)+ "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_anu.value=mfec;}
return true;}
function revisar(){var f=document.form1; var r; var Valido=true;
    if(f.txtfecha_anu.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtfecha_anu.value.length==10){Valido=true;}  else{alert("Longitud de Fecha Invalida");return false;}
    r=confirm("Esta seguro en Descativar el banco ?");
    if (r==true) {r=confirm("Esta Realmente seguro en Descativar el banco ?");
      if (r==true) {Valido=true;} else {return false;}  }
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Anu_cod_banco.php" onSubmit="return revisar()">
  <table width="714" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="707" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">DESACTIVAR CÓDGO DE BANCO </span></td>
        </tr>
        <tr>
          <td><p><strong>ADVERTENCIA: ESTE PROCESO DESACTIVA EL CODIGO DEL BANCO, EL CUAL NO PUEDE SER UTILIZADO EN LOS PROCESOS BANCARIOS. </strong></p> </td>
        </tr>
        <tr><td>&nbsp;</td> </tr>
          <tr>
            <td><table width="680" border="0" align="center">
              <tr>
                <td width="300" align="right"><span class="Estilo5">FECHA DE DESACTIVACI&Oacute;N: </span></td>
                <td width="280"><span class="Estilo5">
                  <input class="Estilo10" name="txtfecha_anu" type="text" id="txtfecha_anu" size="10" maxlength="10" value="<?echo $fecha_hoy?>"  onchange="checkrefecha(this.form)" onFocus="encender(this)" onBlur="apagar(this)"  >
                </span></td>
                <td width="100"></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
          <tr>
          <td><table width="680" border="0" align="center"> <tr>
            <td width="40"><input class="Estilo10" name="txtcod_banco" type="hidden" id="txtcod_banco" value="<?echo $cod_banco?>"></td>
           </tr></table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td><table width="660" align="center">
              <tr>
                <td width="182">&nbsp;</td>
                <td width="127" align="center" valign="middle"><input name="Desactivar" type="submit" id="Desactivar"  value="Desactivar"></td>
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