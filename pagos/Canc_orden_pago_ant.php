<? include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$nro_orden='';$tipo_causado='';}  else {$nro_orden=$_GET["txtnro_orden"];$tipo_causado=$_GET["txttipo_causado"];  }
$fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (REGISTRAR CANCELACION ORDENES DE PAGO)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefecha(mform){var mref; var mfec;
  mref=mform.txtfecha_anu.value;
  if(mform.txtfecha_anu.value.length==8){mfec=mref.substring(0,6)+ "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_anu.value=mfec;}
return true;}
function revisar(){var f=document.form1; var r; var Valido=true;
    if(f.txtfecha_anu.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtdescrip_anu.value==""){alert("Descripción de Anulación no puede estar Vacia"); return false; }
      else{f.txtdescrip_anu.value=f.txtdescrip_anu.value.toUpperCase();}
    if(f.txtfecha_anu.value.length==10){Valido=true;}  else{alert("Longitud de Fecha Invalida");return false;}
    r=confirm("Esta seguro en Anular la Orden de Pago ?");
    if (r==true) {r=confirm("Esta Realmente seguro en Anular la Orden de Pago ?");
      if (r==true) {Valido=true;} else {return false;}  }
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo10 {font-size: 10px}
.Estilo5 {font-size: 12px}
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<? $conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$fecha=""; $mstatus_ord=""; $concepto="";   $inf_usuario="";    $ced_rif="";   $nombre="";  $cod_banco="";  $nombre_cuenta="";  $nombre_banco="";  $fecha_c=""; $nro_cheque="";
$sql="Select * from ORD_PAGO_ANT where tipo_causado='$tipo_causado' and nro_orden='$nro_orden'"; $res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>0){$registro=pg_fetch_array($res);
  $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $mstatus_ord=$registro["status"];
  $concepto=$registro["concepto"];   $inf_usuario=$registro["inf_usuario"];    $ced_rif=$registro["ced_rif"];   $nombre=$registro["nombre"]; 
  $cod_banco=$registro["cod_banco"];  $nombre_cuenta=$registro["nombre_cuenta"];  $nombre_banco=$registro["nombre_banco"]; 
  $fecha_c=$registro["fecha_cheque"]; $nro_cheque=$registro["nro_cheque"]; $fecha_c=formato_ddmmaaaa($fecha_c); $fecha=formato_ddmmaaaa($fecha);
} 
if($mstatus_ord=="I"){$st_orden="CANCELADA";}  else {$st_orden="PENDIENTE"; $cod_banco="";  $nombre_cuenta="";  $nombre_banco="";   $fecha_c=$fecha_hoy; $nro_cheque=""; }
pg_close();
?>
<body>
<form name="form1" method="post" action="Update_canc_orden_ant.php" onSubmit="return revisar()">
  <table width="714" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="707" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">REGISTRAR CANCELACION ORDEN DE PAGO </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
		  
			<tr>
			  <td><table width="680" border="0" align="center">
				  <tr>
					<td width="102"><p><span class="Estilo5">N&Uacute;MERO ORDEN:</span></p></td>
					<td width="118"><input name="txtnro_orden" type="text"  id="txtnro_orden" value="<?echo $nro_orden?>" size="12" readonly></td>
					<td width="50"><input name="txttipo_causado" type="hidden" id="txttipo_causado" value="<?echo $tipo_causado?>"></td>
					<td width="80"><span class="Estilo5">ESTATUS : </span></td>
					<td width="120"><span class="Estilo5"><input name="txtst_orden" type="text"  id="txtst_orden" value="<?echo $st_orden?>" size="12" readonly></span> </td>
					 <td width="60"><span class="Estilo5">FECHA :</span> </td>
					 <td width="120"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" value="<?echo $fecha?>" size="12" readonly> </span></td>
				   </tr>
			  </table></td>
			</tr>
          <tr>
            <td><table width="680" border="0" align="center">
              <tr>
                <td width="160"><span class="Estilo5">FECHA DE CANCELACI&Oacute;N: </span></td>
                <td width="120"><span class="Estilo5"><input name="txtfecha_canc" type="text" id="txtfecha_canc" size="12" value="<?echo $fecha_c?>"  onchange="checkrefecha(this.form)" onFocus="encender(this)" onBlur="apagar(this)">       </span> </td>
				<td width="150"><p><span class="Estilo5">N&Uacute;MERO DE CHEQUE:</span></p></td>
				<td width="150"><span class="Estilo5"><input name="txtnro_cheque" type="text"  id="txtnro_cheque"  value="<?echo $nro_cheque?>"  size="10" maxlength="8" onFocus="encender(this)" onBlur="apaga_referencia(this)"> </span></td>
               </tr>
            </table></td>
          </tr>
		  
		   <tr>
            <td><table width="680" border="0" align="center">
              <tr>
                <td width="130"><p><span class="Estilo5">CODIGO DE BANCO:</span></p></td>
				<td width="100"><span class="Estilo5"> <input name="txtcod_banco" type="text" id="txtcod_banco"   value="<?echo $cod_banco?>" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apaga_banco(this)" onchange="chequea_banco(this.form);">  </span> </td>
                <td width="450"><span class="Estilo5">  <input name="txtnombre_banco" type="text"  id="txtnombre_banco"  value="<?echo $nombre_banco?>"  size="50" maxlength="50" readonly></span></td>
               </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="660" align="center">
              <tr>
                <td width="182">&nbsp;</td>
                <td width="127" align="center" valign="middle"><input name="Registrar" type="submit" id="Registrar"  value="Registrar"></td>
                <td width="10" align="center">&nbsp;</td>
                <td width="136" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:window.close()"></td>
                <td width="181">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><p>&nbsp;</p>
          </tr>
        </table>
          </td>
    </tr>
  </table>
</form>
</body>
</html>