<?php include ("../class/fun_fechas.php"); 
if (!$_GET){$ced_rif=''; $nombre='';}  else {$ced_rif=$_GET["Gced_rif"]; $nombre=$_GET["Gnombre"];} $fecha_hoy=asigna_fecha_hoy();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (CAMBIAR CEDULA/RIF BENEFICIARIO)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){var f=document.form1; var r; var Valido=true;
    if(f.txtced_rif.value==""){alert("Cedula/Rif Actual no puede estar Vacia");return false;}
    if(f.txtced_new.value==""){alert("Cedula/Rif Nuevo no puede estar Vacia"); return false; } else{f.txtced_new.value=f.txtced_new.value.toUpperCase();}
    if(f.txtced_rif.value==f.txtced_new.value){alert("Cedula/Rif no puede ser la misma");return false;} 	
	r=confirm("Esta seguro en Cambiar la Cedula/Rif del Beneficiario ?");
    if (r==true) {r=confirm("Esta Realmente seguro en Cambiar la Cedula/Rif del Beneficiario ?");
      if (r==true) {Valido=true;} else {return false;}  } else {return false;} 
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Update_camb_cedrif.php" onSubmit="return revisar()">
  <table width="714" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="707" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CAMBIAR CEDULA/RIF BENEFICIARIO </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="680" border="0" align="center">
              <tr>
                <td width="160"><span class="Estilo5">CEDULA/RIF ACTUAL: </span></td>
                <td width="270"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" value="<?echo $ced_rif?>"  readonly  >   </span> </td>
                <td width="227"><span class="Estilo5"> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
             <td><table width="680" border="0" align="center">
               <tr>
                 <td width="80"><span class="Estilo5">NOMBRE :</span></td>
                 <td width="577"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="90" readonly>   </tr>
             </table></td>
           </tr>
		  <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="680" border="0" align="center">
              <tr>
                <td width="160"><span class="Estilo5">CEDULA/RIF NUEVO: </span></td>
                <td width="270"><span class="Estilo5"> <input class="Estilo10" name="txtced_new" type="text" id="txtced_new" size="15"   onFocus="encender(this)" onBlur="apagar(this)"  >  </span> </td>
                <td width="227"><span class="Estilo5"> </span></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
            <td><p>&nbsp;</p></td>
          </tr>          	  
          <tr>
            <td><table width="660" align="center">
              <tr>
                <td width="182">&nbsp;</td>
                <td width="127" align="center" valign="middle"><input name="Cambiar" type="submit" id="Cambiar"  value="Cambiar"></td>
                <td width="10" align="center">&nbsp;</td>
                <td width="136" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:window.close()"></td>
                <td width="181">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>	
        </table>
          </td>
    </tr>
  </table>
</form>
</body>
</html>