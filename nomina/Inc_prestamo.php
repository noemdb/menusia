<?include ("../class/conect.php");  include ("../class/funciones.php");?>
<?$equipo=getenv("COMPUTERNAME");  $codigo_mov=""; $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$criterio="";} else{$criterio=$_GET["criterio"];} $tipo_nomina=substr($criterio,0,2);$cod_concepto=substr($criterio,2,3);$cod_empleado="";
$criterio=$tipo_nomina.$cod_concepto; $activo="SI";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Incluir Prestamo)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}

function quitacomas (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ".";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function cambia_punto_coma (monto){var i;var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ",";} else{if (monto.charAt(i) == '.'){str2 = str2 + ',';}else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } } }
   return str2;}   

function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;}
function apaga_monto(mthis){var mmonto;  apagar(mthis); mmonto=mthis.value;  mmonto=daformatomonto(mmonto);   mthis.value=mmonto; } 
function encende_monto(mthis){var mmonto; encender(mthis);   mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }
function tabular(e,obj) {
  tecla=(document.all) ? e.keyCode : e.which;
  if(tecla!=13) return;  frm=obj.form;  
  for(i=0;i<frm.elements.length;i++)
    if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }
  frm.elements[i+1].focus();
return false;} 

function chequea_monto(mform){var mmonto; var mcantidad; var smonto=mform.txtmonto.value; 
   smonto=cambia_punto_coma(smonto); mform.txtmonto.value=smonto;
   mcantidad=quitaformatomonto(mform.txtnro_cuotas.value);
   mmonto=quitacomas(smonto); mmonto=(mmonto*1);  mmonto=(mmonto*mcantidad); mmonto=Math.round(mmonto*100)/100;
   mform.txtmonto_prestamo.value=mmonto;  mform.txtmonto_prestamo.value=cambia_punto_coma(mform.txtmonto_prestamo.value);
   mform.txtsaldo.value=mmonto;  mform.txtsaldo.value=cambia_punto_coma(mform.txtsaldo.value); 
return true;}
function llamar_anterior(){ document.location ='Det_prestamo.php?criterio=<?echo $criterio?>'; }
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}
   if(f.txtnro_cuotas.value==""){alert("Numero de Cuotas no puede estar Vacio");return false;}
   if(f.txtmonto.value==""){alert("Monto de Cuotas no puede estar Vacio");return false;}
   if(f.txtmonto_prestamo.value==""){alert("Monto de Prestamo no puede estar Vacio");return false;}
   if(f.txtfecha_ini.value==""){alert("Fecha de Inicio no puede estar Vacio");return false;}
   if(f.txtfecha_exp.value==""){alert("Fecha de Expiracion no puede estar Vacio");return false;}
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
$cantidad=0;$monto=0;$fecha_ini=$fecha_hoy; $dia=substr($fecha_ini,0,2);  $dia=$dia*1; if($dia<15){ $fecha_ini=colocar_pdiames($fecha_ini); } else{ $fecha_ini="16".substr($fecha_ini,2,8);}
$fecha_exp="31/12/9999"; $nro_cuotas=0;$monto_prestamo=0;$nro_cuotas_c=0;$acumulado=0;$saldo=0;$nombre="";
?>
<body>
<form name="form1" method="post" action="Update_prestamo.php" onSubmit="return revisar()">
  <table width="761" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="760" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR PRESTAMO</span></td>
        </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>

                   <td width="100"><span class="Estilo5">TRABAJADOR : </span></td>
                   <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                   <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trabajadores.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="500"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="70" maxlength="70" readonly value="<?echo $nombre?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="100"><span class="Estilo5">NRO. CUOTAS : </span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtnro_cuotas" type="text" id="txtnro_cuotas" style="text-align:right" size="6" maxlength="6" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?echo $nro_cuotas?>" onchange="chequea_monto(this.form);" onKeypress="return validarNum(event,this)"> </span></td>
                   <td width="110"><span class="Estilo5">MONTO CUOTA : </span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" style="text-align:right" size="14" maxlength="14" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto?>" onchange="chequea_monto(this.form);" onKeypress="return validarNum(event,this)"> </span></td>
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
                   <td width="350"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ini" type="text" id="txtfecha_ini"  size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_ini?>"> </span></td>
                   <td width="100"><span class="Estilo5">FECHA HASTA : </span></td>
                   <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_exp" type="text" id="txtfecha_exp"  size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_exp?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
        <tr> <td>&nbsp;</td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input name="txtcriterio" type="hidden" id="txtcriterio" value="<?echo $criterio?>"></td>
            <td width="20"><input name="txttipo_nomina" type="hidden" id="txttipo_nomina" value="<?echo $tipo_nomina?>"></td>
            <td width="20"><input name="txtcod_concepto" type="hidden" id="txtcod_concepto" value="<?echo $cod_concepto?>"></td>
			<td width="20"><input name="txtactivo" type="hidden" id="txtactivo" value="<?echo $activo?>"></td>
            <td width="60">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="120">&nbsp;</td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>