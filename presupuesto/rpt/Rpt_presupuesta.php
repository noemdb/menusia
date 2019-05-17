<?include ("../../class/conect.php"); include ("../../class/phpreports/PHPReportMaker.php");  include ("../../class/conect.php");
if ($_GET){$cod_presup_d=$_GET["cod_presup_d"];$cod_presup_h=$_GET["cod_presup_h"];$cod_fuente_d=$_GET["cod_fuente_d"];$cod_fuente_h=$_GET["cod_fuente_h"];}
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$tipo="";}
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");

if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}


  $criterio="where (cod_presup>='$cod_presup_d' and cod_presup<='$cod_presup_h') and (cod_fuente>='$cod_fuente_d' and cod_fuente<='$cod_fuente_h')";

        $sSQL = "SELECT PRE020.Cod_Presup, PRE020.Denominacion, PRE020.Asignado, PRE020.Traslados, PRE020.Trasladon, PRE020.Adicion, PRE020.Disminucion, PRE020.Compromiso, PRE020.Causado, 		         PRE020.Pagado, PRE020.Disponible,  
		(PRE020.Traslados-PRE020.Trasladon+PRE020.Adicion-PRE020.Disminucion) AS Modificaciones,
		(PRE020.Asignado+PRE020.Traslados-PRE020.Trasladon+PRE020.Adicion-PRE020.Disminucion) AS Asig_Actualizada, 
		(PRE020.Asignado+PRE020.Traslados-PRE020.Trasladon+PRE020.Adicion-PRE020.Disminucion-PRE020.Compromiso) AS Disponibilidad
		 FROM PRE020 ".$criterio."
		 ORDER BY PRE020.Cod_Presup";
        $oRpt = new PHPReportMaker();
        $oRpt->setXML("Rpt_presupuestaria.xml");
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("localhost");
        $oRpt->setDatabaseInterface("postgresql");
        $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
        $oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
        $oRpt->run();

?>

