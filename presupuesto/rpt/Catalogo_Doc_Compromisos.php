<?include ("/AppServ/www/sia/class/conect.php");?>

<?
   // include the PHPReports classes on the PHP path! configure your path here
   include "/AppServ/www/sia/class/phpreports/PHPReportMaker.php";

   $sSQL = "select tipo_compromiso,nombre_tipo_comp,nombre_abrev_comp from PRE002 order by tipo_compromiso";
   $oRpt = new PHPReportMaker();
   $oRpt->setXML("Catalogo_Doc_Compromisos.xml");
   $oRpt->setUser("$user");
   $oRpt->setPassword("$password");
   $oRpt->setConnection("localhost");
   $oRpt->setDatabaseInterface("postgresql");
   $oRpt->setSQL($sSQL);
   $oRpt->setDatabase("$dbname");
   $oRpt->run();
?>

