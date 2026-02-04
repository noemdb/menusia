<?include ("../class/conect.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME");
if (!$_GET){ $cod_presup=""; $cod_fuente="00"; $grupo="01";  $mcod_m="PRE009".$equipo;$codigo_mov=substr($mcod_m,0,49);}
 else{ $cod_presup=$_GET["codigo"];$cod_fuente=$_GET["fuente"]; $codigo_mov=$_GET["codigo_mov"];}  $grupo=$_GET["grupo"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Modificar Códigos en el Diferido)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 

function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function llamar_anterior(){document.location ='Det_inc_traspasos.php?codigo_mov=<?echo $codigo_mov?>';}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio"); f.txtcod_presup.focus(); return false;}
   if(f.txtcod_fuente.value==""){alert("Codigo de Fuente no puede estar Vacio"); f.txtcod_fuente.focus(); return false; }
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio"); f.txtmonto.focus(); return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;} else{alert("monto debe tener valores numericos."); f.txtmonto.focus(); return false;}
document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$denominacion="";$des_fuente="";$monto=0;
$sql="SELECT * FROM CODIGOS_PRE026  where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and grupo='$grupo'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $denominacion=$registro["denominacion"]; $monto=$registro["monto"];
  $des_fuente=$registro["des_fuente_financ"];  $montod=$registro["disponible"];  $operacion=$registro["operacion"];}
$monto=formato_monto($monto);$montod=formato_monto($montod);
?>
<body>
<form name="form1" method="post" action="Update_cod_tras.php" onSubmit="return revisar()">
  <table width="634" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="630" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR CODIGO DEL TRASPASO</span></td>
        </tr>
        <tr>
          <td><table width="627" border="0">
              <tr>
                <td width="55"><span class="Estilo5">GRUPO : </span></td>
                <td width="131"><span class="Estilo5"><input class="Estilo10" name="txtgrupo" type="text" id="txtgrupo" size="4" maxlength="2" readonly value="<?echo $grupo?>" onkeypress="return stabular(event,this)"> </span></td>
                <td width="188"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO : </span></td>
                <td width="211"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo de la Cuenta" value="<? echo $cod_presup ?>"  size="32" maxlength="32" readonly onkeypress="return stabular(event,this)">   </span></td>
                <td width="20">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="623" border="0">
            <tr>
              <td width="215"><span class="Estilo5">FUENTE DE FINANCIAMIENTO : </span></td>
              <td width="22"><span class="Estilo5"> <input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" value="<? echo $cod_fuente ?>" size="3" maxlength="2" readonly onkeypress="return stabular(event,this)"> </span></td>
              <td width="17">&nbsp;</td>
              <td width="351"><span class="Estilo5"> <input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" value="<? echo $des_fuente ?>" size="50" readonly onkeypress="return stabular(event,this)">     </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="621" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="494"><span class="Estilo5"> <textarea name="txtdenominacion" class="Estilo10" cols="58" rows="2" readonly="readonly" id="txtdenominacion" onkeypress="return stabular(event,this)"><? echo $denominacion ?></textarea>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><table width="593" border="0">
            <tr>
              <td width="110"><span class="Estilo5">DISPONIBLE:</span></td>
              <td width="233"><span class="Estilo5"> <input class="Estilo10" name="txtdisponible" type="text" id="txtdisponible" size="25" style="text-align:right" value="<? echo $montod ?>" readonly onkeypress="return stabular(event,this)"></span></td>
              <td width="91"><span class="Estilo5">OPERACI&Oacute;N :</span></td>
              <td width="168"><span class="Estilo5"><input class="Estilo10" name="txtoperacion" type="text" id="txtoperacion" size="3"  value="<?echo $operacion?>" align="center" readonly onkeypress="return stabular(event,this)"></span></td>
            </tr>
          </table>                </td>
        </tr>
        <tr>
          <td><table width="614" border="0">
            <tr>
              <td width="108"><span class="Estilo5">MONTO </span>:</td>
              <td width="496"><span class="Estilo5"> <input class="Estilo10" name="txtmonto" type="text" id="txtmonto" onFocus="encender_monto(this)" onBlur="apagar(this)" value="<? echo $monto ?>" size="25" maxlength="22" style="text-align:right" onKeypress="return validarNum(event,this)" >
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p></td>
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