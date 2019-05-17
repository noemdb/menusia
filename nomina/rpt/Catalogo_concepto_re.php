<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$date = date("d-m-Y");$hora = date("H:i:s a");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
       else{$sSQL = "select cod_concepto,denominacion,cod_partida,asignacion,activo,inicializable,tipo_grupo,oculto,acumula,frecuencia from nom002 order by cod_concepto";
   			$oRpt = new PHPReportMaker();
   			$oRpt->setXML("Catalogo_concepto_re.xml");
   			$oRpt->setUser("$user");
   			$oRpt->setPassword("$password");
   			$oRpt->setConnection("localhost");
   			$oRpt->setDatabaseInterface("postgresql");
   			$oRpt->setSQL($sSQL);
   			$oRpt->setDatabase("$dbname");
   			$oRpt->run();
            }
?>
