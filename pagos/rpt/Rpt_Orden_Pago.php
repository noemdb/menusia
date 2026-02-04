<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc"); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
$nro_orden_d="";$nro_orden_h="";$documento_causado_d="";$documento_causado_h="";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$cedula_d="";$cedula_h="";$tipo_orden_d="";$tipo_orden_h="";$status_orden="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Reporte Listado Ordenes de Pagos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">

function checkreferenciad(mform){var mref;
   mref=mform.txtnro_orden_d.value;   mref = Rellenarizq(mref,"0",8);  mform.txtnro_orden_d.value=mref;
return true;}
function checkreferenciah(mform){var mref;
   mref=mform.txtnro_orden_h.value;   mref = Rellenarizq(mref,"0",8);  mform.txtnro_orden_h.value=mref;
return true;}
function Llama_Rpt_Orden_Pa(murl){var url;var r;  
  r=confirm("Desea Generar el Reporte Ordenes de Pago?");
  if (r==true) {url=murl+"?txtnro_orden="+document.form1.txtnro_orden_d.value+"&txttipo_causado="+document.form1.txttipo_causado_d.value+"&txtnro_orden_h="+document.form1.txtnro_orden_h.value+"&txttipo_causado_h="+document.form1.txttipo_causado_h.value;
    window.open(url,"Reporte  Ordenes de Pago")
  }
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?php $sql="SELECT MAX(nro_orden) As Max_Nro_Orden, MIN(nro_orden) As Min_Nro_Orden FROM ORD_PAGO";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$nro_orden_d=$registro["min_nro_orden"];$nro_orden_h=$registro["max_nro_orden"];}
$sql="SELECT MAX(tipo_causado) As Max_tipo_causado, MIN(tipo_causado) As Min_tipo_causado FROM pre003 where tipo_causado<>'0000'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$documento_causado_d=$registro["min_tipo_causado"];$documento_causado_h=$registro["max_tipo_causado"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE ORDENES DE PAGO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="223" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="220">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:216px; z-index:1; top: 73px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="220" border="0">
    <tr>
      <td width="958" height="218" align="center" valign="top"><table width="783" height="215" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5"><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="230">&nbsp;</td>
              <td width="248"><span class="Estilo13">DESDE</span></td>
              <td width="279"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5"><table width="776" border="0">
            <tr>
              <td width="221" class="Estilo5" height="26"><div align="left">NUMERO DE ORDEN:</div></td>
              <td width="231"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden_d" type="text" id="txtnro_orden_d" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciad(this.form)" value="<?php echo $nro_orden_d?>" size="15" maxlength="8"></span></td>
              <td width="310"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden_h" type="text" id="txtnro_orden_h" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciah(this.form)" value="<?php echo $nro_orden_h?>" size="15" maxlength="8"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
		  <td width="5"><input class="Estilo10" name="txttipo_causado_d" type="hidden" id="txttipo_causado_d" value="<?php echo $documento_causado_d?>" ></td>
          <td width="5"><input class="Estilo10" name="txttipo_causado_h" type="hidden" id="txttipo_causado_h" value="<?php echo $documento_causado_h?>" ></td>
        </tr>        
		<tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>  
        <tr>
          <td height="24"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Orden_Pa('Rpt_formato_orden.php');">     </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">   </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="38">&nbsp;</td>
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
<?php  pg_close($conn);?>
