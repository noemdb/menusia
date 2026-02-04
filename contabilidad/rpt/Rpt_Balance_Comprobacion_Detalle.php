<?php include ("../../class/seguridad.inc");?>
<?php include ("../../class/conects.php");  include ("../../class/funciones.php"); ?>
<?php include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$codigocuentad="";$codigocuentah="9-9-999-99-99-9999";$periodo="";$nivel="";$vimprimir="S";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD (Reporte Balance de Comprobacion (Detalle))</title>
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
function Llama_Rpt_Balance_Comprobacion_Deta(murl){var url;var r;var st;
  if(document.form1.opcomprob[0].checked==true){st="S";}
  if(document.form1.opcomprob[1].checked==true){st="N";}
  r=confirm("Desea Generar el Reporte Comprobacion Detalle?");
  if (r==true) {url=murl+"?codigocuentad="+document.form1.txtCodigo_Cuenta_D.value+"&codigocuentah="+document.form1.txtCodigo_Cuenta_H.value+"&periodo="+document.form1.txtperiodo.value+"&nivel="+document.form1.txtnivel.value+"&vimprimir="+st;
    window.open(url,"Reporte Comprobacion Detalle")
  }
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<?php 
$sql="SELECT MAX(Referencia) As Max_Referencia, MIN(Referencia) As Min_Referencia,MAX(Tipo_Asiento) As Max_Tipo,MIN(Tipo_Asiento) As Min_Tipo FROM CON002";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{$encontro=false;}
if($encontro=true){$referencia_d=$registro["min_referencia"];$referencia_h=$registro["max_referencia"];$tipo_asiento_d=$registro["min_tipo"];$tipo_asiento_h=$registro["max_tipo"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE BALANCE DE COMPROBACION (DETALLE) </div></td>
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
          <td colspan="3" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><div align="right">
            <blockquote>
              <p>DESDE</p>
            </blockquote>
          </div></td>
          <td><blockquote>
            <p>HASTA</p>
          </blockquote></td>
        </tr>
        <tr>
          <td>
            <div align="left">
              <blockquote>
                <p align="left">CODIGO CUENTA :</p>
              </blockquote>
            </div>
                  </td>
          <td><span class="Estilo5">
          <input name="txtCodigo_Cuenta_D" type="text" id="txtCodigo_Cuenta_D" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="32">
          <input name="Catalogo1" type="button" id="Catalogo223" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIPAP','','750','500','true')" value="...">
          </span></td>
          <td><span class="Estilo5">
            <input name="txtCodigo_Cuenta_H" type="text" id="txtCodigo_Cuenta_H" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="32" value="<?php echo $codigocuentah?>">
            <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesh.php?criterio=','SIPAP','','750','500','true')" value="...">
                  </span></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="305"> <div align="left">
            <blockquote>
              <p align="left">PERIODO:</p>
            </blockquote>
          </div></td>
          <td width="185"><select name="txtperiodo" size="1" id="txtperiodo">
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
          <td>IMPRIMIR CUENTAS SIN MOVIMIENTOS:</td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>
            <div align="left">
              <blockquote>
                <p align="left">NIVEL PARA EL REPORTE :</p>
              </blockquote>
          </div></td>
          <td><select name="txtnivel" size="1" id="txtnivel">
            <option selected>01</option>
            <option>02</option>
            <option>03</option>
            <option>04</option>
            <option>05</option>
            <option>06</option>
            <option>07</option>
          </select></td>
          <td><table width="144" height="46" border="1">
            <tr>
              <td width="134" height="40" valign="top">
                          <label>
                <input type="radio" name="opcomprob" value="A">
                      SI</label>
              <label>
                <input type="radio" name="opcomprob" value="D">
            NO</label>
                  <br>                  <label>
                  </label><label></label>              </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" valign="top"><div align="right"><span class="Estilo5">
          </span></div></td>
          <td width="293" valign="top"><span class="Estilo5">
          </span></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Balance_Comprobacion_Deta('Rpt_Balance_Comprobacion_Deta.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="38" colspan="3">&nbsp;</td>
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
<?php  pg_close();?>
