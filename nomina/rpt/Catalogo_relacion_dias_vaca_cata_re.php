<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$date = date("d-m-Y");$hora = date("H:i:s a");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
       else{$sSQL = "SELECT codigo_departamento,descripcion_dep  FROM nom005 ORDER BY codigo_departamento";
   		$oRpt = new PHPReportMaker();
   		$oRpt->setXML("Catalogo_relacion_dias_vaca_cata_re.xml");
   		$oRpt->setUser("$user");
   		$oRpt->setPassword("$password");
   		$oRpt->setConnection("localhost");
   		$oRpt->setDatabaseInterface("postgresql");
   		$oRpt->setSQL($sSQL);
   		$oRpt->setDatabase("$dbname");
   		$oRpt->run();
          }
?>
