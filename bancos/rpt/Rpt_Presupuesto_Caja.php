<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="03-0000130"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_hoy=asigna_fecha_hoy(); $fecha_h=formato_aaaammdd($fecha_hoy); if($fecha_h>$Fec_Fin_Ejer){$fecha_d=formato_ddmmaaaa($Fec_Fin_Ejer);}else{$fecha_d=$fecha_hoy;} ;$imprimir="N";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Reporte Presupuesto de Caja)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="javascript" src="../../class/sia.js" type="text/javascript"></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
var patronfecha = new Array(2,2,4);
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechad.value=mfec;}
return true;}

function Llama_Rpt_presup_caja(murl){var url;var r;var imp;
  r=confirm("Desea Generar el Reporte Presupuesto de Caja ?");
  if (r==true){url=murl+"?periodo_d="+document.form1.selectperiodo_d.value+"&periodo_h="+document.form1.selectperiodo_h.value;
  window.open(url,"Reporte Presupuesto de Caja")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE PRESUPUESTO DE CAJA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="285" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="279">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:265px; z-index:1; top: 65px; left: 17px;">
        <form name="form1" method="get">
           <table width="950" height="251" border="0">
    <tr>
      <td width="958" height="247" align="center" valign="top"><table width="783" height="231" border="0" cellpadding="0" cellspacing="0">
        <tr> <td height="19">&nbsp;</td>   </tr>
        <tr>
          <td height="19"><table width="783" border="0">
            <tr>
              <td width="247" align="left"><span class="Estilo5">PERIODO DESDE :</span></td>
              <td width="170"><select name="selectperiodo_d" size="1" id="selectperiodo_d" onFocus="encender(this)" onBlur="apaga_periodo_d(this)">
                  <option selected>01</option> <option>02</option> <option>03</option>
                  <option>04</option> <option>05</option> <option>06</option>
                  <option>07</option> <option>08</option> <option>09</option>
                  <option>10</option> <option>11</option> <option>12</option>
              </select></td>
              <td width="107"><span class="Estilo5">HASTA :</span></td>
              <td width="241"><select name="selectperiodo_h" size="1" id="selectperiodo_h" onFocus="encender(this)" onBlur="apaga_periodo_h(this)">
                <option selected>01</option> <option>02</option> <option>03</option>
                <option>04</option> <option>05</option> <option>06</option>
                <option>07</option> <option>08</option> <option>09</option>
                <option>10</option> <option>11</option> <option >12</option>
              </select></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td height="19">&nbsp;</td>   </tr>
        <tr>
          <td height="95"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_presup_caja('Rpt_presup_caja.php');">     </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">   </div></td></tr>
          </table></td>
        </tr>
         <tr> <td height="18" colspan="3">&nbsp;</td>  </tr> 
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
