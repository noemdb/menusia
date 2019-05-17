<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
   $cod_empleado_d=$_GET["cod_empleado_d"];
   $cod_empleado_h=$_GET["cod_empleado_h"];
   $Sql="";
   $date = date("d-m-Y");
   $hora = date("H:i:s a");
   $criterio1="15";
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
      $sSQL = "SELECT * FROM NOM022,NOM023, NOM006
               WHERE NOM022.Cod_Empleado = NOM023.Cod_Empleado AND NOM023.Oculto = 'NO' AND NOM006.Cod_Empleado = NOM022.Cod_Empleado AND
               NOM022.Cod_Empleado>='".$cod_empleado_d."' AND NOM022.Cod_Empleado<='".$cod_empleado_h."' ORDER BY NOM006.Cod_Empleado, NOM022.Cod_Concepto_V";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_compro_vaca_mpv_re.xml");
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
?>
