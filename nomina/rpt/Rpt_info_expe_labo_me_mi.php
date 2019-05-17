<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
   $cod_empleado_d=$_GET["cod_empleado_d"];
   $cod_empleado_h=$_GET["cod_empleado_h"];
   $fecha_d=$_GET["fecha_d"];
   $fecha_h=$_GET["fecha_h"];
   $fecha_de=$_GET["fecha_de"];
   $fecha_ha=$_GET["fecha_ha"];
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
      //cambiar formato a la fecha experiencia laboral
        if (!(empty($fecha_de))){$ano1=substr($fecha_de,6,9);$mes1=substr($fecha_de,3,2);$dia1=substr($fecha_de,0,2);}
        else{$fecha_de='';}
      $fecha_desde_x=$ano1.$mes1.$dia1;
        if (!(empty($fecha_ha))){$ano1=substr($fecha_ha,6,9);$mes1=substr($fecha_ha,3,2);$dia1=substr($fecha_ha,0,2);}
        else{$fecha_ha='';}
      $fecha_hasta_x=$ano1.$mes1.$dia1;
//echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
      $sSQL = "SELECT NOM053.Cedula, NOM053.Nombre_E, NOM055.Fecha_desde_LE, NOM055.Fecha_hasta_LE, NOM055.Empresa_LE, NOM055.Departamento_LE, NOM055.Cargo_LE, NOM055.Sueldo_LE
               FROM NOM053, NOM055
               WHERE NOM053.Cedula = NOM055.Cedula   AND
               NOM053.Cedula>='".$cod_empleado_d."' AND NOM053.Cedula<='".$cod_empleado_h."' AND
               NOM055.Fecha_desde_le>='".$fecha_desde."' AND NOM055.Fecha_desde_le<='".$fecha_hasta."'   AND
               NOM055.Fecha_hasta_le>='".$fecha_desde_x."' AND NOM055.Fecha_hasta_le<='".$fecha_hasta_x."'
               ORDER BY NOM053.Cedula";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_info_expe_labo_me_mi_re.xml");
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
