<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $cod_presup_d="";  $cod_presup_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz"; 
 $cod_fuente_d="";  $cod_fuente_h="zz"; $des_fuente_d=""; $des_fuente_h="";$mes_desde="";$mes_hasta="";$asig_global="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte Disponibilidad de Periodo por Partida)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>

</head>
<?$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $cant_cat=1; $mdes_cat=array("NINGUNA","","","","","");
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$titulo=$registro["campo525"];$cant_cat=$registro["campo550"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"];

} $l=strlen($formato_presup);


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
$cod_presup_d=str_replace("X","?",$formato_presup); $cod_presup_h=str_replace("X","?",$formato_presup);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE DISPONIBILIDAD DE PERIODO POR PARTIDA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="465" border="1" id="tablacuerpo">
  <tr>
    <td width="965" height="458">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:455px; z-index:1; top: 71px; left: 16px;">
        <form name="form1" method="get">
           <table width="950" height="449" border="0">
    <tr>
      <td width="958" height="445" align="center" valign="top"><table width="830" height="434" border="0" cellpadding="0" cellspacing="0">
		<tr>
          <td width="830" height="19"><table width="766" border="0">
            <tr>
              <td width="325" height="26"><div align="right"> </div></td>
              <td width="223"><span class="Estilo15"><? echo $titulo; ?></span></td>
              <td width="204">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30"><table width="828" border="0">
            <tr>
              <td width="312" height="26"><div align="right"><span class="Estilo5">CODIGO PRESUPUESTARIO DESDE : </span></div></td>
              <td width="491"><span class="Estilo5"><input name="txtcod_presupd" type="text" id="txtcod_presupd" size="30" maxlength="35"  value="<?echo $cod_presup_d?>" onFocus="encender(this); " onBlur="apagar(this);">
                <input name="catalogo1" type="button" id="catalogo1" title="Abrir Catalogo Codigos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presupd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
			  </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30"><table width="828" border="0">
            <tr>
              <td width="312" height="26"><div align="right"><span class="Estilo5">HASTA : </span></div></td>
              <td width="491"><span class="Estilo5"><input name="txtcod_presuph" type="text" id="txtcod_presuph" size="30" maxlength="35"  value="<?echo $cod_presup_h?>" onFocus="encender(this); " onBlur="apagar(this);">
                <input name="catalogo2" type="button" id="catalogo2" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presuph.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="321" align="right"><span class="Estilo5">FUENTE DE FINANCIAMIENTO DESDE : </span></td>
              <td width="62"><span class="Estilo5"><input name="txtcod_fuented" type="text" id="txtcod_fuented" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="2" value="<?echo $cod_fuente_d?>">
              <td width="45"><span class="Estilo5"><input name="catalogo3" type="button" id="catalogo3" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
              <td width="381"><span class="Estilo5"> <input name="txtdes_fuented" type="text" id="txtdes_fuented" size="60" maxlength="60"  value="<?echo $des_fuente_d?>"  readonly></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="243" height="26"></td>
              <td width="75" align="right"><span class="Estilo5">HASTA : </span></td>
              <td width="61"><span class="Estilo5"><input name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="2" value="<?echo $cod_fuente_h?>" ></span></td>
              <td width="46"><span class="Estilo5"><input name="catalogo4" type="button" id="catalogo4" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
              <td width="381"><span class="Estilo5"><input name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="60" maxlength="60"  value="<?echo $des_fuente_h?>"  readonly></span></td>
            </tr>
          </table></td>
        </tr>		
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="213" height="26">
                <div align="left"></div></td>
              <td width="105"><div align="right"><span class="Estilo5">MES DESDE : </span></div></td>
              <td width="160"><span class="Estilo5">
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
                </select>
</span></td>
              <td width="74"><div align="right"><span class="Estilo5">HASTA :  </span></div></td>
              <td width="260"><span class="Estilo5">
                <select name="txt_mes_hasta">
                  <option value="01">ENERO</option>
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
                  <option selected value="12">DICIEMBRE</option>
                </select>
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
              <td width="153">&nbsp;</td>
              <td width="166"><div align="right"><span class="Estilo5">ASIGNACI&Oacute;N GLOBAL :</span></div></td>
			  <td width="505"><table width="115" height="30" border="1">
                <tr>
                  <td width="504" valign="top"><span class="Estilo5">
                    <input name="opasig" type="radio" value="S" checked> SI </span>
                      <span class="Estilo5">
                      <input name="opasig" type="radio" value="N"> NO  </span></td>
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
              <td width="153">&nbsp;</td>
              <td width="166"><div align="right"><span class="Estilo5">SUB-TOTAL POR :</span></div></td>
			  <td width="505"><select name="txtsubtotal" id="txtsubtotal" onFocus="encender(this)" onBlur="apagar(this);"> 
			  <? for ($i=0; $i<=$cant_cat; $i++) {?> <option value="<? echo $i;?>"><? echo $mdes_cat[$i];?></option>
			  <?}?>
			  </td>              
            </tr>
          </table></td>
        </tr>
         <tr>
          <td height="19">&nbsp;</td>
        </tr> 
        <tr>
          <td height="50"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Disponibilidad_Perio('Rpt_Disp_Perio_Par.php');">
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
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_Disponibilidad_Perio(murl){var url;var r;var asig; var s; 
  if(document.form1.opasig[0].checked==true){asig="S";}
  if(document.form1.opasig[1].checked==true){asig="N";}
  s=document.form1.txtsubtotal.value;
  r=confirm("Desea Generar el Reporte Disponibilidad de Periodo?");
  if (r==true) { url=murl+"?cod_presupd="+document.form1.txtcod_presupd.value+"&cod_presuph="+document.form1.txtcod_presuph.value+"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+"&mes_desde="+document.form1.txt_mes_desde.value+"&mes_hasta="+document.form1.txt_mes_hasta.value+"&asig_global="+asig+"&csubtotal="+s;
        window.open(url);
  }
}
function Llama_Menu_Rpt(murl){var url;   url="../"+murl; LlamarURL(url);}
</script>
<? pg_close();?>
