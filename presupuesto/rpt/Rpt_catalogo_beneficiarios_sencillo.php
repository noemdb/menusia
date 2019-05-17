<?include ("/AppServ/www/sia/class/conect.php");?>

<?
   // include the PHPReports classes on the PHP path! configure your path here
   include "/AppServ/www/sia/class/phpreports/PHPReportMaker.php";

   $sSQL = "select ced_rif, nombre, cedula, rif, tipo_benef from pre099 order by ced_rif";
   $oRpt = new PHPReportMaker();
   $oRpt->setXML("Catalogo_Beneficiarios.xml");
   $oRpt->setUser("$user");
   $oRpt->setPassword("$password");
   $oRpt->setConnection("localhost");
   $oRpt->setDatabaseInterface("postgresql");
   $oRpt->setSQL($sSQL);
   $oRpt->setDatabase("$dbname");
   $oRpt->run();
?>
