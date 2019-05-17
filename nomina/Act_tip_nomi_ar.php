<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if ($gnomina=="00"){ $criterion=""; $criterioc=""; }else{ $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
if (!$_GET){$tipo_nomina=''; $p_letra='';$sql="SELECT * FROM NOM001 ".$criterion." Order by tipo_nomina";
} else {$tipo_nomina=$_GET["Gtipo_nomina"];$p_letra=substr($tipo_nomina, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$tipo_nomina=substr($tipo_nomina,1,3);}
  $sql="Select * from NOM001 where tipo_nomina='$tipo_nomina' ".$criterioc." ";
  if ($p_letra=="P"){$sql="SELECT * FROM NOM001 ".$criterion." Order by tipo_nomina";}
  if ($p_letra=="U"){$sql="SELECT * From NOM001 ".$criterion." Order by tipo_nomina Desc";}
  if ($p_letra=="S"){$sql="SELECT * From NOM001 Where (tipo_nomina>'$tipo_nomina') ".$criterioc." Order by tipo_nomina";}
  if ($p_letra=="A"){$sql="SELECT * From NOM001 Where (tipo_nomina<'$tipo_nomina') ".$criterioc." Order by tipo_nomina Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Tipos de Nomina)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
var Gtipo_nomina=document.form1.txttipo_nomina.value;    murl=url+Gtipo_nomina;
    if (Gtipo_nomina=="") {alert("Tipo de Nomina debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_tip_nomi_ar.php";
   if(MPos=="P"){murl="Act_tip_nomi_ar.php?Gtipo_nomina=P"}
   if(MPos=="U"){murl="Act_tip_nomi_ar.php?Gtipo_nomina=U"}
   if(MPos=="S"){murl="Act_tip_nomi_ar.php?Gtipo_nomina=S"+document.form1.txttipo_nomina.value;}
   if(MPos=="A"){murl="Act_tip_nomi_ar.php?Gtipo_nomina=A"+document.form1.txttipo_nomina.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar el Tipo de Nomina ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Tipo de Nomina ?");
    if (r==true) { url="Delete_tipo_nomina.php?txttipo_nomina="+document.form1.txttipo_nomina.value;  VentanaCentrada(url,'Eliminar Tipo de Nomina','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
}
function Llama_Consultar_Historico(){var url;var r;
  url="Consulta_nominas_cerradas.php?txttipo_nomina="+document.form1.txttipo_nomina.value;  VentanaCentrada(url,'Catalogo Nominas cerradas','','620','500','true');
}
function Llama_Desbloquear(){var url;var r;
  r=confirm("Esta seguro en Desbloquear el Tipo de Nomina ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Desbloquear el Tipo de Nomina ?");
    if (r==true) { url="Desbloquea_tipo_nomina.php?txttipo_nomina="+document.form1.txttipo_nomina.value;  VentanaCentrada(url,'Desbloquear Tipo de Nomina','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
}

function Llama_Desbloquea_ext(){var url;var r;
  r=confirm("Esta seguro en Desbloquear el Tipo de Nomina Extraordinaria ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Desbloquear el Tipo de Nomina Extraordinaria ?");
    if (r==true) { url="Desbloquea_tipo_nomina_ext.php?txttipo_nomina="+document.form1.txttipo_nomina.value;  VentanaCentrada(url,'Desbloquear Tipo de Nomina','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
}
</script>
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
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
</head>
<?
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From NOM001 ".$criterion." Order  by tipo_nomina";}if ($p_letra=="A"){$sql="SELECT * From NOM001 ".$criterion." Order by tipo_nomina desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$descripcion="";$cod_grupo="";$desc_grupo="";$frec="Q"; $nro_semana=0;$frecuencia=""; $ultima_fecha="";$proxima_fecha=""; $redondear="";$inf_usuario="";
$con_sue_bas=""; $con_compen=""; $con_cal_vac=""; $con_bon_vac=""; $con_sue_int=""; $con_sue_int=""; $con_sue_tot="";  $con_tot_prima=""; $con_tot_compen=""; $status_tipo=""; $cod_tipo_liq="";
$con_cal_liqui=""; $con_liqui2=""; $con_liqui3=""; $g_orden_pago=""; $g_orden_pago_e=""; $cod_relac_apo=""; $cod_relac_nom=""; $cod_relac_ext="";  $cod_relac_vac="";	 $cal_int_fidecomiso="";
$bloqueada="N"; $bloqueada_ext="N"; $dep_prest_mes="";
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $tipo_nomina=$registro["tipo_nomina"];  $descripcion=$registro["descripcion"]; $cod_grupo=$registro["cod_grupo"];$desc_grupo=$registro["desc_grupo"];
  $frec=$registro["frecuencia"];  $nro_semana=$registro["nro_semana"]; $redondear=$registro["redondear"]; $status_tipo=$registro["status_tipo"];
  $ultima_fecha=$registro["ultima_fecha"]; $proxima_fecha=$registro["proxima_fecha"];  $fecha_h_p_n=$registro["fecha_h_p_n"]; $fecha_h_p_e=$registro["fecha_h_p_e"];
  $con_sue_bas=$registro["con_sue_bas"]; $con_compen=$registro["con_compen"]; $con_cal_vac=$registro["con_cal_vac"]; $con_bon_vac=$registro["con_bon_vac"]; $con_sue_int=$registro["con_sue_int"];
  $con_sue_int=$registro["con_sue_int"]; $con_sue_tot=$registro["con_sue_tot"];  $con_tot_prima=$registro["con_tot_prima"]; $con_tot_compen=$registro["con_tot_compen"];
  $con_cal_liqui=$registro["con_cal_liqui"]; $con_liqui2=$registro["con_liqui2"]; $con_liqui3=$registro["con_liqui3"]; $g_orden_pago=$registro["g_orden_pago"]; $g_orden_pago_e=$registro["g_orden_pago_e"];
  $cod_relac_nom=$registro["cod_relac_nom"]; $cod_relac_ext=$registro["cod_relac_ext"]; $cod_relac_apo=$registro["cod_relac_apo"];  $cod_relac_vac=$registro["cod_relac_vac"]; $cod_tipo_liq=$registro["cod_tipo_liq"];
  $inf_usuario=$registro["inf_usuario"]; $bloqueada=$registro["bloqueada"]; $bloqueada_ext=$registro["bloqueada_ext"];  $ultima_fecha=formato_ddmmaaaa($ultima_fecha);
}  if($frec=="Q"){$frecuencia="QUINCENAL";} if($frec=="S"){$frecuencia="SEMANAL";} if($frec=="M"){$frecuencia="MENSUAL";}
if(substr($status_tipo,0,1)=="S"){$cal_int_fidecomiso="SI";}else{$cal_int_fidecomiso="NO";} if($g_orden_pago=="S"){$g_orden_pago="SI";}else{$g_orden_pago="NO";}
if(substr($status_tipo,1,1)=="S"){$dep_prest_mes="SI";}else{$dep_prest_mes="NO";}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">TIPOS DE NOMINA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="506" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="503" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?if ($Mcamino{0}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_tipo_nomina.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_tipo_nomina.php">Incluir</A></td>
      </tr>
	  <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_tipo_nomina.php?Gtipo_nomina=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_tipo_nomina.php?Gtipo_nomina=');">Modificar</A></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_tipo_nomina.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_tipo_nomina.php" class="menu">Catalogo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Consultar_Historico();" class="menu">Nominas Cerradas</a></td>
  </tr>
  <?} if ($Mcamino{6}=="S"){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
  </tr>
  <?} if (($tipo_u=="A")and($bloqueada=="S")){?>
	  <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Desbloquear();" class="menu">Desbloquear</a></td>
      </tr>
  <?} if (($tipo_u=="A")and($bloqueada_ext=="S")){?>
	  <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Desbloquea_ext();" class="menu">Desbloquear Extraordinaria</a></td>
      </tr>	  
  <?}?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_tipo_nom.htm','Ayuda Tipo de Nomina','','900','600','true');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_tipo_nom.htm','Ayuda Tipo de Nomina','','900','600','true');" class="menu">Ayuda </a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 65px; left: 110px;">
        <form name="form1" method="post">
            <table width="868" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td><table width="866" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                     <td width="120"><span class="Estilo5">TIPO DE NOMINA :</span></td>
                     <td width="726"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="5" maxlength="5" value="<?echo $tipo_nomina?>" readonly>  </span></td>
                     <td width="20"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                   </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="866" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="110"><span class="Estilo5">DESCRIPCI&Oacute;N  :</span></td>
                    <td width="756"><span class="Estilo5"><textarea name="txtdescripcion" cols="90" class="Estilo10" id="txtdescripcion" readonly><?echo $descripcion?></textarea> </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="866">
                  <tr>
                    <td width="80"><span class="Estilo5">FRECUENCIA : </span></td>
                    <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtfrecuencia" type="text" id="txtfrecuencia"   size="12" maxlength="10" value="<?echo $frecuencia?>" readonly>  </span></td>
                    <td width="170"><span class="Estilo5">ULTIMA FECHA PROCESO : </span></td>
                    <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtultima_fecha" type="text" id="txtultima_fecha"  size="12" maxlength="12" value="<?echo $ultima_fecha?>"  readonly>    </span></td>
                    <td width="160"><span class="Estilo5">Nro. SEMANA/QUINCENA : </span></td>
                    <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtnro_semana" type="text" id="txtnro_semana"  size="3" maxlength="3" readonly value="<?echo $nro_semana?>">  </span></td>
                    <td width="80"><span class="Estilo5">REDONDEAR :</span></td>
                    <td width="65"><span class="Estilo5"><input class="Estilo10" name="txtredondear" type="text"  id="txtredondear"  size="4" maxlength="4" readonly value="<?echo $redondear?>"> </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="866">
                  <tr>
                    <td width="136"><span class="Estilo5">DESCRIPCI&Oacute;N GRUPO:</span></td>
                    <td width="730"><span class="Estilo5"> <textarea name="texdesc_grupo" cols="85" id="texdesc_grupo" class="Estilo10" readonly><?echo $desc_grupo?></textarea> </div></td>
                  </tr>
                </table></td>
              </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="180"><span class="Estilo5">CONCEPTO SUELDO  B&Aacute;SICO : </span></td>
                 <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtcon_sue_bas" type="text"  id="txtcon_sue_bas"  size="4" maxlength="4" readonly value="<?echo $con_sue_bas?>">  </span></td>
                 <td width="180"><span class="Estilo5">CONCEPTO COMPENSACI&Oacute;N  : </span></td>
                 <td width="80"><span class="Estilo5"> <input class="Estilo10" name="txtcon_compen" type="text"  id="txtcon_compen"  size="4" maxlength="4" readonly value="<?echo $con_compen?>">   </span></td>
                 <td width="230"><span class="Estilo5">CONCEPTO TOTAL COMPENSACIONES  : </span></td>
                 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcon_tot_compen" type="text"  id="txtcon_tot_compen"  size="4" maxlength="4" readonly value="<?echo $con_tot_compen?>">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="180"><span class="Estilo5">CONCEPTO TOTAL PRIMAS : </span></td>
                 <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtcon_tot_prima" type="text" id="txtcon_tot_prima"  size="4" maxlength="4" readonly value="<?echo $con_tot_prima?>" > </span></td>
                 <td width="180"><span class="Estilo5">CONCEPTO SUELDO INTEGRAL : </span></td>
                 <td width="80"><span class="Estilo5"> <input class="Estilo10" name="txtcon_sue_int" type="text" id="txtcon_sue_int" size="4" maxlength="4" readonly value="<?echo $con_sue_int?>">  </span></td>
                 <td width="230"><span class="Estilo5">CONCEPTO SUELDO TOTAL : </span></td>
                 <td width="60"><span class="Estilo5"> <input class="Estilo10" name="txtcon_sue_tot" type="text" id="txtcon_sue_tot" size="4" maxlength="4" readonly value="<?echo $con_sue_tot?>"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="185"><span class="Estilo5">CONCEPTO BONO VACACIONAL : </span></td>
                 <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtcon_bon_vac" type="text" id="txtcon_bon_vac"  size="4" maxlength="4" readonly value="<?echo $con_bon_vac?>"> </span></td>
                 <td width="215"><span class="Estilo5">CONCEPTO BONO VAC. POR PAGAR : </span></td>
                 <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtcon_liqui2" type="text"  id="txtcon_liqui2"  size="4" maxlength="4" readonly value="<?echo $con_liqui2?>"> </span></td>
                 <td width="220"><span class="Estilo5">CONCEPTO C&Aacute;LCULO VACACIONALES : </span></td>
                 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcon_cal_vac" type="text"  id="txtcon_cal_vac"  size="4" maxlength="4" readonly value="<?echo $con_cal_vac?>"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="240"><span class="Estilo5">CONCEPTO C&Aacute;LCULO  LIQUIDACI&Oacute;N : </span></td>
                 <td width="306"><span class="Estilo5"><input class="Estilo10" name="txtcon_cal_liqui" type="text" id="txtcon_cal_liqui"  size="4" maxlength="4" readonly value="<?echo $con_cal_liqui?>"> </span></td>
                 <td width="260"><span class="Estilo5">CONCEPTO C&Aacute;LCULO D&Iacute;AS ADICIONALES  : </span></td>
                 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcon_liqui3" type="text" id="txtcon_liqui3"  size="4" maxlength="4" readonly value="<?echo $con_liqui3?>"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="240"><span class="Estilo5">CALCULA INTERESES DE FIDECOMISO  : </span></div></td>
                 <td width="306"><span class="Estilo5"><input class="Estilo10" name="txtcal_int_fidecomiso" type="text"  id="txtcal_int_fidecomiso"  size="4" maxlength="4" readonly value="<?echo $cal_int_fidecomiso?>" >  </span></td>
                 <td width="260"><span class="Estilo5">DEPOSITAR PRESTACIONES MENSUAL  : </span></td>
                 <td width="60"><input class="Estilo10" name="txtdep_prest_mes" type="text" id="txtdep_prest_mes"  size="4" maxlength="4"  value="<?echo $dep_prest_mes?>" readonly>  </span></td>
                 
			   </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="240"><span class="Estilo5">GENERA INFORMACI&Oacute;N ORDEN DE PAGO  : </span></td>
                 <td width="306"><input class="Estilo10" name="txtg_orden_pago" type="text" id="txtg_orden_pago"  size="4" maxlength="4"  value="<?echo $g_orden_pago?>" readonly>  </span></td>
                 <td width="260"><span class="Estilo5"></span></div></td>
                 <td width="60"><span class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="230"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA O/P N&Oacute;MINA : </span></td>
                 <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtcod_relac_nom" type="text" id="txtcod_relac_nom"  size="10" maxlength="10" readonly value="<?echo $cod_relac_nom?>"> </span</td>
                 <td width="336"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA O/P N&Oacute;MINA EXTRAORDINARIA : </span></td>
                 <td width="100"><input class="Estilo10" name="txtcod_relac_ext" type="text" id="txtcod_relac_ext"  size="10" maxlength="10" readonly value="<?echo $cod_relac_ext?>">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="230"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA O/P N&Oacute;MINA 2 : </span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtcod_relac_apo" type="text" id="txtcod_relac_apo"  size="10" maxlength="10" readonly value="<?echo $cod_relac_apo?>"> </span></td>
                 <td width="336"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA O/P N&Oacute;MINA VACACIONES : </span></td>
                 <td width="100"><input class="Estilo10" name="txtcod_relac_vac" type="text" id="txtcod_relac_vac"  size="10" maxlength="10" readonly value="<?echo $cod_relac_vac?>">  </span></td>
              </tr>			   
			  </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="316"><span class="Estilo5">DIAS AL MES/TRIMESTRES CALCULO PRESTACIONES : </span></td>
                 <td width="550"><span class="Estilo5"><input class="Estilo10" name="txtcod_tipo_liq" type="text" id="txtcod_tipo_liq"  size="6" maxlength="5" readonly  value="<?echo $cod_tipo_liq?>" > </span></td>
               </tr>
             </table></td>
           </tr>	
         </table>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>