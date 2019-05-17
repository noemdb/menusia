<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$orden="";$tipo_ret=""; $aux_orden=""; $planilla="00"; $nro_planilla="00000000";  $mcod_m="BAN012".$equipo;$codigo_mov=substr($mcod_m,0,49);}
 else{$orden=$_GET["orden"];$tipo_ret=$_GET["tipo"];$aux_orden=$_GET["aux"]; $planilla=$_GET["planilla"];  $nro_planilla=$_GET["nro_planilla"]; $codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="02-0000018"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Modificar Retenciones de Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function chequea_planilla(mform){
var mref;
   mref=mform.txtplanilla.value; mref = Rellenarizq(mref,"0",2);  mform.txtplanilla.value=mref;
   ajaxSenddoc('GET', 'desplanilla.php?codigo='+mref+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'desplan', 'innerHTML');
   ajaxSenddoc('GET', 'numplanilla.php?codigo='+mref+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nroplan', 'innerHTML');
return true;}
function llamar_anterior(){document.location ='Det_ret_planillas.php?codigo_mov=<?echo $codigo_mov?>';}
function llamar_modificar(){var f=document.form1;var murl; var monto1; var monto2;
var tipo_en; var tipo_doc;  var nro_doc;  var nro_con; var fecha_f; var tipo_p;
  tipo_en=f.txttipo_en.value; tipo_doc=f.txttipo_documento.value;  monto1=f.txtmonto1.value; monto2=f.txtmonto2.value;
  nro_doc=f.txtnro_documento.value; nro_con=f.txtnro_con_factura.value;  fecha_f=f.txtfecha.value; tipo_p=f.txtplanilla.value;
  if(tipo_p=="00"){alert("Tipo de Planilla Invalida");}
  else{if(fecha_f==""){alert("Fecha de Factura Invalida");}
    else{murl="Update_plan_ret.php?codigo_mov=<?echo $codigo_mov?>&orden=<?echo $orden?>&tipo=<?echo $tipo_ret?>&nro_planilla=<?echo $nro_planilla?>&planilla=<?echo $planilla?>&tipo_en="+tipo_en+"&tipo_d="+tipo_doc+"&nro_doc="+nro_doc+"&nro_con_f="+nro_con+"&fecha_f="+fecha_f+"&monto1="+monto1+"&monto2="+monto2;  document.location=murl;} }
}
function llamar_eliminar(){var murl;var r;var f=document.form1;var tipo_op; var tipo_p;
  tipo_op=f.txttipo_operacion.value; tipo_p=f.txtplanilla.value;
  if(tipo_p=="00"){alert("Tipo de Planilla Invalida");}
  else{   murl="Esta seguro en Eliminar la Planilla de Retencion ?"; r=confirm(murl);
    if(r==true){ r=confirm("Esta Realmente seguro en Eliminar la Planilla de Retencion ?");
      if(r==true){murl="Delete_plan_ret.php?codigo_mov=<?echo $codigo_mov?>&orden=<?echo $orden?>&tipo=<?echo $tipo_ret?>&nro_planilla=<?echo $nro_planilla?>&planilla=<?echo $planilla?>&tipo_op="+tipo_op;document.location=murl;}}
     else { url="Cancelado, no elimino"; }
  }
}
function llamar_anular(){var murl;var r;var f=document.form1;var tipo_p;
  tipo_p=f.txtplanilla.value;
  if(tipo_p=="00"){alert("Tipo de Planilla Invalida");}
  else{  murl="Esta seguro en Anular la Planilla de Retencion ?";  r=confirm(murl);
    if(r==true){r=confirm("Esta Realmente seguro en Anular la Planilla de Retencion ?");
      if(r==true){murl="Anula_plan_ret.php?codigo_mov=<?echo $codigo_mov?>&orden=<?echo $orden?>&tipo=<?echo $tipo_ret?>&nro_planilla=<?echo $nro_planilla?>&planilla=<?echo $planilla?>"  ;document.location=murl;}}
     else { url="Cancelado, no elimino"; }
  }
}
function llamar_impimir(){var murl;var r;var f=document.form1;var tipo_p;
  tipo_p=f.txtplanilla.value;
  if(tipo_p=="00"){alert("Tipo de Planilla Invalida");}
  else{  murl="Desa Imprimir Planilla de Retención ?";  r=confirm(murl);
    if(r==true){murl="/sia/pagos/rpt/Rpt_comp_ret_iva.php?nro_planilla=<?echo $nro_planilla?>&planilla=<?echo $planilla?>";
        dwindow.open(url);}
    }
}
function apaga_monto1(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto1.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto1.value=mmonto;
return true;}
function apaga_monto2(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto2.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto2.value=mmonto;
return true;}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtnro_orden.value==""){alert("Número de Orden no puede estar Vacio");return false;}
   if(f.txttipo_retencion.value==""){alert("Tipo de Retención no puede estar Vacio"); return false; }
   if(f.txtplanilla.value==""){alert("Tipo de Planilla no puede estar Vacio"); return false; }
   if(f.txtplanilla.value=="00"){alert("Tipo de Planilla Invalido"); return false; }
   if(f.txtnro_planilla.value==""){alert("Número de Planilla no puede estar Vacio"); return false; }
   if(f.txtmonto_retencion.value==""){alert("Monto Retencion no puede estar Vacio");return false;}
   //if(f.txtret_grupo.value=="I"){ if(f.txtplanilla.value=="01"){Valido=true;}else{alert("Tipo de Planilla Invalido para esta Retencion"); return false;} }
   if(f.txtret_grupo.value=="I"){ if((f.txtplanilla.value=="01")||(f.txtplanilla.value=="02")||(f.txtplanilla.value=="03")){Valido=true;}else{alert("Tipo de Planilla Invalido para esta Retencion"); return false;} }
   
   //if(f.txttipo_retencion.value=="203"){ if(f.txtplanilla.value=="02"){Valido=true;}else{alert("Tipo de Planilla Invalido para esta Retencion"); return false;}}
   if(MontoValido(f.txtmonto_retencion.value)) {Valido=true;} else{alert("monto debe tener valores numéricos.");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 { font-size: 16px;font-weight: bold; color: #FFFFFF; }
-->
</style>
</head>
<?
$monto_r="";$monto_o=""; $monto1=0; $tasa=0; $monto2=0; $descripcion_ret=""; $tipo_en=""; $tipo_documento=""; $nro_documento=""; $nro_con_factura=""; $fecha=""; $descripcion=""; $tipo_operacion="A"; $ret_grupo="";
$sql="SELECT * FROM planilla_ret where codigo_mov='$codigo_mov' and nro_orden='$orden' and tipo_retencion='$tipo_ret' and tipo_planilla='$planilla' and nro_planilla='$nro_planilla'";$res=pg_query($sql); 
if ($registro=pg_fetch_array($res,0)){
  $orden=$registro["nro_orden"];  $aux_orden=$registro["aux_orden"]; $tipo_ret=$registro["tipo_retencion"];  $planilla=$registro["tipo_planilla"]; $nro_planilla=$registro["nro_planilla"]; $descripcion=$registro["descripcion"];
  $monto_r=formato_monto($registro["monto_retencion"]); $monto_o=formato_monto($registro["monto_objeto"]); $tasa=formato_monto($registro["tasa"]); $monto1=formato_monto($registro["monto1"]);  $monto2=formato_monto($registro["monto2"]);
  $descripcion_ret=$registro["descripcion_ret"]; $tipo_en=$registro["tipo_en"];   $tipo_documento=$registro["tipo_documento"]; $tipo_operacion=$registro["tipo_operacion"];
  $nro_documento=$registro["nro_documento"];  $nro_con_factura=$registro["nro_con_factura"]; $sfecha=$registro["fecha_factura"];  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
}
$sSQL="SELECT tipo_retencion,descripcion_ret,ret_grupo FROM PAG003 WHERE tipo_retencion='$tipo_ret'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);if ($filas>=1){ $reg=pg_fetch_array($resultado); $ret_grupo=$reg["ret_grupo"]; }  
?>
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
              <td width="139"><span class="Estilo5">N&Uacute;MERO DE ORDEN :</span></td>
              <td width="177"><span class="Estilo5"> <input class="Estilo10" name="txtnro_orden" type="text" id="txtnro_orden" size="20" maxlength="15" readonly value="<? echo $orden ?>"></span></span></td>
              <td width="181"><span class="Estilo5">ORDEN DE RETENCI&Oacute;N :</span></td>
              <td width="212"><span class="Estilo5"><input class="Estilo10" name="txtaux_orden" type="text" id="txtaux_orden" size="20" maxlength="15" readonly value="<? echo $aux_orden ?>"></span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="737">
            <tr>
              <td width="117"><span class="Estilo5">TIPO RETENCI&Oacute;N :</span></td>
              <td width="48"><span class="Estilo5"><input class="Estilo10" name="txttipo_retencion" type="text" id="txttipo_retencion" size="3" maxlength="3" value="<? echo $tipo_ret ?>"  readonly></span></td>
              <td width="556"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_ret" type="text" id="txtdescripcion_ret"  readonly  size="90" value="<? echo $descripcion_ret ?>"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="733" border="0">
            <tr>
              <td width="47"><span class="Estilo5">TASA :</span></td>
              <td width="77"><span class="Estilo5"><input class="Estilo10" name="txttasa" type="text" id="txttasa" size="6" maxlength="6" style="text-align:right"  readonly value="<? echo $tasa ?>"> </span></td>
              <td width="111"><span class="Estilo5">MONTO OBJETO :</span></td>
              <td width="215"><span class="Estilo5"><input class="Estilo10" name="txtmonto_objeto" type="text" id="txmonto_objeto" size="25" style="text-align:right"  maxlength="22" readonly value="<? echo $monto_o ?>"></span></td>
              <td width="83"><span class="Estilo5">RETENCI&Oacute;N :</span></td>
              <td width="174"><span class="Estilo5"><input class="Estilo10" name="txtmonto_retencion" type="text" id="txtmonto_retencion" size="25" style="text-align:right"  maxlength="22" readonly value="<? echo $monto_r ?>"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="733" border="0">
              <tr>
                <td width="100"><span class="Estilo5">TIPO PLANILLA :</span></td>
                <?  if($planilla=="00"){?>
                <td width="20"><span class="Estilo5"><input class="Estilo10" name="txtplanilla" type="text" id="txtplanilla" title="Registre el tipo de Planilla" value="<? echo $planilla ?>"  size="2" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_planilla(this.form);">  </span></td>
                <?  } else {?>
                <td width="20"><span class="Estilo5"><input class="Estilo10" name="txtplanilla" type="text" id="txtplanilla" value="<? echo $planilla ?>"  size="2" maxlength="2" readonly>  </span></td>
                <?  }?>
                <td width="415"><span class="Estilo5"><div id="desplan"><input class="Estilo10" name="txtdescripcion" type="text" id="txtdescripcion" size="60" value="<? echo $descripcion ?>" readonly> </div></span></td>
                <td width="100"><span class="Estilo5">NRO. PLANILLA :</span></td>
                <?  if($planilla=="00"){?>
                <td width="85"><span class="Estilo5"><div id="nroplan">
                  <input class="Estilo10" name="txtnro_planilla" type="text" id="txtnro_planilla"  size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $nro_planilla ?>"> </div></span></td>
                <?  } else {?>
                <td width="85"><span class="Estilo5"><input class="Estilo10" name="txtnro_planilla" type="text" id="txtnro_planilla" size="10" maxlength="8"  readonly value="<? echo $nro_planilla ?>"> </span></td>
                <?  }?>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="737" border="0">
            <tr>
              <td width="159"><span class="Estilo5">TIPO ENRIQUECIMIENTO :</span></td>
              <td width="474"> <span class="Estilo5"> <div id="tipoen"> <select class="Estilo10" name="txttipo_en" id="txttipo_en" onFocus="encender(this)" onBlur="apagar(this)" >
                  <option>SERVICIOS PRESTADOS</option> <option>HONORARIOS PROFESIONALES</option> <option>PUBLICIDAD</option> </select></div> </span> </td>
              <script language="JavaScript" type="text/JavaScript"> var mtipoe='<?php echo $tipo_en ?>';  ajaxSenddoc('GET', 'cargatipoenr.php?password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&valor='+mtipoe, 'tipoen', 'innerHTML'); </script>
              <td width="90"><span class="Estilo5"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="739" >
            <tr>
              <td width="128"><span class="Estilo5">TIPO DOCUMENTO : </span></td>
              <td width="108"><span class="Estilo5"><input class="Estilo10" name="txttipo_documento" type="text" id="txttipo_documento" size="12" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $tipo_documento ?>"> </span></td>
              <td width="133"><span class="Estilo5">NRO. DOCUMENTO : </span></td>
              <td width="131"><span class="Estilo5"><input class="Estilo10" name="txtnro_documento" type="text" id="txtnro_documento" size="15" maxlength="50"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $nro_documento ?>"></span></td>
              <td width="110"><span class="Estilo5">NRO. CONTROL : </span></td>
              <td width="101"><span class="Estilo5"><input class="Estilo10" name="txtnro_con_factura" type="text" id="txtnro_con_factura" size="15" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $nro_con_factura ?>"> </span></td>
            </tr>
          </table> </td>
        </tr>
        <tr>
          <td><table width="739" >
            <tr>
              <td width="128"><span class="Estilo5">FECHA FACTURA: </span></td>
              <td width="97"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $fecha ?>"> </span></td>
              <td width="115"><span class="Estilo5">TOTAL FACTURA: </span></td>
              <td width="151"><span class="Estilo5"><input class="Estilo10" name="txtmonto1" type="text" id="txtmonto1" size="20" maxlength="20" style="text-align:right"  onFocus="encender(this)" onBlur="apaga_monto1(this)"  value="<? echo $monto1 ?>" onKeypress="return validarNum(event)"> </span></td>
              <td width="94"><span class="Estilo5">MONTO IVA: </span></td>
             <td width="126"><span class="Estilo5"><input class="Estilo10" name="txtmonto2" type="text" id="txtmonto2" size="15" maxlength="15" style="text-align:right"  onFocus="encender(this)" onBlur="apaga_monto2(this)"  value="<? echo $monto2 ?>" onKeypress="return validarNum(event)"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td><p>&nbsp;</p> </td> </tr>
        <tr> <td><p>&nbsp;</p></td></tr>
      </table>
        <table width="740" align="center">
          <tr>
            <td width="10"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="10"><input name="txttipo_operacion" type="hidden" id="txttipo_operacion" value="<?echo $tipo_operacion?>"></td>
            <td width="10"><input name="txtret_grupo" type="hidden" id="txtret_grupo" value="<?echo $ret_grupo?>"></td>
			<?if ($Mcamino{0}=="S"){?>
            <td width="140" align="center" valign="middle"><input name="Atras" type="submit" id="Atras"  value="Incluir"></td>
			<?} if ($Mcamino{1}=="S"){?>
            <td width="140" align="center"><input name="Modificar" type="button" id="Modificar" value="Modificar" onClick="JavaScript:llamar_modificar()"></td>
            <?} ?>
			<td width="140" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <?if ($Mcamino{6}=="S"){?>
			<td width="140" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
            <?} if ($Mcamino{7}=="S"){?>
			<td width="140" align="center"><input name="Anular" type="button" id="Anular" value="Anular" onClick="JavaScript:llamar_anular()"></td>
             <?} ?>
			 <td width="20">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>