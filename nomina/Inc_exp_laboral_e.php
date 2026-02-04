<?php include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$mcod_m="NOM053".$equipo;$codigo_mov=substr($mcod_m,0,49);}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Incluir Experencia Laboral)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_exp_laboral_e.php?codigo_mov=<?echo $codigo_mov?>'; }
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtfecha_desde.value==""){alert("Fecha desde no puede estar Vacio");return false;}
   if(f.txtfecha_desde.value==""){alert("Fecha hasta no puede estar Vacio");return false;}
   if(f.txtempresa.value==""){alert("empresa no puede estar Vacio");return false;}else{f.txtempresa.value=f.txtempresa.value.toUpperCase();}
   if(f.txtdepartamento.value==""){alert("Nombre del departamento no puede estar Vacio");return false;}else{f.txtdepartamento.value=f.txtdepartamento.value.toUpperCase();}
   if(f.txtcargo.value==""){alert("Cargo no puede estar Vacio");return false;}else{f.txtcargo.value=f.txtcargo.value.toUpperCase();}
   if(f.txtsueldo.value==""){alert("Sueldo no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Insert_exp_laboral_e.php" onSubmit="return revisar()">
  <table width="661" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="660" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR EXPERINCIA LABORAL </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="133"><span class="Estilo5"> FECHA DESDE :</span> </td>
                <td width="200"><span class="Estilo5"><input name="txtfecha_desde" type="text" id="txtfecha_desde" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>"></span></td>
                <td width="127"><span class="Estilo5"> FECHA HASTA :</span> </td>
                <td width="200"><span class="Estilo5"><input name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>"></span></td>

               </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="133"><span class="Estilo5">NOMBRE EMPRESA : </span></td>
                <td width="527"><span class="Estilo5"><input name="txtempresa" type="text" id="txtempresa" size="75" maxlength="100" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="133"><span class="Estilo5">DEPARTAMENTO : </span></td>
                <td width="527"><span class="Estilo5"><input name="txtdepartamento" type="text" id="txtdepartamento" size="75" maxlength="100" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="133"><span class="Estilo5">ULTIMO CARGO : </span></td>
                <td width="527"><span class="Estilo5"><input name="txtcargo" type="text" id="txtcargo" size="75" maxlength="100" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="133"><span class="Estilo5">ULTIMO SUELDO : </span></td>
                <td width="527"><span class="Estilo5"><input name="txtsueldo" type="text" id="txtsueldo" size="15" maxlength="15" align="right" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><p>&nbsp;</p> </td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>