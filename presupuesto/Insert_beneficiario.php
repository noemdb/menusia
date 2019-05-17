<?include ("../class/conect.php");  include ("../class/funciones.php"); header ('Content-type: text/html; charset=utf-8');
$ced_rif=$_POST["txtced_rif"];$nombre=$_POST["txtnombre"]; $nombre=$_POST["txtnombre"]; $cedula=$_POST["txtcedula"]; $rif=$_POST["txtrif"]; $nit=$_POST["txtnit"];$direccion=$_POST["txtdireccion"]; $tipo_benef=$_POST["txttipo_benef"];
$ced_rif_aut=$_POST["txtced_rif_aut"];$nombre_autorizado=$_POST["txtnomb_auto"];$ciudad=$_POST["txtciudad"];$municipio=$_POST["txtmunicipio"];$region=$_POST["txtregion"]; $estado=$_POST["txtestado"];$pais=$_POST["txtpais"]; $telefono=$_POST["txttelefono"];
$fax=$_POST["txtfax"]; $tlf_movil=$_POST["txttlf_movil"];$pasaporte=$_POST["txtpasaporte"];$nacionalidad=$_POST["txtnacionalidad"];$residente=$_POST["txtresidente"]; $clasificacion=$_POST["txtclasificacion"]; $rep_legal=$_POST["txtrep_legal"]; $cod_postal=$_POST["txtcod_postal"];
$aptd_postal=$_POST["txtaptd_postal"]; $tipo_orden=$_POST["txttipo_orden"]; $observaciones=""; $status=""; if($pais==""){$pais="VENEZUELA";} $campo_str1=$_POST["txtgrupo_banco"]; $campo_str2=$_POST["txtnro_cuenta"];
$nombre=cambiar_car_especiales($nombre);if($ced_rif_aut==""){$ced_rif_aut=$ced_rif;} if($nombre_autorizado==""){$nombre_autorizado=$nombre;}
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); $fecha=asigna_fecha_hoy(); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0;  $url="Act_beneficiarios.php?Gced_rif=C".$ced_rif;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from PRE099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA/RIF DE BENEFICIARIO YA EXISTE'); </script> <? }
   else{$error=1; if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
     $Ssql="SELECT * FROM pre091 where cod_estado='".$estado."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$estado=$registro["estado"];}
     $sSQL="SELECT ACTUALIZA_PRE099(1,'$ced_rif','$nombre','$cedula','$rif','$nit','$direccion','$tipo_benef','$ced_rif_aut','$nombre_autorizado','$ciudad','$municipio','$region','$estado','$pais','$telefono','$fax','$tlf_movil','$pasaporte','$nacionalidad','$residente','$observaciones','$clasificacion','$rep_legal','$cod_postal','$aptd_postal','$sfecha','$tipo_orden','$status','','','$campo_str1','$campo_str2',0,0,'$minf_usuario')";
     $resultado=pg_exec($conn,$sSQL);  $merror=pg_errormessage($conn);$merror=substr($merror,0,91); if (!$resultado){ $error=1;?> <script language="JavaScript"> muestra('<? echo $merror; ?>'); </script> <? }  else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>