<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$cod_banco_d="";$num_trasnf_d="00000000"; $num_trasnf_h="99999999";
 $vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANACARIO (Reporte Impresion de Transferencias)</title>
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

function Llama_Rpt_Impresion_Transferen(murl){
var url;
var r;
  r=confirm("Desea Generar el Reporte Impresion de Transferencias ?");
  if (r==true) {
    url=murl+"?cod_banco_d="+document.form1.txtcod_banco_d.value+"&num_trasnf_d="+document.form1.txtnum_trasnf_d.value+"&num_trasnf_h="+document.form1.txtnum_trasnf_h.value;
    window.open(url,"Reporte Impresion de Transferencias")}}
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE IMPRESI&Oacute;N DE TRANSFERENCIA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="249" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="217">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:192px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="183" border="0">
    <tr>
      <td width="958" height="179" align="center" valign="top"><table width="783" height="164" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="18" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="26" align="center" class="Estilo16"><table width="783" border="0">
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
          <td height="18" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="22"><div align="center">
              <table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="318" align="center"><div align="left">NUMERO DE TRANSFERENCIA DESDE : </div></td>
                  <td width="143" align="center">
                    <div align="left"><span class="Estilo5">
                      <input name="txtnum_trasnf_d" type="text" id="txtnum_trasnf_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $num_trasnf_d?>" size="12" maxlength="12">
                  </span></div></td>
                  <td width="75" align="center"><div align="left">HASTA :</div></td>
                  <td width="247" align="center">
                    <div align="left"><span class="Estilo5">
                      <input name="txtnum_trasnf_h" type="text" id="txtnum_trasnf_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $num_trasnf_h?>" size="12" maxlength="12">
                  </span></div></td>
                </tr>
              </table>
          </div></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="24"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Impresion_Transferen('Rpt_Impresion_Transferen.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="38">&nbsp;</td>
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

<? pg_close();?>
