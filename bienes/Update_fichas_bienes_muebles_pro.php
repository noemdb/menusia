<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); error_reporting(E_ALL); $equipo = getenv("COMPUTERNAME");  $error=0; $cod_modulo="13";
  $cod_clasificacion=$_POST["txtcod_clasificacion"];  $num_bien=$_POST["txtnum_bien"];  $cod_bien_mue=$cod_clasificacion."-".$num_bien; //$cod_bien_mue=$cod_clasificacion.$num_bien;
  $denominacion=$_POST["txtdenominacion"]; $cod_dependencia=$_POST["txtcod_dependencia"];   $cod_empresa=$_POST["txtcod_empresa"];
  $cod_direccion=$_POST["txtcod_direccion"]; $cod_departamento=$_POST["txtcod_departamento"]; 
  $ced_responsable=$_POST["txtced_responsable"];  $ced_responsable_uso=$_POST["txtced_responsable_uso"]; 
  $cod_metodo_rot=$_POST["txtcod_metodo_rot"];  $ced_rotulador=$_POST["txtced_rotulador"];  
  $fecha_rotulacion=$_POST["txtfecha_rotulacion"];  $fecha_actualizacion=$_POST["txtfecha_actualizacion"]; 
  $direccion=$_POST["txtdireccion"];   $cod_region=$_POST["txtcod_region"];  $cod_entidad=$_POST["txtcod_entidad"];
  $cod_municipio=$_POST["txtcod_municipio"];   $cod_ciudad=$_POST["txtcod_ciudad"];  $cod_parroquia=$_POST["txtcod_parroquia"];   $cod_postal=$_POST["txtcod_postal"];    
  $caracteristicas=$_POST["textcaracteristicas"];  $marca=$_POST["txtmarca"];  $modelo=$_POST["txtmodelo"];
  $color=$_POST["txtcolor"];  $matricula=$_POST["txtmatricula"];  $serial1=$_POST["txtserial1"];  $serial2=$_POST["txtserial2"];  
  $tipo_clase=$_POST["txttipo_clase"];  $uso=$_POST["txtuso"];  $dimension_tam=$_POST["txtdimension_tam"];   $material=$_POST["txtmaterial"]; 
  $codigo_alterno=$_POST["txtcodigo_alterno"];   $ano=$_POST["txtano"];   $antiguedad=$_POST["txtantiguedad"];  $accesorios=$_POST["txtaccesorios"];  
  $cod_contablea=$_POST["txtcod_contablea"];   $cod_contabled=$_POST["txtcod_contabled"];  $tipo_depreciacion=$_POST["txttipo_depreciacion"];   
  $tasa_deprec=$_POST["txttasa_deprec"];  $vida_util=$_POST["txtvida_util"];  $valor_residual=$_POST["txtvalor_residual"]; 
  $cod_presup_dep=$_POST["txtcod_presup_dep"];  $monto_depreciado=$_POST["txtmonto_depreciado"];  $desincorporado=$_POST["txtdesincorporado"];  
  $sit_contable=$_POST["txtsit_contable"];  $sit_legal=$_POST["txtsit_legal"]; $edo_conservacion=$_POST["txtedo_conservacion"];
  $ced_verificador=$_POST["txtced_res_verificador"];   $fecha_verificacion=$_POST["txtfecha_verificacion"];    
  $codigo_tipo_incorp=$_POST["txcodigo_tipo_incorp"];   $tipo_incorporacion=$_POST["txttipo_incorporacion"]; $cod_imp_presup=$_POST["txtcod_presup"];  $nom_imp_presup=$_POST["txtdenomina_presup"];  
  $des_imp_nopresup=$_POST["txtdes_imp_nopresup"];   $fecha_incorporacion=$_POST["txtfecha_incorporacion"];  $valor_incorporacion=$_POST["txtvalor_incorporacion"];  $garantia=$_POST["txtgarantia"];
  $nro_oc=$_POST["txtnro_oc"];   $fecha_oc=$_POST["txtfecha_oc"];   $nro_op=$_POST["txtnro_op"];   $fecha_op=$_POST["txtfecha_op"]; 
  $tipo_doc_cancela=$_POST["txttipo_doc_cancela"];  $nro_doc_cancela=$_POST["txtnro_doc_cancela"];   $fecha_doc_cancela=$_POST["txtfecha_doc_cancela"];
  $ced_rif_proveedor=$_POST["txtced_rif_proveedor"];  $nom_proveedor=$_POST["txtnombre_proveedor"];   $nro_factura=$_POST["txtnro_factura"];   $fecha_factura=$_POST["txtfecha_factura"];  
  $tasa_impuesto=$_POST["txttasa_impuesto"]; $valor_impuesto=$_POST["txtvalor_impuesto"]; $tasa_prorrata=$_POST["txttasa_prorrata"]; $valor_prorrata=$_POST["txtvalor_prorrata"];
  $bien_en_salida="N";   $status_bien_inm="";   $inf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
  $fecha_desincorporado=$fecha_incorporacion;  $des_desincorporado="";  $desincorporado=substr($desincorporado,0,1);  
  $nom_imp_presup=substr($nom_imp_presup,0,199);  $des_imp_nopresup=substr($des_imp_nopresup,0,200);   $sfecha=$fecha_incorporacion;
  if (checkData($fecha_rotulacion)=='1'){ $fecha_rotulacion=formato_aaaammdd($fecha_rotulacion); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA ROTULACION NO ES VALIDA');</script><? }
  if (checkData($fecha_actualizacion)=='1'){ $fecha_actualizacion=formato_aaaammdd($fecha_actualizacion); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA ACTUALIZACION NO ES VALIDA');</script><? }
  if (checkData($fecha_verificacion)=='1'){ $fecha_verificacion=formato_aaaammdd($fecha_verificacion); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA VERIFICACION NO ES VALIDA');</script><? }
  if (checkData($fecha_incorporacion)=='1'){ $fecha_incorporacion=formato_aaaammdd($fecha_incorporacion); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA INCORPORACION NO ES VALIDA');</script><? }
  if (checkData($fecha_oc)=='1'){ $fecha_oc=formato_aaaammdd($fecha_oc); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA ORDEN DE COMPRA NO ES VALIDA');</script><? }
  if (checkData($fecha_op)=='1'){ $fecha_op=formato_aaaammdd($fecha_op); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA ORDEN DE PAGO NO ES VALIDA');</script><? }
  if (checkData($fecha_doc_cancela)=='1'){ $fecha_doc_cancela=formato_aaaammdd($fecha_doc_cancela); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA DOCUMENTO QUE CANCELA NO ES VALIDA');</script><? }
  if (checkData($fecha_factura)=='1'){ $fecha_factura=formato_aaaammdd($fecha_factura); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA FACTURA NO ES VALIDA');</script><? }
  if (checkData($fecha_desincorporado)=='1'){ $fecha_desincorporado=formato_aaaammdd($fecha_desincorporado); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA DESINCORPORACION NO ES VALIDA');</script><? }
  if($desincorporado=="S"){ $error=1; ?> <script language="JavaScript"> muestra('BIEN ESTA DESINCORPORADO');</script><?}  
  $antiguedad=formato_numero($antiguedad);if(is_numeric($antiguedad)){$antiguedad=$antiguedad;} else{$antiguedad=0;}
  $tasa_deprec=formato_numero($tasa_deprec);if(is_numeric($tasa_deprec)){$tasa_deprec=$tasa_deprec;} else{$tasa_deprec=0;}
  $vida_util=formato_numero($vida_util);if(is_numeric($vida_util)){$vida_util=$vida_util;} else{$vida_util=0;}
  $valor_residual=formato_numero($valor_residual);if(is_numeric($valor_residual)){$valor_residual=$valor_residual;} else{$valor_residual=0;}
  $valor_incorporacion=formato_numero($valor_incorporacion);if(is_numeric($valor_incorporacion)){$valor_incorporacion=$valor_incorporacion;} else{$valor_incorporacion=0;}
  if(is_numeric($garantia)){$garantia=parte_entera_num($garantia);} else{$garantia=0;}
  $monto_depreciado=formato_numero($monto_depreciado);if(is_numeric($monto_depreciado)){$monto_depreciado=$monto_depreciado;} else{$monto_depreciado=0;}   
  $tasa_impuesto=formato_numero($tasa_impuesto);if(is_numeric($tasa_impuesto)){$tasa_impuesto=$tasa_impuesto;} else{$tasa_impuesto=0;}
  $valor_impuesto=formato_numero($valor_impuesto);if(is_numeric($valor_impuesto)){$valor_impuesto=$valor_impuesto;} else{$valor_impuesto=0;}
  $tasa_prorrata=formato_numero($tasa_prorrata);if(is_numeric($tasa_prorrata)){$tasa_prorrata=$tasa_prorrata;} else{$tasa_prorrata=0;}
  $valor_prorrata=formato_numero($valor_prorrata);if(is_numeric($valor_prorrata)){$valor_prorrata=$valor_prorrata;} else{$valor_prorrata=0;}
  $valor_depreciar=$valor_incorporacion+$valor_impuesto-$valor_prorrata;
 
echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $url="Act_fichas_bienes_muebles_pro.php?Gcod_bien_mue=".$cod_bien_mue;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $Nom_Emp=busca_conf();   $formato_bien=""; $long_num_bien=0; $periodo="01"; $campo502=""; $doc_caus_inm=""; $doc_caus_mue=""; $doc_caus_sem=""; $num_bien_unico="S";
   $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);   
   if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}
   $formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"];}
   $num_bien_unico=substr($campo502,3,1);  $grupo_c="2";
   $sSQL="Select codigo_c from BIEN008 WHERE grupo_c='$grupo_c' and codigo_c='$cod_clasificacion'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
   if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CLASIFICACION NO EXISTE');</script> <? }     
   if($error==0){$sql="SELECT cod_dependencia,denominacion_dep  FROM bien001 where cod_dependencia='$cod_dependencia'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; echo $cod_dependen."dep"; ?> <script language="JavaScript"> muestra('CODIGO DEPENDENCIA NO EXISTE');</script><? }
   }
   if($error==0){$sql="SELECT cod_direccion,denominacion_dir FROM bien005 where cod_dependencia='$cod_dependencia' and cod_direccion='$cod_direccion'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; echo $cod_direcci; ?> <script language="JavaScript"> muestra('CODIGO DIRECCION NO EXISTE');</script><? }
   }
   if($error==0){$sSQL="Select denominacion_dep from BIEN006 WHERE cod_dependencia='$cod_dependencia' and cod_direccion='$cod_direccion' and cod_departamento='$cod_departamento'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; echo $cod_direcci; ?> <script language="JavaScript"> muestra('CODIGO DEPARTAMENTO NO EXISTE');</script><? }
   }
   if($error==0){ $sSQL="Select * from BIEN007 WHERE cod_empresa='$cod_empresa'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; echo $cod_empresa; ?> <script language="JavaScript"> muestra('CODIGO DE LA EMPRESA NO EXISTE');</script> <? }
   } 
   if($error==0){$sSQL="Select ced_responsable from BIEN002 WHERE ced_responsable='$ced_responsable'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA DEL RESPONSABLE PRIMARIO NO EXISTE');</script> <? }
   }
   if($error==0){$sSQL="Select ced_res_uso from BIEN031 WHERE ced_res_uso='$ced_responsable_uso'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA DEL RESPONSABLE DE USO NO EXISTE');</script> <? }
   }
   if($error==0){ $sSQL="Select * from BIEN012 WHERE codigo='$cod_metodo_rot'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO METODO ROTULACION NO EXISTE');</script> <? }
   }
   if($error==0){ $sSQL="Select * from BIEN032 WHERE ced_res_rotu='$ced_rotulador'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA DE RESPONSABLE ROTULADOR NO EXISTE');</script> <? }
   }
   if($error==0){ $sSQL="Select * from PRE092 WHERE cod_region='$cod_region'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE REGION NO EXISTE');</script> <? }
   }
   if($error==0){ $sSQL="Select * from PRE091 WHERE cod_estado='$cod_entidad'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE ENTIDAD NO EXISTE');</script> <? }
   }
   if($error==0){ $sSQL="Select * from PRE093 WHERE cod_municipio='$cod_municipio'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE MUNICIPIO NO EXISTE');</script> <? }
   }
   if($error==0){  $sSQL="Select * from PRE094 WHERE cod_ciudad='$cod_ciudad'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CIUDAD NO EXISTE');</script> <? }
   }
   if($error==0){$sSQL="Select * from PRE096 WHERE cod_parroquia='$cod_parroquia'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE PARROQUIA NO EXISTE');</script> <? }
   }
   if($error==0){ $sSQL="Select denomina_tipo from BIEN003 WHERE codigo='$codigo_tipo_incorp'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO TIPO DE INCORPORACION NO EXISTE');</script> <? }
   }
   if($error==0){ $sSQL="Select ced_res_verificador from BIEN030 WHERE ced_res_verificador='$ced_verificador'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA DEL RESPONSABLE VERIFICADOR NO EXISTE');</script> <? }
   }
   if($error==0){ $sSQL="Select * from BIEN010 WHERE codigo='$sit_contable'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO SITUACION CONTABLE DEL BIEN NO EXISTE');</script> <? }
   }
   if($error==0){ $sSQL="Select * from BIEN009 WHERE codigo='$sit_legal'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO SITUACION LEGAL DEL BIEN NO EXISTE');</script> <? }
   }
   if($error==0){ $sSQL="Select * from BIEN004 WHERE codigo='$edo_conservacion'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO ESTADO DE CONSERVACION DEL BIEN NO EXISTE');</script> <? }
   }     
   if($error==0){
	  $sSQL="Select cod_bien_mue from BIEN015 WHERE cod_bien_mue='$cod_bien_mue'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado); echo $sSQL;
	  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BIEN NO EXISTE'); </script> <? }
	   else{ $error=0; $status_bien_mue="";  $sSQL="SELECT ACTUALIZA_BIEN015(2,'$cod_bien_mue','$cod_clasificacion','$num_bien','$denominacion','$cod_dependencia','$cod_empresa','$cod_direccion','$cod_departamento','$ced_responsable','$fecha_actualizacion','$ced_responsable_uso','$cod_metodo_rot','$ced_rotulador','$fecha_rotulacion','$direccion','$cod_region','$cod_entidad','$cod_municipio','$cod_ciudad','$cod_parroquia','$cod_postal','$caracteristicas','$marca','$modelo','$color','$matricula','$serial1','$serial2','$tipo_clase','$uso','$dimension_tam','$material','$codigo_alterno','$ano',$antiguedad,'$cod_contablea','$cod_contabled','$tipo_depreciacion',$tasa_deprec,$vida_util,$valor_residual,'$sit_contable','$sit_legal','$edo_conservacion','$ced_verificador','$fecha_verificacion','$tipo_incorporacion','$cod_imp_presup','$nom_imp_presup','$des_imp_nopresup','$fecha_incorporacion',$valor_incorporacion,$garantia,'$nro_oc','$fecha_oc','$nro_op','$fecha_op','$tipo_doc_cancela','$nro_doc_cancela','$fecha_doc_cancela','$ced_rif_proveedor','$codigo_tipo_incorp','$nom_proveedor','$cod_presup_dep',$monto_depreciado, '$nro_factura', '$fecha_factura', '$desincorporado','$accesorios','$fecha_desincorporado','$des_desincorporado','$bien_en_salida','$status_bien_mue','$usuario_sia','$inf_usuario',$tasa_impuesto,$valor_impuesto,$tasa_prorrata,$valor_prorrata,$valor_depreciar)"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn);  $merror=substr($error, 0, 91);
		 if (!$resultado){$error=1; ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><? $error=0; 	$sfecha=$fecha_incorporacion;
	        $desc_doc="FICHA DE BIEN MUEBLE:  CODIGO BIEN:".$cod_bien_mue.", DENOMINACION:".$denominacion.", FECHA INCORPORACION:".$fecha_incorporacion.", VALOR INCORPORACION:".$valor_incorporacion.", CODIGO TIPO INCORPORACION:".$codigo_tipo_incorp;  $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('13','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");  $merror=pg_errormessage($conn);   $error=substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<?echo $merror;?>');</script><? }}
     } }
}
pg_close(); 
if ($error==0){?><script language="JavaScript">document.location ='<?echo $url;?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }
?>
