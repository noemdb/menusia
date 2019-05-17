<?php include ("../class/fun_fechas.php");
if (!$_GET){$nro_requisicion=''; $aprobado_por='';}  else {$nro_requisicion=$_GET["txtnro_requisicion"]; $aprobado_por=$_GET["mnomb"]; }
$fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA COMPRAS,SERVICIOS Y ALMAC&Eacute;N (APROBAR REQUISICION)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefecha(mform){ var mref;var mfec;   mref=mform.txtfecha_aprobada.value;
  if(mform.txtfecha_aprobada.value.length==8){mfec=mref.substring(0,6)+ "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_aprobada.value=mfec;}
return true;}
function revisar(){var f=document.form1; var r;
var Valido=true;
    if(f.txtfecha_aprobada.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtaprobado_por.value==""){alert("Aporbada por no puede estar Vacia"); return false; }
      else{f.txtaprobado_por.value=f.txtaprobado_por.value.toUpperCase();}
    if(f.txtfecha_aprobada.value.length==10){Valido=true;}  else{alert("Longitud de Fecha Invalida");return false;}
    r=confirm("Esta seguro en Aprobar la Requisicion ?");
    if (r==true) {r=confirm("Esta Realmente seguro en Aprobar la Requisicion ?");
      if (r==true) {Valido=true;} else {return false;}  }else {return false;} 
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

<body>
<form name="form1" method="post" action="Update_aprob_req.php" onSubmit="return revisar()">
  <table width="714" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="707" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">APROBAR REQUISICION DE ARTICULOS</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="680" border="0" align="center">
              <tr>
                <td width="160"><span class="Estilo5">FECHA DE APROBACI&Oacute;N: </span></td>
                <td width="270"><span class="Estilo5"><span class="Estilo10">
                  <input name="txtfecha_aprobada" type="text" id="txtfecha_aprobada" size="15" value="<?echo $fecha_hoy?>"  onchange="checkrefecha(this.form)" onFocus="encender(this)" onBlur="apagar(this)"  >
                </span> </span></td>
                <td width="227"><span class="Estilo5">                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="Estilo5"> </span>
                <table width="680" border="0" align="center">
                  <tr>
                    <td width="110"><span class="Estilo5">APROBADA POR : </span></td>
					<td width="495"><span class="Estilo5"><input name="txtaprobado_por" type="text" class="Estilo5" id="txtaprobado_por"  value="<?echo $aprobado_por?>" size="60" maxlength="60" onFocus="encender(this)" onBlur="apagar(this)"></span></td>    
					
                  </tr>
              </table></td>
          </tr>
		  <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
          <td><table width="680" border="0" align="center"> <tr>
            <td width="40"><input name="txtnro_requisicion" type="hidden" id="txtnro_requisicion" value="<?echo $nro_requisicion?>"></td>
          </tr></table></td>
          </tr>          
          <tr>
            <td><table width="660" align="center">
              <tr>
                <td width="182">&nbsp;</td>
                <td width="127" align="center" valign="middle"><input name="Aprobar" type="submit" id="Aprobar"  value="Aprobar"></td>
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