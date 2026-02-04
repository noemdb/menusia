<?php include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Reporte Orden de Pago)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../../class/sia.js"
type=text/javascript></SCRIPT>

<script language="javascript" src="../../class/cal2.js"></script>

<script language="javascript" src="../../class/cal_conf2.js"></script>

<script language="JavaScript" type="text/JavaScript">
</script>
<style type="text/css">
<!--
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo10 {font-size: 12px}
.Estilo11 {font-size: 7pt}
.Estilo12 {font-weight: bold}
.Estilo13 {font-weight: bold; font-size: 7pt; }
.Estilo15 {font-size: 7px; font-weight: bold; }
-->
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ORDEN PAGO N&ordm;</div></td>
    <td width="55" class="Estilo2">&nbsp;</td>
  </tr>
</table>
<table width="978" height="830" border="1" id="tablacuerpo">
  <tr>
    <td width="989" height="300">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:966px; height:803px; z-index:1; top: 90px; left: 16px;">
        <form name="form1" method="get">
           <table width="942" height="804" border="0">
    <tr>
      <td width="958" height="238" align="center" valign="top"><table width="857" height="755" border="2" cellpadding="0" cellspacing="0">
        <tr bgcolor="#FFFFFF">
          <td width="634" height="28" align="center" class="Estilo16" ><div align="left">
            <input name="checkbox1" type="checkbox" id="checkbox1" value="checkbox">
            Con Imputacion Presupuestaria 
            <input type="checkbox" name="checkbox2" value="checkbox">
            Sin imputacion Presupuestaria 
          </div></td>
          <td width="223" align="center" class="Estilo16"><div align="left"><span class="Estilo13">FECHA:&nbsp;</span><span class="Estilo10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="txtfecha" type="text" id="txttipo_retencion6" size="15" maxlength="3" readonly>
          </span></div></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="28" align="center" bordercolor="#3300FF" class="Estilo16"><div align="left" class="Estilo15">
            <p><span class="Estilo11">BENEFICIARIO:&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="txtbeneficiario" type="text" id="txtbeneficiario" size="40" maxlength="3" readonly>
            </p>
            <p><span class="Estilo11">CHEQUE A FAVOR:</span>
              <input name="txtbeneficiario_favor" type="text" id="txtbeneficiario_favor" size="40" maxlength="3" readonly>
            </p>
          </div></td>
          <td height="28" align="center" class="Estilo16"><div align="left" class="Estilo13">
           <p>CEDULA/RIF:
             <input name="txtcedula_rif_benefi" type="text" id="txtcedula_rif_benefi" size="15" maxlength="3" readonly>
           </p>
           <p>CEDULA/RIF:
             <input name="txtcedula_rif_beneficiario_favor" type="text" id="txtcedula_rif_beneficiario_favor" size="15" maxlength="3" readonly>
           </p>
          </div></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="36" colspan="2" align="center" class="Estilo16"><div align="left" class="Estilo11"><strong>POR LA CANTIDAD DE:</strong> 
              <input name="txtcantidad" type="text" id="txtcantidad" value="" size="98" readonly="readonly">
</div></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="18" colspan="2" align="center" class="Estilo16"><div align="left" class="Estilo15"><span class="Estilo11">POR CONCEPTO DE</span>: 
              <textarea name="txtconcepto" cols="70" readonly="readonly" id="txtconcepto"></textarea>
          </div></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="38" colspan="2" align="center" class="Estilo16"><div align="right">MONTO ORDEN Bs:<span class="Estilo10">
            <input name="txtmonto_orden" type="text" id="txtmonto_orden" size="20" maxlength="3" readonly>
          </span></div></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="24" colspan="2"><div align="justify"></div>            <table width="860" height="21" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td width="80"><div align="left"><span class="Estilo13">COD.</span></div></td>
              <td width="359"><div align="left" class="Estilo11"><strong>DESCRIPCION</strong></div></td>
              <td width="187"><div align="left" class="Estilo13">CODIGO CONTABLE </div></td>
              <td width="81"><div align="left" class="Estilo11"><strong>TASA (%) </strong></div></td>
              <td width="141"><div align="left" class="Estilo11"><strong>MONTO RETENCION </strong></div></td></tr>
          </table>
          </td>
        </tr>
        <tr bordercolor="#000000">
          <td height="27" colspan="2"><p><span class="Estilo10">
            <input name="txtcodigo" type="text" id="txttipo_retencion5223" size="10" maxlength="3" readonly>
            <input name="txtdescripcion" type="text" id="txttipo_retencion5224" size="40" maxlength="3" readonly>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="txtcodigo_contable" type="text" id="txttipo_retencion5225" size="25" maxlength="3" readonly>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="txttasa" type="text" id="txttasa" size="8" maxlength="3" readonly>
            <input name="txtmonto_retencion" type="text" id="txtmonto_retencion" size="13" maxlength="3" readonly>
          </span></p>
            <p>&nbsp;</p></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="26" colspan="2"><div align="center"><strong>CONTABILIDAD PRESUPUESTARIA </strong></div></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="24" colspan="2"><div align="justify" class="Estilo11"></div>
              <table width="860" height="21" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr align="center" valign="middle">
                  <td width="275" class="Estilo13"><div align="left">CODIGO PRESUPUESTARIO </div>
                      <div align="center"></div></td>
                  <td width="280" class="Estilo11"><div align="center"><strong>DENOMINACION</strong></div></td>
                  <td width="297" class="Estilo13"><div align="left">
                      <div align="center"></div>
                      <div align="center">MONTO </div>
                  </div></td>
                </tr>
              </table></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="27" colspan="2"><p><span class="Estilo10">
            <input name="txtcodigo_presupuestario" type="text" id="txttipo_retencion5223" size="40" maxlength="3" readonly>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="txtdenominacion_presupuestaria" type="text" id="txttipo_retencion5224" size="40" maxlength="3" readonly>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="monto_presupuestaria" type="text" id="txttipo_retencion5225" size="25" maxlength="3" readonly>
          </span></p>
            <p>&nbsp;</p></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="22" colspan="2"><div align="center"><strong>CONTABILIDAD FINANCIERA </strong></div></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="24" colspan="2"><div align="justify"></div>
              <table width="862" height="21" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr align="center" valign="middle">
                  <td width="197" class="Estilo12"><div align="left" class="Estilo11">CODIGO DE CUENTA </div></td>
                  <td width="349" class="Estilo12"><div align="center" class="Estilo11">NOMBRE</div></td>
                  <td width="136" class="Estilo12"><div align="left" class="Estilo11">DEBE</div></td>
                  <td width="170" class="Estilo12"><div align="left" class="Estilo11">HABER</div></td>
                </tr>
            </table></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="66" colspan="2"><p class="Estilo10">
              <input name="txtcodigo_cuenta" type="text" id="txtcodigo_cuenta" size="27" maxlength="3" readonly>
              &nbsp;&nbsp;&nbsp;
              <input name="txtnombre_cuenta" type="text" id="txtnombre_cuenta" size="50" maxlength="3" readonly>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="txtdebe" type="text" id="txtdebe" size="10" maxlength="3" readonly>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="txthaber" type="text" id="txthaber" size="10" maxlength="3" readonly>
          </p>
            <p class="Estilo10">&nbsp;          </p></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="24" colspan="2"><div align="justify"></div>
              <table width="860" height="21" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr align="center" valign="middle">
                  <td width="177"><div align="left" class="Estilo11">
                    <div align="center">CUENTA POR PAGAR </div>
                  </div></td>
                  <td width="203"><div align="center" class="Estilo11">
                    <div align="center">REVISADO POR PRESUPUESTO </div>
                  </div></td>
                  <td width="205"><div align="left" class="Estilo11">
                    <div align="center">REVISADO POR CONTABILIDAD </div>
                  </div></td>
                  <td width="275"><div align="left" class="Estilo11">
                    <div align="center">GERENCIA DE ADMIN. Y FINANZAS </div>
                  </div></td>
                </tr>
            </table></td>
        </tr>
        <tr bordercolor="#000000">
          <td height="69" colspan="2"><p>&nbsp;</p>
            <p>&nbsp;</p></td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>

<?php  pg_close($conn);?>
