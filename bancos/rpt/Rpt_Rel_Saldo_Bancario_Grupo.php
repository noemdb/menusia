<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $cod_banco_d="";$cod_banco_h="";
 $imprimir="N";
 $vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Reporte Relaci&oacute;n Saldo Bancario por Grupo)</title>
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
function checkrefechad(mform){
var mref;
var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){
var mref;
var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtFechah.value=mfec;}
return true;}

function Llama_Rpt_Rel_Saldo_Bancario_Gru(murl){
var url;
var r;
  r=confirm("Desea Generar el Reporte Relacion Saldo Bancario por Grupo?");
  if (r==true){url=murl+"?cod_banco_d="+document.form1.txtcod_banco_d.value+"&cod_banco_h="+document.form1.txtcod_banco_h.value;
    window.open(url,"Reporte Relacion Saldo Bancario por Grupo")}}
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

$sql="SELECT MAX(Tipo_Movimiento) As Max_Tipo_Movimiento, MIN(Tipo_Movimiento) As Min_Tipo_Movimiento FROM BAN003";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$tipo_mov_d=$registro["min_tipo_movimiento"];$tipo_mov_h=$registro["max_tipo_movimiento"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE RELACI&Oacute;N SALDO BANCARIO POR GRUPO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="585" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="579">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:506px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="493" border="0">
    <tr>
      <td width="958" height="489" align="center" valign="top"><table width="783" height="369" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="2" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="776" border="0">
            <tr>
              <td width="244" height="26">
                <div align="left">CODIGO DE BANCO DESDE : </div></td>
              <td width="52"><span class="Estilo5">
                <input name="txtcod_banco_d" type="text" id="txtcod_banco_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_d?>" size="5" maxlength="32">
              </span></td>
              <td width="35"><span class="Estilo5">
                <input name="Catalogo3" type="button" id="Catalogo32" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Bancosd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="427"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_banco_d" type="text" id="txtdesc_banco_d" size="60" maxlength="60"  readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="776" border="0">
            <tr>
              <td width="245" height="26">
                <div align="left">CODIGO DE BANCO HASTA : </div></td>
              <td width="51"><span class="Estilo5">
                <input name="txtcod_banco_h" type="text" id="txtcod_banco_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_h?>" size="5" maxlength="32">
              </span></td>
              <td width="34"><span class="Estilo5">
                <input name="Catalogo32" type="button" id="Catalogo323" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Bancosh.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="428"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_banco_h" type="text" id="txtdesc_banco_h" size="60" maxlength="60"  readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="776" border="0">
            <tr>
              <td width="240" height="26"><div align="left">GRUPO DE BANCO DESDE : </div></td><td width="47"><span class="Estilo5">
                <input name="txtcod_banco_d" type="text" id="txtcod_banco_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_d?>" size="5" maxlength="32">
              </span></td>
              <td width="44"><span class="Estilo5">
                <input name="Catalogo3" type="button" id="Catalogo32" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Bancosd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="427"><span class="Estilo12"><span class="Estilo5">
                 <input name="txtdesc_banco_d" type="text" id="txtdesc_banco_d" size="60" maxlength="60"  readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="776" border="0">
            <tr>
              <td width="242" height="26">
                <div align="left">GRUPO DE BANCO HASTA : </div></td>
              <td width="47"><span class="Estilo5">
                <input name="txtcod_banco_h" type="text" id="txtcod_banco_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_h?>" size="5" maxlength="32">
              </span></td>
              <td width="41"><span class="Estilo5">
                <input name="Catalogo32" type="button" id="Catalogo323" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Bancosh.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="428"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_banco_h" type="text" id="txtdesc_banco_h" size="60" maxlength="60"  readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="783" border="0">
            <tr>
              <td width="101"><p align="left">PERIODO :</p></td>
              <td width="345"><select name="selectperiodo" size="1" id="selectperiodo">
                  <option selected>01</option>
                  <option>02</option>
                  <option>03</option>
                  <option>04</option>
                  <option>05</option>
                  <option>06</option>
                  <option>07</option>
                  <option>08</option>
                  <option>09</option>
                  <option>10</option>
                  <option>11</option>
                  <option>12</option>
              </select></td>
              <td width="62">&nbsp;</td>
              <td width="257">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><strong>TIPOS DE BANCO</strong></td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="720" border="2" cellspacing="1" cellpadding="1">
            <tr>
              <td width="11">&nbsp;</td>
              <td width="21"><div align="center">
                <input type="checkbox" name="checkbox2422" value="checkbox">
              </div></td>
              <td width="162">TODOS</td>
              <td width="13">&nbsp;</td>
              <td width="26"><div align="center">
                <input type="checkbox" name="checkbox242" value="checkbox">
              </div></td>
              <td width="15">&nbsp;</td>
              <td width="169">GASTOS CORRIENTES</td>
              <td width="15">&nbsp;</td>
              <td width="27"><div align="center">
                <input type="checkbox" name="checkbox2427" value="checkbox">
              </div></td>
              <td width="14">&nbsp;</td>
              <td width="171">FONDO DE TERCEROS</td>
              <td width="11">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div align="center">
                <input type="checkbox" name="checkbox2423" value="checkbox">
              </div></td>
              <td>FIDEICOMISO-FIDES</td>
              <td>&nbsp;</td>
              <td><div align="center">
                <input type="checkbox" name="checkbox2425" value="checkbox">
              </div></td>
              <td>&nbsp;</td>
              <td>FIDEICOMISO-LAEE</td>
              <td>&nbsp;</td>
              <td><div align="center">
                <input type="checkbox" name="checkbox2428" value="checkbox">
              </div></td>
              <td>&nbsp;</td>
              <td>FIEM</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div align="center">
                <input type="checkbox" name="checkbox2424" value="checkbox">
              </div></td>
              <td>PEN. POR CANCELAR</td>
              <td>&nbsp;</td>
              <td><div align="center">
                <input type="checkbox" name="checkbox2426" value="checkbox">
              </div></td>
              <td>&nbsp;</td>
              <td>OTROS</td>
              <td>&nbsp;</td>
              <td><div align="center">
                <input type="checkbox" name="checkbox2429" value="checkbox">
              </div></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="326" height="19">IMPRIME CUENTAS CON SALDO CERO : </td>
          <td width="457" height="19"><div align="left">
            <table width="115" height="30" border="1">
              <tr>
                <td width="121" valign="top"><label>
                  <input name="opordenar" type="radio" value="S" checked>
      SI </label>
                    <label>
                    <input type="radio" name="opordenar" value="N">
      NO </label></td>
              </tr>
            </table>
          </div></td>
        </tr>
        <tr>
          <td height="65" colspan="2"><div align="left">
            <table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr align="center" valign="middle">
                  <td>
                        <div align="center">
                          <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Rel_Saldo_Bancario_Gru('Rpt_Rel_Saldo_Bancario_Gru.php');">
                          </div></td>
                  <td>
                        <div align="center">
                          <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                          </div></td></tr>
            </table>
          </div></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
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
