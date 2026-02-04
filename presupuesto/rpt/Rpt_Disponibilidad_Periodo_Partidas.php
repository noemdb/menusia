<?php include ("../../class/seguridad.inc");?>
<?php include ("../../class/conects.php");  include ("../../class/funciones.php"); ?>
<?php include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
 $cod_presup_d="";  $cod_presup_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz"; 
 $cod_fuente_d="";  $cod_fuente_h="zz"; $des_fuente_d=""; $des_fuente_h="";$mostrar_cuentas="";$mes="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Reporte Disponibilidad de Periodo por Partidas)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">

function Llama_Rpt_Disponibilidad_Periodo_Parti(murl){var url;var r;var cuen;
  if(document.form1.opcuentas[0].checked==true){cuen="S";}
  if(document.form1.opcuentas[1].checked==true){cuen="N";}
  r=confirm("Desea Generar el Reporte Disponibilidad de Periodo por Partidas ?");
  if (r==true) {
    url=murl+"?cod_presupd="+document.form1.txtcod_presupd.value+"&cod_presuph="+document.form1.txtcod_presuph.value+"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+"&mes="+document.form1.txt_mes_desde.value+"&mostrar_cuentas="+cuen;
        window.open(url);
  }
}

function Llama_Menu_Rpt(murl){var url;   url="../"+murl; LlamarURL(url);}
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
<?php $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"];} $l=strlen($formato_presup);
$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001 where (length(Cod_Presup)=".$l.")"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}
//$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001"; $resultado=pg_query($sql);
//if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE DISPONIBILIDAD DE PERIODO POR PARTIDA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="642" border="1" id="tablacuerpo">
  <tr>
    <td width="965" height="636">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:609px; z-index:1; top: 71px; left: 16px;">
        <form name="form1" method="get">
           <table width="950" height="603" border="0">
    <tr>
      <td width="958" height="599" align="center" valign="top"><table width="830" height="503" border="0" cellpadding="0" cellspacing="0">
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
              <td width="326" height="26">
                <div align="left">C&Oacute;DIGO PRESUPUESTARIO DESDE : </div></td>
              <td width="221"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcod_presupd" type="text" id="txtcod_presupd" size="30" maxlength="30" value="<?php echo $cod_presup_d?>" onFocus="encender(this); " onBlur="apagar(this);">
              </span></span></td>
              <td width="252"><span class="Estilo5">SIPAP
                <input name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presupd.php?criterio=','SIA','','750','500','true')" value="...">
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
              <td width="98">HASTA :</td>
              <td width="222"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcod_presuph" type="text" id="txtcod_presuph" size="30" maxlength="30" value="<?php echo $cod_presup_h?>" onFocus="encender(this); " onBlur="apagar(this);">
              </span></span></td>
              <td width="266"><span class="Estilo5">SIPAP
                <input name="btCodPre2" type="button" id="btCodPre2" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presuph.php?criterio=','SIA','','750','500','true')" value="...">
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
                <input name="txtcod_fuented" type="text" id="txtcod_fuented" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5" value="<?php echo $cod_fuente_d?>">
              </span></td>
              <td width="45"><span class="Estilo5">SIPAP
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="...">
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
                <input name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5" value="<?php echo $cod_fuente_h?>">>
              </span></td>
              <td width="46"><span class="Estilo5">SIPAP
                <input name="btfuente2" type="button" id="btfuente7" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="381"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="50" maxlength="50" readonly>
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
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="824" border="0">
            <tr>
              <td width="226" height="26">NOMBRE DEL PROGRAMA  : </td>
              <td width="588"><span class="Estilo5">
                <input name="txtced_rif_benef_d2222" type="text" id="txtced_rif_benef_d2222" onFocus="encender(this)" onBlur="apagar(this)" size="85" maxlength="85">
              </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="112">&nbsp;</td>
              <td width="391">ASIGNACI&Oacute;N GLOBAL </td>
              <td width="314">TAMA&Ntilde;O DEL REPORTE </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19"><table width="829" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="144" height="32">&nbsp;</td>
              <td width="330"><table width="115" height="30" border="1">
                  <tr>
                    <td width="111" valign="top"><label>
                      <input name="opimprimir" type="radio" value="S">
            SI </label>
                        <label>
                        <input name="opimprimir" type="radio" value="N" checked>
            NO </label></td>
                  </tr>
              </table></td>
              <td width="345"><table width="243" height="30" border="1">
                  <tr>
                    <td width="233" valign="top"><label>
                      <input name="opimprimir" type="radio" value="S">
            EXTRAOFICIO</label>
                        <label>
                        <input name="opimprimir" type="radio" value="N" checked>
            CARTA</label></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="79">&nbsp;</td>
              <td width="370">MOSTRAR CUENTAS POR PAGAR </td>
              <td width="368">MOSTRAR DETALLES MODIFICACIONES </td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19"><table width="829" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="146" height="32">&nbsp;</td>
              <td width="393"><table width="115" height="30" border="1">
                <tr>
                  <td width="111" valign="top"><label>
                    <input name="opcuentas" type="radio" value="S">
      SI </label>
                      <label>
                      <input name="opcuentas" type="radio" value="N" checked>
      NO </label></td>
                </tr>
              </table></td>
              <td width="280"><table width="115" height="30" border="1">
                <tr>
                  <td width="111" valign="top"><label>
                    <input name="opimprimir" type="radio" value="S">
      SI </label>
                      <label>
                      <input name="opimprimir" type="radio" value="N" checked>
      NO </label></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="91"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Disponibilidad_Periodo_Parti('Rpt_Disponibilidad_Periodo_Parti.php');">
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

<?php  pg_close($conn);?>
