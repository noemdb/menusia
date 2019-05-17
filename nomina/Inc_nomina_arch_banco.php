<?php include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();  $tipo_arch_banco='00';
if (!$_GET){$criterio="";}else{$criterio=$_GET["criterio"];}  
$tipo_arch_banco=substr($criterio,0,2); $cod_arch_banco=substr($criterio,2,6);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Incluir Detalle Archivo Banco)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_nomina_arch_banco.php?criterio=<?echo $criterio?>'; }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacio");return false;}
   if(f.txtdes_nomina.value==""){alert("Descripcion no puede estar Vacio");return false;}
   if(f.txttipo_nomina.value.length==2){valido=true;}else{alert("Longitud Tipo de Nomina Invalida");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Insert_nom_arch_banco.php" onSubmit="return revisar()">
  <table width="740" height="150" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="739" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR NOMINAS AL ARCHIVO</span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
             <td><table width="738">
                 <tr>
                   <td width="130"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="60"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="4" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_tipo(this.form);"> </span></td>
                   <td width="540"><input class="Estilo10" name="bttiponom" type="button" id="bttiponom" title="Abrir Catalogo Tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                     </tr>
             </table></td>
           </tr>
        <tr>
          <td><table width="738" border="0">
              <tr>
                <td width="100"><span class="Estilo5">DENOMINACION:</span> </td>
                <td width="630"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="100" maxlength="100" readonly > </span></td>
              </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><p>&nbsp;</p></td></tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input class="Estilo10" name="txtcod_arch_banco" type="hidden" id="txtcod_arch_banco" value="<?echo $cod_arch_banco?>"></td>
            <td width="20"><input class="Estilo10" name="txttipo_arch_banco" type="hidden" id="txttipo_arch_banco" value="<?echo $tipo_arch_banco?>"></td>
            <td width="80">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="120">&nbsp;</td>
          </tr>
          <tr><td><p>&nbsp;</p></td></tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>