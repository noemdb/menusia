<?include ("../class/conect.php");  include ("../class/funciones.php");?
$equipo=getenv("COMPUTERNAME");
if (!$_GET){ $cod_presup=""; $cod_fuente="00";
  $mcod_m="PRE023".$equipo;$codigo_mov=substr($mcod_m,0,49);}
 else{ $cod_presup=$_GET["codigo"];  $cod_fuente=$_GET["fuente"];  $codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Modificar Códigos en el Diferido)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet> 
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){document.location ='Det_inc_diferidos.php?codigo_mov=<?echo $codigo_mov?>';}
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtcod_presup.value==""){alert("Código Presupuestario no puede estar Vacio");return false;}
   if(f.txtcod_fuente.value==""){alert("Código de Fuente no puede estar Vacio"); return false; }
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}
      else{alert("monto debe tener valores numéricos.");return false;}
document.form1.submit;
return true;}
</script>

</head>
<?
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$denominacion="";$des_fuente="";
$monto=0;
$sql="SELECT * FROM CODIGOS_PRE026  where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente'";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){
  $denominacion=$registro["denominacion"];
  $monto=$registro["monto"];
  $des_fuente=$registro["des_fuente_financ"];
}
$monto=formato_monto($monto);
?>
<body>
<form name="form1" method="post" action="Update_cod_dife.php" onSubmit="return revisar()">
  <table width="634" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="630" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR CÓDIGO DEL MOVIMIENTO</span></td>
        </tr>
        <tr>
          <td><table width="620" border="0">
              <tr>
                <td width="168"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :

                </span></td>
                <td width="217"><span class="Estilo5">
                  <input name="txtcod_presup" type="text" id="txtcod_presup2" title="Registre el C&oacute;digo de la Cuenta" value="<? echo $cod_presup ?>"  size="30" maxlength="30" readonly>
                </span></td>
                <td width="103">&nbsp;</td>
                <td width="51">&nbsp;</td>
                <td width="59">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="623" border="0">
            <tr>
              <td width="215"><span class="Estilo5">FUENTE DE FINANCIAMIENTO : </span></td>
              <td width="22"><span class="Estilo10">
                <input name="txtcod_fuente" type="text" id="txtcod_fuente" value="<? echo $cod_fuente ?>" size="3" maxlength="2" readonly>
              </span></td>
              <td width="17">&nbsp;</td>
              <td width="351"><span class="Estilo10">
                <input name="txtdes_fuente" type="text" id="txtdes_fuente" value="<? echo $des_fuente ?>" size="50" readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="621" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N :

                </span></td>
                <td width="494"><span class="Estilo5">
                  <textarea name="txtdenominacion" cols="58" rows="2" readonly="readonly" id="txtdenominacion"><? echo $denominacion ?></textarea>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="614" border="0">
                <tr>
                  <td width="108"><span class="Estilo5">MONTO </span>:</td>
                  <td width="496"><span class="Estilo5">
                    <input name="txtmonto" type="text" id="txtmonto" onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $monto ?>" size="25" maxlength="22" align="right">
                  </span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>
              <p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="120">&nbsp;</td>
            <td width="87" align="center" valign="middle"><input name="Submit" type="submit" id="Submit"  value="Aceptar"></td>
            <td width="99" align="center"><input name="button" type="button" id="button4" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="77" align="center">&nbsp;</td>
            <td width="112">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>