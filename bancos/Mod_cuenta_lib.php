<?include ("../class/conect.php");  include ("../class/funciones.php");
$equipo=getenv("COMPUTERNAME");
if (!$_GET){$cod_cuenta=""; $debito_credito="D";$mcod_m="BAN0062".$equipo;$codigo_mov=substr($mcod_m,0,49);} else{ $cod_cuenta=$_GET["cuenta"];$debito_credito=$_GET["deb_cred"];$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Modificar Cuenta del Movimiento Libro)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_comp_libro.php?codigo_mov=<?echo $codigo_mov?>'; }
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function llamar_eliminar(codigo_mov,codigo,dc){var murl;  var r;
 if (codigo=="") {alert("Codigo debe ser Seleccionado");} else { murl="Esta seguro en Eliminar el Codigo:"+codigo+" D/C:"+dc+" de la Orden ?";
  r=confirm(murl);
  if(r==true){r=confirm("Esta Realmente seguro en Eliminar el Codigo de Cuenta de la orden ?");
    if(r==true){murl="Delete_cuenta_libro.php?codigo_mov="+codigo_mov+"&cod_cuenta="+codigo+"&debito_credito="+dc; document.location=murl;} }else { url="Cancelado, no elimino"; }
  }
}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
 return true;}
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtCodigo_Cuenta.value==""){alert("Codigo de Cuenta no puede estar Vacio");return false;}
   if(f.txtDeb_Cre.value=="D" || f.txtDeb_Cre.value=="C") {Valido=true;} else{alert("Valor Dedito/Credito no valida");return false; }
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
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $nombre_cuenta="";$monto_pasivo=0;
$sql="SELECT * FROM CUENTAS_CON010 where codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='$debito_credito'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$nombre_cuenta=$registro["nombre_cuenta"];  $monto_asiento=$registro["monto_asiento"];} $monto_asiento=formato_monto($monto_asiento);
?>
<body>
<form name="form1" method="post" action="Update_cuenta_lib.php" onSubmit="return revisar()">
  <table width="623" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="620" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR CUENTA DEL COMPROBANTE DEL MOVIMIENTO </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="614" border="0">
              <tr>
                <td width="330"><span class="Estilo5">C&Oacute;DIGO CUENTA :
                      <input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" size="30" maxlength="30" value="<? echo $cod_cuenta ?>" readonly >
                </span></td>
                <td width="268">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="614" border="0">
              <tr>
                <td width="608"><span class="Estilo5">NOMBRE CUENTA :
                    <input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" size="74" maxlength="250" value="<? echo $nombre_cuenta ?>" readonly>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="614" border="0">
                <tr>
                  <td width="336"><span class="Estilo5">DEBITO/CREDITO :
                  <input class="Estilo10" name="txtDeb_Cre" type="text"  id="txtDeb_Cre" size="2" maxlength="2" value="<? echo $debito_credito ?>" readonly>
                   </span></td>
                  <td width="242"><span class="Estilo5">MONTO :
                        <input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="25" style="text-align:right" maxlength="22" value="<? echo $monto_asiento ?>" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event)">
                  </span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar('<? echo $codigo_mov; ?>','<? echo $cod_cuenta; ?>','<? echo $debito_credito; ?>')"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>