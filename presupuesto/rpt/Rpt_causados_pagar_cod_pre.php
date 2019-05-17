<?include ("../../class/conect.php");  include ("../../class/funciones.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); include ("../../class/phpreports/PHPReportMaker.php");
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];$doc_causa_d=$_GET["doc_causa_d"];$doc_causa_h=$_GET["doc_causa_h"];$doc_comp_d=$_GET["doc_comp_d"]; $doc_comp_h=$_GET["doc_comp_h"];$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"]; $referenciacomp_d=$_GET["referenciacomp_d"];$referenciacomp_h=$_GET["referenciacomp_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];}
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha="";}  $equipo=getenv("COMPUTERNAME"); $cod_mov="PRE021".$usuario_sia; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }

  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;

  $criterio1="Fecha Desde :".$fecha_d."        "."Hasta : ".$fecha_h; 
  $criterio=" (tipo_causado>='$doc_causa_d' and tipo_causado<='$doc_causa_h') And (referencia_caus>='$referencia_d' and referencia_caus<='$referencia_h') And (tipo_compromiso>='$doc_comp_d' and tipo_compromiso<='$doc_comp_h') And (referencia_comp>='$referenciacomp_d' and referencia_comp<='$referenciacomp_h') And (fecha_doc>='$fecha_d' and fecha_doc<='$fecha_h') And (cod_presup>='$cod_presupd' and cod_presup<='$cod_presuph') And (fuente_financ>='$cod_fuented' and fuente_financ<='$cod_fuenteh') And (ced_rif>='$cedula_d' and ced_rif<='$cedula_h')";
       
  $StrSQL = "DELETE FROM PRE021 Where (Tipo_Registro='C') And (Nombre_Usuario='".$cod_mov."')";
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

$StrSQL= "INSERT INTO PRE021 SELECT 'PRE021ADMINISTRADOR' as Nombre_Usuario,'C' as Tipo_Registro,PRE006.Referencia_Comp,PRE006.Tipo_Compromiso,PRE002.Nombre_Abrev_Comp,PRE002.Nombre_Tipo_Comp,'00000000' as Referencia_Caus,pre006.cod_comp as Tipo_Causado,'' as Nombre_Abrev_Caus, '' as Nombre_Tipo_Caus,'00000000' as Referencia_Pago,'0000' as Tipo_Pago,'' as Nombre_Abrev_Pago,'' as Nombre_Tipo_Pago, PRE036.Cod_Presup,PRE036.Fuente_Financ,PRE001.Denominacion,
PRE006.Fecha_Compromiso as Fecha_Doc,PRE006.Ref_AEP,PRE006.Num_Proyecto, PRE006.Fecha_AEP,PRE006.Tipo_Documento,PRE006.Nro_Documento,PRE006.Anulado,PRE006.Fecha_Anu AS Fecha_Anulado, PRE006.Ced_Rif,
PRE099.Nombre as Nombre_Benef,PRE036.Monto,PRE036.Monto as Comprometido,PRE036.Causado as Causado, PRE036.Pagado as Pagado,PRE036.Ajustado as Ajustado,PRE006.Func_Inv,
PRE036.Tipo_Imput_Presu,PRE036.Ref_Imput_Presu, PRE036.Monto_Credito,PRE006.Descripcion_Comp as Descripcion_Doc 
FROM PRE001,PRE002,PRE006, PRE036, PRE099 
WHERE PRE001.Cod_Presup = PRE036.Cod_Presup AND PRE036.Fuente_Financ=PRE001.cod_fuente AND 
PRE002.Tipo_Compromiso = PRE006.Tipo_Compromiso AND PRE006.Tipo_Compromiso = PRE036.Tipo_Compromiso AND 
PRE006.Referencia_Comp = PRE036.Referencia_Comp AND PRE006.Ced_Rif = PRE099.Ced_Rif";
 $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
// print_r($StrSQL);

		$sSQL = "SELECT * FROM PRE021 WHERE ".$criterio." ORDER BY PRE021.Fecha_Doc, PRE021.Referencia_Comp, PRE021.Tipo_Compromiso";
        	$oRpt = new PHPReportMaker();	
		$oRpt->setXML("Rpt_causados_pagar_cod_presup.xml");
		$oRpt->setUser("$user");
        	$oRpt->setPassword("$password");
        	$oRpt->setConnection("$host");
       	 	$oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
        	$oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"criterio3"=>$criterio3));          
        	$oRpt->run();

?>
