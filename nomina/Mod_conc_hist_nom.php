<?include ("../class/conect.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME");  $codigo_mov="";
if (!$_GET){$tipo_nomina="";$cod_concepto="";$cod_empleado="";$fecha_h="";$tp_calculo=="N";} else{$tipo_nomina=$_GET["tipo_nomina"];$cod_concepto=$_GET["cod_concepto"];$cod_empleado=$_GET["cod_empleado"];$fecha_h=$_GET["fecha_h"];$tp_calculo=$_GET["tp_calculo"];}
$fechab=formato_ddmmaaaa($fecha_h);
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

function encende_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }

function apaga_monto(mthis){var mmonto;
   apagar(mthis);    mmonto=mthis.value;  mmonto=camb_punto_coma(mmonto); mthis=mmonto;
return true;}
function llamar_anterior(){ document.location ='Det_conc_hist_nom.php?cod_empleado=<?echo $cod_empleado?>&tipo_nomina=<?echo $tipo_nomina?>&fecha_nomina=<?echo $fechab?>'; }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}
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
$sql="Select * from nom019 where tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and  cod_concepto='$cod_concepto' and (fecha_p_hasta='$fecha_h') and (tp_calculo='$tp_calculo') ".$criterioc.""; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["des_nomina"];  $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
  $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"]; 
  $denominacion=$registro["denominacion"]; $cantidad=formato_monto($cantidad); $monto=formato_monto($monto); }
?>
<body>
<form name="form1" method="post" action="Update_conc_hist_nom.php" onSubmit="return revisar()">
  <table width="761" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="660" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR MONTOS DE CONCEPTOS DEL HISTORICO </span></td>
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
             <td><table width="866">
                 <tr>
                   <td width="126"><span class="Estilo5">CONCEPTO : </span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="4" readonly value="<?echo $cod_concepto?>"> </span></td>
                   <td width="620"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="80" maxlength="80" readonly value="<?echo $denominacion?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
		   <tr> <td>&nbsp;</td> </tr>

           <tr>
             <td><table width="760">
                 <tr>
                   <td width="100"><span class="Estilo5">MONTO ACTUAL : </span></td>
                   <td width="260"><span class="Estilo5"><input class="Estilo10" name="txtmonto_a" type="text" id="txtmonto_a" style="text-align:right" size="14" maxlength="14" readonly value="<?echo $monto?>" onKeypress="return validarNum(event,this)" > </span></td>
                   <td width="100"><span class="Estilo5">MONTO NUEVO : </span></td>
				   
                   <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" style="text-align:right" size="14" maxlength="14" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto?>" onKeypress="return validarNum(event,this)"> </span></td>
                
				 </tr>
             </table></td>
           </tr>
        
        <tr> <td>&nbsp;</td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input class="Estilo10" name="txtfecha_p_hasta" type="hidden" id="txtfecha_p_hasta" value="<?echo $fecha_h?>"></td>
            <td width="20"><input class="Estilo10" name="txttp_calculo" type="hidden" id="txttp_calculo" value="<?echo $tp_calculo?>"></td>
            <td width="20"><input class="Estilo10" name="txttipo_nomina" type="hidden" id="txttipo_nomina" value="<?echo $tipo_nomina?>"></td>
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