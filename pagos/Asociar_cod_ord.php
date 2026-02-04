<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$cod_presup=""; $cod_fuente="00";$codigo_mov="";$ref_imput_presu="";$ref_comp=""; $tipo_comp="0000";}
 else{ $cod_presup=$_GET["codigo"];$cod_fuente=$_GET["fuente"]; $ref_imput_presu=$_GET["ref_imput"]; $ref_comp=$_GET["ref_comp"]; $tipo_comp=$_GET["tipo_comp"];$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $Formato_Cuenta="X-X-X-XX-XX-XX-XXX";
$sql="Select campo504 from SIA005 where campo501='06'";  $resultado=pg_query($sql);  if ($registro=pg_fetch_array($resultado,0)){$Formato_Cuenta=$registro["campo504"];}
$mpatron="Array(1,1,3,2,2,4,0,0,0,0)";  $mpatron=arma_patron($Formato_Cuenta);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Modificar Codigos de la Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var patroncodigo = new <?php echo $mpatron ?>;
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
function llamar_anterior(){document.location ='Det_inc_cod_ord.php?codigo_mov=<?echo $codigo_mov?>&bloqueada=N';}

function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio");return false;}
   if(f.txtcod_fuente.value==""){alert("Codigo de Fuente no puede estar Vacio"); return false; }
   if(f.txtcod_contable.value==""){alert("Codigo Contable no puede estar Vacio");return false;}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   
   if(f.txtcodigo1.value==""){alert("Codigo Contable 1 no puede estar Vacio");return false;}
   if(f.txtmonto1.value==""){alert("Monto 1 no puede estar Vacio");return false;}
   if(f.txtcodigo2.value==""){alert("Codigo Contable 2 no puede estar Vacio");return false;}
   if(f.txtmonto2.value==""){alert("Monto 2 no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>

</head>
<?

$denominacion="";$des_fuente="";$cod_contable=""; $monto=0;$montoc=0;$montod=0;
$sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and ref_imput_presu='$ref_imput_presu'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){
  $denominacion=$registro["denominacion"];  $monto=$registro["monto"];     $des_fuente=$registro["des_fuente_financ"];
  $tipo_imput_presu=$registro["tipo_imput_presu"];  $montoc=$registro["monto_credito"];    $cod_contable=$registro["cod_con_g_pagar"];
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}    $montod=$registro["disponible"];
}
$monto=formato_monto($monto); $montoc=formato_monto($montoc);  $montod=formato_monto($montod);
$monto1=0; $monto2=0; $monto3=0; $monto4=0; $monto5=0; $codigo1=""; $codigo2=""; $codigo3=""; $codigo4=""; $codigo5="";

$sql="SELECT * FROM con022 where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and ref_imput_presu='$ref_imput_presu'"; $res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas>0){  $registro=pg_fetch_array($res);
  $codigo1=$registro["codigo1"]; $monto1=$registro["monto1"]; $codigo2=$registro["codigo2"]; $monto2=$registro["monto2"];
  $codigo3=$registro["codigo3"]; $monto3=$registro["monto3"]; $codigo4=$registro["codigo4"]; $monto4=$registro["monto4"];
  $codigo5=$registro["codigo5"]; $monto5=$registro["monto5"]; 
  $monto1=formato_monto($monto1); $monto2=formato_monto($monto2);  $monto3=formato_monto($monto3);
}else{ $codigo1=$cod_contable; $monto1=$monto; }
?>
<body>
<form name="form1" method="post" action="Update_asoc_cod.php" onSubmit="return revisar()">
  <table width="634" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="630" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="25" align="center" bgcolor="#000066"><span class="Estilo2 Estilo6">ASOCIAR C&Oacute;DIGO DE LA ORDEN</span></td>
        </tr>
        <tr>
          <td><table width="620" border="0">
              <tr>
                <td width="170"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                <td width="220"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo de la Cuenta" value="<? echo $cod_presup ?>"  size="32" maxlength="32" readonly>  </span></td>
                <td width="60">&nbsp;</td>
                <td width="100"><span class="Estilo5">FUENTE : </span></td>
				<td width="70"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" value="<? echo $cod_fuente ?>" size="3" maxlength="2" readonly>  </span></td>
              </tr>
          </table></td>
        </tr>
		<tr>
          <td><table width="679">
            <tr>
              <td width="139"><span class="Estilo5">CODIGO CONTABLE : </span></td>
              <td width="220"><span class="Estilo5"><input class="Estilo10" name="txtcod_contable" type="text" id="txtcod_contable" size="25" maxlength="30" value="<? echo $cod_contable?>" readonly >     </span></td>
              <td width="132"><span class="Estilo5">MONTO CODIGO : </span></td>
              <td width="168"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="25" style="text-align:right" maxlength="22"  value="<? echo $monto ?>" readonly>  </span></td>
            </tr>
          </table>  </td>
        </tr>
		<tr><td>&nbsp;</td></tr>
		
		<tr>
          <td><table width="679">
            <tr>
              <td width="139"><span class="Estilo5">CODIGO ASOCIADO 1 : </span></td>
              <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtcodigo1" type="text" id="txtcodigo1" size="25" maxlength="30" value="<? echo $codigo1?>" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'-',patroncodigo,true)" >     </span></td>
              <td width="60"><input class="Estilo10" name="btcatcta1" type="button" id="btcatcta1" title="Abrir Catalogo de Cuentas" onclick="VentanaCentrada('Cat_cuentasa1.php?criterio=','SIA','','750','500','true')" value="..."></td>
              <td width="132"><span class="Estilo5">MONTO CUENTA 1 : </span></td>
              <td width="168"><span class="Estilo5"><input class="Estilo10" name="txtmonto1" type="text" id="txtmonto1" size="25" style="text-align:right" maxlength="22"  value="<? echo $monto1 ?>" onFocus="encender_monto(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)">  </span></td>
            </tr>
          </table>  </td>
        </tr>
		<tr>
          <td><table width="679">
            <tr>
              <td width="139"><span class="Estilo5">CODIGO ASOCIADO 2 : </span></td>
              <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtcodigo2" type="text" id="txtcodigo2" size="25" maxlength="30" value="<? echo $codigo2?>" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'-',patroncodigo,true)">     </span></td>
              <td width="60"><input class="Estilo10" name="btcatcta2" type="button" id="btcatcta2" title="Abrir Catalogo de Cuentas" onclick="VentanaCentrada('Cat_cuentasa2.php?criterio=','SIA','','750','500','true')" value="..."></td>
              <td width="132"><span class="Estilo5">MONTO CUENTA 2 : </span></td>
              <td width="168"><span class="Estilo5"><input class="Estilo10" name="txtmonto2" type="text" id="txtmonto2" size="25" style="text-align:right" maxlength="22"  value="<? echo $monto2 ?>" onFocus="encender_monto(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)">  </span></td>
            </tr>
          </table>  </td>
        </tr>
		<tr>
          <td><table width="679">
            <tr>
              <td width="139"><span class="Estilo5">CODIGO ASOCIADO 3 : </span></td>
              <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtcodigo3" type="text" id="txtcodigo3" size="25" maxlength="30" value="<? echo $codigo3?>" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'-',patroncodigo,true)">     </span></td>
              <td width="60"><input class="Estilo10" name="btcatcta3" type="button" id="btcatcta3" title="Abrir Catalogo de Cuentas" onclick="VentanaCentrada('Cat_cuentasa3.php?criterio=','SIA','','750','500','true')" value="..."></td>
              <td width="132"><span class="Estilo5">MONTO CUENTA 3: </span></td>
              <td width="168"><span class="Estilo5"><input class="Estilo10" name="txtmonto3" type="text" id="txtmonto3" size="25" style="text-align:right" maxlength="22"  value="<? echo $monto3 ?>" onFocus="encender_monto(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)">  </span></td>
            </tr>
          </table>  </td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>
        </tr>
      </table>
        <table width="629" align="center">
          <tr>
            <td width="7"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="5"><input class="Estilo10" name="txtref_comp" type="hidden" id="txtref_comp" value="<?echo $ref_comp?>"></td>
            <td width="5"><input class="Estilo10" name="txttipo_comp" type="hidden" id="txttipo_comp" value="<?echo $tipo_comp?>"></td>
			<td width="5"><input class="Estilo10" name="txtref_imput_presu" type="hidden" id="txtref_imput_presu" value="<?echo $ref_imput_presu?>"></td>
			<td width="5"><input class="Estilo10" name="txttipo_imput_presu" type="hidden" id="txttipo_imput_presu" value="<?echo $tipo_imput_presu?>"></td>
			<td width="5"><input class="Estilo10" name="txtcodigo4" type="hidden" id="txtcodigo4" value=""></td>
            <td width="5"><input class="Estilo10" name="txtmonto4" type="hidden" id="txtmonto4" value="0"></td>
			<td width="5"><input class="Estilo10" name="txtcodigo5" type="hidden" id="txtcodigo5" value=""></td>
            <td width="5"><input class="Estilo10" name="txtmonto5" type="hidden" id="txtmonto5" value="0"></td>
            <td width="100">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input class="Estilo10" name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>	
            <td width="100">&nbsp;</td>			
            <td width="110" align="center"><input class="Estilo10" name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
			<td width="100">&nbsp;</td>             
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>
<? pg_close(); ?>