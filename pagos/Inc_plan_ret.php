<?include ("../class/ventana.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$mcod_m="BAN012".$equipo;$codigo_mov=substr($mcod_m,0,49); $user="";$password="";$dbname=""; $fechah="";} else{$codigo_mov=$_GET["codigo_mov"]; $user=$_GET["user"];$password=$_GET["password"];$dbname=$_GET["dbname"];$fechah=$_GET["fechah"];}
$orden="00000000";  $aux_orden="00000000"; $planilla="00";
$monto_r="";$monto_o=""; $monto1=0; $monto2=0; $tasa=0; $descripcion_ret=""; $tipo_en=""; $tipo_documento="FACTURA"; $nro_documento=""; $nro_con_factura=""; $fecha=""; $descripcion=""; $tipo_operacion="N";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Incluir Planilla de Retencion)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function chequea_planilla(mform){
var mref;
   mref=mform.txtplanilla.value; mref = Rellenarizq(mref,"0",2);  mform.txtplanilla.value=mref;
   ajaxSenddoc('GET', 'desplanilla.php?codigo='+mref+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'desplan', 'innerHTML');
   ajaxSenddoc('GET', 'numplanilla.php?codigo='+mref+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nroplan', 'innerHTML');
return true;}
function llamar_anterior(){document.location ='Det_ret_planillas.php?codigo_mov=<?echo $codigo_mov?>';}
function chequea_tipo(mform){
var mref;
   mref=mform.txttipo_retencion.value; mref=Rellenarizq(mref,"0",3);  mform.txttipo_retencion.value=mref;
return true;}
function chequea_tasa(mform){var mmonto;var mtasa;
   mmonto=quitaformatomonto(mform.txtmonto_objeto.value);
   mtasa=quitaformatomonto(mform.txttasa.value);
   mmonto=(mmonto*1);   mtasa=(mmonto*(mtasa/100));    mtasa=Math.round(mtasa*100)/100;
   mform.txtmonto_retencion.value=mtasa;
   mform.txtmonto_retencion.value=daformatomonto(mform.txtmonto_retencion.value);
return true;}
function apaga_tasa(mthis){var mmonto; var mtasa;
   apagar(mthis);
   mmonto=quitaformatomonto(document.form1.txtmonto_objeto.value);
   mtasa=mthis.value;    mtasa=quitaformatomonto(mtasa);
   mmonto=(mmonto*1);   mtasa=(mmonto*(mtasa/100)); mtasa=Math.round(mtasa*100)/100;
   document.form1.txtmonto_retencion.value=mtasa;
   document.form1.txtmonto_retencion.value=daformatomonto(document.form1.txtmonto_retencion.value);
return true;}
function chequea_objeto(mform){var mmonto; var mtasa;
   mmonto=quitaformatomonto(mform.txtmonto_objeto.value);
   mtasa=quitaformatomonto(mform.txttasa.value);
   mmonto=(mmonto*1);   mtasa=(mmonto*(mtasa/100));   mtasa=Math.round(mtasa*100)/100;
   mform.txtmonto_retencion.value=mtasa;
   mform.txtmonto_retencion.value=daformatomonto(mform.txtmonto_retencion.value);
   mform.txtmonto1.value=mform.txtmonto_objeto.value;
return true;}
function apaga_objeto(mthis){var mmonto; var mtasa;
 apagar(mthis);  mmonto=mthis.value;  mmonto=quitaformatomonto(mmonto);
 mtasa=quitaformatomonto(document.form1.txttasa.value);
 mmonto=(mmonto*1); mtasa=(mmonto*(mtasa/100)); mtasa=Math.round(mtasa*100)/100;
 document.form1.txtmonto_retencion.value=mtasa;
 document.form1.txtmonto_retencion.value=daformatomonto(document.form1.txtmonto_retencion.value);
 document.form1.txtmonto1.value=mthis.value;
return true;}
function apaga_monto_ret(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto_retencion.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto_retencion.value=mmonto;
return true;}
function apaga_monto1(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto1.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto1.value=mmonto;
return true;}
function apaga_monto2(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto2.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto2.value=mmonto;
return true;}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtnro_orden.value==""){alert("Numero de Orden no puede estar Vacio");return false;}
   if(f.txttipo_retencion.value==""){alert("Tipo de Retención no puede estar Vacio"); return false; }
   if(f.txtplanilla.value==""){alert("Tipo de Planilla no puede estar Vacio"); return false; }
   if(f.txtplanilla.value=="00"){alert("Tipo de Planilla Invalido"); return false; }
   if(f.txtnro_planilla.value==""){alert("Numero de Planilla no puede estar Vacio"); return false; }
   if(f.txtmonto_retencion.value==""){alert("Monto Retencion no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto_retencion.value)) {Valido=true;} else{alert("monto debe tener valores numéricos.");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--i
.Estilo9 { font-size: 16px;font-weight: bold; color: #FFFFFF; }
-->
</style>
</head>
<body>
<form name="form1" method="post" action="Insert_plan_ret.php" onSubmit="return revisar()">
  <table width="745" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="741" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">PLANILLA DE RETENCI&Oacute;N</span></td>
        </tr>
        <tr>
          <td><table width="729" >
            <tr>
              <td width="139"><span class="Estilo5">N&Uacute;MERO DE ORDEN  :</span></td>
              <td width="177"><span class="Estilo5"> <input class="Estilo10" name="txtnro_orden" type="text" id="txtnro_orden" size="20" maxlength="15" readonly value="<? echo $orden ?>"></span></span></td>
              <td width="181"><span class="Estilo5">ORDEN DE RETENCI&Oacute;N :</span></td>
              <td width="212"><span class="Estilo5"><input class="Estilo10" name="txtaux_orden" type="text" id="txtaux_orden" size="20" maxlength="15" readonly value="<? echo $aux_orden ?>"></span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="737">
            <tr>
              <td width="117"><span class="Estilo5">TIPO RETENCI&Oacute;N:</span></td>
              <td width="48"><span class="Estilo5"><input class="Estilo10" name="txttipo_retencion" type="text" id="txttipo_retencion" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_tipo(this.form);"></span></td>
              <td width="50"><input class="Estilo10" name="bttiporet" type="button" id="bttiporet" title="Abrir Catalogo Tipos de Retención" onclick="VentanaCentrada('Cat_tipo_ret.php?criterio=','SIA','','750','500','true')" value="..."></td>
              <td width="506"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_ret" type="text" id="txtdescripcion_ret"  readonly  size="75"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="733" border="0">
            <tr>
              <td width="47"><span class="Estilo5">TASA :</span></td>
              <td width="77"><span class="Estilo5"><input class="Estilo10" name="txttasa" type="text" id="txttasa" size="6" maxlength="6" align="right" onFocus="encender(this)" onBlur="apaga_tasa(this)" onchange="chequea_tasa(this.form);" value="<? echo $tasa ?>" onKeypress="return validarNum(event)"> </span></td>
              <td width="111"><span class="Estilo5">MONTO OBJETO :</span></td>
              <td width="215"><span class="Estilo5"><input class="Estilo10" name="txtmonto_objeto" type="text" id="txmonto_objeto" size="25" align="right" maxlength="22" onFocus="encender(this)" onBlur="apaga_objeto(this)"  onchange="chequea_objeto(this.form);" onKeypress="return validarNum(event)"></span></td>
              <td width="83"><span class="Estilo5">RETENCI&Oacute;N:</span></td>
              <td width="174"><span class="Estilo5"><input class="Estilo10" name="txtmonto_retencion" type="text" id="txtmonto_retencion" size="25" align="right" maxlength="22" onFocus="encender(this)" onBlur="apaga_monto_ret(this)" onKeypress="return validarNum(event)"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="733" border="0">
              <tr>
                <td width="120"><span class="Estilo5">TIPO PLANILLA :</span></td>
                <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtplanilla" type="text" id="txtplanilla" title="Registre el tipo de Planilla" value="<? echo $planilla ?>"  size="2" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_planilla(this.form);">  </span></td>
                <td width="380"><span class="Estilo5"><div id="desplan"><input class="Estilo10" name="txtdescripcion" type="text" id="txtdescripcion" size="50" value="<? echo $descripcion ?>" readonly> </div></span></td>
                <td width="120"><span class="Estilo5">NRO. PLANILLA :</span></td>
                <td width="100"><span class="Estilo5"><div id="nroplan"> <input class="Estilo10" name="txtnro_planilla" type="text" id="txtnro_planilla"  size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $nro_planilla ?>"> </div></span></td>
               </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="737" border="0">
            <tr>
              <td width="159"><span class="Estilo5">TIPO ENRIQUECIMIENTO :</span></td>
              <td width="474"> <span class="Estilo5">
              <div id="tipoen"> <select name="txttipo_en" id="txttipo_en" onFocus="encender(this)" onBlur="apagar(this)" >
               <option>SERVICIOS PRESTADOS</option> <option>HONORARIOS PROFESIONALES</option> <option>PUBLICIDAD</option>
              </select></div> </span> </td>
              <script language="JavaScript" type="text/JavaScript"> var mtipoe='<?php echo $tipo_en ?>';  ajaxSenddoc('GET', 'cargatipoenr.php?password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&valor='+mtipoe, 'tipoen', 'innerHTML'); </script>
              <td width="90"><span class="Estilo5"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="739" >
            <tr>
              <td width="128"><span class="Estilo5">TIPO DOCUMENTO: </span></td>
              <td width="108"><span class="Estilo5"><input class="Estilo10" name="txttipo_documento" type="text" id="txttipo_documento" size="12" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $tipo_documento ?>"> </span></td>
              <td width="133"><span class="Estilo5">NRO. DOCUMENTO: </span></td>
              <td width="131"><span class="Estilo5"><input class="Estilo10" name="txtnro_documento" type="text" id="txtnro_documento" size="15" maxlength="50"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $nro_documento ?>"></span></td>
              <td width="110"><span class="Estilo5">NRO. CONTROL: </span></td>
              <td width="101"><span class="Estilo5"><input class="Estilo10" name="txtnro_con_factura" type="text" id="txtnro_con_factura" size="15" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $nro_con_factura ?>"> </span></td>
            </tr>
          </table> </td>
        </tr>
        <tr>
          <td><table width="739" >
            <tr>
              <td width="128"><span class="Estilo5">FECHA FACTURA: </span></td>
              <td width="97"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $fechah ?>"> </span></td>
              <td width="115"><span class="Estilo5">TOTAL FACTURA: </span></td>
              <td width="151"><span class="Estilo5"><input class="Estilo10" name="txtmonto1" type="text" id="txtmonto1" size="20" maxlength="20" align="right" onFocus="encender(this)" onBlur="apaga_monto1(this)"  value="<? echo $monto1 ?>" onKeypress="return validarNum(event)"> </span></td>
              <td width="94"><span class="Estilo5">MONTO IVA: </span></td>
             <td width="126"><span class="Estilo5"><input class="Estilo10" name="txtmonto2" type="text" id="txtmonto2" size="15" maxlength="15" align="right" onFocus="encender(this)" onBlur="apaga_monto2(this)"  value="<? echo $monto2 ?>" onKeypress="return validarNum(event)"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>              </td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>              </td>
        </tr>
      </table>
        <table width="699" align="center">
          <tr>
            <td width="10"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="10"><input name="txtced_rif" type="hidden" id="txtced_rif"> </td>
            <td width="10"><input name="txtnombre" type="hidden" id="txtnombre"> </td>
			<td width="10"><input name="txtsustraendo" type="hidden" id="txtsustraendo"> </td>
            <td width="240"><input name="txttipo_operacion" type="hidden" id="txttipo_operacion" value="<?echo $tipo_operacion?>"></td>
            <td width="100" align="center" valign="middle"><input name="Incluir" type="submit" id="Incluir"  value="Incluir"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="250">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>