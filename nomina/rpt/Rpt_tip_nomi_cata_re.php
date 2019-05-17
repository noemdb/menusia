<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$date = date("d-m-Y");$hora = date("H:i:s a");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
       else{$sSQL = "select tipo_nommina,descripcion,frecuencia,ultima_fecha from NOM001 order by tipo_nomina";
   	    $oRpt = new PHPReportMaker();
   	    $oRpt->setXML("Rpt_tip_nomi_cata_re.xml");
   	    $oRpt->setUser("$user");
   	    $oRpt->setPassword("$password");
   	    $oRpt->setConnection("localhost");
   	    $oRpt->setDatabaseInterface("postgresql");
   	    $oRpt->setSQL($sSQL);
   	    $oRpt->setDatabase("$dbname");
   	    $oRpt->run();
	   }
?>

