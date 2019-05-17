<?php include ("../class/fun_fechas.php");  $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){ $referencia_modif='';$tipo_modif=''; $fecha_fin=$fecha_hoy; } else {$referencia_modif=$_GET["txtreferencia_modif"];$tipo_modif=$_GET["txttipo_modif"]; $fec_fin_e=$_GET["fecha_fin"]; $fecha_fin=formato_ddmmaaaa($fec_fin_e);}
if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Anular Modificacion)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript">
</script>
<script language="JavaScript" type="text/JavaScript">
function checkrefecha(mform){var mref;var mfec;
  mref=mform.txtfecha_anu.value;
  if(mform.txtfecha_anu.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_anu.value=mfec;}
return true;}
function revisar(){var f=document.form1; var Valido=true; var r;
    if(f.txtfecha_anu.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtfecha_anu.value.length==10){Valido=true;} else{alert("Longitud de Fecha Invalida");return false;}
	r=confirm("Esta seguro en Anular la Modificacion ?");
    if (r==true) {r=confirm("Esta Realmente seguro en Anular el Modificacion ?");   if (r==true) {Valido=true;} else {return false;}  } else {return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 { font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Anu_modificacion.php" onSubmit="return revisar()">
  <table width="714" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="707" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">ANULAR MODIFICACION </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="680" border="0" align="center">
              <tr>
                <td width="160"><span class="Estilo5">FECHA DE ANULACI&Oacute;N: </span></td>
                <td width="270"><span class="Estilo5"><input class="Estilo10" name="txtfecha_anu" type="text" id="txtfecha_anu" size="15" value="<?echo $fecha_hoy?>"  onchange="checkrefecha(this.form)" onFocus="encender(this)" onBlur="apagar(this)" >   </span> </td>
                <td width="227"><span class="Estilo5"> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>          
          <tr>
            <td width="600" > </td>
            <td width="20"><input class="Estilo10" name="txttipo_modif" type="hidden"  id="txttipo_modif" value="<?echo $tipo_modif?>"></td>
            <td width="96"><input class="Estilo10" name="txtreferencia_modif" type="hidden"  id="txtreferencia_modif" value="<?echo $referencia_modif?>"></td>            
          </tr>
          <tr> <td><span class="Estilo5"> </span>  </td>  </tr>
          <tr>
            <td><table width="660" align="center">
              <tr>
                <td width="182">&nbsp;</td>
                <td width="127" align="center" valign="middle"><input name="Anular" type="submit" id="Anular"  value="Anular"></td>
                <td width="10" align="center">&nbsp;</td>
                <td width="136" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:window.close()"></td>
                <td width="181">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><p>&nbsp;</p></td>
          </tr>
        </table>
       </td>
    </tr>
  </table>
</form>
</body>
</html>