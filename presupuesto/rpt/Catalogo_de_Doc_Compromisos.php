<?include ("/AppServ/www/sia/class/conect.php");?>

<?
   // include the PHPReports classes on the PHP path! configure your path here
   include "/AppServ/www/sia/class/phpreports/PHPReportMaker.php";

   $sSQL = "select Codigo_Cuenta,Nombre_Cuenta,TSaldo,Clasificacion from con001 order by Codigo_Cuenta";
   $oRpt = new PHPReportMaker();
   $oRpt->setXML("Catalogo_de_Cuentas.xml");
   $oRpt->setUser("$user");
   $oRpt->setPassword("$password");
   $oRpt->setConnection("localhost");
   $oRpt->setDatabaseInterface("postgresql");
   $oRpt->setSQL($sSQL);
   $oRpt->setDatabase("$dbname");
   $oRpt->run();
?>

