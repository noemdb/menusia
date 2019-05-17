<?include ("../class/conect.php");  include ("../class/funciones.php");
$equipo=getenv("COMPUTERNAME"); $equipo=getenv("COMPUTERNAME"); $mcod_m="NOM053".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$codigo_mov="";$cedula="";} else{$cedula=$_GET["Gcedula"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$cod_modulo="04";$campo502="NNNNNNNNNNNNNNNNNNNN";$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"];}$p_apellido=substr($campo502,18,1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Informaci&oacute;n Elegibles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
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
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
var mp_apellido='<?php echo $p_apellido ?>';

function chequea_nombre(mform){
var mnombre; var mnombre2; var mnombre2; var mapellido1; var mapellido2;
   mnombre1=mform.txtnombre1.value;  mnombre2=mform.txtnombre2.value; mapellido1=mform.txtapellido1.value; mapellido2=mform.txtapellido2.value;
   mnombre=mnombre1+' '+mnombre2+' '+mapellido1+' '+mapellido2;
   if(mp_apellido=="S"){ mnombre=mapellido1+' '+mapellido2+' '+mnombre1+' '+mnombre2;  }
   mform.txtnombre.value=mnombre;
return true;}
function chequea_fecha_nac(mform){ var mfecha; var mref=mform.txtfecha_nacimiento.value; var mfec; var yearn; var miFecha; var dif;
var mhoy=new Date();  var year=mhoy.getFullYear(); var mmonth=mhoy.getMonth(); var mday=mhoy.getDay(); var ano=2000; var mes; var dia; mfecha=mref;
 if(mfecha.length==8){mfec=mfecha.substring(0,6)+"20"+mfecha.charAt(6)+mfecha.charAt(7);  mform.txtfecha_nacimiento.value=mfec; mfecha=mref;}
 dia=mfecha.charAt(0)+mfecha.charAt(1); mes=mfecha.charAt(3)+mfecha.charAt(4); ano=mfecha.charAt(6)+mfecha.charAt(7)+mfecha.charAt(8)+mfecha.charAt(9);
 miFecha=new Date(ano,mes-1,dia);  yearn=miFecha.getFullYear(); dif=mhoy-miFecha; dif=dif/(86400000*365); dif=year-yearn;
 if(mmonth<(mes-1)){dif=dif-1;} if((mmonth==(mes-1))&&(dia>mday)){dif=dif-1;} mform.txtedad.value=dif;
return true;}
function revisar(){
var f=document.form1;
    if(f.txtcedula.value==""){alert("Cedula d no puede estar Vacio");return false;}else{f.txtcedula.value=f.txtcedula.value.toUpperCase();}
    if(f.txtnombre.value==""){alert("Nombre no puede estar Vacia"); return false; } else{f.txtnombre.value=f.txtnombre.value.toUpperCase();}
   document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {font-size: 16pt;font-weight: bold;}
.Estilo9 {font-size: 8pt}
.Estilo10 {font-size: 12px}
-->
</style>
</head>
<body>
<?
$nombre="";$nombre1="";$nombre2="";$apellido1="";$apellido2=""; $direccion=""; $nacionalidad="";  $sexo=""; $edo_civil=""; $fecha_nacimiento=""; $edad=0;
$lugar_nacimiento="";$cod_postal="";$telefono="";$tlf_movil="";$correo="";$profesion="";$tiempo="";$grado_inst="";$poliza="";
$fecha_seguro="";$estado="";$ciudad="";$municipio="";$parroquia=""; $observacion="";$talla_camisa="";$talla_pantalon="";$talla_calzado="";$peso=""; $estatura="";$aptdo_postal="";$disponibilidad="";
$sql="Select * from NOM053 where cedula='$cedula'";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cedula=$registro["cedula"]; $nombre=$registro["nombre_e"]; $nombre1=$registro["nombre1_e"]; $nombre2=$registro["nombre2_e"];
  $apellido1=$registro["apellido1_e"];$apellido2=$registro["apellido2_e"];$direccion=$registro["direccion_e"];$nacionalidad=$registro["nacionalidad_e"];
  $sexo=$registro["sexo_e"]; $edo_civil=$registro["edo_civil_e"]; $fecha_nacimiento=$registro["fecha_nacimiento_e"]; $edad=$registro["edad_e"];
  $lugar_nacimiento=$registro["lugar_nacimiento_e"]; $cod_postal=$registro["cod_postal_e"]; $telefono=$registro["telefono_e"];  $tlf_movil=$registro["tlf_movil_e"];
  $correo=$registro["correo_e"]; $profesion=$registro["profesion_e"]; $tiempo=$registro["tiempo_e"]; $grado_inst=$registro["grado_inst_e"]; $poliza=$registro["poliza_e"];
  $fecha_seguro=$registro["fecha_seguro_e"]; $estado=$registro["estado_e"]; $ciudad=$registro["ciudad_e"]; $municipio=$registro["municipio_e"]; $parroquia=$registro["parroquia_e"];
  $observacion=$registro["observacion_e"]; $talla_camisa=$registro["talla_camisa_e"]; $talla_pantalon=$registro["talla_pantalon_e"]; $talla_calzado=$registro["talla_calzado_e"]; $peso=$registro["peso_e"];
  $estatura=$registro["estatura_e"]; $aptdo_postal=$registro["aptdo_postal_e"]; $disponibilidad=$registro["disponibilidad"];  $inf_usuario=$registro["inf_usuario"]; $fecha_nacimiento=formato_ddmmaaaa($fecha_nacimiento);
}   $sfecha=formato_aaaammdd($fecha_hoy); $edad=intval($edad);
$sSQL="SELECT ACTUALIZA_NOM067(4,'$codigo_mov','','$sfecha','','','')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM069(4,'$codigo_mov','','','','','$sfecha',0,'')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM070(4,'$codigo_mov','','$sfecha','$sfecha','','','',0)"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sql="SELECT * FROM NOM055  where cedula='$cedula' order by fecha_desde_le"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $fechad=$registro["fecha_desde_le"]; $fechah=$registro["fecha_hasta_le"]; $monto_s=$registro["sueldo_le"]; $empresa=$registro["empresa_le"]; $depar=$registro["departamento_le"]; $cargo=$registro["cargo_le"];
 $sSQL="SELECT ACTUALIZA_NOM070(1,'$codigo_mov','$cedula','$fechad','$fechah','$empresa','$depar','$cargo',$monto_s)";
 $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
}
$sql="SELECT * FROM NOM056 where cedula='$cedula' order by fecha_ce"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){$fechac=$registro["fecha_ce"]; $titulo=$registro["titulo_ce"]; $instituto=$registro["instituto_ce"];  $descripcion=$registro["descripcion_ce"];
  $sSQL="SELECT ACTUALIZA_NOM067(1,'$codigo_mov','$cedula','$fechac','$titulo','$instituto','$descripcion')";
  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
}
$sql="SELECT * FROM NOM054  where cedula='$cedula' order by ci_partida_fe"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $sfecha=$registro["fecha_nac_fe"]; $cedulaf=$registro["ci_partida_fe"];$nombref=$registro["nombre_fe"];$sexof=$registro["sexo_fe"];$edadf=$registro["edad_fe"];$parentesco=$registro["parentesco_fe"];
 $sSQL="SELECT ACTUALIZA_NOM069(1,'$codigo_mov','$cedula','$cedulaf','$nombref','$sexof','$sfecha',$edadf,'$parentesco')";
 $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
}
$cod_estado="00"; $Ssql="SELECT * FROM pre091 where estado='".$estado."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_estado=$registro["cod_estado"];}
$cod_muni=$cod_estado."01"; $Ssql="select * FROM PRE093 where nombre_municipio='".$municipio."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_muni=$registro["cod_municipio"];}
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR INFORMACI&Oacute;N ELEGIBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="835" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="820"><table width="92" height="823" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_info_elegibles.php?Gcedula=C<?echo $cedula?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgcolor=#EAEAEA><a class=menu href="Act_info_elegibles.php?Gcedula=C<?echo $cedula?>">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>

    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:867px; height:472px; z-index:1; top: 68px; left: 119px;">
        <form name="form1" method="post" action="Update_inf_elegible.php" onSubmit="return revisar()">
          <table width="865" border="0" >
            <tr>
             <td><table width="864">
               <tr>
                 <td width="156"><span class="Estilo5">C&Eacute;DULA DE IDENTIDAD :</span></td>
                 <td width="391"><span class="Estilo5"> <input name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  value="<?echo $cedula?>" readonly></span></td>
<script language="JavaScript" type="text/JavaScript"> function asig_nacionalidad(mvalor){var f=document.form1;  if(mvalor=="VENEZOLANO"){document.form1.txtnacionalidad.options[0].selected = true;}else{document.form1.txtnacionalidad.options[1].selected = true;}} </script>
                 <td width="122"><span class="Estilo5">NACIONALIDAD : </span></td>
                 <td width="175"><span class="Estilo5"><select name="txtnacionalidad" size="1" id="txtnacionalidad" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>VENEZOLANO</option> <option>EXTRANJERO</option> </select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_nacionalidad('<?echo $nacionalidad;?>');</script>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="124"><span class="Estilo5">NOMBRE COMPLETO  :</span></td>
                 <td width="720"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" size="85" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="75"><span class="Estilo5">NOMBRES :</span></td>
                 <td width="175"><span class="Estilo5"><input name="txtnombre1" type="text" id="txtnombre1" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);" value="<?echo $nombre1?>"> </span></td>
                 <td width="175"><span class="Estilo5"><input name="txtnombre2" type="text" id="txtnombre2" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);" value="<?echo $nombre2?>"> </span></td>
                 <td width="75"><span class="Estilo5">APELLIDOS :</span></td>
                 <td width="175"><span class="Estilo5"><input name="txtapellido1" type="text" id="txtapellido1" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);" value="<?echo $apellido1?>"></span></td>
                 <td width="175"><span class="Estilo5"><input name="txtapellido2" type="text" id="txtapellido2" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);" value="<?echo $apellido2?>"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
<script language="JavaScript" type="text/JavaScript">
function asig_grado_inst(mvalor){var f=document.form1;
    if(mvalor=="PRIMARIA"){document.form1.txgrado_inst.options[0].selected = true;}
        if(mvalor=="BASICO"){document.form1.txgrado_inst.options[1].selected = true;}
        if(mvalor=="BACHILLER"){document.form1.txgrado_inst.options[2].selected = true;}
        if(mvalor=="TECNICO MEDIO"){document.form1.txgrado_inst.options[3].selected = true;}
        if(mvalor=="TECNICO SUPERIOR"){document.form1.txgrado_inst.options[4].selected = true;}
        if(mvalor=="UNIVERSITARIO"){document.form1.txgrado_inst.options[5].selected = true;}
        if(mvalor=="MAESTRIA"){document.form1.txgrado_inst.options[6].selected = true;}
        if(mvalor=="DOCTORADO"){document.form1.txgrado_inst.options[7].selected = true;}
        if(mvalor=="NINGUNO"){document.form1.txgrado_inst.options[8].selected = true;}
}</script>
                 <td width="166"><span class="Estilo5">GRADO DE INSTRUCCI&Oacute;N : </span></td>
                 <td width="200"><span class="Estilo5"><select name="txgrado_inst" size="1" id="txgrado_inst" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>PRIMARIA</option> <option>BASICO</option> <option>BACHILLER</option> <option>TECNICO MEDIO</option> <option>TECNICO SUPERIOR</option>
                      <option>UNIVERSITARIO</option>  <option>MAESTRIA</option> <option>DOCTORADO</option>  <option>NINGUNO</option>
                    </select>
                 </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_grado_inst('<?echo $grado_inst;?>');</script>
                 <td width="82"><span class="Estilo5">PROFESI&Oacute;N : </span></td>
                 <td width="396"><span class="Estilo5"> <input name="txtprofesion" type="text" id="txtprofesion" size="55" maxlength="55" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $profesion?>"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">EXPERIENCIA EN AÑOS : </span></td>
                 <td width="104"><span class="Estilo5"><input name="txttiempo" type="text" id="txttiempo" size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tiempo?>"></span></td>
                 <td width="169"><span class="Estilo5">DISPONIBILIDAD EN DIAS : </span></td>
                 <td width="178"><span class="Estilo5"> <input name="txtdisponibilidad" type="text" id="txtdisponibilidad" size="5" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $disponibilidad?>" > </span></td>
                 <td width="100"><span class="Estilo5">ESTADO CIVIL  : </span></td>
<script language="JavaScript" type="text/JavaScript">
function asig_edo_civil(mvalor){var f=document.form1;
    if(mvalor=="SOLTERO"){document.form1.txtedo_civil.options[0].selected = true;}
        if(mvalor=="CASADO"){document.form1.txtedo_civil.options[1].selected = true;}
        if(mvalor=="VIUDO"){document.form1.txtedo_civil.options[2].selected = true;}
        if(mvalor=="DIVORCIADO"){document.form1.txtedo_civil.options[3].selected = true;}
        if(mvalor=="CONCUBINO"){document.form1.txtedo_civil.options[4].selected = true;}
        if(mvalor=="OTROS"){document.form1.txtedo_civil.options[5].selected = true;}
}</script>
                 <td width="136"><span class="Estilo5"> <select name="txtedo_civil" size="1" id="txtedo_civil" onFocus="encender(this)" onBlur="apagar(this)">
                    <option>SOLTERO</option> <option>CASADO</option>
                    <option>VIUDO</option> <option>DIVORCIADO</option> <option>CONCUBINO</option> <option>OTROS</option>
                  </select>
                 </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_edo_civil('<?echo $edo_civil;?>');</script>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="57"><span class="Estilo5">SEXO : </span></td>
<script language="JavaScript" type="text/JavaScript"> function asig_sexo(mvalor){var f=document.form1; if(mvalor=="MASCULINO"){document.form1.txtsexo.options[0].selected = true;}else{document.form1.txtsexo.options[1].selected = true;}}</script>
                 <td width="228"><span class="Estilo5"> <select name="txtsexo" size="1" id="txtsexo" onFocus="encender(this)" onBlur="apagar(this)"> <option>MASCULINO</option><option>FEMENINO</option> </select> </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_sexo('<?echo $sexo;?>');</script>
                 <td width="161"><span class="Estilo5">FECHA DE NACIMIENTO  :</span></td>
                 <td width="189"><span class="Estilo5"> <input name="txtfecha_nacimiento" type="text" id="txtfecha_nacimiento" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_fecha_nac(this.form)" value="<?echo $fecha_nacimiento?>" > </span></td>
                 <td width="75"><span class="Estilo5">EDAD : </span></td>
                 <td width="117"><span class="Estilo5"><input name="txtedad" type="text" id="txtedad" size="4" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $edad?>" ></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="154"><span class="Estilo5">LUGAR DE NACIMIENTO : </span></td>
                 <td width="695"><span class="Estilo5"><input name="txtlugar_nacimiento" type="text" id="txtlugar_nacimiento" size="85" maxlength="85"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $lugar_nacimiento?>"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="860">
               <tr>
                 <td width="85"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="745"><textarea name="txtdireccion" cols="84" class="headers" onFocus="encender(this)" onBlur="apagar(this)" id="txtdireccion"><?echo $direccion?></textarea></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
<script language="JavaScript" type="text/JavaScript">
function chequea_estado(mform){ var cod_edo;  var cod_mun; cod_edo=mform.txtestado.value;  cod_mun=mform.txtestado.value+'01';
ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio;?>&cod_estado='+cod_edo, 'municipio', 'innerHTML');
ajaxSenddoc('GET', 'cargaciudad.php?ciudad=<? echo $ciudad;?>&cod_estado='+cod_edo, 'ciudad', 'innerHTML');
ajaxSenddoc('GET', 'cargaparroquia.php?parroquia=<? echo $parroquia;?>&cod_muni='+cod_mun, 'parro', 'innerHTML');
return true;}
function apaga_municipio(mthis){
var mcod_mun;  apagar(mthis); mcod_mun=mthis.value;}
function chequea_municipio(mform){ var mcod_mun; mcod_mun=mform.txtmunicipio.value;
ajaxSenddoc('GET', 'cargaparroquia.php?parroquia=<? echo $parroquia;?>&cod_muni='+mcod_mun, 'parro', 'innerHTML');
return true;}
</script>
               <tr>
                 <td width="73"><span class="Estilo5">ESTADO :</span></td>
                 <td width="323"><span class="Estilo5"> <div id="estado"><select name="txtestado" id="txtestado" onFocus="encender(this)" onBlur="apagar(this);" onchange="chequea_estado(this.form)">
                    <option value="<? echo $cod_estado;?>"><? echo $estado;?></option></div></span></td>
<script language="JavaScript" type="text/JavaScript">ajaxSenddoc('GET', 'cargaentidades.php?mestado=<? echo $estado;?>', 'estado', 'innerHTML'); </script>
                 <td width="92"><span class="Estilo5">MUNICIPIO  : </span></td>
                 <td width="355"><span class="Estilo5"><div id="municipio"><select name="txtmunicipio" id="txtmunicipio" onFocus="encender(this)" onBlur="apagar(this);" onchange="chequea_municipio(this.form)" >
                     <option value="<? echo $cod_muni;?>"><? echo $municipio;?></option> </div></span></td>
<script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value; ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio;?>&cod_estado='+cod_e, 'municipio', 'innerHTML'); </script>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="73"><span class="Estilo5">CIUDAD  : </span></td>
                 <td width="333"><span class="Estilo5"> <div id="ciudad"><select name="txtciudad" id="txtciudad" onFocus="encender(this)" onBlur="apagar(this);">
                    <option><? echo $ciudad;?></option> </div></span></td>
<script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value; ajaxSenddoc('GET', 'cargaciudad.php?ciudad=<? echo $ciudad;?>&cod_estado='+cod_e, 'ciudad', 'innerHTML'); </script>
                 <td width="92"><span class="Estilo5">PARROQUIA  : </span></td>
                 <td width="355"><span class="Estilo5"><div id="parro"><select name="txtparroquia" id="txtparroquia" onFocus="encender(this)" onBlur="apagar(this);">
                    <option><? echo $parroquia;?></option> </div></span></td>
<script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtmunicipio.value; ajaxSenddoc('GET', 'cargaparroquia.php?parroquia=<? echo $parroquia;?>&cod_muni='+cod_e, 'parro', 'innerHTML'); </script>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">TELEFONO HABITACI&Oacute;N : </span></td>
                 <td width="163"><span class="Estilo5"> <input name="txttelefono" type="text" id="txttelefono" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $telefono?>"></span></td>
                 <td width="165"><span class="Estilo5">TELEFONO MOVIL/CELULAR : </span></td>
                 <td width="172"><span class="Estilo5"> <input name="txttlf_movil" type="text" id="txttlf_movil" size="20" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tlf_movil?>"></td>
                 <td width="109"><span class="Estilo5">C&Oacute;DIGO POSTAL : </span></td>
                 <td width="78"><span class="Estilo5"><input name="txtcod_postal" type="text" id="txtcod_postal" size="5" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_postal?>"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">CORREO ELECTRONICO  :</span></td>
                 <td width="308"><span class="Estilo5"> <input name="txtcorreo" type="text" id="txtcorreo" size="40" maxlength="40"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $correo?>"></span></td>
                 <td width="142"><span class="Estilo5">APARTADO POSTAL  : </span></td>
                 <td width="241"><span class="Estilo5"> <input name="txtaptdo_postal" type="text" id="txtaptdo_postal" size="20" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $aptdo_postal?>"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="108"><span class="Estilo5">TALLA CAMISA  : </span></td>
                 <td width="225"><span class="Estilo5"> <input name="txttalla_camisa" type="text" id="txttalla_camisa" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $talla_camisa?>"> </span></td>
                 <td width="125"><span class="Estilo5">TALLA PANTALON  : </span></td>
                 <td width="129"><span class="Estilo5"> <input name="txttalla_pantalon" type="text" id="txttalla_pantalon" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $talla_pantalon?>"></span></td>
                 <td width="111"><span class="Estilo5">TALLA CALZADO  : </span></td>
                 <td width="138"><span class="Estilo5"><input name="txttalla_calzado" type="text" id="txttalla_calzado" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $talla_calzado?>"> </span></td>
               </tr>
             </table></td>
           </tr>
        </table>
          <table width="864" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>
              <div id="Layer3" style="position:absolute; width:860px; height:290px; z-index:2; left: 1px; top: 442px;">
                <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 848;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Informaci&oacute;n Curricular";
   rows[1][2] = "Experiencia Laboral";
   rows[1][3] = "Informaci&oacute;n Familiar";
              </script>
                <?include ("../class/class_tab.php");?>
                <script type="text/javascript" language="javascript"> DrawTabs(); </script>
                <!-- PESTAÑA 1 -->
                <div id="T11" class="tab-body" >
                  <iframe src="Det_inc_inf_curricular_e.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 2 -->
                <div id="T12" class="tab-body">
                  <iframe src="Det_inc_exp_laboral_e.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 3 -->
                <div id="T13" class="tab-body">
                  <iframe src="Det_inc_inf_familiar_e.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
              </div>
              </td>
            </tr>
          </table>
                  <div id="Layer3" style="position:absolute; width:859px; height:37px; z-index:2; left: 0px; top: 785px;">
          <table width="859">
                <tr>
                  <td width="100"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
                  <td width="564">&nbsp;</td>
                  <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                  <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
                </tr>
          </table>
                  </div>
      </form> </div>
    </td>
</tr>
</table>
</body>
</html>