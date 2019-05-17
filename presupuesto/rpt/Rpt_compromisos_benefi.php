<?include ("../../class/phpreports/PHPReportMaker.php");?>
<?include ("../../class/conect.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="";
   $cedrifd=$_GET["cedrifd"]; $cedrifh=$_GET["cedrifh"];  $clasificad=$_GET["clasificad"];$clasificah=$_GET["clasificah"]; $detallado=$_GET["detallado"];
   $oRpt = new PHPReportMaker();
   if  ($detallado=="S")    
   {
     $sSQL = "SELECT * FROM PRE019, PRE001, PRE002, PRE006, PRE099, PRE036
		WHERE PRE019.Cod_Presup_Cat = PRE001.Cod_Presup AND PRE002.Tipo_Compromiso = PRE006.Tipo_Compromiso AND PRE006.Ced_Rif = PRE099.Ced_Rif AND 
		PRE006.Tipo_Compromiso = PRE036.Tipo_Compromiso AND PRE006.Referencia_Comp = PRE036.Referencia_Comp
		ORDER BY PRE006.Fecha_Compromiso, PRE006.Referencia_Comp, PRE006.Tipo_Compromiso";
     $oRpt->setXML("Catalogo_beneficiarios_deta.xml");
   }
   else 
   {$sSQL = "SELECT * FROM PRE019, PRE001, PRE002, PRE006, PRE099, PRE036
WHERE PRE019.Cod_Presup_Cat = PRE001.Cod_Presup AND PRE002.Tipo_Compromiso = PRE006.Tipo_Compromiso AND PRE006.Ced_Rif = PRE099.Ced_Rif AND 
PRE006.Tipo_Compromiso = PRE036.Tipo_Compromiso AND PRE006.Referencia_Comp = PRE036.Referencia_Comp AND PRE019.Cod_presup_cat>='01-00-55' AND PRE019.Cod_presup_cat<='01-00-55'
ORDER BY PRE006.Fecha_Compromiso, PRE006.Referencia_Comp, PRE006.Tipo_Compromiso";
     $oRpt->setXML("Rpt_compromisos_beneficiarios.xml");}
     $oRpt->setUser("$user");
     $oRpt->setPassword("$password");
     $oRpt->setConnection("localhost");
     $oRpt->setDatabaseInterface("postgresql");
     $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
     $oRpt->setSQL($sSQL);
     $oRpt->setDatabase("$dbname");
    $oRpt->run();
 }
?>
