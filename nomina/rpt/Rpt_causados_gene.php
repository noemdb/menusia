<?include ("../../class/conect.php");  include ("../../class/funciones.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); include ("../../class/phpreports/PHPReportMaker.php");
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];$doc_causa_d=$_GET["doc_causa_d"];$doc_causa_h=$_GET["doc_causa_h"];$doc_comp_d=$_GET["doc_comp_d"]; $doc_comp_h=$_GET["doc_comp_h"];$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"]; $referenciacomp_d=$_GET["referenciacomp_d"];$referenciacomp_h=$_GET["referenciacomp_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$tipo_regis=$_GET["tipo_regis"];}
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha="";}  $equipo=getenv("COMPUTERNAME"); $cod_mov="PRE021".$usuario_sia; 
if ($tipo_regis=='TO'){$nombre='TODOS';}elseif($tipo_regis=='ANU'){$nombre='ANULADOS';}elseif($tipo_regis=='AJU'){$nombre='AJUSTADOS';}elseif($tipo_regis=='NANU'){$nombre='NI ANULADOS';}elseif($tipo_regis=='NAJU'){$nombre='NI AJUSTADOS';}
if ($cod_fuente_d=='00'){$fuente='PRESUPUESTO ORDINARIO';}
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
  if ($tipo_regis=='TO'){$nombre='TODOS';} $criterio_est="";
  if($tipo_regis=='ANU'){$nombre='ANULADOS'; $criterio_est="(pre007.anulado='S') And ";}
  if($tipo_regis=='AJU'){$nombre='AJUSTADOS';  $criterio_est="(pre037.ajustado<>0) And ";}
  if($tipo_regis=='NANU'){$nombre='NI ANULADOS,NI AJUSTADOS'; $criterio_est="(pre007.anulado='N') And (pre037.ajustado=0) And ";}
 
  $cfecha_h=formato_aaaammdd($fecha_h); $cfecha_d=formato_aaaammdd($fecha_d);
  $criterio1="Fecha Desde :".$fecha_d."        "."Hasta : ".$fecha_h;  $criterio2="USUARIO: ".$usuario_sia;
  $criterio=" (tipo_causado>='$doc_causa_d' and tipo_causado<='$doc_causa_h') And (referencia_caus>='$referencia_d' and referencia_caus<='$referencia_h') And (tipo_compromiso>='$doc_comp_d' and tipo_compromiso<='$doc_comp_h') And (referencia_comp>='$referenciacomp_d' and referencia_comp<='$referenciacomp_h') And (fecha_doc>='$fecha_d' and fecha_doc<='$fecha_h') And (cod_presup>='$cod_presupd' and cod_presup<='$cod_presuph') And (fuente_financ>='$cod_fuented' and fuente_financ<='$cod_fuenteh') And (ced_rif>='$cedula_d' and ced_rif<='$cedula_h')";
  $criterio4=$criterio_est."(substring(pre037.cod_presup from ".$ini." for 3)='401') and (PRE007.tipo_causado>='$doc_causa_d' and PRE007.tipo_causado<='$doc_causa_h') And (PRE007.referencia_caus>='$referencia_d' and PRE007.referencia_caus<='$referencia_h') And (PRE037.cod_presup>='$cod_presupd' and PRE037.cod_presup<='$cod_presuph') And (PRE007.tipo_compromiso>='$doc_comp_d' and PRE007.tipo_compromiso<='$doc_comp_h') And (PRE007.referencia_comp>='$referenciacomp_d' and PRE007.referencia_comp<='$referenciacomp_h')  And (PRE007.Fecha_Causado>='$fecha_d' and PRE007.Fecha_Causado<='$fecha_h') And (PRE037.fuente_financ>='$cod_fuente_d' and PRE037.fuente_financ<='$cod_fuente_h') And (PRE007.ced_rif>='$cedula_d' and PRE007.ced_rif<='$cedula_h')";
 	
  $StrSQL = "DELETE FROM PRE021 Where (tipo_registro='A') And (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

 if($cfecha_h==$Fec_Fin_Ejer){$StrSQL= "INSERT INTO PRE021 SELECT '$cod_mov' as nombre_usuario,'A' as tipo_registro,PRE007.Referencia_Comp,PRE007.Tipo_Compromiso,PRE002.Nombre_Abrev_Comp,PRE002.Nombre_Tipo_Comp,
PRE007.referencia_caus,PRE007.tipo_causado,PRE003.nombre_tipo_caus,PRE003.nombre_abrev_caus,'00000000' as Referencia_Pago,'0000' as Tipo_Pago,'' as Nombre_Abrev_Pago,'' as Nombre_Tipo_Pago, PRE037.Cod_Presup,PRE037.Fuente_Financ,PRE001.Denominacion,
PRE007.Fecha_Causado as Fecha_Doc,PRE007.Ref_AEP,PRE007.Num_Proyecto, PRE007.Fecha_AEP,'' as Tipo_Documento,'' as Nro_Documento,PRE007.Anulado,PRE007.Fecha_Anu AS Fecha_Anulado, PRE007.Ced_Rif,
PRE099.Nombre as Nombre_Benef,PRE037.Monto,0 as Comprometido,PRE037.Monto as Causado, PRE037.Pagado as Pagado,PRE037.Ajustado as Ajustado,PRE007.Func_Inv,
PRE037.Tipo_Imput_Presu,PRE037.Ref_Imput_Presu, PRE037.Monto_Credito,PRE007.inf_usuario,PRE007.Descripcion_Caus as Descripcion_Doc FROM PRE001,PRE002,PRE003,PRE007,PRE037,PRE099 
WHERE PRE001.Cod_Presup = PRE037.Cod_Presup AND PRE037.Fuente_Financ=PRE001.cod_fuente AND 
 PRE007.Tipo_Causado = PRE003.Tipo_Causado AND PRE002.Tipo_Compromiso = PRE007.Tipo_Compromiso AND PRE007.Tipo_Compromiso = PRE037.Tipo_Compromiso AND PRE007.Referencia_Comp = PRE037.Referencia_Comp AND
PRE007.Referencia_Caus = PRE037.Referencia_Caus AND PRE007.Tipo_Causado = PRE037.Tipo_Causado
AND PRE007.Ced_Rif = PRE099.Ced_Rif and ".$criterio4; }
else{$StrSQL= "INSERT INTO PRE021 SELECT '$cod_mov' as nombre_usuario,'A' as tipo_registro,PRE007.Referencia_Comp,PRE007.Tipo_Compromiso,PRE002.Nombre_Abrev_Comp,PRE002.Nombre_Tipo_Comp,
PRE007.referencia_caus,PRE007.tipo_causado,PRE003.nombre_tipo_caus,PRE003.nombre_abrev_caus,'00000000' as Referencia_Pago,'0000' as Tipo_Pago,'' as Nombre_Abrev_Pago,'' as Nombre_Tipo_Pago, PRE037.Cod_Presup,PRE037.Fuente_Financ,PRE001.Denominacion,
PRE007.Fecha_Causado as Fecha_Doc,PRE007.Ref_AEP,PRE007.Num_Proyecto, PRE007.Fecha_AEP,'' as Tipo_Documento,'' as Nro_Documento,PRE007.Anulado,PRE007.Fecha_Anu AS Fecha_Anulado, PRE007.Ced_Rif,
PRE099.Nombre as Nombre_Benef,PRE037.Monto,0 as Comprometido,PRE037.Monto as Causado, 0 as Pagado,0 as Ajustado,PRE007.Func_Inv,
PRE037.Tipo_Imput_Presu,PRE037.Ref_Imput_Presu, PRE037.Monto_Credito,PRE007.inf_usuario,PRE007.Descripcion_Caus as Descripcion_Doc FROM PRE001,PRE002,PRE003,PRE007,PRE037,PRE099 
WHERE PRE001.Cod_Presup = PRE037.Cod_Presup AND PRE037.Fuente_Financ=PRE001.cod_fuente AND 
 PRE007.Tipo_Causado = PRE003.Tipo_Causado AND PRE002.Tipo_Compromiso = PRE007.Tipo_Compromiso AND PRE007.Tipo_Compromiso = PRE037.Tipo_Compromiso AND PRE007.Referencia_Comp = PRE037.Referencia_Comp AND
PRE007.Referencia_Caus = PRE037.Referencia_Caus AND PRE007.Tipo_Causado = PRE037.Tipo_Causado
AND PRE007.Ced_Rif = PRE099.Ced_Rif and ".$criterio4; 
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$StrSQL="SELECT ACT_CAUS_pre021('P','".$cod_mov."','A','$referencia_d','$referencia_h','$doc_comp_d','$doc_comp_h','$cfecha_d','$cfecha_h')";

}
 
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
//print_r($StrSQL);
	
	$sSQL = "SELECT * FROM PRE021 WHERE ".$criterio." and (tipo_registro='A') And (nombre_usuario='".$cod_mov."') ORDER BY PRE021.Fecha_Doc, PRE021.Referencia_Comp, PRE021.Tipo_Compromiso";
        
	$sSQL = "SELECT nombre_usuario, tipo_registro, referencia_comp, tipo_compromiso, nombre_abrev_comp, nombre_tipo_comp, referencia_caus, tipo_causado, nombre_tipo_caus, nombre_abrev_caus, referencia_pago, tipo_pago, nombre_tipo_pago, nombre_abrev_pago, cod_presup, fuente_financ, 
       substr(denominacion,1,30) as denominacion, fecha_doc, ref_aep, num_proyecto, fecha_aep, tipo_documento,nro_documento, anulado, fecha_anulado, ced_rif, nombre_benef, 
       monto, comprometido, causado, pagado, ajustado, (ajustado*-1) as ajuste, func_inv, tipo_imput_presu, ref_imput_presu, monto_credito, inf_usuario, descripcion_doc, substr(descripcion_doc,1,140) AS descripciond, to_char(fecha_Doc,'DD/MM/YYYY') as fechad FROM pre021 WHERE ".$criterio." and (Tipo_Registro='A') And (Nombre_Usuario='".$cod_mov."') ORDER BY pre021.fecha_Doc, pre021.referencia_caus,pre021.tipo_causado,pre021.cod_presup,pre021.fuente_financ";

//print_r($sSQL);
		
		$oRpt = new PHPReportMaker();	
		$oRpt->setXML("Rpt_causados_general.xml");
		$oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("localhost");
       	$oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2));          
        $oRpt->run();

?>
