<<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");$codigocuentad=$_GET["codigocuentad"];$codigocuentah=$_GET["codigocuentah"];$periodo=$_GET["periodo"];;$nivel=$_GET["nivel"];;$vimprimir=$_GET["vimprimir"];;$Sql="";
//echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{
    // LLAMAR A PHP_REPORT
      $sSQL = "SELECT CON013.Nro_Linea, CON013.Nombre_Cuenta, CON013.Columna2, CON013.Status, CON013.Codigo_Cuenta,  CON013.Columna3, CON013.Columna4,
               CON013.Columna5, CON013.Columna1,  CON013.Columna6,  CON013.Columna7,  CON013.Columna8
               FROM CON013 CON013
               WHERE STATUS<>'C'  AND NRO_LINEA='1'AND
               CON013.Codigo_Cuenta>='".$codigocuentad."' AND CON013.Codigo_Cuenta<='".$codigocuentah."'
               ORDER BY CON013.Nro_Linea";
      $oRpt = new PHPReportMaker();
      $oRpt->setXML("Balance_Comprobacion_Detalle.xml");
      $oRpt->setUser("$user");
      $oRpt->setPassword("$password");
      $oRpt->setConnection("$host");
      $oRpt->setDatabaseInterface("postgresql");
      $oRpt->setSQL($sSQL);
      $oRpt->setDatabase("$dbname");
      $oRpt->setParameters(array("criterio1"=>$criterio1));
      $oRpt->run();
     }

?>

