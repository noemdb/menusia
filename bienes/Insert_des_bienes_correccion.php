<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc"); $cod_modulo="13"; $error=0;
$equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();
$cod_bien_mue=$_POST["txtcod_bien_mue"]; $desincorporado=$_POST["txtdesincorporado"];  $desincorporado=substr($desincorporado,0,1);
$fecha_desincorporado=$_POST["txtfecha_desincorporado"];   $des_desincorporado=$_POST["txtdes_desincorporado"]; 
$inf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); $fecha_desin=$fecha_desincorporado; $sfecha=$fecha_desincorporado;
echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $url="Act_desin_bienes_muebles_correccion.php?Gcod_bien_mue=".$cod_bien_mue;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?} 
 else{ $Nom_Emp=busca_conf();
    $sql="Select campo502,campo503 from SIA005 where campo501='13'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} }
    if (checkData($fecha_desincorporado)=='1'){ $fecha_desincorporado=formato_aaaammdd($fecha_desincorporado); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA DESINCORPORACION NO ES VALIDA');</script><? }
    
	
   /* validar fecha
	if($error==0){$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); $sfecha=$fecha_desincorporado;
		if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DESINCORPORACION INVALIDA');</script><?}
	}
	if($error==0){$nmes=substr($fecha_desin,3, 2);
		if ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DESINCORPORACION MENOR A ULTIMO PERIODO CERRADO');</script><?}
	}
	*/
	
	if($error==0){
	  $sSQL="Select cod_bien_mue,desincorporado,denominacion,fecha_incorporacion from BIEN015 WHERE cod_bien_mue='$cod_bien_mue'";  $res=pg_exec($conn,$sSQL);  $filas=pg_numrows($res); 
	  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BIEN NO EXISTE'); </script> <? }
	   else { $registro=pg_fetch_array($res,0); $mdes=$registro["desincorporado"]; $denominacion=$registro["denominacion"];  $fecha_incorporacion=$registro["fecha_incorporacion"];
	     if($mdes=="S"){ $error=1; ?> <script language="JavaScript"> muestra('ERROR, CODIGO BIEN YA ESTA DESINCORPORADO');</script><?}
	   }
	}
	if($error==0){ $sSQL="Select cod_bien_mue from BIEN055 WHERE cod_bien_mue='$cod_bien_mue' and fecha_desincorporado='$fecha_desincorporado' and fecha_incorporacion='$fecha_incorporacion' ";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
	  if ($filas>0){ $error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BIEN YA REGISTRADO COMO DESINCORPORADO'); </script> <? }
	}
	if($error==0){ $sSQL="SELECT REGISTRA_BIEN055('$cod_bien_mue','$desincorporado','$fecha_desincorporado','$des_desincorporado','$usuario_sia','$inf_usuario')"; 
	  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
	  if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
	    else{?><script language="JavaScript">muestra('REGISTRO DESINCORPORACION EXITOSAMENTE');</script><? $error=0; 
	  
	     $sfecha=$fecha_desincorporado;
	     $desc_doc="DESINCORPORACION POR CORRECCION BIEN MUEBLE,  CODIGO BIEN:".$cod_bien_mue.", DENOMINACION:".$denominacion.", FECHA DESINCORPORACION:".$fecha_desin;
         $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('13','$usuario_sia','$usuario_sia','$equipo','Registro','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);   $error=substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }
	}
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<?echo $url;?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }

?>