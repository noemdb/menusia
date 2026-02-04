<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();  $tipo_arch_banco='96';
if (!$_GET){$cod_arch_banco="";$pos_campo="001";}else{$cod_arch_banco=$_GET["cod_arch_banco"];$pos_campo=$_GET["pos_campo"];$tipo_arch_banco=$_GET["tipo_arch_banco"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Modificar Detalle Archivo Banco)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_archivo_presta.php?criterio=<?echo $tipo_arch_banco.$cod_arch_banco?>'; }
function llamar_eliminar(){var murl; var r;
  murl="Esta seguro en Eliminar el campo del Archivo ?"; r=confirm(murl);
  if(r==true){r=confirm("Esta Realmente seguro en Eliminar campo del Archivo ?");
    if(r==true){murl="Delete_campo_arch_presta.php?cod_arch_banco=<?echo $cod_arch_banco?>&pos_campo=<?echo $pos_campo?>&tipo_arch_banco=<?echo $tipo_arch_banco?>"; document.location=murl;}}  else{url="Cancelado, no elimino";}
}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_campo.value==""){alert("Codigo no puede estar Vacio");return false;}
   if(f.txtpos_campo.value==""){alert("Posicion no puede estar Vacio");return false;}
   if(f.txtcod_campo.value.length==3){valido=true;}else{alert("Longitud Codigo Campo Invalida");return false;}
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
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $observacion="";
$sql="SELECT * FROM nom052 where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco='$cod_arch_banco') and (pos_campo='$pos_campo')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
$longitud_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_comienza=$registro["pos_comienza"]; $pos_finaliza=$registro["pos_finaliza"];
$rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
$elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
$elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"]; $camb_punto_coma=$registro["status3_campo"]; 
}pg_close();
?>
<body>
<form name="form1" method="post" action="Update_campo_arch_presta.php" onSubmit="return revisar()">
  <table width="832" height="150" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="831" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR CAMPO DEL ARCHIVO</span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="80"><span class="Estilo5">C&Oacute;DIGO:</span> </td>
                <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_campo" type="text" id="txtcod_campo" size="3" maxlength="3" readonly value="<?echo $cod_campo?>" > </span></td>
                <td width="100"><span class="Estilo5">DESCRIPCION:</span> </td>
                <td width="550"><span class="Estilo5">
                <? if($cod_campo=='999'){?>
                <input class="Estilo10" name="txtcar_especial" type="text" id="txtcar_especial" size="80" maxlength="80" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $car_especial?>">
                <?}else{?>
                <input class="Estilo10" name="txtcar_especial" type="text" id="txtcar_especial" size="80" maxlength="80" readonly value="<?echo $car_especial?>">
                <?}?>
                </span></td>
              </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><div id="dcarcampo"><table width="830" border="0">
              <tr>
                <td width="40"><span class="Estilo5">TIPO: </span></td>
                <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txttipo_campo" type="text" id="txttipo_campo" size="1" maxlength="1" readonly value="<?echo $tipo_campo?>" > </span></td>
                <td width="100"><span class="Estilo5">LONGITUD: </span></td>
                <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtlongitud_campo" type="text" id="txtlongitud_campo" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $longitud_campo?>" > </span></td>
                <td width="100"><span class="Estilo5">DECIMALES: </span></td>
                <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtdecimales_campo" type="text" id="txtdecimales_campo" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $decimales_campo?>"> </span></td>
                <td width="100"><span class="Estilo5">INICIO: </span></td>
                <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtpos_comienza" type="text" id="txtpos_comienza" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $pos_comienza?>"> </span></td>
                <td width="40"><span class="Estilo5">FIN: </span></td>
                <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtpos_finaliza" type="text" id="txtpos_finaliza" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $pos_finaliza?>"> </span></td>
               </tr>
           </table> </div></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
<script language="JavaScript" type="text/JavaScript">
function asig_rellena_ceros_izq(mvalor){var f=document.form1;  if(mvalor=="N"){document.form1.txtrellena_ceros_izq.options[0].selected = true;}else{document.form1.txtrellena_ceros_izq.options[1].selected = true;}}
function asig_rellena_ceros_der(mvalor){var f=document.form1;  if(mvalor=="N"){document.form1.txtrellena_ceros_der.options[0].selected = true;}else{document.form1.txtrellena_ceros_der.options[1].selected = true;}}
function asig_rellena_espacios_i(mvalor){var f=document.form1;  if(mvalor=="N"){document.form1.txtrellena_espacios_i.options[0].selected = true;}else{document.form1.txtrellena_espacios_i.options[1].selected = true;}}
function asig_rellena_espacios_d(mvalor){var f=document.form1;  if(mvalor=="N"){document.form1.txtrellena_espacios_d.options[0].selected = true;}else{document.form1.txtrellena_espacios_d.options[1].selected = true;}}
</script>
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
<script language="JavaScript" type="text/JavaScript">
asig_rellena_ceros_izq('<?echo $rellena_ceros_izq;?>'); asig_rellena_ceros_der('<?echo $rellena_ceros_der;?>'); asig_rellena_espacios_i('<?echo $rellena_espacios_i;?>'); asig_rellena_espacios_D('<?echo $rellena_espacios_d;?>');
function asig_elimina_ceros_izq(mvalor){var f=document.form1;  if(mvalor=="N"){document.form1.txtelimina_ceros_izq.options[0].selected = true;}else{document.form1.txtelimina_ceros_izq.options[1].selected = true;}}
function asig_elimina_ceros_der(mvalor){var f=document.form1;  if(mvalor=="N"){document.form1.txtelimina_ceros_der.options[0].selected = true;}else{document.form1.txtelimina_ceros_der.options[1].selected = true;}}
function asig_elimina_espacios_i(mvalor){var f=document.form1;  if(mvalor=="N"){document.form1.txtelimina_espacios_i.options[0].selected = true;}else{document.form1.txtelimina_espacios_i.options[1].selected = true;}}
function asig_elimina_espacios_d(mvalor){var f=document.form1;  if(mvalor=="N"){document.form1.txtelimina_espacios_d.options[0].selected = true;}else{document.form1.txtelimina_espacios_d.options[1].selected = true;}}
</script>
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
<script language="JavaScript" type="text/JavaScript">
asig_elimina_ceros_izq('<?echo $elimina_ceros_izq;?>'); asig_elimina_ceros_der('<?echo $elimina_ceros_der;?>'); asig_elimina_espacios_i('<?echo $elimina_espacios_i;?>'); asig_elimina_espacios_d('<?echo $elimina_espacios_d;?>');
function asig_elimina_comas(mvalor){var f=document.form1; if(mvalor=="N"){document.form1.txtelimina_comas.options[0].selected=true;}else{document.form1.txtelimina_comas.options[1].selected=true;}}
function asig_elimina_puntos(mvalor){var f=document.form1; if(mvalor=="N"){document.form1.txtelimina_puntos.options[0].selected=true;}else{document.form1.txtelimina_puntos.options[1].selected=true;}}
function asig_status2_campo(mvalor){var f=document.form1; if(mvalor=="D"){document.form1.txtstatus2_campo.options[0].selected = true;}
    if(mvalor=="E"){document.form1.txtstatus2_campo.options[1].selected = true;} if(mvalor=="P"){document.form1.txtstatus2_campo.options[2].selected = true;}
}</script>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="120"><span class="Estilo5">ELIMINA COMA: </span></td>
                <td width="60"><span class="Estilo5"><select class="Estilo10" name="txtelimina_comas" size="1" id="txtelimina_comas" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="120"><span class="Estilo5">ELIMINA PUNTO: </span></td>
                <td width="80"><span class="Estilo5"><select class="Estilo10" name="txtelimina_puntos" size="1" id="txtelimina_puntos" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="80"><span class="Estilo5">POSICION: </span></td>
                <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtpos_campo" type="text" id="txtpos_campo" size="3" maxlength="3" readonly value="<?echo $pos_campo?>" > </span></td>
                <td width="150"><span class="Estilo5">CUERPO DEL ARCHIVO: </span></td>
                <td width="150"><span class="Estilo5"><select class="Estilo10" name="txtstatus2_campo" size="1" id="txtstatus2_campo" onFocus="encender(this)" onBlur="apagar(this)"><option>DETALLE</option> <option>ENCABEZADO</option> <option>PIE PAGINA</option></select> </span></td>
              </tr>
           </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript"> asig_elimina_comas('<?echo $elimina_comas;?>'); asig_elimina_puntos('<?echo $elimina_puntos;?>'); asig_status2_campo('<?echo $status2_campo;?>');  </script>
        
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
		
<script language="JavaScript" type="text/JavaScript"> 
var mcamb_punto_c='<?echo $camb_punto_coma;?>';  
if(mcamb_punto_c=="N"){document.form1.txtstatus3_campo.options[0].selected=true;}else{document.form1.txtstatus3_campo.options[1].selected=true;}
</script>
 
		
        <tr><td>&nbsp;</td></tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input class="Estilo10" name="txtcod_arch_banco" type="hidden" id="txtcod_arch_banco" value="<?echo $cod_arch_banco?>"></td>
            <td width="20"><input name="txttipo_arch_banco" type="hidden" id="txttipo_arch_banco" value="<?echo $tipo_arch_banco?>"></td>
            <td width="40">&nbsp;</td>
            <td width="120" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="120" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="120" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
            <td width="100">&nbsp;</td>
          </tr>
          <tr><td><p>&nbsp;</p></td></tr>
        </table>
    </tr>
  </table>
</form>
</body>
</html>