<?include ("../class/conect.php");  include ("../class/funciones.php"); header ('Content-type: text/html; charset=utf-8');
$ced_rif=$_POST["txtced_rif"];$nombre=$_POST["txtnombre"];  $nombre=$_POST["txtnombre"]; $cedula=$_POST["txtcedula"]; $rif=$_POST["txtrif"]; $nit=$_POST["txtnit"]; $direccion=$_POST["txtdireccion"]; $tipo_benef=$_POST["txttipo_benef"];
$ced_rif_aut=$_POST["txtced_rif_aut"]; $nombre_autorizado=$_POST["txtnomb_auto"];  $ciudad=$_POST["txtciudad"]; $municipio=$_POST["txtmunicipio"];$region=$_POST["txtregion"];  $estado=$_POST["txtestado"]; $pais=$_POST["txtpais"];$telefono=$_POST["txttelefono"];
$fax=$_POST["txtfax"]; $tlf_movil=$_POST["txttlf_movil"];  $pasaporte=$_POST["txtpasaporte"];$nacionalidad=$_POST["txtnacionalidad"];$residente=$_POST["txtresidente"];$clasificacion=$_POST["txtclasificacion"]; $rep_legal=$_POST["txtrep_legal"]; $cod_postal=$_POST["txtcod_postal"];
$aptd_postal=$_POST["txtaptd_postal"]; $tipo_orden=$_POST["txttipo_orden"]; $observaciones="";$status="";if($pais==""){$pais="VENEZUELA";} $campo_str1=$_POST["txtgrupo_banco"]; $campo_str2=$_POST["txtnro_cuenta"];
$nombre=str_replace("\r\n","",$nombre); $nombre=str_replace("\n","",$nombre);$nombre=str_replace('"','',$nombre); $nombre=str_replace("'","",$nombre); if($ced_rif_aut==""){$ced_rif_aut=$ced_rif;}if($nombre_autorizado==""){$nombre_autorizado=$nombre;}
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a"); $fecha=asigna_fecha_hoy();  echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from PRE099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA/RIF DE BENEFICIARIO NO EXISTE'); </script> <? }
   else{ $registro=pg_fetch_array($resultado,0); $nom_ant=$registro["nombre"]; $error=1;   $Ssql="SELECT * FROM pre091 where cod_estado='".$estado."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$estado=$registro["estado"];}
     if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
     $sSQL="SELECT ACTUALIZA_PRE099(2,'$ced_rif','$nombre','$cedula','$rif','$nit','$direccion','$tipo_benef','$ced_rif_aut','$nombre_autorizado','$ciudad','$municipio','$region','$estado','$pais','$telefono','$fax','$tlf_movil','$pasaporte','$nacionalidad','$residente','$observaciones','$clasificacion','$rep_legal','$cod_postal','$aptd_postal','$sfecha','$tipo_orden','$status','','','$campo_str1','$campo_str2',0,0,'$minf_usuario')";  //echo $sSQL,"<br>";
     $resultado=pg_exec($conn,$sSQL);$merror=pg_errormessage($conn);$merror=substr($merror, 0, 91);  if (!$resultado){$error=1; ?> <script language="JavaScript"> muestra('<? echo $merror; ?>'); </script> <? }
      else{?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><? $error=0;  $desc_doc="CEDULA/RIF:".$ced_rif.",  NOMBRE BENEFICIARIO:".$nom_ant;  $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
        $merror=pg_errormessage($conn); $merror=substr($merror, 0, 91);  if (!$resultado){$error=1; ?> <script language="JavaScript">  muestra('<? echo $merror; ?>'); </script> <?}}
      }
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='Mod_beneficiario.php?Gced_rif=<?echo $ced_rif?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>