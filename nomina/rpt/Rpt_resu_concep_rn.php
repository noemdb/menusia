<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");$tipo_nomina_d=$_GET["tipo_nomina_d"];
   $tipo_nomina_h=$_GET["tipo_nomina_h"];
   $cod_conceptod=$_GET["cod_conceptod"];
   $cod_conceptoh=$_GET["cod_conceptoh"];
   $codigo_departamentod=$_GET["codigo_departamentod"];
   $codigo_departamentoh=$_GET["codigo_departamentoh"];
   $tipo_resumen=$_GET["tipo_resumen"];
   $forma_pago=$_GET["forma_pago"];
   $tipo_calculo=$_GET["tipo_calculo"];
   $Sql="";
   $date = date("d-m-Y");
   $hora = date("h:i:s a");
   if($tipo_resumen=='ASIGNACIONES'){$criterio1="RESUMEN DE ASIGNACIONES";}
   elseif($tipo_resumen=='DEDUCCIONES'){$criterio1="RESUMEN DE DEDUCCIONES";}
   else{$criterio1="RESUMEN DE NOMINA";}
//echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
   if (($tipo_resumen=='ASIGNACIONES') && ($forma_pago=='TODOS'))
   {
          $sSQL = "SELECT *  FROM NOM017 NOM017
                   WHERE ((NOM017.Cod_Concepto<>'VVV') AND NOM017.Asignacion='SI' AND (NOM017.Oculto='NO')) AND
                    NOM017.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM017.Tipo_Nomina<='".$tipo_nomina_h."' AND
                    NOM017.Cod_Departam>='".$codigo_departamentod."' AND NOM017.Cod_Departam<='".$codigo_departamentoh."' AND NOM017.Tp_Calculo='".$tipo_calculo."'
                    ORDER BY NOM017.Tipo_Nomina, NOM017.Cod_Concepto";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_resu_concep_rn_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
   }
   elseif (($tipo_resumen=='ASIGNACIONES') && ($forma_pago!='TODOS'))
   {
          $sSQL = "SELECT *  FROM NOM017 NOM017
                   WHERE ((NOM017.Cod_Concepto<>'VVV') AND NOM017.Asignacion='SI' AND (NOM017.Oculto='NO')) AND
                    NOM017.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM017.Tipo_Nomina<='".$tipo_nomina_h."' AND
                    NOM017.Cod_Departam>='".$codigo_departamentod."' AND NOM017.Cod_Departam<='".$codigo_departamentoh."' AND NOM017.Tipo_Pago='".$forma_pago."' AND NOM017.Tp_Calculo='".$tipo_calculo."'
                    ORDER BY NOM017.Tipo_Nomina, NOM017.Cod_Concepto";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_resu_concep_rn_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
   }
   elseif (($tipo_resumen=='DEDUCCIONES') && ($forma_pago=='TODOS'))
   {
           $sSQL = "SELECT *  FROM NOM017 NOM017
                   WHERE ((NOM017.Cod_Concepto<>'VVV') AND NOM017.Asignacion='NO' AND (NOM017.Oculto='NO')) AND
                    NOM017.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM017.Tipo_Nomina<='".$tipo_nomina_h."' AND
                    NOM017.Cod_Departam>='".$codigo_departamentod."' AND NOM017.Cod_Departam<='".$codigo_departamentoh."' AND NOM017.Tp_Calculo='".$tipo_calculo."'
                    ORDER BY NOM017.Tipo_Nomina, NOM017.Cod_Concepto";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_resu_concep_rn_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
   }
   elseif (($tipo_resumen=='DEDUCCIONES') && ($forma_pago!='TODOS'))
   {
           $sSQL = "SELECT *  FROM NOM017 NOM017
                   WHERE ((NOM017.Cod_Concepto<>'VVV') AND NOM017.Asignacion='NO' AND (NOM017.Oculto='NO')) AND
                    NOM017.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM017.Tipo_Nomina<='".$tipo_nomina_h."' AND
                    NOM017.Cod_Departam>='".$codigo_departamentod."' AND NOM017.Cod_Departam<='".$codigo_departamentoh."' AND NOM017.Tipo_Pago='".$forma_pago."'  AND NOM017.Tp_Calculo='".$tipo_calculo."'
                    ORDER BY NOM017.Tipo_Nomina, NOM017.Cod_Concepto";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_resu_concep_rn_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
   }
   elseif (($tipo_resumen=='APORTES') && ($forma_pago=='TODOS'))
   {
           $sSQL = "SELECT *  FROM NOM017 NOM017
                    WHERE ((NOM017.Cod_Concepto<>'VVV') AND NOM017.Asignacion='SI' AND NOM017.Asig_ded_apo='P' AND (NOM017.Oculto='SI')) AND
                    NOM017.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM017.Tipo_Nomina<='".$tipo_nomina_h."' AND
                    NOM017.Cod_Departam>='".$codigo_departamentod."' AND NOM017.Cod_Departam<='".$codigo_departamentoh."'  AND NOM017.Tp_Calculo='".$tipo_calculo."'
                    ORDER BY NOM017.Tipo_Nomina, NOM017.Cod_Concepto";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_resu_concep_rn_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
   }
   elseif (($tipo_resumen=='APORTES') && ($forma_pago!='TODOS'))
   {
           $sSQL = "SELECT *  FROM NOM017 NOM017
                    WHERE ((NOM017.Cod_Concepto<>'VVV') AND NOM017.Asignacion='SI' AND NOM017.Asig_ded_apo='P' AND (NOM017.Oculto='SI')) AND
                    NOM017.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM017.Tipo_Nomina<='".$tipo_nomina_h."' AND
                    NOM017.Cod_Departam>='".$codigo_departamentod."' AND NOM017.Cod_Departam<='".$codigo_departamentoh."' AND NOM017.Tipo_Pago='".$forma_pago."'  AND NOM017.Tp_Calculo='".$tipo_calculo."'
                    ORDER BY NOM017.Tipo_Nomina, NOM017.Cod_Concepto";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_resu_concep_rn_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
   }
   elseif (($tipo_resumen=='TODOS') && ($forma_pago=='TODOS'))
   {
       $sSQL = "SELECT *  FROM NOM017 NOM017
                    WHERE ((NOM017.Cod_Concepto<>'VVV') AND (NOM017.Oculto='NO')) AND
                    NOM017.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM017.Tipo_Nomina<='".$tipo_nomina_h."' AND
                    NOM017.Cod_Departam>='".$codigo_departamentod."' AND NOM017.Cod_Departam<='".$codigo_departamentoh."' AND NOM017.Tp_Calculo='".$tipo_calculo."'
                    ORDER BY NOM017.Tipo_Nomina, NOM017.Cod_Concepto";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_resu_concep_rn_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();

   }
   elseif (($tipo_resumen=='TODOS') && ($forma_pago!='TODOS'))
   {
       $sSQL = "SELECT *  FROM NOM017 NOM017
                    WHERE ((NOM017.Cod_Concepto<>'VVV') AND (NOM017.Oculto='NO')) AND
                    NOM017.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM017.Tipo_Nomina<='".$tipo_nomina_h."' AND
                    NOM017.Cod_Departam>='".$codigo_departamentod."' AND NOM017.Cod_Departam<='".$codigo_departamentoh."' AND NOM017.Tipo_Pago='".$forma_pago."' AND NOM017.Tp_Calculo='".$tipo_calculo."'
                    ORDER BY NOM017.Tipo_Nomina, NOM017.Cod_Concepto";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_resu_concep_rn_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();

   }
  }
?>
