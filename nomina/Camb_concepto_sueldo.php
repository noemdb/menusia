<?include ("../class/conect.php"); include ("../class/funciones.php");  $fecha_hoy=asigna_fecha_hoy();  $cod_concepto="001";
if (!$_GET){$tipo_nomina="";$cod_sueldo=""; $cod_ret="";} else{$tipo_nomina=$_GET["Gtipo_nomina"];$cod_sueldo=$_GET["Gcod_sueldo"]; $cod_ret=$_GET["Gcod_ret"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Cambiar Sueldo de Trabjadores)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function llamar_anterior(){  window.close(); }

function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txttipo_desde.value==""){alert("Tipo de Nomina no puede estar Vacio");return false;}   
   r=confirm("Desea Actualizar el Concepto Sueldo Sueldo a los Trabajadores Indicados ?"); if(r==true){r=confirm("Esta Realmente Seguro en cambiar el Sueldo a los Trabajadores ?"); if(r==false){return false;}}
 document.form1.submit;
return true;}

</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<? $cod_desde="000000000000000"; $cod_hasta="999999999999999";
?>
<body>
<form name="form1" method="post" action="Update_conc_sueldo.php" onSubmit="return revisar()">
  <table width="580" height="40" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="580" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">ACTUALIZAR CONCEPTO SUELDO DE TRABAJADORES </span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
             <td align="center"><table width="550" border="0">
               <tr>
                 <td width="200"><span class="Estilo5">TIPO DE NOMINA :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txttipo_desde" type="text" id="txttipo_desde" size="3" maxlength="2"  value="<?echo $tipo_nomina?>" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
                 <td width="200"><span class="Estilo5"></span></td>

               </tr>
             </table></td>
        </tr>       
        <tr><td>&nbsp;</td></tr>
      </table>
        <table width="390" align="center">
          <tr>
            <td width="80">&nbsp;</td>
            <td width="80" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="80">&nbsp;</td>
            <td width="80" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:llamar_anterior()"></td>
            <td width="70">&nbsp;</td>
          </tr>
          <tr> <td><p>&nbsp;</p> </td>
        </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>