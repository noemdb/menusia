<?include ("../../class/phpreports/PHPReportMaker.php"); include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE);

$date = date("d-m-Y");$hora = date("H:i:s a");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
       else{$sSQL = "select tipo_nomina,descripcion,frecuencia,ultima_fecha,redondear, to_char(ultima_fecha,'DD/MM/YYYY') as fecham from nom001 order by tipo_nomina";
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Catalogo_tip_nomi_cata_re.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("localhost");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("date"=>$date,"hora"=>$hora));
            $oRpt->run();
           }
?>
