<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="03-0000201"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}

$cedula_d="";$cedula_h="";$sexo="";$estado_civil="";;$fecha_d="01/01/1900";$fecha_h="31/12/9999";$edad_d="0";$edad_h="99";$profesion="TODAS";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Reportes Maestro Elegibles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
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
function Llama_Rpt_ma_ele_me(murl){var url;var r;
   r=confirm("Desea Generar el Reporte Maestro Elegibles?");
  if (r==true){url=murl+"?cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&sexo="+document.form1.txt_sexo.value+"&estado_civil="+document.form1.txt_edocivil.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&edad_d="+document.form1.txtedad_d.value+"&edad_h="+document.form1.txtedad_h.value+"&profesion="+document.form1.txtprofesion.value;
  window.open(url,"Reporte Maestro Elegibles")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<?
$nombre_d="";$nombre_h="";
$sql="SELECT MAX(cedula) As Max_cedula, MIN(cedula) As Min_cedula FROM NOM053";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cedula_d=$registro["min_cedula"];$cedula_h=$registro["max_cedula"];}
?>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE MAESTROS DE ELEGIBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="325" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="319">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:309px; z-index:1; top: 73px; left: 19px;">
        <form name="form1" method="get">
           <table width="950" height="287" border="0">
    <tr>
      <td width="958" height="283" align="center" valign="top"><table width="783" height="264" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="18" colspan="8" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="8" align="center"><table width="905">
            <tr>
              <td width="180" ><div align="right"><span class="Estilo5">CEDULA TRABAJADOR DESDE:</span></div></td>
              <td width="94" ><div align="left"><span class="Estilo5"> <input name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cedula_d?>">    </div></td>
              <td width="171" ><span class="Estilo5"><input class="Estilo10" name="Catalogo5" type="button" id="Catalogo55" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedula_re_d.php?criterio=','SIA','','650','500','true')" value="...">   </td>
              <td width="56" class="Estilo5" >HASTA : </td>
              <td width="94" ><span class="Estilo5"><input class="Estilo10" name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cedula_h?>">    </td>
              <td width="282" ><span class="Estilo5"><input class="Estilo10" name="Catalogo6" type="button" id="Catalogo64" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedula_re_h.php?criterio=','SIA','','650','500','true')" value="...">  </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="8">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="8" align="center"><table width="906">
            <tr>
              <td width="181" ><div align="right"><span class="Estilo5">SEXO :</span></div></td>
              <td width="226" ><div align="left"><span class="Estilo5"> <select class="Estilo10" name="txt_sexo">
                    <option value="TODOS">TODOS</option>
                    <option value="MASCULINO">MASCULINO</option>
                    <option value="FEMENINO">FEMENINO</option>
                  </select>
              </div></td>
              <td width="99" ><span class="Estilo5">ESTADO CIVIL :</span></td>
              <td width="291" ><span class="Estilo5"><select class="Estilo10" name="txt_edocivil">
                  <option value="TODOS">TODOS</option>
                  <option value="SOLTERO">SOLTERO</option>
                  <option value="CASADO">CASADO</option>
                  <option value="VIUDO">VIUDO</option>
                  <option value="DIVORCIADO">DIVORCIADO</option>
                  <option value="OTROS">OTROS</option>
                </select>
              </td>
              <td width="85" >&nbsp;</td>
            </tr>
          </table></td>
        </tr>
                <tr>
          <td height="18" colspan="8">&nbsp;</td>
        </tr>
        <tr>
          <td height="22" colspan="8"><table width="905">
            <tr>
              <td width="182" ><div align="right"><span class="Estilo5">FECHA NACIMIENTO DESDE :</span></div></td>
              <td width="269" ><div align="left"><span class="Estilo5"> <input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></div></td>
              <td width="56" ><span class="Estilo5">HASTA :</span></td>
              <td width="378" ><span class="Estilo5">  <input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  />  </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="8">&nbsp;</td>
        </tr>
        <tr>
          <td width="15" height="18"><div align="center" class="Estilo5">
            <div align="center"></div>
          </div></td>
          <td width="10">&nbsp;</td>
          <td width="8">&nbsp;</td>
          <td width="6">&nbsp;</td>
          <td height="18" class="Estilo5">EDAD:</td>
          <td width="339"><span class="Estilo5"><input class="Estilo10" name="txtedad_d" type="text" id="txtedad_d" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $edad_d?>">
          </span></td>
          <td width="116"><span class="Estilo5"><input class="Estilo10" name="txtedad_h" type="text" id="txtedad_h" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $edad_h?>">
          </span></td>
          <td width="266">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="8">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="4">&nbsp;</td>
          <td width="146" class="Estilo5">PROFESION:</td>
          <td height="18"><span class="Estilo5"><input class="Estilo10" name="txtprofesion" type="text" id="txtprofesion" onFocus="encender(this)" onBlur="apagar(this)" size="40" maxlength="60" value="<?echo $profesion?>"> </span></td>
          <td height="18">&nbsp;</td>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="8">&nbsp;</td>
        </tr>
        <tr>
          <td height="24" colspan="8"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_ma_ele_me('Rpt_ma_ele_me.php');">  </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('Menu.php');">   </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="38" colspan="8">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
      </div>
    <div align="left"></div></td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
