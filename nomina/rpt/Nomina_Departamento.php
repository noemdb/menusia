<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$date = date("d-m-Y");$hora = date("H:i:s a");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
       else{$sSQL = "SELECT nom004.codigo_cargo, nom004.denominacion, nom004.nro_cargos, nom004.asignados, nom004.grado, nom004.Paso  FROM nom004 nom004  ORDER BY 			      nom004.codigo_cargo";
   			$oRpt = new PHPReportMaker();
   			$oRpt->setXML("Nomina_Departamento.xml");
   			$oRpt->setUser("$user");
   			$oRpt->setPassword("$password");
   			$oRpt->setConnection("localhost");
   			$oRpt->setDatabaseInterface("postgresql");
   			$oRpt->setSQL($sSQL);
   			$oRpt->setDatabase("$dbname");
   			$oRpt->run();
	   }
?>
