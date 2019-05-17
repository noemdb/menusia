<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$date = date("d-m-Y");$hora = date("H:i:s a");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
       else{ $sSQL = "SELECT nom003.tipo_nomina, nom001.descripcion, nom003.cod_concepto, nom002.denominacion, nom003.consecutivo, nom003.accion, 				nom003.rango_inicial,nom003.rango_final, nom003.Calculo1, NOM003.Calculo2, NOM003.CalculoFinal  FROM NOM001 NOM001, NOM002 NOM002, NOM003 NOM003  				WHERE NOM003.Cod_Concepto,NOM002.Cod_Concepto AND NOM003.Tipo_Nomina = NOM001.Tipo_Nomina AND NOM003.Tipo_Nomina = NOM002.tipo_nomina  ORDER BY 			NOM003.Tipo_Nomina,NOM003.Cod_Concepto,NOM003.Consecutivo";
   		$oRpt = new PHPReportMaker();
   		$oRpt->setXML("Catalogo_formula_concepto_re.xml");
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
