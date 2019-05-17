<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="03-0000157"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$comprobante_d="00000000";$comprobante_h="99999999";$cedula_d="";$cedula_h="";$vurl;
 
 $periodod='2010';$periodoh='01';$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); $fecha_hoy=asigna_fecha_hoy(); 
$periodod=substr($fecha_hoy,6,4);  $periodoh=substr($fecha_hoy,3,2); $fecha_d="01".substr($fecha_hoy,2,8); $fecha_h=colocar_udiames($fecha_hoy);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Listado Relaci&oacute;n Impuesto Retenido)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function apaga_mes(mthis){
var mmes;  var mano; var mdesde; var mhasta; var mdia;
   apagar(mthis); mmes=document.form1.txtmes.value; mmes=Rellenarizq(mmes,"0",2); 
   mdesde=document.form1.txtFechad.value; mano=mdesde.charAt(6)+mdesde.charAt(7)+mdesde.charAt(8)+mdesde.charAt(9);
   mdesde="01/"+mmes+"/"+mano; document.form1.txtFechad.value=mdesde;    
   mhasta=document.form1.txtFechad.value; mano=mhasta.charAt(6)+mhasta.charAt(7)+mhasta.charAt(8)+mhasta.charAt(9);
   mdia="31"; if(mmes=="02"){mdia="28";} if((mmes=="04")||(mmes=="06")||(mmes=="09")||(mmes=="11")){mdia="30";}
   mhasta=mdia+"/"+mmes+"/"+mano; document.form1.txtFechah.value=mhasta;
true;}

function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_Listado_Ret_I(murl){var url;var r; 
   r=confirm("Desea Generar el Reporte Listado Retencion 1_1000 ?");
  if (r==true){url=murl+"?fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&periodod="+document.form1.txtperiodo_d.value+"&mes="+document.form1.txtmes.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Listado Retencion 1_1000")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO RELACI&Oacute;N RETENCION 1_1000 </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="289" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="283">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:256px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="250" border="0">
    <tr>
      <td width="958" height="246" align="center" valign="top"><table width="783" height="236" border="0" cellpadding="0" cellspacing="0">        
		<tr>
		  <td height="19" colspan="4"><table width="776" border="0">
			  <tr>
				<td width="220">&nbsp;</td>
				<td width="243"><span class="Estilo13">DESDE</span></td>
				<td width="323"><span class="Estilo13">HASTA</span></td>
			  </tr>
		  </table></td>
		</tr>
		<tr><td>&nbsp;</td> </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="198" height="26"> <div align="left" class="Estilo5">PERIODO FISCAL A&Ntilde;O: </div></td>
              <td width="223"><span class="Estilo5"><input class="Estilo10" name="txtperiodo_d" type="text" id="txtperiodo_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $periodod?>" size="12" maxlength="10" class="Estilo5"></span></td>
              <td width="52" class="Estilo5">MES : </td>
              <td width="285"><span class="Estilo12"><span class="Estilo5"><input class="Estilo10" name="txtmes" type="text" id="txtmes" onFocus="encender(this)" onBlur="apaga_mes(this)" value="<?echo $periodoh?>" size="3" maxlength="3" class="Estilo5"></span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td> </tr>
        <tr>
          <td height="19"><table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="207" align="center"><div align="left"><p align="left" class="Estilo5"> FECHA  DESDE : </p> </div></td>
              <td width="217" align="center"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)" class="Estilo5">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="70" align="center" class="Estilo5"><div align="left">HASTA :</div></td>
              <td width="289" align="center"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)" class="Estilo5">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td> </tr>
        <tr>
          <td height="18" colspan="3"><table width="783" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="203"><span class="Estilo5">TIPO DE REPORTE :</span></td>
              <td width="220"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt"><option value='PDF'>FORMATO PDF</option></select></span></td>
			  <td width="360"><span class="Estilo5"></span></td>	
			         
            </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td> </tr>
		<tr><td>&nbsp;</td> </tr>
        <tr>
          <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Listado_Ret_I('Rpt_Relacion_ret_1_1000.php');">  </div></td>
              <td><div align="center"> <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
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
