<?include ("../class/conect.php");  include ("../class/funciones.php");
  $cod_bien_sem=$_POST["txtcod_bien_sem"];
  $cod_clasificacion=$_POST["txtcod_clasificacion"];
  $num_bien=$_POST["txtnum_bien"];
  $denominacion=$_POST["txtdenominacion"]; 
  $cod_empresa=$_POST["txtcod_empresa"];
  $cod_direccion=$_POST["txtcod_direccion"];
  $cod_departamento=$_POST["txtcod_departamento"]; 
  $cod_dependencia=$_POST["txtcod_dependencia"]; 
  $ced_responsable=$_POST["txtced_responsable"];
  $fecha_actualizacion=$_POST["txtfecha_actualizacion"]; 
  $ced_responsable_uso=$_POST["txtced_res_uso"];
  $cod_metodo_rot=$_POST["txtcodigo_rotula"];
  $ced_rotulador=$_POST["txtced_res_rotu"];
  $fecha_rotulacion=$_POST["txtfecha_rotulacion"];
  $direccion=$_POST["txtdireccion"]; 
  $cod_region=$_POST["txtcod_region"]; 
  $cod_entidad=$_POST["txtcod_entidad"];
  $cod_municipio=$_POST["txtcod_municipio"]; 
  $cod_ciudad=$_POST["txtcod_ciudad"]; 
  $cod_parroquia=$_POST["txtcod_parroquia"]; 
  $cod_postal=$_POST["txtcod_postal"];
  $caracteristicas=$_POST["txtcaracteristicas"];
  $raza=$_POST["txtraza"];
  $color=$_POST["txtcolor"];
  $sexo=$_POST["txtsexo"];
  $fecha_nacimiento=$_POST["txtfecha_nacimiento"];
  $edad=$_POST["txtedad"];
  $tam_peso=$_POST["txttam_peso"];
  $uso=$_POST["txtuso"];
  $cod_contablea=$_POST["txtcod_contablea"]; 
  $cod_contabled=$_POST["txtcod_contabled"];
  $tipo_depreciacion=$_POST["txttipo_depreciacion"]; 
  $tasa_deprec=$_POST["txttasa_deprec"];
  $vida_util=$_POST["txtvida_util"];
  $valor_residual=$_POST["txtvalor_residual"]; 
  $cod_presup_dep=$_POST["txtcod_presup_dep"]; 
  $monto_depreciado=$_POST["txtmonto_depreciado"]; 
  $desincorporado=$_POST["txtdesincorporado"]; 
  $fecha_desincorporado=$_POST["txtfecha_desincorporado"];
  $sit_contable=$_POST["txtcodigo_situacont"]; 
  $sit_legal=$_POST["txtcodigo_situalegal"];
  $ced_verificador=$_POST["txtced_res_verificador"];  
  $fecha_verificacion=$_POST["txtfecha_verificacion"];
  $codigo_tipo_incorp=$_POST["txttipo_incorporacion"];  
  $tipo_incorporacion=$_POST["txttipo_incorporacion"];
  $cod_imp_presup=$_POST["txtcod_imp_presup"];
  $nom_imp_presup=$_POST["txtnom_imp_presup"];
  $des_imp_nopresup=$_POST["txtdes_imp_nopresup"];
  $valor_incorporacion=$_POST["txtvalor_incorporacion"];
  $fecha_incorporacion=$_POST["txtfecha_incorporacion"]; 
  $nro_oc=$_POST["txtnro_oc"]; 
  $fecha_oc=$_POST["txtfecha_oc"]; 
  $nro_op=$_POST["txtnro_op"]; 
  $fecha_op=$_POST["txtfecha_op"]; 
  $tipo_doc_cancela=$_POST["txttipo_doc_cancela"];
  $nro_doc_cancela=$_POST["txtnro_doc_cancela"]; 
  $fecha_doc_cancela=$_POST["txtfecha_doc_cancela"];  
  $nro_factura=$_POST["txtnro_factura"]; 
  $fecha_factura=$_POST["txtfecha_factura"];
  $ced_rif_proveedor=$_POST["txtced_rif_proveedor"];
  $nom_proveedor=$_POST["txtnombre_proveedor"]; 
$url="Act_fichas_semovientes_pro.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN016 WHERE cod_bien_sem='$cod_bien_sem'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL SEMOVIENTE NO EXISTE');</script> <? }
   else{$error=1;$resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN016(2,
'$cod_bien_sem','$cod_clasificacion','$num_bien','$denominacion', '$cod_empresa','$cod_direccion', '$cod_departamento', '$cod_dependencia', '$ced_responsable','$fecha_actualizacion', '$ced_responsable_uso','$cod_metodo_rot','$ced_rotulador','$fecha_rotulacion','$direccion', '$cod_region', '$cod_entidad','$cod_municipio', '$cod_ciudad', '$cod_parroquia', '$cod_postal','$caracteristicas','$raza','$color','$sexo','$fecha_nacimiento','$edad','$tam_peso','$uso','$cod_contablea', '$cod_contabled','$tipo_depreciacion', '$tasa_deprec','$vida_util','$valor_residual', '$cod_presup_dep', '$monto_depreciado', '$desincorporado', '$fecha_desincorporado','$sit_contable', '$sit_legal','$ced_verificador',  '$fecha_verificacion','$codigo_tipo_incorp',  '$tipo_incorporacion','$cod_imp_presup','$nom_imp_presup','$des_imp_nopresup','$valor_incorporacion','$fecha_incorporacion', '$nro_oc', '$fecha_oc', '$nro_op', '$fecha_op', '$tipo_doc_cancela','$nro_doc_cancela', '$fecha_doc_cancela',  
'$nro_factura', '$fecha_factura','$ced_rif_proveedor','$nom_proveedor')"); $error=pg_errormessage($conn);  $error=substr($error,0,91);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
