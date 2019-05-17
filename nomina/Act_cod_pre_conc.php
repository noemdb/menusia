<?include ("../class/conect.php"); include ("../class/funciones.php");  $fecha_hoy=asigna_fecha_hoy();  $cod_concepto="001";
if (!$_GET){$tipo_nomina="";} else{$tipo_nomina=$_GET["Gtipo_nomina"]; $cod_concepto=$_GET["Gconcepto"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA NOMINA Y PERSONAL (Actualizar Codigos presupuestario de Concepto)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function llamar_anterior(){  window.close(); }
function chequea_banco(mform){var mref;
   mref=mform.txtcod_new.value;  mref=Rellenarizq(mref,"0",4);  mform.txtcod_new.value=mref;
   ajaxSenddoc('GET', 'nombbanco.php?cod_banco='+mref+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nbanco', 'innerHTML');
   ajaxSenddoc('GET', 'cuentabanco.php?cod_banco='+mref+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'cbanco', 'innerHTML');
 return true;}
function revisar(){var f=document.form1; var Valido=true; var r;
   r=confirm("Desea Actualizar Codigos Presupuestarios  ?"); if(r==true){r=confirm("Esta Realmente Seguro en Actualizar Codigos Presupuestarios ?"); if(r==false){return false;}}
 document.form1.submit;
return true;}

</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<? $cod_desde=""; $cod_hasta="zzzzzzzzzzzzzzz"; $conc_desde=""; $conc_hasta="zzz";
?>
<body>
<form name="form1" method="post" action="Update_pre_conc.php" onSubmit="return revisar()">
  <table width="580" height="40" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="580" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">ACTUALIZAR CODIGO PRESUPUESTARIO DE CONCEPTOS ASIGNADOS </span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
             <td align="center"><table width="550" border="0">
               <tr>
                 <td width="200"><span class="Estilo5">TIPO DE NOMINA DESDE :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txttipo_desde" type="text" id="txttipo_desde" size="3" maxlength="2"  value="<?echo $tipo_nomina?>" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
                 <td width="50"><span class="Estilo5">HASTA :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txttipo_hasta" type="text" id="txttipo_hasta" size="3" maxlength="2"  value="<?echo $tipo_nomina?>" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
               </tr>
             </table></td>
        </tr>
        <tr>
             <td align="center"><table width="550" border="0">
               <tr>
                 <td width="200"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR DESDE:</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_desde" type="text" id="txtcod_desde" size="15" maxlength="15"  value="<?echo $cod_desde?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="50"><span class="Estilo5">HASTA :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_hasta" type="text" id="txtcodo_hasta" size="15" maxlength="15"  value="<?echo $cod_hasta?>" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
               </tr>
             </table></td>
        </tr>
        <tr>
             <td align="center"><table width="550" border="0">
               <tr>
                 <td width="200"><span class="Estilo5">C&Oacute;DIGO CONCEPTO DESDE:</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtconc_desde" type="text" id="txtconc_desde" size="5" maxlength="4"  value="<?echo $conc_desde?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="50"><span class="Estilo5">HASTA :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtconc_hasta" type="text" id="txtconc_hasta" size="5" maxlength="4"  value="<?echo $conc_hasta?>" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
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