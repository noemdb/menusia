<?include ("../class/conect.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME");  $codigo_mov="";
if (!$_GET){$tipo_nomina="";$cod_concepto="";$cod_empleado="";} else{$tipo_nomina=$_GET["tipo_nomina"];$cod_concepto=$_GET["cod_concepto"];$cod_empleado=$_GET["cod_empleado"];}
$criterio=$tipo_nomina.$cod_concepto; if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Modificar Prestamo)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
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
function apaga_monto(mthis){var mmonto;  apagar(mthis); mmonto=mthis.value;  mmonto=daformatomonto(mmonto);   mthis.value=mmonto; } 
function encende_monto(mthis){var mmonto; encender(mthis);   mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }


function llamar_eliminar(){var murl; var r;
  murl="Esta seguro en Eliminar Asignacion del Prestamo ?"; r=confirm(murl);
  if(r==true){r=confirm("Esta Realmente seguro en Eliminar la Asignacion del Prestamo ?");
    if(r==true){murl="Delete_prestamo.php?tipo_nomina=<?echo $tipo_nomina?>&cod_empleado=<?echo $cod_empleado?>&cod_concepto=<?echo $cod_concepto?>"; document.location=murl;}}
   else{url="Cancelado, no elimino";}
}
function llamar_anterior(){ document.location ='Det_prestamo.php?criterio=<?echo $criterio?>'; }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}
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
$cantidad=0;$monto=0;$fecha_ini="";$fecha_exp="";$activo="";$calculable="";$denominacion="";$descripcion="";$nombre="";$frec="0";$imp_fija="SI";
$sql="Select * from CONCEPTOS_ASIGNADOS where tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and  cod_concepto='$cod_concepto' ".$criterioc.""; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];  $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  $fecha_ini=formato_ddmmaaaa($registro["fecha_ini"]); $fecha_exp=formato_ddmmaaaa($registro["fecha_exp"]);
  $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"]; $activo=$registro["activoa"]; $calculable=$registro["calculable"]; $frec=$registro["frecuenciaa"];
  $acumulado=$registro["acumulado"]; $saldo=$registro["saldo"]; $prestamo=$registro["prestamo"]; $monto_prestamo=$registro["monto_prestamo"]; $nro_cuotas=$registro["nro_cuotas"]; $nro_cuotas_c=$registro["nro_cuotas_c"];
  $cantidad=formato_monto($cantidad); $monto=formato_monto($monto);$acumulado=formato_monto($acumulado); $saldo=formato_monto($saldo);  $monto_prestamo=formato_monto($monto_prestamo); $nro_cuotas=intval($nro_cuotas); $nro_cuotas_c=intval($nro_cuotas_c);
}
if($frec=="1"){$frecuencia="PRIMERA QUINCENA";} if($frec=="2"){$frecuencia="SEGUNDA QUINCENA";} if($frec=="3"){$frecuencia="PRIMERA Y SEGUNDA QUINCENA";}
if($frec=="4"){$frecuencia="PRIMERA SEMANA";} if($frec=="5"){$frecuencia="SEGUNDA SEMANA";} if($frec=="6"){$frecuencia="TERCERA SEMANA";}
if($frec=="7"){$frecuencia="CUARTA SEMANA";} if($frec=="8"){$frecuencia="QUINTA SEMANA";} if($frec=="9"){$frecuencia="TODAS LAS SEMANAS";} if($frec=="0"){$frecuencia="ULTIMA SEMANA";}
?>
<body>
<form name="form1" method="post" action="Update_prestamo.php" onSubmit="return revisar()">
  <table width="761" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="760" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR PRESTAMO</span></td>
        </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="100"><span class="Estilo5">TRABAJADOR : </span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" readonly value="<?echo $cod_empleado?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="510"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="70" maxlength="70" readonly value="<?echo $nombre?>" onkeypress="return tabular(event,this)"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="100"><span class="Estilo5">NRO. CUOTAS : </span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtnro_cuotas" type="text" id="txtnro_cuotas" style="text-align:right" size="6" maxlength="6" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?echo $nro_cuotas?>" onKeypress="return validarNum(event,this)"> </span></td>
                   <td width="110"><span class="Estilo5">MONTO CUOTA : </span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" style="text-align:right" size="14" maxlength="14" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto?>" onKeypress="return validarNum(event,this)"> </span></td>
                   <td width="150"><span class="Estilo5">MONTO PRESTAMO : </span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtmonto_prestamo" type="text" id="txtmonto_prestamo" style="text-align:right" size="14" maxlength="14" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto_prestamo?>" onKeypress="return validarNum(event,this)"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="160"><span class="Estilo5">CUOTAS CANCELADAS : </span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtnro_cuotas_c" type="text" id="txtnro_cuotas_c" style="text-align:right" size="6" maxlength="6" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?echo $nro_cuotas_c?>" onKeypress="return validarNum(event,this)"> </span></td>
                   <td width="110"><span class="Estilo5">ACUMULADO : </span></td>
                   <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtacumulado" type="text" id="txtacumulado" style="text-align:right" size="14" maxlength="14" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?echo $acumulado?>" onKeypress="return validarNum(event,this)"> </span></td>
                   <td width="80"><span class="Estilo5">SALDO : </span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtsaldo" type="text" id="txtsaldo" style="text-align:right" size="14" maxlength="14" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?echo $saldo?>" onKeypress="return validarNum(event,this)"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="110"><span class="Estilo5">FECHA DESDE : </span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ini" type="text" id="txtfecha_ini"  size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_ini?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="100"><span class="Estilo5">FECHA HASTA : </span></td>
                   <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_exp" type="text" id="txtfecha_exp"  size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_exp?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="100"><span class="Estilo5">ACTIVO : </span></td>
                   <td width="100"><span class="Estilo5"><select name="txtactivo" size="1" id="txtactivo" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>                   
				 </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript"> var mvalor='<?echo $activo;?>';var f=document.form1; 
if(mvalor=="SI"){document.form1.txtactivo.options[0].selected=true;}else{document.form1.txtactivo.options[1].selected=true;}}
</script>
        <tr> <td>&nbsp;</td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input name="txtcriterio" type="hidden" id="txtcriterio" value="<?echo $criterio?>"></td>
            <td width="20"><input name="txttipo_nomina" type="hidden" id="txttipo_nomina" value="<?echo $tipo_nomina?>"></td>
            <td width="20"><input name="txtcod_concepto" type="hidden" id="txtcod_concepto" value="<?echo $cod_concepto?>"></td>
            <td width="60">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
			<td width="100" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
            <td width="120">&nbsp;</td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>