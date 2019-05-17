<?include ("../class/conect.php");  include ("../class/funciones.php"); ?>
<? $equipo=getenv("COMPUTERNAME"); $referencia="";$tipo="0000"; $cod_presup="";$cod_fuente="00";
if (!$_GET){ $tipo_ret=""; $mcod_m="PAG006".$equipo;$codigo_mov=substr($mcod_m,0,49);} else{$tipo_ret=$_GET["tipo_ret"]; $codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Modificar Retención de la Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto (monto){var i;var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if ((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function llamar_eliminar(){
var murl;
var r;
  murl="Esta seguro en Eliminar la Retención de la Orden Financiera ?";
  r=confirm(murl);
  if(r==true){
    r=confirm("Esta Realmente seguro en Eliminar la Retención de la Orden ?");
    if(r==true){murl="Delete_ret_ord_fin.php?codigo_mov=<?echo $codigo_mov?>&tipo_ret=<?echo $tipo_ret?>&tipo=<?echo $tipo?>&referencia=<?echo $referencia?>&codigo=<?echo $cod_presup?>&fuente=<?echo $cod_fuente?>";document.location=murl;}
    }
   else { url="Cancelado, no elimino"; }
}
function llamar_anterior(){document.location ='Det_inc_ret_ord_fin.php?codigo_mov=<?echo $codigo_mov?>';}
function chequea_tasa(mform){
var mmonto;
var mtasa;
   mmonto=quitaformatomonto(mform.txtmonto_objeto.value);
   mtasa=quitaformatomonto(mform.txttasa.value);
   mmonto=(mmonto*1);
   mtasa=(mmonto*(mtasa/100));
   mtasa=Math.round(mtasa*100)/100;
   mform.txtmonto_retencion.value=mtasa;
   mform.txtmonto_retencion.value=daformatomonto(mform.txtmonto_retencion.value);
return true;}
function apaga_tasa(mthis){
var mmonto;
var mtasa;
   apagar(mthis);
   mmonto=quitaformatomonto(mform.txtmonto_objeto.value);
   mtasa=mthis.value;
   mtasa=quitaformatomonto(mtasa);
   mmonto=(mmonto*1);
   mtasa=(mmonto*(mtasa/100));
   mtasa=Math.round(mtasa*100)/100;
   document.form1.txtmonto_retencion.value=mtasa;
   document.form1.txtmonto_retencion.value=daformatomonto(document.form1.txtmonto_retencion.value);
return true;}
function chequea_objeto(mform){var mmonto; var mtasa;
   mmonto=quitaformatomonto(mform.txtmonto_objeto.value);
   mtasa=quitaformatomonto(mform.txttasa.value);
   mmonto=(mmonto*1);
   mtasa=(mmonto*(mtasa/100));
   mtasa=Math.round(mtasa*100)/100;
   mform.txtmonto_retencion.value=mtasa;
   mform.txtmonto_retencion.value=daformatomonto(mform.txtmonto_retencion.value);
return true;}
function apaga_objeto(mthis){var mmonto; var mtasa;
 apagar(mthis);
 mmonto=mthis.value;
 mmonto=quitaformatomonto(mmonto);
 mtasa=quitaformatomonto(document.form1.txttasa.value);
 mmonto=(mmonto*1);
 mtasa=(mmonto*(mtasa/100));
 mtasa=Math.round(mtasa*100)/100;
 document.form1.txtmonto_retencion.value=mtasa;
 document.form1.txtmonto_retencion.value=daformatomonto(document.form1.txtmonto_retencion.value);
return true;}
function apaga_monto_ret(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto_retencion.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto_retencion.value=mmonto;
return true;}
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtcod_presup.value==""){alert("Código Presupuestario no puede estar Vacio");return false;}
   if(f.txttipo_retencion.value==""){alert("Tipo de Reteneción no puede estar Vacio"); return false; }
   if(f.txtced_rif.value==""){alert("Cedula/Rif no puede estar Vacia"); return false; } else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
   if(f.txtmonto_retencion.value==""){alert("Monto Retencion no puede estar Vacio");return false;}
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
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$concepto_ret="";$descripcion_ret=""; $tasa=0; $monto_objeto=0; $monto=0;$cod_ret="";
$sql="SELECT * FROM COD_RET  where codigo_mov='$codigo_mov' and tipo_retencion='$tipo_ret' and ref_comp_ret='$referencia' and tipo_comp_ret='$tipo' and cod_presup_ret='$cod_presup' and fuente_fin_ret='$cod_fuente'"; $res=pg_query($sql); 
if ($registro=pg_fetch_array($res,0)){  $tasa=$registro["tasa_retencion"];
  $monto_objeto=$registro["monto_objeto_ret"]; $monto=$registro["monto_retencion"];
  $descripcion_ret=$registro["descripcion_ret"];  $concepto_ret=$registro["des_orden_ret"];
  $ced_rif=$registro["ced_rif_r"]; $nombre=$registro["beneficiario_ret"];
  $cod_ret=$registro["tipo_comp_ret"]." ".$registro["ref_comp_ret"]." ".$registro["fuente_fin_ret"]." ".$registro["cod_presup_ret"];
}
$tasa=formato_monto($tasa);$monto_objeto=formato_monto($monto_objeto);$monto=formato_monto($monto);
?>
<body>
<form name="form1" method="post" action="Update_ret_ord_fin.php" onSubmit="return revisar()">
  <table width="745" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="741" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR RETENCI&Oacute;N DE LA ORDEN FINANCIERA </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="732">
            <tr>
              <td width="112"><span class="Estilo5">TIPO RETENCI&Oacute;N:</span></td>
              <td width="46"><span class="Estilo5"><input class="Estilo10" name="txttipo_retencion" type="text" id="txttipo_retencion" size="4" maxlength="3" value="<? echo $tipo_ret ?>"  readonly>   </span></td>
              <td width="497"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_ret" type="text" id="txtdescripcion_ret"  readonly  size="80" value="<? echo $descripcion_ret ?>">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="733" border="0">
            <tr>
              <td width="47"><span class="Estilo5">TASA :</span></td>
              <td width="77"><span class="Estilo5"><input class="Estilo10" name="txttasa" type="text" id="txttasa" size="6" maxlength="6"  onFocus="encender(this)" onBlur="apaga_tasa(this)" onchange="chequea_tasa(this.form);" value="<? echo $tasa ?>" onKeypress="return validarNum(event)">  </span> </td>
              <td width="111"><span class="Estilo5">MONTO OBJETO :</span></td>
              <td width="215"><span class="Estilo5"><input class="Estilo10" name="txtmonto_objeto" type="text" id="txmonto_objeto" size="25" align="right" maxlength="22" onFocus="encender(this)" onBlur="apaga_objeto(this)"  onchange="chequea_objeto(this.form);" value="<? echo $monto_objeto ?>" onKeypress="return validarNum(event)">  </span></td>
              <td width="83"><span class="Estilo5">RETENCI&Oacute;N:</span></td>
              <td width="174"><span class="Estilo5"><input class="Estilo10" name="txtmonto_retencion" type="text" id="txtmonto_retencion" size="25" align="right" maxlength="22" onFocus="encender(this)" onBlur="apaga_monto_ret(this)" value="<? echo $monto ?>" onKeypress="return validarNum(event)">   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="703" border="0">
              <tr>
                <td width="175"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                <td width="444"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo de la Cuenta" value="<? echo $cod_ret ?>"  size="50" maxlength="50" readonly>   </span></td>
                <td width="70">&nbsp;</td>
                </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="737" border="0">
            <tr>
              <td width="145"><span class="Estilo5">CED/RIF BENEFICIARIO:</span></td>
              <td width="153"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $ced_rif ?>">   </span></td>
              <td width="40"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../presupuesto/Cat_beneficiarios.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
              <td width="375"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="60" value="<? echo $nombre ?>" readonly>   </span> </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span> </td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>              </td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="20"><input name="txtdes_orden_ret" type="hidden" id="txtdes_orden_ret" ></td>
            <td width="127">&nbsp;</td>
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