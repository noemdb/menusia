<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$cod_banco_d="";$cod_banco_h="";$num_cheque_d="00000000";$num_cheque_h="99999999";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$cheque_d="00000000";$cheque_h="99999999";$detallado="S";$imprimir="S";$ordenado="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Reporte Ruta de Cheques)</title>
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
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_Ruta_Cheq(murl){var url;var r;var det;var imp;var ord;
  if(document.form1.opdetallado[0].checked==true){det="S";}
  if(document.form1.opdetallado[1].checked==true){det="N";}
  if(document.form1.opimprimir[0].checked==true){imp="S";}
  if(document.form1.opimprimir[1].checked==true){imp="N";}
  if(document.form1.opordenar[0].checked==true){ord="num_cheque";}
  if(document.form1.opordenar[1].checked==true){ord="fecha";}
  r=confirm("Desea Generar el Reporte Ruta de Cheques?");
  if (r==true){url=murl+"?cod_banco_d="+document.form1.txtcod_banco_d.value+"&cod_banco_h="+document.form1.txtcod_banco_h.value+"&num_cheque_d="+document.form1.txtnum_cheque_d.value+"&num_cheque_h="+document.form1.txtnum_cheque_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&cheque_d="+document.form1.txtchequed.value+"&cheque_h="+document.form1.txtchequeh.value+"&detallado="+det+"&imprimir="+imp+"&ordenado="+ord;
  window.open(url,"Reporte Ruta de Cheques")}
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
-->
</style>
</head>
<?
$sql="SELECT MAX(Cod_Banco) As Max_Cod_Banco, MIN(Cod_Banco) As Min_Cod_Banco FROM BAN002";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_banco_d=$registro["min_cod_banco"];$cod_banco_h=$registro["max_cod_banco"];}
?>
<body>
<blockquote>&nbsp;        </blockquote>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE RUTA DE CHEQUES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="568" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="562">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:507px; z-index:1; top: 99px; left: 21px;">
        <form name="form1" method="get">
           <table width="950" height="499" border="0">
    <tr>
      <td width="958" height="426" align="center" valign="top"><table width="783" height="524" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="19" colspan="3" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="30" colspan="3"><table width="776" border="0">
            <tr>
              <td width="239" height="26"><div align="left">CODIGO DE BANCO DESDE:</div></td>
             <td width="56"><span class="Estilo5">
                <input name="txtcod_banco_d" type="text" id="txtcod_banco_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_d?>" size="5" maxlength="5">
              </span></td>
              <td width="47"><span class="Estilo5">
                <input name="Catalogo3" type="button" id="Catalogo32" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Bancosd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="418"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_banco_d" type="text" id="txtdesc_banco_d" size="60" maxlength="60"  readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="776" border="0">
            <tr>
              <td width="240" height="26">
                <div align="left">CODIGO DE BANCO HASTA:</div></td>
               <td width="55"><span class="Estilo5">
                <input name="txtcod_banco_h" type="text" id="txtcod_banco_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_h?>" size="5" maxlength="5">
              </span></td>
              <td width="46"><span class="Estilo5">
                <input name="Catalogo32" type="button" id="Catalogo322" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Bancosh.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="420"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_banco_h" type="text" id="txtdesc_banco_h" size="60" maxlength="60"  readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="783" border="0">
            <tr>
              <td width="226" height="26"><p align="left">NUMERO CHEQUE  DESDE:</p></td>
               <td width="301"><span class="Estilo5">
                <input name="txtnum_cheque_d" type="text" id="txtnum_cheque_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $num_cheque_d?>" size="12" maxlength="8">
              </span></td>
              <td width="97">HASTA:</td>
              <td width="139"><span class="Estilo5">
                <input name="txtnum_cheque_h" type="text" id="txtnum_cheque_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $num_cheque_h?>" size="12" maxlength="8">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="22" colspan="3"><table width="777" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="205" align="center"><div align="left">FECHA EMISION DESDE: </div></td>
              <td width="349" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="77" align="center"><div align="left">HASTA :</div></td>
              <td width="146" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="783" border="0">
            <tr>
              <td width="273" height="26"><p align="left">ULT. 6 DIGITO CHEQUE  DESDE :</p></td>
              <td width="273"><span class="Estilo5">
                <input name="txtchequed" type="text" id="txtUltimoDigCheqd" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cheque_d?>" size="12" maxlength="12">
              </span></td>
              <td width="74">HASTA :</td>
              <td width="146"><span class="Estilo5">
                <input name="txtchequeh" type="text" id="txtUltimoDigCheq" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cheque_h?>" size="12" maxlength="12">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="312">IMP. CANT. CHEQUES EMITIDOS :</td>
              <td width="452">IMP. CANT. CONCEPTOS DE LOS CHEQUES : </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="97">&nbsp;</td>
              <td width="379"><table width="120" height="30" border="1">
                <tr>
                  <td width="110" valign="top"><label>
                   <input name="opdetallado" type="radio" value="S" checked>
      SI </label>
                      <label>
                      <input name="opdetallado" type="radio" value="N" >
      NO </label></td>
                </tr>
              </table></td>
              <td width="285"><table width="120" height="30" border="1">
                <tr>
                  <td width="110" valign="top"><label>
                    <input name="opimprimir" type="radio" value="S" checked>
      SI </label>
                      <label>
                      <input name="opimprimir" type="radio" value="N" >
      NO </label></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="369">ORDENAR CHEQUES POR ULT. 6 DIGITOS : </td>
              <td width="395">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="97" height="32">&nbsp;</td>
              <td width="365"><table width="120" height="30" border="1">
                  <tr>
                    <td width="110" valign="top"><label>
                      <input name="opordenar" type="radio" value="num_cheque"  checked>
            SI </label>
                        <label>
                        <input name="opordenar" type="radio" value="fecha">
            NO </label></td>
                  </tr>
              </table></td>
              <td width="299">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="118" colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Ruta_Cheq('Rpt_Ruta_Cheq.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
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
