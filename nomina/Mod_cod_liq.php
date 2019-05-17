<? include ("../class/conect.php"); include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");$mcod_m="LIQ".$usuario_sia.$equipo;
if (!$_GET){$codigo_mov=substr($mcod_m,0,49);$cod_concepto="";} else{$codigo_mov=$_GET["codigo_mov"]; $cod_concepto=$_GET["cod_concepto"]; } 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Modificar Conceptos de Liquidacion)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">

function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if ((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 

function encende_cant(mthis){var mmonto; encender(mthis); 
  mmonto=document.form1.txtcosto.value; mmonto=eliminapunto(mmonto);  document.form1.txtcosto.value=mmonto; 
  mmonto=document.form1.txtcantidad.value; mmonto=eliminapunto(mmonto);  document.form1.txtcantidad.value=mmonto; 
}
function apaga_cant(mthis){var mcant; var mmonto; var mtotal;
  apagar(mthis); mcant=mthis.value;  mcant=camb_punto_coma(mcant); document.form1.txtcantidad.value=mcant;
  mcant=quitaformatomonto(mcant);  mmonto=quitaformatomonto(document.form1.txtcosto.value);
  mcant=(mcant*1); mmonto=(mmonto*1); mtotal=mcant*mmonto; mtotal=Math.round(mtotal*100)/100;
  document.form1.txttotal.value=mtotal; document.form1.txttotal.value=daformatomonto(document.form1.txttotal.value);
}
function encende_monto(mthis){var mmonto; encender(mthis); 
  mmonto=document.form1.txtcosto.value; mmonto=eliminapunto(mmonto);  document.form1.txtcosto.value=mmonto; 
}
function apaga_monto(mthis){var mcant; var mmonto; var mtotal;
  apagar(mthis); mmonto=mthis.value;  mmonto=camb_punto_coma(mmonto); document.form1.txtcosto.value=mmonto;
  mmonto=quitaformatomonto(mmonto); mcant=quitaformatomonto(document.form1.txtcantidad.value);
  mcant=(mcant*1); mmonto=(mmonto*1); mtotal=mcant*mmonto;  mtotal=Math.round(mtotal*100)/100;
  document.form1.txttotal.value=mtotal;  document.form1.txttotal.value=daformatomonto(document.form1.txttotal.value);
}
function llamar_anterior(){ document.location ='Det_inc_cal_liq.php?codigo_mov=<?echo $codigo_mov?>'; }

function llamar_eliminar(codigo_mov,cod_concepto){ var murl;var r; var mfecha_hasta=document.form1.txtfecha_hasta.value;
 if (cod_concepto=="") {alert("Codigo debe ser Seleccionado");}
  else { murl="Esta seguro en Eliminar el Codigo Concepto:"+cod_concepto+" de la Liquidacion ?";   r=confirm(murl);
  if(r==true){ r=confirm("Esta Realmente seguro en Eliminar el Codigo Concepto de la Liquidacion ?");
    if(r==true){murl="Delete_cod_liq.php?codigo_mov="+codigo_mov+"&cod_concepto="+cod_concepto+"&fecha_hasta="+mfecha_hasta; document.location=murl;}  }
   else { url="Cancelado, no elimino"; }}
}

function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_concepto.value==""){alert("Codigo de Concepto no puede estar Vacio");return false;}
   if(f.txtdenominacion.value==""){alert("Denominacion no puede estar Vacio"); return false; }
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}  else{alert("monto debe tener valores numericos.");return false;}
document.form1.submit;
return true;}
</script>

</head>
<? $cantidad=0; $costo=0; $asig_ded_apo=""; $denominacion=""; $total=0; $fecha_hasta="";  $tipo_asigna='O';
$sSQL="Select * from nom076 WHERE codigo_mov='$codigo_mov' and cod_concepto='$cod_concepto' "; $res=pg_query($sSQL);
if ($registro=pg_fetch_array($res,0)){ $denominacion=$registro["denominacion"]; $asig_ded_apo=$registro["asig_ded_apo"]; 
  $cantidad=formato_monto($registro["cantidad"]); $costo=formato_monto($registro["monto_orig"]); $total=$registro["valor"]; 
  $fecha_hasta=$registro["fecha_hasta"]; $fecha_desde=$registro["fecha_ini"]; $tipo_asigna=$registro["tipo_asigna"];
 $fecha_desde=formato_ddmmaaaa($fecha_desde); $fecha_hasta=formato_ddmmaaaa($fecha_hasta); }
?>
<body>
<form name="form1" method="post" action="Update_cod_liq.php" onSubmit="return revisar()">
  <table width="634" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="628" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo2 Estilo6">MODIFCAR CONCEPTOS DE LIQUIDACION</span></td>
        </tr>
        <tr>
          <td><table width="620" border="0">
              <tr>
                <td width="170"><span class="Estilo5">C&Oacute;DIGO CONCEPTO :</span></td>
				<td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="3"  value="<? echo $cod_concepto ?>" readonly> </span></td>
                <td width="150"><span class="Estilo5">TIPO DE CONCEPTO : </span></td>
                <td width="150"><span class="Estilo5"><select class="Estilo10" name="txtasig_ded_apo" size="1" id="txtasig_ded_apo" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>ASIGNACION</option> <option>DEDUCCION</option> </select>  </span></td>
			  </tr>
          </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_tipo_conc(mvalor){var f=document.form1;
    if(mvalor=="A"){document.form1.txtasig_ded_apo.options[0].selected = true;}
    if(mvalor=="D"){document.form1.txtasig_ded_apo.options[1].selected = true;}
} asig_tipo_conc('<?echo $asig_ded_apo;?>');
</script>
		<tr> <td>&nbsp;</td> </tr>
        <tr>
          <td><table width="620" border="0">
            <tr>
              <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
              <td width="520"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="75" maxlength="80" onFocus="encender(this)" onBlur="apagar(this)"  value="<? echo $denominacion ?>"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
        <tr>
             <td><table width="620">
                 <tr>
                   <td width="100"><span class="Estilo5">PERIODO DESDE : </span></td>
                   <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ini" type="text" id="txtfecha_ini" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_desde?>"  onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                   <td width="130"><span class="Estilo5">PERIODO HASTA : </span></td>
                   <td width="136"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hasta?>"  onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                     </tr>
             </table></td>
         </tr>
		<tr> <td>&nbsp;</td> </tr>   
		<tr>
          <td><table width="620" border="0">
            <tr>
                <td width="70"><span class="Estilo5">CANTIDAD :</span></td>
                  <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcantidad" type="text" id="txtcantidad" size="12" maxlength="12" style="text-align:right" onFocus="encende_cant(this)" onBlur="apaga_cant(this)" onKeypress="return validarNum(event)"  value="<? echo $cantidad ?>">  </span></td>
                  <td width="60"><span class="Estilo5">MONTO : </span></td>
                  <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtcosto" type="text" id="txtcosto" size="15" style="text-align:right" maxlength="15" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event)"  value="<? echo $costo ?>"> </span></td>
                  <td width="60"><span class="Estilo5">TOTAL : </span></td>
                  <td width="140"><span class="Estilo5"><input class="Estilo10" name="txttotal" type="text" id="txttotal" size="15" style="text-align:right" maxlength="15" readonly  value="<? echo $total ?>"> </span></td>
             
            </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="10"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="10"><input name="txttipo_asigna" type="hidden" id="txttipo_asigna" value="<?echo $tipo_asigna?>"></td>
            <td width="100">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="90" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
			<td width="90" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar('<? echo $codigo_mov; ?>','<? echo $cod_concepto; ?>')"></td>
            <td width="130">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>