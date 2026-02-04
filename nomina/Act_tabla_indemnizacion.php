<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000055"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
if (!$_GET){$tipo_nomina=''; $consecutivo=''; $p_letra='';$sql="SELECT * FROM tabla_indem ".$criterion." Order by tipo_nomina,consecutivo";
} else {$codigo=$_GET["Gcodigo"];$p_letra=substr($codigo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$tipo_nomina=substr($codigo,1,2);$consecutivo=substr($codigo,3,4);} else{$tipo_nomina=substr($codigo,0,2);$consecutivo=substr($codigo,2,4);}
  $sql="Select * from tabla_indem where tipo_nomina='$tipo_nomina' and consecutivo='$consecutivo'"; $clave=$tipo_nomina.$consecutivo;
  if ($p_letra=="P"){$sql="SELECT * FROM tabla_indem ".$criterion." Order by tipo_nomina,consecutivo";}
  if ($p_letra=="U"){$sql="SELECT * From tabla_indem ".$criterion." Order by tipo_nomina Desc,consecutivo Desc";}
  if ($p_letra=="S"){$sql="SELECT * From tabla_indem Where (text(tipo_nomina)||text(consecutivo)>'$clave') ".$criterioc." Order by tipo_nomina,consecutivo";}
  if ($p_letra=="A"){$sql="SELECT * From tabla_indem Where (text(tipo_nomina)||text(consecutivo)<'$clave') ".$criterioc." Order by tipo_nomina Desc,consecutivo Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Actualiza Tabla de Indemnizaci&oacute;n)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
var Gcodigo=document.form1.txttipo_nomina.value+document.form1.txtconsecutivo.value;    murl=url+Gcodigo;
    if (Gcodigo=="") {alert("Consecutivo debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_tabla_indemnizacion.php";
   if(MPos=="P"){murl="Act_tabla_indemnizacion.php?Gcodigo=P"}
   if(MPos=="U"){murl="Act_tabla_indemnizacion.php?Gcodigo=U"}
   if(MPos=="S"){murl="Act_tabla_indemnizacion.php?Gcodigo=S"+document.form1.txttipo_nomina.value+document.form1.txtconsecutivo.value;}
   if(MPos=="A"){murl="Act_tabla_indemnizacion.php?Gcodigo=A"+document.form1.txttipo_nomina.value+document.form1.txtconsecutivo.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar el Consecutivo de la Tabla de Idemnizacion ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar Consecutivo de la Tabla de Idemnizacion ?");
    if (r==true) { url="Delete_tabla_indem.php?txttipo_nomina="+document.form1.txttipo_nomina.value+"&txtconsecutivo="+document.form1.txtconsecutivo.value; VentanaCentrada(url,'Eliminar Tabla de Indemnizaci&oacute;n','','400','400','true');} }
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
$res=pg_query($sql);$filas=pg_num_rows($res);if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From tabla_indem ".$criterion." Order by tipo_nomina,consecutivo";}if ($p_letra=="A"){$sql="SELECT * From tabla_indem ".$criterion." Order by tipo_nomina desc,consecutivo desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$tipo_nomina="";$consecutivo="";$desde=0;$hasta=0;$antiguedad=0;$preaviso=0;$vacaciones=0;$vac_adicional=0;$bono_vacacional=0;$auxiliar1=0;$valor1=0;$valor2=0;$valor3=0;$valor4=0;$valor5=0;$descripcion="";$inf_usuario="";
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];  $consecutivo=$registro["consecutivo"]; $desde=$registro["desde"]; $hasta=$registro["hasta"];
  $antiguedad=$registro["antiguedad"]; $preaviso=$registro["preaviso"]; $vacaciones=$registro["vacaciones"]; $vac_adicional=$registro["vac_adicional"]; $bono_vacacional=$registro["bono_vacacional"];
  $auxiliar1=$registro["auxiliar1"]; $valor1=$registro["valor1"]; $valor2=$registro["valor2"]; $valor3=$registro["valor3"]; $valor4=$registro["valor4"]; $valor5=$registro["valor5"];
  $desde=formato_monto($desde); $hasta=formato_monto($hasta);  $preaviso=formato_monto($preaviso); $antiguedad=formato_monto($antiguedad); $vacaciones=formato_monto($vacaciones); $vac_adicional=formato_monto($vac_adicional); $bono_vacacional=formato_monto($bono_vacacional);  $auxiliar1=formato_monto($auxiliar1);
}
$temp_des_nomina=$descripcion;
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">TABLA DE INDEMNIZACI&Oacute;N</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="381" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="375"><table width="92" height="374" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?if ($Mcamino{0}=="S"){?>
	 <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_tabla_indemnizacion.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Inc_tabla_indemnizacion.php">Incluir</a></td>
     </tr>
	 <?} if ($Mcamino{1}=="S"){?>
     <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_tabla_indemnizacion.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_tabla_indemnizacion.php?Gcodigo=');">Modificar</A></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Copia_tabla_indemnizacion.php?Gcodigo=');";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Ventana('Copia_tabla_indemnizacion.php?Gcodigo=');">Copiar</a></td>
     </tr>
	  <?} if ($Mcamino{2}=="S"){?>
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
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_tabla_indem.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_tabla_indem.php" class="menu">Catalogo</a></td>
     </tr>
	 <?} if ($Mcamino{6}=="S"){?>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
     </tr>
	 <?} ?>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
     </tr>
      <tr><td>&nbsp;</td> </tr>
    </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 90px; left: 110px;">
        <form name="form1" method="post">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="120"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="4" maxlength="4" readonly value="<?echo $tipo_nomina?>"> </span></td>
                   <td width="656"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="100" maxlength="100" readonly value="<?echo $descripcion?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="120"><span class="Estilo5">CONSECUTIVO :</span></td>
                   <td width="166"><span class="Estilo5"> <input class="Estilo10" name="txtconsecutivo" type="text" id="txtconsecutivo" size="5" maxlength="4" readonly value="<?echo $consecutivo?>"> </span></td>
                   <td width="100"><span class="Estilo5">RANGO DESDE :</span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtdesde" type="text" id="txtdesde" style="text-align:right" size="8" maxlength="8" readonly value="<?echo $desde?>"> </span></td>
                   <td width="100"><span class="Estilo5">MESES</span></td>
                   <td width="60"><span class="Estilo5">HASTA :</span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txthasta" type="text" id="txthasta" style="text-align:right" size="8" maxlength="8" readonly value="<?echo $hasta?>"> </span></td>
                   <td width="120"><span class="Estilo5">MESES</span></td>
                  </tr>
             </table></td>
           </tr>
           <tr><td>&nbsp;</td> </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="230"><span class="Estilo5">CANTIDAD DIAS ANTIGUEDAD  :</span></td>
                   <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtantiguedad" type="text" id="txtantiguedad"  style="text-align:right" size="8" maxlength="8" readonly value="<?echo $antiguedad?>"> </span></td>
                   <td width="280"><span class="Estilo5">CANTIDAD DIAS PREAVISO  :</span></td>
                   <td width="156"><span class="Estilo5"><input class="Estilo10" name="txtpreaviso" type="text" id="txtpreaviso" style="text-align:right" size="8" maxlength="8" readonly value="<?echo $preaviso?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="230"><span class="Estilo5">CANTIDAD DIAS VACACIONES :</span></td>
                   <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtvacaciones" type="text" id="txtvacaciones"  style="text-align:right" size="8" maxlength="8" readonly value="<?echo $vacaciones?>"> </span></td>
                   <td width="280"><span class="Estilo5">CANTIDAD DIAS VACACIONES ADICIONALES :</span></td>
                   <td width="156"><span class="Estilo5"><input class="Estilo10" name="txtvac_adicional" type="text" id="txtvac_adicional" style="text-align:right" size="8" maxlength="8" readonly value="<?echo $vac_adicional?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="230"><span class="Estilo5">CANTIDAD DIAS BONO VACACIONAL :</span></td>
                   <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtbono_vacacional" type="text" id="txtbono_vacacional"  style="text-align:right" size="8" maxlength="8" readonly value="<?echo $bono_vacacional?>"> </span></td>
                   <td width="280"><span class="Estilo5">DIAS ADICIONALES BONO VACACIONAL  :</span></td>
                   <td width="156"><span class="Estilo5"><input class="Estilo10" name="txtauxiliar1" type="text" id="txtauxiliar1" style="text-align:right" size="8" maxlength="8" readonly value="<?echo $auxiliar1?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
         </table>
       </div>
     </form>
<form name="form2" method="post" action="Inc_tabla_indemnizacion.php">
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