<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="03-0000035"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
 $periodo='01';  $vimprimir="S"; $cod_cuenta_d="";$cod_cuenta_h="9-9-999-99-99-9999";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD (Reporte Libro Auxiliar de Tesoreria)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_Lib_aux(murl){var url; var r; var imp;
  
  r=confirm("Desea Generar el Reporte Libro Auxiliar de Tesoreria ?");
  if (r==true) {url=murl+"?periodo="+document.form1.txtperiodo.value+"&cod_cuenta_d="+document.form1.txtCodigo_Cuenta_D.value+"&cod_cuenta_h="+document.form1.txtCodigo_Cuenta_H.value+"&agrupar_dia="+txtagrupar_dia.value; window.open(url,"Reporte Libro Auxiliar de Tesoreria")}
}
function Llama_Menu_Rpt(murl){var url;    url="../"+murl;  LlamarURL(url);}
</script>
</head>
<?
$sql="SELECT MAX(codigo_cuenta) As max_cod_cuenta, MIN(codigo_cuenta) As min_cod_cuenta FROM con001";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cod_cuenta_d=$registro["min_cod_cuenta"];$cod_cuenta_h=$registro["max_cod_cuenta"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LIBRO AUXILIAR DE TESORERIA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="976" height="242" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:957px; height:223px; z-index:1; top: 68px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="207" border="0">
    <tr>
      <td width="958" height="203" align="center" valign="top"><table width="783" border="0" cellspacing="0" cellpadding="0">
        <tr><td colspan="2">&nbsp;</td> </tr>
        <tr>
          <td colspan="2" align="center" ><table width="748" height="21" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="121" align="left"><span class="Estilo5">PERIODO : </span></td>
              <td width="221" align="left"><span class="Estilo5"><select class="Estilo10" name="txtperiodo" size="1" id="txtperiodo">
                    <option selected>01</option> <option>02</option> <option>03</option>
                    <option>04</option> <option>05</option>  <option>06</option>
                    <option>07</option> <option>08</option>  <option>09</option>
                    <option>10</option> <option>11</option> <option>12</option>
                  </select> </span></td>
              <td width="113" align="center"></td>
              <td width="294" align="center"></td>
            </tr>
          </table></td>
        </tr>
       <tr><td colspan="2">&nbsp;</td> </tr>
        <tr>
          <td colspan="2"><table width="748" height="29" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="121" align="left"><span class="Estilo5">CUENTA DESDE :</span></td>
              <td width="221" align="left"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta_D" type="text" id="txtCodigo_Cuenta_D3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cuenta_d?>" size="25" maxlength="24"></span></td>
              <td width="59" align="left"><span class="Estilo5"><input class="Estilo10" name="Catalogo3" type="button" id="Catalogo33" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
              <td width="54" align="left"><span class="Estilo5">HASTA :</span></td>
              <td width="215" align="center"> <div align="left"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta_H" type="text" id="txtCodigo_Cuenta_H2" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cuenta_h?>" size="25" maxlength="24"></span></td>
              <td width="78" align="left"><span class="Estilo5"> <input class="Estilo10" name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesh.php?criterio=','SIA','','750','500','true')" value="...">    </span></td>
            </tr>
          </table></td>
        </tr>
       <tr> <td colspan="2">&nbsp;</td> </tr> <tr>
       <tr>
          <td ><table width="748" height="29" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
			    <td width="121" align="left"><span class="Estilo5">AGRUPAR POR DIA : </span></div></td>
                <td width="627" align="left"><span class="Estilo5"><select class="Estilo10" name="txtagrupar_dia" size="1" id="txtagrupar_dia" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select>  </span></td>
				
              </tr>
            </table></td>
        </tr>
       <tr> <td colspan="2">&nbsp;</td> </tr> <tr>
        <tr> <td colspan="2">&nbsp;</td> </tr>
        <tr>
          <td colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Lib_aux('Rpt_Lib_aux_teso.php');">  </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </div></td>
			</tr>
          </table></td>
        </tr>
        <tr>
          <td height="38" colspan="2">&nbsp;</td>
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
