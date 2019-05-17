<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../../class/configura.inc"); $equipo=getenv("COMPUTERNAME");  $codigo_mov="";
if (!$_GET){$tipo_nomina="";$cod_concepto="";$cod_empleado="";$tipof="";} else{$tipo_nomina=$_GET["tipo_nomina"];$cod_concepto=$_GET["cod_concepto"];$cod_empleado=$_GET["cod_empleado"];$tipof=$_GET["tipof"];}
$criterio=$tipo_nomina.$cod_concepto.$tipof;
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Modificar Carga Manual)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;}
function apaga_cantidad(mthis){var mmonto;
   apagar(mthis);    mmonto=document.form1.txtcantidad.value;  mmonto=camb_punto_coma(mmonto); document.form1.txtcantidad.value=mmonto;
return true;}
function encende_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }

function apaga_monto(mthis){var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto); document.form1.txtmonto.value=mmonto;
return true;}
function llamar_anterior(){ document.location ='Det_carga_manual.php?criterio=<?echo $criterio?>'; }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}
   if(f.txtcantidad.value==""){alert("Cantidad no puede estar Vacio");return false;}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
document.form1.submit;
return true;}
function tabular(e,obj) {
  tecla=(document.all) ? e.keyCode : e.which;
  if(tecla!=13) return;  frm=obj.form;  
  for(i=0;i<frm.elements.length;i++)
    if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }
  frm.elements[i+1].focus();
return false;} 
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $observacion="";
$cantidad=0;$monto=0;$fecha_ini="";$fecha_exp="";$activo="";$calculable="";$denominacion="";$descripcion="";$nombre="";$frec="0";$imp_fija="SI"; $fecha_ini="";$fecha_exp=""; $cod_presup="";
$sql="Select * from CONCEPTOS_ASIGNADOS where tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and  cod_concepto='$cod_concepto' ".$criterioc.""; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];  $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
  $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"]; $activo=$registro["activoa"]; $calculable=$registro["calculable"]; $frec=$registro["frecuenciaa"];
  $cantidad=formato_monto($cantidad); $monto=formato_monto($monto); $fecha_ini=$registro["fecha_ini"]; $fecha_exp=$registro["fecha_exp"]; $cod_presup=$registro["cod_presup"];
  $afecta_presup=$registro["afecta_presup"]; $cod_retencion=$registro["cod_retencion"]; $observacion=$registro["observacion"]; $fecha_ini=formato_ddmmaaaa($fecha_ini); $fecha_exp=formato_ddmmaaaa($fecha_exp);
}
if($frec=="1"){$frecuencia="PRIMERA QUINCENA";} if($frec=="2"){$frecuencia="SEGUNDA QUINCENA";} if($frec=="3"){$frecuencia="PRIMERA Y SEGUNDA QUINCENA";}
if($frec=="4"){$frecuencia="PRIMERA SEMANA";} if($frec=="5"){$frecuencia="SEGUNDA SEMANA";} if($frec=="6"){$frecuencia="TERCERA SEMANA";}
if($frec=="7"){$frecuencia="CUARTA SEMANA";} if($frec=="8"){$frecuencia="QUINTA SEMANA";} if($frec=="9"){$frecuencia="TODAS LAS SEMANAS";} if($frec=="0"){$frecuencia="ULTIMA SEMANA";}
?>
<body>
<form name="form1" method="post" action="Update_carga_manual.php" onSubmit="return revisar()">
  <table width="761" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="660" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR CARGA MANUAL </span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="100"><span class="Estilo5">TRABAJADOR : </span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" readonly value="<?echo $cod_empleado?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="510"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="60" maxlength="60" readonly value="<?echo $nombre?>" onkeypress="return tabular(event,this)"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="100"><span class="Estilo5">FECHA INICIO : </span></td>
                   <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ini" type="text" id="txtfecha_ini" size="10" maxlength="10" readonly value="<?echo $fecha_ini?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="130"><span class="Estilo5">FECHA EXPIRACI&Oacute;N : </span></td>
                   <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_exp" type="text" id="txtfecha_exp" size="10" maxlength="10" readonly value="<?echo $fecha_exp?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="100"><span class="Estilo5">COD. PRESUP. : </span></td>
                   <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" size="32" maxlength="32" readonly value="<?echo $cod_presup?>" onkeypress="return tabular(event,this)"></span></td>
               
                 </tr>
             </table></td>
           </tr>
		   <tr> <td>&nbsp;</td> </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_activo(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtactivo.options[0].selected=true;}else{document.form1.txtactivo.options[1].selected=true;}}
function asig_calculable(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtcalculable.options[0].selected=true;}else{document.form1.txtcalculable.options[1].selected=true;}}
function asig_frecuencia(mvalor){var f=document.form1;
    if(mvalor=="PRIMERA QUINCENA"){document.form1.txtfrecuencia.options[0].selected = true;} if(mvalor=="SEGUNDA QUINCENA"){document.form1.txtfrecuencia.options[1].selected = true;}
    if(mvalor=="PRIMERA Y SEGUNDA QUINCENA"){document.form1.txtfrecuencia.options[2].selected = true;} if(mvalor=="PRIMERA SEMANA"){document.form1.txtfrecuencia.options[3].selected = true;}
    if(mvalor=="SEGUNDA SEMANA"){document.form1.txtfrecuencia.options[4].selected = true;} if(mvalor=="TERCERA SEMANA"){document.form1.txtfrecuencia.options[5].selected = true;}
    if(mvalor=="CUARTA SEMANA"){document.form1.txtfrecuencia.options[6].selected = true;}  if(mvalor=="QUINTA SEMANA"){document.form1.txtfrecuencia.options[7].selected = true;}
    if(mvalor=="TODAS LAS SEMANAS"){document.form1.txtfrecuencia.options[8].selected = true;} if(mvalor=="ULTIMA SEMANA"){document.form1.txtfrecuencia.options[9].selected = true;}
}</script>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="90"><span class="Estilo5">ACTIVO : </span></td>
                   <td width="90"><span class="Estilo5"><select name="txtactivo" size="1" id="txtactivo" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="90"><span class="Estilo5">CALCULABLE : </span></td>
                   <td width="90"><span class="Estilo5"><select name="txtcalculable" size="1" id="txtcalculable" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="90"><span class="Estilo5">FRECUENCIA : </span></td>
                   <td width="310"><span class="Estilo5"><div id="dfrec"><select name="txtfrecuencia" size="1" id="txtfrecuencia" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)">
                      <option>PRIMERA QUINCENA</option> <option>SEGUNDA QUINCENA</option> <option>PRIMERA Y SEGUNDA QUINCENA</option>
                      <option>PRIMERA SEMANA</option> <option>SEGUNDA SEMANA</option> <option>TERCERA SEMANA</option> <option>CUARTA SEMANA</option>
                      <option>QUINTA SEMANA</option> <option>TODAS LAS SEMANAS</option> <option>ULTIMA SEMANA</option> </select> </div> </span></td>

<script language="JavaScript" type="text/JavaScript"> asig_activo('<?echo $activo;?>'); asig_calculable('<?echo $calculable;?>'); asig_frecuencia('<?echo $frecuencia;?>');  </script>
                  </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="100"><span class="Estilo5">CANTIDAD : </span></td>
                   <td width="260"><span class="Estilo5"><input class="Estilo10" name="txtcantidad" type="text" id="txtcantidad" style="text-align:right" size="14" maxlength="14" onFocus="encende_monto(this)" onBlur="apaga_cantidad(this)" value="<?echo $cantidad?>" onKeypress="return validarNum(event,this)" > </span></td>
                   <td width="100"><span class="Estilo5">MONTO : </span></td>
				   <?if (($cod_concepto=="001")){?>
                    <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" style="text-align:right" size="14" maxlength="14"  value="<?echo $monto?>" readonly> </span></td>
					<?} else{?>
                   <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" style="text-align:right" size="14" maxlength="14" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto?>" onKeypress="return validarNum(event,this)"> </span></td>
                   <?}?>
				 </tr>
             </table></td>
           </tr>
        <tr> <td>&nbsp;</td> </tr>
		<tr>
             <td><table width="760">
                 <tr>
                   <td width="100"><span class="Estilo5">OBSERVACION : </span></td>
                   <td width="660"><span class="Estilo5"><input class="Estilo10" name="txtobservacion" type="text" id="txtobservacion" size="90" maxlength="100" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $observacion?>" onkeypress="return tabular(event,this)"> </span></td>
                 </tr>
             </table></td>
           </tr>
        <tr> <td>&nbsp;</td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input class="Estilo10" name="txtcriterio" type="hidden" id="txtcriterio" value="<?echo $criterio?>"></td>
            <td width="20"><input class="Estilo10" name="txttipo_nomina" type="hidden" id="txttipo_nomina" value="<?echo $tipo_nomina?>"></td>
            <td width="20"><input class="Estilo10" name="txtcod_concepto" type="hidden" id="txtcod_concepto" value="<?echo $cod_concepto?>"></td>
            <td width="100">&nbsp;</td>
			<td width="80">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100">&nbsp;</td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>