<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");  $equipo=getenv("COMPUTERNAME"); $mcod_m="NOM053".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $fecha_hoy=asigna_fecha_hoy();
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}

if (!$_GET){ $cedula=''; $p_letra=''; $sql="SELECT * FROM NOM053 ORDER BY cedula";}
else {$cedula = $_GET["Gcedula"];$p_letra=substr($cedula, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cedula=substr($cedula,1,12);} else{$cedula=substr($cedula,0,12);}
  $sql="Select * from NOM053 where cedula='$cedula' ";
  if ($p_letra=="P"){$sql="SELECT * FROM NOM053 ORDER BY cedula";}
  if ($p_letra=="U"){$sql="SELECT * From NOM053 Order by cedula desc";}
  if ($p_letra=="S"){$sql="SELECT * From NOM053 Where (cedula>'$cedula') Order by cedula";}
  if ($p_letra=="A"){$sql="SELECT * From NOM053 Where (cedula<'$cedula') Order by cedula desc";}
 // echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Informaci&oacute;n Elegibles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var Gcedula = "";
function Llamar_Incluir(mop){ document.form2.submit(); }
function Llamar_Ventana(url){var murl;
    Gcedula=document.form1.txtcedula.value;murl=url+Gcedula;
    if (Gcedula==""){alert("Cedula/Rif debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_info_elegibles.php";
   if(MPos=="P"){murl="Act_info_elegibles.php?Gcedula=P"}
   if(MPos=="U"){murl="Act_info_elegibles.php?Gcedula=U"}
   if(MPos=="S"){murl="Act_info_elegibles.php?Gcedula=S"+document.form1.txtcedula.value;}
   if(MPos=="A"){murl="Act_info_elegibles.php?Gcedula=A"+document.form1.txtcedula.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar los Datos de Elegible ?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar los Datos de Elegible ?");
    if (r==true) {url="Delete_elegible.php?Gcedula="+document.form1.txtcedula.value; VentanaCentrada(url,'Eliminar Beneficiario','','400','400','true');}}
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
$nombre="";$cedula="";$nombre1="";$nombre2="";$apellido1="";$apellido2=""; $direccion=""; $nacionalidad="";  $sexo=""; $edo_civil=""; $fecha_nacimiento=""; $edad=0;
$lugar_nacimiento="";$cod_postal="";$telefono="";$tlf_movil="";$correo="";$profesion="";$tiempo="";$grado_inst="";$poliza="";
$fecha_seguro="";$estado="";$ciudad="";$municipio="";$parroquia=""; $observacion="";$talla_camisa="";$talla_pantalon="";$talla_calzado="";$peso=""; $estatura="";$aptdo_postal="";$disponibilidad="";
$res=pg_query($sql);$filas=pg_num_rows($res); $fecha_nacimiento=$fecha_hoy;
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From NOM053 ORDER BY cedula";} if ($p_letra=="A"){$sql="SELECT * From NOM053 ORDER BY cedula desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cedula=$registro["cedula"]; $nombre=$registro["nombre_e"]; $nombre1=$registro["nombre1_e"]; $nombre2=$registro["nombre2_e"];
  $apellido1=$registro["apellido1_e"];$apellido2=$registro["apellido2_e"];$direccion=$registro["direccion_e"];$nacionalidad=$registro["nacionalidad_e"];
  $sexo=$registro["sexo_e"]; $edo_civil=$registro["edo_civil_e"]; $fecha_nacimiento=$registro["fecha_nacimiento_e"]; $edad=$registro["edad_e"];
  $lugar_nacimiento=$registro["lugar_nacimiento_e"]; $cod_postal=$registro["cod_postal_e"]; $telefono=$registro["telefono_e"];  $tlf_movil=$registro["tlf_movil_e"];
  $correo=$registro["correo_e"]; $profesion=$registro["profesion_e"]; $tiempo=$registro["tiempo_e"]; $grado_inst=$registro["grado_inst_e"]; $poliza=$registro["poliza_e"];
  $fecha_seguro=$registro["fecha_seguro_e"]; $estado=$registro["estado_e"]; $ciudad=$registro["ciudad_e"]; $municipio=$registro["municipio_e"]; $parroquia=$registro["parroquia_e"];
  $observacion=$registro["observacion_e"]; $talla_camisa=$registro["talla_camisa_e"]; $talla_pantalon=$registro["talla_pantalon_e"]; $talla_calzado=$registro["talla_calzado_e"]; $peso=$registro["peso_e"];
  $estatura=$registro["estatura_e"]; $aptdo_postal=$registro["aptdo_postal_e"]; $disponibilidad=$registro["disponibilidad"];  $inf_usuario=$registro["inf_usuario"]; $fecha_nacimiento=formato_ddmmaaaa($fecha_nacimiento);
}   $edad=intval($edad);
$Ssql="select * from SIA000"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$reg_e=$registro["campo041"];$edo_e=$registro["campo010"];$mun_e=$registro["campo011"];$ciu_e=$registro["campo009"];}else{$reg_e="REGION CENTRO-OCCIDENTAL";$edo_e="LARA";$mun_e="IRIBARREN";$ciu_e="BARQUISIMETO";}
$cod_e="00"; $Ssql="select * FROM pre091 where estado='".$edo_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_e=$registro["cod_estado"];}
$cod_m="00"; $Ssql="select * FROM PRE093 where nombre_municipio='".$mun_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_m=$registro["cod_municipio"];}
$cod_p=$cod_m."00"; $Ssql="select * from PRE096 where substr(cod_parroquia,1,4)='".$cod_m."'  order by cod_parroquia"; $resultado=pg_query($Ssql); if($registro=pg_fetch_array($resultado,0)){$cod_p=$registro["cod_parroquia"];}
$cod_modulo="04";$campo502="NNNNNNNNNNNNNNNNNNNN";$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"];} $primero_apellido=substr($campo502,18,1); $sfecha=formato_aaaammdd($fecha_hoy);
$sSQL="SELECT ACTUALIZA_NOM067(4,'$codigo_mov','','$sfecha','','','')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM069(4,'$codigo_mov','','','','','$sfecha',0,'')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM070(4,'$codigo_mov','','$sfecha','$sfecha','','','',0)"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INFORMACI&Oacute;N DE ELEGIBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="825" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="820"><table width="92" height="813" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?if ($Mcamino{0}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Incluir()";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Incluir()">Incluir</A></td>
      </tr>
	   <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_elegibles.php?Gcedula=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="31"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_elegibles.php?Gcedula=');">Modificar</A></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="37"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="34"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="33"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="40"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_elegibles.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_elegibles.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="40"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
	  <?} ?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
          <td>&nbsp;</td>
  </table></td>
    <td width="888">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
            <div id="Layer1" style="position:absolute; width:836px; height:642px; z-index:1; top: 74px; left: 115px;">
      <form name="form1" method="post">
        <table width="865" border="0" >
           <tr>
             <td><table width="864">
               <tr>
                 <td width="156"><span class="Estilo5">C&Eacute;DULA DE IDENTIDAD :</span></td>
                 <td width="391"><span class="Estilo5"> <input name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  value="<?echo $cedula?>" readonly></span></td>
                 <td width="122"><span class="Estilo5">NACIONALIDAD : </span></td>
                 <td width="155"><span class="Estilo5"> <input name="txtnacionalidad" type="text" id="txtnacionalidad" size="15" maxlength="15"   value="<?echo $nacionalidad?>" readonly></span></td>
                 <td width="20"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="125"><span class="Estilo5">NOMBRE COMPLETO  :</span></td>
                 <td width="699"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" size="85" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="75"><span class="Estilo5">NOMBRES :</span></td>
                 <td width="175"><span class="Estilo5"><input name="txtnombre1" type="text" id="txtnombre1" size="20" maxlength="20" value="<?echo $nombre1?>" readonly> </span></td>
                 <td width="175"><span class="Estilo5"><input name="txtnombre2" type="text" id="txtnombre2" size="20" maxlength="20" value="<?echo $nombre2?>" readonly> </span></td>
                 <td width="75"><span class="Estilo5">APELLIDOS :</span></td>
                 <td width="175"><span class="Estilo5"><input name="txtapellido1" type="text" id="txtapellido1" size="20" maxlength="20" value="<?echo $apellido1?>" readonly></span></td>
                 <td width="175"><span class="Estilo5"><input name="txtapellido2" type="text" id="txtapellido2" size="20" maxlength="20" value="<?echo $apellido2?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="166"><span class="Estilo5">GRADO DE INSTRUCCI&Oacute;N : </span></td>
                 <td width="200"><span class="Estilo5"><input name="txgrado_inst" type="text" id="txtgrado_inst" size="25" maxlength="25" value="<?echo $grado_inst?>" readonly> </span></td>
                 <td width="82"><span class="Estilo5">PROFESI&Oacute;N : </span></td>
                 <td width="396"><span class="Estilo5"> <input name="txtprofesion" type="text" id="txtprofesion" size="55" maxlength="55" value="<?echo $profesion?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">EXPERIENCIA EN A&Ntilde;OS : </span></td>
                 <td width="104"><span class="Estilo5"><input name="txttiempo" type="text" id="txttiempo" size="4" maxlength="4"  value="<?echo $tiempo?>" readonly></span></td>
                 <td width="169"><span class="Estilo5">DISPONIBILIDAD EN DIAS : </span></td>
                 <td width="178"><span class="Estilo5"> <input name="txtdisponibilidad" type="text" id="txtdisponibilidad" size="5" maxlength="5"  value="<?echo $disponibilidad?>" readonly> </span></td>
                 <td width="100"><span class="Estilo5">ESTADO CIVIL  : </span></td>
                 <td width="136"><span class="Estilo5"><input name="txtedo_civil" type="text" id="txtedo_civil" size="12" maxlength="12"  value="<?echo $edo_civil?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="57"><span class="Estilo5">SEXO : </span></td>
                 <td width="228"><span class="Estilo5"><input name="txtsexo" type="text" id="txtsexo" size="12" maxlength="12"  value="<?echo $sexo?>" readonly></span></td>
                 <td width="161"><span class="Estilo5">FECHA DE NACIMIENTO  :</span></td>
                 <td width="189"><span class="Estilo5"> <input name="txtfecha_nacimiento" type="text" id="txtfecha_nacimiento" size="10" maxlength="10"  value="<?echo $fecha_nacimiento?>" readonly> </span></td>
                 <td width="75"><span class="Estilo5">EDAD : </span></td>
                 <td width="117"><span class="Estilo5"><input name="txtedad" type="text" id="txtedad" size="4" maxlength="4" value="<?echo $edad?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="154"><span class="Estilo5">LUGAR DE NACIMIENTO : </span></td>
                 <td width="695"><span class="Estilo5"><input name="txtlugar_nacimiento" type="text" id="txtlugar_nacimiento" size="85" maxlength="85"  value="<?echo $lugar_nacimiento?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="860">
               <tr>
                 <td width="85"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="745"><textarea name="txtdireccion" cols="84" readonly="readonly" class="headers" id="txtdireccion"><?echo $direccion?></textarea></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                             <td width="73"><span class="Estilo5">ESTADO :</span></td>
                 <td width="323"><span class="Estilo5"><input name="txtestado" type="text" id="txtestado" size="40"  value="<?echo $estado?>" readonly>  </span></td>
                 <td width="92"><span class="Estilo5">MUNICIPIO  : </span></td>
                 <td width="355"><span class="Estilo5"><input name="txtmunicipio" type="text" id="txtmunicipio" size="50"  value="<?echo $municipio?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="73"><span class="Estilo5">CIUDAD  : </span></td>
                 <td width="323"><span class="Estilo5"><input name="txtciudad" type="text" id="txtciudad" size="40"  value="<?echo $ciudad?>" readonly>  </span></td>
                 <td width="92"><span class="Estilo5">PARROQUIA  : </span></td>
                 <td width="355"><span class="Estilo5"><input name="txtparroquia" type="text" id="txtparroquia" size="50"  value="<?echo $parroquia?>" readonly></span></td>
              </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">TELEFONO HABITACI&Oacute;N : </span></td>
                 <td width="163"><span class="Estilo5"> <input name="txttelefono" type="text" id="txttelefono" size="20" maxlength="20" value="<?echo $telefono?>" readonly></span></td>
                 <td width="165"><span class="Estilo5">TELEFONO MOVIL/CELULAR : </span></td>
                 <td width="172"><span class="Estilo5"> <input name="txttlf_movil" type="text" id="txttlf_movil" size="20" maxlength="20"  value="<?echo $tlf_movil?>" readonly></td>
                 <td width="109"><span class="Estilo5">C&Oacute;DIGO POSTAL : </span></td>
                 <td width="78"><span class="Estilo5"><input name="txtcod_postal" type="text" id="txtcod_postal" size="5" maxlength="5"  value="<?echo $cod_postal?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">CORREO ELECTRONICO  :</span></td>
                 <td width="308"><span class="Estilo5"> <input name="txtcorreo" type="text" id="txtcorreo" size="40" maxlength="40"  value="<?echo $correo?>" readonly></span></td>
                 <td width="142"><span class="Estilo5">APARTADO POSTAL  : </span></td>
                 <td width="241"><span class="Estilo5"> <input name="txtaptdo_postal" type="text" id="txtaptdo_postal" size="20" maxlength="20"  value="<?echo $aptdo_postal?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="108"><span class="Estilo5">TALLA CAMISA  : </span></td>
                 <td width="225"><span class="Estilo5"> <input name="txttalla_camisa" type="text" id="txttalla_camisa" size="10" maxlength="10" value="<?echo $talla_camisa?>" readonly> </span></td>
                 <td width="125"><span class="Estilo5">TALLA PANTALON  : </span></td>
                 <td width="129"><span class="Estilo5"> <input name="txttalla_pantalon" type="text" id="txttalla_pantalon" size="10" maxlength="10" value="<?echo $talla_pantalon?>" readonly></span></td>
                 <td width="111"><span class="Estilo5">TALLA CALZADO  : </span></td>
                 <td width="138"><span class="Estilo5"><input name="txttalla_calzado" type="text" id="txttalla_calzado" size="10" maxlength="10" value="<?echo $talla_calzado?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>

          <table width="864" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>
              <div id="Layer3" style="position:absolute; width:847px; height:291px; z-index:2; left: 5px; top: 454px;">
                <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 848;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Informaci&oacute;n Curricular";        // Requiere: <div id="T12" class="tab-body">  ... </div>
   rows[1][2] = "Experiencia Laboral";        // Requiere: <div id="T13" class="tab-body">  ... </div>
   rows[1][3] = "Informaci&oacute;n Familiar";        // Requiere: <div id="T14" class="tab-body">  ... </div>
              </script>
                <?include ("../class/class_tab.php");?>
                <script type="text/javascript" language="javascript"> DrawTabs(); </script>
                 <!--PESTAÑA 1 -->
                <div id="T11" class="tab-body" >
                  <iframe src="Det_cons_inf_curricular_e.php?cedula=<?echo $cedula?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 2 -->
                <div id="T12" class="tab-body">
                  <iframe src="Det_cons_exp_laboral_e.php?cedula=<?echo $cedula?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 3 -->
                <div id="T13" class="tab-body">
                  <iframe src="Det_cons_inf_familiar_e.php?cedula=<?echo $cedula?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
              </div>
              </td>
            </tr>
          </table>
        </form>
      </div>
<form name="form2" method="post" action="Inc_info_ele_ar.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtregion_e" type="hidden" id="txtregion_e" value="<?echo $reg_e?>" ></td>
     <td width="5"><input name="txtestado_e" type="hidden" id="txtestado_e" value="<?echo $edo_e?>" ></td>
     <td width="5"><input name="txtmunicipio_e" type="hidden" id="txtmunicipio_e" value="<?echo $mun_e?>" ></td>
     <td width="5"><input name="txtciudad_e" type="hidden" id="txtciudad_e" value="<?echo $ciu_e?>" ></td>
     <td width="5"><input name="txtparroquia_e" type="hidden" id="txtparroquia_e" value="<?echo $mun_e?>" ></td>
     <td width="5"><input name="txtcod_estado" type="hidden" id="txtcod_estado" value="<?echo $cod_e?>" ></td>
     <td width="5"><input name="txtcod_municipio" type="hidden" id="txtcod_municipio" value="<?echo $cod_m?>" ></td>
     <td width="5"><input name="txtprimero_apellido" type="hidden" id="txtprimero_apellido" value="<?echo $primero_apellido?>" ></td>
  </tr>
</table>
</form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>