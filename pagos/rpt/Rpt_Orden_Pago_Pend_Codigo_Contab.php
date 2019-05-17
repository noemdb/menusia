<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$tipo_orden_d="";$tipo_orden_h="";$cod_cuenta_d="";$cod_cuenta_h="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Reporte Relacion Orden de Pago / Asociacion Contable)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK
href="../../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../../class/sia.js"
type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}

function Llama_Rpt_Orden_Pago_Pend_Codigo_Cont(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Ordenes de Pago Pedientes por Codigo Contable?");
  if (r==true) {
    url=murl+"?fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&tipo_orden_d="+document.form1.txttipo_ordend.value+"&tipo_orden_h="+document.form1.txttipo_ordenh.value+"&cod_cuenta_d="+document.form1.txtcod_cuentad.value+"&cod_cuenta_h="+document.form1.txtcod_cuentah.value;
    window.open(url,"Reporte Ordenes de Pago Pedientes por Codigo Contable")
  }
}

function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo9 {font-size: 8pt}
.Estilo12 {font-size: 12px}
.Estilo13 {
        color: #0000FF;
        font-weight: bold;
}
-->
</style>
</head>
<?
$sql="SELECT MAX(Tipo_Orden) As Max_Tipo_Orden, MIN(Tipo_Orden) As Min_Tipo_Orden FROM TIPOS_ORDEN";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$tipo_orden_d=$registro["min_tipo_orden"];$tipo_orden_h=$registro["max_tipo_orden"];}

$sql="SELECT MAX(Codigo_Cuenta) As Max_Codigo_Cuenta, MIN(Codigo_Cuenta) As Min_Codigo_Cuenta FROM CON001";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_cuenta_d=$registro["min_codigo_cuenta"];$cod_cuenta_h=$registro["max_codigo_cuenta"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE ORDENES DE PAGO PENDIENTES POR CODIGO CONTABLE </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="403" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="397">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:375px; z-index:1; top: 73px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="369" border="0">
    <tr>
      <td width="958" height="365" align="center" valign="top"><table width="783" height="292" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="175">&nbsp;</td>
              <td width="239"><span class="Estilo13">DESDE</span></td>
              <td width="343"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="771" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="170" align="center"><div align="left">FECHA ORDENES:</div></td>
              <td width="238" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="363" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="18"><table width="776" border="0">
            <tr>
              <td width="170" height="26">
                <div align="left">TIPO ORDEN:</div></td>
              <td width="92"><span class="Estilo5">
                <input name="txttipo_ordend" type="text" id="txttipo_ordend" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_orden_d?>" size="15" maxlength="15">
              </span></td>
              <td width="139"><span class="Estilo5">
                <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_tipo_ordend.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="90"><span class="Estilo5">
                <input name="txttipo_ordenh" type="text" id="txttipo_ordenh" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_orden_h?>" size="15" maxlength="15">
              </span></td>
              <td width="263"><span class="Estilo5">
                <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_tipo_ordenh.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="18"><table width="776" border="0">
            <tr>
              <td width="170" height="26">
                <div align="left">CODIGO CUENTA: </div></td>
              <td width="150"><span class="Estilo5">
                <input name="txtcod_cuentad" type="text" id="txtcod_cuentad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cuenta_d?>" size="25" maxlength="15">
              </span></td>
              <td width="85"><span class="Estilo5">
                <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_cuentasd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="150"><span class="Estilo5">
                <input name="txtcod_cuentah" type="text" id="txtcod_cuentah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cuenta_h?>" size="25" maxlength="15">
              </span></td>
              <td width="199"><span class="Estilo5">
                <input name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_cuentash.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="89"><table width="399" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td width="200">
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Orden_Pago_Pend_Codigo_Cont('Rpt_Orden_Pago_Pend_Codigo_Cont.php');">
                      </div></td>
              <td width="254">
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
    </div>    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
