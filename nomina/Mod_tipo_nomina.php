<?include ("../class/seguridad.inc"); include("../class/conects.php");  include ("../class/funciones.php");
if ($gnomina=="00"){ $criterion=""; $criterioc="";}else{ $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
if (!$_GET){$tipo_nomina='';} else {$tipo_nomina=$_GET["Gtipo_nomina"];} $sql="Select * from NOM001 where tipo_nomina='$tipo_nomina' ".$criterioc."";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Tipos de Nomina)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
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
var patronfecha = new Array(2,2,4);
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_nomina.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina.value=mref;
return true;}
function chequea_ult_fecha(mform){ var mfecha; var mref=mform.txtultima_fecha.value; var mfec; var yearn; var miFecha; var dif;
 mfecha=mref;
 if(mfecha.length==8){mfec=mfecha.substring(0,6)+"20"+mfecha.charAt(6)+mfecha.charAt(7);  mform.txtultima_fecha.value=mfec; mfecha=mref;}
return true;}
function chequea_conc(mthis){ var mref;
 mref=mthis.value; mref = Rellenarizq(mref,"0",3); mthis.value=mref;
}
function chequea_cod_est(mthis){ var mref;
 mref=mthis.value; mref = Rellenarizq(mref,"0",8); mthis.value=mref;
}
function revisar(){
var f=document.form1;
    if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacio");return false;}else{f.txttipo_nomina.value=f.txttipo_nomina.value.toUpperCase();}
    if(f.txtdescripcion.value==""){alert("Descripcion Tipo de Nomina no puede estar Vacia"); return false; } else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
    if(f.texdesc_grupo.value==""){alert("Descripcion Grupo de Nomina no puede estar Vacia"); return false; } else{f.texdesc_grupo.value=f.texdesc_grupo.value.toUpperCase();}
document.form1.submit;
return true;}
function tabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;
  if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus();
return false;} 
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$res=pg_query($sql);$filas=pg_num_rows($res);
$descripcion="";$cod_grupo="";$desc_grupo="";$frec="Q"; $nro_semana=0;$frecuencia=""; $ultima_fecha="";$proxima_fecha=""; $redondear="";$inf_usuario=""; $cod_relac_vac="";
$con_sue_bas=""; $con_compen=""; $con_cal_vac=""; $con_bon_vac=""; $con_sue_int=""; $con_sue_int=""; $con_sue_tot="";  $con_tot_prima=""; $con_tot_compen=""; $status_tipo="";
$con_cal_liqui=""; $con_liqui2=""; $con_liqui3=""; $g_orden_pago=""; $g_orden_pago_e=""; $cod_relac_apo=""; $cod_relac_nom=""; $cod_relac_ext="";  $cal_int_fidecomiso=""; $cod_tipo_liq="";
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $tipo_nomina=$registro["tipo_nomina"];  $descripcion=$registro["descripcion"]; $cod_grupo=$registro["cod_grupo"];$desc_grupo=$registro["desc_grupo"];
  $frec=$registro["frecuencia"];  $nro_semana=$registro["nro_semana"]; $redondear=$registro["redondear"]; $status_tipo=$registro["status_tipo"];
  $ultima_fecha=$registro["ultima_fecha"]; $proxima_fecha=$registro["proxima_fecha"];  $fecha_h_p_n=$registro["fecha_h_p_n"]; $fecha_h_p_e=$registro["fecha_h_p_e"];
  $con_sue_bas=$registro["con_sue_bas"]; $con_compen=$registro["con_compen"]; $con_cal_vac=$registro["con_cal_vac"]; $con_bon_vac=$registro["con_bon_vac"]; $con_sue_int=$registro["con_sue_int"];
  $con_sue_int=$registro["con_sue_int"]; $con_sue_tot=$registro["con_sue_tot"];  $con_tot_prima=$registro["con_tot_prima"]; $con_tot_compen=$registro["con_tot_compen"];
  $con_cal_liqui=$registro["con_cal_liqui"]; $con_liqui2=$registro["con_liqui2"]; $con_liqui3=$registro["con_liqui3"]; $g_orden_pago=$registro["g_orden_pago"]; $g_orden_pago_e=$registro["g_orden_pago_e"];
  $cod_relac_nom=$registro["cod_relac_nom"]; $cod_relac_ext=$registro["cod_relac_ext"]; $cod_relac_apo=$registro["cod_relac_apo"];  $cod_relac_vac=$registro["cod_relac_vac"]; $cod_tipo_liq=$registro["cod_tipo_liq"];
  $inf_usuario=$registro["inf_usuario"]; $ultima_fecha=formato_ddmmaaaa($ultima_fecha);
}else{ $tipo_nomina="";}  if($frec=="Q"){$frecuencia="QUINCENAL";} if($frec=="S"){$frecuencia="SEMANAL";} if($frec=="M"){$frecuencia="MENSUAL";}
if(substr($status_tipo,0,1)=="S"){$cal_int_fidecomiso="SI";}else{$cal_int_fidecomiso="NO";} if($g_orden_pago=="S"){$g_orden_pago="SI";}else{$g_orden_pago="NO";}
if(substr($status_tipo,1,1)=="S"){$dep_prest_mes="SI";}else{$dep_prest_mes="NO";}
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR TIPOS DE NOMINA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="496" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="492"><table width="92" height="492" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_tip_nomi_ar.php?Gtipo_nomina=C<?echo $tipo_nomina?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_tip_nomi_ar.php?Gtipo_nomina=C<?echo $tipo_nomina?>">Atras</a></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr>
   </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 65px; left: 110px;">
        <form name="form1" method="post" action="Update_tipo_nomina.php" onSubmit="return revisar()">
            <table width="868" border="0" align="center" >
              <tr>
                <td><table width="866" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                     <td width="120"><span class="Estilo5">TIPO DE NOMINA :</span></td>
                     <td width="746"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="4" maxlength="2" value="<?echo $tipo_nomina?>" readonly onkeypress="return tabular(event,this)">  </span></td>
                   </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="866" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="110"><span class="Estilo5">DESCRIPCI&Oacute;N  :</span></td>
                    <td width="756"><span class="Estilo5"><textarea name="txtdescripcion" cols="90" maxlength="200" id="txtdescripcion" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><?echo $descripcion?></textarea> </span></td>
                  </tr>
                </table></td>
              </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_frecuencia(mvalor){var f=document.form1;
    if(mvalor=="QUINCENAL"){document.form1.txtfrecuencia.options[0].selected = true;}
    if(mvalor=="SEMANAL"){document.form1.txtfrecuencia.options[1].selected = true;}
    if(mvalor=="MENSUAL"){document.form1.txtfrecuencia.options[2].selected = true;}
}</script>
              <tr>
                <td><table width="866">
                  <tr>
                    <td width="80"><span class="Estilo5">FRECUENCIA : </span></td>
                     <td width="110"><span class="Estilo5"><select name="txtfrecuencia" size="1" id="txtfrecuencia" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)">
                      <option>QUINCENAL</option> <option>SEMANAL</option> <option>MENSUAL</option> </select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_frecuencia('<?echo $frecuencia;?>');</script>
                    <td width="170"><span class="Estilo5">ULTIMA FECHA PROCESO : </span></td>
                    <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtultima_fecha" type="text" id="txtultima_fecha"  size="12" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $ultima_fecha?>" onchange="chequea_ult_fecha(this.form)" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return tabular(event,this)"> </span></td>
                    <td width="160"><span class="Estilo5">Nro. SEMANA/QUINCENA : </span></td>
                    <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtnro_semana" type="text" id="txtnro_semana"  size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nro_semana?>" onkeypress="return tabular(event,this)"> </span></td>
                    <td width="80"><span class="Estilo5">REDONDEAR :</span></td>
<script language="JavaScript" type="text/JavaScript"> function asig_redondear(mvalor){var f=document.form1;  if(mvalor=="SI"){document.form1.txtredondear.options[0].selected = true;}else{document.form1.txtredondear.options[1].selected = true;}} </script>
                    <td width="65"><span class="Estilo5"><select name="txtredondear" size="1" id="txtredondear" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_redondear('<?echo $redondear;?>');</script>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="866">
                  <tr>
                    <td width="136"><span class="Estilo5">DESCRIPCI&Oacute;N GRUPO:</span></td>
                    <td width="730"><span class="Estilo5"> <textarea name="texdesc_grupo" cols="85" maxlength="200"  id="texdesc_grupo" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><?echo $desc_grupo?></textarea> </div></td>
                  </tr>
                </table></td>
              </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="180"><span class="Estilo5">CONCEPTO SUELDO  B&Aacute;SICO : </span></td>
                 <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtcon_sue_bas" type="text"  id="txtcon_sue_bas"  size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $con_sue_bas?>" readonly onkeypress="return tabular(event,this)">  </span></td>
                 <td width="180"><span class="Estilo5">CONCEPTO COMPENSACI&Oacute;N  : </span></td>
                 <td width="80"><span class="Estilo5"> <input class="Estilo10" name="txtcon_compen" type="text"  id="txtcon_compen"  size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_conc(this);" value="<?echo $con_compen?>" onkeypress="return tabular(event,this)">   </span></td>
                 <td width="230"><span class="Estilo5">CONCEPTO TOTAL COMPENSACIONES  : </span></td>
                 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcon_tot_compen" type="text"  id="txtcon_tot_compen"  size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_conc(this);" value="<?echo $con_tot_compen?>" onkeypress="return tabular(event,this)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="180"><span class="Estilo5">CONCEPTO TOTAL PRIMAS : </span></td>
                 <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtcon_tot_prima" type="text" id="txtcon_tot_prima"  size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_conc(this);" value="<?echo $con_tot_prima?>" onkeypress="return tabular(event,this)">  </span></td>
                 <td width="180"><span class="Estilo5">CONCEPTO SUELDO INTEGRAL : </span></td>
                 <td width="80"><span class="Estilo5"> <input class="Estilo10" name="txtcon_sue_int" type="text" id="txtcon_sue_int" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_conc(this);" value="<?echo $con_sue_int?>" onkeypress="return tabular(event,this)">  </span></td>
                 <td width="230"><span class="Estilo5">CONCEPTO SUELDO TOTAL : </span></td>
                 <td width="60"><span class="Estilo5"> <input class="Estilo10" name="txtcon_sue_tot" type="text" id="txtcon_sue_tot" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_conc(this);" value="<?echo $con_sue_tot?>" onkeypress="return tabular(event,this)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="185"><span class="Estilo5">CONCEPTO BONO VACACIONAL : </span></td>
                 <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtcon_bon_vac" type="text" id="txtcon_bon_vac"  size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_conc(this);" value="<?echo $con_bon_vac?>" onkeypress="return tabular(event,this)">  </span></td>
                 <td width="215"><span class="Estilo5">CONCEPTO BONO VAC. POR PAGAR : </span></td>
                 <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtcon_liqui2" type="text"  id="txtcon_liqui2"  size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_conc(this);" value="<?echo $con_liqui2?>" onkeypress="return tabular(event,this)">  </span></td>
                 <td width="220"><span class="Estilo5">CONCEPTO C&Aacute;LCULO VACACIONES : </span></td>
                 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcon_cal_vac" type="text"  id="txtcon_cal_vac"  size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_conc(this);" value="<?echo $con_cal_vac?>" onkeypress="return tabular(event,this)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="240"><span class="Estilo5">CONCEPTO C&Aacute;LCULO  LIQUIDACI&Oacute;N : </span></td>
                 <td width="306"><span class="Estilo5"><input class="Estilo10" name="txtcon_cal_liqui" type="text" id="txtcon_cal_liqui"  size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_conc(this);" value="<?echo $con_cal_liqui?>" onkeypress="return tabular(event,this)">  </span></td>
                 <td width="260"><span class="Estilo5">CONCEPTO C&Aacute;LCULO D&Iacute;AS ADICIONALES  : </span></td>
                 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcon_liqui3" type="text" id="txtcon_liqui3"  size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_conc(this);" value="<?echo $con_liqui3?>" onkeypress="return tabular(event,this)">  </span></td>
               </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript"> 
function asig_cal_int(mvalor){var f=document.form1;  if(mvalor=="SI"){document.form1.txtcal_int_fidecomiso.options[0].selected = true;}else{document.form1.txtcal_int_fidecomiso.options[1].selected = true;}} 
function asig_dep_prest_mes(mvalor){var f=document.form1;  if(mvalor=="SI"){document.form1.txtdep_prest_mes.options[1].selected = true;}else{document.form1.txtdep_prest_mes.options[0].selected = true;}} 
</script>

           <tr>
             <td><table width="866">
               <tr>
                 <td width="240"><span class="Estilo5">CALCULA INTERESES DE FIDECOMISO  : </span></div></td>
                 <td width="306"><span class="Estilo5"><select name="txtcal_int_fidecomiso" size="1" id="txtcal_int_fidecomiso" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)">  <option>SI</option> <option>NO</option></select>  </span></td>
                  <td width="260"><span class="Estilo5">DEPOSITAR PRESTACIONES MENSUAL   : </span></td>
                 <td width="60"><select name="txtdep_prest_mes" size="1" id="txtdep_prest_mes" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"> <option>NO</option> <option>SI</option></select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_cal_int('<?echo $cal_int_fidecomiso;?>'); asig_dep_prest_mes('<?echo $dep_prest_mes;?>'); </script>
               </tr>
             </table></td>
           </tr>
		   
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="240"><span class="Estilo5">GENERA INFORMACI&Oacute;N ORDEN DE PAGO  : </span></td>
<script language="JavaScript" type="text/JavaScript"> function asig_g_orden(mvalor){var f=document.form1;  if(mvalor=="SI"){document.form1.txtg_orden_pago.options[0].selected = true;}else{document.form1.txtg_orden_pago.options[1].selected = true;}} </script>
                 <td width="306"><select name="txtg_orden_pago" size="1" id="txtg_orden_pago" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"> <option>SI</option> <option>NO</option></select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_g_orden('<?echo $g_orden_pago;?>');</script>
                 <td width="260"><span class="Estilo5">C&Oacute;DIGO DE FUENTE : </span></td>
                 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_grupo" type="text" id="txtcod_grupo"  size="3" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $cod_grupo?>" onkeypress="return tabular(event,this)">  </span></td>
                 
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="230"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA O/P N&Oacute;MINA : </span></td>
                 <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtcod_relac_nom" type="text" id="txtcod_relac_nom"  size="10" maxlength="8" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_cod_est(this);" value="<?echo $cod_relac_nom?>" onkeypress="return tabular(event,this)"> </span></td>
                 <td width="336"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA O/P N&Oacute;MINA EXTRAORDINARIA : </span></td>
                 <td width="100"><input class="Estilo10" name="txtcod_relac_ext" type="text" id="txtcod_relac_ext"  size="10" maxlength="8" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_cod_est(this);" value="<?echo $cod_relac_ext?>" onkeypress="return tabular(event,this)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="230"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA O/P N&Oacute;MINA 2 : </span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtcod_relac_apo" type="text" id="txtcod_relac_apo"  size="10" maxlength="8" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_cod_est(this);" value="<?echo $cod_relac_apo?>" onkeypress="return tabular(event,this)">  </span></td>
                 <td width="336"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA O/P N&Oacute;MINA VACACIONES : </span></td>
                 <td width="100"><input class="Estilo10" name="txtcod_relac_vac" type="text" id="txtcod_relac_vac"  size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_cod_est(this);" value="<?echo $cod_relac_vac?>" onkeypress="return tabular(event,this)">  </span></td>
              </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="316"><span class="Estilo5">DIAS AL MES/TRIMESTRES CALCULO PRESTACIONES : </span></td>
                 <td width="550"><span class="Estilo5"><input class="Estilo10" name="txtcod_tipo_liq" type="text" id="txtcod_tipo_liq"  size="6" maxlength="5" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $cod_tipo_liq?>" onkeypress="return tabular(event,this)"> </span></td>
               </tr>
             </table></td>
           </tr>		  
		  
		   
         </table>
         <table width="859">
                <tr>
                  <td width="664">&nbsp;</td>
                  <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                  <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
                </tr>
          </table>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>