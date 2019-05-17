<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
   $cod_empleado_d=$_GET["cod_empleado_d"];
   $cod_empleado_h=$_GET["cod_empleado_h"];
   $fecha_d=$_GET["fecha_d"];
   $fecha_h=$_GET["fecha_h"];
   $Sql="";
   $date = date("d-m-Y");
   $hora = date("h:i:s a");
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
      $sSQL = "SELECT NOM053.Cedula, NOM053.Nombre_E, NOM054.CI_Partida_FE, NOM054.Nombre_FE, NOM054.Sexo_FE, NOM054.Fecha_Nac_FE, NOM054.Edad_FE, NOM054.Parentesco_FE
               FROM NOM053 NOM053, NOM054 NOM054 WHERE NOM053.Cedula = NOM054.Cedula ORDER BY NOM053.Cedula";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_info_fami_me.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
  }
?>
