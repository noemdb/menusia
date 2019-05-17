<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
   $tipo_nomina_d=$_GET["tipo_nomina_d"];
   $tipo_nomina_h=$_GET["tipo_nomina_h"];
   $codigo_departamentod=$_GET["codigo_departamentod"];
   $codigo_departamentoh=$_GET["codigo_departamentoh"];
   $fecha_d=$_GET["fecha_d"];
   $fecha_h=$_GET["fecha_h"];
   $detallado=$_GET["detallado"];
   $Sql="";
   $date = date("d-m-Y");
   $hora = date("H:i:s a");
   //cambiar formato a la fecha
        if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
      $fecha_desde=$ano1.$mes1.$dia1;
        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
      $fecha_hasta=$ano1.$mes1.$dia1;
//echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {

     if ($detallado=='NO')
     {
      $sSQL = "SELECT * FROM NOM017  WHERE NOM017.Oculto='NO'  AND
               NOM017.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM017.Tipo_Nomina<='".$tipo_nomina_h."' AND
               NOM017.Cod_Departam>='".$codigo_departamentod."' AND NOM017.Cod_Departam<='".$codigo_departamentoh."' AND
               NOM017.Fecha_P_Desde>='".$fecha_desde."' AND NOM017.Fecha_P_Hasta<='".$fecha_hasta."' Union All
               SELECT * FROM NOM019  WHERE NOM019.Oculto='NO'  AND
               NOM019.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM019.Tipo_Nomina<='".$tipo_nomina_h."' AND
               NOM019.Cod_Departam>='".$codigo_departamentod."' AND NOM019.Cod_Departam<='".$codigo_departamentoh."' AND
               NOM019.Fecha_P_Desde>='".$fecha_desde."' AND NOM019.Fecha_P_Hasta<='".$fecha_hasta."'
               order by 52,1,3,4";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_gas_per_tip_rn_re.xml");
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
    elseif ($detallado=='POR FECHA')
    {
      $sSQL = "SELECT * FROM NOM017  WHERE NOM017.Oculto='NO'  AND
               NOM017.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM017.Tipo_Nomina<='".$tipo_nomina_h."' AND
               NOM017.Cod_Departam>='".$codigo_departamentod."' AND NOM017.Cod_Departam<='".$codigo_departamentoh."' AND
               NOM017.Fecha_P_Desde>='".$fecha_desde."' AND NOM017.Fecha_P_Hasta<='".$fecha_hasta."' Union All
               SELECT * FROM NOM019  WHERE NOM019.Oculto='NO'  AND
               NOM019.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM019.Tipo_Nomina<='".$tipo_nomina_h."' AND
               NOM019.Cod_Departam>='".$codigo_departamentod."' AND NOM019.Cod_Departam<='".$codigo_departamentoh."' AND
               NOM019.Fecha_P_Desde>='".$fecha_desde."' AND NOM019.Fecha_P_Hasta<='".$fecha_hasta."'
               order by 52,1,3,4";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_gas_per_tip_rn_re_fecha.xml");
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
    elseif ($detallado=='POR PERSONA')
    {
      $sSQL = "SELECT * FROM NOM017  WHERE NOM017.Oculto='NO'  AND
               NOM017.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM017.Tipo_Nomina<='".$tipo_nomina_h."' AND
               NOM017.Cod_Departam>='".$codigo_departamentod."' AND NOM017.Cod_Departam<='".$codigo_departamentoh."' AND
               NOM017.Fecha_P_Desde>='".$fecha_desde."' AND NOM017.Fecha_P_Hasta<='".$fecha_hasta."' Union All
               SELECT * FROM NOM019  WHERE NOM019.Oculto='NO'  AND
               NOM019.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM019.Tipo_Nomina<='".$tipo_nomina_h."' AND
               NOM019.Cod_Departam>='".$codigo_departamentod."' AND NOM019.Cod_Departam<='".$codigo_departamentoh."' AND
               NOM019.Fecha_P_Desde>='".$fecha_desde."' AND NOM019.Fecha_P_Hasta<='".$fecha_hasta."'
               order by 52,1,3,4";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_gas_per_tip_rn_re_persona.xml");
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
