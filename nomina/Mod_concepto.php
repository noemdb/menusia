<?include ("../class/conect.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME");
if ($gnomina=="00"){ $criterion=""; $criterioc="";}else{ $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
if (!$_GET){$codigo="";} else{$codigo=$_GET["Gcodigo"];} $tipo_nomina=substr($codigo,0,2);$cod_concepto=substr($codigo,2,3);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Conceptos de Nomina)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
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
function chequea_tipo(mform){
var mref;
   mref=mform.txttipo_nomina.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina.value=mref;
return true;}
function chequea_concepto(mform){ var mref;
 mref=mform.txtcod_concepto.value; mref = Rellenarizq(mref,"0",3); mform.txtcod_concepto.value=mref;  mform.txtcod_orden.value=mref;
}
function chequea_orden(mform){ var mref;
 mref=mform.txtcod_orden.value; mref = Rellenarizq(mref,"0",3);  mform.txtcod_orden.value=mref;
}
function chequea_aporte(mform){ var mref;
 mref=mform.txtcod_aporte.value; mref = Rellenarizq(mref,"0",3);  mform.txtcod_aporte.value=mref;
}
function revisar(){var f=document.form1;
    if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacio");return false;}else{f.txttipo_nomina.value=f.txttipo_nomina.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Denominacion no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtcod_concepto.value==""){alert("COdigo de concepto no puede estar Vacia"); return false; } else{f.txtcod_concepto.value=f.txtcod_concepto.value.toUpperCase();}
document.form1.submit;
return true;}
function tabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;
  if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus();
return false;} 
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from conceptos where tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' ".$criterioc." "; $res=pg_query($sql);$filas=pg_num_rows($res);
$denominacion="";$cod_partida="";$cod_cat_alter=""; $cod_contable="";$asignacion="";$tipo_asigna="";$asig_ded_apo="";$activo=""; $frec="3"; $descripcion=""; $tipo_concepto=""; $tipo_a=""; $cal_vac=""; $fuente="00";
$inicializable="";$inicializable_c="";$oculto="";$acumula="";$tipo_grupo="";$frecuencia="";$afecta_presup="";$cod_retencion="";$grupo_retencion="";$prestamo="";$status="";$cod_orden=""; $cod_aporte=""; $inf_usuario="";
if ($registro=pg_fetch_array($res,0)){
  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];  $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
  $cod_partida=$registro["cod_partida"]; $cod_cat_alter=$registro["cod_cat_alter"]; $asignacion=$registro["asignacion"]; $tipo_a=$registro["tipo_asigna"]; $frec=$registro["frecuencia"];
  $asig_ded_apo=$registro["asig_ded_apo"]; $activo=$registro["activo"]; $inicializable=$registro["inicializable"]; $inicializable_c=$registro["inicializable_c"]; $cod_aporte=$registro["cod_aporte"];
  $oculto=$registro["oculto"]; $acumula=$registro["acumula"]; $tipo_grupo=$registro["tipo_grupo"]; $afecta_presup=$registro["afecta_presup"]; $cod_retencion=$registro["cod_retencion"]; $fuente=$registro["cod_contable"];
  $grupo_retencion=$registro["grupo_retencion"]; $prestamo=$registro["prestamo"]; $status=$registro["status"]; $cod_orden=$registro["cod_orden"]; $inf_usuario=$registro["inf_usuario"];
} if($asignacion=="SI"){$tipo_concepto="ASIGNACION";}else{if($asig_ded_apo=="D"){$tipo_concepto="DEDUCCION";}else{$tipo_concepto="APORTE";}}
$tipo_asigna="OTRO"; if($tipo_a=="S"){$tipo_asigna="SUELDO";} if($tipo_a=="C"){$tipo_asigna="COMPENSACION";} if($tipo_a=="P"){$tipo_asigna="PRIMA";} if($tipo_a=="T"){$tipo_asigna="CESTATICKET";}
if(substr($status,0,1)=="S"){$cal_vac="SI";}else{$cal_vac="NO";}  if(substr($prestamo,0,1)=="S"){$prestamo="SI";}else{$prestamo="NO";}
if($frec=="1"){$frecuencia="PRIMERA QUINCENA";} if($frec=="2"){$frecuencia="SEGUNDA QUINCENA";} if($frec=="3"){$frecuencia="PRIMERA Y SEGUNDA QUINCENA";}
if($frec=="4"){$frecuencia="PRIMERA SEMANA";} if($frec=="5"){$frecuencia="SEGUNDA SEMANA";} if($frec=="6"){$frecuencia="TERCERA SEMANA";}
if($frec=="7"){$frecuencia="CUARTA SEMANA";} if($frec=="8"){$frecuencia="QUINTA SEMANA";} if($frec=="9"){$frecuencia="TODAS LAS SEMANAS";} if($frec=="0"){$frecuencia="ULTIMA SEMANA";}
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR CONCEPTOS DE NOMINA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_concep_ar.php?Gcodigo=C<?echo $codigo?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_concep_ar.php?Gcodigo=C<?echo $codigo?>">Atras</a></td>
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
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post" action="Update_concepto.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="130"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="90"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="4" maxlength="4" readonly value="<?echo $tipo_nomina?>"  onkeypress="return tabular(event,this)"> </span></td>
                   <td width="665"><span class="Estilo5"><input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="80" maxlength="80" readonly value="<?echo $descripcion?>" onkeypress="return tabular(event,this)"> </span></td>
                  </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO DE CONCEPTO : </span></td>
                   <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="4" readonly value="<?echo $cod_concepto?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                   <td width="520"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="65" maxlength="80" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $denominacion?>" onkeypress="return tabular(event,this)"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="150"><span class="Estilo5">C&Oacute;DIGO DE PARTIDA : </span></td>
                   <td width="145"><span class="Estilo5"><input class="Estilo10" name="txtcod_partida" type="text" id="txtcod_partida" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_partida?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="40"><input class="Estilo10" name="btcodpart" type="button" id="btcodpart" title="Abrir Catalogo Partidas"  onClick="VentanaCentrada('Cat_codigos_par.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return tabular(event,this)"> </span></td>
                   <td width="121"><span class="Estilo5">FUENTE : <span class="Estilo5"><input class="Estilo10" name="txtfuente" type="text" id="txtfuente" size="2" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fuente?>"  onkeypress="return tabular(event,this)">  </span></td>
				   
				   <td width="210"><span class="Estilo5">CODIGO DE CATEGORIA ALTERNA : </span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_cat_alter" type="text" id="txtcod_cat_alter" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cat_alter?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="50"><input class="Estilo10" name="btcodcat" type="button" id="btcodcat" title="Abrir Catalogo Categorias"  onClick="VentanaCentrada('Cat_codigos_cat.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return tabular(event,this)"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
<script language="JavaScript" type="text/JavaScript">
function asig_tipo_conc(mvalor){var f=document.form1;
    if(mvalor=="ASIGNACION"){document.form1.txttipo_concepto.options[0].selected = true;}
    if(mvalor=="DEDUCCION"){document.form1.txttipo_concepto.options[1].selected = true;}
    if(mvalor=="APORTE"){document.form1.txttipo_concepto.options[2].selected = true;}
}
function asig_tipo_asigna(mvalor){var f=document.form1;
    if(mvalor=="SUELDO"){document.form1.txttipo_asigna.options[0].selected = true;}
    if(mvalor=="COMPENSACION"){document.form1.txttipo_asigna.options[1].selected = true;}
    if(mvalor=="PRIMA"){document.form1.txttipo_asigna.options[2].selected = true;}
    if(mvalor=="OTRO"){document.form1.txttipo_asigna.options[3].selected = true;}
	if(mvalor=="CESTATICKET"){document.form1.txttipo_asigna.options[4].selected = true;}
}
</script>
                   <td width="150"><span class="Estilo5">TIPO DE CONCEPTO : </span></td>
                   <td width="366"><span class="Estilo5"><select class="Estilo10" name="txttipo_concepto" size="1" id="txttipo_concepto" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)">
                      <option>ASIGNACION</option> <option>DEDUCCION</option> <option>APORTE</option> </select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_tipo_conc('<?echo $tipo_concepto;?>');</script>
                   <td width="150"><span class="Estilo5">TIPO DE ASIGNACI&Oacute;N : </span></td>
                   <td width="200"><span class="Estilo5"><select class="Estilo10" name="txttipo_asigna" size="1" id="txttipo_asigna" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)">
                      <option>SUELDO</option> <option>COMPENSACION</option> <option>PRIMA</option> <option>OTRO</option> <option>CESTATICKET</option> </select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_tipo_asigna('<?echo $tipo_asigna;?>');</script>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="216" ><span class="Estilo5">CONCEPTO AFECTA PRESUPUESTO : </span></td>
<script language="JavaScript" type="text/JavaScript"> function asig_afecta_pre(mvalor){var f=document.form1;  if(mvalor=="SI"){document.form1.txtafecta_presup.options[0].selected = true;}else{document.form1.txtafecta_presup.options[1].selected = true;}} </script>
                   <td width="110"><span class="Estilo5"><select class="Estilo10" name="txtafecta_presup" size="1" id="txtafecta_presup" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_afecta_pre('<?echo $afecta_presup;?>');</script>
                   <td width="180" ><span class="Estilo5">C&Oacute;DIGO TIPO DE RETENCI&Oacute;N : </span></td>
                   <td width="60" ><span class="Estilo5"><input class="Estilo10" name="txtcod_retencion" type="text" id="txtcod_retencion" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_retencion?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="60"><input class="Estilo10" name="bttiporet" type="button" id="bttiporet" title="Abrir Catalogo Tipos de Retencion"  onClick="VentanaCentrada('Cat_tipo_ret.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return tabular(event,this)"> </span></td>
                   <td width="150"><span class="Estilo5">C&Oacute;DIGO DE APORTE : </span></td>
                   <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtcod_aporte" type="text" id="txtcod_aporte" size="4" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_aporte(this.form);"   value="<?echo $cod_aporte?>" onkeypress="return tabular(event,this)"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="75"><span class="Estilo5">ACTIVO : </span></td>
<script language="JavaScript" type="text/JavaScript">
function asig_activo(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtactivo.options[0].selected=true;}else{document.form1.txtactivo.options[1].selected=true;}}
function asig_oculto(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtoculto.options[1].selected=true;}else{document.form1.txtoculto.options[0].selected=true;}}
function asig_monto_ini(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtinicializable.options[1].selected=true;}else{document.form1.txtinicializable.options[0].selected=true;}}
function asig_cantidad_ini(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtinicializable_c.options[1].selected=true;}else{document.form1.txtinicializable_c.options[0].selected=true;}}
function asig_acumula(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtacumula.options[0].selected=true;}else{document.form1.txtacumula.options[1].selected=true;}}
function asig_cal_vac(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtcal_vac.options[0].selected=true;}else{document.form1.txtcal_vac.options[1].selected=true;}}
function asig_prestamo(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtprestamo.options[1].selected=true;}else{document.form1.txtprestamo.options[0].selected=true;}}
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
} </script>
                   <td width="105"><span class="Estilo5"><select class="Estilo10" name="txtactivo" size="1" id="txtactivo" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="75"><span class="Estilo5">OCULTO : </span></td>
                   <td width="105"><span class="Estilo5"><select class="Estilo10" name="txtoculto" size="1" id="txtoculto" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)"><option>NO</option> <option>SI</option></select>  </span></td>
                   <td width="150" ><span class="Estilo5">MONTO INICIALIZABLE : </span></td>
                   <td width="110"><span class="Estilo5"><select class="Estilo10" name="txtinicializable" size="1" id="txtinicializable" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)"><option>NO</option> <option>SI</option></select>  </span></td>
                   <td width="166" ><span class="Estilo5">CANTIDAD INICIALIZABLE : </span></td>
                   <td width="80"><span class="Estilo5"><select class="Estilo10" name="txtinicializable_c" size="1" id="txtinicializable_c" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)"><option>NO</option> <option>SI</option></select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_activo('<?echo $activo;?>'); asig_oculto('<?echo $oculto;?>'); asig_monto_ini('<?echo $inicializable;?>'); asig_cantidad_ini('<?echo $inicializable_c;?>'); </script>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="145"><span class="Estilo5">ACUMULA HISTORICO : </span></td>
                   <td width="100"><span class="Estilo5"><select class="Estilo10" name="txtacumula" size="1" id="txtacumula" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="260"><span class="Estilo5">INTERVIENE EN CALCULO DE VACACIONES : </span></td>
                   <td width="146"><span class="Estilo5"><select class="Estilo10" name="txtcal_vac" size="1" id="txtcal_vac" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="120" ><span class="Estilo5">TIPO DE GRUPO : </span></td>
                   <td width="80" ><span class="Estilo5"> <input class="Estilo10" name="txttipo_grupo" type="text" id="txttipo_grupo" size="4" maxlength="1" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_grupo?>"  onkeypress="return tabular(event,this)"></span></td>
<script language="JavaScript" type="text/JavaScript"> asig_acumula('<?echo $acumula;?>'); asig_cal_vac('<?echo $cal_vac;?>'); </script>
                 </tr>
             </table></td>
           </tr>
           <tr>
            <td><table width="866">
                 <tr>
                   <td width="90"><span class="Estilo5">FRECUENCIA : </span></td>
                   <td width="310"><span class="Estilo5"><select class="Estilo10" name="txtfrecuencia" size="1" id="txtfrecuencia" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)">
                      <option>PRIMERA QUINCENA</option> <option>SEGUNDA QUINCENA</option> <option>PRIMERA Y SEGUNDA QUINCENA</option>
                      <option>PRIMERA SEMANA</option> <option>SEGUNDA SEMANA</option> <option>TERCERA SEMANA</option> <option>CUARTA SEMANA</option>
                      <option>QUINTA SEMANA</option> <option>TODAS LAS SEMANAS</option> <option>ULTIMA SEMANA</option> </select>  </span></td>
                   <td width="166"><span class="Estilo5">CONCEPTO DE PRESTAMO : </span></td>
                   <td width="90"><span class="Estilo5"><select class="Estilo10" name="txtprestamo" size="1" id="txtprestamo" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)"><option>NO</option> <option>SI</option></select>  </span></td>
                   <td width="130"><span class="Estilo5">ORDEN DE C&Aacute;LCULO : </span></td>
                   <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtcod_orden" type="text" id="txtcod_orden" size="4" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_orden(this.form);"  value="<?echo $cod_orden?>"  onkeypress="return tabular(event,this)"></span></td>
<script language="JavaScript" type="text/JavaScript"> asig_prestamo('<?echo $prestamo;?>'); asig_frecuencia('<?echo $frecuencia;?>'); </script>
                 </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
                  <td width="664">&nbsp;</td>
                  <td width="80"><input name="txtdescripcion_ret" type="hidden" id="txtdescripcion_ret" value=""></td>
                  <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                </tr>
          </table>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>