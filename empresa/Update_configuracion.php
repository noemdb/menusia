<?php include ("../class/conect.php");include ("../class/funciones.php");
$nomb_abrev=$_POST["txtnomb_abrev"]; $nombre_Comp=$_POST["txtnombre_Comp"];  $direccion=$_POST["txtdireccion"]; $ciudad=$_POST["txtciudad"];$municipio=$_POST["txtmunicipio"];$region=$_POST["txtregion"];$estado=$_POST["txtestado"]; $parroquia=$_POST["txtparroquia"]; $tam_logo=$_POST["txttam_logo"];
$rif=$_POST["txtrif"];  $nit=$_POST["txtnit"]; $telefono=$_POST["txttelefono"];  $fax=$_POST["txtfax"];$fecha_ini=$_POST["txtfecha_ini"]; $fecha_fin=$_POST["txtfecha_fin"]; $periodo=$_POST["txtperiodo"]; $correo=$_POST["txtmail"];$pagina=$_POST["txtweb"]; $str1=$_POST["txtstr1"]; $str2=$_POST["txtstr2"];
$monto_ut=$_POST["txtmonto_ut"]; $tasa_iva=$_POST["txttasa_iva"]; $codigo=$_POST["txtcod_emp"]; $fecha_ini=formato_aaaammdd($fecha_ini); $fecha_fin=formato_aaaammdd($fecha_fin);
$monto=formato_numero($tasa_iva); if(is_numeric($monto)){$tasa_iva=$monto;} else{$tasa_iva=0;} $monto=formato_numero($monto_ut); if(is_numeric($monto)){$monto_ut=$monto;} else{$monto_ut=0;}   $monto=formato_numero($tam_logo); if(is_numeric($monto)){$tam_logo=$monto;} else{$tam_logo=0;}
$url="Act_Configuracion.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0; $SIA_Cierre="N";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?php }
 else{ $Ssql="SELECT * FROM pre091 where cod_estado='".$estado."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$estado=$registro["estado"];}
  $sSQL="Select * from SIA000 order by campo001";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CONFIGURACION DE EMPRESA NO EXISTE');</script> <?php }
   else{$error=0;  $registro=pg_fetch_array($resultado,0); $SIA_Integrado=$registro["campo036"];$SIA_Cierre=substr($SIA_Integrado,17,1);}
  if($SIA_Cierre=="S"){ $error=1; ?><script language="JavaScript">muestra('EJERCICIO YA CERRADO NO PUEDE MODIFICAR');</script><?php }
  if($error==0){
   $resultado=pg_exec($conn,"SELECT MODIFICA_SIA000('$codigo','$nombre_Comp','$direccion','$rif','$nit','$ciudad','$estado','$municipio','$telefono','$fax','$correo','$pagina','$fecha_ini','$fecha_fin','$periodo','$parroquia','$region','','','','','','$fecha_ini','$fecha_fin','$str1','$str2','','$fecha_ini','$fecha_ini','$fecha_ini',$monto_ut,$tasa_iva,$tam_logo,0,0,'','','','','','')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<?php echo $error; ?>'); </script> <?php } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><?php $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?php echo $url;?>'); </script>
