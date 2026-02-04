<?php include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();  
if (!$_GET){$tipo_informe="";$linea="00000001";}else{$tipo_informe=$_GET["tipo_informe"];$linea=$_GET["linea"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Agregar Linea Informes Contables)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_inf_contables.php?criterio=<?php echo $tipo_informe?>'; }

function revisar(){var f=document.form1; var Valido=true;
   if(f.txtlinea.value==""){alert("Linea no puede estar Vacio");return false;}
   if(f.txtlinea.value.length==8){valido=true;}else{alert("Longitud Linea Invalida");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Insert_campo_inf_contab.php" onSubmit="return revisar()">
  <table width="832" height="150" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="831" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR LINEA INFORME CONTABLE</span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="50"><span class="Estilo5">LINEA :</span> </td>
                <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtlinea" type="text" id="txtlinea" size="10" maxlength="8" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $linea?>" > </span></td>
                <td width="120"><span class="Estilo5">CODIGO CUENTA :</span> </td>
				<td width="200"><span class="Estilo5"><input  class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" class="Estilo5"  size="30" maxlength="30" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
                <td width="80"><input  class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Codigo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas.php?criterio=','SIPAP','','750','500','true')" value="..."></td>                   
			    <td width="80"><span class="Estilo5">CODIGO : </span></td>
                <td width="200"><span class="Estilo5"><input  class="Estilo10" name="txtcod_cuenta" type="text" class="Estilo5" id="txtcod_cuenta"  size="30" maxlength="30" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
              </tr>
          </table></td>
        </tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
            <td><table width="830">
                <tr>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                   <td width="500"><span class="Estilo5"> <input  class="Estilo10" name="txtNombre_Cuenta" type="text" class="Estilo5" id="txtNombre_Cuenta"   size="120" maxlength="200" readonly>   </span></td>
                </tr>
            </table></td>
        </tr>
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="100"><span class="Estilo5">CALCULABLE : </span></td>
                <td width="130"><span class="Estilo5"><select class="Estilo10" name="txtcalculable" size="1" id="txtcalculable" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="100"><span class="Estilo5">ESTATUS : </span></td>
                <td width="130"><span class="Estilo5"><select class="Estilo10" name="txtstatus_linea" size="1" id="txtstatus_linea" onFocus="encender(this)" onBlur="apagar(this)"><option>0</option> <option>1</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> <option>6</option> <option>7</option> <option>8</option> <option>9</option> </select> </span></td>
                <td width="100"><span class="Estilo5">OPERACION : </span></td>
                <td width="180"><span class="Estilo5"><select class="Estilo10" name="txtmoperacion" size="1" id="txtmoperacion" onFocus="encender(this)" onBlur="apagar(this)"><option>+</option> <option>-</option></select> </span></td>
              </tr>
           </table></td>
        </tr>		
        <tr><td>&nbsp;</td></tr>        
		<tr>
          <td><table width="830" border="0">
              <tr>
                <td width="100"><span class="Estilo5">COLUMNA : </span></td>
				<td width="230"><span class="Estilo5"><select class="Estilo10" name="txtcolumna" size="1" id="txtcolumna" onFocus="encender(this)" onBlur="apagar(this)"><option>1</option> <option>2</option> <option>3</option> <option>4</option> </select> </span></td>
                <td width="100"><span class="Estilo5">ESTILO : </span></td>
				<td width="400"><span class="Estilo5"><select class="Estilo10" name="txtstatus" size="1" id="txtstatus" onFocus="encender(this)" onBlur="apagar(this)"><option>1-Normal</option> <option>2-Negrita</option> <option>3-Subrayada</option> <option>4-Negrita Subrayada</option> <option>5-Subtotal</option> <option>6-Total</option> <option>7-Cursiva</option> <option>8-Subtotal Negrita</option>  <option>9-Total Negrita</option> </select> </span></td>
              </tr>
           </table></td>
        </tr>
		
        <tr><td><p>&nbsp;</p></td></tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input name="txttipo_informe" type="hidden" id="txttipo_informe" value="<?php echo $tipo_informe?>"></td>
            <td width="80">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="120">&nbsp;</td>
          </tr>
          <tr><td><p>&nbsp;</p></td></tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>