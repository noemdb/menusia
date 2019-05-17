<?php include ("../class/fun_fechas.php"); if (!$_GET){$cod_banco='';$num_cheque='';}  else{$cod_banco=$_GET["txtcod_banco"];$num_cheque=$_GET["num_cheque"];} $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Devolucion de Cheques)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefecha(mform){var mref; var mfec;
  mref=mform.txtfecha_recep.value;
  if(mform.txtfecha_recep.value.length==8){mfec=mref.substring(0,6)+ "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_recep.value=mfec;}
return true;}
function revisar(){ var f=document.form1;var r; var Valido=true;
    if(f.txtfecha_recep.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtfecha_recep.value.length==10){Valido=true;}  else{alert("Longitud de Fecha Invalida");return false;}
    r=confirm("Desea Devolver el Cheque ?");  if (r==true) {Valido=true;} else {return false;}
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
<form name="form1" method="post" action="Update_edo_cheque.php" onSubmit="return revisar()">
  <table width="374" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="370" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">DEVOLUCION DE CHEQUE A CAJA</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="360" border="0" align="center">
              <tr>
                <td width="160"><span class="Estilo5">FECHA DE DEVOLUCI&Oacute;N: </span></td>
                <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtfecha_recep" type="text" id="txtfecha_recep" size="15" value="<?echo $fecha_hoy?>"  onchange="checkrefecha(this.form)" onFocus="encender(this)" onBlur="apagar(this)"  >
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <td><table width="360" border="0" align="center"> <tr>
            <td width="40"><input name="txtcod_banco" type="hidden" id="txtcod_banco" value="<?echo $cod_banco?>"></td>
            <td width="40"><input name="txtentregado" type="hidden" id="txtentregado" value="N"></td>
            <td width="40"><input name="txtopcion" type="hidden" id="txtopcion" value="D"></td>
            <td width="40"><input name="txtced_rif_recib" type="hidden" id="txtced_rif_recib" value=""></td>
            <td width="40"><input name="txtnombre_recib" type="hidden" id="txtnombre_recib" value=""></td>
            <td width="40"><input name="txtnum_cheque" type="hidden" id="txtnum_cheque" value="<?echo $num_cheque?>"></td>
          </tr></table></td>
          </tr>
          <tr>
            <td><span class="Estilo5"> </span>                </td>
          </tr>
          <tr>
            <td><table width="360" align="center">
              <tr>
                <td width="30">&nbsp;</td>
                <td width="100" align="center" valign="middle"><input name="Devolver" type="submit" id="Devolver"  value="Devolver"></td>
                <td width="10" align="center">&nbsp;</td>
                <td width="90" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:window.close()"></td>
                <td width="30">&nbsp;</td>
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