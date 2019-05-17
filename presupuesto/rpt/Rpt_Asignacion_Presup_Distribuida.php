<?include ("../../class/seguridad.inc");?>
<?include ("../../class/conects.php");  include ("../../class/funciones.php"); ?>
<?php include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $partida_d='';
 $partida_h='';
 $fuente_d='';
 $fuente_h='';
 $nivel='';
 $salto_pag="S";
 $ordenar="S";
 $imprimir="N";
 $vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte Asignacion Presupuestria Distribuida)</title>
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


function Llama_Rpt_asig_dis(murl){
var url;
var r;
var imp;
var saltopag;
var ord;
  r=confirm("Desea Generar el Reporte de Asignacion Distribuida?");
  if (r==true) {
    url=murl+"?partida_d="+document.form1.txtcod_presupd.value+"&partida_h="+document.form1.txtcod_presuph.value+"&fuente_d="+document.form1.txtcod_fuented.value+"&fuente_h="+document.form1.txtcod_fuenteh.value;
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
.Estilo12 {font-size: 12px}
.Estilo15 {font-size: 8pt; font-weight: bold; }
-->
</style>
</head>
<?
$sql="SELECT MAX(Cod_Fuente_Financ) As Max_Cod_Fuente_Financ, MIN(Cod_Fuente_Financ) As Min_Cod_Fuente_Financ FROM PRE095";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
}
if($encontro=true){
  $fuente_d=$registro["min_cod_fuente_financ"];
  $fuente_h=$registro["max_cod_fuente_financ"];
}



$sql="SELECT MAX(Cod_Presup) As Max_Cod_Presup, MIN(Cod_Presup) As Min_Cod_Presup FROM PRE001";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
}
if($encontro=true){
  $partida_d=$registro["min_cod_presup"];
  $partida_h=$registro["max_cod_presup"];
}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE ASIGNACI&Oacute;N PRESUPUESTARIA DISTRIBUIDA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="395" border="1" id="tablacuerpo">
  <tr>
    <td width="967" height="389">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:361px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="356" border="0">
    <tr>
      <td width="958" height="352" align="center" valign="top"><table width="830" height="342" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="830" height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="766" border="0">
            <tr>
              <td width="325" height="26"><div align="right"> </div></td>
              <td width="223"><span class="Estilo15">SE-PR-AC-PAR-GE-ES-SE</span></td>
              <td width="204">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30"><table width="813" border="0">
            <tr>
              <td width="315" height="26">
                <div align="left">C&Oacute;DIGO PRESUPUESTARIO DESDE : </div></td>
              <td width="195"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcod_presupd" type="text" id="txtcod_presupd" size="30" maxlength="30" onFocus="encender(this); " value="<?echo $partida_d?>" onBlur="apagar(this);">
              </span></span></td>
              <td width="289"><span class="Estilo5">
                <input name="catalogo1" type="button" id="catalogo1" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('../Cat_codigos_presup_d.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="827" border="0">
            <tr>
              <td width="223" height="26">
                <div align="left"></div></td>
              <td width="88">HASTA :</td>
              <td width="207"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcod_presuph" type="text" id="txtcod_presuph" size="30" maxlength="30" onFocus="encender(this); " value="<?echo $partida_h?>" onBlur="apagar(this);">
              </span></span></td>
              <td width="291"><span class="Estilo5">
                <input name="catalogo2" type="button" id="catalogo2" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('../Cat_codigos_presup_h.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="321" height="26">
                <div align="left">FUENTE DE FINANCIAMIENTO DESDE : </div></td>
              <td width="62"><span class="Estilo5">
                <input name="txtcod_fuented" type="text" id="txtcod_fuented" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5" value="<?echo $fuente_d?>">
              </span></td>
              <td width="45"><span class="Estilo5">
                <input name="catalogo3" type="button" id="catalogo3" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="381"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdes_fuented" type="text" id="txtdes_fuented" size="50" maxlength="50" readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="243" height="26">
                <div align="left"></div></td>
              <td width="75">HASTA : </td>
              <td width="61"><span class="Estilo5">
                <input name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5" value="<?echo $fuente_h?>">
              </span></td>
              <td width="46"><span class="Estilo5">
                <input name="catalogo4" type="button" id="catalogo4" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="381"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="50" maxlength="50" readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="98"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_asig_dis('Rpt_asignacion_distri.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
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