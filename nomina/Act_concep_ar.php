<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000015"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
if (!$_GET){$tipo_nomina=''; $cod_concepto=''; $p_letra='';$sql="SELECT * FROM conceptos ".$criterion." Order by tipo_nomina,cod_concepto";
} else {$codigo=$_GET["Gcodigo"];$p_letra=substr($codigo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$tipo_nomina=substr($codigo,1,2);$cod_concepto=substr($codigo,3,3);} else{$tipo_nomina=substr($codigo,0,2);$cod_concepto=substr($codigo,2,3);}
  $sql="Select * from conceptos where tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' ".$criterioc.""; $clave=$tipo_nomina.$cod_concepto;
  if ($p_letra=="P"){$sql="SELECT * FROM conceptos ".$criterion." Order by tipo_nomina,cod_concepto";}
  if ($p_letra=="U"){$sql="SELECT * From conceptos ".$criterion." Order by tipo_nomina Desc,cod_concepto Desc";}
  if ($p_letra=="S"){$sql="SELECT * From conceptos Where (text(tipo_nomina)||text(cod_concepto)>'$clave') ".$criterioc." Order by tipo_nomina,cod_concepto";}
  if ($p_letra=="A"){$sql="SELECT * From conceptos Where (text(tipo_nomina)||text(cod_concepto)<'$clave') ".$criterioc." Order by tipo_nomina Desc,cod_concepto Desc";}
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Conceptos de Nomina)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Incluir(mop){ document.form2.submit(); }
function Llamar_Ventana(url){var murl;
var Gcodigo=document.form1.txttipo_nomina.value+document.form1.txtcod_concepto.value;    murl=url+Gcodigo;
    if (Gcodigo=="") {alert("Concepto debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_concep_ar.php";
   if(MPos=="P"){murl="Act_concep_ar.php?Gcodigo=P"}
   if(MPos=="U"){murl="Act_concep_ar.php?Gcodigo=U"}
   if(MPos=="S"){murl="Act_concep_ar.php?Gcodigo=S"+document.form1.txttipo_nomina.value+document.form1.txtcod_concepto.value;}
   if(MPos=="A"){murl="Act_concep_ar.php?Gcodigo=A"+document.form1.txttipo_nomina.value+document.form1.txtcod_concepto.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar el Concepto ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Concepto ?");
    if (r==true) { url="Delete_concepto.php?txttipo_nomina="+document.form1.txttipo_nomina.value+"&txtcod_concepto="+document.form1.txtcod_concepto.value;  VentanaCentrada(url,'Eliminar Conceptos de N&oacute;mina','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
}
function Llama_Especial(){var url;var r;
  r=confirm("Esta seguro en Modificar Concepto como Calculo Especial ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Modificar Concepto como Calculo Especial ?");
    if (r==true) { url="Especial_concepto.php?txttipo_nomina="+document.form1.txttipo_nomina.value+"&txtcod_concepto="+document.form1.txtcod_concepto.value;  VentanaCentrada(url,'Eliminar Conceptos de N&oacute;mina','','400','400','true');} }
   else { url="Cancelado, no modifica"; }
}
function Llama_Asigna_Grupo(){var url;var r;
  r=confirm("Asignar el Concepto a Trabajadores por Grupo ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Asignar el Concepto a Trabajadores ?");
    if (r==true) { url="Asigna_concepto_grupo.php?txttipo_nomina="+document.form1.txttipo_nomina.value+"&txtcod_concepto="+document.form1.txtcod_concepto.value;  VentanaCentrada(url,'Asignar Conceptos de N&oacute;mina','','400','400','true');} }
   else { url="Cancelado, no asignado"; }
}

function Llama_Asigna_Persona(){var murl;
var Gcodigo=document.form1.txttipo_nomina.value+document.form1.txtcod_concepto.value;    murl="Asigna_concepto_persona.php?Gcodigo="+Gcodigo;
    if (Gcodigo=="") {alert("Concepto debe ser Seleccionada");} else {document.location = murl;}
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
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From conceptos ".$criterion." Order by tipo_nomina,cod_concepto";}if ($p_letra=="A"){$sql="SELECT * From conceptos ".$criterion." Order by tipo_nomina desc,cod_concepto desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$denominacion="";$cod_partida="";$cod_cat_alter=""; $cod_contable="";$asignacion="";$tipo_asigna="";$asig_ded_apo="";$activo=""; $frec="3"; $descripcion=""; $tipo_concepto=""; $tipo_a=""; $cal_vac=""; $cod_aporte=""; $fuente="";
$inicializable="";$inicializable_c="";$oculto="";$acumula="";$tipo_grupo="";$frecuencia="";$afecta_presup="";$cod_retencion="";$grupo_retencion="";$prestamo="";$status="";$cod_orden="";$inf_usuario="";
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];  $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; $fuente=$registro["cod_contable"];
  $cod_partida=$registro["cod_partida"]; $cod_cat_alter=$registro["cod_cat_alter"]; $asignacion=$registro["asignacion"]; $tipo_a=$registro["tipo_asigna"]; $frec=$registro["frecuencia"];
  $asig_ded_apo=$registro["asig_ded_apo"]; $activo=$registro["activo"]; $inicializable=$registro["inicializable"]; $inicializable_c=$registro["inicializable_c"];  $cod_aporte=$registro["cod_aporte"];
  $oculto=$registro["oculto"]; $acumula=$registro["acumula"]; $tipo_grupo=$registro["tipo_grupo"]; $afecta_presup=$registro["afecta_presup"]; $cod_retencion=$registro["cod_retencion"];
  $grupo_retencion=$registro["grupo_retencion"]; $prestamo=$registro["prestamo"]; $status=$registro["status"]; $cod_orden=$registro["cod_orden"]; $inf_usuario=$registro["inf_usuario"];
} if($asignacion=="SI"){$tipo_concepto="ASIGNACION";}else{if($asig_ded_apo=="D"){$tipo_concepto="DEDUCCION";}else{$tipo_concepto="APORTE";}}
$tipo_asigna="OTROS"; if($tipo_a=="S"){$tipo_asigna="SUELDO";} if($tipo_a=="C"){$tipo_asigna="COMPENSACION";} if($tipo_a=="P"){$tipo_asigna="PRIMA";} if($tipo_a=="T"){$tipo_asigna="CESTATICKET";}
if(substr($status,0,1)=="S"){$cal_vac="SI";}else{$cal_vac="NO";}  if(substr($prestamo,0,1)=="S"){$prestamo="SI";}else{$prestamo="NO";}
if(substr($status,1,2)=="S"){$cal_esp="SI";}else{$cal_esp="NO";} 
if($frec=="1"){$frecuencia="PRIMERA QUINCENA";} if($frec=="2"){$frecuencia="SEGUNDA QUINCENA";} if($frec=="3"){$frecuencia="PRIMERA Y SEGUNDA QUINCENA";}
if($frec=="4"){$frecuencia="PRIMERA SEMANA";} if($frec=="5"){$frecuencia="SEGUNDA SEMANA";} if($frec=="6"){$frecuencia="TERCERA SEMANA";}
if($frec=="7"){$frecuencia="CUARTA SEMANA";} if($frec=="8"){$frecuencia="QUINTA SEMANA";} if($frec=="9"){$frecuencia="TODAS LAS SEMANAS";} if($frec=="0"){$frecuencia="ULTIMA SEMANA";}
$temp_des_nomina=$descripcion;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEFINICION DE CONCEPTO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
	  <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Incluir()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Incluir()">Incluir</A></td>
      </tr>
	  <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_concepto.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_concepto.php?Gcodigo=');">Modificar</A></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cons_concepto.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Cons_concepto.php">Consultar</a></td>
      </tr>
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
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_concepto.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_concepto.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
      </tr>
	  <?} if ($Mcamino{11}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
            onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Asigna_Grupo();" class="menu">Asigna por Grupo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Asigna_Persona();" class="menu">Asigna por Persona</a></td>
      </tr>
	  <?} if (($Mcamino{6}=="S") and ($Cod_Emp=="71")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Especial();" class="menu">Calculo Especial</a></td>
      </tr>
	  <?}?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_reg_conceptos.htm','Ayuda Conceptos','','900','600','true');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_reg_conceptos.htm','Ayuda Conceptos','','900','600','true');" class="menu">Ayuda </a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
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
                   <td width="645"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="80" maxlength="80" readonly value="<?echo $descripcion?>"> </span></td>
                   <td width="20"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO DE CONCEPTO : </span></td>
                   <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="4" readonly value="<?echo $cod_concepto?>"> </span></td>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                   <td width="520"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="65" maxlength="80" readonly value="<?echo $denominacion?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="155"><span class="Estilo5">C&Oacute;DIGO DE PARTIDA : </span></td>
                   <td width="180"><span class="Estilo5"> <input class="Estilo10" name="txtcod_partida" type="text" id="txtcod_partida" size="20" maxlength="20" readonly value="<?echo $cod_partida?>"> </span></td>
                   <td width="121"><span class="Estilo5">FUENTE : <span class="Estilo5"><input class="Estilo10" name="txtfuente" type="text" id="txtfuente" size="2" maxlength="2" readonly value="<?echo $fuente?>">  </span></td>
				   
				   <td width="210"><span class="Estilo5">CODIGO DE CATEGORIA ALTERNA : </span></td>
                   <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtcod_cat_alter" type="text" id="txtcod_cat_alter" size="20" maxlength="20" readonly value="<?echo $cod_cat_alter?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">TIPO DE CONCEPTO : </span></td>
                   <td width="360"><span class="Estilo5"><input class="Estilo10" name="txttipo_concepto" type="text" id="txttipo_concepto" size="17" maxlength="17" readonly value="<?echo $tipo_concepto?>"> </span></td>
                   <td width="150"><span class="Estilo5">TIPO DE ASIGNACI&Oacute;N : </span></td>
                   <td width="200"><span class="Estilo5"><input class="Estilo10" name="txttipo_asigna" type="text" id="txttipo_asigna" size="17" maxlength="17" readonly value="<?echo $tipo_asigna?>"></span></td>

                  </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="216" ><span class="Estilo5">CONCEPTO AFECTA PRESUPUESTO : </span></td>
                   <td width="110"><span class="Estilo5"> <input class="Estilo10" name="txtafecta_presup" type="text" id="txtafecta_presup" size="3" maxlength="3" readonly value="<?echo $afecta_presup?>">  </span></td>
                   <td width="180" ><span class="Estilo5">C&Oacute;DIGO TIPO DE RETENCI&Oacute;N : </span></td>
                   <td width="120" ><span class="Estilo5"><input class="Estilo10" name="txtcod_retencion" type="text" id="txtcod_retencion" size="4" maxlength="4" readonly value="<?echo $cod_retencion?>"> </span></td>
                   <td width="150"><span class="Estilo5">C&Oacute;DIGO DE APORTE : </span></td>
                   <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtcod_aporte" type="text" id="txtcod_aporte" size="4" maxlength="4" readonly value="<?echo $cod_aporte?>"> </span></td>

                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="75"><span class="Estilo5">ACTIVO : </span></td>
                   <td width="105"><span class="Estilo5"><input class="Estilo10" name="txtactivo" type="text" id="txtactivo" size="4" maxlength="4" readonly value="<?echo $activo?>"></span></td>
                   <td width="75"><span class="Estilo5">OCULTO : </span></td>
                   <td width="105"><span class="Estilo5"><input class="Estilo10" name="txtoculto" type="text" id="txtoculto" size="4" maxlength="4" readonly value="<?echo $oculto?>"></span></td>
                   <td width="150" ><span class="Estilo5">MONTO INICIALIZABLE : </span></td>
                   <td width="110" ><span class="Estilo5"> <input class="Estilo10" name="txtinicializable" type="text" id="txtinicializable" size="4" maxlength="4" readonly value="<?echo $inicializable?>"></span></td>
                   <td width="166" ><span class="Estilo5">CANTIDAD INICIALIZABLE : </span></td>
                   <td width="80" ><span class="Estilo5"><input class="Estilo10" name="txtinicializable_c" type="text" id="txtinicializable_c" size="4" maxlength="4" readonly value="<?echo $inicializable_c?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="150"><span class="Estilo5">ACUMULA HISTORICO : </span></td>
                   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtacumula" type="text" id="txtacumula" size="4" maxlength="4" readonly value="<?echo $acumula?>"></span></td>
                   <td width="260"><span class="Estilo5">INTERVIENE EN CALCULO DE VACACIONES : </span></td>
                   <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtcal_vac" type="text" id="txtcal_vac" size="4" maxlength="4" readonly value="<?echo $cal_vac?>"></span></td>
                   <td width="120" ><span class="Estilo5">TIPO DE GRUPO : </span></td>
                   <td width="80" ><span class="Estilo5"> <input class="Estilo10" name="txttipo_grupo" type="text" id="txttipo_grupo" size="4" maxlength="4" readonly value="<?echo $tipo_grupo?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
            <td><table width="866">
                 <tr>
                   <td width="90"><span class="Estilo5">FRECUENCIA : </span></td>
                   <td width="310"><span class="Estilo5"><input class="Estilo10" name="txtfrecuencia" type="text" id="txtfrecuencia" size="40" maxlength="40" readonly value="<?echo $frecuencia?>"></span></td>
                   <td width="166"><span class="Estilo5">CONCEPTO DE PRESTAMO : </span></td>
                   <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txtprestamo" type="text" id="txtprestamo" size="4" maxlength="4" readonly value="<?echo $prestamo?>"></span></td>
                   <td width="130"><span class="Estilo5">ORDEN DE C&Aacute;LCULO : </span></td>
                   <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtcod_orden" type="text" id="txtcod_orden" size="4" maxlength="4" readonly value="<?echo $cod_orden?>"></span></td>
                 </tr>
             </table></td>
           </tr>
		   <?if($Cod_Emp=="71"){?>
		   <tr>
             <td><table width="866">
                 <tr>
                   <td width="216"><span class="Estilo5">INTERVIENE EN CALCULO ESPECIAL : </span></td>
                   <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtcal_esp" type="text" id="txtcal_esp" size="4" maxlength="4" readonly value="<?echo $cal_esp?>"></span></td>
                   <td width="200" ><span class="Estilo5"></span></td>
                   <td width="250" ><span class="Estilo5"> </span></td>
                 </tr>
             </table></td>
           </tr>
		   <?}?>
         </table>
         </div>
         </form>
<form name="form2" method="post" action="Inc_concepto.php">
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