<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); error_reporting(E_ALL); $equipo = getenv("COMPUTERNAME");  $error=0; $cod_modulo="13";
  $cod_clasificacion=$_POST["txtcod_clasificacion"];  $num_bien=$_POST["txtnum_bien"];  $cod_bien_mue=$cod_clasificacion."-".$num_bien;
  $denominacion=$_POST["txtdenominacion"]; $cod_dependencia=$_POST["txtcod_dependencia"];   $cod_empresa="00"; 
  $cod_direccion=$_POST["txtcod_direccion"]; $cod_departamento=$_POST["txtcod_departamento"]; 
  $codigo_tipo_incorp=$_POST["txcodigo_tipo_incorp"];   $fecha_incorporacion=$_POST["txtfecha_incorporacion"];  $valor_incorporacion=$_POST["txtvalor_incorporacion"];
  $sfecha=$fecha_incorporacion;
  if (checkData($fecha_incorporacion)=='1'){ $fecha_incorporacion=formato_aaaammdd($fecha_incorporacion); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA INCORPORACION NO ES VALIDA');</script><? }
  $valor_incorporacion=formato_numero($valor_incorporacion);if(is_numeric($valor_incorporacion)){$valor_incorporacion=$valor_incorporacion;} else{$valor_incorporacion=0;}
  
 echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $url="Act_fichas_bienes_muebles_pro.php?Gcod_bien_mue=".$cod_bien_mue;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $Nom_Emp=busca_conf();   $formato_bien=""; $long_num_bien=0; $periodo="01"; $campo502=""; $doc_caus_inm=""; $doc_caus_mue=""; $doc_caus_sem=""; $num_bien_unico="S";
   $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);   
   if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}
   $formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"];}
   if($error==0){ $sSQL="Select denomina_tipo from BIEN003 WHERE codigo='$codigo_tipo_incorp'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO TIPO DE INCORPORACION NO EXISTE');</script> <? }
   }
   if($error==0){
      $sqlb="Select * from BIEN055 where cod_bien_mue='$cod_bien_mue' "; $resb=pg_query($sqlb);$filasb=pg_num_rows($resb);
      if($filasb>=1){
	  }
   }	  
   if($error==0){  $inf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
	  $sSQL="Select cod_bien_mue from BIEN015 WHERE cod_bien_mue='$cod_bien_mue'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
	  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BIEN NO EXISTE'); </script> <? }
	   else{ $error=0; $status_bien_mue="";
	     $sSQL="SELECT ACTIVA_BIEN015('$cod_bien_mue','$fecha_incorporacion','$codigo_tipo_incorp',$valor_incorporacion,'$usuario_sia','$inf_usuario')";
	     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error,0,91);
		 if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><? $error=0; 
		    $sfecha=$fecha_incorporacion;
	        $desc_doc="ACTIVACION FICHA DE BIEN MUEBLE:  CODIGO BIEN:".$cod_bien_mue.", DENOMINACION:".$denominacion.", FECHA INCORPORACION:".$fecha_incorporacion.", VALOR INCORPORACION:".$valor_incorporacion.", CODIGO TIPO INCORPORACION:".$codigo_tipo_incorp;
            $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('13','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
            $error=pg_errormessage($conn);   $error=substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }    
	  } }
}
pg_close(); 
if ($error==0){?><script language="JavaScript">document.location ='<?echo $url;?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }
?>