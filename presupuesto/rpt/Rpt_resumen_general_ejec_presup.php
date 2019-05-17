<?include ("../../class/seguridad.inc");?>
<?include ("../../class/conects.php");  include ("../../class/funciones.php"); ?>
<?php include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $cod_presup_cat_d=""; 
 $cod_fuente_d="";  $cod_fuente_h="zz"; $des_fuente_d=""; $des_fuente_h="";$mes=""; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte de Resumen General Ejecucion Presupuestaria)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_resumen_general_ejec_pre(murl){var url;var r;
  r=confirm("Desea Generar el Reporte de Resumen General Ejecucion Presupuestaria?");
  if (r==true) {
    url=murl+"?cod_presup_cat_d="+document.form1.txtcodcategoria_d.value+"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+"&mes="+document.form1.txt_mes_desde.value;
        window.open(url);
  }
}

function Llama_Menu_Rpt(murl){var url;   url="../"+murl; LlamarURL(url);}

</script>

</head>
<?$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"];} $l=strlen($formato_presup);
$sql="Select max(cod_presup_cat) As max_cod_presup_cat, min(cod_presup_cat) As min_cod_presup_cat from pre019"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_cat_d=$registro["min_cod_presup_cat"];}
$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_d'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_d=$registro["des_fuente_financ"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_h'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_h=$registro["des_fuente_financ"];}

?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE ESP. RESUMEN GENERAL EJECUCI&Oacute;N PRESUPUESTARIA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="364" border="1" id="tablacuerpo">
  <tr>
    <td width="992" height="358">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:952px; height:334px; z-index:1; top: 79px; left: 29px;">
        <form name="form1" method="get">
           <table width="950" height="331" border="0">
    <tr>
      <td width="958" height="327" align="center" valign="top"><table width="830" height="322" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="61" height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="610" border="0">
            <tr>
              <td width="188" height="26">
                <div align="left">C&Oacute;DIGO CATEGORIA  : </div></td>
              <td width="148"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcodcategoria_d" type="text" id="txtcodcategoria_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_presup_cat_d?>" size="22" maxlength="22">
              </span></span></td>
              <td width="260"><span class="Estilo5">
                <input name="btCodPre2" type="button" id="btCodPre2" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presup_catd.php?criterio=','SIA','','750','500','true')" value="...">
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
                <input name="txtcod_fuented" type="text" id="txtcod_fuented" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5" value="<?echo $cod_fuente_d?>">
              </span></td>
              <td width="45"><span class="Estilo5">
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="381"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdes_fuented" type="text" id="txtdes_fuented" size="50" maxlength="50" readonly value="<?echo $des_fuente_d?>">
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
                <input name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5" value="<?echo $cod_fuente_h?>">
              </span></td>
              <td width="46"><span class="Estilo5">
                <input name="btfuente2" type="button" id="btfuente7" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="381"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="50" maxlength="50" readonly value="<?echo $des_fuente_h?>">
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
              <td width="318" align="right"><span class="Estilo5">MES HASTA : </span></td>
              <td width="488"><span class="Estilo5">
	         <select name="txt_mes_desde">
                  <option selected value="01">ENERO</option>
                  <option value="02">FEBRERO</option>
                  <option value="03">MARZO</option>
                  <option value="04">ABRIL</option>
                  <option value="05">MAYO</option>
                  <option value="06">JUNIO</option>
                  <option value="07">JULIO</option>
                  <option value="08">AGOSTO</option>
                  <option value="09">SEPTIEMBRE</option>
                  <option value="10">OCTUBRE</option>
                  <option value="11">NOVIEMBRE</option>
                  <option value="12">DICIEMBRE</option>
                </select></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="827" border="0">
            <tr>
              <td width="229" height="26">
                <div align="left">NOMBRE DEL PROGRAMA : </div></td>
              <td width="538"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcodbancoh333" type="text" id="txtcodbancoh333" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_h?>" size="87" maxlength="22">
</span></span></td>
              <td width="14"><span class="Estilo5"> </span></td>
              <td width="13"><span class="Estilo12"><span class="Estilo5">                </span></span></td>
              <td width="11"><span class="Estilo5"> </span></td>
            </tr>
          </table>            </td>
        </tr>
        <tr>
          <td height="60"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_resumen_general_ejec_pre('Rpt_resumen_general_ejec_pre.php');">
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
