<?include ("../class/conect.php"); include ("../class/funciones.php");  $fecha_hoy=asigna_fecha_hoy();  $cod_concepto="001";
if (!$_GET){$tipo_nomina="";$cuenta="";} else{$tipo_nomina=$_GET["Gtipo_nomina"];$cuenta=$_GET["Gcuenta"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Cambiar Cuenta de Empresa)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function llamar_anterior(){  window.close(); }
function chequea_banco(mform){
var mref;
   mref=mform.txtcod_new.value;  mref=Rellenarizq(mref,"0",4);  mform.txtcod_new.value=mref;
   ajaxSenddoc('GET', 'nombbanco.php?cod_banco='+mref+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nbanco', 'innerHTML');
   ajaxSenddoc('GET', 'cuentabanco.php?cod_banco='+mref+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'cbanco', 'innerHTML');
 return true;}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcuenta.value==""){alert("Cuenta Actual no puede estar Vacio");return false;}
   if(f.txtcuenta_new.value==""){alert("Cuenta Nueva no puede estar Vacio");return false;}
   if(f.txtcod_new.value==""){alert("Codigo de Banco Nuevo no puede estar Vacio");return false;}
   if(f.txtnombre_banco.value==""){alert("Nombre de Banco Nuevo no puede estar Vacio");return false;}
   if(f.txtcuenta_new.value==f.txtcuenta.value){alert("Numero de Cuentas no pueden ser Iguales");return false;}
   r=confirm("Desea Cambiar el Numero de Cuenta por cual se les paga a los Trabajadores Indicados ?"); if(r==true){r=confirm("Esta Realmente Seguro en cambiar el Numero de Cuenta por cual se les paga a los Trabajadores ?"); if(r==false){return false;}}
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
<form name="form1" method="post" action="Update_cuenta_emp.php" onSubmit="return revisar()">
  <table width="580" height="40" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="580" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CAMBIAR CUENTA BANCARIA DE EMPRESA </span></td>
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
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_desde" type="text" id="txtcod_desde" size="17" maxlength="15"  value="<?echo $cod_desde?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="50"><span class="Estilo5">HASTA :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_hasta" type="text" id="txtcodo_hasta" size="17" maxlength="15"  value="<?echo $cod_hasta?>" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
               </tr>
             </table></td>
        </tr>
        <tr>
          <td align="center"><table width="550" border="0">
              <tr>
                <td width="200" ><span class="Estilo5">NUMERO CUENTA ACTUAL :</span> </td>
                <td width="350"><span class="Estilo5"><input class="Estilo10" name="txtcuenta" type="text" id="txtcuenta" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cuenta;?>"></span></td>
              </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td align="center"><table width="560" border="0">
              <tr>
                <td width="170"><span class="Estilo5"> C&Oacute;DIGO CUENTA NUEVA :</span> </td>
                <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_new" type="text" id="txtcod_new" size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_banco(this.form);"></span></td>
                <td width="330"><span class="Estilo5"><div id="nbanco"><input class="Estilo10" name="txtnombre_banco" type="text" id="txtnombre_banco" size="45" maxlength="100" onFocus="encender(this)" onBlur="apagar(this)"></div> </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center"><table width="560" border="0">
              <tr>
                <td width="170"><span class="Estilo5"> NUMERO CUENTA NUEVA :</span> </td>
                <td width="390"><span class="Estilo5"><div id="cbanco"><input class="Estilo10" name="txtcuenta_new" type="text" id="txtcuenta_new" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)"></div></span></td>
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