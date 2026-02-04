<?include ("../class/conect.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy(); $fecha_exp="31/12/9999";
if ($gnomina=="00"){ $criterion="";$criterioc="";}else{ $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
if (!$_GET){$codigo="";} else{$codigo=$_GET["Gcodigo"];} $tipo_nomina=substr($codigo,0,2);$cod_concepto=substr($codigo,2,3);$cod_empleado=substr($codigo,5,15); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Asignaci&oacute;n de Conceptos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') || (monto.charAt(i) == ',') ) {str2 = str2 + monto.charAt(i);} } }
return str2;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function apaga_monto(mthis){var mmonto;  apagar(mthis);
 mmonto=mthis.value;  mmonto=daformatomonto(mmonto);   mthis.value=mmonto; } 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }
function chequea_tipo(mform){
var mref;
   mref=mform.txttipo_nomina.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina.value=mref;
return true;}
function chequea_concepto(mform){ var mref;
 mref=mform.txtcod_concepto.value; mref = Rellenarizq(mref,"0",3); mform.txtcod_concepto.value=mref;
return true;}
function apaga_concepto(mthis){
var mref;  var mtipo=document.form1.txttipo_nomina.value; var mcodemp=document.form1.txtcod_empleado.value;
   apagar(mthis);   mref=document.form1.txtcod_concepto.value;
return true;}
function chequea_orden(mform){ var mref;
 mref=mform.txtcod_orden.value; mref = Rellenarizq(mref,"0",3);  mform.txtcod_orden.value=mref;
}
function revisar(){
var f=document.form1;
    if(f.txttipo_nomina.value==""){alert("Tipo de N&oacute;mina no puede estar Vacio");return false;}else{f.txttipo_nomina.value=f.txttipo_nomina.value.toUpperCase();}
    if(f.txtcod_empleado.value==""){alert("C&oacute;digo de Empleado no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Denominaci&oacute;n no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtcod_concepto.value==""){alert("C&oacute;digo de concepto no puede estar Vacia"); return false; } else{f.txtcod_concepto.value=f.txtcod_concepto.value.toUpperCase();}
    if(f.txtfecha_ini.value==""){alert("Fecha de Inicio no puede estar Vacio");return false;}
    if(f.txtfecha_exp.value==""){alert("Fecha de Expiraci&oacute;n no puede estar Vacio");return false;}
    document.form1.submit;
return true;}
</script>

</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from CONCEPTOS_ASIGNADOS where tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and cod_concepto='$cod_concepto' ".$criterioc.""; $res=pg_query($sql);$filas=pg_num_rows($res);
$tipo_nomina="";$cod_empleado="";$cod_concepto="";$cantidad=0;$monto=0;$fecha_ini="";$fecha_exp="";$activo="";$calculable="";$acumulado=0;$saldo=0;$cod_presup="";$frecuencia="";$afecta_presup="";$cod_retencion="";$cod_presup_ant="";$prestamo="";$monto_prestamo="";$nro_cuotas="";$nro_cuotas_c="";$status="";$inf_usuario="";
$denominacion="";$descripcion="";$nombre="";$frec="0";$imp_fija="SI";
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];  $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
  $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"]; $fecha_ini=$registro["fecha_ini"]; $fecha_exp=$registro["fecha_exp"];
  $activo=$registro["activoa"]; $calculable=$registro["calculable"]; $acumulado=$registro["acumulado"]; $saldo=$registro["saldo"]; $frec=$registro["frecuenciaa"]; $cod_presup=$registro["cod_presup"];
  $afecta_presup=$registro["afecta_presup"]; $cod_retencion=$registro["cod_retencion"]; $cod_presup_ant=$registro["cod_presup_ant"]; $prestamo=$registro["prestamo"];
  $monto_prestamo=$registro["monto_prestamo"]; $nro_cuotas=$registro["nro_cuotas"]; $nro_cuotas_c=$registro["nro_cuotas_c"]; $status=$registro["statusa"]; $inf_usuario=$registro["inf_usuario"];
  $fecha_ini=formato_ddmmaaaa($fecha_ini); $fecha_exp=formato_ddmmaaaa($fecha_exp); $cantidad=formato_monto($cantidad); $monto=formato_monto($monto);  $acumulado=formato_monto($acumulado);  $saldo=formato_monto($saldo);
}  if(substr($prestamo,0,1)=="S"){$prestamo="SI";}else{$prestamo="NO";} if(substr($status,0,1)=="S"){$imp_fija="SI";}else{$imp_fija="NO";}
if($frec=="1"){$frecuencia="PRIMERA QUINCENA";} if($frec=="2"){$frecuencia="SEGUNDA QUINCENA";} if($frec=="3"){$frecuencia="PRIMERA Y SEGUNDA QUINCENA";}
if($frec=="4"){$frecuencia="PRIMERA SEMANA";} if($frec=="5"){$frecuencia="SEGUNDA SEMANA";} if($frec=="6"){$frecuencia="TERCERA SEMANA";}
if($frec=="7"){$frecuencia="CUARTA SEMANA";} if($frec=="8"){$frecuencia="QUINTA SEMANA";} if($frec=="9"){$frecuencia="TODAS LAS SEMANAS";} if($frec=="0"){$frecuencia="ULTIMA SEMANA";}
pg_close();
?>
<body>
<table width="991" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="76"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="872"><div align="center" class="Estilo2 Estilo6">MODIFICAR ASIGNACI&Oacute;N DE CONCEPTOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="992" height="381" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="375"><table width="92" height="384" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_asig_concep_ar.php?Gcodigo=C<?echo $codigo?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_asig_concep_ar.php?Gcodigo=C<?echo $codigo?>">Atras</a></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
     </tr>
      <tr><td>&nbsp;</td> </tr>
    </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post" action="Update_asig_concepto.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="130"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="4" maxlength="4" readonly value="<?echo $tipo_nomina?>"> </span></td>
                   <td width="645"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="100" maxlength="100" readonly value="<?echo $descripcion?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR  : </span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" readonly value="<?echo $cod_empleado?>"> </span></td>
                   <td width="560"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="80" maxlength="80" readonly value="<?echo $nombre?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO DE CONCEPTO : </span></td>
                   <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="4" readonly value="<?echo $cod_concepto?>"> </span></td>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                   <td width="520"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="80" maxlength="80" readonly value="<?echo $denominacion?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_activo(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtactivo.options[0].selected=true;}else{document.form1.txtactivo.options[1].selected=true;}}
function asig_calculable(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtcalculable.options[0].selected=true;}else{document.form1.txtcalculable.options[1].selected=true;}}
function asig_frecuencia(mvalor){var f=document.form1;
    if(mvalor=="PRIMERA QUINCENA"){document.form1.txtfrecuencia.options[0].selected = true;}
    if(mvalor=="SEGUNDA QUINCENA"){document.form1.txtfrecuencia.options[1].selected = true;}
    if(mvalor=="PRIMERA Y SEGUNDA QUINCENA"){document.form1.txtfrecuencia.options[2].selected = true;}
    if(mvalor=="PRIMERA SEMANA"){document.form1.txtfrecuencia.options[3].selected = true;}
    if(mvalor=="SEGUNDA SEMANA"){document.form1.txtfrecuencia.options[4].selected = true;}
    if(mvalor=="TERCERA SEMANA"){document.form1.txtfrecuencia.options[5].selected = true;}
    if(mvalor=="CUARTA SEMANA"){document.form1.txtfrecuencia.options[6].selected = true;}
    if(mvalor=="QUINTA SEMANA"){document.form1.txtfrecuencia.options[7].selected = true;}
    if(mvalor=="TODAS LAS SEMANAS"){document.form1.txtfrecuencia.options[8].selected = true;}
    if(mvalor=="ULTIMA SEMANA"){document.form1.txtfrecuencia.options[9].selected = true;}
}</script>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="100"><span class="Estilo5">FECHA INICIO : </span></td>
                   <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ini" type="text" id="txtfecha_ini" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_ini?>"> </span></td>
                   <td width="130"><span class="Estilo5">FECHA EXPIRACI&Oacute;N : </span></td>
                   <td width="136"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_exp" type="text" id="txtfecha_exp" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_exp?>"> </span></td>
                   <td width="75"><span class="Estilo5">ACTIVO : </span></td>
                   <td width="95"><span class="Estilo5"><select class="Estilo10" name="txtactivo" size="1" id="txtactivo" onFocus="encender(this)" onBlur="apagar(this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="95"><span class="Estilo5">CALCULABLE : </span></td>
                   <td width="95"><span class="Estilo5"><select class="Estilo10" name="txtcalculable" size="1" id="txtcalculable" onFocus="encender(this)" onBlur="apagar(this)"><option>SI</option> <option>NO</option></select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_activo('<?echo $activo;?>'); asig_calculable('<?echo $calculable;?>'); </script>
                  </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="80"><span class="Estilo5">CANTIDAD : </span></td>
                   <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtcantidad" type="text" id="txtcantidad" style="text-align:right" size="14" maxlength="14" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $cantidad?>" onKeypress="return validarNum(event)"> </span></td>
                   <td width="70"><span class="Estilo5">MONTO : </span></td>
                   <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtmonto" type="text" id="txtmonto" style="text-align:right" size="14" maxlength="14" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto?>" onKeypress="return validarNum(event)"> </span></td>
                   <td width="95"><span class="Estilo5">ACUMULADO : </span></td>
                   <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtacumulado" type="text" id="txtacumulado" style="text-align:right" size="14" maxlength="14" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $acumulado?>" onKeypress="return validarNum(event)"></span></td>
                   <td width="65"><span class="Estilo5">SALDO : </span></td>
                   <td width="130"><span class="Estilo5"><input class="Estilo10" name="txtsaldo" type="text" id="txtsaldo" style="text-align:right" size="14" maxlength="14" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $saldo?>" onKeypress="return validarNum(event)"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
            <td><table width="866">
                 <tr>
                   <td width="90"><span class="Estilo5">FRECUENCIA : </span></td>
                   <td width="310"><span class="Estilo5"><div id="dfrec"><select class="Estilo10" name="txtfrecuencia" size="1" id="txtfrecuencia" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>PRIMERA QUINCENA</option> <option>SEGUNDA QUINCENA</option> <option>PRIMERA Y SEGUNDA QUINCENA</option>
                      <option>PRIMERA SEMANA</option> <option>SEGUNDA SEMANA</option> <option>TERCERA SEMANA</option> <option>CUARTA SEMANA</option>
                      <option>QUINTA SEMANA</option> <option>TODAS LAS SEMANAS</option> <option>ULTIMA SEMANA</option> </select> </div> </span></td>
                   <td width="190"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO : </span></td>
                   <td width="230"><span class="Estilo5"><div id="cpresup"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" size="35" maxlength="32"onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_presup?>"> </div></span></td>
                   <td width="46"><input class="Estilo10" name="btcodpre" type="button" id="btcodpre" title="Abrir Catalogo C&oacute;digos Presupuestario"  onClick="VentanaCentrada('Cat_cod_pre.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 </tr>
<script language="JavaScript" type="text/JavaScript"> asig_frecuencia('<?echo $frecuencia;?>'); </script>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_afecta_pre(mvalor){var f=document.form1;  if(mvalor=="SI"){document.form1.txtafecta_presup.options[0].selected = true;}else{document.form1.txtafecta_presup.options[1].selected = true;}}
function asig_imp_fija(mvalor){var f=document.form1;  if(mvalor=="NO"){document.form1.txtimp_fija.options[0].selected = true;}else{document.form1.txtimp_fija.options[1].selected = true;}}
</script>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="150" ><span class="Estilo5">AFECTA PRESUPUESTO : </span></td>
                   <td width="100"><span class="Estilo5"><select class="Estilo10" name="txtafecta_presup" size="1" id="txtafecta_presup" onFocus="encender(this)" onBlur="apagar(this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="220" ><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA FIJA : </span></td>
                   <td width="100"><span class="Estilo5"><select class="Estilo10" name="txtimp_fija" size="1" id="txtimp_fija" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select>  </span></td>
                   <td width="190" ><span class="Estilo5">C&Oacute;DIGO TIPO DE RETENCI&Oacute;N : </span></td>
                   <td width="60" ><span class="Estilo5"><div id="cret"><input class="Estilo10" name="txtcod_retencion" type="text" id="txtcod_retencion" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_retencion?>"></div> </span></td>
                   <td width="46"><input class="Estilo10" name="bttiporet" type="button" id="bttiporet" title="Abrir Catalogo Tipos de Retencion"  onClick="VentanaCentrada('Cat_tipo_ret.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                  </tr>
<script language="JavaScript" type="text/JavaScript"> asig_afecta_pre('<?echo $afecta_presup;?>');  asig_imp_fija('<?echo $imp_fija;?>'); </script>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
                  <td width="64"><input class="Estilo10" name="txtdescripcion_ret" type="hidden" id="txtdescripcion_ret" value=""></td>
                  <td width="600">&nbsp;</td>
                  <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                  <td width="88">&nbsp;</td>
                </tr>
          </table>
       </div>
     </form>
    </td>
  </tr>
</table>
</body>
</html>