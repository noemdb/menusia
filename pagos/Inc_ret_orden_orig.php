<?php  include ("../class/conect.php"); include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$mcod_m="PAG001".$usuario_sia.$equipo;$codigo_mov=substr($mcod_m,0,49);}
else{$codigo_mov=$_GET["codigo_mov"];$user=$_GET["user"];$password=$_GET["password"];$dbname=$_GET["dbname"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Incluir Retencion en la orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto (monto){var i;var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if ((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function llamar_anterior(){ document.location ='Det_inc_ret_orden.php?codigo_mov=<?php echo $codigo_mov?>&bloqueada=N'; }
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_retencion.value;  mref=Rellenarizq(mref,"0",3);  mform.txttipo_retencion.value=mref;
return true;}
function apaga_tipo(mthis){ var mref;var mmonto; var mtasa; var msust;
   apagar(mthis);
   mmonto=quitaformatomonto(document.form1.txtmonto_objeto.value);
   mtasa=quitaformatomonto(document.form1.txttasa.value);
   msust=quitaformatomonto(document.form1.txtsustraendo.value);   
   msust=(msust*1);   mmonto=(mmonto*1);
   mtasa=(mmonto*(mtasa/100));    mtasa=Math.round(mtasa*100)/100;
   if(mtasa>0){mtasa=mtasa-msust;  if(mtasa>0){ mtasa=Math.round(mtasa*100)/100;}else{mtasa=0;} }   
   document.form1.txtmonto_retencion.value=mtasa;
   document.form1.txtmonto_retencion.value=daformatomonto(document.form1.txtmonto_retencion.value);
return true;}
function chequea_cod_ret(mform){var mref;
   mref=mform.txtcod_ret.value;
   ajaxSenddoc('GET', 'amontob.php?mref='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'montOb', 'innerHTML');
return true;}
function apaga_cod_ret(mthis){ var mref;var mmonto; var mtasa; var msust;
   apagar(mthis);
   mref=document.form1.txtcod_ret.value;
   ajaxSenddoc('GET', 'amontob.php?mref='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'montOb', 'innerHTML');
   mmonto=quitaformatomonto(document.form1.txtmonto_objeto.value);
   mtasa=quitaformatomonto(document.form1.txttasa.value);
   msust=quitaformatomonto(document.form1.txtsustraendo.value);
   msust=(msust*1);   mmonto=(mmonto*1);
   mtasa=(mmonto*(mtasa/100));    mtasa=Math.round(mtasa*100)/100;
   if(mtasa>0){mtasa=mtasa-msust;  if(mtasa>0){ mtasa=Math.round(mtasa*100)/100;}else{mtasa=0;} }   
   document.form1.txtmonto_retencion.value=mtasa;  
   document.form1.txtmonto_retencion.value=daformatomonto(document.form1.txtmonto_retencion.value);
return true;}
function chequea_tasa(mform){var mmonto; var mtasa;  var msust;
   mmonto=document.form1.txttasa.value;  mmonto=camb_punto_coma(mmonto); document.form1.txttasa.value=mmonto;  
   mmonto=quitaformatomonto(mform.txtmonto_objeto.value);
   mtasa=quitaformatomonto(mform.txttasa.value);
   msust=quitaformatomonto(mform.txtsustraendo.value);
    msust=(msust*1);   mmonto=(mmonto*1);
   mtasa=(mmonto*(mtasa/100));    mtasa=Math.round(mtasa*100)/100;
   if(mtasa>0){mtasa=mtasa-msust;  if(mtasa>0){ mtasa=Math.round(mtasa*100)/100;}else{mtasa=0;} }
   mform.txtmonto_retencion.value=mtasa;
   mform.txtmonto_retencion.value=daformatomonto(mform.txtmonto_retencion.value);
return true;}
function apaga_tasa(mthis){var mmonto; var mtasa;  var msust;
   apagar(mthis);
   mmonto=quitaformatomonto(document.form1.txtmonto_objeto.value);
   msust=quitaformatomonto(document.form1.txtsustraendo.value);
   mtasa=mthis.value; mtasa=quitaformatomonto(mtasa);
   msust=(msust*1);   mmonto=(mmonto*1);
   mtasa=(mmonto*(mtasa/100));    mtasa=Math.round(mtasa*100)/100;
   if(mtasa>0){mtasa=mtasa-msust;  if(mtasa>0){ mtasa=Math.round(mtasa*100)/100;}else{mtasa=0;} }
   document.form1.txtmonto_retencion.value=mtasa;
   document.form1.txtmonto_retencion.value=daformatomonto(document.form1.txtmonto_retencion.value);
return true;}
function encende_objeto(mthis){var mmonto; encender(mthis); 
  mmonto=document.form1.txtmonto_objeto.value; mmonto=eliminapunto(mmonto); document.form1.txtmonto_objeto.value=mmonto; 
}
function chequea_objeto(mform){var mmonto; var mtasa;  var msust;
   mmonto=mform.txtmonto_objeto.value;   mmonto=camb_punto_coma(mmonto); document.form1.txtmonto_objeto.value=mmonto;  
   mmonto=quitaformatomonto(mform.txtmonto_objeto.value);
   mtasa=quitaformatomonto(mform.txttasa.value);
   msust=quitaformatomonto(mform.txtsustraendo.value);
   msust=(msust*1);   mmonto=(mmonto*1);
   mtasa=(mmonto*(mtasa/100));    mtasa=Math.round(mtasa*100)/100;
   if(mtasa>0){mtasa=mtasa-msust;  if(mtasa>0){ mtasa=Math.round(mtasa*100)/100;}else{mtasa=0;} }
   mform.txtmonto_retencion.value=mtasa;
   mform.txtmonto_retencion.value=daformatomonto(mform.txtmonto_retencion.value);
return true;}
function apaga_objeto(mthis){var mmonto;  var mtasa;  var msust;
 apagar(mthis);
 mmonto=mthis.value; mmonto=camb_punto_coma(mmonto); mmonto=quitaformatomonto(mmonto);
 mtasa=quitaformatomonto(document.form1.txttasa.value);
 msust=quitaformatomonto(document.form1.txtsustraendo.value);
 msust=(msust*1);   mmonto=(mmonto*1);
 mtasa=(mmonto*(mtasa/100));    mtasa=Math.round(mtasa*100)/100;
 if(mtasa>0){mtasa=mtasa-msust;  if(mtasa>0){ mtasa=Math.round(mtasa*100)/100;}else{mtasa=0;} }
 document.form1.txtmonto_retencion.value=mtasa;
 document.form1.txtmonto_retencion.value=daformatomonto(document.form1.txtmonto_retencion.value);
return true;}
function apaga_monto(mthis){var mmonto;  apagar(mthis);
 mmonto=document.form1.txtmonto_retencion.value;  mmonto=camb_punto_coma(mmonto); document.form1.txtmonto_retencion.value=mmonto;}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_ret.value==""){alert("Codigo Presupuestario no puede estar Vacio");return false;}
   if(f.txttipo_retencion.value==""){alert("Tipo de Retenecion no puede estar Vacio"); return false; }
   if(f.txtced_rif.value==""){alert("Cedula/Rif no puede estar Vacia"); return false; } else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
   if(f.txtmonto_retencion.value==""){alert("Monto Retencion no puede estar Vacio");return false;}
   if(f.txttasa.value==""){alert("Tasa no puede estar Vacio");return false;}
   if(f.txtmonto_objeto.value==""){alert("Monto Objeto no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold;  color: #FFFFFF; }
-->
</style>
</head>
<?php 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $cod_part_iva="403-18-01";
$StrSQL="select * from pre026 where codigo_mov='$codigo_mov' and (monto>0) and (cod_presup not in (select cod_presup from pre026 where (cod_presup LIKE '%$cod_part_iva%'))) order by tipo_compromiso,referencia_comp,cod_presup,fuente_financ"; $res=pg_query($StrSQL); $monto_objeto=0;
if ($registro=pg_fetch_array($res,0)){ $monto_objeto=$registro["monto"];} $monto_objeto=formato_monto($monto_objeto);
?>
<body>
<form name="form1" method="post" action="Insert_ret_orden.php" onSubmit="return revisar()">
  <table width="746" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="742" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR NUEVA RETENCION EN LA ORDEN</span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="737">
            <tr>
              <td width="112"><span class="Estilo5">TIPO RETENCI&Oacute;N:</span></td>
              <td width="46"><span class="Estilo5"><input class="Estilo10" name="txttipo_retencion" type="text" id="txttipo_retencion" size="4" maxlength="3"  onFocus="encender(this)" onBlur="apaga_tipo(this)"  onchange="chequea_tipo(this.form);"> </span></td>
              <td width="43"><input class="Estilo10" name="bttiporet" type="button" id="bttiporet" title="Abrir Catalogo Tipos de Retencion" onclick="VentanaCentrada('Cat_tipo_ret.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
              <td width="497"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_ret" type="text" id="txtdescripcion_ret"  readonly  size="77">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="732" border="0">
            <tr>
              <td width="184"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO : </span></td>
			  
			  
              <td width="538"><span class="Estilo5"><div id="codigop"><select name="txtcod_ret" id="txtcod_ret" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_cod_ret(this.form);">
                    <option value="  "> </option> </select>
                </div>
                <script language="JavaScript" type="text/JavaScript">
                    ajaxSenddoc('GET','cargacodest.php?codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'codigop', 'innerHTML');
               </script> </span> </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="733" border="0">
            <tr>
              <td width="42"><span class="Estilo5">TASA:</span></td>
              <td width="57"><span class="Estilo5"><input class="Estilo10" name="txttasa" type="text" id="txttasa" size="5" maxlength="5"  onFocus="encender(this)" onBlur="apaga_tasa(this)" onchange="chequea_tasa(this.form);" onKeypress="return validarNum(event)"> </span></td>
              <td width="90"><span class="Estilo5">SUSTRAENDO:</span></td>
              <td width="75"><span class="Estilo5"><input class="Estilo10" name="txtsustraendo" type="text" id="txtsustraendo" size="6" maxlength="5"  readonly onchange="chequea_tasa(this.form);" onKeypress="return validarNum(event)"> </span></td>
              <td width="111"><span class="Estilo5">MONTO OBJETO: </span></td>
              <td width="135"><span class="Estilo5"><div id="montOb"> <input class="Estilo10" name="txtmonto_objeto" type="text" id="txtmonto_objeto" size="15" style="text-align:right" maxlength="22"  onFocus="encende_objeto(this)" onBlur="apaga_objeto(this)" value="<?php echo $monto_objeto?>" onchange="chequea_objeto(this.form);" onKeypress="return validarNum(event)"> </div></span></td>
              <td width="83"><span class="Estilo5">RETENCI&Oacute;N:</span></td>
              <td width="114"><span class="Estilo5"><input class="Estilo10" name="txtmonto_retencion" type="text" id="txtmonto_retencion" size="14" style="text-align:right" maxlength="22" onFocus="encender(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event)">    </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="737" border="0">
            <tr>
              <td width="145"><span class="Estilo5">CED/RIF BENEFICIARIO:</span></td>
              <td width="153"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
              <td width="40"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../presupuesto/Cat_beneficiarios.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
              <td width="375"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="60" readonly>  </span> </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>   </td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>  </td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="20"><input class="Estilo10" name="txtdes_orden_ret" type="hidden" id="txtdes_orden_ret" ></td>
            <td width="80">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="96" align="center"><input  name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>   </td>
    </tr>
  </table>
</form>
</body>
</html>
