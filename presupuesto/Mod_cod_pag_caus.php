<?include ("../class/conect.php");  include ("../class/funciones.php");
$equipo=getenv("COMPUTERNAME");
if (!$_GET){  $cod_presup="";$cod_fuente="00";  $mcod_m="PRE006".$equipo;$codigo_mov=substr($mcod_m,0,49);}
 else{ $cod_presup=$_GET["codigo"];  $cod_fuente=$_GET["fuente"];  $ref_imput_presu=$_GET["ref_imput_presu"];  $codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Modificar Codigos en el Pago)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
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
function llamar_anterior(){document.location ='Det_inc_pagos_caus.php?codigo_mov=<?echo $codigo_mov?>';}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio");return false;}
   if(f.txtcod_fuente.value==""){alert("Codigo de Fuente no puede estar Vacio"); return false; }
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}    else{alert("monto debe tener valores numericos.");return false;}
document.form1.submit;
return true;}
</script>
<!--
.Estilo9 { font-size: 14px;  font-weight: bold;  color: #FFFFFF;}
-->
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$denominacion="";$des_fuente="";$cod_contable="";$monto=0;
$sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and ref_imput_presu='$ref_imput_presu'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){
  $denominacion=$registro["denominacion"];  $monto=$registro["monto"];  $des_fuente=$registro["des_fuente_financ"];  $tipo_imput_presu=$registro["tipo_imput_presu"];
  $montoc=$registro["monto_credito"];  $montocomp=$registro["monto_presup"];  $credito=$registro["amort_anticipo"];  $cod_contable=$registro["cod_con_g_pagar"];
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}  $montod=$registro["disponible"];
}
$monto=formato_monto($monto);$montoc=formato_monto($montoc);
$montod=formato_monto($montod);$montocomp=formato_monto($montocomp);
?>
<body>
<form name="form1" method="post" action="Update_cod_pag_caus.php" onSubmit="return revisar()">
  <table width="707" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="692" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo2 Estilo6">PAGAR MONTO DEL C&Oacute;DIGO</span></td>
        </tr>
        <tr>
          <td><table width="620" border="0">
              <tr>
                <td width="168"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                <td width="217"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo de la Cuenta" value="<? echo $cod_presup ?>"  size="32" maxlength="32" readonly>
                </span></td>
                <td width="103">&nbsp;</td>
				<td width="51">&nbsp;</td>
                <td width="59">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="663" border="0">
            <tr>
              <td width="200"><span class="Estilo5">FUENTE DE FINANCIAMIENTO : </span></td>
              <td width="34"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" value="<? echo $cod_fuente ?>" size="3" maxlength="2" readonly>   </span></td>
              <td width="10">&nbsp;</td>
              <td width="401"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" value="<? echo $des_fuente ?>" size="55" readonly> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="678" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                <td width="494"><span class="Estilo5"><textarea name="txtdenominacion" cols="65" rows="2" readonly="readonly" id="txtdenominacion"><? echo $denominacion ?></textarea>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><table width="681">
            <tr>
              <td width="121"><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA:</span></td>
              <td width="184"><span class="Estilo5"><input class="Estilo10" name="txttipo_imput_presu" type="text" id="txttipo_imput_presu"  value="<?echo $tipo_imput_presu?>" size="20" readonly> </span></td>
              <td width="244"><span class="Estilo5">REFERENCIA DEL CREDITO ADICIONAL:</span></td>
              <td width="72"><input class="Estilo10" name="txtref_imput_presu" type="text"  id="txtref_imput_presu" value="<?echo $ref_imput_presu?>" size="12" readonly ></td>
              <td width="36"><span class="Estilo5">              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="689" border="0">
            <tr>
              <td width="167"><span class="Estilo5">MONTO CAUSADO  : </span></td>
              <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtmonto_compromiso" type="text" id="txtmonto_compromiso" size="25" style="text-align:right" maxlength="22"  value="<? echo $montocomp ?>" readonly>  </span></td>
              <td width="125"><span class="Estilo5">MONTO A PAGAR  : </span></td>
              <td width="167"><span class="Estilo5"> <input class="Estilo10" name="txtmonto" type="text" id="txtmonto" style="text-align:right" onFocus="encender_monto(this)" onBlur="apagar(this)" value="<? echo $montocomp ?>" size="25" maxlength="22" onKeypress="return validarNum(event)">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>
        </tr>
      </table>
        <table width="629" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="195"><input name="txtcredito" type="hidden" id="txtcredito" value="<? echo $credito?>" readonly></td>
            <td width="66" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="71" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="67"><input name="txtmonto_credito" type="hidden" id="txtmonto_credito" value="<? echo $montoc?>" readonly></td>
            <td width="185"><input name="txtcod_contable" type="hidden" id="txtcod_contable" value="<? echo $cod_contable?>" readonly></td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>
