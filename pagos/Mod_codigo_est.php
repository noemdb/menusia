<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$referencia="";$tipo="";$cod_presup="";$cod_fuente="00"; $ref_imput_presu=""; $codigo_mov="";}
 else{$referencia=$_GET["referencia"];  $tipo=$_GET["tipo"];  $cod_presup=$_GET["codigo"];  $cod_fuente=$_GET["fuente"];  $ref_imput_presu=$_GET["ref_imput"]; $codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Modificar Codigos en la Estructura)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var Gcodigo = "<?echo $codigo?>";
var Gfuente = "<?echo $fuente?>";
var Gcodigo_mov = "<?echo $codigo_mov?>";
var Gtipo = "<?echo $tipo?>";
var Greferencia = "<?echo $referencia?>";
var Gref_imput = "<?echo $ref_imput_presu?>";
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function encende_monto(mthis){var mmonto; encender(mthis); 
  mmonto=document.form1.txtmonto.value; mmonto=quitaformatomonto(mmonto); document.form1.txtmonto.value=mmonto; 
}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto); document.form1.txtmonto.value=mmonto;
return true;}
function llamar_anterior(){document.location ='Det_inc_cod_est.php?codigo_mov=<?echo $codigo_mov?>';}
function llamar_eliminar(){var murl;var r;
 if (Gcodigo=="") {alert("Codigo Presupuestario debe ser Seleccionada");}
  else { murl="Esta seguro en Eliminar el Codigo:"+Gcodigo+" Fuente:"+Gfuente+" de la Estructura ?";  r=confirm(murl);
  if(r==true){r=confirm("Esta Realmente seguro en Eliminar el Codigo de la Estructura ?");
    if(r==true){murl="Delete_cod_est.php?codigo_mov="+Gcodigo_mov+"&tipo="+Gtipo+"&referencia="+Greferencia+"&codigo="+Gcodigo+"&fuente="+Gfuente+"&ref_imput="+Gref_imput;document.location=murl;}
    }else { url="Cancelado, no elimino"; }
  }
}
function revisar(){var f=document.form1;  var Valido=true;
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio");return false;}
   if(f.txtcod_fuente.value==""){alert("Codigo de Fuente no puede estar Vacio"); return false; }
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}
      else{alert("monto debe tener valores numéricos.");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$denominacion="";$des_fuente="";$monto=0;
$sql="SELECT * FROM CODIGOS_PRE026  where codigo_mov='$codigo_mov' and referencia_comp='$referencia' and tipo_compromiso='$tipo' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and ref_imput_presu='$ref_imput_presu'";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $denominacion=$registro["denominacion"]; $monto=$registro["monto"];  $des_fuente=$registro["des_fuente_financ"];
$tipo_imput_presu=$registro["tipo_imput_presu"]; if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";} 
}$monto=formato_monto($monto);
?>
<body>
<form name="form1" method="post" action="Update_cod_est.php" onSubmit="return revisar()">
  <table width="634" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="630" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR CODIGO DE LA ESTRUCTURA</span></td>
        </tr>
        <tr>
          <td><table width="620">
            <tr>
              <td width="187"><span class="Estilo5">DOCUMENTO COMPROMISO:</span></td>
              <td width="82"><input class="Estilo10" name="txttipo_compromiso" type="text"  id="txttipo_compromiso" size="6" maxlength="4" readonly value="<? echo $tipo ?>"></td>
              <td width="144"><span class="Estilo5">REFERENCIA :</span></td>
              <td width="187"><input class="Estilo10" name="txtreferencia_comp" type="text" id="txtreferencia_comp" size="12" readonly value="<? echo $referencia ?>" ></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="620" border="0">
              <tr>
                <td width="168"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO : </span></td>
                <td width="217"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo de la Cuenta" value="<? echo $cod_presup ?>"  size="30" maxlength="30" readonly>
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
              <td width="22"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" value="<? echo $cod_fuente ?>" size="3" maxlength="2" readonly>
              </span></td>
              <td width="17">&nbsp;</td>
              <td width="351"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" value="<? echo $des_fuente ?>" size="50" readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="621" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="494"><span class="Estilo5"><textarea name="txtdenominacion" class="Estilo10" cols="58" rows="1" readonly="readonly" id="txtdenominacion"><? echo $denominacion ?></textarea>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="614" border="0">
                <tr>
                  <td width="108"><span class="Estilo5">MONTO :</span></td>
                  <td width="496"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<? echo $monto ?>" size="25" maxlength="22"  style="text-align:right"  onKeypress="return validarNum(event)">
                  </span></td>
                </tr>
            </table></td>
        </tr>
		<tr>
          <td><table width="620">
            <tr>
              <td width="180"><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA:</span></td>
              <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txttipo_imput_presu" type="text" id="txttipo_imput_presu"  value="<?echo $tipo_imput_presu?>" size="20" readonly class="Estilo5"></span></td>
              <td width="200"><span class="Estilo5">REFERENCIA DEL CREDITO ADICIONAL:</span></td>
              <td width="80"><input class="Estilo10" name="txtref_imput_presu" type="text"  id="txtref_imput_presu" value="<?echo $ref_imput_presu?>" size="12" readonly class="Estilo5"></td>             
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="147">&nbsp;</td>
            <td width="83" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="76" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="77" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
            <td width="112">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>