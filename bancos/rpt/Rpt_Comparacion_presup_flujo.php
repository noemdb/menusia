<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="03-0000130"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
 $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_hoy=asigna_fecha_hoy(); $fecha_h=formato_aaaammdd($fecha_hoy); if($fecha_h>$Fec_Fin_Ejer){$fecha_d=formato_ddmmaaaa($Fec_Fin_Ejer);}else{$fecha_d=$fecha_hoy;} ;$imprimir="N";
$cod_partida_d=""; $cod_partida_h="";
$sql="SELECT MAX(cod_partida) As Max_partida, MIN(cod_partida) As Min_partida FROM ban021 where cod_partida<>''"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cod_partida_d=$registro["min_partida"]; $cod_partida_h=$registro["max_partida"];  }
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Reporte Comparacion Presupuestaria Flujo de Caja)</title>
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

function Llama_Rpt_presup_caja(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Vefificar Gasto de Caja ?");
  if (r==true){url=murl+"?periodo_d="+document.form1.selectperiodo_d.value+"&cod_partida_d="+document.form1.txtcod_partida_d.value+"&cod_partida_h="+document.form1.txtcod_partida_h.value;
  window.open(url,"Reporte Comparacion Flujo de Caja")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE COMPARACION PRESUPUESTARIO FLUJO DE CAJA </div></td>
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
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="179" align="left"><span class="Estilo5">PERIODO DESDE :</span></td>
              <td width="253"><select name="selectperiodo_d" size="1" id="selectperiodo_d" onFocus="encender(this)" onBlur="apaga_periodo_d(this)">
                  <option selected>01</option> <option>02</option> <option>03</option>
                  <option>04</option> <option>05</option> <option>06</option>
                  <option>07</option> <option>08</option> <option>09</option>
                  <option>10</option> <option>11</option> <option>12</option>
              </select></td>
              <td width="322"><span class="Estilo5"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td height="19">&nbsp;</td>   </tr>
		 <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="179" height="26"><div align="left"><span class="Estilo5">CODIGO PARTIDA : </span></div></td>
              <td width="253"><span class="Estilo5"><input name="txtcod_partida_d" type="text" id="txtcod_partida_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_partida_d?>" size="30" maxlength="25" class="Estilo5"> </span></td>
              <td width="43"></td>
              <td width="235"><span class="Estilo5"><input name="txtcod_partida_h" type="text" id="txtcod_partida_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_partida_h?>" size="30" maxlength="25" class="Estilo5"> </span></td>
              <td width="44"></td>
            </tr>
          </table></td>
        </tr>
		<tr> <td height="19">&nbsp;</td>   </tr>
        <tr>
          <td height="95"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_presup_caja('Rpt_comp_pre_flujo.php');">     </div></td>
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
