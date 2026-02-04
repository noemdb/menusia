<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000050"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
if (!$_GET){$tipo_nomina=''; $cod_concepto=''; $cod_empleado=''; $p_letra='';$sql="SELECT * FROM CONCEPTOS_ASIGNADOS ".$criterion." Order by tipo_nomina,cod_empleado,cod_concepto limit 1000";
} else {$codigo=$_GET["Gcodigo"];$p_letra=substr($codigo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$tipo_nomina=substr($codigo,1,2);$cod_concepto=substr($codigo,3,3);$cod_empleado=substr($codigo,6,15);} else{$tipo_nomina=substr($codigo,0,2);$cod_concepto=substr($codigo,2,3);$cod_empleado=substr($codigo,5,15);}
  $sql="Select * from CONCEPTOS_ASIGNADOS where tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and  cod_concepto='$cod_concepto' ".$criterioc.""; $clave=$tipo_nomina.$cod_empleado.$cod_concepto;
  if ($p_letra=="P"){$sql="SELECT * FROM CONCEPTOS_ASIGNADOS ".$criterion." Order by tipo_nomina,cod_empleado,cod_concepto limit 1000";}
  if ($p_letra=="U"){$sql="SELECT * From CONCEPTOS_ASIGNADOS ".$criterion." Order by tipo_nomina Desc,cod_empleado Desc, cod_concepto Desc limit 1000";}
  if ($p_letra=="S"){$sql="SELECT * From CONCEPTOS_ASIGNADOS Where (text(tipo_nomina)||text(cod_empleado)||text(cod_concepto)>'$clave') ".$criterioc." Order by tipo_nomina,cod_empleado,cod_concepto limit 1000";}
  if ($p_letra=="A"){$sql="SELECT * From CONCEPTOS_ASIGNADOS Where (text(tipo_nomina)||text(cod_empleado)||text(cod_concepto)<'$clave') ".$criterioc." Order by tipo_nomina Desc,cod_empleado Desc,cod_concepto Desc limit 1000";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Asignaci&oacute;n de Conceptos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Incluir(mop){ document.form2.submit(); }
function Llamar_Ventana(url){var murl;
var Gcodigo=document.form1.txttipo_nomina.value+document.form1.txtcod_concepto.value+document.form1.txtcod_empleado.value;    murl=url+Gcodigo;
    if (Gcodigo=="") {alert("Concepto debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_asig_concep_ar.php";
   if(MPos=="P"){murl="Act_asig_concep_ar.php?Gcodigo=P"}
   if(MPos=="U"){murl="Act_asig_concep_ar.php?Gcodigo=U"}
   if(MPos=="S"){murl="Act_asig_concep_ar.php?Gcodigo=S"+document.form1.txttipo_nomina.value+document.form1.txtcod_concepto.value+document.form1.txtcod_empleado.value;}
   if(MPos=="A"){murl="Act_asig_concep_ar.php?Gcodigo=A"+document.form1.txttipo_nomina.value+document.form1.txtcod_concepto.value+document.form1.txtcod_empleado.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar la Asignaci&oacute;n de Concepto ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Asignaci&oacute;n de Concepto ?");
    if (r==true) { url="Delete_asig_concepto.php?txttipo_nomina="+document.form1.txttipo_nomina.value+"&txtcod_concepto="+document.form1.txtcod_concepto.value+"&txtcod_empleado="+document.form1.txtcod_empleado.value; VentanaCentrada(url,'Eliminar Conceptos de N&oacute;mina','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
}
function Llama_act_concepto(){var url;var r;
 url="Act_grupo_concepto.php?Gtipo_nomina="+document.form1.txttipo_nomina.value+"&Gconcepto="+document.form1.txtcod_concepto.value; VentanaCentrada(url,'Actualizar Grupo de Concepto','','600','350','true');
}
function Llama_act_cod_presup(){var url;var r;
 url="Act_cod_pre_conc.php?Gtipo_nomina="+document.form1.txttipo_nomina.value+"&Gconcepto="+document.form1.txtcod_concepto.value; VentanaCentrada(url,'Actualizar Grupo de Concepto','','600','350','true');
}
</script>
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

</head>
<?
$res=pg_query($sql);$filas=pg_num_rows($res);if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From CONCEPTOS_ASIGNADOS ".$criterion." Order by tipo_nomina,cod_empleado,cod_concepto limit 1000";}if ($p_letra=="A"){$sql="SELECT * From CONCEPTOS_ASIGNADOS ".$criterion." Order by tipo_nomina desc,cod_concepto desc limit 1000";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$tipo_nomina="";$cod_empleado="";$cod_concepto="";$cantidad=0;$monto=0;$fecha_ini="";$fecha_exp="";$activo="";$calculable="";$acumulado=0;$saldo=0;$cod_presup="";$frecuencia="";$afecta_presup="";$cod_retencion="";$cod_presup_ant="";$prestamo="";$monto_prestamo="";$nro_cuotas="";$nro_cuotas_c="";$status="";$inf_usuario="";
$denominacion="";$descripcion="";$nombre="";$frec="0";$imp_fija="SI";$observacion="";
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];  $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
  $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"]; $fecha_ini=$registro["fecha_ini"]; $fecha_exp=$registro["fecha_exp"];
  $activo=$registro["activoa"]; $calculable=$registro["calculable"]; $acumulado=$registro["acumulado"]; $saldo=$registro["saldo"]; $frec=$registro["frecuenciaa"]; $cod_presup=$registro["cod_presup"];
  $afecta_presup=$registro["afecta_presup"]; $cod_retencion=$registro["cod_retencion"]; $cod_presup_ant=$registro["cod_presup_ant"]; $prestamo=$registro["prestamo"];
  $monto_prestamo=$registro["monto_prestamo"]; $nro_cuotas=$registro["nro_cuotas"]; $nro_cuotas_c=$registro["nro_cuotas_c"]; $status=$registro["statusa"]; $inf_usuario=$registro["inf_usuario"];
  $fecha_ini=formato_ddmmaaaa($fecha_ini); $fecha_exp=formato_ddmmaaaa($fecha_exp); $cantidad=formato_monto($cantidad); $monto=formato_monto($monto);  $acumulado=formato_monto($acumulado);  $saldo=formato_monto($saldo);
}  if(substr($prestamo,0,1)=="S"){$prestamo="SI";}else{$prestamo="NO";}  if(substr($status,0,1)=="S"){$imp_fija="SI";}else{$imp_fija="NO";}
if($frec=="1"){$frecuencia="PRIMERA QUINCENA";} if($frec=="2"){$frecuencia="SEGUNDA QUINCENA";} if($frec=="3"){$frecuencia="PRIMERA Y SEGUNDA QUINCENA";}
if($frec=="4"){$frecuencia="PRIMERA SEMANA";} if($frec=="5"){$frecuencia="SEGUNDA SEMANA";} if($frec=="6"){$frecuencia="TERCERA SEMANA";}
if($frec=="7"){$frecuencia="CUARTA SEMANA";} if($frec=="8"){$frecuencia="QUINTA SEMANA";} if($frec=="9"){$frecuencia="TODAS LAS SEMANAS";} if($frec=="0"){$frecuencia="ULTIMA SEMANA";}
$temp_des_nomina=$descripcion;
?>
<body>
<table width="991" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="76"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="872"><div align="center" class="Estilo2 Estilo6">ASIGNACI&Oacute;N DE CONCEPTOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="992" height="381" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="375"><table width="92" height="374" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?if ($Mcamino{0}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Incluir()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Incluir()">Incluir</A></td>
      </tr>
	  <?} if ($Mcamino{1}=="S"){?>
       <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_asig_concepto.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_asig_concepto.php?Gcodigo=');">Modificar</A></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cons_asig_concepto.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Cons_asig_concepto.php">Consultar</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Mover_Registro('P');">Primero</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_asig_concepto.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_asig_concepto.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
      </tr>
	  <?} if ($Mcamino{10}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
            onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_act_concepto();" class="menu">Actualiza Concepto</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
            onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_act_cod_presup();" class="menu">Actualiza Cod. Presupuestario</a></td>
      </tr>
	  <?} ?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr><td>&nbsp;</td> </tr>
    </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="130"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="4" maxlength="4" readonly value="<?echo $tipo_nomina?>"> </span></td>
                   <td width="645"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="100" maxlength="100" readonly value="<?echo $descripcion?>"> </span></td>
                   <td width="20"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
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
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="100"><span class="Estilo5">FECHA INICIO : </span></td>
                   <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ini" type="text" id="txtfecha_ini" size="10" maxlength="10" readonly value="<?echo $fecha_ini?>"> </span></td>
                   <td width="130"><span class="Estilo5">FECHA EXPIRACI&Oacute;N : </span></td>
                   <td width="136"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_exp" type="text" id="txtfecha_exp" size="10" maxlength="10" readonly value="<?echo $fecha_exp?>"> </span></td>
                   <td width="75"><span class="Estilo5">ACTIVO : </span></td>
                   <td width="95"><span class="Estilo5"><input class="Estilo10" name="txtactivo" type="text" id="txtactivo" size="4" maxlength="4" readonly value="<?echo $activo?>"></span></td>
                   <td width="95"><span class="Estilo5">CALCULABLE : </span></td>
                   <td width="95"><span class="Estilo5"><input class="Estilo10" name="txtcalculable" type="text" id="txtcalculable" size="4" maxlength="4" readonly value="<?echo $calculable?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="80"><span class="Estilo5">CANTIDAD : </span></td>
                   <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtcantidad" type="text" id="txtcantidad" style="text-align:right" size="14" maxlength="14" readonly value="<?echo $cantidad?>"> </span></td>
                   <td width="70"><span class="Estilo5">MONTO : </span></td>
                   <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtmonto" type="text" id="txtmonto" style="text-align:right" size="14" maxlength="14" readonly value="<?echo $monto?>"> </span></td>
                   <td width="95"><span class="Estilo5">ACUMULADO : </span></td>
                   <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtacumulado" type="text" id="txtacumulado" style="text-align:right" size="14" maxlength="14" readonly value="<?echo $acumulado?>"></span></td>
                   <td width="65"><span class="Estilo5">SALDO : </span></td>
                   <td width="130"><span class="Estilo5"><input class="Estilo10" name="txtsaldo" type="text" id="txtsaldo" style="text-align:right" size="14" maxlength="14" readonly value="<?echo $saldo?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
            <td><table width="866">
                 <tr>
                   <td width="90"><span class="Estilo5">FRECUENCIA : </span></td>
                   <td width="310"><span class="Estilo5"><input class="Estilo10" name="txtfrecuencia" type="text" id="txtfrecuencia" size="35" maxlength="35" readonly value="<?echo $frecuencia?>"></span></td>
                   <td width="180"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO : </span></td>
                   <td width="286"><span class="Estilo5"> <input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" size="35" maxlength="35" readonly value="<?echo $cod_presup?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="166" ><span class="Estilo5">AFECTA PRESUPUESTO : </span></td>
                   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtafecta_presup" type="text" id="txtafecta_presup" size="3" maxlength="3" readonly value="<?echo $afecta_presup?>">  </span></td>
                   <td width="220" ><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA FIJA : </span></td>
                   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtimp_fija" type="text" id="txtimp_fija" size="3" maxlength="3" readonly value="<?echo $imp_fija?>">  </span></td>
                   <td width="200" ><span class="Estilo5">C&Oacute;DIGO TIPO DE RETENCI&Oacute;N : </span></td>
                   <td width="80" ><span class="Estilo5"><input class="Estilo10" name="txtcod_retencion" type="text" id="txtcod_retencion" size="4" maxlength="4" readonly value="<?echo $cod_retencion?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="760">
                 <tr>
                   <td width="100"><span class="Estilo5">OBSERVACION : </span></td>
                   <td width="660"><span class="Estilo5"><input class="Estilo10" name="txtobservacion" type="text" id="txtobservacion" size="90" maxlength="100" readonly value="<?echo $observacion?>" > </span></td>
                 </tr>
             </table></td>
           </tr>
         </table>
       </div>
     </form>
<form name="form2" method="post" action="Inc_asig_concepto.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
     <td width="5"><input class="Estilo10" name="txttipo_nomina" type="hidden" id="txttipo_nomina" value="<?echo $temp_nomina?>" ></td>	
     <td width="5"><input class="Estilo10" name="txtdes_nomina" type="hidden" id="txtdes_nomina" value="<?echo $temp_des_nomina?>" ></td>
  </tr>
</table>
</form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>