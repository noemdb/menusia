<?include ("../../class/conect.php");error_reporting(E_ALL ^ E_NOTICE);  include "../../class/phpreports/PHPReportMaker.php"; 
     $date = date("d-m-Y");$hora = date("H:i:s a");
   $sSQL = "SELECT NOM005.Codigo_Departamento, NOM005.Descripcion_Dep, NOM043.Codigo_Cargo, NOM043.Cod_Tipo_Personal, NOM043.Nro_Cargos, NOM043.Asignados,NOM004.Denominacion
            FROM NOM005,NOM004,NOM043
            WHERE NOM005.Codigo_Departamento=NOM043.Codigo_Departamento  And NOM004.Codigo_Cargo=NOM043.Codigo_Cargo ORDER BY NOM005.Codigo_Departamento";
   $oRpt = new PHPReportMaker();
   $oRpt->setXML("Catalogo_carg_depar_cata_re.xml");
   $oRpt->setUser("$user");
   $oRpt->setPassword("$password");
   $oRpt->setConnection("localhost");
   $oRpt->setDatabaseInterface("postgresql");
   $oRpt->setSQL($sSQL);
   $oRpt->setDatabase("$dbname");
   $oRpt->setParameters(array("date"=>$date,"hora"=>$hora)); 
   $oRpt->run();
?>