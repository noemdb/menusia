<?php include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();  $tipo_arch_banco='00';
if (!$_GET){$cod_arch_banco="";$pos_campo="001";}else{$cod_arch_banco=$_GET["cod_arch_banco"];$pos_campo=$_GET["pos_campo"];$tipo_arch_banco=$_GET["tipo_arch_banco"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Incluir Detalle Archivo)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_archivo_presta.php?criterio=<?echo $tipo_arch_banco.$cod_arch_banco?>'; }
function apaga_cod_campo(mthis){var mcodigo=document.form1.txtcod_campo.value; var mcod_arch='<?echo $tipo_arch_banco?>';
   mcodigo = Rellenarizq(mcodigo,"0",3); document.form1.txtcod_campo.value=mcodigo;
   apagar(mthis); ajaxSenddoc('GET', 'asigdescampo.php?cod_campo='+mcodigo+'&cod_arch='+mcod_arch, 'dcampo', 'innerHTML');
   ajaxSenddoc('GET', 'asigcarcampo.php?cod_campo='+mcodigo+'&cod_arch='+mcod_arch, 'dcarcampo', 'innerHTML');
return true;}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_campo.value==""){alert("Codigo no puede estar Vacio");return false;}
   if(f.txtpos_campo.value==""){alert("Posicion no puede estar Vacio");return false;}
   if(f.txttipo_campo.value==""){alert("Tipo no puede estar Vacio");return false;}
   if(f.txtcod_campo.value.length==3){valido=true;}else{alert("Longitud C&oacute;digo Campo Invalida");return false;}
   if(f.txtpos_campo.value.length==3){valido=true;}else{alert("Longitud Posicion Campo Invalida");return false;}
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
<form name="form1" method="post" action="Insert_campo_arch_presta.php" onSubmit="return revisar()">
  <table width="832" height="150" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="831" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR CAMPO DEL ARCHIVO</span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="80"><span class="Estilo5">C&Oacute;DIGO:</span> </td>
                <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_campo" type="text" id="txtcod_campo" size="3" maxlength="3" onFocus="encender(this)" onBlur="apaga_cod_campo(this)" > </span></td>
                <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="btcampos" title="Abrir Catalogo Campos"  onClick="VentanaCentrada('Cat_campo_archivos.php?criterio=<?echo $tipo_arch_banco?>','SIA','','750','500','true')" value="..."> </span></td>
                <td width="100"><span class="Estilo5">DESCRIPCION:</span> </td>
                <td width="550"><span class="Estilo5"><div id="dcampo"> <input class="Estilo10" name="txtcar_especial" type="text" id="txtcar_especial" size="90" maxlength="80" readonly> </div></span></td>
              </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><div id="dcarcampo"><table width="830" border="0">
              <tr>
                <td width="40"><span class="Estilo5">TIPO: </span></td>
                <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txttipo_campo" type="text" id="txttipo_campo" size="1" maxlength="1" readonly > </span></td>
                <td width="100"><span class="Estilo5">LONGITUD: </span></td>
                <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtlongitud_campo" type="text" id="txtlongitud_campo" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
                <td width="100"><span class="Estilo5">DECIMALES: </span></td>
                <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtdecimales_campo" type="text" id="txtdecimales_campo" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
                <td width="100"><span class="Estilo5">INICIO: </span></td>
                <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtpos_comienza" type="text" id="txtpos_comienza" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
                <td width="40"><span class="Estilo5">FIN: </span></td>
                <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtpos_finaliza" type="text" id="txtpos_finaliza" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
               </tr>
           </table> </div></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="130"><span class="Estilo5">RELLENA CERO IZQ.: </span></td>
                <td width="60"><span class="Estilo5"><select class="Estilo10" name="txtrellena_ceros_izq" size="1" id="txtrellena_ceros_izq" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="130"><span class="Estilo5">RELLENA CERO DER.: </span></td>
                <td width="70"><span class="Estilo5"><select class="Estilo10" name="txtrellena_ceros_der" size="1" id="txtrellena_ceros_der" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="150"><span class="Estilo5">RELLENA ESPACIO IZQ.: </span></td>
                <td width="70"><span class="Estilo5"><select class="Estilo10" name="txtrellena_espacios_i" size="1" id="txtrellena_espacios_i" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="150"><span class="Estilo5">RELLENA ESPACIO DER: </span></td>
                <td width="70"><span class="Estilo5"><select class="Estilo10" name="txtrellena_espacios_d" size="1" id="txtrellena_espacios_d" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
              </tr>
           </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="130"><span class="Estilo5">ELIMINA CERO IZQ.: </span></td>
                <td width="60"><span class="Estilo5"><select class="Estilo10" name="txtelimina_ceros_izq" size="1" id="txtelimina_ceros_izq" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="130"><span class="Estilo5">ELIMINA CERO DER.: </span></td>
                <td width="70"><span class="Estilo5"><select class="Estilo10" name="txtelimina_ceros_der" size="1" id="txtelimina_ceros_der" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="150"><span class="Estilo5">ELIMINA ESPACIO IZQ.: </span></td>
                <td width="70"><span class="Estilo5"><select class="Estilo10" name="txtelimina_espacios_i" size="1" id="txtelimina_espacios_i" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="150"><span class="Estilo5">ELIMINA ESPACIO DER: </span></td>
                <td width="70"><span class="Estilo5"><select class="Estilo10" name="txtelimina_espacios_d" size="1" id="txtelimina_espacios_d" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
              </tr>
           </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="120"><span class="Estilo5">ELIMINA COMA: </span></td>
                <td width="60"><span class="Estilo5"><select class="Estilo10" name="txtelimina_comas" size="1" id="txtelimina_comas" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="120"><span class="Estilo5">ELIMINA PUNTO: </span></td>
                <td width="80"><span class="Estilo5"><select class="Estilo10" name="txtelimina_puntos" size="1" id="txtelimina_puntos" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="80"><span class="Estilo5">POSICION: </span></td>
                <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtpos_campo" type="text" id="txtpos_campo" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $pos_campo?>" > </span></td>
                <td width="150"><span class="Estilo5">CUERPO DEL ARCHIVO: </span></td>
                <td width="150"><span class="Estilo5"><select class="Estilo10" name="txtstatus2_campo" size="1" id="txtstatus2_campo" onFocus="encender(this)" onBlur="apagar(this)"><option>DETALLE</option> <option>ENCABEZADO</option> <option>PIE PAGINA</option></select> </span></td>
              </tr>
           </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
		<tr>
          <td><table width="830" border="0">
              <tr>
                <td width="180"><span class="Estilo5">CAMBIA PUNTO POR COMA: </span></td>
				<td width="150"><span class="Estilo5"><select class="Estilo10" name="txtstatus3_campo" size="1" id="txtstatus3_campo" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="500"><span class="Estilo5"> </span></td>
              </tr>
           </table></td>
        </tr>
		
        <tr><td><p>&nbsp;</p></td></tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input name="txtcod_arch_banco" type="hidden" id="txtcod_arch_banco" value="<?echo $cod_arch_banco?>"></td>
            <td width="20"><input name="txttipo_arch_banco" type="hidden" id="txttipo_arch_banco" value="<?echo $tipo_arch_banco?>"></td>
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