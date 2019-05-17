<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo_mov=$_POST["txtcodigo_mov"]; $cedula=$_POST["txtcedula"]; $nacionalidad=$_POST["txtnacionalidad"];
$nombre=$_POST["txtnombre"]; $nombre1=$_POST["txtnombre1"]; $nombre2=$_POST["txtnombre2"]; $apellido1=$_POST["txtapellido1"]; $apellido2=$_POST["txtapellido2"];
$nombre=strtoupper($nombre); $nombre1=strtoupper($nombre1); $nombre2=strtoupper($nombre2); $apellido1=strtoupper($apellido1); $apellido2=strtoupper($apellido2);
$grado_inst=$_POST["txgrado_inst"]; $profesion=$_POST["txtprofesion"]; $tiempo=$_POST["txttiempo"]; $disponibilidad=$_POST["txtdisponibilidad"];
$edo_civil=$_POST["txtedo_civil"]; $sexo=$_POST["txtsexo"]; $fecha_nacimiento=$_POST["txtfecha_nacimiento"]; $edad=$_POST["txtedad"];
$lugar_nacimiento=$_POST["txtlugar_nacimiento"]; $direccion=$_POST["txtdireccion"]; $estado=$_POST["txtestado"]; $municipio=$_POST["txtmunicipio"];
$ciudad=$_POST["txtciudad"]; $parroquia=$_POST["txtparroquia"]; $telefono=$_POST["txttelefono"]; $tlf_movil=$_POST["txttlf_movil"]; $cod_postal=$_POST["txtcod_postal"];
$correo=$_POST["txtcorreo"]; $aptdo_postal=$_POST["txtaptdo_postal"]; $talla_camisa=$_POST["txttalla_camisa"]; $talla_pantalon=$_POST["txttalla_pantalon"]; $talla_calzado=$_POST["txttalla_calzado"];
$edad=formato_numero($edad); if(is_numeric($edad)){$edad=$edad;}else{$edad=0;} $tiempo=formato_numero($tiempo); if(is_numeric($tiempo)){$tiempo=$tiempo;}else{$tiempo=0;}
$disponibilidad=formato_numero($disponibilidad); if(is_numeric($disponibilidad)){$disponibilidad=$disponibilidad;}else{$disponibilidad=0;}
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_info_elegibles.php?Gcedula=C".$cedula;  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($fecha_nacimiento)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE NACIMIENTO NO ES VALIDA');</script><? } }
 if($error==0){if($nombre==""){$error=1; ?> <script language="JavaScript">muestra('NOMBRE NO ES VALIDO');</script><? }}
 if($error==0){if($cedula==""){$error=1; ?> <script language="JavaScript">muestra('CEDULA NO ES VALIDA');</script><? }}
 if($error==0){
  $Ssql="SELECT * FROM pre091 where cod_estado='".$estado."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$estado=$registro["estado"];}
  $Ssql="SELECT * FROM PRE093 where cod_municipio='".$municipio."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$municipio=$registro["nombre_municipio"];}
  $Ssql="SELECT * FROM PRE096 where cod_parroquia='".$parroquia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$parroquia=$registro["nombre_parroquia"];}
  $sSQL="Select * from NOM053 WHERE cedula='$cedula'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA NO EXISTE EN INFORMACION DE ELEGIBLE');</script><? }
   else{$sfechan=formato_aaaammdd($fecha_nacimiento);
      $sSQL="SELECT ACTUALIZA_NOM053(2,'$cedula','$nombre','$nombre1','$nombre2','$apellido1','$apellido2','$nacionalidad','$sexo','$edo_civil','$sfechan',$edad,'$lugar_nacimiento','$direccion','$cod_postal','$telefono','$tlf_movil','$correo','$profesion',$tiempo,'$grado_inst','','$sfechan','$estado','$ciudad','$municipio','$parroquia','','$talla_camisa','$talla_pantalon','$talla_calzado',0,0,'$aptdo_postal',$disponibilidad,'',0,'','$usuario_sia','$minf_usuario','$codigo_mov')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>