<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); error_reporting(E_ALL);$cod_modulo="13";
$referencia=$_GET["Greferencia_dep"];$fecha=$_GET["Gfecha_dep"];  $statusc="D"; $ced_rif="";
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); $descripcion="";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $Nom_Emp=busca_conf(); $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);   
  if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}
    $formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"]; $cod_fuente=$registro["campo512"]; $doc_comp=$registro["campo513"]; $ref_comp=$registro["campo514"];}

  $tipo_causado=$doc_caus_mue; $unidad_sol=""; $ref_compromiso="N"; $tipo_compromiso="0000"; $referencia_comp=""; 
  $sSQL="Select * from bien028 WHERE referencia_dep='$referencia'";
  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE DEPRECIACION NO EXISTE');</script><?}
   else{  $registro=pg_fetch_array($resultado);  $gen_comp=$registro["gen_comp"]; $afecta_presup=$registro["afecta_presup"];
       $descripcion=$registro["descripcion"]; $sfecha=$registro["fecha_dep"]; $status=$registro["status"]; 
	  $met_calculo=$registro["met_calculo"];
	}
  if($afecta_presup=="S"){
    $sql="Select * from pre007 where tipo_causado='$tipo_causado' and referencia_caus='$referencia'" ; $res=pg_query($sql);   $filas=pg_num_rows($res);

    if($filas>0){  $registro=pg_fetch_array($res); $referencia_caus=$registro["referencia_caus"];   $tipo_causado=$registro["tipo_causado"];   $referencia_comp=$registro["referencia_comp"];
      $tipo_compromiso=$registro["tipo_compromiso"]; $ced_rif=$registro["ced_rif"];
	}
  }
  if ($error==0){ 
     $sql="Select * from bien047 WHERE referencia_dep='$referencia' and fecha_dep='$sfecha'";   $res=pg_query($sql);   $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){
       $total=$total+$registro["monto_dep"]; $desc_cod=$desc_cod.", CODIGO BIEN:".$registro["cod_bien_mue"]."  MONTO:".$registro["monto_dep"];
     }
     $sql="SELECT ACTUALIZA_BIEN028(3,'','$referencia','$sfecha','$met_calculo','$gen_comp','N','N','$sfecha','$afecta_presup','$tipo_causado','','$ced_rif','$statusc','$unidad_sol','$referencia_comp','$tipo_compromiso','')";
     $resultado=pg_exec($conn,$sql);  $error=pg_errormessage($conn);  $error=substr($error,0,91); echo $sql;
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0; 
	    $desc_doc="DEPRECIACION DE BIENES MUEBLES REEFRENCIA:".$referencia.", FECHA:".$fecha.", DESCRIPCION:".$descripcion.", TOTAL:".$total; $desc_doc=$desc_doc.$desc_cod;
  	    $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('13','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn);   $error=substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }
	 }
  }
}
pg_close(); 
if ($error==0){?><script language="JavaScript"> window.close();window.opener.location.reload(); </script> <? }
?>
