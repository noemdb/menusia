<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_cuenta=$_GET["cod_cuenta"];$codigo_mov=$_GET["codigo_mov"];$debito_credito=$_GET["debito_credito"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Incluir Cuentas en el Comprobante)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_comp_caus.php?codigo_mov=<?echo $codigo_mov?>'; }
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtCodigo_Cuenta.value==""){alert("C�digo de Cuenta no puede estar Vacio");return false;}
   if(f.txtDeb_Cre.value=="D" || f.txtDeb_Cre.value=="C") {Valido=true;}
        else{alert("Valor Dedito/Credito no valida");return false; }
   if(f.txtDes_A.value==""){alert("Descripci�n de Asiento no puede estar Vacio"); return false; }
        else{f.txtDes_A.value=f.txtDes_A.value.toUpperCase();}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}
      else{alert("monto debe tener valores num�ricos.");return false;}
document.form1.submit;
return true;}
</script>
</head>
<?
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname.""); $monto=0; $modificable="N";
$sSQL="SELECT * FROM CUENTAS_CON008  WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='$debito_credito'";
$res=pg_query($sSQL);
if ($registro=pg_fetch_array($res,0)){ $monto=$registro["monto_asiento"]; $modif=$registro["modificable"]; $nombre=$registro["nombre_cuenta"];
  $modificable=$registro["modificable"];
} $monto=formato_monto($monto);
if ($modif=="N"){?> <script language="JavaScript">muestra('CUENTA NO PUEDE SER MODIFICADA EN EL COMPROBANTE');llamar_anterior();</script> <?
}
?>


<body>
<form name="form1" method="post" action="Update_cuenta_comp.php" onSubmit="return revisar()">
  <table width="623" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="620" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#003399"><span class="Estilo9">MODIFICAR CUENTA EN EL COMPROBANTE</span></td>
        </tr>
        <tr>
          <td><table width="614" border="0">
              <tr>
                <td width="330"><span class="Estilo5">C&Oacute;DIGO CUENTA :
                      <input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" title="Registre el C&oacute;digo de la Cuenta"  value="<?ECHO $cod_cuenta?>" readonly size="30" maxlength="30" onFocus="encender(this); " onBlur="apagar(this);">
                </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="614" border="0">
              <tr>
                <td width="608"><span class="Estilo5">NOMBRE CUENTA :
                    <input name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" size="74" maxlength="250" value="<?ECHO $nombre?>" readonly>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="614" border="0">
                <tr>
                  <td width="336"><span class="Estilo5">DEBITO/CREDITO :
                     <input name="txtDeb_Cre" type="text" id="txtDeb_Cre" size="4" value="<?ECHO $debito_credito?>" readonly>
                  </span></td>
                  <td width="242"><span class="Estilo5">MONTO :
                        <input name="txtmonto" type="text" id="txtmonto" size="25" align="right" maxlength="22" value="<?ECHO $monto?>" onFocus="encender(this)" onBlur="apagar(this)">
                  </span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov2" value="<?echo $codigo_mov?>"></td>
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
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