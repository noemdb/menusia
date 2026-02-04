<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$codigo_mov=""; $cod_banco=""; $mcod_m="BAN05L".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $monto_d=0; $monto_h=9999999999.99; $solop="NO";} 
else{ $codigo_mov=$_GET["codigo_mov"];$cod_banco=$_GET["cod_banco"];$referencia=$_GET["referencia"];$tipo_mov=$_GET["tipom"];$fecha=$_GET["fecha"]; $monto_d=$_GET["monto_d"]; $monto_h=$_GET["monto_h"]; $solop=$_GET["solop"];
} echo $fecha;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Seleccionar Movimiento)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_carga_libros.php?codigo_mov=<?echo $codigo_mov?>&cod_banco=<?echo $cod_banco?>&fecha=<?echo $fecha?>&solop=<?echo $solop?>&monto_d=<?echo $monto_d?>&monto_h=<?echo $monto_h?>'; }
function llamar_eliminar(codigo_mov,cod_banco,referencia,tipo_mov,mesc){var murl; var r;
 if (mesc=="00")  { murl="Esta seguro en Eliminar el Movimiento en banco ?";
  r=confirm(murl);
  if(r==true){r=confirm("Esta Realmente seguro en Eliminar el Movimiento en banco ?");
    if(r==true){murl="Delete_carga_mov.php?codigo_mov="+codigo_mov+"&cod_banco="+cod_banco+"&referencia="+referencia+"&tipo_mov="+tipo_mov+"&fecha=<?echo $fecha?>&solop=<?echo $solop?>&monto_d=<?echo $monto_d?>&monto_h=<?echo $monto_h?>"; document.location=murl;} }else { url="Cancelado, no elimino"; }
  }else {alert("Mes no Valido");} 
}
function llamar_modificar(codigo_mov,cod_banco,referencia,tipo_mov,mesc){var murl; var r; var Gfecha_mov=document.form1.txtfecha_mov.value;
 if (mesc=="00")  { murl="Esta seguro en Modificar el Movimiento en banco ?";   r=confirm(murl);
    if(r==true){murl="Update_carga_mov.php?codigo_mov="+codigo_mov+"&cod_banco="+cod_banco+"&referencia="+referencia+"&tipo_mov="+tipo_mov+"&fecha_mov="+Gfecha_mov+"&fecha=<?echo $fecha?>&solop=<?echo $solop?>&monto_d=<?echo $monto_d?>&monto_h=<?echo $monto_h?>"; document.location=murl;} 
  }else {alert("Mes no Valido");} 
}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtmes.value=="99"){Valido=true;}else{alert("Mes no Valido");return false;}
   if(f.txtfecha_mov.value.length==10){Valido=true;} else{alert("Longitud de Fecha Invalida");return false;}    
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;} else{alert("monto debe tener valores numéricos.");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;font-weight: bold;  color: #FFFFFF; }
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $monto=0; $fecha_mov=""; $nomb_benef=""; $mes_c=""; $descripcion="";
$sql="SELECT * FROM carga_libros where codigo_mov='$codigo_mov' and cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $sfecha=$registro["fecha_mov_libro"]; $fecha_mov=substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); 
 $monto=$registro["monto_mov_libro"]; $referencia=$registro["referencia"]; $nomb_benef=$registro["nombre"]; if($nomb_benef==""){$nomb_benef=$registro["campo_str2"];}
 $mes_c=$registro["mes_conciliacion"]; }  $monto=formato_monto($monto); $descripcion=$registro["descrip_mov_libro"];
?>
<body>
<form name="form1" method="post" action="Insert_mov_carga.php" onSubmit="return revisar()">
  <table width="623" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="620" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">SELECCIONAR MOVIMIENTO </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="614" border="0">
              <tr>
                <td width="330"><span class="Estilo5">REFERENCIA : <input class="Estilo10" name="txtreferencia" type="text" id="txtreferencia" size="10" maxlength="8" value="<? echo $referencia ?>" readonly >   </span></td>
                <td width="268"><span class="Estilo5">TIPO DE MOVIMIENTO : <input class="Estilo10" name="txttipo_mov" type="text" id="txttipo_mov" size="4" maxlength="4" value="<? echo $tipo_mov ?>" readonly >  </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="614" border="0">
              <tr>
                <td width="608"><span class="Estilo5">BENEFIACIRIO : <input class="Estilo10" name="txtbeneficiario" type="text" id="txtbeneficiario" size="74" maxlength="250" value="<? echo $nomb_benef ?>" readonly> </span></td>
              </tr>
            </table>   </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="614" border="0">
                <tr>
                  <td width="214"><span class="Estilo5">FECHA : <input class="Estilo10" name="txtfecha_mov" type="text"  id="txtfecha_mov" size="10" maxlength="10" value="<? echo $fecha_mov ?>" onkeyup="mascara(this,'/',patronfecha,true)" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                  <td width="240"><span class="Estilo5">MONTO :  <input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="15" style="text-align:right" maxlength="22" value="<? echo $monto ?>" readonly> </span></td>
				   <td width="160"><span class="Estilo5">MES : <input class="Estilo10" name="txtmes" type="text"  id="txtmes" size="3" maxlength="3" value="<? echo $mes_c ?>" readonly> </span></td>
                </tr>
            </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="10"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="10"><input name="txtcod_banco" type="hidden" id="txtcod_banco" value="<?echo $cod_banco?>"></td>
			<td width="10"><input name="txtfecha" type="hidden" id="txtfecha" value="<?echo $fecha?>"></td>
			<td width="10"><input name="txtmonto_d" type="hidden" id="txtmonto_d" value="<?echo $monto_d?>"></td>
			<td width="10"><input name="txtmonto_h" type="hidden" id="txtmonto_h" value="<?echo $monto_h?>"></td>
			<td width="10"><input name="txtsolop" type="hidden" id="txtsolop" value="<?echo $solop?>"></td>	
			<td width="10"><input name="txtdescripcion" type="hidden" id="txtdescripcion" value="<?echo $descripcion?>"></td>            
            <td width="100" align="center" valign="middle"><input name="Incluir" type="submit" id="Incluir"  value="Incluir"></td>
            <td width="100" align="center"><input name="Modificar" type="button" id="Modificar" value="Modificar" onClick="JavaScript:llamar_modificar('<? echo $codigo_mov; ?>','<? echo $cod_banco; ?>','<? echo $referencia; ?>','<? echo $tipo_mov; ?>','<? echo $mes_c ?>')"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar('<? echo $codigo_mov; ?>','<? echo $cod_banco; ?>','<? echo $referencia; ?>','<? echo $tipo_mov; ?>','<? echo $mes_c ?>')"></td>
            <td width="67">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>