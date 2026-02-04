<?php include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$nom_usuario="ADMNISTRADOR";$fecha_d="";$num_expediente_d="0000000000";$num_expediente_h="0000000000";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Reporte )</title>
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

function Llama_Rpt_Cheques_Emitidos_Usua(murl){var url;var r;
  r=confirm("Desea Generar el Reporten Cheques Emitidos por Usuarios?");
  if (r==true){url=murl+"?nom_usuario="+document.form1.txtnomusuario.value+"&fecha_d="+document.form1.selectfecha_emision.value+"&num_expediente_d="+document.form1.txtnumexpediented.value+"&num_expediente_d="+document.form1.txtnumexpedienteh.value;
    window.open(url,"Reporten Cheques Emitidos por Usuarios")}
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
.Estilo13 {
        color: #0000FF;
        font-weight: bold;
}
-->
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE CHEQUES EMITIDOS POR EL USUARIO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="425" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="419">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:394px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="384" border="0">
    <tr>
      <td width="958" height="380" align="center" valign="top"><table width="783" height="362" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="83" height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="674" border="0">
            <tr>
              <td width="96" height="26">                 <div align="left">USUARIO : </div></td><td width="568"><span class="Estilo5">
                <input name="txtnomusuario" type="text" id="txtnomusuario" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $nom_usuario?>" size="25" maxlength="25">
              </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="674" border="0">
            <tr>
              <td width="151" height="26">                <div align="left">FECHA EMISION : </div></td><td width="513"><span class="Estilo5">
                <select name="selectfecha_emision" id="selectfecha_emision">
                  <option>25/02/2008</option>
                </select>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="674" border="0">
            <tr>
              <td width="278" height="26"><div align="right"> </div></td>
              <td width="233"><span class="Estilo13">DESDE</span></td>
              <td width="149"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="775" border="0">
            <tr>
              <td width="235" height="26">                <div align="left">NUMERO DEL EXPEDIENTE : </div></td><td width="245"><span class="Estilo5">
                <input name="txtnumexpediented" type="text" id="txtnumexpediented" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_expediente_d?>" size="25" maxlength="25">
              </span></td>
              <td width="281"><span class="Estilo5">
                <input name="txtnumexpedienteh" type="text" id="txtnumexpedienteh" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_expediente_h?>" size="25" maxlength="25">
              </span></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Cheques_Emitidos_Usua('Rpt_Cheques_Emitidos_Usua.php');">
                      </div></td>
              <td>
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
<?php  pg_close($conn);?>
