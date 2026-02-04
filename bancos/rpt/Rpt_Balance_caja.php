<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="03-0000200"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
 $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_hoy=asigna_fecha_hoy(); $fecha_h=formato_aaaammdd($fecha_hoy); if($fecha_h>$Fec_Fin_Ejer){$fecha_d=formato_ddmmaaaa($Fec_Fin_Ejer);}else{$fecha_d=$fecha_hoy;} ;$imprimir="N";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Reporte Depositos Bancarios)</title>
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

function Llama_Rpt_Dep_Banca(murl){var url;var r;var imp;
  if(document.form1.opimprimir[0].checked==true){imp="S";}
  if(document.form1.opimprimir[1].checked==true){imp="N";}
  r=confirm("Desea Generar el Reporte Depositos Bancarios?");
  if (r==true){url=murl+"?cod_banco_d="+document.form1.txtcod_banco_d.value+"&cod_banco_h="+document.form1.txtcod_banco_h.value+"&fecha_d="+document.form1.txtFechad.value+"&imprimir="+imp+"&tipo_rep="+document.form1.tipo_rep.value;
  window.open(url,"Reporte Depositos Bancarios")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?php  $cod_banco_d=""; $cod_banco_h="zzzz";
$sql="SELECT MAX(cod_banco) As Max_cod_banco, MIN(cod_banco) As Min_cod_banco FROM BAN002";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cod_banco_d=$registro["min_cod_banco"];$cod_banco_h=$registro["max_cod_banco"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE BALANCE DE CAJA </div></td>
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
          <td height="19"><table width="775" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="155"><span class="Estilo5">FECHA BALANCE: </span></td>
              <td width="610"><span class="Estilo5"><input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10"  class="Estilo5" onChange="checkrefechad(this.form)" onkeyup="mascara(this,'/',patronfecha,true)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"   onClick="javascript:showCal('Calendario1')"  /></span></td>
              <td width="5"><input name="txtcod_banco_d" type="hidden" id="txtcod_banco_d" value="<?php echo $cod_banco_d?>" ></td>
              <td width="5"><input name="txtcod_banco_h" type="hidden" id="txtcod_banco_h" value="<?php echo $cod_banco_h?>" ></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td height="19">&nbsp;</td>   </tr>
        <tr>
          <td height="19"><table width="775" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="275"><span class="Estilo5">IMPRIME CUENTAS CON SALDO EN CERO: </span></td>
               <td width="500"><table width="116" height="30" border="1">
                <tr>
                  <td width="250" valign="top"><label>
                    <input name="opimprimir" type="radio" value="S"  checked>
                    <span class="Estilo5"> SI </span></label>
                      <label>
                      <input name="opimprimir" type="radio" value="N">
                      <span class="Estilo5"> NO </span></label></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
		<tr> <td height="18" colspan="3">&nbsp;</td>  </tr> 
		<tr>
		  <td height="19"><table width="775" border="0">
			  <tr>
				<td width="155" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="620"><span class="Estilo5"> <select name="tipo_rep" id="tipo_rep">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option> </select>
				</span></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rep.options[1].selected = true;}else{document.form1.tipo_rep.options[0].selected = true;} </script>
        <tr> <td height="18" colspan="3">&nbsp;</td>  </tr> 
        <tr>
          <td height="95"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Dep_Banca('Rpt_Bal_caja.php');">     </div></td>
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
<?php  pg_close($conn);?>
