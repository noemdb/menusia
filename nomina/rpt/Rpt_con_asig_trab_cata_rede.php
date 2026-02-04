<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $tipo_nomina_d="";
 $tipo_nomina_h="zzzzzzzz";
 $cod_trab_hasta="";
 $cedula_desde="zzz";
 $vstatus="T";
 $vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Reporte Diario General)</title>
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


function Llama_Rpt_Diario_Gen(murl){
var url;
var r;
  r=confirm("Desea Generar el Reporte Diario General ?");
  if (r==true) {
    url=murl+"?"&tipo_nomina_d="+document.form1.txttipo.value+"&cod_trab_desde="+document.form1.txtcod_empleado.value+"&cedula_desde="+document.form1.txtced.value+";
    LlamarURL(url);
  }
}

function Llama_Menu_Rpt(murl){
var url;
   url="../"+murl;
   LlamarURL(url);
}

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
$sql="SELECT MAX(Referencia) As Max_Referencia, MIN(Referencia) As Min_Referencia,MAX(Tipo_Asiento) As Max_Tipo,MIN(Tipo_Asiento) As Min_Tipo FROM CON002";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
}
if($encontro=true){
  $referencia_d=$registro["min_referencia"];
  $referencia_h=$registro["max_referencia"];
  $tipo_asiento_d=$registro["min_tipo"];
  $tipo_asiento_h=$registro["max_tipo"];
}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE DIARIO GENERAL </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="507" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:495px; z-index:1; top: 68px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" border="0">
    <tr>
      <td width="958" align="center" valign="top"><table width="783" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="783" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center">
            <table width="588" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="193" align="center"><div align="left">REFERENCIA DESDE: </div></td>
                <td width="140" align="center">
                  <div align="left"><span class="Estilo5">
                    <input name="txtReferenciad" type="text" id="txtReferenciad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $referencia_d?>" size="12" maxlength="8">
                </span></div></td>
                <td width="68" align="center"><div align="left">HASTA:</div></td>
                <td width="187" align="center">
                  <div align="left"><span class="Estilo5">
                    <input name="txtReferenciah" type="text" id="txtReferenciah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $referencia_h?>" size="12" maxlength="8">
                </span></div></td>
              </tr>
            </table>
          </div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center">
            <table width="587" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="193" align="center"><div align="left">TIPO ASIENTO  DESDE: </div></td>
                <td width="139" align="center">
                  <div align="left"><span class="Estilo5">
                    <input name="txtTipo_Asientod" type="text" id="txttipo_asientod" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_asiento_d?>" size="12" maxlength="3">
                    <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo Tipos de Asientos" onclick="VentanaCentrada('../Cat_tipo_asientod.php?criterio=','SIA','','650','500','true')" value="...">
</span></div></td>
                <td width="71" align="center"><div align="left">HASTA:</div></td>
                <td width="184" align="center">
                  <div align="left"><span class="Estilo5">
                    <input name="txtTipo_Asientoh" type="text" id="txttipo_asientoh" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_asiento_h?>" size="12" maxlength="3">
                    <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo Tipos de Asientos" onclick="VentanaCentrada('../Cat_tipo_asientoh.php?criterio=','SIA','','650','500','true')" value="...">
</span></div></td>
              </tr>
            </table>
          </div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Diario_Gen('Rpt_Diario_Gen.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('Menu.php');">
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
