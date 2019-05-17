<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
   $cedula_d=$_GET["cedula_d"];
   $cedula_h=$_GET["cedula_h"];
   $fecha_d=$_GET["fecha_d"];
   $fecha_h=$_GET["fecha_h"];
   $sexo=$_GET["sexo"];
   $edad_d=$_GET["edad_d"];
   $edad_h=$_GET["edad_h"];
   $edo_civil=$_GET["edo_civil"];
   $Sql="";
   $date = date("d-m-Y");
   $hora = date("h:i:s a");
  // print_r($sexo);
  // print_r($edo_civil);
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
    if (($sexo=='TODOS') && ($edo_civil=='TODOS'))
    {
      $sSQL = "SELECT NOM006.Cod_Empleado, NOM006.Nombre, NOM006.Cedula, NOM006.Status, NOM007.Sexo, NOM007.Edo_Civil, NOM007.Fecha_Nacimiento,
               NOM007.Edad, NOM007.Lugar_Nacimiento, NOM007.Direccion, NOM007.Cod_Postal, NOM007.Telefono, NOM007.Correo, NOM007.Estado,
               NOM007.Ciudad, NOM007.Tlf_Movil, NOM007.Profesion, NOM007.Grado_Inst, NOM007.Tiempo_E, NOM007.Poliza, NOM007.Fecha_Seguro,
               NOM007.Municipio, NOM007.Parroquia, NOM007.Observacion, NOM007.Talla_Camisa, NOM007.Talla_Pantalon, NOM007.Talla_Calzado,
               NOM007.Peso, NOM007.Estatura, NOM007.Aptdo_Postal  FROM NOM006 NOM006, NOM007 NOM007
               WHERE NOM006.Cod_Empleado = NOM007.Cod_Empleado  AND
               NOM006.Cod_Empleado>='".$cedula_d."' AND NOM006.Cod_Empleado<='".$cedula_h."'  AND
               NOM007.Fecha_Nacimiento>='".$fecha_desde."' AND NOM007.Fecha_Nacimiento<='".$fecha_hasta."'  AND
               NOM007.Edad>='".$edad_d."' AND NOM007.Edad<='".$edad_h."'
               ORDER BY NOM006.Cedula";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_info_ele_me_mi_re.xml");
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
     elseif (($sexo!='TODOS') && ($edo_civil=='TODOS'))
     {
      $sSQL = "SELECT NOM006.Cod_Empleado, NOM006.Nombre, NOM006.Cedula, NOM006.Status, NOM007.Sexo, NOM007.Edo_Civil, NOM007.Fecha_Nacimiento,
               NOM007.Edad, NOM007.Lugar_Nacimiento, NOM007.Direccion, NOM007.Cod_Postal, NOM007.Telefono, NOM007.Correo, NOM007.Estado,
               NOM007.Ciudad, NOM007.Tlf_Movil, NOM007.Profesion, NOM007.Grado_Inst, NOM007.Tiempo_E, NOM007.Poliza, NOM007.Fecha_Seguro,
               NOM007.Municipio, NOM007.Parroquia, NOM007.Observacion, NOM007.Talla_Camisa, NOM007.Talla_Pantalon, NOM007.Talla_Calzado,
               NOM007.Peso, NOM007.Estatura, NOM007.Aptdo_Postal  FROM NOM006 NOM006, NOM007 NOM007
               WHERE NOM006.Cod_Empleado = NOM007.Cod_Empleado  AND
               NOM006.Cod_Empleado>='".$cedula_d."' AND NOM006.Cod_Empleado<='".$cedula_h."'  AND
               NOM007.Fecha_Nacimiento>='".$fecha_desde."' AND NOM007.Fecha_Nacimiento<='".$fecha_hasta."'  AND
               NOM007.Edad>='".$edad_d."' AND NOM007.Edad<='".$edad_h."' AND
               NOM007.Sexo ='".$sexo."'
               ORDER BY NOM006.Cod_Empleado";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_info_ele_me_mi_re.xml");
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
    elseif (($sexo=='TODOS') && ($edo_civil!='TODOS'))
    {
      $sSQL = "SELECT NOM006.Cod_Empleado, NOM006.Nombre, NOM006.Cedula, NOM006.Status, NOM007.Sexo, NOM007.Edo_Civil, NOM007.Fecha_Nacimiento,
               NOM007.Edad, NOM007.Lugar_Nacimiento, NOM007.Direccion, NOM007.Cod_Postal, NOM007.Telefono, NOM007.Correo, NOM007.Estado,
               NOM007.Ciudad, NOM007.Tlf_Movil, NOM007.Profesion, NOM007.Grado_Inst, NOM007.Tiempo_E, NOM007.Poliza, NOM007.Fecha_Seguro,
               NOM007.Municipio, NOM007.Parroquia, NOM007.Observacion, NOM007.Talla_Camisa, NOM007.Talla_Pantalon, NOM007.Talla_Calzado,
               NOM007.Peso, NOM007.Estatura, NOM007.Aptdo_Postal  FROM NOM006 NOM006, NOM007 NOM007
               WHERE NOM006.Cod_Empleado = NOM007.Cod_Empleado  AND
               NOM006.Cod_Empleado>='".$cedula_d."' AND NOM006.Cod_Empleado<='".$cedula_h."'  AND
               NOM007.Fecha_Nacimiento>='".$fecha_desde."' AND NOM007.Fecha_Nacimiento<='".$fecha_hasta."'  AND
               NOM007.Edad>='".$edad_d."' AND NOM007.Edad<='".$edad_h."'  AND
               NOM007.Edo_Civil='".$edo_civil."'
               ORDER BY NOM006.Cod_Empleado";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_info_ele_me_mi_re.xml");
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
     elseif (($sexo!='TODOS') && ($edo_civil!='TODOS'))
     {
      $sSQL = "SELECT NOM006.Cod_Empleado, NOM006.Nombre, NOM006.Cedula, NOM006.Status, NOM007.Sexo, NOM007.Edo_Civil, NOM007.Fecha_Nacimiento,
               NOM007.Edad, NOM007.Lugar_Nacimiento, NOM007.Direccion, NOM007.Cod_Postal, NOM007.Telefono, NOM007.Correo, NOM007.Estado,
               NOM007.Ciudad, NOM007.Tlf_Movil, NOM007.Profesion, NOM007.Grado_Inst, NOM007.Tiempo_E, NOM007.Poliza, NOM007.Fecha_Seguro,
               NOM007.Municipio, NOM007.Parroquia, NOM007.Observacion, NOM007.Talla_Camisa, NOM007.Talla_Pantalon, NOM007.Talla_Calzado,
               NOM007.Peso, NOM007.Estatura, NOM007.Aptdo_Postal  FROM NOM006 NOM006, NOM007 NOM007
               WHERE NOM006.Cod_Empleado = NOM007.Cod_Empleado  AND
               NOM006.Cod_Empleado>='".$cedula_d."' AND NOM006.Cod_Empleado<='".$cedula_h."'  AND
               NOM007.Fecha_Nacimiento>='".$fecha_desde."' AND NOM007.Fecha_Nacimiento<='".$fecha_hasta."'  AND
               NOM007.Edad>='".$edad_d."' AND NOM007.Edad<='".$edad_h."' AND
               NOM007.Sexo ='".$sexo."'  AND NOM007.Edo_Civil='".$edo_civil."'
               ORDER BY NOM006.Cod_Empleado";

          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_info_ele_me_mi_re.xml");
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
  }
?>
